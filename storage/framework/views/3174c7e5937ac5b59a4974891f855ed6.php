<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
  .table th,.table td{vertical-align:middle}
  .nav-tabs .nav-link{color:#495057}
  .nav-tabs .nav-link:hover{background:#f8f9fa}
  .nav-tabs .nav-link.active{background:#007bff;color:#fff}
  .filter-dropdown .form-control,.filter-dropdown .form-select,.input-group .form-control{font-size:12px}
  .filter-dropdown{background:#fff;padding:15px;border-radius:5px;box-shadow:0 2px 10px rgba(0,0,0,.1)}
  .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:400}
  .pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}
  .preloader{display:none;position:absolute;left:40%;font-size:20px;color:#007bff}
  .no-data{font-size:12px;text-align:center;color:red}
  .input-clear{position:relative}
  .input-clear .fa-times-circle{position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#6c757d;display:none}
</style>

<main id="main" class="main">
<section class="section">
<div class="card flex-fill">
<div class="card-body">

<div class="d-flex align-items-center mb-3">
  <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
      <i class="fas fa-check-circle me-2"></i>
      <div><?php echo e(session('success')); ?></div>
      <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
  <?php elseif(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
      <i class="fas fa-exclamation-circle me-2"></i>
      <div><?php echo e(session('error')); ?></div>
      <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>
</div>

<div class="d-flex justify-content-between align-items-center" style="margin-top:10px">
  <ul class="nav nav-tabs" id="mainTabs">
    <li class="nav-item"><a class="nav-link active" id="rvo-tab" data-bs-toggle="tab" href="#receipt-voucher-outside">Receipt Voucher Outside (RVO)</a></li>
    <li class="nav-item"><a class="nav-link" id="rvi-tab" data-bs-toggle="tab" href="#receipt-voucher-inside">Receipt Voucher Inside (RVI)</a></li>
    <li class="nav-item"><a class="nav-link" id="inv-tab" data-bs-toggle="tab" href="#invoices">Tax Invoices (INV)</a></li>
  </ul>

  <div class="d-flex align-items-center">
    <div class="input-group input-clear" style="width:350px;">
      <input type="text" class="form-control" id="global_search" placeholder="Search by Invoice # / Customer Name / Candidate Name">
      <i class="fas fa-times-circle" id="clear_global_search"></i>
    </div>
    <div class="dropdown ms-2">
      <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">Filters</button>
      <div class="dropdown-menu filter-dropdown p-3" style="min-width:600px">
        <form id="global_filter_form" class="row g-2">
          <div class="col-6"><input type="text" class="form-control" name="customer_name" placeholder="Search By Customer Name"></div>
          <div class="col-6"><input type="text" class="form-control" name="candidate_name" placeholder="Search By Candidate Name"></div>
          <div class="col-6"><input type="text" class="form-control" name="CN_Number" placeholder="Search By CN Number"></div>
          <div class="col-6"><input type="text" class="form-control" name="CL_Number" placeholder="Search By CL Number"></div>
          <div class="col-6"><input type="text" class="form-control" name="contract_number" placeholder="Search By Contract Number"></div>
          <div class="col-6"><input type="text" class="form-control" name="agreement_number" placeholder="Search By Agreement Number"></div>
          <div class="col-6">
            <select class="form-select" id="filter_status" name="status">
              <option value="all" selected>All Status</option>
              <option>Pending</option><option>Unpaid</option><option>Paid</option>
              <option>Partially Paid</option><option>Overdue</option><option>Cancelled</option>
            </select>
          </div>
          <div class="col-6">
            <select class="form-select" id="filter_invoice_type_main" name="tab">
              <option value="all">All</option><option value="rvo">RVO</option><option value="rvi">RVI</option><option value="inv">INV</option>
            </select>
          </div>
          <div class="col-6"><input type="date" class="form-control" name="from_date"></div>
          <div class="col-6"><input type="date" class="form-control" name="end_date"></div>
          <div class="col-6">
            <select class="form-select" id="filter_invoice_type_sub" name="invoice_type_sub">
              <option value="all" selected>All Sub-Types</option><option>Proforma</option><option>Tax</option><option>Installment</option>
            </select>
          </div>
          <div class="col-6">
            <select class="form-select" id="filter_payment_method" name="payment_method">
              <option disabled selected>Select Payment Method</option>
              <option>Bank Transfer ADIB</option><option>Bank Transfer ADCB</option>
              <option>POS-ID 60043758-ADIB</option><option>POS-ID 60045161-ADCB</option>
              <option>ADIB-19114761</option><option>ADIB-19136783</option>
              <option>Cash</option><option>Cheque</option><option>Replacement</option>
            </select>
          </div>
          <div class="col-6">
            <select class="form-select" id="invoice_order_by" name="sort_by">
              <option value="all">Sort By Approved Date</option>
              <option value="ASC">ASC (Oldest first)</option>
              <option value="DESC">DESC (Newest first)</option>
            </select>
          </div>
          <div class="col-12 text-end">
            <button type="reset" id="btn_reset_filters" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</button>
            <button type="button" id="btn_export" class="btn btn-success"><i class="fas fa-file-export"></i> Export</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="tab-content" id="mainTabsContent">
  <div class="tab-pane fade show active" id="receipt-voucher-outside"><div class="table-responsive" id="invoice_table_rvo"><div class="preloader"><i class="fas fa-spinner fa-spin"></i> Loading...</div></div></div>
  <div class="tab-pane fade" id="receipt-voucher-inside"><div class="table-responsive" id="invoice_table_rvi"><div class="preloader"><i class="fas fa-spinner fa-spin"></i> Loading...</div></div></div>
  <div class="tab-pane fade" id="invoices"><div class="table-responsive" id="invoice_table_inv"><div class="preloader"><i class="fas fa-spinner fa-spin"></i> Loading...</div></div></div>
</div>

</div>
</div>
</section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<div class="modal fade" id="receiptVoucherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white" style="background-color: #fd7e14 !important;">
                <h5 class="modal-title"><i class="fas fa-hand-holding-usd me-2"></i>Create Receipt Voucher</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="receiptVoucherForm">
                <input type="hidden" id="rv_invoice_id" name="invoice_id">
                <input type="hidden" id="rv_customer_id" name="customer_id">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Invoice</label>
                        <input type="text" class="form-control" id="rv_invoice_number" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Mode <span class="text-danger">*</span></label>
                        <select class="form-select" id="rv_method_mode" name="method_mode" required>
                            <option value="1">Cash</option>
                            <option value="2">Credit Card</option>
                            <option value="3">Debit Card</option>
                            <option value="4">Bank Transfer</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Debit Ledger <span class="text-danger">*</span></label>
                        <p class="text-muted small mb-1">Select the account receiving the funds.</p>
                        <select class="form-select" id="rv_debit_ledger_id" name="debit_ledger_id" required></select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="rv_amount" name="amount" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Note <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rv_note" name="note" rows="2" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning text-white" onclick="submitReceiptVoucher()" id="btnSubmitRV">Create Voucher</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="chargingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#17a2b8;color:white;">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Create Charging Entry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="chargingForm">
                <input type="hidden" id="charging_invoice_id" name="invoice_id">
                <input type="hidden" id="charging_customer_id" name="customer_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <textarea class="form-control" id="charging_note" name="note" rows="2" placeholder="Optional note for this charging entry"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Charging Lines</label>
                        <table class="table table-bordered" id="chargingLinesTable">
                            <thead style="background-color:#eef5ff;">
                                <tr>
                                    <th style="width:45%">Ledger Account</th>
                                    <th style="width:20%" class="text-center">Amount</th>
                                    <th style="width:30%">Line Note</th>
                                    <th style="width:5%"></th>
                                </tr>
                            </thead>
                            <tbody id="chargingLinesBody">
                                <!-- Rows added via JS -->
                            </tbody>
                        </table>
                        <div class="text-end">
                            <button type="button" class="btn btn-success btn-sm" onclick="addChargingLine()">
                                <i class="fas fa-plus me-1"></i> Add Line
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitChargingBtn" onclick="submitCharging()">
                        <i class="fas fa-save me-1"></i> Create Charging Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

// Receipt Voucher Functions
function openReceiptVoucherModal(invoiceId, customerId, invoiceNumber) {
    $('#rv_invoice_id').val(invoiceId);
    $('#rv_customer_id').val(customerId);
    $('#rv_invoice_number').val(invoiceNumber);
    $('#rv_amount').val('');
    $('#rv_note').val('Payment received for ' + invoiceNumber);
    
    // Initialize Select2 if not already initialized
    if (!$('#rv_debit_ledger_id').hasClass('select2-hidden-accessible')) {
        initReceiptVoucherSelect2();
    }
    
    var modal = new bootstrap.Modal(document.getElementById('receiptVoucherModal'));
    modal.show();
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

function submitReceiptVoucher() {
    const data = {
        invoice_id: $('#rv_invoice_id').val(),
        customer_id: $('#rv_customer_id').val(),
        debit_ledger_id: $('#rv_debit_ledger_id').val(),
        amount: $('#rv_amount').val(),
        method_mode: $('#rv_method_mode').val(),
        note: $('#rv_note').val()
    };
    
    if (!data.debit_ledger_id) {
        if (typeof toastr !== 'undefined') toastr.error('Please select a Debit Ledger.');
        else alert('Please select a Debit Ledger.');
        return;
    }
    
    if (!data.amount || data.amount <= 0) {
        if (typeof toastr !== 'undefined') toastr.error('Please enter a valid amount.');
        else alert('Please enter a valid amount.');
        return;
    }

    const submitBtn = document.getElementById('btnSubmitRV');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

    $.ajax({
        url: '/api/package-one/received-voucher',
        method: 'POST',
        data: data,
        success: function(response) {
            if (typeof toastr !== 'undefined') toastr.success('Receipt Voucher created successfully!');
            else alert('Receipt Voucher created successfully!');
            
            // Close modal
            const modalEl = document.getElementById('receiptVoucherModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            
            // Reload current tab
            const tab = $('#mainTabs a.active').attr('id').replace('-tab', '');
            loadInvoices(tab, $('#filter_status').val() || 'all');
        },
        error: function(xhr) {
            console.error('API Error:', xhr);
            const msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Failed to create receipt voucher.';
            if (typeof toastr !== 'undefined') toastr.error(msg);
            else alert(msg);
        },
        complete: function() {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });
}

// ============== CHARGING ENTRY FUNCTIONS ==============

// Open Charging Modal
function openChargingModal(invoiceId, customerId) {
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
</script>

<script>
const routes={
  invoicesIndex:"<?php echo e(route('invoices.index')); ?>",
  invoicesExport:"<?php echo e(route('invoices.export')); ?>",
  updateStatus:"<?php echo e(route('invoices.updateStatus', ':id')); ?>",
  deleteInvoice:"<?php echo e(route('invoices.destroy', ':id')); ?>"
};

$(function(){
  $('#filter_invoice_type_main').val('rvo');
  $('#filter_status').val('all');
  loadInvoices('rvo','all');

  $('#mainTabs a').on('click',e=>{
    e.preventDefault();
    $('#mainTabs a').removeClass('active');
    $(e.currentTarget).addClass('active');
    const tab=e.currentTarget.id.replace('-tab','');
    $('#filter_invoice_type_main').val(tab);
    $('#filter_status').val('all');
    $('#global_search').val('');
    $('#clear_global_search').hide();
    $('#global_filter_form')[0].reset();
    loadInvoices(tab,'all');
  });

  $('#global_search').on('keyup',function(){
    $('#clear_global_search').toggle(!!this.value.length);
    const tab=$('#mainTabs a.active').attr('id').replace('-tab','');
    loadInvoices(tab,$('#filter_status').val()||'all');
  });

  $('#clear_global_search').on('click',()=>{
    $('#global_search').val('').focus();
    $('#clear_global_search').hide();
    const tab=$('#mainTabs a.active').attr('id').replace('-tab','');
    loadInvoices(tab,$('#filter_status').val()||'all');
  });

  $('#filter_status,#global_filter_form input,#global_filter_form select').on('change keyup',function(){
    const tab=$('#mainTabs a.active').attr('id').replace('-tab','');
    loadInvoices(tab,$('#filter_status').val()||'all');
  });

  $('#btn_reset_filters').on('click',()=>window.location="<?php echo e(route('invoices.index')); ?>");

  $('#btn_export').on('click',()=>{
    const params=$('#global_filter_form').serialize();
    const g=encodeURIComponent($('#global_search').val());
    const tab=$('#filter_invoice_type_main').val();
    const status=$('#filter_status').val();
    window.location=`${routes.invoicesExport}?${params}&global_search=${g}&tab=${tab}${status!=='all'?`&status=${status}`:''}`;
  });

  $(document).on('click','.pagination a',function(e){
    e.preventDefault();
    const url=$(this).attr('href');
    const tab=$('#mainTabs a.active').attr('id').replace('-tab','');
    const status=$('#filter_status').val()||'all';
    const params=$('#global_filter_form').serialize();
    const g=encodeURIComponent($('#global_search').val());
    $.get(url,`${params}&global_search=${g}&tab=${tab}${status!=='all'?`&status=${status}`:''}`,d=>{
      $(`#invoice_table_${tab}`).html(d.html);
    });
  });
});

function loadInvoices(tab='rvo',status='all'){
  const c=$(`#invoice_table_${tab}`);
  c.find('.preloader').show();
  const params=$('#global_filter_form').serialize();
  const g=encodeURIComponent($('#global_search').val());
  $.get(routes.invoicesIndex,`${params}&global_search=${g}&tab=${tab}${status!=='all'?`&status=${status}`:''}`)
   .done(d=>c.html(d.html))
   .fail(()=>c.html('<div class="no-data">No records found</div>'))
   .always(()=>c.find('.preloader').hide());
}

function confirmStatusChange(el,id,name,amt,agr){
  const sel=el.options[el.selectedIndex].text;
  const lbl=`${name} (${agr}) - Received: ${amt}`;
  Swal.fire({
    title:`Change status for ${lbl}?`,
    text:`Switch to "${sel}"?`,
    icon:'warning',
    showCancelButton:true,
    confirmButtonColor:'#28a745',
    cancelButtonColor:'#dc3545',
    confirmButtonText:'Yes',
    cancelButtonText:'No'
  }).then(r=>{
    if(r.isConfirmed) updateStatus(el,id,agr);
    else el.selectedIndex=el.dataset.prev||0;
  });
  el.dataset.prev=el.selectedIndex;
}

function updateStatus(el,id,agr){
  $.post(routes.updateStatus.replace(':id',id),{
    _token:'<?php echo e(csrf_token()); ?>',
    status_name:el.value,
    invoice_id:id,
    agreementNo:agr
  })
  .done(res=>{
    if(res.success){
      toastr.success(res.message);
      if(res.statusColor) $(el).css('background-color',res.statusColor);
    }else toastr.error(res.message||'Failed.');
  })
  .fail(xhr=>{
    const msg=xhr.responseJSON?.message||'Error.';
    toastr.error(msg);
  });
}

function confirmDelete(ref){
  Swal.fire({
    title:'Are you sure?',
    text:'This will delete the invoice.',
    icon:'warning',
    showCancelButton:true,
    confirmButtonColor:'#dc3545',
    cancelButtonColor:'#6c757d',
    confirmButtonText:'Yes, delete',
    cancelButtonText:'Cancel'
  }).then(r=>{
    if(r.isConfirmed){
      const f=document.getElementById(`delete-form-${ref}`);
      f.action=routes.deleteInvoice.replace(':id',ref);
      f.submit();
    }
  });
}
</script>

<script>
// Void Package One Journal Entry (Moved to Index)
function voidPackageOne(journalId, invoiceNumber) {
    if (!journalId || journalId == 0) {
        alert('Error: Journal ID not linkable. The finance entry may be missing or corrupt.');
        return;
    }

    const confirmMsg = 'Are you sure you want to VOID the journal entry for invoice ' + invoiceNumber + '?\n\nThis will permanently delete the financial record.';
    
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
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/invoices/index.blade.php ENDPATH**/ ?>