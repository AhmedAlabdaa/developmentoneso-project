@php
use Carbon\Carbon;
use Illuminate\Support\Str;

$subdomain      = explode('.', request()->getHost())[0] ?? 'default';
$headerFileName = asset('assets/img/' . strtolower($subdomain) . '_header.jpg');
$footerFileName = asset('assets/img/' . strtolower($subdomain) . '_footer.jpg');

$agr = $contract->agreement;

$agreementStart = $agr->agreement_start_date
    ? Carbon::parse($agr->agreement_start_date)->format('d-m-Y')
    : '';

$agreementEnd = $agr->agreement_end_date
    ? Carbon::parse($agr->agreement_end_date)->format('d-m-Y')
    : '';

$monthly     = $agr->monthly_payment  ?? 0;
$totalAmount = $agr->monthly_payment ?: ($agr->total_amount ?? 0);
$received    = $agr->received_amount  ?? 0;
$remaining   = max(0, $totalAmount - $received);

if ($monthly > 0) {
    $clauseEn = "The contract is valid from {$agreementStart} to {$agreementEnd}. "
              . "The total contract value is " . number_format($totalAmount, 2) . " AED. ";

    $clauseAr = "تسري هذه الاتفاقية من {$agreementStart} إلى {$agreementEnd}. "
              . "قيمة العقد الإجمالية " . number_format($totalAmount, 2) . " درهم. "
              . "يُقر الطرف الأول باستلام مبلغ مقدّم قدره " . number_format($received, 2) . " درهم، ";
} else {
    if ($remaining === 0) {
        $clauseEn = "The contract is valid from {$agreementStart} to {$agreementEnd}. "
                  . "The total contract value of " . number_format($totalAmount, 2) . " AED has been paid in full on signing.";

        $clauseAr = "تسري هذه الاتفاقية من {$agreementStart} إلى {$agreementEnd}. "
                  . "قيمة العقد الإجمالية " . number_format($totalAmount, 2) . " درهم مدفوعة بالكامل عند التوقيع.";
    } else {
        $clauseEn = "The contract is valid from {$agreementStart} to {$agreementEnd}. "
                  . "The total contract value is " . number_format($totalAmount, 2) . " AED. ";

        $clauseAr = "تسري هذه الاتفاقية من {$agreementStart} إلى {$agreementEnd}. "
                  . "قيمة العقد الإجمالية " . number_format($totalAmount, 2) . " درهم. ";
    }
}

