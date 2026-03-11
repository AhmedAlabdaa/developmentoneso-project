<style>
    .table-container { width: 100%; overflow-x: auto; position: relative; }
    .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .table th, .table td {
        padding: 10px 15px;
        text-align: center;
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
    .table-hover tbody tr:hover { background-color: #f1f1f1; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
    .btn-icon-only { display: inline-flex; align-items: center; justify-content: center; padding: 5px; border-radius: 50%; font-size: 12px; width: 30px; height: 30px; color: white; }
    .btn-info { background-color: #17a2b8; }
    .btn-warning { background-color: #ffc107; }
    .btn-danger { background-color: #dc3545; }
    .attachments-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px; margin-top: 10px; }
    .attachment-item { text-align: center; }
    .attachment-item p { margin-top: 5px; font-size: 12px; }
    .img-thumbnail { max-width: 100px; max-height: 100px; object-fit: cover; }
    .bg-gradient-primary { background: linear-gradient(to right, #007bff, #6a11cb); }
    .btn-sm { font-size: 0.8rem; }
    .table-warning { background-color: #fff3cd !important; }
    .appeal-blink { animation: blink-animation 1.5s infinite; font-weight: bold; color: #000; }
    @keyframes blink-animation { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }
    .pagination-controls { display: flex; justify-content: center; margin-bottom: 10px; align-items: center; gap: 20px; }
    .pagination-controls i { font-size: 12px; cursor: pointer; color: #343a40; }
    .pagination-controls i.disabled { color: #ccc; cursor: not-allowed; }
    .fullscreen-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1049; }
    .dropdown-container { display: none; position: fixed; z-index: 1050; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2); min-width: 350px; max-width: 450px; text-align: center; left: 50%; top: 50%; transform: translate(-50%, -50%); border: 4px solid #007bff; animation: fadeIn 0.3s ease-in-out; }
    .dropdown-header { margin-bottom: 15px; }
    .dropdown-header .header-icon { font-size: 24px; color: #007bff; margin-bottom: 10px; }
    .dropdown-header p { font-size: 12px; font-weight: bold; color: #333; margin: 5px 0; line-height: 1.5; }
    .candidate-name { color: #007bff; font-weight: bold; font-size: 12px; }
    .status-dropdown { width: 100%; margin-top: 10px; font-size: 12px; border: 2px solid #007bff; border-radius: 6px; outline: none; background-color: #fff; color: #333; }
    .close-icon { position: absolute; top: 10px; right: 10px; font-size: 24px; color: #ff6347; cursor: pointer; transition: color 0.3s ease; }
    .close-icon:hover { color: #ff4500; }
    @keyframes fadeIn { from { opacity: 0; transform: translate(-50%, -55%); } to { opacity: 1; transform: translate(-50%, -50%); } }
    .dropdown-container .fa-times { cursor: pointer; margin-left: 10px; color: #888; font-size: 12px; }
    .pagination-controls { margin-top: 10px; display: flex; gap: 10px; justify-content: center; align-items: center; }
    .icon-wrapper { display: flex; justify-content: center; align-items: center; width: 20px; height: 20px; border-radius: 50%; background-color: #f0f0f0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease, transform 0.3s ease; cursor: pointer; }
    .icon-wrapper i { font-size: 12px; color: #555; }
    .icon-wrapper:hover { background-color: #007BFF; transform: scale(1.1); }
    .icon-wrapper:hover i { color: #fff; }
    .icon-wrapper .disabled { cursor: not-allowed; opacity: 0.5; }
    .icon-wrapper .disabled:hover { transform: none; background-color: #f0f0f0; }
    .pagination-container span { font-size: 12px; }
    /* Preloader styles */
    .preloader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1050;
    }
    .preloader-content {
        text-align: center;
    }
    .spinner {
        width: 50px;
        height: 50px;
        border: 6px solid rgba(0, 0, 0, 0.1);
        border-top-color: #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 10px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<?php if($employees->count()): ?>
<div class="table-responsive">
    <table class="table sticky-table table-striped table-hover">
        <thead>
            <tr>
                <th>Reference #</th>
                <!-- <th>HR Reference #</th> -->
                <th>Name</th>
                <th>Package</th>
                <th>Nationality</th>
                <th>Visa Status</th>
                <th>Passport No</th>
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
            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($employee->reference_no); ?></td>
                <!-- <td><?php echo e($employee->hr_reference_number); ?></td> -->
                <td><?php echo e($employee->name); ?></td>
                <td><?php echo e($employee->package); ?></td>
                <td><?php echo e($employee->nationality); ?></td>
                <td>
                    <?php if($employee->visa_status == 0): ?>
                        <button class="btn btn-secondary btn-sm">
                            <i class="fas fa-clock"></i> Not started
                        </button>
                    <?php else: ?>
                        <?php
                            $status = $visaStatus->firstWhere('id', $employee->visa_status);
                        ?>
                        <button class="btn btn-info btn-sm">
                            <i class="fas 
                                <?php switch($status->id):
                                    case (1): ?> fa-plane <?php break; ?>
                                    <?php case (2): ?> fa-plane-departure <?php break; ?>
                                    <?php case (3): ?> fa-file-medical <?php break; ?>
                                    <?php case (4): ?> fa-passport <?php break; ?>
                                    <?php case (5): ?> fa-user-shield <?php break; ?>
                                    <?php case (6): ?> fa-heartbeat <?php break; ?>
                                    <?php case (7): ?> fa-calendar-alt <?php break; ?>
                                    <?php case (8): ?> fa-id-card <?php break; ?>
                                    <?php case (9): ?> fa-stamp <?php break; ?>
                                    <?php case (10): ?> fa-plane-arrival <?php break; ?>
                                    <?php case (11): ?> fa-briefcase <?php break; ?>
                                    <?php case (12): ?> fa-money-bill <?php break; ?>
                                    <?php case (13): ?> fa-close <?php break; ?>
                                    <?php case (14): ?> fa-check-circle <?php break; ?>
                                    <?php default: ?> fa-question-circle
                                <?php endswitch; ?>
                            "></i> <?php echo e($status->name); ?>

                        </button>
                    <?php endif; ?>
                </td>
                <td><?php echo e($employee->passport_no); ?></td>
                <td>
                    <?php if($employee->passport_expiry_date): ?>
                        <?php echo e(\Carbon\Carbon::parse($employee->passport_expiry_date)->format('d M Y')); ?>

                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($employee->date_of_joining): ?>
                        <?php echo e(\Carbon\Carbon::parse($employee->date_of_joining)->format('d M Y')); ?>

                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td><?php echo e($employee->visa_designation); ?></td>
                <td>
                    <?php if($employee->date_of_birth): ?>
                        <?php echo e(\Carbon\Carbon::parse($employee->date_of_birth)->format('d M Y')); ?>

                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td><?php echo e($employee->gender); ?></td>
                <td>
                    <?php if($employee->employment_contract_start_date): ?>
                        <?php echo e(\Carbon\Carbon::parse($employee->employment_contract_start_date)->format('d M Y')); ?>

                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($employee->employment_contract_end_date): ?>
                        <?php echo e(\Carbon\Carbon::parse($employee->employment_contract_end_date)->format('d M Y')); ?>

                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td><?php echo e($employee->contract_type); ?></td>
                <td><?php echo e($employee->salary_as_per_contract); ?></td>
                <td><?php echo e($employee->basic); ?></td>
                <td><?php echo e($employee->housing); ?></td>
                <td><?php echo e($employee->transport); ?></td>
                <td><?php echo e($employee->other_allowances); ?></td>
                <td><?php echo e($employee->total_salary); ?></td>
                <td><?php echo e($employee->payment_type); ?></td>
                <td><?php echo e($employee->bank_name); ?></td>
                <td><?php echo e($employee->iban); ?></td>
                <td><?php echo e($employee->remarks); ?></td>
                <td><?php echo e($employee->comments); ?></td>
                <td class="actions">
                    <a href="<?php echo e(route('employees.show', $employee->reference_no)); ?>" class="btn btn-primary btn-icon-only" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-primary btn-icon-only" title="Change Status"
                       onclick="openDropdown('<?php echo e($employee->id); ?>', this, '<?php echo e($employee->name ? strtoupper(\Illuminate\Support\Str::title(strtolower($employee->name))) : 'N/A'); ?>')">
                        <i class="fas fa-train"></i>
                    </a>
                    <div class="fullscreen-overlay" id="fullscreenOverlay" onclick="closeAllDropdowns()"></div>
                    <div class="dropdown-container" id="dropdownContainer-<?php echo e($employee->id); ?>">
                        <div class="close-icon" onclick="closeAllDropdowns()">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="dropdown-header">
                            <div class="header-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <p>Do you want to change the status of</p>
                            <p>employee <span id="candidateName-<?php echo e($employee->id); ?>" class="candidate-name"><?php echo e($employee->name); ?></span>?</p>
                        </div>
                        <select class="form-control status-dropdown" id="statusDropdown-<?php echo e($employee->id); ?>" name="current_status" onchange="confirmStatusChange(this, '<?php echo e($employee->id); ?>','<?php echo e($employee->name); ?>')">
                            <option value="" selected>Choose Tracking Status</option>
                            <?php $__currentLoopData = $visaStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($statusOption->id); ?>" <?php echo e($employee->current_status == $statusOption->id ? 'selected' : ''); ?>>
                                <?php echo e($statusOption->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php if(Auth::user()->role === 'Admin'): ?>
                        <form action="<?php echo e(route('employees.destroy', $employee->reference_no)); ?>" method="POST" style="display:inline;" id="delete-form-<?php echo e($employee->reference_no); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="button" class="btn btn-danger btn-icon-only" onclick="confirmDelete('<?php echo e($employee->reference_no); ?>')" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Reference #</th>
                <!-- <th>HR Reference #</th> -->
                <th>Name</th>
                <th>Package</th>
                <th>Nationality</th>
                <th>Visa Status</th>
                <th>Passport No</th>
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
    <nav aria-label="Page navigation">
        <div class="pagination-container">
            <span class="muted-text">
                Showing <?php echo e($employees->firstItem()); ?> to <?php echo e($employees->lastItem()); ?> of <?php echo e($employees->total()); ?> results
            </span>
            <ul class="pagination justify-content-center">
                <?php echo e($employees->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

            </ul>
        </div>
    </nav>
</div>
<?php else: ?>
<div class="no-records" style="font-size: 12px; color: red; text-align: center;">
    <p>No employee records found.</p>
</div>
<?php endif; ?>


<script type="text/javascript">

    function openDropdown(candidateId, buttonElement, candidateName) {
        $('.dropdown-container').hide();
        $('#fullscreenOverlay').fadeIn();
        const dropdownContainer = $(`#dropdownContainer-${candidateId}`);
        dropdownContainer.find('.candidate-name').text(candidateName);
        dropdownContainer.css({ display: 'block', opacity: 0 }).animate({ opacity: 1 }, 300);
    }

    function closeAllDropdowns() {
        $('.dropdown-container').fadeOut();
        $('#fullscreenOverlay').fadeOut();
    }

    function confirmStatusChange(selectElement, candidateId, name) {
        if ($(selectElement).val() === null || $(selectElement).val() === "") {
            return false;
        }
        const selectedStatus = selectElement.options[selectElement.selectedIndex].text;
        Swal.fire({
            title: `Change status for ${name}?`,
            text: `Do you want to change the status to "${selectedStatus}"?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#dc3545",
            confirmButtonText: "Yes, change it",
            cancelButtonText: "No, keep it",
        }).then((result) => {
            if (result.isConfirmed) {
                const statusText = $.trim($(selectElement).find("option:selected").text());
                const status = $.trim($(selectElement).find("option:selected").val());
                const employee_id = candidateId;
                $.ajax({
                    url: '<?php echo e(route('employees.create-table')); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        statusText: statusText,
                        status:status,
                    },
                    success: function (response) {
                        var formFields = '';
                        response.fields.forEach(function (field) {
                            var inputField = '';
                            var fieldLabel = field.field_name.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
                            var fieldIcon = '';

                            switch (field.field_name.toLowerCase()) {
                                case 'proof':
                                    fieldIcon = 'fas fa-file-upload';
                                    inputField = `
                                        <div class="col-md-6 mb-3">
                                            <label for="${field.field_name}" class="form-label"><i class="${fieldIcon} me-1"></i> Proof</label>
                                            <input type="file" class="form-control" name="${field.field_name}" id="${field.field_name}" required>
                                        </div>`;
                                    break;
                                case 'remarks':
                                    fieldIcon = 'fas fa-comment-dots';
                                    inputField = `
                                        <div class="col-md-12 mb-3">
                                            <label for="${field.field_name}" class="form-label"><i class="${fieldIcon} me-1"></i> Remarks</label>
                                            <textarea class="form-control" name="${field.field_name}" id="${field.field_name}" placeholder="Enter ${fieldLabel}" required></textarea>
                                        </div>`;
                                    break;
                                case 'basic':
                                case 'housing':
                                case 'transportation':
                                case 'other_allowances':
                                case 'total':
                                    fieldIcon = 'fas fa-dollar-sign';
                                    inputField = `
                                        <div class="col-md-6 mb-3">
                                            <label for="${field.field_name}" class="form-label"><i class="${fieldIcon} me-1"></i> ${fieldLabel}</label>
                                            <input type="number" class="form-control" name="${field.field_name}" id="${field.field_name}" value="${field.default_value ?? ''}" required>
                                        </div>`;
                                    break;
                                case 'st_number':
                                case 'mb_number':
                                    fieldIcon = 'fas fa-hashtag';
                                    inputField = `
                                        <div class="col-md-6 mb-3">
                                            <label for="${field.field_name}" class="form-label"><i class="${fieldIcon} me-1"></i> ${fieldLabel}</label>
                                            <input type="number" class="form-control" name="${field.field_name}" id="${field.field_name}" value="${field.default_value ?? ''}" required>
                                        </div>`;
                                    break;
                                case 'invoice_no':
                                case 'permit_number':
                                    fieldIcon = 'fas fa-file-invoice';
                                    inputField = `
                                        <div class="col-md-6 mb-3">
                                            <label for="${field.field_name}" class="form-label"><i class="${fieldIcon} me-1"></i> ${fieldLabel}</label>
                                            <input type="text" class="form-control" name="${field.field_name}" id="${field.field_name}" placeholder="Enter ${fieldLabel}" value="${field.default_value ?? ''}" required>
                                        </div>`;
                                    break;
                                case 'invoice_amount':
                                    fieldIcon = 'fas fa-dollar-sign';
                                    inputField = `
                                        <div class="col-md-6 mb-3">
                                            <label for="${field.field_name}" class="form-label"><i class="${fieldIcon} me-1"></i> ${fieldLabel}</label>
                                            <input type="number" class="form-control" name="${field.field_name}" id="${field.field_name}" value="${field.default_value ?? ''}" required>
                                        </div>`;
                                    break;
                                case 'applied_date':
                                case 'expiry_date':
                                case 'issued_date':
                                case 'result_date':
                                case 'invoice_date':
                                case 'arrival_date':
                                case 'application_date':
                                case 'date_of_attended':
                                case 'lc_submission_date':
                                case 'biometric_schedule':
                                case 'inception_date':
                                case 'ol_expiry':
                                case 'paid_date':
                                case 'lc_expiry':
                                case 'cancellation_date':
                                case 'ol_type':
                                    fieldIcon = 'fas fa-calendar-alt';
                                    inputField = `
                                        <div class="col-md-6 mb-3">
                                            <label for="${field.field_name}" class="form-label"><i class="${fieldIcon} me-1"></i> ${fieldLabel}</label>
                                            <input type="date" class="form-control" name="${field.field_name}" id="${field.field_name}" value="${field.default_value ?? ''}" required>
                                        </div>`;
                                    break;
                                case 'eid_number':
                                case 'lc_number':
                                case 'permit_no':
                                case 'certificate_number':
                                case 'uid_number':
                                    fieldIcon = 'fas fa-id-badge';
                                    inputField = `
                                        <div class="col-md-6 mb-3">
                                            <label for="${field.field_name}" class="form-label"><i class="${fieldIcon} me-1"></i> ${fieldLabel}</label>
                                            <input type="text" class="form-control" name="${field.field_name}" id="${field.field_name}" placeholder="Enter ${fieldLabel}" value="${field.default_value ?? ''}" required>
                                        </div>`;
                                    break;
                                case 'candidate_id':
                                    break;
                                default:
                                    fieldIcon = 'fas fa-circle';
                                    inputField = `
                                        <div class="col-md-6 mb-3">
                                            <label for="${field.field_name}" class="form-label"><i class="${fieldIcon} me-1"></i> ${fieldLabel}</label>
                                            <input type="text" class="form-control" name="${field.field_name}" id="${field.field_name}" placeholder="Enter ${fieldLabel}" value="${field.default_value ?? ''}" required>
                                        </div>`;
                                    break;
                            }

                            formFields += inputField;
                        });

                        var statusIcons = {
                            "Visit 1": "fas fa-plane",
                            "Visit 2": "fas fa-plane-arrival",
                            "Dubai Insurance": "fas fa-shield-alt",
                            "Entry Permit Visa": "fas fa-passport",
                            "CS (For Inside)": "fas fa-building",
                            "Medical": "fas fa-user-md",
                            "Tawjeeh Date": "fas fa-calendar-alt",
                            "EID": "fas fa-id-card",
                            "Residence Visa Stamping": "fas fa-stamp",
                            "Visit 3": "fas fa-plane-departure",
                            "ILOE": "fas fa-file-invoice",
                            "Salary Details": "fas fa-coins",
                            "Visa Cancellation": "fas fa-close"
                        };

                        var iconClass = statusIcons[statusText] || "fas fa-info-circle";
                        var modalHtml = `
                            <div class="modal fade custom-modal" id="visaStatusModal" tabindex="-1" aria-labelledby="visaStatusModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="visaStatusModalLabel">
                                                <i class="${iconClass} me-2"></i> ${response.statusText}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="visaStatusForm">
                                                <input type="hidden" name="candidate_id" id="candidate_id" value="${candidateId}">
                                                <div class="row">
                                                    ${formFields}
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="saveVisaStatus">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        $('body').append(modalHtml);
                        $('#visaStatusModal').modal('show');
                        $('#visaStatusModal').on('hidden.bs.modal', function () {
                            $(this).remove();
                        });

                        $('#saveVisaStatus').on('click', function () {
                            var form = $('#visaStatusForm');
                            var formData = new FormData(form[0]);
                            var isValid = true;

                            form.find('input, textarea, select').each(function () {
                                if (!$(this).val() && $(this).attr('name') !== 'remarks') {
                                    $(this).addClass('is-invalid');
                                    toastr.error($(this).attr('name').replace(/_/g, ' ') + ' is required');
                                    isValid = false;
                                    return false;
                                } else {
                                    $(this).removeClass('is-invalid');
                                }
                            });

                            if (!isValid) return;
                            formData.append('form_name', statusText);
                            formData.append('status', status);
                            formData.append('_token', '<?php echo e(csrf_token()); ?>'); 
                            $.ajax({
                                url: '<?php echo e(route('employees.store-tracking-detail')); ?>',
                                method: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function () {
                                    toastr.success('Visa status saved successfully!');
                                    $('#visaStatusModal').modal('hide');
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);

                                },
                                error: function (xhr) {
                                    toastr.error('An error occurred: ' + xhr.responseText);
                                }
                            });
                        });
                    },
                    error: function (xhr) {
                        toastr.error('Error: ' + xhr.responseJSON.error);
                    }
                });
            }
        });
    }
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/partials/employee_visa_tracker_table.blade.php ENDPATH**/ ?>