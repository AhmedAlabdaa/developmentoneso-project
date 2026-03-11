<?php
  $role = auth()->user()->role ?? '';
  $allowedRoles = ['Admin','Operations Manager','Managing Director','Accountant','Cashier','Finance Officer'];
  $canManage = in_array($role, $allowedRoles, true);

  $normalizeStatus = function ($v) {
      $v = strtolower(trim((string)($v ?? 'pending')));
      if ($v === 'canceled') return 'cancelled';
      if ($v === 'raplaced' || $v === 'replace') return 'replaced';
      return $v !== '' ? $v : 'pending';
  };

  $fmtDate = function ($v) {
      if (empty($v)) return '-';
      try {
          return \Carbon\Carbon::parse($v)->format('d M Y');
      } catch (\Throwable $e) {
          return '-';
      }
  };

  $fmtDateTz = function ($v) {
      if (empty($v)) return '-';
      try {
          return \Carbon\Carbon::parse($v)->timezone('Asia/Qatar')->format('d M Y');
      } catch (\Throwable $e) {
          return '-';
      }
  };

  $amountFor = function ($r) {
      return ($r->action_type ?? '') === 'refund'
          ? (float)($r->refund_final_balance ?? 0)
          : (float)($r->replacement_final_balance ?? 0);
  };

  $icons = [
    'pending'   => 'fas fa-hourglass-half',
    'paid'      => 'fas fa-check-circle',
    'replaced'  => 'fas fa-exchange-alt',
    'cancelled' => 'fas fa-times-circle',
  ];

  $titles = [
    'pending'   => 'Pending',
    'paid'      => 'Paid',
    'replaced'  => 'Replaced',
    'cancelled' => 'Cancelled',
  ];

  $statusClass = [
    'pending'   => 'refund-status-pending',
    'paid'      => 'refund-status-paid',
    'replaced'  => 'refund-status-replaced',
    'cancelled' => 'refund-status-cancelled',
  ];

  $stageMap = [
    'sales return' => ['param' => 'sales_return', 'icon' => 'fas fa-box-open', 'title' => 'Sales Return Form'],
    'trial return' => ['param' => 'trial_return', 'icon' => 'fas fa-undo-alt', 'title' => 'Trial Return Form'],
    'incident outside' => ['param' => 'incident_outside', 'icon' => 'fas fa-exclamation-triangle', 'title' => 'Incident Outside Form'],
    'incident inside' => ['param' => 'incident_inside', 'icon' => 'fas fa-exclamation-circle', 'title' => 'Incident Inside Form'],
    'incident before visa' => ['param' => 'incident_before_visa', 'icon' => 'fas fa-passport', 'title' => 'Incident Before Visa Form'],
    'incident after visa' => ['param' => 'incident_after_visa', 'icon' => 'fas fa-id-card', 'title' => 'Incident After Visa Form'],
    'incident after arrival' => ['param' => 'incident_after_arrival', 'icon' => 'fas fa-plane-arrival', 'title' => 'Incident After Arrival Form'],
    'incident after departure' => ['param' => 'incident_after_departure', 'icon' => 'fas fa-plane-departure', 'title' => 'Incident After Departure Form'],
  ];

  $normalizeStageKey = function ($v) {
      $s = strtolower(trim((string)($v ?? '')));
      $s = preg_replace('/\s+/', ' ', $s);
      return $s;
  };

  $rows = [];
  if (is_object($refunds) && method_exists($refunds, 'items')) {
      $rows = $refunds->items();
  } elseif (is_iterable($refunds)) {
      foreach ($refunds as $x) $rows[] = $x;
  }

  $filterStatus = strtolower((string)request('status', ''));
  $mode = in_array($filterStatus, ['refund', 'replacement'], true) ? $filterStatus : 'mixed';

  $hasRefund = false;
  $hasReplacement = false;
  foreach ($rows as $x) {
      if (($x->action_type ?? '') === 'refund') $hasRefund = true; else $hasReplacement = true;
      if ($hasRefund && $hasReplacement) break;
  }

  if ($mode === 'refund') {
      $dateHeader = 'Due Date';
      $showReplacementCols = false;
  } elseif ($mode === 'replacement') {
      $dateHeader = 'Replaced Date';
      $showReplacementCols = true;
  } else {
      $dateHeader = $hasRefund && !$hasReplacement ? 'Due Date' : (!$hasRefund && $hasReplacement ? 'Replaced Date' : 'Date');
      $showReplacementCols = $hasReplacement || (!$hasRefund && !$hasReplacement) || ($hasRefund && $hasReplacement);
  }

  $getReplacedCandidate = function ($r) {
      $v = null;

      $candidates = [
          $r->replaced_with ?? null,
          $r->replaced_with_name ?? null,
          $r->replaced_candidate ?? null,
          $r->replaced_candidate_name ?? null,
          $r->replacement_candidate ?? null,
          $r->replacement_candidate_name ?? null,
          $r->new_candidate ?? null,
          $r->new_candidate_name ?? null,
          $r->replacement_name ?? null,
          $r->replace_candidate ?? null,
          $r->replace_candidate_name ?? null,
          $r->replaced_with_candidate ?? null,
          $r->replaced_with_candidate_name ?? null,
      ];

      foreach ($candidates as $cand) {
          if (is_string($cand) && trim($cand) !== '') { $v = $cand; break; }
          if (is_object($cand)) {
              if (isset($cand->candidate_name) && trim((string)$cand->candidate_name) !== '') { $v = $cand->candidate_name; break; }
              if (isset($cand->name) && trim((string)$cand->name) !== '') { $v = $cand->name; break; }
          }
      }

      if (!$v) {
          $relCandidates = [
              $r->replacedCandidate ?? null,
              $r->replacementCandidate ?? null,
              $r->replacedWithCandidate ?? null,
              $r->newCandidate ?? null,
          ];
          foreach ($relCandidates as $rel) {
              if (is_object($rel)) {
                  if (isset($rel->candidate_name) && trim((string)$rel->candidate_name) !== '') { $v = $rel->candidate_name; break; }
                  if (isset($rel->name) && trim((string)$rel->name) !== '') { $v = $rel->name; break; }
              }
          }
      }

      $v = is_string($v) ? trim($v) : '';
      return $v !== '' ? $v : '-';
  };

  $packagesBaseUrl = url('/packages/returnforms');

  $colCount = $showReplacementCols ? 15 : 13;
