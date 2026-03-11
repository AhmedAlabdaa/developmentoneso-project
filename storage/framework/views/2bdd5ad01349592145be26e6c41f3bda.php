<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Chart of Account</h5>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('chart-of-accounts.update', $account->account_id)); ?>" method="POST" class="row g-3" id="coaEditForm">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="col-md-6">
                                <label for="account_code" class="form-label">Account Code <span style="color:red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                    <input type="text"
                                           name="account_code"
                                           class="form-control"
                                           id="account_code"
                                           value="<?php echo e(old('account_code', $account->account_code)); ?>"
                                           required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="currency_code" class="form-label">Currency</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                    <input type="text" class="form-control" id="currency_code" value="AED" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="account_name" class="form-label">Account Name <span style="color:red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-font"></i></span>
                                    <input type="text"
                                           name="account_name"
                                           class="form-control"
                                           id="account_name"
                                           value="<?php echo e(old('account_name', $account->account_name)); ?>"
                                           required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="parent_account_code" class="form-label">Parent Account</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                                    <select name="parent_account_code" class="form-select" id="parent_account_code">
                                        <option value="">No Parent (Top Level)</option>
                                        <?php $__currentLoopData = $parentAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($p->account_code); ?>"
                                                <?php echo e((string)old('parent_account_code', $account->parent_account_code) === (string)$p->account_code ? 'selected' : ''); ?>>
                                                <?php echo e($p->account_code); ?> - <?php echo e($p->account_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <small class="text-muted">Parent cannot be the same account.</small>
                            </div>

                            <div class="col-md-6">
                                <label for="account_type" class="form-label">Account Type <span style="color:red;">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                    <select name="account_type" class="form-select" id="account_type" required>
                                        <?php $__currentLoopData = ['ASSET','LIABILITY','EQUITY','INCOME','EXPENSE']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($t); ?>" <?php echo e(old('account_type', $account->account_type) == $t ? 'selected' : ''); ?>>
                                                <?php echo e($t); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Normal Balance</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input type="text" class="form-control" id="normal_balance_preview" value="" readonly>
                                </div>
                                <input type="hidden" name="normal_balance" id="normal_balance"
                                       value="<?php echo e(old('normal_balance', $account->normal_balance)); ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Posting Account</label>
                                <input type="hidden" name="is_posting" value="0">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_posting"
                                           name="is_posting" value="1" <?php echo e(old('is_posting', (int)$account->is_posting) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="is_posting">Yes</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Control Account</label>
                                <input type="hidden" name="is_control" value="0">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_control"
                                           name="is_control" value="1" <?php echo e(old('is_control', (int)$account->is_control) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="is_control">Yes</label>
                                </div>
                                <small class="text-muted">If enabled, Posting is forced ON.</small>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Active</label>
                                <input type="hidden" name="is_active" value="0">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                           name="is_active" value="1" <?php echo e(old('is_active', (int)$account->is_active) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="is_active">Enabled</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
                                    <input type="number"
                                           name="sort_order"
                                           class="form-control"
                                           id="sort_order"
                                           min="0"
                                           value="<?php echo e(old('sort_order', $account->sort_order ?? 0)); ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" id="submitButton">
                                    <i class="fas fa-save me-1"></i> Update
                                </button>
                                <a href="<?php echo e(route('chart-of-accounts.index')); ?>" class="btn btn-light ms-2">
                                    Cancel
                                </a>
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
    (function () {
        const typeEl = document.getElementById('account_type');
        const nbHidden = document.getElementById('normal_balance');
        const nbPreview = document.getElementById('normal_balance_preview');
        const isControl = document.getElementById('is_control');
        const isPosting = document.getElementById('is_posting');
        const parentEl = document.getElementById('parent_account_code');
        const codeEl = document.getElementById('account_code');

        function setNormalBalance() {
            const t = (typeEl.value || '').toUpperCase();
            let nb = '';
            if (t === 'ASSET' || t === 'EXPENSE') nb = 'D (Debit)';
            if (t === 'LIABILITY' || t === 'EQUITY' || t === 'INCOME') nb = 'C (Credit)';
            nbPreview.value = nb;
            nbHidden.value = nb.startsWith('D') ? 'D' : (nb.startsWith('C') ? 'C' : '');
        }

        function enforceRules() {
            if (isControl.checked) {
                isPosting.checked = true;
                isPosting.disabled = true;
            } else {
                isPosting.disabled = false;
            }

            if ((parentEl.value || '') !== '' && (codeEl.value || '') === (parentEl.value || '')) {
                parentEl.value = '';
            }
        }

        typeEl.addEventListener('change', setNormalBalance);
        isControl.addEventListener('change', enforceRules);
        isPosting.addEventListener('change', enforceRules);
        parentEl.addEventListener('change', enforceRules);
        codeEl.addEventListener('keyup', enforceRules);

        setNormalBalance();
        enforceRules();
    })();
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/chart_of_accounts/edit.blade.php ENDPATH**/ ?>