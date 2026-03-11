<?php
use Carbon\Carbon;

$serverName     = request()->getHost();
$subdomain      = explode('.', $serverName)[0] ?? 'default';
$headerFileName = strtolower($subdomain) . '_header.jpg';
$footerFileName = strtolower($subdomain) . '_footer.jpg';
$logoFileName   = strtolower($subdomain) . '_logo.png';

$firstName = function ($user) {
    if (!$user) return '';
    $name = $user->name ?? '';
    return trim(explode(' ', $name)[0] ?? '');
};
?>

<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
  .dataTables_info{font-size:12px}
  .dataTables_paginate{font-size:12px}
  .modal-lg{max-width:1000px}
  .grid{width:100%;border-collapse:collapse}
  .grid th,.grid td{border:1px solid #9aa3b2;padding:6px;vertical-align:middle;background:#fff}
  .grid thead th{background:#eef5ff}
  .row-actions{white-space:nowrap;text-align:center}
  .btn-mini{display:inline-flex;align-items:center;justify-content:center;padding:4px 8px;border:0;color:#fff;font-size:11px;line-height:1}
  .btn-plus{background:linear-gradient(to right,#22c55e,#4ade80)}
  .btn-minus{background:linear-gradient(to right,#ef4444,#fb7185)}
  .is-alert{display:none}
  a{text-decoration:none}
  @media print {.no-print{display:none!important}}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">Typing Transaction Government Invoices</h5>
          <button class="btn btn-primary btn-sm" id="btn-new" data-bs-toggle="modal" data-bs-target="#ttModal">
            <i class="fa-solid fa-plus me-1"></i> New Transaction
          </button>
        </div>

        <div class="table-responsive">
          <table id="tt-table" class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Serial No</th>
                <th>Customer</th>
                <th>Mobile</th>
                <th>Amount</th>
                <th>Remaining</th>
                <th>Payment Status</th>
                <th>Created At</th>
                <th class="text-center" style="width: 1%; white-space: nowrap;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                  // Extract Customer info
                  $customerName = '-';
                  $customerId = '';
                  $customerMobile = '-';

                  if ($item->ledger) {
                      $customerName = $item->ledger->name;
                      $customerId = $item->ledger->id;
                      $customerMobile = $item->ledger->note ?? '-';
                  } elseif ($item->journal) {
                      // Try to find the debit line which usually represents the customer
                      $debitLine = $item->journal->lines->where('debit', '>', 0)->first();
                      if($debitLine && $debitLine->ledger) {
                          $customerName = $debitLine->ledger->name;
                          $customerId = $debitLine->ledger_id;
                          $customerMobile = $debitLine->ledger->note ?? '-';
                      }
                  }

                  // Calculate Payment Status
                  $amountReceived = $item->amount_received ?? 0;
                  $amountOfInvoice = $item->amount_of_invoice ?? 0;
                  $remainingAmount = $amountOfInvoice - $amountReceived;
                  
                  if ($amountReceived >= $amountOfInvoice && $amountOfInvoice > 0) {
                      $paymentStatus = 'Paid';
                      $statusBadge = 'bg-success';
                  } elseif ($amountReceived > 0 && $amountReceived < $amountOfInvoice) {
                      $paymentStatus = 'Partial';
                      $statusBadge = 'bg-warning';
                  } else {
                      $paymentStatus = 'Pending';
                      $statusBadge = 'bg-secondary';
                  }
              ?>
              <tr>
                <td><?php echo e($item->id); ?></td>
                <td><?php echo e($item->serial_no); ?></td>
                <td>
                    <?php if($customerId): ?>
                        <a href="<?php echo e(route('finance.statementOfAccount', $customerId)); ?>" target="_blank" class="fw-bold text-decoration-none text-dark">
                            <?php echo e($customerName); ?> <i class="fas fa-external-link-alt ms-1 text-muted small"></i>
                        </a>
                    <?php else: ?>
                        <?php echo e($customerName); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e($customerMobile); ?></td>
                <td><?php echo e(number_format($item->amount_of_invoice, 2)); ?></td>
                <td><?php echo e(number_format($remainingAmount, 2)); ?></td>
                <td><span class="badge <?php echo e($statusBadge); ?>"><?php echo e($paymentStatus); ?></span></td>
                <td><?php echo e($item->created_at->format('Y-m-d')); ?></td>
                <td class="text-center" style="white-space: nowrap;">
                  <?php if($item->journal): ?>
                    <a href="<?php echo e(route('finance.journals.show', $item->journal->id)); ?>" target="_blank" class="btn btn-secondary btn-sm me-1" title="View Journal Entries">
                        <i class="fa-solid fa-book"></i>
                    </a>
                  <?php endif; ?>
                  <button class="btn btn-info btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#ttModal"
                          data-id="<?php echo e($item->id); ?>"
                          data-customer_id="<?php echo e($customerId); ?>"
                          data-customer_name="<?php echo e($customerName); ?>"
                          title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-success btn-sm receive-payment-btn" data-bs-toggle="modal" data-bs-target="#paymentModal"
                          data-id="<?php echo e($item->id); ?>"
                          title="Receive Payment">
                    <i class="fa-solid fa-money-bill-wave"></i>
                  </button>
                  <button class="btn btn-secondary btn-sm view-invoice-btn" data-bs-toggle="modal" data-bs-target="#invoiceModal"
                          data-id="<?php echo e($item->id); ?>"
                          title="View Invoice">
                    <i class="fa-solid fa-file-invoice"></i>
                  </button>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
        <div class="mt-3">
          <?php echo e($items->links('pagination::bootstrap-5')); ?>

        </div>

      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="ttModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="ttForm" class="w-100">
      <input type="hidden" name="_method" id="tt_method" value="POST">
      <input type="hidden" name="id" id="tt_id">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title"><i class="fa-solid fa-file-invoice me-1"></i> <span id="tt_title">New Transaction</span></h6>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            
            <div class="col-md-6">
              <label class="form-label">Customer (Ledger) *</label>
              <select class="form-select" id="ledger_of_account_id" name="ledger_of_account_id" required></select>
            </div>

            <div class="col-12">
              <label class="form-label">Note</label>
              <textarea class="form-control" id="gov_dw_no" name="gov_dw_no" rows="2" placeholder="Add a note..."></textarea>
            </div>

            <div class="col-12">
              <label class="form-label">Services *</label>
              <table class="grid" id="servicesTable">
                <thead>
                  <tr>
                    <th style="width:35%">Invoice Service</th>
                    <th style="width:15%">DW No</th>
                    <th class="text-center" style="width:12%">Qty</th>
                    <th class="text-end" style="width:18%">Amount</th>
                    <th class="text-center" style="width:20%">Actions</th>
                  </tr>
                </thead>
                <tbody id="servicesBody">
                  <tr>
                    <td>
                      <select class="line-input service-select form-select" style="width: 100%" data-price="0">
                        <option value="" selected disabled>Type to search...</option>
                      </select>
                    </td>
                    <td><input type="text" class="line-input form-control dw" placeholder="DW-001"></td>
                    <td class="amount"><input type="number" class="line-input form-control qty" step="any" min="0.01" placeholder="1" value="1"></td>
                    <td class="text-end amount-display">0.00</td>
                    <td class="row-actions">
                      <button type="button" class="btn-mini btn-plus addServiceRow"><i class="fa-solid fa-plus"></i></button>
                      <button type="button" class="btn-mini btn-minus delServiceRow"><i class="fa-solid fa-minus"></i></button>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr class="table-primary" style="font-weight: bold;">
                    <td colspan="3" class="text-end">Total:</td>
                    <td class="text-end" id="servicesTotal">0.00</td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>

            

            <!-- Note: Attachments currently handled as simple array in backend but no dedicated UI requested other than standard CRUD. Keeping simple unless requested. -->

            <div class="col-12">
              <div id="tt_error" class="is-alert alert alert-danger py-2 px-3"></div>
              <div id="tt_success" class="is-alert alert alert-success py-2 px-3"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer no-print">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="btn_save" class="btn btn-success btn-sm"><i class="fa-solid fa-floppy-disk me-1"></i> Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Receive Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="paymentForm" class="w-100">
      <input type="hidden" id="pay_transaction_id">
      <input type="hidden" id="pay_credit_ledger_id">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h6 class="modal-title"><i class="fa-solid fa-money-bill-wave me-1"></i> Receive Payment</h6>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            
            <!-- Invoice Info Display -->
            <div class="col-12">
              <div class="card bg-light">
                <div class="card-body py-2">
                  <div class="row">
                    <div class="col-6">
                      <small class="text-muted">Invoice</small>
                      <p class="mb-0 fw-bold" id="pay_serial_no">-</p>
                    </div>
                    <div class="col-6">
                      <small class="text-muted">Customer</small>
                      <p class="mb-0 fw-bold" id="pay_customer_name">-</p>
                    </div>
                  </div>
                  <hr class="my-2">
                  <div class="row">
                    <div class="col-4">
                      <small class="text-muted">Total Amount</small>
                      <p class="mb-0 fw-bold" id="pay_total_amount">0.00</p>
                    </div>
                    <div class="col-4">
                      <small class="text-muted">Already Paid</small>
                      <p class="mb-0 fw-bold text-success" id="pay_amount_received">0.00</p>
                    </div>
                    <div class="col-4">
                      <small class="text-muted">Remaining</small>
                      <p class="mb-0 fw-bold text-danger" id="pay_remaining">0.00</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Amount Input -->
            <div class="col-md-6">
              <label class="form-label">Amount *</label>
              <input type="number" class="form-control" id="pay_amount" name="amount" step="0.01" min="0.01" required>
            </div>

            <!-- Payment Mode -->
            <div class="col-md-6">
              <label class="form-label">Payment Mode *</label>
              <select class="form-select" id="pay_payment_mode" name="payment_mode" required>
                <option value="1">Cash</option>
                <option value="2">Bank Transfer</option>
                <option value="3">Cheque</option>
                <option value="4">Card</option>
              </select>
            </div>

            <!-- Debit Ledger (Cash/Bank Account) -->
            <div class="col-12">
              <label class="form-label">Cash/Bank Account *</label>
              <select class="form-select" id="pay_debit_ledger_id" name="debit_ledger_id" required></select>
            </div>

            <div class="col-12">
              <div id="pay_error" class="is-alert alert alert-danger py-2 px-3"></div>
              <div id="pay_success" class="is-alert alert alert-success py-2 px-3"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="btn_pay" class="btn btn-success btn-sm"><i class="fa-solid fa-check me-1"></i> Receive Payment</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Invoice View/Print Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white no-print">
        <h6 class="modal-title"><i class="fa-solid fa-file-invoice me-1"></i> Tax Invoice Details</h6>
        <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body" id="invoiceContent">
        <!-- Invoice Content will be loaded here -->
        <div class="text-center py-5" id="invoiceLoading">
          <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
          <p class="mt-2">Loading invoice...</p>
        </div>
        
        <div id="invoiceData" style="display: none;">
          <!-- Invoice Wrapper -->
          <div class="invoice-wrapper" style="padding: 25px; font-family: Arial, sans-serif; font-size: 12px; color: #333; background: #fff;">
            
            <!-- Header Box with Company Name and Logo -->
            <div style="border: 3px solid #333; border-radius: 15px; padding: 15px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
              <div style="flex-shrink: 0; margin-right: 20px;">
                <img src="<?php echo e(asset('assets/img/' . $logoFileName)); ?>" alt="Company Logo" style="max-height: 90px; max-width: 150px;" id="inv_company_logo">
              </div>
              <div style="flex: 1; text-align: center;">
                <h2 style="margin: 0; font-size: 22px; font-weight: bold; color: #333; letter-spacing: 0.5px; text-transform: uppercase;">AL EBDAA WORKERS EMPLOYMENT SERVICES</h2>
                <p style="margin: 5px 0 0; font-size: 16px; font-weight: bold; color: #333;">مركز الإبداع لخدمات العمالة المساعدة</p>
              </div>
            </div>
            
            <!-- Tax Invoice Title -->
            <div style="text-align: center; margin-bottom: 20px;">
              <span style="font-size: 16px; color: #c0392b; display: inline-block; border-bottom: 2px solid #c0392b; padding-bottom: 3px; font-weight: normal;">
                TAX INVOICE &nbsp;&nbsp; فاتورة ضريبية
              </span>
            </div>
            
            <!-- Two Column Info Section (Flexbox) -->
            <div style="display: flex; width: 100%; margin-bottom: 20px; font-size: 11px; align-items: stretch;">
              
              <!-- Left Column -->
              <div style="flex: 1; border: 2px solid #333; padding: 10px; display: flex; flex-direction: column; justify-content: space-between;">
                
                <!-- Barcode (Top) -->
                <div style="margin-bottom: 8px;">
                   <svg id="inv_barcode" style="max-height: 35px;"></svg>
                   <div id="inv_barcode_number" style="font-size: 11px; margin-top: 2px;">-</div>
                </div>

                <!-- Info Fields (Bottom) -->
                <div>
                    <!-- TRN -->
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                       <div style="width: 40%;"><strong>TRN</strong> <span style="color: #666;">رقم تسجيل ضريبة</span></div>
                       <div id="inv_trn">-</div>
                    </div>

                    <!-- Invoice No -->
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                       <div><strong>Invoice No</strong> <span style="color: #666;">رقم الفاتورة</span></div>
                       <div id="inv_serial_no">-</div>
                    </div>

                    <!-- Date -->
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                       <div><strong>Date</strong> <span style="color: #666;">التاريخ والوقت</span></div>
                       <div id="inv_date">-</div>
                    </div>

                    <!-- Invoiced At -->
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                       <div><strong>Invoiced At</strong> <span style="color: #666;">بفاتورة في</span></div>
                       <div id="inv_invoiced_at">-</div>
                    </div>

                    <!-- Staff Name -->
                    <div style="display: flex; justify-content: space-between;">
                       <div><strong>Staff Name</strong> <span style="color: #666;">اسم الموظفين</span></div>
                       <div id="inv_staff_name">-</div>
                    </div>
                </div>

              </div>

              <!-- Right Column -->
              <div style="flex: 1; border: 2px solid #333; border-left: none; padding: 10px; display: flex; flex-direction: column; justify-content: flex-end;">
                
                <!-- Customer Ref -->
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                   <div style="width: 40%;"><strong>Customer Ref.</strong> <span style="color: #666;">كود العميل</span></div>
                   <div id="inv_customer_ref">-</div>
                </div>

                <!-- Customer Name -->
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                   <div><strong>Customer Name</strong> <span style="color: #666;">عميل</span></div>
                   <div id="inv_customer_name">-</div>
                </div>

                <!-- Mobile No -->
                <div style="display: flex; justify-content: space-between;">
                   <div><strong>Mobile No.</strong> <span style="color: #666;">رقم الهاتف المتحرك</span></div>
                   <div id="inv_mobile_no">-</div>
                </div>

              </div>
              
            </div>
            
            <!-- Services Table with 8 Columns -->
            <style>
                #inv_svc_table th {
                    line-height: 1.6 !important; /* Force generous spacing */
                    vertical-align: middle !important;
                    white-space: normal !important;
                    padding: 4px 1px !important;
                    height: auto !important;
                }
                #inv_svc_table th span {
                    display: block !important; /* Force Arabic to own line */
                    margin-top: 1px;
                }
            </style>
            <table id="inv_svc_table" style="width: 100%; border-collapse: collapse; margin-bottom: 0; font-size: 10px;">
              <thead>
                <tr style="background: #f4f4f4;">
                  <th style="border: 1px solid #333; padding: 4px 1px; text-align: center; width: 5%; vertical-align: middle; line-height: 1.5;">
                    Sl. No<br><span style="color: #666; font-size: 9px;">الرقم</span>
                  </th>
                  <th style="border: 1px solid #333; padding: 4px 1px; text-align: center; width: 24%; vertical-align: middle; line-height: 1.5;">
                    Service<br><span style="color: #666; font-size: 9px;">الخدمات</span>
                  </th>
                  <th style="border: 1px solid #333; padding: 4px 1px; text-align: center; width: 7%; vertical-align: middle; line-height: 1.5;">
                    Qty<br><span style="color: #666; font-size: 9px;">الكمية</span>
                  </th>
                  <th style="border: 1px solid #333; padding: 4px 1px; text-align: center; width: 12%; vertical-align: middle; line-height: 1.5;">
                    Govt Fee + Bank Charge<br><span style="color: #666; font-size: 9px;">رسوم حكومية</span>
                  </th>
                  <th style="border: 1px solid #333; padding: 4px 1px; text-align: center; width: 10%; vertical-align: middle; line-height: 1.5;">
                    Center Fee<br><span style="color: #666; font-size: 9px;">رسوم المركز</span>
                  </th>
                  <th style="border: 1px solid #333; padding: 4px 1px; text-align: center; width: 10%; vertical-align: middle; line-height: 1.5;">
                    Service chg.<br><span style="color: #666; font-size: 9px;">تكلفة الخدمة</span>
                  </th>
                  <th style="border: 1px solid #333; padding: 4px 1px; text-align: center; width: 10%; vertical-align: middle; line-height: 1.5;">
                    Tax<br><span style="color: #666; font-size: 9px;">ضريبة</span>
                  </th>
                  <th style="border: 1px solid #333; padding: 4px 1px; text-align: center; width: 12%; vertical-align: middle; line-height: 1.5;">
                    Total<br><span style="color: #666; font-size: 9px;">الاجمالي بالدرهم</span>
                  </th>
                </tr>
              </thead>
              <tbody id="inv_services_body">
                <!-- Services will be loaded here -->
              </tbody>
              <tfoot>
                 <tr>
                    <td colspan="7" style="border: 1px solid #333; padding: 6px 10px; text-align: right;">
                        <strong>Total Amount</strong> <span style="color: #666;">اجمالي المبلغ</span>
                    </td>
                    <td style="border: 1px solid #333; padding: 6px 10px; text-align: right;" id="inv_total_amount">0.00</td>
                 </tr>
                 <tr>
                    <td colspan="7" style="border: 1px solid #333; padding: 6px 10px; text-align: right;">
                        <strong>Total VAT</strong> <span style="color: #666;">اجمالي الضريبة</span>
                    </td>
                    <td style="border: 1px solid #333; padding: 6px 10px; text-align: right;" id="inv_total_vat">0.00</td>
                 </tr>
                 <tr>
                    <td colspan="7" style="border: 1px solid #333; padding: 6px 10px; text-align: right;">
                        <strong>Net Total</strong> <span style="color: #666;">صافي الإجمالي</span>
                    </td>
                    <td style="border: 1px solid #333; padding: 6px 10px; text-align: right; font-weight: bold;" id="inv_net_total">0.00</td>
                 </tr>
              </tfoot>
            </table>
            
            <!-- Notice Text -->
            <div style="display: flex; justify-content: space-between; margin: 8px 0 25px 0; font-size: 9px; color: #666;">
              <div style="font-style: italic;">Kindly check the invoice and documents before leaving the counter</div>
              <div style="text-align: right;">الرجاء التأكد من الفاتورة والمستندات قبل مغادرة الكاونتر</div>
            </div>
            
            <!-- Comments Section -->
            <div style="margin-bottom: 50px;">
              <div style="font-weight: bold; margin-bottom: 8px; font-size: 11px;">Comments</div>
              <div id="inv_comments" style="min-height: 40px; color: #666; font-size: 11px;"></div>
            </div>
            
            <!-- Signature Section -->
            <div style="margin-bottom: 15px; margin-top: auto;">
              <div id="inv_signatory_name" style="font-weight: bold; font-size: 11px;">-</div>
              <div style="color: #666; font-size: 10px;">Authorized Signatory - المخول بالتوقيع</div>
            </div>
            
            <!-- Footer Divider -->
            <div style="border-top: 3px solid #333; margin-bottom: 0;"></div>
            
            <!-- Footer -->
            <div style="background: #f5f5f5; padding: 12px 15px; text-align: center; margin-top: 0;">
              <div style="font-size: 12px; font-weight: bold; margin-bottom: 3px;">
                0488 288 48 &nbsp;|&nbsp; info@tadbeer-alebdaa.com &nbsp;|&nbsp; www.tadbeer-alebdaa.com
              </div>
              <div style="font-size: 11px;">
                Office No:5, SARAYA Avenue BLDG., Al Garhoud, Dubai - U.A.E.
              </div>
            </div>
            
          </div>
        </div>
      </div>
      <div class="modal-footer no-print">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="btn_print_invoice"><i class="fa-solid fa-print me-1"></i> Print Invoice</button>
      </div>
    </div>
  </div>
</div>

<style>
@media print {
  @page { margin: 0; size: auto; }
  /* Hide everything by default */
  body * {
    visibility: hidden;
  }
  
  /* Hide modal backdrop */
  .modal-backdrop, .modal-backdrop.show {
    display: none !important;
  }
  
  /* Show only invoice content */
  #invoiceModal,
  #invoiceModal .modal-dialog,
  #invoiceModal .modal-content,
  #invoiceModal .modal-body,
  #invoiceModal .modal-body *,
  #invoiceData,
  #invoiceData * {
    visibility: visible !important;
  }
  
  /* Position modal */
  #invoiceModal {
    position: absolute !important;
    left: 0 !important;
    top: 0 !important;
    width: 100% !important;
    background: #fff !important;
  }
  
  #invoiceModal .modal-dialog {
    margin: 0 !important;
    padding: 0 !important;
    max-width: 100% !important;
    width: 100% !important;
    transform: none !important;
    align-items: flex-start !important;
    min-height: auto !important;
    display: block !important;
  }
  
  #invoiceModal .modal-content {
    border: none !important;
    box-shadow: none !important;
    background: #fff !important;
  }
  
  #invoiceModal .modal-body {
    padding: 0 !important;
  }
  
  .invoice-wrapper {
    padding: 75px !important;
    min-height: 98vh;
    display: flex;
    flex-direction: column;
  }
  
  /* Hide header, footer, loading */
  .no-print,
  #invoiceModal .modal-header,
  #invoiceModal .modal-footer,
  #invoiceLoading {
    display: none !important;
  }
  
  /* Force colors to print */
  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }
}
</style>

