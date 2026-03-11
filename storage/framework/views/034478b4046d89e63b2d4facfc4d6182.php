<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style type="text/css">
    body {
        background: linear-gradient(to right, #e0f7fa, #e1bee7);
        font-family: Arial, sans-serif;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .nav-tabs .nav-link {
        color: #495057;
    }

    .nav-tabs .nav-link:hover {
        background-color: #f8f9fa;
    }

    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: white;
    }

    .no-records img {
        margin-top: 20px;
    }

    .filter-section {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }

    .toggle-filters {
        cursor: pointer;
        color: #007bff;
        font-weight: normal;
        margin: 20px;
    }

    .table thead th {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
    }
    .table tfoot th {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
    }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
    }

    .preloader {
        display: none;
        position: absolute;
        left: 40%;
        font-size: 20px;
        color: #007bff;
    }

    .description {
        font-size: 12px;
        color: #343a40;
        margin: 10px 0 10px;
        padding: 10px;
        background-color: #f8f9fa;
        border-left: 5px solid #007bff;
    }

    label {
        font-size: 12px;
    }

    .btn-primary {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: white;
        text-align: center;
        font-weight: normal;
        border: none;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">User Management</h5>
                            <button data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add User
                            </button>
                        </div>
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search_by_user_name" placeholder="Search by Name or Email...">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="user_table">
                            <div class="preloader">
                                <i class="fas fa-spinner fa-spin"></i> Loading...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="fas fa-plus-circle"></i> Add User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name"><i class="fas fa-user"></i> First Name *</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter first name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name"><i class="fas fa-user"></i> Last Name *</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter last name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email"><i class="fas fa-envelope"></i> Email *</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nationality"><i class="fas fa-flag"></i> Nationality</label>
                            <select id="nationality" name="nationality" class="form-control">
                                <option value="">Select Nationality</option>
                                <option value="1">Ethiopia</option>
                                <option value="2">Uganda</option>
                                <option value="3">Philippines</option>
                                <option value="4">Indonesia</option>
                                <option value="5">Sri Lanka</option>
                                <option value="6">Myanmar</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role"><i class="fas fa-user-tag"></i> Role *</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="Managing Director">Managing Director</option>
                                <option value="Marketing Manager">Marketing Manager</option>
                                <option value="Digital Marketing Specialist">Digital Marketing Specialist</option>
                                <option value="Digital Marketing Executive">Digital Marketing Executive</option>
                                <option value="Photographer">Photographer</option>
                                <option value="Accountant">Accountant</option>
                                <option value="Junior Accountant">Junior Accountant</option>
                                <option value="Cashier">Cashier</option>
                                <option value="HR Manager">HR Manager</option>
                                <option value="Operations Manager">Operations Manager</option>
                                <option value="Contract Administrator">Contract Administrator</option>
                                <option value="PRO">PRO</option>
                                <option value="Web Manager">Web Manager</option>
                                <option value="Sales Manager">Sales Manager</option>
                                <option value="Sales Officer">Sales Officer</option>
                                <option value="Sales Coordinator">Sales Coordinator</option>
                                <option value="Operations Supervisor">Operations Supervisor</option>
                                <option value="Happiness Consultant">Happiness Consultant</option>
                                <option value="Customer Service">Customer Service</option>
                                <option value="Finance Officer">Finance Officer</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password"><i class="fas fa-key"></i> Password *</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" id="save_user" class="btn btn-success">
                    <i class="fas fa-save"></i> Save User
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
    $(document).ready(function () {
        loadUsers();
        $('#search_by_user_name').on('input', function () {
            const query = $(this).val();
            loadUsers({ query: query });
        });
        function loadUsers(params = {}) {
            $('.preloader').show();
            $.ajax({
                url: '<?php echo e(route("users.all")); ?>',
                type: 'GET',
                data: params,
                success: function (response) {
                    $('#user_table').html(response);
                },
                error: function () {
                    $('#user_table').html('<p class="text-danger">Error loading users. Please try again.</p>');
                },
                complete: function () {
                    $('.preloader').hide();
                }
            });
        }
        $('#save_user').on('click', function (e) {
            e.preventDefault();
            const form = document.getElementById('addUserForm');
            let isValid = true;
            form.querySelectorAll('input[required], select[required]').forEach(field => {
                if (field.value.trim() === '') {
                    field.classList.add('is-invalid');
                    toastr.error(`${field.previousElementSibling.textContent.trim()} is required.`);
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            const role = document.getElementById('role').value;
            const nationality = document.getElementById('nationality').value;
            if (role === 'Sales Coordinator' && !nationality) {
                const nationalityField = document.getElementById('nationality');
                nationalityField.classList.add('is-invalid');
                toastr.error('Nationality is required for the role Sales Coordinator.');
                isValid = false;
            } else {
                document.getElementById('nationality').classList.remove('is-invalid');
            }

            if (isValid) {
                const formData = $('#addUserForm').serialize();
                const button = $(this);
                button.prop('disabled', true);
                $.ajax({
                    url: '<?php echo e(route("users.store")); ?>',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#addUserModal').modal('hide');
                        toastr.success(response.message);
                        loadUsers();
                    },
                    error: function (xhr) {
                        if (xhr.responseJSON?.errors) {
                            const errors = xhr.responseJSON.errors;
                            const errorMessages = Object.values(errors).flat().join('<br>');
                            toastr.error(errorMessages);
                        } else {
                            toastr.error('An unexpected error occurred. Please try again.');
                        }
                    },
                    complete: function () {
                        button.prop('disabled', false);
                    }
                });
            }
        });

        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            loadUsers(parseQueryString(url));
        });

        function parseQueryString(url) {
            const queryString = url.split('?')[1] || '';
            return queryString.split('&').reduce((params, param) => {
                const [key, value] = param.split('=');
                params[key] = decodeURIComponent(value);
                return params;
            }, {});
        }
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/user/all.blade.php ENDPATH**/ ?>