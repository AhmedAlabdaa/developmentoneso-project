<style>
    .table-container {
        width: 100%;
        overflow-x: auto;
        position: relative;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th,
    .table td {
        padding: 10px 15px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #ddd;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .table th {
        background-color: #343a40;
        color: white;
        text-transform: uppercase;
        font-weight: bold;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    .btn-icon-only {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        border-radius: 50%;
        font-size: 12px;
        width: 30px;
        height: 30px;
        color: white;
    }
    .btn-info {
        background-color: #17a2b8;
    }
    .btn-warning {
        background-color: #ffc107;
    }
    .btn-danger {
        background-color: #dc3545;
    }
    .attachments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 20px;
        margin-top: 10px;
    }
    .attachment-item {
        text-align: center;
    }
    .attachment-item p {
        margin-top: 5px;
        font-size: 12px;
    }
    .img-thumbnail {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
    }
    .bg-gradient-primary {
        background: linear-gradient(to right, #007bff, #6a11cb);
    }
    .btn-sm {
        font-size: 0.8rem;
    }
    .table-warning {
        background-color: #fff3cd !important;
    }
    .appeal-blink {
        animation: blink-animation 1.5s infinite;
        font-weight: bold;
        color: #000;
    }
    @keyframes blink-animation {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    .pagination-controls {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
        align-items: center;
        gap: 20px;
    }
    .pagination-controls i {
        font-size: 12px;
        cursor: pointer;
        color: #343a40;
    }
    .pagination-controls i.disabled {
        color: #ccc;
        cursor: not-allowed;
    }
    .fullscreen-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1049;
    }
    .dropdown-container {
        display: none;
        position: fixed;
        z-index: 1050;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        min-width: 350px;
        max-width: 450px;
        text-align: center;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border: 4px solid #007bff;
        animation: fadeIn 0.3s ease-in-out;
    }
    .dropdown-header {
        margin-bottom: 15px;
    }
    .dropdown-header .header-icon {
        font-size: 24px;
        color: #007bff;
        margin-bottom: 10px;
    }
    .dropdown-header p {
        font-size: 12px;
        font-weight: bold;
        color: #333;
        margin: 5px 0;
        line-height: 1.5;
    }
    .candidate-name {
        color: #007bff;
        font-weight: bold;
        font-size: 12px;
    }
    .status-dropdown {
        width: 100%;
        margin-top: 10px;
        font-size: 12px;
        border: 2px solid #007bff;
        border-radius: 6px;
        outline: none;
        background-color: #fff;
        color: #333;
    }
    .close-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        color: #ff6347;
        cursor: pointer;
        transition: color 0.3s ease;
    }
    .close-icon:hover {
        color: #ff4500;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translate(-50%, -55%);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }
    .dropdown-container .fa-times {
        cursor: pointer;
        margin-left: 10px;
        color: #888;
        font-size: 12px;
    }
    .pagination-controls {
        margin-top: 10px;
        display: flex;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }
    .icon-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #f0f0f0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.3s ease;
        cursor: pointer;
    }
    .icon-wrapper i {
        font-size: 12px;
        color: #555;
    }
    .icon-wrapper:hover {
        background-color: #007BFF;
        transform: scale(1.1);
    }
    .icon-wrapper:hover i {
        color: #fff;
    }
    .icon-wrapper .disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }
    .icon-wrapper .disabled:hover {
        transform: none;
        background-color: #f0f0f0;
    }
    .office-modal .modal-header {
        background: linear-gradient(135deg, #007bff, #6a11cb);
        color: #fff;
    }
    .office-modal .modal-header h5 {
        margin: 0;
        font-weight: 600;
    }
    .office-modal label {
        font-weight: 500;
        margin-bottom: 3px;
    }
    .office-modal .form-control,
    .office-modal .form-select {
        font-size: 14px;
    }
</style>
<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Reference #</th>
                <th>Created At</th>
                <th>Selected From</th>
                <th>Visa Stage</th>
                <th>Name</th>
                <th>Passport No</th>
                <th>Package</th>
                <th>Nationality</th>
                <th>Passport Expiry Date</th>
                <th>Date of Joining</th>
                <th>Visa Designation</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Contract Start Date</th>
                <th>Contract End Date</th>
                <th>Contract Type</th>
                <th>Salary as per Contract</th>
                <th>Basic Salary</th>
                <th>Housing Allowance</th>
                <th>Transport Allowance</th>
                <th>Other Allowances</th>
                <th>Total Salary</th>
                <th>Payment Type</th>
                <th>Bank Name</th>
                <th>IBAN</th>
                <th>Remarks</th>
                <th>Comments</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($employees->isEmpty())
                <tr>
                    <td colspan="26" class="text-center">No results found.</td>
                </tr>
            @else
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->reference_no }}</td>
                        <td>{{ \Carbon\Carbon::parse($employee->updated_at)->format('d M Y h:i A') }}</td>
                        <td>
                            @if($employee->visa_status == 0)
                                <button class="btn btn-secondary btn-sm">
                                    <i class="fas fa-clock"></i> Not started
                                </button>
                            @else
                                @php
                                    $visaStatusName = '';
                                    $visaStatusIcon = '';

                                    $visaStatuses = [
                                        1  => ['name' => 'Visit 1',    'icon' => 'fa-plane'],
                                        2  => ['name' => 'Visit 2',    'icon' => 'fa-plane-departure'],
                                        3  => ['name' => 'DIN',        'icon' => 'fa-file-medical'],
                                        4  => ['name' => 'EPV',        'icon' => 'fa-passport'],
                                        5  => ['name' => 'CS',         'icon' => 'fa-user-shield'],
                                        6  => ['name' => 'Medical',    'icon' => 'fa-heartbeat'],
                                        7  => ['name' => 'TWJ',        'icon' => 'fa-calendar-alt'],
                                        8  => ['name' => 'EID',        'icon' => 'fa-id-card'],
                                        9  => ['name' => 'RVS',        'icon' => 'fa-stamp'],
                                        10 => ['name' => 'Visit 3',    'icon' => 'fa-plane-arrival'],
                                        11 => ['name' => 'ILOE',       'icon' => 'fa-briefcase'],
                                        12 => ['name' => 'SD',         'icon' => 'fa-money-bill'],
                                        13 => ['name' => 'VC',         'icon' => 'fa-times'],
                                        14 => ['name' => 'Completed',  'icon' => 'fa-check-circle'],
                                        15 => ['name' => 'Arrived',    'icon' => 'fa-plane-arrival'],
                                    ];

                                    $visaStatusId = (int) ($employee->visa_status ?? 0);
                                    $visaStatus = $visaStatuses[$visaStatusId] ?? ['name' => 'Unknown', 'icon' => 'fa-question-circle'];

                                    $visaStatusName = $visaStatus['name'];
                                    $visaStatusIcon = $visaStatus['icon'];
                                @endphp
                                <button class="btn btn-info btn-sm">
                                    <i class="fas {{ $visaStatusIcon }}"></i> {{ $visaStatusName }}
                                </button>
                            @endif
                        </td>
                        <td></td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->passport_no }}</td>
                        <td>{{ $employee->package }}</td>
                        <td>{{ $employee->nationality }}</td>
                        <td>
                            @if($employee->passport_expiry_date)
                                {{ \Carbon\Carbon::parse($employee->passport_expiry_date)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($employee->date_of_joining)
                                {{ \Carbon\Carbon::parse($employee->date_of_joining)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $employee->visa_designation }}</td>
                        <td>
                            @if($employee->date_of_birth)
                                {{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $employee->gender }}</td>
                        <td>
                            @if($employee->employment_contract_start_date)
                                {{ \Carbon\Carbon::parse($employee->employment_contract_start_date)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($employee->employment_contract_end_date)
                                {{ \Carbon\Carbon::parse($employee->employment_contract_end_date)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $employee->contract_type }}</td>
                        <td>{{ $employee->salary_as_per_contract }}</td>
                        <td>{{ $employee->basic }}</td>
                        <td>{{ $employee->housing }}</td>
                        <td>{{ $employee->transport }}</td>
                        <td>{{ $employee->other_allowances }}</td>
                        <td>{{ $employee->total_salary }}</td>
                        <td>{{ $employee->payment_type }}</td>
                        <td>{{ $employee->bank_name }}</td>
                        <td>{{ $employee->iban }}</td>
                        <td>{{ $employee->remarks }}</td>
                        <td>{{ $employee->comments }}</td>
                        <td>
                            <a href="{{ route('employees.show', $employee->reference_no) }}" class="btn btn-primary btn-icon-only" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('employees.edit', $employee->reference_no) }}" class="btn btn-primary btn-icon-only" title="Edit">
                                <i class="fas fa-pencil"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-primary btn-icon-only"
                               title="Change Status"
                               onclick="openDropdown('{{ $employee->id }}', this, '{{ $employee->name }}')">
                                <i class="fas fa-train"></i>
                            </a>
                            <div class="fullscreen-overlay" id="fullscreenOverlay" onclick="closeAllDropdowns()"></div>
                            <div class="dropdown-container" id="dropdownContainer-{{ $employee->id }}" style="display: none;">
                                <div class="close-icon" onclick="closeAllDropdowns()">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="dropdown-header">
                                    <div class="header-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <p>Do you want to change the status of</p>
                                    <p>employee <span id="candidateName-{{ $employee->id }}" class="candidate-name"></span>?</p>
                                </div>
                                <select class="form-control status-dropdown" id="statusDropdown-{{ $employee->id }}"
                                        name="current_status"
                                        onchange="confirmStatusChange(this, '{{ $employee->id }}', '{{ $employee->name }}')">
                                    @php
                                        $allowedStatuses = [
                                            0 => 'Change Status',
                                            1 => 'Office',
                                            3 => 'Incident',
                                        ];
                                    @endphp
                                    @foreach ($allowedStatuses as $statusId => $statusName)
                                        <option value="{{ $statusId }}" {{ $employee->_status == $statusId ? 'selected' : '' }}>
                                            {{ $statusName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if (Auth::user()->role === 'Admin')
                                <form action="{{ route('employees.destroy', $employee->reference_no) }}"
                                      method="POST" style="display:inline;"
                                      id="delete-form-{{ $employee->reference_no }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-danger btn-icon-only"
                                            onclick="confirmDelete('{{ $employee->reference_no }}')"
                                            title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th>Reference #</th>
                <th>Created At</th>
                <th>Selected From</th>
                <th>Visa Stage</th>
                <th>Name</th>
                <th>Passport No</th>
                <th>Package</th>
                <th>Nationality</th>
                <th>Passport Expiry Date</th>
                <th>Date of Joining</th>
                <th>Visa Designation</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Contract Start Date</th>
                <th>Contract End Date</th>
                <th>Contract Type</th>
                <th>Salary as per Contract</th>
                <th>Basic Salary</th>
                <th>Housing Allowance</th>
                <th>Transport Allowance</th>
                <th>Other Allowances</th>
                <th>Total Salary</th>
                <th>Payment Type</th>
                <th>Bank Name</th>
                <th>IBAN</th>
                <th>Remarks</th>
                <th>Comments</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} results
        </span>
        <ul class="pagination justify-content-center">
            {{ $employees->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>
<div class="modal fade office-modal" id="officeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-building me-2"></i> Office Details</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close" onclick="$('#officeModal').modal('hide');"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-info-circle me-2"></i>Information</h6>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%;" class="bg-secondary text-white">
                                    <i class="fas fa-user"></i> Sales Name
                                </th>
                                <td id="office_sales_name"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">
                                    <i class="fas fa-handshake"></i> Partner
                                </th>
                                <td id="office_partner"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">
                                    <i class="fas fa-hashtag"></i> CN Number
                                </th>
                                <td id="office_cn_number"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">
                                    <i class="fas fa-hashtag"></i> CL Number
                                </th>
                                <td id="office_cl_number"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">
                                    <i class="fas fa-passport"></i> Visa Type
                                </th>
                                <td id="office_visa_type"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">
                                    <i class="fas fa-info-circle"></i> Visa Status
                                </th>
                                <td id="office_visa_status"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">
                                    <i class="fas fa-box-open"></i> Package
                                </th>
                                <td id="office_package_value"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">
                                    <i class="fas fa-plane-arrival"></i> Arrived Date
                                </th>
                                <td id="office_arrived_date"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">
                                    <i class="fas fa-exchange-alt"></i> Transferred Date
                                </th>
                                <td id="office_transferred_date"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-edit me-2"></i>Form</h6>
                    <form id="officeForm" enctype="multipart/form-data">
                        <input type="hidden" name="employee_id" id="employee_id" value="">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category">Category <span style="color: red;">*</span></label>
                                <select id="category" name="category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <option value="Unfit">Unfit</option>
                                    <option value="Sales Return">Sales Return</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="returned_date">Returned Date <span style="color: red;">*</span></label>
                                <input type="date" name="returned_date" id="returned_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="expiry_date">Expiry Date (ICA Proof) <span style="color: red;">*</span></label>
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="ica_proof_attachment">ICA Proof Attachment <span style="color: red;">*</span></label>
                                <input type="file" name="ica_proof_attachment" id="ica_proof_attachment" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="overstay_days">Overstay Days <span style="color: red;">*</span></label>
                                <input type="number" name="overstay_days" id="overstay_days" class="form-control" value="0" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fine_amount">Fine Amount <span style="color: red;">*</span></label>
                                <input type="number" name="fine_amount" id="fine_amount" class="form-control" value="0" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="passport_status" class="form-label">Passport Status <span style="color: red;">*</span></label>
                                <select id="passport_status" name="passport_status" class="form-select" required>
                                    <option value="">Select Passport Status</option>
                                    <option value="With Employer">With Employer</option>
                                    <option value="With Candidate">With Candidate</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Office">Office</option>
                                    <option value="Lost">Lost</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="$('#officeModal').modal('hide');">
                                <i class="fas fa-times me-1"></i> Close
                            </button>
                            <button type="button" id="saveOfficeBtn" class="btn btn-success" onclick="saveOfficeData()">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function openDropdown(candidateId, buttonElement, candidateName) {
        $('.dropdown-container').hide();
        $('#fullscreenOverlay').fadeIn();
        const dropdownContainer = $('#dropdownContainer-' + candidateId);
        dropdownContainer.find('.candidate-name').text(candidateName);
        dropdownContainer.css({ display: 'block', opacity: 0 });
        dropdownContainer.animate({ opacity: 1 }, 300);
    }

    function closeAllDropdowns() {
        $('.dropdown-container').fadeOut();
        $('#fullscreenOverlay').fadeOut();
    }

    function confirmStatusChange(selectElement, candidateId, candidateName) {
        if (selectElement.value == 1) {
            closeAllDropdowns();
            openOfficeModal(candidateId);
        }
    }

    function confirmDelete(referenceNo) {}

    function openOfficeModal(employeeId) {
        $('#office_sales_name').text('');
        $('#office_partner').text('');
        $('#office_cn_number').text('');
        $('#office_cl_number').text('');
        $('#office_visa_type').text('');
        $('#office_visa_status').text('');
        $('#office_package_value').text('');
        $('#office_arrived_date').text('');
        $('#office_transferred_date').text('');
        $('#employee_id').val(employeeId);
        $('#officeForm')[0].reset();
        $.ajax({
            url: "{{ route('employees.officeData', ':id') }}".replace(':id', employeeId),
            type: "GET",
            success: function(response) {
                $('#office_sales_name').text(response.sales_name ? response.sales_name.toUpperCase() : 'N/A');
                $('#office_partner').text(response.partner ? response.partner.toUpperCase() : 'N/A');
                $('#office_cn_number').text(response.cn_number ? response.cn_number.toUpperCase() : 'N/A');
                $('#office_cl_number').text(response.cl_number ? response.cl_number.toUpperCase() : 'N/A');
                $('#office_visa_type').text(response.visa_type ? response.visa_type.toUpperCase() : 'N/A');
                $('#office_visa_status').text(response.visa_status ? response.visa_status.toUpperCase() : 'N/A');
                $('#office_package_value').text(response.package ? response.package.toUpperCase() : 'N/A');
                $('#office_arrived_date').text(response.arrived_date ? response.arrived_date : 'N/A');
                $('#office_transferred_date').text(response.transferred_date ? response.transferred_date : 'N/A');
                $('#officeModal').modal('show');
            },
            error: function() {
                toastr.error('Failed to load office data. Please try again.');
            }
        });
    }

    function saveOfficeData() {
        $('#saveOfficeBtn').prop('disabled', true);
        var formData = new FormData(document.getElementById('officeForm'));
        formData.append('_token', "{{ csrf_token() }}");
        $.ajax({
            url: "{{ route('employees.officeSave') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success(response.message);
                setTimeout(function(){
                    location.reload();
                }, 2000);
            },
            error: function(xhr) {
                $('#saveOfficeBtn').prop('disabled', false);
                var errorMsg = 'Failed to save data. Please check your inputs and try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                toastr.error(errorMsg);
            }
        });
    }

</script>
