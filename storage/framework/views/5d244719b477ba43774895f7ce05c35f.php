<?php
    $host        = request()->getHost();
    $subdomain   = explode('.', $host)[0];
    $headerImage = asset('assets/img/'.strtolower($subdomain).'_header.jpg');
    $footerImage = asset('assets/img/'.strtolower($subdomain).'_footer.jpg');
    $logoImage   = asset('assets/img/'.strtolower($subdomain).'_logo.png');
    $fmtDate     = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d M Y') : 'N/A';
    $paymentMethodsList = [
        'Bank Transfer ADIB',
        'Bank Transfer ADCB',
        'POS-ID 60043758-ADIB',
        'POS-ID 60045161-ADCB',
        'ADIB-19114761',
        'ADIB-19136783',
        'Cash',
        'Cheque',
        'Replacement',
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Installment Receipt – <?php echo e($invoice->invoice_number); ?></title>
    <link rel="icon" href="<?php echo e($logoImage); ?>">
    <link rel="apple-touch-icon" href="<?php echo e($logoImage); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @page{size:A4;margin:10mm}
        *{box-sizing:border-box}
        body{font-family:Arial,sans-serif;font-size:12px;margin:0;padding:10px;background:#f4f4f4;display:flex;justify-content:center}
        .container{width:100%;max-width:800px;background:#fff;padding:20px;border-radius:10px;box-shadow:0 0 15px rgba(0,0,0,.1)}
        .top-buttons {
            display: flex; justify-content: center;
            gap: 15px; margin-bottom: 15px;
        }
        .top-buttons a,
        .top-buttons button,
        .top-buttons select {
            background: #fff; border: 1px solid #ddd;
            border-radius: 5px;
            padding: 8px 16px; font-size: 14px;
            color: #333; text-decoration: none;
            display: flex; align-items: center;
            gap: 6px; cursor: pointer;
            transition: background .3s;
        }
        .top-buttons select {
            appearance: none;
        }
        .top-buttons a:hover,
        .top-buttons button:hover,
        .top-buttons select:hover {
            background: #f1f1f1;
        }
        .header img,.footer img{width:100%}
        .title{margin:12px 0;font-size:18px;font-weight:700;text-align:center}
        table{width:100%;border-collapse:collapse}
        th,td{padding:8px;border:1px solid #ddd;text-align:left}
        th{background:#f1f1f1}
        .service-table th,.service-table td{text-align:center}
        .totals-table td{text-align:right}
        .note{display:flex;justify-content:space-between;margin-top:10px;font-size:12px}
        .note .ar{text-align:right;direction:rtl;width:48%}.note .en{width:48%}
        .comments textarea{width:100%;height:90px;padding:8px;border:1px solid #ddd}
        .signature{margin-top:10px;font-size:12px}
    </style>
</head>
<body>
    <div class="container">
        <div class="top-buttons">
            <a href="<?php echo e(route('invoices.download',$invoice->invoice_number)); ?>"><i class="fas fa-download"></i>Download</a>
            <button onclick="shareInvoice('<?php echo e($invoice->invoice_number); ?>')"><i class="fas fa-share-alt"></i>Share</button>
            <a href="<?php echo e(route('invoices.index')); ?>"><i class="fas fa-arrow-left"></i>Back</a>
        </div>
        <div class="top-buttons">
          <a href="<?php echo e(route('invoices.download', $invoice->invoice_number)); ?>">
            <i class="fas fa-download"></i> Download
          </a>
          <button onclick="shareInvoice('<?php echo e($invoice->invoice_number); ?>')">
            <i class="fas fa-share-alt"></i> Share
          </button>
          <a href="<?php echo e(route('invoices.index')); ?>">
            <i class="fas fa-arrow-left"></i> Back to Invoices
          </a>
          <select id="payment_method_select">
            <option disabled selected>Change Payment Method</option>
            <?php $__currentLoopData = $paymentMethodsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($method); ?>"><?php echo e($method); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="header"><img src="<?php echo e($headerImage); ?>"></div>
        <div class="title">Installment Receipt / الإيصال (<?php echo e($invoice->invoice_number); ?>)</div>
        <table style="border:none">
            <tr>
                <td style="width:50%">
                    <table>
                        <tr><th>Receipt No.</th><td><?php echo e($invoice->invoice_number); ?></td></tr>
                        <tr><th>Receipt Date</th><td><?php echo e($fmtDate($invoice->invoice_date)); ?></td></tr>
                        <tr><th>Customer</th><td><?php echo e(optional($invoice->customer)->first_name); ?> <?php echo e(optional($invoice->customer)->last_name); ?></td></tr>
                        <tr><th>EID No</th><td><?php echo e(optional($invoice->customer)->emirates_id); ?></td></tr>
                        <tr><th>Nationality</th><td><?php echo e(optional($invoice->customer)->nationality); ?></td></tr>
                        <tr><th>Contact No</th><td><?php echo e(optional($invoice->customer)->mobile); ?></td></tr>
                        <tr><th>Payment Method</th><td><?php echo e($invoice->payment_method); ?></td></tr>
                        <tr><th>Payment Status</th><td><?php echo e($invoice->status); ?></td></tr>
                        <tr><th>Sales Staff</th><td><?php echo e(optional($invoice->creator)->first_name); ?> <?php echo e(optional($invoice->creator)->last_name); ?></td></tr>
                    </table>
                </td>
                <td style="width:50%">
                    <table>
                        <tr>
                            <th>Contract Reference</th>
                            <td>
                                <?php if($invoice->agreement->status == 5): ?>
                                  <?php echo e(optional($invoice->contract)->reference_no ?? '-'); ?>

                                <?php else: ?>
                                  <?php echo e($invoice->agreement->reference_no); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr><th>Contract Type</th><td>
                            <?php if($invoice->agreement->status == 5): ?> CT <?php else: ?> <?php echo e($invoice->agreement->agreement_type); ?> <?php endif; ?>
                        </td></tr>
                        <tr><th>Maid Name</th><td><?php echo e(optional($invoice->agreement)->candidate_name); ?></td></tr>
                        <tr><th>Passport No</th><td><?php echo e(optional($invoice->agreement)->passport_no); ?></td></tr>
                        <tr>
                            <th>Nationality</th>
                            <td>
                                <?php
                                  $nat = $invoice->agreement->nationality;
                                ?>

                                <?php if(is_numeric($nat)): ?>
                                    <?php if($nat == 1): ?>
                                        Ethiopia
                                    <?php elseif($nat == 2): ?>
                                        Uganda
                                    <?php elseif($nat == 3): ?>
                                        Philippines
                                    <?php elseif($nat == 4): ?>
                                        Indonesia
                                    <?php elseif($nat == 5): ?>
                                        Sri Lanka
                                    <?php elseif($nat == 6): ?>
                                        Myanmar
                                    <?php else: ?>
                                        Ethiopia
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php echo e($nat ?: 'Ethiopia'); ?>

                                <?php endif; ?>

                            </td>
                        </tr>
                        <tr><th>Contract Date</th><td><?php echo e($fmtDate(optional($invoice->agreement)->created_at)); ?></td></tr>
                        <tr><th>Contract From</th><td><?php echo e($fmtDate(optional($invoice->agreement)->agreement_start_date)); ?></td></tr>
                        <tr><th>Contract To</th><td><?php echo e($fmtDate(optional($invoice->agreement)->agreement_end_date)); ?></td></tr>
                        <tr><th>Payment Status</th><td><?php echo e($invoice->status); ?></td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <p style="text-align:center;font-weight:700;margin:15px 0 5px">Particulars / تفاصيل</p>

        <table class="service-table">
            <thead>
                <tr>
                    <th>Sl.</th><th>Service</th><th>Qty</th><th>Unit Price</th><th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $invoiceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($i+1); ?></td>
                    <td><?php echo e($it->product_name); ?></td>
                    <td><?php echo e($it->quantity); ?></td>
                    <td><?php echo e(number_format($it->unit_price,2)); ?></td>
                    <td><?php echo e(number_format($it->unit_price*$it->quantity,2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <table class="totals-table" style="margin-top:10px">
            <tr><td style="font-weight:700">Subtotal</td><td><?php echo e(number_format($invoice->total_amount,2)); ?></td></tr>
            <tr><td style="font-weight:700">Amount Received</td><td><?php echo e(number_format($invoice->received_amount,2)); ?></td></tr>
            <tr><td style="font-weight:700">Balance Due</td><td><?php echo e(number_format($invoice->balance_due,2)); ?></td></tr>
        </table>

        <div class="note">
            <div class="en">Kindly check the receipt and documents before leaving the counter.</div>
            <div class="ar">تأكد من الإيصال والمستندات قبل مغادرة الكاونتر</div>
        </div>

        <div class="comments" style="margin-top:10px">
            <strong>Comment:</strong>
            <p style="border:1px solid #ddd;padding:8px;margin-top:5px"><?php echo e($invoice->notes ?? 'N/A'); ?></p>
        </div>

        <div class="signature">
            Prepared By: <?php echo e(auth()->user()->first_name); ?> <?php echo e(auth()->user()->last_name); ?><br>
            Authorized Signatory – المخول بالتوقيع
        </div>

        <div class="footer" style="margin-top:25px"><img src="<?php echo e($footerImage); ?>"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function shareInvoice(number) {
            const url = `${window.location.origin}/invoices/share/${number}`;
            if (navigator.share) {
                navigator.share({ title: `Receipt Invoice ${number}`, url });
            } else {
                alert('Sharing not supported on this browser.');
            }
        }

        $('#payment_method_select').on('change', function() {
            const method = $(this).val();
            const invoiceNo = <?php echo json_encode($invoice->invoice_number, 15, 512) ?>;
            Swal.fire({
                title: 'Change Payment Method?',
                text: `Do you want to change the current payment method to "${method}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it',
                cancelButtonText: 'No, keep current'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `<?php echo e(url('invoices')); ?>/${invoiceNo}/payment-method`,
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            payment_method: method
                        },
                        success(response) {
                            if (response.success) {
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message || 'Update failed');
                            }
                        },
                        error(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Server error');
                        }
                    });
                } else {
                    $(this).val(''); 
                }
            });
        });
    </script>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/invoices/show2.blade.php ENDPATH**/ ?>