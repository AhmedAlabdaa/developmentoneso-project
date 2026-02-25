<style>
    .table-container{width:100%;overflow-x:auto;position:relative}
    .table{width:100%;border-collapse:collapse;margin-bottom:12px}
    .table th,.table td{
        padding:10px 12px;
        text-align:left;
        vertical-align:middle;
        border-bottom:1px solid #e6e6e6;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        max-width:260px
    }
    .table thead th{
        background:#343a40;
        color:#fff;
        text-transform:uppercase;
        font-weight:700;
        font-size:12px;
        letter-spacing:.3px
    }
    .table-hover tbody tr:hover{background-color:#f6f7f8}
    .table-striped tbody tr:nth-of-type(odd){background-color:#fafafa}

    .actions{display:flex;gap:6px;justify-content:flex-start}
    .btn-icon-only{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:5px;
        border-radius:50%;
        font-size:12px;
        width:32px;
        height:32px;
        color:#fff;
        border:none
    }
    .btn-info{background-color:#17a2b8}
    .btn-warning{background-color:#ffc107;color:#000}
    .btn-danger{background-color:#dc3545}

    .sticky-table th:last-child,
    .sticky-table td:last-child{
        position:sticky;
        right:0;
        background-color:#fff;
        z-index:2;
        box-shadow:-2px 0 5px rgba(0,0,0,.08);
        min-width:170px
    }
    .table thead th:last-child{z-index:3;background-color:#343a40;color:#fff}

    .badge{
        font-size:11px;
        padding:6px 8px;
        border-radius:10px;
        font-weight:700;
        text-transform:uppercase
    }
    .badge-soft{background:#f1f3f5;color:#212529}
    .badge-yes{background:#d4edda;color:#155724}
    .badge-no{background:#f8d7da;color:#721c24}
    .badge-type{background:#e7f1ff;color:#004085}

    .pagination-container{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:10px;
        flex-wrap:wrap
    }
    .muted-text{color:#6c757d;font-size:12px}
</style>

<div class="table-container">
    <table class="table sticky-table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th title="Account Code">Code</th>
                <th title="Account Name">Name</th>
                <th title="Account Type">Type</th>
                <th title="Normal Balance">NB</th>
                <th title="Posting Account">Posting</th>
                <th title="Control Account">Control</th>
                <th title="Active">Active</th>
                <th title="Parent Account">Parent</th>
                <th title="Currency">Curr</th>
                <th title="Action">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($accounts as $account)
                <tr>
                    <td title="{{ $account->account_code }}"><strong>{{ $account->account_code }}</strong></td>

                    <td title="{{ $account->account_name }}">{{ $account->account_name }}</td>

                    <td><span class="badge badge-type">{{ strtoupper($account->account_type) }}</span></td>

                    <td>
                        @if(($account->normal_balance ?? '') === 'D')
                            <span class="badge badge-yes">D</span>
                        @elseif(($account->normal_balance ?? '') === 'C')
                            <span class="badge badge-soft">C</span>
                        @else
                            <span class="badge badge-soft">N/A</span>
                        @endif
                    </td>

                    <td>
                        @if((int)($account->is_posting ?? 0) === 1)
                            <span class="badge badge-yes">Yes</span>
                        @else
                            <span class="badge badge-no">No</span>
                        @endif
                    </td>

                    <td>
                        @if((int)($account->is_control ?? 0) === 1)
                            <span class="badge badge-soft">Yes</span>
                        @else
                            <span class="badge badge-no">No</span>
                        @endif
                    </td>

                    <td>
                        @if((int)($account->is_active ?? 1) === 1)
                            <span class="badge badge-yes">Active</span>
                        @else
                            <span class="badge badge-no">Inactive</span>
                        @endif
                    </td>

                    <td title="{{ $account->parentAccount ? ($account->parentAccount->account_code . ' - ' . $account->parentAccount->account_name) : 'Top Level' }}">
                        @if($account->parentAccount)
                            {{ $account->parentAccount->account_code }} - {{ $account->parentAccount->account_name }}
                        @else
                            <span class="text-muted">Top Level</span>
                        @endif
                    </td>

                    <td><span class="badge badge-soft">{{ strtoupper($account->currency_code ?? 'AED') }}</span></td>

                    <td class="actions">
                        <a href="{{ route('chart-of-accounts.show', $account->account_id) }}" class="btn btn-info btn-icon-only btn-sm" title="View">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('chart-of-accounts.edit', $account->account_id) }}" class="btn btn-warning btn-icon-only btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('chart-of-accounts.destroy', $account->account_id) }}" method="POST" style="display:inline;" id="delete-form-{{ $account->account_id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-icon-only btn-sm" onclick="confirmDelete('{{ $account->account_id }}')" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-4">No accounts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            @if($accounts->total() > 0)
                Showing {{ $accounts->firstItem() }} to {{ $accounts->lastItem() }} of {{ $accounts->total() }} results
            @else
                Showing 0 results
            @endif
        </span>
        <div>
            {{ $accounts->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</nav>
