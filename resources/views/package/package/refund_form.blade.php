@php
$serverName      = $_SERVER['SERVER_NAME'] ?? parse_url(url('/'), PHP_URL_HOST);
$subdomain       = explode('.', $serverName)[0] ?? '';
$headerFileName  = strtolower($subdomain) . '_header.jpg';
$footerFileName  = strtolower($subdomain) . '_footer.jpg';

$fmt = function ($date) {
    if (empty($date)) return '-';
    try {
        return \Carbon\Carbon::parse($date)
            ->timezone('Asia/Qatar')
            ->format('j F Y');
    } catch (\Exception $e) {
        return '-';
    }
};

$qar = function ($value) {
    if ($value === null || $value === '') return '-';
    if (!is_numeric($value)) return '-';
    return 'QAR ' . number_format((float) $value, 2);
};

$val = fn ($x) => ($x === null || $x === '') ? '-' : $x;

$days = function ($value) {
    if ($value === null || $value === '') return '-';
    if (!is_numeric($value)) return '-';
    return (int) $value . ' DAYS';
};

$holders = [
    'sponsor'  => 'Sponsor - كفيل',
    'office'   => 'Office - مكتب',
    'worker'   => 'Worker - العاملة',
    'customer' => 'Customer - العميل',
];

$decisions = [
    'replacement' => 'Replacement - استبدال',
    'refund'      => 'Refund - استرجاع',
];

