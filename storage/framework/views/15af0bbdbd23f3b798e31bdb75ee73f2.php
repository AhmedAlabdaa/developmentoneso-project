<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- FontAwesome & Select2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
    /* Global Background from govt-transactions */
    body { background: linear-gradient(to right, #e0f7fa, #e1bee7); font-family: Arial, sans-serif; }

    /* Select2 Styles */
    .select2-container--bootstrap-5 .select2-selection { border-color: #dee2e6; }
    .select2-container--bootstrap-5 .select2-dropdown { border-color: #dee2e6; }
    
    /* Button Styles from govt-transactions */
    .btn-icon-only {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        border-radius: 50%;
        font-size: 12px;
        width: 30px;
        height: 30px;
        color: #fff;
    }
    /* Override Bootstrap buttons for exact color match if needed, largely consistent with Bootstrap 5 */
    .btn-info { background-color: #17a2b8; border: none; color: #fff; }
    .btn-warning { background-color: #ffc107; border: none; color: #fff; }
    .btn-danger { background-color: #dc3545; border: none; color: #fff; }
    .btn-success { background-color: #198754; border: none; color: #fff; }
    
    /* Modal Table Styles */
    .journal-lines-table th { background-color: #f8f9fa; font-size: 0.85rem; }
    .journal-lines-table td { vertical-align: middle; }
    .total-row td { font-weight: bold; background-color: #e9ecef; }
    .text-danger-custom { color: #dc3545; }
    .text-success-custom { color: #198754; }

    /* Main Table Header Styling */
    #entriesTable thead th {
        padding-top: 15px;
        padding-bottom: 15px;
        background-color: #fff;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }
</style>

<main id="main" class="main">
    <section class="section">
        <div class="card shadow-sm mt-1">
            <div class="card-body pt-3">
                <!-- Header Section Moved Inside -->
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div>
                        <h2 class="fs-4 fw-bold text-dark mb-0"><i class="fas fa-book me-2"></i> Journal Entries</h2>
                        <div class="text-muted small mt-1"><?php echo e($now ?? date('l, F d, Y h:i A')); ?></div>
                    </div>
                    <div class="d-flex gap-2">
                        <!-- Bulk Update Section -->
                        <div class="d-flex align-items-center gap-2 me-2 border-end pe-2">
                            <select id="bulk_status" class="form-select form-select-sm" style="width: 120px;">
                                <option value="0">Draft</option>
                                <option value="1">Posted</option>
                                <option value="2">Void</option>
                            </select>
                            <button class="btn btn-primary btn-sm" onclick="performBulkUpdate()">
                                <i class="fas fa-check-double me-1"></i> Update
                            </button>
                        </div>

                        <button class="btn btn-info text-white" onclick="openBulkImportModal()">
                            <i class="fas fa-file-upload me-1"></i> Import Bulk Journals
                        </button>
                        <button class="btn btn-success" onclick="openCreateModal()">
                            <i class="fas fa-plus me-1"></i> Create Journal Entry
                        </button>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Date From</label>
                        <input type="date" id="filter_from" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Date To</label>
                        <input type="date" id="filter_to" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Status</label>
                        <select id="filter_status" class="form-select">
                            <option value="">All Status</option>
                            <option value="1">Posted</option>
                            <option value="0">Draft</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Type</label>
                        <select id="filter_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="debit">Debit</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Search</label>
                        <input type="text" id="filter_search" class="form-control" placeholder="Note, ledger...">
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button class="btn btn-primary w-50" id="btn_filter">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <button class="btn btn-outline-secondary w-50" id="btn_reset">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-2">
            <div class="card-body">
                <!-- Loading Indicator -->
                <div id="loading" class="text-center py-5">
                    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                    <p class="mt-2 text-muted">Loading journal entries...</p>
                </div>

                <!-- Table -->
                <div id="tableContainer" class="table-responsive" style="display: none;">
                    <table class="table table-striped table-hover align-middle" id="entriesTable">
                        <thead>
                            <tr>
                                <th style="width: 3%;"><input type="checkbox" id="selectAll"></th>
                                <th style="width: 5%;">#</th>
                                <th style="width: 10%;">Date</th>
                                <th style="width: 12%;">Source</th>
                                <th style="width: 15%;">Ledger</th>
                                <th class="text-end" style="width: 10%;">Debit</th>
                                <th class="text-end" style="width: 10%;">Credit</th>
                                <th style="width: 25%;">Note</th>
                                <th style="width: 8%;">Status</th>
                                <th style="width: 5%;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="entriesBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div id="pagination" class="d-flex justify-content-between align-items-center mt-3" style="display: none !important;">
                    <div class="text-muted small" id="paginationInfo">Showing 0 of 0 entries</div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0" id="paginationLinks">
                            <!-- Pagination links will be loaded here -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Create/Edit Modal -->
<div class="modal fade" id="journalModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="journalModalTitle"><i class="fas fa-book me-2"></i> Create Journal Entry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="journalForm">
                    <input type="hidden" id="journal_id">
                    
                    <!-- Header Fields -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Posting Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="posting_date" name="posting_date" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="0">Draft</option>
                                <option value="1">Posted</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Note</label>
                            <input type="text" class="form-control" id="note" name="note" placeholder="Description of this journal entry">
                        </div>
                    </div>

                    <!-- Journal Lines -->
                    <h6 class="fw-bold mb-3 border-bottom pb-2">Journal Lines</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered journal-lines-table" id="linesTable">
                            <thead>
                                <tr>
                                    <th style="width: 35%;">Ledger Account <span class="text-danger">*</span></th>
                                    <th style="width: 15%;" class="text-end">Debit</th>
                                    <th style="width: 15%;" class="text-end">Credit</th>
                                    <th style="width: 30%;">Line Note</th>
                                    <th style="width: 5%;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="linesBody">
                                <!-- Lines will be added here -->
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td class="text-end">Totals:</td>
                                    <td class="text-end" id="totalDebit">0.00</td>
                                    <td class="text-end" id="totalCredit">0.00</td>
                                    <td colspan="2"><span id="balanceMsg" class="badge bg-success">Balanced</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="mt-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addJournalLine()">
                            <i class="fas fa-plus me-1"></i> Add Line
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnSaveJournal" onclick="saveJournal()">
                    <i class="fas fa-save me-1"></i> Save Journal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Import Modal -->
<div class="modal fade" id="bulkImportModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-file-upload me-2"></i> Import Bulk Journal Journals</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="btnCloseImport"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light border shadow-sm">
                    <h6 class="fw-bold"><i class="fas fa-info-circle me-1"></i> Instructions</h6>
                    <p class="mb-2">Upload a CSV file with the following columns. The system will group rows by <code>posting_date</code> to create journal entries.</p>
                    <ul class="mb-2 small">
                        <li><strong>ledger_name</strong>: Exact name of the ledger account</li>
                        <li><strong>debit</strong>: Debit amount (0 if credit)</li>
                        <li><strong>credit</strong>: Credit amount (0 if debit)</li>
                        <li><strong>posting_date</strong>: YYYY-MM-DD format</li>
                        <li><strong>candidate_id</strong>: (Optional) Candidate ID if applicable</li>
                        <li><strong>note</strong>: (Optional) Line note</li>
                    </ul>
                </div>
                
                <h6 class="fw-bold mt-3">CSV Example Format</h6>
                <div class="table-responsive border rounded mb-3">
                    <table class="table table-sm table-bordered mb-0 bg-white small text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ledger_name</th>
                                <th>debit</th>
                                <th>credit</th>
                                <th>posting_date</th>
                                <th>candidate_id</th>
                                <th>note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cash Account</td>
                                <td>1000.00</td>
                                <td>0.00</td>
                                <td>2026-01-20</td>
                                <td></td>
                                <td>Opening Balance</td>
                            </tr>
                            <tr>
                                <td>Capital Account</td>
                                <td>0.00</td>
                                <td>1000.00</td>
                                <td>2026-01-20</td>
                                <td></td>
                                <td>Owner Investment</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Select CSV File</label>
                    <input type="file" class="form-control" id="importFile" accept=".csv" name="file">
                </div>
                
                <!-- Progress Bar -->
                <div id="importProgressContainer" style="display: none;">
                    <div class="progress mb-2" style="height: 20px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" id="importProgressBar">0%</div>
                    </div>
                    <p class="text-center small text-muted" id="importStatusText">Uploading...</p>
                </div>
                
                <!-- Errors Area -->
                <div id="importErrors" class="alert alert-danger mt-3" style="display: none; max-height: 200px; overflow-y: auto;"></div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelImport">Cancel</button>
                <button type="button" class="btn btn-info text-white" onclick="startBulkImport()" id="btnStartImport">
                    <i class="fas fa-cloud-upload-alt me-1"></i> Start Import
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Update Confirmation Modal -->
<div class="modal fade" id="bulkConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Confirm Bulk Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-check-double fa-3x text-warning opacity-75"></i>
                </div>
                <h5 class="mb-3">Are you sure?</h5>
                <p class="text-muted mb-0">You are about to update <span id="confirmBulkCount" class="fw-bold text-dark">0</span> unique journal entries to status:</p>
                <div class="mt-2">
                    <span id="confirmBulkStatus" class="badge fs-6 px-3">Status</span>
                </div>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary px-4" id="btnConfirmBulkAction" onclick="executeBulkUpdate()">
                    Confirm Update
                </button>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Add Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
$(function() {
    const apiUrl = '/api/journal-tran-lines';
    const journalApiUrl = '/api/journals';
    let currentPage = 1;
    let lineCounter = 0;
    
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    function formatNumber(num) {
        return parseFloat(num || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        return dateStr.substring(0, 10);
    }
    
    // ================== DATA LOADING ==================

    function loadData(page = 1) {
        currentPage = page;
        
        // Show loading
        $('#loading').show();
        $('#tableContainer').hide();
        $('#pagination').hide();
        
        let params = {
            page: page,
            per_page: 20,
            sort_by: 'created_at',
            sort_direction: 'desc'
        };
        
        const from = $('#filter_from').val();
        const to = $('#filter_to').val();
        const status = $('#filter_status').val();
        const type = $('#filter_type').val();
        const search = $('#filter_search').val();
        
        if (from) params.posting_date_from = from;
        if (to) params.posting_date_to = to;
        if (status) params.status = status;
        if (type) params.type = type;
        if (search) params.search = search;
        
        $.ajax({
            url: apiUrl,
            method: 'GET',
            data: params,
            success: function(res) {
                const data = res.data || [];
                const meta = res.meta || {};
                
                let html = '';
                if (data.length === 0) {
                    html = '<tr><td colspan="9" class="text-center text-muted py-5"><i class="fas fa-inbox fa-2x mb-2 d-block"></i>No journal entries found</td></tr>';
                } else {
                    data.forEach(function(item, idx) {
                        const isDebit = parseFloat(item.debit) > 0;
                        const ledgerName = item.ledger ? item.ledger.name : '-';
                        const sourceType = item.header ? item.header.source_name : '-';
                        const postingDate = item.header ? item.header.posting_date : formatDate(item.created_at);
                        const statusLabel = item.header && item.header.status_label ? item.header.status_label : '-';
                        const statusClass = statusLabel === 'Posted' ? 'success' : 'secondary';
                        const journalId = item.journal_header_id;
                        
                        html += `
                            <tr>
                                <td><input type="checkbox" class="row-checkbox" data-id="${journalId}"></td>
                                <td class="text-muted">${(meta.from || 1) + idx}</td>
                                <td>${postingDate}</td>
                                <td><span class="badge bg-info">${sourceType}</span></td>
                                <td>
                                    <a href="/finance/statement-of-account/${item.ledger_id}" target="_blank" class="fw-medium text-decoration-none text-dark">
                                        ${ledgerName} <i class="fas fa-external-link-alt ms-1 text-muted small"></i>
                                    </a>
                                    <small class="d-block text-muted">${item.ledger ? item.ledger.group : ''}</small>
                                </td>
                                <td class="text-end ${isDebit ? 'text-success fw-bold' : ''}">${isDebit ? formatNumber(item.debit) : '-'}</td>
                                <td class="text-end ${!isDebit ? 'text-danger fw-bold' : ''}">${!isDebit ? formatNumber(item.credit) : '-'}</td>
                                <td><small>${item.note || '-'}</small></td>
                                <td><span class="badge bg-${statusClass}">${statusLabel}</span></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-icon-only" onclick="openEditModal(${journalId})" title="Edit Journal Entry">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }
                
                $('#entriesBody').html(html);
                
                $('#paginationInfo').text(`Showing ${meta.from || 0} to ${meta.to || 0} of ${meta.total || 0} entries`);
                
                let paginationHtml = '';
                if (meta.last_page > 1) {
                    paginationHtml += `<li class="page-item ${meta.current_page === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${meta.current_page - 1}">&laquo;</a>
                    </li>`;
                    
                    let startPage = Math.max(1, meta.current_page - 2);
                    let endPage = Math.min(meta.last_page, startPage + 4);
                    if (endPage - startPage < 4) startPage = Math.max(1, endPage - 4);
                    
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `<li class="page-item ${i === meta.current_page ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>`;
                    }
                    
                    paginationHtml += `<li class="page-item ${meta.current_page === meta.last_page ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${meta.current_page + 1}">&raquo;</a>
                    </li>`;
                }
                $('#paginationLinks').html(paginationHtml);
                
                $('#loading').hide();
                $('#tableContainer').show();
                if (meta.last_page > 1) {
                    $('#pagination').show();
                }
            },
            error: function(err) {
                console.error('Error loading data:', err);
                $('#entriesBody').html('<tr><td colspan="9" class="text-center text-danger py-5">Error loading data</td></tr>');
                $('#loading').hide();
                $('#tableContainer').show();
            }
        });
    }
    
    // ================== INITIALIZATION ==================
    
    loadData(1);
    
    $('#btn_filter').click(function() { loadData(1); });
    $('#filter_search').keypress(function(e) { if (e.which === 13) loadData(1); });
    $('#btn_reset').click(function() {
        $('#filter_from, #filter_to, #filter_search').val('');
        $('#filter_status, #filter_type').val('');
        loadData(1);
    });
    
    $(document).on('click', '#paginationLinks .page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page && !$(this).parent().hasClass('disabled')) loadData(page);
    });

    // ================== MODAL & FORM LOGIC ==================

    window.openCreateModal = function() {
        $('#journalModalTitle').html('<i class="fas fa-book me-2"></i> Create Journal Entry');
        $('#journal_id').val('');
        $('#journalForm')[0].reset();
        $('#linesBody').empty();
        $('#posting_date').val(new Date().toISOString().split('T')[0]);
        $('#status').val('0');
        
        addJournalLine();
        addJournalLine();
        
        calculateTotals();
        
        const modal = new bootstrap.Modal(document.getElementById('journalModal'));
        modal.show();
    };

    window.openEditModal = function(id) {
        $.ajax({
            url: journalApiUrl + '/' + id,
            method: 'GET',
            success: function(res) {
                const journal = res.data;
                
                $('#journalModalTitle').html('<i class="fas fa-edit me-2"></i> Edit Journal Entry #' + journal.id);
                $('#journal_id').val(journal.id);
                $('#posting_date').val(journal.posting_date);
                $('#status').val(journal.status_label === 'Posted' ? 1 : 0);
                $('#note').val(journal.note);
                
                $('#linesBody').empty();
                
                if (journal.lines && journal.lines.length > 0) {
                    journal.lines.forEach(line => {
                        addJournalLine({
                            id: line.id,
                            ledger_id: line.ledger_id,
                            ledger_name: line.ledger ? line.ledger.name : '',
                            debit: parseFloat(line.debit) > 0 ? line.debit : '',
                            credit: parseFloat(line.credit) > 0 ? line.credit : '',
                            note: line.note
                        });
                    });
                } else {
                    addJournalLine();
                    addJournalLine();
                }
                
                calculateTotals();
                
                const modal = new bootstrap.Modal(document.getElementById('journalModal'));
                modal.show();
            },
            error: function(err) {
                toastr.error('Failed to load journal details');
            }
        });
    };

    window.addJournalLine = function(data = {}) {
        lineCounter++;
        const rowId = 'line_' + lineCounter;
        
        const tr = document.createElement('tr');
        tr.className = 'journal-line';
        if (data.id) tr.dataset.id = data.id;
        
        tr.innerHTML = `
            <td>
                <select class="form-select ledger-select" id="ledger_${rowId}" required></select>
            </td>
            <td>
                <input type="number" step="0.01" min="0" class="form-control text-end debit-input" placeholder="0.00" value="${data.debit || ''}">
            </td>
            <td>
                <input type="number" step="0.01" min="0" class="form-control text-end credit-input" placeholder="0.00" value="${data.credit || ''}">
            </td>
            <td>
                <input type="text" class="form-control note-input" placeholder="Line note" value="${data.note || ''}">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-icon-only remove-line" title="Remove Line">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        `;
        
        document.getElementById('linesBody').appendChild(tr);
        
        initLedgerSelect2($('#ledger_' + rowId), data.ledger_id, data.ledger_name);
        
        $(tr).find('.debit-input, .credit-input').on('input', function() {
            calculateTotals();
        });
        
        $(tr).find('.remove-line').click(function() {
            if ($('#linesBody tr').length > 2) {
                $(this).closest('tr').remove();
                calculateTotals();
            } else {
                toastr.warning('A journal entry must have at least 2 lines.');
            }
        });
    };
    
    function initLedgerSelect2($element, initialId, initialText) {
        $element.select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#journalModal'),
            ajax: {
                url: '/api/ledgers/lookup',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.results,
                        pagination: { more: data.pagination.more }
                    };
                },
                cache: true
            },
            placeholder: 'Search Ledger...',
            allowClear: true,
            minimumInputLength: 0
        });
        
        if (initialId && initialText) {
            const option = new Option(initialText, initialId, true, true);
            $element.append(option).trigger('change');
        }
    }
    
    function calculateTotals() {
        let totalDebit = 0;
        let totalCredit = 0;
        
        $('.journal-line').each(function() {
            const deb = parseFloat($(this).find('.debit-input').val()) || 0;
            const cred = parseFloat($(this).find('.credit-input').val()) || 0;
            totalDebit += deb;
            totalCredit += cred;
        });
        
        $('#totalDebit').text(formatNumber(totalDebit));
        $('#totalCredit').text(formatNumber(totalCredit));
        
        const diff = Math.abs(totalDebit - totalCredit);
        const msgEl = $('#balanceMsg');
        
        if (diff < 0.01 && totalDebit > 0) {
            msgEl.removeClass('bg-danger').addClass('bg-success').text('Balanced');
            return true;
        } else {
            msgEl.removeClass('bg-success').addClass('bg-danger').text('Unbalanced (Diff: ' + formatNumber(diff) + ')');
            return false;
        }
    }

    window.saveJournal = function() {
        if (!calculateTotals()) {
            toastr.error('Journal entry is not balanced.');
            return;
        }
        
        const id = $('#journal_id').val();
        const postingDate = $('#posting_date').val();
        const status = $('#status').val();
        const note = $('#note').val();
        
        const lines = [];
        let hasError = false;
        
        $('.journal-line').each(function() {
            const ledgerId = $(this).find('.ledger-select').val();
            const debit = parseFloat($(this).find('.debit-input').val()) || 0;
            const credit = parseFloat($(this).find('.credit-input').val()) || 0;
            const lineNote = $(this).find('.note-input').val();
            const lineId = $(this).data('id');
            
            if (!ledgerId) {
                hasError = true;
                toastr.error('All lines must have a ledger account selected.');
                return false;
            }
            
            if (debit === 0 && credit === 0) {
                 hasError = true;
                 toastr.error('Lines must have either Debit or Credit amount.');
                 return false;
            }
            
            const lineObj = {
                ledger_id: ledgerId,
                debit: debit,
                credit: credit,
                note: lineNote
            };
            
            if (lineId && id) {
                 lineObj.id = lineId;
            }
            
            lines.push(lineObj);
        });
        
        if (hasError) return;
        
        const data = {
            posting_date: postingDate,
            status: status,
            note: note,
            lines: lines
        };
        
        const btn = $('#btnSaveJournal');
        const originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        const method = id ? 'PUT' : 'POST';
        const url = id ? journalApiUrl + '/' + id : journalApiUrl;
        
        $.ajax({
            url: url,
            method: method,
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(res) {
                toastr.success(res.message || 'Journal saved successfully');
                bootstrap.Modal.getInstance(document.getElementById('journalModal')).hide();
                loadData(currentPage);
            },
            error: function(err) {
                console.error(err);
                const msg = err.responseJSON?.message || 'Error saving journal';
                toastr.error(msg);
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    };
    
    // ================== BULK IMPORT LOGIC ==================
    
    window.openBulkImportModal = function() {
        $('#importFile').val('');
        $('#importProgressContainer').hide();
        $('#importErrors').hide().empty();
        $('#importProgressBar').css('width', '0%').text('0%').removeClass('bg-success bg-danger');
        $('#btnStartImport').prop('disabled', false).html('<i class="fas fa-cloud-upload-alt me-1"></i> Start Import');
        $('#btnCloseImport, #btnCancelImport').prop('disabled', false);
        
        const modal = new bootstrap.Modal(document.getElementById('bulkImportModal'));
        modal.show();
    };
    
    window.startBulkImport = function() {
        const fileInput = document.getElementById('importFile');
        if (fileInput.files.length === 0) {
            toastr.error('Please select a CSV file first.');
            return;
        }
        
        const file = fileInput.files[0];
        const formData = new FormData();
        formData.append('file', file);
        
        // UI Updates
        $('#importProgressContainer').show();
        $('#importErrors').hide().empty();
        $('#btnStartImport').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Processing...');
        $('#btnCloseImport, #btnCancelImport').prop('disabled', true);
        
        $('#importStatusText').text('Uploading and Processing...');
        $('#importProgressBar').css('width', '50%').text('50%'); // Simulate progress for single request
        
        $.ajax({
            url: '/api/journals/bulk-import',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        // Only go up to 90% on upload, wait for processing
                        var displayPercent = Math.min(percentComplete, 90);
                        $('#importProgressBar').width(displayPercent + '%').text(displayPercent + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(res) {
                $('#importProgressBar').width('100%').text('100%').addClass('bg-success');
                $('#importStatusText').text('Import Completed Successfully!');
                
                toastr.success(res.message || 'Import completed successfully');
                
                if (res.errors && res.errors.length > 0) {
                     // If partial success with some errors (unlikely with transaction rollback, but good to handle)
                     $('#importErrors').html('<strong>Warning:</strong><br>' + res.errors.join('<br>')).show();
                     $('#btnStartImport').html('Import Done');
                     $('#btnCloseImport, #btnCancelImport').prop('disabled', false);
                } else {
                     setTimeout(function() {
                         bootstrap.Modal.getInstance(document.getElementById('bulkImportModal')).hide();
                         loadData(1); // Refresh table
                     }, 1500);
                }
            },
            error: function(err) {
                $('#importProgressBar').addClass('bg-danger');
                $('#importStatusText').text('Import Failed');
                
                let errorMsg = 'Unknown error occurred';
                if (err.responseJSON) {
                    if (err.responseJSON.message) errorMsg = err.responseJSON.message;
                    if (err.responseJSON.errors) {
                         const headerErrors = checkHeaderErrors(err.responseJSON.errors);
                         if (headerErrors) errorMsg = headerErrors;
                         else errorMsg += '<br>' + Object.values(err.responseJSON.errors).flat().join('<br>');
                    }
                    if (err.responseJSON.error) { // Custom error field
                        errorMsg = err.responseJSON.error; 
                    }
                }
                
                $('#importErrors').html('<strong>Error:</strong> ' + errorMsg).show();
                toastr.error('Import failed. Check errors.');
            },
            complete: function() {
                $('#btnStartImport').prop('disabled', false).html('<i class="fas fa-cloud-upload-alt me-1"></i> Start Import');
                $('#btnCloseImport, #btnCancelImport').prop('disabled', false);
            }
        });
    };

    function checkHeaderErrors(errors) {
        // sometimes validation errors on file headers come as "file.0", "file.1" etc if array validation
        // or just strict strings. 
        if (typeof errors === 'string') return errors;
        return null;
    }

    // ================== BULK UPDATE ACTIONS ==================

    // Select All toggle
    $(document).on('change', '#selectAll', function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
    });

    window.performBulkUpdate = function() {
        const ids = [];
        $('.row-checkbox:checked').each(function() {
            const id = $(this).data('id');
            if (id && !ids.includes(id)) {
                ids.push(id);
            }
        });

        if (ids.length === 0) {
            toastr.warning('Please select at least one journal entry.');
            return;
        }

        const status = $('#bulk_status').val();
        const statusLabel = $('#bulk_status option:selected').text();

        // Populate modal details
        $('#confirmBulkCount').text(ids.length);
        $('#confirmBulkStatus').text(statusLabel);
        
        // Change badge color based on status
        const statusBadge = $('#confirmBulkStatus');
        statusBadge.removeClass('bg-secondary bg-success bg-danger');
        if (status == '0') statusBadge.addClass('bg-secondary');
        else if (status == '1') statusBadge.addClass('bg-success');
        else if (status == '2') statusBadge.addClass('bg-danger');

        // Store data for the confirm button
        $('#btnConfirmBulkAction').data('ids', ids).data('status', status);

        const modal = new bootstrap.Modal(document.getElementById('bulkConfirmModal'));
        modal.show();
    };

    window.executeBulkUpdate = function() {
        const btn = $('#btnConfirmBulkAction');
        const ids = btn.data('ids');
        const status = btn.data('status');
        
        const originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Updating...');

        $.ajax({
            url: '/api/journal-tran-lines/bulk-update-status',
            method: 'POST',
            data: JSON.stringify({
                ids: ids,
                status: parseInt(status)
            }),
            contentType: 'application/json',
            success: function(res) {
                toastr.success(res.message || 'Updated successfully');
                $('#selectAll').prop('checked', false);
                bootstrap.Modal.getInstance(document.getElementById('bulkConfirmModal')).hide();
                loadData(currentPage);
            },
            error: function(err) {
                console.error(err);
                toastr.error(err.responseJSON?.message || 'Bulk update failed');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    };
});
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/finance_module/journal_entries.blade.php ENDPATH**/ ?>