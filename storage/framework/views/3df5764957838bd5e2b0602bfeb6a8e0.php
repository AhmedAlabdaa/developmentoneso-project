<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<style>
.table-container{width:100%;overflow-x:auto;position:relative}
.table{width:100%;border-collapse:collapse;margin-bottom:20px}
.table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.table th{background:#343a40;color:#fff;text-transform:uppercase;font-weight:700}
.table-hover tbody tr:hover{background:#f1f1f1}
.table-striped tbody tr:nth-of-type(odd){background:#f9f9f9}
.actions{display:flex;gap:5px}
.btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
.btn-info{background:#17a2b8}
.btn-warning{background:#ffc107}
.btn-danger{background:#dc3545}
.sticky-table th:last-child,.sticky-table td:last-child{position:sticky;right:0;z-index:2;box-shadow:-2px 0 5px rgba(0,0,0,.1);min-width:150px}
.modal .table th:last-child,.modal .table td:last-child{position:static}
.table th:last-child{z-index:3}
.status-dropdown{padding:5px;font-size:12px;border-radius:5px;transition:background-color .3s;width:120px;color:#000;font-weight:700;text-transform:uppercase}
.status-dropdown.pending{background:#ffc107}
.status-dropdown.partial-paid{background:#17a2b8}
.status-dropdown.paid{background:#28a745}
.status-dropdown.cancelled{background:#dc3545}
.attachments-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:20px;margin-top:10px}
.attachment-item{text-align:center}
.attachment-item p{margin-top:5px;font-size:12px}
.img-thumbnail{max-width:100px;max-height:100px;object-fit:cover}
.bg-gradient-primary{background:linear-gradient(to right,#007bff,#6a11cb)}
.btn-sm{font-size:.8rem}
.scrollable-modal-body{max-height:500px;overflow-y:auto}
</style>

<div class="table-container">
  <table class="table table-striped table-hover sticky-table">
    <thead>
      <tr>
        <th>Ref #</th>
        <th>Invoice Date</th>
        <th>Approved / Rejected Date</th>
        <th>Customer (CL #)</th>
        <th>Candidate (CN #)</th>
        <th>Sales Name</th>
        <th>Change Status</th>
        <th>Payment Mode</th>
        <th>Total Amount</th>
        <th>Total VAT</th>
        <th>Net Total</th>
        <th>Received Amount</th>
        <th>Remaining Amount</th>
        <th>Status</th>
        <th>Customer Note</th>
        <th>Terms&nbsp;&amp;&nbsp;Conditions</th>
        <th>Created By</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $invoiceDate  = optional($invoice->invoice_date)->format('d M Y') ?? '—';
          $decisionDate = $invoice->status !== 'Pending' ? optional($invoice->updated_at)->format('d M Y') : '—';
          $creator      = \App\Models\User::find($invoice->created_by);
          $creatorName  = $creator ? trim(($creator->first_name ?? '').' '.($creator->last_name ?? '')) : 'N/A';
          $statusClass  = strtolower(str_replace(' ', '-', $invoice->status));
          $filePath     = $invoice->payment_proof ? asset('storage/payment_proofs/'.$invoice->payment_proof) : null;
          $ext          = $filePath ? strtolower(pathinfo(parse_url($filePath, PHP_URL_PATH) ?? $filePath, PATHINFO_EXTENSION)) : null;
        ?>
        <tr>
          <td>
            <a href="<?php echo e(route('govt-transactions.show', $invoice->invoice_number)); ?>" class="text-primary" target="_blank">
              <?php echo e($invoice->invoice_number); ?>

            </a>
          </td>
          <td><?php echo e($invoiceDate); ?></td>
          <td><?php echo e($decisionDate); ?></td>
          <td>
            <?php echo e($invoice->Customer_name); ?>

            <small>(<?php echo e($invoice->CL_Number ?? 'N/A'); ?>)</small>
          </td>
          <td>
            <?php echo e($invoice->candidate_name); ?>

            <small>(<?php echo e($invoice->CN_Number ?? 'N/A'); ?>)</small>
          </td>
          <td><?php echo e($invoice->Sales_name ?? 'N/A'); ?></td>
          <td>
            <select class="status-dropdown form-control <?php echo e($statusClass); ?>"
                    data-invoice-number="<?php echo e($invoice->invoice_number); ?>"
                    data-original="<?php echo e($invoice->status); ?>">
              <?php $__currentLoopData = ['Pending','Partial Paid','Paid','Cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($opt); ?>" <?php echo e($invoice->status === $opt ? 'selected' : ''); ?>>
                  <?php echo e($opt); ?>

                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </td>
          <td><?php echo e($invoice->payment_mode); ?></td>
          <td><?php echo e(number_format($invoice->total_amount,2)); ?></td>
          <td><?php echo e(number_format($invoice->total_vat,2)); ?></td>
          <td><?php echo e(number_format($invoice->net_total,2)); ?></td>
          <td><?php echo e(number_format($invoice->received_amount,2)); ?></td>
          <td><?php echo e(number_format($invoice->remaining_amount,2)); ?></td>
          <td><?php echo e($invoice->status); ?></td>
          <td><?php echo e($invoice->customer_note ?? 'N/A'); ?></td>
          <td><?php echo e($invoice->terms_and_conditions ?? 'N/A'); ?></td>
          <td><?php echo e($creatorName); ?></td>
          <td class="actions text-center">
            <button type="button" class="btn btn-success btn-icon-only" data-bs-toggle="modal" data-bs-target="#paymentProofModal<?php echo e($invoice->invoice_number); ?>">
              <i class="fas fa-receipt"></i>
            </button>
            <a href="<?php echo e(route('govt-transactions.show', $invoice->invoice_number)); ?>" class="btn btn-info btn-icon-only">
              <i class="fas fa-eye"></i>
            </a>
            <?php if($invoice->status === 'Pending'): ?>
              <a href="<?php echo e(route('govt-transactions.edit', $invoice->invoice_number)); ?>" class="btn btn-warning btn-icon-only">
                <i class="fas fa-edit"></i>
              </a>
            <?php endif; ?>
          </td>
        </tr>

        <div class="modal fade" id="paymentProofModal<?php echo e($invoice->invoice_number); ?>" tabindex="-1" aria-labelledby="paymentProofLabel<?php echo e($invoice->invoice_number); ?>" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="paymentProofLabel<?php echo e($invoice->invoice_number); ?>">Payment Proof for <?php echo e($invoice->invoice_number); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body text-center">
                <?php if($filePath): ?>
                  <?php if(in_array($ext, ['jpg','jpeg','png','gif','bmp','webp'])): ?>
                    <img src="<?php echo e($filePath); ?>" class="img-thumbnail" style="max-width:100%;max-height:500px">
                  <?php elseif($ext === 'pdf'): ?>
                    <iframe src="<?php echo e($filePath); ?>" width="100%" height="500" style="border:none"></iframe>
                  <?php else: ?>
                    <p>Unsupported file format.</p>
                  <?php endif; ?>
                <?php else: ?>
                  <p>No payment proof available.</p>
                <?php endif; ?>
              </div>
              <div class="modal-footer justify-content-center">
                <?php if($filePath): ?>
                  <a href="<?php echo e($filePath); ?>" download class="btn btn-primary">
                    <i class="fas fa-download"></i> Download
                  </a>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="18" class="text-center">
            <h5 class="my-5">There are no records available</h5>
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <th>Ref #</th>
        <th>Invoice Date</th>
        <th>Approved / Rejected Date</th>
        <th>Customer (CL #)</th>
        <th>Candidate (CN #)</th>
        <th>Sales Name</th>
        <th>Change Status</th>
        <th>Payment Mode</th>
        <th>Total Amount</th>
        <th>Total VAT</th>
        <th>Net Total</th>
        <th>Received Amount</th>
        <th>Remaining Amount</th>
        <th>Status</th>
        <th>Customer Note</th>
        <th>Terms&nbsp;&amp;&nbsp;Conditions</th>
        <th>Created By</th>
        <th class="text-center">Actions</th>
      </tr>
    </tfoot>
  </table>
</div>

<nav class="py-2">
  <div class="d-flex justify-content-between align-items-center">
    <span class="text-muted small">
      Showing <?php echo e($invoices->firstItem()); ?>–<?php echo e($invoices->lastItem()); ?> of <?php echo e($invoices->total()); ?> results
    </span>
    <ul class="pagination mb-0">
      <?php echo e($invoices->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

    </ul>
  </div>
</nav>

<script>
toastr.options={closeButton:true,progressBar:true,positionClass:'toast-top-right',timeOut:4000};

$.ajaxSetup({headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}});

$('.table-container').on('change','.status-dropdown',function(){
  const $el=$(this);
  const num=$el.data('invoice-number');
  const newStatus=$el.val();
  const old=$el.data('original');
  $.ajax({
    type:'POST',
    url:'<?php echo e(route('govt-transactions.changeStatus')); ?>',
    data:{invoice_number:num,status:newStatus},
    beforeSend:()=>$el.prop('disabled',true),
    success:r=>{
      toastr.success(r.message||'Status updated');
      $el.closest('tr').find('td').eq(13).text(r.new_status||newStatus);
      $el.removeClass('pending partial-paid paid cancelled')
         .addClass((r.new_status||newStatus).toLowerCase().replace(' ','-'))
         .data('original',r.new_status||newStatus);
    },
    error:x=>{
      let msg='Unable to update status.';
      if(x.status===422&&x.responseJSON?.errors){msg=Object.values(x.responseJSON.errors).flat().join('<br>')}
      else if(x.responseJSON?.message){msg=x.responseJSON.message}
      toastr.error(msg);
      $el.val(old);
    },
    complete:()=>$el.prop('disabled',false)
  });
});
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/govt_transactions/partials/invoice_table.blade.php ENDPATH**/ ?>