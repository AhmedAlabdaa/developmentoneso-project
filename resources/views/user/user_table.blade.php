<style>
   .table-container {
        width: 100%;
        overflow-x: auto;
        position: relative;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
        border-spacing: 0;
        margin-bottom: 20px;
    }
    .table th, .table td {
        padding: 10px 15px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #ddd;
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow: ellipsis; 
    }
    .table th {
        background-color: #343a40;
        color: white;
        text-transform: uppercase;
        font-weight: bold;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    @media screen and (max-width: 768px) {
        .table th, .table td {
            padding: 8px 12px;
        }
    }
    .actions {
        display: flex;
        gap: 5px;
    }
    .btn-icon-only {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        border-radius: 50%;
        font-size: 12px;
        width: 30px;
        height: 30px;
        color: white;
    }
    .btn-info {
        background-color: #17a2b8;
    }
    .btn-warning {
        background-color: #ffc107;
    }
    .btn-danger {
        background-color: #dc3545;
    }
    .password-group {
        position: relative;
        display: inline-flex;
        align-items: center;
    }
    .password-group input {
        padding-right: 60px;
    }
    .password-group .password-icon {
        position: absolute;
        right: 40px;
        cursor: pointer;
    }
    .password-group .copy-icon {
        position: absolute;
        right: 10px;
        cursor: pointer;
    }
</style>
<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
                <th>Nationality</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td style="text-transform: none;">{{ $user->email }}</td>
                    <td>
                        <div class="password-group">
                            <input type="password" style="text-transform: none;" class="form-control" id="password-{{ $user->id }}" value="{{ $user->password }}" readonly>
                            <span class="password-icon" onclick="togglePassword({{ $user->id }})">
                                <i class="fas fa-eye"></i>
                            </span>
                            <span class="copy-icon" onclick="copyPassword({{ $user->id }})">
                                <i class="fas fa-copy"></i>
                            </span>
                        </div>
                    </td>
                    <td>{{ $user->role }}</td>
                    @php
                        $nationalities = [
                            1 => 'Ethiopia',
                            2 => 'Uganda',
                            3 => 'Philippines',
                            4 => 'Indonesia',
                            5 => 'Sri Lanka',
                            6 => 'Myanmar',
                        ];
                    @endphp
                    <td>
                        {{ $nationalities[$user->nationality] ?? 'N/A' }}
                    </td>
                    <td>{{ $user->status }}</td>
                    <td class="actions">
                        <button type="button" class="btn btn-info btn-icon-only" data-bs-toggle="modal" data-bs-target="#viewUserModal-{{ $user->id }}" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-warning btn-icon-only" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-primary btn-icon-only" title="Change Password" data-bs-toggle="modal" data-bs-target="#changePasswordModal-{{ $user->id }}">
                            <i class="fas fa-key"></i>
                        </button>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-icon-only" title="Delete" onclick="return confirm('Are you sure?');">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <!-- View User Modal -->
                <div class="modal fade" id="viewUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="viewUserModalLabel"><i class="fas fa-eye"></i> View User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>First Name:</strong> {{ $user->first_name }}</p>
                                <p><strong>Last Name:</strong> {{ $user->last_name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Role:</strong> {{ $user->role }}</p>
                                <p><strong>Nationality:</strong> {{ $user->nationality }}</p>
                                <p><strong>Status:</strong> {{ $user->status }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title" id="editUserModalLabel"><i class="fas fa-edit"></i> Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editUserForm-{{ $user->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="first_name-{{ $user->id }}"><i class="fas fa-user"></i> First Name</label>
                                            <input type="text" id="first_name-{{ $user->id }}" name="first_name" class="form-control" value="{{ $user->first_name }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="last_name-{{ $user->id }}"><i class="fas fa-user"></i> Last Name</label>
                                            <input type="text" id="last_name-{{ $user->id }}" name="last_name" class="form-control" value="{{ $user->last_name }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email-{{ $user->id }}"><i class="fas fa-envelope"></i> Email</label>
                                            <input type="email" id="email-{{ $user->id }}" name="email" class="form-control" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nationality-{{ $user->id }}"><i class="fas fa-flag"></i> Nationality</label>
                                            @php
                                                $nationalities = [
                                                    1 => 'Ethiopia',
                                                    2 => 'Uganda',
                                                    3 => 'Philippines',
                                                    4 => 'Indonesia',
                                                    5 => 'Sri Lanka',
                                                    6 => 'Myanmar',
                                                ];
                                            @endphp
                                            <select id="nationality-{{ $user->id }}" name="nationality_id" class="form-control">
                                                <option value="">Select Nationality</option>
                                                @foreach ($nationalities as $id => $name)
                                                    <option value="{{ $id }}" {{ old('nationality_id', $user->nationality_id ?? '') == $id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="role-{{ $user->id }}"><i class="fas fa-user-tag"></i> Role</label>
                                            <select id="role-{{ $user->id }}" name="role" class="form-control" required>
                                                <option value="">Select Role</option>
                                                @foreach(['Managing Director', 'Marketing Manager', 'Sales Officer', 'Operations Manager', 'Digital Marketing Specialist', 'Digital Marketing Executive', 'Photographer', 'Accountant', 'Junior Accountant','Cashier', 'HR Manager', 'Contract Administrator', 'PRO', 'Web Manager', 'Sales Coordinator', 'Operations Supervisor', 'Happiness Consultant', 'Customer Service', 'Finance Officer'] as $role)
                                                    <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>{{ $role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                                <button type="button" class="btn btn-success" id="update_user" data-user-id="{{ $user->id }}"><i class="fas fa-save"></i> Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="changePasswordModal-{{ $user->id }}" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="changePasswordModalLabel">
                                    <i class="fas fa-key"></i> Change Password
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="changePasswordForm-{{ $user->id }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="new_password-{{ $user->id }}">
                                            <i class="fas fa-key"></i> New Password
                                        </label>
                                        <input type="password" id="new_password-{{ $user->id }}" name="new_password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password-{{ $user->id }}"><i class="fas fa-key"></i> Confirm Password</label>
                                        <input type="password" id="confirm_password-{{ $user->id }}" name="new_password_confirmation" class="form-control" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                                <button type="button" class="btn btn-success" onclick="changePassword({{ $user->id }})">
                                    <i class="fas fa-save"></i> Change Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
                <th>Nationality</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results</span>
        <ul class="pagination justify-content-center">
            {{ $users->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>
<script type="text/javascript">
    function togglePassword(userId) {
        const passwordField = document.getElementById(`password-${userId}`);
        const icon = passwordField.nextElementSibling.firstElementChild;
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    function copyPassword(userId) {
        const passwordField = document.getElementById(`password-${userId}`);
        if (navigator.clipboard) {
            navigator.clipboard.writeText(passwordField.value)
                .then(() => {
                    toastr.success('Password copied to clipboard!');
                })
                .catch(() => {
                    toastr.error('Failed to copy password.');
                });
        } else {
            const tempInput = document.createElement('input');
            document.body.appendChild(tempInput);
            tempInput.value = passwordField.value;
            tempInput.select();
            tempInput.setSelectionRange(0, 99999);
            try {
                document.execCommand('copy');
                toastr.success('Password copied to clipboard!');
            } catch (error) {
                toastr.error('Failed to copy password.');
            }
            document.body.removeChild(tempInput);
        }
    }
    
    $(document).on('click', '#update_user', function (e) {
        e.preventDefault();
        const userId = $(this).data('user-id');
        const firstName = $(`#first_name-${userId}`).val().trim();
        const lastName = $(`#last_name-${userId}`).val().trim();
        const email = $(`#email-${userId}`).val().trim();
        const role = $(`#role-${userId}`).val();
        const nationality = $(`#nationality-${userId}`).val();

        let isValid = true;
        $(`#editUserForm-${userId}`).find('.is-invalid').removeClass('is-invalid');

        if (!firstName) {
            $(`#first_name-${userId}`).addClass('is-invalid');
            toastr.error('The first name field is required.');
            isValid = false;
        }

        if (!lastName) {
            $(`#last_name-${userId}`).addClass('is-invalid');
            toastr.error('The last name field is required.');
            isValid = false;
        }

        if (!email) {
            $(`#email-${userId}`).addClass('is-invalid');
            toastr.error('The email field is required.');
            isValid = false;
        }

        if (!role) {
            $(`#role-${userId}`).addClass('is-invalid');
            toastr.error('The role field is required.');
            isValid = false;
        }

        if (role === 'Sales Coordinator' && !nationality) {
            $(`#nationality-${userId}`).addClass('is-invalid');
            toastr.error('The nationality field is required for the Sales Coordinator role.');
            isValid = false;
        }

        if (isValid) {
            const data = {
                first_name: firstName,
                last_name: lastName,
                email: email,
                role: role,
                nationality: nationality,
                _token: $('meta[name="csrf-token"]').attr('content') 
            };

            const button = $(this);
            button.prop('disabled', true);

            $.ajax({
                url: `/users/${userId}`,
                type: 'POST',
                data: data,
                success: function (response) {
                    console.log("Server Response:", response);
                    $(`#editUserModal-${userId}`).modal('hide');
                    toastr.success(response.message);
                    loadUsers(); // Refresh user list
                },
                error: function (xhr) {
                    console.error("Error Response:", xhr);
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

    function changePassword(userId) {
        const form = document.getElementById(`changePasswordForm-${userId}`);
        const newPassword = $(`#new_password-${userId}`).val();
        const confirmPassword = $(`#confirm_password-${userId}`).val();
        if (newPassword !== confirmPassword) {
            toastr.error('New password and confirm password must match.');
            return;
        }
        const formData = new FormData(form);
        fetch(`/users/change-password/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                $(`#changePasswordModal-${userId}`).modal('hide');
            } else if (data.errors) {
                toastr.error(Object.values(data.errors).join('<br>'));
            } else {
                toastr.error('Failed to change password.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('An unexpected error occurred. Please try again.');
        });
    }
</script>
