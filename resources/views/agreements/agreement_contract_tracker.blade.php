@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        font-family: Arial, sans-serif;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .nav-tabs .nav-link {
        color: #495057;
        transition: background-color 0.2s;
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
    .description {
        font-size: 12px;
        color: #343a40;
        margin: 10px 0;
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
    .preloader {
        display: none;
        position: absolute;
        left: 40%;
        font-size: 20px;
        color: #007bff;
    }
</style>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <p class="description mb-0">Manage your agreement records. Use the filters below to find specific records quickly.</p>
                            <button class="btn btn-secondary" id="toggleFilterBtn">
                                <i class="fas fa-filter"></i> Filters
                            </button>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="filter-section" id="filterSection" style="display: none;">
                            <form id="filter_form">
                                <div class="row">
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="text" id="customer_number" name="customer_number" class="form-control" placeholder="Customer Number">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="text" id="client_number" name="client_number" class="form-control" placeholder="Client Number">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="date" id="from_date" name="from_date" class="form-control" placeholder="From Date">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="date" id="to_date" name="to_date" class="form-control" placeholder="To Date">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row mb-3 mt-3">
                            <div class="col-lg-8">
                                <ul class="nav nav-tabs" id="agreementTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-status="all" role="tab">
                                            <i class="fas fa-file-contract"></i> All
                                            <span class="badge bg-primary">0</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="package2" role="tab">
                                            <i class="fas fa-box"></i> Package 2
                                            <span class="badge bg-primary">0</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="package2" role="tab">
                                            <i class="fas fa-box-open"></i> Package 3
                                            <span class="badge bg-primary">0</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="package3" role="tab">
                                            <i class="fas fa-archive"></i> Package 4
                                            <span class="badge bg-primary">0</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4 d-flex justify-content-end">
                                <div class="input-group" style="max-width: 300px;">
                                    <input type="text" class="form-control" id="global_search" placeholder="Search by Customer , client or agreement #">
                                    <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="agreement_table">
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
    $(document).ready(function () {
        let currentPackage = 'all';
        function loadAgreements(page = 1) {
            $('.preloader').show();
            let formData = $('#filter_form').serialize();
            let globalSearch = $('#global_search').val();
            let status = currentPackage;
            $.ajax({
                url: "{{ route('agreements.agreement-contract-tracker') }}",
                type: 'GET',
                data: {
                    status: status !== 'all' ? status : undefined,
                    global_search: globalSearch,
                    filters: formData,
                    page: page
                },
                success: function (response) {
                    $('#agreement_table').html(response.trim() ? response : '<p class="text-center">No records found.</p>');
                    $('.preloader').hide();
                },
                error: function () {
                    $('#agreement_table').html('<p class="text-center text-danger">Failed to load data. Please try again later.</p>');
                    $('.preloader').hide();
                }
            });
        }
        loadAgreements();
        $('#agreementTab a').on('click', function (e) {
            e.preventDefault();
            $('#agreementTab a').removeClass('active');
            $(this).addClass('active');
            currentPackage = $(this).data('status');
            loadAgreements();
        });
        $('#global_search, #searchBtn').on('input click', function () {
            loadAgreements();
        });
        $('#clearSearch').on('click', function () {
            $('#global_search').val('');
            loadAgreements();
        });
        $('#filter_form input').on('input', function () {
            loadAgreements();
        });
        $('#toggleFilterBtn').on('click', function() {
            $('#filterSection').slideToggle(300);
        });
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let page = 1;
            if (url.indexOf('page=') !== -1) {
                page = url.split('page=')[1].split('&')[0];
            }
            loadAgreements(page);
        });
    });
</script>
