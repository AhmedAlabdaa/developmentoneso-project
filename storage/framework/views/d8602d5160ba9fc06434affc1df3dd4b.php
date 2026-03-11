<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
  .nav-tabs .nav-link{transition:background-color .2s;color:#495057;font-size:12px;text-transform:uppercase}
  .nav-tabs .nav-link:hover{background-color:#f8f9fa}
  .nav-tabs .nav-link.active{background-color:#007bff;color:#fff}
  .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:400}
  .pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}
  .muted-text{color:#6c757d;font-size:12px}
  .pagination{display:flex;justify-content:center;align-items:center;margin:0}
  .pagination .page-item{margin:0 .1rem}
  .pagination .page-link{border-radius:.25rem;padding:.5rem .75rem;color:#007bff;background:#fff;border:1px solid #007bff;transition:background-color .2s,color .2s}
  .pagination .page-link:hover{background:#007bff;color:#fff}
  .pagination .page-item.active .page-link{background:#007bff;color:#fff;border:1px solid #007bff}
  .pagination .page-item.disabled .page-link{color:#6c757d;background:#fff;border:1px solid #6c757d;cursor:not-allowed}
  .pagination .page-item:first-child .page-link{border-top-left-radius:.25rem;border-bottom-left-radius:.25rem}
  .pagination .page-item:last-child .page-link{border-top-right-radius:.25rem;border-bottom-right-radius:.25rem}
  .table-container{width:100%;overflow-x:auto;position:relative}
  .table{width:100%;border-collapse:collapse;margin-bottom:20px}
  .table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .table th{background:#343a40;color:#fff;text-transform:uppercase;font-weight:700}
  .table-hover tbody tr:hover{background:#f1f1f1}
  .table-striped tbody tr:nth-of-type(odd){background:#f9f9f9}
  .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
  .btn-danger{background:#dc3545}
  .btn-dark{background:#343a40}
  .dropdown-container{display:none;position:fixed;z-index:1050;background:#fff;border-radius:8px;padding:20px;box-shadow:0 8px 12px rgba(0,0,0,.2);min-width:350px;max-width:450px;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border:4px solid #007bff;animation:fadeIn .3s ease-in-out}
  .dropdown-header{margin-bottom:15px}
  .dropdown-header .header-icon{font-size:24px;color:#007bff;margin-bottom:10px}
  .dropdown-header p{font-size:12px;font-weight:700;color:#333;margin:5px 0;line-height:1.5}
  .package-name{color:#007bff;font-weight:700;font-size:12px}
  .status-dropdown{width:100%;margin-top:10px;font-size:12px;border:2px solid #007bff;border-radius:6px;outline:none;background:#fff;color:#333}
  .close-icon{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer;transition:color .3s ease}
  .close-icon:hover{color:#ff4500}
  @keyframes fadeIn{from{opacity:0;transform:translate(-50%,-55%)}to{opacity:1;transform:translate(-50%,-50%)}}
  .custom-modal .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3);font-size:12px;background:#fff}
  .custom-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0}
  .custom-modal .modal-header h5{font-size:12px;font-weight:700;margin:0;color:#fff}
  .custom-modal .modal-body{padding:20px;color:#333;background:#f9f9f9}
  .custom-modal .modal-footer{padding:15px;border-top:1px solid #ddd;border-radius:0 0 12px 12px;background:#f1f1f1}
  .action-stack{display:flex;gap:6px;align-items:center;flex-wrap:wrap}
  .icon-text{display:inline-flex;align-items:center;gap:6px;font-size:11px;padding:6px 10px;border-radius:20px;color:#fff}
  .icon-text i{font-size:12px}
  .icon-text.danger{background:#dc3545}
  .row-warning{background:#fff3cd !important}
  .row-warning:hover{background:#ffe69c !important}
  .row-danger{background:#f8d7da !important}
  .row-danger:hover{background:#f5c2c7 !important}
  .mini-kv{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
  .mini-kv .pill{display:inline-flex;align-items:center;gap:6px;padding:4px 8px;border-radius:999px;font-size:10px;font-weight:700}
  .mini-kv .pill.gray{background:#e9ecef;color:#212529}
  .mini-kv .pill.warn{background:#ffc107;color:#212529}
  .mini-kv .pill.dang{background:#dc3545;color:#fff}
  .modal-kv{display:grid;grid-template-columns:140px 1fr;gap:8px 12px;font-size:12px}
  .modal-kv div{padding:6px 0;border-bottom:1px dashed #ddd}
  .modal-kv .k{color:#6c757d;font-weight:700}
  .modal-kv .v{color:#212529;font-weight:700}
  /*.fullscreen-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.35);z-index:1045}*/
  .modal-backdrop,.modal-backdrop.fade,.modal-backdrop.show{display:none!important;opacity:0!important;pointer-events:none!important}
</style>

<div class="fullscreen-overlay" id="fullscreenOverlay"></div>

<div class="table-container">
  <table class="table table-striped table-hover" id="packagesTable">
    <thead>
      <tr>
        <th>CN#</th>
        <th>Full Name</th>
        <th>Sales Name</th>
        <th>Status Date</th>
        <th>Expiry Date</th>
        <th>Proof</th>
        <th>Nationality</th>
        <th>Partner</th>
        <th>Visa</th>
        <th>Arrived Date</th>
        <th>Return Date</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $catRaw = trim((string)($p->category ?? ''));
          $cat = strtoupper($catRaw);
          $office = $p->office ?? null;

          $map = [
            'NEW ARRIVAL'      => ['btn-success','fa-plane-arrival','New Arrival'],
            'SALES RETURN'     => ['btn-info','fa-undo','Sales Return'],
            'TRIAL RETURN'     => ['btn-warning','fa-clipboard-check','Trial Return'],
            'SICK'             => ['btn-info','fa-notes-medical','Sick'],
            'UNFIT'            => ['btn-secondary','fa-user-slash','Unfit'],
            'PREGNANT'         => ['btn-danger','fa-female','Pregnant'],
            'ABSCONDING'       => ['btn-dark','fa-running','Absconding'],
            'RUNAWAY'          => ['btn-dark','fa-shoe-prints','Runaway'],
            'VALID VISA'       => ['btn-primary','fa-passport','Valid Visa'],
            'VALID RESIDENCY'  => ['btn-primary','fa-id-card','Valid Residency'],
            'REFUSED'          => ['btn-danger','fa-ban','Refused'],
            'PSYCHIATRIC'      => ['btn-info','fa-user-md','Psychiatric'],
            'EMBASSY SHELTER'  => ['btn-outline-primary','fa-flag','Embassy Shelter'],
            'HOSPITAL'         => ['btn-info','fa-hospital','Hospital'],
            'POLICE STATION'   => ['btn-outline-dark','fa-shield-alt','Police Station'],
            'JAIL'             => ['btn-secondary','fa-lock','Jail'],
            'WAITING TICKET'   => ['btn-outline-secondary','fa-ticket-alt','Waiting Ticket'],
            'RESERVED'         => ['btn-outline-secondary','fa-bookmark','Reserved'],
            'REPATRIATION'     => ['btn-outline-warning','fa-plane','Repatriation'],
            'EMBASSY'          => ['btn-outline-primary','fa-flag','Embassy'],
          ];
          [$btn,$icon,$label] = $map[$cat] ?? ['btn-light','fa-tag', ($catRaw !== '' ? ucfirst(strtolower($catRaw)) : 'Unknown')];

          $candidateTitle = $p->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($p->candidate_name))) : 'N/A';
          $isNewArrival = strtoupper(trim($catRaw)) === 'NEW ARRIVAL';

          $financeRejected = $office && strtoupper(trim((string)($office->finance_status ?? ''))) === 'REJECTED';
          $commentRejected = $office && strtoupper(trim((string)($office->comment_status ?? $office->status_comment ?? $office->comments_status ?? ''))) === 'REJECTED';

          $financeUpdatedAt = $office && $office->updated_at ? \Carbon\Carbon::parse($office->updated_at)->timezone('Asia/Qatar')->format('d M Y, h:i A') : '';
          $expiryIso = $p->expiry_date ? \Carbon\Carbon::parse($p->expiry_date)->timezone('Asia/Qatar')->format('Y-m-d') : '';
          $expiryHuman = $p->expiry_date ? \Carbon\Carbon::parse($p->expiry_date)->format('d M Y') : '';
          $passportNo = strtoupper(trim((string)($p->passport_no ?? '')));
        ?>

        <tr
          data-cn="<?php echo e(strtoupper((string)($p->CN_Number ?? ''))); ?>"
          data-candidate="<?php echo e(e($candidateTitle)); ?>"
          data-nationality="<?php echo e(strtoupper((string)($p->nationality ?? ''))); ?>"
          data-visa="<?php echo e(strtoupper((string)($p->visa_type ?? ''))); ?>"
          data-expiry="<?php echo e($expiryIso); ?>"
          data-expiry-human="<?php echo e($expiryHuman); ?>"
          data-category="<?php echo e(strtoupper($catRaw)); ?>"
          data-package-id="<?php echo e($p->id); ?>"
          data-passport="<?php echo e($passportNo); ?>"
          data-comment-rejected="<?php echo e($commentRejected ? 1 : 0); ?>"
          data-finance-rejected="<?php echo e($financeRejected ? 1 : 0); ?>"
        >
          <td><?php echo e(strtoupper((string)($p->CN_Number ?? ''))); ?></td>
          <td>
            <div><?php echo e(strtoupper((string)($p->candidate_name ?? ''))); ?></div>
            <div class="text-muted small">
              PP: <?php echo e($passportNo ?: 'N/A'); ?>

              • EXP: <?php echo e($p->passport_expiry_date ? \Carbon\Carbon::parse($p->passport_expiry_date)->format('d M Y') : 'N/A'); ?>

            </div>
          </td>
          <td title="<?php echo e($p->sales_name); ?>"><?php echo e(strtoupper(explode(' ', (string)$p->sales_name)[0] ?? '')); ?></td>
          <td style="text-align:center;font-size:12px">
            <div><?php echo e($p->updated_at ? strtoupper($p->updated_at->format('d M Y')) : ''); ?></div>
            <div class="mt-1">
              <span class="btn btn-sm <?php echo e($btn); ?>" style="font-size:10px">
                <i class="fas <?php echo e($icon); ?> mr-1"></i> <?php echo e(strtoupper($label)); ?>

              </span>
            </div>
          </td>
          <td style="text-align:center">
            <div class="expiry-date-text"><?php echo e($expiryHuman); ?></div>
            <div class="mini-kv mt-1" style="justify-content:center">
              <span class="pill gray">OVD: <span class="ovd-days">0</span></span>
              <span class="pill gray">FINE: <span class="fine-amt">0</span></span>
              <span class="pill gray">DUE: <span class="due-in">N/A</span></span>
            </div>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-icon-only js-view-proof" data-proof-url="<?php echo e($p->ica_proof ? asset('storage/'.$p->ica_proof) : ''); ?>">
              <i class="fas fa-eye"></i>
            </button>
          </td>
          <td><?php echo e(strtoupper((string)($p->nationality ?? ''))); ?></td>
          <td title="<?php echo e(strtoupper((string)($p->foreign_partner ?? ''))); ?>"><?php echo e(strtoupper(strtok((string)($p->foreign_partner ?? ''), ' '))); ?></td>
          <td><?php echo e(strtoupper((string)($p->visa_type ?? ''))); ?></td>
          <td><?php echo e($p->arrived_date ? \Carbon\Carbon::parse($p->arrived_date)->format('d M Y') : ''); ?></td>
          <td><?php echo e($p->returned_date ? \Carbon\Carbon::parse($p->returned_date)->format('d M Y') : ''); ?></td>
          <td><?php echo e($p->description); ?></td>
          <td>
            <div class="action-stack">
              <button type="button" class="btn btn-primary btn-icon-only js-open-status" title="Change Status"
                data-package-id="<?php echo e($p->id); ?>"
                data-candidate="<?php echo e(e((string)($p->candidate_name ?? ''))); ?>"
                data-candidate-title="<?php echo e(e($candidateTitle)); ?>"
              >
                <i class="fas fa-train"></i>
              </button>

              <?php if($financeRejected): ?>
                <button type="button" class="btn btn-dark btn-icon-only js-finance-rejected" title="Finance Rejected"
                  data-cn="<?php echo e(strtoupper((string)($p->CN_Number ?? ''))); ?>"
                  data-candidate="<?php echo e($candidateTitle); ?>"
                  data-category="<?php echo e(strtoupper($catRaw)); ?>"
                  data-status="<?php echo e(strtoupper((string)($office->finance_status ?? ''))); ?>"
                  data-comments="<?php echo e(e((string)($office->finance_comments ?? ''))); ?>"
                  data-updated="<?php echo e($financeUpdatedAt); ?>"
                  data-office-id="<?php echo e($office->id ?? ''); ?>"
                  data-package-id="<?php echo e($p->id); ?>"
                >
                  <i class="fas fa-money-check-alt"></i>
                </button>
              <?php endif; ?>

              <?php if($commentRejected): ?>
                <span class="icon-text danger" title="Rejected">
                  <i class="fas fa-comment-dots"></i> REJECTED
                </span>
              <?php endif; ?>

              <a href="<?php echo e(route('package.exit', ['reference_no' => $p->cn_number_series])); ?>" class="btn btn-primary btn-icon-only" title="Exit Form" target="_blank">
                <i class="fas fa-file-export"></i>
              </a>

              <button type="button" class="btn btn-primary btn-icon-only js-edit-office" title="Edit Package"
                data-office-id="<?php echo e($office->id ?? ''); ?>"
                data-candidate-id="<?php echo e($p->id); ?>"
                data-cn="<?php echo e($p->CN_Number); ?>"
                data-name="<?php echo e($p->candidate_name); ?>"
                data-passport-no="<?php echo e($p->passport_no); ?>"
                data-nationality="<?php echo e($p->nationality); ?>"
                data-category="<?php echo e($office->category ?? ''); ?>"
                data-returned-date="<?php echo e($office->returned_date ?? ''); ?>"
                data-expiry-date="<?php echo e($office->expiry_date ?? ''); ?>"
                data-ica-proof="<?php echo e($office->ica_proof ?? ''); ?>"
                data-overstay-days="<?php echo e($office->overstay_days ?? ''); ?>"
                data-fine-amount="<?php echo e($office->fine_amount ?? ''); ?>"
                data-passport-status="<?php echo e($office->passport_status ?? ''); ?>"
              >
                <i class="fas fa-edit"></i>
              </button>
            </div>

            <div class="dropdown-container" id="dropdownContainer-<?php echo e($p->id); ?>">
              <div class="close-icon js-close-dropdown" data-package-id="<?php echo e($p->id); ?>"><i class="fas fa-times-circle"></i></div>
              <div class="dropdown-header">
                <div class="header-icon"><i class="fas fa-info-circle"></i></div>
                <p>Do you want to change the status of</p>
                <p>package <span class="package-name" id="packageName-<?php echo e($p->id); ?>"></span>?</p>
              </div>

              <?php
                $allowedStatuses = [0 => 'Change Status', 2 => 'Trial', 5 => 'Incident'];
              ?>

              <select
                class="form-control status-dropdown js-status-select"
                id="statusDropdown-<?php echo e($p->id); ?>"
                name="current_status"
                data-package-id="<?php echo e($p->id); ?>"
                data-original="<?php echo e($p->_status); ?>"
                data-cn="<?php echo e($p->cn_number_series); ?>"
                data-can-convert="<?php echo e($isNewArrival ? 1 : 0); ?>"
              >
                <?php $__currentLoopData = $allowedStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusId => $statusName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($statusId); ?>" <?php echo e($p->_status == $statusId ? 'selected' : ''); ?>><?php echo e($statusName); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($isNewArrival): ?>
                  <option value="contracted">Convert to Contract</option>
                <?php else: ?>
                  <option value="contracted" disabled>Convert to Contract</option>
                <?php endif; ?>
              </select>

              <?php if(!$isNewArrival): ?>
                <div class="small text-muted mt-2" style="text-align:left;font-size:8px">
                  Convert to Contract is available only when category is <b>New Arrival</b>.
                </div>
              <?php endif; ?>
            </div>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="13" class="text-center">No results found.</td>
        </tr>
      <?php endif; ?>
    </tbody>

    <tfoot>
      <tr>
        <th>CN#</th>
        <th>Full Name</th>
        <th>Sales Name</th>
        <th>Status Date</th>
        <th>Expiry Date</th>
        <th>Proof</th>
        <th>Nationality</th>
        <th>Partner</th>
        <th>Visa</th>
        <th>Arrived Date</th>
        <th>Return Date</th>
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

<div class="modal fade custom-modal" id="financeRejectedModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-money-check-alt me-2"></i> Finance Rejected</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="modal-kv">
          <div class="k">CN#</div><div class="v" id="fr_cn"></div>
          <div class="k">Candidate</div><div class="v" id="fr_candidate"></div>
          <div class="k">Category</div><div class="v" id="fr_category"></div>
          <div class="k">Finance Status</div><div class="v" id="fr_status"></div>
          <div class="k">Updated At</div><div class="v" id="fr_updated_at"></div>
        </div>
        <div class="mt-3">
          <div class="k" style="font-weight:700;color:#6c757d;margin-bottom:6px">Finance Comments</div>
          <div class="p-3" style="background:#fff;border:1px solid #ddd;border-radius:10px;white-space:pre-wrap" id="fr_comments"></div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="editOfficeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-building me-2"></i> Edit Package Office</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="editOfficeForm" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
          <input type="hidden" id="eo_office_id" name="office_id" required>
          <input type="hidden" id="eo_candidate_id" name="candidate_id" required>

          <div class="row g-3 mb-2">
            <div class="col-md-4">
              <label class="form-label">Candidate</label>
              <input type="text" id="eo_name" class="form-control" readonly required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Passport No</label>
              <input type="text" id="eo_passport_no" class="form-control" readonly required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Nationality</label>
              <input type="text" id="eo_nationality" class="form-control" readonly required>
            </div>
          </div>

          <div class="row g-3 mb-2">
            <div class="col-md-4 d-none">
              <label class="form-label">Type</label>
              <input type="text" id="eo_type" name="type" class="form-control" value="package" readonly required>
            </div>

            <div class="col-md-4">
              <label for="eo_category" class="form-label">Category</label>
              <select id="eo_category" name="category" class="form-control" required>
                <option value="">Select Category</option>
                <option value="Sales Return">Sales Return</option>
                <option value="Trial Return">Trial Return</option>
                <option value="New Arrival">New Arrival</option>
                <option value="Unfit">Unfit</option>
                <option value="Others">Others</option>
              </select>
            </div>

            <div class="col-md-4">
              <label for="eo_returned_date" class="form-label">Return Date</label>
              <input type="date" id="eo_returned_date" name="returned_date" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label for="eo_expiry_date" class="form-label">Expiry Date</label>
              <input type="date" id="eo_expiry_date" name="expiry_date" class="form-control" required>
            </div>
          </div>

          <div class="row g-3 mb-2">
            <div class="col-md-6">
              <label class="form-label">ICA Proof</label>
              <div class="d-flex align-items-center gap-2">
                <input type="file" id="eo_ica_proof" name="ica_proof" class="form-control" accept="image/*,application/pdf">
                <a id="eo_ica_view" class="btn btn-primary btn-icon-only" target="_blank" style="display:none">
                  <i class="fas fa-eye"></i>
                </a>
              </div>
            </div>

            <div class="col-md-3">
              <label for="eo_overstay_days" class="form-label">Overstay Days</label>
              <input type="text" id="eo_overstay_days" name="overstay_days" class="form-control" readonly required>
            </div>

            <div class="col-md-3">
              <label for="eo_fine_amount" class="form-label">Fine Amount</label>
              <input type="text" id="eo_fine_amount" name="fine_amount" class="form-control" readonly required>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-4">
              <label for="eo_passport_status" class="form-label">Passport Status</label>
              <select id="eo_passport_status" name="passport_status" class="form-control" required>
                <option value="">Select Passport Status</option>
                <option value="With Employer">With Employer</option>
                <option value="With Candidate">With Candidate</option>
                <option value="Expired">Expired</option>
                <option value="Office">Office</option>
                <option value="Lost">Lost</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <div class="col-md-4 d-none">
              <input type="hidden" id="eo_updated_by" name="update_by" value="<?php echo e(auth()->id()); ?>">
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="eo_save_btn">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="trialModal" class="modal fade custom-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="TrialModalLabel"><i class="fas fa-box-open text-light"></i> Trial Agreement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:#fff"></button>
      </div>

      <form id="agreement_form" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

          <div class="card border-info mb-3">
            <div class="card-body">
              <h5 class="card-title text-default"><i class="fas fa-clipboard-list"></i> Select Package and Client</h5>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="Package"><i class="fas fa-cube text-default"></i> Select Package <span class="text-danger">*</span></label>
                  <select id="Package" class="form-control" required>
                    <option value="">Select Package</option>
                    <option value="PKG-1">PKG-1</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="clientDropdown"><i class="fas fa-user text-default"></i> Select Client <span class="text-danger">*</span></label>
                  <select id="clientDropdown" class="form-control select2" required></select>
                </div>
              </div>

              <div class="row mb-4" id="new_contract_field">
                <div class="col-md-6">
                  <label for="VisaType"><i class="fas fa-passport text-default me-2"></i> Select Visa Type <span class="text-danger">*</span></label>
                  <select id="VisaType" class="form-control" required>
                    <option value="">Select Visa Type</option>
                    <option value="D-SPO">D-SPO</option>
                    <option value="D-HIRE">D-HIRE</option>
                    <option value="TADBEER">TADBEER</option>
                    <option value="TOURIST">TOURIST</option>
                    <option value="VISIT">VISIT</option>
                    <option value="OFFICE-VISA">OFFICE-VISA</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="contractDuration"><i class="fas fa-calendar-alt text-default"></i> Contract Duration <span class="text-danger">*</span></label>
                  <input type="text" id="contractDuration" name="contract_duration" class="form-control" value="2 Years" readonly required>
                </div>
              </div>
            </div>
          </div>

          <div class="card border-info mb-3">
            <div class="card-body">
              <h5 class="card-title text-default"><i class="fas fa-money-check-alt"></i> Office Transaction</h5>
              <div class="alert alert-info small mb-4"><i class="fas fa-info-circle me-1"></i> Enter complete amount including VAT.</div>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="officePaymentMethod"><i class="fas fa-wallet text-default"></i> Payment Method <span class="text-danger">*</span></label>
                  <select id="officePaymentMethod" class="form-control" required>
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
              </div>

              <div class="row office-amount-row">
                <div class="col-lg-6 mb-3">
                  <label for="officeTotalAmount"><i class="fas fa-calculator text-default"></i> Total Amount <span class="text-danger">*</span></label>
                  <input type="text" id="officeTotalAmount" class="form-control" required>
                </div>

                <div class="col-lg-6 mb-3">
                  <label for="officeReceivedAmount"><i class="fas fa-hand-holding-usd text-default"></i> Received Amount <span class="text-danger">*</span></label>
                  <input type="text" id="officeReceivedAmount" class="form-control" required>
                </div>

                <div class="col-lg-6 mb-3">
                  <label for="officeRemainingAmount"><i class="fas fa-balance-scale text-default"></i> Remaining Amount</label>
                  <input type="text" id="officeRemainingAmount" class="form-control" readonly>
                </div>

                <div class="col-lg-6 mb-3 office-payment-proof-col">
                  <label for="officePaymentProof"><i class="fas fa-upload text-default"></i> Upload Payment Proof <span class="text-danger">*</span></label>
                  <input type="file" id="officePaymentProof" class="form-control" accept="image/*,application/pdf">
                </div>

                <div class="col-12 mb-0">
                  <label for="officePaymentNotes"><i class="fas fa-sticky-note text-default"></i> Payment Notes</label>
                  <textarea id="officePaymentNotes" class="form-control" placeholder="Enter notes (optional)"></textarea>
                </div>
              </div>

              <p class="small text-muted mt-2">Payment proof is required if received amount is greater than 0 and payment method is not Cash.</p>
            </div>
          </div>

          <div class="card border-info mb-3">
            <div class="card-body">
              <h5 class="card-title text-default"><i class="fas fa-money-check-alt"></i> Govt. Transaction</h5>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="govtPaymentMethod"><i class="fas fa-wallet text-default"></i> Payment Method</label>
                  <select id="govtPaymentMethod" class="form-control">
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

                <div class="col-md-4">
                  <label for="govtServiceSelect"><i class="fas fa-search text-default"></i> Select Service</label>
                  <select id="govtServiceSelect" class="form-control select2">
                    <option value="">Search and Select Service</option>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($service->service_name); ?>"><?php echo e($service->service_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="govtTotalAmount"><i class="fas fa-calculator text-default"></i> Total Amount</label>
                  <input type="text" id="govtTotalAmount" class="form-control" value="0">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="govtReceivedAmount"><i class="fas fa-hand-holding-usd text-default"></i> Received Amount</label>
                  <input type="text" id="govtReceivedAmount" class="form-control" value="0">
                </div>

                <div class="col-md-4">
                  <label for="govtRemainingAmount"><i class="fas fa-balance-scale text-default"></i> Remaining Amount</label>
                  <input type="text" id="govtRemainingAmount" class="form-control" value="0" readonly>
                </div>

                <div class="col-md-4">
                  <label for="govtVatAmount"><i class="fas fa-percentage text-default"></i> VAT Amount</label>
                  <input type="text" id="govtVatAmount" class="form-control" value="0">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="govtNetAmount"><i class="fas fa-money-check text-default"></i> Net Amount</label>
                  <input type="text" id="govtNetAmount" class="form-control" readonly>
                </div>

                <div class="col-md-8">
                  <label for="govtPaymentProof"><i class="fas fa-upload text-default"></i> Upload Payment Proof</label>
                  <input type="file" id="govtPaymentProof" class="form-control" accept="image/*,application/pdf">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-12">
                  <label for="govtPaymentNotes"><i class="fas fa-sticky-note text-default"></i> Payment Notes</label>
                  <textarea id="govtPaymentNotes" class="form-control" name="govt_notes" placeholder="Enter any notes (optional)"></textarea>
                </div>
              </div>

              <p class="small text-muted">Payment proof is required if received amount is greater than 0 and payment method is not Cash.</p>
            </div>
          </div>

          <div class="card border-secondary mb-3">
            <div class="card-body">
              <h5 class="card-title text-default"><i class="fas fa-file-medical"></i> Medical Certificate</h5>
              <div class="row">
                <div class="col-md-12">
                  <label for="medicalCertificate"><i class="fas fa-upload text-default"></i> Upload Medical Certificate</label>
                  <input type="file" id="medicalCertificate" class="form-control" accept="image/*,application/pdf">
                </div>
              </div>
            </div>
          </div>

          <div class="card border-success mb-3">
            <div class="card-body">
              <h5 class="card-title text-default"><i class="fas fa-file-signature"></i> Create Agreement</h5>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="selectedModalcandidateName"><i class="fas fa-user text-default"></i> Candidate <span class="text-danger">*</span></label>
                  <input type="text" id="selectedModalcandidateName" class="form-control" readonly required>
                  <input type="hidden" id="selectedModalcandidateId" name="candidate_id" required>
                  <input type="hidden" id="selectedModalreferenceNo" name="reference_no" required>
                  <input type="hidden" id="selectedModalrefNo" name="ref_no" required>
                  <input type="hidden" id="selectedModalforeignPartner" name="foreign_partner" required>
                  <input type="hidden" id="selectedModalcandiateNationality" name="candidate_nationality" required>
                  <input type="hidden" id="selectedModalcandidatePassportNumber" name="candidate_passport_number" required>
                  <input type="hidden" id="selectedModalcandidatePassportExpiry" name="candidate_passport_expiry" required>
                  <input type="hidden" id="selectedModalcandidateDOB" name="candidate_dob" required>
                  <input type="hidden" id="selectedModalcandidateType" name="candidate_type" value="package" required>
                </div>

                <div class="col-md-6">
                  <label for="agreementType"><i class="fas fa-file text-default"></i> Agreement Type <span class="text-danger">*</span></label>
                  <select id="agreementType" class="form-control" required>
                    <option value="">Select Agreement Type</option>
                    <option value="BIA" selected>Booking Inside Agreement (BIA/TA)</option>
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="trialStartDate"><i class="fas fa-calendar text-default"></i> Trial Start Date <span class="text-danger">*</span></label>
                  <input type="date" id="trialStartDate" name="trial_start_date" class="form-control" required>
                </div>

                <div class="col-md-6">
                  <label for="trialEndDate"><i class="fas fa-calendar text-default"></i> Trial End Date <span class="text-danger">*</span></label>
                  <input type="date" id="trialEndDate" name="trial_end_date" class="form-control" required>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="number_of_days"><i class="fas fa-calendar-check text-default"></i> Number of Days <span class="text-danger">*</span></label>
                  <input type="text" id="number_of_days" name="number_of_days" class="form-control" value="0" readonly required>
                </div>

                <div class="col-md-6">
                  <label for="agreedSalary"><i class="fas fa-coins text-default"></i> Agreed Salary <span class="text-danger">*</span></label>
                  <input type="text" id="agreedSalary" class="form-control" required>
                </div>
              </div>

            </div>
          </div>

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveChanges" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="incidentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
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
      <input type="hidden" id="im_received_raw" value="0">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Incident</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

          <div class="card border-warning mb-3" id="im_agreement_card">
            <div class="card-body mt-4">
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

<div class="modal fade custom-modal" id="contractedModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="false" data-bs-keyboard="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-file-signature me-2"></i> Convert to Contract</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="contractedForm" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
          <input type="hidden" id="ct_package_id" name="package_id">
          <input type="hidden" id="ct_candidate_id" name="candidate_id">
          <input type="hidden" id="ct_cn" name="cn_number">
          <input type="hidden" id="ct_passport_hidden" name="passport_no">
          <input type="hidden" id="ct_outstanding_total_raw" value="0">

          <div class="row g-3 mb-2">
            <div class="col-md-4">
              <label class="form-label">CN#</label>
              <input type="text" id="ct_cn_view" class="form-control" readonly>
            </div>
            <div class="col-md-4">
              <label class="form-label">Candidate</label>
              <input type="text" id="ct_candidate_name" class="form-control" readonly>
            </div>
            <div class="col-md-4">
              <label class="form-label">Passport No</label>
              <input type="text" id="ct_passport_no" class="form-control" readonly>
            </div>
          </div>

          <div class="card border-info m3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center m-2">
                <h6 class="m-0"><i class="fas fa-receipt me-2"></i> Tax Invoices</h6>
                <div class="small text-muted">Pending invoices for this candidate</div>
              </div>

              <div class="table-responsive">
                <table class="table table-striped table-hover mb-2">
                  <thead>
                    <tr>
                      <th>Invoice #</th>
                      <th>Date</th>
                      <th class="text-end">Total</th>
                      <th class="text-end">Paid</th>
                      <th class="text-end">Remaining</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="ct_invoices_tbody">
                    <tr><td colspan="6" class="text-center text-muted">No invoice data.</td></tr>
                  </tbody>
                </table>
              </div>

              <div class="row g-3 mt-1">
                <div class="col-md-4">
                  <label class="form-label">Outstanding Total</label>
                  <input type="text" id="ct_outstanding_total" class="form-control" readonly>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Pay Now</label>
                  <input type="text" id="ct_pay_amount" name="pay_amount" class="form-control" value="0">
                </div>
                <div class="col-md-4">
                  <label class="form-label">Remaining After Payment</label>
                  <input type="text" id="ct_remaining_after" class="form-control" readonly>
                </div>
              </div>

              <div class="row g-3 mt-1">
                <div class="col-md-4">
                  <label class="form-label">Payment Method</label>
                  <select id="ct_payment_method" name="payment_method" class="form-control" required>
                    <option value="">Select Payment Method</option>
                    <option value="Bank Transfer ADIB">Bank Transfer ADIB</option>
                    <option value="Bank Transfer ADCB">Bank Transfer ADCB</option>
                    <option value="POS ADCB">POS ADCB</option>
                    <option value="POS ADIB">POS ADIB</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="METTPAY">METTPAY</option>
                    <option value="Replacement">Replacement</option>
                  </select>
                  <div class="small text-muted mt-1" id="ct_proof_note"></div>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Attach Payment Proof</label>
                  <input type="file" id="ct_payment_proof" name="payment_proof" class="form-control" accept="image/*,application/pdf">
                </div>
              </div>

              <div class="row g-3 mt-1">
                <div class="col-md-12">
                  <label class="form-label">Comments</label>
                  <textarea id="ct_comments" name="comments" class="form-control" rows="3" placeholder="Add comments (optional)"></textarea>
                </div>
              </div>

            </div>
          </div>

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="submit" class="btn btn-primary" id="ct_save_btn"><i class="fas fa-save"></i> Save Conversion</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
(() => {
  const qsa = (s, r=document) => Array.from(r.querySelectorAll(s));
  const killBackdrops = () => qsa('.modal-backdrop').forEach(e => e.remove());
  document.addEventListener('shown.bs.modal', killBackdrops, true);
  document.addEventListener('hidden.bs.modal', killBackdrops, true);
  window.addEventListener('load', killBackdrops);
})();

(() => {
  const csrf = () => $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val() || '';

  const num = (v) => {
    const n = parseFloat(String(v ?? '').replace(/[^0-9.]/g,''));
    return Number.isFinite(n) ? n : 0;
  };

  const fix2 = (n) => (Number.isFinite(n) ? n : 0).toFixed(2);

  const sanitizeNumberInput = (el) => {
    const sanitized = String($(el).val() ?? '').replace(/[^0-9.]/g,'');
    const parts = sanitized.split('.');
    $(el).val(parts.length > 2 ? (parts[0] + '.' + parts.slice(1).join('')) : sanitized);
  };

  const moneyInt = (n) => (Number.isFinite(n) ? n : 0).toLocaleString(undefined,{maximumFractionDigits:0});

  const aed = (n) => {
    const x = Number.isFinite(n) ? n : 0;
    try { return new Intl.NumberFormat(undefined,{style:'currency',currency:'AED',maximumFractionDigits:0}).format(x); }
    catch(e){ return `AED ${moneyInt(x)}`; }
  };

  const modalShow = (id) => {
    const el = document.getElementById(id);
    if (!el) return;
    if (window.bootstrap?.Modal) {
      const inst = window.bootstrap.Modal.getOrCreateInstance(el,{backdrop:false,keyboard:true,focus:true});
      inst.show();
      return;
    }
    if (typeof $ === 'function' && $(el).modal) $(el).modal({backdrop:false,keyboard:true,show:true});
  };

  const modalHide = (id) => {
    const el = document.getElementById(id);
    if (!el) return;
    if (window.bootstrap?.Modal) {
      const inst = window.bootstrap.Modal.getInstance(el);
      if (inst) inst.hide();
      return;
    }
    if (typeof $ === 'function' && $(el).modal) $(el).modal('hide');
  };

  const overlayShow = () => $('#fullscreenOverlay').stop(true,true).fadeIn(120);
  const overlayHide = () => $('#fullscreenOverlay').stop(true,true).fadeOut(120);
  const closeAllDropdowns = () => { $('.dropdown-container').stop(true,true).fadeOut(120); overlayHide(); };

  const openDropdown = (packageId, candidateTitle) => {
    closeAllDropdowns();
    overlayShow();
    $(`#packageName-${packageId}`).text(candidateTitle || '');
    $(`#dropdownContainer-${packageId}`).stop(true,true).fadeIn(160);
  };

  $('#fullscreenOverlay').on('click', closeAllDropdowns);
  $(document).on('click', '.js-close-dropdown', closeAllDropdowns);

  $(document).on('click', '.js-open-status', function () {
    const packageId = $(this).data('package-id');
    const candidateTitle = $(this).data('candidate-title') || $(this).data('candidate') || '';
    const $dd = $(`#statusDropdown-${packageId}`);
    if ($dd.length) $dd.get(0).dataset.original = String($dd.val() ?? '');
    openDropdown(packageId, candidateTitle);
  });

  $(document).on('click', '.js-view-proof', function () {
    const url = $(this).data('proof-url');
    if (url) window.open(url,'_blank');
    else toastr.error('No proof uploaded.');
  });

  $(document).on('click', '.js-finance-rejected', function () {
    const $el = $(this);
    $('#fr_cn').text($el.data('cn') || '');
    $('#fr_candidate').text($el.data('candidate') || '');
    $('#fr_category').text($el.data('category') || '');
    $('#fr_status').text($el.data('status') || 'REJECTED');
    $('#fr_updated_at').text($el.data('updated') || '');
    const c = $el.data('comments');
    $('#fr_comments').text((c !== undefined && c !== null && String(c).trim() !== '') ? String(c) : 'No comments.');
    modalShow('financeRejectedModal');
  });

  const computeOfficeOverstay = () => {
    const r = $('#eo_returned_date').val();
    const e = $('#eo_expiry_date').val();
    if (!r || !e) { $('#eo_overstay_days').val(''); $('#eo_fine_amount').val(''); return; }
    const rd = new Date(r);
    const ed = new Date(e);
    let days = 0;
    if (!isNaN(rd.getTime()) && !isNaN(ed.getTime()) && rd > ed) days = Math.ceil((rd - ed) / 86400000);
    $('#eo_overstay_days').val(days);
    $('#eo_fine_amount').val(fix2(days * 50));
  };

  $(document).on('change', '#eo_returned_date,#eo_expiry_date', computeOfficeOverstay);

  $(document).on('click', '.js-edit-office', function () {
    const btn = $(this);
    $('#eo_office_id').val(btn.data('office-id') || '');
    $('#eo_candidate_id').val(btn.data('candidate-id') || '');
    $('#eo_name').val(btn.data('name') || '');
    $('#eo_passport_no').val(btn.data('passport-no') || '');
    $('#eo_nationality').val(btn.data('nationality') || '');
    $('#eo_category').val(btn.data('category') || '');
    $('#eo_returned_date').val(btn.data('returned-date') || '');
    $('#eo_expiry_date').val(btn.data('expiry-date') || '');
    $('#eo_overstay_days').val(btn.data('overstay-days') || '');
    $('#eo_fine_amount').val(btn.data('fine-amount') || '');
    $('#eo_passport_status').val(btn.data('passport-status') || '');

    const proof = btn.data('ica-proof') || '';
    if (proof) {
      const href = (`${window.location.origin}/storage/${proof}`).replace(/\/+/g,'/').replace(':/','://');
      $('#eo_ica_view').attr('href', href).show();
    } else {
      $('#eo_ica_view').hide().attr('href','#');
    }

    computeOfficeOverstay();
    modalShow('editOfficeModal');
  });

  $('#eo_save_btn').on('click', function () {
    const required = ['#eo_candidate_id','#eo_name','#eo_passport_no','#eo_nationality','#eo_category','#eo_returned_date','#eo_expiry_date','#eo_passport_status'];
    for (const s of required) { if (!$(s).val()) { toastr.error('Please fill all required fields.'); return; } }
    computeOfficeOverstay();

    const fd = new FormData(document.getElementById('editOfficeForm'));
    fd.set('type','package');
    fd.set('update_by',$('#eo_updated_by').val());

    $.ajax({
      url: "<?php echo e(route('office.update')); ?>",
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf() },
      data: fd,
      contentType: false,
      processData: false,
      success: (res) => {
        if (res && res.success) {
          toastr.success(res.message || 'Saved');
          modalHide('editOfficeModal');
          location.reload();
        } else {
          toastr.error((res && res.message) || 'Failed');
        }
      },
      error: (xhr) => {
        const j = xhr.responseJSON;
        if (j && j.errors) Object.values(j.errors).flat().forEach(m => toastr.error(m));
        else if (j && j.message) toastr.error(j.message);
        else toastr.error('Error');
      }
    });
  });

  const numberSelectors = [
    '#officeTotalAmount','#officeReceivedAmount',
    '#govtTotalAmount','#govtReceivedAmount','#govtRemainingAmount','#govtVatAmount',
    '#agreedSalary','#ct_pay_amount','#im_office_charges'
  ];
  $(document).on('input', numberSelectors.join(','), function(){ sanitizeNumberInput(this); });

  $(document).on('input', '#officeTotalAmount,#officeReceivedAmount', function () {
    const total = num($('#officeTotalAmount').val());
    const received = num($('#officeReceivedAmount').val());
    if (total < 0) { toastr.error('Total amount cannot be negative.'); $('#officeTotalAmount').val('0'); return; }
    if (received < 0) { toastr.error('Received amount cannot be negative.'); $('#officeReceivedAmount').val('0'); return; }
    if (received > total) { toastr.error('Received amount cannot exceed the total amount.'); $('#officeReceivedAmount').val(''); $('#officeRemainingAmount').val(''); return; }
    $('#officeRemainingAmount').val(fix2(total - received));
  });

  $(document).on('input', '#govtTotalAmount,#govtReceivedAmount,#govtVatAmount', function () {
    const total = num($('#govtTotalAmount').val());
    const received = num($('#govtReceivedAmount').val());
    let vat = num($('#govtVatAmount').val());

    if (total < 0) { toastr.error('Total amount cannot be negative.'); $('#govtTotalAmount').val('0'); }
    if (received < 0) { toastr.error('Received amount cannot be negative.'); $('#govtReceivedAmount').val('0'); }
    if (received > total) { toastr.error('Received amount cannot exceed the total amount.'); $('#govtReceivedAmount').val(''); $('#govtRemainingAmount').val(''); $('#govtNetAmount').val(''); return; }
    if (vat < 0) { toastr.error('VAT amount cannot be negative.'); vat = 0; $('#govtVatAmount').val('0'); }

    $('#govtRemainingAmount').val(fix2(total - received));
    $('#govtNetAmount').val(fix2(total + vat));
  });

  $(document).on('change', '#officePaymentProof,#govtPaymentProof,#ct_payment_proof,#medicalCertificate,#im_proof', function () {
    const v = $(this).val() || '';
    if (!v) return;
    const ext = v.split('.').pop().toLowerCase();
    if (!['png','jpeg','jpg','pdf'].includes(ext)) { toastr.error('Only PNG, JPEG, JPG, and PDF files are allowed.'); $(this).val(''); }
  });

  const recomputeTrialDays = () => {
    const start = new Date($("#trialStartDate").val());
    const end = new Date($("#trialEndDate").val());
    let days = 0;
    if (!isNaN(start.getTime()) && !isNaN(end.getTime()) && end >= start) days = Math.ceil((end - start) / 86400000);
    $("#number_of_days").val(days);
  };
  $(document).on('change', '#trialStartDate,#trialEndDate', recomputeTrialDays);

  $(document).on('blur', '#agreedSalary', function () {
    const salaryVal = num($(this).val());
    if (!Number.isFinite(salaryVal) || salaryVal < 1200) { toastr.error('The agreed salary must be at least 1200.'); $(this).val('').focus(); }
  });

  const validateAgreementForm = () => {
    const pkg = $('#Package').val();
    const client = $('#clientDropdown').val();
    const cand = $('#selectedModalcandidateName').val().trim();
    const visa = $('#VisaType').val();
    const officeTotal = num($('#officeTotalAmount').val());
    const officeReceived = num($('#officeReceivedAmount').val());
    const officeMethod = ($('#officePaymentMethod').val() || '').toLowerCase();
    const officeProof = $('#officePaymentProof').val();
    const salary = num($('#agreedSalary').val());
    const tStart = $('#trialStartDate').val();
    const tEnd = $('#trialEndDate').val();

    if (!pkg) return toastr.error('Please select a package.'), false;
    if (!client) return toastr.error('Please select a client.'), false;
    if (!cand) return toastr.error('Candidate name is required.'), false;
    if (!visa) return toastr.error('Please select a visa type.'), false;
    if (!tStart || !tEnd) return toastr.error('Trial dates are required.'), false;
    if (!(officeTotal > 0)) return toastr.error('Office total amount must be greater than zero.'), false;
    if (officeReceived < 0) return toastr.error('Received amount cannot be negative.'), false;
    if (officeReceived > officeTotal) return toastr.error('Received amount cannot exceed the total amount.'), false;
    if (officeReceived > 0 && officeMethod !== 'cash' && !officeProof) return toastr.error('Payment proof is required when received amount is greater than 0 and payment method is not Cash.'), false;
    if (!Number.isFinite(salary) || salary < 1200) return toastr.error('Agreed salary must be at least 1200.'), false;

    return true;
  };

  $('#saveChanges').on('click', function (e) {
    e.preventDefault();
    if (!validateAgreementForm()) return;

    const btn = $('#saveChanges');
    btn.prop('disabled', true);

    const formData = new FormData();
    formData.append('candidate_id', $('#selectedModalcandidateId').val());
    formData.append('candidate_name', $('#selectedModalcandidateName').val());
    formData.append('reference_of_candidate', $('#selectedModalreferenceNo').val());
    formData.append('ref_no_in_of_previous', $('#selectedModalrefNo').val());
    formData.append('package', $('#Package').val());
    formData.append('client_id', $('#clientDropdown').val());
    formData.append('payment_method', $('#officePaymentMethod').val());
    formData.append('total_amount', $('#officeTotalAmount').val());
    formData.append('received_amount', $('#officeReceivedAmount').val());
    formData.append('remaining_amount', $('#officeRemainingAmount').val());
    if ($('#officePaymentProof')[0].files[0]) formData.append('payment_proof', $('#officePaymentProof')[0].files[0]);
    formData.append('agreement_type', $('#agreementType').val());
    formData.append('contract_duration', $('#contractDuration').val());
    formData.append('salary', $('#agreedSalary').val());
    formData.append('foreign_partner', $('#selectedModalforeignPartner').val());
    formData.append('nationality', $('#selectedModalcandiateNationality').val());
    formData.append('passport_no', $('#selectedModalcandidatePassportNumber').val());
    formData.append('passport_expiry_date', $('#selectedModalcandidatePassportExpiry').val());
    formData.append('date_of_birth', $('#selectedModalcandidateDOB').val());
    formData.append('visa_type', $('#VisaType').val());
    formData.append('candidate_type', 'package');
    formData.append('trial_start_date', $('#trialStartDate').val());
    formData.append('trial_end_date', $('#trialEndDate').val());
    formData.append('number_of_days', $('#number_of_days').val());
    formData.append('office_notes', $('#officePaymentNotes').val() || '');

    const govtTotal = num($('#govtTotalAmount').val());
    const govtReceived = num($('#govtReceivedAmount').val());
    const govtMethod = ($('#govtPaymentMethod').val() || '').toLowerCase();
    const govtProof = $('#govtPaymentProof').val();

    if (govtTotal > 0 || govtReceived > 0) {
      if (govtReceived > 0 && govtMethod !== 'cash' && !govtProof) { btn.prop('disabled', false); toastr.error('Govt payment proof is required when received amount is greater than 0 and payment method is not Cash.'); return; }
      formData.append('govt_total_amount', $('#govtTotalAmount').val());
      formData.append('govt_received_amount', $('#govtReceivedAmount').val());
      formData.append('govt_remaining_amount', $('#govtRemainingAmount').val());
      formData.append('govt_vat_amount', $('#govtVatAmount').val());
      formData.append('govt_net_amount', $('#govtNetAmount').val());
      formData.append('govt_payment_method', $('#govtPaymentMethod').val());
      formData.append('govt_payment_notes', $('#govtPaymentNotes').val() || '');
      formData.append('govt_service_name', $('#govtServiceSelect').val() || '');
      if ($('#govtPaymentProof')[0].files[0]) formData.append('govt_payment_proof', $('#govtPaymentProof')[0].files[0]);
    }

    if ($('#medicalCertificate')[0].files[0]) formData.append('medical_certificate', $('#medicalCertificate')[0].files[0]);

    $.ajax({
      url: '<?php echo e(route("agreements.insideagreement")); ?>',
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf() },
      data: formData,
      processData: false,
      contentType: false,
      success: (response) => {
        btn.prop('disabled', false);
        if (response && response.status === 'success') {
          toastr.success(response.message);
          $('#agreement_form')[0].reset();
          modalHide('trialModal');
          setTimeout(() => location.reload(), 1200);
        } else {
          toastr.error((response && response.message) || 'Failed.');
        }
      },
      error: (xhr) => {
        btn.prop('disabled', false);
        const resp = xhr.responseJSON;
        if (resp && resp.errors) Object.entries(resp.errors).forEach(([k, errs]) => errs.forEach(err => toastr.error(`${k}: ${err}`)));
        else if (resp && resp.message) toastr.error(resp.message);
        else toastr.error('An unexpected error occurred.');
      }
    });
  });

  const DueDate = { minDays: 7, blockedDow: [0], selector: '#im_refund_due_date' };
  const pad2 = (n) => String(n).padStart(2,'0');
  const ymd = (d) => `${d.getFullYear()}-${pad2(d.getMonth()+1)}-${pad2(d.getDate())}`;
  const midnight = () => { const d=new Date(); d.setHours(0,0,0,0); return d; };
  const addDays = (base, days) => { const d=new Date(base.getTime()); d.setDate(d.getDate()+days); return d; };
  const parseYmd = (s) => {
    const m=/^(\d{4})-(\d{2})-(\d{2})$/.exec(String(s||'').trim());
    if(!m) return null;
    const d=new Date(Number(m[1]),Number(m[2])-1,Number(m[3]),0,0,0,0);
    return Number.isFinite(d.getTime()) ? d : null;
  };
  const minDue = () => addDays(midnight(), DueDate.minDays);

  const applyDueConstraints = () => {
    const min = minDue();
    const minStr = ymd(min);
    const $i = $(DueDate.selector);
    $i.attr('min', minStr);
    const cur = $i.val();
    if (!cur) return;
    const d = parseYmd(cur);
    if (!d) { $i.val(''); return; }
    if (d.getTime() < min.getTime() || DueDate.blockedDow.includes(d.getDay())) $i.val('');
  };

  const validateDue = (toast=true) => {
    const val = $(DueDate.selector).val();
    if (!val) { if (toast) toastr.error('Please select refund due date.'); return false; }
    const d = parseYmd(val);
    if (!d) { if (toast) toastr.error('Invalid refund due date.'); $(DueDate.selector).val(''); return false; }
    const min = minDue();
    if (d.getTime() < min.getTime()) { if (toast) toastr.error(`Refund due date must be at least ${DueDate.minDays} days from today.`); $(DueDate.selector).val(''); return false; }
    if (DueDate.blockedDow.includes(d.getDay())) { if (toast) toastr.error('Sunday is not allowed. Please choose another date.'); $(DueDate.selector).val(''); return false; }
    return true;
  };

  const setDecisionUi = () => {
    const isRefund = $('#im_decision_refund').prop('checked');
    $('#im_balance_label').text(isRefund ? 'Refund Balance' : 'Replacement Balance');
    $('#im_due_label').text(isRefund ? 'Refund Due Date' : 'Replacement Due Date');
  };

  const enforceSingleDecision = (changed) => {
    const $r = $('#im_decision_refund');
    const $p = $('#im_decision_replacement');
    if (changed === 'refund') { if ($r.prop('checked')) $p.prop('checked', false); else $r.prop('checked', true); }
    else { if ($p.prop('checked')) $r.prop('checked', false); else $p.prop('checked', true); }
    setDecisionUi();
  };

  const setBalance = () => {
    const received = num($('#im_received_raw').val());
    let oc = num($('#im_office_charges').val());
    if (oc < 0) oc = 0;
    if (oc > received) oc = received;
    $('#im_office_charges').val(fix2(oc));
    $('#im_balance_amount').val(fix2(Math.max(received - oc, 0)));
  };

  const resetIncident = () => {
    $('#incidentForm')[0].reset();
    $('#im_refund_type').val('package');
    $('#im_refund_type_label').val('Inside - All');
    $('#im_incident_category').val('Inside - All');
    $('#im_decision_refund').prop('checked', true);
    $('#im_decision_replacement').prop('checked', false);
    $('#im_office_charges').val('0');
    $('#im_balance_amount').val('0.00');
    $('#im_received_raw').val('0');
    $('#im_other_reason_wrap').hide();
    $('#im_expiry_wrap').hide();
    $('#im_no_agreement').addClass('d-none');
    $('#im_agreement_card').removeClass('d-none');
    setDecisionUi();
    setBalance();
    applyDueConstraints();
  };

  const applyReasonUi = () => {
    const r = String($('#im_incident_reason').val() || '').toUpperCase();
    $('#im_other_reason_wrap').toggle(r === 'OTHER');
    const showExpiry = (r === 'MOHRE COMPLAIN');
    $('#im_expiry_wrap').toggle(showExpiry);
    if (!showExpiry) $('#im_incident_expiry_date').val('');
    if (r !== 'OTHER') $('#im_other_reason').val('');
  };

  const fillIncident = (packageId, cd) => {
    const ag = cd.agreement || null;

    $('#im_candidate_id').val(cd.candidate_id || packageId);
    $('#im_candidate_reference_no').val(cd.candidate_reference_no || '');
    $('#im_candidate_ref_no').val(cd.candidate_ref_no || '');
    $('#im_foreign_partner').val(cd.foreign_partner || '');
    $('#im_candidate_nationality').val(cd.candidate_nationality || '');
    $('#im_candidate_passport_number').val(cd.candidate_passport_number || '');
    $('#im_candidate_passport_expiry').val(cd.candidate_passport_expiry || '');
    $('#im_candidate_dob').val(cd.candidate_dob || '');

    $('#im_candidate_name').val(cd.candidate_name || '');
    $('#im_sponsor_name').val(cd.sponsor_name || cd.employer_name || '');
    $('#im_sponsor_qid').val(cd.sponsor_qid || '');
    $('#im_incident_category').val(cd.refund_type_label || 'Inside - All');
    $('#im_refund_type').val(cd.refund_type || 'package');
    $('#im_refund_type_label').val(cd.refund_type_label || 'Inside - All');

    const total = num(cd.total_amount);
    const received = num(cd.received_amount);

    $('#im_total_amount').val(fix2(total));
    $('#im_received_amount').val(fix2(received));
    $('#im_received_raw').val(String(received));

    const hasAgreement = !!(ag && (ag.id || ag.reference_no));

    if (!hasAgreement) {
      $('#im_no_agreement').removeClass('d-none');
      $('#im_agreement_card').addClass('d-none');
      $('#im_total_amount').val(fix2(0));
      $('#im_received_amount').val(fix2(0));
      $('#im_received_raw').val('0');
      $('#im_office_charges').val('0');
      setBalance();
      applyDueConstraints();
      modalShow('incidentModal');
      return;
    }

    $('#im_no_agreement').addClass('d-none');
    $('#im_agreement_card').removeClass('d-none');

    $('#im_agreement_id').val(ag.id || '');
    $('#im_agreement_reference_no').val(ag.reference_no || '');
    $('#im_agreement_type').val(ag.agreement_type || '');
    $('#im_agreement_client_id').val(ag.client_id || '');

    $('#im_agreement_reference_no_text').val(ag.reference_no || '');
    $('#im_contract_start_date').val(ag.contract_start_date || '');
    $('#im_contract_end_date').val(ag.contract_end_date || '');

    setBalance();
    applyDueConstraints();
    modalShow('incidentModal');
  };

  $('#im_decision_refund').on('change', () => enforceSingleDecision('refund'));
  $('#im_decision_replacement').on('change', () => enforceSingleDecision('replacement'));
  $('#im_office_charges').on('input', setBalance);
  $('#im_incident_reason').on('change', applyReasonUi);
  $(document).on('change input', DueDate.selector, () => validateDue(true));
  $('#incidentModal').on('shown.bs.modal', applyDueConstraints);

  $('#im_save_btn').on('click', () => {
    const reason = $('#im_incident_reason').val();
    if (!reason) return toastr.error('Please select reason.');
    if (String(reason).toUpperCase() === 'OTHER' && !String($('#im_other_reason').val() || '').trim()) return toastr.error('Please specify reason.');
    if (String(reason).toUpperCase() === 'MOHRE COMPLAIN' && !$('#im_incident_expiry_date').val()) return toastr.error('Please select expiry date of incident.');
    if (!validateDue(true)) return;

    const proof = $('#im_proof').get(0)?.files?.length || 0;
    if (!proof) return toastr.error('Please upload incident proof.');

    const formData = new FormData(document.getElementById('incidentForm'));
    const isRefund = $('#im_decision_refund').prop('checked');
    formData.set('customer_decision', isRefund ? 'Refund' : 'Replacement');
    formData.set('balance_amount', $('#im_balance_amount').val());

    $.ajax({
      url: "<?php echo e(route('package.incidentSave')); ?>",
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf() },
      data: formData,
      processData: false,
      contentType: false,
      success: (res) => {
        if (res && res.success === false) return toastr.error(res.message || 'Failed to save incident.');
        toastr.success((res && res.message) || 'Incident saved successfully!');
        modalHide('incidentModal');
        location.reload();
      },
      error: (xhr) => {
        const resp = xhr.responseJSON;
        if (resp && resp.errors) Object.values(resp.errors).flat().forEach(m => toastr.error(m));
        else toastr.error(resp?.message || 'Failed to save incident. Please check your inputs and try again.');
      }
    });
  });

  let lastStatusSelect = null;

  const renderInvoices = (rows) => {
    const $tb = $('#ct_invoices_tbody');
    if (!Array.isArray(rows) || rows.length === 0) { $tb.html('<tr><td colspan="6" class="text-center text-muted">No invoice data.</td></tr>'); return; }
    $tb.html(rows.map(r => {
      const invNo = String(r.invoice_number ?? r.invoice_no ?? r.number ?? r.invoice_id ?? '');
      const date = String(r.invoice_date ?? r.date ?? '');
      const total = fix2(num(r.total_amount ?? r.total));
      const paid = fix2(num(r.received_amount ?? r.paid_amount ?? r.paid));
      const rem = fix2(Math.max(num(r.total_amount ?? r.total) - num(r.received_amount ?? r.paid_amount ?? r.paid), 0));
      const st = String(r.status ?? '');
      return `<tr><td>${invNo}</td><td>${date}</td><td class="text-end">${total}</td><td class="text-end">${paid}</td><td class="text-end">${rem}</td><td>${st}</td></tr>`;
    }).join(''));
  };

  const setContractProofNote = () => {
    const method = ($('#ct_payment_method').val() || '').toLowerCase();
    $('#ct_proof_note').text(method && method !== 'cash' ? 'Payment proof is required for non-cash payments.' : '');
  };

  const recomputeContractTotals = () => {
    const outstanding = num($('#ct_outstanding_total_raw').val());
    let pay = num($('#ct_pay_amount').val());
    if (pay < 0) pay = 0;
    if (pay > outstanding) { toastr.error('Pay Now cannot exceed Outstanding Total.'); pay = outstanding; }
    $('#ct_pay_amount').val(fix2(pay));
    $('#ct_remaining_after').val(fix2(outstanding - pay));
    setContractProofNote();
  };

  $(document).on('input', '#ct_pay_amount', function () { sanitizeNumberInput(this); recomputeContractTotals(); });
  $(document).on('change', '#ct_payment_method', setContractProofNote);

  $('#contractedModal').on('hidden.bs.modal', function () {
    $('#contractedForm')[0].reset();
    $('#ct_invoices_tbody').html('<tr><td colspan="6" class="text-center text-muted">No invoice data.</td></tr>');
    $('#ct_outstanding_total_raw').val('0');
    $('#ct_proof_note').text('');
    if (lastStatusSelect) { lastStatusSelect.value = lastStatusSelect.dataset.original; lastStatusSelect = null; }
  });

  const fetchContractedDataByPassport = (passportNo, packageId) => {
    if (!passportNo) { toastr.error('Passport number not found.'); if (lastStatusSelect) lastStatusSelect.value = lastStatusSelect.dataset.original; return; }
    $.ajax({
      url: '<?php echo e(route("packages.office-contracted")); ?>',
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf() },
      dataType: 'json',
      data: { passport_no: passportNo, package_id: packageId },
      success: (res) => {
        if (!res || !res.success) { toastr.error((res && res.message) || 'Failed to load contract conversion data.'); if (lastStatusSelect) lastStatusSelect.value = lastStatusSelect.dataset.original; return; }

        const d = res.data || {};
        const c = d.candidate || {};
        const invoices = d.invoices || [];

        const cn = c.cn_number || c.CN_Number || c.cn || '';
        const candidateId = c.candidate_id || c.id || '';

        $('#ct_package_id').val(packageId || '');
        $('#ct_candidate_id').val(candidateId);
        $('#ct_cn').val(cn);
        $('#ct_passport_hidden').val(passportNo);

        $('#ct_cn_view').val(cn);
        $('#ct_candidate_name').val(c.candidate_name || '');
        $('#ct_passport_no').val(passportNo);

        renderInvoices(invoices);

        const outstanding = num(d.outstanding_total);
        $('#ct_outstanding_total').val(fix2(outstanding));
        $('#ct_outstanding_total_raw').val(String(outstanding));

        $('#ct_pay_amount').val('0');
        $('#ct_payment_method').val('');
        $('#ct_payment_proof').val('');
        $('#ct_comments').val('');

        recomputeContractTotals();
        modalShow('contractedModal');
      },
      error: (xhr) => {
        const j = xhr.responseJSON;
        toastr.error((j && j.message) || 'Error loading contract conversion data.');
        if (lastStatusSelect) lastStatusSelect.value = lastStatusSelect.dataset.original;
      }
    });
  };

  $('#contractedForm').on('submit', function (e) {
    e.preventDefault();
    toastr.clear();

    const packageId = $('#ct_package_id').val();
    const candidateId = $('#ct_candidate_id').val();
    const passportNo = $('#ct_passport_hidden').val();
    const outstanding = num($('#ct_outstanding_total_raw').val());
    const pay = num($('#ct_pay_amount').val());
    const method = $('#ct_payment_method').val();
    const proof = $('#ct_payment_proof')[0].files.length > 0;

    if (!passportNo) return toastr.error('Passport number is required.');
    if (!candidateId) return toastr.error('Candidate is required.');
    if (!method) return toastr.error('Payment method is required.');
    if (pay < 0) return toastr.error('Pay Now cannot be negative.');
    if (pay > outstanding) return toastr.error('Pay Now cannot exceed Outstanding Total.');
    if (String(method).toLowerCase() !== 'cash' && !proof) return toastr.error('Payment proof is required for non-cash payments.');

    const btn = $('#ct_save_btn');
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

    const fd = new FormData(this);
    fd.set('passport_no', passportNo);
    if (packageId) fd.set('package_id', packageId);
    fd.set('outstanding_total', fix2(outstanding));
    fd.set('pay_amount', fix2(pay));
    fd.set('remaining_after', fix2(outstanding - pay));

    $.ajax({
      url: '<?php echo e(route("packages.office-contracted.save")); ?>',
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf() },
      data: fd,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: (res) => {
        if (res && res.success) { toastr.success(res.message || 'Converted successfully.'); modalHide('contractedModal'); setTimeout(() => location.reload(), 1200); return; }
        if (res && res.errors) { Object.values(res.errors).flat().forEach(m => toastr.error(m)); return; }
        toastr.error((res && res.message) || 'Failed to save conversion.');
      },
      error: (xhr) => {
        const j = xhr.responseJSON;
        if (j && j.errors) Object.values(j.errors).flat().forEach(m => toastr.error(m));
        else if (j && j.message) toastr.error(j.message);
        else toastr.error('Error saving conversion.');
      },
      complete: () => { btn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Conversion'); }
    });
  });

  const updateStatus = (packageId, statusId, selectEl) => {
    const url = "<?php echo e(route('packages.update-status-inside', ['packageId' => ':packageId'])); ?>".replace(':packageId', packageId);
    $.ajax({
      url,
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf() },
      data: { status_id: statusId },
      dataType: 'json',
      success: (res) => {
        if (!res || !res.success) { toastr.error((res && res.message) || 'Failed to update status.'); if (selectEl) selectEl.value = selectEl.dataset.original; return; }

        if (res.action === 'open_modal' && String(res.modal || '') === 'trialModal') {
          const d = res.candidateDetails || {};
          $('#selectedModalcandidateName').val(d.candidate_name || '');
          $('#selectedModalcandidateId').val(d.candidate_id || '');
          $('#selectedModalreferenceNo').val(d.candidate_reference_no || '');
          $('#selectedModalrefNo').val(d.candidate_ref_no || '');
          $('#selectedModalforeignPartner').val(d.foreign_partner || '');
          $('#selectedModalcandiateNationality').val(d.candidate_nationality || '');
          $('#selectedModalcandidatePassportNumber').val(d.candidate_passport_number || '');
          $('#selectedModalcandidatePassportExpiry').val(d.candidate_passport_expiry || '');
          $('#selectedModalcandidateDOB').val(d.candidate_dob || '');

          const $client = $('#clientDropdown');
          if (Array.isArray(res.clients)) {
            $client.empty().append('<option value=""></option>');
            res.clients.forEach(c => {
              const name = [c.first_name, c.last_name].filter(Boolean).join(' ').trim();
              $client.append(`<option value="${c.id}">${name || ('Client #' + c.id)}</option>`);
            });
          }

          if ($client.data('select2')) $client.select2('destroy');
          $client.select2({ width:'100%', dropdownParent: $('#trialModal'), placeholder:'Select Client', allowClear:true, minimumResultsForSearch:0 });

          modalShow('trialModal');
          return;
        }

        if (res.action === 'open_modal' && String(res.modal || '') === 'incidentModal') {
          resetIncident();
          if (res.candidateDetails) fillIncident(packageId, res.candidateDetails);
          else toastr.error('Incident data not found.');
          return;
        }

        toastr.success(res.message || 'Status has been updated successfully!');
        location.reload();
      },
      error: () => {
        toastr.error('An error occurred. Please try again.');
        if (selectEl) selectEl.value = selectEl.dataset.original;
      }
    });
  };

  $(document).on('change', '.js-status-select', function () {
    const selectEl = this;
    const packageId = $(this).data('package-id');
    const prevVal = String(selectEl.dataset.original ?? '');
    const newVal = String(selectEl.value ?? '');
    const canConvert = String(selectEl.dataset.canConvert || '0') === '1';

    const $row = $(`#packagesTable tbody tr[data-package-id="${packageId}"]`);
    const candidateName = ($row.data('candidate') || '').toString() || 'Candidate';

    if (newVal === 'contracted' && !canConvert) { toastr.error('Convert to Contract is allowed only when category is New Arrival.'); selectEl.value = prevVal; return; }

    Swal.fire({
      title: `Change action for ${candidateName}?`,
      text: newVal === 'contracted' ? 'Convert to Contract?' : `Set status to "${selectEl.options[selectEl.selectedIndex].text}"?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#dc3545',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    }).then(r => {
      if (!r.isConfirmed) { selectEl.value = prevVal; return; }
      closeAllDropdowns();

      if (newVal === 'contracted') {
        lastStatusSelect = selectEl;
        const passportNo = String($row.data('passport') || '').trim().toUpperCase();
        fetchContractedDataByPassport(passportNo, packageId);
        return;
      }

      const statusId = parseInt(newVal, 10);
      if (Number.isNaN(statusId)) { toastr.error('Invalid status selected.'); selectEl.value = prevVal; return; }
      updateStatus(packageId, statusId, selectEl);
    });
  });

  const ExpiryLive = {
    finePerDay: 50,
    warnDays: 7,
    popupDelayMs: 5000,
    snoozeMs: 3600000,
    storageKey: 'expiry_live_snooze_v1',
    rows: [],
    popupTimer: null,
    timer: null,
    snooze: {}
  };

  const parseYmdUtc = (s) => {
    const m=/^(\d{4})-(\d{2})-(\d{2})$/.exec(String(s||'').trim());
    if(!m) return null;
    return Date.UTC(Number(m[1]), Number(m[2]) - 1, Number(m[3]), 0,0,0,0);
  };

  const diffDaysFloor = (aUtc, bUtc) => Math.floor((aUtc - bUtc) / 86400000);
  const untilDaysCeil = (expUtc, nowUtc) => Math.ceil((expUtc - nowUtc) / 86400000);

  const loadSnooze = () => {
    try {
      const raw = localStorage.getItem(ExpiryLive.storageKey);
      const obj = raw ? JSON.parse(raw) : {};
      ExpiryLive.snooze = (obj && typeof obj === 'object') ? obj : {};
    } catch(e) { ExpiryLive.snooze = {}; }
  };

  const saveSnooze = () => { try { localStorage.setItem(ExpiryLive.storageKey, JSON.stringify(ExpiryLive.snooze || {})); } catch(e){} };
  const snoozeKey = (row) => `${row.dataset.cn || ''}::${row.dataset.packageId || ''}`;
  const isSnoozed = (row, now) => Number.isFinite(ExpiryLive.snooze[snoozeKey(row)]) && ExpiryLive.snooze[snoozeKey(row)] > now;
  const setSnooze = (row, until) => { ExpiryLive.snooze[snoozeKey(row)] = until; saveSnooze(); };

  const computeExpiry = (row, nowMs) => {
    const expUtc = parseYmdUtc(row.dataset.expiry || '');
    const $row = $(row);
    const $ovd = $row.find('.ovd-days');
    const $fine = $row.find('.fine-amt');
    const $due = $row.find('.due-in');
    const $pills = $row.find('.mini-kv .pill');

    $row.removeClass('row-warning row-danger');
    $pills.removeClass('warn dang').addClass('gray');

    if (!expUtc) { $ovd.text('0'); $fine.text('0'); $due.text('N/A'); return { status:'none', expUtc:null, daysUntil:null, ovd:0, fine:0 }; }

    const ovd = Math.max(0, diffDaysFloor(nowMs, expUtc));
    const fine = ovd * ExpiryLive.finePerDay;
    const until = untilDaysCeil(expUtc, nowMs);

    $ovd.text(String(ovd));
    $fine.text(moneyInt(fine));

    if (until > 0) {
      $due.text(`${until} day${until === 1 ? '' : 's'}`);
      if (until <= ExpiryLive.warnDays) { $row.addClass('row-warning'); $pills.removeClass('gray').addClass('warn'); return { status:'warning', expUtc, daysUntil:until, ovd, fine }; }
      return { status:'ok', expUtc, daysUntil:until, ovd, fine };
    }

    $due.text('EXPIRED');
    $row.addClass('row-danger');
    $pills.removeClass('gray').addClass('dang');
    return { status:'danger', expUtc, daysUntil:until, ovd, fine };
  };

  const refreshExpiryAll = () => {
    const now = Date.now();
    const urgent = [];
    for (const row of ExpiryLive.rows) {
      const r = computeExpiry(row, now);
      if (r.status === 'danger' || r.status === 'warning') urgent.push({ row, r });
    }
    return urgent;
  };

  const urgentHtml = (items) => {
    const totalFine = items.reduce((s,it)=>s + (Number.isFinite(it?.r?.fine) ? it.r.fine : 0), 0);

    const rows = items.slice(0,10).map(({row,r}) => {
      const cn = row.dataset.cn || '';
      const pid = row.dataset.packageId || '';
      const cand = row.dataset.candidate || '';
      const nat = row.dataset.nationality || '';
      const visa = row.dataset.visa || '';
      const exp = row.dataset.expiryHuman || row.dataset.expiry || '';
      const fineAed = aed(r.fine);
      const due = r.status === 'danger' ? 'EXPIRED' : `${r.daysUntil} day${r.daysUntil === 1 ? '' : 's'}`;
      const badge = r.status === 'danger'
        ? '<span style="display:inline-block;background:#dc3545;color:#fff;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:700">EXPIRED</span>'
        : '<span style="display:inline-block;background:#ffc107;color:#212529;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:700">NEAR</span>';

      return `
        <tr>
          <td style="padding:8px 10px;border-bottom:1px solid #eee;font-weight:800">${cn}</td>
          <td style="padding:8px 10px;border-bottom:1px solid #eee;font-weight:700">${cand}</td>
          <td style="padding:8px 10px;border-bottom:1px solid #eee">${nat}</td>
          <td style="padding:8px 10px;border-bottom:1px solid #eee">${visa}</td>
          <td style="padding:8px 10px;border-bottom:1px solid #eee">${exp}</td>
          <td style="padding:8px 10px;border-bottom:1px solid #eee;text-align:center">${badge}</td>
          <td style="padding:8px 10px;border-bottom:1px solid #eee;text-align:center;font-weight:700">${due}</td>
          <td style="padding:8px 10px;border-bottom:1px solid #eee;text-align:center;font-weight:800">${r.ovd}</td>
          <td style="padding:8px 10px;border-bottom:1px solid #eee;text-align:center;font-weight:900">${fineAed}</td>
          <td style="padding:8px 10px;border-bottom:1px solid #eee;text-align:center">
            <button type="button" class="btn btn-sm btn-primary js-open-edit-from-alert" data-package-id="${pid}" style="font-size:10px;padding:4px 8px;border-radius:999px">Open</button>
          </td>
        </tr>
      `;
    }).join('');

    const more = items.length > 10 ? `<div class="small text-muted mt-2">Showing 10 of ${items.length} urgent candidates.</div>` : '';

    return `
      <div style="text-align:left">
        <div style="font-weight:800;font-size:13px;margin-bottom:10px">Expiry / Fine Alert</div>
        <div class="small text-muted" style="margin-bottom:10px">
          Fine calculated live: <b>${ExpiryLive.finePerDay}</b> per day after expiry.
          <span style="float:right;font-weight:800">${aed(totalFine)}</span>
        </div>
        <div style="max-height:320px;overflow:auto;background:#fff;border:1px solid #eee;border-radius:10px">
          <table style="width:100%;border-collapse:collapse;font-size:11px">
            <thead>
              <tr style="background:linear-gradient(to right,#007bff,#00c6ff);color:#fff">
                <th style="padding:8px 10px;text-align:left">CN#</th>
                <th style="padding:8px 10px;text-align:left">Candidate</th>
                <th style="padding:8px 10px;text-align:left">Nat.</th>
                <th style="padding:8px 10px;text-align:left">Visa</th>
                <th style="padding:8px 10px;text-align:left">Expiry</th>
                <th style="padding:8px 10px;text-align:center">Flag</th>
                <th style="padding:8px 10px;text-align:center">Due</th>
                <th style="padding:8px 10px;text-align:center">OVD</th>
                <th style="padding:8px 10px;text-align:center">Fine</th>
                <th style="padding:8px 10px;text-align:center">Action</th>
              </tr>
            </thead>
            <tbody>${rows}</tbody>
          </table>
        </div>
        ${more}
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:12px">
          <button type="button" class="btn btn-sm btn-outline-secondary" id="expiryAlertSnoozeBtn">Snooze 1 hour</button>
          <button type="button" class="btn btn-sm btn-primary" id="expiryAlertCloseBtn">Close</button>
        </div>
      </div>
    `;
  };

  const showExpiryPopup = (urgent) => {
    if (!urgent || urgent.length === 0) return;
    const now = Date.now();
    const items = urgent.filter(({row}) => !isSnoozed(row, now));
    if (items.length === 0) return;

    Swal.fire({
      html: urgentHtml(items),
      width: '900px',
      showConfirmButton: false,
      allowOutsideClick: true,
      didOpen: () => {
        const $p = $(Swal.getPopup());
        $p.find('#expiryAlertCloseBtn').on('click', () => Swal.close());
        $p.find('#expiryAlertSnoozeBtn').on('click', () => {
          const until = Date.now() + ExpiryLive.snoozeMs;
          items.forEach(({row}) => setSnooze(row, until));
          toastr.success('Snoozed for 1 hour.');
          Swal.close();
        });
        $p.find('.js-open-edit-from-alert').on('click', function () {
          const packageId = $(this).data('package-id');
          if (!packageId) return;
          Swal.close();
          const $row = $(`#packagesTable tbody tr[data-package-id="${packageId}"]`);
          const $edit = $row.find('.js-edit-office');
          if ($edit.length) $edit.trigger('click');
        });
      }
    });
  };

  const initExpiry = () => {
    loadSnooze();
    ExpiryLive.rows = Array.from(document.querySelectorAll('#packagesTable tbody tr[data-expiry]'));
    refreshExpiryAll();

    clearTimeout(ExpiryLive.popupTimer);
    ExpiryLive.popupTimer = setTimeout(() => {
      const urgent = refreshExpiryAll();
      if (urgent.length) showExpiryPopup(urgent);
    }, ExpiryLive.popupDelayMs);

    clearInterval(ExpiryLive.timer);
    ExpiryLive.timer = setInterval(refreshExpiryAll, 60000);
  };

  $(document).ready(initExpiry);
})();
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/partials/office_table.blade.php ENDPATH**/ ?>