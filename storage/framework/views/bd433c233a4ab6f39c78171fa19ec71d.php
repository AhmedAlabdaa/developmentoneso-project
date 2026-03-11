<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main id="main" class="main">
    <div class="pagetitle"><h1>Posting Errors</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Source</th>
                                <th>Table</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($r->created_at); ?></td>
                                    <td><?php echo e($r->source_type); ?></td>
                                    <td><?php echo e($r->table_name); ?></td>
                                    <td><?php echo e($r->message); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="text-center text-muted py-4">No errors</td></tr>
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
<?php /**PATH /var/www/developmentoneso-project/resources/views/finance_module/errors.blade.php ENDPATH**/ ?>