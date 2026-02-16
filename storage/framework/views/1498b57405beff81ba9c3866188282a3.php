<?php
  $serverName = $_SERVER['HTTP_HOST'];
  $firstWord = explode('.', $serverName)[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login :: <?php echo e(ucfirst($firstWord)); ?> ERP</title>
  <link href="<?php echo e(asset('assets/img/' . $firstWord . '_logo.png')); ?>" rel="icon">
  <link href="<?php echo e(asset('assets/img/apple-touch-icon.png')); ?>" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">
  <link href="<?php echo e(asset('assets/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('assets/css/' . $firstWord . '_style.css')); ?>" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>
<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <a href="<?php echo e(url('/')); ?>" class="logo d-flex align-items-center w-auto">
                  <img src="<?php echo e(asset('assets/img/' . $firstWord . '_logo.png')); ?>" alt="">
                </a>
              </div>
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email and password to login</p>
                  </div>
                  <form class="row g-3 needs-validation" method="POST" action="<?php echo e(url('login')); ?>" id="loginForm">
                    <?php echo csrf_field(); ?>
                    <div class="col-12">
                      <label for="email" class="form-label">Email / Username</label>
                      <div class="input-group has-validation">
                        <input type="text" name="email" class="form-control" id="email" required>
                      </div>
                    </div>
                    <div class="col-12 position-relative">
                      <label for="password" class="form-label">Password</label>
                      <div class="input-group">
                        <input type="password" name="password" class="form-control" id="password" required>
                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                          <i class="bi bi-eye-slash" id="toggleIcon"></i>
                        </span>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="<?php echo e(asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
  <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    $('#loginForm').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          if (response.success) {
            toastr.success("You have logged in Successfully!", "Success");
            setTimeout(function() {
              window.location.href = response.redirect_url;
            }, 2000);
          } else {
            toastr.error(response.message, "Error");
          }
        },
        error: function(xhr) {
          toastr.error("Invalid credentials. Please try again.", "Error");
        }
      });
    });
    $('#togglePassword').on('click', function() {
      const passwordInput = $('#password');
      const icon = $('#toggleIcon');
      if (passwordInput.attr('type') === 'password') {
        passwordInput.attr('type', 'text');
        icon.removeClass('bi-eye-slash').addClass('bi-eye');
      } else {
        passwordInput.attr('type', 'password');
        icon.removeClass('bi-eye').addClass('bi-eye-slash');
      }
    });
  </script>
</body>
</html>
<?php /**PATH /home/developmentoneso/public_html/resources/views/index.blade.php ENDPATH**/ ?>