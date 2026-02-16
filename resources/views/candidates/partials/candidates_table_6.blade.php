<style>
    .table-container { width: 100%; overflow-x: auto; position: relative; }
    .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .table th, .table td { padding: 10px 15px; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .table th { background-color: #343a40; color: white; text-transform: uppercase; font-weight: bold; }
    .table-hover tbody tr:hover { background-color: #f1f1f1; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
    .btn-icon-only { display: inline-flex; align-items: center; justify-content: center; padding: 5px; border-radius: 50%; font-size: 12px; width: 30px; height: 30px; color: white; }
    .btn-info { background-color: #17a2b8; }
    .btn-warning { background-color: #ffc107; }
    .btn-danger { background-color: #dc3545; }
    .attachments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 20px;
        margin-top: 10px;
    }
    .attachment-item {
        text-align: center;
    }
    .attachment-item p {
        margin-top: 5px;
        font-size: 12px;
    }
    .img-thumbnail {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
    }
    .bg-gradient-primary {
       background: linear-gradient(to right, #007bff, #6a11cb);
    }
    .btn-sm {
        font-size: 0.8rem;
    }

    .table-warning {
        background-color: #fff3cd !important; 
    }
    .appeal-blink {
        animation: blink-animation 1.5s infinite;
        font-weight: bold;
        color: #000; 
    }
    @keyframes blink-animation {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    .pagination-controls {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
        align-items: center;
        gap: 20px;
    }
    .pagination-controls i {
        font-size: 12px;
        cursor: pointer;
        color: #343a40;
    }
    .pagination-controls i.disabled {
        color: #ccc;
        cursor: not-allowed;
    }

    .fullscreen-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1049;
    }

    .dropdown-container {
        display: none;
        position: fixed;
        z-index: 1050;
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        min-width: 350px;
        max-width: 450px;
        text-align: center;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border: 4px solid #007bff;
        animation: fadeIn 0.3s ease-in-out;
    }

    .dropdown-header {
        margin-bottom: 15px;
    }

    .dropdown-header .header-icon {
        font-size: 24px;
        color: #007bff;
        margin-bottom: 10px;
    }

    .dropdown-header p {
        font-size: 12px;
        font-weight: bold;
        color: #333;
        margin: 5px 0;
        line-height: 1.5;
    }

    .candidate-name {
        color: #007bff;
        font-weight: bold;
        font-size: 12px;
    }

    .status-dropdown {
        width: 100%;
        margin-top: 10px;
        font-size: 12px;
        border: 2px solid #007bff;
        border-radius: 6px;
        outline: none;
        background-color: #fff;
        color: #333;
    }

    .close-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        color: #ff6347;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close-icon:hover {
        color: #ff4500;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translate(-50%, -55%);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }

    .dropdown-container .fa-times {
        cursor: pointer;
        margin-left: 10px;
        color: #888;
        font-size: 12px;
    }
    .pagination-controls {
        margin-top: 10px;
        display: flex;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }

    .icon-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #f0f0f0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.3s ease;
        cursor: pointer;
    }

    .icon-wrapper i {
        font-size: 12px;
        color: #555;
    }

    .icon-wrapper:hover {
        background-color: #007BFF;
        transform: scale(1.1);
    }

    .icon-wrapper:hover i {
        color: #fff;
    }

    .icon-wrapper .disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }

    .icon-wrapper .disabled:hover {
        transform: none;
        background-color: #f0f0f0;
    }

</style>
<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th title="Agent Reference No">A . Ref #</th>
                <th title="Candidate #">Candidate #</th>
                <th title="Candidate Name">Candidate Name</th>
                <th title="Sales">Sales</th>
                <th title="Status Date">Status Date</th>
                <th title="Incident #">Incident #</th>
                <th title="WC Date">WC Date</th>
                <th title="Passport Number">Passport #</th>
                <th title="Labour ID Number">Labour ID #</th>
                <th title="Nationality">Nationality</th>
                <th title="Partners">Partners</th>
                <th title="Age">Age</th>
                <th title="Experience">Experience</th>
                <th title="Work Skill">Work Skill</th>
                <th title="Applied Position">Applied Position</th>
                <th title="Religion">Religion</th>
                <th title="Marital Status">Marital Status</th>
                <th title="Number of Children">Children</th>
                <th title="Education Level">Education Level</th>
                <th title="Phone Number">Phone Number</th>
                <th title="Family Contact #">Family Contact #</th>
                <th title="Passport Expiry Date">Passport Exp</th>
                <th title="Date of Birth">DOB</th>
                <th title="Gender">Gender</th>
                <th title="English Skills">English Skills</th>
                <th title="Arabic Skills">Arabic Skills</th>
                <th title="Height">Height</th>
                <th title="Weight">Weight</th>
                <th title="Preferred Package">Preferred Package</th>
                <th title="Certificate of Competency Status">COC Status</th>
                <th title="Place of Birth">Place of Birth</th>
                <th title="Candidate Current Address">Current Address</th>
                <th title="Labour ID Date">Labour ID Date</th>
                <th title="Labour ID Number">Labour ID #</th>
                <th title="Family Name">Family Name</th>
                <th title="Family Contact Number 1">Family Contact #1</th>
                <th title="Family Contact Number 2">Family Contact #2</th>
                <th title="Relationship with Candidate">Relationship</th>
                <th title="Family Current Address">Family Address</th>
                <th title="Action">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($candidates->isEmpty())
                <tr>
                    <td class="text-center no-records">
                        No results found.
                    </td>
                </tr>
            @else
            @foreach ($candidates as $candidate)
                <tr class="{{ $candidate->appeal == 1 ? 'table-warning appeal-row' : '' }}">
                    <td><a style="color: #007bff !important;" href="{{ route('candidates.show', $candidate->reference_no) }}" target="_blank" class="text-decoration-none text-dark">{{ strtoupper($candidate->ref_no) }}</a></td>
                    <td><a style="color: #007bff !important;" href="{{ route('candidates.show', $candidate->reference_no) }}" target="_blank" class="text-decoration-none text-dark">{{ strtoupper($candidate->CN_Number) }}</a></td>
                    <td>
                        <a style="color: #007bff !important;" href="{{ route('candidates.show', $candidate->reference_no) }}" target="_blank" class="text-decoration-none text-dark">
                            {{ $candidate->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->candidate_name))) : 'N/A' }}
                        </a>
                        <img src="{{ asset('assets/img/attach.png') }}" alt="Attachment Icon" style="cursor: pointer; margin-left: 8px; vertical-align: middle; height: 20px;" title="View Attachments of the Candidate" onclick="showCandidateModal('{{ $candidate->candidate_name }}', '{{ $candidate->id }}', '{{ $candidate->reference_no }}')"/>
                    </td>
                    <td>{{ strtoupper(optional($candidate->sales)->first_name . ' ' . optional($candidate->sales)->last_name) ?? 'N/A' }}</td>
                    <td class="text-center">
                        @php
                            $statusDateMap = [
                                1 => $candidate->updated_at,
                                2 => $candidate->backout_date,
                                3 => $candidate->hold_date,
                                4 => $candidate->selected_date,
                                5 => $candidate->wc_added_date,
                                6 => $candidate->incident_before_visa_date,
                                7 => $candidate->visa_added_date,
                                8 => $candidate->incident_after_visa_date,
                                9 => $candidate->medical_status_date,
                                10 => $candidate->coc_status_date,
                                11 => $candidate->l_submitted_date,
                                12 => $candidate->l_issued_date,
                                13 => $candidate->departure_date,
                                14 => $candidate->incident_after_departure_date,
                                15 => $candidate->arrived_added_date,
                                16 => $candidate->incident_after_arrival_date,
                                17 => $candidate->transfer_added_date,
                            ];
                            $dateToShow = $statusDateMap[$candidate->current_status] ?? $candidate->updated_at;
                        @endphp
                        <div>{{ strtoupper(\Carbon\Carbon::parse($dateToShow)->timezone('Asia/Dubai')->format('d-M-Y')) }}</div>
                        <div>{{ strtoupper(\Carbon\Carbon::parse($dateToShow)->timezone('Asia/Dubai')->format('h:i A')) }}</div>
                    </td>
                    <td>N/A</td>
                    <td>{{ $candidate->wc_date ? \Carbon\Carbon::parse($candidate->wc_date)->format('d M Y') : 'N/A' }}</td>
                    <td>{{ strtoupper($candidate->passport_no ?? '') }}</td>
                    <td>{{ strtoupper($candidate->labour_id_number ?? '') }}</td>
                    <td>{{ strtoupper($candidate->Nationality->name ?? '') }}</td>
                    <td>{{ strtoupper(explode(' ', $candidate->foreign_partner, 2)[0] . '-' . (trim(str_replace('-', '', substr($candidate->foreign_partner, strrpos($candidate->foreign_partner, '-') + 1))) ? implode('', array_map(fn($word) => strtoupper($word[0]), explode(' ', trim(substr($candidate->foreign_partner, strrpos($candidate->foreign_partner, '-') + 1))))) : 'HO')) }}</td>
                    <td>{{ strtoupper($candidate->age ?? '') }}</td>
                    <td class="text-center">
                        @if ($candidate->CandidatesExperience->count() > 0)
                            @php
                                $totalExperienceYears = $candidate->CandidatesExperience->sum('experience_years');
                                $totalExperienceMonths = $candidate->CandidatesExperience->sum('experience_months');
                                $additionalYears = intdiv($totalExperienceMonths, 12);
                                $remainingMonths = $totalExperienceMonths % 12;
                                $totalExperienceYears += $additionalYears;
                            @endphp
                            <button type="button" class="btn btn-primary btn-circle btn-sm" onclick="showExperienceModal({{ $candidate->id }})">
                                <i class="fa fa-check-circle"></i> {{ $totalExperienceYears }}.{{ $remainingMonths }} Years
                            </button>
                        @else
                            <button type="button" class="btn btn-danger btn-circle btn-sm">
                                <i class="fa fa-times-circle"></i> No Experience
                            </button>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($candidate->work_skills->count() > 0)
                            <button type="button" class="btn btn-primary btn-sm btn-circle" onclick="showSkillsModal({{ $candidate->id }})">
                                <i class="fa fa-eye"></i>
                            </button>
                        @else
                            <span class="text-muted">No skills</span>
                        @endif
                    </td>
                    <td>{{ strtoupper($candidate->appliedPosition->position_name ?? '') }}</td>
                    <td>{{ strtoupper($candidate->religion ?? '') }}</td>
                    <td>{{ strtoupper($candidate->maritalStatus->status_name ?? '') }}</td>
                    <td>{{ strtoupper($candidate->number_of_children ?? '') }}</td>
                    <td>{{ strtoupper($candidate->educationLevel->level_name ?? '') }}</td>
                    <td>{{ strtoupper($candidate->phone_number ?? 'N/A') }}</td>
                    <td>{{ strtoupper($candidate->family_contact_number_1 ?? '') }}</td>
                    <td>{{ strtoupper(\Carbon\Carbon::parse($candidate->passport_expiry_date)->format('d M Y')) }}</td>
                    <td>{{ strtoupper(\Carbon\Carbon::parse($candidate->date_of_birth)->format('d M Y')) }}</td>
                    <td>{{ strtoupper($candidate->gender ?? '') }}</td>
                    <td>{{ strtoupper($candidate->english_skills ?? '') }}</td>
                    <td>{{ strtoupper($candidate->arabic_skills ?? '') }}</td>
                    <td>{{ strtoupper($candidate->height ?? '') }} CM</td>
                    <td>{{ strtoupper($candidate->weight ?? '') }} KG</td>
                    <td>{{ strtoupper($candidate->preferred_package ?? '') }}</td>
                    <td>{{ strtoupper($candidate->coc_status ?? '') }}</td>
                    <td>{{ $candidate->place_of_birth ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->place_of_birth))) : 'N/A' }}</td>
                    <td>{{ $candidate->candidate_current_address ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->candidate_current_address ?? ''))) : 'N/A' }}</td>
                    <td>{{ strtoupper($candidate->labour_id_date ?? '') }}</td>
                    <td>{{ strtoupper($candidate->labour_id_number ?? '') }}</td>
                    <td>{{ $candidate->family_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->family_name))) : 'N/A' }}</td>
                    <td>{{ strtoupper($candidate->family_contact_number_1 ?? '') }}</td>
                    <td>{{ strtoupper($candidate->family_contact_number_2 ?? '') }}</td>
                    <td>{{ strtoupper($candidate->relationship_with_candidate ?? '') }}</td>
                    <td>{{ $candidate->family_current_address ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->family_current_address ?? ''))) : 'N/A' }}</td>
                    @php
                        $userRole = Auth::user()->role;
                        $candidateStatus = $candidate->current_status;

                        $adminStatuses = [
                            1 => 'Available',
                            3 => 'Hold',
                            4 => 'Selected',
                            5 => 'WC-Date',
                            6 => 'Incident Before Visa (IBV)',
                            7 => 'Visa Date',
                            15 => 'Arrived Date',
                            16 => 'Incident After Arrival (IAA)',
                            17 => 'Transfer Date',
                        ];

                        $dropdownStatuses = [];

                        if (in_array($userRole, ['Admin', 'Operations Manager','Managing Director','Sales Manager'], true)) {
                            $dropdownStatuses = $adminStatuses;
                        } elseif (in_array($userRole, ['Customer Service', 'Sales Coordinator', 'Sales Officer' , 'Contract Administrator','Managing Director','Archive Clerk','Operations Supervisor'])) {
                            if ($candidateStatus == 1) {
                                $dropdownStatuses = [
                                    1 => 'Available',
                                    3 => 'Hold'
                                ];
                            } elseif ($candidateStatus == 3) {
                                $dropdownStatuses = [
                                    3 => 'Hold',
                                    4 => 'Selected'
                                ];
                            } elseif ($candidateStatus == 4) {
                                $dropdownStatuses = [
                                    4 => 'Selected',
                                    5 => 'WC-Date',
                                    6 => 'Incident Before Visa (IBV)'
                                ];
                            } elseif (in_array($candidateStatus, [5, 6])) {
                                $dropdownStatuses = [
                                    5 => 'WC-Date',
                                    6 => 'Incident Before Visa (IBV)',
                                    7 => 'Visa Date',
                                    15 => 'Arrived Date',
                                    16 => 'Incident After Arrival (IAA)'
                                ];
                            } elseif (in_array($candidateStatus, [15, 16])) {
                                $dropdownStatuses = [
                                    15 => 'Arrived Date',
                                    16 => 'Incident After Arrival (IAA)',
                                    17 => 'Transfer Date'
                                ];
                            }
                        } elseif ($userRole === 'Happiness Consultant') {
                            if ($candidateStatus == 1) {
                                $dropdownStatuses = [
                                    1 => 'Available',
                                    4 => 'Selected'
                                ];
                            } elseif ($candidateStatus == 4) {
                                $dropdownStatuses = [
                                    4 => 'Selected',
                                    5 => 'WC-Date',
                                    6 => 'Incident Before Visa (IBV)',
                                    7 => 'Visa Date'
                                ];
                            } else {
                                $dropdownStatuses = [
                                    4 => 'Selected',
                                    5 => 'WC-Date',
                                    6 => 'Incident Before Visa (IBV)',
                                    7 => 'Visa Date'
                                ];
                            }
                        }
                    @endphp
                    <td class="actions">
                        <a href="{{ route('candidates.showCV', ['candidate' => $candidate->reference_no]) }}" target="_blank" class="btn btn-info btn-icon-only ms-1" title="View CV">
                            <i class="fas fa-file-alt"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-success btn-icon-only ms-1" title="View Video" data-bs-toggle="modal" data-bs-target="#videoModal-{{ $candidate->reference_no }}">
                            <i class="fas fa-video"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-icon-only" title="Change Status"
                           onclick="openDropdown('{{ $candidate->id }}', this, '{{ $candidate->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->candidate_name))) : 'N/A' }}')">
                            <i class="fas fa-train"></i>
                        </a>
                        <div class="fullscreen-overlay" id="fullscreenOverlay" onclick="closeAllDropdowns()"></div>
                        <div class="dropdown-container" id="dropdownContainer-{{ $candidate->id }}" style="display: none;">
                            <div class="close-icon" onclick="closeAllDropdowns()">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="dropdown-header">
                                <div class="header-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <p>Do you want to change the status of</p>
                                <p>candidate <span id="candidateName-{{ $candidate->id }}" class="candidate-name"></span>?</p>
                            </div>
                            <select class="form-control status-dropdown" id="statusDropdown-{{ $candidate->id }}" name="current_status" onchange="confirmStatusChange(this, '{{ $candidate->id }}', '{{ $candidate->candidate_name }}')">
                                @foreach ($dropdownStatuses as $statusId => $statusName)
                                    <option value="{{ $statusId }}" {{ $candidateStatus == $statusId ? 'selected' : '' }}>
                                        {{ $statusName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($candidate->appeal == 1)
                            <a href="javascript:void(0);" class="btn btn-warning btn-icon-only appeal-blink" title="Appeal Pending" data-bs-toggle="modal" data-bs-target="#appealModal-{{ $candidate->reference_no }}">
                                ⚠️
                            </a>
                        @endif
                        @if (in_array(Auth::user()->role, ['Sales Officer', 'Sales Coordinator']) && $candidate->current_status == 5)
                            <a href="javascript:void(0);" onclick="sendAlarm('{{ $candidate->CN_Number }}')" class="btn btn-danger btn-icon-only" title="Send Alarm to CHC about this Candidate">
                                <i class="fas fa-bell"></i>
                            </a>
                        @endif
                        @if (Auth::user()->role === 'Admin')
                            <form action="{{ route('candidates.destroy', $candidate->reference_no) }}" method="POST" style="display:inline;" id="delete-form-{{ $candidate->reference_no }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-icon-only" onclick="confirmDelete('{{ $candidate->reference_no }}')" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                <div class="modal fade custom-modal" id="videoModal-{{ $candidate->reference_no }}" tabindex="-1" aria-labelledby="videoModalLabel-{{ $candidate->reference_no }}" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title d-flex align-items-center" id="videoModalLabel-{{ $candidate->reference_no }}">
                                    <i class="fas fa-video me-2" style="color: #fff;"></i> Video of {{ $candidate->candidate_name }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            @php
                                $foreignPartner = strtolower(explode(' ', $candidate->foreign_partner)[0]);
                                $baseUrl = 'https://' . $foreignPartner . '.onesourceerp.com/storage/app/public/';
                                $videoFound = false;
                                $videoUrl = null;
                            @endphp
                            @foreach ($candidate->attachments as $attachment)
                                @if ($attachment->attachment_type == 'Video')
                                    @php
                                        $localVideoPath = 'storage/app/public/' . $attachment->attachment_file;
                                        $localVideoUrl = \Storage::exists($localVideoPath) 
                                            ? url('storage/app/public/' . $attachment->attachment_file) 
                                            : null;
                                        $remoteVideoUrl = $baseUrl . $attachment->attachment_file;
                                        $videoUrl = $localVideoUrl ?? ($attachment->attachment_file ? (get_headers($remoteVideoUrl) ? $remoteVideoUrl : null) : null);
                                        $videoFound = $videoUrl !== null;
                                    @endphp
                                    @if ($videoFound)
                                        <div class="modal-body text-center">
                                            <video id="videoPlayer-{{ $candidate->reference_no }}" controls style="max-width: 100%; height: auto; border-radius: 8px;">
                                                <source src="{{ $videoUrl }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="shareBtn-{{ $candidate->reference_no }}" class="btn btn-success">
                                                <i class="fas fa-share"></i> Share on WhatsApp
                                            </button>
                                            <script>
                                                $('#shareBtn-{{ $candidate->reference_no }}').on('click', function () {
                                                    var candidateId = $(this).attr('id').split('-')[1];
                                                    var videoUrl = $('#videoPlayer-' + candidateId + ' source').attr('src');
                                                    if (!videoUrl) {
                                                        toastr.error('Video URL is not available.');
                                                        return;
                                                    }
                                                    var whatsappUrl = 'https://wa.me/?text=' + encodeURIComponent('Check out this video: ' + videoUrl);
                                                    window.open(whatsappUrl, '_blank');
                                                    toastr.success('WhatsApp share link opened successfully.');
                                                });
                                            </script>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                            @if (!$videoFound)
                                <div class="modal-body text-center">
                                    <p>No video available for this candidate.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th title="Agent Reference No">A . Ref #</th>
                <th title="Candidate #">Candidate #</th>
                <th title="Candidate Name">Candidate Name</th>
                <th title="Sales">Sales</th>
                <th title="Status Date">Status Date</th>
                <th title="Incident #">Incident #</th>
                <th title="WC Date">WC Date</th>
                <th title="Passport Number">Passport #</th>
                <th title="Labour ID Number">Labour ID #</th>
                <th title="Nationality">Nationality</th>
                <th title="Partners">Partners</th>
                <th title="Age">Age</th>
                <th title="Experience">Experience</th>
                <th title="Work Skill">Work Skill</th>
                <th title="Applied Position">Applied Position</th>
                <th title="Religion">Religion</th>
                <th title="Marital Status">Marital Status</th>
                <th title="Number of Children">Children</th>
                <th title="Education Level">Education Level</th>
                <th title="Phone Number">Phone Number</th>
                <th title="Family Contact #">Family Contact #</th>
                <th title="Passport Expiry Date">Passport Exp</th>
                <th title="Date of Birth">DOB</th>
                <th title="Gender">Gender</th>
                <th title="English Skills">English Skills</th>
                <th title="Arabic Skills">Arabic Skills</th>
                <th title="Height">Height</th>
                <th title="Weight">Weight</th>
                <th title="Preferred Package">Preferred Package</th>
                <th title="Certificate of Competency Status">COC Status</th>
                <th title="Place of Birth">Place of Birth</th>
                <th title="Candidate Current Address">Current Address</th>
                <th title="Labour ID Date">Labour ID Date</th>
                <th title="Labour ID Number">Labour ID #</th>
                <th title="Family Name">Family Name</th>
                <th title="Family Contact Number 1">Family Contact #1</th>
                <th title="Family Contact Number 2">Family Contact #2</th>
                <th title="Relationship with Candidate">Relationship</th>
                <th title="Family Current Address">Family Address</th>
                <th title="Action">Action</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing {{ $candidates->firstItem() }} to {{ $candidates->lastItem() }} of {{ $candidates->total() }} results
        </span>
        <ul class="pagination justify-content-center">
            {{ $candidates->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>

<!-- Global Modal -->
<div class="modal fade custom-modal" id="experienceModal" tabindex="-1" aria-labelledby="experienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="experienceModalLabel">
                    <i class="fa fa-briefcase"></i> Experience Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="experienceModalBody">
                <p class="text-center">Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade custom-modal" id="skillsModal" tabindex="-1" aria-labelledby="skillsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="skillsModalLabel">
                    <i class="fa fa-cogs"></i> Skills Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="skillsModalBody">
                <p class="text-center">Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade custom-modal" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="candidateModalLabel">Candidate Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p id="candidateName" class="fw-bold fs-5"></p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-secondary" title="Attachments" id="attachmentButton" style="font-size: 12px;line-height: 2;">
                        <i class="fas fa-paperclip"></i> Attachments
                    </a>
                    <a href="#" class="btn btn-secondary" title="View Video" id="videoButton" style="font-size: 12px;line-height: 2;">
                        <i class="fas fa-video"></i> View Video
                    </a>
                    <a href="#" class="btn btn-primary" title="View CV" id="cvButton" target="_blank" style="font-size: 12px;line-height: 2;">
                        <i class="fas fa-file-alt"></i> View CV
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const CV_ROUTE_TEMPLATE = @json(route('candidates.showCV', ['candidate' => '___REF___']));
    function openDropdown(candidateId, buttonElement, candidateName) {
        $('.dropdown-container').hide();
        $('#fullscreenOverlay').fadeIn();
        const dropdownContainer = $(`#dropdownContainer-${candidateId}`);
        dropdownContainer.find('.candidate-name').text(candidateName);
        dropdownContainer.css({
            display: 'block',
            opacity: 0,
        });
        dropdownContainer.animate({ opacity: 1 }, 300);
    }

    function closeAllDropdowns() {
        $('.dropdown-container').fadeOut();
        $('#fullscreenOverlay').fadeOut();
    }

    function showExperienceModal(candidateId) {
        const modal = new bootstrap.Modal(document.getElementById('experienceModal'));
        modal.show();
        $('#experienceModalBody').html('<p class="text-center">Loading...</p>');
        const url = `/candidates/${candidateId}/experience`;
        $.ajax({
            url: url,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (data) {
                if (data.experiences.length > 0) {
                    let table = '<table class="table table-bordered text-center"><thead><tr><th>Country</th><th>Years</th><th>Months</th></tr></thead><tbody>';
                    data.experiences.forEach(exp => {
                        table += `<tr><td class="text-center">${exp.country}</td><td class="text-center">${exp.experience_years}</td><td class="text-center">${exp.experience_months}</td></tr>`;
                    });
                    table += '</tbody></table>';
                    $('#experienceModalBody').html(table);
                } else {
                    $('#experienceModalBody').html('<p class="text-center">No experience available.</p>');
                }
            },
            error: function () {
                $('#experienceModalBody').html('<p class="text-danger text-center">Failed to load experience details.</p>');
            }
        });
    }

    function showSkillsModal(candidateId) {
        const modal = new bootstrap.Modal(document.getElementById('skillsModal'));
        modal.show();
        $('#skillsModalBody').html('<p class="text-center">Loading...</p>');

        const url = `/candidates/${candidateId}/skills`;
        $.ajax({
            url: url,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (data) {
                $('#skillsModalBody').empty();
                if (data.skills.length > 0) {
                    let list = '<ul class="list-group">';
                    data.skills.forEach(skill => {
                        list += `<li class="list-group-item"><i class="fa fa-circle me-2"></i>${skill.skill_name}</li>`;
                    });
                    list += '</ul>';
                    $('#skillsModalBody').html(list);
                } else {
                    $('#skillsModalBody').html('<p class="text-center">No skills available.</p>');
                }
            },
            error: function () {
                $('#skillsModalBody').html('<p class="text-danger text-center">Failed to load skills.</p>');
            }
        });
    }

    function showCandidateModal(candidateName, candidateId, referenceNo) {
      document.getElementById('candidateName').textContent = candidateName;
      document.getElementById('attachmentButton').setAttribute('onclick', `loadimages('${candidateId}')`);
      document.getElementById('videoButton').setAttribute('data-bs-toggle', 'modal');
      document.getElementById('videoButton').setAttribute('data-bs-target', `#videoModal-${referenceNo}`);
      const cvUrl = CV_ROUTE_TEMPLATE.replace('___REF___', encodeURIComponent(referenceNo));
      document.getElementById('cvButton').setAttribute('href', cvUrl);
      const modal = new bootstrap.Modal(document.getElementById('candidateModal'));
      modal.show();
    }

</script>
