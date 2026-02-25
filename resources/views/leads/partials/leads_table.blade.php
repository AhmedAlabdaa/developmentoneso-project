<style>
   .table-container {
        width: 100%;
        overflow-x: auto;
        position: relative;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
        border-spacing: 0;
        margin-bottom: 20px;
    }

    .table th, .table td {
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

    @media screen and (max-width: 768px) {
        .table th, .table td {
            padding: 8px 12px;
        }
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
        font-size: 13px;
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
</style>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>SR #</th>
            <th>Lead Name</th>
            <th>Email</th>
            <th>Sales Name</th>
            <th>Source</th>
            <th>Status</th>
            <th>Status Date/Time</th>
            <th>Notes</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leads as $index => $lead)
            <tr>
                <td>{{ ($leads->currentPage() - 1) * $leads->perPage() + $index + 1 }}</td>
                <td>{{ $lead->name }}</td>
                <td>{{ $lead->email }}</td>
                <td>{{ $lead->sales_name }}</td>
                <td>{{ $lead->source }}</td>
                <td>{{ $lead->status }}</td>
                <td>{{ $lead->status_date_time ? \Carbon\Carbon::parse($lead->status_date_time)->format('Y-m-d H:i') : 'N/A' }}</td>
                <td>{{ $lead->notes }}</td>
                <td class="actions">
                    <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-info btn-icon-only" title="View/Edit">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-warning btn-icon-only" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-icon-only" title="Delete" onclick="return confirm('Are you sure you want to delete this lead?');">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                    <form action="{{ route('leads.convert', $lead->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-icon-only" title="Convert">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>SR #</th>
            <th>Lead Name</th>
            <th>Email</th>
            <th>Sales Name</th>
            <th>Source</th>
            <th>Status</th>
            <th>Status Date/Time</th>
            <th>Notes</th>
            <th>Actions</th>
        </tr>
    </tfoot>
</table>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing {{ $leads->firstItem() }} to {{ $leads->lastItem() }} of {{ $leads->total() }} results
        </span>
        <ul class="pagination justify-content-center">
            {{ $leads->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>
