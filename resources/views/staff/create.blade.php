@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
  body {
    background: linear-gradient(to right, #e0f7fa, #e1bee7);
    font-family: Arial, sans-serif;
  }
  .form-select { font-size: 12px; }
  .select2-container .select2-selection--single { height: 38px; font-size: 12px; padding: 6px 12px; }
  .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 24px; }
</style>
<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Create Staff Member</h5>
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <form method="POST" action="{{ route('staff.store') }}" class="row g-3">
              @csrf
              <div class="col-md-6">
                <label for="inputName" class="form-label">Name of Staff <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="name_of_staff" class="form-control" id="inputName" placeholder="Enter name" value="{{ old('name_of_staff') }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <label for="nationality" class="form-label">NATIONALITY</label>
                <select name="nationality" class="form-control select2" id="nationality"></select>
              </div>
              <div class="col-md-6">
                <label for="inputPassportNo" class="form-label">Passport Number <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-passport"></i></span>
                  <input type="text" name="passport_no" class="form-control" id="inputPassportNo" value="{{ old('passport_no') }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputPassportExpiry" class="form-label">Passport Expiry Date <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" name="passport_expiry_date" class="form-control flatpickr-input" id="inputPassportExpiry" value="{{ old('passport_expiry_date') }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputStatus" class="form-label">Status <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                  <select name="status" class="form-select" id="inputStatus" required>
                    <option selected disabled value="">{{ __('Choose...') }}</option>
                    <option value="AVAILABLE" {{ old('status') == 'AVAILABLE' ? 'selected' : '' }}>AVAILABLE</option>
                    <option value="HOLD" {{ old('status') == 'HOLD' ? 'selected' : '' }}>HOLD</option>
                    <option value="SELECTED" {{ old('status') == 'SELECTED' ? 'selected' : '' }}>SELECTED</option>
                    <option value="WC-DATE" {{ old('status') == 'WC-DATE' ? 'selected' : '' }}>WC-DATE</option>
                    <option value="VISA DATE" {{ old('status') == 'VISA DATE' ? 'selected' : '' }}>VISA DATE</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputDateOfJoining" class="form-label">Date of Joining <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                  <input type="text" name="date_of_joining" class="form-control flatpickr-input" id="inputDateOfJoining" value="{{ old('date_of_joining') }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputActualDesignation" class="form-label">Actual Designation</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                  <input type="text" name="actual_designation" class="form-control" id="inputActualDesignation" value="{{ old('actual_designation') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputVisaDesignation" class="form-label">Visa Designation</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                  <input type="text" name="visa_designation" class="form-control" id="inputVisaDesignation" value="{{ old('visa_designation') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputGender" class="form-label">Gender</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                  <select name="gender" class="form-select" id="inputGender">
                    <option selected disabled value="">{{ __('Choose...') }}</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputDateOfBirth" class="form-label">Date of Birth</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  <input type="text" name="date_of_birth" class="form-control flatpickr-input" id="inputDateOfBirth" value="{{ old('date_of_birth') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputMaritalStatus" class="form-label">Marital Status</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-heart"></i></span>
                  <select name="marital_status" class="form-select" id="inputMaritalStatus">
                    <option selected disabled value="">{{ __('Choose...') }}</option>
                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                    <option value="unmarried" {{ old('marital_status') == 'unmarried' ? 'selected' : '' }}>Unmarried</option>
                    <option value="other" {{ old('marital_status') == 'other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputContractStartDate" class="form-label">Employment Contract Start Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" name="employment_contract_start_date" class="form-control flatpickr-input" id="inputContractStartDate" value="{{ old('employment_contract_start_date') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputContractEndDate" class="form-label">Employment Contract End Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" name="employment_contract_end_date" class="form-control flatpickr-input" id="inputContractEndDate" value="{{ old('employment_contract_end_date') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputContractType" class="form-label">Contract Type</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                  <input type="text" name="contract_type" class="form-control" id="inputContractType" value="{{ old('contract_type') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputFileEntryPermitNo" class="form-label">File/Entry Permit No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file"></i></span>
                  <input type="text" name="file_entry_permit_no" class="form-control" id="inputFileEntryPermitNo" value="{{ old('file_entry_permit_no') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputUidNo" class="form-label">UID No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  <input type="text" name="uid_no" class="form-control" id="inputUidNo" value="{{ old('uid_no') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputContactNo" class="form-label">Contact No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                  <input type="text" name="contact_no" class="form-control" id="inputContactNo" value="{{ old('contact_no') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputTempWorkPermitNo" class="form-label">Temp Work Permit No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                  <input type="text" name="temp_work_permit_no" class="form-control" id="inputTempWorkPermitNo" value="{{ old('temp_work_permit_no') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputTempWorkPermitExpiry" class="form-label">Temp Work Permit Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" name="temp_work_permit_expiry_date" class="form-control flatpickr-input" id="inputTempWorkPermitExpiry" value="{{ old('temp_work_permit_expiry_date') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputPersonalNo" class="form-label">Personal No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  <input type="text" name="personal_no" class="form-control" id="inputPersonalNo" value="{{ old('personal_no') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputLaborCardNo" class="form-label">Labor Card No <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  <input type="text" name="labor_card_no" class="form-control" id="inputLaborCardNo" value="{{ old('labor_card_no') }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputLaborCardExpiry" class="form-label">Labor Card Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" name="labor_card_expiry_date" class="form-control flatpickr-input" id="inputLaborCardExpiry" value="{{ old('labor_card_expiry_date') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputResidenceVisaStart" class="form-label">Residence Visa Start Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" name="residence_visa_start_date" class="form-control flatpickr-input" id="inputResidenceVisaStart" value="{{ old('residence_visa_start_date') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputResidenceVisaExpiry" class="form-label">Residence Visa Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" name="residence_visa_expiry_date" class="form-control flatpickr-input" id="inputResidenceVisaExpiry" value="{{ old('residence_visa_expiry_date') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputEmiratesIdNumber" class="form-label">Emirates ID Number <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  <input type="text" name="emirates_id_number" class="form-control" id="inputEmiratesIdNumber" value="{{ old('emirates_id_number') }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputEidExpiry" class="form-label">EID Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" name="eid_expiry_date" class="form-control flatpickr-input" id="inputEidExpiry" value="{{ old('eid_expiry_date') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputSalaryAsPerContract" class="form-label">Salary as Per Contract</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                  <input type="number" name="salary_as_per_contract" class="form-control" id="inputSalaryAsPerContract" value="{{ old('salary_as_per_contract') }}" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputBasicSalary" class="form-label">Basic Salary</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                  <input type="number" name="basic" class="form-control" id="inputBasicSalary" value="{{ old('basic') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputHousing" class="form-label">Housing Allowance</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-home"></i></span>
                  <input type="number" name="housing" class="form-control" id="inputHousing" value="{{ old('housing') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputTransport" class="form-label">Transport Allowance</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-bus"></i></span>
                  <input type="number" name="transport" class="form-control" id="inputTransport" value="{{ old('transport') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputOtherAllowances" class="form-label">Other Allowances</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                  <input type="number" name="other_allowances" class="form-control" id="inputOtherAllowances" value="{{ old('other_allowances') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputTotalSalary" class="form-label">Total Salary</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                  <input type="number" name="total_salary" class="form-control" id="inputTotalSalary" value="{{ old('total_salary') }}" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputBankName" class="form-label">Bank Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-university"></i></span>
                  <input type="text" name="bank_name" class="form-control" id="inputBankName" value="{{ old('bank_name') }}">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputIban" class="form-label">IBAN</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                  <input type="text" name="iban" class="form-control" id="inputIban" value="{{ old('iban') }}">
                </div>
              </div>
              <div class="col-12">
                <label for="inputComments" class="form-label">Comments</label>
                <textarea name="comments" class="form-control" id="inputComments" rows="3">{{ old('comments') }}</textarea>
              </div>
              <div class="col-12">
                <label for="inputRemarks" class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control" id="inputRemarks" rows="3">{{ old('remarks') }}</textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@include('../layout.footer')
<script>
$(document).ready(function() {
  $('.select2').select2({
    width: '100%',
    placeholder: 'SEARCH AND SELECT'
  });
  $.ajax({
    url: '{{ route("get.countries") }}',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      $.each(data, function(index, item) {
        $('#nationality').append(new Option(item.name.toUpperCase(), item.name));
      });
      $('#nationality').trigger('change');
    },
    error: function(xhr, status, error) {
      console.error(error);
    }
  });
  function calculateSalary() {
    var basic = parseFloat($('#inputBasicSalary').val()) || 0;
    var housing = parseFloat($('#inputHousing').val()) || 0;
    var transport = parseFloat($('#inputTransport').val()) || 0;
    var other = parseFloat($('#inputOtherAllowances').val()) || 0;
    var total = basic + housing + transport + other;
    $('#inputTotalSalary').val(total);
    $('#inputSalaryAsPerContract').val(total);
  }
  $('#inputBasicSalary, #inputHousing, #inputTransport, #inputOtherAllowances').on('keyup change', calculateSalary);
  calculateSalary();
});
</script>
