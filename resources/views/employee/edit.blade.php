@php
  use Illuminate\Support\Str;
  use Illuminate\Support\Facades\Storage;

  $docTypes = [
      'PASSPORT',
      'PASSPORT SIZE PHOTO',
      'FULL BODY PHOTO',
      'VIDEO',
      'MEDICAL',
      'POLICE CLEARANCE( UGN AND KNY)',
      'UPDATED TADBEER CURRICULUM VITAE',
      'VISA - IF TOURIST VISA',
      'CANCELLATION (IF INSIDE UAE)',
      'TICKET',
      'E-VISA',
      'ENTRY STAMP',
      'CHANGE STATUS (IF INSIDE)',
      'MOHRE VISIT 1',
      'MOHRE VISIT 2',
      'TAWJIH',
      'MOHRE VISIT 3',
      'MEDICAL FITNESS APPLICATION',
      'MEDICAL FITNESS RESULT',
      'EMIRATES ID APPLICATION',
      'RESIDENCE VISA',
      'EMIRATES ID',
      'ILOE',
      'INSURANCE',
      'CANCELLATION',
      'RETURN FORM'
  ];

  $firstStepId = optional(collect($steps)->sortBy('id')->first())->id ?? '';
@endphp

@include('role_header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
  .table-gradient thead tr th{background:linear-gradient(to right,#007bff,#00c6ff)!important;color:#fff!important}
  .subrow-title{font-weight:600}
  .finance-grid{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:.75rem}
  .stage-action{white-space:nowrap}
  .required-asterisk{color:#dc3545;margin-left:4px}
  .select2-container--bootstrap-5.select2-container--focus .select2-selection,.select2-container--bootstrap-5.select2-container--open .select2-selection{font-size:12px}
  .select2-selection__rendered,.select2-search__field,.select2-results__option select2-results__option--selectable select2-results__option--selected,.form-select,.form-select option{font-size:12px}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Employee</h5>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div id="ajax-error-box" class="alert alert-danger d-none">
              <ul class="mb-0" id="ajax-error-list"></ul>
            </div>

            <form class="row g-3" action="{{ route('employees.update', $employee->reference_no) }}" method="POST" enctype="multipart/form-data" id="employee-edit-form">
              @csrf
              @method('PUT')

              <div class="col-lg-6">
                <label class="form-label">REF-No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  <input type="text" class="form-control" name="reference_no" value="{{ old('reference_no', $employee->reference_no) }}" readonly>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Personal Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                  <input type="text" class="form-control" name="personal_no" value="{{ old('personal_no', $employee->personal_no) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Package<span class="required-asterisk">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-box"></i></span>
                  <select class="form-select" name="package" required>
                    <option value="">Select Package</option>
                    <option value="PKG-2" {{ old('package', $employee->package) == 'PKG-2' ? 'selected' : '' }}>PKG-2</option>
                    <option value="PKG-3" {{ old('package', $employee->package) == 'PKG-3' ? 'selected' : '' }}>PKG-3</option>
                    <option value="PKG-4" {{ old('package', $employee->package) == 'PKG-4' ? 'selected' : '' }}>PKG-4</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Name<span class="required-asterisk">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" class="form-control" name="name" value="{{ old('name', $employee->name) }}" required>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Slug</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-link"></i></span>
                  <input type="text" class="form-control" name="slug" value="{{ old('slug', $employee->slug) }}" readonly>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Nationality<span class="required-asterisk">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-flag"></i></span>
                  <select class="form-select" name="nationality" required>
                    <option value="">Select Nationality</option>
                    <option value="ETHIOPIA" {{ old('nationality', $employee->nationality) == 'ETHIOPIA' ? 'selected' : '' }}>ETHIOPIA</option>
                    <option value="INDIA" {{ old('nationality', $employee->nationality) == 'INDIA' ? 'selected' : '' }}>INDIA</option>
                    <option value="PAKISTAN" {{ old('nationality', $employee->nationality) == 'PAKISTAN' ? 'selected' : '' }}>PAKISTAN</option>
                    <option value="INDONESIA" {{ old('nationality', $employee->nationality) == 'INDONESIA' ? 'selected' : '' }}>INDONESIA</option>
                    <option value="KENYA" {{ old('nationality', $employee->nationality) == 'KENYA' ? 'selected' : '' }}>KENYA</option>
                    <option value="MYANMAR" {{ old('nationality', $employee->nationality) == 'MYANMAR' ? 'selected' : '' }}>MYANMAR</option>
                    <option value="PHILIPPINES" {{ old('nationality', $employee->nationality) == 'PHILIPPINES' ? 'selected' : '' }}>PHILIPPINES</option>
                    <option value="SRI LANKA" {{ old('nationality', $employee->nationality) == 'SRI LANKA' ? 'selected' : '' }}>SRI LANKA</option>
                    <option value="UGANDA" {{ old('nationality', $employee->nationality) == 'UGANDA' ? 'selected' : '' }}>UGANDA</option>
                    <option value="NIGERIA" {{ old('nationality', $employee->nationality) == 'NIGERIA' ? 'selected' : '' }}>NIGERIA</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Gender<span class="required-asterisk">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                  <select class="form-select" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender', $employee->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Date of Birth<span class="required-asterisk">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  <input type="text" class="form-control date-field" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth) }}" required>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Passport No<span class="required-asterisk">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-passport"></i></span>
                  <input type="text" class="form-control" name="passport_no" value="{{ old('passport_no', $employee->passport_no) }}" required>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Passport Expiry Date<span class="required-asterisk">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" class="form-control date-field" name="passport_expiry_date" value="{{ old('passport_expiry_date', $employee->passport_expiry_date) }}" required>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Date of Joining</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                  <input type="text" class="form-control date-field" name="date_of_joining" value="{{ old('date_of_joining', $employee->date_of_joining) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Visa Designation</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                  <input type="text" class="form-control" name="visa_designation" value="{{ old('visa_designation', $employee->visa_designation) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Residence Visa Start Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                  <input type="text" class="form-control date-field" name="residence_visa_start_date" value="{{ old('residence_visa_start_date', $employee->residence_visa_start_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Residence Visa Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                  <input type="text" class="form-control date-field" name="residence_visa_expiry_date" value="{{ old('residence_visa_expiry_date', $employee->residence_visa_expiry_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">File/Entry Permit Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                  <input type="text" class="form-control" name="file_entry_permit_no" value="{{ old('file_entry_permit_no', $employee->file_entry_permit_no) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">File/Entry Permit Issued Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                  <input type="text" class="form-control date-field" name="file_entry_permit_issued_date" value="{{ old('file_entry_permit_issued_date', $employee->file_entry_permit_issued_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">File/Entry Permit Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                  <input type="text" class="form-control date-field" name="file_entry_permit_expired_date" value="{{ old('file_entry_permit_expired_date', $employee->file_entry_permit_expired_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">EID Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  <input type="text" class="form-control" name="emirates_id_number" value="{{ old('emirates_id_number', $employee->emirates_id_number) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">EID Issued Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                  <input type="text" class="form-control date-field" name="eid_issued_date" value="{{ old('eid_issued_date', $employee->eid_issued_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">EID Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                  <input type="text" class="form-control date-field" name="eid_expiry_date" value="{{ old('eid_expiry_date', $employee->eid_expiry_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Labor Card Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                  <input type="text" class="form-control" name="labor_card_no" value="{{ old('labor_card_no', $employee->labor_card_no) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Labor Card Issued Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                  <input type="text" class="form-control date-field" name="labor_card_issued_date" value="{{ old('labor_card_issued_date', $employee->labor_card_issued_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Labor Card Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                  <input type="text" class="form-control date-field" name="labor_card_expiry_date" value="{{ old('labor_card_expiry_date', $employee->labor_card_expiry_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">ILOE Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                  <input type="text" class="form-control" name="iloe_number" value="{{ old('iloe_number', $employee->iloe_number) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">ILOE Issued Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                  <input type="text" class="form-control date-field" name="iloe_issued_date" value="{{ old('iloe_issued_date', $employee->iloe_issued_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">ILOE Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                  <input type="text" class="form-control date-field" name="iloe_expired_date" value="{{ old('iloe_expired_date', $employee->iloe_expired_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Insurance Policy Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-medkit"></i></span>
                  <input type="text" class="form-control" name="insurance_policy_number" value="{{ old('insurance_policy_number', $employee->insurance_policy_number) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Insurance Policy Issued Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                  <input type="text" class="form-control date-field" name="insurance_policy_issued_date" value="{{ old('insurance_policy_issued_date', $employee->insurance_policy_issued_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Insurance Policy Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                  <input type="text" class="form-control date-field" name="insurance_policy_expired_date" value="{{ old('insurance_policy_expired_date', $employee->insurance_policy_expired_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Employment Contract Start Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                  <input type="text" class="form-control date-field" name="employment_contract_start_date" value="{{ old('employment_contract_start_date', $employee->employment_contract_start_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Employment Contract End Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                  <input type="text" class="form-control date-field" name="employment_contract_end_date" value="{{ old('employment_contract_end_date', $employee->employment_contract_end_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Contract Type</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                  <select class="form-select" name="contract_type">
                    <option value="">Select Contract Type</option>
                    <option value="Permanent" {{ old('contract_type', $employee->contract_type) == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                    <option value="Temporary" {{ old('contract_type', $employee->contract_type) == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Salary as per Contract</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                  <input type="number" class="form-control" name="salary_as_per_contract" value="{{ old('salary_as_per_contract', $employee->salary_as_per_contract) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Basic Salary</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                  <input type="number" class="form-control salary-input" id="basic" name="basic" value="{{ old('basic', $employee->basic) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Housing Allowance</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-home"></i></span>
                  <input type="number" class="form-control salary-input" id="housing" name="housing" value="{{ old('housing', $employee->housing) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Transport Allowance</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-bus"></i></span>
                  <input type="number" class="form-control salary-input" id="transport" name="transport" value="{{ old('transport', $employee->transport) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Other Allowances</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-gift"></i></span>
                  <input type="number" class="form-control salary-input" id="other_allowances" name="other_allowances" value="{{ old('other_allowances', $employee->other_allowances) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Total Salary</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                  <input type="number" class="form-control" id="total_salary" name="total_salary" value="{{ old('total_salary', $employee->total_salary) }}" readonly>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Payment Type</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                  <select class="form-select" name="payment_type">
                    <option value="">Select Payment Type</option>
                    <option value="WPS" {{ old('payment_type', $employee->payment_type) == 'WPS' ? 'selected' : '' }}>WPS</option>
                    <option value="CASH" {{ old('payment_type', $employee->payment_type) == 'CASH' ? 'selected' : '' }}>CASH</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Bank Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-university"></i></span>
                  <input type="text" class="form-control" name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">IBAN</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                  <input type="text" class="form-control" name="iban" value="{{ old('iban', $employee->iban) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Current Status</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                  <input type="text" class="form-control" name="current_status" value="{{ old('current_status', $employee->current_status) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Inside Status<span class="required-asterisk">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  <select class="form-select" name="inside_status" id="inside_status" required>
                    <option value="">Select Status</option>
                    <option value="0" {{ (string)old('inside_status', $employee->inside_status) === '0' ? 'selected' : '' }}>All</option>
                    <option value="1" {{ (string)old('inside_status', $employee->inside_status) === '1' ? 'selected' : '' }}>Office</option>
                    <option value="2" {{ (string)old('inside_status', $employee->inside_status) === '2' ? 'selected' : '' }}>Contracted</option>
                    <option value="3" {{ (string)old('inside_status', $employee->inside_status) === '3' ? 'selected' : '' }}>Incidented</option>
                    <option value="4" {{ (string)old('inside_status', $employee->inside_status) === '4' ? 'selected' : '' }}>Outside</option>
                  </select>
                </div>
                <div class="text-danger small mt-1">Before change this make sure are you changing accurate and pefect status .Operations will not disturb?</div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">IN /OUT Status<span class="required-asterisk">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  <select class="form-select" name="inside_country_or_outside" required>
                    <option value="">Select Status</option>
                    <option value="2" {{ (string)old('inside_country_or_outside', $employee->inside_country_or_outside) === '2' ? 'selected' : '' }}>Inside</option>
                    <option value="1" {{ (string)old('inside_country_or_outside', $employee->inside_country_or_outside) === '1' ? 'selected' : '' }}>Outside</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-6" id="incident_type_wrap">
                <label class="form-label">Incident Type<span class="required-asterisk d-none" id="incident_req1">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                  <select class="form-select" name="incident_type" id="incident_type">
                    <option value="" {{ old('incident_type', $employee->incident_type) ? '' : 'selected' }}>Select incident type</option>
                    <option value="RUNAWAY" {{ old('incident_type', $employee->incident_type) === 'RUNAWAY' ? 'selected' : '' }}>Runaway</option>
                    <option value="REPATRIATION" {{ old('incident_type', $employee->incident_type) === 'REPATRIATION' ? 'selected' : '' }}>Repatriation</option>
                    <option value="UNFIT" {{ old('incident_type', $employee->incident_type) === 'UNFIT' ? 'selected' : '' }}>Unfit</option>
                    <option value="REFUSED" {{ old('incident_type', $employee->incident_type) === 'REFUSED' ? 'selected' : '' }}>Refused</option>
                    <option value="PSYCHIATRIC" {{ old('incident_type', $employee->incident_type) === 'PSYCHIATRIC' ? 'selected' : '' }}>Psychiatric</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-6" id="incident_date_wrap">
                <label class="form-label">Incident Date<span class="required-asterisk d-none" id="incident_req2">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-times"></i></span>
                  <input type="text" class="form-control date-field" name="incident_date" id="incident_date" value="{{ old('incident_date', $employee->incident_date) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Foreign Partner</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                  <input type="text" class="form-control" name="foreign_partner" value="{{ old('foreign_partner', $employee->foreign_partner) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Unified Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                  <input type="text" class="form-control" name="uid_no" value="{{ old('uid_no', $employee->uid_no) }}">
                </div>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" name="remarks" rows="2">{{ old('remarks', $employee->remarks) }}</textarea>
              </div>

              <div class="col-lg-6">
                <label class="form-label">Comments</label>
                <textarea class="form-control" name="comments" rows="2">{{ old('comments', $employee->comments) }}</textarea>
              </div>

              <div class="form-section col-12">
                <h6>Attachments</h6>
                <div class="table-responsive">
                  <table class="table table-bordered table-gradient">
                    <thead>
                      <tr>
                        <th>Type<span class="required-asterisk">*</span></th>
                        <th>Document Number</th>
                        <th>Issued On</th>
                        <th>Expired On</th>
                        <th>File<span class="required-asterisk">*</span></th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="attachment-container">
                      @foreach($attachments as $attachment)
                        <tr class="attachment-row">
                          <td>
                            <select class="form-select attachment-type" name="attachment_type_existing[{{ $attachment->id }}]" required>
                              <option disabled value="">Select Document Type...</option>
                              @foreach($docTypes as $t)
                                <option value="{{ $t }}" {{ old('attachment_type_existing.'.$attachment->id, $attachment->attachment_type) == $t ? 'selected' : '' }}>{{ $t }}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <input type="text" name="attachment_number_existing[{{ $attachment->id }}]" class="form-control" placeholder="Document Number" value="{{ old('attachment_number_existing.'.$attachment->id, $attachment->attachment_number) }}">
                          </td>
                          <td>
                            <input type="text" name="issued_on_existing[{{ $attachment->id }}]" class="form-control date-field" value="{{ old('issued_on_existing.'.$attachment->id, $attachment->issued_on) }}">
                          </td>
                          <td>
                            <input type="text" name="expired_on_existing[{{ $attachment->id }}]" class="form-control date-field" value="{{ old('expired_on_existing.'.$attachment->id, $attachment->expired_on) }}">
                          </td>
                          <td>
                            @if($attachment->attachment_file)
                              <a href="{{ Storage::url($attachment->attachment_file) }}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            @endif
                            <input type="file" name="attachment_file_existing[{{ $attachment->id }}]" class="form-control mt-1">
                          </td>
                          <td>
                            <button type="button" class="btn btn-sm btn-danger remove-attachment-existing" data-id="{{ $attachment->id }}"><i class="fas fa-trash"></i></button>
                          </td>
                        </tr>
                      @endforeach

                      <tr class="attachment-row">
                        <td>
                          <select class="form-select attachment-type" name="attachment_type_new[]" required>
                            <option selected disabled value="">Select Document Type...</option>
                            @foreach($docTypes as $t)
                              <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <input type="text" name="attachment_number_new[]" class="form-control" placeholder="Document Number">
                        </td>
                        <td>
                          <input type="text" name="issued_on_new[]" class="form-control date-field">
                        </td>
                        <td>
                          <input type="text" name="expired_on_new[]" class="form-control date-field">
                        </td>
                        <td>
                          <input type="file" name="attachment_file_new[]" class="form-control" required>
                        </td>
                        <td>
                          <button type="button" class="btn btn-sm btn-success add-attachment"><i class="fas fa-plus"></i></button>
                          <button type="button" class="btn btn-sm btn-danger remove-attachment"><i class="fas fa-minus"></i></button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="form-section col-12">
                <h6>Visa Stages</h6>
                <div class="table-responsive">
                  <table class="table table-bordered table-gradient" id="visa-stages-table">
                    <thead>
                      <tr>
                        <th>Stage / Section<span class="required-asterisk">*</span></th>
                        <th>Issue Date<span class="required-asterisk">*</span></th>
                        <th>File Number</th>
                        <th>Expiry Date<span class="required-asterisk">*</span></th>
                        <th>ICA Proof</th>
                        <th>Attach File</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="visa-stages-container">
                      @foreach($visaStages->sortBy('step_id') as $stage)
                        @php
                          $extraRaw = $stage->fin_extra_files;
                          $extra = [];
                          if (is_array($extraRaw)) {
                              $extra = $extraRaw;
                          } elseif (is_string($extraRaw)) {
                              $trim = trim($extraRaw);
                              if (Str::startsWith($trim, ['[', '{'])) {
                                  $decoded = json_decode($trim, true);
                                  if (is_array($decoded)) {
                                      $extra = $decoded;
                                  } elseif ($trim !== '') {
                                      $extra = [$trim];
                                  }
                              } elseif ($trim !== '') {
                                  $extra = [$trim];
                              }
                          }
                          $extraList = [];
                          foreach ($extra as $item) {
                              if (is_array($item)) {
                                  $p = $item['path'] ?? $item['file_path'] ?? $item['url'] ?? $item['storage_path'] ?? null;
                                  $n = $item['name'] ?? $item['file_name'] ?? ($p ? basename($p) : 'File');
                              } else {
                                  $p = $item;
                                  $n = basename($p);
                              }
                              if ($p) {
                                  $extraList[] = ['name' => $n, 'url' => Storage::url($p)];
                              }
                          }
                        @endphp

                        <tr class="stage-group hr-row" data-existing="1" data-id="{{ $stage->id }}">
                          <td>
                            <select class="form-select stage-select" name="stages_existing[{{ $stage->id }}][step_id]" required>
                              <option value="" disabled>Select Stage</option>
                              @foreach($steps as $step)
                                @if($step->title !== 'Arrival Status')
                                  @php $selectedId = old('stages_existing.'.$stage->id.'.step_id', $stage->step_id); @endphp
                                  <option value="{{ $step->id }}" {{ (int)$selectedId === (int)$step->id ? 'selected' : '' }}>{{ $step->id }} - {{ $step->title }}</option>
                                @endif
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <input type="text" class="form-control date-field" name="stages_existing[{{ $stage->id }}][hr_issue_date]" value="{{ old('stages_existing.'.$stage->id.'.hr_issue_date', $stage->hr_issue_date) }}" required>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="stages_existing[{{ $stage->id }}][hr_file_number]" value="{{ old('stages_existing.'.$stage->id.'.hr_file_number', $stage->hr_file_number) }}" placeholder="File Number">
                          </td>
                          <td>
                            <input type="text" class="form-control date-field" name="stages_existing[{{ $stage->id }}][hr_expiry_date]" value="{{ old('stages_existing.'.$stage->id.'.hr_expiry_date', $stage->hr_expiry_date) }}" required>
                          </td>
                          <td>
                            @if(!empty($stage->ica_proof))
                              <a href="{{ Storage::url($stage->ica_proof) }}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            @endif
                            <input type="file" class="form-control mt-1" name="stages_existing[{{ $stage->id }}][ica_proof]">
                          </td>
                          <td>
                            @if(!empty($stage->hr_attach_file))
                              <a href="{{ Storage::url($stage->hr_attach_file) }}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            @endif
                            <input type="file" class="form-control mt-1" name="stages_existing[{{ $stage->id }}][hr_attach_file]">
                          </td>
                          <td class="stage-action text-center">
                            <button type="button" class="btn btn-sm btn-success add-stage-group"><i class="fas fa-plus"></i></button>
                            <button type="button" class="btn btn-sm btn-danger remove-stage-group" data-existing="1" data-id="{{ $stage->id }}"><i class="fas fa-minus"></i></button>
                          </td>
                        </tr>

                        <tr class="stage-group finance-row" data-existing="1" data-id="{{ $stage->id }}">
                          <td>
                            <span class="subrow-title" style="line-height:5;margin-left:10px;">Finance</span>
                          </td>
                          <td colspan="5">
                            <div class="finance-grid">
                              <div>
                                <label class="form-label mb-1">Paid Amount</label>
                                <input type="number" step="0.01" class="form-control" name="stages_existing[{{ $stage->id }}][fin_paid_amount]" value="{{ old('stages_existing.'.$stage->id.'.fin_paid_amount', $stage->fin_paid_amount) }}">
                              </div>
                              <div>
                                <label class="form-label mb-1">Zoho Payment Proof</label>
                                @if(!empty($stage->fin_zoho_proof))
                                  <a href="{{ Storage::url($stage->fin_zoho_proof) }}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                @endif
                                <input type="file" class="form-control mt-1" name="stages_existing[{{ $stage->id }}][fin_zoho_proof]">
                              </div>
                              <div>
                                <label class="form-label mb-1">Gov’t Invoice Proof</label>
                                @if(!empty($stage->fin_gov_invoice_proof))
                                  <a href="{{ Storage::url($stage->fin_gov_invoice_proof) }}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                @endif
                                <input type="file" class="form-control mt-1" name="stages_existing[{{ $stage->id }}][fin_gov_invoice_proof]">
                              </div>
                              <div>
                                <label class="form-label mb-1">
                                  Additional Files
                                  @if(count($extraList))
                                    <button type="button" class="btn btn-sm btn-info ms-1 btn-view-extra" data-title="Stage {{ $stage->step_id }} Additional Files" data-files='@json($extraList)'>
                                      <i class="fas fa-eye"></i>
                                    </button>
                                  @endif
                                </label>
                                <input type="file" class="form-control" name="stages_existing[{{ $stage->id }}][fin_extra_files][]" multiple>
                              </div>
                            </div>
                          </td>
                          <td></td>
                        </tr>
                      @endforeach

                      @if($visaStages->count() == 0)
                        <tr class="stage-group hr-row" data-existing="0" data-index="0">
                          <td>
                            <select class="form-select stage-select" name="stages_new[0][step_id]" required>
                              <option value="" disabled>Select Stage</option>
                              @foreach($steps as $step)
                                @if($step->title !== 'Arrival Status')
                                  <option value="{{ $step->id }}" {{ (string)$step->id === (string)$firstStepId ? 'selected' : '' }}>{{ $step->id }} - {{ $step->title }}</option>
                                @endif
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <input type="text" class="form-control date-field" name="stages_new[0][hr_issue_date]" required>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="stages_new[0][hr_file_number]" placeholder="File Number">
                          </td>
                          <td>
                            <input type="text" class="form-control date-field" name="stages_new[0][hr_expiry_date]" required>
                          </td>
                          <td>
                            <input type="file" class="form-control" name="stages_new[0][ica_proof]">
                          </td>
                          <td>
                            <input type="file" class="form-control" name="stages_new[0][hr_attach_file]">
                          </td>
                          <td class="stage-action text-center">
                            <button type="button" class="btn btn-sm btn-success add-stage-group"><i class="fas fa-plus"></i></button>
                            <button type="button" class="btn btn-sm btn-danger remove-stage-group"><i class="fas fa-minus"></i></button>
                          </td>
                        </tr>

                        <tr class="stage-group finance-row" data-existing="0" data-index="0">
                          <td>
                            <span class="subrow-title" style="line-height:5;margin-left:10px;">Finance</span>
                          </td>
                          <td colspan="5">
                            <div class="finance-grid">
                              <div>
                                <label class="form-label mb-1">Paid Amount</label>
                                <input type="number" step="0.01" class="form-control" name="stages_new[0][fin_paid_amount]" placeholder="0.00">
                              </div>
                              <div>
                                <label class="form-label mb-1">Zoho Payment Proof</label>
                                <input type="file" class="form-control" name="stages_new[0][fin_zoho_proof]">
                              </div>
                              <div>
                                <label class="form-label mb-1">Gov’t Invoice Proof</label>
                                <input type="file" class="form-control" name="stages_new[0][fin_gov_invoice_proof]">
                              </div>
                              <div>
                                <label class="form-label mb-1">
                                  Additional Files
                                  <button type="button" class="btn btn-sm btn-info ms-1 btn-preview-extra-new" data-index="0">
                                    <i class="fas fa-eye"></i>
                                  </button>
                                </label>
                                <input type="file" class="form-control" name="stages_new[0][fin_extra_files][]" multiple>
                              </div>
                            </div>
                          </td>
                          <td></td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="form-section col-12">
                <h6>Arrival Status <small class="text-muted">You can update after Entry permit issuance</small></h6>
                <div class="table-responsive">
                  <table class="table table-bordered table-gradient">
                    <thead>
                      <tr>
                        <th>Ticket Attachment</th>
                        <th>Immigration Entry Stamp Attachment</th>
                        <th>ICP Proof Attachment</th>
                        <th>Arrival Date</th>
                        <th>Expiry Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          @if(!empty($employee->arrival_ticket_attachment))
                            <a href="{{ Storage::url($employee->arrival_ticket_attachment) }}" target="_blank" class="btn btn-sm btn-info mb-1">
                              <i class="fas fa-eye"></i>
                            </a>
                          @endif
                          <input type="file" class="form-control" name="arrival_ticket_attachment">
                        </td>
                        <td>
                          @if(!empty($employee->arrival_entry_stamp_attachment))
                            <a href="{{ Storage::url($employee->arrival_entry_stamp_attachment) }}" target="_blank" class="btn btn-sm btn-info mb-1">
                              <i class="fas fa-eye"></i>
                            </a>
                          @endif
                          <input type="file" class="form-control" name="arrival_entry_stamp_attachment">
                        </td>
                        <td>
                          @if(!empty($employee->arrival_icp_proof_attachment))
                            <a href="{{ Storage::url($employee->arrival_icp_proof_attachment) }}" target="_blank" class="btn btn-sm btn-info mb-1">
                              <i class="fas fa-eye"></i>
                            </a>
                          @endif
                          <input type="file" class="form-control" name="arrival_icp_proof_attachment">
                        </td>
                        <td>
                          <input type="text" class="form-control date-field" name="arrival_date" value="{{ old('arrival_date', $employee->arrival_date) }}">
                        </td>
                        <td>
                          <input type="text" class="form-control date-field" name="arrival_expiry_date" value="{{ old('arrival_expiry_date', $employee->arrival_expiry_date) }}">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="col-lg-12">
                <button type="submit" class="btn btn-primary" id="btn-update">Update</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="stageExtraModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="stageExtraModalTitle">Additional Files</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>File Name</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody id="stageExtraModalBody"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
  function calculateTotal(){
    const b = parseFloat(document.getElementById('basic')?.value) || 0;
    const h = parseFloat(document.getElementById('housing')?.value) || 0;
    const t = parseFloat(document.getElementById('transport')?.value) || 0;
    const o = parseFloat(document.getElementById('other_allowances')?.value) || 0;
    const out = document.getElementById('total_salary');
    if(out) out.value = b + h + t + o;
  }

  function initFlatpickr(scope){
    const $s = scope ? $(scope) : $(document);
    $s.find('.date-field').each(function(){
      if(this._flatpickr) return;
      flatpickr(this,{
        altInput:true,
        altFormat:'d M Y',
        dateFormat:'Y-m-d',
        defaultDate:this.value || null
      });
    });
  }

  function setIncidentRequired(on){
    const $type = $('#incident_type');
    const $date = $('#incident_date');
    $('#incident_req1').toggleClass('d-none', !on);
    $('#incident_req2').toggleClass('d-none', !on);
    $type.prop('required', !!on);
    $date.prop('required', !!on);
    $('#incident_type_wrap').toggle(!!on);
    $('#incident_date_wrap').toggle(!!on);
    if(!on){
      $type.removeClass('is-invalid');
      $date.removeClass('is-invalid');
      $('.invalid-feedback.ajax[data-for="incident_type"]').remove();
      $('.invalid-feedback.ajax[data-for="incident_date"]').remove();
    }
  }

  function usedStageIds(){
    const ids = [];
    $('#visa-stages-container .stage-select').each(function(){
      const v = parseInt($(this).val(),10);
      if(v) ids.push(String(v));
    });
    return ids;
  }

  function refreshStageOptions(){
    const used = usedStageIds();
    $('#visa-stages-container .stage-select').each(function(){
      const current = $(this).val();
      $(this).find('option').each(function(){
        const val = String($(this).attr('value') || '');
        if(!val) return;
        if(val === String(current)){
          $(this).prop('disabled', false);
        } else {
          $(this).prop('disabled', used.includes(val));
        }
      });
    });
  }

  function nextAllowedStage(){
    const ids = usedStageIds().map(v => parseInt(v,10)).filter(Boolean);
    if(!ids.length) return 1;
    return Math.max.apply(null, ids) + 1;
  }

  function lockNewestStageToNext(){
    const $lastHr = $('#visa-stages-container .hr-row').last();
    if(!$lastHr.length || $lastHr.data('existing') == 1) return;
    const expect = String(nextAllowedStage());
    const $sel = $lastHr.find('.stage-select');
    if($sel.length){
      $sel.val(expect);
      refreshStageOptions();
    }
  }

  function validateStageGroup($hr){
    let ok = true;
    const stageEl = $hr.find('select.stage-select')[0];
    const issueEl = $hr.find('input[name$="[hr_issue_date]"]')[0];
    const expiryEl = $hr.find('input[name$="[hr_expiry_date]"]')[0];
    const stageVal = (stageEl || {}).value || '';
    const issueVal = (issueEl || {}).value || '';
    const expiryVal = (expiryEl || {}).value || '';
    if(!stageVal){
      ok = false;
      $(stageEl).addClass('is-invalid');
    }
    if(!issueVal){
      ok = false;
      $(issueEl).addClass('is-invalid');
    }
    if(!expiryVal){
      ok = false;
      $(expiryEl).addClass('is-invalid');
    }
    return ok;
  }

  function buildNewStageGroup(i){
    return `<tr class="stage-group hr-row" data-existing="0" data-index="${i}">
      <td>
        <select class="form-select stage-select" name="stages_new[${i}][step_id]" required>
          <option value="" disabled>Select Stage</option>
          @foreach($steps as $step)
            @if($step->title !== 'Arrival Status')
              <option value="{{ $step->id }}">{{ $step->id }} - {{ $step->title }}</option>
            @endif
          @endforeach
        </select>
      </td>
      <td>
        <input type="text" class="form-control date-field" name="stages_new[${i}][hr_issue_date]" required>
      </td>
      <td>
        <input type="text" class="form-control" name="stages_new[${i}][hr_file_number]" placeholder="File Number">
      </td>
      <td>
        <input type="text" class="form-control date-field" name="stages_new[${i}][hr_expiry_date]" required>
      </td>
      <td>
        <input type="file" class="form-control" name="stages_new[${i}][ica_proof]">
      </td>
      <td>
        <input type="file" class="form-control" name="stages_new[${i}][hr_attach_file]">
      </td>
      <td class="stage-action text-center">
        <button type="button" class="btn btn-sm btn-success add-stage-group"><i class="fas fa-plus"></i></button>
        <button type="button" class="btn btn-sm btn-danger remove-stage-group"><i class="fas fa-minus"></i></button>
      </td>
    </tr>
    <tr class="stage-group finance-row" data-existing="0" data-index="${i}">
      <td>
        <span class="subrow-title" style="line-height:5;margin-left:10px;">Finance</span>
      </td>
      <td colspan="5">
        <div class="finance-grid">
          <div>
            <label class="form-label mb-1">Paid Amount</label>
            <input type="number" step="0.01" class="form-control" name="stages_new[${i}][fin_paid_amount]" placeholder="0.00">
          </div>
          <div>
            <label class="form-label mb-1">Zoho Payment Proof</label>
            <input type="file" class="form-control" name="stages_new[${i}][fin_zoho_proof]">
          </div>
          <div>
            <label class="form-label mb-1">Gov’t Invoice Proof</label>
            <input type="file" class="form-control" name="stages_new[${i}][fin_gov_invoice_proof]">
          </div>
          <div>
            <label class="form-label mb-1">
              Additional Files
              <button type="button" class="btn btn-sm btn-info ms-1 btn-preview-extra-new" data-index="${i}">
                <i class="fas fa-eye"></i>
              </button>
            </label>
            <input type="file" class="form-control" name="stages_new[${i}][fin_extra_files][]" multiple>
          </div>
        </div>
      </td>
      <td></td>
    </tr>`;
  }

  function renumberStageButtons(){
    const groups = $('#visa-stages-container .hr-row');
    groups.each(function(idx){
      $(this).find('.add-stage-group').toggle(idx === groups.length - 1);
      $(this).find('.remove-stage-group').toggle(groups.length > 1);
    });
  }

  function addStageGroup(){
    const html = buildNewStageGroup(window.stageIndex++);
    $('#visa-stages-container').append(html);
    initFlatpickr($('#visa-stages-container .hr-row').last());
    renumberStageButtons();
    refreshStageOptions();
    lockNewestStageToNext();
  }

  function removeStageGroup(btn){
    const $hr = $(btn).closest('tr.hr-row');
    const isExisting = $hr.data('existing') == 1;
    const idx = $hr.data('index');
    const id = $(btn).data('id') || $hr.data('id');

    if(isExisting && id){
      $('<input>').attr({ type:'hidden', name:'delete_stages[]', value:id }).appendTo('form');
    }

    $hr.remove();

    if(idx !== undefined){
      $(`#visa-stages-container .finance-row[data-index="${idx}"]`).remove();
    } else if(id){
      $(`#visa-stages-container .finance-row[data-id="${id}"]`).remove();
    }

    renumberStageButtons();
    refreshStageOptions();
  }

  function addAttachmentRow(){
    const tpl = `<tr class="attachment-row">
      <td>
        <select class="form-select attachment-type" name="attachment_type_new[]" required>
          <option selected disabled value="">Select Document Type...</option>
          @foreach($docTypes as $t)
            <option value="{{ $t }}">{{ $t }}</option>
          @endforeach
        </select>
      </td>
      <td>
        <input type="text" name="attachment_number_new[]" class="form-control" placeholder="Document Number">
      </td>
      <td>
        <input type="text" name="issued_on_new[]" class="form-control date-field">
      </td>
      <td>
        <input type="text" name="expired_on_new[]" class="form-control date-field">
      </td>
      <td>
        <input type="file" name="attachment_file_new[]" class="form-control" required>
      </td>
      <td>
        <button type="button" class="btn btn-sm btn-success add-attachment"><i class="fas fa-plus"></i></button>
        <button type="button" class="btn btn-sm btn-danger remove-attachment"><i class="fas fa-minus"></i></button>
      </td>
    </tr>`;
    $('#attachment-container').append(tpl);
    updateAttachmentButtons();
    initFlatpickr($('#attachment-container .attachment-row').last());
  }

  function updateAttachmentButtons(){
    const rows = $('#attachment-container .attachment-row');
    rows.each(function(i){
      $(this).find('.add-attachment').toggle(i === rows.length - 1);
      $(this).find('.remove-attachment').toggle(rows.length > 1);
    });
  }

  function applyIncidentRule(){
    const v = String($('#inside_status').val() || '');
    setIncidentRequired(v === '3');
  }

  function laravelKeyToBracketName(key){
    const parts = String(key).split('.');
    let out = parts[0];
    for(let i=1;i<parts.length;i++){
      out += '[' + parts[i] + ']';
    }
    return out;
  }

  function clearAjaxErrors(){
    $('#ajax-error-box').addClass('d-none');
    $('#ajax-error-list').empty();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback.ajax').remove();
  }

  function addTopError(msg){
    $('#ajax-error-list').append('<li>' + String(msg) + '</li>');
    $('#ajax-error-box').removeClass('d-none');
  }

  function findFieldByLaravelKey(key){
    const bracket = laravelKeyToBracketName(key);
    let $el = $('[name="' + bracket.replace(/"/g,'\\"') + '"]');
    if ($el.length) return $el;
    $el = $('[name="' + key.replace(/"/g,'\\"') + '"]');
    if ($el.length) return $el;

    const parts = String(key).split('.');
    if (parts.length >= 2) {
      const last = parts[parts.length - 1];
      const idx = parts[parts.length - 2];
      const base = parts.slice(0, parts.length - 2).join('.');

      if (/^\d+$/.test(idx)) {
        const bracketBase = laravelKeyToBracketName(base);
        const name1 = bracketBase + '[]';
        const $arr1 = $('[name="' + name1.replace(/"/g,'\\"') + '"]');
        if ($arr1.length) {
          const n = parseInt(idx, 10);
          if ($arr1.eq(n).length) return $arr1.eq(n);
        }

        const name2 = base + '[]';
        const $arr2 = $('[name="' + name2.replace(/"/g,'\\"') + '"]');
        if ($arr2.length) {
          const n = parseInt(idx, 10);
          if ($arr2.eq(n).length) return $arr2.eq(n);
        }

        if (last && /^\d+$/.test(last)) {
          const base2 = parts.slice(0, parts.length - 1).join('.');
          const bracketBase2 = laravelKeyToBracketName(base2);
          const name3 = bracketBase2 + '[]';
          const $arr3 = $('[name="' + name3.replace(/"/g,'\\"') + '"]');
          if ($arr3.length) {
            const n = parseInt(last, 10);
            if ($arr3.eq(n).length) return $arr3.eq(n);
          }
        }
      }
    }

    return $();
  }

  function showFieldError($field, message){
    if (!$field || !$field.length) {
      addTopError(message);
      return;
    }

    $field.addClass('is-invalid');

    let $target = $field;
    if ($field.hasClass('select2-hidden-accessible')) {
      const id = $field.attr('id');
      if (id) {
        const $sel = $('[aria-labelledby="select2-' + id + '-container"]').closest('.select2');
        if ($sel.length) $target = $sel;
      }
    }

    const $fb = $('<div class="invalid-feedback ajax d-block"></div>').text(message);

    if ($target.closest('.input-group').length) {
      $target.closest('.input-group').after($fb);
    } else {
      $target.after($fb);
    }
  }

  function scrollToFirstError(){
    const $first = $('.is-invalid').first();
    if ($first.length) {
      $('html, body').animate({ scrollTop: $first.offset().top - 120 }, 250);
    } else if (!$('#ajax-error-box').hasClass('d-none')) {
      $('html, body').animate({ scrollTop: $('#ajax-error-box').offset().top - 120 }, 250);
    }
  }

  $(document).on('input change','.is-invalid',function(){
    $(this).removeClass('is-invalid');
  });

  document.querySelectorAll('.salary-input').forEach(function(el){
    el.addEventListener('input', calculateTotal);
  });

  $(document).on('click','.add-attachment',function(e){
    e.preventDefault();
    const $row = $(this).closest('.attachment-row');
    const typeVal = ($row.find('.attachment-type')[0] || {}).value || '';
    const fileVal = ($row.find('input[name="attachment_file_new[]"]')[0] || {}).value || '';
    if(!typeVal || !fileVal){
      if(!typeVal) $row.find('.attachment-type').addClass('is-invalid');
      if(!fileVal) $row.find('input[name="attachment_file_new[]"]').addClass('is-invalid');
      alert('Please select the document type and file before adding a new row.');
      return;
    }
    addAttachmentRow();
  });

  $(document).on('click','.remove-attachment',function(){
    $(this).closest('.attachment-row').remove();
    updateAttachmentButtons();
  });

  $(document).on('click','.remove-attachment-existing',function(){
    const id = $(this).data('id');
    $('<input>').attr({ type:'hidden', name:'delete_attachments[]', value:id }).appendTo('form');
    $(this).closest('.attachment-row').remove();
    updateAttachmentButtons();
  });

  $(document).on('click','.add-stage-group',function(e){
    e.preventDefault();
    const $hr = $(this).closest('tr.hr-row');
    if(!validateStageGroup($hr)){
      alert('Please select stage, HR issue date and HR expiry date before adding a new one.');
      return;
    }
    addStageGroup();
  });

  $(document).on('click','.remove-stage-group',function(){
    removeStageGroup(this);
  });

  $(document).on('change','.stage-select',function(){
    refreshStageOptions();
  });

  $(document).on('change','#inside_status',function(){
    applyIncidentRule();
  });

  $(document).on('click','.btn-view-extra',function(){
    const files = $(this).data('files') || [];
    const title = $(this).data('title') || 'Additional Files';
    $('#stageExtraModalTitle').text(title);
    const $body = $('#stageExtraModalBody');
    $body.empty();
    if(!files.length){
      $body.append('<tr><td colspan="3">No files found.</td></tr>');
    } else {
      files.forEach(function(f,i){
        const name = f.name || 'File';
        const url = f.url || '#';
        $body.append(`<tr>
          <td>${i+1}</td>
          <td>${name}</td>
          <td class="text-center">
            <a href="${url}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
            <a href="${url}" download class="btn btn-sm btn-secondary"><i class="fas fa-download"></i></a>
          </td>
        </tr>`);
      });
    }
    if(window.bootstrap && bootstrap.Modal){
      new bootstrap.Modal(document.getElementById('stageExtraModal')).show();
    } else {
      $('#stageExtraModal').modal('show');
    }
  });

  $(document).on('click','.btn-preview-extra-new',function(){
    const i = $(this).data('index');
    const $input = $(`#visa-stages-container .finance-row[data-index="${i}"] input[name="stages_new[${i}][fin_extra_files][]"]`);
    const files = $input.get(0)?.files || [];
    $('#stageExtraModalTitle').text('Selected Additional Files');
    const $body = $('#stageExtraModalBody');
    $body.empty();
    if(!files.length){
      $body.append('<tr><td colspan="3">No files selected.</td></tr>');
    } else {
      Array.from(files).forEach(function(f,idx){
        $body.append(`<tr><td>${idx+1}</td><td colspan="2">${f.name}</td></tr>`);
      });
    }
    if(window.bootstrap && bootstrap.Modal){
      new bootstrap.Modal(document.getElementById('stageExtraModal')).show();
    } else {
      $('#stageExtraModal').modal('show');
    }
  });

  $(document).ready(function(){
    window.stageIndex = {{ $visaStages->count() == 0 ? 1 : $visaStages->count() }};
    initFlatpickr();
    renumberStageButtons();
    refreshStageOptions();
    lockNewestStageToNext();
    calculateTotal();
    updateAttachmentButtons();
    applyIncidentRule();
  });

  $('#employee-edit-form').off('submit').on('submit', function(e){
    e.preventDefault();
    clearAjaxErrors();

    let ok = true;
    applyIncidentRule();

    if($('#inside_status').val() === '3'){
      const t = ($('#incident_type')[0] || {}).value || '';
      const d = ($('#incident_date')[0] || {}).value || '';
      if(!t){ showFieldError($('#incident_type'), 'Incident Type is required.'); ok = false; }
      if(!d){ showFieldError($('#incident_date'), 'Incident Date is required.'); ok = false; }
    }

    const used = new Set();
    $('#visa-stages-container .hr-row').each(function(){
      const $hr = $(this);

      const stageEl = $hr.find('select.stage-select');
      const issueEl = $hr.find('input[name$="[hr_issue_date]"]');
      const expiryEl = $hr.find('input[name$="[hr_expiry_date]"]');

      const sv = stageEl.val();
      const iv = issueEl.val();
      const ev = expiryEl.val();

      if(!sv){ showFieldError(stageEl, 'Stage is required.'); ok = false; }
      if(!iv){ showFieldError(issueEl, 'HR issue date is required.'); ok = false; }
      if(!ev){ showFieldError(expiryEl, 'HR expiry date is required.'); ok = false; }

      if(sv){
        if(used.has(sv)){
          showFieldError(stageEl, 'Each stage can be selected only once.');
          ok = false;
        } else {
          used.add(sv);
        }
      }
    });

    if(!ok){
      scrollToFirstError();
      return;
    }

    const $btn = $('#btn-update');
    $btn.prop('disabled', true);

    const form = this;
    const fd = new FormData(form);

    $.ajax({
      url: $(form).attr('action'),
      method: 'POST',
      data: fd,
      processData: false,
      contentType: false,
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      success: function(res){
        if(res && res.redirect){
          window.location.href = res.redirect;
          return;
        }
        window.location.reload();
      },
      error: function(xhr){
        $btn.prop('disabled', false);

        if(xhr.status === 422){
          const json = xhr.responseJSON || {};
          const errors = json.errors || {};

          Object.keys(errors).forEach(function(key){
            const msgs = errors[key] || [];
            const msg = Array.isArray(msgs) ? msgs[0] : String(msgs);
            const $field = findFieldByLaravelKey(key);
            showFieldError($field, msg);
          });

          const flat = [];
          Object.keys(errors).forEach(function(key){
            (errors[key] || []).forEach(function(m){ flat.push(m); });
          });
          flat.slice(0, 50).forEach(addTopError);

          scrollToFirstError();
          return;
        }

        const json = xhr.responseJSON || {};
        addTopError(json.message || 'Something went wrong.');
        if (json.error) addTopError(json.error);
        scrollToFirstError();
      }
    });
  });
</script>

@include('../layout.footer')
