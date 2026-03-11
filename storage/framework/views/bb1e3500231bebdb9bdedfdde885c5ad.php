<?php use Illuminate\Support\Str; use Carbon\Carbon; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
    th, td { border: 1px solid #333; padding: 6px; }
    th { background-color: #f0f0f0; text-transform: uppercase; }
    tfoot th { background-color: #fafafa; border-top: 2px solid #333; }
    .signature { margin-top: 60px; text-align: right; }
  </style>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>Candidate Name</th>
        <th>Contract No</th>
        <th>Status</th>
        <th>Date</th>
        <th>Nationality</th>
        <th>Package</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Rep. Date</th>
        <th>Days</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $created  = Carbon::parse($r['contract_created_at'])->format('j M Y');
          $start    = Carbon::parse($r['contract_start_date'])->format('j M Y');
          $end      = Carbon::parse($r['contract_end_date'])->format('j M Y');
          $repDate  = $r['replacement_date']
                        ? Carbon::parse($r['replacement_date'])->format('j M Y')
                        : '-';
          $days     = (int) Str::before($r['duration'], ' ');
        ?>
        <tr>
          <td><?php echo e($r['candidate_name']); ?></td>
          <td><?php echo e($r['contract_number']); ?></td>
          <td><?php echo $r['status']; ?></td>
          <td><?php echo e($created); ?></td>
          <td><?php echo e($r['nationality']); ?></td>
          <td><?php echo e($r['package']); ?></td>
          <td><?php echo e($start); ?></td>
          <td><?php echo e($end); ?></td>
          <td><?php echo e($repDate); ?></td>
          <td><?php echo e($days); ?> Days</td>
          <td><?php echo e(number_format($r['calculated'], 2)); ?></td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="9" class="text-end">Total Employees: <?php echo e($totalEmployees); ?></th>
        <th><?php echo e($totalEmployees); ?></th>
        <th><?php echo e(number_format($totalPayable, 2)); ?> AED</th>
      </tr>
    </tfoot>
  </table>
  <div class="signature">
    ______________________________<br>
    <strong>Accounts</strong>
  </div>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/partials/live_salary_pdf.blade.php ENDPATH**/ ?>