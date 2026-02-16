@php
use Carbon\Carbon;

$serverName     = request()->getHost();
$subdomain      = explode('.', $serverName)[0] ?? 'default';
$headerFileName = strtolower($subdomain) . '_header.jpg';
$footerFileName = strtolower($subdomain) . '_footer.jpg';
$headerImgUrl   = asset('assets/img/' . $headerFileName);
$footerImgUrl   = asset('assets/img/' . $footerFileName);

$maxNum = 0;
foreach ($receipts as $rr) {
    if (preg_match('/^PR-(\d+)$/', (string)$rr->receipt_number, $m)) {
        $n = (int)$m[1];
        if ($n > $maxNum) $maxNum = $n;
    }
}
$nextReceiptNo = 'PR-' . str_pad((string)($maxNum + 1), 5, '0', STR_PAD_LEFT);
$todayISO = Carbon::now('Asia/Dubai')->toDateString();

$ids = [];
foreach ($receipts as $r) {
    if ($r->created_by) $ids[] = $r->created_by;
    if ($r->approved_by) $ids[] = $r->approved_by;
    if ($r->cancelled_by) $ids[] = $r->cancelled_by;
}
$ids = array_values(array_unique(array_filter($ids)));
$userMap = $ids ? \App\Models\User::whereIn('id', $ids)->get()->keyBy('id') : collect();

$firstName = function ($id) use ($userMap) {
    if (!$id || !$userMap->has($id)) return '';
    $u = $userMap->get($id);
    if (isset($u->first_name) && $u->first_name) return $u->first_name;
    $name = $u->name ?? '';
    return trim(explode(' ', $name)[0] ?? '');
};
@endphp

@include('role_header')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

