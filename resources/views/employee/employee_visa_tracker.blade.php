@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style type="text/css">
    body {
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        font-family: Arial, sans-serif;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .nav-tabs .nav-link {
        transition: background-color 0.2s;
        color: #495057;
    }
    .nav-tabs .nav-link:hover {
        background-color: #f8f9fa;
    }
    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: white;
    }
    .nav-tabs .nav-link i {
        margin-right: 5px;
    }
    .filter-section {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }
    .filter-section .form-group {
        margin-bottom: 1rem;
    }
    .toggle-filters {
        cursor: pointer;
        margin-left: auto;
        color: #007bff;
        font-weight: normal;
        margin: 20px;
    }
    .toggle-filters:hover {
        text-decoration: underline;
    }
    .table-responsive {
        margin-top: 20px;
    }
    .card-title {
        font-weight: normal;
    }
    .description {
        font-size: 12px;
        color: #343a40;
        margin: 10px 0 10px;
        padding: 10px;
        background-color: #f8f9fa;
        border-left: 5px solid #007bff;
    }
    .table thead th, .table tfoot th {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
    }
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
    }
    .muted-text {
        color: #6c757d;
        font-size: 12px;
    }
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }
    .pagination .page-item {
        margin: 0 0.1rem;
    }
    .pagination .page-link {
        border-radius: 0.25rem;
        padding: 0.5rem 0.75rem;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #007bff;
        transition: background-color 0.2s, color 0.2s;
    }
    .pagination .page-link:hover {
        background-color: #007bff;
        color: white;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border: 1px solid #6c757d;
        cursor: not-allowed;
    }
    .preloader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1050;
    }
    .preloader-content {
        text-align: center;
    }
    .spinner {
        width: 50px;
        height: 50px;
        border: 6px solid rgba(0, 0, 0, 0.1);
        border-top-color: #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 10px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .btn {
        transition: background-color 0.2s, color 0.2s;
    }
    .btn:hover {
        background-color: #007bff;
        color: white;
    }
    .btn-primary {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        border: none;
    }
    .btn-csv-upload {
        background: linear-gradient(to right, #00c6ff, #6a11cb);
        color: white;
        border: none;
        font-size: 12px;
        transition: background-color 0.2s, color 0.2s;
    }
    .btn-csv-upload:hover {
        background-color: #00a1ff;
        color: white;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card flex-fill">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>{{ session('success') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>{{ session('error') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <p class="description">
                                    <i class="fas fa-bullhorn" style="margin-right: 5px; color: #007bff;"></i>
                                    Manage your package records efficiently. Use the filters below to find specific employees quickly.
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="toggle-filters" id="toggleFilterText">
                                    <i class="fas fa-filter"></i>
                                    <span>Show Filters</span>
                                </div>
                            </div>
                        </div>
                        <div class="filter-section" id="filterSection" style="display: none;">
                            <form id="filter_form">
                                <div class="row">
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="text" id="reference_no" name="reference_no" class="form-control" placeholder="Reference #">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Employee Name">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="text" id="passport_no" name="passport_no" class="form-control" placeholder="Passport No">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="text" id="nationality" name="nationality" class="form-control" placeholder="Nationality">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="text" id="visa_designation" name="visa_designation" class="form-control" placeholder="Visa Designation">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="date" id="date_of_joining" name="date_of_joining" class="form-control" placeholder="Date of Joining">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="date" id="employment_contract_start_date" name="employment_contract_start_date" class="form-control" placeholder="Employment Contract Start Date">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <select id="contract_type" name="contract_type" class="form-control">
                                            <option value="">Contract Type</option>
                                            <option value="permanent">Permanent</option>
                                            <option value="temporary">Temporary</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs" id="packageTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-package="all" role="tab" href="#">
                                            <i class="fas fa-users"></i> All Employees
                                            <span class="badge bg-primary">{{ \App\Providers\EmployeesServiceProvider::getbyPackages('all') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-package="Package 2" role="tab" href="#">
                                            <i class="fas fa-check-circle text-success"></i> Package 2
                                            <span class="badge bg-primary">{{ \App\Providers\EmployeesServiceProvider::getbyPackages('Package 2') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-package="Package 3" role="tab" href="#">
                                            <i class="fas fa-clock text-warning"></i> Package 3
                                            <span class="badge bg-primary">{{ \App\Providers\EmployeesServiceProvider::getbyPackages('Package 3') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-package="Package 4" role="tab" href="#">
                                            <i class="fas fa-star text-info"></i> Package 4
                                            <span class="badge bg-primary">{{ \App\Providers\EmployeesServiceProvider::getbyPackages('Package 4') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="global_search" placeholder="Search by Name or Passport No..." aria-label="Search by Name or Passport No">
                                    <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="visaStatusTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-visa_status="new" role="tab" href="#">
                                            <i class="fas fa-plus"></i> New
                                            <span class="badge bg-primary">{{ \App\Providers\VisaStatusServiceProvider::getByVisaStatus('new') }}</span>
                                        </a>
                                    </li>
                                    @foreach ($visaStatus as $status)
                                    <li class="nav-item">
                                        <a class="nav-link" data-visa_status="{{ $status->id }}" role="tab" href="#">
                                            <i class="fas
                                                @switch($status->id)
                                                    @case(1) fa-plane @break
                                                    @case(2) fa-plane-departure @break
                                                    @case(3) fa-file-medical @break
                                                    @case(4) fa-passport @break
                                                    @case(5) fa-user-shield @break
                                                    @case(6) fa-heartbeat @break
                                                    @case(7) fa-calendar-alt @break
                                                    @case(8) fa-id-card @break
                                                    @case(9) fa-stamp @break
                                                    @case(10) fa-plane-arrival @break
                                                    @case(11) fa-briefcase @break
                                                    @case(12) fa-money-bill @break
                                                    @case(13) fa-times @break
                                                    @case(14) fa-check-circle @break
                                                    @default fa-question-circle
                                                @endswitch
                                            "></i> {{ $status->name }}
                                            <span class="badge bg-primary">{{ \App\Providers\VisaStatusServiceProvider::getByVisaStatus($status->id) }}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="table-responsive" id="employee_table">
                            <div class="preloader">
                                <i class="fas fa-spinner fa-spin"></i> Loading...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@include('../layout.footer')
<script>
    function showPreloader() {
        const preloader = `
            <div id="preloader" class="preloader-container">
                <div class="preloader-content">
                    <div class="spinner"></div>
                    <p>Loading...</p>
                </div>
            </div>
        `;
        $('body').append(preloader);
    }
    function hidePreloader() {
        $('#preloader').remove();
    }
    $('#toggleFilterText').on('click', function() {
        let filterSection = $('#filterSection');
        if (filterSection.is(':visible')) {
            filterSection.slideUp(300);
            $(this).find('span').text('Show Filters');
        } else {
            filterSection.slideDown(300);
            $(this).find('span').text('Hide Filters');
        }
    });
    let currentPackage = 'all';
    let currentVisaStatus = 'new';
    function loadEmployees(page = 1) {
        showPreloader();
        let formData = $('#filter_form').serialize();
        let globalSearch = $('#global_search').val();
        $.ajax({
            url: "{{ route('employees.employee-visa-tracker') }}",
            type: 'GET',
            data: {
                package: currentPackage,
                visa_status: currentVisaStatus,
                filters: formData,
                global_search: globalSearch,
                page: page
            },
            success: function(response) {
                $('#employee_table').html(response);
                hidePreloader();
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                hidePreloader();
            }
        });
    }
    $(document).ready(function() {
        loadEmployees();
        $('#packageTab a, #packageTabs a').on('click', function(e) {
            e.preventDefault();
            $('#packageTab a, #packageTabs a').removeClass('active');
            $(this).addClass('active');
            currentPackage = $(this).data('package') || 'all';
            loadEmployees();
        });
        $('#visaStatusTabs a').on('click', function(e) {
            e.preventDefault();
            $('#visaStatusTabs a').removeClass('active');
            $(this).addClass('active');
            currentVisaStatus = $(this).data('visa_status') || 'new';
            loadEmployees();
        });
        $('#filter_form input, #filter_form select').on('input change', function() {
            loadEmployees();
        });
        $('#global_search, #searchBtn').on('input click', function() {
            loadEmployees();
        });
        $('#clearSearch').on('click', function() {
            $('#global_search').val('');
            loadEmployees();
        });
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let page = 1;
            if (url.indexOf('page=') !== -1) {
                page = url.split('page=')[1].split('&')[0];
            }
            loadEmployees(page);
        });
    });
</script>
