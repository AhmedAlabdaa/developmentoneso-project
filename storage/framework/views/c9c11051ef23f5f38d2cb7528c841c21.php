<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  .dataTables_info{font-size:12px}
  .dataTables_paginate{font-size:12px}
  .modal-lg{max-width:900px}
  .is-alert{display:none}
  .badge-status{padding:4px 10px;border-radius:4px;font-size:11px;text-transform:uppercase}
  .badge-draft{background:#ffc107;color:#000}
  .badge-posted{background:#28a745;color:#fff}
  .table thead th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">Receipt Vouchers</h5>
          <button class="btn btn-primary btn-sm" id="btn-new" data-bs-toggle="modal" data-bs-target="#rvModal">
            <i class="fa-solid fa-plus me-1"></i> New Receipt Voucher
          </button>
        </div>

        <div class="table-responsive">
          <table id="rv-table" class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Serial Number</th>
                <th>Invoice Number</th>
                <th>Source Type</th>
                <th>Amount</th>
                <th>Payment Mode</th>
                <th>Status</th>
                <th>Created At</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="rv-tbody">
              <!-- Loaded via AJAX -->
            </tbody>
          </table>
        </div>
        <div id="paginationContainer" class="mt-3 d-flex justify-content-center"></div>
      </div>
    </div>
  </section>
</main>

<!-- Receipt Voucher Modal -->
<div class="modal fade" id="rvModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="rvForm" class="w-100">
      <input type="hidden" id="rv_id" name="id">
      <input type="hidden" id="rv_method" value="POST">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title"><i class="fa-solid fa-hand-holding-usd me-1"></i> <span id="rv_title">New Receipt Voucher</span></h6>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <!-- Source fields - only visible in EDIT mode as read-only -->
            <div class="col-md-4 source-field-edit" style="display:none;">
              <label class="form-label">Source Type</label>
              <input type="text" class="form-control" id="source_type_display" readonly>
              <input type="hidden" id="source_type" name="source_type">
            </div>
            <div class="col-md-4 source-field-edit" style="display:none;">
              <label class="form-label">Source Invoice</label>
              <input type="text" class="form-control" id="source_id_display" readonly>
              <input type="hidden" id="source_id" name="source_id">
            </div>

            <!-- Payment Mode for EDIT mode - same row as source fields -->
            <div class="col-md-4 source-field-edit" style="display:none;">
              <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
              <select class="form-select" id="payment_mode_edit" name="payment_mode_edit">
                <option value="1">Cash</option>
                <option value="2">Credit Card</option>
                <option value="3">Debit Card</option>
                <option value="4">Bank Transfer</option>
              </select>
            </div>

            <!-- Payment Mode for CREATE mode - full width -->
            <div class="col-12 source-field-create">
              <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
              <select class="form-select" id="payment_mode" name="payment_mode" required>
                <option value="1">Cash</option>
                <option value="2">Credit Card</option>
                <option value="3">Debit Card</option>
                <option value="4">Bank Transfer</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Credit Ledger <span class="text-danger">*</span></label>
              <select class="form-select" id="credit_ledger_id" name="credit_ledger_id" required></select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Debit Ledger <span class="text-danger">*</span></label>
              <select class="form-select" id="debit_ledger_id" name="debit_ledger_id" required></select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Amount <span class="text-danger">*</span></label>
              <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Status <span class="text-danger">*</span></label>
              <select class="form-select" id="status" name="status" required>
                <option value="draft">Draft</option>
                <option value="posted">Posted</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Attachments (URLs, comma separated)</label>
              <input type="text" class="form-control" id="attachments" name="attachments" placeholder="url1, url2">
            </div>
            <div class="col-12">
              <div id="rv_error" class="is-alert alert alert-danger py-2 px-3"></div>
              <div id="rv_success" class="is-alert alert alert-success py-2 px-3"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="btn_save" class="btn btn-success btn-sm"><i class="fa-solid fa-floppy-disk me-1"></i> Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

const apiBaseUrl = '/api/receipt-vouchers';
let currentPage = 1;

function showMsg(id, msg) {
  const $el = $(id);
  $el.text(msg).show();
  setTimeout(() => $el.fadeOut(250), 2500);
}

function initSelect2Ledger($select, placeholder = 'Search Ledger...', spacial = null) {
  $select.select2({
    ajax: {
      url: '/api/ledgers/lookup',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        const query = { search: params.term || '', page: params.page || 1, per_page: 20 };
        if (spacial !== null) {
          query.spacial = spacial;
        }
        return query;
      },
      processResults: function(data) {
        return { results: data.results, pagination: { more: data.pagination.more } };
      },
      cache: true
    },
    minimumInputLength: 0,
    placeholder: placeholder,
    allowClear: true,
    width: '100%',
    dropdownParent: $('#rvModal')
  });
}

function initSelect2Invoice($select) {
  $select.select2({
    ajax: {
      url: '/invoices/search',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return { q: params.term || '' };
      },
      processResults: function(data) {
        return {
          results: data.map(i => ({ id: i.invoice_id, text: i.invoice_number + ' - ' + (i.customer_name || 'N/A') }))
        };
      },
      cache: true
    },
    minimumInputLength: 0,
    placeholder: 'Search Invoice...',
    allowClear: true,
    width: '100%',
    dropdownParent: $('#rvModal')
  });
}

