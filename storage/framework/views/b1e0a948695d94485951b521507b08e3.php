<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
  .nav-tabs .nav-link{transition:background-color .2s;color:#495057;font-size:12px;text-transform:uppercase}
  .nav-tabs .nav-link:hover{background-color:#f8f9fa}
  .nav-tabs .nav-link.active{background-color:#007bff;color:#fff}
  .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:normal}
  .muted-text{color:#6c757d;font-size:12px}
  .table-container{width:100%;overflow-x:auto;position:relative}
  .table{width:100%;border-collapse:collapse;margin-bottom:20px}
  .table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .table th{background-color:#343a40;color:#fff;text-transform:uppercase;font-weight:bold}
  .table-hover tbody tr:hover{background-color:#f1f1f1}
  .table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}
  .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
  .btn-danger{background-color:#dc3545}
  /*.fullscreen-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,.5);z-index:1049}*/
  .dropdown-container{display:none;position:fixed;z-index:1050;background:#fff;border-radius:8px;padding:20px;box-shadow:0 8px 12px rgba(0,0,0,.2);min-width:350px;max-width:450px;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border:4px solid #007bff;animation:fadeIn .3s ease-in-out}
  .dropdown-header{margin-bottom:15px}
  .dropdown-header .header-icon{font-size:24px;color:#007bff;margin-bottom:10px}
  .dropdown-header p{font-size:12px;font-weight:bold;color:#333;margin:5px 0;line-height:1.5}
  .employee-name{color:#007bff;font-weight:bold;font-size:12px}
  .status-dropdown{width:100%;margin-top:10px;font-size:12px;border:2px solid #007bff;border-radius:6px;background:#fff;color:#333}
  .close-icon{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer;transition:color .3s}
  .close-icon:hover{color:#ff4500}
  @keyframes fadeIn{from{opacity:0;transform:translate(-50%,-55%)}to{opacity:1;transform:translate(-50%,-50%)}}
  .custom-modal .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3);font-size:12px;background:#fff}
  .custom-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0}
  .custom-modal .modal-header h5{font-size:12px;font-weight:bold;margin:0}
  .custom-modal .modal-body{padding:20px;color:#333;background:#f9f9f9}
  .custom-modal .modal-footer{padding:15px;border-top:1px solid #ddd;border-radius:0 0 12px 12px;background:#f1f1f1}
  .pagination-controls{display:flex;justify-content:center;margin-bottom:10px;align-items:center;gap:20px}
  .pagination-controls i{font-size:12px;cursor:pointer;color:#343a40}
  .pagination-controls i.disabled{color:#ccc;cursor:not-allowed}
</style>

<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>BIA#</th>
        <th>Full Name</th>
        <th>Sales Name</th>
        <th>Status</th>
        <th>Date</th>
        <th>Nationality</th>
        <th>Partner</th>
        <th>Client Name</th>
        <th>Current Visa</th>
        <th>Arrived Date</th>
        <th>Return Date</th>
        <th>Expiry Date</th>
        <th>Overstay</th>
        <th>Trial Start</th>
        <th>Trial End</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if($packages->isEmpty()): ?>
        <tr>
          <td colspan="17" class="text-center">No results found.</td>
        </tr>
      <?php else: ?>
        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $today   = \Carbon\Carbon::now('Asia/Dubai');
            $end     = \Carbon\Carbon::parse($trial->trial_end_date);
            $rowStyle = $end->isSameDay($today) ? 'background-color:#ffc107!important;' : ($end->lessThan($today) ? 'background-color:#dc3545!important;' : '');
            $timeDisplay = $end->isPast() ? ('Expired '.$end->diffForHumans($today, ['parts'=>2,'join'=>', '])) : $end->diffForHumans($today, ['parts'=>2,'join'=>', ']);
            $buttonClass = ($end->isPast() || $today->diffInHours($end,false) <= 24) ? 'btn-danger' : 'btn-secondary';
            $config = [
              'Active'        => ['class'=>'btn-success','icon'=>'fas fa-check-circle'],
              'Confirmed'     => ['class'=>'btn-primary','icon'=>'fas fa-user-check'],
              'Change Status' => ['class'=>'btn-warning','icon'=>'fas fa-exchange-alt'],
              'Sales Return'  => ['class'=>'btn-danger','icon'=>'fas fa-undo'],
              'Incident'      => ['class'=>'btn-dark','icon'=>'fas fa-exclamation-triangle'],
              'Trial Return'  => ['class'=>'btn-secondary','icon'=>'fas fa-arrow-circle-left'],
              'Contracted'    => ['class'=>'btn-primary','icon'=>'fas fa-user-check'],
            ];
            $c = $config[$trial->trial_status] ?? ['class'=>'btn-light','icon'=>'fas fa-info-circle'];
          ?>

          <tr style="<?php echo e($rowStyle); ?>">
            <td><a href="#" target="_blank" class="text-dark text-decoration-none"><?php echo e(strtoupper($trial->agreement_reference_no ?? '')); ?></a></td>
            <td><?php echo e(strtoupper($trial->candidate_name)); ?></td>
            <td><?php echo e(strtoupper($trial->sales_name)); ?></td>
            <td><button class="btn <?php echo e($c['class']); ?> btn-sm"><i class="<?php echo e($c['icon']); ?>"></i> <?php echo e($trial->trial_status); ?></button></td>
            <td><?php echo e($trial->created_at ? \Carbon\Carbon::parse($trial->created_at)->format('d M Y') : '-'); ?></td>
            <td><?php echo e(strtoupper($trial->nationality)); ?></td>
            <td title="<?php echo e(strtoupper($trial->foreign_partner)); ?>"><?php echo e(strtoupper(strtok($trial->foreign_partner, ' '))); ?></td>
            <td><a href="#" class="text-dark text-decoration-none" target="_blank"><?php echo e(strtoupper($trial->first_name ?? '')); ?> <?php echo e(strtoupper($trial->last_name ?? '')); ?></a></td>
            <td><?php echo e(strtoupper($trial->visa_type)); ?></td>
            <td><?php echo e($trial->arrived_date ? \Carbon\Carbon::parse($trial->arrived_date)->format('d M Y') : '-'); ?></td>
            <td><?php echo e($trial->returned_date ? \Carbon\Carbon::parse($trial->returned_date)->format('d M Y') : '-'); ?></td>
            <td><?php echo e($trial->expiry_date ? \Carbon\Carbon::parse($trial->expiry_date)->format('d M Y') : '-'); ?></td>
            <td><?php echo e($trial->overstay_days); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($trial->trial_start_date)->format('d M Y')); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($trial->trial_end_date)->format('d M Y')); ?></td>
            <td><?php echo e($trial->description); ?></td>
            <td class="actions">
              <?php if($trial->trial_status==='Active'): ?>
                <a href="javascript:void(0)" class="btn <?php echo e($buttonClass); ?> btn-sm"><i class="fas fa-clock"></i> <?php echo e($timeDisplay); ?></a>
              <?php endif; ?>
              <a href="<?php echo e(route('package.exit', ['reference_no' => $trial->cn_number_series])); ?>" class="btn btn-primary btn-icon-only" title="Exit Form" target="_blank">
                <i class="fas fa-file-export"></i>
              </a>
              <a href="javascript:void(0)" class="btn btn-primary btn-icon-only" title="Change Status" onclick="openDropdown('<?php echo e($trial->id); ?>','<?php echo e(strtoupper($trial->candidate_name)); ?>')">
                <i class="fas fa-train"></i>
              </a>

              <div class="dropdown-container" id="dropdownContainer-<?php echo e($trial->id); ?>">
                <div class="close-icon" onclick="closeAllDropdowns()"><i class="fas fa-times-circle"></i></div>
                <div class="dropdown-header">
                  <div class="header-icon"><i class="fas fa-info-circle"></i></div>
                  <p>Do you want to change the status of</p>
                  <p>candidate <span class="employee-name"><?php echo e(strtoupper($trial->candidate_name)); ?></span>?</p>
                </div>
                <select class="form-control status-dropdown" onchange="trialChangeStatus(this.value, <?php echo e($trial->trial_id); ?>, <?php echo e($trial->id); ?>, <?php echo e($trial->client_id); ?>)">
                  <?php if($trial->trial_status==='Active'): ?>
                    <option disabled selected>Active</option>
                    <option>Contracted</option>
                    <option>Trial Return</option>
                    <option>Incident</option>
                  <?php elseif($trial->trial_status==='Contracted'): ?>
                    <option disabled selected>Contracted</option>
                    <option>Change Status</option>
                    <option>Sales Return</option>
                    <option>Incident</option>
                  <?php elseif($trial->trial_status==='Change Status'): ?>
                    <option disabled selected>Change Status</option>
                    <option>Sales Return</option>
                    <option>Incident</option>
                  <?php else: ?>
                    <option disabled selected><?php echo e($trial->trial_status); ?></option>
                  <?php endif; ?>
                </select>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <th>BIA#</th>
        <th>Full Name</th>
        <th>Sales Name</th>
        <th>Status</th>
        <th>Date</th>
        <th>Nationality</th>
        <th>Partner</th>
        <th>Client Name</th>
        <th>Current Visa</th>
        <th>Arrived Date</th>
        <th>Return Date</th>
        <th>Expiry Date</th>
        <th>Overstay</th>
        <th>Trial Start</th>
        <th>Trial End</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>
</div>

<div class="fullscreen-overlay" id="fullscreenOverlay" onclick="closeAllDropdowns()"></div>

<nav aria-label="Page navigation">
  <div class="pagination-container d-flex align-items-center justify-content-between">
    <span class="muted-text">Showing <?php echo e($packages->firstItem()); ?> to <?php echo e($packages->lastItem()); ?> of <?php echo e($packages->total()); ?> results</span>
    <ul class="pagination justify-content-center mb-0">
      <?php echo e($packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

    </ul>
  </div>
</nav>

<div class="modal fade custom-modal" id="ContractedModal" tabindex="-1" aria-labelledby="ContractedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title" id="ContractedModalLabel"><i class="fa-solid fa-circle-check text-light"></i> Contracted</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <form id="ContractedModalForm" enctype="multipart/form-data" method="POST">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="mb-3">
            <p><label><i class="fas fa-building"></i> Candidate Name:</label>
              <input type="text" id="ContractedModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="ContractedModalcandidateId" name="candidate_id" readonly>
              <input type="hidden" name="trial_id" id="trial_id">
              <input type="hidden" name="client_id" id="client_id">
            </p>
            <p><label><i class="fas fa-building"></i> Employer Name:</label>
              <input type="text" name="employer_name" id="ContractedModalclientName" class="form-control" readonly>
            </p>
          </div>
          <div class="mb-4" id="InvoiceData"></div>
          <div class="mb-3">
            <label for="ContractedModalDate" class="form-label"><i class="fas fa-calendar-day"></i> Contracted Date</label>
            <input type="date" id="ContractedModalDate" class="form-control" name="confirmed_date" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>">
          </div>
          <div class="row mb-3">
            <div class="col-md-6"><label for="ContractedModalremainingAmountWithVat" class="form-label"><i class="fas fa-balance-scale"></i> Remaining Amount</label><input type="text" id="ContractedModalremainingAmountWithVat" name="remaining_amount" class="form-control" value="0" readonly></div>
            <div class="col-md-6"><label for="ContractedModalreceivedAmount" class="form-label"><i class="fas fa-money-bill-wave"></i> Received Amount *</label><input type="number" id="ContractedModalreceivedAmount" name="received_amount" class="form-control" min="0" required></div>
          </div>
          <div class="mb-3">
            <label for="paymentMethodForConfirmed" class="form-label"><i class="fas fa-credit-card"></i> Payment Method</label>
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
          <div class="mb-3"><label for="ContractedModalpaymentProof" class="form-label"><i class="fas fa-upload"></i> Upload Payment Proof</label><input type="file" id="ContractedModalpaymentProof" class="form-control" name="payment_proof" accept="image/png,image/jpg,image/jpeg,application/pdf"></div>
          <div class="mb-3">
            <label class="form-label"><i class="fas fa-info-circle"></i> Important Notes</label>
            <ul class="list-group">
              <li class="list-group-item">1 - Tax Invoice for final payment has done?</li>
              <li class="list-group-item">2 - Contract has signed?</li>
              <li class="list-group-item">3 - For change status, transaction must be done today.</li>
            </ul>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button><button type="button" id="saveContractedModalButton" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button></div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="ChangeStatusModal" tabindex="-1" aria-labelledby="ChangeStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title" id="ChangeStatusModalLabel"><i class="fa-solid fa-circle-check text-info"></i> Change Status</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <form method="POST" enctype="multipart/form-data" id="ChangeStatusModalForm"><?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="mb-3">
            <p><strong><i class="fas fa-building"></i> Candidate Name:</strong>
              <input type="text" id="ChangeStatusModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="ChangeStatusModalcandidateId" name="candidate_id" readonly>
              <input type="hidden" name="trial_id" id="ChangeStatusModaltrial_id">
            </p>
            <p><strong><i class="fas fa-building"></i> Employer Name:</strong><input type="text" name="employer_name" id="ChangeStatusModalclientName" class="form-control" readonly></p>
          </div>
          <div class="mb-3"><label for="ChangeStatusModalDate" class="form-label"><i class="fas fa-calendar-day"></i> Change Status Date</label><input type="date" id="ChangeStatusModalDate" class="form-control" name="change_status_date" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>"></div>
          <div class="mb-3"><label for="ChangeStatusModalproof" class="form-label">Change Status Proof (Include Visa + WC)</label><input type="file" id="ChangeStatusModalproof" class="form-control" name="change_status_proof" accept="image/png,image/jpg,image/jpeg,application/pdf"></div>
          <div class="mb-3"><label for="penaltyPaymentAmount" class="form-label">Penality Payment Amount</label><input type="text" id="penaltyPaymentAmount" class="form-control" name="penalty_payment_amount" placeholder="Enter penalty amount if any"></div>
          <div class="mb-3"><label for="penaltyPaymentProof" class="form-label">Penality Payment Amount Proof (If Overstay)</label><input type="file" id="penaltyPaymentProof" class="form-control" name="penalty_payment_proof" accept="image/png,image/jpg,image/jpeg,application/pdf"></div>
          <div class="mb-3"><label for="penaltyPaidBy" class="form-label">Penality Amount Paid By</label>
            <select id="penaltyPaidBy" name="penalty_paid_by" class="form-select" style="font-size:12px">
              <option value="" disabled selected>Select who paid the penalty</option>
              <option value="Customer">Customer</option>
              <option value="Office">Office</option>
              <option value="Candidate">Candidate</option>
            </select>
          </div>
          <div class="mb-3"><label for="istirahaProof" class="form-label">Istiraha Proof</label><input type="file" id="istirahaProof" class="form-control" name="istiraha_proof" accept="image/png,image/jpg,image/jpeg,application/pdf"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button><button type="button" id="saveChangeStatusModalButton" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button></div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="TrialReturnModal" tabindex="-1" aria-labelledby="TrialReturnModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title" id="TrialReturnModalLabel"><i class="fa-solid fa-clipboard-check text-info"></i> Trial Return</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <form id="TrialReturnModalForm" enctype="multipart/form-data" method="POST"><?php echo csrf_field(); ?>
        <input type="hidden" name="customer_decision" id="tr_customer_decision" value="Refund">
        <div class="modal-body">
          <div class="mb-3">
            <p><strong><i class="fas fa-building"></i> Candidate Name:</strong>
              <input type="text" id="TrialReturnModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="TrialReturnModalcandidateId" name="candidate_id" readonly>
              <input type="hidden" name="trial_id" id="TrialReturnModaltrial_id">
            </p>
            <p><strong><i class="fas fa-building"></i> Employer Name:</strong><input type="text" name="employer_name" id="TrialReturnModalclientName" class="form-control" readonly></p>
          </div>

          <div id="tr_no_agreement" class="alert alert-warning d-none">There is no agreement exist related this candidate.</div>

          <div class="card border-warning mb-3" id="tr_agreement_card">
            <div class="card-body mt-2">
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <h6 class="m-0 fw-semibold"><i class="fas fa-file-contract me-1"></i> Agreement Details</h6>
              </div>

              <div class="d-flex gap-4 align-items-center flex-wrap mt-2">
                <div class="form-check m-0">
                  <input class="form-check-input" type="checkbox" id="tr_decision_refund" checked>
                  <label class="form-check-label" for="tr_decision_refund">Refund</label>
                </div>
                <div class="form-check m-0">
                  <input class="form-check-input" type="checkbox" id="tr_decision_replacement">
                  <label class="form-check-label" for="tr_decision_replacement">Replacement</label>
                </div>
              </div>

              <div class="mt-2">
                <div class="table-responsive">
                  <table class="table table-bordered align-middle mb-0">
                    <tbody>
                      <tr>
                        <th style="width:45%;">Agreement Reference No</th>
                        <td><input type="text" id="tr_agreement_reference_no_text" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th>Contract Start Date</th>
                        <td><input type="text" id="tr_contract_start_date" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th>Contract End Date</th>
                        <td><input type="text" id="tr_contract_end_date" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th>Total Amount</th>
                        <td><input type="text" id="tr_total_amount" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th>Received Amount</th>
                        <td><input type="text" id="tr_received_amount" name="received_amount" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th>Office Charges</th>
                        <td><input type="number" min="0" step="0.01" id="tr_office_charges" name="office_charges" class="form-control form-control-sm" value="0"></td>
                      </tr>
                      <tr>
                        <th><span id="tr_balance_label">Refund Balance</span></th>
                        <td><input type="text" id="tr_balance_amount" name="balance_amount" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th><span id="tr_due_label">Refund Due Date</span></th>
                        <td><input type="date" id="tr_due_date" name="refund_due_date" class="form-control form-control-sm" autocomplete="off"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>

          <div class="mb-3"><label for="TrialReturnProof" class="form-label"><i class="fas fa-upload"></i> Upload Proof</label><input type="file" id="TrialReturnProof" class="form-control" name="proof" accept="image/png,image/jpg,image/jpeg,application/pdf"></div>
          <div class="mb-3"><label for="TrialReturnRemarks" class="form-label"><i class="fas fa-comment"></i> Remarks</label><textarea id="TrialReturnRemarks" class="form-control" name="remarks" rows="3"></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button><button type="button" id="saveTrialReturnButton" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button></div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="SalesReturnModal" tabindex="-1" aria-labelledby="SalesReturnModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title" id="SalesReturnModalLabel"><i class="fa-solid fa-box-open text-info"></i> Sales Return</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <form id="SalesReturnModalForm" enctype="multipart/form-data" method="POST"><?php echo csrf_field(); ?>
        <input type="hidden" name="customer_decision" id="sr_customer_decision" value="Refund">
        <div class="modal-body">
          <div class="mb-3">
            <p><strong><i class="fas fa-building"></i> Candidate Name:</strong>
              <input type="text" id="SalesReturnModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="SalesReturnModalcandidateId" name="candidate_id" readonly>
              <input type="hidden" name="trial_id" id="SalesReturnModaltrial_id">
            </p>
            <p><strong><i class="fas fa-building"></i> Employer Name:</strong><input type="text" name="employer_name" id="SalesReturnModalclientName" class="form-control" readonly></p>
          </div>

          <div id="sr_no_agreement" class="alert alert-warning d-none">There is no agreement exist related this candidate.</div>

          <div class="card border-warning mb-3" id="sr_agreement_card">
            <div class="card-body mt-2">
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <h6 class="m-0 fw-semibold"><i class="fas fa-file-contract me-1"></i> Agreement Details</h6>
              </div>

              <div class="d-flex gap-4 align-items-center flex-wrap mt-2">
                <div class="form-check m-0">
                  <input class="form-check-input" type="checkbox" id="sr_decision_refund" checked>
                  <label class="form-check-label" for="sr_decision_refund">Refund</label>
                </div>
                <div class="form-check m-0">
                  <input class="form-check-input" type="checkbox" id="sr_decision_replacement">
                  <label class="form-check-label" for="sr_decision_replacement">Replacement</label>
                </div>
              </div>

              <div class="mt-2">
                <div class="table-responsive">
                  <table class="table table-bordered align-middle mb-0">
                    <tbody>
                      <tr>
                        <th style="width:45%;">Agreement Reference No</th>
                        <td><input type="text" id="sr_agreement_reference_no_text" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th>Contract Start Date</th>
                        <td><input type="text" id="sr_contract_start_date" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th>Contract End Date</th>
                        <td><input type="text" id="sr_contract_end_date" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th>Total Amount</th>
                        <td><input type="text" id="sr_total_amount" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th>Received Amount</th>
                        <td><input type="text" id="sr_received_amount" name="received_amount" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th>Office Charges</th>
                        <td><input type="number" min="0" step="0.01" id="sr_office_charges" name="office_charges" class="form-control form-control-sm" value="0"></td>
                      </tr>
                      <tr>
                        <th><span id="sr_balance_label">Refund Balance</span></th>
                        <td><input type="text" id="sr_balance_amount" name="balance_amount" class="form-control form-control-sm" readonly></td>
                      </tr>
                      <tr>
                        <th><span id="sr_due_label">Refund Due Date</span></th>
                        <td><input type="date" id="sr_due_date" name="refund_due_date" class="form-control form-control-sm" autocomplete="off"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>

          <div class="mb-3"><label for="SalesReturnProof" class="form-label"><i class="fas fa-upload"></i> Upload Proof</label><input type="file" id="SalesReturnProof" class="form-control" name="proof" accept="image/png,image/jpg,image/jpeg,application/pdf"></div>
          <div class="mb-3"><label for="SalesReturnRemarks" class="form-label"><i class="fas fa-comment"></i> Remarks</label><textarea id="SalesReturnRemarks" class="form-control" name="remarks" rows="3"></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button><button type="button" id="saveSalesReturnButton" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button></div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="incidentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="incidentForm" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <input type="hidden" id="im_refund_type" name="refund_type" value="package">
      <input type="hidden" id="im_refund_type_label" name="refund_type_label" value="Inside - All">
      <input type="hidden" id="im_trial_id" name="trial_id">
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
      <input type="hidden" id="im_customer_decision" name="customer_decision" value="Refund">

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
              <input type="text" id="im_incident_category" name="incident_category" class="form-control form-control-sm" value="Inside - All" readonly>
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

          <div class="card border-warning mb-3 incident-agreement-card" id="im_agreement_card">
            <div class="card-body mt-2">
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <h6 class="m-0 fw-semibold"><i class="fas fa-file-contract me-1"></i> Agreement Details</h6>
              </div>

              <div class="d-flex gap-4 align-items-center flex-wrap mt-2">
                <div class="form-check m-0">
                  <input class="form-check-input" type="checkbox" id="im_decision_refund" checked>
                  <label class="form-check-label" for="im_decision_refund">Refund</label>
                </div>
                <div class="form-check m-0">
                  <input class="form-check-input" type="checkbox" id="im_decision_replacement">
                  <label class="form-check-label" for="im_decision_replacement">Replacement</label>
                </div>
              </div>

              <div class="mt-2">
                <div class="table-responsive">
                  <table class="table table-bordered align-middle mb-0 incident-agreement-table">
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
                        <td><input type="date" id="im_due_date" name="refund_due_date" class="form-control form-control-sm" autocomplete="off"></td>
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
(function ($, w, d) {
  'use strict';

  const csrfToken = '<?php echo e(csrf_token()); ?>';

  function showPreloader(){
    if(d.getElementById('preloader')) return;
    $('body').append('<div id="preloader" class="preloader-container"><div class="preloader-content"><div class="spinner"></div><p>Loading...</p></div></div>');
    $('#preloader').css({position:'fixed',top:0,left:0,width:'100%',height:'100%',backgroundColor:'rgba(255,255,255,.8)',display:'flex',justifyContent:'center',alignItems:'center',zIndex:2000});
    $('.preloader-content .spinner').css({width:'50px',height:'50px',border:'6px solid rgba(0,0,0,.1)',borderTopColor:'#007bff',borderRadius:'50%',animation:'spin 1s linear infinite',marginBottom:'10px'});
    $('.preloader-content p').css({fontSize:'1rem',color:'#007bff',fontWeight:'bold',textAlign:'center'});
    if(!d.getElementById('preloader-kf')){
      const t=d.createElement('style');t.id='preloader-kf';t.textContent='@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}';d.head.appendChild(t);
    }
  }
  function hidePreloader(){ $('#preloader').remove(); }

  function closeAllDropdowns(){
    $('.dropdown-container').fadeOut(120);
    $('#fullscreenOverlay').fadeOut(120);
    $('.status-dropdown').each(function(){ this.selectedIndex = 0; });
  }

  function openDropdown(candidateId, candidateName){
    $('.dropdown-container').hide();
    $('#fullscreenOverlay').fadeIn(120);
    const box=$('#dropdownContainer-'+candidateId);
    box.find('.employee-name').text(String(candidateName||''));
    box.stop(true,true).css({display:'block',opacity:0}).animate({opacity:1},160);
  }

  function parseErrorPayload(status, headers, raw){
    const ct=headers.get('content-type')||'';
    if(ct.includes('application/json')){
      if(raw && typeof raw==='object'){
        if(status===422 && raw.errors){
          const messages=[];
          Object.values(raw.errors).forEach(arr=>(arr||[]).forEach(m=>messages.push(m)));
          return messages.length?messages:['Validation error.'];
        }
        if(raw.message) return [raw.message];
      }
      return [`Request failed (${status}).`];
    }
    const text=typeof raw==='string'?raw:'';
    if(status===419) return ['Page expired. Refresh and try again.'];
    if(status===403) return ['Forbidden'];
    if(status===404) return ['Not found'];
    return text ? [text.substring(0,300)] : [`Request failed (${status}).`];
  }

  async function handleFetch(url, options){
    const baseHeaders={'X-CSRF-TOKEN':csrfToken,'X-Requested-With':'XMLHttpRequest','Accept':'application/json'};
    const opt=Object.assign({method:'POST',headers:baseHeaders,credentials:'same-origin'},options||{});
    const isFormData = opt.body instanceof FormData;
    const isUrlParams = opt.body instanceof URLSearchParams;
    if(opt.headers && opt.headers instanceof Headers===false) opt.headers=Object.assign({},baseHeaders,opt.headers||{});
    if(!isFormData){
      if(isUrlParams) opt.body = opt.body.toString();
      opt.headers = Object.assign({}, opt.headers, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'});
    }
    const res=await fetch(url,opt);
    const ct=res.headers.get('content-type')||'';
    const data=ct.includes('application/json')?await res.json().catch(()=>({})):await res.text().catch(()=>(''));
    if(!res.ok){
      const messages=parseErrorPayload(res.status,res.headers,data);
      const err=new Error(messages[0]||`HTTP ${res.status}`);
      err.messages=messages;
      err.status=res.status;
      throw err;
    }
    return data;
  }

  function showErrors(msgs){ (msgs||[]).forEach(m=>toastr.error(m)); }
  function showSuccess(msg){ toastr.success(msg||'Success.'); }

  function n(v){
    const x=parseFloat(String(v??'').replace(/[^0-9.\-]/g,''));
    return Number.isFinite(x)?x:0;
  }
  function f2(x){ return (Number.isFinite(x)?x:0).toFixed(2); }

  function pick(obj, keys, fallback){
    for(let i=0;i<keys.length;i++){
      const k=keys[i];
      if(obj && obj[k]!==undefined && obj[k]!==null && String(obj[k]).length) return obj[k];
    }
    return fallback;
  }

  function ymd(dt){
    const d0 = new Date(dt.getTime());
    d0.setHours(0,0,0,0);
    const y=d0.getFullYear();
    const m=String(d0.getMonth()+1).padStart(2,'0');
    const dd=String(d0.getDate()).padStart(2,'0');
    return y+'-'+m+'-'+dd;
  }

  function minDueDate(){
    const t=new Date();
    t.setHours(0,0,0,0);
    t.setDate(t.getDate()+7);
    return t;
  }

  function parseYMD(v){
    const s=String(v||'').trim();
    if(!s) return null;
    const parts=s.split('-');
    if(parts.length!==3) return null;
    const y=parseInt(parts[0],10);
    const m=parseInt(parts[1],10);
    const d2=parseInt(parts[2],10);
    if(!Number.isFinite(y)||!Number.isFinite(m)||!Number.isFinite(d2)) return null;
    const dt=new Date(y,m-1,d2);
    dt.setHours(0,0,0,0);
    if(dt.getFullYear()!==y || dt.getMonth()!==m-1 || dt.getDate()!==d2) return null;
    return dt;
  }

  function dueLabel(prefix){
    const isRefund = $('#'+prefix+'_decision_refund').is(':checked');
    return isRefund ? 'Refund Due Date' : 'Replacement Due Date';
  }

  function applyDueDateRules(prefix){
    const el = $('#'+prefix+'_due_date');
    if(!el.length) return;
    const minD = minDueDate();
    el.attr('min', ymd(minD));
  }

  function validateDueDate(prefix){
    const el = $('#'+prefix+'_due_date');
    if(!el.length) return true;
    const v = String(el.val()||'').trim();
    if(!v) return true;

    const dt = parseYMD(v);
    if(!dt){
      toastr.error(dueLabel(prefix)+' is invalid.');
      el.val('');
      return false;
    }

    const minD = minDueDate();
    if(dt.getTime() < minD.getTime()){
      toastr.error(dueLabel(prefix)+' must be at least 7 days from today.');
      el.val('');
      return false;
    }

    if(dt.getDay()===0){
      toastr.error('Sunday is off. Please choose another date.');
      el.val('');
      return false;
    }

    return true;
  }

  function setDecision(prefix, mode){
    const isRefund=(mode==='Refund');
    $('#'+prefix+'_decision_refund').prop('checked',isRefund);
    $('#'+prefix+'_decision_replacement').prop('checked',!isRefund);
    $('#'+prefix+'_balance_label').text(isRefund?'Refund Balance':'Replacement Balance');
    $('#'+prefix+'_due_label').text(isRefund?'Refund Due Date':'Replacement Due Date');
    const hiddenId = (prefix==='im') ? 'im_customer_decision' : (prefix==='tr' ? 'tr_customer_decision' : 'sr_customer_decision');
    $('#'+hiddenId).val(isRefund?'Refund':'Replacement');
    applyDueDateRules(prefix);
    validateDueDate(prefix);
  }

  function enforceDecision(prefix){
    const r = $('#'+prefix+'_decision_refund');
    const p = $('#'+prefix+'_decision_replacement');
    if(!r.length || !p.length) return;
    if(!r.is(':checked') && !p.is(':checked')){ setDecision(prefix,'Refund'); return; }
    if(r.is(':checked') && p.is(':checked')){ setDecision(prefix,'Refund'); return; }
    if(r.is(':checked')) setDecision(prefix,'Refund');
    if(p.is(':checked')) setDecision(prefix,'Replacement');
  }

  function calcBalance(prefix){
    const received = n($('#'+prefix+'_received_amount').val());
    let charges = n($('#'+prefix+'_office_charges').val());
    if(charges < 0) charges = 0;
    if(charges > received) charges = received;
    $('#'+prefix+'_office_charges').val(f2(charges));
    const balance = Math.max(0, received - charges);
    $('#'+prefix+'_balance_amount').val(f2(balance));
  }

  function bindBalance(prefix){
    $(d).on('input','#'+prefix+'_office_charges',function(){
      const raw=String($(this).val()??'').replace(/[^0-9.]/g,'');
      const parts=raw.split('.');
      $(this).val(parts.length>2?(parts[0]+'.'+parts.slice(1).join('')):raw);
      calcBalance(prefix);
    });
    $(d).on('change','#'+prefix+'_decision_refund,#'+prefix+'_decision_replacement',function(){
      if(this.id===prefix+'_decision_refund') $('#'+prefix+'_decision_replacement').prop('checked',false);
      if(this.id===prefix+'_decision_replacement') $('#'+prefix+'_decision_refund').prop('checked',false);
      enforceDecision(prefix);
      calcBalance(prefix);
    });
    $(d).on('focus','#'+prefix+'_due_date',function(){
      applyDueDateRules(prefix);
    });
    $(d).on('change','#'+prefix+'_due_date',function(){
      validateDueDate(prefix);
    });
  }

  bindBalance('im');
  bindBalance('tr');
  bindBalance('sr');

  function fillAgreement(prefix, src){
    const a = src?.agreement || src?.agreement_details || src?.agreementDetail || {};
    const agreementRef = pick(a, ['agreement_reference_no','reference_no'], pick(src, ['agreement_reference_no','reference_no'], ''));
    const startDate = pick(a, ['contract_start_date','agreement_start_date','start_date'], pick(src, ['contract_start_date','agreement_start_date','start_date'], ''));
    const endDate = pick(a, ['contract_end_date','agreement_end_date','end_date'], pick(src, ['contract_end_date','agreement_end_date','end_date'], ''));
    const totalAmount = n(pick(a, ['total_amount','contracted_amount','total'], pick(src, ['total_amount','contracted_amount','total'], 0)));
    const receivedAmt = n(pick(a, ['received_amount','received'], pick(src, ['received_amount','received'], 0)));
    const hasAgreement = !!String(agreementRef||'').trim();

    const noSel = '#'+prefix+'_no_agreement';
    const cardSel = '#'+prefix+'_agreement_card';

    if(!hasAgreement){
      $(noSel).removeClass('d-none');
      $(cardSel).addClass('d-none');
      setDecision(prefix,'Refund');
      $('#'+prefix+'_agreement_reference_no_text').val('');
      $('#'+prefix+'_contract_start_date').val('');
      $('#'+prefix+'_contract_end_date').val('');
      $('#'+prefix+'_total_amount').val('0.00');
      $('#'+prefix+'_received_amount').val('0.00');
      $('#'+prefix+'_office_charges').val('0.00');
      $('#'+prefix+'_balance_amount').val('0.00');
      $('#'+prefix+'_due_date').val('');
      applyDueDateRules(prefix);
      return;
    }

    $(noSel).addClass('d-none');
    $(cardSel).removeClass('d-none');

    $('#'+prefix+'_agreement_reference_no_text').val(agreementRef);
    $('#'+prefix+'_contract_start_date').val(startDate);
    $('#'+prefix+'_contract_end_date').val(endDate);
    $('#'+prefix+'_total_amount').val(f2(totalAmount));
    $('#'+prefix+'_received_amount').val(f2(receivedAmt));

    let charges = n($('#'+prefix+'_office_charges').val());
    if(!Number.isFinite(charges) || charges < 0) charges = 0;
    if(charges > receivedAmt) charges = receivedAmt;
    $('#'+prefix+'_office_charges').val(f2(charges));

    setDecision(prefix,'Refund');
    enforceDecision(prefix);
    calcBalance(prefix);
    applyDueDateRules(prefix);
    validateDueDate(prefix);
  }

  function fillInvoices(invoices){
    if(!Array.isArray(invoices) || !invoices.length){
      $('#InvoiceData').html('<p class="text-danger">No invoices found.</p>');
      return;
    }
    var rows='';
    invoices.forEach(function(i){
      var total=n(i.total_amount);
      var received=n(i.received_amount);
      var remain=Math.max(0,total-received);
      rows+='<tr><td>'+(i.invoice_date||'')+'</td><td>'+f2(total)+'</td><td>'+f2(received)+'</td><td>'+f2(remain)+'</td><td><a href="/invoices/'+(i.invoice_number||'')+'" target="_blank" class="btn btn-light btn-sm"><i class="fas fa-external-link-alt"></i> '+(i.invoice_number||'')+'</a></td></tr>';
    });
    $('#InvoiceData').html('<table class="table table-striped"><thead><tr><th>Date</th><th>Total Amount</th><th>Received Amount</th><th>Remaining Amount</th><th>Invoice Reference #</th></tr></thead><tbody>'+rows+'</tbody></table>');
  }

  function normalizeCandidateDetails(payload){
    const dts = payload?.candidateDetails || {};
    const agreement = dts?.agreement || payload?.agreement || {};
    return {
      trial_id: pick(dts, ['trial_id','trialId'], payload?.trial_id),
      candidate_id: pick(dts, ['candidate_id','candidateId'], payload?.candidate_id),
      client_id: pick(dts, ['client_id','clientId'], payload?.client_id),
      candidate_name: pick(dts, ['candidate_name','candidateName'], ''),
      employer_name: pick(dts, ['employer_name','employerName'], ''),
      client_name: pick(dts, ['client_name','clientName'], ''),
      reference_no: pick(dts, ['reference_no','referenceNo','ref_no'], ''),
      foreign_partner: pick(dts, ['foreign_partner','foreignPartner'], ''),
      nationality: pick(dts, ['nationality'], ''),
      passport_number: pick(dts, ['passport_number','passportNo'], ''),
      passport_expiry: pick(dts, ['passport_expiry','passportExpiry'], ''),
      dob: pick(dts, ['dob'], ''),
      remaining_amount_with_vat: pick(dts, ['remaining_amount_with_vat','remainingAmountWithVat'], 0),
      invoices: pick(dts, ['invoices'], []),
      agreement: agreement
    };
  }

  function fillModalFields(modalId, payload){
    const dts = normalizeCandidateDetails(payload);
    const ag = dts.agreement || {};

    if(modalId==='ContractedModal'){
      $('#trial_id').val(dts.trial_id||'');
      $('#client_id').val(dts.client_id||'');
      $('#ContractedModalcandidateId').val(dts.candidate_id||'');
      $('#ContractedModalcandidateName').val(dts.candidate_name||'');
      $('#ContractedModalclientName').val((dts.client_name||dts.employer_name)||'');
      $('#ContractedModalremainingAmountWithVat').val(f2(n(dts.remaining_amount_with_vat)));
      fillInvoices(dts.invoices);
    }

    if(modalId==='ChangeStatusModal'){
      $('#ChangeStatusModaltrial_id').val(dts.trial_id||'');
      $('#ChangeStatusModalcandidateId').val(dts.candidate_id||'');
      $('#ChangeStatusModalcandidateName').val(dts.candidate_name||'');
      $('#ChangeStatusModalclientName').val((dts.client_name||dts.employer_name)||'');
    }

    if(modalId==='TrialReturnModal'){
      $('#TrialReturnModaltrial_id').val(dts.trial_id||'');
      $('#TrialReturnModalcandidateId').val(dts.candidate_id||'');
      $('#TrialReturnModalcandidateName').val(dts.candidate_name||'');
      $('#TrialReturnModalclientName').val((dts.client_name||dts.employer_name)||'');
      $('#tr_due_date').val('');
      fillAgreement('tr', {agreement: ag});
      applyDueDateRules('tr');
    }

    if(modalId==='SalesReturnModal'){
      $('#SalesReturnModaltrial_id').val(dts.trial_id||'');
      $('#SalesReturnModalcandidateId').val(dts.candidate_id||'');
      $('#SalesReturnModalcandidateName').val(dts.candidate_name||'');
      $('#SalesReturnModalclientName').val((dts.client_name||dts.employer_name)||'');
      $('#sr_due_date').val('');
      fillAgreement('sr', {agreement: ag});
      applyDueDateRules('sr');
    }

    if(modalId==='incidentModal'){
      $('#im_trial_id').val(dts.trial_id||'');
      $('#im_candidate_id').val(dts.candidate_id||'');
      $('#im_candidate_name').val(dts.candidate_name||'');
      $('#im_sponsor_name').val((dts.client_name||dts.employer_name)||'');
      $('#im_candidate_reference_no').val(dts.reference_no||'');
      $('#im_candidate_ref_no').val(dts.reference_no||'');
      $('#im_foreign_partner').val(dts.foreign_partner||'');
      $('#im_candidate_nationality').val(dts.nationality||'');
      $('#im_candidate_passport_number').val(dts.passport_number||'');
      $('#im_candidate_passport_expiry').val(dts.passport_expiry||'');
      $('#im_candidate_dob').val(dts.dob||'');
      $('#im_agreement_id').val(pick(ag, ['id'], ''));
      $('#im_agreement_reference_no').val(pick(ag, ['agreement_reference_no','reference_no'], ''));
      $('#im_agreement_type').val(pick(ag, ['agreement_type'], ''));
      $('#im_agreement_client_id').val(dts.client_id||'');
      $('#im_due_date').val('');
      fillAgreement('im', {agreement: ag});
      applyDueDateRules('im');
    }
  }

  function trialChangeStatus(status, trialId, candidateId, clientId){
    Swal.fire({
      title:'Change to "'+status+'"',
      text:'Are you sure you want to change the status to "'+status+'"?',
      icon:'warning',
      showCancelButton:true,
      confirmButtonText:'Yes',
      cancelButtonText:'No',
      confirmButtonColor:'#28a745',
      cancelButtonColor:'#dc3545'
    }).then(function(r){
      if(!r.isConfirmed){
        closeAllDropdowns();
        return;
      }
      closeAllDropdowns();
      updateTrialStatus(status,trialId,candidateId,clientId);
    });
  }

  function updateTrialStatus(status, trialId, candidateId, clientId){
    showPreloader();
    const body = new URLSearchParams({trial_id:String(trialId),candidate_id:String(candidateId),client_id:String(clientId),status:String(status)});
    handleFetch('<?php echo e(route("packages.updateTrialStatus")); ?>',{method:'POST',body:body}).then(res=>{
      if(res && res.success){
        if(res.action==='open_modal' && res.modal){
          $('#'+res.modal).modal('show');
          fillModalFields(res.modal,res);
          applyDueDateRules('im');
          applyDueDateRules('tr');
          applyDueDateRules('sr');
          hidePreloader();
          return;
        }
        showSuccess(res.message||'Status updated successfully!');
        setTimeout(function(){location.reload();},900);
        hidePreloader();
        return;
      }
      showErrors([(res&&res.message)||'Failed to update status. Please try again.']);
      hidePreloader();
    }).catch(err=>{showErrors(err.messages||[err.message]);hidePreloader();});
  }

  function bindIfExists(id,handler){
    const el=d.getElementById(id);
    if(el) el.addEventListener('click',handler,false);
  }

  function saveConfirmed(){
    const form=d.getElementById('ContractedModalForm');
    if(!form) return;

    let ok=true;

    const clientName = String((d.getElementById('ContractedModalclientName')&&d.getElementById('ContractedModalclientName').value)||'').trim();
    const dateVal    = String((d.getElementById('ContractedModalDate')&&d.getElementById('ContractedModalDate').value)||'').trim();
    const methodVal  = String((d.getElementById('paymentMethodForConfirmed')&&d.getElementById('paymentMethodForConfirmed').value)||'').trim();
    const received   = n((d.getElementById('ContractedModalreceivedAmount')&&d.getElementById('ContractedModalreceivedAmount').value)||0);

    if(!clientName){toastr.error('Employer Name is required.');ok=false;}
    if(!dateVal){toastr.error('Confirmed Date is required.');ok=false;}
    if(!methodVal){toastr.error('Payment method is required.');ok=false;}
    if(received<=0){toastr.error('Received Amount must be greater than 0.');ok=false;}

    const proof=d.getElementById('ContractedModalpaymentProof');
    if(!proof||!proof.files||!proof.files.length){toastr.error('Payment proof is required.');ok=false;}

    if(!ok) return;

    const btn=d.getElementById('saveContractedModalButton');
    if(btn) btn.disabled=true;
    const fd=new FormData(form);

    showPreloader();
    handleFetch('<?php echo e(route("packages.saveTrialConfirmed")); ?>',{method:'POST',body:fd}).then(r=>{
      if(r && r.success){
        showSuccess(r.message||'Saved.');
        $('#ContractedModal').modal('hide');
        form.reset();
        setTimeout(function(){location.reload();},900);
        hidePreloader();
        if(btn) btn.disabled=false;
        return;
      }
      showErrors([(r&&r.message)||'Failed to save confirmed trial.']);
      hidePreloader();
      if(btn) btn.disabled=false;
    }).catch(err=>{
      showErrors(err.messages||[err.message]);
      hidePreloader();
      if(btn) btn.disabled=false;
    });
  }

  function saveChangeStatus(){
    const btn=d.getElementById('saveChangeStatusModalButton');
    const form=d.getElementById('ChangeStatusModalForm');
    if(!form) return;
    if(btn) btn.disabled=true;
    const fd=new FormData(form);
    showPreloader();
    handleFetch('<?php echo e(route("packages.updateChangeStatus")); ?>',{method:'POST',body:fd}).then(dj=>{
      if(dj && dj.success){
        showSuccess(dj.message||'Updated.');
        $('#ChangeStatusModal').modal('hide');
        setTimeout(function(){location.reload();},900);
        hidePreloader();
        if(btn) btn.disabled=false;
        return;
      }
      showErrors([(dj&&dj.message)||'Failed to update status.']);
      hidePreloader();
      if(btn) btn.disabled=false;
    }).catch(err=>{
      showErrors(err.messages||[err.message]);
      hidePreloader();
      if(btn) btn.disabled=false;
    });
  }

  function saveTrialReturn(){
    enforceDecision('tr');
    calcBalance('tr');
    if(!validateDueDate('tr')) return;

    const form=d.getElementById('TrialReturnModalForm');
    const btn=d.getElementById('saveTrialReturnButton');
    if(!form) return;

    const due = String($('#tr_due_date').val()||'').trim();
    if(!due){toastr.error(dueLabel('tr')+' is required.');return;}

    if(btn) btn.disabled=true;
    const fd=new FormData(form);
    showPreloader();
    handleFetch('<?php echo e(route("packages.saveTrialReturn")); ?>',{method:'POST',body:fd}).then(dj=>{
      if(dj && dj.success){
        showSuccess(dj.message||'Trial Return saved.');
        $('#TrialReturnModal').modal('hide');
        setTimeout(function(){location.reload();},900);
        hidePreloader();
        if(btn) btn.disabled=false;
        return;
      }
      showErrors([(dj&&dj.message)||'Failed to save Trial Return.']);
      hidePreloader();
      if(btn) btn.disabled=false;
    }).catch(err=>{
      showErrors(err.messages||[err.message]);
      hidePreloader();
      if(btn) btn.disabled=false;
    });
  }

  function saveSalesReturn(){
    enforceDecision('sr');
    calcBalance('sr');
    if(!validateDueDate('sr')) return;

    const form=d.getElementById('SalesReturnModalForm');
    const btn=d.getElementById('saveSalesReturnButton');
    if(!form) return;

    const due = String($('#sr_due_date').val()||'').trim();
    if(!due){toastr.error(dueLabel('sr')+' is required.');return;}

    if(btn) btn.disabled=true;
    const fd=new FormData(form);
    showPreloader();
    handleFetch('<?php echo e(route("packages.saveSalesReturn")); ?>',{method:'POST',body:fd}).then(dj=>{
      if(dj && dj.success){
        showSuccess(dj.message||'Sales Return saved.');
        $('#SalesReturnModal').modal('hide');
        setTimeout(function(){location.reload();},900);
        hidePreloader();
        if(btn) btn.disabled=false;
        return;
      }
      showErrors([(dj&&dj.message)||'Failed to save Sales Return.']);
      hidePreloader();
      if(btn) btn.disabled=false;
    }).catch(err=>{
      showErrors(err.messages||[err.message]);
      hidePreloader();
      if(btn) btn.disabled=false;
    });
  }

  function saveIncident(){
    enforceDecision('im');
    calcBalance('im');
    if(!validateDueDate('im')) return;

    const form=d.getElementById('incidentForm');
    const btn=d.getElementById('im_save_btn');
    if(!form) return;

    const reason = String($('#im_incident_reason').val()||'').trim();
    if(!reason){toastr.error('Incident reason is required.');return;}

    if(String(reason).toUpperCase()==='OTHER'){
      const other = String($('#im_other_reason').val()||'').trim();
      if(!other){toastr.error('Specify reason is required.');return;}
    }

    if(String(reason).toUpperCase()==='MOHRE COMPLAIN'){
      const ex = String($('#im_incident_expiry_date').val()||'').trim();
      if(!ex){toastr.error('Expiry Date of Incident is required.');return;}
    }

    const due = String($('#im_due_date').val()||'').trim();
    if(!due){toastr.error(dueLabel('im')+' is required.');return;}

    const proof = d.getElementById('im_proof');
    if(!proof || !proof.files || !proof.files.length){toastr.error('Incident proof is required.');return;}

    if(btn) btn.disabled=true;
    const fd=new FormData(form);

    showPreloader();
    handleFetch('<?php echo e(route("packages.saveReturnIncident")); ?>',{method:'POST',body:fd}).then(dj=>{
      if(dj && dj.success){
        showSuccess(dj.message||'Incident saved.');
        $('#incidentModal').modal('hide');
        form.reset();
        setDecision('im','Refund');
        setTimeout(function(){location.reload();},800);
        hidePreloader();
        if(btn) btn.disabled=false;
        return;
      }
      showErrors([(dj&&dj.message)||'Failed to save Incident.']);
      hidePreloader();
      if(btn) btn.disabled=false;
    }).catch(err=>{
      showErrors(err.messages||[err.message]);
      hidePreloader();
      if(btn) btn.disabled=false;
    });
  }

  $(d).on('change','#im_incident_reason',function(){
    const v=String($(this).val()||'').toUpperCase();
    if(v==='MOHRE COMPLAIN') $('#im_expiry_wrap').show(); else $('#im_expiry_wrap').hide();
    if(v==='OTHER') $('#im_other_reason_wrap').show(); else $('#im_other_reason_wrap').hide();
  });

  $(d).on('shown.bs.modal','#TrialReturnModal',function(){ applyDueDateRules('tr'); });
  $(d).on('shown.bs.modal','#SalesReturnModal',function(){ applyDueDateRules('sr'); });
  $(d).on('shown.bs.modal','#incidentModal',function(){ applyDueDateRules('im'); });

  function init(){
    applyDueDateRules('im');
    applyDueDateRules('tr');
    applyDueDateRules('sr');
    bindIfExists('saveContractedModalButton',saveConfirmed);
    bindIfExists('saveChangeStatusModalButton',saveChangeStatus);
    bindIfExists('saveTrialReturnButton',saveTrialReturn);
    bindIfExists('saveSalesReturnButton',saveSalesReturn);
    bindIfExists('im_save_btn',saveIncident);
  }

  $(init);

  w.showPreloader=showPreloader;
  w.hidePreloader=hidePreloader;
  w.openDropdown=openDropdown;
  w.closeAllDropdowns=closeAllDropdowns;
  w.trialChangeStatus=trialChangeStatus;

})(jQuery,window,document);
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/partials/trial_table.blade.php ENDPATH**/ ?>