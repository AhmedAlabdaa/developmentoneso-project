<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WC Contract</title>
    <style>
        body {
            font-family: 'arabic', sans-serif;
            direction: rtl;
            text-align: right;
        }
        h1, p {
            margin: 0;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>عقد العمل</h1>
    <p><strong>الاسم:</strong> <?php echo e($candidate->candidate_name); ?></p>
    <p><strong>الجنسية:</strong> <?php echo e($candidate->candidate_name); ?></p>
    <p><strong>التاريخ:</strong> <?php echo e($now); ?></p>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/wc_contract_pdf.blade.php ENDPATH**/ ?>