function initSelect2Candidate($select) {
  $select.select2({
    ajax: {
      url: '/api/candidates/lookup',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return { search: params.term || '', page: params.page || 1, per_page: 20 };
      },
      processResults: function(data) {
        return {
          results: (data.results || data.data || []).map(c => ({ id: c.id, text: c.candidate_name || c.text })),
          pagination: { more: data.pagination?.more || false }
        };
      },
      cache: true
    },
    minimumInputLength: 0,
    placeholder: 'Search Candidate...',
    allowClear: true,
    width: '100%',
    dropdownParent: $('#rvModal')
  });
}

function loadTable(page = 1) {
  currentPage = page;
  $('#rv-tbody').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
  $.get(apiBaseUrl + '?page=' + page)
    .done(function(res) {
      const data = res.data || [];
      if (!data.length) {
        $('#rv-tbody').html('<tr><td colspan="9" class="text-center text-muted">No records found</td></tr>');
        $('#paginationContainer').empty();
        return;
      }
      let html = '';
      data.forEach(function(rv) {
        const invoiceNumber = rv.source?.invoice_number || 'N/A';
        const sourceType = rv.source_type ? rv.source_type.split('\\').pop() : 'N/A';
        const statusClass = rv.status === 'posted' ? 'badge-posted' : 'badge-draft';
        const createdAt = rv.created_at ? new Date(rv.created_at).toLocaleDateString() : 'N/A';
        html += `<tr>
          <td>${rv.id}</td>
          <td>${rv.serial_number || 'N/A'}</td>
          <td>${invoiceNumber}</td>
          <td>${sourceType}</td>
          <td>${parseFloat(rv.amount || 0).toFixed(2)}</td>
          <td>${rv.payment_mode_label || rv.payment_mode}</td>
          <td><span class="badge-status ${statusClass}">${rv.status}</span></td>
          <td>${createdAt}</td>
          <td class="text-center">
            <button type="button" class="btn btn-primary btn-sm btn-edit" data-id="${rv.id}" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
          </td>
        </tr>`;
      });
      $('#rv-tbody').html(html);
      renderPagination(res.meta, res.links);
    })
    .fail(function() {
      $('#rv-tbody').html('<tr><td colspan="9" class="text-center text-danger">Failed to load data</td></tr>');
    });
}

