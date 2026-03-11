<?php
    use Illuminate\Support\Str;

    $subdomain      = explode('.', $_SERVER['SERVER_NAME'])[0];
    $headerFile     = strtolower($subdomain) . '_header.jpg';
    $footerFile     = strtolower($subdomain) . '_footer.jpg';
    $logoFile       = strtolower($subdomain) . '_logo.png';
    $fmt            = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d M Y') : 'N/A';

    $partner    = strtolower(strtok($candidate->foreign_partner, ' '));
    $baseUrl    = "https://{$partner}.onesourceerp.com/storage/app/public/";

    $remote     = fn($file) => $file && @get_headers($baseUrl . $file) && str_contains(@get_headers($baseUrl . $file)[0], '200')
                                ? $baseUrl . $file
                                : null;

    $passportUrl  = optional($candidate->attachments->firstWhere('attachment_type', 'Passport Size Photo'))->attachment_file;
    $passportUrl  = $remote($passportUrl);

    $fullBodyUrl  = optional($candidate->attachments->firstWhere('attachment_type', 'Full Body Photo'))->attachment_file;
    $fullBodyUrl  = $remote($fullBodyUrl);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo e($candidate->candidate_name); ?> CV</title>
    <link rel="icon" href="<?php echo e(asset('assets/img/' . $logoFile)); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('assets/img/' . $logoFile)); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body{font-family:Arial,Helvetica,sans-serif;font-size:12px;background:#f8f9fa}
        .cv-box{max-width:210mm;margin:auto;background:#fff;box-shadow:0 0 10px rgba(0,0,0,.1);padding:15px}
        .btn-box{text-align:center;margin:20px 0}
        .btn-box a{margin:0 10px;font-size:12px}
        .heading{font-size:1rem;font-weight:700;margin:15px 0 20px;display:flex;justify-content:space-between;letter-spacing:2px}
        .section-table{width:100%;margin-bottom:15px;border:1px solid #000;border-collapse:collapse}
        .section-table th,.section-table td{border:1px solid #000;padding:8px;vertical-align:middle;font-size:12px}
        .section-table th{background:#f0f0f0}
        .full-name{border:1px solid #000;padding:10px;font-size:14px;margin-bottom:20px}
        .rtl{direction:rtl;text-align:right}
        .ltr{direction:ltr;text-align:left}
    </style>
</head>
<body>
<div class="btn-box">
    <a href="<?php echo e(route('candidates.download',$candidate->reference_no)); ?>" class="btn btn-primary"><i class="bi bi-download"></i> Download</a>
    <a href="<?php echo e(route('candidates.share',$candidate->reference_no)); ?>" class="btn btn-success"><i class="bi bi-whatsapp"></i> Share</a>
    <a href="<?php echo e(route('candidates.index')); ?>" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="cv-box">
    <img src="<?php echo e(asset('assets/img/' . $headerFile)); ?>" style="width:100%">

    <div class="heading">
        <span class="ltr">Application For Employment</span>
        <span class="rtl">استمارة طلب عمل</span>
    </div>

    <div class="row">
        <div class="col-9">
            <table class="section-table">
                <tr><th class="ltr">Reference No</th><td><?php echo e($candidate->reference_no ?: 'N/A'); ?></td><th class="rtl">الرقم المرجعي</th></tr>
                <tr><th class="ltr">Post Applied For</th><td><?php echo e($candidate->appliedPosition->position_name ?? 'N/A'); ?></td><th class="rtl">الوظيفة المتقدم عليها</th></tr>
                <tr><th class="ltr">Monthly Salary</th><td><?php echo e($candidate->salary ?: 'N/A'); ?></td><th class="rtl">الراتب الشهري</th></tr>
                <tr><th class="ltr">Contract Period</th><td><?php echo e($candidate->contract_duration ? Str::title(strtolower($candidate->contract_duration)) : 'N/A'); ?></td><th class="rtl">فترة العقد</th></tr>
            </table>
        </div>
        <div class="col-3 text-center">
            <img src="<?php echo e($passportUrl ?: 'https://via.placeholder.com/150x200?text=No+Image'); ?>" class="img-thumbnail" style="width:150px;height:auto">
        </div>
    </div>

    <div class="full-name"><strong>Name:</strong> <span class="ltr"><?php echo e($candidate->candidate_name); ?></span></div>

    <div class="row">
        <div class="col-7">
            <table class="section-table">
                <tr><th colspan="3">Details of Application - بيانات صاحب الطلب</th></tr>
                <tr><td class="ltr">Nationality</td><td><?php echo e($candidate->Nationality->name ?? 'N/A'); ?></td><td class="rtl">الجنسية</td></tr>
                <tr><td class="ltr">Religion</td><td><?php echo e($candidate->religion ?: 'N/A'); ?></td><td class="rtl">الديانة</td></tr>
                <tr><td class="ltr">Date of Birth</td><td><?php echo e($fmt($candidate->date_of_birth)); ?></td><td class="rtl">تاريخ الميلاد</td></tr>
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

        <div class="col-5">
            <table class="section-table">
                <tr><th colspan="3">Passport Details - بيانات جواز السفر</th></tr>
                <tr><td class="ltr">Passport Number</td><td><?php echo e($candidate->passport_no ? strtoupper($candidate->passport_no) : 'N/A'); ?></td><td class="rtl">رقم الجواز</td></tr>
                <tr><td class="ltr">Issue Date</td><td><?php echo e($fmt($candidate->passport_issue_date)); ?></td><td class="rtl">تاريخ الصدور</td></tr>
                <tr><td class="ltr">Place of Issue</td><td><?php echo e($candidate->passport_issue_place ? Str::title(strtolower($candidate->passport_issue_place)) : 'N/A'); ?></td><td class="rtl">مكان الصدور</td></tr>
                <tr><td class="ltr">Expiry Date</td><td><?php echo e($fmt($candidate->passport_expiry_date)); ?></td><td class="rtl">تاريخ الانتهاء</td></tr>
            </table>
            <div class="text-center">
                <img src="<?php echo e($fullBodyUrl ?: 'https://via.placeholder.com/250x350?text=No+Image'); ?>" class="img-thumbnail" style="width:250px;height:auto">
            </div>
        </div>
    </div>

    <img src="<?php echo e(asset('assets/img/' . $footerFile)); ?>" style="width:100%">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/package/cv.blade.php ENDPATH**/ ?>