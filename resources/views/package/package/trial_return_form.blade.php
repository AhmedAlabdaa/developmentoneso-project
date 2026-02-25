@php
$d = function ($date, $pattern = 'j F Y') {
    if (empty($date)) return '-';
    try {
        return \Carbon\Carbon::parse($date)
            ->timezone('Asia/Qatar')
            ->locale('en')
            ->format($pattern);
    } catch (\Exception $e) {
        return '-';
    }
};

$q = function ($num) {
    return ($num !== null && $num !== '' && is_numeric($num))
        ? 'QAR ' . number_format((float) $num, 0)
        : '-';
};

$v = fn ($x) => ($x === null || $x === '') ? '-' : $x;

$holders = [
    'sponsor'  => 'Sponsor - كفيل',
    'office'   => 'Office - مكتب',
    'worker'   => 'Worker - العاملة',
    'customer' => 'Customer - العميل',
];

$dec = [
    'replacement' => 'Replacement - استبدال',
    'refund'      => 'Refund - استرجاع',
];

$noc = [
    'received'     => 'Received - تم الاستلام',
    'not_received' => 'Not Received - لم يتم الاستلام',
];

$originalPassport = $holders[strtolower($record->original_passport_holder ?? '')] ?? $v($record->original_passport_holder ?? '');
$belongingsWith   = $holders[strtolower($record->worker_belongings_with ?? '')] ?? $v($record->worker_belongings_with ?? '');
$salaryTo         = $holders[strtolower($record->worker_salary_to ?? '')] ?? $v($record->worker_salary_to ?? '');
$decision         = $dec[strtolower($record->customer_decision ?? '')] ?? $v($record->customer_decision ?? '');
$nocStatus        = $noc[strtolower($record->noc_status ?? '')] ?? $v($record->noc_status ?? '');

