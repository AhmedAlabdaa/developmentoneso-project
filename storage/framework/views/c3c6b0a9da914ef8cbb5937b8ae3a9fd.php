<?php
use Carbon\Carbon;
use Illuminate\Support\Str;

$serverName     = request()->getHost();
$subdomain      = explode('.', $serverName)[0] ?? 'default';
$headerFileName = strtolower($subdomain) . '_header.jpg';
$footerFileName = strtolower($subdomain) . '_footer.jpg';
$headerImgUrl   = asset('assets/img/' . $headerFileName);
$footerImgUrl   = asset('assets/img/' . $footerFileName);

/**
 * Compute next voucher number by scanning existing vouchers with pattern ALB-PV-###
 */
$maxNum = 0;
foreach ($vouchers as $vv) {
    if (preg_match('/^ALB-PV-(\d+)$/', (string)$vv->voucher_no, $m)) {
        $n = (int)$m[1];
        if ($n > $maxNum) $maxNum = $n;
    }
}
$nextVoucherNo = 'ALB-PV-' . str_pad((string)($maxNum + 1), 3, '0', STR_PAD_LEFT);

/**
 * Today's ISO date in Asia/Dubai, (YYYY-MM-DD) – safe for DB
 */
$todayISO = Carbon::now('Asia/Dubai')->toDateString();

/**
 * Preload user map for created/approved/cancelled by
 */
$ids = [];
foreach ($vouchers as $v) {
    if ($v->created_by)   $ids[] = $v->created_by;
    if ($v->approved_by)  $ids[] = $v->approved_by;
    if ($v->cancelled_by) $ids[] = $v->cancelled_by;
}
$ids = array_values(array_unique(array_filter($ids)));
$userMap = $ids ? \App\Models\User::whereIn('id', $ids)->get()->keyBy('id') : collect();

$firstName = function ($id) use ($userMap) {
    if (!$id || !$userMap->has($id)) return '';
    $u = $userMap->get($id);
    if (isset($u->first_name) && $u->first_name) return $u->first_name;
    $name = $u->name ?? '';
    return trim(explode(' ', $name)[0] ?? '');
};
?>

