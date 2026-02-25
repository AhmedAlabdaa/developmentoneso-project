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
      @forelse($remittances as $r)
        @php
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
        @endphp
        <tr>
          <td>{{ $createdAt }}</td>
          <td>{{ $handover }}</td>
          <td title="{{ $r->candidate_name }}">{{ strtoupper($r->candidate_name ?? '-') }}</td>
          <td title="{{ $partner }}">{{ strtoupper($partner) }}</td>
          <td>{{ strtoupper($r->nationality ?? '-') }}</td>
          <td>{{ $amount }}</td>
          <td><span class="status {{ $badge }}">{{ $status }}</span></td>
          <td>
            @if($proofUrl)
              <a class="btn-icon-only btn-info" href="{{ $proofUrl }}" target="_blank" title="View Proof"><i class="fas fa-file"></i></a>
            @else
              -
            @endif
          </td>
          <td>
            <a class="btn-icon-only btn-info" href="{{ route('remittances.show', ['remittance' => $r->id]) }}" title="View"><i class="fas fa-eye"></i></a>
            <a class="btn-icon-only btn-warning" href="{{ route('remittances.edit', ['remittance' => $r->id]) }}" title="Edit"><i class="fas fa-pen"></i></a>
          </td>
        </tr>
      @empty
        <tr><td colspan="9" class="text-center">No results found.</td></tr>
      @endforelse
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
      Showing {{ $remittances->firstItem() }} to {{ $remittances->lastItem() }} of {{ $remittances->total() }} results
    </span>
    <ul class="pagination justify-content-center">
      {{ $remittances->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
    </ul>
  </div>
</nav>
