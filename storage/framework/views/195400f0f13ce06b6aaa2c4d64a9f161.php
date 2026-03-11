<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        font-family: Arial, sans-serif;
        font-size: 12px;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 8px 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 12px;
    }
    .table th {
        background-color: #343a40;
        color: white;
        text-transform: uppercase;
        font-weight: bold;
        width: 30%;
    }
    .btn {
        font-size: 12px;
        padding: 5px 10px;
        transition: background-color 0.2s, color 0.2s;
    }
    .btn:hover {
        background-color: #007bff;
        color: white;
    }
    .btn-secondary { background-color: #6c757d; color: white; }
    .btn-primary { background-color: #007bff; color: white; }
    .btn-danger { background-color: #dc3545; color: white; }
</style>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lead Information</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Lead ID</th>
                                        <td><?php echo e($lead->respond_id ?? $lead->id); ?></td>
                                    </tr>
                                    <tr>
                                        <th>First Name</th>
                                        <td><?php echo e($lead->first_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td><?php echo e($lead->last_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo e($lead->email ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td><?php echo e($lead->phone ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Sales Name</th>
                                        <td><?php echo e($lead->sales_name ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td><?php echo e($lead->address ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td><?php echo e($lead->city ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nationality</th>
                                        <td><?php echo e($lead->nationality ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Source</th>
                                        <td><?php echo e($lead->source ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><?php echo e($lead->status ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status Date/Time</th>
                                        <td>
                                            <?php if($lead->status_date_time): ?>
                                                <?php echo e(\Carbon\Carbon::parse($lead->status_date_time)->format('l, F d, Y h:i A')); ?>

                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Package</th>
                                        <td><?php echo e($lead->package ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Negotiation Status</th>
                                        <td><?php echo e($lead->negotiation ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Notes</th>
                                        <td><?php echo e($lead->notes ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date Created</th>
                                        <td><?php echo e($lead->created_at->format('l, F d, Y h:i A')); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td><?php echo e($lead->updated_at->format('l, F d, Y h:i A')); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="<?php echo e(route('leads.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="<?php echo e(route('leads.edit', $lead->id)); ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="<?php echo e(route('leads.destroy', $lead->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this lead?');">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/leads/show.blade.php ENDPATH**/ ?>