<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />

<style>
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da !important;
        border-radius: 5px !important;
        padding: 6px 12px !important;
        font-size: 12px !important;
        line-height: 1.5 !important;
        background-color: #fff !important;
        text-transform: uppercase;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-left: 0px !important;
        color: #495057 !important;
        text-transform: uppercase;
        font-size: 12px !important;
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 38px !important;
        right: 10px !important;
    }

    .select2-container .select2-selection--single {
        display: flex !important;
        align-items: center !important;
    }

    input, select, textarea {
        text-transform: uppercase;
        font-size: 12px !important;
        height: 38px !important;
    }
</style>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">EDIT LEAD</h5>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('leads.update', $lead->id)); ?>" method="POST" class="row g-3">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="col-md-6">
                                <label for="first_name" class="form-label">FIRST NAME <span style="color: red;">*</span></label>
                                <input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo e(old('first_name', $lead->first_name)); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label for="last_name" class="form-label">LAST NAME <span style="color: red;">*</span></label>
                                <input type="text" name="last_name" class="form-control" id="last_name" value="<?php echo e(old('last_name', $lead->last_name)); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">PHONE NUMBER <span style="color: red;">*</span></label>
                                <input type="text" name="phone" class="form-control" id="phone" value="<?php echo e(old('phone', $lead->phone)); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">EMAIL</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php echo e(old('email', $lead->email)); ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="sales_name" class="form-label">SALES NAME</label>
                                <input type="text" name="sales_name" class="form-control" id="sales_name" value="<?php echo e(old('sales_name', $lead->sales_name)); ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="source" class="form-label">SOURCE</label>
                                <select name="source" class="form-select" id="source">
                                    <option disabled selected>CHOOSE...</option>
                                    <option value="INSTAGRAM" <?php echo e(old('source', $lead->source) == 'INSTAGRAM' ? 'selected' : ''); ?>>INSTAGRAM</option>
                                    <option value="TIKTOK" <?php echo e(old('source', $lead->source) == 'TIKTOK' ? 'selected' : ''); ?>>TIKTOK</option>
                                    <option value="FACEBOOK" <?php echo e(old('source', $lead->source) == 'FACEBOOK' ? 'selected' : ''); ?>>FACEBOOK</option>
                                    <option value="REFERRAL" <?php echo e(old('source', $lead->source) == 'REFERRAL' ? 'selected' : ''); ?>>REFERRAL</option>
                                    <option value="WALK-IN" <?php echo e(old('source', $lead->source) == 'WALK-IN' ? 'selected' : ''); ?>>WALK-IN</option>
                                    <option value="OTHER" <?php echo e(old('source', $lead->source) == 'OTHER' ? 'selected' : ''); ?>>OTHER</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label">CITY</label>
                                <input type="text" name="city" class="form-control" id="city" value="<?php echo e(old('city', $lead->city)); ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="nationality" class="form-label">NATIONALITY</label>
                                <select name="nationality" class="form-control select2" id="nationality"></select>
                            </div>

                            <div class="col-md-6">
                                <label for="emirate" class="form-label">EMIRATE</label>
                                <select name="emirate" class="form-control select2" id="emirate">
                                    <option disabled selected>CHOOSE EMIRATE</option>
                                    <option value="ABU DHABI" <?php echo e(old('emirate', $lead->emirate) == 'ABU DHABI' ? 'selected' : ''); ?>>ABU DHABI</option>
                                    <option value="DUBAI" <?php echo e(old('emirate', $lead->emirate) == 'DUBAI' ? 'selected' : ''); ?>>DUBAI</option>
                                    <option value="SHARJAH" <?php echo e(old('emirate', $lead->emirate) == 'SHARJAH' ? 'selected' : ''); ?>>SHARJAH</option>
                                    <option value="AJMAN" <?php echo e(old('emirate', $lead->emirate) == 'AJMAN' ? 'selected' : ''); ?>>AJMAN</option>
                                    <option value="UMM AL-QUWAIN" <?php echo e(old('emirate', $lead->emirate) == 'UMM AL-QUWAIN' ? 'selected' : ''); ?>>UMM AL-QUWAIN</option>
                                    <option value="RAS AL-KHAIMAH" <?php echo e(old('emirate', $lead->emirate) == 'RAS AL-KHAIMAH' ? 'selected' : ''); ?>>RAS AL-KHAIMAH</option>
                                    <option value="FUJAIRAH" <?php echo e(old('emirate', $lead->emirate) == 'FUJAIRAH' ? 'selected' : ''); ?>>FUJAIRAH</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="negotiation" class="form-label">NEGOTIATION</label>
                                <select name="negotiation" class="form-control select2" id="negotiation">
                                    <option value="IN NEGOTIATION" <?php echo e(old('negotiation', $lead->negotiation) == 'IN NEGOTIATION' ? 'selected' : ''); ?>>IN NEGOTIATION</option>
                                    <option value="DEAL LOST" <?php echo e(old('negotiation', $lead->negotiation) == 'DEAL LOST' ? 'selected' : ''); ?>>DEAL LOST</option>
                                    <option value="DEAL ON HOLD" <?php echo e(old('negotiation', $lead->negotiation) == 'DEAL ON HOLD' ? 'selected' : ''); ?>>DEAL ON HOLD</option>
                                    <option value="DEAL WON" <?php echo e(old('negotiation', $lead->negotiation) == 'DEAL WON' ? 'selected' : ''); ?>>DEAL WON</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="notes" class="form-label">NOTES</label>
                                <textarea name="notes" class="form-control" id="notes" rows="3"><?php echo e(old('notes', $lead->notes)); ?></textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">UPDATE LEAD</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: 'SEARCH AND SELECT'
        });

        $('#nationality').select2({
            ajax: {
                url: '<?php echo e(route("get.countries")); ?>',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name.toUpperCase(),
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/leads/edit.blade.php ENDPATH**/ ?>