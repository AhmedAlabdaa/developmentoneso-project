@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
.table th,.table td{vertical-align:middle;text-align:center}
.nav-tabs .nav-link{transition:background-color .2s;color:#495057}
.nav-tabs .nav-link:hover{background-color:#f8f9fa}
.nav-tabs .nav-link.active{background-color:#007bff;color:#fff}
.nav-tabs .nav-link i{margin-right:5px}
.btn{transition:background-color .2s,color .2s,transform .1s;display:inline-flex;align-items:center;gap:.5rem;border:none}
.btn:hover{transform:translateY(-1px)}
.btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff}
.btn-warning{background:#ffc107;color:#212529}
.btn-success{background:#28a745;color:#fff}
.filter-dropdown{position:absolute;top:60px;right:20px;width:360px;background:#fff;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,0.15);padding:16px;display:none;z-index:1050}
.filter-dropdown .row>div{margin-bottom:12px}
.filter-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:12px}
.table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;font-weight:normal}
.preloader-container{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,.8);display:flex;justify-content:center;align-items:center;z-index:1100}
.spinner{width:50px;height:50px;border:6px solid rgba(0,0,0,.1);border-top-color:#007bff;border-radius:50%;animation:spin 1s linear infinite;margin-bottom:10px}
@keyframes spin{to{transform:rotate(360deg)}}
.input-group .form-control,
.input-group .btn {
  height: 42px;
}
.input-group .btn {
  padding: 0 .75rem;
}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12 position-relative">
        <div class="card flex-fill">
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="card-title">All Employees</h5>
              <div>
                <!-- <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm gap-2">
                  <i class="fas fa-plus-circle"></i> Add Employee
                </a>
                <a href="{{ route('employees.upload-employees-csv-file') }}" class="btn btn-primary btn-sm gap-2">
                  <i class="fas fa-upload"></i> Upload CSV File
                </a> -->
                <a href="{{ url('candidates/inside?emp=1') }}" class="btn btn-primary btn-sm gap-2">
                  <i class="fas fa-spinner"></i> In Process
                </a>
                <button id="toggleFilters" class="btn btn-primary btn-sm gap-2">
                  <i class="fas fa-filter"></i> Filters <i class="fas fa-chevron-down"></i>
                </button>
              </div>
            </div>

            <div id="filterDropdown" class="filter-dropdown">
              <form id="filter_form">
                <div class="row">
                  <div class="col-6"><input type="text" name="reference_no" class="form-control" placeholder="Enter Reference No"></div>
                  <div class="col-6"><input type="text" name="name" class="form-control" placeholder="Enter Name"></div>
                  <div class="col-6"><select name="nationality" class="form-control"><option value="">Select Nationality</option></select></div>
                  <div class="col-6"><input type="text" name="passport_no" class="form-control" placeholder="Enter Passport Number"></div>
                  <div class="col-6"><select name="status" class="form-control"><option value="">Select Status</option></select></div>
                  <div class="col-6"><select name="package" class="form-control"><option value="">Select Package</option></select></div>
                  <div class="col-6"><select name="education" class="form-control"><option value="">Select Education</option></select></div>
                  <div class="col-6"><select name="skill" class="form-control"><option value="">Select Skill</option></select></div>
                  <div class="col-6"><select name="religion" class="form-control"><option value="">Select Religion</option></select></div>
                  <div class="col-6"><select name="age" class="form-control"><option value="">Select Age</option></select></div>
                  <div class="col-6"><select name="marital_status" class="form-control"><option value="">Select Marital Status</option></select></div>
                  <div class="col-6"><select name="experience" class="form-control"><option value="">Select Experience</option></select></div>
                  <div class="col-12"><select name="partner" class="form-control"><option value="">Choose Partner</option></select></div>
                </div>
                <div class="filter-actions">
                  <button type="button" id="resetFilters" class="btn btn-warning btn-sm gap-2"><i class="fas fa-sync-alt"></i> Reset</button>
                  <button type="button" id="exportFilters" class="btn btn-success btn-sm gap-2"><i class="fas fa-file-excel"></i> Export</button>
                </div>
              </form>
            </div>

            <div class="row mb-3">
              <div class="col-md-8">
                <ul class="nav nav-tabs" id="packageTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-status="all" href="#">
                      <i class="fas fa-users"></i> All Employees
                      <span class="badge bg-primary">{{ \App\Providers\EmployeesServiceProvider::getbyPackages('all') }}</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-status="Package 2" href="#">
                      <i class="fas fa-check-circle text-success"></i> Package 2
                      <span class="badge bg-primary">{{ \App\Providers\EmployeesServiceProvider::getbyPackages('Package 2') }}</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-status="Package 3" href="#">
                      <i class="fas fa-clock text-warning"></i> Package 3
                      <span class="badge bg-primary">{{ \App\Providers\EmployeesServiceProvider::getbyPackages('Package 3') }}</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-status="Package 4" href="#">
                      <i class="fas fa-star text-info"></i> Package 4
                      <span class="badge bg-primary">{{ \App\Providers\EmployeesServiceProvider::getbyPackages('Package 4') }}</span>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <input type="text" id="global_search" class="form-control" placeholder="Search by Name or Passport No...">
                  <button class="btn btn-primary btn-sm gap-2" id="clearSearch"><i class="fas fa-times"></i></button>
                  <button class="btn btn-primary btn-sm gap-2" id="searchBtn"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </div>

            <div class="table-responsive" id="employee_table"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@include('../layout.footer')
<script>
  function showPreloader() {
    document.body.insertAdjacentHTML('beforeend',
      '<div id="preloader" class="preloader-container">' +
        '<div class="preloader-content">' +
          '<div class="spinner"></div><p>Loading...</p>' +
        '</div>' +
      '</div>'
    );
  }
  function hidePreloader() {
    var p = document.getElementById('preloader'); if (p) p.remove();
  }
  document.getElementById('toggleFilters').addEventListener('click', function() {
    var d = document.getElementById('filterDropdown');
    d.style.display = d.style.display==='block'?'none':'block';
  });
  document.getElementById('resetFilters').addEventListener('click', function() {
    document.getElementById('filter_form').reset();
  });
  function loadEmployees(status='all', page=1) {
    showPreloader();
    var data = $('#filter_form').serialize();
    $.get("{{ route('employees.index') }}", {
      package: status,
      global_search: $('#global_search').val(),
      filters: data,
      page: page
    })
    .done(res => $('#employee_table').html(res))
    .fail(console.error)
    .always(hidePreloader);
  }
  $(function(){
    loadEmployees();
    $('#packageTab a').click(function(e){
      e.preventDefault();
      $('#packageTab a').removeClass('active');
      $(this).addClass('active');
      loadEmployees($(this).data('status'));
    });
    $('#filter_form input,#filter_form select').on('input change', loadEmployees);
    $('#global_search,#searchBtn').on('input click', loadEmployees);
    $('#clearSearch').click(function(){ $('#global_search').val(''); loadEmployees(); });
    $(document).on('click','.pagination a', function(e){
      e.preventDefault();
      var pg = this.href.split('page=')[1].split('&')[0];
      loadEmployees($('#packageTab a.active').data('status'), pg);
    });
  });
</script>
