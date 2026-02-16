@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Agent</h5>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('agents.update', $agent->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('PUT')
                       <!--  <div class="col-md-6">
                            <label for="agentID" class="form-label">Agent ID <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="id" class="form-control" id="agentID" value="{{ $agent->id }}" readonly>
                            </div>
                        </div> -->
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Name <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" id="inputName" value="{{ old('name', $agent->name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCompanyName" class="form-label">Company Name <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                <input type="text" name="company_name" class="form-control" id="inputCompanyName" value="{{ old('company_name', $agent->company_name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputBranchName" class="form-label">Branch Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" name="branch_name" class="form-control" id="inputBranchName" value="{{ old('branch_name', $agent->branch_name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCountry" class="form-label">Country <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                <select name="country" class="form-control" id="inputCountry" required>
                                    <option value="">Select Country</option>
                                    <option value="Ethiopia" {{ old('country', $agent->country) == 'Ethiopia' ? 'selected' : '' }}>Ethiopia</option>
                                    <option value="Sri Lanka" {{ old('country', $agent->country) == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                    <option value="Philippines" {{ old('country', $agent->country) == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                    <option value="India" {{ old('country', $agent->country) == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="Uganda" {{ old('country', $agent->country) == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                    <option value="Myanmar" {{ old('country', $agent->country) == 'Myanmar' ? 'selected' : '' }}>Myanmar</option>
                                </select>
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
