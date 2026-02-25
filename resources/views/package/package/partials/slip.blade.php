@php
  $firstRefund = (isset($refundRows) && $refundRows && method_exists($refundRows, 'count') && $refundRows->count()) ? $refundRows->first() : null;

  $candidateName = strtoupper($candidate->candidate_name ?? ($firstRefund->candidate_name ?? '-'));

  $passportRaw = $passportNo ?? ($candidate->passport_no ?? ($firstRefund->passport_no ?? null));
  $passportRaw = is_string($passportRaw) ? trim($passportRaw) : $passportRaw;
  $passportFinal = ($passportRaw && strtoupper($passportRaw) !== 'SPONSOR') ? strtoupper($passportRaw) : '-';

  $nationality = strtoupper($candidate->nationality ?? ($firstRefund->nationality ?? '-'));
  $salaryType  = strtoupper($candidate->worker_salary_type ?? ($firstRefund->worker_salary_type ?? '-'));

  $salaryDate = !empty($candidate->salary_date)
    ? \Carbon\Carbon::parse($candidate->salary_date)->timezone('Asia/Qatar')->format('d M Y')
    : '-';

  $printedAt = \Carbon\Carbon::now('Asia/Qatar')->format('d M Y h:i A');

  $totalSalaryV = (float)($totalSalary ?? 0);
  $totalPaidV   = (float)($totalPaid ?? 0);
  $balanceV     = (float)($balance ?? 0);

  $totalSalaryF = number_format($totalSalaryV, 2);
  $totalPaidF   = number_format($totalPaidV, 2);
  $balanceF     = number_format($balanceV, 2);

  $totalRefundDays = (int)($totalRefundDays ?? 0);
  $totalRowAmountV = (float)($totalRowAmount ?? 0);

  $host = (string) request()->getHost();

  if (\Illuminate\Support\Str::contains($host, 'middleeast.onesourceerp.com')) $companyName = 'Middleeast Manpower';
  elseif (\Illuminate\Support\Str::contains($host, 'rozana.onesourceerp.com')) $companyName = 'Rozana Manpower';
  else {
    $sub = explode('.', $host)[0] ?? '';
    $sub = preg_replace('/[^a-z0-9]+/i', ' ', $sub);
    $sub = trim($sub);
    $companyName = $sub !== '' ? (ucwords($sub) . ' Manpower') : 'Company Name';
  }

  $monthlySalary = (float)($candidate->worker_salary_amount ?? 0);
  if ($monthlySalary <= 0 && $firstRefund) $monthlySalary = (float)($firstRefund->worker_salary_amount ?? 0);
  $perDaySalary = $monthlySalary > 0 ? ($monthlySalary / 30) : 0;

  $lastPaymentMethodDisplay = !empty($lastPaymentMethod) ? strtoupper($lastPaymentMethod) : null;

  $subdomain = explode('.', (string)request()->getHost())[0] ?? 'default';
  $subdomainLower = strtolower(trim((string)$subdomain));
  $headerFileName = asset('assets/img/' . $subdomainLower . '_header.jpg');
  $footerFileName = asset('assets/img/' . $subdomainLower . '_footer.jpg');

  $headerPrintHeight = '40mm';
  $footerPrintHeight = '22mm';

  $slipNo = '-';
  if (isset($payments) && $payments && method_exists($payments, 'last')) {
    $slipNoRaw = optional($payments->last())->pay_slip_no;
    $slipNoRaw = is_string($slipNoRaw) ? trim($slipNoRaw) : $slipNoRaw;
    $slipNo = $slipNoRaw ? strtoupper($slipNoRaw) : '-';
  }
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">

