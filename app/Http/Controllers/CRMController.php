<?php

namespace App\Http\Controllers;

use App\Models\CRM;
use App\Models\Agreement;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\GovtTransactionInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\LedgerOfAccountService;


class CRMController extends Controller
{


    protected LedgerOfAccountService $ledgerService;

    public function __construct(LedgerOfAccountService $ledgerService)
    {
        $this->ledgerService = $ledgerService;
    }


    public function index(Request $request)
    {
        $countries = $this->getCountries();

        $query = CRM::orderByDesc('cl');

        $query->when($request->filled('CL_Number'), fn($q) =>
                $q->where('CL_Number', 'like', "%{$request->CL_Number}%"))
            ->when($request->filled('name'), fn($q) =>
                $q->where('first_name', 'like', "%{$request->name}%"))
            ->when($request->filled('nationality'), fn($q) =>
                $q->where('nationality', $request->nationality))
            ->when($request->filled('email'), fn($q) =>
                $q->where('email', 'like', "%{$request->email}%"))
            ->when($request->filled('mobile'), fn($q) =>
                $q->where('mobile', 'like', "%{$request->mobile}%"))
            ->when($request->filled('emirates_id'), fn($q) =>
                $q->where('emirates_id', 'like', "%{$request->emirates_id}%"))
            ->when($request->filled('source'), fn($q) =>
                $q->where('source', $request->source))
            ->when($request->filled('status') && $request->status !== 'all', fn($q) =>
                $q->where('status', $request->status))
            ->when($request->filled('global_search'), function ($q) use ($request) {
                $g = $request->global_search;
                $q->where(function ($q2) use ($g) {
                    $q2->where('emirates_id', 'like', "%{$g}%")
                        ->orWhere('first_name', 'like', "%{$g}%")
                        ->orWhere('mobile', 'like', "%{$g}%")
                        ->orWhere('email', 'like', "%{$g}%");
                });
            });

        $crms = $query->paginate(10);
        $now  = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        if ($request->ajax()) {
            return view('crm.partials.customer_table', compact('crms'));
        }

        return view('crm.index', compact('crms', 'now', 'countries'));
    }

    public function create()
    {
        $now           = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $latest        = CRM::orderByDesc('cl')->value('cl');
        $newId         = is_numeric($latest) ? $latest + 1 : 1;
        $newCustomerId = str_pad($newId, 4, '0', STR_PAD_LEFT);
        $countries     = $this->getCountries();

        return view('crm.create', compact('now', 'newCustomerId', 'countries'));
    }