$originalPassport = $holders[strtolower($record->original_passport_holder ?? '')] ?? $val($record->original_passport_holder ?? '');
$belongingsWith   = $holders[strtolower($record->worker_belongings_with ?? '')] ?? $val($record->worker_belongings_with ?? '');
$salaryTo         = $holders[strtolower($record->worker_salary_to ?? '')] ?? $val($record->worker_salary_to ?? '');
$decision         = $decisions[strtolower($record->customer_decision ?? '')] ?? $val($record->customer_decision ?? '');
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Refund Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @page{size:A4;margin:0}
        body{margin:0;background:#eef3f9;font-family:Arial,Helvetica,sans-serif;-webkit-print-color-adjust:exact;print-color-adjust:exact}
        .wrap{width:210mm;min-height:297mm;margin:0 auto;position:relative;background:#fff}
        .header,.footer{position:absolute;left:0;right:0;height:110px}
        .header{top:0}
        .footer{bottom:0}
        .header img,.footer img{width:100%;height:100%;object-fit:cover}
        .content{padding:115px 10mm 115px}
        h1{display:flex;justify-content:space-between;align-items:center;font-size:16px;margin:0 0 6px;font-weight:800;letter-spacing:.2px}
        h1 span{font-size:16px}
        .table{width:100%;border-collapse:collapse;font-size:11px}
        .table th,.table td{border:1px solid #555;padding:6px 8px;vertical-align:middle}
        .caption{background:#e9edf5;font-weight:800;text-align:center}
        .label{width:25%;font-weight:700}
        .value{text-align:center}
        .label-ar{width:30%;text-align:right;direction:rtl}
        .money{color:#c0191f;font-weight:800}
        .signs td{height:56px}
        .actions{position:fixed;top:12px;right:12px}
        button{padding:6px 10px;border:0;background:#111;color:#fff;border-radius:6px;cursor:pointer;font-weight:700;font-size:12px}
        @media print{.actions{display:none}}
        .label span{display:block;font-weight:400;direction:rtl;text-align:right;font-size:10px}
        .file-details .label,
        .file-details .value{width:25%}
    </style>
</head>
<body>
<div class="actions">
    <button onclick="window.print()">Print</button>
</div>
<div class="wrap">
    <div class="header">
        <img src="{{ asset('assets/img/' . $headerFileName) }}" alt="">
    </div>
    <div class="footer">
        <img src="{{ asset('assets/img/' . $footerFileName) }}" alt="">
    </div>
    <div class="content">
        <h1>
            <span>REFUND REQUEST FORM</span>
            <span>استمارة طلب الاسترداد</span>
        </h1>

        <table class="table">
            <tr>
                <td class="label">Reference Number</td>
                <td class="value">{{ $val($record->ref_no ?? ($record->reference_no ?? null)) }}</td>
                <td class="label-ar">رقم المرجع</td>
            </tr>
            <tr>
                <td class="label">Date</td>
                <td class="value">{{ $fmt($record->form_date ?? ($record->request_date ?? ($record->date ?? null))) }}</td>
                <td class="label-ar">التاريخ</td>
            </tr>
            <tr>
                <td class="label">CN-NO.</td>
                <td class="value">{{ $val($record->cn_no ?? null) }}</td>
                <td class="label-ar">رقم الملف</td>
            </tr>
            <tr>
                <td class="label">SPONSOR NAME</td>
                <td class="value">{{ $val($record->sponsor_name ?? null) }}</td>
                <td class="label-ar">اسم الكفيل</td>
            </tr>
            <tr>
                <td class="label">QID NO.</td>
                <td class="value">{{ $val($record->sponsor_qid ?? null) }}</td>
                <td class="label-ar">الرقم الشخصي</td>
            </tr>
            <tr>
                <td class="label">PHONE NO.</td>
                <td class="value">{{ $val($record->sponsor_phone ?? null) }}</td>
                <td class="label-ar">رقم الهاتف</td>
            </tr>
            <tr>
                <td class="label">SALES NAME</td>
                <td class="value">{{ $val($record->sales_name ?? null) }}</td>
                <td class="label-ar">اسم المبيعات</td>
            </tr>
        </table>

        <table class="table" style="margin-top:10px">
            <tr>
                <th class="caption" colspan="3">CONTRACT DETAILS - تفاصيل العقد</th>
            </tr>
            <tr>
                <td class="label">CONTRACT TYPE</td>
                <td class="value">{{ $val($record->contract_type ?? ($record->visa_type ?? null)) }}</td>
                <td class="label-ar">نوع العقد</td>
            </tr>
            <tr>
                <td class="label">CANDIDATE NAME</td>
                <td class="value">{{ $val($record->candidate_name ?? null) }}</td>
                <td class="label-ar">اسم العاملة</td>
            </tr>
            <tr>
                <td class="label">NATIONALITY</td>
                <td class="value">{{ $val($record->nationality_name ?? null) }}</td>
                <td class="label-ar">الجنسية</td>
            </tr>
            <tr>
                <td class="label">PASSPORT NO.</td>
                <td class="value">{{ $val($record->passport_no ?? null) }}</td>
                <td class="label-ar">رقم جواز السفر</td>
            </tr>
            <tr>
                <td class="label">CONTRACT AMOUNT</td>
                <td class="value money">{{ $qar($record->contract_amount ?? null) }}</td>
                <td class="label-ar">قيمة العقد</td>
            </tr>
            <tr>
                <td class="label">CONTRACT START DATE</td>
                <td class="value">{{ $fmt($record->contract_start_date ?? null) }}</td>
                <td class="label-ar">تاريخ بداية العقد</td>
            </tr>
            <tr>
                <td class="label">WORKER RETURNED DATE</td>
                <td class="value">{{ $fmt($record->worker_returned_date ?? null) }}</td>
                <td class="label-ar">تاريخ إرجاع العاملة</td>
            </tr>
            <tr>
                <td class="label">NO. OF DAYS WORK</td>
                <td class="value">
                    {{ $days($record->maid_worked_days ?? $record->number_of_days ?? null) }}
                </td>
                <td class="label-ar">عدد أيام العمل</td>
            </tr>
            <tr>
                <td class="label">OFFICE SERVICE CHARGES</td>
                <td class="value money">0</td>
                <td class="label-ar">رسوم خدمات المكتب</td>
            </tr>
            <tr>
                <td class="label">REFUND AMOUNT</td>
                <td class="value money">{{ $qar($record->refund_amount ?? null) }}</td>
                <td class="label-ar">المبلغ المستحق للاسترجاع</td>
            </tr>
            <tr>
                <td class="label">DUE DATE</td>
                <td class="value">{{ $fmt($record->refund_replace_date ?? null) }}</td>
                <td class="label-ar">تاريخ الاستحقاق</td>
            </tr>
            <tr>
                <td class="label">REASON</td>
                <td class="value">{{ $val($record->return_reason ?? null) }}</td>
                <td class="label-ar">سبب الإرجاع</td>
            </tr>
        </table>

        <table class="table file-details" style="margin-top:10px">
            <tr>
                <th class="caption" colspan="4">FILE DETAILS - تفاصيل الملف</th>
            </tr>
            <tr>
                <td class="label">
                    ORIGINAL PASSPORT
                    <span>ارجاع جواز السفر</span>
                </td>
                <td class="value">{{ $originalPassport }}</td>
                <td class="label">
                    NOC STATUS
                    <span>حالة عدم الممانعة</span>
                </td>
                <td class="value">{{ $val($record->noc_status ?? null) }}</td>
            </tr>
            <tr>
                <td class="label">
                    NOC EXPIRY DATE
                    <span>تاريخ انتهاء عدم الممانعة</span>
                </td>
                <td class="value">{{ $fmt($record->noc_expiry ?? null) }}</td>
                <td class="label">
                    WORKER BELONGINGS
                    <span>تسليم أغراض العاملة</span>
                </td>
                <td class="value">{{ $belongingsWith }}</td>
            </tr>
            <tr>
                <td class="label">
                    WORKER’S SALARY
                    <span>تسليم راتب العاملة</span>
                </td>
                <td class="value">{{ $salaryTo }}</td>
                <td class="label">
                    WORKER’S SALARY AMOUNT
                    <span>قيمة راتب العاملة</span>
                </td>
                <td class="value money">{{ $qar($record->worker_salary_amount ?? null) }}</td>
            </tr>
            <tr>
                <td class="label">
                    CUSTOMER DECISION
                    <span>قرار العميل</span>
                </td>
                <td class="value">{{ $decision }}</td>
                <td class="label"></td>
                <td class="value"></td>
            </tr>
        </table>

        <table class="table signs" style="margin-top:10px">
            <tr>
                <td style="width:25%;text-align:center;font-weight:700">
                    SALES OFFICER SIGN<br>
                    <span style="font-weight:400">توقيع موظف المبيعات</span>
                </td>
                <td style="width:25%;text-align:center;font-weight:700">
                    CUSTOMER SIGN<br>
                    <span style="font-weight:400">توقيع العميل</span>
                </td>
                <td style="width:25%;text-align:center;font-weight:700">
                    WORKER SIGN<br>
                    <span style="font-weight:400">توقيع العاملة</span>
                </td>
                <td style="width:25%;text-align:center;font-weight:700">
                    OPERATION MANAGER SIGN<br>
                    <span style="font-weight:400">توقيع مدير الفرع</span>
                </td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
