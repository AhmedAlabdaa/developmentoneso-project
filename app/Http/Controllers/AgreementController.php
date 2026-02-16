<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\CRM;
use App\Models\Package;
use App\Models\Employee;
use App\Models\NewCandidate;
use App\Models\Invoice;
use App\Models\Contract;
use App\Models\GovtTransactionInvoice;
use App\Models\GovtTransactionInvoiceItem;
use App\Models\InvoiceItem;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Installment;
use App\Models\InstallmentItem;
use App\Models\Trial;
use App\Models\Payroll;
use App\Models\GovernmentService;
use App\Models\PayrollDetail;
use App\Models\CandidateAttachment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Services\ZohoItemService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AgreementsExport;
use App\Exports\ContractsExport;

class AgreementController extends Controller
{
    public function __construct(AccountInvoiceController $acctInv)
    {
        $this->acctInv = $acctInv;
    }
    
    function get_user_id(string $role, ?string $nationality = null): ?int
    {
        $query = DB::table('users')->where('role', $role);

        if ($role == 'Sales Coordinator') {
            if (empty($nationality)) {
                throw new InvalidArgumentException("Nationality is required for the role 'Sales Coordinator'.");
            }
            $query->where('nationality', $nationality);
        }

        $user = $query->select('id')->first();

        return $user ? $user->id : null;
    }

    protected function getForeignDatabaseName($foreignPartner)
    {
        // DISABLED: Remote tenant syncing - working with local database only
        // To re-enable, uncomment the switch statement below
        return null;
        
        /*
        $name = strtolower(explode(' ', $foreignPartner)[0]);
        switch ($name) {
            case 'adey':          return 'adeyonesourceerp_new';
            case 'alkaba':        return 'alkabaonesourcee_new';
            case 'bmg':           return 'bmgonesourceerp_new';
            case 'middleeast':    return 'middleeastonesou_new';
            case 'my':            return 'myonesourceerp_new';
            case 'rozana':        return 'rozanaonesourcee_new';
            case 'tadbeeralebdaa':return 'tadbeeralebdaaon_new';
            case 'vienna':        return 'viennaonesourcee_new';
            case 'edith':         return 'edithonesource_new';
            case 'estella':       return 'estella_new';
            case 'ritemerit':     return 'ritemeritonesour_new';
            case 'khalid':        return 'khalidonesourcee_new';
            default:              return '';
        }
        */
    }

    public function index(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $tab = $request->input('agreement_type', 'BOA');

        if ($tab === 'contracts') {
            $query = Contract::join('agreements', 'contracts.agreement_reference_no', '=', 'agreements.reference_no')
                ->with(['candidate', 'client'])
                ->select(
                    'contracts.*',
                    'agreements.CN_Number',
                    'agreements.CL_Number',
                    'agreements.passport_no',
                    'agreements.candidate_name as agreement_candidate_name',
                    'agreements.nationality as agreement_nationality',
                    'agreements.foreign_partner as agreement_foreign_partner',
                    'agreements.package as agreement_package',
                    'agreements.agreement_type as agreement_type'
                )
                ->whereIn('agreements.package', ['PKG-1', 'PACKAGE 1'])
                ->orderBy('contracts.reference_no', 'desc');

            if ($s = $request->search) {
                $query->where(function ($q) use ($s) {
                    $q->where('contracts.reference_no', 'like', "%{$s}%")
                      ->orWhere('contracts.agreement_reference_no', 'like', "%{$s}%")
                      ->orWhere('agreements.CN_Number', 'like', "%{$s}%")
                      ->orWhere('agreements.CL_Number', 'like', "%{$s}%")
                      ->orWhere('agreements.passport_no', 'like', "%{$s}%")
                      ->orWhere('agreements.candidate_name', 'like', "%{$s}%");
                });
            }

            if ($v = $request->candidate_name_gl) {
                $query->where('agreements.candidate_name', 'like', "%{$v}%");
            }
            if ($v = $request->cn_number_gl) {
                $query->where('agreements.CN_Number', 'like', "%{$v}%");
            }
            if ($v = $request->cl_number_gl) {
                $query->where('agreements.CL_Number', 'like', "%{$v}%");
            }
            if ($v = $request->passport_number_gl) {
                $query->where('agreements.passport_no', 'like', "%{$v}%");
            }
            if ($v = $request->nationality_gl) {
                $query->where('agreements.nationality', $v);
            }
            if ($v = $request->status) {
                $query->where('contracts.status', $v);
            }
            if ($v = $request->foreign_partner_gl) {
                $query->where('agreements.foreign_partner', 'like', "%{$v}%");
            }
            if ($v = $request->package_gl) {
                $query->where('agreements.package', $v);
            }
            if ($v = $request->agreement_type_gl) {
                $query->where('agreements.agreement_type', $v);
            }
            if ($from = $request->from_date_gl and $to = $request->to_date_gl) {
                $from = Carbon::parse($from)->startOfDay();
                $to = Carbon::parse($to)->endOfDay();
                $query->whereBetween('contracts.created_at', [$from, $to]);
            }

            if ($request->input('export') === 'excel') {
                return Excel::download(
                    new ContractsExport($query->get()),
                    'contracts_' . now('Asia/Dubai')->format('Ymd_His') . '.xlsx'
                );
            }

            $contracts = $query->paginate(10)->withQueryString();
            $view = $request->ajax() ? 'contracts.partials.contracts_table' : 'agreements.index';
            return view($view, compact('contracts', 'now'));
        }

        $query = Agreement::with('client')
            ->where('agreement_type', $tab)
            ->whereIn('package', ['PKG-1', 'PACKAGE 1'])
            ->orderBy('reference_no', 'desc');

        if ($s = $request->search) {
            $query->where(function ($q) use ($s) {
                $q->where('reference_no', 'like', "%{$s}%")
                  ->orWhere('CN_Number', 'like', "%{$s}%")
                  ->orWhere('CL_Number', 'like', "%{$s}%")
                  ->orWhere('passport_no', 'like', "%{$s}%")
                  ->orWhereHas('client', function ($c) use ($s) {
                      $c->where('candidate_name', 'like', "%{$s}%");
                  });
            });
        }

        if ($v = $request->candidate_name_gl) {
            $query->whereHas('client', function ($c) use ($v) {
                $c->where('candidate_name', 'like', "%{$v}%");
            });
        }
        if ($v = $request->cn_number_gl) {
            $query->where('CN_Number', 'like', "%{$v}%");
        }
        if ($v = $request->cl_number_gl) {
            $query->where('CL_Number', 'like', "%{$v}%");
        }
        if ($v = $request->passport_number_gl) {
            $query->where('passport_no', 'like', "%{$v}%");
        }
        if ($v = $request->nationality_gl) {
            $query->where('nationality', $v);
        }
        if ($v = $request->status) {
            $query->where('status', $v);
        }
        if ($v = $request->foreign_partner_gl) {
            $query->where('foreign_partner', 'like', "%{$v}%");
        }
        if ($v = $request->package_gl) {
            $query->where('package', $v);
        }
        if ($v = $request->agreement_type_gl) {
            $query->where('agreement_type', $v);
        }
        if ($from = $request->from_date_gl and $to = $request->to_date_gl) {
            $from = Carbon::parse($from)->startOfDay();
            $to = Carbon::parse($to)->endOfDay();
            $query->whereBetween('created_at', [$from, $to]);
        }

        if ($request->input('export') === 'excel') {
            return Excel::download(
                new AgreementsExport($query->get()),
                'agreements_' . now('Asia/Dubai')->format('Ymd_His') . '.xlsx'
            );
        }

        $agreements = $query->paginate(10)->withQueryString();
        $view = $request->ajax() ? 'agreements.partials.agreement_table' : 'agreements.index';
        return view($view, compact('agreements', 'now'));
    }

    protected function add_notification(array $data)
    {
        Notification::create([
            'role'         => $data['role'],
            'user_id'      => $data['user_id'],
            'title'        => $data['title'],
            'message'      => $data['message'],
            'ref_no'       => $data['ref_no'],
            'reference_no' => $data['reference_no'],
            'CN_Number'    => $data['CN_Number'],
            'CL_Number'    => $data['CL_Number'],
            'status'       => $data['status'],
            'created_at'   => $data['created_at'],
        ]);
    }
    public function create()
    {
        return view('agreements.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agreement_type'            => 'required|string|max:255',
            'candidate_id'              => 'required|integer',
            'candidate_name'            => 'required|string|max:255',
            'reference_no'              => 'required|string|max:255',
            'ref_no'                    => 'nullable|string|max:255',
            'package'                   => 'required|string|max:255',
            'client_id'                 => 'required|integer',
            'agreed_salary'             => 'required|numeric|min:1200',
            'visa_type'                 => 'nullable|string|max:255',
            'foreign_partner'           => 'required|string|max:255',
            'candidate_nationality'     => 'required|string|max:255',
            'candidate_passport_number' => 'required|string|max:255',
            'candidate_passport_expiry' => 'required|date',
            'candidate_dob'             => 'required|date',
            'contract_duration'         => 'required|string|max:255',
            'contract_end_date'         => 'required|string|max:255',
            'expected_arrival_date'     => 'required|date',
            'office_payment_method'     => 'required|string|max:255',
            'office_total_amount'       => 'required|numeric|min:0',
            'office_received_amount'    => 'required|numeric|min:0',
            'office_remaining_amount'   => 'required|numeric|min:0',
            'office_vat_amount'         => 'required|numeric|min:0',
            'office_net_amount'         => 'required|numeric|min:0',
            'office_payment_proof'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'office_notes'              => 'nullable|string',
            'govt_service'              => 'nullable|string|max:255',
            'govt_total_amount'         => 'nullable|numeric|min:0',
            'govt_received_amount'      => 'nullable|numeric|min:0',
            'govt_remaining_amount'     => 'nullable|numeric|min:0',
            'govt_vat_amount'           => 'nullable|numeric|min:0',
            'govt_net_amount'           => 'nullable|numeric|min:0',
            'govt_payment_method'       => 'nullable|string|max:255',
            'govt_payment_proof'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'govt_notes'                => 'nullable|string',
            'medical_certificate'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'monthly_payment'           => 'nullable|numeric|min:0',
            'payment_cycle'             => 'nullable|string|max:255',
            'installments_details'      => 'nullable|string',
            'installments_count'        => 'nullable|integer|min:0',
        ]);

        $validator->sometimes('office_payment_proof', 'required', fn($input) => (float) $input->office_received_amount > 0);
        $validator->sometimes('govt_payment_proof', 'required', fn($input) => (float) $input->govt_received_amount > 0 && (float) $input->govt_total_amount > 0);
        $validator->sometimes('payment_cycle', 'required', fn($input) => (float) $input->monthly_payment > 0);
        $validator->sometimes('monthly_payment', 'required|numeric|min:499', fn($input) => (float) $input->monthly_payment > 0);

        $data    = $validator->validate();
        $cand    = NewCandidate::findOrFail($data['candidate_id']);
        $prevRef = $request->input('ref_no', $cand->ref_no ?? '');

        DB::beginTransaction();

        try {
            $client = CRM::findOrFail($data['client_id']);

            if (!$client->CL_Number) {
                $n = CRM::whereNotNull('CL_Number')->lockForUpdate()->count();

                do {
                    $n++;
                    $client->CL_Number = 'CL-' . str_pad($n, 5, '0', STR_PAD_LEFT);
                } while (CRM::where('CL_Number', $client->CL_Number)->exists());

                $client->save();
            }

            $clNumber = $client->CL_Number;

            $generateCN = function (string $prefix = 'CN-', int $pad = 5): string {
                $maxPkgCN  = (int) (Package::where('CN_Number', 'like', $prefix . '%')->lockForUpdate()->selectRaw("COALESCE(MAX(CAST(SUBSTRING_INDEX(CN_Number,'-',-1) AS UNSIGNED)),0) m")->value('m') ?? 0);
                $maxPkgSer = (int) (Package::where('cn_number_series', 'like', $prefix . '%')->lockForUpdate()->selectRaw("COALESCE(MAX(CAST(SUBSTRING_INDEX(cn_number_series,'-',-1) AS UNSIGNED)),0) m")->value('m') ?? 0);
                $maxPkgHr  = (int) (Package::where('hr_ref_no', 'like', $prefix . '%')->lockForUpdate()->selectRaw("COALESCE(MAX(CAST(SUBSTRING_INDEX(hr_ref_no,'-',-1) AS UNSIGNED)),0) m")->value('m') ?? 0);
                $maxCand   = (int) (NewCandidate::where('CN_Number', 'like', $prefix . '%')->lockForUpdate()->selectRaw("COALESCE(MAX(CAST(SUBSTRING_INDEX(CN_Number,'-',-1) AS UNSIGNED)),0) m")->value('m') ?? 0);

                $n = max($maxPkgCN, $maxPkgSer, $maxPkgHr, $maxCand) + 1;

                while (true) {
                    $cn = $prefix . str_pad($n, $pad, '0', STR_PAD_LEFT);

                    $exists = Package::where('CN_Number', $cn)->exists()
                        || Package::where('cn_number_series', $cn)->exists()
                        || Package::where('hr_ref_no', $cn)->exists()
                        || NewCandidate::where('CN_Number', $cn)->exists();

                    if (!$exists) {
                        return $cn;
                    }

                    $n++;
                }
            };

            if (
                empty($cand->CN_Number)
                || Package::where('CN_Number', $cand->CN_Number)->lockForUpdate()->exists()
                || Package::where('cn_number_series', $cand->CN_Number)->lockForUpdate()->exists()
                || Package::where('hr_ref_no', $cand->CN_Number)->lockForUpdate()->exists()
            ) {
                $cand->CN_Number = $generateCN();
                $cand->save();
            }

            $cnNumber = $cand->CN_Number;

            $duplicate = Agreement::where('candidate_id', $data['candidate_id'])
                ->where('agreement_type', $data['agreement_type'])
                ->whereDate('created_at', now()->toDateString())
                ->where('status', '!=', 4)
                ->exists();

            if ($duplicate) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Agreement exists for this candidate today.'], 400);
            }

