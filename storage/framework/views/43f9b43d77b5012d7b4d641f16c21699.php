<ul class="nav nav-tabs" id="statusTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button type="button" class="nav-link <?php echo e(request('status', 'all') == 'all' ? 'active' : ''); ?>" onclick="changeStatusAndLoad('all', this)">
      <i class="bi bi-people-fill text-success me-1"></i>
      ALL <span class="badge bg-info ms-1"><?php echo e($counts['all'] ?? 0); ?></span>
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button type="button" class="nav-link <?php echo e(request('status') == 'outside' ? 'active' : ''); ?>" onclick="changeStatusAndLoad('outside', this)">
      <i class="bi bi-door-open-fill text-info me-1"></i>
      OUTSIDE <span class="badge bg-info ms-1"><?php echo e($counts['outside'] ?? 0); ?></span>
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button  type="button"  class="nav-link <?php echo e(request('status') == 'office' ? 'active' : ''); ?>"  onclick="changeStatusAndLoad('office', this)">
      <i class="bi bi-building text-primary me-1"></i>
      OFFICE <span class="badge bg-info ms-1"><?php echo e($counts['office'] ?? 0); ?></span>
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button type="button" class="nav-link <?php echo e(request('status') == 'trial' ? 'active' : ''); ?>" onclick="changeStatusAndLoad('trial', this)">
      <i class="bi bi-person-check-fill text-warning me-1"></i>
      TRIALS <span class="badge bg-info ms-1"><?php echo e($counts['trial'] ?? 0); ?></span>
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button type="button" class="nav-link <?php echo e(request('status') == 'incident' ? 'active' : ''); ?>" onclick="changeStatusAndLoad('incident', this)">
      <i class="bi bi-exclamation-triangle-fill text-danger me-1"></i>
      INCIDENT <span class="badge bg-info ms-1"><?php echo e($counts['incident'] ?? 0); ?></span>
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button type="button" class="nav-link <?php echo e(request('status') == 'contracts' ? 'active' : ''); ?>" onclick="changeStatusAndLoad('contracts', this)">
      <i class="bi bi-file-earmark-text-fill text-primary me-1"></i>
      CONTRACTED <span class="badge bg-info ms-1"><?php echo e($counts['contracts'] ?? 0); ?></span>
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button type="button" class="nav-link <?php echo e(request('status') == 'refund' ? 'active' : ''); ?>" onclick="changeStatusAndLoad('refund', this)">
      <i class="bi bi-arrow-counterclockwise text-warning me-1"></i>
      REFUND <span class="badge bg-info ms-1"><?php echo e($counts['refund'] ?? 0); ?></span>
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button type="button" class="nav-link <?php echo e(request('status') == 'replacement' ? 'active' : ''); ?>" onclick="changeStatusAndLoad('replacement', this)">
      <i class="bi bi-arrow-left-right text-secondary me-1"></i>
      REPLACEMENT <span class="badge bg-info ms-1"><?php echo e($counts['replacement'] ?? 0); ?></span>
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button
      type="button"
      class="nav-link <?php echo e(request('status') == 'salaries' ? 'active' : ''); ?>"
      onclick="changeStatusAndLoad('salaries', this)"
    >
      <i class="bi bi-cash-stack text-success me-1"></i>
      SALARIES <span class="badge bg-info ms-1"><?php echo e($counts['salaries'] ?? 0); ?></span>
    </button>
  </li>

  <li class="nav-item" role="presentation">
    <button
      type="button"
      class="nav-link <?php echo e(request('status') == 'remittance' ? 'active' : ''); ?>"
      onclick="changeStatusAndLoad('remittance', this)"
    >
      <i class="bi bi-send-fill text-primary me-1"></i>
      REMITTANCE <span class="badge bg-info ms-1"><?php echo e($counts['remittance'] ?? 0); ?></span>
    </button>
  </li>
</ul>
<?php /**PATH /home/developmentoneso/public_html/resources/views/candidates/partials/inside_counts.blade.php ENDPATH**/ ?>