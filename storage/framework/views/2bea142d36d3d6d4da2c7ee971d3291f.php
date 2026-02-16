<style>
    .table-container{width:100%;overflow-x:auto;position:relative}
    .table{width:100%;border-collapse:collapse}
    .table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .table th{background-color:#343a40;color:#fff;text-transform:uppercase;font-weight:700}
    .table-hover tbody tr:hover{background-color:#f1f1f1}
    .table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}
    .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
    .btn-info{background-color:#17a2b8}
    .btn-warning{background-color:#ffc107;color:#212529}
    .btn-danger{background-color:#dc3545}
    .attachments-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:20px;margin-top:10px}
    .attachment-item{text-align:center}
    .attachment-item p{margin-top:5px;font-size:12px}
    .img-thumbnail{max-width:100px;max-height:100px;object-fit:cover}
    .bg-gradient-primary{background:linear-gradient(to right,#007bff,#6a11cb)}
    .btn-sm{font-size:.8rem}
    .table-warning{background-color:#fff3cd !important}
    .appeal-blink{animation:blink-animation 1.5s infinite;font-weight:700;color:#000}
    @keyframes blink-animation{0%{opacity:1}50%{opacity:.5}100%{opacity:1}}
    .pagination-controls{display:flex;justify-content:center;margin-bottom:10px;align-items:center;gap:20px}
    .pagination-controls i{font-size:12px;cursor:pointer;color:#343a40}
    .pagination-controls i.disabled{color:#ccc;cursor:not-allowed}
    .dropdown-container{display:none;position:fixed;z-index:1050;background-color:#fff;border-radius:8px;padding:20px;box-shadow:0 8px 12px rgba(0,0,0,.2);min-width:350px;max-width:450px;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border:4px solid #007bff;animation:fadeIn .3s ease-in-out}
    .dropdown-header{margin-bottom:15px}
    .dropdown-header .header-icon{font-size:24px;color:#007bff;margin-bottom:10px}
    .dropdown-header p{font-size:12px;font-weight:700;color:#333;margin:5px 0;line-height:1.5}
    .candidate-name{color:#007bff;font-weight:700;font-size:12px}
    .status-dropdown{width:100%;margin-top:10px;font-size:12px;border:2px solid #007bff;border-radius:6px;outline:none;background-color:#fff;color:#333}
    .close-icon{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer;transition:color .3s ease}
    .close-icon:hover{color:#ff4500}
    @keyframes fadeIn{from{opacity:0;transform:translate(-50%,-55%)}to{opacity:1;transform:translate(-50%,-50%)}}
    .dropdown-container .fa-times{cursor:pointer;margin-left:10px;color:#888;font-size:12px}
    .icon-wrapper{display:flex;justify-content:center;align-items:center;width:20px;height:20px;border-radius:50%;background-color:#f0f0f0;box-shadow:0 4px 6px rgba(0,0,0,.1);transition:background-color .3s ease,transform .3s ease;cursor:pointer}
    .icon-wrapper i{font-size:12px;color:#555}
    .icon-wrapper:hover{background-color:#007bff;transform:scale(1.1)}
    .icon-wrapper:hover i{color:#fff}
    .icon-wrapper .disabled{cursor:not-allowed;opacity:.5}
    .icon-wrapper .disabled:hover{transform:none;background-color:#f0f0f0}
    .office-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff}
    .office-modal .modal-header h5{margin:0;font-weight:600}
    .office-modal label{font-weight:500;margin-bottom:3px}
    .office-modal .form-control,.office-modal .form-select{font-size:14px}
    .custom-modal .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3);font-family:Arial,sans-serif;font-size:12px;background:#fff}
    .custom-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0}
    .custom-modal .modal-header h5,.custom-modal .modal-header h4{font-size:12px;font-weight:700;margin:0;color:#fff}
    .custom-modal .modal-header .btn-close{font-size:1.2rem}
    .custom-modal .modal-header .btn-close:hover{opacity:1;transform:scale(1.1)}
    .custom-modal .modal-body{padding:20px;color:#333;background:#f9f9f9}
    .custom-modal .modal-body-scroll{max-height:400px;overflow-y:auto;overflow-x:hidden;padding-right:10px}
    .custom-modal .modal-body-scroll::-webkit-scrollbar{width:8px;background:#f1f1f1}
    .custom-modal .modal-body-scroll::-webkit-scrollbar-thumb{background:#007bff;border-radius:4px}
    .custom-modal .modal-body-scroll::-webkit-scrollbar-thumb:hover{background:#0056b3}
    .custom-modal .modal-footer{padding:15px;border-top:1px solid #ddd;border-radius:0 0 12px 12px;background:#f1f1f1}
    .custom-modal .modal-footer .btn{font-size:12px;padding:8px 15px;border-radius:5px;transition:all .3s}
    .custom-modal .modal-footer .btn-primary{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:none}
    .custom-modal .modal-footer .btn-primary:hover{background:#0056b3;color:#fff}
    .custom-modal .modal-footer .btn-secondary{background:#6c757d;color:#fff;border:none}
    .custom-modal .modal-footer .btn-secondary:hover{background:#565e64;color:#fff}
    .custom-modal .table-container{width:100%;max-height:300px;overflow-x:auto;overflow-y:auto;border:1px solid #ddd;border-radius:8px}
    .custom-modal .table-container::-webkit-scrollbar{width:8px;height:8px}
    .custom-modal .table-container::-webkit-scrollbar-thumb{background:#007bff;border-radius:4px}
    .custom-modal .table-container::-webkit-scrollbar-thumb:hover{background:#0056b3}
    .custom-modal .table{margin-bottom:0;font-size:12px;color:#333}
    .custom-modal .table thead th{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;text-align:center}
    .custom-modal .table tbody tr{border-bottom:1px solid #e9ecef}
    .custom-modal .table tbody tr:hover{background:#f1f1f1}
    .custom-modal .table td,.custom-modal .table th{padding:10px;text-align:left;white-space:nowrap}
    .custom-modal input[type="text"],.custom-modal input[type="number"],.custom-modal input[type="file"],.custom-modal input[type="email"],.custom-modal select,.custom-modal .form-control{font-size:12px;padding:10px;border:1px solid #ddd;border-radius:5px;width:100%;transition:border-color .3s,box-shadow .3s}
    .custom-modal input[type="text"]:focus,.custom-modal input[type="number"]:focus,.custom-modal input[type="file"]:focus,.custom-modal input[type="email"]:focus,.custom-modal select:focus,.custom-modal .form-control:focus{border-color:#007bff;box-shadow:0 0 5px rgba(0,123,255,.5)}
    .custom-modal label{font-weight:400;margin-bottom:5px;color:#000}
    .custom-modal .btn{transition:all .2s ease-in-out;font-size:12px}
    .custom-modal .btn:hover{transform:scale(1.05);box-shadow:0 4px 10px rgba(0,0,0,.1)}
    .custom-modal .pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}
    .custom-modal .pagination{display:flex;gap:.3rem}
    .custom-modal .pagination .page-link{font-size:12px;padding:.5rem .75rem;color:#007bff;background:#fff;border:1px solid #007bff;border-radius:4px;transition:all .2s}
    .custom-modal .pagination .page-link:hover{background:#007bff;color:#fff}
    .custom-modal .pagination .page-item.active .page-link{background:#007bff;color:#fff;border:none}
    .custom-modal .pagination .page-item.disabled .page-link{color:#6c757d;background:#f1f1f1}
    .status-icon{margin-right:6px;font-size:.9rem;vertical-align:-2px}
    .passport-pill{display:inline-flex;align-items:center;gap:6px;padding:3px 8px;border-radius:999px;font-size:10px;font-weight:700;line-height:1;margin-top:6px}
    .passport-pill.ok{background:#e9ecef;color:#212529}
    .passport-pill.warn{background:#ffc107;color:#212529}
    .passport-pill.dang{background:#dc3545;color:#fff}
    .row-passport-warning{background:#fff3cd !important}
    .row-passport-warning:hover{background:#ffe69c !important}
    .row-passport-danger{background:#f8d7da !important}
    .row-passport-danger:hover{background:#f5c2c7 !important}
    .status-stack{display:flex;flex-direction:column;gap:6px;align-items:flex-start}
    .status-badge{display:inline-flex;align-items:center;gap:6px}
    .status-badge i{width:14px;text-align:center}
    /*.fullscreen-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.25);z-index:1040}*/
</style>

<div class="table-container">
    <table class="table table-striped table-hover" id="insidePackagesTable">
        <?php
            $insideMap = [
                0 => ['label' => 'No Status',     'class' => 'secondary', 'icon' => 'minus-circle'],
                1 => ['label' => 'Office',        'class' => 'info',      'icon' => 'building'],
                2 => ['label' => 'Trial',         'class' => 'warning',   'icon' => 'clock'],
                3 => ['label' => 'Confirmed',     'class' => 'success',   'icon' => 'check-circle'],
                4 => ['label' => 'Change Status', 'class' => 'primary',   'icon' => 'sync'],
                5 => ['label' => 'Incident',      'class' => 'danger',    'icon' => 'exclamation-triangle'],
                6 => ['label' => 'Contracted',    'class' => 'secondary', 'icon' => 'handshake'],
                7 => ['label' => 'Completed',     'class' => 'success',   'icon' => 'check-double'],
            ];

            $outsideCurrentMap = [
                0  => ['label' => 'No Status',                     'class' => 'secondary', 'icon' => 'minus-circle'],
                1  => ['label' => 'Available',                     'class' => 'success',   'icon' => 'check-circle'],
                2  => ['label' => 'Back Out',                      'class' => 'secondary', 'icon' => 'undo-alt'],
                3  => ['label' => 'Hold',                          'class' => 'warning',   'icon' => 'pause-circle'],
                4  => ['label' => 'Selected',                      'class' => 'primary',   'icon' => 'user-check'],
                5  => ['label' => 'WC-Date',                       'class' => 'info',      'icon' => 'calendar-check'],
                6  => ['label' => 'Incident Before Visa (IBV)',    'class' => 'danger',    'icon' => 'exclamation-triangle'],
                7  => ['label' => 'Visa Date',                     'class' => 'info',      'icon' => 'passport'],
                8  => ['label' => 'Incident After Visa (IAV)',     'class' => 'danger',    'icon' => 'exclamation-triangle'],
                9  => ['label' => 'Medical Status',                'class' => 'warning',   'icon' => 'stethoscope'],
                10 => ['label' => 'COC-Status',                    'class' => 'primary',   'icon' => 'file-signature'],
                11 => ['label' => 'MoL Submitted Date',            'class' => 'info',      'icon' => 'paper-plane'],
                12 => ['label' => 'MoL Issued Date',               'class' => 'info',      'icon' => 'file-alt'],
                13 => ['label' => 'Departure Date',                'class' => 'secondary', 'icon' => 'plane-departure'],
                14 => ['label' => 'Incident After Departure (IAD)', 'class' => 'danger',   'icon' => 'exclamation-triangle'],
                15 => ['label' => 'Arrived Date',                  'class' => 'success',   'icon' => 'plane-arrival'],
                16 => ['label' => 'Incident After Arrival (IAA)',  'class' => 'danger',    'icon' => 'exclamation-triangle'],
                17 => ['label' => 'Transfer Date',                 'class' => 'success',   'icon' => 'exchange-alt'],
            ];

            $locationMap = [
                1 => ['label' => 'Outside', 'class' => 'dark',    'icon' => 'globe'],
                2 => ['label' => 'Inside',  'class' => 'primary', 'icon' => 'map-marker-alt'],
            ];

            $textColor = fn($cls) => $cls === 'warning' ? '#212529' : '#fff';
            $today = \Carbon\Carbon::now('Asia/Dubai')->startOfDay();
        ?>

        <thead>
            <tr>
                <th>Agree. #</th>
                <th>Selected Date</th>
                <th>Candidate</th>
                <th>Status</th>
                <th>E. Date & Fine</th>
                <th>Client</th>
                <th>WC Date</th>
                <th>Visa Date</th>
                <th>Arrived Date</th>
                <th>Incident</th>
                <th>Updated At</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $insideStatus = $insideMap[$package->inside_status ?? null] ?? ['label' => 'Unknown', 'class' => 'dark', 'icon' => 'question-circle'];
                    $currentOutsideStatus = $outsideCurrentMap[$package->current_status ?? null] ?? ['label' => 'Unknown', 'class' => 'dark', 'icon' => 'question-circle'];
                    $outsideInsideStatus = $locationMap[$package->inside_country_or_outside ?? null] ?? ['label' => 'Unknown', 'class' => 'secondary', 'icon' => 'question-circle'];

                    $isOutside = (int) ($package->inside_country_or_outside ?? 0) === 1;

                    $candidateTitle = $package->candidate_name
                        ? strtoupper(\Illuminate\Support\Str::title(strtolower($package->candidate_name)))
                        : 'N/A';

                    $fineAmount = null;
                    if (isset($package->fine_amount) && $package->fine_amount !== null && $package->fine_amount !== '') {
                        $fineAmount = (float) $package->fine_amount;
                    } elseif (isset($package->fine) && $package->fine !== null && $package->fine !== '') {
                        $fineAmount = (float) $package->fine;
                    } elseif (isset($package->fine_total) && $package->fine_total !== null && $package->fine_total !== '') {
                        $fineAmount = (float) $package->fine_total;
                    }
                    $fineHuman = $fineAmount !== null ? number_format((float) $fineAmount, 2) : null;

                    $icaExpiry = $package->expiry_date ? \Carbon\Carbon::parse($package->expiry_date)->startOfDay() : null;

                    $isExpired = $icaExpiry ? $icaExpiry->lt($today) : false;
                    $daysLeft = ($icaExpiry && !$isExpired) ? $today->diffInDays($icaExpiry) : null;

                    $overDays = $isExpired ? $icaExpiry->diffInDays($today) : 0;
                    $liveFine = (int) round($overDays * 50);

                    $btnClass = $icaExpiry
                        ? ($isExpired ? 'danger' : (($daysLeft !== null && $daysLeft <= 7) ? 'warning' : 'info'))
                        : 'secondary';

                    $btnIcon = $icaExpiry
                        ? ($isExpired ? 'calendar-times' : (($daysLeft !== null && $daysLeft <= 7) ? 'hourglass-half' : 'calendar-check'))
                        : 'calendar-minus';

                    $expiryHuman = $icaExpiry ? $icaExpiry->format('d M Y') : 'N/A';

                    $metaBadgeClass = $isExpired ? 'danger' : (($daysLeft !== null && $daysLeft <= 7) ? 'warning' : 'secondary');
                    $metaTextColor = $metaBadgeClass === 'warning' ? '#212529' : '#fff';

                    $ppExpiry = $package->passport_expiry_date ? \Carbon\Carbon::parse($package->passport_expiry_date)->format('Y-m-d') : '';
                    $ppExpiryHuman = $package->passport_expiry_date ? \Carbon\Carbon::parse($package->passport_expiry_date)->format('d M Y') : '';
                ?>

                <tr
                    data-package-id="<?php echo e($package->id); ?>"
                    data-cn="<?php echo e(strtoupper($package->CN_Number ?? '')); ?>"
                    data-candidate="<?php echo e(e($candidateTitle)); ?>"
                    data-nationality="<?php echo e(strtoupper($package->nationality ?? '')); ?>"
                    data-passport="<?php echo e(strtoupper($package->passport_no ?? '')); ?>"
                    data-passport-expiry="<?php echo e($ppExpiry); ?>"
                    data-passport-expiry-human="<?php echo e($ppExpiryHuman); ?>"
                    data-sponsor-name="<?php echo e(strtoupper($package->sponsor_name ?? '')); ?>"
                    data-sponsor-qid="<?php echo e(strtoupper($package->eid_no ?? '')); ?>"
                >
                    <td class="align-middle">
                        <a href="" class="text-decoration-none" style="color:#007bff">
                            <?php echo e(strtoupper($package->agreement_no)); ?>

                        </a>
                        <?php $agStatus = $package->agreement?->status; ?>
                        <div class="text-muted small mt-1">
                            <?php switch($agStatus):
                                case (1): ?>
                                    <i class="fas fa-clock text-warning status-icon" title="Pending"></i> PENDING
                                    <?php break; ?>
                                <?php case (2): ?>
                                    <i class="fas fa-check-circle text-success status-icon" title="Active"></i> ACTIVE
                                    <?php break; ?>
                                <?php case (3): ?>
                                    <i class="fas fa-exclamation-circle text-warning status-icon" title="Exceeded"></i> EXCEEDED
                                    <?php break; ?>
                                <?php case (4): ?>
                                    <i class="fas fa-times-circle text-danger status-icon" title="Rejected"></i> REJECTED
                                    <?php break; ?>
                                <?php case (5): ?>
                                    <i class="fas fa-file-signature text-success status-icon" title="Contracted"></i> CONTRACTED
                                    <?php break; ?>
                                <?php default: ?>
                                    <i class="fas fa-question-circle text-secondary status-icon" title="Unknown"></i> UNKNOWN
                            <?php endswitch; ?>
                        </div>
                    </td>

                    <td class="align-middle text-center">
                        <div><?php echo e(\Carbon\Carbon::parse($package->created_at)->format('d M Y')); ?></div>
                        <div class="text-muted small mt-1" title="<?php echo e($package->sales_name); ?>">
                            <?php echo e(strtoupper(explode(' ', $package->sales_name)[0])); ?>

                        </div>
                    </td>

                    <td class="align-middle">
                        <a
                            href="<?php echo e(url('package/'.$package->id)); ?>"
                            target="_blank"
                            class="text-decoration-none"
                            style="color:#007bff"
                        >
                            <?php echo e($package->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($package->candidate_name))) : 'N/A'); ?>

                        </a>

                        <img
                            src="<?php echo e(asset('assets/img/attach.png')); ?>"
                            alt="Attachment Icon"
                            style="cursor:pointer;margin-left:8px;vertical-align:middle;height:20px"
                            title="View Attachments of the Candidate"
                            onclick="showCandidateModal('<?php echo e($package->candidate_name); ?>','<?php echo e($package->id); ?>','<?php echo e($package->reference_no); ?>')"
                        />

                        <div class="text-muted small mt-1">
                            <?php echo e(strtoupper($package->passport_no)); ?> — <?php echo e(strtoupper($package->nationality)); ?> — <?php echo e(strtoupper(\Illuminate\Support\Str::before($package->foreign_partner ?? '', ' '))); ?> - <?php echo e($package->CN_Number ?? ''); ?>

                        </div>

                        <div class="passport-pill ok">
                            <i class="fas fa-passport"></i>
                            <span class="pp-exp-state"><?php echo e($ppExpiryHuman ? strtoupper($ppExpiryHuman) : 'N/A'); ?></span>
                        </div>
                    </td>

                    <td class="align-middle">
                        <div class="status-stack">
                            <span class="btn btn-sm btn-<?php echo e($outsideInsideStatus['class']); ?> status-badge" style="font-size:10px;color:<?php echo e($textColor($outsideInsideStatus['class'])); ?>">
                                <i class="fas fa-<?php echo e($outsideInsideStatus['icon']); ?>"></i> <?php echo e(strtoupper($outsideInsideStatus['label'])); ?>

                            </span>

                            <?php if($isOutside): ?>
                                <span class="btn btn-sm btn-<?php echo e($currentOutsideStatus['class']); ?> status-badge" style="font-size:10px;color:<?php echo e($textColor($currentOutsideStatus['class'])); ?>">
                                    <i class="fas fa-<?php echo e($currentOutsideStatus['icon']); ?>"></i> <?php echo e(strtoupper($currentOutsideStatus['label'])); ?>

                                </span>

                                <span class="btn btn-sm btn-<?php echo e($insideStatus['class']); ?> status-badge" style="font-size:10px;color:<?php echo e($textColor($insideStatus['class'])); ?>">
                                    <i class="fas fa-<?php echo e($insideStatus['icon']); ?>"></i> <?php echo e(strtoupper($insideStatus['label'])); ?>

                                </span>
                            <?php else: ?>
                                <span class="btn btn-sm btn-<?php echo e($insideStatus['class']); ?> status-badge" style="font-size:10px;color:<?php echo e($textColor($insideStatus['class'])); ?>">
                                    <i class="fas fa-<?php echo e($insideStatus['icon']); ?>"></i> <?php echo e(strtoupper($insideStatus['label'])); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </td>

                    <td class="align-middle text-center">
                        <div class="d-inline-flex flex-column align-items-center" style="gap:6px;min-width:170px">
                            <span class="btn btn-sm btn-<?php echo e($btnClass); ?> px-2" style="font-size:10px;color:<?php echo e($textColor($btnClass)); ?>;white-space:nowrap">
                                <i class="fas fa-<?php echo e($btnIcon); ?>"></i>
                                <span class="ms-1"> EXP: <?php echo e(strtoupper($expiryHuman)); ?></span>
                            </span>

                            <div class="d-inline-flex align-items-center justify-content-center flex-wrap" style="gap:6px">
                                <span class="badge bg-<?php echo e($metaBadgeClass); ?>" style="font-size:10px;color:<?php echo e($metaTextColor); ?>;padding:6px 8px;border-radius:999px;white-space:nowrap">
                                    <i class="fas fa-hourglass-end"></i>
                                    <span class="ms-1"><?php echo e($isExpired ? 'OVER: '.$overDays.' D' : ($icaExpiry ? 'LEFT: '.$daysLeft.' D' : 'LEFT: N/A')); ?></span>
                                </span>

                                <span class="badge bg-primary" style="font-size:10px;color:#fff;padding:6px 8px;border-radius:999px;white-space:nowrap">
                                    <i class="fas fa-coins"></i>
                                    <span class="ms-1">FINE: <?php echo e(number_format($liveFine, 0)); ?> AED</span>
                                </span>
                            </div>
                        </div>
                    </td>

                    <td class="align-middle">
                        <a href="" class="text-decoration-none" style="color:#007bff">
                            <?php echo e(strtoupper($package->sponsor_name)); ?>

                        </a>
                        <div class="text-muted small mt-1">
                            CLIENT #: <?php echo e(strtoupper($package->CL_Number)); ?> — EID: <?php echo e(strtoupper($package->eid_no)); ?>

                        </div>
                    </td>

                    <td class="align-middle">
                        <div><?php echo e($package->wc_date ? \Carbon\Carbon::parse($package->wc_date)->format('d M Y') : 'N/A'); ?></div>
                        <div class="text-muted small mt-1">
                            DW #: <?php echo e(strtoupper($package->dw_number ?? 'N/A')); ?>

                        </div>
                    </td>

                    <td class="align-middle">
                        <div><?php echo e($package->visa_date ? \Carbon\Carbon::parse($package->visa_date)->format('d M Y') : 'N/A'); ?></div>
                        <div class="text-muted small mt-1">
                            <?php echo e($package->visa_type ? strtoupper($package->visa_type) : 'N/A'); ?>

                        </div>
                    </td>

                    <td class="align-middle">
                        <?php echo e($package->arrived_date ? \Carbon\Carbon::parse($package->arrived_date)->format('d M Y') : 'N/A'); ?>

                    </td>

                    <td class="align-middle">
                        <div><?php echo e($package->incident_date ? \Carbon\Carbon::parse($package->incident_date)->format('d M Y') : 'N/A'); ?></div>
                        <div class="text-muted small mt-1">
                            <?php echo e($package->incident_type ? strtoupper($package->incident_type) : 'N/A'); ?>

                        </div>
                    </td>

                    <td class="align-middle">
                        <?php echo e(\Carbon\Carbon::parse($package->updated_at)->format('d M Y h:i A')); ?>

                    </td>

                    <td class="align-middle">
                        <?php echo e(strtoupper($package->remarks)); ?>

                    </td>

                    <td class="align-middle" id="action-cell-<?php echo e($package->id); ?>">
                        <a href="<?php echo e(route('package.edit', $package->id)); ?>" class="btn btn-primary btn-icon-only" title="Edit Package">
                            <i class="fas fa-edit"></i>
                        </a>

                        <?php if(in_array($package->inside_status, [0, 1])): ?>
                            <a href="javascript:void(0)" class="btn btn-success btn-icon-only" onclick="openConsentModal('<?php echo e($package->id); ?>','<?php echo e($package->candidate_name); ?>')" title="Consent">
                                <i class="fas fa-exchange-alt"></i>
                            </a>
                        <?php endif; ?>

                        <?php if($package->inside_status === 0 || $package->inside_status === 6): ?>
                            <a href="javascript:void(0);" class="btn btn-primary btn-icon-only" onclick="openDropdown('<?php echo e($package->id); ?>', this, '<?php echo e($package->candidate_name); ?>')" title="Change Status">
                                <i class="fas fa-train"></i>
                            </a>

                            <div class="dropdown-container" id="dropdownContainer-<?php echo e($package->id); ?>">
                                <div class="close-icon" onclick="closeAllDropdowns()">
                                    <i class="fas fa-times-circle"></i>
                                </div>

                                <div class="dropdown-header">
                                    <div class="header-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <p>Change status for <span class="candidate-name"><?php echo e($package->candidate_name); ?></span></p>
                                </div>

                                <select
                                    class="form-control status-dropdown"
                                    data-original="<?php echo e($package->inside_status); ?>"
                                    onchange="confirmStatusChange(this,'<?php echo e($package->id); ?>','<?php echo e($package->candidate_name); ?>')"
                                >
                                    <?php
                                        $allowed = [
                                            0 => 'Change Status',
                                            1 => 'Office',
                                            5 => 'Incident',
                                        ];
                                    ?>
                                    <?php $__currentLoopData = $allowed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>" <?php if($package->inside_status == $id): echo 'selected'; endif; ?>><?php echo e($name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if(in_array($package->inside_status, [1])): ?>
                            <a href="<?php echo e(route('package.exit', $package->cn_number_series)); ?>" class="btn btn-danger btn-icon-only" title="Exit">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        <?php endif; ?>

                        <a href="<?php echo e(route('package.showCV', ['package' => $package->cn_number_series])); ?>" target="_blank" class="btn btn-info btn-icon-only ms-1" title="View CV">
                            <i class="fas fa-file-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="13" class="text-center">No results found.</td>
                </tr>
            <?php endif; ?>
        </tbody>

        <tfoot>
            <tr>
                <th>Agree. #</th>
                <th>Selected Date</th>
                <th>Candidate</th>
                <th>Status</th>
                <th>E. Date & Fine</th>
                <th>Client</th>
                <th>WC Date</th>
                <th>Visa Date</th>
                <th>Arrived Date</th>
                <th>Incident</th>
                <th>Updated At</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>

<div class="fullscreen-overlay" id="fullscreenOverlay" onclick="closeAllDropdowns()"></div>

<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing <?php echo e($packages->firstItem()); ?> to <?php echo e($packages->lastItem()); ?> of <?php echo e($packages->total()); ?> results
        </span>
        <ul class="pagination justify-content-center">
            <?php echo e($packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

        </ul>
    </div>
</nav>

<div class="modal fade custom-modal" id="consentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transfer to Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Do you want to transfer <strong id="consentCandidate"></strong> to employees? This will disable the package.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmTransferBtn">Yes, Transfer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade office-modal" id="officeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-building me-2"></i> Office Details</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-info-circle me-2"></i>Information</h6>
                    <table class="table table-bordered">
                        <tbody>
                            <tr><th style="width:30%" class="bg-secondary text-white"><i class="fas fa-user"></i> Sales Name</th><td id="office_sales_name"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-handshake"></i> Partner</th><td id="office_partner"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-hashtag"></i> CN Number</th><td id="office_cn_number"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-hashtag"></i> CL Number</th><td id="office_cl_number"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-passport"></i> Visa Type</th><td id="office_visa_type"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-info-circle"></i> Visa Status</th><td id="office_visa_status"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-box-open"></i> Package</th><td id="office_package_value"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-plane-arrival"></i> Arrived Date</th><td id="office_arrived_date"></td></tr>
                            <tr><th class="bg-secondary text-white"><i class="fas fa-exchange-alt"></i> Transfer Date</th><td id="office_transferred_date"></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-edit me-2"></i>Form</h6>
                    <form id="officeForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="package_id" id="package_id" value="">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category">Category</label>
                                <select id="category" name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Sales return">Sales return</option>
                                    <option value="Trial return">Trial return</option>
                                    <option value="Absconding">Absconding</option>
                                    <option value="Repatriation">Repatriation</option>
                                    <option value="Reserved">Reserved</option>
                                    <option value="New arrival">New arrival</option>
                                    <option value="Hospital">Hospital</option>
                                    <option value="Embassy">Embassy</option>
                                    <option value="Sick">Sick</option>
                                    <option value="Waiting ticket">Waiting ticket</option>
                                    <option value="Runaway">Runaway</option>
                                    <option value="Unfit">Unfit</option>
                                    <option value="Pregnant">Pregnant</option>
                                    <option value="Valid visa">Valid visa</option>
                                    <option value="Valid residency">Valid residency</option>
                                    <option value="Refused">Refused</option>
                                    <option value="Psychiatric">Psychiatric</option>
                                    <option value="Embassy shelter">Embassy shelter</option>
                                    <option value="Police station">Police station</option>
                                    <option value="Jail">Jail</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="returned_date">Returned Date</label>
                                <input type="date" name="returned_date" id="returned_date" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="expiry_date">Cancellation Expiry</label>
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="ica_proof_attachment">ICA Proof Attachment</label>
                                <input type="file" name="ica_proof_attachment" id="ica_proof_attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="overstay_days">Overstay Days</label>
                                <input type="number" name="overstay_days" id="overstay_days" class="form-control" value="0" min="0" step="1">
                            </div>
                            <div class="col-md-6">
                                <label for="fine_amount">Fine Amount</label>
                                <input type="number" name="fine_amount" id="fine_amount" class="form-control" value="0" min="0" step="0.01">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="passport_status" class="form-label">Passport Status</label>
                                <select id="passport_status" name="passport_status" class="form-select">
                                    <option value="">Select Passport Status</option>
                                    <option value="With Employer">With Employer</option>
                                    <option value="With Candidate">With Candidate</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Office">Office</option>
                                    <option value="Lost">Lost</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Close
                            </button>
                            <button type="button" id="saveOfficeBtn" class="btn btn-success" onclick="saveOfficeData()">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-modal" id="incidentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="incidentForm" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="im_refund_type" name="refund_type" value="package">
            <input type="hidden" id="im_refund_type_label" name="refund_type_label" value="Inside - All">
            <input type="hidden" id="im_candidate_id" name="candidate_id">
            <input type="hidden" id="im_candidate_reference_no" name="candidate_reference_no">
            <input type="hidden" id="im_candidate_ref_no" name="candidate_ref_no">
            <input type="hidden" id="im_foreign_partner" name="foreign_partner">
            <input type="hidden" id="im_candidate_nationality" name="candidate_nationality">
            <input type="hidden" id="im_candidate_passport_number" name="candidate_passport_number">
            <input type="hidden" id="im_candidate_passport_expiry" name="candidate_passport_expiry">
            <input type="hidden" id="im_candidate_dob" name="candidate_dob">
            <input type="hidden" id="im_agreement_id" name="agreement_id">
            <input type="hidden" id="im_agreement_reference_no" name="agreement_reference_no">
            <input type="hidden" id="im_agreement_type" name="agreement_type">
            <input type="hidden" id="im_agreement_client_id" name="agreement_client_id">
            <input type="hidden" id="im_remaining_with_vat" value="0">
            <input type="hidden" id="im_vat_amount" name="vat_amount" value="0">
            <input type="hidden" id="im_remaining_amount" name="remaining_amount" value="0">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Incident</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-lg-6">
                            <label for="im_candidate_name" class="form-label"><i class="fas fa-user me-1"></i> Candidate Name <span class="text-danger">*</span></label>
                            <input type="text" id="im_candidate_name" name="candidate_name" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-lg-6">
                            <label for="im_sponsor_name" class="form-label"><i class="fas fa-building me-1"></i> Sponsor Name <span class="text-danger">*</span></label>
                            <input type="text" id="im_sponsor_name" name="employer_name" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-lg-6">
                            <label for="im_sponsor_qid" class="form-label"><i class="fas fa-id-card me-1"></i> Sponsor QID</label>
                            <input type="text" id="im_sponsor_qid" name="sponsor_qid" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-lg-6">
                            <label for="im_incident_category" class="form-label"><i class="fas fa-layer-group me-1"></i> Category</label>
                            <input type="text" id="im_incident_category" name="incident_category" class="form-control form-control-sm" value="Inside - All" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="im_incident_reason" class="form-label"><strong><i class="fas fa-list-alt me-1"></i> Select Reason</strong></label>
                        <select id="im_incident_reason" name="incident_reason" class="form-select" required>
                            <option value="">Select Reason</option>
                            <option value="RUNAWAY">RUNAWAY</option>
                            <option value="REPATRIATION">REPATRIATION</option>
                            <option value="UNFIT">UNFIT</option>
                            <option value="SICK">SICK</option>
                            <option value="REFUSED">REFUSED</option>
                            <option value="PSYCHIATRIC">PSYCHIATRIC</option>
                            <option value="RESERVED">RESERVED</option>
                            <option value="ABSCONDING">ABSCONDING</option>
                            <option value="RELEASED">RELEASED</option>
                            <option value="MOHRE COMPLAIN">MOHRE COMPLAIN</option>
                            <option value="Other">Other</option>
                            <option value="Valid Visa">Valid Visa</option>
                            <option value="Valid Resident">Valid Resident</option>
                        </select>

                        <div id="im_other_reason_wrap" class="mt-2" style="display:none;">
                            <label for="im_other_reason" class="form-label"><strong><i class="fas fa-pen me-1"></i> Specify Reason</strong></label>
                            <input type="text" id="im_other_reason" name="other_reason" class="form-control" placeholder="Write reason here">
                        </div>

                        <div id="im_expiry_wrap" class="mb-3" style="display:none;margin-top:10px;">
                            <label for="im_incident_expiry_date" class="form-label"><strong><i class="fas fa-calendar-alt me-1"></i> Expiry Date of Incident</strong></label>
                            <input type="date" id="im_incident_expiry_date" name="incident_expiry_date" class="form-control">
                        </div>
                    </div>

                    <div id="im_no_agreement" class="alert alert-warning d-none">
                        There is no agreement exist related this candidate.
                    </div>

                    <div class="card border-warning mb-3 incident-agreement-card" id="im_agreement_card">
                        <div class="card-body mt-2">
                            <div class="incident-agreement-head">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h6 class="m-0 fw-semibold">
                                        <i class="fas fa-file-contract me-1"></i> Agreement Details
                                    </h6>
                                </div>
                            </div>

                            <div class="incident-decision-wrap d-flex gap-4 align-items-center flex-wrap">
                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" id="im_decision_refund" name="customer_decision" value="Refund" checked>
                                    <label class="form-check-label" for="im_decision_refund">Refund</label>
                                </div>

                                <div class="form-check m-0">
                                    <input class="form-check-input" type="checkbox" id="im_decision_replacement" name="customer_decision" value="Replacement">
                                    <label class="form-check-label" for="im_decision_replacement">Replacement</label>
                                </div>
                            </div>

                            <div class="mt-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle mb-0 incident-agreement-table">
                                        <tbody>
                                            <tr>
                                                <th style="width:45%;">Agreement Reference No</th>
                                                <td><input type="text" id="im_agreement_reference_no_text" class="form-control form-control-sm" readonly></td>
                                            </tr>

                                            <tr>
                                                <th>Contract Start Date</th>
                                                <td><input type="text" id="im_contract_start_date" name="agreement_start_date" class="form-control form-control-sm" readonly></td>
                                            </tr>

                                            <tr>
                                                <th>Contract End Date</th>
                                                <td><input type="text" id="im_contract_end_date" name="agreement_end_date" class="form-control form-control-sm" readonly></td>
                                            </tr>

                                            <tr>
                                                <th>Total Amount</th>
                                                <td><input type="text" id="im_total_amount" name="contracted_amount" class="form-control form-control-sm" readonly></td>
                                            </tr>

                                            <tr>
                                                <th>Received Amount</th>
                                                <td><input type="text" id="im_received_amount" name="received_amount" class="form-control form-control-sm" readonly></td>
                                            </tr>

                                            <tr>
                                                <th>Office Charges</th>
                                                <td><input type="number" min="0" step="0.01" id="im_office_charges" name="office_charges" class="form-control form-control-sm" value="0"></td>
                                            </tr>

                                            <tr>
                                                <th><span id="im_balance_label">Refund Balance</span></th>
                                                <td><input type="text" id="im_balance_amount" name="balance_amount" class="form-control form-control-sm" readonly></td>
                                            </tr>

                                            <tr>
                                                <th><span id="im_due_label">Refund Due Date</span></th>
                                                <td><input type="date" id="im_refund_due_date" name="refund_due_date" class="form-control form-control-sm" autocomplete="off"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="im_proof" class="form-label"><strong><i class="fas fa-upload me-1"></i> Upload Incident Proof</strong></label>
                        <input type="file" id="im_proof" name="proof" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>

                    <div class="mb-3">
                        <label for="im_remarks" class="form-label"><strong><i class="fas fa-comment-dots me-1"></i> Add Remark (Optional)</strong></label>
                        <textarea id="im_remarks" name="remarks" class="form-control" rows="4" placeholder="Write your remarks here..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                    <button type="button" id="im_save_btn" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
(() => {
    const csrfToken='<?php echo e(csrf_token()); ?>';
    const routes={
        transferToEmployees:'<?php echo e(route('transfer-to-employees')); ?>',
        officeData:"<?php echo e(route('package.officeData' , ':id')); ?>",
        officeSave:"<?php echo e(route('package.officeSave')); ?>",
        incidentSave:"<?php echo e(route('package.incidentSave')); ?>",
        insideStatusUpdate:"<?php echo e(route('packages.update-status-inside', ['packageId' => ':id'])); ?>"
    };

    let activePackageId=null;

    const modalEl=id=>document.getElementById(id);
    const getModal=id=>bootstrap.Modal.getOrCreateInstance(modalEl(id),{backdrop:true,keyboard:true});
    const showModal=id=>getModal(id).show();
    const hideModal=id=>getModal(id).hide();

    const parseNum=v=>{
        const s=String(v??'').replace(/[^0-9.\-]/g,'');
        const n=parseFloat(s);
        return Number.isFinite(n)?n:0;
    };

    const money=n=>{
        const x=Number.isFinite(n)?n:0;
        return x.toFixed(2);
    };

    const getRowByPackageId=packageId=>{
        return document.querySelector(`#insidePackagesTable tbody tr[data-package-id="${packageId}"]`);
    };

    const pad2=n=>String(n).padStart(2,'0');
    const ymdFromLocalDate=d=>`${d.getFullYear()}-${pad2(d.getMonth()+1)}-${pad2(d.getDate())}`;
    const localMidnight=()=>{const d=new Date();d.setHours(0,0,0,0);return d;};
    const addDaysLocal=(base,days)=>{const d=new Date(base.getTime());d.setDate(d.getDate()+days);return d;};
    const parseYmdLocal=ymd=>{
        if(!ymd) return null;
        const m=/^(\d{4})-(\d{2})-(\d{2})$/.exec(String(ymd).trim());
        if(!m) return null;
        const y=Number(m[1]),mo=Number(m[2])-1,da=Number(m[3]);
        const d=new Date(y,mo,da,0,0,0,0);
        return Number.isFinite(d.getTime())?d:null;
    };

    const DueDateRules={minDays:7,blockedDow:[0],selector:'#im_refund_due_date'};
    const getDueDateMin=()=>addDaysLocal(localMidnight(),DueDateRules.minDays);

    const applyDueDateConstraints=()=>{
        const min=getDueDateMin();
        const minYmd=ymdFromLocalDate(min);
        const $inp=$(DueDateRules.selector);
        $inp.attr('min',minYmd);
        const cur=$inp.val();
        if(cur){
            const d=parseYmdLocal(cur);
            if(!d){$inp.val('');return;}
            if(d.getTime()<min.getTime()||DueDateRules.blockedDow.includes(d.getDay())) $inp.val('');
        }
    };

    const validateDueDate=({showToast=true}={})=>{
        const val=$(DueDateRules.selector).val();
        if(!val){if(showToast) toastr.error('Please select refund due date.');return false;}
        const d=parseYmdLocal(val);
        if(!d){if(showToast) toastr.error('Invalid refund due date.');$(DueDateRules.selector).val('');return false;}
        const min=getDueDateMin();
        if(d.getTime()<min.getTime()){if(showToast) toastr.error(`Refund due date must be at least ${DueDateRules.minDays} days from today.`);$(DueDateRules.selector).val('');return false;}
        if(DueDateRules.blockedDow.includes(d.getDay())){if(showToast) toastr.error('Sunday is not allowed. Please choose another date.');$(DueDateRules.selector).val('');return false;}
        return true;
    };

    const validateFileExt=(inputSel,allowed)=>{
        const v=$(inputSel).val()||'';
        if(!v) return true;
        const ext=v.split('.').pop().toLowerCase();
        if(!allowed.includes(ext)){toastr.error(`Only ${allowed.join(', ').toUpperCase()} files are allowed.`);$(inputSel).val('');return false;}
        return true;
    };

    $(document).on('change','#ica_proof_attachment,#im_proof',function(){
        validateFileExt(this,['pdf','jpg','jpeg','png']);
    });

    window.openConsentModal=(id,name)=>{
        activePackageId=id;
        $('#consentCandidate').text(name||'');
        showModal('consentModal');
    };

    $('#confirmTransferBtn').on('click',()=>{
        if(!activePackageId){toastr.error('Package not found.');hideModal('consentModal');return;}
        $.ajax({
            url:routes.transferToEmployees,
            type:'POST',
            headers:{'X-CSRF-TOKEN':csrfToken},
            data:{package_id:activePackageId},
            success:()=>{
                hideModal('consentModal');
                toastr.success('Transferred successfully.');
                setTimeout(()=>location.reload(),1200);
            },
            error:xhr=>{
                hideModal('consentModal');
                const msg=xhr.responseJSON?.message||xhr.responseJSON?.error||xhr.statusText||'Transfer failed.';
                toastr.error(msg);
            }
        });
    });

    const officeModalSelectors={
        salesName:'#office_sales_name',
        partner:'#office_partner',
        cnNumber:'#office_cn_number',
        clNumber:'#office_cl_number',
        visaType:'#office_visa_type',
        visaStatus:'#office_visa_status',
        packageValue:'#office_package_value',
        arrivedDate:'#office_arrived_date',
        transferredDate:'#office_transferred_date'
    };

    const setOfficeInfo=(res={})=>{
        $(officeModalSelectors.salesName).text(String(res.sales_name||'N/A').toUpperCase());
        $(officeModalSelectors.partner).text(String(res.partner||'N/A').toUpperCase());
        $(officeModalSelectors.cnNumber).text(String(res.cn_number||'N/A').toUpperCase());
        $(officeModalSelectors.clNumber).text(String(res.cl_number||'N/A').toUpperCase());
        $(officeModalSelectors.visaType).text(String(res.visa_type||'N/A').toUpperCase());
        $(officeModalSelectors.visaStatus).text(String(res.visa_status||'N/A').toUpperCase());
        $(officeModalSelectors.packageValue).text(String(res.package||'N/A').toUpperCase());
        $(officeModalSelectors.arrivedDate).text(res.arrived_date||'N/A');
        $(officeModalSelectors.transferredDate).text(res.transferred_date||'N/A');
    };

    const fillOfficeForm=(res={})=>{
        $('#category').val(res.category||'');
        $('#returned_date').val(res.returned_date||'');
        $('#expiry_date').val(res.expiry_date||'');
        $('#overstay_days').val(String(parseNum(res.overstay_days)));
        $('#fine_amount').val(String(parseNum(res.fine_amount)));
        $('#passport_status').val(res.passport_status||'');
        $('#ica_proof_attachment').val('');
    };

    window.openOfficeModal=packageId=>{
        Object.values(officeModalSelectors).forEach(sel=>$(sel).text(''));
        $('#package_id').val(packageId);
        document.getElementById('officeForm').reset();
        $('#ica_proof_attachment').val('');
        $.ajax({
            url:routes.officeData.replace(':id',packageId),
            type:'GET',
            headers:{'X-CSRF-TOKEN':csrfToken},
            success:res=>{
                setOfficeInfo(res||{});
                fillOfficeForm(res||{});
                showModal('officeModal');
            },
            error:()=>{
                toastr.error('Failed to load office data. Please try again.');
            }
        });
    };

    window.saveOfficeData=()=>{
        if(!validateFileExt('#ica_proof_attachment',['pdf','jpg','jpeg','png'])) return;
        const fd=new FormData(document.getElementById('officeForm'));
        const pkgId=$('#package_id').val();
        if(!pkgId){toastr.error('Package not found.');return;}
        $.ajax({
            url:routes.officeSave,
            type:'POST',
            headers:{'X-CSRF-TOKEN':csrfToken},
            data:fd,
            processData:false,
            contentType:false,
            success:()=>{
                toastr.success('Data saved successfully!');
                hideModal('officeModal');
                setTimeout(()=>location.reload(),800);
            },
            error:xhr=>{
                const msg=xhr.responseJSON?.message||xhr.responseJSON?.error||'Failed to save data. Please check your inputs and try again.';
                toastr.error(msg);
            }
        });
    };

    window.openDropdown=(packageId,_btnEl,candidateName)=>{
        $('.dropdown-container').hide();
        $('#fullscreenOverlay').stop(true,true).fadeIn(120);
        const $c=$(`#dropdownContainer-${packageId}`);
        $c.find('.candidate-name').text(candidateName||'');
        $c.stop(true,true).css({display:'block',opacity:0}).animate({opacity:1},160);
    };

    window.closeAllDropdowns=()=>{
        $('.dropdown-container').stop(true,true).fadeOut(120);
        $('#fullscreenOverlay').stop(true,true).fadeOut(120);
    };

    const updateInsideStatus=(packageId,statusId)=>{
        const url=routes.insideStatusUpdate.replace(':id',packageId);
        return $.ajax({
            url,
            type:'POST',
            headers:{'X-CSRF-TOKEN':csrfToken},
            dataType:'json',
            data:{status_id:statusId}
        });
    };

    const setDecisionUi=()=>{
        const isRefund=$('#im_decision_refund').prop('checked');
        const title=isRefund?'Refund':'Replacement';
        $('#im_balance_label').text(title==='Refund'?'Refund Balance':'Replacement Balance');
        $('#im_due_label').text(title==='Refund'?'Refund Due Date':'Replacement Due Date');
    };

    const enforceSingleDecision=changedId=>{
        const $r=$('#im_decision_refund');
        const $p=$('#im_decision_replacement');
        if(changedId==='refund'){
            if($r.prop('checked')) $p.prop('checked',false);
            else $r.prop('checked',true);
        }else{
            if($p.prop('checked')) $r.prop('checked',false);
            else $p.prop('checked',true);
        }
        setDecisionUi();
    };

    const clampOfficeCharges=()=>{
        let received=parseNum($('#im_received_amount').val());
        let oc=parseNum($('#im_office_charges').val());
        if(oc<0) oc=0;
        if(oc>received) oc=received;
        $('#im_office_charges').val(money(oc));
        return {received,oc};
    };

    const setBalance=()=>{
        const {received,oc}=clampOfficeCharges();
        const bal=Math.max(received-oc,0);
        $('#im_balance_amount').val(money(bal));
    };

    const resetIncidentModal=()=>{
        document.getElementById('incidentForm').reset();
        $('#im_refund_type').val('package');
        $('#im_refund_type_label').val('Inside - All');
        $('#im_incident_category').val('Inside - All');
        $('#im_decision_refund').prop('checked',true);
        $('#im_decision_replacement').prop('checked',false);
        $('#im_remaining_with_vat').val('0');
        $('#im_vat_amount').val('0');
        $('#im_remaining_amount').val('0');
        $('#im_office_charges').val('0');
        $('#im_received_amount').val('0.00');
        $('#im_balance_amount').val('0.00');
        $('#im_other_reason_wrap').hide();
        $('#im_expiry_wrap').hide();
        $('#im_no_agreement').addClass('d-none');
        $('#im_agreement_card').removeClass('d-none');
        $('#im_proof').val('');
        setDecisionUi();
        setBalance();
        applyDueDateConstraints();
    };

    const applyReasonUi=()=>{
        const r=String($('#im_incident_reason').val()||'');
        $('#im_other_reason_wrap').toggle(r==='Other');
        const showExpiry=(r==='Valid Resident'||r==='Valid Visa'||r==='MOHRE COMPLAIN');
        $('#im_expiry_wrap').toggle(showExpiry);
        if(!showExpiry) $('#im_incident_expiry_date').val('');
        if(r!=='Other') $('#im_other_reason').val('');
    };

    window.openIncidentModal=packageId=>{
        resetIncidentModal();
        updateInsideStatus(packageId,5)
            .done(res=>{
                if(!res?.success||!res?.candidateDetails){
                    toastr.error(res?.message||'Failed to load incident data.');
                    return;
                }

                const cd=res.candidateDetails||{};
                const ag=cd.agreement||{};
                const totals=cd.invoice_totals||{};
                const row=getRowByPackageId(packageId);

                const sponsorName=(cd.sponsorName||cd.clientName||cd.employerName||row?.dataset?.sponsorName||'');
                const sponsorQid=(cd.sponsorQid||row?.dataset?.sponsorQid||'');

                $('#im_candidate_id').val(cd.candidateId||packageId);
                $('#im_candidate_reference_no').val(cd.referenceNo||'');
                $('#im_candidate_ref_no').val(cd.ref_no||'');
                $('#im_foreign_partner').val(cd.foreignPartner||'');
                $('#im_candidate_nationality').val(cd.nationality||'');
                $('#im_candidate_passport_number').val(cd.passportNo||'');
                $('#im_candidate_passport_expiry').val(cd.passportExpiry||'');
                $('#im_candidate_dob').val(cd.dob||'');

                $('#im_candidate_name').val(cd.candidate_name||'');
                $('#im_sponsor_name').val(sponsorName);
                $('#im_sponsor_qid').val(sponsorQid);
                $('#im_incident_category').val(cd.category||'Inside - All');
                $('#im_refund_type').val(cd.refund_type||'package');
                $('#im_refund_type_label').val(cd.refund_type_label||'Inside - All');

                const hasAgreement=!!(ag?.id||ag?.reference_no||cd.agreement_reference_no);

                if(!hasAgreement){
                    $('#im_no_agreement').removeClass('d-none');
                    $('#im_agreement_card').addClass('d-none');

                    $('#im_agreement_id').val('');
                    $('#im_agreement_reference_no').val('');
                    $('#im_agreement_type').val('');
                    $('#im_agreement_client_id').val('');
                    $('#im_agreement_reference_no_text').val('');
                    $('#im_contract_start_date').val('');
                    $('#im_contract_end_date').val('');
                    $('#im_total_amount').val('0.00');
                    $('#im_received_amount').val('0.00');
                    $('#im_remaining_with_vat').val('0');
                    $('#im_vat_amount').val('0');
                    $('#im_remaining_amount').val('0');
                    $('#im_office_charges').val('0');
                    setBalance();
                    applyDueDateConstraints();
                    showModal('incidentModal');
                    return;
                }

                $('#im_no_agreement').addClass('d-none');
                $('#im_agreement_card').removeClass('d-none');

                $('#im_agreement_id').val(ag.id||'');
                $('#im_agreement_reference_no').val(ag.reference_no||cd.agreement_reference_no||'');
                $('#im_agreement_type').val(ag.agreement_type||'');
                $('#im_agreement_client_id').val(ag.client_id||'');

                $('#im_agreement_reference_no_text').val(ag.reference_no||cd.agreement_reference_no||'');
                $('#im_contract_start_date').val(ag.contract_start_date||'');
                $('#im_contract_end_date').val(ag.contract_end_date||'');

                const total=parseNum(totals.total_amount);
                const received=parseNum(totals.received_amount);
                const vat=parseNum(totals.vat_amount);
                const remaining=parseNum(totals.remaining_amount);
                const remainingWithVat=parseNum(totals.remaining_with_vat);

                $('#im_total_amount').val(money(total));
                $('#im_received_amount').val(money(received));
                $('#im_vat_amount').val(String(vat));
                $('#im_remaining_amount').val(String(remaining));
                $('#im_remaining_with_vat').val(String(remainingWithVat));

                setBalance();
                applyDueDateConstraints();
                showModal('incidentModal');
            })
            .fail(xhr=>{
                const msg=xhr.responseJSON?.message||xhr.statusText||'Failed to load incident data.';
                toastr.error(msg);
            });
    };

    window.confirmStatusChange=(selectEl,packageId,candidateName)=>{
        const $sel=$(selectEl);
        const newStatusVal=Number($sel.val());
        const newStatusLabel=$sel.find(':selected').text();
        const prevStatusVal=Number($sel.data('original'));

        Swal.fire({
            title:`Change status for ${candidateName}?`,
            text:`Set status to "${newStatusLabel}"?`,
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#28a745',
            cancelButtonColor:'#dc3545',
            confirmButtonText:'Yes, change it',
            cancelButtonText:'No, keep it'
        }).then(result=>{
            if(!result.isConfirmed){
                $sel.val(prevStatusVal);
                return;
            }

            closeAllDropdowns();

            if(newStatusVal===1){
                openOfficeModal(packageId);
                return;
            }

            if(newStatusVal===5){
                openIncidentModal(packageId);
                return;
            }

            updateInsideStatus(packageId,newStatusVal)
                .done(r=>{
                    if(r?.success){
                        toastr.success(r.message||'Status updated.');
                        setTimeout(()=>location.reload(),800);
                    }else{
                        toastr.error(r?.message||'Failed to update status.');
                        $sel.val(prevStatusVal);
                    }
                })
                .fail(xhr=>{
                    const msg=xhr.responseJSON?.message||xhr.statusText||'Failed to update status.';
                    toastr.error(msg);
                    $sel.val(prevStatusVal);
                });
        });
    };

    $('#im_decision_refund').on('change',()=>enforceSingleDecision('refund'));
    $('#im_decision_replacement').on('change',()=>enforceSingleDecision('replacement'));
    $('#im_office_charges').on('input',setBalance);
    $('#im_incident_reason').on('change',applyReasonUi);
    $(document).on('change input',DueDateRules.selector,()=>validateDueDate({showToast:true}));
    $('#incidentModal').on('shown.bs.modal',applyDueDateConstraints);

    $('#im_save_btn').on('click',()=>{
        const reason=$('#im_incident_reason').val();
        if(!reason){toastr.error('Please select reason.');return;}
        if(String(reason)==='Other' && !String($('#im_other_reason').val()||'').trim()){toastr.error('Please specify reason.');return;}
        if((String(reason)==='Valid Resident'||String(reason)==='Valid Visa'||String(reason)==='MOHRE COMPLAIN') && !$('#im_incident_expiry_date').val()){toastr.error('Please select expiry date of incident.');return;}
        if(!validateDueDate({showToast:true})) return;
        if(!validateFileExt('#im_proof',['pdf','jpg','jpeg','png'])) return;

        const proof=$('#im_proof').get(0)?.files?.length||0;
        if(!proof){toastr.error('Please upload incident proof.');return;}

        const formData=new FormData(document.getElementById('incidentForm'));
        const isRefund=$('#im_decision_refund').prop('checked');
        formData.set('customer_decision', isRefund ? 'Refund' : 'Replacement');

        const {received,oc}=clampOfficeCharges();
        formData.set('balance_amount', money(Math.max(received-oc,0)));

        $.ajax({
            url:routes.incidentSave,
            type:'POST',
            headers:{'X-CSRF-TOKEN':csrfToken},
            data:formData,
            processData:false,
            contentType:false,
            success:()=>{
                toastr.success('Incident saved successfully!');
                hideModal('incidentModal');
                setTimeout(()=>location.reload(),800);
            },
            error:xhr=>{
                const msg=xhr.responseJSON?.message||xhr.responseJSON?.error||'Failed to save incident. Please check your inputs and try again.';
                toastr.error(msg);
            }
        });
    });

    const PassportExpiryLive={
        warnDays:30,
        dangerDays:7,
        popupDelayMs:5000,
        snoozeMs:60*60*1000,
        storageKey:'passport_expiry_snooze_v1',
        state:{rows:[],timer:null,popupTimer:null,snooze:{}}
    };

    const parseYmdToUtcMidnight=ymd=>{
        if(!ymd) return null;
        const m=/^(\d{4})-(\d{2})-(\d{2})$/.exec(String(ymd).trim());
        if(!m) return null;
        const y=Number(m[1]),mo=Number(m[2])-1,d=Number(m[3]);
        if(!Number.isFinite(y)||!Number.isFinite(mo)||!Number.isFinite(d)) return null;
        return Date.UTC(y,mo,d,0,0,0,0);
    };

    const daysUntil=expiryUtcMs=>{
        const day=24*60*60*1000;
        return Math.ceil((expiryUtcMs-Date.now())/day);
    };

    const loadSnooze=()=>{
        try{
            const raw=localStorage.getItem(PassportExpiryLive.storageKey);
            const obj=raw?JSON.parse(raw):{};
            if(obj&&typeof obj==='object') PassportExpiryLive.state.snooze=obj;
        }catch(e){
            PassportExpiryLive.state.snooze={};
        }
    };

    const saveSnooze=()=>{
        try{
            localStorage.setItem(PassportExpiryLive.storageKey,JSON.stringify(PassportExpiryLive.state.snooze||{}));
        }catch(e){}
    };

    const snoozeKey=row=>{
        const cn=row.dataset.cn||'';
        const pid=row.dataset.packageId||'';
        return `${cn}::${pid}`;
    };

    const isSnoozed=(row,nowMs)=>{
        const until=PassportExpiryLive.state.snooze[snoozeKey(row)];
        return Number.isFinite(until)&&until>nowMs;
    };

    const setSnooze=(row,untilMs)=>{
        PassportExpiryLive.state.snooze[snoozeKey(row)]=untilMs;
        saveSnooze();
    };

    const setPill=(row,kind,text)=>{
        const $row=$(row);
        const $pill=$row.find('.passport-pill');
        const $state=$row.find('.pp-exp-state');
        $pill.removeClass('ok warn dang').addClass(kind);
        $state.text(text);
    };

    const computePassportRow=row=>{
        const expiryYmd=row.dataset.passportExpiry||'';
        const expiryUtcMs=parseYmdToUtcMidnight(expiryYmd);
        const $row=$(row);

        $row.removeClass('row-passport-warning row-passport-danger');

        if(!expiryUtcMs){
            setPill(row,'ok','N/A');
            return {status:'none',days:null,expiryUtcMs:null};
        }

        const d=daysUntil(expiryUtcMs);

        if(d<0){
            $row.addClass('row-passport-danger');
            setPill(row,'dang',`EXPIRED (${Math.abs(d)} day${Math.abs(d)===1?'':'s'})`);
            return {status:'expired',days:d,expiryUtcMs};
        }

        if(d<=PassportExpiryLive.dangerDays){
            $row.addClass('row-passport-danger');
            setPill(row,'dang',d===0?'DUE TODAY':`DUE IN ${d} day${d===1?'':'s'}`);
            return {status:'danger',days:d,expiryUtcMs};
        }

        if(d<=PassportExpiryLive.warnDays){
            $row.addClass('row-passport-warning');
            setPill(row,'warn',`IN ${d} day${d===1?'':'s'}`);
            return {status:'warning',days:d,expiryUtcMs};
        }

        setPill(row,'ok',`IN ${d} day${d===1?'':'s'}`);
        return {status:'ok',days:d,expiryUtcMs};
    };

    const collectRows=()=>{
        PassportExpiryLive.state.rows=Array.from(document.querySelectorAll('#insidePackagesTable tbody tr[data-passport-expiry]'));
    };

    const refreshAll=()=>{
        const urgent=[];
        for(const row of PassportExpiryLive.state.rows){
            const res=computePassportRow(row);
            if(res.status==='danger'||res.status==='expired') urgent.push({row,res});
        }
        return urgent;
    };

    const buildPopupHtml=items=>{
        const rows=items.slice(0,8).map(({row,res})=>{
            const cn=row.dataset.cn||'';
            const cand=row.dataset.candidate||'';
            const nat=row.dataset.nationality||'';
            const pp=row.dataset.passport||'';
            const exp=row.dataset.passportExpiryHuman||row.dataset.passportExpiry||'';
            const type=res.status==='expired'
                ?'<span style="display:inline-block;background:#dc3545;color:#fff;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:700">EXPIRED</span>'
                :'<span style="display:inline-block;background:#dc3545;color:#fff;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:700">DANGER</span>';
            const due=res.status==='expired'
                ?`EXPIRED ${Math.abs(res.days)} day${Math.abs(res.days)===1?'':'s'}`
                :(res.days===0?'DUE TODAY':`DUE IN ${res.days} day${res.days===1?'':'s'}`);
            return `
                <tr>
                    <td style="padding:8px 10px;border-bottom:1px solid #eee;font-weight:700">${cn}</td>
                    <td style="padding:8px 10px;border-bottom:1px solid #eee;font-weight:700">${cand}</td>
                    <td style="padding:8px 10px;border-bottom:1px solid #eee">${nat}</td>
                    <td style="padding:8px 10px;border-bottom:1px solid #eee">${pp}</td>
                    <td style="padding:8px 10px;border-bottom:1px solid #eee">${exp}</td>
                    <td style="padding:8px 10px;border-bottom:1px solid #eee;text-align:center">${type}</td>
                    <td style="padding:8px 10px;border-bottom:1px solid #eee;text-align:center;font-weight:700">${due}</td>
                </tr>
            `;
        }).join('');

        const more=items.length>8?`<div class="small text-muted mt-2">Showing 8 of ${items.length} urgent candidates.</div>`:'';

        return `
            <div style="text-align:left">
                <div style="font-weight:800;font-size:13px;margin-bottom:10px">Passport Expiry Alert</div>
                <div style="max-height:320px;overflow:auto;background:#fff;border:1px solid #eee;border-radius:10px">
                    <table style="width:100%;border-collapse:collapse;font-size:12px">
                        <thead>
                            <tr style="background:#f8f9fa">
                                <th style="padding:8px 10px;border-bottom:1px solid #eee;text-align:left">CN#</th>
                                <th style="padding:8px 10px;border-bottom:1px solid #eee;text-align:left">Candidate</th>
                                <th style="padding:8px 10px;border-bottom:1px solid #eee;text-align:left">Nationality</th>
                                <th style="padding:8px 10px;border-bottom:1px solid #eee;text-align:left">Passport</th>
                                <th style="padding:8px 10px;border-bottom:1px solid #eee;text-align:left">PP Expiry</th>
                                <th style="padding:8px 10px;border-bottom:1px solid #eee;text-align:center">Type</th>
                                <th style="padding:8px 10px;border-bottom:1px solid #eee;text-align:center">Status</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>
                ${more}
                <div class="small text-muted m-2" style="font-size:12px;">Choose “I read it” to snooze this alert for 1 hour.</div>
            </div>
        `;
    };

    const showPopup=items=>{
        Swal.fire({
            html:buildPopupHtml(items),
            icon:'warning',
            showCancelButton:true,
            confirmButtonText:'<i class="fas fa-check-circle"></i> I read it',
            cancelButtonText:'No',
            confirmButtonColor:'#28a745',
            cancelButtonColor:'#dc3545',
            width:900
        }).then(r=>{
            if(r.isConfirmed){
                const nowMs=Date.now();
                for(const it of items) setSnooze(it.row,nowMs+PassportExpiryLive.snoozeMs);
            }
        });
    };

    const schedulePopup=urgent=>{
        const nowMs=Date.now();
        const filtered=urgent.filter(u=>!isSnoozed(u.row,nowMs));
        if(filtered.length===0) return;
        if(PassportExpiryLive.state.popupTimer) clearTimeout(PassportExpiryLive.state.popupTimer);
        PassportExpiryLive.state.popupTimer=setTimeout(()=>{
            const current=refreshAll().filter(u=>!isSnoozed(u.row,Date.now()));
            if(current.length>0) showPopup(current);
        },PassportExpiryLive.popupDelayMs);
    };

    const startPassportLive=()=>{
        loadSnooze();
        collectRows();
        const urgent=refreshAll();
        schedulePopup(urgent);
        if(PassportExpiryLive.state.timer) clearInterval(PassportExpiryLive.state.timer);
        PassportExpiryLive.state.timer=setInterval(()=>{
            const u=refreshAll();
            schedulePopup(u);
        },60*1000);
    };

    $(document).ready(()=>{
        startPassportLive();
        applyDueDateConstraints();
    });
})();
</script>
<?php /**PATH /home/developmentoneso/public_html/resources/views/candidates/partials/package_table_inside.blade.php ENDPATH**/ ?>