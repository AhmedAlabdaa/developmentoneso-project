<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<style>
    .notification-list {
        margin-top: 1rem;
        font-size: 12px;
    }
    .notification-item {
        padding: 1rem;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .notification-item:last-child {
        border-bottom: none;
    }
    .notification-time {
        margin-right: 1rem;
        text-align: right;
    }
    .notification-time .time {
        font-weight: bold;
    }
    .notification-time .date {
        color: #666;
    }
    .notification-badge {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        margin-right: 1rem;
    }
    .notification-content {
        flex: 1;
    }
    .notification-content strong {
        display: block;
        margin-bottom: 0.5rem;
    }
    .notification-actions {
        display: flex;
        gap: 0.5rem;
    }
    .pagination-container {
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .pagination-container .muted-text {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .pagination-container ul.pagination {
        justify-content: flex-end;
        margin-bottom: 0;
    }
    .alert {
        max-width: 600px;
        margin: 1rem auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .alert i {
        margin-right: 0.5rem;
    }

    .notification-item.unread {
        background-color: #ffecec;
    }
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Recent Notifications</h5>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($error); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <form method="GET" action="<?php echo e(route('notifications.index')); ?>" class="mb-3">
              <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search notifications...">
                <button class="btn btn-primary" type="submit">
                  <i class="bi bi-search"></i> Search
                </button>
              </div>
            </form>
            <div class="notification-list">
                <?php if($notifications->isEmpty()): ?>
                  <div class="notification-item">
                    <div class="notification-content text-center w-100">
                      <strong>No notifications available.</strong>
                    </div>
                  </div>
                <?php else: ?>
                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="notification-item <?php echo e($notification->status === 'Un Read' ? 'unread' : ''); ?>">
                    <div class="notification-time">
                      <div class="time"><?php echo e($notification->created_at->format('d M, Y')); ?></div>
                      <div class="date"><?php echo e($notification->created_at->format('H:i')); ?></div>
                    </div>
                    <i class="bi bi-circle-fill notification-badge 
                        <?php switch($notification->role):
                            case ('finance'): ?> text-success <?php break; ?>
                            <?php case ('sales'): ?> text-danger <?php break; ?>
                            <?php case ('coordinator'): ?> text-primary <?php break; ?>
                            <?php case ('CHC'): ?> text-info <?php break; ?>
                            <?php default: ?> text-muted
                        <?php endswitch; ?>"></i>
                      <div class="notification-content">
                        <strong><?php echo e($notification->title); ?></strong>
                        <p><?php echo e($notification->message); ?></p>
                      </div>
                      <?php if($notification->filePath): ?>
                        <div class="notification-attachment">
                          <?php
                            $fileExtension = strtolower(pathinfo($notification->filePath, PATHINFO_EXTENSION));
                          ?>
                          <?php if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <a href="javascript:void(0)" style="margin-right: 10px;" class="btn btn-outline-primary btn-sm" onclick="showImageModal('<?php echo e(asset('storage/' .$notification->filePath)); ?>')">
                              <i class="bi bi-image"></i> View Image
                            </a>
                          <?php elseif($fileExtension === 'pdf'): ?>
                            <a href="javascript:void(0)" style="margin-right: 10px;" class="btn btn-outline-primary btn-sm" onclick="showPdfModal('<?php echo e(asset('storage/' .$notification->filePath)); ?>')">
                              <i class="bi bi-file-earmark-pdf"></i> View PDF
                            </a>
                          <?php endif; ?>
                          <a href="<?php echo e(asset($notification->filePath)); ?>" style="margin-right: 10px;" class="btn btn-outline-success btn-sm" download>
                            <i class="bi bi-download"></i> Download
                          </a>
                        </div>
                      <?php endif; ?>
                      <div class="notification-actions">
                        <form method="POST" action="<?php echo e(route('notifications.markAsRead', $notification->id)); ?>" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-outline-secondary btn-sm" title="Mark as Read">
                              <i class="bi bi-check-circle"></i>
                            </button>
                        </form>
                        <a href="#" class="btn btn-outline-danger btn-sm" title="Delete">
                          <i class="bi bi-trash"></i>
                        </a>
                      </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </div>

            <nav aria-label="Page navigation">
                <div class="pagination-container">
                    <span class="muted-text">
                        Showing <?php echo e($notifications->firstItem()); ?> to <?php echo e($notifications->lastItem()); ?> of <?php echo e($notifications->total()); ?> results
                    </span>
                    <ul class="pagination justify-content-center">
                        <?php echo e($notifications->appends(['search' => request('search')])->links('vendor.pagination.bootstrap-4')); ?>

                    </ul>
                </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Notification Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="modalPdf" src="" width="100%" height="500px" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
    function showImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }

    function showPdfModal(pdfSrc) {
        document.getElementById('modalPdf').src = pdfSrc;
        const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
        pdfModal.show();
    }

</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/activities/index.blade.php ENDPATH**/ ?>