<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
  .muted-text{color:#6c757d;font-size:12px}
  .table-container{width:100%;overflow-x:auto;position:relative}
  .table{width:100%;border-collapse:collapse;margin-bottom:20px}
  .table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:500}
  .table-hover tbody tr:hover{background:#f8f9fa}
  .table-striped tbody tr:nth-of-type(odd){background:#f9f9f9}
  .badge-status{display:inline-flex;align-items:center;gap:6px;padding:.35rem .5rem}
  .icon-bar{display:flex;align-items:center}
  .icon-btn{display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:50%;border:1px solid #e0e0e0;background:#fff;color:#495057;margin-right:6px;font-size:14px}
  .icon-btn:hover{background:#f8f9fa;color:#0d6efd}
  .dropdown-container{display:none;position:fixed;z-index:1050;background:#fff;border-radius:8px;padding:20px;box-shadow:0 8px 12px rgba(0,0,0,.2);min-width:350px;max-width:450px;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border:4px solid #007bff}
  .dropdown-header{margin-bottom:15px}
  .dropdown-header .header-icon{font-size:24px;color:#007bff;margin-bottom:10px}
  .dropdown-header p{font-size:12px;font-weight:700;color:#333;margin:5px 0;line-height:1.5}
  .employee-name{color:#007bff;font-weight:700;font-size:12px}
  .status-dropdown{width:100%;margin-top:10px;font-size:12px;border:2px solid #007bff;border-radius:6px;background:#fff;color:#333}
  .close-icon{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer}
  .custom-modal .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3);font-size:12px;background:#fff}
  .custom-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:12px 16px;border-radius:12px 12px 0 0}
  .custom-modal .modal-header h5{font-size:12px;font-weight:700;margin:0;color:#fff}
  .custom-modal .modal-body{color:#333;background:#f9f9f9}
  .custom-modal .modal-footer{padding:12px 16px;border-top:1px solid #ddd;border-radius:0 0 12px 12px;background:#f1f1f1}
  .custom-modal .modal-footer .btn{font-size:12px;padding:8px 14px;border-radius:6px}
  .custom-modal .modal-footer .btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:none}
  .custom-modal .modal-footer .btn-secondary{background:#6c757d;color:#fff;border:none}
  .file-view{width:100%;height:360px;border:1px solid #e5e5e5;border-radius:8px;background:#fff;display:flex;align-items:center;justify-content:center;overflow:hidden}
  .file-view img{max-width:100%;max-height:100%;display:block}
  .btn-view{padding:4px 8px;border:1px solid #e0e0e0;border-radius:6px;background:#fff;font-size:11px}
  .btn-view i{margin-right:6px}
  .sr-penalty-head{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;border-radius:10px 10px 0 0;padding:10px 14px;font-weight:700;letter-spacing:.3px}
  .sr-penalty-body{border:1px solid #dee2e6;border-top:none;border-radius:0 0 10px 10px;padding:12px;background:#fff}
</style>

<div id="fullscreenOverlay" class="fullscreen-overlay"></div>

<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>CN#</th>
        <th>Candidate Name</th>
        <th>Sales Name</th>
        <th>Status</th>
        <th>Status Date</th>
        <th>Change Sponsorship Date</th>
        <th>Sponsor Name</th>
        <th>QID</th>
        <th>Penalty Amount</th>
        <th>Penalty Paid By</th>
        <th>Change Status Proof</th>
        <th>Penalty Proof</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($packages as $row)
        @php
          $cn = strtoupper($row->CN_Number ?? $row->trial_CN_Number ?? '');
          $cand = strtoupper($row->candidate_name ?? $row->trial_candidate_name ?? '');
          $passportNo = strtoupper($row->passport_no ?? $row->trial_passport_no ?? '');
          $salesName = trim(($row->sales_first_name ?? '').' '.($row->sales_last_name ?? ''));
          if ($salesName === '') {
              $salesRel = optional($row->createdByUser);
              $salesName = trim(($salesRel->first_name ?? '').' '.($salesRel->last_name ?? ''));
          }
          $salesName = $salesName !== '' ? strtoupper($salesName) : 'NOT ASSIGNED';

          $statusDateRaw = $row->change_status_date ?? $row->trial_updated_at ?? $row->updated_at;
          $statusDate = $statusDateRaw ? \Carbon\Carbon::parse($statusDateRaw)->format('d M Y') : '-';
          $chgSponDate = !empty($row->change_status_date) ? \Carbon\Carbon::parse($row->change_status_date)->format('d M Y H:i:s') : '-';

          $sFirst = $row->crm_first_name ?? optional(optional($row)->client)->first_name;
          $sLast  = $row->crm_last_name  ?? optional(optional($row)->client)->last_name;
          $sponsorName = trim(trim((string)$sFirst).' '.trim((string)$sLast));
          $sponsorName = $sponsorName !== '' ? strtoupper($sponsorName) : '-';

          $qid = $row->crm_emirates_id ?? optional(optional($row)->client)->emirates_id;
          $qid = $qid ? strtoupper($qid) : '-';

          $csProof = $row->change_status_proof ? asset('storage/'.$row->change_status_proof) : '';
          $penProof = $row->penalty_payment_proof ? asset('storage/'.$row->penalty_payment_proof) : '';
          $penAmt = is_null($row->penalty_payment_amount) ? null : (float)$row->penalty_payment_amount;

          $allowed = ['Admin','Operations Manager','Managing Director'];
          $canChange = in_array(auth()->user()->role ?? '', $allowed, true);

          $currentSid = (int)($row->created_by ?? $row->trial_created_by ?? $row->sales_id ?? 0);

          $statusClass = 'bg-info text-white';
          $statusIcon  = 'fas fa-right-left';
          if (($row->trial_status ?? '') === 'Incident') {
              $statusClass = 'bg-dark text-white';
              $statusIcon  = 'fas fa-exclamation-triangle';
          }
          if (in_array(($row->trial_status ?? ''), ['Confirmed','Contracted'], true)) {
              $statusClass = 'bg-primary text-white';
              $statusIcon  = 'fas fa-file-signature';
          }

          $candidateKey = $row->candidate_id ?: $row->id;
          $trialKey     = $row->trial_id ?? null;
        @endphp
        <tr>
          <td>{{ $cn }}</td>
          <td>{{ $cand }}</td>
          <td>
            <button
              type="button"
              class="btn btn-outline-primary btn-sm js-open-sales-modal"
              style="font-size:10px"
              data-can-change="{{ $canChange ? '1' : '0' }}"
              data-candidate-id="{{ $candidateKey }}"
              data-trial-id="{{ $trialKey }}"
              data-current-id="{{ $currentSid }}"
              data-current-label="{{ $salesName }}"
            >
              <i class="fas fa-user-edit me-1"></i>
              <span class="js-sales-label">{{ $salesName }}</span>
            </button>
          </td>
          <td>
            <span class="badge badge-status {{ $statusClass }}">
              <i class="{{ $statusIcon }}"></i> {{ $row->trial_status ?? '-' }}
            </span>
          </td>
          <td>{{ $statusDate }}</td>
          <td>{{ $chgSponDate }}</td>
          <td>{{ $sponsorName }}</td>
          <td>{{ $qid }}</td>
          <td>{{ !is_null($penAmt) ? number_format($penAmt,2) : '-' }}</td>
          <td>{{ $row->penalty_paid_by ?: '-' }}</td>
          <td>
            @if($csProof)
              <button class="btn-view" onclick="openChangeStatusFiles('{{ $csProof }}','')">
                <i class="fas fa-eye"></i> View
              </button>
            @else
              —
            @endif
          </td>
          <td>
            @if($penProof)
              <button class="btn-view" onclick="openChangeStatusFiles('','{{ $penProof }}')">
                <i class="fas fa-eye"></i> View
              </button>
            @else
              —
            @endif
          </td>
          <td>
            <div class="icon-bar">
              <button
                class="icon-btn"
                data-bs-toggle="tooltip"
                title="Change Status"
                onclick="openDropdown('{{ $candidateKey }}',this,'{{ $cand }}','{{ $cn }}')"
              >
                <i class="fas fa-train"></i>
              </button>
            </div>
            <div class="dropdown-container" id="dropdownContainer-{{ $candidateKey }}">
              <div class="close-icon" onclick="closeAllDropdowns()">
                <i class="fas fa-times-circle"></i>
              </div>
              <div class="dropdown-header">
                <div class="header-icon"><i class="fas fa-info-circle"></i></div>
                <p>Do you want to change the status of</p>
                <p>candidate <span class="employee-name">{{ $cand }}</span>?</p>
              </div>
              <select
                class="form-control status-dropdown"
                data-trial-id="{{ $trialKey }}"
                data-client-id="{{ $row->client_id }}"
                onchange="confirmStatusChange(this,'{{ $candidateKey }}','{{ $cand }}','{{ $cn }}','{{ $passportNo }}')"
              >
                <option value="0" selected>Change Status</option>
                <option value="5">Incident</option>
                <option value="6">Contracted</option>
                <option value="99">Sales Return</option>
              </select>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="13" class="text-center">No results found.</td>
        </tr>
      @endforelse
    </tbody>
    <tfoot>
      <tr>
        <th>CN#</th>
        <th>Candidate Name</th>
        <th>Sales Name</th>
        <th>Status</th>
        <th>Status Date</th>
        <th>Change Sponsorship Date</th>
        <th>Sponsor Name</th>
        <th>QID</th>
        <th>Penalty Amount</th>
        <th>Penalty Paid By</th>
        <th>Change Status Proof</th>
        <th>Penalty Proof</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>
</div>

<nav aria-label="Page navigation">
  <div class="pagination-container d-flex justify-content-between align-items-center">
    <span class="muted-text">
      Showing {{ $packages->firstItem() }} to {{ $packages->lastItem() }} of {{ $packages->total() }} results
    </span>
    <ul class="pagination justify-content-center mb-0">
      {{ $packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
    </ul>
  </div>
</nav>

<div class="modal fade custom-modal" id="SalesReturnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fa-solid fa-box-open text-light"></i> Sales Return
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="SalesReturnModalForm" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row g-3 mb-2">
            <div class="col-md-4">
              <label class="form-label">Candidate Name</label>
              <input type="text" id="SalesReturnModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="SalesReturnModalcandidateId" name="candidate_id">
              <input type="hidden" id="SalesReturnModaltrial_id" name="trial_id">
              <input type="hidden" id="SalesReturnModalpassportNo" name="passport_no">
            </div>
            <div class="col-md-4">
              <label class="form-label">Employer Name</label>
              <input type="text" id="SalesReturnModalclientName" name="employer_name" class="form-control" readonly>
            </div>
            <div class="col-md-4">
              <label class="form-label">Return Date</label>
              <input
                type="date"
                class="form-control js-sales-return-date"
                name="return_date"
                value="{{ \Carbon\Carbon::now('Asia/Qatar')->format('Y-m-d') }}"
              >
            </div>
          </div>
          <div class="mb-2">
            <div class="d-inline-flex align-items-center gap-3">
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input js-sales-decision"
                  type="radio"
                  name="action_type"
                  id="SalesActionRefund"
                  value="refund"
                  checked
                >
                <label class="form-check-label" for="SalesActionRefund">Refund</label>
              </div>
              <div class="form-check form-check-inline">
                <input
                  class="form-check-input js-sales-decision"
                  type="radio"
                  name="action_type"
                  id="SalesActionReplacement"
                  value="replacement"
                >
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
                  <input
                    type="file"
                    id="nocExpiryAttachment"
                    name="noc_expiry_attachment"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png"
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="row g-3 mt-2">
            <div class="col-md-6">
              <label class="form-label">Upload Proof</label>
              <input
                type="file"
                id="SalesReturnProof"
                class="form-control"
                name="proof"
                accept="image/png,image/jpg,image/jpeg,application/pdf"
              >
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

<div class="modal fade custom-modal" id="ChangeStatusFilesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fa-solid fa-images text-light"></i> Change Status Files
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Change Status Proof</label>
            <div id="view_cs_proof" class="file-view">No file</div>
            <div class="mt-2">
              <a
                id="link_cs_proof"
                href="#"
                target="_blank"
                class="btn btn-sm btn-light"
                style="display:none"
              >
                <i class="fas fa-file-arrow-down me-1"></i>View/Download
              </a>
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Penalty Payment Proof</label>
            <div id="view_penalty_proof" class="file-view">No file</div>
            <div class="mt-2">
              <a
                id="link_penalty_proof"
                href="#"
                target="_blank"
                class="btn btn-sm btn-light"
                style="display:none"
              >
                <i class="fas fa-file-arrow-down me-1"></i>View/Download
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Close
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="changeSalesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title">
          <i class="fas fa-user-gear me-2"></i> Change Sales Name
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-3">
        <div class="mb-2">Current: <strong id="sales-current-label">—</strong></div>
        <input type="hidden" id="sales-candidate-id">
        <input type="hidden" id="sales-trial-id">
        <input type="hidden" id="sales-current-id">
        <label class="form-label">Select Sales Officer</label>
        <select id="sales-select" class="form-select">
          @foreach($salesOfficers as $user)
            @php $full = trim(($user->first_name ?? '').' '.($user->last_name ?? '')); @endphp
            <option value="{{ $user->id }}">{{ $full }}</option>
          @endforeach
        </select>
        <div id="sales-consent" style="display:none;margin-top:10px">
          <div class="mb-2">Confirm change?</div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-success btn-sm" id="btn-consent-yes">
              <i class="fas fa-check"></i> Yes
            </button>
            <button type="button" class="btn btn-secondary btn-sm" id="btn-consent-no">
              <i class="fas fa-times"></i> No
            </button>
          </div>
        </div>
        <div id="sales-msg" class="mt-2"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="IncidentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-exclamation-triangle me-2"></i> Incident Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="hideModal('IncidentModal')"></button>
      </div>
      <div class="modal-body">
        <form id="incidentForm" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="trial_id" id="incident_trial_id">
          <input type="hidden" name="candidate_id" id="incident_candidate_id">
          <input type="hidden" name="cn_number" id="incident_cn_number">
          <input type="hidden" name="type" id="incident_scope" value="package">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="incident_candidate_name">Candidate Name</label>
              <input type="text" id="incident_candidate_name" name="candidate_name" class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label for="incident_passport_no">Passport No</label>
              <input type="text" id="incident_passport_no" name="passport_no" class="form-control" readonly>
            </div>
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
            <input type="file" id="incident_proof" name="incident_proof" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
          </div>
          <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="hideModal('IncidentModal')">
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

<script>
  var csrfToken='{{ csrf_token() }}';
  var routes={
    updateTrialStatus:'{{ route("packages.updateTrialStatus") }}',
    saveSalesReturn:'{{ route("packages.saveSalesReturn") }}',
    updateSalesName:'{{ route("packages.updateTrialSalesName") }}',
    refundSalesView:'{{ route("packages.refund-sales-view") }}',
    replacementSalesView:'{{ route("packages.replacement-sales-view") }}',
    incidentData:'{{ route("package.incidentData",":id") }}',
    saveIncident:'{{ route("package.incidentSave") }}'
  };

  function toastSuccess(msg){
    var m=msg||'Saved successfully.';
    if(window.toastr){toastr.success(m)}else{alert(m)}
  }

  function toastError(msg){
    var m=msg||'Something went wrong.';
    if(window.toastr){toastr.error(m)}else{alert(m)}
  }

  function confirmDialog(options,onConfirm,onCancel){
    var title=options.title||'Are you sure?';
    var text=options.text||'';
    var icon=options.icon||'warning';
    var confirmText=options.confirmButtonText||'Yes';
    var cancelText=options.cancelButtonText||'Cancel';
    if(window.Swal){
      Swal.fire({
        title:title,
        text:text,
        icon:icon,
        showCancelButton:true,
        confirmButtonText:confirmText,
        cancelButtonText:cancelText,
        reverseButtons:true
      }).then(function(result){
        if(result.isConfirmed){if(typeof onConfirm==='function')onConfirm()}
        else if(typeof onCancel==='function')onCancel()
      });
    }else{
      if(confirm(text||title)){if(typeof onConfirm==='function')onConfirm()}
      else if(typeof onCancel==='function')onCancel()
    }
  }

  function openDropdown(candidateKey,btn,candidateName,cn){
    $('.dropdown-container').hide();
    $('#fullscreenOverlay').fadeIn(120);
    var dc=$('#dropdownContainer-'+candidateKey);
    dc.find('.employee-name').text(candidateName);
    dc.css({display:'block',opacity:0}).animate({opacity:1},200);
  }

  function closeAllDropdowns(){
    $('.dropdown-container').fadeOut(150);
    $('#fullscreenOverlay').fadeOut(150);
  }

  function openIncidentModal(data){
    $('#incident_trial_id').val(data.trial_id||'');
    $('#incident_candidate_id').val(data.candidate_id||'');
    $('#incident_cn_number').val(data.cn_number||'');
    $('#incident_candidate_name').val((data.candidate_name||'').toString());
    $('#incident_passport_no').val(data.passport_no||'');
    $('#incident_type').val(data.incident_type||'');
    $('#incident_date').val(data.incident_date||'');
    $('#incident_comments').val(data.comments||'');
    var el=document.getElementById('IncidentModal');
    var m=new bootstrap.Modal(el);
    m.show();
  }

  function hideModal(id){
    var el=document.getElementById(id);
    if(!el)return;
    var inst=bootstrap.Modal.getInstance(el);
    if(inst){inst.hide();}
  }

  function updateTrialStatusRequest(trialId,candidateId,clientId,statusLabel,passportNo){
    fetch(routes.updateTrialStatus,{
      method:'POST',
      headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN':csrfToken,
        'Accept':'application/json'
      },
      body:JSON.stringify({
        trial_id:trialId,
        candidate_id:candidateId,
        client_id:clientId,
        status:statusLabel,
        passport_no:passportNo||''
      })
    })
      .then(function(r){return r.json()})
      .then(function(res){
        if(res.success){
          if(res.action==='open_modal'){
            closeAllDropdowns();
            if(res.modal==='IncidentModal'&&res.incident){
              openIncidentModal(res.incident);
            }else if(res.modal==='SalesReturnModal'){
              openSalesReturn(trialId,candidateId,clientId,passportNo||'');
            }
            if(res.message){toastSuccess(res.message);}
            return;
          }
          toastSuccess(res.message||('Status changed to '+statusLabel+'.'));
          closeAllDropdowns();
          setTimeout(function(){location.reload()},600);
        }else{
          toastError(res.message||'Failed to change status.');
        }
      })
      .catch(function(){
        toastError('Failed to change status.');
      });
  }

  function confirmStatusChange(sel,candidateId,candidateName,cn,passportNo){
    var v=String(sel.value||'0');
    if(v==='0'){return}
    var trialId=sel.getAttribute('data-trial-id')||'';
    var clientId=sel.getAttribute('data-client-id')||'';
    var p=(passportNo||'').toString();
    if(!trialId){
      toastError('Trial reference not found for this record.');
      sel.value='0';
      return;
    }
    if(v==='5'){
      confirmDialog(
        {
          title:'Change Status',
          text:'Do you want to change status to Incident?',
          icon:'warning',
          confirmButtonText:'Yes, change',
          cancelButtonText:'Cancel'
        },
        function(){
          updateTrialStatusRequest(trialId,candidateId,clientId,'Incident',p);
        },
        function(){
          sel.value='0';
        }
      );
    }else if(v==='6'){
      confirmDialog(
        {
          title:'Contracted Status',
          text:'Do you want to change this to the Contracted status?',
          icon:'warning',
          confirmButtonText:'Yes, change',
          cancelButtonText:'Cancel'
        },
        function(){
          updateTrialStatusRequest(trialId,candidateId,clientId,'Contracted',p);
        },
        function(){
          sel.value='0';
        }
      );
    }else if(v==='99'){
      sel.value='0';
      closeAllDropdowns();
      openSalesReturn(trialId,candidateId,clientId,p);
    }
  }

  function filePreview(containerId,url){
    var wrap=document.getElementById(containerId);
    wrap.innerHTML='No file';
    if(!url)return;
    if(/\.pdf(\?|$)/i.test(url)){
      var obj=document.createElement('iframe');
      obj.src=url;
      obj.style.border='0';
      obj.width='100%';
      obj.height='100%';
      wrap.innerHTML='';
      wrap.appendChild(obj);
    }else{
      var img=document.createElement('img');
      img.src=url;
      img.alt='file';
      wrap.innerHTML='';
      wrap.appendChild(img);
    }
  }

  function openChangeStatusFiles(csUrl,penUrl){
    filePreview('view_cs_proof',csUrl||'');
    filePreview('view_penalty_proof',penUrl||'');
    var a1=document.getElementById('link_cs_proof');
    var a2=document.getElementById('link_penalty_proof');
    if(csUrl){a1.href=csUrl;a1.style.display='inline-block'}else{a1.removeAttribute('href');a1.style.display='none'}
    if(penUrl){a2.href=penUrl;a2.style.display='inline-block'}else{a2.removeAttribute('href');a2.style.display='none'}
    new bootstrap.Modal(document.getElementById('ChangeStatusFilesModal')).show();
  }

  var salesModalInst=null;
  function salesModal(){
    if(!salesModalInst){
      salesModalInst=new bootstrap.Modal(document.getElementById('changeSalesModal'));
    }
    return salesModalInst;
  }

  $(document).on('click','.js-open-sales-modal',function(){
    var canChange=$(this).data('can-change')==='1';
    if(!canChange){
      toastError('You do not have permission to update.');
      return;
    }
    var cid=$(this).data('candidate-id');
    var tid=$(this).data('trial-id');
    var curId=parseInt($(this).data('current-id'))||0;
    var curLabel=($(this).data('current-label')||'NOT ASSIGNED').toString();
    window.__lastSalesBtn=$(this);
    $('#sales-candidate-id').val(cid);
    $('#sales-trial-id').val(tid);
    $('#sales-current-id').val(curId);
    $('#sales-current-label').text(curLabel);
    $('#sales-select').val(curId);
    $('#sales-consent').hide();
    $('#sales-msg').removeClass().text('');
    salesModal().show();
  });

  $('#sales-select').on('change',function(){
    var n=parseInt($(this).val())||0;
    var c=parseInt($('#sales-current-id').val())||0;
    if(n!==c){$('#sales-consent').show()}else{$('#sales-consent').hide()}
  });

  $('#btn-consent-no').on('click',function(){
    $('#sales-select').val($('#sales-current-id').val());
    $('#sales-consent').hide();
    $('#sales-msg').removeClass().text('');
  });

  $('#btn-consent-yes').on('click',function(){
    var cid=$('#sales-candidate-id').val();
    var tid=$('#sales-trial-id').val();
    var nid=$('#sales-select').val();
    $('#sales-msg').removeClass().text('Saving...');
    $.post(routes.updateSalesName,{candidate_id:cid,trial_id:tid,sales_name:nid,_token:csrfToken})
      .done(function(res){
        var label=(res.display_name||$('#sales-select option:selected').text()||'Not assigned').toUpperCase();
        $('#sales-current-id').val(nid);
        $('#sales-current-label').text(label);
        if(window.__lastSalesBtn&&window.__lastSalesBtn.length){
          window.__lastSalesBtn.data('current-id',parseInt(nid));
          window.__lastSalesBtn.data('current-label',label);
          window.__lastSalesBtn.find('.js-sales-label').text(label);
        }
        $('#sales-msg').addClass('text-success').text(res.message||'Updated successfully.');
        setTimeout(function(){salesModal().hide()},400);
      })
      .fail(function(xhr){
        $('#sales-msg').addClass('text-danger').text((xhr.responseJSON&&xhr.responseJSON.message)?xhr.responseJSON.message:'Failed to update.');
      });
  });

  $(document).on('hidden.bs.modal','.modal',function(){
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css({overflow:'auto',paddingRight:''});
  });

  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el){
    if(window.bootstrap&&bootstrap.Tooltip){new bootstrap.Tooltip(el)}
  });

  function _num(v){
    var x=parseFloat((v||'').toString().replace(/,/g,''));
    return isNaN(x)?0:x;
  }

  function _d(s){
    if(!s)return null;
    var d=new Date(s+'T00:00:00Z');
    return isNaN(d)?null:d;
  }

  function _days(a,b){
    if(!a||!b)return 0;
    var ms=b.getTime()-a.getTime();
    return ms<=0?0:Math.floor(ms/86400000);
  }

  function _isFriday(d){
    return d&&d.getUTCDay()===5;
  }

  function applyDateGuardsSales(kind){
    var $refundDate=$('#DecisionContentSales .js-available-date');
    var $replaceDate=$('#DecisionContentSales [name="replacement_due_date"]');
    var t=new Date();
    var today=new Date(Date.UTC(t.getFullYear(),t.getMonth(),t.getDate()));
    if(kind==='refund'&&$refundDate.length){
      var min=new Date(today.getTime()+7*86400000);
      $refundDate.attr('min',min.toISOString().slice(0,10))
        .off('change.guard')
        .on('change.guard',function(){
          var d=_d(this.value);
          if(!d){this.value='';return}
          if(d<min||_isFriday(d)){
            this.value='';
            toastError('Refund Available Date must be after 7 days and not Friday');
          }
        });
    }
    if(kind==='replacement'&&$replaceDate.length){
      $replaceDate.off('change.guard').on('change.guard',function(){
        var d=_d(this.value);
        if(!d||_isFriday(d)){
          this.value='';
          toastError('Replacement Available Date cannot be Friday');
        }
      });
    }
  }

  function computePenaltySales(){
    var type=($('#DecisionContentSales .js-penalty-type').val()||'Visa').toString();
    var expiry=_d($('#DecisionContentSales .js-expiry-date').val());
    var ret=_d($('.js-sales-return-date').val());
    var rate=_num($('#DecisionContentSales .js-penalty-rate').val());
    var days=0;
    if(expiry&&ret){
      if(type==='Visa'){days=_days(expiry,ret)}
      else{
        var raw=_days(expiry,ret);
        days=raw>90?(raw-90):0;
      }
    }
    if(days<0)days=0;
    var amount=Math.max(0,rate*days);
    $('#DecisionContentSales .js-penalty-days').val(days);
    $('#DecisionContentSales .js-penalty-amount').val(amount.toFixed(2));
    return amount;
  }

  function salaryDeductionSales(){
    var who=($('#DecisionContentSales .js-salary-type').val()||'Sponsor').toString();
    if(who!=='Sponsor')return 0;
    var salary=_num($('#DecisionContentSales .js-salary-amount').val());
    var days=_num($('#DecisionContentSales .js-days-exist').val());
    if(salary<=0||days<=0)return 0;
    var perDay=salary/30;
    var deduct=perDay*days;
    return Math.max(0,deduct);
  }

  function baseBalanceSales(){
    return _num($('#DecisionContentSales .js-balance').val());
  }

  function ensureHiddenSales(name){
    var $f=$('input[name="'+name+'"]');
    if(!$f.length){
      $f=$('<input type="hidden">').attr('name',name);
      $('#SalesReturnModalForm').append($f);
    }
    return $f;
  }

  function recalcFinalSales(){
    var penalty=computePenaltySales();
    var salary=salaryDeductionSales();
    $('#DecisionContentSales .js-salary-deduct').val(salary.toFixed(2));
    var finalVal=Math.max(0,baseBalanceSales()-penalty-salary);
    $('#DecisionContentSales .js-final').val(finalVal.toFixed(2));
    var action=$('input[name="action_type"]:checked').val();
    if(action==='refund'){
      ensureHiddenSales('refund_final_balance').val(finalVal.toFixed(2));
      ensureHiddenSales('replacement_final_balance').val('');
    }else{
      ensureHiddenSales('replacement_final_balance').val(finalVal.toFixed(2));
      ensureHiddenSales('refund_final_balance').val('');
    }
  }

  function bindRecalcHandlersSales(){
    $('#DecisionContentSales')
      .off('input change.recalc')
      .on('input change.recalc','.js-penalty-type,.js-expiry-date,.js-penalty-rate,.js-balance,.js-salary-type,.js-salary-amount,.js-days-exist',recalcFinalSales);
    $('.js-sales-return-date')
      .off('change.recalc')
      .on('change.recalc',recalcFinalSales);
  }

  function loadDecisionPartialSales(kind){
    var cid=$('#SalesReturnModalcandidateId').val();
    var pass=$('#SalesReturnModalpassportNo').val()||'';
    var url=kind==='refund'?routes.refundSalesView:routes.replacementSalesView;
    $('#DecisionContentSales').html('');
    $('#DecisionContentSales').load(
      url+'?candidate_id='+encodeURIComponent(cid)+'&passport_no='+encodeURIComponent(pass),
      function(){
        applyDateGuardsSales(kind);
        bindRecalcHandlersSales();
        recalcFinalSales();
      }
    );
  }

  function openSalesReturn(trialId,candidateId,clientId,passportNo){
    $('#SalesReturnModaltrial_id').val(trialId||'');
    $('#SalesReturnModalcandidateId').val(candidateId||'');
    $('#SalesReturnModalpassportNo').val(passportNo||'');
    $('#SalesReturnModalcandidateName').val('');
    $('#SalesReturnModalclientName').val('');
    $('#DecisionContentSales').html('');
    $('#nocExpirySelect').val('');
    $('.noc-extra').addClass('d-none');
    $.get({
      url:routes.incidentData.replace(':id',trialId),
      headers:{'X-CSRF-TOKEN':csrfToken}
    })
      .done(function(resp){
        $('#SalesReturnModalcandidateName').val(resp.candidate_name||resp.candidateName||'');
        $('#SalesReturnModalclientName').val(resp.client_name||resp.clientName||resp.employer_name||'');
        if((resp.passport_no||resp.passportNo||'')!==''){
          $('#SalesReturnModalpassportNo').val(resp.passport_no||resp.passportNo||'');
        }
      })
      .always(function(){
        $('input[name="action_type"][value="refund"]').prop('checked',true);
        loadDecisionPartialSales('refund');
        new bootstrap.Modal(document.getElementById('SalesReturnModal')).show();
      });
  }

  $(document).on('change','.js-sales-decision',function(){
    var v=$(this).val();
    if(v==='refund'||v==='replacement'){loadDecisionPartialSales(v)}
  });

  $('#nocExpirySelect').on('change',function(){
    if($(this).val()==='Yes'){
      $('.noc-extra').removeClass('d-none');
    }else{
      $('.noc-extra').addClass('d-none');
      $('#nocExpiryDate').val('');
      $('#nocExpiryAttachment').val('');
    }
  });

  function saveIncidentData(){
    var form=document.getElementById('incidentForm');
    var fd=new FormData(form);
    fetch(routes.saveIncident,{
      method:'POST',
      headers:{'X-CSRF-TOKEN':csrfToken},
      body:fd
    })
      .then(function(r){return r.json()})
      .then(function(d){
        if(d.success){
          toastSuccess(d.message||'Incident saved.');
          hideModal('IncidentModal');
          setTimeout(function(){location.reload()},800);
        }else{
          toastError(d.message||'Failed to save incident.');
        }
      })
      .catch(function(){
        toastError('Request failed.');
      });
  }

  document.getElementById('saveSalesReturnButton').addEventListener('click',function(){
    var action=$('input[name="action_type"]:checked').val();
    if(!action){
      toastError('Please choose Refund or Replacement.');
      return;
    }
    recalcFinalSales();
    var fd=new FormData(document.getElementById('SalesReturnModalForm'));
    fd.set('action_type',action);
    fd.set('passport_no',$('#SalesReturnModalpassportNo').val()||'');
    var finalVal=$('#DecisionContentSales .js-final').val()||'0';
    if(action==='refund'){
      fd.set('refund_final_balance',finalVal);
      fd.delete('replacement_final_balance');
    }else{
      fd.set('replacement_final_balance',finalVal);
      fd.delete('refund_final_balance');
    }
    var nocStatus=$('#nocExpirySelect').val()||'';
    fd.set('noc_expiry_status',nocStatus);
    if(nocStatus!=='Yes'){
      fd.delete('noc_expiry_date');
      fd.delete('noc_expiry_attachment');
    }
    fetch(routes.saveSalesReturn,{
      method:'POST',
      headers:{'X-CSRF-TOKEN':csrfToken},
      body:fd
    })
      .then(function(r){return r.json()})
      .then(function(d){
        if(d.success){
          toastSuccess(d.message||'Saved.');
          bootstrap.Modal.getInstance(document.getElementById('SalesReturnModal')).hide();
          setTimeout(function(){location.reload()},1200);
        }else{
          toastError(d.message||'Failed to save.');
        }
      })
      .catch(function(){
        toastError('Request failed.');
      });
  });
</script>
