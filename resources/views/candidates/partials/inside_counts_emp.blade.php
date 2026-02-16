<ul class="nav nav-tabs" id="statusTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button
      type="button"
      class="nav-link {{ request('status', 'all') == 'all' ? 'active' : '' }}"
      onclick="changeStatusAndLoad('all', this)"
    >
      <i class="bi bi-people-fill text-success"></i>
      ALL EMPLOYEES <span class="badge bg-info">{{ $counts['all'] }}</span>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button
      type="button"
      class="nav-link {{ request('status') == 'office' ? 'active' : '' }}"
      onclick="changeStatusAndLoad('office', this)"
    >
      <i class="bi bi-building text-primary"></i>
      OFFICE <span class="badge bg-info">{{ $counts['office'] }}</span>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button
      type="button"
      class="nav-link {{ request('status') == 'trial' ? 'active' : '' }}"
      onclick="changeStatusAndLoad('trial', this)"
    >
      <i class="bi bi-file-earmark-text-fill text-warning"></i>
      CONTRACTED <span class="badge bg-info">{{ $counts['trial'] }}</span>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button
      type="button"
      class="nav-link {{ request('status') == 'incident' ? 'active' : '' }}"
      onclick="changeStatusAndLoad('incident', this)"
    >
      <i class="bi bi-exclamation-triangle-fill text-danger"></i>
      INCIDENT <span class="badge bg-info">{{ $counts['incident'] }}</span>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button type="button"
            class="nav-link {{ request('status') == 'outside' ? 'active' : '' }}"
            onclick="changeStatusAndLoad('outside', this)">
      <i class="bi bi-globe text-success"></i>
      OUTSIDE <span class="badge bg-info">{{ $counts['outside'] }}</span>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button
      type="button"
      class="nav-link {{ request('status') == 'invoices' ? 'active' : '' }}"
      onclick="loadInvoices('invoices', this)"
    >
      <i class="bi bi-receipt text-dark"></i>
      INVOICES <span class="badge bg-info">0</span>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button
      type="button"
      class="nav-link {{ request('status') == 'payroll' ? 'active' : '' }}"
      onclick="loadPayroll('payroll', this)"
    >
      <i class="bi bi-cash-stack text-secondary"></i>
      PAYROLL <span class="badge bg-info">0</span>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button
      type="button"
      class="nav-link {{ request('status') == 'payment_tracking' ? 'active' : '' }}"
      onclick="loadPaymentTracking('payment_tracking', this)"
    >
      <i class="bi bi-card-checklist text-info"></i>
      PAYMENT TRACKER <span class="badge bg-info">0</span>
    </button>
  </li>
</ul>
