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
.status-icon {
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
.pagination .page-item:first-child .page-link {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}
.pagination .page-item:last-child .page-link {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}
.pagination .page-item .page-link {
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.preloader {
    display: none;
}
label {
    font-size: 12px;
}
.btn-primary {
    background: linear-gradient(to right, #007bff, #00c6ff);
    color: white;
    text-align: center;
    font-weight: normal;
    border: none;
}
.btn-csv-upload {
    background: linear-gradient(to right, #00c6ff, #6a11cb);
    color: white;
    text-align: center;
    font-weight: normal;
    border: none;
    transition: background-color 0.2s, color 0.2s;
    font-size: 12px;
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
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">All Staff</h5>
                            <div>
                                <a href="{{ route('staff.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i> Add Staff Member
                                </a>
                                <a href="{{ route('staff.upload-staff-csv-file') }}" class="btn btn-csv-upload">
                                    <i class="fas fa-upload"></i> Upload CSV File
                                </a>
                            </div>
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
                                    Manage your staff records efficiently. Use the filters below to find specific staff members quickly.
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
                                        <label for="reference_no"><i class="fas fa-clipboard"></i> Reference #</label>
                                        <input type="text" id="reference_no" name="reference_no" class="form-control" placeholder="Enter Reference No">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="name_of_staff"><i class="fas fa-user"></i> Name</label>
                                        <input type="text" id="name_of_staff" name="name_of_staff" class="form-control" placeholder="Enter staff name">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="nationality"><i class="fas fa-flag"></i> Nationality</label>
                                        <input type="text" id="nationality" name="nationality" class="form-control" placeholder="Enter Nationality">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="passport_no"><i class="fas fa-passport"></i> Passport No</label>
                                        <input type="text" id="passport_no" name="passport_no" class="form-control" placeholder="Enter passport number">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="passport_expiry_date"><i class="fas fa-calendar-alt"></i> Passport Expiry Date</label>
                                        <input type="date" id="passport_expiry_date" name="passport_expiry_date" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="status"><i class="fas fa-circle"></i> Status</label>
                                        <select id="status" name="status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="AVAILABLE">Available</option>
                                            <option value="HOLD">Hold</option>
                                            <option value="SELECTED">Selected</option>
                                            <option value="WC-DATE">WC-Date</option>
                                            <option value="VISA DATE">Visa Date</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="date_of_joining"><i class="fas fa-calendar-check"></i> Date of Joining</label>
                                        <input type="date" id="date_of_joining" name="date_of_joining" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="actual_designation"><i class="fas fa-briefcase"></i> Designation</label>
                                        <input type="text" id="actual_designation" name="actual_designation" class="form-control" placeholder="Enter designation">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs" id="statusTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-status="all" role="tab">
                                            <i class="fas fa-list"></i> All Staff
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="AVAILABLE" role="tab">
                                            <i class="fas fa-check-circle text-success"></i> Available
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="HOLD" role="tab">
                                            <i class="fas fa-pause-circle text-warning"></i> Hold
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="SELECTED" role="tab">
                                            <i class="fas fa-star text-info"></i> Selected
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="WC-DATE" role="tab">
                                            <i class="fas fa-calendar-alt text-primary"></i> WC-Date
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="VISA DATE" role="tab">
                                            <i class="fas fa-passport text-danger"></i> Visa Date
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="emirates_id_number" name="emirates_id_number" placeholder="Search by Emirates ID..." aria-label="Search by Emirates ID">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="staff_table"></div>
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
    $('#preloader').css({
        position: 'fixed',
        top: '0',
        left: '0',
        width: '100%',
        height: '100%',
        backgroundColor: 'rgba(255, 255, 255, 0.8)',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        zIndex: '1050'
    });
    $('.preloader-content .spinner').css({
        width: '50px',
        height: '50px',
        border: '6px solid rgba(0, 0, 0, 0.1)',
        borderTopColor: '#007bff',
        borderRadius: '50%',
        animation: 'spin 1s linear infinite',
        marginBottom: '10px'
    });
    $('.preloader-content p').css({
        fontSize: '1rem',
        color: '#007bff',
        fontWeight: 'bold',
        textAlign: 'center'
    });
    const spinnerKeyframes = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    const styleTag = document.createElement('style');
    styleTag.textContent = spinnerKeyframes;
    document.head.appendChild(styleTag);
}
function hidePreloader() {
    $('#preloader').remove();
}
$(document).ready(function() {
    loadStaff();
    $('#toggleFilterText').on('click', function() {
        const filterSection = $('#filterSection');
        if (filterSection.is(':hidden')) {
            filterSection.slideDown(300);
            $(this).find('span').text('Hide Filters');
        } else {
            filterSection.slideUp(300);
            $(this).find('span').text('Show Filters');
        }
    });
    $('#statusTab a').on('click', function(e) {
        e.preventDefault();
        $('#statusTab a').removeClass('active');
        $(this).addClass('active');
        var status = $(this).data('status');
        loadStaff(status);
    });
    $('#filter_form input, #filter_form select').on('keyup change', function() {
        loadStaff();
    });
    $('#emirates_id_number').on('keyup', function() {
        loadStaff();
    });
    $('.btn-outline-secondary').on('click', function() {
        loadStaff();
    });
    function loadStaff(status = 'all') {
        var formData = $('#filter_form').serialize();
        var emiratesId = $('#emirates_id_number').val();
        showPreloader();
        var dataString = formData + (emiratesId ? '&emirates_id_number=' + emiratesId : '');
        if (status !== 'all') {
            dataString += '&status=' + status;
        }
        $.ajax({
            url: '{{ route("staff.index") }}',
            type: 'GET',
            data: dataString,
            success: function(data) {
                $('#staff_table').html(data);
                hidePreloader();
            },
            error: function() {
                hidePreloader();
            }
        });
    }
});
</script>
