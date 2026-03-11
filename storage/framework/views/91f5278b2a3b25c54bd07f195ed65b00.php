<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .form-section {
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .description {
        font-size: 14px;
        color: #343a40;
        margin: 10px 0;
        padding: 10px;
        background-color: #e9f3fd;
        border-left: 5px solid #007bff;
    }

    .experience-row select, .attachment-row select, .attachment-row input {
        margin-right: 10px;
    }
    .btn-sm {
        padding: 5px 10px;
        font-size: 14px;
        margin-left: 5px;
    }

    .table thead th {
        background-color: #007bff;
        color: white;
        text-align: center;
        font-weight: bold;
        padding: 10px;
    }

    .table thead th:first-child {
        border-top-left-radius: 8px;
    }

    .table thead th:last-child {
        border-top-right-radius: 8px;
    }


</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Add New Candidate</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('dashboard')); ?>">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('candidates.index')); ?>">Candidates</a></li>
                <li class="breadcrumb-item active">Add Candidate</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Candidate Profile</h5>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form class="row g-3" method="POST" action="<?php echo e(route('candidates.store')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="form-section">
                                <div class="row mb-3" style="display:none;">
                                    <div class="col-lg-6">
                                        <label for="inputRefNo" class="form-label">Reference Number <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            <input type="text" name="ref_no" class="form-control" id="inputRefNo" 
                                                   value="<?php echo e(old('ref_no', $refNo)); ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <h6>Personal Information</h6>
                                <p class="description">
                                    <i class="fas fa-user" style="margin-right: 5px; color: #007bff;"></i>
                                    Please provide the candidate's complete personal information.
                                </p>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputFirstName" class="form-label">First Name <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="first_name" class="form-control" id="inputFirstName" value="<?php echo e(old('first_name')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputMiddleName" class="form-label">Middle Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="middle_name" class="form-control" id="inputMiddleName" value="<?php echo e(old('middle_name')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputSurname" class="form-label">Surname <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="surname" class="form-control" id="inputSurname" value="<?php echo e(old('surname')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputPassportNo" class="form-label">Passport Number <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-passport"></i></span>
                                            <input type="text" name="passport_number" class="form-control" id="inputPassportNo" value="<?php echo e(old('passport_number')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputPassportExpiry" class="form-label">Passport Expiry Date <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            <input type="date" name="passport_expiry_date" class="form-control" id="inputPassportExpiry" value="<?php echo e(old('passport_expiry_date')); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputDateOfBirth" class="form-label">Date of Birth <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            <input type="date" name="date_of_birth" class="form-control" id="inputDateOfBirth" value="<?php echo e(old('date_of_birth')); ?>" max="<?php echo e(date('Y-m-d')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputAge" class="form-label">Age <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            <input type="number" name="age" class="form-control" id="inputAge" value="<?php echo e(old('age')); ?>" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputPlaceOfBirth" class="form-label">Place of Birth <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="text" name="place_of_birth" class="form-control" id="inputPlaceOfBirth" value="<?php echo e(old('place_of_birth')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Nationality and Labour ID -->
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputNationality" class="form-label">Nationality <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                            <select class="form-select" name="nationality" id="inputNationality" required>
                                                <option disabled value="">Choose...</option>
                                                <?php $__currentLoopData = $nationalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nationality): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($nationality->id); ?>" <?php echo e(old('nationality') == $nationality->id ? 'selected' : ''); ?>>
                                                        <?php echo e($nationality->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputLabourIdDate" class="form-label">Labor ID Date <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            <input type="date" name="labour_id_date" class="form-control" id="inputLabourIdDate" value="<?php echo e(old('labour_id_date')); ?>" min="<?php echo e(date('Y-m-d')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Labour ID Number and Gender -->
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputLabourIdNumber" class="form-label">Labor ID Number <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                            <input type="text" name="labour_id_number" class="form-control" id="inputLabourIdNumber" placeholder="Enter labour ID number" value="<?php echo e(old('labour_id_number')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputGender" class="form-label">Gender <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            <select class="form-select" name="gender" id="inputGender" required>
                                                <option disabled value="">Choose...</option>
                                                <option value="Male" <?php echo e(old('gender') == 'Male' ? 'selected' : ''); ?>>Male</option>
                                                <option value="Female" <?php echo e(old('gender') == 'Female' ? 'selected' : ''); ?>>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Religion and Language Skills -->
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputReligion" class="form-label">Religion <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-praying-hands"></i></span>
                                            <select class="form-select" name="religion" id="inputReligion" required>
                                                <option disabled value="">Choose...</option>
                                                <option value="Muslim" <?php echo e(old('religion') == 'Muslim' ? 'selected' : ''); ?>>Muslim</option>
                                                <option value="Christian" <?php echo e(old('religion') == 'Christian' ? 'selected' : ''); ?>>Christian</option>
                                                <option value="Other" <?php echo e(old('religion') == 'Other' ? 'selected' : ''); ?>>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputEnglishSkills" class="form-label">English Skills <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-language"></i></span>
                                            <select class="form-select" name="english_skills" id="inputEnglishSkills">
                                                <option disabled value="">Choose...</option>
                                                <option value="Fluent" <?php echo e(old('english_skills') == 'Fluent' ? 'selected' : ''); ?>>Fluent</option>
                                                <option value="Good" <?php echo e(old('english_skills') == 'Good' ? 'selected' : ''); ?>>Good</option>
                                                <option value="Poor" <?php echo e(old('english_skills') == 'Poor' ? 'selected' : ''); ?>>Poor</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Arabic Skills and Applied Position -->
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputArabicSkills" class="form-label">Arabic Skills <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-language"></i></span>
                                            <select class="form-select" name="arabic_skills" id="inputArabicSkills">
                                                <option disabled value="">Choose...</option>
                                                <option value="Fluent" <?php echo e(old('arabic_skills') == 'Fluent' ? 'selected' : ''); ?>>Fluent</option>
                                                <option value="Good" <?php echo e(old('arabic_skills') == 'Good' ? 'selected' : ''); ?>>Good</option>
                                                <option value="Poor" <?php echo e(old('arabic_skills') == 'Poor' ? 'selected' : ''); ?>>Poor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputAppliedPosition" class="form-label">Applied Position <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                            <select class="form-select" name="applied_position" id="inputAppliedPosition">
                                                <option disabled value="">Choose...</option>
                                                <?php $__currentLoopData = $appliedPositions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($position->id); ?>" <?php echo e(old('applied_position') == $position->id ? 'selected' : ''); ?>>
                                                        <?php echo e($position->position_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Work Skill and Education Level -->
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputWorkSkill" class="form-label">Work Skill <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <select class="form-select select2" name="work_skill[]" id="inputWorkSkill" multiple>
                                                <option disabled value="">Choose...</option>
                                                <?php $__currentLoopData = $workSkills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($skill->id); ?>" <?php echo e(in_array($skill->id, old('work_skill', [])) ? 'selected' : ''); ?>>
                                                        <?php echo e($skill->skill_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputEducationLevel" class="form-label">Education Level <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                            <select class="form-select" name="education_level" id="inputEducationLevel">
                                                <option disabled value="">Choose...</option>
                                                <?php $__currentLoopData = $educationLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($level->id); ?>" <?php echo e(old('education_level') == $level->id ? 'selected' : ''); ?>>
                                                        <?php echo e($level->level_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Marital Status and Preferred Package -->
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputMaritalStatus" class="form-label">Marital Status <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                            <select class="form-select" name="marital_status" id="inputMaritalStatus">
                                                <option disabled value="">Choose...</option>
                                                <?php $__currentLoopData = $maritalStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($status->id); ?>" <?php echo e(old('marital_status') == $status->id ? 'selected' : ''); ?>>
                                                        <?php echo e($status->status_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputPreferredPackage" class="form-label">Preferred Package <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                                            <select class="form-select" name="preferred_package" id="inputPreferredPackage">
                                                <option disabled value="">Choose...</option>
                                                <option value="PKG-1" <?php echo e(old('preferred_package') == 'PKG-1' ? 'selected' : ''); ?>>PKG-1</option>
                                                <option value="PKG-2" <?php echo e(old('preferred_package') == 'PKG-2' ? 'selected' : ''); ?>>PKG-2</option>
                                                <option value="PKG-3" <?php echo e(old('preferred_package') == 'PKG-3' ? 'selected' : ''); ?>>PKG-3</option>
                                                <option value="PKG-4" <?php echo e(old('preferred_package') == 'PKG-4' ? 'selected' : ''); ?>>PKG-4</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="number_of_children" class="form-label">Number of Children <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="number_of_children" value="<?php echo e(old('number_of_children', 0)); ?>" class="form-control" id="number_of_children" placeholder="Enter Number of children" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="sub_agent_field" class="form-label">Sub Agent <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="sub_agent" value="<?php echo e(old('sub_agent')); ?>" class="form-control" id="sub_agent_field" placeholder="Enter Sub Agent" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="phone_number" class="form-label">Phone Number <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="phone_number" value="<?php echo e(old('phone_number')); ?>" class="form-control" id="phone_number" placeholder="Enter Phone Number" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="current_status" class="form-label">Current Status <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <select name="current_status" id="current_status" class="form-select" required>
                                                <option selected disabled value="">Select Status</option>
                                                <?php $__currentLoopData = $currentStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($status->id); ?>" <?php echo e(old('current_status') == $status->id ? 'selected' : ''); ?>>
                                                        <?php echo e($status->status_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h6>Candidate Address</h6>
                                <p class="description">
                                    <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #007bff;"></i>
                                    Please provide the candidate's complete address details.
                                </p>
                                <!-- Candidate Region and Sub City/Zone -->
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputCandidateRegion" class="form-label">Candidate Region <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map"></i></span>
                                            <input type="text" name="candidate_region" value="<?php echo e(old('candidate_region')); ?>" class="form-control" id="inputCandidateRegion" placeholder="Enter region" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputCandidateSubCityZone" class="form-label">Candidate Sub City/Zone <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                                            <input type="text" name="candidate_sub_city_zone" value="<?php echo e(old('candidate_sub_city_zone')); ?>" class="form-control" id="inputCandidateSubCityZone" placeholder="Enter sub city or zone" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- Candidate Woreda and Kebele -->
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputCandidateWoreda" class="form-label">Candidate Woreda <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-signs"></i></span>
                                            <input type="text" name="candidate_woreda" value="<?php echo e(old('candidate_woreda')); ?>" class="form-control" id="inputCandidateWoreda" placeholder="Enter woreda" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputCandidateKebele" class="form-label">Candidate Kebele <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            <input type="text" name="candidate_kebele" value="<?php echo e(old('candidate_kebele')); ?>" class="form-control" id="inputCandidateKebele" placeholder="Enter kebele" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputCandidateHouseNo" class="form-label">Candidate House No <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            <input type="text" name="candidate_house_no" value="<?php echo e(old('candidate_house_no')); ?>" class="form-control" id="inputCandidateHouseNo" placeholder="Enter house number" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputCandidateCurrentAddress" class="form-label">Candidate Current Address <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="text" name="candidate_current_address" value="<?php echo e(old('candidate_current_address')); ?>" class="form-control" id="inputCandidateCurrentAddress" placeholder="Enter current address" required>
                                        </div>
                                    </div>
                                </div>
                                <h6>Desired Country</h6>
                                <p class="description">
                                    <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #007bff;"></i>
                                    Please provide the candidate's desired country.
                                </p>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputDesiredCountry" class="form-label">Desired Country <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                            <select class="form-select" name="desired_country" id="inputDesiredCountry" onchange="fetchFraNames(this.value)" required>
                                                <option selected disabled value="">Choose...</option>
                                                <?php $__currentLoopData = $desiredCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($country->id); ?>" <?php echo e(old('desired_country') == $country->id ? 'selected' : ''); ?>>
                                                        <?php echo e($country->country_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputFraName" class="form-label">FRA Name <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            <select class="form-select" name="fra_name" id="inputFraName" required>
                                                <option selected disabled value="">Choose...</option>
                                                <!-- FRA Names will be dynamically populated based on selected Desired Country -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h6>Measurment and Medical Information</h6>
                                <p class="description">
                                    <i class="fas fa-notes-medical" style="margin-right: 5px; color: #007bff;"></i>
                                    Please provide the candidate's medical information & measurment.
                                </p>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputHeight" class="form-label">Height (cm) <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-ruler-vertical"></i></span>
                                            <input type="text" name="height" class="form-control" id="inputHeight" placeholder="Enter height in cm" required value="<?php echo e(old('height')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputWeight" class="form-label">Weight (kg) <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-weight-hanging"></i></span>
                                            <input type="text" name="weight" class="form-control" id="inputWeight" placeholder="Enter weight in kg" required value="<?php echo e(old('weight')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputMedicalDate" class="form-label">Medical Date </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            <input type="date" name="medical_date" class="form-control" id="inputMedicalDate" value="<?php echo e(old('medical_date')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputMedicalStatus" class="form-label">Medical Status</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                            <select class="form-select" name="medical_status" id="inputMedicalStatus">
                                                <option selected disabled value="">Choose...</option>
                                                <?php $__currentLoopData = $medicalStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($status->id); ?>" <?php echo e(old('medical_status') == $status->id ? 'selected' : ''); ?>>
                                                        <?php echo e($status->status_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputHospitalName" class="form-label">Hospital Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                            <input type="text" name="hospital_name" class="form-control" id="inputHospitalName" placeholder="Enter hospital name" value="<?php echo e(old('hospital_name')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputCocStatus" class="form-label">COC Status</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                            <select class="form-select" name="coc_status" id="inputCocStatus">
                                                <option selected disabled value="">Choose...</option>
                                                <?php $__currentLoopData = $cocStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($status->id); ?>" <?php echo e(old('coc_status') == $status->id ? 'selected' : ''); ?>>
                                                        <?php echo e($status->status_name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputPulledDate" class="form-label">Pulled Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                            <input type="date" name="pulled_date" class="form-control" id="inputPulledDate" value="<?php echo e(old('pulled_date')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputInsuranceApprovedDate" class="form-label">Insurance Approved Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                            <input type="date" name="insurance_approved_date" class="form-control" id="inputInsuranceApprovedDate" value="<?php echo e(old('insurance_approved_date')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <h6>Family Information</h6>
                                <p class="description">
                                    <i class="fas fa-users" style="margin-right: 5px; color: #007bff;"></i>
                                    Please provide the candidate's family contact and address details.
                                </p>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputFamilyName" class="form-label">Family Name <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                            <input type="text" name="family_name" class="form-control" id="inputFamilyName" placeholder="Enter family member's name" value="<?php echo e(old('family_name')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputFamilyContactNumber_1" class="form-label">Family Contact Number 1<span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" name="family_contact_number_1" class="form-control" id="inputFamilyContactNumber_1" placeholder="Enter contact number" value="<?php echo e(old('family_contact_number_1')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputFamilyContactNumber_2" class="form-label">Family Contact Number 2</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" name="family_contact_number_2" class="form-control" id="inputFamilyContactNumber_2" placeholder="Enter contact number" value="<?php echo e(old('family_contact_number_2')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputRelationshipWithCandidate" class="form-label">Relationship with Candidate <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            <select name="relationship_with_candidate" class="form-select" id="relationshipWithCandidate" required onchange="toggleOtherRelationshipField()">
                                                <option value="" disabled <?php echo e(old('relationship_with_candidate') ? '' : 'selected'); ?>>Select relationship</option>
                                                <optgroup label="Immediate Family">
                                                    <option value="Mother" <?php echo e(old('relationship_with_candidate') == 'Mother' ? 'selected' : ''); ?>>Mother</option>
                                                    <option value="Father" <?php echo e(old('relationship_with_candidate') == 'Father' ? 'selected' : ''); ?>>Father</option>
                                                    <option value="Brother" <?php echo e(old('relationship_with_candidate') == 'Brother' ? 'selected' : ''); ?>>Brother</option>
                                                    <option value="Sister" <?php echo e(old('relationship_with_candidate') == 'Sister' ? 'selected' : ''); ?>>Sister</option>
                                                    <option value="Husband" <?php echo e(old('relationship_with_candidate') == 'Husband' ? 'selected' : ''); ?>>Husband</option>
                                                </optgroup>
                                                <optgroup label="Extended Family">
                                                    <option value="Nephew" <?php echo e(old('relationship_with_candidate') == 'Nephew' ? 'selected' : ''); ?>>Nephew</option>
                                                    <option value="Sister in Law" <?php echo e(old('relationship_with_candidate') == 'Sister in Law' ? 'selected' : ''); ?>>Sister in Law</option>
                                                    <option value="Brother in Law" <?php echo e(old('relationship_with_candidate') == 'Brother in Law' ? 'selected' : ''); ?>>Brother in Law</option>
                                                    <option value="Grandma" <?php echo e(old('relationship_with_candidate') == 'Grandma' ? 'selected' : ''); ?>>Grandma</option>
                                                    <option value="Grandpa" <?php echo e(old('relationship_with_candidate') == 'Grandpa' ? 'selected' : ''); ?>>Grandpa</option>
                                                </optgroup>
                                                <option value="Other" <?php echo e(old('relationship_with_candidate') == 'Other' ? 'selected' : ''); ?>>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3" id="otherRelationshipField" style="display: <?php echo e(old('relationship_with_candidate') == 'Other' ? 'block' : 'none'); ?>;">
                                    <div class="col-lg-6">
                                        <label for="otherRelationship" class="form-label">What is the other relation? <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-question-circle"></i></span>
                                            <input type="text" name="other_relationship" class="form-control" id="otherRelationship" placeholder="Enter other relationship" value="<?php echo e(old('other_relationship')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <h6>Family Address</h6>
                                <p class="description">
                                    <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #007bff;"></i>
                                    Please provide the complete address of the family member.
                                </p>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputFamilyRegion" class="form-label">Family Region <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map"></i></span>
                                            <input type="text" name="family_region" class="form-control" id="inputFamilyRegion" placeholder="Enter region" value="<?php echo e(old('family_region')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputFamilySubCityZone" class="form-label">Family Sub City/Zone <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                                            <input type="text" name="family_sub_city_zone" class="form-control" id="inputFamilySubCityZone" placeholder="Enter sub city or zone" value="<?php echo e(old('family_sub_city_zone')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputFamilyWoreda" class="form-label">Family Woreda <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-signs"></i></span>
                                            <input type="text" name="family_woreda" class="form-control" id="inputFamilyWoreda" placeholder="Enter woreda" value="<?php echo e(old('family_woreda')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputFamilyKebele" class="form-label">Family Kebele <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            <input type="text" name="family_kebele" class="form-control" id="inputFamilyKebele" placeholder="Enter kebele" value="<?php echo e(old('family_kebele')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="inputFamilyHouseNo" class="form-label">Family House No <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            <input type="text" name="family_house_no" class="form-control" id="inputFamilyHouseNo" placeholder="Enter house number" value="<?php echo e(old('family_house_no')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inputFamilyCurrentAddress" class="form-label">Family Current Address <span style="color: red;">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="text" name="family_current_address" class="form-control" id="inputFamilyCurrentAddress" placeholder="Enter full address" value="<?php echo e(old('family_current_address')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Experience Section -->
                            <div class="form-section">
                                <h6>Experience Information</h6>
                                <p class="description">
                                    <i class="fas fa-briefcase" style="margin-right: 5px; color: #007bff;"></i>
                                    Provide details about the candidate’s experience in Gulf countries.
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Country</th>
                                                <th>Years</th>
                                                <th>Months</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="experience-container">
                                            <tr class="experience-row">
                                                <td>
                                                    <select class="form-select experience-country" name="experience_country[]" required>
                                                        <option selected disabled value="">Select Gulf Country...</option>
                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                                        <option value="Kuwait">Kuwait</option>
                                                        <option value="Qatar">Qatar</option>
                                                        <option value="Oman">Oman</option>
                                                        <option value="Bahrain">Bahrain</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="experience_years[]" required>
                                                        <option selected disabled value="">Select Years...</option>
                                                        <?php for($i = 0; $i <= 10; $i++): ?>
                                                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?> Year<?php echo e($i != 1 ? 's' : ''); ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="experience_months[]" required>
                                                        <option selected disabled value="">Select Months...</option>
                                                        <?php for($i = 0; $i < 12; $i++): ?>
                                                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?> Month<?php echo e($i != 1 ? 's' : ''); ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="button-group">
                                                        <button type="button" class="btn btn-sm btn-success add-experience"><i class="fas fa-plus"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Attachments Section -->
                            <div class="form-section">
                                <h6>Attachments</h6>
                                <p class="description">
                                    <i class="fas fa-paperclip" style="margin-right: 5px; color: #007bff;"></i>
                                    Upload important documents for the candidate’s profile.
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
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
                                            <tr class="attachment-row">
                                                <td>
                                                    <select class="form-select attachment-type" name="attachment_type[]" required>
                                                        <option selected disabled value="">Select Document Type...</option>
                                                        <option value="Passport">Passport</option>
                                                        <option value="Candidate ID">Candidate ID</option>
                                                        <option value="Passport Size Photo">Passport Size Photo</option>
                                                        <option value="Full Body Photo">Full Body Photo</option>
                                                        <option value="Pre Registration Agreement">Pre Registration Agreement</option>
                                                        <option value="Beneficiary Form">Beneficiary Form</option>
                                                        <option value="Video">Video</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="attachment_number[]" class="form-control" placeholder="Document Number"></td>
                                                <td><input type="date" name="issued_on[]" class="form-control" placeholder="Issued On"></td>
                                                <td><input type="date" name="expired_on[]" class="form-control" placeholder="Expired On"></td>
                                                <td><input type="file" name="attachment_file[]" class="form-control" required></td>
                                                <td>
                                                    <div class="button-group">
                                                        <button type="button" class="btn btn-sm btn-success add-attachment"><i class="fas fa-plus"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
    function fetchBranches(companyId) {
        const branchSelect = document.getElementById('inputRegBranch');
        branchSelect.innerHTML = '<option selected disabled value="">Choose...</option>';
        if (companyId) {
            fetch(`/get-branches/${companyId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(branch => {
                        const option = document.createElement('option');
                        option.value = branch.id;
                        option.text = branch.name;
                        branchSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching branches:', error));
        }
    }
    function fetchFraNames(countryId) {
        const fraNameSelect = document.getElementById('inputFraName');
        fraNameSelect.innerHTML = '<option selected disabled value="">Choose...</option>';
        if (countryId) {
            fetch(`/get-fra-names/${countryId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(fra => {
                        const option = document.createElement('option');
                        option.value = fra.id;
                        option.text = fra.fra_name;
                        fraNameSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching FRA names:', error));
        }
    }
    function toggleOtherRelationshipField() {
        var relationshipDropdown = document.getElementById("relationshipWithCandidate");
        var otherField = document.getElementById("otherRelationshipField");
        
        if (relationshipDropdown.value === "Other") {
            otherField.style.display = "block";
        } else {
            otherField.style.display = "none";
            document.getElementById("otherRelationship").value = "";
        }
    }

    document.getElementById('inputDateOfBirth').addEventListener('change', function () {
        const dob = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDifference = today.getMonth() - dob.getMonth();
        
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        document.getElementById('inputAge').value = age > 0 ? age : '';
    });
    function addExperienceRow() {
        const $container = $('#experience-container');
        const newRow = `
            <tr class="experience-row">
                <td>
                    <select class="form-select experience-country" name="experience_country[]" required>
                        <option selected disabled value="">Select Gulf Country...</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Oman">Oman</option>
                        <option value="Bahrain">Bahrain</option>
                    </select>
                </td>
                <td>
                    <select class="form-select" name="experience_years[]" required>
                        <option selected disabled value="">Select Years...</option>
                        ${Array.from({ length: 11 }, (_, i) => `<option value="${i}">${i} Year${i !== 1 ? 's' : ''}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <select class="form-select" name="experience_months[]" required>
                        <option selected disabled value="">Select Months...</option>
                        ${Array.from({ length: 12 }, (_, i) => `<option value="${i}">${i} Month${i !== 1 ? 's' : ''}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <div class="button-group">
                        <button type="button" class="btn btn-sm btn-success add-experience"><i class="fas fa-plus"></i></button>
                        <button type="button" class="btn btn-sm btn-danger remove-experience"><i class="fas fa-minus"></i></button>
                    </div>
                </td>
            </tr>`;
        $container.append(newRow);
        updateButtonDisplay();
        updateExperienceOptions();
    }

    function addAttachmentRow() {
        const $container = $('#attachment-container');
        const newRow = `
            <tr class="attachment-row">
                <td>
                    <select class="form-select attachment-type" name="attachment_type[]" required>
                        <option selected disabled value="">Select Document Type...</option>
                        <option value="Passport">Passport</option>
                        <option value="Candidate ID">Candidate ID</option>
                        <option value="Passport Size Photo">Passport Size Photo</option>
                        <option value="Full Body Photo">Full Body Photo</option>
                        <option value="Pre Registration Agreement">Pre Registration Agreement</option>
                        <option value="Beneficiary Form">Beneficiary Form</option>
                        <option value="Video">Video</option>
                    </select>
                </td>
                <td><input type="text" name="attachment_number[]" class="form-control" placeholder="Document Number"></td>
                <td><input type="date" name="issued_on[]" class="form-control" placeholder="Issued On"></td>
                <td><input type="date" name="expired_on[]" class="form-control" placeholder="Expired On"></td>
                <td><input type="file" name="attachment_file[]" class="form-control" required></td>
                <td>
                    <div class="button-group">
                        <button type="button" class="btn btn-sm btn-success add-attachment"><i class="fas fa-plus"></i></button>
                        <button type="button" class="btn btn-sm btn-danger remove-attachment"><i class="fas fa-minus"></i></button>
                    </div>
                </td>
            </tr>`;
        $container.append(newRow);
        updateButtonDisplay();
        updateAttachmentOptions();
    }

    function updateButtonDisplay() {
        $('.experience-row').each(function (index) {
            const isLastRow = index === $('.experience-row').length - 1;
            $(this).find('.add-experience').toggle(isLastRow);
            $(this).find('.remove-experience').toggle(!isLastRow || index !== 0);
        });

        $('.attachment-row').each(function (index) {
            const isLastRow = index === $('.attachment-row').length - 1;
            $(this).find('.add-attachment').toggle(isLastRow);
            $(this).find('.remove-attachment').toggle(!isLastRow || index !== 0);
        });
    }

    function updateExperienceOptions() {
        const selectedValues = $('.experience-country').map(function () {
            return $(this).val();
        }).get();
        $('.experience-country').each(function () {
            $(this).find('option').each(function () {
                $(this).prop('disabled', selectedValues.includes($(this).val()) && $(this).val() !== $(this).parent().val());
            });
        });
    }

    function updateAttachmentOptions() {
        const selectedValues = $('.attachment-type').map(function () {
            return $(this).val();
        }).get();
        $('.attachment-type').each(function () {
            $(this).find('option').each(function () {
                $(this).prop('disabled', selectedValues.includes($(this).val()) && $(this).val() !== $(this).parent().val());
            });
        });
    }

    $(document).on('click', '.add-experience', addExperienceRow);
    $(document).on('click', '.remove-experience', function () {
        $(this).closest('.experience-row').remove();
        updateButtonDisplay();
        updateExperienceOptions();
    });
    $(document).on('click', '.add-attachment', addAttachmentRow);
    $(document).on('click', '.remove-attachment', function () {
        $(this).closest('.attachment-row').remove();
        updateButtonDisplay();
        updateAttachmentOptions();
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/create.blade.php ENDPATH**/ ?>