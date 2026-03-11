<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main id="main" class="main">
    <div class="pagetitle"><h1>VAT Detail</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form class="row g-2 mt-2" method="GET" action="<?php echo e(route('finance.vatDetail')); ?>">
                    <div class="col-md-3"><input type="date" name="from" class="form-control" value="<?php echo e(request('from')); ?>"></div>
                    <div class="col-md-3"><input type="date" name="to" class="form-control" value="<?php echo e(request('to')); ?>"></div>
                    <div class="col-md-4"><input type="text" name="ref" class="form-control" placeholder="Invoice ref..." value="<?php echo e(request('ref')); ?>"></div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-dark w-100" type="submit">Filter</button>
                        <a class="btn btn-outline-secondary w-100" href="<?php echo e(route('finance.vatDetail')); ?>">Reset</a>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Ref</th>
                                <th class="text-end">Net</th>
                                <th class="text-end">VAT</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($r->journal_date); ?></td>
                                    <td><?php echo e($r->reference_no); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->net_amount,2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->vat_amount,2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->total_amount,2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">No records</td></tr>
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
<?php /**PATH /var/www/developmentoneso-project/resources/views/finance_module/vat_detail.blade.php ENDPATH**/ ?>