<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://alebdaa.cloudledger.ae";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.7.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.7.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-bulk-journal-import" class="tocify-header">
                <li class="tocify-item level-1" data-unique="bulk-journal-import">
                    <a href="#bulk-journal-import">Bulk Journal Import</a>
                </li>
                                    <ul id="tocify-subheader-bulk-journal-import" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="bulk-journal-import-POSTapi-journals-bulk-import">
                                <a href="#bulk-journal-import-POSTapi-journals-bulk-import">Bulk Import Journal Vouchers</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-invoice-services" class="tocify-header">
                <li class="tocify-item level-1" data-unique="invoice-services">
                    <a href="#invoice-services">Invoice Services</a>
                </li>
                                    <ul id="tocify-subheader-invoice-services" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="invoice-services-POSTapi-invoice-services">
                                <a href="#invoice-services-POSTapi-invoice-services">Create Invoice Service</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoice-services-PUTapi-invoice-services--id-">
                                <a href="#invoice-services-PUTapi-invoice-services--id-">Update Invoice Service</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoice-services-DELETEapi-invoice-services--id-">
                                <a href="#invoice-services-DELETEapi-invoice-services--id-">Delete Invoice Service</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-journal-entries" class="tocify-header">
                <li class="tocify-item level-1" data-unique="journal-entries">
                    <a href="#journal-entries">Journal Entries</a>
                </li>
                                    <ul id="tocify-subheader-journal-entries" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="journal-entries-POSTapi-journals">
                                <a href="#journal-entries-POSTapi-journals">Create a new journal entry</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="journal-entries-PUTapi-journals--id-">
                                <a href="#journal-entries-PUTapi-journals--id-">Update a journal entry</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="journal-entries-DELETEapi-journals--id-">
                                <a href="#journal-entries-DELETEapi-journals--id-">Delete a journal entry</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-journal-transaction-lines" class="tocify-header">
                <li class="tocify-item level-1" data-unique="journal-transaction-lines">
                    <a href="#journal-transaction-lines">Journal Transaction Lines</a>
                </li>
                                    <ul id="tocify-subheader-journal-transaction-lines" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="journal-transaction-lines-POSTapi-journal-tran-lines-bulk-update-status">
                                <a href="#journal-transaction-lines-POSTapi-journal-tran-lines-bulk-update-status">Bulk update journal status</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-ledger-of-accounts" class="tocify-header">
                <li class="tocify-item level-1" data-unique="ledger-of-accounts">
                    <a href="#ledger-of-accounts">Ledger of Accounts</a>
                </li>
                                    <ul id="tocify-subheader-ledger-of-accounts" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="ledger-of-accounts-POSTapi-ledgers">
                                <a href="#ledger-of-accounts-POSTapi-ledgers">Create a new ledger account</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ledger-of-accounts-PUTapi-ledgers--id-">
                                <a href="#ledger-of-accounts-PUTapi-ledgers--id-">Update a ledger account</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ledger-of-accounts-DELETEapi-ledgers--id-">
                                <a href="#ledger-of-accounts-DELETEapi-ledgers--id-">Delete a ledger account</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-package-3-modular" class="tocify-header">
                <li class="tocify-item level-1" data-unique="package-3-modular">
                    <a href="#package-3-modular">Package 3 Modular</a>
                </li>
                                    <ul id="tocify-subheader-package-3-modular" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="package-3-modular-primary-contract-p3">
                                <a href="#package-3-modular-primary-contract-p3">Primary contract p3</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-primary-contract-p3" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-monthly-contracts-lookup-employees">
                                            <a href="#package-3-modular-GETapi-am-monthly-contracts-lookup-employees">Lookup employees (maids).</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-monthly-contracts-lookup-all-employees">
                                            <a href="#package-3-modular-GETapi-am-monthly-contracts-lookup-all-employees">Lookup all employees (maids).</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-monthly-contracts-search-candidates">
                                            <a href="#package-3-modular-GETapi-am-monthly-contracts-search-candidates">Search candidates by CN number, reference numbers, or candidate name.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-monthly-contracts-all-employees">
                                            <a href="#package-3-modular-GETapi-am-monthly-contracts-all-employees">List all employees (maids).</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-am-monthly-contracts-employees">
                                            <a href="#package-3-modular-POSTapi-am-monthly-contracts-employees">Create a new employee for monthly contracts.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-PUTapi-am-monthly-contracts-employees--id-">
                                            <a href="#package-3-modular-PUTapi-am-monthly-contracts-employees--id-">Update an employee for monthly contracts.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-monthly-contracts-lookup-customers">
                                            <a href="#package-3-modular-GETapi-am-monthly-contracts-lookup-customers">Lookup customers (CRM).</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-am-monthly-contracts-import-excel">
                                            <a href="#package-3-modular-POSTapi-am-monthly-contracts-import-excel">Import monthly contracts from Excel.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-monthly-contracts">
                                            <a href="#package-3-modular-GETapi-am-monthly-contracts">List all monthly contracts.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-am-monthly-contracts">
                                            <a href="#package-3-modular-POSTapi-am-monthly-contracts">Create a new monthly contract.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-monthly-contracts--id-">
                                            <a href="#package-3-modular-GETapi-am-monthly-contracts--id-">Display a specific monthly contract.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-PUTapi-am-monthly-contracts--id-">
                                            <a href="#package-3-modular-PUTapi-am-monthly-contracts--id-">Update a monthly contract.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-DELETEapi-am-monthly-contracts--id-">
                                            <a href="#package-3-modular-DELETEapi-am-monthly-contracts--id-">Delete a monthly contract.</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="package-3-modular-return-maids-this-will-return-namespace-appenum-enum-mcstatus-int-case-pending-0-case-returntooffice-1-amer-make-this-status-to-show-in-return-list-if-value-0-make-it-pending-and-if-value-1-make-it-return-to-office-in-the-raw-action-i-want-to-make-action-for-refund-or-replacement-or-due-amount">
                                <a href="#package-3-modular-return-maids-this-will-return-namespace-appenum-enum-mcstatus-int-case-pending-0-case-returntooffice-1-amer-make-this-status-to-show-in-return-list-if-value-0-make-it-pending-and-if-value-1-make-it-return-to-office-in-the-raw-action-i-want-to-make-action-for-refund-or-replacement-or-due-amount">Return Maids

this will return namespace App\Enum;
enum MCStatus: int
case Pending = 0;
case ReturnToOffice = 1;
Amer make this status to show in return list if value 0 make it pending and if value 1 make it return to office
in the raw action I want to make action for refund or replacement or due amount</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-return-maids-this-will-return-namespace-appenum-enum-mcstatus-int-case-pending-0-case-returntooffice-1-amer-make-this-status-to-show-in-return-list-if-value-0-make-it-pending-and-if-value-1-make-it-return-to-office-in-the-raw-action-i-want-to-make-action-for-refund-or-replacement-or-due-amount" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-am-monthly-contracts--id--return">
                                            <a href="#package-3-modular-POSTapi-am-monthly-contracts--id--return">Return a maid from a contract movement.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-return-maids">
                                            <a href="#package-3-modular-GETapi-am-return-maids">List return maids.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-return-maids--id-">
                                            <a href="#package-3-modular-GETapi-am-return-maids--id-">Display a specific return maid record.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-am-return-maids--id--replacement">
                                            <a href="#package-3-modular-POSTapi-am-return-maids--id--replacement">Mark returned maid as replacement requested and execute replacement.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-PUTapi-am-return-maids--id-">
                                            <a href="#package-3-modular-PUTapi-am-return-maids--id-">Update a return maid record.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-DELETEapi-am-return-maids--id-">
                                            <a href="#package-3-modular-DELETEapi-am-return-maids--id-">Delete a return maid record.</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="package-3-modular-incidents-apis-for-managing-incidents-ran-away-cancelled-hold-related-to-monthly-contracts-these-records-share-the-am-return-maids-table">
                                <a href="#package-3-modular-incidents-apis-for-managing-incidents-ran-away-cancelled-hold-related-to-monthly-contracts-these-records-share-the-am-return-maids-table">Incidents

APIs for managing incidents (Ran Away, Cancelled, Hold) related to monthly contracts.
These records share the am_return_maids table.</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-incidents-apis-for-managing-incidents-ran-away-cancelled-hold-related-to-monthly-contracts-these-records-share-the-am-return-maids-table" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-incidents">
                                            <a href="#package-3-modular-GETapi-am-incidents">List incidents.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-am-incidents">
                                            <a href="#package-3-modular-POSTapi-am-incidents">Store a new incident.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-PUTapi-am-incidents--id-">
                                            <a href="#package-3-modular-PUTapi-am-incidents--id-">Update an incident.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-DELETEapi-am-incidents--id-">
                                            <a href="#package-3-modular-DELETEapi-am-incidents--id-">Delete an incident.</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="package-3-modular-refund-action-notify-apis-for-managing-refund-action-notify-records">
                                <a href="#package-3-modular-refund-action-notify-apis-for-managing-refund-action-notify-records">Refund Action Notify

APIs for managing refund action notify records.</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-refund-action-notify-apis-for-managing-refund-action-notify-records" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-amp3-action-notifies">
                                            <a href="#package-3-modular-POSTapi-amp3-action-notifies">Raise a refund action notify.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-PUTapi-amp3-action-notifies--id-">
                                            <a href="#package-3-modular-PUTapi-amp3-action-notifies--id-">Update an action notify.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-DELETEapi-amp3-action-notifies--id-">
                                            <a href="#package-3-modular-DELETEapi-amp3-action-notifies--id-">Delete an action notify.</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="package-3-modular-deduction-payroll-apis-for-managing-employee-payroll-deductions-and-allowances">
                                <a href="#package-3-modular-deduction-payroll-apis-for-managing-employee-payroll-deductions-and-allowances">Deduction Payroll

APIs for managing employee payroll deductions and allowances.</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-deduction-payroll-apis-for-managing-employee-payroll-deductions-and-allowances" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-deduction-payrolls">
                                            <a href="#package-3-modular-POSTapi-deduction-payrolls">Store deduction payroll record(s).</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-PUTapi-deduction-payrolls--id-">
                                            <a href="#package-3-modular-PUTapi-deduction-payrolls--id-">Update deduction payroll record.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-DELETEapi-deduction-payrolls--id-">
                                            <a href="#package-3-modular-DELETEapi-deduction-payrolls--id-">Delete deduction payroll record.</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="package-3-modular-maid-payroll-history-apis-for-managing-maid-payroll-history-records">
                                <a href="#package-3-modular-maid-payroll-history-apis-for-managing-maid-payroll-history-records">Maid Payroll History

APIs for managing maid payroll history records.</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-maid-payroll-history-apis-for-managing-maid-payroll-history-records" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-maid-payroll-histories-export-excel">
                                            <a href="#package-3-modular-GETapi-am-maid-payroll-histories-export-excel">Export payroll histories to Excel.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-maid-payroll-histories">
                                            <a href="#package-3-modular-GETapi-am-maid-payroll-histories">List payroll histories.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-am-maid-payroll-histories">
                                            <a href="#package-3-modular-POSTapi-am-maid-payroll-histories">Store payroll history record(s).</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-maid-payroll-histories--id-">
                                            <a href="#package-3-modular-GETapi-am-maid-payroll-histories--id-">Show payroll history record.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-PUTapi-am-maid-payroll-histories--id-">
                                            <a href="#package-3-modular-PUTapi-am-maid-payroll-histories--id-">Update payroll history record.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-DELETEapi-am-maid-payroll-histories--id-">
                                            <a href="#package-3-modular-DELETEapi-am-maid-payroll-histories--id-">Delete payroll history record.</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="package-3-modular-contract-movements-apis-for-managing-contract-movements">
                                <a href="#package-3-modular-contract-movements-apis-for-managing-contract-movements">Contract Movements

APIs for managing contract movements.</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-contract-movements-apis-for-managing-contract-movements" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-contract-movements">
                                            <a href="#package-3-modular-GETapi-am-contract-movements">List contract movements.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-contract-movements--id-">
                                            <a href="#package-3-modular-GETapi-am-contract-movements--id-">Display a specific contract movement.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-PUTapi-am-contract-movements--id-">
                                            <a href="#package-3-modular-PUTapi-am-contract-movements--id-">Update a contract movement.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-DELETEapi-am-contract-movements--id-">
                                            <a href="#package-3-modular-DELETEapi-am-contract-movements--id-">Delete a contract movement.</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="package-3-modular-installments-apis-for-managing-contract-installments">
                                <a href="#package-3-modular-installments-apis-for-managing-contract-installments">Installments

APIs for managing contract installments.</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-installments-apis-for-managing-contract-installments" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-installments">
                                            <a href="#package-3-modular-GETapi-am-installments">List installments.</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="package-3-modular-return-actions-apis-for-managing-actions-on-returned-maids-refund-replacement-etc">
                                <a href="#package-3-modular-return-actions-apis-for-managing-actions-on-returned-maids-refund-replacement-etc">Return Actions

APIs for managing actions on returned maids (Refund, Replacement, etc).</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-return-actions-apis-for-managing-actions-on-returned-maids-refund-replacement-etc" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-PUTapi-am-return-maids--id--update-action">
                                            <a href="#package-3-modular-PUTapi-am-return-maids--id--update-action">Ameeeeeeeeer this one make it on action return list maid as action for each row
and aslo make same one it the insident return list maid.</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="package-3-modular-invoices-for-p3-invoices-for-p3">
                                <a href="#package-3-modular-invoices-for-p3-invoices-for-p3">Invoices For p3

 invoices for p3.</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-invoices-for-p3-invoices-for-p3" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-am-monthly-invoices--id--receive-payment">
                                            <a href="#package-3-modular-POSTapi-am-monthly-invoices--id--receive-payment">Receive payment for a monthly invoice.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-am-monthly-invoices--id--credit-note">
                                            <a href="#package-3-modular-POSTapi-am-monthly-invoices--id--credit-note">Issue a credit note for a monthly invoice.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-monthly-invoices">
                                            <a href="#package-3-modular-GETapi-am-monthly-invoices">List all monthly invoices.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-POSTapi-am-monthly-invoices">
                                            <a href="#package-3-modular-POSTapi-am-monthly-invoices">Store a newly created monthly invoice.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-monthly-invoices--id-">
                                            <a href="#package-3-modular-GETapi-am-monthly-invoices--id-">Display a specific monthly invoice.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-PUTapi-am-monthly-invoices--id-">
                                            <a href="#package-3-modular-PUTapi-am-monthly-invoices--id-">Update a monthly invoice.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-DELETEapi-am-monthly-invoices--id-">
                                            <a href="#package-3-modular-DELETEapi-am-monthly-invoices--id-">Delete a monthly invoice.</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="package-3-modular-maid-payroll-apis-for-maid-payroll-salary-calculations">
                                <a href="#package-3-modular-maid-payroll-apis-for-maid-payroll-salary-calculations">Maid Payroll

APIs for maid payroll salary calculations.</a>
                            </li>
                                                            <ul id="tocify-subheader-package-3-modular-maid-payroll-apis-for-maid-payroll-salary-calculations" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-maid-payroll">
                                            <a href="#package-3-modular-GETapi-am-maid-payroll">Salary calculation.</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="package-3-modular-GETapi-am-maid-payroll--employee_id-">
                                            <a href="#package-3-modular-GETapi-am-maid-payroll--employee_id-">Employee breakdown.</a>
                                        </li>
                                                                    </ul>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-package-one" class="tocify-header">
                <li class="tocify-item level-1" data-unique="package-one">
                    <a href="#package-one">Package One</a>
                </li>
                                    <ul id="tocify-subheader-package-one" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="package-one-POSTapi-package-one-received-voucher">
                                <a href="#package-one-POSTapi-package-one-received-voucher">Create Received Voucher for Package One</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="package-one-POSTapi-package-one-credit-note">
                                <a href="#package-one-POSTapi-package-one-credit-note">Create Credit Note for Package One</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="package-one-POSTapi-package-one-charging">
                                <a href="#package-one-POSTapi-package-one-charging">Create Charging Entry for Package One</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="package-one-POSTapi-package-one">
                                <a href="#package-one-POSTapi-package-one">Create Package One Journal Entry</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="package-one-DELETEapi-package-one--id-">
                                <a href="#package-one-DELETEapi-package-one--id-">Delete Package One Journal Entry</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-receipt-vouchers" class="tocify-header">
                <li class="tocify-item level-1" data-unique="receipt-vouchers">
                    <a href="#receipt-vouchers">Receipt Vouchers</a>
                </li>
                                    <ul id="tocify-subheader-receipt-vouchers" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="receipt-vouchers-POSTapi-receipt-vouchers">
                                <a href="#receipt-vouchers-POSTapi-receipt-vouchers">Create a new receipt voucher</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="receipt-vouchers-PUTapi-receipt-vouchers--id-">
                                <a href="#receipt-vouchers-PUTapi-receipt-vouchers--id-">Update a receipt voucher</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="receipt-vouchers-DELETEapi-receipt-vouchers--id-">
                                <a href="#receipt-vouchers-DELETEapi-receipt-vouchers--id-">Delete a receipt voucher</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-typing-transaction-government-invoices" class="tocify-header">
                <li class="tocify-item level-1" data-unique="typing-transaction-government-invoices">
                    <a href="#typing-transaction-government-invoices">Typing Transaction Government Invoices</a>
                </li>
                                    <ul id="tocify-subheader-typing-transaction-government-invoices" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="typing-transaction-government-invoices-POSTapi-typing-tran-gov-invs--id--receive-payment">
                                <a href="#typing-transaction-government-invoices-POSTapi-typing-tran-gov-invs--id--receive-payment">Receive payment for a typing invoice</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="typing-transaction-government-invoices-POSTapi-typing-tran-gov-invs">
                                <a href="#typing-transaction-government-invoices-POSTapi-typing-tran-gov-invs">Create a new item</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="typing-transaction-government-invoices-PUTapi-typing-tran-gov-invs--id-">
                                <a href="#typing-transaction-government-invoices-PUTapi-typing-tran-gov-invs--id-">Update an item</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="typing-transaction-government-invoices-DELETEapi-typing-tran-gov-invs--id-">
                                <a href="#typing-transaction-government-invoices-DELETEapi-typing-tran-gov-invs--id-">Delete an item</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: March 12, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://alebdaa.cloudledger.ae</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="bulk-journal-import">Bulk Journal Import</h1>

    <p>APIs for bulk importing journal vouchers via CSV.</p>

                                <h2 id="bulk-journal-import-POSTapi-journals-bulk-import">Bulk Import Journal Vouchers</h2>

<p>
</p>

<p>Import multiple journal entries from a CSV file. Each journal entry is grouped by posting_date.</p>
<p>CSV columns:</p>
<ul>
<li>ledger_name (required): Name of the ledger account</li>
<li>debit (required): Debit amount (use 0 if credit)</li>
<li>credit (required): Credit amount (use 0 if debit)</li>
<li>posting_date (required): Date in Y-m-d format</li>
<li>candidate_id (optional): Employee/candidate ID</li>
<li>note (optional): Transaction note</li>
</ul>

