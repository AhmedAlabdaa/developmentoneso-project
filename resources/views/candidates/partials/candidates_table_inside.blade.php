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
                <th title="Arrived Date">Arrived Date</th>
                <th title="Sales">Sales</th>
                <th title="Status Date">Status Date</th>
                <th title="WC Date">WC Date</th>
                <th title="Passport Number">Passport #</th>
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
                        <i class="bi bi-box-arrow-in-up-right" onclick="showCandidateModal('{{ $candidate->candidate_name }}', '{{ $candidate->id }}', '{{ $candidate->reference_no }}')"></i>
                    </td>
                    <td><button class="btn btn-primary">{{ strtoupper(\Carbon\Carbon::parse($candidate->arrived_date)->format('d M Y')) }}</button></td>
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
                        <div>{{ strtoupper(\Carbon\Carbon::parse($dateToShow)->timezone('Asia/Qatar')->format('d-M-Y')) }}</div>
                        <div>{{ strtoupper(\Carbon\Carbon::parse($dateToShow)->timezone('Asia/Qatar')->format('h:i A')) }}</div>
                    </td>
                    <td>{{ $candidate->wc_date ? \Carbon\Carbon::parse($candidate->wc_date)->format('d M Y') : 'N/A' }}</td>
                    <td>{{ strtoupper($candidate->passport_no) }}</td>
                    <td>{{ strtoupper($candidate->Nationality->name) }}</td>
                    <td>{{ strtoupper(explode(' ', $candidate->foreign_partner, 2)[0] . '-' . (trim(str_replace('-', '', substr($candidate->foreign_partner, strrpos($candidate->foreign_partner, '-') + 1))) ? implode('', array_map(fn($word) => strtoupper($word[0]), explode(' ', trim(substr($candidate->foreign_partner, strrpos($candidate->foreign_partner, '-') + 1))))) : 'HO')) }}</td>
                    <td>{{ strtoupper($candidate->age) }}</td>
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
                    <td>{{ strtoupper($candidate->appliedPosition->position_name) }}</td>
                    <td>{{ strtoupper($candidate->religion) }}</td>
                    <td>{{ strtoupper($candidate->maritalStatus->status_name) }}</td>
                    <td>{{ strtoupper($candidate->number_of_children) }}</td>
                    <td>{{ strtoupper($candidate->educationLevel->level_name) }}</td>
                    <td>{{ strtoupper($candidate->phone_number ?? 'N/A') }}</td>
                    <td>{{ strtoupper($candidate->family_contact_number_1) }}</td>
                    <td>{{ strtoupper(\Carbon\Carbon::parse($candidate->passport_expiry_date)->format('d M Y')) }}</td>
                    <td>{{ strtoupper(\Carbon\Carbon::parse($candidate->date_of_birth)->format('d M Y')) }}</td>
                    <td>{{ strtoupper($candidate->gender) }}</td>
                    <td>{{ strtoupper($candidate->english_skills) }}</td>
                    <td>{{ strtoupper($candidate->arabic_skills) }}</td>
                    <td>{{ strtoupper($candidate->height) }} CM</td>
                    <td>{{ strtoupper($candidate->weight) }} KG</td>
                    <td>{{ strtoupper($candidate->preferred_package) }}</td>
                    <td>{{ strtoupper($candidate->coc_status) }}</td>
                    <td>{{ $candidate->place_of_birth ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->place_of_birth))) : 'N/A' }}</td>
                    <td>{{ $candidate->candidate_current_address ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->candidate_current_address))) : 'N/A' }}</td>
                    <td>{{ strtoupper($candidate->labour_id_date) }}</td>
                    <td>{{ strtoupper($candidate->labour_id_number) }}</td>
                    <td>{{ $candidate->family_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->family_name))) : 'N/A' }}</td>
                    <td>{{ strtoupper($candidate->family_contact_number_1) }}</td>
                    <td>{{ strtoupper($candidate->family_contact_number_2) }}</td>
                    <td>{{ strtoupper($candidate->relationship_with_candidate) }}</td>
                    <td>{{ $candidate->family_current_address ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->family_current_address))) : 'N/A' }}</td>
                    <td class="actions">
                        <a href="javascript:void(0);" class="btn btn-primary btn-icon-only" title="Change Status" onclick="openDropdown('{{ $candidate->id }}', this, '{{ $candidate->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->candidate_name))) : 'N/A' }}')">
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
                            <select class="form-control status-dropdown" id="statusDropdown-{{ $candidate->id }}" name="current_status" onchange="confirmStatusChange(this, '{{ $candidate->id }}', '{{ $candidate->candidate_name}}')">
                                @php
                                    $allowedStatuses = [
                                        0 => 'Change Status',
                                        1 => 'Office',
                                    ];
                                @endphp
                                @foreach ($allowedStatuses as $statusId => $statusName)
                                    <option value="{{ $statusId }}" {{ $candidate->_status == $statusId ? 'selected' : '' }}>
                                        {{ $statusName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($candidate->appeal == 1)
                            <a href="javascript:void(0);" 
                               class="btn btn-warning btn-icon-only appeal-blink" 
                               title="Appeal Pending" 
                               data-bs-toggle="modal" 
                               data-bs-target="#appealModal-{{ $candidate->reference_no }}">
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
                <th title="Arrived Date">Arrived Date</th>
                <th title="Sales">Sales</th>
                <th title="Status Date">Status Date</th>
                <th title="WC Date">WC Date</th>
                <th title="Passport Number">Passport #</th>
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
<div class="modal fade custom-modal" id="OfficeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #007bff, #6a11cb)">
                <h5 class="modal-title"><i class="fas fa-building me-2"></i>Office</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-id-badge me-2"></i> Candidate Detail</h6>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="bg-primary text-white" style="width: 30%;"><i class="fas fa-hashtag"></i> Candidate Reference</th>
                                <td id="candidateRef"></td>
                            </tr>
                            <tr>
                                <th class="bg-primary text-white"><i class="fas fa-file-contract"></i> Agreement/Contract #</th>
                                <td id="agreementNo"></td>
                            </tr>
                            <tr>
                                <th class="bg-primary text-white"><i class="fas fa-user"></i> Full Name</th>
                                <td id="fullName"></td>
                            </tr>
                            <tr>
                                <th class="bg-primary text-white"><i class="fas fa-passport"></i> Passport Number</th>
                                <td id="passportNo"></td>
                            </tr>
                            <tr>
                                <th class="bg-primary text-white"><i class="fas fa-flag"></i> Nationality</th>
                                <td id="nationality"></td>
                            </tr>
                            <tr>
                                <th class="bg-primary text-white"><i class="fas fa-eye"></i> View</th>
                                <td><a href="" class="btn btn-primary btn-sm" id="#userLink" target="_blank"><i class="fas fa-external-link-alt"></i> View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mb-4">
                    <h6 class="fw-bold"><i class="fas fa-user-tie me-2"></i> Agent Detail</h6>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="bg-secondary text-white" style="width: 30%;"><i class="fas fa-user"></i> Agent Name</th>
                                <td id="agentName"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white"><i class="fas fa-hashtag"></i> Agent Reference #</th>
                                <td id="agentRef"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <h6 class="fw-bold"><i class="fas fa-edit me-2"></i> Update Details</h6>
                    <form id="updateDetailsForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="arrived_in_office_date" class="form-label"><i class="fas fa-calendar-alt me-1"></i> Arrived Date</label>
                                <input type="date" id="arrived_in_office_date" name="arrived_in_office_date" data-required="true" class="form-control" required>
                                <input type="hidden" name="candidate_id" value="" id="candidate_id" required>
                            </div>
                            <div class="col-md-6">
                                <label for="visa_type" class="form-label"><i class="fas fa-passport me-1"></i> Visa Type</label>
                                <select id="visa_type" name="visa_type" data-required="true" class="form-select" required>
                                    <option value="">Select Visa Type</option>
                                    <option value="D-SPO">D-SPO</option>
                                    <option value="D-HIRE">D-HIRE</option>
                                    <option value="ROZANA SERVICE">ROZANA SERVICE</option>
                                    <option value="FAMILY-CARE CLEANING & HOSPITALITY">FAMILY-CARE CLEANING & HOSPITALITY</option>
                                    <option value="OFFICE-VISA">OFFICE-VISA</option>
                                    <option value="HAYYA">HAYYA</option>
                                    <option value="Cancellation">CANCELLATION</option>
                                </select>
                            </div>
                        </div>
                        <div id="visaFields" class="mb-3 d-none">
                            <div class="row mb-3" id="dynamicFields">
                                <!-- Dynamic fields will appear here -->
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="overstay_days" class="form-label"><i class="fas fa-clock me-1"></i> Overstay Days</label>
                                    <input type="number" name="overstay_days" data-required="true" id="overstay_days" value="0" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="fine_amount" class="form-label"><i class="fas fa-money-bill-wave me-1"></i> Fine Amount</label>
                                    <input type="number" name="fine_amount" data-required="true" id="fine_amount" value="0" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="accomodation" class="form-label"><i class="fas fa-home me-1"></i> Accommodation Branch</label>
                                <select id="accomodation" name="accomodation" data-required="true" class="form-select">
                                    <option value="">Select Branch</option>
                                    <option value="Branch-1">Branch-1</option>
                                    <option value="Branch-2">Branch-2</option>
                                    <option value="Branch-3">Branch-3</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="preferred_package" class="form-label"><i class="fas fa-home me-1"></i> Prefered Package</label>
                                <select id="preferred_package" name="preferred_package" data-required="true" class="form-select">
                                    <option value="">Select Branch</option>
                                    <option value="PKG-1">PACKAGE-1</option>
                                    <option value="PKG-2">PACKAGE-2</option>
                                    <option value="PKG-3">PACKAGE-3</option>
                                    <option value="PKG-4">PACKAGE-4</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="passport_status" class="form-label"><i class="fas fa-book me-1"></i> Passport Status</label>
                                <select id="passport_status" name="passport_status" data-required="true" class="form-select">
                                    <option value="">Select Passport Status</option>
                                    <option value="With Employer">With Employer</option>
                                    <option value="With Candidate">With Candidate</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Lost">Lost</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Close</button>
                            <button type="button" id="saveDetailsBtn" class="btn btn-success"><i class="fas fa-save me-1"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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
        document.getElementById('cvButton').setAttribute('href', `/${referenceNo}/cv`);
        const modal = new bootstrap.Modal(document.getElementById('candidateModal'));
        modal.show();
    }
    $(document).ready(function () {
        function calculateDaysAndFine() {
            const today = new Date();
            const expiryDate = new Date($('#visaExpiry').val());
            const daysOverdue = Math.floor((today - expiryDate) / (1000 * 60 * 60 * 24));
            const finePerDay = 100; 
            if (daysOverdue > 0) {
                $('#overstay_days').val(daysOverdue);
                $('#fine_amount').val(daysOverdue * finePerDay);
            } else {
                $('#overstay_days').val(0);
                $('#fine_amount').val(0);
            }
        }
        $('#visa_type').change(function () {
            const visa_type = $(this).val();
            $('#dynamicFields').empty();
            $('#visaFields').toggleClass('d-none', visa_type === '');
            if (visa_type === 'Tourist') {
                $('#dynamicFields').append(`
                    <div class="col-md-6">
                        <label for="visa_issue_date" class="form-label"><i class="fas fa-calendar-plus me-1"></i> Visa Issue / Renew Date</label>
                        <input type="date" id="visa_issue_date" name="visa_issue_date" data-required="true" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="visa_expiry_date" class="form-label"><i class="fas fa-calendar-times me-1"></i> Visa Expiry Date</label>
                        <input type="date" id="visa_expiry_date" name="visa_expiry_date" data-required="true" class="form-control">
                    </div>
                `);
            } else if (visa_type === 'OFFICE-VISA' || visa_type === 'ROZANA SERVICE' || visa_type === 'FAMILY-CARE CLEANING & HOSPITALITY') {
                $('#dynamicFields').append(` 
                    <div class="col-md-6">
                        <label for="entry_date" class="form-label"><i class="fas fa-calendar-alt me-1"></i> Entry Date</label>
                        <input type="date" id="entry_date" name="entry_date" data-required="true" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="visa_expiry_date" class="form-label"><i class="fas fa-calendar-times me-1"></i> Visa Expiry Date</label>
                        <input type="date" id="visa_expiry_date" name="visa_expiry_date" data-required="true" class="form-control">
                    </div>
                `);
            } else if (visa_type === 'Cancellation') {
                $('#dynamicFields').append(`
                    <div class="col-md-6">
                        <label for="cancellation_date" class="form-label"><i class="fas fa-ban me-1"></i> Visa Cancellation Date</label>
                        <input type="date" id="cancellation_date" name="cancellation_date" data-required="true" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="visa_expiry_date" class="form-label"><i class="fas fa-calendar-times me-1"></i> Visa Expiry Date</label>
                        <input type="date" id="visa_expiry_date" name="visa_expiry_date" data-required="true" class="form-control">
                    </div>
                `);
            }
            $('#visa_expiry_date').change(calculateDaysAndFine);
        });
    });
    $(document).ready(function () {
        const $clientDropdown = $('#clientDropdown');
        $clientDropdown.on('change', function () {
            const selectedClientText = $clientDropdown.find('option:selected').text();
            if (selectedClientText === 'Company') {
                $('#VisaType').val('ROZANA SERVICE').trigger('change');
            }
        });
    });
    $('#paymentProof').on('change', function() {
        const allowedExtensions = ['png', 'jpeg', 'jpg', 'pdf'];
        const file = $(this).val().split('.').pop().toLowerCase();
        const totalAmount = parseFloat($('#totalAmount').val()) || 0;
        const receivedAmount = parseFloat($('#receivedAmount').val()) || 0;
        if (!totalAmount || !receivedAmount) {
            toastr.error('Fill Total Amount and Received Amount before uploading proof.');
            $(this).val('');
            $('#agreementSection').hide();
            return;
        }
        if (allowedExtensions.includes(file)) {
            $('#agreementSection').show();
        } else {
            toastr.error('Only PNG, JPEG, JPG, and PDF files are allowed.');
            $(this).val('');
            $('#agreementSection').hide();
        }
    });
    $('#totalAmount, #receivedAmount').on('input', function() {
        const totalAmount = parseFloat($('#totalAmount').val()) || 0;
        const receivedAmount = parseFloat($('#receivedAmount').val()) || 0;
        const remainingAmount = totalAmount - receivedAmount;
        if (remainingAmount < 0) {
            toastr.error('Received amount cannot exceed the total amount.');
            $('#receivedAmount').val('');
            $('#remainingAmount').val('');
            $('#vatAmount').val('');
            $('#netAmount').val('');
            return;
        }
        $('#remainingAmount').val(remainingAmount);
        const vatAmount = totalAmount * 0.00;
        const netAmount = totalAmount + vatAmount;
        $('#vatAmount').val(vatAmount.toFixed(2));
        $('#netAmount').val(netAmount.toFixed(2));
    });
    $('#VisaType').on('change', function() {
        const selectedVisaType = $(this).val();
        const additionalFieldContainer = $('#additionalFieldContainer');
        additionalFieldContainer.empty();
        if (!selectedVisaType) {
            alert('Please choose a visa type.');
            return;
        }
        if (selectedVisaType === 'VISIT' || selectedVisaType === 'TOURIST') {
            additionalFieldContainer.html(`
            <label for="contractDuration"><i class="fas fa-calendar-alt text-default"></i> Contract Duration <span class="text-danger">*</span></label>
            <input type="text" id="contractDuration" name="contract_duration" class="form-control" placeholder="Enter Contract Duration">
        `);
        } else {
            additionalFieldContainer.html(`
            <label for="contractDuration"><i class="fas fa-calendar-alt text-default"></i> Contract Duration <span class="text-danger">*</span></label>
            <input type="text" id="contractDuration" name="contract_duration" class="form-control" value="2 Years" readonly>
        `);
        }
        $('#new_contract_field').append('<div id="additionalFieldContainer" class="col-md-6"></div>');
    });
    $('#agreedSalary').on('input keydown', function (e) {
        const key = e.key;
        const value = $(this).val();
        if (!/^[0-9.]$/.test(key) && e.keyCode !== 8 && e.keyCode !== 46) {
            e.preventDefault();
        }
        if (key === '.' && value.includes('.')) {
            e.preventDefault();
        }
    });
    $('#agreedSalary').on('blur', function () {
        const agreedSalary = parseFloat($(this).val());
        if (isNaN(agreedSalary) || agreedSalary < 1200) {
            toastr.error('The agreed salary must be at least 1200.');
            $(this).val('');
            $(this).focus();
        }
    });
    function confirmStatusChange(selectElement, candidateId, candidateFullName) {
        const selectedStatus = selectElement.options[selectElement.selectedIndex].text;
        Swal.fire({
            title: `Change status for ${candidateFullName}?`,
            text: `Do you want to change the status to "${selectedStatus}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, change it',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(selectElement, candidateId);
            } else {
                const previousStatus = [...selectElement.options].find(option => option.defaultSelected);
                if (previousStatus) {
                    selectElement.value = previousStatus.value;
                }
            }
        });
    }
    function updateStatus(selectElement, candidateId) {
        const statusId = selectElement.value;
        const csrfToken = '{{ csrf_token() }}'; 
        const updateStatusUrl = "{{ route('candidates.update-status-inside', ['candidate' => ':reference_no']) }}".replace(':reference_no', candidateId);
        $.ajax({
            url: updateStatusUrl,
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: { status_id: statusId },
            success: function (response) {
                if (response.success) {
                    if (response.action === 'open_modal' && response.modal) {
                        const modalId = `#${response.modal}`;
                        $(modalId).modal('show');
                        populateModalFields(modalId, response.candidateDetails , response.clients);
                        if (response.clients) {
                            const clientDropdown = $(`${modalId} #clientDropdown`);
                            populateDropdown(clientDropdown, response.clients, 'id', 'first_name');
                        }
                        if (response.modal === 'ConfirmedModal') {
                            handleInvoices(response.candidate_details.invoices, response.candidate_details.remainingAmountWithVat);
                        }
                    } else {
                        toastr.success(response.message || 'Status has been updated successfully!');
                    }
                    if (response.statusColor) {
                        $(selectElement).css('background-color', response.statusColor);
                    }
                } else {
                    toastr.error(response.message || 'Failed to update status. Please try again.');
                }
            },
            error: function () {
                toastr.error('An error occurred. Please try again.');
            }
        });
    }
    function populateModalFields(modalId, candidateDetails, clients) {
        const setTextOrNA = (selector, value) => {
            $(`${modalId} ${selector}`).text(value || 'N/A');
        };
        setTextOrNA('#candidateRef', candidateDetails.referenceNo);
        setTextOrNA('#fullName', candidateDetails.candidateName);
        setTextOrNA('#agreementNo', candidateDetails.agreement);
        setTextOrNA('#passportNo', candidateDetails.passportNo);
        setTextOrNA('#nationality', candidateDetails.nationality);
        setTextOrNA('#employerName', candidateDetails.employerName);
        setTextOrNA('#agentName', candidateDetails.foreignPartner);
        setTextOrNA('#agentRef', candidateDetails.ref_no);
        $("#candidate_id").val(candidateDetails.candidateId);
        $("#arrived_in_office_date").val(candidateDetails.arrived_date);
        $("#userLink").attr("href", candidateDetails.view);
        // populate modal fields of trials
        $('#TrialModalcandidateName').val(candidateDetails.candidateName);
        $('#TrialModalcandidateId').val(candidateDetails.candidateId);
        $('#TrialModalreferenceNo').val(candidateDetails.referenceNo);
        $('#TrialModalrefNo').val(candidateDetails.ref_no);
        $('#TrialModalforeignPartner').val(candidateDetails.foreignPartner);
        $('#TrialModalcandiateNationality').val(candidateDetails.nationality);
        $('#TrialModalcandidatePassportNumber').val(candidateDetails.passportNo);
        $('#TrialModalcandidatePassportExpiry').val(candidateDetails.passportExpiry);
        $('#TrialModalcandidateDOB').val(candidateDetails.candidateDOB);                                 
        $(`${modalId} #remainingAmount`).text(
            candidateDetails.remainingAmountWithVat
                ? candidateDetails.remainingAmountWithVat.toFixed(2)
                : '0.00'
        );
        const invoiceTable = $(`${modalId} #invoiceTableBody`);
        invoiceTable.empty();
        if (candidateDetails.invoices && candidateDetails.invoices.length > 0) {
            candidateDetails.invoices.forEach(invoice => {
                invoiceTable.append(`
                    <tr>
                        <td>${invoice.invoice_no || 'N/A'}</td>
                        <td>${invoice.total_amount || 'N/A'}</td>
                        <td>${invoice.received_amount || 'N/A'}</td>
                        <td>${invoice.status || 'N/A'}</td>
                    </tr>
                `);
            });
        } else {
            invoiceTable.append('<tr><td colspan="4">No invoices available</td></tr>');
        }
    }
    $(document).ready(function () {
        $('#saveDetailsBtn').on('click', function (event) {
            event.preventDefault();
            let isValid = true;
            $('#updateDetailsForm [required], #updateDetailsForm [data-required="true"]').each(function () {
                const value = $(this).val();
                if (!value || value.trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            if (!isValid) {
                toastr.error('Please fill out all required fields.');
                return;
            }
            const formData = new FormData();
            $('#updateDetailsForm [required], #updateDetailsForm [data-required="true"]').each(function () {
                const fieldId = $(this).attr('id');
                formData.append(fieldId, $(this).val());
            });
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('candidates.updateCandidateDetails')}}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        toastr.success('Details updated successfully!');
                        $('#OfficeModal').modal('hide');
                    } else {
                        toastr.error('Failed to update details: ' + response.message);
                    }
                },
                error: function () {
                    toastr.error('An error occurred while updating details.');
                }
            });
        });
    });
    allowOnlyNumbers('#totalAmount');
    allowOnlyNumbers('#receivedAmount');
    allowOnlyNumbers('#remainingAmount');
    function allowOnlyNumbers(selector) {
        $(selector).on('input', function() {
            const sanitizedValue = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(sanitizedValue);
        });
    }
    $(document).ready(function () {
        const $clientDropdown = $('#clientDropdown');
        $clientDropdown.on('change', function () {
            const selectedClientText = $clientDropdown.find('option:selected').text();
            if (selectedClientText === 'Tadbeer Sponsorship') {
                $('#VisaType').val('TADBEER').trigger('change');
                $('#additionalFieldContainer').remove();
            } else {
                $('#additionalFieldContainer').remove();
            }
        });
        $clientDropdown.on('select2:unselect', function () {
            $('#additionalFieldContainer').remove();
        });
    });
    $('#paymentProof').on('change', function() {
        const allowedExtensions = ['png', 'jpeg', 'jpg', 'pdf'];
        const file = $(this).val().split('.').pop().toLowerCase();
        const totalAmount = parseFloat($('#totalAmount').val()) || 0;
        const receivedAmount = parseFloat($('#receivedAmount').val()) || 0;
        if (!totalAmount || !receivedAmount) {
            toastr.error('Fill Total Amount and Received Amount before uploading proof.');
            $(this).val('');
            $('#agreementSection').hide();
            return;
        }
        if (allowedExtensions.includes(file)) {
            $('#agreementSection').show();
        } else {
            toastr.error('Only PNG, JPEG, JPG, and PDF files are allowed.');
            $(this).val('');
            $('#agreementSection').hide();
        }
    });
    $('#totalAmount, #receivedAmount').on('input', function() {
        const totalAmount = parseFloat($('#totalAmount').val()) || 0;
        const receivedAmount = parseFloat($('#receivedAmount').val()) || 0;
        const remainingAmount = totalAmount - receivedAmount;
        if (remainingAmount < 0) {
            toastr.error('Received amount cannot exceed the total amount.');
            $('#receivedAmount').val('');
            $('#remainingAmount').val('');
            $('#vatAmount').val('');
            $('#netAmount').val('');
            return;
        }
        $('#remainingAmount').val(remainingAmount);
        const vatAmount = totalAmount * 0.00;
        const netAmount = totalAmount + vatAmount;
        $('#vatAmount').val(vatAmount.toFixed(2));
        $('#netAmount').val(netAmount.toFixed(2));
    });
    function validateAgreementForm() {
        const packageSelected = $('#packageDropdown').val();
        const candidateName = $('#TrialModalcandidateName').val();
        const clientSelected = $('#clientDropdown').val();
        const totalAmount = parseFloat($('#totalAmount').val());
        const receivedAmount = parseFloat($('#receivedAmount').val());
        const remainingAmount = $('#remainingAmount').val();
        const paymentMethod = $('#paymentMethod').val();
        const paymentProof = $('#paymentProof').val();
        const agreedSalary = $('#agreedSalary').val();
        const visaType = $('#VisaType').val();
        const TrialStartDate = $('#TrialStartDate').val();
        const TrialEndDate = $('#TrialEndDate').val();
        const NumberOfDays = $('#NumberOfDays').val();
        if (!packageSelected) {
            toastr.error('Please select a package.');
            $('#packageDropdown').focus();
            return false;
        }
        if (!candidateName) {
            toastr.error('Candidate name is required.');
            $('#TrialModalcandidateName').focus();
            return false;
        }
        if (packageSelected === 'PKG-1' && !clientSelected) {
            toastr.error('Please select a client for PKG-1.');
            $('#clientDropdown').focus();
            return false;
        }
        if (!totalAmount || isNaN(totalAmount) || totalAmount <= 0) {
            toastr.error('Please enter a valid total amount.');
            $('#totalAmount').focus();
            return false;
        }
        if (!receivedAmount || isNaN(receivedAmount) || receivedAmount <= 0) {
            toastr.error('Please enter a valid received amount.');
            $('#receivedAmount').focus();
            return false;
        }
        if (!remainingAmount || isNaN(remainingAmount)) {
            toastr.error('Remaining amount must be calculated.');
            $('#remainingAmount').focus();
            return false;
        }
        if (!paymentMethod) {
            toastr.error('Please select a payment method.');
            $('#paymentMethod').focus();
            return false;
        }
        if (!paymentProof) {
            toastr.error('Please upload payment proof.');
            $('#paymentProof').focus();
            return false;
        }
        if (!agreedSalary || isNaN(agreedSalary) || agreedSalary <= 0) {
            toastr.error('Please enter a valid salary amount.');
            $('#agreedSalary').focus();
            return false;
        }
        if (!visaType) {
            toastr.error('Please select a visa type.');
            $('#VisaType').focus();
            return false;
        }
        if (!NumberOfDays) {
            toastr.error('Please select number of days.');
            $('#NumberOfDays').focus();
            return false;
        }
        return true;
    }
    $('#saveChanges').on('click', function(e) {
        e.preventDefault();
        if (!validateAgreementForm()) {
            return;
        }
        const formData = new FormData();
        formData.append('candidate_id', $('#TrialModalcandidateId').val());
        formData.append('candidate_name', $('#TrialModalcandidateName').val());
        formData.append('reference_of_candidate', $('#TrialModalreferenceNo').val());
        formData.append('ref_no_in_of_previous', $('#TrialModalrefNo').val());
        formData.append('package', $('#packageDropdown').val());
        formData.append('client_id', $('#clientDropdown').val());
        formData.append('payment_method', $('#paymentMethod').val());
        formData.append('total_amount', $('#totalAmount').val());
        formData.append('received_amount', $('#receivedAmount').val());
        formData.append('remaining_amount', $('#remainingAmount').val());
        formData.append('vat_amount', $('#vatAmount').val());
        formData.append('net_amount', $('#netAmount').val());
        formData.append('notes', $('#paymentNotes').val());
        formData.append('agreement_type', $('#agreementType').val());
        formData.append('salary', $('#agreedSalary').val());
        formData.append('foreign_partner', $('#TrialModalforeignPartner').val());
        formData.append('nationality', $('#TrialModalcandiateNationality').val());
        formData.append('passport_no', $('#TrialModalcandidatePassportNumber').val());
        formData.append('trial_start_date', $('#TrialStartDate').val());
        formData.append('trial_end_date', $('#TrialEndDate').val());
        formData.append('number_of_days', $('#NumberOfDays').val());
        formData.append('passport_expiry_date', $('#TrialModalcandidatePassportExpiry').val());
        formData.append('date_of_birth', $('#TrialModalcandidateDOB').val());
        formData.append('visa_type', $('#VisaType').val());
        formData.append('contract_duration', $('#NumberOfDays').val());
        const paymentProof = $('#paymentProof')[0].files[0];
        if (paymentProof) {
            formData.append('payment_proof', paymentProof);
        }
        $('#spinner').show();
        $.ajax({
            url: '{{ route('agreements.insideagreement')}}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#spinner').hide();
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $('#TrialModalForm')[0].reset();
                    $('#TrialModal').modal('hide');
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                $('#spinner').hide();
                const response = xhr.responseJSON;
                if (response && response.errors) {
                    Object.entries(response.errors).forEach(([key, errors]) => {
                        errors.forEach(error => toastr.error(`${key}: ${error}`));
                    });
                } else {
                    toastr.error('An unexpected error occurred.');
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('TrialStartDate');
        const endDateInput = document.getElementById('TrialEndDate');
        const numberOfDaysInput = document.getElementById('NumberOfDays');
        if (startDateInput && endDateInput && numberOfDaysInput) {
            startDateInput.addEventListener('change', calculateNumberOfDays);
            endDateInput.addEventListener('change', calculateNumberOfDays);
            function calculateNumberOfDays() {
                const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
                const endDate = endDateInput.value ? new Date(endDateInput.value) : null;

                if (startDate && endDate) {
                    if (endDate >= startDate) {
                        const timeDifference = endDate.getTime() - startDate.getTime();
                        const daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24)) + 1;
                        numberOfDaysInput.value = daysDifference;
                    } else {
                        toastr.error('End Date must be after or equal to Start Date');
                        numberOfDaysInput.value = '';
                    }
                } else {
                    numberOfDaysInput.value = '';
                }
            }
        } else {
            console.error('One or more elements (TrialStartDate, TrialEndDate, NumberOfDays) not found in the DOM.');
        }
    });

    $('#packageDropdown').on('change', function () {
        const packageValue = $(this).val();
        const $clientDropdown = $('#clientDropdown');
        const $visaTypeDropdown = $('#VisaType');
        if (packageValue === 'PKG-1') {
            $clientDropdown.find('option').filter(function () {
                return $(this).text() === 'ROZANA SERVICE' || $(this).text() === 'FAMILY-CARE CLEANING & HOSPITALITY';
            }).prop('disabled', true);
            $visaTypeDropdown.find('option').each(function () {
                $(this).prop('disabled', $(this).text() === 'ROZANA SERVICE' || $(this).text() === 'FAMILY-CARE CLEANING & HOSPITALITY');
            });
        } else if (['PKG-2', 'PKG-3', 'PKG-4'].includes(packageValue)) {
            $clientDropdown.find('option').each(function () {
                $(this).prop('disabled', !($(this).text() === 'ROZANA SERVICE' || $(this).text() === 'FAMILY-CARE CLEANING & HOSPITALITY'));
            });
            $visaTypeDropdown.find('option').each(function () {
                $(this).prop('disabled', !($(this).text() === 'ROZANA SERVICE' || $(this).text() === 'FAMILY-CARE CLEANING & HOSPITALITY'));
            });
        } else {
            $clientDropdown.find('option').prop('disabled', false);
            $visaTypeDropdown.find('option').prop('disabled', false);
        }
        if (['ROZANA SERVICE', 'FAMILY-CARE CLEANING & HOSPITALITY'].includes($clientDropdown.val()) && packageValue === 'PKG-1') {
            $clientDropdown.val('');
        }
        if (['ROZANA SERVICE', 'FAMILY-CARE CLEANING & HOSPITALITY'].includes($visaTypeDropdown.val()) && packageValue === 'PKG-1') {
            $visaTypeDropdown.val('');
        }
        if (['PKG-2', 'PKG-3', 'PKG-4'].includes(packageValue)) {
            if (!['ROZANA SERVICE', 'FAMILY-CARE CLEANING & HOSPITALITY'].includes($clientDropdown.val())) {
                $clientDropdown.val('');
            }
            if (!['ROZANA SERVICE', 'FAMILY-CARE CLEANING & HOSPITALITY'].includes($visaTypeDropdown.val())) {
                $visaTypeDropdown.val('');
            }
        }
    });

    $(document).ready(function () {
        $('#clientDropdownOutside').select2({
            placeholder: "Select a client",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#selectedModal') 
        });
    });
</script>
