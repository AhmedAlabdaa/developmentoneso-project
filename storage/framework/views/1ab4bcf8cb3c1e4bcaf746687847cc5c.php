<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>SR</th>
                <th>Incident ID</th>
                <th>Incident Category</th>
                <th>Candidate Name</th>
                <th>Employer Name</th>
                <th>Incident Reason</th>
                <th>Nationality</th>
                <th>Date of Incident</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $incidents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td>INC-0000<?php echo e($incident->id); ?></td>
                    <td><?php echo e($incident->incident_category); ?></td>
                    <td>
                        <a href="">
                            <?php echo e($incident->candidate_name); ?>

                        </a>
                    </td>
                    <td><?php echo e($incident->employer_name ?: 'NA'); ?></td>
                    <td><?php echo e($incident->incident_reason); ?></td>
                    <td><?php echo e($incident->nationality); ?></td>
                    <td><?php echo e($incident->created_at->format('d-m-Y')); ?></td>
                    <td>
                        <button class="btn btn-info btn-icon-only view-details-btn" 
                                data-id="<?php echo e($incident->id); ?>" 
                                title="View Details" 
                                data-bs-toggle="modal" 
                                data-bs-target="#viewIncidentModal">
                            <i class="fas fa-eye"></i> View Detail
                        </button>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="viewIncidentModal" tabindex="-1" aria-labelledby="viewIncidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to right, #007bff, #00c6ff); color: white;">
                <h5 class="modal-title" id="viewIncidentModalLabel">Incident Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="incidentModalBody">
                <p>Loading...</p>
            </div>
        </div>
    </div>
</div>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing <?php echo e($incidents->firstItem()); ?> to <?php echo e($incidents->lastItem()); ?> of <?php echo e($incidents->total()); ?> results
        </span>
        <ul class="pagination justify-content-center">
            <?php echo e($incidents->links('vendor.pagination.bootstrap-4')); ?>

        </ul>
    </div>
</nav>
<script>
    $(document).ready(function () {
        $('.view-details-btn').on('click', function () {
            const incidentId = $(this).data('id');
            const modalBody = $('#incidentModalBody');
            modalBody.html('<p>Loading...</p>');

            $.ajax({
                url: `/incidents/${incidentId}`,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    const html = `
                        <table class="table table-bordered">
                            <thead style="background-color: #007bff; color: white;">
                                <tr>
                                    <th>Field</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Incident Category</td><td>${data.incident_category || 'N/A'}</td></tr>
                                <tr><td>Candidate ID</td><td>${data.candidate_id || 'N/A'}</td></tr>
                                <tr><td>Candidate Name</td><td>${data.candidate_name || 'N/A'}</td></tr>
                                <tr><td>Employer Name</td><td>${data.employer_name || 'N/A'}</td></tr>
                                <tr><td>Reference No</td><td>${data.reference_no || 'N/A'}</td></tr>
                                <tr><td>Ref No</td><td>${data.ref_no || 'N/A'}</td></tr>
                                <tr><td>Country</td><td>${data.country || 'N/A'}</td></tr>
                                <tr><td>Company</td><td>${data.company || 'N/A'}</td></tr>
                                <tr><td>Branch</td><td>${data.branch || 'N/A'}</td></tr>
                                <tr><td>Nationality</td><td>${data.nationality || 'N/A'}</td></tr>
                                <tr><td>Incident Reason</td><td>${data.incident_reason || 'N/A'}</td></tr>
                                <tr><td>Incident Expiry Date</td><td>${data.incident_expiry_date || 'N/A'}</td></tr>
                                <tr><td>Other Reason</td><td>${data.other_reason || 'N/A'}</td></tr>
                                <tr>
                                    <td>Proof</td>
                                    <td>
                                        ${data.proof ? `
                                            <img src="/storage/${data.proof}" class="img-fluid mb-2" style="width: 200px;">
                                            <div>
                                                <a href="/storage/${data.proof}" download class="btn btn-primary btn-sm">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </div>
                                        ` : 'N/A'}
                                    </td>
                                </tr>
                                <tr><td>Note</td><td>${data.note || 'N/A'}</td></tr>
                                <tr><td>Created By</td><td>${data.created_by || 'N/A'}</td></tr>
                            </tbody>
                        </table>
                    `;
                    modalBody.html(html);
                },
                error: function () {
                    modalBody.html('<p class="text-danger">Error loading data. Please try again later.</p>');
                }
            });
        });
    });
</script>

<?php /**PATH /var/www/developmentoneso-project/resources/views/incidents/partials/incidents_table.blade.php ENDPATH**/ ?>