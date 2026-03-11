<style>
    .table-container{width:100%;overflow-x:auto;position:relative}
    .table{width:100%;border-collapse:collapse}
    .table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .table th{background-color:#343a40;color:white;text-transform:uppercase;font-weight:bold}
    .table-hover tbody tr:hover{background-color:#f1f1f1}
    .table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}
    .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:white}
    .btn-info{background-color:#17a2b8}
    .btn-warning{background-color:#ffc107}
    .btn-danger{background-color:#dc3545}
    .attachments-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:20px;margin-top:10px}
    .attachment-item{text-align:center}
    .attachment-item p{margin-top:5px;font-size:12px}
    .img-thumbnail{max-width:100px;max-height:100px;object-fit:cover}
    .bg-gradient-primary{background:linear-gradient(to right,#007bff,#6a11cb)}
    .btn-sm{font-size:.8rem}
    .table-warning{background-color:#fff3cd!important}
    .appeal-blink{animation:blink-animation 1.5s infinite;font-weight:bold;color:#000}
    @keyframes blink-animation{0%{opacity:1}50%{opacity:.5}100%{opacity:1}}
    .dropdown-container{display:none;position:fixed;z-index:1050;background-color:#ffffff;border-radius:8px;padding:20px;box-shadow:0 8px 12px rgba(0,0,0,.2);min-width:350px;max-width:450px;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border:4px solid #007bff;animation:fadeIn .3s ease-in-out}
    .dropdown-header{margin-bottom:15px}
    .dropdown-header .header-icon{font-size:24px;color:#007bff;margin-bottom:10px}
    .dropdown-header p{font-size:12px;font-weight:bold;color:#333;margin:5px 0;line-height:1.5}
    .candidate-name{color:#007bff;font-weight:bold;font-size:12px}
    .status-dropdown{width:100%;margin-top:10px;font-size:12px;border:2px solid #007bff;border-radius:6px;outline:none;background-color:#fff;color:#333}
    .close-icon{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer;transition:color .3s ease}
    .close-icon:hover{color:#ff4500}
    @keyframes fadeIn{from{opacity:0;transform:translate(-50%,-55%)}to{opacity:1;transform:translate(-50%,-50%)}}
    .pagination-controls{margin-top:10px;display:flex;gap:10px;justify-content:center;align-items:center}
    .icon-wrapper{display:flex;justify-content:center;align-items:center;width:20px;height:20px;border-radius:50%;background-color:#f0f0f0;box-shadow:0 4px 6px rgba(0,0,0,.1);transition:background-color .3s ease,transform .3s ease;cursor:pointer}
    .icon-wrapper i{font-size:12px;color:#555}
    .icon-wrapper:hover{background-color:#007BFF;transform:scale(1.1)}
    .icon-wrapper:hover i{color:#fff}
    .icon-wrapper .disabled{cursor:not-allowed;opacity:.5}
    .icon-wrapper .disabled:hover{transform:none;background-color:#f0f0f0}
    .office-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff}
    .office-modal .modal-header h5{margin:0;font-weight:600}
    .office-modal label{font-weight:500;margin-bottom:3px}
    .office-modal .form-control,.office-modal .form-select{font-size:14px}
    .custom-modal .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3);font-family:'Arial',sans-serif;font-size:12px;background:#ffffff}
    .custom-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0}
    .custom-modal .modal-header h5,.custom-modal .modal-header h4{font-size:12px;font-weight:bold;margin:0;color:#fff}
    .custom-modal .modal-header .btn-close{font-size:1.2rem}
    .custom-modal .modal-header .btn-close:hover{opacity:1;transform:scale(1.1)}
    .custom-modal .modal-body{padding:20px;color:#333;background:#f9f9f9}
    .custom-modal .modal-body-scroll{max-height:400px;overflow-y:auto;overflow-x:hidden;padding-right:10px}
    .custom-modal .modal-body-scroll::-webkit-scrollbar{width:8px;background:#f1f1f1}
    .custom-modal .modal-body-scroll::-webkit-scrollbar-thumb{background:#007bff;border-radius:4px}
    .custom-modal .modal-body-scroll::-webkit-scrollbar-thumb:hover{background:#0056b3}
    .custom-modal .modal-footer{padding:15px;border-top:1px solid #ddd;border-radius:0 0 12px 12px;background:#f1f1f1}
    .custom-modal .modal-footer .btn{font-size:12px;padding:8px 15px;border-radius:5px;transition:all .3s}
    .custom-modal .modal-footer .btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:none}
    .custom-modal .modal-footer .btn-primary:hover{background:#0056b3;color:#fff}
    .custom-modal .btn-secondary{background:#6c757d;color:#fff;border:none}
    .custom-modal .btn-secondary:hover{background:#565e64;color:#fff}
    .custom-modal .table-container{width:100%;max-height:300px;overflow-x:auto;overflow-y:auto;border:1px solid #ddd;border-radius:8px}
    .custom-modal .table-container::-webkit-scrollbar{width:8px;height:8px}
    .custom-modal .table-container::-webkit-scrollbar-thumb{background:#007bff;border-radius:4px}
    .custom-modal .table-container::-webkit-scrollbar-thumb:hover{background:#0056b3}
    .custom-modal .table{margin-bottom:0;font-size:12px;color:#333}
    .custom-modal .table thead th{background:linear-gradient(135deg,#007bff,#6a11cb);color:white;font-size:12px;font-weight:bold;text-transform:uppercase;text-align:center}
    .custom-modal .table tbody tr{border-bottom:1px solid #e9ecef}
    .custom-modal .table tbody tr:hover{background:#f1f1f1}
    .custom-modal .table td,.custom-modal .table th{padding:10px;text-align:left;white-space:nowrap}
    .custom-modal input[type="text"],.custom-modal input[type="number"],.custom-modal input[type="file"],.custom-modal input[type="email"],.custom-modal select,.custom-modal .form-control{font-size:12px;padding:10px;border:1px solid #ddd;border-radius:5px;width:100%;transition:border-color .3s,box-shadow .3s}
    .custom-modal input[type="text"]:focus,.custom-modal input[type="number"]:focus,.custom-modal input[type="file"]:focus,.custom-modal input[type="email"]:focus,.custom-modal select:focus,.custom-modal .form-control:focus{border-color:#007bff;box-shadow:0 0 5px rgba(0,123,255,.5)}
    .custom-modal label{font-weight:normal;margin-bottom:5px;color:#000}
    .custom-modal .btn{transition:all .2s ease-in-out;font-size:12px}
    .custom-modal .btn:hover{transform:scale(1.05);box-shadow:0 4px 10px rgba(0,0,0,.1)}
    .custom-modal .pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}
    .custom-modal .pagination{display:flex;gap:.3rem}
    .custom-modal .pagination .page-link{font-size:12px;padding:.5rem .75rem;color:#007bff;background:white;border:1px solid #007bff;border-radius:4px;transition:all .2s}
    .custom-modal .pagination .page-link:hover{background:#007bff;color:white}
    .custom-modal .pagination .page-item.active .page-link{background:#007bff;color:white;border:none}
    .custom-modal .pagination .page-item.disabled .page-link{color:#6c757d;background:#f1f1f1}
    .status-icon{margin-right:6px;font-size:.9rem;vertical-align:-2px}
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Agree. #</th>
                <th>Selected Date</th>
                <th>Candidate</th>
                <th>Current Status</th>
                <th>Client</th>
                <th>WC Date</th>
                <th>Visa Date</th>
                <th>Arrived Date</th>
                <th>Incident</th>
                <th>Updated At</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $statusMap = [
                    1  => ['label' => 'Available',                      'icon' => 'check-circle',         'class' => 'success'],
                    2  => ['label' => 'Back Out',                       'icon' => 'undo',                 'class' => 'secondary'],
                    3  => ['label' => 'Hold',                           'icon' => 'pause-circle',         'class' => 'warning'],
                    4  => ['label' => 'Selected',                       'icon' => 'hand-pointer',         'class' => 'primary'],
                    5  => ['label' => 'WC-Date',                        'icon' => 'calendar-day',         'class' => 'info'],
                    6  => ['label' => 'Incident Before Visa (IBV)',     'icon' => 'exclamation-triangle', 'class' => 'danger'],
                    7  => ['label' => 'Visa Date',                      'icon' => 'passport',             'class' => 'primary'],
                    8  => ['label' => 'Incident After Visa (IAV)',      'icon' => 'exclamation-triangle', 'class' => 'danger'],
                    9  => ['label' => 'Medical Status',                 'icon' => 'notes-medical',        'class' => 'info'],
                    10 => ['label' => 'COC-Status',                     'icon' => 'certificate',          'class' => 'primary'],
                    11 => ['label' => 'MoL Submitted Date',             'icon' => 'file-upload',          'class' => 'primary'],
                    12 => ['label' => 'MoL Issued Date',                'icon' => 'file-signature',       'class' => 'success'],
                    13 => ['label' => 'Departure Date',                 'icon' => 'plane-departure',      'class' => 'info'],
                    14 => ['label' => 'Incident After Departure (IAD)', 'icon' => 'exclamation-triangle', 'class' => 'danger'],
                    15 => ['label' => 'Arrived Date',                   'icon' => 'plane-arrival',        'class' => 'success'],
                    16 => ['label' => 'Incident After Arrival (IAA)',   'icon' => 'exclamation-triangle', 'class' => 'danger'],
                    17 => ['label' => 'Transfer Date',                  'icon' => 'exchange-alt',         'class' => 'secondary'],
                ];
                $status = $statusMap[(int)($package->current_status ?? 0)] ?? ['label' => 'Unknown', 'icon' => 'question-circle', 'class' => 'dark'];
            ?>

            <tr>
                <td class="align-middle">
                    <a href="" style="color:#007bff"><?php echo e(strtoupper($package->agreement_no)); ?></a>
                    <?php $agStatus = $package->agreement?->status; ?>
                    <div class="text-muted small mt-1">
                        <?php switch($agStatus):
                            case (1): ?> <i class="fas fa-clock text-warning status-icon" title="Pending"></i> PENDING <?php break; ?>
                            <?php case (2): ?> <i class="fas fa-check-circle text-success status-icon" title="Active"></i> ACTIVE <?php break; ?>
                            <?php case (3): ?> <i class="fas fa-exclamation-circle text-warning status-icon" title="Exceeded"></i> EXCEEDED <?php break; ?>
                            <?php case (4): ?> <i class="fas fa-times-circle text-danger status-icon" title="Rejected"></i> REJECTED <?php break; ?>
                            <?php case (5): ?> <i class="fas fa-file-signature text-success status-icon" title="Contracted"></i> CONTRACTED <?php break; ?>
                            <?php default: ?> <i class="fas fa-question-circle text-secondary status-icon" title="Unknown"></i> UNKNOWN
                        <?php endswitch; ?>
                    </div>
                </td>

                <td class="align-middle text-center">
                    <div><?php echo e(\Carbon\Carbon::parse($package->created_at)->format('d M Y')); ?></div>
                    <div class="text-muted small mt-1" title="<?php echo e($package->sales_name); ?>"><?php echo e(strtoupper(explode(' ', $package->sales_name)[0])); ?></div>
                </td>

                <td class="align-middle">
                    <a href="<?php echo e(url('package/'.$package->id)); ?>" target="_blank" class="text-decoration-none" style="color:#007bff">
                        <?php echo e($package->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($package->candidate_name))) : 'N/A'); ?>

                    </a>

                    <img src="<?php echo e(asset('assets/img/attach.png')); ?>" alt="Attachment Icon" style="cursor:pointer;margin-left:8px;vertical-align:middle;height:20px;" title="View Attachments of the Candidate" onclick="showCandidateModal('<?php echo e($package->candidate_name); ?>', '<?php echo e($package->id); ?>', '<?php echo e($package->reference_no); ?>')" />

                    <div class="text-muted small mt-1">
                        <?php echo e(strtoupper($package->passport_no)); ?> — <?php echo e(strtoupper($package->nationality)); ?> — <?php echo e(strtoupper(\Illuminate\Support\Str::before($package->foreign_partner ?? '', ' '))); ?>

                    </div>
                </td>

                <td>
                    <span class="btn btn-sm btn-<?php echo e($status['class']); ?>" style="font-size:10px;color:#fff;">
                        <i class="fas fa-<?php echo e($status['icon']); ?>"></i> <?php echo e($status['label']); ?>

                    </span>
                </td>

                <td class="align-middle">
                    <a href="" class="text-decoration-none" style="color:#007bff"><?php echo e(strtoupper($package->sponsor_name)); ?></a>
                    <div class="text-muted small mt-1">CLIENT #: <?php echo e(strtoupper($package->CL_Number)); ?> — EID: <?php echo e(strtoupper($package->eid_no)); ?></div>
                </td>

                <td class="align-middle">
                    <div><?php echo e($package->wc_date ? \Carbon\Carbon::parse($package->wc_date)->format('d M Y') : 'N/A'); ?></div>
                    <div class="text-muted small mt-1">DW #: <?php echo e(strtoupper($package->dw_number ?? 'N/A')); ?></div>
                </td>

                <td class="align-middle">
                    <div><?php echo e($package->visa_date ? \Carbon\Carbon::parse($package->visa_date)->format('d M Y') : 'N/A'); ?></div>
                    <div class="text-muted small mt-1"><?php echo e($package->visa_type ? strtoupper($package->visa_type) : 'N/A'); ?></div>
                </td>

                <td><?php echo e($package->arrived_date ? \Carbon\Carbon::parse($package->arrived_date)->format('d M Y') : 'N/A'); ?></td>

                <td class="align-middle">
                    <div><?php echo e($package->incident_date ? \Carbon\Carbon::parse($package->incident_date)->format('d M Y') : 'N/A'); ?></div>
                    <div class="text-muted small mt-1"><?php echo e($package->incident_type ? strtoupper($package->incident_type) : 'N/A'); ?></div>
                </td>

                <td><?php echo e(\Carbon\Carbon::parse($package->updated_at)->format('d M Y h:i A')); ?></td>

                <td><?php echo e(strtoupper($package->remarks)); ?></td>

                <td id="action-cell-<?php echo e($package->id); ?>">
                    <?php if($package->inside_status === 0 || $package->inside_status === 6): ?>
                        <a href="javascript:void(0);" class="btn btn-primary btn-icon-only" onclick="openDropdown('<?php echo e($package->id); ?>', this, '<?php echo e($package->candidate_name); ?>')" title="Change Status">
                            <i class="fas fa-train"></i>
                        </a>

                        <div class="dropdown-container" id="dropdownContainer-<?php echo e($package->id); ?>">
                            <div class="close-icon" onclick="closeAllDropdowns()"><i class="fas fa-times-circle"></i></div>
                            <div class="dropdown-header">
                                <div class="header-icon"><i class="fas fa-info-circle"></i></div>
                                <p>Change status for <span class="candidate-name"><?php echo e($package->candidate_name); ?></span></p>
                            </div>

                            <select class="form-control status-dropdown" onchange="confirmStatusChange(this, '<?php echo e($package->id); ?>', '<?php echo e($package->candidate_name); ?>')">
                                <?php $allowed = [0 => 'Change Status', 5 => 'Incident']; ?>
                                <?php $__currentLoopData = $allowed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php if((int)0 === (int)$id): echo 'selected'; endif; ?>><?php echo e($name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <?php if(in_array($package->inside_status, [1])): ?>
                        <a href="<?php echo e(route('package.exit', $package->cn_number_series)); ?>" class="btn btn-danger btn-icon-only" title="Exit">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo e(route('package.showCV', ['package' => $package->cn_number_series])); ?>" target="_blank" class="btn btn-info btn-icon-only ms-1" title="View CV">
                        <i class="fas fa-file-alt"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="12" class="text-center">No results found.</td></tr>
        <?php endif; ?>
        </tbody>

        <tfoot>
            <tr>
                <th>Agree. #</th>
                <th>Selected Date</th>
                <th>Candidate</th>
                <th>Current Status</th>
                <th>Client</th>
                <th>WC Date</th>
                <th>Visa Date</th>
                <th>Arrived Date</th>
                <th>Incident</th>
                <th>Updated At</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>

<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">Showing <?php echo e($packages->firstItem()); ?> to <?php echo e($packages->lastItem()); ?> of <?php echo e($packages->total()); ?> results</span>
        <ul class="pagination justify-content-center">
            <?php echo e($packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

        </ul>
    </div>
</nav>

<div class="modal fade custom-modal" id="consentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transfer to Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Do you want to transfer <strong id="consentCandidate"></strong> to employees? This will disable the package.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmTransferBtn">Yes, Transfer</button>
            </div>
        </div>
    </div>
</div>

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
                            <tr><th style="width:30%" class="bg-secondary text-white"><i class="fas fa-user"></i> Sales Name</th><td id="office_sales_name"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-handshake"></i> Partner</th><td id="office_partner"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-hashtag"></i> CN Number</th><td id="office_cn_number"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-hashtag"></i> CL Number</th><td id="office_cl_number"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-passport"></i> Visa Type</th><td id="office_visa_type"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-info-circle"></i> Visa Status</th><td id="office_visa_status"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-box-open"></i> Package</th><td id="office_package_value"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-plane-arrival"></i> Arrived Date</th><td id="office_arrived_date"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-exchange-alt"></i> Transfer Date</th><td id="office_transferred_date"></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-edit me-2"></i>Form</h6>
                    <form id="officeForm" enctype="multipart/form-data">
                        <input type="hidden" name="package_id" id="package_id" value="">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category">Category</label>
                                <select id="category" name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Sales return">Sales return</option>
                                    <option value="Trial return">Trial return</option>
                                    <option value="Absconding">Absconding</option>
                                    <option value="Repatriation">Repatriation</option>
                                    <option value="Reserved">Reserved</option>
                                    <option value="New arrival">New arrival</option>
                                    <option value="Hospital">Hospital</option>
                                    <option value="Embassy">Embassy</option>
                                    <option value="Sick">Sick</option>
                                    <option value="Waiting ticket">Waiting ticket</option>
                                    <option value="Runaway">Runaway</option>
                                    <option value="Unfit">Unfit</option>
                                    <option value="Pregnant">Pregnant</option>
                                    <option value="Valid visa">Valid visa</option>
                                    <option value="Valid residency">Valid residency</option>
                                    <option value="Refused">Refused</option>
                                    <option value="Psychiatric">Psychiatric</option>
                                    <option value="Embassy shelter">Embassy shelter</option>
                                    <option value="Police station">Police station</option>
                                    <option value="Jail">Jail</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="returned_date">Returned Date</label>
                                <input type="date" name="returned_date" id="returned_date" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="expiry_date">Cancellation Expiry</label>
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="ica_proof_attachment">ICA Proof Attachment</label>
                                <input type="file" name="ica_proof_attachment" id="ica_proof_attachment" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="overstay_days">Overstay Days</label>
                                <input type="number" name="overstay_days" id="overstay_days" class="form-control" value="0">
                            </div>
                            <div class="col-md-6">
                                <label for="fine_amount">Fine Amount</label>
                                <input type="number" name="fine_amount" id="fine_amount" class="form-control" value="0">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="passport_status" class="form-label">Passport Status</label>
                                <select id="passport_status" name="passport_status" class="form-select">
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="$('#officeModal').modal('hide');"><i class="fas fa-times me-1"></i> Close</button>
                            <button type="button" id="saveOfficeBtn" class="btn btn-success" onclick="saveOfficeData()"><i class="fas fa-save me-1"></i> Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-modal" id="incidentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="incidentForm" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <input type="hidden" id="im_refund_type" name="refund_type" value="package">
            <input type="hidden" id="im_refund_type_label" name="refund_type_label" value="Inside - All">

            <input type="hidden" id="im_candidate_id" name="candidate_id">
            <input type="hidden" id="im_candidate_reference_no" name="candidate_reference_no">
            <input type="hidden" id="im_candidate_ref_no" name="candidate_ref_no">
            <input type="hidden" id="im_foreign_partner" name="foreign_partner">
            <input type="hidden" id="im_candidate_nationality" name="candidate_nationality">
            <input type="hidden" id="im_candidate_passport_number" name="candidate_passport_number">
            <input type="hidden" id="im_candidate_passport_expiry" name="candidate_passport_expiry">
            <input type="hidden" id="im_candidate_dob" name="candidate_dob">

            <input type="hidden" id="im_agreement_id" name="agreement_id">
            <input type="hidden" id="im_agreement_reference_no" name="agreement_reference_no">
            <input type="hidden" id="im_agreement_type" name="agreement_type">
            <input type="hidden" id="im_agreement_client_id" name="agreement_client_id">

            <input type="hidden" id="im_remaining_with_vat" value="0">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Incident</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="$('#incidentModal').modal('hide');"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-lg-6">
                            <label for="im_candidate_name" class="form-label"><i class="fas fa-user me-1"></i> Candidate Name <span class="text-danger">*</span></label>
                            <input type="text" id="im_candidate_name" name="candidate_name" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-lg-6">
                            <label for="im_sponsor_name" class="form-label"><i class="fas fa-building me-1"></i> Sponsor Name <span class="text-danger">*</span></label>
                            <input type="text" id="im_sponsor_name" name="employer_name" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-lg-6">
                            <label for="im_sponsor_qid" class="form-label"><i class="fas fa-id-card me-1"></i> Sponsor QID</label>
                            <input type="text" id="im_sponsor_qid" name="sponsor_qid" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-lg-6">
                            <label for="im_incident_category" class="form-label"><i class="fas fa-layer-group me-1"></i> Category</label>
                            <input type="text" id="im_incident_category" name="incident_category" class="form-control form-control-sm" value="Inside - Outside Tab" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="im_incident_reason" class="form-label"><strong><i class="fas fa-list-alt me-1"></i> Select Reason</strong></label>
                        <select id="im_incident_reason" name="incident_reason" class="form-select" required>
                            <option value="">Select Reason</option>
                            <option value="RUNAWAY">RUNAWAY</option>
                            <option value="REPATRIATION">REPATRIATION</option>
                            <option value="UNFIT">UNFIT</option>
                            <option value="SICK">SICK</option>
                            <option value="REFUSED">REFUSED</option>
                            <option value="PSYCHIATRIC">PSYCHIATRIC</option>
                            <option value="RESERVED">RESERVED</option>
                            <option value="ABSCONDING">ABSCONDING</option>
                            <option value="RELEASED">RELEASED</option>
                            <option value="MOHRE COMPLAIN">MOHRE COMPLAIN</option>
                            <option value="OTHER">OTHER</option>
                        </select>

                        <div id="im_other_reason_wrap" class="mt-2" style="display:none;">
                            <label for="im_other_reason" class="form-label"><strong><i class="fas fa-pen me-1"></i> Specify Reason</strong></label>
                            <input type="text" id="im_other_reason" name="other_reason" class="form-control" placeholder="Write reason here">
                        </div>

                        <div id="im_expiry_wrap" class="mb-3" style="display:none;margin-top:10px;">
                            <label for="im_incident_expiry_date" class="form-label"><strong><i class="fas fa-calendar-alt me-1"></i> Expiry Date of Incident</strong></label>
                            <input type="date" id="im_incident_expiry_date" name="incident_expiry_date" class="form-control">
                        </div>
                    </div>

                    <div id="im_no_agreement" class="alert alert-warning d-none">There is no agreement exist related this candidate.</div>

                    <div class="card border-warning mb-3" id="im_agreement_card">
                        <div class="card-body mt-2">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h6 class="m-0 fw-semibold"><i class="fas fa-file-contract me-1"></i> Agreement Details</h6>
                            </div>

                            <div class="d-flex gap-4 align-items-center flex-wrap mt-2">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" id="im_decision_refund" name="customer_decision" value="Refund" checked>
                                    <label class="form-check-label" for="im_decision_refund">Refund</label>
                                </div>
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" id="im_decision_replacement" name="customer_decision" value="Replacement">
                                    <label class="form-check-label" for="im_decision_replacement">Replacement</label>
                                </div>
                            </div>

                            <div class="mt-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle mb-0">
                                        <tbody>
                                            <tr>
                                                <th style="width:45%;">Agreement Reference No</th>
                                                <td><input type="text" id="im_agreement_reference_no_text" class="form-control form-control-sm" readonly></td>
                                            </tr>
                                            <tr>
                                                <th>Contract Start Date</th>
                                                <td><input type="text" id="im_contract_start_date" name="agreement_start_date" class="form-control form-control-sm" readonly></td>
                                            </tr>
                                            <tr>
                                                <th>Contract End Date</th>
                                                <td><input type="text" id="im_contract_end_date" name="agreement_end_date" class="form-control form-control-sm" readonly></td>
                                            </tr>
                                            <tr>
                                                <th>Total Amount</th>
                                                <td><input type="text" id="im_total_amount" name="contracted_amount" class="form-control form-control-sm" readonly></td>
                                            </tr>
                                            <tr>
                                                <th>Received Amount</th>
                                                <td><input type="text" id="im_received_amount" name="received_amount" class="form-control form-control-sm" readonly></td>
                                            </tr>
                                            <tr>
                                                <th>Office Charges</th>
                                                <td><input type="number" min="0" step="0.01" id="im_office_charges" name="office_charges" class="form-control form-control-sm" value="0"></td>
                                            </tr>
                                            <tr>
                                                <th><span id="im_balance_label">Refund Balance</span></th>
                                                <td><input type="text" id="im_balance_amount" name="balance_amount" class="form-control form-control-sm" readonly></td>
                                            </tr>
                                            <tr>
                                                <th><span id="im_due_label">Refund Due Date</span></th>
                                                <td><input type="date" id="im_refund_due_date" name="refund_due_date" class="form-control form-control-sm" autocomplete="off"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="im_proof" class="form-label"><strong><i class="fas fa-upload me-1"></i> Upload Incident Proof</strong></label>
                        <input type="file" id="im_proof" name="proof" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>

                    <div class="mb-3">
                        <label for="im_remarks" class="form-label"><strong><i class="fas fa-comment-dots me-1"></i> Add Remark (Optional)</strong></label>
                        <textarea id="im_remarks" name="remarks" class="form-control" rows="4" placeholder="Write your remarks here..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" id="im_save_btn" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
(() => {
    const csrfToken = '<?php echo e(csrf_token()); ?>';
    const routes = {
        transferToEmployees: '<?php echo e(route('transfer-to-employees')); ?>',
        officeData: "<?php echo e(route('package.officeData' , ':id')); ?>",
        officeSave: "<?php echo e(route('package.officeSave')); ?>",
        incidentSave: "<?php echo e(route('package.incidentSave')); ?>",
        insideStatusUpdate: "<?php echo e(route('packages.update-status-inside', ['packageId' => ':id'])); ?>"
    };

    let activePackageId = null;

    const num = (v) => {
        const n = parseFloat(String(v ?? '').replace(/[^0-9.\-]/g, ''));
        return Number.isFinite(n) ? n : 0;
    };

    const fix2 = (n) => (Number.isFinite(n) ? n : 0).toFixed(2);

    const setDecisionMode = (mode) => {
        const isRefund = mode === 'Refund';
        $('#im_decision_refund').prop('checked', isRefund);
        $('#im_decision_replacement').prop('checked', !isRefund);
        $('#im_balance_label').text(isRefund ? 'Refund Balance' : 'Replacement Balance');
        $('#im_due_label').text(isRefund ? 'Refund Due Date' : 'Replacement Due Date');
    };

    const calcIncidentBalance = () => {
        const received = num($('#im_received_amount').val());
        let charges = num($('#im_office_charges').val());
        if (charges < 0) charges = 0;
        if (charges > received) charges = received;
        $('#im_office_charges').val(fix2(charges));
        $('#im_balance_amount').val(fix2(Math.max(0, received - charges)));
    };

    const postInsideStatus = (packageId, statusId, onOk, onFail) => {
        const url = routes.insideStatusUpdate.replace(':id', packageId);
        $.ajax({
            url,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: { package_id: packageId, status_id: statusId },
            success: (res) => { if (typeof onOk === 'function') onOk(res); },
            error: (xhr) => { if (typeof onFail === 'function') onFail(xhr); else toastr.error(xhr.responseJSON?.message || 'Request failed.'); }
        });
    };

    const resetIncidentForm = () => {
        const f = document.getElementById('incidentForm');
        if (f) f.reset();

        $('#im_candidate_id,#im_candidate_reference_no,#im_candidate_ref_no,#im_foreign_partner,#im_candidate_nationality,#im_candidate_passport_number,#im_candidate_passport_expiry,#im_candidate_dob').val('');
        $('#im_agreement_id,#im_agreement_reference_no,#im_agreement_type,#im_agreement_client_id').val('');
        $('#im_agreement_reference_no_text,#im_contract_start_date,#im_contract_end_date').val('');
        $('#im_total_amount,#im_received_amount').val('');
        $('#im_office_charges').val('0');
        $('#im_balance_amount').val('0.00');
        $('#im_refund_due_date').val('');
        $('#im_proof').val('');
        $('#im_remarks').val('');
        $('#im_other_reason').val('');
        $('#im_incident_expiry_date').val('');
        $('#im_incident_reason').val('');
        $('#im_other_reason_wrap').hide();
        $('#im_expiry_wrap').hide();
        $('#im_no_agreement').addClass('d-none');
        $('#im_agreement_card').removeClass('d-none');
        setDecisionMode('Refund');
        calcIncidentBalance();
    };

    const fillIncident = (payload) => {
        const d = payload?.candidateDetails ?? payload ?? {};
        const ag = d.agreement ?? {};
        const agreementId = d.agreement_id ?? ag.id ?? '';
        const agreementRef = d.agreement_reference_no ?? ag.reference_no ?? ag.agreement_reference_no ?? '';
        const agreementType = d.agreement_type ?? ag.agreement_type ?? '';
        const agreementClientId = d.agreement_client_id ?? ag.client_id ?? '';

        $('#im_candidate_id').val(d.candidate_id ?? d.candidateId ?? d.candidate_id ?? '');
        $('#im_candidate_name').val(d.candidate_name ?? d.candidateName ?? '');
        $('#im_candidate_reference_no').val(d.candidate_reference_no ?? d.candidateReferenceNo ?? d.referenceNo ?? '');
        $('#im_candidate_ref_no').val(d.candidate_ref_no ?? d.ref_no ?? d.refNo ?? '');
        $('#im_foreign_partner').val(d.foreign_partner ?? d.foreignPartner ?? '');
        $('#im_candidate_nationality').val(d.candidate_nationality ?? d.nationality ?? '');
        $('#im_candidate_passport_number').val(d.candidate_passport_number ?? d.passportNo ?? d.passport_no ?? '');
        $('#im_candidate_passport_expiry').val(d.candidate_passport_expiry ?? d.passportExpiry ?? d.passport_expiry ?? '');
        $('#im_candidate_dob').val(d.candidate_dob ?? d.dob ?? '');

        $('#im_sponsor_name').val(d.sponsor_name ?? d.employer_name ?? '');
        $('#im_sponsor_qid').val(d.sponsor_qid ?? '');

        const hasAgreement = !!(agreementId || agreementRef || d.agreement);
        if (!hasAgreement) {
            $('#im_no_agreement').removeClass('d-none');
            $('#im_agreement_card').addClass('d-none');
        } else {
            $('#im_no_agreement').addClass('d-none');
            $('#im_agreement_card').removeClass('d-none');

            $('#im_agreement_id').val(agreementId);
            $('#im_agreement_reference_no').val(agreementRef);
            $('#im_agreement_type').val(agreementType);
            $('#im_agreement_client_id').val(agreementClientId);

            $('#im_agreement_reference_no_text').val(agreementRef);
            $('#im_contract_start_date').val(d.contract_start_date ?? ag.contract_start_date ?? ag.start_date ?? '');
            $('#im_contract_end_date').val(d.contract_end_date ?? ag.contract_end_date ?? ag.end_date ?? '');
        }

        const totals = d.invoice_totals ?? {};
        const totalAmount = num(d.total_amount ?? totals.total_amount ?? ag.total_amount ?? ag.contracted_amount ?? d.contracted_amount);
        const receivedAmount = num(d.received_amount ?? totals.received_amount ?? ag.received_amount);

        $('#im_total_amount').val(fix2(totalAmount));
        $('#im_received_amount').val(fix2(receivedAmount));

        const received = receivedAmount;
        const initCharges = Math.min(Math.max(0, num(d.office_charges ?? 0)), received);
        $('#im_office_charges').val(fix2(initCharges));

        calcIncidentBalance();
    };

    const officeSelectors = {
        salesName: '#office_sales_name',
        partner: '#office_partner',
        cnNumber: '#office_cn_number',
        clNumber: '#office_cl_number',
        visaType: '#office_visa_type',
        visaStatus: '#office_visa_status',
        packageValue: '#office_package_value',
        arrivedDate: '#office_arrived_date',
        transferredDate: '#office_transferred_date'
    };

    window.openConsentModal = (id, name) => {
        activePackageId = id;
        $('#consentCandidate').text(name || '');
        new bootstrap.Modal(document.getElementById('consentModal')).show();
    };

    $('#confirmTransferBtn').on('click', () => {
        $.ajax({
            url: routes.transferToEmployees,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: { package_id: activePackageId },
            success: () => { $('#consentModal').modal('hide'); toastr.success('Transferred successfully.'); setTimeout(() => location.reload(), 1200); },
            error: (xhr) => { $('#consentModal').modal('hide'); toastr.error(xhr.responseJSON?.message || xhr.responseJSON?.error || xhr.statusText || 'Transfer failed.'); }
        });
    });

    window.openOfficeModal = (packageId) => {
        Object.values(officeSelectors).forEach(sel => $(sel).text(''));
        $('#package_id').val(packageId);
        const f = document.getElementById('officeForm');
        if (f) f.reset();

        $.ajax({
            url: routes.officeData.replace(':id', packageId),
            type: 'GET',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: (res) => {
                $(officeSelectors.salesName).text(String(res.sales_name || 'N/A').toUpperCase());
                $(officeSelectors.partner).text(String(res.partner || 'N/A').toUpperCase());
                $(officeSelectors.cnNumber).text(String(res.cn_number || 'N/A').toUpperCase());
                $(officeSelectors.clNumber).text(String(res.cl_number || 'N/A').toUpperCase());
                $(officeSelectors.visaType).text(String(res.visa_type || 'N/A').toUpperCase());
                $(officeSelectors.visaStatus).text(String(res.visa_status || 'N/A').toUpperCase());
                $(officeSelectors.packageValue).text(String(res.package || 'N/A').toUpperCase());
                $(officeSelectors.arrivedDate).text(res.arrived_date || 'N/A');
                $(officeSelectors.transferredDate).text(res.transferred_date || 'N/A');
                $('#officeModal').modal('show');
            },
            error: () => toastr.error('Failed to load office data.')
        });
    };

    window.saveOfficeData = () => {
        const form = document.getElementById('officeForm');
        const formData = new FormData(form);
        $.ajax({
            url: routes.officeSave,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: formData,
            processData: false,
            contentType: false,
            success: () => { toastr.success('Data saved successfully!'); $('#officeModal').modal('hide'); location.reload(); },
            error: () => toastr.error('Failed to save data.')
        });
    };

    window.openDropdown = (rowId, _btnEl, candidateName) => {
        $('.dropdown-container').hide();
        const $container = $(`#dropdownContainer-${rowId}`);
        $container.find('.candidate-name').text(candidateName || '');
        $container.css({ display: 'block', opacity: 0 }).animate({ opacity: 1 }, 200);
        const $sel = $container.find('select.status-dropdown');
        $sel.data('original', $sel.val());
    };

    window.closeAllDropdowns = () => {
        $('.dropdown-container').fadeOut(120);
    };

    window.openIncidentModal = (packageId) => {
        resetIncidentForm();
        postInsideStatus(
            packageId,
            5,
            (res) => {
                fillIncident(res);
                $('#incidentModal').modal('show');
            },
            (xhr) => toastr.error(xhr.responseJSON?.message || 'Failed to load incident data.')
        );
    };

    window.confirmStatusChange = (selectEl, packageId, candidateName) => {
        const $sel = $(selectEl);
        const newStatusVal = Number($sel.val());
        const prevStatusVal = $sel.data('original');

        if (!newStatusVal) { $sel.val(prevStatusVal); return; }

        Swal.fire({
            title: `Change status for ${candidateName}?`,
            text: `Set status to "${$sel.find(':selected').text()}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, change it',
            cancelButtonText: 'No'
        }).then(result => {
            if (!result.isConfirmed) { $sel.val(prevStatusVal); return; }

            closeAllDropdowns();

            if (newStatusVal === 5) {
                openIncidentModal(packageId);
                return;
            }

            if (newStatusVal === 1) {
                postInsideStatus(
                    packageId,
                    1,
                    () => openOfficeModal(packageId),
                    () => { toastr.error('Failed to update status.'); $sel.val(prevStatusVal); }
                );
                return;
            }

            postInsideStatus(
                packageId,
                newStatusVal,
                () => { toastr.success('Status updated successfully!'); location.reload(); },
                () => { toastr.error('Failed to update status.'); $sel.val(prevStatusVal); }
            );
        });
    };

    $(document).on('input', '#im_office_charges', function () {
        const raw = String($(this).val() ?? '');
        const sanitized = raw.replace(/[^0-9.]/g, '');
        const parts = sanitized.split('.');
        $(this).val(parts.length > 2 ? (parts[0] + '.' + parts.slice(1).join('')) : sanitized);
        calcIncidentBalance();
    });

    $(document).on('change', '#im_decision_refund,#im_decision_replacement', function () {
        if (this.id === 'im_decision_refund' && $(this).is(':checked')) setDecisionMode('Refund');
        if (this.id === 'im_decision_replacement' && $(this).is(':checked')) setDecisionMode('Replacement');
        calcIncidentBalance();
    });

    $(document).on('change', '#im_incident_reason', function () {
        const v = String($(this).val() || '').toUpperCase();
        v === 'MOHRE COMPLAIN' ? $('#im_expiry_wrap').show() : $('#im_expiry_wrap').hide();
        v === 'OTHER' ? $('#im_other_reason_wrap').show() : $('#im_other_reason_wrap').hide();
    });

    $('#im_save_btn').on('click', function () {
        const fd = new FormData(document.getElementById('incidentForm'));
        const decision = $('#im_decision_replacement').is(':checked') ? 'Replacement' : 'Refund';
        fd.set('customer_decision', decision);
        calcIncidentBalance();
        fd.set('office_charges', $('#im_office_charges').val());
        fd.set('balance_amount', $('#im_balance_amount').val());

        $.ajax({
            url: routes.incidentSave,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: fd,
            processData: false,
            contentType: false,
            success: () => { toastr.success('Incident saved successfully!'); $('#incidentModal').modal('hide'); location.reload(); },
            error: (xhr) => {
                const resp = xhr.responseJSON;
                if (resp && resp.errors) Object.values(resp.errors).flat().forEach(m => toastr.error(m));
                else toastr.error(resp?.message || 'Failed to save incident.');
            }
        });
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') closeAllDropdowns();
    });
})();
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/partials/outside_table.blade.php ENDPATH**/ ?>