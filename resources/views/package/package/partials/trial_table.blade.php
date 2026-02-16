<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
  .nav-tabs .nav-link{transition:background-color .2s;color:#495057;font-size:12px;text-transform:uppercase}
  .nav-tabs .nav-link:hover{background-color:#f8f9fa}
  .nav-tabs .nav-link.active{background-color:#007bff;color:#fff}
  .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:400}
  .muted-text{color:#6c757d;font-size:12px}
  .table-container{width:100%;overflow-x:auto;position:relative}
  .table{width:100%;border-collapse:collapse;margin-bottom:20px}
  .table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .table th{background-color:#343a40;color:#fff;text-transform:uppercase;font-weight:700}
  .table-hover tbody tr:hover{background-color:#f1f1f1}
  .table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}
  .icon-btn{display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:50%;border:1px solid #e0e0e0;background:#fff;color:#495057;margin-right:6px;font-size:14px}
  .icon-btn:hover{background:#f8f9fa;color:#0d6efd}
  .icon-bar{display:flex;align-items:center}
  .dropdown-container{display:none;position:fixed;z-index:1050;background:#fff;border-radius:8px;padding:20px;box-shadow:0 8px 12px rgba(0,0,0,.2);min-width:350px;max-width:450px;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border:4px solid #007bff}
  .dropdown-header{margin-bottom:15px}
  .dropdown-header .header-icon{font-size:24px;color:#007bff;margin-bottom:10px}
  .dropdown-header p{font-size:12px;font-weight:700;color:#333;margin:5px 0;line-height:1.5}
  .employee-name{color:#007bff;font-weight:700;font-size:12px}
  .status-dropdown{width:100%;margin-top:10px;font-size:12px;border:2px solid #007bff;border-radius:6px;background:#fff;color:#333}
  .close-icon{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer}
  .badge-status{display:inline-flex;align-items:center;gap:6px;padding:.35rem .5rem}
  .time-ok{color:#28a745}
  .time-bad{color:#dc3545}
  .custom-modal .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3);font-family:Arial,sans-serif;background:#fff}
  .custom-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0}
  .custom-modal .modal-header h5,.custom-modal .modal-header h4{font-weight:bold;margin:0;color:#fff}
  .custom-modal .modal-body{color:#333;background:#f9f9f9}
  .custom-modal .modal-footer{padding:15px;border-top:1px solid #ddd;border-radius:0 0 12px 12px;background:#f1f1f1}
  .custom-modal .modal-footer .btn{padding:8px 15px;border-radius:5px;transition:all .3s}
  .custom-modal .modal-footer .btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:none}
  .custom-modal .modal-footer .btn-primary:hover{background:#0056b3;color:#fff}
  .custom-modal .modal-footer .btn-secondary{background:#6c757d;color:#fff;border:none}
  .custom-modal .table{margin-bottom:0;color:#333}
  .custom-modal .table thead th{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;font-weight:bold;text-transform:uppercase;text-align:center}
  .penalty-head{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;border-radius:10px 10px 0 0;padding:10px 12px;letter-spacing:.3px}
  .penalty-body{border:1px solid #dee2e6;border-top:none;border-radius:0 0 10px 10px;padding:12px;background:#fff}
  .custom-modal .form-control,.custom-modal .form-select{height:30px;padding:4px 8px;font-size:12px}
  .custom-modal textarea.form-control{min-height:60px}
  .custom-modal label,.custom-modal .modal-title,.custom-modal .btn,.custom-modal .form-check-label{font-size:12px}
  .table-container .time-note{display:block;font-size:10px;line-height:1.1;margin-top:3px}
  .table-container .blink-red{color:#dc3545;}
  @keyframes blink{50%{opacity:0}}
</style>
<div id="fullscreenOverlay"></div>
<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>CN#</th>
        <th>Candidate Name</th>
        <th>Sales Name</th>
        <th>Status</th>
        <th>Status Date</th>
        <th>Nationality</th>
        <th>Passport #</th>
        <th>Partner</th>
        <th>Client Name</th>
        <th>Current Visa</th>
        <th>Arrived Date</th>
        <th>Return Date</th>
        <th>Cancel Date</th>
        <th>Visa/Cancel Expiry</th>
        <th>Trial Start</th>
        <th>Trial End</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @if($packages->isEmpty())
        <tr><td colspan="17" class="text-center">No results found.</td></tr>
      @else
        @foreach($packages as $trial)
          @php
            $today=\Carbon\Carbon::now('Asia/Qatar');
            $end=$trial->trial_end_date?\Carbon\Carbon::parse($trial->trial_end_date,'Asia/Qatar'):null;
            $rowStyle=$end?($end->isSameDay($today)?'background-color:#fff3cd!important;':($end->lessThan($today)?'background-color:#f8d7da!important;':'')):'';
            $diff=$end?$end->diffForHumans($today,['parts'=>2,'join'=>', ']):null;
            $timeTitle=$end?($end->isPast()?($diff.' ago'):($diff.' left')):'';
            $timeClass=$end&&($end->isPast()||$today->diffInHours($end,false)<=24)?'time-bad':'time-ok';
            $allowedRoles=['Admin','Operations Manager','Managing Director'];
            $canChange=in_array(auth()->user()->role??'',$allowedRoles,true);
            $currentSalesId=(int)($trial->sales_id??$trial->created_by??0);
            $currentSalesDisplay=strtoupper(($trial->sales_name??'')!==''?$trial->sales_name:'NOT ASSIGNED');
            $statusStyles=['Active'=>['bg-success text-white','fas fa-check-circle'],'Confirmed'=>['bg-primary text-white','fas fa-user-check'],'Change Status'=>['bg-warning text-dark','fas fa-right-left'],'Incident'=>['bg-dark text-white','fas fa-exclamation-triangle'],'Trial Return'=>['bg-secondary text-white','fas fa-arrow-circle-left']];
            [$statusClass,$statusIcon]=$statusStyles[$trial->trial_status]??['bg-light text-dark','fas fa-info-circle'];
            $partnerRaw=strtoupper($trial->foreign_partner??'');
            $partnerShort=\Illuminate\Support\Str::before($partnerRaw,' ');
            $candidateFull=strtoupper($trial->candidate_name??'');
            $candidateDisplay=\Illuminate\Support\Str::length($candidateFull)>20?\Illuminate\Support\Str::substr($candidateFull,0,20).'...':$candidateFull;
            $clientFull=strtoupper(trim(($trial->crm_first_name??'').' '.($trial->crm_last_name??'')));
            $clientDisplay=\Illuminate\Support\Str::length($clientFull)>20?\Illuminate\Support\Str::substr($clientFull,0,20).'...':$clientFull;
            $clientUrl=isset($trial->client)?route('crm.show',$trial->client->slug):'javascript:void(0);';
          @endphp
          <tr style="{{ $rowStyle }}">
            <td>{{ strtoupper($trial->trial_CN_Number ?? '') }}</td>
            <td title="{{ $candidateFull }}">{{ $candidateDisplay }}</td>
            <td>
              <button type="button" style="font-size:8px!important" class="btn btn-outline-primary btn-sm js-open-sales-modal" data-can-change="{{ $canChange ? '1':'0' }}" data-candidate-id="{{ $trial->candidate_id }}" data-trial-id="{{ $trial->trials_id }}" data-current-id="{{ $currentSalesId }}" data-current-label="{{ $currentSalesDisplay }}">
                <i class="fas fa-user-edit me-1"></i><span class="js-sales-label">{{ $currentSalesDisplay }}</span>
              </button>
            </td>
            <td class="text-center">
              <span class="badge badge-status {{ $statusClass }}"><i class="{{ $statusIcon }}"></i> {{ $trial->trial_status }}</span>
              @if($trial->trial_status==='Active' && $end)
                @if($end->isPast())
                  <small class="time-note blink-red" title="{{ $timeTitle }}">EXPIRED • {{ $diff }}</small>
                @else
                  <small class="time-note text-muted" title="{{ $timeTitle }}">{{ $diff }} left</small>
                @endif
              @endif
            </td>
            <td>{{ strtoupper($trial->updated_at->setTimezone('Asia/Qatar')->format('d M Y h:i A')) }}</td>
            <td>{{ strtoupper($trial->nationality ?? '') }}</td>
            <td>{{ strtoupper($trial->passport_no ?? '') }}</td>
            <td>{{ $partnerShort }}</td>
            <td title="{{ $clientFull }}"><a href="{{ $clientUrl }}">{{ $clientDisplay }}</a></td>
            <td>{{ strtoupper($trial->visa_type ?? '') }}</td>
            <td>{{ $trial->arrived_date ? \Carbon\Carbon::parse($trial->arrived_date,'Asia/Qatar')->format('d M Y') : '-' }}</td>
            <td>{{ $trial->display_return_date ? \Carbon\Carbon::parse($trial->display_return_date,'Asia/Qatar')->format('d M Y') : '-' }}</td>
            <td>{{ $trial->pkg_cancel_date ? \Carbon\Carbon::parse($trial->pkg_cancel_date,'Asia/Qatar')->format('d M Y') : '-' }}</td>
            <td>{{ $trial->pkg_expiry_date ? \Carbon\Carbon::parse($trial->pkg_expiry_date,'Asia/Qatar')->format('d M Y') : '-' }}</td>
            <td>{{ $trial->trial_start_date ? \Carbon\Carbon::parse($trial->trial_start_date,'Asia/Qatar')->format('d M Y') : '-' }}</td>
            <td>{{ $trial->trial_end_date ? \Carbon\Carbon::parse($trial->trial_end_date,'Asia/Qatar')->format('d M Y') : '-' }}</td>
            <td>{{ $trial->remarks ?? '-' }}</td>
            <td>
              <div class="icon-bar">
                @if ($trial->trial_status === 'Active')
                  <a class="icon-btn" href="{{ route('packages.trialForm',['agreement_reference_no'=>$trial->agreement_reference_no]) }}" target="_blank" data-bs-toggle="tooltip" title="Trial Form"><i class="fas fa-file-alt"></i></a>
                @endif
                @if ($trial->trial_status === 'Trial Return')
                  <a class="icon-btn" href="{{ route('packages.trialReturnForm', [ 'client_id' => $trial->client_id, 'candidate_id' => $trial->candidate_id, 'stage' => 'trial_return',]) }}" target="_blank" data-bs-toggle="tooltip" title="Trial Return Form">
                    <i class="fas fa-file-invoice"></i>
                  </a>
                @endif
                <button class="icon-btn" data-bs-toggle="tooltip" title="Change Status" onclick="openDropdown('{{ $trial->trials_id }}')"><i class="fas fa-train"></i></button>
              </div>
              <div class="dropdown-container" id="dropdownContainer-{{ $trial->trials_id }}">
                <div class="close-icon" onclick="closeAllDropdowns()"><i class="fas fa-times-circle"></i></div>
                <div class="dropdown-header">
                  <div class="header-icon"><i class="fas fa-info-circle"></i></div>
                  <p>Do you want to change the status of</p>
                  <p>candidate <span class="employee-name">{{ strtoupper($trial->candidate_name) }}</span>?</p>
                </div>
                <select class="form-control status-dropdown" onchange="trialChangeStatus(this,{{ $trial->trials_id }},{{ $trial->candidate_id }},{{ $trial->client_id }})">
                  @if($trial->trial_status==='Active')
                    <option disabled selected>Active</option>
                    <option>Confirmed</option>
                    <option>Trial Return</option>
                    <option>Incident</option>
                  @elseif($trial->trial_status==='Confirmed')
                    <option disabled selected>Confirmed</option>
                    <option>Change Status</option>
                    <option>Trial Return</option>
                    <option>Incident</option>
                  @elseif($trial->trial_status==='Change Status')
                    <option disabled selected>Change Status</option>
                    <option>Incident</option>
                  @else
                    <option disabled selected>{{ $trial->trial_status }}</option>
                  @endif
                </select>
              </div>
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
    <tfoot>
      <tr>
        <th>CN#</th>
        <th>Candidate Name</th>
        <th>Sales Name</th>
        <th>Status</th>
        <th>Status Date</th>
        <th>Nationality</th>
        <th>Passport #</th>
        <th>Partner</th>
        <th>Client Name</th>
        <th>Current Visa</th>
        <th>Arrived Date</th>
        <th>Return Date</th>
        <th>Cancel Date</th>
        <th>Visa/Cancel Expiry</th>
        <th>Trial Start</th>
        <th>Trial End</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>
</div>
<nav aria-label="Page navigation">
  <div class="pagination-container">
    <span class="muted-text">Showing {{ $packages->firstItem() }} to {{ $packages->lastItem() }} of {{ $packages->total() }} results</span>
    <ul class="pagination justify-content-center">{{ $packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}</ul>
  </div>
</nav>

<div class="modal fade custom-modal" id="ConfirmedModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-circle-check text-light"></i> Trial Confirmed</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="ConfirmedModalForm" enctype="multipart/form-data" method="POST">@csrf
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label class="form-label"><i class="fas fa-user"></i> Candidate Name</label>
              <input type="text" id="ConfirmedModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="ConfirmedModalcandidateId" name="candidate_id">
              <input type="hidden" name="trial_id" id="trial_id">
            </div>
            <div class="col-lg-6">
              <label class="form-label"><i class="fas fa-building"></i> Employer Name</label>
              <input type="text" name="employer_name" id="ConfirmedModalclientName" class="form-control" readonly>
            </div>
          </div>
          <div class="mb-4" id="InvoiceData"></div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label"><i class="fas fa-calendar-day"></i> Confirmed Date</label>
              <input type="date" id="ConfirmedModalDate" class="form-control" name="confirmed_date" value="{{ \Carbon\Carbon::now('Asia/Qatar')->format('Y-m-d') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label"><i class="fas fa-credit-card"></i> Payment Method</label>
              @php
                $host=request()->getHost();
                $tenant=stripos($host,'rozana.')!==false?'rozana':(stripos($host,'middleeast.')!==false?'middleeast':(stripos($host,'vienna.')!==false?'vienna':null));
                $map=['rozana'=>['CBQ','QNB','CASH','CHEQUE','POS','CB-LINK','REPLACEMENT'],'middleeast'=>['QIB','CBQ','POS','CASH','CHEQUE','CB-LINK','REPLACEMENT'],'vienna'=>['CBQ','CASH','CHEQUE','POS','CB-LINK','REPLACEMENT']];
                $methods=$map[$tenant]??['CBQ','QNB','QIB','CASH','CHEQUE','POS'];
                $selected=old('payment_method',$payment_method??'');
              @endphp
              <select id="paymentMethodForConfirmed" name="payment_method" class="form-control" required>
                <option value="" disabled {{ $selected===''?'selected':'' }}>Select Payment Method</option>
                @foreach($methods as $m)<option value="{{ $m }}" {{ strtoupper($selected)===$m?'selected':'' }}>{{ $m }}</option>@endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label"><i class="fas fa-balance-scale"></i> Remaining Amount</label>
              <input type="text" id="ConfirmedModalremainingAmountWithVat" name="remaining_amount" class="form-control" value="0" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label"><i class="fas fa-money-bill-wave"></i> Received Amount *</label>
              <input type="number" id="ConfirmedModalreceivedAmount" name="received_amount" class="form-control" min="0" required>
            </div>
            <div class="col-12">
              <label class="form-label"><i class="fas fa-upload"></i> Upload Payment Proof</label>
              <input type="file" id="ConfirmedModalpaymentProof" class="form-control" name="payment_proof" accept="image/png,image/jpg,image/jpeg,application/pdf">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveConfirmedModalButton" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="ChangeStatusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-circle-check text-info" style="color:#fff!important;"></i> Change Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" enctype="multipart/form-data" id="ChangeStatusModalForm">@csrf
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label class="form-label"><i class="fas fa-user"></i> Candidate Name</label>
              <input type="text" id="ChangeStatusModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="ChangeStatusModalcandidateId" name="candidate_id">
              <input type="hidden" name="trial_id" id="ChangeStatusModaltrial_id">
            </div>
            <div class="col-lg-6">
              <label class="form-label"><i class="fas fa-building"></i> Employer Name</label>
              <input type="text" name="employer_name" id="ChangeStatusModalclientName" class="form-control" readonly>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label"><i class="fas fa-calendar-day"></i> Change Status Date</label>
            <input type="date" id="ChangeStatusModalDate" class="form-control" name="change_status_date" value="{{ \Carbon\Carbon::now('Asia/Qatar')->format('Y-m-d') }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Change Status Proof (Include Visa + WC)</label>
            <input type="file" id="ChangeStatusModalproof" class="form-control" name="change_status_proof" accept="image/png,image/jpg,image/jpeg,application/pdf">
          </div>
          <div class="mb-3">
            <label class="form-label">Penality Payment Amount</label>
            <input type="text" id="penaltyPaymentAmount" class="form-control" name="penalty_payment_amount" placeholder="Enter penalty amount if any">
          </div>
          <div class="mb-3">
            <label class="form-label">Penality Payment Amount Proof (If Overstay)</label>
            <input type="file" id="penaltyPaymentProof" class="form-control" name="penalty_payment_proof" accept="image/png,image/jpg,image/jpeg,application/pdf">
          </div>
          <div class="mb-3">
            <label class="form-label">Penality Amount Paid By</label>
            <select id="penaltyPaidBy" name="penalty_paid_by" class="form-select">
              <option value="" disabled selected>Select who paid the penalty</option>
              <option value="Customer">Customer</option>
              <option value="Office">Office</option>
              <option value="Candidate">Candidate</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Istiraha Proof</label>
            <input type="file" id="istirahaProof" class="form-control" name="istiraha_proof" accept="image/png,image/jpg,image/jpeg,application/pdf">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveChangeStatusModalButton" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="TrialReturnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-clipboard-check text-info" style="color:#fff!important;"></i> Trial Return</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="TrialReturnModalForm" enctype="multipart/form-data" method="POST" novalidate>@csrf
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label"><i class="fas fa-user"></i> Candidate Name</label>
              <input type="text" id="TrialReturnModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="TrialReturnModalcandidateId" name="candidate_id">
              <input type="hidden" name="trial_id" id="TrialReturnModaltrial_id">
            </div>
            <div class="col-md-6">
              <label class="form-label"><i class="fas fa-building"></i> Employer Name</label>
              <input type="text" name="employer_name" id="TrialReturnModalclientName" class="form-control" readonly>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label"><i class="fas fa-exchange-alt"></i> Customer Decision</label>
            <div class="d-flex align-items-center gap-4">
              <div class="form-check form-check-inline">
                <input class="form-check-input js-decision" type="radio" name="action_type" id="ActionRefund" value="refund" checked>
                <label class="form-check-label" for="ActionRefund">Refund</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input js-decision" type="radio" name="action_type" id="ActionReplacement" value="replacement">
                <label class="form-check-label" for="ActionReplacement">Replacement</label>
              </div>
            </div>
          </div>
          <div id="DecisionContent" class="mt-2"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveTrialReturnButton" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="IncidentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-exclamation-triangle text-info" style="color:#fff!important;"></i> Incident</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="IncidentModalForm" method="POST" enctype="multipart/form-data">@csrf
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label class="form-label">Candidate Name</label>
              <input type="text" id="IncidentModalcandidateName" name="candidate_name" class="form-control" readonly>
              <input type="hidden" id="IncidentModalcandidateId" name="candidate_id">
              <input type="hidden" name="trial_id" id="IncidentModaltrialId">
              <input type="hidden" name="client_id" id="IncidentModalclientId">
              <input type="hidden" name="package_id" id="IncidentModalpackageId">
              <input type="hidden" name="cn_number" id="IncidentModalCN">
              <input type="hidden" name="type" id="IncidentModalType" value="trial">
            </div>
            <div class="col-lg-6">
              <label class="form-label">Employer Name</label>
              <input type="text" name="employer_name" id="IncidentModalclientName" class="form-control" readonly>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Upload Proof</label>
            <input type="file" id="IncidentProof" class="form-control" name="proof" accept=".pdf,.jpg,.jpeg,.png">
          </div>
          <div class="mb-3">
            <label class="form-label">Incident Type</label>
            <select id="incident_type" name="incident_type" class="form-select" required>
              <option value="">Select Type</option>
              <option value="RUNAWAY">RUNAWAY</option>
              <option value="REPATRIATION">REPATRIATION</option>
              <option value="UNFIT">UNFIT</option>
              <option value="REFUSED">REFUSED</option>
              <option value="SICK">SICK</option>
              <option value="PSYCHIATRIC">PSYCHIATRIC</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Incident Date</label>
            <input type="date" id="incident_date" name="incident_date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Remarks</label>
            <textarea id="IncidentRemarks" class="form-control" name="comments" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="saveIncidentButton" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="changeSalesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title"><i class="fas fa-user-gear me-2"></i> Change Sales Name</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-3">
        <div class="mb-2">Current: <strong id="sales-current-label">—</strong></div>
        <input type="hidden" id="sales-candidate-id">
        <input type="hidden" id="sales-trial-id">
        <input type="hidden" id="sales-current-id">
        <label class="sales-modal-label">Select Sales Officer</label>
        <select id="sales-select" class="form-select">
          @foreach($salesOfficers as $user)
            @php $full=trim(($user->first_name ?? '').' '.($user->last_name ?? '')); @endphp
            <option value="{{ $user->id }}">{{ $full }}</option>
          @endforeach
        </select>
        <div id="sales-consent" style="display:none;margin-top:10px">
          <div class="mb-2">Confirm change?</div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-success btn-sm" id="btn-consent-yes"><i class="fas fa-check"></i> Yes</button>
            <button type="button" class="btn btn-secondary btn-sm" id="btn-consent-no"><i class="fas fa-times"></i> No</button>
          </div>
        </div>
        <div id="sales-msg" class="mt-2"></div>
      </div>
    </div>
  </div>
</div>

<script>
  (function(){
    var csrfToken=$('meta[name="csrf-token"]').attr('content')||'{{ csrf_token() }}';
    var routes={
      updateTrialStatus:'{{ route("packages.updateTrialStatus") }}',
      saveTrialConfirmed:'{{ route("packages.saveTrialConfirmed") }}',
      updateChangeStatus:'{{ route("packages.updateChangeStatus") }}',
      saveTrialReturn:'{{ route("packages.saveTrialReturn") }}',
      saveReturnIncident:'{{ route("package.incidentSave") }}',
      incidentData:'{{ route("package.incidentData",":id") }}',
      updateSalesName:'{{ route("packages.updateTrialSalesName") }}',
      refundView:'{{ route("packages.refund-view") }}',
      replacementView:'{{ route("packages.replacement-view") }}'
    };

    function openDropdown(trialId){$('.dropdown-container').hide();$('#fullscreenOverlay').fadeIn(120);$('#dropdownContainer-'+trialId).css({display:'block',opacity:0}).animate({opacity:1},160);}
    function closeAllDropdowns(){$('.dropdown-container').fadeOut(120);$('#fullscreenOverlay').fadeOut(120);}

    function ensureSpinnerKeyframes(){if(!document.getElementById('preloader-spin-keyframes')){var s=document.createElement('style');s.id='preloader-spin-keyframes';s.textContent='@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}';document.head.appendChild(s);}}
    function showPreloader(){ensureSpinnerKeyframes();var h='<div id="preloader" style="position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(255,255,255,.8);display:flex;justify-content:center;align-items:center;z-index:2000"><div style="width:42px;height:42px;border:6px solid rgba(0,0,0,.1);border-top-color:#007bff;border-radius:50%;animation:spin 1s linear infinite;margin-bottom:10px"></div><p style="font-size:12px;color:#007bff;font-weight:bold;margin:0">Loading...</p></div>';$('body').append(h);}
    function hidePreloader(){$('#preloader').remove();}

    function trialChangeStatus(el,tid,cid,clid){
      var status=el.value;
      Swal.fire({title:'Change to "'+status+'"',text:'Are you sure?',icon:'warning',showCancelButton:true,confirmButtonText:'Yes',cancelButtonText:'No',confirmButtonColor:'#28a745',cancelButtonColor:'#dc3545'}).then(function(res){
        if(!res.isConfirmed)return;
        if(status==='Incident'){ closeAllDropdowns(); openIncidentModal(tid,cid,clid); }
        else{ updateTrialStatus(status,tid,cid,clid); }
      });
    }

    function updateTrialStatus(status,tid,cid,clid){
      showPreloader();
      $.ajax({url:routes.updateTrialStatus,type:'POST',headers:{'X-CSRF-TOKEN':csrfToken},data:{trial_id:tid,candidate_id:cid,client_id:clid,status:status}})
      .done(function(r){
        if(r.success){
          if(r.action==='open_modal'&&r.modal){ var m='#'+r.modal; $(m).modal('show'); fillModalFields(r.modal,r,tid); }
          else{ toastr.success(r.message||'Status updated'); setTimeout(function(){ location.reload(); },900); }
        }else{ toastr.error(r.message||'Failed to update'); }
      })
      .fail(function(xhr){ toastr.error((xhr.responseJSON&&xhr.responseJSON.message)||'An error occurred'); })
      .always(hidePreloader);
    }

    function buildInvoiceRows(invoices){
      var html='';(invoices||[]).forEach(function(i){
        var t=parseFloat(i.total_amount)||0,r=parseFloat(i.received_amount)||0,rem=t-r;
        html+='<tr><td>'+(i.invoice_date||'')+'</td><td>'+t.toFixed(2)+'</td><td>'+r.toFixed(2)+'</td><td>'+rem.toFixed(2)+'</td><td><a href="/invoices/'+(i.invoice_number||'')+'" target="_blank" class="btn btn-light btn-sm"><i class="fas fa-external-link-alt"></i> '+(i.invoice_number||'')+'</a></td></tr>';
      });
      return html;
    }

    function fillModalFields(modalId,data,trialId){
      var d=data.candidateDetails||{};
      if(modalId==='ConfirmedModal'){
        $('#trial_id').val(trialId||'');$('#ConfirmedModalcandidateId').val(d.candidateId||'');$('#ConfirmedModalcandidateName').val(d.candidateName||'');$('#ConfirmedModalclientName').val(d.clientName||'');
        if(typeof d.remainingAmountWithVat!=='undefined'){ $('#ConfirmedModalremainingAmountWithVat').val((parseFloat(d.remainingAmountWithVat)||0).toFixed(2)); }
        if(d.invoices&&d.invoices.length){ $('#InvoiceData').html('<table class="table table-striped"><thead><tr><th>Date</th><th>Total Amount</th><th>Received Amount</th><th>Remaining Amount</th><th>Invoice Reference #</th></tr></thead><tbody>'+buildInvoiceRows(d.invoices)+'</tbody></table>'); } else{ $('#InvoiceData').html('<p class="text-danger" style="font-size:12px">No invoices found.</p>'); }
      }
      if(modalId==='ChangeStatusModal'){
        $('#ChangeStatusModaltrial_id').val(trialId||'');$('#ChangeStatusModalcandidateId').val(d.candidateId||'');$('#ChangeStatusModalcandidateName').val(d.candidateName||'');$('#ChangeStatusModalclientName').val(d.clientName||'');
      }
      if(modalId==='TrialReturnModal'){
        $('#TrialReturnModaltrial_id').val(trialId||'');$('#TrialReturnModalcandidateId').val(d.candidateId||'');$('#TrialReturnModalcandidateName').val(d.candidateName||'');$('#TrialReturnModalclientName').val(d.clientName||'');
        $('#DecisionContent').html('');$('input[name="action_type"][value="refund"]').prop('checked',true);loadDecisionPartial('refund');
        var t=new Date();t.setHours(0,0,0,0);$('.js-trial-return').val(t.toISOString().slice(0,10)).trigger('change');
      }
      if(modalId==='IncidentModal'){
        $('#IncidentModaltrialId').val(trialId||'');$('#IncidentModalcandidateId').val(d.candidateId||'');$('#IncidentModalcandidateName').val(d.candidateName||'');$('#IncidentModalclientId').val(d.clientId||'');$('#IncidentModalclientName').val(d.clientName||'');
      }
    }

    $('#saveConfirmedModalButton').on('click',function(){
      var $btn=$(this),form=$('#ConfirmedModalForm')[0],fd=new FormData(form),ok=true;
      [['#ConfirmedModalclientName','Employer Name is required.'],['#ConfirmedModalDate','Confirmed Date is required.'],['#paymentMethodForConfirmed','Payment method is required.']].forEach(function(p){ if(!$(p[0]).val()||!String($(p[0]).val()).trim()){ ok=false; toastr.error(p[1]); }});
      if(!$('#ConfirmedModalpaymentProof')[0]||!$('#ConfirmedModalpaymentProof')[0].files.length){ ok=false; toastr.error('Payment proof is required.'); }
      if(!ok)return;
      $btn.prop('disabled',true);
      $.ajax({url:routes.saveTrialConfirmed,type:'POST',headers:{'X-CSRF-TOKEN':csrfToken},data:fd,processData:false,contentType:false})
      .done(function(resp){ if(resp.success){ toastr.success(resp.message||'Saved'); $('#ConfirmedModal').modal('hide'); $('#ConfirmedModalForm')[0].reset(); setTimeout(function(){ location.reload(); },900);} else{ toastr.error(resp.message||'Failed to save'); }})
      .fail(function(xhr){ var msg=(xhr.responseJSON&&(xhr.responseJSON.message||(xhr.responseJSON.errors&&Object.values(xhr.responseJSON.errors)[0][0]))); toastr.error(msg||'An error occurred'); })
      .always(function(){ $btn.prop('disabled',false); });
    });

    $('#saveChangeStatusModalButton').on('click',function(){
      var $btn=$(this),fd=new FormData($('#ChangeStatusModalForm')[0]);$btn.prop('disabled',true);
      $.ajax({url:routes.updateChangeStatus,type:'POST',headers:{'X-CSRF-TOKEN':csrfToken},data:fd,processData:false,contentType:false})
      .done(function(d){ if(d.success){ toastr.success(d.message||'Updated'); $('#ChangeStatusModal').modal('hide'); setTimeout(function(){ location.reload(); },900);} else{ toastr.error(d.message||'Failed to update'); }})
      .fail(function(xhr){ var msg=(xhr.responseJSON&&(xhr.responseJSON.message||(xhr.responseJSON.errors&&Object.values(xhr.responseJSON.errors)[0][0]))); toastr.error(msg||'An error occurred'); })
      .always(function(){ $btn.prop('disabled',false); });
    });

    function num(v){ var x=parseFloat((v||'').toString()); return isNaN(x)?0:x; }
    function dObj(s){ if(!s) return null; var d=new Date(s+'T00:00:00'); d.setHours(0,0,0,0); return isNaN(d)?null:d; }
    function isFridayLocal(d){ return d&&d.getDay()===5; }
    function minAfterDays(days){ var t=new Date(); t.setHours(0,0,0,0); return new Date(t.getTime()+days*86400000); }

    function enforceDueDateRules($field){
      var v=$field.val(); if(!v) return;
      var picked=dObj(v), min=minAfterDays(7);
      if(!picked || picked<min || isFridayLocal(picked)){
        toastr.error('Date must be at least 7 days from today and not Friday.');
        $field.val('');
      }
    }

    function loadDecisionPartial(kind){
      var cid=$('#TrialReturnModalcandidateId').val();
      var url=kind==='refund'?routes.refundView:routes.replacementView;
      $('#DecisionContent').html(''); showPreloader();
      $('#DecisionContent').load(url+'?candidate_id='+encodeURIComponent(cid),function(){
        hidePreloader();
        var ret=$('.js-trial-return').val()||'';
        $('#DecisionContent .js-trial-return').prop('readonly',false).val(ret).trigger('change');
        var $due=$('#DecisionContent [name="refund_due_date"], #DecisionContent [name="replacement_due_date"]');
        if($due.length){ var min=minAfterDays(7).toISOString().slice(0,10); $due.attr('type','date').attr('min',min); }
      });
    }

    $(document).on('change','.js-decision',function(){ var v=$(this).val(); if(v==='refund'||v==='replacement'){ loadDecisionPartial(v); }});
    $(document).on('change','.js-trial-return',function(){ var v=$(this).val()||''; $('#DecisionContent .js-trial-return').val(v).trigger('change'); });
    $(document).on('change','#DecisionContent [name="refund_due_date"], #DecisionContent [name="replacement_due_date"]',function(){ enforceDueDateRules($(this)); });

    $('#TrialReturnModal').on('shown.bs.modal',function(){
      $('input[name="action_type"][value="refund"]').prop('checked',true);
      loadDecisionPartial('refund');
      var t=new Date();t.setHours(0,0,0,0);$('.js-trial-return').val(t.toISOString().slice(0,10));
    });

    $('#saveTrialReturnButton').on('click',function(){
      var $btn=$(this),$form=$('#TrialReturnModalForm'),action=$('input[name="action_type"]:checked').val(),clientName=$('#TrialReturnModalclientName').val()||'';
      if(!action){ toastr.error('Please choose Refund or Replacement.'); return; }
      var ret=$('.js-trial-return').val(); if(!ret){ toastr.error('Return Date is required.'); return; }

      if(action==='refund'){
        var paidTotal=$('#DecisionContent [name="total_paid_amount"]').val();
        var salaryType=$('#DecisionContent [name="refund_worker_salary_type"]').val();
        var maidSalary=$('#DecisionContent [name="maid_salary"]').val();
        var refundBal=$('#DecisionContent [name="refund_balance"]').val();
        var reason=$('#DecisionContent [name="refund_reason_text"]').val();
        var due=$('#DecisionContent [name="refund_due_date"]').val();
        var dueDate=dObj(due), min=minAfterDays(7);
        if(!paidTotal){ toastr.error('Total Paid Amount is required.'); return; }
        if(!salaryType){ toastr.error('Worker Salary Status is required.'); return; }
        if(!maidSalary){ toastr.error('Worker Monthly Salary is required.'); return; }
        if(!refundBal){ toastr.error('Refund Balance is required.'); return; }
        if(!reason){ toastr.error('Refund Reason is required.'); return; }
        if(!dueDate||dueDate<min||isFridayLocal(dueDate)){ toastr.error('Refund Available Date must be at least 7 days ahead and not Friday.'); return; }
        var bankAmt=num($('#DecisionContent .js-bank-amount').val()); var proof=$('#DecisionContent .js-bank-proof')[0];
        if((salaryType==='OfficeBankTransfer') && (bankAmt<=0 || !proof || !proof.files || !proof.files.length)){ toastr.error('Enter bank transfer amount and upload proof.'); return; }
      }else{
        var rType=$('#DecisionContent [name="replacement_worker_salary_type"]').val();
        var rSalary=$('#DecisionContent [name="replacement_worker_salary_amount"]').val();
        var rBal=$('#DecisionContent [name="replacement_balance"]').val();
        var rReason=$('#DecisionContent [name="replacement_reason_text"]').val();
        var dueR=$('#DecisionContent [name="replacement_due_date"]').val();
        var dueDateR=dObj(dueR), minR=minAfterDays(7);
        if(!rType){ toastr.error('Worker Salary Status is required.'); return; }
        if(!rSalary){ toastr.error('Worker Monthly Salary is required.'); return; }
        if(!rBal){ toastr.error('Replacement Balance is required.'); return; }
        if(!rReason){ toastr.error('Replacement Reason is required.'); return; }
        var bankAmtR=num($('#DecisionContent .js-bank-amount').val()); var proofR=$('#DecisionContent .js-bank-proof')[0];
        if((rType==='OfficeBankTransfer') && (bankAmtR<=0 || !proofR || !proofR.files || !proofR.files.length)){ toastr.error('Enter bank transfer amount and upload proof.'); return; }
      }

      var fd=new FormData($form[0]);
      fd.set('action_type',action);
      fd.set('client_name',clientName);
      fd.set('trial_return_date',$('.js-trial-return').val());
      var finalVal=$('#DecisionContent .js-final').val()||'0';
      if(action==='refund'){ fd.set('refund_final_balance',finalVal); fd.delete('replacement_final_balance'); }
      else{ fd.set('replacement_final_balance',finalVal); fd.delete('refund_final_balance'); }

      $btn.prop('disabled',true);
      $.ajax({url:routes.saveTrialReturn,type:'POST',headers:{'X-CSRF-TOKEN':csrfToken},data:fd,processData:false,contentType:false})
      .done(function(d){ if(d.success){ toastr.success(d.message||'Saved successfully'); $('#TrialReturnModal').modal('hide'); setTimeout(function(){ location.reload(); },900);} else{ toastr.error(d.message||'Failed to save'); }})
      .fail(function(xhr){ var msg=(xhr.responseJSON&&(xhr.responseJSON.message||(xhr.responseJSON.errors&&Object.values(xhr.responseJSON.errors)[0][0]))); toastr.error(msg||'An error occurred'); })
      .always(function(){ $btn.prop('disabled',false); });
    });

    $('#saveIncidentButton').on('click',function(){
      var $btn=$(this),fd=new FormData($('#IncidentModalForm')[0]);$btn.prop('disabled',true);
      $.ajax({url:routes.saveReturnIncident,type:'POST',headers:{'X-CSRF-TOKEN':csrfToken},data:fd,processData:false,contentType:false})
      .done(function(d){ if(d.success){ toastr.success(d.message||'Incident saved'); $('#IncidentModal').modal('hide'); $('#IncidentModalForm')[0].reset(); setTimeout(function(){ location.reload(); },900);} else{ toastr.error(d.message||'Failed to save Incident'); }})
      .fail(function(xhr){ var msg=(xhr.responseJSON&&(xhr.responseJSON.message||(xhr.responseJSON.errors&&Object.values(xhr.responseJSON.errors)[0][0]))); toastr.error(msg||'An error occurred'); })
      .always(function(){ $btn.prop('disabled',false); });
    });

    function openIncidentModal(trialId,candidateId,clientId){
      $.ajax({
        url: routes.incidentData.replace(':id', trialId),
        type: 'GET'
      })
      .done(function(resp){
        $('#IncidentModaltrialId').val(resp.trial_id||trialId);
        $('#IncidentModalcandidateId').val(resp.candidate_id||candidateId);
        $('#IncidentModalcandidateName').val(resp.candidate_name||'');
        $('#IncidentModalclientId').val(resp.client_id||clientId);
        $('#IncidentModalclientName').val(resp.client_name||'');
        $('#IncidentModalpackageId').val(resp.package_id||'');
        $('#IncidentModalCN').val(resp.cn_number||'');
        $('#incident_type').val(resp.incident_type||'');
        $('#incident_date').val(resp.incident_date||'');
        $('#IncidentRemarks').val(resp.comments||'');
      })
      .fail(function(){
        toastr.error('Unable to load incident data.');
      })
      .always(function(){
        $('#IncidentModal').modal('show');
      });
    }

    var salesModalInstance=null;
    function getSalesModal(){
      if(window.bootstrap&&bootstrap.Modal){
        if(!salesModalInstance){ salesModalInstance=new bootstrap.Modal(document.getElementById('changeSalesModal')); }
        return{type:'bs5',inst:salesModalInstance};
      }else{
        return{type:'jq',inst:$('#changeSalesModal')};
      }
    }

    $(document).on('click','.js-open-sales-modal',function(){
      var canChange=$(this).data('can-change')==='1'||$(this).data('can-change')===1; if(!canChange){ alert('You do not have permission to update.'); return; }
      var modal=getSalesModal(),cid=$(this).data('candidate-id'),tid=$(this).data('trial-id'),curId=parseInt($(this).data('current-id'))||0,curLabel=($(this).data('current-label')||'NOT ASSIGNED').toString();
      window.__lastSalesBtn=$(this);$('#sales-candidate-id').val(cid);$('#sales-trial-id').val(tid||'');$('#sales-current-id').val(curId);$('#sales-current-label').text(curLabel);$('#sales-select').val(curId);$('#sales-consent').hide();$('#sales-msg').removeClass().text('');
      if(modal.type==='bs5'){ modal.inst.show(); } else{ modal.inst.modal('show'); }
    });

    $('#sales-select').on('change',function(){ var n=parseInt($(this).val())||0,c=parseInt($('#sales-current-id').val())||0; if(n!==c){ $('#sales-consent').show(); } else{ $('#sales-consent').hide(); } });
    $('#btn-consent-no').on('click',function(){ $('#sales-select').val($('#sales-current-id').val());$('#sales-consent').hide();$('#sales-msg').removeClass().text(''); });
    $('#btn-consent-yes').on('click',function(){
      var cid=$('#sales-candidate-id').val(),tid=$('#sales-trial-id').val(),nid=$('#sales-select').val();$('#sales-msg').removeClass().text('Saving...');
      $.post(routes.updateSalesName,{candidate_id:cid,trial_id:tid,sales_name:nid,_token:csrfToken})
      .done(function(res){
        var label=(res.display_name||$('#sales-select option:selected').text()||'Not assigned').toUpperCase();
        $('#sales-current-id').val(nid);$('#sales-current-label').text(label);
        if(window.__lastSalesBtn&&window.__lastSalesBtn.length){
          window.__lastSalesBtn.data('current-id',parseInt(nid));
          window.__lastSalesBtn.data('current-label',label);
          window.__lastSalesBtn.find('.js-sales-label').text(label);
        }
        $('#sales-msg').addClass('text-success').text(res.message||'Updated successfully.');
        var m=getSalesModal(); setTimeout(function(){ if(m.type==='bs5'){ m.inst.hide(); } else{ $('#changeSalesModal').modal('hide'); } },350);
      })
      .fail(function(xhr){ $('#sales-msg').addClass('text-danger').text((xhr.responseJSON&&xhr.responseJSON.message)?xhr.responseJSON.message:'Failed to update.'); });
    });

    $(document).on('hidden.bs.modal','.modal',function(){ $('.modal-backdrop').remove();$('body').removeClass('modal-open').css({overflow:'auto',paddingRight:''}); });

    window.openDropdown=openDropdown;
    window.closeAllDropdowns=closeAllDropdowns;
    window.trialChangeStatus=trialChangeStatus;
    window.openIncidentModal=openIncidentModal;
  })();

  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el){ if(window.bootstrap&&bootstrap.Tooltip){ new bootstrap.Tooltip(el); } });
</script>
