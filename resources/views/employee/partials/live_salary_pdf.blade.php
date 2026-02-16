@php use Illuminate\Support\Str; use Carbon\Carbon; @endphp
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
    th, td { border: 1px solid #333; padding: 6px; }
    th { background-color: #f0f0f0; text-transform: uppercase; }
    tfoot th { background-color: #fafafa; border-top: 2px solid #333; }
    .signature { margin-top: 60px; text-align: right; }
  </style>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>Candidate Name</th>
        <th>Contract No</th>
        <th>Status</th>
        <th>Date</th>
        <th>Nationality</th>
        <th>Package</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Rep. Date</th>
        <th>Days</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $r)
        @php
          $created  = Carbon::parse($r['contract_created_at'])->format('j M Y');
          $start    = Carbon::parse($r['contract_start_date'])->format('j M Y');
          $end      = Carbon::parse($r['contract_end_date'])->format('j M Y');
          $repDate  = $r['replacement_date']
                        ? Carbon::parse($r['replacement_date'])->format('j M Y')
                        : '-';
          $days     = (int) Str::before($r['duration'], ' ');
        @endphp
        <tr>
          <td>{{ $r['candidate_name'] }}</td>
          <td>{{ $r['contract_number'] }}</td>
          <td>{!! $r['status'] !!}</td>
          <td>{{ $created }}</td>
          <td>{{ $r['nationality'] }}</td>
          <td>{{ $r['package'] }}</td>
          <td>{{ $start }}</td>
          <td>{{ $end }}</td>
          <td>{{ $repDate }}</td>
          <td>{{ $days }} Days</td>
          <td>{{ number_format($r['calculated'], 2) }}</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="9" class="text-end">Total Employees: {{ $totalEmployees }}</th>
        <th>{{ $totalEmployees }}</th>
        <th>{{ number_format($totalPayable, 2) }} AED</th>
      </tr>
    </tfoot>
  </table>
  <div class="signature">
    ______________________________<br>
    <strong>Accounts</strong>
  </div>
</body>
</html>
