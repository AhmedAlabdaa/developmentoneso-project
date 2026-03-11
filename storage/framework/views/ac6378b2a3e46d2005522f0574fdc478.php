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
  .center-split{font-size:.8rem;color:#6c757d;margin-top:4px}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card flex-fill">
          <div class="card-body" style="margin-top:10px">
            <h4 class="card-title mb-3" style="font-weight:600;color:#333">
              <i class="fas fa-file-invoice-dollar me-2"></i> Create Invoice
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

            <form action="<?php echo e(route('govt-transactions.store')); ?>" method="POST" enctype="multipart/form-data" class="row g-3">
              <?php echo csrf_field(); ?>

              <div class="col-md-4">
                <label class="form-label">MOHRE Ref <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  <input type="text" name="mohre_ref" class="form-control" required>
                </div>
              </div>

              <div class="col-md-4">
                <label class="form-label">Invoice Date <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="text" class="form-control" value="<?php echo e(\Carbon\Carbon::now('Asia/Dubai')->format('d M Y')); ?>" readonly>
                  <input type="hidden" name="invoice_date" value="<?php echo e(\Carbon\Carbon::now('Asia/Dubai')->format('Y-m-d')); ?>">
                </div>
              </div>

              <div class="col-md-4">
                <label class="form-label">Customer Type <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                  <select name="customer_type" id="customer_type" class="form-select" required>
                    <option value="" disabled selected>Select Type</option>
                    <option value="Indoor" <?php echo e(old('customer_type')=='Indoor'?'selected':''); ?>>Indoor Customer</option>
                    <option value="Walking" <?php echo e(old('customer_type')=='Walking'?'selected':''); ?>>Walking Customer</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <label class="form-label">Select Customer <span class="text-danger">*</span></label>
                <select name="customer_id" id="customer_id" class="form-select" required>
                  <option value="" disabled selected>Select Customer</option>
                  <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($customer->id); ?>" <?php echo e(old('customer_id')==$customer->id?'selected':''); ?>>
                      <?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?> – <?php echo e($customer->CL_Number ?? 'N/A'); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="col-md-4" id="candidateCol">
                <label class="form-label">Select Candidate</label>
                <select name="candidate_id" id="candidate_id" class="form-select">
                  <!-- <option value="" disabled selected>Select Candidate</option>
                  <?php $__currentLoopData = $candidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($candidate->id); ?>" <?php echo e(old('candidate_id')==$candidate->id?'selected':''); ?>>
                      <?php echo e($candidate->candidate_name); ?> – <?php echo e($candidate->CN_Number ?? 'N/A'); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->

                  <option value="1">Select Candidate</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label">Invoice Items <span class="text-danger">*</span></label>
                <table class="table table-bordered table-hover" id="invoiceItemsTable">
                  <thead>
                    <tr>
                      <th style="width:22%">Service</th>
                      <th style="width:13%">DW Number</th>
                      <th style="width:11%">Quantity</th>
                      <th style="width:11%">Rate</th>
                      <th style="width:11%">Tax (%)</th>
                      <th style="width:11%">Center Fee (Incl. VAT)</th>
                      <th style="width:11%">Line Total</th>
                      <th style="width:10%">Action</th>
                    </tr>
                  </thead>
                  <tbody id="invoiceItemsBody">
                    <tr>
                      <td>
                        <select name="service_name[]" class="form-select service-select" required>
                          <option value="" disabled selected>Select Service</option>
                          <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($service->service_name); ?>"><?php echo e($service->service_name); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </td>
                      <td>
                        <input type="text" name="dw_numbers[]" class="form-control dw-number" placeholder="DW Number">
                      </td>
                      <td>
                        <input type="number" name="quantities[]" class="form-control quantity" step="1" min="1" value="1" required>
                      </td>
                      <td>
                        <input type="number" name="rates[]" class="form-control rate" step="0.01" min="0" value="0" required>
                      </td>
                      <td>
                        <input type="number" name="taxes[]" class="form-control tax" step="0.01" min="0" value="5">
                      </td>
                      <td>
                        <input type="number" name="center_fees[]" class="form-control center-fee" step="0.01" min="0" value="0">
                        <div class="center-split">Base: 0.00 | VAT: 0.00</div>
                      </td>
                      <td>
                        <input type="text" class="form-control line-total" value="0.00" readonly>
                      </td>
                      <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm removeRowBtn" disabled>
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
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
                <label class="form-label">Discount</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-tag"></i></span>
                  <input type="number" step="0.01" min="0" id="discount_amount" name="discount_amount" class="form-control" value="0.00">
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
                  <input type="number" step="0.01" min="0" id="received_amount" name="received_amount" class="form-control" value="0.00">
                </div>
              </div>

              <div class="col-md-2">
                <label class="form-label">Remaining Amount</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hourglass-end"></i></span>
                  <input type="text" id="remaining_amount" class="form-control" value="0.00" readonly>
                </div>
              </div>

              <input type="hidden" name="currency" value="AED">

              <div class="col-md-3">
                <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                <select name="payment_mode" id="payment_mode" class="form-select" required>
                  <option value="" disabled selected>Select Method</option>
                  <option value="Bank Transfer ADIB">Bank Transfer ADIB</option>
                  <option value="Bank Transfer ADCB">Bank Transfer ADCB</option>
                  <option value="POS-ID 60043758-ADIB">POS-ID 60043758-ADIB</option>
                  <option value="POS-ID 60045161-ADCB">POS-ID 60045161-ADCB</option>
                  <option value="ADIB-19114761">ADIB-19114761</option>
                  <option value="ADIB-19136783">ADIB-19136783</option>
                  <option value="Cash">Cash</option>
                  <option value="Cheque">Cheque</option>
                  <option value="Replacement">Replacement</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">Payment Reference</label>
                <input type="text" name="payment_reference" id="payment_reference" class="form-control" placeholder="e.g. Bank Txn ID / Cheque #">
              </div>

              <div class="col-md-3">
                <label class="form-label">Due Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                  <input type="date" name="due_date" id="due_date" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Payment Proof <span class="text-danger">*</span></label>
                <input type="file" name="payment_proof" id="payment_proof" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Payment Note</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                  <input type="text" name="payment_note" id="payment_note" class="form-control" placeholder="Optional note about this payment">
                </div>
              </div>

              <div class="col-md-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Internal or public notes"></textarea>
              </div>

              <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Create Invoice
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
  function updateServiceSelects(){
    var selected=[];
    $('.service-select').each(function(){var v=$(this).val();if(v)selected.push(v)});
    $('.service-select').each(function(){
      var cur=$(this).val();
      $(this).find('option').each(function(){
        var val=$(this).val();
        $(this).prop('disabled',val&&val!==cur&&selected.includes(val));
      });
    });
  }
  function updateRemoveButtons(){
    var rows=$('#invoiceItemsBody tr').length;
    $('#invoiceItemsBody .removeRowBtn').prop('disabled',rows<=1);
  }
  function isLastRowFilled(){
    var $r=$('#invoiceItemsBody tr:last');
    return $r.find('select').val()&&($r.find('.quantity').val()||'').trim()&&($r.find('.rate').val()||'').trim();
  }
  function splitVatInclusive(amount,taxPct){
    var t=parseFloat(taxPct)||0;
    var a=parseFloat(amount)||0;
    if(t<=0)return{base:a,vat:0,total:a};
    var base=a/(1+t/100);
    var vat=a-base;
    return{base:base,vat:vat,total:a};
  }
  function calculateLineTotal($row){
    var qty=parseFloat($row.find('.quantity').val())||0;
    var rate=parseFloat($row.find('.rate').val())||0;
    var taxPct=parseFloat($row.find('.tax').val())||0;
    var centerIncl=parseFloat($row.find('.center-fee').val())||0;
    var baseItem=qty*rate;
    var centerSplit=splitVatInclusive(centerIncl,taxPct);
    var total=baseItem+centerSplit.total;
    $row.data('baseItem',baseItem).data('centerBase',centerSplit.base).data('centerVat',centerSplit.vat).data('centerTotal',centerSplit.total);
    $row.find('.line-total').val(total.toFixed(2));
    $row.find('.center-split').text('Base: '+centerSplit.base.toFixed(2)+' | VAT: '+centerSplit.vat.toFixed(2));
  }
  function calculateTotals(){
    var sub=0,vat=0;
    $('#invoiceItemsBody tr').each(function(){
      sub+=(parseFloat($(this).data('baseItem'))||0)+(parseFloat($(this).data('centerBase'))||0);
      vat+=parseFloat($(this).data('centerVat'))||0;
    });
    var discount=parseFloat($('#discount_amount').val())||0;
    if(discount<0)discount=0;
    var gross=sub+vat;
    var grand=Math.max(gross-discount,0);
    $('#subtotal').val(sub.toFixed(2));
    $('#total_vat').val(vat.toFixed(2));
    $('#grand_total').val(grand.toFixed(2));
    var recv=parseFloat($('#received_amount').val())||0;
    if(recv<0)recv=0;
    $('#remaining_amount').val(Math.max(grand-recv,0).toFixed(2));
  }
  function toggleCandidate(){
    if($('#customer_type').val()==='Walking'){
      $('#candidateCol').hide();$('#candidate_id').prop('required',false);
    }else{
      $('#candidateCol').show();$('#candidate_id').prop('required',true);
    }
  }
  function initRow($row){
    $row.find('.center-split').text('Base: 0.00 | VAT: 0.00');
    calculateLineTotal($row);
  }
  $(function(){
    $('#customer_id,#candidate_id,#payment_mode').select2({placeholder:'Select',width:'100%'});
    $('.service-select').select2({placeholder:'Select Service',tags:true,width:'100%'});
    toggleCandidate();
    $('#customer_type').on('change',toggleCandidate);
    $('#addRowBtn').on('click',function(){
      if(!isLastRowFilled())return;
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
          '<td><input type="text" name="dw_numbers[]" class="form-control dw-number" placeholder="DW Number"></td>'+
          '<td><input type="number" name="quantities[]" class="form-control quantity" step="1" min="1" value="1" required></td>'+
          '<td><input type="number" name="rates[]" class="form-control rate" step="0.01" min="0" value="0" required></td>'+
          '<td><input type="number" name="taxes[]" class="form-control tax" step="0.01" min="0" value="5"></td>'+
          '<td><input type="number" name="center_fees[]" class="form-control center-fee" step="0.01" min="0" value="0"><div class="center-split">Base: 0.00 | VAT: 0.00</div></td>'+
          '<td><input type="text" class="form-control line-total" value="0.00" readonly></td>'+
          '<td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRowBtn"><i class="fas fa-trash"></i></button></td>'+
        '</tr>';
      $('#invoiceItemsBody').append(row);
      $('.service-select').select2({placeholder:'Select Service',tags:true,width:'100%'});
      updateServiceSelects();updateRemoveButtons();
      initRow($('#invoiceItemsBody tr:last'));
      calculateTotals();
    });
    $(document).on('click','.removeRowBtn',function(){
      $(this).closest('tr').remove();calculateTotals();updateServiceSelects();updateRemoveButtons();
    });
    $(document).on('input change','.quantity,.rate,.tax,.center-fee',function(){
      var $row=$(this).closest('tr');calculateLineTotal($row);calculateTotals();
    });
    $(document).on('change','.service-select',function(){
      var $row=$(this).closest('tr');calculateLineTotal($row);calculateTotals();updateServiceSelects();
    });
    $('#received_amount,#discount_amount').on('input',calculateTotals);
    $('#invoiceItemsBody tr').each(function(){initRow($(this))});
    calculateTotals();updateRemoveButtons();updateServiceSelects();
  });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/govt_transactions/create.blade.php ENDPATH**/ ?>