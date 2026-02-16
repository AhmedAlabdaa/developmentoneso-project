<style>
.table-container{width:100%;overflow-x:auto;position:relative}
.table{width:100%;border-collapse:collapse}
.table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.table th{background-color:#343a40;color:#fff;text-transform:uppercase;font-weight:800;font-size:12px}
.table-hover tbody tr:hover{background-color:#f1f1f1}
.table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}
.badge{padding:4px 10px;border-radius:999px;font-size:11px;display:inline-block}
.badge-pending{background-color:#6c757d;color:#fff}
.badge-paid{background-color:#28a745;color:#fff}
.badge-replaced{background-color:#007bff;color:#fff}
.badge-cancelled{background-color:#dc3545;color:#fff}
.muted-text{color:#6c757d;font-size:11px;display:block}
.pagination-container{display:flex;justify-content:space-between;align-items:center;margin-top:10px}
.action-btn{border:none;background:transparent;cursor:pointer;padding:4px 8px}
.action-btn i{font-size:16px}
.text-right{text-align:right}
.text-center{text-align:center}
.salary-modal-header,.salary-modal-footer{background:linear-gradient(90deg,#5b2cff,#00c6ff,#00f5a0);color:#fff;border:none}
.salary-modal-footer .btn{font-size:12px}
.salary-modal-close-wrapper{width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;margin-left:8px}
.salary-modal-close-wrapper .close{opacity:1;font-size:18px;line-height:1}
.salary-modal-close-wrapper .close span{display:block;margin-top:-2px}
.receipt-box{border:1px solid #e9ecef;border-radius:12px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,.06)}
.receipt-head{padding:12px 14px;background:#343a40;color:#fff;display:flex;align-items:flex-start;justify-content:space-between;gap:12px}
.receipt-title{font-weight:900;letter-spacing:.5px;font-size:13px}
.receipt-sub{font-size:11px;opacity:.75}
.receipt-pill{background:rgba(255,255,255,.14);padding:6px 10px;border-radius:999px;font-size:11px;font-weight:900}
.receipt-body{padding:14px}
.receipt-row{display:flex;gap:12px;flex-wrap:wrap}
.receipt-col{flex:1;min-width:220px}
.receipt-label{font-size:11px;color:#6c757d;margin-bottom:4px}
.receipt-value{font-size:13px;font-weight:900}
.receipt-readonly{background:#f8f9fa;border:1px solid #e9ecef}
.balance-grid{display:flex;gap:12px;flex-wrap:wrap;margin-top:10px}
.balance-card{flex:1;min-width:240px;border:1px solid #e9ecef;border-radius:10px;padding:10px 12px;background:#fff}
.balance-title{font-size:11px;color:#6c757d;margin-bottom:6px}
.balance-amt{font-size:14px;font-weight:900}
.balance-amt small{font-weight:900;color:#6c757d}
.flash-wrap{position:fixed;top:14px;right:14px;z-index:9999;max-width:360px;width:calc(100% - 28px)}
@media print{.no-print{display:none!important}}
</style>

<div class="flash-wrap">
  <div id="salaryFlash" class="alert d-none" style="border-radius:12px;box-shadow:0 10px 26px rgba(0,0,0,.12);font-size:12px;"></div>
</div>

<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Candidate</th>
        <th>Passport No</th>
        <th>Nationality</th>
        <th>Client</th>
        <th>Decision</th>
        <th class="text-center">No. of Salaries</th>
        <th class="text-center">Worked Days</th>
        <th class="text-right">Paid Amount</th>
        <th class="text-right">Balance</th>
        <th>Salary To</th>
        <th>Status</th>
        <th>Created At</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>

    <tbody>
      @forelse($salaries as $s)
        @php
          $candidateId      = (int)($s->candidate_id ?? 0);
          $candidate        = strtoupper($s->candidate_name ?? '-');
          $passport         = strtoupper($s->passport_no ?? '-');
          $nationality      = strtoupper($s->nationality ?? '-');
          $clientName       = strtoupper($s->client_name ?? '-');
          $decision         = strtoupper($s->decision ?? 'REFUND');
          $workedDays       = (int)($s->worked_days ?? 0);
          $salaryType       = strtoupper($s->worker_salary_type ?? '-');
          $numberOfSalaries = (int)($s->number_of_salaries ?? 1);

          $paidAmountRaw    = (float)($s->total_paid ?? 0);
          $balanceRaw       = (float)($s->salary_deduction_amount ?? $s->balance ?? 0);

          $paidAmount       = number_format($paidAmountRaw, 2);
          $balance          = number_format($balanceRaw, 2);

          $statusRaw        = strtolower($s->status ?? (($balanceRaw <= 0 && $paidAmountRaw > 0) ? 'paid' : 'pending'));
          $statusLabel      = strtoupper($statusRaw);
          $statusClass      = match ($statusRaw) {
              'paid'      => 'badge-paid',
              'replaced'  => 'badge-replaced',
              'cancelled' => 'badge-cancelled',
              default     => 'badge-pending',
          };

          $createdSource    = $s->created_at ?? null;
          $created          = $createdSource ? \Carbon\Carbon::parse($createdSource)->timezone('Asia/Qatar')->format('d M Y h:i A') : '-';
        @endphp

        <tr id="row-cand-{{ $candidateId }}" data-candidate-id="{{ $candidateId }}">
          <td>{{ $candidate }}</td>
          <td>{{ $passport }}</td>
          <td>{{ $nationality }}</td>
          <td>{{ $clientName }}</td>
          <td>{{ $decision }}</td>
          <td class="text-center">{{ $numberOfSalaries }}</td>
          <td class="text-center">{{ $workedDays }}</td>
          <td class="text-right js-paid" data-paid="{{ $paidAmountRaw }}">{{ $paidAmount }}</td>
          <td class="text-right js-balance" data-balance="{{ $balanceRaw }}">{{ $balance }}</td>
          <td>{{ $salaryType }}</td>
          <td><span class="badge js-status {{ $statusClass }}">{{ $statusLabel }}</span></td>
          <td>{{ $created }}</td>

          <td class="text-center">
            <button type="button" class="action-btn btn-view-salary-slip" data-candidate-id="{{ $candidateId }}" data-url="{{ route('salaries.slip', $candidateId) }}" title="View salary slip">
              <i class="fa fa-eye"></i>
            </button>

            <button type="button" class="action-btn btn-add-salary" title="Add salary payment" data-candidate-id="{{ $candidateId }}" data-pay-url="{{ route('salaries.pay', $candidateId) }}" data-slip-url="{{ route('salaries.slip', $candidateId) }}" data-candidate="{{ $candidate }}" data-passport="{{ $passport }}" data-nationality="{{ $nationality }}" data-client="{{ $clientName }}" data-salaryto="{{ $salaryType }}" data-balance="{{ $balanceRaw }}">
              <i class="fa fa-plus-circle"></i>
            </button>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="13" class="text-center">No results found.</td>
        </tr>
      @endforelse
    </tbody>

    <tfoot>
      <tr>
        <th>Candidate</th>
        <th>Passport No</th>
        <th>Nationality</th>
        <th>Client</th>
        <th>Decision</th>
        <th class="text-center">No. of Salaries</th>
        <th class="text-center">Worked Days</th>
        <th class="text-right">Paid Amount</th>
        <th class="text-right">Balance</th>
        <th>Salary To</th>
        <th>Status</th>
        <th>Created At</th>
        <th class="text-center">Action</th>
      </tr>
    </tfoot>
  </table>
</div>

<nav aria-label="Page navigation">
  <div class="pagination-container">
    <span class="muted-text">Showing {{ $salaries->firstItem() }} to {{ $salaries->lastItem() }} of {{ $salaries->total() }} results</span>
    <ul class="pagination justify-content-center">
      {{ $salaries->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
    </ul>
  </div>
</nav>

<div class="modal fade" id="salarySlipModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header salary-modal-header">
        <h5 class="modal-title mb-0">Salary Slip</h5>
        <div class="salary-modal-close-wrapper">
          <button type="button" class="close text-white btn-salary-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body" style="overflow:visible;"></div>
      <div class="modal-footer salary-modal-footer">
        <button type="button" class="btn btn-outline-light btn-sm btn-salary-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addSalaryModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header salary-modal-header">
        <h5 class="modal-title mb-0">Payment Receipt</h5>
        <div class="salary-modal-close-wrapper">
          <button type="button" class="close text-white btn-add-salary-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>

      <form id="addSalaryForm">
        <div class="modal-body">
          <div class="receipt-box">
            <div class="receipt-head">
              <div>
                <div class="receipt-title">SALARY PAYMENT RECEIPT</div>
                <div class="receipt-sub">Asia/Qatar</div>
              </div>
              <div class="receipt-pill" id="pillPending">Pending: 0.00</div>
            </div>

            <div class="receipt-body">
              <div class="receipt-row mb-3">
                <div class="receipt-col">
                  <div class="receipt-label">Candidate</div>
                  <div class="receipt-value" id="rCandidate">-</div>
                </div>
                <div class="receipt-col">
                  <div class="receipt-label">Passport No</div>
                  <div class="receipt-value" id="rPassport">-</div>
                </div>
              </div>

              <div class="receipt-row mb-3">
                <div class="receipt-col">
                  <div class="receipt-label">Nationality</div>
                  <div class="receipt-value" id="rNationality">-</div>
                </div>
                <div class="receipt-col">
                  <div class="receipt-label">Client</div>
                  <div class="receipt-value" id="rClient">-</div>
                </div>
              </div>

              <div class="receipt-row mb-3">
                <div class="receipt-col">
                  <div class="receipt-label">Salary To</div>
                  <div class="receipt-value" id="rSalaryTo">-</div>
                </div>
                <div class="receipt-col">
                  <div class="receipt-label">Date</div>
                  <input type="date" class="form-control form-control-sm" name="payment_date" id="paymentDate" required>
                </div>
              </div>

              <div class="balance-grid mb-3">
                <div class="balance-card">
                  <div class="balance-title">Pending Balance</div>
                  <div class="balance-amt"><span id="pendingBalText">0.00</span> <small>QAR</small></div>
                  <input type="text" id="pendingBalInput" class="form-control form-control-sm receipt-readonly mt-2" readonly>
                </div>
                <div class="balance-card">
                  <div class="balance-title">New Pending Balance</div>
                  <div class="balance-amt"><span id="newBalText">0.00</span> <small>QAR</small></div>
                  <input type="text" id="newBalInput" class="form-control form-control-sm receipt-readonly mt-2" readonly>
                </div>
              </div>

              <div class="receipt-row mb-3">
                <div class="receipt-col">
                  <div class="receipt-label">Particular</div>
                  <input type="text" class="form-control form-control-sm" name="reference_no" placeholder="Enter Particular" required>
                </div>
                <div class="receipt-col">
                  <div class="receipt-label">Payment Method</div>
                  <select class="form-control form-control-sm" name="payment_method" required>
                    <option value="">Select method</option>
                    <option value="cash">Cash</option>
                    <option value="MOI">MOI</option>
                    <option value="Ticket">Ticket</option>
                  </select>
                </div>
              </div>

              <div class="receipt-row mb-3">
                <div class="receipt-col">
                  <div class="receipt-label">Received Amount</div>
                  <input type="number" class="form-control form-control-sm" name="received_amount" id="receivedAmount" step="0.01" min="0.01" placeholder="0.00" required>
                </div>
                <div class="receipt-col">
                  <div class="receipt-label">Note</div>
                  <input type="text" class="form-control form-control-sm" name="note" placeholder="Optional note">
                </div>
              </div>

              <div class="alert alert-danger d-none" id="addSalaryErr" style="font-size:12px;"></div>
            </div>
          </div>
        </div>

        <div class="modal-footer salary-modal-footer">
          <button type="submit" class="btn btn-light btn-sm" id="btnSaveSalary">Save</button>
          <button type="button" class="btn btn-outline-light btn-sm btn-add-salary-close" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
(function () {
  function qatarDateISO() {
    return new Intl.DateTimeFormat('en-CA', { timeZone: 'Asia/Qatar', year: 'numeric', month: '2-digit', day: '2-digit' }).format(new Date());
  }

  function n(v) {
    var x = parseFloat(v);
    return isFinite(x) ? x : 0;
  }

  function money(v) {
    return n(v).toFixed(2);
  }

  function flash(type, text) {
    var box = $('#salaryFlash');
    box.removeClass('d-none alert-success alert-danger alert-info');
    box.addClass(type === 'success' ? 'alert-success' : (type === 'error' ? 'alert-danger' : 'alert-info'));
    box.text(text);
    setTimeout(function () { box.addClass('d-none'); }, 2600);
  }

  function storeLast(modal, candidateId) {
    localStorage.setItem('salary_last_modal', modal || '');
    localStorage.setItem('salary_last_candidate', candidateId != null ? String(candidateId) : '');
  }

  function clearLast() {
    localStorage.removeItem('salary_last_modal');
    localStorage.removeItem('salary_last_candidate');
  }

  function setCandidate(btn) {
    $('#rCandidate').text(btn.data('candidate') || '-');
    $('#rPassport').text(btn.data('passport') || '-');
    $('#rNationality').text(btn.data('nationality') || '-');
    $('#rClient').text(btn.data('client') || '-');
    $('#rSalaryTo').text(btn.data('salaryto') || '-');
  }

  function setBalances(pending, amt) {
    var p = Math.max(0, n(pending));
    var a = Math.max(0, n(amt));
    var newBal = Math.max(0, p - a);

    $('#pendingBalText').text(money(p));
    $('#newBalText').text(money(newBal));
    $('#pendingBalInput').val(money(p));
    $('#newBalInput').val(money(newBal));
    $('#pillPending').text('Pending: ' + money(p));
  }

  function updateRow(candidateId, totals) {
    if (!totals) return;
    var row = $('#row-cand-' + candidateId);
    if (!row.length) return;

    var paid = n(totals.total_paid);
    var bal = n((totals.salary_deduction_amount != null) ? totals.salary_deduction_amount : totals.balance);

    row.find('.js-paid').attr('data-paid', paid).text(money(paid));
    row.find('.js-balance').attr('data-balance', bal).text(money(bal));

    var status = (bal <= 0 && paid > 0) ? 'PAID' : 'PENDING';
    var badge = row.find('.js-status');
    badge.text(status);
    badge.removeClass('badge-paid badge-pending').addClass(status === 'PAID' ? 'badge-paid' : 'badge-pending');

    var addBtn = row.find('.btn-add-salary');
    addBtn.data('balance', bal);
    addBtn.attr('data-balance', bal);
  }

  function refreshSlipIfOpen(candidateId, slipUrl) {
    if (!slipUrl) return;
    if (!$('#salarySlipModal').hasClass('show')) return;

    var openFor = $('#salarySlipModal').data('candidate-id');
    if (String(openFor || '') !== String(candidateId || '')) return;

    $.get(slipUrl, function (res) {
      if (res && res.html) $('#salarySlipModal .modal-body').html(res.html);
      if (res && res.totals) updateRow(candidateId, res.totals);
    });
  }

  function openPrintWindowFromTemplate(tpl){
    if(!tpl) return;
    var html = tpl.innerHTML || '';
    if(!html) return;
    var w = window.open('', '_blank', 'width=1100,height=900');
    if(!w) return;
    w.document.open();
    w.document.write('<html><head><title>Salary Slip</title></head><body>');
    w.document.write(html);
    w.document.write('</body></html>');
    w.document.close();
    w.focus();
    w.print();
    w.close();
  }

  $(document).on('click', '.btn-print-ledger', function () {
    var pid = $(this).data('payment-id');
    if(!pid) return;
    var tpl = document.getElementById('ledger-print-' + pid);
    if(!tpl) return;
    openPrintWindowFromTemplate(tpl);
  });

  $(document).on('click', '.btn-view-salary-slip', function () {
    var btn = $(this);
    var url = btn.data('url');
    var candidateId = btn.data('candidate-id');
    if (!url) return;

    storeLast('slip', candidateId);

    $.get(url, function (res) {
      $('#salarySlipModal .modal-body').html((res && res.html) ? res.html : '');
      $('#salarySlipModal').data('candidate-id', candidateId);
      $('#salarySlipModal').modal('show');
      if (res && res.totals) updateRow(candidateId, res.totals);
    }).fail(function () {
      flash('error', 'Unable to load salary slip.');
    });
  });

  $(document).on('click', '.btn-salary-close', function () {
    $('#salarySlipModal').modal('hide');
  });

  $('#salarySlipModal').on('hidden.bs.modal', function () {
    clearLast();
    $('#salarySlipModal').removeData('candidate-id');
  });

  $(document).on('click', '.btn-add-salary', function () {
    var btn = $(this);
    var payUrl = btn.data('pay-url');
    var slipUrl = btn.data('slip-url');
    var candidateId = btn.data('candidate-id');
    var pending = n(btn.data('balance'));
    if (!payUrl) return;

    storeLast('add', candidateId);

    $('#addSalaryForm')[0].reset();
    $('#addSalaryErr').addClass('d-none').text('');
    $('#btnSaveSalary').prop('disabled', false);

    $('#addSalaryForm').data('pay-url', payUrl);
    $('#addSalaryForm').data('slip-url', slipUrl);
    $('#addSalaryForm').data('candidate-id', candidateId);
    $('#addSalaryForm').data('pending', pending);

    setCandidate(btn);
    $('#paymentDate').val(qatarDateISO());
    $('#receivedAmount').val('');
    setBalances(pending, 0);

    $('#addSalaryModal').modal('show');
  });

  $(document).on('click', '.btn-add-salary-close', function () {
    $('#addSalaryModal').modal('hide');
  });

  $('#addSalaryModal').on('hidden.bs.modal', function () {
    clearLast();
  });

  $(document).on('input', '#receivedAmount', function () {
    var pending = n($('#addSalaryForm').data('pending'));
    setBalances(pending, n($(this).val()));
  });

  $('#addSalaryForm').on('submit', function (e) {
    e.preventDefault();

    var form = $(this);
    var url = form.data('pay-url');
    var slipUrl = form.data('slip-url');
    var candidateId = form.data('candidate-id');
    if (!url) return;

    $('#addSalaryErr').addClass('d-none').text('');
    $('#btnSaveSalary').prop('disabled', true);

    $.ajax({
      url: url,
      method: 'POST',
      data: form.serialize(),
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      success: function (resp) {
        $('#btnSaveSalary').prop('disabled', false);

        if (resp && resp.ok) {
          flash('success', resp.message || 'Payment saved successfully.');
          if (resp.totals) {
            updateRow(candidateId, resp.totals);
            form.data('pending', n((resp.totals.salary_deduction_amount != null) ? resp.totals.salary_deduction_amount : resp.totals.balance));
          }
          $('#addSalaryModal').modal('hide');
          refreshSlipIfOpen(candidateId, slipUrl);
          return;
        }

        $('#addSalaryErr').removeClass('d-none').text((resp && resp.message) ? resp.message : 'Something went wrong.');
      },
      error: function (xhr) {
        $('#btnSaveSalary').prop('disabled', false);

        var msg = 'Something went wrong.';
        if (xhr && xhr.responseJSON) {
          if (xhr.responseJSON.message) msg = xhr.responseJSON.message;
          if (xhr.responseJSON.errors) {
            var k = Object.keys(xhr.responseJSON.errors)[0];
            if (k && xhr.responseJSON.errors[k] && xhr.responseJSON.errors[k][0]) msg = xhr.responseJSON.errors[k][0];
          }
        }
        $('#addSalaryErr').removeClass('d-none').text(msg);
      }
    });
  });

  $(function () {
    var m = localStorage.getItem('salary_last_modal') || '';
    var c = localStorage.getItem('salary_last_candidate') || '';
    if (!c) return;

    if (m === 'slip') {
      var b1 = $('.btn-view-salary-slip[data-candidate-id="' + c + '"]').first();
      if (b1.length) b1.trigger('click');
    }

    if (m === 'add') {
      var b2 = $('.btn-add-salary[data-candidate-id="' + c + '"]').first();
      if (b2.length) b2.trigger('click');
    }
  });
})();
</script>
