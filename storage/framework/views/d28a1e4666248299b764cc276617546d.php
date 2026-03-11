<table class="table table-bordered text-center">
    <thead class="bg-dark text-white">
        <tr>
            <th scope="col">Skill Name</th>
            <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        <?php if($skills->count() > 0): ?>
            <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($skill->skill_name ?? 'N/A'); ?></td>
                    <td><?php echo e($skill->skill_description ?? 'N/A'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <tr>
                <td colspan="2" class="text-center">No skills found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/partials/load_skills.blade.php ENDPATH**/ ?>