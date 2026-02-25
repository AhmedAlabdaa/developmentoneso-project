<style>
  :root{
    --rf-primary:#007bff;
    --rf-primary2:#00c6ff;
    --rf-dark:#343a40;
    --rf-muted:#6c757d;
    --rf-border:#e9ecef;
    --rf-shadow:0 10px 28px rgba(0,0,0,.08);
    --rf-radius:14px;
    --rf-font:12px;
  }

  body{
    background:linear-gradient(to right,#e0f7fa,#e1bee7);
    font-family:Arial,sans-serif;
  }

  .refund-wrap{width:100%}

  .refund-stats{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    margin:14px 0;
  }
  .refund-card{
    flex:1 1 260px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:12px 14px;
    border-radius:var(--rf-radius);
    border:1px solid var(--rf-border);
    background:#fff;
    box-shadow:var(--rf-shadow);
    min-width:0;
  }
  .refund-card .l{display:flex;align-items:center;gap:10px;min-width:0}
  .refund-ic{
    width:38px;height:38px;border-radius:14px;
    display:flex;align-items:center;justify-content:center;
    font-size:16px;
    border:1px solid rgba(0,0,0,.07);
  }
  .refund-meta{display:flex;flex-direction:column;min-width:0}
  .refund-title{
    font-size:12px;
    font-weight:900;
    letter-spacing:.06em;
    text-transform:uppercase;
    line-height:1.05;
  }
  .refund-sub{
    font-size:12px;
    color:var(--rf-muted);
    margin-top:2px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }
  .refund-r{text-align:right;white-space:nowrap}
  .refund-cnt{font-size:16px;font-weight:950;line-height:1.05}
  .refund-amt{font-size:12px;color:var(--rf-muted);margin-top:2px}
  .refund-amt strong{color:#111;font-weight:950}

  .refund-card-open .refund-ic{background:#eef6ff;color:#0b5ed7}
  .refund-card-closed .refund-ic{background:#eaf7ef;color:#198754}
  .refund-card-cancelled .refund-ic{background:#ffeaea;color:#dc3545}

  .refund-table-container{
    width:100%;
    overflow-x:auto;
    border-radius:16px;
    border:1px solid var(--rf-border);
    background:#fff;
    box-shadow:var(--rf-shadow);
  }

  .refund-table{
    width:100%;
    border-collapse:collapse;
    margin:0;
    font-size:var(--rf-font);
  }
  .refund-table th,.refund-table td{
    padding:10px 14px;
    text-align:left;
    vertical-align:middle;
    border-bottom:1px solid #edf0f4;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }

  .refund-table thead th,
  .refund-table tfoot th{
    background:linear-gradient(to right,var(--rf-primary),var(--rf-primary2));
    color:#fff;
    text-transform:uppercase;
    font-weight:900;
    letter-spacing:.05em;
    border-bottom:0;
    position:sticky;
    top:0;
    z-index:2;
  }

  .refund-table tfoot th{
    position:sticky;
    bottom:0;
    top:auto;
    z-index:1;
  }

  .refund-table tbody tr:nth-of-type(odd){background:#f9fbff}
  .refund-table tbody tr:hover{background:#f1f7ff}

  .refund-status-select{
    min-width:140px;
    font-size:12px;
    font-weight:900;
    border-radius:12px;
    border:1px solid #bfc6d1;
    padding:6px 10px;
    text-transform:uppercase;
    background:#fff;
    color:#111;
    cursor:pointer;
    outline:none;
  }
  .refund-status-text{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 10px;
    border-radius:12px;
    font-weight:900;
    font-size:12px;
    text-transform:uppercase;
    border:1px solid #bfc6d1;
    background:#fff;
    color:#111;
  }

  .refund-st-open{background:#eef6ff!important;color:#0b5ed7!important;border-color:#90b7ff!important}
  .refund-st-closed{background:#eaf7ef!important;color:#198754!important;border-color:#7dd3a8!important}
  .refund-st-cancelled{background:#ffeaea!important;color:#dc3545!important;border-color:#ff9aa5!important}

  .refund-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:30px;height:30px;
    border-radius:10px;
    color:#fff;
    text-decoration:none;
    margin-right:6px;
    box-shadow:0 8px 18px rgba(0,0,0,.08);
  }
  .refund-btn-info{background:#17a2b8}
  .refund-btn:hover{filter:brightness(.96);transform:translateY(-1px)}
  .refund-btn:active{transform:translateY(0)}

  .refund-pagination{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:12px 4px 0;
  }
  .refund-muted{color:var(--rf-muted);font-size:12px}

  .pagination{margin:0}
  .pagination .page-item{margin:0 2px}
  .pagination .page-link{
    border-radius:10px;
    padding:.4rem .7rem;
    color:var(--rf-primary);
    background:#fff;
    border:1px solid rgba(0,123,255,.35);
    font-size:12px;
    font-weight:800;
    transition:.15s;
  }
  .pagination .page-link:hover{
    background:var(--rf-primary);
    color:#fff;
    border-color:var(--rf-primary);
    transform:translateY(-1px);
  }
  .pagination .page-item.active .page-link{
    background:var(--rf-primary);
    color:#fff;
    border-color:var(--rf-primary);
  }
  .pagination .page-item.disabled .page-link{
    color:var(--rf-muted);
    border-color:rgba(108,117,125,.35);
    cursor:not-allowed;
    transform:none;
  }

  @media (max-width: 900px){
    .refund-pagination{flex-direction:column;align-items:flex-start}
  }
</style>

@php
  $role = auth()->user()->role ?? '';
  $allowedRoles = ['Admin','Operations Manager','Managing Director','Accountant','Cashier','Finance Officer'];
  $canManage = in_array($role, $allowedRoles, true);

  $norm = function ($v) {
    $v = strtolower(trim((string)($v ?? 'open')));
    if ($v === 'canceled') return 'cancelled';
    return $v ?: 'open';
  };

  $cls = [
    'open' => 'refund-st-open',
    'closed' => 'refund-st-closed',
    'cancelled' => 'refund-st-cancelled',
  ];

  $stat = $refundStatusStats ?? [
    'open' => ['count'=>0,'amount'=>0],
    'closed' => ['count'=>0,'amount'=>0],
    'cancelled' => ['count'=>0,'amount'=>0],
  ];
@endphp

<div class="refund-wrap" data-refund-root="1">

  <div class="refund-stats">
    <div class="refund-card refund-card-open">
      <div class="l">
        <div class="refund-ic"><i class="fas fa-folder-open"></i></div>
        <div class="refund-meta">
          <div class="refund-title">Open</div>
          <div class="refund-sub">Total Refunded Amount</div>
        </div>
      </div>
      <div class="refund-r">
        <div class="refund-cnt">{{ (int)($stat['open']['count'] ?? 0) }}</div>
        <div class="refund-amt"><strong>QAR {{ number_format((float)($stat['open']['amount'] ?? 0), 2) }}</strong></div>
      </div>
    </div>

    <div class="refund-card refund-card-closed">
      <div class="l">
        <div class="refund-ic"><i class="fas fa-check-circle"></i></div>
        <div class="refund-meta">
          <div class="refund-title">Closed</div>
          <div class="refund-sub">Total Refunded Amount</div>
        </div>
      </div>
      <div class="refund-r">
        <div class="refund-cnt">{{ (int)($stat['closed']['count'] ?? 0) }}</div>
        <div class="refund-amt"><strong>QAR {{ number_format((float)($stat['closed']['amount'] ?? 0), 2) }}</strong></div>
      </div>
    </div>

    <div class="refund-card refund-card-cancelled">
      <div class="l">
        <div class="refund-ic"><i class="fas fa-times-circle"></i></div>
        <div class="refund-meta">
          <div class="refund-title">Cancelled</div>
          <div class="refund-sub">Total Refunded Amount</div>
        </div>
      </div>
      <div class="refund-r">
        <div class="refund-cnt">{{ (int)($stat['cancelled']['count'] ?? 0) }}</div>
        <div class="refund-amt"><strong>QAR {{ number_format((float)($stat['cancelled']['amount'] ?? 0), 2) }}</strong></div>
      </div>
    </div>
  </div>

  <div class="refund-table-container">
    <table class="refund-table table-striped table-hover">
      <thead>
        <tr>
          <th>Reference No</th>
          <th>Candidate Name</th>
          <th>Sponsor Name</th>
          <th>Passport No</th>
          <th>Nationality</th>
          <th>Foreign Partner</th>
          <th>Agreement No</th>
          <th>Contract Start</th>
          <th>Contract End</th>
          <th>Return Date</th>
          <th>Worked Days</th>
          <th>Amount</th>
          <th>Salary</th>
          <th>Worker Salary (Days)</th>
          <th>Payment Method</th>
          <th>Payment Proof</th>
          <th>Office Charges</th>
          <th>Refunded Amount</th>
          <th>Refund Date</th>
          <th>Original Passport</th>
          <th>Worker Belongings</th>
          <th>Status</th>
          <th>Sales Name</th>
          <th>Updated By</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        @forelse($refunds as $r)
          @php $st = $norm($r->status); @endphp
          <tr>
            <td>{{ strtoupper((string)($r->reference_no ?? '-')) }}</td>
            <td title="{{ $r->candidate_name }}">{{ strtoupper((string)($r->candidate_name ?? '-')) }}</td>
            <td title="{{ $r->sponsor_name }}">{{ strtoupper((string)($r->sponsor_name ?? '-')) }}</td>
            <td>{{ strtoupper((string)($r->passport_no ?? '-')) }}</td>
            <td>{{ strtoupper((string)($r->nationality ?? '-')) }}</td>
            <td>{{ strtoupper((string)($r->foreign_partner ?? '-')) }}</td>
            <td>{{ strtoupper((string)($r->agreement_no ?? '-')) }}</td>
            <td>{{ $r->contract_start_date ? \Carbon\Carbon::parse($r->contract_start_date)->format('d M Y') : '-' }}</td>
            <td>{{ $r->contract_end_date ? \Carbon\Carbon::parse($r->contract_end_date)->format('d M Y') : '-' }}</td>
            <td>{{ $r->return_date ? \Carbon\Carbon::parse($r->return_date)->format('d M Y') : '-' }}</td>
            <td>{{ $r->maid_worked_days ?? '-' }}</td>
            <td>QAR {{ number_format((float)($r->contracted_amount ?? 0), 2) }}</td>
            <td>QAR {{ number_format((float)($r->salary ?? 0), 2) }}</td>
            <td>QAR {{ number_format((float)($r->worker_salary_for_work_days ?? 0), 2) }}</td>
            <td>{{ strtoupper((string)($r->salary_payment_method ?? '-')) }}</td>
            <td>{{ (string)($r->payment_proof ?? '-') }}</td>
            <td>QAR {{ number_format((float)($r->office_charges ?? 0), 2) }}</td>
            <td>QAR {{ number_format((float)($r->refunded_amount ?? 0), 2) }}</td>
            <td>{{ $r->refund_date ? \Carbon\Carbon::parse($r->refund_date)->format('d M Y') : '-' }}</td>
            <td>{{ !empty($r->original_passport) ? 'YES' : 'NO' }}</td>
            <td>{{ !empty($r->worker_belongings) ? 'YES' : 'NO' }}</td>
            <td>
              @if($canManage)
                <select
                  class="refund-status-select {{ $cls[$st] ?? '' }}"
                  data-refund-status="1"
                  data-id="{{ $r->id }}"
                  data-original="{{ $st }}"
                  data-name="{{ strtoupper((string)($r->candidate_name ?? 'CANDIDATE')) }}"
                >
                  <option value="open" {{ $st==='open'?'selected':'' }}>OPEN</option>
                  <option value="closed" {{ $st==='closed'?'selected':'' }}>CLOSED</option>
                  <option value="cancelled" {{ $st==='cancelled'?'selected':'' }}>CANCELLED</option>
                </select>
              @else
                <span class="refund-status-text {{ $cls[$st] ?? '' }}">{{ strtoupper($st) }}</span>
              @endif
            </td>
            <td>{{ strtoupper((string)($r->sales_name ?? '-')) }}</td>
            <td>{{ strtoupper((string)($r->updated_by_sales_name ?? '-')) }}</td>
            <td>{{ $r->created_at ? \Carbon\Carbon::parse($r->created_at)->format('d M Y h:i A') : '-' }}</td>
            <td>{{ $r->updated_at ? \Carbon\Carbon::parse($r->updated_at)->format('d M Y h:i A') : '-' }}</td>
            <td>
              <a class="refund-btn refund-btn-info" href="{{ route('refunds.view', $r->id) }}" title="View Refund Form">
                <i class="fas fa-eye"></i>
              </a>
            </td>
          </tr>
        @empty
          <tr><td colspan="27" class="text-center">No results found.</td></tr>
        @endforelse
      </tbody>

      <tfoot>
        <tr>
          <th>Reference No</th>
          <th>Candidate Name</th>
          <th>Sponsor Name</th>
          <th>Passport No</th>
          <th>Nationality</th>
          <th>Foreign Partner</th>
          <th>Agreement No</th>
          <th>Contract Start</th>
          <th>Contract End</th>
          <th>Return Date</th>
          <th>Worked Days</th>
          <th>Amount</th>
          <th>Salary</th>
          <th>Worker Salary (Days)</th>
          <th>Payment Method</th>
          <th>Payment Proof</th>
          <th>Office Charges</th>
          <th>Refunded Amount</th>
          <th>Refund Date</th>
          <th>Original Passport</th>
          <th>Worker Belongings</th>
          <th>Status</th>
          <th>Sales Name</th>
          <th>Updated By</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <nav aria-label="Page navigation">
    <div class="refund-pagination">
      <span class="refund-muted">
        Showing {{ $refunds->firstItem() ?? 0 }} to {{ $refunds->lastItem() ?? 0 }} of {{ $refunds->total() ?? 0 }} results
      </span>
      <ul class="pagination justify-content-center">
        {{ $refunds->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
      </ul>
    </div>
  </nav>

</div>

<script>
(function(){
  if(window.__refundTableInit) return;
  window.__refundTableInit = true;

  function getCsrf(){
    var m = document.querySelector('meta[name="csrf-token"]');
    if(m && m.getAttribute('content')) return m.getAttribute('content');
    var i = document.querySelector('input[name="_token"]');
    if(i && i.value) return i.value;
    return '';
  }

  function norm(v){
    v=(v||'').toString().trim().toLowerCase();
    if(v==='canceled') v='cancelled';
    return v||'open';
  }

  function applyClass(el, st){
    st=norm(st);
    el.classList.remove('refund-st-open','refund-st-closed','refund-st-cancelled');
    if(st==='open') el.classList.add('refund-st-open');
    if(st==='closed') el.classList.add('refund-st-closed');
    if(st==='cancelled') el.classList.add('refund-st-cancelled');
  }

  function setOriginal(el, st){
    st=norm(st);
    el.value = st;
    el.setAttribute('data-original', st);
    applyClass(el, st);
  }

  function confirmBox(title, text){
    if(window.Swal && typeof Swal.fire==='function'){
      return Swal.fire({
        title:title,
        text:text,
        icon:'warning',
        showCancelButton:true,
        confirmButtonText:'Yes',
        cancelButtonText:'No',
        width:650
      });
    }
    return Promise.resolve({isConfirmed: window.confirm(text)});
  }

  function toast(icon, title, text){
    if(window.Swal && typeof Swal.fire==='function'){
      return Swal.fire({
        icon:icon,
        title:title,
        text:text,
        width:650,
        timer:1400,
        showConfirmButton:false
      });
    }
    alert((title?title+': ':'')+(text||''));
    return Promise.resolve();
  }

  function safeJson(res){
    return res.json().then(function(d){ return {ok:res.ok,status:res.status,data:d}; })
      .catch(function(){ return {ok:false,status:res.status,data:null}; });
  }

  function initSelectClasses(){
    document.querySelectorAll('[data-refund-status="1"]').forEach(function(el){
      setOriginal(el, norm(el.getAttribute('data-original') || el.value));
    });
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', initSelectClasses);
  } else {
    initSelectClasses();
  }

  document.addEventListener('change', function(e){
    var el=e.target;
    if(!el || !el.matches || !el.matches('[data-refund-status="1"]')) return;

    var id = el.getAttribute('data-id');
    var prev = norm(el.getAttribute('data-original') || 'open');
    var next = norm(el.value);
    var name = (el.getAttribute('data-name') || 'CANDIDATE').toString();
    var label = (next || '').toUpperCase();

    if(!id){
      setOriginal(el, prev);
      return;
    }

    confirmBox('Change status for '+name+'?', 'Switch to "'+label+'"?').then(function(res){
      if(!res || !res.isConfirmed){
        setOriginal(el, prev);
        return;
      }

      el.disabled = true;

      fetch("{{ route('refunds.updateStatus') }}",{
        method:'POST',
        credentials:'same-origin',
        headers:{
          'Content-Type':'application/json',
          'Accept':'application/json',
          'X-Requested-With':'XMLHttpRequest',
          'X-CSRF-TOKEN': getCsrf()
        },
        body: JSON.stringify({id:id,status:next})
      })
      .then(safeJson)
      .then(function(r){
        el.disabled = false;

        if(!r.ok || !r.data || r.data.success !== true){
          setOriginal(el, prev);
          return toast('error','Update failed', (r.data && r.data.message) ? r.data.message : 'Failed to update status.');
        }

        var finalSt = norm(r.data.status || next);
        setOriginal(el, finalSt);
        return toast('success','Updated', r.data.message || 'Status updated.');
      })
      .catch(function(){
        el.disabled = false;
        setOriginal(el, prev);
        toast('error','Error','Failed to update status. Please try again.');
      });
    });
  });

})();
</script>
