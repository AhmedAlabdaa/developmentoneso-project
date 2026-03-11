<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .custom-card {
        gap: 16px;
        background-color: #f9f9f9;
        border-radius: 12px;
        padding: 16px 24px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-left: 4px solid #007bff;
    }

    .card-image {
        width: 48px;
        height: 48px;
        overflow: hidden;
        border-radius: 50%;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-text {
        flex: 1;
    }

    .card-name {
        font-size: 1rem;
        font-weight: normal;
        color: #007bff;
    }

    .card-button {
        background: none;
        border: none;
        font-size: 0.875rem;
        font-weight: normal;
        color: #007bff;
        display: flex;
        align-items: center;
        gap: 4px;
        cursor: default;
        line-height: 3;
    }

    .card-icon {
        color: #007bff;
        font-size: 1rem;
    }

    .modal-navigation-tabs {
        display: flex;
        margin: 16px 0;
        border-bottom: 1px solid #ddd;
    }

    .modal-navigation-item {
        padding: 8px 16px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-navigation-item.active {
        color: #007bff;
        font-weight: normal;
        border-bottom: 2px solid #007bff;
    }

    .modal-content-section {
        margin-top: 16px;
        position: relative;
    }

    .modal-tab-content {
        display: none;
    }

    .modal-tab-content.active {
        display: block;
    }

    .modal-preloader {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100;
        display: none;
    }

    .modal-preloader.active {
        display: flex;
    }

    .modal-tab-content {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #333;
    }

    .profile-details {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        width: calc(50% - 10px);
        border-bottom: 1px solid #eee;
        padding: 5px 0;
    }

    .detail-label {
        font-weight: normal;
        color: #000;
    }

    .detail-value {
        color: #777;
    }

    .document-list {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .document-item {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .document-name {
        font-weight: normal;
        font-size: 12px;
        color: #000;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .document-viewer {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        text-align: center;
    }

    .document-frame {
        width: 100%;
        height: 500px;
    }

    .document-image {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    .document-placeholder {
        width: 100%;
        height: auto;
        object-fit: contain;
        display: block;
        margin: 0 auto;
    }

    .agreements-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .agreements-table th, .agreements-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .agreements-table th {
        background-color: #f4f4f4;
        font-weight: normal;
    }

    .agreements-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .agreements-table tr:hover {
        background-color: #f1f1f1;
    }

    .agreements-table a {
        text-decoration: none;
        color: #007bff;
    }

    .agreements-table a:hover {
        text-decoration: underline;
    }

    .fas.fa-file-pdf {
        color: #e3342f;
        margin-right: 5px;
    }
    .accordion-button {
        font-weight: normal;
        font-size: 12px;
    }

    .accordion-body ul {
        list-style-type: disc;
        margin-left: 20px;
    }

    .accordion-body li {
        margin-bottom: 5px;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1050; 
    }

    .loading-content {
        text-align: center;
    }

    .spinner-border {
        width: 3rem;
        height: 3rem;
    }

    .loading-text {
        margin-top: 1rem;
        font-size: 1rem;
        color: #6c757d;  
    }

    .modal-navigation-item:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="cansidebar-content card custom-card">
                    <div class="card custom-card">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="card-image">
                                    <?php
                                        $foreignPartner = strtolower(explode(' ', $candidate->foreign_partner)[0]);
                                        $baseUrl = 'https://' . $foreignPartner . '.onesourceerp.com/storage/app/public/';
                                        $photoAttachment = $candidate->attachments->where('attachment_type', 'Passport Size Photo')->first();
                                        $fileUrl = null;
                                        if ($photoAttachment) {
                                            $localPath = 'public/' . $photoAttachment->attachment_file;
                                            $remoteFileUrl = $baseUrl . $photoAttachment->attachment_file;
                                            $localFileExists = \Storage::exists($localPath);

                                            $fileUrl = $localFileExists 
                                                        ? url('storage/app/public/' . $photoAttachment->attachment_file) 
                                                        : (get_headers($remoteFileUrl) && strpos(get_headers($remoteFileUrl)[0], '200') !== false ? $remoteFileUrl : null);
                                        }
                                    ?>

                                    <div class="card-image">
                                        <?php if($fileUrl): ?>
                                            <img src="<?php echo e($fileUrl); ?>" alt="Profile Image">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/64">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card-text">
                                    <div class="card-name"><?php echo e($candidate->candidate_name); ?></div>
                                    <div class="card-info"><?php echo e($candidate->passport_no); ?></div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="card-button-wrapper">
                                    <button class="card-button" style="text-transform: uppercase;">
                                        <span class="card-icon">&#x2714;</span> <?php echo e($candidate->currentStatus->status_name); ?>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-navigation-tabs">
                        <button class="modal-navigation-item active" data-tab="modal-information">
                            <span>&#x1F4C4;</span> Information
                        </button>
                        <button class="modal-navigation-item" data-tab="modal-documents" onclick="loadDocuments(<?php echo e($candidate->id); ?>)">
                            <span>&#x1F4C3;</span> Documents
                        </button>
                        <button class="modal-navigation-item" data-tab="modal-experiences" onclick="loadExperiences(<?php echo e($candidate->id); ?>)">
                            <span>&#x1F4BC;</span> Experiences
                        </button>
                        <button class="modal-navigation-item" data-tab="modal-work-skills" onclick="loadWorkSkills(<?php echo e($candidate->id); ?>)">
                            <span>&#x2699;</span> Work Skills
                        </button>
                        <button class="modal-navigation-item" data-tab="modal-desired-countries" onclick="loadDesiredCountries(<?php echo e($candidate->id); ?>)">
                            <span>&#x1F30F;</span> Desired Countries
                        </button>
                        <button class="modal-navigation-item" data-tab="modal-work-contract" onclick="loadWorkContract(<?php echo e($candidate->id); ?>)">
                            <span>&#x1F4DC;</span> Work Contract
                        </button>
                        <button class="modal-navigation-item" data-tab="modal-agreements" onclick="loadAgreements(<?php echo e($candidate->id); ?>)">
                            <span>&#x1F4D1;</span> Agreements
                        </button>
                        <button class="modal-navigation-item" data-tab="modal-contracts" onclick="loadContracts(<?php echo e($candidate->id); ?>)">
                            <span>&#x1F4DD;</span> Contracts
                        </button>
                        <button class="modal-navigation-item" data-tab="modal-incidents" onclick="loadIncidents(<?php echo e($candidate->id); ?>)">
                            <span>&#x1F6A8;</span> Incidents
                        </button>
                        <button class="modal-navigation-item" data-tab="modal-trials" disabled>
                            <span>&#x2696;</span> Trials
                        </button>
                        <button class="modal-navigation-item" data-tab="modal-visa-tracking" disabled>
                            <span>&#x1F4CB;</span> Visa Tracking
                        </button>
                    </div>
                    <div class="modal-content-section">
                        <div class="modal-preloader" id="modal-preloader">
                            <span>Loading...</span>
                        </div>
                        <div class="modal-tab-content active" id="modal-information">
                            <div class="profile-details">
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> ID:</span>
                                    <span class="detail-value"><?php echo e($candidate->id ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> CN Number:</span>
                                    <span class="detail-value"><?php echo e($candidate->CN_Number ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Reference No:</span>
                                    <span class="detail-value"><?php echo e($candidate->reference_no ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Ref No:</span>
                                    <span class="detail-value"><?php echo e($candidate->ref_no ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Candidate Name:</span>
                                    <span class="detail-value"><?php echo e($candidate->candidate_name ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Passport No:</span>
                                    <span class="detail-value"><?php echo e($candidate->passport_no ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Passport Issue Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->passport_issue_date ? \Carbon\Carbon::parse($candidate->passport_issue_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Passport Issue Place:</span>
                                    <span class="detail-value"><?php echo e($candidate->passport_issue_place ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Nationality:</span>
                                    <span class="detail-value"><?php echo e($candidate->Nationality->name ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Passport Expiry Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->passport_expiry_date ? \Carbon\Carbon::parse($candidate->passport_expiry_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Date of Birth:</span>
                                    <span class="detail-value"><?php echo e($candidate->date_of_birth ? \Carbon\Carbon::parse($candidate->date_of_birth)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Foreign Partner:</span>
                                    <span class="detail-value"><?php echo e($candidate->foreign_partner ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Age:</span>
                                    <span class="detail-value"><?php echo e($candidate->age ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Gender:</span>
                                    <span class="detail-value"><?php echo e($candidate->gender ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Salary:</span>
                                    <span class="detail-value"><?php echo e($candidate->salary ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Sponsorship:</span>
                                    <span class="detail-value"><?php echo e($candidate->sponsorship ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Work Skill General Description:</span>
                                    <span class="detail-value"><?php echo e($candidate->work_skill_general_description ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Contract Duration:</span>
                                    <span class="detail-value"><?php echo e($candidate->contract_duration ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Religion:</span>
                                    <span class="detail-value"><?php echo e($candidate->religion ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> English Skills:</span>
                                    <span class="detail-value"><?php echo e($candidate->english_skills ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Arabic Skills:</span>
                                    <span class="detail-value"><?php echo e($candidate->arabic_skills ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Applied Position:</span>
                                    <span class="detail-value"><?php echo e($candidate->appliedPosition->position_name ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Work Skill:</span>
                                    <span class="detail-value"><?php echo e($candidate->work_skill ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Skill Description:</span>
                                    <span class="detail-value"><?php echo e($candidate->skill_description ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Education Level:</span>
                                    <span class="detail-value"><?php echo e($candidate->educationLevel->level_name ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Marital Status:</span>
                                    <span class="detail-value"><?php echo e($candidate->marital_status ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Number of Children:</span>
                                    <span class="detail-value"><?php echo e($candidate->number_of_children ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Height:</span>
                                    <span class="detail-value"><?php echo e($candidate->height ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Weight:</span>
                                    <span class="detail-value"><?php echo e($candidate->weight ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Preferred Package:</span>
                                    <span class="detail-value"><?php echo e($candidate->preferred_package ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Desired Country:</span>
                                    <span class="detail-value">Qatar</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> COC Status:</span>
                                    <span class="detail-value"><button type="button" class="btn btn-primary"><?php echo e($candidate->coc_status ?? 'N/A'); ?></button></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Place of Birth:</span>
                                    <span class="detail-value"><?php echo e($candidate->place_of_birth ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Candidate Current Address:</span>
                                    <span class="detail-value"><?php echo e($candidate->candidate_current_address ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Labour ID Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->labour_id_date ? \Carbon\Carbon::parse($candidate->labour_id_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Labour ID Number:</span>
                                    <span class="detail-value"><?php echo e($candidate->labour_id_number ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Family Name:</span>
                                    <span class="detail-value"><?php echo e($candidate->family_name ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Family Contact Number 1:</span>
                                    <span class="detail-value"><?php echo e($candidate->family_contact_number_1 ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Family Contact Number 2:</span>
                                    <span class="detail-value"><?php echo e($candidate->family_contact_number_2 ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Relationship with Candidate:</span>
                                    <span class="detail-value"><?php echo e($candidate->relationship_with_candidate ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Family Current Address:</span>
                                    <span class="detail-value"><?php echo e($candidate->family_current_address ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Current Status:</span>
                                    <span class="detail-value"><?php echo e($candidate->current_status ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Visa Status:</span>
                                    <span class="detail-value"><?php echo e($candidate->visa_status ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Hold Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->hold_date ? \Carbon\Carbon::parse($candidate->hold_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Selected Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->selected_date ? \Carbon\Carbon::parse($candidate->selected_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> WC Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->wc_date ? \Carbon\Carbon::parse($candidate->wc_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> WC Added Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->wc_added_date ? \Carbon\Carbon::parse($candidate->wc_added_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Visa Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->visa_date ? \Carbon\Carbon::parse($candidate->visa_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Visa Added Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->visa_added_date ? \Carbon\Carbon::parse($candidate->visa_added_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> UID Number:</span>
                                    <span class="detail-value"><?php echo e($candidate->uid_number ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Entry Permit Number:</span>
                                    <span class="detail-value"><?php echo e($candidate->entry_permit_number ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Visa Number:</span>
                                    <span class="detail-value"><?php echo e($candidate->visa_number ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Phone Number:</span>
                                    <span class="detail-value"><?php echo e($candidate->phone_number ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Arrived Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->arrived_date ? \Carbon\Carbon::parse($candidate->arrived_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Arrived Added Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->arrived_added_date ? \Carbon\Carbon::parse($candidate->arrived_added_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Transfer Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->transfer_date ? \Carbon\Carbon::parse($candidate->transfer_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Transfer Added Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->transfer_added_date ? \Carbon\Carbon::parse($candidate->transfer_added_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Office Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->office_date ? \Carbon\Carbon::parse($candidate->office_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Trial Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->trial_date ? \Carbon\Carbon::parse($candidate->trial_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Confirmed Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->confirmed_date ? \Carbon\Carbon::parse($candidate->confirmed_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Change Status Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->change_status_date ? \Carbon\Carbon::parse($candidate->change_status_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Sales Name:</span>
                                    <span class="detail-value"><?php echo e($candidate->sales_name ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Visa Type:</span>
                                    <span class="detail-value"><?php echo e($candidate->visa_type ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Rejected Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->rejected_date ? \Carbon\Carbon::parse($candidate->rejected_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Remarks:</span>
                                    <span class="detail-value"><?php echo e($candidate->remarks ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Created At:</span>
                                    <span class="detail-value"><?php echo e($candidate->created_at ? \Carbon\Carbon::parse($candidate->created_at)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Updated At:</span>
                                    <span class="detail-value"><?php echo e($candidate->updated_at ? \Carbon\Carbon::parse($candidate->updated_at)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Updated By:</span>
                                    <span class="detail-value"><?php echo e($candidate->updated_by ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Inside Status:</span>
                                    <span class="detail-value"><?php echo e($candidate->inside_status ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Arrived in Office Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->arrived_in_office_date ? \Carbon\Carbon::parse($candidate->arrived_in_office_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Medical Status:</span>
                                    <span class="detail-value"><a href="#"><a href="#" class="btn btn-primary"><?php echo e($candidate->medical_status ? $candidate->medical_status : 'N/A'); ?></a></a></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Medical Date:</span>
                                    <span class="detail-value"><a href="#"><a href="#" class="btn btn-primary"><?php echo e($candidate->medical_date ? \Carbon\Carbon::parse($candidate->medical_date)->format('d F Y') : 'N/A'); ?></a></a></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hospital"></i> Hospital Name:</span>
                                    <span class="detail-value"><?php echo e($candidate->hospital_name ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> COC Status Date:</span>
                                    <span class="detail-value"><a href="#"><a href="#" class="btn btn-primary"><?php echo e($candidate->coc_status_date ? \Carbon\Carbon::parse($candidate->coc_status_date)->format('d F Y') : 'N/A'); ?></a></a></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> L Submitted Date:</span>
                                    <span class="detail-value"><a href="#" class="btn btn-primary"><?php echo e($candidate->l_submitted_date ? \Carbon\Carbon::parse($candidate->l_submitted_date)->format('d F Y') : 'N/A'); ?></a></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> L Issued Date:</span>
                                    <span class="detail-value"><a href="#" class="btn btn-primary"><?php echo e($candidate->l_issued_date ? \Carbon\Carbon::parse($candidate->l_issued_date)->format('d F Y') : 'N/A'); ?></a></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Departure Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->departure_date ? \Carbon\Carbon::parse($candidate->departure_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Incident After Departure Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->incident_after_departure_date ? \Carbon\Carbon::parse($candidate->incident_after_departure_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Incident After Arrival Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->incident_after_arrival_date ? \Carbon\Carbon::parse($candidate->incident_after_arrival_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Appeal:</span>
                                    <span class="detail-value"><?php echo e($candidate->appeal ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Appeal Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->appeal_date ? \Carbon\Carbon::parse($candidate->appeal_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Medical Remarks:</span>
                                    <span class="detail-value"><?php echo e($candidate->medical_remarks ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> COC Remarks:</span>
                                    <span class="detail-value"><?php echo e($candidate->coc_remarks ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> L Submitted Date Remarks:</span>
                                    <span class="detail-value"><?php echo e($candidate->l_submitted_date_remarks ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> L Issued Date Remarks:</span>
                                    <span class="detail-value"><?php echo e($candidate->l_issued_date_remarks ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Departure Date Remarks:</span>
                                    <span class="detail-value"><?php echo e($candidate->departure_date_remarks ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> L Submission Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->l_submission_date ? \Carbon\Carbon::parse($candidate->l_submission_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Pulled Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->pulled_date ? \Carbon\Carbon::parse($candidate->pulled_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Insurance Approved Date:</span>
                                    <span class="detail-value"><?php echo e($candidate->insurance_approved_date ? \Carbon\Carbon::parse($candidate->insurance_approved_date)->format('d F Y') : 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> Status:</span>
                                    <span class="detail-value"><?php echo e($candidate->status ?? 'N/A'); ?></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label"><i class="fas fa-hashtag"></i> VP Number:</span>
                                    <span class="detail-value"><?php echo e($candidate->vp_number ?? 'N/A'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-tab-content" id="modal-documents"></div>
                        <div class="modal-tab-content" id="modal-experiences"></div>
                        <div class="modal-tab-content" id="modal-work-skills"></div>
                        <div class="modal-tab-content" id="modal-desired-countries"></div>
                        <div class="modal-tab-content" id="modal-work-contract"></div>
                        <div class="modal-tab-content" id="modal-agreements"></div>
                        <div class="modal-tab-content" id="modal-contracts"></div>
                        <div class="modal-tab-content" id="modal-incidents"> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
    document.querySelectorAll('.modal-navigation-item').forEach(tab => {
        tab.addEventListener('click', () => {
            const preloader = document.getElementById('modal-preloader');
            preloader.classList.add('active');
            setTimeout(() => {
                document.querySelectorAll('.modal-navigation-item').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.modal-tab-content').forEach(content => content.classList.remove('active'));
                tab.classList.add('active');
                const target = tab.getAttribute('data-tab');
                document.getElementById(target).classList.add('active');
                preloader.classList.remove('active');
            }, 500); 
        });
    });

    function loadDocuments(candidate_id) {
        const loadingSpinner = `
            <div class="loading-overlay">
                <div class="loading-content">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="loading-text text-muted mt-3">Please wait while documents are loading...</p>
                </div>
            </div>
        `;
        $('body').append(loadingSpinner);
        $.ajax({
            url: '<?php echo e(route("candidates.loadimages1")); ?>',
            type: 'GET',
            data: { id: candidate_id },
            success: function(response) {
                if (response.success) {
                    $('#modal-documents').html(response.html);
                } else {
                    $('#modal-documents').html('<p class="text-center text-muted">No documents found for this candidate.</p>');
                }
                $('.loading-overlay').remove();
            },
            error: function(xhr, status, error) {
                console.error('Error loading documents:', error);
                $('#modal-documents').html('<p class="text-center text-danger">Unable to load documents. Please try again later.</p>');
                $('.loading-overlay').remove(); 
            }
        });
    }

    function loadExperiences(candidate_id) {
        const loadingSpinner = `
            <div class="loading-overlay">
                <div class="loading-content">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="loading-text text-muted mt-3">Please wait while experiences are loading...</p>
                </div>
            </div>
        `;
        $('body').append(loadingSpinner);
        $.ajax({
            url: '<?php echo e(route("candidates.loadExperiences")); ?>',
            type: 'GET',
            data: { id: candidate_id },
            success: function(response) {
                if (response.success) {
                    $('#modal-experiences').html(response.html);
                } else {
                    $('#modal-experiences').html('<p class="text-center text-muted">No experiences found for this candidate.</p>');
                }
                $('.loading-overlay').remove();
            },
            error: function(xhr, status, error) {
                console.error('Error loading experiences:', error);
                $('#modal-experiences').html('<p class="text-center text-danger">Unable to load experiences. Please try again later.</p>');
                $('.loading-overlay').remove(); 
            }
        });
    }

    function loadWorkSkills(candidateId) {
        const loadingSpinner = `
            <div class="loading-overlay">
                <div class="loading-content">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="loading-text text-muted mt-3">Please wait while work skills are loading...</p>
                </div>
            </div>
        `;
        $('body').append(loadingSpinner);

        $.ajax({
            url: '/candidates/loadWorkSkills',  
            type: 'GET',
            data: { id: candidateId },
            success: function (response) {
                if (response.success) {
                    $('#modal-work-skills').html(response.html);
                } else {
                    $('#modal-work-skills').html('<p class="text-center text-muted">No work skills found for this candidate.</p>');
                }
                $('.loading-overlay').remove();
            },
            error: function (xhr, status, error) {
                console.error('Error loading work skills:', error);
                $('#modal-work-skills').html('<p class="text-center text-danger">Unable to load work skills. Please try again later.</p>');
                $('.loading-overlay').remove();
            }
        });
    }

    function loadDesiredCountries(candidateId) {
        const loadingSpinner = `
            <div class="loading-overlay">
                <div class="loading-content">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="loading-text text-muted mt-3">Please wait while desired countries are loading...</p>
                </div>
            </div>
        `;
        $('body').append(loadingSpinner);

        $.ajax({
            url: '/candidates/loadDesiredCountries',  
            type: 'GET',
            data: { id: candidateId },
            success: function (response) {
                if (response.success) {
                    $('#modal-desired-countries').html(response.html);
                } else {
                    $('#modal-desired-countries').html('<p class="text-center text-muted">No desired countries found for this candidate.</p>');
                }
                $('.loading-overlay').remove();
            },
            error: function (xhr, status, error) {
                console.error('Error loading desired countries:', error);
                $('#modal-desired-countries').html('<p class="text-center text-danger">Unable to load desired countries. Please try again later.</p>');
                $('.loading-overlay').remove();
            }
        });
    }

    function loadWorkContract(candidateId) {
        const csrfToken = '<?php echo e(csrf_token()); ?>'; 
        const loadingSpinner = `
            <div class="loading-overlay">
                <div class="loading-content">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="loading-text text-muted mt-3">Please wait while the work contract is loading...</p>
                </div>
            </div>
        `;
        $('body').append(loadingSpinner);
        $.ajax({
            url: '/candidates/' + candidateId + '/wc_contract',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                $('#modal-work-contract').html(response);
                $('.loading-overlay').remove();
            },
            error: function (xhr, status, error) {
                console.error('Error:', xhr.responseText);
                $('#modal-work-contract').html('<p class="text-center text-danger">Unable to load work contract. Please try again later.</p>');
                $('.loading-overlay').remove();
            }
        });
    }

</script><?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/show.blade.php ENDPATH**/ ?>