<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">
          <i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="mb-0">Are you sure you want to delete this ledger account?</p>
        <p class="text-muted mb-0"><small>This action cannot be undone.</small></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cancel
        </button>
        <button type="button" class="btn btn-danger" id="confirm_delete_btn">
          <i class="fas fa-trash"></i> Delete
        </button>
      </div>
    </div>
  </div>
</div>
