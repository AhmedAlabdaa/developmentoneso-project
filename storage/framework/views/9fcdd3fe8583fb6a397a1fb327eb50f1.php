<!-- resources/views/packages/refunds/edit.blade.php -->
<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<?php
  use Carbon\Carbon;

  $val = fn($v) => old($v, $refund->$v ?? '');
  $valNum = fn($v) => old($v, isset($refund->$v) ? (string) $refund->$v : '');

  $valDate = function ($v) use ($refund) {
      $old = old($v);
      if ($old !== null && $old !== '') {
          return $old;
      }
      $raw = $refund->$v ?? null;
      if (!$raw) {
          return '';
      }
      $dt = $raw instanceof Carbon ? $raw : Carbon::parse($raw);
      return $dt->format('Y-m-d');
  };

  $valDT = function ($v) use ($refund) {
      $old = old($v);
      if ($old !== null && $old !== '') {
          return $old;
      }
      $raw = $refund->$v ?? null;
      if (!$raw) {
          return '';
      }
      $dt = $raw instanceof Carbon ? $raw : Carbon::parse($raw);
      return $dt->format('Y-m-d\TH:i');
  };

  $fileUrl = function (?string $path) {
      if (!$path) return null;
      $clean = trim($path, '/');
      $clean = preg_replace('#^storage/app/public/#', '', $clean);
      $clean = preg_replace('#^app/public/#', '', $clean);
      $clean = preg_replace('#^public/#', '', $clean);
      return url('storage/app/public/'.$clean);
  };

  $isImage = fn($p) => $p && preg_match('/\.(jpe?g|png|gif|webp|bmp)$/i', $p);

  $refundReasons = $refundReasons ?? [
      'NOT SATISFIED','UNSKILLED','LANGUAGE ISSUE','BEHAVIOR ISSUES','MOBILE USAGE',
      'HEALTH REASONS','REFUSE TO WORK','MOI ISSUE - FROM PREVIOUS SPO','OTHER'
  ];

  $salaryTypes = [
      'Customer paid to Office by Cash',
      'Customer paid to Office by Bank Transfer',
      'Paid to Worker',
      'Deduct From Balance'
  ];

  $passportWhere = ['Office','Sponsor'];
  $belongingsWhere = ['Office','Sponsor House','Accommodation','Others'];
?>

