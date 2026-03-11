<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    body {
        background: linear-gradient(to right, #c9d6ff, #e2e2e2);
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }
    .card {
        border-radius: 10px;
        background: linear-gradient(to right, #ffffff, #f2f2f2);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .table thead th {
        background: linear-gradient(to right, #007bff, #00c6ff);
        color: #fff;
        text-align: center;
    }
    .table tbody td {
        vertical-align: middle;
    }
    .btn-primary {
        background: linear-gradient(to right, #007bff, #00c6ff);
        border: none;
    }
    .btn-success {
        background: linear-gradient(to right, #28a745, #85e085);
        border: none;
        color: #fff;
    }
    .btn-danger {
        background: linear-gradient(to right, #dc3545, #ff6666);
        border: none;
        color: #fff;
    }
    .form-label {
        font-weight: 500;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card flex-fill">
                    <div class="card-body" style="margin-top: 10px;">
                        <h4 class="card-title mb-3" style="font-weight:600; color:#333;">
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
                        <form action="<?php echo e(route('invoices.store')); ?>" method="POST" class="row g-3">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-6">
                                <label for="invoice_number" class="form-label">
                                    Invoice Number <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-hashtag"></i>
                                    </span>
                                    <input type="text" name="invoice_number" id="invoice_number" class="form-control" value="<?php echo e(old('invoice_number', $nextInvoiceNumber ?? 'INV-0001')); ?>" placeholder="INV-0001" required readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="invoice_date" class="form-label">
                                    Invoice Date <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="<?php echo e(old('invoice_date') ?? date('Y-m-d')); ?>" required
                                    >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="customer_id" class="form-label">
                                    Select Customer <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <select name="customer_id" id="customer_id" class="form-select" style="width:90%" required>
                                        <option value="" disabled selected>-- Search & Select Customer --</option>
                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($customer->id); ?>" <?php echo e(old('customer_id') == $customer->id ? 'selected' : ''); ?>

                                            > <?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?> - <?php echo e($customer->CN_Number ?? 'N/A'); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="due_date" class="form-label">
                                    Payment Due Date <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="date" name="due_date" id="due_date" class="form-control" value="<?php echo e(old('due_date')); ?>" required
                                    >
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">
                                    Invoice Items <span class="text-danger">*</span>
                                </label>
                                <table class="table table-bordered table-hover" id="invoiceItemsTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 35%">Particular / Description</th>
                                            <th style="width: 15%">Quantity</th>
                                            <th style="width: 15%">Unit Price</th>
                                            <th style="width: 15%">Line Total</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoiceItemsBody">
                                        <tr>
                                            <td>
                                                <input type="text" name="particulars[]" class="form-control" placeholder="Description" required>
                                            </td>
                                            <td>
                                                <input type="number" name="quantities[]" class="form-control quantity" step="1" min="1" value="1" required>
                                            </td>
                                            <td>
                                                <input type="number" name="prices[]" class="form-control price" step="0.01" min="0" value="0" required>
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
                            <div class="col-md-4">
                                <label for="subtotal" class="form-label">Subtotal</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="text" name="subtotal" id="subtotal" class="form-control" value="0.00" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="vat_amount" class="form-label">
                                    VAT Amount 
                                    <span style="font-size: 10px;">
                                        (Default 5% of subtotal; you can override)
                                    </span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-percent"></i>
                                    </span>
                                    <input type="number" name="vat_amount" id="vat_amount" class="form-control" step="0.01" value="0.00">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="grand_total" class="form-label">Grand Total</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calculator"></i>
                                    </span>
                                    <input type="text" name="grand_total" id="grand_total" class="form-control" value="0.00" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="notes" class="form-label">Additional Notes</label>
                                <textarea 
                                    name="notes" 
                                    id="notes" 
                                    class="form-control" 
                                    rows="3"
                                    placeholder="Any extra information about this invoice..."
                                ><?php echo e(old('notes')); ?></textarea>
                            </div>
                            <div class="col-12">
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
<script>
    $(document).ready(function() {
        $('#customer_id').select2({
            placeholder: "Search & Select Customer",
            allowClear: true
        });

        function isLastRowFilled() {
            const $lastRow = $('#invoiceItemsBody tr:last');
            const particularVal = $lastRow.find('input[name="particulars[]"]').val().trim();
            const quantityVal = $lastRow.find('input[name="quantities[]"]').val().trim();
            const priceVal = $lastRow.find('input[name="prices[]"]').val().trim();
            if (!particularVal || !quantityVal || !priceVal) {
                return false;
            }
            return true;
        }

        function calculateLineTotal($row) {
            const qty = parseFloat($row.find('.quantity').val()) || 0;
            const price = parseFloat($row.find('.price').val()) || 0;
            const lineTotal = qty * price;
            $row.find('.line-total').val(lineTotal.toFixed(2));
        }

        function calculateTotals() {
            let subTotal = 0;
            $('#invoiceItemsBody tr').each(function() {
                const lineTotal = parseFloat($(this).find('.line-total').val()) || 0;
                subTotal += lineTotal;
            });
            $('#subtotal').val(subTotal.toFixed(2));

            let currentVat = parseFloat($('#vat_amount').val());
            if (isNaN(currentVat) || currentVat < 0) {
                currentVat = subTotal * 0.05; 
                $('#vat_amount').val(currentVat.toFixed(2));
            }

            const grandTotal = subTotal + currentVat;
            $('#grand_total').val(grandTotal.toFixed(2));
        }

        $('#addRowBtn').on('click', function() {
            if (!isLastRowFilled()) {
                toastr.error('Please fill the current row before adding a new one.');
                return;
            }
            const newRow = `<tr>
                <td><input type="text" name="particulars[]" class="form-control" placeholder="Description" required></td>
                <td><input type="number" name="quantities[]" class="form-control quantity" step="1" min="1" value="1" required></td>
                <td><input type="number" name="prices[]" class="form-control price" step="0.01" min="0" value="0" required></td>
                <td><input type="text" class="form-control line-total" value="0.00" readonly></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm removeRowBtn">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>`;
            $('#invoiceItemsBody').append(newRow);
        });

        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
            calculateTotals();
        });

        $(document).on('input', '.quantity, .price', function() {
            calculateLineTotal($(this).closest('tr'));
            calculateTotals();
        });

        $(document).on('input', '#vat_amount', function() {
            calculateTotals();
        });
    });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/invoices/create.blade.php ENDPATH**/ ?>