<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Voucher - <?php echo e($invoice->invoice_number); ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Times New Roman', Times, serif;
            -webkit-print-color-adjust: exact;
        }
        .voucher-container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border: 1px solid #ddd;
            position: relative;
        }
        .header-title {
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 24px;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
            padding-bottom: 5px;
            display: inline-block;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        .company-info h2 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        .company-info p {
            margin: 2px 0;
            font-size: 14px;
            color: #666;
        }
        .voucher-meta {
            text-align: right;
        }
        .voucher-meta p {
            margin: 2px 0;
            font-size: 14px;
        }
        .voucher-meta strong {
            font-size: 15px;
        }
        .content-row {
            margin-bottom: 12px;
            display: flex;
            align-items: baseline;
            font-size: 16px;
            line-height: 1.6;
        }
        .label {
            width: 150px;
            font-weight: bold;
            flex-shrink: 0;
        }
        .value {
            border-bottom: 1px dotted #999;
            flex-grow: 1;
            padding-left: 10px;
            font-weight: 500;
        }
        .amount-box {
            border: 2px solid #000;
            padding: 10px 20px;
            font-size: 20px;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
            background: #f1f1f1;
        }
        .footer-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            text-align: center;
            padding-top: 5px;
            font-size: 14px;
            font-weight: bold;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            opacity: 0.03;
            font-weight: bold;
            pointer-events: none;
            text-transform: uppercase;
        }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        @media print {
            body { background-color: white; }
            .voucher-container { margin: 0; box-shadow: none; border: none; width: 100%; max-width: 100%; padding: 0; }
            .print-btn { display: none; }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn btn-primary print-btn"><i class="fas fa-print"></i> Print</button>

    <div class="voucher-container">
        <div class="watermark">RECEIPT</div>
        
        <div class="header-section">
            <div class="company-info">
                <h2>Al Ebdaa</h2>
                <p>Documents Clearing Services</p>
                <p>Dubai, UAE</p>
                <p>Phone: +971 50 123 4567</p>
            </div>
            <div class="voucher-meta">
                <p><strong>Receipt No:</strong> <?php echo e($invoice->invoice_number); ?></p>
                <p><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y')); ?></p>
            </div>
        </div>

        <div class="text-center">
            <div class="header-title">Receipt Voucher</div>
        </div>

<?php
    $voucherAmount = $receiptVouchers->sum(fn($rv) => $rv->journal?->total_debit ?? 0);
?>

        <div style="margin-top: 30px;">
            <div class="content-row">
                <div class="label">Received From:</div>
                <div class="value"><?php echo e(optional($invoice->customer)->first_name); ?> <?php echo e(optional($invoice->customer)->last_name); ?></div>
            </div>

            <div class="content-row">
                <div class="label">The Sum of AED:</div>
                <div class="value"><?php echo e(number_format($voucherAmount, 2)); ?> (<?php echo e(ucwords(\NumberFormatter::create('en', \NumberFormatter::SPELLOUT)->format($voucherAmount))); ?> Dirhams only)</div>
            </div>

            <div class="content-row">
                <div class="label">Being:</div>
                <div class="value"><?php echo e($invoice->notes ?? 'Payment for services rendered'); ?></div>
            </div>

<?php
    $paymentMode = $receiptVouchers->first()->payment_mode ?? 1;
    $paymentModeLabel = match($paymentMode) {
        1 => 'Cash',
        2 => 'Credit Card',
        3 => 'Debit Card',
        4 => 'Bank Transfer',
        default => 'Cash',
    };
?>

            <div class="content-row">
                <div class="label">Payment Mode:</div>
                <div class="value"><?php echo e($paymentModeLabel); ?></div>
            </div>

             <?php if($invoice->CN_Number): ?>
            <div class="content-row">
                <div class="label">Ref (CN):</div>
                <div class="value"><?php echo e($invoice->CN_Number); ?></div>
            </div>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-between align-items-end">
            <div class="amount-box">
                AED <?php echo e(number_format($voucherAmount, 2)); ?>

            </div>
        </div>

        <div class="footer-section">
            <div class="signature-line">
                Accountant's Signature
            </div>
            <div class="signature-line">
                Receiver's Signature
            </div>
        </div>
        
        <div style="margin-top: 40px; text-align: center; font-size: 12px; color: #777;">
            <p>Thank you for doing business with us.</p>
            <p>This is a computer-generated receipt.</p>
        </div>
    </div>

</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/invoices/receipt_voucher.blade.php ENDPATH**/ ?>