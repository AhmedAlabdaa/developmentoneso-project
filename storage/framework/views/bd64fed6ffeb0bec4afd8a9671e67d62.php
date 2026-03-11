<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Reference&nbsp;#</th>
                <th>Payroll&nbsp;Type</th>
                <th>Payroll Period</th>
                <th>No. of Candidates</th>
                <th>Total&nbsp;Amount</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('payrolls.payroll-sheet', $payroll->reference_no)); ?>" class="text-decoration-none">
                            <?php echo e($payroll->reference_no); ?>

                        </a>
                    </td>

                    <td><?php echo e($payroll->type ?? 'N/A'); ?></td>

                    <td>
                        <?php echo e(\Carbon\Carbon::parse($payroll->pay_period_start)->format('d M Y')); ?>

                        &ndash;
                        <?php echo e(\Carbon\Carbon::parse($payroll->pay_period_end)->format('d M Y')); ?>

                    </td>

                    <td><?php echo e($payroll->number_of_candidates); ?></td>

                    <td><?php echo e(number_format($payroll->total_amount, 2)); ?></td>

                    <td class="text-center">
                        <a  href="<?php echo e(route('payrolls.payroll-sheet', $payroll->reference_no)); ?>"
                            class="btn btn-info btn-icon-only"  title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">No payroll records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>

        <tfoot>
            <tr>
                <th>Reference&nbsp;#</th>
                <th>Payroll&nbsp;Type</th>
                <th>Payroll Period</th>
                <th>No. of Candidates</th>
                <th>Total&nbsp;Amount</th>
                <th class="text-center">Action</th>
            </tr>
        </tfoot>
    </table>
</div>

<?php if($payrolls->hasPages()): ?>
    <nav aria-label="Pagination">
        <div class="pagination-container">
            <span class="muted-text">
                Showing <?php echo e($payrolls->firstItem()); ?>-<?php echo e($payrolls->lastItem()); ?> of <?php echo e($payrolls->total()); ?>

            </span>

            <ul class="pagination justify-content-center">
                <?php echo e($payrolls->appends(request()->except('page'))
                             ->links('vendor.pagination.bootstrap-4')); ?>

            </ul>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/partials/payroll_table.blade.php ENDPATH**/ ?>