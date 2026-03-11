<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main id="main" class="main">
    <div class="pagetitle"><h1>Journal Entries</h1></div>

    <section class="section">
        <div class="card">
            <div class="card-body">

                <form class="row g-2 mt-2" method="GET" action="<?php echo e(route('finance.journals')); ?>">
                    <div class="col-md-2">
                        <input type="date" name="from" class="form-control" value="<?php echo e(request('from')); ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="to" class="form-control" value="<?php echo e(request('to')); ?>">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="source_type">
                            <option value="">All Sources</option>
                            <?php $__currentLoopData = ['TAX_INVOICE','TAX_RECEIPT','TAX_INVOICE_REV']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>" <?php if(request('source_type')==$s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="ref" class="form-control" placeholder="Reference..." value="<?php echo e(request('ref')); ?>">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-dark w-100" type="submit">Filter</button>
                        <a class="btn btn-outline-secondary w-100" href="<?php echo e(route('finance.journals')); ?>">Reset</a>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Source</th>
                                <th>Ref</th>
                                <th>Memo</th>
                                <th class="text-end">Debit</th>
                                <th class="text-end">Credit</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($j->journal_date); ?></td>
                                    <td><?php echo e($j->source_type); ?></td>
                                    <td><?php echo e($j->reference_no); ?></td>
                                    <td><?php echo e($j->memo); ?></td>
                                    <td class="text-end"><?php echo e(number_format($j->total_debit,2)); ?></td>
                                    <td class="text-end"><?php echo e(number_format($j->total_credit,2)); ?></td>
                                    <td><?php echo e($j->status); ?></td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-primary" href="<?php echo e(route('finance.journals.show',$j->journal_id)); ?>">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="8" class="text-center text-muted py-4">No records</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-2">
                    <?php echo e($journals->links('vendor.pagination.bootstrap-4')); ?>

                </div>

            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/finance_module/journals.blade.php ENDPATH**/ ?>