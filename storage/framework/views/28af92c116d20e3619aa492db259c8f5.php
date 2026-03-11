<style>
    .table-container {
        width: 100%;
        overflow-x: auto;
        position: relative;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .table th,
    .table td {
        padding: 10px 15px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #ddd;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .table th {
        background-color: #343a40;
        color: white;
        text-transform: uppercase;
        font-weight: bold;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    .actions {
        display: flex;
        gap: 5px;
    }
    .btn-icon-only {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        border-radius: 50%;
        font-size: 14px;
        width: 30px;
        height: 30px;
        color: white;
    }
    .btn-info {
        background-color: #17a2b8;
    }
    .btn-warning {
        background-color: #ffc107;
    }
    .btn-danger {
        background-color: #dc3545;
    }
    .sticky-table th:last-child,
    .sticky-table td:last-child {
        position: sticky;
        right: 0;
        background-color: white;
        z-index: 2;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        min-width: 150px;
    }
    .modal .table th:last-child,
    .modal .table td:last-child {
        position: static;
    }
    .table th:last-child {
        z-index: 3;
    }
    .bg-gradient-primary {
        background: linear-gradient(to right, #007bff, #6a11cb);
    }
    .btn-sm {
        font-size: 0.8rem;
    }
    .scrollable-modal-body {
        max-height: 500px;
        overflow-y: auto;
    }
    .muted-text{font-size: 12px;}
</style>

<div class="table-container">
    <table class="table sticky-table table-striped table-hover">
        <thead>
            <tr>
                <th title="SR #">SR #</th>
                <th title="Agent Name">Agent Name</th>
                <th title="CL Number">CL Number</th>
                <th title="CN Number">CN Number</th>
                <th title="Credit Amount">Credit Amount</th>
                <th title="Debit Amount">Debit Amount</th>
                <th title="Status">Status</th>
                <th title="Incident Ref">Incident Ref</th>
                <th title="Incident Proof">Incident Proof</th>
                <th title="Created At">Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->iteration + ($commissions->currentPage() - 1) * $commissions->perPage()); ?></td> <!-- Calculate SR # -->
                    <td><?php echo e($commission->agent_name ?? 'N/A'); ?></td>
                    <td><?php echo e($commission->cl_number ?? 'N/A'); ?></td>
                    <td><?php echo e($commission->cn_number ?? 'N/A'); ?></td>
                    <td><?php echo e(number_format($commission->credit_amount ?? 0, 2)); ?></td>
                    <td><?php echo e(number_format($commission->debit_amount ?? 0, 2)); ?></td>
                    <td><?php echo e(ucfirst($commission->status ?? 'N/A')); ?></td>
                    <td><?php echo e($commission->incident_no ?? 'N/A'); ?></td>
                    <td><?php echo e($commission->incident_proof ?? 'N/A'); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($commission->created_at)->format('d M Y h:i:A')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="10" class="text-center">No records found</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th title="SR #">SR #</th>
                <th title="Agent Name">Agent Name</th>
                <th title="CL Number">CL Number</th>
                <th title="CN Number">CN Number</th>
                <th title="Credit Amount">Credit Amount</th>
                <th title="Debit Amount">Debit Amount</th>
                <th title="Status">Status</th>
                <th title="Incident Ref">Incident Ref</th>
                <th title="Incident Proof">Incident Proof</th>
                <th title="Created At">Created At</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing <?php echo e($commissions->firstItem()); ?> to <?php echo e($commissions->lastItem()); ?> of <?php echo e($commissions->total()); ?> results
        </span>
        <ul class="pagination justify-content-center">
            <?php echo e($commissions->links('vendor.pagination.bootstrap-4')); ?>

        </ul>
    </div>
</nav>

<?php /**PATH /var/www/developmentoneso-project/resources/views/agents/partials/agent_commission_table.blade.php ENDPATH**/ ?>