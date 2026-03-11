<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                <td class="info-value"><?php echo e($staff->reference_no); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-user"></i> Name of Staff</td>
                <td class="info-value"><?php echo e($staff->name_of_staff); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-flag"></i> Nationality</td>
                <td class="info-value"><?php echo e($staff->nationality); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-passport"></i> Passport Number</td>
                <td class="info-value"><?php echo e($staff->passport_no); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Passport Expiry Date</td>
                <td class="info-value"><?php echo e($staff->passport_expiry_date); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-info-circle"></i> Status</td>
                <td class="info-value"><?php echo e($staff->status); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-plus"></i> Date of Joining</td>
                <td class="info-value"><?php echo e($staff->date_of_joining); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-briefcase"></i> Actual Designation</td>
                <td class="info-value"><?php echo e($staff->actual_designation); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-briefcase"></i> Visa Designation</td>
                <td class="info-value"><?php echo e($staff->visa_designation); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-venus-mars"></i> Gender</td>
                <td class="info-value"><?php echo e($staff->gender); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-birthday-cake"></i> Date of Birth</td>
                <td class="info-value"><?php echo e($staff->date_of_birth); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-heart"></i> Marital Status</td>
                <td class="info-value"><?php echo e($staff->marital_status); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Employment Contract Start Date</td>
                <td class="info-value"><?php echo e($staff->employment_contract_start_date); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Employment Contract End Date</td>
                <td class="info-value"><?php echo e($staff->employment_contract_end_date); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-file-contract"></i> Contract Type</td>
                <td class="info-value"><?php echo e($staff->contract_type); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-file"></i> File/Entry Permit No</td>
                <td class="info-value"><?php echo e($staff->file_entry_permit_no); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-id-card"></i> UID No</td>
                <td class="info-value"><?php echo e($staff->uid_no); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-phone"></i> Contact No</td>
                <td class="info-value"><?php echo e($staff->contact_no); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-file-alt"></i> Temp Work Permit No</td>
                <td class="info-value"><?php echo e($staff->temp_work_permit_no); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Temp Work Permit Expiry Date</td>
                <td class="info-value"><?php echo e($staff->temp_work_permit_expiry_date); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-id-card"></i> Personal No</td>
                <td class="info-value"><?php echo e($staff->personal_no); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-id-card"></i> Labor Card No</td>
                <td class="info-value"><?php echo e($staff->labor_card_no); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Labor Card Expiry Date</td>
                <td class="info-value"><?php echo e($staff->labor_card_expiry_date); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Residence Visa Start Date</td>
                <td class="info-value"><?php echo e($staff->residence_visa_start_date); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> Residence Visa Expiry Date</td>
                <td class="info-value"><?php echo e($staff->residence_visa_expiry_date); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-id-card"></i> Emirates ID Number</td>
                <td class="info-value"><?php echo e($staff->emirates_id_number); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-calendar-alt"></i> EID Expiry Date</td>
                <td class="info-value"><?php echo e($staff->eid_expiry_date); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-money-bill"></i> Salary as Per Contract</td>
                <td class="info-value"><?php echo e($staff->salary_as_per_contract); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-money-bill"></i> Basic Salary</td>
                <td class="info-value"><?php echo e($staff->basic); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-home"></i> Housing Allowance</td>
                <td class="info-value"><?php echo e($staff->housing); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-bus"></i> Transport Allowance</td>
                <td class="info-value"><?php echo e($staff->transport); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-money-bill-wave"></i> Other Allowances</td>
                <td class="info-value"><?php echo e($staff->other_allowances); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-wallet"></i> Total Salary</td>
                <td class="info-value"><?php echo e($staff->total_salary); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-desktop"></i> PC</td>
                <td class="info-value"><?php echo e($staff->pc ? 'Yes' : 'No'); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-laptop"></i> Laptop</td>
                <td class="info-value"><?php echo e($staff->laptop ? 'Yes' : 'No'); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-mobile-alt"></i> Mobile</td>
                <td class="info-value"><?php echo e($staff->mobile ? 'Yes' : 'No'); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-sim-card"></i> Company SIM</td>
                <td class="info-value"><?php echo e($staff->company_sim ? 'Yes' : 'No'); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-print"></i> Printer</td>
                <td class="info-value"><?php echo e($staff->printer ? 'Yes' : 'No'); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-money-check"></i> WPS Cash</td>
                <td class="info-value"><?php echo e($staff->wps_cash); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-university"></i> Bank Name</td>
                <td class="info-value"><?php echo e($staff->bank_name); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-credit-card"></i> IBAN</td>
                <td class="info-value"><?php echo e($staff->iban); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-comment-dots"></i> Comments</td>
                <td class="info-value"><?php echo e($staff->comments); ?></td>
              </tr>
              <tr>
                <td class="info-label"><i class="fas fa-sticky-note"></i> Remarks</td>
                <td class="info-value"><?php echo e($staff->remarks); ?></td>
              </tr>
            </tbody>
          </table>
          <div class="btn-container">
            <a href="<?php echo e(route('staff.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Staff</a>
            <a href="<?php echo e(route('staff.edit', $staff->slug)); ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Staff</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php echo $__env->make('../layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /var/www/developmentoneso-project/resources/views/staff/show.blade.php ENDPATH**/ ?>