<!-- Create/Edit Modal -->
<div class="modal fade" id="ledgerModal" tabindex="-1" aria-labelledby="ledgerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ledgerModalLabel">Add Ledger Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ledger_form">
          <input type="hidden" id="ledger_id" name="id">
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="name" class="form-label">Account Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="name" name="name" required>
              <div class="invalid-feedback" id="name_error"></div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="class" class="form-label">Class <span class="text-danger">*</span></label>
              <select class="form-select" id="class" name="class" required>
                <option value="">Select Class</option>
                <option value="1">Asset</option>
                <option value="2">Liability</option>
                <option value="3">Equity</option>
                <option value="4">Income</option>
                <option value="5">Expense</option>
              </select>
              <div class="invalid-feedback" id="class_error"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="sub_class" class="form-label">Sub Class <span class="text-danger">*</span></label>
              <select class="form-select" id="sub_class" name="sub_class" required>
                <option value="">Select Sub Class</option>
                <option value="1">Current Asset</option>
                <option value="2">Non Current Asset</option>
                <option value="3">Current Liability</option>
                <option value="4">Non Current Liability</option>
                <option value="5">Equity</option>
                <option value="6">Income</option>
                <option value="7">Expense</option>
                <option value="8">Cost of Sales (COGS)</option>
              </select>
              <div class="invalid-feedback" id="sub_class_error"></div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="group" class="form-label">Group</label>
              <input type="text" class="form-control" id="group" name="group">
              <div class="invalid-feedback" id="group_error"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
              <select class="form-select" id="type" name="type" required>
                <option value="">Select Type</option>
                <option value="dr">Debit (Dr)</option>
                <option value="cr">Credit (Cr)</option>
              </select>
              <div class="invalid-feedback" id="type_error"></div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="spacial" class="form-label">Special <span class="text-danger">*</span></label>
              <select class="form-select" id="spacial" name="spacial" required>
                @foreach(\App\Enum\Spacial::cases() as $spacial)
                    <option value="{{ $spacial->value }}">{{ $spacial->label() }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="spacial_error"></div>
            </div>
          </div>

          <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
            <div class="invalid-feedback" id="note_error"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="save_ledger_btn">
          <i class="fas fa-save"></i> Save
        </button>
      </div>
    </div>
  </div>
</div>
