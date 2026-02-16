{{-- resources/views/salaries/print.blade.php --}}
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Salary Slip</title>
  <style>
    @page { size: A4; margin: 16mm; }
    body{margin:0;background:#fff}
    .salary-slip-wrapper{width:100%;max-width:800px;margin:0 auto;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000}
    .salary-slip-header-img,.salary-slip-footer-img{width:100%;display:block}
    .salary-slip-meta{margin:10px 0 15px 0;font-size:12px}
    .salary-slip-meta span{display:block}
    .salary-slip-table{width:100%;border-collapse:collapse;margin-bottom:15px}
    .salary-slip-table th,.salary-slip-table td{border:1px solid #000;padding:6px 8px;font-size:12px}
    .salary-slip-table th{background-color:#9fc5e8;font-weight:bold;text-align:center}
    .salary-slip-section-title{background-color:#4f81bd;color:#fff;font-weight:bold;text-align:center}
    .salary-slip-label{width:20%;font-weight:bold}
    .salary-slip-text-right{text-align:right}
    .salary-slip-text-center{text-align:center}
    .salary-slip-ack{margin-top:20px;font-size:12px;line-height:1.6}
    .salary-slip-signature-block{margin-top:25px;font-size:12px}
    .salary-slip-signature-block p{margin:6px 0}
    .salary-slip-line{display:inline-block;min-width:200px;border-bottom:1px solid #000}
    @media print{
      .no-print{display:none!important}
      body{background:#fff}
    }
  </style>
</head>
<body>
@php
  $issueDate = \Carbon\Carbon::now('Asia/Qatar');
  $firstRow  = $rows->first();

  $candidateNo   = $worker->cn_number ?? $firstRow->cn_number ?? '-';
  $candidateName = strtoupper($worker->candidate_name ?? $firstRow->candidate_name ?? '-');
  $passportNo    = strtoupper($worker->passport_no ?? $firstRow->original_passport ?? $firstRow->passport_no ?? '-');
  $nationality   = strtoupper($worker->nationality ?? $firstRow->nationality ?? '-');
  $monthlySalary = (float)($worker->worker_salary_amount ?? $firstRow->worker_salary_amount ?? 0);

  $refNo = $worker->agreement_reference_no ?? $firstRow->agreement_reference_no ?? $worker->payment_reference ?? $firstRow->payment_reference ?? '-';
@endphp

<div id="salary-slip-print">
  <div class="salary-slip-wrapper">
    @if($headerPath)
      <img src="{{ $headerPath }}" alt="Header" class="salary-slip-header-img">
    @endif

    <div class="salary-slip-meta">
      <span>Date of Issuing: {{ $issueDate->format('d-m-Y') }}</span>
      <span>Reference No.: {{ $refNo }}</span>
    </div>

    <table class="salary-slip-table">
      <tr>
        <th colspan="4" class="salary-slip-section-title">WORKER DETAILS</th>
      </tr>
      <tr>
        <td class="salary-slip-label">Candidate No.</td>
        <td>{{ $candidateNo }}</td>
        <td class="salary-slip-label">Monthly Salary</td>
        <td class="salary-slip-text-right">{{ number_format($monthlySalary, 2) }}</td>
      </tr>
      <tr>
        <td class="salary-slip-label">Candidate Name</td>
        <td>{{ $candidateName }}</td>
        <td class="salary-slip-label">Passport No</td>
        <td>{{ $passportNo }}</td>
      </tr>
      <tr>
        <td class="salary-slip-label">Nationality</td>
        <td>{{ $nationality }}</td>
        <td class="salary-slip-label"></td>
        <td></td>
      </tr>
    </table>

    <table class="salary-slip-table">
      <tr>
        <th colspan="5" class="salary-slip-section-title">SALARY DETAILS</th>
      </tr>
      <tr>
        <th>CUSTOMER NAME</th>
        <th>NO. OF WORKED DAYS</th>
        <th>MODE OF PAYMENT</th>
        <th>TOTAL AMOUNT</th>
        <th>STATUS</th>
      </tr>

      @php
        $totalDays = 0;
        $totalAmount = 0.0;
      @endphp

      @foreach($rows as $row)
        @php
          $days = (int)($row->maid_worked_days ?? $row->number_of_days ?? 0);
          $amount = (float)($row->salary_deduction_amount ?? 0);
          $totalDays += $days;
          $totalAmount += $amount;
          $status = strtolower($row->status ?? '');
          $statusText = $status === 'paid' ? 'Paid Balance' : 'Balance';
          $mode = strtoupper($row->payment_method ?? '-');
        @endphp
        <tr>
          <td>{{ strtoupper($row->client_name ?? '-') }}</td>
          <td class="salary-slip-text-center">{{ $days }}</td>
          <td class="salary-slip-text-center">{{ $mode }}</td>
          <td class="salary-slip-text-right">{{ number_format($amount, 2) }}</td>
          <td class="salary-slip-text-center">{{ $statusText }}</td>
        </tr>
      @endforeach

      <tr>
        <td class="salary-slip-text-right"><strong>Total</strong></td>
        <td class="salary-slip-text-center"><strong>{{ $totalDays }}</strong></td>
        <td></td>
        <td class="salary-slip-text-right"><strong>{{ number_format($totalAmount, 2) }}</strong></td>
        <td></td>
      </tr>
    </table>

    <div class="salary-slip-ack">
      I, {{ $candidateName }}, hereby acknowledge that I have received the above-mentioned salary amount from Company Name.
    </div>

    <div class="salary-slip-signature-block">
      <p>Worker Name: <span class="salary-slip-line"></span></p>
      <p>Signature: <span class="salary-slip-line"></span></p>
      <p>Date: <span class="salary-slip-line"></span></p>
    </div>

    @if($footerPath)
      <img src="{{ $footerPath }}" alt="Footer" class="salary-slip-footer-img">
    @endif
  </div>
</div>

<script>
  window.addEventListener('load', function () { window.print(); });
</script>
</body>
</html>
