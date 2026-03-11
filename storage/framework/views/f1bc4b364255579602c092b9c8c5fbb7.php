<table class="table table-bordered text-center">
    <thead class="bg-dark text-white">
        <tr>
            <th scope="col">Country Name</th>
            <th scope="col">Arabic Name</th>
            <th scope="col">FRA Name</th>
        </tr>
    </thead>
    <tbody>
        <?php if($desiredCountries->count() > 0): ?>
            <?php $__currentLoopData = $desiredCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($country->country_name ?? 'N/A'); ?></td>
                    <td><?php echo e($country->country_arabic_name ?? 'N/A'); ?></td>
                    <td><?php echo e($country->fra_name ?? 'N/A'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No desired countries found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/partials/load_desired_countries.blade.php ENDPATH**/ ?>