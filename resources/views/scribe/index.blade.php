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
        var tryItOutBaseUrl = "http://74.162.89.93";
        var useCsrf = Boolean(1);
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.6.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.6.0.js") }}"></script>

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
                                                    <li class="tocify-item level-2" data-unique="invoice-services-GETapi-invoice-services-lookup">
                                <a href="#invoice-services-GETapi-invoice-services-lookup">Lookup Invoice Services</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoice-services-GETapi-invoice-services">
                                <a href="#invoice-services-GETapi-invoice-services">List Invoice Services</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoice-services-POSTapi-invoice-services">
                                <a href="#invoice-services-POSTapi-invoice-services">Create Invoice Service</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoice-services-GETapi-invoice-services--id-">
                                <a href="#invoice-services-GETapi-invoice-services--id-">Get Invoice Service</a>
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
                                                    <li class="tocify-item level-2" data-unique="journal-entries-GETapi-journals">
                                <a href="#journal-entries-GETapi-journals">List all journal entries</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="journal-entries-POSTapi-journals">
                                <a href="#journal-entries-POSTapi-journals">Create a new journal entry</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="journal-entries-GETapi-journals--id-">
                                <a href="#journal-entries-GETapi-journals--id-">Get a specific journal entry</a>
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
                                                    <li class="tocify-item level-2" data-unique="journal-transaction-lines-GETapi-journal-tran-lines">
                                <a href="#journal-transaction-lines-GETapi-journal-tran-lines">List journal transaction lines</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-ledger-of-accounts" class="tocify-header">
                <li class="tocify-item level-1" data-unique="ledger-of-accounts">
                    <a href="#ledger-of-accounts">Ledger of Accounts</a>
                </li>
                                    <ul id="tocify-subheader-ledger-of-accounts" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="ledger-of-accounts-GETapi-ledgers-lookup">
                                <a href="#ledger-of-accounts-GETapi-ledgers-lookup">Lookup ledger accounts for dropdowns</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ledger-of-accounts-GETapi-ledgers-lookup-customers">
                                <a href="#ledger-of-accounts-GETapi-ledgers-lookup-customers">Lookup customers with CRM search</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ledger-of-accounts-GETapi-ledgers-export">
                                <a href="#ledger-of-accounts-GETapi-ledgers-export">Export all ledger accounts to Excel</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ledger-of-accounts-GETapi-ledgers">
                                <a href="#ledger-of-accounts-GETapi-ledgers">List all ledger accounts</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ledger-of-accounts-POSTapi-ledgers">
                                <a href="#ledger-of-accounts-POSTapi-ledgers">Create a new ledger account</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ledger-of-accounts-GETapi-ledgers--id-">
                                <a href="#ledger-of-accounts-GETapi-ledgers--id-">Get a specific ledger account</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ledger-of-accounts-PUTapi-ledgers--id-">
                                <a href="#ledger-of-accounts-PUTapi-ledgers--id-">Update a ledger account</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="ledger-of-accounts-DELETEapi-ledgers--id-">
                                <a href="#ledger-of-accounts-DELETEapi-ledgers--id-">Delete a ledger account</a>
                            </li>
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
                                                                                <li class="tocify-item level-2" data-unique="package-one-GETapi-package-one">
                                <a href="#package-one-GETapi-package-one">List Package One Journal Entries</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="package-one-POSTapi-package-one">
                                <a href="#package-one-POSTapi-package-one">Create Package One Journal Entry</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="package-one-GETapi-package-one--id-">
                                <a href="#package-one-GETapi-package-one--id-">Get Package One Journal Entry</a>
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
                                                    <li class="tocify-item level-2" data-unique="receipt-vouchers-GETapi-receipt-vouchers">
                                <a href="#receipt-vouchers-GETapi-receipt-vouchers">List all receipt vouchers</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="receipt-vouchers-POSTapi-receipt-vouchers">
                                <a href="#receipt-vouchers-POSTapi-receipt-vouchers">Create a new receipt voucher</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="receipt-vouchers-GETapi-receipt-vouchers--id-">
                                <a href="#receipt-vouchers-GETapi-receipt-vouchers--id-">Get a specific receipt voucher</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="receipt-vouchers-PUTapi-receipt-vouchers--id-">
                                <a href="#receipt-vouchers-PUTapi-receipt-vouchers--id-">Update a receipt voucher</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="receipt-vouchers-DELETEapi-receipt-vouchers--id-">
                                <a href="#receipt-vouchers-DELETEapi-receipt-vouchers--id-">Delete a receipt voucher</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-statement-of-account" class="tocify-header">
                <li class="tocify-item level-1" data-unique="statement-of-account">
                    <a href="#statement-of-account">Statement of Account</a>
                </li>
                                    <ul id="tocify-subheader-statement-of-account" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="statement-of-account-GETapi-statement-of-account--ledger_id-">
                                <a href="#statement-of-account-GETapi-statement-of-account--ledger_id-">Get Statement of Account</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-trial-balance" class="tocify-header">
                <li class="tocify-item level-1" data-unique="trial-balance">
                    <a href="#trial-balance">Trial Balance</a>
                </li>
                                    <ul id="tocify-subheader-trial-balance" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="trial-balance-GETapi-trial-balance">
                                <a href="#trial-balance-GETapi-trial-balance">Get Trial Balance</a>
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
                                                                                <li class="tocify-item level-2" data-unique="typing-transaction-government-invoices-GETapi-typing-tran-gov-invs">
                                <a href="#typing-transaction-government-invoices-GETapi-typing-tran-gov-invs">List all items</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="typing-transaction-government-invoices-POSTapi-typing-tran-gov-invs">
                                <a href="#typing-transaction-government-invoices-POSTapi-typing-tran-gov-invs">Create a new item</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="typing-transaction-government-invoices-GETapi-typing-tran-gov-invs--id-">
                                <a href="#typing-transaction-government-invoices-GETapi-typing-tran-gov-invs--id-">Get a specific item</a>
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
        <li>Last updated: February 14, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://74.162.89.93</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_TOKEN}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your token by logging in to the application. Use Laravel Sanctum for authentication.</p>

        <h1 id="bulk-journal-import">Bulk Journal Import</h1>

    <p>APIs for bulk importing journal vouchers via CSV.</p>

                                <h2 id="bulk-journal-import-POSTapi-journals-bulk-import">Bulk Import Journal Vouchers</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
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
    "http://74.162.89.93/api/journals/bulk-import" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "file=@/tmp/phpe7rglj" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/journals/bulk-import"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-journals-bulk-import"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
<p>The CSV file to import. Example: <code>/tmp/phpe7rglj</code></p>
        </div>
        </form>

                <h1 id="invoice-services">Invoice Services</h1>

    <p>APIs for managing invoice services.</p>

                                <h2 id="invoice-services-GETapi-invoice-services-lookup">Lookup Invoice Services</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get a simplified list of invoice services for dropdowns, including nested lines.
Returns format: {id, text, lines: [...]}</p>

<span id="example-requests-GETapi-invoice-services-lookup">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/invoice-services/lookup?search=Service+A&amp;type=1&amp;page=1&amp;per_page=20" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/invoice-services/lookup"
);

