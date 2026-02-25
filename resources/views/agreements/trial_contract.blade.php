@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    // Subdomain-based header/footer filenames
    $subdomain       = explode('.', request()->getHost())[0] ?? 'default';
    $headerFileName  = strtolower($subdomain) . '_header.jpg';
    $footerFileName  = strtolower($subdomain) . '_footer.jpg';

    $fmt = fn($d) => $d ? Carbon::parse($d)->format('d/m/Y') : '';

    // Amount calculations
    if (!empty($agreement->monthly_payment) && $agreement->monthly_payment > 0) {
        $totalAmount = $agreement->monthly_payment;
        $received    = $agreement->monthly_payment;
        $remaining   = 0;
    } else {
        $totalAmount = $agreement->total_amount;
        $received    = $agreement->received_amount;
        $remaining   = max(0, $totalAmount - $received);
    }

    // Payment terms
    if (!empty($agreement->monthly_payment) && $agreement->monthly_payment > 0) {
        $payEn = 'monthly payment of (' . number_format($agreement->monthly_payment, 2) . ') each month.';
        $payAr = 'دفعة شهرية: (' . number_format($agreement->monthly_payment, 2) . ') كل شهر.';
    } else {
        if ($remaining == 0) {
            $payEn = 'one time payment.';
            $payAr = 'دفعة واحدة .';
        } else {
            $payEn = 'two installments: (' . number_format($received, 2) . ') upon initial agreement and (' . number_format($remaining, 2) . ') upon worker\'s arrival.';
            $payAr = 'دفعتین . الدفعة الأولى عند الاتفاق المبدئي: (' . number_format($received, 2) . ') .الدفعة الثانیة : (' . number_format($remaining, 2) . ') عند استلام العامل.';
        }
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement of {{ $agreement->candidate_name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page { size: A4; margin: 20mm; }
        body { font-family: Arial, Helvetica, sans-serif; background: #f9f9f9; margin: 0; padding: 0; font-size: 12px; line-height: 1.5; }
        .contract-container { width: 210mm; max-width: 210mm; margin: auto; background: #fff; padding: 20px; border: 1px solid #ddd; box-shadow: 0 4px 6px rgba(0,0,0,.1); }
        .header, .footer { text-align: center; margin: 0; padding: 0; }
        .header img, .footer img { max-width: 100%; height: auto; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table td, .table th { border: 1px dotted #000; padding: 10px; text-align: center; vertical-align: middle; }
        .table-solid td, .table-solid th { border: 1px solid #000; }
        .vertical-text { writing-mode: vertical-rl; transform: rotate(180deg); font-weight: bold; }
        .clause { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .clause p { width: 48%; margin: 0; text-align: justify; }
        .clause p:last-child { direction: rtl; }
        .signature-section { margin-top: 30px; display: flex; justify-content: space-between; gap: 20px; }
        .signature-box { flex: 1; border: 2px solid #000; padding: 20px; position: relative; }
        .signature-title { position: absolute; top: -12px; left: 20px; background: #fff; padding: 0 10px; font-weight: bold; }
        .signature-box p { margin: 15px 0; }
        .signature-line { border-bottom: 1px solid #000; display: inline-block; width: 80%; margin: 5px 0; }
        .signature-label { font-weight: bold; margin-right: 10px; display: inline-block; width: 20%; }
        .btn { display: inline-block; margin: 0 10px; padding: 10px 20px; color: #fff; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .btn-download { background: #28a745; }
        .btn-back { background: #6c757d; }
    </style>
</head>
<body>
    <div class="contract-container">

        <div style="text-align:center; margin-bottom:20px">
            <a href="{{ route('download.agreement', $agreement->reference_no) }}" class="btn btn-download">
                <i class="fa fa-download"></i> Download Agreement
            </a>
            <a href="{{ route('agreements.index') }}" class="btn btn-back">
                <i class="fa fa-arrow-left"></i> Back to Agreements
            </a>
        </div>

        <div class="header">
            <img src="{{ asset('assets/img/' . $headerFileName) }}">
        </div>

        <table class="table">
            <tr>
                <td>{{ $agreement->created_at ? $agreement->created_at->format('d/m/Y') : '' }}</td>
                <td>
                    <strong>Domestic worker Contract (Traditional Package)</strong><br>
                    <strong>عقد استقدام عامل مساعد (الباقة التقليدية)</strong>
                </td>
                <td>Agreement Number<br><strong>اتفاقية رقم</strong></td>
                <td style="font-weight:bold">{{ $agreement->reference_no }}</td>
            </tr>
        </table>

        <table class="table table-solid">
            <tr>
                <td>{{ $agreement->client->first_name }} {{ $agreement->client->last_name }}</td>
                <td><strong>اسم صاحب العمل<br>SPONSER NAME</strong></td>
                <td rowspan="7" class="vertical-text"><strong>SECOND PARTY</strong><br>الطرف الثاني</td>
                <td>AL EBDAA DOMESTIC WORKERS CENTRE</td>
                <td><strong>مكتب الاستقدام<br>Tadbeer Center</strong></td>
                <td rowspan="3" class="vertical-text"><strong>FIRST PARTY</strong><br>الطرف الأول</td>
            </tr>
            <tr>
                <td>{{ $agreement->client->emirates_id }}</td>
                <td><strong>رقم الهوية<br>ID NUMBER</strong></td>
                <td>800 32332</td>
                <td><strong>رقم الهاتف<br>Phone NUMBER</strong></td>
            </tr>
            <tr>
                <td>{{ $agreement->client->address }}</td>
                <td><strong>العنوان<br>ADDRESS</strong></td>
                <td>AL GARHOUD, DUBAI, UAE</td>
                <td><strong>العنوان<br>Address</strong></td>
            </tr>
            <tr>
                <td>{{ $agreement->client->nationality }}</td>
                <td><strong>الجنسية<br>NATIONALITY</strong></td>
                <td>{{ $agreement->candidate_name }}</td>
                <td><strong>اسم العامل<br>Name</strong></td>
                <td rowspan="3"><strong>العامل المساعد<br>Domestic worker</strong></td>
            </tr>
            <tr>
                <td>{{ $agreement->client->mobile }}</td>
                <td><strong>رقم الهاتف<br>PHONE NUMBER</strong></td>
                <td>{{ $agreement->passport_no }}</td>
                <td><strong>رقم جواز السفر<br>Passport</strong></td>
            </tr>
            <tr>
                <td>{{ $agreement->client->state ?? '' }}</td>
                <td><strong>الإمارة<br>EMIRATE</strong></td>
                <td>{{ $agreement->Nationality->name ?? $agreement->nationality }}</td>
                <td><strong>الجنسية<br>Nationality</strong></td>
            </tr>
        </table>

        <div>
            {{-- Clause 1 with received & remaining --}}
            <div class="clause">
                <p>
                    <strong>Article&nbsp;1: Contract and Recruitment Office Fees</strong><br>
                    The second party agrees to pay the first party recruitment fees amounting to
                    <strong>{{ number_format($totalAmount, 2) }}</strong> Dirhams
                    (received: <strong>{{ number_format($received, 2) }}</strong>,
                    remaining: <strong>{{ number_format($remaining, 2) }}</strong>).
                    Payment will be made in {{ $payEn }}
                </p>
                <p>
                    <strong>البند الأول: التعاقد واتعاب مكتب الاستقدام</strong><br>
                    تم الاتفاق على أن يدفع الطرف الثاني إلى الطرف الأول رسوم الاستقدام وقدرها
                    <strong>{{ number_format($totalAmount, 2) }}</strong> درهم
                    (المستلم: <strong>{{ number_format($received, 2) }}</strong>،
                    المتبقي: <strong>{{ number_format($remaining, 2) }}</strong>).
                    {{ $payAr }}
                </p>
            </div>

            {{-- Clause 2 --}}
            <div class="clause">
                <p>
                    <strong>Article&nbsp;2: Probation Period</strong><br>
                    The worker will undergo a six-month probation period starting from the date of employment.
                </p>
                <p>
                    <strong>البند الثاني: فترة التجربة</strong><br>
                    يوضع العامل تحت التجربة لمدة ستة أشهر من تاريخ تسلمه العمل.
                </p>
            </div>

            {{-- Clause 3 --}}
            <div class="clause">
                <p>
                    <strong>Article&nbsp;3: Obligations of the First Party (Recruitment Office)</strong><br>
                    The office commits to providing a worker within 30&nbsp;days of entry-permit issuance and conducting a medical examination within 30&nbsp;days before recruitment. No additional charges beyond the ministry-approved fee will be levied. The office accepts a returned worker in case of conflict with the employer.
                </p>
                <p>
                    <strong>البند الثالث: التزامات الطرف الأول</strong><br>
                    يتعهد المركز بتوفير عامل خلال مدة لا تتجاوز ثلاثين يومًا من تاريخ إذن الدخول، وإجراء الفحص الطبي للعامل المساعد قبل استقدامه خلال مدة لا تزيد على 30 يومًا للتأكد من لياقته الصحية، واستقدام العامل وفق متطلبات صاحب العمل المحددة في الاتفاق المبدئي بين المكتب وصاحب العمل، وعدم تحصيل أي مبالغ إضافية على مبلغ الاستقدام المعتمد من الوزارة، واستلام العامل المساعد من صاحب العمل في حال وجود خلاف بين الطرفين.
                </p>
            </div>

            {{-- Clause 4 --}}
            <div class="clause">
                <p>
                    <strong>Article&nbsp;4: Obligations of the Second Party (Employer)</strong><br>
                    The employer agrees to pay government fees and complete the worker’s employment procedures, provide suitable accommodation, meals and work necessities, grant a weekly day off, bear medical expenses, and not employ the worker elsewhere. The employer must inform the Ministry within 5 days of the worker’s unjustified absence and pay all dues at the end of the contract.
                </p>
                <p>
                    <strong>البند الرابع: التزامات الطرف الثاني</strong><br>
                    يدفع صاحب العمل الرسوم الحكومية ويلتزم باستكمال إجراءات تصريح العمل للعامل المساعد، وتوفير المسكن والوجبات والملابس الملائمة ومستلزمات العمل، وتحمل تكاليف العلاج وإصابات العمل، وعدم تشغيل العامل لدى الغير أو بمهنة مخالفة، وعدم تحصيل أي مبالغ من العامل، ويستحق العامل الأجر من تاريخ دخوله الدولة على أن يتم تسديده خلال عشرة أيام من تاريخ استحقاقه، وأداء جميع مستحقات العامل عند انتهاء العقد، وإبلاغ الوزارة خلال خمسة أيام من انقطاع العامل عن العمل دون مبرر.
                </p>
            </div>

            {{-- Clause 5 --}}
            <div class="clause">
                <p>
                    <strong>Article&nbsp;5: Responsibilities of the First Party in Case of Contract Violation</strong><br>
                    Within the first month, the office refunds the entire recruitment fee plus government fees if the worker runs away, refuses to work or is medically unfit. After the first month and within the six-month probation period, a partial refund is due. Beyond probation, the office will either refund part of the fee or provide a replacement worker, and will cover repatriation costs.
                </p>
                <p>
                    <strong>البند الخامس: مسؤولية الطرف الأول في حال الإخلال بشروط هذا العقد خلال فترة التجربة (6 أشهر)</strong><br>
                    في حال عدم الكفاءة المهنية أو سوء السلوك الشخصي للعامل، أو تركه العمل، أو إنهاء العقد في غير الأحوال المرخص بها، أو عدم لياقته الطبية، يلتزم المكتب برد كامل مبلغ الاستقدام والرسوم الحكومية خلال الشهر الأول. بعد الشهر الأول وحتى نهاية فترة التجربة يرد جزء من المبلغ، وبعد فترة التجربة يحق لصاحب العمل استرداد جزء من المبلغ أو الحصول على عامل بديل، ويتحمل المكتب نفقات إعادة العامل إلى بلده.
                </p>
            </div>

            {{-- Clause 6 --}}
            <div class="clause">
                <p>
                    <strong>Article&nbsp;6: Refund Calculation</strong><br>
                    Refund = (Total recruitment cost ÷ Worker’s contract duration in months) × Remaining months. The office must reimburse the amounts stated in Article 5 within 14 working days of the worker’s return or the absence report.
                </p>
                <p>
                    <strong>البند السادس: الاسترداد</strong><br>
                    طريقة احتساب مبلغ الاسترداد = (إجمالي تكلفة الاستقدام ÷ مدة العقد بالشهر) × المدة المتبقية من العقد. في حال هروب العامل أو رفضه العمل يُرد جزء من المبلغ بعد انقضاء الشهر الأول وحتى نهاية العقد، ويُرد كامل المبلغ مع الرسوم الحكومية إذا ثبت عدم لياقة العامل خلال فترة التجربة. يلتزم المكتب برد المبالغ خلال 14 يوم عمل من تاريخ إرجاع العامل أو الإبلاغ عن انقطاعه.
                </p>
            </div>

            {{-- Clause 7 --}}
            <div class="clause">
                <p>
                    <strong>Article&nbsp;7: Jurisdiction</strong><br>
                    In case of disputes, both parties will first seek resolution through the Ministry; if unresolved, the matter will be referred to the competent court in accordance with Federal Decree-Law No. 9 of 2022 on auxiliary service workers.
                </p>
                <p>
                    <strong>البند السابع: الاختصاص القضائي</strong><br>
                    في حال حدوث نزاع بين الطرفين وفشلهما في تسويته وديًا، يحال إلى الوزارة التي تتخذ ما تراه مناسبًا وفق مرسوم بقانون اتحادي رقم 9 لسنة 2022 بشأن عمال الخدمة المساعدة، وإذا لم تتم التسوية خلال أسبوعين يحال النزاع إلى المحكمة المختصة.
                </p>
            </div>

            {{-- Clause 8 --}}
            <div class="clause">
                <p>
                    <strong>Article&nbsp;8: Contract Drafting</strong><br>
                    This contract is prepared in triplicate; one copy for each party and the third deposited with the Ministry.
                </p>
                <p>
                    <strong>البند الثامن: تحرير العقد</strong><br>
                    حُرر هذا العقد من ثلاث نسخ بعد توقيعه من الطرفين؛ تسلم نسخة للطرف الأول وأخرى للطرف الثاني وتودع الثالثة لدى الوزارة.
                </p>
            </div>
        </div>

        {{-- Signatures --}}
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-title">SECOND PARTY (Employer) / الطرف الثاني (صاحب العمل)</div>
                <p><span class="signature-label">Name:</span> <span class="signature-line">{{ $agreement->client->name }}</span></p>
                <p><span class="signature-label">Signature:</span> <span class="signature-line"></span></p>
                <p><span class="signature-label">Date:</span> <span class="signature-line">{{ $fmt(now()) }}</span></p>
            </div>
            <div class="signature-box">
                <div class="signature-title">FIRST PARTY (Recruitment Office) / الطرف الأول (مكتب الاستقدام)</div>
                <p><span class="signature-label">Name:</span> <span class="signature-line">ALEBDAA WORKERS EMPLOYMENT SERVICES CENTER</span></p>
                <p><span class="signature-label">Signature:</span> <span class="signature-line"></span></p>
                <p><span class="signature-label">Date:</span> <span class="signature-line">{{ $fmt(now()) }}</span></p>
            </div>
        </div>

        <div class="footer" style="margin-top:20px">
            <img src="{{ asset('assets/img/' . $footerFileName) }}">
        </div>
    </div>
</body>
</html>