@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $contract->reference_no }}</title>
    <style>
        body{margin:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px}
        table{width:100%;border-collapse:collapse}
        th,td{border:1px solid #000;padding:8px;text-align:center;vertical-align:middle}
        .dotted td{border-style:dotted}
        .rotate90{transform:rotate(90deg);white-space:nowrap;font-weight:bold}
        .rotate-90{transform:rotate(-90deg);white-space:nowrap;font-weight:bold}
        .sig{width:44%;border:2px solid #000;padding:15px;position:relative}
        .title-box{position:absolute;top:12px;left:15px;background:#fff;padding:0 8px;font-weight:bold}
        .clear{clear:both}
    </style>
</head>
<body>

<img src="{{ $headerFileName }}" style="width:100%">

<table class="dotted" style="margin:20px 0">
    <tr>
        <td>{{ Carbon::parse($contract->created_at)->format('d/m/Y') }}</td>
        <td>
            <strong>Domestic Worker Contract</strong><br>
            <strong>عقد استقدام عامل مساعد</strong>
        </td>
        <td>Contract&nbsp;No.<br><strong>رقم الاتفاقية</strong></td>
        <td style="font-weight:bold">{{ $contract->reference_no }}</td>
    </tr>
</table>

<table>
    <tr>
        <td>{{ $contract->client->first_name }} {{ $contract->client->last_name }}</td>
        <td><strong>اسم صاحب العمل<br>SPONSOR NAME</strong></td>
        <td rowspan="8"><span class="rotate90">SECOND&nbsp;PARTY<br>الطرف&nbsp;الثاني</span></td>
        <td>AL&nbsp;EBDAA&nbsp;DOMESTIC&nbsp;WORKERS&nbsp;CENTRE</td>
        <td><strong>مكتب الاستقدام<br>Tadbeer Center</strong></td>
        <td rowspan="3"><span class="rotate-90">FIRST&nbsp;PARTY<br>الطرف&nbsp;الأول</span></td>
    </tr>
    <tr>
        <td>{{ $contract->client->emirates_id }}</td>
        <td><strong>رقم الهوية<br>ID NUMBER</strong></td>
        <td>800&nbsp;32332</td>
        <td><strong>رقم الهاتف<br>Phone</strong></td>
    </tr>
    <tr>
        <td>{{ $contract->client->address }}</td>
        <td><strong>العنوان<br>ADDRESS</strong></td>
        <td>AL&nbsp;GARHOUD,&nbsp;DUBAI,&nbsp;UAE</td>
        <td><strong>العنوان<br>Address</strong></td>
    </tr>
    <tr>
        <td>{{ $contract->client->nationality }}</td>
        <td><strong>الجنسية<br>NATIONALITY</strong></td>
        <td>
          {{ $contract->replaced_by_name ?: $agr->candidate_name }}
        </td>
        <td><strong>اسم العامل<br>Name</strong></td>
        <td rowspan="4"><strong>العامل المساعد<br>Domestic worker</strong></td>
    </tr>
    <tr>
        <td>{{ $contract->client->mobile }}</td>
        <td><strong>رقم الهاتف<br>PHONE</strong></td>
        <td>{{ $agr->passport_no }}</td>
        <td><strong>رقم جواز السفر<br>Passport</strong></td>
    </tr>
    <tr>
        <td>{{ $contract->client->state ?? '' }}</td>
        <td><strong>الإمارة<br>EMIRATE</strong></td>
        <td>{{ $agr->Nationality->name ?? $agr->nationality }}</td>
        <td><strong>الجنسية<br>Nationality</strong></td>
    </tr>
    <tr>
        <td>{{ $agreementStart }}</td>
        <td><strong>تاريخ البدء<br>Start&nbsp;Date</strong></td>
        <td>{{ $agreementEnd }}</td>
        <td><strong>تاريخ الانتهاء<br>End&nbsp;Date</strong></td>
    </tr>
</table>

<div style="width:100%;margin:20px 0;overflow:auto">
    <div style="float:left;width:47%">
        <p style="margin:0;text-align:left"><strong>Article&nbsp;1 – Financial Terms</strong><br>{{ $clauseEn }}</p>
    </div>
    <div style="float:left;width:47%;margin-left:2%">
        <p style="margin:0;direction:rtl;text-align:right"><strong>البند&nbsp;الأول – الشروط المالية</strong><br>{{ $clauseAr }}</p>
    </div>
</div>
<div class="clear"></div>

<div style="width:100%;margin:20px 0;overflow:auto">
    <div style="float:left;width:47%">
        <p style="margin:0;text-align:left"><strong>Article 2: Probation Period</strong><br>The worker will undergo a six-month probation period starting on the first working day.</p>
    </div>
    <div style="float:left;width:47%;margin-left:2%">
        <p style="margin:0;direction:rtl;text-align:right"><strong>البند الثاني: فترة التجربة</strong><br>يوضع العامل تحت التجربة لمدة ستة أشهر ابتداءً من أول يوم عمل.</p>
    </div>
</div>
<div class="clear"></div>

<div style="width:100%;margin:20px 0;overflow:auto">
    <div style="float:left;width:47%">
        <p style="margin:0;text-align:left"><strong>Article 3: Obligations of the First Party (Recruitment Office)</strong><br>The Office shall supply a worker within 30 days of entry-permit issuance, complete the medical examination within 30 days before recruitment, and charge no fees beyond those approved by the Ministry. The Office must accept the worker’s return in the event of a dispute.</p>
    </div>
    <div style="float:left;width:47%;margin-left:2%">
        <p style="margin:0;direction:rtl;text-align:right"><strong>البند الثالث: التزامات الطرف الأول</strong><br>يتعهد المكتب بتوفير عامل خلال 30 يوماً من إصدار إذن الدخول، وإجراء الفحص الطبي خلال 30 يوماً قبل الاستقدام، وعدم تحصيل أي رسوم إضافية غير المعتمدة من الوزارة، مع استلام العامل في حال حدوث خلاف.</p>
    </div>
</div>
<div class="clear"></div>

<div style="width:100%;margin:20px 0;overflow:auto">
    <div style="float:left;width:47%">
        <p style="margin:0;text-align:left"><strong>Article 4: Obligations of the Second Party (Employer)</strong><br>The Employer shall pay government fees, finalise residency procedures, provide accommodation, meals and healthcare, grant a weekly day-off, and report any absence within five days. All dues must be cleared at contract end.</p>
    </div>
    <div style="float:left;width:47%;margin-left:2%">
        <p style="margin:0;direction:rtl;text-align:right"><strong>البند الرابع: التزامات الطرف الثاني</strong><br>يلتزم صاحب العمل بدفع الرسوم الحكومية، وإنهاء إجراءات إقامة العامل، وتوفير السكن والوجبات والرعاية الطبية، ومنح يوم راحة أسبوعي، وإبلاغ الوزارة عن الانقطاع خلال خمسة أيام، وسداد المستحقات عند انتهاء العقد.</p>
    </div>
</div>
<div class="clear"></div>

<!-- <div style="width:100%;margin:20px 0;overflow:auto">
  <div style="float:left;width:47%">
    <p style="margin:0;text-align:left">
      <strong>Article 5: First-Party Liability during Probation</strong><br>
      Within the first month, the office shall refund the full fee if the Worker is professionally incompetent, absconds, or refuses to work. In cases where the Worker is declared medically unfit the office shall refund the full fee plus the goverment fees. from the sencond month until the end of the probation, the refind is calculated proportionally based on the remaining probation duration and in accordance with Tadbeer regulations.
    </p>
  </div>
  <div style="float:left;width:47%;margin-left:2%">
    <p style="margin:0;direction:rtl;text-align:right">
      <strong>البند الخامس: مسؤولية الطرف الأول خلال فترة التجربة</strong><br>
       في حالة انتفاء الكفاءة المهنية للعامل او هروبه او رفضه العمل خلال الشهر الاول يلتزم المكتب برد كامل رسوم الاستقدام.  بالإضافة الى رد كامل المبلغ زائد الرسوم الحكومية في حال ثبتت عدم لياقة العامل طبيا.

ابتداء من الشهر الثاني حتى نهاية فترة التجربة يتم رد جزء من مبلغ الاستقدام.
    </p>
  </div>
</div> -->
<div style="width:100%;margin:20px 0;overflow:auto">
    <div style="float:left;width:47%">
        <p style="margin:0;text-align:left"><strong>Note:</strong> The first Party hereby acknowledges that the warranty period provided for the worker is two (2) years from the official commencement date of employment.In accordance with Mohre laws, if the worker absconds or refuses to work after the six (6)month probation period, the Second Party shall be entitled to request a refund under the approved terms.</p>
    </div>
    <div style="float:left;width:47%;margin-left:2%">
        <p style="margin:0;direction:rtl;text-align:right"><strong>ملاحظة:</strong>

        يقر الطرف الاول بان مدة الضمان المقدمة هي سنتان (24 شهرا) من تاريخ مباشرة العمل.ووفقا لقوانين الموارد البشرية  في حالة 
        هروب العاملة او رفضها العمل بعد فترة التجربة(6 اشهر) يحق للطرف الثاني طلب الاسترجاع وفق الشروط المعتمدة 
        </p>
    </div>
</div>

<div class="clear"></div>

<div style="width:100%;margin:20px 0;overflow:auto">
    <div style="float:left;width:47%">
        <p style="margin:0;text-align:left"><strong>Article 6: Refund Formula</strong><br>Refund = (Total recruitment cost ÷ contract months) × remaining months. Payment is due within 14 working days of the worker’s return or absence report.</p>
    </div>
    <div style="float:left;width:47%;margin-left:2%">
        <p style="margin:0;direction:rtl;text-align:right"><strong>البند السادس: آلية الاسترداد</strong><br>قيمة الاسترداد = (تكلفة الاستقدام ÷ مدة العقد بالشهر) × المدة المتبقية. يلتزم المكتب بالسداد خلال 14 يوم عمل من تاريخ رجوع العامل أو الإبلاغ عن انقطاعه.</p>
    </div>
</div>
<div class="clear"></div>

<div style="width:100%;margin:20px 0;overflow:auto">
    <div style="float:left;width:47%">
        <p style="margin:0;text-align:left"><strong>Article 7: Jurisdiction</strong><br>Disputes are referred first to the Ministry; if unresolved, the competent court shall decide under Federal Decree-Law 9-2022 on auxiliary workers.</p>
    </div>
    <div style="float:left;width:47%;margin-left:2%">
        <p style="margin:0;direction:rtl;text-align:right"><strong>البند السابع: الاختصاص القضائي</strong><br>تُحال الخلافات أولاً إلى الوزارة، وإذا تعذّر حلها تُعرض على المحكمة المختصة طبقاً لمرسوم بقانون اتحادي 9 لسنة 2022 بشأن عمال الخدمة المساعدة.</p>
    </div>
</div>
<div class="clear"></div>

<div style="width:100%;margin:20px 0;overflow:auto">
    <div style="float:left;width:47%">
        <p style="margin:0;text-align:left"><strong>Article 8: Copies of the Contract</strong><br>This Contract is issued in three copies: one for each Party and one filed with the Ministry.</p>
    </div>
    <div style="float:left;width:47%;margin-left:2%">
        <p style="margin:0;direction:rtl;text-align:right"><strong>البند الثامن: نسخ العقد</strong><br>حُرر هذا العقد من ثلاث نسخ؛ نسخة لكل طرف ونسخة تودع لدى الوزارة.</p>
    </div>
</div>
<div class="clear"></div>

<div style="margin:30px 0;overflow:auto">
    <div class="sig" style="float:left">
        <span class="title-box">SECOND PARTY (Employer) / الطرف الثاني</span>
        <p><strong>Name&nbsp;:</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">{{ $contract->client->first_name }} {{ $contract->client->last_name }}</span></p>
        <p><strong>Signature&nbsp;:</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">&nbsp;</span></p>
        <p><strong>Date&nbsp;:</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">&nbsp;</span></p>
    </div>
    <div class="sig" style="float:left;margin-left:2%">
        <span class="title-box">FIRST PARTY (Recruitment Office) / الطرف الأول</span>
        <p><strong>Name&nbsp;:</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">ALEBDAA WORKERS EMPLOYMENT SERVICES CENTRE</span></p>
        <p><strong>Signature&nbsp;:</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">&nbsp;</span></p>
        <p><strong>Date&nbsp;:</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">&nbsp;</span></p>
    </div>
</div>
<div class="clear"></div>

<img src="{{ $footerFileName }}" style="width:100%">
</body>
</html>
