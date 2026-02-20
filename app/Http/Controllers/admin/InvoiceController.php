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
    public function index(Request $request)
    {
        // 1. Start the query with eager loading to prevent N+1 issues
        $query = Invoice::with(['patient', 'doctor.user', 'services']);
    
        // 2. Filter by Patient Name (Relationship search)
        if ($request->filled('search')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
    
        // 3. Filter by Status (Exact match: paid/unpaid)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        // 4. Filter by specific Invoice Date
        if ($request->filled('date')) {
            $query->whereDate('invoice_date', $request->date);
        }
    
        // 5. Paginate and append query strings to maintain filters on page links
        $invoices = $query->latest('invoice_date')->paginate(10);
    
        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = \App\Models\Doctor::get();
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

     public function toggleStatus(Invoice $invoice)
     {
         $invoice->status = $invoice->status === 'paid' ? 'unpaid' : 'paid';
         $invoice->save();
     
         return redirect()->back()->with('success', 'Invoice status updated successfully.');
     }
     
    //  trashed 
    public function trashed(Request $request)
    {
        $query = Invoice::onlyTrashed();
    
        // 1. Filter by Patient Name (Relationship search)
        if ($request->filled('search')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
    
        // 2. Filter by Status (Exact match: paid/unpaid)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        // 3. Filter by specific Invoice Date
        if ($request->filled('date')) {
            $query->whereDate('invoice_date', $request->date);
        }
    
        // 4. Paginate and append query strings to maintain filters on page links
        $invoices = $query->latest('invoice_date')->paginate(10);
    
        return view('admin.invoices.trashed', compact('invoices'));
    }


     public function restore(string $id)
     {
         $invoice = Invoice::withTrashed()->findOrFail($id);
         $invoice->restore();
     
         return redirect()->route('admin.invoice.index')
             ->with('success', 'Invoice restored successfully.');
     }
}
