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
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Agent Commissions</h5>
                        <div class="filter-section mb-4">
                            <form id="filter_form">
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <input type="text" id="agent_name" name="agent_name" class="form-control" placeholder="Enter Agent Name">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <input type="text" id="cn_number" name="cn_number" class="form-control" placeholder="Enter CN Number">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <select id="status" name="status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="Draft">Draft</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Paid">Paid</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <input type="text" id="incident_ref" name="incident_ref" class="form-control" placeholder="Enter Incident Ref">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <input type="date" id="from_date" name="from_date" class="form-control">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <input type="date" id="to_date" name="to_date" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <div id="agent_commission_table">
                                <div class="text-center py-5">
                                    <i class="fas fa-spinner fa-spin text-primary" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <span class="badge bg-info">Total Credit: <span id="total_credit">0.00</span></span>
                            <span class="badge bg-danger">Total Debit: <span id="total_debit">0.00</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
    $(document).ready(function () {
        loadAgentCommissions();

        $("#filter_form input, #filter_form select").on('keyup change', function () {
            loadAgentCommissions();
        });

        function loadAgentCommissions() {
            let filters = $('#filter_form').serialize();
            $('#agent_commission_table').html('<div class="text-center py-5"><i class="fas fa-spinner fa-spin text-primary" style="font-size: 2rem;"></i></div>');
            $.ajax({
                url: '<?php echo e(route('agents.agent-commission')); ?>',
                method: 'GET',
                data: filters,
                success: function (response) {
                    if (response.status === 'success') {
                        $('#agent_commission_table').html(response.html);
                        $('#total_credit').text(response.totalCredit.toFixed(2));
                        $('#total_debit').text(response.totalDebit.toFixed(2));
                    } else {
                        $('#agent_commission_table').html('<div class="text-center py-5"><p>No records found.</p></div>');
                    }
                },
                error: function () {
                    $('#agent_commission_table').html('<div class="text-center py-5"><p>Error loading data. Please try again.</p></div>');
                }
            });
        }
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/agents/agent_commission.blade.php ENDPATH**/ ?>