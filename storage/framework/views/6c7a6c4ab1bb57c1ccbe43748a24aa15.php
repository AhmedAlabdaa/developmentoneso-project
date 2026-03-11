<?php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $names        = array_column($rows, 'candidate_name');
    $counts       = array_count_values($names);
    $colorClasses = ['table-primary','table-secondary','table-success','table-danger','table-warning','table-info'];
    $nameClassMap = [];
    $i = 0;
    foreach ($counts as $name => $count) {
        if ($count > 1) {
            $nameClassMap[$name] = $colorClasses[$i++ % count($colorClasses)];
        }
    }
?>

<div id="liveSalaryContainer" class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead class="table-light">
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
          $class       = $nameClassMap[$r['candidate_name']] ?? '';
          $created     = Carbon::parse($r['contract_created_at'])->format('j F Y');
          $updated     = Carbon::parse($r['contract_updated_at'])->format('j F Y');
          $start       = Carbon::parse($r['contract_start_date'])->format('j M Y');
          $end         = Carbon::parse($r['contract_end_date'])->format('j M Y');
          $repDate     = $r['replacement_date']
                            ? Carbon::parse($r['replacement_date'])->format('j M Y')
                            : '-';
          $days        = (int) Str::before($r['duration'], ' ');
        ?>
        <tr class="<?php echo e($class); ?>">
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
    <tfoot class="table-light">
      <tr>
        <th colspan="9" class="text-end">Total Employees:</th>
        <th><?php echo e($totalEmployees); ?></th>
        <th><?php echo e(number_format($totalPayable, 2)); ?> AED</th>
      </tr>
    </tfoot>
  </table>
</div>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/partials/live_salary.blade.php ENDPATH**/ ?>