function renderPagination(meta, links) {
  if (!meta || meta.last_page <= 1) {
    $('#paginationContainer').empty();
    return;
  }
  let html = '<nav><ul class="pagination pagination-sm mb-0">';
  html += `<li class="page-item ${meta.current_page === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${meta.current_page - 1}">&laquo;</a></li>`;
  for (let i = 1; i <= meta.last_page; i++) {
    html += `<li class="page-item ${meta.current_page === i ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
  }
  html += `<li class="page-item ${meta.current_page === meta.last_page ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${meta.current_page + 1}">&raquo;</a></li>`;
  html += '</ul></nav>';
  $('#paginationContainer').html(html);
}

$(document).on('click', '#paginationContainer .page-link', function(e) {
  e.preventDefault();
  const page = $(this).data('page');
  if (page && page >= 1) loadTable(page);
});

function resetForm() {
  $('#rvForm')[0].reset();
  $('#rv_id').val('');
  $('#rv_method').val('POST');
  $('#rv_title').text('New Receipt Voucher');
  // Hide edit mode fields, show create mode fields
  $('.source-field-edit').hide();
  $('.source-field-create').show();
  $('#source_type').val('');
  $('#source_id').val('');
  $('#source_type_display').val('');
  $('#source_id_display').val('');

  $('#credit_ledger_id').val(null).trigger('change');
  $('#debit_ledger_id').val(null).trigger('change');
  $('.is-alert').hide();
}

$('#btn-new').on('click', function() {
  resetForm();
});

$(document).on('click', '.btn-edit', function() {
  const id = $(this).data('id');
  resetForm();
  $.get(apiBaseUrl + '/' + id)
    .done(function(res) {
      const rv = res.data || res;
      $('#rv_id').val(rv.id);
      $('#rv_method').val('PUT');
      $('#rv_title').text('Edit Receipt Voucher #' + rv.serial_number);
      
      // Show edit mode fields, hide create mode fields
      $('.source-field-edit').show();
      $('.source-field-create').hide();
      const sourceTypeDisplay = rv.source_type ? rv.source_type.split('\\').pop() : 'N/A';
      $('#source_type_display').val(sourceTypeDisplay);
      $('#source_type').val(rv.source_type || '');
      if (rv.source && rv.source.invoice_number) {
        $('#source_id_display').val(rv.source.invoice_number);
      } else {
        $('#source_id_display').val('Invoice #' + (rv.source_id || 'N/A'));
      }
      $('#source_id').val(rv.source_id || '');
      
      // Set payment mode on both fields (edit uses payment_mode_edit)
      $('#payment_mode').val(rv.payment_mode);
      $('#payment_mode_edit').val(rv.payment_mode);
      $('#amount').val(rv.amount);
      $('#status').val(rv.status);
      if (rv.attachments && Array.isArray(rv.attachments)) {
        $('#attachments').val(rv.attachments.join(', '));
      }

      // Set ledgers from journal lines
      if (rv.journal && rv.journal.lines && rv.journal.lines.length) {
        rv.journal.lines.forEach(function(line) {
          if (parseFloat(line.debit) > 0 && line.ledger) {
            // This is the debit ledger
            const optDL = new Option(line.ledger.name || 'Ledger #' + line.ledger_id, line.ledger_id, true, true);
            $('#debit_ledger_id').append(optDL).trigger('change');
          }
          if (parseFloat(line.credit) > 0 && line.ledger) {
            // This is the credit ledger
            const optCL = new Option(line.ledger.name || 'Ledger #' + line.ledger_id, line.ledger_id, true, true);
            $('#credit_ledger_id').append(optCL).trigger('change');
          }
        });
      }
      $('#rvModal').modal('show');
    })
    .fail(function(xhr) {
      alert('Failed to load receipt voucher: ' + (xhr.responseJSON?.message || 'Unknown error'));
    });
});

$('#rvForm').on('submit', function(e) {
  e.preventDefault();
  const id = $('#rv_id').val();
  const method = $('#rv_method').val();
  const url = id ? apiBaseUrl + '/' + id : apiBaseUrl;
  
  const attachmentsVal = $('#attachments').val();
  const attachmentsArr = attachmentsVal ? attachmentsVal.split(',').map(s => s.trim()).filter(s => s) : [];
  
  const payload = {
    source_type: id ? ($('#source_type').val() || null) : null,
    source_id: id ? ($('#source_id').val() || null) : null,

    credit_ledger_id: $('#credit_ledger_id').val(),
    debit_ledger_id: $('#debit_ledger_id').val(),
    payment_mode: id ? $('#payment_mode_edit').val() : $('#payment_mode').val(),
    amount: parseFloat($('#amount').val()) || 0,
    status: $('#status').val(),
    attachments: attachmentsArr.length ? attachmentsArr : null
  };

  $.ajax({
    url: url,
    method: method,
    contentType: 'application/json',
    data: JSON.stringify(payload)
  })
  .done(function(res) {
    showMsg('#rv_success', method === 'POST' ? 'Receipt Voucher created successfully!' : 'Receipt Voucher updated successfully!');
    setTimeout(function() {
      // Properly close modal and remove backdrop
      var modalEl = document.getElementById('rvModal');
      var modal = bootstrap.Modal.getInstance(modalEl);
      if (modal) {
        modal.hide();
      }
      // Ensure backdrop is removed
      $('.modal-backdrop').remove();
      $('body').removeClass('modal-open').css('overflow', '');
      loadTable(currentPage);
    }, 1000);
  })
  .fail(function(xhr) {
    const errors = xhr.responseJSON?.errors || {};
    const msg = xhr.responseJSON?.message || 'Failed to save';
    let errText = msg;
    if (Object.keys(errors).length) {
      errText = Object.values(errors).flat().join(', ');
    }
    showMsg('#rv_error', errText);
  });
});

$(document).ready(function() {

  initSelect2Ledger($('#credit_ledger_id'), 'Search Credit Ledger...');
  initSelect2Ledger($('#debit_ledger_id'), 'Search Debit Ledger...', 2);
  loadTable();
});
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/receipt_vouchers/index.blade.php ENDPATH**/ ?>