<style>
  :root{--c-primary:#0d6efd;--c-muted:#6c757d;--pad:1rem;--radius:.6rem;--bg-soft:#f7f9fc}
  .wrap{max-width:1100px;margin:0 auto;padding:var(--pad)}
  .card{border:1px solid #e5e8ef;border-radius:var(--radius);background:#fff}
  .card + .card{margin-top:var(--pad)}
  .card-hdr{display:flex;align-items:center;justify-content:space-between;padding:.8rem 1rem}
  .title{margin:0;font-size:1.15rem;font-weight:700}
  .sub{color:var(--c-muted);font-size:.85rem}
  .sect{padding:.5rem 1rem;font-weight:700}
  .grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;padding:0 1rem 1rem}
  .grid-1{display:grid;grid-template-columns:1fr;gap:12px;padding:0 1rem 1rem}
  .row-soft{background:var(--bg-soft);border-top:1px dashed #e5e8ef;border-bottom:1px dashed #e5e8ef}
  .form-label{font-weight:600;font-size:.9rem;margin-bottom:.25rem}
  .form-control,.form-select{border:1px solid #dfe3ea;border-radius:.5rem;height:38px;padding:.5rem .65rem}
  textarea.form-control{height:auto;min-height:90px}
  .form-control:focus,.form-select:focus{border-color:#b9d1ff;outline:0;box-shadow:0 0 0 .2rem rgba(13,110,253,.08)}
  .btns{display:flex;gap:.5rem;padding:1rem}
  .preview{display:flex;align-items:center;gap:.5rem}
  .thumb{max-height:56px;max-width:100px;border:1px solid #e5e8ef;border-radius:.35rem}
  .hint{font-size:.8rem;color:var(--c-muted)}
  @media (max-width:768px){.grid{grid-template-columns:1fr}}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="wrap">

      <?php if($errors->any()): ?>
        <div class="card" style="border-color:#f1c0c7;background:#fff5f6">
          <div class="grid-1">
            <div>
              <div class="form-label" style="color:#842029">Please fix the following</div>
              <ul style="margin:0 0 0 1rem;color:#842029">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <div class="card">
        <div class="card-hdr">
          <div>
            <h5 class="title">Edit Refund / Replacement</h5>
            <div class="sub">
              CN: <?php echo e($refund->cn_number ?? '-'); ?>

              • Candidate: <?php echo e($refund->candidate_name ?? '-'); ?>

              • Type: <?php echo e(ucfirst($refund->action_type ?? '-')); ?>

            </div>
          </div>
          <div class="btns">
            <a href="<?php echo e(route('refunds.show',['refund'=>$refund->id])); ?>" class="btn btn-outline-secondary">
              <i class="fa-solid fa-eye me-1"></i>View
            </a>
            <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline-secondary">
              <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
          </div>
        </div>

        <form action="<?php echo e(route('refunds.update',['refund'=>$refund->id])); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>

          <div class="sect">Core</div>
          <div class="grid">
            <div>
              <label class="form-label">Action Type</label>
              <select name="action_type" class="form-select js-action-type">
                <option value="refund" <?php echo e($val('action_type')==='refund'?'selected':''); ?>>Refund</option>
                <option value="replacement" <?php echo e($val('action_type')==='replacement'?'selected':''); ?>>Replacement</option>
              </select>
            </div>
            <div>
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="pending" <?php echo e($val('status')==='pending'?'selected':''); ?>>Pending</option>
                <option value="approved" <?php echo e($val('status')==='approved'?'selected':''); ?>>Approved</option>
                <option value="rejected" <?php echo e($val('status')==='rejected'?'selected':''); ?>>Rejected</option>
              </select>
            </div>
            <div>
              <label class="form-label">Refund Type</label>
              <input type="text" name="refund_type" class="form-control" value="<?php echo e($val('refund_type')); ?>">
            </div>
            <div>
              <label class="form-label">Stage</label>
              <input type="text" name="refund_stage" class="form-control" value="<?php echo e($val('refund_stage')); ?>">
            </div>
          </div>

          <div class="sect">Profile</div>
          <div class="grid">
            <div>
              <label class="form-label">CN Number</label>
              <input type="text" name="cn_number" class="form-control" value="<?php echo e($val('cn_number')); ?>">
            </div>
            <div>
              <label class="form-label">Agreement Reference No.</label>
              <input type="text" name="agreement_reference_no" class="form-control" value="<?php echo e($val('agreement_reference_no')); ?>">
            </div>
            <div>
              <label class="form-label">Candidate Name</label>
              <input type="text" name="candidate_name" class="form-control" value="<?php echo e($val('candidate_name')); ?>" readonly>
            </div>
            <div>
              <label class="form-label">Sponsor Name</label>
              <input type="text" name="client_name" class="form-control" value="<?php echo e($val('client_name')); ?>" readonly>
            </div>
            <div>
              <label class="form-label">Nationality</label>
              <input type="text" name="nationality" class="form-control" value="<?php echo e($val('nationality')); ?>">
            </div>
            <div>
              <label class="form-label">Contract Start</label>
              <input type="date" name="contract_start_date" class="form-control js-start" value="<?php echo e($valDate('contract_start_date')); ?>">
            </div>
            <div>
              <label class="form-label">Return Date</label>
              <input type="date" name="return_date" class="form-control js-return" value="<?php echo e($valDate('return_date')); ?>">
            </div>
            <div>
              <label class="form-label">Number Of Days</label>
              <input type="number" name="number_of_days" class="form-control js-days" value="<?php echo e($valNum('number_of_days') ?: 0); ?>">
            </div>
            <div>
              <label class="form-label">Worked Days With Sponsor</label>
              <input type="number" name="maid_worked_days" class="form-control js-worked-days" value="<?php echo e($valNum('maid_worked_days') ?: 0); ?>">
            </div>
            <div>
              <label class="form-label">Worker Monthly Salary</label>
              <input type="number" step="0.01" name="worker_salary_amount" class="form-control js-salary-amount" value="<?php echo e($valNum('worker_salary_amount') ?: '0.00'); ?>">
            </div>
            <div>
              <label class="form-label">Worker Salary Status</label>
              <select name="worker_salary_type" class="form-select js-salary-type">
                <option value="">Select</option>
                <?php $__currentLoopData = $salaryTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($opt); ?>" <?php echo e($val('worker_salary_type')===$opt?'selected':''); ?>><?php echo e($opt); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div>
              <label class="form-label">Worker Total Salary (Auto)</label>
              <input type="number" step="0.01" class="form-control js-salary-total" value="0.00" readonly>
            </div>
          </div>

          <div class="sect">Ownership & Reasons</div>
          <div class="grid">
            <div>
              <label class="form-label">Original Passport</label>
              <select name="original_passport" class="form-select">
                <option value="">Select</option>
                <?php $__currentLoopData = $passportWhere; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($opt); ?>" <?php echo e($val('original_passport')===$opt?'selected':''); ?>><?php echo e($opt); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div>
              <label class="form-label">Worker Belongings</label>
              <select name="worker_belongings" class="form-select">
                <option value="">Select</option>
                <?php $__currentLoopData = $belongingsWhere; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($opt); ?>" <?php echo e($val('worker_belongings')===$opt?'selected':''); ?>><?php echo e($opt); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <div class="js-refund-only">
              <label class="form-label">Refund Reason</label>
              <select class="form-select js-refund-reason">
                <option value="">Select</option>
                <?php $__currentLoopData = $refundReasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($r); ?>" <?php echo e(strtoupper($val('refund_reason'))===strtoupper($r)?'selected':''); ?>><?php echo e($r); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <option value="Other">Other</option>
              </select>
              <input type="text" class="form-control mt-2 d-none js-refund-reason-other" placeholder="Type other reason">
              <input type="hidden" name="refund_reason" class="js-refund-reason-final" value="<?php echo e($val('refund_reason')); ?>">
            </div>

            <div class="js-replacement-only">
              <label class="form-label">Replacement Reason</label>
              <select class="form-select js-replacement-reason">
                <option value="">Select</option>
                <?php $__currentLoopData = $refundReasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($r); ?>" <?php echo e(strtoupper($val('replacement_reason'))===strtoupper($r)?'selected':''); ?>><?php echo e($r); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <option value="Other">Other</option>
              </select>
              <input type="text" class="form-control mt-2 d-none js-replacement-reason-other" placeholder="Type other reason">
              <input type="hidden" name="replacement_reason" class="js-replacement-reason-final" value="<?php echo e($val('replacement_reason')); ?>">
            </div>

            <div class="js-refund-only">
              <label class="form-label">Refund Due Date</label>
              <input type="date" name="refund_due_date" class="form-control" value="<?php echo e($valDate('refund_due_date')); ?>">
            </div>

            <div class="js-replacement-only">
              <label class="form-label">Replacement Due Date</label>
              <input type="date" name="replacement_due_date" class="form-control" value="<?php echo e($valDate('replacement_due_date')); ?>">
            </div>
          </div>

          <div class="sect">Financials</div>
          <div class="grid">
            <div>
              <label class="form-label">Contracted Amount</label>
              <input type="number" step="0.01" name="contracted_amount" class="form-control" value="<?php echo e($valNum('contracted_amount')); ?>">
            </div>

            <div class="js-refund-only">
              <label class="form-label">Refund Balance</label>
              <input type="number" step="0.01" name="refund_balance" class="form-control" value="<?php echo e($valNum('refund_balance')); ?>">
            </div>

            <div class="js-replacement-only">
              <label class="form-label">Replacement Balance</label>
              <input type="number" step="0.01" name="replacement_balance" class="form-control js-replacement-balance" value="<?php echo e($valNum('replacement_balance')); ?>">
            </div>

            <div class="js-refund-only">
              <label class="form-label">Refund Final Balance</label>
              <input type="number" step="0.01" name="refund_final_balance" class="form-control" value="<?php echo e($valNum('refund_final_balance')); ?>">
            </div>

            <div class="js-replacement-only">
              <label class="form-label">Replacement Final Balance</label>
              <input type="number" step="0.01" name="replacement_final_balance" class="form-control js-final" value="<?php echo e($valNum('replacement_final_balance')); ?>">
            </div>

            <div class="js-replacement-only js-bank-amount-wrap <?php echo e($val('worker_salary_type')==='Customer paid to Office by Bank Transfer'?'':'d-none'); ?>">
              <label class="form-label">Bank Transfer Amount</label>
              <input type="number" step="0.01" name="replacement_bank_amount" class="form-control js-bank-amount" value="<?php echo e($valNum('replacement_bank_amount') ?: '0.00'); ?>">
            </div>

            <div>
              <label class="form-label">Salary Deduction Amount</label>
              <input type="number" step="0.01" name="salary_deduction_amount" class="form-control" value="<?php echo e($valNum('salary_deduction_amount')); ?>">
            </div>
          </div>

          <div class="sect">Payment</div>
          <div class="grid">
            <div>
              <label class="form-label">Payment Method</label>
              <select name="payment_method" class="form-select">
                <option value="">Select</option>
                <option value="Cash" <?php echo e($val('payment_method')==='Cash'?'selected':''); ?>>Cash</option>
                <option value="Bank Transfer" <?php echo e($val('payment_method')==='Bank Transfer'?'selected':''); ?>>Bank Transfer</option>
                <option value="Cheque" <?php echo e($val('payment_method')==='Cheque'?'selected':''); ?>>Cheque</option>
              </select>
            </div>
            <div>
              <label class="form-label">Paid Amount</label>
              <input type="number" step="0.01" name="paid_amount" class="form-control" value="<?php echo e($valNum('paid_amount')); ?>">
            </div>
            <div>
              <label class="form-label">Paid At</label>
              <input type="datetime-local" name="paid_at" class="form-control" value="<?php echo e($valDT('paid_at')); ?>">
            </div>
            <div>
              <label class="form-label">Payment Reference</label>
              <input type="text" name="payment_reference" class="form-control" value="<?php echo e($val('payment_reference')); ?>">
            </div>
          </div>

          <div class="sect">Approval & NOC</div>
          <div class="grid">
            <div>
              <label class="form-label">Approved By</label>
              <input type="text" name="approved_by" class="form-control" value="<?php echo e($val('approved_by')); ?>">
            </div>
            <div>
              <label class="form-label">Approved At</label>
              <input type="datetime-local" name="approved_at" class="form-control" value="<?php echo e($valDT('approved_at')); ?>">
            </div>
            <div class="grid-1" style="padding:0">
              <label class="form-label">Approved Note / Remarks</label>
              <textarea name="approved_note" class="form-control" rows="3"><?php echo e($val('approved_note')); ?></textarea>
            </div>
            <div>
              <label class="form-label">NOC Status</label>
              <input type="text" name="noc_status" class="form-control" value="<?php echo e($val('noc_status')); ?>">
            </div>
            <div>
              <label class="form-label">NOC Expiry Date</label>
              <input type="date" name="noc_expiry_date" class="form-control" value="<?php echo e($valDate('noc_expiry_date')); ?>">
            </div>
          </div>

          <div class="sect">Attachments</div>
          <div class="grid row-soft">
            <div>
              <label class="form-label">Bank Proof</label>
              <input type="file" name="bank_proof_path" class="form-control">
              <?php if($fileUrl($refund->bank_proof_path ?? null)): ?>
                <div class="preview mt-2">
                  <a target="_blank" href="<?php echo e($fileUrl($refund->bank_proof_path)); ?>" class="btn btn-sm btn-outline-primary">Open</a>
                  <?php if($isImage($refund->bank_proof_path)): ?>
                    <img src="<?php echo e($fileUrl($refund->bank_proof_path)); ?>" class="thumb" alt="">
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <div class="hint mt-1">Keeps existing if empty</div>
            </div>

            <div>
              <label class="form-label">General Proof</label>
              <input type="file" name="proof_path" class="form-control">
              <?php if($fileUrl($refund->proof_path ?? null)): ?>
                <div class="preview mt-2">
                  <a target="_blank" href="<?php echo e($fileUrl($refund->proof_path)); ?>" class="btn btn-sm btn-outline-primary">Open</a>
                  <?php if($isImage($refund->proof_path)): ?>
                    <img src="<?php echo e($fileUrl($refund->proof_path)); ?>" class="thumb" alt="">
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <div class="hint mt-1">Keeps existing if empty</div>
            </div>

            <div>
              <label class="form-label">Penalty Payment Proof</label>
              <input type="file" name="penalty_payment_proof_path" class="form-control">
              <?php if($fileUrl($refund->penalty_payment_proof_path ?? null)): ?>
                <div class="preview mt-2">
                  <a target="_blank" href="<?php echo e($fileUrl($refund->penalty_payment_proof_path)); ?>" class="btn btn-sm btn-outline-primary">Open</a>
                  <?php if($isImage($refund->penalty_payment_proof_path)): ?>
                    <img src="<?php echo e($fileUrl($refund->penalty_payment_proof_path)); ?>" class="thumb" alt="">
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <div class="hint mt-1">Keeps existing if empty</div>
            </div>

            <div>
              <label class="form-label">Istiraha Proof</label>
              <input type="file" name="istiraha_proof_path" class="form-control">
              <?php if($fileUrl($refund->istiraha_proof_path ?? null)): ?>
                <div class="preview mt-2">
                  <a target="_blank" href="<?php echo e($fileUrl($refund->istiraha_proof_path)); ?>" class="btn btn-sm btn-outline-primary">Open</a>
                  <?php if($isImage($refund->istiraha_proof_path)): ?>
                    <img src="<?php echo e($fileUrl($refund->istiraha_proof_path)); ?>" class="thumb" alt="">
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <div class="hint mt-1">Keeps existing if empty</div>
            </div>

            <div>
              <label class="form-label">Payment Proof</label>
              <input type="file" name="payment_proof_path" class="form-control">
              <?php if($fileUrl($refund->payment_proof_path ?? null)): ?>
                <div class="preview mt-2">
                  <a target="_blank" href="<?php echo e($fileUrl($refund->payment_proof_path)); ?>" class="btn btn-sm btn-outline-primary">Open</a>
                  <?php if($isImage($refund->payment_proof_path)): ?>
                    <img src="<?php echo e($fileUrl($refund->payment_proof_path)); ?>" class="thumb" alt="">
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <div class="hint mt-1">Keeps existing if empty</div>
            </div>
          </div>

          <div class="btns">
            <button type="submit" class="btn btn-primary">
              <i class="fa-solid fa-save me-1"></i>Update
            </button>
            <a href="<?php echo e(route('refunds.show',['refund'=>$refund->id])); ?>" class="btn btn-outline-secondary">Cancel</a>
          </div>

        </form>
      </div>

    </div>
  </section>
</main>

<script>
(function(){
  function num(v){var x=parseFloat(v);return isNaN(x)?0:x}
  function d(s){if(!s)return null;var x=new Date(s+'T00:00:00');x.setHours(0,0,0,0);return isNaN(x)?null:x}
  function days(a,b){if(!a||!b)return 0;return Math.max(0,Math.floor((b-a)/86400000)+1)}

  function recomputeDays(){
    var s=d(document.querySelector('.js-start')?.value||'');
    var r=d(document.querySelector('.js-return')?.value||'');
    var o=document.querySelector('.js-days');
    if(o && s && r){o.value=days(s,r);}
  }

  function salaryTotal(){
    var m=num(document.querySelector('.js-salary-amount')?.value||0);
    var wd=num(document.querySelector('.js-worked-days')?.value||0);
    var t=(m/30)*wd;
    var fo=document.querySelector('.js-salary-total');
    if(fo)fo.value=t.toFixed(2);
    return t;
  }

  function salaryType(){
    return (document.querySelector('.js-salary-type')?.value||'').trim();
  }

  function toggleBank(){
    var wrap=document.querySelector('.js-bank-amount-wrap');
    var isBank = salaryType()==='Customer paid to Office by Bank Transfer';
    if(wrap) wrap.classList.toggle('d-none',!isBank);
    var el = wrap?wrap.querySelector('.js-bank-amount'):null;
    if(el){
      if(isBank){el.setAttribute('required','required');}
      else{el.removeAttribute('required');if(!el.value)el.value='0.00';}
    }
  }

  function recomputeReplacementFinal(){
    var base=num(document.querySelector('.js-replacement-balance')?.value||0);
    var sal=salaryTotal();
    var st=salaryType();
    var val = (st==='Deduct From Balance' || st==='Customer paid to Office by Bank Transfer') ? Math.max(0, base - sal) : base;
    var fo=document.querySelector('.js-final');
    if(fo)fo.value=val.toFixed(2);
  }

  function syncReason(kind){
    var sel=document.querySelector('.js-'+kind+'-reason');
    var other=document.querySelector('.js-'+kind+'-reason-other');
    var fin=document.querySelector('.js-'+kind+'-reason-final');
    if(!sel||!other||!fin)return;
    var v=sel.value;
    if(v==='Other'){
      other.classList.remove('d-none');
      fin.value=(other.value||'').trim();
    }else{
      other.classList.add('d-none');
      fin.value=v;
    }
  }

  function initReason(kind, preset){
    var sel=document.querySelector('.js-'+kind+'-reason');
    var other=document.querySelector('.js-'+kind+'-reason-other');
    var fin=document.querySelector('.js-'+kind+'-reason-final');
    if(!sel||!other||!fin)return;
    if(preset && !Array.from(sel.options).some(function(o){return o.value.toUpperCase()===preset.toUpperCase();})){
      sel.value='Other';
      other.classList.remove('d-none');
      other.value=preset;
      fin.value=preset;
    }else{
      syncReason(kind);
    }
  }

  function toggleActionSections(){
    var type=(document.querySelector('.js-action-type')?.value||'').toLowerCase();
    var isRefund=type==='refund';
    document.querySelectorAll('.js-refund-only').forEach(function(el){el.classList.toggle('d-none',!isRefund);});
    document.querySelectorAll('.js-replacement-only').forEach(function(el){el.classList.toggle('d-none',isRefund);});
  }

  function init(){
    recomputeDays();
    toggleBank();
    salaryTotal();
    recomputeReplacementFinal();
    initReason('refund',(document.querySelector('.js-refund-reason-final')||{}).value||'');
    initReason('replacement',(document.querySelector('.js-replacement-reason-final')||{}).value||'');
    toggleActionSections();

    if(typeof flatpickr!=='undefined'){
      document.querySelectorAll('input[type="date"]').forEach(function(input){
        flatpickr(input,{
          dateFormat:"Y-m-d",
          altInput:true,
          altFormat:"d M Y",
          allowInput:true,
          defaultDate:input.value||null
        });
      });
    }
  }

  init();

  document.addEventListener('change',function(e){
    if(e.target.matches('.js-start,.js-return'))recomputeDays();
    if(e.target.matches('.js-salary-type')){toggleBank();recomputeReplacementFinal();}
    if(e.target.matches('.js-refund-reason'))syncReason('refund');
    if(e.target.matches('.js-replacement-reason'))syncReason('replacement');
    if(e.target.matches('.js-action-type'))toggleActionSections();
  });

  document.addEventListener('input',function(e){
    if(e.target.matches('.js-worked-days,.js-salary-amount')){salaryTotal();recomputeReplacementFinal();}
    if(e.target.matches('.js-refund-reason-other'))syncReason('refund');
    if(e.target.matches('.js-replacement-reason-other'))syncReason('replacement');
    if(e.target.matches('.js-replacement-balance'))recomputeReplacementFinal();
  });
})();
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/package/refunds/edit.blade.php ENDPATH**/ ?>