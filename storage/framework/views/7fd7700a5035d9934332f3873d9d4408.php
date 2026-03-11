<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<style>
  .dataTables_info{font-size: 12px;}
  .dataTables_paginate{font-size: 12px;}
</style>
<main id="main" class="main">
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title">Services</h5>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="fas fa-plus-circle"></i> Add Service
          </button>
        </div>
        <div class="table-responsive">
          <table id="services-table" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Name (AR)</th>
                <th>Govt</th>
                <th>Center</th>
                <th>Total</th>
                <th>Created</th>
                <th>Updated</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($s->id); ?></td>
                  <td><?php echo e($s->service_name); ?></td>
                  <td><?php echo e($s->service_name_arabic); ?></td>
                  <td><?php echo e($s->govt_fee); ?></td>
                  <td><?php echo e($s->center_fee); ?></td>
                  <td><?php echo e($s->grand_total); ?></td>
                  <td><?php echo e($s->created_at->format('Y-m-d')); ?></td>
                  <td><?php echo e($s->updated_at->format('Y-m-d')); ?></td>
                  <td class="text-center">
                    <button
                      class="btn btn-info btn-sm edit-btn"
                      data-bs-toggle="modal"
                      data-bs-target="#addServiceModal"
                      data-id="<?php echo e($s->id); ?>"
                      data-name="<?php echo e($s->service_name); ?>"
                      data-name-ar="<?php echo e($s->service_name_arabic); ?>"
                      data-govt="<?php echo e($s->govt_fee); ?>"
                      data-center="<?php echo e($s->center_fee); ?>"
                    >
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo e($s->id); ?>">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="serviceForm">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="_method" id="method_field" value="POST">
      <input type="hidden" name="id" id="service_id">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">
            <i class="fas fa-plus-circle"></i>
            <span id="modalTitle">Add Service</span>
          </h5>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="row gx-3">
            <div class="col-6 mb-3">
              <label for="service_name" class="form-label">Service Name *</label>
              <input type="text" id="service_name" name="service_name" class="form-control" required>
            </div>
            <div class="col-6 mb-3">
              <label for="service_name_arabic" class="form-label">Service Name (Arabic) *</label>
              <input type="text" id="service_name_arabic" name="service_name_arabic" class="form-control" required>
            </div>
            <div class="col-6 mb-3">
              <label for="govt_fee" class="form-label">Govt Fee *</label>
              <input type="number" step="0.01" id="govt_fee" name="govt_fee" class="form-control" value="0.00" required>
            </div>
            <div class="col-6 mb-3">
              <label for="center_fee" class="form-label">Center Fee *</label>
              <input type="number" step="0.01" id="center_fee" name="center_fee" class="form-control" value="0.00" required>
            </div>
            <div class="col-6 mb-3">
              <label for="grand_total" class="form-label">Grand Total</label>
              <input type="number" step="0.01" id="grand_total" name="grand_total" class="form-control" value="0.00" readonly>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
            <i class="fas fa-times-circle"></i>
          </button>
          <button type="submit" class="btn btn-success btn-sm">
            <i class="fas fa-save"></i>
            <span id="saveBtnText">Save</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  const storeUrl          = "<?php echo e(route('services.store')); ?>";
  const updateUrlTemplate = "<?php echo e(route('services.update', ':id')); ?>";

  $(function(){
    $('#services-table').DataTable();

    function calcTotal(){
      const g = parseFloat($('#govt_fee').val()) || 0;
      const c = parseFloat($('#center_fee').val()) || 0;
      $('#grand_total').val((g + c).toFixed(2));
    }

    $('#addServiceModal').on('show.bs.modal', function(e){
      const btn = $(e.relatedTarget);
      if (btn.hasClass('edit-btn')) {
        const id     = btn.data('id');
        const name   = btn.data('name');
        const nameAr = btn.data('nameAr');
        const govt   = btn.data('govt');
        const center = btn.data('center');

        $('#serviceForm').attr('action', updateUrlTemplate.replace(':id', id));
        $('#method_field').val('PUT');
        $('#modalTitle').text('Edit Service');
        $('#saveBtnText').text('Update');

        $('#service_id').val(id);
        $('#service_name').val(name);
        $('#service_name_arabic').val(nameAr);
        $('#govt_fee').val(govt);
        $('#center_fee').val(center);
        calcTotal();
      } else {
        $('#serviceForm')
          .attr('action', storeUrl)
          .trigger('reset');
        $('#method_field').val('POST');
        $('#modalTitle').text('Add Service');
        $('#saveBtnText').text('Save');
        $('#grand_total').val('0.00');
      }
    });

    $('#govt_fee, #center_fee').on('input', calcTotal);

    $('#serviceForm').submit(function(e){
      e.preventDefault();
      $.ajax({
        url:    $(this).attr('action'),
        type:   'POST',
        data:   $(this).serialize(),
        success: () => location.reload(),
        error(xhr) {
          if (xhr.responseJSON && xhr.responseJSON.errors) {
            alert(Object.values(xhr.responseJSON.errors).flat().join("\n"));
          } else {
            alert(xhr.responseText || 'An unexpected error occurred');
          }
        }
      });
    });

    $(document).on('click', '.delete-btn', function(){
      if (!confirm('Delete this service?')) return;
      const id = $(this).data('id');
      $.ajax({
        url:  updateUrlTemplate.replace(':id', id),
        type: 'POST',
        data: { _method: 'DELETE' },
        success: () => location.reload(),
        error() {
          alert('Could not delete. Please try again.');
        }
      });
    });
  });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/services/index.blade.php ENDPATH**/ ?>