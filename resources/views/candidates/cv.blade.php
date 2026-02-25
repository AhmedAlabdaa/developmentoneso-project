@php
    $serverName = $_SERVER['SERVER_NAME'];
    $subdomain = explode('.', $serverName)[0];
    $headerFileName = strtolower($subdomain) . '_header.jpg';
    $footerFileName = strtolower($subdomain) . '_footer.jpg';
    $formattedDate = fn($date) => $date ? \Carbon\Carbon::parse($date)->format('d M Y') : 'N/A';
    $logoFileName = strtolower($subdomain) . '_logo.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $candidate->candidate_name }}'s CV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="{{ asset('assets/img/' . $logoFileName) }}" rel="icon">
    <link href="{{ asset('assets/img/' . $logoFileName) }}" rel="apple-touch-icon">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; background-color: #f8f9fa; }
        .cv-container { max-width: 210mm; margin: auto; background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 15px; }
        .button-container { text-align: center; margin: 20px 0; }
        .button-container a { margin: 0 10px; font-size: 12px; }
        .heading { font-size: 1rem; font-weight: bold; margin-top: 15px; color: #333; }
        .section-table { width: 100%; margin: 20px 0; border: 1px solid #000; padding: 10px; }
        .section-table th, .section-table td { border: 1px solid #000; padding: 8px; vertical-align: middle; font-size: 12px; }
        .section-table th { background-color: #f0f0f0; }
        .info-column { width: 33%; }
        .text-left-align { text-align: left; padding-left: 10px; }
        .text-right-align { text-align: right; padding-right: 10px; }
        .passport-photo { width: 172px; height: 160px; object-fit: cover; border: 2px solid #000; display: block; margin-top: 10px; }
        .full-width-name { border: 1px solid #000; padding: 10px; font-size: 14px; }
        .rtl { direction: rtl; }
        .ltr { direction: ltr; }
    </style>
</head>
<body>
<div class="button-container">
    <a href="{{ route('candidates.download', $candidate->reference_no) }}" class="btn btn-primary">
        <i class="bi bi-download"></i> Download
    </a>
    <a href="{{ route('candidates.share', $candidate->reference_no) }}" class="btn btn-success">
        <i class="bi bi-whatsapp"></i> Share on WhatsApp
    </a>
    <!-- <a href="{{ route('candidates.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Candidates
    </a> -->
</div>
<div class="cv-container">
    <div class="header">
        <img src="{{ asset('assets/img/' . $headerFileName) }}" style="width:100%;">
    </div>
    <div class="heading" style="display: flex; justify-content: space-between; letter-spacing: 2px;">
        <div class="ltr" style="flex: 1; text-align: left;">Application For Employment</div>
        <div class="rtl" style="flex: 1; text-align: right; letter-spacing: 2px;">استمارة طلب عمل</div>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <table class="table section-table">
                <tr>
                    <th class="info-column text-left-align">Reference No</th>
                    <td class="info-column">{{ $candidate->ref_no ?? 'N/A' }}</td>
                    <th class="info-column text-right-align rtl">الرقم المرجعي</th>
                </tr>
                <tr>
                    <th class="text-left-align">Post Applied For</th>
                    <td>{{ $candidate->appliedPosition->position_name ?? 'N/A' }}</td>
                    <th class="text-right-align rtl">الوظيفة المتقدم عليها</th>
                </tr>
                <tr>
                    <th class="text-left-align">Monthly Salary</th>
                    <td>
                        {{ 'AED ' . number_format(
                            $candidate->nationality == 3
                                ? round($candidate->salary * 3.6)
                                : $candidate->salary,
                            0
                        ) }}
                    </td>
                    <th class="text-right-align rtl">الراتب الشهري</th>
                </tr>
                <tr>
                    <th class="text-left-align">Contract Period</th>
                    <td>{{ $candidate->contract_duration ? \Illuminate\Support\Str::title(strtolower($candidate->contract_duration)) : 'N/A' }}</td>
                    <th class="text-right-align rtl">فترة العقد</th>
                </tr>
            </table>
        </div>
        <div class="col-lg-3 text-center">
           @php
                $photoAttachment = $candidate->attachments->where('attachment_type', 'Passport Size Photo')->first();
                $fileUrl = null;
                if ($photoAttachment) {
                    $localPath = 'public/' . $photoAttachment->attachment_file;
                    $foreignPartner = strtolower(explode(' ', $candidate->foreign_partner)[0]);
                    $baseUrl = 'https://' . $foreignPartner . '.onesourceerp.com/storage/app/public/';
                    $remoteFileUrl = $baseUrl . $photoAttachment->attachment_file;
                    if (\Storage::exists($localPath)) {
                        $fileUrl = url('storage/app/public/' . $photoAttachment->attachment_file);
                    } else {
                        $headers = @get_headers($remoteFileUrl);
                        if ($headers && strpos($headers[0], '200') !== false) {
                            $fileUrl = $remoteFileUrl;
                        }
                    }
                }
            @endphp
            @if ($fileUrl)
                <img src="{{ $fileUrl }}" alt="Passport Size Photo" class="img-thumbnail" style="width: 150px; height: auto;">
            @else
                <img src="https://via.placeholder.com/150x200?text=No+Image" alt="No Image Available" class="img-thumbnail" style="width: 150px; height: auto;">
            @endif
        </div>
    </div>
    <div class="full-width-name">
        <span style="font-weight: bold;"> Name :</span> <span class="ltr">{{ $candidate->candidate_name }}</span>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <table class="table section-table">
                <tr>
                    <th colspan="3">Details of Application - بيانات صاحب الطلب</th>
                </tr>
                <tr>
                    <td class="ltr">Nationality</td>
                    <td>{{ $candidate->Nationality->name ?? 'N/A' }}</td>
                    <td class="rtl">الجنسية</td>
                </tr>
                <tr>
                    <td class="ltr">Religion</td>
                    <td>{{ $candidate->religion ?? 'N/A' }}</td>
                    <td class="rtl">الديانة</td>
                </tr>
                <tr>
                    <td class="ltr">Date of Birth</td>
                    <td>{{ $formattedDate($candidate->date_of_birth) }}</td>
                    <td class="rtl">تاريخ الميلاد</td>
                </tr>
                <tr>
                    <td class="ltr">Place of Birth</td>
                    <td>{{ $candidate->place_of_birth ? \Illuminate\Support\Str::title(strtolower($candidate->place_of_birth)) : 'N/A' }}</td>
                    <td class="rtl">مكان الميلاد</td>
                </tr>
                <tr>
                    <td class="ltr">Age</td>
                    <td>{{ $candidate->age ?? 'N/A' }}</td>
                    <td class="rtl">العمر</td>
                </tr>
                <tr>
                    <td class="ltr">Living Town</td>
                    <td>{{ $candidate->candidate_region ? \Illuminate\Support\Str::title(strtolower($candidate->candidate_region)) : 'N/A' }}</td>
                    <td class="rtl">مكان السكن</td>
                </tr>
                <tr>
                    <td class="ltr">Marital Status</td>
                    <td>{{ $candidate->maritalStatus->status_name ?? 'N/A' }}</td>
                    <td class="rtl">الحالة الاجتماعية</td>
                </tr>
                <tr>
                    <td class="ltr">No Of Children</td>
                    <td>{{ $candidate->number_of_children ?? 'N/A' }}</td>
                    <td class="rtl">عدد الأطفال</td>
                </tr>
                <tr>
                    <td class="ltr">Weight</td>
                    <td>{{ $candidate->weight ?? 'N/A' }} kg</td>
                    <td class="rtl">الوزن</td>
                </tr>
                <tr>
                    <td class="ltr">Height</td>
                    <td>{{ $candidate->height ?? 'N/A' }} cm</td>
                    <td class="rtl">الطول</td>
                </tr>
                <tr>
                    <td class="ltr">Education Level</td>
                    <td>{{ $candidate->educationLevel->level_name ?? 'N/A' }}</td>
                    <td class="rtl">الدرجة العلمية</td>
                </tr>
                <!-- <tr>
                    <td class="ltr">Contact No.</td>
                    <td>{{ $candidate->phone_number ?? 'N/A' }}</td>
                    <td class="rtl">رقم الجوال</td>
                </tr> -->
            </table>
            <table class="table section-table">
                <tr>
                    <th colspan="3">Knowledge of Language - اللغات</th>
                </tr>
                <tr>
                    <td class="ltr">English</td>
                    <td>{{ $candidate->english_skills ?? 'N/A' }}</td>
                    <td class="rtl">الإنجليزية</td>
                </tr>
                <tr>
                    <td class="ltr">Arabic</td>
                    <td>{{ $candidate->arabic_skills ?? 'N/A' }}</td>
                    <td class="rtl">العربية</td>
                </tr>
            </table>
            <table class="table section-table">
                <tr>
                    <th colspan="3">Working Experience - خبرة العمل</th>
                </tr>
                @if($candidate->workSkills && $candidate->workSkills->isNotEmpty())
                    @foreach($candidate->workSkills as $skill)
                        <tr>
                            <td class="ltr">{{ ucfirst($skill->skill_name ?? 'N/A') }}</td>
                            <td class="text-center">Yes</td>
                            <td class="rtl">{{ $skill->arabic_name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">No skills are available</td>
                    </tr>
                @endif
            </table>
            <table class="table section-table">
                <tr>
                    <th colspan="3">Previous Employment Abroad - الخبرة خارج البلد</th>
                </tr>
                @forelse($candidate->experiences as $experience)
                    <tr>
                        <td class="ltr">{{ $experience->country }}</td>
                        <td>{{ $experience->experience_years }} Years & {{ $experience->experience_months }} Months & 0 Days</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">N/A</td>
                    </tr>
                @endforelse
            </table>
            <!-- <table class="table section-table">
                <tr>
                    <th colspan="3">Emergency Contact Person - اسم شخص الاتصال في حالات الطوارئ</th>
                </tr>
                <tr>
                    <td class="ltr">Family Contact Number</td>
                    <td>{{ $candidate->family_contact_number_1 ?? $candidate->family_contact_number_2 }}</td>
                    <td class="rtl">رقم الاتصال بالعائلة</td>
                </tr>
            </table> -->
        </div>
        <div class="col-lg-5">
            <table class="table section-table">
                <tr>
                    <th colspan="3">Passport Details - بيانات جواز السفر</th>
                </tr>
                <tr>
                    <td class="ltr">Passport Number</td>
                    <td>{{ $candidate->passport_no ? strtoupper($candidate->passport_no) : 'N/A' }}</td>
                    <td class="rtl">رقم جواز السفر</td>
                </tr>
                <tr>
                    <td class="ltr">Issue Date</td>
                    <td>{{ $formattedDate($candidate->passport_issue_date) }}</td>
                    <td class="rtl">تاريخ الصدور</td>
                </tr>
                <tr>
                    <td class="ltr">Place of Issue</td>
                    <td>{{ $candidate->passport_issue_place ? \Illuminate\Support\Str::title(strtolower($candidate->passport_issue_place)) : 'N/A' }}</td>
                    <td class="rtl">مكان الصدور</td>
                </tr>
                <tr>
                    <td class="ltr">Expiry Date</td>
                    <td>{{ $formattedDate($candidate->passport_expiry_date) }}</td>
                    <td class="rtl">تاريخ الانتهاء</td>
                </tr>
            </table>
            <div class="text-center">
                @php
                    $photoAttachment = $candidate->attachments->where('attachment_type', 'Full Body Photo')->first();
                    $fileUrl = null;
                    if ($photoAttachment) {
                        $localPath = 'public/' . $photoAttachment->attachment_file;
                        $foreignPartner = strtolower(explode(' ', $candidate->foreign_partner)[0]);
                        $baseUrl = 'https://' . $foreignPartner . '.onesourceerp.com/storage/app/public/';
                        $remoteFileUrl = $baseUrl . $photoAttachment->attachment_file;
                        if (\Storage::exists($localPath)) {
                            $fileUrl = url('storage/app/public/' . $photoAttachment->attachment_file);
                        } else {
                            $headers = @get_headers($remoteFileUrl);
                            if ($headers && strpos($headers[0], '200') !== false) {
                                $fileUrl = $remoteFileUrl;
                            }
                        }
                    }
                @endphp
                @if ($fileUrl)
                    <img src="{{ $fileUrl }}" alt="Passport Size Photo" class="img-thumbnail" style="width: 300px; height: auto;">
                @else
                    <img src="https://via.placeholder.com/150x200?text=No+Image" alt="No Image Available" class="img-thumbnail" style="width: 300px; height: auto;">
                @endif
            </div>
        </div>
    </div>
    <div class="footer">
        <img src="{{ asset('assets/img/' . $footerFileName) }}" style="width:100%;">
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
