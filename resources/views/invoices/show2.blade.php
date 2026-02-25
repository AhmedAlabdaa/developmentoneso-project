@php
    $host        = request()->getHost();
    $subdomain   = explode('.', $host)[0];
    $headerImage = asset('assets/img/'.strtolower($subdomain).'_header.jpg');
    $footerImage = asset('assets/img/'.strtolower($subdomain).'_footer.jpg');
    $logoImage   = asset('assets/img/'.strtolower($subdomain).'_logo.png');
    $fmtDate     = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d M Y') : 'N/A';
    $paymentMethodsList = [
        'Bank Transfer ADIB',
        'Bank Transfer ADCB',
        'POS-ID 60043758-ADIB',
        'POS-ID 60045161-ADCB',
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
    <title>Installment Receipt – {{ $invoice->invoice_number }}</title>
    <link rel="icon" href="{{ $logoImage }}">
    <link rel="apple-touch-icon" href="{{ $logoImage }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @page{size:A4;margin:10mm}
        *{box-sizing:border-box}
        body{font-family:Arial,sans-serif;font-size:12px;margin:0;padding:10px;background:#f4f4f4;display:flex;justify-content:center}
        .container{width:100%;max-width:800px;background:#fff;padding:20px;border-radius:10px;box-shadow:0 0 15px rgba(0,0,0,.1)}
        .top-buttons {
            display: flex; justify-content: center;
            gap: 15px; margin-bottom: 15px;
        }
        .top-buttons a,
        .top-buttons button,
        .top-buttons select {
            background: #fff; border: 1px solid #ddd;
            border-radius: 5px;
            padding: 8px 16px; font-size: 14px;
            color: #333; text-decoration: none;
            display: flex; align-items: center;
            gap: 6px; cursor: pointer;
            transition: background .3s;
        }
        .top-buttons select {
            appearance: none;
        }
        .top-buttons a:hover,
        .top-buttons button:hover,
        .top-buttons select:hover {
            background: #f1f1f1;
        }
        .header img,.footer img{width:100%}
        .title{margin:12px 0;font-size:18px;font-weight:700;text-align:center}
        table{width:100%;border-collapse:collapse}
        th,td{padding:8px;border:1px solid #ddd;text-align:left}
        th{background:#f1f1f1}
        .service-table th,.service-table td{text-align:center}
        .totals-table td{text-align:right}
        .note{display:flex;justify-content:space-between;margin-top:10px;font-size:12px}
        .note .ar{text-align:right;direction:rtl;width:48%}.note .en{width:48%}
        .comments textarea{width:100%;height:90px;padding:8px;border:1px solid #ddd}
        .signature{margin-top:10px;font-size:12px}
    </style>
</head>
<body>
    <div class="container">
        <div class="top-buttons">
            <a href="{{ route('invoices.download',$invoice->invoice_number) }}"><i class="fas fa-download"></i>Download</a>
            <button onclick="shareInvoice('{{ $invoice->invoice_number }}')"><i class="fas fa-share-alt"></i>Share</button>
            <a href="{{ route('invoices.index') }}"><i class="fas fa-arrow-left"></i>Back</a>
        </div>
        <div class="top-buttons">
          <a href="{{ route('invoices.download', $invoice->invoice_number) }}">
            <i class="fas fa-download"></i> Download
          </a>
          <button onclick="shareInvoice('{{ $invoice->invoice_number }}')">
            <i class="fas fa-share-alt"></i> Share
          </button>
          <a href="{{ route('invoices.index') }}">
            <i class="fas fa-arrow-left"></i> Back to Invoices
          </a>
          <select id="payment_method_select">
            <option disabled selected>Change Payment Method</option>
            @foreach($paymentMethodsList as $method)
                <option value="{{ $method }}">{{ $method }}</option>
            @endforeach
          </select>
        </div>
        <div class="header"><img src="{{ $headerImage }}"></div>
        <div class="title">Installment Receipt / الإيصال ({{ $invoice->invoice_number }})</div>
        <table style="border:none">
            <tr>
                <td style="width:50%">
                    <table>
                        <tr><th>Receipt No.</th><td>{{ $invoice->invoice_number }}</td></tr>
                        <tr><th>Receipt Date</th><td>{{ $fmtDate($invoice->invoice_date) }}</td></tr>
                        <tr><th>Customer</th><td>{{ optional($invoice->customer)->first_name }} {{ optional($invoice->customer)->last_name }}</td></tr>
                        <tr><th>EID No</th><td>{{ optional($invoice->customer)->emirates_id }}</td></tr>
                        <tr><th>Nationality</th><td>{{ optional($invoice->customer)->nationality }}</td></tr>
                        <tr><th>Contact No</th><td>{{ optional($invoice->customer)->mobile }}</td></tr>
                        <tr><th>Payment Method</th><td>{{ $invoice->payment_method }}</td></tr>
                        <tr><th>Payment Status</th><td>{{ $invoice->status }}</td></tr>
                        <tr><th>Sales Staff</th><td>{{ optional($invoice->creator)->first_name }} {{ optional($invoice->creator)->last_name }}</td></tr>
                    </table>
                </td>
                <td style="width:50%">
                    <table>
                        <tr>
                            <th>Contract Reference</th>
                            <td>
                                @if($invoice->agreement->status == 5)
                                  {{ optional($invoice->contract)->reference_no ?? '-' }}
                                @else
                                  {{ $invoice->agreement->reference_no }}
                                @endif
                            </td>
                        </tr>
                        <tr><th>Contract Type</th><td>
                            @if($invoice->agreement->status == 5) CT @else {{ $invoice->agreement->agreement_type }} @endif
                        </td></tr>
                        <tr><th>Maid Name</th><td>{{ optional($invoice->agreement)->candidate_name }}</td></tr>
                        <tr><th>Passport No</th><td>{{ optional($invoice->agreement)->passport_no }}</td></tr>
                        <tr>
                            <th>Nationality</th>
                            <td>
                                @php
                                  $nat = $invoice->agreement->nationality;
                                @endphp

                                @if (is_numeric($nat))
                                    @if ($nat == 1)
                                        Ethiopia
                                    @elseif ($nat == 2)
                                        Uganda
                                    @elseif ($nat == 3)
                                        Philippines
                                    @elseif ($nat == 4)
                                        Indonesia
                                    @elseif ($nat == 5)
                                        Sri Lanka
                                    @elseif ($nat == 6)
                                        Myanmar
                                    @else
                                        Ethiopia
                                    @endif
                                @else
                                    {{ $nat ?: 'Ethiopia' }}
                                @endif

                            </td>
                        </tr>
                        <tr><th>Contract Date</th><td>{{ $fmtDate(optional($invoice->agreement)->created_at) }}</td></tr>
                        <tr><th>Contract From</th><td>{{ $fmtDate(optional($invoice->agreement)->agreement_start_date) }}</td></tr>
                        <tr><th>Contract To</th><td>{{ $fmtDate(optional($invoice->agreement)->agreement_end_date) }}</td></tr>
                        <tr><th>Payment Status</th><td>{{ $invoice->status }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <p style="text-align:center;font-weight:700;margin:15px 0 5px">Particulars / تفاصيل</p>

        <table class="service-table">
            <thead>
                <tr>
                    <th>Sl.</th><th>Service</th><th>Qty</th><th>Unit Price</th><th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($invoiceItems as $i=>$it)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $it->product_name }}</td>
                    <td>{{ $it->quantity }}</td>
                    <td>{{ number_format($it->unit_price,2) }}</td>
                    <td>{{ number_format($it->unit_price*$it->quantity,2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <table class="totals-table" style="margin-top:10px">
            <tr><td style="font-weight:700">Subtotal</td><td>{{ number_format($invoice->total_amount,2) }}</td></tr>
            <tr><td style="font-weight:700">Amount Received</td><td>{{ number_format($invoice->received_amount,2) }}</td></tr>
            <tr><td style="font-weight:700">Balance Due</td><td>{{ number_format($invoice->balance_due,2) }}</td></tr>
        </table>

        <div class="note">
            <div class="en">Kindly check the receipt and documents before leaving the counter.</div>
            <div class="ar">تأكد من الإيصال والمستندات قبل مغادرة الكاونتر</div>
        </div>

        <div class="comments" style="margin-top:10px">
            <strong>Comment:</strong>
            <p style="border:1px solid #ddd;padding:8px;margin-top:5px">{{ $invoice->notes ?? 'N/A' }}</p>
        </div>

        <div class="signature">
            Prepared By: {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}<br>
            Authorized Signatory – المخول بالتوقيع
        </div>

        <div class="footer" style="margin-top:25px"><img src="{{ $footerImage }}"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function shareInvoice(number) {
            const url = `${window.location.origin}/invoices/share/${number}`;
            if (navigator.share) {
                navigator.share({ title: `Receipt Invoice ${number}`, url });
            } else {
                alert('Sharing not supported on this browser.');
            }
        }

        $('#payment_method_select').on('change', function() {
            const method = $(this).val();
            const invoiceNo = @json($invoice->invoice_number);
            Swal.fire({
                title: 'Change Payment Method?',
                text: `Do you want to change the current payment method to "${method}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it',
                cancelButtonText: 'No, keep current'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('invoices') }}/${invoiceNo}/payment-method`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            payment_method: method
                        },
                        success(response) {
                            if (response.success) {
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message || 'Update failed');
                            }
                        },
                        error(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Server error');
                        }
                    });
                } else {
                    $(this).val(''); 
                }
            });
        });
    </script>
</body>
</html>
