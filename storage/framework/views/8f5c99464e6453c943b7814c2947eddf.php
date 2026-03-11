<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<style>
 body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
 .nav-tabs .nav-link{transition:background .2s;color:#495057;font-size:12px;text-transform:uppercase}
 .nav-tabs .nav-link:hover{background:#f8f9fa}
 .nav-tabs .nav-link.active{background:#007bff;color:#fff}
 .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:normal}
 .pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}
 .muted-text{color:#6c757d;font-size:12px}
 .pagination{display:flex;justify-content:center;align-items:center;margin:0}
 .pagination .page-item{margin:0 .1rem}
 .pagination .page-link{border-radius:.25rem;padding:.5rem .75rem;color:#007bff;background:#fff;border:1px solid #007bff;transition:background .2s,color .2s}
 .pagination .page-link:hover{background:#007bff;color:#fff}
 .pagination .page-item.active .page-link{background:#007bff;color:#fff;border:1px solid #007bff}
 .pagination .page-item.disabled .page-link{color:#6c757d;background:#fff;border:1px solid #6c757d;cursor:not-allowed}
 .table-container{width:100%;overflow-x:auto;position:relative}
 .table{width:100%;border-collapse:collapse;margin-bottom:20px}
 .table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
 .table th{background:#343a40;color:#fff;text-transform:uppercase;font-weight:bold}
 .table-hover tbody tr:hover{background:#f1f1f1}
 .table-striped tbody tr:nth-of-type(odd){background:#f9f9f9}
 .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
 .btn-danger{background:#dc3545}
 .custom-modal .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3);font-size:12px;background:#fff}
 .custom-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0}
 .custom-modal .modal-body{padding:20px;color:#333;background:#f9f9f9}
 .custom-modal .modal-footer{padding:15px;border-top:1px solid #ddd;border-radius:0 0 12px 12px;background:#f1f1f1}
</style>

<div class="table-container">
 <table class="table table-bordered table-striped table-hover">
  <thead class="table-primary">
   <tr>
    <th>Serial</th><th>Reference No</th><th>Employee Name</th><th>Passport No</th><th>Contract Duration</th><th>Start Date</th><th>End Date</th><th>Package</th><th>Contract Amount</th><th># Installments</th><th>Paid Installments</th><th>Created At</th><th>Action</th>
   </tr>
  </thead>
  <tbody>
   <?php $__empty_1 = true; $__currentLoopData = $installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$inst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
   <tr>
    <td><?php echo e($i+$installments->firstItem()); ?></td>
    <td><?php echo e($inst->reference_no); ?></td>
    <td><?php echo e($inst->employee_name); ?></td>
    <td><?php echo e($inst->passport_no); ?></td>
    <td><?php echo e($inst->contract_duration); ?></td>
    <td><?php echo e($inst->contract_start_date); ?></td>
    <td><?php echo e($inst->contract_end_date); ?></td>
    <td><?php echo e($inst->package); ?></td>
    <td><?php echo e(number_format($inst->contract_amount,2)); ?></td>
    <td><?php echo e($inst->number_of_installments); ?></td>
    <td><?php echo e($inst->paid_installments); ?></td>
    <td><?php echo e($inst->created_at->format('Y-m-d')); ?></td>
    <td>
     <button class="btn btn-sm btn-primary view-items-btn"
             data-items='<?php echo json_encode($inst->items, 15, 512) ?>'
             data-reference="<?php echo e($inst->reference_no); ?>">
      <i class="fas fa-eye"></i> View
     </button>
    </td>
   </tr>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
   <tr><td colspan="13">No payment found.</td></tr>
   <?php endif; ?>
  </tbody>
 </table>

 <nav aria-label="Page navigation">
  <div class="pagination-container">
   <span class="muted-text">Showing <?php echo e($installments->firstItem()); ?> to <?php echo e($installments->lastItem()); ?> of <?php echo e($installments->total()); ?> results</span>
   <ul class="pagination justify-content-center"><?php echo e($installments->links('vendor.pagination.bootstrap-4')); ?></ul>
  </div>
 </nav>
</div>

<div class="modal custom-modal fade" id="itemsModal" tabindex="-1">
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title">Payment Tracker - <span id="installmentReference"></span></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
   </div>
   <div class="modal-body">
    <div class="table-responsive">
     <table class="table table-bordered" id="itemsTable">
      <thead class="table-secondary">
       <tr><th>#</th><th>Particular</th><th>Amount</th><th>Payment Date</th><th>Paid Date</th><th>Status</th><th>Action</th></tr>
      </thead>
      <tbody></tbody>
     </table>
    </div>
   </div>
   <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
  </div>
 </div>
</div>

<script>
const csrf=document.querySelector('meta[name="csrf-token"]').content;

function fmt(d){return d?new Date(d).toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'}):'N/A'}

$(document).on('click','.view-items-btn',function(){
 const items=$(this).data('items')||[],ref=$(this).data('reference');
 $('#installmentReference').text(ref);
 const tb=$('#itemsTable tbody');tb.empty();
 if(!items.length){tb.append('<tr><td colspan="7">No Payment Tracker found.</td></tr>');$('#itemsModal').modal('show');return}
 $.each(items,(i,it)=>{
  const genBtn=`<button class="btn btn-sm btn-success generate-invoice-btn"
                       data-id="${it.id}"
                       data-installment="${it.installment_id}"
                       data-amount="${it.amount}"><i class="fas fa-file-invoice-dollar"></i> Generate Invoice</button>`;
  const viewBtn=`<button class="btn btn-sm btn-info view-invoice-btn"
                        data-invoice="${it.invoice_number}"><i class="fas fa-eye"></i> View Invoice</button>`;
  const btn=it.invoice_generated?viewBtn:genBtn;
  tb.append(`<tr>
   <td>${i+1}</td><td>${it.particular}</td><td>${parseFloat(it.amount).toFixed(2)}</td>
   <td>${fmt(it.payment_date)}</td><td>${fmt(it.paid_date)}</td><td>${it.status||'N/A'}</td><td>${btn}</td>
  </tr>`);
 });
 $('#itemsModal').modal('show');
});

$(document).on('click','.generate-invoice-btn',function(){
 const b=$(this);b.prop('disabled',true);
 $.ajax({
  url:"<?php echo e(route('installments.generate-invoice')); ?>",
  type:'POST',
  headers:{'X-CSRF-TOKEN':csrf},
  data:{
   id:b.data('id'),
   installment_id:b.data('installment'),
   amount:b.data('amount')
  },
  success:r=>{
   if(r.status==='success'){
    toastr.success('The invoice has generated successfully.');
    b.replaceWith(`<button class="btn btn-sm btn-info view-invoice-btn" data-invoice="${r.invoice_number}"><i class="fas fa-eye"></i> View Invoice</button>`);
   }else{
    toastr.error(r.message||'Error');
    b.prop('disabled',false);
   }
  },
  error:x=>{
   const m=x.responseJSON?.message||'Server error';
   toastr.error(m);
   b.prop('disabled',false);
  }
 });
});

$(document).on('click','.view-invoice-btn',function(){
 window.open('/invoices/'+$(this).data('invoice'),'_blank');
});
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/partials/payment_tracker_table.blade.php ENDPATH**/ ?>