<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        font-family: Arial, sans-serif;
    }

    .report-panel {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.08);
        padding: 14px;
        position: relative;
        margin: 12px 0 18px;
    }

    .report-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .page-title {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #1b2a4a;
    }

    .export-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        justify-content: flex-end;
    }

    .btn-export {
        border: none;
        color: #fff;
        padding: 7px 10px;
        border-radius: 10px;
        font-size: 11px;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        transition: transform .05s ease-in-out, opacity .1s ease-in-out;
    }
    .btn-export i { font-size: 12px; }
    .btn-export:active { transform: scale(0.98); }
    .btn-export:hover { opacity: 0.95; }

    .g-primary { background: linear-gradient(to right, #007bff, #00c6ff); }
    .g-pkg1   { background: linear-gradient(to right, #6f42c1, #b17cff); }
    .g-pkg2   { background: linear-gradient(to right, #198754, #2fd18b); }
    .g-pkg3   { background: linear-gradient(to right, #fd7e14, #ffb26b); }
    .g-pkg4   { background: linear-gradient(to right, #0dcaf0, #6ee7ff); }
    .g-all    { background: linear-gradient(to right, #343a40, #6c757d); }
    .g-nc     { background: linear-gradient(to right, #dc3545, #ff6b6b); }

    .preloader {
        display: none;
        position: absolute;
        left: 40%;
        top: 16px;
        font-size: 18px;
        color: #007bff;
        z-index: 10;
    }

    .empty-state {
        background: #fff;
        border: 1px dashed #cfe0ff;
        padding: 22px;
        border-radius: 12px;
        text-align: center;
        color: #5b6b86;
        font-size: 13px;
    }
</style>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="report-panel">
                    <div class="report-header">
                        <h5 class="page-title">
                            <i class="fas fa-chart-line"></i> Customer Report
                        </h5>

                        <div class="export-row">
                            <button class="btn-export g-primary export-action" data-export="current" type="button">
                                <i class="fas fa-filter"></i> Current
                            </button>
                            <button class="btn-export g-pkg1 export-action" data-export="pkg1" type="button">
                                <i class="fas fa-box"></i> PKG-1
                            </button>
                            <button class="btn-export g-pkg2 export-action" data-export="pkg2" type="button">
                                <i class="fas fa-box-open"></i> PKG-2
                            </button>
                            <button class="btn-export g-pkg3 export-action" data-export="pkg3" type="button">
                                <i class="fas fa-cubes"></i> PKG-3
                            </button>
                            <button class="btn-export g-pkg4 export-action" data-export="pkg4" type="button">
                                <i class="fas fa-layer-group"></i> PKG-4
                            </button>
                            <button class="btn-export g-all export-action" data-export="all_packages" type="button">
                                <i class="fas fa-boxes-stacked"></i> All
                            </button>
                            <button class="btn-export g-nc export-action" data-export="no_contract" type="button">
                                <i class="fas fa-file-circle-xmark"></i> No Contract
                            </button>
                        </div>
                    </div>

                    <div class="preloader" id="customerPreloader">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>

                    <div id="customer_table">
                        <div class="empty-state">
                            <i class="fas fa-table" style="font-size:22px;"></i>
                            <div class="mt-2">Loading current view...</div>
                        </div>
                    </div>
                </div>

                <iframe id="downloadFrame" style="display:none;"></iframe>

            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
    $(document).ready(function () {
        const DEFAULT_EXPORT = 'current';

        loadResults(DEFAULT_EXPORT);

        $('.export-action').on('click', function () {
            const exportType = $(this).data('export');
            loadResults(exportType);
            startDownload(exportType);
        });

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const exportType = $('#customer_table').data('export') || DEFAULT_EXPORT;
            loadResults(exportType, url);
        });

        function loadResults(exportType, url = null) {
            $('#customerPreloader').show();
            const endpoint = url || "<?php echo e(route('reports.customer.table')); ?>";

            $.ajax({
                url: endpoint,
                type: 'GET',
                data: { export: exportType },
                success: function (response) {
                    $('#customer_table').data('export', exportType).html(response);
                    $('#customerPreloader').hide();
                },
                error: function () {
                    $('#customerPreloader').hide();
                }
            });
        }

        function startDownload(exportType) {
            const exportUrl = "<?php echo e(route('reports.customer.export')); ?>"
                + '?export=' + encodeURIComponent(exportType);

            $('#downloadFrame').attr('src', exportUrl);
        }
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/reports/customer.blade.php ENDPATH**/ ?>