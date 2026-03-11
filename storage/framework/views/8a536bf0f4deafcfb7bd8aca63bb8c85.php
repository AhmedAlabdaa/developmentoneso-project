<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Salary Sheet | <?php echo e($payroll->reference_no); ?></title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"
  />
  <style>
    body {
      background-color: #f2f3f5;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      font-size: 12px;
      color: #2c2f33;
    }

    .salary-container {
      background-color: #ffffff;
      padding: 24px;
      margin-top: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .sheet-header {
      border-bottom: 2px solid #2c2f33;
      padding-bottom: 12px;
      margin-bottom: 20px;
    }

    .company-logo {
      max-height: 70px;
    }

    .sheet-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #2c2f33;
    }

    .info-label {
      font-weight: 500;
      color: #495057;
    }

    .info-value {
      color: #212529;
    }

    .signature-line {
      display: inline-block;
      border-bottom: 1px dashed #495057;
      width: 160px;
      margin-top: 4px;
    }

    .btn-print {
      font-size: 12px;
      padding: 4px 8px;
      background: linear-gradient(90deg, #4e54c8, #8f94fb);
      border: none;
      color: #ffffff;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-print:hover {
      background: linear-gradient(90deg, #3b41a1, #6d72e8);
    }

    @media print {
      body {
        -webkit-print-color-adjust: exact;
      }
      .no-print {
        display: none !important;
      }
      .table thead {
        display: table-row-group;
      }
      .table tfoot {
        display: table-row-group;
      }
      .table-bordered th,
      .table-bordered td {
        border: 1px solid #000 !important;
      }
    }

    .table thead th {
      background-color: #e9ecef;
      font-weight: 600;
    }

    .table tbody tr:nth-of-type(odd) {
      background-color: #f8f9fa;
    }

    .table td,
    .table th {
      padding: 8px;
      vertical-align: middle;
      font-size: 12px;
    }

    .totals-row th,
    .totals-row td {
      font-weight: 600;
      background-color: #e9ecef;
    }
  </style>
</head>
<body>
  <div class="container my-4">
    <div class="d-flex justify-content-end mb-3 no-print">
      <button class="btn-print btn-sm" onclick="window.print()">
        <i class="fas fa-print me-1"></i> Print
      </button>
    </div>

    <div class="salary-container">
      <div class="row align-items-center sheet-header">
        <div class="col-sm-4 d-flex align-items-center">
          <img
            src="https://tadbeeralebdaa.onesourceerp.com/assets/img/tadbeeralebdaa_logo.png"
            alt="Tadbeer Alebdaa Logo"
            class="company-logo me-3"
          />
          <div>
            <h5 class="mb-1">Tadbeer Alebdaa</h5>
            <p class="mb-0 small text-muted">
              Dubai, United Arab Emirates<br />
              T: +971 4 123 4567 | E: hr@tadbeer.ae
            </p>
          </div>
        </div>

        <div class="col-sm-8 text-end">
          <div class="sheet-title">Salary Sheet</div>
          <div class="mt-2">
            <span class="info-label">Payroll Ref:</span>
            <span class="info-value"><?php echo e($payroll->reference_no); ?></span><br />
            <span class="info-label">Period:</span>
            <span class="info-value">
              <?php echo e(\Carbon\Carbon::parse($payroll->pay_period_start)->format('d M Y')); ?>

              &ndash;
              <?php echo e(\Carbon\Carbon::parse($payroll->pay_period_end)->format('d M Y')); ?>

            </span><br />
            <span class="info-label">Generated On:</span>
            <span class="info-value"><?php echo e(now()->format('d M Y')); ?></span>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th class="text-center">SR #</th>
              <th class="text-start">Candidate Name</th>
              <th class="text-start">Agreement Ref. No</th>
              <th class="text-end">Salary Amount (AED)</th>
              <th class="text-end">Payable Amount (AED)</th>
              <th class="text-center">Days</th>
              <th class="text-center">Start Date</th>
              <th class="text-center">End Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $grandTotal = 0;
              $totalDays = 0;
            ?>

            <?php $__empty_1 = true; $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <?php
                $candidateName = $detail->agreement->candidate_name ?? 'N/A';
                $grandTotal += $detail->payable_amount;
                $totalDays  += $detail->number_of_days;
              ?>
              <tr>
                <td class="text-center"><?php echo e($loop->iteration); ?></td>
                <td>
                  <a
                    href="<?php echo e(route('agreements.show', $detail->agreement_reference_no)); ?>"
                    class="text-decoration-none text-dark fw-medium"
                  >
                    <?php echo e($candidateName); ?>

                  </a>
                </td>
                <td>
                  <a
                    href="<?php echo e(route('agreements.show', $detail->agreement_reference_no)); ?>"
                    class="text-decoration-none text-dark fw-medium"
                  >
                    <?php echo e($detail->agreement_reference_no); ?>

                  </a>
                </td>
                <td class="text-end"><?php echo e(number_format($detail->salary_amount, 2)); ?></td>
                <td class="text-end"><?php echo e(number_format($detail->payable_amount, 2)); ?></td>
                <td class="text-center"><?php echo e($detail->number_of_days); ?></td>
                <td class="text-center">
                  <?php echo e(\Carbon\Carbon::parse($detail->agreement_start_date)->format('d M Y')); ?>

                </td>
                <td class="text-center">
                  <?php echo e(\Carbon\Carbon::parse($detail->agreement_end_date)->format('d M Y')); ?>

                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr>
                <td colspan="8" class="text-center py-3">
                  No salary details available.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
          <?php if($details->isNotEmpty()): ?>
            <tfoot>
              <tr class="totals-row">
                <th colspan="3" class="text-end">Totals:</th>
                <th class="text-end"><?php echo e(number_format($details->sum('salary_amount'), 2)); ?></th>
                <th class="text-end"><?php echo e(number_format($grandTotal, 2)); ?></th>
                <th class="text-center"><?php echo e($totalDays); ?></th>
                <th colspan="2"></th>
              </tr>
            </tfoot>
          <?php endif; ?>
        </table>
      </div>

      <div class="row mt-4">
        <div class="col-md-6">
          <p class="mb-1 fw-semibold">Prepared By:</p>
          <span class="signature-line"></span>
        </div>
        <div class="col-md-6 text-end">
          <p class="mb-1 fw-semibold">Approved By:</p>
          <span class="signature-line"></span>
        </div>
      </div>

      <div class="text-center mt-4 border-top pt-2">
        <small class="text-muted">© <?php echo e(now()->year); ?> Tadbeer Alebdaa. All rights reserved.</small>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH /var/www/developmentoneso-project/resources/views/agreements/payroll_detail.blade.php ENDPATH**/ ?>