<span id="example-requests-POSTapi-journals-bulk-import">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/journals/bulk-import" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "file=@/tmp/phpyAY93Q" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/journals/bulk-import"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('file', document.querySelector('input[name="file"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-journals-bulk-import">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Import completed&quot;,
    &quot;created_journals&quot;: 3,
    &quot;total_rows&quot;: 10,
    &quot;errors&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-journals-bulk-import" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-journals-bulk-import"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-journals-bulk-import"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-journals-bulk-import" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-journals-bulk-import">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-journals-bulk-import" data-method="POST"
      data-path="api/journals/bulk-import"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-journals-bulk-import', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-journals-bulk-import"
                    onclick="tryItOut('POSTapi-journals-bulk-import');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-journals-bulk-import"
                    onclick="cancelTryOut('POSTapi-journals-bulk-import');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-journals-bulk-import"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/journals/bulk-import</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-journals-bulk-import"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-journals-bulk-import"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>file</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="file"                data-endpoint="POSTapi-journals-bulk-import"
               value=""
               data-component="body">
    <br>
<p>The CSV file to import. Example: <code>/tmp/phpyAY93Q</code></p>
        </div>
        </form>

                <h1 id="invoice-services">Invoice Services</h1>

    <p>APIs for managing invoice services.</p>

                                <h2 id="invoice-services-POSTapi-invoice-services">Create Invoice Service</h2>

<p>
</p>

<p>Store a newly created resource in storage.</p>

<span id="example-requests-POSTapi-invoice-services">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/invoice-services" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"b\",
    \"code\": \"n\",
    \"note\": \"g\",
    \"status\": false,
    \"type\": 2,
    \"lines\": [
        {
            \"ledger_account_id\": 16,
            \"amount_debit\": 39,
            \"amount_credit\": 84,
            \"vatable\": true,
            \"note\": \"z\",
            \"source_amount\": 1
        }
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/invoice-services"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "b",
    "code": "n",
    "note": "g",
    "status": false,
    "type": 2,
    "lines": [
        {
            "ledger_account_id": 16,
            "amount_debit": 39,
            "amount_credit": 84,
            "vatable": true,
            "note": "z",
            "source_amount": 1
        }
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-invoice-services">
</span>
<span id="execution-results-POSTapi-invoice-services" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-invoice-services"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-invoice-services"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-invoice-services" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-invoice-services">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-invoice-services" data-method="POST"
      data-path="api/invoice-services"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-invoice-services', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-invoice-services"
                    onclick="tryItOut('POSTapi-invoice-services');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-invoice-services"
                    onclick="cancelTryOut('POSTapi-invoice-services');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-invoice-services"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/invoice-services</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-invoice-services"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-invoice-services"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-invoice-services"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-invoice-services"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-invoice-services"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 1000 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-invoice-services" style="display: none">
            <input type="radio" name="status"
                   value="true"
                   data-endpoint="POSTapi-invoice-services"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-invoice-services" style="display: none">
            <input type="radio" name="status"
                   value="false"
                   data-endpoint="POSTapi-invoice-services"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="type"                data-endpoint="POSTapi-invoice-services"
               value="2"
               data-component="body">
    <br>
<p>Example: <code>2</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>2</code></li> <li><code>3</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>settings</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="settings"                data-endpoint="POSTapi-invoice-services"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>lines</code></b>&nbsp;&nbsp;
<small>object[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>ledger_account_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.ledger_account_id"                data-endpoint="POSTapi-invoice-services"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the ledger_of_accounts table. Example: <code>16</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>amount_debit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.amount_debit"                data-endpoint="POSTapi-invoice-services"
               value="39"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>39</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>amount_credit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.amount_credit"                data-endpoint="POSTapi-invoice-services"
               value="84"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>84</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>vatable</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-invoice-services" style="display: none">
            <input type="radio" name="lines.0.vatable"
                   value="true"
                   data-endpoint="POSTapi-invoice-services"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-invoice-services" style="display: none">
            <input type="radio" name="lines.0.vatable"
                   value="false"
                   data-endpoint="POSTapi-invoice-services"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lines.0.note"                data-endpoint="POSTapi-invoice-services"
               value="z"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>z</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>source_amount</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.source_amount"                data-endpoint="POSTapi-invoice-services"
               value="1"
               data-component="body">
    <br>
<p>Example: <code>1</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>2</code></li></ul>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="invoice-services-PUTapi-invoice-services--id-">Update Invoice Service</h2>

<p>
</p>

<p>Update the specified resource in storage.</p>

<span id="example-requests-PUTapi-invoice-services--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/invoice-services/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"b\",
    \"code\": \"n\",
    \"note\": \"g\",
    \"status\": false,
    \"type\": 2,
    \"lines\": [
        {
            \"ledger_account_id\": 16,
            \"amount_debit\": 39,
            \"amount_credit\": 84,
            \"vatable\": true,
            \"note\": \"z\",
            \"source_amount\": 1
        }
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/invoice-services/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "b",
    "code": "n",
    "note": "g",
    "status": false,
    "type": 2,
    "lines": [
        {
            "ledger_account_id": 16,
            "amount_debit": 39,
            "amount_credit": 84,
            "vatable": true,
            "note": "z",
            "source_amount": 1
        }
    ]
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-invoice-services--id-">
</span>
<span id="execution-results-PUTapi-invoice-services--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-invoice-services--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-invoice-services--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-invoice-services--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-invoice-services--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-invoice-services--id-" data-method="PUT"
      data-path="api/invoice-services/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-invoice-services--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-invoice-services--id-"
                    onclick="tryItOut('PUTapi-invoice-services--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-invoice-services--id-"
                    onclick="cancelTryOut('PUTapi-invoice-services--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-invoice-services--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/invoice-services/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/invoice-services/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-invoice-services--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-invoice-services--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PUTapi-invoice-services--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the invoice service. Example: <code>architecto</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-invoice-services--id-"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="PUTapi-invoice-services--id-"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-invoice-services--id-"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 1000 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-invoice-services--id-" style="display: none">
            <input type="radio" name="status"
                   value="true"
                   data-endpoint="PUTapi-invoice-services--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-invoice-services--id-" style="display: none">
            <input type="radio" name="status"
                   value="false"
                   data-endpoint="PUTapi-invoice-services--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="type"                data-endpoint="PUTapi-invoice-services--id-"
               value="2"
               data-component="body">
    <br>
<p>Example: <code>2</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>2</code></li> <li><code>3</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>settings</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="settings"                data-endpoint="PUTapi-invoice-services--id-"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>lines</code></b>&nbsp;&nbsp;
<small>object[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lines.0.id"                data-endpoint="PUTapi-invoice-services--id-"
               value=""
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the invoice_service_lines table.</p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>ledger_account_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.ledger_account_id"                data-endpoint="PUTapi-invoice-services--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the ledger_of_accounts table. Example: <code>16</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>amount_debit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.amount_debit"                data-endpoint="PUTapi-invoice-services--id-"
               value="39"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>39</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>amount_credit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.amount_credit"                data-endpoint="PUTapi-invoice-services--id-"
               value="84"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>84</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>vatable</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-invoice-services--id-" style="display: none">
            <input type="radio" name="lines.0.vatable"
                   value="true"
                   data-endpoint="PUTapi-invoice-services--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-invoice-services--id-" style="display: none">
            <input type="radio" name="lines.0.vatable"
                   value="false"
                   data-endpoint="PUTapi-invoice-services--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lines.0.note"                data-endpoint="PUTapi-invoice-services--id-"
               value="z"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>z</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>source_amount</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.source_amount"                data-endpoint="PUTapi-invoice-services--id-"
               value="1"
               data-component="body">
    <br>
<p>Example: <code>1</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>2</code></li></ul>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="invoice-services-DELETEapi-invoice-services--id-">Delete Invoice Service</h2>

<p>
</p>

<p>Remove the specified resource from storage.</p>

<span id="example-requests-DELETEapi-invoice-services--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/invoice-services/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/invoice-services/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-invoice-services--id-">
</span>
<span id="execution-results-DELETEapi-invoice-services--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-invoice-services--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-invoice-services--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-invoice-services--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-invoice-services--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-invoice-services--id-" data-method="DELETE"
      data-path="api/invoice-services/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-invoice-services--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-invoice-services--id-"
                    onclick="tryItOut('DELETEapi-invoice-services--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-invoice-services--id-"
                    onclick="cancelTryOut('DELETEapi-invoice-services--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-invoice-services--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/invoice-services/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-invoice-services--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-invoice-services--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="DELETEapi-invoice-services--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the invoice service. Example: <code>architecto</code></p>
            </div>
                    </form>

                <h1 id="journal-entries">Journal Entries</h1>

    <p>APIs for managing journal entries (headers) with nested transaction lines.</p>

                                <h2 id="journal-entries-POSTapi-journals">Create a new journal entry</h2>

<p>
</p>

<p>Store a newly created journal entry with nested transaction lines.</p>

<span id="example-requests-POSTapi-journals">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/journals" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"posting_date\": \"2026-01-07\",
    \"status\": 0,
    \"source_type\": \"App\\\\Models\\\\Invoice\",
    \"source_id\": 123,
    \"pre_src_type\": \"App\\\\Models\\\\Order\",
    \"pre_src_id\": 456,
    \"note\": \"Monthly payment entry\",
    \"meta_json\": {
        \"reference\": \"PAY-001\"
    },
    \"created_by\": 16,
    \"lines\": [
        \"architecto\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/journals"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "posting_date": "2026-01-07",
    "status": 0,
    "source_type": "App\\Models\\Invoice",
    "source_id": 123,
    "pre_src_type": "App\\Models\\Order",
    "pre_src_id": 456,
    "note": "Monthly payment entry",
    "meta_json": {
        "reference": "PAY-001"
    },
    "created_by": 16,
    "lines": [
        "architecto"
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-journals">
</span>
<span id="execution-results-POSTapi-journals" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-journals"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-journals"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-journals" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-journals">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-journals" data-method="POST"
      data-path="api/journals"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-journals', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-journals"
                    onclick="tryItOut('POSTapi-journals');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-journals"
                    onclick="cancelTryOut('POSTapi-journals');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-journals"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/journals</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-journals"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-journals"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>posting_date</code></b>&nbsp;&nbsp;
<small>date</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="posting_date"                data-endpoint="POSTapi-journals"
               value="2026-01-07"
               data-component="body">
    <br>
<p>The posting date. Example: <code>2026-01-07</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="POSTapi-journals"
               value="0"
               data-component="body">
    <br>
<p>The status: 0=Draft, 1=Posted, 2=Void. Example: <code>0</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>source_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="source_type"                data-endpoint="POSTapi-journals"
               value="App\Models\Invoice"
               data-component="body">
    <br>
<p>optional Source model type. Example: <code>App\Models\Invoice</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>source_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="source_id"                data-endpoint="POSTapi-journals"
               value="123"
               data-component="body">
    <br>
<p>optional Source model ID. Example: <code>123</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>pre_src_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="pre_src_type"                data-endpoint="POSTapi-journals"
               value="App\Models\Order"
               data-component="body">
    <br>
<p>optional Previous source type. Example: <code>App\Models\Order</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>pre_src_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="pre_src_id"                data-endpoint="POSTapi-journals"
               value="456"
               data-component="body">
    <br>
<p>optional Previous source ID. Example: <code>456</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-journals"
               value="Monthly payment entry"
               data-component="body">
    <br>
<p>optional Journal notes. Example: <code>Monthly payment entry</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>meta_json</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="meta_json"                data-endpoint="POSTapi-journals"
               value=""
               data-component="body">
    <br>
<p>optional Additional metadata.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>created_by</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="created_by"                data-endpoint="POSTapi-journals"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>lines</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
 &nbsp;
<br>
<p>Array of transaction lines (minimum 2). Total debits must equal total credits.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.employee_id"                data-endpoint="POSTapi-journals"
               value="5"
               data-component="body">
    <br>
<p>optional Employee ID. Example: <code>5</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.ledger_id"                data-endpoint="POSTapi-journals"
               value="1"
               data-component="body">
    <br>
<p>Ledger account ID. Example: <code>1</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>debit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.debit"                data-endpoint="POSTapi-journals"
               value="1000"
               data-component="body">
    <br>
<p>Debit amount (use 0 if credit entry). Example: <code>1000</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>credit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.credit"                data-endpoint="POSTapi-journals"
               value="0"
               data-component="body">
    <br>
<p>Credit amount (use 0 if debit entry). Example: <code>0</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lines.0.note"                data-endpoint="POSTapi-journals"
               value="Payment received"
               data-component="body">
    <br>
<p>optional Line note. Example: <code>Payment received</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="journal-entries-PUTapi-journals--id-">Update a journal entry</h2>

<p>
</p>

<p>Update the details of a specific journal entry and its nested lines.</p>

<span id="example-requests-PUTapi-journals--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/journals/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"posting_date\": \"2026-01-08\",
    \"status\": 1,
    \"source_type\": \"App\\\\Models\\\\Invoice\",
    \"source_id\": 123,
    \"pre_src_type\": \"App\\\\Models\\\\Order\",
    \"pre_src_id\": 456,
    \"note\": \"Updated entry\",
    \"meta_json\": {
        \"reference\": \"PAY-001\"
    },
    \"lines\": [
        \"architecto\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/journals/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "posting_date": "2026-01-08",
    "status": 1,
    "source_type": "App\\Models\\Invoice",
    "source_id": 123,
    "pre_src_type": "App\\Models\\Order",
    "pre_src_id": 456,
    "note": "Updated entry",
    "meta_json": {
        "reference": "PAY-001"
    },
    "lines": [
        "architecto"
    ]
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-journals--id-">
</span>
<span id="execution-results-PUTapi-journals--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-journals--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-journals--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-journals--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-journals--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-journals--id-" data-method="PUT"
      data-path="api/journals/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-journals--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-journals--id-"
                    onclick="tryItOut('PUTapi-journals--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-journals--id-"
                    onclick="cancelTryOut('PUTapi-journals--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-journals--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/journals/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/journals/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-journals--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-journals--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-journals--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the journal entry. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>posting_date</code></b>&nbsp;&nbsp;
<small>date</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="posting_date"                data-endpoint="PUTapi-journals--id-"
               value="2026-01-08"
               data-component="body">
    <br>
<p>optional The posting date. Example: <code>2026-01-08</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="PUTapi-journals--id-"
               value="1"
               data-component="body">
    <br>
<p>optional The status: 0=Draft, 1=Posted, 2=Void. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>source_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="source_type"                data-endpoint="PUTapi-journals--id-"
               value="App\Models\Invoice"
               data-component="body">
    <br>
<p>Source model type. Must not be greater than 255 characters. Example: <code>App\Models\Invoice</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>source_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="source_id"                data-endpoint="PUTapi-journals--id-"
               value="123"
               data-component="body">
    <br>
<p>Source model ID. Example: <code>123</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>pre_src_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="pre_src_type"                data-endpoint="PUTapi-journals--id-"
               value="App\Models\Order"
               data-component="body">
    <br>
<p>Previous source type. Must not be greater than 255 characters. Example: <code>App\Models\Order</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>pre_src_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="pre_src_id"                data-endpoint="PUTapi-journals--id-"
               value="456"
               data-component="body">
    <br>
<p>Previous source ID. Example: <code>456</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-journals--id-"
               value="Updated entry"
               data-component="body">
    <br>
<p>optional Journal notes. Example: <code>Updated entry</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>meta_json</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="meta_json"                data-endpoint="PUTapi-journals--id-"
               value=""
               data-component="body">
    <br>
<p>Additional metadata.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>lines</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>optional Array of transaction lines. Include 'id' to update existing lines, omit to create new ones.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.id"                data-endpoint="PUTapi-journals--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the journal_tran_lines table. Example: <code>16</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.employee_id"                data-endpoint="PUTapi-journals--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the employees table. Example: <code>16</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.ledger_id"                data-endpoint="PUTapi-journals--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the ledger_of_accounts table. Example: <code>16</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>debit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.debit"                data-endpoint="PUTapi-journals--id-"
               value="39"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>39</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>credit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.credit"                data-endpoint="PUTapi-journals--id-"
               value="84"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>84</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lines.0.note"                data-endpoint="PUTapi-journals--id-"
               value="z"
               data-component="body">
    <br>
<p>Must not be greater than 1000 characters. Example: <code>z</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="journal-entries-DELETEapi-journals--id-">Delete a journal entry</h2>

<p>
</p>

<p>Remove a specific journal entry and its transaction lines from the database.</p>

<span id="example-requests-DELETEapi-journals--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/journals/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/journals/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-journals--id-">
</span>
<span id="execution-results-DELETEapi-journals--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-journals--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-journals--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-journals--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-journals--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-journals--id-" data-method="DELETE"
      data-path="api/journals/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-journals--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-journals--id-"
                    onclick="tryItOut('DELETEapi-journals--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-journals--id-"
                    onclick="cancelTryOut('DELETEapi-journals--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-journals--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/journals/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-journals--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-journals--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-journals--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the journal entry to delete. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="journal-transaction-lines">Journal Transaction Lines</h1>

    <p>APIs for querying journal transaction lines from posted journal vouchers.</p>

                                <h2 id="journal-transaction-lines-POSTapi-journal-tran-lines-bulk-update-status">Bulk update journal status</h2>

<p>
</p>

<p>Update the status of multiple journal headers by their IDs.</p>

<span id="example-requests-POSTapi-journal-tran-lines-bulk-update-status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/journal-tran-lines/bulk-update-status" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"ids\": [
        16
    ],
    \"status\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/journal-tran-lines/bulk-update-status"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        16
    ],
    "status": 1
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-journal-tran-lines-bulk-update-status">
</span>
<span id="execution-results-POSTapi-journal-tran-lines-bulk-update-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-journal-tran-lines-bulk-update-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-journal-tran-lines-bulk-update-status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-journal-tran-lines-bulk-update-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-journal-tran-lines-bulk-update-status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-journal-tran-lines-bulk-update-status" data-method="POST"
      data-path="api/journal-tran-lines/bulk-update-status"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-journal-tran-lines-bulk-update-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-journal-tran-lines-bulk-update-status"
                    onclick="tryItOut('POSTapi-journal-tran-lines-bulk-update-status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-journal-tran-lines-bulk-update-status"
                    onclick="cancelTryOut('POSTapi-journal-tran-lines-bulk-update-status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-journal-tran-lines-bulk-update-status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/journal-tran-lines/bulk-update-status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-journal-tran-lines-bulk-update-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-journal-tran-lines-bulk-update-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ids</code></b>&nbsp;&nbsp;
<small>integer[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ids[0]"                data-endpoint="POSTapi-journal-tran-lines-bulk-update-status"
               data-component="body">
        <input type="number" style="display: none"
               name="ids[1]"                data-endpoint="POSTapi-journal-tran-lines-bulk-update-status"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the journal_headers table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="POSTapi-journal-tran-lines-bulk-update-status"
               value="1"
               data-component="body">
    <br>
<p>Example: <code>1</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>0</code></li> <li><code>1</code></li> <li><code>2</code></li></ul>
        </div>
        </form>

                <h1 id="ledger-of-accounts">Ledger of Accounts</h1>

    <p>APIs for managing ledger accounts with filtering, sorting, and pagination.</p>

                                <h2 id="ledger-of-accounts-POSTapi-ledgers">Create a new ledger account</h2>

<p>
</p>

<p>Store a newly created ledger account in the database.</p>

<span id="example-requests-POSTapi-ledgers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/ledgers" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Cash Account\",
    \"class\": 1,
    \"sub_class\": 0,
    \"group\": \"Assets\",
    \"spacial\": 0,
    \"type\": \"dr\",
    \"note\": \"Main cash account\",
    \"created_by\": 16,
    \"updated_by\": 16
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/ledgers"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Cash Account",
    "class": 1,
    "sub_class": 0,
    "group": "Assets",
    "spacial": 0,
    "type": "dr",
    "note": "Main cash account",
    "created_by": 16,
    "updated_by": 16
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-ledgers">
</span>
<span id="execution-results-POSTapi-ledgers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-ledgers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-ledgers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-ledgers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-ledgers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-ledgers" data-method="POST"
      data-path="api/ledgers"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-ledgers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-ledgers"
                    onclick="tryItOut('POSTapi-ledgers');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-ledgers"
                    onclick="cancelTryOut('POSTapi-ledgers');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-ledgers"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/ledgers</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-ledgers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-ledgers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-ledgers"
               value="Cash Account"
               data-component="body">
    <br>
<p>The name of the ledger account. Example: <code>Cash Account</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>class</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="class"                data-endpoint="POSTapi-ledgers"
               value="1"
               data-component="body">
    <br>
<p>The class of the ledger account. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>sub_class</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="sub_class"                data-endpoint="POSTapi-ledgers"
               value="0"
               data-component="body">
    <br>
<p>The sub-class of the ledger account. Example: <code>0</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>group</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="group"                data-endpoint="POSTapi-ledgers"
               value="Assets"
               data-component="body">
    <br>
<p>optional The group. Example: <code>Assets</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>spacial</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="spacial"                data-endpoint="POSTapi-ledgers"
               value="0"
               data-component="body">
    <br>
<p>Spacial value. Example: <code>0</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="POSTapi-ledgers"
               value="dr"
               data-component="body">
    <br>
<p>The type (dr or cr). Example: <code>dr</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-ledgers"
               value="Main cash account"
               data-component="body">
    <br>
<p>optional Additional notes. Example: <code>Main cash account</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>created_by</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="created_by"                data-endpoint="POSTapi-ledgers"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>updated_by</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="updated_by"                data-endpoint="POSTapi-ledgers"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>16</code></p>
        </div>
        </form>

                    <h2 id="ledger-of-accounts-PUTapi-ledgers--id-">Update a ledger account</h2>

<p>
</p>

<p>Update the details of a specific ledger account.</p>

<span id="example-requests-PUTapi-ledgers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/ledgers/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Updated Cash Account\",
    \"class\": 1,
    \"sub_class\": 0,
    \"group\": \"Assets\",
    \"spacial\": 0,
    \"type\": \"dr\",
    \"note\": \"Updated notes\",
    \"created_by\": 16,
    \"updated_by\": 16
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/ledgers/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Updated Cash Account",
    "class": 1,
    "sub_class": 0,
    "group": "Assets",
    "spacial": 0,
    "type": "dr",
    "note": "Updated notes",
    "created_by": 16,
    "updated_by": 16
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-ledgers--id-">
</span>
<span id="execution-results-PUTapi-ledgers--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-ledgers--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-ledgers--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-ledgers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-ledgers--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-ledgers--id-" data-method="PUT"
      data-path="api/ledgers/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-ledgers--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-ledgers--id-"
                    onclick="tryItOut('PUTapi-ledgers--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-ledgers--id-"
                    onclick="cancelTryOut('PUTapi-ledgers--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-ledgers--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/ledgers/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/ledgers/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-ledgers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-ledgers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-ledgers--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the ledger account. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-ledgers--id-"
               value="Updated Cash Account"
               data-component="body">
    <br>
<p>The name of the ledger account. Example: <code>Updated Cash Account</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>class</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="class"                data-endpoint="PUTapi-ledgers--id-"
               value="1"
               data-component="body">
    <br>
<p>The class of the ledger account. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>sub_class</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="sub_class"                data-endpoint="PUTapi-ledgers--id-"
               value="0"
               data-component="body">
    <br>
<p>The sub-class of the ledger account. Example: <code>0</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>group</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="group"                data-endpoint="PUTapi-ledgers--id-"
               value="Assets"
               data-component="body">
    <br>
<p>optional The group. Example: <code>Assets</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>spacial</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="spacial"                data-endpoint="PUTapi-ledgers--id-"
               value="0"
               data-component="body">
    <br>
<p>Spacial value. Example: <code>0</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="PUTapi-ledgers--id-"
               value="dr"
               data-component="body">
    <br>
<p>The type (dr or cr). Example: <code>dr</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-ledgers--id-"
               value="Updated notes"
               data-component="body">
    <br>
<p>optional Additional notes. Example: <code>Updated notes</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>created_by</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="created_by"                data-endpoint="PUTapi-ledgers--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>updated_by</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="updated_by"                data-endpoint="PUTapi-ledgers--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>16</code></p>
        </div>
        </form>

                    <h2 id="ledger-of-accounts-DELETEapi-ledgers--id-">Delete a ledger account</h2>

<p>
</p>

<p>Remove a specific ledger account from the database.</p>

<span id="example-requests-DELETEapi-ledgers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/ledgers/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/ledgers/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-ledgers--id-">
</span>
<span id="execution-results-DELETEapi-ledgers--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-ledgers--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-ledgers--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-ledgers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-ledgers--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-ledgers--id-" data-method="DELETE"
      data-path="api/ledgers/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-ledgers--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-ledgers--id-"
                    onclick="tryItOut('DELETEapi-ledgers--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-ledgers--id-"
                    onclick="cancelTryOut('DELETEapi-ledgers--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-ledgers--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/ledgers/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-ledgers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-ledgers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-ledgers--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the ledger account to delete. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="package-3-modular">Package 3 Modular</h1>

    

                        <h2 id="package-3-modular-primary-contract-p3">Primary contract p3</h2>
                                                    <h2 id="package-3-modular-GETapi-am-monthly-contracts-lookup-employees">Lookup employees (maids).</h2>

<p>
</p>

<p>Search employees by name for autocomplete. Returns id and name only.</p>

<span id="example-requests-GETapi-am-monthly-contracts-lookup-employees">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/lookup-employees?search=maria&amp;limit=10" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/lookup-employees"
);

const params = {
    "search": "maria",
    "limit": "10",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-monthly-contracts-lookup-employees">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;id&quot;: 5,
        &quot;name&quot;: &quot;Maria Santos&quot;
    },
    {
        &quot;id&quot;: 12,
        &quot;name&quot;: &quot;Maria Garcia&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-monthly-contracts-lookup-employees" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-monthly-contracts-lookup-employees"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-monthly-contracts-lookup-employees"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-monthly-contracts-lookup-employees" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-monthly-contracts-lookup-employees">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-monthly-contracts-lookup-employees" data-method="GET"
      data-path="api/am-monthly-contracts/lookup-employees"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-monthly-contracts-lookup-employees', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-monthly-contracts-lookup-employees"
                    onclick="tryItOut('GETapi-am-monthly-contracts-lookup-employees');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-monthly-contracts-lookup-employees"
                    onclick="cancelTryOut('GETapi-am-monthly-contracts-lookup-employees');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-monthly-contracts-lookup-employees"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-monthly-contracts/lookup-employees</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-monthly-contracts-lookup-employees"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-monthly-contracts-lookup-employees"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-am-monthly-contracts-lookup-employees"
               value="maria"
               data-component="query">
    <br>
<p>Search term to match against maid name. Example: <code>maria</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>limit</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="limit"                data-endpoint="GETapi-am-monthly-contracts-lookup-employees"
               value="10"
               data-component="query">
    <br>
<p>Maximum number of results. Default: 20. Example: <code>10</code></p>
            </div>
                </form>

                    <h2 id="package-3-modular-GETapi-am-monthly-contracts-lookup-all-employees">Lookup all employees (maids).</h2>

<p>
</p>

<p>Search all employees by name for autocomplete. Returns id and name only.</p>

<span id="example-requests-GETapi-am-monthly-contracts-lookup-all-employees">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/lookup-all-employees?search=maria&amp;limit=10" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/lookup-all-employees"
);

const params = {
    "search": "maria",
    "limit": "10",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-monthly-contracts-lookup-all-employees">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;id&quot;: 5,
        &quot;name&quot;: &quot;Maria Santos&quot;
    },
    {
        &quot;id&quot;: 12,
        &quot;name&quot;: &quot;Maria Garcia&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-monthly-contracts-lookup-all-employees" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-monthly-contracts-lookup-all-employees"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-monthly-contracts-lookup-all-employees"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-monthly-contracts-lookup-all-employees" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-monthly-contracts-lookup-all-employees">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-monthly-contracts-lookup-all-employees" data-method="GET"
      data-path="api/am-monthly-contracts/lookup-all-employees"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-monthly-contracts-lookup-all-employees', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-monthly-contracts-lookup-all-employees"
                    onclick="tryItOut('GETapi-am-monthly-contracts-lookup-all-employees');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-monthly-contracts-lookup-all-employees"
                    onclick="cancelTryOut('GETapi-am-monthly-contracts-lookup-all-employees');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-monthly-contracts-lookup-all-employees"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-monthly-contracts/lookup-all-employees</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-monthly-contracts-lookup-all-employees"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-monthly-contracts-lookup-all-employees"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-am-monthly-contracts-lookup-all-employees"
               value="maria"
               data-component="query">
    <br>
<p>Search term to match against employee name. Example: <code>maria</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>limit</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="limit"                data-endpoint="GETapi-am-monthly-contracts-lookup-all-employees"
               value="10"
               data-component="query">
    <br>
<p>Maximum number of results. Default: 20. Example: <code>10</code></p>
            </div>
                </form>

                    <h2 id="package-3-modular-GETapi-am-monthly-contracts-search-candidates">Search candidates by CN number, reference numbers, or candidate name.</h2>

<p>
</p>

<p>Returns full candidate records from new_candidates.</p>

<span id="example-requests-GETapi-am-monthly-contracts-search-candidates">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/search-candidates?search=EP3-0008&amp;limit=50" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"search\": \"b\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/search-candidates"
);

const params = {
    "search": "EP3-0008",
    "limit": "50",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "search": "b"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-monthly-contracts-search-candidates">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;id&quot;: 1,
        &quot;CN_Number&quot;: &quot;CN-0001&quot;,
        &quot;reference_no&quot;: &quot;EP3-0008&quot;,
        &quot;ref_no&quot;: &quot;REF-001&quot;,
        &quot;candidate_name&quot;: &quot;Maria Santos&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-monthly-contracts-search-candidates" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-monthly-contracts-search-candidates"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-monthly-contracts-search-candidates"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-monthly-contracts-search-candidates" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-monthly-contracts-search-candidates">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-monthly-contracts-search-candidates" data-method="GET"
      data-path="api/am-monthly-contracts/search-candidates"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-monthly-contracts-search-candidates', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-monthly-contracts-search-candidates"
                    onclick="tryItOut('GETapi-am-monthly-contracts-search-candidates');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-monthly-contracts-search-candidates"
                    onclick="cancelTryOut('GETapi-am-monthly-contracts-search-candidates');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-monthly-contracts-search-candidates"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-monthly-contracts/search-candidates</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-monthly-contracts-search-candidates"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-monthly-contracts-search-candidates"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-am-monthly-contracts-search-candidates"
               value="EP3-0008"
               data-component="query">
    <br>
<p>Search keyword. Matches CN_Number, reference_no, ref_no, candidate_name. Example: <code>EP3-0008</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>limit</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="limit"                data-endpoint="GETapi-am-monthly-contracts-search-candidates"
               value="50"
               data-component="query">
    <br>
<p>Max number of rows to return. Default: 20. Example: <code>50</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-am-monthly-contracts-search-candidates"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-GETapi-am-monthly-contracts-all-employees">List all employees (maids).</h2>

<p>
</p>

<p>Returns a paginated list of employees with optional filters.</p>

<span id="example-requests-GETapi-am-monthly-contracts-all-employees">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/all-employees?per_page=20&amp;name=maria&amp;inside_status=1&amp;nationality=Philippines&amp;payment_type=bank&amp;passport_no=P12345&amp;emirates_id=784-&amp;reference_no=EMP-0001&amp;inside_country_or_outside=1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"architecto\",
    \"inside_status\": 16,
    \"nationality\": \"n\",
    \"payment_type\": \"g\",
    \"passport_no\": \"z\",
    \"emirates_id\": \"m\",
    \"reference_no\": \"i\",
    \"inside_country_or_outside\": 16,
    \"per_page\": 22
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/all-employees"
);

const params = {
    "per_page": "20",
    "name": "maria",
    "inside_status": "1",
    "nationality": "Philippines",
    "payment_type": "bank",
    "passport_no": "P12345",
    "emirates_id": "784-",
    "reference_no": "EMP-0001",
    "inside_country_or_outside": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "architecto",
    "inside_status": 16,
    "nationality": "n",
    "payment_type": "g",
    "passport_no": "z",
    "emirates_id": "m",
    "reference_no": "i",
    "inside_country_or_outside": 16,
    "per_page": 22
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-monthly-contracts-all-employees">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 5,
            &quot;name&quot;: &quot;Maria Santos&quot;
        }
    ],
    &quot;last_page&quot;: 1,
    &quot;per_page&quot;: 15,
    &quot;total&quot;: 1
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-monthly-contracts-all-employees" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-monthly-contracts-all-employees"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-monthly-contracts-all-employees"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-monthly-contracts-all-employees" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-monthly-contracts-all-employees">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-monthly-contracts-all-employees" data-method="GET"
      data-path="api/am-monthly-contracts/all-employees"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-monthly-contracts-all-employees', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-monthly-contracts-all-employees"
                    onclick="tryItOut('GETapi-am-monthly-contracts-all-employees');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-monthly-contracts-all-employees"
                    onclick="cancelTryOut('GETapi-am-monthly-contracts-all-employees');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-monthly-contracts-all-employees"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-monthly-contracts/all-employees</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Default: 15. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="maria"
               data-component="query">
    <br>
<p>Filter by employee name. Example: <code>maria</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>inside_status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="inside_status"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="1"
               data-component="query">
    <br>
<p>Filter by maid status enum:
0 = Pending, 1 = Office, 2 = Hired, 3 = Incidented. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>nationality</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="nationality"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="Philippines"
               data-component="query">
    <br>
<p>Filter by nationality. Example: <code>Philippines</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>payment_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="payment_type"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="bank"
               data-component="query">
    <br>
<p>Filter by payment type. Example: <code>bank</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>passport_no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="passport_no"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="P12345"
               data-component="query">
    <br>
<p>Filter by passport number (partial match). Example: <code>P12345</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>emirates_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="emirates_id"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="784-"
               data-component="query">
    <br>
<p>Filter by Emirates ID (partial match). Example: <code>784-</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>reference_no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="reference_no"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="EMP-0001"
               data-component="query">
    <br>
<p>Filter by reference number (partial match). Example: <code>EMP-0001</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>inside_country_or_outside</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="inside_country_or_outside"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="1"
               data-component="query">
    <br>
<p>Filter by location status (1 = Outside, 2 = Inside). Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>inside_status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="inside_status"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>nationality</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="nationality"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="payment_type"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 50 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>passport_no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="passport_no"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="z"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>z</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>emirates_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="emirates_id"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="m"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>m</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>reference_no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="reference_no"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="i"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>i</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>inside_country_or_outside</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="inside_country_or_outside"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-monthly-contracts-all-employees"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 200. Example: <code>22</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-POSTapi-am-monthly-contracts-employees">Create a new employee for monthly contracts.</h2>

<p>
</p>



<span id="example-requests-POSTapi-am-monthly-contracts-employees">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/employees" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Maria Santos\",
    \"nationality\": \"Philippines\",
    \"passport_expiry_date\": \"2028-12-31\",
    \"passport_no\": \"P1234567\",
    \"emirates_id\": \"784-1990-1234567-1\",
    \"salary\": 1500,
    \"payment_type\": \"cash\",
    \"inside_country_or_outside\": 2
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/employees"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Maria Santos",
    "nationality": "Philippines",
    "passport_expiry_date": "2028-12-31",
    "passport_no": "P1234567",
    "emirates_id": "784-1990-1234567-1",
    "salary": 1500,
    "payment_type": "cash",
    "inside_country_or_outside": 2
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-am-monthly-contracts-employees">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Employee created successfully&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Maria Santos&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-am-monthly-contracts-employees" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-am-monthly-contracts-employees"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-am-monthly-contracts-employees"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-am-monthly-contracts-employees" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-am-monthly-contracts-employees">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-am-monthly-contracts-employees" data-method="POST"
      data-path="api/am-monthly-contracts/employees"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-am-monthly-contracts-employees', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-am-monthly-contracts-employees"
                    onclick="tryItOut('POSTapi-am-monthly-contracts-employees');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-am-monthly-contracts-employees"
                    onclick="cancelTryOut('POSTapi-am-monthly-contracts-employees');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-am-monthly-contracts-employees"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/am-monthly-contracts/employees</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-am-monthly-contracts-employees"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-am-monthly-contracts-employees"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-am-monthly-contracts-employees"
               value="Maria Santos"
               data-component="body">
    <br>
<p>Employee name. Example: <code>Maria Santos</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>nationality</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="nationality"                data-endpoint="POSTapi-am-monthly-contracts-employees"
               value="Philippines"
               data-component="body">
    <br>
<p>Employee nationality. Example: <code>Philippines</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>passport_expiry_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="passport_expiry_date"                data-endpoint="POSTapi-am-monthly-contracts-employees"
               value="2028-12-31"
               data-component="body">
    <br>
<p>Passport expiry date. Example: <code>2028-12-31</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>passport_no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="passport_no"                data-endpoint="POSTapi-am-monthly-contracts-employees"
               value="P1234567"
               data-component="body">
    <br>
<p>Employee passport number. Example: <code>P1234567</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>emirates_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="emirates_id"                data-endpoint="POSTapi-am-monthly-contracts-employees"
               value="784-1990-1234567-1"
               data-component="body">
    <br>
<p>Employee Emirates ID. Example: <code>784-1990-1234567-1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>salary</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="salary"                data-endpoint="POSTapi-am-monthly-contracts-employees"
               value="1500"
               data-component="body">
    <br>
<p>Employee monthly salary. Example: <code>1500</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="payment_type"                data-endpoint="POSTapi-am-monthly-contracts-employees"
               value="cash"
               data-component="body">
    <br>
<p>Employee payment type. Example: <code>cash</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>inside_country_or_outside</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="inside_country_or_outside"                data-endpoint="POSTapi-am-monthly-contracts-employees"
               value="2"
               data-component="body">
    <br>
<p>1 = Outside, 2 = Inside. Example: <code>2</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-PUTapi-am-monthly-contracts-employees--id-">Update an employee for monthly contracts.</h2>

<p>
</p>



<span id="example-requests-PUTapi-am-monthly-contracts-employees--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/employees/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Maria Santos\",
    \"nationality\": \"Philippines\",
    \"passport_expiry_date\": \"2028-12-31\",
    \"passport_no\": \"P1234567\",
    \"emirates_id\": \"784-1990-1234567-1\",
    \"salary\": 1500,
    \"payment_type\": \"bank\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/employees/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Maria Santos",
    "nationality": "Philippines",
    "passport_expiry_date": "2028-12-31",
    "passport_no": "P1234567",
    "emirates_id": "784-1990-1234567-1",
    "salary": 1500,
    "payment_type": "bank"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-am-monthly-contracts-employees--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Employee updated successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-am-monthly-contracts-employees--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-am-monthly-contracts-employees--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-am-monthly-contracts-employees--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-am-monthly-contracts-employees--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-am-monthly-contracts-employees--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-am-monthly-contracts-employees--id-" data-method="PUT"
      data-path="api/am-monthly-contracts/employees/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-am-monthly-contracts-employees--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-am-monthly-contracts-employees--id-"
                    onclick="tryItOut('PUTapi-am-monthly-contracts-employees--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-am-monthly-contracts-employees--id-"
                    onclick="cancelTryOut('PUTapi-am-monthly-contracts-employees--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-am-monthly-contracts-employees--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/am-monthly-contracts/employees/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the employee. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="5"
               data-component="url">
    <br>
<p>Employee ID. Example: <code>5</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="Maria Santos"
               data-component="body">
    <br>
<p>Employee name. Example: <code>Maria Santos</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>nationality</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="nationality"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="Philippines"
               data-component="body">
    <br>
<p>Employee nationality. Example: <code>Philippines</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>passport_expiry_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="passport_expiry_date"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="2028-12-31"
               data-component="body">
    <br>
<p>Passport expiry date. Example: <code>2028-12-31</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>passport_no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="passport_no"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="P1234567"
               data-component="body">
    <br>
<p>Employee passport number. Example: <code>P1234567</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>emirates_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="emirates_id"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="784-1990-1234567-1"
               data-component="body">
    <br>
<p>Employee Emirates ID. Example: <code>784-1990-1234567-1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>salary</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="salary"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="1500"
               data-component="body">
    <br>
<p>Employee monthly salary. Example: <code>1500</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="payment_type"                data-endpoint="PUTapi-am-monthly-contracts-employees--id-"
               value="bank"
               data-component="body">
    <br>
<p>Employee payment type. Example: <code>bank</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-GETapi-am-monthly-contracts-lookup-customers">Lookup customers (CRM).</h2>

<p>
</p>

<p>Search customers by name, mobile, or CL number for autocomplete.
Returns CRM IDs (not ledger IDs). Same response format as /api/ledgers/lookup-customers.</p>

<span id="example-requests-GETapi-am-monthly-contracts-lookup-customers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/lookup-customers?search=ahmed&amp;page=1&amp;per_page=20" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/lookup-customers"
);

