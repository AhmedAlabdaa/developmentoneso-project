<style>
    .table-container{width:100%;overflow-x:auto;position:relative}
    .table{width:100%;border-collapse:collapse;margin-bottom:12px}
    .table th,.table td{
        padding:10px 12px;
        text-align:left;
        vertical-align:middle;
        border-bottom:1px solid #e6e6e6;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        max-width:260px
    }
    .table thead th{
        background:#343a40;
        color:#fff;
        text-transform:uppercase;
        font-weight:700;
        font-size:12px;
        letter-spacing:.3px
    }
    .table-hover tbody tr:hover{background-color:#f6f7f8}
    .table-striped tbody tr:nth-of-type(odd){background-color:#fafafa}

    .actions{display:flex;gap:6px;justify-content:flex-start}
    .btn-icon-only{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:5px;
        border-radius:50%;
        font-size:12px;
        width:32px;
        height:32px;
        color:#fff;
        border:none
    }
    .btn-info{background-color:#17a2b8}
    .btn-warning{background-color:#ffc107;color:#000}
    .btn-danger{background-color:#dc3545}

    .sticky-table th:last-child,
    .sticky-table td:last-child{
        position:sticky;
        right:0;
        background-color:#fff;
        z-index:2;
        box-shadow:-2px 0 5px rgba(0,0,0,.08);
        min-width:170px
    }
    .table thead th:last-child{z-index:3;background-color:#343a40;color:#fff}

    .badge{
        font-size:11px;
        padding:6px 8px;
        border-radius:10px;
        font-weight:700;
        text-transform:uppercase
    }
    .badge-soft{background:#f1f3f5;color:#212529}
    .badge-yes{background:#d4edda;color:#155724}
    .badge-no{background:#f8d7da;color:#721c24}
    .badge-type{background:#e7f1ff;color:#004085}

    .pagination-container{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:10px;
        flex-wrap:wrap
    }
    .muted-text{color:#6c757d;font-size:12px}
</style>

<div class="table-container">
    <table class="table sticky-table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th title="Account Code">Code</th>
                <th title="Account Name">Name</th>
                <th title="Account Type">Type</th>
                <th title="Normal Balance">NB</th>
                <th title="Posting Account">Posting</th>
                <th title="Control Account">Control</th>
                <th title="Active">Active</th>
                <th title="Parent Account">Parent</th>
                <th title="Currency">Curr</th>
                <th title="Action">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td title="<?php echo e($account->account_code); ?>"><strong><?php echo e($account->account_code); ?></strong></td>

                    <td title="<?php echo e($account->account_name); ?>"><?php echo e($account->account_name); ?></td>

                    <td><span class="badge badge-type"><?php echo e(strtoupper($account->account_type)); ?></span></td>

                    <td>
                        <?php if(($account->normal_balance ?? '') === 'D'): ?>
                            <span class="badge badge-yes">D</span>
                        <?php elseif(($account->normal_balance ?? '') === 'C'): ?>
                            <span class="badge badge-soft">C</span>
                        <?php else: ?>
                            <span class="badge badge-soft">N/A</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if((int)($account->is_posting ?? 0) === 1): ?>
                            <span class="badge badge-yes">Yes</span>
                        <?php else: ?>
                            <span class="badge badge-no">No</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if((int)($account->is_control ?? 0) === 1): ?>
                            <span class="badge badge-soft">Yes</span>
                        <?php else: ?>
                            <span class="badge badge-no">No</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if((int)($account->is_active ?? 1) === 1): ?>
                            <span class="badge badge-yes">Active</span>
                        <?php else: ?>
                            <span class="badge badge-no">Inactive</span>
                        <?php endif; ?>
                    </td>

                    <td title="<?php echo e($account->parentAccount ? ($account->parentAccount->account_code . ' - ' . $account->parentAccount->account_name) : 'Top Level'); ?>">
                        <?php if($account->parentAccount): ?>
                            <?php echo e($account->parentAccount->account_code); ?> - <?php echo e($account->parentAccount->account_name); ?>

                        <?php else: ?>
                            <span class="text-muted">Top Level</span>
                        <?php endif; ?>
                    </td>

                    <td><span class="badge badge-soft"><?php echo e(strtoupper($account->currency_code ?? 'AED')); ?></span></td>

                    <td class="actions">
                        <a href="<?php echo e(route('chart-of-accounts.show', $account->account_id)); ?>" class="btn btn-info btn-icon-only btn-sm" title="View">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="<?php echo e(route('chart-of-accounts.edit', $account->account_id)); ?>" class="btn btn-warning btn-icon-only btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="<?php echo e(route('chart-of-accounts.destroy', $account->account_id)); ?>" method="POST" style="display:inline;" id="delete-form-<?php echo e($account->account_id); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="button" class="btn btn-danger btn-icon-only btn-sm" onclick="confirmDelete('<?php echo e($account->account_id); ?>')" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="10" class="text-center text-muted py-4">No accounts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            <?php if($accounts->total() > 0): ?>
                Showing <?php echo e($accounts->firstItem()); ?> to <?php echo e($accounts->lastItem()); ?> of <?php echo e($accounts->total()); ?> results
            <?php else: ?>
                Showing 0 results
            <?php endif; ?>
        </span>
        <div>
            <?php echo e($accounts->links('vendor.pagination.bootstrap-4')); ?>

        </div>
    </div>
</nav>
<?php /**PATH /var/www/developmentoneso-project/resources/views/chart_of_accounts/partials/chart_of_accounts_table.blade.php ENDPATH**/ ?>