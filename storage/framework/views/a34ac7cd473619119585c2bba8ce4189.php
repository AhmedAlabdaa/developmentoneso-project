<style>
.table-container{width:100%;overflow-x:auto;position:relative}
.table{width:100%;border-collapse:collapse}
.table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.table th{background-color:#343a40;color:#fff;text-transform:uppercase;font-weight:bold}
.table-hover tbody tr:hover{background-color:#f1f1f1}
.table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}
.btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:6px;border-radius:6px;font-size:11px;min-width:30px;height:28px;color:#fff}
.btn-info{background-color:#17a2b8}
.btn-warning{background-color:#ffc107;color:#000}
.btn-danger{background-color:#dc3545}
.pagination-container{display:flex;justify-content:space-between;align-items:center;margin-top:10px}
.muted-text{color:#6c757d;font-size:12px}
.status{padding:4px 8px;border-radius:12px;font-size:12px;font-weight:600;display:inline-block}
.status-pending{background:#ffeeba;color:#856404}
.status-paid{background:#d4edda;color:#155724}
.status-partial{background:#cce5ff;color:#004085}
.status-cancelled{background:#f8d7da;color:#721c24}
</style>

<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Created Date</th>
        <th>Handover Date</th>
        <th>Candidate Name</th>
        <th>Partner</th>
        <th>Nationality</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Proof</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $remittances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $createdAt = $r->created_date ? \Carbon\Carbon::parse($r->created_date)->timezone('Asia/Qatar')->format('d M Y h:i A') : '-';
          $handover  = $r->handover_date ? \Carbon\Carbon::parse($r->handover_date)->format('d M Y') : '-';
          $amount    = isset($r->remittance_amount) ? number_format($r->remittance_amount, 2) : '0.00';
          $partner   = $r->foreign_partner ?? '-';
          $status    = $r->status ?? 'Pending';
          $badge     = match (strtolower($status)) {
            'paid' => 'status-paid',
            'partially paid' => 'status-partial',
            'cancelled' => 'status-cancelled',
            default => 'status-pending'
          };
          $proofUrl  = $r->proof ? \Illuminate\Support\Facades\Storage::url($r->proof) : null;
        ?>
        <tr>
          <td><?php echo e($createdAt); ?></td>
          <td><?php echo e($handover); ?></td>
          <td title="<?php echo e($r->candidate_name); ?>"><?php echo e(strtoupper($r->candidate_name ?? '-')); ?></td>
          <td title="<?php echo e($partner); ?>"><?php echo e(strtoupper($partner)); ?></td>
          <td><?php echo e(strtoupper($r->nationality ?? '-')); ?></td>
          <td><?php echo e($amount); ?></td>
          <td><span class="status <?php echo e($badge); ?>"><?php echo e($status); ?></span></td>
          <td>
            <?php if($proofUrl): ?>
              <a class="btn-icon-only btn-info" href="<?php echo e($proofUrl); ?>" target="_blank" title="View Proof"><i class="fas fa-file"></i></a>
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
          <td>
            <a class="btn-icon-only btn-info" href="<?php echo e(route('remittances.show', ['remittance' => $r->id])); ?>" title="View"><i class="fas fa-eye"></i></a>
            <a class="btn-icon-only btn-warning" href="<?php echo e(route('remittances.edit', ['remittance' => $r->id])); ?>" title="Edit"><i class="fas fa-pen"></i></a>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="9" class="text-center">No results found.</td></tr>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <th>Created Date</th>
        <th>Handover Date</th>
        <th>Candidate Name</th>
        <th>Partner</th>
        <th>Nationality</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Proof</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>
</div>

<nav aria-label="Page navigation">
  <div class="pagination-container">
    <span class="muted-text">
      Showing <?php echo e($remittances->firstItem()); ?> to <?php echo e($remittances->lastItem()); ?> of <?php echo e($remittances->total()); ?> results
    </span>
    <ul class="pagination justify-content-center">
      <?php echo e($remittances->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

    </ul>
  </div>
</nav>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/package/partials/remittance_table.blade.php ENDPATH**/ ?>