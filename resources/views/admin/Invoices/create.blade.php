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

                        {{-- Visit (optional - auto-fills patient & doctor) --}}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="visit_id">
                                    Link to Visit
                                    <small class="text-muted ml-1">(optional — auto-fills patient & doctor)</small>
                                </label>
                                <select name="visit_id" id="visit_id" class="form-control select2">
                                    <option value="">-- Choose Visit (optional) --</option>
                                    @foreach($visits as $visit)
                                        <option value="{{ $visit->id }}"
                                                data-patient="{{ $visit->patient_id }}"
                                                data-doctor="{{ $visit->doctor_id }}">
                                            #{{ $visit->id }} — {{ $visit->patient->name ?? 'N/A' }}
                                            &nbsp;·&nbsp; Dr. {{ $visit->doctor->user->name ?? 'N/A' }}
                                            &nbsp;·&nbsp; {{ $visit->created_at->format('d M Y') }}
                                            &nbsp;
                                            <span class="text-capitalize">[{{ ucfirst($visit->status) }}]</span>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="patient_id">Select Patient</label>
                                <select name="patient_id" id="patient_id" class="form-control select2" required>
                                    <option value="">-- Choose Patient --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="doctor_id">Select Doctor</label>
                                <select name="doctor_id" id="doctor_id" class="form-control select2" required>
                                    <option value="">-- Choose Doctor --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

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

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="service_id">Select Additional Service</label>
                                <select id="service_id" class="form-control select2">
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

                        <div class="row">
                            <div class="col-md-6 offset-md-6 mb-3">
                                <label for="total_amount" class="fw-bold">Total Amount (EGP)</label>
                                <input type="number" step="0.01" name="amount" id="total_amount" class="form-control fw-bold" readonly value="0.00">
                            </div>
                        </div>

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

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Enter any notes"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Invoice</button>
                        <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary ms-2">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let consultationFee = 0;
    let serviceIndex = 0;

    $('.select2').select2({ theme: 'bootstrap4', width: '100%' });

    // ─── Visit selector: auto-fill patient & doctor ───────────────────────────
    $('#visit_id').on('change', function () {
        const selected = $(this).find('option:selected');
        const patientId = selected.data('patient');
        const doctorId  = selected.data('doctor');

        if (!patientId && !doctorId) return;

        // Set patient dropdown
        if (patientId) {
            $('#patient_id').val(patientId).trigger('change');
        }

        // Set doctor dropdown and trigger info fetch
        if (doctorId) {
            $('#doctor_id').val(doctorId).trigger('change');
        }
    });

    // ─── Doctor info fetch ────────────────────────────────────────────────────
    $('#doctor_id').on('change', function () {
        const doctorId = $(this).val();
        if (!doctorId) {
            resetDoctorFields();
            return;
        }

        const url = "{{ route('admin.doctor.info', ':id') }}".replace(':id', doctorId);
        $.get(url, function(data) {
            $('#department').val(data.department_name);
            consultationFee = parseFloat(data.consultation_fee || 0);
            $('#consultation_fee').val(consultationFee.toFixed(2));
            updateTotal();
        }).fail(function() {
            console.error("Could not fetch doctor info");
        });
    });

    // ─── Add service to table ─────────────────────────────────────────────────
    $('#service_id').on('change', function () {
        const selected     = $(this).find('option:selected');
        const serviceName  = selected.data('name');
        const servicePrice = parseFloat(selected.data('price') || 0);

        if (!serviceName) return;

        const row = `
            <tr>
                <td>${serviceName}<input type="hidden" name="services[${serviceIndex}][name]" value="${serviceName}"></td>
                <td>${servicePrice.toFixed(2)}<input type="hidden" name="services[${serviceIndex}][price]" class="service-price" value="${servicePrice}"></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-service">Remove</button></td>
            </tr>`;

        $('#servicesTable tbody').append(row);
        serviceIndex++;
        updateTotal();

        $(this).val(null).trigger('change');
    });

    // ─── Remove service ───────────────────────────────────────────────────────
    $(document).on('click', '.remove-service', function() {
        $(this).closest('tr').remove();
        updateTotal();
    });

    // ─── Helpers ──────────────────────────────────────────────────────────────
    function updateTotal() {
        let total = consultationFee;
        $('.service-price').each(function() {
            total += parseFloat($(this).val() || 0);
        });
        $('#total_amount').val(total.toFixed(2));
    }

    function resetDoctorFields() {
        $('#department').val('');
        $('#consultation_fee').val('');
        consultationFee = 0;
        updateTotal();
    }
});
</script>
@endpush