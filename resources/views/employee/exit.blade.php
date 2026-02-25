@php
    $serverName        = $_SERVER['SERVER_NAME'];
    $subdomain         = explode('.', $serverName)[0];
    $headerFileName    = strtolower($subdomain) . '_header.jpg';
    $footerFileName    = strtolower($subdomain) . '_footer.jpg';
    $logoFileName      = strtolower($subdomain) . '_logo.png';
    $todayDate         = date('d M Y');
    $cancellationDate  = $employee->cancellation_date ?? null;
    $accommodation     = $employee->accommodation ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>{{ $employee->name }}'s Exit Form</title>
    <link rel="icon" href="{{ asset('assets/img/' . $logoFileName) }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/' . $logoFileName) }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        @media print {
            @page { size: A4; }
            body { margin:0; padding:0; width:210mm; height:297mm; }
            .print-button { display:none!important; }
        }
        body { font-family:Arial,sans-serif;font-size:13px;margin:0;padding:0;background:#f8f9fa;display:flex;flex-direction:column;align-items:center; }
        .print-button { margin-top:20px;padding:10px 20px;background:#007bff;color:#fff;border:none;border-radius:5px;cursor:pointer;font-size:14px;display:flex;align-items:center; }
        .print-button i { margin-right:5px; }
        .container { width:210mm;padding:5mm;background:#fff;border-radius:5px;margin-top:20px; }
        .form-table { width:100%;border-collapse:collapse; }
        .form-table th { background:#000;color:#fff;text-align:left;padding:10px; }
        .form-table td { padding:10px;border:1px solid #dee2e6;vertical-align:middle; }
        .form-header { text-align:center;margin-bottom:10px; }
        .form-header h6 { margin:0;font-weight:bold; }
        .checkbox-center { text-align:center; }
        .signature-section { display:flex;justify-content:space-between;margin-top:30px; }
        .rtl { direction:rtl;text-align:right; }
        .ltr { direction:ltr;text-align:left; }
    </style>
</head>
<body>
    <button class="print-button" onclick="printPage()">
        <i class="bi bi-printer"></i> Print
    </button>
    <div class="container" id="printContainer">
        <img src="{{ asset('assets/img/' . $headerFileName) }}" style="width:100%;">
        <div class="form-header">
            <h6>Domestic Workers Exit Form</h6>
            <h6>نموذج خروج عامل مساعد</h6>
        </div>
        <div class="text-end mb-3">
            <label>Date: {{ $todayDate }}</label>
        </div>
        <table class="form-table mb-4">
            <thead>
                <tr>
                    <th colspan="3">WORKER DETAILS <span class="float-end rtl">بيانات العامل</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ltr">CANDIDATE NAME:</td>
                    <td>{{ $employee->name }}</td>
                    <td class="rtl">اسم:</td>
                </tr>
                <tr>
                    <td class="ltr">PASSPORT NUMBER:</td>
                    <td>{{ $employee->passport_no }}</td>
                    <td class="rtl">رقم جواز السفر:</td>
                </tr>
                <tr>
                    <td class="ltr">NATIONALITY:</td>
                    <td>{{ $employee->nationality }}</td>
                    <td class="rtl">الجنسية:</td>
                </tr>
                <tr>
                    <td class="ltr">CANCELLATION DATE:</td>
                    <td>
                        @if($cancellationDate)
                            {{ \Carbon\Carbon::parse($cancellationDate)->format('d M Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="rtl">تاريخ الإلغاء:</td>
                </tr>
                <tr>
                    <td class="ltr">ACCOMMODATION BRANCH:</td>
                    <td>{{ $accommodation ?? 'N/A' }}</td>
                    <td class="rtl">السكن:</td>
                </tr>
            </tbody>
        </table>
        <table class="form-table mb-4">
            <thead>
                <tr>
                    <th colspan="4">PURPOSE OF EXIT <span class="float-end rtl">سبب الخروج</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ltr">INTERVIEW</td><td class="checkbox-center"><input type="checkbox"></td><td></td><td class="rtl">مقابلة في المكتب</td>
                </tr>
                <tr>
                    <td class="ltr">RECORD VIDEO</td><td class="checkbox-center"><input type="checkbox"></td><td></td><td class="rtl">فيديو في المكتب</td>
                </tr>
                <tr>
                    <td class="ltr">HOSPITAL</td><td class="checkbox-center"><input type="checkbox"></td><td></td><td class="rtl">مستشفى</td>
                </tr>
                <tr>
                    <td class="ltr">REPATRIATION</td><td class="checkbox-center"><input type="checkbox"></td><td></td><td class="rtl">العودة إلى الوطن</td>
                </tr>
                <tr>
                    <td class="ltr">EMBASSY</td><td class="checkbox-center"><input type="checkbox"></td><td></td><td class="rtl">السفارة</td>
                </tr>
                <tr>
                    <td class="ltr">SPONSOR HAND-OVER</td>
                    <td class="checkbox-center">TRIAL <input type="checkbox" checked></td>
                    <td class="checkbox-center">NEW ARRIVAL <input type="checkbox"></td>
                    <td class="rtl">تسليم للعميل</td>
                </tr>
                <tr>
                    <td class="ltr">TRAINING</td><td class="checkbox-center"><input type="checkbox"></td><td></td><td class="rtl">تدريب</td>
                </tr>
                <tr>
                    <td class="ltr">OTHER</td><td class="checkbox-center"><input type="checkbox"></td><td></td><td class="rtl">سبب آخر</td>
                </tr>
            </tbody>
        </table>
        <table class="form-table">
            <thead>
                <tr>
                    <th colspan="3">SALES NAME <span class="float-end rtl">اسم المبيعات</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ltr">FULL NAME:</td>
                    <td>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</td>
                    <td class="rtl">الاسم:</td>
                </tr>
            </tbody>
        </table>
        <div class="signature-section">
            <div><strong class="ltr">PREPARED BY:</strong> __________________________</div>
            <div><strong class="ltr">APPROVED BY:</strong> __________________________</div>
        </div>
        <img src="{{ asset('assets/img/' . $footerFileName) }}" style="width:100%;margin-top:20px">
    </div>

    <script>
    function printPage(){
      const printContent = document.getElementById('printContainer').outerHTML;
      const styles = `<style>
        @page{size:A4;margin:0}
        body{font-family:Arial,sans-serif;font-size:13px;margin:0;padding:0;width:210mm;height:297mm;display:flex;justify-content:center;align-items:center;background:#fff}
        .form-table{width:100%;border-collapse:collapse}
        .form-table th{background:#000;color:#fff;text-align:left;padding:10px}
        .form-table td{padding:10px;border:1px solid #dee2e6;vertical-align:middle}
        .form-header{text-align:center;margin-bottom:10px}
        .form-header h6{margin:0;font-weight:bold}
        .checkbox-center{text-align:center}
        .signature-section{display:flex;justify-content:space-between;margin-top:30px}
        .rtl{direction:rtl;text-align:right}
        .ltr{direction:ltr;text-align:left}
      </style>`;
      const win = window.open('','','width=800,height=600');
      win.document.write(`<html><head><title>Print</title>${styles}</head><body>${printContent}</body></html>`);
      win.document.close();
      win.focus();
      win.print();
      win.close();
    }
    </script>
</body>
</html>
