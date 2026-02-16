@php
$serverName = $_SERVER['SERVER_NAME'] ?? parse_url(url('/'), PHP_URL_HOST);
$subdomain  = explode('.', (string) $serverName)[0] ?? '';
$headerFile = strtolower($subdomain) . '_header.jpg';
$footerFile = strtolower($subdomain) . '_footer.jpg';

$val = function ($v) {
    return ($v !== null && $v !== '') ? $v : '';
};

$fmt = function ($date) {
    if (empty($date)) return '';
    try {
        return \Carbon\Carbon::parse($date)
            ->timezone('Asia/Qatar')
            ->format('j M Y');
    } catch (\Exception $e) {
        return '';
    }
};

$qar = function ($n) {
    if ($n === null || $n === '') return '';
    if (!is_numeric($n)) {
        $n = preg_replace('/[^\d.]/', '', (string) $n);
    }
    return 'QAR ' . number_format((float) $n, 0, '.', ',');
};
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Trial Deployment Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
@page { size: A4; margin: 0 }
* { box-sizing: border-box }
body {
  margin: 0;
  background: #eef3f9;
  font-family: Arial, Helvetica, sans-serif;
  -webkit-print-color-adjust: exact;
  print-color-adjust: exact;
}
.wrap {
  width: 210mm;
  min-height: 297mm;
  margin: 0 auto;
  position: relative;
  background: #fff;
}
.header,
.footer {
  position: absolute;
  left: 0;
  right: 0;
  height: 110px;
}
.header { top: 0 }
.footer { bottom: 0 }
.header img,
.footer img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.content {
  padding: 115px 10mm 115px;
}
h1 {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 16px;
  margin: 0 0 6px;
  font-weight: 800;
  letter-spacing: .2px;
}
h1 span { font-size: 16px }
.table {
  width: 100%;
  border-collapse: collapse;
  font-size: 11px;
}
.table th,
.table td {
  border: 1px solid #555;
  padding: 6px 8px;
  vertical-align: middle;
}
.caption {
  background: #e9edf5;
  font-weight: 800;
  text-align: center;
}
.label { width: 25%; font-weight: 700 }
.value { width: 45%; text-align: center }
.label-ar { width: 30%; text-align: right; direction: rtl }
.signs td {
  height: 56px;
  text-align: center;
  font-weight: 700;
}
.signs small {
  display: block;
  font-weight: 400;
  margin-top: 4px;
}
.actions {
  position: fixed;
  top: 12px;
  right: 12px;
  z-index: 9;
}
button {
  padding: 6px 10px;
  border: 0;
  background: #111;
  color: #fff;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 700;
  font-size: 12px;
}
@media print {
  .actions { display: none }
}
</style>
</head>
<body>
<div class="actions">
  <button onclick="window.print()">Print</button>
</div>
<div class="wrap">
  <div class="header">
    <img src="{{ asset('assets/img/' . $headerFile) }}" alt="">
  </div>
  <div class="footer">
    <img src="{{ asset('assets/img/' . $footerFile) }}" alt="">
  </div>
  <div class="content">
    <h1>
      <span>TRIAL DEPLOYMENT FORM</span>
      <span>نموذج إرسال للتجربة</span>
    </h1>

    <table class="table">
      <tr>
        <td class="label">Reference Number</td>
        <td class="value">{{ $val($record->ref_no ?? null) }}</td>
        <td class="label-ar">رقم المرجع</td>
      </tr>
      <tr>
        <td class="label">Date</td>
        <td class="value">{{ $fmt($record->date ?? now()) }}</td>
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
    </table>

    <table class="table" style="margin-top:10px">
      <tr>
        <th class="caption" colspan="3">CANDIDATE DETAILS - بيانات العاملة</th>
      </tr>
      <tr>
        <td class="label">CONTRACT TYPE</td>
        <td class="value">{{ $val($record->contract_type ?? $record->visa_type ?? null) }}</td>
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
        <td class="label">WORK START DATE</td>
        <td class="value">{{ $fmt($record->work_start_date ?? null) }}</td>
        <td class="label-ar">تاريخ بداية العمل</td>
      </tr>
      <tr>
        <td class="label">RETURN DATE</td>
        <td class="value">{{ $fmt($record->return_date ?? null) }}</td>
        <td class="label-ar">تاريخ إرجاع العاملة</td>
      </tr>
      <tr>
        <td class="label">CONTRACT AMOUNT</td>
        <td class="value">{{ $qar($record->total_amount ?? null) }}</td>
        <td class="label-ar">قيمة العقد</td>
      </tr>
      <tr>
        <td class="label">ADVANCE AMOUNT</td>
        <td class="value">{{ $qar($record->received_amount ?? null) }}</td>
        <td class="label-ar">دفعة مقدمة</td>
      </tr>
      <tr>
        <td class="label">PAYMENT METHOD</td>
        <td class="value">{{ $val($record->payment_method ?? null) }}</td>
        <td class="label-ar">طريقة الدفع</td>
      </tr>
      <tr>
        <td class="label">BALANCE DUE</td>
        <td class="value">{{ $qar($record->remaining_amount ?? null) }}</td>
        <td class="label-ar">المبلغ المستحق</td>
      </tr>
      <tr>
        <td class="label">SALES OFFICER NAME</td>
        <td class="value">{{ $val($record->sales_officer_name ?? null) }}</td>
        <td class="label-ar">اسم موظف المبيعات</td>
      </tr>
    </table>

    <table class="table" style="margin-top:10px">
      <tr>
        <th class="caption" colspan="3">REMARKS / ملاحظات</th>
      </tr>
      <tr>
        <td colspan="3" style="height:70px;text-align:center;vertical-align:top;padding-top:8px">
          {{ $val($record->remarks ?? null) }}
        </td>
      </tr>
    </table>

    <table class="table signs" style="margin-top:10px">
      <tr>
        <td style="width:33.33%;">
          SALES OFFICER SIGN
          <small>توقيع موظف المبيعات</small>
        </td>
        <td style="width:33.33%;">
          OPERATIONS MANAGER SIGN
          <small>توقيع مدير الفرع</small>
        </td>
        <td style="width:33.33%;">
          FINANCE MANAGER SIGN
          <small>توقيع مدير المالية</small>
        </td>
      </tr>
      <tr>
        <td></td><td></td><td></td>
      </tr>
    </table>
  </div>
</div>
</body>
</html>
