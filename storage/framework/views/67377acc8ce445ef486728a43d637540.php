<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Finance Module</h1>
    </div>

    <section class="section">
        <div class="row g-3">
            <div class="col-md-4">
                <a class="card text-decoration-none" href="<?php echo e(route('finance.journalEntries')); ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Journal Entries</h5>
                        <div class="text-muted">All postings (Invoices, Receipts, Reversals)</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card text-decoration-none" href="<?php echo e(route('finance.trialBalance')); ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Trial Balance</h5>
                        <div class="text-muted">Debit/Credit totals by account</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card text-decoration-none" href="<?php echo e(route('finance.openAr')); ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Open AR</h5>
                        <div class="text-muted">Outstanding customer balances</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card text-decoration-none" href="<?php echo e(route('finance.customerLedger')); ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Customer Ledger</h5>
                        <div class="text-muted">AR statement with running balance</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card text-decoration-none" href="<?php echo e(route('finance.employeeOca')); ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-1">PKG-3 OCA Ledger</h5>
                        <div class="text-muted">Advances/Medical/Air Ticket tracking</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card text-decoration-none" href="<?php echo e(route('finance.vat')); ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-1">VAT Report</h5>
                        <div class="text-muted">VAT Output + Revenue summaries</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card text-decoration-none" href="<?php echo e(route('finance.errors')); ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Posting Errors</h5>
                        <div class="text-muted">Fix issues without breaking posting</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card text-decoration-none" href="<?php echo e(url('invoice-services')); ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Invoice Services</h5>
                        <div class="text-muted">Manage service items and pricing</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card text-decoration-none" href="<?php echo e(url('ledgers')); ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Ledger of Accounts</h5>
                        <div class="text-muted">Chart of accounts management</div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a class="card text-decoration-none" href="<?php echo e(url('receipt-vouchers')); ?>">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Receipt Vouchers</h5>
                        <div class="text-muted">Manage receipt vouchers and payments</div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /home/developmentoneso/public_html/resources/views/finance_module/index.blade.php ENDPATH**/ ?>