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
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Agreement of {{ $agreement->candidate_name }}</title>
</head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;font-size:14px;line-height:1.5;background:#f9f9f9;">
    <div style="width:100%;margin:0 auto;background:#fff;">
        <div style="text-align:center;margin-bottom:20px;">
            <img src="{{ asset('assets/img/' . $headerFileName) }}" alt="Header Image" style="width:100%;height:auto;">
        </div>
        <table style="width:100%;border-collapse:collapse;background:#21ace0;margin-bottom:20px;">
            <tr>
                <td style="padding:10px;text-align:center;">
                    <input type="text" value="{{ $createdAt }}"
                        style="width:90%;padding:5px;font-size:12px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="padding:10px;text-align:center;">
                    <strong> (الباقة المرنة) اتفاقية تشغيل عامل مساعد<br>Domestic Worker Agreement (Flexible Package)</strong>
                </td>
                <td style="padding:10px;text-align:center;">
                    <input type="text" value="{{ $agreement->reference_no }}" readonly
                        style="width:90%;padding:5px;font-size:12px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="padding:10px;text-align:center;">
                    <strong>Agreement Number<br>اتفاقية رقم</strong>
                </td>
            </tr>
        </table>
        <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
            <tr>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ $agreement->client->name }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>اسم العميل<br>CUSTOMER&nbsp;NAME</strong></td>
                <td rowspan="8" style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;writing-mode:vertical-rl;transform:rotate(180deg);font-weight:bold;">Second&nbsp;Party<br>الطرف&nbsp;الثاني</td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="مركز الإبداع لخدمات العمالة المساعدة" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>مكتب الاستقدام<br>Tadbeer&nbsp;Center</strong></td>
                <td rowspan="3" style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;writing-mode:vertical-rl;transform:rotate(180deg);font-weight:bold;">First&nbsp;Party<br>الطرف&nbsp;الأول</td>
            </tr>
            <tr>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ $agreement->client->emirates_id }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>رقم الهوية<br>ID&nbsp;NUMBER</strong></td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="800-32332" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>رقم الهاتف<br>Phone&nbsp;Number</strong></td>
            </tr>
            <tr>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ $agreement->client->address }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>العنوان<br>ADDRESS</strong></td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="القرهود&nbsp;-&nbsp;دبي" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>العنوان<br>Address</strong></td>
            </tr>
            <tr>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ $agreement->client->passport_number }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>رقم الجواز<br>PASSPORT&nbsp;NUMBER</strong></td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="admin@tadbeer-alebdaa.com" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>البريد الإلكتروني<br>Email</strong></td>
                <td rowspan="5" style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;writing-mode:vertical-rl;transform:rotate(180deg);font-weight:bold;">العامل&nbsp;المساعد<br>Domestic&nbsp;Worker</td>
            </tr>
            <tr>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ $agreement->client->nationality }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>الجنسية<br>NATIONALITY</strong></td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ $agreement->candidate_name }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>اسم العامل<br>Name</strong></td>
            </tr>
            <tr>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ $agreement->client->mobile }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>رقم الهاتف<br>PHONE&nbsp;NUMBER</strong></td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ $agreement->passport_no }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>رقم جواز السفر<br>Passport</strong></td>
            </tr>
            <tr>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ $agreement->client->email }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>البريد الإلكتروني<br>EMAIL</strong></td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ $agreement->Nationality->name ?? $agreement->nationality }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>الجنسية<br>Nationality</strong></td>
            </tr>
            <tr>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ \Carbon\Carbon::parse($agreement->agreement_start_date)->format('d-m-Y') }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>تاريخ بدء الاتفاقية<br>Agreement&nbsp;Start&nbsp;Date</strong></td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;">
                    <input type="text" value="{{ \Carbon\Carbon::parse($agreement->agreement_end_date)->format('d-m-Y') }}" style="width:90%;padding:5px;border:none;background:transparent;pointer-events:none;">
                </td>
                <td style="border:1px solid #000;padding:10px;text-align:center;font-size:12px;"><strong>تاريخ انتهاء الاتفاقية<br>Agreement&nbsp;End&nbsp;Date</strong></td>
            </tr>
        </table>

        <div style="width:48%;float:left;padding-left:20px;margin-bottom:20px;font-size:14px;">
            <ul style="margin:0;padding:0;list-style:disc inside;">
                <li style="list-style: none;"><strong>Agreement Introduction:</strong></li>
                <li>The First Party commits to providing a domestic helper service under the sponsorship of the First Party, who will handle the work permit and residency for the domestic helper for a period of two years in exchange for an upfront fee agreed upon as: <span style="font-weight:bold;">{{ $totalAmount }} AED</span>.</li>
                <li>The parties agree that the duration of this contract shall extend from the date <span style="font-weight:bold;">{{ $agreementStart }}</span> to <span style="font-weight:bold;">{{ $agreementEnd }}</span>.</li>
                <li>The first party is responsible for completing procedures related to the employment contract/work card/visa issuance/status adjustment/medical examination/ID and residence of the domestic worker.</li>
                <li>The first party shall deposit the domestic worker’s salary monthly through the Wage Protection System.</li>
                <li>The second party shall pay the agreed-upon office fees monthly throughout the contract period.</li>
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
        </div>
        <div style="width:48%;float:left;margin-bottom:20px;direction:rtl;font-size:14px;">
            <ul style="margin:0;padding:0;list-style:disc inside;">
                <li style="list-style: none;"><strong>مقدمة الاتفاقية:</strong></li>
                <li>يتعهد الطرف الأول بتقديم خدمة عامل مساعد على كفالته، ويتولى إصدار تصريح العمل والإقامة للعامل المساعد لمدة سنتين مقابل رسوم مقدمة تم الاتفاق عليها وقدرها: <span style="font-weight:bold;">{{ $totalAmount }} درهم إماراتي</span>.</li>
                <li>يتفق الطرفان على أن مدة هذا العقد تمتد من تاريخ <span style="font-weight:bold;">{{ $agreementStart }}</span> إلى تاريخ <span style="font-weight:bold;">{{ $agreementEnd }}</span>.</li>
                <li>يتولى الطرف الأول استكمال الإجراءات المتعلقة بعقد العمل/بطاقة العمل/إصدار التأشيرة/تعديل الوضع/الفحص الطبي/الهوية والإقامة للعامل المساعد.</li>
                <li>يتعهد الطرف الأول بإيداع راتب العامل المساعد شهرياً عبر نظام حماية الأجور.</li>
                <li>يلتزم الطرف الثاني بدفع رسوم المكتب المتفق عليها شهرياً طوال مدة العقد.</li>
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
        <div style="clear:both;"></div>
        <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
            <tr>
                <td colspan="2" style="border:1px solid #000;text-align:center;font-weight:bold;font-size:16px;padding:10px;">SIGNATURES  الامضاءات</td>
            </tr>
            <tr>
                <td style="border:1px solid #000;width:50%;text-align:center;padding:40px;">
                    <div style="width:300px;height:40px;background:#ccc;margin:0 auto;"></div>
                    <div style="margin-top:10px;font-weight:bold;font-size:14px;">SECOND PARTY  الطرف الثاني</div>
                </td>
                <td style="border:1px solid #000;width:50%;text-align:center;padding:40px;">
                    <div style="font-weight:bold;font-size:14px;">FIRST PARTY  (مكتب الاستقدام)</div>
                    <div style="margin-top:10px;">مركز الإبداع لخدمات العمالة المساعدة</div>
                    <div>ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER</div>
                </td>
            </tr>
        </table>
        <div style="text-align:center;">
            <img src="{{ asset('assets/img/' . $footerFileName) }}" alt="Footer Image" style="width:100%;height:auto;">
        </div>
    </div>
</body>
</html>
