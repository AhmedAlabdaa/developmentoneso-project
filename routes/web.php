<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\ActivityController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\SettingsController;
    use App\Http\Controllers\StaffController;
    use App\Http\Controllers\PackageController; 
    use App\Http\Controllers\EmployeeController; 
    use App\Http\Controllers\CRMController;
    use App\Http\Controllers\LicenseController;
    use App\Http\Controllers\CandidateController;
    use App\Http\Controllers\AgreementController;
    use App\Http\Controllers\ChartOfAccountsController;
    use App\Http\Controllers\GeneralLedgerController;
    use App\Http\Controllers\JournalEntriesController;
    use App\Http\Controllers\JournalEntryDetailsController;
    use App\Http\Controllers\InvoiceController;
    use App\Http\Controllers\InvoiceItemController;
    use App\Http\Controllers\PaymentController;
    use App\Http\Controllers\BankAccountController;
    use App\Http\Controllers\TaxRateController;
    use App\Http\Controllers\BudgetController;
    use App\Http\Controllers\FixedAssetController;
    use App\Http\Controllers\PayrollController;
    use App\Http\Controllers\AccountInvoiceController;
    use App\Http\Controllers\ContractController;
    use App\Http\Controllers\IncidentsController;
    use App\Http\Controllers\GovernmentServiceController;
    use App\Http\Controllers\AgentController;
    use App\Http\Controllers\CountryController;
    use App\Http\Controllers\LeadController;
    use App\Http\Controllers\MessagingController;
    use App\Http\Controllers\RespondIoWebhookController;
    use App\Http\Controllers\GovtTransactionController;
    use App\Http\Controllers\ServiceController;
    use App\Http\Controllers\ContractReportController;
    use App\Http\Controllers\WebManagerController;
    use App\Http\Controllers\PaymentVoucherController;
    use App\Http\Controllers\ReportsController;
    use App\Http\Controllers\FinanceModuleController;
    use App\Http\Controllers\PaymentReceiptController;
    use App\Http\Controllers\RefundController;
    Use App\Http\Controllers\TypingTranGovInvController;
    use App\Http\Controllers\ReplacementController;
    use App\Http\Controllers\InvoiceServiceController;
    use Illuminate\Support\Carbon;
    use App\Http\Controllers\AmContractMovementController;



    Route::get('/minisry/p3/{contractId}', [AmContractMovementController::class, 'getMinistryContract'])->name('ministry.contract');

    Route::get('/', function () {
        return view('index');
    });

    Route::get('/login', function () {
        return view('index');
    })->name('login');
    Route::get('/send-test-email', [CandidateController::class, 'sendTestEmail']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/kiosk', [CandidateController::class, 'outlet'])->name('candidates.outlet');
    Route::get('/kiosk/data', [CandidateController::class, 'outletData'])->name('candidates.outlet.data');
    Route::prefix('candidate')
        ->name('candidates.')
        ->controller(CandidateController::class)
        ->group(function () {
            Route::get('/{candidate:reference_no}/view-cv', 'viewCV')->name('viewCV');
            Route::get('/{candidate:reference_no}/cv', 'showCV')->name('showCV');
            Route::get('/{candidate:reference_no}/download', 'downloadCV')->name('download');
            Route::get('/{candidate:reference_no}/share', 'shareCV')->name('share');
        });

    Route::prefix('package')
        ->name('package.')
        ->controller(PackageController::class)
        ->group(function () {
            Route::get('/{package:cn_number_series}/view-cv', 'viewCV')->name('viewCV');
            Route::get('/{package:cn_number_series}/cv', 'showCV')->name('showCV');
            Route::get('/{package:cn_number_series}/download', 'downloadCV')->name('download');
            Route::get('/{package:cn_number_series}/share', 'shareCV')->name('share');
        });

    Route::post('/refunds/update-status', [PackageController::class, 'refundUpdateStatus'])->name('refunds.updateStatus');
    Route::post('/replacements/update-status', [PackageController::class, 'replacementUpdateStatus'])->name('replacements.updateStatus');
    Route::post('/salaries/update-status', [PackageController::class, 'salaryUpdateStatus'])->name('salaries.updateStatus');
    Route::post('/remittances/update-status', [PackageController::class, 'remittanceUpdateStatus'])->name('remittances.updateStatus');
    Route::post('packages/office/update', [PackageController::class, 'updateOffice'])->name('office.update');
    Route::post('/employees/office/update', [EmployeeController::class, 'UpdateofficeSave'])->name('employee.office.save');

    Route::prefix('employee')
        ->name('employee.')
        ->controller(EmployeeController::class)
        ->group(function () {
            Route::get('/{employee:reference_no}/view-cv', 'viewCV')->name('viewCV');
            Route::get('/{employee:reference_no}/cv', 'showCV')->name('showCV');
            Route::get('/{employee:reference_no}/download', 'downloadCV')->name('download');
            Route::get('/{employee:reference_no}/share', 'shareCV')->name('share');
        });

    Route::get('/ajaxSyncPartnerStatus', [CandidateController::class, 'ajaxSyncPartnerStatus']);
    Route::get('/contracts/{contract}/sign-share',        [ContractController::class, 'showSignAndShare'])   ->name('contracts.signShareForm');
    Route::post('/contracts/{contract}/sign-share',       [ContractController::class, 'storeSignedAndShare']) ->name('contracts.storeSignedShare');
    Route::post('/contracts/{contract}/share-whatsapp',   [ContractController::class, 'shareWhatsapp'])       ->name('contracts.shareWhatsapp');
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('activities', [ActivityController::class, 'index'])->name('activities.index');
        Route::get('/notifications', [ActivityController::class, 'index'])->name('notifications.index');
        Route::patch('/notifications/{id}/mark-as-read', [ActivityController::class, 'markAsRead'])->name('notifications.markAsRead');
        // ------------------------------- 
        // User Management Routes
        // -------------------------------
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/users', [UserController::class, 'allusers'])->name('users.all');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/change-password/{id}', [UserController::class, 'updatePassword'])->name('users.change-password');
        Route::get('/backup', [UserController::class, 'backup'])->name('users.backup');
        Route::post('/login-request', [UserController::class, 'loginRequest'])->name('users.login-request');

        // ------------------------------- 
        // Settings Routes
        // -------------------------------
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/users', [SettingsController::class, 'updateUserManagement'])->name('settings.users.update');
        Route::post('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
        Route::post('/settings/system', [SettingsController::class, 'updateSystem'])->name('settings.system.update');

        // ------------------------------- 
        // Staff Management Routes
        // -------------------------------
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/upload-staff-csv-file', [StaffController::class, 'showUploadForm'])->name('staff.upload-staff-csv-file');
        Route::post('/staff/process-csv-upload', [StaffController::class, 'processCsvUpload'])->name('staff.process_csv_upload');
        Route::get('/staff/{slug}', [StaffController::class, 'show'])->name('staff.show');
        Route::get('/staff/{slug}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::put('/staff/{slug}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{slug}', [StaffController::class, 'destroy'])->name('staff.destroy');

        // ------------------------------- 
        // Package 1 Management Routes
        // -------------------------------
        
        Route::get('/package', [PackageController::class, 'index'])->name('package.index');
        Route::get('/package/create', [PackageController::class, 'create'])->name('package.create');
        Route::get('/packages/trial', [PackageController::class, 'trial'])->name('packages.trial');
        Route::post('/package/store', [PackageController::class, 'store'])->name('package.store');
        Route::post('/package/importpackage', [PackageController::class, 'importPackage'])->name('package.import');
        Route::get('/package/{id}', [PackageController::class, 'show'])->name('package.show');
        Route::get('/package/{id}/edit', [PackageController::class, 'edit'])->name('package.edit');
        Route::put('/package/{id}', [PackageController::class, 'update'])->name('package.update');
        Route::delete('/package/{id}', [PackageController::class, 'destroy'])->name('package.destroy');
        Route::get('packages/office-data/{id}', [PackageController::class, 'officeData'])->name('package.officeData');
        Route::post('packages/office-save', [PackageController::class, 'officeSave'])->name('package.officeSave');
        Route::post('package/incidentSave',        [PackageController::class, 'incidentSave'])->name('package.incidentSave');
        Route::post('packages/{packageId}/update-status-inside', [PackageController::class, 'updateStatusInside'])->name('packages.update-status-inside');
        Route::post('/packages/trial/confirmed', [PackageController::class, 'saveTrialConfirmed'])->name('packages.saveTrialConfirmed');
        Route::post('/packages/trial/return', [PackageController::class, 'saveTrialReturn'])->name('packages.saveTrialReturn');
        Route::post('{packages/updateTrialStatus', [PackageController::class, 'updateTrialStatus'])->name('packages.updateTrialStatus');
        Route::post('{packages/updateChangeStatus', [PackageController::class, 'updateChangeStatus'])->name('packages.updateChangeStatus');
        Route::post('/packages/trial/sales-return', [PackageController::class, 'saveSalesReturn'])->name('packages.saveSalesReturn');
        Route::post('/packages/trial/incident', [PackageController::class, 'saveReturnIncident'])->name('packages.saveReturnIncident');
        Route::post('/packages/update-details', [PackageController::class, 'updateCandidateDetails'])->name('packages.updateCandidateDetails');
        Route::delete('/packages/{id}', [PackageController::class, 'destroy'])->name('packages.destroy');
        Route::get('/package/exit/{reference_no}', [PackageController::class, 'exit_form'])->name('package.exit');
        Route::post('/convertOfficeToContract', [PackageController::class, 'convertOfficeToContract'])->name('packages.office-contracted');
        Route::post('/convertOfficeToContractSave', [PackageController::class, 'convertOfficeToContractSave'])->name('packages.office-contracted.save');

        // ------------------------------- 
        // Employee Management Routes
        // -------------------------------
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::get('/employees/trial', [EmployeeController::class, 'trial'])->name('employees.trial');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/employees/upload-employees-csv-file', [EmployeeController::class, 'showUploadForm'])->name('employees.upload-employees-csv-file');
        Route::post('/employees/process-csv-upload', [EmployeeController::class, 'processCsvUpload'])->name('employees.process_csv_upload');
        Route::get('/employees/{reference_no}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/employees/{reference_no}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/{slug}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        Route::get('/employee-visa-tracker', [EmployeeController::class, 'employee_visa_tracker'])->name('employees.employee-visa-tracker');
        Route::post('/get-visa-status-details', [EmployeeController::class, 'getVisaStatusDetails'])->name('employees.create-table');
        Route::post('/store-tracking-detail', [EmployeeController::class, 'storeTrackingDetail'])->name('employees.store-tracking-detail');
        Route::get('employees/office-data/{id}', [EmployeeController::class, 'officeData'])->name('employees.officeData');
        Route::post('employees/office-save', [EmployeeController::class, 'officeSave'])->name('employees.officeSave');
        Route::post('employees/{employeeId}/update-status-inside', [EmployeeController::class, 'updateStatusInside'])->name('employees.update-status-inside');
        Route::post('/employees/trial/confirmed', [EmployeeController::class, 'saveTrialConfirmed'])->name('employees.saveTrialConfirmed');
        Route::post('/employees/trial/return', [EmployeeController::class, 'saveTrialReturn'])->name('employees.saveTrialReturn');
        Route::post('{employees/updateTrialStatus', [EmployeeController::class, 'updateTrialStatus'])->name('employees.updateTrialStatus');
        Route::post('{employees/updateChangeStatus', [EmployeeController::class, 'updateChangeStatus'])->name('employees.updateChangeStatus');
        Route::post('/employees/trial/sales-return', [EmployeeController::class, 'saveSalesReturn'])->name('employees.saveSalesReturn');
        Route::post('/employees/trial/incident', [EmployeeController::class, 'saveReturnIncident'])->name('employees.saveReturnIncident');
        Route::post('/employees/update-details', [EmployeeController::class, 'updateCandidateDetails'])->name('employees.updateCandidateDetails');
        Route::get('/employee/exit/{reference_no}', [EmployeeController::class, 'exit_form'])->name('employee.exit');
        Route::get('employee-payment-tracker', [EmployeeController::class, 'employeePaymentTracker'])->name('employee.payment.tracker');
        Route::post('employees/save-completed', [EmployeeController::class, 'saveCompleted'])->name('employees.saveCompleted');
        Route::get('/employee-in-office', [EmployeeController::class, 'office'])->name('employees.office');
        Route::get('/employee-in-contracted', [EmployeeController::class, 'contracted'])->name('employees.contracted');
        Route::get('/employee-in-incident', [EmployeeController::class, 'incident'])->name('employees.incident');
        Route::get('/employee-in-outside', [EmployeeController::class, 'outside'])->name('employees.outside');
        Route::get('/employee-with-information', [EmployeeController::class, 'inside_employees'])->name('employees.inside');
        Route::get('/employee-invoices', [EmployeeController::class, 'invoices'])->name('employees.emp-invoices');
        Route::get('/employee-ins-invoices', [EmployeeController::class, 'InstallmentInvoices'])->name('employees.emp-ins-invoices');
        Route::get('/employee-get-payroll', [EmployeeController::class, 'payroll'])->name('employees.emp-payroll');
        Route::get('/employee-emp-payroll-excel', [EmployeeController::class, 'exportLiveSalaryExcel'])->name('employees.emp-payroll-excel');
        Route::get('/employee-emp-payroll-pdf',   [EmployeeController::class, 'exportLiveSalaryPdf'])->name('employees.emp-payroll-pdf');
        Route::post('/packages/transfer-to-employees',     [EmployeeController::class, 'transferToEmployees'])    ->name('transfer-to-employees');
        Route::get('/employee-get-boa', [EmployeeController::class, 'boa'])->name('employees.emp-boa');
        Route::get('/employee-get-rvo', [EmployeeController::class, 'rvo'])->name('employees.emp-rvo');
        Route::post('/employee-incident-saved', [EmployeeController::class, 'incidentSave'])->name('employees.incidentSave');
        Route::get('/employee-payment-tracker-list', [EmployeeController::class, 'payment_tracker'])->name('employees.emp-payment-tracker');
        Route::post('employees/{identifier}/change-status-outside', [EmployeeController::class, 'changeStatusOutside'])->name('employees.change-status-outside');
        Route::get('employees/replacements/getReplacedcandidates', [EmployeeController::class, 'getReplaced'])->name('employees.getReplaced');
        Route::get('/employees/emp-receipts', [EmployeeController::class, 'receipts'])->name('employees.emp-receipts');
        Route::get('/employees/emp-refunds', [EmployeeController::class, 'refunds'])->name('employees.emp-refunds');
        Route::get('/employee/{reference_no}/boa-process', [EmployeeController::class, 'boaProcess'])->name('boa.process');

        Route::post('/employee/{reference_no}/boa/wc',      [EmployeeController::class, 'saveWc'])->name('boa.wc.save');
        Route::post('/employee/{reference_no}/boa/ibv',     [EmployeeController::class, 'saveIbv'])->name('boa.ibv.save');
        Route::post('/employee/{reference_no}/boa/visa',    [EmployeeController::class, 'saveVisa'])->name('boa.visa.save');
        Route::post('/employee/{reference_no}/boa/arrival', [EmployeeController::class, 'saveArrival'])->name('boa.arrival.save');
        Route::post('/employee/{reference_no}/boa/iaa',     [EmployeeController::class, 'saveIaa'])->name('boa.iaa.save');
        Route::post('/employee/{reference_no}/boa/transfer',[EmployeeController::class, 'saveTransfer'])->name('boa.transfer.save');
        // ------------------------------- 
        // CRM Routes
        // -------------------------------


        Route::get('/crm', [CRMController::class, 'index'])->name('crm.index');
        Route::get('/crm/create', [CRMController::class, 'create'])->name('crm.create');
        Route::get('/crm/export', [CRMController::class, 'export'])->name('crm.export');
        Route::post('/crm', [CRMController::class, 'store'])->name('crm.store');
        Route::get('/crm/{slug}', [CRMController::class, 'show'])->name('crm.show');
        Route::get('/crm/{slug}/edit', [CRMController::class, 'edit'])->name('crm.edit');
        Route::put('/crm/{slug}', [CRMController::class, 'update'])->name('crm.update');
        Route::delete('/crm/{slug}', [CRMController::class, 'destroy'])->name('crm.destroy');

        // Ledger of Accounts
        Route::get('/ledgers', [App\Http\Controllers\LedgerOfAccountController::class, 'viewIndex'])->name('ledgers.index');

        // ------------------------------- 
        // License Routes
        // -------------------------------

        Route::get('/licenses', [LicenseController::class, 'index'])->name('licenses.index');
        Route::get('/licenses/create', [LicenseController::class, 'create'])->name('licenses.create');
        Route::post('/licenses', [LicenseController::class, 'store'])->name('licenses.store');
        Route::get('/licenses/{license}', [LicenseController::class, 'show'])->name('licenses.show');
        Route::get('/licenses/{license}/edit', [LicenseController::class, 'edit'])->name('licenses.edit');
        Route::put('/licenses/{license}', [LicenseController::class, 'update'])->name('licenses.update');
        Route::delete('/licenses/{license}', [LicenseController::class, 'destroy'])->name('licenses.destroy');
        Route::get('/get-branches/{companyId}', [LicenseController::class, 'getBranchesByCompany']);
        Route::get('/licenses/file/{filename}', function ($filename) {
            return Storage::download("public/
                /{$filename}");
        })->name('licenses.download');

        // ------------------------------- 
        // New CandidatesController Routes
        // -------------------------------
        Route::prefix('candidates')->group(function () {
            Route::get('/hide-in-others', [CandidateController::class, 'hideInOtherDatabasesForActive'])->name('candidates.hideInOthers');
            Route::post('/reset-record', [CandidateController::class, 'resetRecord'])->name('candidates.resetRecord');
            Route::get('/outside', [CandidateController::class, 'index'])->name('candidates.index');
            Route::get('/inside', [CandidateController::class, 'inside'])->name('candidates.inside');
            Route::post('/{candidate}/convert-to-contract', [CandidateController::class, 'convertToContract'])->name('candidates.convert-to-employees');
            Route::get('/loadImages', [CandidateController::class, 'loadImages'])->name('candidates.loadimages');
            Route::get('/loadImages1', [CandidateController::class, 'loadImages1'])->name('candidates.loadimages1');
            Route::get('/loadExperiences', [CandidateController::class, 'loadExperiences'])->name('candidates.loadExperiences');
            Route::get('/loadWorkSkills', [CandidateController::class, 'loadWorkSkills'])->name('candidates.loadWorkSkills');
            Route::get('/loadDesiredCountries', [CandidateController::class, 'loadDesiredCountries'])->name('candidates.loadDesiredCountries');
            Route::get('inside', [CandidateController::class, 'inside'])->name('candidates.inside');
            Route::get('trial', [CandidateController::class, 'trial'])->name('candidates.trial');
            Route::get('/{candidate:reference_no}', [CandidateController::class, 'show'])->name('candidates.show');
            Route::get('/{candidate:reference_no}/wc-contract', [CandidateController::class, 'wc_contract'])->name('candidates.wc-contract');
            Route::get('/wc_contract/pdf/view/{candidate}', [CandidateController::class, 'wc_contract_pdf'])->name('wc_contract.pdf.view');
            Route::get('/wc_contract/pdf/download/{candidate}', [CandidateController::class, 'wc_contract_pdf'])->defaults('action', 'download')->name('wc_contract.pdf.download');
            Route::get('/{candidate:reference_no}/edit', [CandidateController::class, 'edit'])->name('candidates.edit');
            Route::put('/{candidate:reference_no}', [CandidateController::class, 'update'])->name('candidates.update');
            Route::delete('/{candidate:reference_no}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
            Route::get('/upload-csv', [CandidateController::class, 'showCsvUploadForm'])->name('candidates.upload-csv');
            Route::post('/upload-csv', [CandidateController::class, 'processCsvUpload'])->name('candidates.process-csv');
            Route::post('/{candidate:reference_no}/update-status', [CandidateController::class, 'updateStatus'])->name('candidates.update-status');
            Route::post('/{candidate:reference_no}/update-status-inside', [CandidateController::class, 'updateStatusInside'])->name('candidates.update-status-inside');
            Route::post('/{candidate:reference_no}/update-trial-status', [CandidateController::class, 'updateTrialStatus'])->name('candidates.update-trial-status');
            Route::post('update-wc-date', [CandidateController::class, 'updateWcDate'])->name('candidates.update-wc-date');
            Route::post('save-incident', [CandidateController::class, 'saveIncident'])->name('candidates.save-incident');
            Route::post('update-visa-details', [CandidateController::class, 'updateVisaDetails'])->name('candidates.update-visa-details');
            Route::post('save-incident-after-visa', [CandidateController::class, 'saveIncidentAfterVisa'])->name('candidates.save-incident-after-visa');
            Route::post('update-arrived-date', [CandidateController::class, 'updateArrivedDate'])->name('candidates.update-arrived-date');
            Route::post('save-incident-after-departure', [CandidateController::class, 'saveIncidentAfterDeparture'])->name('candidates.save-incident-after-departure');
            Route::post('save-incident-after-arrival', [CandidateController::class, 'saveIncidentAfterArrival'])->name('candidates.save-incident-after-arrival');
            Route::post('save-transfer-date', [CandidateController::class, 'saveTransferDate'])->name('candidates.saveTransferDate');
            Route::post('save-tiral-confirmed', [CandidateController::class, 'saveTrialConfirmed'])->name('candidates.saveTrialConfirmed');
            Route::post('get-change-status-details', [CandidateController::class, 'getChangeStatusDetails'])->name('candidates.getChangeStatusDetails');
            Route::post('candidates/update-change-status', [CandidateController::class, 'updateChangeStatus'])->name('candidates.updateChangeStatus');
            Route::post('candidates/save-trial-return', [CandidateController::class, 'saveTrialReturn'])->name('candidates.saveTrialReturn');
            Route::post('candidates/save-sales-return', [CandidateController::class, 'saveSalesReturn'])->name('candidates.saveSalesReturn');
            Route::post('candidates/save-return-incident', [CandidateController::class, 'saveReturnIncident'])->name('candidates.saveReturnIncident');
            Route::post('save-incident-after-transfer', [CandidateController::class, 'saveIncidentAfterTransfer'])->name('candidates.saveIncidentAfterTransfer');
            Route::post('update-candidate-details', [CandidateController::class, 'updateCandidateDetails'])->name('candidates.updateCandidateDetails');
            Route::post('send-alarm', [CandidateController::class, 'sendAlarm'])->name('send.alarm');
            Route::post('export-filtered', [CandidateController::class, 'exportFiltered'])->name('candidates.export');
            Route::get('/{id}/experience', [CandidateController::class, 'getExperience'])->name('candidates.experience');
            Route::get('/{id}/skills', [CandidateController::class, 'getSkills'])->name('candidates.skills');
            Route::post('/{candidateId}/toggle-draft', [CandidateController::class, 'toggleDraft'])->name('candidates.toggleDraft');

        });

        // ------------------------------- 
        // New AgreementController Routes
        // 

        Route::get('/agreements',                                   [AgreementController::class, 'index'])->name('agreements.index');
        Route::get('/agreements/create',                            [AgreementController::class, 'create'])->name('agreements.create');
        Route::post('/agreements',                                  [AgreementController::class, 'store'])->name('agreements.store');
        Route::post('/agreements/inside-agreements',                [AgreementController::class, 'insideAgreement'])->name('agreements.insideagreement');
        Route::post('/agreements/inside-emp-agreements',            [AgreementController::class, 'insideEMPAgreement'])->name('agreements.insideempagreement');
        Route::get('/agreements/{reference_no}/download',           [AgreementController::class, 'download'])->name('download.agreement');
        Route::get('/agreements/insideDownload/{reference_no}',     [AgreementController::class, 'insideDownload'])->name('agreements.insideDownload');
        Route::get('agreements/{reference_no}/pdf',                 [AgreementController::class, 'pdf' ])->name('agreements.pdf');
        Route::get('/agreements/{agreement}/edit', [AgreementController::class, 'edit'])->name('agreements.edit');
        Route::put('/agreements/{reference_no}',                    [AgreementController::class, 'update'])->name('agreements.update');
        Route::delete('/agreements/{reference_no}',                 [AgreementController::class, 'destroy'])->name('agreements.destroy');
        Route::post('/agreements/{reference_no}/update-status',     [AgreementController::class, 'updateStatus'])->name('agreements.update-status');
        Route::get('/agreements/{reference_no}/add-payment',        [AgreementController::class, 'addPayment'])->name('agreements.add-payment');
        Route::get('/agreements/{reference_no}/convert',            [AgreementController::class, 'convertToContract'])->name('agreements.convert');
        Route::get('/agreements/{reference_no}/deliver-mad',        [AgreementController::class, 'deliverMad'])->name('agreements.deliver-mad');
        Route::get('/agreements/{reference_no}/share',              [AgreementController::class, 'shareAgreement'])->name('agreements.share');
        Route::get('/agreements/{reference_no}/deliver-maid',       [AgreementController::class, 'deliverMaid'])->name('agreements.deliver-maid');
        Route::get('/agreements/{reference_no}',                    [AgreementController::class, 'show'])->name('agreements.show');
        Route::get('/agreement-contract-tracker',                   [AgreementController::class, 'agreement_contract_tracker'])->name('agreements.agreement-contract-tracker');
        Route::get('/agreements/import/form', [AgreementController::class, 'showImportForm'])->name('agreements.import.form');
        Route::post('/agreements/import/form', [AgreementController::class, 'importAgreements'])->name('agreements.import');
        Route::post('/agreements/toggleMarked',       [AgreementController::class, 'toggleMarked'])->name('agreements.toggleMarked');

        // -------------------------------
        // Installments routes
        // -------------------------------
        Route::post('/installments/generate-invoice', [AgreementController::class, 'generateInstallmentInvoice'])->name('installments.generate-invoice');
        Route::get('installments/{installment}/items', [AgreementController::class, 'items'])->name('installments.items');
        Route::post('/agreements/update-marked', [AgreementController::class, 'updateMarked'])->name('agreements.update-marked');
        // -------------------------------
        // Charts of accounts Routes
        // -------------------------------
        Route::get('/chart-of-accounts', [ChartOfAccountsController::class, 'index'])->name('chart-of-accounts.index');
        Route::get('/chart-of-accounts/create', [ChartOfAccountsController::class, 'create'])->name('chart-of-accounts.create');
        Route::post('/chart-of-accounts', [ChartOfAccountsController::class, 'store'])->name('chart-of-accounts.store');
        Route::get('/chart-of-accounts/{id}', [ChartOfAccountsController::class, 'show'])->name('chart-of-accounts.show');
        Route::get('/chart-of-accounts/{id}/edit', [ChartOfAccountsController::class, 'edit'])->name('chart-of-accounts.edit');
        Route::put('/chart-of-accounts/{id}', [ChartOfAccountsController::class, 'update'])->name('chart-of-accounts.update');
        Route::delete('/chart-of-accounts/{id}', [ChartOfAccountsController::class, 'destroy'])->name('chart-of-accounts.destroy');

        // -------------------------------
        // Invoices Routes
        // -------------------------------

        Route::prefix('invoices')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index'); 
            Route::get('/create', [InvoiceController::class, 'create'])->name('invoices.create'); 
            Route::post('/', [InvoiceController::class, 'store'])->name('invoices.store'); 
            Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show'); 
            Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit'); 
            Route::post('/{invoice}', [InvoiceController::class, 'updateInvoice'])->name('invoices.update'); 
            Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy'); 
            Route::get('/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download'); 
            Route::post('/{invoice}/update-status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus'); 
            Route::post('/{invoice}/share', [InvoiceController::class, 'share'])->name('invoices.share');
            Route::post('/{invoice}/add-payment-proof', [InvoiceController::class, 'addPaymentProof'])->name('invoices.addPaymentProof');
            Route::get('/{invoice}/view-payment-proof', [InvoiceController::class, 'viewPaymentProof'])->name('invoices.viewPaymentProof'); 
            Route::post('/{invoice}/payment-method', [InvoiceController::class, 'updatePaymentMethod'])->name('invoices.payment-method.update');
            Route::get('export', [InvoiceController::class, 'export'])->name('invoices.export');
        });

        Route::get('/incidents', [IncidentsController::class, 'index'])->name('incidents.index');
        Route::get('/incidents/{id}', [IncidentsController::class, 'show'])->name('incidents.show');
        // -------------------------------
        // Accounting Invoices Routes
        // -------------------------------
        Route::post('/accinvoices/create', [AccountInvoiceController::class, 'createPendingInvoice'])->name('accinvoices.create');
        Route::post('/accinvoices/change-status', [AccountInvoiceController::class, 'changeaccInvoiceStatus'])->name('accinvoices.changeStatus');

        // -------------------------------
        // Contracts  Routes
        // -------------------------------

        Route::prefix('contracts')->name('contracts.')->group(function () {
            Route::get('/', [ContractController::class, 'index'])->name('index');
            Route::get('/create', [ContractController::class, 'create'])->name('create');
            Route::post('/', [ContractController::class, 'store'])->name('store'); 
            Route::get('/{reference_no}', [ContractController::class, 'show'])->name('show');
            Route::get('show1/{reference_no}', [ContractController::class, 'show1'])->name('show1');
            Route::get('/{reference_no}/edit', [ContractController::class, 'edit'])->name('edit'); 
            Route::put('/{reference_no}', [ContractController::class, 'update'])->name('update');
            Route::delete('/{reference_no}', [ContractController::class, 'destroy'])->name('destroy');
            Route::post('/{contract}/signed-copy', [ContractController::class, 'updateSignedCopy'])->name('contracts.signed-copy');
            Route::post('/updateP1', [ContractController::class, 'updateP1Contract'])->name('contracts.p1.update');
        });
        Route::post('/contracts/updateStatus', [ContractController::class, 'updateStatus'])->name('contracts.updateStatus');
        Route::post('/contracts/installments/items', [ContractController::class, 'items'])->name('contracts.installments.items');
        Route::post('contracts/extend', [ContractController::class, 'extend'])->name('contracts.extend');
        Route::post('contracts/details-all', [ContractController::class, 'detailsAll'])->name('contracts.detailsAll');
        Route::post('contracts/toggleMarked',       [ContractController::class, 'toggleMarked'])->name('contracts.toggleMarked');
        Route::post('contracts/{ref}/replace', [ContractController::class, 'replace'])->name('contracts.replace');
        Route::post('contracts/updateContract', [ContractController::class, 'updateContract'])->name('contracts.update-contract');
        Route::post('/contracts/update-marked', [ContractController::class, 'updateMarked'])->name('contracts.update-marked');
        Route::prefix('government-services')->name('government-services.')->group(function () {
            Route::get('/', [GovernmentServiceController::class, 'index'])->name('index');
            Route::get('/create', [GovernmentServiceController::class, 'create'])->name('create');
            Route::post('/', [GovernmentServiceController::class, 'store'])->name('store');
            Route::get('/{governmentService}/edit', [GovernmentServiceController::class, 'edit'])->name('edit');
            Route::put('/{governmentService}', [GovernmentServiceController::class, 'update'])->name('update');
            Route::delete('/{governmentService}', [GovernmentServiceController::class, 'destroy'])->name('destroy');
        });

        Route::get('/agents', [AgentController::class, 'index'])->name('agents.index');
        Route::post('/agents', [AgentController::class, 'store'])->name('agents.store');
        Route::get('/agents/{id}', [AgentController::class, 'show'])->name('agents.show');
        Route::get('/agents/{id}/edit', [AgentController::class, 'edit'])->name('agents.edit');
        Route::put('/agents/{id}', [AgentController::class, 'update'])->name('agents.update');
        Route::delete('/agents/{id}', [AgentController::class, 'destroy'])->name('agents.destroy');
        Route::get('/agent-commission', [AgentController::class, 'agent_commission'])->name('agents.agent-commission');
    });

    Route::prefix('govt-services')->group(function () {
        Route::get('/',               [ServiceController::class, 'index'])->name('services.index');
        Route::get('/add',            [ServiceController::class, 'add'])->name('services.add');
        Route::post('/',              [ServiceController::class, 'store'])->name('services.store');
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/{service}',      [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/{service}',   [ServiceController::class, 'delete'])->name('services.delete');
    });

    Route::get('/get-countries', [CountryController::class, 'getCountries'])->name('get.countries');

    // Leads
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
    Route::get('/leads/{id}', [LeadController::class, 'show'])->name('leads.show');
    Route::get('/leads/{id}/edit', [LeadController::class, 'edit'])->name('leads.edit');
    Route::put('/leads/{id}', [LeadController::class, 'update'])->name('leads.update');
    Route::delete('/leads/{id}', [LeadController::class, 'destroy'])->name('leads.destroy');

    Route::get('govt-transactions', [GovtTransactionController::class, 'index'])->name('govt-transactions.index');
    Route::get('govt-transactions/create', [GovtTransactionController::class, 'create'])->name('govt-transactions.create');
    Route::post('govt-transactions/store', [GovtTransactionController::class, 'store'])->name('govt-transactions.store');
    Route::get('govt-transactions/{invoice_number}', [GovtTransactionController::class, 'show'])->name('govt-transactions.show');
    Route::get('govt-transactions/{invoice_number}/edit', [GovtTransactionController::class, 'edit'])->name('govt-transactions.edit');
    Route::put('govt-transactions/{invoice_number}', [GovtTransactionController::class, 'update'])->name('govt-transactions.update');
    Route::get('govt-transactions/download/{invoice_number}', [GovtTransactionController::class, 'download'])->name('govt-transactions.download');
    Route::delete('govt-transactions/{invoice_number}', [GovtTransactionController::class, 'destroy'])->name('govt-transactions.destroy');
    Route::post('govt-transactions/change-status',[GovtTransactionController::class, 'changeStatus'])->name('govt-transactions.changeStatus');
    Route::get('govt-transactions/export', [GovtTransactionController::class, 'export'])->name('govt-transactions.export');
    Route::get('/mol-report', ContractReportController::class)->name('mol-report');

    //Web Manager 
    Route::get('available-candidates', [WebManagerController::class, 'availableCandidates'])->name('available-candidates');
    Route::get('available-packages',   [WebManagerController::class, 'availablePackages'])->name('available-packages');
    Route::get('available-employees',  [WebManagerController::class, 'availableEmployees'])->name('available-employees');
    Route::put('available-candidates/{id}', [WebManagerController::class, 'updateCandidateMeta'])->name('available-candidates.update');
    Route::put('available-packages/{id}', [WebManagerController::class, 'updatePackageMeta'])->name('available-packages.update');
    Route::put('available-employees/{id}', [WebManagerController::class, 'updateEmployeeMeta'])->name('available-employees.update');

    Route::middleware(['auth'])->group(function () {
        Route::get('payment-vouchers', [PaymentVoucherController::class, 'index'])->name('payment-vouchers.index');
        Route::post('payment-vouchers', [PaymentVoucherController::class, 'store'])->name('payment-vouchers.store');
        Route::post('payment-vouchers/{payment_voucher}', [PaymentVoucherController::class, 'update'])->name('payment-vouchers.update');
        Route::post('payment-vouchers/{payment_voucher}/delete', [PaymentVoucherController::class, 'destroy'])->name('payment-vouchers.destroy');
        Route::post('payment-vouchers/{payment_voucher}/status', [PaymentVoucherController::class, 'status'])->name('payment-vouchers.status');
        
        Route::get('invoice-services', [InvoiceServiceController::class, 'viewIndex'])->name('invoice-services.index');
        Route::get('receipt-vouchers', function () {
            $now = \Carbon\Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
            return view('receipt_vouchers.index', compact('now'));
        })->name('receipt-vouchers.index');
        Route::get('gov-transactions', [TypingTranGovInvController::class, 'viewIndex'])->name('typing-tran-gov-invs.index');
        Route::get('monthly-contract', [\App\Http\Controllers\MonthlyContractPageController::class, 'index'])->name('monthly-contract.index');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/customerreport', [ReportsController::class, 'customer'])->name('customer');
        Route::get('/customer/table', [ReportsController::class, 'customerTable'])->name('customer.table');
        Route::get('/customer/export', [ReportsController::class, 'exportCustomer'])->name('customer.export');
        Route::get('/agreementsreport', [ReportsController::class, 'agreements'])->name('agreements');
        Route::get('/contractsreport', [ReportsController::class, 'contracts'])->name('contracts');
        Route::get('/package-1report', [ReportsController::class, 'package1'])->name('package1');
        Route::get('/employeesreport', [ReportsController::class, 'employees'])->name('employees');
        Route::get('/invoicesreport', [ReportsController::class, 'invoices'])->name('invoices');
        Route::get('/installmentsreport', [ReportsController::class, 'installments'])->name('installments');
    });

    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/', [FinanceModuleController::class, 'index'])->name('index');
        Route::get('/journals', [FinanceModuleController::class, 'journals'])->name('journals');
        Route::get('/journal-entries', [FinanceModuleController::class, 'journalEntries'])->name('journalEntries');
        Route::get('/journals/{journalId}', [FinanceModuleController::class, 'journalShow'])->name('journals.show');
        Route::get('/trial-balance', [FinanceModuleController::class, 'trialBalance'])->name('trialBalance');
        Route::get('/open-ar', [FinanceModuleController::class, 'openAr'])->name('openAr');
        Route::get('/customer-ledger', [FinanceModuleController::class, 'customerLedger'])->name('customerLedger');
        Route::get('/employee-oca', [FinanceModuleController::class, 'employeeOca'])->name('employeeOca');
        Route::get('/vat', [FinanceModuleController::class, 'vat'])->name('vat');
        Route::get('/vat/detail', [FinanceModuleController::class, 'vatDetail'])->name('vatDetail');
        Route::get('/vat/detail', [FinanceModuleController::class, 'vatDetail'])->name('vatDetail');
        Route::get('/errors', [FinanceModuleController::class, 'errors'])->name('errors');
        Route::get('/statement-of-account/{ledger_id}', [FinanceModuleController::class, 'statementOfAccount'])->name('statementOfAccount');
    });

    Route::prefix('payment-receipts')->name('payment-receipts.')->group(function () {
        Route::get('/', [PaymentReceiptController::class, 'index'])->name('index');
        Route::get('/customers/search', [PaymentReceiptController::class, 'customersSearch'])->name('customers.search');
        Route::post('/', [PaymentReceiptController::class, 'store'])->name('store');
        Route::put('/{payment_receipt}', [PaymentReceiptController::class, 'update'])->name('update');
        Route::delete('/{payment_receipt}', [PaymentReceiptController::class, 'destroy'])->name('destroy');
        Route::post('/{payment_receipt}/status', [PaymentReceiptController::class, 'status'])->name('status');
    });


    Route::prefix('refunds')->name('refunds.')->group(function () {
        Route::get('/', [RefundController::class, 'index'])->name('index');
        Route::get('/{refund}/view', [RefundController::class, 'viewForm'])->name('view');
        Route::post('/status', [RefundController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::prefix('replacements')->name('replacements.')->group(function () {
        Route::get('/', [ReplacementController::class, 'index'])->name('index');
        Route::get('/{replacement}/view', [ReplacementController::class, 'viewForm'])->name('view');
        Route::post('/status', [ReplacementController::class, 'updateStatus'])->name('updateStatus');
    });









