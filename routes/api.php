<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\LedgerOfAccountController;
use App\Http\Controllers\JournalHeaderController;
use App\Http\Controllers\JournalTranLineController;
use App\Http\Controllers\InvoiceServiceController;
use App\Http\Controllers\TypingTranGovInvController;
use App\Http\Controllers\ReceiptVoucherController;
use App\Http\Controllers\PackageOneController;
use App\Http\Controllers\StatementOfAccountController;
use App\Http\Controllers\BulkJournalImportController;
use App\Http\Controllers\TrialBalanceController;
use App\Http\Controllers\AmMonthlyContractController;
use App\Http\Controllers\AmReturnMaidController;
use App\Http\Controllers\AmReturnActionController;
use App\Http\Controllers\AmContractMovementController;
use App\Http\Controllers\AmInstallmentController;
use App\Http\Controllers\AmIncidentController;
use App\Http\Controllers\Amp3ActionNotifyController;
use App\Http\Controllers\DeductionPayrollController;

Route::get('candidates/getOutsideCandidatesAPI', [CandidateController::class, 'getOutsideCandidatesAPI'])
    ->name('candidates.list');
Route::get('candidates/getCandidateBySlug', [CandidateController::class, 'getCandidateBySlug']);



// Ledger of Accounts API Resource Routes (Protected by Authentication)
// Route::middleware('auth:sanctum')->group(function () {

    Route::get('ledgers/lookup', [LedgerOfAccountController::class, 'lookup']);
    Route::get('ledgers/lookup-customers', [LedgerOfAccountController::class, 'lookupCustomer']);
    Route::get('invoice-services/lookup', [InvoiceServiceController::class, 'lookup']);
    Route::post('journals/bulk-import', [BulkJournalImportController::class, 'import'])->name('api.journals.bulk-import');
    Route::apiResource('journals', JournalHeaderController::class)->names('api.journals');
    Route::post('journal-tran-lines/bulk-update-status', [JournalTranLineController::class, 'bulkUpdateStatus'])->name('api.journal-tran-lines.bulk-update-status');
    Route::get('journal-tran-lines', [JournalTranLineController::class, 'index']);
    Route::get('trial-balance', [TrialBalanceController::class, 'index'])->name('api.trial-balance');
    Route::get('ledgers/export', [LedgerOfAccountController::class, 'exportExcel'])->name('api.ledgers.export');
    Route::apiResource('ledgers', LedgerOfAccountController::class)->names('api.ledgers');
    Route::get('statement-of-account/{ledger_id}', [StatementOfAccountController::class, 'show'])->name('api.statement-of-account');
    Route::get('statement-of-account/{ledger_id}/export', [StatementOfAccountController::class, 'export'])->name('api.statement-of-account.export');
    Route::apiResource('invoice-services', InvoiceServiceController::class)->names('api.invoice-services');
    Route::post('typing-tran-gov-invs/{id}/receive-payment', [TypingTranGovInvController::class, 'receivePayment']);
    Route::apiResource('typing-tran-gov-invs', TypingTranGovInvController::class)->names('api.typing-tran-gov-invs');
    Route::apiResource('receipt-vouchers', ReceiptVoucherController::class)->names('api.receipt-vouchers');
    Route::post('package-one/received-voucher', [PackageOneController::class, 'receivedVoucher'])->name('api.package-one.received-voucher');
    Route::post('package-one/credit-note', [PackageOneController::class, 'creditNote'])->name('api.package-one.credit-note');
    Route::post('package-one/charging', [PackageOneController::class, 'charging'])->name('api.package-one.charging');
    Route::apiResource('package-one', PackageOneController::class)->except(['update'])->names('api.package-one');
    //for am monthly contracts
    Route::get('am-monthly-contracts/lookup-employees', [AmMonthlyContractController::class, 'lookupEmployee'])->name('api.am-monthly-contracts.lookup-employees');
    Route::get('am-monthly-contracts/lookup-all-employees', [AmMonthlyContractController::class, 'lookupAllEmployees'])->name('api.am-monthly-contracts.lookup-all-employees');
    Route::get('am-monthly-contracts/lookup-customers', [AmMonthlyContractController::class, 'lookupCustomer'])->name('api.am-monthly-contracts.lookup-customers');
    Route::get('am-monthly-contracts/employees', [AmMonthlyContractController::class, 'employees'])->name('api.am-monthly-contracts.employees');
    Route::get('am-monthly-contracts/all-employees', [AmMonthlyContractController::class, 'allEmployees'])->name('api.am-monthly-contracts.all-employees');
    Route::post('am-monthly-contracts/{id}/return', [AmReturnMaidController::class, 'returnContract'])->name('api.am-monthly-contracts.return');
    Route::apiResource('am-incidents', AmIncidentController::class)->names('api.am-incidents');
    Route::apiResource('amp3-action-notifies', Amp3ActionNotifyController::class)->names('api.amp3-action-notifies');
    Route::apiResource('deduction-payrolls', DeductionPayrollController::class)->names('api.deduction-payrolls');
    Route::apiResource('am-monthly-contracts', AmMonthlyContractController::class);
    // Dedicated contract-movement, installment, and return-maid CRUD routes
    Route::apiResource('am-contract-movements', AmContractMovementController::class)->except(['store'])->names('api.am-contract-movements');
    Route::apiResource('am-installments', AmInstallmentController::class)->only(['index'])->names('api.am-installments');
    Route::get('am-return-maids', [AmReturnMaidController::class, 'returnMaids'])->name('api.am-return-maids.index');
    Route::get('am-return-maids/{id}', [AmReturnMaidController::class, 'show'])->name('api.am-return-maids.show');
    Route::post('am-return-maids/{id}/replacement', [AmReturnMaidController::class, 'executeReplacement'])->name('api.am-return-maids.replacement');
    Route::put('am-return-maids/{id}', [AmReturnMaidController::class, 'update'])->name('api.am-return-maids.update');
    Route::delete('am-return-maids/{id}', [AmReturnMaidController::class, 'destroy'])->name('api.am-return-maids.destroy');
    Route::put('am-return-maids/{id}/update-action', [AmReturnActionController::class, 'updateAction'])->name('api.am-return-maids.update-action');
    Route::post('am-monthly-invoices/{id}/receive-payment', [\App\Http\Controllers\AmInvoiceMonthlyICntl::class, 'receivePayment'])->name('api.am-monthly-invoices.receive-payment');
    Route::post('am-monthly-invoices/{id}/credit-note', [\App\Http\Controllers\AmInvoiceMonthlyICntl::class, 'creditNote'])->name('api.am-monthly-invoices.credit-note');
    Route::apiResource('am-monthly-invoices', \App\Http\Controllers\AmInvoiceMonthlyICntl::class)->names('api.am-monthly-invoices');
    //for am maid payroll
    Route::get('am-maid-payroll', [\App\Http\Controllers\AmMaidPayRollController::class, 'index'])->name('api.am-maid-payroll.index');
    Route::get('am-maid-payroll/{employee_id}', [\App\Http\Controllers\AmMaidPayRollController::class, 'show'])->name('api.am-maid-payroll.show');
// });
