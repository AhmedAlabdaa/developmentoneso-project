<style>
  :root{
    --sal-primary:#007bff;
    --sal-primary2:#00c6ff;
    --sal-border:#e9ecef;
    --sal-muted:#6c757d;
    --sal-shadow:0 10px 28px rgba(0,0,0,.08);
    --sal-radius:14px;
    --sal-font:12px;
  }

  body{
    background:linear-gradient(to right,#e0f7fa,#e1bee7);
    font-family:Arial,sans-serif;
  }

  .sal-wrap{width:100%}

  .sal-stats{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    margin:14px 0;
  }

  .sal-card{
    flex:1 1 260px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:12px 14px;
    border-radius:var(--sal-radius);
    border:1px solid var(--sal-border);
    background:#fff;
    box-shadow:var(--sal-shadow);
    min-width:0;
  }
  .sal-card .l{display:flex;align-items:center;gap:10px;min-width:0}
  .sal-ic{
    width:38px;height:38px;border-radius:14px;
    display:flex;align-items:center;justify-content:center;
    font-size:16px;
    border:1px solid rgba(0,0,0,.07);
  }
  .sal-meta{display:flex;flex-direction:column;min-width:0}
  .sal-title{
    font-size:12px;
    font-weight:900;
    letter-spacing:.06em;
    text-transform:uppercase;
    line-height:1.05;
  }
  .sal-sub{
    font-size:12px;
    color:var(--sal-muted);
    margin-top:2px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }
  .sal-r{text-align:right;white-space:nowrap}
  .sal-cnt{font-size:16px;font-weight:950;line-height:1.05}
  .sal-amt{font-size:12px;color:var(--sal-muted);margin-top:2px}
  .sal-amt strong{color:#111;font-weight:950}

  .sal-card-pending .sal-ic{background:#fff7e8;color:#fd7e14}
  .sal-card-paid .sal-ic{background:#eaf7ef;color:#198754}
  .sal-card-partial .sal-ic{background:#eef6ff;color:#0b5ed7}
  .sal-card-cancelled .sal-ic{background:#ffeef0;color:#dc3545}

  .sal-table-container{
    width:100%;
    overflow-x:auto;
    border-radius:16px;
    border:1px solid var(--sal-border);
    background:#fff;
    box-shadow:var(--sal-shadow);
  }

  .sal-table{
    width:100%;
    border-collapse:collapse;
    margin:0;
    font-size:var(--sal-font);
  }
  .sal-table th,.sal-table td{
    padding:10px 14px;
    text-align:left;
    vertical-align:middle;
    border-bottom:1px solid #edf0f4;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }

  .sal-table thead th,
  .sal-table tfoot th{
    background:linear-gradient(to right,var(--sal-primary),var(--sal-primary2));
    color:#fff;
    text-transform:uppercase;
    font-weight:900;
    letter-spacing:.05em;
    border-bottom:0;
    position:sticky;
    top:0;
    z-index:2;
  }

  .sal-table tfoot th{
    position:sticky;
    bottom:0;
    top:auto;
    z-index:1;
  }

  .sal-table tbody tr:nth-of-type(odd){background:#f9fbff}
  .sal-table tbody tr:hover{background:#f1f7ff}

  .sal-status-select{
    min-width:165px;
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
  .sal-status-text{
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

  .sal-st-pending{background:#fff7e8!important;color:#fd7e14!important;border-color:#ffd19a!important}
  .sal-st-paid{background:#eaf7ef!important;color:#198754!important;border-color:#7dd3a8!important}
  .sal-st-partial_paid{background:#eef6ff!important;color:#0b5ed7!important;border-color:#90b7ff!important}
  .sal-st-cancelled{background:#ffeef0!important;color:#dc3545!important;border-color:#ff9aa6!important}

  .sal-btn{
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
  .sal-btn-info{background:#17a2b8}
  .sal-btn-warning{background:#ffc107;color:#111}
  .sal-btn:hover{filter:brightness(.96);transform:translateY(-1px)}
  .sal-btn:active{transform:translateY(0)}

  .sal-pagination{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:12px 4px 0;
  }
  .sal-muted{color:var(--sal-muted);font-size:12px}

  .pagination{margin:0}
  .pagination .page-item{margin:0 2px}
  .pagination .page-link{
    border-radius:10px;
    padding:.4rem .7rem;
    color:var(--sal-primary);
    background:#fff;
    border:1px solid rgba(0,123,255,.35);
    font-size:12px;
    font-weight:800;
    transition:.15s;
  }
  .pagination .page-link:hover{
    background:var(--sal-primary);
    color:#fff;
    border-color:var(--sal-primary);
    transform:translateY(-1px);
  }
  .pagination .page-item.active .page-link{
    background:var(--sal-primary);
    color:#fff;
    border-color:var(--sal-primary);
  }
  .pagination .page-item.disabled .page-link{
    color:var(--sal-muted);
    border-color:rgba(108,117,125,.35);
    cursor:not-allowed;
    transform:none;
  }

  @media (max-width: 900px){
    .sal-pagination{flex-direction:column;align-items:flex-start}
  }
</style>

<?php
  $role = auth()->user()->role ?? '';
  $allowedRoles = ['Admin','Operations Manager','Managing Director','Accountant','Cashier','Finance Officer'];
  $canManage = in_array($role, $allowedRoles, true);

  $norm = function ($v) {
    $v = strtolower(trim((string)($v ?? 'pending')));
    if ($v === 'canceled') return 'cancelled';
    if ($v === 'partial paid' || $v === 'partialpaid') return 'partial_paid';
    return $v ?: 'pending';
  };

  $cls = [
    'pending' => 'sal-st-pending',
    'paid' => 'sal-st-paid',
    'partial_paid' => 'sal-st-partial_paid',
    'cancelled' => 'sal-st-cancelled',
  ];

  $stat = $salaryStatusStats ?? [
    'pending' => ['count'=>0,'amount'=>0],
    'paid' => ['count'=>0,'amount'=>0],
    'partial_paid' => ['count'=>0,'amount'=>0],
    'cancelled' => ['count'=>0,'amount'=>0],
  ];
?>

<div class="sal-wrap" data-sal-root="1">

  <div class="sal-stats">
    <div class="sal-card sal-card-pending">
      <div class="l">
        <div class="sal-ic"><i class="fas fa-hourglass-half"></i></div>
        <div class="sal-meta">
          <div class="sal-title">Pending</div>
          <div class="sal-sub">Total Salary (Work Days)</div>
        </div>
      </div>
      <div class="sal-r">
        <div class="sal-cnt"><?php echo e((int)($stat['pending']['count'] ?? 0)); ?></div>
        <div class="sal-amt"><strong>QAR <?php echo e(number_format((float)($stat['pending']['amount'] ?? 0), 2)); ?></strong></div>
      </div>
    </div>

    <div class="sal-card sal-card-paid">
      <div class="l">
        <div class="sal-ic"><i class="fas fa-check-circle"></i></div>
        <div class="sal-meta">
          <div class="sal-title">Paid</div>
          <div class="sal-sub">Total Salary (Work Days)</div>
        </div>
      </div>
      <div class="sal-r">
        <div class="sal-cnt"><?php echo e((int)($stat['paid']['count'] ?? 0)); ?></div>
        <div class="sal-amt"><strong>QAR <?php echo e(number_format((float)($stat['paid']['amount'] ?? 0), 2)); ?></strong></div>
      </div>
    </div>

    <div class="sal-card sal-card-partial">
      <div class="l">
        <div class="sal-ic"><i class="fas fa-adjust"></i></div>
        <div class="sal-meta">
          <div class="sal-title">Partial Paid</div>
          <div class="sal-sub">Total Salary (Work Days)</div>
        </div>
      </div>
      <div class="sal-r">
        <div class="sal-cnt"><?php echo e((int)($stat['partial_paid']['count'] ?? 0)); ?></div>
        <div class="sal-amt"><strong>QAR <?php echo e(number_format((float)($stat['partial_paid']['amount'] ?? 0), 2)); ?></strong></div>
      </div>
    </div>

    <div class="sal-card sal-card-cancelled">
      <div class="l">
        <div class="sal-ic"><i class="fas fa-times-circle"></i></div>
        <div class="sal-meta">
          <div class="sal-title">Cancelled</div>
          <div class="sal-sub">Total Salary (Work Days)</div>
        </div>
      </div>
      <div class="sal-r">
        <div class="sal-cnt"><?php echo e((int)($stat['cancelled']['count'] ?? 0)); ?></div>
        <div class="sal-amt"><strong>QAR <?php echo e(number_format((float)($stat['cancelled']['amount'] ?? 0), 2)); ?></strong></div>
      </div>
    </div>
  </div>

  <div class="sal-table-container">
    <table class="sal-table table-striped table-hover">
      <thead>
        <tr>
          <th>Reference No</th>
          <th>Passport No</th>
          <th>Nationality</th>
          <th>Foreign Partner</th>
          <th>Agreement No</th>
          <th>Work Days</th>
          <th>Total Salary</th>
          <th>Salary (Work Days)</th>
          <th>Sales Name</th>
          <th>Status</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $salaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php $st = $norm($s->status); ?>
          <tr>
            <td><?php echo e(strtoupper((string)($s->reference_no ?? '-'))); ?></td>
            <td><?php echo e(strtoupper((string)($s->passport_no ?? '-'))); ?></td>
            <td><?php echo e(strtoupper((string)($s->nationality ?? '-'))); ?></td>
            <td><?php echo e(strtoupper((string)($s->foreign_partner ?? '-'))); ?></td>
            <td><?php echo e(strtoupper((string)($s->agreement_no ?? '-'))); ?></td>
            <td><?php echo e($s->number_of_work_days ?? $s->work_days ?? '-'); ?></td>
            <td>QAR <?php echo e(number_format((float)($s->maid_salary ?? $s->total_salary ?? 0), 2)); ?></td>
            <td>QAR <?php echo e(number_format((float)($s->salary_for_work_days ?? 0), 2)); ?></td>
            <td><?php echo e(strtoupper((string)($s->sales_name ?? '-'))); ?></td>
            <td>
              <?php if($canManage): ?>
                <select
                  class="sal-status-select <?php echo e($cls[$st] ?? ''); ?>"
                  data-sal-status="1"
                  data-id="<?php echo e($s->id); ?>"
                  data-original="<?php echo e($st); ?>"
                  data-name="<?php echo e(strtoupper((string)($s->passport_no ?? 'EMPLOYEE'))); ?>"
                >
                  <option value="pending" <?php echo e($st==='pending'?'selected':''); ?>>PENDING</option>
                  <option value="paid" <?php echo e($st==='paid'?'selected':''); ?>>PAID</option>
                  <option value="partial_paid" <?php echo e($st==='partial_paid'?'selected':''); ?>>PARTIAL PAID</option>
                  <option value="cancelled" <?php echo e($st==='cancelled'?'selected':''); ?>>CANCELLED</option>
                </select>
              <?php else: ?>
                <span class="sal-status-text <?php echo e($cls[$st] ?? ''); ?>"><?php echo e(strtoupper(str_replace('_',' ',$st))); ?></span>
              <?php endif; ?>
            </td>
            <td><?php echo e($s->created_at ? \Carbon\Carbon::parse($s->created_at)->format('d M Y h:i A') : '-'); ?></td>
            <td><?php echo e($s->updated_at ? \Carbon\Carbon::parse($s->updated_at)->format('d M Y h:i A') : '-'); ?></td>
            <td>
              <a class="sal-btn sal-btn-info" href="<?php echo e(route('salaries.show', $s->id)); ?>" title="View"><i class="fas fa-eye"></i></a>
              <a class="sal-btn sal-btn-warning" href="<?php echo e(route('salaries.edit', $s->id)); ?>" title="Edit"><i class="fas fa-pen"></i></a>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="14" class="text-center">No results found.</td></tr>
        <?php endif; ?>
      </tbody>

      <tfoot>
        <tr>
          <th>Reference No</th>
          <th>Passport No</th>
          <th>Nationality</th>
          <th>Foreign Partner</th>
          <th>Agreement No</th>
          <th>Work Days</th>
          <th>Total Salary</th>
          <th>Salary (Work Days)</th>
          <th>Sales Name</th>
          <th>Status</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <nav aria-label="Page navigation">
    <div class="sal-pagination">
      <span class="sal-muted">Showing <?php echo e($salaries->firstItem()); ?> to <?php echo e($salaries->lastItem()); ?> of <?php echo e($salaries->total()); ?> results</span>
      <ul class="pagination justify-content-center">
        <?php echo e($salaries->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

      </ul>
    </div>
  </nav>

</div>

<script>
(function(){
  if(window.__salariesTableInit) return;
  window.__salariesTableInit = true;

  function norm(v){
    v=(v||'').toString().trim().toLowerCase();
    if(v==='canceled') v='cancelled';
    if(v==='partial paid' || v==='partialpaid') v='partial_paid';
    return v||'pending';
  }

  function applyClass(el, st){
    st=norm(st);
    el.classList.remove('sal-st-pending','sal-st-paid','sal-st-partial_paid','sal-st-cancelled');
    if(st==='pending') el.classList.add('sal-st-pending');
    if(st==='paid') el.classList.add('sal-st-paid');
    if(st==='partial_paid') el.classList.add('sal-st-partial_paid');
    if(st==='cancelled') el.classList.add('sal-st-cancelled');
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
    document.querySelectorAll('[data-sal-status="1"]').forEach(function(el){
      setOriginal(el, norm(el.getAttribute('data-original') || el.value));
    });
  });

  document.addEventListener('change', function(e){
    var el=e.target;
    if(!el || !el.matches || !el.matches('[data-sal-status="1"]')) return;

    var id=el.getAttribute('data-id');
    var prev=norm(el.getAttribute('data-original')||'pending');
    var next=norm(el.value);
    var name=(el.getAttribute('data-name')||'EMPLOYEE').toString();
    var label=(next||'').replace('_',' ').toUpperCase();

    if(!id){ setOriginal(el, prev); return; }

    confirmBox('Change status for '+name+'?', 'Switch to "'+label+'"?').then(function(res){
      if(!res || !res.isConfirmed){ setOriginal(el, prev); return; }

      el.disabled=true;

      fetch("<?php echo e(route('salaries.updateStatus')); ?>",{
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
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/partials/salaries_table.blade.php ENDPATH**/ ?>