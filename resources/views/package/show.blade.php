@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/css/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
  .custom-card{gap:16px;background:#f9f9f9;border-radius:12px;padding:16px 24px;box-shadow:0 2px 4px rgba(0,0,0,.1);border-left:4px solid #0d6efd}
  .card-title-name{font-size:1.25rem;font-weight:600;color:#0d6efd;text-transform:capitalize;text-align:center;margin:0}
  .modal-navigation-tabs{display:flex;margin:16px 0;border-bottom:1px solid #ddd;overflow-x:auto}
  .modal-navigation-item{padding:8px 16px;background:none;border:none;cursor:pointer;font-size:.875rem;color:#6c757d;display:flex;align-items:center;gap:8px;white-space:nowrap}
  .modal-navigation-item.active{color:#0d6efd;font-weight:600;border-bottom:2px solid #0d6efd}
  .modal-content-section{margin-top:16px}
  .modal-tab-content{display:none;font-size:12px;color:#333;font-family:Arial,Helvetica,sans-serif}
  .modal-tab-content.active{display:block}
  .profile-details{display:flex;flex-wrap:wrap;gap:10px}
  .detail-row{display:flex;justify-content:space-between;width:calc(50% - 10px);border-bottom:1px solid #eee;padding:5px 0}
  .detail-label{font-weight:600;color:#000}
  .detail-value{color:#777;text-align:right}
  @media(max-width:768px){.detail-row{width:100%}}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card custom-card">
          <h2 class="card-title-name">{{ $package->candidate_name }}</h2>

          <div class="modal-navigation-tabs">
            <button class="modal-navigation-item active" data-tab="info"><i class="fa-solid fa-circle-info"></i> Information</button>
            <button class="modal-navigation-item" data-tab="office"><i class="fa-solid fa-building"></i> Office</button>
            <button class="modal-navigation-item" data-tab="trial"><i class="fa-solid fa-gavel"></i> Trial</button>
            <button class="modal-navigation-item" data-tab="confirmed"><i class="fa-solid fa-circle-check"></i> Confirmed</button>
            <button class="modal-navigation-item" data-tab="change"><i class="fa-solid fa-arrows-rotate"></i> Change&nbsp;Status</button>
          </div>

          <div class="modal-content-section">
            <div class="modal-tab-content active" id="info">
              <div class="profile-details">
                <div class="detail-row"><span class="detail-label">ID:</span><span class="detail-value">{{ $package->id }}</span></div>
                <div class="detail-row"><span class="detail-label">Candidate ID:</span><span class="detail-value">{{ $package->candidate_id }}</span></div>
                <div class="detail-row"><span class="detail-label">CN Number:</span><span class="detail-value">{{ $package->CN_Number }}</span></div>
                <div class="detail-row"><span class="detail-label">HR Ref No:</span><span class="detail-value">{{ $package->hr_ref_no }}</span></div>
                <div class="detail-row"><span class="detail-label">Sales Name:</span><span class="detail-value">{{ $package->sales_name }}</span></div>
                <div class="detail-row"><span class="detail-label">Foreign Partner:</span><span class="detail-value">{{ $package->foreign_partner }}</span></div>
                <div class="detail-row"><span class="detail-label">Agreement No:</span><span class="detail-value">{{ $package->agreement_no }}</span></div>
                <div class="detail-row"><span class="detail-label">Contract No:</span><span class="detail-value">{{ $package->contract_no }}</span></div>
                <div class="detail-row"><span class="detail-label">Current Status:</span><span class="detail-value">{{ $package->current_status }}</span></div>
                <div class="detail-row"><span class="detail-label">Inside Status:</span><span class="detail-value">{{ $package->inside_status }}</span></div>
                <div class="detail-row"><span class="detail-label">Change Status Date:</span><span class="detail-value">{{ $package->change_status_date }}</span></div>
                <div class="detail-row"><span class="detail-label">CS Date:</span><span class="detail-value">{{ $package->cs_date }}</span></div>
                <div class="detail-row"><span class="detail-label">Change Status Proof:</span><span class="detail-value">{{ $package->change_status_proof }}</span></div>
                <div class="detail-row"><span class="detail-label">Penalty Payment Amount:</span><span class="detail-value">{{ $package->penalty_payment_amount }}</span></div>
                <div class="detail-row"><span class="detail-label">Penalty Payment Proof:</span><span class="detail-value">{{ $package->penalty_payment_proof }}</span></div>
                <div class="detail-row"><span class="detail-label">Penalty Paid By:</span><span class="detail-value">{{ $package->penalty_paid_by }}</span></div>
                <div class="detail-row"><span class="detail-label">Istiraha Proof:</span><span class="detail-value">{{ $package->istiraha_proof }}</span></div>
                <div class="detail-row"><span class="detail-label">Passport No:</span><span class="detail-value">{{ $package->passport_no }}</span></div>
                <div class="detail-row"><span class="detail-label">Passport Expiry:</span><span class="detail-value">{{ $package->passport_expiry_date }}</span></div>
                <div class="detail-row"><span class="detail-label">Date of Birth:</span><span class="detail-value">{{ $package->date_of_birth }}</span></div>
                <div class="detail-row"><span class="detail-label">Branch in UAE:</span><span class="detail-value">{{ $package->branch_in_uae }}</span></div>
                <div class="detail-row"><span class="detail-label">Visa Type:</span><span class="detail-value">{{ $package->visa_type }}</span></div>
                <div class="detail-row"><span class="detail-label">CL Number:</span><span class="detail-value">{{ $package->CL_Number }}</span></div>
                <div class="detail-row"><span class="detail-label">Sponsor Name:</span><span class="detail-value">{{ $package->sponsor_name }}</span></div>
                <div class="detail-row"><span class="detail-label">EID No:</span><span class="detail-value">{{ $package->eid_no }}</span></div>
                <div class="detail-row"><span class="detail-label">CL Nationality:</span><span class="detail-value">{{ $package->CL_nationality }}</span></div>
                <div class="detail-row"><span class="detail-label">Nationality:</span><span class="detail-value">{{ $package->nationality }}</span></div>
                <div class="detail-row"><span class="detail-label">WC Date:</span><span class="detail-value">{{ $package->wc_date }}</span></div>
                <div class="detail-row"><span class="detail-label">DW Number:</span><span class="detail-value">{{ $package->dw_number }}</span></div>
                <div class="detail-row"><span class="detail-label">Visa Date:</span><span class="detail-value">{{ $package->visa_date }}</span></div>
                <div class="detail-row"><span class="detail-label">Incident Type:</span><span class="detail-value">{{ $package->incident_type }}</span></div>
                <div class="detail-row"><span class="detail-label">Incident Date:</span><span class="detail-value">{{ $package->incident_date }}</span></div>
                <div class="detail-row"><span class="detail-label">Arrived Date:</span><span class="detail-value">{{ $package->arrived_date }}</span></div>
                <div class="detail-row"><span class="detail-label">Package:</span><span class="detail-value">{{ $package->package }}</span></div>
                <div class="detail-row"><span class="detail-label">Sales Comm Status:</span><span class="detail-value">{{ $package->sales_comm_status }}</span></div>
                <div class="detail-row"><span class="detail-label">Remark:</span><span class="detail-value">{{ $package->remark }}</span></div>
                <div class="detail-row"><span class="detail-label">Missing File:</span><span class="detail-value">{{ $package->missing_file }}</span></div>
                <div class="detail-row"><span class="detail-label">Created At:</span><span class="detail-value">{{ $package->created_at }}</span></div>
                <div class="detail-row"><span class="detail-label">Updated At:</span><span class="detail-value">{{ $package->updated_at }}</span></div>
              </div>
            </div>

            <div class="modal-tab-content" id="office"><p class="text-center text-muted m-0">No records exist.</p></div>
            <div class="modal-tab-content" id="trial"><p class="text-center text-muted m-0">No records exist.</p></div>
            <div class="modal-tab-content" id="confirmed"><p class="text-center text-muted m-0">No records exist.</p></div>
            <div class="modal-tab-content" id="change"><p class="text-center text-muted m-0">No records exist.</p></div>
          </div>

          <div class="text-center mt-4">
            <a href="{{ route('package.index') }}" class="btn btn-secondary me-2"><i class="fa-solid fa-list me-1"></i>Back to List</a>
            <a href="{{ route('package.edit', $package->id) }}" class="btn btn-primary me-2"><i class="fa-solid fa-pen-to-square me-1"></i>Edit Package</a>
            <form action="{{ route('package.destroy', $package->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this package?');"><i class="fa-solid fa-trash-can me-1"></i>Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@include('../layout.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(function(){
    $('.modal-navigation-item').on('click',function(){
      const target=$(this).data('tab');
      $('.modal-navigation-item').removeClass('active');
      $(this).addClass('active');
      $('.modal-tab-content').removeClass('active');
      $('#'+target).addClass('active');
    });
  });
</script>
