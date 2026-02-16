<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
  .table th,.table td{vertical-align:middle}
  .nav-tabs .nav-link{transition:background-color .2s;color:#495057;font-size:12px}
  .nav-tabs .nav-link:hover{background-color:#f8f9fa}
  .nav-tabs .nav-link.active{background-color:#007bff;color:#fff}
  .nav-tabs .nav-link i{margin-right:5px}
  .btn{transition:background-color .2s,color .2s}
  .btn:hover{background-color:#007bff;color:#fff}
  .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:normal}
  .pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}
  .muted-text{color:#6c757d;font-size:12px}
  .pagination{display:flex;justify-content:center;align-items:center;margin:0}
  .pagination .page-item{margin:0 .1rem}
  .pagination .page-link{border-radius:.25rem;padding:.5rem .75rem;color:#007bff;background:#fff;border:1px solid #007bff;transition:background-color .2s,color .2s}
  .pagination .page-link:hover{background-color:#007bff;color:#fff}
  .pagination .page-item.active .page-link{background-color:#007bff;color:#fff;border:1px solid #007bff}
  .pagination .page-item.disabled .page-link{color:#6c757d;background:#fff;border:1px solid #6c757d;cursor:not-allowed}
  .btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:none}
  .btn-success{background:linear-gradient(to right,#28a745,#20c997);color:#fff;border:none}
  .form-control{border-radius:6px;height:42px}
  .section{background-color:#fff;border-radius:5px;padding:10px;position:relative}
  .custom-panel{position:absolute;right:0;top:100%;width:360px;z-index:1060;display:none}
  .custom-panel .form-control,.custom-panel .form-select{font-size:12px;border-radius:4px;height:30px}
  .btn-close{width:20px;height:20px;border:2px solid #1bd2ff;background:#06b0c9;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;padding:0;line-height:0;cursor:pointer}
  .btn-close::before{content:"\f00d";font-family:"Font Awesome 6 Free";font-weight:900;font-size:10px;color:#fff}
  .btn-close:hover{background:#04a1b8;border-color:#27dbff}
  .table-loader{position:absolute;inset:0;z-index:1050;background:rgba(255,255,255,.78);display:none;align-items:center;justify-content:center;border-radius:6px}
  .table-loader.show{display:flex}
  .empty-state{border:1px dashed #cfd8dc;border-radius:10px;padding:22px;text-align:center;background:linear-gradient(to right,#f6fbff,#fbf7ff)}
  .empty-state .icon{width:44px;height:44px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:#e7f5ff;color:#007bff;margin-bottom:10px}
  .empty-state .title{font-size:14px;font-weight:600;margin:0;color:#343a40}
  .empty-state .sub{font-size:12px;margin:6px 0 0;color:#6c757d}
  .input-group .form-control{height:36px;border-top-right-radius:0;border-bottom-right-radius:0}
  .input-group .btn{height:36px;border-top-left-radius:0;border-bottom-left-radius:0}
  @media (max-width:640px){.custom-panel{width:100%}}
</style>

<?php
  $tabsConfig = [
    'all'           => 'ALL',
    'office'        => 'OFFICE',
    'trial'         => 'CONTRACTED',
    'invoices'      => 'INVOICES',
    'receipt'       => 'RECEIPT',
    'ins_invoices'  => 'INSTALMENTS',
    'refund'        => 'REFUND',
    'payroll'       => 'PAYROLL',
    'incident'      => 'INCIDENT',
    'outside'       => 'OUTSIDE',
    'boa'           => 'BOA',
    'rvo'           => 'RVO',
    'replacements'  => 'REP.'
  ];
  $tabIcons = [
    'all' => 'people-fill',
    'office' => 'building',
    'trial' => 'file-earmark-text-fill',
    'invoices' => 'receipt',
    'receipt' => 'file-earmark-check-fill',
    'ins_invoices' => 'receipt',
    'refund' => 'arrow-counterclockwise',
    'payroll' => 'cash-stack',
    'incident' => 'exclamation-triangle-fill',
    'outside' => 'globe',
    'boa' => 'bank',
    'rvo' => 'person-badge-fill',
    'replacements' => 'arrow-repeat',
  ];
  $tabsFirstTen = array_slice($tabsConfig, 0, 10, true);
  $tabsExtra = array_slice($tabsConfig, 10, null, true);
  $activePkg = $activePackage ?? request('package');
?>

<main id="main" class="main">
  <section class="section" data-package="<?php echo e($activePkg); ?>">
    <div id="tableLoader" class="table-loader" aria-hidden="true">
      <div class="text-center">
        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
        <div class="mt-2 muted-text">Loading…</div>
      </div>
    </div>

    <div class="row mb-2">
      <div class="col-lg-4">
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
          <input id="global_search" type="text" class="form-control" placeholder="Search by Name, reference no and passport no">
        </div>
      </div>

      <div class="col-lg-8 d-flex justify-content-end align-items-center position-relative">
        <div id="trialStatusDropdown" class="dropdown me-2 d-none">
          <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Status</button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" data-value="" href="#">All Statuses</a></li>
            <li><a class="dropdown-item" data-value="1" href="#">Pending</a></li>
            <li><a class="dropdown-item" data-value="2" href="#">Active</a></li>
            <li><a class="dropdown-item" data-value="3" href="#">Exceeded</a></li>
            <li><a class="dropdown-item" data-value="4" href="#">Cancelled</a></li>
            <li><a class="dropdown-item" data-value="5" href="#">Contracted</a></li>
            <li><a class="dropdown-item" data-value="6" href="#">Rejected</a></li>
          </ul>
        </div>

        <button id="filterBtn" class="btn btn-primary btn-sm me-2"><i class="fas fa-filter"></i> Filter</button>
        <button id="reloadBtn" class="btn btn-secondary btn-sm me-2"><i class="fas fa-sync-alt"></i> Reload</button>
        <button id="resetBtn" class="btn btn-warning btn-sm me-2" style="display:none"><i class="fa-solid fa-rotate-left"></i></button>

        <?php if(auth()->user()->role === 'Archive Clerk' || auth()->user()->role === 'Admin'): ?>
          <a href="<?php echo e(route('employees.create')); ?>?package=<?php echo e($activePkg); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
        <?php endif; ?>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <ul class="nav nav-tabs" id="statusTab">
          <?php $__currentLoopData = $tabsFirstTen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item">
              <button class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>" data-tab="<?php echo e($tab); ?>" onclick="switchTab('<?php echo e($tab); ?>', this)">
                <i class="bi bi-<?php echo e($tabIcons[$tab] ?? 'circle'); ?>"></i>
                <?php echo e($label); ?>

                <span id="badge_count_<?php echo e($tab); ?>" class="badge bg-info"><?php echo e($counts[$tab] ?? 0); ?></span>
              </button>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          <?php if(count($tabsExtra) > 0): ?>
            <li class="nav-item" id="tabsToggleItem">
              <button type="button" id="toggleTabsBtn" class="nav-link" aria-label="Show more tabs">
                <i class="fa-solid fa-plus"></i>
              </button>
            </li>

            <?php $__currentLoopData = $tabsExtra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="nav-item extra-tab d-none">
                <button class="nav-link" data-tab="<?php echo e($tab); ?>" onclick="switchTab('<?php echo e($tab); ?>', this)">
                  <i class="bi bi-<?php echo e($tabIcons[$tab] ?? 'circle'); ?>"></i>
                  <?php echo e($label); ?>

                  <span id="badge_count_<?php echo e($tab); ?>" class="badge bg-info"><?php echo e($counts[$tab] ?? 0); ?></span>
                </button>
              </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <div class="row filter-row position-relative">
      <div class="col-lg-12">
        <div id="filterPanel" class="card p-3 shadow-sm custom-panel">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="m-0" id="panelTitle"></h6>
            <button type="button" class="btn-close" onclick="$('#filterPanel').hide()"></button>
          </div>

          <form id="filterForm" class="row g-2">
            <input type="hidden" id="base_package" value="<?php echo e($activePkg); ?>">

            <div class="col-12 mb-2 filter trial">
              <select id="date_preset_trial" class="form-control">
                <option value="">Date Filter</option>
                <option value="today">TODAY</option>
                <option value="this_week">THIS WEEK</option>
                <option value="this_month">THIS MONTH</option>
                <option value="previous_month">PREVIOUS MONTH</option>
                <option value="this_year">THIS YEAR</option>
                <option value="custom">CUSTOM DATE</option>
              </select>
            </div>
            <div class="col-6 mb-2 filter trial trial-date-range"><input id="trial_date_from" class="form-control" type="date"></div>
            <div class="col-6 mb-2 filter trial trial-date-range"><input id="trial_date_to" class="form-control" type="date"></div>

            <div class="col-12 mb-2 filter rvo invoices receipt refund ins_invoices">
              <select id="date_preset_rvo" class="form-control">
                <option value="">Date Filter</option>
                <option value="today">TODAY</option>
                <option value="this_week">THIS WEEK</option>
                <option value="this_month">THIS MONTH</option>
                <option value="previous_month">PREVIOUS MONTH</option>
                <option value="this_year">THIS YEAR</option>
                <option value="custom">CUSTOM DATE</option>
              </select>
            </div>
            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices rvo-date-range"><input id="rvo_date_from" class="form-control" type="date"></div>
            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices rvo-date-range"><input id="rvo_date_to" class="form-control" type="date"></div>

            <div class="col-12 mb-2 filter payroll">
              <select id="date_preset_payroll" class="form-control">
                <option value="">Date Filter</option>
                <option value="today">TODAY</option>
                <option value="this_week">THIS WEEK</option>
                <option value="this_month">THIS MONTH</option>
                <option value="previous_month">PREVIOUS MONTH</option>
                <option value="this_year">THIS YEAR</option>
                <option value="custom">CUSTOM DATE</option>
              </select>
            </div>
            <div class="col-6 mb-2 filter payroll payroll-date-range"><input id="start_date_payroll" class="form-control" type="date"></div>
            <div class="col-6 mb-2 filter payroll payroll-date-range"><input id="end_date_payroll" class="form-control" type="date"></div>

            <div class="col-6 mb-2 filter trial"><input id="con_reference_no" class="form-control" type="text" placeholder="Contract Ref No"></div>

            <div class="col-6 mb-2 filter common"><input id="reference_no" class="form-control" type="text" placeholder="Reference No"></div>
            <div class="col-6 mb-2 filter common"><input id="candidate_name" class="form-control" type="text" placeholder="Employee Name"></div>
            <div class="col-6 mb-2 filter common"><input id="passport_number" class="form-control" type="text" placeholder="Passport No"></div>
            <div class="col-6 mb-2 filter common"><input id="foreign_partner" class="form-control" type="text" placeholder="Foreign Partner"></div>

            <div class="col-6 mb-2 filter common">
              <select id="package" class="form-control">
                <option value="">Package</option>
                <option value="ALL">All</option>
                <option value="PKG-2">PKG-2</option>
                <option value="PKG-3">PKG-3</option>
                <option value="PKG-4">PKG-4</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter common">
              <select id="inside_status" class="form-control">
                <option value="">Current Status</option>
                <option value="1">1 - Office</option>
                <option value="2">2 - Contracted</option>
                <option value="3">3 - Incidented</option>
                <option value="4">4 - Contracted</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter common">
              <select id="nationality" class="form-control">
                <option value="">Nationality</option>
                <option>Ethiopia</option>
                <option>Uganda</option>
                <option>Philippines</option>
                <option>Indonesia</option>
                <option>Sri Lanka</option>
                <option>Myanmar</option>
                <option>India</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter common">
              <select id="visa_stage" name="visa_stage" class="form-control">
                <option value="">Visa Stage</option>
                <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($step->id); ?>"><?php echo e($step->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <div class="col-6 mb-2 filter office">
              <select id="category" class="form-control">
                <option value="">Category</option>
                <option>Unfit</option>
                <option>Sick</option>
                <option>Trial Return</option>
                <option>New Arrival</option>
                <option>RESERVED</option>
                <option>ABSCONDING</option>
                <option>MOHRE COMPLAIN</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter office">
              <select id="arrived_date" class="form-control">
                <option value="">Arrived order</option>
                <option value="asc">Arrived order ASC</option>
                <option value="desc">Arrived order DESC</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter office">
              <select id="expiry" class="form-control">
                <option value="">Expiry Order</option>
                <option value="asc">Expiry Order ASC</option>
                <option value="desc">Expiry Order DESC</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter incident">
              <select id="incident_type" class="form-control">
                <option value="">Incident Type</option>
                <option>RUNAWAY</option>
                <option>REPATRIATION</option>
                <option>UNFIT</option>
                <option>REFUSED</option>
                <option>PSYCHIATRIC</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter boa"><input id="reference_no_boa" class="form-control" type="text" placeholder="Reference No"></div>
            <div class="col-6 mb-2 filter boa"><input id="cl_number_boa" class="form-control" type="text" placeholder="CL Number"></div>
            <div class="col-6 mb-2 filter boa"><input id="cn_number_boa" class="form-control" type="text" placeholder="CN Number"></div>
            <div class="col-6 mb-2 filter boa"><input id="candidate_name_boa" class="form-control" type="text" placeholder="Employee Name"></div>
            <div class="col-6 mb-2 filter boa"><input id="passport_number_boa" class="form-control" type="text" placeholder="Passport No"></div>
            <div class="col-6 mb-2 filter boa"><input id="date_from_boa" class="form-control" type="date"></div>
            <div class="col-6 mb-2 filter boa"><input id="date_to_boa" class="form-control" type="date"></div>

            <div class="col-6 mb-2 filter boa">
              <select id="package_boa" class="form-control">
                <option value="">Package</option>
                <option value="ALL">All</option>
                <option value="PKG-2">PKG-2</option>
                <option value="PKG-3">PKG-3</option>
                <option value="PKG-4">PKG-4</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter boa">
              <select id="status_boa" class="form-control">
                <option value="">Status</option>
                <option value="1">Pending</option>
                <option value="2">Approved</option>
                <option value="3">Hold</option>
                <option value="4">Cancelled</option>
                <option value="5">Completed</option>
                <option value="6">Extended</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices"><input id="reference_no_rvo" class="form-control" type="text" placeholder="Reference No"></div>
            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices"><input id="candidate_name_rvo" class="form-control" type="text" placeholder="Employee Name"></div>
            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices"><input id="customer_name_rvo" class="form-control" type="text" placeholder="Customer Name"></div>
            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices"><input id="cl_number_rvo" class="form-control" type="text" placeholder="CL Number"></div>
            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices"><input id="cn_number_rvo" class="form-control" type="text" placeholder="CN Number"></div>
            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices"><input id="agreement_no_rvo" class="form-control" type="text" placeholder="Agreement No"></div>

            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices">
              <select id="status_rvo" class="form-control">
                <option value="">Status</option>
                <option>Pending</option>
                <option>Unpaid</option>
                <option>Paid</option>
                <option>Partially Paid</option>
                <option>Overdue</option>
                <option>Cancelled</option>
                <option>Hold</option>
                <option>COD</option>
                <option>Replacement</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices">
              <select id="payment_method_rvo" class="form-control">
                <option value="">Payment Method</option>
                <option>Bank Transfer ADIB</option>
                <option>Bank Transfer ADCB</option>
                <option>POS ADCB</option>
                <option>POS ADIB</option>
                <option>POS-ID 60043758</option>
                <option>POS-ID 60045161</option>
                <option>ADIB-19114761</option>
                <option>ADIB-19136783</option>
                <option>Cash</option>
                <option>Cheque</option>
                <option>Replacement</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter rvo invoices receipt refund ins_invoices">
              <select id="package_rvo" class="form-control">
                <option value="">Package</option>
                <option value="ALL">All</option>
                <option value="PKG-2">PKG-2</option>
                <option value="PKG-3">PKG-3</option>
                <option value="PKG-4">PKG-4</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter payroll"><input id="reference_no_payroll" class="form-control" type="text" placeholder="Reference No"></div>
            <div class="col-6 mb-2 filter payroll"><input id="candidate_name_payroll" class="form-control" type="text" placeholder="Employee Name"></div>
            <div class="col-6 mb-2 filter payroll"><input id="passport_number_payroll" class="form-control" type="text" placeholder="Passport No"></div>

            <div class="col-6 mb-2 filter payroll">
              <select id="package_payroll" class="form-control" name="package">
                <option value="">Choose Package</option>
                <option value="ALL">All</option>
                <option value="PKG-2">PKG-2</option>
                <option value="PKG-3">PKG-3</option>
                <option value="PKG-4">PKG-4</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter replacements"><input id="contract_number_replacements" class="form-control" type="text" placeholder="Contract No"></div>
            <div class="col-6 mb-2 filter replacements"><input id="reference_no_replacements" class="form-control" type="text" placeholder="Reference No"></div>
            <div class="col-6 mb-2 filter replacements"><input id="name_replacements" class="form-control" type="text" placeholder="Name"></div>
            <div class="col-6 mb-2 filter replacements"><input id="passport_number_replacements" class="form-control" type="text" placeholder="Passport No"></div>

            <div class="col-6 mb-2 filter replacements">
              <select id="nationality_replacements" class="form-control">
                <option value="">Nationality</option>
                <option>Ethiopia</option>
                <option>Uganda</option>
                <option>Philippines</option>
                <option>Indonesia</option>
                <option>Sri Lanka</option>
                <option>Myanmar</option>
                <option>India</option>
              </select>
            </div>

            <div class="col-6 mb-2 filter replacements"><input id="from_replacements" class="form-control" type="date"></div>
            <div class="col-6 mb-2 filter replacements"><input id="to_replacements" class="form-control" type="date"></div>
          </form>

          <div class="d-flex justify-content-between mt-3">
            <button id="reloadFilters" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i> Reload</button>
            <div class="d-flex gap-2">
              <button id="exportExcelFilters" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Excel</button>
              <button id="exportPDFFilters" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <?php $__currentLoopData = array_keys($tabsConfig); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div id="table_<?php echo e($tab); ?>" style="<?php echo e($loop->first ? '' : 'display:none'); ?>"></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>
</main>

<?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
(function(){
  const sectionEl=document.querySelector('.section');
  const basePackage=String((sectionEl&&sectionEl.getAttribute('data-package'))||'<?php echo e($activePkg); ?>'||'PKG-2').trim()||'PKG-2';

  const routes={
    all:"<?php echo e(route('employees.inside')); ?>",
    office:"<?php echo e(route('employees.office')); ?>",
    trial:"<?php echo e(route('employees.contracted')); ?>",
    invoices:"<?php echo e(route('employees.emp-invoices')); ?>",
    receipt:"<?php echo e(route('employees.emp-receipts')); ?>",
    ins_invoices:"<?php echo e(route('employees.emp-ins-invoices')); ?>",
    refund:"<?php echo e(route('employees.emp-refunds')); ?>",
    payroll:"<?php echo e(route('employees.emp-payroll')); ?>",
    incident:"<?php echo e(route('employees.incident')); ?>",
    outside:"<?php echo e(route('employees.outside')); ?>",
    boa:"<?php echo e(route('employees.emp-boa')); ?>",
    rvo:"<?php echo e(route('employees.emp-rvo')); ?>",
    replacements:"<?php echo e(route('employees.getReplaced')); ?>"
  };

  const tabs=Object.keys(routes);
  const TAB_STORAGE_KEY='employees_active_tab';
  let currentTab='all';
  let typingTimer=null;
  let trialStatus='';
  let tabsExpanded=false;
  let activeXhr=null;
  let exporting=false;

  function showLoader(on){
    const el=document.getElementById('tableLoader');
    if(!el)return;
    el.classList.toggle('show',!!on);
  }

  function safeNotify(type,msg){
    const text=String(msg||'').trim()||'Something went wrong.';
    if(window.toastr&&typeof window.toastr[type]==='function')return window.toastr[type](text);
    alert(text);
  }

  function emptyStateHtml(title,sub){
    const t=String(title||'No record found');
    const s=String(sub||'Try changing filters, search, or package.');
    return '<div class="empty-state my-3"><div class="icon"><i class="fa-solid fa-circle-info"></i></div><p class="title">'+t+'</p><p class="sub">'+s+'</p></div>';
  }

  function pad2(n){return String(n).padStart(2,'0')}
  function formatDateInput(d){return d.getFullYear()+'-'+pad2(d.getMonth()+1)+'-'+pad2(d.getDate())}
  function startOfDay(d){return new Date(d.getFullYear(),d.getMonth(),d.getDate())}
  function addDays(d,n){return new Date(d.getFullYear(),d.getMonth(),d.getDate()+n)}
  function startOfWeekMonday(d){const day=d.getDay();const diff=(day+6)%7;return addDays(d,-diff)}
  function endOfPrevMonth(d){return new Date(d.getFullYear(),d.getMonth(),0)}
  function startOfPrevMonth(d){return new Date(d.getFullYear(),d.getMonth()-1,1)}
  function startOfThisMonth(d){return new Date(d.getFullYear(),d.getMonth(),1)}
  function startOfThisYear(d){return new Date(d.getFullYear(),0,1)}

  function computePresetRange(preset){
    const now=new Date();
    const today=startOfDay(now);
    if(preset==='today')return{from:today,to:today};
    if(preset==='this_week')return{from:startOfWeekMonday(today),to:today};
    if(preset==='this_month')return{from:startOfThisMonth(today),to:today};
    if(preset==='previous_month')return{from:startOfPrevMonth(today),to:endOfPrevMonth(today)};
    if(preset==='this_year')return{from:startOfThisYear(today),to:today};
    return{from:null,to:null};
  }

  function normalizePackage(val){
    const v=String(val||'').trim().toUpperCase();
    if(v==='ALL')return'ALL';
    const map={'PKG-2':'PKG-2','PKG-3':'PKG-3','PKG-4':'PKG-4','PKG 2':'PKG-2','PKG 3':'PKG-3','PKG 4':'PKG-4'};
    return map[v]||v;
  }

  function updateDateRangeVisibility(){
    const pTrial=$('#date_preset_trial').val();
    $('.trial-date-range').toggle(pTrial==='custom');
    const pRvo=$('#date_preset_rvo').val();
    $('.rvo-date-range').toggle(pRvo==='custom');
    const pPayroll=$('#date_preset_payroll').val();
    $('.payroll-date-range').toggle(pPayroll==='custom');
  }

  function setDateFieldsForTab(group,preset){
    const r=computePresetRange(preset);
    if(!r.from||!r.to)return;

    if(group==='trial'){
      $('#trial_date_from').val(formatDateInput(r.from));
      $('#trial_date_to').val(formatDateInput(r.to));
    }
    if(group==='rvo'){
      $('#rvo_date_from').val(formatDateInput(r.from));
      $('#rvo_date_to').val(formatDateInput(r.to));
    }
    if(group==='payroll'){
      $('#start_date_payroll').val(formatDateInput(r.from));
      $('#end_date_payroll').val(formatDateInput(r.to));
    }
  }

  function toggleExtraTabs(force){
    const extra=$('.extra-tab');
    if(extra.length===0)return;
    if(typeof force==='boolean')tabsExpanded=force; else tabsExpanded=!tabsExpanded;
    extra.toggleClass('d-none',!tabsExpanded);
    const btn=$('#toggleTabsBtn');
    if(btn.length)btn.find('i').removeClass('fa-plus fa-minus').addClass(tabsExpanded?'fa-minus':'fa-plus');
  }

  function setPanelTitle(){
    const tab=currentTab;
    const label=$('button[data-tab="'+tab+'"]').contents().filter(function(){return this.nodeType===3}).text().trim()||tab.toUpperCase();
    $('#panelTitle').text(label+' Filters');
  }

  function sharedFilters(){
    const f={};
    const insideStatus=$('#inside_status').val();
    if(insideStatus)f.inside_status=insideStatus;
    return f;
  }

  function buildFilters(tab=currentTab){
    const f=sharedFilters();
    const s=$('#global_search').val();
    if(s)f.search=s;

    if(tab==='boa'){
      Object.assign(f,{
        reference_no:$('#reference_no_boa').val(),
        cl_number:$('#cl_number_boa').val(),
        cn_number:$('#cn_number_boa').val(),
        candidate_name:$('#candidate_name_boa').val(),
        passport_number:$('#passport_number_boa').val(),
        date_from:$('#date_from_boa').val(),
        date_to:$('#date_to_boa').val(),
        package:normalizePackage($('#package_boa').val()||basePackage),
        status:$('#status_boa').val()
      });
    }else if(['rvo','invoices','receipt','refund','ins_invoices'].includes(tab)){
      Object.assign(f,{
        reference_no:$('#reference_no_rvo').val(),
        candidate_name:$('#candidate_name_rvo').val(),
        customer_name:$('#customer_name_rvo').val(),
        cl_number:$('#cl_number_rvo').val(),
        cn_number:$('#cn_number_rvo').val(),
        agreement_no:$('#agreement_no_rvo').val(),
        invoice_status:$('#status_rvo').val(),
        status:$('#status_rvo').val(),
        date_from:$('#rvo_date_from').val(),
        date_to:$('#rvo_date_to').val(),
        date_preset:$('#date_preset_rvo').val(),
        payment_method:$('#payment_method_rvo').val(),
        package:normalizePackage($('#package_rvo').val()||basePackage)
      });
      if(tab==='receipt'||tab==='refund')f.status=tab;
    }else if(tab==='payroll'){
      Object.assign(f,{
        reference_no:$('#reference_no_payroll').val(),
        candidate_name:$('#candidate_name_payroll').val(),
        passport_number:$('#passport_number_payroll').val(),
        start_date:$('#start_date_payroll').val(),
        end_date:$('#end_date_payroll').val(),
        date_preset:$('#date_preset_payroll').val(),
        package:normalizePackage($('#package_payroll').val()||basePackage)
      });
    }else if(tab==='replacements'){
      Object.assign(f,{
        contract_number:$('#contract_number_replacements').val(),
        reference_no:$('#reference_no_replacements').val(),
        name:$('#name_replacements').val(),
        passport_no:$('#passport_number_replacements').val(),
        nationality:$('#nationality_replacements').val(),
        from:$('#from_replacements').val(),
        to:$('#to_replacements').val(),
        package:normalizePackage($('#package').val()||basePackage)
      });
    }else{
      Object.assign(f,{
        reference_no:$('#reference_no').val(),
        candidate_name:$('#candidate_name').val(),
        passport_number:$('#passport_number').val(),
        foreign_partner:$('#foreign_partner').val(),
        package:normalizePackage($('#package').val()||basePackage),
        nationality:$('#nationality').val(),
        visa_stage:$('#visa_stage').val()
      });
    }

    if(tab==='trial')Object.assign(f,{con_reference_no:$('#con_reference_no').val(),trial_status:trialStatus,date_preset:$('#date_preset_trial').val(),date_from:$('#trial_date_from').val(),date_to:$('#trial_date_to').val()});
    if(tab==='office')Object.assign(f,{category:$('#category').val(),arrived_date:$('#arrived_date').val(),expiry:$('#expiry').val()});
    if(tab==='incident')Object.assign(f,{incident_type:$('#incident_type').val()});

    if(!f.package)f.package=basePackage;
    return f;
  }

  function isMeaningfulFilterValue(tab,key,val){
    if(key==='package')return false;
    if((tab==='receipt'||tab==='refund')&&key==='status'&&String(val||'')===tab)return false;
    return val!==undefined&&val!==null&&String(val).trim()!=='';
  }

  function anyFilterFilled(){
    const f=buildFilters(currentTab);
    return Object.keys(f).some(k=>isMeaningfulFilterValue(currentTab,k,f[k]));
  }

  function updateFilterBtnState(){
    const active=anyFilterFilled();
    const btn=$('#filterBtn');
    btn.toggleClass('btn-success',!!active).toggleClass('btn-primary',!active);
  }

  function updateFilterFields(){
    $('.filter').hide();

    if(currentTab==='boa'){
      $('.filter.boa').show();
      updateDateRangeVisibility();
      return;
    }

    if(['rvo','invoices','receipt','refund','ins_invoices'].includes(currentTab)){
      $('.filter.rvo, .filter.invoices, .filter.receipt, .filter.refund, .filter.ins_invoices').show();
      updateDateRangeVisibility();
      return;
    }

    if(currentTab==='payroll'){
      $('.filter.payroll').show();
      updateDateRangeVisibility();
      return;
    }

    if(currentTab==='trial'){
      $('.filter.trial, .filter.common').show();
      updateDateRangeVisibility();
      return;
    }

    if(currentTab==='office'){
      $('.filter.office, .filter.common').show();
      updateDateRangeVisibility();
      return;
    }

    if(currentTab==='incident'){
      $('.filter.incident, .filter.common').show();
      updateDateRangeVisibility();
      return;
    }

    if(currentTab==='replacements'){
      $('.filter.replacements').show();
      updateDateRangeVisibility();
      return;
    }

    $('.filter.common').show();
    updateDateRangeVisibility();
  }

  function hardResetAndReload(){
    $('#global_search').val('');
    $('#filterForm')[0].reset();
    trialStatus='';
    $('#trialStatusDropdown button').text('Status');
    updateDateRangeVisibility();
    $('#resetBtn').hide();
    loadTab(currentTab,1);
    updateFilterBtnState();
  }

  function applyResponseHtml(tab,html){
    const target=$('#table_'+tab);
    const str=(html??'').toString().trim();
    if(!str)return target.html(emptyStateHtml('No record found','No data returned for your filters.'));
    target.html(str);
    const hasTable=target.find('table').length>0;
    const hasRows=target.find('table tbody tr').length>0;
    const hasText=target.text().trim().length>0;
    if(!hasText)return target.html(emptyStateHtml('No record found','No content was rendered.'));
    if(hasTable&&!hasRows)return target.html(emptyStateHtml('No record found','There are no rows to display.'));
  }

  function updateBadges(counts){
    if(!counts||typeof counts!=='object')return;
    Object.keys(counts).forEach(k=>{
      const el=document.getElementById('badge_count_'+k);
      if(el)el.textContent=counts[k];
    });
  }

  function persistTab(tab){
    try{localStorage.setItem(TAB_STORAGE_KEY,String(tab||'all'))}catch(e){}
    const urlObj=new URL(window.location.href);
    urlObj.searchParams.set('tab',String(tab||'all'));
    history.replaceState({},'',urlObj.toString());
  }

  function persistPackage(pkg){
    const urlObj=new URL(window.location.href);
    if(pkg)urlObj.searchParams.set('package',pkg); else urlObj.searchParams.delete('package');
    if(currentTab)urlObj.searchParams.set('tab',currentTab);
    history.replaceState({},'',urlObj.toString());
  }

  function getInitialTab(){
    const urlObj=new URL(window.location.href);
    const qTab=String(urlObj.searchParams.get('tab')||'').trim();
    if(qTab && tabs.includes(qTab))return qTab;
    let ls='';
    try{ls=String(localStorage.getItem(TAB_STORAGE_KEY)||'').trim()}catch(e){ls=''}
    if(ls && tabs.includes(ls))return ls;
    return 'all';
  }

  function ensureTabVisible(tab){
    const btn=document.querySelector('button.nav-link[data-tab="'+tab+'"]');
    if(!btn)return null;
    const li=btn.closest('li');
    if(li && li.classList.contains('extra-tab') && li.classList.contains('d-none')) toggleExtraTabs(true);
    return btn;
  }

  function loadTab(tab,page=1){
    const url=routes[tab];
    if(!url)return $('#table_'+tab).html(emptyStateHtml('No route found','This tab is not configured.'));
    const f=buildFilters(tab);
    f.page=page;

    if(activeXhr&&typeof activeXhr.abort==='function')activeXhr.abort();
    showLoader(true);

    activeXhr=$.ajax({url,method:'GET',data:f,cache:false})
      .done(res=>{
        const html=(res&&typeof res==='object')?(res.table||res.html||''):res;
        applyResponseHtml(tab,html);
        if(res&&typeof res==='object'&&res.counts)updateBadges(res.counts);
        persistPackage(f.package||basePackage);
      })
      .fail(xhr=>{
        const msg=(xhr&&xhr.responseJSON&&xhr.responseJSON.message)?xhr.responseJSON.message:'Failed to load data.';
        applyResponseHtml(tab,emptyStateHtml('Request failed',msg));
      })
      .always(()=>{
        showLoader(false);
        updateFilterBtnState();
      });
  }

  window.switchTab=function(tab,btn){
    if(!tabs.includes(tab))tab='all';
    currentTab=tab;
    persistTab(tab);
    $('#statusTab .nav-link').not('#toggleTabsBtn').removeClass('active');
    $(btn).addClass('active');
    tabs.forEach(t=>$('#table_'+t).toggle(t===tab));
    setPanelTitle();
    updateFilterFields();
    updateFilterBtnState();
    $('#trialStatusDropdown').toggleClass('d-none',tab!=='trial');
    loadTab(tab,1);
  };

  $('#filterBtn').on('click',()=>{$('#filterPanel').toggle();setPanelTitle();updateFilterFields();updateFilterBtnState();});
  $('#reloadBtn').on('click',hardResetAndReload);
  $('#resetBtn').on('click',hardResetAndReload);

  $('#reloadFilters').on('click',()=>{
    $('#filterForm')[0].reset();
    trialStatus='';
    $('#trialStatusDropdown button').text('Status');
    updateDateRangeVisibility();
    loadTab(currentTab,1);
    $('#resetBtn').toggle(anyFilterFilled());
    updateFilterBtnState();
  });

  $('#date_preset_trial').on('change',function(){
    const preset=$(this).val();
    if(preset&&preset!=='custom')setDateFieldsForTab('trial',preset);
    updateDateRangeVisibility();
    loadTab(currentTab,1);
    $('#resetBtn').toggle(anyFilterFilled());
    updateFilterBtnState();
  });

  $('#date_preset_rvo').on('change',function(){
    const preset=$(this).val();
    if(preset&&preset!=='custom')setDateFieldsForTab('rvo',preset);
    updateDateRangeVisibility();
    loadTab(currentTab,1);
    $('#resetBtn').toggle(anyFilterFilled());
    updateFilterBtnState();
  });

  $('#date_preset_payroll').on('change',function(){
    const preset=$(this).val();
    if(preset&&preset!=='custom')setDateFieldsForTab('payroll',preset);
    updateDateRangeVisibility();
    loadTab(currentTab,1);
    $('#resetBtn').toggle(anyFilterFilled());
    updateFilterBtnState();
  });

  $(document).on('keyup change','#global_search,#filterForm input,#filterForm select',function(){
    clearTimeout(typingTimer);
    typingTimer=setTimeout(()=>{
      loadTab(currentTab,1);
      $('#resetBtn').toggle(anyFilterFilled());
      updateFilterBtnState();
    },300);
  });

  $(document).on('click','.pagination a',function(e){
    e.preventDefault();
    const page=new URL(this.href,location.origin).searchParams.get('page')||1;
    loadTab(currentTab,page);
  });

  $(document).on('click','#trialStatusDropdown .dropdown-item',function(e){
    e.preventDefault();
    trialStatus=$(this).data('value');
    $('#trialStatusDropdown button').text($(this).text());
    loadTab(currentTab,1);
    $('#resetBtn').toggle(anyFilterFilled());
    updateFilterBtnState();
  });

  $(document).on('click','#toggleTabsBtn',function(){toggleExtraTabs();});

  function getFilenameFromDisposition(d,def){
    const v=String(d||'');
    const m=/filename\*?=(?:UTF-8''|")?([^;"\n]+)"?/i.exec(v);
    if(!m)return def;
    try{return decodeURIComponent(m[1]).replace(/["']/g,'').trim()||def}catch{return m[1].replace(/["']/g,'').trim()||def}
  }

  async function downloadViaFetch(url,fallback){
    const res=await fetch(url,{credentials:'same-origin'});
    const ct=(res.headers.get('Content-Type')||'').toLowerCase();
    if(!res.ok){
      if(ct.includes('application/json')){
        const j=await res.json().catch(()=>null);
        throw new Error(j?.message||'Export failed.');
      }
      throw new Error('Export failed. Please try again.');
    }
    if(ct.includes('application/json')){
      const j=await res.json().catch(()=>null);
      if(j?.message)throw new Error(j.message);
      throw new Error('Export failed.');
    }
    const blob=await res.blob();
    const filename=getFilenameFromDisposition(res.headers.get('Content-Disposition'),fallback);
    const a=document.createElement('a');
    const blobUrl=URL.createObjectURL(blob);
    a.href=blobUrl;
    a.download=filename;
    document.body.appendChild(a);
    a.click();
    a.remove();
    URL.revokeObjectURL(blobUrl);
    return{ok:true,message:'Export started.'};
  }

  async function exportNow(format){
    if(exporting)return;
    exporting=true;
    $('#exportExcelFilters,#exportPDFFilters').prop('disabled',true);
    try{
      const url=routes[currentTab];
      if(!url)throw new Error('No export route found.');
      const params=Object.assign({export:format},buildFilters(currentTab));
      const qs=$.param(params);
      const full=url+(qs?('?'+qs):'');
      const ext=format==='pdf'?'pdf':'xlsx';
      const fallback=(currentTab||'export')+'-'+format+'.'+ext;
      const result=await downloadViaFetch(full,fallback);
      safeNotify('success',result?.message||'Export completed.');
    }catch(e){
      safeNotify('error',e?.message||'Export failed.');
    }finally{
      exporting=false;
      $('#exportExcelFilters,#exportPDFFilters').prop('disabled',false);
    }
  }

  $('#exportExcelFilters').on('click',function(e){e.preventDefault();exportNow('excel')});
  $('#exportPDFFilters').on('click',function(e){e.preventDefault();exportNow('pdf')});

  $(function(){
    $('#package').val(basePackage);
    $('#package_boa').val(basePackage);
    $('#package_rvo').val(basePackage);
    $('#package_payroll').val(basePackage);
    toggleExtraTabs(false);
    const initTab=getInitialTab();
    const btn=ensureTabVisible(initTab) || document.querySelector('.nav-link[data-tab="all"]');
    if(btn) switchTab(btn.getAttribute('data-tab')||'all',btn);
  });
})();

window.confirmInvoiceStatusChangeofEmployees = function(el, id, name, amt, agr){
  const prevIndex = el.dataset.prevIndex ? parseInt(el.dataset.prevIndex,10) : el.selectedIndex;
  const nextIndex = el.selectedIndex;
  const nextText = el.options?.[nextIndex]?.text || el.value || '';
  const label = `${name} (${agr}) - Received: ${amt}`;

  const cancel = () => { el.selectedIndex = prevIndex; };

  const proceed = () => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const url = String(<?php echo json_encode(route('invoices.updateStatus', ':id'), 512) ?>).replace(':id', id);

    $.post(url, { _token: token, status_name: el.value, invoice_id: id, agreementNo: agr })
      .done(res => {
        const ok = !!res?.success;
        const msg = res?.message || (ok ? 'Updated.' : 'Failed.');
        if(window.toastr) ok ? toastr.success(msg) : toastr.error(msg); else alert(msg);
        if(ok && res?.statusColor) $(el).css('background-color', res.statusColor);
      })
      .fail(xhr => {
        const msg = xhr?.responseJSON?.message || 'Error.';
        if(window.toastr) toastr.error(msg); else alert(msg);
      });
  };

  el.dataset.prevIndex = String(prevIndex);

  if(window.Swal && typeof Swal.fire === 'function'){
    Swal.fire({
      title: `Change status for ${label}?`,
      text: `Switch to "${nextText}"?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#dc3545',
      confirmButtonText: 'Yes',
      cancelButtonText: 'No'
    }).then(r => { if(r.isConfirmed) proceed(); else cancel(); });
    return;
  }

  if(window.confirm(`Change status for ${label}?\nSwitch to "${nextText}"?`)) proceed();
  else cancel();
};

$(document).on('focus mousedown','select[onchange*="confirmInvoiceStatusChangeofEmployees"]',function(){
  this.dataset.prevIndex = String(this.selectedIndex);
});
</script>
<?php /**PATH /home/developmentoneso/public_html/resources/views/employee/inside_emp.blade.php ENDPATH**/ ?>