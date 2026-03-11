<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $currentStatusIconMap = [
        1  => ['Available',                  'fa-user-check',          'status-available'],
        2  => ['Back Out',                   'fa-door-open',           'status-backout'],
        3  => ['Hold',                       'fa-pause-circle',        'status-hold'],
        4  => ['Selected',                   'fa-star',                'status-selected'],
        5  => ['WC-Date',                    'fa-file-contract',       'status-wc'],
        6  => ['Incident Before Visa (IBV)', 'fa-exclamation-triangle','status-incident'],
        7  => ['Visa Date',                  'fa-passport',            'status-doc'],
        8  => ['Incident After Visa (IAV)',  'fa-exclamation-circle',  'status-incident'],
        9  => ['Medical Status',             'fa-user-nurse',          'status-doc'],
        10 => ['COC-Status',                 'fa-certificate',         'status-doc'],
        11 => ['MoL Submitted Date',         'fa-share-square',        'status-doc'],
        12 => ['MoL Issued Date',            'fa-file-signature',      'status-doc'],
        13 => ['Departure Date',             'fa-plane-departure',     'status-flight'],
        14 => ['Incident After Departure (IAD)','fa-plane',            'status-incident'],
        15 => ['Arrived Date',               'fa-plane-arrival',       'status-flight'],
        16 => ['Incident After Arrival (IAA)','fa-bell',               'status-incident'],
        17 => ['Transfer Date',              'fa-exchange-alt',        'status-transfer'],
    ];

    [$statusLabel, $statusIcon, $statusClass] =
        $currentStatusIconMap[$employee->current_status ?? null] ?? ['Unknown','fa-question-circle','status-unknown'];

    function fmtDate($value) {
        if (!$value) return 'N/A';
        try {
            return \Carbon\Carbon::parse($value)->format('d M Y');
        } catch (\Exception $e) {
            return $value;
        }
    }

    $newCandidate = $newCandidate ?? null;
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<main id="main" class="main">
    <section class="section">
        <div class="container py-4 page-wrapper">
            <div class="card card-soft">
                <div class="card-body card-soft-inner p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center header-top mb-3">
                        <div>
                            <h4 class="mb-1">
                                <span class="candidate-icon-circle">
                                    <i class="fas fa-users"></i>
                                </span>
                                CANDIDATE STAGES
                            </h4>
                            <div class="header-subtitle"><?php echo e($now); ?></div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn-status-main <?php echo e($statusClass); ?> me-2" id="currentStatusButton">
                                <i class="fas <?php echo e($statusIcon); ?> me-1"></i>
                                <?php echo e($statusLabel); ?>

                            </button>
                            <a href="<?php echo e(url()->previous()); ?>" class="btn btn-back">
                                <i class="fas fa-arrow-left me-1"></i>
                                BACK
                            </a>
                        </div>
                    </div>

                    <div class="candidate-strip mb-3">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 mb-2 mb-md-0">
                                <div class="candidate-label">CANDIDATE</div>
                                <div class="candidate-value">
                                    <?php echo e($employee->name ?? 'N/A'); ?>

                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-2 mb-md-0">
                                <div class="candidate-label">NATIONALITY</div>
                                <div class="candidate-value">
                                    <?php echo e($employee->nationality ?? 'N/A'); ?>

                                </div>
                            </div>
                            <div class="col-6 col-md-3 mb-2 mb-md-0">
                                <div class="candidate-label">PASSPORT NO</div>
                                <div class="candidate-value">
                                    <?php echo e($employee->passport_no ?? 'N/A'); ?>

                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="candidate-label">FRA / FOREIGN PARTNER</div>
                                <div class="candidate-value">
                                    <?php echo e($employee->foreign_partner ?? 'N/A'); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if(!$newCandidate): ?>
                        <div class="alert alert-warning small mb-0">
                            No NewCandidate record found for this passport number.
                        </div>
                    <?php else: ?>
                        <div class="stage-accordion"
                             id="stageAccordion"
                             data-wc-done="<?php echo e($newCandidate->wc_date ? 1 : 0); ?>"
                             data-visa-done="<?php echo e($newCandidate->visa_date ? 1 : 0); ?>">
                            <div class="stage-row" data-stage="wc">
                                <div class="stage-header" data-bs-toggle="collapse" data-bs-target="#stageBody-wc">
                                    <div class="stage-index">1</div>
                                    <div class="stage-title">WC</div>
                                    <span class="stage-status badge badge-<?php echo e(!empty($newCandidate->wc_date) ? 'success' : 'secondary'); ?> ms-auto" id="wcStatusBadge">
                                        <?php echo e(!empty($newCandidate->wc_date) ? 'COMPLETED' : 'PENDING'); ?>

                                    </span>
                                    <i class="fas fa-chevron-down stage-chevron"></i>
                                </div>
                                <div id="stageBody-wc" class="collapse show">
                                    <div class="stage-body">
                                        <div class="stage-body-inner">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="stage-desc">WORK CONTRACT STAGE</div>
                                                <span class="badge-chip">
                                                    <i class="fas fa-file-contract me-1"></i>WC
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-center mt-2 mb-2">
                                                <button type="button"
                                                        class="btn-stage-plus"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#wcModal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>

                                            <div class="table-responsive mt-2 <?php echo e($newCandidate->wc_date ? '' : 'd-none'); ?>" id="wcTableWrapper">
                                                <table class="table stage-table" id="wcTable">
                                                    <thead>
                                                    <tr>
                                                        <th>WC DATE</th>
                                                        <th>DW NO</th>
                                                        <th>CONTRACT FILE</th>
                                                        <th>REMARKS</th>
                                                        <th class="text-end">ACTIONS</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="wc-date-cell">
                                                            <?php echo e($newCandidate->wc_date ? fmtDate($newCandidate->wc_date) : 'N/A'); ?>

                                                        </td>
                                                        <td class="wc-dw-cell">
                                                            <?php echo e($newCandidate->wc_dw_number ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="wc-contract-cell">
                                                            <?php if($newCandidate->wc_contract_file): ?>
                                                                <?php echo e(basename($newCandidate->wc_contract_file)); ?>

                                                            <?php else: ?>
                                                                N/A
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="wc-remarks-cell">
                                                            <?php echo e($newCandidate->wc_remarks ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="text-end table-actions">
                                                            <button type="button"
                                                                    class="btn btn-outline-info btn-xs"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewWcModal">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="stage-row" data-stage="incidentBeforeVisa">
                                <div class="stage-header" data-bs-toggle="collapse" data-bs-target="#stageBody-incidentBeforeVisa">
                                    <div class="stage-index">
                                        <i class="fas fa-exclamation" style="font-size:0.6rem;"></i>
                                    </div>
                                    <div class="stage-title">INCIDENT BEFORE VISA</div>
                                    <span class="stage-status badge ms-auto badge-<?php echo e(!empty($newCandidate->ibv_reason) ? 'danger' : 'secondary'); ?>" id="ibvStatusBadge">
                                        <?php echo e(!empty($newCandidate->ibv_reason) ? 'RECORDED' : 'NONE'); ?>

                                    </span>
                                    <i class="fas fa-chevron-down stage-chevron"></i>
                                </div>
                                <div id="stageBody-incidentBeforeVisa" class="collapse">
                                    <div class="stage-body">
                                        <div class="stage-body-inner">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="stage-desc">INCIDENTS BEFORE VISA ISSUE</div>
                                                <span class="badge-chip">
                                                    <i class="fas fa-bell me-1"></i>INCIDENT
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-center mt-2 mb-2">
                                                <button type="button"
                                                        class="btn-stage-plus"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#incidentBeforeVisaModal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>

                                            <div class="table-responsive mt-2 <?php echo e($newCandidate->ibv_date ? '' : 'd-none'); ?>" id="incidentBeforeVisaTableWrapper">
                                                <table class="table stage-table" id="incidentBeforeVisaTable">
                                                    <thead>
                                                    <tr>
                                                        <th>DATE</th>
                                                        <th>REASON</th>
                                                        <th>PROOF</th>
                                                        <th>REMARKS</th>
                                                        <th class="text-end">ACTIONS</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="ibv-date-cell">
                                                            <?php echo e($newCandidate->ibv_date ? fmtDate($newCandidate->ibv_date) : 'N/A'); ?>

                                                        </td>
                                                        <td class="ibv-reason-cell">
                                                            <?php echo e($newCandidate->ibv_reason ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="ibv-proof-cell">
                                                            <?php if($newCandidate->ibv_proof): ?>
                                                                <?php echo e(basename($newCandidate->ibv_proof)); ?>

                                                            <?php else: ?>
                                                                N/A
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="ibv-remarks-cell">
                                                            <?php echo e($newCandidate->ibv_remarks ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="text-end table-actions">
                                                            <button type="button"
                                                                    class="btn btn-outline-info btn-xs"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewIbvModal">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="stage-row" data-stage="visa">
                                <div class="stage-header" data-bs-toggle="collapse" data-bs-target="#stageBody-visa">
                                    <div class="stage-index">2</div>
                                    <div class="stage-title">VISA</div>
                                    <span class="stage-status badge badge-<?php echo e(!empty($newCandidate->visa_date) ? 'success' : 'secondary'); ?> ms-auto" id="visaStatusBadge">
                                        <?php echo e(!empty($newCandidate->visa_date) ? 'COMPLETED' : 'PENDING'); ?>

                                    </span>
                                    <i class="fas fa-chevron-down stage-chevron"></i>
                                </div>
                                <div id="stageBody-visa" class="collapse">
                                    <div class="stage-body">
                                        <div class="stage-body-inner">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="stage-desc">VISA DETAILS</div>
                                                <span class="badge-chip">
                                                    <i class="fas fa-passport me-1"></i>VISA
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-center mt-2 mb-2">
                                                <button type="button"
                                                        class="btn-stage-plus"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#visaModal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>

                                            <div class="table-responsive mt-2 <?php echo e($newCandidate->visa_date ? '' : 'd-none'); ?>" id="visaTableWrapper">
                                                <table class="table stage-table" id="visaTable">
                                                    <thead>
                                                    <tr>
                                                        <th>VISA DATE</th>
                                                        <th>VISA NO</th>
                                                        <th>EXPIRY</th>
                                                        <th>UID NO</th>
                                                        <th>ENTRY PERMIT NO</th>
                                                        <th class="text-end">ACTIONS</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="visa-date-cell">
                                                            <?php echo e($newCandidate->visa_date ? fmtDate($newCandidate->visa_date) : 'N/A'); ?>

                                                        </td>
                                                        <td class="visa-number-cell">
                                                            <?php echo e($newCandidate->visa_number ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="visa-expiry-cell">
                                                            <?php echo e($newCandidate->visa_expiry_date ? fmtDate($newCandidate->visa_expiry_date) : 'N/A'); ?>

                                                        </td>
                                                        <td class="visa-uid-cell">
                                                            <?php echo e($newCandidate->visa_uid_no ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="visa-entry-permit-cell">
                                                            <?php echo e($newCandidate->visa_entry_permit_no ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="text-end table-actions">
                                                            <button type="button"
                                                                    class="btn btn-outline-info btn-xs"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewVisaModal">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="stage-row" data-stage="arrival">
                                <div class="stage-header" data-bs-toggle="collapse" data-bs-target="#stageBody-arrival">
                                    <div class="stage-index">3</div>
                                    <div class="stage-title">ARRIVAL</div>
                                    <span class="stage-status badge badge-<?php echo e(!empty($newCandidate->arrival_date) ? 'success' : 'secondary'); ?> ms-auto" id="arrivalStatusBadge">
                                        <?php echo e(!empty($newCandidate->arrival_date) ? 'COMPLETED' : 'PENDING'); ?>

                                    </span>
                                    <i class="fas fa-chevron-down stage-chevron"></i>
                                </div>
                                <div id="stageBody-arrival" class="collapse">
                                    <div class="stage-body">
                                        <div class="stage-body-inner">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="stage-desc">ARRIVAL DETAILS</div>
                                                <span class="badge-chip">
                                                    <i class="fas fa-plane-arrival me-1"></i>ARRIVAL
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-center mt-2 mb-2">
                                                <button type="button"
                                                        class="btn-stage-plus"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#arrivalModal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>

                                            <div class="table-responsive mt-2 <?php echo e($newCandidate->arrival_date ? '' : 'd-none'); ?>" id="arrivalTableWrapper">
                                                <table class="table stage-table" id="arrivalTable">
                                                    <thead>
                                                    <tr>
                                                        <th>ARRIVAL DATE</th>
                                                        <th>PASSPORT STAMP</th>
                                                        <th>REMARKS</th>
                                                        <th class="text-end">ACTIONS</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="arrival-date-cell">
                                                            <?php echo e($newCandidate->arrival_date ? fmtDate($newCandidate->arrival_date) : 'N/A'); ?>

                                                        </td>
                                                        <td class="arrival-passport-cell">
                                                            <?php if($newCandidate->arrival_passport_stamp_file): ?>
                                                                <?php echo e(basename($newCandidate->arrival_passport_stamp_file)); ?>

                                                            <?php else: ?>
                                                                N/A
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="arrival-remarks-cell">
                                                            <?php echo e($newCandidate->arrival_remarks ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="text-end table-actions">
                                                            <button type="button"
                                                                    class="btn btn-outline-info btn-xs"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewArrivalModal">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="stage-row" data-stage="incidentAfterArrival">
                                <div class="stage-header" data-bs-toggle="collapse" data-bs-target="#stageBody-incidentAfterArrival">
                                    <div class="stage-index">
                                        <i class="fas fa-exclamation" style="font-size:0.6rem;"></i>
                                    </div>
                                    <div class="stage-title">INCIDENT AFTER ARRIVAL</div>
                                    <span class="stage-status badge ms-auto badge-<?php echo e(!empty($newCandidate->iaa_reason) ? 'danger' : 'secondary'); ?>" id="iaaStatusBadge">
                                        <?php echo e(!empty($newCandidate->iaa_reason) ? 'RECORDED' : 'NONE'); ?>

                                    </span>
                                    <i class="fas fa-chevron-down stage-chevron"></i>
                                </div>
                                <div id="stageBody-incidentAfterArrival" class="collapse">
                                    <div class="stage-body">
                                        <div class="stage-body-inner">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="stage-desc">INCIDENTS AFTER ARRIVAL</div>
                                                <span class="badge-chip">
                                                    <i class="fas fa-bullhorn me-1"></i>INCIDENT
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-center mt-2 mb-2">
                                                <button type="button"
                                                        class="btn-stage-plus"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#incidentAfterArrivalModal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>

                                            <div class="table-responsive mt-2 <?php echo e($newCandidate->iaa_reason ? '' : 'd-none'); ?>" id="incidentAfterArrivalTableWrapper">
                                                <table class="table stage-table" id="incidentAfterArrivalTable">
                                                    <thead>
                                                    <tr>
                                                        <th>REASON</th>
                                                        <th>PROOF</th>
                                                        <th>REMARKS</th>
                                                        <th class="text-end">ACTIONS</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="iaa-reason-cell">
                                                            <?php echo e($newCandidate->iaa_reason ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="iaa-proof-cell">
                                                            <?php if($newCandidate->iaa_proof): ?>
                                                                <?php echo e(basename($newCandidate->iaa_proof)); ?>

                                                            <?php else: ?>
                                                                N/A
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="iaa-remarks-cell">
                                                            <?php echo e($newCandidate->iaa_remarks ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="text-end table-actions">
                                                            <button type="button"
                                                                    class="btn btn-outline-info btn-xs"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewIaaModal">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="stage-row" data-stage="transfer">
                                <div class="stage-header" data-bs-toggle="collapse" data-bs-target="#stageBody-transfer">
                                    <div class="stage-index">4</div>
                                    <div class="stage-title">TRANSFER</div>
                                    <span class="stage-status badge badge-<?php echo e(!empty($newCandidate->transfer_date) ? 'success' : 'secondary'); ?> ms-auto" id="transferStatusBadge">
                                        <?php echo e(!empty($newCandidate->transfer_date) ? 'COMPLETED' : 'PENDING'); ?>

                                    </span>
                                    <i class="fas fa-chevron-down stage-chevron"></i>
                                </div>
                                <div id="stageBody-transfer" class="collapse">
                                    <div class="stage-body">
                                        <div class="stage-body-inner">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="stage-desc">TRANSFER DETAILS</div>
                                                <span class="badge-chip">
                                                    <i class="fas fa-exchange-alt me-1"></i>TRANSFER
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-center mt-2 mb-2">
                                                <button type="button"
                                                        class="btn-stage-plus"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#transferModal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>

                                            <div class="table-responsive mt-2 <?php echo e($newCandidate->transfer_date ? '' : 'd-none'); ?>" id="transferTableWrapper">
                                                <table class="table stage-table" id="transferTable">
                                                    <thead>
                                                    <tr>
                                                        <th>TRANSFER DATE</th>
                                                        <th>REMARKS</th>
                                                        <th class="text-end">ACTIONS</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="transfer-date-cell">
                                                            <?php echo e($newCandidate->transfer_date ? fmtDate($newCandidate->transfer_date) : 'N/A'); ?>

                                                        </td>
                                                        <td class="transfer-remarks-cell">
                                                            <?php echo e($newCandidate->transfer_remarks ?? 'N/A'); ?>

                                                        </td>
                                                        <td class="text-end table-actions">
                                                            <button type="button"
                                                                    class="btn btn-outline-info btn-xs"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewTransferModal">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php if($newCandidate): ?>
    <div class="modal fade" id="wcModal" tabindex="-1" aria-labelledby="wcModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="wcForm" class="needs-validation" novalidate
                      method="POST"
                      action="<?php echo e(route('boa.wc.save', $employee->reference_no)); ?>"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="candidate_id" value="<?php echo e($newCandidate->id); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="wcModalLabel">
                            <i class="fas fa-file-contract"></i>WC STAGE
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger d-none form-alert"></div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small-label">WC DATE <span class="required-asterisk">*</span></label>
                                <input type="date" class="form-control" id="wcDate" name="wc_date" value="<?php echo e($newCandidate->wc_date); ?>" required>
                                <div class="invalid-feedback">WC DATE IS REQUIRED.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">DW NUMBER <span class="required-asterisk">*</span></label>
                                <input type="text" class="form-control" id="dwNumber" name="wc_dw_number" value="<?php echo e($newCandidate->wc_dw_number); ?>" placeholder="Enter DW number" required>
                                <div class="invalid-feedback">DW NUMBER IS REQUIRED.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">WC CONTRACT FILE</label>
                                <input type="file" class="form-control" id="wcContractFile" name="wc_contract_file" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted d-block mt-1" style="font-size:0.65rem;">PDF / IMAGE OPTIONAL</small>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="small-label">REMARKS</label>
                                <textarea class="form-control" id="wcRemarks" name="wc_remarks" rows="2" placeholder="Add any notes"><?php echo e($newCandidate->wc_remarks); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-save me-1"></i>SAVE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="incidentBeforeVisaModal" tabindex="-1" aria-labelledby="incidentBeforeVisaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="incidentBeforeVisaForm" class="needs-validation" novalidate
                      method="POST"
                      action="<?php echo e(route('boa.ibv.save', $employee->reference_no)); ?>"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="candidate_id" value="<?php echo e($newCandidate->id); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="incidentBeforeVisaModalLabel">
                            <i class="fas fa-exclamation-triangle"></i>INCIDENT BEFORE VISA
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger d-none form-alert"></div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small-label">INCIDENT DATE <span class="required-asterisk">*</span></label>
                                <input type="date" class="form-control" id="incidentBeforeVisaDate" name="ibv_date" value="<?php echo e($newCandidate->ibv_date); ?>" required>
                                <div class="invalid-feedback">INCIDENT DATE IS REQUIRED.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">REASON <span class="required-asterisk">*</span></label>
                                <select class="form-control" id="incidentBeforeVisaReason" name="ibv_reason" required>
                                    <option value="">Select reason</option>
                                    <option value="Behaviour" <?php echo e($newCandidate->ibv_reason === 'Behaviour' ? 'selected' : ''); ?>>Behaviour</option>
                                    <option value="Medical" <?php echo e($newCandidate->ibv_reason === 'Medical' ? 'selected' : ''); ?>>Medical</option>
                                    <option value="Documentation" <?php echo e($newCandidate->ibv_reason === 'Documentation' ? 'selected' : ''); ?>>Documentation</option>
                                    <option value="Other" <?php echo e($newCandidate->ibv_reason === 'Other' ? 'selected' : ''); ?>>Other</option>
                                </select>
                                <div class="invalid-feedback">REASON IS REQUIRED.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">PROOF</label>
                                <input type="file" class="form-control" id="incidentBeforeVisaProof" name="ibv_proof" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted d-block mt-1" style="font-size:0.65rem;">OPTIONAL PROOF FILE</small>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="small-label">REMARKS</label>
                                <textarea class="form-control" id="incidentBeforeVisaRemarks" name="ibv_remarks" rows="2" placeholder="Add remarks"><?php echo e($newCandidate->ibv_remarks); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-sm btn-warning text-white">
                            <i class="fas fa-save me-1"></i>SAVE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="visaModal" tabindex="-1" aria-labelledby="visaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="visaForm" class="needs-validation" novalidate
                      method="POST"
                      action="<?php echo e(route('boa.visa.save', $employee->reference_no)); ?>"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="candidate_id" value="<?php echo e($newCandidate->id); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visaModalLabel">
                            <i class="fas fa-passport"></i>VISA STAGE
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger d-none form-alert"></div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small-label">VISA DATE <span class="required-asterisk">*</span></label>
                                <input type="date" class="form-control" id="visaDate" name="visa_date" value="<?php echo e($newCandidate->visa_date); ?>" required>
                                <div class="invalid-feedback">VISA DATE IS REQUIRED.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">VISA NUMBER (OPTIONAL)</label>
                                <input type="text" class="form-control" id="visaNumber" name="visa_number" value="<?php echo e($newCandidate->visa_number); ?>" placeholder="Enter visa number">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">VISA EXPIRY DATE <span class="required-asterisk">*</span></label>
                                <input type="date" class="form-control" id="visaExpiry" name="visa_expiry_date" value="<?php echo e($newCandidate->visa_expiry_date); ?>" required>
                                <div class="invalid-feedback">VISA EXPIRY DATE IS REQUIRED.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">UID NO <span class="required-asterisk">*</span></label>
                                <input type="text" class="form-control" id="uidNo" name="visa_uid_no" value="<?php echo e($newCandidate->visa_uid_no); ?>" placeholder="Enter UID number" required>
                                <div class="invalid-feedback">UID NO IS REQUIRED.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">ENTRY PERMIT NUMBER <span class="required-asterisk">*</span></label>
                                <input type="text" class="form-control" id="entryPermitNo" name="visa_entry_permit_no" value="<?php echo e($newCandidate->visa_entry_permit_no); ?>" placeholder="Enter entry permit number" required>
                                <div class="invalid-feedback">ENTRY PERMIT NUMBER IS REQUIRED.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">VISA COPY <span class="required-asterisk">*</span></label>
                                <input type="file" class="form-control" id="visaCopy" name="visa_copy_file" accept=".pdf,.jpg,.jpeg,.png" <?php echo e($newCandidate->visa_copy_file ? '' : 'required'); ?>>
                                <small class="text-muted d-block mt-1" style="font-size:0.65rem;">PDF / IMAGE REQUIRED</small>
                            </div>
                            <div class="col-12 mb-2">
                                <label class="small-label">REMARKS (OPTIONAL)</label>
                                <textarea class="form-control" id="visaRemarks" name="visa_remarks" rows="2" placeholder="Add remarks"><?php echo e($newCandidate->visa_remarks); ?></textarea>
                            </div>
                            <div class="col-12">
                                <small class="text-muted" style="font-size:0.65rem;">
                                    Only Visa Number and Remarks are optional. All other fields are required.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-save me-1"></i>SAVE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="arrivalModal" tabindex="-1" aria-labelledby="arrivalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="arrivalForm" class="needs-validation" novalidate
                      method="POST"
                      action="<?php echo e(route('boa.arrival.save', $employee->reference_no)); ?>"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="candidate_id" value="<?php echo e($newCandidate->id); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="arrivalModalLabel">
                            <i class="fas fa-plane-arrival"></i>ARRIVAL STAGE
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger d-none form-alert"></div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small-label">ARRIVAL DATE <span class="required-asterisk">*</span></label>
                                <input type="date" class="form-control" id="arrivalDate" name="arrival_date" value="<?php echo e($newCandidate->arrival_date); ?>" required>
                                <div class="invalid-feedback">ARRIVAL DATE IS REQUIRED.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">PASSPORT WITH IMMIGRATION STAMP <span class="required-asterisk">*</span></label>
                                <input type="file" class="form-control" id="arrivalPassportStamp" name="arrival_passport_stamp_file" accept=".pdf,.jpg,.jpeg,.png" <?php echo e($newCandidate->arrival_passport_stamp_file ? '' : 'required'); ?>>
                                <small class="text-muted d-block mt-1" style="font-size:0.65rem;">
                                    Passport scan with immigration stamp required.
                                </small>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="small-label">REMARKS</label>
                                <textarea class="form-control" id="arrivalRemarks" name="arrival_remarks" rows="2" placeholder="Add remarks"><?php echo e($newCandidate->arrival_remarks); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-save me-1"></i>SAVE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="incidentAfterArrivalModal" tabindex="-1" aria-labelledby="incidentAfterArrivalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="incidentAfterArrivalForm" class="needs-validation" novalidate
                      method="POST"
                      action="<?php echo e(route('boa.iaa.save', $employee->reference_no)); ?>"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="candidate_id" value="<?php echo e($newCandidate->id); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="incidentAfterArrivalModalLabel">
                            <i class="fas fa-exclamation-circle"></i>INCIDENT AFTER ARRIVAL
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger d-none form-alert"></div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small-label">REASON <span class="required-asterisk">*</span></label>
                                <select class="form-control" id="incidentAfterArrivalReason" name="iaa_reason" required>
                                    <option value="">Select reason</option>
                                    <option value="Absconding" <?php echo e($newCandidate->iaa_reason === 'Absconding' ? 'selected' : ''); ?>>Absconding</option>
                                    <option value="Misconduct" <?php echo e($newCandidate->iaa_reason === 'Misconduct' ? 'selected' : ''); ?>>Misconduct</option>
                                    <option value="Medical" <?php echo e($newCandidate->iaa_reason === 'Medical' ? 'selected' : ''); ?>>Medical</option>
                                    <option value="Other" <?php echo e($newCandidate->iaa_reason === 'Other' ? 'selected' : ''); ?>>Other</option>
                                </select>
                                <div class="invalid-feedback">REASON IS REQUIRED.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small-label">PROOF <span class="required-asterisk">*</span></label>
                                <input type="file" class="form-control" id="incidentAfterArrivalProof" name="iaa_proof" accept=".pdf,.jpg,.jpeg,.png" <?php echo e($newCandidate->iaa_proof ? '' : 'required'); ?>>
                                <small class="text-muted d-block mt-1" style="font-size:0.65rem;">
                                    Attach supporting document.
                                </small>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="small-label">REMARKS</label>
                                <textarea class="form-control" id="incidentAfterArrivalRemarks" name="iaa_remarks" rows="2" placeholder="Add remarks"><?php echo e($newCandidate->iaa_remarks); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-save me-1"></i>SAVE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="transferForm" class="needs-validation" novalidate
                      method="POST"
                      action="<?php echo e(route('boa.transfer.save', $employee->reference_no)); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="candidate_id" value="<?php echo e($newCandidate->id); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transferModalLabel">
                            <i class="fas fa-exchange-alt"></i>TRANSFER STAGE
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger d-none form-alert"></div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small-label">TRANSFER DATE <span class="required-asterisk">*</span></label>
                                <input type="date" class="form-control" id="transferDate" name="transfer_date" value="<?php echo e($newCandidate->transfer_date); ?>" required>
                                <div class="invalid-feedback">TRANSFER DATE IS REQUIRED.</div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="small-label">REMARKS</label>
                                <textarea class="form-control" id="transferRemarks" name="transfer_remarks" rows="2" placeholder="Add remarks"><?php echo e($newCandidate->transfer_remarks); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-save me-1"></i>SAVE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewWcModal" tabindex="-1" aria-labelledby="viewWcModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewWcModalLabel">
                        <i class="fas fa-eye"></i>WC DETAILS
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 view-dt">WC DATE</dt>
                        <dd class="col-sm-8 view-dd" id="viewWcDate"><?php echo e(fmtDate($newCandidate->wc_date ?? null)); ?></dd>

                        <dt class="col-sm-4 view-dt">DW NUMBER</dt>
                        <dd class="col-sm-8 view-dd" id="viewWcDwNumber"><?php echo e($newCandidate->wc_dw_number ?? 'N/A'); ?></dd>

                        <dt class="col-sm-4 view-dt">CONTRACT FILE</dt>
                        <dd class="col-sm-8 view-dd" id="viewWcContractFile">
                            <?php if(!empty($newCandidate->wc_contract_file)): ?>
                                <a href="<?php echo e(asset('storage/'.$newCandidate->wc_contract_file)); ?>" target="_blank" id="viewWcContractFileLink">
                                    View Contract
                                </a>
                            <?php else: ?>
                                <span id="viewWcContractFileText">N/A</span>
                            <?php endif; ?>
                        </dd>

                        <dt class="col-sm-4 view-dt">REMARKS</dt>
                        <dd class="col-sm-8 view-dd" id="viewWcRemarks"><?php echo e($newCandidate->wc_remarks ?? 'N/A'); ?></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewIbvModal" tabindex="-1" aria-labelledby="viewIbvModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewIbvModalLabel">
                        <i class="fas fa-eye"></i>INCIDENT BEFORE VISA DETAILS
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 view-dt">INCIDENT DATE</dt>
                        <dd class="col-sm-8 view-dd" id="viewIbvDate"><?php echo e(fmtDate($newCandidate->ibv_date ?? null)); ?></dd>

                        <dt class="col-sm-4 view-dt">REASON</dt>
                        <dd class="col-sm-8 view-dd" id="viewIbvReason"><?php echo e($newCandidate->ibv_reason ?? 'N/A'); ?></dd>

                        <dt class="col-sm-4 view-dt">PROOF</dt>
                        <dd class="col-sm-8 view-dd" id="viewIbvProof">
                            <?php if(!empty($newCandidate->ibv_proof)): ?>
                                <a href="<?php echo e(asset('storage/'.$newCandidate->ibv_proof)); ?>" target="_blank" id="viewIbvProofLink">
                                    View Proof
                                </a>
                            <?php else: ?>
                                <span id="viewIbvProofText">N/A</span>
                            <?php endif; ?>
                        </dd>

                        <dt class="col-sm-4 view-dt">REMARKS</dt>
                        <dd class="col-sm-8 view-dd" id="viewIbvRemarks"><?php echo e($newCandidate->ibv_remarks ?? 'N/A'); ?></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewVisaModal" tabindex="-1" aria-labelledby="viewVisaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewVisaModalLabel">
                        <i class="fas fa-eye"></i>VISA DETAILS
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 view-dt">VISA DATE</dt>
                        <dd class="col-sm-8 view-dd" id="viewVisaDate"><?php echo e(fmtDate($newCandidate->visa_date ?? null)); ?></dd>

                        <dt class="col-sm-4 view-dt">VISA NUMBER</dt>
                        <dd class="col-sm-8 view-dd" id="viewVisaNumber"><?php echo e($newCandidate->visa_number ?? 'N/A'); ?></dd>

                        <dt class="col-sm-4 view-dt">VISA EXPIRY</dt>
                        <dd class="col-sm-8 view-dd" id="viewVisaExpiry"><?php echo e(fmtDate($newCandidate->visa_expiry_date ?? null)); ?></dd>

                        <dt class="col-sm-4 view-dt">UID NO</dt>
                        <dd class="col-sm-8 view-dd" id="viewVisaUid"><?php echo e($newCandidate->visa_uid_no ?? 'N/A'); ?></dd>

                        <dt class="col-sm-4 view-dt">ENTRY PERMIT NO</dt>
                        <dd class="col-sm-8 view-dd" id="viewVisaEntryPermit"><?php echo e($newCandidate->visa_entry_permit_no ?? 'N/A'); ?></dd>

                        <dt class="col-sm-4 view-dt">VISA COPY</dt>
                        <dd class="col-sm-8 view-dd" id="viewVisaCopy">
                            <?php if(!empty($newCandidate->visa_copy_file)): ?>
                                <a href="<?php echo e(asset('storage/'.$newCandidate->visa_copy_file)); ?>" target="_blank" id="viewVisaCopyLink">
                                    View Visa
                                </a>
                            <?php else: ?>
                                <span id="viewVisaCopyText">N/A</span>
                            <?php endif; ?>
                        </dd>

                        <dt class="col-sm-4 view-dt">REMARKS</dt>
                        <dd class="col-sm-8 view-dd" id="viewVisaRemarks"><?php echo e($newCandidate->visa_remarks ?? 'N/A'); ?></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewArrivalModal" tabindex="-1" aria-labelledby="viewArrivalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewArrivalModalLabel">
                        <i class="fas fa-eye"></i>ARRIVAL DETAILS
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 view-dt">ARRIVAL DATE</dt>
                        <dd class="col-sm-8 view-dd" id="viewArrivalDate"><?php echo e(fmtDate($newCandidate->arrival_date ?? null)); ?></dd>

                        <dt class="col-sm-4 view-dt">PASSPORT STAMP</dt>
                        <dd class="col-sm-8 view-dd" id="viewArrivalPassport">
                            <?php if(!empty($newCandidate->arrival_passport_stamp_file)): ?>
                                <a href="<?php echo e(asset('storage/'.$newCandidate->arrival_passport_stamp_file)); ?>" target="_blank" id="viewArrivalPassportLink">
                                    View Passport
                                </a>
                            <?php else: ?>
                                <span id="viewArrivalPassportText">N/A</span>
                            <?php endif; ?>
                        </dd>

                        <dt class="col-sm-4 view-dt">REMARKS</dt>
                        <dd class="col-sm-8 view-dd" id="viewArrivalRemarks"><?php echo e($newCandidate->arrival_remarks ?? 'N/A'); ?></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewIaaModal" tabindex="-1" aria-labelledby="viewIaaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewIaaModalLabel">
                        <i class="fas fa-eye"></i>INCIDENT AFTER ARRIVAL DETAILS
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 view-dt">REASON</dt>
                        <dd class="col-sm-8 view-dd" id="viewIaaReason"><?php echo e($newCandidate->iaa_reason ?? 'N/A'); ?></dd>

                        <dt class="col-sm-4 view-dt">PROOF</dt>
                        <dd class="col-sm-8 view-dd" id="viewIaaProof">
                            <?php if(!empty($newCandidate->iaa_proof)): ?>
                                <a href="<?php echo e(asset('storage/'.$newCandidate->iaa_proof)); ?>" target="_blank" id="viewIaaProofLink">
                                    View Proof
                                </a>
                            <?php else: ?>
                                <span id="viewIaaProofText">N/A</span>
                            <?php endif; ?>
                        </dd>

                        <dt class="col-sm-4 view-dt">REMARKS</dt>
                        <dd class="col-sm-8 view-dd" id="viewIaaRemarks"><?php echo e($newCandidate->iaa_remarks ?? 'N/A'); ?></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewTransferModal" tabindex="-1" aria-labelledby="viewTransferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTransferModalLabel">
                        <i class="fas fa-eye"></i>TRANSFER DETAILS
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 view-dt">TRANSFER DATE</dt>
                        <dd class="col-sm-8 view-dd" id="viewTransferDate"><?php echo e(fmtDate($newCandidate->transfer_date ?? null)); ?></dd>

                        <dt class="col-sm-4 view-dt">REMARKS</dt>
                        <dd class="col-sm-8 view-dd" id="viewTransferRemarks"><?php echo e($newCandidate->transfer_remarks ?? 'N/A'); ?></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
    <div id="stageLockToast" class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Please complete the previous stages first.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<style>
    :root {
        --main-gradient: linear-gradient(to right, #007bff, #00c6ff);
        --text-muted-soft: #6b7280;
        --border-soft: #e5e7eb;
    }
    body { background:#ffffff;font-size:.85rem;color:#111827;}
    .page-wrapper{min-height:100vh;}
    .card-soft{border-radius:1rem;border:none;background:#ffffff;box-shadow:0 18px 42px rgba(15,23,42,.14);}
    .card-soft-inner{border-radius:1rem;background:#ffffff;}
    .header-top h4{font-size:1rem;letter-spacing:.12em;text-transform:uppercase;}
    .header-subtitle{font-size:.72rem;letter-spacing:.16em;text-transform:uppercase;color:var(--text-muted-soft);}
    .btn-back{border-radius:999px;font-size:.7rem;text-transform:uppercase;letter-spacing:.14em;padding:.35rem 1.05rem;border:none;background:var(--main-gradient);color:#fff;box-shadow:0 10px 24px rgba(0,123,255,.5);}
    .btn-back i{font-size:.7rem;}
    .candidate-strip{border-radius:.8rem;padding:.8rem 1rem;background:#fff;border:1px solid var(--border-soft);box-shadow:0 10px 26px rgba(15,23,42,.06);}
    .candidate-label{font-size:.63rem;opacity:.75;letter-spacing:.16em;text-transform:uppercase;color:var(--text-muted-soft);}
    .candidate-value{font-size:.8rem;font-weight:600;}
    .candidate-icon-circle{width:30px;height:30px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center;background:var(--main-gradient);color:#fff;font-size:.9rem;margin-right:.5rem;}
    .stage-accordion{margin-top:1.25rem;}
    .stage-row{border-radius:.8rem;overflow:hidden;margin-bottom:.7rem;background:#fff;border:1px solid var(--border-soft);box-shadow:0 10px 26px rgba(15,23,42,.08);}
    .stage-header{padding:.55rem .9rem;display:flex;align-items:center;cursor:pointer;color:#fff;font-size:.7rem;letter-spacing:.2em;text-transform:uppercase;user-select:none;background:var(--main-gradient);}
    .stage-row.stage-locked .stage-header{opacity:.5;cursor:not-allowed;}
    .stage-row.stage-locked .btn-stage-plus{opacity:.4;}
    .stage-index{width:22px;height:22px;border-radius:999px;border:1px solid rgba(255,255,255,.9);display:inline-flex;align-items:center;justify-content:center;font-size:.6rem;margin-right:.5rem;background:rgba(255,255,255,.1);}
    .stage-title{font-weight:700;white-space:nowrap;}
    .stage-status{margin-left:auto;font-size:.55rem;padding:.15rem .4rem;border-radius:999px;}
    .stage-chevron{margin-left:.45rem;font-size:.6rem;}
    .stage-body{padding:.6rem .9rem .8rem;background:#f9fafb;}
    .stage-body-inner{border-radius:.65rem;padding:.7rem .8rem .8rem;background:#fff;border:1px solid #e0f2ff;}
    .stage-desc{font-size:.65rem;color:var(--text-muted-soft);text-transform:uppercase;letter-spacing:.16em;}
    .badge-chip{border-radius:999px;padding:.12rem .45rem;border:1px solid #d1d5db;font-size:.63rem;text-transform:uppercase;letter-spacing:.16em;color:var(--text-muted-soft);background:#f9fafb;}
    .view-dt{font-size:.68rem;text-transform:uppercase;letter-spacing:.14em;color:var(--text-muted-soft);}
    .view-dd{font-size:.76rem;color:#111827;}
    .btn-status-main{border-radius:999px;font-size:.7rem;text-transform:uppercase;letter-spacing:.14em;padding:.35rem .9rem;border:none;display:inline-flex;align-items:center;}
    .status-available{background:#e9f7ef;color:#198754;}
    .status-backout{background:#f8d7da;color:#842029;}
    .status-hold{background:#fff3cd;color:#856404;}
    .status-selected{background:#e7f1ff;color:#0d6efd;}
    .status-wc{background:#e0f2fe;color:#055160;}
    .status-incident{background:#fde2e1;color:#b02a37;}
    .status-doc{background:#f3e8ff;color:#5a189a;}
    .status-flight{background:#e0ecff;color:#084298;}
    .status-transfer{background:#e0f7ff;color:#0b7285;}
    .status-unknown{background:#e5e7eb;color:#374151;}
    .btn-stage-plus{width:46px;height:46px;border-radius:999px;padding:0;border:none;background:var(--main-gradient);color:#fff;font-size:.9rem;box-shadow:0 10px 26px rgba(0,123,255,.5);}
    .btn-stage-plus i{transition:transform .2s ease;}
    .btn-stage-plus:hover i{transform:rotate(90deg);}
    .stage-table{margin-bottom:0;}
    .stage-table th,.stage-table td{padding:.25rem .35rem;border-top:none;border-bottom:1px solid #e5e7eb;font-size:.7rem;white-space:nowrap;}
    .stage-table thead th{text-transform:uppercase;letter-spacing:.18em;font-weight:500;color:var(--text-muted-soft);background:#f3f4f6;}
    .required-asterisk{color:#ef4444;}
    .small-label{font-size:.65rem;text-transform:uppercase;letter-spacing:.16em;color:var(--text-muted-soft);}
    .modal-content{border-radius:1.25rem;border:1px solid var(--border-soft);overflow:hidden;}
    .modal-header{border-bottom:1px solid #e5e7eb;background:var(--main-gradient);color:#fff;}
    .modal-footer{border-top:1px solid #e5e7eb;background:#f9fafb;}
    .modal-title{font-size:.85rem;letter-spacing:.16em;text-transform:uppercase;display:flex;align-items:center;}
    .modal-title i{font-size:.9rem;margin-right:.5rem;}
    .form-control{background-color:#fff;border-color:#d1d5db;color:#111827;font-size:.78rem;}
    .form-control::placeholder{color:#9ca3af;}
    .form-control:focus{background-color:#fff;border-color:#007bff;box-shadow:0 0 0 .14rem rgba(0,123,255,.25);}
    .invalid-feedback{font-size:.65rem;}
    .table-actions .btn{padding:.08rem .32rem;font-size:.63rem;}
    .btn-xs{padding:.08rem .32rem;font-size:.63rem;}
    .form-alert{font-size:.75rem;}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var accordion = document.getElementById('stageAccordion');
    var stageState = {
        wcDone: accordion ? accordion.dataset.wcDone === '1' : false,
        visaDone: accordion ? accordion.dataset.visaDone === '1' : false
    };

    var statusMap = {
        '5': {label:'WC-Date', icon:'fa-file-contract', cls:'status-wc'},
        '6': {label:'Incident Before Visa (IBV)', icon:'fa-exclamation-triangle', cls:'status-incident'},
        '7': {label:'Visa Date', icon:'fa-passport', cls:'status-doc'},
        '15': {label:'Arrived Date', icon:'fa-plane-arrival', cls:'status-flight'},
        '16': {label:'Incident After Arrival (IAA)', icon:'fa-bell', cls:'status-incident'},
        '17': {label:'Transfer Date', icon:'fa-exchange-alt', cls:'status-transfer'}
    };

    function setCurrentStatus(statusId) {
        var btn = document.getElementById('currentStatusButton');
        if (!btn) return;
        var cfg = statusMap[String(statusId)];
        if (!cfg) return;
        btn.classList.remove('status-available','status-backout','status-hold','status-selected','status-wc','status-incident','status-doc','status-flight','status-transfer','status-unknown');
        btn.classList.add(cfg.cls);
        var icon = btn.querySelector('i');
        if (icon) {
            icon.className = 'fas ' + cfg.icon + ' me-1';
        }
        var textNodes = Array.prototype.filter.call(btn.childNodes, function (n) { return n.nodeType === Node.TEXT_NODE; });
        if (textNodes.length) {
            textNodes[0].textContent = ' ' + cfg.label;
        } else {
            btn.appendChild(document.createTextNode(' ' + cfg.label));
        }
    }

    function canUseStage(stage) {
        if (stage === 'wc') return true;
        if (stage === 'incidentBeforeVisa') return stageState.wcDone;
        if (stage === 'visa') return stageState.wcDone;
        if (stage === 'arrival') return stageState.visaDone;
        if (stage === 'incidentAfterArrival') return stageState.visaDone;
        if (stage === 'transfer') return stageState.visaDone;
        return true;
    }

    function applyStageLocks() {
        var rows = document.querySelectorAll('.stage-row');
        rows.forEach(function (row) {
            var stage = row.getAttribute('data-stage');
            var locked = !canUseStage(stage);
            row.classList.toggle('stage-locked', locked);
            var header = row.querySelector('.stage-header');
            var plus = row.querySelector('.btn-stage-plus');
            if (header) {
                if (!header.dataset.bsToggleOriginal) {
                    header.dataset.bsToggleOriginal = header.getAttribute('data-bs-toggle') || '';
                    header.dataset.bsTargetOriginal = header.getAttribute('data-bs-target') || '';
                }
                if (locked) {
                    header.removeAttribute('data-bs-toggle');
                    header.removeAttribute('data-bs-target');
                } else {
                    if (header.dataset.bsToggleOriginal) header.setAttribute('data-bs-toggle', header.dataset.bsToggleOriginal);
                    if (header.dataset.bsTargetOriginal) header.setAttribute('data-bs-target', header.dataset.bsTargetOriginal);
                }
            }
            if (plus) {
                if (!plus.dataset.bsToggleOriginal) {
                    plus.dataset.bsToggleOriginal = plus.getAttribute('data-bs-toggle') || '';
                    plus.dataset.bsTargetOriginal = plus.getAttribute('data-bs-target') || '';
                }
                if (locked) {
                    plus.removeAttribute('data-bs-toggle');
                    plus.removeAttribute('data-bs-target');
                } else {
                    if (plus.dataset.bsToggleOriginal) plus.setAttribute('data-bs-toggle', plus.dataset.bsToggleOriginal);
                    if (plus.dataset.bsTargetOriginal) plus.setAttribute('data-bs-target', plus.dataset.bsTargetOriginal);
                }
            }
        });
    }

    function formatDisplayDate(value) {
        if (!value) return 'N/A';
        var parts = value.split('-');
        if (parts.length !== 3) return value;
        var year = parts[0];
        var month = parseInt(parts[1], 10);
        var day = parts[2];
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var m = months[month - 1] || parts[1];
        return day + ' ' + m + ' ' + year;
    }

    var toastInstance;
    function showLockToast() {
        var el = document.getElementById('stageLockToast');
        if (!el) return;
        if (!toastInstance) {
            toastInstance = new bootstrap.Toast(el);
        }
        toastInstance.show();
    }

    document.querySelectorAll('.stage-header').forEach(function (header) {
        header.addEventListener('click', function (e) {
            var row = header.closest('.stage-row');
            if (row && row.classList.contains('stage-locked')) {
                e.preventDefault();
                showLockToast();
            }
        });
    });

    document.querySelectorAll('.btn-stage-plus').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var row = btn.closest('.stage-row');
            if (row && row.classList.contains('stage-locked')) {
                e.preventDefault();
                showLockToast();
            }
        });
    });

    document.querySelectorAll('.stage-row .collapse').forEach(function (el) {
        el.addEventListener('show.bs.collapse', function () {
            document.querySelectorAll('.stage-row .collapse').forEach(function (other) {
                if (other !== el) {
                    var inst = bootstrap.Collapse.getOrCreateInstance(other);
                    inst.hide();
                }
            });
        });
    });

    function clearValidation(form, alertBox) {
        var controls = form.querySelectorAll('.form-control, .form-select');
        controls.forEach(function (c) {
            c.classList.remove('is-invalid');
        });
        var feedbacks = form.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(function (fb) {
            fb.style.display = '';
        });
        if (alertBox) {
            alertBox.classList.add('d-none');
            alertBox.textContent = '';
        }
    }

    function showGeneralError(alertBox, message) {
        if (!alertBox) return;
        alertBox.textContent = message || 'Something went wrong.';
        alertBox.classList.remove('d-none');
    }

    function showValidationErrors(form, alertBox, errors) {
        var firstMessage = null;
        Object.keys(errors).forEach(function (field) {
            var messages = errors[field];
            if (!messages || !messages.length) return;
            if (!firstMessage) firstMessage = messages[0];
            var input = form.querySelector('[name="' + field + '"]');
            if (input) {
                input.classList.add('is-invalid');
                var feedback = input.parentElement.querySelector('.invalid-feedback') || input.closest('.mb-3')?.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = messages[0];
                    feedback.style.display = 'block';
                }
            }
        });
        if (firstMessage) {
            showGeneralError(alertBox, firstMessage);
        }
    }

    function attachAjaxForm(formId, onSuccess) {
        var form = document.getElementById(formId);
        if (!form) return;
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var submitBtn = form.querySelector('button[type="submit"]');
            var alertBox = form.querySelector('.form-alert');
            clearValidation(form, alertBox);
            var fd = new FormData(form);
            var originalHtml = null;
            if (submitBtn) {
                submitBtn.disabled = true;
                originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Saving...';
            }
            fetch(form.action, {
                method: form.method || 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: fd
            }).then(function (res) {
                return res.json().catch(function () { return {}; }).then(function (data) {
                    if (res.status === 422 && data.errors) {
                        showValidationErrors(form, alertBox, data.errors);
                        throw new Error('Validation failed');
                    }
                    if (!res.ok || data.success === false) {
                        var msg = data.message || 'Something went wrong.';
                        showGeneralError(alertBox, msg);
                        throw new Error(msg);
                    }
                    if (typeof onSuccess === 'function') {
                        onSuccess(data, form);
                    }
                    var modalEl = form.closest('.modal');
                    if (modalEl) {
                        var inst = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        inst.hide();
                    }
                });
            }).catch(function (err) {
                console.error(err);
            }).finally(function () {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml || submitBtn.innerHTML;
                }
            });
        });
    }

    attachAjaxForm('wcForm', function (data, form) {
        var dateVal = form.querySelector('#wcDate').value;
        var dwVal = form.querySelector('#dwNumber').value;
        var remarksVal = form.querySelector('#wcRemarks').value || 'N/A';
        var fileInput = form.querySelector('#wcContractFile');
        var fileName = null;
        if (fileInput && fileInput.files && fileInput.files[0]) {
            fileName = fileInput.files[0].name;
        } else {
            var existingCell = document.querySelector('.wc-contract-cell');
            fileName = existingCell ? existingCell.textContent.trim() : 'N/A';
        }

        var wrapper = document.getElementById('wcTableWrapper');
        if (wrapper) wrapper.classList.remove('d-none');
        var row = document.querySelector('#wcTable tbody tr');
        if (row) {
            var dateCell = row.querySelector('.wc-date-cell');
            var dwCell = row.querySelector('.wc-dw-cell');
            var contractCell = row.querySelector('.wc-contract-cell');
            var remarksCell = row.querySelector('.wc-remarks-cell');
            if (dateCell) dateCell.textContent = formatDisplayDate(dateVal);
            if (dwCell) dwCell.textContent = dwVal || 'N/A';
            if (contractCell) contractCell.textContent = fileName || 'N/A';
            if (remarksCell) remarksCell.textContent = remarksVal;
        }

        var viewDate = document.getElementById('viewWcDate');
        var viewDw = document.getElementById('viewWcDwNumber');
        var viewRemarks = document.getElementById('viewWcRemarks');
        if (viewDate) viewDate.textContent = formatDisplayDate(dateVal);
        if (viewDw) viewDw.textContent = dwVal || 'N/A';
        if (viewRemarks) viewRemarks.textContent = remarksVal;

        var badge = document.getElementById('wcStatusBadge');
        if (badge) {
            badge.classList.remove('badge-secondary');
            badge.classList.add('badge-success');
            badge.textContent = 'COMPLETED';
        }

        stageState.wcDone = true;
        applyStageLocks();
        setCurrentStatus(5);
    });

    attachAjaxForm('incidentBeforeVisaForm', function (data, form) {
        var dateVal = form.querySelector('#incidentBeforeVisaDate').value;
        var reasonVal = form.querySelector('#incidentBeforeVisaReason').value || 'N/A';
        var remarksVal = form.querySelector('#incidentBeforeVisaRemarks').value || 'N/A';
        var fileInput = form.querySelector('#incidentBeforeVisaProof');
        var fileName = null;
        if (fileInput && fileInput.files && fileInput.files[0]) {
            fileName = fileInput.files[0].name;
        } else {
            var existingCell = document.querySelector('.ibv-proof-cell');
            fileName = existingCell ? existingCell.textContent.trim() : 'N/A';
        }

        var wrapper = document.getElementById('incidentBeforeVisaTableWrapper');
        if (wrapper) wrapper.classList.remove('d-none');
        var row = document.querySelector('#incidentBeforeVisaTable tbody tr');
        if (row) {
            var dateCell = row.querySelector('.ibv-date-cell');
            var reasonCell = row.querySelector('.ibv-reason-cell');
            var proofCell = row.querySelector('.ibv-proof-cell');
            var remarksCell = row.querySelector('.ibv-remarks-cell');
            if (dateCell) dateCell.textContent = formatDisplayDate(dateVal);
            if (reasonCell) reasonCell.textContent = reasonVal || 'N/A';
            if (proofCell) proofCell.textContent = fileName || 'N/A';
            if (remarksCell) remarksCell.textContent = remarksVal;
        }

        var viewDate = document.getElementById('viewIbvDate');
        var viewReason = document.getElementById('viewIbvReason');
        var viewRemarks = document.getElementById('viewIbvRemarks');
        if (viewDate) viewDate.textContent = formatDisplayDate(dateVal);
        if (viewReason) viewReason.textContent = reasonVal || 'N/A';
        if (viewRemarks) viewRemarks.textContent = remarksVal;

        var badge = document.getElementById('ibvStatusBadge');
        if (badge) {
            badge.classList.remove('badge-secondary');
            badge.classList.add('badge-danger');
            badge.textContent = 'RECORDED';
        }

        setCurrentStatus(6);
    });

    attachAjaxForm('visaForm', function (data, form) {
        var visaDate = form.querySelector('#visaDate').value;
        var visaNumber = form.querySelector('#visaNumber').value || 'N/A';
        var visaExpiry = form.querySelector('#visaExpiry').value;
        var uidNo = form.querySelector('#uidNo').value || 'N/A';
        var entryPermit = form.querySelector('#entryPermitNo').value || 'N/A';
        var remarksVal = form.querySelector('#visaRemarks').value || 'N/A';
        var fileInput = form.querySelector('#visaCopy');
        var fileName = null;
        if (fileInput && fileInput.files && fileInput.files[0]) {
            fileName = fileInput.files[0].name;
        } else {
            var existing = document.getElementById('viewVisaCopyText');
            if (existing) fileName = existing.textContent.trim();
        }

        var wrapper = document.getElementById('visaTableWrapper');
        if (wrapper) wrapper.classList.remove('d-none');
        var row = document.querySelector('#visaTable tbody tr');
        if (row) {
            var dateCell = row.querySelector('.visa-date-cell');
            var numberCell = row.querySelector('.visa-number-cell');
            var expiryCell = row.querySelector('.visa-expiry-cell');
            var uidCell = row.querySelector('.visa-uid-cell');
            var entryCell = row.querySelector('.visa-entry-permit-cell');
            if (dateCell) dateCell.textContent = formatDisplayDate(visaDate);
            if (numberCell) numberCell.textContent = visaNumber || 'N/A';
            if (expiryCell) expiryCell.textContent = formatDisplayDate(visaExpiry);
            if (uidCell) uidCell.textContent = uidNo || 'N/A';
            if (entryCell) entryCell.textContent = entryPermit || 'N/A';
        }

        var viewDate = document.getElementById('viewVisaDate');
        var viewNumber = document.getElementById('viewVisaNumber');
        var viewExpiry = document.getElementById('viewVisaExpiry');
        var viewUid = document.getElementById('viewVisaUid');
        var viewEntry = document.getElementById('viewVisaEntryPermit');
        var viewRemarks = document.getElementById('viewVisaRemarks');
        if (viewDate) viewDate.textContent = formatDisplayDate(visaDate);
        if (viewNumber) viewNumber.textContent = visaNumber || 'N/A';
        if (viewExpiry) viewExpiry.textContent = formatDisplayDate(visaExpiry);
        if (viewUid) viewUid.textContent = uidNo || 'N/A';
        if (viewEntry) viewEntry.textContent = entryPermit || 'N/A';
        if (viewRemarks) viewRemarks.textContent = remarksVal;

        var badge = document.getElementById('visaStatusBadge');
        if (badge) {
            badge.classList.remove('badge-secondary');
            badge.classList.add('badge-success');
            badge.textContent = 'COMPLETED';
        }

        stageState.visaDone = true;
        applyStageLocks();
        setCurrentStatus(7);
    });

    attachAjaxForm('arrivalForm', function (data, form) {
        var arrDate = form.querySelector('#arrivalDate').value;
        var remarksVal = form.querySelector('#arrivalRemarks').value || 'N/A';
        var fileInput = form.querySelector('#arrivalPassportStamp');
        var fileName = null;
        if (fileInput && fileInput.files && fileInput.files[0]) {
            fileName = fileInput.files[0].name;
        } else {
            var existingCell = document.querySelector('.arrival-passport-cell');
            fileName = existingCell ? existingCell.textContent.trim() : 'N/A';
        }

        var wrapper = document.getElementById('arrivalTableWrapper');
        if (wrapper) wrapper.classList.remove('d-none');
        var row = document.querySelector('#arrivalTable tbody tr');
        if (row) {
            var dateCell = row.querySelector('.arrival-date-cell');
            var passportCell = row.querySelector('.arrival-passport-cell');
            var remarksCell = row.querySelector('.arrival-remarks-cell');
            if (dateCell) dateCell.textContent = formatDisplayDate(arrDate);
            if (passportCell) passportCell.textContent = fileName || 'N/A';
            if (remarksCell) remarksCell.textContent = remarksVal;
        }

        var viewDate = document.getElementById('viewArrivalDate');
        var viewRemarks = document.getElementById('viewArrivalRemarks');
        if (viewDate) viewDate.textContent = formatDisplayDate(arrDate);
        if (viewRemarks) viewRemarks.textContent = remarksVal;

        var badge = document.getElementById('arrivalStatusBadge');
        if (badge) {
            badge.classList.remove('badge-secondary');
            badge.classList.add('badge-success');
            badge.textContent = 'COMPLETED';
        }

        setCurrentStatus(15);
    });

    attachAjaxForm('incidentAfterArrivalForm', function (data, form) {
        var reasonVal = form.querySelector('#incidentAfterArrivalReason').value || 'N/A';
        var remarksVal = form.querySelector('#incidentAfterArrivalRemarks').value || 'N/A';
        var fileInput = form.querySelector('#incidentAfterArrivalProof');
        var fileName = null;
        if (fileInput && fileInput.files && fileInput.files[0]) {
            fileName = fileInput.files[0].name;
        } else {
            var existingCell = document.querySelector('.iaa-proof-cell');
            fileName = existingCell ? existingCell.textContent.trim() : 'N/A';
        }

        var wrapper = document.getElementById('incidentAfterArrivalTableWrapper');
        if (wrapper) wrapper.classList.remove('d-none');
        var row = document.querySelector('#incidentAfterArrivalTable tbody tr');
        if (row) {
            var reasonCell = row.querySelector('.iaa-reason-cell');
            var proofCell = row.querySelector('.iaa-proof-cell');
            var remarksCell = row.querySelector('.iaa-remarks-cell');
            if (reasonCell) reasonCell.textContent = reasonVal || 'N/A';
            if (proofCell) proofCell.textContent = fileName || 'N/A';
            if (remarksCell) remarksCell.textContent = remarksVal;
        }

        var viewReason = document.getElementById('viewIaaReason');
        var viewRemarks = document.getElementById('viewIaaRemarks');
        if (viewReason) viewReason.textContent = reasonVal || 'N/A';
        if (viewRemarks) viewRemarks.textContent = remarksVal;

        var badge = document.getElementById('iaaStatusBadge');
        if (badge) {
            badge.classList.remove('badge-secondary');
            badge.classList.add('badge-danger');
            badge.textContent = 'RECORDED';
        }

        setCurrentStatus(16);
    });

    attachAjaxForm('transferForm', function (data, form) {
        var transferDate = form.querySelector('#transferDate').value;
        var remarksVal = form.querySelector('#transferRemarks').value || 'N/A';

        var wrapper = document.getElementById('transferTableWrapper');
        if (wrapper) wrapper.classList.remove('d-none');
        var row = document.querySelector('#transferTable tbody tr');
        if (row) {
            var dateCell = row.querySelector('.transfer-date-cell');
            var remarksCell = row.querySelector('.transfer-remarks-cell');
            if (dateCell) dateCell.textContent = formatDisplayDate(transferDate);
            if (remarksCell) remarksCell.textContent = remarksVal;
        }

        var viewDate = document.getElementById('viewTransferDate');
        var viewRemarks = document.getElementById('viewTransferRemarks');
        if (viewDate) viewDate.textContent = formatDisplayDate(transferDate);
        if (viewRemarks) viewRemarks.textContent = remarksVal;

        var badge = document.getElementById('transferStatusBadge');
        if (badge) {
            badge.classList.remove('badge-secondary');
            badge.classList.add('badge-success');
            badge.textContent = 'COMPLETED';
        }

        setCurrentStatus(17);
    });

    applyStageLocks();
});
</script>

<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/boa_process.blade.php ENDPATH**/ ?>