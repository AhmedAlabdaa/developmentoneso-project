@php use Carbon\Carbon; @endphp
@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
.select2-container--bootstrap-5.select2-container--focus .select2-selection, .select2-container--bootstrap-5.select2-container--open .select2-selection{font-size: 12px;}
.select2-selection__rendered{font-size: 12px;}
.select2-search__field{font-size: 12px;}
.select2-results__option select2-results__option--selectable select2-results__option--selected{font-size: 12px;}
.form-select{font-size: 12px;}
.form-select option{font-size: 12px;}
</style>
<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Package</h5>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('package.update', $package->id) }}" method="POST" class="row g-3" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="col-md-6">
                <label for="CN_Number" class="form-label">CN Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  <input type="text" name="CN_Number" class="form-control" id="CN_Number" value="{{ old('CN_Number', $package->CN_Number) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="contract_no" class="form-label">Contract No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                  <input type="text" name="contract_no" class="form-control" id="contract_no" value="{{ old('contract_no', $package->contract_no) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="agreement_no" class="form-label">Agreement No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                  <input type="text" name="agreement_no" class="form-control" id="agreement_no" value="{{ old('agreement_no', $package->agreement_no) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="sales_name" class="form-label">Sales Name <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  <input type="text" name="sales_name" class="form-control" id="sales_name" value="{{ old('sales_name', $package->sales_name) }}" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="candidate_name" class="form-label">Candidate Name <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="candidate_name" class="form-control" id="candidate_name" value="{{ old('candidate_name', $package->candidate_name) }}" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="foreign_partner" class="form-label">Foreign Partner</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                  <input type="text" name="foreign_partner" class="form-control" id="foreign_partner" value="{{ old('foreign_partner', $package->foreign_partner) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="current_status" class="form-label">Current Status <span style="color: red;">*</span></label>
                <select name="current_status" class="form-select select2-status" id="current_status" required>
                  <option value="">Select Status</option>
                  @foreach($currentStatuses as $status)
                    <option value="{{ $status->id }}" {{ old('current_status', $package->current_status) == $status->id ? 'selected' : '' }}>
                      {{ $status->status_name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="passport_no" class="form-label">Passport No <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                  <input type="text" name="passport_no" class="form-control" id="passport_no" value="{{ old('passport_no', $package->passport_no) }}" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="passport_expiry_date" class="form-label">Passport Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="passport_expiry_date" class="form-control" id="passport_expiry_date" value="{{ old('passport_expiry_date', $package->passport_expiry_date) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  <input type="date" name="date_of_birth" class="form-control" id="date_of_birth" value="{{ old('date_of_birth', $package->date_of_birth) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="branch_in_uae" class="form-label">Branch in UAE</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-building"></i></span>
                  <input type="text" name="branch_in_uae" class="form-control" id="branch_in_uae" value="{{ old('branch_in_uae', $package->branch_in_uae) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="visa_type" class="form-label">Visa Type</label>
                <select name="visa_type" class="form-select select2-visa" id="visa_type">
                  <option value="">Select Visa Type</option>
                  <option value="D-SPO" {{ old('visa_type', $package->visa_type)=='D-SPO' ? 'selected' : '' }}>D-SPO</option>
                  <option value="D-HIRE" {{ old('visa_type', $package->visa_type)=='D-HIRE' ? 'selected' : '' }}>D-HIRE</option>
                  <option value="TADBEER" {{ old('visa_type', $package->visa_type)=='TADBEER' ? 'selected' : '' }}>TADBEER</option>
                  <option value="TOURIST" {{ old('visa_type', $package->visa_type)=='TOURIST' ? 'selected' : '' }}>TOURIST</option>
                  <option value="VISIT" {{ old('visa_type', $package->visa_type)=='VISIT' ? 'selected' : '' }}>VISIT</option>
                  <option value="OFFICE-VISA" {{ old('visa_type', $package->visa_type)=='OFFICE-VISA' ? 'selected' : '' }}>OFFICE-VISA</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="CL_Number" class="form-label">CL Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  <input type="text" name="CL_Number" class="form-control" id="CL_Number" value="{{ old('CL_Number', $package->CL_Number) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="sponsor_name" class="form-label">Sponsor Name</label>
                <select name="sponsor_name" class="form-select select2-sponsor" id="sponsor_name">
                  <option value="">Select Sponsor</option>
                  @foreach($crmCustomers as $customer)
                    <option value="{{ $customer->id }}"
                      data-emirates_id="{{ $customer->emirates_id }}"
                      data-nationality="{{ $customer->nationality }}"
                      {{ old('sponsor_name', $package->sponsor_name) == $customer->id ? 'selected' : '' }}>
                      {{ $customer->first_name }} {{ $customer->last_name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="eid_no" class="form-label">EID No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  <input type="text" name="eid_no" class="form-control" id="eid_no" value="{{ old('eid_no', $package->eid_no) }}">
                </div>
              </div>

              @php
                $allowedCountries = ['ETHIOPIA', 'INDIA', 'INDONESIA', 'KENYA', 'MYANMAR', 'PHILIPPINES', 'SRI LANKA', 'UGANDA'];
              @endphp

              <div class="col-md-6">
                <label for="nationality" class="form-label">Nationality <span style="color: red;">*</span></label>
                <select name="nationality" class="form-select select2-country" id="nationality" required>
                  <option value="">Select country</option>
                  @foreach($allCountries as $country)
                    @if(in_array(strtoupper($country->NAME), $allowedCountries))
                      <option value="{{ $country->NAME }}" {{ old('nationality', $package->nationality) == $country->NAME ? 'selected' : '' }}>
                        {{ $country->NAME }}
                      </option>
                    @endif
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="CL_nationality" class="form-label">CL Nationality</label>
                <select name="CL_nationality" class="form-select select2-country" id="CL_nationality">
                  <option value="">Select country</option>
                  @foreach($allCountries as $country)
                    <option value="{{ $country->NAME }}" {{ old('CL_nationality', $package->CL_nationality)==$country->NAME ? 'selected' : '' }}>
                      {{ $country->NAME }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="wc_date" class="form-label">WC Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                  <input type="date" name="wc_date" class="form-control" id="wc_date" value="{{ old('wc_date', $package->wc_date) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="dw_number" class="form-label">DW Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                  <input type="text" name="dw_number" class="form-control" id="dw_number" value="{{ old('dw_number', $package->dw_number) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="visa_date" class="form-label">Visa Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="visa_date" class="form-control" id="visa_date" value="{{ old('visa_date', $package->visa_date) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="incident_type" class="form-label">Incident Type</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                  <input type="text" name="incident_type" class="form-control" id="incident_type" value="{{ old('incident_type', $package->incident_type) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="incident_date" class="form-label">Incident Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="incident_date" class="form-control" id="incident_date" value="{{ old('incident_date', $package->incident_date) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="arrived_date" class="form-label">Arrived Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-plane-arrival"></i></span>
                  <input type="date" name="arrived_date" class="form-control" id="arrived_date" value="{{ old('arrived_date', $package->arrived_date) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="package" class="form-label">Package</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-box"></i></span>
                  <input type="text" name="package" class="form-control" id="package" value="{{ old('package', $package->package) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="sales_comm_status" class="form-label">Sales Comm Status</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-percent"></i></span>
                  <input type="text" name="sales_comm_status" class="form-control" id="sales_comm_status" value="{{ old('sales_comm_status', $package->sales_comm_status) }}">
                </div>
              </div>
              <div class="col-lg-6">
                <label class="form-label">Outside Status<span class="required-asterisk">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  <select class="form-select" name="inside_country_or_outside" required>
                    <option value="">Select Status</option>
                    <option value="1" {{ old('inside_country_or_outside', $package->inside_country_or_outside) == '1' ? 'selected' : '' }}>Outside</option>
                    <option value="2" {{ old('inside_country_or_outside', $package->inside_country_or_outside) == '2' ? 'selected' : '' }}>Inside</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <label for="missing_file" class="form-label">Missing File</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                  <input type="text" name="missing_file" class="form-control" id="missing_file" value="{{ old('missing_file', $package->missing_file) }}">
                </div>
              </div>

              <div class="col-md-12">
                <label for="remark" class="form-label">Remark</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-comment"></i></span>
                  <textarea name="remark" class="form-control" id="remark" rows="3">{{ old('remark', $package->remark) }}</textarea>
                </div>
              </div>

              <div class="col-md-6">
                <label for="religion" class="form-label">Religion</label>
                <select name="religion" id="religion" class="form-select select2-religion">
                  <option value="">Select Religion</option>
                  <option value="Muslim" {{ old('religion', $package->religion ?? '')=='Muslim' ? 'selected' : '' }}>Muslim</option>
                  <option value="Christian" {{ old('religion', $package->religion ?? '')=='Christian' ? 'selected' : '' }}>Christian</option>
                  <option value="Other" {{ old('religion', $package->religion ?? '')=='Other' ? 'selected' : '' }}>Other</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="marital_status" class="form-label">Marital Status</label>
                <select name="marital_status" id="marital_status" class="form-select select2-marital">
                  <option value="">Select Marital Status</option>
                  <option value="1" {{ old('marital_status', $package->marital_status ?? '')=='1' ? 'selected' : '' }}>Single</option>
                  <option value="2" {{ old('marital_status', $package->marital_status ?? '')=='2' ? 'selected' : '' }}>Married</option>
                  <option value="3" {{ old('marital_status', $package->marital_status ?? '')=='3' ? 'selected' : '' }}>Divorced</option>
                  <option value="4" {{ old('marital_status', $package->marital_status ?? '')=='4' ? 'selected' : '' }}>Widowed</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="children_count" class="form-label">Number of Children</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-children"></i></span>
                  <input type="number" name="children_count" id="children_count" class="form-control" min="0" step="1" value="{{ old('children_count', $package->children_count ?? 0) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="experience_years" class="form-label">Experience in Years</label>
                <select name="experience_years" id="experience_years" class="form-select select2-experience">
                  <option value="">Select Experience</option>
                  @for ($i=1; $i<=9; $i++)
                    <option value="{{ $i }}" {{ old('experience_years', $package->experience_years ?? '')==$i ? 'selected' : '' }}>{{ $i }} {{ $i==1 ? 'Year' : 'Years' }}</option>
                  @endfor
                  <option value="10" {{ old('experience_years', $package->experience_years ?? '')=='10' ? 'selected' : '' }}>10 Years +</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="salary" class="form-label">Salary (AED) <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                  <input type="number" name="salary" id="salary" class="form-control" step="1" value="{{ old('salary', $package->salary ) }}" required>
                </div>
              </div>
              <div class="form-section col-12">
                <h6>Attachments</h6>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead style="background: linear-gradient(to right, #007bff, #00c6ff); color: #fff;">
                      <tr>
                        <th>Type</th>
                        <th>Document Number</th>
                        <th>Issued On</th>
                        <th>Expired On</th>
                        <th>File</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="attachment-container">
                      @foreach($attachments as $attachment)
                        <tr class="attachment-row">
                          <td>
                            <select class="form-select attachment-type" name="attachment_type_existing[{{ $attachment->id }}]" required>
                              <option disabled value="">Select Document Type...</option>
                              <option value="PASSPORT" {{ $attachment->attachment_type == 'PASSPORT' ? 'selected' : '' }}>PASSPORT</option>
                              <option value="PASSPORT SIZE PHOTO" {{ $attachment->attachment_type == 'PASSPORT SIZE PHOTO' ? 'selected' : '' }}>PASSPORT SIZE PHOTO</option>
                              <option value="FULL BODY PHOTO" {{ $attachment->attachment_type == 'FULL BODY PHOTO' ? 'selected' : '' }}>FULL BODY PHOTO</option>
                              <option value="VIDEO" {{ $attachment->attachment_type == 'VIDEO' ? 'selected' : '' }}>VIDEO</option>
                              <option value="MEDICAL" {{ $attachment->attachment_type == 'MEDICAL' ? 'selected' : '' }}>MEDICAL</option>
                              <option value="POLICE CLEARANCE( UGN AND KNY)" {{ $attachment->attachment_type == 'POLICE CLEARANCE( UGN AND KNY)' ? 'selected' : '' }}>POLICE CLEARANCE( UGN AND KNY)</option>
                              <option value="UPDATED TADBEER CURRICULUM VITAE" {{ $attachment->attachment_type == 'UPDATED TADBEER CURRICULUM VITAE' ? 'selected' : '' }}>UPDATED TADBEER CURRICULUM VITAE</option>
                              <option value="VISA - IF TOURIST VISA" {{ $attachment->attachment_type == 'VISA - IF TOURIST VISA' ? 'selected' : '' }}>VISA - IF TOURIST VISA</option>
                              <option value="CANCELLATION (IF INSIDE UAE)" {{ $attachment->attachment_type == 'CANCELLATION (IF INSIDE UAE)' ? 'selected' : '' }}>CANCELLATION (IF INSIDE UAE)</option>
                              <option value="TICKET" {{ $attachment->attachment_type == 'TICKET' ? 'selected' : '' }}>TICKET</option>
                              <option value="E-VISA" {{ $attachment->attachment_type == 'E-VISA' ? 'selected' : '' }}>E-VISA</option>
                              <option value="ENTRY STAMP" {{ $attachment->attachment_type == 'ENTRY STAMP' ? 'selected' : '' }}>ENTRY STAMP</option>
                              <option value="CHANGE STATUS (IF INSIDE)" {{ $attachment->attachment_type == 'CHANGE STATUS (IF INSIDE)' ? 'selected' : '' }}>CHANGE STATUS (IF INSIDE)</option>
                              <option value="MOHRE VISIT 1" {{ $attachment->attachment_type == 'MOHRE VISIT 1' ? 'selected' : '' }}>MOHRE VISIT 1</option>
                              <option value="MOHRE VISIT 2" {{ $attachment->attachment_type == 'MOHRE VISIT 2' ? 'selected' : '' }}>MOHRE VISIT 2</option>
                              <option value="TAWJIH" {{ $attachment->attachment_type == 'TAWJIH' ? 'selected' : '' }}>TAWJIH</option>
                              <option value="MOHRE VISIT 3" {{ $attachment->attachment_type == 'MOHRE VISIT 3' ? 'selected' : '' }}>MOHRE VISIT 3</option>
                              <option value="MEDICAL FITNESS APPLICATION" {{ $attachment->attachment_type == 'MEDICAL FITNESS APPLICATION' ? 'selected' : '' }}>MEDICAL FITNESS APPLICATION</option>
                              <option value="MEDICAL FITNESS RESULT" {{ $attachment->attachment_type == 'MEDICAL FITNESS RESULT' ? 'selected' : '' }}>MEDICAL FITNESS RESULT</option>
                              <option value="EMIRATES ID APPLICATION" {{ $attachment->attachment_type == 'EMIRATES ID APPLICATION' ? 'selected' : '' }}>EMIRATES ID APPLICATION</option>
                              <option value="RESIDENCE VISA" {{ $attachment->attachment_type == 'RESIDENCE VISA' ? 'selected' : '' }}>RESIDENCE VISA</option>
                              <option value="EMIRATES ID" {{ $attachment->attachment_type == 'EMIRATES ID' ? 'selected' : '' }}>EMIRATES ID</option>
                              <option value="ILOE" {{ $attachment->attachment_type == 'ILOE' ? 'selected' : '' }}>ILOE</option>
                              <option value="INSURANCE" {{ $attachment->attachment_type == 'INSURANCE' ? 'selected' : '' }}>INSURANCE</option>
                              <option value="CANCELLATION" {{ $attachment->attachment_type == 'CANCELLATION' ? 'selected' : '' }}>CANCELLATION</option>
                              <option value="RETURN FORM" {{ $attachment->attachment_type == 'RETURN FORM' ? 'selected' : '' }}>RETURN FORM</option>
                            </select>
                          </td>
                          <td>
                            <input
                              type="text"
                              name="attachment_number_existing[{{ $attachment->id }}]"
                              class="form-control"
                              placeholder="Document Number"
                              value="{{ old('attachment_number_existing.' . $attachment->id, $attachment->attachment_number) }}"
                            >
                          </td>
                          <td>
                            <input
                              type="date"
                              name="issued_on_existing[{{ $attachment->id }}]"
                              class="form-control"
                              value="{{ old('issued_on_existing.' . $attachment->id, $attachment->issued_on ? Carbon::parse($attachment->issued_on)->format('Y-m-d') : '') }}"
                            >
                          </td>
                          <td>
                            <input
                              type="date"
                              name="expired_on_existing[{{ $attachment->id }}]"
                              class="form-control"
                              value="{{ old('expired_on_existing.' . $attachment->id, $attachment->expired_on ? Carbon::parse($attachment->expired_on)->format('Y-m-d') : '') }}"
                            >
                          </td>
                          <td>
                            <a href="{{ Storage::url($attachment->attachment_file) }}" target="_blank" class="btn btn-sm btn-info">
                              <i class="fas fa-eye"></i>
                            </a>
                            <input
                              type="file"
                              name="attachment_file_existing[{{ $attachment->id }}]"
                              class="form-control mt-1"
                            >
                          </td>
                          <td>
                            <button type="button" class="btn btn-sm btn-danger remove-attachment-existing" data-id="{{ $attachment->id }}">
                              <i class="fas fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                      @endforeach

                      <tr class="attachment-row">
                        <td>
                          <select class="form-select attachment-type" name="attachment_type_new[]" required>
                            <option selected disabled value="">Select Document Type...</option>
                            <option value="PASSPORT">PASSPORT</option>
                            <option value="PASSPORT SIZE PHOTO">PASSPORT SIZE PHOTO</option>
                            <option value="FULL BODY PHOTO">FULL BODY PHOTO</option>
                            <option value="VIDEO">VIDEO</option>
                            <option value="MEDICAL">MEDICAL</option>
                            <option value="POLICE CLEARANCE( UGN AND KNY)">POLICE CLEARANCE( UGN AND KNY)</option>
                            <option value="UPDATED TADBEER CURRICULUM VITAE">UPDATED TADBEER CURRICULUM VITAE</option>
                            <option value="VISA - IF TOURIST VISA">VISA - IF TOURIST VISA</option>
                            <option value="CANCELLATION (IF INSIDE UAE)">CANCELLATION (IF INSIDE UAE)</option>
                            <option value="TICKET">TICKET</option>
                            <option value="E-VISA">E-VISA</option>
                            <option value="ENTRY STAMP">ENTRY STAMP</option>
                            <option value="CHANGE STATUS (IF INSIDE)">CHANGE STATUS (IF INSIDE)</option>
                            <option value="MOHRE VISIT 1">MOHRE VISIT 1</option>
                            <option value="MOHRE VISIT 2">MOHRE VISIT 2</option>
                            <option value="TAWJIH">TAWJIH</option>
                            <option value="MOHRE VISIT 3">MOHRE VISIT 3</option>
                            <option value="MEDICAL FITNESS APPLICATION">MEDICAL FITNESS APPLICATION</option>
                            <option value="MEDICAL FITNESS RESULT">MEDICAL FITNESS RESULT</option>
                            <option value="EMIRATES ID APPLICATION">EMIRATES ID APPLICATION</option>
                            <option value="RESIDENCE VISA">RESIDENCE VISA</option>
                            <option value="EMIRATES ID">EMIRATES ID</option>
                            <option value="ILOE">ILOE</option>
                            <option value="INSURANCE">INSURANCE</option>
                            <option value="CANCELLATION">CANCELLATION</option>
                            <option value="RETURN FORM">RETURN FORM</option>
                          </select>
                        </td>
                        <td><input type="text" name="attachment_number_new[]" class="form-control" placeholder="Document Number"></td>
                        <td><input type="date" name="issued_on_new[]" class="form-control"></td>
                        <td><input type="date" name="expired_on_new[]" class="form-control"></td>
                        <td><input type="file" name="attachment_file_new[]" class="form-control" required></td>
                        <td>
                          <div class="button-group">
                            <button type="button" class="btn btn-sm btn-success add-attachment"><i class="fas fa-plus"></i></button>
                            <button type="button" class="btn btn-sm btn-danger remove-attachment"><i class="fas fa-minus"></i></button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary" id="submitButton">
                  <i class="fas fa-save"></i> Update
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@include('../layout.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  function isAttachmentRowValid($row){let typeVal=$row.find('.attachment-type').val();let fileVal=$row.find('input[name="attachment_file_new[]"]').val();let isValid=true;if(!typeVal){isValid=false;$row.find('.attachment-type').addClass('is-invalid')}else{$row.find('.attachment-type').removeClass('is-invalid')}if(!fileVal){isValid=false;$row.find('input[name="attachment_file_new[]"]').addClass('is-invalid')}else{$row.find('input[name="attachment_file_new[]"]').removeClass('is-invalid')}return isValid}
  function addAttachmentRow(){const newRow=`<tr class="attachment-row">
        <td>
          <select class="form-select attachment-type" name="attachment_type_new[]" required>
            <option selected disabled value="">Select Document Type...</option>
            <option value="PASSPORT">PASSPORT</option>
            <option value="PASSPORT SIZE PHOTO">PASSPORT SIZE PHOTO</option>
            <option value="FULL BODY PHOTO">FULL BODY PHOTO</option>
            <option value="VIDEO">VIDEO</option>
            <option value="MEDICAL">MEDICAL</option>
            <option value="POLICE CLEARANCE( UGN AND KNY)">POLICE CLEARANCE( UGN AND KNY)</option>
            <option value="UPDATED TADBEER CURRICULUM VITAE">UPDATED TADBEER CURRICULUM VITAE</option>
            <option value="VISA - IF TOURIST VISA">VISA - IF TOURIST VISA</option>
            <option value="CANCELLATION (IF INSIDE UAE)">CANCELLATION (IF INSIDE UAE)</option>
            <option value="TICKET">TICKET</option>
            <option value="E-VISA">E-VISA</option>
            <option value="ENTRY STAMP">ENTRY STAMP</option>
            <option value="CHANGE STATUS (IF INSIDE)">CHANGE STATUS (IF INSIDE)</option>
            <option value="MOHRE VISIT 1">MOHRE VISIT 1</option>
            <option value="MOHRE VISIT 2">MOHRE VISIT 2</option>
            <option value="TAWJIH">TAWJIH</option>
            <option value="MOHRE VISIT 3">MOHRE VISIT 3</option>
            <option value="MEDICAL FITNESS APPLICATION">MEDICAL FITNESS APPLICATION</option>
            <option value="MEDICAL FITNESS RESULT">MEDICAL FITNESS RESULT</option>
            <option value="EMIRATES ID APPLICATION">EMIRATES ID APPLICATION</option>
            <option value="RESIDENCE VISA">RESIDENCE VISA</option>
            <option value="EMIRATES ID">EMIRATES ID</option>
            <option value="ILOE">ILOE</option>
            <option value="INSURANCE">INSURANCE</option>
            <option value="CANCELLATION">CANCELLATION</option>
            <option value="RETURN FORM">RETURN FORM</option>
          </select>
        </td>
        <td><input type="text" name="attachment_number_new[]" class="form-control" placeholder="Document Number"></td>
        <td><input type="date" name="issued_on_new[]" class="form-control"></td>
        <td><input type="date" name="expired_on_new[]" class="form-control"></td>
        <td><input type="file" name="attachment_file_new[]" class="form-control" required></td>
        <td>
          <div class="button-group">
            <button type="button" class="btn btn-sm btn-success add-attachment"><i class="fas fa-plus"></i></button>
            <button type="button" class="btn btn-sm btn-danger remove-attachment"><i class="fas fa-minus"></i></button>
          </div>
        </td>
      </tr>`;$('#attachment-container').append(newRow);updateAttachmentButtons()}
  function updateAttachmentButtons(){const rows=$('#attachment-container .attachment-row');rows.each(function(index){$(this).find('.add-attachment').toggle(index===rows.length-1);$(this).find('.remove-attachment').toggle(rows.length>1)})}
  $(document).on('click','.add-attachment',function(e){e.preventDefault();const $currentRow=$(this).closest('.attachment-row');if(!isAttachmentRowValid($currentRow)){alert('Please select the document type and file before adding a new row.');return}addAttachmentRow()})
  $(document).on('click','.remove-attachment',function(){$(this).closest('.attachment-row').remove();updateAttachmentButtons()})
  $(document).on('click','.remove-attachment-existing',function(){const attachmentId=$(this).data('id');$('<input>').attr({type:'hidden',name:'delete_attachments[]',value:attachmentId}).appendTo('form');$(this).closest('.attachment-row').remove()})
  $(document).ready(function(){updateAttachmentButtons();$('.select2-country, .select2-status, .select2-sponsor, .select2-visa, .select2-religion, .select2-marital, .select2-experience').select2({theme:'bootstrap-5',width:'100%',allowClear:true});$('#salary').on('input',function(){if(this.value&&parseInt(this.value,10)<1200){this.setCustomValidity('Salary must be at least 1200 AED.')}else{this.setCustomValidity('')}})})
</script>
