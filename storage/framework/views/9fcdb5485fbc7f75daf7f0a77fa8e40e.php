<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main id="main" class="main">
    <div class="pagetitle"><h1>VAT Report</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <div class="d-flex gap-2 mt-2">
                    <a class="btn btn-primary" href="<?php echo e(route('finance.vatDetail')); ?>">VAT Detail</a>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Period</th>
                                <th class="text-end">VAT Output</th>
                                <th class="text-end">Revenue</th>
                                <th class="text-end">Invoices</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($r->period); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->vat_output,2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->revenue,2)); ?></td>
                                    <td class="text-end"><?php echo e($r->invoices); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="text-center text-muted py-4">No records</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php echo e($rows->links('vendor.pagination.bootstrap-4')); ?>


            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/finance_module/vat.blade.php ENDPATH**/ ?>