<?php
  use Carbon\Carbon;

  $shortPartner = function ($v) {
    $v = trim((string) $v);
    if ($v === '') return '';
    $p = preg_split('/\s+/', $v);
    return $p[0] ?? '';
  };

  $FINE_PER_DAY_AED = 50;
  $today = Carbon::now('Asia/Dubai')->startOfDay();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif;font-size:14px}
  .table-container{width:100%;overflow-x:auto}
  .table{width:100%;border-collapse:collapse;margin-bottom:20px}
  .table th,.table td{padding:10px 15px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;vertical-align:middle;border-bottom:1px solid #ddd;font-size:12px}
  .table th{background:#343a40;color:#fff;text-transform:uppercase;font-weight:bold}
  .table-striped tbody tr:nth-of-type(odd){background:#f9f9f9}
  .table-hover tbody tr:hover{background:#f1f1f1}
  .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
  .btn-info{background:#17a2b8}
  .btn-danger{background:#dc3545}
  .overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:1090}
  .side-panel{position:fixed;top:0;right:0;width:700px;max-width:100%;height:100%;background:#fff;z-index:1091;transform:translateX(100%);transition:transform .3s ease-in-out;overflow:auto;box-shadow:-5px 0 15px rgba(0,0,0,0.3);border-left:4px solid #007bff}
  .side-panel.open{transform:translateX(0)}
  .side-panel .header{padding:15px;background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;font-size:14px;position:relative}
  .side-panel .header .close-btn{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer}
  .side-panel .body{padding:20px;background:#f9f9f9}
  .side-panel .footer{padding:15px;background:#f9f9f9;text-align:right}
  .side-panel .footer button + button{margin-left:10px}
  .status-button{cursor:pointer}
  .modal-header-gradient{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff}
  .modal-title i{margin-right:8px}
  .overstay-badge{font-size:12px;padding:6px 10px;border-radius:999px;background:#fff;color:#333;border:1px solid rgba(0,0,0,0.08)}
  .overstay-table th{background:#343a40;color:#fff;font-size:12px;text-transform:uppercase}
  .overstay-table td{font-size:12px;vertical-align:middle}
  .money{font-variant-numeric:tabular-nums;font-weight:700}
  .total-row td{font-weight:900;background:#f1f7ff;border-top:2px solid #0d6efd}
  .pill-row{display:flex;gap:6px;align-items:center;justify-content:center;flex-wrap:nowrap}
  .pill{display:inline-flex;align-items:center;gap:6px;padding:4px 8px;border-radius:999px;font-size:11px;line-height:1;border:1px solid rgba(0,0,0,0.08);background:#fff}
  .pill i{font-size:12px}
  .pill-danger{background:#dc3545;color:#fff;border-color:#dc3545}
  .pill-warning{background:#ffc107;color:#212529;border-color:#ffc107}
  .pill-info{background:#0dcaf0;color:#0b2e3a;border-color:#0dcaf0}
  .pill-secondary{background:#6c757d;color:#fff;border-color:#6c757d}
  .pill-dark{background:#212529;color:#fff;border-color:#212529}
</style>

<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Ref #</th>
        <th>Created At</th>
        <th>Selected From</th>
        <th>Visa Stage</th>
        <th>Expiry Date</th>
        <th>Overstay & Fine</th>
        <th>Current Status</th>
        <th>Name</th>
        <th>Passport No</th>
        <th>Nationality</th>
        <th>Foreign Partner</th>
        <th>Package</th>
        <th>P.Exp. Date</th>
        <th>Passport Issue Date</th>
        <th>DOJ</th>
        <th>Visa Desig.</th>
        <th>Date of Birth</th>
        <th>Gender</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Type</th>
        <th>Cont. Salary</th>
        <th>Basic Salary</th>
        <th>Housing Allow.</th>
        <th>Transport Allow.</th>
        <th>Other Allow</th>
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
      <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $fromMap = [
            1 => ['label' => 'Outside', 'class' => 'dark',    'icon' => 'globe'],
            2 => ['label' => 'Inside',  'class' => 'primary', 'icon' => 'map-marker-alt'],
          ];
          $from = $fromMap[(int)($e->inside_country_or_outside ?? 0)] ?? ['label' => 'Unknown', 'class' => 'secondary', 'icon' => 'question-circle'];

          $statusMap = [
            1 => ['label' => 'Office',      'icon' => 'fa-building',             'class' => 'info'],
            2 => ['label' => 'Contracted',  'icon' => 'fa-handshake',            'class' => 'success'],
            3 => ['label' => 'Incidented',  'icon' => 'fa-exclamation-triangle', 'class' => 'danger'],
            4 => ['label' => 'Contracted',  'icon' => 'fa-handshake',            'class' => 'success'],
          ];
          $st = $statusMap[(int)($e->inside_status ?? 0)] ?? ['label' => 'Unknown', 'icon' => 'fa-question-circle', 'class' => 'secondary'];

          $key = (int)($e->visa_status ?? 0);
          $step = $key === 0 ? null : ($steps->firstWhere('step_no', $key) ?? $steps->firstWhere('id', $key));
          $lbl = $step->title ?? 'Unknown';
          $ico = $step->icon_class ?? 'bi bi-question-circle';

          $icaExpiry = $e->expiry_date ? Carbon::parse($e->expiry_date)->startOfDay() : null;
          $isExpired = $icaExpiry ? $icaExpiry->lt($today) : false;

          $expiredDays = $isExpired ? (int) $icaExpiry->diffInDays($today) : 0;
          $fine = (int) round($expiredDays * (float)$FINE_PER_DAY_AED);

          $expiryHuman = $icaExpiry ? $icaExpiry->format('d M Y') : 'N/A';
          $expiryISO = $icaExpiry ? $icaExpiry->format('Y-m-d') : '';

          $expiryPill = 'pill-secondary';
          $expiryIcon = 'fa-calendar-minus';
          if ($icaExpiry) {
            if ($isExpired) { $expiryPill = 'pill-danger'; $expiryIcon = 'fa-calendar-xmark'; }
            else { $expiryPill = 'pill-info'; $expiryIcon = 'fa-calendar-check'; }
          }

          $expiredDaysPill = $isExpired ? 'pill-danger' : ($icaExpiry ? 'pill-info' : 'pill-secondary');
          $finePill = $isExpired ? 'pill-dark' : 'pill-secondary';
        ?>

        <tr class="employee-row"
            data-name="<?php echo e(e($e->name)); ?>"
            data-nationality="<?php echo e(e($e->nationality)); ?>"
            data-passport="<?php echo e(e($e->passport_no)); ?>"
            data-expiry="<?php echo e($expiryISO); ?>">
          <td>
            <a href="<?php echo e(route('employees.show',$e->reference_no)); ?>" style="color:#007bff">
              <?php echo e($e->reference_no); ?>

            </a>
          </td>

          <td><?php echo e(\Carbon\Carbon::parse($e->created_at)->format('d M Y')); ?></td>

          <td>
            <button type="button" class="btn btn-<?php echo e($from['class']); ?> btn-sm" style="font-size:10px;color:#fff">
              <i class="fas fa-<?php echo e($from['icon']); ?>"></i> <?php echo e(strtoupper($from['label'])); ?>

            </button>
          </td>

          <td>
            <?php if($key === 0): ?>
              <button type="button" class="btn btn-secondary btn-sm">
                <i class="fas fa-clock"></i> Not started
              </button>
            <?php else: ?>
              <button type="button" class="btn btn-info btn-sm">
                <i class="<?php echo e($ico); ?>"></i> <?php echo e($lbl); ?>

              </button>
            <?php endif; ?>
          </td>

          <td>
            <div class="pill-row" style="justify-content:flex-start">
              <span class="pill <?php echo e($expiryPill); ?>">
                <i class="fas <?php echo e($expiryIcon); ?>"></i>
                <span><?php echo e($expiryHuman); ?></span>
              </span>
            </div>
          </td>

          <td>
            <div class="pill-row">
              <span class="pill <?php echo e($expiredDaysPill); ?>">
                <i class="fas fa-stopwatch"></i>
                <span>Expired Days: <span class="money"><?php echo e((int)$expiredDays); ?></span></span>
              </span>
              <span class="pill <?php echo e($finePill); ?>">
                <i class="fas fa-money-bill-wave"></i>
                <span>Fine: <span class="money"><?php echo e((int)$fine); ?></span> AED</span>
              </span>
            </div>
          </td>

          <?php if((int)$e->inside_status === 0): ?>
            <td>
              <button class="btn btn-sm btn-secondary status-button" onclick="updateStatus('<?php echo e($e->passport_no); ?>',1)">
                <i class="fas fa-circle-notch"></i> No Status
              </button>
            </td>
          <?php else: ?>
            <td>
              <button class="btn btn-sm btn-<?php echo e($st['class']); ?>">
                <i class="fas <?php echo e($st['icon']); ?>"></i> <?php echo e($st['label']); ?>

              </button>
            </td>
          <?php endif; ?>

          <td>
            <a href="<?php echo e(route('employees.show',$e->reference_no)); ?>" style="color:#007bff">
              <?php echo e($e->name); ?>

            </a>
            <img src="<?php echo e(asset('assets/img/attach.png')); ?>" alt="Attachment Icon" style="cursor:pointer;margin-left:8px;vertical-align:middle;height:20px;" title="View Attachments of the Candidate" onclick="showCandidateModal('<?php echo e($e->name); ?>','<?php echo e($e->id); ?>','<?php echo e($e->reference_no); ?>')"/>
          </td>

          <td><?php echo e($e->passport_no); ?></td>
          <td><?php echo e($e->nationality); ?></td>
          <td><?php echo e($shortPartner($e->foreign_partner)); ?></td>
          <td><?php echo e($e->package); ?></td>
          <td><?php echo e($e->passport_expiry_date ? \Carbon\Carbon::parse($e->passport_expiry_date)->format('d M Y') : 'N/A'); ?></td>
          <td><?php echo e($e->passport_issue_date ? \Carbon\Carbon::parse($e->passport_issue_date)->format('d M Y') : 'N/A'); ?></td>
          <td><?php echo e($e->date_of_joining ? \Carbon\Carbon::parse($e->date_of_joining)->format('d M Y') : 'N/A'); ?></td>
          <td><?php echo e($e->visa_designation); ?></td>
          <td><?php echo e($e->date_of_birth ? \Carbon\Carbon::parse($e->date_of_birth)->format('d M Y') : 'N/A'); ?></td>
          <td><?php echo e($e->gender); ?></td>
          <td><?php echo e($e->employment_contract_start_date ? \Carbon\Carbon::parse($e->employment_contract_start_date)->format('d M Y') : 'N/A'); ?></td>
          <td><?php echo e($e->employment_contract_end_date ? \Carbon\Carbon::parse($e->employment_contract_end_date)->format('d M Y') : 'N/A'); ?></td>
          <td><?php echo e($e->contract_type); ?></td>
          <td><?php echo e($e->salary_as_per_contract); ?></td>
          <td><?php echo e($e->basic); ?></td>
          <td><?php echo e($e->housing); ?></td>
          <td><?php echo e($e->transport); ?></td>
          <td><?php echo e($e->other_allowances); ?></td>
          <td><?php echo e($e->total_salary); ?></td>
          <td><?php echo e($e->payment_type); ?></td>
          <td><?php echo e($e->bank_name); ?></td>
          <td><?php echo e($e->iban); ?></td>
          <td><?php echo e($e->remarks); ?></td>
          <td><?php echo e($e->comments); ?></td>

          <td>
            <button class="btn btn-info btn-icon-only" onclick="viewProof('<?php echo e($e->ica_proof ? asset('storage/'.$e->ica_proof) : ''); ?>')">
              <i class="fas fa-eye"></i>
            </button>
            <a href="<?php echo e(route('employees.edit',$e->reference_no)); ?>" class="btn btn-primary btn-icon-only">
              <i class="fas fa-pencil"></i>
            </a>
            <?php if(in_array($e->inside_status, [1])): ?>
              <a href="<?php echo e(route('employee.exit',$e->reference_no)); ?>" class="btn btn-warning btn-icon-only">
                <i class="fas fa-sign-out-alt"></i>
              </a>
            <?php endif; ?>
            <a href="<?php echo e(route('employee.showCV',['employee'=>$e->reference_no])); ?>" target="_blank" class="btn btn-info btn-icon-only ms-1" title="View CV">
              <i class="fas fa-file-alt"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="33" class="text-center">No results found.</td>
        </tr>
      <?php endif; ?>
    </tbody>

    <tfoot>
      <tr>
        <th>Ref #</th>
        <th>Created At</th>
        <th>Selected From</th>
        <th>Visa Stage</th>
        <th>Expiry Date</th>
        <th>Overstay & Fine</th>
        <th>Current Status</th>
        <th>Name</th>
        <th>Passport No</th>
        <th>Nationality</th>
        <th>Foreign Partner</th>
        <th>Package</th>
        <th>P.Exp. Date</th>
        <th>Passport Issue Date</th>
        <th>DOJ</th>
        <th>Visa Desig.</th>
        <th>Date of Birth</th>
        <th>Gender</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Type</th>
        <th>Cont. Salary</th>
        <th>Basic Salary</th>
        <th>Housing Allow.</th>
        <th>Transport Allow.</th>
        <th>Other Allow</th>
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

<nav class="py-2">
  <div class="d-flex justify-content-between align-items-center">
    <span class="text-muted small">Showing <?php echo e($employees->firstItem()); ?>–<?php echo e($employees->lastItem()); ?> of <?php echo e($employees->total()); ?></span>
    <ul class="pagination mb-0"><?php echo e($employees->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?></ul>
  </div>
</nav>

<div class="overlay"></div>

<div class="modal fade" id="OverstayModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header modal-header-gradient">
        <h5 class="modal-title">
          <i class="fas fa-triangle-exclamation"></i>
          Overstay Fine Alert
          <span class="overstay-badge ms-2">
            Fine rate: <span class="money"><?php echo e(number_format((float)$FINE_PER_DAY_AED,2)); ?> AED</span> / day
          </span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="alert alert-info mb-3" style="font-size:13px">
          Calculated live based on today and each candidate’s ICA Expiry Date. Candidates with no expiry date are ignored.
        </div>

        <div class="table-responsive">
          <table class="table table-bordered overstay-table mb-0">
            <thead>
              <tr>
                <th style="width:60px">#</th>
                <th>Candidate Name</th>
                <th>Nationality</th>
                <th>Passport No</th>
                <th>Expiry Date</th>
                <th style="width:160px">Expired Days</th>
                <th style="width:170px">Fine Amount (AED)</th>
              </tr>
            </thead>
            <tbody id="overstayBody"></tbody>
            <tfoot>
              <tr class="total-row">
                <td colspan="5" class="text-end">TOTAL</td>
                <td id="overstayTotalDays" class="text-center">0</td>
                <td id="overstayTotalFine" class="text-end money">0.00 AED</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" id="snoozeOverstayBtn" class="btn btn-warning">
          <i class="fas fa-bell-slash me-1"></i> Snooze for 1 hour
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>

<div id="OfficePanel" class="side-panel">
  <div class="header">
    <h5><i class="fas fa-building me-2"></i>Office Details</h5>
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

    <form id="officeForm" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <input type="hidden" id="office_id" name="office_id">
      <input type="hidden" id="candidate_id" name="candidate_id">
      <input type="hidden" id="type" name="type" value="employee">

      <div class="row g-3">
        <div class="col-md-6">
          <label>Category *</label>
          <select id="category" name="category" class="form-select" required>
            <option value="">Select</option>
            <option value="Sales Return">Sales Return</option>
            <option value="Trial Return">Trial Return</option>
            <option value="New Arrival">New Arrival</option>
            <option value="Unfit">Unfit</option>
            <option value="Others">Others</option>
          </select>
        </div>
        <div class="col-md-6"><label>Returned Date *</label><input type="date" id="returned_date" name="returned_date" class="form-control" required></div>
        <div class="col-md-6"><label>Expiry Date *</label><input type="date" id="expiry_date" name="expiry_date" class="form-control" required></div>
        <div class="col-md-6"><label>ICA Proof</label><input type="file" id="ica_proof" name="ica_proof" class="form-control" accept=".png,.jpg,.jpeg,.pdf"></div>
        <div class="col-md-6"><label>Overstay Days</label><input type="number" min="0" id="overstay_days" name="overstay_days" class="form-control" value="0"></div>
        <div class="col-md-6"><label>Fine Amount (AED)</label><input type="number" step="0.01" min="0" id="fine_amount" name="fine_amount" class="form-control" value="0"></div>
        <div class="col-md-6">
          <label>Passport Status *</label>
          <select id="passport_status" name="passport_status" class="form-select" required>
            <option value="">Select</option>
            <option value="With Employer">With Employer</option>
            <option value="With Candidate">With Candidate</option>
            <option value="Expired">Expired</option>
            <option value="Office">Office</option>
            <option value="Lost">Lost</option>
            <option value="Other">Other</option>
          </select>
        </div>
      </div>
    </form>
  </div>

  <div class="footer">
    <button type="button" class="btn btn-secondary close-btn">Close</button>
    <button type="button" id="saveOfficeBtn" class="btn btn-success">Save</button>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
(function(w,$){
  if(!w.__EMPLOYEE_WITHINFORM_NS__) w.__EMPLOYEE_WITHINFORM_NS__={};
  var NS=w.__EMPLOYEE_WITHINFORM_NS__;

  if(typeof w.FINE_PER_DAY_AED==='undefined'||w.FINE_PER_DAY_AED===null) w.FINE_PER_DAY_AED=Number(<?php echo e((float)$FINE_PER_DAY_AED); ?>);

  function openSidePanel(sel){$('.overlay').fadeIn(300);$(sel).addClass('open')}
  function closeSidePanels(){$('.side-panel.open').removeClass('open');$('.overlay').fadeOut(300)}

  NS.openSidePanel=openSidePanel;
  NS.closeSidePanels=closeSidePanels;

  $(document).off('click.emp_sidepanel').on('click.emp_sidepanel','.overlay,.side-panel .close-btn',function(e){
    if($(e.target).closest('#saveOfficeBtn').length) return;
    closeSidePanels();
  });

  function shortPartnerText(v){
    var s=String(v||'').trim();
    if(!s) return '';
    return (s.split(/\s+/)[0]||'').trim();
  }

  w.updateStatus=function(passportNo,status){
    var url=`<?php echo e(route('employees.update-status-inside',['employeeId'=>':id'])); ?>`.replace(':id',encodeURIComponent(String(passportNo||'')));
    $.post(url,{status_id:status,_token:'<?php echo e(csrf_token()); ?>'})
      .done(function(res){
        if(res&&res.action==='open_modal'){
          var panel=res.modal==='OfficeModal'?'#OfficePanel':'#IncidentPanel';
          var d=res.candidateDetails||{};
          if(res.modal==='OfficeModal'){
            $('#office_sales_name').text(d.salesName||'');
            $('#office_partner').text(shortPartnerText(d.foreignPartner||''));
            $('#office_cn_number').text(d.cnNumber||'');
            $('#office_cl_number').text(d.clNumber||'');
            $('#office_visa_type').text(d.visaType||'');
            $('#office_visa_status').text(d.visaStatus||'');
            $('#office_package_value').text(d.package||'');
            $('#office_arrived_date').text(d.arrivedDate||'');
            $('#office_transferred_date').text(d.transferredDate||'');
            $('#candidate_id').val(d.candidateId||d.employee_id||'');
            $('#office_id').val(d.office_id||d.officeId||'');
            $('#type').val('employee');
            $('#officeForm')[0].reset();
            $('#candidate_id').val(d.candidateId||d.employee_id||'');
            $('#office_id').val(d.office_id||d.officeId||'');
            $('#type').val('employee');
          }
          openSidePanel(panel);
          return;
        }
        toastr.success((res&&res.message)?res.message:'Updated');
      })
      .fail(function(xhr){
        var msg=(xhr&&xhr.responseJSON&&xhr.responseJSON.message)?xhr.responseJSON.message:'Server error';
        toastr.error(msg);
      });
  };

  function formatLaravelErrors(xhr){
    var out=[];
    var json=xhr&&xhr.responseJSON?xhr.responseJSON:null;
    if(json&&json.errors){
      Object.keys(json.errors).forEach(function(k){
        (json.errors[k]||[]).forEach(function(m){out.push(m)});
      });
    }
    if(out.length) return out.join('\n');
    if(json&&json.message) return json.message;
    return 'Failed to save.';
  }

  function saveOfficeData(){
    var $btn=$('#saveOfficeBtn');
    $btn.prop('disabled',true);

    var fd=new FormData($('#officeForm')[0]);
    fd.set('_token','<?php echo e(csrf_token()); ?>');

    $.ajax({url:'<?php echo e(route("employees.officeSave")); ?>',method:'POST',data:fd,processData:false,contentType:false})
      .done(function(res){
        toastr.success((res&&res.message)?res.message:'Saved');
        closeSidePanels();
        setTimeout(function(){location.reload()},1200);
      })
      .fail(function(xhr){
        toastr.error(formatLaravelErrors(xhr));
        $btn.prop('disabled',false);
      });
  }

  $(document).off('click.emp_office_save').on('click.emp_office_save','#saveOfficeBtn',function(e){
    e.preventDefault();
    e.stopPropagation();
    saveOfficeData();
  });

  var FINE_PER_DAY_AED=Number(w.FINE_PER_DAY_AED);
  var SNOOZE_MS=60*60*1000;
  var CHECK_INTERVAL_MS=60*60*1000;
  var LS_SNOOZE_UNTIL_KEY='overstay_modal_snooze_until';

  function toMoneyAED(amount){
    var n=Number(amount||0);
    return n.toFixed(2)+' AED';
  }

  function parseISODate(iso){
    if(!iso) return null;
    var parts=String(iso).split('-').map(function(x){return parseInt(x,10)});
    if(parts.length!==3||parts.some(function(x){return isNaN(x)})) return null;
    var y=parts[0],m=parts[1],d=parts[2];
    return new Date(y,m-1,d,0,0,0,0);
  }

  function daysExpired(expiryDate){
    var now=new Date();
    var today=new Date(now.getFullYear(),now.getMonth(),now.getDate(),0,0,0,0);
    var diffMs=today.getTime()-expiryDate.getTime();
    if(diffMs<=0) return 0;
    return Math.floor(diffMs/(24*60*60*1000));
  }

  function escapeHtml(str){
    return String(str||'').replace(/[&<>"'`=\/]/g,function(s){
      return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','/':'&#x2F;','`':'&#x60;','=':'&#x3D;'})[s];
    });
  }

  function snoozeUntilMs(){
    var v=localStorage.getItem(LS_SNOOZE_UNTIL_KEY);
    var n=Number(v);
    return isNaN(n)?0:n;
  }

  function setSnoozeOneHour(){
    var until=Date.now()+SNOOZE_MS;
    localStorage.setItem(LS_SNOOZE_UNTIL_KEY,String(until));
    return until;
  }

  function isSnoozed(){
    return Date.now()<snoozeUntilMs();
  }

  function getOverstayCandidates(){
    var rows=document.querySelectorAll('.employee-row');
    var list=[];
    rows.forEach(function(r){
      var name=r.getAttribute('data-name')||'';
      var nationality=r.getAttribute('data-nationality')||'';
      var passport=r.getAttribute('data-passport')||'';
      var expiryISO=r.getAttribute('data-expiry')||'';
      var exp=parseISODate(expiryISO);
      if(!exp) return;
      var expired=daysExpired(exp);
      if(expired<=0) return;
      var fine=Math.round(expired*FINE_PER_DAY_AED);
      list.push({name:name,nationality:nationality,passport:passport,expiryISO:expiryISO,expired:expired,fine:fine});
    });
    list.sort(function(a,b){return b.expired-a.expired});
    return list;
  }

  function renderOverstayModal(list){
    var body=document.getElementById('overstayBody');
    var totalDaysEl=document.getElementById('overstayTotalDays');
    var totalFineEl=document.getElementById('overstayTotalFine');
    if(!body||!totalDaysEl||!totalFineEl) return;

    body.innerHTML='';
    var totalDays=0;
    var totalFine=0;

    list.forEach(function(c,idx){
      totalDays+=c.expired;
      totalFine+=c.fine;

      var dt=parseISODate(c.expiryISO);
      var expiryPretty=dt?dt.toLocaleDateString(undefined,{day:'2-digit',month:'short',year:'numeric'}):c.expiryISO;

      var tr=document.createElement('tr');
      tr.innerHTML=
        '<td class="text-center">'+(idx+1)+'</td>'+
        '<td>'+escapeHtml(c.name)+'</td>'+
        '<td>'+escapeHtml(c.nationality)+'</td>'+
        '<td>'+escapeHtml(c.passport)+'</td>'+
        '<td>'+escapeHtml(expiryPretty)+'</td>'+
        '<td class="text-center money">'+c.expired+'</td>'+
        '<td class="text-end money">'+toMoneyAED(c.fine)+'</td>';
      body.appendChild(tr);
    });

    totalDaysEl.textContent=totalDays;
    totalFineEl.textContent=toMoneyAED(totalFine);
  }

  function showOverstayModalIfNeeded(){
    if(isSnoozed()) return;
    var list=getOverstayCandidates();
    if(list.length===0) return;
    renderOverstayModal(list);
    var modalEl=document.getElementById('OverstayModal');
    if(!modalEl||!w.bootstrap||!w.bootstrap.Modal) return;
    var modal=w.bootstrap.Modal.getOrCreateInstance(modalEl,{backdrop:'static',keyboard:false});
    modal.show();
  }

  $(document).off('click.emp_snooze').on('click.emp_snooze','#snoozeOverstayBtn',function(){
    setSnoozeOneHour();
    var modalEl=document.getElementById('OverstayModal');
    if(modalEl&&w.bootstrap&&w.bootstrap.Modal){
      var modal=w.bootstrap.Modal.getOrCreateInstance(modalEl);
      modal.hide();
    }
    toastr.info('Snoozed for 1 hour.');
  });

  function init(){
    showOverstayModalIfNeeded();
    if(!w.__EMPLOYEE_WITHINFORM_OVERSTAY_TIMER__){
      w.__EMPLOYEE_WITHINFORM_OVERSTAY_TIMER__=setInterval(function(){showOverstayModalIfNeeded()},CHECK_INTERVAL_MS);
    }

    var daysEl=document.getElementById('overstay_days');
    var fineEl=document.getElementById('fine_amount');
    if(daysEl&&fineEl){
      $(daysEl).off('input.emp_finecalc').on('input.emp_finecalc',function(){
        var days=Number(daysEl.value||0);
        var fine=Math.max(0,days)*FINE_PER_DAY_AED;
        fineEl.value=fine.toFixed(2);
      });
    }
  }

  if(document.readyState==='loading') document.addEventListener('DOMContentLoaded',init,{once:true});
  else init();
})(window,window.jQuery);
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/partials/employees_table_inside.blade.php ENDPATH**/ ?>