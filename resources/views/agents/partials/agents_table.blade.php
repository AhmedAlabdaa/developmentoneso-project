<style>
    .table-container {
        width: 100%;
        overflow-x: auto;
        position: relative;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .table th,
    .table td {
        padding: 10px 15px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #ddd;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .table th {
        background-color: #343a40;
        color: white;
        text-transform: uppercase;
        font-weight: bold;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    .actions {
        display: flex;
        gap: 5px;
    }
    .btn-icon-only {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        border-radius: 50%;
        font-size: 14px;
        width: 30px;
        height: 30px;
        color: white;
    }
    .btn-info {
        background-color: #17a2b8;
    }
    .btn-warning {
        background-color: #ffc107;
    }
    .btn-danger {
        background-color: #dc3545;
    }
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
    .table th:last-child {
        z-index: 3;
    }
    .bg-gradient-primary {
        background: linear-gradient(to right, #007bff, #6a11cb);
    }
    .btn-sm {
        font-size: 0.8rem;
    }
    .scrollable-modal-body {
        max-height: 500px;
        overflow-y: auto;
    }
</style>

<div class="table-container">
    <table class="table sticky-table table-striped table-hover">
        <thead>
            <tr>
                <th title="SR #">SR #</th>
                <th title="Agent Name">Agent Name</th>
                <th title="Company Name">Company Name</th>
                <th title="Branch Name">Branch Name</th>
                <th title="Country">Country</th>
                <th title="Created At">Created At</th>
                <th title="Action">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agents as $agent)
                <tr>
                    <td>{{ $loop->iteration + ($agents->currentPage() - 1) * $agents->perPage() }}</td>
                    <td>{{ $agent->name }}</td>
                    <td>{{ $agent->company_name }}</td>
                    <td>{{ $agent->branch_name ?? 'N/A' }}</td>
                    <td>{{ $agent->country ?? 'N/A' }}</td>
                    <td>{{ $agent->created_at->format('d-m-Y H:i:s') }}</td>
                    <td class="actions">
                        <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-warning btn-icon-only btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" style="display: inline;" id="delete-form-{{ $agent->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-icon-only btn-sm" onclick="confirmDelete('{{ $agent->id }}')" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th title="SR #">SR #</th>
                <th title="Agent Name">Agent Name</th>
                <th title="Company Name">Company Name</th>
                <th title="Branch Name">Branch Name</th>
                <th title="Country">Country</th>
                <th title="Created At">Created At</th>
                <th title="Action">Action</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing {{ $agents->firstItem() }} to {{ $agents->lastItem() }} of {{ $agents->total() }} results
        </span>
        <ul class="pagination justify-content-center">
            {{ $agents->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>
<script>
    function confirmDelete(agentID) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will delete the agent.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${agentID}`).submit();
            }
        });
    }
</script>
