@php
use Carbon\Carbon;
use Illuminate\Support\Str;

$serverName     = request()->getHost();
$subdomain      = explode('.', $serverName)[0] ?? 'default';
$headerFileName = strtolower($subdomain) . '_header.jpg';
$footerFileName = strtolower($subdomain) . '_footer.jpg';
$headerImgUrl   = asset('assets/img/' . $headerFileName);
$footerImgUrl   = asset('assets/img/' . $footerFileName);

$firstName = function ($user) {
    if (!$user) return '';
    $name = $user->name ?? '';
    return trim(explode(' ', $name)[0] ?? '');
};
@endphp

@include('role_header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
  .dataTables_info{font-size:12px}
  .dataTables_paginate{font-size:12px}
  .modal-lg{max-width:1000px}
  .grid{width:100%;border-collapse:collapse}
  .grid th,.grid td{border:1px solid #9aa3b2;padding:6px;vertical-align:middle;background:#fff}
  .grid thead th{background:#eef5ff}
  .amount{text-align:right}
  .line-input{width:100%;border:0;background:transparent;outline:none}
  .row-actions{white-space:nowrap;text-align:center}
  .btn-mini{display:inline-flex;align-items:center;justify-content:center;padding:4px 8px;border:0;color:#fff;font-size:11px;line-height:1}
  .btn-plus{background:linear-gradient(to right,#22c55e,#4ade80)}
  .btn-minus{background:linear-gradient(to right,#ef4444,#fb7185)}
  .is-alert{display:none}
  a{text-decoration:none}
  .confirm-icon{width:88px;height:88px;border-radius:50%;border:6px solid #fcd29f;color:#f59e0b;display:flex;align-items:center;justify-content:center;font-size:48px;margin:0 auto 10px}
  @media print {.no-print{display:none!important}}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">Invoice Services</h5>
          <button class="btn btn-primary btn-sm" id="btn-new" data-bs-toggle="modal" data-bs-target="#isModal">
            <i class="fa-solid fa-plus me-1"></i> New Service
          </button>
        </div>

        <div class="table-responsive">
          <table id="is-table" class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Code</th>
                <th>Type</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($invoiceServices as $is)
              @php
                  $linesData = $is->lines->map(function($l){
                      return [
                          'id' => $l->id,
                          'ledger_account_id' => $l->ledger_account_id,
                          'ledger_text' => $l->ledger->name ?? '',
                          'amount_debit' => $l->amount_debit,
                          'amount_credit' => $l->amount_credit,
                          'vatable' => $l->vatable,
                          'note' => $l->note,
                          'source_amount' => $l->source_amount
                      ];
                  });
                  $typeLabel = match($is->type) {
                      1 => 'Government',
                      2 => 'Package One',
                      3 => 'On Fly',
                      default => 'Unknown'
                  };
              @endphp
              <tr>
                <td>{{ $is->id }}</td>
                <td>{{ $is->name }}</td>
                <td>{{ $is->code }}</td>
                <td>{{ $typeLabel }}</td>
                <td>
                  @if($is->status)
                    <span class="badge bg-success">Active</span>
                  @else
                    <span class="badge bg-secondary">Inactive</span>
                  @endif
                </td>
                <td>{{ $firstName($is->creator) }}</td>
                <td>{{ $is->created_at->format('Y-m-d') }}</td>
                <td class="text-center">
                  <button class="btn btn-info btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#isModal"
                          data-id="{{ $is->id }}"
                          data-name="{{ $is->name }}"
                          data-code="{{ $is->code }}"
                          data-note="{{ $is->note }}"
                          data-status="{{ $is->status }}"
                          data-type="{{ $is->type }}"
                          data-lines='@json($linesData)'>
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="mt-3">
          {{ $invoiceServices->links('pagination::bootstrap-5') }}
        </div>

      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="isModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="isForm" class="w-100">
      <input type="hidden" name="_method" id="is_method" value="POST">
      <input type="hidden" name="id" id="is_id">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title"><i class="fa-solid fa-list me-1"></i> <span id="is_title">New Invoice Service</span></h6>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Service Name *</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Service Code *</label>
              <input type="text" class="form-control" id="code" name="code" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Type *</label>
              <select class="form-select" id="type" name="type" required>
                <option value="1">Government Invoice</option>
                <option value="2">Package One</option>
                <option value="3">Invoice on Fly</option>
              </select>
            </div>
            <div class="col-md-6" id="div_status">
                <label class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="col-12">
              <label class="form-label">Note</label>
              <textarea class="form-control" id="note" name="note" rows="2"></textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Service Lines</label>
                <table class="grid" id="linesTable">
                  <thead>
                    <tr>
                      <th style="width:35%">Ledger Account</th>
                      <th class="text-center" style="width:10%">Debit</th>
                      <th class="text-center" style="width:10%">Credit</th>
                      <th style="width:40%">Line Note</th>
                      <th class="text-center" style="width:5%"></th>
                    </tr>
                  </thead>
                  <tbody id="linesBody">
                    <!-- Rows injected via JS -->
                  </tbody>
                </table>
                <div class="mt-2 text-end">
                    <button type="button" class="btn btn-success btn-sm addRow"><i class="fa-solid fa-plus me-1"></i> Add Line</button>
                </div>
            </div>

            <div class="col-12">
              <div id="is_error" class="is-alert alert alert-danger py-2 px-3"></div>
              <div id="is_success" class="is-alert alert alert-success py-2 px-3"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer no-print">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="btn_save" class="btn btn-success btn-sm"><i class="fa-solid fa-floppy-disk me-1"></i> Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

@include('layout.footer')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

  const apiBaseUrl = '/api/invoice-services';

  function showMsg(id,msg){ const $el=$(id); $el.text(msg).show(); setTimeout(()=>{$el.fadeOut(250)},2500); }

  // Initialize Select2
  function initSelect2($select, initialId='', initialText='') {
    $select.select2({
      ajax: {
        url: '/api/ledgers/lookup',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            search: params.term || '',
            page: params.page || 1,
            per_page: 20
          };
        },
        processResults: function (data) {
          return {
            results: data.results,
            pagination: { more: data.pagination.more }
          };
        },
        cache: true
      },
      minimumInputLength: 0, 
      placeholder: 'Search Ledger...',
      allowClear: true,
      width: '100%',
      dropdownParent: $('#isModal')
    });
    
    if(initialId && initialText) {
       const option = new Option(initialText, initialId, true, true);
       $select.append(option).trigger('change');
    }
  }

  function makeRow(data = {}){
    const id = data.ledger_account_id || '';
    const text = data.ledger_text || '';
    const debit = data.amount_debit || '';
    const credit = data.amount_credit || '';
    const note = data.note || '';
    const lineId = data.id || '';

    const $row = $(`
      <tr data-line-id="${lineId}">
        <td><select class="line-input coa-select form-select" required></select></td>
        <td><input type="number" step="0.01" class="line-input form-control debit-input" placeholder="0.00" value="${debit}"></td>
        <td><input type="number" step="0.01" class="line-input form-control credit-input" placeholder="0.00" value="${credit}"></td>
        <td><input type="text" class="line-input form-control note-input" placeholder="Note" value="${note}"></td>
        <td class="row-actions">
          <button type="button" class="btn-mini btn-minus delRow"><i class="fa-solid fa-minus"></i></button>
        </td>
      </tr>
    `);
    
    const $sel = $row.find('.coa-select');
    initSelect2($sel, id, text);
    return $row;
  }

  function addRow(data={}) {
      $('#linesBody').append(makeRow(data));
  }

  $(function(){
    $('#is-table').DataTable({ paging: false, info: false, searching: false, ordering: false });

    // New Button
    $('#btn-new').click(function(){
        $('#isForm')[0].reset();
        $('#is_method').val('POST');
        $('#is_id').val('');
        $('#is_title').text('New Invoice Service');
        
        // Hide Status on Create, default to Active
        $('#div_status').hide();
        $('#status').val('1'); 

        $('#linesBody').empty();
        addRow(); // Add one empty row
    });

    // Edit Button
    $('.edit-btn').click(function(){
        const btn = $(this);
        $('#is_title').text('Edit Invoice Service');
        $('#is_method').val('PUT');
        $('#is_id').val(btn.data('id'));
        
        // Show Status on Edit
        $('#div_status').show();

        $('#name').val(btn.data('name'));
        $('#code').val(btn.data('code'));
        $('#type').val(btn.data('type'));
        $('#status').val(btn.data('status') ? '1' : '0');
        $('#note').val(btn.data('note'));

        const lines = btn.data('lines');
        $('#linesBody').empty();
        if(lines && lines.length > 0) {
            lines.forEach(line => addRow(line));
        } else {
            addRow();
        }
    });

    // Add Row Button
    $('.addRow').click(function(){ addRow(); });

    // Delete Row Button
    $('#linesBody').on('click','.delRow',function(){
        $(this).closest('tr').remove();
    });

    // Form Submit
    $('#isForm').submit(function(e){
        e.preventDefault();
        
        const method = $('#is_method').val();
        let url = apiBaseUrl;
        if(method === 'PUT') {
            url += '/' + $('#is_id').val();
        }

        const lines = [];
        $('#linesBody tr').each(function(){
            const $tr = $(this);
            const ledgerId = $tr.find('.coa-select').val();
            if(ledgerId) {
                lines.push({
                    id: $tr.data('line-id') || null,
                    ledger_account_id: ledgerId,
                    amount_debit: $tr.find('.debit-input').val(),
                    amount_credit: $tr.find('.credit-input').val(),
                    vatable: false, // Default
                    source_amount: 1, // Default (Amount)
                    note: $tr.find('.note-input').val()
                });
            }
        });

        const data = {
            name: $('#name').val(),
            code: $('#code').val(),
            type: $('#type').val(),
            status: $('#status').val() == '1',
            note: $('#note').val(),
            lines: lines
        };

        $.ajax({
            url: url,
            method: method,
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(res) {
                showMsg('#is_success', 'Saved Successfully!');
                setTimeout(() => location.reload(), 1000);
            },
            error: function(err) {
                let msg = 'Error saving data.';
                if(err.responseJSON && err.responseJSON.message) {
                    msg = err.responseJSON.message;
                }
                showMsg('#is_error', msg);
                console.error(err);
            }
        });
    });

    // Re-init Select2 (if needed/hidden)
    $('#isModal').on('shown.bs.modal', function () {
        // Adjust widths if necessary
    });

  });
</script>
