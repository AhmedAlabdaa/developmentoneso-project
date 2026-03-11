<?php
    use Illuminate\Support\Str;
    $serverName     = $_SERVER['SERVER_NAME'];
    $subdomain      = explode('.', $serverName)[0];
    $formattedDate  = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d M Y') : 'N/A';
    $foreignPartner = strtolower(strtok($candidate->foreign_partner, ' '));
    $baseUrl        = 'https://' . $foreignPartner . '.onesourceerp.com/storage/app/public/';
    $remoteExists = fn(string $url) => ($h = @get_headers($url)) && str_contains($h[0], '200');
    $fileUrl = function ($type) use ($candidate, $baseUrl, $remoteExists) {
        $att = $candidate->attachments->firstWhere('attachment_type', $type);
        if (!$att) return null;
        $remote = $baseUrl . $att->attachment_file;
        if ($remoteExists($remote)) return $remote;
        $local = 'public/' . $att->attachment_file;
        return \Storage::exists($local) ? url('storage/app/public/' . $att->attachment_file) : null;
    };
    $passportUrl  = $fileUrl('Passport Size Photo');
    $fullBodyUrl  = $fileUrl('Full Body Photo');
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Noto+Naskh+Arabic:wght@400;700&family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
<style>
    html, body {
        font-family: 'Noto Sans', Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #000;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
        line-height: 1.45;
        letter-spacing: 0;
        hyphens: none;
    }
    body{font-family:'Noto Sans',Arial,Helvetica,sans-serif;font-size:12px}
    .rtl{direction:rtl;text-align:right}
    .ltr{direction:ltr;text-align:left}
    .section-table{width:100%;margin-bottom:0px;border:1px solid #000;border-collapse:collapse;table-layout:fixed}
    .section-table th,.section-table td{border:1px solid #000;padding:7px 8px;vertical-align:middle;font-size:12px;line-height:1.6}
    .section-table th{background:#f3f3f3}
    .full-width-name{border:1px solid #000;padding:10px;font-size:12px;margin-bottom:10px}
    .img-thumb{border:1px solid #ccc}
    .col-80{max-width:80%}
    .col-20{max-width:20%}
    .col-60{max-width:60%}
    .col-40{max-width:40%}
    .float-l{float:left}
    .rtl, .rtl *{
        font-family:'Amiri','Noto Naskh Arabic','Noto Sans',Arial,sans-serif !important;
        direction:rtl;
        unicode-bidi:isolate-override;
        font-kerning:normal;
    }
    .rtl strong, .rtl th { font-weight:700 }
    .section-table th.rtl, .section-table td.rtl { text-align:right }
    .section-table th.ltr, .section-table td.ltr { text-align:left }
    .ltr, .ltr *{
        font-family:'Noto Sans',Arial,Helvetica,sans-serif !important;
        direction:ltr;
        unicode-bidi:isolate;
    }
    .row::after { content:""; display:block; clear:both }
    .float-l.col-80{ width:80% }
    .float-l.col-20{ width:20% }
    .float-l.col-50{ width:50% }
    .float-l.col-60{ width:60% }
    .float-l.col-40{ width:40% }
    .full-width-name, .section-table, .heading { page-break-inside: avoid }
    img { display:block; image-rendering:auto }
    .img-thumb{ border:1px solid #bbb; border-radius:2px }
    .section-table td, .section-table th{
        overflow:visible;
        word-break:keep-all;
        white-space:normal;
    }
</style>
<img src="<?php echo e(asset('assets/img/' . strtolower($subdomain) . '_header.jpg')); ?>" style="width:100%">
<div class="heading" style="margin-bottom:20px;font-weight: bold;">
    <div class="float-l col-50">Application For Employment</div>
    <div class="float-l col-50" style="text-align: right;">استمارة طلب عمل</div>
</div>
<div class="full-width-name"><strong>Name:</strong> <span class="ltr"><?php echo e($candidate->candidate_name); ?></span></div>
<div class="row" style="margin-bottom:10px;">
    <div class="float-l col-80">
        <table class="section-table">
            <tr><th class="ltr">Reference No</th><td><?php echo e($candidate->reference_no ?: 'N/A'); ?></td><th class="rtl">الرقم المرجعي</th></tr>
            <tr><th class="ltr">Post Applied For</th><td><?php echo e($candidate->appliedPosition->position_name ?? 'N/A'); ?></td><th class="rtl">الوظيفة المتقدم عليها</th></tr>
            <tr><th class="ltr">Monthly Salary</th><td><?php echo e($candidate->salary ?: 'N/A'); ?></td><th class="rtl">الراتب الشهري</th></tr>
            <tr><th class="ltr">Contract Period</th><td><?php echo e($candidate->contract_duration ? Str::title(strtolower($candidate->contract_duration)) : 'N/A'); ?></td><th class="rtl">فترة العقد</th></tr>
        </table>
    </div>
    <div class="float-l col-20 text-center">
        <img src="<?php echo e($passportUrl ?: 'https://via.placeholder.com/100x140?text=No+Image'); ?>" class="img-thumb" style="width:170px;height:138px;margin-left:10px;">
    </div>
</div>

<div class="row" style="align-items:flex-start">
    <div class="float-l col-60">
        <table class="section-table">
            <tr><th colspan="3">Details of Application - بيانات صاحب الطلب</th></tr>
            <tr><td class="ltr">Nationality</td><td><?php echo e($candidate->Nationality->name ?? 'N/A'); ?></td><td class="rtl">الجنسية</td></tr>
            <tr><td class="ltr">Religion</td><td><?php echo e($candidate->religion ?: 'N/A'); ?></td><td class="rtl">الديانة</td></tr>
            <tr><td class="ltr">Date of Birth</td><td><?php echo e($formattedDate($candidate->date_of_birth)); ?></td><td class="rtl">تاريخ الميلاد</td></tr>
            <tr><td class="ltr">Place of Birth</td><td><?php echo e($candidate->place_of_birth ? Str::title(strtolower($candidate->place_of_birth)) : 'N/A'); ?></td><td class="rtl">مكان الميلاد</td></tr>
            <tr><td class="ltr">Age</td><td><?php echo e($candidate->age ?: 'N/A'); ?></td><td class="rtl">العمر</td></tr>
            <tr><td class="ltr">Living Town</td><td><?php echo e($candidate->candidate_region ? Str::title(strtolower($candidate->candidate_region)) : 'N/A'); ?></td><td class="rtl">مكان السكن</td></tr>
            <tr><td class="ltr">Marital Status</td><td><?php echo e($candidate->maritalStatus->status_name ?? 'N/A'); ?></td><td class="rtl">الحالة الاجتماعية</td></tr>
            <tr><td class="ltr">No Of Children</td><td><?php echo e($candidate->number_of_children ?: 'N/A'); ?></td><td class="rtl">عدد الأطفال</td></tr>
            <tr><td class="ltr">Weight</td><td><?php echo e($candidate->weight ?: 'N/A'); ?> kg</td><td class="rtl">الوزن</td></tr>
            <tr><td class="ltr">Height</td><td><?php echo e($candidate->height ?: 'N/A'); ?> cm</td><td class="rtl">الطول</td></tr>
            <tr><td class="ltr">Education Level</td><td><?php echo e($candidate->educationLevel->level_name ?? 'N/A'); ?></td><td class="rtl">الدرجة العلمية</td></tr>
            <tr><td class="ltr">Contact No.</td><td><?php echo e($candidate->phone_number ?: 'N/A'); ?></td><td class="rtl">رقم الجوال</td></tr>
        </table>

        <table class="section-table">
            <tr><th colspan="3">Knowledge of Language - اللغات</th></tr>
            <tr><td class="ltr">English</td><td><?php echo e($candidate->english_skills ?: 'N/A'); ?></td><td class="rtl">الإنجليزية</td></tr>
            <tr><td class="ltr">Arabic</td><td><?php echo e($candidate->arabic_skills ?: 'N/A'); ?></td><td class="rtl">العربية</td></tr>
        </table>

        <table class="section-table">
            <tr><th colspan="3">Working Experience - خبرة العمل</th></tr>
            <?php $__empty_1 = true; $__currentLoopData = $candidate->workSkills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr><td class="ltr"><?php echo e(ucfirst($skill->skill_name)); ?></td><td class="text-center">Yes</td><td class="rtl"><?php echo e($skill->arabic_name); ?></td></tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="3" class="text-center">No skills available</td></tr>
            <?php endif; ?>
        </table>

        <table class="section-table">
            <tr><th colspan="3">Previous Employment Abroad - الخبرة خارج البلد</th></tr>
            <?php $__empty_1 = true; $__currentLoopData = $candidate->experiences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr><td class="ltr"><?php echo e($exp->country); ?></td><td><?php echo e($exp->experience_years); ?> Years & <?php echo e($exp->experience_months); ?> Months</td><td></td></tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="3" class="text-center">N/A</td></tr>
            <?php endif; ?>
        </table>

        <table class="section-table">
            <tr><th colspan="3">Emergency Contact Person - اسم شخص الاتصال الطوارئ</th></tr>
            <tr><td class="ltr">Family Contact Number</td><td><?php echo e($candidate->family_contact_number_1 ?: $candidate->family_contact_number_2 ?: 'N/A'); ?></td><td class="rtl">رقم الاتصال بالعائلة</td></tr>
        </table>
    </div>

    <div class="float-l col-40">
        <table class="section-table">
            <tr><th colspan="3">Passport Details - بيانات جواز السفر</th></tr>
            <tr><td class="ltr">Passport Number</td><td><?php echo e($candidate->passport_no ? strtoupper($candidate->passport_no) : 'N/A'); ?></td><td class="rtl">رقم الجواز</td></tr>
            <tr><td class="ltr">Issue Date</td><td><?php echo e($formattedDate($candidate->passport_issue_date)); ?></td><td class="rtl">تاريخ الصدور</td></tr>
            <tr><td class="ltr">Place of Issue</td><td><?php echo e($candidate->passport_issue_place ? Str::title(strtolower($candidate->passport_issue_place)) : 'N/A'); ?></td><td class="rtl">مكان الصدور</td></tr>
            <tr><td class="ltr">Expiry Date</td><td><?php echo e($formattedDate($candidate->passport_expiry_date)); ?></td><td class="rtl">تاريخ الانتهاء</td></tr>
        </table>
        <div class="text-center">
            <img src="<?php echo e($fullBodyUrl ?: 'https://via.placeholder.com/250x350?text=No+Image'); ?>" class="img-thumb" style="width:350px;height:630px;margin-left: 10px;margin-top:10px;">
        </div>
    </div>
</div>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/download_cv.blade.php ENDPATH**/ ?>