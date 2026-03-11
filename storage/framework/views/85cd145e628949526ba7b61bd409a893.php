<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

            <?php if($errors->any()): ?>
              <div class="alert alert-danger">
                <ul>
                  <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
            <?php endif; ?>

            <form action="<?php echo e(route('package.store')); ?>" method="POST" class="row g-3">
              <?php echo csrf_field(); ?>

              <div class="col-md-6">
                <label for="candidate_name" class="form-label">Candidate Name <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="candidate_name" class="form-control" id="candidate_name" value="<?php echo e(old('candidate_name')); ?>" required>
                </div>
              </div>

              <?php
                $allowedCountries = ['ETHIOPIA', 'INDIA', 'INDONESIA', 'KENYA', 'MYANMAR', 'PHILIPPINES', 'SRI LANKA', 'UGANDA'];
              ?>
              <div class="col-md-6">
                <label for="nationality" class="form-label">Nationality <span style="color: red;">*</span></label>
                <select name="nationality" class="form-select select2-country" id="nationality" required>
                  <option value="">Select country</option>
                  <?php $__currentLoopData = $allCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                      $upperName = strtoupper($country->NAME);
                    ?>
                    <?php if(in_array($upperName, $allowedCountries)): ?>
                      <option value="<?php echo e($upperName); ?>" <?php echo e(old('nationality') == $upperName ? 'selected' : ''); ?>>
                        <?php echo e($upperName); ?>

                      </option>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="col-md-6">
                <label for="passport_no" class="form-label">Passport No <span style="color: red;">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                  <input type="text" name="passport_no" class="form-control" id="passport_no" value="<?php echo e(old('passport_no')); ?>" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="foreign_partner" class="form-label">Foreign Partner</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                  <input type="text" name="foreign_partner" class="form-control" id="foreign_partner" value="<?php echo e(old('foreign_partner')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="passport_expiry_date" class="form-label">Passport Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="passport_expiry_date" class="form-control" id="passport_expiry_date" value="<?php echo e(old('passport_expiry_date')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  <input type="date" name="date_of_birth" class="form-control" id="date_of_birth" value="<?php echo e(old('date_of_birth')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="passport_issue_date" class="form-label">Passport Issue Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                  <input type="date" name="passport_issue_date" class="form-control" id="passport_issue_date" value="<?php echo e(old('passport_issue_date')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="experience_years" class="form-label">Experience in Years</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                  <input type="number" min="0" step="1" name="experience_years" class="form-control" id="experience_years" value="<?php echo e(old('experience_years')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="marital_status" class="form-label">Marital Status</label>
                <select name="marital_status" id="marital_status" class="form-select">
                  <option value="">Select status</option>
                  <option value="1" <?php echo e(old('marital_status') == '1' ? 'selected' : ''); ?>>Single</option>
                  <option value="2" <?php echo e(old('marital_status') == '2' ? 'selected' : ''); ?>>Married</option>
                  <option value="3" <?php echo e(old('marital_status') == '3' ? 'selected' : ''); ?>>Divorced</option>
                  <option value="4" <?php echo e(old('marital_status') == '4' ? 'selected' : ''); ?>>Widowed</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="number_of_children" class="form-label">Number of Children</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-child"></i></span>
                  <input type="number" min="0" step="1" name="number_of_children" class="form-control" id="number_of_children" value="<?php echo e(old('number_of_children')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="religion" class="form-label">Religion</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-praying-hands"></i></span>
                  <input type="text" name="religion" class="form-control" id="religion" value="<?php echo e(old('religion')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="place_of_birth" class="form-label">Place of Birth</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  <input type="text" name="place_of_birth" class="form-control" id="place_of_birth" value="<?php echo e(old('place_of_birth')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="living_town" class="form-label">Living Town</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-city"></i></span>
                  <input type="text" name="living_town" class="form-control" id="living_town" value="<?php echo e(old('living_town')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="place_of_issue" class="form-label">Place of Issue</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                  <input type="text" name="place_of_issue" class="form-control" id="place_of_issue" value="<?php echo e(old('place_of_issue')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="education" class="form-label">Education</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                  <input type="text" name="education" class="form-control" id="education" value="<?php echo e(old('education')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="languages" class="form-label">Languages</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-language"></i></span>
                  <input type="text" name="languages" class="form-control" id="languages" value="<?php echo e(old('languages')); ?>">
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

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/create.blade.php ENDPATH**/ ?>