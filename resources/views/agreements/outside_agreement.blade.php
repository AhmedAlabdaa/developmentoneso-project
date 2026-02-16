@php
use Carbon\Carbon;
use Illuminate\Support\Str;
$serverName     = $_SERVER['SERVER_NAME'] ?? '';
$subdomain      = explode('.', $serverName)[0];
$headerFileName = strtolower($subdomain) . '_header.jpg';
$footerFileName = strtolower($subdomain) . '_footer.jpg';

$createdAt      = $agreement->created_at
                    ? Carbon::parse($agreement->created_at)->format('d-m-Y')
                    : '';
$agreementStart = $agreement->agreement_start_date
                    ? Carbon::parse($agreement->agreement_start_date)->format('d-m-Y')
                    : '';
$agreementEnd   = $agreement->agreement_end_date
                    ? Carbon::parse($agreement->agreement_end_date)->format('d-m-Y')
                    : '';

if (! empty($agreement->monthly_payment)) {
    $totalAmount = (float) $agreement->monthly_payment;
    $received    = (float) $agreement->monthly_payment;
    $remaining   = 0;
} else {
    $totalAmount = (float) $agreement->total_amount;
    $received    = (float) ($agreement->received_amount ?? 0);
    $remaining   = max(0, $totalAmount - $received);
}
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement of {{ $agreement->candidate_name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page { size: A4; margin: 20mm; }
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0; padding: 0;
            font-size: 12px; line-height: 1.5;
        }
        .contract-container {
            width: 210mm; max-width: 210mm;
            margin: auto; background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header, .footer { text-align: center; margin: 0; padding: 0; }
        .header img, .footer img { max-width: 100%; height: auto; }
        .table-container {
            width: 100%; border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-container td, .table-container th {
            border: 1px dotted #000;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }
        .solid-table-container {
            width: 100%; border-collapse: collapse;
            margin-bottom: 20px;
        }
        .solid-table-container td, .solid-table-container th {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }
        .agreement-number { font-size: 12px; font-weight: bold; }
        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-weight: bold; font-size: 12px;
        }
        .clause-container { margin-bottom: 20px; }
        .clause {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .clause p {
            width: 48%; margin: 0;
        }
        .clause p:first-child {
            direction: ltr; text-align: justify;
        }
        .clause p:last-child {
            direction: rtl; text-align: justify;
        }
        .signature-section {
            margin-top: 30px;
            display: flex; justify-content: space-between;
            gap: 20px;
        }
        .signature-box {
            flex: 1;
            border: 2px solid #000;
            padding: 20px; position: relative;
        }
        .signature-title {
            position: absolute; top: -12px; left: 20px;
            background: #fff; padding: 0 10px;
            font-weight: bold;
        }
        .signature-box p { margin: 15px 0; font-size: 12px; }
        .signature-line {
            border-bottom: 1px solid #000;
            display: inline-block; width: 80%;
            margin: 5px 0;
        }
        .signature-label {
            font-weight: bold; margin-right: 10px;
            display: inline-block; width: 20%;
        }
        .button-container {
            text-align: center; margin-bottom: 20px;
        }
        .button-container a {
            display: inline-block; margin: 0 10px;
            padding: 10px 20px; color: #fff;
            text-decoration: none; border-radius: 4px;
            font-size: 14px;
        }
        .btn-download { background-color: #28a745; }
        .btn-back     { background-color: #6c757d; }
    </style>
</head>
<body>
    <div class="contract-container">
        <div class="button-container">
            <a href="{{ route('download.agreement', $agreement->reference_no) }}" class="btn-download">
                <i class="fa fa-download"></i> Download Agreement
            </a>
            <a href="{{ route('agreements.index') }}" class="btn-back">
                <i class="fa fa-arrow-left"></i> Back to Agreements
            </a>
        </div>
        <div class="header">
            <img src="{{ asset('assets/img/' . $headerFileName) }}" alt="Header Image">
        </div>
        <table class="table-container">
            <tr>
                <td>{{ $createdAt }}</td>
                <td>
                    <strong>Domestic Worker Booking Agreement</strong><br>
                    <strong>نموذج اتفاق مبدئي لاستقدام عامل مساعد</strong>
                </td>
                <td>Agreement Number<br><strong>اتفاقية رقم</strong></td>
                <td class="agreement-number">{{ $agreement->reference_no }}</td>
            </tr>
        </table>
        <table class="solid-table-container">
            <tr>
                <td>{{ $agreement->client->first_name }} {{ $agreement->client->last_name }}</td>
                <td><strong>اسم صاحب العمل <br> SPONSOR NAME</strong></td>
                <td rowspan="7" class="vertical-text"><strong>Second Party<br>الطرف الثاني</strong></td>
                <td>AL EBDAA DOMESTIC WORKERS CENTRE</td>
                <td><strong>مكتب الاستقدام <br> Tadbeer Center</strong></td>
                <td rowspan="3" class="vertical-text"><strong>First Party<br>الطرف الأول</strong></td>
            </tr>
            <tr>
                <td>{{ $agreement->client->emirates_id }}</td>
                <td><strong>رقم الهوية <br> ID NUMBER</strong></td>
                <td>048828848</td>
                <td><strong>رقم الهاتف <br> Phone NUMBER</strong></td>
            </tr>
            <tr>
                <td>{{ $agreement->client->address }}</td>
                <td><strong>العنوان <br> ADDRESS</strong></td>
                <td>AL GARHOUD, DUBAI, UAE</td>
                <td><strong>العنوان <br> Address</strong></td>
            </tr>
            <tr>
                <td>{{ $agreement->client->nationality }}</td>
                <td><strong>الجنسية <br> NATIONALITY</strong></td>
                <td>{{ $agreement->candidate_name }}</td>
                <td><strong>اسم العامل <br> Name</strong></td>
                <td rowspan="4" class="vertical-text"><strong>العامل المساعد <br> Domestic Worker</strong></td>
            </tr>
            <tr>
                <td>{{ $agreement->client->mobile }}</td>
                <td><strong>رقم الهاتف <br> PHONE NUMBER</strong></td>
                <td>{{ $agreement->passport_no }}</td>
                <td><strong>رقم جواز السفر <br> Passport</strong></td>
            </tr>
            <tr>
                <td>{{ $agreement->client->state }}</td>
                <td><strong>الإمارة <br> EMIRATE</strong></td>
                <td>{{ $agreement->Nationality->name ?? $agreement->nationality }}</td>
                <td><strong>الجنسية <br> Nationality</strong></td>
            </tr>
            <tr>
                <td>{{ $agreementStart }}</td>
                <td><strong>تاريخ بدء الاتفاقية <br> Agreement Start Date</strong></td>
                <td>{{ $agreementEnd }}</td>
                <td><strong>تاريخ انتهاء الاتفاقية <br> Agreement End Date</strong></td>
            </tr>
        </table>
        <div class="clause-container">
            <div class="clause">
                <p>
                    <strong>Clause 1: Contracting and Recruitment Office Fees</strong><br>
                    It was agreed that the second party would pay the recruitment fees to the first party,
                    amounting to <strong>{{ number_format($totalAmount, 2) }}</strong> AED, in the following manner:<br>
                    - First payment of <strong>{{ number_format($received, 2) }}</strong> AED upon the worker’s request.<br>
                    - Second payment of <strong>{{ number_format($remaining, 2) }}</strong> AED on the date the worker is received.
                </p>
                <p>
                    <strong>البند الأول: التعاقد وأتعاب مكتب الاستقدام</strong><br>
                    تم الاتفاق على أن يدفع الطرف الثاني إلى الطرف الأول رسوم الاستقدام وقدرها
                    <strong>{{ number_format($totalAmount, 2) }}</strong> درهم، موزعة على دفعتين:<br>
                    - الدفعة الأولى: <strong>{{ number_format($received, 2) }}</strong> درهم عند طلب العامل.<br>
                    - الدفعة الثانية: <strong>{{ number_format($remaining, 2) }}</strong> درهم عند استلام العامل.
                </p>
            </div>
            <div class="clause">
                <p>
                    <strong>Clause 2: Helper</strong><br>
                    The specifications of the auxiliary worker to be recruited were agreed upon, and the above-mentioned worker was chosen.
                </p>
                <p>
                    <strong>البند الثاني: العامل المساعد</strong><br>
                    تم الاتفاق على مواصفات العامل المساعد المراد استقدامه وتم اختيار العامل المبين أعلاه.
                </p>
            </div>
            <div class="clause">
                <p>
                    <strong>Clause 3: Obligations of the First Party</strong><br>
                    The center takes care of all recruitment procedures and their costs.<br>
                    - The center undertakes to recruit the worker according to legal procedures.<br>
                    - Conduct necessary medical examinations.
                </p>
                <p>
                    <strong>البند الثالث: التزامات الطرف الأول</strong><br>
                    يتكفل المركز بجميع إجراءات الاستقدام وتكاليفها.<br>
                    - يتعهد المركز باستقدام العامل وفق الإجراءات القانونية.<br>
                    - إجراء الفحوصات الطبية اللازمة.
                </p>
            </div>
            <div class="clause">
                <p>
                    <strong>Clause 4: Obligations of the Second Party</strong><br>
                    The employer undertakes to complete the procedures for transferring the worker on their file and adjusting their status before the end of the probationary period.<br>
                    - The employer bears any fines or costs if the probationary period is exceeded.
                </p>
                <p>
                    <strong>البند الرابع: التزامات الطرف الثاني</strong><br>
                    يتعهد صاحب العمل باستكمال إجراءات إقامة العامل قبل انتهاء فترة التجربة.<br>
                    - يتحمل أي غرامات أو تكاليف في حال تجاوز مدة فترة التجربة.
                </p>
            </div>
            <div class="clause">
                <p>
                    <strong>Clause 5: Recovery</strong><br>
                    In the event that the employer wishes to cancel this agreement, the advance amount will be refunded only.<br>
                    - Visa fees are not refundable.
                </p>
                <p>
                    <strong>البند الخامس: الاسترداد</strong><br>
                    في حال يرغب صاحب العمل في إلغاء هذا الاتفاق، يتم إرجاع مبلغ الدفعة المقدمة فقط.<br>
                    - رسوم التأشيرة غير قابلة للاسترداد.
                </p>
            </div>
        </div>
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-title">Second Party (Employer) / الطرف الثاني (صاحب العمل)</div>
                <p><span class="signature-label">Name:</span> <span class="signature-line">{{ $agreement->client->name }}</span></p>
                <p><span class="signature-label">Signature:</span> <span class="signature-line"></span></p>
                <p><span class="signature-label">Date:</span> <span class="signature-line"></span></p>
            </div>
            <div class="signature-box">
                <div class="signature-title">First Party (Recruitment Office) / الطرف الأول (مكتب الاستقدام)</div>
                <p><span class="signature-label">Name:</span> <span class="signature-line">ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER</span></p>
                <p><span class="signature-label">Signature:</span> <span class="signature-line"></span></p>
                <p><span class="signature-label">Date:</span> <span class="signature-line"></span></p>
            </div>
        </div>
        <div class="footer" style="margin-top: 20px;">
            <img src="{{ asset('assets/img/' . $footerFileName) }}" alt="Footer Image">
        </div>
    </div>
</body>
</html>
