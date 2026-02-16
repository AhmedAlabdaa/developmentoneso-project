@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style type="text/css">
    body {
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        font-family: Arial, sans-serif;
    }
    .table th, .table td {
        vertical-align: middle;
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
    .no-records {
        margin: 20px 0; 
    }
    .no-records img {
        margin-top: 20px;
    }
    .filter-section {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        margin-top: 20px; 
    }
    .filter-section .form-group {
        margin-bottom: 1rem;
    }
    .toggle-filters {
        cursor: pointer;
        margin-left: auto;
        color: #007bff;
        font-weight: normal;
        margin:20px;
    }
    .toggle-filters:hover {
        text-decoration: underline;
    }
    .table-responsive {
        margin-top: 20px;
    }
    .btn {
        transition: background-color 0.2s, color 0.2s;
    }
    .btn-primary {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
        border:none;
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
    .table thead th {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
    }
    .preloader {
        display: none;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-size: 20px;
        color: #007bff;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">All Licenses</h5>
                            <a href="{{ route('licenses.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add License
                            </a>
                        </div>
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
                                    Manage licenses efficiently. Use the filters below to find specific licenses quickly.
                                </p>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mt-2">
                                    <input type="text" class="form-control" id="search_by_name" placeholder="Search by License Name..." aria-label="Search by License Name">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="license_table">
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
    $(document).ready(function() {
        loadLicenses();
        $('#search_by_name').on('keyup', function() {
            loadLicenses(); 
        });

        $('.btn-outline-secondary').on('click', function() {
            loadLicenses(); 
        });

        function loadLicenses() {
            var searchQuery = $('#search_by_name').val(); 
            $('.preloader').show(); 

            $.ajax({
                url: '{{ route("licenses.load") }}', 
                type: 'GET',
                data: {
                    search: searchQuery 
                },
                success: function(data) {
                    $('#license_table').html(data); 
                    $('.preloader').hide(); 
                },
                error: function() {
                    $('.preloader').hide(); 
                }
            });
        }
    });
</script>
