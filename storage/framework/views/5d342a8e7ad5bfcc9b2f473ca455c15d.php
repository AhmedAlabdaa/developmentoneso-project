<?php echo $__env->make('../layout.Finance_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="row g-3">
          <div class="col-xxl-4 col-md-6">
              <div class="card info-card">
                  <div class="card-body">
                      <h5 class="card-title" style="font-weight: bold; color: black;">Total Receipt Voucher Inside (RVI)</h5>
                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #28a745; width: 80px; height: 80px;">
                              <i class="bi bi-file-earmark-text" style="color: white; font-size: 36px;"></i>
                          </div>
                          <div class="ps-3">
                              <h6><?php echo e($totalRVIAmount); ?></h6>
                              <span class="text-muted small" style="font-weight: bold; color: black;">Total RVI Amount: AED <?php echo e(number_format($totalRVIAmount, 2)); ?></span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-xxl-4 col-md-6">
              <div class="card info-card">
                  <div class="card-body">
                      <h5 class="card-title" style="font-weight: bold; color: black;">Total Receipt Voucher Outside (RVO)</h5>
                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #007bff; width: 80px; height: 80px;">
                              <i class="bi bi-file-earmark" style="color: white; font-size: 36px;"></i>
                          </div>
                          <div class="ps-3">
                              <h6><?php echo e($totalRVOAmount); ?></h6>
                              <span class="text-muted small" style="font-weight: bold; color: black;">Total RVO Amount: AED <?php echo e(number_format($totalRVOAmount, 2)); ?></span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-xxl-4 col-md-6">
              <div class="card info-card">
                  <div class="card-body">
                      <h5 class="card-title" style="font-weight: bold; color: black;">Total Invoices (INV)</h5>
                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #ffc107; width: 80px; height: 80px;">
                              <i class="bi bi-receipt" style="color: white; font-size: 36px;"></i>
                          </div>
                          <div class="ps-3">
                              <h6><?php echo e($totalINVAmount); ?></h6>
                              <span class="text-muted small" style="font-weight: bold; color: black;">Total INV Amount: AED <?php echo e(number_format($totalINVAmount, 2)); ?></span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-xxl-4 col-md-6">
              <div class="card info-card">
                  <div class="card-body">
                      <h5 class="card-title" style="font-weight: bold; color: black;">Pending Receipt Voucher Inside (RVI)</h5>
                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #17a2b8; width: 80px; height: 80px;">
                              <i class="bi bi-clock-history" style="color: white; font-size: 36px;"></i>
                          </div>
                          <div class="ps-3">
                              <h6><?php echo e($pendingRVI); ?></h6>
                              <span class="text-muted small" style="font-weight: bold; color: black;">Pending this month</span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-xxl-4 col-md-6">
              <div class="card info-card">
                  <div class="card-body">
                      <h5 class="card-title" style="font-weight: bold; color: black;">Pending Receipt Voucher Outside (RVO)</h5>
                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #dc3545; width: 80px; height: 80px;">
                              <i class="bi bi-clock" style="color: white; font-size: 36px;"></i>
                          </div>
                          <div class="ps-3">
                              <h6><?php echo e($pendingRVO); ?></h6>
                              <span class="text-muted small" style="font-weight: bold; color: black;">Pending this month</span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-xxl-4 col-md-6">
              <div class="card info-card">
                  <div class="card-body">
                      <h5 class="card-title" style="font-weight: bold; color: black;">Pending Invoices (INV)</h5>
                      <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: #6c757d; width: 80px; height: 80px;">
                              <i class="bi bi-exclamation-circle" style="color: white; font-size: 36px;"></i>
                          </div>
                          <div class="ps-3">
                              <h6><?php echo e($pendingINV); ?></h6>
                              <span class="text-muted small" style="font-weight: bold; color: black;">Pending this month</span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/developmentoneso-project/resources/views/Cashier-Dashboard.blade.php ENDPATH**/ ?>