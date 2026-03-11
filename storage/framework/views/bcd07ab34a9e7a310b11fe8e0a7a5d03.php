<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Agent Information</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Agent ID</th>
                                        <td><?php echo e($agent->id); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td><?php echo e($agent->name); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Company Name</th>
                                        <td><?php echo e($agent->company_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Branch Name</th>
                                        <td><?php echo e($agent->branch_name ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo e($agent->email ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td><?php echo e($agent->mobile ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td><?php echo e($agent->created_at->format('l, F d, Y h:i A')); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td><?php echo e($agent->updated_at->format('l, F d, Y h:i A')); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <a href="<?php echo e(route('agents.index')); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
                        <a href="<?php echo e(route('agents.edit', $agent->id)); ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                        <form action="<?php echo e(route('agents.destroy', $agent->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this agent?');"><i class="fas fa-trash-alt"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/agents/show.blade.php ENDPATH**/ ?>