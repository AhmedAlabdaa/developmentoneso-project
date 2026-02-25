<footer id="footer" class="footer">
  <div class="copyright">
    &copy; Copyright <strong><span>ERP</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    Designed by <a href="https://www.tadbeer-alebdaa.com/" target="_blank">OnesourceERP Solution</a>
  </div>
</footer>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo e(asset('assets/vendor/apexcharts/apexcharts.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(asset('assets/vendor/chart.js/chart.umd.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/echarts/echarts.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/quill/quill.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/simple-datatables/simple-datatables.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/tinymce/tinymce.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/php-email-form/validate.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.5/js/lightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('#ChangeCompanyLogin').on('change', function () {
        const companyName = $(this).val();
        const userRole = '<?php echo e(Auth::user()->role); ?>';
        Swal.fire({
            title: 'Do you want to login to ' + companyName + '?',
            text: "This action will log you into the selected company.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, login!'
        }).then((result) => {
            if (result.isConfirmed) {
                showPreloader();
                loginToCompany(companyName, userRole);
            }
        });
    });

    function showPreloader() {
        const preloaderHtml = `
            <div id="preloader" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;">
                <div style="text-align: center;">
                    <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;"></div>
                    <p style="margin-top: 1rem; font-size: 1.2rem;">Wait a moment, you are redirecting to the requested company...</p>
                </div>
            </div>`;
        $('body').append(preloaderHtml);
    }

    function hidePreloader() {
      $('#preloader').remove();
    }

    function loginToCompany(companyName, userRole) {
      const newWindow = window.open('', '_blank');
      if (!newWindow) {
        toastr.error('Please allow pop-ups for this site to continue.');
        return;
      }

      $.ajax({
        url: '<?php echo e(route("users.login-request")); ?>',
        type: 'POST',
        data: {
          companyName: companyName,
          userRole: userRole,
          _token: '<?php echo e(csrf_token()); ?>'
        },
        success: function(response) {
          hidePreloader();

          if (response.success && response.redirectUrl) {
            newWindow.location.href = response.redirectUrl;
          } else {
            newWindow.close();
            toastr.error(response.message || 'An unexpected error occurred. Please try again.');
          }
        },
        error: function(xhr) {
          hidePreloader();
          newWindow.close();

          const errorMessage =
            xhr.responseJSON && xhr.responseJSON.message
              ? xhr.responseJSON.message
              : 'An error occurred. Please try again.';

          toastr.error(errorMessage);
        }
      });
    }
  });

  $(document).ready(function() {
    $('.select2').select2({
      placeholder: "Select an option",
      allowClear: true
    });
  });

  $(document).ready(function () {
    $('#clientDropdown').select2({
      dropdownParent: $('#updateagreementModal'),
      width: '100%' 
    });

    $(document).on('select2:open', function () {
      document.querySelector('.select2-container--open').addEventListener('mousedown', function (e) {
        e.stopPropagation();
      });
    });

    $('#updateagreementModal').on('hidden.bs.modal', function () {
      $('#agreement_form')[0].reset();
      $('#clientDropdown').val(null).trigger('change');
    });
  });

  $(document).ready(function () {
      $('#saveAllDatabases').on('click', function () {
          const spinner = $('<div>')
              .attr('id', 'spinner')
              .css({
                  border: '6px solid transparent',
                  'border-top': '6px solid transparent',
                  'border-radius': '50%',
                  width: '50px',
                  height: '50px',
                  animation: 'spin 1s linear infinite',
                  margin: '20px auto',
                  background: 'conic-gradient(#ff0000, #ff7f00, #ffff00, #00ff00, #0000ff, #8b00ff, #ff0000)',
              });

          const progressContainer = $('<div>')
              .attr('id', 'progressContainer')
              .css({
                  width: '100%',
                  'max-width': '400px',
                  margin: '20px auto',
                  background: '#f3f3f3',
                  'border-radius': '5px',
                  overflow: 'hidden',
              });

          const progressBar = $('<div>')
              .attr('id', 'progressBar')
              .css({
                  height: '20px',
                  width: '0',
                  background: 'linear-gradient(90deg, red, orange, yellow, green, blue, purple)',
                  transition: 'width 0.4s ease',
              });

          progressContainer.append(progressBar);
          $('body').append(spinner, progressContainer);
          let progress = 0;
          const interval = setInterval(() => {
              progress += 10;
              progressBar.css('width', `${progress}%`);

              if (progress >= 100) {
                  clearInterval(interval);
              }
          }, 500);

          $.ajax({
              url: "<?php echo e(route('users.backup')); ?>",
              method: 'GET',
              success: function (data) {
                  console.log('Backup results:', data);
                  spinner.remove();
                  const allSuccess = data.every(item => item.status === 'success');
                  if (allSuccess) {
                      toastr.success('All databases backed up successfully!');
                  } else {
                      toastr.error('Some databases failed to back up.');
                  }

                  setTimeout(() => {
                      progressContainer.remove();
                  }, 1000);
              },
              error: function (error) {
                  console.error('Error:', error);
                  spinner.remove();
                  toastr.error('An error occurred while saving databases.');
                  setTimeout(() => {
                      progressContainer.remove();
                  }, 1000);
              },
          });
      });
  });

  document.querySelectorAll('input[type="date"], .flatpickr-input').forEach(input => {
    flatpickr(input, {
      dateFormat: "d M Y",
      altInput: true,
      altFormat: "d M Y",
      allowInput: true
    });
  });

  $(document).ready(function() {
    $("#resetRecord").on("click", function() {
      $.ajax({
        url: "<?php echo e(route('candidates.resetRecord')); ?>", 
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        data: { reset: true },
        success: function(response) {
          toastr.success("Record reset successfully.");
        },
        error: function(xhr, status, error) {
          toastr.error("Error resetting record.");
        }
      });
    });
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views////layout/footer.blade.php ENDPATH**/ ?>