    public function show(Request $request, string $slug)
    {
        $crm = CRM::where('slug', $slug)->firstOrFail();

        $agreements       = Agreement::where('client_id', $crm->id)->get();
        $contracts        = Contract::where('client_id', $crm->id)->get();
        $invoices         = Invoice::where('customer_id', $crm->id)->get();
        $govtTransactions = GovtTransactionInvoice::where('CL_Number', $crm->cl)->get();

        $num = function ($v) {
            if (is_null($v) || $v === '') return 0.0;
            if (is_numeric($v)) return (float) $v;
            if (is_string($v)) return (float) str_replace([',', ' '], '', $v);
            return (float) $v;
        };

        $proformaInvoices = $invoices->filter(function ($i) {
            $t = strtolower($i->invoice_type ?? $i->type ?? '');
            return $t === 'proforma';
        })->values();

        $taxInvoices = $invoices->reject(function ($i) {
            $t = strtolower($i->invoice_type ?? $i->type ?? '');
            return $t === 'proforma';
        })->values();

        $invTotals = [
            'tax_total'         => (float) $taxInvoices->sum(fn($i) => $num($i->total_amount)),
            'tax_received'      => (float) $taxInvoices->sum(fn($i) => $num($i->received_amount)),
            'tax_balance'       => (float) $taxInvoices->sum(fn($i) => $num($i->balance_due)),
            'proforma_received' => (float) $proformaInvoices->sum(fn($i) => $num($i->received_amount)),
        ];
        $invTotals['grand_total']    = $invTotals['tax_total'];
        $invTotals['grand_received'] = $invTotals['tax_received'] + $invTotals['proforma_received'];
        $invTotals['grand_balance']  = $invTotals['tax_balance'];

        $entries = collect();

        foreach ($taxInvoices as $inv) {
            $entries->push((object) [
                'type'    => 'Sales Invoice',
                'number'  => $inv->invoice_number,
                'date'    => $inv->invoice_date ? Carbon::parse($inv->invoice_date) : Carbon::parse($inv->created_at),
                'remarks' => $inv->remarks ?? '',
                'debit'   => (float) $num($inv->total_amount),
                'credit'  => 0.0,
            ]);
        }

        foreach ($govtTransactions as $gt) {
            $entries->push((object) [
                'type'    => 'Govt. Transaction',
                'number'  => $gt->invoice_number,
                'date'    => $gt->invoice_date ? Carbon::parse($gt->invoice_date) : Carbon::parse($gt->created_at),
                'remarks' => $gt->candidate_name ?? '',
                'debit'   => (float) $num($gt->total_amount),
                'credit'  => 0.0,
            ]);
        }

        foreach ($invoices as $inv) {
            $rcv = (float) $num($inv->received_amount ?? 0);
            if ($rcv > 0) {
                $entries->push((object) [
                    'type'    => 'Customer Payment',
                    'number'  => $inv->invoice_number,
                    'date'    => $inv->receipt_date ? Carbon::parse($inv->receipt_date)
                        : ($inv->invoice_date ? Carbon::parse($inv->invoice_date) : Carbon::parse($inv->created_at)),
                    'remarks' => 'Payment',
                    'debit'   => 0.0,
                    'credit'  => $rcv,
                ]);
            }
        }

        foreach ($govtTransactions as $gt) {
            $rcv = (float) $num($gt->received_amount ?? 0);
            if ($rcv > 0) {
                $entries->push((object) [
                    'type'    => 'Customer Payment',
                    'number'  => $gt->invoice_number,
                    'date'    => $gt->receipt_date ? Carbon::parse($gt->receipt_date)
                        : ($gt->invoice_date ? Carbon::parse($gt->invoice_date) : Carbon::parse($gt->created_at)),
                    'remarks' => 'Payment',
                    'debit'   => 0.0,
                    'credit'  => $rcv,
                ]);
            }
        }

        $allDates = $entries->pluck('date')->filter()->map(function ($d) {
            return $d instanceof Carbon ? $d : Carbon::parse($d);
        });
        $minDate = $allDates->isNotEmpty() ? $allDates->min() : now()->startOfYear();
        $maxDate = $allDates->isNotEmpty() ? $allDates->max() : now();

        $periodStart = $request->filled('from') ? Carbon::parse($request->query('from')) : $minDate;
        $periodEnd   = $request->filled('to')   ? Carbon::parse($request->query('to'))   : $maxDate;
        if ($periodEnd->lt($periodStart)) {
            [$periodStart, $periodEnd] = [$periodEnd, $periodStart];
        }

        $openingBalance = $entries->filter(function ($e) use ($periodStart) {
            $d = $e->date instanceof Carbon ? $e->date : Carbon::parse($e->date);
            return $d->lt($periodStart);
        })->reduce(function ($carry, $e) use ($num) {
            return $carry + $num($e->debit ?? 0) - $num($e->credit ?? 0);
        }, 0.0);

        $statementEntries = $entries->filter(function ($e) use ($periodStart, $periodEnd) {
            $d = $e->date instanceof Carbon ? $e->date : Carbon::parse($e->date);
            return $d->between($periodStart, $periodEnd);
        })->sortBy('date')->values();

        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        return view('crm.show', compact(
            'crm',
            'now',
            'agreements',
            'contracts',
            'invoices',
            'proformaInvoices',
            'taxInvoices',
            'govtTransactions',
            'invTotals',
            'statementEntries',
            'periodStart',
            'periodEnd',
            'openingBalance'
        ));
    }

