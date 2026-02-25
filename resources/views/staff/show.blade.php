@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
  body {
    background: linear-gradient(to right, #e0f7fa, #e1bee7);
    font-family: Arial, sans-serif;
  }
  .info-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
  }
  .info-table td {
    padding: 8px 12px;
    border-bottom: 1px solid #ddd;
  }
  .info-label {
    font-weight: bold;
    color: #495057;
    width: 30%;
  }
  .info-value {
    color: #6c757d;
    text-align: right;
    width: 70%;
  }
  .btn-container {
    margin-top: 20px;
    display: flex;
    gap: 15px;
  }
</style>
<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card" style="padding: 20px;">
          <h5>Staff Detail</h5>
          <table class="info-table">
            <tbody>
              <tr>
                <td class="info-label"><i class="fas fa-hashtag"></i> Reference No</td>
                <td class="info-value">{{ $staff->reference_no }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-user"></i> Name of Staff</td>
                <td class="info-value">{{ $staff->name_of_staff }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-flag"></i> Nationality</td>
                <td class="info-value">{{ $staff->nationality }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-passport"></i> Passport Number</td>
                <td class="info-value">{{ $staff->passport_no }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Passport Expiry Date</td>
                <td class="info-value">{{ $staff->passport_expiry_date }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-info-circle"></i> Status</td>
                <td class="info-value">{{ $staff->status }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-plus"></i> Date of Joining</td>
                <td class="info-value">{{ $staff->date_of_joining }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-briefcase"></i> Actual Designation</td>
                <td class="info-value">{{ $staff->actual_designation }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-briefcase"></i> Visa Designation</td>
                <td class="info-value">{{ $staff->visa_designation }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-venus-mars"></i> Gender</td>
                <td class="info-value">{{ $staff->gender }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-birthday-cake"></i> Date of Birth</td>
                <td class="info-value">{{ $staff->date_of_birth }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-heart"></i> Marital Status</td>
                <td class="info-value">{{ $staff->marital_status }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Employment Contract Start Date</td>
                <td class="info-value">{{ $staff->employment_contract_start_date }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Employment Contract End Date</td>
                <td class="info-value">{{ $staff->employment_contract_end_date }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-file-contract"></i> Contract Type</td>
                <td class="info-value">{{ $staff->contract_type }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-file"></i> File/Entry Permit No</td>
                <td class="info-value">{{ $staff->file_entry_permit_no }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-id-card"></i> UID No</td>
                <td class="info-value">{{ $staff->uid_no }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-phone"></i> Contact No</td>
                <td class="info-value">{{ $staff->contact_no }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-file-alt"></i> Temp Work Permit No</td>
                <td class="info-value">{{ $staff->temp_work_permit_no }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Temp Work Permit Expiry Date</td>
                <td class="info-value">{{ $staff->temp_work_permit_expiry_date }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-id-card"></i> Personal No</td>
                <td class="info-value">{{ $staff->personal_no }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-id-card"></i> Labor Card No</td>
                <td class="info-value">{{ $staff->labor_card_no }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Labor Card Expiry Date</td>
                <td class="info-value">{{ $staff->labor_card_expiry_date }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Residence Visa Start Date</td>
                <td class="info-value">{{ $staff->residence_visa_start_date }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Residence Visa Expiry Date</td>
                <td class="info-value">{{ $staff->residence_visa_expiry_date }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-id-card"></i> Emirates ID Number</td>
                <td class="info-value">{{ $staff->emirates_id_number }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> EID Expiry Date</td>
                <td class="info-value">{{ $staff->eid_expiry_date }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-money-bill"></i> Salary as Per Contract</td>
                <td class="info-value">{{ $staff->salary_as_per_contract }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-money-bill"></i> Basic Salary</td>
                <td class="info-value">{{ $staff->basic }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-home"></i> Housing Allowance</td>
                <td class="info-value">{{ $staff->housing }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-bus"></i> Transport Allowance</td>
                <td class="info-value">{{ $staff->transport }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-money-bill-wave"></i> Other Allowances</td>
                <td class="info-value">{{ $staff->other_allowances }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-wallet"></i> Total Salary</td>
                <td class="info-value">{{ $staff->total_salary }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-desktop"></i> PC</td>
                <td class="info-value">{{ $staff->pc ? 'Yes' : 'No' }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-laptop"></i> Laptop</td>
                <td class="info-value">{{ $staff->laptop ? 'Yes' : 'No' }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-mobile-alt"></i> Mobile</td>
                <td class="info-value">{{ $staff->mobile ? 'Yes' : 'No' }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-sim-card"></i> Company SIM</td>
                <td class="info-value">{{ $staff->company_sim ? 'Yes' : 'No' }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-print"></i> Printer</td>
                <td class="info-value">{{ $staff->printer ? 'Yes' : 'No' }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-money-check"></i> WPS Cash</td>
                <td class="info-value">{{ $staff->wps_cash }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-university"></i> Bank Name</td>
                <td class="info-value">{{ $staff->bank_name }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-credit-card"></i> IBAN</td>
                <td class="info-value">{{ $staff->iban }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-comment-dots"></i> Comments</td>
                <td class="info-value">{{ $staff->comments }}</td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-sticky-note"></i> Remarks</td>
                <td class="info-value">{{ $staff->remarks }}</td>
              </tr>
            </tbody>
          </table>
          <div class="btn-container">
            <a href="{{ route('staff.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Staff</a>
            <a href="{{ route('staff.edit', $staff->slug) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Staff</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@include('../layout.footer')
