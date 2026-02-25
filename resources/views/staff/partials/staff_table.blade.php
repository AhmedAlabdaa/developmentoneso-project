<style>
.table-container {
    width: 100%;
    overflow-x: auto;
    position: relative;
}
.table {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto;
    border-spacing: 0;
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
@media screen and (max-width: 768px) {
    .table th, .table td {
        padding: 8px 12px;
    }
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
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th title="Reference Number">Ref #</th>
                <th title="Name of Staff">Name</th>
                <th title="Nationality">Nat</th>
                <th title="Passport Number">PP #</th>
                <th title="Passport Expiry Date">PP Exp</th>
                <th title="Status">Stat</th>
                <th title="Date of Joining">DoJ</th>
                <th title="Actual Designation">Act Desig</th>
                <th title="Visa Designation">Visa Desig</th>
                <th title="Gender">Gen</th>
                <th title="Date of Birth">DOB</th>
                <th title="Marital Status">Mar Stat</th>
                <th title="Contract Start Date">Start</th>
                <th title="Contract End Date">End</th>
                <th title="Contract Type">Type</th>
                <th title="File Entry Permit Number">FEP #</th>
                <th title="UID Number">UID #</th>
                <th title="Contact Number">Contact #</th>
                <th title="Temporary Work Permit Number">TWP #</th>
                <th title="Temporary Work Permit Expiry Date">TWP Exp</th>
                <th title="Personal Number">Pers #</th>
                <th title="Labor Card Number">LC #</th>
                <th title="Labor Card Expiry Date">LC Exp</th>
                <th title="Residence Visa Start Date">RV Start</th>
                <th title="Residence Visa Expiry Date">RV Exp</th>
                <th title="Emirates ID Number">EID #</th>
                <th title="EID Expiry Date">EID Exp</th>
                <th title="Salary As Per Contract">Salary</th>
                <th title="Basic Salary">Basic</th>
                <th title="Housing Allowance">House</th>
                <th title="Transport Allowance">Trans</th>
                <th title="Other Allowances">Other</th>
                <th title="Total Salary">Total</th>
                <th title="PC">PC</th>
                <th title="Laptop">Laptop</th>
                <th title="Mobile">Mobile</th>
                <th title="Company SIM">SIM</th>
                <th title="Printer">Printer</th>
                <th title="WPS Cash">WPS</th>
                <th title="Bank Name">Bank</th>
                <th title="IBAN">IBAN</th>
                <th title="Comments">Com</th>
                <th title="Remarks">Rem</th>
                <th title="Actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($staff as $staffMember)
                <tr>
                    <td>{{ $staffMember->reference_no }}</td>
                    <td>{{ $staffMember->name_of_staff }}</td>
                    <td>{{ $staffMember->nationality }}</td>
                    <td>{{ $staffMember->passport_no }}</td>
                    <td>{{ $staffMember->passport_expiry_date }}</td>
                    <td>
                        @if($staffMember->status == 'AVAILABLE')
                            <i class="fas fa-check-circle text-success status-icon" title="Available"></i> Available
                        @elseif($staffMember->status == 'HOLD')
                            <i class="fas fa-pause-circle text-warning status-icon" title="Hold"></i> Hold
                        @elseif($staffMember->status == 'SELECTED')
                            <i class="fas fa-star text-info status-icon" title="Selected"></i> Selected
                        @elseif($staffMember->status == 'WC-DATE')
                            <i class="fas fa-calendar-alt text-primary status-icon" title="WC-Date"></i> WC-Date
                        @elseif($staffMember->status == 'VISA DATE')
                            <i class="fas fa-passport text-danger status-icon" title="Visa Date"></i> Visa Date
                        @endif
                    </td>
                    <td>{{ $staffMember->date_of_joining }}</td>
                    <td>{{ $staffMember->actual_designation }}</td>
                    <td>{{ $staffMember->visa_designation }}</td>
                    <td>{{ $staffMember->gender }}</td>
                    <td>{{ $staffMember->date_of_birth }}</td>
                    <td>{{ $staffMember->marital_status }}</td>
                    <td>{{ $staffMember->employment_contract_start_date }}</td>
                    <td>{{ $staffMember->employment_contract_end_date }}</td>
                    <td>{{ $staffMember->contract_type }}</td>
                    <td>{{ $staffMember->file_entry_permit_no }}</td>
                    <td>{{ $staffMember->uid_no }}</td>
                    <td>{{ $staffMember->contact_no }}</td>
                    <td>{{ $staffMember->temp_work_permit_no }}</td>
                    <td>{{ $staffMember->temp_work_permit_expiry_date }}</td>
                    <td>{{ $staffMember->personal_no }}</td>
                    <td>{{ $staffMember->labor_card_no }}</td>
                    <td>{{ $staffMember->labor_card_expiry_date }}</td>
                    <td>{{ $staffMember->residence_visa_start_date }}</td>
                    <td>{{ $staffMember->residence_visa_expiry_date }}</td>
                    <td>{{ $staffMember->emirates_id_number }}</td>
                    <td>{{ $staffMember->eid_expiry_date }}</td>
                    <td>{{ $staffMember->salary_as_per_contract }}</td>
                    <td>{{ $staffMember->basic }}</td>
                    <td>{{ $staffMember->housing }}</td>
                    <td>{{ $staffMember->transport }}</td>
                    <td>{{ $staffMember->other_allowances }}</td>
                    <td>{{ $staffMember->total_salary }}</td>
                    <td>{{ $staffMember->pc == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $staffMember->laptop == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $staffMember->mobile == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $staffMember->company_sim == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $staffMember->printer == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $staffMember->wps_cash }}</td>
                    <td>{{ $staffMember->bank_name }}</td>
                    <td>{{ $staffMember->iban }}</td>
                    <td>{{ \Illuminate\Support\Str::words($staffMember->comments, 100) }}</td>
                    <td>{{ \Illuminate\Support\Str::words($staffMember->remarks, 100) }}</td>
                    <td class="actions">
                        <a href="#" class="btn btn-secondary btn-icon-only" title="Attachments">
                            <i class="fas fa-paperclip"></i>
                        </a>
                        <a href="{{ route('staff.show', $staffMember->slug) }}" class="btn btn-info btn-icon-only" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('staff.edit', $staffMember->slug) }}" class="btn btn-warning btn-icon-only" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('staff.destroy', $staffMember->slug) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-icon-only" title="Delete" onclick="return confirm('Are you sure?');">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th title="Reference Number">Ref #</th>
                <th title="Name of Staff">Name</th>
                <th title="Nationality">Nat</th>
                <th title="Passport Number">PP #</th>
                <th title="Passport Expiry Date">PP Exp</th>
                <th title="Status">Stat</th>
                <th title="Date of Joining">DoJ</th>
                <th title="Actual Designation">Act Desig</th>
                <th title="Visa Designation">Visa Desig</th>
                <th title="Gender">Gen</th>
                <th title="Date of Birth">DOB</th>
                <th title="Marital Status">Mar Stat</th>
                <th title="Contract Start Date">Start</th>
                <th title="Contract End Date">End</th>
                <th title="Contract Type">Type</th>
                <th title="File Entry Permit Number">FEP #</th>
                <th title="UID Number">UID #</th>
                <th title="Contact Number">Contact #</th>
                <th title="Temporary Work Permit Number">TWP #</th>
                <th title="Temporary Work Permit Expiry Date">TWP Exp</th>
                <th title="Personal Number">Pers #</th>
                <th title="Labor Card Number">LC #</th>
                <th title="Labor Card Expiry Date">LC Exp</th>
                <th title="Residence Visa Start Date">RV Start</th>
                <th title="Residence Visa Expiry Date">RV Exp</th>
                <th title="Emirates ID Number">EID #</th>
                <th title="EID Expiry Date">EID Exp</th>
                <th title="Salary As Per Contract">Salary</th>
                <th title="Basic Salary">Basic</th>
                <th title="Housing Allowance">House</th>
                <th title="Transport Allowance">Trans</th>
                <th title="Other Allowances">Other</th>
                <th title="Total Salary">Total</th>
                <th title="PC">PC</th>
                <th title="Laptop">Laptop</th>
                <th title="Mobile">Mobile</th>
                <th title="Company SIM">SIM</th>
                <th title="Printer">Printer</th>
                <th title="WPS Cash">WPS</th>
                <th title="Bank Name">Bank</th>
                <th title="IBAN">IBAN</th>
                <th title="Comments">Com</th>
                <th title="Remarks">Rem</th>
                <th title="Actions">Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing {{ $staff->firstItem() }} to {{ $staff->lastItem() }} of {{ $staff->total() }} results
        </span>
        <ul class="pagination justify-content-center">
            {{ $staff->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>
