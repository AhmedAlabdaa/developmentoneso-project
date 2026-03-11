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
        font-size: 12px;
        width: 30px;
        height: 30px;
        color: white;
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
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        min-width: 150px;
    }
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Document Type</th>
                <th>Document Number</th>
                <th>Document Date</th>
                <th>Expiry Date</th>
                <th>Renewal Required</th>
                <th>Status</th>
                <th>Uploaded By</th>
                <th>Uploaded At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $licenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($license->file_name); ?></td>
                    <td><?php echo e($license->document_type); ?></td>
                    <td><?php echo e($license->document_number); ?></td>
                    <td><?php echo e($license->document_date ? \Carbon\Carbon::parse($license->document_date)->format('d F Y') : 'N/A'); ?></td>
                    <td><?php echo e($license->expiry_date ? \Carbon\Carbon::parse($license->expiry_date)->format('d F Y') : 'N/A'); ?></td>
                    <td><?php echo e($license->renewal_required ? 'Yes' : 'No'); ?></td>
                    <td><?php echo e($license->status); ?></td>
                    <td><?php echo e(optional($license->uploadedByUser)->name ?? 'N/A'); ?></td>
                    <td><?php echo e($license->uploaded_at ? \Carbon\Carbon::parse($license->uploaded_at)->format('d F Y h:i A') : 'N/A'); ?></td>
                    <td class="actions">
                        <a href="javascript:void(0);" onclick="openFilePreview('<?php echo e(asset('storage/' . $license->file_path)); ?>')" class="btn btn-secondary btn-icon-only" title="View File">
                            <i class="fas fa-file"></i>
                        </a>
                        <a href="<?php echo e(asset('storage/' . $license->file_path)); ?>" class="btn btn-info btn-icon-only" title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="<?php echo e(route('licenses.show', $license->id)); ?>" class="btn btn-info btn-icon-only" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?php echo e(route('licenses.edit', $license->id)); ?>" class="btn btn-warning btn-icon-only" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if(auth()->user()->role === 'Admin'): ?>
                            <form action="<?php echo e(route('licenses.destroy', $license->id)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-icon-only" title="Delete" onclick="return confirm('Are you sure?');">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr>
                <th>File Name</th>
                <th>Document Type</th>
                <th>Document Number</th>
                <th>Document Date</th>
                <th>Expiry Date</th>
                <th>Renewal Required</th>
                <th>Status</th>
                <th>Uploaded By</th>
                <th>Uploaded At</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>

<?php if($licenses->count()): ?>
    <nav aria-label="Page navigation">
        <div class="pagination-container">
            <span class="muted-text">
                Showing <?php echo e($licenses->firstItem()); ?> to <?php echo e($licenses->lastItem()); ?> of <?php echo e($licenses->total()); ?> results
            </span>
            <ul class="pagination justify-content-center">
                <?php echo e($licenses->links('vendor.pagination.bootstrap-4')); ?>

            </ul>
        </div>
    </nav>
<?php endif; ?>

<div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filePreviewModalLabel">File Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="filePreviewContent" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openFilePreview(fileUrl) {
        let fileExtension = fileUrl.split('.').pop().toLowerCase();
        let content = '';
        if (fileExtension === 'pdf') {
            content = `<embed src="${fileUrl}" type="application/pdf" width="100%" height="500px">`;
        } else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
            content = `<img src="${fileUrl}" alt="File Preview" class="img-fluid">`;
        } else {
            content = '<p>Preview not available for this file type.</p>';
        }
        document.getElementById('filePreviewContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('filePreviewModal')).show();
    }
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/licenses/partials/license_table.blade.php ENDPATH**/ ?>