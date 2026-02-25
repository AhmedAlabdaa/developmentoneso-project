<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .table-container{width:100%;overflow-x:auto}
    .table{width:100%;border-collapse:collapse;margin-bottom:20px}
    .table th,.table td{
        padding:10px 15px;
        border-bottom:1px solid #ddd;
        font-size:12px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        text-align:left;
    }
    .table th{
        background:#343a40;
        color:#fff;
        text-transform:uppercase;
        font-weight:bold;
    }
    .table-striped tbody tr:nth-of-type(odd){background:#f9f9f9}
    .table-hover tbody tr:hover{background:#f1f1f1}
    .btn-icon-only{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        width:30px;
        height:30px;
        border-radius:50%;
        font-size:12px;
        color:#fff;
    }
    .btn-view{background:#0d6efd}
    .btn-edit{background:#6610f2}
    .btn-train{background:#20c997}
    .status-pill{
        display:inline-flex;
        align-items:center;
        gap:4px;
        border-radius:999px;
        padding:3px 8px;
        font-size:11px;
    }
    .status-pill i{font-size:11px}
    .badge-available{background:#e9f7ef;color:#198754}
    .badge-backout{background:#f8d7da;color:#842029}
    .badge-hold{background:#fff3cd;color:#856404}
    .badge-selected{background:#e7f1ff;color:#0d6efd}
    .badge-wc{background:#e0f2fe;color:#055160}
    .badge-incident{background:#fde2e1;color:#b02a37}
    .badge-medical{background:#e0f7fa;color:#006064}
    .badge-doc{background:#f3e8ff;color:#5a189a}
    .badge-flight{background:#e0ecff;color:#084298}
    .badge-transfer{background:#e0f7ff;color:#0b7285}
</style>

<div class="table-container">
    @php
        $visaMap = [
            1  => ['Visit 1',         'fa-plane'],
            2  => ['Visit 2',         'fa-plane-departure'],
            3  => ['Dubai Insurance', 'fa-file-medical'],
            4  => ['Entry Permit',    'fa-passport'],
            5  => ['CS (Inside)',     'fa-user-shield'],
            6  => ['Medical',         'fa-heartbeat'],
            7  => ['Tawjeeh',         'fa-calendar-alt'],
            8  => ['EID',             'fa-id-card'],
            9  => ['Stamping',        'fa-stamp'],
            10 => ['Visit 3',         'fa-plane-arrival'],
            11 => ['ILOE',            'fa-briefcase'],
            12 => ['Salary Details',  'fa-money-bill'],
            13 => ['Cancellation',    'fa-times-circle'],
            14 => ['Completed',       'fa-check-circle'],
        ];

        $currentStatusIconMap = [
            1  => ['Available',                  'fa-user-check',          'badge-available'],
            2  => ['Back Out',                   'fa-door-open',           'badge-backout'],
            3  => ['Hold',                       'fa-pause-circle',        'badge-hold'],
            4  => ['Selected',                   'fa-star',                'badge-selected'],
            5  => ['WC-Date',                    'fa-file-contract',       'badge-wc'],
            6  => ['Incident Before Visa (IBV)', 'fa-exclamation-triangle','badge-incident'],
            7  => ['Visa Date',                  'fa-passport',            'badge-doc'],
            8  => ['Incident After Visa (IAV)',  'fa-exclamation-circle',  'badge-incident'],
            9  => ['Medical Status',             'fa-user-nurse',          'badge-medical'],
            10 => ['COC-Status',                 'fa-certificate',         'badge-doc'],
            11 => ['MoL Submitted Date',         'fa-share-square',        'badge-doc'],
            12 => ['MoL Issued Date',            'fa-file-signature',      'badge-doc'],
            13 => ['Departure Date',             'fa-plane-departure',     'badge-flight'],
            14 => ['Incident After Departure (IAD)','fa-plane',            'badge-incident'],
            15 => ['Arrived Date',               'fa-plane-arrival',       'badge-flight'],
            16 => ['Incident After Arrival (IAA)','fa-bell',               'badge-incident'],
            17 => ['Transfer Date',              'fa-exchange-alt',        'badge-transfer'],
        ];

        $columns = [
            'Sr #',
            'Ref #',
            'Candidate Name',
            'Sales Name',
            'Nationality',
            'Passport No',
            'Visa Stage',
            'Foreign Partner',
            'Current Status',
            'Status Date',
            'Sponsor Name',
            'CN Number',
            'Created At',
            'Actions',
        ];
    @endphp

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            @foreach($columns as $heading)
                <th>{{ $heading }}</th>
            @endforeach
        </tr>
        </thead>

        <tbody>
        @forelse($employees as $e)
            @php
                $rowNumber = $employees->firstItem() + $loop->index;

                [$visaLabel, $visaIcon] =
                    $visaMap[$e->visa_status] ?? ['Not Set', 'fa-question-circle'];

                [$statusLabel, $statusIcon, $statusBadge] =
                    $currentStatusIconMap[$e->current_status] ?? ['Unknown','fa-question-circle','badge-hold'];

                $statusDate = $e->status_date
                    ?? $e->change_status_date
                    ?? $e->updated_at;

                $partnerDisplay = '—';
                if ($e->foreign_partner) {
                    $first = explode(' ', trim($e->foreign_partner))[0] ?? '';
                    $partnerDisplay = $first !== '' ? ucfirst(strtolower($first)) : '—';
                }
            @endphp
            <tr>
                <td>{{ $rowNumber }}</td>

                <td>
                    <a href="{{ route('employees.show', $e->reference_no) }}" class="text-primary">
                        {{ $e->reference_no }}
                    </a>
                </td>

                <td>
                    <a href="{{ route('employees.show', $e->reference_no) }}" class="text-primary">
                        {{ $e->name }}
                    </a>
                </td>

                <td>{{ $e->sales_name ?? '—' }}</td>

                <td>{{ $e->nationality }}</td>

                <td>{{ $e->passport_no }}</td>

                <td>
                    <span class="status-pill badge-wc">
                        <i class="fas {{ $visaIcon }}"></i>
                        {{ $visaLabel }}
                    </span>
                </td>

                <td>{{ $partnerDisplay }}</td>

                <td>
                    <span class="status-pill {{ $statusBadge }}">
                        <i class="fas {{ $statusIcon }}"></i>
                        {{ $statusLabel }}
                    </span>
                </td>

                <td>
                    {{ $statusDate
                        ? \Carbon\Carbon::parse($statusDate)->format('d M Y h:i A')
                        : 'N/A' }}
                </td>

                <td>{{ $e->sponsor_name ?? '—' }}</td>

                <td>{{ $e->CN_Number ?? '—' }}</td>

                <td>{{ \Carbon\Carbon::parse($e->created_at)->format('d M Y h:i A') }}</td>

                <td>
                    <a href="{{ route('employees.show', $e->reference_no) }}" class="btn btn-view btn-icon-only" title="View Profile">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('employees.edit', $e->reference_no) }}" class="btn btn-edit btn-icon-only" title="Edit Employee">
                      <i class="fas fa-pen"></i>
                    </a>
                    <a href="{{ route('boa.process', ['reference_no' => $e->reference_no]) }}" class="btn btn-train btn-icon-only" title="BOA Process">
                      <i class="fas fa-train"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
              <td colspan="{{ count($columns) }}" class="text-center">
                No employees found.
              </td>
            </tr>
        @endforelse
        </tbody>

        <tfoot>
          <tr>
            @foreach($columns as $heading)
              <th>{{ $heading }}</th>
            @endforeach
          </tr>
        </tfoot>
    </table>
</div>

<nav class="py-2">
    <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted small">
            Showing {{ $employees->firstItem() }}–{{ $employees->lastItem() }} of {{ $employees->total() }} results
        </span>
        <ul class="pagination mb-0">
            {{ $employees->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>
