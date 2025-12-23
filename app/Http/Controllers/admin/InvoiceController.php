<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['patient', 'doctor', 'services'])
            ->latest()
            ->paginate(10);
        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = \App\Models\Doctor::where('status', '1')->get();
        $patients = \App\Models\Patient::all();
        $services = \App\Models\Service::all();

        return view('admin.invoices.create',compact('doctors', 'patients','services') );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'invoice_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*.name' => 'required_with:services|string',
            'services.*.price' => 'required_with:services|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'user_id' => auth()->id(),
            'invoice_date' => $request->invoice_date,
            'status' => $request->status,
            'amount' => $request->amount,
            'notes' => $request->notes,
        ]);

        if ($request->has('services')) {
            foreach ($request->services as $service) {
                \App\Models\InvoiceService::create([
                    'invoice_id' => $invoice->id, // ✅  Make sure to set the invoice_id
                    'service_name' => $service['name'],
                    'price' => $service['price'],
                ]);
            }
        }

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice created successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

            $invoice = Invoice::with('services')->findOrFail($id);

            // منع حذف الفاتورة لو مدفوعة
            if ($invoice->status === 'unpaid') {
                return redirect()->route('admin.invoice.index')
                    ->with('error', 'Cannot delete   unpaid invoice.');
            }

            // حذف الخدمات المرتبطة بالفاتورة
            if ($invoice->services->isNotEmpty()) {
                $invoice->services()->delete();
            }

            // حذف الفاتورة نفسها
            $invoice->delete();

            return redirect()->route('admin.invoice.index')
                ->with('success', 'Invoice deleted successfully.');
    }
    /**
     * Print the specified resource.
     */
    public function printInvoice(Invoice $invoice)
    {
        return view('admin.invoices.print', compact('invoice'));    
    }
    /**
     * Toggle the status of the specified resource.
     */
        public function toggleStatus(Request $request, $id)
        {
            $invoice = Invoice::findOrFail($id);

            // نسمح بس بالقيم دي
            $allowed = ['paid', 'unpaid'];

            // لو المرسل في البودي قيمة، ناخدها، وإلا نعمل toggle
            $newStatus = $request->input('status') ?? ($invoice->status === 'paid' ? 'unpaid' : 'paid');
            $newStatus = strtolower($newStatus);

            if (!in_array($newStatus, $allowed)) {
                return response()->json(['success' => false, 'message' => 'Invalid Status '], 422);
            }

            $invoice->status = $newStatus;
            $invoice->save();

            $message = $newStatus === 'paid' 
                ? 'The invoice has been marked as Paid.' 
                : 'The invoice has been marked as Unpaid.';

            return response()->json([
                'success' => true,
                'status'  => $invoice->status,
                'message' => $message,
            ]);
        }
}