<?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

  const apiBaseUrl = '/api/typing-tran-gov-invs';

  function showMsg(id,msg){ const $el=$(id); $el.text(msg).show(); setTimeout(()=>{$el.fadeOut(250)},2500); }
  function parseAmt(v){ const x = parseFloat(String(v).replace(/,/g,'')); return isNaN(x)?0:+x; }

  function initSelect2($select, url, placeholder) {
    $select.select2({
      ajax: {
        url: url,
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            search: params.term || '',
            page: params.page || 1,
            per_page: 20
          };
        },
        processResults: function (data) {
          return {
            results: data.results,
            pagination: { more: data.pagination.more }
          };
        },
        cache: true
      },
      minimumInputLength: 0, 
      placeholder: placeholder,
      allowClear: true,
      width: '100%',
      dropdownParent: $('#ttModal')
    });
  }

  // Calculate and display row amount
  function updateRowAmount($tr) {
    const $select = $tr.find('.service-select');
    const price = parseFloat($select.data('price')) || 0;
    const qty = parseAmt($tr.find('.qty').val());
    const amount = price * qty;
    $tr.find('.amount-display').text(amount.toFixed(2));
    updateTotal();
  }

  // Calculate and display total of all amounts
  function updateTotal() {
    let total = 0;
    $('#servicesBody .amount-display').each(function() {
      total += parseAmt($(this).text());
    });
    $('#servicesTotal').text(total.toFixed(2));
  }

  // Initialize Select2 on a service select element
  function initServiceSelect2($select, initialId='', initialText='') {
    $select.select2({
      ajax: {
        url: '/api/invoice-services/lookup',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            search: params.term || '',
            page: params.page || 1,
            per_page: 20
          };
        },
        processResults: function (data) {
          return {
            results: data.results,
            pagination: { more: data.pagination.more }
          };
        },
        cache: true
      },
      minimumInputLength: 0,
      placeholder: 'Type to search service...',
      allowClear: true,
      width: '100%',
      dropdownParent: $('#ttModal')
    });
    
    // If there's an initial value, add it as an option
    if(initialId && initialText) {
      if ($select.find("option[value='" + initialId + "']").length) {
          $select.val(initialId).trigger('change');
      } else { 
          const option = new Option(initialText, initialId, true, true);
          $select.append(option).trigger('change');
      }
    }

    // Fetch service price when service is selected
    $select.on('select2:select', function(e) {
      const serviceId = e.params.data.id;
      if(serviceId) {
        $.ajax({
          url: '/api/invoice-services/' + serviceId,
          method: 'GET',
          success: function(res) {
            console.log('Service response:', res);
            const service = res.data || res;
            const totalAmount = service.total_amount || 0;
            console.log('Total amount:', totalAmount);
            $select.data('price', totalAmount);
            updateRowAmount($select.closest('tr'));
          },
          error: function(err) {
            console.error('Error fetching service price:', err);
            $select.data('price', 0);
            updateRowAmount($select.closest('tr'));
          }
        });
      }
    });
  }

  // Create a new service row
  function makeServiceRow(serviceId='', serviceName='', quantity='1', dw=''){
    const $row = $(`
      <tr>
        <td><select class="line-input service-select form-select" style="width: 100%" data-price="0"><option value="" selected disabled>Type to search...</option></select></td>
        <td><input type="text" class="line-input form-control dw" placeholder="DW-001" value="${dw}"></td>
        <td class="amount"><input type="number" class="line-input form-control qty" step="any" min="0.01" placeholder="1" value="${quantity}"></td>
        <td class="text-end amount-display">0.00</td>
        <td class="row-actions">
          <button type="button" class="btn-mini btn-plus addServiceRow"><i class="fa-solid fa-plus"></i></button>
          <button type="button" class="btn-mini btn-minus delServiceRow"><i class="fa-solid fa-minus"></i></button>
        </td>
      </tr>
    `);
    const $sel = $row.find('.service-select');
    initServiceSelect2($sel, serviceId, serviceName);
    return $row;
  }

  // Check if a service row is filled
  function serviceRowFilled($tr){
    const svc=$tr.find('.service-select').val();
    const q=parseAmt($tr.find('.qty').val());
    if(!svc && q===0) return false;
    if(!svc) return false;
    if(q<=0) return false;
    return true;
  }

  // Add a new service row after current row
  function addServiceRowAfter($tr){
    if(!serviceRowFilled($tr)){ showMsg('#tt_error','Complete the row before adding a new one'); return; }
    $tr.after(makeServiceRow());
  }

  // Build services array from table rows
  function buildServices(){
    const services=[];
    $('#servicesBody tr').each(function(){
      const $tr=$(this);
      const svcId=$tr.find('.service-select').val()||'';
      const q=parseAmt($tr.find('.qty').val());
      const dw=$tr.find('.dw').val()||'';
      if(svcId||q>0){
        if(!serviceRowFilled($tr)) throw new Error('row');
        services.push({invoice_service_id: parseInt(svcId), quantity: +q.toFixed(2), dw: dw});
      }
    });
    if(services.length===0) throw new Error('noservices');
    return services;
  }

  $(function(){
    $('#tt-table').DataTable({ paging: false, info: false, searching: false, ordering: false });

    // Init Customer Lookup
    initSelect2($('#ledger_of_account_id'), '/api/ledgers/lookup-customers', 'Search Customer (Name/Mobile)...');

    // Initialize Select2 on existing service selects
    $('.service-select').each(function() {
      initServiceSelect2($(this));
    });

    // Reinitialize Select2 when modal is shown
    $('#ttModal').on('shown.bs.modal', function () {
      $('.service-select').each(function() {
        if ($(this).hasClass('select2-hidden-accessible')) {
             $(this).select2('destroy');
        }
        initServiceSelect2($(this));
      });
    });

    // Service row button events
    $('#servicesBody').on('click','.addServiceRow',function(){ addServiceRowAfter($(this).closest('tr')); });
    $('#servicesBody').on('click','.delServiceRow',function(){
      const $tr=$(this).closest('tr');
      if($('#servicesBody tr').length===1){
        $tr.find('.service-select').val('').trigger('change').data('price', 0);
        $tr.find('.dw').val('');
        $tr.find('.qty').val('1');
        updateRowAmount($tr);
      }else{ 
        $tr.remove(); 
        updateTotal();
      }
    });

    // Update amount when quantity changes
    $('#servicesBody').on('input change', '.qty', function() {
      updateRowAmount($(this).closest('tr'));
    });

    // New Button
    $('#btn-new').click(function(){
        $('#ttForm')[0].reset();
        $('#tt_method').val('POST');
        $('#tt_id').val('');
        $('#tt_title').text('New Transaction');
        
        // Clear Select2
        $('#ledger_of_account_id').val(null).trigger('change');
        
        // Clear services table and add one row
        $('#servicesBody').empty().append(makeServiceRow());
        updateTotal();
    });

    // Edit Button
    $('.edit-btn').click(function(){
        const btn = $(this);
        const transactionId = btn.data('id');
        
        $('#tt_title').text('Edit Transaction');
        $('#tt_method').val('PUT');
        $('#tt_id').val(transactionId);
        
        // Show loading state (5 columns now)
        $('#servicesBody').html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');
        
        // Fetch full transaction data via API
        $.ajax({
            url: apiBaseUrl + '/' + transactionId,
            method: 'GET',
            success: function(res) {
                const transaction = res.data || res;
                
                // Pre-fill Note field
                $('#gov_dw_no').val(transaction.gov_dw_no || '');
                
                // Pre-fill Customer Select2
                const custId = btn.data('customer_id');
                const custName = btn.data('customer_name');
                if(custId) {
                    const option = new Option(custName, custId, true, true);
                    $('#ledger_of_account_id').html(option).trigger('change');
                } else {
                     $('#ledger_of_account_id').val(null).trigger('change');
                }
                
                // Clear services table
                $('#servicesBody').empty();
                
                // Load services from services_json
                const services = transaction.services_json || [];
                
                if (services.length > 0) {
                    // Load all services
                    let loadedCount = 0;
                    const totalToLoad = services.length;
                    
                    services.forEach(function(svc) {
                        // Fetch each service to get its name
                        $.ajax({
                            url: '/api/invoice-services/' + svc.invoice_service_id,
                            method: 'GET',
                            success: function(serviceRes) {
                                const service = serviceRes.data || serviceRes;
                                const serviceName = service.code + ' - ' + service.name;
                                const price = svc.amount || service.total_amount || 0;
                                
                                // Create row with service data including DW and set price
                                const $row = makeServiceRow(service.id, serviceName, svc.quantity.toString(), svc.dw || '');
                                $row.find('.service-select').data('price', price);
                                $row.find('.amount-display').text((price * svc.quantity).toFixed(2));
                                
                                $('#servicesBody').append($row);
                                loadedCount++;
                                updateTotal();
                            },
                            error: function() {
                                // If service fetch fails, skip this service
                                loadedCount++;
                                if (loadedCount === totalToLoad && $('#servicesBody tr').length === 0) {
                                    $('#servicesBody').append(makeServiceRow());
                                    updateTotal();
                                }
                            }
                        });
                    });
                } else {
                    // No services, add empty row
                    $('#servicesBody').append(makeServiceRow());
                }
            },
            error: function(err) {
                console.error('Error fetching transaction:', err);
                showMsg('#tt_error', 'Failed to load transaction data');
                // Add empty row on error
                $('#servicesBody').empty().append(makeServiceRow());
            }
        });
    });

    // Form Submit
    $('#ttForm').submit(function(e){
        e.preventDefault();
        
        const method = $('#tt_method').val();
        let url = apiBaseUrl;
        if(method === 'PUT') {
            url += '/' + $('#tt_id').val();
        }

        let services;
        try {
            services = buildServices();
        } catch(err) {
            if(err.message === 'row') {
                showMsg('#tt_error', 'Please complete all service rows or remove empty ones');
            } else if(err.message === 'noservices') {
                showMsg('#tt_error', 'Please add at least one service');
            } else {
                showMsg('#tt_error', 'Invalid service data');
            }
            return;
        }

        const data = {
            ledger_of_account_id: $('#ledger_of_account_id').val(),
            services: services,
            gov_dw_no: $('#gov_dw_no').val(),
            amount_received: 0,
            gov_inv_attachments: []
        };

        $.ajax({
            url: url,
            method: method,
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(res) {
                showMsg('#tt_success', 'Saved Successfully!');
                setTimeout(() => location.reload(), 1000);
            },
            error: function(err) {
                let msg = 'Error saving data.';
                if(err.responseJSON && err.responseJSON.message) {
                    msg = err.responseJSON.message;
                }
                if(err.responseJSON && err.responseJSON.errors) {
                    const errors = Object.values(err.responseJSON.errors).flat();
                    msg = errors.join(', ');
                }
                showMsg('#tt_error', msg);
                console.error(err);
            }
        });
    });

    // ========== PAYMENT MODAL ==========

    // Initialize Select2 for debit ledger (Cash/Bank accounts with spacial=2)
    function initPaymentLedgerSelect2() {
        $('#pay_debit_ledger_id').select2({
            ajax: {
                url: '/api/ledgers/lookup',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term || '',
                        spacial: 2  // Always filter by spacial=2 (Cash/Bank accounts)
                    };
                },
                processResults: function(data) {
                    // API returns {results: [...], pagination: {...}}
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

    // Receive Payment Button Click
    $('.receive-payment-btn').click(function() {
        const transactionId = $(this).data('id');
        
        // Reset form
        $('#paymentForm')[0].reset();
        $('#pay_transaction_id').val(transactionId);
        $('#pay_credit_ledger_id').val('');
        $('#pay_debit_ledger_id').val(null).trigger('change');
        
        // Show loading state
        $('#pay_serial_no').text('Loading...');
        $('#pay_customer_name').text('Loading...');
        $('#pay_total_amount').text('0.00');
        $('#pay_amount_received').text('0.00');
        $('#pay_remaining').text('0.00');
        
        // Fetch transaction data
        $.ajax({
            url: apiBaseUrl + '/' + transactionId,
            method: 'GET',
            success: function(res) {
                const transaction = res.data || res;
                
                // Display invoice info
                $('#pay_serial_no').text(transaction.serial_no || '-');
                $('#pay_total_amount').text(parseFloat(transaction.amount_of_invoice || 0).toFixed(2));
                $('#pay_amount_received').text(parseFloat(transaction.amount_received || 0).toFixed(2));
                
                const remaining = parseFloat(transaction.amount_of_invoice || 0) - parseFloat(transaction.amount_received || 0);
                $('#pay_remaining').text(remaining.toFixed(2));
                
                // Set default amount to remaining
                $('#pay_amount').val(remaining.toFixed(2));
                
                // Find customer name from journal lines (first debit line)
                let customerName = '-';
                let creditLedgerId = null;
                
                if (transaction.journal && transaction.journal.lines) {
                    for (let line of transaction.journal.lines) {
                        if (parseFloat(line.debit) > 0) {
                            customerName = line.ledger ? line.ledger.name : '-';
                            creditLedgerId = line.ledger_id;
                            break;
                        }
                    }
                }
                
                $('#pay_customer_name').text(customerName);
                $('#pay_credit_ledger_id').val(creditLedgerId);
            },
            error: function(err) {
                console.error('Error fetching transaction:', err);
                showMsg('#pay_error', 'Failed to load transaction data');
            }
        });
    });

    // Initialize payment ledger select when modal opens
    $('#paymentModal').on('shown.bs.modal', function() {
        // Always destroy and reinitialize to ensure it works
        if ($('#pay_debit_ledger_id').hasClass('select2-hidden-accessible')) {
            $('#pay_debit_ledger_id').select2('destroy');
        }
        initPaymentLedgerSelect2();
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script>
  $(document).ready(function() {

    // Helper: Show Alert
    function showMsg(selector, msg) {
        // Implementation might vary, ensuring minimal breakage if function missing
        if ($(selector).length) {
            $(selector).text(msg).show().delay(3000).fadeOut();
        } else {
            alert(msg);
        }
    }

    // Payment Form Submission
    $('#paymentForm').submit(function(e) {
        e.preventDefault();
        
        const transactionId = $('#pay_transaction_id').val();
        const creditLedgerId = $('#pay_credit_ledger_id').val();
        const debitLedgerId = $('#pay_debit_ledger_id').val();
        const amount = parseFloat($('#pay_amount').val());
        const paymentMode = parseInt($('#pay_payment_mode').val());
        
        // Validation
        if (!creditLedgerId) { showMsg('#pay_error', 'Cannot process payment: Customer ledger not found.'); return; }
        if (!debitLedgerId) { showMsg('#pay_error', 'Please select a Cash/Bank Account.'); return; }
        if (!amount || amount <= 0) { showMsg('#pay_error', 'Please enter a valid amount.'); return; }
        
        const data = {
            credit_ledger_id: parseInt(creditLedgerId),
            debit_ledger_id: parseInt(debitLedgerId),
            amount: amount,
            attachments: [],
            status: 'posted',
            payment_mode: paymentMode
        };
        
        $.ajax({
            url: apiBaseUrl + '/' + transactionId + '/receive-payment',
            method: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: function(res) {
                showMsg('#pay_success', 'Payment received successfully!');
                setTimeout(() => location.reload(), 1000);
            },
            error: function(err) {
                let msg = 'Error processing payment.';
                if (err.responseJSON && err.responseJSON.message) msg = err.responseJSON.message;
                showMsg('#pay_error', msg);
                console.error(err);
            }
        });
    });

    // ========== INVOICE VIEW/PRINT MODAL ==========

    // View Invoice Button Click
    $('.view-invoice-btn').click(function() {
        const transactionId = $(this).data('id');
        
        // Show loading, hide data
        $('#invoiceLoading').show();
        $('#invoiceData').hide();
        
        // Fetch transaction data
        $.ajax({
            url: apiBaseUrl + '/' + transactionId,
            method: 'GET',
            success: function(res) {
                const tx = res.data || res;
                
                // 1. Populate Header Info
                $('#inv_serial_no').text(tx.serial_no || '-');
                $('#inv_date').text(tx.created_at ? new Date(tx.created_at).toLocaleDateString() : '-');
                $('#inv_invoiced_at').text(tx.created_at ? new Date(tx.created_at).toLocaleString() : '-'); // using full datetime
                
                // TRN (Attempt to get from Ledger)
                let trn = '-';
                if (tx.ledger && tx.ledger.tax_number) trn = tx.ledger.tax_number;
                else if (tx.journal && tx.journal.lines) {
                    // Fallback to finding ledger in lines
                     for (let line of tx.journal.lines) {
                        if (parseFloat(line.debit) > 0 && line.ledger && line.ledger.tax_number) {
                            trn = line.ledger.tax_number;
                            break;
                        }
                    }
                }
                $('#inv_trn').text(trn);

                // Staff Name (Created By - placeholder if not in API)
                $('#inv_staff_name').text(tx.created_by_name || 'Admin'); 

                // 2. Customer Details
                let customerName = '-';
                let customerMobile = '-';
                let customerRef = '-'; // Ledger ID or Code

                if (tx.ledger) {
                    customerName = tx.ledger.name || '-';
                    customerRef = tx.ledger.id || '-';
                    // Try to find mobile in Note or CRM relation (not always exposed directly)
                    if(tx.customer_mobile) customerMobile = tx.customer_mobile;
                    else if(tx.ledger.note) customerMobile = tx.ledger.note; 
                } else if (tx.journal && tx.journal.lines) {
                    for (let line of tx.journal.lines) {
                        if (parseFloat(line.debit) > 0) {
                            customerName = line.ledger ? line.ledger.name : '-';
                            customerRef = line.ledger ? line.ledger.id : '-';
                            customerMobile = line.ledger ? (line.ledger.note || '-') : '-';
                            break;
                        }
                    }
                }
                $('#inv_customer_name').text(customerName);
                $('#inv_customer_ref').text(customerRef);
                $('#inv_mobile_no').text(customerMobile);

                // 3. Barcode Generation
                const barcodeValue = tx.serial_no || transactionId;
                if(barcodeValue) {
                    try {
                        JsBarcode("#inv_barcode", barcodeValue, {
                            format: "CODE128",
                            width: 1.5,
                            height: 35,
                            displayValue: false,
                            margin: 0
                        });
                        $('#inv_barcode_number').text(barcodeValue);
                    } catch(e) { console.error("Barcode Error", e); }
                }

                // 4. Services Table
                $('#inv_services_body').empty();
                const services = tx.services_json || [];
                let subtotal = 0;
                let totalVat = 0;
                
                if (services.length > 0) {
                    let rowNum = 1;
                    // We need to process asynchronously but keep order? 
                    // Actually usually service name is needed. Let's try to just list them.
                    // Ideally the API should return service names in services_json. 
                    // If not, we might need multiple calls or just show IDs if desperate.
                    // The previous code did sync ajax calls (bad practice but works for small number).
                    // improved: fetch all services if possible or keep the sync calls for now as it was working.
                    
                    services.forEach(function(svc) {
                         const unitPrice = parseFloat(svc.amount || 0);
                         const qty = parseFloat(svc.quantity || 1);
                         const lineTotal = parseFloat(svc.total_amount || unitPrice * qty);
                         subtotal += lineTotal;
                         
                         // Simple VAT calc (assuming 5% if not specified, or 0)
                         // Actually tax is usually in service definition. 
                         // Let's assume inclusive or 0 for now unless we fetch service.
                         let tax = 0; 
                         // previous code didn't calculate tax explicitly per line in table?
                         // It had columns: Govt Fee, Center Fee, Service Chg, Tax, Total.
                         // But `svc` usually only has `amount` and `quantity`.
                         // We need the service details. logic from previous code:
                         
                         $.ajax({
                            url: '/api/invoice-services/' + svc.invoice_service_id,
                            method: 'GET',
                            async: false, 
                            success: function(svcRes) {
                                const service = svcRes.data || svcRes;
                                const serviceName = (service.code || '') + ' - ' + (service.name || 'Unknown');
                                
                                // Mocking detailed breakdown if not in JSON
                                // Assuming amount is total unit price. 
                                // If we have breakdown in service model, we use it. 
                                // For now, let's put total in "Total" and maybe split if we knew how.
                                // The user's design has specific columns. 
                                // Let's just put the Amount in Total and Unit Price for now.
                                
                                // If the service object `svc` in services_json doesn't have breakdown, we can't invent it.
                                // We will display main values.
                                
                                const govtFee = parseFloat(service.govt_fee || 0);
                                const centerFee = parseFloat(service.center_fee || 0);
                                const serviceCharge = parseFloat(service.service_charge || 0);
                                // Tax is now calculated inclusively by backend
                                tax = parseFloat(service.tax || 0) * qty;
                                totalVat += tax;

                                $('#inv_services_body').append(`
                                    <tr>
                                        <td style="text-align: center; border: 1px solid #333;">${rowNum}</td>
                                        <td style="border: 1px solid #333;">
                                            <div style="font-weight: 500;">${serviceName}</div>
                                            <div style="font-size: 9px; color: #555;">${svc.dw || ''}</div>
                                        </td>
                                        <td style="text-align: center; border: 1px solid #333;">${qty}</td>
                                        <td style="text-align: center; border: 1px solid #333;">${(govtFee * qty).toFixed(2)}</td>
                                        <td style="text-align: center; border: 1px solid #333;">${(centerFee * qty).toFixed(2)}</td>
                                        <td style="text-align: center; border: 1px solid #333;">${(serviceCharge * qty).toFixed(2)}</td>
                                        <td style="text-align: center; border: 1px solid #333;">${tax.toFixed(2)}</td>
                                        <td style="text-align: right; border: 1px solid #333; font-weight: bold;">${lineTotal.toFixed(2)}</td>
                                    </tr>
                                `);
                                rowNum++;
                            }
                         });
                    });
                } else {
                     $('#inv_services_body').append('<tr><td colspan="8" class="text-center text-muted" style="border: 1px solid #333;">No services found</td></tr>');
                }

                // 5. Totals
                // subtotal is inclusive sum (Gross).
                const totalExcl = subtotal - totalVat;
                
                $('#inv_total_amount').text(totalExcl.toFixed(2));
                $('#inv_total_vat').text(totalVat.toFixed(2));
                $('#inv_net_total').text(subtotal.toFixed(2));
                
                // Add empty rows to fill the page for print
                const currentRows = $('#inv_services_body tr').length;
                const minRows = 5;
                if(currentRows < minRows) {
                     for (let i = 0; i < (minRows - currentRows); i++) {
                        $('#inv_services_body').append(`
                            <tr>
                                <td style="border: 1px solid #333;">&nbsp;</td>
                                <td style="border: 1px solid #333;">&nbsp;</td>
                                <td style="border: 1px solid #333;">&nbsp;</td>
                                <td style="border: 1px solid #333;">&nbsp;</td>
                                <td style="border: 1px solid #333;">&nbsp;</td>
                                <td style="border: 1px solid #333;">&nbsp;</td>
                                <td style="border: 1px solid #333;">&nbsp;</td>
                                <td style="border: 1px solid #333;">&nbsp;</td>
                            </tr>
                        `);
                    }
                }
                
                // Populate Received and Due
                const received = parseFloat(tx.amount_received || 0);
                const total = parseFloat(tx.amount_of_invoice || subtotal);
                const due = total - received;
                
                // Populate Comments with Payment History
                let commentsHtml = '';
                if(tx.receipt_vouchers && tx.receipt_vouchers.length > 0) {
                     commentsHtml += '<div style="margin-top: 5px; font-size: 10px;"><strong>Payment History:</strong></div>';
                     commentsHtml += '<ul style="list-style: none; padding-left: 0; margin-top: 2px;">';
                     tx.receipt_vouchers.forEach(function(rv) {
                         const rvDate = rv.created_at ? new Date(rv.created_at).toLocaleDateString() : '-';
                         const rvAmount = parseFloat(rv.amount || 0).toFixed(2);
                         const rvMode = rv.payment_mode_label || 'Cash';
                         const rvSerial = rv.serial_number || '';
                         commentsHtml += `<li>- Received <strong>${rvAmount}</strong> via ${rvMode} (${rvSerial}) on ${rvDate}</li>`;
                     });
                     commentsHtml += '</ul>';
                }
                $('#inv_comments').html(commentsHtml);

                $('#invoiceLoading').hide();
                $('#invoiceData').show();
            },
            error: function(err) {
                console.error('Error fetching invoice:', err);
                $('#invoiceLoading').html('<p class="text-danger">Failed to load invoice data</p>');
            }
        });
    });

    // Print Invoice
    $(document).on('click', '#btn_print_invoice', function() {
        window.print();
    });

  });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/typing_tran_gov_inv/index.blade.php ENDPATH**/ ?>