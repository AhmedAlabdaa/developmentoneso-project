@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<main class="main p-2">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Customer</h5>

            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @elseif(session('error'))
              <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('crm.update', $crm->slug) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="row g-3">
              @csrf
              @method('PUT')

              <div class="col-md-6" style="display:none;">
                <label class="form-label">Customer ID <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  <input type="text"
                         name="cl"
                         class="form-control"
                         value="{{ $crm->cl }}"
                         readonly>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text"
                         name="first_name"
                         class="form-control @error('first_name') is-invalid @enderror"
                         value="{{ old('first_name', $crm->first_name) }}"
                         required>
                  @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text"
                         name="last_name"
                         class="form-control @error('last_name') is-invalid @enderror"
                         value="{{ old('last_name', $crm->last_name) }}"
                         required>
                  @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Country <span class="text-danger">*</span></label>
                <div class="input-group">
                  <select name="nationality"
                          class="form-select select2 @error('nationality') is-invalid @enderror"
                          required>
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                      <option value="{{ $country['name'] }}"
                        {{ old('nationality', $crm->nationality) === $country['name'] ? 'selected' : '' }}>
                        {{ $country['name'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('nationality')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Address <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  <input type="text"
                         name="address"
                         class="form-control @error('address') is-invalid @enderror"
                         value="{{ old('address', $crm->address) }}"
                         required>
                  @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">State <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-flag"></i></span>
                  <select name="state"
                          class="form-select @error('state') is-invalid @enderror"
                          required>
                    <option value="">Choose...</option>
                    @foreach([
                      'ABU DHABI','AJMAN','AL AIN','DUBAI',
                      'FUJAIRAH','RAS AL KHAIMAH','SHARJAH','UMM AL QUWAIN'
                    ] as $st)
                      <option value="{{ $st }}"
                        {{ old('state', $crm->state) === $st ? 'selected' : '' }}>
                        {{ $st }}
                      </option>
                    @endforeach
                  </select>
                  @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input type="email"
                         name="email"
                         class="form-control @error('email') is-invalid @enderror"
                         value="{{ old('email', $crm->email) }}">
                  @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Mobile <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                  <input type="text"
                         name="mobile"
                         id="inputMobile"
                         class="form-control @error('mobile') is-invalid @enderror"
                         placeholder="0501234567"
                         value="{{ old('mobile', $crm->mobile) }}"
                         required>
                  @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div id="mobileError" class="text-danger small mt-1" style="display:none;">
                  Please enter a valid UAE mobile number.
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Emirates ID <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                  <input type="text"
                         name="emirates_id"
                         id="inputEmiratesId"
                         class="form-control @error('emirates_id') is-invalid @enderror"
                         placeholder="784-XXXX-XXXXXXX-X"
                         value="{{ old('emirates_id', $crm->emirates_id) }}"
                         required>
                  @error('emirates_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div id="emiratesIdError" class="text-danger small mt-1" style="display:none;">
                  Please enter a valid Emirates ID.
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Emergency Contact Person</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                  <input type="text"
                         name="emergency_contact_person"
                         class="form-control @error('emergency_contact_person') is-invalid @enderror"
                         value="{{ old('emergency_contact_person', $crm->emergency_contact_person) }}">
                  @error('emergency_contact_person')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Source</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-bullhorn"></i></span>
                  <select name="source" class="form-select @error('source') is-invalid @enderror">
                    <option value="">Choose...</option>
                    @foreach(['Social Media','Referral','Walk-in','Others'] as $src)
                      <option value="{{ $src }}"
                        {{ old('source', $crm->source) === $src ? 'selected' : '' }}>
                        {{ $src }}
                      </option>
                    @endforeach
                  </select>
                  @error('source')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Passport Number <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-passport"></i></span>
                  <input type="text"
                         name="passport_number"
                         class="form-control @error('passport_number') is-invalid @enderror"
                         value="{{ old('passport_number', $crm->passport_number) }}"
                         required>
                  @error('passport_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Passport Copy <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                  <input type="file"
                         name="passport_copy"
                         class="form-control @error('passport_copy') is-invalid @enderror"
                         accept="application/pdf,image/*">
                  @error('passport_copy')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <small class="text-muted">Current: <a href="{{ asset('storage/'.$crm->passport_copy) }}" target="_blank">View</a></small>
              </div>

              <div class="col-md-6">
                <label class="form-label">Emirates ID Copy <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                  <input type="file"
                         name="id_copy"
                         class="form-control @error('id_copy') is-invalid @enderror"
                         accept="application/pdf,image/*">
                  @error('id_copy')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <small class="text-muted">Current: <a href="{{ asset('storage/'.$crm->id_copy) }}" target="_blank">View</a></small>
              </div>

              <div class="col-12">
                <button type="submit"
                        class="btn btn-primary"
                        id="submitButton">
                  Update
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(function(){
    $('.select2').select2({ placeholder:'Select Country', width:'100%' });

    const mobilePattern    = /^(050|055|056|058|052|054)\d{7}$/;
    const emiratesPattern  = /^784-\d{4}-\d{7}-\d$/;

    function checkAll(){
      return mobilePattern.test($('#inputMobile').val())
          && emiratesPattern.test($('#inputEmiratesId').val());
    }

    $('#inputMobile').on('input',function(){
      mobilePattern.test(this.value)
        ? $('#mobileError').hide()
        : $('#mobileError').show();
      // $('#submitButton').prop('disabled', !checkAll());
    });

    $('#inputEmiratesId').on('input',function(){
      emiratesPattern.test(this.value)
        ? $('#emiratesIdError').hide()
        : $('#emiratesIdError').show();
      // $('#submitButton').prop('disabled', !checkAll());
    });
  });
</script>
