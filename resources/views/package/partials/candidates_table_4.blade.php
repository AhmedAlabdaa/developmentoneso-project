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
</style>
<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th title="Candidate Number">CN Number</th>
                <th title="Sales Name">Sales Name</th>
                <th title="Candidate Name">Candidate Name</th>
                <th title="Foreign Partner">Foreign Partner</th>
                <th title="Current Status">Current Status</th>
                <th title="Passport Number">Passport Number</th>
                <th title="Passport Expiry Date">Passport Expiry Date</th>
                <th title="Date of Birth">Date of Birth</th>
                <th title="Branch in UAE">Branch (UAE)</th>
                <th title="Visa Type">Visa Type</th>
                <th title="Client Number">CL Number</th>
                <th title="Sponsor Name">Sponsor Name</th>
                <th title="EID Number">EID Number</th>
                <th title="Nationality">Nationality</th>
                <th title="Client Nationality">Client Nationality</th>
                <th title="WC Date">WC Date</th>
                <th title="DW Number">DW Number</th>
                <th title="Visa Date">Visa Date</th>
                <th title="Incident Type">Incident Type</th>
                <th title="Incident Date">Incident Date</th>
                <th title="Arrived Date">Arrived Date</th>
                <th title="Package">Package</th>
                <th title="Sales Communication Status">Sales Comm. Status</th>
                <th title="Missing Files">Missing Files</th>
                <th title="Remark">Remark</th>
                <th title="Created At">Created At</th>
                <th title="Updated At">Updated At</th>
                <th title="Action">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($candidates->isEmpty())
                <tr>
                    <td colspan="31" class="text-center">No results found.</td>
                </tr>
            @else
                @foreach ($candidates as $package)
                    <tr>
                        <td>{{ strtoupper($package->CN_Number) }}</td>
                        <td>{{ strtoupper($package->sales_name) }}</td>
                        <td>{{ strtoupper($package->candidate_name) }} <img src="{{ asset('assets/img/attach.png') }}" alt="Attachment Icon" style="cursor: pointer; margin-left: 8px; vertical-align: middle; height: 20px;" title="View Attachments of the Candidate" onclick="showCandidateModal('{{ $package->candidate_name }}', '{{ $package->id }}', '{{ $package->CN_Number }}')"/></td>
                        <td title="{{ strtoupper($package->foreign_partner) }}">
                            {{ strtoupper(\Illuminate\Support\Str::words($package->foreign_partner, 20, '...')) }}
                        </td>
                        <td>
                            @switch($package->current_status)
                                @case(4)
                                    <button class="btn btn-primary">
                                        <i class="fas fa-user-check"></i> Selected
                                    </button>
                                    @break
                                @case(5)
                                    <button class="btn btn-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Incident Before Visa (IBV)
                                    </button>
                                    @break
                                @case(6)
                                    <button class="btn btn-success">
                                        <i class="fas fa-passport"></i> Visa Date
                                    </button>
                                    @break
                                @case(7)
                                    <button class="btn btn-danger">
                                        <i class="fas fa-exclamation-circle"></i> Incident After Visa (IAV)
                                    </button>
                                    @break
                                @case(8)
                                    <button class="btn btn-info">
                                        <i class="fas fa-calendar-alt"></i> WC-Date
                                    </button>
                                    @break
                                @case(13)
                                    <button class="btn btn-secondary">
                                        <i class="fas fa-plane-departure"></i> Departure Date
                                    </button>
                                    @break
                                @case(14)
                                    <button class="btn btn-danger">
                                        <i class="fas fa-exclamation-circle"></i> Incident After Departure (IAD)
                                    </button>
                                    @break
                                @case(15)
                                    <button class="btn btn-success">
                                        <i class="fas fa-plane-arrival"></i> Arrived Date
                                    </button>
                                    @break
                                @case(16)
                                    <button class="btn btn-info">
                                        <i class="fas fa-exclamation-circle"></i> Incident After Arrival (IAA)
                                    </button>
                                    @break
                                @case(17)
                                    <button class="btn btn-dark">
                                        <i class="fas fa-exchange-alt"></i> Transfer Date
                                    </button>
                                    @break
                                @default
                                    <button class="btn btn-light">
                                        <i class="fas fa-question-circle"></i> Unknown Status
                                    </button>
                            @endswitch
                        </td>
                        <td>{{ strtoupper($package->passport_no) }}</td>
                        <td>{{ \Carbon\Carbon::parse($package->passport_expiry_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($package->date_of_birth)->format('d M Y') }}</td>
                        <td>{{ strtoupper($package->branch_in_uae) }}</td>
                        <td>{{ strtoupper($package->visa_type) }}</td>
                        <td>{{ strtoupper($package->CL_Number) }}</td>
                        <td>{{ strtoupper($package->sponsor_name) }}</td>
                        <td>{{ strtoupper($package->eid_no) }}</td>
                        <td>{{ strtoupper($package->nationality) }}</td>
                        <td>{{ strtoupper($package->CL_nationality) }}</td>
                        <td>{{ \Carbon\Carbon::parse($package->wc_date)->format('d M Y') }}</td>
                        <td>{{ strtoupper($package->dw_number) }}</td>
                        <td>{{ \Carbon\Carbon::parse($package->visa_date)->format('d M Y') }}</td>
                        <td>{{ strtoupper($package->incident_type) }}</td>
                        <td>{{ \Carbon\Carbon::parse($package->incident_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($package->arrived_date)->format('d M Y') }}</td>
                        <td>{{ strtoupper($package->package) }}</td>
                        <td>{{ strtoupper($package->sales_comm_status) }}</td>
                        <td>{{ strtoupper($package->missing_file) }}</td>
                        <td>{{ $package->remark }}</td>
                        <td>{{ \Carbon\Carbon::parse($package->created_at)->format('d M Y H:i:s') }}</td>
                        <td>{{ \Carbon\Carbon::parse($package->updated_at)->format('d M Y H:i:s') }}</td>
                        <td>
                          <a href="{{ route('package.show', $package->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="{{ route('package.edit', $package->id) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-edit"></i>
                          </a>
                          @if(auth()->user()->role == 'Admin')
                            <form action="{{ route('package.destroy', $package->id) }}" method="POST" style="display:inline-block;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this package?')">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>
                          @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th title="Candidate Number">CN Number</th>
                <th title="Sales Name">Sales Name</th>
                <th title="Candidate Name">Candidate Name</th>
                <th title="Foreign Partner">Foreign Partner</th>
                <th title="Current Status">Current Status</th>
                <th title="Passport Number">Passport Number</th>
                <th title="Passport Expiry Date">Passport Expiry Date</th>
                <th title="Date of Birth">Date of Birth</th>
                <th title="Branch in UAE">Branch (UAE)</th>
                <th title="Visa Type">Visa Type</th>
                <th title="Client Number">CL Number</th>
                <th title="Sponsor Name">Sponsor Name</th>
                <th title="EID Number">EID Number</th>
                <th title="Nationality">Nationality</th>
                <th title="Client Nationality">Client Nationality</th>
                <th title="WC Date">WC Date</th>
                <th title="DW Number">DW Number</th>
                <th title="Visa Date">Visa Date</th>
                <th title="Incident Type">Incident Type</th>
                <th title="Incident Date">Incident Date</th>
                <th title="Arrived Date">Arrived Date</th>
                <th title="Package">Package</th>
                <th title="Sales Communication Status">Sales Comm. Status</th>
                <th title="Missing Files">Missing Files</th>
                <th title="Remark">Remark</th>
                <th title="Created At">Created At</th>
                <th title="Updated At">Updated At</th>
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

</script>
