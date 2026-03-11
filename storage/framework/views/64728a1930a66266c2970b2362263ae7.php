<style>
  body {
    background: linear-gradient(to right, #e0f7fa, #e1bee7);
    font-family: Arial, sans-serif;
  }
  .nav-tabs .nav-link {
    transition: background-color 0.2s;
    color: #495057;
    font-size: 12px;
    text-transform: uppercase;
  }
  .nav-tabs .nav-link:hover {
    background-color: #f8f9fa;
  }
  .nav-tabs .nav-link.active {
    background-color: #007bff;
    color: white;
  }
  .table thead th,
  .table tfoot th {
    background: linear-gradient(to right, #007bff, #00c6ff);
    color: white;
    text-align: center;
    font-weight: normal;
  }
  .pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
  }
  .muted-text {
    color: #6c757d;
    font-size: 12px;
  }
  .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
  }
  .pagination .page-item {
    margin: 0 0.1rem;
  }
  .pagination .page-link {
    border-radius: 0.25rem;
    padding: 0.5rem 0.75rem;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #007bff;
    transition: background-color 0.2s, color 0.2s;
  }
  .pagination .page-link:hover {
    background-color: #007bff;
    color: white;
  }
  .pagination .page-item.active .page-link {
    background-color: #007bff;
    color: white;
    border: 1px solid #007bff;
  }
  .pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border: 1px solid #6c757d;
    cursor: not-allowed;
  }
  .pagination .page-item:first-child .page-link {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
  }
  .pagination .page-item:last-child .page-link {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
  }
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
  .btn-icon-only {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px;
    border-radius: 50%;
    font-size: 12px;
    width: 30px;
    height: 30px;
    color: white;
  }
  .btn-danger {
    background-color: #dc3545;
  }
  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }
  .btn-primary:hover {
    background-color: #0069d9;
    border-color: #0062cc;
  }
  .btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
  }
  .btn-info:hover {
    background-color: #138496;
    border-color: #117a8b;
  }
  .btn-sm {
    font-size: 0.8rem;
  }
  .dropdown-container {
    display: none;
    position: fixed;
    z-index: 1050;
    background-color: #ffffff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    min-width: 350px;
    max-width: 450px;
    text-align: center;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    border: 4px solid #007bff;
    animation: fadeIn 0.3s ease-in-out;
  }
  .dropdown-header {
    margin-bottom: 15px;
  }
  .dropdown-header .header-icon {
    font-size: 24px;
    color: #007bff;
    margin-bottom: 10px;
  }
  .dropdown-header p {
    font-size: 12px;
    font-weight: bold;
    color: #333;
    margin: 5px 0;
    line-height: 1.5;
  }
  .package-name {
    color: #007bff;
    font-weight: bold;
    font-size: 12px;
  }
  .status-dropdown {
    width: 100%;
    margin-top: 10px;
    font-size: 12px;
    border: 2px solid #007bff;
    border-radius: 6px;
    outline: none;
    background-color: #fff;
    color: #333;
  }
  .close-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    color: #ff6347;
    cursor: pointer;
    transition: color 0.3s ease;
  }
  .close-icon:hover {
    color: #ff4500;
  }
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translate(-50%, -55%);
    }
    to {
      opacity: 1;
      transform: translate(-50%, -50%);
    }
  }
  .custom-modal .modal-content {
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    font-size: 12px;
    background: #ffffff;
  }
  .custom-modal .modal-header {
    background: linear-gradient(135deg, #007bff, #6a11cb);
    color: #fff;
    padding: 15px;
    border-radius: 12px 12px 0 0;
  }
  .custom-modal .modal-header h5 {
    font-size: 12px;
    font-weight: bold;
    margin: 0;
    color: #fff;
  }
  .custom-modal .modal-body {
    padding: 20px;
    color: #333;
    background: #f9f9f9;
  }
  .custom-modal .modal-footer {
    padding: 15px;
    border-top: 1px solid #ddd;
    border-radius: 0 0 12px 12px;
    background: #f1f1f1;
  }
  .alert {
    padding: .6rem .9rem;
    border-radius: .4rem;
    margin-bottom: 10px;
  }
  .alert-danger {
    background: #fde2e1;
    color: #611a15;
    border: 1px solid #f5b5b2;
  }
  .btn-sales {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid #0d6efd;
    background: #fff;
    color: #0d6efd;
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 12px;
  }
  .btn-sales i {
    font-size: 12px;
  }
  .sales-modal-select {
    font-size: 12px;
    line-height: 1.3;
    padding: .375rem .75rem;
  }
  .sales-modal-label {
    font-size: 12px;
  }
  .custom-modal .modal-title i {
    font-size: 12px;
  }
  .sr-penalty-head {
    background: linear-gradient(135deg, #007bff, #6a11cb);
    color: #fff;
    border-radius: 10px 10px 0 0;
    padding: 10px 14px;
    font-weight: 700;
    letter-spacing: .3px;
  }
  .sr-penalty-body {
    border: 1px solid #dee2e6;
    border-top: none;
    border-radius: 0 0 10px 10px;
    padding: 12px;
    background: #fff;
  }
  .noc-extra.d-none {
    display: none !important;
  }
  .is-invalid {
    border-color: #dc3545 !important;
  }
  .invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: .875rem;
    margin-top: .25rem;
  }
  .invalid-feedback.show-feedback {
    display: block;
  }
</style>

<div id="fullscreenOverlay" class="fullscreen-overlay"></div>

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>CN Number</th>
        <th>Candidate Name</th>
        <th>Nationality</th>
        <th>Partner</th>
        <th>Sponsor Name</th>
        <th>QID</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Sales Name</th>
        <th>Status Date</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td><?php echo e(strtoupper($p->CN_Number ?? '-')); ?></td>
          <td><?php echo e(strtoupper($p->candidate_name ?? '-')); ?></td>
          <td><?php echo e(strtoupper($p->nationality ?? '-')); ?></td>
          <td><?php echo e($p->foreign_partner ? strtoupper(preg_split('/\s+/', trim($p->foreign_partner))[0]) : '-'); ?></td>
          <td><?php echo e(strtoupper($p->sponsor_name ?? '-')); ?></td>
          <td><?php echo e(strtoupper($p->eid_no ?? '-')); ?></td>
          <td>
            <?php echo e(!empty($p->trial_start_date) ? \Carbon\Carbon::parse($p->trial_start_date)->format('d M Y') : '-'); ?>

          </td>
          <td>
            <?php echo e(!empty($p->trial_end_date) ? \Carbon\Carbon::parse($p->trial_end_date)->format('d M Y') : '-'); ?>

          </td>
          <td><?php echo e(strtoupper($p->sales_name ?? '-')); ?></td>
          <td>
            <?php if($p->updated_at): ?>
              <?php echo e(\Carbon\Carbon::parse($p->updated_at)->format('d M Y h:i A')); ?>

            <?php else: ?>
              -
            <?php endif; ?>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-icon-only" title="Actions" onclick="openDropdown('<?php echo e($p->trial_id); ?>', this, '<?php echo e($p->candidate_name); ?>')">
              <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-container" id="dropdownContainer-<?php echo e($p->trial_id); ?>">
              <div class="close-icon" onclick="closeAllDropdowns()">
                <i class="fas fa-times-circle"></i>
              </div>
              <div class="dropdown-header">
                <div class="header-icon">
                  <i class="fas fa-tasks"></i>
                </div>
                <p>
                  Actions for
                  <span class="package-name">
                    <?php echo e($p->candidate_name ?? '-'); ?>

                  </span>
                </p>
              </div>
              <select class="form-control status-dropdown" data-candidate-id="<?php echo e($p->trial_id); ?>" data-cn="<?php echo e($p->CN_Number); ?>" data-passport="<?php echo e($p->passport_no); ?>" data-candidate-name="<?php echo e($p->candidate_name); ?>" onchange="handleActionChange(this)">
                <option value="">Select Action</option>
                <option value="incident">Incident</option>
                <option value="sales_return">Sales Return</option>
              </select>
            </div>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="11" class="text-center">No results found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <th>CN Number</th>
        <th>Candidate Name</th>
        <th>Nationality</th>
        <th>Partner</th>
        <th>Sponsor Name</th>
        <th>QID</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Sales Name</th>
        <th>Status Date</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>
</div>

<?php if($packages instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
  <nav aria-label="Page navigation">
    <div class="d-flex justify-content-between align-items-center">
      <span class="text-muted small">
        Showing <?php echo e($packages->firstItem()); ?> to <?php echo e($packages->lastItem()); ?> of <?php echo e($packages->total()); ?> results
      </span>
      <div>
        <?php echo e($packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

      </div>
    </div>
  </nav>
<?php endif; ?>

<div class="modal fade custom-modal" id="incidentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-exclamation-triangle me-2"></i> Incident Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="$('#incidentModal').modal('hide');"></button>
      </div>
      <div class="modal-body">
        <form id="incidentForm" enctype="multipart/form-data" method="POST">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="trial_id" id="incident_trial_id">
          <input type="hidden" name="package_id" id="incident_package_id">
          <input type="hidden" name="candidate_id" id="incident_candidate_id">
          <input type="hidden" name="cn_number" id="incident_cn_number">
          <input type="hidden" name="passport_no" id="incident_passport_no">
          <input type="hidden" name="type" id="incident_scope" value="package">

          <div class="mb-3">
            <label for="incident_candidate_name">Candidate Name</label>
            <input type="text" id="incident_candidate_name" name="candidate_name" class="form-control" readonly>
          </div>

          <div class="mb-3">
            <label for="incident_type">Incident Type</label>
            <select id="incident_type" name="incident_type" class="form-select" required>
              <option value="">Select Type</option>
              <option value="RUNAWAY">RUNAWAY</option>
              <option value="REPATRIATION">REPATRIATION</option>
              <option value="UNFIT">UNFIT</option>
              <option value="REFUSED">REFUSED</option>
              <option value="PSYCHIATRIC">PSYCHIATRIC</option>
              <option value="SICK">SICK</option>
            </select>
            <div class="invalid-feedback"></div>
          </div>

          <div class="mb-3">
            <label for="incident_date">Incident Date</label>
            <input type="date" id="incident_date" name="incident_date" class="form-control" required>
            <div class="invalid-feedback"></div>
          </div>

          <div class="mb-3">
            <label for="incident_comments">Comments</label>
            <textarea id="incident_comments" name="comments" class="form-control" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label for="incident_proof">Incident Proof</label>
            <input
              type="file"
              id="incident_proof"
              name="proof"
              class="form-control"
              accept=".pdf,.jpg,.jpeg,.png"
            >
          </div>

          <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="$('#incidentModal').modal('hide');">
              <i class="fas fa-times me-1"></i> Close
            </button>
            <button type="button" id="saveIncidentBtn" class="btn btn-danger" onclick="saveIncidentData()">
              <i class="fas fa-save me-1"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="SalesReturnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fa-solid fa-box-open text-light me-2"></i> Sales Return
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="SalesReturnModalForm" enctype="multipart/form-data" method="POST">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="row g-3 mb-2">
            <div class="col-md-4">
              <label class="form-label">Candidate Name</label>
              <input type="text" id="SalesReturnModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="SalesReturnModalcandidateId" name="candidate_id">
              <input type="hidden" name="trial_id" id="SalesReturnModaltrial_id">
              <input type="hidden" id="SalesReturnModalpassportNo" name="passport_no">
            </div>
            <div class="col-md-4">
              <label class="form-label">Employer Name</label>
              <input type="text" name="employer_name" id="SalesReturnModalclientName" class="form-control" readonly>
            </div>
            <div class="col-md-4">
              <label class="form-label">Return Date</label>
              <input type="date" class="form-control js-sales-return-date" name="return_date" value="<?php echo e(\Carbon\Carbon::now('Asia/Qatar')->format('Y-m-d')); ?>">
            </div>
          </div>

          <div class="mb-2">
            <div class="d-inline-flex align-items-center gap-3">
              <div class="form-check form-check-inline">
                <input class="form-check-input js-sales-decision" type="radio" name="action_type" id="SalesActionRefund" value="refund" checked>
                <label class="form-check-label" for="SalesActionRefund">Refund</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input js-sales-decision" type="radio" name="action_type" id="SalesActionReplacement" value="replacement">
                <label class="form-check-label" for="SalesActionReplacement">Replacement</label>
              </div>
            </div>
          </div>

          <div id="DecisionContentSales" class="mt-2"></div>

          <div class="mt-3">
            <div class="sr-penalty-head">NOC Expiry</div>
            <div class="sr-penalty-body">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label">NOC Expiry</label>
                  <select id="nocExpirySelect" name="noc_expiry_status" class="form-select">
                    <option value="" selected>Select</option>
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                  </select>
                </div>
                <div class="col-md-4 noc-extra d-none">
                  <label class="form-label">NOC Expiry Date</label>
                  <input type="date" id="nocExpiryDate" name="noc_expiry_date" class="form-control">
                </div>
                <div class="col-md-4 noc-extra d-none">
                  <label class="form-label">NOC Expiry Attachment</label>
                  <input type="file" id="nocExpiryAttachment" name="noc_expiry_attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                </div>
              </div>
            </div>
          </div>

          <div class="row g-3 mt-2">
            <div class="col-md-6">
              <label class="form-label">Upload Proof</label>
              <input type="file" id="SalesReturnProof" class="form-control" name="proof" accept="image/png,image/jpg,image/jpeg,application/pdf">
            </div>
            <div class="col-md-6">
              <label class="form-label">Remarks</label>
              <textarea id="SalesReturnRemarks" class="form-control" name="remarks" rows="3"></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Close
          </button>
          <button type="button" id="saveSalesReturnButton" class="btn btn-primary">
            <i class="fas fa-save"></i> Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
var csrfToken         = '<?php echo e(csrf_token()); ?>';
var incidentDataUrl   = "<?php echo e(route('package.incidentData', ':id')); ?>";
var incidentSaveUrl   = "<?php echo e(route('package.incidentSave')); ?>";
var refundViewUrl     = "<?php echo e(route('packages.refund-sales-view')); ?>";
var replacementViewUrl= "<?php echo e(route('packages.replacement-sales-view')); ?>";
var saveSalesReturnUrl= "<?php echo e(route('packages.saveSalesReturn')); ?>";

function openDropdown(packageId, buttonElement, packageName){
  $('.dropdown-container').hide();
  $('#fullscreenOverlay').fadeIn();
  const dropdownContainer = $(`#dropdownContainer-${packageId}`);
  dropdownContainer.find('.package-name').text(packageName || '');
  dropdownContainer.css({ display: 'block', opacity: 0 });
  dropdownContainer.animate({ opacity: 1 }, 300);
}

function closeAllDropdowns(){
  $('.dropdown-container').fadeOut();
  $('#fullscreenOverlay').fadeOut();
}

function handleActionChange(selectEl){
  const action        = selectEl.value;
  const candidateId   = selectEl.dataset.candidateId;
  const cnNumber      = selectEl.dataset.cn || '';
  const candidateName = selectEl.dataset.candidateName || '';
  const passportNo    = selectEl.dataset.passport || '';

  if (!action || !candidateId) {
    return;
  }

  if (action === 'incident') {
    closeAllDropdowns();
    openIncidentModal(candidateId, cnNumber, candidateName, passportNo);
  } else if (action === 'sales_return') {
    closeAllDropdowns();
    openSalesReturn(candidateId, cnNumber, candidateName, passportNo);
  }

  selectEl.value = '';
}

function confirmDelete(packageId){
  Swal.fire({
    title: 'Are you sure?',
    text: 'This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#dc3545',
    confirmButtonText: 'Yes, delete it',
    cancelButtonText: 'No, cancel'
  }).then((result) => {
    if(result.isConfirmed){
      document.getElementById(`delete-form-${packageId}`).submit();
    }
  });
}

function allowOnlyNumbers(selector){
  $(selector).on('input', function(){
    const sanitized = $(this).val().replace(/[^0-9]/g, '');
    $(this).val(sanitized);
  });
}

allowOnlyNumbers('#officeTotalAmount');
allowOnlyNumbers('#officeReceivedAmount');

$('#officeTotalAmount, #officeReceivedAmount').on('input', function(){
  const total    = parseFloat($('#officeTotalAmount').val()) || 0;
  const received = parseFloat($('#officeReceivedAmount').val()) || 0;

  if (total < 0) {
    toastr.error('Total amount cannot be negative.');
    $('#officeTotalAmount').val('0');
    return;
  }
  if (received < 0) {
    toastr.error('Received amount cannot be negative.');
    $('#officeReceivedAmount').val('0');
    return;
  }
  if (received > total) {
    toastr.error('Received amount cannot exceed the total amount.');
    $('#officeReceivedAmount').val('');
    $('#officeRemainingAmount').val('');
    return;
  }

  $('#officeRemainingAmount').val((total - received).toFixed(2));
});

$('#officePaymentProof').on('change', function(){
  const fileExt = $(this).val().split('.').pop().toLowerCase();
  const allowed = ['png','jpeg','jpg','pdf'];
  if (!allowed.includes(fileExt)) {
    toastr.error('Only PNG, JPEG, JPG, and PDF files are allowed.');
    $(this).val('');
  }
});

allowOnlyNumbers('#govtTotalAmount');
allowOnlyNumbers('#govtReceivedAmount');
allowOnlyNumbers('#govtRemainingAmount');
allowOnlyNumbers('#govtVatAmount');

$('#govtPaymentProof').on('change', function(){
  const fileExt = $(this).val().split('.').pop().toLowerCase();
  const allowed = ['png','jpeg','jpg','pdf'];
  if (!allowed.includes(fileExt)) {
    toastr.error('Only PNG, JPEG, JPG, and PDF files are allowed.');
    $(this).val('');
  }
});

$('#govtTotalAmount, #govtReceivedAmount, #govtVatAmount').on('input', function(){
  const total    = parseFloat($('#govtTotalAmount').val()) || 0;
  const received = parseFloat($('#govtReceivedAmount').val()) || 0;
  let vat        = parseFloat($('#govtVatAmount').val()) || 0;

  if (total < 0) {
    toastr.error('Total amount cannot be negative.');
    $('#govtTotalAmount').val('0');
  }
  if (received < 0) {
    toastr.error('Received amount cannot be negative.');
    $('#govtReceivedAmount').val('0');
  }
  if (received > total) {
    toastr.error('Received amount cannot exceed the total amount.');
    $('#govtReceivedAmount').val('');
    $('#govtRemainingAmount').val('');
    $('#govtNetAmount').val('');
    return;
  }

  const remaining = total - received;
  $('#govtRemainingAmount').val(remaining.toFixed(2));

  if (vat < 0) {
    toastr.error('VAT amount cannot be negative.');
    vat = 0;
    $('#govtVatAmount').val('0');
  }

  const netTotal = total + vat;
  $('#govtNetAmount').val(netTotal.toFixed(2));
});

function validateAgreementForm(){
  const pkg           = $('#Package').val();
  const client        = $('#clientDropdown').val();
  const cand          = $('#selectedModalcandidateName').val().trim();
  const visa          = $('#VisaType').val();
  const officeTotal   = parseFloat($('#officeTotalAmount').val());
  const officeReceived= parseFloat($('#officeReceivedAmount').val());
  const officeProof   = $('#officePaymentProof').val();
  const salary        = parseFloat($('#agreedSalary').val());

  if (!pkg) {
    toastr.error('Please select a package.');
    return false;
  }
  if (!client) {
    toastr.error('Please select a client.');
    return false;
  }
  if (!cand) {
    toastr.error('Candidate name is required.');
    return false;
  }
  if (!visa) {
    toastr.error('Please select a visa type.');
    return false;
  }
  if (isNaN(officeTotal) || officeTotal <= 0) {
    toastr.error('Office total amount must be greater than zero.');
    return false;
  }
  if (officeReceived < 0) {
    toastr.error('Received amount cannot be negative.');
    return false;
  }
  if (officeReceived > 0 && !officeProof) {
    toastr.error('Payment proof is required when the received amount is greater than 0.');
    return false;
  }
  if (isNaN(salary) || salary < 1200) {
    toastr.error('Agreed salary must be at least 1200.');
    return false;
  }

  return true;
}

$('#saveChanges').on('click', function(e){
  e.preventDefault();
  if (!validateAgreementForm()) {
    return;
  }

  const btn = $('#saveChanges');
  btn.prop('disabled', true);

  const formData = new FormData();
  formData.append('candidate_id', $('#selectedModalcandidateId').val());
  formData.append('candidate_name', $('#selectedModalcandidateName').val());
  formData.append('reference_of_candidate', $('#selectedModalreferenceNo').val());
  formData.append('ref_no_in_of_previous', $('#selectedModalrefNo').val());
  formData.append('package', $('#Package').val());
  formData.append('client_id', $('#clientDropdown').val());
  formData.append('payment_method', $('#officePaymentMethod').val());
  formData.append('total_amount', $('#officeTotalAmount').val());
  formData.append('received_amount', $('#officeReceivedAmount').val());
  formData.append('remaining_amount', $('#officeRemainingAmount').val());

  if ($('#officePaymentProof')[0] && $('#officePaymentProof')[0].files[0]) {
    formData.append('payment_proof', $('#officePaymentProof')[0].files[0]);
  }

  formData.append('agreement_type', $('#agreementType').val());
  formData.append('contract_duration', $('#contractDuration').val());
  formData.append('salary', $('#agreedSalary').val());
  formData.append('foreign_partner', $('#selectedModalforeignPartner').val());
  formData.append('nationality', $('#selectedModalcandiateNationality').val());
  formData.append('passport_no', $('#selectedModalcandidatePassportNumber').val());
  formData.append('passport_expiry_date', $('#selectedModalcandidatePassportExpiry').val());
  formData.append('date_of_birth', $('#selectedModalcandidateDOB').val());
  formData.append('visa_type', $('#VisaType').val());
  formData.append('candidate_type', 'package');
  formData.append('trial_start_date', $('#trialStartDate').val());
  formData.append('trial_end_date', $('#trialEndDate').val());
  formData.append('number_of_days', $('#number_of_days').val());
  formData.append('office_notes', $('#officePaymentNotes').val());

  const govtTotal    = parseFloat($('#govtTotalAmount').val()) || 0;
  const govtReceived = parseFloat($('#govtReceivedAmount').val()) || 0;

  if (govtTotal > 0 || govtReceived > 0) {
    formData.append('govt_total_amount', $('#govtTotalAmount').val());
    formData.append('govt_received_amount', $('#govtReceivedAmount').val());
    formData.append('govt_remaining_amount', $('#govtRemainingAmount').val());
    formData.append('govt_vat_amount', $('#govtVatAmount').val());
    formData.append('govt_net_amount', $('#govtNetAmount').val());
    formData.append('govt_payment_method', $('#govtPaymentMethod').val());
    formData.append('govt_payment_notes', $('#govtPaymentNotes').val());
    formData.append('govt_service_name', $('#govtServiceSelect').val());

    if ($('#govtPaymentProof')[0] && $('#govtPaymentProof')[0].files[0]) {
      formData.append('govt_payment_proof', $('#govtPaymentProof')[0].files[0]);
    }
  }

  if ($('#medicalCertificate')[0] && $('#medicalCertificate')[0].files[0]) {
    formData.append('medical_certificate', $('#medicalCertificate')[0].files[0]);
  }

  $.ajax({
    url: '<?php echo e(route("agreements.insideagreement")); ?>',
    type: 'POST',
    headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
    data: formData,
    processData: false,
    contentType: false,
    success: function(response){
      btn.prop('disabled', false);
      if (response.status === 'success') {
        toastr.success(response.message);
        $('#agreement_form')[0].reset();
        $('#TrialModal').modal('hide');
        setTimeout(() => location.reload(), 2000);
      } else {
        toastr.error(response.message);
      }
    },
    error: function(xhr){
      btn.prop('disabled', false);
      const resp = xhr.responseJSON;
      if (resp && resp.errors) {
        Object.entries(resp.errors).forEach(([key, errs]) =>
          errs.forEach(err => toastr.error(`${key}: ${err}`))
        );
      } else if (resp && resp.message) {
        toastr.error(resp.message);
      } else {
        toastr.error('An unexpected error occurred.');
      }
    }
  });
});

$("#trialEndDate").on("change", function(){
  const start = new Date($("#trialStartDate").val());
  const end   = new Date($("#trialEndDate").val());
  let days    = 0;

  if (!isNaN(start.getTime()) && !isNaN(end.getTime()) && end >= start) {
    days = Math.ceil((end - start)/(1000*60*60*24));
  }
  $("#number_of_days").val(days);
});

$('#agreedSalary').on('input keydown', function(e){
  const key = e.key;
  const val = $(this).val();

  if (!/^[0-9.]$/.test(key) && e.keyCode !== 8 && e.keyCode !== 46) {
    e.preventDefault();
  }
  if (key === '.' && val.includes('.')) {
    e.preventDefault();
  }
});

$('#agreedSalary').on('blur', function(){
  const salaryVal = parseFloat($(this).val());
  if (isNaN(salaryVal) || salaryVal < 1200) {
    toastr.error('The agreed salary must be at least 1200.');
    $(this).val('');
    $(this).focus();
  }
});

function openIncidentModal(candidateId, cnNumber, candidateName, passportNo) {
  $('#incident_trial_id').val('');
  $('#incident_package_id').val(candidateId || '');
  $('#incident_candidate_id').val(candidateId || '');
  $('#incident_cn_number').val(cnNumber || '');
  $('#incident_candidate_name').val(candidateName || '');
  $('#incident_passport_no').val(passportNo || '');
  $('#incident_type').val('');
  $('#incident_date').val('');
  $('#incident_comments').val('');
  $('#incident_proof').val('');
  $('#incident_scope').val('package');
  $('#incident_type').removeClass('is-invalid');
  $('#incident_date').removeClass('is-invalid');
  $('#incident_type').siblings('.invalid-feedback').text('');
  $('#incident_date').siblings('.invalid-feedback').text('');

  $.ajax({
    url: incidentDataUrl.replace(':id', candidateId),
    type: "GET",
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: function(response) {
      if (response) {
        $('#incident_candidate_id').val(response.candidate_id || candidateId || '');
        $('#incident_package_id').val(response.package_id || candidateId || '');
        $('#incident_cn_number').val(response.cn_number || cnNumber || '');
        $('#incident_candidate_name').val(response.candidate_name || candidateName || '');
        $('#incident_passport_no').val(response.passport_no || passportNo || '');
        $('#incident_type').val(response.incident_type || '');
        $('#incident_date').val(response.incident_date || '');
        $('#incident_comments').val(response.comments || '');
        $('#incident_scope').val(response.type || 'package');
      }
      $('#incidentModal').modal('show');
    },
    error: function() {
      toastr.error('Failed to load incident data. Please try again.');
      $('#incidentModal').modal('show');
    }
  });
}

$('#incident_proof').on('change', function(){
  const fileExt = $(this).val().split('.').pop().toLowerCase();
  const allowed = ['png','jpeg','jpg','pdf'];
  if (!allowed.includes(fileExt)) {
    toastr.error('Only PNG, JPEG, JPG, and PDF files are allowed for incident proof.');
    $(this).val('');
  }
});

function saveIncidentData() {
  const form    = document.getElementById('incidentForm');
  const formData= new FormData(form);

  if (!formData.get('type')) {
    formData.set('type', 'package');
  }

  $('#incident_type').removeClass('is-invalid');
  $('#incident_date').removeClass('is-invalid');
  $('#incident_type').siblings('.invalid-feedback').text('');
  $('#incident_date').siblings('.invalid-feedback').text('');

  $.ajax({
    url: incidentSaveUrl,
    type: "POST",
    headers: { 'X-CSRF-TOKEN': csrfToken },
    data: formData,
    processData: false,
    contentType: false,
    success: function(res) {
      if (res.success) {
        toastr.success(res.message || 'Incident saved successfully.');
        $('#incidentModal').modal('hide');
        setTimeout(function(){ location.reload(); }, 800);
      } else {
        toastr.error(res.message || 'Failed to save incident.');
      }
    },
    error: function(xhr) {
      const res = xhr.responseJSON;
      if (res && res.errors) {
        if (res.errors.incident_type && res.errors.incident_type.length) {
          $('#incident_type').addClass('is-invalid');
          $('#incident_type').siblings('.invalid-feedback').text(res.errors.incident_type[0]);
        }
        if (res.errors.incident_date && res.errors.incident_date.length) {
          $('#incident_date').addClass('is-invalid');
          $('#incident_date').siblings('.invalid-feedback').text(res.errors.incident_date[0]);
        }
        Object.values(res.errors).forEach(function(errArr){
          errArr.forEach(function(msg){ toastr.error(msg); });
        });
      } else if (res && res.message) {
        toastr.error(res.message);
      } else {
        toastr.error('Failed to save incident. Please check your inputs and try again.');
      }
    }
  });
}

function _num(v){
  const x = parseFloat((v || '').toString().replace(/,/g, ''));
  return isNaN(x) ? 0 : x;
}
function _d(s){
  if (!s) return null;
  const d = new Date(s + 'T00:00:00Z');
  return isNaN(d) ? null : d;
}
function _days(a, b){
  if (!a || !b) return 0;
  const ms = b.getTime() - a.getTime();
  return ms <= 0 ? 0 : Math.floor(ms / 86400000);
}
function _isFriday(d){
  return d && d.getUTCDay && d.getUTCDay() === 5;
}

function applyDateGuardsSales(kind){
  if (!window.jQuery) return;
  const $ = jQuery;
  const $refundDate = $('#DecisionContentSales .js-available-date');
  const $replaceDate = $('#DecisionContentSales [name="replacement_due_date"]');
  const t = new Date();
  const today = new Date(Date.UTC(t.getFullYear(), t.getMonth(), t.getDate()));

  if (kind === 'refund' && $refundDate.length) {
    const min = new Date(today.getTime() + 7 * 86400000);
    $refundDate.attr('min', min.toISOString().slice(0, 10))
      .off('change.guard')
      .on('change.guard', function(){
        const d = _d(this.value);
        if (!d) {
          this.value = '';
          return;
        }
        if (d < min || _isFriday(d)) {
          this.value = '';
          if (window.toastr) toastr.error('Refund Available Date must be after 7 days and not Friday');
          else alert('Refund Available Date must be after 7 days and not Friday');
        }
      });
  }

  if (kind === 'replacement' && $replaceDate.length) {
    $replaceDate.off('change.guard').on('change.guard', function(){
      const d = _d(this.value);
      if (!d || _isFriday(d)) {
        this.value = '';
        if (window.toastr) toastr.error('Replacement Available Date cannot be Friday');
        else alert('Replacement Available Date cannot be Friday');
      }
    });
  }
}

function baseBalanceSales(){
  if (!window.jQuery) return 0;
  const $ = jQuery;
  return _num($('#DecisionContentSales .js-balance').val());
}

function computePenaltySales(){
  if (!window.jQuery) return 0;
  const $ = jQuery;
  const $c = $('#DecisionContentSales');
  const type = ($c.find('.js-penalty-type').val() || 'Visa').toString();
  const expiry = _d($c.find('.js-expiry-date').val());
  const ret = _d($('.js-sales-return-date').val());
  const rate = _num($c.find('.js-penalty-rate').val());
  let days = 0;

  if (expiry && ret) {
    if (type === 'Visa') {
      days = _days(expiry, ret);
    } else {
      const raw = _days(expiry, ret);
      days = raw > 90 ? (raw - 90) : 0;
    }
  }
  if (days < 0) days = 0;
  const amount = Math.max(0, rate * days);
  $c.find('.js-penalty-days').val(days);
  $c.find('.js-penalty-amount').val(amount.toFixed(2));
  return amount;
}

function salaryDeductionSales(){
  if (!window.jQuery) return 0;
  const $ = jQuery;
  const $c = $('#DecisionContentSales');
  const who = ($c.find('.js-salary-type').val() || 'Sponsor').toString();
  if (who !== 'Sponsor') return 0;
  const salary = _num($c.find('.js-salary-amount').val());
  const days   = _num($c.find('.js-days-exist').val());
  if (salary <= 0 || days <= 0) return 0;
  const perDay = salary / 30;
  const deduct = perDay * days;
  return Math.max(0, deduct);
}

function ensureHiddenSales(name){
  if (!window.jQuery) return null;
  const $ = jQuery;
  const $form = $('#SalesReturnModalForm');
  let $f = $form.find('input[name="'+name+'"]');
  if (!$f.length) {
    $f = $('<input type="hidden">').attr('name', name);
    $form.append($f);
  }
  return $f;
}

function recalcFinalSales(){
  if (!window.jQuery) return;
  const $ = jQuery;
  const $c = $('#DecisionContentSales');
  const penalty = computePenaltySales();
  const salary  = salaryDeductionSales();
  $c.find('.js-salary-deduct').val(salary.toFixed(2));
  const finalVal = Math.max(0, baseBalanceSales() - penalty - salary);
  $c.find('.js-final').val(finalVal.toFixed(2));
  const action = $('input[name="action_type"]:checked').val();
  if (action === 'refund') {
    const f1 = ensureHiddenSales('refund_final_balance');
    const f2 = ensureHiddenSales('replacement_final_balance');
    if (f1) f1.val(finalVal.toFixed(2));
    if (f2) f2.val('');
  } else {
    const g1 = ensureHiddenSales('replacement_final_balance');
    const g2 = ensureHiddenSales('refund_final_balance');
    if (g1) g1.val(finalVal.toFixed(2));
    if (g2) g2.val('');
  }
}

function bindRecalcHandlersSales(){
  if (!window.jQuery) return;
  const $ = jQuery;
  $('#DecisionContentSales')
    .off('input change.recalc')
    .on('input change.recalc', '.js-penalty-type,.js-expiry-date,.js-penalty-rate,.js-balance,.js-salary-type,.js-salary-amount,.js-days-exist', recalcFinalSales);
  $('.js-sales-return-date')
    .off('change.recalc')
    .on('change.recalc', recalcFinalSales);
}

function loadDecisionPartialSales(kind){
  if (!window.jQuery) return;
  const $ = jQuery;
  const cid      = $('#SalesReturnModalcandidateId').val();
  const passport = $('#SalesReturnModalpassportNo').val() || '';
  const url      = kind === 'refund' ? refundViewUrl : replacementViewUrl;
  const query    = $.param({ candidate_id: cid, passport_no: passport });

  $('#DecisionContentSales').html('');
  $('#DecisionContentSales').load(url + '?' + query, function(){
    applyDateGuardsSales(kind);
    bindRecalcHandlersSales();
    recalcFinalSales();
  });
}

function openSalesReturn(candidateId, cnNumber, candidateName, passportNo){
  if (!window.jQuery) return;
  const $ = jQuery;

  $('#SalesReturnModaltrial_id').val('');
  $('#SalesReturnModalcandidateId').val(candidateId || '');
  $('#SalesReturnModalcandidateName').val(candidateName || '');
  $('#SalesReturnModalclientName').val('');
  $('#SalesReturnModalpassportNo').val(passportNo || '');
  $('#SalesReturnProof').val('');
  $('#SalesReturnRemarks').val('');
  $('#DecisionContentSales').html('');
  $('#nocExpirySelect').val('');
  $('.noc-extra').addClass('d-none');

  $.ajax({
    url: incidentDataUrl.replace(':id', candidateId),
    type: 'GET',
    headers: { 'X-CSRF-TOKEN': csrfToken },
    success: function(resp){
      if (resp) {
        $('#SalesReturnModalcandidateName').val(resp.candidate_name || resp.candidateName || candidateName || '');
        $('#SalesReturnModalclientName').val(resp.client_name || resp.clientName || resp.employer_name || '');
        $('#SalesReturnModalpassportNo').val(resp.passport_no || passportNo || '');
      }
    },
    complete: function(){
      $('input[name="action_type"][value="refund"]').prop('checked', true);
      loadDecisionPartialSales('refund');
      $('#SalesReturnModal').modal('show');
    },
    error: function(){
      toastr.error('Failed to load sales return data.');
      $('input[name="action_type"][value="refund"]').prop('checked', true);
      loadDecisionPartialSales('refund');
      $('#SalesReturnModal').modal('show');
    }
  });
}

if (window.jQuery) {
  const $ = jQuery;

  $(document).on('change', '.js-sales-decision', function(){
    const v = $(this).val();
    if (v === 'refund' || v === 'replacement') {
      loadDecisionPartialSales(v);
    }
  });

  $('#nocExpirySelect').on('change', function(){
    if ($(this).val() === 'Yes') {
      $('.noc-extra').removeClass('d-none');
    } else {
      $('.noc-extra').addClass('d-none');
      $('#nocExpiryDate').val('');
      $('#nocExpiryAttachment').val('');
    }
  });

  $('#saveSalesReturnButton').on('click', function(){
    const action = $('input[name="action_type"]:checked').val();
    if (!action) {
      toastr.error('Please choose Refund or Replacement.');
      return;
    }

    recalcFinalSales();
    const fd = new FormData(document.getElementById('SalesReturnModalForm'));
    fd.set('action_type', action);
    fd.set('passport_no', $('#SalesReturnModalpassportNo').val() || '');

    const finalVal = $('#DecisionContentSales .js-final').val() || '0';

    if (action === 'refund') {
      fd.set('refund_final_balance', finalVal);
      fd.delete('replacement_final_balance');
    } else {
      fd.set('replacement_final_balance', finalVal);
      fd.delete('refund_final_balance');
    }

    const nocStatus = $('#nocExpirySelect').val() || '';
    fd.set('noc_expiry_status', nocStatus);
    if (nocStatus !== 'Yes') {
      fd.delete('noc_expiry_date');
      fd.delete('noc_expiry_attachment');
    }

    fetch(saveSalesReturnUrl, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken },
      body: fd
    })
      .then(r => r.json())
      .then(d => {
        if (d.success) {
          toastr.success(d.message || 'Sales return saved.');
          $('#SalesReturnModal').modal('hide');
          setTimeout(function(){ location.reload(); }, 1200);
        } else {
          toastr.error(d.message || 'Failed to save sales return.');
        }
      })
      .catch(function(){
        toastr.error('Request failed.');
      });
  });
}
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/package/partials/contracted_table.blade.php ENDPATH**/ ?>