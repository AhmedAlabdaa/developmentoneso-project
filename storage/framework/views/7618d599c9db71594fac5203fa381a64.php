<style>
  :root{
    --rm-primary:#007bff;
    --rm-primary2:#00c6ff;
    --rm-border:#e9ecef;
    --rm-muted:#6c757d;
    --rm-shadow:0 10px 28px rgba(0,0,0,.08);
    --rm-radius:14px;
    --rm-font:12px;
  }

  body{
    background:linear-gradient(to right,#e0f7fa,#e1bee7);
    font-family:Arial,sans-serif;
  }

  .remit-wrap{width:100%}

  .remit-stats{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    margin:14px 0;
  }

  .remit-card{
    flex:1 1 260px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:12px 14px;
    border-radius:var(--rm-radius);
    border:1px solid var(--rm-border);
    background:#fff;
    box-shadow:var(--rm-shadow);
    min-width:0;
  }
  .remit-card .l{display:flex;align-items:center;gap:10px;min-width:0}
  .remit-ic{
    width:38px;height:38px;border-radius:14px;
    display:flex;align-items:center;justify-content:center;
    font-size:16px;
    border:1px solid rgba(0,0,0,.07);
  }
  .remit-meta{display:flex;flex-direction:column;min-width:0}
  .remit-title{
    font-size:12px;
    font-weight:900;
    letter-spacing:.06em;
    text-transform:uppercase;
    line-height:1.05;
  }
  .remit-sub{
    font-size:12px;
    color:var(--rm-muted);
    margin-top:2px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }
  .remit-r{text-align:right;white-space:nowrap}
  .remit-cnt{font-size:16px;font-weight:950;line-height:1.05}
  .remit-amt{font-size:12px;color:var(--rm-muted);margin-top:2px}
  .remit-amt strong{color:#111;font-weight:950}

  .remit-card-pending .remit-ic{background:#fff7e6;color:#b45309}
  .remit-card-paid .remit-ic{background:#eaf7ef;color:#198754}
  .remit-card-partial .remit-ic{background:#eef6ff;color:#0b5ed7}

  .remit-table-container{
    width:100%;
    overflow-x:auto;
    border-radius:16px;
    border:1px solid var(--rm-border);
    background:#fff;
    box-shadow:var(--rm-shadow);
  }

  .remit-table{
    width:100%;
    border-collapse:collapse;
    margin:0;
    font-size:var(--rm-font);
  }
  .remit-table th,.remit-table td{
    padding:10px 14px;
    text-align:left;
    vertical-align:middle;
    border-bottom:1px solid #edf0f4;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }

  .remit-table thead th,
  .remit-table tfoot th{
    background:linear-gradient(to right,var(--rm-primary),var(--rm-primary2));
    color:#fff;
    text-transform:uppercase;
    font-weight:900;
    letter-spacing:.05em;
    border-bottom:0;
    position:sticky;
    top:0;
    z-index:2;
  }

  .remit-table tfoot th{
    position:sticky;
    bottom:0;
    top:auto;
    z-index:1;
  }

  .remit-table tbody tr:nth-of-type(odd){background:#f9fbff}
  .remit-table tbody tr:hover{background:#f1f7ff}

  .remit-status-select{
    min-width:150px;
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
  .remit-status-text{
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

  .remit-st-pending{background:#fff7e6!important;color:#b45309!important;border-color:#f5c18b!important}
  .remit-st-paid{background:#eaf7ef!important;color:#198754!important;border-color:#7dd3a8!important}
  .remit-st-partial_paid{background:#eef6ff!important;color:#0b5ed7!important;border-color:#90b7ff!important}

  .remit-btn{
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
  .remit-btn-info{background:#17a2b8}
  .remit-btn-warning{background:#ffc107;color:#111}
  .remit-btn:hover{filter:brightness(.96);transform:translateY(-1px)}
  .remit-btn:active{transform:translateY(0)}

  .remit-pagination{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:12px 4px 0;
  }
  .remit-muted{color:var(--rm-muted);font-size:12px}

  .pagination{margin:0}
  .pagination .page-item{margin:0 2px}
  .pagination .page-link{
    border-radius:10px;
    padding:.4rem .7rem;
    color:var(--rm-primary);
    background:#fff;
    border:1px solid rgba(0,123,255,.35);
    font-size:12px;
    font-weight:800;
    transition:.15s;
  }
  .pagination .page-link:hover{
    background:var(--rm-primary);
    color:#fff;
    border-color:var(--rm-primary);
    transform:translateY(-1px);
  }
  .pagination .page-item.active .page-link{
    background:var(--rm-primary);
    color:#fff;
    border-color:var(--rm-primary);
  }
  .pagination .page-item.disabled .page-link{
    color:var(--rm-muted);
    border-color:rgba(108,117,125,.35);
    cursor:not-allowed;
    transform:none;
  }

  @media (max-width: 900px){
    .remit-pagination{flex-direction:column;align-items:flex-start}
  }
</style>

<?php
  $role = auth()->user()->role ?? '';
  $allowedRoles = ['Admin','Operations Manager','Managing Director','Accountant','Cashier','Finance Officer'];
  $canManage = in_array($role, $allowedRoles, true);

  $norm = function ($v) {
    $v = strtolower(trim((string)($v ?? 'pending')));
    if ($v === 'partial paid' || $v === 'partialpaid') return 'partial_paid';
    return $v ?: 'pending';
  };

  $cls = [
    'pending' => 'remit-st-pending',
    'paid' => 'remit-st-paid',
    'partial_paid' => 'remit-st-partial_paid',
  ];

  $stat = $remittanceStatusStats ?? [
    'pending' => ['count'=>0,'amount'=>0],
    'paid' => ['count'=>0,'amount'=>0],
    'partial_paid' => ['count'=>0,'amount'=>0],
  ];
?>

<div class="remit-wrap" data-remit-root="1">

  <div class="remit-stats">
    <div class="remit-card remit-card-pending">
      <div class="l">
        <div class="remit-ic"><i class="fas fa-hourglass-half"></i></div>
        <div class="remit-meta">
          <div class="remit-title">Pending</div>
          <div class="remit-sub">Total Amount</div>
        </div>
      </div>
      <div class="remit-r">
        <div class="remit-cnt"><?php echo e((int)($stat['pending']['count'] ?? 0)); ?></div>
        <div class="remit-amt"><strong>QAR <?php echo e(number_format((float)($stat['pending']['amount'] ?? 0), 2)); ?></strong></div>
      </div>
    </div>

    <div class="remit-card remit-card-paid">
      <div class="l">
        <div class="remit-ic"><i class="fas fa-check-circle"></i></div>
        <div class="remit-meta">
          <div class="remit-title">Paid</div>
          <div class="remit-sub">Total Amount</div>
        </div>
      </div>
      <div class="remit-r">
        <div class="remit-cnt"><?php echo e((int)($stat['paid']['count'] ?? 0)); ?></div>
        <div class="remit-amt"><strong>QAR <?php echo e(number_format((float)($stat['paid']['amount'] ?? 0), 2)); ?></strong></div>
      </div>
    </div>

    <div class="remit-card remit-card-partial">
      <div class="l">
        <div class="remit-ic"><i class="fas fa-adjust"></i></div>
        <div class="remit-meta">
          <div class="remit-title">Partial Paid</div>
          <div class="remit-sub">Total Amount</div>
        </div>
      </div>
      <div class="remit-r">
        <div class="remit-cnt"><?php echo e((int)($stat['partial_paid']['count'] ?? 0)); ?></div>
        <div class="remit-amt"><strong>QAR <?php echo e(number_format((float)($stat['partial_paid']['amount'] ?? 0), 2)); ?></strong></div>
      </div>
    </div>
  </div>

  <div class="remit-table-container">
    <table class="remit-table table-striped table-hover">
      <thead>
        <tr>
          <th>Reference No</th>
          <th>Candidate Name</th>
          <th>Passport No</th>
          <th>Nationality</th>
          <th>Foreign Partner</th>
          <th>Amount</th>
          <th>Sales Name</th>
          <th>Status</th>
          <th>Payment Method</th>
          <th>Payment Proof</th>
          <th>Paid Date</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $remittances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php $st = $norm($r->status); ?>
          <tr>
            <td><?php echo e(strtoupper((string)($r->reference_no ?? '-'))); ?></td>
            <td title="<?php echo e($r->candidate_name); ?>"><?php echo e(strtoupper((string)($r->candidate_name ?? '-'))); ?></td>
            <td><?php echo e(strtoupper((string)($r->passport_no ?? '-'))); ?></td>
            <td><?php echo e(strtoupper((string)($r->nationality ?? '-'))); ?></td>
            <td><?php echo e(strtoupper((string)($r->foreign_partner ?? '-'))); ?></td>
            <td>QAR <?php echo e(number_format((float)($r->amount ?? 0), 2)); ?></td>
            <td><?php echo e(strtoupper((string)($r->sales_name ?? '-'))); ?></td>
            <td>
              <?php if($canManage): ?>
                <select
                  class="remit-status-select <?php echo e($cls[$st] ?? ''); ?>"
                  data-remit-status="1"
                  data-id="<?php echo e($r->id); ?>"
                  data-original="<?php echo e($st); ?>"
                  data-name="<?php echo e(strtoupper((string)($r->candidate_name ?? 'CANDIDATE'))); ?>"
                >
                  <option value="pending" <?php echo e($st==='pending'?'selected':''); ?>>PENDING</option>
                  <option value="paid" <?php echo e($st==='paid'?'selected':''); ?>>PAID</option>
                  <option value="partial_paid" <?php echo e($st==='partial_paid'?'selected':''); ?>>PARTIAL PAID</option>
                </select>
              <?php else: ?>
                <span class="remit-status-text <?php echo e($cls[$st] ?? ''); ?>"><?php echo e(strtoupper(str_replace('_',' ',$st))); ?></span>
              <?php endif; ?>
            </td>
            <td><?php echo e(strtoupper((string)($r->payment_method ?? '-'))); ?></td>
            <td><?php echo e((string)($r->payment_proof ?? '-')); ?></td>
            <td><?php echo e($r->paid_date ? \Carbon\Carbon::parse($r->paid_date)->format('d M Y') : '-'); ?></td>
            <td><?php echo e($r->created_at ? \Carbon\Carbon::parse($r->created_at)->format('d M Y h:i A') : '-'); ?></td>
            <td><?php echo e($r->updated_at ? \Carbon\Carbon::parse($r->updated_at)->format('d M Y h:i A') : '-'); ?></td>
            <td>
              <a class="remit-btn remit-btn-info" href="<?php echo e(route('remittances.show', $r->id)); ?>" title="View"><i class="fas fa-eye"></i></a>
              <a class="remit-btn remit-btn-warning" href="<?php echo e(route('remittances.edit', $r->id)); ?>" title="Edit"><i class="fas fa-pen"></i></a>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="15" class="text-center">No results found.</td></tr>
        <?php endif; ?>
      </tbody>

      <tfoot>
        <tr>
          <th>Reference No</th>
          <th>Candidate Name</th>
          <th>Passport No</th>
          <th>Nationality</th>
          <th>Foreign Partner</th>
          <th>Amount</th>
          <th>Sales Name</th>
          <th>Status</th>
          <th>Payment Method</th>
          <th>Payment Proof</th>
          <th>Paid Date</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <nav aria-label="Page navigation">
    <div class="remit-pagination">
      <span class="remit-muted">Showing <?php echo e($remittances->firstItem()); ?> to <?php echo e($remittances->lastItem()); ?> of <?php echo e($remittances->total()); ?> results</span>
      <ul class="pagination justify-content-center">
        <?php echo e($remittances->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

      </ul>
    </div>
  </nav>

</div>

<script>
(function(){
  if(window.__remittanceTableInit) return;
  window.__remittanceTableInit = true;

  function norm(v){
    v=(v||'').toString().trim().toLowerCase();
    if(v==='partial paid' || v==='partialpaid') v='partial_paid';
    return v||'pending';
  }

  function applyClass(el, st){
    st=norm(st);
    el.classList.remove('remit-st-pending','remit-st-paid','remit-st-partial_paid');
    if(st==='pending') el.classList.add('remit-st-pending');
    if(st==='paid') el.classList.add('remit-st-paid');
    if(st==='partial_paid') el.classList.add('remit-st-partial_paid');
  }

  function setOriginal(el, st){
    st=norm(st);
    el.value=st;
    el.setAttribute('data-original', st);
    applyClass(el, st);
  }

  function confirmBox(title, text){
    if(window.Swal && typeof Swal.fire==='function'){
      return Swal.fire({title:title,text:text,icon:'warning',showCancelButton:true,confirmButtonText:'Yes',cancelButtonText:'No',width:650});
    }
    return Promise.resolve({isConfirmed: window.confirm(text)});
  }

  function toast(icon, title, text){
    if(window.Swal && typeof Swal.fire==='function'){
      return Swal.fire({icon:icon,title:title,text:text,width:650,timer:1400,showConfirmButton:false});
    }
    alert((title?title+': ':'')+(text||''));
    return Promise.resolve();
  }

  document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('[data-remit-status="1"]').forEach(function(el){
      setOriginal(el, norm(el.getAttribute('data-original') || el.value));
    });
  });

  document.addEventListener('change', function(e){
    var el=e.target;
    if(!el || !el.matches || !el.matches('[data-remit-status="1"]')) return;

    var id=el.getAttribute('data-id');
    var prev=norm(el.getAttribute('data-original')||'pending');
    var next=norm(el.value);
    var name=(el.getAttribute('data-name')||'CANDIDATE').toString();
    var label=(next||'').replace('_',' ').toUpperCase();

    if(!id){ setOriginal(el, prev); return; }

    confirmBox('Change status for '+name+'?', 'Switch to "'+label+'"?').then(function(res){
      if(!res || !res.isConfirmed){ setOriginal(el, prev); return; }

      el.disabled=true;

      fetch("<?php echo e(route('remittances.updateStatus')); ?>",{
        method:'POST',
        credentials:'same-origin',
        headers:{
          'Content-Type':'application/json',
          'Accept':'application/json',
          'X-Requested-With':'XMLHttpRequest'
        },
        body: JSON.stringify({id:id,status:next})
      })
      .then(function(r){
        return r.json().then(function(d){ return {ok:r.ok,data:d}; }).catch(function(){ return {ok:false,data:null}; });
      })
      .then(function(res2){
        el.disabled=false;
        if(!res2.ok || !res2.data || res2.data.success!==true){
          setOriginal(el, prev);
          return toast('error','Update failed', (res2.data && res2.data.message) ? res2.data.message : 'Failed to update status.');
        }
        var finalSt=norm(res2.data.status || next);
        setOriginal(el, finalSt);
        return toast('success','Updated', res2.data.message || 'Status updated.');
      })
      .catch(function(){
        el.disabled=false;
        setOriginal(el, prev);
        toast('error','Error','Failed to update status. Please try again.');
      });
    });
  });

})();
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/partials/remittance_table.blade.php ENDPATH**/ ?>