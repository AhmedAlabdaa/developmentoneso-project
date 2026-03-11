<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer Information</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Customer ID</th>
                                        <td><?php echo e($crm->cl); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td><?php echo e($crm->name); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Slug</th>
                                        <td><?php echo e($crm->slug); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nationality</th>
                                        <td><?php echo e($crm->nationality); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo e($crm->email ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td><?php echo e($crm->mobile); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Emirates ID</th>
                                        <td><?php echo e($crm->emirates_id); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Emergency Contact Person</th>
                                        <td><?php echo e($crm->emergency_contact_person ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Source</th>
                                        <td><?php echo e($crm->source ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Passport Copy</th>
                                        <td><a href="<?php echo e(asset('storage/' . $crm->passport_copy)); ?>" target="_blank">View Passport Copy</a></td>
                                    </tr>
                                    <tr>
                                        <th>Emirates ID Copy</th>
                                        <td><a href="<?php echo e(asset('storage/' . $crm->id_copy)); ?>" target="_blank">View ID Copy</a></td>
                                    </tr>
                                    <tr>
                                        <th>Date Created</th>
                                        <td><?php echo e($crm->created_at->format('l, F d, Y h:i A')); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td><?php echo e($crm->updated_at->format('l, F d, Y h:i A')); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <a href="<?php echo e(route('crm.index')); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
                        <a href="<?php echo e(route('crm.edit', $crm->id)); ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                        <form action="<?php echo e(route('crm.destroy', $crm->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this customer?');"><i class="fas fa-trash-alt"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/incidents/show.blade.php ENDPATH**/ ?>