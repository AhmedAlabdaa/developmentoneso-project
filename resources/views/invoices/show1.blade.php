@php
    $serverName     = $_SERVER['SERVER_NAME'];
    $subdomain      = explode('.', $serverName)[0];
    $headerFileName = strtolower($subdomain) . '_header.jpg';
    $footerFileName = strtolower($subdomain) . '_footer.jpg';
    $logoFileName   = strtolower($subdomain) . '_logo.png';
    $formattedDate  = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d M Y') : 'N/A';
    $total          = $invoice->total_amount;
    $net            = $total / 1.05;
    $vat            = $total - $net;
    $received       = $receivedAmount;
    $balance        = $balanceDue;
    $paymentMethods = [
        'Bank Transfer ADIB',
        'Bank Transfer ADCB',
        'POS-ID 60043758',
        'POS-ID 60045161',
        'ADIB-19114761',
        'ADIB-19136783',
        'Cash',
        'Cheque',
        'Replacement',
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $invoice->invoice_type }} Invoice - {{ $invoice->invoice_number }}</title>
  <link rel="icon" href="{{ asset('assets/img/' . $logoFileName) }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/' . $logoFileName) }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <style>
    @page { size: A4; margin: 10mm; }
    body { font-family: Arial, sans-serif; background:#f4f4f4; color:#333; font-size:12px; padding:10px; display:flex; justify-content:center; }
    .btn-sm { font-size:12px; }
    .top-buttons { display:flex; justify-content:center; gap:10px; margin-bottom:15px; }
    .container { width:100%; max-width:800px; background:#fff; padding:20px; box-shadow:0 0 15px rgba(0,0,0,0.1); border-radius:10px; }
    .tax-invoice { text-align:center; font-size:18px; font-weight:bold; margin:15px 0; }
    table { width:100%; border-collapse:collapse; margin-bottom:15px; }
    .outer-table, .service-table, .totals-table { border:1px solid #ddd; }
    .outer-table td, .inner-table td { padding:8px; vertical-align:top; }
    .inner-table th { background:#f1f1f1; padding:8px; text-align:left; width:40%; }
    .service-table th, .service-table td { border:1px solid #ddd; padding:8px; text-align:center; }
    .service-table th { background:#f1f1f1; }
    .totals-table td { border:1px solid #ddd; padding:8px; text-align:right; }
    .totals-table td:first-child { text-align:left; }
    .note-container { display:flex; justify-content:space-between; font-size:12px; }
    .note-container .english { width:48%; font-style:italic; }
    .note-container .arabic { width:48%; direction:rtl; text-align:right; }
    .comments-section p { padding:8px; border:1px solid #ddd; min-height:60px; }
    .signature-container p { font-size:12px; margin:4px 0; }

    .custom-modal .modal-content { border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.3); font-size:12px; }
    .custom-modal .modal-header { background:linear-gradient(135deg,#007bff,#6a11cb); color:#fff; padding:15px; border-radius:12px 12px 0 0; }
    .custom-modal .modal-header h5 { margin:0; font-size:12px; font-weight:bold; }
    .custom-modal .modal-header .btn-close { font-size:1.2rem; }
    .custom-modal .modal-header .btn-close:hover { transform:scale(1.1); }
    .custom-modal .modal-body { background:#f9f9f9; padding:20px; color:#333; }
    .custom-modal .modal-body-scroll { max-height:400px; overflow-y:auto; padding-right:10px; }
    .custom-modal .modal-footer { background:#f1f1f1; padding:15px; border-radius:0 0 12px 12px; }
    .custom-modal .modal-footer .btn { font-size:12px; padding:8px 15px; border-radius:5px; transition:.3s; }
    .custom-modal .modal-footer .btn-primary { background:linear-gradient(to right,#007bff,#00c6ff); color:#fff; border:none; }
    .custom-modal .modal-footer .btn-secondary { background:#6c757d; color:#fff; border:none; }
  </style>
</head>
<body>
  <div class="container">
    <div class="top-buttons">
      <a href="{{ route('invoices.download',$invoice->invoice_number) }}" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-download"></i> Download
      </a>
      <button class="btn btn-sm btn-outline-success" onclick="shareInvoice('{{ $invoice->invoice_number }}')">
        <i class="fas fa-share-alt"></i> Share
      </button>
      <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
      </a>
      <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editInvoiceModal">
        <i class="fas fa-edit"></i> Edit
      </button>
    </div>

    <img src="{{ asset('assets/img/' . $headerFileName) }}" class="img-fluid mb-3">

    <div class="tax-invoice">{{ $invoice->invoice_type }} Invoice</div>

    <table class="outer-table">
      <tr>
        <td>
          <table class="inner-table w-100">
            <tr><th>Receipt No.</th><td>{{ $invoice->invoice_number }}</td></tr>
            <tr><th>Date</th><td>{{ $formattedDate($invoice->invoice_date) }}</td></tr>
            <tr><th>Customer</th><td>{{ $invoice->customer->first_name }} {{ $invoice->customer->last_name }}</td></tr>
            <tr><th>EID No.</th><td>{{ $invoice->customer->emirates_id }}</td></tr>
            <tr><th>Nationality</th><td>{{ $invoice->customer->nationality }}</td></tr>
            <tr><th>Contact No.</th><td>{{ $invoice->customer->mobile }}</td></tr>
            <tr><th>Payment Method</th><td>{{ $invoice->payment_method }}</td></tr>
            <tr><th>Sales Staff</th><td>{{ $invoice->creator->first_name ?? ''}} {{ $invoice->creator->last_name ?? ''}}</td></tr>
          </table>
        </td>
        <td>
          <table class="inner-table w-100">
            <tr><th>Contract Ref.</th>
                <td>
                  @if($invoice->agreement->status==5)
                    {{ optional($invoice->contract)->reference_no }}
                  @else
                    {{ $invoice->agreement->reference_no }}
                  @endif
                </td></tr>
            <tr><th>Contract Type</th>
                <td>
                  @if($invoice->agreement->status==5) CT-{{ $invoice->CN_Number }}
                  @else {{ $invoice->agreement->agreement_type }}
                  @endif
                </td></tr>
            <tr><th>Candidate</th><td>{{ $invoice->agreement->candidate_name }}</td></tr>
            <tr><th>Passport No.</th><td>{{ $invoice->agreement->passport_no }}</td></tr>
            <tr><th>Nationality</th>
                <td>
                  @switch($invoice->agreement->nationality)
                    @case(1) Ethiopia @break
                    @case(2) Uganda @break
                    @case(3) Philippines @break
                    @case(4) Indonesia @break
                    @case(5) Sri Lanka @break
                    @case(6) Myanmar @break
                    @default {{ $invoice->agreement->nationality }}
                  @endswitch
                </td></tr>
            <tr><th>Contract Date</th><td>{{ $formattedDate($invoice->agreement->created_at) }}</td></tr>
            <tr><th>From</th><td>{{ $formattedDate($invoice->agreement->agreement_start_date) }}</td></tr>
            <tr><th>To</th><td>{{ $formattedDate($invoice->agreement->agreement_end_date) }}</td></tr>
            <tr><th>Status</th><td>{{ ucfirst($invoice->status) }}</td></tr>
          </table>
        </td>
      </tr>
    </table>

    <p class="text-center fw-bold mb-2">Particulars تفاصيل</p>
    <table class="service-table">
      <thead><tr><th>Sl. No</th><th>Particular</th><th>Qty</th><th>Rate</th><th>Total</th></tr></thead>
      <tbody>
        @foreach($invoiceItems as $i=>$item)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $item->product_name }}</td>
          <td>{{ $item->quantity }}</td>
          <td>{{ number_format($item->unit_price,2) }}</td>
          <td>{{ number_format($item->quantity*$item->unit_price,2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <table class="totals-table">
      <tr><td>Subtotal</td><td>{{ number_format($net,2) }}</td></tr>
      <tr><td>VAT (5%)</td><td>{{ number_format($vat,2) }}</td></tr>
      <tr><td>Total</td><td>{{ number_format($total,2) }}</td></tr>
      <tr><td>Received</td><td>{{ number_format($received,2) }}</td></tr>
      <tr><td>Balance</td><td>{{ number_format($balance,2) }}</td></tr>
    </table>

    <div class="note-container mb-3">
      <div class="english">Please verify before leaving.</div>
      <div class="arabic">يرجى التحقق قبل المغادرة.</div>
    </div>

    <div class="comments-section mb-3">
      <h3>Comments</h3>
      <p>{{ $invoice->notes ?? 'N/A' }}</p>
    </div>

    {{-- Receipt Vouchers Section --}}
    @if(isset($receiptVouchers) && $receiptVouchers->count() > 0)
    <div class="mb-3">
      <h3 style="font-size:14px;font-weight:bold;margin-bottom:10px;"><i class="fas fa-receipt"></i> Receipt Vouchers</h3>
      @foreach($receiptVouchers as $rv)
      <div style="border:1px solid #ddd;padding:10px;margin-bottom:10px;border-radius:5px;">
        <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
          <span><strong>{{ $rv->serial_number }}</strong></span>
          <span class="badge {{ $rv->status == 'posted' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($rv->status ?? 'Pending') }}</span>
        </div>
        @if($rv->journal && $rv->journal->lines->count() > 0)
        <table class="table table-sm table-bordered" style="font-size:11px;margin-bottom:0;">
          <thead style="background:#f1f1f1;">
            <tr>
              <th>Ledger</th>
              <th class="text-end">Debit</th>
              <th>Note</th>
            </tr>
          </thead>
          <tbody>
            @foreach($rv->journal->lines as $line)
            @if($line->debit > 0)
            <tr>
              <td>{{ $line->ledger->name ?? 'N/A' }}</td>
              <td class="text-end">{{ number_format($line->debit, 2) }}</td>
              <td>{{ $line->notes ?? '' }}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
        @else
        <p style="color:#999;font-style:italic;margin:0;">No journal lines</p>
        @endif
      </div>
      @endforeach
    </div>
    @endif

    <div class="text-center mb-3">
      <img src="{{ asset('assets/img/' . $footerFileName) }}" class="img-fluid">
    </div>
  </div>

  <div class="modal fade custom-modal" id="editInvoiceModal" tabindex="-1" aria-labelledby="editInvoiceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editInvoiceLabel"><i class="fas fa-edit me-2"></i>Edit Invoice</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body modal-body-scroll">
          <form id="edit_invoice_form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="invoice_number" value="{{ $invoice->invoice_number }}">
            <input type="hidden" name="invoice_id"     value="{{ $invoice->invoice_id }}">
            <div class="mb-3">
              <label><i class="fas fa-calculator"></i> Total Amount</label>
              <input type="number" name="total_amount" class="form-control form-control-sm" value="{{ number_format($total,2,'.','') }}" step="0.01" required>
            </div>
            <div class="mb-3">
              <label><i class="fas fa-money-bill-wave"></i> Received Amount</label>
              <input type="number" name="received_amount" class="form-control form-control-sm" value="{{ number_format($received,2,'.','') }}" step="0.01" required>
            </div>
            <div class="mb-3">
              <label><i class="fas fa-credit-card"></i> Payment Method</label>
              <select name="payment_method" class="form-select form-select-sm" required>
                @foreach($paymentMethods as $method)
                  <option value="{{ $method }}" @if($invoice->payment_method==$method) selected @endif>{{ $method }}</option>
                @endforeach
              </select>
            </div>
            @if($invoice->payment_proof)
            <div class="text-center mb-3">
              <img src="{{ Storage::url($invoice->payment_proof) }}" class="img-thumbnail" alt="Proof">
            </div>
            <div class="text-center mb-3">
              <a href="{{ Storage::url($invoice->payment_proof) }}" download class="btn btn-sm btn-outline-info">
                <i class="fas fa-download"></i> Download Proof
              </a>
            </div>
            @endif
            <div class="mb-3">
              <label><i class="fas fa-file-upload"></i> New Payment Proof</label>
              <input type="file" name="payment_proof" class="form-control form-control-sm" accept=".jpg,.jpeg,.png,.pdf">
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" form="edit_invoice_form" class="btn btn-sm btn-primary"><i class="fas fa-sync-alt"></i> Update</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    function shareInvoice(n) {
      const u = `${window.location.origin}/invoices/share/${n}`;
      if (navigator.share) navigator.share({ title:`Invoice ${n}`, url:u });
      else alert('Sharing not supported.');
    }

    $('#edit_invoice_form').submit(function(e){
      e.preventDefault();
      const fd = new FormData(this);
      $.ajax({
        url: `{{ url('invoices/update-invoice') }}`,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false
      }).done(res => {
        if (res.success) {
          toastr.success(res.message);
          setTimeout(() => location.reload(), 2000);
          bootstrap.Modal.getInstance('#editInvoiceModal').hide();
        } else {
          toastr.error(res.message || 'Update failed');
        }
      }).fail(xhr => {
        toastr.error(xhr.responseJSON?.message || 'Server error');
      });
    });
  </script>
</body>
</html>
