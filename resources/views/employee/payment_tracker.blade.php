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
    .filter-section {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .table-responsive {
        margin-top: 20px;
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
    .btn-primary {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        border: none;
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
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h5 class="card-title">Employee Payment Tracker</h5>
                        <div class="filter-section" id="trackerFilterSection">
                            <form id="tracker_filter_form">
                                <div class="row">
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="text" id="tracker_global_search" name="global_search" class="form-control" placeholder="Search by Employee Name or Passport No">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <select id="tracker_package" name="package" class="form-control">
                                            <option value="">All Packages</option>
                                            <option value="PKG-1">PKG-1</option>
                                            <option value="PKG-2">PKG-2</option>
                                            <option value="PKG-3">PKG-3</option>
                                            <option value="PKG-4">PKG-4</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <input type="date" id="tracker_contract_start_date" name="contract_start_date" class="form-control" placeholder="Contract Start Date">
                                    </div>
                                    <div class="col-md-3 form-group mb-2">
                                        <button type="button" id="tracker_search_btn" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive" id="payment_tracker_table">
                            <!-- Payment Tracker table will be loaded here via AJAX -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@include('layout.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
function loadPaymentTracker(page = 1) {
    showPreloader();
    let formData = $('#tracker_filter_form').serialize();
    $.ajax({
        url: "{{ route('employee.payment.tracker') }}",
        type: 'GET',
        data: formData + '&page=' + page,
        success: function(response) {
            $('#payment_tracker_table').html(response);
            hidePreloader();
        },
        error: function(xhr, status, error) {
            console.error(xhr);
            hidePreloader();
        }
    });
}
$(document).ready(function() {
    loadPaymentTracker();
    $('#tracker_search_btn').on('click', function() {
        loadPaymentTracker();
    });
    $('#tracker_filter_form input, #tracker_filter_form select').on('input change', function() {
        loadPaymentTracker();
    });
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let page = 1;
        if (url.indexOf('page=') !== -1) {
            page = url.split('page=')[1].split('&')[0];
        }
        loadPaymentTracker(page);
    });
});
</script>
