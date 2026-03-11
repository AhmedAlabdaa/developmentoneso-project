<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        font-family: Arial, sans-serif;
    }
    .nav-tabs .nav-link {
        transition: background-color 0.2s;
        color: #495057;
        font-size: 12px;
        text-transform: uppercase;
    }
    .nav-tabs .nav-link:hover {
        background-color: #f8f9fa;
    }
    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: white;
    }
    .table thead th,
    .table tfoot th {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
    }
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
    }
    .muted-text {
        color: #6c757d;
        font-size: 12px;
    }
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }
    .pagination .page-item {
        margin: 0 0.1rem;
    }
    .pagination .page-link {
        border-radius: 0.25rem;
        padding: 0.5rem 0.75rem;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #007bff;
        transition: background-color 0.2s, color 0.2s;
    }
    .pagination .page-link:hover {
        background-color: #007bff;
        color: white;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border: 1px solid #6c757d;
        cursor: not-allowed;
    }
    .pagination .page-item:first-child .page-link {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    .pagination .page-item:last-child .page-link {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
    .table-container {
        width: 100%;
        overflow-x: auto;
        position: relative;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
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
    .btn-danger {
        background-color: #dc3545;
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
    .employee-name {
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
    .custom-modal .modal-content {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        font-size: 12px;
        background: #ffffff;
    }
    .custom-modal .modal-header {
        background: linear-gradient(135deg, #007bff, #6a11cb);
        color: #fff;
        padding: 15px;
        border-radius: 12px 12px 0 0;
    }
    .custom-modal .modal-header h5 {
        font-size: 12px;
        font-weight: bold;
        margin: 0;
        color: #fff;
    }
    .custom-modal .modal-body {
        padding: 20px;
        color: #333;
        background: #f9f9f9;
    }
    .custom-modal .modal-footer {
        padding: 15px;
        border-top: 1px solid #ddd;
        border-radius: 0 0 12px 12px;
        background: #f1f1f1;
    }
</style>
<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>CN Number</th>
                <th>CL Number</th>
                <th>BIA/TA</th>
                <th>Candidate Name</th>
                <th>Sales Name</th>
                <th>Status Date</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if($trials->isEmpty()): ?>
                <tr>
                    <td colspan="9" class="text-center no-records">No results found.</td>
                </tr>
            <?php else: ?>
                <?php $__currentLoopData = $trials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $today = \Carbon\Carbon::now('Asia/Dubai');
                        $trialEndDate = \Carbon\Carbon::parse($trial->trial_end_date);
                        $rowClass = '';
                        $buttonClass = 'btn-secondary';
                        $timeDisplay = '';
                        if ($trialEndDate->isSameDay($today)) {
                            $rowClass = 'background-color: #ffc107 !important;';
                        } elseif ($trialEndDate->lessThan($today)) {
                            $rowClass = 'background-color: #dc3545 !important;';
                        }
                        if ($trialEndDate->isPast()) {
                            $timeElapsed = $trialEndDate->diffForHumans($today, [
                                'parts' => 2,
                                'join' => ', ',
                                'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW,
                            ]);
                            $buttonClass = 'btn-danger';
                            $timeDisplay = "Expired $timeElapsed";
                        } else {
                            $timeLeft = $trialEndDate->diffForHumans($today, [
                                'parts' => 2,
                                'join' => ', ',
                                'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW,
                            ]);
                            $timeDisplay = $timeLeft;
                            if ($today->diffInHours($trialEndDate, false) <= 24) {
                                $buttonClass = 'btn-danger';
                            }
                        }
                    ?>
                    <tr style="<?php echo e($rowClass); ?>">
                        <td>
                            <a href="<?php echo e(route($trial->trial_type . 's.show', $trial->reference_no)); ?>" target="_blank" class="text-decoration-none text-dark">
                                <?php echo e(strtoupper($trial->CN_Number)); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('crm.show', $trial->client->slug)); ?>" target="_blank" class="text-decoration-none text-dark">
                                <?php echo e(strtoupper($trial->client->CL_Number)); ?>

                            </a>
                        </td>
                        <td>
                            <?php if($trial->agreement_reference_no): ?>
                                <a href="<?php echo e(route('agreements.show', $trial->agreement_reference_no)); ?>" target="_blank" class="text-decoration-none text-dark">
                                    <?php echo e(strtoupper($trial->agreement_reference_no)); ?>

                                </a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(strtoupper($trial->candidate_name)); ?></td>
                        <td><?php echo e(strtoupper(optional($trial->createdByUser)->first_name . ' ' . optional($trial->createdByUser)->last_name) ?: 'N/A'); ?></td>
                        <td>
                            <div><?php echo e(strtoupper(\Carbon\Carbon::parse($trial->updated_at)->timezone('Asia/Dubai')->format('d-M-Y'))); ?></div>
                            <div><?php echo e(strtoupper(\Carbon\Carbon::parse($trial->updated_at)->timezone('Asia/Dubai')->format('h:i A'))); ?></div>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($trial->trial_start_date)->format('d M Y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($trial->trial_end_date)->format('d M Y')); ?></td>
                        <td><?php echo e($trial->number_of_days); ?></td>
                        <?php
                            $statusConfig = [
                                'Active' => ['class' => 'btn-success', 'icon' => 'fas fa-check-circle'],
                                'Confirmed' => ['class' => 'btn-primary', 'icon' => 'fas fa-user-check'],
                                'Change Status' => ['class' => 'btn-warning', 'icon' => 'fas fa-exchange-alt'],
                                'Sales Return' => ['class' => 'btn-danger', 'icon' => 'fas fa-undo'],
                                'Incident' => ['class' => 'btn-dark', 'icon' => 'fas fa-exclamation-triangle'],
                                'Trial Return' => ['class' => 'btn-secondary', 'icon' => 'fas fa-arrow-circle-left'],
                            ];
                            $statusClass = $statusConfig[$trial->trial_status]['class'] ?? 'btn-light';
                            $statusIcon = $statusConfig[$trial->trial_status]['icon'] ?? 'fas fa-info-circle';
                        ?>
                        <td>
                            <button class="btn <?php echo e($statusClass); ?> btn-sm">
                                <i class="<?php echo e($statusIcon); ?>"></i> <?php echo e($trial->trial_status); ?>

                            </button>
                        </td>
                        <td class="actions">
                            <?php if($trial->trial_status === "Active"): ?>
                                <a href="#" class="btn <?php echo e($buttonClass); ?> btn-sm">
                                    <i class="fas fa-clock"></i> <?php echo e($timeDisplay); ?>

                                </a>
                            <?php endif; ?>
                            <a href="javascript:void(0);" class="btn btn-primary btn-icon-only" title="Change Status" onclick="openDropdown('<?php echo e($trial->id); ?>', this, '<?php echo e(strtoupper($trial->candidate_name)); ?>')">
                                <i class="fas fa-train"></i>
                            </a>
                            <div class="fullscreen-overlay" id="fullscreenOverlay" onclick="closeAllDropdowns()"></div>
                            <div class="dropdown-container" id="dropdownContainer-<?php echo e($trial->id); ?>" style="display: none;">
                                <div class="close-icon" onclick="closeAllDropdowns()">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="dropdown-header">
                                    <div class="header-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <p>Do you want to change the status of</p>
                                    <p>candidate <span id="candidateName-<?php echo e($trial->id); ?>" class="candidate-name"><?php echo e(strtoupper($trial->candidate_name)); ?></span>?</p>
                                </div>
                                <select class="form-control status-dropdown"
                                        id="statusDropdown-<?php echo e($trial->id); ?>"
                                        name="current_status"
                                        onchange="trialChangeStatus(this, <?php echo e($trial->id); ?>, <?php echo e($trial->candidate_id); ?>, <?php echo e($trial->client_id); ?>)">
                                    <?php if($trial->trial_status === "Active"): ?>
                                        <option value="Active" selected>Active</option>
                                        <option value="Confirmed">Confirmed</option>
                                        <option value="Trial Return">Trial Return</option>
                                        <option value="Incident">Incident</option>
                                    <?php elseif($trial->trial_status === "Confirmed"): ?>
                                        <option value="Confirmed" selected>Confirmed</option>
                                        <option value="Change Status">Change Status</option>
                                        <option value="Sales Return">Sales Return</option>
                                        <option value="Incident">Incident</option>
                                    <?php elseif($trial->trial_status === "Change Status"): ?>
                                        <option value="Change Status" selected>Change Status</option>
                                        <option value="Sales Return">Sales Return</option>
                                        <option value="Incident">Incident</option>
                                    <?php else: ?>
                                        <option value="<?php echo e($trial->trial_status); ?>"><?php echo e($trial->trial_status); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <a href="<?php echo e(route($trial->trial_type . '.exit', ['reference_no' => $trial->reference_no])); ?>" class="btn btn-primary btn-icon-only" title="Exit Form" target="_blank">
                                <i class="fas fa-file-export"></i>
                            </a>
                            <?php if(Auth::user()->role === 'Admin'): ?>
                                <form action="<?php echo e(route('candidates.destroy', $trial->reference_no)); ?>" method="POST" style="display:inline;" id="delete-form-<?php echo e($trial->reference_no); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="btn btn-danger btn-icon-only" onclick="confirmDelete('<?php echo e($trial->reference_no); ?>')" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>CN Number</th>
                <th>CL Number</th>
                <th>BIA/TA</th>
                <th>Candidate Name</th>
                <th>Sales Name</th>
                <th>Status Date</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Pagination">
    <div class="pagination-container">
        <span class="muted-text">Showing <?php echo e($trials->firstItem()); ?> to <?php echo e($trials->lastItem()); ?> of <?php echo e($trials->total()); ?> results</span>
        <ul class="pagination justify-content-center">
            <?php echo e($trials->links()); ?>

        </ul>
    </div>
</nav>
<div class="modal fade custom-modal" id="ConfirmedModal" tabindex="-1" aria-labelledby="ConfirmedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ConfirmedModalLabel">
                    <i class="fa-solid fa-circle-check text-light"></i> Trial Confirmed
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ConfirmedModalForm" enctype="multipart/form-data" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>
                            <label><i class="fas fa-building"></i> Candidate Name:</label>
                            <input type="text" id="ConfirmedModalcandidateName" name="candidate_name" class="form-control" readonly>
                            <input type="hidden" id="ConfirmedModalcandidateId" name="candidate_id" class="form-control" readonly>
                            <input type="hidden" name="trial_id" id="trial_id">
                        </p>
                        <p>
                            <label><i class="fas fa-building"></i> Employer Name:</label>
                            <input type="text" name="employer_name" id="ConfirmedModalclientName" class="form-control" readonly>
                        </p>
                    </div>
                    <div class="mb-4" id="InvoiceData"></div>
                    <div class="mb-3">
                        <label for="ConfirmedModalDate" class="form-label">
                            <i class="fas fa-calendar-day"></i> Confirmed Date
                        </label>
                        <input type="date" id="ConfirmedModalDate" class="form-control" name="confirmed_date" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="ConfirmedModalremainingAmountWithVat" class="form-label"><i class="fas fa-balance-scale"></i> Remaining Amount (Remaining Amount + VAT 5%)</label>
                        <input type="text" id="ConfirmedModalremainingAmountWithVat" name="remaining_amount" class="form-control" value="7000.00" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="paymentMethodForConfirmed" class="form-label">
                            <i class="fas fa-credit-card"></i> Payment Method
                        </label>
                        <select id="paymentMethodForConfirmed" name="payment_method" class="form-control">
                            <option value="" disabled selected>Select Payment Method</option>
                            <option value="Bank Transfer ADIB">Bank Transfer ADIB</option>
                            <option value="Bank Transfer ADCB">Bank Transfer ADCB</option>
                            <option value="POS ADCB">POS ADCB</option>
                            <option value="POS ADIB">POS ADIB</option>
                            <option value="Cash">Cash</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Replacement">Replacement</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ConfirmedModalpaymentProof" class="form-label"><i class="fas fa-upload"></i> Upload Payment Proof</label>
                        <input type="file" id="ConfirmedModalpaymentProof" class="form-control" name="payment_proof" accept="image/png, image/jpg, image/jpeg, application/pdf">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-info-circle"></i> Important Notes</label>
                        <ul class="list-group">
                            <li class="list-group-item">1 - Tax Invoice for final payment has done?</li>
                            <li class="list-group-item">2 - Contract has signed?</li>
                            <li class="list-group-item">3 - For change status, transaction must be done today.</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                    <button type="button" id="saveConfirmedModalButton" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade custom-modal" id="ChangeStatusModal" tabindex="-1" aria-labelledby="ChangeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ChangeStatusModalLabel">
                    <i class="fa-solid fa-circle-check text-info" style="color: #fff !important;"></i> Change Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#" enctype="multipart/form-data" id="ChangeStatusModalForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>
                            <strong><i class="fas fa-building"></i> Candidate Name:</strong>
                            <input type="text" id="ChangeStatusModalcandidateName" name="candidate_name" class="form-control" readonly>
                            <input type="hidden" id="ChangeStatusModalcandidateId" name="candidate_id" class="form-control" readonly>
                            <input type="hidden" name="trial_id" id="ChangeStatusModaltrial_id">
                        </p>
                        <p>
                            <strong><i class="fas fa-building"></i> Employer Name:</strong>
                            <input type="text" name="employer_name" id="ChangeStatusModalclientName" class="form-control" readonly>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="ChangeStatusModalDate" class="form-label"><i class="fas fa-calendar-day"></i> Change Status Date</label>
                        <input type="date" id="ChangeStatusModalDate" class="form-control" name="change_status_date">
                    </div>
                    <div class="mb-3">
                        <label for="ChangeStatusModalproof" class="form-label"><i class="fas fa-upload"></i> Upload Proof</label>
                        <input type="file" id="ChangeStatusModalproof" class="form-control" name="proof" accept="image/png, image/jpg, image/jpeg, application/pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                    <button type="button" id="saveChangeStatusModalButton" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade custom-modal" id="TrialReturnModal" tabindex="-1" aria-labelledby="TrialReturnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TrialReturnModalLabel">
                    <i class="fa-solid fa-clipboard-check text-info" style="color: #fff !important;"></i> Trial Return
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="TrialReturnModalForm" enctype="multipart/form-data" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>
                            <strong><i class="fas fa-building"></i> Candidate Name:</strong>
                            <input type="text" id="TrialReturnModalcandidateName" name="candidate_name" class="form-control" readonly>
                            <input type="hidden" id="TrialReturnModalcandidateId" name="candidate_id" class="form-control" readonly>
                            <input type="hidden" name="trial_id" id="TrialReturnModaltrial_id">
                        </p>
                        <p>
                            <strong><i class="fas fa-building"></i> Employer Name:</strong>
                            <input type="text" name="employer_name" id="TrialReturnModalclientName" class="form-control" readonly>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="TrialReturnProof" class="form-label"><i class="fas fa-upload"></i> Upload Proof</label>
                        <input type="file" id="TrialReturnProof" class="form-control" name="proof" accept="image/png, image/jpg, image/jpeg, application/pdf">
                    </div>
                    <div class="mb-3">
                        <label for="TrialReturnRemarks" class="form-label"><i class="fas fa-comment"></i> Remarks</label>
                        <textarea id="TrialReturnRemarks" class="form-control" name="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                    <button type="button" id="saveTrialReturnButton" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade custom-modal" id="SalesReturnModal" tabindex="-1" aria-labelledby="SalesReturnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SalesReturnModalLabel">
                    <i class="fa-solid fa-box-open text-info" style="color: #fff !important;"></i> Sales Return
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="SalesReturnModalForm" enctype="multipart/form-data" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>
                            <strong><i class="fas fa-building"></i> Candidate Name:</strong>
                            <input type="text" id="SalesReturnModalcandidateName" name="candidate_name" class="form-control" readonly>
                            <input type="hidden" id="SalesReturnModalcandidateId" name="candidate_id" class="form-control" readonly>
                            <input type="hidden" name="trial_id" id="SalesReturnModaltrial_id">
                        </p>
                        <p>
                            <strong><i class="fas fa-building"></i> Employer Name:</strong>
                            <input type="text" name="employer_name" id="SalesReturnModalclientName" class="form-control" readonly>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="SalesReturnProof" class="form-label"><i class="fas fa-upload"></i> Upload Proof</label>
                        <input type="file" id="SalesReturnProof" class="form-control" name="proof" accept="image/png, image/jpg, image/jpeg, application/pdf">
                    </div>
                    <div class="mb-3">
                        <label for="SalesReturnRemarks" class="form-label"><i class="fas fa-comment"></i> Remarks</label>
                        <textarea id="SalesReturnRemarks" class="form-control" name="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                    <button type="button" id="saveSalesReturnButton" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade custom-modal" id="IncidentModal" tabindex="-1" aria-labelledby="IncidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="IncidentModalLabel">
                    <i class="fa-solid fa-exclamation-triangle text-info" style="color: #fff !important;"></i> Incident
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="IncidentModalForm" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>
                            <strong>Candidate Name:</strong>
                            <input type="text" id="IncidentModalcandidateName" name="candidate_name" class="form-control" readonly>
                            <input type="hidden" id="IncidentModalcandidateId" name="candidate_id" class="form-control" readonly>
                            <input type="hidden" name="candidate_reference_no" id="candidate_reference_no">
                            <input type="hidden" name="foreign_partner" id="foreign_partner">
                            <input type="hidden" name="candidate_nationality" id="candidate_nationality">
                            <input type="hidden" name="candidate_passport_number" id="candidate_passport_number">
                            <input type="hidden" name="candidate_passport_expiry" id="candidate_passport_expiry">
                            <input type="hidden" name="candidate_dob" id="candidate_dob">
                            <input type="hidden" name="candidate_ref_no" id="ref_no">
                        </p>
                        <p>
                            <strong>Employer Name:</strong>
                            <input type="text" name="employer_name" id="IncidentModalclientName" class="form-control" readonly>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="IncidentProof" class="form-label">Upload Proof</label>
                        <input type="file" id="IncidentProof" class="form-control" name="proof" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="mb-3">
                        <label for="IncidentStatus" class="form-label">Incident Occurred After</label>
                        <select id="IncidentStatus" class="form-select" name="incident_status" required>
                            <option value="" disabled selected>Select Status</option>
                            <option value="After Trial">After Trial</option>
                            <option value="After Confirmed">After Confirmed</option>
                            <option value="After Change Status">After Change Status</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="IncidentRemarks" class="form-label">Remarks</label>
                        <textarea id="IncidentRemarks" class="form-control" name="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveIncidentButton" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function openDropdown(candidateId, buttonElement, candidateName) {
        $('.dropdown-container').hide();
        $('#fullscreenOverlay').fadeIn();
        const dropdownContainer = $(`#dropdownContainer-${candidateId}`);
        dropdownContainer.find('.candidate-name').text(candidateName);
        dropdownContainer.css({ display: 'block', opacity: 0 });
        dropdownContainer.animate({ opacity: 1 }, 300);
    }
    function closeAllDropdowns() {
        $('.dropdown-container').fadeOut();
        $('#fullscreenOverlay').fadeOut();
    }
    function confirmDelete(candidateRefNo) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${candidateRefNo}`).submit();
            }
        });
    }
    function showPreloader() {
        const preloaderHTML = `
            <div id="preloader" class="preloader-container">
                <div class="preloader-content">
                    <div class="spinner"></div>
                    <p>Loading...</p>
                </div>
            </div>
        `;
        $('body').append(preloaderHTML);
        $('#preloader').css({
            position: 'fixed',
            top: '0',
            left: '0',
            width: '100%',
            height: '100%',
            backgroundColor: 'rgba(255, 255, 255, 0.8)',
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            zIndex: '1050'
        });
        $('.preloader-content .spinner').css({
            width: '50px',
            height: '50px',
            border: '6px solid rgba(0, 0, 0, 0.1)',
            borderTopColor: '#007bff',
            borderRadius: '50%',
            animation: 'spin 1s linear infinite',
            marginBottom: '10px'
        });
        $('.preloader-content p').css({
            fontSize: '1rem',
            color: '#007bff',
            fontWeight: 'bold',
            textAlign: 'center'
        });
        const spinnerKeyframes = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        const styleTag = document.createElement('style');
        styleTag.textContent = spinnerKeyframes;
        document.head.appendChild(styleTag);
    }
    function hidePreloader() {
        $('#preloader').remove();
    }
    function trialChangeStatus(selectElement, trialId, candidateId, clientId) {
        const selectedStatus = selectElement.value;
        Swal.fire({
            title: `Change to "${selectedStatus}"`,
            text: `Are you sure you want to change the status to "${selectedStatus}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                updateTrialStatus(selectedStatus, trialId, candidateId, clientId);
            }
        });
    }
    function updateTrialStatus(status, trialId, candidateId, clientId) {
        const csrfToken = '<?php echo e(csrf_token()); ?>';
        const updateStatusUrl = "<?php echo e(route('employees.trial-status', ['candidate' => ':reference_no'])); ?>".replace(':reference_no', candidateId);
        showPreloader();
        let ajaxUrl = '';
        let modalId = '';
        let ajaxData = { trial_id: trialId, candidate_id: candidateId, client_id: clientId, status };
        switch (status) {
            case "Confirmed":
                ajaxUrl = updateStatusUrl;
                modalId = '#ConfirmedModal';
                break;
            case "Change Status":
                ajaxUrl = '<?php echo e(route('candidates.getChangeStatusDetails')); ?>';
                modalId = '#ChangeStatusModal';
                break;
            case "Trial Return":
                ajaxUrl = '<?php echo e(route('candidates.getChangeStatusDetails')); ?>';
                modalId = '#TrialReturnModal';
                break;
            case "Sales Return":
                ajaxUrl = '<?php echo e(route('candidates.getChangeStatusDetails')); ?>';
                modalId = '#SalesReturnModal';
                break;
            case "Incident":
                ajaxUrl = '<?php echo e(route('candidates.getChangeStatusDetails')); ?>';
                modalId = '#IncidentModal';
                break;
            default:
                toastr.error('Invalid status selected.');
                hidePreloader();
                return;
        }
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: ajaxData,
            success: function (response) {
                if (response.success) {
                    if (modalId) {
                        $(modalId).modal('show');
                        fillModalFields(modalId, response , trialId);
                    } else {
                        toastr.success(response.message || 'Status updated successfully!');
                        setTimeout(() => location.reload(), 2000);
                    }
                } else {
                    toastr.error(response.message || 'Failed to update status. Please try again.');
                }
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || 'An error occurred. Please try again.');
            },
            complete: function () {
                hidePreloader();
            }
        });
    }
    function fillModalFields(modalId, data ,trialId) {
        if (modalId === '#ConfirmedModal') {
            $('#trial_id').val(trialId|| '');
            $('#ConfirmedModalcandidateId').val(data.candidateDetails.candidateId || '');
            $('#ConfirmedModalcandidateName').val(data.candidateDetails.candidateName || '');
            $('#ConfirmedModalclientName').val(data.candidateDetails.clientName || '');
        }
        if (modalId === '#ChangeStatusModal') {
            $('#ChangeStatusModaltrial_id').val(trialId || '');
            $('#ChangeStatusModalcandidateId').val(data.candidateDetails.candidate_id || '');
            $('#ChangeStatusModalcandidateName').val(data.candidateDetails.candidate_name || '');
            $('#ChangeStatusModalclientName').val(data.candidateDetails.client_name || '');
        }
        if (modalId === '#TrialReturnModal') {
            $('#TrialReturnModaltrial_id').val(trialId || '');
            $('#TrialReturnModalcandidateId').val(data.candidateDetails.candidate_id || '');
            $('#TrialReturnModalcandidateName').val(data.candidateDetails.candidate_name || '');
            $('#TrialReturnModalclientName').val(data.candidateDetails.client_name || '');
        }
        if (modalId === '#SalesReturnModal') {
            $('#SalesReturnModaltrial_id').val(trialId || '');
            $('#SalesReturnModalcandidateId').val(data.candidateDetails.candidate_id || '');
            $('#SalesReturnModalcandidateName').val(data.candidateDetails.candidate_name || '');
            $('#SalesReturnModalclientName').val(data.candidateDetails.client_name || '');
        }
        if (modalId === '#IncidentModal') {
            $('#IncidentModalcandidateId').val(data.candidateDetails.candidate_id || '');
            $('#IncidentModalcandidateName').val(data.candidateDetails.candidate_name || '');
            $('#IncidentModalclientName').val(data.candidateDetails.client_name || '');
        }
        if (data.candidateDetails) {
            const { invoices, remainingAmountWithVat } = data.candidateDetails;
            if (invoices && invoices.length > 0) {
                let invoiceRows = '';
                invoices.forEach(invoice => {
                    invoiceRows += `
                        <tr>
                            <td>${invoice.invoice_date}</td>
                            <td>${parseFloat(invoice.total_amount).toFixed(2)}</td>
                            <td>${parseFloat(invoice.received_amount).toFixed(2)}</td>
                            <td>${(parseFloat(invoice.total_amount) - parseFloat(invoice.received_amount)).toFixed(2)}</td>
                            <td>
                                <a href="/invoices/${invoice.invoice_number}" target="_blank" class="btn btn-light btn-sm">
                                    <i class="fas fa-external-link-alt"></i> ${invoice.invoice_number}
                                </a>
                            </td>
                        </tr>`;
                });
                $('#InvoiceData').html(`
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Received Amount</th>
                                <th>Remaining Amount</th>
                                <th>Invoice Reference #</th>
                            </tr>
                        </thead>
                        <tbody>${invoiceRows}</tbody>
                    </table>`);
                $('#remainingAmount').val(remainingAmountWithVat.toFixed(2));
            } else {
                $('#InvoiceData').html('<p class="text-danger">No invoices found.</p>');
            }
        }
    }
    $('#saveConfirmedModalButton').on('click', function () {
        const button = $(this);
        const form = $('#ConfirmedModalForm')[0];
        const formData = new FormData(form);
        const csrfToken = '<?php echo e(csrf_token()); ?>';
        let isValid = true;
        const requiredFields = [
            { id: '#ConfirmedModalclientName', message: 'Employer Name is required.' },
            { id: '#ConfirmedModalDate', message: 'Confirmed Date is required.' },
            { id: '#paymentMethodForConfirmed', message: 'Payment method is required.' },
        ];
        requiredFields.forEach(field => {
            if (!$(field.id).val().trim()) {
                isValid = false;
                toastr.error(field.message);
            }
        });
        if (!$('#ConfirmedModalpaymentProof')[0].files.length) {
            isValid = false;
            toastr.error('Payment proof is required.');
        }
        if (!isValid) return;
        button.prop('disabled', true);
        $.ajax({
            url: '<?php echo e(route('candidates.saveTrialConfirmed')); ?>',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#ConfirmedModal').modal('hide');
                    $('#ConfirmedModalForm')[0].reset();
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(response.message || 'Failed to save confirmed trial.');
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    Object.values(xhr.responseJSON.errors).forEach(errorMessages => {
                        errorMessages.forEach(error => toastr.error(error));
                    });
                } else {
                    toastr.error('An error occurred while saving the confirmed trial.');
                }
            },
            complete: function () {
                button.prop('disabled', false);
            }
        });
    });
    document.getElementById('saveChangeStatusModalButton').addEventListener('click', function () {
        const button = this;
        const form = document.getElementById('ChangeStatusModalForm');
        const formData = new FormData(form);
        const trialId = formData.get('trial_id');
        const candidateId = formData.get('candidate_id');
        const changeStatusDate = formData.get('change_status_date');
        const proof = formData.get('proof');
        if (!trialId || !candidateId || !changeStatusDate || !proof) {
            toastr.error('All fields are required.');
            return;
        }
        button.disabled = true;
        fetch('<?php echo e(route("candidates.updateChangeStatus")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    $('#ChangeStatusModal').modal('hide');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(data.message || 'Failed to update status. Please try again.');
                }
            })
            .catch(() => toastr.error('An error occurred while updating the status. Please try again.'))
            .finally(() => button.disabled = false);
    });
    document.getElementById('saveTrialReturnButton').addEventListener('click', function () {
        const button = this;
        const form = document.getElementById('TrialReturnModalForm');
        const formData = new FormData(form);
        button.disabled = true;
        fetch('<?php echo e(route("candidates.saveTrialReturn")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message || 'Trial Return saved successfully.');
                    $('#TrialReturnModal').modal('hide');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(data.message || 'Failed to save Trial Return.');
                }
            })
            .catch(() => toastr.error('An error occurred while saving Trial Return.'))
            .finally(() => button.disabled = false);
    });
    document.getElementById('saveSalesReturnButton').addEventListener('click', function () {
        const button = this;
        const form = document.getElementById('SalesReturnModalForm');
        const formData = new FormData(form);
        button.disabled = true;
        fetch('<?php echo e(route("candidates.saveSalesReturn")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message || 'Sales Return saved successfully.');
                    $('#SalesReturnModal').modal('hide');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(data.message || 'Failed to save Sales Return.');
                }
            })
            .catch(() => toastr.error('An error occurred while saving Sales Return.'))
            .finally(() => button.disabled = false);
    });
    document.getElementById('saveIncidentButton').addEventListener('click', function () {
        const button = this;
        const form = document.getElementById('IncidentModalForm');
        const formData = new FormData(form);
        button.disabled = true;
        fetch('<?php echo e(route("candidates.saveReturnIncident")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            },
            body: formData,
        })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    toastr.success(data.message || 'Incident saved successfully.');
                    $('#IncidentModal').modal('hide');
                    form.reset();
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(data.message || 'Failed to save Incident.');
                }
            })
            .catch(() => toastr.error('An error occurred while saving the Incident. Please check your inputs.'))
            .finally(() => button.disabled = false);
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/partials/trial_candidates_table.blade.php ENDPATH**/ ?>