@php
use Carbon\Carbon;
use Illuminate\Support\Str;

$subdomain      = explode('.', request()->getHost())[0] ?? 'default';
$headerFileName = asset('assets/img/' . strtolower($subdomain) . '_header.jpg');
$footerFileName = asset('assets/img/' . strtolower($subdomain) . '_footer.jpg');

$agr = $contract->agreement;

$agreementStart = $agr->agreement_start_date
    ? Carbon::parse($agr->agreement_start_date)->format('d M Y')
    : '';

$agreementEnd = $agr->agreement_end_date
    ? Carbon::parse($agr->agreement_end_date)->format('d M Y')
    : '';

$monthly     = $agr->monthly_payment  ?? 0;
$totalAmount = $agr->monthly_payment ?: ($agr->total_amount ?? 0);
$received    = $agr->received_amount  ?? 0;
$remaining   = max(0, $totalAmount - $received);

if ($monthly > 0) {
    $clauseEn = "The contract is valid from {$agreementStart} to {$agreementEnd}. The total contract value is " . number_format($totalAmount, 2) . " AED.";
    $clauseAr = "تسري هذه الاتفاقية من {$agreementStart} إلى {$agreementEnd}. قيمة العقد الإجمالية " . number_format($totalAmount, 2) . " درهم. يُقر الطرف الأول باستلام مبلغ مقدّم قدره " . number_format($received, 2) . " درهم.";
} elseif ($remaining === 0) {
    $clauseEn = "The contract is valid from {$agreementStart} to {$agreementEnd}. The total contract value of " . number_format($totalAmount, 2) . " AED has been paid in full on signing.";
    $clauseAr = "تسري هذه الاتفاقية من {$agreementStart} إلى {$agreementEnd}. قيمة العقد الإجمالية " . number_format($totalAmount, 2) . " درهم مدفوعة بالكامل عند التوقيع.";
} else {
    $clauseEn = "The contract is valid from {$agreementStart} to {$agreementEnd}. The total contract value is " . number_format($totalAmount, 2) . " AED.";
    $clauseAr = "تسري هذه الاتفاقية من {$agreementStart} إلى {$agreementEnd}. قيمة العقد الإجمالية " . number_format($totalAmount, 2) . " درهم.";
}

