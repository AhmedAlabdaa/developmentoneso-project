<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body{font-family:DejaVu Sans, Arial, sans-serif;font-size:10px}
    h3{margin:0 0 10px 0;font-size:14px}
    table{width:100%;border-collapse:collapse}
    th,td{border:1px solid #444;padding:6px;vertical-align:top}
    th{background:#eee}
  </style>
</head>
<body>
  <h3><?php echo e($title); ?></h3>
  <table>
    <thead>
      <tr>
        <?php $__currentLoopData = $headings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <th><?php echo e($h); ?></th>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <?php $__currentLoopData = $r; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td><?php echo e($c); ?></td>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/exports/generic_pdf.blade.php ENDPATH**/ ?>