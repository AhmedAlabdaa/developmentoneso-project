<?php echo $__env->make('../layout.Operations_Manager_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<style type="text/css">
  .table thead th {
    background-color: #000;
    color: #fff;
    text-align: center;
  }
</style>
<main id="main" class="main">
  <section class="section">
    <div class="card mb-2">
      <div class="card-body">
        <form method="GET" action="">
          <div class="row m-3">
            <div class="col-md-5">
              <label for="startDate" class="form-label">
                <i class="bi bi-calendar-date me-1"></i> FROM DATE
              </label>
              <input type="date" class="form-control" id="startDate" name="start_date" placeholder="From Date" value="<?php echo e($startDate); ?>">
            </div>
            <div class="col-md-5">
              <label for="endDate" class="form-label">
                <i class="bi bi-calendar-date me-1"></i> TO DATE
              </label>
              <input type="date" class="form-control" id="endDate" name="end_date" placeholder="To Date" value="<?php echo e($endDate); ?>">
            </div>
            <div class="col-md-2 d-flex align-items-end">
              <button class="btn btn-primary w-100">
                <i class="bi bi-funnel"></i> Filter
              </button>
            </div>
          </div>
        </form>

        <h5 class="card-title mb-1">
          <i class="bi bi-building me-1"></i> COMPANY STATISTICS
        </h5>
        <div class="table-responsive mb-2">
          <table class="table table-striped text-center">
            <thead>
              <tr>
                <th><i class="bi bi-card-checklist me-1"></i>All</th>
                <th><i class="bi bi-patch-check me-1"></i>Available</th>
                <th><i class="bi bi-file-earmark me-1"></i>Draft</th>
                <th><i class="bi bi-arrow-clockwise me-1"></i>On Process</th>
                <th><i class="bi bi-exclamation-diamond me-1"></i>Incident</th>
                <th><i class="bi bi-arrow-return-left me-1"></i>Backout</th>
                <th><i class="bi bi-check2-circle me-1"></i>COC Done</th>
                <th><i class="bi bi-journal-check me-1"></i>COC Receipted</th>
                <th><i class="bi bi-heart-pulse me-1"></i>Medical</th>
                <th><i class="bi bi-file-earmark-text me-1"></i>MOL Issued</th>
                <th><i class="bi bi-file-earmark-arrow-up me-1"></i>MOL Submitted</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo e($mainStats['All']); ?></td>
                <td><?php echo e($mainStats['Available']); ?></td>
                <td><?php echo e($mainStats['Draft']); ?></td>
                <td><?php echo e($mainStats['On Process']); ?></td>
                <td><?php echo e($mainStats['Incident']); ?></td>
                <td><?php echo e($mainStats['Backout']); ?></td>
                <td><?php echo e($mainStats['COC Done']); ?></td>
                <td><?php echo e($mainStats['COC Receipted']); ?></td>
                <td><?php echo e($mainStats['Medical']); ?></td>
                <td><?php echo e($mainStats['MOL Issued']); ?></td>
                <td><?php echo e($mainStats['MOL Submitted']); ?></td>
              </tr>
            </tbody>
          </table>
        </div>

        <?php $__currentLoopData = $companyStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country => $companies): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <h5 class="card-title mb-1">
            <?php if($country === 'ETHIOPIA'): ?>
              <img src="https://flagcdn.com/et.svg" alt="Ethiopia" width="25" class="me-1" />
            <?php elseif($country === 'PHILIPPINE'): ?>
              <img src="https://flagcdn.com/ph.svg" alt="Philippine" width="25" class="me-1" />
            <?php elseif($country === 'UGANDA'): ?>
              <img src="https://flagcdn.com/ug.svg" alt="Uganda" width="25" class="me-1" />
            <?php endif; ?>
            <?php echo e($country); ?>

          </h5>
          <?php $index = 1; ?>
          <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companyName => $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <h5 class="card-title mb-1">
              <i class="bi bi-pin-map me-1"></i> <?php echo e($index); ?> - <?php echo e($companyName); ?>

            </h5>
            <div class="table-responsive mb-2">
              <table class="table table-striped text-center">
                <thead>
                  <tr>
                    <th><i class="bi bi-card-checklist me-1"></i>All</th>
                    <th><i class="bi bi-patch-check me-1"></i>Available</th>
                    <th><i class="bi bi-file-earmark me-1"></i>Draft</th>
                    <th><i class="bi bi-arrow-clockwise me-1"></i>On Process</th>
                    <th><i class="bi bi-exclamation-diamond me-1"></i>Incident</th>
                    <th><i class="bi bi-arrow-return-left me-1"></i>Backout</th>
                    <th><i class="bi bi-check2-circle me-1"></i>COC Done</th>
                    <th><i class="bi bi-journal-check me-1"></i>COC Receipted</th>
                    <th><i class="bi bi-heart-pulse me-1"></i>Medical</th>
                    <th><i class="bi bi-file-earmark-text me-1"></i>MOL Issued</th>
                    <th><i class="bi bi-file-earmark-arrow-up me-1"></i>MOL Submitted</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo e($stats['All']); ?></td>
                    <td><?php echo e($stats['Available']); ?></td>
                    <td><?php echo e($stats['Draft']); ?></td>
                    <td><?php echo e($stats['On Process']); ?></td>
                    <td><?php echo e($stats['Incident']); ?></td>
                    <td><?php echo e($stats['Backout']); ?></td>
                    <td><?php echo e($stats['COC Done']); ?></td>
                    <td><?php echo e($stats['COC Receipted']); ?></td>
                    <td><?php echo e($stats['Medical']); ?></td>
                    <td><?php echo e($stats['MOL Issued']); ?></td>
                    <td><?php echo e($stats['MOL Submitted']); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <?php $index++; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </section>
  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-xxl-3 col-md-6 mb-2">
            <div class="card info-card staff-card">
              <div class="card-body">
                <h5 class="card-title">Number of Staff</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none"><?php echo e($totalStaff); ?></a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-md-6 mb-2">
            <div class="card info-card employees-card">
              <div class="card-body">
                <h5 class="card-title">Number of Employees</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-badge"></i>
                  </div>
                  <div class="ps-3">
                    <h6><a href="#" class="text-decoration-none"><?php echo e($totalEmployees); ?></a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php for($i = 1; $i <= 4; $i++): ?>
            <div class="col-xxl-3 col-md-6 mb-2">
              <div class="card info-card package-card">
                <div class="card-body">
                  <h5 class="card-title">Package <?php echo e($i); ?></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-box"></i>
                    </div>
                    <div class="ps-3">
                      <h6><a href="#" class="text-decoration-none"><?php echo e(${"package$i"}); ?></a></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endfor; ?>
          <?php $__currentLoopData = [
            ['name' => 'Customers', 'icon' => 'bi bi-person-lines-fill', 'value' => $totalCustomers],
            ['name' => 'Agreements', 'icon' => 'bi bi-file-earmark-text', 'value' => $totalAgreements],
            ['name' => 'Contracts', 'icon' => 'bi bi-journal', 'value' => $totalContracts],
            ['name' => 'Incidents', 'icon' => 'bi bi-exclamation-circle', 'value' => $totalIncidents],
            ['name' => 'Inside Candidates', 'icon' => 'bi bi-house-door', 'value' => $insideCandidates],
            ['name' => 'Outside Candidates', 'icon' => 'bi bi-box-arrow-up-right', 'value' => $outsideCandidates],
            ['name' => 'Proforma Invoices', 'icon' => 'bi bi-receipt', 'value' => $proformaInvoices],
            ['name' => 'Tax Invoices', 'icon' => 'bi bi-receipt-cutoff', 'value' => $taxInvoices],
            ['name' => 'Activities', 'icon' => 'bi bi-activity', 'value' => $totalActivities],
            ['name' => 'Number Of Documents', 'icon' => 'bi bi-folder2', 'value' => $totalDocuments]
          ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xxl-3 col-md-6 mb-2">
              <div class="card info-card">
                <div class="card-body">
                  <h5 class="card-title"><?php echo e($item['name']); ?></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="<?php echo e($item['icon']); ?>"></i>
                    </div>
                    <div class="ps-3">
                      <h6><a href="#" class="text-decoration-none"><?php echo e($item['value']); ?></a></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Monthly Candidates Progress</h5>
                <canvas id="monthlyProgressChart" style="width: 100%; height: 400px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
const ctx = document.getElementById('monthlyProgressChart').getContext('2d');
const months = [
  'January','February','March','April','May','June',
  'July','August','September','October','November','December'
];
const formattedMonthlyData = <?php echo json_encode($formattedMonthlyData, 15, 512) ?>;
const datasets = Object.keys(formattedMonthlyData).map(status => ({
  label: status,
  data: Object.values(formattedMonthlyData[status]),
  borderColor: getRandomColor(),
  backgroundColor: getRandomColor(0.2),
  tension: 0.3
}));

new Chart(ctx, {
  type: 'line',
  data: {
    labels: months,
    datasets: datasets
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: 'top' },
      title: { display: true, text: 'Monthly Progress of Candidates' }
    },
    scales: { y: { beginAtZero: true } }
  }
});

function getRandomColor(alpha = 1) {
  const r = Math.floor(Math.random() * 255);
  const g = Math.floor(Math.random() * 255);
  const b = Math.floor(Math.random() * 255);
  return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}
<?php /**PATH /var/www/developmentoneso-project/resources/views/Operations-Manager-dashboard.blade.php ENDPATH**/ ?>