<style>
  .table-container { width:100%; overflow-x:auto; }
  .table { width:100%; border-collapse:collapse; margin-bottom:20px; }
  .table th, .table td { padding:10px 15px; text-align:left; border-bottom:1px solid #ddd; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
  .table th { background:#343a40; color:#fff; text-transform:uppercase; font-weight:600; }
  .table-hover tbody tr:hover { background:#f1f1f1; }
  .table-striped tbody tr:nth-of-type(odd) { background:#f9f9f9; }
  .btn-icon-only { display:inline-flex; align-items:center; justify-content:center; padding:5px; border-radius:50%; font-size:12px; width:30px; height:30px; color:#fff; }
  .btn-primary { background:#007bff; }
  .btn-warning { background:#ffc107; }
  .pagination-controls { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
  .modal-header.report-modal { background:linear-gradient(90deg,#6a11cb,#2575fc); color:#fff; }
  .modal-header.report-modal .custom-close { background:#ff5c5c; border:none; width:30px; height:30px; border-radius:50%; color:#fff; font-size:16px; line-height:1; }
  .incident-details-table { width:100%; border-collapse:collapse; margin-bottom:20px; }
  .incident-details-table th { background:#2c2f33; color:#fff; padding:12px; width:35%; text-align:left; }
  .incident-details-table td { background:#fff; padding:12px; }
  .form-row { display:flex; gap:15px; margin-bottom:15px; }
  .form-group { flex:1; display:flex; flex-direction:column; }
  .form-group label { margin-bottom:5px; font-weight:600; }
</style>

<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Ref #</th>
        <th>Incident Date</th>
        <th>Name</th>
        <th>Passport #</th>
        <th>Nationality</th>
        <th>Incident Type</th>
        <th>Package</th>
        <th>Visa Stage</th>
        <th>Foreign Partner</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td><a href="<?php echo e(route('employees.show', $emp->reference_no)); ?>"><?php echo e($emp->reference_no); ?></a></td>
          <td><?php echo e($emp->incident_date ? \Carbon\Carbon::parse($emp->incident_date)->format('d M Y') : 'N/A'); ?></td>
          <td><a href="<?php echo e(route('employees.show', $emp->reference_no)); ?>"><?php echo e($emp->name); ?></a></td>
          <td><?php echo e($emp->passport_no); ?></td>
          <td><?php echo e($emp->nationality); ?></td>
          <td><?php echo e($emp->incident_type); ?></td>
          <td><?php echo e($emp->package); ?></td>
          <td><?php echo e($emp->visa_status); ?></td>
          <td><?php echo e($emp->foreign_partner); ?></td>
          <td>
            <button type="button"
                    class="btn btn-primary btn-sm btn-update-incident"
                    data-ref="<?php echo e($emp->reference_no); ?>"
                    data-name="<?php echo e($emp->name); ?>"
                    data-passport="<?php echo e($emp->passport_no); ?>"
                    data-date="<?php echo e($emp->incident_date); ?>"
                    data-type="<?php echo e($emp->incident_type); ?>"
                    data-comments="<?php echo e($emp->comments ?? ''); ?>">
              <i class="fas fa-edit"></i> Update
            </button>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="10" class="text-center">No incidents found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<nav class="pagination-controls">
  <span>Showing <?php echo e($employees->firstItem()); ?> to <?php echo e($employees->lastItem()); ?> of <?php echo e($employees->total()); ?> results</span>
  <ul class="pagination mb-0">
    <?php echo e($employees->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4')); ?>

  </ul>
</nav>

<div class="modal fade" id="updateIncidentModal" tabindex="-1" aria-labelledby="updateIncidentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header report-modal">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        <h5 id="updateIncidentModalLabel" class="modal-title">Update Incident</h5>
        <button type="button" class="custom-close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">
        <table class="incident-details-table">
          <tr>
            <th>REFERENCE NO</th>
            <td id="uiReference"></td>
          </tr>
          <tr>
            <th>CANDIDATE NAME</th>
            <td id="uiName"></td>
          </tr>
          <tr>
            <th>PASSPORT NO</th>
            <td id="uiPassport"></td>
          </tr>
        </table>
        <form id="updateIncidentForm">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="reference_no" id="inputUIRef">
          <div class="form-row">
            <div class="form-group">
              <label for="inputUIDate">Incident Date *</label>
              <input type="date" id="inputUIDate" name="incident_date" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="inputUIType">Incident Type *</label>
              <select id="inputUIType" name="incident_type" class="form-control" required>
                <option value="">Select Type</option>
                <option value="RUNAWAY">RUNAWAY</option>
                <option value="REPATRIATION">REPATRIATION</option>
                <option value="UNFIT">UNFIT</option>
                <option value="SICK">SICK</option>
                <option value="REFUSED">REFUSED</option>
                <option value="PSYCHIATRIC">PSYCHIATRIC</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group" style="flex:1;">
              <label for="inputUIComments">Comments</label>
              <textarea id="inputUIComments" name="comments" class="form-control" rows="3" required></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
        <button type="button" id="saveUpdateIncident" class="btn btn-primary">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).on('click', '.btn-update-incident', function() {
    var b = $(this);
    $('#uiReference').text(b.data('ref'));
    $('#uiName').text(b.data('name'));
    $('#uiPassport').text(b.data('passport'));
    $('#inputUIRef').val(b.data('ref'));
    $('#inputUIDate').val(b.data('date'));
    $('#inputUIType').val(b.data('type'));
    $('#inputUIComments').val(b.data('comments'));
    $('#updateIncidentModal').modal('show');
  });

  $('#saveUpdateIncident').on('click', function() {
    $.post('<?php echo e(route("employees.incidentSave")); ?>', $('#updateIncidentForm').serialize(), function() {
      toastr.success('Incident updated successfully');
      $('#updateIncidentModal').modal('hide');
      location.reload();
    }).fail(function(e) {
      toastr.error(e.responseJSON?.message || 'Error updating incident');
    });
  });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/employee/partials/incident_table.blade.php ENDPATH**/ ?>