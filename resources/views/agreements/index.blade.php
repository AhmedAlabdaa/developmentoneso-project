{{-- resources/views/agreements/index.blade.php --}}
@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>

<style>
  body { background: linear-gradient(to right,#e0f7fa,#e1bee7); font-family: Arial,sans-serif; }
  .filter-wrapper { display:flex;justify-content:flex-end;align-items:center;gap:.5rem;margin-top:10px;font-size:12px; }
  .filter-wrapper .form-control,.filter-wrapper .form-select,.filter-wrapper .btn { font-size:12px; }
  .dropdown-menu { width:350px!important; }
  .preloader { display:none;position:absolute;left:40%;font-size:20px;color:#007bff; }
  .tab-header { display:flex;justify-content:space-between;align-items:center;margin-top:1rem; }
  .nav-tabs .nav-link { color:#495057; }
  .nav-tabs .nav-link.active { background-color:#007bff;color:#fff; }
  .table thead th,.table tfoot th { background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center; }
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card">
      <div class="card-body">

        <div class="filter-wrapper">
          <div class="input-group input-group-sm" style="max-width:300px">
            <input type="text" id="global_search" class="form-control" placeholder="Search by Ref No, Name, Passport#, CL#, CN#">
            <span class="input-group-text clear-search"><i class="fas fa-times"></i></span>
          </div>
          <div class="dropdown" data-bs-auto-close="outside">
            <button class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
              <i class="fas fa-filter"></i> Filter
            </button>
            <div class="dropdown-menu dropdown-menu-end p-3">
              <form id="globalFilterForm">
                <div class="d-flex gap-2 mb-2">
                  <input type="text" id="gf_candidate_name" class="form-control form-control-sm" placeholder="Candidate Name">
                  <input type="text" id="gf_cn_number" class="form-control form-control-sm" placeholder="CN Number">
                </div>
                <div class="d-flex gap-2 mb-2">
                  <input type="text" id="gf_cl_number" class="form-control form-control-sm" placeholder="CL Number">
                  <input type="text" id="gf_passport_number" class="form-control form-control-sm" placeholder="Passport Number">
                </div>
                <div class="d-flex gap-2 mb-2">
                  <select id="gf_status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="1">Pending</option>
                    <option value="2">Approved</option>
                    <option value="3">Hold</option>
                    <option value="4">Cancelled</option>
                    <option value="5">Completed</option>
                  </select>
                  <select id="gf_nationality" class="form-select form-select-sm">
                    <option value="">All Nationalities</option>
                    <option>Ethiopia</option><option>Uganda</option><option>Philippines</option>
                    <option>Indonesia</option><option>Sri Lanka</option><option>Myanmar</option>
                  </select>
                </div>
                <div class="d-flex gap-2 mb-2">
                  <input type="text" id="gf_foreign_partner" class="form-control form-control-sm" placeholder="Foreign Partner">
                  <select id="gf_package" class="form-select form-select-sm">
                    <option value="">Package</option>
                    <option value="PKG-1">PKG-1</option>
                    <option value="PKG-2">PKG-2</option>
                    <option value="PKG-3">PKG-3</option>
                    <option value="PKG-4">PKG-4</option>
                  </select>
                </div>
                <div class="mb-2">
                  <select id="gf_agreement_type" class="form-select form-select-sm w-100">
                    <option value="">All Types</option>
                    <option value="BOA">BOA</option>
                    <option value="BIA">BIA</option>
                  </select>
                </div>
                <div class="d-flex gap-2 mb-2">
                  <input type="date" id="gf_from_date" class="form-control form-control-sm" placeholder="Start Date">
                  <input type="date" id="gf_to_date" class="form-control form-control-sm" placeholder="End Date">
                </div>
                <div class="d-flex justify-content-end gap-1">
                  <button type="reset" class="btn btn-secondary btn-sm"><i class="fas fa-undo"></i> Reset</button>
                  <button type="button" id="filter_export" class="btn btn-success btn-sm"><i class="fas fa-file-export"></i> Export</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="tab-header">
          <ul class="nav nav-tabs" id="mainTabs" role="tablist">
            <li class="nav-item"><a class="nav-link active"   id="boa-tab"       data-bs-toggle="tab" href="#boa"       role="tab"><i class="fas fa-handshake"></i> BOA/WC</a></li>
            <li class="nav-item"><a class="nav-link"         id="bia-tab"       data-bs-toggle="tab" href="#bia"       role="tab"><i class="fas fa-handshake"></i> BIA/TA</a></li>
            <li class="nav-item"><a class="nav-link"         id="contracts-tab" data-bs-toggle="tab" href="#contracts"role="tab"><i class="fas fa-file-contract"></i> Contracts</a></li>
          </ul>
        </div>

        <div class="tab-content" id="mainTabsContent">
          <div class="tab-pane fade show active" id="boa" role="tabpanel">
            <div class="table-responsive position-relative" id="BOA_agreement_table"><div class="preloader"><i class="fas fa-spinner fa-spin"></i></div></div>
          </div>
          <div class="tab-pane fade" id="bia" role="tabpanel">
            <div class="table-responsive position-relative" id="BIA_agreement_table"><div class="preloader"><i class="fas fa-spinner fa-spin"></i></div></div>
          </div>
          <div class="tab-pane fade" id="contracts" role="tabpanel">
            <div class="table-responsive position-relative" id="contracts_table"><div class="preloader"><i class="fas fa-spinner fa-spin"></i></div></div>
          </div>
        </div>

      </div>
    </div>
  </section>
</main>

@include('../layout.footer')

<script>
$(function(){
  function loadData(scope,url='{{ route("agreements.index") }}'){
    let type = scope==='contracts'?'contracts':scope.toUpperCase();
    let d = {
      agreement_type:type,
      search:$('#global_search').val(),
      candidate_name_gl:$('#gf_candidate_name').val(),
      cn_number_gl:$('#gf_cn_number').val(),
      cl_number_gl:$('#gf_cl_number').val(),
      passport_number_gl:$('#gf_passport_number').val(),
      nationality_gl:$('#gf_nationality').val(),
      status:$('#gf_status').val(),
      status_filter:$('#gf_status').val(),
      foreign_partner_gl:$('#gf_foreign_partner').val(),
      package_gl:$('#gf_package').val(),
      agreement_type_gl:$('#gf_agreement_type').val(),
      from_date_gl:$('#gf_from_date').val(),
      to_date_gl:$('#gf_to_date').val()
    };
    let tgt = scope==='contracts'
      ?'#contracts_table'
      : scope==='bia'
        ?'#BIA_agreement_table'
        :'#BOA_agreement_table';
    $(tgt+' .preloader').show();
    $.get(url,d)
      .done(res=>$(tgt).html(res))
      .fail(()=>$(tgt).html('<div class="text-danger p-3">Error loading data</div>'))
      .always(()=>$(tgt+' .preloader').hide());
  }

  function activeScope(){
    return $('#mainTabs .nav-link.active').attr('id').replace('-tab','');
  }

  $('#mainTabs a').click(function(e){
    e.preventDefault();
    $('#mainTabs a').removeClass('active');
    $(this).addClass('active');
    loadData(activeScope());
  });

  $('.clear-search').click(function(){
    $('#global_search').val('');
    loadData(activeScope());
  });

  $('#global_search, #gf_candidate_name, #gf_cn_number, #gf_cl_number, #gf_passport_number, #gf_nationality, #gf_status, #gf_foreign_partner, #gf_package, #gf_agreement_type, #gf_from_date, #gf_to_date')
    .on('input change',()=>loadData(activeScope()));

  $('#globalFilterForm').on('reset',function(){
    setTimeout(()=>loadData(activeScope()),0);
  });

  $('#filter_export').click(function(){
    let s = activeScope(),
        t = s==='contracts'?'contracts':s.toUpperCase(),
        url = '{{ route("agreements.index") }}',
        params = $.param(Object.assign({agreement_type:t,export:'excel'},{
          search:$('#global_search').val(),
          candidate_name_gl:$('#gf_candidate_name').val(),
          cn_number_gl:$('#gf_cn_number').val(),
          cl_number_gl:$('#gf_cl_number').val(),
          passport_number_gl:$('#gf_passport_number').val(),
          nationality_gl:$('#gf_nationality').val(),
          status:$('#gf_status').val(),
          status_filter:$('#gf_status').val(),
          foreign_partner_gl:$('#gf_foreign_partner').val(),
          package_gl:$('#gf_package').val(),
          agreement_type_gl:$('#gf_agreement_type').val(),
          from_date_gl:$('#gf_from_date').val(),
          to_date_gl:$('#gf_to_date').val()
        }));
    window.location = url+'?'+params;
  });

  $(document).on('click','#BOA_agreement_table .pagination a,#BIA_agreement_table .pagination a',function(e){
    e.preventDefault(); loadData(activeScope(),$(this).attr('href'));
  });
  $(document).on('click','#contracts_table .pagination a',function(e){
    e.preventDefault(); loadData('contracts',$(this).attr('href'));
  });

  loadData('boa');
});
</script>
