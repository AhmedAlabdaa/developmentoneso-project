@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}.table th,.table td{vertical-align:middle}.nav-tabs .nav-link{transition:background-color .2s;color:#495057}.nav-tabs .nav-link:hover{background-color:#f8f9fa}.nav-tabs .nav-link.active{background-color:#007bff;color:#fff}.nav-tabs .nav-link i{margin-right:5px}.dropdown-menu{min-width:300px}.dropdown-menu form .mb-2{margin-bottom:.5rem}.btn{transition:background-color .2s,color .2s}.btn:hover{background-color:#007bff;color:#fff}.table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:normal}.pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}.muted-text{color:#6c757d;font-size:12px}.pagination{display:flex;justify-content:center;align-items:center;margin:0}.pagination .page-item{margin:0 .1rem}.pagination .page-link{border-radius:.25rem;padding:.5rem .75rem;color:#007bff;background-color:#fff;border:1px solid #007bff;transition:background-color .2s,color .2s}.pagination .page-link:hover{background-color:#007bff;color:#fff}.pagination .page-item.active .page-link{background-color:#007bff;color:#fff;border:1px solid #007bff}.pagination .page-item.disabled .page-link{color:#6c757d;background-color:#fff;border:1px solid #6c757d;cursor:not-allowed}.btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:none}.btn-csv-upload{background:linear-gradient(to right,#00c6ff,#6a11cb);color:#fff;border:none;font-size:12px}.btn-csv-upload:hover{background-color:#00a1ff;color:#fff}.form-group label{font-weight:500;margin-bottom:10px}.form-control{border-radius:6px;height:42px}.select2-container .select2-selection--single{height:42px;padding:6px 12px;font-size:12px;border:1px solid #ced4da;border-radius:6px}.select2-container{z-index:1055;width:100% !important}.select2-container--open{z-index:1060}.nav-item button{font-size:12px}#global_search{height:36px;margin-bottom:10px}
</style>
<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card flex-fill">
          <div class="card-body">
            <div class="row mt-2">
              <div class="col-lg-4 d-flex justify-content-end align-items-center mt-2 ms-auto">
                <div class="d-flex justify-content-end align-items-center gap-3 mb-2">
                  <a href="{{ route('candidates.index') }}" class="btn btn-primary btn-sm gap-2">
                    <i class="bi bi-door-open"></i> Outside
                  </a>
                  <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-filter"></i> FILTERS
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="filterDropdown">
                      <form id="filter_form_outside">
                        <div class="mb-2">
                          <input type="text" id="reference_no" name="reference_no" class="form-control" placeholder="Enter Reference No">
                        </div>
                        <div class="mb-2">
                          <input type="text" id="candidate_name" name="candidate_name" class="form-control" placeholder="Enter Candidate Name">
                        </div>
                        <div class="mb-2">
                          <input type="text" id="passport_number" name="passport_number" class="form-control" placeholder="Enter Passport Number">
                        </div>
                        <div class="mb-2">
                          <select id="nationality" name="nationality" class="form-control">
                            <option value="">Select Nationality</option>
                            @foreach($nationalities as $nationality)
                              <option value="{{ $nationality->name }}">{{ $nationality->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="mb-2">
                          <select id="package" name="package" class="form-control">
                            <option value="">Select Package</option>
                            <option value="Package 2">PACKAGE 2</option>
                            <option value="Package 3">PACKAGE 3</option>
                            <option value="Package 4">PACKAGE 4</option>
                          </select>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                          <button id="clear_filters" type="button" class="btn btn-warning btn-sm">
                            <i class="fas fa-filter"></i> Clear
                          </button>
                          <button id="export_excel" type="button" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Import Excel
                          </button>
                        </div>
                      </form>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-9" id="statistics_container">
                @include('candidates.partials.inside_counts_emp')
              </div>
              <div class="col-lg-3">
                <div class="d-flex justify-content-end">
                  <div class="input-group" style="max-width:500px;">
                    <input type="text" class="form-control" id="global_search" placeholder="Search by Ref Number , Candidate Name, Passport No">
                  </div>
                </div>
              </div>
            </div>
            @if(session('success'))
              <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif
            @if(session('alert'))
              <div class="alert alert-warning mt-3">{{ session('alert') }}</div>
            @endif
            <div class="table-responsive" id="candidate_table"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@include('layout.footer')
<script>
let currentType = 'employee', currentStatus = 'inside';
function showPreloader(){
  if(!document.getElementById('preloader')){
    const preloader = document.createElement('div');
    preloader.id = 'preloader';
    preloader.style.position = 'fixed';
    preloader.style.top = '0';
    preloader.style.left = '0';
    preloader.style.width = '100%';
    preloader.style.height = '100%';
    preloader.style.backgroundColor = 'rgba(255,255,255,0.8)';
    preloader.style.display = 'flex';
    preloader.style.justifyContent = 'center';
    preloader.style.alignItems = 'center';
    preloader.style.zIndex = '1050';
    preloader.innerHTML = `<div class="preloader-content" style="text-align:center;">
      <div class="spinner" style="width:50px;height:50px;border:6px solid rgba(0,0,0,0.1);border-top-color:#007bff;border-radius:50%;animation:spin 1s linear infinite;margin-bottom:10px;"></div>
      <p style="font-size:1rem;color:#007bff;font-weight:bold;">Loading...</p>
    </div>`;
    document.body.appendChild(preloader);
    const style = document.createElement('style');
    style.textContent = '@keyframes spin {0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); }}';
    document.head.appendChild(style);
  }
}
function hidePreloader(){
  const preloader = document.getElementById('preloader');
  if(preloader) preloader.remove();
}
function setActiveTab(element){
  $(element).closest('ul').find('.nav-link').removeClass('active');
  $(element).addClass('active');
}
function gatherFilters(){
  return {
    reference_no: $('#reference_no').val(),
    candidate_name: $('#candidate_name').val(),
    passport_number: $('#passport_number').val(),
    nationality: $('#nationality').val(),
    package: $('#package').val()
  };
}
function updateTable(params = {}){
  const filters = gatherFilters();
  showPreloader();
  let url = '{{ route("candidates.inside") }}';
  $.ajax({
    url: url,
    type: 'GET',
    data: Object.assign({type: currentType, status: currentStatus}, filters, params),
    success: function(response){
      $('#candidate_table').html(response.table);
      $('#statistics_container').html(response.stats);
      hidePreloader();
    },
    error: function(){
      hidePreloader();
      alert('Error loading data. Please try again.');
    }
  });
}
function changeStatusAndLoad(status, element){
  currentStatus = status;
  setActiveTab(element);
  updateTable();
}
$(document).ready(function(){
  updateTable();
  $('#filter_form_outside input, #filter_form_outside select').on('change keyup', function(){
    updateTable();
  });
  $('#clear_filters').on('click', function(){
    $('#filter_form_outside')[0].reset();
    updateTable();
  });
  $('#export_excel').on('click', function(){
    const url = '{{ route("candidates.inside") }}';
    const query = $.param(Object.assign({type: currentType, status: currentStatus}, gatherFilters()));
    window.location.href = url + '?' + query + '&export=excel';
  });
  $('#global_search').on('keyup', function(){
    const value = $(this).val().trim();
    let params = {};
    if(value.length > 0){
      params = {reference_no: value, candidate_name: value, passport_number: value};
    }
    updateTable(params);
  });
  $(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    const href = $(this).attr('href');
    if(href){
      const url = new URL(href, window.location.origin);
      const page = url.searchParams.get('page');
      updateTable({page: page});
    }
  });
});

var baseUrl = "{{ url('') }}";
function loadInvoices() { window.open(baseUrl + "/invoices", "_blank"); }
function loadPayroll() { window.open(baseUrl + "/employee-payroll", "_blank"); }
function loadPaymentTracking() { window.open(baseUrl + "/employee-payment-tracker", "_blank"); }
</script>