?>

<style>
  .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:6px 10px;border-radius:6px;font-size:11px;min-width:32px;height:30px;color:#fff;border:none;line-height:1;text-decoration:none}
  .btn-icon-only:hover{color:#fff;text-decoration:none}
  .btn-info.btn-icon-only{background-color:#17a2b8}
  .btn-warning.btn-icon-only{background-color:#ffc107;color:#000}
  .btn-warning.btn-icon-only:hover{color:#000}
  .btn-danger.btn-icon-only{background-color:#dc3545}
</style>

<div>
  <?php if($canManage && isset($refundStatusStats)): ?>
    <div class="refund-stats-row">
      <?php $__currentLoopData = ['pending','paid','replaced','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="refund-stat refund-stat-<?php echo e($k); ?>">
          <div class="refund-stat-left">
            <div class="refund-stat-icon"><i class="<?php echo e($icons[$k]); ?>"></i></div>
            <div class="refund-stat-meta">
              <div class="refund-stat-title"><?php echo e($titles[$k]); ?></div>
              <div class="refund-stat-sub">Total Amount</div>
            </div>
          </div>
          <div class="refund-stat-right">
            <div class="refund-stat-count"><?php echo e((int)($refundStatusStats[$k]['count'] ?? 0)); ?></div>
            <div class="refund-stat-amt"><strong>QAR <?php echo e(number_format((float)($refundStatusStats[$k]['amount'] ?? 0), 2)); ?></strong></div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>

  <div class="table-container">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Created Date</th>
          <th><?php echo e($dateHeader); ?></th>
          <th>Stage</th>
          <th>Return Date</th>
          <th>Candidate Name</th>
          <th>Sponsor Name</th>
          <th>Source</th>
          <th>Status</th>
          <th>Nationality</th>
          <th>Contracted Amount</th>
          <th>Balance</th>
          <th>Reason</th>
          <?php if($showReplacementCols): ?>
            <th>Replaced Candidate</th>
            <th>Replaced By</th>
          <?php endif; ?>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $refunds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php
            $createdAt = $r->created_at ? $r->created_at->timezone('Asia/Qatar')->format('d M Y') : '-';

            $isRefund = ($r->action_type ?? '') === 'refund';
            $actionType = $isRefund ? 'refund' : 'replacement';

            if ($mode === 'refund') {
                $dateCell = $fmtDate($r->refund_due_date ?? null);
            } elseif ($mode === 'replacement') {
                $dateCell = $fmtDateTz($r->replaced_date ?? null);
            } else {
                $dateCell = $isRefund ? $fmtDate($r->refund_due_date ?? null) : $fmtDateTz($r->replaced_date ?? null);
            }

            $returnDate = $fmtDate($r->return_date ?? null);

            $contractedAmount = isset($r->contracted_amount) ? number_format((float)$r->contracted_amount, 2) : '-';

            $balanceValue = $amountFor($r);
            $balance = number_format((float)$balanceValue, 2);

            $reason = $isRefund ? ($r->refund_reason ?? '-') : ($r->replacement_reason ?? '-');

            $sponsor = $r->client_name ?? '-';
            $stage = $r->refund_stage ?? '-';
            $source = $r->source ?? '-';

            $stageKey = $normalizeStageKey($stage);
            $stageParam = $stageMap[$stageKey]['param'] ?? null;
            $stageIcon  = $stageMap[$stageKey]['icon'] ?? null;
            $stageTitle = $stageMap[$stageKey]['title'] ?? null;

            $currentStatus = $normalizeStatus($r->status ?? 'pending');

            $replacedCandidate = $isRefund ? '-' : strtoupper($getReplacedCandidate($r));
            $replacedBy = $isRefund ? '-' : trim((string)($r->replaced_by ?? ''));
            $replacedBy = $replacedBy !== '' ? strtoupper($replacedBy) : '-';
          ?>

          <tr>
            <td><?php echo e($createdAt); ?></td>
            <td><?php echo e($dateCell); ?></td>
            <td><?php echo e($stage); ?></td>
            <td><?php echo e($returnDate); ?></td>
            <td title="<?php echo e($r->candidate_name); ?>"><?php echo e(strtoupper($r->candidate_name ?? '-')); ?></td>
            <td title="<?php echo e($sponsor); ?>"><?php echo e(strtoupper($sponsor)); ?></td>
            <td title="<?php echo e($source); ?>"><?php echo e(strtoupper($source)); ?></td>
            <td>
              <?php if($canManage): ?>
                <select
                  class="refund-status-select <?php echo e($statusClass[$currentStatus] ?? ''); ?>"
                  data-refund-id="<?php echo e($r->id); ?>"
                  data-original-status="<?php echo e($currentStatus); ?>"
                  data-candidate-name="<?php echo e(strtoupper($r->candidate_name ?? 'CANDIDATE')); ?>"
                  data-cn-number="<?php echo e($r->cn_number ?? ''); ?>"
                  data-balance="<?php echo e($balance); ?>"
                  data-action-type="<?php echo e($actionType); ?>"
                >
                  <option value="pending" <?php if($currentStatus==='pending'): echo 'selected'; endif; ?>>PENDING</option>
                  <option value="paid" <?php if($currentStatus==='paid'): echo 'selected'; endif; ?>>PAID</option>

                  <?php if($isRefund): ?>
                    <option value="convert_to_replace">CONVERT TO REPLACE</option>
                  <?php else: ?>
                    <option value="replaced" <?php if($currentStatus==='replaced'): echo 'selected'; endif; ?>>REPLACED</option>
                    <option value="convert_to_refund">CONVERT TO REFUND</option>
                  <?php endif; ?>

                  <option value="cancelled" <?php if($currentStatus==='cancelled'): echo 'selected'; endif; ?>>CANCELLED</option>
                </select>
              <?php else: ?>
                <span class="refund-status-text <?php echo e($statusClass[$currentStatus] ?? ''); ?>">
                  <i class="<?php echo e($icons[$currentStatus] ?? 'fas fa-circle'); ?>"></i>
                  <?php echo e(strtoupper($currentStatus)); ?>

                </span>
              <?php endif; ?>
            </td>
            <td><?php echo e(strtoupper($r->nationality ?? '-')); ?></td>
            <td><?php echo e($contractedAmount); ?></td>
            <td><?php echo e($balance); ?></td>
            <td title="<?php echo e($reason); ?>"><?php echo e($reason); ?></td>
            <?php if($showReplacementCols): ?>
              <td><?php echo e($replacedCandidate); ?></td>
              <td><?php echo e($replacedBy); ?></td>
            <?php endif; ?>
            <td>
              <a class="btn-icon-only btn-info" href="<?php echo e(route('refunds.show', ['refund' => $r->id])); ?>" title="View"><i class="fas fa-eye"></i></a>
              <a class="btn-icon-only btn-warning" href="<?php echo e(route('refunds.edit', ['refund' => $r->id])); ?>" title="Edit"><i class="fas fa-pen"></i></a>
              <?php if($stageParam): ?>
                <a href="<?php echo e($packagesBaseUrl . '?id=' . $r->id . '&stage=' . $stageParam); ?>" class="btn-icon-only btn-danger" title="<?php echo e($stageTitle); ?>"><i class="<?php echo e($stageIcon); ?>"></i></a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="<?php echo e($colCount); ?>" class="text-center">No results found.</td></tr>
        <?php endif; ?>
      </tbody>

      <tfoot>
        <tr>
          <th>Created Date</th>
          <th><?php echo e($dateHeader); ?></th>
          <th>Stage</th>
          <th>Return Date</th>
          <th>Candidate Name</th>
          <th>Sponsor Name</th>
          <th>Source</th>
          <th>Status</th>
          <th>Nationality</th>
          <th>Contracted Amount</th>
          <th>Balance</th>
          <th>Reason</th>
          <?php if($showReplacementCols): ?>
            <th>Replaced Candidate</th>
            <th>Replaced By</th>
          <?php endif; ?>
          <th>Action</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <nav aria-label="Page navigation">
    <div class="pagination-container">
      <span class="muted-text">Showing <?php echo e($refunds->firstItem()); ?> to <?php echo e($refunds->lastItem()); ?> of <?php echo e($refunds->total()); ?> results</span>
      <ul class="pagination justify-content-center">
        <?php echo e($refunds->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

      </ul>
    </div>
  </nav>
</div>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/package/partials/refund_table.blade.php ENDPATH**/ ?>