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
    .filter-section {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        margin-top: 20px; 
    }
    .toggle-filters {
        cursor: pointer;
        margin-left: auto;
        color: #007bff;
        font-weight: normal;
        margin:20px;
    }
    .table-responsive {
        margin-top: 20px;
    }
    .btn {
        transition: background-color 0.2s, color 0.2s;
    }
    .btn:hover {
        background-color: #007bff;
        color: white;
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
    .table tfoot th {
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
    .btn-primary {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
        border: none;
    }
</style>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">All Incidents</h5>
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
                                    Manage your incident records efficiently. Use the filters below to find specific incidents quickly.
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
                                    <div class="col-md-3 form-group">
                                        <label for="incident_category"><i class="fas fa-tags"></i> Incident Category</label>
                                        <input type="text" id="incident_category" name="incident_category" class="form-control" placeholder="Enter category">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="candidate_name"><i class="fas fa-user"></i> Candidate Name</label>
                                        <input type="text" id="candidate_name" name="candidate_name" class="form-control" placeholder="Enter candidate name">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="incident_reason"><i class="fas fa-info-circle"></i> Reason</label>
                                        <input type="text" id="incident_reason" name="incident_reason" class="form-control" placeholder="Enter reason">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs" id="statusTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-status="all" role="tab">
                                            <i class="fas fa-list"></i> All Incidents
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="ibv" role="tab">
                                            <i class="fas fa-file-alt"></i> Incident Before Visa (IBV)
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="iav" role="tab">
                                            <i class="fas fa-passport"></i> Incident After Visa (IAV)
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="iad" role="tab">
                                            <i class="fas fa-plane-departure"></i> Incident After Departure (IAD)
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="iaa" role="tab">
                                            <i class="fas fa-plane-arrival"></i> Incident After Arrival (IAA)
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search_incident_ref" placeholder="Search by Incident Ref..." aria-label="Search by Incident Ref">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="incident_table">
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
    document.getElementById('toggleFilterText').addEventListener('click', function() {
        const filterSection = document.getElementById('filterSection');
        if (filterSection.style.display === 'none' || filterSection.style.display === '') {
            filterSection.style.display = 'block';
            $(filterSection).hide().slideDown(300);
            this.querySelector('span').textContent = 'Hide Filters';
        } else {
            $(filterSection).slideUp(300, function() {
                filterSection.style.display = 'none';
            });
            this.querySelector('span').textContent = 'Show Filters';
        }
    });

    $(document).ready(function() {
        loadIncidents();

        $('#statusTab a').on('click', function(e) {
            e.preventDefault();
            $('#statusTab a').removeClass('active');
            $(this).addClass('active');
            var status = $(this).data('status');
            loadIncidents(status);
        });

        $('#filter_form input, #filter_form select').on('keyup change', function() {
            loadIncidents();
        });

        $('#search_incident_ref').on('keyup', function() {
            loadIncidents();
        });

        $('.btn-outline-secondary').on('click', function() {
            loadIncidents();
        });

        function loadIncidents(status = 'all') {
            var formData = $('#filter_form').serialize();
            var incidentRef = $('#search_incident_ref').val(); 
            $('.preloader').show();

            if (status === 'all') {
                $.ajax({
                    url: '{{ route("incidents.index") }}',
                    type: 'GET',
                    data: formData + (incidentRef ? '&incident_ref=' + incidentRef : ''), 
                    success: function(data) {
                        $('#incident_table').html(data);
                        $('.preloader').hide();
                    },
                    error: function() {
                        $('.preloader').hide();
                    }
                });
            } else {
                $.ajax({
                    url: '{{ route("incidents.index") }}',
                    type: 'GET',
                    data: formData + '&status=' + status + (incidentRef ? '&incident_ref=' + incidentRef : ''),
                    success: function(data) {
                        $('#incident_table').html(data);
                        $('.preloader').hide();
                    },
                    error: function() {
                        $('.preloader').hide();
                    }
                });
            }
        }
    });
</script>
