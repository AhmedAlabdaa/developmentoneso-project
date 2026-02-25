@php
use Carbon\Carbon;

$agreement = isset($agreement) ? $agreement : (isset($contract) ? $contract->agreement : null);

$serverName     = $_SERVER['SERVER_NAME'] ?? '';
$subdomain      = explode('.', $serverName)[0] ?? '';
$headerFileName = strtolower($subdomain) . '_header.jpg';
$footerFileName = strtolower($subdomain) . '_footer.jpg';

$createdAt      = ($agreement && $agreement->created_at) ? Carbon::parse($agreement->created_at)->format('d-m-Y') : '';
$agreementStart = ($agreement && $agreement->agreement_start_date) ? Carbon::parse($agreement->agreement_start_date)->format('d-m-Y') : '';
$agreementEnd   = ($agreement && $agreement->agreement_end_date) ? Carbon::parse($agreement->agreement_end_date)->format('d-m-Y') : '';

if ($agreement && !empty($agreement->monthly_payment)) {
    $totalAmount = (float) $agreement->monthly_payment;
    $received    = (float) $agreement->monthly_payment;
    $remaining   = 0;
} else {
    $totalAmount = (float) ($agreement->total_amount ?? 0);
    $received    = (float) ($agreement->received_amount ?? 0);
    $remaining   = max(0, $totalAmount - $received);
}
@endphp

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Agreement</title>
    <style>
        @page{size:A4;margin:5mm}
        body{font-family:Arial,sans-serif;background-color:#f9f9f9;margin:0;padding:0;font-size:12px;line-height:1.5}
        .contract-container{margin:auto;background:#fff;padding:5mm}
        .header,.footer{text-align:center;margin:0;padding:0}
        .header img,.footer img{max-width:100%;height:auto}
        .table-container{width:100%;border-collapse:collapse;margin-bottom:20px;background-color:#f4b083}
        .table-container td{padding:10px;text-align:center}
        .table-container input{width:90%;padding:5px;font-size:12px;border:1px solid #ccc;border-radius:3px}
        .solid-table-container{width:100%;border-collapse:collapse;margin-bottom:20px}
        .solid-table-container td{border:1px solid #000;padding:10px;text-align:center}
        .solid-table-container input{width:90%;padding:5px;font-size:12px;border:1px solid #ccc;border-radius:3px}
        .vertical-text{writing-mode:vertical-rl;transform:rotate(180deg);font-weight:bold}
        .rtl{direction:rtl}
        .terms-container{margin-bottom:20px}
        .terms{display:flex;justify-content:space-between;margin-bottom:15px;align-items:flex-start}
        .terms ul{width:48%;padding-left:20px}
        .terms ul li{list-style-type:disc;margin-bottom:10px}
        .signature-section{display:flex;justify-content:space-between;margin-top:30px}
        .signature-box{flex:1;border:2px solid #000;padding:20px;text-align:left;position:relative;margin-right:10px}
        .signature-box:last-child{margin-right:0}
        .signature-title{position:absolute;top:-12px;left:20px;background:#fff;padding:0 10px;font-weight:bold}
        .signature-line{border-bottom:1px solid #000;display:inline-block;width:80%;margin:5px 0}
        input[type="text"]{border:none;background:transparent;pointer-events:none;cursor:default;outline:none;color:inherit;font-size:inherit}
        .button-container{text-align:center;margin-bottom:20px}
        .button-container a{display:inline-block;margin:0 10px;padding:10px 20px;text-decoration:none;color:#fff;border-radius:4px;font-size:14px}
        .btn-download{background-color:#28a745}
        .btn-back{background-color:#6c757d}
        @media print{body{background-color:#fff}.contract-container{box-shadow:none;border:none;margin:0;padding:0}}
    </style>
</head>
<body>
    <div class="contract-container">
        <div class="header">
            <img src="{{ asset('assets/img/' . $headerFileName) }}" alt="Header Image">
        </div>
        <table class="table-container bg-table">
            <tr>
                <td>
                    <input type="text" value="{{ $agreement && $agreement->created_at ? $agreement->created_at->format('d-m-Y') : '' }}">
                </td>
                <td>
                    <strong>(الباقة المرنة) اتفاقية تشغيل عامل مساعد</strong><br>
                    Domestic Worker Sponsorship Agreement
                </td>
                <td>
                    <input type="text" readonly value="{{ $agreement->reference_no ?? ($contract->reference_no ?? '') }}">
                </td>
                <td>
                    <strong>Agreement Number<br>اتفاقية رقم</strong>
                </td>
            </tr>
        </table>
        <table class="solid-table-container">
            <tr>
                <td>{{ $agreement->client->first_name ?? '' }} {{ $agreement->client->last_name ?? '' }}</td>
                <td><strong>اسم العميل<br>CUSTOMER NAME</strong></td>
                <td rowspan="8" class="vertical-text">Second Party الطرف الثاني</td>
                <td><input type="text" value="مركز االبداع لخدمات العمالة المساعدة"></td>
                <td><strong>مكتب االستقدام<br>Tadbeer Center</strong></td>
                <td rowspan="3" class="vertical-text">الطرف الأول<br>First Party</td>
            </tr>
            <tr>
                <td><input type="text" value="{{ $agreement->client->emirates_id ?? '' }}"></td>
                <td><strong>رقم الهوية<br>ID NUMBER</strong></td>
                <td><input type="text" value="800-32332"></td>
                <td><strong>رقم الهاتف<br>Phone Number</strong></td>
            </tr>
            <tr>
                <td><input type="text" value="{{ $agreement->client->address ?? '' }}"></td>
                <td><strong>العنوان<br>ADDRESS</strong></td>
                <td><input type="text" value="دبي -القرهود"></td>
                <td><strong>العنوان<br>Address</strong></td>
            </tr>
            <tr>
                <td><input type="text" value="{{ $agreement->client->passport_number ?? '' }}"></td>
                <td><strong>رقم الجواز<br>PASSPORT NUMBER</strong></td>
                <td><input type="text" value="admin@tadbeer-alebdaa.com"></td>
                <td><strong>البريد االلكتروني<br>Email</strong></td>
                <td rowspan="5" class="vertical-text">العامل المساعد<br>Domestic Worker</td>
            </tr>
            <tr>
                <td><input type="text" value="{{ $agreement->client->nationality ?? '' }}"></td>
                <td><strong>الجنسية<br>NATIONALITY</strong></td>
                <td>{{ ($contract->replaced_by_name ?? null) ? $contract->replaced_by_name : ($agreement->candidate_name ?? '') }}</td>
                <td><strong>اسم العامل<br>Name</strong></td>
            </tr>
            <tr>
                <td><input type="text" value="{{ $agreement->client->mobile ?? '' }}"></td>
                <td><strong>رقم الهاتف<br>PHONE NUMBER</strong></td>
                <td><input type="text" value="{{ $agreement->passport_no ?? '' }}"></td>
                <td><strong>رقم جواز السفر<br>Passport</strong></td>
            </tr>
            <tr>
                <td><input style="width:200px;" type="text" value="{{ $agreement->client->email ?? '' }}"></td>
                <td><strong>البريد الإلكتروني<br>EMAIL</strong></td>
                <td><input type="text" value="{{ $agreement->Nationality->name ?? ($agreement->nationality ?? '') }}"></td>
                <td><strong>الجنسية<br>Nationality</strong></td>
            </tr>
            <tr>
                <td><input type="text" value="{{ ($agreement && $agreement->agreement_start_date) ? \Carbon\Carbon::parse($agreement->agreement_start_date)->format('d-m-Y') : '' }}"></td>
                <td><strong>تاريخ بدء الاتفاقية<br>Agreement Start Date</strong></td>
                <td><input type="text" value="{{ ($agreement && $agreement->agreement_end_date) ? \Carbon\Carbon::parse($agreement->agreement_end_date)->format('d-m-Y') : '' }}"></td>
                <td><strong>تاريخ انتهاء الاتفاقية<br>Agreement End Date</strong></td>
            </tr>
        </table>
        <div class="terms-container">
            <div class="terms">
                <ul>
                    <li style="list-style:none;"><strong>Agreement Introduction:</strong></li>
                    <li>The First Party commits to providing a domestic helper registration service under the sponsorship of the First Party, who will handle the work permit and residency for the domestic helper for a certian period in exchange for an upfront fee agreed upon as: {{ $totalAmount }} AED.</li>
                    <li style="list-style:none;"><strong>Agreement Terms:</strong></li>
                    <li><strong>1 - Paid Fees:</strong> Non-refundable after the service has commenced.</li>
                    <li><strong>2 - Obligations of the First Party:</strong></li>
                    <li>Handling the work contract/work card/visa issuance/status adjustment/medical examination/ID card/residency for two years/ health insurance for 2 years.</li>
                    <li><strong>3 - Salaries:</strong></li>
                    <li>The first Party pays the worker’s salary,  which amounts to {{ $agreement->salary ?? '' }} AED per month through the Wage Protection System.</li>
                    <li>The Second Party pays the salaries to the First Party monthly, plus an administrative fee of 160 AED.</li>
                    <li><strong>4 - Payment Method:</strong></li>
                    <li>Payments are made by checks deposited in advance with the First Party for the contract period, or via bank transfer or cash payment at the center upon salary due date, no later than the fifth of each month.</li>
                    <li>In case of delay in salary payment by the Second Party, legal action will be taken.</li>
                    <li><strong>5 - Security Check:</strong></li>
                    <li>Used only in case of delayed salary transfer and non-response to 3 official notifications.</li>
                    <li>If the security check is used, the Second Party must replace it immediately to continue benefiting from the agreement.</li>
                    <li><strong>6 - Worker Transportation:</strong></li>
                    <li>The Second Party commits to transporting the worker to and from the center for medical examination and fingerprinting for the ID, otherwise, it is the responsibility of the First Party.</li>
                    <li><strong>7 - Salary Guarantee:</strong></li>
                    <li>The Second Party guarantees the worker receives their salary deposited by the First Party through the exchange office.</li>
                    <li><strong>8 - Worker Responsibility:</strong></li>
                    <li>The center is not responsible for the worker's escape or refusal to work.</li>
                    <li><strong>9 - Worker Rights:</strong></li>
                    <li>The worker is considered an employee of the center and under its sponsorship, enjoying all labor rights guaranteed by UAE labor law, working for the Second Party on a secondment basis, and residing with them as per the agreement.</li>
                    <li>The Second Party commits to employing the domestic helper according to the state laws and providing suitable housing and living conditions.</li>
                    <li><strong>10 - Worker Travel:</strong></li>
                    <li>In case the worker travels with the employer outside the country, the Second Party must notify the First Party, receive a letter approving the travel, and deposit a withdrawable check for the salaries for the period of the worker’s travel.</li>
                    <li><strong>11 - Agreement Duration:</strong></li>
                    <li>This agreement is valid for two years from the date of signing and cannot be extended without signing a new agreement.</li>
                    <li><strong>12 - Compliance with Terms:</strong></li>
                    <li>Both parties commit to complying with all terms and conditions stipulated in this agreement.</li>
                    <li><strong>13 - Agreement Amendments:</strong></li>
                    <li>No party has the right to change or amend this agreement without obtaining written consent from the other party.</li>
                    <li>Any amendments to this agreement are non-binding unless documented in a written agreement signed by both parties.</li>
                    <li><strong>14 - Agreement Termination:</strong></li>
                    <li>This agreement automatically terminates after the specified period, unless extended according to the stipulated terms.</li>
                    <li><strong>15 - Exchange of Official Notifications:</strong></li>
                    <li>Both parties must exchange official notifications, including any changes or amendments to this agreement, via registered mail.</li>
                    <li><strong>16 - Official Communication Channels:</strong></li>
                    <li>The phone number and email address mentioned in this agreement are the official communication channels. Proof of sending notifications is sufficient.</li>
                    <li><strong>17 - End-of-Contract Benefits:</strong></li>
                    <li>The Second Party commits to paying end-of-contract benefits to the mentioned worker as per the law (return ticket plus the equivalent of one month's salary for each year).</li>
                    <li><strong>18 - Worker Escape or Absence:</strong></li>
                    <li>In case the worker escapes or stops working, the Second Party undertakes to inform the First Party within a maximum period of 5 working days. The Second Party will bear the fees for canceling the worker or absconding him.</li>
                </ul>
                <ul class="rtl">
                    <li style="list-style:none;"><strong>مقدمة الاتفاقية:</strong></li>
                    <li>يلتزم الطرف الأول بتوفير خدمة عاملةٍ منزليةٍ تحت كفالته، ويتعهد باستخراج تصريح العمل والإقامة للعاملة لمدة محددة، وذلك مقابل رسم مقدَّم متفق عليه وقدره: <strong>{{ $totalAmount }} درهم إماراتي</strong>.</li>
                    <li style="list-style:none;"><strong>شروط الاتفاقية:</strong></li>
                    <li><strong>1 - الرسوم المدفوعة:</strong> غير قابلة للاسترداد بعد بدء الخدمة.</li>
                    <li><strong>2 - التزامات الطرف الأول:</strong></li>
                    <li>إتمام الإجراءات المتعلقة بعقد العمل/بطاقة العمل/إصدار التأشيرة/تعديل الوضع/الفحص الطبي/بطاقة الهوية/الإقامة لمدة سنتين/ التأمين الصحي لمدة سنتين.</li>
                    <li><strong>3 - الرواتب:</strong></li>
                    <li> يتعهد الطرف الثاني بدفع راتب العامل المساعد، والذي يبلغ {{ $agreement->salary }} درهم إماراتي شهرياً مباشرة إلى العامل.</li>
                    <li>يدفع الطرف الثاني الرواتب للطرف الأول شهريا، بالإضافة إلى رسم إداري قدره  160  درهم إماراتي</li>
                    <li><strong>4 - طريقة الدفع:</strong></li>
                    <li>يتم سداد المدفوعات عن طريق الشيكات المودعة مسبقًا لدى الطرف الأول لمدة العقد، أو عبر التحويل البنكي أو الدفع النقدي في المركز في تاريخ استحقاق الراتب، على ألا يتجاوز الخامس من كل شهر.</li>
                    <li>في حالة تأخر الطرف الثاني في دفع الراتب، سيتم اتخاذ الإجراءات القانونية.</li>
                    <li><strong>5 - شيك الضمان:</strong></li>
                    <li>يتم استخدامه فقط في حالة تأخير تحويل الراتب وعدم الاستجابة لثلاث إشعارات رسمية.</li>
                    <li>إذا تم استخدام شيك الضمان، يجب على الطرف الثاني استبداله فورًا للاستمرار في الاستفادة من الاتفاقية.</li>
                    <li><strong>6 - نقل العامل:</strong></li>
                    <li>يتعهد الطرف الثاني بنقل العامل من وإلى المركز لإجراء الفحص الطبي وأخذ بصمات الهوية. إذا فشل الطرف الثاني في ذلك، تكون المسؤولية على الطرف الأول.</li>
                    <li><strong>7 - ضمان الراتب:</strong></li>
                    <li>يتعهد الطرف الثاني بضمان استلام العامل لرواتبه التي يتم إيداعها من قبل الطرف الأول من خلال مكتب الصرافة.</li>
                    <li><strong>8 - مسؤولية العامل:</strong></li>
                    <li>المركز غير مسؤول عن هروب العامل أو رفضه العمل.</li>
                    <li><strong>9 - حقوق العامل:</strong></li>
                    <li>يُعتبر العامل موظفًا في المركز وتحت كفالته، ويتمتع بكافة الحقوق العمالية التي يضمنها قانون العمل الإماراتي، ويعمل لدى الطرف الثاني على أساس الإعارة، ويقيم معه وفقًا للاتفاق.</li>
                    <li>يتعهد الطرف الثاني بتوظيف العامل المنزلي وفقًا لقوانين الدولة وتوفير السكن المناسب وظروف معيشية ملائمة.</li>
                    <li><strong>10 - سفر العامل:</strong></li>
                    <li>في حال سفر العامل مع صاحب العمل خارج الدولة، يجب على الطرف الثاني إخطار الطرف الأول، والحصول على رسالة موافقة للسفر، وإيداع شيك سحب للرواتب خلال فترة سفر العامل.</li>
                    <li><strong>11 - مدة الاتفاقية:</strong></li>
                    <li>هذه الاتفاقية صالحة لمدة سنتين من تاريخ التوقيع ولا يمكن تمديدها دون توقيع اتفاقية جديدة.</li>
                    <li><strong>12 - الالتزام بالشروط:</strong></li>
                    <li>يتعهد الطرفان بالامتثال لجميع الشروط والأحكام المنصوص عليها في هذه الاتفاقية.</li>
                    <li><strong>13 - تعديلات الاتفاقية:</strong></li>
                    <li>لا يحق لأي طرف تغيير أو تعديل هذه الاتفاقية دون الحصول على موافقة خطية من الطرف الآخر.</li>
                    <li>أي تعديلات على هذه الاتفاقية غير ملزمة ما لم تكن موثقة في اتفاقية مكتوبة موقعة من كلا الطرفين.</li>
                    <li><strong>14 - إنهاء الاتفاقية:</strong></li>
                    <li>تنتهي هذه الاتفاقية تلقائيًا بعد انتهاء مدتها المحددة، ما لم يتم تمديدها وفقًا للشروط المنصوص عليها.</li>
                    <li><strong>15 - تبادل الإشعارات الرسمية:</strong></li>
                    <li>يجب على الطرفين تبادل الإشعارات الرسمية، بما في ذلك أي تغييرات أو تعديلات على هذه الاتفاقية، عبر البريد المسجل.</li>
                    <li><strong>16 - قنوات الاتصال الرسمية:</strong></li>
                    <li>الرقم الهاتفي وعنوان البريد الإلكتروني المذكوران في هذه الاتفاقية هما القنوات الرسمية للتواصل. يُعتبر إثبات إرسال الإشعارات كافيًا.</li>
                    <li><strong>17 - مستحقات نهاية الخدمة:</strong></li>
                    <li>يتعهد الطرف الثاني بدفع مستحقات نهاية الخدمة للعامل وفقًا للقانون (تذكرة العودة بالإضافة إلى ما يعادل راتب شهر عن كل سنة).</li>
                    <li><strong>18 - هروب العامل أو غيابه:</strong></li>
                    <li>في حالة هروب العامل أو توقفه عن العمل، يتعهد الطرف الثاني بإبلاغ الطرف الأول خلال فترة أقصاها 5 أيام عمل. يتحمل الطرف الثاني الرسوم المتعلقة بإلغاء العامل أو هروبه.</li>
                </ul>
            </div>
        </div>
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-title">Second Party (Employer) / الطرف الثاني (صاحب العمل)</div>
                <p>Name: <span class="signature-line">{{ ($agreement->client->first_name ?? '') }} {{ ($agreement->client->last_name ?? '') }}</span></p>
                <p>Signature: <span class="signature-line"></span></p>
                <p>Date: <span class="signature-line"></span></p>
            </div>
            <div class="signature-box">
                <div class="signature-title">First Party (Recruitment Office) / الطرف الأول (مكتب الاستقدام)</div>
                <p>Name: <span class="signature-line" style="text-align:center;">لعمالة املساعدةمركز االبداع لخدمات<br>ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER</span></p>
                <p>Signature: <span class="signature-line"></span></p>
                <p>Date: <span class="signature-line"></span></p>
            </div>
        </div>
        <div class="footer">
            <img src="{{ asset('assets/img/' . $footerFileName) }}" alt="Footer Image">
        </div>
    </div>
</body>
</html>
