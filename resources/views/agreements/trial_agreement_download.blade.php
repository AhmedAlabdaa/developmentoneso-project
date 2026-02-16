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
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Agreement {{ $agreement->reference_no }}</title>
  <style>
    @page { size: A4; margin: 5mm; }
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      font-size: 12px;
      line-height: 1.45;
      background: #f9f9f9;
    }
    .container {
      width: 210mm;
      margin: auto;
      background: #fff;
      padding: 5mm;
      border: 1px solid #ddd;
      box-shadow: 0 4px 6px rgba(0,0,0,.1);
    }
    .header img,
    .footer img {
      width: 100%;
      height: auto;
      display: block;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    td, th {
      padding: 8px;
    }
    .dotted td {
      border: 1px dotted #000;
      text-align: center;
    }
    .solid td {
      border: 1px solid #000;
      text-align: center;
      vertical-align: middle;
    }
    .vertical-text {
      writing-mode: vertical-rl;
      transform: rotate(180deg);
      font-weight: bold;
    }
    .clause-table td {
      width: 50%;
      border: 1px solid #000;
      padding: 6px 8px;
      vertical-align: top;
    }
    .clause-table td.eng {
      text-align: justify;
    }
    .clause-table td.ara {
      direction: rtl;
      text-align: right;
    }
    .clause-title {
      font-weight: bold;
      display: block;
      margin-bottom: 4px;
    }
    .refund-row td {
      border-top: 1px solid #000;
    }
    .sign-table th,
    .sign-table td {
      border: 1px solid #000;
      padding: 12px 8px;
      text-align: center;
      vertical-align: top;
    }
    .sign-table td:first-child {
      width: 50%;
    }
    .sig-name {
      font-weight: bold;
    }
    @media print {
      body {
        background: #fff;
      }
      .container {
        box-shadow: none;
        border: none;
        padding: 0;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <img src="{{ asset('assets/img/' . $headerFileName) }}" alt="Header">
    </div>

    <table class="dotted">
      <tr>
        <td>{{ $createdAt }}</td>
        <td>
          <strong>(نموذج اتفاق تسلم عامل مساعد (فترة تجربة</strong><br>
          <strong>Domestic Worker Agreement (Trial Agreement)</strong>
        </td>
        <td style="font-weight:bold">{{ $agreement->reference_no }}</td>
        <td>
          <strong>Agreement Number<br>اتفاقية رقم</strong>
        </td>
      </tr>
    </table>

    <table class="solid">
      <tr>
        <td>{{ $agreement->client->first_name }} {{ $agreement->client->last_name }}</td>
        <td><strong>اسم العميل<br>CUSTOMER NAME</strong></td>
        <td rowspan="8" class="vertical-text">Second Party<br>الطرف الثاني</td>    {{-- 7 → 8 --}}
        <td>ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER</td>
        <td><strong>مكتب الاستقدام<br>Tadbeer Center</strong></td>
        <td rowspan="3" class="vertical-text">First Party<br>الطرف الأول</td>
      </tr>
      <tr>
        <td>{{ $agreement->client->emirates_id }}</td>
        <td><strong>رقم الهوية<br>ID NUMBER</strong></td>
        <td>800-32332</td>
        <td><strong>رقم الهاتف<br>Phone NUMBER</strong></td>
      </tr>
      <tr>
        <td>{{ $agreement->client->address }}</td>
        <td><strong>العنوان<br>ADDRESS</strong></td>
        <td>AL GARHOUD, DUBAI, UAE</td>
        <td><strong>العنوان<br>Address</strong></td>
      </tr>
      <tr>
        <td>{{ $agreement->client->passport_number }}</td>
        <td><strong>رقم الجواز<br>PASSPORT NUMBER</strong></td>
        <td>admin@tadbeer-alebdaa.com</td>
        <td><strong>البريد الإلكتروني<br>Email</strong></td>
        <td rowspan="5" class="vertical-text">Domestic Worker<br>العامل المساعد</td> {{-- 4 → 5 --}}
      </tr>
      <tr>
        <td>{{ $agreement->client->nationality }}</td>
        <td><strong>الجنسية<br>NATIONALITY</strong></td>
        <td>{{ $agreement->candidate_name }}</td>
        <td><strong>اسم العامل<br>Name</strong></td>
      </tr>
      <tr>
        <td>{{ $agreement->client->mobile }}</td>
        <td><strong>رقم الهاتف<br>PHONE NUMBER</strong></td>
        <td>{{ $agreement->passport_no }}</td>
        <td><strong>رقم جواز السفر<br>Passport</strong></td>
      </tr>
      <tr>
        <td>{{ $agreement->client->email }}</td>
        <td><strong>البريد الإلكتروني<br>EMAIL</strong></td>
        <td>{{ $agreement->nationality }}</td>
        <td><strong>الجنسية<br>Nationality</strong></td>
      </tr>
      <tr>
        <td>{{ \Carbon\Carbon::parse($agreement->agreement_start_date)->format('d-m-Y') }}</td>
        <td><strong>تاريخ بدء الاتفاقية<br>Agreement Start Date</strong></td>
        <td>{{ \Carbon\Carbon::parse($agreement->agreement_end_date)->format('d-m-Y') }}</td>
        <td><strong>تاريخ انتهاء الاتفاقية<br>Agreement End Date</strong></td>
      </tr>
    </table>
    <table class="clause-table">
      <tr>
        <td class="eng">
          <span class="clause-title">
            The first clause: "Contracting and recruitment office fees"
          </span>
          It was agreed that the second party would pay to the first party the recruitment fees, amounting to
          <strong>{{ $totalAmount }} AED</strong> in the following manner:<br>
          Two payments: the first payment upon receipt of the worker: <strong>{{ $received }}</strong>.
          The second payment: <strong>{{ $remaining }}</strong> before the end of the probationary period (four days from the date of receiving the worker).
        </td>
        <td class="ara">
          <span class="clause-title">
            البند الأول: "التعاقد ونفقات مكتب الاستقدام"
          </span>
          تم الاتفاق على أن يدفع الطرف الثاني إلى الطرف الأول رسوم الاستقدام وقدرها
          <strong>{{ $totalAmount }} درهم</strong> بالطريقة التالية:<br>
          دفعتين: الدفعة الأولى عند تسلم العامل: <strong>{{ $received }}</strong>.
          الدفعة الثانية: <strong>{{ $remaining }}</strong> قبل نهاية فترة التجربة (أربعة أيام من تاريخ استلام العامل).
        </td>
      </tr>
      <tr>
        <td class="eng">
          <span class="clause-title">The second clause: "trial period"</span><br>
          The worker shall be placed under probation for a period of 4 days, starting from
          <strong>{{ $agreementStart }}</strong> the date the worker received it until the date of
          <strong>{{ $agreementEnd }}</strong>.
        </td>
        <td class="ara">
          <span class="clause-title">البند الثاني: "فترة التجربة"</span><br>
          يوضع العامل تحت التجربة لمدة 4 أيام تبدأ من
          <strong>{{ $agreementStart }}</strong> حتى <strong>{{ $agreementEnd }}</strong>.
        </td>
      </tr>
      <tr>
        <td class="eng">
          <span class="clause-title">Clause Three: "Obligations of the First Party"</span><br>
          The center guarantees any fines recorded on the worker's previous file. The center undertakes to hand over the worker's passport to the employer upon completion of the status change.
        </td>
        <td class="ara">
          <span class="clause-title">البند الثالث: "التزامات الطرف الأول"</span><br>
          يضمن المركز سداد أي غرامات مسجلة على الملف السابق للعامل ويتعهد بتسليم جواز السفر إلى صاحب العمل فور إنهاء إجراءات تعديل الوضع.
        </td>
      </tr>
      <tr>
        <td class="eng">
          <span class="clause-title">Fourth Clause: "Obligations of the Second Party"</span><br>
          The employer undertakes to bear the responsibility of the worker, her safety and health care (if necessary) during her work period with him. The employer undertakes to complete the procedures for transferring the worker on his file and changing his status before the end of the probationary period and to bear any fines or costs in case the probationary period is exceeded.
        </td>
        <td class="ara">
          <span class="clause-title">البند الرابع: "التزامات الطرف الثاني"</span><br>
          يتعهد صاحب العمل بتحمل مسؤولية العاملة وسلامتها والرعاية الصحية (إن اقتضت الظروف) طوال مدة عملها لديه، ويتعهد باستكمال إجراءات نقل العامل على ملفه وتعديل وضعه قبل نهاية فترة التجربة وتحمل أية غرامات أو تكاليف في حال تجاوز مدة فترة التجربة.
        </td>
      </tr>
      <tr class="refund-row">
        <td colspan="2">
          <span class="clause-title">Clause Five: "Refund"</span><br>
          In case that the worker is returned to the office before the end of the probationary period (04 days), the amount of the first payment shall be returned within 03 days from the date of the worker’s return, after deducting the dues for the days of work that the worker worked for the employer, which are as follows:<br>
          From the first to the fourth day: 50 dirhams for each working day, including the worker’s salary.<br>
          Starting from the fifth day in the event that the status adjustment is not made: 100 dirhams for each working day, not including the worker’s salary.
        </td>
      </tr>
    </table>

    <table class="sign-table">
      <tr>
        <th>Signatures</th>
        <th>الامضاءات</th>
      </tr>
      <tr>
        <td>
          <strong>SECOND PARTY (Employer)</strong><br><br>
          الاسماء بعد الاطلاع والمصادقة<br><br>
          <span class="sig-name">{{ $agreement->client->first_name }} {{ $agreement->client->last_name }}</span>
        </td>
        <td>
          <strong>الطرف الأول (مكتب الاستقدام)</strong><br>
          FIRST PARTY (Recruitment Office)<br><br>
          ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER
        </td>
      </tr>
    </table>

    <div class="footer">
      <img src="{{ asset('assets/img/' . $footerFileName) }}" alt="Footer">
    </div>
  </div>
</body>
</html>
