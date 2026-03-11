<?php
    $serverName = $_SERVER['SERVER_NAME'] ?? 'default.domain.com';
    $subdomain = explode('.', $serverName)[0];
    $headerFileName = strtolower($subdomain) . '_header.jpg';
    $footerFileName = strtolower($subdomain) . '_footer.jpg';
    $formattedDate = fn($date) => $date ? \Carbon\Carbon::parse($date)->format('d M Y') : 'N/A';
    $logoFileName = strtolower($subdomain) . '_logo.png';

    $passportPhoto = $candidate->attachments->where('attachment_type', 'Passport Size Photo')->first();
    $passportUrl = null;
    if ($passportPhoto) {
        $localPath = 'public/' . $passportPhoto->attachment_file;
        $foreignPartner = strtolower(explode(' ', $candidate->foreign_partner)[0]);
        $baseUrl = 'https://' . $foreignPartner . '.onesourceerp.com/storage/app/public/';
        $remoteFileUrl = $baseUrl . $passportPhoto->attachment_file;
        if (\Storage::exists($localPath)) {
            $passportUrl = url('storage/app/public/' . $passportPhoto->attachment_file);
        } else {
            $headers = @get_headers($remoteFileUrl);
            if ($headers && strpos($headers[0], '200') !== false) {
                $passportUrl = $remoteFileUrl;
            }
        }
    }

    $fullBodyPhoto = $candidate->attachments->where('attachment_type', 'Full Body Photo')->first();
    $fullBodyUrl = null;
    if ($fullBodyPhoto) {
        $localPath = 'public/' . $fullBodyPhoto->attachment_file;
        $foreignPartner = strtolower(explode(' ', $candidate->foreign_partner)[0]);
        $baseUrl = 'https://' . $foreignPartner . '.onesourceerp.com/storage/app/public/';
        $remoteFileUrl = $baseUrl . $fullBodyPhoto->attachment_file;
        if (\Storage::exists($localPath)) {
            $fullBodyUrl = url('storage/app/public/' . $fullBodyPhoto->attachment_file);
        } else {
            $headers = @get_headers($remoteFileUrl);
            if ($headers && strpos($headers[0], '200') !== false) {
                $fullBodyUrl = $remoteFileUrl;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($candidate->candidate_name); ?>'s CV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="<?php echo e(asset('assets/img/' . $logoFileName)); ?>" rel="icon">
    <link href="<?php echo e(asset('assets/img/' . $logoFileName)); ?>" rel="apple-touch-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .cv-container {
            max-width: 210mm;
            margin: 20px auto;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 15px;
        }
        .heading {
            font-size: 1rem;
            font-weight: bold;
            margin-top: 15px;
            color: #333;
            display: flex;
            justify-content: space-between;
            letter-spacing: 2px;
        }
        .rtl {
            direction: rtl;
        }
        .ltr {
            direction: ltr;
        }
        .section-table {
            width: 100%;
            margin: 20px 0;
            border: 1px solid #000;
            padding: 10px;
        }
        .section-table th,
        .section-table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: middle;
            font-size: 12px;
        }
        .section-table th {
            background-color: #f0f0f0;
        }
        .info-column {
            width: 33%;
        }
        .text-left-align {
            text-align: left;
            padding-left: 10px;
        }
        .text-right-align {
            text-align: right;
            padding-right: 10px;
        }
        .full-width-name {
            border: 1px solid #000;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .footer img {
            width: 100%;
        }
        .button-container {
            text-align: center;
            margin: 20px 0;
        }
        .button-container a {
            margin: 0 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="button-container">
    <a href="<?php echo e(route('package.download', ['package' => filled($candidate->cn_number_series) ? $candidate->cn_number_series : $candidate->reference_no])); ?>" class="btn btn-primary">
        <i class="bi bi-download"></i> Download
    </a>
    <a href="<?php echo e(route('package.share', ['package' => filled($candidate->cn_number_series) ? $candidate->cn_number_series : $candidate->reference_no])); ?>" class="btn btn-success">
        <i class="bi bi-whatsapp"></i> Share on WhatsApp
    </a>
    <a href="<?php echo e(url('candidates/inside')); ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Candidates
    </a>
</div>
<div class="cv-container">
    <div class="header">
        <img src="<?php echo e(asset('assets/img/' . $headerFileName)); ?>" alt="Header" style="width:100%;">
    </div>

    <div class="heading">
        <div class="ltr" style="flex: 1; text-align: left;">Application For Employment</div>
        <div class="rtl" style="flex: 1; text-align: right;">استمارة طلب عمل</div>
    </div>
    <div class="row g-3">
        <div class="col-12 col-md-9">
            <div class="table-responsive">
                <table class="section-table table">
                    <tr>
                        <th class="info-column text-left-align">Reference No</th>
                        <td class="info-column"><?php echo e($candidate->reference_no ?? 'N/A'); ?></td>
                        <th class="info-column text-right-align rtl">الرقم المميز</th>
                    </tr>
                    <tr>
                        <th class="text-left-align">Post Applied For</th>
                        <td><?php echo e($candidate->appliedPosition->position_name ?? 'N/A'); ?></td>
                        <th class="text-right-align rtl">الوظيفة المتقدم عليها</th>
                    </tr>
                    <tr>
                        <th class="text-left-align">Monthly Salary</th>
                        <td>
                            <?php echo e('AED ' . number_format(
                                $candidate->nationality == 3
                                    ? round($candidate->salary * 3.6)
                                    : $candidate->salary,
                                0
                            )); ?>

                        </td>
                        <th class="text-right-align rtl">الراتب الشهري</th>
                    </tr>
                    <tr>
                        <th class="text-left-align">Contract Period</th>
                        <td><?php echo e($candidate->contract_duration ? \Illuminate\Support\Str::title(strtolower($candidate->contract_duration)) : 'N/A'); ?></td>
                        <th class="text-right-align rtl">فترة العقد</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-12 col-md-3 text-center">
            <?php if($passportUrl): ?>
                <img src="<?php echo e($passportUrl); ?>" alt="Passport Photo" class="img-thumbnail" style="width: 150px; height: auto;">
            <?php else: ?>
                <img src="https://via.placeholder.com/150x200?text=No+Image" alt="No Image" class="img-thumbnail" style="width: 150px; height: auto;">
            <?php endif; ?>
        </div>
    </div>
    <div class="full-width-name">
        <strong>Name:</strong> <span class="ltr"><?php echo e($candidate->candidate_name); ?></span>
    </div>
    <div class="row g-3">
        <div class="col-12 col-md-7">
            <div class="table-responsive">
                <table class="section-table table">
                    <tr>
                        <th colspan="3">Details of Application - بيانات صاحب الطلب</th>
                    </tr>
                    <tr>
                        <td class="ltr">Nationality</td>
                        <td><?php echo e($candidate->Nationality->name ?? 'N/A'); ?></td>
                        <td class="rtl">الجنسية</td>
                    </tr>
                    <tr>
                        <td class="ltr">Religion</td>
                        <td><?php echo e($candidate->religion ?? 'N/A'); ?></td>
                        <td class="rtl">الديانة</td>
                    </tr>
                    <tr>
                        <td class="ltr">Date of Birth</td>
                        <td><?php echo e($formattedDate($candidate->date_of_birth)); ?></td>
                        <td class="rtl">تاريخ الميلاد</td>
                    </tr>
                    <tr>
                        <td class="ltr">Place of Birth</td>
                        <td><?php echo e($candidate->place_of_birth ? \Illuminate\Support\Str::title(strtolower($candidate->place_of_birth)) : 'N/A'); ?></td>
                        <td class="rtl">مكان الميلاد</td>
                    </tr>
                    <tr>
                        <td class="ltr">Age</td>
                        <td><?php echo e($candidate->age ?? 'N/A'); ?></td>
                        <td class="rtl">العمر</td>
                    </tr>
                    <tr>
                        <td class="ltr">Living Town</td>
                        <td><?php echo e($candidate->candidate_region ? \Illuminate\Support\Str::title(strtolower($candidate->candidate_region)) : 'N/A'); ?></td>
                        <td class="rtl">مكان السكن</td>
                    </tr>
                    <tr>
                        <td class="ltr">Marital Status</td>
                        <td><?php echo e($candidate->maritalStatus->status_name ?? 'N/A'); ?></td>
                        <td class="rtl">الحالة الاجتماعية</td>
                    </tr>
                    <tr>
                        <td class="ltr">No Of Children</td>
                        <td><?php echo e($candidate->number_of_children ?? 'N/A'); ?></td>
                        <td class="rtl">عدد الأطفال</td>
                    </tr>
                    <tr>
                        <td class="ltr">Weight</td>
                        <td><?php echo e($candidate->weight ?? 'N/A'); ?> kg</td>
                        <td class="rtl">الوزن</td>
                    </tr>
                    <tr>
                        <td class="ltr">Height</td>
                        <td><?php echo e($candidate->height ?? 'N/A'); ?> cm</td>
                        <td class="rtl">الطول</td>
                    </tr>
                    <tr>
                        <td class="ltr">Education Level</td>
                        <td><?php echo e($candidate->educationLevel->level_name ?? 'N/A'); ?></td>
                        <td class="rtl">الدرجة العلمية</td>
                    </tr>
                    <tr>
                        <td class="ltr">Contact No.</td>
                        <td><?php echo e($candidate->phone_number ?? 'N/A'); ?></td>
                        <td class="rtl">رقم الجوال</td>
                    </tr>
                </table>
            </div>
            <div class="table-responsive">
                <table class="section-table table">
                    <tr>
                        <th colspan="3">Knowledge of Language - اللغات</th>
                    </tr>
                    <tr>
                        <td class="ltr">English</td>
                        <td><?php echo e($candidate->english_skills ?? 'N/A'); ?></td>
                        <td class="rtl">الإنجليزية</td>
                    </tr>
                    <tr>
                        <td class="ltr">Arabic</td>
                        <td><?php echo e($candidate->arabic_skills ?? 'N/A'); ?></td>
                        <td class="rtl">العربية</td>
                    </tr>
                </table>
            </div>
            <div class="table-responsive">
                <table class="section-table table">
                    <tr>
                        <th colspan="3">Working Experience - خبرة العمل</th>
                    </tr>
                    <?php if($candidate->workSkills && $candidate->workSkills->isNotEmpty()): ?>
                        <?php $__currentLoopData = $candidate->workSkills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="ltr"><?php echo e(ucfirst($skill->skill_name ?? 'N/A')); ?></td>
                                <td class="text-center">Yes</td>
                                <td class="rtl"><?php echo e($skill->arabic_name ?? 'N/A'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No skills are available</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="table-responsive">
                <table class="section-table table">
                    <tr>
                        <th colspan="3">Previous Employment Abroad - الخبرة خارج البلد</th>
                    </tr>
                    <?php $__empty_1 = true; $__currentLoopData = $candidate->experiences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $experience): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ltr"><?php echo e($experience->country); ?></td>
                            <td><?php echo e($experience->experience_years); ?> Years & <?php echo e($experience->experience_months); ?> Months & 0 Days</td>
                            <td></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="text-center">N/A</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="table-responsive">
                <table class="section-table table">
                    <tr>
                        <th colspan="3">Emergency Contact Person - اسم شخص الاتصال في حالات الطوارئ</th>
                    </tr>
                    <tr>
                        <td class="ltr">Family Contact Number</td>
                        <td><?php echo e($candidate->family_contact_number_1 ?? $candidate->family_contact_number_2); ?></td>
                        <td class="rtl">رقم الاتصال بالعائلة</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="table-responsive">
                <table class="section-table table">
                    <tr>
                        <th colspan="3">Passport Details - بيانات جواز السفر</th>
                    </tr>
                    <tr>
                        <td class="ltr">Passport Number</td>
                        <td><?php echo e($candidate->passport_no ? strtoupper($candidate->passport_no) : 'N/A'); ?></td>
                        <th class="info-column text-right-align rtl">الرقم المرجعي</th>
                    </tr>
                    <tr>
                        <td class="ltr">Issue Date</td>
                        <td><?php echo e($formattedDate($candidate->passport_issue_date)); ?></td>
                        <td class="rtl">تاريخ الصدور</td>
                    </tr>
                    <tr>
                        <td class="ltr">Place of Issue</td>
                        <td><?php echo e($candidate->passport_issue_place ? \Illuminate\Support\Str::title(strtolower($candidate->passport_issue_place)) : 'N/A'); ?></td>
                        <td class="rtl">مكان الصدور</td>
                    </tr>
                    <tr>
                        <td class="ltr">Expiry Date</td>
                        <td><?php echo e($formattedDate($candidate->passport_expiry_date)); ?></td>
                        <td class="rtl">تاريخ الانتهاء</td>
                    </tr>
                </table>
            </div>
            <div class="text-center">
                <?php if($fullBodyUrl): ?>
                    <img src="<?php echo e($fullBodyUrl); ?>" alt="Full Body Photo" class="img-thumbnail" style="width: 300px; height: auto;">
                <?php else: ?>
                    <img src="https://via.placeholder.com/150x200?text=No+Image" alt="No Image" class="img-thumbnail" style="width: 300px; height: auto;">
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="footer" style="margin-top: 20px;">
        <img src="<?php echo e(asset('assets/img/' . $footerFileName)); ?>" alt="Footer">
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/view_cv.blade.php ENDPATH**/ ?>