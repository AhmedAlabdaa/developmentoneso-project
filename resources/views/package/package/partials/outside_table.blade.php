<style>
    .table-container{width:100%;overflow-x:auto;position:relative}
    .table{width:100%;border-collapse:collapse}
    .table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .table th{background-color:#343a40;color:#fff;text-transform:uppercase;font-weight:bold}
    .table-hover tbody tr:hover{background-color:#f1f1f1}
    .table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}
    .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
    .btn-info{background-color:#17a2b8}
    .btn-warning{background-color:#ffc107}
    .btn-danger{background-color:#dc3545}
    .attachments-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:20px;margin-top:10px}
    .attachment-item{text-align:center}
    .attachment-item p{margin-top:5px;font-size:12px}
    .img-thumbnail{max-width:100px;max-height:100px;object-fit:cover}
    .bg-gradient-primary{background:linear-gradient(to right,#007bff,#6a11cb)}
    .btn-sm{font-size:.8rem}
    .table-warning{background-color:#fff3cd!important}
    .appeal-blink{animation:blink-animation 1.5s infinite;font-weight:bold;color:#000}
    @keyframes blink-animation{0%{opacity:1}50%{opacity:.5}100%{opacity:1}}
    .pagination-controls{display:flex;justify-content:center;margin:10px 0;align-items:center;gap:20px}
    .pagination-controls i{font-size:12px;cursor:pointer;color:#343a40}
    .pagination-controls i.disabled{color:#ccc;cursor:not-allowed}
    .fullscreen-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,.5);z-index:1049}
    .dropdown-container{display:none;position:fixed;z-index:1050;background-color:#fff;border-radius:8px;padding:20px;box-shadow:0 8px 12px rgba(0,0,0,.2);min-width:350px;max-width:450px;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border:4px solid #007bff;animation:fadeIn .3s ease-in-out}
    .dropdown-header{margin-bottom:15px}
    .dropdown-header .header-icon{font-size:24px;color:#007bff;margin-bottom:10px}
    .dropdown-header p{font-size:12px;font-weight:bold;color:#333;margin:5px 0;line-height:1.5}
    .candidate-name{color:#007bff;font-weight:bold;font-size:12px}
    .status-dropdown{width:100%;margin-top:10px;font-size:12px;border:2px solid #007bff;border-radius:6px;outline:none;background-color:#fff;color:#333}
    .close-icon{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer;transition:color .3s ease}
    .close-icon:hover{color:#ff4500}
    @keyframes fadeIn{from{opacity:0;transform:translate(-50%,-55%)}to{opacity:1;transform:translate(-50%,-50%)}}
    .dropdown-container .fa-times{cursor:pointer;margin-left:10px;color:#888;font-size:12px}
    .icon-wrapper{display:flex;justify-content:center;align-items:center;width:20px;height:20px;border-radius:50%;background-color:#f0f0f0;box-shadow:0 4px 6px rgba(0,0,0,.1);transition:background-color .3s ease,transform .3s ease;cursor:pointer}
    .icon-wrapper i{font-size:12px;color:#555}
    .icon-wrapper:hover{background-color:#007bff;transform:scale(1.1)}
    .icon-wrapper:hover i{color:#fff}
    .icon-wrapper .disabled{cursor:not-allowed;opacity:.5}
    .icon-wrapper .disabled:hover{transform:none;background-color:#f0f0f0}
    .office-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff}
    .office-modal .modal-header h5{margin:0;font-weight:600}
    .office-modal label{font-weight:500;margin-bottom:3px}
    .office-modal .form-control,.office-modal .form-select{font-size:14px}
    .scrollable-modal-body{max-height:70vh;overflow-y:auto}
    .custom-modal .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3);font-family:Arial,sans-serif;font-size:12px;background:#fff}
    .custom-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0}
    .custom-modal .modal-header h5,.custom-modal .modal-header h4{font-size:12px;font-weight:bold;margin:0;color:#fff}
    .custom-modal .modal-header .btn-close{font-size:1.2rem}
    .custom-modal .modal-header .btn-close:hover{opacity:1;transform:scale(1.1)}
    .custom-modal .modal-body{color:#333;background:#f9f9f9}
    .custom-modal .modal-footer{padding:15px;border-top:1px solid #ddd;border-radius:0 0 12px 12px;background:#f1f1f1}
    .custom-modal .modal-footer .btn{font-size:12px;padding:8px 15px;border-radius:5px;transition:all .3s}
    .custom-modal .modal-footer .btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:none}
    .custom-modal .modal-footer .btn-primary:hover{background:#0056b3;color:#fff}
    .custom-modal .modal-footer .btn-secondary{background:#6c757d;color:#fff;border:none}
    .custom-modal .modal-footer .btn-secondary:hover{background:#565e64;color:#fff}
    .custom-modal .table{margin-bottom:0;font-size:12px;color:#333}
    .custom-modal .table thead th{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;font-size:12px;font-weight:bold;text-transform:uppercase;text-align:center}
    .custom-modal .table td,.custom-modal .table th{padding:10px;text-align:left;white-space:nowrap}
    .kv-grid{display:grid;grid-template-columns:150px 1fr;gap:8px 16px}
    .kv-label{font-weight:600;color:#333}
    .kv-value{color:#000}
    .kv-wrap{border:1px solid #e3e6ea;border-radius:8px;padding:12px;background:#fafafa}
    .is-invalid{border-color:#dc3545!important}
    .invalid-feedback{display:none;color:#dc3545;font-size:.875rem;margin-top:.25rem}
    .show-feedback{display:block}
    .btn-sales{display:inline-flex;align-items:center;gap:6px;border:1px solid #0d6efd;background:#fff;color:#0d6efd;border-radius:8px;padding:6px 10px;font-size:12px}
    .btn-sales i{font-size:12px}
    .sales-consent{display:none;margin-top:10px}
    .sales-consent.show{display:block}
    .sales-modal-select{font-size:12px;line-height:1.3;padding:.375rem .75rem}
    .sales-modal-label{font-size:12px}
    .custom-modal .modal-title i{font-size:12px}
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th title="CN #">CN #</th>
                <th title="Sales Name">Sales Name</th>
                <th title="Status Date">Status Date</th>
                <th title="Candidate Name">Candidate Name</th>
                <th title="Nationality">Nationality</th>
                <th title="Passport Number">Passport #</th>
                <th title="labor-ID">labor-ID</th>
                <th title="Passport Expiry Date">Passport Exp</th>
                <th title="Date of Birth">DOB</th>
                <th title="Agent Name">Agent Name</th>
                <th title="Visa Type">Visa Type</th>
                <th title="Client #">CL #</th>
                <th title="Sponsor Name">Sponsor Name</th>
                <th title="Sponsor QID">Sponsor QID</th>
                <th title="Application Date">Application Date</th>
                <th title="BOA/WC Status">BOA/WC Status</th>
                <th title="Expected Arrival Date">Expected Arrival Date</th>
                <th title="VP Number">VP Number</th>
                <th title="Selection Type">Selection Type</th>
                <th title="Visa Status">Visa Status</th>
                <th title="Remarks">Remarks</th>
                <th title="Action">Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($packages as $candidate)
            @php
                $statusDateMap = [
                  1 => $candidate->updated_at,
                  2 => $candidate->backout_date,
                  3 => $candidate->hold_date,
                  4 => $candidate->selected_date,
                  5 => $candidate->wc_added_date,
                  6 => $candidate->incident_before_visa_date,
                  7 => $candidate->visa_added_date,
                  8 => $candidate->incident_after_visa_date,
                  9 => $candidate->medical_status_date,
                  10 => $candidate->coc_status_date,
                  11 => $candidate->l_submitted_date,
                  12 => $candidate->l_issued_date,
                  13 => $candidate->departure_date,
                  14 => $candidate->incident_after_departure_date,
                  15 => $candidate->arrived_added_date,
                  16 => $candidate->incident_after_arrival_date,
                  17 => $candidate->transfer_added_date,
                ];
                $dateToShow = $statusDateMap[$candidate->current_status] ?? $candidate->updated_at;

                $partnerPrefix = strtoupper(explode(' ', (string)$candidate->foreign_partner, 2)[0] ?? '');
                $partnerSuffixRaw = trim(substr((string) $candidate->foreign_partner, strrpos((string) $candidate->foreign_partner, '-') + 1));
                $partnerSuffix = $partnerSuffixRaw ? implode('', array_map(fn($w) => strtoupper($w[0]), explode(' ', $partnerSuffixRaw))) : 'HO';
                $partnerCode = trim($partnerPrefix) ? $partnerPrefix . '-' . $partnerSuffix : $partnerSuffix;

                $crm = $candidate->agreement?->client;
                $first = $crm?->first_name ?? '';
                $last  = $crm?->last_name ?? '';
                $sponsorName = trim("$first $last");
                $visaStatus = $candidate->agreement->visa_status ?? null;
                $status = $candidate->agreement->status ?? null;
                $statusMap = [
                    1 => ['text' => 'Pending',   'class' => 'st st-pending st-pulse', 'icon' => '…'],
                    2 => ['text' => 'Approved',  'class' => 'st st-approved',         'icon' => '✔'],
                    3 => ['text' => 'Hold',      'class' => 'st st-hold',             'icon' => '⏸'],
                    4 => ['text' => 'Cancelled', 'class' => 'st st-cancelled',        'icon' => '✖'],
                ];
                $host = request()->getHost() ?? parse_url(url('/'), PHP_URL_HOST);
                $subdomain = strtolower(explode('.', $host)[0] ?? '');
            @endphp
            <tr>
                <td>{{ strtoupper($candidate->CN_Number ?? 'N/A') }}</td>
                <td>
                  <span class="name-with-badge">
                    {{ strtoupper(optional($candidate->sales)->first_name) ?: 'N/A' }}
                    <span class="l-badge" aria-label="L">L</span>
                  </span>
                </td>
                <td class="text-nowrap text-center">
                  <div>{{ strtoupper(\Carbon\Carbon::parse($dateToShow)->format('d-M-Y')) }}</div>
                  <div>{{ strtoupper(\Carbon\Carbon::parse($dateToShow)->format('h:i A')) }}</div>
                </td>
                <td>
                  @php
                    $fullName   = $candidate->candidate_name ?: 'N/A';
                    $titleName  = $candidate->candidate_name ? \Illuminate\Support\Str::title(strtolower($fullName)) : 'N/A';
                    $displayName = $candidate->candidate_name ? strtoupper(\Illuminate\Support\Str::limit($titleName, 25, '…')) : 'N/A';
                  @endphp
                  <a style="color:#007bff!important" href="{{ route('candidates.show', $candidate->reference_no) }}" target="_blank" class="text-decoration-none text-dark" title="{{ $titleName }}">
                    {{ $displayName }}
                  </a>
                  <img src="{{ asset('assets/img/attach.png') }}" alt="Attachment" style="cursor:pointer;margin-left:8px;vertical-align:middle;height:20px" onclick="showCandidateModal('{{ $candidate->candidate_name }}','{{ $candidate->id }}','{{ $candidate->reference_no }}')">
                </td>
                <td>{{ strtoupper(optional($candidate->Nationality)->name ?? 'N/A') }}</td>
                <td>{{ strtoupper($candidate->passport_no ?? 'N/A') }}</td>
                <td>{{ strtoupper($candidate->labour_id_number ?? 'N/A') }}</td>
                <td>{{ $candidate->passport_expiry_date ? strtoupper(\Carbon\Carbon::parse($candidate->passport_expiry_date)->format('d M Y')) : 'N/A' }}</td>
                <td>{{ $candidate->date_of_birth ? strtoupper(\Carbon\Carbon::parse($candidate->date_of_birth)->format('d M Y')) : 'N/A' }}</td>
                <td>{{ strtoupper($partnerCode) }}</td>
                <td>{{ strtoupper($candidate->agreement->visa_type ?? 'N/A') }}</td>
                <td>
                  @if ($candidate->agreement && $candidate->agreement->client?->slug)
                    <a style="color:#007bff!important" href="{{ route('crm.show', $candidate->agreement->client->slug) }}" target="_blank" class="text-decoration-none">
                      {{ strtoupper($candidate->agreement->CL_Number ?? 'N/A') }}
                    </a>
                  @else
                    {{ strtoupper($candidate->agreement->CL_Number ?? 'N/A') }}
                  @endif
                </td>
                <td>
                  @if ($candidate->agreement && $candidate->agreement->client?->slug)
                    <a style="color:#007bff!important" href="{{ route('crm.show', $candidate->agreement->client->slug) }}" target="_blank">
                      {{ $sponsorName !== '' ? strtoupper($sponsorName) : 'N/A' }}
                    </a>
                  @else
                    {{ $sponsorName !== '' ? strtoupper($sponsorName) : 'N/A' }}
                  @endif
                </td>
                <td>{{ $crm?->emirates_id ?? 'N/A' }}</td>
                <td>{{ $candidate->agreement->created_at ? strtoupper(\Carbon\Carbon::parse($candidate->agreement->created_at)->format('d M Y')) : 'N/A' }}</td>
                <td>
                  @if (isset($statusMap[$status]))
                    <span class="{{ $statusMap[$status]['class'] }}">
                      <span class="st-ic">{{ $statusMap[$status]['icon'] }}</span>
                      {{ $statusMap[$status]['text'] }}
                    </span>
                  @else
                    N/A
                  @endif
                </td>
                <td>{{ $candidate->agreement->expected_arrival_date ? strtoupper(\Carbon\Carbon::parse($candidate->agreement->expected_arrival_date)->format('d M Y')) : 'N/A' }}</td>
                <td>{{ strtoupper($candidate->agreement->vp_number ?? 'No Customer Quota') }}</td>
                <td>{{ strtoupper($candidate->agreement->selection_type ?? 'N/A') }}</td>
                <td>
                  @if ($candidate->agreement)
                    <button type="button" class="btn btn-sm btn-outline-primary visa-status-btn" data-bs-toggle="modal" data-bs-target="#visaStatusModal" data-agreement-id="{{ $candidate->agreement->id }}" data-vp-number="{{ $candidate->agreement->vp_number ?? 'N/A' }}" data-current-status="{{ $visaStatus ?? '' }}" data-update-url="{{ route('agreements.update-visa-status', $candidate->agreement->id) }}">
                      {{ strtoupper($visaStatus ?? 'SET STATUS') }}
                    </button>
                  @else
                    N/A
                  @endif
                </td>
                <td>{{ strtoupper($candidate->agreement->notes ?? 'N/A') }}</td>
                <td>
                  @php
                    $modalKey = preg_replace('/[^A-Za-z0-9\-]/', '', (string)($candidate->CN_Number ?? 'CN'));
                  @endphp
                  @if ($subdomain === 'vienna')
                    <a href="javascript:void(0);" class="btn btn-secondary btn-icon-only ms-1" title="Transfer Candidate" data-bs-toggle="modal" data-bs-target="#transferModal-{{ $modalKey }}">
                        <i class="fas fa-exchange-alt"></i>
                    </a>
                  @endif
                </td>
            </tr>
            <div class="modal fade custom-modal" id="transferModal-{{ $modalKey }}" tabindex="-1" aria-labelledby="transferModalLabel-{{ $modalKey }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title d-flex align-items-center" id="transferModalLabel-{{ $modalKey }}"><i class="fas fa-exchange-alt me-2" style="color:#fff"></i> Transfer Candidate</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="kv-wrap">
                                <div class="kv-grid">
                                    <div class="kv-label">Transfer</div>
                                    <div class="kv-value">{{ strtoupper($candidate->CN_Number) }}</div>
                                    <div class="kv-label">Candidate Name</div>
                                    <div class="kv-value">{{ $candidate->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->candidate_name))) : 'N/A' }}</div>
                                    <div class="kv-label">Passport No</div>
                                    <div class="kv-value">{{ strtoupper($candidate->passport_no) }}</div>
                                    <div class="kv-label">Foreign Partner</div>
                                    <div class="kv-value">{{ strtoupper($candidate->foreign_partner) }}</div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Transfer to the Branch</label>
                                <select class="form-select" id="transferBranch-{{ $modalKey }}" required>
                                    <option value="" selected>Choose Branch</option>
                                    <option value="Rozana Manpower">Rozana Manpower</option>
                                    <option value="Middleeast Manpower">Middleeast Manpower</option>
                                </select>
                                <div class="invalid-feedback" id="branchError-{{ $modalKey }}">Please choose a branch.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary transfer-save-btn" data-ref="{{ $modalKey }}"><i class="fas fa-save me-1"></i> Transfer Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <tr>
              <td class="text-center text-muted" colspan="21">No results found.</td>
            </tr>
        @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th title="CN #">CN #</th>
                <th title="Sales Name">Sales Name</th>
                <th title="Status Date">Status Date</th>
                <th title="Candidate Name">Candidate Name</th>
                <th title="Nationality">Nationality</th>
                <th title="Passport Number">Passport #</th>
                <th title="labor-ID">labor-ID</th>
                <th title="Passport Expiry Date">Passport Exp</th>
                <th title="Date of Birth">DOB</th>
                <th title="Agent Name">Agent Name</th>
                <th title="Visa Type">Visa Type</th>
                <th title="Client #">CL #</th>
                <th title="Sponsor Name">Sponsor Name</th>
                <th title="Sponsor QID">Sponsor QID</th>
                <th title="Application Date">Application Date</th>
                <th title="BOA/WC Status">BOA/WC Status</th>
                <th title="Expected Arrival Date">Expected Arrival Date</th>
                <th title="VP Number">VP Number</th>
                <th title="Selection Type">Selection Type</th>
                <th title="Visa Status">Visa Status</th>
                <th title="Remarks">Remarks</th>
                <th title="Action">Action</th>
            </tr>
        </tfoot>
    </table>
</div>

<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">Showing {{ $packages->firstItem() }} to {{ $packages->lastItem() }} of {{ $packages->total() }} results</span>
        <ul class="pagination justify-content-center">
            {{ $packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>

<div class="modal fade office-modal" id="officeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-building me-2"></i> Office Details</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close" onclick="$('#officeModal').modal('hide');"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-info-circle me-2"></i>Information</h6>
                    <table class="table table-bordered">
                        <tbody>
                            <tr><th style="width:30%" class="bg-secondary text-white"><i class="fas fa-user"></i> Sales Name</th><td id="office_sales_name"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-handshake"></i> Partner</th><td id="office_partner"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-hashtag"></i> CN Number</th><td id="office_cn_number"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-hashtag"></i> CL Number</th><td id="office_cl_number"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-passport"></i> Visa Type</th><td id="office_visa_type"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-info-circle"></i> Visa Status</th><td id="office_visa_status"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-box-open"></i> Package</th><td id="office_package_value"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-plane-arrival"></i> Arrived Date</th><td id="office_arrived_date"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-exchange-alt"></i> Transfer Date</th><td id="office_transferred_date"></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-edit me-2"></i>Form</h6>
                    <form id="officeForm">
                        <input type="hidden" name="package_id" id="package_id" value="">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category">Category</label>
                                <select id="category" name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Unfit">Unfit</option>
                                    <option value="Sales Return">Sales Return</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="returned_date">Returned Date</label>
                                <input type="date" name="returned_date" id="returned_date" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="ica_proof_attachment">ICA Proof Attachment</label>
                                <input type="file" name="ica_proof_attachment" id="ica_proof_attachment" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="overstay_days">Overstay Days</label>
                                <input type="number" name="overstay_days" id="overstay_days" class="form-control" value="0">
                            </div>
                            <div class="col-md-6">
                                <label for="fine_amount">Fine Amount</label>
                                <input type="number" name="fine_amount" id="fine_amount" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="passport_status" class="form-label">Passport Status</label>
                                <select id="passport_status" name="passport_status" class="form-select">
                                    <option value="">Select Passport Status</option>
                                    <option value="With Employer">With Employer</option>
                                    <option value="With Candidate">With Candidate</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Office">Office</option>
                                    <option value="Lost">Lost</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="$('#officeModal').modal('hide');"><i class="fas fa-times me-1"></i> Close</button>
                            <button type="button" id="saveOfficeBtn" class="btn btn-success" onclick="saveOfficeData()"><i class="fas fa-save me-1"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade office-modal" id="incidentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Incident Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="$('#incidentModal').modal('hide');"></button>
      </div>
      <div class="modal-body">
        <form id="incidentForm">
          @csrf
          <input type="hidden" name="candidate_id" id="incident_candidate_id">
          <input type="hidden" name="cn_number" id="incident_cn_number">
          <input type="hidden" name="type" id="incident_scope" value="trial">
          <div class="mb-3">
            <label for="incident_type">Incident Type</label>
            <select id="incident_type" name="incident_type" class="form-select" required>
              <option value="">Select Type</option>
              <option value="RUNAWAY">RUNAWAY</option>
              <option value="REPATRIATION">REPATRIATION</option>
              <option value="UNFIT">UNFIT</option>
              <option value="REFUSED">REFUSED</option>
              <option value="PSYCHIATRIC">PSYCHIATRIC</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="incident_date">Incident Date</label>
            <input type="date" id="incident_date" name="incident_date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="incident_comments">Comments</label>
            <textarea id="incident_comments" name="comments" class="form-control" rows="3"></textarea>
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

<div class="modal fade" id="attachmentsModal" tabindex="-1" aria-labelledby="attachmentsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary text-white">
        <h5 class="modal-title" id="attachmentsModalLabel">Attachments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body scrollable-modal-body">
        <p class="text-center text-muted">Loading attachments...</p>
      </div>
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
                <div class="mb-2"><span class="sales-modal-label">Current:</span> <strong id="sales-current-label">—</strong></div>
                <input type="hidden" id="sales-candidate-id" value="">
                <input type="hidden" id="sales-current-id" value="">
                <label for="sales-select" class="sales-modal-label">Select Sales Officer</label>
                <select id="sales-select" class="form-select sales-modal-select">
                    @foreach($salesOfficers as $user)
                        @php $full = trim(($user->first_name ?? '').' '.($user->last_name ?? '')); @endphp
                        <option value="{{ $user->id }}">{{ $full }}</option>
                    @endforeach
                </select>
                <div id="sales-msg" class="mt-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Close</button>
                <button type="button" class="btn btn-primary" id="sales-save-btn"><i class="fas fa-save me-1"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<script>
  const csrfToken='{{ csrf_token() }}';

  function openOfficeModal(packageId){
    $('#office_sales_name,#office_partner,#office_cn_number,#office_cl_number,#office_visa_type,#office_visa_status,#office_package_value,#office_arrived_date,#office_transferred_date').text('');
    $('#package_id').val(packageId);
    $('#officeForm')[0].reset();
    $.ajax({
      url:"{{ route('package.officeData',':id') }}".replace(':id',packageId),
      type:"GET",
      headers:{'X-CSRF-TOKEN':csrfToken},
      dataType:"json",
      success:function(r){
        $('#office_sales_name').text(r.sales_name?r.sales_name.toUpperCase():'N/A');
        $('#office_partner').text(r.partner?r.partner.toUpperCase():'N/A');
        $('#office_cn_number').text(r.cn_number?r.cn_number.toUpperCase():'N/A');
        $('#office_cl_number').text(r.cl_number?r.cl_number.toUpperCase():'N/A');
        $('#office_visa_type').text(r.visa_type?r.visa_type.toUpperCase():'N/A');
        $('#office_visa_status').text(r.visa_status?r.visa_status.toUpperCase():'N/A');
        $('#office_package_value').text(r.package?r.package.toUpperCase():'N/A');
        $('#office_arrived_date').text(r.arrived_date?r.arrived_date:'N/A');
        $('#office_transferred_date').text(r.transferred_date?r.transferred_date:'N/A');
        $('#officeModal').modal('show');
      },
      error:function(){}
    });
  }

  function saveOfficeData(){
    const formData=new FormData(document.getElementById('officeForm'));
    $.ajax({
      url:"{{ route('package.officeSave') }}",
      type:"POST",
      headers:{'X-CSRF-TOKEN':csrfToken},
      data:formData,
      processData:false,
      contentType:false,
      success:function(){
        $('#officeModal').modal('hide');
        location.reload();
      },
      error:function(){}
    });
  }

  function openDropdown(candidateId){
    $('.dropdown-container').hide();
    $('#fullscreenOverlay').fadeIn();
    const dropdownContainer=$('#dropdownContainer-'+candidateId);
    dropdownContainer.css({display:'block',opacity:0}).animate({opacity:1},300);
  }

  function closeAllDropdowns(){
    $('.dropdown-container').fadeOut();
    $('#fullscreenOverlay').fadeOut();
  }

  function confirmStatusChange(selectElement,candidateId){
    if(selectElement.value==1){
      closeAllDropdowns();
      openOfficeModal(candidateId);
    }else if(selectElement.value==5){
      closeAllDropdowns();
      const cnNumber=$(selectElement).data('cn');
      openIncidentModal(candidateId,cnNumber,'trial');
    }
  }

  function openIncidentModal(packageId,cnNumber,scope){
    $('#incident_candidate_id').val(packageId);
    $('#incident_cn_number').val(cnNumber);
    $('#incident_scope').val(scope||'trial');
    $('#incident_type').val('');
    $('#incident_date').val('');
    $('#incident_comments').val('');
    $.ajax({
      url:"{{ route('package.incidentData',':id') }}".replace(':id',packageId),
      type:"GET",
      headers:{'X-CSRF-TOKEN':csrfToken},
      dataType:"json",
      success:function(r){
        $('#incident_candidate_id').val(r.candidate_id||packageId);
        $('#incident_cn_number').val(r.cn_number||cnNumber||'');
        $('#incident_type').val(r.incident_type||'');
        $('#incident_date').val(r.incident_date||'');
        $('#incident_comments').val(r.comments||'');
        $('#incidentModal').modal('show');
      },
      error:function(){
        $('#incidentModal').modal('show');
      }
    });
  }

  function saveIncidentData(){
    const $btn=$('#saveIncidentBtn');
    const form=document.getElementById('incidentForm');
    const formData=new FormData(form);
    if(!formData.get('type')) formData.set('type',$('#incident_scope').val()||'trial');
    $btn.prop('disabled',true);
    $.ajax({
      url:"{{ route('package.incidentSave') }}",
      type:"POST",
      headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
      data:formData,
      processData:false,
      contentType:false,
      dataType:"json"
    })
    .done(function(){
      $('#incidentModal').modal('hide');
      location.reload();
    })
    .fail(function(){})
    .always(function(){ $btn.prop('disabled',false); });
  }

  function showCandidateModal(candidateName,candidateId,referenceNo,passportNo){
    $('#attachmentsModalLabel').text('Attachments' + ((candidateName||referenceNo)?' for '+(candidateName||'Candidate')+(referenceNo?' ('+referenceNo+')':''):''));
    $('#attachmentsModal .modal-body').html('<div class="py-5 text-center"><div class="spinner-border" role="status"></div><div class="mt-2 text-muted">Loading attachments...</div></div>');
    $('#attachmentsModal').modal('show');
    $.ajax({
      url:'{{ route('package.loadimages') }}',
      type:'GET',
      headers:{'X-CSRF-TOKEN':csrfToken},
      dataType:'json',
      data:{id:candidateId,passport_no:passportNo||''},
      success:function(r){
        if(r&&r.success){
          $('#attachmentsModal .modal-body').html(r.html);
        }else{
          $('#attachmentsModal .modal-body').html('<p class="text-center text-muted">No attachments found.</p>');
        }
      },
      error:function(){
        $('#attachmentsModal .modal-body').html('<p class="text-center text-muted">Unable to load attachments. Please try again later.</p>');
      }
    });
  }

  function confirmDelete(id){
    if(confirm('Are you sure you want to delete this record?')){
      $('#delete-form-'+id).submit();
    }
  }

  $(document).on('click','.transfer-save-btn',function(){
        var btn=$(this);
        var ref=btn.data('ref');
        var select=$(`#transferBranch-${ref}`);
        var err=$(`#branchError-${ref}`);
        select.removeClass('is-invalid'); err.removeClass('show-feedback');
        if(!select.val()){
            select.addClass('is-invalid');
            err.addClass('show-feedback');
            return;
        }
        var transferBranch=select.val();
        var endpoint="{{ route('package.branch-transfer-package') }}";
        btn.prop('disabled',true).html('<i class="fas fa-spinner fa-spin me-1"></i> Transferring');
        $.ajax({
            url:endpoint,
            method:'POST',
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            data:{ref_no:ref,transferBranch:transferBranch},
            success:function(resp){
                btn.prop('disabled',false).html('<i class="fas fa-save me-1"></i> Transfer Save');
                $(`#transferModal-${ref}`).modal('hide');
                alert((resp&&resp.message)?resp.message:'Transfer completed successfully.');
            },
            error:function(xhr){
                btn.prop('disabled',false).html('<i class="fas fa-save me-1"></i> Transfer Save');
                var msg='Transfer failed.';
                if(xhr&&xhr.responseJSON&&xhr.responseJSON.message){msg=xhr.responseJSON.message}
                alert(msg);
            }
        });
    });

  let salesModalInstance=null,lastSalesBtn=null;
  function getSalesModal(){
      if(window.bootstrap&&bootstrap.Modal){
          if(!salesModalInstance){salesModalInstance=new bootstrap.Modal(document.getElementById('changeSalesModal'));}
          return {type:'bs5',inst:salesModalInstance};
      }else{
          return {type:'jq',inst:$('#changeSalesModal')};
      }
  }

  $(document).on('click','.js-open-sales-modal',function(){
      const canChange=$(this).data('can-change')==='1'||$(this).data('can-change')===1;
      if(!canChange){alert('You do not have permission to update.');return;}
      const modal=getSalesModal();
      const cid=$(this).data('candidate-id');
      const curId=parseInt($(this).data('current-id'))||0;
      const curLabel=String($(this).data('current-label')||'NOT ASSIGNED').toUpperCase();
      lastSalesBtn=$(this);
      $('#sales-candidate-id').val(cid);
      $('#sales-current-id').val(curId);
      $('#sales-current-label').text(curLabel);
      $('#sales-select').val(curId);
      $('#sales-msg').removeClass().text('');
      if(modal.type==='bs5'){modal.inst.show();}else{modal.inst.modal('show');}
  });

  $('#sales-save-btn').on('click',function(){
      const btn=$(this);
      const cid=$('#sales-candidate-id').val();
      const oldId=parseInt($('#sales-current-id').val())||0;
      const newId=parseInt($('#sales-select').val())||0;
      const msg=$('#sales-msg');
      if(newId===oldId){msg.removeClass().addClass('text-warning').text('No changes to save.');return;}
      btn.prop('disabled',true).html('<i class="fas fa-spinner fa-spin me-1"></i> Saving');
      msg.removeClass().text('');
      $.ajax({
          url:'{{ route("packages.updateSalesName") }}',
          type:'POST',
          data:{candidate_id:cid,sales_name:newId,_token:csrfToken},
          dataType:'json'
      })
      .done(function(res){
          const label=(res.display_name||$('#sales-select option:selected').text()||'Not assigned').toUpperCase();
          $('#sales-current-id').val(newId);
          $('#sales-current-label').text(label);
          if(lastSalesBtn&&lastSalesBtn.length){
              lastSalesBtn.data('current-id',newId);
              lastSalesBtn.data('current-label',label);
              lastSalesBtn.find('.js-sales-label').text(label);
          }
          msg.removeClass().addClass('text-success').text(res.message||'Updated successfully.');
          setTimeout(function(){
              const el=document.getElementById('changeSalesModal');
              const inst=window.bootstrap&&bootstrap.Modal.getInstance?bootstrap.Modal.getInstance(el):null;
              if(inst){inst.hide()}else{$('#changeSalesModal').modal('hide')}
          },2000);
      })
      .fail(function(xhr){
          let text='Failed to update.';
          if(xhr&&xhr.responseJSON){
              if(xhr.responseJSON.message){text=xhr.responseJSON.message}
              if(xhr.responseJSON.errors){
                  const firstKey=Object.keys(xhr.responseJSON.errors)[0];
                  if(firstKey&&xhr.responseJSON.errors[firstKey][0]){text=xhr.responseJSON.errors[firstKey][0]}
              }
          }
          msg.removeClass().addClass('text-danger').text(text);
      })
      .always(function(){
          btn.prop('disabled',false).html('<i class="fas fa-save me-1"></i> Save');
      });
  });
</script>
