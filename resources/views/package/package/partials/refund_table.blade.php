@php
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
@endphp

<style>
  .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:6px 10px;border-radius:6px;font-size:11px;min-width:32px;height:30px;color:#fff;border:none;line-height:1;text-decoration:none}
  .btn-icon-only:hover{color:#fff;text-decoration:none}
  .btn-info.btn-icon-only{background-color:#17a2b8}
  .btn-warning.btn-icon-only{background-color:#ffc107;color:#000}
  .btn-warning.btn-icon-only:hover{color:#000}
  .btn-danger.btn-icon-only{background-color:#dc3545}
</style>

<div>
  @if($canManage && isset($refundStatusStats))
    <div class="refund-stats-row">
      @foreach(['pending','paid','replaced','cancelled'] as $k)
        <div class="refund-stat refund-stat-{{ $k }}">
          <div class="refund-stat-left">
            <div class="refund-stat-icon"><i class="{{ $icons[$k] }}"></i></div>
            <div class="refund-stat-meta">
              <div class="refund-stat-title">{{ $titles[$k] }}</div>
              <div class="refund-stat-sub">Total Amount</div>
            </div>
          </div>
          <div class="refund-stat-right">
            <div class="refund-stat-count">{{ (int)($refundStatusStats[$k]['count'] ?? 0) }}</div>
            <div class="refund-stat-amt"><strong>QAR {{ number_format((float)($refundStatusStats[$k]['amount'] ?? 0), 2) }}</strong></div>
          </div>
        </div>
      @endforeach
    </div>
  @endif

  <div class="table-container">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Created Date</th>
          <th>{{ $dateHeader }}</th>
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
          @if($showReplacementCols)
            <th>Replaced Candidate</th>
            <th>Replaced By</th>
          @endif
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        @forelse($refunds as $r)
          @php
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
          @endphp

          <tr>
            <td>{{ $createdAt }}</td>
            <td>{{ $dateCell }}</td>
            <td>{{ $stage }}</td>
            <td>{{ $returnDate }}</td>
            <td title="{{ $r->candidate_name }}">{{ strtoupper($r->candidate_name ?? '-') }}</td>
            <td title="{{ $sponsor }}">{{ strtoupper($sponsor) }}</td>
            <td title="{{ $source }}">{{ strtoupper($source) }}</td>
            <td>
              @if($canManage)
                <select
                  class="refund-status-select {{ $statusClass[$currentStatus] ?? '' }}"
                  data-refund-id="{{ $r->id }}"
                  data-original-status="{{ $currentStatus }}"
                  data-candidate-name="{{ strtoupper($r->candidate_name ?? 'CANDIDATE') }}"
                  data-cn-number="{{ $r->cn_number ?? '' }}"
                  data-balance="{{ $balance }}"
                  data-action-type="{{ $actionType }}"
                >
                  <option value="pending" @selected($currentStatus==='pending')>PENDING</option>
                  <option value="paid" @selected($currentStatus==='paid')>PAID</option>

                  @if($isRefund)
                    <option value="convert_to_replace">CONVERT TO REPLACE</option>
                  @else
                    <option value="replaced" @selected($currentStatus==='replaced')>REPLACED</option>
                    <option value="convert_to_refund">CONVERT TO REFUND</option>
                  @endif

                  <option value="cancelled" @selected($currentStatus==='cancelled')>CANCELLED</option>
                </select>
              @else
                <span class="refund-status-text {{ $statusClass[$currentStatus] ?? '' }}">
                  <i class="{{ $icons[$currentStatus] ?? 'fas fa-circle' }}"></i>
                  {{ strtoupper($currentStatus) }}
                </span>
              @endif
            </td>
            <td>{{ strtoupper($r->nationality ?? '-') }}</td>
            <td>{{ $contractedAmount }}</td>
            <td>{{ $balance }}</td>
            <td title="{{ $reason }}">{{ $reason }}</td>
            @if($showReplacementCols)
              <td>{{ $replacedCandidate }}</td>
              <td>{{ $replacedBy }}</td>
            @endif
            <td>
              <a class="btn-icon-only btn-info" href="{{ route('refunds.show', ['refund' => $r->id]) }}" title="View"><i class="fas fa-eye"></i></a>
              <a class="btn-icon-only btn-warning" href="{{ route('refunds.edit', ['refund' => $r->id]) }}" title="Edit"><i class="fas fa-pen"></i></a>
              @if($stageParam)
                <a href="{{ $packagesBaseUrl . '?id=' . $r->id . '&stage=' . $stageParam }}" class="btn-icon-only btn-danger" title="{{ $stageTitle }}"><i class="{{ $stageIcon }}"></i></a>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="{{ $colCount }}" class="text-center">No results found.</td></tr>
        @endforelse
      </tbody>

      <tfoot>
        <tr>
          <th>Created Date</th>
          <th>{{ $dateHeader }}</th>
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
          @if($showReplacementCols)
            <th>Replaced Candidate</th>
            <th>Replaced By</th>
          @endif
          <th>Action</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <nav aria-label="Page navigation">
    <div class="pagination-container">
      <span class="muted-text">Showing {{ $refunds->firstItem() }} to {{ $refunds->lastItem() }} of {{ $refunds->total() }} results</span>
      <ul class="pagination justify-content-center">
        {{ $refunds->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
      </ul>
    </div>
  </nav>
</div>
