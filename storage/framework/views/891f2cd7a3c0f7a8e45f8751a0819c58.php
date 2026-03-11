<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
        color: #495057;
    }
    .nav-tabs .nav-link:hover {
        background-color: #f8f9fa;
    }
    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: white;
    }
    .no-records img {
        margin-top: 20px;
    }
    .filter-section {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }
    .toggle-filters {
        cursor: pointer;
        color: #007bff;
        font-weight: normal;
        margin: 20px;
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
    .preloader {
        display: none;
        position: absolute;
        left: 40%;
        font-size: 20px;
        color: #007bff;
    }
    .description {
        font-size: 12px;
        color: #343a40;
        margin: 10px 0 10px;
        padding: 10px;
        background-color: #f8f9fa;
        border-left: 5px solid #007bff;
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
</style>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">All Licenses</h5>
                            <a href="<?php echo e(route('licenses.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add License
                            </a>
                        </div>
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs" id="licenseTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-status="all" role="tab">
                                            <i class="fas fa-list"></i> All Licenses
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="expired" role="tab">
                                            <i class="fas fa-times-circle text-danger"></i> Expired
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-status="valid" role="tab">
                                            <i class="fas fa-check-circle text-success"></i> Valid
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search_license" placeholder="Search by Name or Document Number..." aria-label="Search by Name or Document Number">
                                    <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
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

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
    $(document).ready(function() {
        loadLicenses();
        $('#licenseTab a').on('click', function(e) {
            e.preventDefault();
            $('#licenseTab a').removeClass('active');
            $(this).addClass('active');
            var status = $(this).data('status');
            loadLicenses(status);
        });
        $('#search_license').on('input', function() {
            loadLicenses();
        });
        function loadLicenses(status = 'all') {
            $('.preloader').show();
            $.ajax({
                url: "<?php echo e(route('licenses.index')); ?>",
                type: 'GET',
                data: {
                    status: status,
                    search: $('#search_license').val()
                },
                success: function(response) {
                    $('#license_table').html(response);
                    $('.preloader').hide();
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                    $('.preloader').hide();
                }
            });
        }
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/licenses/index.blade.php ENDPATH**/ ?>