$history = $contract->shareHistory ?? [];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $contract->reference_no }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        @page { size: A4; margin: 10px }
        body { margin:10px; font-family:Arial,Helvetica,sans-serif; font-size:13px }
        table { width:100%; border-collapse:collapse }
        th, td { border:1px solid #000; padding:8px; text-align:center; vertical-align:middle }
        .dotted td { border-style:dotted }
        .rotate90 { transform:rotate(90deg); white-space:nowrap; font-weight:bold }
        .rotate-90 { transform:rotate(-90deg); white-space:nowrap; font-weight:bold }
        .sig { width:44%; border:2px solid #000; padding:15px; position:relative }
        .title-box { position:absolute; top:12px; left:15px; background:#fff; padding:0 8px; font-weight:bold }
        .clear { clear:both }

        .custom-modal .modal-content { border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.3); font-family:Arial,sans-serif; background:#fff }
        .custom-modal .modal-header { background:linear-gradient(135deg,#007bff,#6a11cb); color:#fff; padding:15px; border-radius:12px 12px 0 0 }
        .custom-modal .modal-header h5 { font-size:16px; margin:0 }
        .custom-modal .modal-header .btn-close { filter:invert(1) }
        .custom-modal .modal-body { padding:20px; background:#f9f9f9 }
        .custom-modal .modal-body table { width:100%; border-collapse:collapse; margin-bottom:1rem }
        .custom-modal .modal-body th { background:linear-gradient(135deg,#007bff,#6a11cb); color:#fff; text-align:left; width:40%; padding:12px; font-size:12px; text-transform:uppercase }
        .custom-modal .modal-body td { background:#fff; color:#333; text-align:left; padding:12px; font-size:12px }
        .custom-modal .modal-body .form-label { font-size:12px }
        .custom-modal .modal-body .form-control { font-size:12px }
        .custom-modal .modal-footer { padding:15px; border-top:1px solid #ddd; border-radius:0 0 12px 12px; background:#f1f1f1 }
        .custom-modal .modal-footer .btn-primary { background:linear-gradient(to right,#007bff,#00c6ff); color:#fff; border:none; font-size:14px }
        .custom-modal .modal-footer .btn-primary i { margin-right:8px }
    </style>
</head>
<body>
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#shareModal">
            <i class="fab fa-whatsapp"></i>
        </button>
    </div>
    <img src="{{ $headerFileName }}" style="width:100%">
    <table class="dotted my-4">
        <tr>
            <td>{{ Carbon::parse($contract->created_at)->format('d/m/Y') }}</td>
            <td><strong>Domestic Worker Contract</strong><br><strong>عقد استقدام عامل مساعد</strong></td>
            <td>Contract No.<br><strong>رقم الاتفاقية</strong></td>
            <td style="font-weight:bold">{{ $contract->reference_no }}</td>
        </tr>
    </table>
    <div class="form-check mb-4">
      <input class="form-check-input" type="checkbox" id="chkPageConfirm">
      <label class="form-check-label" for="chkPageConfirm">I confirm that the above contract details are accurate</label>
    </div>
    <table>
        <tr><td>{{ $contract->client->first_name }} {{ $contract->client->last_name }}</td><td><strong>اسم صاحب العمل<br>SPONSOR NAME</strong></td><td rowspan="8"><span class="rotate90">SECOND PARTY<br>الطرف الثاني</span></td><td>AL EBDAA DOMESTIC WORKERS CENTRE</td><td><strong>مكتب الاستقدام<br>Tadbeer Center</strong></td><td rowspan="3"><span class="rotate-90">FIRST PARTY<br>الطرف الأول</span></td></tr>
        <tr><td>{{ $contract->client->emirates_id }}</td><td><strong>رقم الهوية<br>ID NUMBER</strong></td><td>800 32332</td><td><strong>رقم الهاتف<br>Phone</strong></td></tr>
        <tr><td>{{ $contract->client->address }}</td><td><strong>العنوان<br>ADDRESS</strong></td><td>AL GARHOUD, DUBAI, UAE</td><td><strong>العنوان<br>Address</strong></td></tr>
        <tr><td>{{ $contract->client->nationality }}</td><td><strong>الجنسية<br>NATIONALITY</strong></td><td>{{ $contract->replaced_by_name ?: $agr->candidate_name }}</td><td><strong>اسم العامل<br>Name</strong></td><td rowspan="4"><strong>العامل المساعد<br>Domestic worker</strong></td></tr>
        <tr><td>{{ $contract->client->mobile }}</td><td><strong>رقم الهاتف<br>PHONE</strong></td><td>{{ $agr->passport_no }}</td><td><strong>رقم جواز السفر<br>Passport</strong></td></tr>
        <tr><td>{{ $contract->client->state ?? '' }}</td><td><strong>الإمارة<br>EMIRATE</strong></td><td>{{ $agr->Nationality->name ?? $agr->nationality }}</td><td><strong>الجنسية<br>Nationality</strong></td></tr>
        <tr><td>{{ $agreementStart }}</td><td><strong>تاريخ البدء<br>Start Date</strong></td><td>{{ $agreementEnd }}</td><td><strong>تاريخ الانتهاء<br>End Date</strong></td></tr>
    </table>
    <div style="width:100%;margin:20px 0;overflow:auto"><div style="float:left;width:47%"><p style="margin:0;text-align:left"><strong>Article 1 – Financial Terms</strong><br>{{ $clauseEn }}</p></div><div style="float:left;width:47%;margin-left:2%"><p style="margin:0;direction:rtl;text-align:right"><strong>البند الأول – الشروط المالية</strong><br>{{ $clauseAr }}</p></div></div>
    <div class="clear"></div>
    <!-- Articles 2–8 unchanged -->
    <div style="margin:30px 0;overflow:auto">
        <div class="sig" style="float:left"><span class="title-box">SECOND PARTY (Employer) / الطرف الثاني</span><p><strong>Name :</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">{{ $contract->client->first_name }} {{ $contract->client->last_name }}</span></p><p><strong>Signature :</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%"></span></p><p><strong>Date :</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%"></span></p></div>
        <div class="sig" style="float:left;margin-left:2%"><span class="title-box">FIRST PARTY (Recruitment Office) / الطرف الأول</span><p><strong>Name :</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%">ALEBDAA WORKERS EMPLOYMENT SERVICES CENTRE</span></p><p><strong>Signature :</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%"></span></p><p><strong>Date :</strong> <span style="border-bottom:1px solid #000;display:inline-block;width:75%"></span></p></div>
    </div>
    <div class="clear"></div>
    <img src="{{ $footerFileName }}" style="width:100%">

    <div class="modal fade custom-modal" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered animate__animated animate__zoomIn">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="shareModalLabel" class="modal-title">Share via WhatsApp</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <table>
              <thead>
                <tr>
                  <th>WhatsApp No</th>
                  <th>Date &amp; Time</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($history as $h)
                <tr>
                  <td>{{ $h['phone'] }}</td>
                  <td>{{ Carbon::parse($h['sent_at'])->format('d M Y H:i') }}</td>
                  <td>{{ $h['status'] }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="3">No history available</td>
                </tr>
                @endforelse
              </tbody>
            </table>
            <table>
              <tr><th>Maid Name</th><td>{{ $agr->candidate_name }}</td></tr>
              <tr><th>Sponsor Name</th><td>{{ $contract->client->first_name }} {{ $contract->client->last_name }}</td></tr>
              <tr><th>Start Date</th><td>{{ $agreementStart }}</td></tr>
              <tr><th>End Date</th><td>{{ $agreementEnd }}</td></tr>
              <tr><th>Contract Value</th><td>{{ number_format($totalAmount,2) }} AED</td></tr>
            </table>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="chkConfirmAll">
              <label class="form-check-label" for="chkConfirmAll">I confirm that all information above is correct</label>
            </div>
            <div class="mb-3">
              <label for="waPhone" class="form-label">Contact Number</label>
              <input type="text" id="waPhone" name="phone" class="form-control" placeholder="+974XXXXXXXX" value="{{ $contract->client->mobile }}">
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnShare" class="btn btn-primary w-100" disabled>
              <i class="fab fa-whatsapp"></i> Share on WhatsApp
            </button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      const confirmAll = document.getElementById('chkConfirmAll');
      const btnShare = document.getElementById('btnShare');
      confirmAll.addEventListener('change', () => {
        btnShare.disabled = !confirmAll.checked;
      });
      btnShare.addEventListener('click', () => {
        btnShare.disabled = true;
        fetch('{{ route("contracts.shareWhatsapp", $contract) }}', {
          method: 'POST',
          headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
          body: JSON.stringify({phone: document.getElementById('waPhone').value})
        }).then(r => r.json()).then(j => {
          if (j.success) location.reload(); else btnShare.disabled = false;
        });
      });
    </script>
</body>
</html>
