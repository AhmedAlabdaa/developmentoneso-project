
<?php
    $role = Auth::user()->role;
?>

<?php if($role == 'Admin'): ?>
    <?php echo $__env->make('../layout.Admin_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Hr Manager'): ?>
    <?php echo $__env->make('../layout.HRM_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Finance Officer'): ?>
    <?php echo $__env->make('../layout.Finance_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Sales Officer'): ?>
    <?php echo $__env->make('../layout.Sales_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Managing Director'): ?>
    <?php echo $__env->make('../layout.Managing_Director_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Marketing Manager'): ?>
    <?php echo $__env->make('../layout.Marketing_Manager_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Digital Marketing Specialist'): ?>
    <?php echo $__env->make('../layout.Digital_Marketing_Specialist_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Digital Marketing Executive'): ?>
    <?php echo $__env->make('../layout.Digital_Marketing_Executive_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Photographer'): ?>
    <?php echo $__env->make('../layout.Photographer_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Junior Accountant'): ?>
    <?php echo $__env->make('../layout.Junior_Accountant_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Cashier'): ?>
    <?php echo $__env->make('../layout.Cashier_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Contract Administrator'): ?>
    <?php echo $__env->make('../layout.Contract_Administrator_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'PRO'): ?>
    <?php echo $__env->make('../layout.PRO_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Web Manager'): ?>
    <?php echo $__env->make('../layout.Web_Manager_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Sales Coordinator'): ?>
    <?php echo $__env->make('../layout.Sales_Coordinator_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Sales Manager'): ?>
    <?php echo $__env->make('../layout.Sales_Manager_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Operations Manager'): ?>
    <?php echo $__env->make('../layout.Operations_Manager_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Operations Supervisor'): ?>
    <?php echo $__env->make('../layout.Operations_Supervisor_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Happiness Consultant'): ?>
    <?php echo $__env->make('../layout.Happiness_Consultant_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Customer Services'): ?>
    <?php echo $__env->make('../layout.Customer_Services_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif($role == 'Archive Clerk'): ?>
    <?php echo $__env->make('../layout.Archive_Clerk_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('../layout.Administrator_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<?php /**PATH /var/www/developmentoneso-project/resources/views/role_header.blade.php ENDPATH**/ ?>