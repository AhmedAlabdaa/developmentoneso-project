<?php
use Carbon\Carbon;
?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  body { font-family: Arial, sans-serif; font-size: 14px; margin: 0; padding: 0; overflow-x: hidden; }
  .table-container { width: 100%; overflow-x: auto; margin-bottom: 20px; }
  .table { width: 100%; border-collapse: collapse; }
  .table th, .table td { padding: 10px 15px; white-space: nowrap; border-bottom: 1px solid #ddd; font-size: 12px; }
  .table th { background: #343a40; color: #fff; text-transform: uppercase; font-weight: bold; text-align: center; }
  .table-striped tbody tr:nth-child(odd) { background: #f9f9f9; }
  .table-hover tbody tr:hover { background: #f1f1f1; }
  .btn-icon-only { display: inline-flex; align-items: center; justify-content: center; padding: 5px 10px; font-size: 12px; border-radius: 4px; color: #fff; }
  .btn-primary { background: #007bff; }
  .btn-danger { background: #dc3545; }
  .btn-info { background: #17a2b8; }
  .btn-sm { padding: 3px 8px; font-size: 11px; }
  #fullscreenOverlay { display: none; position: fixed; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.7); z-index: 1000; }
  .offcanvas-panel { position: fixed; top: 0; right: -60%; width: 60%; height: 100%; background: #fff; box-shadow: -2px 0 8px rgba(0,0,0,0.2); z-index: 1100; transition: right .3s; display: flex; flex-direction: column; }
  .offcanvas-panel.show { right: 0; }
  .offcanvas-panel .header { background: #007bff; color: #fff; padding: 15px; font-size: 18px; position: relative; }
  .offcanvas-panel .header .close-icon { position: absolute; top: 12px; right: 12px; font-size: 24px; color: #fff; cursor: pointer; }
  .offcanvas-panel .body { flex: 1; overflow: auto; padding: 20px; }
  .offcanvas-panel .footer { padding: 15px; display: flex; justify-content: center; gap: 10px; }
  .form-row { display: flex; flex-wrap: wrap; margin-bottom: 15px; }
  .form-group { flex: 1; min-width: 45%; margin-right: 5%; margin-bottom: 15px; }
  .form-group:nth-child(2n) { margin-right: 0; }
  .form-group label { display: block; margin-bottom: 5px; font-size: 13px; }
  .form-control, .form-select { font-size: 13px; padding: 6px 8px; border: 1px solid #ccc; }
  .form-control { height: 38px; }
  .input-group { display: flex; }
  #contractMonthsCount { border-left: 4px solid #007bff !important; }
  .alert-inline { display: flex; align-items: center; padding: 10px; margin-bottom: 15px; background: #e7f3fe; color: #31708f; border-radius: 4px; }
  .alert-inline i { margin-right: 8px; }
  .small { font-size: 11px; color: #6c757d; }
  #installmentsContainer { display: none; margin-top: 15px; }
  #installmentsTable { width: 100%; border-collapse: collapse; }
  #installmentsTable th, #installmentsTable td { border: 1px solid #ddd; padding: 8px; font-size: 12px; }
  #installmentsTable th { background: #000; color: #fff; text-align: left; }
  input.invalid { border-color: #dc3545 !important; }
  .swal2-container { z-index: 2000 !important; }
  .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 1500; align-items: center; justify-content: center; }
  .modal-card { width: 860px; max-width: 96%; background: #fff; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,.25); overflow: hidden; }
  .modal-card .modal-head { background: linear-gradient(135deg,#007bff,#6a11cb); color:#fff; padding: 14px 16px; font-weight: 600; display:flex; align-items:center; justify-content:space-between; }
  .modal-card .modal-body { padding: 16px; background:#f9f9f9; }
  .modal-card .modal-foot { padding: 12px 16px; background:#f1f1f1; text-align: right; }
  .modal-close { border:0; background:transparent; color:#fff; font-size:20px; line-height:1; cursor:pointer; }
  .inline-eye { display:none; align-items:center; justify-content:center; padding: 0 10px; }
  .alert-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); z-index: 2200; align-items:center; justify-content:center; }
  .alert-box { width: 980px; max-width: 96%; background:#fff; border-radius: 12px; overflow:hidden; box-shadow: 0 12px 40px rgba(0,0,0,.35); }
  .alert-head { background: linear-gradient(135deg,#007bff,#6a11cb); color:#fff; padding: 14px 16px; display:flex; align-items:center; justify-content:space-between; }
  .alert-title { font-weight: 700; font-size: 15px; display:flex; align-items:center; gap:10px; }
  .alert-title .badge { background:#fff; color:#222; border-radius: 999px; padding: 5px 10px; font-size: 12px; border:1px solid rgba(0,0,0,.08); }
  .alert-body { padding: 14px 16px; background:#f8f9fa; }
  .alert-foot { padding: 12px 16px; background:#f1f1f1; text-align:right; }
  .alert-btn { border:0; padding: 9px 14px; border-radius: 8px; font-weight: 600; cursor:pointer; }
  .alert-btn-primary { background:#007bff; color:#fff; }
  .alert-btn-warning { background:#f0ad4e; color:#111; }
  .alert-btn-secondary { background:#6c757d; color:#fff; }
  .alert-table { width:100%; border-collapse: collapse; background:#fff; border-radius: 10px; overflow:hidden; }
  .alert-table th, .alert-table td { border-bottom: 1px solid #e7e7e7; padding: 10px 10px; font-size: 12px; white-space: nowrap; }
  .alert-table th { background:#343a40; color:#fff; text-transform: uppercase; font-size: 11px; }
  .money { font-variant-numeric: tabular-nums; font-weight: 700; }
  .total-row td { background:#eef6ff; font-weight: 800; border-top: 2px solid #0d6efd; }
  .pill { display:inline-flex; align-items:center; gap:6px; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
  .pill-danger { background:#dc3545; color:#fff; }
  .pill-info { background:#0dcaf0; color:#111; }
</style>

<body>
  <div id="fullscreenOverlay"></div>

  <div class="table-container">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Ref #</th>
          <th>Last Updated</th>
          <th>Name</th>
          <th>Passport #</th>
          <th>Nationality</th>
          <th>Category</th>
          <th>Arrived</th>
          <th>Visa Stage</th>
          <th>Returned</th>
          <th>Expiry</th>
          <th>Proof</th>
          <th>Overstay</th>
          <th>Total Fine</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $expiry = $e->expiry_date ? Carbon::parse($e->expiry_date)->startOfDay() : null;
          $today  = Carbon::now('Asia/Qatar')->startOfDay();
          $overstayDays = 0;
          if ($expiry && $today->gt($expiry)) {
            $overstayDays = (int) $expiry->diffInDays($today);
          }
          $totalFine = (int) ($overstayDays * 50);
          $expiryISO = $e->expiry_date ? Carbon::parse($e->expiry_date)->format('Y-m-d') : '';
        ?>
        <tr
          class="employee-row"
          data-name="<?php echo e(e($e->name)); ?>"
          data-nationality="<?php echo e(e($e->nationality)); ?>"
          data-passport="<?php echo e(e($e->passport_no)); ?>"
          data-expiry="<?php echo e($expiryISO); ?>"
        >
          <td><?php echo e($e->reference_no); ?></td>
          <td><?php echo e($e->updated_at->format('d M Y')); ?></td>
          <td><?php echo e($e->name); ?></td>
          <td><?php echo e($e->passport_no); ?></td>
          <td><?php echo e($e->nationality); ?></td>
          <td><?php echo e($e->category); ?></td>
          <td><?php echo e($e->arrived_date ? Carbon::parse($e->arrived_date)->format('d M Y') : '–'); ?></td>
          <td>
            <?php if($e->visa_status==0): ?>
              <button class="btn btn-secondary btn-sm"><i class="fas fa-clock"></i> Not started</button>
            <?php else: ?>
              <?php
                $map = [
                  1  => ['Visit 1',   'fa-plane'],
                  2  => ['Visit 2',   'fa-plane-departure'],
                  3  => ['DIN',       'fa-file-medical'],
                  4  => ['EPV',       'fa-passport'],
                  5  => ['CS',        'fa-user-shield'],
                  6  => ['Medical',   'fa-heartbeat'],
                  7  => ['TWJ',       'fa-calendar-alt'],
                  8  => ['EID',       'fa-id-card'],
                  9  => ['RVS',       'fa-stamp'],
                  10 => ['Visit 3',   'fa-plane-arrival'],
                  11 => ['ILOE',      'fa-briefcase'],
                  12 => ['SD',        'fa-money-bill'],
                  13 => ['VC',        'fa-times'],
                  14 => ['Completed', 'fa-check-circle'],
                  15 => ['Arrived',   'fa-plane-arrival'],
                ];
                [$lbl, $ico] = $map[(int) ($e->visa_status ?? 0)] ?? ['Unknown', 'fa-question-circle'];
              ?>
              <button class="btn btn-info btn-sm"><i class="fas <?php echo e($ico); ?>"></i> <?php echo e($lbl); ?></button>
            <?php endif; ?>
          </td>
          <td><?php echo e($e->returned_date ? Carbon::parse($e->returned_date)->format('d M Y') : '–'); ?></td>
          <td><?php echo e($e->expiry_date ? Carbon::parse($e->expiry_date)->format('d M Y') : '–'); ?></td>
          <td>
            <button class="btn btn-primary btn-icon-only btn-view-proof" data-proof-url="<?php echo e($e->ica_proof ? asset('storage/'.$e->ica_proof) : ''); ?>">
              <i class="fas fa-eye"></i>
            </button>
          </td>
          <td><?php echo e($overstayDays); ?></td>
          <td><?php echo e(number_format($totalFine, 2)); ?></td>
          <td><?php echo e($e->passport_status); ?></td>
          <td>
            <button
              class="btn btn-primary btn-icon-only btn-edit-office"
              data-office-id="<?php echo e(optional($e->office)->id); ?>"
              data-candidate-id="<?php echo e($e->id); ?>"
              data-name="<?php echo e($e->name); ?>"
              data-passport-no="<?php echo e($e->passport_no); ?>"
              data-nationality="<?php echo e($e->nationality); ?>"
              data-category="<?php echo e(optional($e->office)->category); ?>"
              data-returned-date="<?php echo e(optional($e->office)->returned_date ? Carbon::parse(optional($e->office)->returned_date)->format('Y-m-d') : ''); ?>"
              data-expiry-date="<?php echo e(optional($e->office)->expiry_date ? Carbon::parse(optional($e->office)->expiry_date)->format('Y-m-d') : ''); ?>"
              data-ica-proof="<?php echo e(optional($e->office)->ica_proof); ?>"
              data-passport-status="<?php echo e(optional($e->office)->passport_status ?: $e->passport_status); ?>"
            >
              <i class="fas fa-edit"></i>
            </button>

            <button class="btn btn-primary btn-icon-only btn-contract" data-passport="<?php echo e($e->passport_no); ?>">
              <i class="fas fa-file-contract"></i>
            </button>

            <button class="btn btn-danger btn-icon-only btn-incident" data-passport="<?php echo e($e->passport_no); ?>">
              <i class="fas fa-exclamation-triangle"></i>
            </button>

            <?php if(in_array($e->inside_status, [1])): ?>
              <a href="<?php echo e(route('employee.exit', $e->passport_no)); ?>" class="btn btn-warning btn-icon-only">
                <i class="fas fa-sign-out-alt"></i>
              </a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="15" class="text-center">No results</td>
        </tr>
        <?php endif; ?>
      </tbody>
      <tfoot>
        <tr>
          <th>Ref #</th>
          <th>Last Updated</th>
          <th>Name</th>
          <th>Passport #</th>
          <th>Nationality</th>
          <th>Category</th>
          <th>Arrived</th>
          <th>Visa Stage</th>
          <th>Returned</th>
          <th>Expiry</th>
          <th>Proof</th>
          <th>Overstay</th>
          <th>Total Fine</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <nav class="py-2">
    <div class="d-flex justify-content-between align-items-center">
      <span class="text-muted small">Showing <?php echo e($employees->firstItem()); ?>–<?php echo e($employees->lastItem()); ?> of <?php echo e($employees->total()); ?> results</span>
      <ul class="pagination mb-0">
        <?php echo e($employees->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

      </ul>
    </div>
  </nav>

  <div id="contractPanel" class="offcanvas-panel">
    <div class="header">
      <i class="fas fa-file-contract"></i> Create Contract
      <span class="close-icon">&times;</span>
    </div>
    <div class="body">
      <div class="alert-inline">
        <i class="fas fa-info-circle"></i> You are creating a contract for: <strong id="alertCandidateName"></strong>
      </div>
      <form id="TrialModalForInside" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="agreement_type" value="BIA">
        <input type="hidden" name="candidate_id" id="contract_candidate_id">
        <input type="hidden" name="candidate_name" id="contract_candidate_name">
        <input type="hidden" name="date_of_birth" id="contract_dob">
        <input type="hidden" name="nationality" id="contract_nationality">
        <input type="hidden" name="passport_no" id="contract_passport_no">
        <input type="hidden" name="passport_expiry_date" id="contract_passport_expiry">
        <input type="hidden" name="ref_no_prev" id="contract_ref_no">
        <input type="hidden" name="total_amount" id="hidden_total_amount" value="0">
        <input type="hidden" name="received_amount" id="hidden_received_amount" value="0">
        <input type="hidden" name="balance" id="hidden_balance" value="0">
        <input type="hidden" name="payment_terms" id="hidden_payment_terms">
        <input type="hidden" name="number_of_days" id="hidden_number_of_days">
        <input type="hidden" name="installment_count" id="installmentCount" value="0">

        <div class="form-row">
          <div class="form-group">
            <label>Package *</label>
            <select name="package" id="contractPackage" class="form-select" required>
              <option value="">Select</option>
              <option>PKG-2</option>
              <option>PKG-3</option>
              <option>PKG-4</option>
            </select>
          </div>
          <div class="form-group">
            <label>Client *</label>
            <select name="client_id" id="contractClient" class="form-select" required></select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Contract Start Date *</label>
            <input type="date" name="trial_start_date" id="contractStart" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Contract End Date *</label>
            <input type="date" name="trial_end_date" id="contractEnd" class="form-control" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Duration</label>
            <input type="text" id="contractDuration" class="form-control">
          </div>
          <div class="form-group">
            <label>Monthly Payment *</label>
            <input type="number" name="monthly_payment" id="contractMonthly" class="form-control" min="0" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Initial Payment *</label>
            <div class="input-group">
              <input type="number" name="initial_payment" id="contractInitial" class="form-control" min="0" required>
              <select name="months_count" id="contractMonthsCount" class="form-select">
                <option value="1" selected>1 Month</option>
                <?php for($i=2; $i<=24; $i++): ?><option value="<?php echo e($i); ?>"><?php echo e($i); ?> Months</option><?php endfor; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Payment Cycle *</label>
            <select name="payment_cycle" id="contractCycle" class="form-select" required>
              <option value="0">LUMPSUM</option>
              <?php for($i=1; $i<=12; $i++): ?><option value="<?php echo e($i); ?>"><?php echo e($i); ?> Month<?php echo e($i>1?'s':''); ?></option><?php endfor; ?>
            </select>
          </div>
        </div>

        <div id="installmentsContainer">
          <div class="alert-inline">
            <i class="fas fa-info-circle"></i> The installment date is always the 1st of each month
          </div>
          <table id="installmentsTable" class="table">
            <thead>
              <tr>
                <th>Installment Date *</th>
                <th>Reference No</th>
                <th>Amount *</th>
                <th>Payment Proof</th>
                <th style="width:60px;"><button type="button" id="addInstallmentRow" class="btn btn-sm btn-info"><i class="fas fa-plus"></i></button></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Upcoming Payment</label>
            <input type="date" name="upcoming_payment_date" id="contractUpcoming" class="form-control" readonly required>
          </div>
          <div class="form-group">
            <label>Salary *</label>
            <input type="number" name="salary" id="contractSalary" class="form-control" min="0" required>
          </div>
          <div class="form-group">
            <label>Office Charges</label>
            <input type="text" name="office_charges" id="contractOfficeCharges" class="form-control">
          </div>
          <div class="form-group">
            <label>Current Month Salary</label>
            <input type="text" name="current_month_salary" placeholder="(30-day pro-rate, excluding today)" id="contractCurrentSalary" class="form-control">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Initial Payment Method *</label>
            <select name="payment_method" id="contractPaymentMethod" class="form-select" required>
              <option value="">Select</option>
              <option>Bank Transfer ADIB</option>
              <option>Bank Transfer ADCB</option>
              <option>POS-ID 60043758</option>
              <option>POS-ID 60045161</option>
              <option>ADIB-19114761</option>
              <option>ADIB-19136783</option>
              <option>Cash</option>
              <option>Cheque</option>
              <option>METTPAY</option>
              <option>Replacement</option>
            </select>
          </div>
          <div class="form-group">
            <label>Initial Payment Proof <span class="small">(Required)</span></label>
            <input type="file" name="payment_proof" id="contractPaymentProof" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
          </div>
        </div>

        <div class="footer">
          <button type="button" id="saveContract" class="btn btn-info"><i class="fas fa-save"></i> Save</button>
        </div>
      </form>
    </div>
  </div>

  <div id="incidentPanel" class="offcanvas-panel">
    <div class="header">
      <i class="fas fa-exclamation-triangle"></i> Report Incident
      <span class="close-icon">&times;</span>
    </div>
    <div class="body">
      <form id="incident_form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="employee_id" id="incident_employee_id">
        <div class="form-row">
          <div class="form-group">
            <label>Reference No</label>
            <input type="text" id="incidentReference" class="form-control" name="reference_no" required>
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" id="incidentName" class="form-control" name="name" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Passport No</label>
            <input type="text" id="incidentPassport" class="form-control" name="passport_no" required>
          </div>
          <div class="form-group">
            <label>Date *</label>
            <input type="date" name="incident_date" class="form-control" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Type *</label>
            <select name="incident_type" class="form-select" required>
              <option value="">Select</option>
              <option value="RUNAWAY">RUNAWAY</option>
              <option value="REPATRIATION">REPATRIATION</option>
              <option value="UNFIT">UNFIT</option>
              <option value="SICK">SICK</option>
              <option value="REFUSED">REFUSED</option>
              <option value="PSYCHIATRIC">PSYCHIATRIC</option>
            </select>
          </div>
          <div class="form-group">
            <label>Comments</label>
            <textarea name="comments" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="footer">
          <button type="button" id="saveIncident" class="btn btn-info"><i class="fas fa-save"></i> Save</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="editOfficeModal">
    <div class="modal-card">
      <div class="modal-head">
        <span><i class="fas fa-building me-2"></i> Edit Office (Employee)</span>
        <button class="modal-close" id="eo_close">&times;</button>
      </div>
      <form id="editOfficeForm" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
          <input type="hidden" id="eo_office_id" name="office_id">
          <input type="hidden" id="eo_candidate_id" name="candidate_id" required>
          <input type="hidden" id="eo_type" name="type" value="employee" required>
          <input type="hidden" id="eo_update_by" name="update_by" value="<?php echo e(auth()->id()); ?>">
          <div class="form-row">
            <div class="form-group">
              <label>Employee</label>
              <input type="text" id="eo_name" class="form-control" readonly required>
            </div>
            <div class="form-group">
              <label>Passport No</label>
              <input type="text" id="eo_passport_no" class="form-control" readonly required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Nationality</label>
              <input type="text" id="eo_nationality" class="form-control" readonly required>
            </div>
            <div class="form-group">
              <label>Category</label>
              <select id="eo_category" name="category" class="form-select" required>
                <option value="">Select Category</option>
                <option value="Sales Return">Sales Return</option>
                <option value="Trial Return">Trial Return</option>
                <option value="New Arrival">New Arrival</option>
                <option value="Unfit">Unfit</option>
                <option value="Others">Others</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Returned Date</label>
              <input type="date" id="eo_returned_date" name="returned_date" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Expiry Date</label>
              <input type="date" id="eo_expiry_date" name="expiry_date" class="form-control" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group" style="min-width:55%">
              <label>ICA Proof</label>
              <div class="input-group">
                <input type="file" id="eo_ica_proof" name="ica_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                <a id="eo_view_proof" class="inline-eye btn btn-primary btn-icon-only" target="_blank" title="View current proof"><i class="fas fa-eye"></i></a>
              </div>
              <small class="text-muted" id="eo_proof_hint"></small>
            </div>
            <div class="form-group">
              <label>Overstay Days</label>
              <input type="text" id="eo_overstay_days" name="overstay_days" class="form-control" readonly required>
            </div>
            <div class="form-group">
              <label>Total Fine</label>
              <input type="text" id="eo_fine_amount" name="fine_amount" class="form-control" readonly required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group" style="min-width:45%">
              <label>Passport Status</label>
              <select id="eo_passport_status" name="passport_status" class="form-select" required>
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
        </div>
        <div class="modal-foot">
          <button type="button" class="btn btn-secondary" id="eo_cancel">Close</button>
          <button type="button" class="btn btn-primary" id="eo_save_btn">Save</button>
        </div>
      </form>
    </div>
  </div>

  <div class="alert-modal" id="expiryAlertModal">
    <div class="alert-box">
      <div class="alert-head">
        <div class="alert-title">
          <i class="fas fa-triangle-exclamation"></i>
          Overstay Fine Alert
          <span class="badge">50.00 AED / day</span>
        </div>
        <button class="modal-close" id="expiryAlertClose">&times;</button>
      </div>
      <div class="alert-body">
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:12px">
          <span class="pill pill-danger" id="expiredCountPill">Expired: 0</span>
          <span class="pill pill-info" id="soonCountPill">Expiring Soon: 0</span>
        </div>
        <div style="width:100%;overflow:auto">
          <table class="alert-table">
            <thead>
              <tr>
                <th style="width:60px">#</th>
                <th>Candidate Name</th>
                <th>Nationality</th>
                <th>Passport No</th>
                <th>Expiry Date</th>
                <th style="width:180px">Status</th>
                <th style="width:140px">Days</th>
                <th style="width:170px">Fine Amount (AED)</th>
              </tr>
            </thead>
            <tbody id="expiryAlertBody"></tbody>
            <tfoot>
              <tr class="total-row">
                <td colspan="6" style="text-align:right">TOTAL</td>
                <td id="expiryTotalDays" style="text-align:center">0</td>
                <td id="expiryTotalFine" class="money" style="text-align:right">0.00 AED</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="alert-foot">
        <button class="alert-btn alert-btn-warning" id="expirySnoozeBtn"><i class="fas fa-bell-slash"></i> Snooze for 1 hour</button>
        <button class="alert-btn alert-btn-secondary" id="expiryCloseBtn">Close</button>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    $(function () {
      const csrf = $('meta[name="csrf-token"]').attr('content');
      let baseMonthly = 0, fullMonths = 0, partialDays = 0;

      const toLocalDateString = (d) => `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
      const lastDayOfMonth = (d) => new Date(d.getFullYear(), d.getMonth() + 1, 0);
      const firstDayOfMonth = (d) => new Date(d.getFullYear(), d.getMonth(), 1);

      const openPanel = (id) => { $('#fullscreenOverlay').show(); $(`#${id}`).addClass('show'); };
      const closePanel = () => { $('#fullscreenOverlay').hide(); $('.offcanvas-panel').removeClass('show'); };
      const updateCount = () => { $('#installmentCount').val($('#installmentsTable tbody tr').length); };

      const updateMonthsOptions = () => {
        $('#contractMonthsCount option').each(function () {
          const v = +$(this).val();
          $(this).prop('disabled', fullMonths > 0 ? v > fullMonths : false);
        });
        if (+$('#contractMonthsCount').val() > fullMonths) $('#contractMonthsCount').val(fullMonths || 1);
      };

      const adjustDropdowns = () => {
        const cover = +$('#contractMonthsCount').val();
        if (cover === fullMonths) {
          $('#contractCycle').val('0').prop('disabled', true);
          $('#installmentsContainer').hide();
          $('#contractUpcoming').val(toLocalDateString(new Date()));
        } else {
          $('#contractCycle').prop('disabled', false);
        }
      };

      const updateOfficeCharges = () => {
        const monthly = +$('#contractMonthly').val() || 0;
        const salary = +$('#contractSalary').val() || 0;
        const diff = monthly - salary;
        $('#contractOfficeCharges').val(diff > 0 ? diff.toFixed(2) : '0');
      };

      const recalcInitial = () => {
        const cover = +$('#contractMonthsCount').val();
        const sVal = $('#contractStart').val();
        const ld = sVal ? lastDayOfMonth(new Date(sVal)).getDate() : 30;
        const init = baseMonthly * Math.min(cover, fullMonths) + partialDays * (baseMonthly / ld);
        $('#contractInitial,#hidden_total_amount,#hidden_received_amount').val(init.toFixed(2));
        $('#hidden_balance').val(0);
      };

      const computeUpcoming = () => {
        const s = $('#contractStart').val();
        const cover = +$('#contractMonthsCount').val();
        const cv = $('#contractCycle').val();
        if (!s) return $('#contractUpcoming').val('');
        if (cv === '0') return $('#contractUpcoming').val(toLocalDateString(new Date()));
        const d = new Date(s);
        d.setMonth(d.getMonth() + cover + (partialDays > 0 ? 1 : 0));
        $('#contractUpcoming').val(toLocalDateString(firstDayOfMonth(d)));
      };

      const renderInstallments = () => {
        const cycle = +$('#contractCycle').val();
        const cover = +$('#contractMonthsCount').val();
        const s = $('#contractStart').val();
        const $tb = $('#installmentsTable tbody').empty();

        if (!cycle || !s) {
          $('#installmentsContainer').hide();
          return $('#installmentCount').val(0);
        }

        $('#installmentsContainer').show();
        const extra = partialDays > 0 ? 1 : 0;
        const total = Math.max(fullMonths - cover, 0);

        for (let i = 0; i < total; i++) {
          const d = new Date(s);
          d.setMonth(d.getMonth() + cover + extra + cycle * i);
          const date = toLocalDateString(firstDayOfMonth(d));
          const amt = (baseMonthly * cycle).toFixed(2);
          const ref = `Ref-INS-${String(i + 1).padStart(2, '0')}`;

          const $row = $('<tr>');
          $row.append(`<td><input name="inst_date[]" type="date" class="form-control" value="${date}" required></td>`);
          $row.append(`<td><input name="inst_ref[]" type="text" class="form-control" value="${ref}" required></td>`);
          $row.append(`<td><input name="inst_amount[]" type="number" class="form-control" value="${amt}" readonly required></td>`);
          $row.append(`<td><input name="inst_proof[]" type="file" class="form-control" accept=".jpg,.jpeg,.png,.pdf"></td>`);
          $row.append(`<td><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="fas fa-trash-alt"></i></button></td>`);
          $tb.append($row);
        }

        $('#installmentCount').val(total);
      };

      $('#contractMonthsCount').val('1');
      $('#contractCycle').val('0').prop('disabled', true);
      $('#contractOfficeCharges').val('0');

      $('#fullscreenOverlay, .close-icon').on('click', closePanel);
      $('#contractClient').select2({ width: '100%', dropdownParent: $('#contractPanel') });

      $('#contractPackage, #contractStart').on('change', function () {
        const pkg = $('#contractPackage').val();
        const s = $('#contractStart').val();
        if ((pkg === 'PKG-2' || pkg === 'PKG-4') && s) {
          const sd = new Date(s);
          sd.setFullYear(sd.getFullYear() + 2);
          $('#contractEnd').val(toLocalDateString(lastDayOfMonth(sd))).trigger('change').trigger('input');
        }
      });

      $('#contractEnd').on('change', function () {
        const v = $(this).val();
        if (v) {
          const ed = new Date(v);
          $(this).val(toLocalDateString(lastDayOfMonth(ed))).trigger('input');
        }
      });

      $('#contractStart, #contractEnd').on('input', function () {
        const s = $('#contractStart').val();
        const e = $('#contractEnd').val();
        if (!s || !e) return $('#contractDuration').val('');

        const sd = new Date(s);
        const ed = new Date(e);

        if (ed <= sd) {
          toastr.error('End date must be after start date');
          $('#contractEnd').val('');
          return;
        }

        let m = (ed.getFullYear() - sd.getFullYear()) * 12 + (ed.getMonth() - sd.getMonth());
        if (ed.getDate() < sd.getDate()) m--;

        fullMonths = m;
        const nxt = new Date(sd);
        nxt.setMonth(nxt.getMonth() + m);
        partialDays = Math.floor((ed - nxt) / (1000 * 60 * 60 * 24));

        $('#contractDuration').val(`${fullMonths} Month${fullMonths !== 1 ? 's' : ''}${partialDays > 0 ? ` ${partialDays} Day${partialDays !== 1 ? 's' : ''}` : ''}`);

        updateMonthsOptions();
        recalcInitial();
        computeUpcoming();
        renderInstallments();
        adjustDropdowns();
        updateOfficeCharges();
      });

      $('#contractMonthsCount, #contractCycle').on('change', function () {
        recalcInitial();
        computeUpcoming();
        renderInstallments();
        adjustDropdowns();
        updateOfficeCharges();
      });

      $('#contractMonthly').on('input', function () {
        baseMonthly = +this.value || 0;
        recalcInitial();
        computeUpcoming();
        renderInstallments();
        updateOfficeCharges();
      });

      $('#contractSalary').on('input', function () {
        const sal = +this.value || 0;
        const t = new Date();
        const rem = 30 - t.getDate();
        const pr = (sal / 30) * rem;
        $('#contractCurrentSalary').val(pr.toFixed(2));
        updateOfficeCharges();
      });

      $('#addInstallmentRow').on('click', function () {
        Swal.fire({ title: 'Add a new installment row?', icon: 'question', showCancelButton: true, confirmButtonText: 'Yes', cancelButtonText: 'No' })
          .then(r => { if (r.isConfirmed) renderInstallments(); });
      });

      $(document).on('click', '.btn-remove', function () {
        Swal.fire({ title: 'Remove this row?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Yes', cancelButtonText: 'No' })
          .then(r => { if (r.isConfirmed) { $(this).closest('tr').remove(); updateCount(); } });
      });

      $('#saveContract').on('click', function () {
        $('#contractCycle,#contractMonthsCount').prop('disabled', false);
        const data = new FormData($('#TrialModalForInside')[0]);
        data.append('_token', csrf);

        $.ajax({
          url: '<?php echo e(route("agreements.insideempagreement")); ?>',
          method: 'POST',
          data,
          processData: false,
          contentType: false
        })
          .done(() => { toastr.success('Contract saved'); closePanel(); location.reload(); })
          .fail(e => { toastr.error(e.responseJSON?.message || 'Error saving contract'); });
      });

      const showPanelSpinner = () => {
        if (!$('#panelSpinner').length) {
          $('#fullscreenOverlay')
            .append('<div id="panelSpinner" class="spinner-border text-primary" style="position:fixed;top:50%;left:50%;z-index:1051;"></div>')
            .show();
        }
      };

      const hidePanelSpinner = () => { $('#panelSpinner').remove(); };

      const loadInsideByPassport = (passportNo, statusId) => {
        showPanelSpinner();
        return $.post(`/employees/${encodeURIComponent(passportNo)}/update-status-inside`, { status_id: statusId, _token: csrf })
          .always(hidePanelSpinner);
      };

      $(document).on('click', '.btn-contract', function () {
        const passportNo = $(this).data('passport');
        if (!passportNo) return toastr.error('Passport number is missing');

        loadInsideByPassport(passportNo, 2)
          .done(resp => {
            const d = resp.candidateDetails || {};
            $('#TrialModalForInside')[0].reset();

            baseMonthly = +d.monthly_payment || 0;

            $('#alertCandidateName').text(d.candidateName || '');
            $('#contract_candidate_id').val(d.candidateId || '');
            $('#contract_candidate_name').val(d.candidateName || '');
            $('#contract_dob').val(d.dob || '');
            $('#contract_nationality').val(d.nationality || '');
            $('#contract_passport_no').val(d.passportNo || passportNo);
            $('#contract_passport_expiry').val(d.passportExpiry || '');
            $('#contract_ref_no').val(d.referenceNo || '');

            $('#contractMonthsCount').val('1');
            $('#contractCycle').val('0').prop('disabled', true);

            recalcInitial();
            computeUpcoming();
            renderInstallments();
            adjustDropdowns();
            updateOfficeCharges();

            $('#installmentsTable tbody').empty();
            $('#contractClient').empty().append('<option></option>');

            (resp.clients || []).forEach(c => {
              $('#contractClient').append(`<option value="${c.id}">${c.first_name} ${c.last_name}</option>`);
            });

            openPanel('contractPanel');
          })
          .fail(() => { toastr.error('Failed to load data'); });
      });

      $(document).on('click', '.btn-incident', function () {
        const passportNo = $(this).data('passport');
        if (!passportNo) return toastr.error('Passport number is missing');

        loadInsideByPassport(passportNo, 3)
          .done(resp => {
            const d = resp.candidateDetails || {};
            $('#incident_form')[0].reset();
            $('#incident_employee_id').val(d.candidateId || '');
            $('#incidentReference').val(d.referenceNo || '');
            $('#incidentName').val(d.candidateName || '');
            $('#incidentPassport').val(d.passportNo || passportNo);
            openPanel('incidentPanel');
          })
          .fail(() => { toastr.error('Failed to load data'); });
      });

      $('#saveIncident').on('click', function () {
        $.post('<?php echo e(route("employees.incidentSave")); ?>', $('#incident_form').serialize())
          .done(() => { toastr.success('Incident reported'); closePanel(); location.reload(); })
          .fail(e => { toastr.error(e.responseJSON?.message || 'Error reporting incident'); });
      });

      $(document).on('click', '.btn-view-proof', function () {
        const url = $(this).data('proof-url');
        if (url) window.open(url, '_blank');
        else toastr.error('No proof available');
      });

      const $editModal = $('#editOfficeModal');
      const $proofInput = $('#eo_ica_proof');
      const $proofEye = $('#eo_view_proof');
      const $proofHint = $('#eo_proof_hint');

      const normalizeDateOnly = (d) => new Date(d.getFullYear(), d.getMonth(), d.getDate());

      const computeOverstayAndFine = () => {
        const v = $('#eo_expiry_date').val();
        if (!v) { $('#eo_overstay_days').val('0'); $('#eo_fine_amount').val('0.00'); return; }

        const ed = new Date(v);
        if (isNaN(ed.getTime())) { $('#eo_overstay_days').val('0'); $('#eo_fine_amount').val('0.00'); return; }

        const today = normalizeDateOnly(new Date());
        const exp = normalizeDateOnly(ed);

        let days = 0;
        if (today > exp) {
          const diffMs = today - exp;
          days = Math.floor(diffMs / (1000 * 60 * 60 * 24));
        }
        $('#eo_overstay_days').val(days);
        $('#eo_fine_amount').val((days * 50).toFixed(2));
      };

      $('#eo_expiry_date, #eo_returned_date').on('change', computeOverstayAndFine);
      $('#eo_close, #eo_cancel').on('click', function () { $editModal.hide(); });

      $(document).on('click', '.btn-edit-office', function () {
        const b = $(this);
        $('#editOfficeForm')[0].reset();

        const officeId = b.data('office-id') || '';
        const candidateId = b.data('candidate-id') || '';
        const name = b.data('name') || '';
        const passport = b.data('passport-no') || '';
        const nationality = b.data('nationality') || '';
        const category = b.data('category') || '';
        const returned = b.data('returned-date') || '';
        const expiry = b.data('expiry-date') || '';
        const passportStatus = b.data('passport-status') || '';
        const proof = b.data('ica-proof') || '';

        $('#eo_office_id').val(officeId);
        $('#eo_candidate_id').val(candidateId);
        $('#eo_name').val(name);
        $('#eo_passport_no').val(passport);
        $('#eo_nationality').val(nationality);
        $('#eo_category').val(category);
        $('#eo_returned_date').val(returned);
        $('#eo_expiry_date').val(expiry);
        $('#eo_passport_status').val(passportStatus);

        if (proof) {
          const href = `${window.location.origin}/storage/${proof}`.replace(/([^:])\/{2,}/g, '$1/');
          $proofEye.attr('href', href).show();
          $proofHint.text('Proof is already uploaded. You may replace it by selecting a new file.');
          $proofInput.prop('required', false);
        } else {
          $proofEye.hide().attr('href', '#');
          $proofHint.text('No proof on file. Upload is required.');
          $proofInput.prop('required', true);
        }

        computeOverstayAndFine();
        $editModal.css('display', 'flex');
      });

      $proofInput.on('change', function () {
        const ext = (this.value.split('.').pop() || '').toLowerCase();
        const ok = ['jpg', 'jpeg', 'png', 'pdf'];
        if (ext && !ok.includes(ext)) {
          toastr.error('Only JPG, JPEG, PNG, or PDF are allowed.');
          $(this).val('');
        }
      });

      $('#eo_save_btn').on('click', function () {
        const req = ['#eo_candidate_id', '#eo_name', '#eo_passport_no', '#eo_nationality', '#eo_category', '#eo_returned_date', '#eo_expiry_date', '#eo_passport_status'];
        for (const sel of req) {
          if (!$(sel).val()) { toastr.error('Please fill all required fields.'); return; }
        }
        if ($proofInput.prop('required') && !$proofInput.val()) { toastr.error('Proof is required.'); return; }

        computeOverstayAndFine();

        const fd = new FormData($('#editOfficeForm')[0]);

        $.ajax({
          url: "<?php echo e(route('employee.office.save')); ?>",
          type: 'POST',
          headers: { 'X-CSRF-TOKEN': csrf },
          data: fd,
          processData: false,
          contentType: false
        })
          .done(function (res) {
            if (res && res.success) {
              toastr.success(res.message || 'Saved successfully.');
              $editModal.hide();
              location.reload();
            } else {
              toastr.error((res && res.message) || 'Failed to save.');
            }
          })
          .fail(function (xhr) {
            const j = xhr.responseJSON;
            if (j && j.errors) Object.values(j.errors).flat().forEach(m => toastr.error(m));
            else if (j && j.message) toastr.error(j.message);
            else toastr.error('Error saving record.');
          });
      });

      const FINE_PER_DAY_AED = 50;
      const EXPIRY_WINDOW_DAYS = 30;
      const SNOOZE_MS = 60 * 60 * 1000;
      const CHECK_INTERVAL_MS = 60 * 60 * 1000;
      const LS_SNOOZE_UNTIL_KEY = 'expiry_alert_snooze_until';

      const toMoneyAED = (amount) => `${Number(amount || 0).toFixed(2)} AED`;

      const escapeHtml = (str) => String(str || '').replace(/[&<>"'`=\/]/g, s => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;', '/': '&#x2F;', '`': '&#x60;', '=': '&#x3D;'
      })[s]);

      const parseISODate = (iso) => {
        if (!iso) return null;
        const parts = String(iso).split('-').map(x => parseInt(x, 10));
        if (parts.length !== 3 || parts.some(isNaN)) return null;
        const [y, m, d] = parts;
        return new Date(y, m - 1, d, 0, 0, 0, 0);
      };

      const todayMidnight = () => {
        const now = new Date();
        return new Date(now.getFullYear(), now.getMonth(), now.getDate(), 0, 0, 0, 0);
      };

      const snoozeUntilMs = () => {
        const v = localStorage.getItem(LS_SNOOZE_UNTIL_KEY);
        const n = Number(v);
        return isNaN(n) ? 0 : n;
      };

      const isSnoozed = () => Date.now() < snoozeUntilMs();

      const setSnoozeOneHour = () => {
        const until = Date.now() + SNOOZE_MS;
        localStorage.setItem(LS_SNOOZE_UNTIL_KEY, String(until));
        return until;
      };

      const getAlertData = () => {
        const rows = document.querySelectorAll('.employee-row');
        const today = todayMidnight();
        const msDay = 24 * 60 * 60 * 1000;

        const expired = [];
        const soon = [];

        rows.forEach(r => {
          const name = r.getAttribute('data-name') || '';
          const nationality = r.getAttribute('data-nationality') || '';
          const passport = r.getAttribute('data-passport') || '';
          const expiryISO = r.getAttribute('data-expiry') || '';
          const exp = parseISODate(expiryISO);
          if (!exp) return;

          const diff = Math.floor((exp.getTime() - today.getTime()) / msDay);

          if (diff < 0) {
            const overdueDays = Math.abs(diff);
            const fine = overdueDays * FINE_PER_DAY_AED;
            expired.push({ name, nationality, passport, expiryISO, days: overdueDays, fine });
          } else if (diff <= EXPIRY_WINDOW_DAYS) {
            soon.push({ name, nationality, passport, expiryISO, days: diff, fine: 0 });
          }
        });

        expired.sort((a, b) => b.days - a.days);
        soon.sort((a, b) => a.days - b.days);

        return { expired, soon };
      };

      const openExpiryModal = () => { $('#expiryAlertModal').css('display', 'flex'); };
      const closeExpiryModal = () => { $('#expiryAlertModal').hide(); };

      const renderExpiryModal = (data) => {
        const $body = $('#expiryAlertBody').empty();
        let totalDays = 0;
        let totalFine = 0;
        let rowNo = 0;

        $('#expiredCountPill').text(`Expired: ${data.expired.length}`);
        $('#soonCountPill').text(`Expiring Soon: ${data.soon.length}`);

        const fmtDate = (iso) => {
          const dt = parseISODate(iso);
          return dt ? dt.toLocaleDateString(undefined, { day: '2-digit', month: 'short', year: 'numeric' }) : iso;
        };

        const section = (title) => {
          $body.append(`<tr><td colspan="8" style="background:#fff;font-weight:800">${escapeHtml(title)}</td></tr>`);
        };

        const row = (c, statusHtml) => {
          rowNo += 1;
          totalDays += Number(c.days || 0);
          totalFine += Number(c.fine || 0);

          $body.append(`
            <tr>
              <td style="text-align:center">${rowNo}</td>
              <td>${escapeHtml(c.name)}</td>
              <td>${escapeHtml(c.nationality)}</td>
              <td>${escapeHtml(c.passport)}</td>
              <td>${escapeHtml(fmtDate(c.expiryISO))}</td>
              <td>${statusHtml}</td>
              <td style="text-align:center">${c.days}</td>
              <td class="money" style="text-align:right">${toMoneyAED(c.fine)}</td>
            </tr>
          `);
        };

        if (data.expired.length) {
          section('Expired (Fine Applies)');
          data.expired.forEach(c => row(c, `<span class="pill pill-danger">Expired</span>`));
        }

        if (data.soon.length) {
          section(`Nearest to Expire (Next ${EXPIRY_WINDOW_DAYS} Days)`);
          data.soon.forEach(c => {
            const txt = c.days === 0 ? 'Expires Today' : `In ${c.days} days`;
            row(c, `<span class="pill pill-info">${escapeHtml(txt)}</span>`);
          });
        }

        if (!data.expired.length && !data.soon.length) {
          $body.append(`<tr><td colspan="8" style="text-align:center">No expired or near-expiry candidates found.</td></tr>`);
        }

        $('#expiryTotalDays').text(totalDays);
        $('#expiryTotalFine').text(toMoneyAED(totalFine));
      };

      const showExpiryModalIfNeeded = () => {
        if (isSnoozed()) return;
        const data = getAlertData();
        if (!data.expired.length && !data.soon.length) return;
        renderExpiryModal(data);
        openExpiryModal();
      };

      $('#expiryCloseBtn, #expiryAlertClose').on('click', function () { closeExpiryModal(); });

      $('#expirySnoozeBtn').on('click', function () {
        setSnoozeOneHour();
        closeExpiryModal();
        toastr.info('Snoozed for 1 hour.');
      });

      showExpiryModalIfNeeded();
      setInterval(showExpiryModalIfNeeded, CHECK_INTERVAL_MS);
    });
  </script>
</body>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/partials/______office_table.blade.php ENDPATH**/ ?>