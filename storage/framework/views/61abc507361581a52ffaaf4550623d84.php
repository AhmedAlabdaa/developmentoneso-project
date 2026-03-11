<style>
.table-container {
    width: 100%;
    overflow-x: auto;
    position: relative;
}
.table {
    width: 100%;
    border-collapse: collapse;
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
.table th:last-child {
    z-index: 3;
}
.status-dropdown {
    padding: 5px;
    font-size: 12px;
    border-radius: 5px;
    transition: background-color 0.3s;
    width: 150px;
    color: #000;
    font-weight: bold;
    text-transform: uppercase;
}
.status-dropdown.approved {
    background-color: #28a745;
}
.status-dropdown.pending {
    background-color: #ffc107;
}
.status-dropdown.rejected {
    background-color: #dc3545;
}
.status-dropdown.review {
    background-color: #17a2b8;
}
.attachments-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 20px;
    margin-top: 10px;
}
.attachment-item {
    text-align: center;
}
.attachment-item p {
    margin-top: 5px;
    font-size: 12px;
}
.img-thumbnail {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
}
.bg-gradient-primary {
    background: linear-gradient(to right, #007bff, #6a11cb);
}
.btn-sm {
    font-size: 0.8rem;
}
.scrollable-modal-body {
    max-height: 500px;
    overflow-y: auto;
}
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Ref #</th>
                <th>Sales Name</th>
                <th>Candidate Name</th>
                <th>Package</th>
                <th>Status</th>
                <th>CN #</th>
                <th>CL #</th>
                <th>Created At</th>
                <th>Client</th>
                <th>Foreign Partner</th>
                <th>Nationality</th>
                <th>Passport No</th>
                <th>Passport Expiry Date</th>
                <th>Date of Birth</th>
                <th>Payment Method</th>
                <th>Total Amount</th>
                <th>Received Amount</th>
                <th>Remaining Amount</th>
                <th>Salary</th>
                <th>Notes</th>
                <th>Agr. Start Date</th>
                <th>Trial End Date</th>
                <th>Trial No. Days</th>
                <th>Agr. End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $agreements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agreement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($agreement->reference_no); ?></td>
                    <td title="<?php echo e($agreement->user->first_name ?? ''); ?> <?php echo e($agreement->user->last_name ?? ''); ?>"><?php echo e($agreement->user->first_name ?? ''); ?></td>
                    <td><?php echo e($agreement->candidate_name); ?></td>
                    <td><?php echo e($agreement->package); ?></td>
                    <td>
                        <?php switch($agreement->status):
                            case (1): ?>
                                <i class="fas fa-clock text-warning status-icon" title="Pending"></i> Pending
                                <?php break; ?>
                            <?php case (2): ?>
                                <i class="fas fa-bolt text-success status-icon" title="Active"></i> Active
                                <?php break; ?>
                            <?php case (3): ?>
                                <i class="fas fa-triangle-exclamation text-warning status-icon" title="Exceeded"></i> Exceeded
                                <?php break; ?>
                            <?php case (4): ?>
                                <i class="fas fa-ban text-danger status-icon" title="Cancelled"></i> Cancelled
                                <?php break; ?>
                            <?php case (5): ?>
                                <i class="fas fa-file-signature text-primary status-icon" title="Contracted"></i> Contracted
                                <?php break; ?>
                            <?php case (6): ?>
                                <i class="fas fa-circle-xmark text-danger status-icon" title="Rejected"></i> Rejected
                                <?php break; ?>
                            <?php default: ?>
                                <i class="fas fa-circle-question text-secondary status-icon" title="Unknown"></i> Unknown
                        <?php endswitch; ?>
                    </td>
                    <td><a href="<?php echo e(route('candidates.show', $agreement->reference_of_candidate)); ?>" class="text-primary" target="_blank"><?php echo e($agreement->CN_Number); ?></a></td>
                    <td><a href="<?php echo e(route('crm.show', $agreement->client->slug ?? '')); ?>" class="text-success fw-bold" target="_blank"><?php echo e($agreement->client->cl ?? $agreement->CL_Number); ?></a></td>
                    <td><?php echo e(\Carbon\Carbon::parse($agreement->created_at)->format('d M Y')); ?></td>
                    <td>
                        <?php if($agreement->client): ?>
                            <a href="<?php echo e(route('crm.show', $agreement->client->slug)); ?>" class="text-primary"><?php echo e($agreement->client->first_name); ?> <?php echo e($agreement->client->last_name); ?></a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td><?php echo e(explode(' ', $agreement->foreign_partner)[0] . ' ' . last(explode('-', $agreement->foreign_partner))); ?></td>
                    <td><?php echo e($agreement->Nationality->name ??  $agreement->nationality); ?></td>
                    <td><?php echo e($agreement->passport_no); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($agreement->passport_expiry_date)->format('d M Y')); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($agreement->date_of_birth)->format('d M Y')); ?></td>
                    <td><?php echo e($agreement->payment_method); ?></td>
                    <td><?php echo e(number_format($agreement->total_amount, 2)); ?></td>
                    <td><?php echo e(number_format($agreement->received_amount, 2)); ?></td>
                    <td><?php echo e(number_format($agreement->remaining_amount, 2)); ?></td>
                    <td><?php echo e(number_format($agreement->salary, 2)); ?></td>
                    <td><?php echo e($agreement->notes ?? 'NA'); ?></td>
                    <td><?php echo e($agreement->agreement_start_date ? \Carbon\Carbon::parse($agreement->agreement_start_date)->format('d M Y') : 'N/A'); ?></td>
                    <td>
                      <?php if($agreement->package === 'PKG-1' && $agreement->agreement_end_date): ?>
                        <?php echo e(\Carbon\Carbon::parse($agreement->agreement_end_date)->format('d M Y')); ?>

                      <?php else: ?>
                        –
                      <?php endif; ?>
                    </td>
                    <td><?php echo e($agreement->number_of_days ?? '0'); ?></td>
                    <?php
                        $raw = $agreement->package === 'PKG-1'
                            ? $agreement->agreement_start_date
                            : $agreement->agreement_end_date;

                        $display = '-';

                        if ($raw) {
                            $dt = \Carbon\Carbon::parse($raw);
                            if ($agreement->package === 'PKG-1') {
                                $dt->addYears(2);
                            }

                            $display = $dt->format('d M Y');
                        }
                    ?>
                    <td><?php echo e($display); ?></td>
                    <td class="actions">
                        <a href="<?php echo e(route('agreements.edit', $agreement->reference_no)); ?>" class="btn btn-warning btn-icon-only" title="Edit Agreement">
                          <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-success btn-icon-only" title="View Payment Proof" data-bs-toggle="modal" data-bs-target="#paymentProofModal<?php echo e($agreement->reference_no); ?>">
                            <i class="fas fa-receipt"></i>
                        </button>
                        <a href="<?php echo e(route('agreements.show', $agreement->reference_no)); ?>" class="btn btn-info btn-icon-only" target="_blank" title="View Details">
                          <i class="fas fa-eye"></i>
                        </a>
                        <?php if(in_array(Auth::user()->role, ['Managing Director', 'Archive Clerk' , 'Admin'])): ?>
                            <button type="button" class="btn btn-icon-only toggle-marked <?php echo e($agreement->marked === 'Yes' ? 'btn-success' : 'btn-danger'); ?>" data-id="<?php echo e($agreement->id); ?>" data-ref="<?php echo e($agreement->reference_no); ?>" data-current="<?php echo e($agreement->marked); ?>" title="Marked: <?php echo e($agreement->marked === 'Yes' ? 'Yes' : 'No'); ?>"><i class="fas <?php echo e($agreement->marked === 'Yes' ? 'fa-check-circle' : 'fa-times-circle'); ?>"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
                <div class="modal fade" id="paymentProofModal<?php echo e($agreement->reference_no); ?>" tabindex="-1" aria-labelledby="paymentProofLabel<?php echo e($agreement->reference_no); ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentProofLabel<?php echo e($agreement->reference_no); ?>">Payment Proof</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <?php if($agreement->payment_proof): ?>
                                    <?php
                                        $filePath = asset('storage/'.$agreement->payment_proof);
                                        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    ?>

                                    <?php if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp'])): ?>
                                        <div id="lightGallery<?php echo e($agreement->reference_no); ?>">
                                            <a href="<?php echo e($filePath); ?>" class="lightbox-item">
                                                <img src="<?php echo e($filePath); ?>" alt="Payment Proof" class="img-fluid d-block mx-auto rounded-3 shadow" style="max-width: 100%; max-height: 500px;">
                                            </a>
                                        </div>
                                    <?php elseif(strtolower($fileExtension) === 'pdf'): ?>
                                        <iframe src="<?php echo e($filePath); ?>" width="100%" height="500px" style="border: none;">
                                        </iframe>
                                    <?php else: ?>
                                        <p>Unsupported file format for payment proof.</p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p>No payment proof available.</p>
                                <?php endif; ?>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <?php if($agreement->payment_proof): ?>
                                    <a href="<?php echo e($filePath); ?>" download class="btn btn-primary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                <?php endif; ?>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="convertToContractModal<?php echo e($agreement->reference_no); ?>" tabindex="-1" aria-labelledby="convertToContractModalLabel<?php echo e($agreement->reference_no); ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header text-white" style="background: linear-gradient(135deg, #007bff, #6a11cb);">
                                <h5 class="modal-title" id="convertToContractModalLabel<?php echo e($agreement->reference_no); ?>">
                                    <i class="fas fa-file-signature me-2"></i> Convert to Contract 
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="contract_form_<?php echo e($agreement->reference_no); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="reference_no" value="<?php echo e($agreement->reference_no); ?>">
                                    <input type="hidden" name="agreement_type" value="<?php echo e($agreement->agreement_type); ?>">
                                    <input type="hidden" name="candidate_id" value="<?php echo e($agreement->candidate_id); ?>">
                                    <input type="hidden" name="reference_of_candidate" value="<?php echo e($agreement->reference_of_candidate); ?>">
                                    <input type="hidden" name="package" value="<?php echo e($agreement->package); ?>">
                                    <input type="hidden" name="foreign_partner" value="<?php echo e($agreement->foreign_partner ?? 'NA'); ?>">
                                    <input type="hidden" name="client_id" value="<?php echo e($agreement->client_id); ?>">
                                    <input type="hidden" name="CN_Number" value="<?php echo e($agreement->CN_Number); ?>">
                                    <input type="hidden" name="CL_Number" value="<?php echo e($agreement->CL_Number); ?>">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="candidate_name" class="form-label">
                                                <i class="fas fa-user me-1"></i> Maid Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="candidate_name" name="candidate_name" value="<?php echo e($agreement->candidate_name); ?>" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="client_name" class="form-label">
                                                <i class="fas fa-user-tie me-1"></i> Client Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="client_name" name="client_name" value="<?php echo e($agreement->client->first_name ?? ''); ?> <?php echo e($agreement->client->last_name ?? ''); ?>" readonly>
                                        </div>
                                    </div>
                                    <?php
                                        $defaultStart = $agreement->agreement_start_date
                                            ? \Carbon\Carbon::parse($agreement->agreement_start_date)->format('Y-m-d')
                                            : '';

                                        if (
                                            $agreement->package === 'PKG-1'
                                            && $agreement->status === 5
                                            && $agreement->agreement_start_date
                                        ) {
                                            $defaultEnd = \Carbon\Carbon::parse($agreement->agreement_start_date)
                                                ->addYears(2)
                                                ->format('Y-m-d');
                                        } else {
                                            $defaultEnd = $agreement->agreement_end_date
                                                ? \Carbon\Carbon::parse($agreement->agreement_end_date)->format('Y-m-d')
                                                : '';
                                        }
                                    ?>
                                    <div class="alert alert-warning">
                                        <strong>Note:</strong>
                                        Make sure your contract start and end dates are correct according to the package and status.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="contract_start_date" class="form-label">
                                                <i class="fas fa-calendar-alt me-1"></i> Contract Start Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="contract_start_date" id="contract_start_date" class="form-control" value="<?php echo e(old('contract_start_date', $defaultStart)); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="contract_end_date" class="form-label">
                                                <i class="fas fa-calendar-alt me-1"></i> Contract End Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="contract_end_date" id="contract_end_date" class="form-control" value="<?php echo e(old('contract_end_date', $defaultEnd)); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="contract_signed_copy" class="form-label">
                                                <i class="fas fa-file-pdf me-1"></i> Contract Signed Copy <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" name="contract_signed_copy" id="contract_signed_copy" class="form-control" accept=".png, .jpg, .jpeg, .pdf" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="maid_delivered" class="form-label">
                                                <i class="fas fa-truck me-1"></i> Maid Transferred <span class="text-danger">*</span>
                                            </label>
                                            <select name="maid_delivered" id="maid_delivered" class="form-control" required>
                                                <option value="">Select Option</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="transferred_date" class="form-label">
                                                <i class="fas fa-calendar-alt me-1"></i> Transferred Date <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="transferred_date" id="transferred_date" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="remarks" class="form-label">
                                                <i class="fas fa-comment-dots me-1"></i> Remarks (Optional)
                                            </label>
                                            <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Enter remarks here..."></textarea>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i> Close
                                        </button>
                                        <button type="button" id="convert_to_contract" class="btn btn-success">
                                            <i class="fas fa-save me-1"></i> Convert to Contract
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Ref #</th>
                <th>Sales Name</th>
                <th>Candidate Name</th>
                <th>Package</th>
                <th>Status</th>
                <th>CN #</th>
                <th>CL #</th>
                <th>Created At</th>
                <th>Client</th>
                <th>Foreign Partner</th>
                <th>Nationality</th>
                <th>Passport No</th>
                <th>Passport Expiry Date</th>
                <th>Date of Birth</th>
                <th>Payment Method</th>
                <th>Total Amount</th>
                <th>Received Amount</th>
                <th>Remaining Amount</th>
                <th>Salary</th>
                <th>Notes</th>
                <th>Agr. Start Date</th>
                <th>Trial End Date</th>
                <th>Trial No. Days</th>
                <th>Agr. End Date</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav class="py-2">
  <div class="d-flex justify-content-between align-items-center">
    <span class="text-muted small">Showing <?php echo e($agreements->firstItem()); ?>–<?php echo e($agreements->lastItem()); ?> of <?php echo e($agreements->total()); ?></span>
    <ul class="pagination mb-0"><?php echo e($agreements->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?></ul>
  </div>
</nav>
<script>
    function updateTimeLeft() {
        document.querySelectorAll('.time-left').forEach((element) => {
            const expiryData = element.getAttribute('data-expiry');
            if (!expiryData || isNaN(new Date(expiryData).getTime())) {
                element.innerHTML = `<i class="fas fa-exclamation-triangle text-warning"></i> No expiry date set`;
                element.style.color = 'gray';
                return;
            }

            const expiryDate = new Date(expiryData);
            const now = new Date();
            const diff = expiryDate - now;

            if (diff > 0) {
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                element.innerHTML = `<i class="fas fa-clock text-warning status-icon"></i> ${days}d ${hours}h ${minutes}m ${seconds}s left`;
                element.style.color = '';
            } else {
                const overdue = Math.abs(diff);
                const days = Math.floor(overdue / (1000 * 60 * 60 * 24));
                const hours = Math.floor((overdue % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((overdue % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((overdue % (1000 * 60)) / 1000);
                element.innerHTML = `
                    <i class="fas fa-clock text-danger"></i> Expired<br>
                    <span style="color: red;">-${days}d ${hours}h ${minutes}m ${seconds}s</span>`;
            }
        });
    }

    setInterval(updateTimeLeft, 1000);

    $(document).ready(function() {
        $(document).on('click', '#convert_to_contract', function() {
            const modal = $(this).closest('.modal');
            let isValid = true;

            modal.find('input[required], select[required]').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });

            if (!isValid) {
                toastr.error('Please fill all required fields.');
                return;
            }

            const formData = new FormData();
            formData.append('reference_no', modal.find('input[name="reference_no"]').val());
            formData.append('agreement_reference_no', modal.find('input[name="reference_no"]').val());
            formData.append('agreement_type', modal.find('input[name="agreement_type"]').val());
            formData.append('candidate_id', modal.find('input[name="candidate_id"]').val());
            formData.append('reference_of_candidate', modal.find('input[name="reference_of_candidate"]').val());
            formData.append('package', modal.find('input[name="package"]').val());
            formData.append('foreign_partner', modal.find('input[name="foreign_partner"]').val());
            formData.append('client_id', modal.find('input[name="client_id"]').val());
            formData.append('CN_Number', modal.find('input[name="CN_Number"]').val());
            formData.append('CL_Number', modal.find('input[name="CL_Number"]').val());
            formData.append('contract_start_date', modal.find('input[name="contract_start_date"]').val());
            formData.append('contract_end_date', modal.find('input[name="contract_end_date"]').val());
            formData.append('maid_delivered', modal.find('select[name="maid_delivered"]').val());
            formData.append('transferred_date', modal.find('input[name="transferred_date"]').val());
            formData.append('remarks', modal.find('textarea[name="remarks"]').val());

            const contractSignedCopy = modal.find('input[name="contract_signed_copy"]')[0].files[0];
            if (contractSignedCopy) {
                formData.append('contract_signed_copy', contractSignedCopy);
            } else {
                toastr.error('Contract signed copy is required.');
                modal.find('input[name="contract_signed_copy"]').addClass('is-invalid');
                return;
            }

            $.ajax({
                url: '<?php echo e(route('contracts.store')); ?>',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success('Contract converted successfully!');
                    modal.modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.responseJSON?.errors) {
                        const errors = xhr.responseJSON.errors;
                        for (const [field, messages] of Object.entries(errors)) {
                            const input = modal.find(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').remove();
                            input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                        }
                    } else if (xhr.responseJSON?.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('An unexpected error occurred. Please try again.');
                        console.error(xhr);
                    }
                }
            });
        });

        $(document).on('input change', 'input, select', function() {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        });
    });

    $(document).on('click', '.toggle-marked', function(){
      const btn     = $(this);
      const id      = btn.data('id');
      const refNo   = btn.data('ref');
      const current = btn.data('current');
      const next    = current === 'Yes' ? 'No' : 'Yes';

      Swal.fire({
        title: `Do you want to mark this agreement as ${next}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Yes, ${ next === 'Yes' ? 'mark' : 'unmark' }`,
        cancelButtonText: 'Cancel'
      }).then(result => {
        if (!result.isConfirmed) return;

        $.ajax({
          url: "<?php echo e(route('agreements.toggleMarked')); ?>",
          method: 'POST',
          data: {
            id: id,
            reference_no: refNo,
            marked: next,
            _token: "<?php echo e(csrf_token()); ?>"
          },
          success(response) {
            btn.data('current', next);
            if (next === 'Yes') {
              btn.removeClass('btn-danger').addClass('btn-success')
                 .attr('title','Marked: Yes')
                 .find('i').attr('class','fas fa-check-circle');
            } else {
              btn.removeClass('btn-success').addClass('btn-danger')
                 .attr('title','Marked: No')
                 .find('i').attr('class','fas fa-times-circle');
            }
            toastr.success(response.message || 'Updated');
          },
          error() {
            toastr.error('Failed to update. Try again.');
          }
        });
      });
    });

</script><?php /**PATH /var/www/developmentoneso-project/resources/views/agreements/partials/agreement_table.blade.php ENDPATH**/ ?>