<?php echo $__env->make('role_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
  .dataTables_info{font-size:12px}
  .dataTables_paginate{font-size:12px}
  .modal-lg{max-width:1000px}
  .grid{width:100%;border-collapse:collapse}
  .grid th,.grid td{border:1px solid #9aa3b2;padding:6px;vertical-align:middle;background:#fff}
  .grid thead th{background:#eef5ff}
  .amount{text-align:right}
  .line-input{width:100%;border:0;background:transparent;outline:none}
  .row-actions{white-space:nowrap;text-align:center}
  .btn-mini{display:inline-flex;align-items:center;justify-content:center;padding:4px 8px;border:0;color:#fff;font-size:11px;line-height:1}
  .btn-plus{background:linear-gradient(to right,#22c55e,#4ade80)}
  .btn-minus{background:linear-gradient(to right,#ef4444,#fb7185)}
  .pv-alert{display:none}
  a{text-decoration:none}
  #pvViewFrame{width:100%;height:75vh;border:0}
  .confirm-icon{width:88px;height:88px;border-radius:50%;border:6px solid #fcd29f;color:#f59e0b;display:flex;align-items:center;justify-content:center;font-size:48px;margin:0 auto 10px}
  @media print {.no-print{display:none!important}}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title mb-0">Payment Vouchers</h5>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pvModal">
            <i class="fa-solid fa-receipt me-1"></i> New Voucher
          </button>
        </div>

        <div class="table-responsive">
          <table id="pv-table" class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Voucher No</th>
                <th>Date</th>
                <th>Payee</th>
                <th>Mode</th>
                <th class="text-end">Debit</th>
                <th class="text-end">Credit</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Approved By</th>
                <th>Cancelled By</th>
                <th>Created</th>
                <th>Updated</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                  $linesData = $v->journal ? $v->journal->lines->map(function($l){
                      return [
                          'account' => $l->ledger_id,
                          'account_text' => $l->ledger->name ?? '',
                          'debit' => $l->debit,
                          'credit' => $l->credit
                      ];
                  }) : [];
              ?>
              <tr>
                <td><?php echo e($v->id); ?></td>
                <td><?php echo e($v->voucher_no); ?></td>
                <td><?php echo e($v->voucher_date->format('Y-m-d')); ?></td>
                <td><?php echo e($v->payee); ?></td>
                <td><?php echo e($v->mode_of_payment); ?></td>
                <td class="text-end"><?php echo e(number_format($v->journal->total_debit ?? 0, 2)); ?></td>
                <td class="text-end"><?php echo e(number_format($v->journal->total_credit ?? 0, 2)); ?></td>
                <td>
                  <?php if(auth()->user()->role === 'Finance Officer'): ?>
                    <select class="form-select form-select-sm status-select"
                            data-id="<?php echo e($v->id); ?>"
                            data-vno="<?php echo e($v->voucher_no); ?>"
                            data-name="<?php echo e($v->payee); ?>"
                            data-amount="<?php echo e(number_format($v->journal->total_debit ?? 0, 2, '.', '')); ?>"
                            data-current="<?php echo e($v->status); ?>">
                      <option value="Pending"   <?php if($v->status==='Pending'): echo 'selected'; endif; ?>>Pending</option>
                      <option value="Approved"  <?php if($v->status==='Approved'): echo 'selected'; endif; ?>>Approved</option>
                      <option value="Cancelled" <?php if($v->status==='Cancelled'): echo 'selected'; endif; ?>>Cancelled</option>
                    </select>
                  <?php else: ?>
                    <span class="badge <?php if($v->status==='Approved'): ?> bg-success <?php elseif($v->status==='Cancelled'): ?> bg-danger <?php else: ?> bg-secondary <?php endif; ?>"><?php echo e($v->status); ?></span>
                  <?php endif; ?>
                </td>
                <td><?php echo e($firstName($v->created_by)); ?></td>
                <td><?php echo e($firstName($v->approved_by)); ?></td>
                <td><?php echo e($firstName($v->cancelled_by)); ?></td>
                <td><?php echo e($v->created_at->format('Y-m-d')); ?></td>
                <td><?php echo e($v->updated_at->format('Y-m-d')); ?></td>
                <td class="text-center">
                  <button class="btn btn-secondary btn-sm view-btn"
                          data-bs-toggle="modal" data-bs-target="#pvViewModal"
                          data-id="<?php echo e($v->id); ?>"
                          data-vno="<?php echo e($v->voucher_no); ?>"
                          data-date="<?php echo e($v->voucher_date->format('Y-m-d')); ?>"
                          data-payee="<?php echo e($v->payee); ?>"
                          data-mode="<?php echo e($v->mode_of_payment); ?>"
                          data-ref="<?php echo e($v->reference_no); ?>"
                          data-narration="<?php echo e($v->narration); ?>"
                          data-lines='<?php echo json_encode($linesData, 15, 512) ?>'
                          data-td="<?php echo e(number_format($v->journal->total_debit ?? 0, 2, '.', '')); ?>"
                          data-tc="<?php echo e(number_format($v->journal->total_credit ?? 0, 2, '.', '')); ?>">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  <?php if($v->status === 'Pending'): ?>
                  <button class="btn btn-info btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#pvModal"
                          data-id="<?php echo e($v->id); ?>"
                          data-vno="<?php echo e($v->voucher_no); ?>"
                          data-date="<?php echo e($v->voucher_date->format('Y-m-d')); ?>"
                          data-payee="<?php echo e($v->payee); ?>"
                          data-mode="<?php echo e($v->mode_of_payment); ?>"
                          data-ref="<?php echo e($v->reference_no); ?>"
                          data-narration="<?php echo e($v->narration); ?>"
                          data-lines='<?php echo json_encode($linesData, 15, 512) ?>'>
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <?php endif; ?>
                  <?php if(auth()->user()->role === 'Finance Officer'): ?>
                  <button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo e($v->id); ?>"><i class="fa-solid fa-trash"></i></button>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
        <div class="mt-3">
          <?php echo e($vouchers->links('pagination::bootstrap-5')); ?>

        </div>

      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="pvModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="pvForm" class="w-100" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="_method" id="pv_method" value="POST">
      <input type="hidden" name="id" id="pv_id">
      <input type="hidden" name="voucher_no" id="voucher_no">
      <input type="hidden" name="total_debit" id="total_debit">
      <input type="hidden" name="total_credit" id="total_credit">
      <input type="hidden" name="lines_json" id="lines_json">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title"><i class="fa-solid fa-receipt me-1"></i> <span id="pv_title">New Payment Voucher</span></h6>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Voucher #</label>
              <input type="text" class="form-control" id="voucher_no_display" placeholder="Auto-generated" disabled>
            </div>
            <div class="col-md-4">
              <label class="form-label">Date *</label>
              <!-- Visible display input -->
              <input type="text" class="form-control" id="voucher_date_display" placeholder="06 Oct 2025" autocomplete="off">
              <!-- Stores ISO YYYY-MM-DD for DB -->
              <input type="hidden" id="voucher_date" name="voucher_date">
            </div>
            <div class="col-md-4">
              <label class="form-label">Mode of Payment *</label>
              <select class="form-select" id="mode_of_payment" name="mode_of_payment" required>
                <option value="" disabled selected>Choose</option>
                <optgroup label="Cash">
                  <option value="CASH">CASH</option>
                  <option value="CHEQUE">CHEQUE</option>
                </optgroup>
                <optgroup label="ADCB">
                  <option value="ADCB Main">ADCB Main</option>
                  <option value="ADCB 2">ADCB 2</option>
                  <option value="ADCB 3">ADCB 3</option>
                </optgroup>
                <optgroup label="ADIB">
                  <option value="ADIB 783">ADIB 783</option>
                  <option value="ADIB 761">ADIB 761</option>
                </optgroup>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Payee *</label>
              <input type="text" class="form-control" id="payee" name="payee" placeholder="Enter payee name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Reference No</label>
              <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="Optional reference number">
            </div>
            <div class="col-12">
              <table class="grid" id="linesTable">
                <thead>
                  <tr>
                    <th style="width:52%">Chart of Account</th>
                    <th class="text-center" style="width:16%">Debit (AED)</th>
                    <th class="text-center" style="width:16%">Credit (AED)</th>
                    <th class="text-center" style="width:16%">Actions</th>
                  </tr>
                </thead>
                <tbody id="linesBody">
                  <tr>
                    <td>
                      <select class="line-input coa-select form-select" style="width: 100%">
                        <option value="" selected disabled>Type to search...</option>
                      </select>
                    </td>
                    <td class="amount"><input class="line-input form-control dr" inputmode="decimal" placeholder="0.00"></td>
                    <td class="amount"><input class="line-input form-control cr" inputmode="decimal" placeholder="0.00"></td>
                    <td class="row-actions">
                      <button type="button" class="btn-mini btn-plus addRow"><i class="fa-solid fa-plus"></i></button>
                      <button type="button" class="btn-mini btn-minus delRow"><i class="fa-solid fa-minus"></i></button>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-end">Total Debit:</th>
                    <td class="amount" id="totDr">AED 0.00</td>
                    <th class="text-end">Total Credit:</th>
                    <td class="amount" id="totCr">AED 0.00</td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="col-12">
              <label class="form-label">Narration / Remarks</label>
              <input type="text" class="form-control" id="narration" name="narration" placeholder="Narration / Remarks">
            </div>
            <div class="col-12">
              <label class="form-label">Proof / Attachments</label>
              <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
              <div class="form-text">Optional supporting documents for this voucher</div>
            </div>
            <div class="col-12">
              <div id="pv_error" class="pv-alert alert alert-danger py-2 px-3"></div>
              <div id="pv_success" class="pv-alert alert alert-success py-2 px-3"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer no-print">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-circle-xmark me-1"></i> Close</button>
          <button type="button" id="btn_save" class="btn btn-success btn-sm"><i class="fa-solid fa-floppy-disk me-1"></i> Save</button>
          <button type="button" id="btn_save_print" class="btn btn-primary btn-sm"><i class="fa-solid fa-print me-1"></i> Save & Print</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="pvViewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h6 class="modal-title"><i class="fa-solid fa-eye me-1"></i> View Payment Voucher</h6>
        <div class="d-flex gap-2">
          <button type="button" id="btn_view_print" class="btn btn-primary btn-sm"><i class="fa-solid fa-print me-1"></i> Print</button>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
      </div>
      <div class="modal-body p-0">
        <iframe id="pvViewFrame"></iframe>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="statusConfirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-3">
      <div class="confirm-icon">!</div>
      <h4 id="statusConfirmTitle" class="fw-bold mb-3"></h4>
      <p id="statusConfirmSubtitle" class="mb-3"></p>
      <div class="d-flex gap-2 justify-content-center pb-2">
        <button type="button" class="btn btn-success px-4" id="statusConfirmYes">Yes</button>
        <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<select id="coa-master" class="d-none">
  <option value="" selected disabled>Choose</option>
  <optgroup label="Assets">
    <option>Accounts Receivable</option>
    <option>ADCB- 12847639920001-AED (Main Account)</option>
    <option>ADCB- 12847639920002-AED (Card)</option>
    <option>ADCB- 12847639920003-AED (Card)</option>
    <option>ADIB- 19114761</option>
    <option>ADIB- 19136783</option>
    <option>Cash on Hand</option>
    <option>dubai card</option>
    <option>Due from Company AL HABESHA (Intercompany)</option>
    <option>Employees Receivables</option>
    <option>General Advance to Staff / Others</option>
    <option>Input VAT</option>
    <option>Loan to Staff</option>
    <option>METTPAY-385756990345</option>
    <option>NOQODI-DW484879</option>
    <option>Other Receivables</option>
    <option>Pay Pro wallet-234875399</option>
    <option>Petty Cash</option>
    <option>POS-ID 60043758</option>
    <option>POS-ID 60045161</option>
    <option>Prepaid Expenses</option>
    <option>Salary Advance to Staff</option>
    <option>Security Deposits</option>
    <option>Tangible-Fixed Assets</option>
    <option>Unclassified Cash Payment</option>
    <option>XPENCE-10783165</option>
  </optgroup>
  <optgroup label="Liabilities">
    <option>Accounts Payable</option>
    <option>Accrued Expenses</option>
    <option>Customer Deposits / Advances Received</option>
    <option>Deferred Revenue</option>
    <option>Employee Annual Air Ticket Allowance Payable</option>
    <option>FULL AND FINAL SETTLEMENT</option>
    <option>Maid Salaries Payable</option>
    <option>Opening Balance Adjustments</option>
    <option>Output VAT</option>
    <option>Payable – GPSSA</option>
    <option>PDC Payable</option>
    <option>Refund Payables</option>
    <option>Refunds Payable</option>
    <option>Salary Payables</option>
    <option>Sales Commission Payable</option>
    <option>Security Deposit from Customers</option>
    <option>Short-term Loan from Owner / Director</option>
    <option>Staff Salaries Payable</option>
    <option>Utilities Payable</option>
    <option>VAT Payable</option>
  </optgroup>
  <optgroup label="Equities">
    <option>Owner’s Capital</option>
  </optgroup>
  <optgroup label="Income">
    <option>Delivery Fee</option>
    <option>General Income</option>
    <option>MOHRE INCOME</option>
    <option>Office deduction</option>
    <option>Sales</option>
    <option>UNKNOWN CUSTOMER PAYMENTS</option>
  </optgroup>
  <optgroup label="Expense">
    <option>ACCOMDATION RENT</option>
    <option>Advertising And Marketing</option>
    <option>AIR TICKET FOR HOUSEMAID</option>
    <option>AIR TICKET FOR STAFF</option>
    <option>Allowances & Benefits</option>
    <option>Automobile Expense</option>
    <option>Bank & Card Charges</option>
    <option>Bonuses & Commissions</option>
    <option>Charity & Donations Expense</option>
    <option>COGS MOHRE</option>
    <option>Cost of Goods Sold</option>
    <option>DELIVERY EXPENSE</option>
    <option>DUBAI INSURANCE</option>
    <option>EMPLOYEE SALARY</option>
    <option>Employment Expenses</option>
    <option>GPSSA-Exchange Charges</option>
    <option>IT and Internet Expenses</option>
    <option>Legal & Professional Fees</option>
    <option>MAID SALARY</option>
    <option>Meals & Entertainment</option>
    <option>MEDICINE AND HOSPITAL EXPENSE</option>
    <option>Noqodi Charges</option>
    <option>Office Equipment Repair & Maintenance</option>
    <option>Office Repairs and Maintenance Expense</option>
    <option>Office Supplies</option>
    <option>OTHER PAYMENT</option>
    <option>OUTPASS FOR MAID</option>
    <option>Postage & Courier</option>
    <option>Recruitment Expenses</option>
    <option>Rent Expense</option>
    <option>Salaries and Wages Expense</option>
    <option>Sales Commission</option>
    <option>Software & Development</option>
    <option>SOLOMON PHP OFFICE</option>
    <option>Staff Salary</option>
    <option>Staff Welfare & Other Expense</option>
    <option>Stationary & Printing Expense</option>
    <option>STORAGE SPACE</option>
    <option>Taxi / Public Transport</option>
    <option>Travelling Expense</option>
    <option>Unclassified Cash Expenses</option>
    <option>Utilities Expense</option>
    <option>WPS Charges</option>
    <option>Agent Commission</option>
  </optgroup>
</select>

<?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
<script>
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

  const storeUrl      = "<?php echo e(route('payment-vouchers.store')); ?>";
  const updateUrl     = "<?php echo e(route('payment-vouchers.update', ':id')); ?>";
  const destroyUrl    = "<?php echo e(route('payment-vouchers.destroy', ':id')); ?>";
  const statusUrl     = "<?php echo e(route('payment-vouchers.status', ':id')); ?>";
  const headerImg     = <?php echo json_encode($headerImgUrl, 15, 512) ?>;
  const footerImg     = <?php echo json_encode($footerImgUrl, 15, 512) ?>;
  const nextVoucherNo = <?php echo json_encode($nextVoucherNo, 15, 512) ?>;
  const todayISO      = <?php echo json_encode($todayISO, 15, 512) ?>; // "YYYY-MM-DD" from server in Asia/Dubai


  // ======== DATE UTILITIES (NO UTC CONVERSION) ========
  const MONTHS_SHORT = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

  // Format a Date object into YYYY-MM-DD using LOCAL calendar fields
  function toISODateLocal(d){
    const y = d.getFullYear();
    const m = String(d.getMonth()+1).padStart(2,'0');
    const day = String(d.getDate()).padStart(2,'0');
    return `${y}-${m}-${day}`;
  }

  // Format ISO YYYY-MM-DD -> "DD Mon YYYY" (e.g., "06 Oct 2025")
  function fmtDMY(iso){
    if(!iso || !/^\d{4}-\d{2}-\d{2}$/.test(iso)) return '';
    const [y, m, d] = iso.split('-');
    const idx = Math.max(0, Math.min(11, parseInt(m,10)-1));
    return `${d.padStart(2,'0')} ${MONTHS_SHORT[idx]} ${y}`;
  }

  // Parse "06 Oct 2025" -> Date (LOCAL noon to avoid DST/UTC edge cases)
  function parseDMYToDate(dmy){
    const m = String(dmy||'').trim().match(/^(\d{1,2})\s+([A-Za-z]{3,})\s+(\d{4})$/);
    if(!m) return null;
    const day = parseInt(m[1],10);
    const mon3 = m[2].slice(0,3).toLowerCase();
    const y = parseInt(m[3],10);
    const mi = MONTHS_SHORT.findIndex(x=>x.toLowerCase()===mon3);
    if(mi < 0) return null;
    // create at 12:00 local to avoid DST midnight surprises
    return new Date(y, mi, day, 12, 0, 0, 0);
  }
  // ================================================

  function money(n){ return 'AED ' + Number(n||0).toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2}); }
  function parseAmt(v){ const x = parseFloat(String(v).replace(/,/g,'')); return isNaN(x)?0:+x; }
  function showMsg(id,msg){ const $el=$(id); $el.text(msg).show(); setTimeout(()=>{$el.fadeOut(250)},2500); }
  function escapeHtml(s){ return String(s||'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }
  function getCoaOptionsHtml(){ return $('#coa-master').html(); }

  // Initialize Select2 on a COA select element
  function initSelect2($select, initialId='', initialText='') {
    $select.select2({
      ajax: {
        url: '/api/ledgers/lookup',
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
            pagination: {
              more: data.pagination.more
            }
          };
        },
        cache: true
      },
      minimumInputLength: 3,
      placeholder: 'Type at least 3 characters to search...',
      allowClear: true,
      width: '100%',
      dropdownParent: $('#pvModal')
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
  }

  function makeRow(id='', text='', debit='', credit=''){
    const $row = $(`
      <tr>
        <td><select class="line-input coa-select form-select" style="width: 100%"><option value="" selected disabled>Type to search...</option></select></td>
        <td class="amount"><input class="line-input form-control dr" inputmode="decimal" placeholder="0.00" value="${debit}"></td>
        <td class="amount"><input class="line-input form-control cr" inputmode="decimal" placeholder="0.00" value="${credit}"></td>
        <td class="row-actions">
          <button type="button" class="btn-mini btn-plus addRow"><i class="fa-solid fa-plus"></i></button>
          <button type="button" class="btn-mini btn-minus delRow"><i class="fa-solid fa-minus"></i></button>
        </td>
      </tr>
    `);
    const $sel = $row.find('.coa-select');
    initSelect2($sel, id, text);
    return $row;
  }

  function recalc(){
    let dr=0,cr=0;
    $('#linesBody tr').each(function(){
      dr+=parseAmt($(this).find('.dr').val());
      cr+=parseAmt($(this).find('.cr').val());
    });
    $('#totDr').text(money(dr));
    $('#totCr').text(money(cr));
    $('#total_debit').val(dr.toFixed(2));
    $('#total_credit').val(cr.toFixed(2));
  }

  function rowFilled($tr){
    const acc=$tr.find('.coa-select').val();
    const d=parseAmt($tr.find('.dr').val());
    const c=parseAmt($tr.find('.cr').val());
    if(!acc && d===0 && c===0) return false;
    if(!acc) return false;
    if(d>0 && c>0) return false;
    if(d===0 && c===0) return false;
    return true;
  }

  function addRowAfter($tr){
    if(!rowFilled($tr)){ showMsg('#pv_error','Complete the row before adding a new one'); return; }
    $tr.after(makeRow());
  }

  function buildLines(){
    const lines=[];
    $('#linesBody tr').each(function(){
      const $tr=$(this);
      const accId=$tr.find('.coa-select').val()||'';
      const accText=$tr.find('.coa-select option:selected').text()||'';
      const d=parseAmt($tr.find('.dr').val());
      const c=parseAmt($tr.find('.cr').val());
      if(accId||d>0||c>0){
        if(!rowFilled($tr)) throw new Error('row');
        lines.push({account: accId, account_text: accText, debit:+d.toFixed(2),credit:+c.toFixed(2)});
      }
    });
    if(lines.length===0) throw new Error('nolines');
    const dr=lines.reduce((s,l)=>s+l.debit,0), cr=lines.reduce((s,l)=>s+l.credit,0);
    if(Math.abs(dr-cr)>=0.005) throw new Error('unbalanced');
    return lines;
  }



  function buildVoucherHtml(payload){
    const rows = (payload.lines||[]).map(l=>`
      <tr>
        <td>${escapeHtml(l.account_text || l.account)}</td>
        <td class="text-end">${l.debit? Number(l.debit).toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2}):''}</td>
        <td class="text-end">${l.credit? Number(l.credit).toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2}):''}</td>
      </tr>`).join('');
    const totalDr = Number(payload.totals.debit||0).toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2});
    const totalCr = Number(payload.totals.credit||0).toLocaleString(undefined,{minimumFractionDigits:2,maximumFractionDigits:2});
    return `
      <html>
      <head>
        <meta charset="utf-8"><title>Payment Voucher</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
          @page{size:A4;margin:12mm}
          body{font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#111827}
          .grid{width:100%;border-collapse:collapse}
          .grid th,.grid td{border:1px solid #9aa3b2;padding:6px;vertical-align:middle;background:#fff}
          .grid thead th{background:#eef5ff}
          .pv-title{font-weight:700;font-size:18px;margin:10mm 0 6mm;text-align:center}
          .hdr img{width:100%;display:block;margin-bottom:10mm}
          .ftr img{width:100%;display:block;margin-top:10mm}
          .sig-line{height:28px;border-bottom:1px solid #777;text-align:center;padding-top:12px}
          .mt-6mm{margin-top:6mm}
        </style>
      </head>
      <body>
        <div class="hdr"><img src="${headerImg}"></div>
        <div class="container-fluid">
          <div class="pv-title">Payment Voucher</div>
          <table class="grid">
            <tbody>
              <tr>
                <th style="width:18%">Voucher No.:</th>
                <td style="width:32%">${escapeHtml(payload.voucher_no)}</td>
                <th style="width:12%">Date:</th>
                <td style="width:38%">${escapeHtml(fmtDMY(payload.voucher_date))}</td>
              </tr>
              <tr>
                <th>Payee / Paid To:</th>
                <td>${escapeHtml(payload.payee)}</td>
                <th>Mode of Payment:</th>
                <td>${escapeHtml(payload.mode_of_payment)}</td>
              </tr>
              <tr>
                <th>Reference No.:</th>
                <td>${escapeHtml(payload.reference_no||'')}</td>
                <th></th><td></td>
              </tr>
            </tbody>
          </table>

          <div class="mt-3 fw-bold">Entry Details</div>
          <table class="grid">
            <thead>
              <tr>
                <th style="width:50%">Chart of Account</th>
                <th class="text-center" style="width:25%">Debit (AED)</th>
                <th class="text-center" style="width:25%">Credit (AED)</th>
              </tr>
            </thead>
            <tbody>${rows}</tbody>
          </table>

          <div class="d-flex justify-content-center gap-5 mt-3">
            <div><b>Total Debit:</b> ${totalDr}</div>
            <div><b>Total Credit:</b> ${totalCr}</div>
          </div>

          <div class="mt-3"><b>Narration / Remarks:</b> ${escapeHtml(payload.narration||'')}</div>

          <table class="w-100 mt-6mm">
            <tr>
              <td class="sig-line" style="width:33%">Prepared By</td>
              <td class="sig-line" style="width:33%">Approved By</td>
              <td class="sig-line" style="width:34%">Received By</td>
            </tr>
          </table>
        </div>
        <div class="ftr"><img src="${footerImg}"></div>
      </body>
      </html>`;
  }

  function printVoucher(payload){
    const html = buildVoucherHtml(payload).replace('</body>', '<script>window.onload=function(){setTimeout(function(){window.print()},120)}<\/script></body>');
    const w = window.open('', '_blank');
    w.document.open(); w.document.write(html); w.document.close();
  }

  // Flatpickr bound to the visible field; we control parsing/formatting and
  // fill the hidden ISO field WITHOUT using toISOString()
  const fp = flatpickr("#voucher_date_display", {
    dateFormat: "d M Y",
    allowInput: true,
    clickOpens: true,
    // robust custom parse (e.g., "06 Oct 2025")
    parseDate: (datestr) => {
      const d = parseDMYToDate(datestr);
      return d || new Date(); // fallback
    },
    // robust custom format (shows "06 Oct 2025")
    formatDate: (date) => fmtDMY(toISODateLocal(date)),
    onChange: function(selectedDates){
      const d = selectedDates[0];
      const iso = d ? toISODateLocal(d) : '';
      document.getElementById('voucher_date').value = iso;
    },
    onClose: function(selectedDates, dateStr, instance){
      // Handle manual edits
      const manual = $('#voucher_date_display').val();
      const d = parseDMYToDate(manual);
      if (d) {
        instance.setDate(d, true);
        $('#voucher_date').val(toISODateLocal(d));
      } else {
        // invalid manual input – clear both
        $('#voucher_date_display').val('');
        $('#voucher_date').val('');
      }
    }
  });

  $(function(){
    $('#pv-table').DataTable({
      paging: false,
      info: false,
      searching: false,
      ordering: false
    });

    // Initialize Select2 on all existing COA selects on page load
    $('.coa-select').each(function() {
      initSelect2($(this));
    });



    // Reinitialize Select2 when modal is shown (Select2 doesn't work well on hidden elements)
    $('#pvModal').on('shown.bs.modal', function () {
      $('.coa-select').each(function() {
        // Force re-initialization to ensure correct width and visibility
        if ($(this).hasClass('select2-hidden-accessible')) {
             $(this).select2('destroy');
        }
        initSelect2($(this));
      });
    });

    $('#linesBody').on('input','input,select',recalc);
    $('#linesBody').on('click','.addRow',function(){ addRowAfter($(this).closest('tr')); recalc(); });
    $('#linesBody').on('click','.delRow',function(){
      const $tr=$(this).closest('tr');
      if($('#linesBody tr').length===1){
        $tr.find('.coa').val(''); $tr.find('.dr').val(''); $tr.find('.cr').val('');
      }else{ $tr.remove(); }
      recalc();
    });



    // ===== Modal show (New vs Edit) with SAFE date handling =====
    $('#pvModal').on('show.bs.modal', function(e){
      const btn = $(e.relatedTarget);
      if (btn && btn.hasClass('edit-btn')) {
        $('#pv_title').text('Edit Payment Voucher');
        $('#pv_method').val('POST');
        const id = btn.data('id');
        $('#pvForm').attr('action', updateUrl.replace(':id', id));
        $('#pv_id').val(id);

        const vno = btn.data('vno');
        $('#voucher_no').val(vno);
        $('#voucher_no_display').val(vno);

        const iso = btn.data('date'); // already "YYYY-MM-DD" from blade
        $('#voucher_date').val(iso);
        fp.setDate(iso, true, 'Y-m-d'); // sets both display & hidden
        $('#voucher_date_display').val(fmtDMY(iso));

        $('#payee').val(btn.data('payee'));
        $('#mode_of_payment').val(btn.data('mode'));
        $('#reference_no').val(btn.data('ref'));
        $('#narration').val(btn.data('narration'));

        $('#linesBody').empty();
        const lines = btn.data('lines') || [];
        if(lines.length){
          lines.forEach(l=>{
            const row = makeRow(l.account || '', l.account_text || '', Number(l.debit||0).toFixed(2), Number(l.credit||0).toFixed(2));
            $('#linesBody').append(row);
          });
        } else {
          $('#linesBody').append(makeRow());
        }
        $('#attachments').val('');
        recalc();
      } else {
        $('#pv_title').text('New Payment Voucher');
        $('#pvForm').attr('action', storeUrl).trigger('reset');
        $('#pv_id').val(''); $('#pv_method').val('POST');

        $('#voucher_no').val(nextVoucherNo);
        $('#voucher_no_display').val(nextVoucherNo);

        $('#linesBody').html('');
        $('#linesBody').append(makeRow());

        // Use server-provided ISO date; set both fields explicitly
        $('#voucher_date').val(todayISO);
        fp.setDate(todayISO, true, 'Y-m-d');
        $('#voucher_date_display').val(fmtDMY(todayISO));


        $('#attachments').val('');
        recalc();
      }
      $('#pv_error').hide().text(''); $('#pv_success').hide().text('');
    });

    function gatherAndValidate(){
      try{
        const lines = buildLines();
        $('#lines_json').val(JSON.stringify(lines));
      }catch(err){
        if(err.message==='unbalanced'){ showMsg('#pv_error','Totals are not balanced'); }
        else { showMsg('#pv_error','Each line needs an account and either Debit or Credit (not both). Add at least one line'); }
        return false;
      }
      if(!$('#voucher_no').val() || !$('#voucher_date').val() || !$('#payee').val() || !$('#mode_of_payment').val()){
        showMsg('#pv_error','Voucher, Date, Payee and Mode of Payment are required');
        return false;
      }
      // Ensure voucher_date is strict ISO YYYY-MM-DD
      if(!/^\d{4}-\d{2}-\d{2}$/.test($('#voucher_date').val())){
        showMsg('#pv_error','Invalid date');
        return false;
      }
      return true;
    }

    function postForm(onSuccess){
      const form = document.getElementById('pvForm');
      const fd = new FormData(form);
      $.ajax({
        url: $('#pvForm').attr('action'),
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false
      })
      .done(function(res){
        showMsg('#pv_success', (res && res.message) ? res.message : 'Saved successfully');
        if(typeof onSuccess === 'function') onSuccess(res);
        setTimeout(()=>location.reload(), 700);
      })
      .fail(function(xhr){
        const r = xhr.responseJSON;
        if (r && r.errors) {
          const flat = [];
          Object.values(r.errors).forEach(arr=>{ [].concat(arr).forEach(m=>flat.push(m)); });
          showMsg('#pv_error', flat.join(' | '));
        } else {
          showMsg('#pv_error', r?.message || 'Request failed');
        }
      });
    }

    $('#btn_save').on('click', function(){
      if(!gatherAndValidate()) return;
      postForm();
    });

    $('#btn_save_print').on('click', function(){
      if(!gatherAndValidate()) return;
      const payload = {
        voucher_no: $('#voucher_no').val(),
        voucher_date: $('#voucher_date').val(), // ISO
        payee: $('#payee').val(),
        mode_of_payment: $('#mode_of_payment').val(),
        reference_no: $('#reference_no').val(),
        narration: $('#narration').val(),
        totals: { debit: $('#total_debit').val(), credit: $('#total_credit').val() },
        lines: JSON.parse($('#lines_json').val() || '[]')
      };
      postForm(function(){ printVoucher(payload); });
    });

    $(document).on('click','.delete-btn',function(){
      if(!confirm('Delete this voucher?')) return;
      const id=$(this).data('id');
      $.post(destroyUrl.replace(':id', id), {})
        .done(()=>location.reload())
        .fail(xhr=>showMsg('#pv_error', xhr.responseJSON?.message || 'Could not delete'));
    });

    $(document).on('click','.view-btn',function(){
      const btn = $(this);
      const payload = {
        voucher_no: btn.data('vno'),
        voucher_date: btn.data('date'), // ISO
        payee: btn.data('payee'),
        mode_of_payment: btn.data('mode'),
        reference_no: btn.data('ref'),
        narration: btn.data('narration'),
        totals: { debit: btn.data('td'), credit: btn.data('tc') },
        lines: btn.data('lines') || []
      };
      const html = buildVoucherHtml(payload);
      const iframe = document.getElementById('pvViewFrame');
      iframe.srcdoc = html;
      setTimeout(()=>{ iframe.contentWindow && iframe.contentWindow.focus(); }, 150);
    });

    $('#btn_view_print').on('click', function(){
      const iframe = document.getElementById('pvViewFrame');
      if (iframe && iframe.contentWindow) { iframe.contentWindow.print(); }
    });

    let statusPendingPayload = null;
    let statusConfirmed = false;

    $(document).on('focusin', '.status-select', function(){
      $(this).data('prev', this.value);
    });

    $(document).on('change','.status-select',function(){
      const $sel = $(this);
      const id   = $sel.data('id');
      const name = $sel.data('name');
      const vno  = $sel.data('vno');
      const amt  = parseFloat($sel.data('amount') || 0);
      const toStatus = $sel.val();
      statusConfirmed = false;
      statusPendingPayload = { id, toStatus, $sel, prev: $sel.data('prev') || $sel.data('current') };
      $('#statusConfirmTitle').text(`Change status for ${name} (${vno}) - Amount: ${amt.toFixed(2)}?`);
      $('#statusConfirmSubtitle').text(`Switch to "${toStatus}"?`);
      const modal = new bootstrap.Modal(document.getElementById('statusConfirmModal'));
      modal.show();
    });

    document.getElementById('statusConfirmModal').addEventListener('hidden.bs.modal', function () {
      if(statusPendingPayload && !statusConfirmed){
        const { $sel, prev } = statusPendingPayload;
        $sel.val(prev);
      }
      statusPendingPayload = null;
    });

    $('#statusConfirmYes').on('click', function(){
      const btn = $(this);
      btn.disabled = true;
      const modalEl = document.getElementById('statusConfirmModal');
      const modal = bootstrap.Modal.getInstance(modalEl);
      if(!statusPendingPayload) { btn.disabled=false; modal.hide(); return; }
      const { id, toStatus } = statusPendingPayload;
      $.post(statusUrl.replace(':id', id), { status: toStatus })
        .done(()=>{ statusConfirmed = true; location.reload(); })
        .fail(xhr=>{
          showMsg('#pv_error', xhr.responseJSON?.message || 'Status update failed');
          statusConfirmed = false;
        })
        .always(()=>{ btn.disabled=false; modal.hide(); });
    });
  });
</script>
<?php /**PATH /var/www/developmentoneso-project/resources/views/payment_voucher/index.blade.php ENDPATH**/ ?>