<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main id="main" class="main">
    <div class="pagetitle"><h1>Open AR</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form class="row g-2 mt-2" method="GET" action="<?php echo e(route('finance.openAr')); ?>">
                    <div class="col-md-6"><input type="text" name="customer" class="form-control" placeholder="Customer name..." value="<?php echo e(request('customer')); ?>"></div>
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-dark w-100" type="submit">Search</button>
                        <a class="btn btn-outline-secondary w-100" href="<?php echo e(route('finance.openAr')); ?>">Reset</a>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>CL #</th>
                                <th class="text-end">Invoiced</th>
                                <th class="text-end">Received</th>
                                <th class="text-end">Open</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($r->customer_name); ?></td>
                                    <td><?php echo e($r->cl_number); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->total_invoiced,2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->total_received,2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->open_balance,2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">No open balances</td></tr>
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
<?php /**PATH /var/www/developmentoneso-project/resources/views/finance_module/open_ar.blade.php ENDPATH**/ ?>