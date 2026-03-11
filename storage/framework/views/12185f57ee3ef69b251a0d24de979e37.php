<style>
    .table-container {
        width: 100%;
        overflow-x: auto;
        position: relative;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
        margin-bottom: 20px;
    }
    .table th, .table td {
        padding: 10px 15px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #ddd;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .table thead th,
    .table tfoot th {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
        white-space: nowrap;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    .actions {
        display: flex;
        gap: 6px;
        align-items: center;
    }
    .btn-icon-only {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        border-radius: 50%;
        font-size: 12px;
        width: 30px;
        height: 30px;
        color: white;
        border: none;
    }
    .btn-info { background-color: #17a2b8; }
    .btn-warning { background-color: #ffc107; }
    .btn-danger { background-color: #dc3545; }
    .btn-secondary { background-color: #6c757d; }
    .table th:last-child, .table td:last-child {
        position: sticky;
        right: 0;
        background-color: white;
        z-index: 2;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.08);
        min-width: 160px;
    }
    .badge-pill {
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 11px;
        border: 1px solid #eaeaea;
        background: #f8f9fa;
        color: #333;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .pagination-text {
        font-size: 12px;
    }
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>CL</th>
                <th>Created</th>
                <th>Name</th>
                <th>Emirates ID</th>
                <th>Nationality</th>
                <th>Mobile</th>
                <th>Passport</th>
                <th>Emirates</th>
                <th>Source</th>
                <th>Package</th>
                <th>Contract</th>
                <th>Last Export</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $name = trim(($c->first_name ?? '') . ' ' . ($c->last_name ?? ''));
                    $hasContract = (int)($c->agreement_count ?? 0) > 0;
                    $pkg = $c->agreement_package ?? '—';
                ?>
                <tr>
                    <td><?php echo e($c->cl ?? '—'); ?></td>
                    <td><?php echo e($c->created_at ? $c->created_at->format('d M Y') : '—'); ?></td>
                    <td><?php echo e($name ?: '—'); ?></td>
                    <td><?php echo e($c->emirates_id ?? '—'); ?></td>
                    <td><?php echo e($c->nationality ?? '—'); ?></td>
                    <td><?php echo e($c->mobile ?? '—'); ?></td>
                    <td><?php echo e($c->passport_number ?? '—'); ?></td>
                    <td><?php echo e($c->state ?? '—'); ?></td>
                    <td><?php echo e($c->source ?? '—'); ?></td>
                    <td>
                        <span class="badge-pill">
                            <i class="fas fa-box"></i> <?php echo e($pkg); ?>

                        </span>
                    </td>
                    <td>
                        <?php if($hasContract): ?>
                            <span class="badge bg-success">Yes</span>
                        <?php else: ?>
                            <span class="badge bg-danger">No</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge-pill">
                            <i class="fas fa-file-export"></i> <?php echo e($exportLabel ?? '—'); ?>

                        </span>
                    </td>
                    <td class="actions">
                        <a href="<?php echo e(url('crm')); ?>" class="btn btn-info btn-icon-only" title="CRM">
                            <i class="fas fa-folder-open"></i>
                        </a>
                        <a href="<?php echo e(url('agreements')); ?>" class="btn btn-secondary btn-icon-only" title="Agreements">
                            <i class="fas fa-file-signature"></i>
                        </a>
                        <a href="<?php echo e(url('invoices')); ?>" class="btn btn-warning btn-icon-only" title="Invoices">
                            <i class="fas fa-receipt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="13" class="text-center py-4">
                        <i class="fas fa-folder-open text-muted"></i>
                        <div class="text-muted mt-2">No exported records found.</div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>

        <tfoot>
            <tr>
                <th>CL</th>
                <th>Created</th>
                <th>Name</th>
                <th>Emirates ID</th>
                <th>Nationality</th>
                <th>Mobile</th>
                <th>Passport</th>
                <th>Emirates</th>
                <th>Source</th>
                <th>Package</th>
                <th>Contract</th>
                <th>Last Export</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>

<?php if($customers->count()): ?>
    <nav aria-label="Page navigation">
        <div class="d-flex justify-content-between align-items-center py-2">
            <span class="text-muted pagination-text">
                Showing <?php echo e($customers->firstItem()); ?> to <?php echo e($customers->lastItem()); ?> of <?php echo e($customers->total()); ?> results
            </span>
            <ul class="pagination justify-content-center mb-0">
                <?php echo e($customers->links('vendor.pagination.bootstrap-4')); ?>

            </ul>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/reports/partials/customer_table.blade.php ENDPATH**/ ?>