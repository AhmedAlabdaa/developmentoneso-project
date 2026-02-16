<style>
.table-container {
    width: 100%;
    overflow-x: auto;
    position: relative;
}
.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
.table th, .table td {
    padding: 10px 15px;
    text-align: left;
    vertical-align: middle;
    border-bottom: 1px solid #ddd;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.table th {
    background-color: #343a40;
    color: white;
    text-transform: uppercase;
    font-weight: bold;
}
.table-hover tbody tr:hover {
    background-color: #f1f1f1;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9f9f9;
}
.actions {
    display: flex;
    gap: 5px;
}
.btn-icon-only {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px;
    border-radius: 50%;
    font-size: 12px;
    width: 30px;
    height: 30px;
    color: white;
}
.btn-info {
    background-color: #17a2b8;
}
.btn-warning {
    background-color: #ffc107;
}
.btn-danger {
    background-color: #dc3545;
}
.sticky-table th:last-child,
.sticky-table td:last-child {
    position: sticky;
    right: 0;
    background-color: white;
    z-index: 2;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
    min-width: 150px;
}
.modal .table th:last-child,
.modal .table td:last-child {
    position: static;
}
.table th:last-child {
    z-index: 3;
}
.status-dropdown {
    padding: 5px;
    font-size: 12px;
    border-radius: 5px;
    transition: background-color 0.3s;
    width: 150px;
    color: #000;
    font-weight: bold;
    text-transform: uppercase;
}
.status-dropdown.approved {
    background-color: #28a745;
}
.status-dropdown.pending {
    background-color: #ffc107;
}
.status-dropdown.rejected {
    background-color: #dc3545;
}
.status-dropdown.review {
    background-color: #17a2b8;
}
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
.scrollable-modal-body {
    max-height: 500px;
    overflow-y: auto;
}
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Reference No</th>
                <th>Agreement Type</th>
                <th>Candidate Name</th>
                <th>Package</th>
                <th>Status</th>
                <th>CN #</th>
                <th>Visa Status</th>
                <th>CL #</th>
                <th>Created At</th>
                <th>Client</th>
                <th>Foreign Partner</th>
                <th>Nationality</th>
                <th>Passport No</th>
                <th>Passport Expiry Date</th>
                <th>Date of Birth</th>
                <th>Salary</th>
                <th>Agreement Start Date</th>
                <th>Agreement End Date</th>
                <th>Number of Days</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agreements as $agreement)
            <tr>
                <td>{{ $agreement->reference_no ?? '' }}</td>
                <td>{{ $agreement->agreement_type }}</td>
                <td>{{ $agreement->candidate_name }}</td>
                <td>{{ $agreement->package }}</td>
                <td>
                    @switch((int) $agreement->status)
                        @case(1)
                            <i class="fas fa-clock text-warning status-icon" title="Pending"></i> Pending
                            @break
                        @case(2)
                            <i class="fas fa-circle-check text-success status-icon" title="Active"></i> Active
                            @break
                        @case(3)
                            <i class="fas fa-triangle-exclamation text-warning status-icon" title="Exceeded"></i> Exceeded
                            @break
                        @case(4)
                            <i class="fas fa-circle-xmark text-danger status-icon" title="Rejected"></i> Rejected
                            @break
                        @case(5)
                            <i class="fas fa-file-signature text-primary status-icon" title="Contracted"></i> Contracted
                            @break
                        @case(6)
                            <i class="fas fa-calendar-plus text-info status-icon" title="Extended"></i> Extended
                            @break
                        @default
                            <i class="fas fa-circle-question text-secondary status-icon" title="Unknown"></i> Unknown
                    @endswitch
                </td>
                <td>
                    <a href="{{ route('candidates.show', $agreement->reference_of_candidate) }}" class="text-primary" target="_blank">
                        {{ $agreement->CN_Number }}
                    </a>
                </td>
                <td>-</td>
                <td>
                    <a href="{{ route('crm.show', $agreement->client->slug) }}" class="text-primary" target="_blank">
                        {{ $agreement->CL_Number }}
                    </a>
                </td>
                <td>{{ \Carbon\Carbon::parse($agreement->created_at)->format('d-m-Y H:i:s') }}</td>
                <td>
                    @if ($agreement->client)
                        <a href="{{ route('crm.show', $agreement->client->slug) }}" class="text-primary">
                            {{ $agreement->client->name ?? '' }}
                        </a>
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ explode(' ', $agreement->foreign_partner)[0] . ' ' . last(explode('-', $agreement->foreign_partner)) }}</td>
                <td>{{ $agreement->Nationality->name ?? ''}}</td>
                <td>{{ $agreement->passport_no }}</td>
                <td>{{ \Carbon\Carbon::parse($agreement->passport_expiry_date)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($agreement->date_of_birth)->format('d-m-Y') }}</td>
                <td>{{ number_format($agreement->salary, 2) }}</td>
                <td>{{ $agreement->agreement_start_date ? \Carbon\Carbon::parse($agreement->agreement_start_date)->format('d-m-Y') : 'N/A' }}</td>
                <td>{{ $agreement->agreement_end_date ? \Carbon\Carbon::parse($agreement->agreement_end_date)->format('d-m-Y') : 'N/A' }}</td>
                <td>{{ $agreement->number_of_days ?? 'NA' }}</td>
                <td>{{ $agreement->notes ?? 'NA' }}</td>
                <td class="actions">
                    <a href="{{ route('agreements.show', $agreement->reference_no) }}" class="btn btn-info btn-icon-only" target="_blank" title="View Details">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('agreements.print', $agreement->reference_no) }}" class="btn btn-primary btn-icon-only" title="Print">
                        <i class="fas fa-print"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Reference No</th>
                <th>Agreement Type</th>
                <th>Candidate Name</th>
                <th>Package</th>
                <th>Status</th>
                <th>CN #</th>
                <th>Visa Status</th>
                <th>CL #</th>
                <th>Created At</th>
                <th>Client</th>
                <th>Foreign Partner</th>
                <th>Nationality</th>
                <th>Passport No</th>
                <th>Passport Expiry Date</th>
                <th>Date of Birth</th>
                <th>Salary</th>
                <th>Agreement Start Date</th>
                <th>Agreement End Date</th>
                <th>Number of Days</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
