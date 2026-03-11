<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main id="main" class="main">
    <div class="pagetitle"><h1>PKG-3 OCA Ledger</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form class="row g-2 mt-2" method="GET" action="<?php echo e(route('finance.employeeOca')); ?>">
                    <div class="col-md-3"><input type="date" name="from" class="form-control" value="<?php echo e(request('from')); ?>"></div>
                    <div class="col-md-3"><input type="date" name="to" class="form-control" value="<?php echo e(request('to')); ?>"></div>
                    <div class="col-md-4">
                        <select name="employee_id" class="form-select">
                            <option value="">All PKG-3</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($e->employee_id); ?>" <?php if(request('employee_id')==$e->employee_id): echo 'selected'; endif; ?>><?php echo e($e->label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-dark w-100" type="submit">Filter</button>
                        <a class="btn btn-outline-secondary w-100" href="<?php echo e(route('finance.employeeOca')); ?>">Reset</a>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Package</th>
                                <th>Date</th>
                                <th>Source</th>
                                <th>Ref</th>
                                <th class="text-end">Debit</th>
                                <th class="text-end">Credit</th>
                                <th class="text-end">Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($r->employee_name); ?></td>
                                    <td><?php echo e($r->package_code); ?></td>
                                    <td><?php echo e($r->journal_date); ?></td>
                                    <td><?php echo e($r->source_type); ?></td>
                                    <td><?php echo e($r->reference_no); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->debit,2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->credit,2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($r->balance_change,2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="8" class="text-center text-muted py-4">No records</td></tr>
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
<?php /**PATH /var/www/developmentoneso-project/resources/views/finance_module/employee_oca.blade.php ENDPATH**/ ?>