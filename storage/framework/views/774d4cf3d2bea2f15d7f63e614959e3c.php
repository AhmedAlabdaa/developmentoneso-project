<?php
    $serverName  = $_SERVER['SERVER_NAME'] ?? request()->getHost();
    $subdomain   = explode('.', $serverName)[0] ?? 'default';
    $headerFile  = strtolower($subdomain) . '_header.jpg';
    $footerFile  = strtolower($subdomain) . '_footer.jpg';
    $logoFile    = strtolower($subdomain) . '_logo.png';

    $creator     = \App\Models\User::find($invoice->created_by);
    $creatorName = $creator ? trim(($creator->first_name ?? '').' '.($creator->last_name ?? '')) : 'N/A';
    $currency    = $invoice->currency ?? 'AED';

    $fmt     = fn($n) => number_format((float)($n ?? 0), 2, '.', '');
    $dateFmt = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d M Y') : '—';

    $subtotal = 0.0;
    $vatTotal = 0.0;
    $centerTotal = 0.0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo e($invoice->invoice_number); ?> – Tax Invoice</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
@page{margin:20mm}
body{font-family:Arial,sans-serif;font-size:13px;margin:0;padding:0;color:#000;background:#fff}
.header,.footer{text-align:center}
.header img,.footer img{width:100%;max-height:150px;object-fit:contain}
.container{max-width:900px;margin:0 auto;padding:20px}
.logo{text-align:center;margin:6px 0 10px}
.logo img{max-height:80px;object-fit:contain}
.title{text-align:center;font-size:18px;font-weight:700;margin:18px 0}
.info-grid-table{width:100%;border-collapse:separate;border-spacing:18px 0;table-layout:fixed;margin-bottom:16px}
.info-cell{vertical-align:top;width:50%}
.info-box{border:1px solid #ddd;padding:10px;box-sizing:border-box;width:100%}
.info-box table{width:100%;border-collapse:collapse;table-layout:fixed}
.info-box th{width:45%;text-align:left;padding:6px 0;font-weight:700;color:#444;vertical-align:top}
.info-box td{width:55%;padding:6px 0;word-break:break-word}
.invoice-table{width:100%;border-collapse:collapse;margin:0 0 14px}
.totals-table{width:420px;border-collapse:collapse;margin:0 0 18px auto}
.invoice-table th,.invoice-table td,.totals-table th,.totals-table td{border:1px solid #ddd;padding:8px;text-align:center}
.invoice-table th{background:#f5f5f5;font-weight:700}
.totals-table th{background:#f9f9f9;text-align:right;font-weight:700}
.signature{margin-top:10px;font-size:13px}
.arabic{direction:rtl;display:inline-block}
.muted{color:#666}
</style>
</head>
<body>
  <div class="header">
    <img src="<?php echo e(asset('assets/img/'.$headerFile)); ?>" alt="Header">
  </div>

  <div class="container">
    <div class="logo">
      <img src="<?php echo e(asset('assets/img/'.$logoFile)); ?>" alt="Logo">
    </div>

    <div class="title">Tax Invoice / <span class="arabic">فاتورة ضريبية</span></div>

    <table class="info-grid-table">
      <tr>
        <td class="info-cell">
          <div class="info-box">
            <table>
              <tr><th>TRN No / <span class="arabic">الرقم الضريبي</span>:</th><td><?php echo e($invoice->trn_no ?? '104813536000003'); ?></td></tr>
              <tr><th>Invoice No / <span class="arabic">رقم الفاتورة</span>:</th><td><?php echo e($invoice->invoice_number); ?></td></tr>
              <tr><th>Invoice Date / <span class="arabic">تاريخ الفاتورة</span>:</th><td><?php echo e($dateFmt($invoice->invoice_date)); ?></td></tr>
              <tr><th>Status / <span class="arabic">الحالة</span>:</th><td><?php echo e($invoice->status); ?></td></tr>
              <tr><th>Sales Name / <span class="arabic">اسم المبيعات</span>:</th><td><?php echo e($creatorName); ?></td></tr>
              <tr><th>MOHRE Ref / <span class="arabic">مرجع الوزارة</span>:</th><td><?php echo e($invoice->mohre_ref); ?></td></tr>
              <tr><th>Currency / <span class="arabic">العملة</span>:</th><td><?php echo e($currency); ?></td></tr>
            </table>
          </div>
        </td>

        <td class="info-cell">
          <div class="info-box">
            <table>
              <tr><th>Customer (CL#) / <span class="arabic">العميل</span>:</th><td><?php echo e($invoice->Customer_name); ?> <?php if($invoice->CL_Number): ?> (<?php echo e($invoice->CL_Number); ?>) <?php endif; ?></td></tr>
              <tr><th>Candidate (CN#) / <span class="arabic">المرشح</span>:</th><td><?php echo e($invoice->candidate_name ?: '—'); ?> <?php if($invoice->CN_Number): ?> (<?php echo e($invoice->CN_Number); ?>) <?php endif; ?></td></tr>
              <tr><th>Payment Mode / <span class="arabic">طريقة الدفع</span>:</th><td><?php echo e($invoice->payment_mode); ?></td></tr>
              <tr><th>Payment Ref / <span class="arabic">مرجع الدفع</span>:</th><td><?php echo e($invoice->payment_reference ?: '—'); ?></td></tr>
              <tr><th>Due Date / <span class="arabic">تاريخ الاستحقاق</span>:</th><td><?php echo e($dateFmt($invoice->due_date)); ?></td></tr>
              <tr><th>Mobile / <span class="arabic">رقم الهاتف</span>:</th><td><?php echo e($invoice->Customer_mobile_no ?: '—'); ?></td></tr>
            </table>
          </div>
        </td>
      </tr>
    </table>

    <table class="invoice-table">
      <thead>
        <tr>
          <th style="width:4%">#</th>
          <th style="width:24%">Service / <span class="arabic">الخدمة</span></th>
          <th style="width:11%">DW No</th>
          <th style="width:7%">Qty</th>
          <th style="width:10%">Rate</th>
          <th style="width:11%">Amount</th>
          <th style="width:7%">Tax %</th>
          <th style="width:10%">VAT</th>
          <th style="width:10%">Center Fee</th>
          <th style="width:12%">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $qty    = (float)($item->qty ?? 0);
            $rate   = (float)($item->amount ?? 0);
            $taxPct = (float)($item->tax ?? 0);
            $center = (float)($item->center_fee ?? 0);

            $base   = $qty * $rate;
            $vat    = $base * ($taxPct / 100);
            $line   = $base + $vat + $center;

            $subtotal += $base;
            $vatTotal += $vat;
            $centerTotal += $center;
          ?>
          <tr>
            <td><?php echo e($i + 1); ?></td>
            <td><?php echo e($item->service_name); ?></td>
            <td><?php echo e($item->dw_number ?: '—'); ?></td>
            <td><?php echo e($fmt($qty)); ?></td>
            <td><?php echo e($fmt($rate)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
            <td><?php echo e($fmt($base)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
            <td><?php echo e($fmt($taxPct)); ?></td>
            <td><?php echo e($fmt($vat)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
            <td><?php echo e($fmt($center)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
            <td><?php echo e($fmt($line)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>

    <?php
      $discount  = (float)($invoice->discount_amount ?? 0);
      $gross     = $subtotal + $vatTotal + $centerTotal;
      $netTotal  = max($gross - $discount, 0);
      $received  = (float)($invoice->received_amount ?? 0);
      $remaining = max($netTotal - $received, 0);
    ?>

    <table class="totals-table">
      <tr><th>Subtotal / <span class="arabic">الإجمالي الفرعي</span>:</th><td><?php echo e($fmt($subtotal)); ?> <span class="muted"><?php echo e($currency); ?></span></td></tr>
      <tr><th>Total VAT / <span class="arabic">إجمالي الضريبة</span>:</th><td><?php echo e($fmt($vatTotal)); ?> <span class="muted"><?php echo e($currency); ?></span></td></tr>
      <tr><th>Center Fees / <span class="arabic">رسوم المركز</span>:</th><td><?php echo e($fmt($centerTotal)); ?> <span class="muted"><?php echo e($currency); ?></span></td></tr>
      <tr><th>Discount / <span class="arabic">الخصم</span>:</th><td><?php echo e($fmt($discount)); ?> <span class="muted"><?php echo e($currency); ?></span></td></tr>
      <tr><th>Net Total / <span class="arabic">الإجمالي الصافي</span>:</th><td><?php echo e($fmt($netTotal)); ?> <span class="muted"><?php echo e($currency); ?></span></td></tr>
      <tr><th>Received / <span class="arabic">المستلم</span>:</th><td><?php echo e($fmt($received)); ?> <span class="muted"><?php echo e($currency); ?></span></td></tr>
      <tr><th>Remaining / <span class="arabic">المتبقي</span>:</th><td><?php echo e($fmt($remaining)); ?> <span class="muted"><?php echo e($currency); ?></span></td></tr>
    </table>

    <?php if(!empty($invoice->notes)): ?>
      <div class="signature">
        <strong>Notes / <span class="arabic">ملاحظات</span>:</strong> <?php echo e($invoice->notes); ?>

      </div>
    <?php endif; ?>

    <div class="signature">
      <strong>Accountant Name / <span class="arabic">اسم المحاسب</span>:</strong> <?php echo e($creatorName); ?>

    </div>
  </div>

  <div class="footer">
    <img src="<?php echo e(asset('assets/img/'.$footerFile)); ?>" alt="Footer">
  </div>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/govt_transactions/download.blade.php ENDPATH**/ ?>