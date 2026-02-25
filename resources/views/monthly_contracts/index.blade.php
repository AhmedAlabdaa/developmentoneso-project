@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<style>
body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
.table th,.table td{vertical-align:middle;font-size:13px}
.nav-tabs .nav-link{color:#495057;transition:background .2s}
.nav-tabs .nav-link:hover{background:#f8f9fa}
.nav-tabs .nav-link.active{background:#007bff;color:#fff}
.table thead th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:400;white-space:nowrap}
.pagination-container{display:flex;justify-content:space-between;align-items:center;padding:.5rem 0}
.pagination{display:flex;justify-content:center;align-items:center;margin:0}
.pagination .page-item{margin:0 .1rem}
.pagination .page-link{border-radius:.25rem;padding:.4rem .7rem;color:#007bff;background:#fff;border:1px solid #007bff;transition:background .2s,color .2s;font-size:12px}
.pagination .page-link:hover{background:#007bff;color:#fff}
.pagination .page-item.active .page-link{background:#007bff;color:#fff;border:1px solid #007bff}
.pagination .page-item.disabled .page-link{color:#6c757d;background:#fff;border:1px solid #6c757d;cursor:not-allowed}
.input-clear{position:relative}
.input-clear .fa-times-circle{position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;color:#6c757d;display:none}
.btn-create{background:linear-gradient(45deg,#007bff,#00c6ff);color:#fff;font-size:.8rem;padding:.3rem .6rem;border-radius:.25rem;border:none}
.btn-create:hover{background:linear-gradient(45deg,#0056b3,#00a0e0);color:#fff}
.filter-dropdown{background:#fff;padding:15px;border-radius:5px;box-shadow:0 2px 10px rgba(0,0,0,.1);min-width:400px}
#preloader{position:fixed;inset:0;background:rgba(255,255,255,.75);display:flex;flex-direction:column;justify-content:center;align-items:center;z-index:1050}
#preloader .spinner{width:54px;height:54px;border:6px solid rgba(0,0,0,.1);border-top-color:#007bff;border-radius:50%;animation:spin 1s linear infinite}
#preloader .text{margin-top:10px;color:#007bff;font-weight:700}
@keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
.badge-pending{background:#ffc107;color:#333}
.badge-invoiced{background:#28a745;color:#fff}
.status-0{background:#ffc107;color:#333;padding:2px 8px;border-radius:4px;font-size:11px}
.status-1{background:#28a745;color:#fff;padding:2px 8px;border-radius:4px;font-size:11px}
.installment-row{background:#f8f9fa;border:1px solid #dee2e6;border-radius:6px;padding:8px;margin-bottom:6px}
.select2-container{z-index:1060;width:100%!important}
.select2-container--open{z-index:1065}
.modal .select2-container{width:100%!important}
.action-btn{font-size:11px;padding:2px 6px;margin:1px}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card flex-fill">
      <div class="card-body mt-2">

        {{-- Toolbar --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
          <ul class="nav nav-tabs" id="mainTabs">
            <li class="nav-item"><a class="nav-link active" id="contracts-tab" data-bs-toggle="tab" href="#tab-contracts"><i class="fas fa-file-contract me-1"></i>Primary Contracts</a></li>
            <li class="nav-item"><a class="nav-link" id="movements-tab" data-bs-toggle="tab" href="#tab-movements"><i class="fas fa-exchange-alt me-1"></i>Movement Contracts</a></li>
            <li class="nav-item"><a class="nav-link" id="installments-tab" data-bs-toggle="tab" href="#tab-installments"><i class="fas fa-money-check-alt me-1"></i>Installments</a></li>
            <li class="nav-item"><a class="nav-link" id="invoices-tab" data-bs-toggle="tab" href="#tab-invoices"><i class="fas fa-file-invoice-dollar me-1"></i>P3 Invoices</a></li>
            <li class="nav-item"><a class="nav-link" id="returns-tab" data-bs-toggle="tab" href="#tab-returns"><i class="fas fa-undo-alt me-1"></i>Return Office</a></li>
            <li class="nav-item"><a class="nav-link" id="incidents-tab" data-bs-toggle="tab" href="#tab-incidents"><i class="fas fa-exclamation-triangle me-1"></i>Incidents</a></li>
            <li class="nav-item"><a class="nav-link" id="refund-requests-tab" data-bs-toggle="tab" href="#tab-refund-requests"><i class="fas fa-hand-holding-usd me-1"></i>Refund Requests</a></li>
            <li class="nav-item"><a class="nav-link" id="deductions-tab" data-bs-toggle="tab" href="#tab-deductions"><i class="fas fa-file-invoice me-1"></i>Deduct / Add</a></li>
            <li class="nav-item"><a class="nav-link" id="payroll-tab" data-bs-toggle="tab" href="#tab-payroll"><i class="fas fa-wallet me-1"></i>Maids Payroll</a></li>
          </ul>
        </div>

        {{-- Tab Content --}}
        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab-contracts">
            <div class="d-flex justify-content-between align-items-center bg-light rounded border p-3 mb-3 full-width">
              <h5 class="mb-0 fw-bold text-secondary"><i class="fas fa-file-contract me-2"></i>Primary Contracts Overview</h5>
              <button class="btn btn-create btn-sm" onclick="openCreateModal()"><i class="fas fa-plus me-1"></i>New Monthly Contract</button>
            </div>
            <div class="table-responsive" id="contracts_table"></div>
          </div>
          <div class="tab-pane fade" id="tab-movements"><div class="table-responsive" id="movements_table"></div></div>
          <div class="tab-pane fade" id="tab-installments"><div class="table-responsive" id="installments_table"></div></div>
          <div class="tab-pane fade" id="tab-invoices"><div class="table-responsive" id="invoices_table"></div></div>
          <div class="tab-pane fade" id="tab-returns"><div class="table-responsive" id="returns_table"></div></div>
          <div class="tab-pane fade" id="tab-incidents"><div class="table-responsive" id="incidents_table"></div></div>
          <div class="tab-pane fade" id="tab-refund-requests"><div class="table-responsive" id="refund_requests_table"></div></div>
          <div class="tab-pane fade" id="tab-deductions">
            <div class="d-flex justify-content-between align-items-center bg-light rounded border p-3 mb-3 full-width">
              <h5 class="mb-0 fw-bold text-secondary"><i class="fas fa-file-invoice me-2"></i>Deductions & Allowances</h5>
              <button class="btn btn-create btn-sm" onclick="openDeductionModal()"><i class="fas fa-plus me-1"></i>New Deduct / Add</button>
            </div>
            <div class="table-responsive" id="deductions_table"></div>
          </div>
          <div class="tab-pane fade" id="tab-payroll">
            <div class="d-flex justify-content-between align-items-center bg-light rounded border p-3 mb-3 full-width">
              <h5 class="mb-0 fw-bold text-secondary text-nowrap me-3"><i class="fas fa-wallet me-2"></i>Maids Payroll</h5>
              <div class="d-flex align-items-center gap-2 mb-0 flex-wrap justify-content-end">
                <label class="form-label mb-0 fw-bold">Year:</label>
                <input type="number" class="form-control form-control-sm" id="payroll_year" style="width:100px" min="2020" max="2099">
                <label class="form-label mb-0 fw-bold ms-1">Month:</label>
                <select class="form-select form-select-sm" id="payroll_month" style="width:130px">
                  <option value="1">January</option><option value="2">February</option><option value="3">March</option>
                  <option value="4">April</option><option value="5">May</option><option value="6">June</option>
                  <option value="7">July</option><option value="8">August</option><option value="9">September</option>
                  <option value="10">October</option><option value="11">November</option><option value="12">December</option>
                </select>
                <button class="btn btn-primary btn-sm ms-2" onclick="loadPayroll()"><i class="fas fa-search me-1"></i>Load</button>
              </div>
            </div>
            <div class="table-responsive" id="payroll_table"></div>
          </div>
        </div>

      </div>
    </div>
  </section>
</main>

{{-- Create / Edit Contract Modal --}}
<div class="modal fade" id="contractModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#007bff,#00c6ff);color:#fff">
        <h5 class="modal-title" id="contractModalTitle"><i class="fas fa-file-contract me-2"></i>New Monthly Contract</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit_contract_id">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-bold">Customer <span class="text-danger">*</span></label>
            <select id="form_customer" class="form-control"></select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Maid / Employee <span class="text-danger">*</span></label>
            <select id="form_maid" class="form-control"></select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="form_start_date">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">End Date</label>
            <input type="date" class="form-control" id="form_end_date">
          </div>

          {{-- Prorate Section --}}
          <div class="col-12"><hr><h6 class="text-muted"><i class="fas fa-calculator me-1"></i>Prorate (Optional)</h6></div>
          <div class="col-md-6">
            <label class="form-label">Monthly Rate (VAT incl.)</label>
            <input type="number" step="0.01" class="form-control" id="form_prorate_amount" placeholder="e.g. 3000">
          </div>
          <div class="col-md-6">
            <label class="form-label">Prorate Days</label>
            <input type="number" min="1" max="30" class="form-control" id="form_prorate_days" placeholder="1-30">
          </div>

          {{-- Installments Section --}}
          <div class="col-12"><hr><h6 class="text-muted"><i class="fas fa-list-ol me-1"></i>Installments</h6></div>
          <div class="col-12">
            <table class="table table-sm table-bordered" id="installmentTable">
              <thead style="background:#eef5ff">
                <tr>
                  <th style="width:30%">Date</th>
                  <th style="width:25%">Amount</th>
                  <th style="width:35%">Note</th>
                  <th style="width:10%"></th>
                </tr>
              </thead>
              <tbody id="installmentBody"></tbody>
            </table>
            <button type="button" class="btn btn-success btn-sm" onclick="addInstallmentRow()"><i class="fas fa-plus me-1"></i>Add Installment</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnSaveContract" onclick="saveContract()"><i class="fas fa-save me-1"></i>Save Contract</button>
      </div>
    </div>
  </div>
</div>

{{-- Edit Contract Modal --}}
<div class="modal fade" id="editContractModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#ffc107,#ff9800);color:#fff">
        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Contract</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit_only_contract_id">
        <div class="mb-3">
          <label class="form-label fw-bold">Start Date</label>
          <input type="date" class="form-control" id="edit_start_date">
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">End Date</label>
          <input type="date" class="form-control" id="edit_end_date">
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Note <small class="text-muted">(optional)</small></label>
          <textarea class="form-control" id="edit_contract_note" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnSubmitEditContract" onclick="submitEditContract()">Save Changes</button>
      </div>
    </div>
  </div>
</div>

{{-- View Contract Modal --}}
<div class="modal fade" id="viewContractModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#17a2b8,#20c997);color:#fff">
        <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Contract Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="viewContractBody">
        <div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- View Movement Modal --}}
<div class="modal fade" id="viewMovementModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#17a2b8,#20c997);color:#fff">
        <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Movement Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="viewMovementBody">
        <div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- Edit Movement Modal --}}
<div class="modal fade" id="editMovementModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#ffc107,#ff9800);color:#fff">
        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Movement</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit_movement_id">
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-bold">Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="edit_movement_date">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Maid</label>
            <input type="text" class="form-control" id="edit_movement_maid_name" readonly>
          </div>
          <div class="col-12">
            <label class="form-label fw-bold">Note <small class="text-muted">(optional)</small></label>
            <textarea class="form-control" id="edit_movement_note" rows="2"></textarea>
          </div>
        </div>
        
        <div class="card shadow-sm border-0 mt-3">
          <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-primary"><i class="fas fa-money-bill-wave me-1"></i>Installments</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addEditInstallmentRow()"><i class="fas fa-plus me-1"></i>Add</button>
          </div>
          <div class="card-body p-0">
            <table class="table table-bordered mb-0">
              <thead class="table-light">
                <tr>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Note</th>
                  <th style="width:50px"></th>
                </tr>
              </thead>
              <tbody id="editInstallmentBody">
                <!-- Rows injected via JS -->
              </tbody>
            </table>
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnSubmitEditMovement" onclick="submitEditMovement()"><i class="fas fa-save me-1"></i>Save Changes</button>
      </div>
    </div>
  </div>
</div>

{{-- Return Maid Modal --}}
<div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#6c757d,#adb5bd);color:#fff">
        <h5 class="modal-title"><i class="fas fa-undo-alt me-2"></i>Return Maid</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="return_contract_id">
        <div class="mb-3">
          <label class="form-label fw-bold">Return Date <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="return_date" disabled>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Note <small class="text-muted">(optional)</small></label>
          <textarea class="form-control" id="return_note" rows="3" placeholder="Reason for return..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnSubmitReturn" onclick="submitReturn()"><i class="fas fa-check me-1"></i>Submit Return</button>
      </div>
    </div>
  </div>
</div>

{{-- Incident Modal --}}
<div class="modal fade" id="incidentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Report Incident</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="incident_movement_id">
        <div class="mb-3">
          <label class="form-label fw-bold">Incident Date <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="incident_date" disabled>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
          <select class="form-select" id="incident_status" required>
            <option value="">Select Status...</option>
            <option value="2">Runaway</option>
            <option value="3">Cancelled</option>
            <option value="4">Hold</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Note <small class="text-muted">(optional)</small></label>
          <textarea class="form-control" id="incident_note" rows="3" placeholder="Additional details..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="btnSubmitIncident" onclick="submitIncident()"><i class="fas fa-check me-1"></i>Report Incident</button>
      </div>
    </div>
  </div>
</div>

{{-- Refund Modal --}}
<div class="modal fade" id="refundModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#28a745,#218838);color:#fff">
        <h5 class="modal-title"><i class="fas fa-hand-holding-usd me-2"></i>Issue Refund</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="refund_movement_id">
        
        <!-- Info Display Section -->
        <div id="refundInfoSection" class="p-3 mb-3 bg-light rounded border display-none" style="display:none;">
          <div class="row g-2 text-sm">
            <div class="col-6"><strong>Customer:</strong> <span id="lbl_refund_customer">-</span></div>
            <div class="col-6"><strong>Maid:</strong> <span id="lbl_refund_maid">-</span></div>
            <div class="col-6"><strong>Start Date:</strong> <span id="lbl_refund_start_date">-</span></div>
            <div class="col-6"><strong>Return Date:</strong> <span id="lbl_refund_return_date">-</span></div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Refund Date <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="refund_date" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Amount to refund <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text">AED</span>
            <input type="number" class="form-control" id="refund_amount" min="0" step="0.01" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Note <small class="text-muted">(optional)</small></label>
          <textarea class="form-control" id="refund_note" rows="3" placeholder="Reason for refund..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="btnSubmitRefund" onclick="submitRefund()"><i class="fas fa-check me-1"></i>Process Refund</button>
      </div>
    </div>
  </div>
</div>
{{-- Deduct / Add Bulk Modal --}}
<div class="modal fade" id="deductionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#007bff,#00ceff);color:#fff">
        <h5 class="modal-title"><i class="fas fa-file-invoice me-2"></i>New Deductions & Allowances</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-sm mt-3" id="deductionBulkTable">
            <thead class="table-light">
              <tr>
                <th style="width: 25%">Maid / Employee <span class="text-danger">*</span></th>
                <th style="width: 10%">Year <span class="text-danger">*</span></th>
                <th style="width: 10%">Month <span class="text-danger">*</span></th>
                <th style="width: 14%">Date</th>
                <th style="width: 13%">Deduct (Dr.)</th>
                <th style="width: 13%">Add (Cr.)</th>
                <th style="width: 10%">Note</th>
                <th style="width: 5%"></th>
              </tr>
            </thead>
            <tbody id="deductionBulkRows">
              <!-- Rows injected via JS -->
            </tbody>
          </table>
          <button type="button" class="btn btn-success btn-sm" onclick="addDeductionRow()"><i class="fas fa-plus me-1"></i>Add Row</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnSubmitDeduction" onclick="submitDeductionsBulk()">
          <i class="fas fa-save me-1"></i>Save Records
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Maid Breakdown Modal --}}
<div class="modal fade" id="viewMaidBreakdownModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header" style="background:linear-gradient(45deg,#17a2b8,#138496);color:#fff">
        <h5 class="modal-title fw-bold"><i class="fas fa-chart-pie me-2"></i>Maid Payroll Breakdown</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body bg-white" id="viewMaidBreakdownBody">
        <!-- Content injected via JS -->
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- Receive Payment Modal --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#28a745,#218838);color:#fff">
        <h5 class="modal-title"><i class="fas fa-hand-holding-usd me-2"></i>Receive Payment</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="payment_invoice_id">
        <div id="paymentInfoSection" class="p-3 mb-3 bg-light rounded border">
          <div class="row g-2 text-sm">
            <div class="col-12 border-bottom pb-1 mb-1"><strong>Invoice:</strong> <span id="lbl_payment_serial" class="text-primary font-monospace">-</span></div>
            <div class="col-6"><strong>Customer:</strong> <span id="lbl_payment_customer">-</span></div>
            <div class="col-6"><strong>Amount to Pay:</strong> <span id="lbl_payment_balance" class="fw-bold text-danger">-</span></div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Payment Amount (AED) <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="payment_amount" min="0.01" step="0.01" required>
        </div>
        
        <div class="mb-3">
          <label class="form-label fw-bold">Payment Mode <span class="text-danger">*</span></label>
          <select class="form-select" id="payment_mode" required>
            <option value="1">Cash</option>
            <option value="2">Bank</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Deposit To (Ledger) <span class="text-danger">*</span></label>
          <select class="form-select" id="payment_debit_ledger" required>
              <option value="">Loading ledgers...</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="btnSubmitPayment" onclick="submitPayment()"><i class="fas fa-check me-1"></i>Receive Payment</button>
      </div>
    </div>
  </div>
</div>

{{-- Issue Credit Note Modal --}}
<div class="modal fade" id="creditNoteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#dc3545,#c82333);color:#fff">
        <h5 class="modal-title"><i class="fas fa-undo-alt me-2"></i>Issue Credit Note</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="credit_invoice_id">
        <div class="p-3 mb-3 bg-light rounded border">
          <div class="row g-2 text-sm">
            <div class="col-12 border-bottom pb-1 mb-1"><strong>Invoice:</strong> <span id="lbl_credit_serial" class="text-primary font-monospace">-</span></div>
             <div class="col-12"><strong>Customer:</strong> <span id="lbl_credit_customer">-</span></div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Credit Type <span class="text-danger">*</span></label>
          <select class="form-select" id="credit_type" onchange="toggleCreditDays()" required>
            <option value="full">Full Credit (Reverse Entire Invoice)</option>
            <option value="partial">Partial Credit (Pro-rated)</option>
          </select>
        </div>
        
        <div class="mb-3" id="creditDaysContainer" style="display:none;">
          <label class="form-label fw-bold">Days to Retain (1-29) <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="credit_days" min="1" max="29">
          <small class="text-muted">How many days of service should you bill them for?</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="btnSubmitCredit" onclick="submitCreditNote()"><i class="fas fa-check me-1"></i>Issue Credit</button>
      </div>
    </div>
  </div>
</div>

{{-- View Return Modal --}}
<div class="modal fade" id="viewReturnModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#17a2b8,#20c997);color:#fff">
        <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Return Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="viewReturnBody">
        <div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- View Incident Modal --}}
<div class="modal fade" id="viewIncidentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(45deg,#dc3545,#f8d7da);color:#fff">
        <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Incident Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="viewIncidentBody">
        <div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- Replacement Modal --}}
<div class="modal fade" id="replacementModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">
      <div class="modal-header border-bottom-0 pb-0" style="background:linear-gradient(45deg,#fd7e14,#ffc107);color:#fff">
        <h5 class="modal-title fw-bold" id="replacementModalTitle"><i class="fas fa-people-arrows me-2"></i>Execute Replacement</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 bg-light">
        <input type="hidden" id="replacement_return_id">

        <div class="mb-3">
          <label class="form-label fw-bold">Replacement Date <span class="text-danger">*</span></label>
          <input type="date" class="form-control bg-light" id="replacement_date" required readonly disabled>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Maid / Employee <span class="text-danger">*</span></label>
          <select id="replacement_new_employee_id" class="form-select select2" required style="width: 100%;"></select>
        </div>
      </div>
      <div class="modal-footer border-top-0 pt-0 bg-light rounded-bottom-3 pb-3 px-4">
        <button type="button" class="btn btn-secondary px-4 fw-bold shadow-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-warning px-4 fw-bold shadow-sm text-dark" id="btnSubmitReplacement" onclick="submitReplacement()"><i class="fas fa-check-circle me-1"></i>Confirm Replacement</button>
      </div>
    </div>
  </div>
</div>

{{-- Create Invoice Modal --}}
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">
      <div class="modal-header border-bottom-0 pb-0" style="background:linear-gradient(45deg,#0d6efd,#0dcaf0);color:#fff">
        <h5 class="modal-title fw-bold"><i class="fas fa-file-invoice-dollar me-2"></i>Create Invoice</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 bg-light">
        <input type="hidden" id="invoice_installment_id">
        
        <div class="alert alert-info">
          <strong>Installment Overview</strong>
          <ul class="mb-0 mt-2 list-unstyled">
            <li><strong>Customer:</strong> <span id="lbl_invoice_customer"></span></li>
            <li><strong>Maid:</strong> <span id="lbl_invoice_maid"></span></li>
            <li><strong>Accrued Date:</strong> <span id="lbl_invoice_date"></span></li>
            <li><strong>Amount (inc VAT):</strong> <span id="lbl_invoice_amount" class="text-success fw-bold"></span> AED</li>
          </ul>
        </div>
        
        <p class="text-muted small mb-0">
          This will generate an invoice and post the necessary draft journal entries (Customer Debit, VAT Output, Maid Salary, and P3 Profit). 
        </p>
      </div>
      <div class="modal-footer border-top-0 pt-0 bg-light rounded-bottom-3 pb-3 px-4">
        <button type="button" class="btn btn-secondary px-4 fw-bold shadow-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary px-4 fw-bold shadow-sm" id="btnSubmitInvoice" onclick="submitInvoice()"><i class="fas fa-check-circle me-1"></i>Confirm Invoice</button>
      </div>
    </div>
  </div>
</div>

@include('layout.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
/* ========== GLOBALS ========== */
const API = '/api/am-monthly-contracts';
let currentTab = 'contracts';

/* ========== PRELOADER ========== */
function showPreloader(){
  if(!$('#preloader').length) $('body').append('<div id="preloader"><div class="spinner"></div><div class="text">Loading...</div></div>');
}
function hidePreloader(){ $('#preloader').remove(); }

/* ========== CONTRACTS TABLE ========== */
function loadContracts(page){
  page = page || 1;
  showPreloader();
  const search = $('#global_search').val() || '';
  $.getJSON(API, { page: page })
    .done(function(res){
      renderContractsTable(res);
    })
    .fail(function(){
      $('#contracts_table').html('<div class="p-3 text-center text-muted">Failed to load contracts.</div>');
    })
    .always(hidePreloader);
}

function renderContractsTable(res){
  const data = res.data || [];
  if(!data.length){
    $('#contracts_table').html('<div class="p-3 text-center text-muted">No contracts found.</div>');
    return;
  }
  let html = '<table class="table table-hover table-bordered mb-0"><thead><tr>';
  html += '<th>#</th><th>Date</th><th>Customer</th><th>Note</th><th>End Date</th><th>Status</th><th style="width:160px">Actions</th>';
  html += '</tr></thead><tbody>';

  data.forEach(function(c, i){
    const crm = c.crm || {};
    const customerName = (crm.first_name || '') + ' ' + (crm.last_name || '');
    const mov = (c.contract_movments && c.contract_movments[0]) || {};
    const emp = mov.employee || {};
    const instCount = (mov.installments || []).length;
    const statusClass = c.status == 1 ? 'status-1' : 'status-0';
    const statusText = c.status == 1 ? 'Active' : 'Inactive';
    const idx = ((res.current_page - 1) * res.per_page) + i + 1;

    html += '<tr>';
    html += '<td class="text-center">' + idx + '</td>';
    html += '<td>' + (c.date || '-') + '</td>';
    html += '<td>' + customerName.trim() + ' <small class="text-muted">' + (crm.CL_Number || '') + '</small></td>';
    html += '<td>' + (c.note || '-') + '</td>';
    html += '<td>' + (c.end_date || '-') + '</td>';
    html += '<td class="text-center"><span class="' + statusClass + '">' + statusText + '</span></td>';
    html += '<td class="text-center" style="white-space:nowrap">';
    html += '<button class="btn btn-outline-info action-btn" onclick="viewContract(' + c.id + ')" title="View"><i class="fas fa-eye"></i></button> ';
    html += '<button class="btn btn-outline-warning action-btn" onclick="editContract(' + c.id + ')" title="Edit"><i class="fas fa-edit"></i></button> ';
    html += '<button class="btn btn-outline-danger action-btn" onclick="deleteContract(' + c.id + ')" title="Delete"><i class="fas fa-trash"></i></button>';
    html += '</td>';
    html += '</tr>';
  });

  html += '</tbody></table>';
  html += renderPagination(res);
  $('#contracts_table').html(html);
}

/* ========== MOVEMENTS TABLE ========== */
function loadMovements(page){
  page = page || 1;
  showPreloader();
  const params = {
    page: page,
    per_page: 20,
    search: $('#global_search').val() || '',
    date_from: $('#filter_from').val() || '',
    date_to: $('#filter_to').val() || '',
    status: $('#filter_status').val() || ''
  };
  $.getJSON('/api/am-contract-movements', params)
    .done(function(res){ renderMovementsTable(res); })
    .fail(function(){ $('#movements_table').html('<div class="p-3 text-center text-muted">Failed to load movements.</div>'); })
    .always(hidePreloader);
}

function renderMovementsTable(res){
  const data = res.data || [];
  if(!data.length){
    $('#movements_table').html('<div class="p-3 text-center text-muted">No movements found.</div>');
    return;
  }
  let html = '<table class="table table-hover table-bordered mb-0"><thead><tr>';
  html += '<th>#</th><th>Date</th><th>Customer</th><th>Maid</th><th>Return Date</th><th>Status</th><th style="width:160px">Actions</th>';
  html += '</tr></thead><tbody>';

  data.forEach(function(m, i){
    const pc = m.primary_contract || {};
    const crm = pc.crm || {};
    const customerName = (crm.first_name || '') + ' ' + (crm.last_name || '');
    const emp = m.employee || {};
    const retInfo = m.return_info || {};
    
    let statusClass = 'status-0';
    let statusText = 'Returned';
    
    if(m.status == 1) {
      statusClass = 'status-1';
      statusText = 'Active';
    } else if(m.status > 1) {
      statusClass = 'badge bg-danger text-white';
      statusText = 'Incident';
    }
    const idx = ((res.current_page - 1) * res.per_page) + i + 1;

    html += '<tr>';
    html += '<td class="text-center">' + idx + '</td>';
    html += '<td>' + (m.date || '-') + '</td>';
    html += '<td>' + customerName.trim() + ' <small class="text-muted">' + (crm.CL_Number || '') + '</small></td>';
    html += '<td>' + (emp.name || '-') + '</td>';
    html += '<td class="text-center">' + (retInfo.date || '-') + '</td>';
    html += '<td class="text-center"><span class="' + statusClass + '">' + statusText + '</span></td>';
    html += '<td class="text-center" style="white-space:nowrap">';
    html += '<button class="btn btn-outline-info action-btn" onclick="viewMovement(' + m.id + ')" title="View"><i class="fas fa-eye"></i></button> ';
    if(m.status == 1){ 
      html += '<button class="btn btn-outline-warning action-btn" onclick="editMovement(' + m.id + ')" title="Edit"><i class="fas fa-edit"></i></button> ';
      html += '<button class="btn btn-outline-secondary action-btn" onclick="openReturnModal(' + m.id + ')" title="Return Maid"><i class="fas fa-undo-alt"></i></button> ';
      html += '<button class="btn btn-outline-danger action-btn" onclick="openIncidentModal(' + m.id + ')" title="Incident"><i class="fas fa-exclamation-triangle"></i></button>'; 
    }
    html += '</td>';
    html += '</tr>';
  });

  html += '</tbody></table>';
  html += renderPagination(res);
  $('#movements_table').html(html);
}

/* ========== INSTALLMENTS TABLE ========== */
function loadInstallments(page){
  page = page || 1;
  showPreloader();
  const params = {
    page: page,
    per_page: 20,
    search: $('#global_search').val() || '',
    date_from: $('#filter_from').val() || '',
    date_to: $('#filter_to').val() || '',
    status: $('#filter_status').val() || ''
  };
  $.getJSON('/api/am-installments', params)
    .done(function(res){ renderInstallmentsTable(res); })
    .fail(function(){ $('#installments_table').html('<div class="p-3 text-center text-muted">Failed to load installments.</div>'); })
    .always(hidePreloader);
}

function renderInstallmentsTable(res){
  const data = res.data || [];
  if(!data.length){
    $('#installments_table').html('<div class="p-3 text-center text-muted">No installments found.</div>');
    return;
  }
  let html = '<table class="table table-hover table-bordered mb-0"><thead><tr>';
  html += '<th>#</th><th>Customer</th><th>Customer Bank Details</th><th>Mobile</th><th>Maid</th><th>Accrued Date</th><th>Primary Contract Date</th><th>Amount</th><th>Note</th><th>Status</th><th style="width:120px">Actions</th>';
  html += '</tr></thead><tbody>';

  data.forEach(function(inst, i){
    const mov = inst.contract_movment || {};
    const pc = mov.primary_contract || {};
    const crm = pc.crm || {};
    const emp = mov.employee || {};
    const customerName = (crm.first_name || '') + ' ' + (crm.last_name || '');
    const mobile = crm.mobile || '-';
    
    // Extract first payment method bank details if present
    let bankDetails = '-';
    if(crm.payment_methods && crm.payment_methods.length > 0) {
      const pm = crm.payment_methods[0];
      bankDetails = (pm.bank || '') + '<br><small class="text-muted">' + (pm.iban || '') + '</small>';
    }

    const pcDate = pc.date || '-';
    const statusClass = inst.status == 1 ? 'status-1' : 'status-0';
    const statusText = inst.status == 1 ? 'Invoiced' : 'Pending';
    const idx = ((res.current_page - 1) * res.per_page) + i + 1;

    let actionsHtml = '';
    const invoicedDisabled = inst.status == 1 ? 'disabled' : '';
    
    // We encode the installment data into a data attribute so the modal can easily read it
    const instData = encodeURIComponent(JSON.stringify(inst));
    actionsHtml += '<button class="btn btn-outline-primary action-btn btn-sm" onclick="openInvoiceModal(\'' + instData + '\')" title="Create Invoice" ' + invoicedDisabled + '><i class="fas fa-file-invoice-dollar"></i></button>';

    html += '<tr>';
    html += '<td class="text-center">' + idx + '</td>';
    html += '<td>' + customerName.trim() + '</td>';
    html += '<td>' + bankDetails + '</td>';
    html += '<td>' + mobile + '</td>';
    html += '<td>' + (emp.name || '-') + '</td>';
    html += '<td>' + (inst.date || '-') + '</td>';
    html += '<td>' + pcDate + '</td>';
    html += '<td class="text-end">' + parseFloat(inst.amount || 0).toFixed(2) + '</td>';
    html += '<td>' + (inst.note || '-') + '</td>';
    html += '<td class="text-center"><span class="' + statusClass + '">' + statusText + '</span></td>';
    html += '<td class="text-center">' + actionsHtml + '</td>';
    html += '</tr>';
  });

  html += '</tbody></table>';
  html += renderPagination(res);
  $('#installments_table').html(html);
}

/* ========== P3 INVOICES TABLE ========== */
function loadInvoices(page){
  page = page || 1;
  showPreloader();
  const params = {
    page: page,
    per_page: 20
  };
  $.getJSON('/api/am-monthly-invoices', params)
    .done(function(res){ renderInvoicesTable(res); })
    .fail(function(){ $('#invoices_table').html('<div class="p-3 text-center text-muted">Failed to load invoices.</div>'); })
    .always(hidePreloader);
}

function renderInvoicesTable(res){
  const data = res.data || [];
  if(!data.length){
    $('#invoices_table').html('<div class="p-3 text-center text-muted">No invoices found.</div>');
    return;
  }
  let html = '<table class="table table-hover table-bordered mb-0"><thead><tr>';
  html += '<th>#</th><th>Serial No</th><th>Accrued Date</th><th>Customer</th><th>Customer Bank Details</th><th>Mobile</th><th>Maid</th><th>Amount</th><th>Paid / Refunded</th><th>Payment Status</th><th>Refund Status</th><th>Note</th><th style="width:130px">Actions</th>';
  html += '</tr></thead><tbody>';

  data.forEach(function(inv, i){
    const crm = inv.crm || {};
    const mov = inv.contract_movment || {};
    const emp = mov.employee || {};
    
    // Customer
    const customerName = (crm.first_name || '') + ' ' + (crm.last_name || '');
    const mobile = crm.mobile || '-';
    
    // Bank Details
    let bankDetails = '-';
    if(crm.payment_methods && crm.payment_methods.length > 0) {
      const pm = crm.payment_methods[0];
      bankDetails = '<div class="d-flex flex-column"><span class="fw-bold text-dark"><i class="fas fa-university me-1 text-muted"></i>' + (pm.bank || 'Bank') + '</span><small class="text-muted" style="font-size:0.75rem;">' + (pm.iban || '') + '</small></div>';
    }

    // Amount, Paid, Refunded formatting
    const amount = parseFloat(inv.amount || 0);
    const paid = parseFloat(inv.paid_amount || 0);
    const refunded = parseFloat(inv.refunded_amount || 0);
    
    // Paid/Refund Chips
    let balanceStr = '';
    if(paid > 0) balanceStr += `<span class="badge bg-success bg-opacity-10 text-success border border-success me-1 mb-1"><i class="fas fa-check-circle me-1"></i>Paid: ${paid.toLocaleString('en-US', {minimumFractionDigits:2})}</span><br>`;
    else balanceStr += `<span class="badge bg-light text-muted border me-1 mb-1">Paid: 0.00</span><br>`;
    
    if(refunded > 0) balanceStr += `<span class="badge bg-danger bg-opacity-10 text-danger border border-danger"><i class="fas fa-undo me-1"></i>Ref: ${refunded.toLocaleString('en-US', {minimumFractionDigits:2})}</span>`;

    const idx = ((res.current_page - 1) * res.per_page) + i + 1;

    // Badges & styling
    const maidBadge = emp.name ? `<span class="badge bg-primary bg-opacity-10 text-primary border border-primary"><i class="fas fa-user-circle me-1"></i>${emp.name}</span>` : '-';
    const serialBadge = inv.serial_no ? `<span class="badge bg-secondary text-white fw-normal font-monospace px-2 py-1">${inv.serial_no}</span>` : '-';
    const dateStyled = inv.date ? `<div class="text-nowrap"><i class="far fa-calendar-alt text-muted me-1"></i>${inv.date}</div>` : '-';

    // Payment Status Chip
    let payStatusChip = '<span class="badge bg-danger rounded-pill px-2">Unpaid</span>';
    if (inv.payment_status === 'paid') payStatusChip = '<span class="badge bg-success rounded-pill px-2">Paid</span>';
    else if (inv.payment_status === 'partial_paid') payStatusChip = '<span class="badge bg-warning text-dark rounded-pill px-2">Partial Paid</span>';

    // Refund Status Chip
    let refStatusChip = '<span class="badge bg-light text-muted border rounded-pill px-2">Not Refunded</span>';
    if (inv.refund_status === 'fully_refunded') refStatusChip = '<span class="badge bg-danger rounded-pill px-2">Fully Refunded</span>';
    else if (inv.refund_status === 'partial_refunded') refStatusChip = '<span class="badge bg-info text-dark rounded-pill px-2">Partial Refund</span>';

    // Action Buttons
    let actionsHtml = '';
    const invData = encodeURIComponent(JSON.stringify(inv));
    
    // Payment Action
    const payDisabled = (inv.payment_status === 'paid') ? 'disabled' : '';
    actionsHtml += `<button class="btn btn-outline-success action-btn btn-sm" onclick="openPaymentModal('${invData}')" title="Receive Payment" ${payDisabled}><i class="fas fa-hand-holding-usd"></i></button> `;
    
    // Credit Note Action
    const credDisabled = (inv.refund_status === 'fully_refunded' || inv.payment_status === 'unpaid') ? 'disabled' : '';
    actionsHtml += `<button class="btn btn-outline-danger action-btn btn-sm" onclick="openCreditNoteModal('${invData}')" title="Issue Credit Note" ${credDisabled}><i class="fas fa-undo-alt"></i></button>`;

    html += '<tr>';
    html += '<td class="text-center align-middle">' + idx + '</td>';
    html += '<td class="align-middle">' + serialBadge + '</td>';
    html += '<td class="align-middle">' + dateStyled + '</td>';
    html += '<td class="align-middle fw-semibold text-dark">' + customerName.trim() + '</td>';
    html += '<td class="align-middle">' + bankDetails + '</td>';
    html += '<td class="align-middle"><div class="text-nowrap"><i class="fas fa-phone-alt text-muted me-1" style="font-size:0.8rem"></i>' + mobile + '</div></td>';
    html += '<td class="align-middle">' + maidBadge + '</td>';
    html += '<td class="text-end align-middle fw-bold text-dark">' + amount.toLocaleString('en-US', {minimumFractionDigits:2}) + '</td>';
    html += '<td class="align-middle" style="line-height: 1.4;">' + balanceStr + '</td>';
    html += '<td class="align-middle text-center">' + payStatusChip + '</td>';
    html += '<td class="align-middle text-center">' + refStatusChip + '</td>';
    html += '<td class="align-middle text-muted small">' + (inv.note || '-') + '</td>';
    html += '<td class="text-center align-middle" style="white-space:nowrap;">' + actionsHtml + '</td>';
    html += '</tr>';
  });

  html += '</tbody></table>';
  html += renderPagination(res);
  $('#invoices_table').html(html);
}

/* ========== INVOICE ACTIONS ========== */
function initPaymentLedgerSelect2() {
  $('#payment_debit_ledger').select2({
    ajax: {
      url: '/api/ledgers/lookup',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        return {
          search: params.term || '',
          spacial: 2  // Filter strictly by spacial=2 (Cash/Bank accounts)
        };
      },
      processResults: function(data) {
        return {
          results: data.results || []
        };
      },
      cache: true
    },
    minimumInputLength: 0,
    placeholder: 'Select Cash/Bank Account...',
    allowClear: true,
    width: '100%',
    dropdownParent: $('#paymentModal')
  });
}

// Bind the modal shown event to instantiate Select2 cleanly
$(document).ready(function() {
  $('#paymentModal').on('shown.bs.modal', function() {
    if ($('#payment_debit_ledger').hasClass('select2-hidden-accessible')) {
      $('#payment_debit_ledger').select2('destroy');
    }
    initPaymentLedgerSelect2();
  });
});

function openPaymentModal(invStr) {
  try {
    const inv = JSON.parse(decodeURIComponent(invStr));
    const amount = parseFloat(inv.amount || 0);
    const paid = parseFloat(inv.paid_amount || 0);
    const unpaid = amount - paid;
    const crm = inv.crm || {};
    const cName = (crm.first_name || '') + ' ' + (crm.last_name || '');
    
    $('#payment_invoice_id').val(inv.id);
    $('#lbl_payment_serial').text(inv.serial_no || '-');
    $('#lbl_payment_customer').text(cName.trim() || '-');
    $('#lbl_payment_balance').text(unpaid.toFixed(2));
    
    $('#payment_amount').val(unpaid.toFixed(2));
    $('#payment_amount').attr('max', unpaid.toFixed(2));
    $('#payment_mode').val('1');
    $('#payment_debit_ledger').val(null).trigger('change');
    new bootstrap.Modal(document.getElementById('paymentModal')).show();
  } catch(e) {
    console.error("Failed to parse invoice", e);
  }
}

function submitPayment() {
  const id = $('#payment_invoice_id').val();
  const amt = $('#payment_amount').val();
  const mode = $('#payment_mode').val();
  const ledger = $('#payment_debit_ledger').val();

  if(!amt || amt <= 0) return alert('Enter a valid amount.');
  if(!ledger) return alert('Select a Deposit To Ledger.');

  const btn = document.getElementById('btnSubmitPayment');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';

  $.ajax({
    url: '/api/am-monthly-invoices/' + id + '/receive-payment',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({
      amount: amt,
      debit_ledger_id: ledger,
      payment_mode: mode
    }),
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '' }
  })
  .done(function(res) {
    if(typeof toastr !== 'undefined') toastr.success(res.message || 'Payment received!');
    else alert('Payment successful');
    bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
    loadCurrentTab();
  })
  .fail(function(xhr) {
    const msg = xhr.responseJSON?.message || 'Payment failed';
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function() {
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

function openCreditNoteModal(invStr) {
  try {
    const inv = JSON.parse(decodeURIComponent(invStr));
    const crm = inv.crm || {};
    const cName = (crm.first_name || '') + ' ' + (crm.last_name || '');

    $('#credit_invoice_id').val(inv.id);
    $('#lbl_credit_serial').text(inv.serial_no || '-');
    $('#lbl_credit_customer').text(cName.trim() || '-');
    
    $('#credit_type').val('full');
    $('#credit_days').val('');
    $('#creditDaysContainer').hide();
    
    new bootstrap.Modal(document.getElementById('creditNoteModal')).show();
  } catch(e) {
    console.error("Failed to parse invoice", e);
  }
}

function toggleCreditDays() {
  if($('#credit_type').val() === 'partial') {
    $('#creditDaysContainer').slideDown();
    $('#credit_days').prop('required', true);
  } else {
    $('#creditDaysContainer').slideUp();
    $('#credit_days').prop('required', false).val('');
  }
}

function submitCreditNote() {
  const id = $('#credit_invoice_id').val();
  const type = $('#credit_type').val();
  const days = $('#credit_days').val();

  if(type === 'partial' && (!days || days < 1 || days > 29)) {
    return alert('Please enter valid days between 1 and 29 for partial credit.');
  }

  const btn = document.getElementById('btnSubmitCredit');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Issuing...';

  const payload = { credit_type: type };
  if(type === 'partial') payload.days = days;

  $.ajax({
    url: '/api/am-monthly-invoices/' + id + '/credit-note',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify(payload),
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '' }
  })
  .done(function(res) {
    if(typeof toastr !== 'undefined') toastr.success(res.message || 'Credit note issued!');
    else alert('Credit note successful');
    bootstrap.Modal.getInstance(document.getElementById('creditNoteModal')).hide();
    loadCurrentTab();
  })
  .fail(function(xhr) {
    const msg = xhr.responseJSON?.message || 'Credit note failed';
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function() {
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

/* ========== REFUND REQUESTS TABLE ========== */
function loadRefundRequests(page){
  page = page || 1;
  showPreloader();
  const params = {
    page: page,
    per_page: 20
  };
  $.getJSON('/api/amp3-action-notifies', params)
    .done(function(res){ renderRefundRequestsTable(res); })
    .fail(function(){ $('#refund_requests_table').html('<div class="p-3 text-center text-muted">Failed to load refund requests.</div>'); })
    .always(hidePreloader);
}

function renderRefundRequestsTable(res){
  const data = res.data || [];
  if(!data.length){
    $('#refund_requests_table').html('<div class="p-3 text-center text-muted">No refund requests found.</div>');
    return;
  }

  let html = '<table class="table table-hover table-bordered mb-0"><thead><tr>';
  html += '<th>#</th><th>Date Requested</th><th>Customer</th><th>Maid</th><th>Refund Amount</th><th>Note</th><th>Status</th>';
  html += '</tr></thead><tbody>';

  data.forEach(function(req, i){
    const revDate = req.refund_date ? new Date(req.refund_date).toLocaleDateString() : '-';
    
    // Safely extract deeply nested relations
    const mov = req.movement_contract || {};
    const pc = mov.primary_contract || {};
    const crm = pc.crm || {};
    const emp = mov.employee || {};

    const customerName = (crm.first_name || '') + ' ' + (crm.last_name || '');
    const maidBadge = emp.name ? `<span class="badge bg-primary bg-opacity-10 text-primary border border-primary"><i class="fas fa-user-circle me-1"></i>${emp.name}</span>` : '-';
    const amountStr = parseFloat(req.amount || 0).toLocaleString('en-US', {minimumFractionDigits:2});
    
    let statusBadge = '<span class="badge bg-secondary">Unknown</span>';
    if(req.status === 0) statusBadge = '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pending</span>';
    else if(req.status === 1) statusBadge = '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Approved</span>';
    else if(req.status === 2) statusBadge = '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Rejected</span>';

    const idx = ((res.meta ? res.meta.current_page : 1) - 1) * (res.meta ? res.meta.per_page : 20) + i + 1;

    html += '<tr>';
    html += '<td class="text-center align-middle">' + idx + '</td>';
    html += '<td class="align-middle"><div class="text-nowrap"><i class="far fa-calendar-alt text-muted me-1"></i>' + revDate + '</div></td>';
    html += '<td class="align-middle fw-semibold text-dark">' + customerName.trim() + '</td>';
    html += '<td class="align-middle">' + maidBadge + '</td>';
    html += '<td class="text-end align-middle fw-bold text-danger">' + amountStr + '</td>';
    html += '<td class="align-middle small text-muted">' + (req.note || '-') + '</td>';
    html += '<td class="text-center align-middle">' + statusBadge + '</td>';
    html += '</tr>';
  });

  html += '</tbody></table>';
  html += renderPagination(res.meta || res);
  $('#refund_requests_table').html(html);
}

/* ========== DEDUCTIONS / ALLOWANCES MODAL ========== */
function openDeductionModal(){
  $('#deductionBulkRows').empty();
  addDeductionRow();
  new bootstrap.Modal(document.getElementById('deductionModal')).show();
}

function initRowSelect2(rowId){
  const el = $('#' + rowId).find('.ded-employee-select');
  if(!el.hasClass('select2-hidden-accessible')){
    el.select2({
      theme: 'bootstrap-5',
      width: '100%',
      dropdownParent: $('#deductionModal'),
      placeholder: 'Search Maid/Employee...',
      ajax: {
        url: '/api/am-monthly-contracts/lookup-all-employees',
        delay: 250,
        data: function(params){ return { search: params.term }; },
        processResults: function(data){
          return { results: $.map(data.data || data, function(obj){ return { id: obj.id, text: obj.name || obj.text }; }) };
        }
      }
    });
  }
}

function addDeductionRow(){
  const rowId = 'ded_row_' + Date.now() + Math.floor(Math.random() * 1000);
  const now = new Date();
  const year = now.getFullYear();
  const month = now.getMonth() + 1;
  const todayStr = now.toISOString().split('T')[0];
  
  const html = `
    <tr id="${rowId}" class="deduction-row">
      <td style="min-width: 250px;">
        <select class="form-control form-control-sm ded-employee-select" required></select>
      </td>
      <td>
        <input type="number" class="form-control form-control-sm ded-year" min="2020" max="2099" value="${year}" required>
      </td>
      <td>
        <select class="form-select form-select-sm ded-month" required>
          <option value="1" ${month===1?'selected':''}>Jan</option><option value="2" ${month===2?'selected':''}>Feb</option>
          <option value="3" ${month===3?'selected':''}>Mar</option><option value="4" ${month===4?'selected':''}>Apr</option>
          <option value="5" ${month===5?'selected':''}>May</option><option value="6" ${month===6?'selected':''}>Jun</option>
          <option value="7" ${month===7?'selected':''}>Jul</option><option value="8" ${month===8?'selected':''}>Aug</option>
          <option value="9" ${month===9?'selected':''}>Sep</option><option value="10" ${month===10?'selected':''}>Oct</option>
          <option value="11" ${month===11?'selected':''}>Nov</option><option value="12" ${month===12?'selected':''}>Dec</option>
        </select>
      </td>
      <td>
        <input type="date" class="form-control form-control-sm ded-date" value="${todayStr}">
      </td>
      <td>
        <div class="input-group input-group-sm">
          <span class="input-group-text"><i class="fas fa-minus"></i></span>
          <input type="number" step="0.01" class="form-control ded-dr text-danger" placeholder="0.00">
        </div>
      </td>
      <td>
        <div class="input-group input-group-sm">
          <span class="input-group-text"><i class="fas fa-plus"></i></span>
          <input type="number" step="0.01" class="form-control ded-cr text-success" placeholder="0.00">
        </div>
      </td>
      <td>
        <input type="text" class="form-control form-control-sm ded-note" placeholder="Note...">
      </td>
      <td class="text-center align-middle">
        <button type="button" class="btn btn-sm btn-danger px-2 py-1 flex-shrink-0" onclick="removeDeductionRow('${rowId}')">
          <i class="fas fa-trash-alt"></i>
        </button>
      </td>
    </tr>
  `;
  $('#deductionBulkRows').append(html);
  initRowSelect2(rowId);
}

function removeDeductionRow(rowId){
  $('#' + rowId).fadeOut(200, function(){
    $(this).remove();
    if($('.deduction-row').length === 0){
      addDeductionRow(); // Ensure at least one row exists
    }
  });
}

function submitDeductionsBulk(){
  const rows = [];
  let hasError = false;

  $('.deduction-row').each(function(){
    const empId = $(this).find('.ded-employee-select').val();
    const year = $(this).find('.ded-year').val();
    const month = $(this).find('.ded-month').val();
    const date = $(this).find('.ded-date').val();
    const dr = $(this).find('.ded-dr').val();
    const cr = $(this).find('.ded-cr').val();
    const note = $(this).find('.ded-note').val();

    if(!empId || !year || !month){
      hasError = true;
      $(this).addClass('table-danger');
    } else {
      $(this).removeClass('table-danger');
      rows.push({
        employee_id: empId,
        payroll_year: year,
        payroll_month: month,
        deduction_date: date || null,
        amount_deduction: dr ? parseFloat(dr) : null,
        amount_allowance: cr ? parseFloat(cr) : null,
        note: note || null
      });
    }
  });

  if(hasError){
    alert('Please ensure Employee, Year, and Month are filled for all highlighted rows.');
    return;
  }
  
  if(!rows.length){
    alert('No data to submit.');
    return;
  }

  const payload = { rows: rows };

  const btn = document.getElementById('btnSubmitDeduction');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';

  $.ajax({
    url: '/api/deduction-payrolls',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify(payload)
  })
  .done(function(res){
    if(typeof toastr !== 'undefined') toastr.success(res.message || 'Records created successfully!');
    else alert('Records created successfully!');
    bootstrap.Modal.getInstance(document.getElementById('deductionModal')).hide();
    loadCurrentTab();
  })
  .fail(function(xhr){
    const msg = xhr.responseJSON?.message || xhr.responseJSON?.error || 'Failed to create records';
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function(){
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

/* ========== DEDUCTIONS TABLE ========== */
function loadDeductions(page){
  page = page || 1;
  showPreloader();
  const params = {
    page: page,
    per_page: 20
  };
  $.getJSON('/api/deduction-payrolls', params)
    .done(function(res){ renderDeductionsTable(res); })
    .fail(function(){ $('#deductions_table').html('<div class="p-3 text-center text-muted">Failed to load deductions.</div>'); })
    .always(hidePreloader);
}

function renderDeductionsTable(res){
  const data = res.data || [];
  if(!data.length){
    $('#deductions_table').html('<div class="p-3 text-center text-muted">No deduction/allowance records found.</div>');
    return;
  }

  let html = '<table class="table table-hover table-bordered mb-0"><thead><tr>';
  html += '<th>#</th><th>Employee / Maid</th><th>Payroll Month/Year</th><th>Deduction Date</th><th>Deducted (Dr.)</th><th>Allowance (Cr.)</th><th>Note</th><th>Created At</th>';
  html += '</tr></thead><tbody>';

  data.forEach(function(req, i){
    const drAmount = parseFloat(req.amount_deduction || 0);
    const crAmount = parseFloat(req.amount_allowance || 0);

    const drAmountStr = drAmount > 0 ? `<span class="text-danger fw-bold"><i class="fas fa-minus-circle me-1"></i>${drAmount.toLocaleString('en-US', {minimumFractionDigits:2})}</span>` : '-';
    const crAmountStr = crAmount > 0 ? `<span class="text-success fw-bold"><i class="fas fa-plus-circle me-1"></i>${crAmount.toLocaleString('en-US', {minimumFractionDigits:2})}</span>` : '-';
    
    // Safely extract deeply nested relations
    const emp = req.employee || {};
    const maidBadge = emp.name ? `<span class="badge bg-primary bg-opacity-10 text-primary border border-primary"><i class="fas fa-user-circle me-1"></i>${emp.name}</span>` : '-';
    
    const deductionDate = req.deduction_date ? new Date(req.deduction_date).toLocaleDateString() : '-';
    const createdAt = req.created_at ? new Date(req.created_at).toLocaleString() : '-';
    
    const payrollPeriod = `<span class="badge bg-light text-dark border"><i class="far fa-calendar-alt me-1"></i>${req.payroll_month || '-'}/${req.payroll_year || '-'}</span>`;

    const idx = ((res.meta ? res.meta.current_page : 1) - 1) * (res.meta ? res.meta.per_page : 20) + i + 1;

    html += '<tr>';
    html += '<td class="text-center align-middle">' + idx + '</td>';
    html += '<td class="align-middle">' + maidBadge + '</td>';
    html += '<td class="align-middle text-center">' + payrollPeriod + '</td>';
    html += '<td class="align-middle text-center">' + deductionDate + '</td>';
    html += '<td class="text-end align-middle bg-danger bg-opacity-10">' + drAmountStr + '</td>';
    html += '<td class="text-end align-middle bg-success bg-opacity-10">' + crAmountStr + '</td>';
    html += '<td class="align-middle small text-muted">' + (req.note || '-') + '</td>';
    html += '<td class="align-middle small text-muted">' + createdAt + '</td>';
    html += '</tr>';
  });

  html += '</tbody></table>';
  html += renderPagination(res.meta || res);
  $('#deductions_table').html(html);
}

/* ========== PAGINATION ========== */
function renderPagination(res){
  if(res.last_page <= 1) return '';
  let html = '<div class="pagination-container"><small class="text-muted">Showing ' + res.data.length + ' of ' + res.total + '</small><nav><ul class="pagination">';

  // Prev
  if(res.current_page > 1) html += '<li class="page-item"><a class="page-link" href="#" data-page="' + (res.current_page - 1) + '">&laquo;</a></li>';
  else html += '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';

  // Pages
  let start = Math.max(1, res.current_page - 2);
  let end = Math.min(res.last_page, res.current_page + 2);
  for(let p = start; p <= end; p++){
    html += '<li class="page-item' + (p === res.current_page ? ' active' : '') + '"><a class="page-link" href="#" data-page="' + p + '">' + p + '</a></li>';
  }

  // Next
  if(res.current_page < res.last_page) html += '<li class="page-item"><a class="page-link" href="#" data-page="' + (res.current_page + 1) + '">&raquo;</a></li>';
  else html += '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';

  html += '</ul></nav></div>';
  return html;
}

/* ========== CREATE / EDIT MODAL ========== */
function openCreateModal(){
  $('#edit_contract_id').val('');
  $('#contractModalTitle').html('<i class="fas fa-file-contract me-2"></i>New Monthly Contract');
  
  const today = new Date();
  const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
  const diffDays = endOfMonth.getDate() - today.getDate() + 1;

  setDatePickerValue('form_start_date', today);
  setDatePickerValue('form_end_date', endOfMonth);
  $('#form_prorate_amount').val('');
  $('#form_prorate_days').val(diffDays);
  resetSelect2('#form_customer');
  resetSelect2('#form_maid');
  $('#installmentBody').empty();
  addInstallmentRow();
  initSelect2Fields();
  new bootstrap.Modal(document.getElementById('contractModal')).show();
}

function formatDateForInput(dateVal) {
  if (!dateVal) return '';
  let str = String(dateVal).trim();
  if (!str) return '';

  // 1. If it already looks like YYYY-MM-DD anywhere in the string, just extract it
  // Sometimes APIs return "2026-02-21 00:00:00" or similar
  if (str.length >= 10 && str.charAt(4) === '-' && str.charAt(7) === '-') {
      return str.substring(0, 10);
  }

  // 2. Custom parse for "DD MMM YYYY" (e.g. "21 Feb 2026")
  const months = {
    'jan': '01', 'feb': '02', 'mar': '03', 'apr': '04', 'may': '05', 'jun': '06',
    'jul': '07', 'aug': '08', 'sep': '09', 'oct': '10', 'nov': '11', 'dec': '12'
  };
  const parts = str.split(/[\s,-]+/);
  if (parts.length >= 3) {
      const mStr = parts[1].toLowerCase().substring(0, 3);
      if (months[mStr] && parts[0].length <= 2 && parts[2].length === 4) {
          const day = parts[0].length === 1 ? '0' + parts[0] : parts[0];
          return `${parts[2]}-${months[mStr]}-${day}`;
      }
  }

  // 3. Absolute fallback to Date object
  const d = new Date(str);
  if (!isNaN(d.getTime())) {
      const year = d.getFullYear();
      let month = '' + (d.getMonth() + 1);
      let day = '' + d.getDate();
      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;
      return [year, month, day].join('-');
  }

  return ''; // Give up, leave input empty rather than 'undefined'
}

function setDatePickerValue(elementId, dateStr) {
    const el = document.getElementById(elementId);
    if (!el) return;
    
    let dObj = null;
    if (dateStr) {
        let str = String(dateStr).trim();
        if (str.length >= 10 && str.charAt(4) === '-' && str.charAt(7) === '-') {
            const y = parseInt(str.substring(0,4), 10);
            const m = parseInt(str.substring(5,7), 10) - 1;
            const d = parseInt(str.substring(8,10), 10);
            dObj = new Date(y, m, d);
        } else {
            dObj = new Date(str);
        }
    }
    
    if (el._flatpickr) {
        if (dObj && !isNaN(dObj.getTime())) {
            el._flatpickr.setDate(dObj);
        } else {
            el._flatpickr.clear();
        }
    } else {
        if (dObj && !isNaN(dObj.getTime())) {
            const y = dObj.getFullYear();
            const m = String(dObj.getMonth() + 1).padStart(2, '0');
            const d = String(dObj.getDate()).padStart(2, '0');
            el.value = `${y}-${m}-${d}`;
        } else {
            el.value = '';
        }
    }
}

function editContract(id){
  showPreloader();
  $.getJSON(API + '/' + id)
    .done(function(c){
      hidePreloader();
      $('#edit_only_contract_id').val(c.id);
      
      setDatePickerValue('edit_start_date', c.date);
      setDatePickerValue('edit_end_date', c.end_date);

      $('#edit_contract_note').val(c.note || '');
      new bootstrap.Modal(document.getElementById('editContractModal')).show();
    })
    .fail(function(){
      hidePreloader();
      alert('Failed to load contract.');
    });
}

function submitEditContract(){
  const id = $('#edit_only_contract_id').val();
  const date = $('#edit_start_date').val();
  const end_date = $('#edit_end_date').val();
  const note = $('#edit_contract_note').val();
  
  const btn = document.getElementById('btnSubmitEditContract');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';

  $.ajax({
    url: API + '/' + id,
    method: 'PUT',
    contentType: 'application/json',
    data: JSON.stringify({ date: date, end_date: end_date, note: note }),
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
    }
  })
  .done(function(res){
    const msg = res.message || 'Contract updated!';
    if(typeof toastr !== 'undefined') toastr.success(msg);
    else alert(msg);
    bootstrap.Modal.getInstance(document.getElementById('editContractModal'))?.hide();
    loadContracts();
  })
  .fail(function(xhr){
    let msg = 'Failed to update contract.\\n';
    if(xhr.responseJSON) {
      if(xhr.responseJSON.errors) {
        msg += Object.values(xhr.responseJSON.errors).map(e => e.join(', ')).join('\\n');
      } else {
        msg += xhr.responseJSON.message || xhr.responseText;
      }
      if(xhr.responseJSON.error) {
          msg += '\\n' + xhr.responseJSON.error;
      }
    } else {
        msg += xhr.responseText;
    }
    console.error('Update contract error:', xhr);
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function(){
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

function resetSelect2(selector){
  if($(selector).hasClass('select2-hidden-accessible')){
    $(selector).val(null).trigger('change');
    $(selector).select2('destroy');
  }
  $(selector).empty();
}

function initSelect2Fields(){
  // Customer Select2
  resetSelect2('#form_customer');
  $('#form_customer').select2({
    dropdownParent: $('#contractModal'),
    width: '100%',
    placeholder: 'Search customer by name or CL...',
    allowClear: true,
    ajax: {
      url: API + '/lookup-customers',
      dataType: 'json',
      delay: 300,
      data: function(params){ return { search: params.term || '' }; },
      processResults: function(data){
        return {
          results: data.results || [],
          pagination: { more: data.pagination && data.pagination.more }
        };
      },
      cache: true
    },
    minimumInputLength: 0
  });

  // Maid Select2
  resetSelect2('#form_maid');
  $('#form_maid').select2({
    dropdownParent: $('#contractModal'),
    width: '100%',
    placeholder: 'Search maid by name...',
    allowClear: true,
    ajax: {
      url: API + '/lookup-employees',
      dataType: 'json',
      delay: 300,
      data: function(params){ return { search: params.term || '' }; },
      processResults: function(data){
        const items = Array.isArray(data) ? data : (data.results || data.data || []);
        return {
          results: items.map(function(e){ return { id: e.id, text: e.name }; })
        };
      },
      cache: true
    },
    minimumInputLength: 0
  });
}

/* ========== INSTALLMENT ROWS ========== */
function getNextInstallmentDate(tbodySelector, dateClass) {
  const lastInput = $(tbodySelector + ' tr:last-child .' + dateClass);
  let baseDate = new Date();
  
  if (lastInput.length && lastInput.val()) {
    baseDate = new Date(lastInput.val());
  }
  
  baseDate.setMonth(baseDate.getMonth() + 1);
  const yyyy = baseDate.getFullYear();
  const mm = String(baseDate.getMonth() + 1).padStart(2, '0');
  return `${yyyy}-${mm}-01`;
}

function addInstallmentRow(data){
  data = data || {};
  let dateVal = data.date || '';
  if (!dateVal) dateVal = getNextInstallmentDate('#installmentBody', 'inst-date');

  const row = `
    <tr>
      <td><input type="date" class="form-control form-control-sm inst-date" value="${dateVal}"></td>
      <td><input type="number" step="0.01" class="form-control form-control-sm inst-amount" value="${data.amount || ''}" placeholder="0.00"></td>
      <td><input type="text" class="form-control form-control-sm inst-note" value="${data.note || ''}" placeholder="Note"></td>
      <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="removeInstallmentRow(this)"><i class="fas fa-minus"></i></button></td>
    </tr>`;
  $('#installmentBody').append(row);
}

function removeInstallmentRow(btn){
  const rows = $('#installmentBody tr');
  if(rows.length > 1) $(btn).closest('tr').remove();
  else alert('At least one installment is required.');
}

function addEditInstallmentRow(data){
  data = data || {};
  let dateVal = data.date || '';
  if (!dateVal && !data.id) dateVal = getNextInstallmentDate('#editInstallmentBody', 'edit-inst-date');

  const isExisting = !!data.id;
  const isPaid = data.status == 1; // 1 = invoiced/paid
  const row = `
    <tr data-id="${data.id || ''}">
      <td><input type="${isPaid ? 'text' : 'date'}" class="form-control form-control-sm edit-inst-date" value="${dateVal}" ${isPaid ? 'disabled' : ''}></td>
      <td><input type="number" step="0.01" class="form-control form-control-sm edit-inst-amount" value="${data.amount || ''}" placeholder="0.00" ${isPaid ? 'disabled' : ''}></td>
      <td><input type="text" class="form-control form-control-sm edit-inst-note" value="${data.note || ''}" placeholder="Note" ${isPaid ? 'disabled' : ''}></td>
      <td class="text-center">
        ${isPaid ? 
          '<span class="badge bg-success" title="Invoiced"><i class="fas fa-check"></i></span>' : 
          '<button type="button" class="btn btn-outline-danger btn-sm" onclick="removeEditInstallmentRow(this)"><i class="fas fa-trash"></i></button>'
        }
      </td>
    </tr>`;
  $('#editInstallmentBody').append(row);
}

function removeEditInstallmentRow(btn){
  $(btn).closest('tr').remove();
}

/* ========== SAVE CONTRACT ========== */
function saveContract(){
  const contractId = $('#edit_contract_id').val();
  const customerId = $('#form_customer').val();
  const maidId = $('#form_maid').val();
  const startDate = $('#form_start_date').val();
  const endDate = $('#form_end_date').val();
  const prorateAmount = $('#form_prorate_amount').val();
  const prorateDays = $('#form_prorate_days').val();

  if(!customerId){ alert('Please select a customer.'); return; }
  if(!maidId){ alert('Please select a maid.'); return; }
  if(!startDate){ alert('Please enter a start date.'); return; }

  // Collect installments
  const installments = [];
  let valid = true;
  $('#installmentBody tr').each(function(){
    const date = $(this).find('.inst-date').val();
    const amount = $(this).find('.inst-amount').val();
    const note = $(this).find('.inst-note').val();
    if(!date || !amount){ valid = false; return false; }
    installments.push({ date: date, amount: parseFloat(amount), note: note || '' });
  });

  if(!valid){ alert('Please fill in all installment dates and amounts.'); return; }
  if(!installments.length){ alert('Please add at least one installment.'); return; }

  const payload = {
    start_date: startDate,
    ended_date: endDate || null,
    customer_id: parseInt(customerId),
    maid_id: parseInt(maidId),
    installment: installments
  };

  if(prorateAmount && parseFloat(prorateAmount) > 0){
    payload.prorate_amount = parseFloat(prorateAmount);
    payload.prorate_days = parseInt(prorateDays) || 0;
  }

  const url = API;
  const method = 'POST';

  const btn = document.getElementById('btnSaveContract');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';

  $.ajax({
    url: url,
    method: method,
    contentType: 'application/json',
    data: JSON.stringify(payload),
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
    }
  })
  .done(function(res){
    const msg = res.message || 'Contract created!';
    if(typeof toastr !== 'undefined') toastr.success(msg);
    else alert(msg);
    bootstrap.Modal.getInstance(document.getElementById('contractModal'))?.hide();
    loadContracts();
  })
  .fail(function(xhr){
    let msg = 'Failed to save contract.';
    if(xhr.responseJSON){
      if(xhr.responseJSON.errors){
        const errs = xhr.responseJSON.errors;
        msg = Object.keys(errs).map(function(k){ return k + ': ' + errs[k].join(', '); }).join('\n');
      } else {
        msg = xhr.responseJSON.message || '';
        if(xhr.responseJSON.error) msg += '\n' + xhr.responseJSON.error;
      }
    }
    console.error('Save contract error:', xhr.responseJSON);
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function(){
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

/* ========== VIEW CONTRACT ========== */
function viewContract(id){
  $('#viewContractBody').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
  new bootstrap.Modal(document.getElementById('viewContractModal')).show();

  $.getJSON(API + '/' + id)
    .done(function(c){
      const crm = c.crm || {};
      const customerName = (crm.first_name || '') + ' ' + (crm.last_name || '');
      const mov = (c.contract_movments && c.contract_movments[0]) || {};
      const emp = mov.employee || {};
      const installments = mov.installments || [];

      let html = '<div class="row g-3">';
      html += '<div class="col-md-6"><strong>Contract ID:</strong> ' + c.id + '</div>';
      html += '<div class="col-md-6"><strong>Status:</strong> <span class="' + (c.status == 1 ? 'status-1' : 'status-0') + '">' + (c.status == 1 ? 'Active' : 'Inactive') + '</span></div>';
      html += '<div class="col-md-6"><strong>Customer:</strong> ' + customerName.trim() + ' <small class="text-muted">(' + (crm.CL_Number || '') + ')</small></div>';
      html += '<div class="col-md-6"><strong>Start Date:</strong> ' + (c.date || '-') + '</div>';
      html += '<div class="col-md-6"><strong>End Date:</strong> ' + (c.end_date || '-') + '</div>';
      html += '</div>';

      if(c.contract_movments && c.contract_movments.length){
        html += '<hr><h6 class="text-muted"><i class="fas fa-exchange-alt me-1"></i>Movements (' + c.contract_movments.length + ')</h6>';
        html += '<table class="table table-sm table-bordered"><thead><tr><th>#</th><th>Start Date</th><th>Return Date</th><th>Maid</th><th>Status</th><th>Note</th></tr></thead><tbody>';
        c.contract_movments.forEach(function(cmov, i){
          const emp = cmov.employee || {};
          const retInfo = cmov.return_info || {};
          const stCls = cmov.status == 1 ? 'status-1' : 'status-0';
          const stTxt = cmov.status == 1 ? 'Active' : 'Returned';
          html += '<tr>';
          html += '<td>' + (i+1) + '</td>';
          html += '<td>' + (cmov.date || '-') + '</td>';
          html += '<td>' + (retInfo.date || '-') + '</td>';
          html += '<td>' + (emp.name || '-') + '</td>';
          html += '<td class="text-center"><span class="' + stCls + '">' + stTxt + '</span></td>';
          html += '<td>' + (cmov.note || '-') + '</td>';
          html += '</tr>';
        });
        html += '</tbody></table>';
      }

      $('#viewContractBody').html(html);
    })
    .fail(function(){
      $('#viewContractBody').html('<div class="text-center text-danger p-3">Failed to load contract details.</div>');
    });
}

/* ========== DELETE CONTRACT ========== */
function deleteContract(id){
  if(typeof Swal !== 'undefined'){
    Swal.fire({
      title: 'Delete Contract?',
      text: 'This will delete the contract and all its movements and installments.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete',
      cancelButtonText: 'Cancel'
    }).then(function(r){
      if(r.isConfirmed) doDelete(id);
    });
  } else {
    if(confirm('Are you sure you want to delete this contract?')) doDelete(id);
  }
}

function doDelete(id){
  showPreloader();
  $.ajax({
    url: API + '/' + id,
    method: 'DELETE',
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
    }
  })
  .done(function(res){
    const msg = res.message || 'Contract deleted!';
    if(typeof toastr !== 'undefined') toastr.success(msg);
    else alert(msg);
    loadContracts();
  })
  .fail(function(xhr){
    const msg = xhr.responseJSON?.message || 'Failed to delete contract.';
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(hidePreloader);
}

/* ========== RETURN MAID ========== */
function openReturnModal(movementId){
  $('#return_contract_id').val(movementId);
  setDatePickerValue('return_date', new Date());
  $('#return_note').val('');
  new bootstrap.Modal(document.getElementById('returnModal')).show();
}

function submitReturn(){
  const movementId = $('#return_contract_id').val();
  const date = $('#return_date').val();
  const note = $('#return_note').val();

  if(!date){ alert('Please enter a return date.'); return; }

  const btn = document.getElementById('btnSubmitReturn');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Submitting...';

  $.ajax({
    url: API + '/' + movementId + '/return',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({ 
      date: date, 
      note: note,
      status: 1,
      action: 1
    }),
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
    }
  })
  .done(function(res){
    const msg = res.message || 'Maid returned successfully!';
    if(typeof toastr !== 'undefined') toastr.success(msg);
    else alert(msg);
    bootstrap.Modal.getInstance(document.getElementById('returnModal'))?.hide();
    loadMovements();
  })
  .fail(function(xhr){
    let msg = 'Failed to return maid.';
    if(xhr.responseJSON){
      msg = xhr.responseJSON.message || '';
      if(xhr.responseJSON.error) msg += '\n' + xhr.responseJSON.error;
    }
    console.error('Return error:', xhr.responseJSON);
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function(){
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

/* ========== REPORT INCIDENT ========== */
function openIncidentModal(movementId){
  $('#incident_movement_id').val(movementId);
  setDatePickerValue('incident_date', new Date());
  $('#incident_status').val('');
  $('#incident_note').val('');
  new bootstrap.Modal(document.getElementById('incidentModal')).show();
}

function submitIncident(){
  const movementId = $('#incident_movement_id').val();
  const date = $('#incident_date').val();
  const status = $('#incident_status').val();
  const note = $('#incident_note').val();

  if(!date){ alert('Please enter an incident date.'); return; }
  if(!status){ alert('Please select a status.'); return; }

  const payload = {
    am_movment_id: movementId,
    date: date,
    status: parseInt(status),
    note: note
  };

  const btn = document.getElementById('btnSubmitIncident');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Submitting...';

  $.ajax({
    url: '/api/am-incidents',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify(payload),
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
    }
  })
  .done(function(res){
    const msg = res.message || 'Incident reported successfully!';
    if(typeof toastr !== 'undefined') toastr.success(msg);
    else alert(msg);
    bootstrap.Modal.getInstance(document.getElementById('incidentModal'))?.hide();
    loadMovements();
  })
  .fail(function(xhr){
    let msg = 'Failed to report incident.';
    if(xhr.responseJSON){
      msg = xhr.responseJSON.message || '';
      if(xhr.responseJSON.error) msg += '\n' + xhr.responseJSON.error;
    }
    console.error('Incident error:', xhr.responseJSON);
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function(){
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

/* ========== RETURN OFFICE TABLE ========== */
function loadReturns(page){
  page = page || 1;
  showPreloader();
  const params = {
    page: page,
    per_page: 20,
    search: $('#global_search').val() || '',
    date_from: $('#filter_from').val() || '',
    date_to: $('#filter_to').val() || '',
    status: $('#filter_status').val() || ''
  };
  $.getJSON('/api/am-return-maids', params)
    .done(function(res){ renderReturnsTable(res); })
    .fail(function(){ $('#returns_table').html('<div class="p-3 text-center text-muted">Failed to load return office.</div>'); })
    .always(hidePreloader);
}

function renderReturnsTable(res){
  const data = res.data || [];
  if(!data.length){
    $('#returns_table').html('<div class="p-3 text-center text-muted">No returns found.</div>');
    return;
  }
  let html = '<table class="table table-hover table-bordered mb-0"><thead><tr>';
  html += '<th>#</th><th>Date</th><th>Customer</th><th>Maid</th><th>Note</th><th>Status</th><th style="width:120px">Actions</th>';
  html += '</tr></thead><tbody>';

  data.forEach(function(ret, i){
    const mov = ret.contract_movment || {};
    const emp = mov.employee || {};
    const pc = mov.primary_contract || {};
    const crm = pc.crm || {};
    const customerName = ((crm.first_name || '') + ' ' + (crm.last_name || '')).trim();
    const idx = ((res.current_page - 1) * res.per_page) + i + 1;

    let actionBadge = '';
    let actionVal = parseInt(ret.action);
    if(actionVal == 1) actionBadge = '<span class="badge bg-warning text-dark">Pending</span>';
    else if(actionVal == 2) actionBadge = '<span class="badge bg-info text-dark">Replacement</span>';
    else if(actionVal == 3) actionBadge = '<span class="badge bg-success">Refund</span>';
    else if(actionVal == 4) actionBadge = '<span class="badge bg-danger">Due Amount</span>';
    else actionBadge = '<span class="text-muted">-</span>';
    
    // Actions column buttons
    let actionsHtml = '<button class="btn btn-outline-info action-btn btn-sm me-1" onclick="viewReturn(' + ret.id + ')" title="View"><i class="fas fa-eye"></i></button>';
    
    let repDisabled = (actionVal === 2 || actionVal === 3) ? 'disabled' : '';
    actionsHtml += '<button class="btn btn-outline-warning action-btn btn-sm me-1" onclick="openReplacementModal(' + ret.id + ')" title="Replacement" ' + repDisabled + '><i class="fas fa-people-arrows"></i></button>';

    let refundDisabled = (actionVal === 2 || actionVal === 3) ? 'disabled' : '';
    actionsHtml += '<button class="btn btn-outline-success action-btn btn-sm" onclick="openRefundModal(' + ret.id + ', ' + ret.am_movment_id + ')" title="Refund" ' + refundDisabled + '><i class="fas fa-hand-holding-usd"></i></button>';

    html += '<tr>';
    html += '<td class="text-center">' + idx + '</td>';
    html += '<td>' + (ret.date || '-') + '</td>';
    html += '<td>' + (customerName || '-') + ' <small class="text-muted">' + (crm.CL_Number || '') + '</small></td>';
    html += '<td>' + (emp.name || '-') + '</td>';
    html += '<td>' + (ret.note || '-') + '</td>';
    html += '<td class="text-center">' + actionBadge + '</td>';
    html += '<td class="text-center">' + actionsHtml + '</td>';
    html += '</tr>';
  });

  html += '</tbody></table>';
  html += renderPagination(res);
  $('#returns_table').html(html);
}

/* ========== INCIDENTS TABLE ========== */
function loadIncidents(page){
  page = page || 1;
  showPreloader();
  const params = {
    page: page,
    per_page: 20,
    search: $('#global_search').val() || '',
    date_from: $('#filter_from').val() || '',
    date_to: $('#filter_to').val() || '',
    status: $('#filter_status').val() || ''
  };
  $.getJSON('/api/am-incidents', params)
    .done(function(res){ renderIncidentsTable(res); })
    .fail(function(){ $('#incidents_table').html('<div class="p-3 text-center text-muted">Failed to load incidents.</div>'); })
    .always(hidePreloader);
}

function renderIncidentsTable(res){
  const data = res.data || [];
  if(!data.length){
    $('#incidents_table').html('<div class="p-3 text-center text-muted">No incidents found.</div>');
    return;
  }
  let html = '<table class="table table-hover table-bordered mb-0"><thead><tr>';
  html += '<th>#</th><th>Date</th><th>Customer</th><th>Maid</th><th>Note</th><th>Status</th><th style="width:120px">Actions</th>';
  html += '</tr></thead><tbody>';

  data.forEach(function(inc, i){
    const mov = inc.contract_movment || {};
    const emp = mov.employee || {};
    const pc = mov.primary_contract || {};
    const crm = pc.crm || {};
    const customerName = ((crm.first_name || '') + ' ' + (crm.last_name || '')).trim();
    const idx = ((res.current_page - 1) * res.per_page) + i + 1;

    let actionBadge = '';
    let statusVal = parseInt(inc.status);
    let actionVal = parseInt(inc.action);
    if(statusVal == 2) actionBadge = '<span class="badge bg-danger text-white">Ran Away</span>';
    else if(statusVal == 3) actionBadge = '<span class="badge bg-secondary">Cancelled</span>';
    else if(statusVal == 4) actionBadge = '<span class="badge bg-warning text-dark">Hold</span>';
    else actionBadge = '<span class="badge bg-dark">' + (inc.status_label || 'Unknown') + '</span>';
    
    // Actions column buttons
    let actionsHtml = '<button class="btn btn-outline-info action-btn btn-sm me-1" onclick="viewIncident(' + inc.id + ')" title="View"><i class="fas fa-eye"></i></button>';
    
    let repDisabled = (actionVal === 2 || actionVal === 3) ? 'disabled' : '';
    actionsHtml += '<button class="btn btn-outline-warning action-btn btn-sm me-1" onclick="openReplacementModal(' + inc.id + ')" title="Replacement" ' + repDisabled + '><i class="fas fa-people-arrows"></i></button>';

    let refundDisabled = (actionVal === 2 || actionVal === 3) ? 'disabled' : '';
    actionsHtml += '<button class="btn btn-outline-success action-btn btn-sm" onclick="openRefundModal(' + inc.id + ', ' + inc.am_movment_id + ')" title="Refund" ' + refundDisabled + '><i class="fas fa-hand-holding-usd"></i></button>';

    html += '<tr>';
    html += '<td class="text-center">' + idx + '</td>';
    html += '<td>' + (inc.date || '-') + '</td>';
    html += '<td>' + (customerName || '-') + ' <small class="text-muted">' + (crm.CL_Number || '') + '</small></td>';
    html += '<td>' + (emp.name || '-') + '</td>';
    html += '<td>' + (inc.note || '-') + '</td>';
    html += '<td class="text-center">' + actionBadge + '</td>';
    html += '<td class="text-center">' + actionsHtml + '</td>';
    html += '</tr>';
  });

  html += '</tbody></table>';
  html += renderPagination(res);
  $('#incidents_table').html(html);
}

/* ========== MAIDS PAYROLL TABLE ========== */
function loadPayroll(page){
  page = page || 1;
  showPreloader();
  const params = {
    page: page,
    year: $('#payroll_year').val(),
    month: $('#payroll_month').val(),
    per_page: 25
  };
  $.getJSON('/api/am-maid-payroll', params)
    .done(function(res){ renderPayrollTable(res); })
    .fail(function(xhr){
      let msg = 'Failed to load payroll.';
      if(xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
      $('#payroll_table').html('<div class="p-3 text-center text-danger">' + msg + '</div>');
    })
    .always(hidePreloader);
}

function renderPayrollTable(res){
  const data = res.data || [];
  if(!data.length){
    $('#payroll_table').html('<div class="p-3 text-center text-muted"><i class="fas fa-folder-open mb-2 text-secondary fs-4 d-block"></i>No payroll data found for this period.</div>');
    return;
  }
  let html = '<div class="table-responsive">';
  html += '<table class="table table-hover table-bordered mb-0">';
  html += '<thead class="table-light"><tr>';
  html += '<th class="text-center" style="width: 5%">#</th>';
  html += '<th style="width: 20%">Maid Information</th>';
  html += '<th style="width: 15%">Customer</th>';
  html += '<th class="text-center" style="width: 8%">Working Days</th>';
  html += '<th class="text-end" style="width: 8%">Base Salary</th>';
  html += '<th class="text-end" style="width: 9%">Deduction (Dr.)</th>';
  html += '<th class="text-end" style="width: 9%">Allowance (Cr.)</th>';
  html += '<th class="text-end" style="width: 9%">Net Salary</th>';
  html += '<th class="text-center" style="width: 12%">Notes</th>';
  html += '<th class="text-center" style="width: 5%">Actions</th>';
  html += '</tr></thead><tbody>';

  data.forEach(function(row, i){
    const idx = ((res.current_page - 1) * res.per_page) + i + 1;
    const maidName = row.maid_name || 'Unknown Maid';
    const maidId = row.employee_id ? `<span class="badge bg-secondary rounded-pill fw-normal ms-1 px-2 py-1" style="font-size: 0.7rem;">ID: ${row.employee_id}</span>` : '';
    
    const customer = row.last_customer_name || '<em class="text-muted text-xs">No Customer</em>';

    const baseSalary = parseFloat(row.maid_salary || 0).toFixed(2);
    const dr = parseFloat(row.total_deduction || 0).toFixed(2);
    const cr = parseFloat(row.total_allowance || 0).toFixed(2);
    const net = parseFloat(row.net_salary || 0).toFixed(2);
    const days = row.working_days ?? '-';
    
    // Full note display
    const note = row.deduction_note || '-';

    html += '<tr>';
    html += `<td class="text-center align-middle">${idx}</td>`;
    html += `<td><div class="fw-bold text-dark d-flex align-items-center">${maidName} ${maidId}</div></td>`;
    html += `<td>${customer}</td>`;
    html += `<td class="text-center"><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">${days}</span></td>`;
    html += `<td class="text-end text-muted fw-bold">${baseSalary}</td>`;
    
    html += `<td class="text-end">`;
    if(dr > 0) html += `<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">- ${dr}</span>`;
    else html += `<span class="text-muted small">0.00</span>`;
    html += `</td>`;

    html += `<td class="text-end">`;
    if(cr > 0) html += `<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">+ ${cr}</span>`;
    else html += `<span class="text-muted small">0.00</span>`;
    html += `</td>`;

    html += `<td class="text-end align-middle"><span class="fw-bolder fs-6 text-dark">${net}</span></td>`;
    html += `<td class="align-middle text-muted small">${note}</td>`;
    html += `<td class="text-center align-middle">
               <button class="btn btn-sm btn-info text-white shadow-sm" onclick="viewMaidBreakdown(${row.employee_id})" title="View Breakdown">
                 <i class="fas fa-eye"></i>
               </button>
             </td>`;
    html += '</tr>';
  });

  html += '</tbody></table></div>';
  html += '<div class="mt-3">' + renderPagination(res) + '</div>';
  $('#payroll_table').html(html);
}

/* ========== MAIDS PAYROLL BREAKDOWN ========== */
function viewMaidBreakdown(employeeId) {
  const year = $('#payroll_year').val();
  const month = $('#payroll_month').val();
  
  if (!year || !month) {
    alert("Please select a Year and Month first.");
    return;
  }

  $('#viewMaidBreakdownBody').html('<div class="text-center p-5"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2 text-muted">Loading Breakdown...</p></div>');
  new bootstrap.Modal(document.getElementById('viewMaidBreakdownModal')).show();

  $.getJSON(`/api/am-maid-payroll/${employeeId}?year=${year}&month=${month}`)
    .done(function(res) {
      const emp = res.employee || {};
      const moves = res.movements || [];
      const adjs = res.payroll_adjustments || [];
      
      let html = `<div class="p-3 bg-light border mb-4">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.7rem;">Employee Name</small>
                        <div class="fw-bold fs-5 text-dark">${emp.name || '-'}</div>
                      </div>
                      <div class="col-md-3">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.7rem;">Reference No</small>
                        <div class="fw-bold text-secondary">${emp.reference_no || '-'}</div>
                      </div>
                      <div class="col-md-3">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size:0.7rem;">Nationality</small>
                        <div class="text-dark">${emp.nationality || '-'}</div>
                      </div>
                    </div>
                  </div>`;

      // Movements Section
      html += `<h6 class="fw-bold text-secondary text-uppercase mb-3" style="font-size:0.8rem; letter-spacing:0.05rem;"><i class="fas fa-exchange-alt me-2 text-primary"></i>Contract Movements <span class="badge bg-secondary rounded-pill ms-2">${moves.length}</span></h6>`;
      if(moves.length === 0) {
        html += `<div class="alert alert-light border text-center text-muted">No movements found for this period.</div>`;
      } else {
        html += `<div class="table-responsive mb-4">
                  <table class="table table-sm table-hover table-bordered mb-0" style="font-size: 0.85rem">
                    <thead class="table-light">
                      <tr>
                        <th>Date</th>
                        <th>Customer</th>
                        <th class="text-center">Contract Ref</th>
                        <th>Status</th>
                        <th class="text-center">Working Days</th>
                      </tr>
                    </thead>
                    <tbody>`;
        moves.forEach(m => {
          let statusBadge = m.movement_status === 1 ? '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2">Active</span>' : '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2">Inactive</span>';
          html += `<tr>
                    <td class="align-middle">${m.movement_date || '-'}</td>
                    <td class="align-middle fw-bold">${m.customer_name || '-'} <small class="text-muted d-block">${m.customer_cl || ''}</small></td>
                    <td class="align-middle text-center"><span class="badge bg-light text-dark border">#${m.contract_id || '-'}</span></td>
                    <td class="align-middle">${statusBadge}</td>
                    <td class="align-middle text-center fw-bold text-primary">${m.working_days || 0}</td>
                  </tr>`;
        });
        html += `   </tbody>
                  </table>
                </div>`;
      }

      // Adjustments (Deductions/Allowances) Section
      html += `<h6 class="fw-bold text-secondary text-uppercase mb-3" style="font-size:0.8rem; letter-spacing:0.05rem;"><i class="fas fa-file-invoice-dollar me-2 text-warning"></i>Payroll Adjustments <span class="badge bg-secondary rounded-pill ms-2">${adjs.length}</span></h6>`;
      if(adjs.length === 0) {
        html += `<div class="alert alert-light border text-center text-muted">No deductions or allowances recorded for this period.</div>`;
      } else {
        html += `<div class="table-responsive mb-4">
                  <table class="table table-sm table-hover table-bordered mb-0" style="font-size: 0.85rem">
                    <thead class="table-light">
                      <tr>
                        <th>Date</th>
                        <th>Note</th>
                        <th class="text-end">Deduction (Dr.)</th>
                        <th class="text-end">Allowance (Cr.)</th>
                      </tr>
                    </thead>
                    <tbody>`;
        adjs.forEach(a => {
          const dr = parseFloat(a.amount_deduction || 0);
          const cr = parseFloat(a.amount_allowance || 0);
          html += `<tr>
                    <td class="align-middle">${a.deduction_date || '-'}</td>
                    <td class="align-middle text-muted">${a.note || '-'}</td>
                    <td class="align-middle text-end text-danger fw-bold">${dr > 0 ? '- '+dr.toFixed(2) : '-'}</td>
                    <td class="align-middle text-end text-success fw-bold">${cr > 0 ? '+ '+cr.toFixed(2) : '-'}</td>
                  </tr>`;
        });
        html += `   </tbody>
                  </table>
                </div>`;
      }

      // Summary Totals Footer
      const totalDays = res.total_working_days || 0;
      const baseSalary = parseFloat(emp.salary || 0).toFixed(2);
      const totalDr = parseFloat(res.total_deduction || 0).toFixed(2);
      const totalCr = parseFloat(res.total_allowance || 0).toFixed(2);
      const netSalary = parseFloat(res.net_salary || 0).toFixed(2);

      html += `<div class="row g-3">
                <div class="col-md-6">
                  <div class="p-3 bg-light border h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                      <span class="fw-bold text-secondary" style="font-size:0.9rem;">Total Working Days</span>
                      <span class="badge bg-primary rounded-pill px-3 py-1 fs-6">${totalDays}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                      <span class="fw-bold text-secondary" style="font-size:0.9rem;">Base Salary</span>
                      <strong class="text-dark fs-6">${baseSalary} AED</strong>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                   <div class="p-3 bg-light border h-100">
                     <div class="d-flex justify-content-between mb-2 pb-2 border-bottom text-muted" style="font-size:0.85rem;">
                       <span>Totals (Dr. / Cr.)</span>
                       <span><span class="text-danger me-2">-${totalDr}</span> <span class="text-success">+${totalCr}</span></span>
                     </div>
                     <div class="d-flex justify-content-between align-items-center mt-3">
                       <span class="text-uppercase fw-bold text-muted" style="letter-spacing:0.05rem;">Net Payout</span>
                       <span class="fs-4 fw-bolder text-info">${netSalary}</span>
                     </div>
                   </div>
                </div>
               </div>`;

      $('#viewMaidBreakdownBody').html(html);
    })
    .fail(function(xhr) {
      let emsg = "Failed to load breakdown.";
      if(xhr.responseJSON && xhr.responseJSON.message) emsg = xhr.responseJSON.message;
      $('#viewMaidBreakdownBody').html(`<div class="text-center p-4 alert alert-danger">${emsg}</div>`);
    });
}

/* ========== VIEW MOVEMENT ========== */
function viewMovement(id){
  $('#viewMovementBody').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
  new bootstrap.Modal(document.getElementById('viewMovementModal')).show();

  $.getJSON('/api/am-contract-movements/' + id)
    .done(function(m){
      const pc = m.primary_contract || {};
      const crm = pc.crm || {};
      const customerName = (crm.first_name || '') + ' ' + (crm.last_name || '');
      const emp = m.employee || {};
      const installments = m.installments || [];
      const retInfo = m.return_info || {};

      let statusBadge = '<span class="status-0">Returned</span>';
      if(m.status == 1) {
        statusBadge = '<span class="status-1">Active</span>';
      } else if(m.status > 1) {
        statusBadge = '<span class="badge bg-danger text-white">Incident</span>';
      }

      let html = '<div class="row g-3">';
      html += '<div class="col-md-6"><strong>Movement ID:</strong> ' + m.id + '</div>';
      html += '<div class="col-md-6"><strong>Status:</strong> ' + statusBadge + '</div>';
      html += '<div class="col-md-6"><strong>Customer:</strong> ' + customerName.trim() + ' <small class="text-muted">(' + (crm.CL_Number || '') + ')</small></div>';
      html += '<div class="col-md-6"><strong>Maid:</strong> ' + (emp.name || '-') + '</div>';
      html += '<div class="col-md-6"><strong>Start Date:</strong> ' + (m.date || '-') + '</div>';
      
      if(retInfo.date) {
        html += '<div class="col-md-6"><strong>Return Date:</strong> ' + retInfo.date + '</div>';
      }
      if(m.note) {
        html += '<div class="col-12"><strong>Note:</strong> ' + m.note + '</div>';
      }
      html += '</div>';

      if(installments.length){
        html += '<hr><h6 class="text-muted"><i class="fas fa-money-bill-wave me-1"></i>Installments (' + installments.length + ')</h6>';
        html += '<table class="table table-sm table-bordered"><thead><tr><th>#</th><th>Date</th><th>Amount</th><th>Status</th><th>Note</th></tr></thead><tbody>';
        installments.forEach(function(inst, i){
          const stCls = inst.status == 1 ? 'status-1' : 'status-0';
          const stTxt = inst.status == 1 ? 'Invoiced' : 'Pending';
          html += '<tr>';
          html += '<td>' + (i+1) + '</td>';
          html += '<td>' + (inst.date || '-') + '</td>';
          html += '<td class="text-end">' + parseFloat(inst.amount || 0).toFixed(2) + '</td>';
          html += '<td class="text-center"><span class="' + stCls + '">' + stTxt + '</span></td>';
          html += '<td>' + (inst.note || '-') + '</td>';
          html += '</tr>';
        });
        html += '</tbody></table>';
      }

      $('#viewMovementBody').html(html);
    })
    .fail(function(){
      $('#viewMovementBody').html('<div class="text-center text-danger p-3">Failed to load movement details.</div>');
    });
}

/* ========== EDIT MOVEMENT ========== */
function editMovement(id){
  showPreloader();
  $.getJSON('/api/am-contract-movements/' + id)
    .done(function(m){
      hidePreloader();
      $('#edit_movement_id').val(m.id);
      
      setDatePickerValue('edit_movement_date', m.date);

      $('#edit_movement_note').val(m.note || '');
      $('#edit_movement_maid_name').val(m.employee ? m.employee.name : '-');
      
      $('#editInstallmentBody').empty();
      if(m.installments && m.installments.length > 0) {
        m.installments.forEach(function(inst) {
          inst.date = formatDateForInput(inst.date);
          addEditInstallmentRow(inst);
        });
      } else {
        addEditInstallmentRow(); // Add one empty row if no existing installments
      }

      new bootstrap.Modal(document.getElementById('editMovementModal')).show();
    })
    .fail(function(){
      hidePreloader();
      alert('Failed to load movement.');
    });
}

/* ========== VIEW RETURN ========== */
function initReplacementMaidSelect2(){
  $('#replacement_new_employee_id').select2({
    dropdownParent: $('#replacementModal'),
    width: '100%',
    placeholder: 'Search replacement maid...',
    allowClear: true,
    ajax: {
      url: API + '/lookup-employees',
      dataType: 'json',
      delay: 300,
      data: function(params){ return { search: params.term || '' }; },
      processResults: function(data){
        const items = Array.isArray(data) ? data : (data.results || data.data || []);
        return {
          results: items.map(function(e){ return { id: e.id, text: e.name }; })
        };
      },
      cache: true
    },
    minimumInputLength: 0
  });
}

/* ========== REPLACEMENT MODAL ========== */
function openReplacementModal(returnId){
  $('#replacement_return_id').val(returnId);
  setDatePickerValue('replacement_date', new Date());
  resetSelect2('#replacement_new_employee_id');
  initReplacementMaidSelect2();
  new bootstrap.Modal(document.getElementById('replacementModal')).show();
}

function submitReplacement(){
  const returnId = $('#replacement_return_id').val();
  const dateStr = formatDateForInput($('#replacement_date').val());
  const newEmpId = $('#replacement_new_employee_id').val();

  if(!dateStr || !newEmpId){
    alert('Please select a replacement date and a new maid.');
    return;
  }

  const btn = document.getElementById('btnSubmitReplacement');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';

  $.ajax({
    url: '/api/am-return-maids/' + returnId + '/replacement',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({
      new_employee_id: newEmpId,
      date: dateStr
    }),
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
    }
  })
  .done(function(res){
    const msg = res.message || 'Replacement executed successfully.';
    if(typeof toastr !== 'undefined') toastr.success(msg);
    else alert(msg);
    bootstrap.Modal.getInstance(document.getElementById('replacementModal'))?.hide();
    loadCurrentTab();
  })
  .fail(function(xhr){
    let msg = 'Failed to execute replacement.';
    if(xhr.responseJSON){
      msg = xhr.responseJSON.message || msg;
      if(xhr.responseJSON.error) msg += '\n' + xhr.responseJSON.error;
    }
    console.error('Replacement error:', xhr.responseJSON);
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function(){
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

function viewReturn(id){
  $('#viewReturnBody').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
  new bootstrap.Modal(document.getElementById('viewReturnModal')).show();

  $.getJSON('/api/am-return-maids/' + id)
    .done(function(res){
      const r = res.data || res; // depends if it's paginated vs singular response. It should be singular.
      if (res.data === undefined && res.id) res = {data: res}; // normalize
      const data = res.data || res;
      
      const mov = data.contract_movment || {};
      const emp = mov.employee || {};
      const pc = mov.primary_contract || {};
      const crm = pc.crm || {};
      const customerName = ((crm.first_name || '') + ' ' + (crm.last_name || '')).trim();

      let actionBadge = '';
      let actionVal = parseInt(data.action);
      if(actionVal == 1) actionBadge = '<span class="badge bg-warning text-dark">Pending</span>';
      else if(actionVal == 2) actionBadge = '<span class="badge bg-info text-dark">Replacement</span>';
      else if(actionVal == 3) actionBadge = '<span class="badge bg-success">Refund</span>';
      else if(actionVal == 4) actionBadge = '<span class="badge bg-danger">Due Amount</span>';
      else actionBadge = '<span class="text-muted">-</span>';

      let html = '<div class="row g-3">';
      html += '<div class="col-md-6"><strong>Return ID:</strong> ' + data.id + '</div>';
      html += '<div class="col-md-6"><strong>Movement ID:</strong> ' + (data.am_movment_id || '-') + '</div>';
      html += '<div class="col-md-6"><strong>Action:</strong> ' + actionBadge + '</div>';
      html += '<div class="col-md-6"><strong>Customer:</strong> ' + (customerName || '-') + ' <small class="text-muted">(' + (crm.CL_Number || '') + ')</small></div>';
      html += '<div class="col-md-6"><strong>Maid:</strong> ' + (emp.name || '-') + '</div>';
      html += '<div class="col-md-6"><strong>Return Date:</strong> ' + (data.date || '-') + '</div>';
      if(data.note) {
        html += '<div class="col-12"><strong>Note:</strong> ' + data.note + '</div>';
      }
      html += '</div>';

      $('#viewReturnBody').html(html);
    })
    .fail(function(){
      $('#viewReturnBody').html('<div class="text-center text-danger p-3">Failed to load return details.</div>');
    });
}

function openInvoiceModal(instStr){
  try {
    const inst = JSON.parse(decodeURIComponent(instStr));
    
    $('#invoice_installment_id').val(inst.id);
    
    const mov = inst.contract_movment || {};
    const pc = mov.primary_contract || {};
    const crm = pc.crm || {};
    const emp = mov.employee || {};
    
    $('#lbl_invoice_customer').text((crm.first_name || '') + ' ' + (crm.last_name || ''));
    $('#lbl_invoice_maid').text(emp.name || '-');
    $('#lbl_invoice_date').text(inst.date || '-');
    $('#lbl_invoice_amount').text(parseFloat(inst.amount || 0).toFixed(2));
    
    new bootstrap.Modal(document.getElementById('invoiceModal')).show();
  } catch(e) {
    console.error("Failed to parse installment data", e);
    alert("Error reading installment data.");
  }
}

function submitInvoice(){
  const instId = $('#invoice_installment_id').val();
  if(!instId) return;

  const btn = document.getElementById('btnSubmitInvoice');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';

  $.ajax({
    url: '/api/am-monthly-invoices',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({ 
      installment_id: instId 
    }),
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
    }
  })
  .done(function(res){
    const msg = res.message || 'Invoice created successfully.';
    if(typeof toastr !== 'undefined') toastr.success(msg);
    else alert(msg);
    
    bootstrap.Modal.getInstance(document.getElementById('invoiceModal'))?.hide();
    loadCurrentTab();
  })
  .fail(function(xhr){
    let msg = 'Failed to create invoice.';
    if(xhr.responseJSON){
      msg = xhr.responseJSON.message || msg;
      
      // Specifically handle validation errors (like salary mapping check)
      if(xhr.responseJSON.errors) {
         let errs = [];
         for(let k in xhr.responseJSON.errors) {
            errs.push(xhr.responseJSON.errors[k].join('\n'));
         }
         msg += '\n\n' + errs.join('\n');
      } else if(xhr.responseJSON.error) {
         msg += '\n' + xhr.responseJSON.error;
      }
    }
    console.error('Invoice creation error:', xhr.responseJSON);
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function(){
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

function viewIncident(id){
  $('#viewIncidentBody').html('<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
  new bootstrap.Modal(document.getElementById('viewIncidentModal')).show();

  $.getJSON('/api/am-incidents/' + id)
    .done(function(res){
      const data = res.data || res;
      
      const mov = data.contract_movment || {};
      const emp = mov.employee || {};
      const pc = mov.primary_contract || {};
      const crm = pc.crm || {};
      const customerName = ((crm.first_name || '') + ' ' + (crm.last_name || '')).trim();

      let statusBadge = '';
      let statusVal = parseInt(data.status);
      if(statusVal == 2) statusBadge = '<span class="badge bg-danger text-white">Ran Away</span>';
      else if(statusVal == 3) statusBadge = '<span class="badge bg-secondary">Cancelled</span>';
      else if(statusVal == 4) statusBadge = '<span class="badge bg-warning text-dark">Hold</span>';
      else statusBadge = '<span class="badge bg-dark">' + (data.status_label || 'Unknown') + '</span>';

      let html = '<div class="row g-3">';
      html += '<div class="col-md-6"><strong>Incident ID:</strong> ' + data.id + '</div>';
      html += '<div class="col-md-6"><strong>Movement ID:</strong> ' + (data.am_movment_id || '-') + '</div>';
      html += '<div class="col-md-6"><strong>Status:</strong> ' + statusBadge + '</div>';
      html += '<div class="col-md-6"><strong>Customer:</strong> ' + (customerName || '-') + ' <small class="text-muted">(' + (crm.CL_Number || '') + ')</small></div>';
      html += '<div class="col-md-6"><strong>Maid:</strong> ' + (emp.name || '-') + '</div>';
      html += '<div class="col-md-6"><strong>Incident Date:</strong> ' + (data.date || '-') + '</div>';
      if(data.note) {
        html += '<div class="col-12"><strong>Note:</strong> ' + data.note + '</div>';
      }
      html += '</div>';

      $('#viewIncidentBody').html(html);
    })
    .fail(function(){
      $('#viewIncidentBody').html('<div class="text-center text-danger p-3">Failed to load incident details.</div>');
    });
}

function submitEditMovement(){
  const id = $('#edit_movement_id').val();
  const date = $('#edit_movement_date').val();
  const note = $('#edit_movement_note').val();
  
  // Collect installments
  const installments = [];
  let validInsts = true;
  $('#editInstallmentBody tr').each(function(){
    const instId = $(this).data('id');
    const iDate = $(this).find('.edit-inst-date').val();
    const amount = $(this).find('.edit-inst-amount').val();
    const iNote = $(this).find('.edit-inst-note').val();
    
    // Only require date/amount if the row isn't completely empty and it isn't a new row
    if(iDate || amount) {
        if(!iDate || !amount){ validInsts = false; return false; }
        const instData = { date: iDate, amount: parseFloat(amount), note: iNote || '' };
        if(instId) instData.id = parseInt(instId);
        installments.push(instData);
    }
  });

  if(!validInsts){ alert('Please fill in all modified installment dates and amounts.'); return; }
  
  const payload = { date: date, note: note, installments: installments };

  const btn = document.getElementById('btnSubmitEditMovement');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';

  $.ajax({
    url: '/api/am-contract-movements/' + id,
    method: 'PUT',
    contentType: 'application/json',
    data: JSON.stringify(payload),
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
    }
  })
  .done(function(res){
    const msg = res.message || 'Movement updated!';
    if(typeof toastr !== 'undefined') toastr.success(msg);
    else alert(msg);
    bootstrap.Modal.getInstance(document.getElementById('editMovementModal'))?.hide();
    loadMovements();
  })
  .fail(function(xhr){
    let msg = 'Failed to update movement.\\n';
    if(xhr.responseJSON) {
      if(xhr.responseJSON.errors) {
        msg += Object.values(xhr.responseJSON.errors).map(e => e.join(', ')).join('\\n');
      } else {
        msg += xhr.responseJSON.message || xhr.responseText;
      }
      if(xhr.responseJSON.error) {
          msg += '\\n' + xhr.responseJSON.error;
      }
    } else {
        msg += xhr.responseText;
    }
    console.error('Update movement error:', xhr);
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function(){
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

/* ========== DELETE MOVEMENT ========== */
function deleteMovement(id){
  if(typeof Swal !== 'undefined'){
    Swal.fire({
      title: 'Delete Movement?',
      text: 'This will delete the movement and its installments.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete',
      cancelButtonText: 'Cancel'
    }).then(function(r){
      if(r.isConfirmed) doDeleteMovement(id);
    });
  } else {
    if(confirm('Are you sure you want to delete this movement?')) doDeleteMovement(id);
  }
}

function doDeleteMovement(id){
  showPreloader();
  $.ajax({
    url: '/api/am-contract-movements/' + id,
    method: 'DELETE',
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
    }
  })
  .done(function(res){
    const msg = res.message || 'Movement deleted!';
    if(typeof toastr !== 'undefined') toastr.success(msg);
    else alert(msg);
    loadMovements();
  })
  .fail(function(xhr){
    const msg = xhr.responseJSON?.message || 'Failed to delete movement.';
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(hidePreloader);
}

/* ========== TAB SWITCHING ========== */
function loadCurrentTab(page){
  if(currentTab === 'contracts') loadContracts(page);
  else if(currentTab === 'movements') loadMovements(page);
  else if(currentTab === 'installments') loadInstallments(page);
  else if(currentTab === 'invoices') loadInvoices(page);
  else if(currentTab === 'returns') loadReturns(page);
  else if(currentTab === 'incidents') loadIncidents(page);
  else if(currentTab === 'refund-requests') loadRefundRequests(page);
  else if(currentTab === 'deductions') loadDeductions(page);
  else if(currentTab === 'payroll') loadPayroll(page);
}

/* ========== REFUND ========== */
function openRefundModal(returnId, movementId) {
  $('#refund_movement_id').val(movementId);
  setDatePickerValue('refund_date', new Date());
  $('#refund_amount').val('');
  $('#refund_note').val('');
  
  // Reset and show loading state for info section
  $('#lbl_refund_customer, #lbl_refund_maid, #lbl_refund_start_date, #lbl_refund_return_date').text('Loading...');
  $('#refundInfoSection').show();
  
  // Show Modal
  new bootstrap.Modal(document.getElementById('refundModal')).show();

  // Fetch Return details for display context
  $.getJSON('/api/am-return-maids/' + returnId)
    .done(function(res) {
      const data = res.data || res; // depending on pagination vs singular
      const pt_mov = data.contract_movment || {};
      const pt_emp = pt_mov.employee || {};
      const pt_pc  = pt_mov.primary_contract || {};
      const pt_crm = pt_pc.crm || {};
      
      const customerName = ((pt_crm.first_name || '') + ' ' + (pt_crm.last_name || '')).trim() || '-';
      
      $('#lbl_refund_customer').text(customerName);
      $('#lbl_refund_maid').text(pt_emp.name || '-');
      $('#lbl_refund_start_date').text(pt_pc.date || '-');
      $('#lbl_refund_return_date').text(data.date || '-');
    })
    .fail(function() {
      $('#lbl_refund_customer, #lbl_refund_maid, #lbl_refund_start_date, #lbl_refund_return_date').text('N/A (Error fetching details)');
    });
}

function submitRefund() {
  const movementId = $('#refund_movement_id').val();
  const date = $('#refund_date').val();
  const amount = $('#refund_amount').val();
  const note = $('#refund_note').val();
  
  if(!date){ alert('Please select a refund date.'); return; }
  if(!amount || parseFloat(amount) <= 0){ alert('Please enter a valid refund amount.'); return; }
  
  const payload = {
    am_contract_movement_id: parseInt(movementId),
    amount: parseFloat(amount),
    refund_date: date,
    note: note
  };
  
  const btn = document.getElementById('btnSubmitRefund');
  const origText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';
  
  $.ajax({
    url: '/api/amp3-action-notifies',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify(payload),
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
    }
  })
  .done(function(res){
    const msg = res.message || 'Refund processed successfully!';
    if(typeof toastr !== 'undefined') toastr.success(msg);
    else alert(msg);
    bootstrap.Modal.getInstance(document.getElementById('refundModal'))?.hide();
    loadCurrentTab(); // Refresh active tab (Return Office)
  })
  .fail(function(xhr){
    let msg = 'Failed to process refund.';
    if(xhr.responseJSON){
      if(xhr.responseJSON.errors) {
        msg = Object.values(xhr.responseJSON.errors).map(e => e.join(', ')).join('\n');
      } else {
        msg = xhr.responseJSON.message || '';
        if(xhr.responseJSON.error) msg += '\n' + xhr.responseJSON.error;
      }
    }
    console.error('Refund error:', xhr);
    if(typeof toastr !== 'undefined') toastr.error(msg);
    else alert(msg);
  })
  .always(function(){
    btn.disabled = false;
    btn.innerHTML = origText;
  });
}

/* ========== INIT ========== */
$(function(){
  // Set payroll defaults to current year/month
  const now = new Date();
  $('#payroll_year').val(now.getFullYear());
  $('#payroll_month').val(now.getMonth() + 1);

  // Read hash from URL to determine initial tab
  const hash = window.location.hash;
  if (hash) {
      if(hash === '#tab-movements') currentTab = 'movements';
      else if(hash === '#tab-installments') currentTab = 'installments';
      else if(hash === '#tab-invoices') currentTab = 'invoices';
      else if(hash === '#tab-returns') currentTab = 'returns';
      else if(hash === '#tab-incidents') currentTab = 'incidents';
      else if(hash === '#tab-refund-requests') currentTab = 'refund-requests';
      else if(hash === '#tab-deductions') currentTab = 'deductions';
      else if(hash === '#tab-payroll') currentTab = 'payroll';
      else currentTab = 'contracts';
      
      // Activate the corresponding tab visually
      $('#mainTabs a[href="' + hash + '"]').tab('show');
  }

  // Load initial data
  loadCurrentTab();

  // Tab switching
  $('#mainTabs a').on('click', function(e){
    e.preventDefault();
    $(this).tab('show');
    const href = $(this).attr('href');
    
    // Update URL hash without jumping page
    history.replaceState(null, null, href);

    if(href === '#tab-movements') currentTab = 'movements';
    else if(href === '#tab-installments') currentTab = 'installments';
    else if(href === '#tab-invoices') currentTab = 'invoices';
    else if(href === '#tab-returns') currentTab = 'returns';
    else if(href === '#tab-incidents') currentTab = 'incidents';
    else if(href === '#tab-refund-requests') currentTab = 'refund-requests';
    else if(href === '#tab-deductions') currentTab = 'deductions';
    else if(href === '#tab-payroll') currentTab = 'payroll';
    else currentTab = 'contracts';
    loadCurrentTab();
  });

  // Search
  let searchTimer;
  $('#global_search').on('input', function(){
    const v = this.value.trim();
    v ? $('#clear_search').show() : $('#clear_search').hide();
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function(){ loadCurrentTab(); }, 300);
  });

  $('#clear_search').on('click', function(){
    $('#global_search').val('').focus();
    $(this).hide();
    loadCurrentTab();
  });

  // Filters
  $('#btn_apply_filters').on('click', function(){ loadCurrentTab(); });
  $('#btn_reset_filters').on('click', function(){
    $('#filter_from,#filter_to').val('');
    $('#filter_status').val('');
    $('#global_search').val('');
    $('#clear_search').hide();
    loadCurrentTab();
  });

  // Reload
  $('#btn_reload').on('click', function(){ loadCurrentTab(); });

  // Pagination
  $(document).on('click', '.pagination a[data-page]', function(e){
    e.preventDefault();
    const page = parseInt($(this).data('page'));
    if(page) loadCurrentTab(page);
  });
});
</script>
