<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h5 class="card-title mb-0">Chart of Account Details</h5>

                            <span class="badge bg-info">
                                <?php echo e(strtoupper($account->currency_code ?? 'AED')); ?>

                            </span>
                        </div>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger mt-3">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive mt-3">
                            <table class="table table-striped align-middle">
                                <tbody>
                                    <tr>
                                        <th style="width: 240px;">Account ID</th>
                                        <td><?php echo e($account->account_id); ?></td>
                                    </tr>

                                    <tr>
                                        <th>Account Code</th>
                                        <td><strong><?php echo e($account->account_code); ?></strong></td>
                                    </tr>

                                    <tr>
                                        <th>Account Name</th>
                                        <td><?php echo e($account->account_name); ?></td>
                                    </tr>

                                    <tr>
                                        <th>Account Type</th>
                                        <td><span class="badge bg-primary"><?php echo e(strtoupper($account->account_type)); ?></span></td>
                                    </tr>

                                    <tr>
                                        <th>Normal Balance</th>
                                        <td>
                                            <?php if(($account->normal_balance ?? '') === 'D'): ?>
                                                <span class="badge bg-success">Debit (D)</span>
                                            <?php elseif(($account->normal_balance ?? '') === 'C'): ?>
                                                <span class="badge bg-warning text-dark">Credit (C)</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Parent Account</th>
                                        <td>
                                            <?php if($account->parentAccount): ?>
                                                <?php echo e($account->parentAccount->account_code); ?> - <?php echo e($account->parentAccount->account_name); ?>

                                            <?php else: ?>
                                                <span class="text-muted">No Parent (Top Level)</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Posting Account</th>
                                        <td>
                                            <?php if((int)$account->is_posting === 1): ?>
                                                <span class="badge bg-success"><i class="fas fa-check me-1"></i> Yes</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><i class="fas fa-times me-1"></i> No</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Control Account</th>
                                        <td>
                                            <?php if((int)$account->is_control === 1): ?>
                                                <span class="badge bg-info"><i class="fas fa-link me-1"></i> Yes</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><i class="fas fa-minus me-1"></i> No</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Active</th>
                                        <td>
                                            <?php if((int)$account->is_active === 1): ?>
                                                <span class="badge bg-success"><i class="fas fa-toggle-on me-1"></i> Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><i class="fas fa-toggle-off me-1"></i> Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Sort Order</th>
                                        <td><?php echo e($account->sort_order ?? 0); ?></td>
                                    </tr>

                                    <tr>
                                        <th>Children Accounts</th>
                                        <td>
                                            <span class="badge bg-dark"><?php echo e($childrenCount ?? ($childrenCount = $account->childAccounts()->count())); ?></span>
                                            <?php if(($childrenCount ?? 0) > 0): ?>
                                                <span class="text-muted ms-2">This account has sub-accounts.</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <a href="<?php echo e(route('chart-of-accounts.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>

                            <a href="<?php echo e(route('chart-of-accounts.edit', $account->account_id)); ?>" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>

                            <form action="<?php echo e(route('chart-of-accounts.destroy', $account->account_id)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this account?');">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/chart_of_accounts/show.blade.php ENDPATH**/ ?>