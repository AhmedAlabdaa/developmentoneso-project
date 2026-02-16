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
  <meta charset="UTF-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Agreement of {{ $agreement->candidate_name }}</title>
</head>
<style type="text/css">
  .aaa{float: left !important;}
</style>
<body style="margin:10; padding:0;font-size: 14px;">
  <img src="{{ asset('assets/img/' . $headerFileName) }}" style="width:100%;">
  <div style="width:100%;margin:0 auto;">
    <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
      <tr>
        <td style="border:1px dotted #000; padding:10px; text-align:center;">
          {{ $agreement->created_at ? $agreement->created_at->format('d-m-Y') : '' }}
        </td>
        <td style="border:1px dotted #000; padding:10px; text-align:center;">
          <strong>Domestic Worker Booking Agreement</strong><br>
          <strong>نموذج اتفاق مبدئي لاستقدام عامل مساعد</strong>
        </td>
        <td style="border:1px dotted #000; padding:10px; text-align:center;">
          Agreement Number<br>
          <strong>اتفاقية رقم</strong>
        </td>
        <td style="border:1px dotted #000; padding:10px; text-align:center; font-weight:bold;">
          {{ $agreement->reference_no }}
        </td>
      </tr>
    </table>
    <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
      <tr>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ $agreement->client->first_name }} {{ $agreement->client->last_name }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>اسم صاحب العمل<br>SPONSOR NAME</strong>
          </td>
          <td rowspan="7" style="border:1px solid #000; padding:10px; text-align:center;">
              <span style="display:inline-block; font-size:12px; font-weight:bold; white-space:nowrap; transform:rotate(90deg); transform-origin:center center;">
                  Second Party&nbsp;/&nbsp;الطرف&nbsp;الثاني
              </span>
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              AL&nbsp;EBDAA&nbsp;DOMESTIC&nbsp;WORKERS&nbsp;CENTRE
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>مكتب الاستقدام<br>Tadbeer Center</strong>
          </td>
          <td rowspan="3" style="border:1px solid #000; padding:10px; text-align:center;">
              <span style="display:inline-block; font-size:12px; font-weight:bold; white-space:nowrap; transform:rotate(-90deg); transform-origin:center center;">
                  First Party&nbsp;/&nbsp;الطرف&nbsp;الأول
              </span>
          </td>
      </tr>
      <tr>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ $agreement->client->emirates_id }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>رقم الهوية<br>ID NUMBER</strong>
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              048828848
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>رقم الهاتف<br>Phone NUMBER</strong>
          </td>
      </tr>
      <tr>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ $agreement->client->address }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>العنوان<br>ADDRESS</strong>
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              AL&nbsp;GARHOUD,&nbsp;DUBAI,&nbsp;UAE
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>العنوان<br>Address</strong>
          </td>
      </tr>
      <tr>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ $agreement->client->nationality }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>الجنسية<br>NATIONALITY</strong>
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ $agreement->candidate_name }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>اسم العامل<br>Name</strong>
          </td>
          <td rowspan="4" style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>العامل المساعد<br>Domestic worker</strong>
          </td>
      </tr>
      <tr>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ $agreement->client->mobile }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>رقم الهاتف<br>PHONE NUMBER</strong>
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ $agreement->passport_no }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>رقم جواز السفر<br>Passport</strong>
          </td>
      </tr>
      <tr>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ $agreement->client->state }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>الإمارة<br>EMIRATE</strong>
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ $agreement->Nationality->name ?? '' }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>الجنسية<br>Nationality</strong>
          </td>
      </tr>
      <tr>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ \Carbon\Carbon::parse($agreement->agreement_start_date)->format('d-m-Y') }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>تاريخ بدء الاتفاقية<br>Agreement&nbsp;Start&nbsp;Date</strong>
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              {{ \Carbon\Carbon::parse($agreement->agreement_end_date)->format('d-m-Y') }}
          </td>
          <td style="border:1px solid #000; padding:10px; text-align:center;">
              <strong>تاريخ انتهاء الاتفاقية<br>Agreement&nbsp;End&nbsp;Date</strong>
          </td>
      </tr>
  </table>
    <div style="width:100%; margin-bottom:20px; overflow:auto;">
      <div style="float:left; width:47%;">
        <p style="margin:0; direction:ltr; text-align:left;">
          <strong>Clause 1: Contracting and Recruitment Office Fees</strong><br>
          It was agreed that the second party would pay the recruitment fees, amounting to {{ number_format($totalAmount,2) }} AED, as follows:<br>
          - First payment of {{ number_format($received,2) }} AED when requesting the worker.<br>
          - Second payment of the remaining amount {{ number_format($remaining,2) }} AED upon the worker’s arrival.
        </p>
      </div>
      <div style="float:left; width:47%; margin-left:5%;">
        <p style="margin:0; direction:rtl; text-align:right;">
          <strong>البند الأول: أتعاب مكتب الاستقدام</strong><br>
          تم الاتفاق على أن يدفع الطرف الثاني أتعاب مكتب الاستقدام للطرف الأول وقدرها {{ number_format($totalAmount,2) }} درهم موزعة على دفعتين:<br>
          - الدفعة الأولى: {{ number_format($received,2) }} درهم عند طلب العامل.<br>
          - الدفعة الثانية: المبلغ المتبقي وقدره {{ number_format($remaining,2) }} درهم عند استلام العامل.
        </p>
      </div>
    </div>
    <div style="clear:both;"></div>
    <div style="width:100%; margin-bottom:20px; overflow:auto;">
      <div style="float:left; width:47%;">
        <p style="margin:0; direction:ltr; text-align:left;">
          <strong>Clause 2: Helper</strong><br>
          The specifications of the auxiliary worker to be recruited were agreed upon, and the above-mentioned worker was chosen.
        </p>
      </div>
      <div style="float:left; width:47%; margin-left:5%;">
        <p style="margin:0; direction:rtl; text-align:right;">
          <strong>البند الثاني: العامل المساعد</strong><br>
          تم الاتفاق على مواصفات العامل المساعد المراد استقدامه وتم اختيار العامل المبين أعلاه.
        </p>
      </div>
    </div>
    <div style="clear:both;"></div>
    <div style="width:100%; margin-bottom:20px; overflow:auto;">
      <div style="float:left; width:47%;">
        <p style="margin:0; direction:ltr; text-align:left;">
          <strong>Clause 3: Obligations of the First Party</strong><br>
          The center takes care of all recruitment procedures and their costs.<br>
          - The center undertakes to recruit the worker according to legal procedures.<br>
          - Conduct necessary medical examinations.
        </p>
      </div>
      <div style="float:left; width:47%; margin-left:5%;">
        <p style="margin:0; direction:rtl; text-align:right;">
          <strong>البند الثالث: التزامات الطرف الأول</strong><br>
          يتكفل المركز بجميع إجراءات الاستقدام وتكالفيها.<br>
          - يتعهد المركز باستقدام العامل وفق الإجراءات القانونية وإجراء الفحوصات الطبية اللازمة.
        </p>
      </div>
    </div>
    <div style="clear:both;"></div>
    <div style="width:100%; margin-bottom:20px; overflow:auto;">
      <div style="float:left; width:47%;">
        <p style="margin:0; direction:ltr; text-align:left;">
          <strong>Clause 4: Obligations of the Second Party</strong><br>
          The employer undertakes to complete the procedures for transferring the worker on their file and adjusting their status before the end of the probationary period.<br>
          - The employer bears any fines or costs if the probationary period is exceeded.
        </p>
      </div>
      <div style="float:left; width:47%; margin-left:5%;">
        <p style="margin:0; direction:rtl; text-align:right;">
          <strong>البند الرابع: التزامات الطرف الثاني</strong><br>
          يتعهد صاحب العمل باستكمال إجراءات إقامة العامل قبل انتهاء فترة التجربة.<br>
          - يتحمل أي غرامات أو تكاليف في حال تجاوز مدة فترة التجربة.
        </p>
      </div>
    </div>
    <div style="clear:both;"></div>
    <div style="width:100%; margin-bottom:20px; overflow:auto;">
      <div style="float:left; width:47%;">
        <p style="margin:0; direction:ltr; text-align:left;">
          <strong>Clause 5: Recovery</strong><br>
          In the event that the employer wishes to cancel this agreement, the advance amount will be refunded only.<br>
          - Visa fees are not refundable.
        </p>
      </div>
      <div style="float:left; width:47%; margin-left:5%;">
        <p style="margin:0; direction:rtl; text-align:right;">
          <strong>البند الخامس: الاسترداد</strong><br>
          في حال يرغب صاحب العمل في إلغاء هذا الاتفاق، يتم إرجاع مبلغ الدفعة المقدمة فقط.<br>
          - رسوم التأشيرة غير قابلة للاسترداد.
        </p>
      </div>
    </div>
    <div style="clear:both;"></div>
    <div style="width:45%; border:2px solid #000; padding:15px; position:relative;" class="aaa">
      <div style="position:absolute; top:-12px; left:15px; background:#fff; padding:0 8px; font-weight:bold;">
        Second Party (Employer) / الطرف الثاني
      </div>
      <p style="margin:10px 0; font-size:12px;">
        <span style="display:inline-block; width:20%; font-weight:bold; margin-right:5px;">Name:</span>
        <span style="display:inline-block; width:100%; border-bottom:1px solid #000; margin-top:5px;">
          {{ $agreement->client->first_name }} {{ $agreement->client->last_name }}
        </span>
      </p>
      <p style="margin:10px 0; font-size:12px;">
        <span style="display:inline-block; width:20%; font-weight:bold; margin-right:5px;">Signature:</span>
        <span style="display:inline-block; width:100%; border-bottom:1px solid #000; margin-top:5px;"></span>
      </p>
      <p style="margin:10px 0; font-size:12px;">
        <span style="display:inline-block; width:20%; font-weight:bold; margin-right:5px;">Date:</span>
        <span style="display:inline-block; width:100%; border-bottom:1px solid #000; margin-top:5px;"></span>
      </p>
    </div>
    <div style="width:45%; border:2px solid #000; padding:15px; position:relative; margin-left:2%;" class="aaa">
      <div style="position:absolute; top:-12px; left:15px; background:#fff; padding:0 8px; font-weight:bold;">
        First Party (Recruitment Office) / الطرف الأول
      </div>
      <p style="margin:10px 0; font-size:12px;">
        <span style="display:inline-block; width:20%; font-weight:bold; margin-right:5px;">Name:</span>
        <span style="display:inline-block; width:100%; border-bottom:1px solid #000; margin-top:5px;">
          ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER
        </span>
      </p>
      <p style="margin:10px 0; font-size:12px;">
        <span style="display:inline-block; width:20%; font-weight:bold; margin-right:5px;">Signature:</span>
        <span style="display:inline-block; width:100%; border-bottom:1px solid #000; margin-top:5px;"></span>
      </p>
      <p style="margin:10px 0; font-size:12px;">
        <span style="display:inline-block; width:20%; font-weight:bold; margin-right:5px;">Date:</span>
        <span style="display:inline-block; width:100%; border-bottom:1px solid #000; margin-top:5px;"></span>
      </p>
    </div>
    <div style="clear:both;"></div>
  </div>
  <img src="{{ asset('assets/img/' . $footerFileName) }}" style="width:100%">
</body>
</html>
