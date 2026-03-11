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
        font-size: 14px;
        color: #343a40;
        margin: 10px 0 10px;
        padding: 10px;
        background-color: #f8f9fa;
        border-left: 5px solid #007bff;
    }

    label {
        font-size: 14px;
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
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Government Services</h5>
                            <a data-bs-toggle="modal" data-bs-target="#addGovernmentServices" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Services
                            </a>
                        </div>

                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="row mb-3 mt-3">
                            <div class="col-md-8">
                                <ul class="nav nav-tabs" id="transactionTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-status="all" role="tab">
                                            <i class="fas fa-file-contract"></i> All Services
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search_by_service_name" placeholder="Search by Service Name...">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive" id="transaction_table">
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
<div class="modal fade" id="addGovernmentServices" tabindex="-1" aria-labelledby="addGovernmentServicesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addGovernmentServicesLabel">
                    <i class="fas fa-plus-circle"></i> Add Government Service
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addGovernmentServiceForm" method="post">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="service_name"><i class="fas fa-file-alt"></i> Service Name</label>
                            <input type="text" id="service_name" name="service_name" class="form-control" placeholder="Enter service name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="typing_fee"><i class="fas fa-dollar-sign"></i> Typing Fee</label>
                            <input type="number" id="typing_fee" name="typing_fee" class="form-control" placeholder="Enter typing fee" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="total_vat"><i class="fas fa-percentage"></i> VAT</label>
                            <input type="number" id="total_vat" name="total_vat" class="form-control" placeholder="Enter VAT" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="govt_fee"><i class="fas fa-dollar-sign"></i> Government Fee</label>
                            <input type="number" id="govt_fee" name="govt_fee" class="form-control" placeholder="Enter government fee" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="total_govt_fee"><i class="fas fa-money-bill-wave"></i> Total Government Fee</label>
                            <input type="number" id="total_govt_fee" name="total_govt_fee" class="form-control" placeholder="Enter total government fee" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="line_total"><i class="fas fa-calculator"></i> Line Total</label>
                            <input type="number" id="line_total" name="line_total" class="form-control" placeholder="Enter line total" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" id="save_service" class="btn btn-success">
                    <i class="fas fa-save"></i> Save Service
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
    $(document).ready(function () {
        loadTransactions('all');
        $('.nav-tabs a').on('click', function (e) {
            e.preventDefault();
            $('.nav-tabs a').removeClass('active');
            $(this).addClass('active');
            loadTransactions($(this).data('status'));
        });

        $('#search_by_service_name').on('input', function () {
            loadTransactions($('.nav-tabs a.active').data('status'));
        });

        function loadTransactions(status = 'all', page = 1) {
            const requestData = {
                status: status !== 'all' ? status : undefined,
                name: $('#search_by_service_name').val(),
                page: page 
            };

            $('.preloader').show();

            $.ajax({
                url: "<?php echo e(route('agreements.govt-services')); ?>",
                type: 'GET',
                data: requestData,
                success: function (response) {
                    if (response.trim()) {
                        $('#transaction_table').html(response);
                        $('#transaction_table .pagination a').on('click', function (e) {
                            e.preventDefault();
                            const url = $(this).attr('href');
                            const params = new URLSearchParams(url.split('?')[1]);
                            const page = params.get('page') || 1;

                            loadTransactions(status, page);
                        });
                    } else {
                        $('#transaction_table').html('<p class="text-center">No records found.</p>');
                    }
                    $('.preloader').hide();
                },
                error: function () {
                    $('#transaction_table').html('<p class="text-center text-danger">Failed to load transactions. Please try again later.</p>');
                    $('.preloader').hide();
                }
            });
        }

        $('#typing_fee').on('input', function () {
            const typingFee = parseFloat($(this).val()) || 0;
            const vat = typingFee * 0.05;
            $('#total_vat').val(vat.toFixed(2));
        });

        $('#govt_fee').on('input', function () {
            const govtFee = parseFloat($(this).val()) || 0;
            $('#total_govt_fee').val(govtFee.toFixed(2));
            $('#line_total').val(govtFee.toFixed(2));
        });

        $('#save_service').on('click', function () {
            const formData = {
                service_name: $('#service_name').val(),
                typing_fee: $('#typing_fee').val(),
                govt_fee: $('#govt_fee').val(),
                total_vat: $('#total_vat').val(),
                total_govt_fee: $('#total_govt_fee').val(),
                line_total: $('#line_total').val(),
                _token: '<?php echo e(csrf_token()); ?>'
            };

            $.ajax({
                url: ' ',
                type: 'POST',
                data: formData,
                success: function () {
                    toastr.success('Service added successfully!');
                    $('#addGovernmentServices').modal('hide');
                    loadTransactions('all');
                },
                error: function () {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/agreements/govt_services.blade.php ENDPATH**/ ?>