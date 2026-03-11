<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
  .table th,.table td{vertical-align:middle;text-align:center}
  .contract-info{margin-top:10px}
  .contract-info small{font-size:12px;color:#343a40}
  .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;font-weight:normal}
  .alert i{margin-right:8px}
  .action-buttons{display:flex;justify-content:center;gap:.5rem;flex-wrap:wrap;margin-bottom:.5rem;margin-top:.25rem}
  .action-buttons .btn{min-width:190px;height:38px;display:flex;align-items:center;justify-content:center}
  .action-buttons .btn i{margin-right:8px}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card">
      <div class="card-body">

        <div class="action-buttons">
          <a href="<?php echo e(route('contracts.index')); ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Contracts
          </a>
          <?php $isApproved = ($contract->marked === 'Yes'); ?>
          <button id="btnToggleApproval" class="btn btn-sm <?php echo e($isApproved ? 'btn-outline-danger' : 'btn-success'); ?>" data-marked="<?php echo e($isApproved ? 'Yes' : 'No'); ?>" type="button">
            <?php if($isApproved): ?>
              <i class="fas fa-ban"></i> De-Approve
            <?php else: ?>
              <i class="fas fa-check-circle"></i> Approve
            <?php endif; ?>
          </button>
        </div>

        <div class="contract-info text-start">
          <small>Contract Reference No:</small>
          <strong><?php echo e($contract->reference_no); ?></strong>
        </div>

        <div class="table-responsive mt-3">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Candidate Name</th>
                <th>Client Name</th>
                <th>Contract Date</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo e(strtoupper($contract->candidate_name)); ?></td>
                <td><?php echo e(strtoupper(optional($contract->client)->first_name . ' ' . optional($contract->client)->last_name)); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($contract->created_at)->format('d M Y')); ?></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div id="statusAlert" class="alert <?php echo e($isApproved ? 'alert-success' : 'alert-warning'); ?> text-center mt-4">
          <?php if($isApproved): ?>
            <i class="fas fa-check-circle"></i>
            This contract is approved by management.
          <?php else: ?>
            <i class="fas fa-exclamation-triangle"></i>
            This contract is not yet verified by management.<br>
            <i class="fas fa-info-circle"></i>
            Please request management approval before performing any actions.
          <?php endif; ?>
        </div>

        <div id="flashArea"></div>
      </div>
    </div>
  </section>
</main>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<script>
  (function () {
    const btn = document.getElementById('btnToggleApproval');
    const refNo = <?php echo json_encode($contract->reference_no, 15, 512) ?>;
    const token = document.querySelector('meta[name="csrf-token"]').content;
    const statusAlert = document.getElementById('statusAlert');
    const flashArea = document.getElementById('flashArea');

    function setLoading(state){btn.disabled=state;btn.dataset.loading=state?'1':'0';}
    function flash(message,type='success'){const el=document.createElement('div');el.className=`alert alert-${type} mt-3 text-center`;el.innerHTML=message;flashArea.innerHTML='';flashArea.appendChild(el);setTimeout(()=>{el.remove();},1800);}
    function renderButton(marked){
      btn.dataset.marked=marked;
      if(marked==='Yes'){
        btn.classList.remove('btn-success');
        btn.classList.add('btn-outline-danger');
        btn.innerHTML=`<i class="fas fa-ban"></i> De-Approve`;
        statusAlert.classList.remove('alert-warning');
        statusAlert.classList.add('alert-success');
        statusAlert.innerHTML=`<i class="fas fa-check-circle"></i> This contract is approved by management.`;
      }else{
        btn.classList.remove('btn-outline-danger');
        btn.classList.add('btn-success');
        btn.innerHTML=`<i class="fas fa-check-circle"></i> Approve`;
        statusAlert.classList.remove('alert-success');
        statusAlert.classList.add('alert-warning');
        statusAlert.innerHTML=`<i class="fas fa-exclamation-triangle"></i> This contract is not yet verified by management.<br><i class="fas fa-info-circle"></i> Please request management approval before performing any actions.`;
      }
    }

    btn.addEventListener('click',function(){
      const current=btn.dataset.marked;
      const nextVal=current==='Yes'?'No':'Yes';
      setLoading(true);
      fetch(`<?php echo e(route('contracts.update-marked')); ?>`,{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':token,'Accept':'application/json'},
        body:JSON.stringify({reference_no:refNo,marked:nextVal})
      })
      .then(async res=>{if(!res.ok){let msg='Failed to update approval status.';try{const j=await res.json();if(j?.message)msg=j.message;}catch(e){}throw new Error(msg);}return res.json();})
      .then(data=>{
        renderButton(data.marked==='Yes'?'Yes':'No');
        flash(`<i class="fas fa-check"></i> Status updated to <strong>${data.marked==='Yes'?'Approved':'Not Approved'}</strong>.`,'success');
        setTimeout(()=>{location.reload();},2000);
      })
      .catch(err=>{flash(`<i class="fas fa-times-circle"></i> ${err.message}`,'danger');})
      .finally(()=>setLoading(false));
    });
  })();
</script>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/contracts/contract_not_approved_page.blade.php ENDPATH**/ ?>