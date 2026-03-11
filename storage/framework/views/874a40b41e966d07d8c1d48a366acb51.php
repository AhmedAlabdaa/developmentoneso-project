<div class="document-list">
    <?php $__currentLoopData = $candidate->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $baseUrl = 'https://' . $foreignPartner . '.onesourceerp.com/storage/app/public/';
            $localPath = 'public/' . $attachment->attachment_file;
            $localFileExists = \Storage::exists($localPath);
            $remoteFileUrl = $baseUrl . $attachment->attachment_file;
            $fileUrl = $localFileExists 
                        ? url('storage/' . $attachment->attachment_file) 
                        : (get_headers($remoteFileUrl) && strpos(get_headers($remoteFileUrl)[0], '200') !== false ? $remoteFileUrl : null);
        ?>
        <div class="document-item">
            <span class="document-name">
                <?php if(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION) === 'pdf'): ?>
                    <i class="fas fa-file-pdf"></i>
                <?php elseif(in_array(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    <i class="fas fa-image"></i>
                <?php elseif(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION) === 'mp4'): ?>
                    <i class="fas fa-video"></i>
                <?php else: ?>
                    <i class="fas fa-file-alt"></i>
                <?php endif; ?>
                <?php echo e($attachment->attachment_type); ?>

            </span>
            <div class="document-viewer">
                <?php if($fileUrl): ?>
                    <?php if(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION) === 'pdf'): ?>
                        <iframe src="<?php echo e($fileUrl); ?>" frameborder="0" class="document-frame"></iframe>
                    <?php elseif(in_array(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                        <a href="<?php echo e($fileUrl); ?>" data-lightbox="attachment-<?php echo e($attachment->id); ?>" data-title="<?php echo e($attachment->attachment_type); ?>">
                            <img src="<?php echo e($fileUrl); ?>" style="max-width: 300px; max-height: 300px; object-fit: cover;" alt="<?php echo e($attachment->attachment_type); ?>">
                        </a>
                    <?php elseif(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION) === 'mp4'): ?>
                        <a href="<?php echo e($fileUrl); ?>" data-lightbox="attachment-<?php echo e($attachment->id); ?>" data-title="<?php echo e($attachment->attachment_type); ?>">
                            <video controls style="max-width: 300px; max-height: 300px; object-fit: cover;" class="document-video">
                                <source src="<?php echo e($fileUrl); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </a>
                    <?php else: ?>
                        <img src="https://via.placeholder.com/800x600.png?text=Unsupported+Document" class="document-placeholder" alt="Placeholder Document">
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-muted">File not found.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/partials/viewattachments.blade.php ENDPATH**/ ?>