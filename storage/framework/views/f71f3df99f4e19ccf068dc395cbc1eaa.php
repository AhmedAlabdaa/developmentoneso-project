<style>
  #salary-slip-print, #salary-slip-print * { box-sizing: border-box; }
  .salary-slip-wrapper{width:100%;max-width:800px;margin:0 auto;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000}
  .salary-slip-meta{margin:10px 0 15px 0;font-size:12px}
  .salary-slip-meta span{display:block}
  .salary-slip-table{width:100%;border-collapse:collapse;margin-bottom:15px}
  .salary-slip-table th,.salary-slip-table td{border:1px solid #000;padding:6px 8px;font-size:12px;vertical-align:top}
  .salary-slip-table th{background-color:#9fc5e8;font-weight:700;text-align:center}
  .salary-slip-section-title{background-color:#4f81bd;color:#fff;font-weight:700;text-align:center}
  .salary-slip-label{width:20%;font-weight:700}
  .salary-slip-text-right{text-align:right}
  .salary-slip-text-center{text-align:center}
  .salary-slip-ack{margin-top:20px;font-size:12px;line-height:1.6}
  .salary-slip-signature-block{margin-top:25px;font-size:12px;display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
  .salary-slip-sig-box{min-height:70px}
  .salary-slip-sig-line{height:34px;border-bottom:2px solid #000;margin-top:20px}
  .salary-slip-sig-label{margin-top:8px;font-weight:700;text-align:center}
</style>

<?php
  $issueDate = \Carbon\Carbon::now('Asia/Qatar');

  $firstRow = (isset($rows) && $rows && method_exists($rows, 'count') && $rows->count()) ? $rows->first() : null;

  $candidateNoRaw = $worker->cn_number ?? $worker->CN_Number ?? ($firstRow->cn_number ?? ($firstRow->CN_Number ?? null));
  $candidateNo = $candidateNoRaw ? $candidateNoRaw : '-';

  $candidateNameRaw = $worker->candidate_name ?? ($firstRow->candidate_name ?? null);
  $candidateName = $candidateNameRaw ? strtoupper($candidateNameRaw) : '-';

  $passportRaw = $passportNo ?? ($worker->passport_no ?? ($firstRow->passport_no ?? null));
  $passportRaw = is_string($passportRaw) ? trim($passportRaw) : $passportRaw;
  $passportNoFinal = ($passportRaw && strtoupper($passportRaw) !== 'SPONSOR') ? strtoupper($passportRaw) : '-';

  $nationalityRaw = $worker->nationality ?? ($firstRow->nationality ?? null);
  $nationality = $nationalityRaw ? strtoupper($nationalityRaw) : '-';

  $monthlySalary = (float)($worker->worker_salary_amount ?? ($firstRow->worker_salary_amount ?? 0));
  $perDaySalary = $monthlySalary > 0 ? ($monthlySalary / 30) : 0;

  $headerRefRaw =
    $worker->agreement_reference_no
    ?? $worker->payment_reference
    ?? ($firstRow->agreement_reference_no ?? null)
    ?? ($firstRow->payment_reference ?? null)
    ?? ($firstRow->reference_no ?? null);

  $headerRefRaw = is_string($headerRefRaw) ? trim($headerRefRaw) : $headerRefRaw;
  $headerRef = $headerRefRaw ? strtoupper($headerRefRaw) : '-';

  $totalDays = 0;
  $totalAmount = 0;
?>

<div id="salary-slip-print">
  <div class="salary-slip-wrapper">
    <div class="salary-slip-meta">
      <span>Date of Issuing: <?php echo e($issueDate->format('d-m-Y')); ?></span>
      <span>Reference No.: <?php echo e($headerRef); ?></span>
    </div>

    <table class="salary-slip-table">
      <tr>
        <th colspan="4" class="salary-slip-section-title">WORKER DETAILS</th>
      </tr>
      <tr>
        <td class="salary-slip-label">Candidate No.</td>
        <td><?php echo e($candidateNo); ?></td>
        <td class="salary-slip-label">Monthly Salary</td>
        <td class="salary-slip-text-right"><?php echo e(number_format($monthlySalary, 2)); ?></td>
      </tr>
      <tr>
        <td class="salary-slip-label">Candidate Name</td>
        <td><?php echo e($candidateName); ?></td>
        <td class="salary-slip-label">Passport No.</td>
        <td><?php echo e($passportNoFinal); ?></td>
      </tr>
      <tr>
        <td class="salary-slip-label">Nationality</td>
        <td><?php echo e($nationality); ?></td>
        <td class="salary-slip-label"></td>
        <td></td>
      </tr>
    </table>

    <table class="salary-slip-table">
      <tr>
        <th colspan="5" class="salary-slip-section-title">SALARY DETAILS</th>
      </tr>
      <tr>
        <th>REFERENCE NO</th>
        <th>NO. OF WORKED DAYS</th>
        <th>MODE OF PAYMENT</th>
        <th>TOTAL AMOUNT</th>
        <th>STATUS</th>
      </tr>

      <?php if(isset($rows) && $rows && method_exists($rows, 'count') && $rows->count()): ?>
        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $days = (int)($row->maid_worked_days ?? ($row->number_of_days ?? 0));

            $rowMonthly = (float)($row->worker_salary_amount ?? 0);
            $rowPerDay = $rowMonthly > 0 ? ($rowMonthly / 30) : $perDaySalary;

            $ded = $row->salary_deduction_amount ?? null;
            $ded = is_string($ded) ? trim($ded) : $ded;

            $amount = ($ded !== null && $ded !== '') ? (float)$ded : ($rowPerDay * $days);

            $totalDays += $days;
            $totalAmount += $amount;

            $refRaw = $row->reference_no ?? ($row->payment_reference ?? ($row->agreement_reference_no ?? null));
            $refRaw = is_string($refRaw) ? trim($refRaw) : $refRaw;
            $ref = $refRaw ? strtoupper($refRaw) : '-';

            $methodRaw = $row->payment_method ?? null;
            $methodRaw = is_string($methodRaw) ? trim($methodRaw) : $methodRaw;
            $method = $methodRaw ? strtoupper($methodRaw) : '-';

            $status = strtolower((string)($row->status ?? ''));
            $statusText = $status === 'paid' ? 'Paid Balance' : 'Balance';
          ?>

          <tr>
            <td><?php echo e($ref); ?></td>
            <td class="salary-slip-text-center"><?php echo e($days); ?></td>
            <td class="salary-slip-text-center"><?php echo e($method); ?></td>
            <td class="salary-slip-text-right"><?php echo e(number_format($amount, 2)); ?></td>
            <td class="salary-slip-text-center"><?php echo e($statusText); ?></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="salary-slip-text-center">No salary slip data found.</td>
        </tr>
      <?php endif; ?>

      <tr>
        <td class="salary-slip-text-right"><strong>Total</strong></td>
        <td class="salary-slip-text-center"><strong><?php echo e($totalDays); ?></strong></td>
        <td></td>
        <td class="salary-slip-text-right"><strong><?php echo e(number_format($totalAmount, 2)); ?></strong></td>
        <td></td>
      </tr>
    </table>

    <div class="salary-slip-ack">
      I, <strong><?php echo e($candidateName); ?></strong>, hereby acknowledge that I have received the above-mentioned salary amount from Company.
    </div>

    <div class="salary-slip-signature-block">
      <div class="salary-slip-sig-box">
        <div class="salary-slip-sig-line"></div>
        <div class="salary-slip-sig-label">Worker Signature</div>
      </div>
      <div class="salary-slip-sig-box">
        <div class="salary-slip-sig-line"></div>
        <div class="salary-slip-sig-label">Receiver Signature</div>
      </div>
      <div class="salary-slip-sig-box">
        <div class="salary-slip-sig-line"></div>
        <div class="salary-slip-sig-label">Finance Department</div>
      </div>
    </div>
  </div>
</div>
<?php /**PATH /var/www/developmentoneso-project/resources/views/package/package/partials/salary_slip.blade.php ENDPATH**/ ?>