const params = {
    "search": "ahmed",
    "page": "1",
    "per_page": "20",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-monthly-contracts-lookup-customers">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;results&quot;: [
        {
            &quot;id&quot;: 5,
            &quot;text&quot;: &quot;Ahmed Ali&quot;,
            &quot;mobile&quot;: &quot;0501234567&quot;,
            &quot;crm&quot;: {
                &quot;first_name&quot;: &quot;Ahmed&quot;,
                &quot;last_name&quot;: &quot;Ali&quot;,
                &quot;mobile&quot;: &quot;0501234567&quot;,
                &quot;CL_Number&quot;: &quot;CL-001&quot;
            }
        }
    ],
    &quot;pagination&quot;: {
        &quot;more&quot;: false,
        &quot;current_page&quot;: 1,
        &quot;total&quot;: 1
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-monthly-contracts-lookup-customers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-monthly-contracts-lookup-customers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-monthly-contracts-lookup-customers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-monthly-contracts-lookup-customers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-monthly-contracts-lookup-customers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-monthly-contracts-lookup-customers" data-method="GET"
      data-path="api/am-monthly-contracts/lookup-customers"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-monthly-contracts-lookup-customers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-monthly-contracts-lookup-customers"
                    onclick="tryItOut('GETapi-am-monthly-contracts-lookup-customers');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-monthly-contracts-lookup-customers"
                    onclick="cancelTryOut('GETapi-am-monthly-contracts-lookup-customers');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-monthly-contracts-lookup-customers"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-monthly-contracts/lookup-customers</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-monthly-contracts-lookup-customers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-monthly-contracts-lookup-customers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-am-monthly-contracts-lookup-customers"
               value="ahmed"
               data-component="query">
    <br>
<p>Search by name, mobile, CL number. Example: <code>ahmed</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-am-monthly-contracts-lookup-customers"
               value="1"
               data-component="query">
    <br>
<p>Page number. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-monthly-contracts-lookup-customers"
               value="20"
               data-component="query">
    <br>
<p>Items per page. Default: 10. Example: <code>20</code></p>
            </div>
                </form>

                    <h2 id="package-3-modular-POSTapi-am-monthly-contracts-import-excel">Import monthly contracts from Excel.</h2>

<p>
</p>

<p>Expected heading columns:</p>
<ul>
<li>customer (CL_Number from CRM table)</li>
<li>maid</li>
<li>start</li>
<li>end</li>
<li>amount</li>
<li>date_of_installment</li>
</ul>
<p>Validation:</p>
<ul>
<li>customer CL_Number must exist in CRM table</li>
<li>maid must exist in Employees table</li>
</ul>
<p>Creates:
1) am_primary_contracts
2) am_contract_movments
3) am_installments</p>