@if($agreements->count())
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing {{ $agreements->firstItem() }} to {{ $agreements->lastItem() }} of {{ $agreements->total() }} results
        </span>
        <ul class="pagination justify-content-center">
            {{ $agreements->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>
@endif

<script>
function updateTimeLeft() {
    document.querySelectorAll('.time-left').forEach((element) => {
        const expiryData = element.getAttribute('data-expiry');
        if (!expiryData || isNaN(new Date(expiryData).getTime())) {
            element.innerHTML = `<i class="fas fa-exclamation-triangle text-warning"></i> No expiry date set`;
            element.style.color = 'gray';
            return;
        }
        const expiryDate = new Date(expiryData);
        const now = new Date();
        const diff = expiryDate - now;
        if (diff > 0) {
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            element.innerHTML = `<i class="fas fa-clock text-warning"></i> ${days}d ${hours}h ${minutes}m ${seconds}s left`;
            element.style.color = '';
        } else {
            const overdue = Math.abs(diff);
            const days = Math.floor(overdue / (1000 * 60 * 60 * 24));
            const hours = Math.floor((overdue % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((overdue % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((overdue % (1000 * 60)) / 1000);
            element.innerHTML = `<i class="fas fa-clock text-danger"></i> Expired<br><span style="color: red;">-${days}d ${hours}h ${minutes}m ${seconds}s</span>`;
        }
    });
}
setInterval(updateTimeLeft, 1000);

$(document).ready(function () {
    $(document).on('click', '.btn-dark', function () {
        const referenceNo = $(this).closest('tr').find('td:first').text();
        const row = $(this).closest('tr');
        const candidateName = row.find('td:nth-child(3)').text();
        const clientName = row.find('td:nth-child(10)').text();
        const startDate = row.find('td:nth-child(24)').text();
        const endDate = row.find('td:nth-child(25)').text();
        const modal = $(`#convertToContractModal${referenceNo}`);
        modal.find('#candidate_name').val(candidateName.trim());
        modal.find('#client_name').val(clientName.trim());
        modal.find('#contract_start_date').val(startDate.trim() !== 'NA' ? startDate.trim() : '');
        modal.find('#contract_end_date').val(endDate.trim() !== 'NA' ? endDate.trim() : '');
        modal.find('input[name="reference_no"]').val(referenceNo);
        modal.modal('show');
    });
    $(document).on('click', '#convert_to_contract', function () {
        const modal = $(this).closest('.modal');
        let isValid = true;
        modal.find('input[required], select[required]').each(function () {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
                $(this).after('<div class="invalid-feedback">This field is required.</div>');
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        });
        if (!isValid) {
            toastr.error('Please fill all required fields.');
            return;
        }
        const formData = new FormData();
        formData.append('reference_no', modal.find('input[name="reference_no"]').val());
        formData.append('agreement_reference_no', modal.find('input[name="agreement_reference_no"]').val());
        formData.append('agreement_type', modal.find('input[name="agreement_type"]').val());
        formData.append('candidate_id', modal.find('input[name="candidate_id"]').val());
        formData.append('reference_of_candidate', modal.find('input[name="reference_of_candidate"]').val());
        formData.append('package', modal.find('input[name="package"]').val());
        formData.append('foreign_partner', modal.find('input[name="foreign_partner"]').val());
        formData.append('client_id', modal.find('input[name="client_id"]').val());
        formData.append('CN_Number', modal.find('input[name="CN_Number"]').val());
        formData.append('CL_Number', modal.find('input[name="CL_Number"]').val());
        formData.append('contract_start_date', modal.find('input[name="contract_start_date"]').val());
        formData.append('contract_end_date', modal.find('input[name="contract_end_date"]').val());
        formData.append('maid_delivered', modal.find('select[name="maid_delivered"]').val());
        formData.append('transferred_date', modal.find('input[name="transferred_date"]').val());
        formData.append('remarks', modal.find('textarea[name="remarks"]').val());
        const contractSignedCopy = modal.find('input[name="contract_signed_copy"]')[0].files[0];
        if (contractSignedCopy) {
            formData.append('contract_signed_copy', contractSignedCopy);
        } else {
            toastr.error('Contract signed copy is required.');
            modal.find('input[name="contract_signed_copy"]').addClass('is-invalid');
            return;
        }
        $.ajax({
            url: '{{ route('contracts.store') }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                toastr.success('Contract converted successfully!');
                modal.modal('hide');
                location.reload();
            },
            error: function (xhr) {
                if (xhr.responseJSON?.errors) {
                    const errors = xhr.responseJSON.errors;
                    for (const [field, messages] of Object.entries(errors)) {
                        const input = modal.find(`[name="${field}"]`);
                        input.addClass('is-invalid');
                        input.next('.invalid-feedback').remove();
                        input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    }
                } else {
                    toastr.error('An error occurred while processing your request.');
                }
            }
        });
    });
    $(document).on('input change', 'input, select', function () {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    });
});
</script>
