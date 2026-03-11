<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add New Customer</h5>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo e(route('crm.store')); ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-6">
                            <label for="customerID" class="form-label">Customer ID <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="cl" class="form-control" id="customerID" value="<?php echo e($newCustomerId); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Name <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="name" class="form-control" id="inputName" value="<?php echo e(old('name')); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputNationality" class="form-label">Nationality <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                <select name="nationality" class="form-select" id="inputNationality" required>
                                    <option disabled value="">Choose...</option>
                                    <option value="Abu Dhabi" <?php echo e(old('nationality') == 'Abu Dhabi' ? 'selected' : ''); ?>>Abu Dhabi</option>
                                    <option value="Dubai" <?php echo e(old('nationality') == 'Dubai' ? 'selected' : ''); ?>>Dubai</option>
                                    <option value="Sharjah" <?php echo e(old('nationality') == 'Sharjah' ? 'selected' : ''); ?>>Sharjah</option>
                                    <option value="Ajman" <?php echo e(old('nationality') == 'Ajman' ? 'selected' : ''); ?>>Ajman</option>
                                    <option value="Ras Al Khaimah" <?php echo e(old('nationality') == 'Ras Al Khaimah' ? 'selected' : ''); ?>>Ras Al Khaimah</option>
                                    <option value="Fujairah" <?php echo e(old('nationality') == 'Fujairah' ? 'selected' : ''); ?>>Fujairah</option>
                                    <option value="Umm Al Quwain" <?php echo e(old('nationality') == 'Umm Al Quwain' ? 'selected' : ''); ?>>Umm Al Quwain</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" id="inputEmail" value="<?php echo e(old('email')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputMobile" class="form-label">Mobile <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" name="mobile" class="form-control" id="inputMobile" placeholder="0501234567" value="<?php echo e(old('mobile')); ?>" required>
                            </div>
                            <div id="mobileError" class="text-danger small mt-1" style="display: none;">Please enter a valid UAE mobile number (e.g., 0501234567).</div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmiratesId" class="form-label">Emirates ID <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                <input type="text" name="emirates_id" class="form-control" id="inputEmiratesId" placeholder="784-XXXX-XXXXXXX-X" value="<?php echo e(old('emirates_id')); ?>" required>
                            </div>
                            <div id="emiratesIdError" class="text-danger small mt-1" style="display: none;">Please enter a valid Emirates ID (784-XXXX-XXXXXXX-X).</div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmergencyContact" class="form-label">Emergency Contact Person</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                <input type="text" name="emergency_contact_person" class="form-control" id="inputEmergencyContact" value="<?php echo e(old('emergency_contact_person')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputSource" class="form-label">Source</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-bullhorn"></i></span>
                                <select name="source" class="form-select" id="inputSource">
                                    <option disabled value="">Choose...</option>
                                    <option value="Social Media" <?php echo e(old('source') == 'Social Media' ? 'selected' : ''); ?>>Social Media</option>
                                    <option value="Referral" <?php echo e(old('source') == 'Referral' ? 'selected' : ''); ?>>Referral</option>
                                    <option value="Walk-in" <?php echo e(old('source') == 'Walk-in' ? 'selected' : ''); ?>>Walk-in</option>
                                    <option value="Others" <?php echo e(old('source') == 'Others' ? 'selected' : ''); ?>>Others</option>
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
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
<?php /**PATH /var/www/developmentoneso-project/resources/views/agents/create.blade.php ENDPATH**/ ?>