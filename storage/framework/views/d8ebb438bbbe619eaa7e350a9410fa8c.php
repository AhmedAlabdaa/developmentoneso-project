<?php
    $serverName = $_SERVER['SERVER_NAME'];
    $subdomain = explode('.', $serverName)[0];
    $headerFileName = strtolower($subdomain) . '_header.jpg';
    $footerFileName = strtolower($subdomain) . '_footer.jpg';
    $formattedDate = fn($date) => $date ? \Carbon\Carbon::parse($date)->format('d M Y') : 'N/A';
    $logoFileName = strtolower($subdomain) . '_logo.png';
    $total = $invoice->total_amount;
    $net = $total / 1.05;
    $vat = $total - $net;
    $received = $receivedAmount;
    $balance = $balanceDue;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($invoice->invoice_type); ?> Invoice - <?php echo e($invoice->invoice_number); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="<?php echo e(asset('assets/img/' . $logoFileName)); ?>" rel="icon">
    <link href="<?php echo e(asset('assets/img/' . $logoFileName)); ?>" rel="apple-touch-icon">
    <style>
        body { font-family: Arial, sans-serif; margin:0; padding:0; font-size:14px; display:flex; justify-content:center; align-items:center; padding:10px; }
        .header img, .footer img { width:100%; }
        .tax-invoice { text-align:center; font-size:18px; font-weight:bold; margin:10px 0; }
        .table { width:100%; border-collapse:collapse; margin-top:10px; }
        .table td, .table th { padding:10px; text-align:left; }
        .outer-table { border:1px solid #ddd; }
        .outer-table .table { border:none; }
        .table tr th { background:#f1f1f1; }
        .service-table, .totals-table { width:100%; border-collapse:collapse; margin-top:10px; }
        .service-table th, .service-table td { border:1px solid #ddd; padding:10px; text-align:center; }
        .service-table th { background:#f1f1f1; }
        .totals-table td { border:1px solid #ddd; padding:10px; text-align:right; }
        .note-container { display:flex; justify-content:space-between; font-size:12px; margin-top:10px; }
        .note-container .english { width:48%; font-style:italic; }
        .note-container .arabic { width:48%; direction:rtl; text-align:right; }
        .comments-section { margin-top:10px; }
        .comments-section h3 { font-size:18px; font-weight:bold; }
        .comments-section p { width:100%; height:100px; padding:10px; border:1px solid #ddd; }
        .signature-container { margin-top:10px; }
        .signature-container p { font-size:12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?php echo e(asset('assets/img/' . $headerFileName)); ?>">
        </div>
        <div class="tax-invoice">Tax Invoice</div>
        <table class="table outer-table">
            <tr>
                <td style="width:50%; padding-right:10px;">
                    <table class="table">
                        <tr><th>Receipt No.</th><td><?php echo e($invoice->invoice_number); ?></td></tr>
                        <tr><th>Date</th><td><?php echo e($formattedDate($invoice->invoice_date)); ?></td></tr>
                        <tr><th>Customer</th><td><?php echo e($invoice->customer->first_name); ?> <?php echo e($invoice->customer->last_name); ?></td></tr>
                        <tr><th>EID No</th><td><?php echo e($invoice->customer->emirates_id); ?></td></tr>
                        <tr><th>Nationality</th><td><?php echo e($invoice->customer->nationality); ?></td></tr>
                        <tr><th>Contact No</th><td><?php echo e($invoice->customer->mobile); ?></td></tr>
                        <tr><th>Payment Method</th><td><?php echo e($invoice->payment_method); ?></td></tr>
                        <tr><th>Sales Staff</th><td><?php echo e($invoice->creator->first_name ?? ''); ?> <?php echo e($invoice->creator->last_name ?? ''); ?></td></tr>
                    </table>
                </td>
                <td style="width:50%; padding-left:10px;">
                    <table class="table">
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
                            <?php if($invoice->agreement->status==5): ?> CT-<?php echo e($invoice->CN_Number); ?> <?php else: ?> <?php echo e($invoice->agreement->agreement_type); ?> <?php endif; ?>
                        </td></tr>
                        <tr><th>Candidate</th><td><?php echo e($invoice->agreement->candidate_name); ?></td></tr>
                        <tr><th>Passport No</th><td><?php echo e($invoice->agreement->passport_no); ?></td></tr>
                        <tr>
                            <th>Nationality</th>
                            <td>
                                <?php
                                    $nat = $invoice->agreement->nationality;
                                    $map = [
                                        1 => 'Ethiopia',
                                        2 => 'Uganda',
                                        3 => 'Philippines',
                                        4 => 'Indonesia',
                                        5 => 'Sri Lanka',
                                        6 => 'Myanmar',
                                    ];
                                ?>

                                <?php echo e($map[$nat] 
                                   ?? (is_string($nat) && trim($nat) !== '' 
                                         ? $nat 
                                         : 'Ethiopia')); ?>

                            </td>
                        </tr>
                        <tr><th>Contract Date</th><td><?php echo e($formattedDate($invoice->agreement->created_at)); ?></td></tr>
                        <tr><th>From</th><td><?php echo e($formattedDate($invoice->agreement->agreement_start_date)); ?></td></tr>
                        <tr><th>To</th><td><?php echo e($formattedDate($invoice->agreement->agreement_end_date)); ?></td></tr>
                        <tr><th>Status</th><td><?php echo e(ucfirst($invoice->status)); ?></td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <p style="text-align:center; font-weight:bold; margin-top:10px;">Particulars تفاصيل</p>
        <table class="service-table">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Particular الخدمات</th>
                    <th>QTY</th>
                    <th>Amount تكلفة الوحدة</th>
                    <th>Total الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $invoiceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($i+1); ?></td>
                        <td><?php echo e($item->product_name); ?></td>
                        <td><?php echo e($item->quantity); ?></td>
                        <td><?php echo e(number_format($item->unit_price,2)); ?></td>
                        <td><?php echo e(number_format($item->quantity * $item->unit_price,2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <table class="totals-table">
            <tr><td style="font-weight:bold;">Subtotal (Excl. VAT)</td><td><?php echo e(number_format($net,2)); ?></td></tr>
            <tr><td style="font-weight:bold;">VAT (5%)</td><td><?php echo e(number_format($vat,2)); ?></td></tr>
            <tr><td style="font-weight:bold;">Total (Incl. VAT)</td><td><?php echo e(number_format($total,2)); ?></td></tr>
            <tr><td style="font-weight:bold;">Amount Received</td><td><?php echo e(number_format($received,2)); ?></td></tr>
            <tr><td style="font-weight:bold;">Balance Due</td><td><?php echo e(number_format($balance,2)); ?></td></tr>
        </table>
        <div class="note-container">
            <div class="english">Please verify this receipt and attached documents before leaving.</div>
            <div class="arabic">يرجى التحقق من هذا الإيصال والمستندات المرفقة قبل المغادرة.</div>
        </div>
        <div class="comments-section">
            <h3>Comments ملاحظات</h3>
            <p><?php echo e($invoice->notes ?? 'N/A'); ?></p>
        </div>
        <div class="signature-container">
            <p>Prepared By: <?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?></p>
            <p>Authorized Signatory المخول بالتوقيع</p>
        </div>
        <div class="footer">
            <img src="<?php echo e(asset('assets/img/' . $footerFileName)); ?>">
        </div>
    </div>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/invoices/download1.blade.php ENDPATH**/ ?>