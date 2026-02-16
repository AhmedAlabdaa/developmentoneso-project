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
// });

