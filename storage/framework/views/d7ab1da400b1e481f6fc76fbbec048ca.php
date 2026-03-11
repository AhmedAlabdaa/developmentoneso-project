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
    $dateFmt = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d M Y') : '';

    $subtotal = 0.0;
    $vatTotal = 0.0;
    $centerTotal = 0.0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo e($invoice->invoice_number); ?> - فاتورة ضريبية (Tax Invoice)</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
@page{size:A4;margin:10mm}
body{font-family:Arial,sans-serif;font-size:12px;margin:0;padding:0;background:#fff;color:#000}
.top-buttons{display:flex;justify-content:center;gap:15px;margin:10px 0}
.top-buttons a{display:flex;align-items:center;gap:6px;padding:8px 14px;background:#f7f7f7;border:1px solid #ddd;border-radius:6px;text-decoration:none;color:#222}
.container{width:100%;max-width:820px;margin:0 auto;padding:18px;background:#fff;border-radius:10px;box-shadow:0 0 12px rgba(0,0,0,.06)}
.logo-section,.header-section,.footer-section{text-align:center}
.logo-section img{max-height:80px;object-fit:contain}
.header-section img,.footer-section img{width:100%;max-height:80px;object-fit:contain}
.invoice-title{text-align:center;margin:12px 0 6px;font-size:18px;font-weight:bold}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin:14px 0}
.info-box{border:1px solid #e3e3e3;padding:10px}
.info-box table{width:100%;border-collapse:collapse}
.info-box th{width:42%;text-align:left;padding:4px 0;font-weight:600;color:#444;vertical-align:top}
.info-box td{padding:4px 0}
.arabic-text{direction:rtl;display:inline-block}
.invoice-table,.totals-table{width:100%;border-collapse:collapse;margin-top:10px}
.invoice-table th,.invoice-table td,.totals-table th,.totals-table td{border:1px solid #e5e5e5;padding:8px;text-align:center}
.invoice-table th{background:#f5f7fb}
.totals-wrap{display:flex;justify-content:flex-end}
.totals-table{width:360px;margin-left:auto}
.totals-table th{text-align:right;background:#fafafa}
.muted{color:#666}
.note{margin-top:14px}
</style>
</head>
<body>
<div class="top-buttons">
  <a href="<?php echo e(route('govt-transactions.download', $invoice->invoice_number)); ?>"><i class="fas fa-download"></i> Download</a>
  <a href="<?php echo e(route('govt-transactions.index')); ?>"><i class="fas fa-arrow-left"></i> Back to Transactions</a>
</div>

<div class="container">
  <div class="logo-section"><img src="<?php echo e(asset('assets/img/'.$logoFile)); ?>" alt="Logo"></div>
  <div class="header-section"><img src="<?php echo e(asset('assets/img/'.$headerFile)); ?>" alt="Header"></div>

  <div class="invoice-title">Tax Invoice / <span class="arabic-text">فاتورة ضريبية</span></div>

  <div class="info-grid">
    <div class="info-box">
      <table>
        <tr><th>TRN No / <span class="arabic-text">الرقم الضريبي</span>:</th><td><?php echo e($invoice->trn_no ?? '104813536000003'); ?></td></tr>
        <tr><th>Invoice No / <span class="arabic-text">رقم الفاتورة</span>:</th><td><?php echo e($invoice->invoice_number); ?></td></tr>
        <tr><th>Invoice Date / <span class="arabic-text">تاريخ الفاتورة</span>:</th><td><?php echo e($dateFmt($invoice->invoice_date)); ?></td></tr>
        <tr><th>Status / <span class="arabic-text">الحالة</span>:</th><td><?php echo e($invoice->status); ?></td></tr>
        <tr><th>Sales Name / <span class="arabic-text">اسم المبيعات</span>:</th><td><?php echo e($creatorName); ?></td></tr>
        <tr><th>MOHRE Ref / <span class="arabic-text">مرجع الوزارة</span>:</th><td><?php echo e($invoice->mohre_ref); ?></td></tr>
        <tr><th>Currency / <span class="arabic-text">العملة</span>:</th><td><?php echo e($currency); ?></td></tr>
      </table>
    </div>
    <div class="info-box">
      <table>
        <tr><th>Customer (CL#) / <span class="arabic-text">العميل</span>:</th><td><?php echo e($invoice->Customer_name); ?> (<?php echo e($invoice->CL_Number); ?>)</td></tr>
        <tr><th>Candidate (CN#) / <span class="arabic-text">المرشح</span>:</th><td><?php echo e($invoice->candidate_name); ?> <?php if($invoice->CN_Number): ?> (<?php echo e($invoice->CN_Number); ?>) <?php endif; ?></td></tr>
        <tr><th>Payment Mode / <span class="arabic-text">طريقة الدفع</span>:</th><td><?php echo e($invoice->payment_mode); ?></td></tr>
        <tr><th>Payment Ref / <span class="arabic-text">مرجع الدفع</span>:</th><td><?php echo e($invoice->payment_reference); ?></td></tr>
        <tr><th>Due Date / <span class="arabic-text">تاريخ الاستحقاق</span>:</th><td><?php echo e($dateFmt($invoice->due_date)); ?></td></tr>
        <tr><th>Mobile / <span class="arabic-text">رقم الهاتف</span>:</th><td><?php echo e($invoice->Customer_mobile_no); ?></td></tr>
      </table>
    </div>
  </div>

  <table class="invoice-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Service / <span class="arabic-text">الخدمة</span></th>
        <th>DW No</th>
        <th>Qty / <span class="arabic-text">الكمية</span></th>
        <th>Rate</th>
        <th>Tax %</th>
        <th>VAT</th>
        <th>Center Fee</th>
        <th>Line Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $qty    = (float)($item->qty ?? 0);
          $rate   = (float)($item->amount ?? 0);
          $taxPct = (float)($item->tax ?? 0);
          $center = (float)($item->center_fee ?? 0);

          $base = $qty * $rate;
          $vat  = $base * ($taxPct / 100);
          $line = $base + $vat + $center;

          $subtotal += $base;
          $vatTotal += $vat;
          $centerTotal += $center;
        ?>
        <tr>
          <td><?php echo e($i + 1); ?></td>
          <td><?php echo e($item->service_name); ?></td>
          <td><?php echo e($item->dw_number); ?></td>
          <td><?php echo e($fmt($qty)); ?></td>
          <td><?php echo e($fmt($rate)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
          <td><?php echo e($fmt($taxPct)); ?></td>
          <td><?php echo e($fmt($vat)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
          <td><?php echo e($fmt($center)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
          <td><?php echo e($fmt($line)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>

  <?php
    $discount = (float)($invoice->discount_amount ?? 0);
    $gross = $subtotal + $vatTotal + $centerTotal;
    $grand = max($gross - $discount, 0);
    $received = (float)($invoice->received_amount ?? 0);
    $remaining = max($grand - $received, 0);
  ?>

  <div class="totals-wrap">
    <table class="totals-table">
      <tr>
        <th>Subtotal / <span class="arabic-text">الإجمالي الفرعي</span>:</th>
        <td><?php echo e($fmt($subtotal)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
      </tr>
      <tr>
        <th>VAT Total / <span class="arabic-text">إجمالي الضريبة</span>:</th>
        <td><?php echo e($fmt($vatTotal)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
      </tr>
      <tr>
        <th>Center Fee Total / <span class="arabic-text">إجمالي رسوم المركز</span>:</th>
        <td><?php echo e($fmt($centerTotal)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
      </tr>
      <tr>
        <th>Discount / <span class="arabic-text">الخصم</span>:</th>
        <td><?php echo e($fmt($discount)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
      </tr>
      <tr>
        <th>Net Total / <span class="arabic-text">الإجمالي الصافي</span>:</th>
        <td><?php echo e($fmt($grand)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
      </tr>
      <tr>
        <th>Received / <span class="arabic-text">المستلم</span>:</th>
        <td><?php echo e($fmt($received)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
      </tr>
      <tr>
        <th>Remaining / <span class="arabic-text">المتبقي</span>:</th>
        <td><?php echo e($fmt($remaining)); ?> <span class="muted"><?php echo e($currency); ?></span></td>
      </tr>
    </table>
  </div>

  <?php if(!empty($invoice->notes)): ?>
    <div class="note"><strong>Notes / <span class="arabic-text">ملاحظات</span>:</strong> <?php echo e($invoice->notes); ?></div>
  <?php endif; ?>

  <div class="note"><strong>Accountant Name / <span class="arabic-text">اسم المحاسب</span>:</strong> <?php echo e($creatorName); ?></div>

  <div class="footer-section" style="margin-top:10px">
    <img src="<?php echo e(asset('assets/img/'.$footerFile)); ?>" alt="Footer">
  </div>
</div>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/govt_transactions/show.blade.php ENDPATH**/ ?>