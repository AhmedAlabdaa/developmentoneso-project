<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<main id="main" class="main">
  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <img src="https://avatar.iran.liara.run/public/boy" alt="User" class="rounded-circle">
            <h2><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></h2>
            <h3><?php echo e($user->role); ?></h3>
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body pt-3">
            <?php if(session('success')): ?>
              <div class="alert alert-success">
                <?php echo e(session('success')); ?>

              </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
              <div class="alert alert-danger">
                <ul>
                  <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
            <?php endif; ?>
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>
            </ul>
            <div class="tab-content pt-2">
              <!-- Overview Section -->
              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">About</h5>
                <h5 class="card-title">Profile Details</h5>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Full Name</div>
                  <div class="col-lg-9 col-md-8"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8"><?php echo e($user->email); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Role</div>
                  <div class="col-lg-9 col-md-8"><?php echo e($user->role); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Status</div>
                  <div class="col-lg-9 col-md-8"><?php echo e($user->status); ?></div>
                </div>
              </div>
              <!-- Edit Profile Section -->
              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <form id="editUserForm" method="POST">
                  <?php echo csrf_field(); ?>
                  <div class="row mb-3">
                    <label for="firstName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="first_name" type="text" class="form-control" id="first_name" value="<?php echo e($user->first_name); ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="last_name" type="text" class="form-control" id="last_name" value="<?php echo e($user->last_name); ?>">
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="button" class="btn btn-primary" id="update_user" data-user-id="<?php echo e($user->id); ?>">Save Changes</button>
                  </div>
                </form>
              </div>
              <!-- Change Password Section -->
              <div class="tab-pane fade pt-3" id="profile-change-password">
                <form id="changePasswordForm" method="POST">
                  <?php echo csrf_field(); ?>
                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="current_password" type="password" class="form-control" id="current_password" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="new_password" type="password" class="form-control" id="new_password" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="new_password_confirmation" type="password" class="form-control" id="renew_password" required>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="button" class="btn btn-primary" onclick="changePassword(<?php echo e($user->id); ?>)">Change Password</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
  $(document).on('click', '#update_user', function (e) {
      e.preventDefault();
      const userId = $(this).data('user-id');
      const data = {
        first_name: $('#first_name').val().trim(),
        last_name: $('#last_name').val().trim(),
        _token: $('meta[name="csrf-token"]').attr('content')
      };
      $.ajax({
          url: `/users/${userId}`,
          type: 'POST',
          data: data,
          success: function (response) {
              toastr.success(response.message);
          },
          error: function (xhr) {
              toastr.error('An error occurred while updating the user.');
          }
      });
  });

  function changePassword(userId) {
    const currentPassword = $('#current_password').val().trim();
    const newPassword = $('#new_password').val().trim();
    const confirmPassword = $('#renew_password').val().trim();

    if (currentPassword.length === 0) {
        toastr.error('Current password is required.');
        return;
    }

    if (newPassword.length < 5) {
        toastr.error('New password must be at least 5 characters.');
        return;
    }

    if (currentPassword === newPassword) {
        toastr.error('New password must be different from the current password.');
        return;
    }

    if (newPassword !== confirmPassword) {
        toastr.error('New password and confirm password do not match.');
        return;
    }

    $.ajax({
        url: `/users/change-password/${userId}`,
        type: 'POST',
        data: {
            current_password: currentPassword,
            new_password: newPassword,
            new_password_confirmation: confirmPassword,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                $('#current_password').val('');
                $('#new_password').val('');
                $('#renew_password').val('');
            } else {
                toastr.error(response.message);
            }
        },
        error: function (xhr) {
            if (xhr.status === 422 && xhr.responseJSON.errors) {
                const errors = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                toastr.error(errors);
            } else {
                toastr.error('An error occurred. Please try again.');
            }
        }
    });
  }

</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/user/index.blade.php ENDPATH**/ ?>