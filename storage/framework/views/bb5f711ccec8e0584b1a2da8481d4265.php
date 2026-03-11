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
        position: absolute;
        left: 40%;
        font-size: 20px;
        color: #007bff;
    }
    label{
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
    .remove-filter {
        position: absolute;
        right: 16px;
        top: 75%;
        transform: translateY(-50%);
        color: #dc3545;
        font-size: 18px;
        cursor: pointer;
        display: block;
    }
    .remove-filter-1 {
        position: absolute;
        right: 65px;
        top: 50%;
        transform: translateY(-50%);
        color: #dc3545;
        font-size: 20px;
        cursor: pointer;
        display: block;
    }
    .modal-header.bg-primary {
        background-color: #007bff;
        color: #fff;
    }
    .modal-footer.bg-light {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
    }
    .form-group label {
        font-weight: 500;
        margin-bottom: 10px;
    }
    .form-control {
        border-radius: 6px;
        height: 42px;
    }
    .select2-container {
        width: 100% !important;
        z-index: 9999;
    }
    .select2-container .select2-selection--single {
        height: 42px;
        padding: 6px 12px;
        font-size: 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Manage Agents</h5>
                            <div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAgentModal">
                                    <i class="fas fa-plus-circle"></i> Add Agent
                                </button>
                            </div>
                        </div>
                        <div class="filter-section" id="filterSection">
                            <form id="filter_form">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <input type="text" id="agent_name" name="agent_name" class="form-control" placeholder="Enter Agent Name">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <input type="text" id="company_name" name="company_name" class="form-control" placeholder="Enter Company Name">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <input type="text" id="branch_name" name="branch_name" class="form-control" placeholder="Enter Branch Name">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <select class="form-control" name="country">
                                            <option value="">Select Country</option>
                                            <option value="Ethiopia">Ethiopia</option>
                                            <option value="Sri Lanka">Sri Lanka</option>
                                            <option value="Philippines">Philippines</option>
                                            <option value="India">India</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="Myanmar">Myanmar</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive" id="agents_table">
                            <div class="preloader">
                                <i class="fas fa-spinner fa-spin"></i> Loading...
                            </div>
                            <!-- Dynamic Table Content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal custom-modal fade" id="addAgentModal" tabindex="-1" aria-labelledby="addAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-gradient-primary text-white">
                <h6 class="modal-title" id="addAgentModalLabel">
                    <i class="fas fa-plus-circle me-2"></i> Add New Agent
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addAgentForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="agent_name_form" class="form-label">
                            <i class="fas fa-file-signature me-2 text-primary"></i> Agent Name
                        </label>
                        <input type="text" class="form-control" id="agent_name_form" name="agent_name" placeholder="Enter agent name" required>
                        <div class="invalid-feedback">Agent Name is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="company_name_form" class="form-label">
                            <i class="fas fa-building me-2 text-primary"></i> Company Name
                        </label>
                        <input type="text" class="form-control" id="company_name_form" name="company_name" placeholder="Enter company name" required>
                        <div class="invalid-feedback">Company Name is required.</div>
                    </div>
                    <div class="mb-3">
                        <label for="branch_name_form" class="form-label">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i> Branch Name
                        </label>
                        <input type="text" class="form-control" id="branch_name_form" name="branch_name" placeholder="Enter branch name">
                    </div>
                    <div class="mb-3">
                        <label for="country_form" class="form-label">
                            <i class="fas fa-globe me-2 text-primary"></i> Country
                        </label>
                        <select class="form-control" id="country_form" name="country" required>
                            <option value="">Select Country</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Philippines">Philippines</option>
                            <option value="India">India</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Myanmar">Myanmar</option>
                        </select>
                        <div class="invalid-feedback">Country is required.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times-circle me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="saveAgentBtn">
                        <i class="fas fa-save me-1"></i> Add Agent
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
    $(document).ready(function () {
        loadAgents(); // Initial load
        $('#filter_form').on('input change', function () {
            loadAgents();
        });

        $(document).on('click', '#saveAgentBtn', function () {
            saveAgent();
        });

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            const url = $(this).attr('href');
            loadAgents(url);
        });

        function loadAgents(url = '<?php echo e(route("agents.index")); ?>') {
            const formData = $('#filter_form').serialize();
            const hasFilters = formData.trim().length > 0;
            $('.preloader').show();

            $.ajax({
                url: url,
                type: 'GET',
                data: hasFilters ? formData : {}, 
                success: function (response) {
                    if (response.status === 'success') {
                        $('#agents_table').html(response.html);
                    } else {
                        toastr.error('Failed to load agents.');
                    }
                },
                error: function (xhr) {
                    const message = xhr.responseJSON?.message || 'Error loading agents.';
                    toastr.error(message);
                },
                complete: function () {
                    $('.preloader').hide();
                }
            });
        }

        function saveAgent() {
            $('.is-invalid').removeClass('is-invalid'); 
            const data = {
                name: $('#agent_name_form').val(),
                company_name: $('#company_name_form').val(),
                branch_name: $('#branch_name_form').val(),
                country: $('#country_form').val(),
                _token: $('input[name="_token"]').val(),
            };

            $.ajax({
                url: '<?php echo e(route("agents.store")); ?>',
                method: 'POST',
                data: data,
                success: function () {
                    toastr.success('Agent added successfully!');
                    $('#addAgentForm')[0].reset();
                    $('#addAgentModal').modal('hide');
                    loadAgents(); // Reload agents
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON.errors || {};
                    handleValidationErrors(errors);
                    toastr.error('Failed to add the agent.');
                }
            });
        }

        function handleValidationErrors(errors) {
            if (errors.name) {
                $('#agent_name_form').addClass('is-invalid').next('.invalid-feedback').text(errors.name[0]);
            }
            if (errors.company_name) {
                $('#company_name_form').addClass('is-invalid').next('.invalid-feedback').text(errors.company_name[0]);
            }
            if (errors.country) {
                $('#country_form').addClass('is-invalid').next('.invalid-feedback').text(errors.country[0]);
            }
        }
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/agents/index.blade.php ENDPATH**/ ?>