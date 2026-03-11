<style type="text/css">
    .btn-secondary{font-size: 12px !important;}
    .btn-success{ font-size: 12px !important; }
</style>
<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create License</h5>
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> <?php echo e(session('error')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form class="row g-3" action="<?php echo e(route('licenses.store')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="col-lg-6">
                                <label for="file_name" class="form-label">File Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                    <input type="text" class="form-control" id="file_name" name="file_name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="document_type" class="form-label">Document Type <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file"></i></span>
                                    <select class="form-control" id="document_type" name="document_type" required>
                                        <option value="">Select Document Type</option>
                                        <option value="Trade License">Trade License</option>
                                        <option value="VAT Certificate">VAT Certificate</option>
                                        <option value="Insurance">Insurance</option>
                                        <option value="Work Permit">Work Permit</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="document_number" class="form-label">Document Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                    <input type="text" class="form-control" id="document_number" name="document_number" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="document_date" class="form-label">Document Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control" id="document_date" name="document_date" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="expiry_date" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                                    <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="renewal_required" class="form-label">Renewal Required <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                    <select class="form-control" id="renewal_required" name="renewal_required" required>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="file" class="form-label">Upload File <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                    <input type="file" class="form-control" id="file" name="file" required accept="image/*,video/*">
                                </div>
                                <div id="file-preview" class="mt-3"></div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
    $('#file').on('change', function() {
        const file = this.files[0];
        const filePreview = $('#file-preview');
        filePreview.empty();
        if (file) {
            const fileURL = URL.createObjectURL(file);
            let previewContent = '';
            if (file.type.startsWith('image/')) {
                previewContent = `<img src="${fileURL}" alt="${file.name}" class="img-fluid rounded mt-2" style="max-width: 100%; max-height: 300px;">`;
            } else if (file.type.startsWith('video/')) {
                previewContent = `<video controls src="${fileURL}" class="img-fluid rounded mt-2" style="max-width: 100%; max-height: 300px;"></video>`;
            }

            filePreview.append(`
                <div class="card mt-3 p-3 border shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>${previewContent}</div>
                        <button type="button" class="btn btn-danger btn-sm mt-2" id="remove-file"><i class="fas fa-trash-alt"></i> Delete</button>
                    </div>
                </div>
            `);
        }
    });

    $(document).on('click', '#remove-file', function() {
        $('#file').val('');
        $('#file-preview').empty();
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/licenses/create.blade.php ENDPATH**/ ?>