<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style type="text/css">
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
  .table th,.table td{vertical-align:middle}
  .nav-tabs .nav-link{transition:background-color .2s;color:#495057}
  .nav-tabs .nav-link:hover{background-color:#f8f9fa}
  .nav-tabs .nav-link.active{background-color:#007bff;color:#fff}
  .nav-tabs .nav-link i{margin-right:6px}
  .badge{font-weight:500}
  .btn{transition:background-color .2s,color .2s}
  .btn:hover{background-color:#007bff;color:#fff}
  .btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:none}
  .btn-csv-upload{background:linear-gradient(to right,#00c6ff,#6a11cb);color:#fff;border:none;font-size:12px}
  .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:500}
  .pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}
  .pagination{display:flex;justify-content:center;align-items:center;margin:0}
  .pagination .page-item{margin:0 .1rem}
  .pagination .page-link{border-radius:.25rem;padding:.5rem .75rem;color:#007bff;background:#fff;border:1px solid #007bff;transition:background-color .2s,color .2s;box-shadow:0 2px 5px rgba(0,0,0,.1)}
  .pagination .page-link:hover{background:#007bff;color:#fff}
  .pagination .page-item.active .page-link{background:#007bff;color:#fff;border:1px solid #007bff}
  .pagination .page-item.disabled .page-link{color:#6c757d;background:#fff;border:1px solid #6c757d;cursor:not-allowed}
  .preloader{display:none;position:absolute;left:40%;font-size:20px;color:#007bff}
  .card{border-radius:8px}
  .form-group label{font-weight:500;margin-bottom:10px}
  .form-control{border-radius:6px;height:42px}
  .select2-container .select2-selection--single{height:42px;padding:6px 12px;font-size:12px;border:1px solid #ced4da;border-radius:6px}
  .select2-container{z-index:1055;width:100%!important}
  .select2-results__option{font-size:12px}
  .nav-link{font-size:12px;text-transform:uppercase}
  .subtabs-wrap{display:none;margin-top:8px}
  .subtabs-wrap .nav{border-bottom:0}
  .subtabs-wrap .nav-link{color:#000}
  .subtabs-wrap .nav-link.active{background:#0d6efd;color:#fff}
  .global-search{position:relative}
  .global-search .form-control{padding-left:34px;height:40px}
  .global-search .fa-search{position:absolute;left:10px;top:50%;transform:translateY(-50%);opacity:.6}
  .incident-agreement-card .card-body{padding:1rem}
  .incident-agreement-head{display:flex;justify-content:space-between;align-items:center;gap:.75rem;flex-wrap:wrap}
  .incident-agreement-head .ref-badge{font-size:.85rem;padding:.45rem .6rem}
  .incident-agreement-table th{background:#f8fafc;font-weight:600}
  .incident-agreement-table th,.incident-agreement-table td{vertical-align:middle}
  .incident-decision-wrap{display:flex;gap:1.25rem;flex-wrap:wrap;align-items:center;margin:.25rem 0 .75rem}
  .incident-decision-wrap .form-check{margin:0}
  .incident-balance-pill{display:inline-flex;align-items:center;gap:.35rem;padding:.35rem .55rem;border-radius:999px;background:#eef2ff}
  .incident-balance-pill .dot{width:.5rem;height:.5rem;border-radius:50%;background:#4f46e5;display:inline-block}
  .no-flatpickr{background:#fff}
</style>

<?php
  $c = $counts ?? [];
  $sumOnProcess =
    ($c['Selected'] ?? 0) +
    ($c['WC-Date'] ?? 0) +
    ($c['Incident Before Visa (IBV)'] ?? 0) +
    ($c['Visa Date'] ?? 0) +
    ($c['Incident After Visa (IAV)'] ?? 0) +
    ($c['Arrived Date'] ?? 0);
?>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card flex-fill">
          <div class="card-body">
            <div class="row mt-2 align-items-center">
              <div class="col-lg-8 mt-2">
                <div class="global-search">
                  <i class="fas fa-search"></i>
                  <input type="text" id="global_search_input" class="form-control" placeholder="Global Search: Candidate Name, Passport No, Reference No">
                </div>
              </div>
              <div class="col-lg-4 d-flex justify-content-end align-items-center mt-2">
                <div class="d-flex justify-content-end align-items-center gap-3 mb-2">
                  <a href="<?php echo e(route('candidates.inside')); ?>" title="Inside" class="btn btn-primary btn-sm d-flex align-items-center gap-2" style="font-size:12px"><i class="bi bi-door-open"></i>Inside</a>
                  <div class="dropdown">
                    <button class="btn btn-primary btn-sm d-flex align-items-center gap-2 dropdown-toggle" type="button" id="toggleFilterText" data-bs-toggle="dropdown" aria-expanded="false" style="font-size:12px"><i class="fas fa-filter"></i>FILTERS</button>
                    <div class="dropdown-menu" style="min-width:500px" aria-labelledby="toggleFilterText">
                      <div class="p-3">
                        <form id="filter_form_outside">
                          <input type="hidden" id="global_search_hidden" name="global_search">
                          <input type="hidden" id="current_status_id_hidden" name="current_status_id">
                          <input type="hidden" id="tab_name_hidden" name="tab_name">
                          <div class="row">
                            <div class="col-md-6 mb-2"><input type="text" id="reference_no" name="reference_no" class="form-control" placeholder="Enter Reference No"></div>
                            <div class="col-md-6 mb-2"><input type="text" id="name" name="name" class="form-control" placeholder="Enter Name"></div>
                            <div class="col-md-6 mb-2">
                              <select id="nationality" name="nationality" class="form-control">
                                <option value="">Select Nationality</option>
                                <?php $__currentLoopData = $nationalities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nationality): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($nationality->id); ?>"> <?php echo e($nationality->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2"><input type="text" id="passport_number" name="passport_number" class="form-control" placeholder="Enter Passport Number"></div>
                            <div class="col-md-6 mb-2">
                              <select id="current_status" name="current_status" class="form-control">
                                <option value="">Select Status</option>
                                <?php $__currentLoopData = $currentStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($status->id); ?>"> <?php echo e($status->status_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2">
                              <select id="package" name="package" class="form-control">
                                <option value="">Select Package</option>
                                <option value="PKG-1">PKG-1</option>
                                <option value="PKG-2">PKG-2</option>
                                <option value="PKG-3">PKG-3</option>
                                <option value="PKG-4">PKG-4</option>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2">
                              <select id="education" name="education" class="form-control">
                                <option value="">Select Education</option>
                                <?php $__currentLoopData = $educationLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $education): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($education->id); ?>"> <?php echo e($education->level_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2">
                              <select id="skills" name="skills" class="form-control">
                                <option value="">Select Skill</option>
                                <?php $__currentLoopData = $workSkills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($skill->id); ?>"> <?php echo e($skill->skill_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2">
                              <select id="religion" name="religion" class="form-control">
                                <option value="">Select Religion</option>
                                <option value="Muslim">Muslim</option>
                                <option value="Christian">Christian</option>
                                <option value="Other">Other</option>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2">
                              <select id="age" name="age" class="form-control">
                                <option value="">Select Age</option>
                                <option value="18-22">18-22 Years</option>
                                <option value="23-27">23-27 Years</option>
                                <option value="28-32">28-32 Years</option>
                                <option value="33-37">33-37 Years</option>
                                <option value="38-42">38-42 Years</option>
                                <option value="43-47">43-47 Years</option>
                                <option value="48-52">48-52 Years</option>
                                <option value="53-57">53-57 Years</option>
                                <option value="58-60">58-60 Years</option>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2">
                              <select id="marital_status" name="marital_status" class="form-control">
                                <option value="">Select Marital Status</option>
                                <option value="1">Single</option>
                                <option value="2">Married</option>
                                <option value="3">Divorced</option>
                                <option value="4">Widowed</option>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2">
                              <select id="experience" name="experience" class="form-control">
                                <option value="">Select Experience</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2">
                              <select id="partners" name="partners" class="form-control">
                                <option value="">Choose Partner</option>
                                <option value="BMG">BMG</option>
                                <option value="Alkaba">ALKABA</option>
                                <option value="My">MY</option>
                                <option value="Adey">ADEY</option>
                                <option value="Estella">Estella</option>
                                <option value="Edith">Edith</option>
                                <option value="Khalid">Khalid</option>
                                <option value="Ritemerit">Ritemerit</option>
                              </select>
                            </div>
                            <div class="col-md-6 mb-2">
                              <select id="sales_name" name="sales_name" class="form-control">
                                <option value="">Choose Sales Name</option>
                                <?php $__currentLoopData = $salesOfficers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOfficer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($salesOfficer->id); ?>"> <?php echo e($salesOfficer->first_name); ?> <?php echo e($salesOfficer->last_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                          </div>
                          <div class="d-flex justify-content-end mt-3">
                            <button id="clear_filters" type="button" class="btn btn-warning me-2" style="font-size:12px"><i class="fas fa-redo"></i> Reset</button>
                            <button id="export_excel" type="button" class="btn btn-success me-2" style="font-size:12px"><i class="fas fa-file-excel"></i> Export</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php if(session('success')): ?>
              <div class="alert alert-success"> <?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
              <div class="alert alert-danger"> <?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <div class="row mt-2">
              <div class="col-lg-12">
                <ul class="nav nav-tabs" id="statusTabs" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab-all" data-bs-toggle="tab" href="#tabpane-all" role="tab" aria-controls="tabpane-all" aria-selected="true"><i class="bi bi-list"></i>All <span class="badge bg-info"> <?php echo e($c['all'] ?? 0); ?></span></a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tab-draft" data-bs-toggle="tab" href="#tabpane-draft" role="tab" aria-controls="tabpane-draft" aria-selected="true">
                      <i class="bi bi-pencil-square"></i>
                      Draft
                      <span class="badge bg-info"><?php echo e($c['Draft'] ?? ($c['draft'] ?? 0)); ?></span>
                    </a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-available" data-bs-toggle="tab" href="#tabpane-available" role="tab" aria-controls="tabpane-available" aria-selected="false"><i class="bi bi-check-circle"></i>Available <span class="badge bg-info"> <?php echo e($c['Available'] ?? 0); ?></span></a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-backout" data-bs-toggle="tab" href="#tabpane-backout" role="tab" aria-controls="tabpane-backout" aria-selected="false"><i class="bi bi-x-circle"></i>Back Out <span class="badge bg-info"> <?php echo e($c['Back Out'] ?? 0); ?></span></a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-hold" data-bs-toggle="tab" href="#tabpane-hold" role="tab" aria-controls="tabpane-hold" aria-selected="false"><i class="bi bi-pause-circle"></i>Hold <span class="badge bg-info"> <?php echo e($c['Hold'] ?? 0); ?></span></a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-onprocess" data-bs-toggle="tab" href="#tabpane-onprocess" role="tab" aria-controls="tabpane-onprocess" aria-selected="false"><i class="bi bi-hourglass-split"></i>On Process <span class="badge bg-info"> <?php echo e($sumOnProcess); ?></span></a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-arriveddate" data-bs-toggle="tab" href="#tabpane-arriveddate" role="tab" aria-controls="tabpane-arriveddate" aria-selected="false"><i class="bi bi-geo-alt"></i>Arrived Date <span class="badge bg-info"> <?php echo e($c['Arrived Date'] ?? 0); ?></span></a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-incident-after-arrival" data-bs-toggle="tab" href="#tabpane-incident-after-arrival" role="tab" aria-controls="tabpane-incident-after-arrival" aria-selected="false"><i class="bi bi-exclamation-triangle-fill"></i>Incident After Arrival <span class="badge bg-info"> <?php echo e($c['Incident After Arrival (IAA)'] ?? 0); ?></span></a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-transferdate" data-bs-toggle="tab" href="#tabpane-transferdate" role="tab" aria-controls="tabpane-transferdate" aria-selected="false"><i class="bi bi-arrow-left-right"></i>Transfer Date <span class="badge bg-info"> <?php echo e($c['Transfer Date'] ?? 0); ?></span></a>
                  </li>
                </ul>

                <div class="subtabs-wrap" id="onProcessSubTabsWrap">
                  <ul class="nav" id="onProcessSubTabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-sub="Selected" id="sub-selected" href="#"><i class="bi bi-check-circle-fill"></i> Selected <span class="badge bg-secondary ms-1"> <?php echo e($c['Selected'] ?? 0); ?></span></a></li>
                    <li class="nav-item"><a class="nav-link" data-sub="WC-Date" id="sub-wc-date" href="#"><i class="bi bi-calendar-date"></i> WC Date <span class="badge bg-secondary ms-1"> <?php echo e($c['WC-Date'] ?? 0); ?></span></a></li>
                    <li class="nav-item"><a class="nav-link" data-sub="Incident Before Visa (IBV)" id="sub-ibv" href="#"><i class="bi bi-exclamation-circle"></i> Incident Before Visa <span class="badge bg-secondary ms-1"> <?php echo e($c['Incident Before Visa (IBV)'] ?? 0); ?></span></a></li>
                    <li class="nav-item"><a class="nav-link" data-sub="Visa Date" id="sub-visa-date" href="#"><i class="bi bi-calendar-check"></i> Visa Date <span class="badge bg-secondary ms-1"> <?php echo e($c['Visa Date'] ?? 0); ?></span></a></li>
                    <li class="nav-item"><a class="nav-link" data-sub="Incident After Visa (IAV)" id="sub-iav" href="#"><i class="bi bi-exclamation-diamond"></i> Incident After Visa <span class="badge bg-secondary ms-1"> <?php echo e($c['Incident After Visa (IAV)'] ?? 0); ?></span></a></li>
                    <li class="nav-item"><a class="nav-link" data-sub="Medical Status" id="sub-medical" href="#"><i class="bi bi-heart-pulse"></i> Medical Status <span class="badge bg-secondary ms-1"> <?php echo e($c['Medical Status'] ?? 0); ?></span></a></li>
                    <li class="nav-item"><a class="nav-link" data-sub="COC-Status" id="sub-coc" href="#"><i class="bi bi-briefcase"></i> COC Status <span class="badge bg-secondary ms-1"> <?php echo e($c['COC-Status'] ?? 0); ?></span></a></li>
                    <li class="nav-item"><a class="nav-link" data-sub="MoL Submitted Date" id="sub-mol-sub" href="#"><i class="bi bi-upload"></i> MOL Submitted Date <span class="badge bg-secondary ms-1"> <?php echo e($c['MoL Submitted Date'] ?? 0); ?></span></a></li>
                    <li class="nav-item"><a class="nav-link" data-sub="MoL Issued Date" id="sub-mol-iss" href="#"><i class="bi bi-file-earmark-check"></i> MOL Issued Date <span class="badge bg-secondary ms-1"> <?php echo e($c['MoL Issued Date'] ?? 0); ?></span></a></li>
                    <li class="nav-item">
                      <a class="nav-link" id="sub-departure-date" data-sub="Departure Date" href="#" title="Departure Date">
                        <i class="bi bi-calendar-check" aria-hidden="true"></i>
                        <span class="ms-1">Departure Date</span>
                        <span class="badge bg-secondary ms-2"><?php echo e($c['Departure Date'] ?? 0); ?></span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="sub-iad" data-sub="Incident After Departure (IAD)" href="#" title="Incident After Departure (IAD)">
                        <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                        <span class="ms-1">Incident After Departure</span>
                        <span class="badge bg-secondary ms-2"><?php echo e($c['Incident After Departure (IAD)'] ?? 0); ?></span>
                      </a>
                    </li>

                  </ul>
                </div>

                <div class="tab-content" id="statusTabsContent">
                  <div class="tab-pane fade show active" id="tabpane-all" role="tabpanel" aria-labelledby="tab-all"></div>
                  <div class="tab-pane fade" id="tabpane-draft" role="tabpanel" aria-labelledby="tab-draft"></div>
                  <div class="tab-pane fade" id="tabpane-available" role="tabpanel" aria-labelledby="tab-available"></div>
                  <div class="tab-pane fade" id="tabpane-backout" role="tabpanel" aria-labelledby="tab-backout"></div>
                  <div class="tab-pane fade" id="tabpane-hold" role="tabpanel" aria-labelledby="tab-hold"></div>
                  <div class="tab-pane fade" id="tabpane-onprocess" role="tabpanel" aria-labelledby="tab-onprocess"></div>
                  <div class="tab-pane fade" id="tabpane-arriveddate" role="tabpanel" aria-labelledby="tab-arriveddate"></div>
                  <div class="tab-pane fade" id="tabpane-incident-after-arrival" role="tabpanel" aria-labelledby="tab-incident-after-arrival"></div>
                  <div class="tab-pane fade" id="tabpane-transferdate" role="tabpanel" aria-labelledby="tab-transferdate"></div>
                </div>
              </div>
            </div>

            <div class="table-responsive" id="candidate_table_outside"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<div id="selectedModal" class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="selectedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="selectedModalLabel"><i class="fas fa-box-open text-light"></i> Select Candidate</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:#fff"></button>
      </div>

      <form id="agreement_form" method="POST" enctype="multipart/form-data" style="overflow-y:scroll;">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

        <div class="modal-body">
          <div class="card border-info mb-3">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-clipboard-list"></i> Select Package and Client</h5>

              <div class="row g-3 mb-3">
                <div class="col-md-4">
                  <label for="PackageOutside"><i class="fas fa-cube"></i> Select Package</label>
                  <select id="PackageOutside" name="package" class="form-control">
                    <option value="">Select Package</option>
                    <option value="PKG-1">PKG-1</option>
                    <option value="PKG-2">PKG-2</option>
                    <option value="PKG-3">PKG-3</option>
                    <option value="PKG-4">PKG-4</option>
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="clientDropdownOutside"><i class="fas fa-user"></i> Select Client</label>
                  <select id="clientDropdownOutside" name="client_id" class="form-control select2"></select>
                </div>

                <div class="col-md-4">
                  <label for="emiratesId"><i class="fas fa-id-card"></i> Emirates ID</label>
                  <input type="text" id="emiratesId" name="emirates_id" class="form-control" placeholder="Enter Emirates ID" readonly>
                </div>
              </div>

              <div class="row g-3 mb-4">
                <div class="col-md-4">
                  <label for="VisaTypeOutside"><i class="fas fa-passport"></i> Select Visa Type</label>
                  <select id="VisaTypeOutside" name="visa_type" class="form-control">
                    <option value="">Select Visa Type</option>
                    <option value="D-SPO">D-SPO</option>
                    <option value="D-HIRE">D-HIRE</option>
                    <option value="TADBEER">TADBEER</option>
                    <option value="TOURIST">TOURIST</option>
                    <option value="VISIT">VISIT</option>
                    <option value="OFFICE-VISA">OFFICE-VISA</option>
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="contractDuration"><i class="fas fa-calendar-alt"></i> Contract Duration</label>
                  <select id="contractDuration" name="contract_duration" class="form-control">
                    <option value="">Select Duration</option>
                    <?php for($i=1;$i<=24;$i++): ?>
                      <option value="<?php echo e($i); ?>"><?php echo e($i); ?> Month<?php echo e($i>1?'s':''); ?></option>
                    <?php endfor; ?>
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="contractEndDate"><i class="fas fa-calendar-check"></i> Contract End Date</label>
                  <input type="text" id="contractEndDate" name="contract_end_date" class="form-control" readonly>
                </div>
              </div>

              <div class="row mb-3" id="convertRow" style="display:none;">
                <div class="col-12">
                  <button type="button" id="convertToEmployeeBtn" class="btn btn-warning w-100"><i class="fas fa-user-check"></i> Convert to Employee</button>
                </div>
              </div>
            </div>
          </div>

          <div id="hideableSection">
            <div class="card border-info mb-3">
              <div class="card-body">
                <h5 class="card-title"><i class="fas fa-money-check-alt"></i> Office Transaction</h5>
                <div class="alert alert-info mb-3"><i class="fas fa-info-circle"></i> Enter full amount including VAT.</div>

                <div class="row g-3 mb-3">
                  <div class="col-lg-4 col-md-6">
                    <label for="officeTotalAmount"><i class="fas fa-calculator"></i> Total Amount</label>
                    <input type="text" id="officeTotalAmount" name="office_total_amount" class="form-control" value="0" required>
                  </div>

                  <div class="col-lg-4 col-md-6">
                    <label for="officeReceivedAmount"><i class="fas fa-hand-holding-usd"></i> Received Amount</label>
                    <input type="text" id="officeReceivedAmount" name="office_received_amount" class="form-control" value="0" required>
                  </div>

                  <div class="col-lg-4 col-md-6">
                    <label for="officeRemainingAmount"><i class="fas fa-balance-scale"></i> Remaining Amount</label>
                    <input type="text" id="officeRemainingAmount" name="office_remaining_amount" class="form-control" readonly>
                  </div>
                </div>

                <input type="hidden" id="officeVatAmount" name="office_vat_amount" value="0">
                <input type="hidden" id="officeNetAmount" name="office_net_amount" value="0">
                <input type="hidden" id="office_amount_type" name="office_amount_type" value="full">

                <div class="row g-3 mb-3">
                  <div class="col-lg-4 col-md-6">
                    <label for="officePaymentMethod"><i class="fas fa-wallet"></i> Payment Method</label>
                    <select id="officePaymentMethod" name="office_payment_method" class="form-control">
                      <option value="" selected>Select Payment Method</option>
                      <option value="Bank Transfer ADIB">Bank Transfer ADIB</option>
                      <option value="Bank Transfer ADCB">Bank Transfer ADCB</option>
                      <option value="POS ADCB">POS ADCB</option>
                      <option value="POS ADIB">POS ADIB</option>
                      <option value="Cash">Cash</option>
                      <option value="Cheque">Cheque</option>
                      <option value="METTPAY">METTPAY</option>
                      <option value="Replacement">Replacement</option>
                    </select>
                  </div>

                  <div class="col-lg-4 col-md-6" id="monthlyPaymentRow" style="display:none;">
                    <label for="monthlyPayment"><i class="fas fa-calendar-alt"></i> Monthly Payment</label>
                    <input type="number" id="monthlyPayment" name="monthly_payment" class="form-control" min="0" value="0">
                  </div>

                  <div class="col-lg-4 col-md-6" id="paymentCycleRow" style="display:none;">
                    <label for="paymentCycle"><i class="fas fa-sync-alt"></i> Payment Cycle</label>
                    <select id="paymentCycle" name="payment_cycle" class="form-control">
                      <option value="" selected>Select Cycle</option>
                      <option value="LUMSUM">LUMSUM</option>
                      <option value="1">1 Month</option>
                      <option value="2">2 Months</option>
                      <option value="3">3 Months</option>
                      <option value="4">4 Months</option>
                      <option value="5">5 Months</option>
                      <option value="6">6 Months</option>
                      <option value="7">7 Months</option>
                      <option value="8">8 Months</option>
                      <option value="9">9 Months</option>
                      <option value="10">10 Months</option>
                      <option value="11">11 Months</option>
                      <option value="12">12 Months</option>
                    </select>
                  </div>

                  <div class="col-lg-4 col-md-6" id="officePaymentProofRow" style="display:none;">
                    <label for="officePaymentProof"><i class="fas fa-upload"></i> Payment Proof</label>
                    <input type="file" id="officePaymentProof" name="office_payment_proof" class="form-control">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-12">
                    <button type="button" id="generateInstallments" class="btn btn-primary w-100" style="display:none;"><i class="fas fa-cogs"></i> Generate Installments</button>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-12">
                    <table class="table table-bordered" id="officeInstallmentsTable" style="display:none;">
                      <thead class="table-primary">
                        <tr>
                          <th>#</th>
                          <th>Description</th>
                          <th>Amount</th>
                          <th>Payment Date</th>
                        </tr>
                      </thead>
                      <tbody id="officeInstallmentRows"></tbody>
                    </table>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <label for="officePaymentNotes"><i class="fas fa-sticky-note"></i> Payment Notes</label>
                    <textarea id="officePaymentNotes" name="office_notes" class="form-control" placeholder="Optional notes"></textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="card border-info mb-3">
              <div class="card-body">
                <h5 class="card-title"><i class="fas fa-money-check-alt"></i> Govt. Transaction</h5>

                <div class="row g-3 mb-3">
                  <div class="col-md-4">
                    <label for="govtPaymentMethod"><i class="fas fa-wallet"></i> Payment Method</label>
                    <select id="govtPaymentMethod" name="govt_payment_method" class="form-control">
                      <option value="" selected>Select Payment Method</option>
                      <option value="Bank Transfer ADIB">Bank Transfer ADIB</option>
                      <option value="Bank Transfer ADCB">Bank Transfer ADCB</option>
                      <option value="POS ADCB">POS ADCB</option>
                      <option value="POS ADIB">POS ADIB</option>
                      <option value="Cash">Cash</option>
                      <option value="Cheque">Cheque</option>
                      <option value="METTPAY">METTPAY</option>
                      <option value="Replacement">Replacement</option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label for="govtServiceSelect"><i class="fas fa-search"></i> Select Service</label>
                    <select id="govtServiceSelect" name="govt_service" class="form-control select2">
                      <option value="">Search and Select Service</option>
                      <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($service->service_name); ?>"><?php echo e($service->service_name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label for="govtTotalAmount"><i class="fas fa-calculator"></i> Total Amount</label>
                    <input type="text" id="govtTotalAmount" name="govt_total_amount" class="form-control" value="0" required>
                  </div>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-md-4">
                    <label for="govtReceivedAmount"><i class="fas fa-hand-holding-usd"></i> Received Amount</label>
                    <input type="text" id="govtReceivedAmount" name="govt_received_amount" class="form-control" value="0" required>
                  </div>

                  <div class="col-md-4">
                    <label for="govtRemainingAmount"><i class="fas fa-balance-scale"></i> Remaining Amount</label>
                    <input type="text" id="govtRemainingAmount" name="govt_remaining_amount" class="form-control" readonly>
                  </div>

                  <div class="col-md-4">
                    <label for="govtVatAmount"><i class="fas fa-percentage"></i> VAT Amount</label>
                    <input type="text" id="govtVatAmount" name="govt_vat_amount" class="form-control" value="0">
                  </div>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-md-4">
                    <label for="govtNetAmount"><i class="fas fa-money-check"></i> Net Amount</label>
                    <input type="text" id="govtNetAmount" name="govt_net_amount" class="form-control" readonly>
                  </div>

                  <div class="col-md-8" id="govtPaymentProofWrap" style="display:none;">
                    <label for="govtPaymentProof"><i class="fas fa-upload"></i> Upload Payment Proof</label>
                    <input type="file" id="govtPaymentProof" name="govt_payment_proof" class="form-control">
                  </div>
                </div>
              </div>
            </div>

            <div class="card border-secondary mb-3">
              <div class="card-body">
                <h5 class="card-title"><i class="fas fa-file-medical"></i> Medical Certificate</h5>
                <div class="row">
                  <div class="col-12">
                    <label for="medicalCertificate"><i class="fas fa-upload"></i> Upload Medical Certificate</label>
                    <input type="file" id="medicalCertificate" name="medical_certificate" class="form-control">
                  </div>
                </div>
              </div>
            </div>

            <div class="card border-success mb-3">
              <div class="card-body">
                <h5 class="card-title"><i class="fas fa-file-signature"></i> Create Agreement</h5>

                <div class="row g-3 mb-3">
                  <div class="col-lg-6">
                    <label for="selectedModalcandidateName"><i class="fas fa-user"></i> Candidate</label>
                    <input type="text" id="selectedModalcandidateName" name="candidate_name" class="form-control" readonly>

                    <input type="hidden" id="selectedModalcandidateId" name="candidate_id">
                    <input type="hidden" id="selectedModalreferenceNo" name="reference_no">
                    <input type="hidden" id="selectedModalrefNo" name="ref_no">
                    <input type="hidden" id="selectedModalforeignPartner" name="foreign_partner">
                    <input type="hidden" id="selectedModalcandiateNationality" name="candidate_nationality">
                    <input type="hidden" id="selectedModalcandidatePassportNumber" name="candidate_passport_number">
                    <input type="hidden" id="selectedModalcandidatePassportExpiry" name="candidate_passport_expiry">
                    <input type="hidden" id="selectedModalcandidateDOB" name="candidate_dob">
                  </div>

                  <div class="col-lg-6">
                    <label for="agreementTypeOutside"><i class="fas fa-file"></i> Agreement Type</label>
                    <select id="agreementTypeOutside" name="agreement_type" class="form-control">
                      <option value="">Select Agreement Type</option>
                      <option value="BOA" selected>Booking Outside Agreement (BOA)</option>
                    </select>
                  </div>
                </div>

                <div class="row g-3 mb-3">
                  <div class="col-lg-6">
                    <label for="expectedArrivalDateOutside"><i class="fas fa-calendar"></i> Expected Arrival Date</label>
                    <input type="date" id="expectedArrivalDateOutside" name="expected_arrival_date" class="form-control" min="<?php echo e(date('Y-m-d')); ?>">
                  </div>

                  <div class="col-lg-6">
                    <label for="agreedSalaryOutside"><i class="fas fa-coins"></i> Agreed Salary</label>
                    <input type="text" id="agreedSalaryOutside" name="agreed_salary" class="form-control" placeholder="Enter Salary">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveChanges" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade custom-modal" id="IncidentBeforeVisaModal" tabindex="-1" aria-labelledby="IncidentBeforeVisaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="incidentForm" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="IncidentBeforeVisaLabel"><i class="fas fa-file-alt text-light"></i> Incident Before Visa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="IncidentBeforeVisaModalcandidateName"><i class="fas fa-user text-default"></i> Candidate <span class="text-danger">*</span></label>
              <input type="text" id="IncidentBeforeVisaModalcandidateName" name="candidate_name" class="form-control form-control-sm" readonly>

              <input type="hidden" id="IncidentBeforeVisaModalcandidateId" name="candidate_id">
              <input type="hidden" id="IncidentBeforeVisaModalreferenceNo" name="candidate_reference_no">
              <input type="hidden" id="IncidentBeforeVisaModalrefNo" name="candidate_ref_no">
              <input type="hidden" id="IncidentBeforeVisaModalforeignPartner" name="foreign_partner">
              <input type="hidden" id="IncidentBeforeVisaModalcandiateNationality" name="candidate_nationality">
              <input type="hidden" id="IncidentBeforeVisaModalcandidatePassportNumber" name="candidate_passport_number">
              <input type="hidden" id="IncidentBeforeVisaModalcandidatePassportExpiry" name="candidate_passport_expiry">
              <input type="hidden" id="IncidentBeforeVisaModalcandidateDOB" name="candidate_dob">
            </div>

            <div class="col-lg-6">
              <label for="IncidentBeforeVisaModalclient_name"><i class="fas fa-building text-default"></i> Employer Name <span class="text-danger">*</span></label>
              <input type="text" id="IncidentBeforeVisaModalclient_name" name="employer_name" class="form-control form-control-sm" readonly>
            </div>
          </div>

          <div class="mb-3">
            <label for="incidentCategoryBeforeVisa" class="form-label"><strong><i class="fas fa-exclamation-circle"></i> Category</strong></label>
            <input type="text" id="incidentCategoryBeforeVisa" name="incident_category" class="form-control" value="Incident Before Visa" readonly>
          </div>

          <div class="mb-3">
            <label for="beforeVisaReason" class="form-label"><strong><i class="fas fa-list-alt"></i> Select Reason</strong></label>
            <select id="beforeVisaReason" name="incident_reason" class="form-select" required>
              <option value="">Select Reason</option>
              <option value="Black List">Black List</option>
              <option value="Document Required">Document Required</option>
              <option value="Valid Resident">Valid Resident</option>
              <option value="Valid Visa">Valid Visa</option>
              <option value="Sponsor File Issue">Sponsor File Issue</option>
              <option value="Other">Other</option>
            </select>

            <div id="otherBeforeVisaReason" class="mt-2" style="display:none;">
              <label for="otherReasonInputBeforeVisa" class="form-label"><strong><i class="fas fa-pen"></i> Specify Reason</strong></label>
              <input type="text" id="otherReasonInputBeforeVisa" name="other_reason" class="form-control" placeholder="Write reason here">
            </div>

            <div id="expiryDateDiv" class="mb-3" style="display:none;margin-top:10px;">
              <label for="expiryDateInput" class="form-label"><strong><i class="fas fa-calendar-alt"></i> Expiry Date of Incident</strong></label>
              <input type="date" id="expiryDateInput" name="incident_expiry_date" class="form-control">
            </div>
          </div>

          <div class="card border-warning mb-3 incident-agreement-card">
            <div class="card-body">
              <div class="incident-agreement-head">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                  <h6 class="m-0 fw-semibold">
                    <i class="fas fa-file-contract me-1"></i>
                    <span id="IncidentBeforeVisaModaldecision_title">Refund</span> Agreement Details
                  </h6>
                </div>
              </div>

              <div class="incident-decision-wrap">
                <div class="form-check">
                  <input class="form-check-input incident-decision" type="checkbox" id="IncidentBeforeVisaModaldecisionRefund" name="customer_decision" value="Refund" data-modal="#IncidentBeforeVisaModal" checked>
                  <label class="form-check-label" for="IncidentBeforeVisaModaldecisionRefund">Refund</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input incident-decision" type="checkbox" id="IncidentBeforeVisaModaldecisionReplacement" name="customer_decision" value="Replacement" data-modal="#IncidentBeforeVisaModal">
                  <label class="form-check-label" for="IncidentBeforeVisaModaldecisionReplacement">Replacement</label>
                </div>
              </div>

              <input type="hidden" id="IncidentBeforeVisaModalagreement_id" name="agreement_id">
              <input type="hidden" id="IncidentBeforeVisaModalagreement_reference_no" name="agreement_reference_no">
              <input type="hidden" id="IncidentBeforeVisaModalagreement_type" name="agreement_type">
              <input type="hidden" id="IncidentBeforeVisaModalagreement_client_id" name="agreement_client_id">

              <div id="IncidentBeforeVisaModalrefundSection" class="mt-2">
                <div class="table-responsive">
                  <table class="table table-bordered align-middle mb-0 incident-agreement-table">
                    <tbody>
                      <tr>
                        <th style="width:45%;">Agreement Reference No</th>
                        <td><input type="text" id="IncidentBeforeVisaModalagreement_reference_no_text" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Contract Start Date</th>
                        <td><input type="text" id="IncidentBeforeVisaModalagreement_start_date" name="agreement_start_date" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Contract End Date</th>
                        <td><input type="text" id="IncidentBeforeVisaModalagreement_end_date" name="agreement_end_date" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Total Amount</th>
                        <td><input type="text" id="IncidentBeforeVisaModalcontracted_amount" name="contracted_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Received Amount</th>
                        <td><input type="text" id="IncidentBeforeVisaModalreceived_amount" name="received_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>VAT Amount</th>
                        <td><input type="text" id="IncidentBeforeVisaModalvat_amount" name="vat_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Remaining Amount</th>
                        <td><input type="text" id="IncidentBeforeVisaModalremaining_amount" name="remaining_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Office Charges</th>
                        <td><input type="text" id="IncidentBeforeVisaModaloffice_charges" name="office_charges" class="form-control form-control-sm incident-office-charges" data-modal="#IncidentBeforeVisaModal" value="0"></td>
                      </tr>

                      <tr>
                        <th><span id="IncidentBeforeVisaModalbalance_label">Refund Balance</span></th>
                        <td><input type="text" id="IncidentBeforeVisaModalbalance_amount" name="balance_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th><span id="IncidentBeforeVisaModaldue_label">Refund Due Date</span></th>
                        <td><input type="text" id="IncidentBeforeVisaModalrefund_due_date" name="refund_due_date" class="form-control form-control-sm incident-refund-due" data-modal="#IncidentBeforeVisaModal" autocomplete="off"></td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="incidentProofBeforeVisa" class="form-label"><strong><i class="fas fa-upload"></i> Upload Incident Proof</strong></label>
            <input type="file" id="incidentProofBeforeVisa" name="proof" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
          </div>

          <div class="mb-3">
            <label for="IncidentBeforeVisaremarks" class="form-label"><strong><i class="fas fa-comment-dots"></i> Add Remark (Optional)</strong></label>
            <textarea id="IncidentBeforeVisaremarks" name="IncidentBeforeVisaremarks" class="form-control" rows="4" placeholder="Write your remarks here..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveIncident" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade custom-modal" id="WcDateModal" tabindex="-1" aria-labelledby="updateWcDateLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="#" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateWcDateLabel"><i class="fas fa-calendar-alt"></i> Update WC Date</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="WcDateModalcandidateName" class="form-label"><strong><i class="fas fa-user"></i> Candidate Name</strong></label>
              <input type="text" id="WcDateModalcandidateName" class="form-control form-control-sm" readonly>

              <input type="hidden" id="WcDateModalcandidateId">
              <input type="hidden" id="WcDateModalreferenceNo">
              <input type="hidden" id="WcDateModalrefNo">
              <input type="hidden" id="WcDateModalforeignPartner">
              <input type="hidden" id="WcDateModalcandiateNationality">
              <input type="hidden" id="WcDateModalcandidatePassportNumber">
              <input type="hidden" id="WcDateModalcandidatePassportExpiry">
              <input type="hidden" id="WcDateModalcandidateDOB">
            </div>

            <div class="col-lg-6">
              <label for="WcDateModalclient_name" class="form-label"><strong><i class="fas fa-building"></i> Employer Name</strong></label>
              <input type="text" name="employer_name" id="WcDateModalclient_name" class="form-control form-control-sm" readonly>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="wcDate" class="form-label"><i class="fas fa-calendar-day"></i> WC Date</label>
              <input type="date" id="wcDate" class="form-control" name="wc_date" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>">
            </div>

            <div class="col-lg-6">
              <label for="dw_number" class="form-label"><i class="fas fa-clock"></i> DW Number</label>
              <input type="text" id="dw_number" class="form-control" name="dw_number">
            </div>
          </div>

          <div class="mb-3">
            <label for="wcContractFile" class="form-label"><i class="fas fa-file-upload"></i> Upload WC Contract File (Only PDF Format)</label>
            <input type="file" id="wcContractFile" class="form-control" accept="application/pdf">
          </div>

          <div class="mb-3">
            <label for="WcDateModalremarks" class="form-label"><strong><i class="fas fa-comment-dots"></i> Add Remark (Optional)</strong></label>
            <textarea id="WcDateModalremarks" name="WcDateModalremarks" class="form-control" rows="4" placeholder="Write your remarks here..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="save_wc_date" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade custom-modal" id="VisaDateModal" tabindex="-1" aria-labelledby="updateVisaDateLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="visaForm" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateVisaDateLabel"><i class="fas fa-passport text-light"></i> Update Visa Date</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="VisaDateModalcandidateName" class="form-label"><i class="fas fa-user text-default"></i> Candidate Name</label>
              <input type="text" id="VisaDateModalcandidateName" name="candidate_name" class="form-control form-control-sm" readonly>

              <input type="hidden" id="VisaDateModalcandidateId" name="candidate_id">
              <input type="hidden" id="VisaDateModalreferenceNo" name="candidate_reference_no">
              <input type="hidden" id="VisaDateModalrefNo" name="candidate_ref_no">
              <input type="hidden" id="VisaDateModalforeignPartner" name="foreign_partner">
              <input type="hidden" id="VisaDateModalcandiateNationality" name="candidate_nationality">
              <input type="hidden" id="VisaDateModalcandidatePassportNumber" name="candidate_passport_number">
              <input type="hidden" id="VisaDateModalcandidatePassportExpiry" name="candidate_passport_expiry">
              <input type="hidden" id="VisaDateModalcandidateDOB" name="candidate_dob">
            </div>

            <div class="col-lg-6">
              <label for="VisaDateModalclient_name" class="form-label"><i class="fas fa-building text-default"></i> Employer Name</label>
              <input type="text" id="VisaDateModalclient_name" name="employer_name" class="form-control form-control-sm" readonly>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="visaDate" class="form-label"><i class="fas fa-calendar-day"></i> Visa Date</label>
              <input type="date" id="visaDate" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>" class="form-control" name="visa_date" required>
            </div>

            <div class="col-lg-6">
              <label for="visaNumber" class="form-label"><i class="fas fa-file-alt"></i> Visa Number (Optional)</label>
              <input type="text" id="visaNumber" class="form-control" name="visa_number" placeholder="Enter Visa Number">
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="visaExpiryDate" class="form-label"><i class="fas fa-calendar-times"></i> Visa Expiry Date</label>
              <input type="date" id="visaExpiryDate" class="form-control" name="visa_expiry_date" required>
            </div>

            <div class="col-lg-6">
              <label for="uidNumber" class="form-label"><i class="fas fa-id-badge text-primary"></i> U.I.D No. <span class="text-danger">*</span></label>
              <input type="text" id="uidNumber" class="form-control" name="uid_number" placeholder="Enter U.I.D No." required>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="entryPermitNumber" class="form-label"><i class="fas fa-file-contract text-success"></i> Entry Permit No. <span class="text-danger">*</span></label>
              <input type="text" id="entryPermitNumber" class="form-control" name="entry_permit_number" placeholder="Enter Entry Permit No." required>
            </div>

            <div class="col-lg-6">
              <label for="visaCopy" class="form-label"><i class="fas fa-upload"></i> Upload Visa Copy</label>
              <input type="file" id="visaCopy" class="form-control" name="visa_copy" accept="application/pdf" required>
              <small class="text-muted">Only PDF files are allowed.</small>
            </div>
          </div>

          <div class="mb-3">
            <label for="VisaDateModalremarks" class="form-label"><strong><i class="fas fa-comment-dots"></i> Add Remark (Optional)</strong></label>
            <textarea id="VisaDateModalremarks" name="VisaDateModalremarks" class="form-control" rows="4" placeholder="Write your remarks here..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveVisaDetails" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade custom-modal" id="IncidentAfterVisaModal" tabindex="-1" aria-labelledby="IncidentAfterVisaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="incidentAfterVisaForm" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="IncidentAfterVisaLabel"><i class="fas fa-file-alt text-light"></i> Incident After Visa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="IncidentAfterVisaModalcandidateName" class="form-label"><i class="fas fa-user text-default"></i> Candidate Name</label>
              <input type="text" id="IncidentAfterVisaModalcandidateName" name="candidate_name" class="form-control form-control-sm" readonly>

              <input type="hidden" id="IncidentAfterVisaModalcandidateId" name="candidate_id">
              <input type="hidden" id="IncidentAfterVisaModalreferenceNo" name="candidate_reference_no">
              <input type="hidden" id="IncidentAfterVisaModalrefNo" name="candidate_ref_no">
              <input type="hidden" id="IncidentAfterVisaModalforeignPartner" name="foreign_partner">
              <input type="hidden" id="IncidentAfterVisaModalcandiateNationality" name="candidate_nationality">
              <input type="hidden" id="IncidentAfterVisaModalcandidatePassportNumber" name="candidate_passport_number">
              <input type="hidden" id="IncidentAfterVisaModalcandidatePassportExpiry" name="candidate_passport_expiry">
              <input type="hidden" id="IncidentAfterVisaModalcandidateDOB" name="candidate_dob">
            </div>

            <div class="col-lg-6">
              <label for="IncidentAfterVisaModalclient_name" class="form-label"><i class="fas fa-building text-default"></i> Employer Name</label>
              <input type="text" id="IncidentAfterVisaModalclient_name" name="employer_name" class="form-control form-control-sm" readonly>
            </div>
          </div>

          <div class="mb-3">
            <label for="incidentCategoryAfterVisa" class="form-label"><strong><i class="fas fa-exclamation-circle"></i> Category</strong></label>
            <input type="text" id="incidentCategoryAfterVisa" name="incident_category" class="form-control" value="Incident After Visa" readonly>
          </div>

          <div class="mb-3">
            <label for="afterVisaReason" class="form-label"><strong><i class="fas fa-list-ul"></i> Select Reason</strong></label>
            <select id="afterVisaReason" name="incident_reason" class="form-select">
              <option value="">Select Reason</option>
              <option value="Pregnant">Pregnant</option>
              <option value="Unfit">Unfit</option>
              <option value="Accident">Accident</option>
              <option value="Married">Married</option>
              <option value="Phone Out of Service">Phone Out of Service</option>
              <option value="Refused to Travel">Refused to Travel</option>
              <option value="Not Ready to Travel Now">Not Ready to Travel Now</option>
              <option value="Other">Other</option>
            </select>

            <div id="otherAfterVisaReason" class="mt-2" style="display:none;">
              <label for="otherReasonInputAfterVisa" class="form-label"><strong><i class="fas fa-pen"></i> Specify Reason</strong></label>
              <input type="text" id="otherReasonInputAfterVisa" name="other_reason" class="form-control" placeholder="Write reason here">
            </div>
          </div>

          <div class="card border-warning mb-3 incident-agreement-card">
            <div class="card-body">
              <div class="incident-agreement-head">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                  <h6 class="m-0 fw-semibold">
                    <i class="fas fa-file-contract me-1"></i>
                    <span id="IncidentAfterVisaModaldecision_title">Refund</span> Agreement Details
                  </h6>
                </div>
              </div>

              <div class="incident-decision-wrap">
                <div class="form-check">
                  <input class="form-check-input incident-decision" type="checkbox" id="IncidentAfterVisaModaldecisionRefund" name="customer_decision" value="Refund" data-modal="#IncidentAfterVisaModal" checked>
                  <label class="form-check-label" for="IncidentAfterVisaModaldecisionRefund">Refund</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input incident-decision" type="checkbox" id="IncidentAfterVisaModaldecisionReplacement" name="customer_decision" value="Replacement" data-modal="#IncidentAfterVisaModal">
                  <label class="form-check-label" for="IncidentAfterVisaModaldecisionReplacement">Replacement</label>
                </div>
              </div>

              <input type="hidden" id="IncidentAfterVisaModalagreement_id" name="agreement_id">
              <input type="hidden" id="IncidentAfterVisaModalagreement_reference_no" name="agreement_reference_no">
              <input type="hidden" id="IncidentAfterVisaModalagreement_type" name="agreement_type">
              <input type="hidden" id="IncidentAfterVisaModalagreement_client_id" name="agreement_client_id">

              <div id="IncidentAfterVisaModalrefundSection" class="mt-2">
                <div class="table-responsive">
                  <table class="table table-bordered align-middle mb-0 incident-agreement-table">
                    <tbody>
                      <tr>
                        <th style="width:45%;">Agreement Reference No</th>
                        <td><input type="text" id="IncidentAfterVisaModalagreement_reference_no_text" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Contract Start Date</th>
                        <td><input type="text" id="IncidentAfterVisaModalagreement_start_date" name="agreement_start_date" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Contract End Date</th>
                        <td><input type="text" id="IncidentAfterVisaModalagreement_end_date" name="agreement_end_date" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Total Amount</th>
                        <td><input type="text" id="IncidentAfterVisaModalcontracted_amount" name="contracted_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Received Amount</th>
                        <td><input type="text" id="IncidentAfterVisaModalreceived_amount" name="received_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>VAT Amount</th>
                        <td><input type="text" id="IncidentAfterVisaModalvat_amount" name="vat_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Remaining Amount</th>
                        <td><input type="text" id="IncidentAfterVisaModalremaining_amount" name="remaining_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Office Charges</th>
                        <td><input type="text" id="IncidentAfterVisaModaloffice_charges" name="office_charges" class="form-control form-control-sm incident-office-charges" data-modal="#IncidentAfterVisaModal" value="0"></td>
                      </tr>

                      <tr>
                        <th><span id="IncidentAfterVisaModalbalance_label">Refund Balance</span></th>
                        <td><input type="text" id="IncidentAfterVisaModalbalance_amount" name="balance_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th><span id="IncidentAfterVisaModaldue_label">Refund Due Date</span></th>
                        <td><input type="text" id="IncidentAfterVisaModalrefund_due_date" name="refund_due_date" class="form-control form-control-sm incident-refund-due" data-modal="#IncidentAfterVisaModal" autocomplete="off"></td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="incidentProofAfterVisa" class="form-label"><strong><i class="fas fa-upload"></i> Upload Incident Proof</strong></label>
            <input type="file" id="incidentProofAfterVisa" name="proof" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
          </div>

          <div class="mb-3">
            <label for="IncidentAfterVisaModalremarks" class="form-label"><strong><i class="fas fa-comment-dots"></i> Add Remark (Optional)</strong></label>
            <textarea id="IncidentAfterVisaModalremarks" name="IncidentAfterVisaModalremarks" class="form-control" rows="4" placeholder="Write your remarks here..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveIncidentAfterVisa" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade custom-modal" id="updateArrivedDateModal" tabindex="-1" aria-labelledby="updateArrivedDateLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="updateArrivedDateForm" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="status" id="updateArrivedDateStatus" value="Office">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateArrivedDateLabel"><i class="fas fa-plane-arrival text-light"></i> Update Arrived Date</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="alert alert-info d-flex align-items-start" role="alert">
            <i class="fas fa-info-circle me-2 mt-1"></i>
            <div><strong>Note:</strong> Please fill <b>ICP proof</b> and <b>Entry Permit Expiry Date</b>. After saving arrival details, this candidate will be saved in <b>Office</b> automatically.</div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="updateArrivedDateModalcandidateName" class="form-label"><i class="fas fa-user text-default"></i> Candidate Name</label>
              <input type="text" id="updateArrivedDateModalcandidateName" name="candidate_name" class="form-control form-control-sm" readonly>

              <input type="hidden" id="updateArrivedDateModalcandidateId" name="candidate_id">
              <input type="hidden" id="updateArrivedDateModalclientId" name="client_id">
              <input type="hidden" id="updateArrivedDateModalreferenceNo" name="reference_no">
              <input type="hidden" id="updateArrivedDateModalrefNo" name="ref_no">
              <input type="hidden" id="updateArrivedDateModalforeignPartner" name="foreign_partner">
              <input type="hidden" id="updateArrivedDateModalcandidateNationality" name="candidate_nationality">
              <input type="hidden" id="updateArrivedDateModalcandidatePassportNumber" name="candidate_passport_number">
              <input type="hidden" id="updateArrivedDateModalcandidateDOB" name="candidate_dob">
            </div>

            <div class="col-lg-6">
              <label for="updateArrivedDateModalclient_name" class="form-label"><i class="fas fa-building text-default"></i> Employer Name</label>
              <input type="text" id="updateArrivedDateModalclient_name" name="employer_name" class="form-control form-control-sm" readonly>
            </div>
          </div>

          <hr class="my-3">

          <div class="row g-3">
            <div class="col-md-6">
              <label for="arrivedDate" class="form-label"><i class="fas fa-calendar-day"></i> Arrival Date <span class="text-danger">*</span></label>
              <input type="date" id="arrivedDate" name="arrived_date" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="candidatePassportExpiry" class="form-label"><i class="fas fa-hourglass-end"></i> Entry Permit Expiry Date <span class="text-danger">*</span></label>
              <input type="date" id="candidatePassportExpiry" name="candidate_passport_expiry" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label for="ticketFile" class="form-label"><i class="fas fa-ticket-alt"></i> Ticket <span class="text-danger">*</span></label>
              <input type="file" id="ticketFile" name="ticket_attachment" class="form-control" accept="image/*,application/pdf" required>
            </div>

            <div class="col-md-6">
              <label for="passportStampImage" class="form-label"><i class="fas fa-passport"></i> Immigration Entry Stamp <span class="text-danger">*</span></label>
              <input type="file" id="passportStampImage" name="passport_stamp_image" class="form-control" accept="image/*" required>
            </div>

            <div class="col-md-6">
              <label for="icpProofFile" class="form-label"><i class="fas fa-file-upload"></i> ICP Proof <span class="text-danger">*</span></label>
              <input type="file" id="icpProofFile" name="icp_proof_attachment" class="form-control" accept="image/*,application/pdf" required>
            </div>

            <div class="col-md-6">
              <label for="icpNumber" class="form-label"><i class="fas fa-id-card"></i> ICP Reference / Number</label>
              <input type="text" id="icpNumber" name="icp_number" class="form-control" placeholder="Enter ICP reference number (if any)">
            </div>
          </div>

          <div class="mb-3 mt-3">
            <label for="updateArrivedDateModalremarks" class="form-label"><strong><i class="fas fa-comment-dots"></i> Add Remark (Optional)</strong></label>
            <textarea id="updateArrivedDateModalremarks" name="remarks" class="form-control" rows="4" placeholder="Write your remarks here..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="submit" id="saveArrivedDate" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade custom-modal" id="IncidentAfterArrivalModal" tabindex="-1" aria-labelledby="IncidentAfterArrivalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="incidentAfterArrivalForm" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="IncidentAfterArrivalLabel"><i class="fas fa-file-alt text-light"></i> Incident After Arrival</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="IncidentAfterArrivalModalcandidateName" class="form-label"><i class="fas fa-user text-default"></i> Candidate Name</label>
              <input type="text" id="IncidentAfterArrivalModalcandidateName" name="candidate_name" class="form-control form-control-sm" readonly>

              <input type="hidden" id="IncidentAfterArrivalModalcandidateId" name="candidate_id">
              <input type="hidden" id="IncidentAfterArrivalModalreferenceNo" name="reference_no">
              <input type="hidden" id="IncidentAfterArrivalModalrefNo" name="ref_no">
              <input type="hidden" id="IncidentAfterArrivalModalforeignPartner" name="foreign_partner">
              <input type="hidden" id="IncidentAfterArrivalModalcandiateNationality" name="candidate_nationality">
              <input type="hidden" id="IncidentAfterArrivalModalcandidatePassportNumber" name="candidate_passport_number">
              <input type="hidden" id="IncidentAfterArrivalModalcandidatePassportExpiry" name="candidate_passport_expiry">
              <input type="hidden" id="IncidentAfterArrivalModalcandidateDOB" name="candidate_dob">
            </div>

            <div class="col-lg-6">
              <label for="IncidentAfterArrivalModalclient_name" class="form-label"><i class="fas fa-building text-default"></i> Employer Name</label>
              <input type="text" id="IncidentAfterArrivalModalclient_name" name="employer_name" class="form-control form-control-sm" readonly>
            </div>
          </div>

          <div class="mb-3">
            <label for="incidentCategoryAfterArrival" class="form-label"><strong><i class="fas fa-exclamation-circle"></i> Select Reason</strong></label>
            <select id="incidentCategoryAfterArrival" name="incident_reason" class="form-select">
              <option value="">Select Reason</option>
              <option value="Run Away">Run Away</option>
              <option value="Unfit">Unfit</option>
              <option value="Sick">Sick</option>
              <option value="Psychological Illness">Psychological Illness</option>
              <option value="Repatriation">Repatriation</option>
              <option value="Refused to Work">Refused to Work</option>
              <option value="Family Issue">Family Issue</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div id="otherAfterArrivalReason" style="display:none;" class="mb-3">
            <label for="otherReasonInputAfterArrival" class="form-label"><strong>Specify Reason</strong></label>
            <input type="text" id="otherReasonInputAfterArrival" name="other_reason" class="form-control" placeholder="Write specific reason here">
          </div>

          <div class="card border-warning mb-3 incident-agreement-card">
            <div class="card-body">
              <div class="incident-agreement-head">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                  <h6 class="m-0 fw-semibold">
                    <i class="fas fa-file-contract me-1"></i>
                    <span id="IncidentAfterArrivalModaldecision_title">Refund</span> Agreement Details
                  </h6>
                </div>
              </div>

              <div class="incident-decision-wrap">
                <div class="form-check">
                  <input class="form-check-input incident-decision" type="checkbox" id="IncidentAfterArrivalModaldecisionRefund" name="customer_decision" value="Refund" data-modal="#IncidentAfterArrivalModal" checked>
                  <label class="form-check-label" for="IncidentAfterArrivalModaldecisionRefund">Refund</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input incident-decision" type="checkbox" id="IncidentAfterArrivalModaldecisionReplacement" name="customer_decision" value="Replacement" data-modal="#IncidentAfterArrivalModal">
                  <label class="form-check-label" for="IncidentAfterArrivalModaldecisionReplacement">Replacement</label>
                </div>
              </div>

              <input type="hidden" id="IncidentAfterArrivalModalagreement_id" name="agreement_id">
              <input type="hidden" id="IncidentAfterArrivalModalagreement_reference_no" name="agreement_reference_no">
              <input type="hidden" id="IncidentAfterArrivalModalagreement_type" name="agreement_type">
              <input type="hidden" id="IncidentAfterArrivalModalagreement_client_id" name="agreement_client_id">

              <div id="IncidentAfterArrivalModalrefundSection" class="mt-2">
                <div class="table-responsive">
                  <table class="table table-bordered align-middle mb-0 incident-agreement-table">
                    <tbody>
                      <tr>
                        <th style="width:45%;">Agreement Reference No</th>
                        <td><input type="text" id="IncidentAfterArrivalModalagreement_reference_no_text" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Contract Start Date</th>
                        <td><input type="text" id="IncidentAfterArrivalModalagreement_start_date" name="agreement_start_date" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Contract End Date</th>
                        <td><input type="text" id="IncidentAfterArrivalModalagreement_end_date" name="agreement_end_date" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Total Amount</th>
                        <td><input type="text" id="IncidentAfterArrivalModalcontracted_amount" name="contracted_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Received Amount</th>
                        <td><input type="text" id="IncidentAfterArrivalModalreceived_amount" name="received_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>VAT Amount</th>
                        <td><input type="text" id="IncidentAfterArrivalModalvat_amount" name="vat_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Remaining Amount</th>
                        <td><input type="text" id="IncidentAfterArrivalModalremaining_amount" name="remaining_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Office Charges</th>
                        <td><input type="text" id="IncidentAfterArrivalModaloffice_charges" name="office_charges" class="form-control form-control-sm incident-office-charges" data-modal="#IncidentAfterArrivalModal" value="0"></td>
                      </tr>

                      <tr>
                        <th><span id="IncidentAfterArrivalModalbalance_label">Refund Balance</span></th>
                        <td><input type="text" id="IncidentAfterArrivalModalbalance_amount" name="balance_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th><span id="IncidentAfterArrivalModaldue_label">Refund Due Date</span></th>
                        <td><input type="text" id="IncidentAfterArrivalModalrefund_due_date" name="refund_due_date" class="form-control form-control-sm incident-refund-due" data-modal="#IncidentAfterArrivalModal" autocomplete="off"></td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="incidentProofAfterArrival" class="form-label"><strong><i class="fas fa-upload"></i> Upload Incident Proof</strong></label>
            <input type="file" id="incidentProofAfterArrival" name="proof" class="form-control" accept=".pdf,.png,.jpg,.jpeg">
          </div>

          <div class="mb-3">
            <label for="IncidentAfterArrivalModalremarks" class="form-label"><strong><i class="fas fa-comment-dots"></i> Add Remark (Optional)</strong></label>
            <textarea id="IncidentAfterArrivalModalremarks" name="IncidentAfterArrivalModalremarks" class="form-control" rows="4" placeholder="Write your remarks here..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveIncidentAfterArrival" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade custom-modal" id="IncidentAfterDepartureModal" tabindex="-1" aria-labelledby="IncidentAfterDepartureLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="incidentAfterDepartureForm" method="POST" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="IncidentAfterDepartureLabel"><i class="fas fa-file-alt text-light"></i> Incident After Departure</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="IncidentAfterDepartureModalcandidateName" class="form-label"><i class="fas fa-user text-default"></i> Candidate Name</label>
              <input type="text" id="IncidentAfterDepartureModalcandidateName" name="candidate_name" class="form-control form-control-sm" readonly>

              <input type="hidden" id="IncidentAfterDepartureModalcandidateId" name="candidate_id">
              <input type="hidden" id="IncidentAfterDepartureModalreferenceNo" name="reference_no">
              <input type="hidden" id="IncidentAfterDepartureModalrefNo" name="ref_no">
              <input type="hidden" id="IncidentAfterDepartureModalforeignPartner" name="foreign_partner">
              <input type="hidden" id="IncidentAfterDepartureModalcandiateNationality" name="candidate_nationality">
              <input type="hidden" id="IncidentAfterDepartureModalcandidatePassportNumber" name="candidate_passport_number">
              <input type="hidden" id="IncidentAfterDepartureModalcandidatePassportExpiry" name="candidate_passport_expiry">
              <input type="hidden" id="IncidentAfterDepartureModalcandidateDOB" name="candidate_dob">
            </div>

            <div class="col-lg-6">
              <label for="IncidentAfterDepartureModalclient_name" class="form-label"><i class="fas fa-building text-default"></i> Employer Name</label>
              <input type="text" id="IncidentAfterDepartureModalclient_name" name="employer_name" class="form-control form-control-sm" readonly>
            </div>
          </div>

          <div class="mb-3">
            <label for="incidentCategoryAfterDeparture" class="form-label"><strong><i class="fas fa-exclamation-circle"></i> Select Reason</strong></label>
            <select id="incidentCategoryAfterDeparture" name="incident_reason" class="form-select">
              <option value="">Select Reason</option>
              <option value="Canceled">Canceled</option>
              <option value="Client Not Responding">Client Not Responding</option>
              <option value="Candidate Not Responding">Candidate Not Responding</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div id="otherAfterDepartureReason" style="display:none;" class="mb-3">
            <label for="otherReasonInputAfterDeparture" class="form-label"><strong>Specify Reason</strong></label>
            <input type="text" id="otherReasonInputAfterDeparture" name="other_reason" class="form-control" placeholder="Write specific reason here">
          </div>

          <div class="card border-warning mb-3 incident-agreement-card">
            <div class="card-body">
              <div class="incident-agreement-head">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                  <h6 class="m-0 fw-semibold">
                    <i class="fas fa-file-contract me-1"></i>
                    <span id="IncidentAfterDepartureModaldecision_title">Refund</span> Agreement Details
                  </h6>
                </div>
              </div>

              <div class="incident-decision-wrap">
                <div class="form-check">
                  <input class="form-check-input incident-decision" type="checkbox" id="IncidentAfterDepartureModaldecisionRefund" name="customer_decision" value="Refund" data-modal="#IncidentAfterDepartureModal" checked>
                  <label class="form-check-label" for="IncidentAfterDepartureModaldecisionRefund">Refund</label>
                </div>

                <div class="form-check">
                  <input class="form-check-input incident-decision" type="checkbox" id="IncidentAfterDepartureModaldecisionReplacement" name="customer_decision" value="Replacement" data-modal="#IncidentAfterDepartureModal">
                  <label class="form-check-label" for="IncidentAfterDepartureModaldecisionReplacement">Replacement</label>
                </div>
              </div>

              <input type="hidden" id="IncidentAfterDepartureModalagreement_id" name="agreement_id">
              <input type="hidden" id="IncidentAfterDepartureModalagreement_reference_no" name="agreement_reference_no">
              <input type="hidden" id="IncidentAfterDepartureModalagreement_type" name="agreement_type">
              <input type="hidden" id="IncidentAfterDepartureModalagreement_client_id" name="agreement_client_id">

              <div id="IncidentAfterDepartureModalrefundSection" class="mt-2">
                <div class="table-responsive">
                  <table class="table table-bordered align-middle mb-0 incident-agreement-table">
                    <tbody>
                      <tr>
                        <th style="width:45%;">Agreement Reference No</th>
                        <td><input type="text" id="IncidentAfterDepartureModalagreement_reference_no_text" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Contract Start Date</th>
                        <td><input type="text" id="IncidentAfterDepartureModalagreement_start_date" name="agreement_start_date" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Contract End Date</th>
                        <td><input type="text" id="IncidentAfterDepartureModalagreement_end_date" name="agreement_end_date" class="form-control form-control-sm no-flatpickr" readonly></td>
                      </tr>

                      <tr>
                        <th>Total Amount</th>
                        <td><input type="text" id="IncidentAfterDepartureModalcontracted_amount" name="contracted_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Received Amount</th>
                        <td><input type="text" id="IncidentAfterDepartureModalreceived_amount" name="received_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>VAT Amount</th>
                        <td><input type="text" id="IncidentAfterDepartureModalvat_amount" name="vat_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Remaining Amount</th>
                        <td><input type="text" id="IncidentAfterDepartureModalremaining_amount" name="remaining_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th>Office Charges</th>
                        <td><input type="text" id="IncidentAfterDepartureModaloffice_charges" name="office_charges" class="form-control form-control-sm incident-office-charges" data-modal="#IncidentAfterDepartureModal" value="0"></td>
                      </tr>

                      <tr>
                        <th><span id="IncidentAfterDepartureModalbalance_label">Refund Balance</span></th>
                        <td><input type="text" id="IncidentAfterDepartureModalbalance_amount" name="balance_amount" class="form-control form-control-sm" readonly></td>
                      </tr>

                      <tr>
                        <th><span id="IncidentAfterDepartureModaldue_label">Refund Due Date</span></th>
                        <td><input type="text" id="IncidentAfterDepartureModalrefund_due_date" name="refund_due_date" class="form-control form-control-sm incident-refund-due" data-modal="#IncidentAfterDepartureModal" autocomplete="off"></td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="incidentProofAfterDeparture" class="form-label"><strong><i class="fas fa-upload"></i> Upload Incident Proof</strong></label>
            <input type="file" id="incidentProofAfterDeparture" name="proof" class="form-control" accept=".pdf,.png,.jpg,.jpeg">
          </div>

          <div class="mb-3">
            <label for="IncidentAfterDepartureModalremarks" class="form-label"><strong><i class="fas fa-comment-dots"></i> Add Remark (Optional)</strong></label>
            <textarea id="IncidentAfterDepartureModalremarks" name="IncidentAfterDepartureModalremarks" class="form-control" rows="4" placeholder="Write your remarks here..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveIncidentAfterDeparture" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade custom-modal" id="TransferDateModal" tabindex="-1" aria-labelledby="TransferDateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TransferDateModalLabel"><i class="fas fa-exchange-alt text-light"></i> Update Transfer Date</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="transferDateForm" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-lg-6">
              <label for="TransferDateModalcandidateName" class="form-label"><i class="fas fa-user text-default"></i> Candidate Name</label>
              <input type="text" id="TransferDateModalcandidateName" class="form-control form-control-sm" readonly>

              <input type="hidden" id="TransferDateModalcandidateId" name="candidate_id">
              <input type="hidden" id="TransferDateModalclientId" name="client_id">
              <input type="hidden" id="TransferDateModalreferenceNo" name="reference_no">
              <input type="hidden" id="TransferDateModalrefNo" name="ref_no">
              <input type="hidden" id="TransferDateModalforeignPartner" name="foreign_partner">
              <input type="hidden" id="TransferDateModalcandiateNationality" name="candidate_nationality">
              <input type="hidden" id="TransferDateModalcandidatePassportNumber" name="candidate_passport_number">
              <input type="hidden" id="TransferDateModalcandidatePassportExpiry" name="candidate_passport_expiry">
              <input type="hidden" id="TransferDateModalcandidateDOB" name="candidate_dob">
            </div>

            <div class="col-lg-6">
              <label for="TransferDateModalclient_name" class="form-label"><i class="fas fa-building text-default"></i> Employer Name</label>
              <input type="text" id="TransferDateModalclient_name" name="employer_name" class="form-control form-control-sm">
            </div>
          </div>

          <div id="InvoiceData" class="mb-4"></div>

          <div class="mb-3">
            <label for="transferDate" class="form-label"><i class="fas fa-calendar-day"></i> Transfer Date</label>
            <input type="date" id="transferDate" name="transfer_date" class="form-control" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>">
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="remainingAmountOutside1" class="form-label"><i class="fas fa-balance-scale"></i> Remaining Amount</label>
              <input type="text" id="remainingAmountOutside1" name="remaining_amount" class="form-control" readonly>
            </div>

            <div class="col-md-6">
              <label for="receivedAmountOutside" class="form-label"><i class="fas fa-hand-holding-usd"></i> Received Amount</label>
              <input type="text" id="receivedAmountOutside" name="received_amount" class="form-control" value="0">
            </div>
          </div>

          <div class="mb-3">
            <label for="paymentMethodOutsideForTransfer" class="form-label"><i class="fas fa-credit-card"></i> Payment Method</label>
            <select id="paymentMethodOutsideForTransfer" name="payment_method" class="form-control">
              <option value="" selected>Select Payment Method</option>
              <option value="Bank Transfer ADIB">Bank Transfer ADIB</option>
              <option value="Bank Transfer ADCB">Bank Transfer ADCB</option>
              <option value="POS ADCB">POS ADCB</option>
              <option value="POS ADIB">POS ADIB</option>
              <option value="Cash">Cash</option>
              <option value="Cheque">Cheque</option>
              <option value="METTPAY">METTPAY</option>
              <option value="Replacement">Replacement</option>
            </select>
          </div>

          <div class="mb-3" id="TransferProofWrap" style="display:none;">
            <label for="TransferDateModalpaymentProofOutside" class="form-label"><i class="fas fa-upload"></i> Upload Payment Proof</label>
            <input type="file" id="TransferDateModalpaymentProofOutside" name="payment_proof" class="form-control" accept=".png,.jpg,.jpeg,.pdf">
            <div id="proofAlert" class="alert alert-warning mt-2" style="display:none;">Please upload payment proof for transactions.</div>
          </div>

          <div class="mb-3">
            <label for="TransferDateModalremarks" class="form-label"><strong><i class="fas fa-comment-dots"></i> Add Remark (Optional)</strong></label>
            <textarea id="TransferDateModalremarks" name="transfer_date_remark" class="form-control" rows="4" placeholder="Write your remarks here..."></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
          <button type="button" id="saveTransferDateButton" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="attachmentsModal" tabindex="-1" aria-labelledby="attachmentsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary text-white">
        <h5 class="modal-title" id="attachmentsModalLabel">Attachments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body scrollable-modal-body">
        <p class="text-center text-muted">Loading attachments...</p>
      </div>
    </div>
  </div>
</div>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script type="text/javascript">
(function ($) {
  "use strict";

  let currentFilter = "all";
  let currentSubFilter = null;

  const normalize = (v) => String(v || "").trim().toLowerCase();

  const statusNameToId =
    <?php echo json_encode(
      collect($currentStatuses ?? [])
        ->mapWithKeys(fn($s) => [mb_strtolower(trim($s->status_name)) => (int) $s->id])
    ); ?> || {};

  statusNameToId["draft"] = 0;

  const STATUS_TAB_ID_TO_NAME = {
    "tab-all": "all",
    "tab-draft": "draft",
    "tab-available": "Available",
    "tab-backout": "Back Out",
    "tab-hold": "Hold",
    "tab-onprocess": "on-process",
    "tab-arriveddate": "Arrived Date",
    "tab-incident-after-arrival": "Incident After Arrival (IAA)",
    "tab-transferdate": "Transfer Date"
  };

  const STATUS_NAME_TO_TAB_ID = {
    "all": "#tab-all",
    "draft": "#tab-draft",
    "Available": "#tab-available",
    "Back Out": "#tab-backout",
    "Hold": "#tab-hold",
    "on-process": "#tab-onprocess",
    "Arrived Date": "#tab-arriveddate",
    "Incident After Arrival (IAA)": "#tab-incident-after-arrival",
    "Transfer Date": "#tab-transferdate"
  };

  function ensureSpinStyle() {
    if (document.getElementById("preloader-spin-style")) return;
    const styleTag = document.createElement("style");
    styleTag.id = "preloader-spin-style";
    styleTag.textContent = "@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}";
    document.head.appendChild(styleTag);
  }

  function showPreloader() {
    if (document.getElementById("preloader")) return;
    ensureSpinStyle();
    const preloader =
      '<div id="preloader" class="preloader-container">' +
        '<div class="preloader-content">' +
          '<div class="spinner"></div>' +
          "<p>Loading...</p>" +
        "</div>" +
      "</div>";
    document.body.insertAdjacentHTML("beforeend", preloader);
    const el = document.getElementById("preloader");
    Object.assign(el.style, {
      position: "fixed",
      top: "0",
      left: "0",
      width: "100%",
      height: "100%",
      backgroundColor: "rgba(255,255,255,.8)",
      display: "flex",
      justifyContent: "center",
      alignItems: "center",
      zIndex: "1050"
    });
    const sp = el.querySelector(".spinner");
    Object.assign(sp.style, {
      width: "50px",
      height: "50px",
      border: "6px solid rgba(0,0,0,.1)",
      borderTopColor: "#007bff",
      borderRadius: "50%",
      animation: "spin 1s linear infinite",
      marginBottom: "10px"
    });
  }

  function hidePreloader() {
    const p = document.getElementById("preloader");
    if (p) p.remove();
  }

  function setTabState(status, sub) {
    try {
      const url = new URL(window.location.href);
      url.searchParams.set("tab", status || "all");
      if (status === "on-process") url.searchParams.set("sub", sub || "Selected");
      else url.searchParams.delete("sub");
      history.replaceState({}, "", url.toString());
    } catch (_) {}
    try {
      localStorage.setItem("candidates_tab", status || "all");
      localStorage.setItem("candidates_sub", status === "on-process" ? (sub || "Selected") : "");
    } catch (_) {}
  }

  function getTabState() {
    let tab = "all";
    let sub = null;

    try {
      const url = new URL(window.location.href);
      tab = url.searchParams.get("tab") || tab;
      sub = url.searchParams.get("sub") || sub;
    } catch (_) {}

    if ((!tab || tab === "all") && (sub === null || sub === "")) {
      try {
        const t = localStorage.getItem("candidates_tab");
        const s = localStorage.getItem("candidates_sub");
        if (t) tab = t;
        if (s) sub = s;
      } catch (_) {}
    }

    tab = String(tab || "all").trim();
    if (tab !== "on-process") sub = null;
    if (tab === "on-process" && (!sub || sub === "null")) sub = "Selected";

    return { tab, sub };
  }

  function setHiddenFields(tabName, statusId) {
    const tabNameEl = document.getElementById("tab_name_hidden");
    const statusIdEl = document.getElementById("current_status_id_hidden");
    if (tabNameEl) tabNameEl.value = tabName || "";
    if (statusIdEl) statusIdEl.value = statusId === null || statusId === undefined ? "" : String(statusId);
  }

  function resolveStatusId(tabName) {
    const key = normalize(tabName);
    if (Object.prototype.hasOwnProperty.call(statusNameToId, key)) return statusNameToId[key];
    return null;
  }

  function buildRequestData(status, sub_status) {
    const tabName = sub_status ? sub_status : status;
    const statusId = resolveStatusId(tabName);

    setHiddenFields(tabName, statusId);

    const formArray = $("#filter_form_outside").serializeArray();
    formArray.push({ name: "filter", value: status });
    formArray.push({ name: "sub_filter", value: sub_status || "" });
    formArray.push({ name: "current_status_id", value: statusId === null ? "" : String(statusId) });
    formArray.push({ name: "tab_name", value: tabName });

    const globalVal = $("#global_search_input").val() || "";
    formArray.push({ name: "global_search", value: globalVal });

    return $.param(formArray);
  }

  function loadCandidates(status = "all", sub_status = null) {
    currentFilter = status;
    currentSubFilter = sub_status;
    setTabState(status, sub_status);

    showPreloader();
    $.ajax({
      url: '<?php echo e(route("candidates.index")); ?>',
      type: "GET",
      data: buildRequestData(status, sub_status),
      success: function (response) {
        $("#candidate_table_outside").html(response);
        hidePreloader();
      },
      error: function () {
        hidePreloader();
        alert("Error loading candidates. Please try again.");
      }
    });
  }

  function loadCandidatesWithUrl(url, status = "all", sub_status = null) {
    currentFilter = status;
    currentSubFilter = sub_status;
    setTabState(status, sub_status);

    showPreloader();
    $.ajax({
      url: url,
      type: "GET",
      data: buildRequestData(status, sub_status),
      success: function (r) {
        $("#candidate_table_outside").html(r);
        hidePreloader();
      },
      error: function () {
        hidePreloader();
        alert("Error loading candidates. Please try again.");
      }
    });
  }

  function debounce(fn, delay) {
    let t;
    return function () {
      const c = this, a = arguments;
      clearTimeout(t);
      t = setTimeout(function () { fn.apply(c, a); }, delay);
    };
  }

  function activateTabUI(status, sub) {
    $("#statusTabs .nav-link").removeClass("active");
    $("#onProcessSubTabs .nav-link").removeClass("active");

    if (status === "on-process") {
      $("#onProcessSubTabsWrap").show();
      const tabSel = STATUS_NAME_TO_TAB_ID["on-process"] || "#tab-onprocess";
      $(tabSel).addClass("active").tab("show");

      const useSub = sub || "Selected";
      const $subLink = $('#onProcessSubTabs .nav-link[data-sub="' + useSub + '"]');
      if ($subLink.length) $subLink.addClass("active");
      else $("#onProcessSubTabs #sub-selected").addClass("active");
    } else {
      $("#onProcessSubTabsWrap").hide();
      const tabSel = STATUS_NAME_TO_TAB_ID[status] || "#tab-all";
      $(tabSel).addClass("active").tab("show");
    }
  }

  function allowOnlyNumbers(selector) {
    $(document)
      .off("input.allowOnlyNumbers", selector)
      .on("input.allowOnlyNumbers", selector, function () {
        const sanitizedValue = String($(this).val() || "").replace(/[^0-9]/g, "");
        $(this).val(sanitizedValue);
      });
  }

  function parseNumOrNaN(v) {
    const s = String(v ?? "").trim();
    if (s === "") return NaN;
    return parseFloat(s);
  }

  function hasFile($input) {
    const el = $input && $input[0];
    return !!(el && el.files && el.files.length);
  }

  function startOfLocalDay(d) {
    const x = d ? new Date(d) : new Date();
    return new Date(x.getFullYear(), x.getMonth(), x.getDate());
  }

  function fmtYMD(date) {
    const d = new Date(date);
    const y = d.getFullYear();
    const m = String(d.getMonth() + 1).padStart(2, "0");
    const day = String(d.getDate()).padStart(2, "0");
    return `${y}-${m}-${day}`;
  }

  function parseYMD(value) {
    const s = String(value || "").trim();
    if (!s) return null;
    const parts = s.split("-");
    if (parts.length !== 3) return null;
    const y = parseInt(parts[0], 10);
    const m = parseInt(parts[1], 10) - 1;
    const d = parseInt(parts[2], 10);
    if (!y || m < 0 || d < 1) return null;
    return new Date(y, m, d);
  }

  const MIN_REFUND_DAYS = 7;

  function minRefundDate() {
    const d = startOfLocalDay(new Date());
    d.setDate(d.getDate() + MIN_REFUND_DAYS);
    return d;
  }

  function isSunday(dateObj) {
    return dateObj && dateObj.getDay && dateObj.getDay() === 0;
  }

  function safeToastrError(msg) {
    if (window.toastr && typeof window.toastr.error === "function") window.toastr.error(msg);
    else alert(msg);
  }

  function safeToastrSuccess(msg) {
    if (window.toastr && typeof window.toastr.success === "function") window.toastr.success(msg);
    else alert(msg);
  }

  function setInputValue($el, val) {
    if (!$el || !$el.length) return;
    const v = val === undefined || val === null ? "" : String(val);
    const el = $el[0];

    if (el && el._flatpickr) {
      try {
        if (!v) {
          el._flatpickr.clear();
        } else {
          el._flatpickr.setDate(v, true, "Y-m-d");
        }
        return;
      } catch (_) {}
    }

    $el.val(v);
    if ($el.is("select")) $el.trigger("change");
  }

  function findField(modalId, suffixOrName) {
    const modalKey = modalId.replace("#", "");
    const $m = $(modalId);

    const byId = $("#" + modalKey + suffixOrName);
    if (byId.length) return byId;

    const byName = $m.find('[name="' + suffixOrName + '"]');
    if (byName.length) return byName;

    return $();
  }

  function setFieldInModal(modalId, key, value) {
    const $f = findField(modalId, key);
    if ($f.length) {
      setInputValue($f, value);
      return true;
    }
    return false;
  }

  function pickAgreement(details) {
    if (!details) return null;
    if (details.agreement) return details.agreement;
    if (details.current_agreement) return details.current_agreement;
    if (details.active_agreement) return details.active_agreement;
    if (details.latest_agreement) return details.latest_agreement;
    return null;
  }

  function setAgreementRefUI(modalId, refNo) {
    const modalKey = modalId.replace("#", "");
    const $m = $(modalId);
    const ref = refNo ? String(refNo) : "";

    const ids = [
      "#" + modalKey + "agreement_reference_no",
      "#" + modalKey + "agreement_reference_no_view",
      "#" + modalKey + "agreement_reference_no_text",
      "#" + modalKey + "agreement_ref_no",
      "#" + modalKey + "agreementRefNo",
      "#" + modalKey + "agreementReferenceNo"
    ];

    let done = false;
    ids.forEach((sel) => {
      const $x = $(sel);
      if ($x.length) {
        if ($x.is("input,select,textarea")) setInputValue($x, ref);
        else $x.text(ref);
        done = true;
      }
    });

    if (!done) {
      const $place = $m.find(".agreement-reference-no,.agreement-ref-no,[data-agreement-ref]");
      if ($place.length) $place.text(ref);
    }
  }

  function populateAgreementDetails(modalId, details) {
    const a = pickAgreement(details) || {};

    const refNo = a.reference_no ?? a.referenceNo ?? a.ref_no ?? a.refNo ?? a.agreement_reference_no ?? "";
    const agrId = a.id ?? a.agreement_id ?? a.agreementId ?? "";
    const start = a.contract_start_date ?? a.start_date ?? a.contractStartDate ?? a.agreement_start_date ?? "";
    const end = a.contract_end_date ?? a.end_date ?? a.contractEndDate ?? a.agreement_end_date ?? "";
    const total = a.total_amount ?? a.total ?? a.totalAmount ?? a.contracted_amount ?? a.contract_amount ?? "";
    const received = a.received_amount ?? a.received ?? a.receivedAmount ?? "";
    const remaining = a.remaining_amount ?? a.remaining ?? a.remainingAmount ?? "";
    const remainingVat = a.remaining_amount_with_vat ?? a.remainingAmountWithVat ?? "";

    setAgreementRefUI(modalId, refNo);

    setFieldInModal(modalId, "agreement_id", agrId);
    setFieldInModal(modalId, "agreement_reference_no", refNo);
    setFieldInModal(modalId, "agreement_ref_no", refNo);
    setFieldInModal(modalId, "reference_no", refNo);

    setFieldInModal(modalId, "contract_start_date", start);
    setFieldInModal(modalId, "contract_end_date", end);
    setFieldInModal(modalId, "agreement_start_date", start);
    setFieldInModal(modalId, "agreement_end_date", end);

    if (String(total) !== "") {
      setFieldInModal(modalId, "total_amount", total);
      setFieldInModal(modalId, "contracted_amount", total);
    }

    if (String(received) !== "") {
      setFieldInModal(modalId, "received_amount", received);
    }

    if (String(remaining) !== "") setFieldInModal(modalId, "remaining_amount", remaining);
    if (String(remainingVat) !== "") setFieldInModal(modalId, "remaining_amount_with_vat", remainingVat);

    recalcIncidentBalance(modalId);
  }

  function initRefundDueDatePicker(modalId) {
    const modalKey = modalId.replace("#", "");
    const $input = $("#" + modalKey + "refund_due_date");
    if (!$input.length) return;

    const minD = minRefundDate();

    const enforce = function () {
      const v = String($input.val() || "").trim();
      if (!v) return true;
      const d = parseYMD(v);
      if (!d) return false;

      if (isSunday(d)) {
        safeToastrError("Sunday is off and change your refund due date.");
        $input.val("");
        if ($input[0] && $input[0]._flatpickr) {
          try { $input[0]._flatpickr.clear(); } catch (_) {}
        }
        return false;
      }

      if (startOfLocalDay(d) < minD) {
        safeToastrError("Refund due date must be at least 7 days from today.");
        $input.val("");
        if ($input[0] && $input[0]._flatpickr) {
          try { $input[0]._flatpickr.clear(); } catch (_) {}
        }
        return false;
      }

      return true;
    };

    if (window.flatpickr && $input[0]) {
      try { if ($input[0]._flatpickr) $input[0]._flatpickr.destroy(); } catch (_) {}

      window.flatpickr($input[0], {
        dateFormat: "Y-m-d",
        minDate: minD,
        allowInput: true,
        disable: [
          function (date) { return date.getDay() === 0; }
        ],
        onChange: function (selectedDates) {
          const d = selectedDates && selectedDates[0] ? selectedDates[0] : null;
          if (!d) return;
          const local = startOfLocalDay(d);

          if (isSunday(local)) {
            safeToastrError("Sunday is off and change your refund due date.");
            try { $input[0]._flatpickr.clear(); } catch (_) { $input.val(""); }
            return;
          }

          if (local < minD) {
            safeToastrError("Refund due date must be at least 7 days from today.");
            try { $input[0]._flatpickr.clear(); } catch (_) { $input.val(""); }
            return;
          }
        },
        onClose: function () {
          enforce();
        }
      });
    } else {
      $input.attr("min", fmtYMD(minD));
      $input.off("change.refundDueDateEnforce").on("change.refundDueDateEnforce", enforce);
      $input.off("blur.refundDueDateEnforce").on("blur.refundDueDateEnforce", enforce);
    }
  }

  function setIncidentDecisionUI(modalId, decision) {
    const $m = $(modalId);
    const val = decision === "Replacement" ? "Replacement" : "Refund";

    const $refund = $m.find('.incident-decision[value="Refund"]');
    const $replacement = $m.find('.incident-decision[value="Replacement"]');

    $m.find(".incident-decision").prop("checked", false);
    if (val === "Replacement" && $replacement.length) $replacement.prop("checked", true);
    else if ($refund.length) $refund.prop("checked", true);

    const $section = $(`${modalId}refundSection`);
    if ($section.length) $section.show();

    const $label = $(`${modalId}balance_label`);
    if ($label.length) $label.text(val === "Replacement" ? "Replacement Balance" : "Refund Balance");

    const $dueWrapLabel = $m.find('label[for="' + modalId.replace("#", "") + 'refund_due_date"] strong');
    if ($dueWrapLabel.length) $dueWrapLabel.text(val === "Replacement" ? "Replacement Due Date" : "Refund Due Date");

    recalcIncidentBalance(modalId);
  }

  function recalcIncidentBalance(modalId) {
    const modalKey = modalId.replace("#", "");
    const $m = $(modalId);

    const $received = $("#" + modalKey + "received_amount");
    const $charges = $("#" + modalKey + "office_charges");
    const $balance = $("#" + modalKey + "balance_amount");
    const $label = $("#" + modalKey + "balance_label");

    const received = parseFloat($received.val()) || 0;
    const charges = parseFloat($charges.val()) || 0;

    const decision = $m.find(".incident-decision:checked").val() || "Refund";
    if ($label.length) $label.text(decision === "Replacement" ? "Replacement Balance" : "Refund Balance");

    if ($balance.length) $balance.val(Math.max(0, received - charges).toFixed(2));
  }

  function initIncidentModal(modalId, candidateDetails) {
    window.__candidateDetailsByModal = window.__candidateDetailsByModal || {};
    window.__candidateDetailsByModal[modalId] = candidateDetails || {};
    populateAgreementDetails(modalId, candidateDetails || {});
    initRefundDueDatePicker(modalId);
    setIncidentDecisionUI(modalId, "Refund");
    recalcIncidentBalance(modalId);
  }

  function validateRefundDueDateForModal(modalId) {
    const modalKey = modalId.replace("#", "");
    const $m = $(modalId);
    const $due = $("#" + modalKey + "refund_due_date");

    const decision = $m.find(".incident-decision:checked").val() || "Refund";
    if (decision !== "Refund") return true;

    const v = String($due.val() || "").trim();
    if (!v) {
      safeToastrError("Refund due date is required.");
      $due.focus();
      return false;
    }

    const d = parseYMD(v);
    if (!d) {
      safeToastrError("Refund due date is invalid.");
      $due.focus();
      return false;
    }

    const minD = minRefundDate();

    if (isSunday(d)) {
      safeToastrError("Sunday is off and change your refund due date.");
      $due.val("");
      try { if ($due[0] && $due[0]._flatpickr) $due[0]._flatpickr.clear(); } catch (_) {}
      $due.focus();
      return false;
    }

    if (startOfLocalDay(d) < minD) {
      safeToastrError("Refund due date must be at least 7 days from today.");
      $due.val("");
      try { if ($due[0] && $due[0]._flatpickr) $due[0]._flatpickr.clear(); } catch (_) {}
      $due.focus();
      return false;
    }

    return true;
  }

  window.confirmStatusChange = function (selectElement, candidateId, candidateFullName) {
    const selectedStatus = selectElement.options[selectElement.selectedIndex].text;
    Swal.fire({
      title: `Change status for ${candidateFullName}?`,
      text: `Do you want to change the status to "${selectedStatus}"?`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Yes, change it",
      cancelButtonText: "No, keep it"
    }).then((result) => { if (result.isConfirmed) { window.updateStatus(selectElement, candidateId); } });
  };

  window.updateStatus = function (selectElement, candidateId) {
    const statusId = selectElement.value;
    const csrfToken = $("meta[name='csrf-token']").attr("content");
    const updateStatusUrl = "<?php echo e(route('candidates.update-status',['candidate'=>':reference_no'])); ?>".replace(":reference_no", candidateId);

    $.ajax({
      url: updateStatusUrl,
      type: "POST",
      headers: { "X-CSRF-TOKEN": csrfToken },
      data: { status_id: statusId },
      dataType: "json",
      success: function (response) {
        if (!response.success) {
          safeToastrError(response.message || "Failed to update status. Please try again.");
          return;
        }

        if (response.statusColor) $(selectElement).css("background-color", response.statusColor);

        if (response.action === "open_modal" && response.modal) {
          const modalId = `#${response.modal}`;

          $(modalId)
            .off("shown.bs.modal.reinitSelect2")
            .on("shown.bs.modal.reinitSelect2", function () {
              const $dd = $(this).find("#clientDropdownOutside");
              if ($dd.length) {
                try { $dd.select2("destroy"); } catch (_) {}
                $dd.select2({
                  width: "100%",
                  dropdownParent: $(this),
                  placeholder: "Select Client",
                  allowClear: true
                });
              }
            })
            .modal("show");

          if (response.clients?.length) {
            window.populateDropdown($(modalId).find("#clientDropdownOutside"), response.clients, "id", (c) => `${c.first_name} ${c.last_name}`);
          }

          if (response.candidate_details) {
            window.populateModalFields(modalId, response.candidate_details);
            initIncidentModal(modalId, response.candidate_details);

            if (response.modal === "TransferDateModal") {
              const inv = response.candidate_details.invoices || [];
              let rows = "";

              if (inv.length) {
                inv.forEach((i) => {
                  const url = `/invoices/${i.invoice_number}`;
                  const vat = 0;
                  const total = parseFloat(i.total_amount) + vat;
                  rows += `
                    <tr>
                      <td>${i.invoice_date || "N/A"}</td>
                      <td>${(+i.total_amount).toFixed(2)}</td>
                      <td>${(+i.received_amount).toFixed(2)}</td>
                      <td>${(+i.total_amount - +i.received_amount).toFixed(2)}</td>
                      <td>${vat.toFixed(2)}</td>
                      <td>${total.toFixed(2)}</td>
                      <td><a href="${url}" target="_blank" class="btn btn-light btn-sm"><i class="fas fa-external-link-alt"></i> ${i.invoice_number}</a></td>
                    </tr>`;
                });

                $("#TransferDateModal #InvoiceData").html(`
                  <table class="table table-striped">
                    <thead>
                      <tr><th>Date</th><th>Total</th><th>Received</th><th>Remaining</th><th>VAT (5%)</th><th>Total</th><th>Invoice #</th></tr>
                    </thead>
                    <tbody>${rows}</tbody>
                  </table>`);

                $("#TransferDateModal #remainingAmountOutside1").val((+response.candidate_details.remainingAmountWithVat || 0).toFixed(2));
                $("#TransferDateModal #receivedAmountOutside").val("0");

                if (response.candidate_details.client_name !== "Tadbeer Sponsorship") $("#saveTransferDateButton").prop("disabled", false);
              } else {
                $("#TransferDateModal #InvoiceData").html('<p class="text-danger">There are no invoices paid against this agreement.</p>');
                $("#TransferDateModal #remainingAmountOutside1").val("0.00");
                $("#TransferDateModal #receivedAmountOutside").val("0");
              }
            }
          }
        } else {
          safeToastrSuccess(response.message || "Status has been updated successfully!");
          setTimeout(() => location.reload(), 1200);
        }
      },
      error: function () {
        safeToastrError("An error occurred. Please try again.");
      }
    });
  };

  window.populateDropdown = function (dropdown, data, valueKey, textCallback) {
    dropdown.empty().append('<option value="">Select Option</option>');
    data.forEach((item) => {
      const text = typeof textCallback === "function" ? textCallback(item) : item[textCallback];
      dropdown.append(`<option value="${item[valueKey]}" data-emirates-id="${item.emirates_id || ""}">${text}</option>`);
    });
  };

  window.populateModalFields = function (modalId, data) {
    Object.entries(data || {}).forEach(([key, value]) => {
      if (value && (typeof value === "object")) return;
      const fullFieldId = `${modalId.replace("#", "")}${key}`;
      const $field = $(`#${fullFieldId}`);
      if ($field.length) {
        setInputValue($field, value);
      } else {
        const $byName = $(modalId).find('[name="' + key + '"]');
        if ($byName.length) setInputValue($byName, value);
      }
    });
  };

  window.loadimages = function (candidate_id) {
    $("#attachmentsModal .modal-body").html('<p class="text-center text-muted">Loading attachments...</p>');
    $("#attachmentsModalLabel").text("Attachments");
    $.ajax({
      url: '<?php echo e(route("candidates.loadimages")); ?>',
      type: "GET",
      data: { id: candidate_id },
      success: function (response) {
        if (response.success) {
          $("#attachmentsModal .modal-body").html(response.html);
          $("#attachmentsModalLabel").text("Attachments for Candidate #" + candidate_id);
        } else {
          $("#attachmentsModal .modal-body").html('<p class="text-center text-muted">No attachments found.</p>');
        }
        $("#attachmentsModal").modal("show");
      },
      error: function () {
        alert("Unable to load attachments. Please try again later.");
      }
    });
  };

  window.confirmInsideStatusChange = function (selectElement, candidateId, firstName, middleName, surname) {
    const selectedStatus = selectElement.options[selectElement.selectedIndex].text;
    const candidateFullName = `${firstName} ${middleName} ${surname}`.trim();
    Swal.fire({
      title: `Change status for ${candidateFullName}?`,
      text: `Do you want to change the status to "${selectedStatus}"?`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#dc3545",
      confirmButtonText: "Yes, change it",
      cancelButtonText: "No, keep it"
    }).then((result) => {
      if (result.isConfirmed) {
        window.updateStatusInside(selectElement, candidateId);
      } else {
        const previousStatus = [...selectElement.options].find((option) => option.defaultSelected);
        if (previousStatus) selectElement.value = previousStatus.value;
      }
    });
  };

  window.confirmDelete = function (candidateRefNo) {
    Swal.fire({
      title: "Are you sure?",
      text: "This action will delete the candidate's record.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#dc3545",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Yes, delete it",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById(`delete-form-${candidateRefNo}`).submit();
      }
    });
  };

  window.sendAlarm = function (CN_Number) {
    $.ajax({
      url: '<?php echo e(route("send.alarm")); ?>',
      type: "POST",
      headers: { "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>" },
      data: { CN_Number: CN_Number },
      success: function (response) {
        if (response.status === "success") safeToastrSuccess(response.message);
        else safeToastrError(response.message);
      },
      error: function () {
        safeToastrError("An unexpected error occurred.");
      }
    });
  };

  $(document)
    .off("click.paginationCandidates", "#candidate_table_outside .pagination a")
    .on("click.paginationCandidates", "#candidate_table_outside .pagination a", function (e) {
      e.preventDefault();
      const url = $(this).attr("href");
      loadCandidatesWithUrl(url, currentFilter, currentSubFilter);
    });

  $(function () {
    const initial = getTabState();
    activateTabUI(initial.tab, initial.sub);
    loadCandidates(initial.tab, initial.sub);

    $("#global_search_input")
      .off("input.globalSearch")
      .on("input.globalSearch", debounce(function () {
        const val = $(this).val() || "";
        $("#global_search_hidden").val(val);
        loadCandidates(currentFilter, currentSubFilter);
      }, 300));

    $("#statusTabs .nav-link")
      .off("click.statusTabs")
      .on("click.statusTabs", function (e) {
        e.preventDefault();

        const id = $(this).attr("id");
        const status = STATUS_TAB_ID_TO_NAME[id] || "all";

        $("#statusTabs .nav-link").removeClass("active");
        $(this).addClass("active");

        if (status === "on-process") {
          $("#onProcessSubTabsWrap").stop(true, true).slideDown(150);
          $("#onProcessSubTabs .nav-link").removeClass("active");
          $("#onProcessSubTabs #sub-selected").addClass("active");
          $(this).tab("show");
          loadCandidates("on-process", "Selected");
        } else {
          $("#onProcessSubTabsWrap").stop(true, true).slideUp(150);
          $(this).tab("show");
          loadCandidates(status, null);
        }
      });

    $("#onProcessSubTabs .nav-link")
      .off("click.onProcessSubTabs")
      .on("click.onProcessSubTabs", function (e) {
        e.preventDefault();
        $("#onProcessSubTabs .nav-link").removeClass("active");
        $(this).addClass("active");
        const sub = $(this).data("sub");
        loadCandidates("on-process", sub);
      });

    $("#clear_filters")
      .off("click.clearFilters")
      .on("click.clearFilters", function () {
        $("#filter_form_outside")[0].reset();
        $("#global_search_input").val("");
        $("#global_search_hidden").val("");
        $(".remove-filter").each(function () { $(this).hide(); });
        $("#statusTabs .nav-link").removeClass("active");
        $("#tab-all").addClass("active").tab("show");
        $("#onProcessSubTabsWrap").hide();
        loadCandidates("all", null);
      });

    $(document)
      .off("input change.filters", "#filter_form_outside input, #filter_form_outside select")
      .on("input change.filters", "#filter_form_outside input, #filter_form_outside select", function () {
        const field = $(this).attr("name");
        if ($(this).val() !== "") $(`.remove-filter[data-field="${field}"]`).show();
        else $(`.remove-filter[data-field="${field}"]`).hide();
        loadCandidates(currentFilter, currentSubFilter);
      });

    $(document)
      .off("click.removeFilter", ".remove-filter")
      .on("click.removeFilter", ".remove-filter", function () {
        const field = $(this).data("field");
        $(`#filter_form_outside [name="${field}"]`).val("");
        $(this).hide();
        loadCandidates(currentFilter, currentSubFilter);
      });

    $("#export_excel")
      .off("click.exportExcel")
      .on("click.exportExcel", function () {
        const $btn = $(this);
        const originalHtml = $btn.html();

        const formArray = $("#filter_form_outside").serializeArray();
        const data = {};
        formArray.forEach(({ name, value }) => { data[name] = value; });

        data.filter = currentFilter;
        data.sub_filter = currentSubFilter;
        data._token = data._token || "<?php echo e(csrf_token()); ?>";
        data.global_search = $("#global_search_input").val() || "";
        data.current_status_id = $("#current_status_id_hidden").val() === "" ? "" : $("#current_status_id_hidden").val();
        data.tab_name = $("#tab_name_hidden").val() || "";

        $btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Exporting...');

        $.ajax({
          url: '<?php echo e(route("candidates.export")); ?>',
          type: "POST",
          data: data,
          xhrFields: { responseType: "blob" },
          headers: { "X-CSRF-TOKEN": data._token }
        }).done(function (response, status, xhr) {
          const ct = (xhr.getResponseHeader("Content-Type") || "").toLowerCase();
          if (ct.indexOf("application/json") !== -1) {
            const reader = new FileReader();
            reader.onload = function () {
              try { safeToastrError(JSON.parse(reader.result).message || "Export failed."); }
              catch (_) { safeToastrError("Export failed."); }
              $btn.prop("disabled", false).html(originalHtml);
            };
            reader.readAsText(response);
            return;
          }

          const cd = xhr.getResponseHeader("Content-Disposition") || "";
          let filename = (cd.match(/filename\*?=(?:UTF-8'')?("?)([^";]+)\1/i) || [])[2];
          if (!filename) filename = "<?php echo e(date('d-m-Y')); ?>_candidates.xlsx";

          const blob = new Blob([response], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
          const url = window.URL.createObjectURL(blob);
          const a = document.createElement("a");
          a.href = url;
          a.download = filename;
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          setTimeout(function () { window.URL.revokeObjectURL(url); }, 1000);

          safeToastrSuccess("File downloaded successfully!");
          $btn.prop("disabled", false).html(originalHtml);
        }).fail(function (xhr) {
          let msg = "Failed to export data.";
          try { msg = (xhr.responseJSON && xhr.responseJSON.message) || msg; } catch (_) {}
          safeToastrError(msg);
          $btn.prop("disabled", false).html(originalHtml);
        });
      });

    $("#agreedSalaryOutside")
      .off("input keydown.salary")
      .on("input keydown.salary", function (e) {
        const key = e.key;
        const value = $(this).val();
        if (!/^[0-9.]$/.test(key) && e.keyCode !== 8 && e.keyCode !== 46) e.preventDefault();
        if (key === "." && String(value).includes(".")) e.preventDefault();
      });

    $("#agreedSalaryOutside")
      .off("blur.salaryValidate")
      .on("blur.salaryValidate", function () {
        const salaryVal = parseFloat($(this).val());
        if (isNaN(salaryVal) || salaryVal < 1200) {
          safeToastrError("The agreed salary must be at least 1200.");
          $(this).val("");
          $(this).focus();
        }
      });

    allowOnlyNumbers("#officeTotalAmount");
    allowOnlyNumbers("#officeReceivedAmount");
    allowOnlyNumbers("#officeRemainingAmount");
    allowOnlyNumbers("#govtTotalAmount");
    allowOnlyNumbers("#govtReceivedAmount");
    allowOnlyNumbers("#govtRemainingAmount");
    allowOnlyNumbers("#govtVatAmount");

    const $clientDropdown = $("#clientDropdownOutside");
    $clientDropdown
      .off("change.clientVisaType")
      .on("change.clientVisaType", function () {
        const selectedClientText = $clientDropdown.find("option:selected").text();
        if (selectedClientText === "Tadbeer Sponsorship") $("#VisaTypeOutside").val("TADBEER").trigger("change");
      });

    (function () {
      const $client = $("#clientDropdownOutside");
      const $visaType = $("#VisaTypeOutside");
      const $emirates = $("#emiratesId");

      function applyClientSideEffects(data) {
        const text = data?.text || $client.find("option:selected").text();
        const eid =
          data?.emirates_id ??
          $client.find("option:selected").data("emiratesId") ??
          $client.find("option:selected").attr("data-emirates-id") ??
          "";
        if (text === "Tadbeer Sponsorship") $visaType.val("TADBEER").trigger("change");
        $emirates.val(eid);
      }

      $client.off("change.clientEffects").on("change.clientEffects", function () { applyClientSideEffects(); });
      $client.off("select2:select.clientEffects").on("select2:select.clientEffects", function (e) { applyClientSideEffects(e.params.data); });
      $client.off("select2:clear.clientEffects").on("select2:clear.clientEffects", function () { $emirates.val(""); });
    })();

    $("#officePaymentProof")
      .off("change.officePaymentProof")
      .on("change.officePaymentProof", function () {
        const allowedExtensions = ["png", "jpeg", "jpg", "pdf"];
        const file = String($(this).val() || "").split(".").pop().toLowerCase();

        const totalStr = String($("#officeTotalAmount").val() ?? "").trim();
        const recvStr = String($("#officeReceivedAmount").val() ?? "").trim();

        const totalAmount = parseNumOrNaN(totalStr);
        const receivedAmount = parseNumOrNaN(recvStr);

        if (totalStr === "" || isNaN(totalAmount) || totalAmount <= 0) {
          safeToastrError("Fill Total Amount before uploading proof.");
          $(this).val("");
          $("#agreementSection").hide();
          return;
        }

        if (recvStr === "" || isNaN(receivedAmount) || receivedAmount < 0) {
          safeToastrError("Fill Received Amount (0 allowed) before uploading proof.");
          $(this).val("");
          $("#agreementSection").hide();
          return;
        }

        if (receivedAmount === 0) {
          safeToastrError("Received amount is 0. Payment proof is not required.");
          $(this).val("");
          $("#agreementSection").hide();
          return;
        }

        if (allowedExtensions.includes(file)) $("#agreementSection").show();
        else {
          safeToastrError("Only PNG, JPEG, JPG, and PDF files are allowed.");
          $(this).val("");
          $("#agreementSection").hide();
        }
      });

    $("#officeTotalAmount, #officeReceivedAmount")
      .off("input.officeCalc")
      .on("input.officeCalc", function () {
        const totalAmount = parseFloat($("#officeTotalAmount").val()) || 0;
        const receivedAmount = parseFloat($("#officeReceivedAmount").val()) || 0;
        const remainingAmount = totalAmount - receivedAmount;

        if (remainingAmount < 0) {
          safeToastrError("Received amount cannot exceed the total amount.");
          $("#officeReceivedAmount").val("");
          $("#officeRemainingAmount").val("");
          $("#officeVatAmount").val("");
          $("#officeNetAmount").val("");
          return;
        }

        $("#officeRemainingAmount").val(remainingAmount);
        const vatAmount = 0;
        const netAmount = totalAmount + vatAmount;
        $("#officeVatAmount").val(vatAmount.toFixed(2));
        $("#officeNetAmount").val(netAmount.toFixed(2));
      });

    $("#govtTotalAmount, #govtReceivedAmount")
      .off("input.govtCalc")
      .on("input.govtCalc", function () {
        const totalAmount = parseFloat($("#govtTotalAmount").val()) || 0;
        const receivedAmount = parseFloat($("#govtReceivedAmount").val()) || 0;
        const remainingAmount = totalAmount - receivedAmount;

        if (remainingAmount < 0) {
          safeToastrError("Received amount cannot exceed the total amount.");
          $("#govtReceivedAmount").val("");
          $("#govtRemainingAmount").val("");
          $("#govtNetAmount").val("");
          return;
        }

        $("#govtRemainingAmount").val(remainingAmount);
        const vatAmount = parseFloat($("#govtVatAmount").val()) || 0;
        const netTotal = totalAmount + vatAmount;
        $("#govtNetAmount").val(netTotal.toFixed(2));
      });

    $("#govtVatAmount")
      .off("input.govtVatCalc")
      .on("input.govtVatCalc", function () {
        const totalAmount = parseFloat($("#govtTotalAmount").val()) || 0;
        const vatAmount = parseFloat($(this).val()) || 0;
        const netTotal = totalAmount + vatAmount;
        $("#govtNetAmount").val(netTotal.toFixed(2));
      });

    $("#VisaTypeOutside")
      .off("change.visaType")
      .on("change.visaType", function () {
        const selectedVisaType = $(this).val();
        const additionalFieldContainer = $("#additionalFieldContainer");
        additionalFieldContainer.empty();

        if (!selectedVisaType) {
          alert("Please choose a visa type.");
          return;
        }

        if (selectedVisaType === "VISIT" || selectedVisaType === "TOURIST") {
          additionalFieldContainer.html(
            '<label for="contractDuration"><i class="fas fa-calendar-alt text-default"></i> Contract Duration <span class="text-danger">*</span></label>' +
            '<input type="text" id="contractDuration" name="contract_duration" class="form-control" placeholder="Enter Contract Duration">'
          );
        } else {
          additionalFieldContainer.html(
            '<label for="contractDuration"><i class="fas fa-calendar-alt text-default"></i> Contract Duration <span class="text-danger">*</span></label>' +
            '<input type="text" id="contractDuration" name="contract_duration" class="form-control" placeholder=" For Example 2 Months">'
          );
        }
      });

    $("#toggleFilterText")
      .off("click.toggleFilter")
      .on("click.toggleFilter", function () {
        const filterSection = document.getElementById("filterSection");
        if (!filterSection) return;

        const isHidden = filterSection.style.display === "none" || filterSection.style.display === "";
        if (isHidden) {
          $(filterSection).hide().slideDown(300);
          filterSection.style.display = "block";
          this.querySelector("i").classList.remove("bi", "bi-funnel");
          this.querySelector("i").classList.add("fas", "fa-times");
        } else {
          $(filterSection).slideUp(300, function () { filterSection.style.display = "none"; });
          this.querySelector("i").classList.remove("fas", "fa-times");
          this.querySelector("i").classList.add("bi", "bi-funnel");
        }
      });

    $("#incidentReasonAfterTransfer")
      .off("change.incidentAfterTransfer")
      .on("change.incidentAfterTransfer", function () {
        const selectedValue = $(this).val();
        if (selectedValue === "Other") {
          $("#otherReasonAfterTransfer").show();
          $("#otherReasonInputAfterTransfer").prop("required", true);
        } else {
          $("#otherReasonAfterTransfer").hide();
          $("#otherReasonInputAfterTransfer").prop("required", false);
        }
      });

    $("#PackageOutside")
      .off("change.packageRulesTop")
      .on("change.packageRulesTop", function () {
        const packageValue = $(this).val();
        const $clientDropdown2 = $("#clientDropdownOutside");
        const $visaTypeDropdown = $("#VisaTypeOutside");

        if (packageValue === "PKG-1") {
          $clientDropdown2
            .find("option")
            .filter(function () { return $(this).text() === "Tadbeer Sponsorship"; })
            .prop("disabled", true);
          $visaTypeDropdown.find("option").each(function () {
            $(this).prop("disabled", $(this).text() === "TADBEER");
          });
        } else if (["PKG-2", "PKG-3", "PKG-4"].includes(packageValue)) {
          $visaTypeDropdown.find("option").each(function () {
            $(this).prop("disabled", $(this).text() !== "TADBEER");
          });
          $clientDropdown2.find("option").prop("disabled", false);
        } else {
          $clientDropdown2.find("option").prop("disabled", false);
          $visaTypeDropdown.find("option").prop("disabled", false);
        }

        if ($clientDropdown2.val() === "Tadbeer Sponsorship") $clientDropdown2.val("");
        if ($visaTypeDropdown.val() === "TADBEER" && packageValue === "PKG-1") $visaTypeDropdown.val("");
      });
  });

  document.addEventListener("DOMContentLoaded", function () {
    const paymentTermsDropdown = document.getElementById("paymentTermsDropdown");
    const partialPaymentDetails = document.getElementById("partialPaymentDetails");
    const installmentsCount = document.getElementById("installmentsCount");
    const officeTotalAmount = document.getElementById("officeTotalAmount");
    const officeReceivedAmount = document.getElementById("officeReceivedAmount");
    const officeRemainingAmount = document.getElementById("officeRemainingAmount");
    const officeNetAmount = document.getElementById("officeNetAmount");
    const installmentRows = document.getElementById("installmentRows");
    const packageOutside = document.getElementById("PackageOutside");

    if (paymentTermsDropdown) {
      paymentTermsDropdown.addEventListener("change", function () {
        if (!partialPaymentDetails) return;
        partialPaymentDetails.style.display = this.value === "partial" ? "block" : "none";
        if (this.value !== "partial") {
          if (installmentsCount) installmentsCount.value = "";
          if (installmentRows) installmentRows.innerHTML = "";
        }
      });
    }

    function formatDate(date) {
      let d = new Date(date);
      let month = (d.getMonth() + 1).toString().padStart(2, "0");
      let day = d.getDate().toString().padStart(2, "0");
      let year = d.getFullYear();
      return `${year}-${month}-${day}`;
    }

    function addMonths(date, months) {
      let d = new Date(date);
      d.setMonth(d.getMonth() + months);
      return d;
    }

    function updateRemainingAmount() {
      const total = parseFloat(officeTotalAmount?.value) || 0;
      const received = parseFloat(officeReceivedAmount?.value) || 0;
      if (officeRemainingAmount) officeRemainingAmount.value = (total - received).toFixed(2);
    }

    function generateRows() {
      if (!installmentRows || !installmentsCount) return;

      if (!packageOutside?.value) {
        safeToastrError("Choose package first");
        installmentRows.innerHTML = "";
        return;
      }

      if (packageOutside.value === "PKG-1") {
        safeToastrError("You can't make installments for Package 1");
        installmentRows.innerHTML = "";
        return;
      }

      if (!officeNetAmount?.value || parseFloat(officeNetAmount.value) === 0) {
        safeToastrError("Office Net Amount must be greater than 0");
        installmentRows.innerHTML = "";
        return;
      }

      const count = parseInt(installmentsCount.value) || 0;
      const remaining = parseFloat(officeRemainingAmount?.value) || 0;
      installmentRows.innerHTML = "";

      if (count > 0) {
        const amount = (remaining / count).toFixed(2);
        for (let i = 1; i <= count; i++) {
          const tr = document.createElement("tr");

          const td1 = document.createElement("td");
          td1.textContent = i;

          const td2 = document.createElement("td");
          td2.textContent = `Installment ${i}`;

          const td3 = document.createElement("td");
          const amtInput = document.createElement("input");
          amtInput.type = "text";
          amtInput.className = "form-control";
          amtInput.readOnly = true;
          amtInput.value = amount;
          td3.appendChild(amtInput);

          const td4 = document.createElement("td");
          const dateInput = document.createElement("input");
          dateInput.type = "date";
          dateInput.className = "form-control flatpickr-input";
          dateInput.value = formatDate(addMonths(new Date(), i));
          td4.appendChild(dateInput);

          tr.append(td1, td2, td3, td4);
          installmentRows.appendChild(tr);
        }
      }
    }

    if (installmentsCount) installmentsCount.addEventListener("input", generateRows);
    if (officeTotalAmount) officeTotalAmount.addEventListener("input", function () { updateRemainingAmount(); generateRows(); });
    if (officeReceivedAmount) officeReceivedAmount.addEventListener("input", function () { updateRemainingAmount(); generateRows(); });
  });

  $(function () {
    function fmt(date) {
      const d = new Date(date);
      const y = d.getFullYear();
      const m = String(d.getMonth() + 1).padStart(2, "0");
      const day = String(d.getDate()).padStart(2, "0");
      return `${y}-${m}-${day}`;
    }

    function addMonths(date, n) {
      const d = new Date(date);
      d.setMonth(d.getMonth() + n);
      return d;
    }

    function sanitize(selector, allowDecimal) {
      const regex = allowDecimal ? /[^0-9.]/g : /[^0-9]/g;
      $(document)
        .off("input.sanitize", selector)
        .on("input.sanitize", selector, function () { this.value = this.value.replace(regex, ""); });
    }

    function validateAgreementFormOutside() {
      const pkg = $("#PackageOutside").val();
      const candName = $("#selectedModalcandidateName").val().trim();
      const client = $("#clientDropdownOutside").val();
      const visa = $("#VisaTypeOutside").val();
      const contractDur = $("#contractDuration").val();
      const arrivalDate = $("#expectedArrivalDateOutside").val();
      const salary = parseFloat($("#agreedSalaryOutside").val());

      const officeTotalStr = String($("#officeTotalAmount").val() ?? "").trim();
      const officeRecvStr = String($("#officeReceivedAmount").val() ?? "").trim();
      const officeTotal = parseNumOrNaN(officeTotalStr);
      const officeReceived = parseNumOrNaN(officeRecvStr);
      const officeRemaining = $("#officeRemainingAmount").val().trim();

      const govtTotal = parseFloat($("#govtTotalAmount").val()) || 0;
      const govtReceived = parseFloat($("#govtReceivedAmount").val()) || 0;

      const paymentCycle = $("#paymentCycle").val();
      const monthlyPayment = parseFloat($("#monthlyPayment").val());

      if (!pkg) { safeToastrError("Select package"); $("#PackageOutside").focus(); return false; }
      if (!client) { safeToastrError("Select client"); $("#clientDropdownOutside").focus(); return false; }
      if (!candName) { safeToastrError("Enter candidate name"); $("#selectedModalcandidateName").focus(); return false; }
      if (!visa) { safeToastrError("Select visa"); $("#VisaTypeOutside").focus(); return false; }
      if (!contractDur) { safeToastrError("Enter contract duration"); $("#contractDuration").focus(); return false; }

      if (officeTotalStr === "" || isNaN(officeTotal) || officeTotal <= 0) { safeToastrError("Enter valid office total amount"); $("#officeTotalAmount").focus(); return false; }
      if (officeRecvStr === "" || isNaN(officeReceived) || officeReceived < 0) { safeToastrError("Enter valid office received amount (0 allowed)"); $("#officeReceivedAmount").focus(); return false; }
      if (officeRemaining === "" || isNaN(parseFloat(officeRemaining))) { safeToastrError("Office remaining amount is invalid"); $("#officeRemainingAmount").focus(); return false; }

      const officeMethod = $("#officePaymentMethod").val();
      if (officeReceived > 0 && !officeMethod) { safeToastrError("Select office payment method"); $("#officePaymentMethod").focus(); return false; }
      if (officeReceived === 0) { $("#officePaymentMethod").val(""); $("#officePaymentProof").val(""); }

      if (officeTotal > 0 && officeReceived > 0 && !hasFile($("#officePaymentProof"))) { safeToastrError("Upload office payment proof"); $("#officePaymentProof").focus(); return false; }

      if (!arrivalDate) { safeToastrError("Select expected arrival date"); $("#expectedArrivalDateOutside").focus(); return false; }
      if (isNaN(salary) || salary <= 0) { safeToastrError("Enter valid salary"); $("#agreedSalaryOutside").focus(); return false; }

      const govtMethod = $("#govtPaymentMethod").val();
      if (govtReceived > 0 && !govtMethod) { safeToastrError("Select govt payment method"); $("#govtPaymentMethod").focus(); return false; }
      if (govtTotal > 0 && govtReceived > 0 && !hasFile($("#govtPaymentProof"))) { safeToastrError("Upload government payment proof"); $("#govtPaymentProof").focus(); return false; }

      if (monthlyPayment > 0 && !paymentCycle) { safeToastrError("Select payment cycle"); $("#paymentCycle").focus(); return false; }
      if (paymentCycle === "LUMSUM" && monthlyPayment > 0) { safeToastrError("Monthly payment must be 0 for LUMSUM"); $("#monthlyPayment").focus(); return false; }

      return true;
    }

    const $pkg = $("#PackageOutside");
    const $client = $("#clientDropdownOutside");
    const $totO = $("#officeTotalAmount");
    const $recO = $("#officeReceivedAmount");
    const $remO = $("#officeRemainingAmount");
    const $methodO = $("#officePaymentMethod");
    const $proofOrow = $("#officePaymentProofRow");
    const $proofO = $("#officePaymentProof");
    const $monRow = $("#monthlyPaymentRow");
    const $monInp = $("#monthlyPayment");
    const $cycleRow = $("#paymentCycleRow");
    const $cycleSel = $("#paymentCycle");
    const $genBtn = $("#generateInstallments");
    const $tblO = $("#officeInstallmentsTable");
    const $bodyO = $("#officeInstallmentRows");
    const $totG = $("#govtTotalAmount");
    const $recG = $("#govtReceivedAmount");
    const $vatG = $("#govtVatAmount");
    const $remG = $("#govtRemainingAmount");
    const $netG = $("#govtNetAmount");
    const $methodG = $("#govtPaymentMethod");
    const $proofGrow = $("#govtPaymentProof").closest(".col-md-8");
    const $proofG = $("#govtPaymentProof");
    const $durSel = $("#contractDuration");
    const $endDate = $("#contractEndDate");
    const $arrival = $("#expectedArrivalDateOutside");
    const $convertRow = $("#convertRow");
    const $hideable = $("#hideableSection");

    function recalcOffice() {
      const total = parseFloat($totO.val()) || 0;
      const recvStr = String($recO.val() ?? "").trim();
      const recv = recvStr === "" ? 0 : (parseFloat(recvStr) || 0);
      const remain = total - recv;

      $remO.val(remain.toFixed(2));

      if (recv > 0) {
        $proofOrow.show();
      } else {
        $proofOrow.hide();
        $proofO.val("");
      }

      if (recv > 0) $methodO.prop("required", true);
      else {
        $methodO.prop("required", false);
        $methodO.val("");
      }
    }

    function recalcGovt() {
      const total = parseFloat($totG.val()) || 0;
      const recvStr = String($recG.val() ?? "").trim();
      const recv = recvStr === "" ? 0 : (parseFloat(recvStr) || 0);
      const vat = parseFloat($vatG.val()) || 0;

      $remG.val((total - recv).toFixed(2));
      $netG.val((total + vat).toFixed(2));

      if (recv > 0) {
        $proofGrow.show();
      } else {
        $proofGrow.hide();
        $proofG.val("");
      }

      if (recv > 0) $methodG.prop("required", true);
      else {
        $methodG.prop("required", false);
        $methodG.val("");
      }
    }

    function updateEndDate() {
      const months = parseInt($durSel.val(), 10) || 0;
      if (!months) { $endDate.val(""); return; }
      const base = $arrival.val() ? new Date($arrival.val()) : new Date();
      $endDate.val(fmt(addMonths(base, months)));
    }

    function toggleConvertSection() {
      const isConvert = $pkg.val() !== "PKG-1" && $client.find("option:selected").text().trim() === "Tadbeer Alebdaa";
      if (isConvert) { $convertRow.show(); $hideable.slideUp(); }
      else { $convertRow.hide(); $hideable.slideDown(); }
    }

    function buildInstallments() {
      const monthly = parseFloat($monInp.val()) || 0;
      const remain = parseFloat($remO.val()) || 0;
      const cycle = $cycleSel.val();
      const dur = parseInt($durSel.val(), 10) || 24;

      if (!cycle || cycle === "LUMSUM" || monthly < 500 || remain <= 0) return;

      const cycleMonths = parseInt(cycle, 10);
      const count = Math.ceil(remain / monthly);

      if (cycleMonths * count > dur) { safeToastrError("Installments exceed contract duration"); return; }

      $bodyO.empty();
      for (let i = 1; i <= count; i++) {
        const amt = i < count ? monthly : remain - monthly * (count - 1);
        const date = fmt(addMonths(new Date(), i * cycleMonths));
        const row =
          `<tr>` +
            `<td>${i}</td>` +
            `<td>Installment ${i}</td>` +
            `<td><input type="text" readonly class="form-control form-control-sm" value="${amt.toFixed(2)}"></td>` +
            `<td><input type="date" class="form-control form-control-sm" value="${date}"></td>` +
          `</tr>`;
        $bodyO.append(row);
      }
      $tblO.show();
    }

    sanitize("#officeTotalAmount", true);
    sanitize("#officeReceivedAmount", true);
    sanitize("#monthlyPayment", true);
    sanitize("#govtTotalAmount", true);
    sanitize("#govtReceivedAmount", true);
    sanitize("#govtVatAmount", true);

    $totO.off("input change.officeRecalc").on("input change.officeRecalc", recalcOffice);
    $recO.off("input change.officeRecalc").on("input change.officeRecalc", recalcOffice);
    $totG.off("input change.govtRecalc").on("input change.govtRecalc", recalcGovt);
    $recG.off("input change.govtRecalc").on("input change.govtRecalc", recalcGovt);
    $vatG.off("input change.govtRecalc").on("input change.govtRecalc", recalcGovt);
    $durSel.off("change.endDate").on("change.endDate", updateEndDate);
    $arrival.off("change.endDate").on("change.endDate", updateEndDate);

    $pkg.off("change.pkgMain").on("change.pkgMain", function () {
      toggleConvertSection();
      if (this.value === "PKG-1") {
        $monRow.hide().find("input").val(0);
        $cycleRow.hide().find("select").val("");
        $genBtn.hide();
        $tblO.hide();
        $bodyO.empty();
      }
    });

    $client.off("change.toggleConvert").on("change.toggleConvert", toggleConvertSection);

    $monInp.off("input.monthlyToggle").on("input.monthlyToggle", function () {
      if (parseFloat(this.value) > 0) { $cycleRow.show(); $genBtn.show(); }
      else { $cycleRow.hide().find("select").val(""); $genBtn.hide(); $tblO.hide(); $bodyO.empty(); }
    });

    $cycleSel.off("change.cycleToggle").on("change.cycleToggle", function () {
      if (this.value === "LUMSUM") { $monInp.val(0); $genBtn.hide(); $tblO.hide(); $bodyO.empty(); }
      else { $genBtn.show(); }
    });

    $genBtn.off("click.buildInstallments").on("click.buildInstallments", buildInstallments);

    $(document)
      .off("click.openSelectedModal", ".openSelectedModal")
      .on("click.openSelectedModal", ".openSelectedModal", function () {
        const b = $(this);
        $("#selectedModalcandidateName").val(b.data("name"));
        $("#selectedModalcandidateId").val(b.data("id"));
        $("#selectedModalreferenceNo").val(b.data("reference"));
        $("#selectedModalrefNo").val(b.data("ref"));
        $("#selectedModalforeignPartner").val(b.data("partner"));
        $("#selectedModalcandiateNationality").val(b.data("nationality"));
        $("#selectedModalcandidatePassportNumber").val(b.data("passport"));
        $("#selectedModalcandidatePassportExpiry").val(b.data("passport_expiry"));
        $("#selectedModalcandidateDOB").val(b.data("dob"));
      });

    $("#convertToEmployeeBtn")
      .off("click.convertToContract")
      .on("click.convertToContract", function (e) {
        e.preventDefault();

        const id = $("#selectedModalcandidateId").val();
        const fd = new FormData();

        fd.append("candidate_id", id);
        fd.append("candidate_name", $("#selectedModalcandidateName").val());
        fd.append("reference_no", $("#selectedModalreferenceNo").val());
        fd.append("ref_no", $("#selectedModalrefNo").val());
        fd.append("foreign_partner", $("#selectedModalforeignPartner").val());
        fd.append("candidate_nationality", $("#selectedModalcandiateNationality").val());
        fd.append("candidate_passport_number", $("#selectedModalcandidatePassportNumber").val());
        fd.append("candidate_passport_expiry", $("#selectedModalcandidatePassportExpiry").val());
        fd.append("candidate_dob", $("#selectedModalcandidateDOB").val());

        fd.append("package", $("#PackageOutside").val());
        const $clientSel = $("#clientDropdownOutside");
        fd.append("client_id", $clientSel.val());
        fd.append("client_name", $clientSel.find("option:selected").text().trim());
        fd.append("emirates_id", $("#emiratesId").val());
        fd.append("visa_type", $("#VisaTypeOutside").val());
        fd.append("contract_duration", $("#contractDuration").val());
        fd.append("contract_end_date", $("#contractEndDate").val());

        $.ajax({
          url: "/candidates/" + id + "/convert-to-contract",
          type: "POST",
          headers: { "X-CSRF-TOKEN": $("input[name='_token']").val() },
          data: fd,
          processData: false,
          contentType: false
        }).done((r) => {
          if (r.status === "success") {
            safeToastrSuccess(r.message);
            $("#selectedModal").modal("hide");
            setTimeout(() => location.reload(), 1500);
          } else {
            safeToastrError(r.message);
          }
        }).fail((x) => {
          const res = x.responseJSON || {};
          const errs = res.errors || {};
          const msg = res.message;
          Object.values(errs).flat().forEach(safeToastrError);
          if (!Object.keys(errs).length && msg) safeToastrError(msg);
        });
      });

    $("#saveChanges")
      .off("click.saveAgreement")
      .on("click.saveAgreement", function (e) {
        e.preventDefault();
        if (!validateAgreementFormOutside()) return;

        const fd = new FormData($("#agreement_form")[0]);

        if ($("#officeInstallmentsTable").is(":visible")) {
          const arr = [];
          $("#officeInstallmentRows").children().each(function () {
            arr.push({
              installmentNumber: $(this).find("td:eq(0)").text(),
              description: $(this).find("td:eq(1)").text(),
              amount: $(this).find("td:eq(2) input").val(),
              paymentDate: $(this).find("td:eq(3) input").val()
            });
          });
          fd.set("installments_details", JSON.stringify(arr));
          fd.set("installments_count", arr.length);
        }

        $.ajax({
          url: '<?php echo e(route("agreements.store")); ?>',
          type: "POST",
          headers: { "X-CSRF-TOKEN": $("input[name='_token']").val() },
          data: fd,
          processData: false,
          contentType: false
        }).done((r) => {
          if (r.status === "success") {
            safeToastrSuccess(r.message);
            $("#agreement_form")[0].reset();
            $("#selectedModal").modal("hide");
            setTimeout(() => location.reload(), 1500);
          } else {
            safeToastrError(r.message);
          }
        }).fail((x) => {
          const eobj = (x.responseJSON || {}).errors || {};
          const m = (x.responseJSON || {}).message;
          $.each(eobj, (_, arr) => arr.forEach(safeToastrError));
          if (!Object.keys(eobj).length && m) safeToastrError(m);
        });
      });

    recalcOffice();
    recalcGovt();
    toggleConvertSection();
    updateEndDate();
  });

  $(function () {
    $("#save_wc_date")
      .off("click.saveWcDate")
      .on("click.saveWcDate", function () {
        const saveButton = $(this);
        const wcDate = $("#wcDate").val();
        const wcContractFile = $("#wcContractFile")[0]?.files[0];
        const candidateId = $("#WcDateModalcandidateId").val();
        const referenceNo = $("#WcDateModalreferenceNo").val();
        const clientName = $("#WcDateModalclient_name").val();
        const wc_date_remark = $("#WcDateModalremarks").val();
        const dw_number = $("#dw_number").val();

        if (!wcDate) { safeToastrError("WC Date is required."); $("#wcDate").focus(); return; }
        if (!wcContractFile) { safeToastrError("WC Contract File is required."); $("#wcContractFile").focus(); return; }
        if (!candidateId) { safeToastrError("Candidate ID is missing. Please refresh the page and try again."); return; }
        if (!referenceNo) { safeToastrError("Reference Number is missing. Please refresh the page and try again."); return; }
        if (!clientName) { safeToastrError("Employer Name is required."); $("#WcDateModalclient_name").focus(); return; }
        if (!dw_number) { safeToastrError("DW Number is required."); $("#dw_number").focus(); return; }

        const formData = new FormData();
        formData.append("wc_date", wcDate);
        formData.append("wc_contract_file", wcContractFile);
        formData.append("candidate_id", candidateId);
        formData.append("reference_no", referenceNo);
        formData.append("client_name", clientName);
        formData.append("wc_date_remark", wc_date_remark);
        formData.append("dw_number", dw_number);
        formData.append("_token", "<?php echo e(csrf_token()); ?>");

        saveButton.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajax({
          url: '<?php echo e(route("candidates.update-wc-date")); ?>',
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            if (response.success) {
              safeToastrSuccess("WC Date updated successfully.");
              $("#WcDateModal").modal("hide");
              setTimeout(() => location.reload(), 2000);
            } else {
              if (response.errors) {
                $.each(response.errors, function (key, messages) {
                  $.each(messages, function (i, message) { safeToastrError(message); });
                });
              } else {
                safeToastrError(response.message || "Failed to update WC Date. Please try again.");
              }
            }
          },
          error: function (xhr) {
            const response = xhr.responseJSON;
            if (response && response.errors) {
              $.each(response.errors, function (key, messages) {
                $.each(messages, function (i, message) { safeToastrError(message); });
              });
            } else if (response && response.message) {
              safeToastrError(response.message);
            } else {
              safeToastrError("An error occurred while updating WC Date. Please try again.");
            }
          },
          complete: function () {
            saveButton.prop("disabled", false).html("Save");
          }
        });
      });

    $(document)
      .off("change.incidentDecision", ".incident-decision")
      .on("change.incidentDecision", ".incident-decision", function () {
        const $cb = $(this);
        const modal = $cb.data("modal");
        if (!modal) return;

        const isChecked = $cb.is(":checked");
        const val = $cb.val();

        $(`${modal} .incident-decision`).not(this).prop("checked", false);

        const $refundSection = $(`${modal}refundSection`);
        if ($refundSection.length) $refundSection.show();

        const $balanceLabel = $(`${modal}balance_label`);
        if ($balanceLabel.length) $balanceLabel.text(val === "Replacement" ? "Replacement Balance" : "Refund Balance");

        const $dueStrong = $(modal).find('label[for="' + modal.replace("#", "") + 'refund_due_date"] strong');
        if ($dueStrong.length) $dueStrong.text(val === "Replacement" ? "Replacement Due Date" : "Refund Due Date");

        if (val === "Refund" && isChecked) {
          initRefundDueDatePicker(modal);
        }

        recalcIncidentBalance(modal);
      });

    $(document)
      .off("input.incidentOfficeCharges", ".incident-office-charges")
      .on("input.incidentOfficeCharges", ".incident-office-charges", function () {
        const modal = $(this).data("modal");
        if (!modal) return;
        recalcIncidentBalance(modal);
      });

    $(document)
      .off("shown.bs.modal.incidentInit", "#IncidentBeforeVisaModal,#IncidentAfterVisaModal,#IncidentAfterArrivalModal,#IncidentAfterDepartureModal")
      .on("shown.bs.modal.incidentInit", "#IncidentBeforeVisaModal,#IncidentAfterVisaModal,#IncidentAfterArrivalModal,#IncidentAfterDepartureModal", function () {
        const modalId = "#" + this.id;
        const d = (window.__candidateDetailsByModal && window.__candidateDetailsByModal[modalId]) ? window.__candidateDetailsByModal[modalId] : {};
        initIncidentModal(modalId, d);
      });

    $("#saveIncident")
      .off("click.saveIncidentBeforeVisa")
      .on("click.saveIncidentBeforeVisa", function () {
        const saveButton = $(this);
        const form = $("#incidentForm")[0];
        const formData = new FormData(form);
        formData.append("_token", "<?php echo e(csrf_token()); ?>");

        const modalId = "#IncidentBeforeVisaModal";
        const details = (window.__candidateDetailsByModal && window.__candidateDetailsByModal[modalId]) ? window.__candidateDetailsByModal[modalId] : {};
        const a = pickAgreement(details) || {};
        formData.set("agreement_id", a.id ?? "");
        formData.set("agreement_reference_no", a.reference_no ?? "");
        formData.set("contract_start_date", a.contract_start_date ?? "");
        formData.set("contract_end_date", a.contract_end_date ?? "");
        formData.set("total_amount", a.total_amount ?? "");
        formData.set("received_amount", a.received_amount ?? "");

        const remarksVal = $("#IncidentBeforeVisaremarks").val() || "";
        formData.append("incident_before_visa_remark", remarksVal);

        const requiredFields = [
          { selector: "#IncidentBeforeVisaModalcandidateId" },
          { selector: "#IncidentBeforeVisaModalclient_name" },
          { selector: "#incidentCategoryBeforeVisa" },
          { selector: "#beforeVisaReason" },
          { selector: "#incidentProofBeforeVisa" }
        ];

        if ($("#beforeVisaReason").val() === "Other") requiredFields.push({ selector: "#otherReasonInputBeforeVisa" });

        for (const field of requiredFields) {
          const $el = $(field.selector);
          if (!$el.val() && !(field.selector === "#incidentProofBeforeVisa" && hasFile($el))) {
            safeToastrError("All required fields must be filled.");
            $el.focus();
            return;
          }
        }

        const decision = $("#IncidentBeforeVisaModal .incident-decision:checked").val() || "Refund";
        formData.set("customer_decision", decision);

        if (decision === "Refund") {
          if (!validateRefundDueDateForModal(modalId)) return;

          const charges = parseFloat($("#IncidentBeforeVisaModaloffice_charges").val()) || 0;
          if (charges < 0) {
            safeToastrError("Office charges must be 0 or greater.");
            $("#IncidentBeforeVisaModaloffice_charges").focus();
            return;
          }
        }

        saveButton.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajax({
          url: '<?php echo e(route("candidates.save-incident")); ?>',
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            if (response.success) {
              safeToastrSuccess("Incident saved successfully.");
              $("#IncidentBeforeVisaModal").modal("hide");
              $("#incidentForm")[0].reset();
              setTimeout(() => location.reload(), 2000);
            } else {
              if (response.errors) {
                $.each(response.errors, function (key, messages) {
                  $.each(messages, function (i, message) { safeToastrError(message); });
                });
              } else {
                safeToastrError(response.message || "Failed to save the incident. Please try again.");
              }
            }
          },
          error: function (xhr) {
            const response = xhr.responseJSON;
            if (response && response.errors) {
              $.each(response.errors, function (key, messages) {
                $.each(messages, function (i, message) { safeToastrError(message); });
              });
            } else if (response && response.message) {
              safeToastrError(response.message);
            } else {
              safeToastrError("An error occurred while saving the incident.");
            }
          },
          complete: function () {
            saveButton.prop("disabled", false).html("Save");
          }
        });
      });

    const beforeVisaReasonEl = document.getElementById("beforeVisaReason");
    if (beforeVisaReasonEl && !beforeVisaReasonEl.dataset.bound) {
      beforeVisaReasonEl.dataset.bound = "1";
      beforeVisaReasonEl.addEventListener("change", function () {
        const otherReasonDiv = document.getElementById("otherBeforeVisaReason");
        const expiryDateDiv = document.getElementById("expiryDateDiv");
        if (otherReasonDiv) otherReasonDiv.style.display = this.value === "Other" ? "block" : "none";
        if (expiryDateDiv) expiryDateDiv.style.display = (this.value === "Valid Visa" || this.value === "Valid Resident") ? "block" : "none";
      });
    }

    $("#saveVisaDetails")
      .off("click.saveVisaDetails")
      .on("click.saveVisaDetails", function () {
        const saveButton = $(this);
        const form = $("#visaForm")[0];
        const formData = new FormData(form);
        formData.append("_token", "<?php echo e(csrf_token()); ?>");

        const remarksVal = $("#VisaDateModalremarks").val() || "";
        formData.append("visa_date_remark", remarksVal);

        const fields = [
          { selector: "#visaDate" },
          { selector: "#visaExpiryDate" },
          { selector: "#uidNumber" },
          { selector: "#entryPermitNumber" },
          { selector: "#visaCopy" }
        ];

        for (let i = 0; i < fields.length; i++) {
          const $el = $(fields[i].selector);
          if (!$el.val() && !(fields[i].selector === "#visaCopy" && hasFile($el))) {
            safeToastrError("All required fields must be filled.");
            $el.focus();
            return;
          }
        }

        saveButton.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajax({
          url: '<?php echo e(route("candidates.update-visa-details")); ?>',
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            if (response.success) {
              safeToastrSuccess("Visa details updated successfully.");
              $("#VisaDateModal").modal("hide");
              $("#visaForm")[0].reset();
              setTimeout(() => location.reload(), 2000);
            } else {
              if (response.errors) {
                $.each(response.errors, function (key, messages) {
                  $.each(messages, function (i, message) { safeToastrError(message); });
                });
              } else {
                safeToastrError(response.message || "Please check your invoice is not approved ?");
              }
            }
          },
          error: function (xhr) {
            const res = xhr.responseJSON;
            if (res && res.errors) {
              $.each(res.errors, function (key, messages) {
                $.each(messages, function (i, message) { safeToastrError(message); });
              });
            } else if (res && res.message) {
              safeToastrError(res.message);
            } else {
              safeToastrError("An error occurred while updating visa details.");
            }
          },
          complete: function () {
            saveButton.prop("disabled", false).html("Save");
          }
        });
      });

    $("#afterVisaReason")
      .off("change.afterVisaReason")
      .on("change.afterVisaReason", function () {
        if ($(this).val() === "Other") {
          $("#otherAfterVisaReason").show();
          $("#otherReasonInputAfterVisa").prop("required", true);
        } else {
          $("#otherAfterVisaReason").hide();
          $("#otherReasonInputAfterVisa").val("").prop("required", false);
        }
      });

    $("#incidentCategoryAfterArrival")
      .off("change.afterArrivalCategory")
      .on("change.afterArrivalCategory", function () {
        if ($(this).val() === "Other") {
          $("#otherAfterArrivalReason").show();
          $("#otherReasonInputAfterArrival").prop("required", true);
        } else {
          $("#otherAfterArrivalReason").hide();
          $("#otherReasonInputAfterArrival").val("").prop("required", false);
        }
      });

    $("#saveIncidentAfterVisa")
      .off("click.saveIncidentAfterVisa")
      .on("click.saveIncidentAfterVisa", function () {
        const saveButton = $(this);
        const form = $("#incidentAfterVisaForm")[0];
        const formData = new FormData(form);
        formData.append("_token", "<?php echo e(csrf_token()); ?>");

        const modalId = "#IncidentAfterVisaModal";
        const details = (window.__candidateDetailsByModal && window.__candidateDetailsByModal[modalId]) ? window.__candidateDetailsByModal[modalId] : {};
        const a = pickAgreement(details) || {};
        formData.set("agreement_id", a.id ?? "");
        formData.set("agreement_reference_no", a.reference_no ?? "");
        formData.set("contract_start_date", a.contract_start_date ?? "");
        formData.set("contract_end_date", a.contract_end_date ?? "");
        formData.set("total_amount", a.total_amount ?? "");
        formData.set("received_amount", a.received_amount ?? "");

        const remarksVal = $("#IncidentAfterVisaModalremarks").val() || "";
        formData.append("incident_after_visa_remark", remarksVal);

        const requiredFields = ["#IncidentAfterVisaModalcandidateId", "#incidentCategoryAfterVisa", "#afterVisaReason", "#incidentProofAfterVisa"];
        let isValid = true;

        for (let i = 0; i < requiredFields.length; i++) {
          const $el = $(requiredFields[i]);
          if (!$el.val() && !(requiredFields[i] === "#incidentProofAfterVisa" && hasFile($el))) {
            safeToastrError("All required fields must be filled.");
            $el.focus();
            isValid = false;
            break;
          }
        }

        if (isValid && String($("#afterVisaReason").val() || "").toLowerCase() === "other" && !$("#otherReasonInputAfterVisa").val()) {
          safeToastrError('Specify the "Other" reason.');
          $("#otherReasonInputAfterVisa").focus();
          isValid = false;
        }

        const decision = $("#IncidentAfterVisaModal .incident-decision:checked").val() || "Refund";
        formData.set("customer_decision", decision);

        if (isValid && decision === "Refund") {
          if (!validateRefundDueDateForModal(modalId)) return;
          const charges = parseFloat($("#IncidentAfterVisaModaloffice_charges").val()) || 0;
          if (charges < 0) {
            safeToastrError("Office charges must be 0 or greater.");
            $("#IncidentAfterVisaModaloffice_charges").focus();
            return;
          }
        }

        if (!isValid) return;

        saveButton.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajax({
          url: '<?php echo e(route("candidates.save-incident-after-visa")); ?>',
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            if (response.success) {
              safeToastrSuccess("Incident saved successfully.");
              $("#IncidentAfterVisaModal").modal("hide");
              $("#incidentAfterVisaForm")[0].reset();
              setTimeout(() => location.reload(), 2000);
            } else {
              if (response.errors) {
                $.each(response.errors, function (key, messages) {
                  $.each(messages, function (i, message) { safeToastrError(message); });
                });
              } else {
                safeToastrError(response.message || "Failed to save incident.");
              }
            }
          },
          error: function (xhr) {
            const res = xhr.responseJSON;
            if (res && res.errors) {
              $.each(res.errors, function (key, messages) {
                $.each(messages, function (i, message) { safeToastrError(message); });
              });
            } else if (res && res.message) {
              safeToastrError(res.message);
            } else {
              safeToastrError("An error occurred while saving the incident.");
            }
          },
          complete: function () {
            saveButton.prop("disabled", false).html("Save");
          }
        });
      });

    $("#updateArrivedDateForm")
      .off("submit.updateArrivedDate")
      .on("submit.updateArrivedDate", function (e) {
        e.preventDefault();

        const form = this;
        const saveButton = $("#saveArrivedDate");
        const formData = new FormData(form);

        const remarksVal = $("#updateArrivedDateModalremarks").val() || "";
        if (formData.has("updateArrivedDateModalremarks")) formData.delete("updateArrivedDateModalremarks");
        if (formData.has("remarks")) formData.delete("remarks");
        formData.append("remarks", remarksVal);

        formData.append("_token", "<?php echo e(csrf_token()); ?>");
        formData.set("status", "Office");

        if (!$("#updateArrivedDateModalcandidateName").val()) return safeToastrError("Candidate Name is required.");
        if (!$("#updateArrivedDateModalclient_name").val()) return safeToastrError("Employer Name is required.");
        if (!$("#arrivedDate").val()) return safeToastrError("Arrival Date is required.");

        if (!$("#candidatePassportExpiry").val()) return safeToastrError("Entry Permit Expiry Date is required.");
        if (!$("#ticketFile")[0].files.length) return safeToastrError("Ticket is required.");
        if (!$("#passportStampImage")[0].files.length) return safeToastrError("Immigration Entry Stamp is required.");
        if (!$("#icpProofFile")[0].files.length) return safeToastrError("ICP proof is required.");

        saveButton.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajax({
          url: '<?php echo e(route("candidates.update-arrived-date")); ?>',
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          headers: { "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>" },
          success: function (response) {
            if (response && response.success) {
              safeToastrSuccess(response.message || "Arrival details updated successfully.");
              $("#updateArrivedDateModal").modal("hide");
              form.reset();
              setTimeout(() => location.reload(), 1200);
              return;
            }

            if (response && response.errors) {
              $.each(response.errors, function (key, messages) {
                $.each(messages, function (i, message) { safeToastrError(message); });
              });
              return;
            }

            safeToastrError(response && response.message ? response.message : "Failed to update arrival details.");
          },
          error: function (xhr) {
            const res = xhr.responseJSON;

            if (res && res.errors) {
              $.each(res.errors, function (key, messages) {
                $.each(messages, function (i, message) { safeToastrError(message); });
              });
              return;
            }

            safeToastrError(res && res.message ? res.message : "An error occurred while updating the arrival details.");
          },
          complete: function () {
            saveButton.prop("disabled", false).html('<i class="fas fa-save"></i> Save Changes');
          }
        });
      });

    $("#saveIncidentAfterDeparture")
      .off("click.saveIncidentAfterDeparture")
      .on("click.saveIncidentAfterDeparture", function () {
        const saveButton = $(this);
        const form = $("#incidentAfterDepartureForm")[0];
        const formData = new FormData(form);
        formData.append("_token", "<?php echo e(csrf_token()); ?>");

        const modalId = "#IncidentAfterDepartureModal";
        const details = (window.__candidateDetailsByModal && window.__candidateDetailsByModal[modalId]) ? window.__candidateDetailsByModal[modalId] : {};
        const a = pickAgreement(details) || {};
        formData.set("agreement_id", a.id ?? "");
        formData.set("agreement_reference_no", a.reference_no ?? "");
        formData.set("contract_start_date", a.contract_start_date ?? "");
        formData.set("contract_end_date", a.contract_end_date ?? "");
        formData.set("total_amount", a.total_amount ?? "");
        formData.set("received_amount", a.received_amount ?? "");

        const remarksVal = $("#IncidentAfterDepartureModalremarks").val() || "";
        formData.append("incident_after_departure_remark", remarksVal);

        const incidentReason = $("#incidentCategoryAfterDeparture").val();
        if (!incidentReason) { safeToastrError("Reason is required."); $("#incidentCategoryAfterDeparture").focus(); return; }
        if (incidentReason === "Other" && !$("#otherReasonInputAfterDeparture").val()) { safeToastrError('Specify the reason for "Other".'); $("#otherReasonInputAfterDeparture").focus(); return; }
        if (!$("#incidentProofAfterDeparture")[0].files.length) { safeToastrError("Incident proof is required."); $("#incidentProofAfterDeparture").focus(); return; }

        const decision = $("#IncidentAfterDepartureModal .incident-decision:checked").val() || "Refund";
        formData.set("customer_decision", decision);

        if (decision === "Refund") {
          if (!validateRefundDueDateForModal(modalId)) return;
          const charges = parseFloat($("#IncidentAfterDepartureModaloffice_charges").val()) || 0;
          if (charges < 0) { safeToastrError("Office charges must be 0 or greater."); $("#IncidentAfterDepartureModaloffice_charges").focus(); return; }
        }

        saveButton.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajax({
          url: '<?php echo e(route("candidates.save-incident-after-departure")); ?>',
          type: "POST",
          data: formData,
          processData: false,
          contentType: false
        }).done(function (res) {
          if (res.success) {
            safeToastrSuccess(res.message);
            $("#IncidentAfterDepartureModal").modal("hide");
            $("#incidentAfterDepartureForm")[0].reset();
            setTimeout(() => location.reload(), 2000);
          } else {
            if (res.errors) Object.values(res.errors).flat().forEach(safeToastrError);
            else safeToastrError(res.message || "Failed to save incident.");
          }
        }).fail(function (xhr) {
          const r = xhr.responseJSON || {};
          if (r.errors) Object.values(r.errors).flat().forEach(safeToastrError);
          else safeToastrError(r.message || "An error occurred while saving the incident.");
        }).always(function () {
          saveButton.prop("disabled", false).html("Save");
        });
      });

    $("#saveIncidentAfterArrival")
      .off("click.saveIncidentAfterArrival")
      .on("click.saveIncidentAfterArrival", function () {
        const saveButton = $(this);
        const form = $("#incidentAfterArrivalForm")[0];
        const formData = new FormData(form);
        formData.append("_token", "<?php echo e(csrf_token()); ?>");

        const modalId = "#IncidentAfterArrivalModal";
        const details = (window.__candidateDetailsByModal && window.__candidateDetailsByModal[modalId]) ? window.__candidateDetailsByModal[modalId] : {};
        const a = pickAgreement(details) || {};
        formData.set("agreement_id", a.id ?? "");
        formData.set("agreement_reference_no", a.reference_no ?? "");
        formData.set("contract_start_date", a.contract_start_date ?? "");
        formData.set("contract_end_date", a.contract_end_date ?? "");
        formData.set("total_amount", a.total_amount ?? "");
        formData.set("received_amount", a.received_amount ?? "");

        const remarksVal = $("#IncidentAfterArrivalModalremarks").val() || "";
        formData.append("incident_after_arrival_remark", remarksVal);

        if (!$("#incidentCategoryAfterArrival").val()) { safeToastrError("Reason is required."); $("#incidentCategoryAfterArrival").focus(); return; }
        if ($("#incidentCategoryAfterArrival").val() === "Other" && !$("#otherReasonInputAfterArrival").val()) { safeToastrError('Specify the reason for "Other".'); $("#otherReasonInputAfterArrival").focus(); return; }
        if (!$("#incidentProofAfterArrival")[0].files.length) { safeToastrError("Incident proof is required."); $("#incidentProofAfterArrival").focus(); return; }

        const decision = $("#IncidentAfterArrivalModal .incident-decision:checked").val() || "Refund";
        formData.set("customer_decision", decision);

        if (decision === "Refund") {
          if (!validateRefundDueDateForModal(modalId)) return;
          const charges = parseFloat($("#IncidentAfterArrivalModaloffice_charges").val()) || 0;
          if (charges < 0) { safeToastrError("Office charges must be 0 or greater."); $("#IncidentAfterArrivalModaloffice_charges").focus(); return; }
        }

        saveButton.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajax({
          url: '<?php echo e(route("candidates.save-incident-after-arrival")); ?>',
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            if (response.success) {
              safeToastrSuccess(response.message);
              $("#IncidentAfterArrivalModal").modal("hide");
              $("#incidentAfterArrivalForm")[0].reset();
              setTimeout(() => location.reload(), 2000);
            } else {
              if (response.errors) {
                $.each(response.errors, function (key, messages) {
                  $.each(messages, function (i, message) { safeToastrError(message); });
                });
              } else {
                safeToastrError(response.message || "Failed to save incident.");
              }
            }
          },
          error: function (xhr) {
            const res = xhr.responseJSON;
            if (res && res.errors) {
              $.each(res.errors, function (key, messages) {
                $.each(messages, function (i, message) { safeToastrError(message); });
              });
            } else if (res && res.message) {
              safeToastrError(res.message);
            } else {
              safeToastrError("An error occurred while saving the incident.");
            }
          },
          complete: function () {
            saveButton.prop("disabled", false).html("Save");
          }
        });
      });

    $(document)
      .off("input.transferReceived", "#receivedAmountOutside")
      .on("input.transferReceived", "#receivedAmountOutside", function () {
        const recv = parseNumOrNaN($(this).val());
        const r = isNaN(recv) ? 0 : recv;

        if (r > 0) {
          $("#TransferProofWrap").show();
        } else {
          $("#TransferProofWrap").hide();
          $("#TransferDateModalpaymentProofOutside").val("");
          $("#paymentMethodOutsideForTransfer").val("");
        }
      });

    $("#saveTransferDateButton")
      .off("click.saveTransferDate")
      .on("click.saveTransferDate", function () {
        const btn = $(this);
        const form = $("#transferDateForm")[0];
        const fd = new FormData(form);

        if (!$("#TransferDateModalclient_name").val().trim()) { safeToastrError("Employer Name is required."); $("#TransferDateModalclient_name").focus(); return; }
        if (!$("#transferDate").val()) { safeToastrError("Transfer Date is required."); $("#transferDate").focus(); return; }

        const recvStr = String($("#receivedAmountOutside").val() ?? "").trim();
        const recv = parseNumOrNaN(recvStr);
        const received = (recvStr === "" || isNaN(recv)) ? 0 : recv;

        if (received < 0) { safeToastrError("Received amount cannot be negative."); $("#receivedAmountOutside").focus(); return; }

        if (received > 0) {
          const method = $("#paymentMethodOutsideForTransfer").val();
          if (!method) { safeToastrError("Payment method is required."); $("#paymentMethodOutsideForTransfer").focus(); return; }

          const proofFiles = $("#TransferDateModalpaymentProofOutside")[0].files;
          if (proofFiles.length === 0) { safeToastrError("Payment proof is required for transactions."); $("#TransferDateModalpaymentProofOutside").focus(); return; }
        } else {
          $("#paymentMethodOutsideForTransfer").val("");
          $("#TransferDateModalpaymentProofOutside").val("");
        }

        btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajax({
          url: '<?php echo e(route("candidates.saveTransferDate")); ?>',
          type: "POST",
          data: fd,
          processData: false,
          contentType: false
        }).done(function (res) {
          if (res.success) {
            safeToastrSuccess(res.message);
            $("#TransferDateModal").modal("hide");
            $("#transferDateForm")[0].reset();
            setTimeout(() => location.reload(), 2000);
          } else {
            if (res.errors) Object.values(res.errors).flat().forEach(safeToastrError);
            else safeToastrError(res.message || "Failed to save transfer date.");
          }
        }).fail(function (xhr) {
          const r = xhr.responseJSON || {};
          if (r.errors) Object.values(r.errors).flat().forEach(safeToastrError);
          else safeToastrError(r.message || "An error occurred while saving the transfer date.");
        }).always(function () {
          btn.prop("disabled", false).html('<i class="fas fa-save"></i> Save Changes');
        });
      });

    $("#paymentMethodOutsideForTransfer")
      .off("change.transferProofToggle")
      .on("change.transferProofToggle", function () {
        const recvStr = String($("#receivedAmountOutside").val() ?? "").trim();
        const recv = parseNumOrNaN(recvStr);
        const received = (recvStr === "" || isNaN(recv)) ? 0 : recv;

        if (received > 0 && $(this).val()) $("#TransferProofWrap").show();
        else {
          $("#TransferProofWrap").hide();
          $("#TransferDateModalpaymentProofOutside").val("");
        }
      });

    $("#officePaymentMethod")
      .off("change.officeMethodProofToggle")
      .on("change.officeMethodProofToggle", function () {
        const recvStr = String($("#officeReceivedAmount").val() ?? "").trim();
        const recv = parseNumOrNaN(recvStr);
        const received = (recvStr === "" || isNaN(recv)) ? 0 : recv;

        if (received > 0 && $(this).val()) $("#officePaymentProofRow").show();
        if (received === 0) {
          $("#officePaymentProofRow").hide();
          $("#officePaymentProof").val("");
        }
      });

    $("#govtPaymentMethod")
      .off("change.govtMethodProofToggle")
      .on("change.govtMethodProofToggle", function () {
        const recvStr = String($("#govtReceivedAmount").val() ?? "").trim();
        const recv = parseNumOrNaN(recvStr);
        const received = (recvStr === "" || isNaN(recv)) ? 0 : recv;

        if (received > 0 && $(this).val()) $("#govtPaymentProof").closest(".col-md-8").show();
        if (received === 0) {
          $("#govtPaymentProof").closest(".col-md-8").hide();
          $("#govtPaymentProof").val("");
        }
      });
  });
})(jQuery);

</script>


<?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/outside.blade.php ENDPATH**/ ?>