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

    .attachments-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px; margin-top: 10px; }
    .attachment-item { text-align: center; }
    .attachment-item p { margin-top: 5px; font-size: 12px; }
    .img-thumbnail { max-width: 100px; max-height: 100px; object-fit: cover; }
    .bg-gradient-primary { background: linear-gradient(to right, #007bff, #6a11cb); }
    .btn-sm { font-size: 0.8rem; }
    .table-warning { background-color: #fff3cd !important; }
    .appeal-blink { animation: blink-animation 1.5s infinite; font-weight: bold; color: #000; }
    @keyframes blink-animation { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }

    .pagination-controls { display: flex; justify-content: center; margin-bottom: 10px; align-items: center; gap: 20px; }
    .pagination-controls i { font-size: 12px; cursor: pointer; color: #343a40; }
    .pagination-controls i.disabled { color: #ccc; cursor: not-allowed; }

    .fullscreen-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1049; }

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

    .dropdown-header { margin-bottom: 15px; }
    .dropdown-header .header-icon { font-size: 24px; color: #007bff; margin-bottom: 10px; }
    .dropdown-header p { font-size: 12px; font-weight: bold; color: #333; margin: 5px 0; line-height: 1.5; }
    .candidate-name { color: #007bff; font-weight: bold; font-size: 12px; }

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
    .close-icon:hover { color: #ff4500; }

    @keyframes fadeIn { from { opacity: 0; transform: translate(-50%, -55%); } to { opacity: 1; transform: translate(-50%, -50%); } }

    .dropdown-container .fa-times { cursor: pointer; margin-left: 10px; color: #888; font-size: 12px; }

    .pagination-controls { margin-top: 10px; display: flex; gap: 10px; justify-content: center; align-items: center; }

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

    .icon-wrapper i { font-size: 12px; color: #555; }
    .icon-wrapper:hover { background-color: #007BFF; transform: scale(1.1); }
    .icon-wrapper:hover i { color: #fff; }

    .icon-wrapper .disabled { cursor: not-allowed; opacity: 0.5; }
    .icon-wrapper .disabled:hover { transform: none; background-color: #f0f0f0; }
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th title="Serial #">Sr #</th>
                <th title="Agent Reference No">A . Ref #</th>
                <th title="Registration Date">Registration Date</th>
                <th title="Current Status">Current Status</th>
                <th title="Partners">Partners</th>
                <th title="Candidate Name">Candidate Name</th>
                <th title="Passport Number">Passport #</th>
                <th title="Labour ID Number">Labour ID #</th>
                <th title="Nationality">Nationality</th>
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
                <th title="Status Date">Status Date</th>
                <th title="Passport Expiry Date">Passport Exp</th>
                <th title="Date of Birth">DOB</th>
                <th title="Gender">Gender</th>
                <th title="English Skills">English Skills</th>
                <th title="Arabic Skills">Arabic Skills</th>
                <th title="Height">Height</th>
                <th title="Weight">Weight</th>
                <th title="Preferred Package">Preferred Package</th>
                <th title="Desired Country">Desired Country</th>
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
            <?php if($candidates->isEmpty()): ?>
                <tr>
                    <td class="text-center no-records">No results found.</td>
                </tr>
            <?php else: ?>
                <?php $__currentLoopData = $candidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="<?php echo e($candidate->appeal == 1 ? 'table-warning appeal-row' : ''); ?>" data-ref="<?php echo e($candidate->reference_no); ?>">
                        <td><?php echo e($candidate->reference_no); ?></td>
                        <td>
                            <a style="color: #007bff !important;" href="<?php echo e(route('candidates.show', $candidate->reference_no)); ?>" target="_blank" class="text-decoration-none text-dark">
                                <?php echo e(strtoupper($candidate->ref_no)); ?>

                            </a>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($candidate->created_at)->format('d M Y')); ?></td>

                        <?php
                            $statusDisplay = [
                                0  => ['Draft', 'fa-file', 'secondary'],
                                1  => ['Available', 'fa-user-check', 'success'],
                                2  => ['Back Out', 'fa-user-times', 'danger'],
                                3  => ['Hold', 'fa-pause-circle', 'warning'],
                                4  => ['Selected', 'fa-check-circle', 'primary'],
                                5  => ['WC-Date', 'fa-calendar-alt', 'info'],
                                6  => ['Incident Before Visa (IBV)', 'fa-exclamation-triangle', 'warning'],
                                7  => ['Visa Date', 'fa-passport', 'info'],
                                8  => ['Incident After Visa (IAV)', 'fa-exclamation-circle', 'danger'],
                                9  => ['Medical Status', 'fa-notes-medical', 'secondary'],
                                10 => ['COC-Status', 'fa-file-signature', 'secondary'],
                                11 => ['MoL Submitted Date', 'fa-paper-plane', 'info'],
                                12 => ['MoL Issued Date', 'fa-file-alt', 'info'],
                                13 => ['Departure Date', 'fa-plane-departure', 'primary'],
                                14 => ['Incident After Departure (IAD)', 'fa-exclamation-circle', 'danger'],
                                15 => ['Arrived Date', 'fa-plane-arrival', 'success'],
                                16 => ['Incident After Arrival (IAA)', 'fa-exclamation-triangle', 'danger'],
                                17 => ['Transfer Date', 'fa-exchange-alt', 'secondary'],
                            ];
                            [$label, $icon, $color] = $statusDisplay[(int) $candidate->current_status] ?? ['Unknown', 'fa-question-circle', 'muted'];
                        ?>

                        <td class="js-status-cell" data-status="<?php echo e((int) $candidate->current_status); ?>">
                            <i class="fas <?php echo e($icon); ?> text-<?php echo e($color); ?>"></i>
                            <span class="js-status-label"><?php echo e($label); ?></span>
                        </td>

                        <td>
                            <?php echo e(strtoupper(
                                    explode(' ', $candidate->foreign_partner, 2)[0] . '-' .
                                    (
                                        trim(substr($candidate->foreign_partner, strrpos($candidate->foreign_partner, '-') + 1))
                                        ? (str_contains(substr($candidate->foreign_partner, strrpos($candidate->foreign_partner, '-') + 1), ' ')
                                            ? implode('', array_map(fn($word) => strtoupper($word[0]), explode(' ', trim(substr($candidate->foreign_partner, strrpos($candidate->foreign_partner, '-') + 1)))))
                                            : strtoupper(trim(substr($candidate->foreign_partner, strrpos($candidate->foreign_partner, '-') + 1)))
                                        )
                                        : 'HO'
                                    )
                                )); ?>

                        </td>

                        <td class="align-middle">
                            <a style="color: #007bff !important;" href="<?php echo e(route('candidates.show', $candidate->reference_no)); ?>" target="_blank" class="text-decoration-none text-dark">
                                <?php echo e($candidate->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->candidate_name))) : 'N/A'); ?>

                            </a>
                            <img
                                src="<?php echo e(asset('assets/img/attach.png')); ?>"
                                alt="Attachment Icon"
                                style="cursor: pointer; margin-left: 8px; vertical-align: middle; height: 20px;"
                                title="View Attachments of the Candidate"
                                onclick="showCandidateModal('<?php echo e($candidate->candidate_name); ?>', '<?php echo e($candidate->id); ?>', '<?php echo e($candidate->reference_no); ?>')"
                            />
                        </td>

                        <td><?php echo e(strtoupper($candidate->passport_no)); ?></td>
                        <td><?php echo e(strtoupper($candidate->labour_id_number)); ?></td>
                        <td><?php echo e(strtoupper($candidate->Nationality->name ?? '')); ?></td>
                        <td><?php echo e(strtoupper($candidate->age ?? '')); ?></td>

                        <td class="text-center">
                            <?php if($candidate->CandidatesExperience->count() > 0): ?>
                                <?php
                                    $totalExperienceYears = $candidate->CandidatesExperience->sum('experience_years');
                                    $totalExperienceMonths = $candidate->CandidatesExperience->sum('experience_months');
                                    $additionalYears = intdiv($totalExperienceMonths, 12);
                                    $remainingMonths = $totalExperienceMonths % 12;
                                    $totalExperienceYears += $additionalYears;
                                ?>
                                <button type="button" class="btn btn-primary btn-circle btn-sm" onclick="showExperienceModal(<?php echo e($candidate->id); ?>)">
                                    <i class="fa fa-check-circle"></i> <?php echo e($totalExperienceYears); ?>.<?php echo e($remainingMonths); ?> Years
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-danger btn-circle btn-sm">
                                    <i class="fa fa-times-circle"></i> No Experience
                                </button>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php if($candidate->work_skills->count() > 0): ?>
                                <button type="button" class="btn btn-primary btn-sm btn-circle" onclick="showSkillsModal(<?php echo e($candidate->id); ?>)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            <?php else: ?>
                                <span class="text-muted">No skills</span>
                            <?php endif; ?>
                        </td>

                        <td><?php echo e(strtoupper($candidate->appliedPosition->position_name ?? '')); ?></td>
                        <td><?php echo e(strtoupper($candidate->religion ?? '')); ?></td>
                        <td><?php echo e(strtoupper($candidate->maritalStatus->status_name ?? '')); ?></td>
                        <td><?php echo e(strtoupper($candidate->number_of_children ?? '')); ?></td>
                        <td><?php echo e(strtoupper($candidate->educationLevel->level_name ?? '')); ?></td>
                        <td><?php echo e(strtoupper($candidate->phone_number ?? 'N/A')); ?></td>
                        <td><?php echo e(strtoupper($candidate->family_contact_number_1 ?? '')); ?></td>

                        <td>
                            <?php
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
                                    0 => $candidate->updated_at,
                                ];
                                $dateToShow = $statusDateMap[(int) $candidate->current_status] ?? $candidate->updated_at;
                            ?>
                            <div><?php echo e(strtoupper(\Carbon\Carbon::parse($dateToShow)->timezone('Asia/Dubai')->format('d-M-Y'))); ?></div>
                            <div><?php echo e(strtoupper(\Carbon\Carbon::parse($dateToShow)->timezone('Asia/Dubai')->format('h:i A'))); ?></div>
                        </td>

                        <td><?php echo e(\Carbon\Carbon::parse($candidate->passport_expiry_date)->format('d M Y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($candidate->date_of_birth)->format('d M Y')); ?></td>
                        <td><?php echo e(strtoupper($candidate->gender)); ?></td>
                        <td><?php echo e(strtoupper($candidate->english_skills)); ?></td>
                        <td><?php echo e(strtoupper($candidate->arabic_skills)); ?></td>
                        <td><?php echo e(strtoupper($candidate->height)); ?> CM</td>
                        <td><?php echo e(strtoupper($candidate->weight)); ?> KG</td>
                        <td><?php echo e(strtoupper($candidate->preferred_package)); ?></td>
                        <td>-</td>
                        <td><?php echo e(strtoupper($candidate->coc_status)); ?></td>
                        <td><?php echo e($candidate->place_of_birth ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->place_of_birth))) : 'N/A'); ?></td>
                        <td><?php echo e($candidate->candidate_current_address ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->candidate_current_address))) : 'N/A'); ?></td>
                        <td><?php echo e(strtoupper($candidate->labour_id_date)); ?></td>
                        <td><?php echo e(strtoupper($candidate->labour_id_number)); ?></td>
                        <td><?php echo e($candidate->family_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->family_name))) : 'N/A'); ?></td>
                        <td><?php echo e(strtoupper($candidate->family_contact_number_1)); ?></td>
                        <td><?php echo e(strtoupper($candidate->family_contact_number_2)); ?></td>
                        <td><?php echo e(strtoupper($candidate->relationship_with_candidate)); ?></td>
                        <td><?php echo e($candidate->family_current_address ? strtoupper(\Illuminate\Support\Str::title(strtolower($candidate->family_current_address))) : 'N/A'); ?></td>
                        <td class="actions">
                            <a href="<?php echo e(route('candidates.showCV', ['candidate' => $candidate->reference_no])); ?>" target="_blank" class="btn btn-info btn-icon-only ms-1" title="View CV">
                                <i class="fas fa-file-alt"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-success btn-icon-only ms-1" title="View Video" data-bs-toggle="modal" data-bs-target="#videoModal-<?php echo e($candidate->reference_no); ?>">
                                <i class="fas fa-video"></i>
                            </a>
                            <?php if(in_array((int) $candidate->current_status, [0, 1], true)): ?>
                                <button type="button" class="btn btn-<?php echo e((int) $candidate->current_status === 0 ? 'success' : 'warning'); ?> btn-icon-only ms-1 js-draft-toggle" data-url="<?php echo e(route('candidates.toggleDraft', ['candidateId' => $candidate->id])); ?>" data-current="<?php echo e((int) $candidate->current_status); ?>" title="<?php echo e((int) $candidate->current_status === 0 ? 'Un-Draft (Make Available)' : 'Draft (Make Hidden)'); ?>">
                                    <i class="fas <?php echo e((int) $candidate->current_status === 0 ? 'fa-folder-open' : 'fa-file'); ?>"></i>
                                </button>
                            <?php endif; ?>
                            <?php if($candidate->appeal == 1): ?>
                                <a href="javascript:void(0);" class="btn btn-warning btn-icon-only appeal-blink" title="Appeal Pending" data-bs-toggle="modal" data-bs-target="#appealModal-<?php echo e($candidate->reference_no); ?>">
                                    ⚠️
                                </a>
                            <?php endif; ?>
                            <?php if(in_array(Auth::user()->role, ['Sales Officer', 'Sales Coordinator']) && (int) $candidate->current_status == 5): ?>
                                <a href="javascript:void(0);" onclick="sendAlarm('<?php echo e($candidate->CN_Number); ?>')" class="btn btn-danger btn-icon-only" title="Send Alarm to CHC about this Candidate">
                                    <i class="fas fa-bell"></i>
                                </a>
                            <?php endif; ?>
                            <?php if(Auth::user()->role === 'Admin'): ?>
                                <form action="<?php echo e(route('candidates.destroy', $candidate->reference_no)); ?>" method="POST" style="display:inline;" id="delete-form-<?php echo e($candidate->reference_no); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="btn btn-danger btn-icon-only" onclick="confirmDelete('<?php echo e($candidate->reference_no); ?>')" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <div class="modal fade custom-modal" id="videoModal-<?php echo e($candidate->reference_no); ?>" tabindex="-1" aria-labelledby="videoModalLabel-<?php echo e($candidate->reference_no); ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title d-flex align-items-center" id="videoModalLabel-<?php echo e($candidate->reference_no); ?>">
                                        <i class="fas fa-video me-2" style="color: #fff;"></i> Video of <?php echo e($candidate->candidate_name); ?>

                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <?php
                                    $foreignPartner = strtolower(explode(' ', $candidate->foreign_partner)[0]);
                                    $baseUrl = 'https://' . $foreignPartner . '.onesourceerp.com/storage/app/public/';
                                    $videoFound = false;
                                    $videoUrl = null;
                                ?>

                                <?php $__currentLoopData = $candidate->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($attachment->attachment_type == 'Video'): ?>
                                        <?php
                                            $localVideoPath = 'storage/app/public/' . $attachment->attachment_file;
                                            $localVideoUrl = \Storage::exists($localVideoPath) ? url('storage/app/public/' . $attachment->attachment_file) : null;
                                            $remoteVideoUrl = $baseUrl . $attachment->attachment_file;
                                            $remoteHeaders = @get_headers($remoteVideoUrl);
                                            $remoteVideoExists = $remoteHeaders && isset($remoteHeaders[0]) && strpos($remoteHeaders[0], '200') !== false;
                                            $videoUrl = $localVideoUrl ?? ($attachment->attachment_file && $remoteVideoExists ? $remoteVideoUrl : null);
                                            $videoFound = $videoUrl !== null;
                                        ?>

                                        <?php if($videoFound): ?>
                                            <div class="modal-body text-center">
                                                <video id="videoPlayer-<?php echo e($candidate->reference_no); ?>" controls style="max-width: 100%; height: auto; border-radius: 8px;">
                                                    <source src="<?php echo e($videoUrl); ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>

                                            <div class="modal-footer">
                                                <button id="shareBtn-<?php echo e($candidate->reference_no); ?>" class="btn btn-success">
                                                    <i class="fas fa-share"></i> Share on WhatsApp
                                                </button>

                                                <script>
                                                    $('#shareBtn-<?php echo e($candidate->reference_no); ?>').on('click', function () {
                                                        var candidateId = $(this).attr('id').split('-')[1];
                                                        var videoUrl = $('#videoPlayer-' + candidateId + ' source').attr('src');
                                                        if (!videoUrl) return;
                                                        var whatsappUrl = 'https://wa.me/?text=' + encodeURIComponent('Check out this video: ' + videoUrl);
                                                        window.open(whatsappUrl, '_blank');
                                                    });
                                                </script>

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php if(!$videoFound): ?>
                                    <div class="modal-body text-center">
                                        <p>This candidate's video is not available.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>

        <tfoot>
            <tr>
                <th title="Serial #">Sr #</th>
                <th title="Agent Reference No">A . Ref #</th>
                <th title="Registration Date">Registration Date</th>
                <th title="Current Status">Current Status</th>
                <th title="Partners">Partners</th>
                <th title="Candidate Name">Candidate Name</th>
                <th title="Passport Number">Passport #</th>
                <th title="Labour ID Number">Labour ID #</th>
                <th title="Nationality">Nationality</th>
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
                <th title="Status Date">Status Date</th>
                <th title="Passport Expiry Date">Passport Exp</th>
                <th title="Date of Birth">DOB</th>
                <th title="Gender">Gender</th>
                <th title="English Skills">English Skills</th>
                <th title="Arabic Skills">Arabic Skills</th>
                <th title="Height">Height</th>
                <th title="Weight">Weight</th>
                <th title="Preferred Package">Preferred Package</th>
                <th title="Desired Country">Desired Country</th>
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
            Showing <?php echo e($candidates->firstItem()); ?> to <?php echo e($candidates->lastItem()); ?> of <?php echo e($candidates->total()); ?> results
        </span>
        <ul class="pagination justify-content-center">
            <?php echo e($candidates->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

        </ul>
    </div>
</nav>

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 2000;">
    <div id="draftToast" class="toast align-items-center text-bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="draftToastBody"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="modal fade" id="draftConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="draftConfirmText"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="draftConfirmBtn">Yes, Continue</button>
            </div>
        </div>
    </div>
</div>

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
    (function (w, $) {
        if (!$) return;

        w.OSERP = w.OSERP || {};
        w.OSERP.Candidates = w.OSERP.Candidates || {};

        var App = w.OSERP.Candidates;

        App.config = App.config || {};
        App.config.csrf = App.config.csrf || <?php echo json_encode(csrf_token(), 15, 512) ?>;
        App.config.cvRouteTemplate = App.config.cvRouteTemplate || <?php echo json_encode(route('candidates.showCV', ['candidate' => '___REF___']), 512) ?>;
        App.config.refreshDelayMs = App.config.refreshDelayMs || 2000;

        App.STATUS_META = App.STATUS_META || {
            0: { label: 'Draft', icon: 'fa-file', color: 'secondary' },
            1: { label: 'Available', icon: 'fa-user-check', color: 'success' }
        };

        App.toastMessage = function (message, opts) {
            opts = opts || {};
            $('#draftToastBody').text(message);

            var el = document.getElementById('draftToast');
            if (!el) return;

            bootstrap.Toast.getOrCreateInstance(el, { delay: opts.delay || 2500 }).show();

            if (opts.refresh === true) {
                setTimeout(function () {
                    w.location.reload();
                }, typeof opts.refreshDelayMs === 'number' ? opts.refreshDelayMs : App.config.refreshDelayMs);
            }
        };

        w.openDropdown = function (candidateId, buttonElement, candidateName) {
            $('.dropdown-container').hide();
            $('#fullscreenOverlay').fadeIn();
            var dropdownContainer = $('#dropdownContainer-' + candidateId);
            dropdownContainer.find('.candidate-name').text(candidateName);
            dropdownContainer.css({ display: 'block', opacity: 0 });
            dropdownContainer.animate({ opacity: 1 }, 300);
        };

        w.closeAllDropdowns = function () {
            $('.dropdown-container').fadeOut();
            $('#fullscreenOverlay').fadeOut();
        };

        w.showExperienceModal = function (candidateId) {
            var modalEl = document.getElementById('experienceModal');
            if (!modalEl) return;

            bootstrap.Modal.getOrCreateInstance(modalEl).show();
            $('#experienceModalBody').html('<p class="text-center">Loading...</p>');

            $.ajax({
                url: '/candidates/' + candidateId + '/experience',
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': App.config.csrf },
                success: function (data) {
                    if (data && data.experiences && data.experiences.length > 0) {
                        var table = '<table class="table table-bordered text-center"><thead><tr><th>Country</th><th>Years</th><th>Months</th></tr></thead><tbody>';
                        data.experiences.forEach(function (exp) {
                            table += '<tr><td class="text-center">' + exp.country + '</td><td class="text-center">' + exp.experience_years + '</td><td class="text-center">' + exp.experience_months + '</td></tr>';
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
        };

        w.showSkillsModal = function (candidateId) {
            var modalEl = document.getElementById('skillsModal');
            if (!modalEl) return;

            bootstrap.Modal.getOrCreateInstance(modalEl).show();
            $('#skillsModalBody').html('<p class="text-center">Loading...</p>');

            $.ajax({
                url: '/candidates/' + candidateId + '/skills',
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': App.config.csrf },
                success: function (data) {
                    if (data && data.skills && data.skills.length > 0) {
                        var list = '<ul class="list-group">';
                        data.skills.forEach(function (skill) {
                            list += '<li class="list-group-item"><i class="fa fa-circle me-2"></i>' + skill.skill_name + '</li>';
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
        };

        w.showCandidateModal = function (candidateName, candidateId, referenceNo) {
            var nameEl = document.getElementById('candidateName');
            if (nameEl) nameEl.textContent = candidateName;

            var attachBtn = document.getElementById('attachmentButton');
            if (attachBtn) attachBtn.setAttribute('onclick', "loadimages('" + candidateId + "')");

            var videoBtn = document.getElementById('videoButton');
            if (videoBtn) {
                videoBtn.setAttribute('data-bs-toggle', 'modal');
                videoBtn.setAttribute('data-bs-target', '#videoModal-' + referenceNo);
            }

            var cvBtn = document.getElementById('cvButton');
            if (cvBtn) {
                var cvUrl = String(App.config.cvRouteTemplate).replace('___REF___', encodeURIComponent(referenceNo));
                cvBtn.setAttribute('href', cvUrl);
            }

            var modalEl = document.getElementById('candidateModal');
            if (modalEl) bootstrap.Modal.getOrCreateInstance(modalEl).show();
        };

        App.applyDraftUI = function ($row, $btn, newStatus) {
            var meta = App.STATUS_META[newStatus] || { label: 'Unknown', icon: 'fa-question-circle', color: 'muted' };

            var $statusCell = $row.find('.js-status-cell');
            $statusCell.attr('data-status', newStatus);

            $statusCell.find('i.fas')
                .removeClass()
                .addClass('fas ' + meta.icon + ' text-' + meta.color);

            $statusCell.find('.js-status-label').text(meta.label);

            $btn.data('current', newStatus);
            $btn.attr('title', newStatus === 0 ? 'Un-Draft (Make Available)' : 'Draft (Make Hidden)');

            $btn.find('i.fas')
                .removeClass()
                .addClass('fas ' + (newStatus === 0 ? 'fa-folder-open' : 'fa-file'));
        };

        App.ensureInit = function () {
            if (App._inited) return;
            App._inited = true;

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': App.config.csrf } });

            App._pending = { btn: null, row: null, url: null, next: null };

            $(document).on('click', '.js-draft-toggle', function () {
                var $btn = $(this);
                var $row = $btn.closest('tr');
                var url = String($btn.data('url') || '').trim();
                var current = parseInt($btn.data('current'), 10);

                if (!url) {
                    App.toastMessage('Draft URL not found for this row.');
                    return;
                }

                var next = current === 0 ? 1 : 0;
                var actionText = next === 0
                    ? 'Do you want to set this candidate as Draft?'
                    : 'Do you want to Un-Draft and make this candidate Available?';

                App._pending = { btn: $btn, row: $row, url: url, next: next };
                $('#draftConfirmText').text(actionText);

                var confirmEl = document.getElementById('draftConfirmModal');
                if (confirmEl) bootstrap.Modal.getOrCreateInstance(confirmEl).show();
            });

            $(document).on('click', '#draftConfirmBtn', function () {
                var p = App._pending || {};
                var $btn = p.btn;
                var $row = p.row;
                var url = p.url;
                var next = p.next;

                if (!$btn || !$row || !url) return;

                $btn.prop('disabled', true);

                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: { current_status: next },
                    success: function (res) {
                        var status = parseInt(res && res.current_status, 10);
                        if (Number.isNaN(status)) status = next;

                        App.applyDraftUI($row, $btn, status);

                        var confirmEl = document.getElementById('draftConfirmModal');
                        if (confirmEl) bootstrap.Modal.getOrCreateInstance(confirmEl).hide();

                        App.toastMessage(
                            (res && res.message) || (status === 0 ? 'Candidate set to Draft successfully.' : 'Candidate is now Available successfully.'),
                            { refresh: true, refreshDelayMs: App.config.refreshDelayMs, delay: 2000 }
                        );
                    },
                    error: function (xhr) {
                        var confirmEl = document.getElementById('draftConfirmModal');
                        if (confirmEl) bootstrap.Modal.getOrCreateInstance(confirmEl).hide();

                        var msg = (xhr && xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to update draft status. Please try again.';
                        App.toastMessage(msg);
                    },
                    complete: function () {
                        $btn.prop('disabled', false);
                        App._pending = { btn: null, row: null, url: null, next: null };
                    }
                });
            });

            $(document).on('hidden.bs.modal', '#draftConfirmModal', function () {
                App._pending = { btn: null, row: null, url: null, next: null };
            });
        };

        App.ensureInit();
    })(window, window.jQuery);
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/candidates/partials/candidates_table.blade.php ENDPATH**/ ?>