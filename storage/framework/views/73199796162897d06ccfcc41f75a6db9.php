<style>
  .table-container{width:100%;overflow-x:auto;position:relative}
  .table{width:100%;border-collapse:collapse}
  .table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .table th{background-color:#343a40;color:#fff;text-transform:uppercase;font-weight:bold}
  .table-hover tbody tr:hover{background-color:#f1f1f1}
  .table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}
  .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
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
  .pagination-controls{display:flex;justify-content:center;margin:10px 0;align-items:center;gap:20px}
  .pagination-controls i{font-size:12px;cursor:pointer;color:#343a40}
  .pagination-controls i.disabled{color:#ccc;cursor:not-allowed}
  .dropdown-container{display:none;position:fixed;z-index:1050;background-color:#fff;border-radius:8px;padding:20px;box-shadow:0 8px 12px rgba(0,0,0,.2);min-width:350px;max-width:450px;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border:4px solid #007bff;animation:fadeIn .3s ease-in-out}
  .dropdown-header{margin-bottom:15px}
  .dropdown-header .header-icon{font-size:24px;color:#007bff;margin-bottom:10px}
  .dropdown-header p{font-size:12px;font-weight:bold;color:#333;margin:5px 0;line-height:1.5}
  .candidate-name{color:#007bff;font-weight:bold;font-size:12px}
  .status-dropdown{width:100%;margin-top:10px;font-size:12px;border:2px solid #007bff;border-radius:6px;outline:none;background-color:#fff;color:#333}
  .status-dropdown:disabled{opacity:.6;cursor:not-allowed}
  .close-icon{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer;transition:color .3s ease}
  .close-icon:hover{color:#ff4500}
  @keyframes fadeIn{from{opacity:0;transform:translate(-50%,-55%)}to{opacity:1;transform:translate(-50%,-50%)}}
  .dropdown-container .fa-times{cursor:pointer;margin-left:10px;color:#888;font-size:12px}
  .icon-wrapper{display:flex;justify-content:center;align-items:center;width:20px;height:20px;border-radius:50%;background-color:#f0f0f0;box-shadow:0 4px 6px rgba(0,0,0,.1);transition:background-color .3s ease,transform .3s ease;cursor:pointer}
  .icon-wrapper i{font-size:12px;color:#555}
  .icon-wrapper:hover{background-color:#007bff;transform:scale(1.1)}
  .icon-wrapper:hover i{color:#fff}
  .icon-wrapper .disabled{cursor:not-allowed;opacity:.5}
  .icon-wrapper .disabled:hover{transform:none;background-color:#f0f0f0}
  .office-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff}
  .office-modal .modal-header h5{margin:0;font-weight:600}
  .office-modal label{font-weight:500;margin-bottom:3px}
  .office-modal .form-control,.office-modal .form-select{font-size:14px}
  .scrollable-modal-body{max-height:70vh;overflow-y:auto}
  .custom-modal .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3);font-family:Arial,sans-serif;font-size:12px;background:#fff}
  .custom-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0}
  .custom-modal .modal-header h5,.custom-modal .modal-header h4{font-size:12px;font-weight:bold;margin:0;color:#fff}
  .custom-modal .modal-header .btn-close{font-size:1.2rem}
  .custom-modal .modal-header .btn-close:hover{opacity:1;transform:scale(1.1)}
  .custom-modal .modal-body{color:#333;background:#f9f9f9}
  .custom-modal .modal-footer{padding:15px;border-top:1px solid #ddd;border-radius:0 0 12px 12px;background:#f1f1f1}
  .custom-modal .modal-footer .btn{font-size:12px;padding:8px 15px;border-radius:5px;transition:all .3s}
  .custom-modal .modal-footer .btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:none}
  .custom-modal .modal-footer .btn-primary:hover{background:#0056b3;color:#fff}
  .custom-modal .modal-footer .btn-secondary{background:#6c757d;color:#fff;border:none}
  .custom-modal .modal-footer .btn-secondary:hover{background:#565e64;color:#fff}
  .custom-modal .table{margin-bottom:0;font-size:12px;color:#333}
  .custom-modal .table thead th{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;font-size:12px;font-weight:bold;text-transform:uppercase;text-align:center}
  .custom-modal .table td,.custom-modal .table th{padding:10px;text-align:left;white-space:nowrap}
  .kv-grid{display:grid;grid-template-columns:150px 1fr;gap:8px 16px}
  .kv-label{font-weight:600;color:#333}
  .kv-value{color:#000}
  .kv-wrap{border:1px solid #e3e6ea;border-radius:8px;padding:12px;background:#fafafa}
  .is-invalid{border-color:#dc3545!important}
  .invalid-feedback{display:none;color:#dc3545;font-size:.875rem;margin-top:.25rem}
  .show-feedback{display:block}
  .btn-sales{display:inline-flex;align-items:center;gap:6px;border:1px solid #0d6efd;background:#fff;color:#0d6efd;border-radius:8px;padding:6px 10px;font-size:12px}
  .btn-sales i{font-size:12px}
  .sales-modal-select{font-size:12px;line-height:1.3;padding:.375rem .75rem}
  .sales-modal-label{font-size:12px}
  .custom-modal .modal-title i{font-size:12px}
  .hold-meta{margin-top:4px;font-size:10px;line-height:1.2;color:#dc3545;font-weight:700;display:flex;gap:6px;align-items:center;white-space:nowrap}
  .hold-meta small{font-weight:700;color:#343a40}
  .hold-meta i{font-size:11px}
  .table td.candidate-col{white-space:normal;overflow:visible;text-overflow:unset}
</style>

<?php
  $host = request()->getHost();
  $appTenant = \Illuminate\Support\Str::contains($host,'rozana.') ? 'rozana' : (\Illuminate\Support\Str::contains($host,'middleeast.') ? 'middleeast' : null);
  $transferAllowedGlobal = in_array($appTenant, ['rozana','middleeast'], true);
?>

<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>CN#</th>
        <th>SALES NAME</th>
        <th>CANDIDATE NAME</th>
        <th>NAT</th>
        <th>PASSPORT #</th>
        <th>RETURN DATE</th>
        <th>AGENT NAME</th>
        <th>CLIENT NAME</th>
        <th>VISA EXPIRY</th>
        <th>NOC EXPIRY</th>
        <th>PASSPORT</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $allowedRoles = ['Admin','Operations Manager','Managing Director'];
          $canOverrideHold = in_array(auth()->user()->role ?? '', $allowedRoles, true);

          $currentSalesId      = (int)($p->sales_name ?? 0);
          $currentSalesUser    = collect($salesOfficers)->firstWhere('id', $currentSalesId);
          $currentSalesLabel   = trim(($currentSalesUser->first_name ?? '').' '.($currentSalesUser->last_name ?? ''));
          $currentSalesDisplay = strtoupper($currentSalesLabel !== '' ? $currentSalesLabel : (is_numeric($p->sales_name) ? 'NOT ASSIGNED' : (string)$p->sales_name));

          $CNDID        = $p->id;
          $agentShort   = strtoupper(\Illuminate\Support\Str::before((string)($p->foreign_partner ?? ''), ' '));
          $visaExpiry   = $p->expiry_date     ? \Carbon\Carbon::parse($p->expiry_date)->format('d M Y')     : 'N/A';
          $nocExpiry    = $p->noc_expiry_date ? \Carbon\Carbon::parse($p->noc_expiry_date)->format('d M Y') : 'N/A';
          $returnDate   = $p->returned_date   ? \Carbon\Carbon::parse($p->returned_date)->format('d M Y')   : 'N/A';

          $passportRaw     = strtoupper(trim((string)($p->passport_status ?? '')));
          $passportDisplay = $passportRaw === 'OFFICE' ? 'OFFICE' : ($passportRaw === 'WITH EMPLOYER' ? 'SPONSOR' : ($passportRaw ?: 'N/A'));

          $clientUrl        = isset($p->client) ? route('crm.show', $p->client->slug) : 'javascript:void(0);';
          $candidateFull    = trim((string)($p->candidate_name ?? ''));
          $candidateDisplay = strtoupper(\Illuminate\Support\Str::limit($candidateFull, 20, '...'));
          $clientFull       = trim((string)($p->sponsor_name ?? ''));
          $clientDisplay    = strtoupper(\Illuminate\Support\Str::limit($clientFull, 20, '...'));
          $candidateNice    = $p->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($p->candidate_name))) : 'N/A';

          $transferTargetName = $appTenant === 'rozana' ? 'MIDDLEEAST MANPOWER' : ($appTenant === 'middleeast' ? 'ROZANA MANPOWER' : null);
          $transferAllowedRow = $transferAllowedGlobal && $transferTargetName !== null;

          $isHeld = (int)($p->hold ?? 0) === 1;

          $holdDtRaw = $p->hold_date_and_time ?? null;
          $holdDt = $holdDtRaw ? \Carbon\Carbon::parse($holdDtRaw)->format('d M Y h:i A') : '';

          $holdSalesFirst = '';
          if (!is_null($p->hold_sales_name) && $p->hold_sales_name !== '') {
            $holdSalesId = is_numeric($p->hold_sales_name) ? (int)$p->hold_sales_name : 0;
            if ($holdSalesId > 0) {
              $holdSalesUser = collect($salesOfficers)->firstWhere('id', $holdSalesId);
              $holdSalesFirst = $holdSalesUser ? strtoupper((string)($holdSalesUser->first_name ?? '')) : '';
            } else {
              $holdSalesFirst = strtoupper((string)$p->hold_sales_name);
            }
          }
        ?>

        <tr id="row-<?php echo e($p->id); ?>" data-held="<?php echo e($isHeld ? '1' : '0'); ?>">
          <td>
            <a href="#" class="text-primary" target="_blank"><?php echo e(strtoupper($p->CN_Number)); ?></a>
          </td>

          <td>
            <button
              type="button"
              class="btn-sales js-open-sales-modal"
              style="font-size:8px"
              data-can-change="<?php echo e($canOverrideHold ? '1' : '0'); ?>"
              data-candidate-id="<?php echo e($CNDID); ?>"
              data-current-id="<?php echo e($currentSalesId); ?>"
              data-current-label="<?php echo e($currentSalesDisplay); ?>"
            >
              <i class="fas fa-user-edit"></i>
              <span class="js-sales-label"><?php echo e($currentSalesDisplay); ?></span>
            </button>
          </td>

          <td title="<?php echo e($candidateFull); ?>" class="candidate-col">
            <a href="#" target="_blank" class="text-decoration-none"><?php echo e($candidateDisplay); ?></a>

            <?php if($isHeld): ?>
              <div class="js-hold-meta">
                <span class="hold-meta">
                  <i class="fas fa-hand-paper"></i>
                  <span class="js-hold-dt"><?php echo e($holdDt); ?></span>
                  <small class="js-hold-sales"><?php echo e($holdSalesFirst); ?></small>
                </span>
              </div>
            <?php else: ?>
              <div class="js-hold-meta" style="display:none">
                <span class="hold-meta">
                  <i class="fas fa-hand-paper"></i>
                  <span class="js-hold-dt"></span>
                  <small class="js-hold-sales"></small>
                </span>
              </div>
            <?php endif; ?>
          </td>

          <td><?php echo e(strtoupper($p->nationality ?? '')); ?></td>
          <td><?php echo e($p->passport_no); ?></td>
          <td><?php echo e($returnDate); ?></td>

          <td title="<?php echo e(strtoupper($p->foreign_partner ?? '')); ?>">
            <?php echo e($agentShort !== '' ? $agentShort : 'N/A'); ?>

          </td>

          <td title="<?php echo e($clientFull); ?>">
            <a href="<?php echo e($clientUrl); ?>" class="text-primary" target="_blank"><?php echo e($clientDisplay); ?></a>
          </td>

          <td><?php echo e($visaExpiry); ?></td>
          <td><?php echo e($nocExpiry); ?></td>
          <td><?php echo e($passportDisplay); ?></td>

          <td>
            <?php if(!$isHeld): ?>
              <a
                href="javascript:void(0);"
                class="btn btn-primary btn-icon-only"
                title="Change Status"
                onclick="openDropdown('<?php echo e($p->id); ?>', this, '<?php echo e($candidateNice); ?>')"
              >
                <i class="fas fa-train"></i>
              </a>

              <div class="dropdown-container" id="dropdownContainer-<?php echo e($p->id); ?>" style="display:none">
                <div class="close-icon" onclick="closeAllDropdowns()"><i class="fas fa-times-circle"></i></div>

                <div class="dropdown-header">
                  <div class="header-icon"><i class="fas fa-info-circle"></i></div>
                  <p>Do you want to change the status of</p>
                  <p>package <span id="packageName-<?php echo e($p->id); ?>" class="package-name"></span>?</p>
                </div>

                <?php
                  $allowedStatuses = [
                    0 => 'Change Status',
                    1 => 'Hold',
                    2 => 'Trial',
                    5 => 'Incident',
                    7 => 'Monthly'
                  ];
                ?>

                <select
                  class="form-control status-dropdown"
                  id="statusDropdown-<?php echo e($p->id); ?>"
                  name="current_status"
                  data-original="<?php echo e($p->_status); ?>"
                  data-cn="<?php echo e($p->CN_Number); ?>"
                  data-candidate="<?php echo e($candidateNice); ?>"
                  data-held="0"
                  data-can-override-hold="<?php echo e($canOverrideHold ? '1' : '0'); ?>"
                  onchange="confirmStatusChange(this,'<?php echo e($p->id); ?>','<?php echo e($candidateNice); ?>')"
                >
                  <?php $__currentLoopData = $allowedStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusId => $statusName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($statusId); ?>" <?php echo e((int)$p->_status === (int)$statusId ? 'selected' : ''); ?>>
                      <?php echo e($statusName); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
            <?php else: ?>
              <?php if($canOverrideHold): ?>
                <a
                  href="javascript:void(0);"
                  class="btn btn-primary btn-icon-only"
                  title="Change Status"
                  onclick="openDropdown('<?php echo e($p->id); ?>', this, '<?php echo e($candidateNice); ?>')"
                >
                  <i class="fas fa-train"></i>
                </a>

                <div class="dropdown-container" id="dropdownContainer-<?php echo e($p->id); ?>" style="display:none">
                  <div class="close-icon" onclick="closeAllDropdowns()"><i class="fas fa-times-circle"></i></div>

                  <div class="dropdown-header">
                    <div class="header-icon"><i class="fas fa-info-circle"></i></div>
                    <p>Do you want to change the status of</p>
                    <p>package <span id="packageName-<?php echo e($p->id); ?>" class="package-name"></span>?</p>
                  </div>

                  <?php
                    $allowedStatuses = [
                      0 => 'Change Status',
                      1 => 'Hold',
                      2 => 'Trial',
                      5 => 'Incident',
                      7 => 'Monthly'
                    ];
                  ?>

                  <select
                    class="form-control status-dropdown"
                    id="statusDropdown-<?php echo e($p->id); ?>"
                    name="current_status"
                    data-original="<?php echo e($p->_status); ?>"
                    data-cn="<?php echo e($p->CN_Number); ?>"
                    data-candidate="<?php echo e($candidateNice); ?>"
                    data-held="1"
                    data-can-override-hold="1"
                    onchange="confirmStatusChange(this,'<?php echo e($p->id); ?>','<?php echo e($candidateNice); ?>')"
                  >
                    <?php $__currentLoopData = $allowedStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusId => $statusName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($statusId); ?>" <?php echo e((int)$p->_status === (int)$statusId ? 'selected' : ''); ?>>
                        <?php echo e($statusName); ?>

                      </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
              <?php else: ?>
                <span class="badge bg-danger" style="font-size:11px">ON HOLD</span>
              <?php endif; ?>
            <?php endif; ?>

            <?php if($transferAllowedRow): ?>
              <a
                href="javascript:void(0);"
                class="btn btn-info btn-icon-only js-transfer-candidate"
                title="Transfer"
                data-package-id="<?php echo e($p->id); ?>"
                data-passport-no="<?php echo e($p->passport_no); ?>"
                data-candidate-name="<?php echo e($candidateNice); ?>"
                data-target-company="<?php echo e($transferTargetName); ?>"
              >
                <i class="fas fa-right-left"></i>
              </a>
            <?php endif; ?>

            <a
              href="<?php echo e(route('package.exit', ['reference_no' => $p->hr_ref_no])); ?>"
              class="btn btn-primary btn-icon-only"
              title="Exit Form"
              target="_blank"
            >
              <i class="fas fa-file-export"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="12" class="text-center">No results found.</td>
        </tr>
      <?php endif; ?>
    </tbody>

    <tfoot>
      <tr>
        <th>CN#</th>
        <th>SALES NAME</th>
        <th>CANDIDATE NAME</th>
        <th>NAT</th>
        <th>PASSPORT #</th>
        <th>RETURN DATE</th>
        <th>AGENT NAME</th>
        <th>CLIENT NAME</th>
        <th>VISA EXPIRY</th>
        <th>NOC EXPIRY</th>
        <th>PASSPORT</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>
</div>

<div class="fullscreen-overlay" id="fullscreenOverlay" onclick="closeAllDropdowns()"></div>

<nav aria-label="Page navigation">
  <div class="pagination-container">
    <span class="muted-text">
      Showing <?php echo e($packages->firstItem()); ?> to <?php echo e($packages->lastItem()); ?> of <?php echo e($packages->total()); ?> results
    </span>
    <ul class="pagination justify-content-center">
      <?php echo e($packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

    </ul>
  </div>
</nav>

<div id="TrialModal" class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="TrialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="TrialModalLabel">
          <i class="fas fa-box-open text-light"></i> Trial Agreement
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:#fff;"></button>
      </div>
      <form id="agreement_form" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

          <input type="hidden" id="PackageHidden" name="package_id" value="">
          <input type="hidden" id="SalaryHidden" name="salary" value="">
          <input type="hidden" id="NationalityHidden" name="nationality" value="">

          <div class="card border-info mb-3">
            <div class="card-body">
              <h5 class="card-title text-default">
                <i class="fas fa-clipboard-list"></i> Select Package and Client
              </h5>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="Package">
                    <i class="fas fa-cube text-default"></i> Select Package <span class="text-danger">*</span>
                  </label>
                  <select id="Package" name="package" class="form-control">
                    <option value="">Select Package</option>
                    <option value="PKG-1">PKG-1</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="clientDropdown">
                    <i class="fas fa-user text-default"></i> Select Client <span class="text-danger">*</span>
                  </label>
                  <select id="clientDropdown" name="client_id" class="form-control select2"></select>
                </div>
              </div>
              <div class="row mb-4" id="new_contract_field">
                <div class="col-md-6">
                  <label for="VisaType">
                    <i class="fas fa-passport text-default me-2"></i> Select Visa Type <span class="text-danger">*</span>
                  </label>
                  <select id="VisaType" name="visa_type" class="form-control">
                    <option value="">Select Visa Type</option>
                    <option value="D-SPO">D-SPO</option>
                    <option value="D-HIRE">D-HIRE</option>
                    <option value="OFFICE-V">OFFICE-V</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="contractDuration">
                    <i class="fas fa-calendar-alt text-default"></i> Contract Duration <span class="text-danger">*</span>
                  </label>
                  <input type="text" id="contractDuration" name="contract_duration" class="form-control" value="2 Years" readonly>
                </div>
              </div>
            </div>
          </div>

          <div class="card border-info mb-3">
            <div class="card-body">
              <h5 class="card-title text-default">
                <i class="fas fa-money-check-alt"></i> Office Transaction
              </h5>
              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="officePaymentMethod">
                    <i class="fas fa-wallet text-default"></i> Payment Method <span class="text-danger">*</span>
                  </label>
                  <?php
                    use Illuminate\Support\Str;
                    $host = request()->getHost();
                    $tenant = Str::contains($host,'rozana.') ? 'rozana' : (Str::contains($host,'middleeast.') ? 'middleeast' : (Str::contains($host,'vienna.') ? 'vienna' : null));
                    $all = ['CBQ'=>'CBQ','QIB'=>'QIB','QNB'=>'QNB','CASH'=>'Cash','CHEQUE'=>'Cheque','CB-LINK'=>'CB Link','POS'=>'POS','REPLACEMENT'=>'Replacement','NO ADVANCE'=>'No Advance'];
                    $map = ['rozana'=>['CBQ','QNB','CASH','CHEQUE','POS','CB-LINK','REPLACEMENT','NO ADVANCE'],'middleeast'=>['QIB','CBQ','POS','CASH','CHEQUE','CB-LINK','REPLACEMENT','NO ADVANCE'],'vienna'=>['CBQ','CASH','CHEQUE','POS','CB-LINK','REPLACEMENT','NO ADVANCE']];
                    $methods = $map[$tenant] ?? array_keys($all);
                    $selected = strtoupper(trim(old('office_payment_method', $office_payment_method ?? '')));
                  ?>
                  <select id="officePaymentMethod" name="office_payment_method" class="form-control" required>
                    <option value="" disabled <?php echo e($selected === '' ? 'selected' : ''); ?>>Select Payment Method</option>
                    <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php $code = strtoupper($code); $label = $all[$code] ?? $code; ?>
                      <option value="<?php echo e($code); ?>" <?php echo e($selected === $code ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
              </div>

              <div class="row office-amount-row">
                <div class="col-lg-6 mb-3">
                  <label for="officeTotalAmount"><i class="fas fa-calculator text-default"></i> Total Amount <span class="text-danger">*</span></label>
                  <input type="text" id="officeTotalAmount" name="office_total_amount" class="form-control">
                </div>
                <div class="col-lg-6 mb-3">
                  <label for="officeReceivedAmount"><i class="fas fa-hand-holding-usd text-default"></i> Received Amount <span class="text-danger">*</span></label>
                  <input type="text" id="officeReceivedAmount" name="office_received_amount" class="form-control">
                </div>
                <div class="col-lg-6 mb-3">
                  <label for="officeRemainingAmount"><i class="fas fa-balance-scale text-default"></i> Remaining Amount</label>
                  <input type="text" id="officeRemainingAmount" name="office_remaining_amount" class="form-control" value="0" readonly>
                </div>
                <div class="col-lg-6 mb-3 office-payment-proof-col">
                  <label for="officePaymentProof"><i class="fas fa-upload text-default"></i> Upload Payment Proof <span class="text-danger proof-required">*</span></label>
                  <input type="file" id="officePaymentProof" name="office_payment_proof" class="form-control">
                </div>
              </div>
            </div>
          </div>

          <div class="card border-success mb-3">
            <div class="card-body">
              <h5 class="card-title text-default">
                <i class="fas fa-file-signature"></i> Create Agreement
              </h5>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="selectedModalcandidateName"><i class="fas fa-user text-default"></i> Candidate <span class="text-danger">*</span></label>
                  <input type="text" id="selectedModalcandidateName" class="form-control" readonly>
                  <input type="hidden" id="selectedModalcandidateNameHidden" name="candidate_name" class="form-control">

                  <input type="hidden" id="selectedModalcandidateId" name="candidate_id" class="form-control">
                  <input type="hidden" id="selectedModalreferenceNo" name="reference_no" class="form-control">
                  <input type="hidden" id="selectedModalrefNo" name="ref_no" class="form-control">
                  <input type="hidden" id="selectedModalforeignPartner" name="foreign_partner" class="form-control>

                  <input type="hidden" id="selectedModalcandiateNationality" name="candidate_nationality" class="form-control">
                  <input type="hidden" id="selectedModalcandidateNationality" name="candidate_nationality" class="form-control">

                  <input type="hidden" id="selectedModalcandidatePassportNumber" name="candidate_passport_number" class="form-control">
                  <input type="hidden" id="selectedModalpassportNo" name="passport_no" class="form-control">

                  <input type="hidden" id="selectedModalcandidatePassportExpiry" name="candidate_passport_expiry" class="form-control">
                  <input type="hidden" id="selectedModalcandidateDOB" name="candidate_dob" class="form-control">
                  <input type="hidden" id="selectedModalcandidateType" name="candidate_type" value="package" class="form-control">
                </div>
                <div class="col-md-6">
                  <label for="agreementType"><i class="fas fa-file text-default"></i> Agreement Type <span class="text-danger">*</span></label>
                  <select id="agreementType" name="agreement_type" class="form-control">
                    <option value="">Select Agreement Type</option>
                    <option value="BIA" selected>Booking Inside Agreement (BIA/TA)</option>
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="trialStartDate"><i class="fas fa-calendar text-default"></i> Trial Start Date <span class="text-danger">*</span></label>
                  <input type="date" id="trialStartDate" name="trial_start_date" class="form-control">
                </div>
                <div class="col-md-6">
                  <label for="trialEndDate"><i class="fas fa-calendar text-default"></i> Trial End Date <span class="text-danger">*</span></label>
                  <input type="date" id="trialEndDate" name="trial_end_date" class="form-control">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="number_of_days"><i class="fas fa-calendar-check text-default"></i> Number of Days <span class="text-danger">*</span></label>
                  <input type="text" id="number_of_days" name="number_of_days" class="form-control" value="0" readonly>
                </div>
                <div class="col-md-6">
                  <label for="agreedSalary"><i class="fas fa-coins text-default"></i> Agreed Salary <span class="text-danger">*</span></label>
                  <input type="text" id="agreedSalary" name="agreed_salary" class="form-control">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-12">
                  <label for="agreement_comments"><i class="fas fa-comment text-default"></i> Comments</label>
                  <textarea id="agreement_comments" name="comments" class="form-control" rows="2"></textarea>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Close
          </button>
          <button type="button" id="saveChanges" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="incidentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Incident Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="$('#incidentModal').modal('hide');"></button>
      </div>
      <div class="modal-body">
        <form id="incidentForm" enctype="multipart/form-data">
          <input type="hidden" name="candidate_id" id="incident_candidate_id" value="">
          <input type="hidden" name="cn_number" id="incident_cn_number" value="">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="incident_candidate_name">Candidate Name</label>
              <input type="text" id="incident_candidate_name" name="candidate_name" class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label for="incident_passport_no">Passport No</label>
              <input type="text" id="incident_passport_no" name="passport_no" class="form-control" readonly>
            </div>
          </div>
          <div class="mb-3">
            <label for="incident_type">Incident Type</label>
            <select id="incident_type" name="incident_type" class="form-select">
              <option value="">Select Type</option>
              <option value="RUNAWAY">RUNAWAY</option>
              <option value="REPATRIATION">REPATRIATION</option>
              <option value="UNFIT">UNFIT</option>
              <option value="REFUSED">REFUSED</option>
              <option value="PSYCHIATRIC">PSYCHIATRIC</option>
              <option value="SICK">SICK</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="incident_date">Incident Date</label>
            <input type="date" id="incident_date" name="incident_date" class="form-control">
          </div>
          <div class="mb-3">
            <label for="incident_comments">Comments</label>
            <textarea id="incident_comments" name="comments" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label for="incident_proof">Incident Proof</label>
            <input type="file" id="incident_proof" name="incident_proof" class="form-control">
          </div>
          <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="$('#incidentModal').modal('hide');">
              <i class="fas fa-times me-1"></i> Close
            </button>
            <button type="button" id="saveIncidentBtn" class="btn btn-danger" onclick="saveIncidentData()">
              <i class="fas fa-save me-1"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="changeSalesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title"><i class="fas fa-user-gear me-2"></i> Change Sales Name</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-3">
        <div class="mb-2"><span class="sales-modal-label">Current:</span> <strong id="sales-current-label">—</strong></div>
        <input type="hidden" id="sales-candidate-id" value="">
        <input type="hidden" id="sales-current-id" value="">
        <label for="sales-select" class="sales-modal-label">Select Sales Officer</label>
        <select id="sales-select" class="form-select sales-modal-select">
          <?php $__currentLoopData = $salesOfficers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $full = trim(($user->first_name ?? '').' '.($user->last_name ?? '')); ?>
            <option value="<?php echo e($user->id); ?>"><?php echo e($full); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div id="sales-msg" class="mt-2"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Close</button>
        <button type="button" class="btn btn-primary" id="SaaveeBbttn"><i class="fas fa-save me-1"></i> Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="holdModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title"><i class="fas fa-hand-paper me-2"></i> Hold</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-3">
        <input type="hidden" id="hold-candidate-id" value="">
        <input type="hidden" id="hold-target-value" value="1">
        <input type="hidden" id="hold-can-override" value="0">
        <input type="hidden" id="hold-current" value="0">
        <div class="mb-2"><span class="sales-modal-label">Candidate:</span> <strong id="hold-candidate-name">—</strong></div>
        <div class="mb-2"><span class="sales-modal-label">Current:</span> <strong id="hold-current-label">—</strong></div>

        <div class="mb-2">
          <label class="sales-modal-label">Action</label>
          <select id="hold-action" class="form-select sales-modal-select">
            <option value="1">Hold</option>
            <option value="0">Unhold</option>
          </select>
        </div>

        <div class="form-check mt-2">
          <input class="form-check-input" type="checkbox" id="hold-consent">
          <label class="form-check-label" for="hold-consent" style="font-size:12px">
            I confirm this action
          </label>
        </div>

        <div id="hold-msg" class="mt-2"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Close</button>
        <button type="button" class="btn btn-primary" id="holdSaveBtn"><i class="fas fa-save me-1"></i> Save</button>
      </div>
    </div>
  </div>
</div>

<script>
(() => {
  const CSRF = '<?php echo e(csrf_token()); ?>';
  const APP_TENANT = '<?php echo e($appTenant ?? ''); ?>';

  const routes = {
    updateStatus: "<?php echo e(route('packages.update-status-inside',['packageId'=>'__PACKAGE_ID__'])); ?>",
    updateMonthlyStatus: "<?php echo e(route('packages.update-status-monthly')); ?>",
    agreementsInside: "<?php echo e(route('agreements.insideagreement')); ?>",
    incidentDataOffice: "<?php echo e(route('package.incidentDataOffice',':id')); ?>",
    incidentSave: "<?php echo e(route('package.officeIncidentSave')); ?>",
    updateSalesName: "<?php echo e(route('packages.updateSalesName')); ?>",
    transferCandidate: "<?php echo e(route('packages.transfer')); ?>",
    updateHold: "<?php echo e(route('office.updateHold')); ?>"
  };

  const $ = window.jQuery;
  if (!$) return;

  const t = (v) => String(v ?? '').trim();
  const nstr = (v) => {
    const s = t(v);
    const cleaned = s.replace(/[^0-9.]/g, '');
    const parts = cleaned.split('.');
    if (parts.length > 2) return parts[0] + '.' + parts.slice(1).join('');
    return cleaned;
  };
  const num = (v) => {
    const x = parseFloat(nstr(v));
    return isNaN(x) ? 0 : x;
  };
  const intv = (v) => {
    const x = parseInt(t(v), 10);
    return isNaN(x) ? 0 : x;
  };

  const parseAjaxError = (xhr, fallback) => {
    let text = fallback || 'Request failed.';
    if (xhr && xhr.responseJSON) {
      if (xhr.responseJSON.message) text = xhr.responseJSON.message;
      if (xhr.responseJSON.errors) {
        const firstKey = Object.keys(xhr.responseJSON.errors)[0];
        if (firstKey && xhr.responseJSON.errors[firstKey] && xhr.responseJSON.errors[firstKey][0]) {
          text = xhr.responseJSON.errors[firstKey][0];
        }
      }
    }
    return text;
  };

  const getModal = (id) => {
    const el = document.getElementById(id);
    if (window.bootstrap && bootstrap.Modal) return { type: 'bs5', inst: bootstrap.Modal.getOrCreateInstance(el) };
    return { type: 'jq', inst: $('#' + id) };
  };

  const showModal = (id) => {
    const m = getModal(id);
    if (m.type === 'bs5') m.inst.show(); else m.inst.modal('show');
  };

  const hideModal = (id) => {
    const el = document.getElementById(id);
    const inst = (window.bootstrap && bootstrap.Modal && bootstrap.Modal.getInstance) ? bootstrap.Modal.getInstance(el) : null;
    if (inst) inst.hide(); else $('#' + id).modal('hide');
  };

  const closeAllDropdowns = () => {
    $('.dropdown-container').fadeOut();
    $('#fullscreenOverlay').fadeOut();
  };

  const openDropdown = (packageId, buttonElement, packageName) => {
    $('.dropdown-container').hide();
    $('#fullscreenOverlay').fadeIn();
    const el = $(`#dropdownContainer-${packageId}`);
    el.find('.package-name').text(packageName);
    el.css({ display: 'block', opacity: 0 }).animate({ opacity: 1 }, 200);
  };

  const ensureHidden = () => {
    const form = document.getElementById('agreement_form');
    if (!form) return;
    const ensure = (id, name) => {
      let el = document.getElementById(id);
      if (!el) {
        el = document.createElement('input');
        el.type = 'hidden';
        el.id = id;
        el.name = name;
        form.appendChild(el);
      }
    };
    ensure('PackageHidden', 'package_id');
    ensure('SalaryHidden', 'agreed_salary');
    ensure('NationalityHidden', 'candidate_nationality');
  };

  const readSelectValueOrText = (sel) => {
    const $el = $(sel);
    if (!$el.length) return '';
    const v = t($el.val());
    if (v) return v;
    const tx = t($el.find('option:selected').text());
    return tx;
  };

  const syncPackageHidden = () => {
    ensureHidden();
    const v = t($('#Package').val());
    $('#PackageHidden').val(v);
  };

  const syncSalaryHidden = () => {
    ensureHidden();
    const v = nstr($('#agreedSalary').val());
    $('#SalaryHidden').val(v);
  };

  const syncNationalityHidden = () => {
    ensureHidden();
    const a = t($('#selectedModalcandidateNationality').val());
    const b = t($('#selectedModalcandiateNationality').val());
    const nat = a || b;
    $('#NationalityHidden').val(nat);
    if ($('#selectedModalcandidateNationality').length) $('#selectedModalcandidateNationality').val(nat);
    if ($('#selectedModalcandiateNationality').length) $('#selectedModalcandiateNationality').val(nat);
  };

  const setPackageValue = (pkgVal) => {
    const v = t(pkgVal);
    if (!v) return;
    const $pkg = $('#Package');
    if (!$pkg.length) return;
    if ($pkg.find(`option[value="${v}"]`).length === 0) $pkg.append(`<option value="${v}">${v}</option>`);
    $pkg.val(v);
    syncPackageHidden();
  };

  const paymentProofRequired = () => {
    const methodRaw = readSelectValueOrText('#officePaymentMethod');
    const method = t(methodRaw).toUpperCase();
    const received = num($('#officeReceivedAmount').val());
    return received > 0 && method !== 'CASH' && method !== 'NO ADVANCE';
  };

  const enforceNoAdvanceWhenZero = () => {
    const received = num($('#officeReceivedAmount').val());
    if (received !== 0) return;
    const $pm = $('#officePaymentMethod');
    if (!$pm.length) return;
    const has = $pm.find('option[value="NO ADVANCE"]').length > 0;
    if (!has) return;
    const cur = t($pm.val()).toUpperCase();
    if (cur !== 'NO ADVANCE') $pm.val('NO ADVANCE').trigger('change');
  };

  const toggleProofUI = () => {
    enforceNoAdvanceWhenZero();
    const req = paymentProofRequired();
    if (req) $('.proof-required').show(); else $('.proof-required').hide();
  };

  const recalcOfficeAmounts = () => {
    const total = num($('#officeTotalAmount').val());
    const received = num($('#officeReceivedAmount').val());

    if (total < 0) {
      if (window.toastr) toastr.error('Total amount cannot be negative.');
      $('#officeTotalAmount').val('0');
      $('#officeRemainingAmount').val('0');
      return;
    }
    if (received < 0) {
      if (window.toastr) toastr.error('Received amount cannot be negative.');
      $('#officeReceivedAmount').val('0');
      $('#officeRemainingAmount').val(total.toFixed(2));
      return;
    }
    if (received > total) {
      if (window.toastr) toastr.error('Received amount cannot exceed the total amount.');
      $('#officeReceivedAmount').val('');
      $('#officeRemainingAmount').val(total.toFixed(2));
      return;
    }
    $('#officeRemainingAmount').val((total - received).toFixed(2));
  };

  const computeTrialDays = () => {
    const s = t($('#trialStartDate').val());
    const e = t($('#trialEndDate').val());
    if (!s || !e) {
      $('#number_of_days').val('0');
      return;
    }
    const sd = new Date(s + 'T00:00:00');
    const ed = new Date(e + 'T00:00:00');
    if (isNaN(sd.getTime()) || isNaN(ed.getTime()) || ed.getTime() < sd.getTime()) {
      $('#number_of_days').val('0');
      return;
    }
    const diff = Math.floor((ed.getTime() - sd.getTime()) / 86400000) + 1;
    $('#number_of_days').val(String(diff));
  };

  const allowMoney = (selector) => {
    $(selector).on('input', function () {
      const v = String($(this).val() || '');
      const cleaned = v.replace(/[^0-9.]/g, '');
      const parts = cleaned.split('.');
      if (parts.length > 2) {
        $(this).val(parts[0] + '.' + parts.slice(1).join(''));
        return;
      }
      $(this).val(cleaned);
    });
  };

  const formatHoldDate = (iso) => {
    if (!iso) return '';
    const d = new Date(iso);
    if (isNaN(d.getTime())) return '';
    const day = String(d.getDate()).padStart(2, '0');
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const mon = months[d.getMonth()];
    const year = d.getFullYear();
    let hr = d.getHours();
    const min = String(d.getMinutes()).padStart(2, '0');
    const ampm = hr >= 12 ? 'PM' : 'AM';
    hr = hr % 12;
    hr = hr === 0 ? 12 : hr;
    const hr2 = String(hr).padStart(2, '0');
    return `${day} ${mon} ${year} ${hr2}:${min} ${ampm}`;
  };

  const setRowHoldUI = (packageId, isHeld, holdDateIso, holdSalesFirst, canOverrideHold) => {
    const $row = $(`#row-${packageId}`);
    $row.attr('data-held', isHeld ? '1' : '0');

    const $metaWrap = $row.find('.js-hold-meta');
    const $dt = $row.find('.js-hold-dt');
    const $sales = $row.find('.js-hold-sales');

    if (isHeld) {
      $dt.text(formatHoldDate(holdDateIso));
      $sales.text(String(holdSalesFirst || '').toUpperCase());
      $metaWrap.show();
    } else {
      $dt.text('');
      $sales.text('');
      $metaWrap.hide();
    }

    const disableForUser = isHeld && !canOverrideHold;
    const $btn = $row.find('a[title="Change Status"], a[title="On Hold"]').first();

    if (disableForUser) {
      $btn.addClass('disabled').attr('title', 'On Hold').attr('aria-disabled', 'true').off('click').on('click', (e) => e.preventDefault());
      $row.find('.status-dropdown').prop('disabled', true);
    } else {
      $btn.removeClass('disabled').attr('title', 'Change Status').attr('aria-disabled', 'false');
      $row.find('.status-dropdown').prop('disabled', false);
    }
  };

  const openHoldModal = (packageId, candidateName, currentHeld, canOverrideHold) => {
    $('#hold-candidate-id').val(packageId);
    $('#hold-candidate-name').text(candidateName || '—');
    $('#hold-current').val(currentHeld ? '1' : '0');
    $('#hold-can-override').val(canOverrideHold ? '1' : '0');
    $('#hold-current-label').text(currentHeld ? 'ON HOLD' : 'NOT ON HOLD');
    $('#hold-consent').prop('checked', false);
    $('#hold-msg').removeClass().text('');

    if (currentHeld && !canOverrideHold) {
      $('#hold-action').val('1').prop('disabled', true);
      $('#holdSaveBtn').prop('disabled', true);
      $('#hold-msg').removeClass().addClass('text-danger').text('You do not have permission to unhold.');
    } else {
      $('#hold-action').prop('disabled', false);
      $('#holdSaveBtn').prop('disabled', false);
      $('#hold-action').val(currentHeld ? '0' : '1');
    }

    showModal('holdModal');
  };

  const saveHold = () => {
    const packageId = t($('#hold-candidate-id').val());
    const targetHold = intv($('#hold-action').val());
    const canOverrideHold = t($('#hold-can-override').val()) === '1';
    const consent = $('#hold-consent').is(':checked');
    const $msg = $('#hold-msg');
    const $btn = $('#holdSaveBtn');

    if (!packageId) return;
    if (!consent) {
      $msg.removeClass().addClass('text-danger').text('Please confirm this action.');
      return;
    }

    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Saving');
    $msg.removeClass().text('');

    $.ajax({
      url: routes.updateHold,
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': CSRF },
      data: { candidate_id: packageId, hold: targetHold },
      dataType: 'json'
    }).done((res) => {
      if (!res || !res.success) {
        $msg.removeClass().addClass('text-danger').text((res && res.message) ? res.message : 'Failed to update hold.');
        return;
      }

      setRowHoldUI(
        packageId,
        intv(res.hold) === 1,
        res.hold_date_and_time || null,
        res.hold_sales_first_name || '',
        canOverrideHold
      );

      if (window.toastr) toastr.success(res.message || 'Updated successfully.');
      hideModal('holdModal');
      closeAllDropdowns();
    }).fail((xhr) => {
      $msg.removeClass().addClass('text-danger').text(parseAjaxError(xhr, 'Failed to update hold.'));
    }).always(() => {
      $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Save');
    });
  };

  const openIncidentModal = (packageId, cnNumber) => {
    $('#incident_candidate_id').val(packageId);
    $('#incident_cn_number').val(cnNumber || '');
    $('#incident_candidate_name').val('');
    $('#incident_passport_no').val('');
    $('#incident_type').val('');
    $('#incident_date').val('');
    $('#incident_comments').val('');
    $('#incident_proof').val('');

    $.ajax({
      url: routes.incidentDataOffice.replace(':id', packageId),
      type: 'GET'
    }).done((response) => {
      $('#incident_candidate_id').val(response.candidate_id || packageId);
      $('#incident_cn_number').val(response.cn_number || cnNumber || '');
      $('#incident_candidate_name').val(response.candidate_name || '');
      $('#incident_passport_no').val(response.passport_no || '');
      $('#incident_type').val(response.incident_type || '');
      $('#incident_date').val(response.incident_date || '');
      $('#incident_comments').val(response.comments || '');
      showModal('incidentModal');
    }).fail((xhr) => {
      if (window.toastr) toastr.error(parseAjaxError(xhr, 'Failed to load incident data. Please try again.'));
    });
  };

  const saveIncidentData = () => {
    const formData = new FormData(document.getElementById('incidentForm'));
    $.ajax({
      url: routes.incidentSave,
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': CSRF },
      data: formData,
      processData: false,
      contentType: false
    }).done((res) => {
      if (window.toastr) toastr.success((res && res.message) ? res.message : 'Incident saved successfully!');
      hideModal('incidentModal');
      location.reload();
    }).fail((xhr) => {
      if (window.toastr) toastr.error(parseAjaxError(xhr, 'Failed to save incident. Please check your inputs and try again.'));
    });
  };

  const updateMonthlyStatus = (selectEl, packageId) => {
    $.ajax({
      url: routes.updateMonthlyStatus,
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': CSRF },
      data: { package_id: packageId, inside_status: 7 },
      dataType: 'json'
    }).done((res) => {
      if (!res || !res.success) {
        if (window.toastr) toastr.error((res && res.message) ? res.message : 'Failed to update to Monthly.');
        if (selectEl.dataset.original !== undefined) selectEl.value = selectEl.dataset.original;
        return;
      }
      if (window.toastr) toastr.success(res.message || 'Status updated to Monthly successfully!');
      closeAllDropdowns();
      location.reload();
    }).fail((xhr) => {
      if (window.toastr) toastr.error(parseAjaxError(xhr, 'An error occurred while updating Monthly status.'));
      if (selectEl.dataset.original !== undefined) selectEl.value = selectEl.dataset.original;
    });
  };

  const initTrialModalFields = (res) => {
    ensureHidden();

    const form = document.getElementById('agreement_form');
    if (form) form.reset();

    $('#number_of_days').val('0');
    $('#officeRemainingAmount').val('0');
    $('#officePaymentProof').val('');
    $('#agreement_comments').val('');
    $('#PackageHidden').val('');
    $('#SalaryHidden').val('');
    $('#NationalityHidden').val('');

    const d = res.candidateDetails || {};

    const candidateName = d.candidateName || d.candidate_name || d.name || '';
    const candidateId = d.candidateId || d.candidate_id || '';
    const foreignPartner = d.foreignPartner || d.foreign_partner || '';
    const nationalityVal = d.nationality_id ?? d.candidate_nationality ?? d.candidateNationality ?? d.nationality ?? '';
    const passportNo = d.passportNo || d.passport_no || d.candidate_passport_number || '';
    const passportExpiry = d.passportExpiry || d.passport_expiry || d.candidate_passport_expiry || '';
    const dob = d.dob || d.candidate_dob || '';
    const refNo = d.ref_no || d.refNo || '';
    const referenceNo = d.reference_no || d.referenceNo || d.reference || '';

    const pkgFromRes = res.package || res.package_id || res.package_code || res.package_name || d.package || d.package_id || d.package_code || d.package_name || '';

    $('#selectedModalcandidateName').val(candidateName || '');
    $('#selectedModalcandidateNameHidden').val(candidateName || '');
    $('#selectedModalcandidateId').val(candidateId || '');
    $('#selectedModalreferenceNo').val(referenceNo || '');
    $('#selectedModalrefNo').val(refNo || '');
    $('#selectedModalforeignPartner').val(foreignPartner || '');

    if ($('#selectedModalcandidateNationality').length) $('#selectedModalcandidateNationality').val(String(nationalityVal || ''));
    if ($('#selectedModalcandiateNationality').length) $('#selectedModalcandiateNationality').val(String(nationalityVal || ''));

    $('#selectedModalcandidatePassportNumber').val(String(passportNo || ''));
    $('#selectedModalpassportNo').val(String(passportNo || ''));
    $('#selectedModalcandidatePassportExpiry').val(passportExpiry || '');
    $('#selectedModalcandidateDOB').val(dob || '');

    if (pkgFromRes) setPackageValue(pkgFromRes);
    else syncPackageHidden();

    syncSalaryHidden();
    syncNationalityHidden();

    const $client = $('#clientDropdown');
    if (Array.isArray(res.clients)) {
      $client.empty().append('<option value=""></option>');
      res.clients.forEach((c) => $client.append(`<option value="${c.id}">${c.first_name} ${c.last_name}</option>`));
    }

    if ($client.data('select2')) $client.select2('destroy');
    $client.select2({
      width: '100%',
      dropdownParent: $('#TrialModal'),
      placeholder: 'Select Client',
      allowClear: true,
      minimumResultsForSearch: 0
    });

    toggleProofUI();
    showModal('TrialModal');
  };

  const updateStatus = (selectEl, packageId) => {
    const statusId = selectEl.value;
    const url = routes.updateStatus.replace('__PACKAGE_ID__', packageId);

    $.ajax({
      url,
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': CSRF },
      data: { status_id: statusId },
      dataType: 'json'
    }).done((res) => {
      if (!res || !res.success) {
        if (window.toastr) toastr.error((res && res.message) ? res.message : 'Failed to update status.');
        return;
      }

      if (res.action === 'open_modal' && res.modal === 'TrialModal') {
        closeAllDropdowns();
        initTrialModalFields(res);
        return;
      }

      if (window.toastr) toastr.success(res.message || 'Status updated successfully.');
      location.reload();
    }).fail((xhr) => {
      if (window.toastr) toastr.error(parseAjaxError(xhr, 'An error occurred. Please try again.'));
    });
  };

  const confirmStatusChange = (selectEl, packageId, candidateName) => {
    const newStatus = intv(selectEl.value);
    const newStatusTxt = selectEl.options[selectEl.selectedIndex].text;
    const prevStatus = selectEl.dataset.original;
    const isHeld = t(selectEl.dataset.held || '0') === '1';
    const canOverrideHold = t(selectEl.dataset.canOverrideHold || '0') === '1';

    if (isHeld && !canOverrideHold) {
      if (window.toastr) toastr.error('This candidate is on Hold.');
      if (prevStatus !== undefined) selectEl.value = prevStatus;
      return;
    }

    if (newStatus === 1) {
      if (prevStatus !== undefined) selectEl.value = prevStatus;
      closeAllDropdowns();
      openHoldModal(packageId, candidateName, isHeld, canOverrideHold);
      return;
    }

    if (!window.Swal) {
      updateStatus(selectEl, packageId);
      return;
    }

    Swal.fire({
      title: `Change status for ${candidateName}?`,
      text: `Set status to "${newStatusTxt}"?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#dc3545',
      confirmButtonText: 'Yes, change it',
      cancelButtonText: 'No, keep it'
    }).then((res) => {
      if (!res.isConfirmed) {
        if (prevStatus !== undefined) selectEl.value = prevStatus;
        return;
      }

      if (newStatus === 5) {
        closeAllDropdowns();
        openIncidentModal(packageId, selectEl.dataset.cn);
        return;
      }

      if (newStatus === 7) {
        updateMonthlyStatus(selectEl, packageId);
        return;
      }

      updateStatus(selectEl, packageId);
    });
  };

  const buildPayload = () => {
    ensureHidden();
    syncPackageHidden();
    syncSalaryHidden();
    syncNationalityHidden();
    computeTrialDays();

    const pkg = t($('#Package').val());
    const pkgId = t($('#PackageHidden').val()) || pkg;

    const clientId = t($('#clientDropdown').val());
    const visaType = t($('#VisaType').val());
    const contractDuration = t($('#contractDuration').val());
    const agreementType = t($('#agreementType').val());

    const trialStart = t($('#trialStartDate').val());
    const trialEnd = t($('#trialEndDate').val());
    const days = intv($('#number_of_days').val());

    const salaryVal = nstr($('#agreedSalary').val());
    const salaryNum = num(salaryVal);

    const natVal = t($('#NationalityHidden').val());

    const paymentMethodRaw = readSelectValueOrText('#officePaymentMethod');
    const paymentMethod = t(paymentMethodRaw).toUpperCase() || t(paymentMethodRaw);

    const totalAmount = num($('#officeTotalAmount').val());
    const receivedAmount = num($('#officeReceivedAmount').val());
    const remainingAmount = num($('#officeRemainingAmount').val());

    const candidateId = t($('#selectedModalcandidateId').val());
    const candidateName = t($('#selectedModalcandidateNameHidden').val());
    const passportNo = t($('#selectedModalcandidatePassportNumber').val());

    const foreignPartner = t($('#selectedModalforeignPartner').val());
    const referenceNo = t($('#selectedModalreferenceNo').val());
    const refNo = t($('#selectedModalrefNo').val());
    const candidateDob = t($('#selectedModalcandidateDOB').val());
    const passportExpiry = t($('#selectedModalcandidatePassportExpiry').val());
    const candidateType = t($('#selectedModalcandidateType').val()) || 'package';

    const comments = t($('#agreement_comments').val());

    const payload = {
      package: pkg,
      package_id: pkgId,
      package_code: pkgId,
      package_name: pkgId,
      client_id: clientId,
      visa_type: visaType,
      contract_duration: contractDuration,
      agreement_type: agreementType,
      trial_start_date: trialStart,
      trial_end_date: trialEnd,
      number_of_days: String(days),
      agreed_salary: salaryVal,
      salary: salaryVal,
      salary_amount: salaryVal,
      agreedSalary: salaryVal,
      candidate_nationality: natVal,
      nationality: natVal,
      nationality_id: natVal,
      candidateNationality: natVal,
      office_payment_method: paymentMethod,
      payment_method: paymentMethod,
      office_total_amount: String(totalAmount),
      total_amount: String(totalAmount),
      office_received_amount: String(receivedAmount),
      received_amount: String(receivedAmount),
      office_remaining_amount: String(remainingAmount),
      remaining_amount: String(remainingAmount),
      candidate_id: candidateId,
      candidate_name: candidateName,
      candidate_passport_number: passportNo,
      passport_no: passportNo,
      foreign_partner: foreignPartner,
      reference_no: referenceNo,
      ref_no: refNo,
      candidate_dob: candidateDob,
      candidate_passport_expiry: passportExpiry,
      candidate_type: candidateType,
      comments: comments,
      __salary_num: salaryNum,
      __total_num: totalAmount,
      __received_num: receivedAmount
    };

    return payload;
  };

  const validatePayload = (p) => {
    if (!t(p.package_id)) return { ok: false, msg: 'Select Package.' };
    if (!t(p.client_id)) return { ok: false, msg: 'Select Client.' };
    if (!t(p.visa_type)) return { ok: false, msg: 'Select Visa Type.' };
    if (!t(p.agreement_type)) return { ok: false, msg: 'Select Agreement Type.' };
    if (!t(p.trial_start_date)) return { ok: false, msg: 'Select Trial Start Date.' };
    if (!t(p.trial_end_date)) return { ok: false, msg: 'Select Trial End Date.' };
    if (intv(p.number_of_days) <= 0) return { ok: false, msg: 'Trial dates are invalid.' };
    if (!(p.__salary_num > 0)) return { ok: false, msg: 'Enter Agreed Salary.' };
    if (!t(p.candidate_nationality)) return { ok: false, msg: 'Nationality is required.' };
    if (!t(p.office_payment_method)) return { ok: false, msg: 'Select Payment Method.' };
    if (!(p.__total_num > 0)) return { ok: false, msg: 'Enter Total Amount.' };
    if (p.__received_num < 0) return { ok: false, msg: 'Received Amount is invalid.' };
    if (p.__received_num > p.__total_num) return { ok: false, msg: 'Received Amount cannot exceed Total Amount.' };

    const pm = t(p.office_payment_method).toUpperCase();
    if (p.__received_num > 0 && pm === 'NO ADVANCE') return { ok: false, msg: 'Payment Method cannot be No Advance when Received Amount is greater than 0.' };

    if (paymentProofRequired()) {
      const proof = $('#officePaymentProof')[0] && $('#officePaymentProof')[0].files && $('#officePaymentProof')[0].files[0] ? $('#officePaymentProof')[0].files[0] : null;
      if (!proof) return { ok: false, msg: 'Upload Payment Proof.' };
    }

    if (!t(p.candidate_id)) return { ok: false, msg: 'Candidate is missing. Close and open Trial again.' };
    if (!t(p.candidate_name)) return { ok: false, msg: 'Candidate name is missing. Close and open Trial again.' };
    if (!t(p.passport_no)) return { ok: false, msg: 'Passport number is missing. Close and open Trial again.' };

    return { ok: true, msg: '' };
  };

  const submitTrialAgreement = () => {
    const payload = buildPayload();
    const chk = validatePayload(payload);
    if (!chk.ok) {
      if (window.toastr) toastr.error(chk.msg);
      return;
    }

    const btn = $('#saveChanges');
    const oldHtml = btn.html();
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Saving');

    const formEl = document.getElementById('agreement_form');
    const fd = new FormData(formEl);

    Object.keys(payload).forEach((k) => {
      if (k.startsWith('__')) return;
      fd.set(k, payload[k] == null ? '' : String(payload[k]));
    });

    const proof = $('#officePaymentProof')[0] && $('#officePaymentProof')[0].files && $('#officePaymentProof')[0].files[0] ? $('#officePaymentProof')[0].files[0] : null;
    if (proof) {
      fd.set('office_payment_proof', proof);
      fd.set('payment_proof', proof);
      fd.set('proof', proof);
      fd.set('transaction_proof', proof);
    }

    $.ajax({
      url: routes.agreementsInside,
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': CSRF },
      data: fd,
      processData: false,
      contentType: false,
      dataType: 'json'
    }).done((res) => {
      if (!res || res.success === false) {
        if (window.toastr) toastr.error((res && res.message) ? res.message : 'Failed to save.');
        return;
      }
      if (window.toastr) toastr.success(res.message || 'Saved successfully.');
      hideModal('TrialModal');
      location.reload();
    }).fail((xhr) => {
      if (window.toastr) toastr.error(parseAjaxError(xhr, 'Failed to save. Please check inputs.'));
    }).always(() => {
      btn.prop('disabled', false).html(oldHtml);
    });
  };

  const handleTransfer = ($btn) => {
    const packageId = t($btn.data('package-id'));
    const passportNo = t($btn.data('passport-no'));
    const candidateName = t($btn.data('candidate-name') || 'N/A');
    const targetCompany = t($btn.data('target-company'));

    if (!packageId || !passportNo) {
      if (window.Swal) Swal.fire({ icon: 'error', title: 'Invalid data', text: 'Package ID or Passport No is missing.' });
      return;
    }

    if (!APP_TENANT || (APP_TENANT !== 'rozana' && APP_TENANT !== 'middleeast')) {
      if (window.Swal) Swal.fire({ icon: 'error', title: 'Not allowed', text: 'Transfer is not allowed on this domain.' });
      return;
    }

    if (!targetCompany) {
      if (window.Swal) Swal.fire({ icon: 'error', title: 'Not allowed', text: 'Target company is not available.' });
      return;
    }

    if (!window.Swal) return;

    Swal.fire({
      title: 'Transfer Candidate',
      text: `Do you want to transfer ${candidateName} to ${targetCompany}?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#dc3545',
      confirmButtonText: 'Yes, transfer',
      cancelButtonText: 'Cancel'
    }).then((r) => {
      if (!r.isConfirmed) return;

      $btn.prop('disabled', true);

      $.ajax({
        url: routes.transferCandidate,
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF },
        data: { package_id: packageId, passport_no: passportNo },
        dataType: 'json'
      }).done((res) => {
        if (!res || !res.success) {
          Swal.fire({ icon: 'error', title: 'Transfer failed', text: (res && res.message) ? res.message : 'Failed to transfer.' });
          return;
        }
        Swal.fire({ icon: 'success', title: 'Transferred successfully', text: res.message || 'Transferred successfully.' })
          .then(() => location.reload());
      }).fail((xhr) => {
        Swal.fire({ icon: 'error', title: 'Transfer failed', text: parseAjaxError(xhr, 'Failed to transfer. Please try again.') });
      }).always(() => {
        $btn.prop('disabled', false);
      });
    });
  };

  const boot = () => {
    ensureHidden();

    allowMoney('#officeTotalAmount');
    allowMoney('#officeReceivedAmount');
    allowMoney('#agreedSalary');

    $('#Package').on('change', syncPackageHidden);
    $('#agreedSalary').on('input change', syncSalaryHidden);

    $('#officeTotalAmount,#officeReceivedAmount').on('input', function () {
      recalcOfficeAmounts();
      toggleProofUI();
    });

    $('#officePaymentMethod').on('change', toggleProofUI);

    $('#trialStartDate,#trialEndDate').on('change input', computeTrialDays);

    $('#officePaymentProof').on('change', function () {
      const ext = String($(this).val()).split('.').pop().toLowerCase();
      if (!['png','jpeg','jpg','pdf'].includes(ext)) {
        if (window.toastr) toastr.error('Only PNG, JPEG, JPG, and PDF files are allowed.');
        $(this).val('');
      }
    });

    $('#incident_proof').on('change', function () {
      const ext = String($(this).val()).split('.').pop().toLowerCase();
      if (!['png','jpeg','jpg','pdf'].includes(ext)) {
        if (window.toastr) toastr.error('Only PNG, JPEG, JPG, and PDF files are allowed for incident proof.');
        $(this).val('');
      }
    });

    $(document).on('click', '.js-open-sales-modal', function () {
      const canChange = t($(this).data('can-change')) === '1';
      if (!canChange) return alert('You do not have permission to update.');

      const cid = t($(this).data('candidate-id'));
      const curId = intv($(this).data('current-id'));
      const curLabel = t($(this).data('current-label') || 'NOT ASSIGNED').toUpperCase();

      window.__lastSalesBtn = $(this);

      $('#sales-candidate-id').val(cid);
      $('#sales-current-id').val(curId);
      $('#sales-current-label').text(curLabel);
      $('#sales-select').val(curId);
      $('#sales-msg').removeClass().text('');

      showModal('changeSalesModal');
    });

    $('#SaaveeBbttn').on('click', function () {
      const btn = $(this);
      const cid = t($('#sales-candidate-id').val());
      const oldId = intv($('#sales-current-id').val());
      const newId = intv($('#sales-select').val());
      const msg = $('#sales-msg');

      if (!cid || !newId) return msg.removeClass().addClass('text-danger').text('Please select a sales officer.');
      if (newId === oldId) return msg.removeClass().addClass('text-warning').text('No changes to save.');

      btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Saving');
      msg.removeClass().text('');

      $.ajax({
        url: routes.updateSalesName,
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF },
        data: { candidate_id: cid, sales_name: newId },
        dataType: 'json'
      }).done((res) => {
        const label = t(res.display_name || $('#sales-select option:selected').text() || 'Not assigned').toUpperCase();

        $('#sales-current-id').val(newId);
        $('#sales-current-label').text(label);

        const lastButton = window.__lastSalesBtn;
        if (lastButton && lastButton.length) {
          lastButton.data('current-id', newId);
          lastButton.data('current-label', label);
          lastButton.find('.js-sales-label').text(label);
        }

        msg.removeClass().addClass('text-success').text(res.message || 'Updated successfully.');
        setTimeout(() => hideModal('changeSalesModal'), 500);
        setTimeout(() => location.reload(), 650);
      }).fail((xhr) => {
        msg.removeClass().addClass('text-danger').text(parseAjaxError(xhr, 'Failed to update.'));
      }).always(() => {
        btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Save');
      });
    });

    $(document).on('click', '.js-transfer-candidate', function () {
      handleTransfer($(this));
    });

    $('#holdSaveBtn').on('click', saveHold);

    $('#saveChanges').on('click', submitTrialAgreement);

    $('#agreement_form').on('submit', function (e) {
      e.preventDefault();
      submitTrialAgreement();
    });

    toggleProofUI();
    computeTrialDays();
    syncPackageHidden();
    syncSalaryHidden();
    syncNationalityHidden();

    window.openDropdown = openDropdown;
    window.closeAllDropdowns = closeAllDropdowns;
    window.confirmStatusChange = confirmStatusChange;
    window.updateStatus = updateStatus;
    window.updateMonthlyStatus = updateMonthlyStatus;
    window.openIncidentModal = openIncidentModal;
    window.saveIncidentData = saveIncidentData;
    window.initTrialModalFields = initTrialModalFields;
  };

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
  else boot();
})();
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/package/partials/office_table.blade.php ENDPATH**/ ?>