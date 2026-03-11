<?php
    $sub = explode('.', request()->getHost())[0] ?? 'default';
    $hdr = asset("assets/img/".strtolower($sub)."_header.jpg");
    $ftr = asset("assets/img/".strtolower($sub)."_footer.jpg");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: A4; margin: 10px }
        body{margin:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px}
        table{width:100%;border-collapse:collapse}
        th,td{border:1px solid #000;padding:8px;text-align:center;vertical-align:middle}
        .sig-box{margin-top:40px;text-align:center;}
        .sig-img{border-top:1px solid #000;width:300px;margin:0 auto;}
    </style>
</head>
<body>
<img src="<?php echo e($hdr); ?>" style="width:100%">

<?php echo $__env->make('contracts.partials.show1', ['contract'=>$contract], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="sig-box">
    <p><strong>Customer Signature / توقيع العميل</strong></p>
    <img src="file://<?php echo e($signaturePath); ?>" class="sig-img">
    <p><?php echo e(\Carbon\Carbon::now()->format('d-m-Y')); ?></p>
</div>

<img src="<?php echo e($ftr); ?>" style="width:100%">
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/contracts/pdf_signed.blade.php ENDPATH**/ ?>