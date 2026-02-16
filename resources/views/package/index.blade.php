@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main id="main" class="main">
    <section class="section">
        <div class="card flex-fill">
            <div class="card-body">
                <div class="row mt-1 justify-content-end">
                    <div class="col-md-3 position-relative">
                        <input id="globalSearch" class="form-control" placeholder="Search by Name or Passport Number">
                        <span id="clearSearch" class="remove-filter" style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer;">&times;</span>
                    </div>
                    <div class="col-md-auto">
                        <button id="toggleFilterText" class="btn btn-primary"><i class="fas fa-filter"></i> FILTER</button>
                        <button id="resetFilters" class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Reset</button>
                        <button id="exportData" class="btn btn-success"><i class="fas fa-file-export"></i> Export</button>
                        @if(auth()->user()->role === 'Archive Clerk' || auth()->user()->role === 'Admin')
                          <a href="{{ route('package.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                        @endif
                    </div>
                </div>

                <div id="filterSection" class="filter-section mt-3" style="display:none">
                    <form id="filter_form" class="row gx-2">
                        <div class="col-md-2"><input name="CN_Number" class="form-control" placeholder="CN Number"></div>
                        <div class="col-md-2"><input name="name" class="form-control" placeholder="Candidate Name"></div>
                        <div class="col-md-2"><input name="passport_number" class="form-control" placeholder="Passport Number"></div>
                        <div class="col-md-2"><input name="CL_Number" class="form-control" placeholder="CL Number"></div>
                        <div class="col-md-2"><input name="sales_name" class="form-control" placeholder="Sales Name"></div>
                    </form>
                </div>

                <ul id="statusTab" class="nav nav-tabs mt-3">
                    <li class="nav-item"><a class="nav-link active" data-status="all" href="#">All</a></li>
                    <li class="nav-item"><a class="nav-link" data-status="office" href="#">Office</a></li>
                    <li class="nav-item"><a class="nav-link" data-status="trial" href="#">Trial</a></li>
                    <li class="nav-item"><a class="nav-link" data-status="confirm" href="#">Confirm</a></li>
                    <li class="nav-item"><a class="nav-link" data-status="change_status" href="#">Change Status</a></li>
                    <li class="nav-item"><a class="nav-link" data-status="incident" href="#">Incident</a></li>
                </ul>

                <div id="candidate_table" class="table-responsive mt-4"></div>
            </div>
        </div>
    </section>
</main>

<form id="exportForm" method="GET" action="{{ route('package.index') }}" target="_blank" style="display:none;">
    <input name="export" value="excel">
    <input name="status">
    <input name="global_search">
    <input name="CN_Number">
    <input name="name">
    <input name="passport_number">
    <input name="CL_Number">
    <input name="sales_name">
</form>

@include('../layout.footer')

<script>
$(function(){
    loadCandidates();

    function getTab() {
        return $('#statusTab .nav-link.active').data('status') || 'all';
    }

    function serialize(filters = {}) {
        let params = $('#filter_form').serializeArray();
        params.push({ name:'status', value:getTab() });
        params.push({ name:'global_search', value:$('#globalSearch').val() });
        for (let k in filters) params.push({ name:k, value:filters[k] });
        return $.param(params);
    }

    function loadCandidates(url='{{ route("package.index") }}') {
        $('#candidate_table').html('<div class="text-center">Loading...</div>');
        $.get(url, serialize(), html=>$('#candidate_table').html(html))
         .fail(()=>$('#candidate_table').html('<div class="text-danger">Error!</div>'));
    }

    $('#toggleFilterText').click(()=>$('#filterSection').slideToggle(200));

    $('#statusTab a').click(function(e){
        e.preventDefault();
        $('#statusTab .nav-link').removeClass('active');
        $(this).addClass('active');
        loadCandidates();
    });

    $('#filter_form input, #globalSearch').on('input', loadCandidates);

    $('#clearSearch').click(()=>{
        $('#globalSearch').val('');
        loadCandidates();
    });

    $('#resetFilters').click(()=>{
        $('#filter_form')[0].reset();
        $('#globalSearch').val('');
        $('#statusTab .nav-link').removeClass('active');
        $('#statusTab .nav-link[data-status="all"]').addClass('active');
        loadCandidates();
    });

    $('#exportData').click(()=>{
        ['status','global_search','CN_Number','name','passport_number','CL_Number','sales_name']
        .forEach(n=> $('input[name="'+n+'"]', '#exportForm').val(
            n==='status'?getTab(): n==='global_search'?$('#globalSearch').val(): $('[name="'+n+'"]','#filter_form').val()
        ));
        $('#exportForm')[0].submit();
    });

    $(document).on('click','.pagination a',function(e){
        e.preventDefault();
        loadCandidates($(this).attr('href'));
    });
});
</script>
