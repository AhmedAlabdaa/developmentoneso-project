<?php
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
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Agreement</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    @page { size: A4; margin: 5mm; }
    body { font-family: 'Arial', sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; font-size: 12px; line-height: 1.5; }
    .contract-container { width: 210mm; max-width: 210mm; margin: auto; background: #fff; padding: 5mm; border: 1px solid #ddd; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
    .header, .footer { text-align: center; margin: 0; padding: 0; }
    .header img, .footer img { max-width: 100%; height: auto; }
    .table-container { width: 100%; border-collapse: collapse; margin-bottom: 20px; background-color: #21ace0; }
    .table-container td { padding: 10px; text-align: center; }
    .solid-table-container { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .solid-table-container td { border: 1px solid #000; padding: 10px; text-align: center; }
    .vertical-text { writing-mode: vertical-rl; transform: rotate(180deg); font-weight: bold; }
    .rtl { direction: rtl; }
    .terms-container { margin-bottom: 20px; }
    .terms { display: flex; justify-content: space-between; margin-bottom: 15px; align-items: flex-start; }
    .terms ul { width: 48%; padding-left: 20px; }
    .terms ul li { list-style-type: disc; margin-bottom: 10px; }
    .signature-section { display: flex; justify-content: space-between; margin-top: 30px; }
    .signature-box { flex: 1; border: 2px solid #000; padding: 20px; text-align: left; position: relative; margin-right: 10px; }
    .signature-box:last-child { margin-right: 0; }
    .signature-title { position: absolute; top: -12px; left: 20px; background: #fff; padding: 0 10px; font-weight: bold; }
    .signature-line { border-bottom: 1px solid #000; display: inline-block; width: 80%; margin: 5px 0; }
    .button-container { text-align: center; margin-bottom: 20px; }
    .button-container a { display: inline-block; margin: 0 10px; padding: 10px 20px; text-decoration: none; color: #fff; border-radius: 4px; font-size: 14px; }
    .btn-download { background-color: #28a745; }
    .btn-back { background-color: #6c757d; }
    @media print { body { background-color: #fff; } .contract-container { box-shadow: none; border: none; margin: 0; padding: 0; } }
  </style>
</head>
<body>
  <div class="contract-container">
    <div class="button-container">
      <a href="<?php echo e(route('download.agreement', $agreement->reference_no)); ?>" class="btn-download">
        <i class="bi bi-download"></i> Download Agreement
      </a>
      <a href="<?php echo e(route('agreements.index')); ?>" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to Agreements
      </a>
    </div>
    <div class="header">
      <img src="<?php echo e(asset('assets/img/' . $headerFileName)); ?>" alt="Header Image">
    </div>
    <table class="table-container">
      <tr>
        <td><?php echo e($createdAt); ?></td>
        <td>
          <strong>(الباقة المرنة) اتفاقية تشغيل عامل مساعد</strong><br>
          Domestic Worker Agreement (Flexible package)
        </td>
        <td><?php echo e($agreement->reference_no); ?></td>
        <td><strong>Agreement Number<br>اتفاقية رقم</strong></td>
      </tr>
    </table>
    <table class="solid-table-container">
      <tr>
        <td><?php echo e($agreement->client->first_name ?? ''); ?> <?php echo e($agreement->client->last_name ?? ''); ?></td>
        <td><strong>اسم العميل<br>CUSTOMER NAME</strong></td>
        <td rowspan="7" class="vertical-text">Second Party الطرف الثاني</td>
        <td>ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER</td>
        <td><strong>مكتب الاستقدام<br>Tadbeer Center</strong></td>
        <td rowspan="3" class="vertical-text">الطرف الأول<br>First Party</td>
      </tr>
      <tr>
        <td><?php echo e($agreement->client->emirates_id ?? ''); ?></td>
        <td><strong>رقم الهوية<br>ID NUMBER</strong></td>
        <td><?php echo e($agreement->client->mobile ?? ''); ?></td>
        <td><strong>رقم الهاتف<br>Phone Number</strong></td>
      </tr>
      <tr>
        <td><?php echo e($agreement->client->address ?? ''); ?></td>
        <td><strong>العنوان<br>ADDRESS</strong></td>
        <td>AL GARHOUD, DUBAI, UAE</td>
        <td><strong>العنوان<br>Address</strong></td>
      </tr>
      <tr>
        <td><?php echo e($agreement->passport_no); ?></td>
        <td><strong>رقم الجواز<br>PASSPORT NUMBER</strong></td>
        <td><?php echo e($agreement->client->email ?? ''); ?></td>
        <td><strong>البريد الإلكتروني<br>Email</strong></td>
        <td rowspan="4" class="vertical-text">العامل المساعد<br>Domestic Worker</td>
      </tr>
      <tr>
        <td><?php echo e($agreement->client->nationality ?? $agreement->nationality); ?></td>
        <td><strong>الجنسية<br>NATIONALITY</strong></td>
        <td><?php echo e($agreement->candidate_name); ?></td>
        <td><strong>اسم العامل<br>Name</strong></td>
      </tr>
      <tr>
        <td><?php echo e($agreement->client->mobile ?? ''); ?></td>
        <td><strong>رقم الهاتف<br>PHONE NUMBER</strong></td>
        <td><?php echo e($agreement->passport_no); ?></td>
        <td><strong>رقم جواز السفر<br>Passport</strong></td>
      </tr>
      <tr>
        <td><?php echo e($agreement->client->email ?? ''); ?></td>
        <td><strong>البريد الإلكتروني<br>EMAIL</strong></td>
        <td><?php echo e($agreement->nationality ?? ''); ?></td>
        <td><strong>الجنسية<br>Nationality</strong></td>
      </tr>
      <tr>
        <td><input type="text" value="<?php echo e(\Carbon\Carbon::parse($agreement->agreement_start_date)->format('d-m-Y')); ?>"></td>
        <td><strong>تاريخ بدء الاتفاقية<br>Agreement&nbsp;Start&nbsp;Date</strong></td>
        <td><input type="text" value="<?php echo e(\Carbon\Carbon::parse($agreement->agreement_end_date)->format('d-m-Y')); ?>"></td>
        <td><strong>تاريخ انتهاء الاتفاقية<br>Agreement&nbsp;End&nbsp;Date</strong></td>
      </tr>
    </table>
    <div class="terms-container">
      <div class="terms">
        <ul>
          <li style="list-style: none;"><strong>Agreement Introduction:</strong></li>
          <li>The First Party commits to providing a domestic helper service under its sponsorship, handling the work permit and residency for the domestic helper for two years in exchange for an upfront fee of <?php echo e($totalAmount); ?> AED.</li>
          <li>The parties agree that the duration of this contract shall extend from the date <?php echo e($agreementStartDate); ?> to <?php echo e($agreementToDate); ?>.</li>
          <li>The first party is responsible for completing procedures related to the employment contract, work card, visa issuance, status adjustment, medical examination, ID, and residency of the domestic worker.</li>
          <li>The first party shall deposit the domestic worker’s salary monthly through the Wage Protection System.</li>
          <li>The second party shall pay the agreed-upon office fees monthly throughout the contract period.</li>
          <li>Payments are to be made via checks deposited in advance with the first party for the contract duration, or through bank transfer or cash payment at the center.</li>
          <li>In case of delayed payment by the second party, necessary legal actions will be taken, including the use of guarantee checks.</li>
          <li>If a guarantee check is used, the second party must replace it immediately to continue benefiting from the agreement.</li>
          <li>The second party undertakes to transport the worker to and from the center for medical examinations or ID fingerprinting appointments.</li>
          <li>The second party commits to ensuring the worker receives their salary deposited by the first party through the exchange office.</li>
          <li>In cases of worker absconding or refusal to work, the second party shall inform the first party within a maximum of 5 working days, and the first party shall provide a replacement worker within 48 hours. If not possible, the second party has the right to cancel the contract.</li>
          <li>If the second party wishes to terminate this agreement, it must formally notify the first party one month prior to the cancellation date, or in case of immediate termination, pay the month’s fees in cash.</li>
          <li>The first party commits to providing health insurance for the worker, and the second party ensures the worker receives medical care throughout their employment.</li>
          <li>The worker enjoys all labor rights guaranteed by UAE labor law, works for the second party on a secondment basis, and resides with the second party by mutual agreement.</li>
          <li>The second party commits to employing the worker in the agreed-upon specialty according to state laws and providing adequate housing and suitable living conditions.</li>
          <li>If the worker travels with the employer outside the country, the second party must inform the first party, receive a travel approval letter, and deposit a guarantee check, the amount to be determined later based on the contract duration and the worker’s nationality.</li>
          <li>Both parties commit to complying with all terms and conditions of this agreement.</li>
          <li>This agreement automatically terminates at the end of its specified duration unless extended under the stipulated terms.</li>
          <li>The phone number and email address mentioned in this agreement are the official channels of communication. Proof of sending notifications is considered sufficient.</li>
          <li>For any matters not addressed in this contract, the provisions of Federal Law No. (10) of 2017 concerning domestic workers, its executive regulations, and other relevant legal frameworks issued by the Ministry of Human Resources and Emiratisation shall apply. The courts of the UAE have jurisdiction over any disputes related to this contract.</li>
          <li>Without prejudice to the ministry's right to take legal actions against the breaching party, in case of a dispute, the ministry shall be approached to resolve the issue amicably and take appropriate actions.</li>
        </ul>
        <ul class="rtl">
          <li style="list-style: none;"><strong>مقدمة الاتفاقية:</strong></li>
          <li>يتعهد الطرف الأول بتقديم خدمة مساعد منزلي تحت كفالته، ويتولى تصريح العمل والإقامة للعامل المساعد لمدة سنتين مقابل رسوم مسبقة بمبلغ <?php echo e($totalAmount); ?> درهم إماراتي.</li>
          <li>يتفق الطرفان على أن مدة هذا العقد تمتد من التاريخ <?php echo e($agreementStartDate); ?> إلى <?php echo e($agreementToDate); ?>.</li>
          <li>يتعهد الطرف الأول بإتمام الإجراءات المتعلقة بعقد العمل، بطاقة العمل، إصدار التأشيرة، تعديل الوضع، الفحص الطبي، الهوية والإقامة للعامل المساعد.</li>
          <li>يلتزم الطرف الأول بإيداع راتب العامل المساعد شهريًا من خلال نظام حماية الأجور.</li>
          <li>يلتزم الطرف الثاني بدفع الرسوم المكتبية المتفق عليها شهريًا طوال مدة العقد.</li>
          <li>يتم سداد المدفوعات عن طريق الشيكات المودعة مسبقًا لدى الطرف الأول لمدة العقد، أو من خلال التحويل البنكي أو الدفع النقدي في المركز.</li>
          <li>في حالة تأخر الطرف الثاني في الدفع، سيتم اتخاذ الإجراءات القانونية اللازمة، بما في ذلك استخدام الشيكات الضامنة.</li>
          <li>في حال استخدام شيك ضمان، يجب على الطرف الثاني استبداله فورًا للاستمرار في الاستفادة من الاتفاقية.</li>
          <li>يتعهد الطرف الثاني بنقل العامل من وإلى المركز لإجراء الفحوصات الطبية أو مواعيد أخذ بصمات الهوية.</li>
          <li>يتعهد الطرف الثاني بضمان استلام العامل لرواتبه المودعة لدى الطرف الأول من خلال مكتب الصرافة.</li>
          <li>في حالة هروب العامل أو رفضه العمل، يلتزم الطرف الثاني بإبلاغ الطرف الأول بحد أقصى 5 أيام عمل، ويتعهد الطرف الأول بتوفير عامل بديل خلال 48 ساعة، وإلا يحق للطرف الثاني إلغاء العقد.</li>
          <li>إذا رغب الطرف الثاني في إنهاء الاتفاقية، يجب إخطار الطرف الأول رسميًا قبل شهر من تاريخ الإلغاء، أو في حالة الإنهاء الفوري، دفع الرسوم الشهرية نقدًا.</li>
          <li>يلتزم الطرف الأول بتوفير تأمين صحي للعامل، ويتعهد الطرف الثاني بضمان تلقي العامل الرعاية الطبية طوال مدة عمله.</li>
          <li>يتمتع العامل بجميع الحقوق العمالية التي يكفلها قانون العمل الإماراتي، ويعمل لدى الطرف الثاني على أساس الإعارة، ويقيم معه باتفاق متبادل.</li>
          <li>يتعهد الطرف الثاني بتشغيل العامل في التخصص المتفق عليه وفقًا لقوانين الدولة، وتوفير سكن مناسب وظروف معيشية ملائمة.</li>
          <li>إذا سافر العامل مع صاحب العمل خارج الدولة، يجب على الطرف الثاني إخطار الطرف الأول، والحصول على رسالة موافقة السفر، وإيداع شيك ضمان، وسيتم تحديد المبلغ لاحقًا بناءً على مدة العقد وجنسية العامل.</li>
          <li>يلتزم الطرفان بالامتثال لجميع الشروط والأحكام المنصوص عليها في هذه الاتفاقية.</li>
          <li>تنتهي هذه الاتفاقية تلقائيًا عند انتهاء مدتها المحددة ما لم يتم تمديدها وفقًا للشروط المتفق عليها.</li>
          <li>الرقم الهاتفي وعنوان البريد الإلكتروني المذكوران في هذه الاتفاقية هما القنوات الرسمية للتواصل، ويُعتبر إثبات الإشعارات المرسلة كافيًا.</li>
          <li>فيما لم ينص عليه هذا العقد، تسري أحكام القانون الاتحادي رقم (10) لسنة 2017 بشأن عمال الخدمة المساعدة، ولائحته التنفيذية، وباقي الأنظمة القانونية الصادرة عن وزارة الموارد البشرية والتوطين، وتكون محاكم الإمارات هي المختصة بأي نزاع يتعلق بهذا العقد.</li>
          <li>دون المساس بحق الوزارة في اتخاذ الإجراءات القانونية ضد الطرف المخالف، في حالة نشوب خلاف بين الطرفين، يجب اللجوء إلى الوزارة لتسوية الموضوع وديًا واتخاذ الإجراءات المناسبة.</li>
        </ul>
      </div>
    </div>
    <div class="signature-section">
      <div class="signature-box">
        <div class="signature-title">Second Party (Employer) / الطرف الثاني (صاحب العمل)</div>
        <p>Name: <span class="signature-line"><?php echo e($agreement->client->first_name ?? ''); ?> <?php echo e($agreement->client->last_name ?? ''); ?></span></p>
        <p>Signature: <span class="signature-line"></span></p>
        <p>Date: <span class="signature-line"></span></p>
      </div>
      <div class="signature-box">
        <div class="signature-title">First Party (Recruitment Office) / الطرف الأول (مكتب الاستقدام)</div>
        <p>Name: <span class="signature-line">ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER</span></p>
        <p>Signature: <span class="signature-line"></span></p>
        <p>Date: <span class="signature-line"></span></p>
      </div>
    </div>
    <div class="footer">
      <img src="<?php echo e(asset('assets/img/' . $footerFileName)); ?>" alt="Footer Image">
    </div>
  </div>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/agreements/package1_agreement.blade.php ENDPATH**/ ?>