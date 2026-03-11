<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
  .trial-balance-card {
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  }
  .trial-balance-header {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
    padding: 20px 25px;
    border-radius: 12px 12px 0 0;
  }
  .filter-section {
    background: #f8f9fc;
    padding: 20px;
    border-bottom: 1px solid #e3e6f0;
  }
  .table-container {
    padding: 0;
  }
  .tb-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }
  .tb-table thead th {
    background: #4e73df;
    color: white;
    padding: 12px 15px;
    font-weight: 600;
    text-align: left;
    border: none;
  }
  .tb-table thead th:last-child,
  .tb-table thead th:nth-last-child(2),
  .tb-table thead th:nth-last-child(3) {
    text-align: right;
  }
  .tb-table tbody tr {
    border-bottom: 1px solid #e3e6f0;
  }
  .tb-table tbody tr:hover {
    background: #f8f9fc;
  }
  .tb-table tbody td {
    padding: 12px 15px;
    vertical-align: middle;
  }
  .tb-table tbody td.amount-col {
    text-align: right;
    font-family: 'Consolas', 'Monaco', monospace;
  }
  .tb-table tfoot td {
    background: #1cc88a;
    color: white;
    font-weight: bold;
    padding: 14px 15px;
  }
  .tb-table tfoot td.amount-col {
    text-align: right;
    font-family: 'Consolas', 'Monaco', monospace;
    font-size: 16px;
  }
  .tb-table tfoot.unbalanced td {
    background: #e74a3b;
  }
  .balance-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
  }
  .badge-dr {
    background: #e3f2fd;
    color: #1565c0;
  }
  .badge-cr {
    background: #fce4ec;
    color: #c62828;
  }
  .summary-card {
    border-radius: 10px;
    text-align: center;
    padding: 20px;
    margin-bottom: 20px;
  }
  .summary-card.balanced {
    background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
    color: white;
  }
  .summary-card.unbalanced {
    background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
    color: white;
  }
  .summary-card h3 {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
  }
  .summary-card p {
    margin: 5px 0 0;
    opacity: 0.9;
  }
  .class-header {
    background: #eaecf4 !important;
    font-weight: 600;
    color: #5a5c69;
  }
  .loading-overlay {
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.8);
    z-index: 10;
    justify-content: center;
    align-items: center;
  }
  .table-wrapper {
    position: relative;
    min-height: 200px;
  }
  /* Enhanced Summary Cards */
  .stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
  }
  .stat-card .stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 16px;
  }
  .stat-card .stat-value {
    font-size: 32px;
    font-weight: 700;
    margin: 0;
    letter-spacing: -0.5px;
  }
  .stat-card .stat-label {
    color: #6c757d;
    font-size: 14px;
    font-weight: 500;
    margin: 4px 0 0;
  }
  .stat-card.debit .stat-icon {
    background: rgba(16, 185, 129, 0.12);
    color: #10b981;
  }
  .stat-card.debit .stat-value {
    color: #10b981;
  }
  .stat-card.credit .stat-icon {
    background: rgba(239, 68, 68, 0.12);
    color: #ef4444;
  }
  .stat-card.credit .stat-value {
    color: #ef4444;
  }
  .stat-card.balance .stat-icon {
    background: rgba(59, 130, 246, 0.12);
    color: #3b82f6;
  }
  .stat-card.balance.balanced .stat-icon {
    background: rgba(16, 185, 129, 0.12);
    color: #10b981;
  }
  .stat-card.balance.balanced .stat-value {
    color: #10b981;
  }
  .stat-card.balance.unbalanced .stat-icon {
    background: rgba(239, 68, 68, 0.12);
    color: #ef4444;
  }
  .stat-card.balance.unbalanced .stat-value {
    color: #ef4444;
  }
  /* Enhanced Header */
  .report-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
    color: white;
    padding: 28px 30px;
    border-radius: 16px 16px 0 0;
    position: relative;
    overflow: hidden;
  }
  .report-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 300px;
    height: 100%;
    background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.05) 100%);
    border-radius: 0 0 0 100%;
  }
  .report-header h5 {
    font-size: 20px;
    font-weight: 600;
    margin: 0 0 4px;
    position: relative;
    z-index: 1;
  }
  .report-header small {
    opacity: 0.7;
    font-size: 13px;
    position: relative;
    z-index: 1;
  }
  .report-header .header-icon {
    background: rgba(255,255,255,0.15);
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 16px;
    font-size: 22px;
  }
  @media print {
    .filter-section, .no-print { display: none !important; }
    .report-header { background: #333 !important; -webkit-print-color-adjust: exact; }
  }
</style>

<main id="main" class="main">
  <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
    <h1><i class="fas fa-balance-scale me-2"></i>Trial Balance</h1>
  </div>

  <section class="section">
    <!-- Summary Cards -->
    <div class="row mb-4 g-4" id="summarySection">
      <div class="col-md-4">
        <div class="stat-card debit">
          <div class="stat-icon">
            <i class="fas fa-arrow-trend-up"></i>
          </div>
          <h3 class="stat-value" id="totalDebit">0.00</h3>
          <p class="stat-label">Total Debit</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card credit">
          <div class="stat-icon">
            <i class="fas fa-arrow-trend-down"></i>
          </div>
          <h3 class="stat-value" id="totalCredit">0.00</h3>
          <p class="stat-label">Total Credit</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card balance balanced" id="balanceCard">
          <div class="stat-icon">
            <i class="fas fa-scale-balanced" id="balanceIcon"></i>
          </div>
          <h3 class="stat-value" id="balanceStatus">Balanced</h3>
          <p class="stat-label" id="balanceDetail">Debit equals Credit</p>
        </div>
      </div>
    </div>

    <!-- Main Card -->
    <div class="card trial-balance-card">
      <div class="report-header">
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <div class="header-icon">
              <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div>
              <h5>Trial Balance Report</h5>
              <small>Summary of all ledger accounts by class</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Filters -->
      <div class="filter-section no-print">
        <form id="filterForm" class="row g-3 align-items-end">
          <div class="col-md-3">
            <label class="form-label">From Date</label>
            <input type="date" class="form-control" id="posting_date_from" name="posting_date_from">
          </div>
          <div class="col-md-3">
            <label class="form-label">To Date</label>
            <input type="date" class="form-control" id="posting_date_to" name="posting_date_to">
          </div>
          <div class="col-md-3">
            <label class="form-label">Ledger Type</label>
            <select class="form-select" id="spacial" name="spacial">
              <option value="">All Ledgers</option>
              <option value="2">Bank</option>
              <option value="3">Customer</option>
            </select>
          </div>
          <div class="col-md-3">
            <div class="d-flex gap-2">
              <button type="button" class="btn btn-secondary w-50" id="btnClear">
                <i class="fas fa-undo me-1"></i> Clear
              </button>
              <button type="submit" class="btn btn-primary w-50">
                <i class="fas fa-filter me-1"></i> Apply
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- Table -->
      <div class="table-container">
        <div class="table-wrapper">
          <div class="loading-overlay" id="loadingOverlay">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
          <table class="tb-table" id="trialBalanceTable">
            <thead>
              <tr>
                <th style="width:30%">Ledger Name</th>
                <th style="width:15%">Sub Class</th>
                <th style="width:15%">Group</th>
                <th style="width:13%">Debit (DR)</th>
                <th style="width:13%">Credit (CR)</th>
                <th style="width:14%">Closing Balance</th>
              </tr>
            </thead>
            <tbody id="tbBody">
              <tr><td colspan="6" class="text-center py-4 text-muted">Loading...</td></tr>
            </tbody>
            <tfoot id="tbFoot">
              <tr>
                <td colspan="3"><strong>TOTAL</strong></td>
                <td class="amount-col" id="footDebit">0.00</td>
                <td class="amount-col" id="footCredit">0.00</td>
                <td class="amount-col">-</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>

<?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const apiUrl = '/api/trial-balance';

function formatNumber(num) {
  return parseFloat(num || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function loadTrialBalance(params = {}) {
  $('#loadingOverlay').css('display', 'flex');
  
  const queryString = $.param(params);
  const url = queryString ? `${apiUrl}?${queryString}` : apiUrl;
  
  $.get(url)
    .done(function(res) {
      const data = res.data || [];
      const summary = res.summary || {};
      
      // Update summary cards
      $('#totalDebit').text(formatNumber(summary.total_dr));
      $('#totalCredit').text(formatNumber(summary.total_cr));
      
      if (summary.is_balanced) {
        $('#balanceCard').removeClass('unbalanced').addClass('balanced');
        $('#balanceStatus').text('Balanced');
        $('#balanceDetail').text('Debit equals Credit');
        $('#balanceIcon').removeClass('fa-triangle-exclamation').addClass('fa-scale-balanced');
        $('#tbFoot').removeClass('unbalanced');
      } else {
        $('#balanceCard').removeClass('balanced').addClass('unbalanced');
        $('#balanceStatus').text('Unbalanced');
        const diff = Math.abs(parseFloat(summary.total_dr) - parseFloat(summary.total_cr));
        $('#balanceDetail').text('Difference: ' + formatNumber(diff));
        $('#balanceIcon').removeClass('fa-scale-balanced').addClass('fa-triangle-exclamation');
        $('#tbFoot').addClass('unbalanced');
      }
      
      // Update footer totals
      $('#footDebit').text(formatNumber(summary.total_dr));
      $('#footCredit').text(formatNumber(summary.total_cr));
      
      // Build table rows
      if (!data.length) {
        $('#tbBody').html('<tr><td colspan="7" class="text-center py-4 text-muted">No data found</td></tr>');
        $('#loadingOverlay').hide();
        return;
      }
      
      let html = '';
      let currentClass = '';
      
      data.forEach(function(row) {
        // Add class header row if class changed
        if (row.class !== currentClass) {
          currentClass = row.class;
          html += `<tr class="class-header">
            <td colspan="6"><i class="fas fa-folder-open me-2"></i>${currentClass}</td>
          </tr>`;
        }
        
        const balanceBadge = row.balance_type === 'DR' 
          ? '<span class="balance-badge badge-dr">DR</span>' 
          : '<span class="balance-badge badge-cr">CR</span>';
        
        html += `<tr>
          <td><a href="/finance/statement-of-account/${row.ledger_id}" target="_blank" class="text-decoration-none fw-bold">${row.ledger_name}</a></td>
          <td>${row.sub_class}</td>
          <td>${row.group}</td>
          <td class="amount-col">${formatNumber(row.total_debit)}</td>
          <td class="amount-col">${formatNumber(row.total_credit)}</td>
          <td class="amount-col">${formatNumber(row.closing_balance)} ${balanceBadge}</td>
        </tr>`;
      });
      
      $('#tbBody').html(html);
    })
    .fail(function(xhr) {
      $('#tbBody').html('<tr><td colspan="7" class="text-center py-4 text-danger">Failed to load data</td></tr>');
    })
    .always(function() {
      $('#loadingOverlay').hide();
    });
}

$('#filterForm').on('submit', function(e) {
  e.preventDefault();
  const params = {};
  
  const dateFrom = $('#posting_date_from').val();
  const dateTo = $('#posting_date_to').val();
  const spacial = $('#spacial').val();
  
  if (dateFrom) params.posting_date_from = dateFrom;
  if (dateTo) params.posting_date_to = dateTo;
  if (spacial) params.spacial = spacial;
  
  loadTrialBalance(params);
});

$('#btnClear').on('click', function() {
  $('#filterForm')[0].reset();
  loadTrialBalance();
});

$(document).ready(function() {
  loadTrialBalance();
});
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/finance_module/trial_balance.blade.php ENDPATH**/ ?>