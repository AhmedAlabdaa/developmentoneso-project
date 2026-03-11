<?php use Carbon\Carbon; ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
.select2-container { width: 100%!important; }
.select2-container .select2-selection--single { height: 38px; padding: 4px 8px; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 28px; }
.select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px; }
.select2-dropdown { z-index: 9999; }
.table-container { width: 100%; overflow-x: auto; position: relative; }
.table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
.table th, .table td { padding: 10px 15px; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.table th { background-color: #343a40; color: white; text-transform: uppercase; font-weight: bold; }
.table-hover tbody tr:hover { background-color: #f1f1f1; }
.table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
.actions { display: flex; gap: 5px; }
.btn-icon-only { display: inline-flex; align-items: center; justify-content: center; padding: 5px; border-radius: 50%; font-size: 12px; width: 30px; height: 30px; color: white; }
.btn-info { background-color: #17a2b8; }
.btn-warning { background-color: #ffc107; }
.btn-danger { background-color: #dc3545; }
.btn-primary { background-color: #007bff; }
.sticky-table th:last-child, .sticky-table td:last-child { position: sticky; right: 0; background-color: white; z-index: 2; box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1); min-width: 150px; }
.modal .table th:last-child, .modal .table td:last-child { position: static; }
.table th:last-child { z-index: 3; }
.status-dropdown { padding: 5px; font-size: 12px; border-radius: 5px; transition: background-color 0.3s; width: 120px; color: #000; font-weight: bold; text-transform: uppercase; }
.status-dropdown.approved { background-color: #28a745; }
.status-dropdown.pending  { background-color: #ffc107; }
.status-dropdown.rejected { background-color: #dc3545; }
.status-dropdown.review   { background-color: #17a2b8; }
.attachments-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px; margin-top: 10px; }
.attachment-item { text-align: center; }
.attachment-item p { margin-top: 5px; font-size: 12px; }
.img-thumbnail { max-width: 100px; max-height: 100px; object-fit: cover; }
.bg-gradient-primary { background: linear-gradient(to right, #007bff, #6a11cb); }
.btn-sm { font-size: 0.8rem; }
.scrollable-modal-body { max-height: 500px; overflow-y: auto; }
.badge-finance-yes { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
.badge-finance-no { background-color: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; }
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Ref #</th>
                <th>Agree. #</th>
                <th>Created Date</th>
                <th>CL #</th>
                <th>CN #</th>
                <th>Customer Name</th>
                <th>Maid Name</th>
                <th>Status</th>
                <th>Approved Date</th>
                <th>Total Amount</th>
                <th>Received Amount</th>
                <th>Balance Due</th>
                <th>Payment Method</th>
                <th>Notes</th>
                <th>Finance</th>
                <th>Refunded</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($invoices->isEmpty()): ?>
                <tr>
                    <td colspan="20" class="text-center no-records">
                        <h5 style="margin:50px 0;">There are no records available</h5>
                    </td>
                </tr>
            <?php else: ?>
                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('invoices.show', $invoice->invoice_number)); ?>" class="text-primary" target="_blank">
                                <?php echo e($invoice->invoice_number); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('agreements.show', $invoice->agreement_reference_no)); ?>" class="text-primary" target="_blank">
                                <?php echo e($invoice->agreement_reference_no); ?>

                            </a>
                        </td>
                        <td>
                            <?php echo e(Carbon::parse($invoice->created_at)->format('d M Y')); ?>

                        </td>
                        <td>
                            <a href="<?php echo e(route('crm.show', $invoice->customer->slug ?? '')); ?>" class="text-success fw-bold" target="_blank">
                                <?php echo e($invoice->customer->cl ?? $invoice->CL_Number); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('candidates.show', $invoice->candidate->reference_no ?? '')); ?>" class="text-primary" target="_blank">
                                <?php echo e($invoice->CN_Number); ?>

                            </a>
                        </td>
                        <td>
                            <?php $cust = optional($invoice->customer); ?>
                            <a href="<?php echo e($cust->slug ? route('crm.show', $cust->slug) : '#'); ?>" class="text-primary" target="_blank">
                                <?php echo e(trim($cust->first_name . ' ' . $cust->last_name)); ?>

                            </a>
                        </td>
                        <td>
                            <a href="#"><?php echo e(optional($invoice->agreement)->candidate_name ?? ''); ?></a>
                        </td>
                        <td>
                            <select class="status-dropdown" data-invoice-id="<?php echo e($invoice->invoice_id); ?>" onchange="confirmStatusChange(this, <?php echo e($invoice->invoice_id); ?>, '<?php echo e($invoice->customer->first_name ?? ''); ?>', '<?php echo e($invoice->received_amount); ?>', '<?php echo e($invoice->agreement_reference_no); ?>', '<?php echo e($invoice->invoice_type); ?>')">
                                <option value="Pending" <?php echo e($invoice->status == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="Unpaid" <?php echo e($invoice->status == 'Unpaid' ? 'selected' : ''); ?>>Unpaid</option>
                                <option value="Paid" <?php echo e($invoice->status == 'Paid' ? 'selected' : ''); ?>>Paid</option>
                                <option value="Partially Paid" <?php echo e($invoice->status == 'Partially Paid' ? 'selected' : ''); ?>>Partially Paid</option>
                                <option value="Overdue" <?php echo e($invoice->status == 'Overdue' ? 'selected' : ''); ?>>Overdue</option>
                                <option value="Cancelled" <?php echo e($invoice->status == 'Cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                <option value="Hold" <?php echo e($invoice->status == 'Hold' ? 'selected' : ''); ?>>Hold</option>
                                <option value="COD" <?php echo e($invoice->status == 'COD' ? 'selected' : ''); ?>>COD</option>
                                <option value="Replacement" <?php echo e($invoice->status == 'Replacement' ? 'selected' : ''); ?>>Replacement</option>
                            </select>
                        </td>
                        <td>
                          <?php if(in_array($invoice->status, ['Paid','Partially Paid','Cancelled','COD','Replacement'])): ?>
                            <?php echo e(Carbon::parse($invoice->due_date)->format('d M Y')); ?>

                          <?php endif; ?>
                        </td>
                        <td><?php echo e(number_format($invoice->total_amount, 2)); ?></td>
                        <td><?php echo e(number_format($invoice->received_amount, 2)); ?></td>
                        <td><?php echo e(number_format($invoice->balance_due, 2)); ?></td>
                        <td><?php echo e($invoice->payment_method); ?></td>
                        <td><?php echo e($invoice->notes); ?></td>
                        <td>
                            <?php if($invoice->has_finance): ?>
                                <span class="badge-finance-yes">Yes</span>
                            <?php else: ?>
                                <span class="badge-finance-no">No</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($invoice->refunded): ?>
                                <span class="badge-finance-yes">Yes</span>
                            <?php else: ?>
                                <span class="badge-finance-no">No</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <button type="button" class="btn btn-success btn-icon-only" data-bs-toggle="modal" data-bs-target="#paymentProofModal<?php echo e($invoice->invoice_number); ?>">
                                <i class="fas fa-receipt"></i>
                            </button>
                            <?php if($invoice->customer && $invoice->customer->ledger_id): ?>
                                <a href="<?php echo e(route('finance.statementOfAccount', $invoice->customer->ledger_id)); ?>" class="btn btn-info btn-icon-only" title="View Statement of Account" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-icon-only" disabled title="No Ledger Linked">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            <?php endif; ?>
                            <?php if(str_starts_with($invoice->invoice_number, 'INV-P1-') && !$invoice->has_finance): ?>
                                <button type="button" class="btn btn-primary btn-icon-only" data-bs-toggle="modal" data-bs-target="#packageOneModal<?php echo e($invoice->invoice_id); ?>" title="Create Package One Journal Entry">
                                    <i class="fas fa-calculator"></i>
                                </button>
                            <?php endif; ?>
                            <?php if(str_starts_with($invoice->invoice_number, 'INV-P1-')): ?>
                                <button type="button" class="btn btn-danger btn-icon-only" 
                                        onclick="voidPackageOne(<?php echo e($invoice->journal->id ?? 0); ?>, '<?php echo e($invoice->invoice_number); ?>')" 
                                        title="<?php echo e($invoice->has_finance ? 'Void Package One Journal Entry' : 'No Journal Entry to Void'); ?>"
                                        <?php echo e(!$invoice->has_finance ? 'disabled' : ''); ?>>
                                    <i class="fas fa-ban"></i>
                                </button>
                            <?php endif; ?>
                            <?php if(!$invoice->refunded && str_starts_with($invoice->invoice_number, 'INV-P1-')): ?>
                                <button type="button" class="btn btn-warning btn-icon-only" onclick="createCreditNote(<?php echo e($invoice->invoice_id); ?>, '<?php echo e($invoice->invoice_number); ?>')" title="Create Credit Note">
                                    <i class="fas fa-undo"></i>
                                </button>
                            <?php endif; ?>
                            <?php if(str_starts_with($invoice->invoice_number, 'INV-P1-')): ?>
                                <button type="button" class="btn btn-icon-only" style="background-color:#17a2b8;color:white;" onclick="openChargingModal(<?php echo e($invoice->invoice_id); ?>, <?php echo e($invoice->customer_id); ?>)" title="Create Charging Entry">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            <?php endif; ?>
                            <?php if(str_contains($invoice->invoice_number, '-P1-') && 
                                (
                                    str_contains($invoice->invoice_number, 'INV-') || 
                                    (
                                        !$invoice->has_finance &&
                                        (str_contains($invoice->invoice_number, 'RVI-') || str_contains($invoice->invoice_number, 'RVO-'))
                                    )
                                )
                            ): ?>
                                <button type="button" class="btn btn-warning btn-icon-only text-white" style="background-color: #fd7e14; border-color: #fd7e14;" onclick="openReceiptVoucherModal(<?php echo e($invoice->invoice_id); ?>, <?php echo e($invoice->customer_id); ?>, '<?php echo e($invoice->invoice_number); ?>')" title="Create Receipt Voucher">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </button>
                            <?php endif; ?>
                            <?php if(Auth::user()->role === 'Admin'): ?>
                                <form action="<?php echo e(route('invoices.destroy', $invoice->invoice_number)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-icon-only" onclick="return confirm('Are you sure?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="paymentProofModal<?php echo e($invoice->invoice_number); ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Payment Proof</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center scrollable-modal-body">
                                    <?php if(!empty($invoice->payment_proof)): ?>
                                        <?php
                                            $filePath = asset('storage/'.$invoice->payment_proof);
                                            $ext      = pathinfo($filePath, PATHINFO_EXTENSION);
                                        ?>
                                        <?php if(in_array($ext, ['jpg','jpeg','png','gif','bmp'])): ?>
                                            <img src="<?php echo e($filePath); ?>" class="img-fluid d-block mx-auto rounded-3 shadow">
                                        <?php elseif($ext === 'pdf'): ?>
                                            <iframe src="<?php echo e($filePath); ?>" width="100%" height="500" style="border:none"></iframe>
                                        <?php else: ?>
                                            <p>Unsupported file format.</p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p>No payment proof available.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <?php if(!empty($invoice->payment_proof)): ?>
                                        <a href="<?php echo e($filePath); ?>" download class="btn btn-primary"><i class="fas fa-download"></i> Download</a>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <?php if(str_starts_with($invoice->invoice_number, 'INV-P1-')): ?>
                    <div class="modal fade" id="packageOneModal<?php echo e($invoice->invoice_id); ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title"><i class="fas fa-calculator me-2"></i>Create Package One Journal Entry</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="packageOneForm<?php echo e($invoice->invoice_id); ?>" data-invoice-id="<?php echo e($invoice->invoice_id); ?>" data-cn-number="<?php echo e($invoice->CN_Number); ?>" data-customer-id="<?php echo e($invoice->customer_id); ?>">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Invoice:</strong> <?php echo e($invoice->invoice_number); ?></label>
                                            <input type="hidden" name="invoice_id" value="<?php echo e($invoice->invoice_id); ?>">
                                            <input type="hidden" name="cn_number" value="<?php echo e($invoice->CN_Number); ?>">
                                            <input type="hidden" name="customer_id" value="<?php echo e($invoice->customer_id); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">CN Number</label>
                                            <input type="text" class="form-control" value="<?php echo e($invoice->CN_Number); ?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Invoice Service</label>
                                            <select class="form-select invoice-service-select" name="invoice_service_id" id="invoiceServiceSelect<?php echo e($invoice->invoice_id); ?>">
                                                <option value="">-- Auto-select Package One Service --</option>
                                            </select>
                                            <small class="text-muted">Leave empty to use default Package One service</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Amount Received (Optional)</label>
                                            <input type="number" step="0.01" min="0" class="form-control amount-received-input" name="amount_received" id="amountReceived<?php echo e($invoice->invoice_id); ?>" placeholder="0.00" oninput="toggleDebitLedger(<?php echo e($invoice->invoice_id); ?>)">
                                        </div>
                                        <div class="mb-3" id="debitLedgerContainer<?php echo e($invoice->invoice_id); ?>" style="display:none;">
                                            <label class="form-label">Debit Ledger (Cash/Bank)</label>
                                            <select class="form-select ledger-select" name="debit_ledger_id" id="debitLedgerSelect<?php echo e($invoice->invoice_id); ?>">
                                                <option value="">-- Select Ledger --</option>
                                            </select>
                                            <small class="text-muted">Required when amount received > 0</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="submitBtn<?php echo e($invoice->invoice_id); ?>" onclick="submitPackageOne(<?php echo e($invoice->invoice_id); ?>)">
                                            <i class="fas fa-save me-1"></i> Create Journal Entry
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Ref #</th>
                <th>Agree. #</th>
                <th>Created Date</th>
                <th>CL #</th>
                <th>CN #</th>
                <th>Customer Name</th>
                <th>Maid Name</th>
                <th>Status</th>
                <th>Approved Date</th>
                <th>Total Amount</th>
                <th>Received Amount</th>
                <th>Balance Due</th>
                <th>Payment Method</th>
                <th>Notes</th>
                <th>Finance</th>
                <th>Refunded</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">Showing <?php echo e($invoices->firstItem()); ?> to <?php echo e($invoices->lastItem()); ?> of <?php echo e($invoices->total()); ?> results</span>
        <ul class="pagination justify-content-center">
            <?php echo e($invoices->links('vendor.pagination.bootstrap-4')); ?>

        </ul>
    </div>
</nav>




<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
// Load Invoice Services (type=2) for Package One
// Cache the results globally to avoid multiple API calls
let invoiceServicesCache = null;

function loadInvoiceServices(selectId) {
    const select = document.getElementById(selectId);
    if (!select) return;
    
    // Clear existing options except the first placeholder
    while (select.options.length > 1) {
        select.remove(1);
    }
    
    // If we have cached data, use it
    if (invoiceServicesCache) {
        invoiceServicesCache.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id;
            opt.textContent = s.text;
            select.appendChild(opt);
        });
        return;
    }
    
    // Fetch from API and cache
    fetch('/api/invoice-services/lookup?type=2')
        .then(r => r.json())
        .then(data => {
            if (data.results) {
                invoiceServicesCache = data.results;
                data.results.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.text;
                    select.appendChild(opt);
                });
            }
        })
        .catch(e => console.error('Error loading invoice services:', e));
}

// Initialize Select2 with AJAX search for Debit Ledger
function initDebitLedgerSelect2(invoiceId) {
    const selectEl = $('#debitLedgerSelect' + invoiceId);
    if (selectEl.data('select2')) return; // Already initialized
    
    selectEl.select2({
        placeholder: 'Search ledger...',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#packageOneModal' + invoiceId),
        ajax: {
            url: '/api/ledgers/lookup',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || '',
                    spacial: 2,
                    page: params.page || 1,
                    per_page: 20
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results.map(item => ({
                        id: item.id,
                        text: item.text
                    })),
                    pagination: {
                        more: data.pagination && data.pagination.more
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 0
    });
}

// Toggle debit ledger visibility
function toggleDebitLedger(invoiceId) {
    const amountInput = document.getElementById('amountReceived' + invoiceId);
    const container = document.getElementById('debitLedgerContainer' + invoiceId);
    const amount = parseFloat(amountInput.value) || 0;
    
    if (amount > 0) {
        container.style.display = 'block';
        initDebitLedgerSelect2(invoiceId);
    } else {
        container.style.display = 'none';
    }
}

// Submit Package One form
function submitPackageOne(invoiceId) {
    const form = document.getElementById('packageOneForm' + invoiceId);
    const submitBtn = document.getElementById('submitBtn' + invoiceId);
    
    if (!form || !submitBtn) {
        alert('Error: Form not found. Please refresh the page.');
        return;
    }
    
    // Build request data from form data attributes (reliable source)
    const data = {
        invoice_id: parseInt(form.dataset.invoiceId),
        cn_number: form.dataset.cnNumber,
        customer_id: parseInt(form.dataset.customerId)
    };
    
    // Validate required fields
    if (!data.invoice_id || !data.cn_number || !data.customer_id) {
        alert('Error: Missing required invoice data. Please refresh the page.');
        return;
    }
    
    // Get invoice service (optional)
    const invoiceServiceVal = document.getElementById('invoiceServiceSelect' + invoiceId)?.value;
    if (invoiceServiceVal) {
        data.invoice_service_id = parseInt(invoiceServiceVal);
    }
    
    // Get amount received (optional)
    const amountReceivedInput = document.getElementById('amountReceived' + invoiceId);
    const amountReceived = parseFloat(amountReceivedInput?.value) || 0;
    
    if (amountReceived > 0) {
        data.amount_received = amountReceived;
        
        // Get debit ledger (required if amount > 0)
        const debitLedgerVal = $('#debitLedgerSelect' + invoiceId).val();
        if (!debitLedgerVal) {
            alert('Please select a Debit Ledger (Cash/Bank) when Amount Received is greater than 0.');
            return;
        }
        data.debit_ledger_id = parseInt(debitLedgerVal);
    }
    
    // Disable button and show loading
    submitBtn.disabled = true;
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Creating...';
    
    // Send API request
    fetch('/api/package-one', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json().then(body => ({ status: response.status, body })))
    .then(({ status, body }) => {
        if (status === 200 || status === 201) {
            // Success
            if (typeof toastr !== 'undefined') {
                toastr.success(body.message || 'Journal entry created successfully!');
            } else {
                alert('Success: ' + (body.message || 'Journal entry created successfully!'));
            }
            
            // Close modal
            const modalEl = document.getElementById('packageOneModal' + invoiceId);
            if (modalEl) {
                if (typeof bootstrap !== 'undefined') {
                    bootstrap.Modal.getInstance(modalEl)?.hide();
                } else {
                    $(modalEl).modal('hide');
                }
            }
            
            // Reload table
            if (typeof loadInvoices === 'function') {
                const tab = $('#mainTabs a.active').attr('id')?.replace('-tab', '') || 'inv';
                loadInvoices(tab, $('#filter_status').val() || 'all');
            } else {
                window.location.reload();
            }
        } else {
            // Error from API
            const errMsg = body.error || body.message || 'Failed to create journal entry.';
            if (typeof toastr !== 'undefined') {
                toastr.error(errMsg);
            } else {
                alert('Error: ' + errMsg);
            }
        }
    })
    .catch(error => {
        console.error('API Error:', error);
        alert('Network error. Please check your connection and try again.');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
}

// Load services when modal opens
document.addEventListener('shown.bs.modal', function(event) {
    const modalId = event.target.id;
    if (modalId.startsWith('packageOneModal')) {
        const invoiceId = modalId.replace('packageOneModal', '');
        loadInvoiceServices('invoiceServiceSelect' + invoiceId);
    }
});

// Create Credit Note for Package One
function createCreditNote(invoiceId, invoiceNumber) {
    const confirmMsg = 'Are you sure you want to create a Credit Note for invoice ' + invoiceNumber + '?\n\nThis will reverse the financial entries.';
    
    // Use SweetAlert if available, otherwise native confirm
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Create Credit Note?',
            text: 'This will reverse the financial entries for invoice ' + invoiceNumber,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, create credit note',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                submitCreditNote(invoiceId);
            }
        });
    } else {
        if (confirm(confirmMsg)) {
            submitCreditNote(invoiceId);
        }
    }
}

function submitCreditNote(invoiceId) {
    fetch('/api/package-one/credit-note', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ invoice_id: invoiceId })
    })
    .then(response => response.json().then(body => ({ status: response.status, body })))
    .then(({ status, body }) => {
        if (status === 200 || status === 201) {
            if (typeof toastr !== 'undefined') {
                toastr.success(body.message || 'Credit note created successfully!');
            } else {
                alert('Success: ' + (body.message || 'Credit note created successfully!'));
            }
            // Reload table
            if (typeof loadInvoices === 'function') {
                const tab = $('#mainTabs a.active').attr('id')?.replace('-tab', '') || 'inv';
                loadInvoices(tab, $('#filter_status').val() || 'all');
            } else {
                window.location.reload();
            }
        } else {
            const errMsg = body.error || body.message || 'Failed to create credit note.';
            if (typeof toastr !== 'undefined') {
                toastr.error(errMsg);
            } else {
                alert('Error: ' + errMsg);
            }
        }
    })
    .catch(error => {
        console.error('API Error:', error);
        alert('Network error. Please check your connection and try again.');
    });
}

// Void Package One Journal Entry
function voidPackageOne(journalId, invoiceNumber) {
    const confirmMsg = 'Are you sure you want to VOID the journal entry for invoice ' + invoiceNumber + '?\n\nThis will permanently delete the financial record.';
    
    // Use SweetAlert if available, otherwise native confirm
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Void Journal Entry?',
            text: 'This will permanently delete the financial record for invoice ' + invoiceNumber,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, void it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                submitVoidPackageOne(journalId);
            }
        });
    } else {
        if (confirm(confirmMsg)) {
            submitVoidPackageOne(journalId);
        }
    }
}

function submitVoidPackageOne(journalId) {
    // Show global loading if possible, or use toastr
    if (typeof toastr !== 'undefined') toastr.info('Voiding journal entry...');

    fetch('/api/package-one/' + journalId, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(response => response.json().then(body => ({ status: response.status, body })))
    .then(({ status, body }) => {
        if (status === 200 || status === 204) {
            if (typeof toastr !== 'undefined') {
                toastr.success(body.message || 'Journal entry voided successfully!');
            } else {
                alert('Success: ' + (body.message || 'Journal entry voided successfully!'));
            }
            // Reload table
            if (typeof loadInvoices === 'function') {
                const tab = $('#mainTabs a.active').attr('id')?.replace('-tab', '') || 'inv';
                loadInvoices(tab, $('#filter_status').val() || 'all');
            } else {
                window.location.reload();
            }
        } else {
            const errMsg = body.error || body.message || 'Failed to void journal entry.';
            if (typeof toastr !== 'undefined') {
                toastr.error(errMsg);
            } else {
                alert('Error: ' + errMsg);
            }
        }
    })
    .catch(error => {
        console.error('API Error:', error);
        alert('Network error. Please check your connection and try again.');
    });
}

// ============== CHARGING ENTRY FUNCTIONS ==============

// Open Charging Modal
function openChargingModal(invoiceId, customerId) {
    // Set hidden fields
    document.getElementById('charging_invoice_id').value = invoiceId;
    document.getElementById('charging_customer_id').value = customerId;
    document.getElementById('charging_note').value = '';
    
    // Clear existing lines and add one empty row
    document.getElementById('chargingLinesBody').innerHTML = '';
    addChargingLine();
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('chargingModal'));
    modal.show();
}

// Add a new charging line row
function addChargingLine(data = {}) {
    const tbody = document.getElementById('chargingLinesBody');
    const rowIndex = tbody.querySelectorAll('tr').length;
    
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><select class="form-select charging-ledger-select" id="chargingLedger${rowIndex}" required></select></td>
        <td><input type="number" step="0.01" min="0" class="form-control charging-amount-input" placeholder="0.00" value="${data.amount || ''}"></td>
        <td><input type="text" class="form-control charging-note-input" placeholder="Line note" value="${data.note || ''}"></td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeChargingLine(this)">
                <i class="fas fa-minus"></i>
            </button>
        </td>
    `;
    tbody.appendChild(tr);
    
    // Initialize Select2 for the ledger dropdown
    initChargingLedgerSelect2($('#chargingLedger' + rowIndex), data.ledger_id || '', data.ledger_text || '');
}

// Initialize Select2 for charging ledger
function initChargingLedgerSelect2($select, initialId, initialText) {
    $select.select2({
        ajax: {
            url: '/api/ledgers/lookup',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || '',
                    page: params.page || 1,
                    per_page: 20
                };
            },
            processResults: function(data) {
                return {
                    results: data.results,
                    pagination: { more: data.pagination?.more }
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        placeholder: 'Search Ledger...',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#chargingModal')
    });
    
    if (initialId && initialText) {
        const option = new Option(initialText, initialId, true, true);
        $select.append(option).trigger('change');
    }
}

// Remove charging line
function removeChargingLine(btn) {
    const tbody = document.getElementById('chargingLinesBody');
    if (tbody.querySelectorAll('tr').length > 1) {
        btn.closest('tr').remove();
    } else {
        alert('At least one line is required.');
    }
}

// Submit Charging Entry
function submitCharging() {
    const invoiceId = parseInt(document.getElementById('charging_invoice_id').value);
    const customerId = parseInt(document.getElementById('charging_customer_id').value);
    const note = document.getElementById('charging_note').value;
    
    // Collect lines
    const lines = [];
    const rows = document.querySelectorAll('#chargingLinesBody tr');
    
    for (const row of rows) {
        const ledgerId = $(row).find('.charging-ledger-select').val();
        const amount = parseFloat($(row).find('.charging-amount-input').val()) || 0;
        const lineNote = $(row).find('.charging-note-input').val();
        
        if (!ledgerId) {
            alert('Please select a Ledger Account for all lines.');
            return;
        }
        if (amount <= 0) {
            alert('Please enter a valid amount greater than 0 for all lines.');
            return;
        }
        
        lines.push({
            ledger_id: parseInt(ledgerId),
            amount: amount,
            note: lineNote
        });
    }
    
    if (lines.length === 0) {
        alert('Please add at least one charging line.');
        return;
    }
    
    const data = {
        invoice_id: invoiceId,
        customer_id: customerId,
        note: note,
        lines: lines
    };
    
    const submitBtn = document.getElementById('submitChargingBtn');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Creating...';
    
    fetch('/api/package-one/charging', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json().then(body => ({ status: response.status, body })))
    .then(({ status, body }) => {
        if (status === 200 || status === 201) {
            if (typeof toastr !== 'undefined') {
                toastr.success(body.message || 'Charging entry created successfully!');
            } else {
                alert('Success: ' + (body.message || 'Charging entry created successfully!'));
            }
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('chargingModal'))?.hide();
            
            // Reload table
            if (typeof loadInvoices === 'function') {
                const tab = $('#mainTabs a.active').attr('id')?.replace('-tab', '') || 'inv';
                loadInvoices(tab, $('#filter_status').val() || 'all');
            } else {
                window.location.reload();
            }
        } else {
            const errMsg = body.error || body.message || 'Failed to create charging entry.';
            if (typeof toastr !== 'undefined') {
                toastr.error(errMsg);
            } else {
                alert('Error: ' + errMsg);
            }
        }
    })
    .catch(error => {
        console.error('API Error:', error);
        alert('Network error. Please check your connection and try again.');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
}

// ============== RECEIPT VOUCHER FUNCTIONS ==============

function openReceiptVoucherModal(invoiceId, customerId, invoiceNumber) {
    $('#rv_invoice_id').val(invoiceId);
    $('#rv_customer_id').val(customerId);
    $('#rv_invoice_number').val(invoiceNumber);
    $('#rv_amount').val('');
    $('#rv_note').val('Payment received for ' + invoiceNumber);
    
    // Reset Select2
    $('#rv_debit_ledger_id').val(null).trigger('change');
    
    const modal = new bootstrap.Modal(document.getElementById('receiptVoucherModal'));
    modal.show();
    
    // Init select2 after modal shows
    initReceiptVoucherSelect2();
}

function initReceiptVoucherSelect2() {
    $('#rv_debit_ledger_id').select2({
        dropdownParent: $('#receiptVoucherModal'),
        width: '100%',
        placeholder: 'Search Ledger...',
        allowClear: true,
        ajax: {
            url: '/api/ledgers/lookup',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || '',
                    spacial: 2,
                    page: params.page || 1,
                    per_page: 20
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results.map(item => ({
                        id: item.id,
                        text: item.text
                    })),
                    pagination: {
                        more: data.pagination && data.pagination.more
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 0
    });
}


</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/invoices/partials/invoice_table.blade.php ENDPATH**/ ?>