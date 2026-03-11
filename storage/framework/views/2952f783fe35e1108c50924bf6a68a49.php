<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
  .select2-container--bootstrap-5 .select2-selection__rendered,
  .select2-container--bootstrap-5 .select2-selection__placeholder,
  .select2-container--bootstrap-5 .select2-search .select2-search__field,
  .select2-container--bootstrap-5 .select2-results__option { font-size:12px; line-height:1.4 }
  .attachments-card { border:1px solid #e9ecef; border-radius:.5rem }
  .attachments-title { font-weight:600; font-size:1rem; margin-bottom:.5rem }
  .attachments-banner { background:#e9f2ff; color:#0d6efd; padding:.75rem 1rem; display:flex; align-items:center; gap:.5rem; border-left:6px solid #0d6efd; border-radius:.5rem .5rem 0 0 }
  .attachments-banner i { font-size:1rem }
  #attachmentsTable thead th { background:#0d6efd; color:#fff; vertical-align:middle; text-transform:uppercase; font-size:.8rem; letter-spacing:.02em }
  #attachmentsTable td { vertical-align:middle }
  .btn-add { background:#198754; color:#fff }
  .btn-add:hover { color:#fff }
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Package</h5>

            <?php if($errors->any()): ?>
              <div class="alert alert-danger">
                <ul class="mb-0">
                  <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
            <?php endif; ?>

            <?php
              $allowedCountries = ['Ethiopian','India','Indonesia','Kenya','Myanmar','Philippines','Uganda','SriLanka'];
              $nationalities = array_values(array_unique($allowedCountries));
              $selectedNationality = old('nationality', '');
              $selectedForeignPartner = old('foreign_partner', '');
              $documentTypes = ['Passport Copy','Visa Copy','Medical Report','Offer Letter','Contract','QID Copy','Photo','Ticket','Other'];
            ?>

            <form action="<?php echo e(route('package.store')); ?>" method="POST" class="row g-3" enctype="multipart/form-data" id="packageFormCreate">
              <?php echo csrf_field(); ?>

              <div class="col-md-6">
                <label for="candidate_name" class="form-label">Candidate Name <span style="color:#dc3545">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="candidate_name" id="candidate_name" class="form-control" value="<?php echo e(old('candidate_name')); ?>" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="foreign_partner" class="form-label">Foreign Partner</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                  <select name="foreign_partner" id="foreign_partner" class="form-select">
                    <option value="" disabled <?php echo e($selectedForeignPartner === '' ? 'selected' : ''); ?>>Select foreign partner…</option>
                    <optgroup label="Ethiopian Agencies">
                      <option value="ADEY"   <?php echo e($selectedForeignPartner === 'ADEY' ? 'selected' : ''); ?>>Adey</option>
                      <option value="BMG"    <?php echo e($selectedForeignPartner === 'BMG' ? 'selected' : ''); ?>>BMG</option>
                      <option value="ALKABA" <?php echo e($selectedForeignPartner === 'ALKABA' ? 'selected' : ''); ?>>Alkaba</option>
                      <option value="MY"     <?php echo e($selectedForeignPartner === 'MY' ? 'selected' : ''); ?>>My</option>
                    </optgroup>
                    <optgroup label="Philippine Agencies">
                      <option value="Ritemerit" <?php echo e($selectedForeignPartner === 'Ritemerit' ? 'selected' : ''); ?>>Ritemerit</option>
                      <option value="Khalid"    <?php echo e($selectedForeignPartner === 'Khalid' ? 'selected' : ''); ?>>Khalid</option>
                      <option value="Pinoy"    <?php echo e($selectedForeignPartner === 'Pinoy' ? 'selected' : ''); ?>>Pinoy</option>
                      <option value="Philandco"    <?php echo e($selectedForeignPartner === 'Philandco' ? 'selected' : ''); ?>>Philandco</option>
                    </optgroup>
                    <optgroup label="Sri Lanka Agency">
                      <option value="Greenway" <?php echo e($selectedForeignPartner === 'Greenway' ? 'selected' : ''); ?>>Greenway</option>
                    </optgroup>
                    <optgroup label="Ugandan Agencies">
                      <option value="Edith"  <?php echo e($selectedForeignPartner === 'Edith' ? 'selected' : ''); ?>>Edith</option>
                      <option value="Stella" <?php echo e($selectedForeignPartner === 'Stella' ? 'selected' : ''); ?>>Stella</option>
                    </optgroup>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <label for="passport_no" class="form-label">Passport No <span style="color:#dc3545">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                  <input type="text" name="passport_no" id="passport_no" class="form-control" value="<?php echo e(old('passport_no')); ?>" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="passport_expiry_date" class="form-label">Passport Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="passport_expiry_date" id="passport_expiry_date" class="form-control" value="<?php echo e(old('passport_expiry_date')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="<?php echo e(old('date_of_birth')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="visa_type" class="form-label">Visa Type</label>
                <select name="visa_type" id="visa_type" class="form-select select2-visa">
                  <option value="">Select Visa Type</option>
                  <option value="D-SPO"     <?php echo e(old('visa_type')=='D-SPO' ? 'selected' : ''); ?>>D-SPO</option>
                  <option value="D-HIRE"    <?php echo e(old('visa_type')=='D-HIRE' ? 'selected' : ''); ?>>D-HIRE</option>
                  <option value="C-SPO"     <?php echo e(old('visa_type')=='C-SPO' ? 'selected' : ''); ?>>C-SPO</option>
                  <option value="OFFICE-V"  <?php echo e(old('visa_type')=='OFFICE-V' ? 'selected' : ''); ?>>OFFICE-V</option>
                  <option value="HAYYA"     <?php echo e(old('visa_type')=='HAYYA' ? 'selected' : ''); ?>>HAYYA</option>
                  <option value="tourist"   <?php echo e(old('visa_type')=='tourist' ? 'selected' : ''); ?>>Tourist</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="CL_Number" class="form-label">CL Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  <input type="text" name="CL_Number" id="CL_Number" class="form-control" value="<?php echo e(old('CL_Number')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="sponsor_name" class="form-label">Sponsor Name</label>
                <select name="sponsor_name" id="sponsor_name" class="form-select select2-sponsor">
                  <option value="">Select Sponsor</option>
                  <?php $__currentLoopData = $crmCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $full = trim(($customer->first_name ?? '').' '.($customer->last_name ?? '')); ?>
                    <option value="<?php echo e($full); ?>"
                      data-emirates_id="<?php echo e($customer->emirates_id); ?>"
                      data-nationality="<?php echo e($customer->nationality); ?>"
                      <?php echo e(old('sponsor_name') === $full ? 'selected' : ''); ?>>
                      <?php echo e($full); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="col-md-6">
                <label for="eid_no" class="form-label">QID No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  <input type="text" name="eid_no" id="eid_no" class="form-control" value="<?php echo e(old('eid_no')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="nationality" class="form-label">Nationality <span style="color:#dc3545">*</span></label>
                <select name="nationality" id="nationality" class="form-select select2-country" required>
                  <option value="">Select nationality</option>
                  <?php $__currentLoopData = $nationalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($nat); ?>" <?php echo e($selectedNationality === $nat ? 'selected' : ''); ?>><?php echo e($nat); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="col-md-6">
                <label for="CL_nationality" class="form-label">CL Nationality</label>
                <select name="CL_nationality" id="CL_nationality" class="form-select select2-country">
                  <option value="">Select country</option>
                  <?php $__currentLoopData = $allCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($country->NAME); ?>" <?php echo e(old('CL_nationality') == $country->NAME ? 'selected' : ''); ?>><?php echo e($country->NAME); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="col-md-6">
                <label for="wc_date" class="form-label">WC Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                  <input type="date" name="wc_date" id="wc_date" class="form-control" value="<?php echo e(old('wc_date')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="visa_date" class="form-label">Visa Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="visa_date" id="visa_date" class="form-control" value="<?php echo e(old('visa_date')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="incident_type" class="form-label">Incident Type</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                  <input type="text" name="incident_type" id="incident_type" class="form-control" value="<?php echo e(old('incident_type')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="incident_date" class="form-label">Incident Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="incident_date" id="incident_date" class="form-control" value="<?php echo e(old('incident_date')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="arrived_date" class="form-label">Arrived Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-plane-arrival"></i></span>
                  <input type="date" name="arrived_date" id="arrived_date" class="form-control" value="<?php echo e(old('arrived_date')); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label for="package" class="form-label">Package</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-box"></i></span>
                  <input type="text" name="package" id="package" class="form-control" value="<?php echo e(old('package','Package 1')); ?>" readonly>
                </div>
              </div>

              <div class="col-md-6">
                <?php $selectedSalesComm = old('sales_comm_status','') ?>
                <label for="sales_comm_status" class="form-label">Sales Commission Status</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-percent"></i></span>
                  <select name="sales_comm_status" id="sales_comm_status" class="form-select">
                    <option value="" disabled <?php echo e($selectedSalesComm === '' ? 'selected' : ''); ?>>Select status…</option>
                    <option value="Paid"   <?php echo e($selectedSalesComm === 'Paid' ? 'selected' : ''); ?>>Paid</option>
                    <option value="Unpaid" <?php echo e($selectedSalesComm === 'Unpaid' ? 'selected' : ''); ?>>Unpaid</option>
                  </select>
                </div>
              </div>

              <div class="col-md-12">
                <label for="remark" class="form-label">Remark</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-comment"></i></span>
                  <textarea name="remark" id="remark" class="form-control" rows="3"><?php echo e(old('remark')); ?></textarea>
                </div>
              </div>

              <div class="col-12">
                <div class="attachments-card p-3">
                  <div class="attachments-title">Attachments</div>
                  <div class="attachments-banner mb-3">
                    <i class="fas fa-paperclip"></i>
                    <span>Upload important documents for the candidate's profile.</span>
                  </div>
                  <div class="table-responsive">
                    <table class="table align-middle mb-0" id="attachmentsTable">
                      <thead>
                        <tr>
                          <th style="min-width:220px">Type</th>
                          <th style="min-width:200px">Document Number</th>
                          <th style="min-width:160px">Issued On</th>
                          <th style="min-width:160px">Expired On</th>
                          <th style="min-width:220px">File</th>
                          <th style="width:80px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $docIndex = 0; ?>
                        <tr class="doc-row">
                          <td>
                            <select name="documents[<?php echo e($docIndex); ?>][type]" class="form-select select2-doc-type doc-type">
                              <option value="">Select Document Type...</option>
                              <?php $__currentLoopData = $documentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dt); ?>"><?php echo e($dt); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </td>
                          <td><input type="text" name="documents[<?php echo e($docIndex); ?>][document_no]" class="form-control doc-number" placeholder="Document Number"></td>
                          <td><input type="date" name="documents[<?php echo e($docIndex); ?>][issued_at]" class="form-control doc-issued" placeholder="Issued On"></td>
                          <td><input type="date" name="documents[<?php echo e($docIndex); ?>][expires_at]" class="form-control doc-expiry" placeholder="Expired On"></td>
                          <td><input type="file" name="documents[<?php echo e($docIndex); ?>][file]" class="form-control doc-file" accept=".pdf,.jpg,.jpeg,.png"></td>
                          <td class="text-center">
                            <button type="button" class="btn btn-add btn-sm add-doc-row"><i class="fas fa-plus"></i></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary" id="submitButtonCreate"><i class="fas fa-save"></i> Submit</button>
              </div>
            </form>
          </div> 
        </div>
      </div>
    </div>
  </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function(){
  $('.select2-country').select2({theme:'bootstrap-5',width:'100%',placeholder:'Select country',allowClear:true});
  $('.select2-sponsor').select2({theme:'bootstrap-5',width:'100%',placeholder:'Select sponsor',allowClear:true});
  $('.select2-visa').select2({theme:'bootstrap-5',width:'100%',placeholder:'Select visa type',allowClear:true});
  $('.select2-doc-type').select2({theme:'bootstrap-5',width:'100%',placeholder:'Select Document Type...',allowClear:true});

  $('#sponsor_name').on('change', function(){
    var opt=$(this).find(':selected');
    var qid=opt.data('emirates_id')||'';
    var nat=opt.data('nationality')||'';
    if(qid){ $('#eid_no').val(qid); }
    if(nat){ $('#CL_nationality').val(nat).trigger('change'); }
  });

  function nextDocIndex(){
    var max=-1;
    $('#attachmentsTable tbody tr.doc-row').each(function(){
      var n=$(this).find('select.doc-type').attr('name')||'';
      var m=n.match(/documents\[(\d+)\]/);
      if(m){ var i=parseInt(m[1]); if(i>max) max=i; }
    });
    return max+1;
  }

  function rowReady($row){
    var t=$row.find('.doc-type').val();
    var f=$row.find('.doc-file').val();
    return t && f;
  }

  function newRow(idx){
    var opts=$('#attachmentsTable tbody tr.doc-row').first().find('select.doc-type option').map(function(){ return '<option value="'+$(this).attr('value')+'">'+$(this).text()+'</option>'; }).get().join('');
    var html='';
    html+='<tr class="doc-row">';
    html+='<td><select name="documents['+idx+'][type]" class="form-select select2-doc-type doc-type">'+opts+'</select></td>';
    html+='<td><input type="text" name="documents['+idx+'][document_no]" class="form-control doc-number" placeholder="Document Number"></td>';
    html+='<td><input type="date" name="documents['+idx+'][issued_at]" class="form-control doc-issued" placeholder="Issued On"></td>';
    html+='<td><input type="date" name="documents['+idx+'][expires_at]" class="form-control doc-expiry" placeholder="Expired On"></td>';
    html+='<td><input type="file" name="documents['+idx+'][file]" class="form-control doc-file" accept=".pdf,.jpg,.jpeg,.png"></td>';
    html+='<td class="text-center"><button type="button" class="btn btn-add btn-sm add-doc-row"><i class="fas fa-plus"></i></button></td>';
    html+='</tr>';
    return html;
  }

  $(document).on('click','.add-doc-row',function(){
    var $row=$(this).closest('tr');
    if(!rowReady($row)){ alert('Please select Type and choose a File for this row before adding another.'); return; }
    var idx=nextDocIndex();
    $('#attachmentsTable tbody').append(newRow(idx));
    $('#attachmentsTable tbody tr.doc-row:last .select2-doc-type').select2({theme:'bootstrap-5',width:'100%',placeholder:'Select Document Type...',allowClear:true});
  });

  $('#packageFormCreate').on('submit', function(e){
    var hasPassport=false;
    $('#attachmentsTable tbody tr.doc-row').each(function(){
      var type=$(this).find('.doc-type').val();
      var f=$(this).find('.doc-file').val();
      if(type==='Passport Copy' && f){ hasPassport=true; }
    });
    if(!hasPassport){
      e.preventDefault();
      alert('Please upload a Passport Copy in Attachments before submitting.');
      $('html, body').animate({ scrollTop: $('.attachments-card').offset().top-80 }, 300);
    }
  });
});
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/package/create.blade.php ENDPATH**/ ?>