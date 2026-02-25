<style>
    .select2-container--default .select2-selection__rendered {
        line-height: 14px !important;
    }
    .table-container { width: 100%; overflow-x: auto; position: relative; }
    .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
    .table th, .table td { padding: 10px 15px; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .table th { background-color: #343a40; color: white; text-transform: uppercase; font-weight: bold; }
    .table-hover tbody tr:hover { background-color: #f1f1f1; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
    .btn-icon-only { display: inline-flex; align-items: center; justify-content: center; padding: 5px; border-radius: 50%; font-size: 12px; width: 30px; height: 30px; color: white; }
    .btn-info { background-color: #17a2b8; }
    .btn-warning { background-color: #ffc107; }
    .btn-danger { background-color: #dc3545; }
    .attachments-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px; margin-top: 10px; }
    .attachment-item { text-align: center; }
    .attachment-item p { margin-top: 5px; font-size: 12px; }
    .img-thumbnail { max-width: 100px; max-height: 100px; object-fit: cover; }
    .bg-gradient-primary { background: linear-gradient(to right, #007bff, #6a11cb); }
    .btn-sm { font-size: 0.8rem; }
    .table-warning { background-color: #fff3cd !important; }
    .appeal-blink { animation: blink-animation 1.5s infinite; font-weight: bold; color: #000; }
    @keyframes blink-animation { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }
    .pagination-controls { display: flex; justify-content: center; margin-bottom: 10px; align-items: center; gap: 20px; }
    .pagination-controls i { font-size: 12px; cursor: pointer; color: #343a40; }
    .pagination-controls i.disabled { color: #ccc; cursor: not-allowed; }
    .fullscreen-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 2; }
    .dropdown-container { display: none; position: fixed; z-index: 2.5; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2); min-width: 350px; max-width: 450px; text-align: center; left: 50%; top: 50%; transform: translate(-50%, -50%); border: 4px solid #007bff; animation: fadeIn 0.3s ease-in-out; }
    .dropdown-header { margin-bottom: 10px; }
    .dropdown-header .header-icon { font-size: 24px; color: #007bff; margin-bottom: 10px; }
    .dropdown-header p { font-size: 12px; font-weight: bold; color: #333; margin: 5px 0; line-height: 1.5; }
    .candidate-name { color: #007bff; font-weight: bold; font-size: 12px; }
    .status-dropdown { width: 100%; margin-top: 10px; font-size: 12px; border: 2px solid #007bff; border-radius: 6px; outline: none; background-color: #fff; color: #333; }
    .close-icon { position: absolute; top: 10px; right: 10px; font-size: 24px; color: #ff6347; cursor: pointer; transition: color 0.3s ease; }
    .close-icon:hover { color: #ff4500; }
    @keyframes fadeIn { from { opacity: 0; transform: translate(-50%, -55%); } to { opacity: 1; transform: translate(-50%, -50%); } }
    .dropdown-container .fa-times { cursor: pointer; margin-left: 10px; color: #888; font-size: 12px; }
    .pagination-controls { margin-top: 10px; display: flex; gap: 10px; justify-content: center; align-items: center; }
    .icon-wrapper { display: flex; justify-content: center; align-items: center; width: 20px; height: 20px; border-radius: 50%; background-color: #f0f0f0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease, transform 0.3s ease; cursor: pointer; }
    .icon-wrapper i { font-size: 12px; color: #555; }
    .icon-wrapper:hover { background-color: #007BFF; transform: scale(1.1); }
    .icon-wrapper:hover i { color: #fff; }
    .icon-wrapper .disabled { cursor: not-allowed; opacity: 0.5; }
    .icon-wrapper .disabled:hover { transform: none; background-color: #f0f0f0; }
    .pagination-container span { font-size: 12px; }
    .table th,
    .table td {padding: 10px 15px;text-align: center;vertical-align: middle;border-bottom: 1px solid #ddd;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
    /* Preloader styles */
    .preloader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1050;
    }
    .preloader-content {
        text-align: center;
    }
    .spinner {
        width: 50px;
        height: 50px;
        border: 6px solid rgba(0, 0, 0, 0.1);
        border-top-color: #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 10px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@if($employees->count())
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Reference #</th>
                <th>Name</th>
                <th>Package</th>
                <th>Nationality</th>
                <th>Visa Status</th>
                <th>Passport No</th>
                <th>Passport Expiry Date</th>
                <th>Date of Joining</th>
                <th>Visa Designation</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Contract Start Date</th>
                <th>Contract End Date</th>
                <th>Contract Type</th>
                <th>Salary as per Contract</th>
                <th>Basic Salary</th>
                <th>Housing Allowance</th>
                <th>Transport Allowance</th>
                <th>Other Allowances</th>
                <th>Total Salary</th>
                <th>Payment Type</th>
                <th>Bank Name</th>
                <th>IBAN</th>
                <th>Remarks</th>
                <th>Comments</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->reference_no }}</td>
                <td style="text-align:left !important;">
                    {{ $employee->name }} 
                    <img src="{{ asset('assets/img/attach.png') }}" alt="Attachment Icon" style="cursor: pointer; margin-left: 8px; vertical-align: middle; height: 20px;" title="View Attachments of the Candidate" onclick="alert('Work is in progress..');" />
                </td>
                <td>{{ $employee->package }}</td>
                <td>{{ $employee->nationality }}</td>
                <td>
                    @if($employee->visa_status == 0)
                        <button class="btn btn-secondary btn-sm">
                            <i class="fas fa-clock"></i> Not started
                        </button>
                    @else
                        @php
                            $visaStatusName = '';
                            $visaStatusIcon = '';

                            $visaStatuses = [
                                1  => ['name' => 'Visit 1',    'icon' => 'fa-plane'],
                                2  => ['name' => 'Visit 2',    'icon' => 'fa-plane-departure'],
                                3  => ['name' => 'DIN',        'icon' => 'fa-file-medical'],
                                4  => ['name' => 'EPV',        'icon' => 'fa-passport'],
                                5  => ['name' => 'CS',         'icon' => 'fa-user-shield'],
                                6  => ['name' => 'Medical',    'icon' => 'fa-heartbeat'],
                                7  => ['name' => 'TWJ',        'icon' => 'fa-calendar-alt'],
                                8  => ['name' => 'EID',        'icon' => 'fa-id-card'],
                                9  => ['name' => 'RVS',        'icon' => 'fa-stamp'],
                                10 => ['name' => 'Visit 3',    'icon' => 'fa-plane-arrival'],
                                11 => ['name' => 'ILOE',       'icon' => 'fa-briefcase'],
                                12 => ['name' => 'SD',         'icon' => 'fa-money-bill'],
                                13 => ['name' => 'VC',         'icon' => 'fa-times'],
                                14 => ['name' => 'Completed',  'icon' => 'fa-check-circle'],
                                15 => ['name' => 'Arrived',    'icon' => 'fa-plane-arrival'],
                            ];

                            $visaStatusId = (int) ($employee->visa_status ?? 0);
                            $visaStatus = $visaStatuses[$visaStatusId] ?? ['name' => 'Unknown', 'icon' => 'fa-question-circle'];

                            $visaStatusName = $visaStatus['name'];
                            $visaStatusIcon = $visaStatus['icon'];
                        @endphp
                        <button class="btn btn-info btn-sm">
                            <i class="fas {{ $visaStatusIcon }}"></i> {{ $visaStatusName }}
                        </button>
                    @endif
                </td>
                <td>{{ $employee->passport_no }}</td>
                <td>
                    @if($employee->passport_expiry_date)
                        {{ \Carbon\Carbon::parse($employee->passport_expiry_date)->format('d M Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($employee->date_of_joining)
                        {{ \Carbon\Carbon::parse($employee->date_of_joining)->format('d M Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $employee->visa_designation }}</td>
                <td>
                    @if($employee->date_of_birth)
                        {{ \Carbon\Carbon::parse($employee->date_of_birth)->format('d M Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $employee->gender }}</td>
                <td>
                    @if($employee->employment_contract_start_date)
                        {{ \Carbon\Carbon::parse($employee->employment_contract_start_date)->format('d M Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($employee->employment_contract_end_date)
                        {{ \Carbon\Carbon::parse($employee->employment_contract_end_date)->format('d M Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $employee->contract_type }}</td>
                <td>{{ $employee->salary_as_per_contract }}</td>
                <td>{{ $employee->basic }}</td>
                <td>{{ $employee->housing }}</td>
                <td>{{ $employee->transport }}</td>
                <td>{{ $employee->other_allowances }}</td>
                <td>{{ $employee->total_salary }}</td>
                <td>{{ $employee->payment_type }}</td>
                <td>{{ $employee->bank_name }}</td>
                <td>{{ $employee->iban }}</td>
                <td>{{ $employee->remarks }}</td>
                <td>{{ $employee->comments }}</td>
                <td class="actions">
                    <a href="{{ route('employees.show', $employee->reference_no) }}" class="btn btn-primary btn-icon-only" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('employees.edit', $employee->reference_no) }}" class="btn btn-primary btn-icon-only" title="Edit">
                        <i class="fas fa-pencil"></i>
                    </a>
                    @if (Auth::user()->role === 'Admin')
                    <form action="{{ route('employees.destroy', $employee->reference_no) }}" method="POST" style="display:inline;" id="delete-form-{{ $employee->reference_no }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-icon-only" onclick="confirmDelete('{{ $employee->reference_no }}')" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Reference #</th>
                <th>Name</th>
                <th>Package</th>
                <th>Nationality</th>
                <th>Visa Status</th>
                <th>Passport No</th>
                <th>Passport Expiry Date</th>
                <th>Date of Joining</th>
                <th>Visa Designation</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Contract Start Date</th>
                <th>Contract End Date</th>
                <th>Contract Type</th>
                <th>Salary as per Contract</th>
                <th>Basic Salary</th>
                <th>Housing Allowance</th>
                <th>Transport Allowance</th>
                <th>Other Allowances</th>
                <th>Total Salary</th>
                <th>Payment Type</th>
                <th>Bank Name</th>
                <th>IBAN</th>
                <th>Remarks</th>
                <th>Comments</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
    <nav aria-label="Page navigation">
        <div class="pagination-container">
            <span class="muted-text">
                Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} results
            </span>
            <ul class="pagination justify-content-center">
                {{ $employees->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </div>
    </nav>
</div>
@else
<div class="no-records" style="font-size: 12px; text-align: center; color: red;margin-top: 20px;">
    <p>No employee records found.</p>
</div>
@endif