            $refPrefix = in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true) ? 'BOA-P1-' : 'BOA-E-';
            $lastRef   = Agreement::where('reference_no', 'like', $refPrefix . '%')->lockForUpdate()->orderByDesc('reference_no')->value('reference_no');
            $seqRef    = $lastRef ? intval(substr($lastRef, strlen($refPrefix))) + 1 : 1;

            do {
                $ref = $refPrefix . str_pad($seqRef, 5, '0', STR_PAD_LEFT);
                $seqRef++;
            } while (Agreement::where('reference_no', $ref)->exists());

            $officeProof = $request->file('office_payment_proof')?->store('office_payment_proofs', 'public');
            $medCert     = $request->file('medical_certificate')?->store('medical_certificates', 'public');

            $countryMap = [
                1 => 'Ethiopia',
                2 => 'Uganda',
                3 => 'Philippines',
                4 => 'Indonesia',
                5 => 'Sri Lanka',
                6 => 'Myanmar',
            ];

            $id          = $data['candidate_nationality'] ?? null;
            $countryName = $countryMap[$id] ?? 'Unknown';

            Agreement::create([
                'reference_no'           => $ref,
                'agreement_type'         => $data['agreement_type'],
                'candidate_id'           => $data['candidate_id'],
                'candidate_name'         => $data['candidate_name'],
                'reference_of_candidate' => $data['reference_no'],
                'ref_no_in_of_previous'  => $prevRef,
                'client_id'              => $data['client_id'],
                'CL_Number'              => $clNumber,
                'CN_Number'              => $cnNumber,
                'package'                => $data['package'],
                'salary'                 => $data['agreed_salary'],
                'visa_type'              => $data['visa_type'],
                'foreign_partner'        => $data['foreign_partner'],
                'nationality'            => $countryName,
                'passport_no'            => $data['candidate_passport_number'],
                'passport_expiry_date'   => Carbon::parse($data['candidate_passport_expiry'])->toDateString(),
                'date_of_birth'          => Carbon::parse($data['candidate_dob'])->toDateString(),
                'contract_duration'      => $data['contract_duration'],
                'agreement_start_date'   => date('Y-m-d'),
                'agreement_end_date'     => $data['contract_end_date'],
                'expected_arrival_date'  => Carbon::parse($data['expected_arrival_date'])->toDateString(),
                'payment_method'         => $data['office_payment_method'],
                'total_amount'           => $data['office_total_amount'],
                'received_amount'        => $data['office_received_amount'],
                'remaining_amount'       => $data['office_remaining_amount'],
                'vat_amount'             => $data['office_vat_amount'],
                'net_amount'             => $data['office_net_amount'],
                'payment_proof'          => $officeProof,
                'notes'                  => $data['office_notes'] ?? null,
                'monthly_payment'        => $data['monthly_payment'] ?? null,
                'payment_cycle'          => $data['payment_cycle'] ?? null,
                'installments_details'   => $data['installments_details'] ?? null,
                'installments_count'     => $data['installments_count'] ?? 0,
                'medical_certificate'    => $medCert,
                'created_by'             => Auth::id(),
                'status'                 => 1,
            ]);

            if ($data['client_id'] != 1) {
                $proPrefix = in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true) ? 'RVO-P1-' : 'RVO-E-';
                $lastPro   = Invoice::where('invoice_number', 'like', $proPrefix . '%')->lockForUpdate()->orderByDesc('invoice_number')->value('invoice_number');
                $proSeq    = $lastPro ? intval(substr($lastPro, strlen($proPrefix))) + 1 : 1;

                do {
                    $proNo = $proPrefix . str_pad($proSeq, 5, '0', STR_PAD_LEFT);
                    $proSeq++;
                } while (Invoice::where('invoice_number', $proNo)->exists());

                $proforma = Invoice::create([
                    'invoice_number'         => $proNo,
                    'agreement_reference_no' => $ref,
                    'customer_id'            => $data['client_id'],
                    'CL_Number'              => $clNumber,
                    'CN_Number'              => $cnNumber,
                    'invoice_type'           => 'Proforma',
                    'payment_method'         => $data['office_payment_method'],
                    'received_amount'        => $data['office_received_amount'],
                    'invoice_date'           => now('Asia/Dubai'),
                    'due_date'               => now('Asia/Dubai'),
                    'total_amount'           => $data['office_total_amount'],
                    'discount_amount'        => 0,
                    'tax_amount'             => 0,
                    'balance_due'            => $data['office_remaining_amount'],
                    'status'                 => 'Pending',
                    'payment_proof'          => $officeProof,
                    'notes'                  => $data['office_notes'] ?? null,
                    'created_by'             => Auth::id(),
                ]);

                InvoiceItem::create([
                    'invoice_id'   => $proforma->invoice_id,
                    'product_name' => 'Agreement: ' . $ref,
                    'quantity'     => 1,
                    'unit_price'   => $data['office_total_amount'],
                    'total_price'  => $data['office_total_amount'],
                ]);
            }

            if (($data['govt_total_amount'] ?? 0) > 0) {
                $gvPrefix = 'GV-INV-';
                $lastGv   = GovtTransactionInvoice::where('invoice_number', 'like', $gvPrefix . '%')->lockForUpdate()->orderByDesc('invoice_number')->value('invoice_number');
                $gvSeq    = $lastGv ? intval(substr($lastGv, strlen($gvPrefix))) + 1 : 1;

                do {
                    $gvNo = $gvPrefix . str_pad($gvSeq, 5, '0', STR_PAD_LEFT);
                    $gvSeq++;
                } while (GovtTransactionInvoice::where('invoice_number', $gvNo)->exists());

                $gProof = $request->file('govt_payment_proof')?->store('govt_transaction_proofs', 'public');

                GovtTransactionInvoice::create([
                    'invoice_number'      => $gvNo,
                    'invoice_date'        => now('Asia/Dubai'),
                    'CL_Number'           => $clNumber,
                    'CN_Number'           => $cnNumber,
                    'reference_no'        => $data['reference_no'],
                    'Customer_name'       => $client->first_name,
                    'Customer_mobile_no'  => $client->mobile,
                    'canidate_name'       => $data['candidate_name'],
                    'Sales_name'          => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                    'total_amount'        => $data['govt_total_amount'],
                    'total_vat'           => $data['govt_vat_amount'],
                    'net_total'           => $data['govt_net_amount'],
                    'status'              => 'Pending',
                    'customer_note'       => $data['govt_notes'] ?? null,
                    'payment_proof'       => $gProof,
                    'payment_mode'        => $data['govt_payment_method'],
                    'created_by'          => Auth::id(),
                    'due_date'            => now('Asia/Dubai'),
                    'received_amount'     => $data['govt_received_amount'],
                    'remaining_amount'    => $data['govt_remaining_amount'],
                    'service_name'        => $data['govt_service'],
                    'customer_type'       => 'Indoor',
                ]);

                GovtTransactionInvoiceItem::create([
                    'invoice_number' => $gvNo,
                    'service_name'   => $data['govt_service'],
                    'qty'            => 1,
                    'amount'         => $data['govt_total_amount'],
                    'tax'            => $data['govt_vat_amount'],
                    'total'          => $data['govt_net_amount'],
                ]);
            }

            $languages = collect([
                $cand->english_skills ? ('English: ' . $cand->english_skills) : null,
                $cand->arabic_skills ? ('Arabic: ' . $cand->arabic_skills) : null,
            ])->filter()->implode(', ');

            $expRows    = DB::table('candidates_experience')->where('candidate_id', $data['candidate_id'])->get();
            $totalYears = 0;

            foreach ($expRows as $r) {
                if (is_numeric($r->experience_years)) {
                    $totalYears += (int) $r->experience_years;
                }
            }

            if (!$totalYears && is_numeric($cand->working_experience)) {
                $totalYears = (int) $cand->working_experience;
            }

            $totalYears = $totalYears > 0 ? min(10, $totalYears) : null;

            if (in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true)) {
                $existingPackage = Package::where('passport_no', $data['candidate_passport_number'])->lockForUpdate()->first();

                if ($existingPackage) {
                    $existingPackage->update([
                        'candidate_id'              => $data['candidate_id'],
                        'CN_Number'                 => $cnNumber,
                        'cn_number_series'          => $cnNumber,
                        'hr_ref_no'                 => $cnNumber,
                        'contract_no'               => $ref,
                        'agreement_no'              => $ref,
                        'sales_name'                => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                        'candidate_name'            => $data['candidate_name'],
                        'foreign_partner'           => $data['foreign_partner'],
                        'current_status'            => 4,
                        'nationality'               => $countryName,
                        'CL_nationality'            => $cand->nationality,
                        'passport_no'               => $data['candidate_passport_number'],
                        'passport_expiry_date'      => Carbon::parse($data['candidate_passport_expiry'])->toDateString(),
                        'date_of_birth'             => Carbon::parse($data['candidate_dob'])->toDateString(),
                        'branch_in_uae'             => $cand->branch_in_uae,
                        'visa_type'                 => $data['visa_type'],
                        'CL_Number'                 => $clNumber,
                        'sponsor_name'              => trim(($client->first_name ?? '') . ' ' . ($client->last_name ?? '')),
                        'eid_no'                    => $client->emirates_id ?? null,
                        'package'                   => $data['package'],
                        'change_status_date'        => now('Asia/Dubai'),
                        'inside_country_or_outside' => 1,
                        'religion'                  => $cand->religion,
                        'marital_status'            => $cand->marital_status,
                        'children_count'            => is_numeric($cand->number_of_children) ? (int) $cand->number_of_children : 0,
                        'experience_years'          => $totalYears,
                        'salary'                    => $data['agreed_salary'],
                        'place_of_birth'            => $cand->place_of_birth,
                        'living_town'               => $cand->candidate_current_address,
                        'weight'                    => $cand->weight,
                        'height'                    => $cand->height,
                        'education'                 => $cand->education_level,
                        'languages'                 => $languages,
                        'working_experience'        => $cand->working_experience ?? null,
                        'previous_employements'     => $cand->previous_employements ?? null,
                        'contract_period'           => $cand->contract_duration,
                        'passport_issue_date'       => $cand->passport_issue_date ? Carbon::parse($cand->passport_issue_date)->toDateString() : null,
                        'place_of_issue'            => $cand->passport_issue_place,
                        'expiry_date'               => $cand->passport_expiry_date ? Carbon::parse($cand->passport_expiry_date)->toDateString() : null,
                    ]);

                    DB::table('package_skills')->where('package_id', $existingPackage->id)->delete();
                    DB::table('package_experience')->where('package_id', $existingPackage->id)->delete();
                    DB::table('package_attachments')->where('package_id', $existingPackage->id)->delete();

                    $candidateSkills = DB::table('candidate_skills')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateSkills->count()) {
                        $rows = $candidateSkills->map(function ($row) use ($existingPackage) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['package_id'] = $existingPackage->id;
                            $arr['created_at'] = now();
                            $arr['updated_at'] = now();
                            return $arr;
                        })->all();

                        DB::table('package_skills')->insert($rows);
                    }

                    $candidateExp = DB::table('candidates_experience')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateExp->count()) {
                        $rows = $candidateExp->map(function ($row) use ($existingPackage) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['package_id'] = $existingPackage->id;
                            $arr['created_at'] = now();
                            $arr['updated_at'] = now();
                            return $arr;
                        })->all();

                        DB::table('package_experience')->insert($rows);
                    }

                    $candidateAtt = DB::table('candidate_attachments')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateAtt->count()) {
                        $rows = $candidateAtt->map(function ($row) use ($existingPackage) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['package_id'] = $existingPackage->id;
                            $arr['created_at'] = now();
                            $arr['updated_at'] = now();
                            return $arr;
                        })->all();

                        DB::table('package_attachments')->insert($rows);
                    }
                } else {
                    $package = Package::create([
                        'candidate_id'              => $data['candidate_id'],
                        'cn_number_series'          => $cnNumber,
                        'CN_Number'                 => $cnNumber,
                        'hr_ref_no'                 => $cnNumber,
                        'contract_no'               => $ref,
                        'agreement_no'              => $ref,
                        'sales_name'                => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                        'candidate_name'            => $data['candidate_name'],
                        'foreign_partner'           => $data['foreign_partner'],
                        'current_status'            => 4,
                        'nationality'               => $countryName,
                        'CL_nationality'            => $cand->nationality,
                        'passport_no'               => $data['candidate_passport_number'],
                        'passport_expiry_date'      => Carbon::parse($data['candidate_passport_expiry'])->toDateString(),
                        'date_of_birth'             => Carbon::parse($data['candidate_dob'])->toDateString(),
                        'branch_in_uae'             => $cand->branch_in_uae,
                        'visa_type'                 => $data['visa_type'],
                        'CL_Number'                 => $clNumber,
                        'sponsor_name'              => trim(($client->first_name ?? '') . ' ' . ($client->last_name ?? '')),
                        'eid_no'                    => $client->emirates_id ?? null,
                        'package'                   => $data['package'],
                        'change_status_date'        => now('Asia/Dubai'),
                        'inside_country_or_outside' => 1,
                        'religion'                  => $cand->religion,
                        'marital_status'            => $cand->marital_status,
                        'children_count'            => is_numeric($cand->number_of_children) ? (int) $cand->number_of_children : 0,
                        'experience_years'          => $totalYears,
                        'salary'                    => $data['agreed_salary'],
                        'place_of_birth'            => $cand->place_of_birth,
                        'living_town'               => $cand->candidate_current_address,
                        'weight'                    => $cand->weight,
                        'height'                    => $cand->height,
                        'education'                 => $cand->education_level,
                        'languages'                 => $languages,
                        'working_experience'        => $cand->working_experience ?? null,
                        'previous_employements'     => $cand->previous_employements ?? null,
                        'contract_period'           => $cand->contract_duration,
                        'passport_issue_date'       => $cand->passport_issue_date ? Carbon::parse($cand->passport_issue_date)->toDateString() : null,
                        'place_of_issue'            => $cand->passport_issue_place,
                        'expiry_date'               => $cand->passport_expiry_date ? Carbon::parse($cand->passport_expiry_date)->toDateString() : null,
                    ]);

                    $candidateSkills = DB::table('candidate_skills')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateSkills->count()) {
                        $rows = $candidateSkills->map(function ($row) use ($package) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['package_id'] = $package->id;
                            $arr['created_at'] = now();
                            $arr['updated_at'] = now();
                            return $arr;
                        })->all();

                        DB::table('package_skills')->insert($rows);
                    }

                    $candidateExp = DB::table('candidates_experience')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateExp->count()) {
                        $rows = $candidateExp->map(function ($row) use ($package) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['package_id'] = $package->id;
                            $arr['created_at'] = now();
                            $arr['updated_at'] = now();
                            return $arr;
                        })->all();

                        DB::table('package_experience')->insert($rows);
                    }

                    $candidateAtt = DB::table('candidate_attachments')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateAtt->count()) {
                        $rows = $candidateAtt->map(function ($row) use ($package) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['package_id'] = $package->id;
                            $arr['created_at'] = now();
                            $arr['updated_at'] = now();
                            return $arr;
                        })->all();

                        DB::table('package_attachments')->insert($rows);
                    }
                }
            } else {
                $existingEmployee = Employee::where('passport_no', $data['candidate_passport_number'])->lockForUpdate()->first();

                if ($existingEmployee) {
                    $existingEmployee->update([
                        'package'                   => $data['package'],
                        'name'                      => $data['candidate_name'],
                        'slug'                      => Str::slug($data['candidate_name'] . '-' . $existingEmployee->reference_no),
                        'nationality'               => $countryName,
                        'passport_no'               => $data['candidate_passport_number'],
                        'passport_expiry_date'      => Carbon::parse($data['candidate_passport_expiry'])->toDateString(),
                        'visa_designation'          => $data['visa_type'],
                        'date_of_birth'             => Carbon::parse($data['candidate_dob'])->toDateString(),
                        'contract_type'             => $data['package'],
                        'payment_type'              => $data['office_payment_method'],
                        'salary_as_per_contract'    => $data['office_total_amount'],
                        'inside_country_or_outside' => 1,
                        'current_status'            => 4,
                        'foreign_partner'           => $data['foreign_partner'],
                        'contract_no'               => $ref,
                        'religion'                  => $cand->religion,
                        'marital_status'            => $cand->marital_status,
                        'children_count'            => is_numeric($cand->number_of_children) ? (int) $cand->number_of_children : 0,
                        'experience_years'          => $totalYears,
                        'salary'                    => $data['agreed_salary'],
                        'place_of_birth'            => $cand->place_of_birth,
                        'living_town'               => $cand->candidate_current_address,
                        'weight'                    => $cand->weight,
                        'height'                    => $cand->height,
                        'education'                 => $cand->education_level,
                        'languages'                 => $languages,
                        'working_experience'        => $cand->working_experience ?? null,
                        'previous_employements'     => $cand->previous_employements ?? null,
                        'contract_period'           => $cand->contract_duration,
                        'passport_issue_date'       => $cand->passport_issue_date ? Carbon::parse($cand->passport_issue_date)->toDateString() : null,
                        'place_of_issue'            => $cand->passport_issue_place,
                        'expiry_date'               => $cand->passport_expiry_date ? Carbon::parse($cand->passport_expiry_date)->toDateString() : null,
                    ]);

                    DB::table('employee_skills')->where('employee_id', $existingEmployee->id)->delete();
                    DB::table('employee_experience')->where('employee_id', $existingEmployee->id)->delete();
                    DB::table('employee_attachments')->where('employee_id', $existingEmployee->id)->delete();

                    $candidateSkills = DB::table('candidate_skills')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateSkills->count()) {
                        $rows = $candidateSkills->map(function ($row) use ($existingEmployee) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['employee_id'] = $existingEmployee->id;
                            $arr['created_at']  = now();
                            $arr['updated_at']  = now();
                            return $arr;
                        })->all();

                        DB::table('employee_skills')->insert($rows);
                    }

                    $candidateExp = DB::table('candidates_experience')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateExp->count()) {
                        $rows = $candidateExp->map(function ($row) use ($existingEmployee) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['employee_id'] = $existingEmployee->id;
                            $arr['created_at']  = now();
                            $arr['updated_at']  = now();
                            return $arr;
                        })->all();

                        DB::table('employee_experience')->insert($rows);
                    }

                    $candidateAtt = DB::table('candidate_attachments')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateAtt->count()) {
                        $rows = $candidateAtt->map(function ($row) use ($existingEmployee) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['employee_id'] = $existingEmployee->id;
                            $arr['created_at']  = now();
                            $arr['updated_at']  = now();
                            return $arr;
                        })->all();

                        DB::table('employee_attachments')->insert($rows);
                    }
                } else {
                    $lastEr = Employee::whereNotNull('reference_no')->lockForUpdate()->orderByDesc('reference_no')->value('reference_no');
                    $erSeq  = $lastEr && preg_match('/(\d+)$/', $lastEr, $m) ? ((int) $m[1] + 1) : 1;

                    do {
                        $er = 'EM-' . str_pad($erSeq, 5, '0', STR_PAD_LEFT);
                        $erSeq++;
                    } while (Employee::where('reference_no', $er)->exists());

                    $employee = Employee::create([
                        'reference_no'             => $er,
                        'package'                  => $data['package'],
                        'name'                     => $data['candidate_name'],
                        'slug'                     => Str::slug($data['candidate_name'] . '-' . $er),
                        'nationality'              => $countryName,
                        'passport_no'              => $data['candidate_passport_number'],
                        'passport_expiry_date'     => Carbon::parse($data['candidate_passport_expiry'])->toDateString(),
                        'date_of_joining'          => now('Asia/Dubai'),
                        'visa_designation'         => $data['visa_type'],
                        'date_of_birth'            => Carbon::parse($data['candidate_dob'])->toDateString(),
                        'contract_type'            => $data['package'],
                        'payment_type'             => $data['office_payment_method'],
                        'salary_as_per_contract'   => $data['office_total_amount'],
                        'inside_country_or_outside'=> 1,
                        'current_status'           => 4,
                        'foreign_partner'          => $data['foreign_partner'],
                        'contract_no'              => $ref,
                        'religion'                 => $cand->religion,
                        'marital_status'           => $cand->marital_status,
                        'children_count'           => is_numeric($cand->number_of_children) ? (int) $cand->number_of_children : 0,
                        'experience_years'         => $totalYears,
                        'salary'                   => $data['agreed_salary'],
                        'place_of_birth'           => $cand->place_of_birth,
                        'living_town'              => $cand->candidate_current_address,
                        'weight'                   => $cand->weight,
                        'height'                   => $cand->height,
                        'education'                => $cand->education_level,
                        'languages'                => $languages,
                        'working_experience'       => $cand->working_experience ?? null,
                        'previous_employements'    => $cand->previous_employements ?? null,
                        'contract_period'          => $cand->contract_duration,
                        'passport_issue_date'      => $cand->passport_issue_date ? Carbon::parse($cand->passport_issue_date)->toDateString() : null,
                        'place_of_issue'           => $cand->passport_issue_place,
                        'expiry_date'              => $cand->passport_expiry_date ? Carbon::parse($cand->passport_expiry_date)->toDateString() : null,
                    ]);

                    $candidateSkills = DB::table('candidate_skills')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateSkills->count()) {
                        $rows = $candidateSkills->map(function ($row) use ($employee) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['employee_id'] = $employee->id;
                            $arr['created_at']  = now();
                            $arr['updated_at']  = now();
                            return $arr;
                        })->all();

                        DB::table('employee_skills')->insert($rows);
                    }

                    $candidateExp = DB::table('candidates_experience')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateExp->count()) {
                        $rows = $candidateExp->map(function ($row) use ($employee) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['employee_id'] = $employee->id;
                            $arr['created_at']  = now();
                            $arr['updated_at']  = now();
                            return $arr;
                        })->all();

                        DB::table('employee_experience')->insert($rows);
                    }

                    $candidateAtt = DB::table('candidate_attachments')->where('candidate_id', $data['candidate_id'])->get();

                    if ($candidateAtt->count()) {
                        $rows = $candidateAtt->map(function ($row) use ($employee) {
                            $arr = (array) $row;
                            unset($arr['id'], $arr['candidate_id'], $arr['created_at'], $arr['updated_at']);
                            $arr['employee_id'] = $employee->id;
                            $arr['created_at']  = now();
                            $arr['updated_at']  = now();
                            return $arr;
                        })->all();

                        DB::table('employee_attachments')->insert($rows);
                    }
                }
            }

            $cand->update([
                'current_status' => 4,
                'selected_date'  => now('Asia/Dubai'),
                'sales_name'     => Auth::id(),
            ]);

            $db = $this->getForeignDatabaseName($data['foreign_partner']);

            if ($db && $prevRef) {
                try {
                    $affected = DB::connection($db)
                        ->table('candidates')
                        ->where('ref_no', $prevRef)
                        ->update(['current_status' => 4]);

                    if (!$affected) {
                        Log::warning("Remote DB update: No rows affected for ref_no {$prevRef} on {$db}");
                    }
                } catch (\Throwable $e) {
                    // Log the error but don't fail the transaction - remote DB might be down or slow
                    Log::warning("Failed to update remote candidate status on {$db}: " . $e->getMessage());
                }
            }

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Agreement saved successfully'], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function insideAgreement(Request $request)
    {
        if ($request->filled('installments') && is_string($request->installments)) {
            $request->merge([
                'installments' => json_decode($request->installments, true, 512, JSON_THROW_ON_ERROR),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'agreement_type'             => 'required|string|max:255',
            'candidate_id'               => 'nullable|integer',
            'candidate_name'             => 'required|string|max:255',
            'ref_no_in_of_previous'      => 'nullable|string|max:255',
            'client_id'                  => 'required|integer',
            'package'                    => 'required|string|max:255',
            'salary'                     => 'required|string|max:255',
            'monthly_payment'            => 'nullable|numeric|min:0',
            'payment_cycle'              => 'nullable|string|max:255',
            'visa_type'                  => 'nullable|string|max:255',
            'foreign_partner'            => 'nullable|string|max:255',
            'expected_arrival_date'      => 'nullable|date',
            'nationality'                => 'required|string|max:255',
            'passport_no'                => 'nullable|string|max:255',
            'passport_expiry_date'       => 'nullable|date',
            'date_of_birth'              => 'nullable|date',
            'payment_method'             => 'required|string|max:255',
            'total_amount'               => 'required|numeric|min:0',
            'received_amount'            => 'required|numeric|min:0',
            'number_of_days'             => 'required|integer',
            'notes'                      => 'nullable|string',
            'trial_start_date'           => 'required|date',
            'trial_end_date'             => 'required|date',
            'payment_proof'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'medical_certificate'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'govt_total_amount'          => 'nullable|numeric|min:0',
            'govt_received_amount'       => 'nullable|numeric|min:0',
            'govt_remaining_amount'      => 'nullable|numeric|min:0',
            'govt_vat_amount'            => 'nullable|numeric|min:0',
            'govt_net_amount'            => 'nullable|numeric|min:0',
            'govt_payment_method'        => 'nullable|string|max:255',
            'govt_payment_proof'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'govt_payment_notes'         => 'nullable|string',
            'govt_service_name'          => 'nullable|string|max:255',
            'payment_terms'              => 'nullable|string|in:full,partial',
            'installments'               => 'nullable|array',
            'installments.*.description' => 'nullable|string',
            'installments.*.amount'      => 'nullable|numeric|min:0',
            'installments.*.paymentDate' => 'nullable|date',
        ]);

        $validator->sometimes('payment_proof', 'required', fn ($v) => (float) $v->received_amount > 0);
        $validator->sometimes('govt_payment_proof', 'required', fn ($v) => $v->govt_received_amount > 0 && $v->govt_total_amount > 0);
        $validator->sometimes('payment_cycle', 'required', fn ($i) => (float) $i->monthly_payment > 0);
        $validator->sometimes('monthly_payment', 'required|numeric|min:499', fn ($i) => (float) $i->monthly_payment > 0);

        $data = $validator->validate() + [
            'visa_type'             => 'D-SPO',
            'contract_duration'     => '',
            'notes'                 => '',
            'payment_terms'         => 'full',
            'foreign_partner'       => null,
            'govt_total_amount'     => 0,
            'govt_received_amount'  => 0,
            'govt_remaining_amount' => 0,
            'govt_vat_amount'       => 0,
            'govt_net_amount'       => 0,
            'govt_payment_method'   => null,
            'govt_payment_notes'    => null,
            'govt_service_name'     => null,
            'installments'          => [],
        ];

        if ($data['payment_terms'] === 'partial' && empty($data['installments'])) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Installments are required when payment_terms is partial.',
            ], 422);
        }

        if ($data['contract_duration'] === '') {
            $data['contract_duration'] = count($data['installments']) . ' months';
        }

        $totalAmount     = (float) $data['total_amount'];
        $receivedAmount  = (float) $data['received_amount'];
        $remainingAmount = round(max(0, $totalAmount - $receivedAmount), 2);

        DB::beginTransaction();

        try {
            $client = CRM::lockForUpdate()->findOrFail($data['client_id']);

            if (!$client->CL_Number) {
                $seq = CRM::whereNotNull('CL_Number')->lockForUpdate()->count() + 1;
                do {
                    $client->CL_Number = 'CL-' . str_pad($seq, 5, '0', STR_PAD_LEFT);
                    $seq++;
                } while (CRM::where('CL_Number', $client->CL_Number)->exists());
                $client->save();
            }

            $isPkg1 = in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true);
            $candModel = $isPkg1 ? Package::class : Employee::class;
            $refCol    = $isPkg1 ? 'hr_ref_no'     : 'reference_no';
            $prefix    = $isPkg1 ? 'CN-'           : 'EM-';


            if (in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true)) {
                $defaults = [
                    'package'              => $data['package'],
                    'name'                 => $data['candidate_name'],
                    'slug'                 => Str::slug($data['candidate_name']),
                    'nationality'          => $data['nationality'],
                    'passport_no'          => $data['passport_no'],
                    'passport_expiry_date' => $data['passport_expiry_date'] ?? null,
                    'date_of_birth'        => $data['date_of_birth'] ?? null,
                ];

                if ($data['candidate_id']) {
                    $candidate = Package::lockForUpdate()->findOrFail($data['candidate_id']);
                    $candidate->fill($defaults);
                } else {
                    $candidate = new Package($defaults);
                }
            } else {
                if ($data['candidate_id']) {
                    $pkgSource  = Package::lockForUpdate()->findOrFail($data['candidate_id']);
                    $sourceName = $pkgSource->candidate_name ?? $pkgSource->name ?? $data['candidate_name'];
                    $defaults   = [
                        'package'              => $data['package'],
                        'name'                 => $sourceName,
                        'slug'                 => Str::slug($sourceName),
                        'nationality'          => $pkgSource->nationality,
                        'passport_no'          => $pkgSource->passport_no,
                        'passport_expiry_date' => $pkgSource->passport_expiry_date,
                        'date_of_birth'        => $pkgSource->date_of_birth,
                    ];
                    $candidate = new Employee($defaults);
                    if (empty($data['ref_no_in_of_previous'])) {
                        $data['ref_no_in_of_previous'] = $pkgSource->hr_ref_no;
                    }
                } else {
                    $defaults = [
                        'package'              => $data['package'],
                        'name'                 => $data['candidate_name'],
                        'slug'                 => Str::slug($data['candidate_name']),
                        'nationality'          => $data['nationality'],
                        'passport_no'          => $data['passport_no'],
                        'passport_expiry_date' => $data['passport_expiry_date'] ?? null,
                        'date_of_birth'        => $data['date_of_birth'] ?? null,
                    ];
                    $candidate = new Employee($defaults);
                }
            }

            if (!$candidate->$refCol) {
                $seq = $candModel::whereNotNull($refCol)->lockForUpdate()->count() + 1;
                do {
                    $candidate->$refCol = $prefix . str_pad($seq, 5, '0', STR_PAD_LEFT);
                    $seq++;
                } while ($candModel::where($refCol, $candidate->$refCol)->exists());
            }

            if ($candModel === Package::class && !$candidate->cn_number_series) {
                $lastCn = Package::whereNotNull('cn_number_series')->lockForUpdate()->orderByDesc('id')->value('cn_number_series');
                $seqCn  = $lastCn ? intval(substr($lastCn, 3)) + 1 : 1;
                do {
                    $candidate->cn_number_series = 'CN-' . str_pad($seqCn, 5, '0', STR_PAD_LEFT);
                    $seqCn++;
                } while (Package::where('cn_number_series', $candidate->cn_number_series)->exists());
            }

            if ($candModel === Employee::class && $candidate->inside_status == 3) {
                DB::rollBack();
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Incidented employee. Agreement not allowed.',
                ], 422);
            }

            if ($candModel === Package::class && $candidate->inside_status == 5) {
                DB::rollBack();
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Incidented package. Agreement not allowed.',
                ], 422);
            }

            $candidate->inside_status              = 2;
            $candidate->inside_country_or_outside  = 2;
            $candidate->save();
            $data['candidate_id']                  = $candidate->id;
            $candRef                               = $candidate->$refCol;

            DB::table('office')
                ->where('candidate_id', $candidate->id)
                ->where('type', $candModel === Employee::class ? 'employee' : 'package')
                ->where('status', 1)
                ->update(['status' => 0]);

            $prefMap = [
                'BOA.P1' => 'BOA-P1-',
                'BOA.E'  => 'BOA-E-',
                'BIA.P1' => 'BIA-P1-',
                'BIA.E'  => 'CT-E-',
            ];
            $isPkg1 = in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true);
            $key = $data['agreement_type'] . '.' . ($isPkg1 ? 'P1' : 'E');
            $agrPref = $prefMap[$key] ?? 'AGR-';
            $lastAgr = Agreement::where('reference_no', 'like', $agrPref . '%')->lockForUpdate()->orderByDesc('id')->value('reference_no');
            $seq     = $lastAgr ? intval(substr($lastAgr, strlen($agrPref))) + 1 : 1;

            do {
                $agrRef = $agrPref . str_pad($seq, 5, '0', STR_PAD_LEFT);
                $seq++;
            } while (Agreement::where('reference_no', $agrRef)->exists());

            $paymentProof = $request->file('payment_proof')?->store('payment_proofs', 'public');
            $officeProof  = $request->file('office_payment_proof')?->store('office_payment_proofs', 'public');
            $medCert      = $request->file('medical_certificate')?->store('medical_certificates', 'public');

            $agreement = Agreement::create([
                'reference_no'           => $agrRef,
                'agreement_type'         => $data['agreement_type'],
                'candidate_id'           => $candidate->id,
                'candidate_name'         => $data['candidate_name'],
                'reference_of_candidate' => $candRef,
                'ref_no_in_of_previous'  => $data['ref_no_in_of_previous'] ?: $candRef,
                'client_id'              => $data['client_id'],
                'CL_Number'              => $client->CL_Number,
                'CN_Number'              => $candRef,
                'package'                => $data['package'],
                'salary'                 => $data['salary'],
                'monthly_payment'        => $data['monthly_payment'] ?? 0,
                'payment_cycle'          => $data['payment_cycle'] ?? 'LUMSUM',
                'visa_type'              => $data['visa_type'],
                'foreign_partner'        => $data['foreign_partner'],
                'nationality'            => $data['nationality'],
                'passport_no'            => $data['passport_no'],
                'passport_expiry_date'   => $data['passport_expiry_date'] ?? null,
                'date_of_birth'          => $data['date_of_birth'] ?? null,
                'payment_method'         => $data['payment_method'],
                'total_amount'           => $totalAmount,
                'received_amount'        => $receivedAmount,
                'remaining_amount'       => $remainingAmount,
                'vat_amount'             => 0,
                'net_amount'             => $totalAmount,
                'notes'                  => $data['notes'],
                'payment_proof'          => $paymentProof,
                'contract_duration'      => $data['contract_duration'],
                'number_of_days'         => $data['number_of_days'],
                'agreement_start_date'   => $data['trial_start_date'],
                'agreement_end_date'     => $data['trial_end_date'],
                'created_by'             => Auth::id(),
                'status'                 => 1,
            ]);

            if ($medCert) {
                CandidateAttachment::updateOrCreate(
                    ['candidate_id' => $candidate->id, 'attachment_type' => 'Medical Certificate'],
                    [
                        'attachment_file' => $medCert,
                        'attachment_name' => $request->file('medical_certificate')->getClientOriginalName(),
                        'created_by'      => Auth::id(),
                    ]
                );
            }

            $proNo = $taxNo = null;

            if ($data['client_id'] != 1) {
                $proPref = in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true)
                ? 'RVI-P1-'
                : 'RVI-E-';
                $lastPro = Invoice::where('invoice_number', 'like', $proPref . '%')->lockForUpdate()->orderByDesc('invoice_number')->value('invoice_number');
                $seq     = $lastPro ? intval(substr($lastPro, strlen($proPref))) + 1 : 1;
                $proNo   = $proPref . str_pad($seq, 5, '0', STR_PAD_LEFT);

                $proforma = Invoice::create([
                    'invoice_number'         => $proNo,
                    'agreement_reference_no' => $agrRef,
                    'customer_id'            => $data['client_id'],
                    'reference_no'           => $candRef,
                    'CL_Number'              => $client->CL_Number,
                    'CN_Number'              => $candRef,
                    'invoice_type'           => 'Proforma',
                    'payment_method'         => $data['payment_method'],
                    'received_amount'        => $receivedAmount,
                    'invoice_date'           => now('Asia/Dubai'),
                    'due_date'               => now('Asia/Dubai'),
                    'total_amount'           => $totalAmount,
                    'discount_amount'        => 0,
                    'tax_amount'             => 0,
                    'balance_due'            => $remainingAmount,
                    'status'                 => 'Pending',
                    'payment_proof'          => $paymentProof,
                    'created_by'             => Auth::id(),
                ]);

                InvoiceItem::create([
                    'invoice_id'   => $proforma->invoice_id,
                    'product_name' => 'Agreement: ' . $agrRef,
                    'quantity'     => 1,
                    'unit_price'   => $totalAmount,
                    'total_price'  => $totalAmount,
                ]);

                $fin = $this->get_user_id('Finance Officer') ?? Auth::id();

                $this->add_notification([
                    'role'         => 'finance',
                    'user_id'      => $fin,
                    'title'        => "Approve {$proNo}",
                    'message'      => "Approve {$proNo}",
                    'ref_no'       => $candRef,
                    'reference_no' => $candRef,
                    'CL_Number'    => $client->CL_Number,
                    'CN_Number'    => $candRef,
                    'status'       => 'Un Read',
                    'created_at'   => now('Asia/Dubai'),
                ]);
            }

            if ($data['govt_total_amount'] > 0) {
                $gvPref = 'GV-INV-';
                $lastGv = GovtTransactionInvoice::where('invoice_number', 'like', $gvPref . '%')->lockForUpdate()->orderByDesc('invoice_number')->value('invoice_number');
                $seq    = $lastGv ? intval(substr($lastGv, strlen($gvPref))) + 1 : 1;
                $gvNo   = $gvPref . str_pad($seq, 5, '0', STR_PAD_LEFT);
                $gProof = $request->file('govt_payment_proof')?->store('govt_transaction_proofs', 'public');

                GovtTransactionInvoice::create([
                    'invoice_number'     => $gvNo,
                    'invoice_date'       => now('Asia/Dubai'),
                    'CL_Number'          => $client->CL_Number,
                    'CN_Number'          => $candRef,
                    'reference_no'       => $candRef,
                    'Customer_name'      => $client->first_name,
                    'Customer_mobile_no' => $client->mobile,
                    'canidate_name'      => $data['candidate_name'],
                    'Sales_name'         => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                    'total_amount'       => $data['govt_total_amount'],
                    'total_vat'          => $data['govt_vat_amount'],
                    'net_total'          => $data['govt_net_amount'],
                    'status'             => 'Pending',
                    'customer_note'      => $data['govt_payment_notes'],
                    'payment_proof'      => $gProof,
                    'payment_mode'       => $data['govt_payment_method'],
                    'created_by'         => Auth::id(),
                    'due_date'           => now('Asia/Dubai'),
                    'received_amount'    => $data['govt_received_amount'],
                    'remaining_amount'   => $data['govt_remaining_amount'],
                    'service_name'       => $data['govt_service_name'] ?: 'Visa Fee',
                ]);

                GovtTransactionInvoiceItem::create([
                    'invoice_number' => $gvNo,
                    'service_name'   => $data['govt_service_name'] ?: 'Visa Fee',
                    'qty'            => 1,
                    'amount'         => $data['govt_total_amount'],
                    'tax'            => $data['govt_vat_amount'],
                    'total'          => $data['govt_net_amount'],
                ]);

                $fin = $this->get_user_id('Finance Officer') ?? Auth::id();

                $this->add_notification([
                    'role'         => 'finance',
                    'user_id'      => $fin,
                    'title'        => "Approve {$gvNo}",
                    'message'      => "Approve {$gvNo}",
                    'ref_no'       => $candRef,
                    'reference_no' => $candRef,
                    'CL_Number'    => $client->CL_Number,
                    'CN_Number'    => $candRef,
                    'status'       => 'Un Read',
                    'created_at'   => now('Asia/Dubai'),
                ]);
            }

            if ($data['payment_terms'] === 'partial') {
                $max    = Installment::lockForUpdate()->selectRaw("MAX(CAST(SUBSTRING(reference_no,5) AS UNSIGNED)) m")->value('m');
                $insRef = 'INS-' . str_pad(($max ?? 0) + 1, 5, '0', STR_PAD_LEFT);

                $ins = Installment::create([
                    'reference_no'           => $insRef,
                    'agreement_no'           => $agrRef,
                    'invoice_number'         => $proNo,
                    'CL_Number'              => $client->CL_Number,
                    'CN_Number'              => $candRef,
                    'customer_name'          => trim($client->first_name . ' ' . $client->last_name),
                    'employee_name'          => $data['candidate_name'],
                    'passport_no'            => $data['passport_no'],
                    'contract_duration'      => $data['contract_duration'],
                    'contract_start_date'    => $data['trial_start_date'],
                    'contract_end_date'      => $data['trial_end_date'],
                    'package'                => $data['package'],
                    'contract_amount'        => $totalAmount,
                    'number_of_installments' => count($data['installments']),
                    'paid_installments'      => 0,
                    'created_by'             => Auth::id(),
                ]);

                foreach ($data['installments'] as $i) {
                    InstallmentItem::create([
                        'installment_id'    => $ins->id,
                        'particular'        => $i['description'] ?? '',
                        'amount'            => $i['amount'] ?? 0,
                        'payment_date'      => $i['paymentDate'] ?? null,
                        'invoice_generated' => 0,
                        'paid_date'         => null,
                        'status'            => 'Pending',
                    ]);
                }
            }

            Trial::create([
                'candidate_id'           => $candidate->id,
                'reference_no'           => $candRef,
                'candidate_name'         => $data['candidate_name'],
                'client_id'              => $data['client_id'],
                'package'                => $data['package'],
                'trial_type'             => in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true) ? 'package' : 'employee',
                'trial_status'           => 'Active',
                'agreement_reference_no' => $agrRef,
                'agreement_amount'       => $totalAmount,
                'remarks'                => $data['notes'],
                'trial_start_date'       => $data['trial_start_date'],
                'trial_end_date'         => $data['trial_end_date'],
                'number_of_days'         => $data['number_of_days'],
                'CL_Number'              => $client->CL_Number,
                'CN_Number'              => $candRef,
                'created_by'             => Auth::id(),
            ]);

            $pkgMap = [
                'PKG-1' => 'Package 1',
                'PKG-2' => 'Package 2',
                'PKG-3' => 'Package 3',
                'PKG-4' => 'Package 4',
            ];

            $visaMap = [
                'D-SPO'       => 'D-SPO',
                'D-HIRE'      => 'D-HIRE',
                'TADBEER'     => 'TADBEER',
                'OFFICE-VISA' => 'OFFICE-V',
                'OFFICE-V'    => 'OFFICE-V',
                'VISIT'       => 'TOURIST/VISIT',
                'TOURIST'     => 'TOURIST/VISIT',
            ];

            if (isset($pkgMap[$data['package']])) {
                try {
                    $zoho = new ZohoItemService;

                    if (!$zoho->itemExists($data['passport_no'])) {
                        $zoho->createItem([
                            'candidate_name'               => $data['candidate_name'],
                            'cf_package'                   => $pkgMap[$data['package']],
                            'cf_visa_type'                 => $visaMap[$data['visa_type']] ?? 'D-SPO',
                            'cf_passport_number'           => $data['passport_no'],
                            'cf_govt_fees'                 => $data['govt_total_amount'],
                            'cf_nationality'               => strtoupper($data['nationality']),
                            'cf_item_number'               => $candRef,
                            'cf_status'                    => 'Selected',
                            'cf_arrival_status'            => 'Not Arrived',
                            'cf_client_final_payment_done' => $data['payment_terms'] === 'partial' ? 'No' : 'Yes',
                            'cf_commission_status'         => 'Unpaid',
                        ]);
                    }
                } catch (\Throwable $e) {
                    Log::error('Zoho integration failed: ' . $e->getMessage());
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('insideAgreement error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to create agreement.',
                'error'   => $e->getMessage(),
            ], 500);
        }

        if ($data['client_id'] != 1) {
            try {
                $pendingRequest = clone $request;
                $pendingRequest->merge([
                    'ref_no'                   => $candRef,
                    'reference_no'             => $agrRef,
                    'agreement_reference_no'   => $agrRef,
                ]);

                $this->acctInv->createPendingInvoice(
                    $pendingRequest,
                    $paymentProof ?? ''
                );
            } catch (\Throwable $e) {
                Log::error('createPendingInvoice error: ' . $e->getMessage());
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Agreement created successfully.',
            'data'    => ['agreement' => $agreement],
        ], 201);
    }

    public function insideEMPAgreement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agreement_type'        => 'required|string|max:255',
            'candidate_id'          => 'required|integer',
            'candidate_name'        => 'required|string|max:255',
            'ref_no_prev'           => 'nullable|string|max:255',
            'client_id'             => 'required|integer',
            'package'               => 'required|string|max:255',
            'contract_duration'     => 'nullable|string',
            'salary'                => 'required|string|max:255',
            'monthly_payment'       => 'nullable|numeric|min:0',
            'initial_payment'       => 'required|numeric|min:0',
            'payment_cycle'         => 'nullable|integer|min:0',
            'months_count'          => 'nullable|integer|min:1',
            'inst_date'             => 'nullable|array',
            'inst_date.*'           => 'nullable|date',
            'inst_ref'              => 'nullable|array',
            'inst_ref.*'            => 'nullable|string|max:255',
            'inst_amount'           => 'nullable|array',
            'inst_amount.*'         => 'nullable|string|max:255',
            'visa_type'             => 'nullable|string|max:255',
            'foreign_partner'       => 'nullable|string|max:255',
            'expected_arrival_date' => 'nullable|date',
            'nationality'           => 'required|string|max:255',
            'passport_no'           => 'nullable|string|max:255',
            'passport_expiry_date'  => 'nullable|date',
            'date_of_birth'         => 'nullable|date',
            'payment_method'        => 'required|string',
            'payment_proof'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'total_amount'          => 'required|numeric|min:0',
            'received_amount'       => 'nullable|numeric|min:0',
            'number_of_days'        => 'nullable|integer',
            'installment_count'     => 'required|integer',
            'trial_start_date'      => 'required|date',
            'trial_end_date'        => 'required|date',
            'medical_certificate'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'govt_total_amount'     => 'nullable|numeric|min:0',
            'govt_received_amount'  => 'nullable|numeric|min:0',
            'govt_vat_amount'       => 'nullable|numeric|min:0',
            'govt_net_amount'       => 'nullable|numeric|min:0',
            'govt_payment_method'   => 'nullable|string|max:255',
            'govt_payment_proof'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'govt_payment_notes'    => 'nullable|string',
            'govt_service_name'     => 'nullable|string|max:255',
            'govt_remaining_amount' => 'nullable|numeric|min:0',
            'upcoming_payment_date' => 'nullable|date',
            'current_month_salary'  => 'nullable|string|max:255',
        ]);

        $validator->sometimes('payment_proof',   'required',              fn($i) => (float)$i->received_amount > 0);
        $validator->sometimes('payment_cycle',   'required',              fn($i) => (float)$i->monthly_payment > 0);
        $validator->sometimes('monthly_payment', 'required|numeric|min:1',fn($i) => (float)$i->monthly_payment > 0);
        
        $data = $validator->validate() + [
            'visa_type'             => 'D-SPO',
            'foreign_partner'       => null,
            'govt_total_amount'     => 0,
            'govt_received_amount'  => 0,
            'govt_remaining_amount' => 0,
            'govt_vat_amount'       => 0,
            'govt_net_amount'       => 0,
            'govt_payment_method'   => null,
            'govt_payment_notes'    => null,
            'govt_service_name'     => null,
            'number_of_days'        => 0,
        ];

        $data['payment_terms'] = ((float)$data['monthly_payment'] > 0 && (int)$data['payment_cycle'] > 0) ? 'partial' : 'full';

        if ($data['payment_terms'] === 'full') {
            $data['received_amount']  = (float)$data['total_amount'];
            $data['remaining_amount'] = 0;
            $data['payment_cycle']    = 0;
        } else {
            $data['received_amount']  = (float)$data['received_amount'];
            $data['remaining_amount'] = round(max(0, (float)$data['total_amount'] - $data['received_amount']), 2);
        }

        DB::beginTransaction();

        try {
            $client = CRM::lockForUpdate()->findOrFail($data['client_id']);
            if (! $client->CL_Number) {
                $seq = CRM::whereNotNull('CL_Number')->lockForUpdate()->count() + 1;
                do {
                    $client->CL_Number = 'CL-' . str_pad($seq++, 5, '0', STR_PAD_LEFT);
                } while (CRM::where('CL_Number', $client->CL_Number)->exists());
                $client->save();
            }

            $cancelNote = 'This agreement has been cancelled because this candidate has a new agreement.';
            Agreement::where('passport_no', $data['passport_no'])
                ->where('status', 5)
                ->each(function ($old) use ($cancelNote) {
                    $old->status = 4;
                    $old->notes  = $cancelNote . ' Ref: ' . $old->reference_no;
                    $old->save();
                    Contract::where('agreement_reference_no', $old->reference_no)
                        ->where('status', 1)
                        ->update(['status' => 2, 'remarks' => $old->notes]);
                    Invoice::where('agreement_reference_no', $old->reference_no)
                        ->update(['status' => 'Cancelled', 'notes' => $old->notes]);
                });

            $isPkg1 = in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true);
            $candModel = $isPkg1 ? Package::class : Employee::class;
            $refCol    = $isPkg1 ? 'hr_ref_no'   : 'reference_no';
            $prefix    = $isPkg1 ? 'CN-'         : 'EM-';
            $candidate = $candModel::lockForUpdate()->firstOrNew(['id' => $data['candidate_id']]);

            if (($candModel === Employee::class && $candidate->inside_status == 3) ||
                ($candModel === Package::class  && $candidate->inside_status == 5)) {
                DB::rollBack();
                return response()->json(['status' => 'error','message' => 'Incident not allowed.'], 422);
            }

            DB::table('office')
                ->where('candidate_id', $candidate->id)
                ->where('type', $candModel === Employee::class ? 'employee' : 'package')
                ->where('status', 1)
                ->update(['status' => 0]);

            if ($candModel === Package::class) {
                $lastCn = Package::whereNotNull('cn_number_series')->lockForUpdate()->orderByDesc('id')->value('cn_number_series');
                $seqCn  = $lastCn ? intval(substr($lastCn,3)) + 1 : 1;
                do {
                    $candidate->cn_number_series = 'CN-' . str_pad($seqCn++, 5, '0', STR_PAD_LEFT);
                } while (Package::where('cn_number_series', $candidate->cn_number_series)->exists());
            }

            if (! $candidate->$refCol) {
                $seq = $candModel::whereNotNull($refCol)->lockForUpdate()->count() + 1;
                do {
                    $candidate->$refCol = $prefix . str_pad($seq++, 5, '0', STR_PAD_LEFT);
                } while ($candModel::where($refCol, $candidate->$refCol)->exists());
            }

            $candidate->save();
            $candRef = $candidate->$refCol;

            $prefMap = ['BOA.P1'=>'BOA-P1-','BOA.E'=>'BOA-E-','BIA.P1'=>'BIA-P1-','BIA.E'=>'BIA-E-'];
            $isPkg1 = in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true);
            $key = $data['agreement_type'] . '.' . ($isPkg1 ? 'P1' : 'E');
            $agrPref = $prefMap[$key] ?? 'AGR-';
            $lastAgr = Agreement::where('reference_no','like',$agrPref.'%')->lockForUpdate()->orderByDesc('id')->value('reference_no');
            $seqA    = $lastAgr ? intval(substr($lastAgr,strlen($agrPref)))+1 : 1;
            do {
                $agrRef = $agrPref . str_pad($seqA++,5,'0',STR_PAD_LEFT);
            } while (Agreement::where('reference_no',$agrRef)->exists());

            $paymentProof = $request->file('payment_proof')?->store('payment_proofs','public');
            $medCert      = $request->file('medical_certificate')?->store('payment_certificates','public');

            $agreement = Agreement::create([
                'reference_no'           => $agrRef,
                'agreement_type'         => $data['agreement_type'],
                'candidate_id'           => $data['candidate_id'],
                'candidate_name'         => $data['candidate_name'],
                'reference_of_candidate' => $candRef,
                'ref_no_in_of_previous'  => $data['ref_no_prev'] ?: $candRef,
                'client_id'              => $data['client_id'],
                'CL_Number'              => $client->CL_Number,
                'CN_Number'              => $candRef,
                'package'                => $data['package'],
                'salary'                 => $data['salary'],
                'monthly_payment'        => $data['monthly_payment'] ?? 0,
                'initial_payment'        => $data['initial_payment'],
                'payment_cycle'          => $data['payment_cycle'] ?? 0,
                'months_count'           => $data['months_count'],
                'upcoming_payment_date'  => $data['upcoming_payment_date'],
                'current_month_salary'   => $data['current_month_salary'],
                'number_of_installments' => $data['installment_count'],
                'visa_type'              => $data['visa_type'],
                'foreign_partner'        => $data['foreign_partner'],
                'nationality'            => $data['nationality'],
                'passport_no'            => $data['passport_no'],
                'passport_expiry_date'   => $data['passport_expiry_date'] ?? null,
                'date_of_birth'          => $data['date_of_birth'] ?? null,
                'payment_method'         => $data['payment_method'],
                'total_amount'           => (float)$data['total_amount'],
                'received_amount'        => $data['received_amount'],
                'remaining_amount'       => $data['remaining_amount'] ?? 0,
                'payment_proof'          => $paymentProof,
                'contract_duration'      => $data['contract_duration'] ?? '',
                'number_of_days'         => $data['number_of_days'] ?? 0,
                'agreement_start_date'   => $data['trial_start_date'],
                'agreement_end_date'     => $data['trial_end_date'],
                'medical_certificate'    => $medCert,
                'installment_count'      => $data['installment_count'],
                'govt_total_amount'      => $data['govt_total_amount'],
                'govt_received_amount'   => $data['govt_received_amount'],
                'govt_remaining_amount'  => $data['govt_remaining_amount'],
                'govt_vat_amount'        => $data['govt_vat_amount'],
                'govt_net_amount'        => $data['govt_net_amount'],
                'govt_payment_method'    => $data['govt_payment_method'],
                'govt_payment_notes'     => $data['govt_payment_notes'],
                'govt_service_name'      => $data['govt_service_name'],
                'govt_payment_proof'     => $request->file('govt_payment_proof')?->store('govt_transaction_proofs','public'),
                'created_by'             => Auth::id(),
                'status'                 => 1,
            ]);

            $candidate->inside_status = 2;
            $candidate->save();

            if ($medCert) {
                CandidateAttachment::updateOrCreate(
                    ['candidate_id'=>$data['candidate_id'],'attachment_type'=>'Medical Certificate'],
                    ['attachment_file'=>$medCert,'attachment_name'=>$request->file('medical_certificate')->getClientOriginalName(),'created_by'=>Auth::id()]
                );
            }

            $isPkg1  = in_array($data['package'], ['PKG-1', 'PACKAGE 1'], true);
            $taxPref = $isPkg1 ? 'INV-P1-' : 'INV-E-';
            $lastTax = Invoice::where('invoice_number','like',$taxPref.'%')->lockForUpdate()->orderByDesc('invoice_id')->value('invoice_number');
            $seqT    = $lastTax ? intval(substr($lastTax,strlen($taxPref)))+1 : 1;
            do {
                $taxNo = $taxPref.str_pad($seqT++,5,'0',STR_PAD_LEFT);
            } while (Invoice::where('invoice_number',$taxNo)->exists());

            $balanceDue = $data['payment_terms']==='full' ? 0 : $data['remaining_amount'];

            $taxInv = Invoice::create([
                'invoice_number'         => $taxNo,
                'agreement_reference_no' => $agrRef,
                'customer_id'            => $data['client_id'],
                'reference_no'           => $candRef,
                'CL_Number'              => $client->CL_Number,
                'CN_Number'              => $candRef,
                'invoice_type'           => 'Tax',
                'payment_method'         => $data['payment_method'],
                'received_amount'        => $data['received_amount'],
                'invoice_date'           => now('Asia/Dubai'),
                'due_date'               => now('Asia/Dubai'),
                'total_amount'           => (float)$data['total_amount'],
                'discount_amount'        => 0,
                'tax_amount'             => 0,
                'balance_due'            => $balanceDue,
                'status'                 => 'Pending',
                'upcoming_payment_date'  => $data['upcoming_payment_date'],
                'payment_proof'          => $paymentProof,
                'created_by'             => Auth::id(),
            ]);

            InvoiceItem::create([
                'invoice_id'   => $taxInv->invoice_id,
                'product_name' => 'Tax Invoice for '.$agrRef,
                'quantity'     => 1,
                'unit_price'   => (float)$data['total_amount'],
                'total_price'  => (float)$data['total_amount'],
            ]);

            if ($data['payment_terms'] === 'partial') {
                $max    = Installment::lockForUpdate()->selectRaw("MAX(CAST(SUBSTRING(reference_no,5) AS UNSIGNED)) m")->value('m');
                $insRef = 'INS-'.str_pad(($max ?? 0)+1,5,'0',STR_PAD_LEFT);

                $ins = Installment::create([
                    'reference_no'           => $insRef,
                    'agreement_no'           => $agrRef,
                    'invoice_number'         => $taxNo,
                    'CL_Number'              => $client->CL_Number,
                    'CN_Number'              => $candRef,
                    'customer_name'          => trim($client->first_name.' '.$client->last_name),
                    'employee_name'          => $data['candidate_name'],
                    'passport_no'            => $data['passport_no'],
                    'contract_duration'      => $data['contract_duration'] ?? '',
                    'contract_start_date'    => $data['trial_start_date'],
                    'contract_end_date'      => $data['trial_end_date'],
                    'package'                => $data['package'],
                    'contract_amount'        => (float)$data['total_amount'],
                    'number_of_installments' => $data['installment_count'],
                    'paid_installments'      => 0,
                    'created_by'             => Auth::id(),
                ]);

                $dates = $request->input('inst_date', []);
                $refs  = $request->input('inst_ref', []);
                $amounts = $request->input('inst_amount', []);
                $proofs = $request->file('inst_proof', []);

                foreach ($dates as $idx => $date) {
                    if (! $date) continue;
                    $proofPath = isset($proofs[$idx]) ? $proofs[$idx]->store('installment_proofs','public') : null;
                    InstallmentItem::create([
                        'installment_id'    => $ins->id,
                        'particular'        => 'Installment '.($idx+1),
                        'amount'            => $amounts[$idx],
                        'payment_date'      => $date,
                        'reference_no'      => $refs[$idx] ?? null,
                        'payment_proof'     => $proofPath,
                        'invoice_generated' => 0,
                        'paid_date'         => null,
                        'status'            => 'Pending',
                        'invoice_number'    => $taxNo,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Agreement created successfully.',
                'data'    => ['agreement'=>$agreement,'invoice'=>$taxInv]
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('insideEMPAgreement error: '.$e->getMessage(), ['trace'=>$e->getTraceAsString()]);
            return response()->json(['status'=>'error','message'=>'Failed to create agreement.','error'=>$e->getMessage()],500);
        }
    }

    public function show(string $reference_no)
    {
        $agreement = $this->findAgreementOrFail($reference_no);
        $candidate  = null;

        if ($agreement->candidate_id) {
            switch ($agreement->agreement_type) {
                case 'BIA':
                    if (in_array($agreement->package, ['PKG-1', 'PACKAGE 1'], true)) {
                        $candidate = Package::find($agreement->candidate_id);
                    } elseif (in_array($agreement->package, ['PKG-2', 'PKG-3', 'PKG-4'], true)) {
                        $candidate = Employee::find($agreement->candidate_id);
                    }
                    break;
                default:
                    $candidate = NewCandidate::find($agreement->candidate_id);
            }
        }

        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        if ((string) $agreement->marked == 'No') {
            if (Auth::user()->role === 'Archive Clerk') {
                $view = $this->resolveView($agreement, 'show');
            }else{
                return view('agreements.agreement_non_approved_page', compact('agreement', 'candidate', 'now'));
            }
            
        }else{
            $view = $this->resolveView($agreement, 'show');
        }
        return view($view, compact('agreement', 'candidate', 'now'));
    }

    public function download(string $reference_no)
    {
        $agreement = $this->findAgreementOrFail($reference_no);
        $candidate = null;
        if ($agreement->candidate_id) {
            if (in_array($agreement->package, ['PKG-1', 'PACKAGE 1'], true)) {
                $candidate = Package::find($agreement->candidate_id);
            } elseif (
                in_array(
                    $agreement->package,
                    ['PKG-2', 'PACKAGE 2', 'PKG-3', 'PACKAGE 3', 'PKG-4', 'PACKAGE 4'],
                    true
                )
            ) {

                $candidate = Employee::find($agreement->candidate_id);
            } else {
                $candidate = NewCandidate::find($agreement->candidate_id);
            }
        }

        $now       = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $subdomain = explode('.', request()->getHost())[0];

        $headerFile = "{$subdomain}_header.jpg";
        $footerFile = "{$subdomain}_footer.jpg";

        $headerUrl = file_exists(public_path("assets/img/{$headerFile}"))
            ? asset("assets/img/{$headerFile}")
            : null;

        $footerUrl = file_exists(public_path("assets/img/{$footerFile}"))
            ? asset("assets/img/{$footerFile}")
            : null;

        $view = $this->resolveView($agreement, 'download');
        
        $pdf = PDF::loadView($view, compact('agreement', 'candidate', 'now', 'headerUrl', 'footerUrl'))
            ->setPaper('A4')
            ->setOption('enable-local-file-access', true)
            ->setOption('encoding', 'UTF-8');

        return $pdf->stream("agreement_{$agreement->reference_no}.pdf");
    }

    public function insideDownload(string $reference_no)
    {
        $agreement = $this->findAgreementOrFail($reference_no);
        $candidate = null;
        if ($agreement->candidate_id) {
            if (in_array($agreement->package, ['PKG-1', 'PACKAGE 1'], true)) {
                $candidate = Package::find($agreement->candidate_id);
            } elseif (
                in_array(
                    $agreement->package,
                    ['PKG-2', 'PKG-3', 'PKG-4', 'PACKAGE 2', 'PACKAGE 3', 'PACKAGE 4'],
                    true
                )
            ) {

                $candidate = Employee::find($agreement->candidate_id);
            } else {
                $candidate = NewCandidate::find($agreement->candidate_id);
            }
        }

        $now       = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $subdomain = explode('.', request()->getHost())[0];

        $headerFile = "{$subdomain}_header.jpg";
        $footerFile = "{$subdomain}_footer.jpg";

        $headerUrl = file_exists(public_path("assets/img/{$headerFile}"))
            ? asset("assets/img/{$headerFile}")
            : null;

        $footerUrl = file_exists(public_path("assets/img/{$footerFile}"))
            ? asset("assets/img/{$footerFile}")
            : null;

        $view = $this->resolveView($agreement, 'download');

        $pdf = PDF::loadView($view, compact('agreement', 'candidate', 'now', 'headerUrl', 'footerUrl'))
            ->setPaper('A4')
            ->setOption('enable-local-file-access', true)
            ->setOption('encoding', 'UTF-8');

        return $pdf->stream("agreement_{$agreement->reference_no}.pdf");
    }

    private function findAgreementOrFail(string $reference_no): Agreement
    {
        $ref       = trim($reference_no);
        $agreement = Agreement::whereRaw('LOWER(reference_no)=?', [strtolower($ref)])->first();

        if (! $agreement) {
            abort(404, "Agreement \"{$reference_no}\" not found.");
        }

        return $agreement;
    }

    public function pdf(string $reference_no)
    {
        $agreement = $this->findAgreementOrFail($reference_no);

        $candidate = null;
        if ($agreement->candidate_id) {
            $candidate = in_array($agreement->package, ['PKG-1', 'PACKAGE 1'], true)
                ? Package::find($agreement->candidate_id)
                : (
                    in_array(
                        $agreement->package,
                        ['PKG-2', 'PACKAGE 2', 'PKG-3', 'PACKAGE 3', 'PKG-4', 'PACKAGE 4'],
                        true
                    )
                    ? Employee::find($agreement->candidate_id)
                    : NewCandidate::find($agreement->candidate_id)
                );
        }

        $now       = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $subdomain = explode('.', request()->getHost())[0];

        $headerFile = "{$subdomain}_header.jpg";
        $footerFile = "{$subdomain}_footer.jpg";

        $headerUrl = file_exists(public_path("assets/img/{$headerFile}"))
            ? asset("assets/img/{$headerFile}")
            : null;

        $footerUrl = file_exists(public_path("assets/img/{$footerFile}"))
            ? asset("assets/img/{$footerFile}")
            : null;

        $view = $this->resolveView($agreement, 'download');

        $pdfContent = PDF::loadView($view, compact(
                'agreement',
                'candidate',
                'now',
                'headerUrl',
                'footerUrl'
            ))
            ->setPaper('A4')
            ->setOption('enable-local-file-access', true)
            ->setOption('encoding', 'UTF-8')
            ->output();

        return response($pdfContent, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="agreement_'.$reference_no.'.pdf"',
        ]);
    }

    private function resolveView(Agreement $agreement, string $mode): string
    {
        $suffix = $mode == 'show' ? '' : '_download';

        if ($agreement->agreement_type == 'BOA') {
            return "agreements.outside_agreement{$suffix}";
        }

        if ($agreement->agreement_type == 'BIA') {
            $packageCode  = $agreement->package;
            $insideStatus = Package::find($agreement->CN_Number)?->inside_status;

            switch ($packageCode) {
                case 'PKG-1':
                case 'PACKAGE 1':
                    $trial   = Trial::find($agreement->reference_no);
                    $viewKey = ($trial && $trial->status === 'Confirmed') ? 'trial_contract' : 'trial_agreement';
                    break;

                case 'PKG-2':
                case 'PACKAGE 2':
                    $viewKey = 'package2_agreement';
                    break;

                case 'PKG-3':
                case 'PACKAGE 3':
                    $viewKey = 'package3_agreement';
                    break;

                case 'PKG-4':
                case 'PACKAGE 4':
                    $viewKey = 'package4_agreement';
                    break;

                default:
                    $viewKey = 'outside_agreement';
                    break;
            }

            return "agreements.{$viewKey}{$suffix}";
        }

        return "agreements.outside_agreement{$suffix}";
    }

    public function edit(Agreement $agreement)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        $customers = CRM::orderBy('first_name')
            ->orderBy('last_name')
            ->get(['id','first_name','last_name','CL_Number']);

        $candidates = NewCandidate::select('id','candidate_name','CN_Number','passport_no','passport_expiry_date','date_of_birth','nationality','visa_type','current_status')
            ->where(function ($q) use ($agreement) {
                $q->where('current_status', 1)
                  ->orWhere('id', $agreement->candidate_id);
            })
            ->orderBy('candidate_name')
            ->get();

        return view('agreements.edit', compact('agreement','now','customers','candidates'));
    }

    public function update(Request $request, Agreement $agreement)
    {
        $validated = $request->validate([
            'client_id'            => ['required','integer','exists:crms,id'],
            'candidate_id'         => ['required','integer','exists:new_candidates,id'],
            'total_amount'         => ['required','numeric','min:0'],
            'received_amount'      => ['required','numeric','min:0','lte:total_amount'],
            'agreement_start_date' => ['required','date'],
            'agreement_end_date'   => ['required','date','after_or_equal:agreement_start_date'],
            'notes'                => ['nullable','string','max:2000'],
            'visa_type'            => ['nullable','string','max:255'],
        ]);

        DB::transaction(function () use ($validated, $agreement) {

            $client = CRM::lockForUpdate()->findOrFail($validated['client_id']);
            if (!$client->CL_Number) {
                $n = CRM::whereNotNull('CL_Number')->count();
                do {
                    $n++;
                    $client->CL_Number = 'CL-' . str_pad($n, 5, '0', STR_PAD_LEFT);
                } while (CRM::where('CL_Number', $client->CL_Number)->exists());
                $client->save();
            }

            $cand = NewCandidate::lockForUpdate()->findOrFail($validated['candidate_id']);
            if (!$cand->CN_Number) {
                $n = NewCandidate::whereNotNull('CN_Number')->count();
                do {
                    $n++;
                    $cand->CN_Number = 'CN-' . str_pad($n, 5, '0', STR_PAD_LEFT);
                } while (NewCandidate::where('CN_Number', $cand->CN_Number)->exists());
                $cand->save();
            }

            $start     = Carbon::parse($validated['agreement_start_date'])->toDateString();
            $end       = Carbon::parse($validated['agreement_end_date'])->toDateString();
            $days      = Carbon::parse($start)->diffInDays(Carbon::parse($end)) + 1;
            $remaining = max(0, round($validated['total_amount'] - $validated['received_amount'], 2));

            $agreement->update([
                'client_id'            => (int)$client->id,
                'CL_Number'            => $client->CL_Number,
                'candidate_id'         => (int)$cand->id,
                'CN_Number'            => $cand->CN_Number,
                'candidate_name'       => $cand->candidate_name,
                'nationality'          => $cand->nationality,
                'passport_no'          => $cand->passport_no,
                'passport_expiry_date' => $cand->passport_expiry_date ? Carbon::parse($cand->passport_expiry_date)->toDateString() : null,
                'date_of_birth'        => $cand->date_of_birth ? Carbon::parse($cand->date_of_birth)->toDateString() : null,
                'visa_type'            => $validated['visa_type'] ?? $cand->visa_type,
                'total_amount'         => (float)$validated['total_amount'],
                'received_amount'      => (float)$validated['received_amount'],
                'remaining_amount'     => $remaining,
                'agreement_start_date' => $start,
                'agreement_end_date'   => $end,
                'number_of_days'       => $days,
                'notes'                => $validated['notes'] ?? null,
            ]);

            $invoices = Invoice::where('agreement_reference_no', $agreement->reference_no)
                ->lockForUpdate()
                ->get();

            foreach ($invoices as $inv) {
                $inv->customer_id     = $client->id;
                $inv->CL_Number       = $client->CL_Number;
                $inv->CN_Number       = $cand->CN_Number;
                $inv->total_amount    = (float)$validated['total_amount'];
                $inv->received_amount = (float)$validated['received_amount'];
                $inv->balance_due     = $remaining;
                $inv->save();

                $item = InvoiceItem::where('invoice_id', $inv->invoice_id)
                    ->where('product_name', 'Agreement: ' . $agreement->reference_no)
                    ->first();

                if (!$item) {
                    $item = InvoiceItem::where('invoice_id', $inv->invoice_id)->first();
                }

                if ($item) {
                    $item->product_name = "Agreement : ".$agreement->reference_no;
                    $item->unit_price  = (float)$validated['total_amount'];
                    $item->total_price = (float)$validated['total_amount'];
                    $item->save();
                }
            }
        });

        return redirect()
            ->route('agreements.edit', $agreement->reference_no)
            ->with('success', 'Agreement, customer/candidate links, and related invoices updated successfully.');
    }

    public function updateStatus(Request $request, $agreementId)
    {
        $agreement = Agreement::find($agreementId);

        if (!$agreement) {
            return response()->json(['success' => false, 'message' => 'Agreement not found.']);
        }

        $agreement->status = $request->status_id;
        $agreement->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'statusColor' => $this->getStatusColor($agreement->status)
        ]);
    }

    public function getStatusColor($status)
    {
        switch ($status) {
            case 1:
                return '#ffc107'; 
            case 2:
                return '#28a745';
            case 3:
                return '#dc3545';
            default:
                return '#ffffff';
        }
    }

    public function addPayment($contractId)
    {
        $agreement = Agreement::find($contractId);

        if (!$agreement) {
            return redirect()->route('agreements.index')->with('error', 'Agreement not found.');
        }

        return view('agreements.add-payment', compact('agreement'));
    }

    public function convertToContract($contractId)
    {
        $agreement = Agreement::find($contractId);

        if (!$agreement) {
            return redirect()->route('agreements.index')->with('error', 'Agreement not found.');
        }

        $contract = new Contract();
        $contract->agreement_id = $agreement->id;
        $contract->status = 'Active';
        $contract->save();

        $agreement->status = 3;
        $agreement->save();

        return redirect()->route('agreements.index')->with('success', 'Agreement successfully converted to contract.');
    }

    public function printAgreement($contractId)
    {
        $agreement = Agreement::find($contractId);

        if (!$agreement) {
            return redirect()->route('agreements.index')->with('error', 'Agreement not found.');
        }

        $pdf = \PDF::loadView('agreements.print', compact('agreement'));
        return $pdf->download('agreement_'.$agreement->id.'.pdf');
    }

    public function deliverMad($contractId)
    {
        $agreement = Agreement::find($contractId);

        if (!$agreement) {
            return redirect()->route('agreements.index')->with('error', 'Agreement not found.');
        }

        return redirect()->route('agreements.index')->with('success', 'MAD delivered successfully.');
    }

    public function shareAgreement($contractId)
    {
        $agreement = Agreement::find($contractId);

        if (!$agreement) {
            return redirect()->route('agreements.index')->with('error', 'Agreement not found.');
        }

        return redirect()->route('agreements.index')->with('success', 'Agreement shared successfully.');
    }

    public function destroy(string $referenceNo): JsonResponse
    {
        $agreements = Agreement::where('reference_no', $referenceNo)
            ->with(['invoices.items'])
            ->get();

        if ($agreements->isEmpty()) {
            return response()->json([
                'status'  => 'error',
                'message' => "No agreement found for reference {$referenceNo}.",
            ], 404);
        }

        DB::transaction(function () use ($agreements) {
            foreach ($agreements as $agreement) {
                foreach ($agreement->invoices as $invoice) {
                    $invoice->items()->delete();
                    $invoice->delete();
                }
                $agreement->delete();
            }
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Agreement(s), related invoices, and invoice items deleted.',
        ]);
    }

    public function delete_service($id){
        $deleted = DB::table('government_transactions')->where('id', $id)->delete();
        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Service deleted successfully!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Service not found or already deleted!',
        ], 404);
    }

    public function deliverMaid($referenceNo)
    {
        $agreement = Agreement::where('reference_no', $referenceNo)->firstOrFail();
        return redirect()->route('agreements.show', $referenceNo)->with('success', 'Maid delivery processed successfully.');
    }

    public function agreement_contract_tracker(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $query = Agreement::with('client')
            ->whereIn('status', [2, 5])
            ->whereIn('package', ['PKG-2', 'PKG-3', 'PKG-4'])
            ->orderBy('id', 'desc');

        if ($request->filled('package') && $request->package !== 'all') {
            $query->where('package', $request->package);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->filled('global_search')) {
            $search = $request->global_search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_number', 'like', '%' . $search . '%')
                  ->orWhere('client_number', 'like', '%' . $search . '%')
                  ->orWhere('agreement_no', 'like', '%' . $search . '%');
            });
        }
        if ($request->filled('customer_number')) {
            $query->where('customer_number', 'like', '%' . $request->customer_number . '%');
        }
        if ($request->filled('client_number')) {
            $query->where('client_number', 'like', '%' . $request->client_number . '%');
        }
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $agreements = $query->paginate(10);

        if ($request->ajax()) {
            return view('agreements.partials.agreement_contract_tracker_table', [
                'agreements' => $agreements,
                'now' => $now,
            ]);
        }

        return view('agreements.agreement_contract_tracker', [
            'agreements' => $agreements,
            'now' => $now,
        ]);
    }

    public function payroll(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $totalPayrolls     = Payroll::count();
        $pendingPayrolls   = Payroll::where('status', 1)->count();
        $approvedPayrolls  = Payroll::where('status', 2)->count();
        $cancelledPayrolls = Payroll::where('status', 3)->count();
        $query = Payroll::with('details')->latest();
        if ($request->filled('status') && $request->status !== 'all') {
            $map = ['pending' => 1, 'approved' => 2, 'cancelled' => 3];
            $query->where('status', $map[$request->status] ?? $request->status);
        }

        if ($request->filled('reference')) {
            $query->where('id', 'like', '%'.$request->reference.'%');
        }

        if ($request->filled('employee_id')) {
            $query->whereHas('details',
                fn ($q) => $q->where('CN_Number', 'like', '%'.$request->employee_id.'%'));
        }

        if ($request->filled('employee_name')) {
            $query->whereHas('details',
                fn ($q) => $q->where('agreement_reference_no', 'like', '%'.$request->employee_name.'%'));
        }

        if ($request->filled('from_date')) {
            $query->whereDate('pay_period_start', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('pay_period_end', '<=', $request->to_date);
        }

        $payrolls = $query->paginate(10);

        if ($request->ajax()) {
            return view('agreements.partials.payroll_table', compact(
                'payrolls', 'now',
                'totalPayrolls', 'pendingPayrolls', 'approvedPayrolls', 'cancelledPayrolls'
            ))->render();
        }

        return view('agreements.payroll', compact(
            'payrolls', 'now',
            'totalPayrolls', 'pendingPayrolls', 'approvedPayrolls', 'cancelledPayrolls'
        ));
    }

    public function save_payroll(Request $request)
    {
        $data = $request->validate([
            'pay_period_start' => 'required|date',
            'pay_period_end'   => 'required|date|after_or_equal:pay_period_start',
            'notes'            => 'required|string|max:1000',
        ]);

        $start = Carbon::parse($data['pay_period_start'])->startOfDay();
        $end   = Carbon::parse($data['pay_period_end'])->endOfDay();

        $generateReference = function (): string {
            $prefix = 'PR-';
            $length = 5;
            $latest = Payroll::orderByDesc('id')->value('reference_no');
            $current = $latest ? (int) preg_replace('/\D/', '', $latest) + 1 : 1;
            return $prefix . str_pad($current, $length, '0', STR_PAD_LEFT);
        };

        DB::beginTransaction();

        try {
            do {
                $reference_no = $generateReference();
            } while (Payroll::where('reference_no', $reference_no)->exists());

            $payroll = Payroll::create([
                'reference_no'         => $reference_no,
                'pay_period_start'     => $start->toDateString(),
                'pay_period_end'       => $end->toDateString(),
                'number_of_candidates' => 0,
                'total_amount'         => 0,
                'status'               => 1,
                'created_by'           => Auth::id(),
                'type'                 => 'Salary',
                'remarks'              => $data['notes'],
            ]);

            $agreements = Agreement::whereIn('status', [2, 5])
                ->whereDate('agreement_start_date', '<=', $end)
                ->whereDate('agreement_end_date',   '>=', $start)
                ->get();

            $total = 0;
            $count = 0;

            foreach ($agreements as $agr) {
                if (!is_numeric($agr->salary) || $agr->salary <= 0) {
                    continue;
                }

                $rawOverlapStart = Carbon::parse(max($agr->agreement_start_date, $start))->startOfDay();
                $rawOverlapEnd   = Carbon::parse(min($agr->agreement_end_date,   $end))->endOfDay();

                if ($rawOverlapEnd->lt($rawOverlapStart)) {
                    continue;
                }

                $lastPaidInfo = PayrollDetail::where('CN_Number', $agr->CN_Number)
                    ->join('payrolls', 'payrolls.id', '=', 'payroll_details.payroll_id')
                    ->select('payrolls.pay_period_end')
                    ->where('payrolls.pay_period_end', '<=', $end->toDateString())
                    ->orderByDesc('payrolls.pay_period_end')
                    ->first();

                if ($lastPaidInfo) {
                    $lastPaidPayrollEnd = Carbon::parse($lastPaidInfo->pay_period_end)->endOfDay();
                    if ($lastPaidPayrollEnd->gte($rawOverlapEnd)) {
                        continue;
                    }
                    $adjustedOverlapStart = $lastPaidPayrollEnd->copy()->addDay()->startOfDay();
                } else {
                    $adjustedOverlapStart = $rawOverlapStart;
                }

                $adjustedOverlapEnd = $rawOverlapEnd;

                if ($adjustedOverlapEnd->lt($adjustedOverlapStart)) {
                    continue;
                }

                $days = $adjustedOverlapStart->diffInDays($adjustedOverlapEnd) + 1;

                if ($days > 30) {
                    $days = 30;
                }

                $amount = round(($agr->salary / 30) * $days, 2);

                PayrollDetail::create([
                    'payroll_id'             => $payroll->id,
                    'CN_Number'              => $agr->CN_Number,
                    'agreement_reference_no' => $agr->reference_no,
                    'salary_amount'          => $agr->salary,
                    'payable_amount'         => $amount,
                    'number_of_days'         => $days,
                    'agreement_start_date'   => $agr->agreement_start_date,
                    'agreement_end_date'     => $agr->agreement_end_date,
                ]);

                $total += $amount;
                $count++;
            }

            $payroll->update([
                'number_of_candidates' => $count,
                'total_amount'         => $total,
            ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Payroll has been generated successfully.',
                'id'      => $payroll->id,
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to generate payroll. Please try again.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function payroll_sheet(string $reference_no)
    {
        $payroll = Payroll::with('details.agreement')
            ->where('reference_no', $reference_no)
            ->firstOrFail();

        $details = $payroll->details;

        return view('agreements.payroll_detail', compact('payroll', 'details'));
    }

    public function govt_services(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        $govtServicesQuery = GovernmentService::query()->orderBy('id', 'desc');

        if ($request->filled('name')) {
            $govtServicesQuery->where('service_name', 'like', '%' . $request->name . '%');
        }

        $govtServices = $govtServicesQuery->paginate(10);

        if ($request->ajax()) {
            return view('agreements.partials.govt_services_table', [
                'services' => $govtServices,
                'now' => $now,
            ]);
        }

        return view('agreements.govt_services', [
            'services ' => $govtServices,
            'now' => $now,
        ]);
    }

    public function liveSalaryOfMonth()
    {
        $data = $this->getLiveSalaryData();
        return view('agreements.partials.live_salary', $data);
    }

    public function exportLiveSalaryPdf()
    {
        $data = $this->getLiveSalaryData();
        $pdf  = PDF::loadView('agreements.partials.live_salary_pdf', $data)
                   ->setPaper('a4', 'landscape');
        return $pdf->download('live_salary.pdf');
    }

    private function getLiveSalaryData(): array
    {
        $monthStart   = Carbon::now()->startOfMonth()->startOfDay();
        $today        = Carbon::now()->startOfDay();
        $daysInMonth  = $monthStart->daysInMonth;

        $contracts = Contract::with('agreement')
            ->where('maid_delivered', 'Yes')
            ->whereHas('agreement', fn ($q) =>
                $q->whereNotIn('package', ['PKG-1', 'PACKAGE 1'])
            )
            ->whereDate('contract_start_date', '<=', $today)
            ->whereDate('contract_end_date',   '>=', $monthStart)
            ->get()
            ->unique(fn($c) => $c->agreement->passport_no)
            ->sortBy(fn($c) => $c->agreement->reference_no)
            ->values();

        $rows = [];
        foreach ($contracts as $c) {
            $agr     = $c->agreement;
            $salary  = $agr->monthly_payment;
            $cs      = Carbon::parse($c->contract_start_date)->startOfDay();
            $ce      = Carbon::parse($c->contract_end_date)->startOfDay();
            $start   = $cs->greaterThan($monthStart) ? $cs : $monthStart;
            $end     = $ce->lessThan($today)        ? $ce : $today;
            if ($start->greaterThan($end)) {
                continue;
            }
            $daysWorked = $start->diffInDays($end) + 1;
            if ($daysWorked > $daysInMonth) {
                $daysWorked = $daysInMonth;
            }
            $duration   = $daysWorked === $daysInMonth ? '1 Month' : "{$daysWorked} Days";
            $calculated = round(($salary / $daysInMonth) * $daysWorked, 2);

            $rows[] = [
                'CN'            => $agr->CN_Number,
                'name'          => $agr->candidate_name,
                'contractStart' => $c->contract_start_date,
                'contractEnd'   => $c->contract_end_date,
                'duration'      => $duration,
                'basic'         => round($salary, 2),
                'calculated'    => $calculated,
            ];
        }

        $totalEmployees = count($rows);
        $totalPayable   = collect($rows)->sum('calculated');

        return compact('rows', 'totalEmployees', 'totalPayable');
    }

    public function generateInstallmentInvoice(Request $request)
    {
        $data = $request->validate([
            'id'             => 'required|integer|exists:installment_items,id',
            'installment_id' => 'required|integer|exists:installments,id',
            'amount'         => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();

        try {
            $item = InstallmentItem::lockForUpdate()->findOrFail($data['id']);

            if ($item->invoice_generated) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Invoice already generated for this installment item.',
                ], 422);
            }

            $installment = Installment::lockForUpdate()->findOrFail($data['installment_id']);

            $baseInvoice = $installment->invoice_number
                ? Invoice::where('invoice_number', $installment->invoice_number)->first()
                : null;

            $prefix     = 'INV-INS-';
            $agreement = Agreement::where('CL_Number', $installment->CL_Number)
                     ->firstOrFail();
            $customerId = $agreement->client_id;
            $lastSeq = Invoice::lockForUpdate()
                ->where('invoice_number', 'like', $prefix . '%')
                ->max(DB::raw("CAST(SUBSTRING(invoice_number, LENGTH('$prefix') + 1) AS UNSIGNED)")) ?? 0;

            do {
                $lastSeq++;
                $invoiceNumber = $prefix . str_pad($lastSeq, 5, '0', STR_PAD_LEFT);
            } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

            $invoice = Invoice::create([
                'invoice_number'         => $invoiceNumber,
                'agreement_reference_no' => $installment->agreement_no,
                'customer_id'            => $customerId,
                'reference_no'           => $installment->reference_no,
                'CL_Number'              => $installment->CL_Number,
                'CN_Number'              => $installment->CN_Number,
                'invoice_type'           => 'Installment',
                'payment_method'         => 'Pending',
                'received_amount'        => 0,
                'invoice_date'           => now('Asia/Dubai'),
                'due_date'               => now('Asia/Dubai'),
                'total_amount'           => $data['amount'],
                'discount_amount'        => 0,
                'tax_amount'             => 0,
                'balance_due'            => $data['amount'],
                'status'                 => 'Pending',
                'payment_proof'          => null,
                'notes'                  => 'Generated from installment scheduler',
                'created_by'             => Auth::id(),
            ]);

            InvoiceItem::create([
                'invoice_id'   => $invoice->invoice_id,
                'product_name' => $item->particular.' for agreement reference # ' . $installment->reference_no,
                'quantity'     => 1,
                'unit_price'   => $data['amount'],
                'total_price'  => $data['amount'],
            ]);

            $item->update([
                'invoice_generated' => 1,
                'invoice_number'    => $invoiceNumber,
            ]);

            $this->add_notification([
                'role'         => 'finance',
                'user_id'      => $this->get_user_id('Finance Officer'),
                'title'        => 'Approve ' . $invoiceNumber,
                'message'      => 'Approve ' . $invoiceNumber,
                'ref_no'       => $installment->reference_no,
                'reference_no' => $installment->reference_no,
                'CL_Number'    => $installment->CL_Number,
                'CN_Number'    => $installment->CN_Number,
                'status'       => 'Un Read',
                'created_at'   => now('Asia/Dubai'),
            ]);

            DB::commit();

            return response()->json([
                'status'         => 'success',
                'message'        => 'Invoice generated successfully.',
                'invoice_number' => $invoiceNumber,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to generate invoice.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function showImportForm()
    {
        $now = "";
        return view('agreements.import' , compact('now'));
    }

    public function importAgreements(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $import = new AgreementsImport();
        Excel::import($import, $request->file('file'));

        return redirect()
            ->route('agreements.import.form')
            ->with([
                'status'               => 'Import completed!',
                'agreements_created'   => $import->getAgreementsCreated(),
                'installments_created' => $import->getInstallmentsCreated(),
                'contracts_created'    => $import->getContractsCreated(),
                'row_failures_count'   => count($import->getErrors()),
                'rowErrors'            => $import->getErrors(),
            ]);
    }

    public function toggleMarked(Request $request)
    {
        $request->validate([
            'id'     => 'required|integer|exists:agreements,id',
            'marked' => 'required|in:Yes,No',
        ]);

        $agreement = Agreement::find($request->input('id'));
        $agreement->marked = $request->input('marked');
        $agreement->save();
        return response()->json([
            'message' => 'Marked status updated successfully.',
            'marked'  => $agreement->marked,
        ]);
    }

    public function items(Installment $installment)
    {
        return response()->json(
            $installment->items()->get()
        );
    }

    public function updateMarked(Request $request)
    {
        $data = $request->validate([
            'reference_no' => ['required','string'],
            'marked' => ['required','in:Yes,No'],
        ]);

        $agreement = Agreement::where('reference_no', $data['reference_no'])->firstOrFail();
        $agreement->marked = $data['marked'];
        $agreement->save();

        return response()->json([
            'ok' => true,
            'marked' => $agreement->marked,
        ]);
    }
}