<style>
  @media print { .no-print { display: none !important; } }

  #salary-slip-print, #salary-slip-print * {
    font-family: 'Montserrat', sans-serif;
    box-sizing: border-box;
  }

  .slip-page {
    width: 100%;
    max-width: 980px;
    margin: 0 auto;
    color: #111;
    font-size: 12px;
    line-height: 1.45;
  }

  .slip-header, .slip-footer {
    width: 100%;
    display: block;
  }

  .slip-body {
    padding: 12px;
  }

  .slip-title {
    font-weight: 900;
    font-size: 14px;
    letter-spacing: .3px;
  }

  .slip-muted {
    color: #6c757d;
    font-size: 12px;
    line-height: 1.35;
  }

  .slip-slipno {
    margin-top: 4px;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .2px;
  }

  .slip-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    flex-wrap: wrap;
    margin: 10px 0 12px 0;
  }

  .slip-col-left { min-width: 260px; }
  .slip-col-right { min-width: 320px; flex: 1; font-size: 12px; line-height: 1.55; }

  .slip-kv {
    display: flex;
    gap: 18px;
    flex-wrap: wrap;
  }

  .slip-kv > div { min-width: 240px; }

  .slip-card {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    margin-top: 12px;
    background: #fff;
  }

  .slip-card-head {
    background: #1f2937;
    color: #fff;
    font-size: 14px;
    font-weight: 900;
    letter-spacing: .25px;
    padding: 8px 12px;
    text-transform: uppercase;
  }

  table.slip-table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
    margin: 0;
  }

  table.slip-table thead { background: #f7f7f7; }

  table.slip-table th, table.slip-table td {
    padding: 8px 10px;
    font-size: 12px;
    border-bottom: 1px solid #eef2f7;
    vertical-align: top;
  }

  table.slip-table th {
    font-weight: 900;
    text-transform: uppercase;
  }

  table.slip-table tfoot { background: #fafafa; }

  table.slip-table tfoot th, table.slip-table tfoot td {
    border-top: 1px solid #eef2f7;
    border-bottom: 0;
    font-weight: 900;
  }

  .text-center { text-align: center; }
  .text-right { text-align: right; }
  .nowrap { white-space: nowrap; }
  .wrap { white-space: normal; word-break: break-word; }

  .signatures {
    margin-top: 18px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
  }

  .sig-box { font-size: 12px; }
  .sig-line { height: 34px; border-bottom: 2px solid #000; margin-top: 22px; }
  .sig-label { margin-top: 8px; font-weight: 800; text-align: center; font-size: 12px; }

  @media print {
    @page { size: A4; margin: 0; }
    html, body { margin: 0 !important; padding: 0 !important; }

    #salary-slip-print { padding: 0 !important; margin: 0 !important; }
    .slip-page { width: 100% !important; max-width: 100% !important; margin: 0 !important; }

    .slip-header {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: {{ $headerPrintHeight }};
      width: 100%;
      object-fit: cover;
      z-index: 1000;
    }

    .slip-footer {
      position: fixed;
      bottom: 0; left: 0; right: 0;
      height: {{ $footerPrintHeight }};
      width: 100%;
      object-fit: cover;
      z-index: 1000;
    }

    .slip-body {
      padding: 0;
      margin-top: {{ $headerPrintHeight }};
      margin-bottom: {{ $footerPrintHeight }};
      padding-top: 12mm;
      padding-right: 12mm;
      padding-bottom: 10mm;
      padding-left: 12mm;
    }

    .slip-card { break-inside: avoid; page-break-inside: avoid; }
    table, tr, td, th { break-inside: avoid; page-break-inside: avoid; }
  }
</style>

<div id="salary-slip-print">
  <div class="slip-page">
    <img src="{{ $headerFileName }}" alt="Header" class="slip-header">

    <div class="slip-body">
      <div class="slip-row">
        <div class="slip-col-left">
          <div class="slip-title">SALARY SLIP</div>
          <div class="slip-muted">Salary Date: {{ $salaryDate }}</div>
          <div class="slip-slipno">Slip No: {{ $slipNo }}</div>
          <div class="slip-muted">Printed: {{ $printedAt }}</div>
        </div>

        <div class="slip-col-right">
          <div class="slip-kv">
            <div><strong>Candidate:</strong> {{ $candidateName }}</div>
            <div><strong>Passport:</strong> {{ $passportFinal }}</div>
            <div><strong>Nationality:</strong> {{ $nationality }}</div>
            <div><strong>Salary To:</strong> {{ $salaryType }}</div>
            @if($lastPaymentMethodDisplay)
              <div><strong>Salary Paid By:</strong> {{ $lastPaymentMethodDisplay }}</div>
            @endif
          </div>
        </div>
      </div>

      <div class="slip-card">
        <div class="slip-card-head">Salary Details (Refund Rows)</div>

        <table class="slip-table">
          <thead>
            <tr>
              <th style="width:52px;">#</th>
              <th style="width:210px;">Sponsor Name</th>
              <th style="width:170px;">Agreement Ref No</th>
              <th class="text-center" style="width:120px;">Worked Days</th>
              <th class="text-right" style="width:150px;">Monthly Salary</th>
              <th class="text-right" style="width:110px;">Per Day</th>
              <th class="text-right" style="width:150px;">Total Amount</th>
              <th style="width:130px;">Date</th>
            </tr>
          </thead>

          <tbody>
            @forelse($refundRows as $i => $r)
              @php
                $sponsor = strtoupper($r->client_name ?? '-');
                $agreement = strtoupper($r->agreement_reference_no ?? ($r->payment_reference ?? '-'));

                $days = (int)($r->maid_worked_days ?? ($r->number_of_days ?? 0));
                $monthly = (float)($r->worker_salary_amount ?? 0);
                $perDay = $monthly > 0 ? ($monthly / 30) : $perDaySalary;

                $ded = $r->salary_deduction_amount;
                $ded = is_string($ded) ? trim($ded) : $ded;
                $rowAmount = ($ded !== null && $ded !== '') ? (float)$ded : ($perDay * $days);

                $rowDate = !empty($r->created_at)
                  ? \Carbon\Carbon::parse($r->created_at)->timezone('Asia/Qatar')->format('d M Y')
                  : '-';
              @endphp

              <tr>
                <td class="nowrap" style="font-weight:800;">{{ $i + 1 }}</td>
                <td class="wrap">{{ $sponsor }}</td>
                <td class="wrap">{{ $agreement }}</td>
                <td class="text-center nowrap" style="font-weight:800;">{{ $days }}</td>
                <td class="text-right nowrap" style="font-weight:900;">{{ number_format($monthly, 2) }}</td>
                <td class="text-right nowrap">{{ number_format($perDay, 2) }}</td>
                <td class="text-right nowrap" style="font-weight:900;">{{ number_format($rowAmount, 2) }}</td>
                <td class="nowrap">{{ $rowDate }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center" style="padding:12px;">No refund rows found.</td>
              </tr>
            @endforelse
          </tbody>

          <tfoot>
            <tr>
              <th colspan="3" class="text-right">Totals</th>
              <th class="text-center">{{ $totalRefundDays }}</th>
              <th></th>
              <th></th>
              <th class="text-right">{{ number_format($totalRowAmountV, 2) }}</th>
              <th></th>
            </tr>
            <tr>
              <th colspan="6" class="text-right">Total Salary</th>
              <th colspan="2" class="text-right">{{ $totalSalaryF }}</th>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="slip-card">
        <div class="slip-card-head">Payment Ledger</div>

        <table class="slip-table">
          <thead>
            <tr>
              <th style="width:52px;">#</th>
              <th style="width:130px;">Paid Date</th>
              <th style="width:170px;">Reference No</th>
              <th style="width:150px;">Payment Method</th>
              <th>Note</th>
              <th class="text-right" style="width:150px;">Received Amount</th>
              <th class="text-center no-print" style="width:110px;">Action</th>
            </tr>
          </thead>

          <tbody>
            @forelse($payments as $k => $p)
              @php
                $pid = (int)($p->id ?? 0);

                $payDate = !empty($p->txn_date)
                  ? \Carbon\Carbon::parse($p->txn_date)->timezone('Asia/Qatar')->format('d-m-Y')
                  : '-';

                $refNo = strtoupper($p->reference_no ?? '-');
                $method = strtoupper($p->payment_method ?? '-');
                $note = trim((string)($p->note ?? ''));

                $amt = (float)($p->credit ?? 0);
                $amtF = number_format($amt, 2);
              @endphp

              <tr>
                <td class="nowrap" style="font-weight:800;">{{ $k + 1 }}</td>
                <td class="nowrap">{{ $payDate }}</td>
                <td class="wrap">{{ $refNo }}</td>
                <td class="wrap">{{ $method }}</td>
                <td class="wrap" style="line-height:1.35;">{{ $note !== '' ? $note : '-' }}</td>
                <td class="text-right nowrap" style="font-weight:900;">{{ $amtF }}</td>
                <td class="text-center no-print">
                  <button type="button" class="btn btn-sm btn-dark btn-print-ledger" data-payment-id="{{ $pid }}" style="font-size:12px;font-weight:900;padding:4px 10px;border-radius:10px;">Print</button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center" style="padding:12px;">No payments found.</td>
              </tr>
            @endforelse
          </tbody>

          <tfoot>
            <tr>
              <th colspan="5" class="text-right">Total Paid</th>
              <th class="text-right">{{ $totalPaidF }}</th>
              <th class="no-print"></th>
            </tr>
            <tr>
              <th colspan="5" class="text-right">Balance</th>
              <th class="text-right">{{ $balanceF }}</th>
              <th class="no-print"></th>
            </tr>
          </tfoot>
        </table>
      </div>

      <div style="margin-top:14px;font-size:12px;line-height:1.55;">
        I, <strong>{{ $candidateName }}</strong>, hereby acknowledge that I have received the above-mentioned salary amount from <strong>{{ $companyName }}</strong>.
      </div>

      <div class="signatures">
        <div class="sig-box">
          <div class="sig-line"></div>
          <div class="sig-label">Worker Signature</div>
        </div>
        <div class="sig-box">
          <div class="sig-line"></div>
          <div class="sig-label">Receiver Signature</div>
        </div>
        <div class="sig-box">
          <div class="sig-line"></div>
          <div class="sig-label">Finance Department</div>
        </div>
      </div>
    </div>

    <img src="{{ $footerFileName }}" alt="Footer" class="slip-footer">
  </div>

  <div id="print-templates" style="display:none;">
    @foreach($payments as $p)
      @php
        $pid = (int)($p->id ?? 0);

        $issueDateP = \Carbon\Carbon::now('Asia/Qatar')->format('d-m-Y');

        $payDateP = !empty($p->txn_date)
          ? \Carbon\Carbon::parse($p->txn_date)->timezone('Asia/Qatar')->format('d-m-Y')
          : '-';

        $slipNoP = strtoupper(trim((string)($p->pay_slip_no ?? '-')));
        $particularRefP = strtoupper(trim((string)($p->reference_no ?? '-')));

        $methodP = strtoupper(trim((string)($p->payment_method ?? '-')));
        $amtP = number_format((float)($p->credit ?? 0), 2);
      @endphp

      <template id="ledger-print-{{ $pid }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">

        <style>
          @page { size: A4; margin: 0; }
          html, body { margin: 0 !important; padding: 0 !important; }

          .p-slip-page {
            width: 100%;
            margin: 0;
            color: #111;
            font-family: 'Montserrat', sans-serif;
            font-size: 12px;
            line-height: 1.45;
          }

          .p-slip-header {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: {{ $headerPrintHeight }};
            width: 100%;
            object-fit: cover;
            display: block;
            z-index: 1000;
          }

          .p-slip-footer {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: {{ $footerPrintHeight }};
            width: 100%;
            object-fit: cover;
            display: block;
            z-index: 1000;
          }

          .p-slip-body {
            margin-top: {{ $headerPrintHeight }};
            margin-bottom: {{ $footerPrintHeight }};
            padding-top: 12mm;
            padding-right: 12mm;
            padding-bottom: 10mm;
            padding-left: 12mm;
          }

          .p-title { font-weight: 900; font-size: 14px; letter-spacing: .3px; }
          .p-muted { color: #6c757d; font-size: 12px; line-height: 1.35; }
          .p-slipno { margin-top: 4px; font-size: 12px; font-weight: 800; letter-spacing: .2px; }

          table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 0;
          }

          th, td {
            border: 1px solid #000;
            padding: 8px 10px;
            font-size: 12px;
            vertical-align: top;
          }

          th { font-weight: 900; text-transform: uppercase; }
          .section-title { background: #9fc5e8; text-align: center; font-size: 14px; font-weight: 900; }

          .sig-wrap { display: flex; gap: 18px; justify-content: space-between; margin-top: 18px; }
          .sig-col { flex: 1; }
          .sig-line { height: 34px; border-bottom: 2px solid #000; }
          .sig-label { margin-top: 8px; font-weight: 800; text-align: center; font-size: 12px; }
        </style>

        <div class="p-slip-page">
          <img src="{{ $headerFileName }}" alt="Header" class="p-slip-header">

          <div class="p-slip-body">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;margin:0 0 14px 0;">
              <div style="font-weight:800;line-height:1.35;">
                <div>Date of Issuing: {{ $issueDateP }}</div>
                <div class="p-slipno">Slip No: {{ $slipNoP }}</div>
              </div>
              <div style="text-align:right;font-size:12px;line-height:1.45;">
                <div class="p-title">SALARY SLIP</div>
                <div>Salary Date: {{ $salaryDate }}</div>
                <div>Paid Date: {{ $payDateP }}</div>
                <div>Printed: {{ $printedAt }}</div>
              </div>
            </div>

            <table style="margin-bottom:14px;">
              <tr>
                <th colspan="4" class="section-title">WORKER DETAILS</th>
              </tr>
              <tr>
                <td style="font-weight:800;width:22%;">Candidate Name</td>
                <td>{{ $candidateName }}</td>
                <td style="font-weight:800;width:22%;">Monthly Salary</td>
                <td style="text-align:right;width:22%;">{{ number_format($monthlySalary, 2) }}</td>
              </tr>
              <tr>
                <td style="font-weight:800;">Passport No</td>
                <td>{{ $passportFinal }}</td>
                <td style="font-weight:800;">Nationality</td>
                <td>{{ $nationality }}</td>
              </tr>
            </table>

            <table style="margin-bottom:16px;">
              <tr>
                <th colspan="5" class="section-title">SALARY DETAILS</th>
              </tr>
              <tr>
                <th style="text-align:center;">Particular</th>
                <th style="text-align:center;width:16%;">Days</th>
                <th style="text-align:center;width:18%;">Mode of Payment</th>
                <th style="text-align:center;width:18%;">Total Amount</th>
                <th style="text-align:center;width:18%;">Status</th>
              </tr>
              <tr>
                <td style="font-weight:700;">{{ $particularRefP }}</td>
                <td style="text-align:center;font-weight:700;">-</td>
                <td style="text-align:center;font-weight:700;">{{ $methodP }}</td>
                <td style="text-align:center;font-weight:800;">{{ $amtP }}</td>
                <td style="text-align:center;font-weight:900;">PAID</td>
              </tr>
              <tr>
                <td style="text-align:right;font-weight:800;">TOTAL</td>
                <td></td>
                <td></td>
                <td style="text-align:center;font-weight:900;">{{ $amtP }}</td>
                <td style="text-align:center;font-weight:900;">PAID</td>
              </tr>
            </table>

            <div style="font-size:12px;line-height:1.55;margin:18px 0;">
              I, <strong>{{ $candidateName }}</strong>, hereby acknowledge that I have received the above-mentioned salary amount from <strong>{{ $companyName }}</strong>.
            </div>

            <div class="sig-wrap">
              <div class="sig-col">
                <div class="sig-line"></div>
                <div class="sig-label">Worker Signature</div>
              </div>
              <div class="sig-col">
                <div class="sig-line"></div>
                <div class="sig-label">Receiver Signature</div>
              </div>
              <div class="sig-col">
                <div class="sig-line"></div>
                <div class="sig-label">Finance Department</div>
              </div>
            </div>
          </div>

          <img src="{{ $footerFileName }}" alt="Footer" class="p-slip-footer">
        </div>
      </template>
    @endforeach
  </div>
</div>
