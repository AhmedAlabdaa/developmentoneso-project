@php
    $serverName = $_SERVER['SERVER_NAME'];
    $subdomain = explode('.', $serverName)[0];
    $headerFileName = strtolower($subdomain) . '_header.jpg';
    $footerFileName = strtolower($subdomain) . '_footer.jpg';
    $formattedDate = fn($date) => $date ? \Carbon\Carbon::parse($date)->format('d M Y') : 'N/A';
    $logoFileName = strtolower($subdomain) . '_logo.png';
@endphp
@include('role_header')
<style type="text/css">
.container {
        max-width: 210mm;
        min-height: 297mm;
        padding: 10mm;
        background: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .row {
        margin-bottom: 10px;
    }
    h5 {
        font-size: 14px;
        margin-bottom: 10px;
        text-align: center;
        font-weight: bold;
    }
    p {
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 5px;
    }
    .section-title{font-size: 13px;font-weight: bold;}
    .arabic{direction: rtl;}
</style>        
<div class="container">
    <div style="text-align: center; margin: 10px 0;">
        <a href="{{ route('wc_contract.pdf.download', ['candidate' => $candidate->reference_no]) }}" class="btn btn-primary" title="Download Contract">
            <i class="bi bi-download me-2"></i> Download
        </a>
        <a href="{{ route('wc_contract.pdf.view', ['candidate' => $candidate->reference_no]) }}" class="btn btn-primary" title="View PDF">
            <i class="bi bi-file-pdf me-2"></i> View PDF
        </a>
        <a href="{{ route('candidates.index') }}" class="btn btn-primary" title="Back to Candidates">
            <i class="bi bi-arrow-left me-2"></i> Back to Candidates
        </a>
    </div>
    <img src="{{ asset('assets/img/' . $headerFileName) }}" style="width:100%;">
    <div class="row">
        <div class="col-md-4" style="border:1px solid;text-align: left;">
            <h5 class="mt-1">የስራ ውል</h5>
            <p>ይህ የስራ ውል ከዚህ በታች በተመለከቱት ተዋዋይ ወገኖች መካከል ተፈፅሟል።</p>
            <p><strong>ሀ. አሠሪ፣</strong></p>
            <p>ሙሉ ስም</p>
            <p>አድራሻ፡</p>
            <p>ፖ.ሣ.ቁ </p>
            <p>ስልክ ቁጥር፡ </p>
            <p><strong>ለ. ኤጀንሲ፣</strong></p>
            <p>ሙሉ ስም </p>
            <p>አድራሻ፡</p>
            <p>ስልክ ቁጥር፡ </p>
            <p><strong>ሐ. ኤጀንት፣</strong></p>
            <p>ሙሉ ስም </p>
            <p>አድራሻ፡</p>
            <p>ስልክ ቁጥር፡ </p>
            <p>ፋክስ _____ ፖ.ሣ.ቁ ____</p>
            <p><strong>መ. ሠራተኛ</strong></p>
            <p>ሙሉ ስም</p>
            <p>ዕድሜ ___________ ፆታ _________</p>
            <p>የጋብቻ ሁኔታ </p>
            <p>የት/ት ደረጃ/ሙያ </p>
            <p>የፓስፖርት ቁ. </p>
            <p>ፓስፖርት የተሰጠበት ቀንና ቦታ</p>
            <p><strong>በአደጋ ጊዜ የቅርብ ተጠሪ</strong></p>
            <p>ሙሉ ስም </p>
            <p>አድራሻ፡</p>
            <p>ስልክ ቁጥር፡ </p>
            <p>በሚከተሉት ግዴታዎችና ሁኔታዎች ለመገዛት</p>
            <p>ወደውና ፈቅደው ተዋውለዋል።</p>
            <p>1. ተቀባይ አገር </p>
            <p>2. የስራው ስፍራ /ቦታ/ </p>
            <p>3. የስራው ውል የሚቆይበት ጊዜ </p>
            <p>ሠራተኛው ለሥራ ወደ ሚሰማራበት ስፍራ</p>
            <p>ለመሄድ ከኢትዮጵያ ከሚለቅበት ጊዜ አንስቶ</p>
            <p>4. የሙያው አይነት </p>
            <p>5. የወር ደመወዝ </p>
            <p>6. ክፍያው የሚፈፀምበት ጊዜ</p>
            <p>7. መደበኛ የስራ ሰዓት </p>
            <p>8. የዕረፍት ሰዓት </p>
            <p>9. የትርፍ ሰዓት ስራ ክፍያ </p>
            <p>ሀ. ከመደበኛ የስራ ሰዓት በላይ ለሚሰራ ስራ</p>
            <p>ለ. በተወሰነ የዕረፍትና የበዓል ቀናት ለሚሰራ ስራ</p>
            <p>10. ዕረፍት ከሙሉ ክፍያ ጋር</p>
            <p>ሀ. የሳምንት እረፍት </p>
            <p>ለ. የዓመት እረፍት </p>
            <p>ሐ. የህመም ዕረፍት</p>
            <p>መ. የሌሎች </p>
            <p>11. ነጻ ደርሶ መልስ ትኬት</p>
            <p>12. በቂ፣ የተመጣጠነ ነጻ ምግብና ምቹ የመኖሪያ ቤት
            ወይም ማካካሻ አበል</p>
            <p>13. ነጻ ህክምና አገልግሎት ከመድሃኒት አቅርቦት
            ጭምር</p>
            <p>14. በአሰሪው የተገባ የሰራተኛው የግል ህይወት እና
            አደጋ ኢንሹራንስ</p>
            <p>15. ከዚህ የሥራ ውል ቆይታ ጊዜ ውስጥ ሠራተኛው
            ቢሞት አስክሬኑ እና የግል ንብረቶቹ በአሠሪው ወጪ
            ወደ ኢትዮጵያ መመለስ፡፡ ምናልባት አስክሬኑ ወደ
            ኢትዮጵያ መላክ የማይቻል ሆኖ ሲገኝ የሟቿን የቅርብ
            ዘመድ እና ወይም የኢትዮጵያ ሚሲዮን ኤምባሲ ቋሚ
            መልዕክተኛ ጽ/ቤት፤ ጉዳይ አስፈፃሚ ወይ የክብር
            ቆንስላ) በሚያደርጉት የቅድሚያ ስምምነት መሠረት
            ተገቢውን ማድረግ ይቻላል፡፡</p>
            <p>16. ሠራተኛው አግባብ ባለው የባንክ አሠራር ወይም
            ሕጋዊ በሆነ በሌላ መንገድ ቨመጠቀም ደመዎዙን ወደ
            አገሩ መላክ እንዲችል አሠሪው መርዳት ይኖርበታል።</p>
            <p>17. የሥራ ውል መቋረጥ፤ የሥራ ውሉ የሚቋረጥበት
            ምክንያቶች ሊጨምር ይችላል፡፡
            ሀ. በአሠሪው የሚደረግ የሥራ ውል መቋረጥ ፣ አሠሪው
            አንዳችም ማስጠንቀቂጣ ለሠራተኛው ሳይሰጥ ይህን
            የሥራ ውል በሚከተሉት በቂ ምክንያቶች ሊያቋርጥ
            ይችላል፤ በሠራተኛው ጉልህ፣ የሥራ ምግባረ ብልሹነት
            ፤የአሠሪውን ሕጋዊ ትዕዛዝ ሆን ብሎ ያለመወጣት
            ልምድ ያለበቂ ምክንያት በተደጋጋሚ ከሥራ
            የመቅረት፤ የድርጅቱን ሚስጥሮች የመግለፅና
            የመሳሰሉት ወይም ይን የሥራ ውል ሲጥስ፤
            ለ. በሠራተኛው የሚደረግ የሥራ ውል መቋረጥ፤
            ሠራተኛው አንዳችም ማስጠንቀቂያ ለአሠሪው ሳይሰጥ
            ይህን የስራ ውል በሚከተሉት ምክያቶች ሊያቋርጥ
            ይችላል። የአሰሪው ወይም የወኪሉ ከባድ ስድብ
            አሰሪው ወይም ወኪሉ ለሰራተኛው የሚያደርገው
            ኢሰብዐዊነትና አግባብነት የሌለው አያያዝ የአሰሪውን
            ወይም የወኪሉን በሰራተኛው ላይ የወንጀል ድርጊት
            መፈጸም ወይም የወኪሎችን ህጎች የዚህን ስራ ውል
            መጣስ።
            ሐ. ሰራተኛው የ30 ቀን የቅድሚያ የጽሁፍ
            ማስጠንቀቂያ ለ አሰሪው በመስጠት ይህንን የስራ ውል
            በማናቸውም ምክንያት ማቋረጥ ይችላል።</p>
            <p>18. እድሳት ይህ የሥራ ውል በጋራ ስምምነት ሊታደስ
            ይችላል፡፡</p>
            <p>19. ማሻሻል እና መለወጥ ፤ በዚህ የሥራ ውል ላይ
            የሚደረግ የሠራተኛውን ጥቅም የሚቀንስ ማሻሻያ፤
            ለውጥ እና የመሳሰሉት የሠራተኛና ማኅበራዊ ጉዳይ
            ሚኒስቴር ፈቃድ ከሌለው በቀር ውጤት አይኖረውም።</p>
            <p>20. የሥራ ክርክር አፈታት፤ ማንኛውም ከሥራ ውሉ
            ጋር የተዛመደ የይግባኝ ጥያቄ እና ቅሬታ በኩባንያው
            ፖሊሲ፤ መመሪያ፤ ደንብ እና ሕጎች መሠረት
            ይፈታል፡፡ይህ ሳይሳካ ቢቀር ጊዜ አግባብ ያለው
            የኢትዮጵያ ሚሊዮን (የኢትዮጵያ ኤምባሲ ቋሚ
            መልዕክተኛ ጽ/ቤት ፤ ጉዳይ አስፈፃሚ ወይም የክብር
            ቆንስላን ተሳታፊ በሆነበት ጉዳይ በስምምነት እንዲፈታ
            ጥረቱ ካልተሳካም ቅሬታ ባለው ወይም አግባብ ሲሆን
            የመንግስት አካል እንዲያቀርቡ ይደረጋል፡፡</p>
            <p>21. ሠራተኛው የአሠሪውን መመሪያ ማክበር እና
            አግባብ ባለው የተቀባይ አገር ሕጎች መኖር
            ይኖርበታል።</p>
            <p>22. አሠሪው ለሠራተኛው አስፈላጊውን የመግቢያ ቪዛ
            እና ሕጋዊ የሥራ ፈቃድ ከተቀባይ አገር የማግኘት
            ኃላፊነት አለበት።</p>
            <p>23. ተፈፃሚነት ያለው ሕግ፤ ከላይ ከተመለከቱት
            አንቀጾች ጋር የሚግባባም ሌሎች ግዴታዎችና
            የሥራ ውለታዎች አግባብ ያለው ሕጎች ተፈፃሚነት
            ይኖረዋል፡፡</p>
            <p>24. አሠሪው ይህን የሥራ ውል ቢጥስ ኤጀንሲው
            በጋራ እና በተናጠል ተጠያቂ ለመሆን ተስማምቷል፡፡</p>
            <p>25. ይህ የሥራ ውል በ4 ቅጂ ተዘጋጅቶ ኤጀንሲው ፤
            አሠሪው እና ሠራተኛው አንድ አንድ ይደርሳቸዋል፡፡
            አንድ ኮፒ በሠራተኛና ማኅበራዊ ጉዳይ ሚኒስቴር
            እንዲቀመጥ ይደረጋል።</p>
            <p style="font-size:13px;font-weight: bold;text-align: center;">ይህ የስራ ውል ዛሬ</p>
            <p>ቀን </p>
            <p>ሰራተኛ </p>
            <p>አሰሪ </p>
            <p style="font-size:13px;font-weight: bold;text-align: center;">የግል ስራና ሰራተኛ አገናኝ ኤጀንሲ</p><br>
            <p></p>
            <p style="text-align: center;">ፊርማ</p>
            <p style="font-size:13px;font-weight: bold;text-align: center;">የውጭ ኤጀንት</p><br>
            <p></p>
            <p style="text-align: center;">ፊርማ</p><br>
            <p style="font-weight:bold;">እማኞች</p>
            <p>1. ሙሉ ስም</p>
            <p>አድራሻ</p>
            <p>ስ.ቁ _______ፊርማ______</p>
            <p>2. ሙሉ ስም</p>
            <p>አድራሻ</p>
            <p>ስ.ቁ ______ፊርማ______</p>
        </div>
        <div class="col-md-4" style="border-top: 1px solid;border-bottom: 1px solid;text-align: left;">
            <h5 class="mt-1">CONTRACT AGREEMENT</h5>
            <p>This work contract shall be executed and concluded between and to:</p>
            <p class="section-title">A. Employer</p>
            <p>Name: {{ $candidate->client ? $candidate->client->first_name . ' ' . $candidate->client->last_name : 'N/A' }}</p>
            <p>Address:  {{ $candidate->client ? $candidate->client->address : 'N/A' }}</p>
            <p>Phone No: {{ $candidate->client ? $candidate->client->mobile : 'N/A' }}</p>
            <p>ID: {{ $candidate->client ? $candidate->client->emirates_id : 'N/A' }}</p>
            <p class="section-title">B. Agency</p>
            <p>Name: </p>
            <p>Address: </p>
            <p>Phone No: </p>
            <p class="section-title">C. Agency Representative</p>
            <p>Name: </p>
            <p>Address: </p>
            <p>Phone No: </p>
            <p>Fax: </p>
            <p>P.O.Box: </p>
            <p class="section-title">D. Employee</p>
            <p>Name: {{ $candidate->candidate_name }}</p>
            <p>Age: {{ $candidate->age }}</p>
            <p>Sex: {{ $candidate->gender }}</p>
            <p>Social Status: {{ $candidate->marital_status }}</p>
            <p>Passport: {{ $candidate->passport_no }}</p>
            <p>Education: {{ $candidate->education_level }}</p>
            <p>Occupation: </p>
            <p>Date & Issue Place:</p>
            <p class="section-title">The person contacted at the time of the accident</p>
            <p>Full Name: DITA MUHAMMED</p>
            <p>Address: ARSI</p>
            <p>Phone No: +2519140224332</p>
            <p class="section-title">Voluntarily bound by the following terms and conditions:</p>
            <p>1. Host Country: </p>
            <p>2. Employment Site: </p>
            <p>3. Duration of Contract: </p>
            <p>Commencing of Employee’s Departure from Ethiopia to the employment site</p>
            <p>4. Profession: </p>
            <p>5. Monthly Salary: </p>
            <p>6. The biography of the payment: </p>
            <p>7. Normal working hours: </p>
            <p>8. Rest time: </p>
            <p>9. Overtime:</p>
            <p>A: To work more than normal: </p>
            <p>B: To work on a specific day off and holiday: </p>
            <p>10. Full payment Leave:</p>
            <p>a. Weekly rest: </p>
            <p>b. Annual vacation: </p>
            <p>c. Sick leave: </p>
            <p>d. Others: </p>
            <p>11. Free round-trip ticket</p>
            <p>12. Free, adequate, and balanced food, free housing allowance or compensation allowance.</p>
            <p>13. Free medical service and facilities including medicine</p>
            <p>14. Personal life and accident insurance covered by the employer</p>
            <p>15. In the event of death of the employee during the term of this agreement his remains and personal belongings shall be repatriated to the point of origin. In case the repatriation of remains is not possible, the same may be disposed of as appropriate upon prior approval of the employee's next of kin and/or by the appropriate Ethiopian missions (Ethiopian embassy permanent mission general consulate office charges de affairs honorary consulate general).</p>
            <p>16. The employer shall assist them in remitting his salary through the proper banking channel or other means authorized by law</p>
            <p>17. Termination: ground for termination of the employment contract may include the following:</p>
            <p>a) Termination by the employer: the employer may terminate this contract without serving any notice to the employee for any of the following just cases: serious misconduct, disobedience of employer's lawful orders, habitual neglect of duties, absenteeism, revealing secrets of establishment, or when the employee violates terms of this contract of agreement.</p>
            <p>b) Termination by the employee: the employee may terminate this contract without serving any notice to the employer for any of the following just causes: serious insult by the employer or his representative, inhuman and unbearable treatment accorded to the employee by the employer or his representative.</p>
            <p>c) The employee may terminate this contract for any reason by serving 30 days advance written notice to the employer.</p>
            <p>18. Renewal: this contract may be renewed by mutual agreement.</p>
            <p>19. Modification and alteration: any modification, alteration and the like made in this contract unfavorable to the worker without the consent of the ministry of labor and social affairs shall not have any effect.</p>
            <p>20. Settlement of disputes: all claims and complaints related to the employment contract of the employee shall be settled in accordance with the company's policies, rules, regulations, and law. In case the settlement fails the matter shall be settled amicably with the involvement of the appropriate Ethiopian mission (embassy, permanent mission, general consulate office charges de affairs or honorary consulate general). In case the amicable settlement fails, the matter shall be submitted to the competent or appropriate government body in (host country) or in Ethiopia at the option of the complaining party.</p>
            <p>21. The employee shall observe employer's company rule and abide by the pertinent laws of the host country.</p>
            <p>22. The employer is responsible to obtain the necessary entry visa and legal work permit for the employee from the host country.</p>
            <p>23. Applicable law: other terms and conditions of employment which are consistent with the above provisions shall be governed by the pertinent laws………………………</p>
            <p>24. If this contract of employment is violated by the employer, the agency has agreed to be held responsible jointly and separately.</p>
            <p>25. This contract of employment is drawn in four the agency, the employer and the employee will be provided one each and the one copy will be deposited in the ministry of labor and social affairs</p>
            <p class="section-title">We here by sign this contract this:</p>
            <p>15DAY OF JUNE 2024</p>
            <p class="section-title">ADEY FOREIGN EMPLOYMENT AGENT PLC</p>
            <p>Agency signature</p>
            <p class="section-title" style="text-align:center;">KHALID GHANEM S H AL-KUWARI</p>
            <p style="text-align:center;">Employer Signature</p><br>
            <p class="section-title" style="text-align:center;">SEMIRA MUHAMMED HASSEN</p>
            <p style="text-align: center;">Employee Signature</p> <br>
            <p class="section-title" style="text-align:center;">Agency Representative</p>
            <p class="section-title">VIENNA MANPOWER</p>
            <p>Signature</p>
            <p class="section-title">Witnesses</p>
            <p>1. Full Name HANAN GEBRILE</p>
            <p>2. Address QATAR DOHA ALKHARTIYAT</p>
            <p>Tel no :+97470007899</p>
            <p>Signature</p>
        </div>
        <div class="col-md-4 arabic" style="border:1px solid;text-align: right;">
            <h5 class="mt-1">عقد العمل</h5>
            <p class="section-title">أ. الموظف</p>
            <p>الاسم الكامل: </p>
            <p>العنوان: </p>
            <p>صندوق البريد: </p>
            <p>رقم الهاتف: </p>
            <p class="section-title">ب. وكالة</p>
            <p>الاسم الكامل: </p>
            <p>العنوان: </p>
            <p>صندوق البريد: </p>
            <p>رقم الهاتف: </p>
            <p class="section-title">ت. ممثل الوكالة</p>
            <p>الاسم الكامل: </p>
            <p>العنوان: </p>
            <p>صندوق البريد: </p>
            <p>رقم الهاتف: </p>
            <p class="section-title">الموظف</p>
            <p>الاسم الكامل: </p>
            <p>العمر: </p>
            <p>الجنس: </p>
            <p>الحالة الاجتماعية: </p>
            <p>المستوى التعليمي: </p>
            <p>رقم جواز السفر: </p>
            <p>تاريخ ومكان الإصدار: </p>
            <p class="section-title">المتعاقد عليه وقت وقوع الحادث:</p>
            <p>الاسم الكامل: </p>
            <p>العنوان: </p>
            <p>صندوق البريد: </p>
            <p>رقم الهاتف: </p>
            <p class="section-title">طوعيًا ملتزمًا بالشروط والأحكام التالية:</p>
            <p>1. البلد المضيف: </p>
            <p>2. موقع العمل: </p>
            <p>3. مدة الاتصال: </p>
            <p>الموظف من إثيوبيا إلى الموقع إذا كان التوظيف.</p>
            <p>4. نوع المهنة: </p>
            <p>5. الراتب الشهري: </p>
            <p>6. سيرة الدفع: </p>
            <p>7. ساعات العمل العادية: </p>
            <p>8. وقت الراحة: </p>
            <p>9. بعد فوات الوقت:</p>
            <p>أ. العمل أكثر من المعتاد: </p>
            <p>ب. العمل في يوم عطلة وعطلة محددة: </p>
            <p>10. إجازة السداد كاملة:</p>
            <p>الراحة الأسبوعية: </p>
            <p>الإجازة السنوية: </p>
            <p>الإجازة المرضية: </p>
            <p>الآخرين: </p>
            <p>11. تذكرة مجانية ذهابا وإيابا</p>
            <p>12. مجاني وكاف ومتوازن الغذاء بدل السكن المجاني أو بدل التعويض.</p>
            <p>13. الخدمات والمرافق الطبية المجانية بما في ذلك الأدوية.</p>
            <p>14. الحياة الشخصية والحوادث المغطاة من قبل صاحب العمل.</p>
            <p>15. في حالة وفاة الموظف خلال مدة هذه الاتفاقية، يجب إعادة رفاته وممتلكاته الشخصية إلى موطنها الأصلي. في حالة عدم إمكانية إعادة الرفات، قد يتم التخلص منها بنفس البعثة الإثيوبية حسب الاقتضاء (السفارة الإثيوبية، البعثة الدائمة، القنصلية العامة، مكتب المسؤول عن الشؤون أو القنصلية الفخرية العامة).</p>
            <p>16. على صاحب العمل مساعدتهم في إعادة كتابة راتبه من خلال القناة المصرفية الصحيحة أو الوسائل الأخرى التي يسمح بها القانون.</p>
            <p>17. الإنهاء: قد تتضمن أسباب إنهاء عقد العمل ما يلي:</p>
            <p>أ. الإنهاء من قبل صاحب العمل: يجوز لصاحب العمل إنهاء هذا العقد دون تقديم أي إشعار للموظف في أي من الحالات العادلة التالية: سوء السلوك الجسيم، عصيان أوامر صاحب العمل القانونية، الإهمال المعتاد للواجبات، التغيب عن العمل، إفشاء أسرار المنشأة أو مخالفة الموظف لبنود عقد الاتفاق هذا.</p>
            <p>ب. الإنهاء من قبل الموظف: يجوز للموظف إنهاء هذا العقد دون تقديم أي إشعار لصاحب العمل في أي من الحالات العادلة التالية: سوء المعاملة الجسيمة من قبل صاحب العمل أو ممثله، المعاملة اللاإنسانية أو غير المحتملة التي يتعرض لها الموظف من صاحب العمل أو ممثله.</p>
            <p>ج. يجوز للموظف إنهاء هذا العقد لأي سبب بتقديم إشعار كتابي مسبق قبل 30 يومًا لصاحب العمل.</p>
            <p>18. التجديد: يمكن تجديد هذا العقد بالاتفاق المتبادل.</p>
            <p>19. التعديل والتغيير: أي تعديل أو تناوب يتم إجراؤه في هذا العقد دون موافقة وزارة العمل والشؤون الاجتماعية لن يكون له أي تأثير.</p>
            <p>20. تسوية النزاعات: جميع المطالبات والشكاوى المتعلقة بعقد عمل الموظف يجب أن تتم تسويتها وفقًا لسياسات الشركة والقوانين واللوائح. في حالة فشل التسوية، يتم اللجوء إلى البعثة الإثيوبية المناسبة (السفارة، البعثة الدائمة، القنصلية العامة). وإذا فشلت التسوية الودية، يتم تقديم المسألة إلى الجهة الحكومية المختصة في الدولة المضيفة أو في إثيوبيا بناءً على اختيار الطرف المشتكي.</p>
            <p>21. يجب على الموظف مراعاة قواعد العاملين لدى صاحب العمل والامتثال للقوانين المعمول بها في البلد المضيف.</p>
            <p>22. صاحب العمل مسؤول عن الحصول على تأشيرة الدخول اللازمة وتصريح العمل القانوني من الدولة المضيفة.</p>
            <p>23. القانون المعمول به الشروط والأحكام الأخرى لصاحب العمل والتي تتفق مع السيادة أعلاه يجب أن تغطيها ذات الصلة.</p>
            <p>24. في عقد العمل هذا ينظمه صاحب العمل، وافقت الوكالة على أن يكون القطيع مسؤولاً والتكافل بالتضامن.</p>
            <p>25. عقد العمل يغرق في الوكالة التي يعمل بها الموظف ويؤمن صاحب العمل واحدة لكل منهما وتودع النسخة في وزارة العمل.</p>
            <p>نحن هنا بتوقيع هذا العقد:</p>
            <p>توقيع وكالة التوظيف الأجنبية توقيع وكالة التوظيف الخاصة.</p>
            <p>توقيع الموظف.</p>
            <p>ممثل الوكالة</p>
            <p>التوقيع:</p>
            <p>شهود عيان</p>
            <p>1. الاسم الكامل:</p>
            <p>تبوك:</p>
            <p>رقم الهاتف:</p>
            <p>التوقيع:</p>
            <p>2. الاسم الكامل:</p>
            <p>تبوك:</p>
            <p>رقم الهاتف:</p>
            <p>التوقيع:</p>
        </div>
    </div>
    <img src="{{ asset('assets/img/' . $footerFileName) }}" style="width:100%;">
</div>
@include('../layout.footer')