<span id="example-requests-POSTapi-am-monthly-contracts-import-excel">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/import-excel" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "file=@/tmp/php1samnN" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/import-excel"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('file', document.querySelector('input[name="file"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-am-monthly-contracts-import-excel">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Import completed&quot;,
    &quot;contracts_created&quot;: 3,
    &quot;row_failures_count&quot;: 1,
    &quot;row_errors&quot;: [
        {
            &quot;row&quot;: 4,
            &quot;error&quot;: &quot;Customer not found: Unknown&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-am-monthly-contracts-import-excel" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-am-monthly-contracts-import-excel"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-am-monthly-contracts-import-excel"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-am-monthly-contracts-import-excel" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-am-monthly-contracts-import-excel">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-am-monthly-contracts-import-excel" data-method="POST"
      data-path="api/am-monthly-contracts/import-excel"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-am-monthly-contracts-import-excel', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-am-monthly-contracts-import-excel"
                    onclick="tryItOut('POSTapi-am-monthly-contracts-import-excel');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-am-monthly-contracts-import-excel"
                    onclick="cancelTryOut('POSTapi-am-monthly-contracts-import-excel');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-am-monthly-contracts-import-excel"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/am-monthly-contracts/import-excel</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-am-monthly-contracts-import-excel"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-am-monthly-contracts-import-excel"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>file</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="file"                data-endpoint="POSTapi-am-monthly-contracts-import-excel"
               value=""
               data-component="body">
    <br>
<p>Excel file (.xlsx/.xls/.csv) with heading row. Example: <code>/tmp/php1samnN</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-GETapi-am-monthly-contracts">List all monthly contracts.</h2>

<p>
</p>

<p>Returns a paginated list of monthly contracts with movements, installments, employee and customer data.</p>

<span id="example-requests-GETapi-am-monthly-contracts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-monthly-contracts?per_page=20&amp;customer_name=Ahmed&amp;crm_id=1&amp;employee_name=Maria&amp;employee_id=5&amp;status=1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts"
);

const params = {
    "per_page": "20",
    "customer_name": "Ahmed",
    "crm_id": "1",
    "employee_name": "Maria",
    "employee_id": "5",
    "status": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-monthly-contracts">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [],
    &quot;last_page&quot;: 1,
    &quot;per_page&quot;: 15,
    &quot;total&quot;: 0
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-monthly-contracts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-monthly-contracts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-monthly-contracts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-monthly-contracts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-monthly-contracts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-monthly-contracts" data-method="GET"
      data-path="api/am-monthly-contracts"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-monthly-contracts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-monthly-contracts"
                    onclick="tryItOut('GETapi-am-monthly-contracts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-monthly-contracts"
                    onclick="cancelTryOut('GETapi-am-monthly-contracts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-monthly-contracts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-monthly-contracts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-monthly-contracts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-monthly-contracts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-monthly-contracts"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Default: 15. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customer_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_name"                data-endpoint="GETapi-am-monthly-contracts"
               value="Ahmed"
               data-component="query">
    <br>
<p>Filter by customer name (first or last). Example: <code>Ahmed</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>crm_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="crm_id"                data-endpoint="GETapi-am-monthly-contracts"
               value="1"
               data-component="query">
    <br>
<p>Filter by customer (CRM) ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="employee_name"                data-endpoint="GETapi-am-monthly-contracts"
               value="Maria"
               data-component="query">
    <br>
<p>Filter by employee/maid name. Example: <code>Maria</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="GETapi-am-monthly-contracts"
               value="5"
               data-component="query">
    <br>
<p>Filter by employee/maid ID. Example: <code>5</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="GETapi-am-monthly-contracts"
               value="1"
               data-component="query">
    <br>
<p>Filter by status (0 = inactive, 1 = active). Example: <code>1</code></p>
            </div>
                </form>

                    <h2 id="package-3-modular-POSTapi-am-monthly-contracts">Create a new monthly contract.</h2>

<p>
</p>

<p>Creates a primary contract with a contract movement and installments.
Optionally creates a prorate journal entry when prorate_amount is provided.</p>

<span id="example-requests-POSTapi-am-monthly-contracts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"start_date\": \"2026-03-01\",
    \"ended_date\": \"2027-03-01\",
    \"customer_id\": 1,
    \"maid_id\": 5,
    \"installment\": [
        \"architecto\"
    ],
    \"prorate_amount\": 3000,
    \"prorate_days\": 24
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "start_date": "2026-03-01",
    "ended_date": "2027-03-01",
    "customer_id": 1,
    "maid_id": 5,
    "installment": [
        "architecto"
    ],
    "prorate_amount": 3000,
    "prorate_days": 24
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-am-monthly-contracts">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Contract created successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Prorate amount is less than maid salary.&quot;,
    &quot;errors&quot;: {
        &quot;prorate_amount&quot;: [
            &quot;Prorate base amount (X) is less than maid salary cost (Y).&quot;
        ]
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Failed to create contract&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-am-monthly-contracts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-am-monthly-contracts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-am-monthly-contracts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-am-monthly-contracts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-am-monthly-contracts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-am-monthly-contracts" data-method="POST"
      data-path="api/am-monthly-contracts"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-am-monthly-contracts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-am-monthly-contracts"
                    onclick="tryItOut('POSTapi-am-monthly-contracts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-am-monthly-contracts"
                    onclick="cancelTryOut('POSTapi-am-monthly-contracts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-am-monthly-contracts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/am-monthly-contracts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-am-monthly-contracts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-am-monthly-contracts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>start_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="start_date"                data-endpoint="POSTapi-am-monthly-contracts"
               value="2026-03-01"
               data-component="body">
    <br>
<p>The contract start date. Example: <code>2026-03-01</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ended_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ended_date"                data-endpoint="POSTapi-am-monthly-contracts"
               value="2027-03-01"
               data-component="body">
    <br>
<p>The contract end date. Example: <code>2027-03-01</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="customer_id"                data-endpoint="POSTapi-am-monthly-contracts"
               value="1"
               data-component="body">
    <br>
<p>The customer (CRM) ID. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>maid_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="maid_id"                data-endpoint="POSTapi-am-monthly-contracts"
               value="5"
               data-component="body">
    <br>
<p>The employee/maid ID. Example: <code>5</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>installment</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
 &nbsp;
<br>
<p>List of installments.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="installment.0.date"                data-endpoint="POSTapi-am-monthly-contracts"
               value="2026-03-01"
               data-component="body">
    <br>
<p>The installment date. Example: <code>2026-03-01</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="installment.0.amount"                data-endpoint="POSTapi-am-monthly-contracts"
               value="1000"
               data-component="body">
    <br>
<p>The installment amount. Example: <code>1000</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="installment.0.note"                data-endpoint="POSTapi-am-monthly-contracts"
               value="First installment"
               data-component="body">
    <br>
<p>A note for the installment. Example: <code>First installment</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>prorate_amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="prorate_amount"                data-endpoint="POSTapi-am-monthly-contracts"
               value="3000"
               data-component="body">
    <br>
<p>The prorate amount (VAT inclusive). When provided, a journal entry is created splitting the amount into VAT, salary cost, and profit. Example: <code>3000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>prorate_days</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="prorate_days"                data-endpoint="POSTapi-am-monthly-contracts"
               value="24"
               data-component="body">
    <br>
<p>Number of prorate days (1-30, required when prorate_amount is provided). Example: <code>24</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-GETapi-am-monthly-contracts--id-">Display a specific monthly contract.</h2>

<p>
</p>

<p>Returns a single contract with its movements, installments, employee and customer data.</p>

<span id="example-requests-GETapi-am-monthly-contracts--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-monthly-contracts--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;date&quot;: &quot;2026-03-01&quot;,
    &quot;crm_id&quot;: 1,
    &quot;end_date&quot;: &quot;2027-03-01&quot;,
    &quot;status&quot;: 1,
    &quot;type&quot;: 2,
    &quot;contract_movments&quot;: [],
    &quot;crm&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Contract not found&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-monthly-contracts--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-monthly-contracts--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-monthly-contracts--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-monthly-contracts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-monthly-contracts--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-monthly-contracts--id-" data-method="GET"
      data-path="api/am-monthly-contracts/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-monthly-contracts--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-monthly-contracts--id-"
                    onclick="tryItOut('GETapi-am-monthly-contracts--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-monthly-contracts--id-"
                    onclick="cancelTryOut('GETapi-am-monthly-contracts--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-monthly-contracts--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-monthly-contracts/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-monthly-contracts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-monthly-contracts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-am-monthly-contracts--id-"
               value="1"
               data-component="url">
    <br>
<p>The contract ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="package-3-modular-PUTapi-am-monthly-contracts--id-">Update a monthly contract.</h2>

<p>
</p>



<span id="example-requests-PUTapi-am-monthly-contracts--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"date\": \"2026-04-01\",
    \"end_date\": \"2027-04-01\",
    \"note\": \"Updated contract note\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "date": "2026-04-01",
    "end_date": "2027-04-01",
    "note": "Updated contract note"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-am-monthly-contracts--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Contract updated successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Contract not found&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Failed to update contract&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-am-monthly-contracts--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-am-monthly-contracts--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-am-monthly-contracts--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-am-monthly-contracts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-am-monthly-contracts--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-am-monthly-contracts--id-" data-method="PUT"
      data-path="api/am-monthly-contracts/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-am-monthly-contracts--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-am-monthly-contracts--id-"
                    onclick="tryItOut('PUTapi-am-monthly-contracts--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-am-monthly-contracts--id-"
                    onclick="cancelTryOut('PUTapi-am-monthly-contracts--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-am-monthly-contracts--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/am-monthly-contracts/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/am-monthly-contracts/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-am-monthly-contracts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-am-monthly-contracts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-am-monthly-contracts--id-"
               value="1"
               data-component="url">
    <br>
<p>The contract ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date"                data-endpoint="PUTapi-am-monthly-contracts--id-"
               value="2026-04-01"
               data-component="body">
    <br>
<p>The contract start date. Example: <code>2026-04-01</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>end_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="end_date"                data-endpoint="PUTapi-am-monthly-contracts--id-"
               value="2027-04-01"
               data-component="body">
    <br>
<p>The contract end date. Example: <code>2027-04-01</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-am-monthly-contracts--id-"
               value="Updated contract note"
               data-component="body">
    <br>
<p>An optional note. Example: <code>Updated contract note</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-DELETEapi-am-monthly-contracts--id-">Delete a monthly contract.</h2>

<p>
</p>

<p>Deletes the contract and its associated movements and installments.</p>

<span id="example-requests-DELETEapi-am-monthly-contracts--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-am-monthly-contracts--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Contract deleted successfully&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Failed to delete contract&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-am-monthly-contracts--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-am-monthly-contracts--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-am-monthly-contracts--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-am-monthly-contracts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-am-monthly-contracts--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-am-monthly-contracts--id-" data-method="DELETE"
      data-path="api/am-monthly-contracts/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-am-monthly-contracts--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-am-monthly-contracts--id-"
                    onclick="tryItOut('DELETEapi-am-monthly-contracts--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-am-monthly-contracts--id-"
                    onclick="cancelTryOut('DELETEapi-am-monthly-contracts--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-am-monthly-contracts--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/am-monthly-contracts/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-am-monthly-contracts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-am-monthly-contracts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-am-monthly-contracts--id-"
               value="1"
               data-component="url">
    <br>
<p>The contract ID. Example: <code>1</code></p>
            </div>
                    </form>

                                <h2 id="package-3-modular-return-maids-this-will-return-namespace-appenum-enum-mcstatus-int-case-pending-0-case-returntooffice-1-amer-make-this-status-to-show-in-return-list-if-value-0-make-it-pending-and-if-value-1-make-it-return-to-office-in-the-raw-action-i-want-to-make-action-for-refund-or-replacement-or-due-amount">Return Maids

this will return namespace App\Enum;
enum MCStatus: int
case Pending = 0;
case ReturnToOffice = 1;
Amer make this status to show in return list if value 0 make it pending and if value 1 make it return to office
in the raw action I want to make action for refund or replacement or due amount</h2>
                                                    <h2 id="package-3-modular-POSTapi-am-monthly-contracts--id--return">Return a maid from a contract movement.</h2>

<p>
</p>

<p>Records the return in am_return_maids, sets movement and contract status to 0,
and resets the maid's inside_status back to 1 (in office).</p>

<span id="example-requests-POSTapi-am-monthly-contracts--id--return">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/3/return" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"date\": \"2026-02-19\",
    \"note\": \"Maid returned by customer\",
    \"status\": 1,
    \"action\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-contracts/3/return"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "date": "2026-02-19",
    "note": "Maid returned by customer",
    "status": 1,
    "action": 1
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-am-monthly-contracts--id--return">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Maid returned successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Validation failed&quot;,
    &quot;errors&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Failed to return maid&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-am-monthly-contracts--id--return" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-am-monthly-contracts--id--return"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-am-monthly-contracts--id--return"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-am-monthly-contracts--id--return" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-am-monthly-contracts--id--return">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-am-monthly-contracts--id--return" data-method="POST"
      data-path="api/am-monthly-contracts/{id}/return"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-am-monthly-contracts--id--return', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-am-monthly-contracts--id--return"
                    onclick="tryItOut('POSTapi-am-monthly-contracts--id--return');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-am-monthly-contracts--id--return"
                    onclick="cancelTryOut('POSTapi-am-monthly-contracts--id--return');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-am-monthly-contracts--id--return"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/am-monthly-contracts/{id}/return</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-am-monthly-contracts--id--return"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-am-monthly-contracts--id--return"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-am-monthly-contracts--id--return"
               value="3"
               data-component="url">
    <br>
<p>The contract movement ID. Example: <code>3</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date"                data-endpoint="POSTapi-am-monthly-contracts--id--return"
               value="2026-02-19"
               data-component="body">
    <br>
<p>The return date. Example: <code>2026-02-19</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-am-monthly-contracts--id--return"
               value="Maid returned by customer"
               data-component="body">
    <br>
<p>An optional note. Example: <code>Maid returned by customer</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="POSTapi-am-monthly-contracts--id--return"
               value="1"
               data-component="body">
    <br>
<p>Return status (0 = Pending, 1 = Return to Office, 2 = Ran Away, 3 = Cancelled, 4 = Hold). Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>action</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="action"                data-endpoint="POSTapi-am-monthly-contracts--id--return"
               value="1"
               data-component="body">
    <br>
<p>Return action (1 = Pending, 2 = Replacement, 3 = Refund, 4 = Due Amount). Example: <code>1</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-GETapi-am-return-maids">List return maids.</h2>

<p>
</p>

<p>Returns a paginated list of maid returns with optional filters.
Each return includes the related contract movement, employee, contract, and customer.</p>

<span id="example-requests-GETapi-am-return-maids">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-return-maids?per_page=20&amp;sort_by=status&amp;sort_direction=asc&amp;contract_id=1&amp;employee_id=5&amp;employee_name=Maria&amp;customer_name=Ahmed&amp;crm_id=1&amp;status=1&amp;action=1&amp;date_from=2026-01-01&amp;date_to=2026-12-31&amp;search=returned" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-return-maids"
);

const params = {
    "per_page": "20",
    "sort_by": "status",
    "sort_direction": "asc",
    "contract_id": "1",
    "employee_id": "5",
    "employee_name": "Maria",
    "customer_name": "Ahmed",
    "crm_id": "1",
    "status": "1",
    "action": "1",
    "date_from": "2026-01-01",
    "date_to": "2026-12-31",
    "search": "returned",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-return-maids">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;date&quot;: &quot;2026-02-19&quot;,
            &quot;am_movment_id&quot;: 3,
            &quot;note&quot;: &quot;Maid returned by customer&quot;,
            &quot;status&quot;: 1,
            &quot;contract_movment&quot;: {
                &quot;id&quot;: 3,
                &quot;employee&quot;: {},
                &quot;primary_contract&quot;: {
                    &quot;crm&quot;: {}
                }
            }
        }
    ],
    &quot;last_page&quot;: 1,
    &quot;per_page&quot;: 15,
    &quot;total&quot;: 1
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-return-maids" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-return-maids"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-return-maids"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-return-maids" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-return-maids">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-return-maids" data-method="GET"
      data-path="api/am-return-maids"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-return-maids', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-return-maids"
                    onclick="tryItOut('GETapi-am-return-maids');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-return-maids"
                    onclick="cancelTryOut('GETapi-am-return-maids');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-return-maids"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-return-maids</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-return-maids"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-return-maids"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-return-maids"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Default: 15. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-am-return-maids"
               value="status"
               data-component="query">
    <br>
<p>Sort field (id, date, status, created_at). Default: date. Example: <code>status</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-am-return-maids"
               value="asc"
               data-component="query">
    <br>
<p>Sort direction (asc, desc). Default: desc. Example: <code>asc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>contract_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="contract_id"                data-endpoint="GETapi-am-return-maids"
               value="1"
               data-component="query">
    <br>
<p>Filter by primary contract ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="GETapi-am-return-maids"
               value="5"
               data-component="query">
    <br>
<p>Filter by employee/maid ID. Example: <code>5</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="employee_name"                data-endpoint="GETapi-am-return-maids"
               value="Maria"
               data-component="query">
    <br>
<p>Filter by employee/maid name. Example: <code>Maria</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customer_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_name"                data-endpoint="GETapi-am-return-maids"
               value="Ahmed"
               data-component="query">
    <br>
<p>Filter by customer name (first or last). Example: <code>Ahmed</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>crm_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="crm_id"                data-endpoint="GETapi-am-return-maids"
               value="1"
               data-component="query">
    <br>
<p>Filter by customer (CRM) ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="GETapi-am-return-maids"
               value="1"
               data-component="query">
    <br>
<p>Filter by status (0 = Pending, 1 = Return to Office, 2 = Ran Away, 3 = Cancelled, 4 = Hold). Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>action</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="action"                data-endpoint="GETapi-am-return-maids"
               value="1"
               data-component="query">
    <br>
<p>Filter by action (1 = Pending, 2 = Replacement, 3 = Refund, 4 = Due Amount). Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date_from"                data-endpoint="GETapi-am-return-maids"
               value="2026-01-01"
               data-component="query">
    <br>
<p>Filter returns from this date. Example: <code>2026-01-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date_to"                data-endpoint="GETapi-am-return-maids"
               value="2026-12-31"
               data-component="query">
    <br>
<p>Filter returns until this date. Example: <code>2026-12-31</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-am-return-maids"
               value="returned"
               data-component="query">
    <br>
<p>Search by note. Example: <code>returned</code></p>
            </div>
                </form>

                    <h2 id="package-3-modular-GETapi-am-return-maids--id-">Display a specific return maid record.</h2>

<p>
</p>

<p>Returns a single return maid with its related contract movement, employee, and customer.</p>

<span id="example-requests-GETapi-am-return-maids--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-return-maids/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-return-maids/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-return-maids--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;date&quot;: &quot;2026-02-19&quot;,
    &quot;am_movment_id&quot;: 3,
    &quot;note&quot;: &quot;Maid returned by customer&quot;,
    &quot;status&quot;: 1,
    &quot;contract_movment&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Return maid record not found&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-return-maids--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-return-maids--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-return-maids--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-return-maids--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-return-maids--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-return-maids--id-" data-method="GET"
      data-path="api/am-return-maids/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-return-maids--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-return-maids--id-"
                    onclick="tryItOut('GETapi-am-return-maids--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-return-maids--id-"
                    onclick="cancelTryOut('GETapi-am-return-maids--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-return-maids--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-return-maids/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-return-maids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-return-maids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-am-return-maids--id-"
               value="1"
               data-component="url">
    <br>
<p>The return maid ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="package-3-modular-POSTapi-am-return-maids--id--replacement">Mark returned maid as replacement requested and execute replacement.</h2>

<p>
</p>



<span id="example-requests-POSTapi-am-return-maids--id--replacement">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/am-return-maids/1/replacement" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"new_employee_id\": 5,
    \"date\": \"2026-02-22\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-return-maids/1/replacement"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "new_employee_id": 5,
    "date": "2026-02-22"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-am-return-maids--id--replacement">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Replacement executed successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-am-return-maids--id--replacement" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-am-return-maids--id--replacement"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-am-return-maids--id--replacement"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-am-return-maids--id--replacement" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-am-return-maids--id--replacement">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-am-return-maids--id--replacement" data-method="POST"
      data-path="api/am-return-maids/{id}/replacement"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-am-return-maids--id--replacement', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-am-return-maids--id--replacement"
                    onclick="tryItOut('POSTapi-am-return-maids--id--replacement');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-am-return-maids--id--replacement"
                    onclick="cancelTryOut('POSTapi-am-return-maids--id--replacement');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-am-return-maids--id--replacement"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/am-return-maids/{id}/replacement</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-am-return-maids--id--replacement"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-am-return-maids--id--replacement"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-am-return-maids--id--replacement"
               value="1"
               data-component="url">
    <br>
<p>The return maid ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>new_employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="new_employee_id"                data-endpoint="POSTapi-am-return-maids--id--replacement"
               value="5"
               data-component="body">
    <br>
<p>New employee ID for replacement. Example: <code>5</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date"                data-endpoint="POSTapi-am-return-maids--id--replacement"
               value="2026-02-22"
               data-component="body">
    <br>
<p>Replacement date. Example: <code>2026-02-22</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-PUTapi-am-return-maids--id-">Update a return maid record.</h2>

<p>
</p>



<span id="example-requests-PUTapi-am-return-maids--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/am-return-maids/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"date\": \"2026-02-20\",
    \"note\": \"Updated return note\",
    \"status\": 1,
    \"action\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-return-maids/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "date": "2026-02-20",
    "note": "Updated return note",
    "status": 1,
    "action": 1
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-am-return-maids--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Return maid record updated successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Return maid record not found&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Failed to update return maid record&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-am-return-maids--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-am-return-maids--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-am-return-maids--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-am-return-maids--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-am-return-maids--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-am-return-maids--id-" data-method="PUT"
      data-path="api/am-return-maids/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-am-return-maids--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-am-return-maids--id-"
                    onclick="tryItOut('PUTapi-am-return-maids--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-am-return-maids--id-"
                    onclick="cancelTryOut('PUTapi-am-return-maids--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-am-return-maids--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/am-return-maids/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-am-return-maids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-am-return-maids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-am-return-maids--id-"
               value="1"
               data-component="url">
    <br>
<p>The return maid ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date"                data-endpoint="PUTapi-am-return-maids--id-"
               value="2026-02-20"
               data-component="body">
    <br>
<p>The return date. Example: <code>2026-02-20</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-am-return-maids--id-"
               value="Updated return note"
               data-component="body">
    <br>
<p>An optional note. Example: <code>Updated return note</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="PUTapi-am-return-maids--id-"
               value="1"
               data-component="body">
    <br>
<p>Status (0 = Pending, 1 = Return to Office, 2 = Ran Away, 3 = Cancelled, 4 = Hold). Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>action</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="action"                data-endpoint="PUTapi-am-return-maids--id-"
               value="1"
               data-component="body">
    <br>
<p>Action (1 = Pending, 2 = Replacement, 3 = Refund, 4 = Due Amount). Example: <code>1</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-DELETEapi-am-return-maids--id-">Delete a return maid record.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-am-return-maids--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/am-return-maids/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-return-maids/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-am-return-maids--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Return maid record deleted successfully&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Return maid record not found&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Failed to delete return maid record&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-am-return-maids--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-am-return-maids--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-am-return-maids--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-am-return-maids--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-am-return-maids--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-am-return-maids--id-" data-method="DELETE"
      data-path="api/am-return-maids/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-am-return-maids--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-am-return-maids--id-"
                    onclick="tryItOut('DELETEapi-am-return-maids--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-am-return-maids--id-"
                    onclick="cancelTryOut('DELETEapi-am-return-maids--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-am-return-maids--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/am-return-maids/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-am-return-maids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-am-return-maids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-am-return-maids--id-"
               value="1"
               data-component="url">
    <br>
<p>The return maid ID. Example: <code>1</code></p>
            </div>
                    </form>

                                <h2 id="package-3-modular-incidents-apis-for-managing-incidents-ran-away-cancelled-hold-related-to-monthly-contracts-these-records-share-the-am-return-maids-table">Incidents

APIs for managing incidents (Ran Away, Cancelled, Hold) related to monthly contracts.
These records share the am_return_maids table.</h2>
                                                    <h2 id="package-3-modular-GETapi-am-incidents">List incidents.</h2>

<p>
</p>

<p>Returns a paginated list of incidents (RanAway, Cancelled, Hold).</p>

<span id="example-requests-GETapi-am-incidents">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-incidents?per_page=20&amp;status=2&amp;employee_id=5&amp;crm_id=1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-incidents"
);

const params = {
    "per_page": "20",
    "status": "2",
    "employee_id": "5",
    "crm_id": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-incidents">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;date&quot;: &quot;2026-02-20&quot;,
            &quot;status&quot;: 2,
            &quot;status_label&quot;: &quot;Ran Away&quot;,
            &quot;note&quot;: &quot;Incident note&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-incidents" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-incidents"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-incidents"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-incidents" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-incidents">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-incidents" data-method="GET"
      data-path="api/am-incidents"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-incidents', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-incidents"
                    onclick="tryItOut('GETapi-am-incidents');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-incidents"
                    onclick="cancelTryOut('GETapi-am-incidents');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-incidents"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-incidents</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-incidents"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-incidents"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-incidents"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Default: 15. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="GETapi-am-incidents"
               value="2"
               data-component="query">
    <br>
<p>Filter by status (2 = Ran Away, 3 = Cancelled, 4 = Hold). Example: <code>2</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="GETapi-am-incidents"
               value="5"
               data-component="query">
    <br>
<p>Filter by employee ID. Example: <code>5</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>crm_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="crm_id"                data-endpoint="GETapi-am-incidents"
               value="1"
               data-component="query">
    <br>
<p>Filter by customer ID. Example: <code>1</code></p>
            </div>
                </form>

                    <h2 id="package-3-modular-POSTapi-am-incidents">Store a new incident.</h2>

<p>
</p>



<span id="example-requests-POSTapi-am-incidents">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/am-incidents" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"date\": \"2026-03-12T17:54:57\",
    \"am_movment_id\": \"architecto\",
    \"note\": \"architecto\",
    \"status\": 2,
    \"action\": 2
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-incidents"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "date": "2026-03-12T17:54:57",
    "am_movment_id": "architecto",
    "note": "architecto",
    "status": 2,
    "action": 2
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-am-incidents">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Incident created successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-am-incidents" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-am-incidents"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-am-incidents"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-am-incidents" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-am-incidents">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-am-incidents" data-method="POST"
      data-path="api/am-incidents"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-am-incidents', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-am-incidents"
                    onclick="tryItOut('POSTapi-am-incidents');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-am-incidents"
                    onclick="cancelTryOut('POSTapi-am-incidents');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-am-incidents"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/am-incidents</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-am-incidents"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-am-incidents"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date"                data-endpoint="POSTapi-am-incidents"
               value="2026-03-12T17:54:57"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-03-12T17:54:57</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>am_movment_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="am_movment_id"                data-endpoint="POSTapi-am-incidents"
               value="architecto"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the am_contract_movments table. Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-am-incidents"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="POSTapi-am-incidents"
               value="2"
               data-component="body">
    <br>
<p>Example: <code>2</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>2</code></li> <li><code>3</code></li> <li><code>4</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>action</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="action"                data-endpoint="POSTapi-am-incidents"
               value="2"
               data-component="body">
    <br>
<p>Example: <code>2</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>2</code></li> <li><code>3</code></li> <li><code>4</code></li></ul>
        </div>
        </form>

                    <h2 id="package-3-modular-PUTapi-am-incidents--id-">Update an incident.</h2>

<p>
</p>



<span id="example-requests-PUTapi-am-incidents--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/am-incidents/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"date\": \"2026-03-12T17:54:57\",
    \"note\": \"architecto\",
    \"status\": 3,
    \"action\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-incidents/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "date": "2026-03-12T17:54:57",
    "note": "architecto",
    "status": 3,
    "action": 1
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-am-incidents--id-">
</span>
<span id="execution-results-PUTapi-am-incidents--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-am-incidents--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-am-incidents--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-am-incidents--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-am-incidents--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-am-incidents--id-" data-method="PUT"
      data-path="api/am-incidents/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-am-incidents--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-am-incidents--id-"
                    onclick="tryItOut('PUTapi-am-incidents--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-am-incidents--id-"
                    onclick="cancelTryOut('PUTapi-am-incidents--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-am-incidents--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/am-incidents/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/am-incidents/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-am-incidents--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-am-incidents--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PUTapi-am-incidents--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the am incident. Example: <code>architecto</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date"                data-endpoint="PUTapi-am-incidents--id-"
               value="2026-03-12T17:54:57"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-03-12T17:54:57</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-am-incidents--id-"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="PUTapi-am-incidents--id-"
               value="3"
               data-component="body">
    <br>
<p>Example: <code>3</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>2</code></li> <li><code>3</code></li> <li><code>4</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>action</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="action"                data-endpoint="PUTapi-am-incidents--id-"
               value="1"
               data-component="body">
    <br>
<p>Example: <code>1</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>2</code></li> <li><code>3</code></li> <li><code>4</code></li></ul>
        </div>
        </form>

                    <h2 id="package-3-modular-DELETEapi-am-incidents--id-">Delete an incident.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-am-incidents--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/am-incidents/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-incidents/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-am-incidents--id-">
</span>
<span id="execution-results-DELETEapi-am-incidents--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-am-incidents--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-am-incidents--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-am-incidents--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-am-incidents--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-am-incidents--id-" data-method="DELETE"
      data-path="api/am-incidents/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-am-incidents--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-am-incidents--id-"
                    onclick="tryItOut('DELETEapi-am-incidents--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-am-incidents--id-"
                    onclick="cancelTryOut('DELETEapi-am-incidents--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-am-incidents--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/am-incidents/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-am-incidents--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-am-incidents--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="DELETEapi-am-incidents--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the am incident. Example: <code>architecto</code></p>
            </div>
                    </form>

                                <h2 id="package-3-modular-refund-action-notify-apis-for-managing-refund-action-notify-records">Refund Action Notify

APIs for managing refund action notify records.</h2>
                                                    <h2 id="package-3-modular-POSTapi-amp3-action-notifies">Raise a refund action notify.</h2>

<p>
</p>



<span id="example-requests-POSTapi-amp3-action-notifies">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/amp3-action-notifies" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"am_contract_movement_id\": 4,
    \"amount\": 1200,
    \"note\": \"Customer requested refund\",
    \"refund_date\": \"2026-02-21\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/amp3-action-notifies"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "am_contract_movement_id": 4,
    "amount": 1200,
    "note": "Customer requested refund",
    "refund_date": "2026-02-21"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-amp3-action-notifies">
</span>
<span id="execution-results-POSTapi-amp3-action-notifies" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-amp3-action-notifies"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-amp3-action-notifies"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-amp3-action-notifies" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-amp3-action-notifies">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-amp3-action-notifies" data-method="POST"
      data-path="api/amp3-action-notifies"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-amp3-action-notifies', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-amp3-action-notifies"
                    onclick="tryItOut('POSTapi-amp3-action-notifies');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-amp3-action-notifies"
                    onclick="cancelTryOut('POSTapi-amp3-action-notifies');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-amp3-action-notifies"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/amp3-action-notifies</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-amp3-action-notifies"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-amp3-action-notifies"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>am_contract_movement_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="am_contract_movement_id"                data-endpoint="POSTapi-amp3-action-notifies"
               value="4"
               data-component="body">
    <br>
<p>Contract movement ID. Example: <code>4</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="POSTapi-amp3-action-notifies"
               value="1200"
               data-component="body">
    <br>
<p>Refund amount. Example: <code>1200</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-amp3-action-notifies"
               value="Customer requested refund"
               data-component="body">
    <br>
<p>Refund note. Example: <code>Customer requested refund</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>refund_date</code></b>&nbsp;&nbsp;
<small>date</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="refund_date"                data-endpoint="POSTapi-amp3-action-notifies"
               value="2026-02-21"
               data-component="body">
    <br>
<p>Refund date. Example: <code>2026-02-21</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-PUTapi-amp3-action-notifies--id-">Update an action notify.</h2>

<p>
</p>



<span id="example-requests-PUTapi-amp3-action-notifies--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/amp3-action-notifies/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"am_contract_movement_id\": 4,
    \"amount\": 1200,
    \"note\": \"Updated refund note\",
    \"refund_date\": \"2026-02-22\",
    \"status\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/amp3-action-notifies/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "am_contract_movement_id": 4,
    "amount": 1200,
    "note": "Updated refund note",
    "refund_date": "2026-02-22",
    "status": 1
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-amp3-action-notifies--id-">
</span>
<span id="execution-results-PUTapi-amp3-action-notifies--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-amp3-action-notifies--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-amp3-action-notifies--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-amp3-action-notifies--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-amp3-action-notifies--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-amp3-action-notifies--id-" data-method="PUT"
      data-path="api/amp3-action-notifies/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-amp3-action-notifies--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-amp3-action-notifies--id-"
                    onclick="tryItOut('PUTapi-amp3-action-notifies--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-amp3-action-notifies--id-"
                    onclick="cancelTryOut('PUTapi-amp3-action-notifies--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-amp3-action-notifies--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/amp3-action-notifies/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/amp3-action-notifies/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-amp3-action-notifies--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-amp3-action-notifies--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-amp3-action-notifies--id-"
               value="1"
               data-component="url">
    <br>
<p>Action notify ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>am_contract_movement_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="am_contract_movement_id"                data-endpoint="PUTapi-amp3-action-notifies--id-"
               value="4"
               data-component="body">
    <br>
<p>Contract movement ID. Example: <code>4</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="PUTapi-amp3-action-notifies--id-"
               value="1200"
               data-component="body">
    <br>
<p>Refund amount. Example: <code>1200</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-amp3-action-notifies--id-"
               value="Updated refund note"
               data-component="body">
    <br>
<p>Refund note. Example: <code>Updated refund note</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>refund_date</code></b>&nbsp;&nbsp;
<small>date</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="refund_date"                data-endpoint="PUTapi-amp3-action-notifies--id-"
               value="2026-02-22"
               data-component="body">
    <br>
<p>Refund date. Example: <code>2026-02-22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="PUTapi-amp3-action-notifies--id-"
               value="1"
               data-component="body">
    <br>
<p>Status (0 = pending, 1 = approved, 2 = rejected). Example: <code>1</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-DELETEapi-amp3-action-notifies--id-">Delete an action notify.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-amp3-action-notifies--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/amp3-action-notifies/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/amp3-action-notifies/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-amp3-action-notifies--id-">
</span>
<span id="execution-results-DELETEapi-amp3-action-notifies--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-amp3-action-notifies--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-amp3-action-notifies--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-amp3-action-notifies--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-amp3-action-notifies--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-amp3-action-notifies--id-" data-method="DELETE"
      data-path="api/amp3-action-notifies/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-amp3-action-notifies--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-amp3-action-notifies--id-"
                    onclick="tryItOut('DELETEapi-amp3-action-notifies--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-amp3-action-notifies--id-"
                    onclick="cancelTryOut('DELETEapi-amp3-action-notifies--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-amp3-action-notifies--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/amp3-action-notifies/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-amp3-action-notifies--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-amp3-action-notifies--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-amp3-action-notifies--id-"
               value="1"
               data-component="url">
    <br>
<p>Action notify ID. Example: <code>1</code></p>
            </div>
                    </form>

                                <h2 id="package-3-modular-deduction-payroll-apis-for-managing-employee-payroll-deductions-and-allowances">Deduction Payroll

APIs for managing employee payroll deductions and allowances.</h2>
                                                    <h2 id="package-3-modular-POSTapi-deduction-payrolls">Store deduction payroll record(s).</h2>

<p>
</p>

<p>Supports single-row create and bulk create in one endpoint.</p>
<p>Single row payload fields:</p>

<span id="example-requests-POSTapi-deduction-payrolls">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/deduction-payrolls" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"rows\": [
        \"architecto\"
    ],
    \"deduction_date\": \"2026-02-22\",
    \"employee_id\": 10,
    \"payroll_year\": 2026,
    \"payroll_month\": 2,
    \"amount_deduction\": 150,
    \"amount_allowance\": 50,
    \"note\": \"Late penalty\\n\\nBulk payload fields:\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/deduction-payrolls"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "rows": [
        "architecto"
    ],
    "deduction_date": "2026-02-22",
    "employee_id": 10,
    "payroll_year": 2026,
    "payroll_month": 2,
    "amount_deduction": 150,
    "amount_allowance": 50,
    "note": "Late penalty\n\nBulk payload fields:"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-deduction-payrolls">
</span>
<span id="execution-results-POSTapi-deduction-payrolls" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-deduction-payrolls"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-deduction-payrolls"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-deduction-payrolls" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-deduction-payrolls">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-deduction-payrolls" data-method="POST"
      data-path="api/deduction-payrolls"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-deduction-payrolls', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-deduction-payrolls"
                    onclick="tryItOut('POSTapi-deduction-payrolls');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-deduction-payrolls"
                    onclick="cancelTryOut('POSTapi-deduction-payrolls');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-deduction-payrolls"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/deduction-payrolls</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-deduction-payrolls"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-deduction-payrolls"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>rows</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Optional array for bulk create.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>deduction_date</code></b>&nbsp;&nbsp;
<small>date</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="rows.0.deduction_date"                data-endpoint="POSTapi-deduction-payrolls"
               value="2026-02-22"
               data-component="body">
    <br>
<p>Optional deduction date. Example: <code>2026-02-22</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.0.employee_id"                data-endpoint="POSTapi-deduction-payrolls"
               value="10"
               data-component="body">
    <br>
<p>required_with:rows Employee ID. Example: <code>10</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>payroll_year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.0.payroll_year"                data-endpoint="POSTapi-deduction-payrolls"
               value="2026"
               data-component="body">
    <br>
<p>required_with:rows Payroll year. Example: <code>2026</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>payroll_month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.0.payroll_month"                data-endpoint="POSTapi-deduction-payrolls"
               value="2"
               data-component="body">
    <br>
<p>required_with:rows Payroll month (1-12). Example: <code>2</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>amount_deduction</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.0.amount_deduction"                data-endpoint="POSTapi-deduction-payrolls"
               value="150"
               data-component="body">
    <br>
<p>Optional deduction amount. Example: <code>150</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>amount_allowance</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.0.amount_allowance"                data-endpoint="POSTapi-deduction-payrolls"
               value="50"
               data-component="body">
    <br>
<p>Optional allowance amount. Example: <code>50</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="rows.0.note"                data-endpoint="POSTapi-deduction-payrolls"
               value="Bonus adjustment"
               data-component="body">
    <br>
<p>Optional note. Example: <code>Bonus adjustment</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>deduction_date</code></b>&nbsp;&nbsp;
<small>date</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="deduction_date"                data-endpoint="POSTapi-deduction-payrolls"
               value="2026-02-22"
               data-component="body">
    <br>
<p>Optional deduction date. Example: <code>2026-02-22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="POSTapi-deduction-payrolls"
               value="10"
               data-component="body">
    <br>
<p>Employee ID. Example: <code>10</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payroll_year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="payroll_year"                data-endpoint="POSTapi-deduction-payrolls"
               value="2026"
               data-component="body">
    <br>
<p>Payroll year. Example: <code>2026</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payroll_month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="payroll_month"                data-endpoint="POSTapi-deduction-payrolls"
               value="2"
               data-component="body">
    <br>
<p>Payroll month (1-12). Example: <code>2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount_deduction</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount_deduction"                data-endpoint="POSTapi-deduction-payrolls"
               value="150"
               data-component="body">
    <br>
<p>Optional deduction amount. Example: <code>150</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount_allowance</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount_allowance"                data-endpoint="POSTapi-deduction-payrolls"
               value="50"
               data-component="body">
    <br>
<p>Optional allowance amount. Example: <code>50</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-deduction-payrolls"
               value="Late penalty

Bulk payload fields:"
               data-component="body">
    <br>
<p>Optional note. Example: `Late penalty</p>
<p>Bulk payload fields:`</p>
        </div>
        </form>

                    <h2 id="package-3-modular-PUTapi-deduction-payrolls--id-">Update deduction payroll record.</h2>

<p>
</p>



<span id="example-requests-PUTapi-deduction-payrolls--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/deduction-payrolls/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"deduction_date\": \"2026-02-22\",
    \"employee_id\": 10,
    \"payroll_year\": 2026,
    \"payroll_month\": 2,
    \"amount_deduction\": 150,
    \"amount_allowance\": 50,
    \"note\": \"Updated note\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/deduction-payrolls/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "deduction_date": "2026-02-22",
    "employee_id": 10,
    "payroll_year": 2026,
    "payroll_month": 2,
    "amount_deduction": 150,
    "amount_allowance": 50,
    "note": "Updated note"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-deduction-payrolls--id-">
</span>
<span id="execution-results-PUTapi-deduction-payrolls--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-deduction-payrolls--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-deduction-payrolls--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-deduction-payrolls--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-deduction-payrolls--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-deduction-payrolls--id-" data-method="PUT"
      data-path="api/deduction-payrolls/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-deduction-payrolls--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-deduction-payrolls--id-"
                    onclick="tryItOut('PUTapi-deduction-payrolls--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-deduction-payrolls--id-"
                    onclick="cancelTryOut('PUTapi-deduction-payrolls--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-deduction-payrolls--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/deduction-payrolls/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/deduction-payrolls/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-deduction-payrolls--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-deduction-payrolls--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-deduction-payrolls--id-"
               value="1"
               data-component="url">
    <br>
<p>Deduction payroll ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>deduction_date</code></b>&nbsp;&nbsp;
<small>date</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="deduction_date"                data-endpoint="PUTapi-deduction-payrolls--id-"
               value="2026-02-22"
               data-component="body">
    <br>
<p>Deduction date. Example: <code>2026-02-22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="PUTapi-deduction-payrolls--id-"
               value="10"
               data-component="body">
    <br>
<p>Employee ID. Example: <code>10</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payroll_year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="payroll_year"                data-endpoint="PUTapi-deduction-payrolls--id-"
               value="2026"
               data-component="body">
    <br>
<p>Payroll year. Example: <code>2026</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payroll_month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="payroll_month"                data-endpoint="PUTapi-deduction-payrolls--id-"
               value="2"
               data-component="body">
    <br>
<p>Payroll month (1-12). Example: <code>2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount_deduction</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount_deduction"                data-endpoint="PUTapi-deduction-payrolls--id-"
               value="150"
               data-component="body">
    <br>
<p>Deduction amount. Example: <code>150</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount_allowance</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount_allowance"                data-endpoint="PUTapi-deduction-payrolls--id-"
               value="50"
               data-component="body">
    <br>
<p>Allowance amount. Example: <code>50</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-deduction-payrolls--id-"
               value="Updated note"
               data-component="body">
    <br>
<p>Optional note. Example: <code>Updated note</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-DELETEapi-deduction-payrolls--id-">Delete deduction payroll record.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-deduction-payrolls--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/deduction-payrolls/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/deduction-payrolls/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-deduction-payrolls--id-">
</span>
<span id="execution-results-DELETEapi-deduction-payrolls--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-deduction-payrolls--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-deduction-payrolls--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-deduction-payrolls--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-deduction-payrolls--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-deduction-payrolls--id-" data-method="DELETE"
      data-path="api/deduction-payrolls/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-deduction-payrolls--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-deduction-payrolls--id-"
                    onclick="tryItOut('DELETEapi-deduction-payrolls--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-deduction-payrolls--id-"
                    onclick="cancelTryOut('DELETEapi-deduction-payrolls--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-deduction-payrolls--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/deduction-payrolls/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-deduction-payrolls--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-deduction-payrolls--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-deduction-payrolls--id-"
               value="1"
               data-component="url">
    <br>
<p>Deduction payroll ID. Example: <code>1</code></p>
            </div>
                    </form>

                                <h2 id="package-3-modular-maid-payroll-history-apis-for-managing-maid-payroll-history-records">Maid Payroll History

APIs for managing maid payroll history records.</h2>
                                                    <h2 id="package-3-modular-GETapi-am-maid-payroll-histories-export-excel">Export payroll histories to Excel.</h2>

<p>
</p>



<span id="example-requests-GETapi-am-maid-payroll-histories-export-excel">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories/export/excel?year=2026&amp;month=2" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"year\": 1,
    \"month\": 4
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories/export/excel"
);

