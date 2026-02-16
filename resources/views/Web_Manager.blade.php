@include('../layout.Web_Manager_header')
<main id="main" class="main">
  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        @php
          $candidatesCount = $candidatesCount ?? \Illuminate\Support\Facades\DB::table('new_candidates')->where('current_status', 1)->count();
          $packagesCount = $packagesCount ?? \Illuminate\Support\Facades\DB::table('packages')->where('inside_status', 1)->count();
          $employeesCount = $employeesCount ?? \Illuminate\Support\Facades\DB::table('employees')->where('inside_status', 1)->count();

          $cards = [
            ['title' => 'Candidates', 'icon' => 'bi bi-people-fill', 'color' => '#17a2b8', 'count' => $candidatesCount, 'subtitle' => 'Total Candidates'],
            ['title' => 'Employees', 'icon' => 'bi bi-briefcase-fill', 'color' => '#28a745', 'count' => $employeesCount, 'subtitle' => 'Total Employees'],
            ['title' => 'Packages', 'icon' => 'bi bi-box-seam-fill', 'color' => '#6f42c1', 'count' => $packagesCount, 'subtitle' => 'Total Packages'],
          ];

          $nationalityStats = \Illuminate\Support\Facades\DB::table('nationalities as n')
            ->leftJoin('new_candidates as c', function($join){
              $join->on('c.nationality', '=', 'n.id')->where('c.current_status', 1);
            })
            ->groupBy('n.id', 'n.name', 'n.arabic_name')
            ->select('n.id', 'n.name', 'n.arabic_name', \Illuminate\Support\Facades\DB::raw('COUNT(c.id) as total'))
            ->orderByDesc('total')
            ->orderBy('n.name')
            ->get();

          $totalActive = $nationalityStats->sum('total');
        @endphp

        <div class="row">
          @foreach($cards as $card)
            <div class="col-xxl-4 col-md-6 mb-3">
              <div class="card info-card">
                <div class="card-body">
                  <h5 class="card-title" style="font-weight: bold; color: black;">{{ $card['title'] }}</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background-color: {{ $card['color'] }}; width: 80px; height: 80px;">
                      <i class="{{ $card['icon'] }}" style="color: white; font-size: 36px;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ number_format($card['count']) }}</h6>
                      <span class="text-muted small" style="font-weight: bold; color: black;">{{ $card['subtitle'] }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-3" style="font-weight: bold; color: black;">Candidates by Nationality</h5>
            <div class="table-responsive">
              <table class="table table-striped align-middle">
                <thead class="table-light">
                  <tr>
                    <th style="width: 60px;">#</th>
                    <th>Nationality (EN)</th>
                    <th class="text-end">Arabic</th>
                    <th class="text-end" style="width: 120px;">Count</th>
                    <th style="width: 220px;">Share</th>
                  </tr>
                </thead>
                <tbody>
                  @php $i = 1; @endphp
                  @foreach($nationalityStats as $row)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $row->name }}</td>
                      <td class="text-end">{{ $row->arabic_name }}</td>
                      <td class="text-end"><span class="badge bg-primary">{{ number_format($row->total) }}</span></td>
                      <td>
                        @php
                          $pct = $totalActive > 0 ? round(($row->total / max(1,$totalActive)) * 100) : 0;
                        @endphp
                        <div class="progress" style="height: 10px;">
                          <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%;" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  @if($nationalityStats->isEmpty())
                    <tr>
                      <td colspan="5" class="text-center text-muted">No active candidates found.</td>
                    </tr>
                  @endif
                </tbody>
                <tfoot class="table-light">
                  <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th class="text-end">{{ number_format($totalActive) }}</th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</main>
@include('../layout.footer')
