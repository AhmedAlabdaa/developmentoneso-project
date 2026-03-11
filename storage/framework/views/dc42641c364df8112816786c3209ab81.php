<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
      <h5 class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>Agreement Pending Approval</h5>
      <a href="<?php echo e(route('agreements.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Agreements
      </a>
    </div>
    <div class="card-body">
      <table class="table table-bordered mb-4">
        <thead class="table-light">
          <tr>
            <th>Agreement #</th>
            <th>Customer Name</th>
            <th>Candidate Name</th>
            <th>Type</th>
            <th>Package</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo e($agreement->reference_no); ?></td>
            <td><?php echo e(optional($agreement->client)->first_name ?? '—'); ?></td>
            <td><?php echo e($agreement->candidate_name); ?></td>
            <td><?php echo e($agreement->agreement_type); ?></td>
            <td><?php echo e($agreement->package); ?></td>
            <td><?php echo e($agreement->created_at->format('d M Y h:i A')); ?></td>
          </tr>
        </tbody>
      </table>

      <div class="alert alert-info d-flex align-items-center">
        <i class="fas fa-info-circle fa-lg me-2"></i>
        <div>
          This agreement has not yet been approved. Please contact your Contract/Agreement Administrator to approve it in order to proceed with further actions.
        </div>
      </div>
    </div>
  </div>
</div>
<?php /**PATH /var/www/developmentoneso-project/resources/views/agreements/payroll.blade.php ENDPATH**/ ?>