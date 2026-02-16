@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        font-family: Arial, sans-serif;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
        font-size: 12px;
    }
    .nav-tabs .nav-link {
        transition: background-color 0.2s;
        color: #495057;
    }
    .nav-tabs .nav-link:hover {
        background-color: #f8f9fa;
    }
    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: white;
    }
    .filter-section {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        margin-top: 20px;
    }
    .table-responsive {
        margin-top: 20px;
    }
    .btn {
        transition: background-color 0.2s, color 0.2s;
    }
    .btn:hover {
        background-color: #007bff;
        color: white;
    }
    .table thead th {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
    }
    .form-control, .form-select {
        font-size: 12px;
    }
    .card-title {
        font-weight: normal;
    }
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
    }
    .pagination .page-item .page-link {
        color: #007bff;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }
    .large-search-input {
        min-width: 300px;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">LEADS LIST</h5>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="row align-items-center mb-3">
                            <div class="col-md-6">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == '' ? 'active' : '' }}"
                                           href="{{ route('leads.index') }}">
                                           <i class="fas fa-list"></i> All Leads
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == 'In negotiation' ? 'active' : '' }}"
                                           href="{{ route('leads.index', ['status' => 'In negotiation']) }}">
                                           <i class="fas fa-comments"></i> In negotiation
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == 'On Hold' ? 'active' : '' }}"
                                           href="{{ route('leads.index', ['status' => 'On Hold']) }}">
                                           <i class="fas fa-pause-circle"></i> On Hold
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') == 'Customer' ? 'active' : '' }}"
                                           href="{{ route('leads.index', ['status' => 'Customer']) }}">
                                           <i class="fas fa-user-check"></i> Customer
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <form method="GET" action="{{ route('leads.index') }}" class="d-flex me-3">
                                    <div class="input-group">
                                        <input type="text" name="globalSearch" class="form-control large-search-input"
                                               placeholder="Search by name, phone or email"
                                               value="{{ request()->query('globalSearch') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                                <a href="{{ route('leads.create') }}" class="btn btn-primary me-2">
                                    <i class="fas fa-plus"></i> Add Lead
                                </a>
                                <button type="button" id="toggleFilterBtn" class="btn btn-secondary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                        <div class="filter-section p-3" id="filterSection" style="display: none;">
                            <form method="GET" action="{{ route('leads.index') }}" class="row g-2">
                                <div class="col-md-3">
                                    <select name="status" class="form-select">
                                        <option value="">All Statuses</option>
                                        <option value="In negotiation" {{ request('status') == 'In negotiation' ? 'selected' : '' }}>In negotiation</option>
                                        <option value="On Hold" {{ request('status') == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                        <option value="Customer" {{ request('status') == 'Customer' ? 'selected' : '' }}>Customer</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="source" class="form-select">
                                        <option value="">All Sources</option>
                                        <option value="respond.io" {{ request('source') == 'respond.io' ? 'selected' : '' }}>Respond.io</option>
                                        <option value="Instagram" {{ request('source') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                                        <option value="Facebook" {{ request('source') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                        <option value="Referral" {{ request('source') == 'Referral' ? 'selected' : '' }}>Referral</option>
                                        <option value="Walk-in" {{ request('source') == 'Walk-in' ? 'selected' : '' }}>Walk-in</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="sales_name" class="form-control" placeholder="Sales Name" value="{{ request()->query('sales_name') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="from_date" class="form-control" placeholder="From Date" value="{{ request()->query('from_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="to_date" class="form-control" placeholder="To Date" value="{{ request()->query('to_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="phone" class="form-control" placeholder="Enter phone number" value="{{ request()->query('phone') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{ request()->query('email') }}">
                                </div>
                                <div class="col-md-12 d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('leads.index') }}" class="btn btn-warning ms-2">
                                        <i class="fas fa-undo"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Sales Name</th>
                                    <th>Sales Email</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leads as $key => $lead)
                                    <tr>
                                        <td>{{ $leads->firstItem() + $key }}</td>
                                        <td>{{ $lead->first_name }}</td>
                                        <td>{{ $lead->last_name }}</td>
                                        <td>{{ $lead->phone }}</td>
                                        <td>{{ $lead->email }}</td>
                                        <td>{{ $lead->sales_name }}</td>
                                        <td>{{ $lead->sales_email }}</td>
                                        <td>{{ $lead->source }}</td>
                                        <td>{{ $lead->status }}</td>
                                        <td>
                                            @if($lead->status_date_time)
                                                {{ \Carbon\Carbon::parse($lead->status_date_time)->format('d F Y h:i A') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if(auth()->user()->role === 'Admin')
                                                <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No leads found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation" class="pagination-container">
                            <span class="muted-text">
                                Showing {{ $leads->firstItem() }} to {{ $leads->lastItem() }} of {{ $leads->total() }} results
                            </span>
                            <div>
                                {{ $leads->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@include('layout.footer')
<script>
document.getElementById('toggleFilterBtn').addEventListener('click', function() {
    const filterSection = document.getElementById('filterSection');
    if (filterSection.style.display === 'none' || !filterSection.style.display) {
        filterSection.style.display = 'block';
    } else {
        filterSection.style.display = 'none';
    }
});
</script>
