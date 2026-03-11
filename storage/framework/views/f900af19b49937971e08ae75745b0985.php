
<?php
use Carbon\Carbon;
$agreement        = $contract->agreement;
$serverName       = $_SERVER['SERVER_NAME'] ?? '';
$subdomain        = explode('.', $serverName)[0];
$headerFileName   = strtolower($subdomain) . '_header.jpg';
$footerFileName   = strtolower($subdomain) . '_footer.jpg';
$createdAt        = $agreement->created_at
                     ? Carbon::parse($agreement->created_at)->format('d M Y')
                     : '';
$agreementStart   = $agreement->agreement_start_date
                     ? Carbon::parse($agreement->agreement_start_date)->format('d M Y')
                     : '';
$agreementEnd     = $agreement->agreement_end_date
                     ? Carbon::parse($agreement->agreement_end_date)->format('d M Y')
                     : '';
$packageLabelAr = [
    'PKG-2'  => 'الباقة الثابتة',
    'PKG-3'  => 'الباقة المرنة',
    'PKG-4'  => 'الباقة 4',
    'TRIAL'  => 'اتفاقية تجريبية',
][$contract->package] ?? $contract->package;
$packageLabelEn = [
    'PKG-2'  => 'Fixed Package',
    'PKG-3'  => 'Flexible Package',
    'PKG-4'  => 'Package 4',
    'TRIAL'  => 'Trial Contract',
][$contract->package] ?? $contract->package;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Contract of <?php echo e($profile->first_name); ?> <?php echo e($profile->last_name); ?></title>
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 0; font-size: 12px; line-height: 1.5; }
    .contract-container { margin: auto; background: #fff; padding: 5mm; border: 1px solid #ddd; }
    .header, .footer { text-align: center; }
    .table-container { width: 100%; border-collapse: collapse; margin-bottom: 20px; background-color: #21ace0; }
    .table-container td { padding: 10px; text-align: center; }
    .table-container input { width: 90%; padding: 5px; font-size: 12px; border: 1px solid #ccc; border-radius: 3px; background: transparent; pointer-events: none; }
    .solid-table-container { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .solid-table-container td { border: 1px solid #000; padding: 10px; text-align: center; }
    .solid-table-container input { width: 90%; padding: 5px; font-size: 12px; border: 1px solid #ccc; border-radius: 3px; background: transparent; pointer-events: none; }
    .vertical-text { writing-mode: vertical-rl; transform: rotate(180deg); font-weight: bold; }
    .rtl { direction: rtl; }
    .terms-container { margin-bottom: 20px; }
    .terms { display: flex; justify-content: space-between; }
    .terms ul { width: 48%; padding-left: 20px; }
    .terms ul li { list-style-type: disc; margin-bottom: 10px; }
    .signature-placeholder { width: 300px; height: 40px; background: #ccc; margin: 0 auto; }
    .page-break { page-break-before: always; }
    .ref { margin-bottom: 20px; font-weight: bold; text-align: left; }
    .title-ar, .title-en { text-align: center; margin: 5px 0; color: #1F4E79; }
    .title-ar { font-size: 18px; }
    .title-en { font-size: 16px; }
    .history_table { width: 100%; border-collapse: collapse; margin: 20px 0; direction: ltr; }
    .history_table th, td { border: 1px solid #000; padding: 8px; }
    .history_table th { background: #fff; font-weight: bold; }
    .history_table td { background: #fff; text-align: center; height: 40px; }
    .signatures-title { text-align: center; margin: 30px 0 10px; color: #1F4E79; font-size: 16px; }
    .date { margin: 10px 0 30px; }
    .sig-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
    .sig-block { line-height: 1.6; }
    .sig-block h4 { margin: 0 0 10px; font-size: 14px; }
    .sig-block label { display: inline-block; width: 100%; }
    .sig-block .field { display: inline-block; width: calc(100% - 100px); border-bottom: 1px solid #000; }
    @media print {
      body { background: #fff; }
      .contract-container { box-shadow: none; border: none; margin: 0; padding: 0; }
    }
  </style>
</head>
<body>
  <div class="contract-container">
    <div class="header">
      <img src="<?php echo e(asset('assets/img/' . $headerFileName)); ?>" alt="Header Image">
    </div>
    <table class="table-container">
      <tr>
        <td><input type="text" value="<?php echo e($createdAt); ?>"></td>
        <td><strong>(<?php echo e($packageLabelAr); ?>) اتفاقية تشغيل عامل مساعد<br>Domestic Worker Contract (<?php echo e($packageLabelEn); ?>)</strong></td>
        <td><input type="text" readonly value="<?php echo e($contract->reference_no); ?>"></td>
        <td><strong>Contract Number<br>اتفاقية رقم</strong></td>
      </tr>
    </table>
    <table class="solid-table-container">
      <tr>
        <td><input type="text" value="<?php echo e($agreement->client->first_name); ?> <?php echo e($agreement->client->last_name); ?>"></td>
        <td><strong>اسم صاحب العمل<br>SPONSER NAME</strong></td>
        <td rowspan="8" class="vertical-text">الطرف الثاني<br>Second Party</td>
        <td><input type="text" value="مركز الإبداع لخدمات العمالة المساعدة"></td>
        <td><strong>مكتب الاستقدام<br>Tadbeer Center</strong></td>
        <td rowspan="3" class="vertical-text">الطرف الأول<br>First Party</td>
      </tr>
      <tr>
        <td><input type="text" value="<?php echo e($agreement->client->emirates_id); ?>"></td>
        <td><strong>رقم الهوية<br>ID NUMBER</strong></td>
        <td><input type="text" value="800-32332"></td>
        <td><strong>رقم الهاتف<br>Phone Number</strong></td>
      </tr>
      <tr>
        <td><input type="text" value="<?php echo e($agreement->client->address); ?>"></td>
        <td><strong>العنوان<br>ADDRESS</strong></td>
        <td><input type="text" value="القرهود - دبي"></td>
        <td><strong>العنوان<br>Address</strong></td>
      </tr>
      <tr>
        <td><input type="text" value="<?php echo e($agreement->client->passport_number); ?>"></td>
        <td><strong>رقم الجواز<br>PASSPORT NUMBER</strong></td>
        <td><input type="text" value="admin@tadbeer-alebdaa.com"></td>
        <td><strong>البريد الإلكتروني<br>Email</strong></td>
        <td rowspan="5" class="vertical-text">العامل المساعد<br>Domestic Worker</td>
      </tr>
      <tr>
        <td><input type="text" value="<?php echo e($agreement->client->nationality); ?>"></td>
        <td><strong>الجنسية<br>NATIONALITY</strong></td>
        <td>
          <?php echo e($contract->replaced_by_name ?: $agreement->candidate_name); ?>

        </td>
        <td><strong>اسم العامل<br>Name</strong></td>
      </tr>
      <tr>
        <td><input type="text" value="<?php echo e($agreement->client->mobile); ?>"></td>
        <td><strong>رقم الهاتف<br>PHONE NUMBER</strong></td>
        <td><input type="text" value="<?php echo e($agreement->passport_no); ?>"></td>
        <td><strong>رقم جواز السفر<br>Passport</strong></td>
      </tr>
      <tr>
        <td><input type="text" value="<?php echo e($agreement->client->email); ?>"></td>
        <td><strong>البريد الإلكتروني<br>EMAIL</strong></td>
        <td><input type="text" value="<?php echo e($agreement->Nationality->name ?? $agreement->nationality); ?>"></td>
        <td><strong>الجنسية<br>Nationality</strong></td>
      </tr>
      <tr>
        <td><input type="text" value="<?php echo e(Carbon::parse($agreement->agreement_start_date)->format('d-m-Y')); ?>"></td>
        <td><strong>تاريخ بدء الاتفاقية<br>Agreement Start Date</strong></td>
        <td><input type="text" value="<?php echo e(Carbon::parse($agreement->agreement_end_date)->format('d-m-Y')); ?>"></td>
        <td><strong>تاريخ انتهاء الاتفاقية<br>Agreement End Date</strong></td>
      </tr>
    </table>
    <div class="terms-container">
      <div class="terms">
        <ul>
          <li style="list-style: none;"><strong>Contract Introduction:</strong></li>
          <li>The First Party commits to providing a domestic helper service under the sponsorship of the First Party, who will handle the work permit and residency for the domestic helper for a certian period in exchange for an upfront fee agreed upon as: <strong><?php echo e($totalAmt); ?> AED</strong>.</li>
          <li>The parties agree that the duration of this contract shall extend from the date <strong><?php echo e($agreementStart); ?></strong> to <strong><?php echo e($agreementEnd); ?></strong>.</li>
          <li>The first party is responsible for completing procedures related to the employment contract/work card/visa issuance/status adjustment/medical examination/ID and residence of the domestic worker.</li>
          <li>The first party shall deposit the domestic worker’s salary monthly through the Wage Protection System.</li>
          <!-- <li>The second party shall pay the agreed-upon office fees monthly throughout the contract period.</li> -->
          <li>Payments are to be made via checks deposited in advance with the first party for the contract duration, or through bank transfer or cash payment at the center.</li>
          <li>In case of delayed payment of fees by the second party, necessary legal actions will be taken, including the use of guarantee checks.</li>
          <li>If a guarantee check is used, the second party must replace it immediately to continue benefiting from the agreement.</li>
          <li>The second party undertakes to transport the worker to and from the center for medical examinations or ID fingerprinting appointments.</li>
          <li>The second party commits to ensuring the worker receives their salaries deposited by the first party through the exchange office.</li>
          <li>The second party has the right to replace the worker if she does not have the necessary qualifications throughout the contract period, provided that a replacement worker is provided within a maximum period of 5 working days. If this is not possible, the second party has the right to request the termination of the contract.</li>
          <li>In the event of the worker’s escape or refusal to work, the second party undertakes to notify the first party within a maximum period of 5 working days. The first party undertakes to provide an alternative worker within 48 hours. If this is not possible, the first party undertakes to return the remaining fees to the second party within 14 working days.</li>
          <li>In the event that the second party wishes to terminate this agreement, it undertakes to officially notify the first party one month before the date of its cancellation. Or in the event of immediate termination of the contract, to pay the month’s fees in cash. The amount due shall be returned within 14 working days from the date of termination of the contract.</li>
          <li>The first party commits to providing health insurance for the worker, and the second party commits to ensuring the worker receives medical care throughout their employment.</li>
          <li>The worker enjoys all labor rights guaranteed by the UAE labor law, works for the second party on a secondment basis, and resides with the second party by mutual agreement.</li>
          <li>The second party commits to employing the worker in the agreed-upon specialty according to state laws and providing adequate housing and suitable living conditions.</li>
          <li>If the worker travels with the employer outside the country, the second party must inform the first party, receive a travel approval letter, and deposit a guarantee check, the amount of which will be determined later based on the contract duration and the worker’s nationality.</li>
          <li>Both parties commit to complying with all terms and conditions stipulated in this agreement.</li>
          <li>This agreement automatically terminates at the end of its specified duration unless extended according to the stipulated terms.</li>
          <li>In the event of contract renewal, the terms, conditions and prices applicable as of the day of renewal shall apply, and the fees mentioned in this contract shall not apply to the renewal contract.</li>
          <li>The phone number and email address mentioned in this agreement are the official channels of communication. Proof of sending notifications is considered sufficient.</li>
          <li>For any matters not addressed in this contract, the provisions of Federal Law No. (10) of 2017 concerning domestic workers, its executive regulations, and other relevant legal frameworks issued by the Ministry of Human Resources and Emiratisation shall apply. The courts of the UAE have jurisdiction over any disputes related to this contract.</li>
          <li>Without prejudice to the ministry’s right to take legal actions against the party breaching the contract, in case of a dispute between the parties, the ministry shall be approached to resolve the issue amicably and take appropriate actions.</li>
        </ul>
        <ul class="rtl">
          <li style="list-style: none;"><strong>مقدمة الاتفاقية:</strong></li>
          <li>يلتزم الطرف الأول بتوفير خدمة عاملةٍ منزليةٍ تحت كفالته، ويتعهد باستخراج تصريح العمل والإقامة للعاملة لمدة محددة، وذلك مقابل رسم مقدَّم متفق عليه وقدره: <strong><?php echo e($totalAmt); ?> درهم إماراتي</strong>.</li>
          <li>يتفق الطرفان على أن مدة هذا العقد تمتد من تاريخ <strong><?php echo e($agreementStart); ?></strong> إلى تاريخ <strong><?php echo e($agreementEnd); ?></strong>.</li>
          <li>يتولى الطرف الأول استكمال الإجراءات المتعلقة بعقد العمل/بطاقة العمل/إصدار التأشيرة/تعديل الوضع/الفحص الطبي/الهوية والإقامة للعامل المساعد.</li>
           <li>يتعهد الطرف الأول بإيداع راتب العامل المساعد شهرياً عبر نظام حماية الأجور.</li> 
          <!--<li>يلتزم الطرف الثاني بدفع رسوم المكتب المتفق عليها شهرياً طوال مدة العقد.</li>-->
          <li>تتم المدفوعات عن طريق شيكات تودع مقدماً لدى الطرف الأول لمدة العقد، أو عبر التحويل البنكي أو الدفع النقدي في المركز.</li>
          <li>في حالة تأخر الطرف الثاني في سداد الرسوم، يتم اتخاذ الإجراءات القانونية اللازمة، بما في ذلك استخدام شيكات الضمان.</li>
          <li>إذا تم استخدام شيك ضمان، يجب على الطرف الثاني استبداله فوراً لمواصلة الاستفادة من الاتفاقية.</li>
          <li>يتعهد الطرف الثاني بنقل العامل من وإلى المركز لإجراء الفحوص الطبية أو مواعيد أخذ بصمات الهوية.</li>
          <li>يلتزم الطرف الثاني بضمان حصول العامل على رواتبه المودعة من الطرف الأول عبر مكتب الصرافة.</li>
          <li>يحق للطرف الثاني استبدال العامل إذا لم تتوفر لديه المؤهلات اللازمة طوال مدة العقد، شريطة توفير عامل بديل خلال مدة أقصاها 5 أيام عمل. وإذا تعذّر ذلك، يحق للطرف الثاني طلب فسخ العقد.</li>
          <li>في حال هروب العامل أو رفضه العمل، يتعهد الطرف الثاني بإبلاغ الطرف الأول خلال مدة أقصاها 5 أيام عمل. ويتعهد الطرف الأول بتوفير عامل بديل خلال 48 ساعة. وإذا تعذّر ذلك، يتعهد الطرف الأول بإرجاع المبالغ المتبقية للطرف الثاني خلال 14 يوماً عمل.</li>
          <li>إذا رغب الطرف الثاني في إنهاء هذه الاتفاقية، يتعهد بإخطار الطرف الأول رسمياً قبل شهر من تاريخ الإلغاء. أو في حال الإنهاء الفوري للعقد، بدفع رسوم الشهر نقداً، ويُعاد المبلغ المستحق خلال 14 يوماً عمل من تاريخ إنهاء العقد.</li>
          <li>يتعهد الطرف الأول بتوفير تأمين صحي للعامل، ويتعهد الطرف الثاني بضمان تلقي العامل الرعاية الطبية طوال فترة عمله.</li>
          <li>يتمتع العامل بكل الحقوق العمالية المضمونة بموجب قانون العمل الإماراتي، ويعمل لدى الطرف الثاني على سبيل الإعارة، ويقيم معه باتفاق متبادل.</li>
          <li>يلتزم الطرف الثاني بتشغيل العامل في الاختصاص المتفق عليه وفقاً لقوانين الدولة، وتوفير سكن مناسب وظروف معيشية لائقة.</li>
          <li>إذا سافر العامل مع صاحب العمل خارج الدولة، يجب على الطرف الثاني إخطار الطرف الأول والحصول على رسالة موافقة على السفر وإيداع شيك ضمان يتم تحديد قيمته لاحقاً بناءً على مدة العقد وجنسية العامل.</li>
          <li>يلتزم الطرفان بالامتثال لجميع الشروط والأحكام الواردة في هذه الاتفاقية.</li>
          <li>تنتهي هذه الاتفاقية تلقائياً عند نهاية مدتها المحددة ما لم يتم تمديدها وفقاً للشروط المنصوص عليها.</li>
          <li>في حال تجديد العقد، تُطبق الشروط والأحكام والأسعار المعتمدة في تاريخ التجديد، ولا تسري الرسوم الواردة في هذا العقد على العقد المجدد.</li>
          <li>رقم الهاتف وعنوان البريد الإلكتروني المذكوران في هذه الاتفاقية هما القنوات الرسمية للتواصل، ويُعتبر إثبات الإرسال كافياً.</li>
          <li>فيما لم يُنظّم في هذا العقد، تُطبق أحكام القانون الاتحادي رقم (10) لسنة 2017 بشأن عمال الخدمة المساعدة ولائحته التنفيذية والأنظمة الصادرة عن وزارة الموارد البشرية والتوطين، وتختص محاكم دولة الإمارات بالفصل في أي نزاع متعلق بهذا العقد.</li>
          <li>دون الإخلال بحق الوزارة في اتخاذ الإجراءات القانونية ضد الجهة المخالفة للعقد، في حالة حدوث خلاف بين الطرفين، يُلجأ إلى الوزارة لتسوية المسألة ودياً واتخاذ ما يلزم.</li>
        </ul>
      </div>
    </div>
    <table class="solid-table-container">
      <tr>
        <td colspan="2" style="text-align:center; font-weight:bold; font-size:16px;">SIGNATURES  الامضاءات</td>
      </tr>
      <tr>
        <td style="text-align:center; padding:40px;">
          <div class="signature-placeholder"></div>
          <div style="margin-top:10px; font-weight:bold; font-size:14px;">SECOND PARTY الطرف الثاني</div>
        </td>
        <td style="text-align:center; padding:40px;">
          <div style="font-weight:bold; font-size:14px;">FIRST PARTY (مكتب الاستقدام)</div>
          <div>مركز الإبداع لخدمات العمالة المساعدة</div>
          <div>ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER</div>
        </td>
      </tr>
    </table>
    <div class="footer" style="margin-top:20px;">
      <img src="<?php echo e(asset('assets/img/' . $footerFileName)); ?>" alt="Footer Image">
    </div>
  </div>

  <?php $__currentLoopData = $replacementHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $hist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="page-break"></div>
    <div class="header">
      <img src="<?php echo e(asset('assets/img/' . $headerFileName)); ?>" alt="Header Image">
    </div>
    <p class="ref">Ref: <?php echo e($contract->reference_no); ?>-AN<?php echo e($i+1); ?></p>
    <h2 class="title-ar">ملحق رقم (<?php echo e($i+1); ?>) – بيانات العامل وتاريخ بدء العمل</h2>
    <h2 class="title-en">Annex No. <?php echo e($i+1); ?> – Worker and Contract details</h2>
    <table class="history_table">
      <tr>
        <th style="width:20%;">Worker Name</th>
        <td style="width:60%;"><?php echo e($hist->name); ?></td>
        <th style="width:20%;">اسم العامل</th>
      </tr>
      <tr>
        <th>Nationality</th>
        <td><?php echo e($hist->nationality); ?></td>
        <th>الجنسية</th>
      </tr>
      <tr>
        <th>Passport Number</th>
        <td><?php echo e($hist->passport_no); ?></td>
        <th>رقم جواز السفر</th>
      </tr>
      <tr>
        <th>Phone Number</th>
        <td></td>
        <th>رقم الهاتف</th>
      </tr>
      <tr>
        <th>Date of Work Start</th>
        <td><?php echo e(Carbon::parse($hist->replacement_date)->format('d M Y')); ?></td>
        <th>تاريخ بدء العمل</th>
      </tr>
      <tr>
        <th>Contract Expiry date</th>
        <td><?php echo e(Carbon::parse($contract->contract_end_date)->format('d M Y')); ?></td>
        <th>تاريخ نهاية العقد</th>
      </tr>
    </table>
    <div class="row">
      <div class="col-lg-6" dir="rtl">
        يعتبر هذا الملحق جزءاً لا يتجزأ من اتفاقية رقم  <?php echo e($contract->reference_no); ?>، ويقر الطرفان ويوافقان على التفاصيل الواردة فيه.
      </div>
      <div class="col-lg-6">
        This annex is an integral part of Agreement No. <?php echo e($contract->reference_no); ?>, and both parties acknowledge and agree to the details provided herein.
      </div>
    </div>
    <h3 class="signatures-title">التوقيعات / Signatures</h3>
    <p class="date">- <strong>التاريخ / Date:</strong> ____________________________</p>
    <div class="sig-grid">
      <div class="sig-block" dir="rtl">
        <h4>الطرف الأول / First Party (Recruitment Office):</h4>
        <div><label>الاسم / Name: ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER </label><span class="field"></span></div>
        <div><label>التوقيع / Signature:</label><span class="field"></span></div>
      </div>
      <div class="sig-block" dir="rtl">
        <h4>الطرف الثاني / Second Party (Employer):</h4>
        <div><label>الاسم / Name: <?php echo e($agreement->client->first_name); ?> <?php echo e($agreement->client->last_name); ?></label><span class="field"></span></div>
        <div><label>التوقيع / Signature:</label><span class="field"></span></div>
      </div>
    </div>
    <div class="footer" style="margin-top:20px;">
      <img src="<?php echo e(asset('assets/img/' . $footerFileName)); ?>" alt="Footer Image">
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/contracts/show2.blade.php ENDPATH**/ ?>