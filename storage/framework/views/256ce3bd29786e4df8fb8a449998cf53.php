<?php echo $__env->make('../layout.PRO_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<main id="main" class="main">
  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="row">
          <?php
            $statuses = [
              ['title' => 'Available', 'icon' => 'bi bi-person-check', 'color' => '#17a2b8'],
              ['title' => 'Hold', 'icon' => 'bi bi-pause-circle', 'color' => '#ffc107'],
              ['title' => 'Selected', 'icon' => 'bi bi-person-plus', 'color' => '#007bff'],
              ['title' => 'WC-Date', 'icon' => 'bi bi-calendar-check', 'color' => '#17a2b8'],
              ['title' => 'Incident Before Visa (IBV)', 'icon' => 'bi bi-exclamation-triangle', 'color' => '#dc3545'],
              ['title' => 'Visa Date', 'icon' => 'bi bi-passport', 'color' => '#28a745'],
              ['title' => 'Incident After Visa (IAV)', 'icon' => 'bi bi-exclamation-octagon', 'color' => '#ffc107'],
              ['title' => 'Medical Status', 'icon' => 'bi bi-activity', 'color' => '#007bff'],
              ['title' => 'COC-Status', 'icon' => 'bi bi-award', 'color' => '#17a2b8'],
              ['title' => 'L-Submitted Date', 'icon' => 'bi bi-envelope-check', 'color' => '#28a745'],
              ['title' => 'L-Issued Date', 'icon' => 'bi bi-envelope-open', 'color' => '#007bff'],
              ['title' => 'Departure Date', 'icon' => 'bi bi-airplane', 'color' => '#17a2b8'],
              ['title' => 'Incident After Departure (IAD)', 'icon' => 'bi bi-exclamation-circle', 'color' => '#dc3545'],
              ['title' => 'Arrived Date', 'icon' => 'bi bi-calendar-event', 'color' => '#28a745'],
              ['title' => 'Incident After Arrival (IAA)', 'icon' => 'bi bi-flag', 'color' => '#ffc107'],
              ['title' => 'Transfer Date', 'icon' => 'bi bi-arrow-left-right', 'color' => '#17a2b8'],
            ];
          ?>
          <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xxl-4 col-md-6 mb-3">
              <div class="card info-card">
                <div class="card-body">
                  <h5 class="card-title" style="font-weight: bold; color: black;"><?php echo e($status['title']); ?></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: <?php echo e($status['color']); ?>; width: 80px; height: 80px;">
                      <i class="<?php echo e($status['icon']); ?>" style="color: white; font-size: 36px;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>0</h6>
                      <span class="text-muted small" style="font-weight: bold; color: black;"><?php echo e($status['title']); ?> Candidates</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>
  </section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/Pro-Dashboard.blade.php ENDPATH**/ ?>