@include('role_header')
<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
      <h5 class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>Agreement Pending Approval</h5>
      <a href="{{ route('agreements.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Agreements
      </a>
    </div>
    <div class="card-body">
      <table class="table table-bordered mb-4">
        <thead class="table-light">
          <tr>
            <th>Agreement #</th>
            <th>Customer Name</th>
            <th>Candidate Name</th>
            <th>Type</th>
            <th>Package</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $agreement->reference_no }}</td>
            <td>{{ optional($agreement->client)->first_name ?? '—' }}</td>
            <td>{{ $agreement->candidate_name }}</td>
            <td>{{ $agreement->agreement_type }}</td>
            <td>{{ $agreement->package }}</td>
            <td>{{ $agreement->created_at->format('d M Y h:i A') }}</td>
          </tr>
        </tbody>
      </table>

      <div class="alert alert-info d-flex align-items-center">
        <i class="fas fa-info-circle fa-lg me-2"></i>
        <div>
          This agreement has not yet been approved. Please contact your Contract/Agreement Administrator to approve it in order to proceed with further actions.
        </div>
      </div>
    </div>
  </div>
</div>
