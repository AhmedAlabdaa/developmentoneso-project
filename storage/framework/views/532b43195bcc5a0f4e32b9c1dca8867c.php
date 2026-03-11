
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
        font-weight: bold;
        color: #007bff;
    }

    .card-button {
        background: none;
        border: none;
        font-size: 0.875rem;
        font-weight: bold;
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
        font-weight: bold;
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
        font-size: 14px;
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
        font-weight: bold;
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
        font-weight: bold;
        font-size: 14px;
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
        font-weight: bold;
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
        font-weight: bold;
        font-size: 14px;
    }

    .accordion-body ul {
        list-style-type: disc;
        margin-left: 20px;
    }

    .accordion-body li {
        margin-bottom: 5px;
    }
</style>
<div class="cansidebar-content">
    <div class="card custom-card">
        <div class="row">
            <div class="col-lg-2">
                <div class="card-image">
                    <img src="https://via.placeholder.com/64" alt="Profile Image">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card-text">
                    <div class="card-name">GETE ABERA WELDEAMANUEL</div>
                    <div class="card-info">EFI0010841</div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="card-button-wrapper">
                    <button class="card-button">
                        <span class="card-icon">&#x2714;</span> Submitted
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-navigation-tabs">
        <button class="modal-navigation-item active" data-tab="modal-information">
            <span>&#x1F4C4;</span> Information
        </button>
        <button class="modal-navigation-item" data-tab="modal-documents">
            <span>&#x1F4C3;</span> Documents
        </button>
        <button class="modal-navigation-item" data-tab="modal-agreements">
            <span>&#x1F4D1;</span> Agreements
        </button>
        <button class="modal-navigation-item" data-tab="modal-contracts">
            <span>&#x1F4DD;</span> Contracts
        </button>
        <button class="modal-navigation-item" data-tab="modal-trials">
            <span>&#x2696;</span> Trials
        </button>
        <button class="modal-navigation-item" data-tab="modal-incidents">
            <span>&#x1F6A8;</span> Incidents
        </button>
        <button class="modal-navigation-item" data-tab="modal-visa-tracking">
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
                    <span class="detail-label"><i class="fas fa-hashtag"></i> Reference No:</span>
                    <span class="detail-value">123456</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-barcode"></i> CN Number:</span>
                    <span class="detail-value">987654</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-user"></i> Candidate Name:</span>
                    <span class="detail-value">John Doe</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-passport"></i> Passport No:</span>
                    <span class="detail-value">A12345678</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-alt"></i> Passport Issue Date:</span>
                    <span class="detail-value">2021-01-01</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Passport Issue Place:</span>
                    <span class="detail-value">Dubai</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-money-bill-wave"></i> Salary:</span>
                    <span class="detail-value">$3000</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-check"></i> Contract Duration:</span>
                    <span class="detail-value">2 years</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-flag"></i> Nationality:</span>
                    <span class="detail-value">Indian</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-alt"></i> Passport Expiry Date:</span>
                    <span class="detail-value">2031-01-01</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-birthday-cake"></i> Date of Birth:</span>
                    <span class="detail-value">1990-05-15</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-handshake"></i> Foreign Partner:</span>
                    <span class="detail-value">Yes</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-building"></i> Branch in UAE:</span>
                    <span class="detail-value">Abu Dhabi</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-user-clock"></i> Age:</span>
                    <span class="detail-value">33</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-hashtag"></i> DW Number:</span>
                    <span class="detail-value">DW12345</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-venus-mars"></i> Gender:</span>
                    <span class="detail-value">Male</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-praying-hands"></i> Religion:</span>
                    <span class="detail-value">Hindu</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-language"></i> English Skills:</span>
                    <span class="detail-value">Fluent</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-language"></i> Arabic Skills:</span>
                    <span class="detail-value">Basic</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-briefcase"></i> Applied Position:</span>
                    <span class="detail-value">Software Engineer</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-tools"></i> Work Skill:</span>
                    <span class="detail-value">Programming</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-graduation-cap"></i> Education Level:</span>
                    <span class="detail-value">Bachelor's Degree</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-heart"></i> Marital Status:</span>
                    <span class="detail-value">Single</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-child"></i> Number of Children:</span>
                    <span class="detail-value">0</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-ruler-vertical"></i> Height:</span>
                    <span class="detail-value">180 cm</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-weight"></i> Weight:</span>
                    <span class="detail-value">75 kg</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-box"></i> Preferred Package:</span>
                    <span class="detail-value">Gold</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-plane"></i> Desired Country:</span>
                    <span class="detail-value">USA</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-check-circle"></i> COC Status:</span>
                    <span class="detail-value">Active</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Place of Birth:</span>
                    <span class="detail-value">Mumbai</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-home"></i> Current Address:</span>
                    <span class="detail-value">123 Main Street, Dubai</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-id-badge"></i> Labour ID Date:</span>
                    <span class="detail-value">2022-01-01</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-id-card"></i> Labour ID Number:</span>
                    <span class="detail-value">LAB123456</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-users"></i> Family Name:</span>
                    <span class="detail-value">Smith</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-phone"></i> Family Contact Number 1:</span>
                    <span class="detail-value">+971501234567</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-phone"></i> Family Contact Number 2:</span>
                    <span class="detail-value">+971502345678</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-hand-holding-heart"></i> Relationship with Candidate:</span>
                    <span class="detail-value">Brother</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-map-marked-alt"></i> Family Current Address:</span>
                    <span class="detail-value">456 Elm Street, Abu Dhabi</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-info-circle"></i> Current Status:</span>
                    <span class="detail-value">Employed</span>
                </div>
            </div>
        </div>
        <div class="modal-tab-content" id="modal-documents">
            <div class="document-list">
                <div class="document-item">
                    <span class="document-name">
                        <i class="fas fa-file-pdf"></i> Power of Attorney
                    </span>
                    <div class="document-viewer">
                        <iframe src="https://mozilla.github.io/pdf.js/web/viewer.html" frameborder="0" class="document-frame"></iframe>
                    </div>
                </div>
                <div class="document-item">
                    <span class="document-name">
                        <i class="fas fa-file-pdf"></i> Sample PDF Document
                    </span>
                    <div class="document-viewer">
                        <iframe src="https://www.adobe.com/support/products/enterprise/knowledgecenter/media/c4611_sample_explain.pdf" frameborder="0" class="document-frame"></iframe>
                    </div>
                </div>
                <div class="document-item">
                    <span class="document-name">
                        <i class="fas fa-image"></i> Sample JPG Image
                    </span>
                    <div class="document-viewer">
                        <img src="https://via.placeholder.com/800x600.jpg?text=Sample+JPG+Image" class="document-image" alt="Document Image">
                    </div>
                </div>
                <div class="document-item">
                    <span class="document-name">
                        <i class="fas fa-image"></i> Sample PNG Image
                    </span>
                    <div class="document-viewer">
                        <img src="https://via.placeholder.com/800x600.png?text=Sample+PNG+Image" class="document-image" alt="Document Image">
                    </div>
                </div>
                <div class="document-item">
                    <span class="document-name">
                        <i class="fas fa-file-alt"></i> Placeholder for Unsupported Document
                    </span>
                    <div class="document-viewer">
                        <img src="https://via.placeholder.com/800x600.png?text=Unsupported+Document" class="document-placeholder" alt="Placeholder Document">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-tab-content" id="modal-agreements">
            <table class="agreements-table">
                <thead>
                    <tr>
                        <th>Ref No</th>
                        <th>CN Number</th>
                        <th>CL Number</th>
                        <th>Started Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12345</td>
                        <td>98765</td>
                        <td>CL001</td>
                        <td>2023-01-01</td>
                        <td>2023-12-31</td>
                        <td>Active</td>
                        <td><a href="https://example.com/documents/12345.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                    <tr>
                        <td>67890</td>
                        <td>54321</td>
                        <td>CL002</td>
                        <td>2022-01-01</td>
                        <td>2022-12-31</td>
                        <td>Completed</td>
                        <td><a href="https://example.com/documents/67890.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                    <tr>
                        <td>11223</td>
                        <td>44556</td>
                        <td>CL003</td>
                        <td>2023-06-01</td>
                        <td>2024-05-31</td>
                        <td>Pending</td>
                        <td><a href="https://example.com/documents/11223.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-tab-content" id="modal-contracts">
            <table class="agreements-table">
                <thead>
                    <tr>
                        <th>Ref No</th>
                        <th>CN Number</th>
                        <th>CL Number</th>
                        <th>Started Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12345</td>
                        <td>98765</td>
                        <td>CL001</td>
                        <td>2023-01-01</td>
                        <td>2023-12-31</td>
                        <td>Active</td>
                        <td><a href="https://example.com/documents/12345.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                    <tr>
                        <td>67890</td>
                        <td>54321</td>
                        <td>CL002</td>
                        <td>2022-01-01</td>
                        <td>2022-12-31</td>
                        <td>Completed</td>
                        <td><a href="https://example.com/documents/67890.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                    <tr>
                        <td>11223</td>
                        <td>44556</td>
                        <td>CL003</td>
                        <td>2023-06-01</td>
                        <td>2024-05-31</td>
                        <td>Pending</td>
                        <td><a href="https://example.com/documents/11223.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-tab-content" id="modal-trials">
            <table class="agreements-table">
                <thead>
                    <tr>
                        <th>Ref No</th>
                        <th>CN Number</th>
                        <th>CL Number</th>
                        <th>Started Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12345</td>
                        <td>98765</td>
                        <td>CL001</td>
                        <td>2023-01-01</td>
                        <td>2023-12-31</td>
                        <td>Active</td>
                        <td><a href="https://example.com/documents/12345.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                    <tr>
                        <td>67890</td>
                        <td>54321</td>
                        <td>CL002</td>
                        <td>2022-01-01</td>
                        <td>2022-12-31</td>
                        <td>Completed</td>
                        <td><a href="https://example.com/documents/67890.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                    <tr>
                        <td>11223</td>
                        <td>44556</td>
                        <td>CL003</td>
                        <td>2023-06-01</td>
                        <td>2024-05-31</td>
                        <td>Pending</td>
                        <td><a href="https://example.com/documents/11223.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-tab-content" id="modal-incidents">
            <table class="agreements-table">
                <thead>
                    <tr>
                        <th>Ref No</th>
                        <th>CN Number</th>
                        <th>CL Number</th>
                        <th>Started Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>12345</td>
                        <td>98765</td>
                        <td>CL001</td>
                        <td>2023-01-01</td>
                        <td>2023-12-31</td>
                        <td>Active</td>
                        <td><a href="https://example.com/documents/12345.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                    <tr>
                        <td>67890</td>
                        <td>54321</td>
                        <td>CL002</td>
                        <td>2022-01-01</td>
                        <td>2022-12-31</td>
                        <td>Completed</td>
                        <td><a href="https://example.com/documents/67890.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                    <tr>
                        <td>11223</td>
                        <td>44556</td>
                        <td>CL003</td>
                        <td>2023-06-01</td>
                        <td>2024-05-31</td>
                        <td>Pending</td>
                        <td><a href="https://example.com/documents/11223.pdf" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-tab-content" id="modal-visa-tracking">
            <div class="accordion" id="visaTrackingAccordion">
                <!-- Stage 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            Salary Details
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Basic</li>
                                <li>Housing</li>
                                <li>Transportation</li>
                                <li>Other Allowances</li>
                                <li>Total</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            Visit 1
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Ol Type</li>
                                <li>Ol Expiry</li>
                                <li>St Number</li>
                                <li>Mb Number</li>
                                <li>Invoice No</li>
                                <li>Paid Date</li>
                                <li>Invoice Amount</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            Visit 2
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Applied Date</li>
                                <li>Expiry Date</li>
                                <li>Mb Number</li>
                                <li>Invoice Number</li>
                                <li>Invoice Amount</li>
                                <li>Personal Number</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 4 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            Medical
                        </button>
                    </h2>
                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Application Date</li>
                                <li>Application Expiry Date</li>
                                <li>Application Number</li>
                                <li>Result Date</li>
                                <li>Result Expiry</li>
                                <li>Invoice Date</li>
                                <li>Invoice Number</li>
                                <li>Invoice Amount</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 5 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            Tawjeeh Date
                        </button>
                    </h2>
                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Date Of Attended</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 6 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading6">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            Eid
                        </button>
                    </h2>
                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Application Date</li>
                                <li>Application Number</li>
                                <li>Biometric Schedule</li>
                                <li>Invoice Date</li>
                                <li>Invoice Number</li>
                                <li>Invoice Amount</li>
                                <li>Eid Number</li>
                                <li>Eid Expiry</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 7 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading7">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                            Residence Visa Stamping
                        </button>
                    </h2>
                    <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Applied Date</li>
                                <li>Issued Date</li>
                                <li>Expiry Date</li>
                                <li>Invoice Date</li>
                                <li>Invoice Number</li>
                                <li>Invoice Amount</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 8 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading8">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                            Visit 3
                        </button>
                    </h2>
                    <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Tawjeeh Certificate</li>
                                <li>Lc Submission Date</li>
                                <li>Invoice Date</li>
                                <li>Invoice Number</li>
                                <li>Invoice Amount</li>
                                <li>Lc Number</li>
                                <li>Lc Expiry</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 9 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading9">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                            ILOE
                        </button>
                    </h2>
                    <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Certificate Number</li>
                                <li>Duration</li>
                                <li>Inception Date</li>
                                <li>Expiry Date</li>
                                <li>Invoice Date</li>
                                <li>Invoice Amount</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 10 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading10">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                            Dubai Insurance
                        </button>
                    </h2>
                    <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Paid Date</li>
                                <li>Mb Number</li>
                                <li>Invoice Number</li>
                                <li>Invoice Amount</li>
                                <li>Applied Date</li>
                                <li>Issued Date</li>
                                <li>Expiry Date</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 11 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading11">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                            Entry Permit Visa
                        </button>
                    </h2>
                    <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Applied Date</li>
                                <li>Issued Date</li>
                                <li>Expiry Date</li>
                                <li>Permit No</li>
                                <li>Uid Number</li>
                                <li>Invoice Date</li>
                                <li>Invoice Number</li>
                                <li>Invoice Amount</li>
                                <li>Arrival Date</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Stage 12 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading12">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                            Cs (For Inside)
                        </button>
                    </h2>
                    <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12" data-bs-parent="#visaTrackingAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li>Applied Date</li>
                                <li>Issued Date</li>
                                <li>Expiry Date</li>
                                <li>Invoice Date</li>
                                <li>Invoice Amount</li>
                                <li>Remarks</li>
                                <li>Proof</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
</script><?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/user_data.blade.php ENDPATH**/ ?>