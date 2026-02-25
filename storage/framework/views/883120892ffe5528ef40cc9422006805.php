<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        font-family: Arial, sans-serif;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
        font-size: 12px;
    }
    .nav-tabs .nav-link {
        transition: background-color 0.2s;
        color: #495057;
    }
    .nav-tabs .nav-link:hover {
        background-color: #f8f9fa;
    }
    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: white;
    }
    .filter-section {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        margin-top: 20px;
    }
    .table-responsive {
        margin-top: 20px;
    }
    .btn {
        transition: background-color 0.2s, color 0.2s;
    }
    .btn:hover {
        background-color: #007bff;
        color: white;
    }
    .table thead th {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
    }
    .form-control, .form-select {
        font-size: 12px;
    }
    .card-title {
        font-weight: normal;
    }
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
    }
    .pagination .page-item .page-link {
        color: #007bff;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }
    .large-search-input {
        min-width: 300px;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">LEADS LIST</h5>
                        <?php if(session('success')): ?>
                            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                        <?php endif; ?>
                        <div class="row align-items-center mb-3">
                            <div class="col-md-6">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(request('status') == '' ? 'active' : ''); ?>"
                                           href="<?php echo e(route('leads.index')); ?>">
                                           <i class="fas fa-list"></i> All Leads
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(request('status') == 'In negotiation' ? 'active' : ''); ?>"
                                           href="<?php echo e(route('leads.index', ['status' => 'In negotiation'])); ?>">
                                           <i class="fas fa-comments"></i> In negotiation
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(request('status') == 'On Hold' ? 'active' : ''); ?>"
                                           href="<?php echo e(route('leads.index', ['status' => 'On Hold'])); ?>">
                                           <i class="fas fa-pause-circle"></i> On Hold
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(request('status') == 'Customer' ? 'active' : ''); ?>"
                                           href="<?php echo e(route('leads.index', ['status' => 'Customer'])); ?>">
                                           <i class="fas fa-user-check"></i> Customer
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <form method="GET" action="<?php echo e(route('leads.index')); ?>" class="d-flex me-3">
                                    <div class="input-group">
                                        <input type="text" name="globalSearch" class="form-control large-search-input"
                                               placeholder="Search by name, phone or email"
                                               value="<?php echo e(request()->query('globalSearch')); ?>">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                                <a href="<?php echo e(route('leads.create')); ?>" class="btn btn-primary me-2">
                                    <i class="fas fa-plus"></i> Add Lead
                                </a>
                                <button type="button" id="toggleFilterBtn" class="btn btn-secondary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                        <div class="filter-section p-3" id="filterSection" style="display: none;">
                            <form method="GET" action="<?php echo e(route('leads.index')); ?>" class="row g-2">
                                <div class="col-md-3">
                                    <select name="status" class="form-select">
                                        <option value="">All Statuses</option>
                                        <option value="In negotiation" <?php echo e(request('status') == 'In negotiation' ? 'selected' : ''); ?>>In negotiation</option>
                                        <option value="On Hold" <?php echo e(request('status') == 'On Hold' ? 'selected' : ''); ?>>On Hold</option>
                                        <option value="Customer" <?php echo e(request('status') == 'Customer' ? 'selected' : ''); ?>>Customer</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="source" class="form-select">
                                        <option value="">All Sources</option>
                                        <option value="respond.io" <?php echo e(request('source') == 'respond.io' ? 'selected' : ''); ?>>Respond.io</option>
                                        <option value="Instagram" <?php echo e(request('source') == 'Instagram' ? 'selected' : ''); ?>>Instagram</option>
                                        <option value="Facebook" <?php echo e(request('source') == 'Facebook' ? 'selected' : ''); ?>>Facebook</option>
                                        <option value="Referral" <?php echo e(request('source') == 'Referral' ? 'selected' : ''); ?>>Referral</option>
                                        <option value="Walk-in" <?php echo e(request('source') == 'Walk-in' ? 'selected' : ''); ?>>Walk-in</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="sales_name" class="form-control" placeholder="Sales Name" value="<?php echo e(request()->query('sales_name')); ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="from_date" class="form-control" placeholder="From Date" value="<?php echo e(request()->query('from_date')); ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="to_date" class="form-control" placeholder="To Date" value="<?php echo e(request()->query('to_date')); ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="phone" class="form-control" placeholder="Enter phone number" value="<?php echo e(request()->query('phone')); ?>">
                                </div>
                                <div class="col-md-3">
                                    <input type="email" name="email" class="form-control" placeholder="Enter email" value="<?php echo e(request()->query('email')); ?>">
                                </div>
                                <div class="col-md-12 d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Apply Filters
                                    </button>
                                    <a href="<?php echo e(route('leads.index')); ?>" class="btn btn-warning ms-2">
                                        <i class="fas fa-undo"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Sales Name</th>
                                    <th>Sales Email</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($leads->firstItem() + $key); ?></td>
                                        <td><?php echo e($lead->first_name); ?></td>
                                        <td><?php echo e($lead->last_name); ?></td>
                                        <td><?php echo e($lead->phone); ?></td>
                                        <td><?php echo e($lead->email); ?></td>
                                        <td><?php echo e($lead->sales_name); ?></td>
                                        <td><?php echo e($lead->sales_email); ?></td>
                                        <td><?php echo e($lead->source); ?></td>
                                        <td><?php echo e($lead->status); ?></td>
                                        <td>
                                            <?php if($lead->status_date_time): ?>
                                                <?php echo e(\Carbon\Carbon::parse($lead->status_date_time)->format('d F Y h:i A')); ?>

                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('leads.show', $lead->id)); ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('leads.edit', $lead->id)); ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if(auth()->user()->role === 'Admin'): ?>
                                                <form action="<?php echo e(route('leads.destroy', $lead->id)); ?>" method="POST" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="11" class="text-center">No leads found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation" class="pagination-container">
                            <span class="muted-text">
                                Showing <?php echo e($leads->firstItem()); ?> to <?php echo e($leads->lastItem()); ?> of <?php echo e($leads->total()); ?> results
                            </span>
                            <div>
                                <?php echo e($leads->links('vendor.pagination.bootstrap-4')); ?>

                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
document.getElementById('toggleFilterBtn').addEventListener('click', function() {
    const filterSection = document.getElementById('filterSection');
    if (filterSection.style.display === 'none' || !filterSection.style.display) {
        filterSection.style.display = 'block';
    } else {
        filterSection.style.display = 'none';
    }
});
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/leads/index.blade.php ENDPATH**/ ?>