const params = {
    "year": "2026",
    "month": "2",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "year": 1,
    "month": 4
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-maid-payroll-histories-export-excel">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Excel file download started&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-maid-payroll-histories-export-excel" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-maid-payroll-histories-export-excel"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-maid-payroll-histories-export-excel"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-maid-payroll-histories-export-excel" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-maid-payroll-histories-export-excel">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-maid-payroll-histories-export-excel" data-method="GET"
      data-path="api/am-maid-payroll-histories/export/excel"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-maid-payroll-histories-export-excel', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-maid-payroll-histories-export-excel"
                    onclick="tryItOut('GETapi-am-maid-payroll-histories-export-excel');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-maid-payroll-histories-export-excel"
                    onclick="cancelTryOut('GETapi-am-maid-payroll-histories-export-excel');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-maid-payroll-histories-export-excel"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-maid-payroll-histories/export/excel</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-maid-payroll-histories-export-excel"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-maid-payroll-histories-export-excel"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="GETapi-am-maid-payroll-histories-export-excel"
               value="2026"
               data-component="query">
    <br>
<p>Payroll year. Example: <code>2026</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="month"                data-endpoint="GETapi-am-maid-payroll-histories-export-excel"
               value="2"
               data-component="query">
    <br>
<p>Payroll month (1-12). Example: <code>2</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="GETapi-am-maid-payroll-histories-export-excel"
               value="1"
               data-component="body">
    <br>
<p>Must be at least 2020. Must not be greater than 2099. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="month"                data-endpoint="GETapi-am-maid-payroll-histories-export-excel"
               value="4"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 12. Example: <code>4</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-GETapi-am-maid-payroll-histories">List payroll histories.</h2>

<p>
</p>



<span id="example-requests-GETapi-am-maid-payroll-histories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories?per_page=15&amp;employee_id=10&amp;year=2026&amp;month=2&amp;status=paid&amp;payment_method=cash&amp;search=bonus&amp;sort_by=created_at&amp;sort_direction=desc" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories"
);

const params = {
    "per_page": "15",
    "employee_id": "10",
    "year": "2026",
    "month": "2",
    "status": "paid",
    "payment_method": "cash",
    "search": "bonus",
    "sort_by": "created_at",
    "sort_direction": "desc",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-maid-payroll-histories">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;employee_id&quot;: 10,
            &quot;year&quot;: 2026,
            &quot;month&quot;: 2,
            &quot;payment_method&quot;: &quot;bank&quot;,
            &quot;basic_salary&quot;: &quot;1500.00&quot;,
            &quot;deduction&quot;: &quot;200.00&quot;,
            &quot;allowance&quot;: &quot;100.00&quot;,
            &quot;net&quot;: &quot;1400.00&quot;,
            &quot;note&quot;: &quot;February payroll&quot;,
            &quot;status&quot;: &quot;paid&quot;,
            &quot;created_at&quot;: &quot;2026-02-28T10:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-02-28T10:00:00.000000Z&quot;
        }
    ],
    &quot;last_page&quot;: 1,
    &quot;per_page&quot;: 15,
    &quot;total&quot;: 1
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-maid-payroll-histories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-maid-payroll-histories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-maid-payroll-histories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-maid-payroll-histories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-maid-payroll-histories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-maid-payroll-histories" data-method="GET"
      data-path="api/am-maid-payroll-histories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-maid-payroll-histories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-maid-payroll-histories"
                    onclick="tryItOut('GETapi-am-maid-payroll-histories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-maid-payroll-histories"
                    onclick="cancelTryOut('GETapi-am-maid-payroll-histories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-maid-payroll-histories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-maid-payroll-histories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="15"
               data-component="query">
    <br>
<p>Number of items per page. Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="10"
               data-component="query">
    <br>
<p>Filter by employee ID. Example: <code>10</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="2026"
               data-component="query">
    <br>
<p>Filter by payroll year. Example: <code>2026</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="month"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="2"
               data-component="query">
    <br>
<p>Filter by payroll month (1-12). Example: <code>2</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="paid"
               data-component="query">
    <br>
<p>Filter by status. Example: <code>paid</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>payment_method</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="payment_method"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="cash"
               data-component="query">
    <br>
<p>Filter by payment method. Example: <code>cash</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="bonus"
               data-component="query">
    <br>
<p>Search in note field. Example: <code>bonus</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="created_at"
               data-component="query">
    <br>
<p>Sort field. Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-am-maid-payroll-histories"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction (<code>asc</code> or <code>desc</code>). Example: <code>desc</code></p>
            </div>
                </form>

                    <h2 id="package-3-modular-POSTapi-am-maid-payroll-histories">Store payroll history record(s).</h2>

<p>
</p>

<p>Creates payroll history rows in bulk with per-employee values.</p>

