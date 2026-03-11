<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Attachment Type</th>
            <th>Preview</th>
            <th>Expired On</th>
        </tr>
    </thead>
    <tbody>
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

            <tr>
                <td class="align-middle text-center"><strong><?php echo e($attachment->attachment_type); ?></strong></td>
                <td class="text-center">
                    <?php if($fileUrl): ?>
                        <div style="width: 300px; height: 300px; overflow: hidden; margin: auto; display: flex; align-items: center; justify-content: center;">
                            <?php if(in_array(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                <a href="<?php echo e($fileUrl); ?>" data-lightbox="attachment-<?php echo e($attachment->id); ?>" data-title="<?php echo e($attachment->attachment_type); ?>">
                                    <img src="<?php echo e($fileUrl); ?>" style="width: 300px; height: 300px; object-fit: cover;">
                                </a>
                            <?php elseif($attachment->attachment_type === 'Video'): ?>
                                <video controls style="width: 300px; height: 300px; border-radius: 8px;">
                                    <source src="<?php echo e($fileUrl); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php elseif(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION) === 'pdf'): ?>
                                <iframe src="<?php echo e($fileUrl); ?>" style="width: 300px; height: 300px; border: none;"></iframe>
                            <?php endif; ?>
                        </div>
                        <div class="mt-2 text-center">
                            <a href="<?php echo e($fileUrl); ?>" target="_blank" class="btn btn-primary btn-sm">
                                View Full
                            </a>
                            <a href="<?php echo e($fileUrl); ?>" download="<?php echo e($attachment->attachment_file); ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    <?php else: ?>
                        <span class="text-muted">File not found.</span>
                    <?php endif; ?>
                </td>
                <td class="align-middle text-center">
                    <?php echo e($attachment->expired_on ? \Carbon\Carbon::parse($attachment->expired_on)->format('j F Y') : 'N/A'); ?>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/partials/attachments.blade.php ENDPATH**/ ?>