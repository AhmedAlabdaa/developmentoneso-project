@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body { background: linear-gradient(to right, #e0f7fa, #e1bee7); font-family: Arial, sans-serif; }
    .filter-section { background:#fff; padding:15px; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,.08); margin:18px 0; }
    .table thead th { background: linear-gradient(to right, #007bff, #00c6ff); color:#fff; text-align:center; font-weight:600; }
    .preloader { display:none; font-size:14px; color:#007bff; }
    label { font-size:12px; font-weight:600; margin-bottom:6px; }
    .btn-primary { background: linear-gradient(to right, #007bff, #00c6ff); border:none; }
    .description { font-size:12px; color:#343a40; margin:10px 0; padding:10px; background:#f8f9fa; border-left:5px solid #007bff; border-radius:6px; }
</style>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h5 class="card-title mb-0">Manage Chart of Accounts</h5>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                                <i class="fas fa-plus-circle me-1"></i> Add Account
                            </button>
                        </div>

                        <div class="filter-section">
                            <form id="filter_form" class="row g-3">
                                <div class="col-md-3">
                                    <label for="account_code"><i class="fas fa-barcode me-1"></i> Account Code</label>
                                    <input type="text" id="account_code" name="account_code" class="form-control" placeholder="Search code">
                                </div>

                                <div class="col-md-4">
                                    <label for="account_name"><i class="fas fa-signature me-1"></i> Account Name</label>
                                    <input type="text" id="account_name" name="account_name" class="form-control" placeholder="Search name">
                                </div>

                                <div class="col-md-3">
                                    <label for="account_type"><i class="fas fa-layer-group me-1"></i> Account Type</label>
                                    <select id="account_type" name="account_type" class="form-control">
                                        <option value="">All Types</option>
                                        <option value="ASSET">ASSET</option>
                                        <option value="LIABILITY">LIABILITY</option>
                                        <option value="EQUITY">EQUITY</option>
                                        <option value="INCOME">INCOME</option>
                                        <option value="EXPENSE">EXPENSE</option>
                                    </select>
                                </div>

                                <div class="col-md-2 d-flex align-items-end gap-2">
                                    <button type="button" class="btn btn-outline-secondary w-100" id="resetFilters">
                                        <i class="fas fa-eraser me-1"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="preloader" id="preloader"><i class="fas fa-spinner fa-spin me-1"></i> Loading...</div>
                        </div>

                        <div class="table-responsive" id="accounts_table"></div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header text-white" style="background: linear-gradient(to right, #007bff, #00c6ff);">
                <h6 class="modal-title" id="addAccountModalLabel">
                    <i class="fas fa-plus-circle me-2"></i> Add New Account
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addAccountForm">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label"><i class="fas fa-hashtag me-1"></i> Account Code</label>
                            <input type="text" class="form-control" id="account_code_form" name="account_code" placeholder="Leave empty to auto-generate">
                            <div class="invalid-feedback" id="err_account_code"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"><i class="fas fa-coins me-1"></i> Currency</label>
                            <input type="text" class="form-control" value="AED" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"><i class="fas fa-sort-numeric-down me-1"></i> Sort Order</label>
                            <input type="number" class="form-control" id="sort_order_form" name="sort_order" min="0" value="0">
                            <div class="invalid-feedback" id="err_sort_order"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-file-signature me-1"></i> Account Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="account_name_form" name="account_name" placeholder="Enter account name" required>
                            <div class="invalid-feedback" id="err_account_name"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-sitemap me-1"></i> Parent Account</label>
                            <select class="form-select" id="parent_account_code_form" name="parent_account_code">
                                <option value="">No Parent (Top Level)</option>
                                @foreach($parentAccounts as $account)
                                    <option value="{{ $account->account_code }}">
                                        {{ $account->account_code }} - {{ $account->account_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="err_parent_account_code"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-layer-group me-1"></i> Account Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="account_type_form" name="account_type" required>
                                <option value="" disabled selected>Select type</option>
                                <option value="ASSET">ASSET</option>
                                <option value="LIABILITY">LIABILITY</option>
                                <option value="EQUITY">EQUITY</option>
                                <option value="INCOME">INCOME</option>
                                <option value="EXPENSE">EXPENSE</option>
                            </select>
                            <div class="invalid-feedback" id="err_account_type"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-balance-scale me-1"></i> Normal Balance</label>
                            <input type="text" class="form-control" id="normal_balance_preview" value="" readonly>
                            <input type="hidden" name="normal_balance" id="normal_balance_form">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Posting Account</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_posting_form" name="is_posting" value="1" checked>
                                <label class="form-check-label" for="is_posting_form">Yes</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Control Account</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_control_form" name="is_control" value="1">
                                <label class="form-check-label" for="is_control_form">Yes</label>
                            </div>
                            <small class="text-muted">If ON, Posting will be forced ON.</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Active</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active_form" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active_form">Enabled</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times-circle me-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="saveAccountBtn">
                        <i class="fas fa-save me-1"></i> Add Account
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@include('../layout.footer')

<script>
    function debounce(fn, delay = 350) {
        let t;
        return function () {
            clearTimeout(t);
            const args = arguments;
            const ctx = this;
            t = setTimeout(() => fn.apply(ctx, args), delay);
        };
    }

    function loadAccounts(url = null) {
        const formData = $('#filter_form').serialize();
        $('#preloader').show();

        $.ajax({
            url: url || '{{ route("chart-of-accounts.index") }}',
            type: 'GET',
            data: formData,
            success: function (html) {
                $('#accounts_table').html(html);
                $('#preloader').hide();
            },
            error: function () {
                $('#preloader').hide();
                toastr.error('Error loading accounts. Please try again.');
            }
        });
    }

    function clearFormErrors() {
        $('#addAccountForm .is-invalid').removeClass('is-invalid');
        $('[id^="err_"]').text('');
    }

    function setNormalBalancePreview() {
        const t = ($('#account_type_form').val() || '').toUpperCase();
        let preview = '';
        let nb = '';

        if (t === 'ASSET' || t === 'EXPENSE') { preview = 'D (Debit)'; nb = 'D'; }
        if (t === 'LIABILITY' || t === 'EQUITY' || t === 'INCOME') { preview = 'C (Credit)'; nb = 'C'; }

        $('#normal_balance_preview').val(preview);
        $('#normal_balance_form').val(nb);
    }

    function enforceControlRule() {
        if ($('#is_control_form').is(':checked')) {
            $('#is_posting_form').prop('checked', true).prop('disabled', true);
        } else {
            $('#is_posting_form').prop('disabled', false);
        }
    }

    function hideModal(modalId) {
        const el = document.getElementById(modalId);
        const instance = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
        instance.hide();
    }

    function confirmDelete(accountID) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will delete the account.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${accountID}`).submit();
            }
        });
    }

    $(document).ready(function () {
        const token = $('#addAccountForm input[name="_token"]').val();

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': token }
        });

        loadAccounts();

        const debouncedLoad = debounce(() => loadAccounts(), 350);

        $('#filter_form input').on('keyup', debouncedLoad);
        $('#filter_form select').on('change', debouncedLoad);

        $('#resetFilters').on('click', function () {
            $('#filter_form')[0].reset();
            loadAccounts();
        });

        $(document).on('click', '#accounts_table .pagination a', function (e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url) loadAccounts(url);
        });

        $('#account_type_form').on('change', setNormalBalancePreview);
        $('#is_control_form').on('change', enforceControlRule);

        $('#addAccountModal').on('shown.bs.modal', function () {
            clearFormErrors();
            setNormalBalancePreview();
            enforceControlRule();
        });

        $('#saveAccountBtn').on('click', function () {
            clearFormErrors();

            const payload = {
                account_code: $('#account_code_form').val(),
                account_name: $('#account_name_form').val(),
                parent_account_code: $('#parent_account_code_form').val(),
                account_type: $('#account_type_form').val(),
                normal_balance: $('#normal_balance_form').val(),
                is_posting: $('#is_posting_form').is(':checked') ? 1 : 0,
                is_control: $('#is_control_form').is(':checked') ? 1 : 0,
                is_active: $('#is_active_form').is(':checked') ? 1 : 0,
                sort_order: $('#sort_order_form').val(),
                _token: token
            };

            if (!payload.account_name || !payload.account_type) {
                if (!payload.account_name) {
                    $('#account_name_form').addClass('is-invalid');
                    $('#err_account_name').text('Account Name is required.');
                }
                if (!payload.account_type) {
                    $('#account_type_form').addClass('is-invalid');
                    $('#err_account_type').text('Account Type is required.');
                }
                return;
            }

            $('#saveAccountBtn').prop('disabled', true);

            $.ajax({
                url: '{{ route("chart-of-accounts.store") }}',
                method: 'POST',
                data: payload,
                success: function (resp) {
                    toastr.success(resp.message || 'Account added successfully!');
                    $('#addAccountForm')[0].reset();
                    setNormalBalancePreview();
                    enforceControlRule();
                    hideModal('addAccountModal');
                    $('#saveAccountBtn').prop('disabled', false);
                    loadAccounts();
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;

                        if (errors.account_code) {
                            $('#account_code_form').addClass('is-invalid');
                            $('#err_account_code').text(errors.account_code[0]);
                        }
                        if (errors.account_name) {
                            $('#account_name_form').addClass('is-invalid');
                            $('#err_account_name').text(errors.account_name[0]);
                        }
                        if (errors.parent_account_code) {
                            $('#parent_account_code_form').addClass('is-invalid');
                            $('#err_parent_account_code').text(errors.parent_account_code[0]);
                        }
                        if (errors.account_type) {
                            $('#account_type_form').addClass('is-invalid');
                            $('#err_account_type').text(errors.account_type[0]);
                        }
                        if (errors.sort_order) {
                            $('#sort_order_form').addClass('is-invalid');
                            $('#err_sort_order').text(errors.sort_order[0]);
                        }
                    } else {
                        toastr.error('An unexpected error occurred. Please try again.');
                    }

                    $('#saveAccountBtn').prop('disabled', false);
                }
            });
        });
    });
</script>
