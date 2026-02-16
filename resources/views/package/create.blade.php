@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Package</h5>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('package.store') }}" method="POST" class="row g-3">
              @csrf

              <div class="col-md-6">
                <label for="candidate_name" class="form-label">Candidate Name <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="candidate_name" class="form-control" id="candidate_name" value="{{ old('candidate_name') }}" required>
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
                    @php
                      $upperName = strtoupper($country->NAME);
                    @endphp
                    @if(in_array($upperName, $allowedCountries))
                      <option value="{{ $upperName }}" {{ old('nationality') == $upperName ? 'selected' : '' }}>
                        {{ $upperName }}
                      </option>
                    @endif
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="passport_no" class="form-label">Passport No <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                  <input type="text" name="passport_no" class="form-control" id="passport_no" value="{{ old('passport_no') }}" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="foreign_partner" class="form-label">Foreign Partner</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                  <input type="text" name="foreign_partner" class="form-control" id="foreign_partner" value="{{ old('foreign_partner') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="passport_expiry_date" class="form-label">Passport Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="passport_expiry_date" class="form-control" id="passport_expiry_date" value="{{ old('passport_expiry_date') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  <input type="date" name="date_of_birth" class="form-control" id="date_of_birth" value="{{ old('date_of_birth') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="passport_issue_date" class="form-label">Passport Issue Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                  <input type="date" name="passport_issue_date" class="form-control" id="passport_issue_date" value="{{ old('passport_issue_date') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="experience_years" class="form-label">Experience in Years</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                  <input type="number" min="0" step="1" name="experience_years" class="form-control" id="experience_years" value="{{ old('experience_years') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="marital_status" class="form-label">Marital Status</label>
                <select name="marital_status" id="marital_status" class="form-select">
                  <option value="">Select status</option>
                  <option value="1" {{ old('marital_status') == '1' ? 'selected' : '' }}>Single</option>
                  <option value="2" {{ old('marital_status') == '2' ? 'selected' : '' }}>Married</option>
                  <option value="3" {{ old('marital_status') == '3' ? 'selected' : '' }}>Divorced</option>
                  <option value="4" {{ old('marital_status') == '4' ? 'selected' : '' }}>Widowed</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="number_of_children" class="form-label">Number of Children</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-child"></i></span>
                  <input type="number" min="0" step="1" name="number_of_children" class="form-control" id="number_of_children" value="{{ old('number_of_children') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="religion" class="form-label">Religion</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-praying-hands"></i></span>
                  <input type="text" name="religion" class="form-control" id="religion" value="{{ old('religion') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="place_of_birth" class="form-label">Place of Birth</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  <input type="text" name="place_of_birth" class="form-control" id="place_of_birth" value="{{ old('place_of_birth') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="living_town" class="form-label">Living Town</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-city"></i></span>
                  <input type="text" name="living_town" class="form-control" id="living_town" value="{{ old('living_town') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="place_of_issue" class="form-label">Place of Issue</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                  <input type="text" name="place_of_issue" class="form-control" id="place_of_issue" value="{{ old('place_of_issue') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="education" class="form-label">Education</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                  <input type="text" name="education" class="form-control" id="education" value="{{ old('education') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="languages" class="form-label">Languages</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-language"></i></span>
                  <input type="text" name="languages" class="form-control" id="languages" value="{{ old('languages') }}">
                </div>
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary" id="submitButton">
                  <i class="fas fa-save"></i> Submit
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
$(document).ready(function() {
  $('.select2-country').select2({
    theme: 'bootstrap-5',
    width: '100%',
    placeholder: 'Select country',
    allowClear: true
  });
});
</script>