<style>
  .dataTables_info{font-size:12px}
  .dataTables_paginate{font-size:12px}
  .modal-lg{max-width:900px}
  a{text-decoration:none}
  #prViewFrame{width:100%;height:78vh;border:0}
  .confirm-icon{width:88px;height:88px;border-radius:50%;border:6px solid #fcd29f;color:#f59e0b;display:flex;align-items:center;justify-content:center;font-size:48px;margin:0 auto 10px}
  .pr-alert{display:none}
  .select2-container .select2-selection--single{height:38px}
  .select2-container--default .select2-selection--single .select2-selection__rendered{line-height:36px}
  .select2-container--default .select2-selection--single .select2-selection__arrow{height:36px}
  .select2-container--open{z-index:1060 !important}
  .select2-dropdown{z-index:1060 !important}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">Payment Receipts</h5>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#prModal">
            <i class="fa-solid fa-receipt me-1"></i> New Receipt
          </button>
        </div>

        <div class="table-responsive">
          <table id="pr-table" class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Receipt No</th>
                <th>Date</th>
                <th>Payer Type</th>
                <th>Payee</th>
                <th>Method</th>
                <th class="text-end">Amount</th>
                <th>Ref</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Approved By</th>
                <th>Cancelled By</th>
                <th>Created</th>
                <th>Updated</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($receipts as $r)
              <tr>
                <td>{{ $r->id }}</td>
                <td>{{ $r->receipt_number }}</td>
                <td>{{ optional($r->receipt_date)->format('Y-m-d') }}</td>
                <td>{{ $r->payer_type === 'customer' ? 'Customer' : 'Walk-in' }}</td>
                <td>{{ $r->payer_display }}</td>
                <td>{{ $r->payment_method }}</td>
                <td class="text-end">{{ number_format((float)$r->amount,2) }}</td>
                <td>{{ $r->reference_no }}</td>
                <td>
                  @if(auth()->user()->role === 'Finance Officer')
                    <select class="form-select form-select-sm status-select"
                            data-id="{{ $r->id }}"
                            data-prev="{{ $r->status }}"
                            data-rno="{{ $r->receipt_number }}">
                      <option value="Pending"   @selected($r->status==='Pending')>Pending</option>
                      <option value="Approved"  @selected($r->status==='Approved')>Approved</option>
                      <option value="Cancelled" @selected($r->status==='Cancelled')>Cancelled</option>
                    </select>
                  @else
                    <span class="badge @if($r->status==='Approved') bg-success @elseif($r->status==='Cancelled') bg-danger @else bg-secondary @endif">{{ $r->status }}</span>
                  @endif
                </td>
                <td>{{ $firstName($r->created_by) }}</td>
                <td>{{ $firstName($r->approved_by) }}</td>
                <td>{{ $firstName($r->cancelled_by) }}</td>
                <td>{{ optional($r->created_at)->format('Y-m-d') }}</td>
                <td>{{ optional($r->updated_at)->format('Y-m-d') }}</td>
                <td class="text-center">
                  <button class="btn btn-secondary btn-sm view-btn"
                          data-bs-toggle="modal" data-bs-target="#prViewModal"
                          data-rno="{{ $r->receipt_number }}"
                          data-date="{{ optional($r->receipt_date)->format('Y-m-d') }}"
                          data-ptype="{{ $r->payer_type }}"
                          data-cid="{{ $r->customer_id }}"
                          data-cname="{{ $r->payer_type==='customer' ? $r->payer_display : '' }}"
                          data-wname="{{ $r->walkin_name }}"
                          data-method="{{ $r->payment_method }}"
                          data-amount="{{ number_format((float)$r->amount,2,'.','') }}"
                          data-ref="{{ $r->reference_no }}"
                          data-notes="{{ $r->notes }}"
                          data-status="{{ $r->status }}"
                          data-attach="{{ $r->attachment_path ? asset('storage/'.$r->attachment_path) : '' }}"
                          data-cancel="{{ $r->cancel_reason }}">
                    <i class="fa-solid fa-eye"></i>
                  </button>

                  @if($r->status === 'Pending')
                  <button class="btn btn-info btn-sm edit-btn"
                          data-bs-toggle="modal" data-bs-target="#prModal"
                          data-id="{{ $r->id }}"
                          data-rno="{{ $r->receipt_number }}"
                          data-date="{{ optional($r->receipt_date)->format('Y-m-d') }}"
                          data-ptype="{{ $r->payer_type }}"
                          data-cid="{{ $r->customer_id }}"
                          data-cname="{{ $r->payer_type==='customer' ? $r->payer_display : '' }}"
                          data-wname="{{ $r->walkin_name }}"
                          data-method="{{ $r->payment_method }}"
                          data-amount="{{ number_format((float)$r->amount,2,'.','') }}"
                          data-ref="{{ $r->reference_no }}"
                          data-notes="{{ $r->notes }}">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  @endif

                  @if(auth()->user()->role === 'Finance Officer' && $r->status === 'Pending')
                  <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $r->id }}"><i class="fa-solid fa-trash"></i></button>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="prModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="prForm" class="w-100" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="_method" id="pr_method" value="POST">
      <input type="hidden" id="pr_id">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title"><i class="fa-solid fa-receipt me-1"></i> <span id="pr_title">New Payment Receipt</span></h6>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Receipt #</label>
              <input type="text" class="form-control" id="receipt_number_display" disabled>
            </div>

            <div class="col-md-4">
              <label class="form-label">Date *</label>
              <input type="text" class="form-control" id="receipt_date_display" autocomplete="off">
              <input type="hidden" id="receipt_date" name="receipt_date">
            </div>

            <div class="col-md-4">
              <label class="form-label">Payment Method *</label>
              <select class="form-select" id="payment_method" name="payment_method" required>
                <option value="" disabled selected>Choose</option>
                <option value="CASH">CASH</option>
                <option value="CHEQUE">CHEQUE</option>
                <option value="BANK TRANSFER">BANK TRANSFER</option>
                <option value="CARD">CARD</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Payer Type *</label>
              <select class="form-select" id="payer_type" name="payer_type" required>
                <option value="" disabled selected>Choose</option>
                <option value="customer">Customer</option>
                <option value="walkin">Walk-in</option>
              </select>
            </div>

            <div class="col-md-8" id="customer_wrap" style="display:none">
              <label class="form-label">Customer *</label>
              <select class="form-select" id="customer_id" name="customer_id"></select>
            </div>

            <div class="col-md-8" id="walkin_wrap" style="display:none">
              <label class="form-label">Walk-in Name *</label>
              <input type="text" class="form-control" id="walkin_name" name="walkin_name" placeholder="Enter name">
            </div>

            <div class="col-md-4">
              <label class="form-label">Amount *</label>
              <input type="text" class="form-control" id="amount" name="amount" inputmode="decimal" placeholder="0.00" required>
            </div>

            <div class="col-md-8">
              <label class="form-label">Reference No</label>
              <input type="text" class="form-control" id="reference_no" name="reference_no">
            </div>

            <div class="col-12">
              <label class="form-label">Notes *</label>
              <input type="text" class="form-control" id="notes" name="notes" required>
            </div>

            <div class="col-12">
              <label class="form-label">Proof Attachment *</label>
              <input type="file" class="form-control" id="attachment" name="attachment" accept=".jpg,.jpeg,.png,.pdf">
            </div>

            <div class="col-12">
              <div id="pr_error" class="pr-alert alert alert-danger py-2 px-3"></div>
              <div id="pr_success" class="pr-alert alert alert-success py-2 px-3"></div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark me-1"></i> Close</button>
          <button type="button" id="btn_save" class="btn btn-success btn-sm"><i class="fa-solid fa-floppy-disk me-1"></i> Save</button>
          <button type="button" id="btn_save_print" class="btn btn-primary btn-sm"><i class="fa-solid fa-print me-1"></i> Save & Print</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="prViewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h6 class="modal-title"><i class="fa-solid fa-eye me-1"></i> View Payment Receipt</h6>
        <div class="d-flex gap-2">
          <button type="button" id="btn_view_print" class="btn btn-primary btn-sm"><i class="fa-solid fa-print me-1"></i> Print</button>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
      </div>
      <div class="modal-body p-0">
        <iframe id="prViewFrame"></iframe>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="statusConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-3">
      <div class="confirm-icon">!</div>
      <h4 id="statusConfirmTitle" class="fw-bold mb-3"></h4>
      <p id="statusConfirmSubtitle" class="mb-3"></p>
      <div class="d-flex gap-2 justify-content-center pb-2">
        <button type="button" class="btn btn-success px-4" id="statusConfirmYes">Yes</button>
        <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

