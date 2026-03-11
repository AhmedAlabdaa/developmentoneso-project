<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

<style>
  body{background:linear-gradient(to right,#c9d6ff,#e2e2e2);font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif}
  .card{border-radius:10px;background:linear-gradient(to right,#fff,#f2f2f2);box-shadow:0 4px 8px rgba(0,0,0,.1)}
  .table thead th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center}
  .table tbody td{vertical-align:middle}
  .btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);border:none}
  .btn-success{background:linear-gradient(to right,#28a745,#85e085);border:none;color:#fff}
  .btn-danger{background:linear-gradient(to right,#dc3545,#ff6666);border:none;color:#fff}
  .form-label{font-weight:500}
  .select2-selection__clear{display:none!important}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card flex-fill">
          <div class="card-body" style="margin-top:10px">
            <h4 class="card-title mb-3" style="font-weight:600;color:#333">
              <i class="fas fa-pen-to-square me-2"></i> Edit Invoice
            </h4>

            <?php if($errors->any()): ?>
              <div class="alert alert-danger">
                <ul class="mb-0">
                  <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
            <?php endif; ?>

            <form action="<?php echo e(route('govt-transactions.update', $invoice->invoice_number)); ?>" method="POST" enctype="multipart/form-data" class="row g-3">
              <?php echo csrf_field(); ?>
              <?php echo method_field('PUT'); ?>

              <div class="col-md-4">
                <label class="form-label">MOHRE Ref <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  <input type="text" name="mohre_ref" class="form-control" value="<?php echo e(old('mohre_ref', $invoice->mohre_ref)); ?>" required>
                </div>
              </div>

              <div class="col-md-4">
                <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" class="form-control" value="<?php echo e(\Carbon\Carbon::parse(old('invoice_date', $invoice->invoice_date))->format('d M Y')); ?>" readonly>
                  <input type="hidden" name="invoice_date" value="<?php echo e(old('invoice_date', $invoice->invoice_date)); ?>">
                </div>
              </div>

              <div class="col-md-4">
                <label class="form-label">Customer Type <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                  <select name="customer_type" id="customer_type" class="form-select" required>
                    <option value="Indoor" <?php echo e(old('customer_type', $invoice->customer_type)=='Indoor'?'selected':''); ?>>Indoor Customer</option>
                    <option value="Walking" <?php echo e(old('customer_type', $invoice->customer_type)=='Walking'?'selected':''); ?>>Walking Customer</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <label class="form-label">Select Customer <span class="text-danger">*</span></label>
                <select name="customer_id" id="customer_id" class="form-select" required>
                  <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($customer->id); ?>" <?php echo e((string)old('customer_id', $invoice->customer_id)===(string)$customer->id?'selected':''); ?>>
                      <?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?> – <?php echo e($customer->CL_Number ?? 'N/A'); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="col-md-4" id="candidateCol">
                <label class="form-label">Select Candidate</label>
                <select name="candidate_id" id="candidate_id" class="form-select">
                  <option value="">Select Candidate</option>
                  <?php $__currentLoopData = $candidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($candidate->id); ?>" <?php echo e((string)old('candidate_id', $invoice->candidate_id)===(string)$candidate->id?'selected':''); ?>>
                      <?php echo e($candidate->candidate_name); ?> – <?php echo e($candidate->CN_Number ?? 'N/A'); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label">Invoice Items <span class="text-danger">*</span></label>
                <table class="table table-bordered table-hover" id="invoiceItemsTable">
                  <thead>
                    <tr>
                      <th style="width:22%">Service</th>
                      <th style="width:13%">DW Number</th>
                      <th style="width:10%">Quantity</th>
                      <th style="width:12%">Rate</th>
                      <th style="width:10%">Tax (%)</th>
                      <th style="width:13%">Center Fee</th>
                      <th style="width:10%">VAT</th>
                      <th style="width:10%">Line Total</th>
                      <th style="width:10%">Action</th>
                    </tr>
                  </thead>
                  <tbody id="invoiceItemsBody">
                    <?php if(old('service_name')): ?>
                      <?php for($i=0;$i<count(old('service_name',[]));$i++): ?>
                        <tr>
                          <td>
                            <select name="service_name[]" class="form-select service-select" required>
                              <option value="" disabled>Select Service</option>
                              <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->service_name); ?>" <?php echo e(old('service_name.'.$i)==$service->service_name?'selected':''); ?>><?php echo e($service->service_name); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php if(old('service_name.'.$i) && collect($services)->pluck('service_name')->contains(old('service_name.'.$i))===false): ?>
                                <option value="<?php echo e(old('service_name.'.$i)); ?>" selected><?php echo e(old('service_name.'.$i)); ?></option>
                              <?php endif; ?>
                            </select>
                          </td>
                          <td><input type="text" name="dw_numbers[]" class="form-control dw-number" value="<?php echo e(old('dw_numbers.'.$i)); ?>"></td>
                          <td><input type="number" name="quantities[]" class="form-control quantity" step="1" min="1" value="<?php echo e(old('quantities.'.$i,1)); ?>" required></td>
                          <td><input type="number" name="rates[]" class="form-control rate" step="0.01" min="0" value="<?php echo e(old('rates.'.$i,0)); ?>" required></td>
                          <td><input type="number" name="taxes[]" class="form-control tax" step="0.01" min="0" value="<?php echo e(old('taxes.'.$i,5)); ?>"></td>
                          <td><input type="number" name="center_fees[]" class="form-control center-fee" step="0.01" min="0" value="<?php echo e(old('center_fees.'.$i,0)); ?>"></td>
                          <td><input type="text" class="form-control line-vat" value="0.00" readonly></td>
                          <td><input type="text" class="form-control line-total" value="0.00" readonly></td>
                          <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm removeRowBtn" <?php echo e($i===0?'disabled':''); ?>><i class="fas fa-trash"></i></button>
                          </td>
                        </tr>
                      <?php endfor; ?>
                    <?php else: ?>
                      <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx=>$it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td>
                            <select name="service_name[]" class="form-select service-select" required>
                              <option value="" disabled>Select Service</option>
                              <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->service_name); ?>" <?php echo e($it->service_name==$service->service_name?'selected':''); ?>><?php echo e($service->service_name); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php if($it->service_name && collect($services)->pluck('service_name')->contains($it->service_name)===false): ?>
                                <option value="<?php echo e($it->service_name); ?>" selected><?php echo e($it->service_name); ?></option>
                              <?php endif; ?>
                            </select>
                          </td>
                          <td><input type="text" name="dw_numbers[]" class="form-control dw-number" value="<?php echo e($it->dw_number); ?>"></td>
                          <td><input type="number" name="quantities[]" class="form-control quantity" step="1" min="1" value="<?php echo e($it->qty ?? 1); ?>" required></td>
                          <td><input type="number" name="rates[]" class="form-control rate" step="0.01" min="0" value="<?php echo e($it->amount ?? 0); ?>" required></td>
                          <td><input type="number" name="taxes[]" class="form-control tax" step="0.01" min="0" value="<?php echo e($it->tax ?? 0); ?>"></td>
                          <td><input type="number" name="center_fees[]" class="form-control center-fee" step="0.01" min="0" value="<?php echo e($it->center_fee ?? 0); ?>"></td>
                          <td><input type="text" class="form-control line-vat" value="0.00" readonly></td>
                          <td><input type="text" class="form-control line-total" value="0.00" readonly></td>
                          <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm removeRowBtn" <?php echo e($idx===0?'disabled':''); ?>><i class="fas fa-trash"></i></button>
                          </td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                  </tbody>
                </table>

                <button type="button" class="btn btn-success btn-sm" id="addRowBtn">
                  <i class="fas fa-plus"></i> Add More Items
                </button>
              </div>

              <div class="col-md-2">
                <label class="form-label">Subtotal</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                  <input type="text" id="subtotal" class="form-control" value="0.00" readonly>
                </div>
              </div>

              <div class="col-md-2">
                <label class="form-label">VAT Total</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-percent"></i></span>
                  <input type="text" id="total_vat" class="form-control" value="0.00" readonly>
                </div>
              </div>

              <div class="col-md-2">
                <label class="form-label">Center Fee Total</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-building"></i></span>
                  <input type="text" id="total_center_fee" class="form-control" value="0.00" readonly>
                </div>
              </div>

              <div class="col-md-2">
                <label class="form-label">Discount</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-tag"></i></span>
                  <input type="number" step="0.01" min="0" id="discount_amount" name="discount_amount" class="form-control" value="<?php echo e(old('discount_amount', $invoice->discount_amount ?? 0)); ?>">
                </div>
              </div>

              <div class="col-md-2">
                <label class="form-label">Grand Total</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calculator"></i></span>
                  <input type="text" id="grand_total" class="form-control" value="0.00" readonly>
                </div>
              </div>

              <div class="col-md-2">
                <label class="form-label">Received Amount</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                  <input type="number" step="0.01" min="0" id="received_amount" name="received_amount" class="form-control" value="<?php echo e(old('received_amount', $invoice->received_amount ?? 0)); ?>">
                </div>
              </div>

              <div class="col-md-2">
                <label class="form-label">Remaining Amount</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hourglass-end"></i></span>
                  <input type="text" id="remaining_amount" class="form-control" value="0.00" readonly>
                </div>
              </div>

              <input type="hidden" name="currency" value="<?php echo e(old('currency', $invoice->currency ?? 'AED')); ?>">

              <div class="col-md-3">
                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                <select name="payment_mode" id="payment_mode" class="form-select" required>
                  <?php $pm = old('payment_mode', $invoice->payment_mode); ?>
                  <option value="Bank Transfer ADIB" <?php echo e($pm=='Bank Transfer ADIB'?'selected':''); ?>>Bank Transfer ADIB</option>
                  <option value="Bank Transfer ADCB" <?php echo e($pm=='Bank Transfer ADCB'?'selected':''); ?>>Bank Transfer ADCB</option>
                  <option value="POS-ID 60043758-ADIB" <?php echo e($pm=='POS-ID 60043758-ADIB'?'selected':''); ?>>POS-ID 60043758-ADIB</option>
                  <option value="POS-ID 60045161-ADCB" <?php echo e($pm=='POS-ID 60045161-ADCB'?'selected':''); ?>>POS-ID 60045161-ADCB</option>
                  <option value="ADIB-19114761" <?php echo e($pm=='ADIB-19114761'?'selected':''); ?>>ADIB-19114761</option>
                  <option value="ADIB-19136783" <?php echo e($pm=='ADIB-19136783'?'selected':''); ?>>ADIB-19136783</option>
                  <option value="Cash" <?php echo e($pm=='Cash'?'selected':''); ?>>Cash</option>
                  <option value="Cheque" <?php echo e($pm=='Cheque'?'selected':''); ?>>Cheque</option>
                  <option value="Replacement" <?php echo e($pm=='Replacement'?'selected':''); ?>>Replacement</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">Payment Reference</label>
                <input type="text" name="payment_reference" id="payment_reference" class="form-control" value="<?php echo e(old('payment_reference', $invoice->payment_reference)); ?>">
              </div>

              <div class="col-md-3">
                <label class="form-label">Due Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                  <input type="date" name="due_date" id="due_date" class="form-control" value="<?php echo e(old('due_date', $invoice->due_date)); ?>">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Payment Proof</label>
                <input type="file" name="payment_proof" id="payment_proof" class="form-control">
              </div>

              <div class="col-md-6">
                <label class="form-label">Payment Note</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                  <input type="text" name="payment_note" id="payment_note" class="form-control" value="<?php echo e(old('payment_note', $invoice->payment_note)); ?>">
                </div>
              </div>

              <div class="col-md-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="2"><?php echo e(old('notes', $invoice->notes)); ?></textarea>
              </div>

              <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Update Invoice
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  function n(v){v=parseFloat(v);return isNaN(v)?0:v}
  function f(v){return n(v).toFixed(2)}

  function updateServiceSelects(){
    var selected=[]
    $('.service-select').each(function(){var v=$(this).val();if(v)selected.push(v)})
    $('.service-select').each(function(){
      var cur=$(this).val()
      $(this).find('option').each(function(){
        var val=$(this).val()
        $(this).prop('disabled',val&&val!==cur&&selected.includes(val))
      })
    })
  }

  function updateRemoveButtons(){
    var rows=$('#invoiceItemsBody tr').length
    $('#invoiceItemsBody .removeRowBtn').prop('disabled',rows<=1)
    $('#invoiceItemsBody .removeRowBtn:first').prop('disabled',rows<=1)
  }

  function isLastRowFilled(){
    var $r=$('#invoiceItemsBody tr:last')
    return $r.find('.service-select').val() && $.trim($r.find('.quantity').val()||'') && $.trim($r.find('.rate').val()||'')
  }

  function calcRow($row){
    var qty=n($row.find('.quantity').val())
    var rate=n($row.find('.rate').val())
    var tax=n($row.find('.tax').val())
    var center=n($row.find('.center-fee').val())

    var base=qty*rate
    var vat=base*(tax/100)
    var total=base+vat+center

    $row.data('base',base).data('vat',vat).data('center',center).data('total',total)

    $row.find('.line-vat').val(f(vat))
    $row.find('.line-total').val(f(total))
  }

  function calcTotals(){
    var subtotal=0, vatTotal=0, centerTotal=0
    $('#invoiceItemsBody tr').each(function(){
      subtotal+=n($(this).data('base'))
      vatTotal+=n($(this).data('vat'))
      centerTotal+=n($(this).data('center'))
    })

    var discount=n($('#discount_amount').val())
    if(discount<0)discount=0

    var grand=Math.max(subtotal+vatTotal+centerTotal-discount,0)

    $('#subtotal').val(f(subtotal))
    $('#total_vat').val(f(vatTotal))
    $('#total_center_fee').val(f(centerTotal))
    $('#grand_total').val(f(grand))

    var recv=n($('#received_amount').val())
    if(recv<0)recv=0
    $('#remaining_amount').val(f(Math.max(grand-recv,0)))
  }

  function toggleCandidate(){
    if($('#customer_type').val()==='Walking'){
      $('#candidateCol').hide()
      $('#candidate_id').prop('required',false).val('').trigger('change')
    }else{
      $('#candidateCol').show()
      $('#candidate_id').prop('required',true)
    }
  }

  function initServiceSelect($el){
    $el.select2({placeholder:'Select Service',tags:true,width:'100%'})
  }

  function initRow($row){
    calcRow($row)
  }

  $(function(){
    $('#customer_id,#candidate_id,#payment_mode').select2({placeholder:'Select',width:'100%'})
    $('.service-select').each(function(){initServiceSelect($(this))})

    toggleCandidate()
    $('#customer_type').on('change',toggleCandidate)

    $('#invoiceItemsBody tr').each(function(){initRow($(this))})
    calcTotals()
    updateRemoveButtons()
    updateServiceSelects()

    $('#addRowBtn').on('click',function(){
      if(!isLastRowFilled())return
      var row=
        '<tr>'+
          '<td>'+
            '<select name="service_name[]" class="form-select service-select" required>'+
              '<option value="" disabled selected>Select Service</option>'+
              '<?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>'+
                '<option value="<?php echo e($service->service_name); ?>"><?php echo e($service->service_name); ?></option>'+
              '<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>'+
            '</select>'+
          '</td>'+
          '<td><input type="text" name="dw_numbers[]" class="form-control dw-number"></td>'+
          '<td><input type="number" name="quantities[]" class="form-control quantity" step="1" min="1" value="1" required></td>'+
          '<td><input type="number" name="rates[]" class="form-control rate" step="0.01" min="0" value="0" required></td>'+
          '<td><input type="number" name="taxes[]" class="form-control tax" step="0.01" min="0" value="0"></td>'+
          '<td><input type="number" name="center_fees[]" class="form-control center-fee" step="0.01" min="0" value="0"></td>'+
          '<td><input type="text" class="form-control line-vat" value="0.00" readonly></td>'+
          '<td><input type="text" class="form-control line-total" value="0.00" readonly></td>'+
          '<td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRowBtn"><i class="fas fa-trash"></i></button></td>'+
        '</tr>'

      $('#invoiceItemsBody').append(row)
      initServiceSelect($('#invoiceItemsBody tr:last .service-select'))
      updateServiceSelects()
      updateRemoveButtons()
      initRow($('#invoiceItemsBody tr:last'))
      calcTotals()
    })

    $(document).on('click','.removeRowBtn',function(){
      $(this).closest('tr').remove()
      $('#invoiceItemsBody tr').each(function(){initRow($(this))})
      calcTotals()
      updateServiceSelects()
      updateRemoveButtons()
    })

    $(document).on('input change','.quantity,.rate,.tax,.center-fee',function(){
      var $row=$(this).closest('tr')
      calcRow($row)
      calcTotals()
    })

    $(document).on('change','.service-select',function(){
      updateServiceSelects()
    })

    $('#received_amount,#discount_amount').on('input',function(){
      calcTotals()
    })
  })
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/govt_transactions/edit.blade.php ENDPATH**/ ?>