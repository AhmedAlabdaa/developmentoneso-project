@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $names        = array_column($rows, 'candidate_name');
    $counts       = array_count_values($names);
    $colorClasses = ['table-primary','table-secondary','table-success','table-danger','table-warning','table-info'];
    $nameClassMap = [];
    $i = 0;
    foreach ($counts as $name => $count) {
        if ($count > 1) {
            $nameClassMap[$name] = $colorClasses[$i++ % count($colorClasses)];
        }
    }
@endphp

<div id="liveSalaryContainer" class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead class="table-light">
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
          $class       = $nameClassMap[$r['candidate_name']] ?? '';
          $created     = Carbon::parse($r['contract_created_at'])->format('j F Y');
          $updated     = Carbon::parse($r['contract_updated_at'])->format('j F Y');
          $start       = Carbon::parse($r['contract_start_date'])->format('j M Y');
          $end         = Carbon::parse($r['contract_end_date'])->format('j M Y');
          $repDate     = $r['replacement_date']
                            ? Carbon::parse($r['replacement_date'])->format('j M Y')
                            : '-';
          $days        = (int) Str::before($r['duration'], ' ');
        @endphp
        <tr class="{{ $class }}">
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
    <tfoot class="table-light">
      <tr>
        <th colspan="9" class="text-end">Total Employees:</th>
        <th>{{ $totalEmployees }}</th>
        <th>{{ number_format($totalPayable, 2) }} AED</th>
      </tr>
    </tfoot>
  </table>
</div>