@include('layout.footer')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>

<script>
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

  const storeUrl   = "{{ route('payment-receipts.store') }}";
  const updateUrl  = "{{ route('payment-receipts.update', ':id') }}";
  const destroyUrl = "{{ route('payment-receipts.destroy', ':id') }}";
  const statusUrl  = "{{ route('payment-receipts.status', ':id') }}";
  const custUrl    = "{{ route('payment-receipts.customers.search') }}";

  const headerImg  = @json($headerImgUrl);
  const footerImg  = @json($footerImgUrl);
  const nextNo     = @json($nextReceiptNo);
  const todayISO   = @json($todayISO);

  const MONTHS_SHORT = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

  function toISODateLocal(d){
    const y = d.getFullYear();
    const m = String(d.getMonth()+1).padStart(2,'0');
    const day = String(d.getDate()).padStart(2,'0');
    return `${y}-${m}-${day}`;
  }

  function fmtDMY(iso){
    if(!iso || !/^\d{4}-\d{2}-\d{2}$/.test(iso)) return '';
    const [y, m, d] = iso.split('-');
    const idx = Math.max(0, Math.min(11, parseInt(m,10)-1));
    return `${d.padStart(2,'0')} ${MONTHS_SHORT[idx]} ${y}`;
  }

  function parseDMYToDate(dmy){
    const m = String(dmy||'').trim().match(/^(\d{1,2})\s+([A-Za-z]{3,})\s+(\d{4})$/);
    if(!m) return null;
    const day = parseInt(m[1],10);
    const mon3 = m[2].slice(0,3).toLowerCase();
    const y = parseInt(m[3],10);
    const mi = MONTHS_SHORT.findIndex(x=>x.toLowerCase()===mon3);
    if(mi < 0) return null;
    return new Date(y, mi, day, 12, 0, 0, 0);
  }

  function escapeHtml(s){ return String(s||'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }

  function showMsg(id,msg){ const $el=$(id); $el.text(msg).show(); setTimeout(()=>{$el.fadeOut(250)},2500); }

  function initCustomerSelect2(){
    const $sel = $('#customer_id');
    if ($sel.hasClass('select2-hidden-accessible')) $sel.select2('destroy');
    $sel.select2({
      width: '100%',
      placeholder: 'Search customer...',
      dropdownParent: $('#prModal'),
      allowClear: true,
      minimumInputLength: 1,
      ajax: {
        url: custUrl,
        dataType: 'json',
        delay: 250,
        data: params => ({ q: params.term || '' }),
        processResults: data => data
      }
    });
  }

  function payerUI(){
    const t = $('#payer_type').val();
    if (t === 'customer') {
      $('#customer_wrap').show();
      $('#walkin_wrap').hide();
      $('#walkin_name').val('');
      $('#customer_id').prop('required', true);
      $('#walkin_name').prop('required', false);
    } else if (t === 'walkin') {
      $('#customer_wrap').hide();
      $('#walkin_wrap').show();
      $('#customer_id').val(null).trigger('change');
      $('#walkin_name').prop('required', true);
      $('#customer_id').prop('required', false);
    } else {
      $('#customer_wrap').hide();
      $('#walkin_wrap').hide();
      $('#walkin_name').prop('required', false);
      $('#customer_id').prop('required', false);
    }
  }

  function buildReceiptHtml(p){
    const payer = p.payer_type === 'customer' ? p.customer_name : p.walkin_name;
    const attach = p.attachment_url ? `<a href="${escapeHtml(p.attachment_url)}" target="_blank">${escapeHtml(p.attachment_url.split('/').pop())}</a>` : '';
    const cancel = p.cancel_reason ? `<tr><th style="width:22%">Cancel Reason:</th><td>${escapeHtml(p.cancel_reason)}</td></tr>` : '';

    return `
      <html>
      <head>
        <meta charset="utf-8"><title>Payment Receipt</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
          @page{size:A4;margin:12mm}
          body{font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#111827}
          .grid{width:100%;border-collapse:collapse}
          .grid th,.grid td{border:1px solid #9aa3b2;padding:6px;vertical-align:middle;background:#fff}
          .grid thead th{background:#eef5ff}
          .title{font-weight:700;font-size:18px;margin:10mm 0 6mm;text-align:center}
          .hdr img{width:100%;display:block;margin-bottom:10mm}
          .ftr img{width:100%;display:block;margin-top:10mm}
          .sig-line{height:28px;border-bottom:1px solid #777;text-align:center;padding-top:12px}
          .mt-6mm{margin-top:6mm}
        </style>
      </head>
      <body>
        <div class="hdr"><img src="${headerImg}"></div>
        <div class="container-fluid">
          <div class="title">Payment Receipt</div>

          <table class="grid">
            <tbody>
              <tr>
                <th style="width:22%">Receipt No.:</th>
                <td style="width:28%">${escapeHtml(p.receipt_number)}</td>
                <th style="width:12%">Date:</th>
                <td style="width:38%">${escapeHtml(fmtDMY(p.receipt_date))}</td>
              </tr>
              <tr>
                <th>Payer Type:</th>
                <td>${escapeHtml(p.payer_type === 'customer' ? 'Customer' : 'Walk-in')}</td>
                <th>Payee:</th>
                <td>${escapeHtml(payer)}</td>
              </tr>
              <tr>
                <th>Payment Method:</th>
                <td>${escapeHtml(p.payment_method)}</td>
                <th>Reference No.:</th>
                <td>${escapeHtml(p.reference_no || '')}</td>
              </tr>
              <tr>
                <th>Amount (AED):</th>
                <td>${Number(String(p.amount||'0').replace(/,/g,'')).toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2})}</td>
                <th>Status:</th>
                <td>${escapeHtml(p.status || '')}</td>
              </tr>
              <tr>
                <th>Notes:</th>
                <td colspan="3">${escapeHtml(p.notes || '')}</td>
              </tr>
              ${cancel}
              <tr>
                <th>Attachment:</th>
                <td colspan="3">${attach}</td>
              </tr>
            </tbody>
          </table>

          <table class="w-100 mt-6mm">
            <tr>
              <td class="sig-line" style="width:33%">Prepared By</td>
              <td class="sig-line" style="width:33%">Approved By</td>
              <td class="sig-line" style="width:34%">Received By</td>
            </tr>
          </table>
        </div>
        <div class="ftr"><img src="${footerImg}"></div>
      </body>
      </html>
    `;
  }

  function printHtml(html){
    const w = window.open('', '_blank');
    w.document.open();
    w.document.write(html.replace('</body>', '<script>window.onload=function(){setTimeout(function(){window.print()},120)}<\/script></body>'));
    w.document.close();
  }

  $(function(){
    $('#pr-table').DataTable();

    const fp = flatpickr("#receipt_date_display", {
      dateFormat: "d M Y",
      allowInput: true,
      parseDate: (datestr) => parseDMYToDate(datestr) || new Date(),
      formatDate: (date) => fmtDMY(toISODateLocal(date)),
      onChange: function(selectedDates){
        const d = selectedDates[0];
        document.getElementById('receipt_date').value = d ? toISODateLocal(d) : '';
      },
      onClose: function(){
        const manual = $('#receipt_date_display').val();
        const d = parseDMYToDate(manual);
        if (d) {
          fp.setDate(d, true);
          $('#receipt_date').val(toISODateLocal(d));
        } else {
          $('#receipt_date_display').val('');
          $('#receipt_date').val('');
        }
      }
    });

    $('#payer_type').on('change', payerUI);

    $('#prModal').on('show.bs.modal', function(e){
      initCustomerSelect2();

      const btn = $(e.relatedTarget);
      $('#pr_error').hide().text('');
      $('#pr_success').hide().text('');

      if (btn && btn.hasClass('edit-btn')) {
        $('#pr_title').text('Edit Payment Receipt');
        const id = btn.data('id');

        $('#pr_id').val(id);
        $('#prForm').attr('action', updateUrl.replace(':id', id));
        $('#pr_method').val('PUT');

        const iso = btn.data('date');
        $('#receipt_number_display').val(btn.data('rno'));
        $('#receipt_date').val(iso);
        fp.setDate(iso, true, 'Y-m-d');
        $('#receipt_date_display').val(fmtDMY(iso));

        $('#payer_type').val(btn.data('ptype'));
        payerUI();

        if (btn.data('ptype') === 'customer') {
          const cid = btn.data('cid');
          const cname = btn.data('cname') || ('Customer (ID: ' + cid + ')');
          const opt = new Option(cname, cid, true, true);
          $('#customer_id').append(opt).trigger('change');
          $('#walkin_name').val('');
        } else {
          $('#customer_id').val(null).trigger('change');
          $('#walkin_name').val(btn.data('wname') || '');
        }

        $('#payment_method').val(btn.data('method'));
        $('#amount').val(btn.data('amount'));
        $('#reference_no').val(btn.data('ref'));
        $('#notes').val(btn.data('notes'));
        $('#attachment').val('');
        $('#attachment').prop('required', false);
      } else {
        $('#pr_title').text('New Payment Receipt');
        $('#pr_id').val('');
        $('#prForm').attr('action', storeUrl);
        $('#pr_method').val('POST');

        $('#receipt_number_display').val(nextNo);
        $('#receipt_date').val(todayISO);
        fp.setDate(todayISO, true, 'Y-m-d');
        $('#receipt_date_display').val(fmtDMY(todayISO));

        $('#payer_type').val('');
        $('#payment_method').val('');
        $('#customer_id').val(null).trigger('change');
        $('#walkin_name').val('');
        $('#amount').val('');
        $('#reference_no').val('');
        $('#notes').val('');
        $('#attachment').val('');
        $('#attachment').prop('required', true);
        payerUI();
      }
    });

    function validateForm(){
      const d = $('#receipt_date').val();
      const t = $('#payer_type').val();
      const amt = parseFloat(String($('#amount').val() || '0').replace(/,/g,''));
      const notes = ($('#notes').val() || '').trim();

      if (!d || !/^\d{4}-\d{2}-\d{2}$/.test(d)) { showMsg('#pr_error','Invalid date'); return false; }
      if (!$('#payment_method').val()) { showMsg('#pr_error','Payment method is required'); return false; }
      if (!t) { showMsg('#pr_error','Payer type is required'); return false; }
      if (!(amt > 0)) { showMsg('#pr_error','Amount must be greater than 0'); return false; }
      if (!notes) { showMsg('#pr_error','Notes are required'); return false; }

      if (t === 'customer') {
        if (!$('#customer_id').val()) { showMsg('#pr_error','Customer is required'); return false; }
        if ($('#walkin_name').val().trim() !== '') { showMsg('#pr_error','Walk-in name must be empty for customer'); return false; }
      }

      if (t === 'walkin') {
        if (!$('#walkin_name').val().trim()) { showMsg('#pr_error','Walk-in name is required'); return false; }
        if ($('#customer_id').val()) { showMsg('#pr_error','Customer must be empty for walk-in'); return false; }
      }

      const isCreate = ($('#pr_method').val() || 'POST') === 'POST';
      if (isCreate) {
        const f = $('#attachment')[0]?.files?.length || 0;
        if (!f) { showMsg('#pr_error','Proof attachment is required'); return false; }
      }

      return true;
    }

    function postForm(onSuccess){
      const fd = new FormData(document.getElementById('prForm'));
      $.ajax({
        url: $('#prForm').attr('action'),
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false
      })
      .done(function(res){
        showMsg('#pr_success', res?.message || 'Saved');
        if (typeof onSuccess === 'function') onSuccess(res);
        setTimeout(()=>location.reload(), 700);
      })
      .fail(function(xhr){
        const r = xhr.responseJSON;
        if (r && r.errors) {
          const flat = [];
          Object.values(r.errors).forEach(arr=>{ [].concat(arr).forEach(m=>flat.push(m)); });
          showMsg('#pr_error', flat.join(' | '));
        } else {
          showMsg('#pr_error', r?.message || 'Request failed');
        }
      });
    }

    $('#btn_save').on('click', function(){
      if(!validateForm()) return;
      postForm();
    });

    $('#btn_save_print').on('click', function(){
      if(!validateForm()) return;

      const ptype = $('#payer_type').val();
      const p = {
        receipt_number: $('#receipt_number_display').val(),
        receipt_date: $('#receipt_date').val(),
        payer_type: ptype,
        customer_name: ptype==='customer' ? ($('#customer_id option:selected').text() || '') : '',
        walkin_name: ptype==='walkin' ? $('#walkin_name').val() : '',
        payment_method: $('#payment_method').val(),
        amount: $('#amount').val(),
        reference_no: $('#reference_no').val(),
        notes: $('#notes').val(),
        status: 'Pending',
        attachment_url: ''
      };

      postForm(function(){ printHtml(buildReceiptHtml(p)); });
    });

    $(document).on('click','.delete-btn',function(){
      if(!confirm('Delete this receipt?')) return;
      const id = $(this).data('id');
      $.ajax({
        url: destroyUrl.replace(':id', id),
        method: 'POST',
        data: { _method: 'DELETE' }
      })
      .done(()=>location.reload())
      .fail(xhr=>showMsg('#pr_error', xhr.responseJSON?.message || 'Could not delete'));
    });

    $(document).on('click','.view-btn',function(){
      const btn = $(this);
      const p = {
        receipt_number: btn.data('rno'),
        receipt_date: btn.data('date'),
        payer_type: btn.data('ptype'),
        customer_name: btn.data('cname') || '',
        walkin_name: btn.data('wname') || '',
        payment_method: btn.data('method'),
        amount: btn.data('amount'),
        reference_no: btn.data('ref'),
        notes: btn.data('notes'),
        status: btn.data('status'),
        attachment_url: btn.data('attach'),
        cancel_reason: btn.data('cancel')
      };
      document.getElementById('prViewFrame').srcdoc = buildReceiptHtml(p);
    });

    $('#btn_view_print').on('click', function(){
      const iframe = document.getElementById('prViewFrame');
      if (iframe && iframe.contentWindow) iframe.contentWindow.print();
    });

    let pendingStatus = null;
    let confirmed = false;

    $(document).on('focusin', '.status-select', function(){
      $(this).data('prev', this.value);
    });

    $(document).on('change','.status-select',function(){
      const $sel = $(this);
      pendingStatus = {
        $sel,
        id: $sel.data('id'),
        rno: $sel.data('rno'),
        prev: $sel.data('prev'),
        toStatus: $sel.val()
      };
      confirmed = false;

      $('#statusConfirmTitle').text('Change status: ' + (pendingStatus.rno || ''));
      $('#statusConfirmSubtitle').text('Switch to "' + pendingStatus.toStatus + '"?');

      new bootstrap.Modal(document.getElementById('statusConfirmModal')).show();
    });

    document.getElementById('statusConfirmModal').addEventListener('hidden.bs.modal', function () {
      if(pendingStatus && !confirmed){
        pendingStatus.$sel.val(pendingStatus.prev);
      }
      pendingStatus = null;
    });

    $('#statusConfirmYes').on('click', function(){
      const btn = $(this);
      btn.disabled = true;

      const modalEl = document.getElementById('statusConfirmModal');
      const modal = bootstrap.Modal.getInstance(modalEl);

      if(!pendingStatus){ btn.disabled=false; modal.hide(); return; }

      const payload = { status: pendingStatus.toStatus };
      if (pendingStatus.toStatus === 'Cancelled') {
        payload.cancel_reason = prompt('Cancel reason (optional):') || '';
      }

      $.post(statusUrl.replace(':id', pendingStatus.id), payload)
        .done(()=>{ confirmed = true; location.reload(); })
        .fail(xhr=>{ showMsg('#pr_error', xhr.responseJSON?.message || 'Status update failed'); confirmed = false; })
        .always(()=>{ btn.disabled=false; modal.hide(); });
    });
  });
</script>
