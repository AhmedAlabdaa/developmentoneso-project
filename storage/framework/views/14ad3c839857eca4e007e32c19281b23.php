<table class="table table-bordered text-center">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Country</th>
            <th scope="col">Experience (Years)</th>
            <th scope="col">Experience (Months)</th>
        </tr>
    </thead>
    <tbody>
        <?php if($candidate->experiences->count() > 0): ?>
            <?php $__currentLoopData = $candidate->experiences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $experience): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($experience->country ?? 'N/A'); ?></td>
                    <td><?php echo e($experience->experience_years ?? '0'); ?></td>
                    <td><?php echo e($experience->experience_months ?? '0'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No experiences found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/partials/load_experiences.blade.php ENDPATH**/ ?>