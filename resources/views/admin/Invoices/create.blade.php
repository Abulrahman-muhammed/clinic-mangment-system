@extends('admin.master')

@section('title', 'Create Invoice')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="h5 page-title mb-3">Create Invoice</h2>

            <div class="card shadow">
                <div class="card-body">

                    <form action="{{ route('admin.invoice.store') }}" method="POST" id="invoiceForm">
                        @csrf

                        <!-- Select Patient & Doctor -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="patient_id">Select Patient</label>
                                <select name="patient_id" class="form-control" required>
                                    <option value="">-- Choose Patient --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="doctor_id">Select Doctor</label>
                                <select name="doctor_id" id="doctor_id" class="form-control" required>
                                    <option value="">-- Choose Doctor --</option>
                                    @foreach($doctors as $doctor)
                                        <option  value="{{ $doctor->id }}">{{$doctor->user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Department & Consultation Fee -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="department">Doctor Department</label>
                                <input type="text" id="department" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="consultation_fee">Consultation Fee (EGP)</label>
                                <input type="number" step="0.01" id="consultation_fee" name="consultation_fee" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="service_id">Select Additional Service</label>
                                <select id="service_id" class="form-control">
                                    <option value="">-- Choose Service --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" 
                                                data-name="{{ $service->name }}" 
                                                data-price="{{ $service->price }}">
                                            {{ $service->name }} ({{ $service->price }} EGP)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Selected Services Table -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <table class="table table-sm table-bordered text-center" id="servicesTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Service Name</th>
                                            <th>Price (EGP)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Total Amount -->
                        <div class="row">
                            <div class="col-md-6 offset-md-6 mb-3">
                                <label for="total_amount" class="fw-bold">Total Amount (EGP)</label>
                                <input type="number" step="0.01" name="amount" id="total_amount" class="form-control fw-bold" readonly>
                            </div>
                        </div>

                        <!-- Status & Date -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Payment Status</label>
                                <select name="status" class="form-control">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Invoice Date</label>
                                <input type="date" name="invoice_date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Enter any notes"></textarea>
                            </div>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Invoice
                        </button>
                        <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let consultationFee = 0;
let serviceIndex = 0;

// Fetch doctor info
document.getElementById('doctor_id').addEventListener('change', function () {
    const doctorId = this.value;

    if (!doctorId) {
        document.getElementById('department').value = '';
        document.getElementById('consultation_fee').value = '';
        updateTotal();
        return;
    }

    fetch(`/admin/doctors/${doctorId}/info`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('department').value = data.department_name ?? '';
            consultationFee = parseFloat(data.consultation_fee ?? 0);
            document.getElementById('consultation_fee').value = consultationFee.toFixed(2);
            updateTotal();
        })
        .catch(err => console.error('Error fetching doctor info:', err));
});

// Add service
document.getElementById('service_id').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const serviceName = selected.dataset.name;
    const servicePrice = parseFloat(selected.dataset.price || 0);

    if (!serviceName || servicePrice <= 0) return;

    const tbody = document.querySelector('#servicesTable tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${serviceName}<input type="hidden" name="services[${serviceIndex}][name]" value="${serviceName}"></td>
        <td>${servicePrice.toFixed(2)}<input type="hidden" name="services[${serviceIndex}][price]" value="${servicePrice}"></td>
        <td><button type="button" class="btn btn-sm btn-danger remove-service">Remove</button></td>
    `;
    tbody.appendChild(row);
    serviceIndex++;

    updateTotal();
    this.selectedIndex = 0;
});

// Remove service
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-service')) {
        e.target.closest('tr').remove();
        updateTotal();
    }
});

// Calculate total
function updateTotal() {
    let total = consultationFee;
    document.querySelectorAll('#servicesTable tbody tr').forEach(row => {
        const priceInput = row.querySelector('input[name*="[price]"]');
        total += parseFloat(priceInput.value || 0);
    });
    document.getElementById('total_amount').value = total.toFixed(2);
}
</script>
@endsection
