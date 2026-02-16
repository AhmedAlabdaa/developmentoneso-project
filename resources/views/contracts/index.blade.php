@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
  body {
    background: linear-gradient(to right,#e0f7fa,#e1bee7);
    font-family: Arial, sans-serif;
  }
  .filter-wrapper {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: .5rem;
    margin: 20px 0;
    font-size: 12px;
  }
  .filter-wrapper .form-control,
  .filter-wrapper .btn {
    font-size: 12px;
  }
  .dropdown-menu {
    width: 300px !important;
  }
  .preloader {
    display: none;
    position: absolute;
    left: 40%;
    font-size: 20px;
    color: #007bff;
  }
  .table thead th,
  .table tfoot th {
    background: linear-gradient(to right,#007bff,#00c6ff);
    color: #fff;
    text-align: center;
    font-weight: normal;
  }
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card flex-fill">
          <div class="card-body">

            <div class="filter-wrapper">
              <div class="input-group input-group-sm" style="max-width:300px">
                <input type="text" id="global_search" class="form-control" placeholder="Search by Ref No, Name, Passport#, CL#, CN#">
                <span class="input-group-text clear-search"><i class="fas fa-times"></i></span>
              </div>
              <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-filter"></i> Filter
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="filterDropdown">
                  <form id="globalFilterForm">
                    <div class="mb-2">
                      <input type="text" id="gf_reference_no" class="form-control form-control-sm" placeholder="Reference No">
                    </div>
                    <div class="mb-2">
                      <input type="text" id="gf_type" class="form-control form-control-sm" placeholder="Type">
                    </div>
                    <div class="d-flex gap-2 mb-2">
                      <input type="text" id="gf_candidate_name" class="form-control form-control-sm" placeholder="Candidate Name">
                      <input type="text" id="gf_passport_no" class="form-control form-control-sm" placeholder="Passport No">
                    </div>
                    <div class="d-flex gap-2 mb-2">
                      <input type="text" id="gf_cn_number" class="form-control form-control-sm" placeholder="CN Number">
                      <input type="text" id="gf_cl_number" class="form-control form-control-sm" placeholder="CL Number">
                    </div>
                    <div class="mb-2">
                      @php
                        $statusOptions = [
                          1 => 'Pending',
                          2 => 'Active',
                          3 => 'Exceeded',
                          4 => 'Rejected',
                          5 => 'Contracted',
                          6 => 'Extended',
                        ];
                        $current = request('gf_status');
                        @endphp
                        <select id="gf_status" name="gf_status" class="form-control form-control-sm">
                          <option value="">All Statuses</option>
                          @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected((string)$current === (string)$value)>{{ $label }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                      <input type="text" id="gf_foreign_partner" class="form-control form-control-sm" placeholder="Foreign Partner">
                    </div>
                    <div class="mb-2">
                      <input type="text" id="gf_package" class="form-control form-control-sm" placeholder="Package">
                    </div>
                    <div class="d-flex gap-2 mb-2">
                      <input type="date" id="gf_from_date" class="form-control form-control-sm" placeholder="From Date">
                      <input type="date" id="gf_to_date" class="form-control form-control-sm" placeholder="To Date">
                    </div>
                    <div class="d-flex justify-content-end gap-1 mt-2">
                      <button type="button" id="filter_reset" class="btn btn-secondary btn-sm"><i class="fas fa-undo"></i> Reset</button>
                      <button type="button" id="filter_export" class="btn btn-success btn-sm"><i class="fas fa-file-export"></i> Export</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <ul class="nav nav-tabs mb-3" id="contractTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-status="all" role="tab"><i class="fas fa-list"></i> All Contracts</a>
              </li>
            </ul>

            <div class="table-responsive position-relative" id="contract_table">
              <div class="preloader"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@include('../layout.footer')

<script>
  $(function(){
    function loadContracts(status = 'all', url = "{{ route('contracts.index') }}") {
      $('.preloader').show();
      const data = {
        status,
        search: $('#global_search').val(),
        reference_no: $('#gf_reference_no').val(),
        type: $('#gf_type').val(),
        candidate_name: $('#gf_candidate_name').val(),
        passport_no: $('#gf_passport_no').val(),
        CN_Number: $('#gf_cn_number').val(),
        CL_Number: $('#gf_cl_number').val(),
        status_filter: $('#gf_status').val(),
        foreign_partner: $('#gf_foreign_partner').val(),
        package: $('#gf_package').val(),
        from_date: $('#gf_from_date').val(),
        to_date:   $('#gf_to_date').val()
      };
      $.get(url, data)
        .done(res => $('#contract_table').html(res))
        .fail(() => $('#contract_table').html('<p class="text-danger p-3">Unable to load data.</p>'))
        .always(() => $('.preloader').hide());
    }

    $('#contractTab a').on('click', function(e){
      e.preventDefault();
      $('#contractTab a').removeClass('active');
      $(this).addClass('active');
      loadContracts($(this).data('status'));
    });

    $('#global_search').on('input', () => loadContracts($('#contractTab a.active').data('status')));
    $('.clear-search').click(() => $('#global_search').val('').trigger('input'));
    $('#globalFilterForm').on('input change', 'input,select', () => loadContracts($('#contractTab a.active').data('status')));
    $('#filter_reset').click(() => {
      $('#globalFilterForm')[0].reset();
      loadContracts($('#contractTab a.active').data('status'));
    });
    $('#filter_export').click(() => {
      const params = $.param(Object.assign(
        { status: $('#contractTab a.active').data('status'), search: $('#global_search').val() },
        {
          reference_no: $('#gf_reference_no').val(),
          type: $('#gf_type').val(),
          candidate_name: $('#gf_candidate_name').val(),
          passport_no: $('#gf_passport_no').val(),
          CN_Number: $('#gf_cn_number').val(),
          CL_Number: $('#gf_cl_number').val(),
          status_filter: $('#gf_status').val(),
          foreign_partner: $('#gf_foreign_partner').val(),
          package: $('#gf_package').val(),
          from_date: $('#gf_from_date').val(),
          to_date:   $('#gf_to_date').val()
        }
      ));
      window.location = '{{ route("contracts.index") }}?' + params;
    });

    loadContracts();
    $(document).on('click', '#contract_table .pagination a', function(e){
      e.preventDefault();
      loadContracts($('#contractTab a.active').data('status'), $(this).attr('href'));
    });
  });
</script>
