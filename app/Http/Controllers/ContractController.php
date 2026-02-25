<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\NewCandidate;
use App\Models\Package;
use App\Models\Employee;
use App\Models\Trial;
use App\Models\Office;
use App\Models\Agreement;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Installment;
use App\Models\InstallmentItem;
use App\Models\CRM;
use App\Models\ReplacementHistory;
use App\Models\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class ContractController extends Controller
{
    protected function add_notification(array $data)
    {
        Notification::create($data);
    }

    public function index(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $query = Contract::with(['agreement', 'client', 'candidate', 'salesPerson', 'creator']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('reference_no', 'like', "%{$s}%")
                  ->orWhere('agreement_reference_no', 'like', "%{$s}%")
                  ->orWhere('CN_Number', 'like', "%{$s}%")
                  ->orWhere('CL_Number', 'like', "%{$s}%")
                  ->orWhereHas('agreement', fn($a) => $a->where('candidate_name', 'like', "%{$s}%")
                                                      ->orWhere('nationality', 'like', "%{$s}%"))
                  ->orWhereHas('client', fn($c) => $c->whereRaw("CONCAT(first_name,' ',last_name) LIKE ?", ["%{$s}%"]))
                  ->orWhereHas('candidate', fn($c) => $c->where('name', 'like', "%{$s}%"));
            });
        }

        $query->when($request->filled('reference_no'), fn($q) => $q->where('reference_no', 'like', "%{$request->reference_no}%"))
              ->when($request->filled('type'), fn($q) => $q->where('type', $request->type))
              ->when($request->filled('candidate_name'), fn($q) => $q->whereHas('agreement', fn($a) => $a->where('candidate_name', 'like', "%{$request->candidate_name}%")))
              ->when($request->filled('nationality'), fn($q) => $q->whereHas('agreement', fn($a) => $a->where('nationality', 'like', "%{$request->nationality}%")))
              ->when($request->filled('CN_Number'), fn($q) => $q->where('CN_Number', 'like', "%{$request->CN_Number}%"))
              ->when($request->filled('CL_Number'), fn($q) => $q->where('CL_Number', 'like', "%{$request->CL_Number}%"))
              ->when($request->filled('status_filter'), fn($q) => $q->where('status', $request->status_filter))
              ->when($request->filled('foreign_partner'), fn($q) => $q->where('foreign_partner', 'like', "%{$request->foreign_partner}%"))
              ->when($request->filled('package'), fn($q) => $q->where('package', 'like', "%{$request->package}%"))
              ->when($request->filled('from_date') && $request->filled('to_date'), fn($q) => $q->whereBetween('created_at', [
                  Carbon::parse($request->from_date)->startOfDay(),
                  Carbon::parse($request->to_date)->endOfDay()
              ]));

        $contracts = $query->latest()->paginate(10)->withQueryString();

        return $request->ajax()
            ? view('contracts.partials.contracts_table', compact('contracts', 'now'))
            : view('contracts.index', compact('contracts', 'now'));
    }

    public function create()
    {
        return view('contracts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agreement_type'         => 'required|string',
            'agreement_reference_no' => ['required','string', Rule::unique('contracts','agreement_reference_no')],
            'candidate_id'           => 'required|integer',
            'CL_Number'              => 'required|string',
            'CN_Number'              => 'required|string',
            'reference_of_candidate' => 'required|string',
            'package'                => 'required|string',
            'foreign_partner'        => 'required|string',
            'client_id'              => 'required|integer',
            'contract_start_date'    => 'required|date',
            'contract_end_date'      => 'required|date|after:contract_start_date',
            'contract_signed_copy'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
            'maid_delivered'         => 'required|in:Yes,No',
            'transferred_date'       => 'required|date',
            'remarks'                => 'nullable|string',
        ]);

        $agreement = Agreement::where('reference_no', $validated['agreement_reference_no'])->first();
        if (! $agreement) {
            return response()->json(['success' => false, 'message' => 'Agreement not found.'], 404);
        }
        if (Contract::where('agreement_reference_no', $validated['agreement_reference_no'])->exists()) {
            return response()->json(['success' => false, 'message' => 'Contract already exists for this agreement.'], 400);
        }

        $pkg = strtoupper($validated['package']);
        if ($validated['agreement_type'] === 'BIA' && in_array($pkg, ['PKG-1','PACKAGE 1'], true)) {
            $trial = Trial::where('agreement_reference_no', $validated['agreement_reference_no'])->first();
            if (! $trial) {
                return response()->json(['success' => false, 'message' => 'No trial record found for this agreement reference.'], 400);
            }
            if ($trial->trial_status !== 'Confirmed') {
                return response()->json(['success' => false, 'message' => "Trial status is {$trial->trial_status}. Please confirm it first."], 400);
            }
        }

        if ($validated['agreement_type'] === 'BOA') {
            $candidate = NewCandidate::where('CN_Number', $validated['CN_Number'])->first();
            if (! $candidate) {
                return response()->json(['success' => false, 'message' => 'Candidate not found.'], 404);
            }
            $statusMap = [
                1  => 'Available',2  => 'Back Out',3  => 'Hold',4  => 'Selected',
                5  => 'WC-Date',6  => 'Incident Before Visa (IBV)',7  => 'Visa Date',
                8  => 'Incident After Visa (IAV)',9  => 'Medical Status',10 => 'COC-Status',
                11 => 'MoL Submitted Date',12 => 'MoL Issued Date',13 => 'Departure Date',
                14 => 'Incident After Departure (IAD)',15 => 'Arrived Date',
                16 => 'Incident After Arrival (IAA)',17 => 'Transfer Date',
            ];
            if ($candidate->current_status !== 17) {
                $name = $statusMap[$candidate->current_status] ?? 'Unknown';
                return response()->json(['success' => false, 'message' => "Candidate status is {$name}. Please set to Transfer Date first."], 400);
            }
        }

        try {
            $refNo = DB::transaction(function () use ($request, $validated, $agreement) {
                $latest = Contract::lockForUpdate()->orderByDesc('reference_no')->value('reference_no');
                $next   = $latest ? ((int)str_replace('CT-','',$latest))+1 : 1;
                $refNo  = 'CT-'.str_pad($next,5,'0',STR_PAD_LEFT);

                $data = array_merge($validated, ['reference_no' => $refNo]);
                if ($request->hasFile('contract_signed_copy')) {
                    $data['contract_signed_copy'] = $request->file('contract_signed_copy')->store('contracts','public');
                }
                Contract::create($data);

                $agreement->update([
                    'status'               => 5,
                    'agreement_start_date' => $validated['contract_start_date'],
                    'agreement_end_date'   => $validated['contract_end_date'],
                ]);

                if ($validated['maid_delivered'] === 'Yes') {
                    NewCandidate::where('id', $validated['candidate_id'])
                        ->update(['transfer_date' => $validated['transferred_date']]);
                }

                $pkg = strtoupper($validated['package']);
                if (! in_array($pkg, ['PKG-1','PACKAGE 1'], true)) {
                    $emp = Employee::find($validated['candidate_id']);
                    if ($emp) {
                        $emp->employment_contract_start_date = $validated['contract_start_date'];
                        $emp->employment_contract_end_date   = $validated['contract_end_date'];
                        $emp->contract_type = match ($pkg) {
                            'PKG-2','PACKAGE 2' => 'TEMPORARY',
                            'PKG-3','PACKAGE 3' => 'FLEXIBLE',
                            'PKG-4','PACKAGE 4' => 'Tadbeer Visa',
                            default             => null,
                        };
                        $emp->save();
                    }
                }

                return $refNo;
            });

            $contract = Contract::where('reference_no',$refNo)->firstOrFail();
            return response()->json(['success'=>true,'message'=>'Contract created successfully.','data'=>$contract],201);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'message'=>'Error creating contract: '.$e->getMessage()],500);
        }
    }

    public function show(string $referenceNo)
    {
        $now = Carbon::now('Asia/Qatar')->format('l, F d, Y h:i A');
        $contract = Contract::with(['agreement','candidate','client'])
            ->where('reference_no', $referenceNo)->firstOrFail();

        $replacementHistories = $contract->replacementHistories;
        $agr = $contract->agreement;
        $monthly = $agr->monthly_payment ?? 0;
        $totalAmt = $agr->total_amount ?? 0;
        $received = $agr->received_amount ?? 0;
        $remaining = max(0, ($monthly ?: $totalAmt) - $received);

        $pkg = strtoupper((string) $contract->package);
        $agreementType = strtoupper((string) ($contract->agreement_type ?? $agr?->agreement_type ?? ''));

        if ($agreementType === 'BOA') {
            $profileClass = NewCandidate::class;
        }elseif (in_array($pkg, ['PKG-1', 'PACKAGE 1'], true)) {
            $profileClass = Package::class;
        } else {
            $profileClass = Employee::class;
        }

        $profile = $profileClass::findOrFail($contract->candidate_id);

        $view = match ($pkg) {
            'PKG-1', 'PACKAGE 1' => 'contracts.show',
            'PKG-2', 'PACKAGE 2', 'PKG-3', 'PACKAGE 3' => 'contracts.show2',
            'PKG-4', 'PACKAGE 4' => 'contracts.show3',
        };

        if ((string) $contract->marked === 'No' && Auth::user()->role !== 'Archive Clerk') {
            return view('contracts.contract_not_approved_page', compact('contract', 'now', 'agr', 'replacementHistories'));
        }

        return view($view, compact('contract', 'profile', 'monthly', 'totalAmt', 'received', 'remaining', 'replacementHistories', 'now'));
    }

    public function show1(string $referenceNo)
    {
        $now = Carbon::now('Asia/Qatar')->format('l, F d, Y h:i A');
        $contract = Contract::with(['agreement','candidate','client'])
            ->where('reference_no', $referenceNo)->firstOrFail();

        $replacementHistories = $contract->replacementHistories;
        $agr = $contract->agreement;
        $monthly = $agr->monthly_payment ?? 0;
        $totalAmt = $agr->total_amount ?? 0;
        $received = $agr->received_amount ?? 0;
        $remaining = max(0, ($monthly ?: $totalAmt) - $received);

        $pkg = strtoupper((string) $contract->package);
        $agreementType = strtoupper((string) ($contract->agreement_type ?? $agr?->agreement_type ?? ''));

        if (in_array($pkg, ['PKG-1', 'PACKAGE 1'], true)) {
            $profileClass = Package::class;
        } elseif ($agreementType === 'BOA') {
            $profileClass = NewCandidate::class;
        } else {
            $profileClass = Employee::class;
        }

        $profile = $profileClass::findOrFail($contract->candidate_id);

        $view = 'contracts.show1';

        if ((string) $contract->marked === 'No' && Auth::user()->role !== 'Archive Clerk') {
            return view('contracts.contract_not_approved_page', compact('contract', 'now', 'agr', 'replacementHistories'));
        }

        return view($view, compact('contract', 'profile', 'monthly', 'totalAmt', 'received', 'remaining', 'replacementHistories', 'now'));
    }

    public function edit(string $reference_no)
    {
        $contract = Contract::where('agreement_reference_no',$reference_no)->firstOrFail();
        return view('contracts.edit',compact('contract'));
    }

    public function update(Request $request,string $reference_no)
    {
        $contract  = Contract::where('agreement_reference_no',$reference_no)->firstOrFail();
        $validated = $request->validate([
            'contract_start_date'=>'required|date',
            'contract_end_date'  =>'required|date|after:contract_start_date',
            'maid_delivered'     =>'required|in:Yes,No',
            'transferred_date'   =>'required|date',
            'remarks'            =>'nullable|string',
        ]);

        if ($request->hasFile('contract_signed_copy')) {
            $validated['contract_signed_copy']=$request->file('contract_signed_copy')->store('contracts','public');
        }

        $contract->update($validated);
        return redirect()->route('contracts.index')->with('success','Contract updated successfully.');
    }

    public function destroy(string $reference_no)
    {
        $contract = Contract::where('agreement_reference_no',$reference_no)->firstOrFail();
        $contract->delete();
        return redirect()->route('contracts.index')->with('success','Contract deleted successfully.');
    }

    public function updateP1Contract(Request $request)
    {
        $data = $request->validate([
            'reference_no'           =>'required|string|exists:contracts,reference_no',
            'agreement_reference_no' =>'required|string|exists:agreements,reference_no',
            'contract_start_date'    =>'required|date',
            'contract_end_date'      =>'required|date|after_or_equal:contract_start_date',
            'maid_delivered'         =>'required|in:Yes,No',
            'status'                 =>'required|integer',
            'contract_signed_copy'   =>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        DB::transaction(function () use ($data,$request) {
            $contract = Contract::where('reference_no',$data['reference_no'])->firstOrFail();

            if ($file=$request->file('contract_signed_copy')) {
                $contract->contract_signed_copy=$file->store('contracts/signed','public');
            }

            $contract->update([
                'contract_start_date'=>$data['contract_start_date'],
                'contract_end_date'  =>$data['contract_end_date'],
                'maid_transferred'   =>$data['maid_delivered'],
                'status'             =>$data['status'],
            ]);

            $agreement = Agreement::where('reference_no',$data['agreement_reference_no'])->firstOrFail();
            $agreement->update([
                'agreement_start_date'=>$data['contract_start_date'],
                'agreement_end_date'  =>$data['contract_end_date'],
                'status'              =>$data['status'],
            ]);
        });

        return response()->json(['success'=>true,'message'=>'Contract & Agreement updated successfully.']);
    }

    public function updateSignedCopy(Request $request,Contract $contract)
    {
        $validated = $request->validate([
            'contract_start_date'   =>'required|date',
            'contract_end_date'     =>'required|date|after_or_equal:contract_start_date',
            'cancelled_date'        =>'nullable|date',
            'maid_delivered'        =>'required',
            'status'                =>'required|integer',
            'contract_signed_copy'  =>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'monthly_payment'       =>'nullable|numeric|min:0',
            'initial_payment'       =>'nullable|numeric|min:0',
            'payment_cycle'         =>'nullable|in:0,'.implode(',',range(1,12)),
            'upcoming_payment_date' =>'nullable|date',
            'salary'                =>'nullable|numeric|min:0',
            'payment_method'        =>'nullable|string',
            'months_count'          =>'nullable|string',
            'payment_proof'         =>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'inst_id'               =>'nullable|array',
            'inst_id.*'             =>'nullable|integer|exists:installments,id',
            'inst_date'             =>'required_with:inst_date|array',
            'inst_date.*'           =>'required_with:inst_date|date',
            'inst_ref.*'            =>'nullable|string|max:255',
            'inst_amount.*'         =>'required_with:inst_date|numeric|min:0',
            'inst_proof.*'          =>'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        DB::transaction(function () use ($validated,$request,$contract) {
            if ($request->hasFile('contract_signed_copy')) {
                $contract->contract_signed_copy = $request->file('contract_signed_copy')->store('contracts/signed','public');
            }

            $contract->fill([
                'contract_start_date'=>$validated['contract_start_date'],
                'contract_end_date'  =>$validated['contract_end_date'],
                'maid_delivered'     =>$validated['maid_delivered'],
                'status'             =>$validated['status'],
                'cancelled_date'     =>$validated['cancelled_date'],
                'remarks'            =>'Done',
            ]);

            foreach (['monthly_payment','initial_payment','payment_cycle','upcoming_payment_date','salary','payment_method'] as $f) {
                if (isset($validated[$f])) {
                    $contract->$f = $validated[$f];
                }
            }

            if ($request->hasFile('payment_proof')) {
                $contract->payment_proof=$request->file('payment_proof')->store('office_payment_proof','public');
            }

            $contract->save();

            if ($agr=$contract->agreement) {
                $agr->update([
                    'agreement_start_date'  =>$validated['contract_start_date'],
                    'agreement_end_date'    =>$validated['contract_end_date'],
                    'months_count'          =>$validated['months_count'],
                    'monthly_payment'       =>$validated['monthly_payment']??$agr->monthly_payment,
                    'initial_payment'       =>$validated['initial_payment']??$agr->initial_payment,
                    'payment_cycle'         =>$validated['payment_cycle']??$agr->payment_cycle,
                    'upcoming_payment_date' =>$validated['upcoming_payment_date']??$agr->upcoming_payment_date,
                    'salary'                =>$validated['salary']??$agr->salary,
                    'payment_method'        =>$validated['payment_method']??$agr->payment_method,
                    'status'                =>5,
                ]);
            }

            $existing = $contract->installments()->pluck('id')->toArray();
            $incoming = array_filter($validated['inst_id']??[]);
            $toDelete = array_diff($existing,$incoming);
            if ($toDelete) {
                $contract->installments()->whereIn('id',$toDelete)->delete();
            }

            foreach ($validated['inst_date'] as $i=>$due) {
                $data = [
                    'due_date'    => $due,
                    'reference_no'=> $validated['inst_ref'][$i]??null,
                    'amount'      => $validated['inst_amount'][$i]??0,
                ];

                if (!empty($validated['inst_id'][$i]) && $inst=$contract->installments()->find($validated['inst_id'][$i])) {
                    $inst->update($data);
                } else {
                    $inst=$contract->installments()->create($data);
                }

                if ($request->hasFile("inst_proof.$i")) {
                    $inst->proof=$request->file('inst_proof')[$i]->store('office_payment_proof','public');
                    $inst->save();
                }
            }

            if ($validated['maid_delivered']==='Yes' && $contract->candidate_id) {
                NewCandidate::where('id',$contract->candidate_id)->update(['transfer_date'=>now()]);
            }

            $pkg = strtoupper($contract->package);
            if (! in_array($pkg,['PKG-1','PACKAGE 1'],true) && $contract->candidate_id) {
                if ($emp=Employee::find($contract->candidate_id)) {
                    $emp->update([
                        'employment_contract_start_date'=>$validated['contract_start_date'],
                        'employment_contract_end_date'  =>$validated['contract_end_date'],
                        'contract_type'=>match($pkg){
                            'PKG-2','PACKAGE 2'=>'TEMPORARY',
                            'PKG-3','PACKAGE 3'=>'FLEXIBLE',
                            'PKG-4','PACKAGE 4'=>'TADBEER Visa',
                            default=>$emp->contract_type,
                        },
                    ]);
                }
            }
        });

        return response()->json(['success'=>true,'message'=>'Contract, agreement, and installments updated successfully.']);
    }

    public function toggleMarked(Request $request)
    {
        $request->validate(['id'=>'required|integer|exists:contracts,id','marked'=>'required|in:Yes,No']);
        $contract=Contract::find($request->id);
        $contract->marked=$request->marked;
        $contract->save();
        return response()->json(['message'=>'Marked status updated successfully.','marked'=>$contract->marked]);
    }

    public function detailsAll(Request $request)
    {
        $ref = $request->validate(['agreement_reference_no'=>'required|string'])['agreement_reference_no'];
        $agr = Agreement::with(['contract','installments.items','invoices.items','client:id,first_name,last_name'])
            ->where('reference_no',$ref)->firstOrFail();

        $instItems = $agr->installments->flatMap(fn($i)=>$i->items)->map->toArray()->all();
        $invoices  = $agr->invoices->map->toArray();
        $clients   = CRM::select('id','first_name','last_name')->get();
        $employees = Employee::select('id','name')->whereIn('inside_status',[0,1])->orderBy('name')->get();
        $customer  = trim("{$agr->client->first_name} {$agr->client->last_name}");

        return response()->json([
            'agreement'     =>$agr->toArray(),
            'contract'      =>$agr->contract?->toArray(),
            'installments'  =>$instItems,
            'invoices'      =>$invoices,
            'clients'       =>$clients,
            'employees'     =>$employees,
            'client_id'     =>$agr->client->id,
            'customer_name' =>$customer,
        ]);
    }

    public function replace(Request $request, $ref)
    {
        $data = $request->validate([
            'contract_number'       => 'required|string|exists:contracts,reference_no',
            'replacement_employee'  => 'required|integer|exists:employees,id',
            'replacement_date'      => 'required|date',
            'proof'                 => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'total_amount'          => 'required|numeric|min:0',
        ]);

        $contract = Contract::where('reference_no', $data['contract_number'])->first();
        if (! $contract) {
            return response()->json(['message' => 'Contract not found'], 404);
        }

        $agreement = Agreement::where('reference_no', $contract->agreement_reference_no)->first();
        if (! $agreement) {
            return response()->json(['message' => 'Agreement not found'], 404);
        }

        $new = Employee::find($data['replacement_employee']);
        if (! in_array($new->inside_status, [0, 1], true)) {
            return response()->json(['message' => 'This employee is not available for replacement'], 422);
        }

        try {
            DB::transaction(function () use ($new, $agreement, $data, $request) {
                $oldId   = $agreement->candidate_id;
                $oldName = $agreement->candidate_name;

                $agreement->update([
                    'candidate_id'           => $new->id,
                    'candidate_name'         => $new->name,
                    'reference_of_candidate' => $new->reference_no,
                    'passport_no'            => $new->passport_no,
                    'foreign_partner'        => $new->foreign_partner,
                    'ref_no_in_of_previous'  => $oldName,
                ]);

                Contract::where('agreement_reference_no', $agreement->reference_no)->update([
                    'CN_Number'              => $new->reference_no,
                    'reference_of_candidate' => $new->reference_no,
                    'replaced_by_name'       => $oldName,
                    'replacement'            => 1,
                ]);

                $new->update(['inside_status' => 2]);
                Employee::where('id', $oldId)->update(['inside_status' => 1]);
                
                $office = Office::where('candidate_id', $oldId)
                ->where('type', 'employee')
                ->orderBy('id','asc')   
                ->first();
                if ($office) {
                    $office->status = 1;
                    $office->save();
                }

                Office::where('candidate_id', $new->id)->where('type', 'employee')->update(['status' => 0]);
                $proofPath = $request->file('proof')->store('replacement_proofs', 'public');
                ReplacementHistory::create([
                    'client_id'            => $agreement->client_id,
                    'old_candidate_id'     => $oldId,
                    'new_candidate_id'     => $new->id,
                    'reference_no'         => $new->reference_no,
                    'contract_number'      => $data['contract_number'],
                    'agreement_no'         => $agreement->reference_no,
                    'old_invoice_number'   => 0,
                    'new_invoice_number'   => 0,
                    'replacement_date'     => $data['replacement_date'],
                    'total_amount'         => $data['total_amount'],
                    'name'                 => $new->name,
                    'nationality'          => $new->nationality,
                    'passport_no'          => $new->passport_no,
                    'replacement_proof'    => $proofPath,
                    'created_by'           => Auth::id(),
                ]);
            });

            return response()->json(['message' => 'Replacement completed successfully']);
        } catch (\Throwable $e) {
            Log::error('Replacement failed: ' . $e->getMessage(), ['trace' => $e->getTrace()]);
            return response()->json(['message' => 'Replacement failed: ' . $e->getMessage()], 500);
        }
    }
    
    public function updateContract(Request $request): JsonResponse
    {
        $data = $request->validate([
            'contract_reference_no'    => 'required|string|exists:contracts,reference_no',
            'agreement_reference_no'   => 'required|string|exists:agreements,reference_no',
            'status'                   => 'required|integer|in:1,2,3,4,5,6',
            'maid_delivered'           => ['required', Rule::in(['Yes', 'No'])],
            'contract_start_date'      => 'required|date',
            'contract_end_date'        => 'required|date|after_or_equal:contract_start_date',
            'contract_signed_copy'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'package'                  => 'required|string|max:50',
            'payment_terms'            => 'required|string|in:full,partial',
            'client_id'                => 'required|integer|exists:crm,id',
            'candidate_id'             => 'required|integer|exists:employees,id',
            'initial_payment'          => 'required|numeric|min:0',
            'monthly_payment'          => 'required|numeric|min:0',
            'payment_cycle'            => 'required|integer|min:0',
            'salary'                   => 'required|numeric|min:0',
            'received_amount'          => 'required|numeric|min:0',
            'remaining_amount'         => 'required|numeric|min:0',
            'payment_method'           => 'nullable|string|max:255',
            'inst_date'                => 'nullable|array',
            'inst_ref'                 => 'nullable|array',
            'inst_amount'              => 'nullable|array',
            'inst_proof'               => 'nullable|array',
        ]);

        DB::transaction(function () use ($data, $request) {
            $contract = Contract::lockForUpdate()
                ->where('reference_no', $data['contract_reference_no'])
                ->firstOrFail();

            if ($request->hasFile('contract_signed_copy')) {
                $contract->contract_signed_copy = $request->file('contract_signed_copy')->store('contracts/signed', 'public');
            }

            $contract->status = $data['status'];
            $contract->maid_delivered = $data['maid_delivered'];
            $contract->contract_start_date = $data['contract_start_date'];
            $contract->contract_end_date = $data['contract_end_date'];
            $contract->package = $data['package'];
            $contract->client_id = $data['client_id'];
            $contract->candidate_id = $data['candidate_id'];
            $contract->agreement_reference_no = $data['agreement_reference_no'];

            if ((int)$data['status'] === 2) {
                $contract->cancelled_date = now();
                $contract->remarks = 'Contract cancelled on ' . now()->format('d M Y');
            }

            $contract->save();

            $agreement = Agreement::lockForUpdate()
                ->where('reference_no', $data['agreement_reference_no'])
                ->firstOrFail();

            $agreement->agreement_start_date = $data['contract_start_date'];
            $agreement->agreement_end_date = $data['contract_end_date'];
            $agreement->package = $data['package'];
            $agreement->client_id = $data['client_id'];
            $agreement->payment_method = $data['payment_method'];
            $agreement->total_amount = $data['initial_payment'];
            $agreement->monthly_payment = $data['monthly_payment'];
            $agreement->payment_cycle = $data['payment_cycle'];
            $agreement->salary = $data['salary'];
            $agreement->received_amount = $data['received_amount'];
            $agreement->remaining_amount = $data['remaining_amount'];

            if ((int)$data['status'] === 2) {
                $agreement->status = 4;
                $agreement->notes = 'Agreement cancelled due to contract cancellation';
            }

            $agreement->save();

            $invoice = Invoice::lockForUpdate()
                ->where('agreement_reference_no', $agreement->reference_no)
                ->where('invoice_type', 'Tax')
                ->first();

            if (! $invoice) {
                $balanceDue = $data['payment_terms'] === 'full' ? 0 : $data['remaining_amount'];

                $invoice = Invoice::create([
                    'agreement_reference_no' => $agreement->reference_no,
                    'customer_id'            => $data['client_id'],
                    'reference_no'           => $contract->reference_no,
                    'CL_Number'              => $agreement->CL_Number,
                    'CN_Number'              => $agreement->CN_Number,
                    'invoice_type'           => 'Tax',
                    'payment_method'         => $data['payment_method'] ?? null,
                    'received_amount'        => $data['received_amount'],
                    'invoice_date'           => now('Asia/Dubai'),
                    'due_date'               => now('Asia/Dubai'),
                    'total_amount'           => $data['initial_payment'],
                    'discount_amount'        => 0,
                    'tax_amount'             => 0,
                    'balance_due'            => $balanceDue,
                    'status'                 => 'Pending',
                    'payment_proof'          => null,
                    'created_by'             => Auth::id(),
                ]);

                InvoiceItem::create([
                    'invoice_id'   => $invoice->id,
                    'product_name' => 'Tax Invoice for ' . $agreement->reference_no,
                    'quantity'     => 1,
                    'unit_price'   => $data['initial_payment'],
                    'total_price'  => $data['initial_payment'],
                ]);
            } else {
                $invoice->customer_id = $data['client_id'];
                $invoice->payment_method = $data['payment_method'] ?? $invoice->payment_method;
                $invoice->total_amount = $data['initial_payment'];
                $invoice->received_amount = $data['received_amount'];
                $invoice->balance_due = $data['payment_terms'] === 'full' ? 0 : $data['remaining_amount'];
                $invoice->save();
            }

            if ($data['payment_terms'] === 'partial') {
                $installment = Installment::lockForUpdate()
                    ->where('invoice_number', $invoice->invoice_number)
                    ->first();

                if ($installment) {
                    $installment->agreement_no = $agreement->reference_no;
                    $installment->CL_Number = $agreement->CL_Number;
                    $installment->CN_Number = $agreement->CN_Number;
                    $installment->customer_name = trim($agreement->client->first_name . ' ' . $agreement->client->last_name);
                    $installment->employee_name = $agreement->candidate_name;
                    $installment->passport_no = $agreement->passport_no;
                    $installment->contract_duration = $agreement->number_of_days;
                    $installment->contract_start_date = $data['contract_start_date'];
                    $installment->contract_end_date = $data['contract_end_date'];
                    $installment->package = $data['package'];
                    $installment->contract_amount = $data['initial_payment'];
                    $installment->number_of_installments = count($request->input('inst_date', []));
                    $installment->save();
                    $installment->items()->delete();
                } else {
                    $max = Installment::lockForUpdate()
                        ->selectRaw("MAX(CAST(SUBSTRING(reference_no,5) AS UNSIGNED)) m")
                        ->value('m');
                    $insRef = 'INS-' . str_pad(($max ?? 0) + 1, 5, '0', STR_PAD_LEFT);

                    $installment = Installment::create([
                        'reference_no'           => $insRef,
                        'agreement_no'           => $agreement->reference_no,
                        'invoice_number'         => $invoice->invoice_number,
                        'CL_Number'              => $agreement->CL_Number,
                        'CN_Number'              => $agreement->CN_Number,
                        'customer_name'          => trim($agreement->client->first_name . ' ' . $agreement->client->last_name),
                        'employee_name'          => $agreement->candidate_name,
                        'passport_no'            => $agreement->passport_no,
                        'contract_duration'      => $agreement->number_of_days,
                        'contract_start_date'    => $data['contract_start_date'],
                        'contract_end_date'      => $data['contract_end_date'],
                        'package'                => $data['package'],
                        'contract_amount'        => $data['initial_payment'],
                        'number_of_installments' => count($request->input('inst_date', [])),
                        'paid_installments'      => 0,
                        'created_by'             => Auth::id(),
                    ]);
                }

                $dates   = $request->input('inst_date', []);
                $refs    = $request->input('inst_ref', []);
                $amounts = $request->input('inst_amount', []);
                $proofs  = $request->file('inst_proof', []);

                foreach ($dates as $idx => $date) {
                    if (! $date) {
                        continue;
                    }

                    $proofPath = isset($proofs[$idx]) ? $proofs[$idx]->store('installment_proofs', 'public') : null;

                    InstallmentItem::create([
                        'installment_id'    => $installment->id,
                        'particular'        => 'Installment ' . ($idx + 1),
                        'amount'            => $amounts[$idx] ?? 0,
                        'payment_date'      => $date,
                        'reference_no'      => $refs[$idx] ?? null,
                        'payment_proof'     => $proofPath,
                        'invoice_generated' => 0,
                        'paid_date'         => null,
                        'status'            => 'Pending',
                        'invoice_number'    => $invoice->invoice_number,
                    ]);
                }
            }

            if ((int)$data['status'] === 2) {
                Invoice::where('agreement_reference_no', $agreement->reference_no)
                    ->update(['status' => 'Cancelled', 'notes' => 'Cancelled due to contract cancellation']);

                InstallmentItem::whereHas('installment', function ($q) use ($agreement) {
                    $q->where('agreement_no', $agreement->reference_no);
                })->update(['status' => 'Cancelled']);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Contract, agreement, invoice and installments updated.',
        ]);
    }

    public function extend(Request $request)
    {
        $request->validate([
            'agreement_reference_no'=>'required|exists:contracts,agreement_reference_no',
            'new_end_date'=>'required|date|after:contract_end_date',
        ]);

        $contract = Contract::where('agreement_reference_no',$request->agreement_reference_no)->firstOrFail();
        $contract->contract_end_date = $request->new_end_date;
        $contract->save();

        return response()->json(['message'=>'Contract successfully extended to '.$request->new_end_date]);
    }

    public function showSignAndShare(Contract $contract)
    {
        return view('contracts.sign_and_share', compact('contract'));
    }

    public function shareForSignature(Request $request, Contract $contract)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $filename = "contract-{$contract->reference_no}-unsigned.pdf";

        $pdf = PDF::loadView('contracts.pdf_unsigned', [
            'contract' => $contract,
        ])
        ->setPaper('a4')
        ->setOption('margin-top', '10mm')
        ->setOption('margin-bottom', '10mm')
        ->setOption('margin-left', '10mm')
        ->setOption('margin-right', '10mm');

        Storage::put("temp/{$filename}", $pdf->inline());
        $url = asset("storage/temp/{$filename}");

        $clientName = "{$contract->client->first_name} {$contract->client->last_name}";
        $maidName   = $contract->agreement->candidate_name;
        $startDate  = $contract->agreement->agreement_start_date
            ? Carbon::parse($contract->agreement->agreement_start_date)->format('d M Y')
            : '—';
        $endDate    = $contract->agreement->agreement_end_date
            ? Carbon::parse($contract->agreement->agreement_end_date)->format('d M Y')
            : '—';
        $totalValue = number_format(
            $contract->agreement->monthly_payment
            ?: $contract->agreement->total_amount,
            2
        );

        $text  = "Dear {$clientName},\n\n";
        $text .= "Please review and sign the Domestic Worker Contract for {$maidName}, ";
        $text .= "valid from {$startDate} to {$endDate} (AED {$totalValue}):\n";
        $text .= "{$url}\n\nThank you.";

        $phone = preg_replace('/\D+/', '', $request->input('phone'));

        return $this->sendWhatsappLink($phone, $text);
    }

    public function storeSignedAndShare(Request $request, Contract $contract)
    {
        $request->validate([
            'phone'     => 'required|string',
            'signature' => 'required|string',
        ]);

        [, $data] = explode(',', $request->input('signature'));
        $sigPath = "signatures/{$contract->reference_no}.png";
        Storage::put($sigPath, base64_decode($data));
        $signatureFile = storage_path("app/{$sigPath}");

        $pdf = PDF::loadView('contracts.pdf_signed', [
            'contract'      => $contract,
            'signaturePath' => $signatureFile,
        ])
        ->setPaper('a4')
        ->setOption('margin-top', '10mm')
        ->setOption('margin-bottom', '10mm')
        ->setOption('margin-left', '10mm')
        ->setOption('margin-right', '10mm');

        $filename = "contract-{$contract->reference_no}-signed.pdf";
        Storage::put("temp/{$filename}", $pdf->inline());
        $url = asset("storage/temp/{$filename}");

        $clientName = "{$contract->client->first_name} {$contract->client->last_name}";
        $maidName   = $contract->agreement->candidate_name;
        $startDate  = $contract->agreement->agreement_start_date
            ? Carbon::parse($contract->agreement->agreement_start_date)->format('d M Y')
            : '—';
        $endDate    = $contract->agreement->agreement_end_date
            ? Carbon::parse($contract->agreement->agreement_end_date)->format('d M Y')
            : '—';
        $totalValue = number_format(
            $contract->agreement->monthly_payment
            ?: $contract->agreement->total_amount,
            2
        );

        $text  = "Dear {$clientName},\n\n";
        $text .= "Your signed Domestic Worker Contract for {$maidName}, ";
        $text .= "valid from {$startDate} to {$endDate} (AED {$totalValue}), is here:\n";
        $text .= "{$url}\n\nThank you.";

        $phone = preg_replace('/\D+/', '', $request->input('phone'));

        return $this->sendWhatsappLink($phone, $text);
    }

    public function shareWhatsapp(Request $request, Contract $contract)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $filename = "contract-{$contract->reference_no}-signed.pdf";
        $url      = asset("storage/temp/{$filename}");

        $clientName = "{$contract->client->first_name} {$contract->client->last_name}";
        $maidName   = $contract->agreement->candidate_name;
        $startDate  = $contract->agreement->agreement_start_date
            ? Carbon::parse($contract->agreement->agreement_start_date)->format('d M Y')
            : '—';
        $endDate    = $contract->agreement->agreement_end_date
            ? Carbon::parse($contract->agreement->agreement_end_date)->format('d M Y')
            : '—';
        $totalValue = number_format(
            $contract->agreement->monthly_payment
            ?: $contract->agreement->total_amount,
            2
        );

        $text  = "Dear {$clientName},\n\n";
        $text .= "Please find your signed Domestic Worker Contract for {$maidName}, ";
        $text .= "valid from {$startDate} to {$endDate} (AED {$totalValue}):\n";
        $text .= "{$url}\n\nThank you.";

        $phone = preg_replace('/\D+/', '', $request->input('phone'));

        return $this->sendWhatsappLink($phone, $text);
    }

    private function sendWhatsappLink(string $phone, string $text)
    {
        $link = "https://wa.me/{$phone}?text=" . urlencode($text);
        return redirect()->away($link);
    }

    public function items(Request $request)
    {
        $ref  = $request->input('reference_no');
        $agre = $request->input('agreement_reference_no');

        $contract = Contract::query()
            ->when($ref,  fn ($q) => $q->where('reference_no', $ref))
            ->when($agre, fn ($q) => $q->orWhere('agreement_reference_no', $agre))
            ->with([
                'installments.items',  
            ])
            ->firstOrFail();

        $items = $contract->installments
            ->flatMap(function ($inst) {
                return $inst->items->map(function ($item) use ($inst) {
                    $invoiceGenerated = (int) ($item->invoice_generated ?? ($item->invoice_id ? 1 : 0));

                    return [
                        'id'                => $item->id,
                        'installment_id'    => $inst->id,
                        'particular'        => $item->particular ?? 'Installment',
                        'amount'            => (float) $item->amount,
                        'payment_date'      => $item->payment_date,
                        'paid_date'         => $item->paid_date,
                        'status'            => $item->status ?? 'Pending',
                        'invoice_generated' => $invoiceGenerated,
                        'invoice_number'    => $item->invoice_number ?? null,
                    ];
                });
            })
            ->values();

        return response()->json($items);
    }
    
    public function updateMarked(Request $request)
    {
        $data = $request->validate([
            'reference_no' => ['required','string'],
            'marked' => ['required','in:Yes,No'],
        ]);

        $contract = Contract::where('reference_no', $data['reference_no'])->firstOrFail();
        $contract->marked = $data['marked'];
        $contract->save();

        return response()->json([
            'ok' => true,
            'marked' => $contract->marked,
        ]);
    }

}
