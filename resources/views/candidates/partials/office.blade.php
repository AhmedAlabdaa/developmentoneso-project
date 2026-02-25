<style>
    .table-container { width: 100%; overflow-x: auto; position: relative; }
    .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .table th, .table td { padding: 10px 15px; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .table th { background-color: #343a40; color: white; text-transform: uppercase; font-weight: bold; }
    .table-hover tbody tr:hover { background-color: #f1f1f1; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
    .btn-icon-only { display: inline-flex; align-items: center; justify-content: center; padding: 5px; border-radius: 50%; font-size: 12px; width: 30px; height: 30px; color: white; }
    .btn-info { background-color: #17a2b8; }
    .btn-warning { background-color: #ffc107; }
    .btn-danger { background-color: #dc3545; }
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
</style>
<div class="table-container">
    <table class="table table-striped table-hover text-center">
        <thead>
            <tr>
                <th title="Agent Reference No">A . Ref #</th>
                <th title="Candidate #">Candidate #</th>
                <th title="Candidate Name">Candidate Name</th>
                <th title="In Office Date">In Office Date</th>
                <th title="Sales">Sales</th>
                <th title="Status Date">Status Date</th>
                <th title="Passport Status">Passport Status</th>
                <th title="Visa Issue Date">Visa Issue Date</th>
                <th title="Visa Expiry Date">Visa Expiry Date</th>
                <th title="Overstay Days">Overstay Days</th>
                <th title="Fine Amount">Fine Amount</th>
                <th title="Passport Number">Passport #</th>
                <th title="Nationality">Nationality</th>
                <th title="Partners">Partners</th>
                <th title="Age">Age</th>
                <th title="Experience">Experience</th>
                <th title="Work Skill">Work Skill</th>
                <th title="Applied Position">Applied Position</th>
                <th title="Religion">Religion</th>
                <th title="Marital Status">Marital Status</th>
                <th title="Number of Children">Children</th>
                <th title="Education Level">Education Level</th>
                <th title="Phone Number">Phone Number</th>
                <th title="Family Contact #">Family Contact #</th>
                <th title="Passport Expiry Date">Passport Exp</th>
                <th title="Date of Birth">DOB</th>
                <th title="Gender">Gender</th>
                <th title="English Skills">English Skills</th>
                <th title="Arabic Skills">Arabic Skills</th>
                <th title="Height">Height</th>
                <th title="Weight">Weight</th>
                <th title="Preferred Package">Preferred Package</th>
                <th title="Place of Birth">Place of Birth</th>
                <th title="Candidate Current Address">Current Address</th>
                <th title="Labour ID Date">Labour ID Date</th>
                <th title="Labour ID Number">Labour ID #</th>
                <th title="Family Name">Family Name</th>
                <th title="Family Contact Number 1">Family Contact #1</th>
                <th title="Family Contact Number 2">Family Contact #2</th>
                <th title="Relationship with Candidate">Relationship</th>
                <th title="Family Current Address">Family Address</th>
                <th title="Passport Status">Passport Status</th>
                <th title="Visa Issue Date">Visa Issue Date</th>
                <th title="Visa Expiry Date">Visa Expiry Date</th>
                <th title="Overstay Days">Overstay Days</th>
                <th title="Fine Amount">Fine Amount</th>
                <th title="Action">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($candidates->isEmpty())
                <tr>
                    <td colspan="50" class="text-center no-records">
                        No results found.
                    </td>
                </tr>
            @else
                @foreach ($candidates as $candidate)
                    <tr class="{{ $candidate->appeal == 1 ? 'table-warning appeal-row' : '' }}">
                        <td><a style="color: #007bff !important;" href="{{ route('candidates.show', $candidate->reference_no) }}" target="_blank" class="text-decoration-none text-dark">{{ strtoupper($candidate->ref_no) }}</a></td>
                        <td><a style="color: #007bff !important;" href="{{ route('candidates.show', $candidate->reference_no) }}" target="_blank" class="text-decoration-none text-dark">{{ strtoupper($candidate->CN_Number) }}</a></td>
                        <td>
                            <a style="color: #007bff !important;" href="{{ route('candidates.show', $candidate->reference_no) }}" target="_blank" class="text-decoration-none text-dark">
                                {{ $candidate->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->candidate_name))) : 'N/A' }}
                            </a>
                            <i class="bi bi-box-arrow-in-up-right" onclick="showCandidateModal('{{ $candidate->candidate_name }}', '{{ $candidate->id }}', '{{ $candidate->reference_no }}')"></i>
                        </td>
                        <td><button class="btn btn-danger">{{ \Carbon\Carbon::parse($candidate->arrived_in_office_date)->format('d M Y') }}</button></td>
                        <td>{{ strtoupper(optional($candidate->sales)->first_name . ' ' . optional($candidate->sales)->last_name) ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($candidate->updated_at)->format('d M Y, h:i A') }}</td>
                        <td>{{ strtoupper($candidate->passport_status) ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($candidate->visa_issue_date)->format('d M Y') ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($candidate->visa_expiry_date)->format('d M Y') ?? 'N/A' }}</td>
                        <td>{{ $candidate->overstay_days ?? 0 }}</td>
                        <td>{{ $candidate->fine_amount ?? 0 }} QR</td>
                        <td>{{ strtoupper($candidate->passport_no) ?? 'N/A' }}</td>
                        <td>{{ strtoupper(optional($candidate->Nationality)->name) ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->foreign_partner) ?? 'N/A' }}</td>
                        <td>{{ $candidate->age ?? 'N/A' }}</td>
                        <td>{{ $candidate->CandidatesExperience->count() > 0 ? $candidate->CandidatesExperience->sum('experience_years') : 'N/A' }}</td>
                        <td>{{ $candidate->work_skills->count() > 0 ? 'Available' : 'No skills' }}</td>
                        <td>{{ strtoupper(optional($candidate->appliedPosition)->position_name) ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->religion) ?? 'N/A' }}</td>
                        <td>{{ strtoupper(optional($candidate->maritalStatus)->status_name) ?? 'N/A' }}</td>
                        <td>{{ $candidate->number_of_children ?? 0 }}</td>
                        <td>{{ strtoupper(optional($candidate->educationLevel)->level_name) ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->phone_number) ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->family_contact_number_1) ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($candidate->passport_expiry_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($candidate->date_of_birth)->format('d M Y') }}</td>
                        <td>{{ strtoupper($candidate->gender) ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->english_skills) ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->arabic_skills) ?? 'N/A' }}</td>
                        <td>{{ $candidate->height ?? 'N/A' }} CM</td>
                        <td>{{ $candidate->weight ?? 'N/A' }} KG</td>
                        <td>{{ strtoupper($candidate->preferred_package) ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->place_of_birth) ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->candidate_current_address) ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($candidate->labour_id_date)->format('d M Y') }}</td>
                        <td>{{ $candidate->labour_id_number ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->family_name) ?? 'N/A' }}</td>
                        <td>{{ $candidate->family_contact_number_1 ?? 'N/A' }}</td>
                        <td>{{ $candidate->family_contact_number_2 ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->relationship_with_candidate) ?? 'N/A' }}</td>
                        <td>{{ strtoupper($candidate->family_current_address) ?? 'N/A' }}</td>
                        <td class="actions">
                            <a href="javascript:void(0);" class="btn btn-primary btn-icon-only" title="Change Status" onclick="openDropdown('{{ $candidate->id }}', this, '{{ $candidate->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->candidate_name))) : 'N/A' }}')">
                                <i class="fas fa-train"></i>
                            </a>
                            <div class="fullscreen-overlay" id="fullscreenOverlay" onclick="closeAllDropdowns()"></div>
                            <div class="dropdown-container" id="dropdownContainer-{{ $candidate->id }}" style="display: none;">
                                <div class="close-icon" onclick="closeAllDropdowns()">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="dropdown-header">
                                    <div class="header-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <p>Do you want to change the status of</p>
                                    <p>candidate <span id="candidateName-{{ $candidate->id }}" class="candidate-name"></span>?</p>
                                </div>
                                <select class="form-control status-dropdown" id="statusDropdown-{{ $candidate->id }}" name="current_status" onchange="confirmStatusChange(this, '{{ $candidate->id }}', '{{ $candidate->candidate_name}}')">
                                    @php
                                        $allowedStatuses = [
                                            0 => 'Change Status',
                                            2 => 'Trial',
                                        ];
                                    @endphp
                                    @foreach ($allowedStatuses as $statusId => $statusName)
                                        <option value="{{ $statusId }}" {{ $candidate->_status == $statusId ? 'selected' : '' }}>
                                            {{ $statusName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if (Auth::user()->role === 'Admin')
                                <form action="{{ route('candidates.destroy', $candidate->reference_no) }}" method="POST" style="display:inline;" id="delete-form-{{ $candidate->reference_no }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-icon-only" onclick="confirmDelete('{{ $candidate->reference_no }}')" title="Delete">
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
                <th title="Agent Reference No">A . Ref #</th>
                <th title="Candidate #">Candidate #</th>
                <th title="Candidate Name">Candidate Name</th>
                <th title="In Office Date">In Office Date</th>
                <th title="Sales">Sales</th>
                <th title="Status Date">Status Date</th>
                <th title="Passport Status">Passport Status</th>
                <th title="Visa Issue Date">Visa Issue Date</th>
                <th title="Visa Expiry Date">Visa Expiry Date</th>
                <th title="Overstay Days">Overstay Days</th>
                <th title="Fine Amount">Fine Amount</th>
                <th title="Passport Number">Passport #</th>
                <th title="Nationality">Nationality</th>
                <th title="Partners">Partners</th>
                <th title="Age">Age</th>
                <th title="Experience">Experience</th>
                <th title="Work Skill">Work Skill</th>
                <th title="Applied Position">Applied Position</th>
                <th title="Religion">Religion</th>
                <th title="Marital Status">Marital Status</th>
                <th title="Number of Children">Children</th>
                <th title="Education Level">Education Level</th>
                <th title="Phone Number">Phone Number</th>
                <th title="Family Contact #">Family Contact #</th>
                <th title="Passport Expiry Date">Passport Exp</th>
                <th title="Date of Birth">DOB</th>
                <th title="Gender">Gender</th>
                <th title="English Skills">English Skills</th>
                <th title="Arabic Skills">Arabic Skills</th>
                <th title="Height">Height</th>
                <th title="Weight">Weight</th>
                <th title="Preferred Package">Preferred Package</th>
                <th title="Place of Birth">Place of Birth</th>
                <th title="Candidate Current Address">Current Address</th>
                <th title="Labour ID Date">Labour ID Date</th>
                <th title="Labour ID Number">Labour ID #</th>
                <th title="Family Name">Family Name</th>
                <th title="Family Contact Number 1">Family Contact #1</th>
                <th title="Family Contact Number 2">Family Contact #2</th>
                <th title="Relationship with Candidate">Relationship</th>
                <th title="Family Current Address">Family Address</th>
                <th title="Passport Status">Passport Status</th>
                <th title="Visa Issue Date">Visa Issue Date</th>
                <th title="Visa Expiry Date">Visa Expiry Date</th>
                <th title="Overstay Days">Overstay Days</th>
                <th title="Fine Amount">Fine Amount</th>
                <th title="Action">Action</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing {{ $candidates->firstItem() }} to {{ $candidates->lastItem() }} of {{ $candidates->total() }} results
        </span>
        <ul class="pagination justify-content-center">
            {{ $candidates->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>
<script>
    function openDropdown(candidateId, buttonElement, candidateName) {
        $('.dropdown-container').hide();
        $('#fullscreenOverlay').fadeIn();
        const dropdownContainer = $(`#dropdownContainer-${candidateId}`);
        dropdownContainer.find('.candidate-name').text(candidateName);
        dropdownContainer.css({
            display: 'block',
            opacity: 0,
        });
        dropdownContainer.animate({ opacity: 1 }, 300);
    }
    function closeAllDropdowns() {
        $('.dropdown-container').fadeOut();
        $('#fullscreenOverlay').fadeOut();
    }

    $('#paymentProof').on('change', function() {
        const allowedExtensions = ['png', 'jpeg', 'jpg', 'pdf'];
        const file = $(this).val().split('.').pop().toLowerCase();
        const totalAmount = parseFloat($('#totalAmount').val()) || 0;
        const receivedAmount = parseFloat($('#receivedAmount').val()) || 0;
        if (!totalAmount || !receivedAmount) {
            toastr.error('Fill Total Amount and Received Amount before uploading proof.');
            $(this).val('');
            $('#agreementSection').hide();
            return;
        }
        if (allowedExtensions.includes(file)) {
            $('#agreementSection').show();
        } else {
            toastr.error('Only PNG, JPEG, JPG, and PDF files are allowed.');
            $(this).val('');
            $('#agreementSection').hide();
        }
    });
    $('#totalAmount, #receivedAmount').on('input', function() {
        const totalAmount = parseFloat($('#totalAmount').val()) || 0;
        const receivedAmount = parseFloat($('#receivedAmount').val()) || 0;
        const remainingAmount = totalAmount - receivedAmount;
        if (remainingAmount < 0) {
            toastr.error('Received amount cannot exceed the total amount.');
            $('#receivedAmount').val('');
            $('#remainingAmount').val('');
            $('#vatAmount').val('');
            $('#netAmount').val('');
            return;
        }
        $('#remainingAmount').val(remainingAmount);
        const vatAmount = totalAmount * 0.05;
        const netAmount = totalAmount + vatAmount;
        $('#vatAmount').val(vatAmount.toFixed(2));
        $('#netAmount').val(netAmount.toFixed(2));
    });
    $('#agreedSalary').on('input keydown', function (e) {
        const key = e.key;
        const value = $(this).val();
        if (!/^[0-9.]$/.test(key) && e.keyCode !== 8 && e.keyCode !== 46) {
            e.preventDefault();
        }
        if (key === '.' && value.includes('.')) {
            e.preventDefault();
        }
    });
    $('#agreedSalary').on('blur', function () {
        const agreedSalary = parseFloat($(this).val());
        if (isNaN(agreedSalary) || agreedSalary < 1200) {
            toastr.error('The agreed salary must be at least 1200.');
            $(this).val('');
            $(this).focus();
        }
    });
    function confirmStatusChange(selectElement, candidateId, candidateFullName) {
        const selectedStatus = selectElement.options[selectElement.selectedIndex].text;
        Swal.fire({
            title: `Change status for ${candidateFullName}?`,
            text: `Do you want to change the status to "${selectedStatus}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, change it',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(selectElement, candidateId);
            } else {
                const previousStatus = [...selectElement.options].find(option => option.defaultSelected);
                if (previousStatus) {
                    selectElement.value = previousStatus.value;
                }
            }
        });
    }
    function updateStatus(selectElement, candidateId) {
        const statusId = selectElement.value;
        const csrfToken = '{{ csrf_token() }}'; 
        const updateStatusUrl = "{{ route('candidates.update-status-inside', ['candidate' => ':reference_no']) }}".replace(':reference_no', candidateId);
        $.ajax({
            url: updateStatusUrl,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: { status_id: statusId },
            success: function (response) {
                if (response.success) {
                    if (response.action === 'open_modal' && response.modal) {
                        const modalId = `#${response.modal}`;
                        $(modalId).modal('show');
                        populateModalFields(modalId, response.candidateDetails , response.clients);
                        if (response.clients) {
                            const clientDropdown = $(`${modalId} #clientDropdown`);
                            populateDropdown(clientDropdown, response.clients, 'id', 'first_name');
                        }
                        if (response.modal === 'ConfirmedModal') {
                            handleInvoices(response.candidate_details.invoices, response.candidate_details.remainingAmountWithVat);
                        }
                    } else {
                        toastr.success(response.message || 'Status has been updated successfully!');
                    }
                    if (response.statusColor) {
                        $(selectElement).css('background-color', response.statusColor);
                    }
                } else {
                    toastr.error(response.message || 'Failed to update status. Please try again.');
                }
            },
            error: function () {
                toastr.error('An error occurred. Please try again.');
            }
        });
    }
    function populateModalFields(modalId, candidateDetails, clients) {
        const setTextOrNA = (selector, value) => {
            $(`${modalId} ${selector}`).text(value || 'N/A');
        };
        setTextOrNA('#candidateRef', candidateDetails.referenceNo);
        setTextOrNA('#fullName', candidateDetails.candidateName);
        setTextOrNA('#agreementNo', candidateDetails.agreement);
        setTextOrNA('#passportNo', candidateDetails.passportNo);
        setTextOrNA('#nationality', candidateDetails.nationality);
        setTextOrNA('#employerName', candidateDetails.employerName);
        setTextOrNA('#agentName', candidateDetails.foreignPartner);
        setTextOrNA('#agentRef', candidateDetails.ref_no);
        $("#candidate_id").val(candidateDetails.candidateId);
        $("#arrived_in_office_date").val(candidateDetails.arrived_date);
        $('#TrialModalcandidateName').val(candidateDetails.candidateName);
        $('#TrialModalcandidateId').val(candidateDetails.candidateId);
        $('#TrialModalreferenceNo').val(candidateDetails.referenceNo);
        $('#TrialModalrefNo').val(candidateDetails.ref_no);
        $('#TrialModalforeignPartner').val(candidateDetails.foreignPartner);
        $('#TrialModalcandiateNationality').val(candidateDetails.nationality);
        $('#TrialModalcandidatePassportNumber').val(candidateDetails.passportNo);
        $('#TrialModalcandidatePassportExpiry').val(candidateDetails.passportExpiry);
        $('#TrialModalcandidateDOB').val(candidateDetails.candidateDOB);                                 
        $(`${modalId} #remainingAmount`).text(
            candidateDetails.remainingAmountWithVat
                ? candidateDetails.remainingAmountWithVat.toFixed(2)
                : '0.00'
        );
        const invoiceTable = $(`${modalId} #invoiceTableBody`);
        invoiceTable.empty();
        if (candidateDetails.invoices && candidateDetails.invoices.length > 0) {
            candidateDetails.invoices.forEach(invoice => {
                invoiceTable.append(`
                    <tr>
                        <td>${invoice.invoice_no || 'N/A'}</td>
                        <td>${invoice.total_amount || 'N/A'}</td>
                        <td>${invoice.received_amount || 'N/A'}</td>
                        <td>${invoice.status || 'N/A'}</td>
                    </tr>
                `);
            });
        } else {
            invoiceTable.append('<tr><td colspan="4">No invoices available</td></tr>');
        }
    }
    $(document).ready(function () {
        $('#saveDetailsBtn').on('click', function (event) {
            event.preventDefault();
            let isValid = true;
            $('#updateDetailsForm [required], #updateDetailsForm [data-required="true"]').each(function () {
                const value = $(this).val();
                if (!value || value.trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            if (!isValid) {
                toastr.error('Please fill out all required fields.');
                return;
            }
            const formData = new FormData();
            $('#updateDetailsForm [required], #updateDetailsForm [data-required="true"]').each(function () {
                const fieldId = $(this).attr('id');
                formData.append(fieldId, $(this).val());
            });
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('candidates.updateCandidateDetails')}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        toastr.success('Details updated successfully!');
                        $('#OfficeModal').modal('hide');
                    } else {
                        toastr.error('Failed to update details: ' + response.message);
                    }
                },
                error: function () {
                    toastr.error('An error occurred while updating details.');
                }
            });
        });
    });
    allowOnlyNumbers('#totalAmount');
    allowOnlyNumbers('#receivedAmount');
    allowOnlyNumbers('#remainingAmount');
    function allowOnlyNumbers(selector) {
        $(selector).on('input', function() {
            const sanitizedValue = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(sanitizedValue);
        });
    }
    $('#paymentProof').on('change', function() {
        const allowedExtensions = ['png', 'jpeg', 'jpg', 'pdf'];
        const file = $(this).val().split('.').pop().toLowerCase();
        const totalAmount = parseFloat($('#totalAmount').val()) || 0;
        const receivedAmount = parseFloat($('#receivedAmount').val()) || 0;
        if (!totalAmount || !receivedAmount) {
            toastr.error('Fill Total Amount and Received Amount before uploading proof.');
            $(this).val('');
            $('#agreementSection').hide();
            return;
        }
        if (allowedExtensions.includes(file)) {
            $('#agreementSection').show();
        } else {
            toastr.error('Only PNG, JPEG, JPG, and PDF files are allowed.');
            $(this).val('');
            $('#agreementSection').hide();
        }
    });
    $('#totalAmount, #receivedAmount').on('input', function() {
        const totalAmount = parseFloat($('#totalAmount').val()) || 0;
        const receivedAmount = parseFloat($('#receivedAmount').val()) || 0;
        const remainingAmount = totalAmount - receivedAmount;
        if (remainingAmount < 0) {
            toastr.error('Received amount cannot exceed the total amount.');
            $('#receivedAmount').val('');
            $('#remainingAmount').val('');
            $('#vatAmount').val('');
            $('#netAmount').val('');
            return;
        }
        $('#remainingAmount').val(remainingAmount);
        const vatAmount = totalAmount * 0.05;
        const netAmount = totalAmount + vatAmount;
        $('#vatAmount').val(vatAmount.toFixed(2));
        $('#netAmount').val(netAmount.toFixed(2));
    });
    function validateAgreementForm() {
        const packageSelected = $('#packageDropdown').val();
        const candidateName = $('#TrialModalcandidateName').val();
        const clientSelected = $('#clientDropdown').val();
        const totalAmount = parseFloat($('#totalAmount').val());
        const receivedAmount = parseFloat($('#receivedAmount').val());
        const remainingAmount = $('#remainingAmount').val();
        const paymentMethod = $('#paymentMethod').val();
        const paymentProof = $('#paymentProof').val();
        const agreedSalary = $('#agreedSalary').val();
        const visaType = $('#VisaType').val();
        const TrialStartDate = $('#TrialStartDate').val();
        const TrialEndDate = $('#TrialEndDate').val();
        const NumberOfDays = $('#NumberOfDays').val();
        if (!packageSelected) {
            toastr.error('Please select a package.');
            $('#packageDropdown').focus();
            return false;
        }
        if (!candidateName) {
            toastr.error('Candidate name is required.');
            $('#TrialModalcandidateName').focus();
            return false;
        }
        if (!totalAmount || isNaN(totalAmount) || totalAmount <= 0) {
            toastr.error('Please enter a valid total amount.');
            $('#totalAmount').focus();
            return false;
        }
        if (!receivedAmount || isNaN(receivedAmount) || receivedAmount <= 0) {
            toastr.error('Please enter a valid received amount.');
            $('#receivedAmount').focus();
            return false;
        }
        if (!remainingAmount || isNaN(remainingAmount)) {
            toastr.error('Remaining amount must be calculated.');
            $('#remainingAmount').focus();
            return false;
        }
        if (!paymentMethod) {
            toastr.error('Please select a payment method.');
            $('#paymentMethod').focus();
            return false;
        }
        if (!paymentProof) {
            toastr.error('Please upload payment proof.');
            $('#paymentProof').focus();
            return false;
        }
        if (!agreedSalary || isNaN(agreedSalary) || agreedSalary <= 0) {
            toastr.error('Please enter a valid salary amount.');
            $('#agreedSalary').focus();
            return false;
        }
        if (!visaType) {
            toastr.error('Please select a visa type.');
            $('#VisaType').focus();
            return false;
        }
        if (!NumberOfDays) {
            toastr.error('Please select number of days.');
            $('#NumberOfDays').focus();
            return false;
        }
        return true;
    }
    $('#saveChanges').on('click', function(e) {
        e.preventDefault();
        if (!validateAgreementForm()) {
            return;
        }
        const formData = new FormData();
        formData.append('candidate_id', $('#TrialModalcandidateId').val());
        formData.append('candidate_name', $('#TrialModalcandidateName').val());
        formData.append('reference_of_candidate', $('#TrialModalreferenceNo').val());
        formData.append('ref_no_in_of_previous', $('#TrialModalrefNo').val());
        formData.append('package', $('#packageDropdown').val());
        formData.append('client_id', $('#clientDropdown').val());
        formData.append('payment_method', $('#paymentMethod').val());
        formData.append('total_amount', $('#totalAmount').val());
        formData.append('received_amount', $('#receivedAmount').val());
        formData.append('remaining_amount', $('#remainingAmount').val());
        formData.append('vat_amount', $('#vatAmount').val());
        formData.append('net_amount', $('#netAmount').val());
        formData.append('notes', $('#paymentNotes').val());
        formData.append('agreement_type', $('#agreementType').val());
        formData.append('salary', $('#agreedSalary').val());
        formData.append('foreign_partner', $('#TrialModalforeignPartner').val());
        formData.append('nationality', $('#TrialModalcandiateNationality').val());
        formData.append('passport_no', $('#TrialModalcandidatePassportNumber').val());
        formData.append('trial_start_date', $('#TrialStartDate').val());
        formData.append('trial_end_date', $('#TrialEndDate').val());
        formData.append('number_of_days', $('#NumberOfDays').val());
        formData.append('passport_expiry_date', $('#TrialModalcandidatePassportExpiry').val());
        formData.append('date_of_birth', $('#TrialModalcandidateDOB').val());
        formData.append('visa_type', $('#VisaType').val());
        formData.append('contract_duration', $('#NumberOfDays').val());
        const paymentProof = $('#paymentProof')[0].files[0];
        if (paymentProof) {
            formData.append('payment_proof', paymentProof);
        }
        $('#spinner').show();
        $.ajax({
            url: '{{ route('agreements.insideagreement')}}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#spinner').hide();
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $('#TrialModalForm')[0].reset();
                    $('#TrialModal').modal('hide');
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                $('#spinner').hide();
                const response = xhr.responseJSON;
                if (response && response.errors) {
                    Object.entries(response.errors).forEach(([key, errors]) => {
                        errors.forEach(error => toastr.error(`${key}: ${error}`));
                    });
                } else {
                    toastr.error('An unexpected error occurred.');
                }
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('TrialStartDate');
        const endDateInput = document.getElementById('TrialEndDate');
        const numberOfDaysInput = document.getElementById('NumberOfDays');
        if (startDateInput && endDateInput && numberOfDaysInput) {
            startDateInput.addEventListener('change', calculateNumberOfDays);
            endDateInput.addEventListener('change', calculateNumberOfDays);
            function calculateNumberOfDays() {
                const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
                const endDate = endDateInput.value ? new Date(endDateInput.value) : null;

                if (startDate && endDate) {
                    if (endDate >= startDate) {
                        const timeDifference = endDate.getTime() - startDate.getTime();
                        const daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24)) + 1;
                        numberOfDaysInput.value = daysDifference;
                    } else {
                        toastr.error('End Date must be after or equal to Start Date');
                        numberOfDaysInput.value = '';
                    }
                } else {
                    numberOfDaysInput.value = '';
                }
            }
        } else {
            console.error('One or more elements (TrialStartDate, TrialEndDate, NumberOfDays) not found in the DOM.');
        }
    });
    $(document).ready(function () {
        $('#clientDropdownOutside').select2({
            placeholder: "Select a client",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#selectedModal') 
        });
    });
</script>
