@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Customer</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('crm.update', $crm->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6">
                                <label for="customerID" class="form-label">Customer ID <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="cl" class="form-control" id="customerID" value="{{ $crm->cl }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputName" class="form-label">Name <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="name" class="form-control" id="inputName" value="{{ old('name', $crm->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $crm->address) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputNationality" class="form-label">Nationality <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                    <select name="nationality" class="form-select" id="inputNationality" required>
                                        <option disabled value="">Choose...</option>
                                        <option value="Abu Dhabi" {{ old('nationality', $crm->nationality) == 'Abu Dhabi' ? 'selected' : '' }}>Abu Dhabi</option>
                                        <option value="Dubai" {{ old('nationality', $crm->nationality) == 'Dubai' ? 'selected' : '' }}>Dubai</option>
                                        <option value="Sharjah" {{ old('nationality', $crm->nationality) == 'Sharjah' ? 'selected' : '' }}>Sharjah</option>
                                        <option value="Ajman" {{ old('nationality', $crm->nationality) == 'Ajman' ? 'selected' : '' }}>Ajman</option>
                                        <option value="Ras Al Khaimah" {{ old('nationality', $crm->nationality) == 'Ras Al Khaimah' ? 'selected' : '' }}>Ras Al Khaimah</option>
                                        <option value="Fujairah" {{ old('nationality', $crm->nationality) == 'Fujairah' ? 'selected' : '' }}>Fujairah</option>
                                        <option value="Umm Al Quwain" {{ old('nationality', $crm->nationality) == 'Umm Al Quwain' ? 'selected' : '' }}>Umm Al Quwain</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" id="inputEmail" value="{{ old('email', $crm->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputMobile" class="form-label">Mobile <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="mobile" class="form-control" id="inputMobile" placeholder="0501234567" value="{{ old('mobile', $crm->mobile) }}" required>
                                </div>
                                <div id="mobileError" class="text-danger small mt-1" style="display: none;">Please enter a valid UAE mobile number (e.g., 0501234567).</div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmiratesId" class="form-label">Emirates ID <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                    <input type="text" name="emirates_id" class="form-control" id="inputEmiratesId" placeholder="784-XXXX-XXXXXXX-X" value="{{ old('emirates_id', $crm->emirates_id) }}" required>
                                </div>
                                <div id="emiratesIdError" class="text-danger small mt-1" style="display: none;">Please enter a valid Emirates ID (784-XXXX-XXXXXXX-X).</div>
                            </div>
                            <div class="col-md-6">
                                <label for="passport_number" class="form-label">Passport Number <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-passport"></i></span>
                                    <input type="text" name="passport_number" class="form-control" id="passport_number" value="{{ old('passport_number', $crm->passport_number) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassportCopy" class="form-label">Passport Copy <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-pdf"></i></span>
                                    <input type="file" name="passport_copy" class="form-control" id="inputPassportCopy" accept="application/pdf">
                                </div>
                                <small class="text-muted">Only PDF files are allowed. Current: <a href="{{ asset('storage/' . $crm->passport_copy) }}" target="_blank">View Passport Copy</a></small>
                            </div>
                            <div class="col-md-6">
                                <label for="inputIdCopy" class="form-label">Emirates ID Copy <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-file-pdf"></i></span>
                                    <input type="file" name="id_copy" class="form-control" id="inputIdCopy" accept="application/pdf">
                                </div>
                                <small class="text-muted">Only PDF files are allowed. Current: <a href="{{ asset('storage/' . $crm->id_copy) }}" target="_blank">View ID Copy</a></small>
                            </div>
                            <div class="col-md-6">
                                <label for="inputSource" class="form-label">Source</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-bullhorn"></i></span>
                                    <select name="source" class="form-select" id="inputSource">
                                        <option disabled value="">Choose...</option>
                                        <option value="Social Media" {{ old('source', $crm->source) == 'Social Media' ? 'selected' : '' }}>Social Media</option>
                                        <option value="Referral" {{ old('source', $crm->source) == 'Referral' ? 'selected' : '' }}>Referral</option>
                                        <option value="Walk-in" {{ old('source', $crm->source) == 'Walk-in' ? 'selected' : '' }}>Walk-in</option>
                                        <option value="Others" {{ old('source', $crm->source) == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmergencyContact" class="form-label">Emergency Contact Person</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                    <input type="text" name="emergency_contact_person" class="form-control" id="inputEmergencyContact" value="{{ old('emergency_contact_person', $crm->emergency_contact_person) }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" id="submitButton">Update</button>
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
            } else {
                $('#mobileError').show();
            }
        });

        $('#inputEmiratesId').on('keyup', function() {
            const emiratesId = $(this).val();
            if (emiratesIdPattern.test(emiratesId)) {
                $('#emiratesIdError').hide();
            } else {
                $('#emiratesIdError').show();
            }
        });
    });
</script>
