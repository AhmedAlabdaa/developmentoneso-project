<?php use Carbon\Carbon; ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif;font-size:14px}
  .table-container{width:100%;overflow-x:auto}
  .table{width:100%;border-collapse:collapse;margin-bottom:20px}
  .table th,.table td{padding:10px 15px;border-bottom:1px solid #ddd;font-size:12px;text-align:left;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .table th{background:#343a40;color:#fff;text-transform:uppercase;font-weight:bold}
  .table-striped tbody tr:nth-of-type(odd){background:#f9f9f9}
  .table-hover tbody tr:hover{background:#f1f9f1}
  .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
  .btn-info{background:#17a2b8}
  .btn-danger{background:#dc3545}
  .btn-warning{background:#ffc107;color:#212529}
  .overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1090}
  .side-panel{position:fixed;top:0;right:0;width:700px;height:100%;background:#fff;z-index:1091;transform:translateX(100%);transition:transform .3s;overflow:auto;box-shadow:-5px 0 15px rgba(0,0,0,.3);border-left:4px solid #007bff}
  .side-panel.open{transform:translateX(0)}
  .side-panel .header{padding:15px;background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;position:relative}
  .side-panel .header .close-btn{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer}
  .side-panel .body{padding:20px;background:#f9f9f9}
  .side-panel .footer{padding:15px;background:#f9f9f9;text-align:right}
  .side-panel .footer button+button{margin-left:10px}
  .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3)}
  .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0;font-size:14px}
  .modal-body{padding:20px;background:#f9f9f9;font-size:12px;max-height:70vh;overflow:auto}
  .modal-footer{padding:15px;background:#f9f9f9;border-radius:0 0 12px 12px}
  .custom-modal .modal-dialog{max-width:880px;margin:0 auto}
  .custom-modal .form-control,.custom-modal .form-select{font-size:12px;border-radius:4px;height:35px}
  .ellipsis-btn{background:#0d6efd}
  .action-popover{position:absolute;z-index:2000;background:#fff;border:1px solid #e0e0e0;border-radius:8px;box-shadow:0 8px 20px rgba(0,0,0,.15);padding:10px;display:none;opacity:0;transform:translateX(20px);transition:transform .2s ease,opacity .2s ease}
  .action-popover.open{display:block;opacity:1;transform:translateX(0)}
  .action-popover .close-pop{position:absolute;top:-8px;right:6px;border:none;background:red;font-size:10px;color:#fff;border-radius:10px;cursor:pointer}
  .action-popover .actions-column{display:flex;flex-direction:row;align-items:center;gap:8px}
  .action-popover .actions-column .btn{width:30px;height:30px;border-radius:6px;margin:0}
  .inst-pill{display:inline-flex;align-items:center;gap:4px;border-radius:14px;padding:2px 8px;font-size:11px;font-weight:600;color:#fff;cursor:pointer}
  .inst-ok{background:#28a745}
  .inst-warn{background:#ffc107;color:#212529}
  .inst-danger{background:#dc3545}
  .blink{animation:blink 1s linear infinite}
  @keyframes blink{50%{opacity:.2}}
  .row-danger{background:#ffe5e5!important}
</style>

<body>
  <div class="table-container">
    <div class="table-container">
      <table class="table table-striped table-hover">
        <?php
          $fmt = 'd M Y';
          $sumContracted = 0.0;
          $sumReceived = 0.0;
          $sumBalance = 0.0;
          $sumSalary = 0.0;
        ?>

        <thead>
          <tr>
            <th>CT#</th>
            <th>Created Date</th>
            <th>Sales Name</th>
            <th>CT Status</th>
            <th>Finance Status</th>
            <th>Invoice No</th>
            <th>Invoice Date</th>
            <th>CN#</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Monthly</th>
            <th>Paid Date</th>
            <th>Payment Mode</th>
            <th>Upcoming Payment</th>
            <th>Installments</th>
            <th>CL #</th>
            <th>Candidate Name</th>
            <th>Nationality</th>
            <th>Customer Name</th>
            <th>Contracted Amount</th>
            <th>Received</th>
            <th>Balance</th>
            <th>Maid Salary</th>
            <th>Package</th>
            <th>Delivered</th>
            <th>Transferred</th>
            <th>Remarks</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>

        <tbody>
          <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $agr = $contract->agreement;
              $cli = $contract->client;
              $inv = $contract->invoice;

              $money = function ($v) {
                if ($v === null || $v === '') return '0.00';
                if (is_numeric($v)) return number_format((float) $v, 2);
                return (string) $v;
              };

              $statusMap = [
                1 => ['label' => 'Pending',    'icon' => 'fas fa-hourglass-half',        'class' => 'btn-primary'],
                2 => ['label' => 'Active',     'icon' => 'fas fa-check-circle',          'class' => 'btn-success'],
                3 => ['label' => 'Exceeded',   'icon' => 'fas fa-exclamation-triangle',  'class' => 'btn-warning'],
                4 => ['label' => 'Cancelled',  'icon' => 'fas fa-times-circle',          'class' => 'btn-danger'],
                5 => ['label' => 'Contracted', 'icon' => 'fas fa-handshake',             'class' => 'btn-success'],
                6 => ['label' => 'Rejected',   'icon' => 'fas fa-ban',                   'class' => 'btn-danger'],
              ];

              $ct = $statusMap[$contract->status] ?? ['label' => 'Unknown', 'icon' => 'fas fa-question-circle', 'class' => 'btn-secondary'];

              $invoiceStatusRaw = $inv?->status ?? null;
              $invoiceStatus = is_string($invoiceStatusRaw) ? strtolower(trim($invoiceStatusRaw)) : $invoiceStatusRaw;

              $financeMap = [
                'pending'   => ['label' => 'Pending',   'icon' => 'fas fa-hourglass-half', 'class' => 'btn-primary'],
                'approved'  => ['label' => 'Approved',  'icon' => 'fas fa-check-circle',   'class' => 'btn-success'],
                'rejected'  => ['label' => 'Rejected',  'icon' => 'fas fa-ban',            'class' => 'btn-danger'],
                'cancelled' => ['label' => 'Cancelled', 'icon' => 'fas fa-times-circle',   'class' => 'btn-danger'],
                'paid'      => ['label' => 'Paid',      'icon' => 'fas fa-receipt',        'class' => 'btn-success'],
                'unpaid'    => ['label' => 'Unpaid',    'icon' => 'fas fa-exclamation-circle', 'class' => 'btn-warning text-dark'],
                'overdue'   => ['label' => 'Overdue',   'icon' => 'fas fa-exclamation-circle', 'class' => 'btn-danger'],
                0 => ['label' => 'Pending',   'icon' => 'fas fa-hourglass-half', 'class' => 'btn-primary'],
                1 => ['label' => 'Approved',  'icon' => 'fas fa-check-circle',   'class' => 'btn-success'],
                2 => ['label' => 'Rejected',  'icon' => 'fas fa-ban',            'class' => 'btn-danger'],
                3 => ['label' => 'Cancelled', 'icon' => 'fas fa-times-circle',   'class' => 'btn-danger'],
                4 => ['label' => 'Paid',      'icon' => 'fas fa-receipt',        'class' => 'btn-success'],
                5 => ['label' => 'Unpaid',    'icon' => 'fas fa-exclamation-circle', 'class' => 'btn-warning text-dark'],
                6 => ['label' => 'Overdue',   'icon' => 'fas fa-exclamation-circle', 'class' => 'btn-danger'],
              ];

              $finance = $financeMap[$invoiceStatus] ?? ['label' => ($invoiceStatusRaw ? (string) $invoiceStatusRaw : '—'), 'icon' => 'fas fa-question-circle', 'class' => 'btn-secondary'];

              $invoiceNo = $inv?->invoice_number ?? $inv?->invoice_no ?? $inv?->reference_no ?? '—';
              $invoiceDateRaw = $inv?->invoice_date ?? $inv?->created_at ?? null;

              $totalItems = (int) ($contract->number_of_installments ?? ($contract->installments_count ?? 0));
              $paidItems  = (int) ($contract->paid_installments ?? 0);

              $upcomingPaymentRaw = $inv?->upcoming_payment_date ?? $contract->nextPaymentDueAt ?? null;

              $disabled = false;
              $blink = false;

              if ($totalItems === 0) {
                $instBtnClass = 'btn-secondary';
                $instIcon = 'fas fa-ban';
                $instLabel = 'No';
                $disabled = true;
              } else {
                if ($paidItems === $totalItems) {
                  $instBtnClass = 'btn-success';
                  $instIcon = 'fas fa-check-circle';
                } else {
                  $d = null;
                  if ($upcomingPaymentRaw) {
                    try { $d = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($upcomingPaymentRaw), false); }
                    catch (\Throwable $e) { $d = null; }
                  }

                  if ($d !== null && $d <= 1) {
                    $instBtnClass = 'btn-danger';
                    $instIcon = 'fas fa-exclamation-circle';
                    $blink = true;
                  } elseif ($d !== null && $d <= 3) {
                    $instBtnClass = 'btn-danger';
                    $instIcon = 'fas fa-exclamation-circle';
                  } elseif ($d !== null && $d <= 7) {
                    $instBtnClass = 'btn-warning text-dark';
                    $instIcon = 'fas fa-exclamation-triangle';
                  } else {
                    $instBtnClass = 'btn-info';
                    $instIcon = 'fas fa-info-circle';
                  }
                }
                $instLabel = "{$paidItems}/{$totalItems}";
              }

              $salesFull = trim(($contract->salesPerson?->first_name ?? '') . ' ' . ($contract->salesPerson?->last_name ?? '')) ?: '—';
              $customerName = trim(($cli?->first_name ?? '') . ' ' . ($cli?->last_name ?? '')) ?: '—';

              $cnNumber = $contract->CN_Number ?? $agr?->CN_Number ?? '—';

              $contractedAmount = $contract->contracted_amount
                ?? $contract->contract_amount
                ?? $agr?->contracted_amount
                ?? $agr?->total_amount
                ?? $agr?->amount
                ?? 0;

              $receivedAmount = $contract->received_amount
                ?? $contract->amount_received
                ?? $agr?->received_amount
                ?? $agr?->amount_received
                ?? 0;

              $balanceAmount = $contract->balance_amount
                ?? $contract->amount_balance
                ?? ((float) $contractedAmount - (float) $receivedAmount);

              $maidSalary = $contract->maid_salary
                ?? $contract->maidSalary
                ?? $contract->salary
                ?? $agr?->maid_salary
                ?? $agr?->maidSalary
                ?? $agr?->salary
                ?? 0;

              $monthlyAmount = ($totalItems > 0) ? ((float) $contractedAmount / $totalItems) : 0;

              $paidDateRaw = $inv?->due_date ?? null;
              $paymentMode = $inv?->payment_method ?? '—';

              $sumContracted += (float) $contractedAmount;
              $sumReceived += (float) $receivedAmount;
              $sumBalance += (float) $balanceAmount;
              $sumSalary += (float) $maidSalary;

              $passportNo = $agr?->passport_no ?? $contract->passport_no ?? $contract->employee?->passport_no ?? '';
            ?>

            <tr>
              <td>
                <?php if($contract->reference_no): ?>
                  <a class="link-primary" href="<?php echo e(route('contracts.show', $contract->reference_no)); ?>"><?php echo e($contract->reference_no); ?></a>
                <?php else: ?>
                  —
                <?php endif; ?>
              </td>
              <td><?php echo e($contract->created_at ? \Carbon\Carbon::parse($contract->created_at)->format($fmt) : '—'); ?></td>
              <td title="<?php echo e($salesFull); ?>"><?php echo e($salesFull); ?></td>
              <td><button class="btn btn-sm <?php echo e($ct['class']); ?>"><i class="<?php echo e($ct['icon']); ?>"></i> <?php echo e($ct['label']); ?></button></td>
              <td><button class="btn btn-sm <?php echo e($finance['class']); ?>"><i class="<?php echo e($finance['icon']); ?>"></i> <?php echo e($finance['label']); ?></button></td>
              <td><?php echo e($invoiceNo); ?></td>
              <td><?php echo e($invoiceDateRaw ? \Carbon\Carbon::parse($invoiceDateRaw)->format($fmt) : '—'); ?></td>
              <td><?php echo e($cnNumber); ?></td>
              <td><?php echo e($contract->contract_start_date ? \Carbon\Carbon::parse($contract->contract_start_date)->format($fmt) : '—'); ?></td>
              <td><?php echo e($contract->contract_end_date ? \Carbon\Carbon::parse($contract->contract_end_date)->format($fmt) : '—'); ?></td>
              <td><?php echo e($money($monthlyAmount)); ?></td>
              <td><?php echo e($paidDateRaw ? \Carbon\Carbon::parse($paidDateRaw)->format($fmt) : '—'); ?></td>
              <td><?php echo e($paymentMode); ?></td>
              <td><?php echo e($upcomingPaymentRaw ? \Carbon\Carbon::parse($upcomingPaymentRaw)->format($fmt) : '—'); ?></td>
              <td>
                <button
                  type="button"
                  class="btn btn-sm <?php echo e($instBtnClass); ?> <?php echo e($blink ? 'btn-blink' : ''); ?> open-contract-installments"
                  data-contract-ref="<?php echo e($contract->reference_no); ?>"
                  data-agreement-ref="<?php echo e($contract->agreement_reference_no); ?>"
                  data-total="<?php echo e($totalItems); ?>"
                  data-paid="<?php echo e($paidItems); ?>"
                  <?php echo e($disabled ? 'disabled' : ''); ?>

                >
                  <i class="<?php echo e($instIcon); ?> me-1"></i><?php echo e($instLabel); ?>

                </button>
              </td>
              <td><?php echo e($cli?->CL_Number ?? '—'); ?></td>
              <td><?php echo e($agr?->candidate_name ?? '—'); ?></td>
              <td><?php echo e($agr?->nationality ?? '—'); ?></td>
              <td><?php echo e($customerName); ?></td>
              <td><?php echo e($money($contractedAmount)); ?></td>
              <td><?php echo e($money($receivedAmount)); ?></td>
              <td><?php echo e($money($balanceAmount)); ?></td>
              <td><?php echo e($money($maidSalary)); ?></td>
              <td><?php echo e($contract->package ?? ''); ?></td>
              <td><?php echo e($contract->maid_delivered ?? ''); ?></td>
              <td><?php echo e($contract->transferred_date ? \Carbon\Carbon::parse($contract->transferred_date)->format($fmt) : ''); ?></td>
              <td><?php echo e($contract->remarks ?? ''); ?></td>
              <td class="text-center">
                <button
                  class="btn btn-icon-only ellipsis-btn open-actions"
                  data-passport="<?php echo e($passportNo); ?>"
                  data-cn="<?php echo e($agr?->CN_Number ?? ''); ?>"
                  data-ref="<?php echo e($agr?->reference_no ?? ''); ?>"
                  data-contract-ref="<?php echo e($contract->reference_no); ?>"
                  data-id="<?php echo e($contract->id); ?>"
                  data-current="<?php echo e($contract->marked ?? ''); ?>"
                  data-status="<?php echo e($contract->status); ?>"
                >
                  <i class="fas fa-ellipsis-h"></i>
                </button>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>

        <tfoot>
          <tr>
            <th>CT#</th>
            <th>Created Date</th>
            <th>Sales Name</th>
            <th>CT Status</th>
            <th>Finance Status</th>
            <th>Invoice No</th>
            <th>Invoice Date</th>
            <th>CN#</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Monthly</th>
            <th>Paid Date</th>
            <th>Payment Mode</th>
            <th>Upcoming Payment</th>
            <th>Installments</th>
            <th>CL #</th>
            <th>Candidate Name</th>
            <th>Nationality</th>
            <th>Customer Name</th>
            <th>Contracted Amount</th>
            <th>Received</th>
            <th>Balance</th>
            <th>Maid Salary</th>
            <th>Package</th>
            <th>Delivered</th>
            <th>Transferred</th>
            <th>Remarks</th>
            <th class="text-center">Actions</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <nav class="py-2">
    <div class="d-flex justify-content-between align-items-center">
      <span class="text-muted small">
        Showing <?php echo e($employees->firstItem()); ?>–<?php echo e($employees->lastItem()); ?> of <?php echo e($employees->total()); ?> results
      </span>
      <ul class="pagination mb-0">
        <?php echo e($employees->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

      </ul>
    </div>
  </nav>

  <div class="overlay"></div>

  <div id="NewOfficePanelToMoveOffice" class="side-panel">
    <div class="header">
      <h5><i class="fas fa-building"></i> CREATE RETURN FORM</h5>
      <div class="close-btn"><i class="fas fa-times-circle"></i></div>
    </div>
    <div class="body">
      <table class="table table-bordered mb-4">
        <tr><th>Sales Name</th><td id="office_sales_name"></td></tr>
        <tr><th>Partner</th><td id="office_partner"></td></tr>
        <tr><th>CN Number</th><td id="office_cn_number"></td></tr>
        <tr><th>CL Number</th><td id="office_cl_number"></td></tr>
        <tr><th>Visa Type</th><td id="office_visa_type"></td></tr>
        <tr><th>Visa Status</th><td id="office_visa_status"></td></tr>
        <tr><th>Package</th><td id="office_package_value"></td></tr>
        <tr><th>Arrived Date</th><td id="office_arrived_date"></td></tr>
        <tr><th>Transferred Date</th><td id="office_transferred_date"></td></tr>
      </table>

      <form id="officeFormInContract" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" id="office_employee_id" name="employee_id">
        <div class="row g-3">
          <div class="col-md-6">
            <label>Category *</label>
            <select id="category" name="category" class="form-select" required>
              <option value="">Select</option>
              <option>Unfit</option>
              <option>Sick</option>
              <option>Sales Return</option>
              <option>Trial Return</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Returned Date *</label>
            <input type="date" id="returned_date" name="returned_date" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Expiry Date *</label>
            <input type="date" id="expiry_date" name="expiry_date" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>ICA Proof *</label>
            <input type="file" id="ica_proof_attachment" name="ica_proof_attachment" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Overstay Days *</label>
            <input type="number" id="overstay_days" name="overstay_days" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Fine Amount *</label>
            <input type="number" id="fine_amount" name="fine_amount" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Passport Status *</label>
            <select id="passport_status" name="passport_status" class="form-select" required>
              <option value="">Select</option>
              <option>With Employer</option>
              <option>With Candidate</option>
              <option>Expired</option>
              <option>Office</option>
              <option>Lost</option>
              <option>Other</option>
            </select>
          </div>
        </div>
      </form>
    </div>
    <div class="footer">
      <button class="btn btn-secondary close-btn">Close</button>
      <button id="saveOfficeBtnEmp" class="btn btn-success">Save</button>
    </div>
  </div>

  <div id="IncidentPanel" class="side-panel">
    <div class="header">
      <h5><i class="fas fa-exclamation-triangle"></i> Report Incident</h5>
      <div class="close-btn"><i class="fas fa-times-circle"></i></div>
    </div>
    <div class="body">
      <form id="incidentForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" id="incident_employee_id" name="employee_id">
        <table class="table table-bordered mb-4">
          <tr><th>Reference No</th><td id="incident_reference_no"></td></tr>
          <tr><th>Candidate Name</th><td id="incident_candidate_name"></td></tr>
          <tr><th>Passport No</th><td id="incident_passport_no"></td></tr>
        </table>
        <div class="row g-3">
          <div class="col-md-6">
            <label>Incident Date *</label>
            <input type="date" id="incident_date" name="incident_date" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Incident Type *</label>
            <select id="incident_type" name="incident_type" class="form-select" required>
              <option value="">Select Type</option>
              <option value="RUNAWAY">RUNAWAY</option>
              <option value="REPATRIATION">REPATRIATION</option>
              <option value="UNFIT">UNFIT</option>
              <option value="REFUSED">REFUSED</option>
              <option value="PSYCHIATRIC">PSYCHIATRIC</option>
            </select>
          </div>
          <div class="col-md-12">
            <label>Comments</label>
            <textarea id="incident_comments" name="comments" class="form-control" rows="3"></textarea>
          </div>
        </div>
      </form>
    </div>
    <div class="footer">
      <button class="btn btn-secondary close-btn">Close</button>
      <button id="saveIncidentBtn" class="btn btn-danger">Save Incident</button>
    </div>
  </div>

  <div class="modal fade" id="replacementModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <form id="replacementForm" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-exchange-alt"></i> Replace Employee</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="rep_contract_number" class="form-label">Contract Number</label>
              <input type="text" id="rep_contract_number" name="contract_number" class="form-control" readonly required>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="rep_old_employee" class="form-label">Current Employee</label>
                <input type="text" id="rep_old_employee" class="form-control" readonly required>
              </div>
              <div class="col-md-6">
                <label for="rep_client_name" class="form-label">Client Name</label>
                <input type="text" id="rep_client_name" class="form-control" readonly required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-4">
                <label for="rep_contract_start" class="form-label">Contract Start</label>
                <input type="date" id="rep_contract_start" class="form-control" readonly required>
              </div>
              <div class="col-md-4">
                <label for="rep_contract_end" class="form-label">Contract End</label>
                <input type="date" id="rep_contract_end" class="form-control" readonly required>
              </div>
              <div class="col-md-4">
                <label for="rep_total_amount" class="form-label">Total Amount</label>
                <input type="text" id="rep_total_amount" name="total_amount" class="form-control" readonly required>
              </div>
            </div>
            <div class="mb-3">
              <label for="replacement_employee" class="form-label">Select Replacement Employee *</label>
              <select id="replacement_employee" name="replacement_employee" class="form-control select2" required>
                <option value="">Select Employee</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="rep_replacement_date" class="form-label">Replacement Date *</label>
              <input type="date" id="rep_replacement_date" name="replacement_date" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="rep_proof" class="form-label">Proof *</label>
              <input type="file" id="rep_proof" name="proof" class="form-control" required>
            </div>
            <div id="rep_confirmation" class="alert alert-warning d-none">
              Do you agree to replace <strong id="rep_old_name"></strong> with <strong id="rep_new_name"></strong>?
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" id="saveReplacement" class="btn btn-warning">Confirm Replacement</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade custom-modal" id="UpdateContractModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <?php if(auth()->check() && in_array(auth()->user()->role, ['Admin', 'Managing Director','Sales Officer'])): ?>
        <form id="UpdateContractForm" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="fas fa-file-contract"></i> Update Contract</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <div class="alert alert-warning mb-4">
                Updating for: <strong id="alertCandidateName"></strong>
              </div>

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
              <input type="hidden" name="remaining_amount" id="hidden_balance" value="0" data-orig="">
              <input type="hidden" name="payment_terms" id="hidden_payment_terms" value="full">
              <input type="hidden" name="number_of_days" id="hidden_number_of_days">
              <input type="hidden" name="installment_count" id="installmentCount" value="0">

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label for="packageSelect" class="form-label">Package</label>
                  <select id="packageSelect" name="package" class="form-select" required>
                    <option value="">Select Package</option>
                    <option value="PKG-2">PKG-2</option>
                    <option value="PKG-3">PKG-3</option>
                    <option value="PKG-4">PKG-4</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="clientSelect" class="form-label">Client</label>
                  <select id="clientSelect" name="client_id" class="form-select select2" required>
                    <option value="">Select Client</option>
                  </select>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label for="contractReferenceNo" class="form-label">Contract Ref No</label>
                  <input type="text" id="contractReferenceNo" name="contract_reference_no" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label for="agreementReferenceNo" class="form-label">Agreement Ref No</label>
                  <input type="text" id="agreementReferenceNo" name="agreement_reference_no" class="form-control" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label for="maidTransfer" class="form-label">Maid Transfer</label>
                  <select id="maidTransfer" name="maid_delivered" class="form-select" required>
                    <option value="">Maid Transfer</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="contractStatus" class="form-label">Status</label>
                  <select id="contractStatus" name="status" class="form-select" required>
                    <option value="">Status</option>
										<option value="1">Pending</option>
										<option value="2">Active</option>
										<option value="3">Exceeded</option>
										<option value="4">Cancelled</option>
										<option value="5">Contracted</option>
										<option value="6">Rejected</option>
                  </select>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label for="contractStart" class="form-label">Contract Start</label>
                  <input type="date" id="contractStart" name="contract_start_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label for="contractEnd" class="form-label">Contract End</label>
                  <input type="date" id="contractEnd" name="contract_end_date" class="form-control" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label for="contractDuration" class="form-label">Duration</label>
                  <input type="text" id="contractDuration" class="form-control" readonly>
                </div>
                <div class="col-md-6">
                  <label for="contractMonthly" class="form-label">Monthly Payment</label>
                  <input type="number" id="contractMonthly" name="monthly_payment" class="form-control" step="0.01" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label">Initial Payment & Duration</label>
                  <div class="input-group">
                    <input type="number" id="contractInitial" name="initial_payment" class="form-control" step="0.01" required>
                    <select id="contractMonthsCount" name="months_count" class="form-select" required>
                      <?php for($i=1; $i<=24; $i++): ?>
                        <option value="<?php echo e($i); ?>"><?php echo e($i); ?> Month<?php echo e($i>1?'s':''); ?></option>
                      <?php endfor; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="contractCycle" class="form-label">Payment Cycle</label>
                  <select id="contractCycle" name="payment_cycle" class="form-select" required>
                    <option value="0">LUMPSUMP</option>
                    <?php for($i=1; $i<=12; $i++): ?>
                      <option value="<?php echo e($i); ?>"><?php echo e($i); ?> Month<?php echo e($i>1?'s':''); ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>

              <table id="installmentsTable" class="table table-bordered mb-3" style="display:none;">
                <thead>
                  <tr>
                    <th>Installment Date *</th>
                    <th>Reference No</th>
                    <th>Amount *</th>
                    <th>Payment Proof</th>
                    <th style="width:60px">
                      <button type="button" id="addInstallmentRow" class="btn btn-sm btn-info">
                        <i class="fas fa-plus"></i>
                      </button>
                    </th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label for="contractSalary" class="form-label">Salary</label>
                  <input type="number" id="contractSalary" name="salary" class="form-control" step="0.01" required>
                </div>
                <div class="col-md-6">
                  <label for="contractUpcoming" class="form-label">Upcoming Payment</label>
                  <input type="date" id="contractUpcoming" name="upcoming_payment_date" class="form-control" readonly required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label for="contractCurrentSalary" class="form-label">Current Month Salary</label>
                  <input type="text" id="contractCurrentSalary" name="current_month_salary" class="form-control" readonly>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label for="contractPaymentMethod" class="form-label">Initial Payment Method</label>
                  <select id="contractPaymentMethod" name="payment_method" class="form-select" required>
                    <option value="">Select Method</option>
                    <option>Bank Transfer ADIB</option>
                    <option>Bank Transfer ADCB</option>
                    <option>POS-ID 60043758</option>
                    <option>POS-ID 60045161</option>
                    <option>ADIB-19114761</option>
                    <option>ADIB-19136783</option>
                    <option>Cash</option>
                    <option>Cheque</option>
                    <option>Replacement</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="contractPaymentProof" class="form-label">Initial Payment Proof</label>
                  <input type="file" id="contractPaymentProof" name="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label">Contract Signed Copy *</label>
                  <input type="file" id="contractSignedCopy" name="contract_signed_copy" class="form-control" accept=".pdf,.jpg,.png" required>
                </div>
                <div class="col-md-6" id="existingSignedCopyContainer"></div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" id="saveUpdateContract" class="btn btn-info">Save Full Payment</button>
            </div>
          </div>
        </form>
      <?php else: ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-file-contract"></i> Update Contract</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger mb-0">
              You have not rights to update.
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="modal fade" id="signedCopyModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Contract Signed Copy</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-0">
          <iframe id="signedCopyFrame" style="width:100%;height:80vh;border:0"></iframe>
        </div>
      </div>
    </div>
  </div>

  <div id="actionPopover" class="action-popover">
    <button class="close-pop"><i class="fas fa-times"></i></button>
    <div class="actions-column">
      <button type="button" class="btn btn-info btn-sm act-office"><i class="fas fa-building"></i></button>
      <button type="button" class="btn btn-danger btn-sm act-incident"><i class="fas fa-exclamation-triangle"></i></button>
      <button type="button" class="btn btn-warning btn-sm act-replacement"><i class="fas fa-exchange-alt"></i></button>
      <button type="button" class="btn btn-sm act-mark"><i class="fas fa-check-circle"></i></button>
      <button type="button" class="btn btn-primary btn-sm act-upload"><i class="fas fa-upload"></i></button>
    </div>
  </div>

  <div class="modal fade" id="contractInstallmentsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-gradient-primary text-white">
          <h5 class="modal-title">Installment Items – <span id="cInstRef"></span></h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="cInstAlert" class="alert d-none mb-3"></div>
          <table class="table table-bordered">
            <thead class="table-secondary">
              <tr>
                <th>#</th>
                <th>Particular</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Paid Date</th>
                <th>Status</th>
                <th>Invoice</th>
              </tr>
            </thead>
            <tbody id="cInstBody"></tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <script>
    (function(){
      let calcData={totalMonths:0,daysLeft:0};
      let actionCtx=null;
      const $popover=$('#actionPopover');
      const csrf='<?php echo e(csrf_token()); ?>';

      function toLocalDateString(d){return d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0')+'-'+String(d.getDate()).padStart(2,'0')}
      function openSidePanel(sel){$('.overlay').fadeIn(300);$(sel).addClass('open')}
      function closeSidePanels(){$('.side-panel.open').removeClass('open');$('.overlay').fadeOut(300)}
      $('.overlay, .side-panel .close-btn').on('click',closeSidePanels);

      window.showOffice=function(passportNo){
        openSidePanel('#NewOfficePanelToMoveOffice');
        $.post(`<?php echo e(route('employees.update-status-inside',['employeeId'=>':id'])); ?>`.replace(':id',encodeURIComponent(passportNo)),{status_id:1,_token:csrf}).done(res=>{
          let d=res.candidateDetails;
          $('#office_sales_name').text(d.salesName);
          $('#office_partner').text(d.foreignPartner);
          $('#office_cn_number').text(d.cnNumber);
          $('#office_cl_number').text(d.clNumber);
          $('#office_visa_type').text(d.visaType);
          $('#office_visa_status').text(d.visaStatus);
          $('#office_package_value').text(d.package);
          $('#office_arrived_date').text(d.arrivedDate);
          $('#office_transferred_date').text(d.transferredDate);
          $('#office_employee_id').val(d.candidateId);
        });
      };

      window.showIncident=function(passportNo){
        openSidePanel('#IncidentPanel');
        $.post(`<?php echo e(route('employees.update-status-inside',['employeeId'=>':id'])); ?>`.replace(':id',encodeURIComponent(passportNo)),{status_id:3,_token:csrf}).done(res=>{
          let d=res.candidateDetails;
          $('#incident_reference_no').text(d.referenceNo);
          $('#incident_candidate_name').text(d.candidateName);
          $('#incident_passport_no').text(d.passportNo);
          $('#incident_employee_id').val(d.candidateId);
          $('#incident_date,#incident_type,#incident_comments').val('');
        });
      };

      function computeDuration(){
        let s=$('#contractStart').val(),e=$('#contractEnd').val();
        if(!s||!e){$('#contractDuration').val('');calcData={totalMonths:0,daysLeft:0};return}
        let sd=new Date(s),ed=new Date(e);
        let y=ed.getFullYear()-sd.getFullYear();
        let m=ed.getMonth()-sd.getMonth();
        let months=y*12+m;
        let dayDiff=ed.getDate()-sd.getDate();
        if(dayDiff<0){months--;let prev=new Date(ed.getFullYear(),ed.getMonth(),0);dayDiff=prev.getDate()-sd.getDate()+ed.getDate()}
        calcData={totalMonths:months,daysLeft:dayDiff};
        $('#contractDuration').val(months+' Month'+(months>1?'s':'')+(dayDiff>0?' '+dayDiff+' Day'+(dayDiff>1?'s':''):'')); 
      }

      function computeInitialPayment(){
        let mp=parseFloat($('#contractMonthly').val())||0;
        let mc=parseInt($('#contractMonthsCount').val())||0;
        let base=mp*mc;
        let extra=calcData.daysLeft>0?mp/30*calcData.daysLeft:0;
        $('#contractInitial').val((base+extra).toFixed(2));
      }

      function computeUpcoming(){
        let s=$('#contractStart').val();
        let mc=parseInt($('#contractMonthsCount').val())||0;
        if(!s){$('#contractUpcoming').val('');return}
        let d=new Date(s);
        if(mc===calcData.totalMonths){$('#contractUpcoming').val(toLocalDateString(new Date()));return}
        d.setMonth(d.getMonth()+mc);
        $('#contractUpcoming').val(toLocalDateString(d));
      }

      function computeCurrentSalary(){
        let sal=parseFloat($('#contractSalary').val())||0;
        let t=new Date();
        let dim=new Date(t.getFullYear(),t.getMonth()+1,0).getDate();
        let rem=dim-t.getDate()+1;
        $('#contractCurrentSalary').val((sal/dim*rem).toFixed(2));
      }

      function updateMonthsCountValidation(){
        let total=calcData.totalMonths;
        $('#contractMonthsCount option').each(function(){$(this).prop('disabled',parseInt(this.value)>total)});
        let mc=parseInt($('#contractMonthsCount').val())||0;
        if(mc>total){mc=total;$('#contractMonthsCount').val(total)}
        if(mc===total){$('#addInstallmentRow').prop('disabled',true)}else{$('#addInstallmentRow').prop('disabled',false)}
      }

      function generateInstallments(){
        let tbody=$('#installmentsTable tbody').empty();
        let s=$('#contractStart').val();
        let mc=parseInt($('#contractMonthsCount').val())||0;
        let pc=parseInt($('#contractCycle').val())||0;
        if(!s||pc===0){$('#installmentCount').val(0);return}
        let sd=new Date(s);
        let d0=new Date(sd);
        d0.setMonth(d0.getMonth()+mc);
        if(calcData.daysLeft>0)d0.setDate(d0.getDate()+calcData.daysLeft);
        let startInst=calcData.daysLeft>0?new Date(d0.getFullYear(),d0.getMonth()+1,1):new Date(d0);
        let endDate=new Date($('#contractEnd').val());
        let dt=new Date(startInst);
        let count=0;
        while(dt<=endDate){
          let dateStr=toLocalDateString(dt);
          let amt=parseFloat($('#contractMonthly').val())||0;
          tbody.append('<tr><td><input name="inst_date[]" type="date" class="form-control" value="'+dateStr+'" required></td><td><input name="inst_ref[]" type="text" class="form-control" required></td><td><input name="inst_amount[]" type="number" class="form-control" value="'+amt.toFixed(2)+'" required></td><td><input name="inst_proof[]" type="file" class="form-control"></td><td><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="fas fa-trash-alt"></i></button></td></tr>');
          count++;
          dt.setMonth(dt.getMonth()+pc);
        }
        $('#installmentCount').val(count);
      }

      function togglePaymentMode(){
        let cycle=parseInt($('#contractCycle').val())||0;
        if(cycle===0){$('#installmentsTable').hide();$('#saveUpdateContract').text('Save Full Payment');$('#hidden_balance').val(0);$('#hidden_payment_terms').val('full')}
        else{$('#installmentsTable').show();$('#saveUpdateContract').text('Save Partial Payment');$('#hidden_balance').val($('#hidden_balance').data('orig')||$('#hidden_balance').val());$('#hidden_payment_terms').val('partial')}
      }

      function positionPopover($btn){
        const off = $btn.offset();
        const spacing = 8;
        const top = off.top - 2;
        const right = $(window).width() - (off.left + $btn.outerWidth()) - spacing;
        $popover.css({left:'auto', right:right, top:top});
      }

      function openPopover($btn){
        closePopover();
        actionCtx={
          passport:$btn.data('passport')||'',
          cn:$btn.data('cn')||'',
          ref:$btn.data('ref')||'',
          id:$btn.data('id')||'',
          contractRef:$btn.data('contract-ref')||'',
          current:($btn.data('current')||''),
          status:$btn.data('status')||''
        };
        positionPopover($btn);
        const $markBtn=$popover.find('.act-mark');
        $markBtn.removeClass('btn-success btn-danger').addClass(actionCtx.current==='Yes'?'btn-success':'btn-danger');
        $markBtn.find('i').attr('class',actionCtx.current==='Yes'?'fas fa-check-circle':'fas fa-times-circle');
        $popover.show().addClass('open').css('opacity',1);
      }

      function closePopover(){
        $popover.removeClass('open').css('opacity',0).hide();
      }

      function openUploadModal(ref){
        $.post('<?php echo e(route("contracts.detailsAll")); ?>',{agreement_reference_no:ref,_token:csrf}).done(d=>{
          $('#alertCandidateName').text(d.agreement.candidate_name);
          $('#contract_candidate_id').val(d.agreement.candidate_id);
          $('#contract_candidate_name').val(d.agreement.candidate_name);
          $('#contract_dob').val(d.agreement.date_of_birth);
          $('#contract_nationality').val(d.agreement.nationality);
          $('#contract_passport_no').val(d.agreement.passport_no);
          $('#contract_passport_expiry').val(d.agreement.passport_expiry_date);
          $('#contract_ref_no').val(d.agreement_reference_no);
          $('#contractReferenceNo').val(d.contract.reference_no);
          $('#agreementReferenceNo').val(d.contract.agreement_reference_no);
          $('#maidTransfer').val(d.contract.maid_delivered);
          $('#contractStatus').val(d.contract.status);
          $('#contractStart').val(d.contract.contract_start_date);
          $('#contractEnd').val(d.contract.contract_end_date);
          $('#contractMonthly').val(parseFloat(d.agreement.monthly_payment||0).toFixed(2));
          $('#contractSalary').val(parseFloat(d.agreement.salary||0).toFixed(2));
          $('#hidden_total_amount').val(d.agreement.total_amount);
          $('#hidden_received_amount').val(d.agreement.received_amount);
          $('#hidden_balance').val(d.agreement.remaining_amount).data('orig',d.agreement.remaining_amount);
          $('#hidden_payment_terms').val(d.agreement.payment_terms);
          $('#hidden_number_of_days').val(d.agreement.number_of_days);
          $('#installmentCount').val(d.installments.length);

          let $clientSel=$('#clientSelect').empty().append('<option value="">Select Client</option>');
          d.clients.forEach(c=>{$clientSel.append('<option value="'+c.id+'">'+c.first_name+' '+c.last_name+'</option>')});
          $clientSel.val(d.client_id).trigger('change');

          $('#packageSelect').val(d.agreement.package).trigger('change');

          computeDuration();
          computeInitialPayment();
          computeUpcoming();
          computeCurrentSalary();
          updateMonthsCountValidation();
          generateInstallments();
          togglePaymentMode();

          let $tb=$('#installmentsTable tbody').empty();
          d.installments.forEach(item=>{
            let proofLink=item.payment_proof?'<a href="'+item.payment_proof+'" target="_blank"><i class="fas fa-eye"></i></a>':'';
            $tb.append('<tr><td><input name="inst_date[]" type="date" class="form-control" value="'+item.payment_date+'" required></td><td><input name="inst_ref[]" type="text" class="form-control" value="'+item.reference_no+'" required></td><td><input name="inst_amount[]" type="number" class="form-control" value="'+parseFloat(item.amount||0).toFixed(2)+'" required></td><td><input name="inst_proof[]" type="file" class="form-control">'+proofLink+'</td><td><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="fas fa-trash-alt"></i></button></td></tr>');
          });

          if(d.contract.contract_signed_copy){$('#existingSignedCopyContainer').html('<a href="'+d.contract.contract_signed_copy+'" target="_blank"><i class="fas fa-eye"></i> View Signed Copy</a>')}
          new bootstrap.Modal($('#UpdateContractModal')).show();
        });
      }

      function showContractInstallments(ref,agreementNo){
        const $m=$('#contractInstallmentsModal');
        $('#cInstRef').text(ref);
        const $body=$('#cInstBody').html('<tr><td colspan="7" class="text-center py-4"><div class="spinner-border"></div></td></tr>');
        $('#cInstAlert').addClass('d-none').removeClass('alert-danger alert-warning alert-success').empty();
        $m.modal('show');
        $.post('<?php echo e(route("contracts.installments.items")); ?>',{reference_no:ref,agreement_reference_no:agreementNo,_token:csrf})
          .done(items=>{
            if(!Array.isArray(items)||!items.length){
              $body.html('<tr><td colspan="7" class="text-center">No items.</td></tr>');
              return;
            }
            const dtf=new Intl.DateTimeFormat('en-GB',{day:'2-digit',month:'short',year:'numeric'});
            const daysLeft = d => Math.floor((new Date(d) - new Date())/86400000);
            const pending=items.filter(i=>Number(i.invoice_generated)===0).sort((a,b)=>new Date(a.payment_date)-new Date(b.payment_date));
            if(pending.length){
              const first=pending[0]; const dl=daysLeft(first.payment_date);
              if(dl<=2){ $('#cInstAlert').removeClass('d-none').addClass('alert-danger').html('<i class="fas fa-bell me-2"></i>Payment date '+dtf.format(new Date(first.payment_date))+' is in '+(dl<=0?'past':'less than 2 days')+'. Invoice not generated yet.'); }
              else if(dl<=3){ $('#cInstAlert').removeClass('d-none').addClass('alert-danger').html('<i class="fas fa-exclamation-circle me-2"></i>Payment date '+dtf.format(new Date(first.payment_date))+' is in less than 3 days. Invoice not generated yet.'); }
              else if(dl<=7){ $('#cInstAlert').removeClass('d-none').addClass('alert-warning').html('<i class="fas fa-exclamation-triangle me-2"></i>Payment date '+dtf.format(new Date(first.payment_date))+' is within a week. Invoice not generated yet.'); }
              else { $('#cInstAlert').removeClass('d-none').addClass('alert-success').html('<i class="fas fa-check-circle me-2"></i>No urgent installments.'); }
            }else{
              $('#cInstAlert').removeClass('d-none').addClass('alert-success').html('<i class="fas fa-check-circle me-2"></i>All invoices are generated for upcoming installments.');
            }
            let i=0,html='';
            for(const it of items){
              const btn = Number(it.invoice_generated)===1
                ? '<button type="button" class="btn btn-sm btn-info view-invoice-btn" data-invoice="'+it.invoice_number+'"><i class="fas fa-eye"></i> View</button>'
                : '<button type="button" class="btn btn-sm btn-success generate-invoice-btn" data-id="'+it.id+'"><i class="fas fa-file-invoice-dollar"></i> Generate</button>';
              const rowDanger = (Number(it.invoice_generated)===0 && daysLeft(it.payment_date)<=2) ? ' style="background:#ffe5e5"' : '';
              html += '<tr'+rowDanger+'><td>'+(++i)+'</td><td>'+escapeHtml(it.particular)+'</td><td>'+Number(it.amount).toFixed(2)+'</td><td>'+dtf.format(new Date(it.payment_date))+'</td><td>'+(it.paid_date?dtf.format(new Date(it.paid_date)):'N/A')+'</td><td>'+(it.status||'Pending')+'</td><td>'+btn+'</td></tr>';
            }
            $body.html(html);
          })
          .fail(()=>{$body.html('<tr><td colspan="7" class="text-center text-danger">Failed to load.</td></tr>')});
      }

      function escapeHtml(s){return String(s??'').replace(/[&<>"']/g,c=>({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;' }[c]))}

      $(function(){
        $('.select2').each(function(){
          let $el=$(this);
          let parent=$el.closest('.modal');
          $el.select2({width:'100%',dropdownParent:parent.length?parent:$(document.body)});
        });

        computeDuration();
        computeInitialPayment();
        computeUpcoming();
        computeCurrentSalary();
        updateMonthsCountValidation();
        generateInstallments();
        togglePaymentMode();

        $('#contractStart,#contractEnd').on('change',function(){
          computeDuration();
          computeInitialPayment();
          computeUpcoming();
          updateMonthsCountValidation();
          generateInstallments();
          togglePaymentMode();
        });

        $('#contractMonthly,#contractMonthsCount').on('input change',function(){
          computeInitialPayment();
          computeUpcoming();
          updateMonthsCountValidation();
          generateInstallments();
          togglePaymentMode();
        });

        $('#contractSalary').on('input change',computeCurrentSalary);

        $('#contractCycle').on('change',function(){
          generateInstallments();
          togglePaymentMode();
        });

        $('#addInstallmentRow').on('click',function(){
          Swal.fire({title:'Add Installment',icon:'question',showCancelButton:true,confirmButtonText:'Yes'}).then(r=>{
            if(!r.isConfirmed)return;
            let dateVal=toLocalDateString(new Date());
            let amt=parseFloat($('#contractMonthly').val())||0;
            $('#installmentsTable tbody').append('<tr><td><input name="inst_date[]" type="date" class="form-control" value="'+dateVal+'" required></td><td><input name="inst_ref[]" type="text" class="form-control"></td><td><input name="inst_amount[]" type="number" class="form-control" value="'+amt.toFixed(2)+'" required></td><td><input name="inst_proof[]" type="file" class="form-control"></td><td><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="fas fa-trash-alt"></i></button></td></tr>');
            $('#installmentCount').val($('#installmentsTable tbody tr').length);
          });
        });

        $(document).on('click','.btn-remove',function(){
          let row=$(this).closest('tr');
          Swal.fire({title:'Remove Installment',icon:'warning',showCancelButton:true,confirmButtonText:'Yes'}).then(r=>{
            if(r.isConfirmed){row.remove();$('#installmentCount').val($('#installmentsTable tbody tr').length);Swal.fire('Removed!','','success')}
          });
        });

        $('#replacement_employee').on('change',function(){
          let newName=$(this).find('option:selected').data('name');
          if(newName){$('#rep_old_name').text($('#rep_old_employee').val());$('#rep_new_name').text(newName);$('#rep_confirmation').removeClass('d-none')}
          else{$('#rep_confirmation').addClass('d-none')}
        });

        $('#replacementForm').on('submit',function(e){
          e.preventDefault();
          let ref=$('#rep_contract_number').val();
          let url=`<?php echo e(url('contracts')); ?>/${ref}/replace`;
          let fd=new FormData(this);
          $.ajax({url,method:'POST',data:fd,processData:false,contentType:false}).done(res=>{
            toastr.success(res.message);
            bootstrap.Modal.getInstance($('#replacementModal')[0]).hide();
            setTimeout(()=>location.reload(),1000);
          });
        });

        $('#saveOfficeBtnEmp').on('click',function(){
          let btn=$(this).prop('disabled',true);
          let fd=new FormData($('#officeFormInContract')[0]);
          $.ajax({url:'<?php echo e(route("employees.officeSave")); ?>',method:'POST',data:fd,processData:false,contentType:false}).done(r=>{
            toastr.success(r.message);
            setTimeout(()=>location.reload(),1000);
          }).fail(e=>{
            toastr.error(e.responseJSON?.message||'Failed to save.');
            btn.prop('disabled',false);
          });
        });

        $('#saveIncidentBtn').on('click',function(){
          let btn=$(this).prop('disabled',true);
          let fd=new FormData($('#incidentForm')[0]);
          fd.append('_token',csrf);
          $.ajax({url:'<?php echo e(route("employees.incidentSave")); ?>',method:'POST',data:fd,processData:false,contentType:false}).done(r=>{
            toastr.success(r.message);
            setTimeout(()=>location.reload(),1000);
          }).fail(e=>{
            toastr.error(e.responseJSON?.message||'Failed to save incident.');
            btn.prop('disabled',false);
          });
        });

        $('#saveUpdateContract').click(function(){
          let fd=new FormData($('#UpdateContractForm')[0]);
          $.ajax({url:'<?php echo e(route("contracts.update-contract")); ?>',method:'POST',data:fd,processData:false,contentType:false}).done(res=>{
            toastr.success('Contract updated');
            bootstrap.Modal.getInstance($('#UpdateContractModal')[0]).hide();
            setTimeout(()=>location.reload(),1000);
          }).fail(xhr=>{
            toastr.error(xhr.responseJSON?.message||'Error updating contract');
          });
        });

        $(document).on('click','.open-actions',function(e){
          e.stopPropagation();
          openPopover($(this));
        });

        $(document).on('click','.open-contract-installments',function(){
          const ref=$(this).data('contract-ref');
          const agr=$(this).data('agreement-ref');
          showContractInstallments(ref,agr);
        });

        $(document).on('click','.generate-invoice-btn',async function(){
          const btn=this; btn.disabled=true;
          try{
            const r=await fetch('<?php echo e(route('installments.generate-invoice')); ?>',{method:'POST',headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json','Content-Type':'application/json'},body:JSON.stringify({id:btn.dataset.id})});
            const j=await r.json();
            if(j.status==='success'){
              toastr.success('Invoice generated.');
              btn.outerHTML='<button type="button" class="btn btn-sm btn-info view-invoice-btn" data-invoice="'+j.invoice_number+'"><i class="fas fa-eye"></i> View</button>';
            }else{
              toastr.error(j.message||'Error'); btn.disabled=false;
            }
          }catch(e){ toastr.error('Server error'); btn.disabled=false; }
        });

        $(document).on('click','.view-invoice-btn',function(){
          window.open('/invoices/'+$(this).data('invoice'),'_blank');
        });

        $popover.on('click',function(e){e.stopPropagation()});
        $(document).on('click',function(){closePopover()});
        $(window).on('scroll resize',function(){closePopover()});
        $popover.find('.close-pop').on('click',function(){closePopover()});

        $popover.find('.act-office').on('click',function(){
          if(!actionCtx)return;
          closePopover();
          showOffice(actionCtx.passport);
        });

        $popover.find('.act-incident').on('click',function(){
          if(!actionCtx)return;
          closePopover();
          showIncident(actionCtx.passport);
        });

        $popover.find('.act-replacement').on('click',function(){
          if(!actionCtx)return;
          closePopover();
          $.post('<?php echo e(route("contracts.detailsAll")); ?>',{agreement_reference_no:actionCtx.ref,_token:csrf}).done(d=>{
            $('#rep_contract_number').val(d.contract.reference_no);
            $('#rep_old_employee').val(d.agreement.candidate_name);
            $('#rep_client_name').val(d.customer_name.trim());
            $('#rep_contract_start').val(d.contract.contract_start_date);
            $('#rep_contract_end').val(d.contract.contract_end_date);
            $('#rep_total_amount').val(d.agreement.total_amount);
            $('#rep_replacement_date').val(toLocalDateString(new Date()));
            let $sel=$('#replacement_employee').empty().append('<option value="">Select Employee</option>');
            d.employees.forEach(emp=>{$sel.append('<option value="'+emp.id+'" data-name="'+emp.name+'">'+emp.name+'</option>')});
            $('#replacement_employee').trigger('change');
            new bootstrap.Modal($('#replacementModal')).show();
          });
        });

        $popover.find('.act-mark').on('click',function(){
          if(!actionCtx)return;
          let next=actionCtx.current==='Yes'?'No':'Yes';
          Swal.fire({title:`Mark as ${next}?`,icon:'question',showCancelButton:true,confirmButtonText:'Yes',cancelButtonText:'No'}).then(r=>{
            if(!r.isConfirmed)return;
            $.post('<?php echo e(route("contracts.toggleMarked")); ?>',{id:actionCtx.id,reference_no:actionCtx.contractRef,marked:next,_token:csrf}).done(res=>{
              toastr.success(res.message);
              actionCtx.current=next;
              const $markBtn=$popover.find('.act-mark');
              $markBtn.removeClass('btn-success btn-danger').addClass(actionCtx.current==='Yes'?'btn-success':'btn-danger');
              $markBtn.find('i').attr('class',actionCtx.current==='Yes'?'fas fa-check-circle':'fas fa-times-circle');
            });
          });
        });

        $popover.find('.act-upload').on('click',function(){
          if(!actionCtx)return;
          closePopover();
          openUploadModal(actionCtx.ref);
        });
      });
    })();
  </script>
</body>
<?php /**PATH /home/developmentoneso/public_html/resources/views/employee/partials/contracted_table.blade.php ENDPATH**/ ?>