<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style type="text/css">
    .progress {
        height: 30px;
        border-radius: 20px;
    }

    .progress-bar {
        font-size: 16px;
        font-weight: bold;
        border-radius: 20px;
        transition: width 0.4s ease-in-out;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            <i class="fas fa-file-upload"></i> Upload CSV File
                        </h5>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form id="csvUploadForm" class="row g-3" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-12">
                                <label for="csvFile" class="form-label"><i class="fas fa-file-csv"></i> Select CSV File</label>
                                <input class="form-control" type="file" id="csvFile" name="csv_file" required accept=".csv">
                                <div class="invalid-feedback" id="fileError" style="display: none;">
                                    Please select a valid CSV file.
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-upload"></i> Upload File
                                </button>
                            </div>
                        </form>
                        <div class="progress mt-4" id="progressBarContainer" style="height: 30px; display:none;">
                            <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-gradient" role="progressbar" 
                                style="width: 0%; background: linear-gradient(to right, #00c6ff, #0072ff);" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                            </div>
                        </div>
                        <div class="alert alert-success mt-4" style="display: none;" id="uploadSuccess">
                            <i class="fas fa-check-circle"></i> CSV file uploaded successfully!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
    $(document).ready(function () {
        $('#csvUploadForm').on('submit', function (e) {
            e.preventDefault();
            var fileInput = $('#csvFile');
            var filePath = fileInput.val();
            var allowedExtensions = /(\.csv)$/i;

            if (!allowedExtensions.exec(filePath)) {
                $('#fileError').show();
                return false;
            } else {
                $('#fileError').hide();
            }

            var formData = new FormData(this);
            $('#uploadSuccess').hide();
            $('#progressBarContainer').show();

            $.ajax({
                url: '<?php echo e(route('employees.process_csv_upload')); ?>',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                            $('#progressBar').width(percentComplete + '%');
                            $('#progressBar').text(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function (response) {
                    $('#progressBarContainer').hide();
                    $('#uploadSuccess').text(response.message).show();
                },
                error: function (response) {
                    var errors = response.responseJSON.errors;
                    var errorMessages = '';
                    if (errors) {
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessages += errors[key].join(', ') + '<br>';
                            }
                        }
                    } else {
                        errorMessages = 'Error uploading file.';
                    }
                    $('#uploadSuccess').removeClass('alert-success').addClass('alert-danger').html(errorMessages).show();
                    $('#progressBarContainer').hide();
                }
            });
        });
    });
</script><?php /**PATH /var/www/developmentoneso-project/resources/views/employee/upload_staff_csv_file.blade.php ENDPATH**/ ?>