@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add New Customer</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('crm.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="customerID" class="form-label">Customer ID <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="cl" class="form-control" id="customerID" value="{{ $newCustomerId }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Name <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" id="inputName" value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputNationality" class="form-label">Nationality <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                <select name="nationality" class="form-select" id="inputNationality" required>
                                    <option disabled value="">Choose...</option>
                                    <option value="Abu Dhabi" {{ old('nationality') == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
                                    <option value="Dubai" {{ old('nationality') == 'Dubai' ? 'selected' : '' }}>Dubai</option>
                                    <option value="Sharjah" {{ old('nationality') == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
                                    <option value="Ajman" {{ old('nationality') == 'Ajman' ? 'selected' : '' }}>Ajman</option>
                                    <option value="Ras Al Khaimah" {{ old('nationality') == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option>
                                    <option value="Fujairah" {{ old('nationality') == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
                                    <option value="Umm Al Quwain" {{ old('nationality') == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" id="inputEmail" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputMobile" class="form-label">Mobile <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" name="mobile" class="form-control" id="inputMobile" placeholder="0501234567" value="{{ old('mobile') }}" required>
                            </div>
                            <div id="mobileError" class="text-danger small mt-1" style="display: none;">Please enter a valid UAE mobile number (e.g., 0501234567).</div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmiratesId" class="form-label">Emirates ID <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                <input type="text" name="emirates_id" class="form-control" id="inputEmiratesId" placeholder="784-XXXX-XXXXXXX-X" value="{{ old('emirates_id') }}" required>
                            </div>
                            <div id="emiratesIdError" class="text-danger small mt-1" style="display: none;">Please enter a valid Emirates ID (784-XXXX-XXXXXXX-X).</div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmergencyContact" class="form-label">Emergency Contact Person</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                <input type="text" name="emergency_contact_person" class="form-control" id="inputEmergencyContact" value="{{ old('emergency_contact_person') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputSource" class="form-label">Source</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-bullhorn"></i></span>
                                <select name="source" class="form-select" id="inputSource">
                                    <option disabled value="">Choose...</option>
                                    <option value="Social Media" {{ old('source') == 'Social Media' ? 'selected' : '' }}>Social Media</option>
                                    <option value="Referral" {{ old('source') == 'Referral' ? 'selected' : '' }}>Referral</option>
                                    <option value="Walk-in" {{ old('source') == 'Walk-in' ? 'selected' : '' }}>Walk-in</option>
                                    <option value="Others" {{ old('source') == 'Others' ? 'selected' : '' }}>Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassportCopy" class="form-label">Passport Copy <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-file-pdf"></i></span>
                                <input type="file" name="passport_copy" class="form-control" id="inputPassportCopy" accept="application/pdf" required>
                            </div>
                            <small class="text-muted">Only PDF files are allowed.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="inputIdCopy" class="form-label">Emirates ID Copy<span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-file-pdf"></i></span>
                                <input type="file" name="id_copy" class="form-control" id="inputIdCopy" accept="application/pdf" required>
                            </div>
                            <small class="text-muted">Only PDF files are allowed.</small>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
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
        const uaeMobilePattern = /^(050|055|056|058|052|054)\d{7}$/;
        const emiratesIdPattern = /^784-\d{4}-\d{7}-\d$/;
        $('#inputMobile').on('keyup', function() {
            const mobile = $(this).val();
            if (uaeMobilePattern.test(mobile)) {
                $('#mobileError').hide();
                validateForm();
            } else {
                $('#mobileError').show();
            }
        });

        $('#inputEmiratesId').on('keyup', function() {
            const emiratesId = $(this).val();
            if (emiratesIdPattern.test(emiratesId)) {
                $('#emiratesIdError').hide();
                validateForm();
            } else {
                $('#emiratesIdError').show();
            }
        });

        function validateForm() {
            if (uaeMobilePattern.test($('#inputMobile').val()) && emiratesIdPattern.test($('#inputEmiratesId').val())) {
                $('#submitButton').prop('disabled', false);
            }
        }
    });
</script>
