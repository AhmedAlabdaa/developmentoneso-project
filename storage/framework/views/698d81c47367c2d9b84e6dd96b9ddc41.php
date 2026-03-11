
<?php
    use Illuminate\Support\Str;
    
    $subdomain    = explode('.', $_SERVER['SERVER_NAME'])[0];
    $headerFileName   = strtolower($subdomain) . '_header.jpg';
    $footerFileName   = strtolower($subdomain) . '_footer.jpg';

    $fmt = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d/m/Y') : '';

    if (!empty($agreement->monthly_payment) && $agreement->monthly_payment > 0) {
        $totalAmount = $agreement->monthly_payment;
        $received    = $agreement->monthly_payment;
        $remaining   = 0;
    } else {
        $totalAmount = $agreement->total_amount;
        $received    = $agreement->received_amount;
        $remaining   = max(0, $totalAmount - $received);
    }

    if (!empty($agreement->monthly_payment) && $agreement->monthly_payment > 0) {
        $payEn = 'monthly payment of (' . number_format($agreement->monthly_payment, 2) . ') each month.';
        $payAr = 'دفعة شهرية: (' . number_format($agreement->monthly_payment, 2) . ') كل شهر.';
    } else {
        $payEn = $remaining == 0
            ? 'one time payment.'
            : 'two installments: (' . number_format($received, 2) . ') upon initial agreement and (' . number_format($remaining, 2) . ') upon worker\'s arrival.';
        $payAr = $remaining == 0
            ? 'دفعة واحدة .'
            : 'دفعتین . الدفعة الأولى عند الاتفاق المبدئي: (' . number_format($received, 2) . ') .الدفعة الثانیة : (' . number_format($remaining, 2) . ') عند استلام العامل.';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Agreement <?php echo e($agreement->reference_no); ?></title>
    <style>
        body{margin:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px}
        table{width:100%;border-collapse:collapse}
        td,th{border:1px solid #000;padding:8px;text-align:center;vertical-align:middle}
        .dotted td,.dotted th{border:1px dotted #000}
        .rotate90{transform:rotate(90deg);white-space:nowrap;font-weight:bold}
        .rotate-90{transform:rotate(-90deg);white-space:nowrap;font-weight:bold}
        .sig{width:45%;border:2px solid #000;padding:15px;position:relative}
        .title-box{position:absolute;top:-12px;left:15px;background:#fff;padding:0 8px;font-weight:bold}
        .clear{clear:both}
    </style>
</head>
<body>
    <img src="<?php echo e(asset('assets/img/' . $headerFileName)); ?>" style="width:100%">
    <table class="dotted" style="margin:20px 0">
        <tr>
            <td><?php echo e($fmt($agreement->created_at)); ?></td>
            <td>
                <strong>Domestic worker Contract (traditional Package)</strong><br>
                <strong>( عقد استقدام عامل مساعد (الباقة التقليدية</strong>
            </td>
            <td>Agreement Number<br><strong>اتفاقية رقم</strong></td>
            <td style="font-weight:bold"><?php echo e($agreement->reference_no); ?></td>
        </tr>
    </table>
    <table>
        <tr>
            <td><?php echo e($agreement->client->first_name); ?> <?php echo e($agreement->client->last_name); ?></td>
            <td><strong>اسم صاحب العمل<br>SPONSER NAME</strong></td>
            <td rowspan="8"><span class="rotate90">SECOND&nbsp;PARTY<br>الطرف&nbsp;الثاني</span></td>
            <td>AL EBDAA DOMESTIC WORKERS CENTRE</td>
            <td><strong>مكتب الاستقدام<br>Tadbeer Center</strong></td>
            <td rowspan="3"><span class="rotate-90">FIRST&nbsp;PARTY<br>الطرف&nbsp;الأول</span></td>
        </tr>
        <tr>
            <td><?php echo e($agreement->client->emirates_id); ?></td>
            <td><strong>رقم الهوية<br>ID NUMBER</strong></td>
            <td>800&nbsp;32332</td>
            <td><strong>رقم الهاتف<br>Phone NUMBER</strong></td>
        </tr>
        <tr>
            <td><?php echo e($agreement->client->address); ?></td>
            <td><strong>العنوان<br>ADDRESS</strong></td>
            <td>AL&nbsp;GARHOUD,&nbsp;DUBAI,&nbsp;UAE</td>
            <td><strong>العنوان<br>Address</strong></td>
        </tr>
        <tr>
            <td><?php echo e($agreement->client->nationality); ?></td>
            <td><strong>الجنسية<br>NATIONALITY</strong></td>
            <td><?php echo e($agreement->candidate_name); ?></td>
            <td><strong>اسم العامل<br>Name</strong></td>
            <td rowspan="4"><strong>العامل المساعد<br>Domestic worker</strong></td>
        </tr>
        <tr>
            <td><?php echo e($agreement->client->mobile); ?></td>
            <td><strong>رقم الهاتف<br>PHONE NUMBER</strong></td>
            <td><?php echo e($agreement->passport_no); ?></td>
            <td><strong>رقم جواز السفر<br>Passport</strong></td>
        </tr>
        <tr>
            <td><?php echo e($agreement->client->state ?? ''); ?></td>
            <td><strong>الإمارة<br>EMIRATE</strong></td>
            <td><?php echo e($agreement->Nationality->name ?? $agreement->nationality); ?></td>
            <td><strong>الجنسية<br>Nationality</strong></td>
        </tr>
        <tr>
            <td><?php echo e(\Carbon\Carbon::parse($agreement->agreement_start_date)->format('d-m-Y')); ?></td>
            <td><strong>تاريخ بدء الاتفاقية<br>Agreement Start Date</strong></td>
            <td><?php echo e(\Carbon\Carbon::parse($agreement->agreement_end_date)->format('d-m-Y')); ?></td>
            <td><strong>تاريخ انتهاء الاتفاقية<br>Agreement End Date</strong></td>
        </tr>
    </table>
    <div style="width:100%;margin:20px 0;overflow:auto">
        <div style="float:left;width:47%">
            <p style="margin:0;direction:ltr;text-align:left">
                <strong>Article&nbsp;1: Contract and Recruitment Office Fees</strong><br>
                    The second party agrees to pay the first party recruitment fees amounting to <strong><?php echo e(number_format($totalAmount, 2)); ?></strong> Dirhams. Payment will be made in
            </p>
        </div>
        <div style="float:left;width:47%;margin-left:2%">
            <p style="margin:0;direction:rtl;text-align:right">
                <strong>البند الأول: التعاقد واتعاب مكتب الاستقدام</strong><br>
                    تم الاتفاق على أن يدفع الطرف الثاني إلى الطرف الأول رسوم الاستقدام وقدرها <strong><?php echo e(number_format($totalAmount, 2)); ?></strong> درهم بالطريقة التالية:<br>
            </p>
        </div>
    </div><div class="clear"></div>

    <div style="width:100%;margin:20px 0;overflow:auto">
        <div style="float:left;width:47%">
            <p style="margin:0;direction:ltr;text-align:left"><strong>Article&nbsp;2: Probation Period</strong><br>
                    The worker will undergo a six-month probation period starting from the date of employment.</p>
        </div>
        <div style="float:left;width:47%;margin-left:2%">
            <p style="margin:0;direction:rtl;text-align:right"><strong>البند الثاني: فترة التجربة</strong><br>
                    يوضع العامل تحت التجربة لمدة ستة أشهر من تاريخ تسلمه العمل.</p>
        </div>
    </div><div class="clear"></div>

    <div style="width:100%;margin:20px 0;overflow:auto">
        <div style="float:left;width:47%">
            <p style="margin:0;direction:ltr;text-align:left"><strong>Article&nbsp;3: Obligations of the First Party (Recruitment Office)</strong><br>The office commits to providing a worker within 30&nbsp;days of entry-permit issuance, conducting a medical examination within 30&nbsp;days before recruitment, and levying no extra charges beyond the ministry-approved fee. It also accepts a returned worker in case of conflict with the employer.</p>
        </div>
        <div style="float:left;width:47%;margin-left:2%">
            <p style="margin:0;direction:rtl;text-align:right"><strong>البند&nbsp;الثالث: التزامات الطرف الأول</strong><br>يتعهد المكتب بتوفير عامل خلال ثلاثين يوماً من تاريخ إذن الدخول، وإجراء الفحص الطبي خلال ثلاثين يوماً قبل الاستقدام، وعدم تحصيل أي مبالغ إضافية، واستلام العامل في حال وجود خلاف مع صاحب العمل.</p>
        </div>
    </div><div class="clear"></div>

    <div style="width:100%;margin:20px 0;overflow:auto">
        <div style="float:left;width:47%">
            <p style="margin:0;direction:ltr;text-align:left"><strong>Article&nbsp;4: Obligations of the Second Party (Employer)</strong><br>The employer pays government fees, completes the worker’s paperwork, provides accommodation, meals and medical care, grants a weekly day off, and must not employ the worker elsewhere. Absence must be reported within five days and all dues paid at contract end.</p>
        </div>
        <div style="float:left;width:47%;margin-left:2%">
            <p style="margin:0;direction:rtl;text-align:right"><strong>البند&nbsp;الرابع: التزامات الطرف الثاني</strong><br>يلتزم صاحب العمل بدفع الرسوم الحكومية واستكمال إجراءات إقامة العامل، وتوفير المسكن والوجبات والرعاية الطبية، ومنح يوم راحة أسبوعي، وعدم تشغيله لدى الغير، وإبلاغ الوزارة خلال خمسة أيام من الانقطاع، وسداد المستحقات عند نهاية العقد.</p>
        </div>
    </div><div class="clear"></div>

    <div style="width:100%;margin:20px 0;overflow:auto">
        <div style="float:left;width:47%">
            <p style="margin:0;direction:ltr;text-align:left"><strong>Article&nbsp;5: Responsibilities of the First Party in Case of Contract Violation</strong><br>During the first month the office refunds the full fee plus government fees if the worker absconds, refuses work or is medically unfit. Within the six-month probation period it refunds part of the fee or provides a replacement.</p>
        </div>
        <div style="float:left;width:47%;margin-left:2%">
            <p style="margin:0;direction:rtl;text-align:right"><strong>البند&nbsp;الخامس: مسؤولية الطرف الأول في حال الإخلال خلال فترة التجربة</strong><br>إذا ترك العامل العمل، أو رفضه، أو ثبت عدم لياقته الطبية خلال الشهر الأول يرد كامل المبلغ مع الرسوم. وبعد الشهر الأول وحتى نهاية فترة التجربة يُرد جزء من المبلغ أو يُوفر عامل بديل.</p>
        </div>
    </div><div class="clear"></div>

    <div style="width:100%;margin:20px 0;overflow:auto">
        <div style="float:left;width:47%">
            <p style="margin:0;direction:ltr;text-align:left"><strong>Article&nbsp;6: Refund Calculation</strong><br>Refund = (Total recruitment cost ÷ contract months) × remaining months. Payment must be made within 14&nbsp;working days of the worker’s return or absence report.</p>
        </div>
        <div style="float:left;width:47%;margin-left:2%">
            <p style="margin:0;direction:rtl;text-align:right"><strong>البند&nbsp;السادس: الاسترداد</strong><br>طريقة الاسترداد = (تكلفة الاستقدام ÷ مدة العقد بالشهر) × المدة المتبقية. يلتزم المكتب بالسداد خلال 14 يوم عمل من تاريخ رجوع العامل أو الإبلاغ عن انقطاعه.</p>
        </div>
    </div><div class="clear"></div>

    <div style="width:100%;margin:20px 0;overflow:auto">
        <div style="float:left;width:47%">
            <p style="margin:0;direction:ltr;text-align:left"><strong>Article&nbsp;7: Jurisdiction</strong><br>Disputes are first referred to the Ministry; if unresolved, the competent court will rule according to Federal Decree-Law 9-2022 on auxiliary workers.</p>
        </div>
        <div style="float:left;width:47%;margin-left:2%">
            <p style="margin:0;direction:rtl;text-align:right"><strong>البند&nbsp;السابع: الاختصاص القضائي</strong><br>تحال النزاعات إلى الوزارة، وإن تعذر حلها تُحال إلى المحكمة المختصة وفق مرسوم بقانون اتحادي 9-2022 بشأن عمال الخدمة المساعدة.</p>
        </div>
    </div><div class="clear"></div>

    <div style="width:100%;margin:20px 0;overflow:auto">
        <div style="float:left;width:47%">
            <p style="margin:0;direction:ltr;text-align:left"><strong>Article&nbsp;8: Contract Drafting</strong><br>This contract is issued in three copies: one for each party and a third lodged with the Ministry.</p>
        </div>
        <div style="float:left;width:47%;margin-left:2%">
            <p style="margin:0;direction:rtl;text-align:right"><strong>البند&nbsp;الثامن: تحرير العقد</strong><br>يُحرَّر العقد من ثلاث نسخ؛ نسخة لكل طرف ونسخة تودع لدى الوزارة.</p>
        </div>
    </div><div class="clear"></div>

    <div style="margin:30px 0;overflow:auto">
        <div class="sig" style="float:left">
            <div class="title-box">SECOND PARTY (Employer) / الطرف الثاني</div>
            <p><span style="font-weight:bold">Name&nbsp;:</span> <span style="border-bottom:1px solid #000;display:inline-block;width:75%"><?php echo e($agreement->client->first_name); ?> <?php echo e($agreement->client->last_name); ?></span></p>
            <p><span style="font-weight:bold">Signature&nbsp;:</span> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">&nbsp;</span></p>
            <p><span style="font-weight:bold">Date&nbsp;:</span> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">&nbsp;</span></p>
        </div>
        <div class="sig" style="float:left;margin-left:2%">
            <div class="title-box">FIRST PARTY (Recruitment Office) / الطرف الأول</div>
            <p><span style="font-weight:bold">Name&nbsp;:</span> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER</span></p>
            <p><span style="font-weight:bold">Signature&nbsp;:</span> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">&nbsp;</span></p>
            <p><span style="font-weight:bold">Date&nbsp;:</span> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">&nbsp;</span></p>
        </div>
    </div><div class="clear"></div>

    <img src="<?php echo e(asset('assets/img/' . $footerFileName)); ?>" style="width:100%">
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/agreements/trial_contract_download.blade.php ENDPATH**/ ?>