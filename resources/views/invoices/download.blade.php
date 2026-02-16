@php
    $serverName = $_SERVER['SERVER_NAME'];
    $subdomain = explode('.', $serverName)[0];
    $headerFileName = strtolower($subdomain) . '_header.jpg';
    $footerFileName = strtolower($subdomain) . '_footer.jpg';
    $formattedDate = fn($date) => $date ? \Carbon\Carbon::parse($date)->format('d M Y') : 'N/A';
    $logoFileName = strtolower($subdomain) . '_logo.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->invoice_type}} Invoice - {{ $invoice->invoice_number}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="{{ asset('assets/img/' . $logoFileName) }}" rel="icon">
    <link href="{{ asset('assets/img/' . $logoFileName) }}" rel="apple-touch-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }
        .header img, .footer img {
            width: 100%;
        }
        .tax-invoice {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table td, .table th {
            padding: 10px;
            text-align: left;
        }
        .outer-table {
            border: 1px solid #ddd;
        }
        .table td, .table th {
            border: none;
        }
        .table tr th {
            background-color: #f1f1f1;
        }
        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 30px;
        }
        .service-table, .totals-table, .receipt-info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .service-table th, .totals-table th, .receipt-info-table th {
            background-color: #f1f1f1;
            padding: 10px;
        }
        .service-table td, .receipt-info-table td {
            padding: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
        }
        .totals-table td {
            padding: 10px;
            text-align: right;
            border-top: 1px solid #ddd;
        }
        .totals-table td {
            border: 1px solid #ddd;
        }
        .note-container {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }
        .note-container .english {
            font-style: italic;
            margin-right: 30px;
            text-align: left;
            width: 48%;
        }
        .note-container .arabic {
            margin-left: 30px;
            text-align: right;
            width: 48%;
            direction: rtl;
        }
        .signature-container {
            margin-top: 10px;
        }
        .signature-container p {
            font-size: 12px;
        }
        .comments-section {
            margin-top: 10px;
        }
        .comments-section h3 {
            font-size: 18px;
            font-weight: bold;
        }
        .comments-section p {
            width: 100%;
            height: 100px;
            margin: 10px auto;
            padding: 10px;
        }
        .receipt-info-table {
            margin-top: 10px;
            width: 100%;
            border-collapse: collapse;
        }
        .receipt-info-table th, .receipt-info-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/img/' . $headerFileName) }}" style="width:100%;">
        </div>
        <div class="tax-invoice">
            <p>ADVANCE RECEIPT – إيصال دفعة مقدمة</p>
        </div>
        <table class="table outer-table">
            <tr>
                <td style="width: 50%; padding-right: 10px;">
                    <table class="table">
                        <tr>
                            <th>Receipt No.</th>
                            <td>{{ $invoice->invoice_number }}</td>
                        </tr>
                        <tr>
                            <th>Receipt Date/والوقت التاريخ</th>
                            <td>{{ date('d M Y', strtotime($invoice->invoice_date)) }}</td>
                        </tr>
                        <tr>
                            <th>Customer/المتعامل</th>
                            <td>{{ $invoice->customer->first_name }} {{ $invoice->customer->last_name }}</td>
                        </tr>
                        <tr>
                            <th>EID No</th>
                            <td>{{ $invoice->customer->emirates_id }}</td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td>{{ $invoice->customer->nationality }}</td>
                        </tr>
                        <tr>
                            <th>Contact No</th>
                            <td>{{ $invoice->customer->mobile }}</td>
                        </tr>
                        <tr>
                            <th>Payment Method/المتعامل</th>
                            <td>{{ $invoice->payment_method }}</td>
                        </tr>
                        <tr>
                            <th>Staff Sales/موظفي المبيعات</th>
                            <td>{{ $invoice->creator->first_name }} {{ $invoice->creator->last_name }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; padding-left: 10px;">
                    <table class="table">
                        <tr>
                            <th>Contract Reference</th>
                            <td>
                                <!-- @if($invoice->agreement->status == 5)
                                  {{ optional($invoice->contract)->reference_no ?? '-' }}
                                @else
                                  {{ $invoice->agreement->reference_no }}
                                @endif -->
                                {{ $invoice->agreement->reference_no }}
                            </td>
                        </tr>
                        <tr>
                            <th>Contract Type</th>
                            <td>
                                <!-- @if($invoice->agreement->status == 5) CT @else {{ $invoice->agreement->agreement_type }} @endif -->
                                {{ $invoice->agreement->agreement_type }}
                            </td>
                        </tr>
                        <tr>
                            <th>Maid Name</th>
                            <td>{{ $invoice->agreement->candidate_name }}</td>
                        </tr>
                        <tr>
                            <th>Passport No</th>
                            <td>{{ $invoice->agreement->passport_no }}</td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td>
                                @php
                                    $nat = $invoice->agreement->nationality;
                                @endphp

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
                                @elseif (!empty($nat))
                                    {{ $nat }}
                                @else
                                    Ethiopia
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Contract Date</th>
                            <td>{{ date('d M Y', strtotime($invoice->agreement->created_at)) }}</td>
                        </tr>
                        <tr>
                            <th>Contract From</th>
                            <td>{{ !empty($invoice->agreement->agreement_start_date) ? date('d M Y', strtotime($invoice->agreement->agreement_start_date)) : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Contract To</th>
                            <td>{{ !empty($invoice->agreement->agreement_end_date) ? date('d M Y', strtotime($invoice->agreement->agreement_end_date)) : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Payment</th>
                            <td>{{ $invoice->status }}</td>
                        </tr>
                    </table>
                </td>
        </table>
        <p style="text-align: center;font-weight: bold;font-size: 14px;"><b>Particulars  تفاصيل</b></p>
        <table class="service-table">
            <thead>
                <tr>
                    <th>Sl. No <br> الرقم</th>
                    <th>Barcode <br> الخدمات</th>
                    <th>Contract No <br> رقم العقد</th>
                    <th>Contract Amount <br> تكلفة المعاملة</th>
                    <th>Total <br> الاجمالي بالدرهم</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5">ADVANCE RECEIPT</td>
                </tr>
            </tbody>
        </table>
        <table class="totals-table">
            <tr>
                <td><strong>SUB TOTAL  الإجمالي الفرعي</strong></td>
                <td>{{ $invoice->total_amount }} AED</td>
            </tr>
            <tr>
                <td><strong>VAT (0%)  ضريبة القيمة المضافة</strong></td>
                <td>0.00</td>
            </tr>
            <tr>
                <td><strong>DISCOUNT  الخصم</strong></td>
                <td>0.00</td>
            </tr>
            <tr>
                <td><strong>CREDIT CARD CHARGE  رسوم بطاقة الائتمان</strong></td>
                <td>0.00</td>
            </tr>
            <tr>
                <td><strong>TOTAL RECEIPT AMOUNT  المبلغ الإجمالي للفاتورة</strong></td>
                <td>{{ $invoice->received_amount }} AED</td>
            </tr>
            <tr>
                <td><strong>BALANCE AMOUNT  المبلغ المتبقي</strong></td>
                <td>{{ $invoice->total_amount - $invoice->received_amount }}.00 AED</td>
            </tr>
        </table>
        <div class="note-container">
            <div class="english">
                <p>Kindly check the invoice and documents before leaving the counter.</p>
            </div>
            <div class="arabic">
                <p>تأكد من الفاتورة والمستندات قبل مغادرة الكاونتر</p>
            </div>
        </div>
        <div class="comments-section">
            <h3>Comment</h3>
            <p>{{ $invoice->notes ?? "N/A" }}</p>
        </div>
        <div class="signature-container">
            <p>Prepared By: {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
            <p>Authorized Signatory - المخول بالتوقيع </p>
        </div>
        <div class="footer">
            <img src="{{ asset('assets/img/' . $footerFileName) }}" style="width:100%;">
        </div>
    </div>
</body>
</html>