<span id="example-requests-POSTapi-am-maid-payroll-histories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"year\": 2026,
    \"month\": 2,
    \"note\": \"February payroll\",
    \"rows\": [
        {
            \"employee_id\": 10,
            \"payment_method\": \"bank\",
            \"basic_salary\": 1500,
            \"deduction\": 200,
            \"allowance\": 100,
            \"net\": 1400,
            \"paid_at\": \"2026-02-28 10:00:00\",
            \"status\": \"paid\"
        },
        {
            \"employee_id\": 11,
            \"payment_method\": \"cash\",
            \"basic_salary\": 1800,
            \"deduction\": 50,
            \"allowance\": 0,
            \"net\": 1750,
            \"paid_at\": \"2026-02-28 10:00:00\",
            \"status\": \"paid\"
        }
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "year": 2026,
    "month": 2,
    "note": "February payroll",
    "rows": [
        {
            "employee_id": 10,
            "payment_method": "bank",
            "basic_salary": 1500,
            "deduction": 200,
            "allowance": 100,
            "net": 1400,
            "paid_at": "2026-02-28 10:00:00",
            "status": "paid"
        },
        {
            "employee_id": 11,
            "payment_method": "cash",
            "basic_salary": 1800,
            "deduction": 50,
            "allowance": 0,
            "net": 1750,
            "paid_at": "2026-02-28 10:00:00",
            "status": "paid"
        }
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-am-maid-payroll-histories">
</span>
<span id="execution-results-POSTapi-am-maid-payroll-histories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-am-maid-payroll-histories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-am-maid-payroll-histories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-am-maid-payroll-histories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-am-maid-payroll-histories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-am-maid-payroll-histories" data-method="POST"
      data-path="api/am-maid-payroll-histories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-am-maid-payroll-histories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-am-maid-payroll-histories"
                    onclick="tryItOut('POSTapi-am-maid-payroll-histories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-am-maid-payroll-histories"
                    onclick="cancelTryOut('POSTapi-am-maid-payroll-histories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-am-maid-payroll-histories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/am-maid-payroll-histories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="2026"
               data-component="body">
    <br>
<p>Payroll year for all rows. Example: <code>2026</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="month"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="2"
               data-component="body">
    <br>
<p>Payroll month (1-12) for all rows. Example: <code>2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="February payroll"
               data-component="body">
    <br>
<p>Optional note applied to all rows. Example: <code>February payroll</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>rows</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
 &nbsp;
<br>
<p>Payroll rows.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.0.employee_id"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="10"
               data-component="body">
    <br>
<p>Employee ID. The <code>id</code> of an existing record in the employees table. Example: <code>10</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>payment_method</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="rows.0.payment_method"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="bank"
               data-component="body">
    <br>
<p>Optional payment method. Must not be greater than 20 characters. Example: <code>bank</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>basic_salary</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.0.basic_salary"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="1500"
               data-component="body">
    <br>
<p>Optional basic salary. Must be at least 0. Example: <code>1500</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>deduction</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.0.deduction"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="200"
               data-component="body">
    <br>
<p>Optional deduction amount. Must be at least 0. Example: <code>200</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>allowance</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.0.allowance"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="100"
               data-component="body">
    <br>
<p>Optional allowance amount. Must be at least 0. Example: <code>100</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>net</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.0.net"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="1400"
               data-component="body">
    <br>
<p>Optional net amount. Must be at least 0. Example: <code>1400</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>paid_at</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="rows.0.paid_at"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="2026-02-28 10:00:00"
               data-component="body">
    <br>
<p>Optional paid datetime. Must be a valid date. Example: <code>2026-02-28 10:00:00</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="rows.0.status"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="paid"
               data-component="body">
    <br>
<p>Optional status. Must not be greater than 20 characters. Example: <code>paid</code></p>
                    </div>
                                                                <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>*</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.*.employee_id"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="10"
               data-component="body">
    <br>
<p>Employee ID. Example: <code>10</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>payment_method</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="rows.*.payment_method"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="bank"
               data-component="body">
    <br>
<p>Optional payment method. Example: <code>bank</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>basic_salary</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.*.basic_salary"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="1500"
               data-component="body">
    <br>
<p>Optional basic salary. Example: <code>1500</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>deduction</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.*.deduction"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="200"
               data-component="body">
    <br>
<p>Optional deduction amount. Example: <code>200</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>allowance</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.*.allowance"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="100"
               data-component="body">
    <br>
<p>Optional allowance amount. Example: <code>100</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>net</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="rows.*.net"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="1400"
               data-component="body">
    <br>
<p>Optional net amount. Example: <code>1400</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>paid_at</code></b>&nbsp;&nbsp;
<small>date</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="rows.*.paid_at"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="2026-02-28 10:00:00"
               data-component="body">
    <br>
<p>Optional paid date/time. Example: <code>2026-02-28 10:00:00</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="rows.*.status"                data-endpoint="POSTapi-am-maid-payroll-histories"
               value="paid"
               data-component="body">
    <br>
<p>Optional status. Example: <code>paid</code></p>
                    </div>
                                    </details>
        </div>
                                        </details>
        </div>
        </form>

                    <h2 id="package-3-modular-GETapi-am-maid-payroll-histories--id-">Show payroll history record.</h2>

<p>
</p>



<span id="example-requests-GETapi-am-maid-payroll-histories--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-maid-payroll-histories--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;employee_id&quot;: 10,
    &quot;year&quot;: 2026,
    &quot;month&quot;: 2,
    &quot;payment_method&quot;: &quot;bank&quot;,
    &quot;basic_salary&quot;: &quot;1500.00&quot;,
    &quot;deduction&quot;: &quot;200.00&quot;,
    &quot;allowance&quot;: &quot;100.00&quot;,
    &quot;net&quot;: &quot;1400.00&quot;,
    &quot;note&quot;: &quot;February payroll&quot;,
    &quot;status&quot;: &quot;paid&quot;,
    &quot;created_at&quot;: &quot;2026-02-28T10:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2026-02-28T10:00:00.000000Z&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Payroll history not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-maid-payroll-histories--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-maid-payroll-histories--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-maid-payroll-histories--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-maid-payroll-histories--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-maid-payroll-histories--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-maid-payroll-histories--id-" data-method="GET"
      data-path="api/am-maid-payroll-histories/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-maid-payroll-histories--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-maid-payroll-histories--id-"
                    onclick="tryItOut('GETapi-am-maid-payroll-histories--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-maid-payroll-histories--id-"
                    onclick="cancelTryOut('GETapi-am-maid-payroll-histories--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-maid-payroll-histories--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-maid-payroll-histories/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-maid-payroll-histories--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-maid-payroll-histories--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-am-maid-payroll-histories--id-"
               value="1"
               data-component="url">
    <br>
<p>Payroll history ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="package-3-modular-PUTapi-am-maid-payroll-histories--id-">Update payroll history record.</h2>

<p>
</p>



<span id="example-requests-PUTapi-am-maid-payroll-histories--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"employee_id\": 10,
    \"year\": 2026,
    \"month\": 2,
    \"payment_method\": \"bank\",
    \"basic_salary\": 1500,
    \"deduction\": 200,
    \"allowance\": 100,
    \"net\": 1400,
    \"note\": \"Updated note\",
    \"paid_at\": \"2026-02-28 10:00:00\",
    \"status\": \"paid\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "employee_id": 10,
    "year": 2026,
    "month": 2,
    "payment_method": "bank",
    "basic_salary": 1500,
    "deduction": 200,
    "allowance": 100,
    "net": 1400,
    "note": "Updated note",
    "paid_at": "2026-02-28 10:00:00",
    "status": "paid"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-am-maid-payroll-histories--id-">
</span>
<span id="execution-results-PUTapi-am-maid-payroll-histories--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-am-maid-payroll-histories--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-am-maid-payroll-histories--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-am-maid-payroll-histories--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-am-maid-payroll-histories--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-am-maid-payroll-histories--id-" data-method="PUT"
      data-path="api/am-maid-payroll-histories/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-am-maid-payroll-histories--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-am-maid-payroll-histories--id-"
                    onclick="tryItOut('PUTapi-am-maid-payroll-histories--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-am-maid-payroll-histories--id-"
                    onclick="cancelTryOut('PUTapi-am-maid-payroll-histories--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-am-maid-payroll-histories--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/am-maid-payroll-histories/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/am-maid-payroll-histories/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="1"
               data-component="url">
    <br>
<p>Payroll history ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="10"
               data-component="body">
    <br>
<p>Employee ID. Example: <code>10</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="2026"
               data-component="body">
    <br>
<p>Payroll year. Example: <code>2026</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="month"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="2"
               data-component="body">
    <br>
<p>Payroll month (1-12). Example: <code>2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_method</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="payment_method"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="bank"
               data-component="body">
    <br>
<p>Payment method. Example: <code>bank</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>basic_salary</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="basic_salary"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="1500"
               data-component="body">
    <br>
<p>Basic salary. Example: <code>1500</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>deduction</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="deduction"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="200"
               data-component="body">
    <br>
<p>Deduction amount. Example: <code>200</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>allowance</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="allowance"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="100"
               data-component="body">
    <br>
<p>Allowance amount. Example: <code>100</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>net</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="net"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="1400"
               data-component="body">
    <br>
<p>Net amount. Example: <code>1400</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="Updated note"
               data-component="body">
    <br>
<p>Optional note. Example: <code>Updated note</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>paid_at</code></b>&nbsp;&nbsp;
<small>date</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="paid_at"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="2026-02-28 10:00:00"
               data-component="body">
    <br>
<p>Optional paid date/time. Example: <code>2026-02-28 10:00:00</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="PUTapi-am-maid-payroll-histories--id-"
               value="paid"
               data-component="body">
    <br>
<p>Status. Example: <code>paid</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-DELETEapi-am-maid-payroll-histories--id-">Delete payroll history record.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-am-maid-payroll-histories--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll-histories/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-am-maid-payroll-histories--id-">
</span>
<span id="execution-results-DELETEapi-am-maid-payroll-histories--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-am-maid-payroll-histories--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-am-maid-payroll-histories--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-am-maid-payroll-histories--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-am-maid-payroll-histories--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-am-maid-payroll-histories--id-" data-method="DELETE"
      data-path="api/am-maid-payroll-histories/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-am-maid-payroll-histories--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-am-maid-payroll-histories--id-"
                    onclick="tryItOut('DELETEapi-am-maid-payroll-histories--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-am-maid-payroll-histories--id-"
                    onclick="cancelTryOut('DELETEapi-am-maid-payroll-histories--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-am-maid-payroll-histories--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/am-maid-payroll-histories/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-am-maid-payroll-histories--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-am-maid-payroll-histories--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-am-maid-payroll-histories--id-"
               value="1"
               data-component="url">
    <br>
<p>Payroll history ID. Example: <code>1</code></p>
            </div>
                    </form>

                                <h2 id="package-3-modular-contract-movements-apis-for-managing-contract-movements">Contract Movements

APIs for managing contract movements.</h2>
                                                    <h2 id="package-3-modular-GETapi-am-contract-movements">List contract movements.</h2>

<p>
</p>

<p>Returns a paginated list of contract movements with optional filters.
Each movement includes the related contract, customer, employee, installments, and return info.</p>

<span id="example-requests-GETapi-am-contract-movements">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-contract-movements?per_page=20&amp;sort_by=status&amp;sort_direction=asc&amp;contract_id=1&amp;employee_id=5&amp;employee_name=Maria&amp;customer_name=Ahmed&amp;crm_id=1&amp;status=1&amp;date_from=2026-01-01&amp;date_to=2026-12-31&amp;search=contract" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-contract-movements"
);

const params = {
    "per_page": "20",
    "sort_by": "status",
    "sort_direction": "asc",
    "contract_id": "1",
    "employee_id": "5",
    "employee_name": "Maria",
    "customer_name": "Ahmed",
    "crm_id": "1",
    "status": "1",
    "date_from": "2026-01-01",
    "date_to": "2026-12-31",
    "search": "contract",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-contract-movements">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 3,
            &quot;date&quot;: &quot;2026-03-01&quot;,
            &quot;am_contract_id&quot;: 1,
            &quot;employee_id&quot;: 5,
            &quot;status&quot;: 1,
            &quot;primary_contract&quot;: {
                &quot;crm&quot;: {}
            },
            &quot;employee&quot;: {},
            &quot;installments&quot;: [],
            &quot;return_info&quot;: null
        }
    ],
    &quot;last_page&quot;: 1,
    &quot;per_page&quot;: 15,
    &quot;total&quot;: 1
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-contract-movements" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-contract-movements"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-contract-movements"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-contract-movements" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-contract-movements">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-contract-movements" data-method="GET"
      data-path="api/am-contract-movements"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-contract-movements', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-contract-movements"
                    onclick="tryItOut('GETapi-am-contract-movements');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-contract-movements"
                    onclick="cancelTryOut('GETapi-am-contract-movements');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-contract-movements"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-contract-movements</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-contract-movements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-contract-movements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-contract-movements"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Default: 15. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-am-contract-movements"
               value="status"
               data-component="query">
    <br>
<p>Sort field (id, date, status, created_at). Default: date. Example: <code>status</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-am-contract-movements"
               value="asc"
               data-component="query">
    <br>
<p>Sort direction (asc, desc). Default: desc. Example: <code>asc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>contract_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="contract_id"                data-endpoint="GETapi-am-contract-movements"
               value="1"
               data-component="query">
    <br>
<p>Filter by primary contract ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="GETapi-am-contract-movements"
               value="5"
               data-component="query">
    <br>
<p>Filter by employee/maid ID. Example: <code>5</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="employee_name"                data-endpoint="GETapi-am-contract-movements"
               value="Maria"
               data-component="query">
    <br>
<p>Filter by employee/maid name. Example: <code>Maria</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customer_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_name"                data-endpoint="GETapi-am-contract-movements"
               value="Ahmed"
               data-component="query">
    <br>
<p>Filter by customer name (first or last). Example: <code>Ahmed</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>crm_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="crm_id"                data-endpoint="GETapi-am-contract-movements"
               value="1"
               data-component="query">
    <br>
<p>Filter by customer (CRM) ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="GETapi-am-contract-movements"
               value="1"
               data-component="query">
    <br>
<p>Filter by status (0 = inactive, 1 = active). Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date_from"                data-endpoint="GETapi-am-contract-movements"
               value="2026-01-01"
               data-component="query">
    <br>
<p>Filter movements from this date. Example: <code>2026-01-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date_to"                data-endpoint="GETapi-am-contract-movements"
               value="2026-12-31"
               data-component="query">
    <br>
<p>Filter movements until this date. Example: <code>2026-12-31</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-am-contract-movements"
               value="contract"
               data-component="query">
    <br>
<p>Search by note. Example: <code>contract</code></p>
            </div>
                </form>

                    <h2 id="package-3-modular-GETapi-am-contract-movements--id-">Display a specific contract movement.</h2>

<p>
</p>

<p>Returns a single contract movement with its related contract, customer, employee, installments, and return info.</p>

<span id="example-requests-GETapi-am-contract-movements--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-contract-movements/3" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-contract-movements/3"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-contract-movements--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 3,
    &quot;date&quot;: &quot;2026-03-01&quot;,
    &quot;am_contract_id&quot;: 1,
    &quot;employee_id&quot;: 5,
    &quot;status&quot;: 1,
    &quot;primary_contract&quot;: {
        &quot;crm&quot;: {}
    },
    &quot;employee&quot;: {},
    &quot;installments&quot;: [],
    &quot;return_info&quot;: null
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Contract movement not found&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-contract-movements--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-contract-movements--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-contract-movements--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-contract-movements--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-contract-movements--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-contract-movements--id-" data-method="GET"
      data-path="api/am-contract-movements/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-contract-movements--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-contract-movements--id-"
                    onclick="tryItOut('GETapi-am-contract-movements--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-contract-movements--id-"
                    onclick="cancelTryOut('GETapi-am-contract-movements--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-contract-movements--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-contract-movements/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-contract-movements--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-contract-movements--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-am-contract-movements--id-"
               value="3"
               data-component="url">
    <br>
<p>The contract movement ID. Example: <code>3</code></p>
            </div>
                    </form>

                    <h2 id="package-3-modular-PUTapi-am-contract-movements--id-">Update a contract movement.</h2>

<p>
</p>



<span id="example-requests-PUTapi-am-contract-movements--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/am-contract-movements/3" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"date\": \"2026-04-01\",
    \"employee_id\": 5,
    \"note\": \"Updated assignment\",
    \"installments\": [
        \"architecto\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-contract-movements/3"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "date": "2026-04-01",
    "employee_id": 5,
    "note": "Updated assignment",
    "installments": [
        "architecto"
    ]
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-am-contract-movements--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Contract movement updated successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Contract movement not found&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Failed to update contract movement&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-am-contract-movements--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-am-contract-movements--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-am-contract-movements--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-am-contract-movements--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-am-contract-movements--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-am-contract-movements--id-" data-method="PUT"
      data-path="api/am-contract-movements/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-am-contract-movements--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-am-contract-movements--id-"
                    onclick="tryItOut('PUTapi-am-contract-movements--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-am-contract-movements--id-"
                    onclick="cancelTryOut('PUTapi-am-contract-movements--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-am-contract-movements--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/am-contract-movements/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/am-contract-movements/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-am-contract-movements--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-am-contract-movements--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-am-contract-movements--id-"
               value="3"
               data-component="url">
    <br>
<p>The contract movement ID. Example: <code>3</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date"                data-endpoint="PUTapi-am-contract-movements--id-"
               value="2026-04-01"
               data-component="body">
    <br>
<p>The movement date. Example: <code>2026-04-01</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="PUTapi-am-contract-movements--id-"
               value="5"
               data-component="body">
    <br>
<p>The employee/maid ID. Example: <code>5</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-am-contract-movements--id-"
               value="Updated assignment"
               data-component="body">
    <br>
<p>An optional note. Example: <code>Updated assignment</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>installments</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>List of installments to create or update.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="installments.0.id"                data-endpoint="PUTapi-am-contract-movements--id-"
               value="16"
               data-component="body">
    <br>
<p>Optional. The installment ID to update. If omitted, a new installment will be created. Example: <code>16</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="installments.0.amount"                data-endpoint="PUTapi-am-contract-movements--id-"
               value="1500"
               data-component="body">
    <br>
<p>required_without:installments[].id. The installment amount. Example: <code>1500</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="installments.0.date"                data-endpoint="PUTapi-am-contract-movements--id-"
               value="2026-04-01"
               data-component="body">
    <br>
<p>Optional. The installment date. Example: <code>2026-04-01</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="installments.0.note"                data-endpoint="PUTapi-am-contract-movements--id-"
               value="Monthly payment
    *"
               data-component="body">
    <br>
<p>Optional. An optional note for the installment. Example: <code>Monthly payment *</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="package-3-modular-DELETEapi-am-contract-movements--id-">Delete a contract movement.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-am-contract-movements--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/am-contract-movements/3" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-contract-movements/3"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-am-contract-movements--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Contract movement deleted successfully&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Contract movement not found&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Failed to delete contract movement&quot;,
    &quot;error&quot;: &quot;Error message&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-am-contract-movements--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-am-contract-movements--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-am-contract-movements--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-am-contract-movements--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-am-contract-movements--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-am-contract-movements--id-" data-method="DELETE"
      data-path="api/am-contract-movements/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-am-contract-movements--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-am-contract-movements--id-"
                    onclick="tryItOut('DELETEapi-am-contract-movements--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-am-contract-movements--id-"
                    onclick="cancelTryOut('DELETEapi-am-contract-movements--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-am-contract-movements--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/am-contract-movements/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-am-contract-movements--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-am-contract-movements--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-am-contract-movements--id-"
               value="3"
               data-component="url">
    <br>
<p>The contract movement ID. Example: <code>3</code></p>
            </div>
                    </form>

                                <h2 id="package-3-modular-installments-apis-for-managing-contract-installments">Installments

APIs for managing contract installments.</h2>
                                                    <h2 id="package-3-modular-GETapi-am-installments">List installments.</h2>

<p>
</p>

<p>Returns a paginated list of installments with optional filters.</p>

<span id="example-requests-GETapi-am-installments">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-installments?per_page=20&amp;sort_by=amount&amp;sort_direction=asc&amp;am_movment_id=3&amp;contract_id=1&amp;employee_id=5&amp;employee_name=Maria&amp;customer_name=Ahmed&amp;crm_id=1&amp;status=0&amp;date_from=2026-01-01&amp;date_to=2026-12-31&amp;search=salary" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-installments"
);

const params = {
    "per_page": "20",
    "sort_by": "amount",
    "sort_direction": "asc",
    "am_movment_id": "3",
    "contract_id": "1",
    "employee_id": "5",
    "employee_name": "Maria",
    "customer_name": "Ahmed",
    "crm_id": "1",
    "status": "0",
    "date_from": "2026-01-01",
    "date_to": "2026-12-31",
    "search": "salary",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-installments">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;date&quot;: &quot;2026-03-01&quot;,
            &quot;amount&quot;: 1000,
            &quot;status&quot;: 0,
            &quot;note&quot;: &quot;First installment&quot;,
            &quot;contract_movment&quot;: {}
        }
    ],
    &quot;last_page&quot;: 1,
    &quot;per_page&quot;: 15,
    &quot;total&quot;: 1
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-installments" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-installments"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-installments"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-installments" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-installments">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-installments" data-method="GET"
      data-path="api/am-installments"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-installments', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-installments"
                    onclick="tryItOut('GETapi-am-installments');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-installments"
                    onclick="cancelTryOut('GETapi-am-installments');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-installments"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-installments</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-installments"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-installments"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-installments"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Default: 15. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-am-installments"
               value="amount"
               data-component="query">
    <br>
<p>Sort field (id, date, amount, status, created_at). Default: date. Example: <code>amount</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-am-installments"
               value="asc"
               data-component="query">
    <br>
<p>Sort direction (asc, desc). Default: desc. Example: <code>asc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>am_movment_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="am_movment_id"                data-endpoint="GETapi-am-installments"
               value="3"
               data-component="query">
    <br>
<p>Filter by contract movement ID. Example: <code>3</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>contract_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="contract_id"                data-endpoint="GETapi-am-installments"
               value="1"
               data-component="query">
    <br>
<p>Filter by primary contract ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="GETapi-am-installments"
               value="5"
               data-component="query">
    <br>
<p>Filter by employee/maid ID. Example: <code>5</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="employee_name"                data-endpoint="GETapi-am-installments"
               value="Maria"
               data-component="query">
    <br>
<p>Filter by employee/maid name. Example: <code>Maria</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customer_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_name"                data-endpoint="GETapi-am-installments"
               value="Ahmed"
               data-component="query">
    <br>
<p>Filter by customer name (first or last). Example: <code>Ahmed</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>crm_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="crm_id"                data-endpoint="GETapi-am-installments"
               value="1"
               data-component="query">
    <br>
<p>Filter by customer (CRM) ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="GETapi-am-installments"
               value="0"
               data-component="query">
    <br>
<p>Filter by status (0 = pending, 1 = invoiced). Example: <code>0</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date_from"                data-endpoint="GETapi-am-installments"
               value="2026-01-01"
               data-component="query">
    <br>
<p>Filter installments from this date. Example: <code>2026-01-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date_to"                data-endpoint="GETapi-am-installments"
               value="2026-12-31"
               data-component="query">
    <br>
<p>Filter installments until this date. Example: <code>2026-12-31</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-am-installments"
               value="salary"
               data-component="query">
    <br>
<p>Search by note. Example: <code>salary</code></p>
            </div>
                </form>

                                <h2 id="package-3-modular-return-actions-apis-for-managing-actions-on-returned-maids-refund-replacement-etc">Return Actions

APIs for managing actions on returned maids (Refund, Replacement, etc).</h2>
                                                    <h2 id="package-3-modular-PUTapi-am-return-maids--id--update-action">Ameeeeeeeeer this one make it on action return list maid as action for each row
and aslo make same one it the insident return list maid.</h2>

<p>
</p>



<span id="example-requests-PUTapi-am-return-maids--id--update-action">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/am-return-maids/1/update-action" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"action\": 2,
    \"amount\": 27,
    \"refund_date\": \"2026-03-12T17:54:57\",
    \"note\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-return-maids/1/update-action"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "action": 2,
    "amount": 27,
    "refund_date": "2026-03-12T17:54:57",
    "note": "architecto"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-am-return-maids--id--update-action">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Action updated successfully&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;action&quot;: 2
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Return maid record not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-am-return-maids--id--update-action" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-am-return-maids--id--update-action"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-am-return-maids--id--update-action"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-am-return-maids--id--update-action" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-am-return-maids--id--update-action">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-am-return-maids--id--update-action" data-method="PUT"
      data-path="api/am-return-maids/{id}/update-action"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-am-return-maids--id--update-action', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-am-return-maids--id--update-action"
                    onclick="tryItOut('PUTapi-am-return-maids--id--update-action');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-am-return-maids--id--update-action"
                    onclick="cancelTryOut('PUTapi-am-return-maids--id--update-action');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-am-return-maids--id--update-action"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/am-return-maids/{id}/update-action</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-am-return-maids--id--update-action"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-am-return-maids--id--update-action"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-am-return-maids--id--update-action"
               value="1"
               data-component="url">
    <br>
<p>The return maid ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>action</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="action"                data-endpoint="PUTapi-am-return-maids--id--update-action"
               value="2"
               data-component="body">
    <br>
<p>The action to set (1 = Pending, 2 = ReplacementRequested, 3 = RefundRaised, 4 = DueAmountOnCustomer). Example: <code>2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="PUTapi-am-return-maids--id--update-action"
               value="27"
               data-component="body">
    <br>
<p>This field is required when <code>action</code> is <code>3</code>. Must be at least 0. Example: <code>27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>refund_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="refund_date"                data-endpoint="PUTapi-am-return-maids--id--update-action"
               value="2026-03-12T17:54:57"
               data-component="body">
    <br>
<p>This field is required when <code>action</code> is <code>3</code>. Must be a valid date. Example: <code>2026-03-12T17:54:57</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-am-return-maids--id--update-action"
               value="architecto"
               data-component="body">
    <br>
<p>This field is required when <code>action</code> is <code>3</code>. Example: <code>architecto</code></p>
        </div>
        </form>

                                <h2 id="package-3-modular-invoices-for-p3-invoices-for-p3">Invoices For p3

 invoices for p3.</h2>
                                                    <h2 id="package-3-modular-POSTapi-am-monthly-invoices--id--receive-payment">Receive payment for a monthly invoice.</h2>

<p>
</p>

<p>Creates a receipt voucher linked to the invoice with a journal entry
and updates the invoice's paid_amount.</p>

<span id="example-requests-POSTapi-am-monthly-invoices--id--receive-payment">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices/1/receive-payment" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"amount\": 1500,
    \"debit_ledger_id\": 10,
    \"payment_mode\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices/1/receive-payment"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "amount": 1500,
    "debit_ledger_id": 10,
    "payment_mode": 1
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-am-monthly-invoices--id--receive-payment">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Payment received successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Payment amount (5000) exceeds remaining balance (3000)&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-am-monthly-invoices--id--receive-payment" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-am-monthly-invoices--id--receive-payment"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-am-monthly-invoices--id--receive-payment"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-am-monthly-invoices--id--receive-payment" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-am-monthly-invoices--id--receive-payment">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-am-monthly-invoices--id--receive-payment" data-method="POST"
      data-path="api/am-monthly-invoices/{id}/receive-payment"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-am-monthly-invoices--id--receive-payment', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-am-monthly-invoices--id--receive-payment"
                    onclick="tryItOut('POSTapi-am-monthly-invoices--id--receive-payment');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-am-monthly-invoices--id--receive-payment"
                    onclick="cancelTryOut('POSTapi-am-monthly-invoices--id--receive-payment');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-am-monthly-invoices--id--receive-payment"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/am-monthly-invoices/{id}/receive-payment</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-am-monthly-invoices--id--receive-payment"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-am-monthly-invoices--id--receive-payment"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-am-monthly-invoices--id--receive-payment"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="POSTapi-am-monthly-invoices--id--receive-payment"
               value="1500"
               data-component="body">
    <br>
