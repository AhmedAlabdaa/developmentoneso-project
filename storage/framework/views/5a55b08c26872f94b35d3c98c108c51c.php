<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Create Employee</h5>

            <?php if($errors->any()): ?>
              <div class="alert alert-danger">
                <ul>
                  <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
            <?php endif; ?>

            <form class="row g-3" action="<?php echo e(route('employees.store')); ?>" method="POST">
              <?php echo csrf_field(); ?>

              <div class="col-lg-6">
                <label for="package" class="form-label">Package<span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-box"></i></span>
                  <select class="form-select" id="package" name="package" required>
                    <option value="">Select Package</option>
                    <option value="PKG-2" <?php echo e(old('package') == 'PKG-2' ? 'selected' : ''); ?>>PKG-2</option>
                    <option value="PKG-3" <?php echo e(old('package') == 'PKG-3' ? 'selected' : ''); ?>>PKG-3</option>
                    <option value="PKG-4" <?php echo e(old('package') == 'PKG-4' ? 'selected' : ''); ?>>PKG-4</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-6">
                <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                </div>
              </div>

              <div class="col-lg-6">
                <label for="nationality" class="form-label">Nationality<span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-flag"></i></span>
                  <select class="form-select" id="nationality" name="nationality" required>
                    <option value="">Select Nationality</option>
                    <option value="ETHIOPIA" <?php echo e(old('nationality') == 'ETHIOPIA' ? 'selected' : ''); ?>>ETHIOPIA</option>
                    <option value="INDIA" <?php echo e(old('nationality') == 'INDIA' ? 'selected' : ''); ?>>INDIA</option>
                    <option value="PAKISAN" <?php echo e(old('nationality') == 'PAKISAN' ? 'selected' : ''); ?>>PAKISAN</option>
                    <option value="INDONESIA" <?php echo e(old('nationality') == 'INDONESIA' ? 'selected' : ''); ?>>INDONESIA</option>
                    <option value="KENYA" <?php echo e(old('nationality') == 'KENYA' ? 'selected' : ''); ?>>KENYA</option>
                    <option value="MYANMAR" <?php echo e(old('nationality') == 'MYANMAR' ? 'selected' : ''); ?>>MYANMAR</option>
                    <option value="PHILIPPINES" <?php echo e(old('nationality') == 'PHILIPPINES' ? 'selected' : ''); ?>>PHILIPPINES</option>
                    <option value="SRI LANKA" <?php echo e(old('nationality') == 'SRI LANKA' ? 'selected' : ''); ?>>SRI LANKA</option>
                    <option value="UGANDA" <?php echo e(old('nationality') == 'UGANDA' ? 'selected' : ''); ?>>UGANDA</option>
                    <option value="NIGERIA" <?php echo e(old('nationality') == 'NIGERIA' ? 'selected' : ''); ?>>NIGERIA</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-6">
                <label for="passport_no" class="form-label">Passport No<span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-passport"></i></span>
                  <input type="text" class="form-control" id="passport_no" name="passport_no" value="<?php echo e(old('passport_no')); ?>" required>
                </div>
              </div>

              <div class="col-lg-6">
                <label for="passport_expiry_date" class="form-label">Passport Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" class="form-control" id="passport_expiry_date" name="passport_expiry_date" value="<?php echo e(old('passport_expiry_date')); ?>">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo e(old('date_of_birth')); ?>">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="passport_issue_date" class="form-label">Passport Issue Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                  <input type="date" class="form-control" id="passport_issue_date" name="passport_issue_date" value="<?php echo e(old('passport_issue_date')); ?>">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="foreign_partner" class="form-label">Foreign Partner</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                  <input type="text" class="form-control" id="foreign_partner" name="foreign_partner" value="<?php echo e(old('foreign_partner')); ?>">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="relgion" class="form-label">Religion</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-praying-hands"></i></span>
                  <input type="text" class="form-control" id="relgion" name="relgion" value="<?php echo e(old('relgion')); ?>">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="place_of_birth" class="form-label">Place of Birth</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="<?php echo e(old('place_of_birth')); ?>">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="living_town" class="form-label">Living Town</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-city"></i></span>
                  <input type="text" class="form-control" id="living_town" name="living_town" value="<?php echo e(old('living_town')); ?>">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="marital_status" class="form-label">Marital Status</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-ring"></i></span>
                  <select class="form-select" id="marital_status" name="marital_status">
                    <option value="">Select Status</option>
                    <option value="Single" <?php echo e(old('marital_status') == 'Single' ? 'selected' : ''); ?>>Single</option>
                    <option value="Married" <?php echo e(old('marital_status') == 'Married' ? 'selected' : ''); ?>>Married</option>
                    <option value="Divorced" <?php echo e(old('marital_status') == 'Divorced' ? 'selected' : ''); ?>>Divorced</option>
                    <option value="Widowed" <?php echo e(old('marital_status') == 'Widowed' ? 'selected' : ''); ?>>Widowed</option>
                  </select>
                </div>
              </div>

              <div class="col-lg-6">
                <label for="no_of_childrens" class="form-label">Number of Children</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-child"></i></span>
                  <input type="number" class="form-control" id="no_of_childrens" name="no_of_childrens" value="<?php echo e(old('no_of_childrens')); ?>" min="0">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="weight" class="form-label">Weight (kg)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-weight"></i></span>
                  <input type="number" class="form-control" id="weight" name="weight" value="<?php echo e(old('weight')); ?>" step="0.1" min="0">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="height" class="form-label">Height (cm)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-ruler-vertical"></i></span>
                  <input type="number" class="form-control" id="height" name="height" value="<?php echo e(old('height')); ?>" step="0.1" min="0">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="education" class="form-label">Education</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                  <input type="text" class="form-control" id="education" name="education" value="<?php echo e(old('education')); ?>">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="languages" class="form-label">Languages</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-language"></i></span>
                  <input type="text" class="form-control" id="languages" name="languages" value="<?php echo e(old('languages')); ?>">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="working_expierience" class="form-label">Working Experience</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                  <input type="text" class="form-control" id="working_expierience" name="working_expierience" value="<?php echo e(old('working_expierience')); ?>">
                </div>
              </div>

              <div class="col-lg-6">
                <label for="place_of_issues" class="form-label">Place of Issue</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                  <input type="text" class="form-control" id="place_of_issues" name="place_of_issues" value="<?php echo e(old('place_of_issues')); ?>">
                </div>
              </div>

              <div class="col-lg-12">
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
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/create.blade.php ENDPATH**/ ?>