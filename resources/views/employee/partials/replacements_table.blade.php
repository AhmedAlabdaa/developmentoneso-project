<style>
.table-container { width: 100%; overflow-x: auto; position: relative; }
.table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
.table th, .table td { padding: 10px 15px; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.table th { background-color: #343a40; color: white; text-transform: uppercase; font-weight: bold; }
.table-hover tbody tr:hover { background-color: #f1f1f1; }
.table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
.actions { display: flex; gap: 5px; }
.btn-icon-only { display: inline-flex; align-items: center; justify-content: center; padding: 5px; border-radius: 50%; font-size: 12px; width: 30px; height: 30px; color: white; }
.btn-info { background-color: #17a2b8; }
.btn-danger { background-color: #dc3545; }
.sticky-table th:last-child,
.sticky-table td:last-child {
    position: sticky;
    right: 0;
    background-color: white;
    z-index: 2;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
    min-width: 150px;
}
.modal .table th:last-child,
.modal .table td:last-child {
    position: static;
}
.table th:last-child { z-index: 3; }
.status-dropdown {
    padding: 5px;
    font-size: 12px;
    border-radius: 5px;
    width: 120px;
    color: #000;
    font-weight: bold;
    text-transform: uppercase;
}
.status-dropdown.pending  { background-color: #ffc107; }
.status-dropdown.unpaid   { background-color: #ffc107; }
.status-dropdown.paid     { background-color: #28a745; }
.status-dropdown.partially-paid { background-color: #ffc107; }
.status-dropdown.overdue  { background-color: #dc3545; }
.status-dropdown.cancelled { background-color: #dc3545; }
.status-dropdown.hold     { background-color: #ffc107; }
.status-dropdown.cod      { background-color: #17a2b8; }
.img-thumbnail {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
}
.bg-gradient-primary {
   background: linear-gradient(to right, #007bff, #6a11cb);
}
.btn-sm { font-size: 0.8rem; }
.scrollable-modal-body {
    max-height: 500px;
    overflow-y: auto;
}
</style>
@php use Carbon\Carbon; @endphp
<div class="table-container sticky-table">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Ref</th>
                <th>Contract #</th>
                <th>Client</th>
                <th>Old Candidate</th>
                <th>New Candidate</th>
                <th>Replacement Date</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histories as $history)
                <tr>
                    <td> 
                        <a href="{{ route('contracts.show', $history->contract_number) }}" class="text-primary" target="_blank">
                            REP-CT-E-{{ $history->id }}
                        </a>
                    <td>
                        <a href="{{ route('contracts.show', $history->contract_number) }}" class="text-primary" target="_blank">
                            {{ $history->contract_number }}
                        </a>
                    </td>
                    <td>
                        @if($history->client)
                            <a href="{{ route('crm.show', $history->client->slug) }}" class="text-primary" target="_blank">
                                {{ $history->client->first_name }} {{ $history->client->last_name }}
                            </a>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if($history->oldCandidate)
                            <a href="{{ route('employees.show', $history->oldCandidate->id) }}" class="text-primary" target="_blank">
                                {{ $history->oldCandidate->name }}
                            </a>
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if($history->newCandidate)
                            <a href="{{ route('employees.show', $history->newCandidate->id) }}" class="text-primary" target="_blank">
                                {{ $history->newCandidate->name }}
                            </a>
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ Carbon::parse($history->replacement_date)->format('d M Y') }}</td>
                    <td>{{ Carbon::parse($history->created_at)->format('d M Y h:i A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        <h5 style="margin:50px 0;">There are no records available</h5>
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Ref</th>
                <th>Contract #</th>
                <th>Client</th>
                <th>Old Candidate</th>
                <th>New Candidate</th>
                <th>Replacement Date</th>
                <th>Created At</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted small">
            Showing {{ $histories->firstItem() }}–{{ $histories->lastItem() }} of {{ $histories->total() }} results
        </span>
        <ul class="pagination mb-0">
            {{ $histories->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>

