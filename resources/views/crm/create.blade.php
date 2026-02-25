@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<main class="main p-2">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add New Customer</h5>

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

            <form action="{{ route('crm.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="row g-3">
              @csrf

              <div class="col-md-6" style="display:none;">
                <label class="form-label">Customer ID <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  <input type="text"
                         name="cl"
                         class="form-control"
                         value="{{ $newCustomerId }}"
                         readonly>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text"
                         name="first_name"
                         class="form-control"
                         value="{{ old('first_name') }}"
                         required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text"
                         name="last_name"
                         class="form-control"
                         value="{{ old('last_name') }}"
                         required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Country <span class="text-danger">*</span></label>
                <div class="input-group">
                  <select name="nationality"
                          class="form-select select2"
                          required>
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                      <option value="{{ $country['name'] }}"
                        {{ old('nationality') === $country['name'] ? 'selected' : '' }}>
                        {{ $country['name'] }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Address <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  <input type="text"
                         name="address"
                         class="form-control"
                         value="{{ old('address') }}"
                         required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">State <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-flag"></i></span>
                  <select name="state"
                          class="form-select"
                          required>
                    <option value="">Choose...</option>
                    @foreach([
                      'ABU DHABI','AJMAN','AL AIN','DUBAI',
                      'FUJAIRAH','RAS AL KHAIMAH','SHARJAH','UMM AL QUWAIN'
                    ] as $st)
                      <option value="{{ $st }}"
                        {{ old('state') === $st ? 'selected' : '' }}>
                        {{ $st }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input type="email"
                         name="email"
                         class="form-control"
                         value="{{ old('email') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Mobile <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                  <input type="text"
                         name="mobile"
                         id="inputMobile"
                         class="form-control"
                         placeholder="0501234567"
                         value="{{ old('mobile') }}"
                         required>
                </div>
                <div id="mobileError"
                     class="text-danger small mt-1"
                     style="display:none;">
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
                         class="form-control"
                         placeholder="784-XXXX-XXXXXXX-X"
                         value="{{ old('emirates_id') }}"
                         required>
                </div>
                <div id="emiratesIdError"
                     class="text-danger small mt-1"
                     style="display:none;">
                  Please enter a valid Emirates ID.
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Emergency Contact Person</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                  <input type="text"
                         name="emergency_contact_person"
                         class="form-control"
                         value="{{ old('emergency_contact_person') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Source</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-bullhorn"></i></span>
                  <select name="source" class="form-select">
                    <option value="">Choose...</option>
                    @foreach(['Social Media','Referral','Walk-in','Others'] as $src)
                      <option value="{{ $src }}"
                        {{ old('source') === $src ? 'selected' : '' }}>
                        {{ $src }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Passport Number <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-passport"></i></span>
                  <input type="text"
                         name="passport_number"
                         class="form-control"
                         value="{{ old('passport_number') }}"
                         required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Passport Copy <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                  <input type="file"
                         name="passport_copy"
                         class="form-control"
                         accept="application/pdf,image/*"
                         required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Emirates ID Copy <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                  <input type="file"
                         name="id_copy"
                         class="form-control"
                         accept="application/pdf,image/*"
                         required>
                </div>
              </div>

              {{-- ─── Payment Methods ─── --}}
              <div class="col-12">
                <hr>
                <h6 class="mb-3"><i class="fas fa-credit-card me-1"></i> Payment Methods</h6>
                <div id="paymentMethodsContainer">
                  {{-- First row is always visible --}}
                  <div class="row g-2 mb-2 payment-method-row">
                    <div class="col-md-4">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                        <input type="text"
                               name="payment_methods[0][iban]"
                               class="form-control"
                               placeholder="IBAN"
                               value="{{ old('payment_methods.0.iban') }}">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                        <input type="text"
                               name="payment_methods[0][bank]"
                               class="form-control"
                               placeholder="Bank Name"
                               value="{{ old('payment_methods.0.bank') }}">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                        <input type="text"
                               name="payment_methods[0][note]"
                               class="form-control"
                               placeholder="Note"
                               value="{{ old('payment_methods.0.note') }}">
                      </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                      <button type="button"
                              class="btn btn-outline-danger btn-sm remove-payment-method"
                              title="Remove"
                              style="display:none;">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <button type="button"
                        class="btn btn-outline-primary btn-sm mt-1"
                        id="addPaymentMethod">
                  <i class="fas fa-plus me-1"></i> Add Payment Method
                </button>
              </div>

              <div class="col-12">
                <button type="submit"
                        class="btn btn-primary"
                        id="submitButton"
                        >
                  Submit
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

    /* ── Payment Methods dynamic rows ── */
    let pmIndex = 1;

    $('#addPaymentMethod').on('click', function(){
      const row = `
        <div class="row g-2 mb-2 payment-method-row">
          <div class="col-md-4">
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="fas fa-university"></i></span>
              <input type="text" name="payment_methods[${pmIndex}][iban]" class="form-control" placeholder="IBAN">
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="fas fa-building"></i></span>
              <input type="text" name="payment_methods[${pmIndex}][bank]" class="form-control" placeholder="Bank Name">
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
              <input type="text" name="payment_methods[${pmIndex}][note]" class="form-control" placeholder="Note">
            </div>
          </div>
          <div class="col-md-1 d-flex align-items-center">
            <button type="button" class="btn btn-outline-danger btn-sm remove-payment-method" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>`;
      $('#paymentMethodsContainer').append(row);
      pmIndex++;
      toggleRemoveButtons();
    });

    $(document).on('click', '.remove-payment-method', function(){
      $(this).closest('.payment-method-row').remove();
      toggleRemoveButtons();
    });

    function toggleRemoveButtons(){
      const rows = $('.payment-method-row');
      rows.find('.remove-payment-method').toggle(rows.length > 1);
    }
  });
</script>
