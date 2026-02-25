@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
  body { background: linear-gradient(to right, #e0f7fa, #e1bee7); font-family: Arial, sans-serif; }
  .table th, .table td { vertical-align: middle; }
  .table-responsive { margin-top: 20px; }
  .btn { transition: background-color .2s, color .2s; }
  .btn:hover { background-color: #007bff; color: #fff; }
  .card-title { font-weight: normal; }
  .table thead th { background: linear-gradient(to right, #007bff, #00c6ff); color: #fff; text-align: center; font-weight: normal; }
  .btn-primary { background: linear-gradient(to right, #007bff, #00c6ff); border: none; }
  .input-group-text { cursor: pointer; }
  .preloader { padding: 20px; text-align: center; }
  .badge { font-size: 11px; padding: 4px 8px; }
  .modal-header { background: linear-gradient(to right, #007bff, #00c6ff); color: #fff; }
  .modal-header .btn-close { filter: brightness(0) invert(1); }
  .modal-header .btn-close-white { filter: brightness(0) invert(1); }
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card flex-fill">
          <div class="card-body">

            <div class="row mb-3 align-items-center">
              <div class="col-lg-4">
                <h5 class="card-title mb-0">Ledger of Accounts</h5>
              </div>
              <div class="col-lg-4">
                <div class="input-group">
                  <input type="text" class="form-control" id="global_search" placeholder="Search by Name, Group, or Note">
                  <span class="input-group-text clear-filter" style="cursor: pointer;">
                    <i class="fas fa-times"></i>
                  </span>
                  <button class="btn btn-outline-secondary" type="button" id="global_search_btn">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
              <div class="col-lg-4 text-lg-end mt-2 mt-lg-0">
                <button type="button" class="btn btn-primary me-2" id="add_ledger_btn">
                  <i class="fas fa-plus-circle"></i> Add Ledger
                </button>
                <button type="button" class="btn btn-success" id="export_excel_btn">
                  <i class="fas fa-file-excel"></i> Export Excel
                </button>
              </div>
            </div>

            <div id="alert_container"></div>

            <div class="table-responsive" id="ledger_table">
              <x-ui.loader />
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<x-ledgers.form-modal />
<x-ledgers.delete-modal />

@include('../layout.footer')

<script>
/**
 * LedgerManager
 * Handles all logic for the Ledger of Accounts management page
 */
class LedgerManager {
    constructor(apiBase) {
        this.apiBase = apiBase;
        this.currentPage = 1;
        this.searchQuery = '';
        this.debounceTimer = null;
        this.ledgerToDelete = null;
        this.ledgerModal = null;
        this.deleteModal = null;

        this.init();
    }

    init() {
        this.cacheDom();
        this.bindEvents();
        this.loadLedgers();
    }

    cacheDom() {
        // Modals
        this.ledgerModalElement = document.getElementById('ledgerModal');
        this.deleteModalElement = document.getElementById('deleteModal');
        
        // Forms & Inputs
        this.ledgerForm = document.getElementById('ledger_form');
        this.ledgerIdInput = document.getElementById('ledger_id');
        this.globalSearch = document.getElementById('global_search');
        
        // Buttons
        this.addBtn = document.getElementById('add_ledger_btn');
        this.saveBtn = document.getElementById('save_ledger_btn');
        this.searchBtn = document.getElementById('global_search_btn');
        this.clearFilterBtn = document.querySelector('.clear-filter');
        this.exportBtn = document.getElementById('export_excel_btn');
        this.confirmDeleteBtn = document.getElementById('confirm_delete_btn');
        
        // Containers
        this.tableContainer = document.getElementById('ledger_table');
        this.alertContainer = document.getElementById('alert_container');
        this.preloader = document.querySelector('.preloader');
    }

    bindEvents() {
        // Initialize Bootstrap validation on modals
        this.ledgerModal = new bootstrap.Modal(this.ledgerModalElement);
        this.deleteModal = new bootstrap.Modal(this.deleteModalElement);

        this.addBtn.addEventListener('click', () => this.openCreateModal());
        this.saveBtn.addEventListener('click', () => this.saveLedger());
        this.confirmDeleteBtn.addEventListener('click', () => this.confirmDelete());
        
        this.globalSearch.addEventListener('input', (e) => {
            this.searchQuery = e.target.value;
            this.currentPage = 1;
            this.loadLedgers(1, this.searchQuery);
        });

        this.searchBtn.addEventListener('click', () => this.loadLedgers(1, this.searchQuery));
        
        this.clearFilterBtn.addEventListener('click', () => {
            this.globalSearch.value = '';
            this.searchQuery = '';
            this.loadLedgers(1, '');
        });

        this.exportBtn.addEventListener('click', () => {
            window.location.href = '/api/ledgers/export';
        });
    }

    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    showAlert(message, type = 'success') {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <div>${message}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        this.alertContainer.innerHTML = alertHtml;
        setTimeout(() => {
            if (this.alertContainer) this.alertContainer.innerHTML = '';
        }, 5000);
    }

    async loadLedgers(page = 1, search = '', forceRefresh = false) {
        if (forceRefresh) {
            clearTimeout(this.debounceTimer);
            await this.fetchLedgers(page, search);
            return;
        }

        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(async () => {
            await this.fetchLedgers(page, search);
        }, 300);
    }

    async fetchLedgers(page, search) {
        try {
            if (this.preloader) this.preloader.style.display = 'block';

            const params = new URLSearchParams({
                page: page,
                per_page: 10,
                search: search
            });

            const response = await fetch(`${this.apiBase}?${params}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to load ledgers');

            const data = await response.json();
            this.renderTable(data);

            const preloaderAfter = document.querySelector('.preloader');
            if (preloaderAfter) preloaderAfter.style.display = 'none';
        } catch (error) {
            console.error('Error loading ledgers:', error);
            const preloaderError = document.querySelector('.preloader');
            if (preloaderError) preloaderError.style.display = 'none';
            this.showAlert('Failed to load ledgers', 'danger');
        }
    }

    renderTable(data) {
        const ledgers = data.data || [];
        const meta = data.meta || {};

        let html = `
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Sub Class</th>
                        <th>Group</th>
                        <th>Type</th>
                        <th>Special</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
        `;

        if (ledgers.length === 0) {
            html += `<tr><td colspan="9" class="text-center">No ledger accounts found</td></tr>`;
        } else {
            ledgers.forEach(ledger => {
                const classLabels = {1: 'Asset', 2: 'Liability', 3: 'Equity', 4: 'Income', 5: 'Expense'};
                const subClassLabels = {
                    1: 'Current Asset', 2: 'Non Current Asset', 3: 'Current Liability',
                    4: 'Non Current Liability', 5: 'Equity', 6: 'Income', 7: 'Expense',
                    8: 'Cost of Sales (COGS)'
                };
                const spacialLabels = {
                    0: 'None',
                    1: 'MAID Assets',
                    2: 'Payment Method',
                    3: 'Customer'
                };

                const spacialValue = ledger.spacial ?? 0;
                const spacialLabel = spacialLabels[spacialValue] || spacialValue;
                const spacialBadgeClass = spacialValue === 0 ? 'bg-secondary' : 'bg-warning';

                html += `
                    <tr>
                        <td>${ledger.id}</td>
                        <td>
                            <a href="/finance/statement-of-account/${ledger.id}" target="_blank" class="fw-bold text-decoration-none text-dark">
                                ${ledger.name} <i class="fas fa-external-link-alt ms-1 text-muted small"></i>
                            </a>
                        </td>
                        <td><span class="badge bg-primary">${classLabels[ledger.class] || ledger.class}</span></td>
                        <td><span class="badge bg-info">${subClassLabels[ledger.sub_class] || ledger.sub_class}</span></td>
                        <td>${ledger.group || '-'}</td>
                        <td><span class="badge bg-${ledger.type === 'dr' ? 'success' : 'warning'}">${ledger.type.toUpperCase()}</span></td>
                        <td><span class="badge ${spacialBadgeClass}">${spacialLabel}</span></td>
                        <td>${ledger.created_by?.name || 'N/A'}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="${ledger.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${ledger.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }

        html += `</tbody></table>`;

        if (meta.last_page > 1) {
            html += this.renderPagination(meta);
        }

        this.tableContainer.innerHTML = html;
        this.attachTableEventListeners();
    }

    renderPagination(meta) {
        let html = '<nav><ul class="pagination justify-content-center">';
        
        html += `<li class="page-item ${meta.current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${meta.current_page - 1}">Previous</a>
        </li>`;

        for (let i = 1; i <= meta.last_page; i++) {
            if (i === 1 || i === meta.last_page || (i >= meta.current_page - 2 && i <= meta.current_page + 2)) {
                html += `<li class="page-item ${i === meta.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
            } else if (i === meta.current_page - 3 || i === meta.current_page + 3) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }

        html += `<li class="page-item ${meta.current_page === meta.last_page ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${meta.current_page + 1}">Next</a>
        </li>`;

        html += '</ul></nav>';
        return html;
    }

    attachTableEventListeners() {
        // Edit buttons
        this.tableContainer.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => this.editLedger(btn.dataset.id));
        });

        // Delete buttons
        this.tableContainer.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => this.initiateDelete(btn.dataset.id));
        });

        // Pagination
        this.tableContainer.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = parseInt(link.dataset.page);
                if (page && page > 0) {
                    this.currentPage = page;
                    this.loadLedgers(page, this.searchQuery);
                }
            });
        });
    }

    openCreateModal() {
        document.getElementById('ledgerModalLabel').textContent = 'Add Ledger Account';
        this.ledgerForm.reset();
        this.ledgerIdInput.value = '';
        this.clearValidationErrors();
        this.ledgerModal.show();
    }

    async editLedger(id) {
        try {
            const response = await fetch(`${this.apiBase}/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to fetch ledger');

            const result = await response.json();
            const ledger = result.data;

            document.getElementById('ledgerModalLabel').textContent = 'Edit Ledger Account';
            this.ledgerIdInput.value = ledger.id;
            document.getElementById('name').value = ledger.name;
            document.getElementById('class').value = ledger.class;
            document.getElementById('sub_class').value = ledger.sub_class;
            document.getElementById('group').value = ledger.group || '';
            document.getElementById('type').value = ledger.type;
            document.getElementById('spacial').value = ledger.spacial;
            document.getElementById('note').value = ledger.note || '';

            this.clearValidationErrors();
            this.ledgerModal.show();
        } catch (error) {
            console.error('Error fetching ledger:', error);
            this.showAlert('Failed to load ledger data', 'danger');
        }
    }

    async saveLedger() {
        const id = this.ledgerIdInput.value;
        const formData = {
            name: document.getElementById('name').value,
            class: parseInt(document.getElementById('class').value),
            sub_class: parseInt(document.getElementById('sub_class').value),
            group: document.getElementById('group').value || null,
            type: document.getElementById('type').value,
            spacial: parseInt(document.getElementById('spacial').value),
            note: document.getElementById('note').value || null
        };

        this.saveBtn.disabled = true;
        this.saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        try {
            const url = id ? `${this.apiBase}/${id}` : this.apiBase;
            const method = id ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                credentials: 'same-origin',
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (!response.ok) {
                if (response.status === 422) {
                    this.displayValidationErrors(result.errors);
                    this.showAlert('Please fix the validation errors', 'danger');
                    this.saveBtn.disabled = false;
                    this.saveBtn.innerHTML = '<i class="fas fa-save"></i> Save';
                    return;
                }
                throw new Error(result.message || 'Failed to save ledger');
            }

            this.ledgerModal.hide();
            this.showAlert(id ? 'Ledger updated successfully' : 'Ledger created successfully', 'success');
            await this.loadLedgers(this.currentPage, this.searchQuery, true);
            this.saveBtn.disabled = false;
            this.saveBtn.innerHTML = '<i class="fas fa-save"></i> Save';
            
        } catch (error) {
            console.error('Error saving ledger:', error);
            this.showAlert(error.message || 'Failed to save ledger', 'danger');
            this.saveBtn.disabled = false;
            this.saveBtn.innerHTML = '<i class="fas fa-save"></i> Save';
        }
    }

    initiateDelete(id) {
        this.ledgerToDelete = id;
        this.deleteModal.show();
    }

    async confirmDelete() {
        if (!this.ledgerToDelete) return;

        this.confirmDeleteBtn.disabled = true;
        this.confirmDeleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';

        try {
            const response = await fetch(`${this.apiBase}/${this.ledgerToDelete}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Failed to delete ledger');

            this.deleteModal.hide();
            this.showAlert('Ledger deleted successfully', 'success');
            await this.loadLedgers(this.currentPage, this.searchQuery, true);
            
            this.ledgerToDelete = null;
            this.confirmDeleteBtn.disabled = false;
            this.confirmDeleteBtn.innerHTML = '<i class="fas fa-trash"></i> Delete';
        } catch (error) {
            console.error('Error deleting ledger:', error);
            this.showAlert('Failed to delete ledger', 'danger');
            this.confirmDeleteBtn.disabled = false;
            this.confirmDeleteBtn.innerHTML = '<i class="fas fa-trash"></i> Delete';
        }
    }

    displayValidationErrors(errors) {
        this.clearValidationErrors();
        Object.keys(errors).forEach(field => {
            const input = document.getElementById(field);
            const errorDiv = document.getElementById(`${field}_error`);
            if (input && errorDiv) {
                input.classList.add('is-invalid');
                errorDiv.textContent = errors[field][0];
            }
        });
    }

    clearValidationErrors() {
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new LedgerManager('/api/ledgers');
});
</script>