<p>The payment amount. Example: <code>1500</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>debit_ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="debit_ledger_id"                data-endpoint="POSTapi-am-monthly-invoices--id--receive-payment"
               value="10"
               data-component="body">
    <br>
<p>The cash/bank ledger ID to debit. Example: <code>10</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_mode</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="payment_mode"                data-endpoint="POSTapi-am-monthly-invoices--id--receive-payment"
               value="1"
               data-component="body">
    <br>
<p>Payment mode (1 = Cash, 2 = Bank). Default: 1. Example: <code>1</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-POSTapi-am-monthly-invoices--id--credit-note">Issue a credit note for a monthly invoice.</h2>

<p>
</p>

<p>Full credit: reverses the entire invoice journal (swap debit/credit),
reverts installment status, and zeros out the invoice.</p>
<p>Partial credit: recalculates proportionally by days, reverses the difference,
and updates the invoice amount to the new prorated total.</p>

<span id="example-requests-POSTapi-am-monthly-invoices--id--credit-note">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices/1/credit-note" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"credit_type\": \"full\",
    \"days\": 15
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices/1/credit-note"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "credit_type": "full",
    "days": 15
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-am-monthly-invoices--id--credit-note">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Credit note issued successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice has no journal entry to reverse&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-am-monthly-invoices--id--credit-note" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-am-monthly-invoices--id--credit-note"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-am-monthly-invoices--id--credit-note"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-am-monthly-invoices--id--credit-note" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-am-monthly-invoices--id--credit-note">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-am-monthly-invoices--id--credit-note" data-method="POST"
      data-path="api/am-monthly-invoices/{id}/credit-note"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-am-monthly-invoices--id--credit-note', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-am-monthly-invoices--id--credit-note"
                    onclick="tryItOut('POSTapi-am-monthly-invoices--id--credit-note');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-am-monthly-invoices--id--credit-note"
                    onclick="cancelTryOut('POSTapi-am-monthly-invoices--id--credit-note');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-am-monthly-invoices--id--credit-note"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/am-monthly-invoices/{id}/credit-note</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-am-monthly-invoices--id--credit-note"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-am-monthly-invoices--id--credit-note"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-am-monthly-invoices--id--credit-note"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>credit_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="credit_type"                data-endpoint="POSTapi-am-monthly-invoices--id--credit-note"
               value="full"
               data-component="body">
    <br>
<p>The credit type: full or partial. Example: <code>full</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>days</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="days"                data-endpoint="POSTapi-am-monthly-invoices--id--credit-note"
               value="15"
               data-component="body">
    <br>
<p>Number of days to retain (required when credit_type is partial, 1-29). Example: <code>15</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-GETapi-am-monthly-invoices">List all monthly invoices.</h2>

<p>
</p>

<p>Returns a paginated list of monthly contract invoices with optional filtering.</p>

<span id="example-requests-GETapi-am-monthly-invoices">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-monthly-invoices?per_page=20&amp;sort_by=date&amp;sort_direction=asc&amp;crm_id=1&amp;am_monthly_contract_id=5&amp;date_from=2026-01-01&amp;date_to=2026-12-31&amp;search=p3-INV" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices"
);

const params = {
    "per_page": "20",
    "sort_by": "date",
    "sort_direction": "asc",
    "crm_id": "1",
    "am_monthly_contract_id": "5",
    "date_from": "2026-01-01",
    "date_to": "2026-12-31",
    "search": "p3-INV",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-monthly-invoices">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [],
    &quot;last_page&quot;: 1,
    &quot;per_page&quot;: 15,
    &quot;total&quot;: 0
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-monthly-invoices" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-monthly-invoices"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-monthly-invoices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-monthly-invoices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-monthly-invoices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-monthly-invoices" data-method="GET"
      data-path="api/am-monthly-invoices"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-monthly-invoices', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-monthly-invoices"
                    onclick="tryItOut('GETapi-am-monthly-invoices');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-monthly-invoices"
                    onclick="cancelTryOut('GETapi-am-monthly-invoices');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-monthly-invoices"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-monthly-invoices</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-monthly-invoices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-monthly-invoices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-monthly-invoices"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Default: 15. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-am-monthly-invoices"
               value="date"
               data-component="query">
    <br>
<p>Sort field (id, date, serial_no, amount, paid_amount, created_at). Default: created_at. Example: <code>date</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-am-monthly-invoices"
               value="asc"
               data-component="query">
    <br>
<p>Sort direction (asc, desc). Default: desc. Example: <code>asc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>crm_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="crm_id"                data-endpoint="GETapi-am-monthly-invoices"
               value="1"
               data-component="query">
    <br>
<p>Filter by customer ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>am_monthly_contract_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="am_monthly_contract_id"                data-endpoint="GETapi-am-monthly-invoices"
               value="5"
               data-component="query">
    <br>
<p>Filter by contract movement ID. Example: <code>5</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date_from"                data-endpoint="GETapi-am-monthly-invoices"
               value="2026-01-01"
               data-component="query">
    <br>
<p>Filter invoices from this date. Example: <code>2026-01-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date_to"                data-endpoint="GETapi-am-monthly-invoices"
               value="2026-12-31"
               data-component="query">
    <br>
<p>Filter invoices until this date. Example: <code>2026-12-31</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-am-monthly-invoices"
               value="p3-INV"
               data-component="query">
    <br>
<p>Search by serial number or note. Example: <code>p3-INV</code></p>
            </div>
                </form>

                    <h2 id="package-3-modular-POSTapi-am-monthly-invoices">Store a newly created monthly invoice.</h2>

<p>
</p>

<p>This method handles:</p>
<ol>
<li>Validation of the installment.</li>
<li>Calculation of amounts:
<ul>
<li>VAT (assumed 5% inclusive): Total - (Total / 1.05)</li>
<li>Salary Cost: Full monthly salary of the maid</li>
<li>Profit: Total - VAT - Salary Cost</li>
</ul></li>
<li>Ledger Resolution using <code>LedgerOfAccount</code> for:
<ul>
<li>Customer (Debit)</li>
<li>VAT Output (Credit)</li>
<li>Maid Salary (Credit)</li>
<li>P3 Profit (Credit)</li>
</ul></li>
<li>Creation of <code>AmMonthlyContractInv</code> record.</li>
<li>Update of <code>AmInstallment</code> status to 1 (Invoiced).</li>
<li>Generation of Journal Entry via <code>JournalHeaderService</code> (Status: Draft).</li>
</ol>

<span id="example-requests-POSTapi-am-monthly-invoices">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"installment_id\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "installment_id": 1
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-am-monthly-invoices">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice created successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Installment already invoiced&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-am-monthly-invoices" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-am-monthly-invoices"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-am-monthly-invoices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-am-monthly-invoices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-am-monthly-invoices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-am-monthly-invoices" data-method="POST"
      data-path="api/am-monthly-invoices"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-am-monthly-invoices', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-am-monthly-invoices"
                    onclick="tryItOut('POSTapi-am-monthly-invoices');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-am-monthly-invoices"
                    onclick="cancelTryOut('POSTapi-am-monthly-invoices');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-am-monthly-invoices"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/am-monthly-invoices</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-am-monthly-invoices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-am-monthly-invoices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>installment_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="installment_id"                data-endpoint="POSTapi-am-monthly-invoices"
               value="1"
               data-component="body">
    <br>
<p>The ID of the installment to invoice. Example: <code>1</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-GETapi-am-monthly-invoices--id-">Display a specific monthly invoice.</h2>

<p>
</p>

<p>Returns a single monthly contract invoice with all related data.</p>

<span id="example-requests-GETapi-am-monthly-invoices--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-monthly-invoices/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-monthly-invoices--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;serial_no&quot;: &quot;p3-INV-000001&quot;,
    &quot;date&quot;: &quot;2026-01-15&quot;,
    &quot;amount&quot;: 3150,
    &quot;paid_amount&quot;: 0,
    &quot;note&quot;: &quot;January installment&quot;,
    &quot;contract_movment&quot;: {},
    &quot;crm&quot;: {},
    &quot;installment&quot;: {},
    &quot;journal&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-monthly-invoices--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-monthly-invoices--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-monthly-invoices--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-monthly-invoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-monthly-invoices--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-monthly-invoices--id-" data-method="GET"
      data-path="api/am-monthly-invoices/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-monthly-invoices--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-monthly-invoices--id-"
                    onclick="tryItOut('GETapi-am-monthly-invoices--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-monthly-invoices--id-"
                    onclick="cancelTryOut('GETapi-am-monthly-invoices--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-monthly-invoices--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-monthly-invoices/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-monthly-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-monthly-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-am-monthly-invoices--id-"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="package-3-modular-PUTapi-am-monthly-invoices--id-">Update a monthly invoice.</h2>

<p>
</p>

<p>Updates the editable fields of a monthly contract invoice.</p>

<span id="example-requests-PUTapi-am-monthly-invoices--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"date\": \"2026-02-01\",
    \"note\": \"Updated note\",
    \"amount\": 3500,
    \"paid_amount\": 1000
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "date": "2026-02-01",
    "note": "Updated note",
    "amount": 3500,
    "paid_amount": 1000
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-am-monthly-invoices--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice updated successfully&quot;,
    &quot;data&quot;: {}
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-am-monthly-invoices--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-am-monthly-invoices--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-am-monthly-invoices--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-am-monthly-invoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-am-monthly-invoices--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-am-monthly-invoices--id-" data-method="PUT"
      data-path="api/am-monthly-invoices/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-am-monthly-invoices--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-am-monthly-invoices--id-"
                    onclick="tryItOut('PUTapi-am-monthly-invoices--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-am-monthly-invoices--id-"
                    onclick="cancelTryOut('PUTapi-am-monthly-invoices--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-am-monthly-invoices--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/am-monthly-invoices/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/am-monthly-invoices/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-am-monthly-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-am-monthly-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-am-monthly-invoices--id-"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="date"                data-endpoint="PUTapi-am-monthly-invoices--id-"
               value="2026-02-01"
               data-component="body">
    <br>
<p>The invoice date. Example: <code>2026-02-01</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="PUTapi-am-monthly-invoices--id-"
               value="Updated note"
               data-component="body">
    <br>
<p>A note for the invoice. Example: <code>Updated note</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="PUTapi-am-monthly-invoices--id-"
               value="3500"
               data-component="body">
    <br>
<p>The invoice amount. Example: <code>3500</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>paid_amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="paid_amount"                data-endpoint="PUTapi-am-monthly-invoices--id-"
               value="1000"
               data-component="body">
    <br>
<p>The paid amount. Example: <code>1000</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-DELETEapi-am-monthly-invoices--id-">Delete a monthly invoice.</h2>

<p>
</p>

<p>Deletes the invoice, reverts the installment status to pending,
and removes the associated journal entry.</p>

<span id="example-requests-DELETEapi-am-monthly-invoices--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-monthly-invoices/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-am-monthly-invoices--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice deleted successfully&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-am-monthly-invoices--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-am-monthly-invoices--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-am-monthly-invoices--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-am-monthly-invoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-am-monthly-invoices--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-am-monthly-invoices--id-" data-method="DELETE"
      data-path="api/am-monthly-invoices/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-am-monthly-invoices--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-am-monthly-invoices--id-"
                    onclick="tryItOut('DELETEapi-am-monthly-invoices--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-am-monthly-invoices--id-"
                    onclick="cancelTryOut('DELETEapi-am-monthly-invoices--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-am-monthly-invoices--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/am-monthly-invoices/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-am-monthly-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-am-monthly-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-am-monthly-invoices--id-"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                    </form>

                                <h2 id="package-3-modular-maid-payroll-apis-for-maid-payroll-salary-calculations">Maid Payroll

APIs for maid payroll salary calculations.</h2>
                                                    <h2 id="package-3-modular-GETapi-am-maid-payroll">Salary calculation.</h2>

<p>
</p>

<p>Returns a paginated list of maids with their working days, salary,
last contract, and last customer for the given year and month.</p>
<p>Working days are calculated from contract movement (hire) dates and
return dates, clamped to the selected month boundaries.</p>

<span id="example-requests-GETapi-am-maid-payroll">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-maid-payroll?year=2026&amp;month=2&amp;per_page=25" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"year\": 1,
    \"month\": 4
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll"
);

const params = {
    "year": "2026",
    "month": "2",
    "per_page": "25",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "year": 1,
    "month": 4
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-maid-payroll">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        {
            &quot;employee_id&quot;: 5,
            &quot;maid_name&quot;: &quot;Maria Santos&quot;,
            &quot;maid_salary&quot;: &quot;1500.00&quot;,
            &quot;last_contract_id&quot;: 12,
            &quot;last_customer_name&quot;: &quot;John Doe&quot;,
            &quot;working_days&quot;: 28,
            &quot;payroll_status&quot;: &quot;paid&quot;,
            &quot;payroll_note&quot;: &quot;Salary paid via bank&quot;
        }
    ],
    &quot;last_page&quot;: 1,
    &quot;per_page&quot;: 50,
    &quot;total&quot;: 1
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Validation failed&quot;,
    &quot;errors&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-maid-payroll" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-maid-payroll"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-maid-payroll"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-maid-payroll" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-maid-payroll">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-maid-payroll" data-method="GET"
      data-path="api/am-maid-payroll"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-maid-payroll', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-maid-payroll"
                    onclick="tryItOut('GETapi-am-maid-payroll');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-maid-payroll"
                    onclick="cancelTryOut('GETapi-am-maid-payroll');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-maid-payroll"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-maid-payroll</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-maid-payroll"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-maid-payroll"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="GETapi-am-maid-payroll"
               value="2026"
               data-component="query">
    <br>
<p>The year. Example: <code>2026</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="month"                data-endpoint="GETapi-am-maid-payroll"
               value="2"
               data-component="query">
    <br>
<p>The month (1-12). Example: <code>2</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-am-maid-payroll"
               value="25"
               data-component="query">
    <br>
<p>Items per page. Default: 50. Example: <code>25</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="GETapi-am-maid-payroll"
               value="1"
               data-component="body">
    <br>
<p>Must be at least 2020. Must not be greater than 2099. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="month"                data-endpoint="GETapi-am-maid-payroll"
               value="4"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 12. Example: <code>4</code></p>
        </div>
        </form>

                    <h2 id="package-3-modular-GETapi-am-maid-payroll--employee_id-">Employee breakdown.</h2>

<p>
</p>

<p>Returns detailed contract movement records for a single employee
during the given year and month, including contract info, customer,
return date, and working days per movement.</p>

<span id="example-requests-GETapi-am-maid-payroll--employee_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://alebdaa.cloudledger.ae/api/am-maid-payroll/5?year=2026&amp;month=2" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"employee_id\": 16,
    \"year\": 22,
    \"month\": 7
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/am-maid-payroll/5"
);

