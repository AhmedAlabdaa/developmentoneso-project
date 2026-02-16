<?php use Carbon\Carbon; ?>
<style>
.table-container { width: 100%; overflow-x: auto; position: relative; }
.table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
.table th, .table td { padding: 10px 15px; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.table th { background-color: #343a40; color: white; text-transform: uppercase; font-weight: bold; }
.table-hover tbody tr:hover { background-color: #f1f1f1; }
.table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
.actions { display: flex; gap: 5px; }
.btn-icon-only { display: inline-flex; align-items: center; justify-content: center; padding: 5px; border-radius: 50%; font-size: 12px; width: 30px; height: 30px; color: white; }
.btn-info { background-color: #17a2b8; }
.btn-danger { background-color: #dc3545; }
.sticky-table th:last-child,
.sticky-table td:last-child {
    position: sticky;
    right: 0;
    background-color: white;
    z-index: 2;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
    min-width: 150px;
}
.modal .table th:last-child,
.modal .table td:last-child {
    position: static;
}
.table th:last-child { z-index: 3; }
.status-dropdown {
    padding: 5px;
    font-size: 12px;
    border-radius: 5px;
    width: 120px;
    color: #000;
    font-weight: bold;
    text-transform: uppercase;
}
.status-dropdown.pending  { background-color: #ffc107; }
.status-dropdown.unpaid   { background-color: #ffc107; }
.status-dropdown.paid     { background-color: #28a745; }
.status-dropdown.partially-paid { background-color: #ffc107; }
.status-dropdown.overdue  { background-color: #dc3545; }
.status-dropdown.cancelled { background-color: #dc3545; }
.status-dropdown.hold     { background-color: #ffc107; }
.status-dropdown.cod      { background-color: #17a2b8; }
.img-thumbnail {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
}
.bg-gradient-primary {
   background: linear-gradient(to right, #007bff, #6a11cb);
}
.btn-sm { font-size: 0.8rem; }
.scrollable-modal-body {
    max-height: 500px;
    overflow-y: auto;
}
</style>

<div class="table-container sticky-table">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Ref #</th>
                <th>Contract Ref #</th>
                <th>Sales Name</th>
                <th>Date</th>
                <th>CL #</th>
                <th>CN #</th>
                <th>Customer Name</th>
                <th>Maid Name</th>
                <th>Status</th>
                <th>Approved Date</th>
                <th>Total Amount</th>
                <th>Received Amount</th>
                <th>Discount</th>
                <th>Tax</th>
                <th>Payment Method</th>
                <th>Date</th>
                <th>Due Date</th>
                <th>Upcoming Payment</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($invoices->isEmpty()): ?>
                <tr>
                    <td colspan="19" class="text-center">
                        <h5 style="margin:50px 0;">There are no records available</h5>
                    </td>
                </tr>
            <?php else: ?>
                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $statusClass = strtolower(str_replace(' ', '-', $invoice->status)); ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('invoices.show', $invoice->invoice_number)); ?>" class="text-primary" target="_blank">
                                <?php echo e($invoice->invoice_number); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('contracts.show', $invoice->contract_ref_no ?? '')); ?>" class="text-primary" target="_blank">
                                <?php echo e($invoice->contract_ref_no ?? ''); ?>

                            </a>
                        </td>
                        <td title="<?php echo e($invoice->creator?->first_name ?? '—'); ?> <?php echo e($invoice->creator?->last_name ?? '—'); ?>"><?php echo e($invoice->creator?->first_name ?? '—'); ?></td>
                        <td><?php echo e(Carbon::parse($invoice->invoice_date)->format('d M Y')); ?></td>
                        <td>
                            <a href="<?php echo e(route('crm.show', $invoice->customer->slug ?? '')); ?>" class="text-primary" target="_blank">
                                <?php echo e($invoice->CL_Number); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('employees.show', $invoice->CN_Number ?? '')); ?>" class="text-primary" target="_blank">
                                <?php echo e($invoice->CN_Number); ?>

                            </a>
                        </td>
                        <td>
                            <?php $cust = optional($invoice->customer); ?>
                            <a href="<?php echo e($cust->slug ? route('crm.show', $cust->slug) : '#'); ?>" class="text-primary" target="_blank">
                                <?php echo e(trim($cust->first_name . ' ' . $cust->last_name)); ?>

                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('candidates.show', $invoice->CN_Number ?? '')); ?>">
                                <?php echo e(optional($invoice->agreement)->candidate_name); ?>

                            </a>
                        </td>
                        <td>
                            <select class="status-dropdown <?php echo e($statusClass); ?>" data-invoice-id="<?php echo e($invoice->invoice_id); ?>" onchange="confirmInvoiceStatusChangeofEmployees(this, <?php echo e($invoice->invoice_id); ?>, '<?php echo e($invoice->customer->first_name ?? ''); ?>', '<?php echo e($invoice->received_amount); ?>', '<?php echo e($invoice->agreement_reference_no); ?>', '<?php echo e($invoice->invoice_type); ?>')">
                                <?php $__currentLoopData = ['Pending','Unpaid','Paid','Partially Paid','Overdue','Cancelled','Hold','COD','Replacement']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $optClass = strtolower(str_replace(' ', '-', $st)); ?>
                                    <option value="<?php echo e($st); ?>" <?php echo e($invoice->status == $st ? 'selected' : ''); ?> class="<?php echo e($optClass); ?>">
                                        <?php echo e($st); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </td>
                        <td>
                            <?php if(in_array($invoice->status, ['Paid','Partially Paid','Cancelled','COD'])): ?>
                                <?php echo e(Carbon::parse($invoice->due_date)->format('d M Y')); ?>

                            <?php endif; ?>
                        </td>
                        <td><?php echo e(number_format($invoice->total_amount, 2)); ?></td>
                        <td><?php echo e(number_format($invoice->received_amount, 2)); ?></td>
                        <td><?php echo e(number_format($invoice->discount_amount, 2)); ?></td>
                        <td><?php echo e(number_format($invoice->tax_amount, 2)); ?></td>
                        <td><?php echo e($invoice->payment_method); ?></td>
                        <td><?php echo e(Carbon::parse($invoice->invoice_date)->format('d M Y')); ?></td>
                        <td><?php echo e(Carbon::parse($invoice->due_date)->format('d M Y')); ?></td>
                        <td>
                          <?php echo e($invoice->upcoming_payment_date
                              ? \Carbon\Carbon::parse($invoice->upcoming_payment_date)->format('d M Y')
                              : '-'); ?>

                        </td>
                        <td><?php echo e($invoice->notes); ?></td>
                        <td class="actions">
                            <button class="btn btn-success btn-icon-only btn-sm" data-bs-toggle="modal" data-bs-target="#paymentProofModal<?php echo e($invoice->invoice_number); ?>">
                                <i class="fas fa-receipt"></i>
                            </button>
                            <a href="<?php echo e(route('invoices.show', ['invoice' => $invoice->invoice_number])); ?>" class="btn btn-info btn-icon-only btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php
                                $inst = $installmentForInvoice($invoice->invoice_number);
                                [$paid,$total] = explode('/', $installmentStats($invoice->invoice_number));
                            ?>
                            <?php if($inst && (int)$total > 0): ?>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-flex align-items-center" onclick="show_installment_items(<?php echo e($inst->id); ?>)" title="View installments">
                                    <i class="fas fa-list-alt me-1"></i><?php echo e($paid); ?>/<?php echo e($total); ?>

                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <div class="modal fade" id="paymentProofModal<?php echo e($invoice->invoice_number); ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-gradient-primary text-white">
                                    <h5 class="modal-title">Payment Proof</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body scrollable-modal-body text-center">
                                    <?php if($invoice->payment_proof): ?>
                                        <?php
                                            $path = asset('storage/'.$invoice->payment_proof);
                                            $ext  = pathinfo($path, PATHINFO_EXTENSION);
                                        ?>
                                        <?php if(in_array($ext,['jpg','jpeg','png','gif','bmp'])): ?>
                                            <img src="<?php echo e($path); ?>" class="img-fluid d-block mx-auto rounded-3 shadow" alt="Proof">
                                        <?php elseif($ext==='pdf'): ?>
                                            <iframe src="<?php echo e($path); ?>" width="100%" height="500" style="border:none"></iframe>
                                        <?php else: ?>
                                            <p>Unsupported format.</p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p>No proof available.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <?php if($invoice->payment_proof): ?>
                                        <a href="<?php echo e($path); ?>" download class="btn btn-primary btn-sm"><i class="fas fa-download"></i> Download</a>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Ref #</th>
                <th>Contract Ref #</th>
                <th>Sales Name</th>
                <th>Date</th>
                <th>CL #</th>
                <th>CN #</th>
                <th>Customer Name</th>
                <th>Maid Name</th>
                <th>Status</th>
                <th>Approved Date</th>
                <th>Total Amount</th>
                <th>Received Amount</th>
                <th>Discount</th>
                <th>Tax</th>
                <th>Payment Method</th>
                <th>Date</th>
                <th>Due Date</th>
                <th>Upcoming Payment</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted small">Showing <?php echo e($invoices->firstItem()); ?>–<?php echo e($invoices->lastItem()); ?> of <?php echo e($invoices->total()); ?> results</span>
        <ul class="pagination mb-0"><?php echo e($invoices->links('vendor.pagination.bootstrap-4')); ?></ul>
    </div>
</nav>
<div class="modal fade" id="installmentsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary text-white">
        <h5 class="modal-title">Installment Items – <span id="installmentRef"></span></h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body scrollable-modal-body">
        <table class="table table-bordered" id="installmentsTable">
          <thead class="table-secondary"><tr><th>#</th><th>Particular</th><th>Amount</th><th>Payment Date</th><th>Paid Date</th><th>Status</th><th>Action</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token } });
  function fmt(d){ return d ? new Date(d).toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'}) : 'N/A'; }
  function show_installment_items(id){
    document.getElementById('installmentRef').textContent = id;
    fetch('/installments/'+id+'/items',{ headers:{ 'X-CSRF-TOKEN': token }})
      .then(r=>r.json()).then(items=>{
        const tb = document.querySelector('#installmentsTable tbody');
        tb.innerHTML = '';
        if(!items.length){
          tb.innerHTML = '<tr><td colspan="7">No items found.</td></tr>';
        } else {
          items.forEach((it,i)=>{
            const gen = '<button class="btn btn-sm btn-success generate-invoice-btn" data-id="'+it.id+'" data-installment="'+it.installment_id+'" data-amount="'+it.amount+'"><i class="fas fa-file-invoice-dollar"></i> Generate Invoice</button>';
            const view = '<button class="btn btn-sm btn-info view-invoice-btn" data-invoice="'+it.invoice_number+'"><i class="fas fa-eye"></i> View Invoice</button>';
            const btn = it.invoice_generated ? view : gen;
            tb.insertAdjacentHTML('beforeend','<tr><td>'+ (i+1) +'</td><td>'+it.particular+'</td><td>'+parseFloat(it.amount).toFixed(2)+'</td><td>'+fmt(it.payment_date)+'</td><td>'+fmt(it.paid_date)+'</td><td>'+ (it.status||'N/A') +'</td><td>'+btn+'</td></tr>');
          });
        }
        new bootstrap.Modal(document.getElementById('installmentsModal')).show();
      });
  }
  $(document).on('click','.generate-invoice-btn',function(){
    const b = $(this).prop('disabled',true);
    $.ajax({
      url:"<?php echo e(route('installments.generate-invoice')); ?>",
      type:'POST',
      data:{ id:b.data('id'), installment_id:b.data('installment'), amount:b.data('amount') },
      success:r=>{
        if(r.status==='success'){
          toastr.success('Invoice generated.');
          b.replaceWith('<button class="btn btn-sm btn-info view-invoice-btn" data-invoice="'+r.invoice_number+'"><i class="fas fa-eye"></i>View Invoice</button>');
        } else {
          toastr.error(r.message||'Error');
          b.prop('disabled',false);
        }
      },
      error:x=>{
        toastr.error(x.responseJSON?.message||'Server error');
        b.prop('disabled',false);
      }
    });
  });
  $(document).on('click','.view-invoice-btn',function(){
    window.open('/invoices/'+$(this).data('invoice'),'_blank');
  });
  window.show_installment_items = show_installment_items;
})();
</script>
<?php /**PATH /home/developmentoneso/public_html/resources/views/employee/partials/invoice_table.blade.php ENDPATH**/ ?>