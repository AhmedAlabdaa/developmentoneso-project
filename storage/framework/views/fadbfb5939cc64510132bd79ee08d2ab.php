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
  .muted-text {
    color: #6c757d;
    font-size: 12px;
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
  .fullscreen-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1049;
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
  .employee-name {
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
  .pagination-controls {
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
    align-items: center;
    gap: 20px;
  }
  .pagination-controls i {
    font-size: 12px;
    cursor: pointer;
    color: #343a40;
  }
  .pagination-controls i.disabled {
    color: #ccc;
    cursor: not-allowed;
  }
</style>
<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>CN#</th>
        <th>Full Name</th>
        <th>Sales Name</th>
        <th>Status</th>
        <th>Nationality</th>
        <th>Partner</th>
        <th>CL#</th>
        <th>Client Name</th>
        <th>Current Visa</th>
        <th>Arrived Date</th>
        <th>Incident Type</th>
        <th>Incident Date</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $sales      = optional($package->createdByUser);
          $client     = optional($package->client);
          $incident   = optional($package->incident);
          $statusBtn  = '<button class="btn btn-dark btn-sm"><i class="fas fa-exclamation-triangle"></i> Incident</button>';
        ?>
        <tr>
          <td><?php echo e(strtoupper($package->CN_Number)); ?></td>
          <td><?php echo e(strtoupper($package->candidate_name)); ?></td>
          <td><?php echo e(strtoupper($sales->first_name.' '.$sales->last_name)); ?></td>
          <td><?php echo $statusBtn; ?></td>
          <td><?php echo e(strtoupper($package->nationality)); ?></td>
          <td><?php echo e(strtoupper($package->foreign_partner)); ?></td>
          <td><?php echo e(strtoupper($client->CL_Number)); ?></td>
          <td><?php echo e(strtoupper($client->first_name.' '.$client->last_name)); ?></td>
          <td><?php echo e(strtoupper($package->visa_type)); ?></td>
          <td>
            <?php echo e($package->arrived_date
                ? \Carbon\Carbon::parse($package->arrived_date)->format('d M Y')
                : '-'); ?>

          </td>
          <td><?php echo e(strtoupper($incident->incident_type ?: '-')); ?></td>
          <td>
            <?php echo e($incident->incident_date
                ? \Carbon\Carbon::parse($incident->incident_date)->format('d M Y')
                : '-'); ?>

          </td>
          <td><?php echo e($incident->comments ?: '-'); ?></td>
          <td class="actions">
            <a href="javascript:void(0);" class="btn btn-primary btn-icon-only"
               title="Change Status"
               onclick="openDropdown('<?php echo e($package->id); ?>', this, '<?php echo e(strtoupper($package->candidate_name)); ?>')">
              <i class="fas fa-train"></i>
            </a>
            <div class="fullscreen-overlay" onclick="closeAllDropdowns()"></div>
            <div class="dropdown-container" id="dropdownContainer-<?php echo e($package->id); ?>" style="display:none;">
              <div class="close-icon" onclick="closeAllDropdowns()">
                <i class="fas fa-times-circle"></i>
              </div>
              <div class="dropdown-header">
                <div class="header-icon"><i class="fas fa-info-circle"></i></div>
                <p>Change status for</p>
                <p><strong><?php echo e(strtoupper($package->candidate_name)); ?></strong>?</p>
              </div>
              <select class="form-control status-dropdown"
                      onchange="updateStatus(this, <?php echo e($package->id); ?>)">
                <option disabled selected>Incident</option>
                <option value="Sales Return">Sales Return</option>
              </select>
            </div>
            <?php if(Auth::user()->role==='Admin'): ?>
              <form action="<?php echo e(route('packages.destroy',$package->id)); ?>"
                    method="POST" style="display:inline;" id="delete-form-<?php echo e($package->id); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="button" class="btn btn-danger btn-icon-only"
                        onclick="confirmDelete('<?php echo e($package->id); ?>')">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="14" class="text-center">No results found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <th>CN#</th>
        <th>Full Name</th>
        <th>Sales Name</th>
        <th>Status</th>
        <th>Nationality</th>
        <th>Partner</th>
        <th>CL#</th>
        <th>Client Name</th>
        <th>Current Visa</th>
        <th>Arrived Date</th>
        <th>Incident Type</th>
        <th>Incident Date</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>
</div>

<nav aria-label="Page navigation">
  <div class="pagination-container">
    <span class="muted-text">
      Showing <?php echo e($packages->firstItem()); ?> to <?php echo e($packages->lastItem()); ?> of <?php echo e($packages->total()); ?> results
    </span>
    <ul class="pagination justify-content-center">
      <?php echo e($packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

    </ul>
  </div>
</nav>

<div class="modal fade custom-modal" id="ConfirmedModal" tabindex="-1" aria-labelledby="ConfirmedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ConfirmedModalLabel">
          <i class="fa-solid fa-circle-check text-light"></i> Trial Confirmed
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="ConfirmedModalForm" enctype="multipart/form-data" method="POST">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="mb-3">
            <p>
              <label><i class="fas fa-building"></i> Candidate Name:</label>
              <input type="text" id="ConfirmedModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="ConfirmedModalcandidateId" name="candidate_id" class="form-control" readonly>
              <input type="hidden" name="trial_id" id="trial_id">
            </p>
            <p>
              <label><i class="fas fa-building"></i> Employer Name:</label>
              <input type="text" name="employer_name" id="ConfirmedModalclientName" class="form-control" readonly>
            </p>
          </div>

          <div class="mb-4" id="InvoiceData"></div>

          <div class="mb-3">
            <label for="ConfirmedModalDate" class="form-label">
              <i class="fas fa-calendar-day"></i> Confirmed Date
            </label>
            <input type="date" id="ConfirmedModalDate" class="form-control" name="confirmed_date" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>">
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="ConfirmedModalremainingAmountWithVat" class="form-label">
                <i class="fas fa-balance-scale"></i> Remaining Amount
              </label>
              <input type="text" id="ConfirmedModalremainingAmountWithVat" name="remaining_amount" class="form-control" value="0" readonly>
            </div>
            <div class="col-md-6">
              <label for="ConfirmedModalreceivedAmount" class="form-label">
                <i class="fas fa-money-bill-wave"></i> Received Amount *
              </label>
              <input type="number" id="ConfirmedModalreceivedAmount" name="received_amount" class="form-control" min="0" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="paymentMethodForConfirmed" class="form-label">
              <i class="fas fa-credit-card"></i> Payment Method
            </label>
            <select id="paymentMethodForConfirmed" name="payment_method" class="form-control">
              <option value="" disabled selected>Select Payment Method</option>
              <option value="Bank Transfer ADIB">Bank Transfer ADIB</option>
              <option value="Bank Transfer ADCB">Bank Transfer ADCB</option>
              <option value="POS ADCB">POS ADCB</option>
              <option value="POS ADIB">POS ADIB</option>
              <option value="Cash">Cash</option>
              <option value="Cheque">Cheque</option>
              <option value="Replacement">Replacement</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="ConfirmedModalpaymentProof" class="form-label">
              <i class="fas fa-upload"></i> Upload Payment Proof
            </label>
            <input type="file" id="ConfirmedModalpaymentProof" class="form-control" name="payment_proof" accept="image/png, image/jpg, image/jpeg, application/pdf">
          </div>

          <div class="mb-3">
            <label class="form-label">
              <i class="fas fa-info-circle"></i> Important Notes
            </label>
            <ul class="list-group">
              <li class="list-group-item">1 - Tax Invoice for final payment has done?</li>
              <li class="list-group-item">2 - Contract has signed?</li>
              <li class="list-group-item">3 - For change status, transaction must be done today.</li>
            </ul>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Close
          </button>
          <button type="button" id="saveConfirmedModalButton" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade custom-modal" id="ChangeStatusModal" tabindex="-1" aria-labelledby="ChangeStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ChangeStatusModalLabel">
          <i class="fa-solid fa-circle-check text-info" style="color: #fff !important;"></i> Change Status
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data" id="ChangeStatusModalForm">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="mb-3">
            <p>
              <strong><i class="fas fa-building"></i> Candidate Name:</strong>
              <input type="text" id="ChangeStatusModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="ChangeStatusModalcandidateId" name="candidate_id" class="form-control" readonly>
              <input type="hidden" name="trial_id" id="ChangeStatusModaltrial_id">
            </p>
            <p>
              <strong><i class="fas fa-building"></i> Employer Name:</strong>
              <input type="text" name="employer_name" id="ChangeStatusModalclientName" class="form-control" readonly>
            </p>
          </div>
          <div class="mb-3">
            <label for="ChangeStatusModalDate" class="form-label">
              <i class="fas fa-calendar-day"></i> Change Status Date
            </label>
            <input type="date" id="ChangeStatusModalDate" class="form-control" name="change_status_date" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>">
          </div>
          <div class="mb-3">
            <label for="ChangeStatusModalproof" class="form-label">
              Change Status Proof (Include Visa + WC)
            </label>
            <input type="file" id="ChangeStatusModalproof" class="form-control" name="change_status_proof" accept="image/png, image/jpg, image/jpeg, application/pdf">
          </div>
          <div class="mb-3">
            <label for="penaltyPaymentAmount" class="form-label">
              Penality Payment Amount
            </label>
            <input type="text" id="penaltyPaymentAmount" class="form-control" name="penalty_payment_amount" placeholder="Enter penalty amount if any">
          </div>
          <div class="mb-3">
            <label for="penaltyPaymentProof" class="form-label">
              Penality Payment Amount Proof (If Overstay)
            </label>
            <input type="file" id="penaltyPaymentProof" class="form-control" name="penalty_payment_proof" accept="image/png, image/jpg, image/jpeg, application/pdf">
          </div>
          <div class="mb-3">
            <label for="penaltyPaidBy" class="form-label">
              Penality Amount Paid By
            </label>
            <select id="penaltyPaidBy" name="penalty_paid_by" class="form-select" style="font-size: 12px;">
              <option value="" disabled selected>Select who paid the penalty</option>
              <option value="Customer">Customer</option>
              <option value="Office">Office</option>
              <option value="Candidate">Candidate</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="istirahaProof" class="form-label">
              Istiraha Proof
            </label>
            <input type="file" id="istirahaProof" class="form-control" name="istiraha_proof" accept="image/png, image/jpg, image/jpeg, application/pdf">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Close
          </button>
          <button type="button" id="saveChangeStatusModalButton" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade custom-modal" id="SalesReturnModal" tabindex="-1" aria-labelledby="SalesReturnModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="SalesReturnModalLabel">
          <i class="fa-solid fa-box-open text-info" style="color: #fff !important;"></i> Sales Return
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="SalesReturnModalForm" enctype="multipart/form-data" method="POST">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="mb-3">
            <p>
              <strong><i class="fas fa-building"></i> Candidate Name:</strong>
              <input type="text" id="SalesReturnModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="SalesReturnModalcandidateId" name="candidate_id" class="form-control" readonly>
              <input type="hidden" name="trial_id" id="SalesReturnModaltrial_id">
            </p>
            <p>
              <strong><i class="fas fa-building"></i> Employer Name:</strong>
              <input type="text" name="employer_name" id="SalesReturnModalclientName" class="form-control" readonly>
            </p>
          </div>
          <div class="mb-3">
            <label for="SalesReturnProof" class="form-label">
              <i class="fas fa-upload"></i> Upload Proof
            </label>
            <input type="file" id="SalesReturnProof" class="form-control" name="proof" accept="image/png, image/jpg, image/jpeg, application/pdf">
          </div>
          <div class="mb-3">
            <label for="SalesReturnRemarks" class="form-label">
              <i class="fas fa-comment"></i> Remarks
            </label>
            <textarea id="SalesReturnRemarks" class="form-control" name="remarks" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Close
          </button>
          <button type="button" id="saveSalesReturnButton" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade custom-modal" id="incidentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Incident Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="$('#incidentModal').modal('hide');"></button>
      </div>
      <div class="modal-body">
        <form id="incidentForm">
          <input type="hidden" name="candidate_id" id="incident_candidate_id" value="">
          <input type="hidden" name="cn_number" id="incident_cn_number" value="">
          <input type="hidden" name="type" id="type_of_stage" value="office">
          <div class="mb-3">
            <label for="incident_type">Incident Type</label>
            <select id="incident_type" name="incident_type" class="form-select" required>
              <option value="">Select Type</option>
              <option value="RUNAWAY">RUNAWAY</option>
              <option value="REPATRIATION">REPATRIATION</option>
              <option value="UNFIT">UNFIT</option>
              <option value="SICK">SICK</option>
              <option value="REFUSED">REFUSED</option>
              <option value="PSYCHIATRIC">PSYCHIATRIC</option>
              <option value="RESERVED">RESERVED</option>
              <option value="ABSCONDING">ABSCONDING</option>
              <option value="RELEASED">RELEASED</option>
              <option value="MOHRE COMPLAIN">MOHRE COMPLAIN</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="incident_date">Incident Date</label>
            <input type="date" id="incident_date" name="incident_date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="incident_comments">Comments</label>
            <textarea id="incident_comments" name="comments" class="form-control" required></textarea>
          </div>
          <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="$('#incidentModal').modal('hide');"><i class="fas fa-times me-1"></i> Close</button>
            <button type="button" id="saveIncidentBtn" class="btn btn-danger" onclick="saveIncidentData()"><i class="fas fa-save me-1"></i> Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  function openDropdown(candidateId, buttonElement, candidateName){
    $('.dropdown-container').hide();
    $('#fullscreenOverlay').fadeIn();
    const dropdownContainer = $(`#dropdownContainer-${candidateId}`);
    dropdownContainer.find('.employee-name').text(candidateName);
    dropdownContainer.css({ display: 'block', opacity: 0 });
    dropdownContainer.animate({ opacity: 1 }, 300);
  }
  function closeAllDropdowns(){
    $('.dropdown-container').fadeOut();
    $('#fullscreenOverlay').fadeOut();
  }
  function confirmDelete(candidateRefNo){
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
        document.getElementById(`delete-form-${candidateRefNo}`).submit();
      }
    });
  }
  function showPreloader(){
    const preloaderHTML = `
      <div id="preloader" class="preloader-container">
        <div class="preloader-content">
          <div class="spinner"></div>
          <p>Loading...</p>
        </div>
      </div>
    `;
    $('body').append(preloaderHTML);
    $('#preloader').css({
      position: 'fixed',
      top: '0',
      left: '0',
      width: '100%',
      height: '100%',
      backgroundColor: 'rgba(255, 255, 255, 0.8)',
      display: 'flex',
      justifyContent: 'center',
      alignItems: 'center',
      zIndex: '1050'
    });
    $('.preloader-content .spinner').css({
      width: '50px',
      height: '50px',
      border: '6px solid rgba(0, 0, 0, 0.1)',
      borderTopColor: '#007bff',
      borderRadius: '50%',
      animation: 'spin 1s linear infinite',
      marginBottom: '10px'
    });
    $('.preloader-content p').css({
      fontSize: '1rem',
      color: '#007bff',
      fontWeight: 'bold',
      textAlign: 'center'
    });
    const spinnerKeyframes = `
      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
    `;
    const styleTag = document.createElement('style');
    styleTag.textContent = spinnerKeyframes;
    document.head.appendChild(styleTag);
  }
  function hidePreloader(){
    $('#preloader').remove();
  }
  function trialChangeStatus(selectElement, trialId, candidateId, clientId) {
    const status = selectElement.value;
    Swal.fire({
      title: `Change to "${status}"`,
      text: `Are you sure you want to change the status to "${status}"?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#dc3545'
    }).then(({ isConfirmed }) => {
      if (!isConfirmed) return;
      if (status === 'Incident') {
        closeAllDropdowns();
        openIncidentModal(trialId, candidateId, clientId);
      } else {
        updateTrialStatus(status, trialId, candidateId, clientId);
      }
    });
  }

  function updateTrialStatus(status, trialId, candidateId, clientId){
    const csrfToken = '<?php echo e(csrf_token()); ?>';
    const updateStatusUrl = '<?php echo e(route("packages.updateTrialStatus")); ?>';
    showPreloader();
    const ajaxData = {
      trial_id: trialId,
      candidate_id: candidateId,
      client_id: clientId,
      status
    };
    $.ajax({
      url: updateStatusUrl,
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken },
      data: ajaxData,
      success: function(response){
        if(response.success){
          if(response.action === 'open_modal' && response.modal){
            const modalId = `#${response.modal}`;
            $(modalId).modal('show');
            fillModalFields(response.modal, response, trialId);
          } else {
            toastr.success(response.message || 'Status updated successfully!');
            setTimeout(() => location.reload(), 2000);
          }
        } else {
          toastr.error(response.message || 'Failed to update status. Please try again.');
        }
      },
      error: function(xhr){
        toastr.error(xhr.responseJSON?.message || 'An error occurred. Please try again.');
      },
      complete: function(){
        hidePreloader();
      }
    });
  }
  function fillModalFields(modalId, data, trialId) {
    const details = data.candidateDetails || {};
    if (modalId === 'ConfirmedModal') {
        $('#trial_id').val(trialId || '');
        $('#ConfirmedModalcandidateId').val(details.candidateId || '');
        $('#ConfirmedModalcandidateName').val(details.candidateName || '');
        $('#ConfirmedModalclientName').val(details.clientName || '');
        if (details.remainingAmountWithVat) {
          $('#ConfirmedModalremainingAmountWithVat').val(
            parseFloat(details.remainingAmountWithVat).toFixed(2)
          );
        }
        if (details.invoices && details.invoices.length > 0) {
          let invoiceRows = '';
          details.invoices.forEach(invoice => {
            const total = parseFloat(invoice.total_amount) || 0;
            const received = parseFloat(invoice.received_amount) || 0;
            const remaining = total - received;
            invoiceRows += `
              <tr>
                <td>${invoice.invoice_date}</td>
                <td>${total.toFixed(2)}</td>
                <td>${received.toFixed(2)}</td>
                <td>${remaining.toFixed(2)}</td>
                <td>
                  <a href="/invoices/${invoice.invoice_number}" target="_blank" class="btn btn-light btn-sm">
                    <i class="fas fa-external-link-alt"></i> ${invoice.invoice_number}
                  </a>
                </td>
              </tr>`;
          });
          $('#InvoiceData').html(`
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Total Amount</th>
                  <th>Received Amount</th>
                  <th>Remaining Amount</th>
                  <th>Invoice Reference #</th>
                </tr>
              </thead>
              <tbody>${invoiceRows}</tbody>
            </table>
          `);
        } else {
          $('#InvoiceData').html('<p class="text-danger">No invoices found.</p>');
        }
    }

    if (modalId === 'ChangeStatusModal') {
        $('#ChangeStatusModaltrial_id').val(trialId || '');
        $('#ChangeStatusModalcandidateId').val(details.candidateId || '');
        $('#ChangeStatusModalcandidateName').val(details.candidateName || '');
        $('#ChangeStatusModalclientName').val(details.clientName || '');
    }

    if (modalId === 'TrialReturnModal') {
        $('#TrialReturnModaltrial_id').val(trialId || '');
        $('#TrialReturnModalcandidateId').val(details.candidateId || '');
        $('#TrialReturnModalcandidateName').val(details.candidateName || '');
        $('#TrialReturnModalclientName').val(details.clientName || '');
    }

    if (modalId === 'SalesReturnModal') {
        $('#SalesReturnModaltrial_id').val(trialId || '');
        $('#SalesReturnModalcandidateId').val(details.candidateId || '');
        $('#SalesReturnModalcandidateName').val(details.candidateName || '');
        $('#SalesReturnModalclientName').val(details.clientName || '');
    }

    if (modalId === 'IncidentModal') {
        $('#IncidentModalcandidateId').val(details.candidateId || '');
        $('#IncidentModalcandidateName').val(details.candidateName || '');
        $('#IncidentModalclientName').val(details.clientName || '');
      }
    }

   $('#saveConfirmedModalButton').on('click', function() {
      const button = $(this);
      const form = $('#ConfirmedModalForm')[0];
      const formData = new FormData(form);
      const csrfToken = '<?php echo e(csrf_token()); ?>';
      let isValid = true;
      const requiredFields = [
        { id: '#ConfirmedModalclientName', message: 'Employer Name is required.' },
        { id: '#ConfirmedModalDate', message: 'Confirmed Date is required.' },
        { id: '#paymentMethodForConfirmed', message: 'Payment method is required.' }
      ];
      requiredFields.forEach(field => {
        if (!$(field.id).val().trim()) {
          isValid = false;
          toastr.error(field.message);
        }
      });
      if (!$('#ConfirmedModalpaymentProof')[0].files.length) {
        isValid = false;
        toastr.error('Payment proof is required.');
      }
      if (!isValid) return;
      button.prop('disabled', true);
      $.ajax({
        url: '<?php echo e(route("packages.saveTrialConfirmed")); ?>',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
            $('#ConfirmedModal').modal('hide');
            $('#ConfirmedModalForm')[0].reset();
            setTimeout(() => location.reload(), 2000);
          } else {
            toastr.error(response.message || 'Failed to save confirmed trial.');
          }
        },
        error: function(xhr) {
          if (xhr.responseJSON && xhr.responseJSON.errors) {
            Object.values(xhr.responseJSON.errors).forEach(errorMessages => {
              errorMessages.forEach(error => toastr.error(error));
            });
          } else if (xhr.responseJSON && xhr.responseJSON.message) {
            toastr.error(xhr.responseJSON.message);
          } else {
            toastr.error('An error occurred while saving the confirmed trial.');
          }
        },
        complete: function() {
          button.prop('disabled', false);
        }
      });
    });
  document.getElementById('saveChangeStatusModalButton').addEventListener('click', function(){
    const button = this;
    const form = document.getElementById('ChangeStatusModalForm');
    const formData = new FormData(form);
    const csrfToken = '<?php echo e(csrf_token()); ?>';
    button.disabled = true;
    fetch('<?php echo e(route("packages.updateChangeStatus")); ?>', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken },
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if(data.success){
          toastr.success(data.message);
          $('#ChangeStatusModal').modal('hide');
          setTimeout(() => location.reload(), 2000);
        } else {
          toastr.error(data.message || 'Failed to update status. Please try again.');
        }
      })
      .catch(() => toastr.error('An error occurred while updating the status. Please try again.'))
      .finally(() => button.disabled = false);
  });
  document.getElementById('saveTrialReturnButton').addEventListener('click', function(){
    const button = this;
    const form = document.getElementById('TrialReturnModalForm');
    const formData = new FormData(form);
    const csrfToken = '<?php echo e(csrf_token()); ?>';
    button.disabled = true;
    fetch('<?php echo e(route("packages.saveTrialReturn")); ?>', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken },
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if(data.success){
          toastr.success(data.message || 'Trial Return saved successfully.');
          $('#TrialReturnModal').modal('hide');
          setTimeout(() => location.reload(), 2000);
        } else {
          toastr.error(data.message || 'Failed to save Trial Return.');
        }
      })
      .catch(() => toastr.error('An error occurred while saving Trial Return.'))
      .finally(() => button.disabled = false);
  });
  document.getElementById('saveSalesReturnButton').addEventListener('click', function(){
    const button = this;
    const form = document.getElementById('SalesReturnModalForm');
    const formData = new FormData(form);
    const csrfToken = '<?php echo e(csrf_token()); ?>';
    button.disabled = true;
    fetch('<?php echo e(route("packages.saveSalesReturn")); ?>', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken },
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        if(data.success){
          toastr.success(data.message || 'Sales Return saved successfully.');
          $('#SalesReturnModal').modal('hide');
          setTimeout(() => location.reload(), 2000);
        } else {
          toastr.error(data.message || 'Failed to save Sales Return.');
        }
      })
      .catch(() => toastr.error('An error occurred while saving Sales Return.'))
      .finally(() => button.disabled = false);
  });
  document.getElementById('saveIncidentButton').addEventListener('click', function(){
    const button = this;
    const form = document.getElementById('IncidentModalForm');
    const formData = new FormData(form);
    const csrfToken = '<?php echo e(csrf_token()); ?>';
    button.disabled = true;
    fetch('<?php echo e(route("packages.saveReturnIncident")); ?>', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken },
      body: formData
    })
      .then(response => {
        if(!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        return response.json();
      })
      .then(data => {
        if(data.success){
          toastr.success(data.message || 'Incident saved successfully.');
          $('#IncidentModal').modal('hide');
          form.reset();
          setTimeout(() => location.reload(), 2000);
        } else {
          toastr.error(data.message || 'Failed to save Incident.');
        }
      })
      .catch(() => toastr.error('An error occurred while saving the Incident. Please check your inputs.'))
      .finally(() => button.disabled = false);
  });

  function openIncidentModal(trialId, candidateId, clientId) {
    $('#incident_candidate_id').val(candidateId);
    $('#incident_type').val('');
    $('#incident_date').val('');
    $('#incident_comments').val('');
    $.ajax({
      url: "<?php echo e(route('package.incidentData', ':id')); ?>".replace(':id', trialId),
      type: "GET",
      headers: { 'X-CSRF-TOKEN': csrfToken },
      success: function(response) {
        $('#incident_candidate_id').val(candidateId);
        $('#incident_cn_number').val(response.cn_number);
        $('#incidentModal').modal('show');
      },
      error: function() {
        toastr.error('Failed to load incident data. Please try again.');
      }
    });
  }

  function saveIncidentData() {
    const formData = new FormData(document.getElementById('incidentForm'));
    $.ajax({
      url: "<?php echo e(route('package.incidentSave')); ?>",
      type: "POST",
      headers: { 'X-CSRF-TOKEN': csrfToken },
      data: formData,
      processData: false,
      contentType: false,
      success: function() {
        toastr.success('Incident saved successfully!');
        $('#incidentModal').modal('hide');
        location.reload();
      },
      error: function() {
        toastr.error('Failed to save incident. Please check your inputs and try again.');
      }
    });
  }
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/partials/change_status_table.blade.php ENDPATH**/ ?>