const params = {
    "year": "2026",
    "month": "2",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "employee_id": 16,
    "year": 22,
    "month": 7
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-am-maid-payroll--employee_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;employee&quot;: {
        &quot;id&quot;: 5,
        &quot;name&quot;: &quot;Maria Santos&quot;,
        &quot;salary&quot;: &quot;1500.00&quot;,
        &quot;nationality&quot;: &quot;Philippines&quot;,
        &quot;reference_no&quot;: &quot;EMP-0005&quot;
    },
    &quot;year&quot;: 2026,
    &quot;month&quot;: 2,
    &quot;month_start&quot;: &quot;2026-02-01&quot;,
    &quot;month_end&quot;: &quot;2026-02-28&quot;,
    &quot;movements&quot;: [
        {
            &quot;movement_id&quot;: 10,
            &quot;movement_date&quot;: &quot;2026-01-15&quot;,
            &quot;movement_note&quot;: &quot;Assigned&quot;,
            &quot;movement_status&quot;: 1,
            &quot;contract_id&quot;: 12,
            &quot;contract_ref&quot;: &quot;p4_00012&quot;,
            &quot;customer_name&quot;: &quot;John Doe&quot;,
            &quot;customer_cl&quot;: &quot;CL-00001&quot;,
            &quot;return_id&quot;: null,
            &quot;return_date&quot;: null,
            &quot;return_note&quot;: null,
            &quot;working_days&quot;: 28
        }
    ],
    &quot;total_working_days&quot;: 28
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Employee not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-am-maid-payroll--employee_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-am-maid-payroll--employee_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-am-maid-payroll--employee_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-am-maid-payroll--employee_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-am-maid-payroll--employee_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-am-maid-payroll--employee_id-" data-method="GET"
      data-path="api/am-maid-payroll/{employee_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-am-maid-payroll--employee_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-am-maid-payroll--employee_id-"
                    onclick="tryItOut('GETapi-am-maid-payroll--employee_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-am-maid-payroll--employee_id-"
                    onclick="cancelTryOut('GETapi-am-maid-payroll--employee_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-am-maid-payroll--employee_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/am-maid-payroll/{employee_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-am-maid-payroll--employee_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-am-maid-payroll--employee_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="GETapi-am-maid-payroll--employee_id-"
               value="5"
               data-component="url">
    <br>
<p>The employee ID. Example: <code>5</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="GETapi-am-maid-payroll--employee_id-"
               value="2026"
               data-component="query">
    <br>
<p>The year. Example: <code>2026</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="month"                data-endpoint="GETapi-am-maid-payroll--employee_id-"
               value="2"
               data-component="query">
    <br>
<p>The month (1-12). Example: <code>2</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>employee_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="employee_id"                data-endpoint="GETapi-am-maid-payroll--employee_id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the employees table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="GETapi-am-maid-payroll--employee_id-"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 2020. Must not be greater than 2099. Example: <code>22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="month"                data-endpoint="GETapi-am-maid-payroll--employee_id-"
               value="7"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 12. Example: <code>7</code></p>
        </div>
        </form>

                <h1 id="package-one">Package One</h1>

    <p>APIs for creating Package One journal entries (financial impact only).
Invoices are created separately via InvoiceController.</p>

                                <h2 id="package-one-POSTapi-package-one-received-voucher">Create Received Voucher for Package One</h2>

<p>
</p>

<p>Create a receipt voucher for Package One, linked to an Invoice as source.
The customer's ledger account is used as the credit side, and the provided
debit_ledger_id is used as the debit side (e.g., Cash/Bank).</p>

<span id="example-requests-POSTapi-package-one-received-voucher">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/package-one/received-voucher" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"invoice_id\": 1,
    \"customer_id\": 5,
    \"debit_ledger_id\": 2,
    \"amount\": 500,
    \"method_mode\": 1,
    \"note\": \"Payment received for Package One\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/package-one/received-voucher"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "invoice_id": 1,
    "customer_id": 5,
    "debit_ledger_id": 2,
    "amount": 500,
    "method_mode": 1,
    "note": "Payment received for Package One"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-package-one-received-voucher">
</span>
<span id="execution-results-POSTapi-package-one-received-voucher" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-package-one-received-voucher"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-package-one-received-voucher"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-package-one-received-voucher" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-package-one-received-voucher">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-package-one-received-voucher" data-method="POST"
      data-path="api/package-one/received-voucher"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-package-one-received-voucher', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-package-one-received-voucher"
                    onclick="tryItOut('POSTapi-package-one-received-voucher');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-package-one-received-voucher"
                    onclick="cancelTryOut('POSTapi-package-one-received-voucher');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-package-one-received-voucher"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/package-one/received-voucher</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-package-one-received-voucher"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-package-one-received-voucher"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>invoice_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="invoice_id"                data-endpoint="POSTapi-package-one-received-voucher"
               value="1"
               data-component="body">
    <br>
<p>The ID of the Invoice to link the receipt voucher to (source). The <code>invoice_id</code> of an existing record in the invoices table. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="customer_id"                data-endpoint="POSTapi-package-one-received-voucher"
               value="5"
               data-component="body">
    <br>
<p>The customer ID from CRM. The service will find the associated ledger account (credit side). The <code>id</code> of an existing record in the crm table. Example: <code>5</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>debit_ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="debit_ledger_id"                data-endpoint="POSTapi-package-one-received-voucher"
               value="2"
               data-component="body">
    <br>
<p>The debit ledger account ID for the receipt voucher (e.g., Cash/Bank). The <code>id</code> of an existing record in the ledger_of_accounts table. Example: <code>2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="POSTapi-package-one-received-voucher"
               value="500"
               data-component="body">
    <br>
<p>Amount received from customer. Must be at least 0.01. Example: <code>500</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>method_mode</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="method_mode"                data-endpoint="POSTapi-package-one-received-voucher"
               value="1"
               data-component="body">
    <br>
<p>Payment method mode (optional). Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-package-one-received-voucher"
               value="Payment received for Package One"
               data-component="body">
    <br>
<p>Note for the receipt voucher (optional). Must not be greater than 500 characters. Example: <code>Payment received for Package One</code></p>
        </div>
        </form>

                    <h2 id="package-one-POSTapi-package-one-credit-note">Create Credit Note for Package One</h2>

<p>
</p>

<p>Create a credit note that reverses the original journal entries for an invoice.
The original debit becomes credit and vice versa. The invoice will be marked as refunded.</p>

<span id="example-requests-POSTapi-package-one-credit-note">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/package-one/credit-note" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"invoice_id\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/package-one/credit-note"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "invoice_id": 1
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-package-one-credit-note">
</span>
<span id="execution-results-POSTapi-package-one-credit-note" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-package-one-credit-note"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-package-one-credit-note"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-package-one-credit-note" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-package-one-credit-note">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-package-one-credit-note" data-method="POST"
      data-path="api/package-one/credit-note"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-package-one-credit-note', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-package-one-credit-note"
                    onclick="tryItOut('POSTapi-package-one-credit-note');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-package-one-credit-note"
                    onclick="cancelTryOut('POSTapi-package-one-credit-note');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-package-one-credit-note"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/package-one/credit-note</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-package-one-credit-note"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-package-one-credit-note"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>invoice_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="invoice_id"                data-endpoint="POSTapi-package-one-credit-note"
               value="1"
               data-component="body">
    <br>
<p>The ID of the Invoice to create a credit note for. This will reverse the journal entries. The <code>invoice_id</code> of an existing record in the invoices table. Example: <code>1</code></p>
        </div>
        </form>

                    <h2 id="package-one-POSTapi-package-one-charging">Create Charging Entry for Package One</h2>

<p>
</p>

<p>Create a charging journal entry with custom lines (ledger_id with debit/credit amounts).
The invoice is referenced as the source.</p>

<span id="example-requests-POSTapi-package-one-charging">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/package-one/charging" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"invoice_id\": 1,
    \"customer_id\": 5,
    \"note\": \"Additional charges for services\",
    \"lines\": [
        {
            \"ledger_id\": 10,
            \"amount\": 100,
            \"note\": \"Service charge\"
        },
        {
            \"ledger_id\": 11,
            \"amount\": 50,
            \"note\": \"Processing fee\"
        }
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/package-one/charging"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "invoice_id": 1,
    "customer_id": 5,
    "note": "Additional charges for services",
    "lines": [
        {
            "ledger_id": 10,
            "amount": 100,
            "note": "Service charge"
        },
        {
            "ledger_id": 11,
            "amount": 50,
            "note": "Processing fee"
        }
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-package-one-charging">
</span>
<span id="execution-results-POSTapi-package-one-charging" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-package-one-charging"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-package-one-charging"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-package-one-charging" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-package-one-charging">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-package-one-charging" data-method="POST"
      data-path="api/package-one/charging"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-package-one-charging', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-package-one-charging"
                    onclick="tryItOut('POSTapi-package-one-charging');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-package-one-charging"
                    onclick="cancelTryOut('POSTapi-package-one-charging');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-package-one-charging"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/package-one/charging</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-package-one-charging"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-package-one-charging"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>invoice_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="invoice_id"                data-endpoint="POSTapi-package-one-charging"
               value="1"
               data-component="body">
    <br>
<p>The ID of the Invoice to reference as source. The <code>invoice_id</code> of an existing record in the invoices table. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="customer_id"                data-endpoint="POSTapi-package-one-charging"
               value="5"
               data-component="body">
    <br>
<p>The customer ID from CRM. The service will find the associated ledger account for the debit side. The <code>id</code> of an existing record in the crm table. Example: <code>5</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-package-one-charging"
               value="Additional charges for services"
               data-component="body">
    <br>
<p>Note for the journal header (optional). Must not be greater than 500 characters. Example: <code>Additional charges for services</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>lines</code></b>&nbsp;&nbsp;
<small>object[]</small>&nbsp;
 &nbsp;
 &nbsp;
<br>
<p>Array of credit ledger lines with ledger_id and amount. Must have at least 1 items.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.ledger_id"                data-endpoint="POSTapi-package-one-charging"
               value="10"
               data-component="body">
    <br>
<p>The ledger account ID for the credit side. The <code>id</code> of an existing record in the ledger_of_accounts table. Example: <code>10</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.amount"                data-endpoint="POSTapi-package-one-charging"
               value="100"
               data-component="body">
    <br>
<p>Amount to credit to this ledger. Must be at least 0.01. Example: <code>100</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lines.0.note"                data-endpoint="POSTapi-package-one-charging"
               value="Service charge"
               data-component="body">
    <br>
<p>Note for this specific line (optional). Must not be greater than 255 characters. Example: <code>Service charge</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="package-one-POSTapi-package-one">Create Package One Journal Entry</h2>

<p>
</p>

<p>Create journal entries for Package One (financial impact only).
The cn_number will be stored in all journal transaction lines.
Invoice creation is handled separately via InvoiceController.</p>

<span id="example-requests-POSTapi-package-one">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/package-one" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"invoice_id\": 1,
    \"cn_number\": \"CN-2026-001\",
    \"customer_id\": 5,
    \"invoice_service_id\": 1,
    \"amount_received\": 500,
    \"debit_ledger_id\": 2
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/package-one"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "invoice_id": 1,
    "cn_number": "CN-2026-001",
    "customer_id": 5,
    "invoice_service_id": 1,
    "amount_received": 500,
    "debit_ledger_id": 2
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-package-one">
</span>
<span id="execution-results-POSTapi-package-one" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-package-one"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-package-one"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-package-one" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-package-one">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-package-one" data-method="POST"
      data-path="api/package-one"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-package-one', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-package-one"
                    onclick="tryItOut('POSTapi-package-one');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-package-one"
                    onclick="cancelTryOut('POSTapi-package-one');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-package-one"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/package-one</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-package-one"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-package-one"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>invoice_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="invoice_id"                data-endpoint="POSTapi-package-one"
               value="1"
               data-component="body">
    <br>
<p>The ID of the invoice to link the journal entry to. The <code>invoice_id</code> of an existing record in the invoices table. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>cn_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="cn_number"                data-endpoint="POSTapi-package-one"
               value="CN-2026-001"
               data-component="body">
    <br>
<p>The CN Number from the package. Must not be greater than 255 characters. Example: <code>CN-2026-001</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="customer_id"                data-endpoint="POSTapi-package-one"
               value="5"
               data-component="body">
    <br>
<p>The customer ID from CRM. The service will find the associated ledger account. The <code>id</code> of an existing record in the crm table. Example: <code>5</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>invoice_service_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="invoice_service_id"                data-endpoint="POSTapi-package-one"
               value="1"
               data-component="body">
    <br>
<p>The invoice service ID to use. If not provided, uses first active Package One type (type=1) service. The <code>id</code> of an existing record in the invoice_services table. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount_received</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount_received"                data-endpoint="POSTapi-package-one"
               value="500"
               data-component="body">
    <br>
<p>Amount received from customer. If &gt; 0, creates a receipt voucher. Must be at least 0. Example: <code>500</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>debit_ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="debit_ledger_id"                data-endpoint="POSTapi-package-one"
               value="2"
               data-component="body">
    <br>
<p>The debit ledger account ID for the receipt voucher (e.g., Cash/Bank). Required if amount_received &gt; 0. This field is required when <code>amount_received</code> is <code>&gt;</code> or <code>0</code>. The <code>id</code> of an existing record in the ledger_of_accounts table. Example: <code>2</code></p>
        </div>
        </form>

                    <h2 id="package-one-DELETEapi-package-one--id-">Delete Package One Journal Entry</h2>

<p>
</p>

<p>Delete a Package One journal entry and its lines.</p>

<span id="example-requests-DELETEapi-package-one--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/package-one/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/package-one/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-package-one--id-">
</span>
<span id="execution-results-DELETEapi-package-one--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-package-one--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-package-one--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-package-one--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-package-one--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-package-one--id-" data-method="DELETE"
      data-path="api/package-one/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-package-one--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-package-one--id-"
                    onclick="tryItOut('DELETEapi-package-one--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-package-one--id-"
                    onclick="cancelTryOut('DELETEapi-package-one--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-package-one--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/package-one/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-package-one--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-package-one--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-package-one--id-"
               value="1"
               data-component="url">
    <br>
<p>The journal ID. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="receipt-vouchers">Receipt Vouchers</h1>

    <p>APIs for managing receipt vouchers with automatic journal entry creation.</p>

                                <h2 id="receipt-vouchers-POSTapi-receipt-vouchers">Create a new receipt voucher</h2>

<p>
</p>

<p>Store a newly created receipt voucher with automatic journal entry creation.
The journal entry will be created with a debit to the specified debit_ledger_id
and a credit to the credit_ledger_id for the specified amount.</p>

<span id="example-requests-POSTapi-receipt-vouchers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/receipt-vouchers" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"source_type\": \"architecto\",
    \"candidate_id\": 5,
    \"credit_ledger_id\": 10,
    \"debit_ledger_id\": 20,
    \"source_id\": 16,
    \"attachments\": [
        \"url1\",
        \"url2\"
    ],
    \"status\": \"posted\",
    \"amount\": 1500,
    \"payment_mode\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/receipt-vouchers"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "source_type": "architecto",
    "candidate_id": 5,
    "credit_ledger_id": 10,
    "debit_ledger_id": 20,
    "source_id": 16,
    "attachments": [
        "url1",
        "url2"
    ],
    "status": "posted",
    "amount": 1500,
    "payment_mode": 1
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-receipt-vouchers">
</span>
<span id="execution-results-POSTapi-receipt-vouchers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-receipt-vouchers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-receipt-vouchers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-receipt-vouchers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-receipt-vouchers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-receipt-vouchers" data-method="POST"
      data-path="api/receipt-vouchers"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-receipt-vouchers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-receipt-vouchers"
                    onclick="tryItOut('POSTapi-receipt-vouchers');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-receipt-vouchers"
                    onclick="cancelTryOut('POSTapi-receipt-vouchers');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-receipt-vouchers"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/receipt-vouchers</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-receipt-vouchers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-receipt-vouchers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>source_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="source_type"                data-endpoint="POSTapi-receipt-vouchers"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>candidate_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="candidate_id"                data-endpoint="POSTapi-receipt-vouchers"
               value="5"
               data-component="body">
    <br>
<p>optional Link to a candidate. Example: <code>5</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>credit_ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="credit_ledger_id"                data-endpoint="POSTapi-receipt-vouchers"
               value="10"
               data-component="body">
    <br>
<p>Ledger account to credit. Example: <code>10</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>debit_ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="debit_ledger_id"                data-endpoint="POSTapi-receipt-vouchers"
               value="20"
               data-component="body">
    <br>
<p>Ledger account to debit. Example: <code>20</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>source_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="source_id"                data-endpoint="POSTapi-receipt-vouchers"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>attachments</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="attachments[0]"                data-endpoint="POSTapi-receipt-vouchers"
               data-component="body">
        <input type="text" style="display: none"
               name="attachments[1]"                data-endpoint="POSTapi-receipt-vouchers"
               data-component="body">
    <br>
<p>optional Array of attachment URLs.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="POSTapi-receipt-vouchers"
               value="posted"
               data-component="body">
    <br>
<p>optional Voucher status (draft, posted, void). Defaults to draft. Example: <code>posted</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="POSTapi-receipt-vouchers"
               value="1500"
               data-component="body">
    <br>
<p>Receipt amount. Example: <code>1500</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_mode</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="payment_mode"                data-endpoint="POSTapi-receipt-vouchers"
               value="1"
               data-component="body">
    <br>
<p>optional Payment mode code. Example: <code>1</code></p>
        </div>
        </form>

                    <h2 id="receipt-vouchers-PUTapi-receipt-vouchers--id-">Update a receipt voucher</h2>

<p>
</p>

<p>Update the details of a specific receipt voucher and its associated journal entry.</p>

<span id="example-requests-PUTapi-receipt-vouchers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/receipt-vouchers/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"serial_number\": \"bngzmi\",
    \"source_type\": \"architecto\",
    \"source_id\": 16,
    \"status\": \"posted\",
    \"amount\": 2000,
    \"payment_mode\": 2,
    \"candidate_id\": 5,
    \"credit_ledger_id\": 10,
    \"debit_ledger_id\": 20
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/receipt-vouchers/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "serial_number": "bngzmi",
    "source_type": "architecto",
    "source_id": 16,
    "status": "posted",
    "amount": 2000,
    "payment_mode": 2,
    "candidate_id": 5,
    "credit_ledger_id": 10,
    "debit_ledger_id": 20
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-receipt-vouchers--id-">
</span>
<span id="execution-results-PUTapi-receipt-vouchers--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-receipt-vouchers--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-receipt-vouchers--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-receipt-vouchers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-receipt-vouchers--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-receipt-vouchers--id-" data-method="PUT"
      data-path="api/receipt-vouchers/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-receipt-vouchers--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-receipt-vouchers--id-"
                    onclick="tryItOut('PUTapi-receipt-vouchers--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-receipt-vouchers--id-"
                    onclick="cancelTryOut('PUTapi-receipt-vouchers--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-receipt-vouchers--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/receipt-vouchers/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/receipt-vouchers/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the receipt voucher. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>serial_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="serial_number"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="bngzmi"
               data-component="body">
    <br>
<p>Must not be greater than 10 characters. Example: <code>bngzmi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>source_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="source_type"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>source_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="source_id"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>attachments</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="attachments"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="posted"
               data-component="body">
    <br>
<p>optional Voucher status (draft, posted, void). Example: <code>posted</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="2000"
               data-component="body">
    <br>
<p>optional Receipt amount. Example: <code>2000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_mode</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="payment_mode"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="2"
               data-component="body">
    <br>
<p>optional Payment mode code. Example: <code>2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>candidate_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="candidate_id"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="5"
               data-component="body">
    <br>
<p>optional Link to a candidate. Example: <code>5</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>credit_ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="credit_ledger_id"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="10"
               data-component="body">
    <br>
<p>optional Ledger account to credit. Example: <code>10</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>debit_ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="debit_ledger_id"                data-endpoint="PUTapi-receipt-vouchers--id-"
               value="20"
               data-component="body">
    <br>
<p>optional Ledger account to debit. Example: <code>20</code></p>
        </div>
        </form>

                    <h2 id="receipt-vouchers-DELETEapi-receipt-vouchers--id-">Delete a receipt voucher</h2>

<p>
</p>

<p>Remove a specific receipt voucher and its associated journal entry from the database.</p>

<span id="example-requests-DELETEapi-receipt-vouchers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/receipt-vouchers/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/receipt-vouchers/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-receipt-vouchers--id-">
</span>
<span id="execution-results-DELETEapi-receipt-vouchers--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-receipt-vouchers--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-receipt-vouchers--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-receipt-vouchers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-receipt-vouchers--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-receipt-vouchers--id-" data-method="DELETE"
      data-path="api/receipt-vouchers/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-receipt-vouchers--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-receipt-vouchers--id-"
                    onclick="tryItOut('DELETEapi-receipt-vouchers--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-receipt-vouchers--id-"
                    onclick="cancelTryOut('DELETEapi-receipt-vouchers--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-receipt-vouchers--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/receipt-vouchers/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-receipt-vouchers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-receipt-vouchers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-receipt-vouchers--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the receipt voucher to delete. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="typing-transaction-government-invoices">Typing Transaction Government Invoices</h1>

    <p>APIs for managing Typing Transaction Government Invoices.</p>

                                <h2 id="typing-transaction-government-invoices-POSTapi-typing-tran-gov-invs--id--receive-payment">Receive payment for a typing invoice</h2>

<p>
</p>

<p>Create a receipt voucher for a specific typing invoice and record the payment
with proper journal entries. This endpoint creates a ReceiptVoucher linked to
the typing invoice via polymorphic relationship and updates the amount_received.</p>

<span id="example-requests-POSTapi-typing-tran-gov-invs--id--receive-payment">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/typing-tran-gov-invs/1/receive-payment" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"credit_ledger_id\": 10,
    \"debit_ledger_id\": 20,
    \"amount\": 500,
    \"attachments\": [
        \"url1\",
        \"url2\"
    ],
    \"status\": \"posted\",
    \"payment_mode\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/typing-tran-gov-invs/1/receive-payment"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "credit_ledger_id": 10,
    "debit_ledger_id": 20,
    "amount": 500,
    "attachments": [
        "url1",
        "url2"
    ],
    "status": "posted",
    "payment_mode": 1
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-typing-tran-gov-invs--id--receive-payment">
</span>
<span id="execution-results-POSTapi-typing-tran-gov-invs--id--receive-payment" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-typing-tran-gov-invs--id--receive-payment"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-typing-tran-gov-invs--id--receive-payment"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-typing-tran-gov-invs--id--receive-payment" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-typing-tran-gov-invs--id--receive-payment">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-typing-tran-gov-invs--id--receive-payment" data-method="POST"
      data-path="api/typing-tran-gov-invs/{id}/receive-payment"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-typing-tran-gov-invs--id--receive-payment', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-typing-tran-gov-invs--id--receive-payment"
                    onclick="tryItOut('POSTapi-typing-tran-gov-invs--id--receive-payment');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-typing-tran-gov-invs--id--receive-payment"
                    onclick="cancelTryOut('POSTapi-typing-tran-gov-invs--id--receive-payment');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-typing-tran-gov-invs--id--receive-payment"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/typing-tran-gov-invs/{id}/receive-payment</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               value="1"
               data-component="url">
    <br>
<p>The ID of the typing invoice. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>credit_ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="credit_ledger_id"                data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               value="10"
               data-component="body">
    <br>
<p>Ledger account to credit (usually the customer account). Example: <code>10</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>debit_ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="debit_ledger_id"                data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               value="20"
               data-component="body">
    <br>
<p>Ledger account to debit (usually cash/bank account). Example: <code>20</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               value="500"
               data-component="body">
    <br>
<p>Payment amount received. Example: <code>500</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>attachments</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="attachments[0]"                data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               data-component="body">
        <input type="text" style="display: none"
               name="attachments[1]"                data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               data-component="body">
    <br>
<p>optional Array of attachment URLs.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               value="posted"
               data-component="body">
    <br>
<p>optional Voucher status (draft, posted, void). Defaults to posted. Example: <code>posted</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_mode</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="payment_mode"                data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               value="1"
               data-component="body">
    <br>
<p>optional Payment mode code. Example: <code>1</code></p>
        </div>
        </form>

                    <h2 id="typing-transaction-government-invoices-POSTapi-typing-tran-gov-invs">Create a new item</h2>

<p>
</p>

<p>Store a newly created item.</p>

<span id="example-requests-POSTapi-typing-tran-gov-invs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://alebdaa.cloudledger.ae/api/typing-tran-gov-invs" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"gov_dw_no\": \"DW-12345\",
    \"gov_inv_attachments\": [
        \"architecto\"
    ],
    \"maid_id\": 10,
    \"amount_received\": 0,
    \"ledger_of_account_id\": 1,
    \"services\": [
        \"architecto\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/typing-tran-gov-invs"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "gov_dw_no": "DW-12345",
    "gov_inv_attachments": [
        "architecto"
    ],
    "maid_id": 10,
    "amount_received": 0,
    "ledger_of_account_id": 1,
    "services": [
        "architecto"
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-typing-tran-gov-invs">
</span>
<span id="execution-results-POSTapi-typing-tran-gov-invs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-typing-tran-gov-invs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-typing-tran-gov-invs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-typing-tran-gov-invs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-typing-tran-gov-invs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-typing-tran-gov-invs" data-method="POST"
      data-path="api/typing-tran-gov-invs"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-typing-tran-gov-invs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-typing-tran-gov-invs"
                    onclick="tryItOut('POSTapi-typing-tran-gov-invs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-typing-tran-gov-invs"
                    onclick="cancelTryOut('POSTapi-typing-tran-gov-invs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-typing-tran-gov-invs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/typing-tran-gov-invs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-typing-tran-gov-invs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-typing-tran-gov-invs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>gov_dw_no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="gov_dw_no"                data-endpoint="POSTapi-typing-tran-gov-invs"
               value="DW-12345"
               data-component="body">
    <br>
<p>optional Government D/W Number (deprecated, use services.*.dw instead). Example: <code>DW-12345</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>gov_inv_attachments</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="gov_inv_attachments[0]"                data-endpoint="POSTapi-typing-tran-gov-invs"
               data-component="body">
        <input type="text" style="display: none"
               name="gov_inv_attachments[1]"                data-endpoint="POSTapi-typing-tran-gov-invs"
               data-component="body">
    <br>
<p>optional Array of attachment paths or objects.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>maid_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="maid_id"                data-endpoint="POSTapi-typing-tran-gov-invs"
               value="10"
               data-component="body">
    <br>
<p>optional Maid ID. Example: <code>10</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount_received</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount_received"                data-endpoint="POSTapi-typing-tran-gov-invs"
               value="0"
               data-component="body">
    <br>
<p>Initial amount received (if any). Must be at least 0. Example: <code>0</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ledger_of_account_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ledger_of_account_id"                data-endpoint="POSTapi-typing-tran-gov-invs"
               value="1"
               data-component="body">
    <br>
<p>Ledger/Customer ID. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>services</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
 &nbsp;
<br>
<p>Array of services to include in the invoice.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>invoice_service_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="services.0.invoice_service_id"                data-endpoint="POSTapi-typing-tran-gov-invs"
               value="1"
               data-component="body">
    <br>
<p>Invoice Service ID. Example: <code>1</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="services.0.quantity"                data-endpoint="POSTapi-typing-tran-gov-invs"
               value="2"
               data-component="body">
    <br>
<p>Quantity for this service. Example: <code>2</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>dw</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="services.0.dw"                data-endpoint="POSTapi-typing-tran-gov-invs"
               value="DW-001"
               data-component="body">
    <br>
<p>optional D/W number for this service line. Example: <code>DW-001</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="typing-transaction-government-invoices-PUTapi-typing-tran-gov-invs--id-">Update an item</h2>

<p>
</p>

<p>Update the details of a specific item.</p>

<span id="example-requests-PUTapi-typing-tran-gov-invs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://alebdaa.cloudledger.ae/api/typing-tran-gov-invs/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"gov_dw_no\": \"DW-12345\",
    \"gov_inv_attachments\": [
        \"architecto\"
    ],
    \"maid_id\": 10,
    \"amount_received\": 39,
    \"ledger_of_account_id\": 1,
    \"services\": [
        \"architecto\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/typing-tran-gov-invs/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "gov_dw_no": "DW-12345",
    "gov_inv_attachments": [
        "architecto"
    ],
    "maid_id": 10,
    "amount_received": 39,
    "ledger_of_account_id": 1,
    "services": [
        "architecto"
    ]
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-typing-tran-gov-invs--id-">
</span>
<span id="execution-results-PUTapi-typing-tran-gov-invs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-typing-tran-gov-invs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-typing-tran-gov-invs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-typing-tran-gov-invs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-typing-tran-gov-invs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-typing-tran-gov-invs--id-" data-method="PUT"
      data-path="api/typing-tran-gov-invs/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-typing-tran-gov-invs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-typing-tran-gov-invs--id-"
                    onclick="tryItOut('PUTapi-typing-tran-gov-invs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-typing-tran-gov-invs--id-"
                    onclick="cancelTryOut('PUTapi-typing-tran-gov-invs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-typing-tran-gov-invs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/typing-tran-gov-invs/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/typing-tran-gov-invs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the item. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>gov_dw_no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="gov_dw_no"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="DW-12345"
               data-component="body">
    <br>
<p>optional Government D/W Number (deprecated, use services.*.dw instead). Example: <code>DW-12345</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>gov_inv_attachments</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="gov_inv_attachments[0]"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               data-component="body">
        <input type="text" style="display: none"
               name="gov_inv_attachments[1]"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               data-component="body">
    <br>
<p>optional Array of attachment paths or objects.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>maid_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="maid_id"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="10"
               data-component="body">
    <br>
<p>optional Maid ID. Example: <code>10</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount_received</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount_received"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="39"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>39</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ledger_of_account_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ledger_of_account_id"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="1"
               data-component="body">
    <br>
<p>optional Ledger/Customer ID. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>services</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>optional Array of services to include in the invoice.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>invoice_service_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="services.0.invoice_service_id"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="1"
               data-component="body">
    <br>
<p>Invoice Service ID. Example: <code>1</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="services.0.quantity"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="2"
               data-component="body">
    <br>
<p>Quantity for this service. Example: <code>2</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>dw</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="services.0.dw"                data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="DW-001"
               data-component="body">
    <br>
<p>optional D/W number for this service line. Example: <code>DW-001</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="typing-transaction-government-invoices-DELETEapi-typing-tran-gov-invs--id-">Delete an item</h2>

<p>
</p>

<p>Remove a specific item from the database.</p>

<span id="example-requests-DELETEapi-typing-tran-gov-invs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://alebdaa.cloudledger.ae/api/typing-tran-gov-invs/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://alebdaa.cloudledger.ae/api/typing-tran-gov-invs/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-typing-tran-gov-invs--id-">
</span>
<span id="execution-results-DELETEapi-typing-tran-gov-invs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-typing-tran-gov-invs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-typing-tran-gov-invs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-typing-tran-gov-invs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-typing-tran-gov-invs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-typing-tran-gov-invs--id-" data-method="DELETE"
      data-path="api/typing-tran-gov-invs/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-typing-tran-gov-invs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-typing-tran-gov-invs--id-"
                    onclick="tryItOut('DELETEapi-typing-tran-gov-invs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-typing-tran-gov-invs--id-"
                    onclick="cancelTryOut('DELETEapi-typing-tran-gov-invs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-typing-tran-gov-invs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/typing-tran-gov-invs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-typing-tran-gov-invs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-typing-tran-gov-invs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-typing-tran-gov-invs--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the item to delete. Example: <code>1</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