    public function edit(string $slug)
    {
        $crm       = CRM::where('slug', $slug)->firstOrFail();
        $now       = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $countries = $this->getCountries();

        return view('crm.edit', compact('crm', 'now', 'countries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'               => 'required|string|max:255',
            'last_name'                => 'required|string|max:255',
            'nationality'              => 'required|string|max:255',
            'state'                    => 'required|string|max:255',
            'passport_number'          => 'required|string|unique:crm,passport_number',
            'address'                  => 'required|string',
            'email'                    => 'nullable|email|max:255|unique:crm,email',
            'mobile'                   => ['required', 'regex:/^(050|055|056|058|052|054)\d{7}$/', 'unique:crm,mobile'],
            'emirates_id'              => ['required', 'regex:/^784-\d{4}-\d{7}-\d$/', 'unique:crm,emirates_id'],
            'emergency_contact_person' => 'nullable|string|max:255',
            'source'                   => 'nullable|string|max:255',
            'passport_copy'            => 'required|file|mimes:pdf,jpg,png,jpeg|max:10000',
            'id_copy'                  => 'required|file|mimes:pdf,jpg,png,jpeg|max:10000',
        ]);

        $data['passport_copy'] = $request->file('passport_copy')->store('passport_copies', 'public');
        $data['id_copy']       = $request->file('id_copy')->store('id_copies', 'public');
        $data['slug']          = $this->generateUniqueSlug($data['first_name'], $data['last_name']);

        DB::beginTransaction();

        try {
            $latestCl = CRM::lockForUpdate()
                ->whereRaw("cl REGEXP '^CL-[0-9]{5}$'")
                ->orderByRaw("CAST(SUBSTRING(cl, 4) AS UNSIGNED) DESC")
                ->value('cl');

            $nextNum    = $latestCl ? ((int) substr($latestCl, 3) + 1) : 1;
            $data['cl'] = sprintf('CL-%05d', $nextNum);

         // 1) This is for createing ledger for the customer in the ledger table 
            $ledger = $this->ledgerService->createLedger([
                        'name'      => $data['first_name'],     
                        'class'     => 1,
                        'sub_class' => 1,
                        'group'     => 'account receivable',
                        'spacial'   => 3,
                        'type'      => 'dr',
                        'note'      => $data['mobile'],
                ]);
            
            //  2 ) this one to update relationship and to know which ledger is related to which customer    
            $data['ledger_id'] = $ledger->id;


            CRM::create($data);

          

            DB::commit();
            return redirect()->route('crm.index')
                ->with('success', 'Customer added and synced with Zoho CRM. and Already have a ledger account');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('CRM store error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to add customer: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, string $slug)
    {
        $crm = CRM::where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'first_name'               => 'required|string|max:255',
            'last_name'                => 'required|string|max:255',
            'nationality'              => 'required|string|max:255',
            'state'                    => 'required|string|max:255',
            'address'                  => 'required|string|max:500',
            'email'                    => ['nullable', 'email', 'max:255', Rule::unique('crm', 'email')->ignore($crm->id)],
            'mobile'                   => ['nullable', 'regex:/^(050|055|056|058|052|054)\d{7}$/', Rule::unique('crm', 'mobile')->ignore($crm->id)],
            'emirates_id'              => ['required', 'regex:/^784-\d{4}-\d{7}-\d$/', Rule::unique('crm', 'emirates_id')->ignore($crm->id)],
            'passport_number'          => ['required', 'string', Rule::unique('crm', 'passport_number')->ignore($crm->id)],
            'passport_copy'            => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:10000',
            'id_copy'                  => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:10000',
            'emergency_contact_person' => 'nullable|string|max:255',
            'source'                   => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('passport_copy')) {
            $data['passport_copy'] = $request->file('passport_copy')->store('passport_copies', 'public');
        }
        if ($request->hasFile('id_copy')) {
            $data['id_copy'] = $request->file('id_copy')->store('id_copies', 'public');
        }

        $base          = Str::slug("{$data['first_name']} {$data['last_name']}");
        $slugCandidate = $base;
        $i             = 1;
        while (CRM::where('slug', $slugCandidate)->where('id', '!=', $crm->id)->exists()) {
            $slugCandidate = "{$base}-{$i}";
            $i++;
        }
        $data['slug'] = $slugCandidate;

        $crm->update($data);
        return redirect()->route('crm.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(string $slug)
    {
    }

    private function generateUniqueSlug(string $firstName, string $lastName): string
    {
        $base = Str::slug("{$firstName}-{$lastName}");
        $slug = $base;
        $i    = 1;
        while (CRM::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        return $slug;
    }

    private function getCountries(): array
    {
        return [
            ['id' => 1, 'name' => 'Afghanistan'],
            ['id' => 2, 'name' => 'Albania'],
            ['id' => 3, 'name' => 'Algeria'],
            ['id' => 4, 'name' => 'Andorra'],
            ['id' => 5, 'name' => 'Angola'],
            ['id' => 6, 'name' => 'Argentina'],
            ['id' => 7, 'name' => 'Armenia'],
            ['id' => 8, 'name' => 'Australia'],
            ['id' => 9, 'name' => 'Austria'],
            ['id' => 10, 'name' => 'Azerbaijan'],
            ['id' => 11, 'name' => 'Bahamas'],
            ['id' => 12, 'name' => 'Bahrain'],
            ['id' => 13, 'name' => 'Bangladesh'],
            ['id' => 14, 'name' => 'Barbados'],
            ['id' => 15, 'name' => 'Belarus'],
            ['id' => 16, 'name' => 'Belgium'],
            ['id' => 17, 'name' => 'Belize'],
            ['id' => 18, 'name' => 'Benin'],
            ['id' => 19, 'name' => 'Bhutan'],
            ['id' => 20, 'name' => 'Bolivia'],
            ['id' => 21, 'name' => 'Bosnia and Herzegovina'],
            ['id' => 22, 'name' => 'Botswana'],
            ['id' => 23, 'name' => 'Brazil'],
            ['id' => 24, 'name' => 'Brunei'],
            ['id' => 25, 'name' => 'Bulgaria'],
            ['id' => 26, 'name' => 'Burkina Faso'],
            ['id' => 27, 'name' => 'Burundi'],
            ['id' => 28, 'name' => 'Cambodia'],
            ['id' => 29, 'name' => 'Cameroon'],
            ['id' => 30, 'name' => 'Canada'],
            ['id' => 31, 'name' => 'Cape Verde'],
            ['id' => 32, 'name' => 'Central African Republic'],
            ['id' => 33, 'name' => 'Chad'],
            ['id' => 34, 'name' => 'Chile'],
            ['id' => 35, 'name' => 'China'],
            ['id' => 36, 'name' => 'Colombia'],
            ['id' => 37, 'name' => 'Comoros'],
            ['id' => 38, 'name' => 'Congo'],
            ['id' => 39, 'name' => 'Costa Rica'],
            ['id' => 40, 'name' => 'Croatia'],
            ['id' => 41, 'name' => 'Cuba'],
            ['id' => 42, 'name' => 'Cyprus'],
            ['id' => 43, 'name' => 'Czech Republic'],
            ['id' => 44, 'name' => 'Denmark'],
            ['id' => 45, 'name' => 'Djibouti'],
            ['id' => 46, 'name' => 'Dominica'],
            ['id' => 47, 'name' => 'Dominican Republic'],
            ['id' => 48, 'name' => 'Ecuador'],
            ['id' => 49, 'name' => 'Egypt'],
            ['id' => 50, 'name' => 'El Salvador'],
            ['id' => 51, 'name' => 'Equatorial Guinea'],
            ['id' => 52, 'name' => 'Eritrea'],
            ['id' => 53, 'name' => 'Estonia'],
            ['id' => 54, 'name' => 'Eswatini'],
            ['id' => 55, 'name' => 'Ethiopia'],
            ['id' => 56, 'name' => 'Fiji'],
            ['id' => 57, 'name' => 'Finland'],
            ['id' => 58, 'name' => 'France'],
            ['id' => 59, 'name' => 'Gabon'],
            ['id' => 60, 'name' => 'Gambia'],
            ['id' => 61, 'name' => 'Georgia'],
            ['id' => 62, 'name' => 'Germany'],
            ['id' => 63, 'name' => 'Ghana'],
            ['id' => 64, 'name' => 'Greece'],
            ['id' => 65, 'name' => 'Grenada'],
            ['id' => 66, 'name' => 'Guatemala'],
            ['id' => 67, 'name' => 'Guinea'],
            ['id' => 68, 'name' => 'Guinea-Bissau'],
            ['id' => 69, 'name' => 'Guyana'],
            ['id' => 70, 'name' => 'Haiti'],
            ['id' => 71, 'name' => 'Honduras'],
            ['id' => 72, 'name' => 'Hungary'],
            ['id' => 73, 'name' => 'Iceland'],
            ['id' => 74, 'name' => 'India'],
            ['id' => 75, 'name' => 'Indonesia'],
            ['id' => 76, 'name' => 'Iran'],
            ['id' => 77, 'name' => 'Iraq'],
            ['id' => 78, 'name' => 'Ireland'],
            ['id' => 79, 'name' => 'Israel'],
            ['id' => 80, 'name' => 'Italy'],
            ['id' => 81, 'name' => 'Jamaica'],
            ['id' => 82, 'name' => 'Japan'],
            ['id' => 83, 'name' => 'Jordan'],
            ['id' => 84, 'name' => 'Kazakhstan'],
            ['id' => 85, 'name' => 'Kenya'],
            ['id' => 86, 'name' => 'Kiribati'],
            ['id' => 87, 'name' => 'Kuwait'],
            ['id' => 88, 'name' => 'Kyrgyzstan'],
            ['id' => 89, 'name' => 'Laos'],
            ['id' => 90, 'name' => 'Latvia'],
            ['id' => 91, 'name' => 'Lebanon'],
            ['id' => 92, 'name' => 'Lesotho'],
            ['id' => 93, 'name' => 'Liberia'],
            ['id' => 94, 'name' => 'Libya'],
            ['id' => 95, 'name' => 'Liechtenstein'],
            ['id' => 96, 'name' => 'Lithuania'],
            ['id' => 97, 'name' => 'Luxembourg'],
            ['id' => 98, 'name' => 'Madagascar'],
            ['id' => 99, 'name' => 'Malawi'],
            ['id' => 100, 'name' => 'Malaysia'],
            ['id' => 101, 'name' => 'Maldives'],
            ['id' => 102, 'name' => 'Mali'],
            ['id' => 103, 'name' => 'Malta'],
            ['id' => 104, 'name' => 'Marshall Islands'],
            ['id' => 105, 'name' => 'Mauritania'],
            ['id' => 106, 'name' => 'Mauritius'],
            ['id' => 107, 'name' => 'Mexico'],
            ['id' => 108, 'name' => 'Micronesia'],
            ['id' => 109, 'name' => 'Moldova'],
            ['id' => 110, 'name' => 'Monaco'],
            ['id' => 111, 'name' => 'Mongolia'],
            ['id' => 112, 'name' => 'Montenegro'],
            ['id' => 113, 'name' => 'Morocco'],
            ['id' => 114, 'name' => 'Mozambique'],
            ['id' => 115, 'name' => 'Myanmar'],
            ['id' => 116, 'name' => 'Namibia'],
            ['id' => 117, 'name' => 'Nauru'],
            ['id' => 118, 'name' => 'Nepal'],
            ['id' => 119, 'name' => 'Netherlands'],
            ['id' => 120, 'name' => 'New Zealand'],
            ['id' => 121, 'name' => 'Nicaragua'],
            ['id' => 122, 'name' => 'Niger'],
            ['id' => 123, 'name' => 'Nigeria'],
            ['id' => 124, 'name' => 'North Korea'],
            ['id' => 125, 'name' => 'North Macedonia'],
            ['id' => 126, 'name' => 'Norway'],
            ['id' => 127, 'name' => 'Oman'],
            ['id' => 128, 'name' => 'Pakistan'],
            ['id' => 129, 'name' => 'Palau'],
            ['id' => 130, 'name' => 'Panama'],
            ['id' => 131, 'name' => 'Papua New Guinea'],
            ['id' => 132, 'name' => 'Paraguay'],
            ['id' => 133, 'name' => 'Peru'],
            ['id' => 134, 'name' => 'Philippines'],
            ['id' => 135, 'name' => 'Poland'],
            ['id' => 136, 'name' => 'Portugal'],
            ['id' => 137, 'name' => 'Qatar'],
            ['id' => 138, 'name' => 'Romania'],
            ['id' => 139, 'name' => 'Russia'],
            ['id' => 140, 'name' => 'Rwanda'],
            ['id' => 141, 'name' => 'Saint Kitts and Nevis'],
            ['id' => 142, 'name' => 'Saint Lucia'],
            ['id' => 143, 'name' => 'Samoa'],
            ['id' => 144, 'name' => 'San Marino'],
            ['id' => 145, 'name' => 'Saudi Arabia'],
            ['id' => 146, 'name' => 'Senegal'],
            ['id' => 147, 'name' => 'Serbia'],
            ['id' => 148, 'name' => 'Seychelles'],
            ['id' => 149, 'name' => 'Sierra Leone'],
            ['id' => 150, 'name' => 'Singapore'],
            ['id' => 151, 'name' => 'Slovakia'],
            ['id' => 152, 'name' => 'Slovenia'],
            ['id' => 153, 'name' => 'Solomon Islands'],
            ['id' => 154, 'name' => 'Somalia'],
            ['id' => 155, 'name' => 'South Africa'],
            ['id' => 156, 'name' => 'South Korea'],
            ['id' => 157, 'name' => 'South Sudan'],
            ['id' => 158, 'name' => 'Spain'],
            ['id' => 159, 'name' => 'Sri Lanka'],
            ['id' => 160, 'name' => 'Sudan'],
            ['id' => 161, 'name' => 'Suriname'],
            ['id' => 162, 'name' => 'Sweden'],
            ['id' => 163, 'name' => 'Switzerland'],
            ['id' => 164, 'name' => 'Syria'],
            ['id' => 165, 'name' => 'Tajikistan'],
            ['id' => 166, 'name' => 'Tanzania'],
            ['id' => 167, 'name' => 'Thailand'],
            ['id' => 168, 'name' => 'Timor-Leste'],
            ['id' => 169, 'name' => 'Togo'],
            ['id' => 170, 'name' => 'Tonga'],
            ['id' => 171, 'name' => 'Trinidad and Tobago'],
            ['id' => 172, 'name' => 'Tunisia'],
            ['id' => 173, 'name' => 'Turkey'],
            ['id' => 174, 'name' => 'Turkmenistan'],
            ['id' => 175, 'name' => 'Tuvalu'],
            ['id' => 176, 'name' => 'Uganda'],
            ['id' => 177, 'name' => 'Ukraine'],
            ['id' => 178, 'name' => 'United Arab Emirates'],
            ['id' => 179, 'name' => 'United Kingdom'],
            ['id' => 180, 'name' => 'United States'],
            ['id' => 181, 'name' => 'Uruguay'],
            ['id' => 182, 'name' => 'Uzbekistan'],
            ['id' => 183, 'name' => 'Vanuatu'],
            ['id' => 184, 'name' => 'Vatican City'],
            ['id' => 185, 'name' => 'Venezuela'],
            ['id' => 186, 'name' => 'Vietnam'],
            ['id' => 187, 'name' => 'Yemen'],
            ['id' => 188, 'name' => 'Zambia'],
            ['id' => 189, 'name' => 'Zimbabwe'],
            ['id' => 190, 'name' => 'Palestine'],
            ['id' => 191, 'name' => "cote D'Ivoire"],
        ];
    }

    public function export(Request $request): StreamedResponse
    {
        $query = CRM::orderByDesc('cl');

        $query->when($request->filled('CL_Number'), function ($q) use ($request) {
                $q->where('CL_Number', 'like', '%' . $request->CL_Number . '%');
            })
            ->when($request->filled('name'), function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->name . '%');
            })
            ->when($request->filled('nationality'), function ($q) use ($request) {
                $q->where('nationality', $request->nationality);
            })
            ->when($request->filled('email'), function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->email . '%');
            })
            ->when($request->filled('mobile'), function ($q) use ($request) {
                $q->where('mobile', 'like', '%' . $request->mobile . '%');
            })
            ->when($request->filled('emirates_id'), function ($q) use ($request) {
                $q->where('emirates_id', 'like', '%' . $request->emirates_id . '%');
            })
            ->when($request->filled('source'), function ($q) use ($request) {
                $q->where('source', $request->source);
            })
            ->when($request->filled('status') && $request->status !== 'all', function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('global_search'), function ($q) use ($request) {
                $g = $request->global_search;
                $q->where(function ($q2) use ($g) {
                    $q2->where('emirates_id', 'like', '%' . $g . '%')
                        ->orWhere('first_name', 'like', '%' . $g . '%')
                        ->orWhere('mobile', 'like', '%' . $g . '%')
                        ->orWhere('email', 'like', '%' . $g . '%');
                });
            });

        $filename = 'customers_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $columns = [
            'CL Number',
            'Created At',
            'Name',
            'Emirates ID',
            'Nationality',
            'Mobile',
            'Passport No',
            'Emirates',
            'Source',
        ];

        $callback = function () use ($query, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);

            $query->chunk(200, function ($customers) use ($handle) {
                foreach ($customers as $customer) {
                    $createdAt = $customer->created_at
                        ? $customer->created_at->format('d M Y')
                        : '';

                    fputcsv($handle, [
                        $customer->cl,
                        $createdAt,
                        trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')),
                        $customer->emirates_id,
                        $customer->nationality,
                        $customer->mobile,
                        $customer->passport_number,
                        $customer->state,
                        $customer->source,
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

}
