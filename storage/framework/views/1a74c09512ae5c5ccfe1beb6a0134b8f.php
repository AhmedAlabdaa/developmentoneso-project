<style type="text/css">
    .btn-secondary { font-size: 12px !important; }
    .btn-success { font-size: 12px !important; }
</style>

<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Update License</h5>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form class="row g-3" action="<?php echo e(route('licenses.update', $license->id)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="col-lg-6">
                                <label for="file_name" class="form-label">File Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                    <input type="text" class="form-control" id="file_name" name="file_name" value="<?php echo e(old('file_name', $license->file_name)); ?>" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="document_type" class="form-label">Document Type <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file"></i></span>
                                    <select class="form-control" id="document_type" name="document_type" required>
                                        <option value="">Select Document Type</option>
                                        <option value="Trade License" <?php echo e(old('document_type', $license->document_type) == 'Trade License' ? 'selected' : ''); ?>>Trade License</option>
                                        <option value="VAT Certificate" <?php echo e(old('document_type', $license->document_type) == 'VAT Certificate' ? 'selected' : ''); ?>>VAT Certificate</option>
                                        <option value="Insurance" <?php echo e(old('document_type', $license->document_type) == 'Insurance' ? 'selected' : ''); ?>>Insurance</option>
                                        <option value="Work Permit" <?php echo e(old('document_type', $license->document_type) == 'Work Permit' ? 'selected' : ''); ?>>Work Permit</option>
                                        <option value="Other" <?php echo e(old('document_type', $license->document_type) == 'Other' ? 'selected' : ''); ?>>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="document_number" class="form-label">Document Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                    <input type="text" class="form-control" id="document_number" name="document_number" value="<?php echo e(old('document_number', $license->document_number)); ?>" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="document_date" class="form-label">Document Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control" id="document_date" name="document_date" value="<?php echo e(old('document_date', $license->document_date)); ?>" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="expiry_date" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                                    <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="<?php echo e(old('expiry_date', $license->expiry_date)); ?>" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="renewal_required" class="form-label">Renewal Required <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                    <select class="form-control" id="renewal_required" name="renewal_required" required>
                                        <option value="Yes" <?php echo e(old('renewal_required', $license->renewal_required) == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                        <option value="No" <?php echo e(old('renewal_required', $license->renewal_required) == 'No' ? 'selected' : ''); ?>>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="file" class="form-label">Upload File</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                    <input type="file" class="form-control" id="file" name="file" accept="image/*,video/*">
                                </div>
                                <div id="file-preview" class="mt-3">
                                    <?php if($license->file): ?>
                                        <?php
                                            $fileUrl = asset('storage/' . $license->file_path);
                                            $extension = pathinfo($license->file_path, PATHINFO_EXTENSION);
                                        ?>
                                        <div class="card mt-3 p-3 border shadow-sm">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <?php if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                                    <img src="<?php echo e($fileUrl); ?>" alt="File Preview" class="img-fluid rounded" style="max-width: 100%; max-height: 300px;">
                                                <?php elseif(in_array($extension, ['mp4', 'avi', 'mov'])): ?>
                                                    <video controls src="<?php echo e($fileUrl); ?>" class="img-fluid rounded" style="max-width: 100%; max-height: 300px;"></video>
                                                <?php else: ?>
                                                    <p>No preview available for this file type.</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="<?php echo e(route('licenses.index')); ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/licenses/edit.blade.php ENDPATH**/ ?>