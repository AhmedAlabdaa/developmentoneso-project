<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
  .table th,.table td{vertical-align:middle}
  .nav-tabs .nav-link{transition:background-color .2s;color:#495057}
  .nav-tabs .nav-link:hover{background-color:#f8f9fa}
  .nav-tabs .nav-link.active{background-color:#007bff;color:#fff}
  .nav-tabs .nav-link i{margin-right:5px}
  .dropdown-menu{position:relative;min-width:420px;padding:1rem}
  .dropdown-menu form{padding-top:40px}
  .close-icon{position:absolute;top:10px;right:10px;width:30px;height:30px;background:#e0e0e0;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;z-index:999}
  .btn{transition:background-color .2s,color .2s}
  .btn:hover{background-color:#007bff;color:#fff}
  .btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:none}
  .btn-csv-upload{background:linear-gradient(to right,#00c6ff,#6a11cb);color:#fff;border:none;font-size:12px}
  .btn-csv-upload:hover{background-color:#00a1ff;color:#fff}
  .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:400}
  .pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}
  .muted-text{color:#6c757d;font-size:12px}
  .pagination{display:flex;justify-content:center;align-items:center;margin:0}
  .pagination .page-item{margin:0 .1rem}
  .pagination .page-link{border-radius:.25rem;padding:.5rem .75rem;color:#007bff;background-color:#fff;border:1px solid #007bff;transition:background-color .2s,color .2s}
  .pagination .page-link:hover{background-color:#007bff;color:#fff}
  .pagination .page-item.active .page-link{background-color:#007bff;color:#fff;border:1px solid #007bff}
  .pagination .page-item.disabled .page-link{color:#6c757d;background-color:#fff;border:1px solid #6c757d;cursor:not-allowed}
  .form-group label{font-weight:500;margin-bottom:10px}
  .form-control{border-radius:6px;height:42px}
  .filter-input{height:36px}
  .select2-container .select2-selection--single{height:42px;padding:6px 12px;font-size:12px;border:1px solid #ced4da;border-radius:6px}
  .select2-container{z-index:1055;width:100%!important}
  .select2-container--open{z-index:1060}
  .nav-item button{font-size:12px}
  .center-filter{height:36px;margin-bottom:10px;max-width:300px}
  .input-label{font-weight:500;margin-bottom:4px;display:block}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start gap-2 mt-2 mb-2">
          <input type="text" id="global_search" class="form-control center-filter" placeholder="Search by CN Number, Contract No, Candidate Name, Passport No"/>
          <div class="d-flex gap-2">
            <a href="<?php echo e(route('candidates.index')); ?>" class="btn btn-primary btn-sm">
              <i class="bi bi-door-open"></i> Outside
            </a>
            <div class="dropdown">
              <button class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-filter"></i> FILTERS
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <div class="close-icon" id="close_filters"><i class="fas fa-times"></i></div>
                <form id="filter_form_outside">
                  <div class="row mb-2">
                    <div class="col-6">
                      <input type="text" id="reference_no" name="reference_no" class="form-control filter-input" placeholder="CN Number"/>
                    </div>
                    <div class="col-6">
                      <input type="text" id="candidate_name" name="candidate_name" class="form-control filter-input" placeholder="Candidate Name"/>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-6">
                      <input type="text" id="passport_number" name="passport_number" class="form-control filter-input" placeholder="Passport Number"/>
                    </div>
                    <div class="col-6">
                      <select id="nationality" name="nationality" class="form-control filter-input">
                        <option value="">Nationality</option>
                        <?php $__currentLoopData = $nationalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($n->name); ?>"><?php echo e($n->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-6">
                      <select id="package" name="package" class="form-control filter-input">
                        <option value="">Package</option>
                        <option value="PKG-1">PKG-1</option>
                      </select>
                    </div>
                    <div class="col-6">
                      <select id="expiry_order" name="expiry_order" class="form-control filter-input">
                        <option value="">Expiry Order</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-6">
                      <select id="arrival_order" name="arrival_order" class="form-control filter-input">
                        <option value="">Arrival Order</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                      </select>
                    </div>
                    <div class="col-6">
                      <select id="return_order" name="return_order" class="form-control filter-input">
                        <option value="">Return Date Order</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                      </select>
                    </div>
                  </div>
                  <div class="d-flex justify-content-end gap-2">
                    <button id="clear_filters" type="button" class="btn btn-warning btn-sm">
                      <i class="fas fa-filter"></i> Clear
                    </button>
                    <button id="reload_table" type="button" class="btn btn-info btn-sm">
                      <i class="fas fa-sync-alt"></i> Reload
                    </button>
                    <button id="export_excel" type="button" class="btn btn-success btn-sm">
                      <i class="fas fa-file-excel"></i> Excel
                    </button>
                  </div>
                </form>
              </ul>
            </div>
            <button id="reload_table_outside" class="btn btn-info btn-sm">
              <i class="fas fa-sync-alt"></i> Reload
            </button>
            <?php if(auth()->user()->role === 'Archive Clerk' || auth()->user()->role === 'Admin'): ?>
              <a href="<?php echo e(route('package.create')); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
            <?php endif; ?>
          </div>
        </div>

        <div id="statistics_container" class="mb-2">
          <?php echo $__env->make('candidates.partials.inside_counts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div id="candidate_table" class="table-responsive"></div>
      </div>
    </div>
  </section>
</main>

<?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
(function(){
  const KEY = 'candidates_inside_active_status';

  function normStatus(v){
    v = (v ?? 'all').toString().trim().toLowerCase();
    return v || 'all';
  }

  function getQS(){
    return new URLSearchParams(window.location.search);
  }

  function getParam(k){
    return getQS().get(k);
  }

  function setParam(k, v){
    const url = new URL(window.location.href);
    if (v === null || v === undefined || v === '') url.searchParams.delete(k);
    else url.searchParams.set(k, v);
    history.replaceState({}, '', url.toString());
  }

  function readStatus(){
    return normStatus(getParam('status') || sessionStorage.getItem(KEY) || 'all');
  }

  function readPage(){
    const p = parseInt(getParam('page') || '1', 10);
    return Number.isFinite(p) && p > 0 ? p : 1;
  }

  function btnStatus(btn){
    const ds = btn.getAttribute('data-status');
    if (ds) return normStatus(ds);
    const oc = btn.getAttribute('onclick') || '';
    const m = oc.match(/changeStatusAndLoad\(\s*'([^']+)'/);
    return normStatus(m ? m[1] : 'all');
  }

  function setActiveTab(status){
    status = normStatus(status);
    document.querySelectorAll('#statusTab .nav-link').forEach(function(b){
      b.classList.toggle('active', btnStatus(b) === status);
    });
  }

  function showPreloader(){
    if (!document.getElementById('preloader')) {
      const pre = document.createElement('div');
      pre.id = 'preloader';
      Object.assign(pre.style, {
        position: 'fixed',
        top: '0',
        left: '0',
        width: '100%',
        height: '100%',
        backgroundColor: 'rgba(255,255,255,0.8)',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        zIndex: '1050'
      });
      pre.innerHTML = `<div style="text-align:center;"><div style="width:50px;height:50px;border:6px solid rgba(0,0,0,0.1);border-top-color:#007bff;border-radius:50%;animation:spin 1s linear infinite;margin-bottom:10px;"></div><p style="font-size:1rem;color:#007bff;font-weight:bold;">Loading...</p></div>`;
      document.body.appendChild(pre);
      const s = document.createElement('style');
      s.textContent = '@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}';
      document.head.appendChild(s);
    }
  }

  function hidePreloader(){
    const pre = document.getElementById('preloader');
    if (pre) pre.remove();
  }

  function gatherFilters(){
    return {
      reference_no: $('#reference_no').val(),
      candidate_name: $('#candidate_name').val(),
      passport_number: $('#passport_number').val(),
      nationality: $('#nationality').val(),
      package: $('#package').val(),
      global_search: $('#global_search').val(),
      expiry_order: $('#expiry_order').val(),
      arrival_order: $('#arrival_order').val(),
      return_order: $('#return_order').val()
    };
  }

  window.currentStatus = readStatus();

  window.updateTable = function(params){
    params = params || {};
    const f = gatherFilters();
    showPreloader();
    $.get('<?php echo e(route("candidates.inside")); ?>', Object.assign({ status: window.currentStatus }, f, params))
      .done(function(res){
        $('#candidate_table').html(res.table);
        $('#statistics_container').html(res.stats);
        setActiveTab(window.currentStatus);
        hidePreloader();
      })
      .fail(function(){
        hidePreloader();
        alert('Error loading data. Please try again.');
      });
  };

  window.changeStatusAndLoad = function(status, btn){
    status = normStatus(status);
    window.currentStatus = status;
    sessionStorage.setItem(KEY, status);
    setParam('status', status);
    setParam('page', '');
    if (btn) {
      document.querySelectorAll('#statusTab .nav-link').forEach(function(x){ x.classList.remove('active'); });
      btn.classList.add('active');
    } else {
      setActiveTab(status);
    }
    window.updateTable({ page: 1 });
  };

  $(function(){
    window.currentStatus = readStatus();
    sessionStorage.setItem(KEY, window.currentStatus);
    setParam('status', window.currentStatus);
    setActiveTab(window.currentStatus);
    window.updateTable({ page: readPage() });

    $('#filter_form_outside input, #filter_form_outside select, #global_search')
      .on('change keyup', function(){ window.updateTable({ page: 1 }); });

    $('#clear_filters').on('click', function(){
      $('#filter_form_outside')[0].reset();
      $('#global_search').val('');
      setParam('page', '');
      window.updateTable({ page: 1 });
    });

    $('#reload_table, #reload_table_outside').on('click', function(){
      window.updateTable({ page: readPage() });
    });

    $('#export_excel').on('click', function(){
      const q = $.param(Object.assign({ status: window.currentStatus, export: 'excel' }, gatherFilters()));
      window.location = '<?php echo e(route("candidates.inside")); ?>?' + q;
    });

    $('#close_filters').on('click', function(){
      $('.dropdown-toggle').dropdown('hide');
    });

    $(document).on('click', '.pagination a', function(e){
      e.preventDefault();
      const page = parseInt(new URL(this.href).searchParams.get('page') || '1', 10) || 1;
      setParam('page', page);
      window.updateTable({ page: page });
    });
  });
})();
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/inside.blade.php ENDPATH**/ ?>