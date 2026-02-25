<style>
.table-container{width:100%;overflow-x:auto;position:relative}.table{width:100%;border-collapse:collapse;table-layout:auto;border-spacing:0}.table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.table th{background-color:#343a40;color:#fff;text-transform:uppercase;font-weight:bold}.table-hover tbody tr:hover{background-color:#f1f1f1}.table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}@media screen and (max-width:768px){.table th,.table td{padding:8px 12px}}.actions{display:flex;gap:5px}.btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:13px;width:30px;height:30px;color:#fff}.btn-info{background-color:#17a2b8}.btn-warning{background-color:#ffc107}.btn-danger{background-color:#dc3545}
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>CL Number</th>
                <th>Created At</th>
                <th>Name</th>
                <th>Emirates ID</th>
                <th>Nationality</th>
                <th>Mobile</th>
                <!-- <th>Email</th> -->
                <th>Passport Number</th>
                <th>Emirates</th>
                <!-- <th>Emergency Contact Person</th> -->
                <th>Source</th>
                <th>Passport Copy</th>
                <th>ID Copy</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($crms as $entry)
                <tr>
                    <td>{{ $entry->cl ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('d M Y') }}</td>
                    <td>{{ $entry->first_name }} {{ $entry->last_name }}</td>
                    <td>{{ $entry->emirates_id }}</td>
                    <td>{{ $entry->nationality === 'United Arab Emirates' ? 'Emirati' : $entry->nationality }}</td>
                    <td>{{ $entry->mobile }}</td>
                    <!-- <td>{{ $entry->email }}</td> -->
                    <td>{{ $entry->passport_number }}</td>
                    <td>{{ $entry->address }}</td>
                    <!-- <td>{{ $entry->emergency_contact_person }}</td> -->
                    <td>{{ $entry->source }}</td>
                    <td><a href="{{ asset('storage/' . $entry->passport_copy) }}" target="_blank">View</a></td>
                    <td><a href="{{ asset('storage/' . $entry->id_copy) }}" target="_blank">View</a></td>
                    <td class="actions">
                        <a href="{{ route('crm.show', $entry->slug) }}" class="btn btn-info btn-icon-only" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('crm.edit', $entry->slug) }}" class="btn btn-warning btn-icon-only" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('crm.destroy', $entry->slug) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-icon-only" title="Delete" onclick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>CL Number</th>
                <th>Created At</th>
                <th>Name</th>
                <th>Emirates ID</th>
                <th>Nationality</th>
                <th>Mobile</th>
                <!-- <th>Email</th> -->
                <th>Passport Number</th>
                <th>Emirates</th>
                <!-- <th>Emergency Contact Person</th> -->
                <th>Source</th>
                <th>Passport Copy</th>
                <th>ID Copy</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>

<nav class="py-2">
  <div class="d-flex justify-content-between align-items-center">
    <span class="text-muted small">Showing {{ $crms->firstItem() }}–{{ $crms->lastItem() }} of {{ $crms->total() }}</span>
    <ul class="pagination mb-0">{{ $crms->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}</ul>
  </div>
</nav>