const params = {
    "search": "Service A",
    "type": "1",
    "page": "1",
    "per_page": "20",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-invoice-services-lookup">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;results&quot;: [],
    &quot;pagination&quot;: {
        &quot;more&quot;: false,
        &quot;current_page&quot;: 1,
        &quot;total&quot;: 0
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-invoice-services-lookup" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-invoice-services-lookup"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-invoice-services-lookup"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-invoice-services-lookup" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-invoice-services-lookup">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-invoice-services-lookup" data-method="GET"
      data-path="api/invoice-services/lookup"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-invoice-services-lookup', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-invoice-services-lookup"
                    onclick="tryItOut('GETapi-invoice-services-lookup');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-invoice-services-lookup"
                    onclick="cancelTryOut('GETapi-invoice-services-lookup');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-invoice-services-lookup"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/invoice-services/lookup</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-invoice-services-lookup"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-invoice-services-lookup"
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
                              name="Accept"                data-endpoint="GETapi-invoice-services-lookup"
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
                              name="search"                data-endpoint="GETapi-invoice-services-lookup"
               value="Service A"
               data-component="query">
    <br>
<p>Search by name or code. Example: <code>Service A</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="type"                data-endpoint="GETapi-invoice-services-lookup"
               value="1"
               data-component="query">
    <br>
<p>Filter by service type. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-invoice-services-lookup"
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
               step="any"               name="per_page"                data-endpoint="GETapi-invoice-services-lookup"
               value="20"
               data-component="query">
    <br>
<p>Items per page (max 50). Example: <code>20</code></p>
            </div>
                </form>

                    <h2 id="invoice-services-GETapi-invoice-services">List Invoice Services</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Display a listing of the resource.</p>

<span id="example-requests-GETapi-invoice-services">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/invoice-services?per_page=15&amp;sort_by=created_at&amp;sort_direction=desc" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/invoice-services"
);

const params = {
    "per_page": "15",
    "sort_by": "created_at",
    "sort_direction": "desc",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-invoice-services">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 14,
            &quot;name&quot;: &quot;Phi&quot;,
            &quot;code&quot;: &quot;sss&quot;,
            &quot;note&quot;: null,
            &quot;status&quot;: true,
            &quot;type&quot;: 2,
            &quot;settings&quot;: null,
            &quot;created_by&quot;: null,
            &quot;updated_by&quot;: null,
            &quot;created_by_name&quot;: null,
            &quot;updated_by_name&quot;: null,
            &quot;total_amount&quot;: 12600,
            &quot;govt_fee&quot;: 10000,
            &quot;center_fee&quot;: 2000,
            &quot;service_charge&quot;: 0,
            &quot;tax&quot;: 600,
            &quot;is_taxable&quot;: false,
            &quot;lines&quot;: [
                {
                    &quot;id&quot;: 41,
                    &quot;ledger_account_id&quot;: 24,
                    &quot;ledger_name&quot;: &quot;maids&quot;,
                    &quot;invoice_service_id&quot;: 14,
                    &quot;amount_debit&quot;: null,
                    &quot;amount_credit&quot;: &quot;10000.00&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-03T12:27:23.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-03T12:27:23.000000Z&quot;
                },
                {
                    &quot;id&quot;: 42,
                    &quot;ledger_account_id&quot;: 25,
                    &quot;ledger_name&quot;: &quot;profit package one&quot;,
                    &quot;invoice_service_id&quot;: 14,
                    &quot;amount_debit&quot;: null,
                    &quot;amount_credit&quot;: &quot;2000.00&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-03T12:27:23.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-03T12:27:23.000000Z&quot;
                },
                {
                    &quot;id&quot;: 43,
                    &quot;ledger_account_id&quot;: 10,
                    &quot;ledger_name&quot;: &quot;VAT&quot;,
                    &quot;invoice_service_id&quot;: 14,
                    &quot;amount_debit&quot;: null,
                    &quot;amount_credit&quot;: &quot;600.00&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-03T12:27:23.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-03T12:27:23.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2026-02-03T12:27:23.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-02-03T12:27:23.000000Z&quot;
        },
        {
            &quot;id&quot;: 13,
            &quot;name&quot;: &quot;service for package one&quot;,
            &quot;code&quot;: &quot;p1&quot;,
            &quot;note&quot;: null,
            &quot;status&quot;: true,
            &quot;type&quot;: 2,
            &quot;settings&quot;: null,
            &quot;created_by&quot;: null,
            &quot;updated_by&quot;: null,
            &quot;created_by_name&quot;: null,
            &quot;updated_by_name&quot;: null,
            &quot;total_amount&quot;: 15750,
            &quot;govt_fee&quot;: 12000,
            &quot;center_fee&quot;: 3000,
            &quot;service_charge&quot;: 0,
            &quot;tax&quot;: 750,
            &quot;is_taxable&quot;: false,
            &quot;lines&quot;: [
                {
                    &quot;id&quot;: 38,
                    &quot;ledger_account_id&quot;: 25,
                    &quot;ledger_name&quot;: &quot;profit package one&quot;,
                    &quot;invoice_service_id&quot;: 13,
                    &quot;amount_debit&quot;: &quot;0.00&quot;,
                    &quot;amount_credit&quot;: &quot;3000.00&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-01T12:01:23.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-02T10:27:49.000000Z&quot;
                },
                {
                    &quot;id&quot;: 39,
                    &quot;ledger_account_id&quot;: 24,
                    &quot;ledger_name&quot;: &quot;maids&quot;,
                    &quot;invoice_service_id&quot;: 13,
                    &quot;amount_debit&quot;: &quot;0.00&quot;,
                    &quot;amount_credit&quot;: &quot;12000.00&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-01T12:01:23.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-01T12:01:23.000000Z&quot;
                },
                {
                    &quot;id&quot;: 40,
                    &quot;ledger_account_id&quot;: 10,
                    &quot;ledger_name&quot;: &quot;VAT&quot;,
                    &quot;invoice_service_id&quot;: 13,
                    &quot;amount_debit&quot;: &quot;0.00&quot;,
                    &quot;amount_credit&quot;: &quot;750.00&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-01T12:01:23.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-01T12:01:23.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2026-02-01T12:01:23.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-02-01T12:01:23.000000Z&quot;
        },
        {
            &quot;id&quot;: 12,
            &quot;name&quot;: &quot;typing service&quot;,
            &quot;code&quot;: &quot;ts&quot;,
            &quot;note&quot;: null,
            &quot;status&quot;: true,
            &quot;type&quot;: 1,
            &quot;settings&quot;: null,
            &quot;created_by&quot;: null,
            &quot;updated_by&quot;: null,
            &quot;created_by_name&quot;: null,
            &quot;updated_by_name&quot;: null,
            &quot;total_amount&quot;: 135.6,
            &quot;govt_fee&quot;: 60,
            &quot;center_fee&quot;: 72,
            &quot;service_charge&quot;: 0,
            &quot;tax&quot;: 3.6,
            &quot;is_taxable&quot;: false,
            &quot;lines&quot;: [
                {
                    &quot;id&quot;: 33,
                    &quot;ledger_account_id&quot;: 22,
                    &quot;ledger_name&quot;: &quot;noqodi&quot;,
                    &quot;invoice_service_id&quot;: 12,
                    &quot;amount_debit&quot;: null,
                    &quot;amount_credit&quot;: &quot;60.00&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;
                },
                {
                    &quot;id&quot;: 34,
                    &quot;ledger_account_id&quot;: 20,
                    &quot;ledger_name&quot;: &quot;credit card&quot;,
                    &quot;invoice_service_id&quot;: 12,
                    &quot;amount_debit&quot;: null,
                    &quot;amount_credit&quot;: &quot;75.60&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;
                },
                {
                    &quot;id&quot;: 35,
                    &quot;ledger_account_id&quot;: 30,
                    &quot;ledger_name&quot;: &quot;Mohre Cash back receivable&quot;,
                    &quot;invoice_service_id&quot;: 12,
                    &quot;amount_debit&quot;: &quot;75.60&quot;,
                    &quot;amount_credit&quot;: null,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;
                },
                {
                    &quot;id&quot;: 36,
                    &quot;ledger_account_id&quot;: 19,
                    &quot;ledger_name&quot;: &quot;typing profit&quot;,
                    &quot;invoice_service_id&quot;: 12,
                    &quot;amount_debit&quot;: null,
                    &quot;amount_credit&quot;: &quot;72.00&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;
                },
                {
                    &quot;id&quot;: 37,
                    &quot;ledger_account_id&quot;: 10,
                    &quot;ledger_name&quot;: &quot;VAT&quot;,
                    &quot;invoice_service_id&quot;: 12,
                    &quot;amount_debit&quot;: null,
                    &quot;amount_credit&quot;: &quot;3.60&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: null,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-02-01T11:51:10.000000Z&quot;
        },
        {
            &quot;id&quot;: 11,
            &quot;name&quot;: &quot;Change status&quot;,
            &quot;code&quot;: &quot;n&quot;,
            &quot;note&quot;: &quot;g&quot;,
            &quot;status&quot;: true,
            &quot;type&quot;: 3,
            &quot;settings&quot;: null,
            &quot;created_by&quot;: null,
            &quot;updated_by&quot;: null,
            &quot;created_by_name&quot;: null,
            &quot;updated_by_name&quot;: null,
            &quot;total_amount&quot;: 611.89,
            &quot;govt_fee&quot;: 535.75,
            &quot;center_fee&quot;: 72.51,
            &quot;service_charge&quot;: 0,
            &quot;tax&quot;: 3.63,
            &quot;is_taxable&quot;: false,
            &quot;lines&quot;: [
                {
                    &quot;id&quot;: 28,
                    &quot;ledger_account_id&quot;: 30,
                    &quot;ledger_name&quot;: &quot;Mohre Cash back receivable&quot;,
                    &quot;invoice_service_id&quot;: 11,
                    &quot;amount_debit&quot;: &quot;76.14&quot;,
                    &quot;amount_credit&quot;: &quot;0.00&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: &quot;m&quot;,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-01-31T14:42:18.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
                },
                {
                    &quot;id&quot;: 29,
                    &quot;ledger_account_id&quot;: 20,
                    &quot;ledger_name&quot;: &quot;credit card&quot;,
                    &quot;invoice_service_id&quot;: 11,
                    &quot;amount_debit&quot;: &quot;0.00&quot;,
                    &quot;amount_credit&quot;: &quot;76.14&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: &quot;m&quot;,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-01-31T14:42:18.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
                },
                {
                    &quot;id&quot;: 30,
                    &quot;ledger_account_id&quot;: 19,
                    &quot;ledger_name&quot;: &quot;typing profit&quot;,
                    &quot;invoice_service_id&quot;: 11,
                    &quot;amount_debit&quot;: &quot;0.00&quot;,
                    &quot;amount_credit&quot;: &quot;72.51&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: &quot;m&quot;,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-01-31T14:42:18.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
                },
                {
                    &quot;id&quot;: 31,
                    &quot;ledger_account_id&quot;: 10,
                    &quot;ledger_name&quot;: &quot;VAT&quot;,
                    &quot;invoice_service_id&quot;: 11,
                    &quot;amount_debit&quot;: &quot;0.00&quot;,
                    &quot;amount_credit&quot;: &quot;3.63&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: &quot;m&quot;,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-01-31T14:42:18.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
                },
                {
                    &quot;id&quot;: 32,
                    &quot;ledger_account_id&quot;: 22,
                    &quot;ledger_name&quot;: &quot;noqodi&quot;,
                    &quot;invoice_service_id&quot;: 11,
                    &quot;amount_debit&quot;: &quot;0.00&quot;,
                    &quot;amount_credit&quot;: &quot;535.75&quot;,
                    &quot;vatable&quot;: false,
                    &quot;note&quot;: &quot;m&quot;,
                    &quot;source_amount&quot;: 1,
                    &quot;created_at&quot;: &quot;2026-01-31T14:42:18.000000Z&quot;,
                    &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
                }
            ],
            &quot;created_at&quot;: &quot;2026-01-31T14:24:13.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://74.162.89.93/api/invoice-services?page=1&quot;,
        &quot;last&quot;: &quot;http://74.162.89.93/api/invoice-services?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 1,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://74.162.89.93/api/invoice-services?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://74.162.89.93/api/invoice-services&quot;,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 4,
        &quot;total&quot;: 4
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-invoice-services" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-invoice-services"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-invoice-services"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-invoice-services" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-invoice-services">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-invoice-services" data-method="GET"
      data-path="api/invoice-services"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-invoice-services', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-invoice-services"
                    onclick="tryItOut('GETapi-invoice-services');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-invoice-services"
                    onclick="cancelTryOut('GETapi-invoice-services');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-invoice-services"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/invoice-services</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-invoice-services"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-invoice-services"
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
                              name="Accept"                data-endpoint="GETapi-invoice-services"
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
               step="any"               name="per_page"                data-endpoint="GETapi-invoice-services"
               value="15"
               data-component="query">
    <br>
<p>Number of items per page. Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-invoice-services"
               value="created_at"
               data-component="query">
    <br>
<p>Field to sort by. Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-invoice-services"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction. Example: <code>desc</code></p>
            </div>
                </form>

                    <h2 id="invoice-services-POSTapi-invoice-services">Create Invoice Service</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Store a newly created resource in storage.</p>

<span id="example-requests-POSTapi-invoice-services">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://74.162.89.93/api/invoice-services" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"b\",
    \"code\": \"n\",
    \"note\": \"g\",
    \"status\": true,
    \"type\": \"1\",
    \"lines\": [
        {
            \"ledger_account_id\": 16,
            \"amount_debit\": 39,
            \"amount_credit\": 84,
            \"vatable\": true,
            \"note\": \"z\",
            \"source_amount\": \"2\"
        }
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/invoice-services"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "b",
    "code": "n",
    "note": "g",
    "status": true,
    "type": "1",
    "lines": [
        {
            "ledger_account_id": 16,
            "amount_debit": 39,
            "amount_credit": 84,
            "vatable": true,
            "note": "z",
            "source_amount": "2"
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-invoice-services"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="type"                data-endpoint="POSTapi-invoice-services"
               value="1"
               data-component="body">
    <br>
<p>Example: <code>1</code></p>
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
               value="2"
               data-component="body">
    <br>
<p>Example: <code>2</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>2</code></li></ul>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="invoice-services-GETapi-invoice-services--id-">Get Invoice Service</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Display the specified resource.</p>

<span id="example-requests-GETapi-invoice-services--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/invoice-services/11" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/invoice-services/11"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-invoice-services--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 11,
        &quot;name&quot;: &quot;Change status&quot;,
        &quot;code&quot;: &quot;n&quot;,
        &quot;note&quot;: &quot;g&quot;,
        &quot;status&quot;: true,
        &quot;type&quot;: 3,
        &quot;settings&quot;: null,
        &quot;created_by&quot;: null,
        &quot;updated_by&quot;: null,
        &quot;created_by_name&quot;: null,
        &quot;updated_by_name&quot;: null,
        &quot;total_amount&quot;: 611.89,
        &quot;govt_fee&quot;: 535.75,
        &quot;center_fee&quot;: 72.51,
        &quot;service_charge&quot;: 0,
        &quot;tax&quot;: 3.63,
        &quot;is_taxable&quot;: false,
        &quot;lines&quot;: [
            {
                &quot;id&quot;: 28,
                &quot;ledger_account_id&quot;: 30,
                &quot;ledger_name&quot;: &quot;Mohre Cash back receivable&quot;,
                &quot;invoice_service_id&quot;: 11,
                &quot;amount_debit&quot;: &quot;76.14&quot;,
                &quot;amount_credit&quot;: &quot;0.00&quot;,
                &quot;vatable&quot;: false,
                &quot;note&quot;: &quot;m&quot;,
                &quot;source_amount&quot;: 1,
                &quot;created_at&quot;: &quot;2026-01-31T14:42:18.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
            },
            {
                &quot;id&quot;: 29,
                &quot;ledger_account_id&quot;: 20,
                &quot;ledger_name&quot;: &quot;credit card&quot;,
                &quot;invoice_service_id&quot;: 11,
                &quot;amount_debit&quot;: &quot;0.00&quot;,
                &quot;amount_credit&quot;: &quot;76.14&quot;,
                &quot;vatable&quot;: false,
                &quot;note&quot;: &quot;m&quot;,
                &quot;source_amount&quot;: 1,
                &quot;created_at&quot;: &quot;2026-01-31T14:42:18.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
            },
            {
                &quot;id&quot;: 30,
                &quot;ledger_account_id&quot;: 19,
                &quot;ledger_name&quot;: &quot;typing profit&quot;,
                &quot;invoice_service_id&quot;: 11,
                &quot;amount_debit&quot;: &quot;0.00&quot;,
                &quot;amount_credit&quot;: &quot;72.51&quot;,
                &quot;vatable&quot;: false,
                &quot;note&quot;: &quot;m&quot;,
                &quot;source_amount&quot;: 1,
                &quot;created_at&quot;: &quot;2026-01-31T14:42:18.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
            },
            {
                &quot;id&quot;: 31,
                &quot;ledger_account_id&quot;: 10,
                &quot;ledger_name&quot;: &quot;VAT&quot;,
                &quot;invoice_service_id&quot;: 11,
                &quot;amount_debit&quot;: &quot;0.00&quot;,
                &quot;amount_credit&quot;: &quot;3.63&quot;,
                &quot;vatable&quot;: false,
                &quot;note&quot;: &quot;m&quot;,
                &quot;source_amount&quot;: 1,
                &quot;created_at&quot;: &quot;2026-01-31T14:42:18.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
            },
            {
                &quot;id&quot;: 32,
                &quot;ledger_account_id&quot;: 22,
                &quot;ledger_name&quot;: &quot;noqodi&quot;,
                &quot;invoice_service_id&quot;: 11,
                &quot;amount_debit&quot;: &quot;0.00&quot;,
                &quot;amount_credit&quot;: &quot;535.75&quot;,
                &quot;vatable&quot;: false,
                &quot;note&quot;: &quot;m&quot;,
                &quot;source_amount&quot;: 1,
                &quot;created_at&quot;: &quot;2026-01-31T14:42:18.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
            }
        ],
        &quot;created_at&quot;: &quot;2026-01-31T14:24:13.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2026-02-03T12:13:13.000000Z&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-invoice-services--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-invoice-services--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-invoice-services--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-invoice-services--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-invoice-services--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-invoice-services--id-" data-method="GET"
      data-path="api/invoice-services/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-invoice-services--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-invoice-services--id-"
                    onclick="tryItOut('GETapi-invoice-services--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-invoice-services--id-"
                    onclick="cancelTryOut('GETapi-invoice-services--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-invoice-services--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/invoice-services/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-invoice-services--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-invoice-services--id-"
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
                              name="Accept"                data-endpoint="GETapi-invoice-services--id-"
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
               step="any"               name="id"                data-endpoint="GETapi-invoice-services--id-"
               value="11"
               data-component="url">
    <br>
<p>The ID of the invoice service. Example: <code>11</code></p>
            </div>
                    </form>

                    <h2 id="invoice-services-PUTapi-invoice-services--id-">Update Invoice Service</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Update the specified resource in storage.</p>

<span id="example-requests-PUTapi-invoice-services--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://74.162.89.93/api/invoice-services/11" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"b\",
    \"code\": \"n\",
    \"note\": \"g\",
    \"status\": false,
    \"type\": \"3\",
    \"lines\": [
        {
            \"ledger_account_id\": 16,
            \"amount_debit\": 39,
            \"amount_credit\": 84,
            \"vatable\": true,
            \"note\": \"z\",
            \"source_amount\": \"2\"
        }
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/invoice-services/11"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "b",
    "code": "n",
    "note": "g",
    "status": false,
    "type": "3",
    "lines": [
        {
            "ledger_account_id": 16,
            "amount_debit": 39,
            "amount_credit": 84,
            "vatable": true,
            "note": "z",
            "source_amount": "2"
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-invoice-services--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-invoice-services--id-"
               value="11"
               data-component="url">
    <br>
<p>The ID of the invoice service. Example: <code>11</code></p>
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
               value="3"
               data-component="body">
    <br>
<p>Example: <code>3</code></p>
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
               value="2"
               data-component="body">
    <br>
<p>Example: <code>2</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>1</code></li> <li><code>2</code></li></ul>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="invoice-services-DELETEapi-invoice-services--id-">Delete Invoice Service</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Remove the specified resource from storage.</p>

<span id="example-requests-DELETEapi-invoice-services--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://74.162.89.93/api/invoice-services/11" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/invoice-services/11"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-invoice-services--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-invoice-services--id-"
               value="11"
               data-component="url">
    <br>
<p>The ID of the invoice service. Example: <code>11</code></p>
            </div>
                    </form>

                <h1 id="journal-entries">Journal Entries</h1>

    <p>APIs for managing journal entries (headers) with nested transaction lines.</p>

                                <h2 id="journal-entries-GETapi-journals">List all journal entries</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get a paginated list of journal entries with optional filtering and sorting.</p>

<span id="example-requests-GETapi-journals">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/journals?per_page=20&amp;sort_by=posting_date&amp;sort_direction=desc&amp;status=DRAFT&amp;posting_date_from=2026-01-01&amp;posting_date_to=2026-01-31&amp;source_type=App%5CModels%5CInvoice&amp;source_id=123&amp;created_by=1&amp;posted_by=1&amp;created_from=2026-01-01&amp;created_to=2026-01-31&amp;search=payment" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/journals"
);

const params = {
    "per_page": "20",
    "sort_by": "posting_date",
    "sort_direction": "desc",
    "status": "DRAFT",
    "posting_date_from": "2026-01-01",
    "posting_date_to": "2026-01-31",
    "source_type": "App\Models\Invoice",
    "source_id": "123",
    "created_by": "1",
    "posted_by": "1",
    "created_from": "2026-01-01",
    "created_to": "2026-01-31",
    "search": "payment",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-journals">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://74.162.89.93/api/journals?page=1&quot;,
        &quot;last&quot;: &quot;http://74.162.89.93/api/journals?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: null,
        &quot;last_page&quot;: 1,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://74.162.89.93/api/journals?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://74.162.89.93/api/journals&quot;,
        &quot;per_page&quot;: 20,
        &quot;to&quot;: null,
        &quot;total&quot;: 0
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-journals" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-journals"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-journals"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-journals" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-journals">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-journals" data-method="GET"
      data-path="api/journals"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-journals', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-journals"
                    onclick="tryItOut('GETapi-journals');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-journals"
                    onclick="cancelTryOut('GETapi-journals');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-journals"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/journals</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-journals"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-journals"
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
                              name="Accept"                data-endpoint="GETapi-journals"
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
               step="any"               name="per_page"                data-endpoint="GETapi-journals"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-journals"
               value="posting_date"
               data-component="query">
    <br>
<p>Field to sort by (id, posting_date, status, total_debit, total_credit, created_at, updated_at, posted_at). Example: <code>posting_date</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-journals"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction (asc or desc). Example: <code>desc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="GETapi-journals"
               value="DRAFT"
               data-component="query">
    <br>
<p>Filter by status. Example: <code>DRAFT</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>posting_date_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="posting_date_from"                data-endpoint="GETapi-journals"
               value="2026-01-01"
               data-component="query">
    <br>
<p>date Filter from posting date (Y-m-d). Example: <code>2026-01-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>posting_date_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="posting_date_to"                data-endpoint="GETapi-journals"
               value="2026-01-31"
               data-component="query">
    <br>
<p>date Filter to posting date (Y-m-d). Example: <code>2026-01-31</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>source_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="source_type"                data-endpoint="GETapi-journals"
               value="App\Models\Invoice"
               data-component="query">
    <br>
<p>Filter by source type. Example: <code>App\Models\Invoice</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>source_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="source_id"                data-endpoint="GETapi-journals"
               value="123"
               data-component="query">
    <br>
<p>Filter by source ID. Example: <code>123</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>created_by</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="created_by"                data-endpoint="GETapi-journals"
               value="1"
               data-component="query">
    <br>
<p>Filter by creator user ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>posted_by</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="posted_by"                data-endpoint="GETapi-journals"
               value="1"
               data-component="query">
    <br>
<p>Filter by poster user ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>created_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="created_from"                data-endpoint="GETapi-journals"
               value="2026-01-01"
               data-component="query">
    <br>
<p>date Filter from created date (Y-m-d). Example: <code>2026-01-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>created_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="created_to"                data-endpoint="GETapi-journals"
               value="2026-01-31"
               data-component="query">
    <br>
<p>date Filter to created date (Y-m-d). Example: <code>2026-01-31</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-journals"
               value="payment"
               data-component="query">
    <br>
<p>Search across notes. Example: <code>payment</code></p>
            </div>
                </form>

                    <h2 id="journal-entries-POSTapi-journals">Create a new journal entry</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Store a newly created journal entry with nested transaction lines.</p>

<span id="example-requests-POSTapi-journals">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://74.162.89.93/api/journals" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/journals"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-journals"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
                        <b style="line-height: 2;"><code>candidate_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.candidate_id"                data-endpoint="POSTapi-journals"
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

                    <h2 id="journal-entries-GETapi-journals--id-">Get a specific journal entry</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Display the details of a specific journal entry with nested lines.</p>

<span id="example-requests-GETapi-journals--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/journals/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/journals/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-journals--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Journal entry not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-journals--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-journals--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-journals--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-journals--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-journals--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-journals--id-" data-method="GET"
      data-path="api/journals/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-journals--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-journals--id-"
                    onclick="tryItOut('GETapi-journals--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-journals--id-"
                    onclick="cancelTryOut('GETapi-journals--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-journals--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/journals/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-journals--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-journals--id-"
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
                              name="Accept"                data-endpoint="GETapi-journals--id-"
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
               step="any"               name="id"                data-endpoint="GETapi-journals--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the journal entry. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="journal-entries-PUTapi-journals--id-">Update a journal entry</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Update the details of a specific journal entry and its nested lines.</p>

<span id="example-requests-PUTapi-journals--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://74.162.89.93/api/journals/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/journals/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-journals--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
                        <b style="line-height: 2;"><code>candidate_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="lines.0.candidate_id"                data-endpoint="PUTapi-journals--id-"
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
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Remove a specific journal entry and its transaction lines from the database.</p>

<span id="example-requests-DELETEapi-journals--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://74.162.89.93/api/journals/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/journals/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-journals--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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

                                <h2 id="journal-transaction-lines-GETapi-journal-tran-lines">List journal transaction lines</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get a paginated list of journal transaction lines with optional filtering.
By default, returns lines from posted journal vouchers.</p>

<span id="example-requests-GETapi-journal-tran-lines">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/journal-tran-lines?per_page=20&amp;sort_by=created_at&amp;sort_direction=desc&amp;journal_header_id=1&amp;ledger_id=5&amp;candidate_id=10&amp;status=1&amp;only_posted=1&amp;posting_date_from=2026-01-01&amp;posting_date_to=2026-01-31&amp;type=debit&amp;search=payment" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/journal-tran-lines"
);

const params = {
    "per_page": "20",
    "sort_by": "created_at",
    "sort_direction": "desc",
    "journal_header_id": "1",
    "ledger_id": "5",
    "candidate_id": "10",
    "status": "1",
    "only_posted": "1",
    "posting_date_from": "2026-01-01",
    "posting_date_to": "2026-01-31",
    "type": "debit",
    "search": "payment",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-journal-tran-lines">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://74.162.89.93/api/journal-tran-lines?page=1&quot;,
        &quot;last&quot;: &quot;http://74.162.89.93/api/journal-tran-lines?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: null,
        &quot;last_page&quot;: 1,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://74.162.89.93/api/journal-tran-lines?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://74.162.89.93/api/journal-tran-lines&quot;,
        &quot;per_page&quot;: 20,
        &quot;to&quot;: null,
        &quot;total&quot;: 0
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-journal-tran-lines" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-journal-tran-lines"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-journal-tran-lines"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-journal-tran-lines" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-journal-tran-lines">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-journal-tran-lines" data-method="GET"
      data-path="api/journal-tran-lines"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-journal-tran-lines', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-journal-tran-lines"
                    onclick="tryItOut('GETapi-journal-tran-lines');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-journal-tran-lines"
                    onclick="cancelTryOut('GETapi-journal-tran-lines');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-journal-tran-lines"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/journal-tran-lines</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-journal-tran-lines"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-journal-tran-lines"
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
                              name="Accept"                data-endpoint="GETapi-journal-tran-lines"
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
               step="any"               name="per_page"                data-endpoint="GETapi-journal-tran-lines"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-journal-tran-lines"
               value="created_at"
               data-component="query">
    <br>
<p>Field to sort by (id, journal_header_id, ledger_id, debit, credit, created_at, updated_at). Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-journal-tran-lines"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction (asc or desc). Example: <code>desc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>journal_header_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="journal_header_id"                data-endpoint="GETapi-journal-tran-lines"
               value="1"
               data-component="query">
    <br>
<p>Filter by journal header ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ledger_id"                data-endpoint="GETapi-journal-tran-lines"
               value="5"
               data-component="query">
    <br>
<p>Filter by ledger account ID. Example: <code>5</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>candidate_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="candidate_id"                data-endpoint="GETapi-journal-tran-lines"
               value="10"
               data-component="query">
    <br>
<p>Filter by candidate/employee ID. Example: <code>10</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="status"                data-endpoint="GETapi-journal-tran-lines"
               value="1"
               data-component="query">
    <br>
<p>Filter by journal header status (0=Draft, 1=Posted, 2=Void). Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>only_posted</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-journal-tran-lines" style="display: none">
            <input type="radio" name="only_posted"
                   value="1"
                   data-endpoint="GETapi-journal-tran-lines"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-journal-tran-lines" style="display: none">
            <input type="radio" name="only_posted"
                   value="0"
                   data-endpoint="GETapi-journal-tran-lines"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filter to only include posted journal entries. Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>posting_date_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="posting_date_from"                data-endpoint="GETapi-journal-tran-lines"
               value="2026-01-01"
               data-component="query">
    <br>
<p>date Filter from posting date (Y-m-d). Example: <code>2026-01-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>posting_date_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="posting_date_to"                data-endpoint="GETapi-journal-tran-lines"
               value="2026-01-31"
               data-component="query">
    <br>
<p>date Filter to posting date (Y-m-d). Example: <code>2026-01-31</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="GETapi-journal-tran-lines"
               value="debit"
               data-component="query">
    <br>
<p>Filter by transaction type (debit or credit). Example: <code>debit</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-journal-tran-lines"
               value="payment"
               data-component="query">
    <br>
<p>Search across notes and ledger names. Example: <code>payment</code></p>
            </div>
                </form>

                <h1 id="ledger-of-accounts">Ledger of Accounts</h1>

    <p>APIs for managing ledger accounts with filtering, sorting, and pagination.</p>

                                <h2 id="ledger-of-accounts-GETapi-ledgers-lookup">Lookup ledger accounts for dropdowns</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get a simplified list of ledger accounts optimized for Select2/dropdown menus.
Returns format: {id, text, type, group}</p>

<span id="example-requests-GETapi-ledgers-lookup">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/ledgers/lookup?search=Cash&amp;type=dr&amp;group=Assets&amp;spacial=3&amp;customer=1&amp;page=1&amp;per_page=20" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/ledgers/lookup"
);

const params = {
    "search": "Cash",
    "type": "dr",
    "group": "Assets",
    "spacial": "3",
    "customer": "1",
    "page": "1",
    "per_page": "20",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-ledgers-lookup">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;results&quot;: [],
    &quot;pagination&quot;: {
        &quot;more&quot;: false,
        &quot;current_page&quot;: 1,
        &quot;total&quot;: 0
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-ledgers-lookup" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-ledgers-lookup"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-ledgers-lookup"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-ledgers-lookup" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-ledgers-lookup">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-ledgers-lookup" data-method="GET"
      data-path="api/ledgers/lookup"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-ledgers-lookup', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-ledgers-lookup"
                    onclick="tryItOut('GETapi-ledgers-lookup');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-ledgers-lookup"
                    onclick="cancelTryOut('GETapi-ledgers-lookup');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-ledgers-lookup"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/ledgers/lookup</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-ledgers-lookup"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-ledgers-lookup"
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
                              name="Accept"                data-endpoint="GETapi-ledgers-lookup"
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
                              name="search"                data-endpoint="GETapi-ledgers-lookup"
               value="Cash"
               data-component="query">
    <br>
<p>Search by account name. Example: <code>Cash</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="GETapi-ledgers-lookup"
               value="dr"
               data-component="query">
    <br>
<p>Filter by type (dr or cr). Example: <code>dr</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>group</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="group"                data-endpoint="GETapi-ledgers-lookup"
               value="Assets"
               data-component="query">
    <br>
<p>Filter by group. Example: <code>Assets</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>spacial</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="spacial"                data-endpoint="GETapi-ledgers-lookup"
               value="3"
               data-component="query">
    <br>
<p>Filter by spacial. Example: <code>3</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customer</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-ledgers-lookup" style="display: none">
            <input type="radio" name="customer"
                   value="1"
                   data-endpoint="GETapi-ledgers-lookup"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-ledgers-lookup" style="display: none">
            <input type="radio" name="customer"
                   value="0"
                   data-endpoint="GETapi-ledgers-lookup"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filter for customers (spacial=3). Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-ledgers-lookup"
               value="1"
               data-component="query">
    <br>
<p>Page number for pagination. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-ledgers-lookup"
               value="20"
               data-component="query">
    <br>
<p>Items per page (max 50). Example: <code>20</code></p>
            </div>
                </form>

                    <h2 id="ledger-of-accounts-GETapi-ledgers-lookup-customers">Lookup customers with CRM search</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Specialized lookup for customers that searches in CRM fields (mobile, etc).</p>

<span id="example-requests-GETapi-ledgers-lookup-customers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/ledgers/lookup-customers?search=0501234567&amp;page=1&amp;per_page=20" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/ledgers/lookup-customers"
);

const params = {
    "search": "0501234567",
    "page": "1",
    "per_page": "20",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-ledgers-lookup-customers">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;results&quot;: [],
    &quot;pagination&quot;: {
        &quot;more&quot;: false,
        &quot;current_page&quot;: 1,
        &quot;total&quot;: 0
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-ledgers-lookup-customers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-ledgers-lookup-customers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-ledgers-lookup-customers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-ledgers-lookup-customers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-ledgers-lookup-customers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-ledgers-lookup-customers" data-method="GET"
      data-path="api/ledgers/lookup-customers"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-ledgers-lookup-customers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-ledgers-lookup-customers"
                    onclick="tryItOut('GETapi-ledgers-lookup-customers');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-ledgers-lookup-customers"
                    onclick="cancelTryOut('GETapi-ledgers-lookup-customers');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-ledgers-lookup-customers"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/ledgers/lookup-customers</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-ledgers-lookup-customers"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-ledgers-lookup-customers"
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
                              name="Accept"                data-endpoint="GETapi-ledgers-lookup-customers"
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
                              name="search"                data-endpoint="GETapi-ledgers-lookup-customers"
               value="0501234567"
               data-component="query">
    <br>
<p>Search by name, mobile, CL number. Example: <code>0501234567</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-ledgers-lookup-customers"
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
               step="any"               name="per_page"                data-endpoint="GETapi-ledgers-lookup-customers"
               value="20"
               data-component="query">
    <br>
<p>Items per page. Example: <code>20</code></p>
            </div>
                </form>

                    <h2 id="ledger-of-accounts-GETapi-ledgers-export">Export all ledger accounts to Excel</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Download all ledger accounts as an Excel (.xlsx) file.</p>

<span id="example-requests-GETapi-ledgers-export">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/ledgers/export" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/ledgers/export"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-ledgers-export">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: public
content-disposition: attachment; filename=ledger_of_accounts.xlsx
content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
accept-ranges: bytes
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;"></code>
 </pre>
    </span>
<span id="execution-results-GETapi-ledgers-export" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-ledgers-export"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-ledgers-export"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-ledgers-export" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-ledgers-export">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-ledgers-export" data-method="GET"
      data-path="api/ledgers/export"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-ledgers-export', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-ledgers-export"
                    onclick="tryItOut('GETapi-ledgers-export');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-ledgers-export"
                    onclick="cancelTryOut('GETapi-ledgers-export');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-ledgers-export"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/ledgers/export</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-ledgers-export"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-ledgers-export"
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
                              name="Accept"                data-endpoint="GETapi-ledgers-export"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="ledger-of-accounts-GETapi-ledgers">List all ledger accounts</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get a paginated list of ledger accounts with optional filtering and sorting.</p>

<span id="example-requests-GETapi-ledgers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/ledgers?per_page=20&amp;sort_by=name&amp;sort_direction=asc&amp;name=Cash&amp;class=1&amp;sub_class=1&amp;group=Assets&amp;spacial=1&amp;type=dr&amp;created_by=1&amp;created_from=2025-01-01&amp;created_to=2026-01-31&amp;search=cash" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/ledgers"
);

const params = {
    "per_page": "20",
    "sort_by": "name",
    "sort_direction": "asc",
    "name": "Cash",
    "class": "1",
    "sub_class": "1",
    "group": "Assets",
    "spacial": "1",
    "type": "dr",
    "created_by": "1",
    "created_from": "2025-01-01",
    "created_to": "2026-01-31",
    "search": "cash",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-ledgers">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://74.162.89.93/api/ledgers?page=1&quot;,
        &quot;last&quot;: &quot;http://74.162.89.93/api/ledgers?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: null,
        &quot;last_page&quot;: 1,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://74.162.89.93/api/ledgers?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://74.162.89.93/api/ledgers&quot;,
        &quot;per_page&quot;: 20,
        &quot;to&quot;: null,
        &quot;total&quot;: 0
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-ledgers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-ledgers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-ledgers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-ledgers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-ledgers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-ledgers" data-method="GET"
      data-path="api/ledgers"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-ledgers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-ledgers"
                    onclick="tryItOut('GETapi-ledgers');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-ledgers"
                    onclick="cancelTryOut('GETapi-ledgers');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-ledgers"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/ledgers</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-ledgers"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-ledgers"
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
                              name="Accept"                data-endpoint="GETapi-ledgers"
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
               step="any"               name="per_page"                data-endpoint="GETapi-ledgers"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-ledgers"
               value="name"
               data-component="query">
    <br>
<p>Field to sort by. Example: <code>name</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-ledgers"
               value="asc"
               data-component="query">
    <br>
<p>Sort direction (asc or desc). Example: <code>asc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="GETapi-ledgers"
               value="Cash"
               data-component="query">
    <br>
<p>Filter by name (partial match). Example: <code>Cash</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>class</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="class"                data-endpoint="GETapi-ledgers"
               value="1"
               data-component="query">
    <br>
<p>Filter by class. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sub_class</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="sub_class"                data-endpoint="GETapi-ledgers"
               value="1"
               data-component="query">
    <br>
<p>Filter by sub-class. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>group</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="group"                data-endpoint="GETapi-ledgers"
               value="Assets"
               data-component="query">
    <br>
<p>Filter by group. Example: <code>Assets</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>spacial</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="spacial"                data-endpoint="GETapi-ledgers"
               value="1"
               data-component="query">
    <br>
<p>Filter by spacial. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="GETapi-ledgers"
               value="dr"
               data-component="query">
    <br>
<p>Filter by type (dr or cr). Example: <code>dr</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>created_by</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="created_by"                data-endpoint="GETapi-ledgers"
               value="1"
               data-component="query">
    <br>
<p>Filter by creator user ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>created_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="created_from"                data-endpoint="GETapi-ledgers"
               value="2025-01-01"
               data-component="query">
    <br>
<p>date Filter from date (Y-m-d). Example: <code>2025-01-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>created_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="created_to"                data-endpoint="GETapi-ledgers"
               value="2026-01-31"
               data-component="query">
    <br>
<p>date Filter to date (Y-m-d). Example: <code>2026-01-31</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-ledgers"
               value="cash"
               data-component="query">
    <br>
<p>Search across name, group, and note. Example: <code>cash</code></p>
            </div>
                </form>

                    <h2 id="ledger-of-accounts-POSTapi-ledgers">Create a new ledger account</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Store a newly created ledger account in the database.</p>

<span id="example-requests-POSTapi-ledgers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://74.162.89.93/api/ledgers" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/ledgers"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-ledgers"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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

                    <h2 id="ledger-of-accounts-GETapi-ledgers--id-">Get a specific ledger account</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Display the details of a specific ledger account.</p>

<span id="example-requests-GETapi-ledgers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/ledgers/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/ledgers/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-ledgers--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Ledger account not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-ledgers--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-ledgers--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-ledgers--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-ledgers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-ledgers--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-ledgers--id-" data-method="GET"
      data-path="api/ledgers/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-ledgers--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-ledgers--id-"
                    onclick="tryItOut('GETapi-ledgers--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-ledgers--id-"
                    onclick="cancelTryOut('GETapi-ledgers--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-ledgers--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/ledgers/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-ledgers--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-ledgers--id-"
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
                              name="Accept"                data-endpoint="GETapi-ledgers--id-"
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
               step="any"               name="id"                data-endpoint="GETapi-ledgers--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the ledger account. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="ledger-of-accounts-PUTapi-ledgers--id-">Update a ledger account</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Update the details of a specific ledger account.</p>

<span id="example-requests-PUTapi-ledgers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://74.162.89.93/api/ledgers/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/ledgers/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-ledgers--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Remove a specific ledger account from the database.</p>

<span id="example-requests-DELETEapi-ledgers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://74.162.89.93/api/ledgers/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/ledgers/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-ledgers--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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

                <h1 id="package-one">Package One</h1>

    <p>APIs for creating Package One journal entries (financial impact only).
Invoices are created separately via InvoiceController.</p>

                                <h2 id="package-one-POSTapi-package-one-received-voucher">Create Received Voucher for Package One</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Create a receipt voucher for Package One, linked to an Invoice as source.
The customer's ledger account is used as the credit side, and the provided
debit_ledger_id is used as the debit side (e.g., Cash/Bank).</p>

<span id="example-requests-POSTapi-package-one-received-voucher">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://74.162.89.93/api/package-one/received-voucher" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/package-one/received-voucher"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-package-one-received-voucher"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Create a credit note that reverses the original journal entries for an invoice.
The original debit becomes credit and vice versa. The invoice will be marked as refunded.</p>

<span id="example-requests-POSTapi-package-one-credit-note">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://74.162.89.93/api/package-one/credit-note" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"invoice_id\": 1
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/package-one/credit-note"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-package-one-credit-note"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Create a charging journal entry with custom lines (ledger_id with debit/credit amounts).
The invoice is referenced as the source.</p>

<span id="example-requests-POSTapi-package-one-charging">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://74.162.89.93/api/package-one/charging" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/package-one/charging"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-package-one-charging"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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

                    <h2 id="package-one-GETapi-package-one">List Package One Journal Entries</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get a paginated list of Package One journal entries.</p>

<span id="example-requests-GETapi-package-one">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/package-one?per_page=20&amp;sort_by=id&amp;sort_direction=desc&amp;cn_number=CN-2026&amp;search=PKG" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/package-one"
);

const params = {
    "per_page": "20",
    "sort_by": "id",
    "sort_direction": "desc",
    "cn_number": "CN-2026",
    "search": "PKG",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-package-one">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://74.162.89.93/api/package-one?page=1&quot;,
        &quot;last&quot;: &quot;http://74.162.89.93/api/package-one?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: null,
        &quot;last_page&quot;: 1,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://74.162.89.93/api/package-one?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://74.162.89.93/api/package-one&quot;,
        &quot;per_page&quot;: 20,
        &quot;to&quot;: null,
        &quot;total&quot;: 0
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-package-one" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-package-one"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-package-one"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-package-one" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-package-one">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-package-one" data-method="GET"
      data-path="api/package-one"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-package-one', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-package-one"
                    onclick="tryItOut('GETapi-package-one');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-package-one"
                    onclick="cancelTryOut('GETapi-package-one');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-package-one"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/package-one</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-package-one"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-package-one"
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
                              name="Accept"                data-endpoint="GETapi-package-one"
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
               step="any"               name="per_page"                data-endpoint="GETapi-package-one"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-package-one"
               value="id"
               data-component="query">
    <br>
<p>Field to sort by. Example: <code>id</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-package-one"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction (asc or desc). Example: <code>desc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>cn_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="cn_number"                data-endpoint="GETapi-package-one"
               value="CN-2026"
               data-component="query">
    <br>
<p>Filter by CN Number. Example: <code>CN-2026</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-package-one"
               value="PKG"
               data-component="query">
    <br>
<p>Search in note or CN_Number. Example: <code>PKG</code></p>
            </div>
                </form>

                    <h2 id="package-one-POSTapi-package-one">Create Package One Journal Entry</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Create journal entries for Package One (financial impact only).
The cn_number will be stored in all journal transaction lines.
Invoice creation is handled separately via InvoiceController.</p>

<span id="example-requests-POSTapi-package-one">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://74.162.89.93/api/package-one" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/package-one"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-package-one"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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

                    <h2 id="package-one-GETapi-package-one--id-">Get Package One Journal Entry</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Display a specific Package One journal entry.</p>

<span id="example-requests-GETapi-package-one--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/package-one/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/package-one/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-package-one--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Journal entry not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-package-one--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-package-one--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-package-one--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-package-one--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-package-one--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-package-one--id-" data-method="GET"
      data-path="api/package-one/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-package-one--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-package-one--id-"
                    onclick="tryItOut('GETapi-package-one--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-package-one--id-"
                    onclick="cancelTryOut('GETapi-package-one--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-package-one--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/package-one/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-package-one--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-package-one--id-"
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
                              name="Accept"                data-endpoint="GETapi-package-one--id-"
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
               step="any"               name="id"                data-endpoint="GETapi-package-one--id-"
               value="1"
               data-component="url">
    <br>
<p>The journal ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="package-one-DELETEapi-package-one--id-">Delete Package One Journal Entry</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Delete a Package One journal entry and its lines.</p>

<span id="example-requests-DELETEapi-package-one--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://74.162.89.93/api/package-one/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/package-one/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-package-one--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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

                                <h2 id="receipt-vouchers-GETapi-receipt-vouchers">List all receipt vouchers</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get a paginated list of receipt vouchers with optional filtering and sorting.</p>

<span id="example-requests-GETapi-receipt-vouchers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/receipt-vouchers?limit=20&amp;sort_by=created_at&amp;sort_desc=true&amp;search=RV-000001&amp;status=posted" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/receipt-vouchers"
);

const params = {
    "limit": "20",
    "sort_by": "created_at",
    "sort_desc": "true",
    "search": "RV-000001",
    "status": "posted",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-receipt-vouchers">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://74.162.89.93/api/receipt-vouchers?page=1&quot;,
        &quot;last&quot;: &quot;http://74.162.89.93/api/receipt-vouchers?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: null,
        &quot;last_page&quot;: 1,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://74.162.89.93/api/receipt-vouchers?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://74.162.89.93/api/receipt-vouchers&quot;,
        &quot;per_page&quot;: 20,
        &quot;to&quot;: null,
        &quot;total&quot;: 0
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-receipt-vouchers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-receipt-vouchers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-receipt-vouchers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-receipt-vouchers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-receipt-vouchers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-receipt-vouchers" data-method="GET"
      data-path="api/receipt-vouchers"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-receipt-vouchers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-receipt-vouchers"
                    onclick="tryItOut('GETapi-receipt-vouchers');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-receipt-vouchers"
                    onclick="cancelTryOut('GETapi-receipt-vouchers');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-receipt-vouchers"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/receipt-vouchers</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-receipt-vouchers"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-receipt-vouchers"
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
                              name="Accept"                data-endpoint="GETapi-receipt-vouchers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>limit</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="limit"                data-endpoint="GETapi-receipt-vouchers"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-receipt-vouchers"
               value="created_at"
               data-component="query">
    <br>
<p>Field to sort by (id, serial_number, status, payment_mode, created_at, updated_at). Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_desc</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_desc"                data-endpoint="GETapi-receipt-vouchers"
               value="true"
               data-component="query">
    <br>
<p>Sort in descending order (true or false). Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-receipt-vouchers"
               value="RV-000001"
               data-component="query">
    <br>
<p>Search by serial number. Example: <code>RV-000001</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="GETapi-receipt-vouchers"
               value="posted"
               data-component="query">
    <br>
<p>Filter by status (draft, posted, void). Example: <code>posted</code></p>
            </div>
                </form>

                    <h2 id="receipt-vouchers-POSTapi-receipt-vouchers">Create a new receipt voucher</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Store a newly created receipt voucher with automatic journal entry creation.
The journal entry will be created with a debit to the specified debit_ledger_id
and a credit to the credit_ledger_id for the specified amount.</p>

<span id="example-requests-POSTapi-receipt-vouchers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://74.162.89.93/api/receipt-vouchers" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/receipt-vouchers"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-receipt-vouchers"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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

                    <h2 id="receipt-vouchers-GETapi-receipt-vouchers--id-">Get a specific receipt voucher</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Display the details of a specific receipt voucher with its source and journal entry.</p>

<span id="example-requests-GETapi-receipt-vouchers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/receipt-vouchers/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/receipt-vouchers/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-receipt-vouchers--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Receipt voucher not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-receipt-vouchers--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-receipt-vouchers--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-receipt-vouchers--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-receipt-vouchers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-receipt-vouchers--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-receipt-vouchers--id-" data-method="GET"
      data-path="api/receipt-vouchers/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-receipt-vouchers--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-receipt-vouchers--id-"
                    onclick="tryItOut('GETapi-receipt-vouchers--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-receipt-vouchers--id-"
                    onclick="cancelTryOut('GETapi-receipt-vouchers--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-receipt-vouchers--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/receipt-vouchers/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-receipt-vouchers--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-receipt-vouchers--id-"
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
                              name="Accept"                data-endpoint="GETapi-receipt-vouchers--id-"
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
               step="any"               name="id"                data-endpoint="GETapi-receipt-vouchers--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the receipt voucher. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="receipt-vouchers-PUTapi-receipt-vouchers--id-">Update a receipt voucher</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Update the details of a specific receipt voucher and its associated journal entry.</p>

<span id="example-requests-PUTapi-receipt-vouchers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://74.162.89.93/api/receipt-vouchers/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/receipt-vouchers/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-receipt-vouchers--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Remove a specific receipt voucher and its associated journal entry from the database.</p>

<span id="example-requests-DELETEapi-receipt-vouchers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://74.162.89.93/api/receipt-vouchers/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/receipt-vouchers/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-receipt-vouchers--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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

                <h1 id="statement-of-account">Statement of Account</h1>

    <p>APIs for retrieving statement of account for a ledger.</p>

                                <h2 id="statement-of-account-GETapi-statement-of-account--ledger_id-">Get Statement of Account</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Retrieve the statement of account for a specific ledger. Returns all posted
journal transaction lines with debit, credit, running balance, notes, and source type.</p>

<span id="example-requests-GETapi-statement-of-account--ledger_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/statement-of-account/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/statement-of-account/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-statement-of-account--ledger_id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Ledger not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-statement-of-account--ledger_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-statement-of-account--ledger_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-statement-of-account--ledger_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-statement-of-account--ledger_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-statement-of-account--ledger_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-statement-of-account--ledger_id-" data-method="GET"
      data-path="api/statement-of-account/{ledger_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-statement-of-account--ledger_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-statement-of-account--ledger_id-"
                    onclick="tryItOut('GETapi-statement-of-account--ledger_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-statement-of-account--ledger_id-"
                    onclick="cancelTryOut('GETapi-statement-of-account--ledger_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-statement-of-account--ledger_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/statement-of-account/{ledger_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-statement-of-account--ledger_id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-statement-of-account--ledger_id-"
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
                              name="Accept"                data-endpoint="GETapi-statement-of-account--ledger_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ledger_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ledger_id"                data-endpoint="GETapi-statement-of-account--ledger_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the ledger. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="trial-balance">Trial Balance</h1>

    <p>APIs for retrieving trial balance report data.</p>

                                <h2 id="trial-balance-GETapi-trial-balance">Get Trial Balance</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Retrieve a trial balance report with ledger accounts organized by class, group, and sub-class.
Each ledger shows total debits, total credits, closing balance, and balance type (DR/CR).
Ledgers with zero closing balance are excluded.</p>

<span id="example-requests-GETapi-trial-balance">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/trial-balance?posting_date_from=2026-01-01&amp;posting_date_to=2026-01-31&amp;spacial=3" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/trial-balance"
);

const params = {
    "posting_date_from": "2026-01-01",
    "posting_date_to": "2026-01-31",
    "spacial": "3",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-trial-balance">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [],
    &quot;summary&quot;: {
        &quot;total_dr&quot;: &quot;0.00&quot;,
        &quot;total_cr&quot;: &quot;0.00&quot;,
        &quot;is_balanced&quot;: true
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-trial-balance" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-trial-balance"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-trial-balance"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-trial-balance" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-trial-balance">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-trial-balance" data-method="GET"
      data-path="api/trial-balance"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-trial-balance', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-trial-balance"
                    onclick="tryItOut('GETapi-trial-balance');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-trial-balance"
                    onclick="cancelTryOut('GETapi-trial-balance');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-trial-balance"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/trial-balance</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-trial-balance"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-trial-balance"
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
                              name="Accept"                data-endpoint="GETapi-trial-balance"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>posting_date_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="posting_date_from"                data-endpoint="GETapi-trial-balance"
               value="2026-01-01"
               data-component="query">
    <br>
<p>date Filter from posting date (Y-m-d). Example: <code>2026-01-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>posting_date_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="posting_date_to"                data-endpoint="GETapi-trial-balance"
               value="2026-01-31"
               data-component="query">
    <br>
<p>date Filter to posting date (Y-m-d). Example: <code>2026-01-31</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>spacial</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="spacial"                data-endpoint="GETapi-trial-balance"
               value="3"
               data-component="query">
    <br>
<p>Filter by spacial type (e.g., 3 for Customer). Example: <code>3</code></p>
            </div>
                </form>

                <h1 id="typing-transaction-government-invoices">Typing Transaction Government Invoices</h1>

    <p>APIs for managing Typing Transaction Government Invoices.</p>

                                <h2 id="typing-transaction-government-invoices-POSTapi-typing-tran-gov-invs--id--receive-payment">Receive payment for a typing invoice</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Create a receipt voucher for a specific typing invoice and record the payment
with proper journal entries. This endpoint creates a ReceiptVoucher linked to
the typing invoice via polymorphic relationship and updates the amount_received.</p>

<span id="example-requests-POSTapi-typing-tran-gov-invs--id--receive-payment">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://74.162.89.93/api/typing-tran-gov-invs/1/receive-payment" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/typing-tran-gov-invs/1/receive-payment"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-typing-tran-gov-invs--id--receive-payment"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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

                    <h2 id="typing-transaction-government-invoices-GETapi-typing-tran-gov-invs">List all items</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Get a paginated list of items with optional filtering and sorting.</p>

<span id="example-requests-GETapi-typing-tran-gov-invs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/typing-tran-gov-invs?per_page=20&amp;sort_by=created_at&amp;sort_direction=desc&amp;search=GOV-INV" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/typing-tran-gov-invs"
);

const params = {
    "per_page": "20",
    "sort_by": "created_at",
    "sort_direction": "desc",
    "search": "GOV-INV",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-typing-tran-gov-invs">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 39,
            &quot;serial_no&quot;: &quot;GOV-INV-000039&quot;,
            &quot;gov_dw_no&quot;: null,
            &quot;gov_inv_attachments&quot;: [],
            &quot;maid_id&quot;: null,
            &quot;ledger_id&quot;: 21,
            &quot;ledger&quot;: {
                &quot;id&quot;: 21,
                &quot;name&quot;: &quot;the best customer&quot;,
                &quot;class&quot;: 1,
                &quot;sub_class&quot;: 1,
                &quot;group&quot;: &quot;account receivable&quot;,
                &quot;spacial&quot;: 3,
                &quot;type&quot;: &quot;dr&quot;,
                &quot;note&quot;: &quot;0565636203&quot;,
                &quot;created_by&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: null
                },
                &quot;updated_by&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: null
                },
                &quot;created_at&quot;: &quot;2026-01-11T15:27:49+04:00&quot;,
                &quot;updated_at&quot;: &quot;2026-01-11T17:58:49+04:00&quot;
            },
            &quot;customer_mobile&quot;: &quot;0565636203&quot;,
            &quot;amount_received&quot;: &quot;611.89&quot;,
            &quot;amount_of_invoice&quot;: &quot;611.89&quot;,
            &quot;services_json&quot;: [
                {
                    &quot;dw&quot;: null,
                    &quot;amount&quot;: 611.89,
                    &quot;quantity&quot;: 1,
                    &quot;total_amount&quot;: 611.89,
                    &quot;invoice_service_id&quot;: 11
                }
            ],
            &quot;payment_status&quot;: &quot;paid&quot;,
            &quot;created_at&quot;: &quot;2026-02-05T11:10:34.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-02-05T11:21:36.000000Z&quot;,
            &quot;journal&quot;: {
                &quot;id&quot;: 189,
                &quot;posting_date&quot;: &quot;2026-02-05&quot;,
                &quot;status&quot;: 1,
                &quot;status_label&quot;: &quot;Posted&quot;,
                &quot;source_type&quot;: &quot;App\\Models\\TypingTranGovInv&quot;,
                &quot;source_id&quot;: 39,
                &quot;pre_src_type&quot;: &quot;App\\Models\\InvoiceService&quot;,
                &quot;pre_src_id&quot;: 11,
                &quot;note&quot;: &quot;Generated from TypingTranGovInv #GOV-INV-000039&quot;,
                &quot;meta_json&quot;: null,
                &quot;total_debit&quot;: &quot;688.03&quot;,
                &quot;total_credit&quot;: &quot;688.03&quot;,
                &quot;created_by&quot;: 1,
                &quot;posted_by&quot;: null,
                &quot;posted_at&quot;: null,
                &quot;created_at&quot;: &quot;2026-02-05T11:10:34.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2026-02-05T11:10:34.000000Z&quot;
            }
        },
        {
            &quot;id&quot;: 38,
            &quot;serial_no&quot;: &quot;GOV-INV-000038&quot;,
            &quot;gov_dw_no&quot;: &quot;test&quot;,
            &quot;gov_inv_attachments&quot;: [],
            &quot;maid_id&quot;: null,
            &quot;ledger_id&quot;: 26,
            &quot;ledger&quot;: {
                &quot;id&quot;: 26,
                &quot;name&quot;: &quot;new customer test&quot;,
                &quot;class&quot;: 1,
                &quot;sub_class&quot;: 1,
                &quot;group&quot;: &quot;account receivable&quot;,
                &quot;spacial&quot;: 3,
                &quot;type&quot;: &quot;dr&quot;,
                &quot;note&quot;: &quot;0565636277&quot;,
                &quot;created_by&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: null
                },
                &quot;updated_by&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: null
                },
                &quot;created_at&quot;: &quot;2026-01-19T15:27:14+04:00&quot;,
                &quot;updated_at&quot;: &quot;2026-01-19T15:27:14+04:00&quot;
            },
            &quot;customer_mobile&quot;: &quot;0565636277&quot;,
            &quot;amount_received&quot;: &quot;500.00&quot;,
            &quot;amount_of_invoice&quot;: &quot;611.89&quot;,
            &quot;services_json&quot;: [
                {
                    &quot;dw&quot;: &quot;dw1213213&quot;,
                    &quot;amount&quot;: 611.89,
                    &quot;quantity&quot;: 1,
                    &quot;total_amount&quot;: 611.89,
                    &quot;invoice_service_id&quot;: 11
                }
            ],
            &quot;payment_status&quot;: &quot;partial&quot;,
            &quot;created_at&quot;: &quot;2026-02-03T12:13:36.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-02-05T11:24:53.000000Z&quot;,
            &quot;journal&quot;: {
                &quot;id&quot;: 185,
                &quot;posting_date&quot;: &quot;2026-02-03&quot;,
                &quot;status&quot;: 1,
                &quot;status_label&quot;: &quot;Posted&quot;,
                &quot;source_type&quot;: &quot;App\\Models\\TypingTranGovInv&quot;,
                &quot;source_id&quot;: 38,
                &quot;pre_src_type&quot;: &quot;App\\Models\\InvoiceService&quot;,
                &quot;pre_src_id&quot;: 11,
                &quot;note&quot;: &quot;Generated from TypingTranGovInv #GOV-INV-000038&quot;,
                &quot;meta_json&quot;: null,
                &quot;total_debit&quot;: &quot;688.03&quot;,
                &quot;total_credit&quot;: &quot;688.03&quot;,
                &quot;created_by&quot;: 1,
                &quot;posted_by&quot;: null,
                &quot;posted_at&quot;: null,
                &quot;created_at&quot;: &quot;2026-02-03T12:13:36.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2026-02-03T12:30:58.000000Z&quot;
            }
        },
        {
            &quot;id&quot;: 37,
            &quot;serial_no&quot;: &quot;GOV-INV-000001&quot;,
            &quot;gov_dw_no&quot;: null,
            &quot;gov_inv_attachments&quot;: [],
            &quot;maid_id&quot;: null,
            &quot;ledger_id&quot;: 18,
            &quot;ledger&quot;: {
                &quot;id&quot;: 18,
                &quot;name&quot;: &quot;canchetooo&quot;,
                &quot;class&quot;: 1,
                &quot;sub_class&quot;: 1,
                &quot;group&quot;: &quot;erytderyer&quot;,
                &quot;spacial&quot;: 3,
                &quot;type&quot;: &quot;dr&quot;,
                &quot;note&quot;: &quot;testtttttttttttttttt&quot;,
                &quot;created_by&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: null
                },
                &quot;updated_by&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: null
                },
                &quot;created_at&quot;: &quot;2026-01-08T19:46:57+04:00&quot;,
                &quot;updated_at&quot;: &quot;2026-01-08T19:46:57+04:00&quot;
            },
            &quot;customer_mobile&quot;: &quot;0565636222&quot;,
            &quot;amount_received&quot;: &quot;0.00&quot;,
            &quot;amount_of_invoice&quot;: &quot;611.89&quot;,
            &quot;services_json&quot;: [
                {
                    &quot;dw&quot;: null,
                    &quot;amount&quot;: 611.89,
                    &quot;quantity&quot;: 1,
                    &quot;total_amount&quot;: 611.89,
                    &quot;invoice_service_id&quot;: 11
                }
            ],
            &quot;payment_status&quot;: &quot;pending&quot;,
            &quot;created_at&quot;: &quot;2026-02-02T12:03:48.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-02-02T12:03:48.000000Z&quot;,
            &quot;journal&quot;: {
                &quot;id&quot;: 184,
                &quot;posting_date&quot;: &quot;2026-02-02&quot;,
                &quot;status&quot;: 1,
                &quot;status_label&quot;: &quot;Posted&quot;,
                &quot;source_type&quot;: &quot;App\\Models\\TypingTranGovInv&quot;,
                &quot;source_id&quot;: 37,
                &quot;pre_src_type&quot;: &quot;App\\Models\\InvoiceService&quot;,
                &quot;pre_src_id&quot;: 11,
                &quot;note&quot;: &quot;Generated from TypingTranGovInv #GOV-INV-000001&quot;,
                &quot;meta_json&quot;: null,
                &quot;total_debit&quot;: &quot;688.03&quot;,
                &quot;total_credit&quot;: &quot;688.03&quot;,
                &quot;created_by&quot;: 1,
                &quot;posted_by&quot;: null,
                &quot;posted_at&quot;: null,
                &quot;created_at&quot;: &quot;2026-02-02T12:03:48.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2026-02-02T12:03:48.000000Z&quot;
            }
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://74.162.89.93/api/typing-tran-gov-invs?page=1&quot;,
        &quot;last&quot;: &quot;http://74.162.89.93/api/typing-tran-gov-invs?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 1,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://74.162.89.93/api/typing-tran-gov-invs?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://74.162.89.93/api/typing-tran-gov-invs&quot;,
        &quot;per_page&quot;: 20,
        &quot;to&quot;: 3,
        &quot;total&quot;: 3
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-typing-tran-gov-invs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-typing-tran-gov-invs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-typing-tran-gov-invs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-typing-tran-gov-invs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-typing-tran-gov-invs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-typing-tran-gov-invs" data-method="GET"
      data-path="api/typing-tran-gov-invs"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-typing-tran-gov-invs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-typing-tran-gov-invs"
                    onclick="tryItOut('GETapi-typing-tran-gov-invs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-typing-tran-gov-invs"
                    onclick="cancelTryOut('GETapi-typing-tran-gov-invs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-typing-tran-gov-invs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/typing-tran-gov-invs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-typing-tran-gov-invs"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-typing-tran-gov-invs"
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
                              name="Accept"                data-endpoint="GETapi-typing-tran-gov-invs"
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
               step="any"               name="per_page"                data-endpoint="GETapi-typing-tran-gov-invs"
               value="20"
               data-component="query">
    <br>
<p>Number of items per page. Example: <code>20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-typing-tran-gov-invs"
               value="created_at"
               data-component="query">
    <br>
<p>Field to sort by (id, serial_no, gov_dw_no, created_at, updated_at). Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-typing-tran-gov-invs"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction (asc or desc). Example: <code>desc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-typing-tran-gov-invs"
               value="GOV-INV"
               data-component="query">
    <br>
<p>Search across serial_no and gov_dw_no. Example: <code>GOV-INV</code></p>
            </div>
                </form>

                    <h2 id="typing-transaction-government-invoices-POSTapi-typing-tran-gov-invs">Create a new item</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Store a newly created item.</p>

<span id="example-requests-POSTapi-typing-tran-gov-invs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://74.162.89.93/api/typing-tran-gov-invs" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/typing-tran-gov-invs"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-typing-tran-gov-invs"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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

                    <h2 id="typing-transaction-government-invoices-GETapi-typing-tran-gov-invs--id-">Get a specific item</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Display the details of a specific item.</p>

<span id="example-requests-GETapi-typing-tran-gov-invs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://74.162.89.93/api/typing-tran-gov-invs/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/typing-tran-gov-invs/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-typing-tran-gov-invs--id-">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
vary: Origin
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Item not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-typing-tran-gov-invs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-typing-tran-gov-invs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-typing-tran-gov-invs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-typing-tran-gov-invs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-typing-tran-gov-invs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-typing-tran-gov-invs--id-" data-method="GET"
      data-path="api/typing-tran-gov-invs/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-typing-tran-gov-invs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-typing-tran-gov-invs--id-"
                    onclick="tryItOut('GETapi-typing-tran-gov-invs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-typing-tran-gov-invs--id-"
                    onclick="cancelTryOut('GETapi-typing-tran-gov-invs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-typing-tran-gov-invs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/typing-tran-gov-invs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-typing-tran-gov-invs--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-typing-tran-gov-invs--id-"
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
                              name="Accept"                data-endpoint="GETapi-typing-tran-gov-invs--id-"
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
               step="any"               name="id"                data-endpoint="GETapi-typing-tran-gov-invs--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the item. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="typing-transaction-government-invoices-PUTapi-typing-tran-gov-invs--id-">Update an item</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Update the details of a specific item.</p>

<span id="example-requests-PUTapi-typing-tran-gov-invs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://74.162.89.93/api/typing-tran-gov-invs/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
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
    "http://74.162.89.93/api/typing-tran-gov-invs/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-typing-tran-gov-invs--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Remove a specific item from the database.</p>

<span id="example-requests-DELETEapi-typing-tran-gov-invs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://74.162.89.93/api/typing-tran-gov-invs/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://74.162.89.93/api/typing-tran-gov-invs/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
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
      data-authed="1"
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
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-typing-tran-gov-invs--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
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
