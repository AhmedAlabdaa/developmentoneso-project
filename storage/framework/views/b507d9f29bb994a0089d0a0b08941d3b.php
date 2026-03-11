<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
  .emp-wrap{max-width:1100px;margin:0 auto}
  .emp-card{background:#fff;border:1px solid #e9ecef;border-radius:14px;box-shadow:0 2px 10px rgba(0,0,0,.05);overflow:hidden}
  .emp-head{padding:18px 22px;background:linear-gradient(180deg,#f8f9fa,#ffffff)}
  .emp-title{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
  .emp-title h4{margin:0;font-size:16px;font-weight:700}
  .emp-badges{display:flex;gap:8px;flex-wrap:wrap}
  .badge-pill{font-size:11px;padding:6px 10px;border-radius:999px;background:#f1f3f5;border:1px solid #e9ecef}
  .badge-ok{background:#e7f5ff;border-color:#d0ebff}
  .badge-warn{background:#fff3bf;border-color:#ffe066}
  .badge-danger{background:#ffe3e3;border-color:#ffc9c9}
  .emp-sub{margin-top:6px;font-size:12px;color:#6c757d}
  .emp-body{padding:18px 22px}
  .grid{display:grid;grid-template-columns:repeat(12,1fr);gap:14px}
  .box{border:1px solid #e9ecef;border-radius:12px;padding:14px 14px;background:#fff}
  .box h6{margin:0 0 10px 0;font-size:12px;letter-spacing:.4px;text-transform:uppercase;color:#495057}
  .kv{display:grid;grid-template-columns:1fr 1fr;gap:10px}
  .kv .row{display:flex;gap:10px;font-size:12px;line-height:1.4}
  .k{min-width:140px;color:#6c757d}
  .v{color:#212529;word-break:break-word}
  .kv.one{grid-template-columns:1fr}
  .pill-actions{display:flex;gap:8px;flex-wrap:wrap;margin-top:10px}
  .btn-mini{font-size:12px;padding:6px 10px}
  .timeline{display:flex;flex-direction:column;gap:10px}
  .t-item{border:1px solid #e9ecef;border-radius:12px;padding:12px 14px;background:#fbfcfd}
  .t-top{display:flex;justify-content:space-between;gap:10px;align-items:flex-start;flex-wrap:wrap}
  .t-title{font-weight:700;font-size:13px;margin:0}
  .t-meta{font-size:11px;color:#6c757d}
  .t-grid{margin-top:8px;display:grid;grid-template-columns:repeat(12,1fr);gap:10px}
  .t-col{grid-column:span 6}
  .t-col .row{display:flex;gap:10px;font-size:12px}
  .divider{height:1px;background:#e9ecef;margin:14px 0}
  .no-data{color:#dc3545;font-size:12px;margin:0;text-align:center;padding:10px}
  #proofContent embed,#proofContent video{max-height:75vh}
  @media (max-width: 992px){ .kv{grid-template-columns:1fr} .t-col{grid-column:span 12} }
</style>

<?php
  $fmt = function ($v) {
    if (!$v) return 'N/A';
    try { return \Carbon\Carbon::parse($v)->setTimezone('Asia/Dubai')->format('d M Y'); } catch (\Throwable $e) { return (string) $v; }
  };

  $val = function ($v) { return ($v === null || $v === '') ? 'N/A' : $v; };

  $insideStatusLabel = function ($v) {
    $map = [
      0 => 'Outside',
      1 => 'Inside',
      2 => 'Hold',
      3 => 'Incident',
      4 => 'Completed',
      5 => 'Incident',
      6 => 'Other',
    ];
    return $map[(int)$v] ?? (string)$v;
  };

  $countryLabel = function ($v) {
    $map = [1 => 'Outside', 2 => 'Inside'];
    return $map[(int)$v] ?? (string)$v;
  };

  $badgeClass = function ($v) {
    $v = (int) $v;
    if ($v === 1) return 'badge-ok';
    if ($v === 3 || $v === 5) return 'badge-danger';
    if ($v === 2) return 'badge-warn';
    return '';
  };

  $makeUrl = function ($path) {
    if (!$path) return null;
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
    return asset('storage/' . ltrim($path, '/'));
  };
?>

<main id="main" class="main">
  <section class="section">
    <div class="container emp-wrap">
      <div class="emp-card">
        <div class="emp-head">
          <div class="emp-title">
            <h4>
              <i class="fa-solid fa-id-card-clip"></i>
              <?php echo e($employee->name ?? 'Employee'); ?>

            </h4>
            <div class="emp-badges">
              <span class="badge-pill <?php echo e($badgeClass($employee->inside_status ?? null)); ?>">
                Inside Status: <?php echo e($insideStatusLabel($employee->inside_status ?? null)); ?>

              </span>
              <span class="badge-pill">
                Outside Status: <?php echo e($countryLabel($employee->inside_country_or_outside ?? null)); ?>

              </span>
              <span class="badge-pill">
                Reference: <?php echo e($val($employee->reference_no ?? null)); ?>

              </span>
              <span class="badge-pill">
                Passport: <?php echo e($val($employee->passport_no ?? null)); ?>

              </span>
            </div>
          </div>
          <div class="emp-sub">
            <i class="fa-regular fa-clock"></i> <?php echo e($now); ?>

          </div>
        </div>

        <div class="emp-body">
          <div class="grid">
            <div class="box" style="grid-column: span 12;">
              <h6>Primary Information</h6>
              <div class="kv">
                <div class="row"><div class="k">Name</div><div class="v"><?php echo e($val($employee->name ?? null)); ?></div></div>
                <div class="row"><div class="k">Nationality</div><div class="v"><?php echo e($val($employee->nationality ?? null)); ?></div></div>
                <div class="row"><div class="k">Gender</div><div class="v"><?php echo e($val($employee->gender ?? null)); ?></div></div>
                <div class="row"><div class="k">Date of Birth</div><div class="v"><?php echo e($fmt($employee->date_of_birth ?? null)); ?></div></div>
                <div class="row"><div class="k">Package</div><div class="v"><?php echo e($val($employee->package ?? null)); ?></div></div>
                <div class="row"><div class="k">Foreign Partner</div><div class="v"><?php echo e($val($employee->foreign_partner ?? null)); ?></div></div>
                <div class="row"><div class="k">Passport Expiry</div><div class="v"><?php echo e($fmt($employee->passport_expiry_date ?? null)); ?></div></div>
                <div class="row"><div class="k">Date of Joining</div><div class="v"><?php echo e($fmt($employee->date_of_joining ?? null)); ?></div></div>
              </div>
            </div>

            <div class="box" style="grid-column: span 6;">
              <h6>Visa / IDs</h6>
              <div class="kv one">
                <div class="row"><div class="k">UID No</div><div class="v"><?php echo e($val($employee->uid_no ?? $employee->uid_number ?? null)); ?></div></div>
                <div class="row"><div class="k">Personal No</div><div class="v"><?php echo e($val($employee->personal_no ?? null)); ?></div></div>
                <div class="row"><div class="k">Entry Permit No</div><div class="v"><?php echo e($val($employee->file_entry_permit_no ?? null)); ?></div></div>
                <div class="row"><div class="k">Entry Permit Issued</div><div class="v"><?php echo e($fmt($employee->file_entry_permit_issued_date ?? null)); ?></div></div>
                <div class="row"><div class="k">Entry Permit Expiry</div><div class="v"><?php echo e($fmt($employee->file_entry_permit_expired_date ?? null)); ?></div></div>
                <div class="row"><div class="k">Emirates ID</div><div class="v"><?php echo e($val($employee->emirates_id_number ?? null)); ?></div></div>
                <div class="row"><div class="k">EID Issued</div><div class="v"><?php echo e($fmt($employee->eid_issued_date ?? null)); ?></div></div>
                <div class="row"><div class="k">EID Expiry</div><div class="v"><?php echo e($fmt($employee->eid_expiry_date ?? null)); ?></div></div>
              </div>
            </div>

            <div class="box" style="grid-column: span 6;">
              <h6>Arrival</h6>
              <div class="kv one">
                <div class="row"><div class="k">Arrival Date</div><div class="v"><?php echo e($fmt($employee->arrival_date ?? null)); ?></div></div>
                <div class="row"><div class="k">Arrival Expiry</div><div class="v"><?php echo e($fmt($employee->arrival_expiry_date ?? null)); ?></div></div>

                <?php
                  $t1 = $makeUrl($employee->arrival_ticket_attachment ?? null);
                  $t2 = $makeUrl($employee->arrival_entry_stamp_attachment ?? null);
                  $t3 = $makeUrl($employee->arrival_icp_proof_attachment ?? null);
                ?>

                <div class="pill-actions">
                  <?php if($t1): ?>
                    <button type="button" class="btn btn-primary btn-mini view-proof" data-proof-url="<?php echo e($t1); ?>">
                      <i class="fa-solid fa-ticket"></i> Ticket
                    </button>
                  <?php endif; ?>
                  <?php if($t2): ?>
                    <button type="button" class="btn btn-primary btn-mini view-proof" data-proof-url="<?php echo e($t2); ?>">
                      <i class="fa-solid fa-stamp"></i> Entry Stamp
                    </button>
                  <?php endif; ?>
                  <?php if($t3): ?>
                    <button type="button" class="btn btn-primary btn-mini view-proof" data-proof-url="<?php echo e($t3); ?>">
                      <i class="fa-solid fa-file-circle-check"></i> ICP Proof
                    </button>
                  <?php endif; ?>
                  <?php if(!$t1 && !$t2 && !$t3): ?>
                    <p class="no-data">NO Attachments Available</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="box" style="grid-column: span 12;">
              <h6>Visa Stages</h6>

              <?php if(isset($visaStages) && $visaStages->count()): ?>
                <div class="timeline">
                  <?php $__currentLoopData = $visaStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                      $hrFile = $makeUrl($s->hr_attach_file ?? null);
                      $ica = $makeUrl($s->ica_proof ?? null);
                      $zoho = $makeUrl($s->fin_zoho_proof ?? null);
                      $gov = $makeUrl($s->fin_gov_invoice_proof ?? null);
                      $step = $s->step_id ?? $s->stage_id ?? null;
                    ?>
                    <div class="t-item">
                      <div class="t-top">
                        <div>
                          <p class="t-title">
                            <i class="fa-solid fa-layer-group"></i>
                            Stage <?php echo e($val($step)); ?>

                          </p>
                          <div class="t-meta">
                            HR File: <?php echo e($val($s->hr_file_number ?? null)); ?> · Paid: <?php echo e($val($s->fin_paid_amount ?? null)); ?>

                          </div>
                        </div>
                        <div class="emp-badges">
                          <span class="badge-pill">Issue: <?php echo e($fmt($s->hr_issue_date ?? null)); ?></span>
                          <span class="badge-pill">Expiry: <?php echo e($fmt($s->hr_expiry_date ?? null)); ?></span>
                        </div>
                      </div>

                      <div class="t-grid">
                        <div class="t-col">
                          <div class="row"><div class="k">HR Attach</div>
                            <div class="v">
                              <?php if($hrFile): ?>
                                <button type="button" class="btn btn-primary btn-mini view-proof" data-proof-url="<?php echo e($hrFile); ?>">View</button>
                              <?php else: ?>
                                N/A
                              <?php endif; ?>
                            </div>
                          </div>
                          <div class="row"><div class="k">ICA Proof</div>
                            <div class="v">
                              <?php if($ica): ?>
                                <button type="button" class="btn btn-primary btn-mini view-proof" data-proof-url="<?php echo e($ica); ?>">View</button>
                              <?php else: ?>
                                N/A
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>
                        <div class="t-col">
                          <div class="row"><div class="k">Zoho Proof</div>
                            <div class="v">
                              <?php if($zoho): ?>
                                <button type="button" class="btn btn-primary btn-mini view-proof" data-proof-url="<?php echo e($zoho); ?>">View</button>
                              <?php else: ?>
                                N/A
                              <?php endif; ?>
                            </div>
                          </div>
                          <div class="row"><div class="k">Gov Invoice</div>
                            <div class="v">
                              <?php if($gov): ?>
                                <button type="button" class="btn btn-primary btn-mini view-proof" data-proof-url="<?php echo e($gov); ?>">View</button>
                              <?php else: ?>
                                N/A
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              <?php else: ?>
                <p class="no-data">NO Data Available</p>
              <?php endif; ?>
            </div>

            <div class="box" style="grid-column: span 12;">
              <h6>Notes</h6>
              <div class="kv one">
                <div class="row"><div class="k">Incident Type</div><div class="v"><?php echo e($val($employee->incident_type ?? null)); ?></div></div>
                <div class="row"><div class="k">Incident Date</div><div class="v"><?php echo e($fmt($employee->incident_date ?? null)); ?></div></div>
                <div class="row"><div class="k">Remarks</div><div class="v"><?php echo e($val($employee->remarks ?? null)); ?></div></div>
                <div class="row"><div class="k">Comments</div><div class="v"><?php echo e($val($employee->comments ?? null)); ?></div></div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="proofModal" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="proofModalLabel">Attachment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div id="proofContent"></div>
      </div>
    </div>
  </div>
</div>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
  var proofModal=new bootstrap.Modal(document.getElementById('proofModal'))
  document.querySelectorAll('.view-proof').forEach(function(button){
    button.addEventListener('click',function(){
      var proofUrl=this.getAttribute('data-proof-url')
      var ext=proofUrl.split('?')[0].split('#')[0].split('.').pop().toLowerCase()
      var container=document.getElementById('proofContent')
      container.innerHTML=''
      if(['jpg','jpeg','png','gif','bmp','webp'].includes(ext)){
        container.innerHTML='<img src="'+proofUrl+'" class="img-fluid">'
      } else if(ext==='pdf'){
        container.innerHTML='<embed src="'+proofUrl+'" type="application/pdf" width="100%" height="700px">'
      } else if(['mp4','webm','ogg'].includes(ext)){
        container.innerHTML='<video controls width="100%"><source src="'+proofUrl+'" type="video/'+ext+'">Your browser does not support the video tag.</video>'
      } else {
        container.innerHTML='<p>Cannot preview this file type. <a href="'+proofUrl+'" target="_blank">Download it here</a>.</p>'
      }
      proofModal.show()
    })
  })
})
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/show.blade.php ENDPATH**/ ?>