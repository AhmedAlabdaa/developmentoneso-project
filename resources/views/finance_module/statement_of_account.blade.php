@include('role_header')

<!-- FontAwesome & Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        font-family: 'Inter', sans-serif;
        color: #343a40;
    }
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        background: #fff;
    }
    .card-header {
        background: transparent;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem;
    }
    .stat-card {
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-title {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        font-weight: 600;
    }
    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-top: 0.5rem;
    }
    
    /* Table Styling */
    .table-custom thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 15px;
        border-bottom: 2px solid #e9ecef;
        border-top: none;
    }
    .table-custom tbody td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.9rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Badge Styles */
    .badge-source {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    .bg-invoice { background-color: #e3f2fd; color: #0d47a1; }
    .bg-receipt { background-color: #e8f5e9; color: #1b5e20; }
    .bg-credit { background-color: #fff3e0; color: #e65100; }
    .bg-gov { background-color: #fff9c4; color: #f57f17; } /* Golden/Amber style */
    
    /* Loading Overlay */
    #loading-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255,255,255,0.9);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
</style>

<div id="loading-overlay">
    <i class="fas fa-circle-notch fa-spin fa-3x text-primary mb-3"></i>
    <h5 class="text-muted fw-normal">Generating Statement of Account...</h5>
</div>

<main id="main" class="main mt-5">
    <div class="row mb-4 animate__animated animate__fadeInDown">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i> Statement of Account</h2>
                <div class="text-muted">{{ date('l, F d, Y h:i A') }}</div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-success btn-lg px-4 shadow-sm" onclick="exportToExcel()">
                    <i class="fas fa-file-excel me-2"></i> Export to Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Filter & Opening Balance Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Date From</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar-alt text-primary"></i></span>
                        <input type="date" id="date_from" class="form-control border-start-0">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Date To</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-calendar-alt text-primary"></i></span>
                        <input type="date" id="date_to" class="form-control border-start-0">
                    </div>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-50 py-2" onclick="loadData()">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <button class="btn btn-outline-secondary w-50 py-2" onclick="resetFilters()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-primary bg-opacity-10 rounded border border-primary border-opacity-25 h-100">
                        <div class="small text-primary fw-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">Opening Balance</div>
                        <div class="h4 fw-bold mb-0 text-primary" id="opening-balance-display">0.00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card shadow-sm mb-4" id="content-section" style="display: none;">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <div>
                <h5 class="fw-bold mb-1 text-dark" id="ledger-name">Loading...</h5>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">Customer Ledger #<span id="ledger-id"></span></span>
            </div>
            <div class="text-end">
                <span id="period-display" class="small text-muted fw-medium"></span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 12%;">Date</th>
                            <th style="width: 15%;">Source</th>
                            <th style="width: 12%;">Serial no</th>
                            <th style="width: 21%;">Description / Note</th>
                            <th class="text-end" style="width: 12%;">Debit</th>
                            <th class="text-end" style="width: 12%;">Credit</th>
                            <th class="text-end" style="width: 11%;">Balance</th>
                        </tr>
                    </thead>
                    <tbody id="transactions-body">
                        <!-- Data rows -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-3">
             <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Generated on {{ date('d M Y, h:i A') }}</span>
                <span class="fw-bold">End of Statement</span>
             </div>
        </div>
    </div>
    <!-- Summary Cards (Moved to Bottom) -->
    <div class="row g-4 mb-5" id="summary-section" style="display: none;">
        <div class="col-md-4">
            <div class="card stat-card border-start border-4 border-success h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-title">Total Credit</div>
                            <div class="stat-value text-success" id="total-credit">0.00</div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-arrow-down text-success fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card border-start border-4 border-danger h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-title">Total Debit</div>
                            <div class="stat-value text-danger" id="total-debit">0.00</div>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-arrow-up text-danger fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card border-start border-4 border-primary h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-title">Closing Balance</div>
                            <div class="stat-value text-primary" id="closing-balance">0.00</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-wallet text-primary fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold"><i class="fas fa-file-excel me-2"></i> Export to Excel</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-4">Select the date range for your statement export. Leave dates blank to export the <strong>full history</strong>.</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Date From</label>
                            <input type="date" id="export_date_from" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Date To</label>
                            <input type="date" id="export_date_to" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light justify-content-center border-top-0 py-3">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success px-4" onclick="confirmExport()">
                        <i class="fas fa-download me-2"></i> Download Excel
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

@include('../layout.footer')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
$(document).ready(function() {
    const ledgerId = "{{ $ledgerId }}";
    
    function formatMoney(amount) {
        return parseFloat(amount || 0).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function formatBalance(amount) {
        const val = parseFloat(amount || 0);
        const absVal = Math.abs(val);
        const suffix = val > 0 ? ' DR' : (val < 0 ? ' CR' : '');
        return formatMoney(absVal) + suffix;
    }
    
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-GB', {
            day: '2-digit', month: 'short', year: 'numeric'
        });
    }

    function getSourceBadge(type) {
        let badgeClass = 'bg-secondary';
        let icon = 'fa-file';
        
        if (type === 'Invoice') {
            badgeClass = 'bg-invoice';
            icon = 'fa-file-invoice';
        } else if (type === 'ReceiptVoucher') {
            badgeClass = 'bg-receipt';
            icon = 'fa-receipt';
        } else if (type === 'Credit Note' || type === 'CreditNote') {
            badgeClass = 'bg-credit';
            icon = 'fa-undo';
        } else if (type === 'TypingTranGovInv') {
            badgeClass = 'bg-gov';
            icon = 'fa-landmark';
        }
        
        return `<span class="badge-source ${badgeClass}"><i class="fas ${icon} me-1"></i> ${type}</span>`;
    }

    window.loadData = function() {
        const dateFrom = $('#date_from').val();
        const dateTo = $('#date_to').val();
        
        $('#loading-overlay').show();
        $('#summary-section, #content-section').hide();
        
        $.ajax({
            url: `/api/statement-of-account/${ledgerId}`,
            method: 'GET',
            data: {
                date_from: dateFrom,
                date_to: dateTo
            },
            success: function(res) {
                const data = res.data || res;
                
                if (data.ledger) {
                    $('#ledger-name').text(data.ledger.name);
                    $('#ledger-id').text(data.ledger.id);
                }

                if (dateFrom || dateTo) {
                    $('#period-display').text(`Period: ${formatDate(dateFrom)} to ${formatDate(dateTo)}`);
                } else {
                    $('#period-display').text('Full History');
                }
                
                $('#opening-balance-display').text(formatBalance(data.opening_balance));
                
                if (data.summary) {
                    $('#total-debit').text(formatMoney(data.summary.total_debit));
                    $('#total-credit').text(formatMoney(data.summary.total_credit));
                    $('#closing-balance').text(formatBalance(data.summary.closing_balance));
                }
                
                const tbody = $('#transactions-body');
                tbody.empty();
                
                if (data.transactions && data.transactions.length > 0) {
                    data.transactions.forEach((trn, index) => {
                        const dr = parseFloat(trn.debit);
                        const cr = parseFloat(trn.credit);
                        const rb = parseFloat(trn.running_balance);
                        
                        const row = `
                            <tr>
                                <td class="text-muted">${index + 1}</td>
                                <td class="fw-medium">${formatDate(trn.posting_date)}</td>
                                <td>${getSourceBadge(trn.source_type)}</td>
                                <td class="fw-bold text-dark">${trn.serial_no || '-'}</td>
                                <td>
                                    <div class="text-dark fw-medium">${trn.note || '-'}</div>
                                    ${trn.source_id ? `<small class="text-muted">Ref ID: #${trn.source_id}</small>` : ''}
                                </td>
                                <td class="text-end ${dr > 0 ? 'fw-bold text-dark' : 'text-muted'}">${dr > 0 ? formatMoney(dr) : '-'}</td>
                                <td class="text-end ${cr > 0 ? 'fw-bold text-dark' : 'text-muted'}">${cr > 0 ? formatMoney(cr) : '-'}</td>
                                <td class="text-end fw-bold text-primary">${formatBalance(rb)}</td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                } else {
                    tbody.html('<tr><td colspan="8" class="text-center py-5 text-muted">No transactions found for this period.</td></tr>');
                }
                
                $('#loading-overlay').fadeOut();
                $('#summary-section, #content-section').fadeIn();
            },
            error: function(err) {
                console.error(err);
                toastr.error('Failed to load statement of account.');
                $('#loading-overlay').html('<div class="text-danger"><i class="fas fa-exclamation-triangle fa-3x mb-3"></i><h5>Failed to load data</h5><button class="btn btn-sm btn-outline-danger mt-3" onclick="location.reload()">Retry</button></div>');
            }
        });
    };

    window.exportToExcel = function() {
        // Sync page filters to modal inputs
        $('#export_date_from').val($('#date_from').val());
        $('#export_date_to').val($('#date_to').val());
        const modal = new bootstrap.Modal(document.getElementById('exportModal'));
        modal.show();
    };

    window.confirmExport = function() {
        const dateFrom = $('#export_date_from').val();
        const dateTo = $('#export_date_to').val();
        let exportUrl = `/api/statement-of-account/${ledgerId}/export`;
        const params = [];
        if (dateFrom) params.push(`date_from=${dateFrom}`);
        if (dateTo) params.push(`date_to=${dateTo}`);
        if (params.length > 0) exportUrl += '?' + params.join('&');
        
        window.location.href = exportUrl;
        bootstrap.Modal.getInstance(document.getElementById('exportModal')).hide();
        toastr.info('Generating your Excel report...');
    };

    window.resetFilters = function() {
        $('#date_from, #date_to').val('');
        loadData();
    };

    // Initial Load
    loadData();
});
</script>