$server = $_SERVER['SERVER_NAME'] ?? parse_url(url('/'), PHP_URL_HOST);
$sub    = explode('.', $server)[0] ?? '';
$header = asset('assets/img/' . strtolower($sub) . '_header.jpg');
$footer = asset('assets/img/' . strtolower($sub) . '_footer.jpg');
@endphp
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{{ $formTitle ?? 'Worker Return Form' }}</title>
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
.label {
  width: 25%;
  font-weight: 700;
}
.value {
  width: 45%;
  text-align: center;
}
.label-ar {
  width: 30%;
  text-align: right;
  direction: rtl;
}
.mt { margin-top: 10px }
.grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}
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
.money {
  color: red;
  font-weight: 700;
}
.file-details .label,
.file-details .value {
  width: 25%;
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
  <div class="header"><img src="{{ $header }}" alt=""></div>
  <div class="footer"><img src="{{ $footer }}" alt=""></div>
  <div class="content">
    <h1>
      <span>{{ $formTitle ?? 'WORKER RETURN FORM' }}</span>
      <span>استمارة إرجاع العاملة</span>
    </h1>

    <table class="table">
      <tr>
        <td class="label">Reference Number</td>
        <td class="value">{{ $v($record->ref_no ?? '') }}</td>
        <td class="label-ar">رقم المرجع</td>
      </tr>
      <tr>
        <td class="label">Date</td>
        <td class="value">{{ $d($record->form_date ?? $record->created_at ?? now()) }}</td>
        <td class="label-ar">التاريخ</td>
      </tr>
      <tr>
        <td class="label">CN-NO.</td>
        <td class="value">{{ $v($record->cn_no ?? '') }}</td>
        <td class="label-ar">رقم الملف</td>
      </tr>
    </table>

    <div class="grid mt">
      <table class="table">
        <tr><td class="caption" colspan="3">SPONSOR</td></tr>
        <tr>
          <td class="label">SPONSOR NAME</td>
          <td class="value">{{ $v($record->sponsor_name ?? '') }}</td>
          <td class="label-ar">اسم الكفيل</td>
        </tr>
        <tr>
          <td class="label">QID NO.</td>
          <td class="value">{{ $v($record->sponsor_qid ?? '') }}</td>
          <td class="label-ar">الرقم الشخصي</td>
        </tr>
        <tr>
          <td class="label">PHONE NO.</td>
          <td class="value">{{ $v($record->sponsor_phone ?? '') }}</td>
          <td class="label-ar">رقم الهاتف</td>
        </tr>
        <tr>
          <td class="label">SALES NAME</td>
          <td class="value">{{ $v($record->sales_name ?? '') }}</td>
          <td class="label-ar">اسم المبيعات</td>
        </tr>
      </table>

      <table class="table">
        <tr><td class="caption" colspan="3">CANDIDATE</td></tr>
        <tr>
          <td class="label">CANDIDATE NAME</td>
          <td class="value">{{ $v($record->candidate_name ?? '') }}</td>
          <td class="label-ar">اسم العاملة</td>
        </tr>
        <tr>
          <td class="label">PASSPORT NO.</td>
          <td class="value">{{ $v($record->passport_no ?? '') }}</td>
          <td class="label-ar">رقم جواز السفر</td>
        </tr>
        <tr>
          <td class="label">NATIONALITY</td>
          <td class="value">{{ $v($record->nationality_name ?? '') }}</td>
          <td class="label-ar">الجنسية</td>
        </tr>
      </table>
    </div>

    <table class="table mt file-details">
      <tr><th class="caption" colspan="4">CONTRACT DETAILS - تفاصيل العقد</th></tr>
      <tr>
        <td class="label">
          CONTRACT TYPE
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            نوع العقد
          </span>
        </td>
        <td class="value">{{ $v($record->contract_type ?? '') }}</td>
        <td class="label">
          CONTRACT AMOUNT
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            قيمة العقد
          </span>
        </td>
        <td class="value money">{{ $q($record->contract_amount ?? null) }}</td>
      </tr>
      <tr>
        <td class="label">
          CONTRACT START DATE
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            تاريخ بداية العقد
          </span>
        </td>
        <td class="value">{{ $d($record->contract_start_date ?? null) }}</td>
        <td class="label">
          WORKER RETURNED DATE
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            تاريخ إرجاع العاملة
          </span>
        </td>
        <td class="value">{{ $d($record->worker_returned_date ?? null) }}</td>
      </tr>
      <tr>
        <td class="label">
          MAID WORKED DAYS
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            عدد الأيام
          </span>
        </td>
        <td class="value">{{ $v($record->maid_worked_days ?? '0') }}</td>
        <td class="label">
          OFFICE SERVICE CHARGES
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            رسوم خدمات المكتب
          </span>
        </td>
        <td class="value money">0</td>
      </tr>
      <tr>
        <td class="label">
          CREDIT AVAILABLE
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
             المبلغ المستحق للاسترداد
          </span>
        </td>
        <td class="value money">{{ $q($record->refund_amount ?? null) }}</td>
        <td class="label">
          DUE DATE
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            تاريخ الاستحقاق
          </span>
        </td>
        <td class="value" colspan="3">{{ $d($record->refund_replace_date ?? null) }}</td>
      </tr>
    </table>
    <table class="table mt file-details">
      <tr><th class="caption" colspan="4">FILE DETAILS - تفاصيل الملف</th></tr>
      <tr>
        <td class="label">
          ORIGINAL PASSPORT
          <br>
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            ارجاع جواز السفر
          </span>
        </td>
        <td class="value">{{ $originalPassport }}</td>
        <td class="label">
          WORKER BELONGINGS
          <br>
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            تسليم أغراض العاملة
          </span>
        </td>
        <td class="value">{{ $belongingsWith }}</td>
      </tr>
      @php
        $salaryToRaw = strtolower(trim((string)($record->worker_salary_to ?? '')));
        $workerSalaryAmount = ($salaryToRaw === 'worker') ? 0 : ($record->worker_salary_amount ?? null);
      @endphp
      <tr>
        <td class="label">
          WORKER’S SALARY
          <br>
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            تسليم راتب العاملة
          </span>
        </td>
        <td class="value">{{ $salaryTo }}</td>
        <td class="label">
          WORKER’S SALARY AMOUNT
          <br>
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            قيمة راتب العاملة
          </span>
        </td>
        <td class="value money">{{ $q($workerSalaryAmount) }}</td>
      </tr>
      <tr>
        <td class="label">
          NOC STATUS
          <br>
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            حالة عدم الممانعة
          </span>
        </td>
        <td class="value">{{ $nocStatus }}</td>
        <td class="label">
          NOC EXPIRY DATE
          <br>
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            تاريخ انتهاء عدم الممانعة
          </span>
        </td>
        <td class="value">{{ $d($record->noc_expiry ?? null) }}</td>
      </tr>
      <tr>
        <td class="label">
          CUSTOMER DECISION
          <br>
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            قرار العميل
          </span>
        </td>
        <td class="value" colspan="3">{{ $decision }}</td>
      </tr>
    </table>

    <table class="table mt">
      <tr>
        <td class="label">
          RETURN REASON
          <span style="font-weight:400;direction:rtl;text-align:right;font-size:10px;display:block">
            سبب الارجاع
          </span>
        </td>
        <td class="value" style="text-align:left;font-weight: bold;color: red;">{{ $v($record->return_reason ?? '') }}</td>
      </tr>
    </table>

    <table class="table mt signs">
      <tr>
        <td>SALES OFFICER SIGN<small>توقيع موظف المبيعات</small></td>
        <td>CUSTOMER SIGN<small>توقيع العميل</small></td>
        <td>WORKER SIGN<small>توقيع العاملة</small></td>
        <td>OPERATION MANAGER SIGN<small>توقيع مدير الفرع</small></td>
      </tr>
      <tr>
        <td></td><td></td><td></td><td></td>
      </tr>
    </table>
  </div>
</div>
</body>
</html>
