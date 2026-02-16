<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\CRM;
use App\Models\Invoice;
use App\Models\Office;
use App\Models\GovtTransactionInvoice;
use App\Models\Country;
use App\Models\CurrentStatus;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PaymentProof;
use App\Models\Trial;
use App\Models\Notification;
use App\Models\Invoices;
use App\Models\InvoiceItem;
use App\Models\Refund;
use App\Models\Replacement;
use App\Models\NewCandidate;
use App\Models\PackageAttachment;
use App\Models\Agreement;
use App\Http\Controllers\AccountInvoiceController;
use App\Services\ZohoItemService;
use Exception;
use Illuminate\Validation\Rule;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;


class PackageController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $currentStatuses = CurrentStatus::all();
        $query = Package::with('currentStatus')->orderBy('CN_Number', 'desc');
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('current_status', $request->input('status'));
        }
        if ($request->filled('CN_Number')) {
            $query->where('CN_Number', $request->input('CN_Number'));
        }
        if ($request->filled('name')) {
            $query->where('candidate_name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('passport_number')) {
            $query->where('passport_no', $request->input('passport_number'));
        }
        if ($request->filled('CL_Number')) {
            $query->where('CL_Number', $request->input('CL_Number'));
        }
        if ($request->filled('sales_name')) {
            $query->where('sales_name', 'like', '%' . $request->input('sales_name') . '%');
        }
        if ($request->filled('visa_type')) {
            $query->where('visa_type', $request->input('visa_type'));
        }
        if ($request->filled('package')) {
            $query->where('package', $request->input('package'));
        }
        if ($request->filled('nationality')) {
            $query->where('nationality', $request->input('nationality'));
        }
        if ($request->filled('global_search')) {
            $searchTerm = $request->input('global_search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('CN_Number', 'like', '%' . $searchTerm . '%')
                  ->orWhere('candidate_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('passport_no', 'like', '%' . $searchTerm . '%')
                  ->orWhere('CL_Number', 'like', '%' . $searchTerm . '%')
                  ->orWhere('sales_name', 'like', '%' . $searchTerm . '%');
            });
        }

        $candidates = $query->paginate(10);

        if ($request->ajax()) {
            return view('package.partials.candidates_table_4', compact('candidates'))->render();
        }

        return view('package.index', [
            'now'             => $now,
            'candidates'      => $candidates,
            'currentStatuses' => $currentStatuses,
        ]);
    }

    public function create()
    {
        $allCountries = Country::all();
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $currentStatuses = CurrentStatus::all();
        $crmCustomers = CRM::all();
        return view('package.create', compact('currentStatuses', 'crmCustomers', 'now', 'allCountries'));
    }

    public function store(Request $request)
    {
        $rules = [
            'candidate_name'        => 'required|string|max:255',
            'nationality'           => 'required|string|max:100',
            'passport_no'           => 'required|string|max:50|unique:packages,passport_no',
            'foreign_partner'       => 'nullable|string|max:255',
            'passport_expiry_date'  => 'nullable|date',
            'date_of_birth'         => 'nullable|date',
            'passport_issue_date'   => 'nullable|date',
            'experience_years'      => 'nullable',
            'marital_status'        => 'nullable',
            'number_of_children'    => 'nullable|integer|min:0',
            'religion'              => 'nullable|string|max:100',
            'place_of_birth'        => 'nullable|string|max:255',
            'living_town'           => 'nullable|string|max:255',
            'place_of_issue'        => 'nullable|string|max:255',
            'education'             => 'nullable|string|max:255',
            'languages'             => 'nullable|string|max:255',
        ];

        $messages = [
            'candidate_name.required' => 'Candidate name is required.',
            'nationality.required'    => 'Nationality is required.',
            'passport_no.required'    => 'Passport number is required.',
            'passport_no.unique'      => 'This passport number is already in use.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $dateFields = [
            'passport_expiry_date',
            'date_of_birth',
            'passport_issue_date',
        ];

        foreach ($dateFields as $field) {
            if (!empty($validatedData[$field])) {
                $validatedData[$field] = $this->sanitizeDate($validatedData[$field]);
            }
        }

        $user = Auth::user();

        $validatedData['package']                  = 'Package 1';
        $validatedData['CN_Number']                = $this->generateCN();
        $validatedData['hr_ref_no']                = $this->generateHR();
        $validatedData['cn_number_series']         = $this->generateCNSeries();
        $validatedData['candidate_id']             = 0;
        $validatedData['sales_name']               = $user ? $user->first_name : null;
        $validatedData['inside_status']            = 0;
        $validatedData['inside_country_or_outside'] = 2;
        $validatedData['slug'] = Str::slug($validatedData['candidate_name'].'-'.$validatedData['CN_Number']);

        DB::beginTransaction();

        try {
            Package::create($validatedData);

            DB::commit();
            return redirect()
                ->route('candidates.inside')
                ->with('success', 'Package created successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating package', ['error' => $e->getMessage()]);

            return back()
                ->withErrors(['error' => 'Failed to create package: ' . $e->getMessage()])
                ->withInput();
        }
    }


    public function importPackage(Request $request)
    {
        ini_set('memory_limit', '5000M');
        ini_set('max_execution_time', 300);
        $request->validate(['excelFile' => 'required|mimes:xlsx,xls']);

        try {
            $file = $request->file('excelFile');
            $filePath = $file->getRealPath();
            $reader = IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, false);

            if (empty($rows) || count($rows) <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'The uploaded file is empty or invalid.',
                ], 400);
            }

            $uploadedRecords = 0;
            $errors = [];
            $totalRows = count($rows) - 1;

            foreach ($rows as $rowIndex => $rowData) {
                if ($rowIndex === 0 || empty($rowData[0]) || !is_numeric($rowData[0])) {
                    continue;
                }
                $data = $this->mapRowToData($rowData);
                $validator = Validator::make($data, [
                    'sales_name'     => 'required|string|max:255',
                    'candidate_name' => 'required|string|max:255',
                    'passport_no'    => 'required|string|max:50|unique:packages,passport_no',
                    'nationality'    => 'required|string|max:100',
                    'passport_expiry_date' => 'nullable|date',
                    'date_of_birth'  => 'nullable|date',
                    'incident_date'  => 'nullable|date',
                    'arrived_date'   => 'nullable|date',
                ]);

                if ($validator->fails()) {
                    $errors[] = [
                        'row'    => $rowIndex + 1,
                        'errors' => $validator->errors()->toArray(),
                        'data'   => $data,
                    ];
                    continue;
                }

                DB::beginTransaction();
                try {
                    $data['CN_Number'] = $this->generateCN();
                    $package = Package::create($data);
                    $zohoData = [

                        'candidate_name'                => $data['candidate_name'],
                        'cf_package'                    => $data['package'],
                        'cf_visa_type'                  => $data['visa_type'],
                        'cf_passport_number'            => $data['passport_no'],
                        'cf_nationality'                => $data['nationality'] ,
                        'cf_item_number'                => $data['CN_Number'],
                        'cf_status'                     => 'Available',
                        'cf_arrival_status'             => 'Arrived',
                        'cf_client_final_payment_done'  => 'Yes',
                        'cf_commission_status'          => 'Unpaid',
                        'Created_Source'                => 'ERP',
                    ];

                    try {
                        $zohoService = new ZohoItemService();
                        $response = $zohoService->createItem($zohoData);
                        Log::info('Item stored successfully in Zoho Books', ['response' => $response]);
                    } catch (Exception $e) {
                        Log::error('Error storing item in Zoho Books', ['error' => $e->getMessage()]);
                    }

                    DB::commit();
                    $uploadedRecords++;
                } catch (Exception $e) {
                    DB::rollBack();
                    $errors[] = [
                        'row'    => $rowIndex + 1,
                        'errors' => ['error' => $e->getMessage()],
                        'data'   => $data,
                    ];
                }
                $this->updateProgress($uploadedRecords, $totalRows);
            }

            return response()->json([
                'success'         => true,
                'message'         => "$uploadedRecords records uploaded successfully.",
                'uploadedRecords' => $uploadedRecords,
                'totalRecords'    => $totalRows,
                'errors'          => $errors,
            ]);
        } catch (Exception $e) {
            Log::error('Import error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during the import process.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $package = Package::findOrFail($id);
        return view('package.show', compact('package','now'));
    }

    public function edit($id)
    {
        $package         = Package::findOrFail($id);
        $attachments     = DB::table('package_attachments')
                              ->where('package_id', $id)
                              ->get();
        $allCountries    = Country::all();
        $now             = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $currentStatuses = CurrentStatus::all();
        $crmCustomers    = CRM::all();

        return view('package.edit', compact(
            'package',
            'attachments',
            'allCountries',
            'currentStatuses',
            'crmCustomers',
            'now'
        ));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $validated = $request->validate([
            'hr_ref_no'                  => 'nullable|string|max:255',
            'sales_name'                 => 'required|string|max:255',
            'candidate_name'             => 'required|string|max:255',
            'passport_no'                => 'required|string|max:50|unique:packages,passport_no,' . $package->id,
            'nationality'                => 'required|string|max:100',
            'passport_expiry_date'       => 'nullable|date',
            'date_of_birth'              => 'nullable|date',
            'foreign_partner'            => 'nullable|string|max:255',
            'visa_type'                  => 'nullable|string|max:255',
            'sponsor_name'               => 'nullable|string|max:255',
            'qid_no'                     => 'nullable|string|max:255',
            'applied_date'               => 'nullable|date',
            'vp_number'                  => 'nullable|string|max:255',
            'issued_date'                => 'nullable|date',
            'incident_type'              => 'nullable|string|max:255',
            'incident_date'              => 'nullable|date',
            'arrived_date'               => 'nullable|date',
            'status'                     => 'nullable|string|max:255',
            'remark'                     => 'nullable|string',
            'package'                    => 'required|string|max:255',
            'CN_Number'                  => 'nullable|string|max:255',
            'contract_no'                => 'nullable|string|max:255',
            'agreement_no'               => 'nullable|string|max:255',
            'branch_in_uae'              => 'nullable|string|max:255',
            'CL_Number'                  => 'nullable|string|max:255',
            'CL_nationality'             => 'nullable|string|max:255',
            'current_status'             => 'nullable|string|max:255',
            'eid_no'                     => 'nullable|string|max:255',
            'wc_date'                    => 'nullable|date',
            'dw_number'                  => 'nullable|string|max:255',
            'visa_date'                  => 'nullable|date',
            'sales_comm_status'          => 'nullable|string|max:255',
            'missing_file'               => 'nullable|string|max:255',
            'religion'                   => 'nullable|in:Muslim,Christian,Other',
            'marital_status'             => 'nullable|integer|in:1,2,3,4',
            'children_count'             => 'nullable|integer|min:0',
            'experience_years'           => 'nullable|integer|min:1|max:10',
            'salary'                     => 'nullable|numeric',
            'delete_attachments'         => 'nullable|array',
            'delete_attachments.*'       => 'integer|exists:package_attachments,id',
            'attachment_type_existing'    => 'sometimes|array',
            'attachment_type_existing.*'  => 'nullable|string|max:255',
            'attachment_number_existing'  => 'sometimes|array',
            'attachment_number_existing.*'=> 'nullable|string|max:255',
            'issued_on_existing'          => 'sometimes|array',
            'issued_on_existing.*'        => 'nullable|date',
            'expired_on_existing'         => 'sometimes|array',
            'expired_on_existing.*'       => 'nullable|date',
            'attachment_file_existing'    => 'sometimes|array|max:10',
            'attachment_file_existing.*'  => 'file',
            'attachment_type_new'         => 'sometimes|array',
            'attachment_type_new.*'       => 'nullable|string|max:255',
            'attachment_number_new'       => 'sometimes|array',
            'attachment_number_new.*'     => 'nullable|string|max:255',
            'issued_on_new'               => 'sometimes|array',
            'issued_on_new.*'             => 'nullable|date',
            'expired_on_new'              => 'sometimes|array',
            'expired_on_new.*'            => 'nullable|date',
            'attachment_file_new'         => 'sometimes|array|max:10',
            'attachment_file_new.*'       => 'file',
            'inside_country_or_outside'   => 'required',
        ]);

        foreach ([
            'passport_expiry_date',
            'date_of_birth',
            'applied_date',
            'issued_date',
            'incident_date',
            'arrived_date',
            'wc_date',
            'visa_date',
        ] as $field) {
            if (!empty($validated[$field])) {
                $validated[$field] = Carbon::parse($validated[$field])->format('Y-m-d');
            }
        }

        foreach (['issued_on_existing', 'expired_on_existing'] as $group) {
            if (isset($validated[$group])) {
                foreach ($validated[$group] as $key => $value) {
                    if ($value) {
                        $validated[$group][$key] = Carbon::parse($value)->format('Y-m-d');
                    }
                }
            }
        }

        foreach (['issued_on_new', 'expired_on_new'] as $group) {
            if (isset($validated[$group])) {
                foreach ($validated[$group] as $key => $value) {
                    if ($value) {
                        $validated[$group][$key] = Carbon::parse($value)->format('Y-m-d');
                    }
                }
            }
        }

        if (!isset($validated['qid_no']) && $request->filled('eid_no')) {
            $validated['qid_no'] = $request->input('eid_no');
        }

        DB::beginTransaction();

        try {
            $package->update($validated);

            if (!empty($validated['delete_attachments'])) {
                PackageAttachment::whereIn('id', $validated['delete_attachments'])->delete();
            }

            $hasExistingMeta = $request->has('attachment_type_existing')
                || $request->has('attachment_number_existing')
                || $request->has('issued_on_existing')
                || $request->has('expired_on_existing')
                || $request->hasFile('attachment_file_existing');

            if ($hasExistingMeta) {
                $ids = array_unique(array_merge(
                    array_keys($validated['attachment_type_existing'] ?? []),
                    array_keys($validated['attachment_number_existing'] ?? []),
                    array_keys($validated['issued_on_existing'] ?? []),
                    array_keys($validated['expired_on_existing'] ?? []),
                    array_keys($request->file('attachment_file_existing') ?? [])
                ));

                foreach ($ids as $attId) {
                    if ($attachment = PackageAttachment::find($attId)) {
                        $attachment->attachment_type   = $validated['attachment_type_existing'][$attId]   ?? $attachment->attachment_type;
                        $attachment->attachment_number = $validated['attachment_number_existing'][$attId] ?? $attachment->attachment_number;
                        $attachment->issued_on         = $validated['issued_on_existing'][$attId]         ?? $attachment->issued_on;
                        $attachment->expired_on        = $validated['expired_on_existing'][$attId]        ?? $attachment->expired_on;

                        if ($request->hasFile("attachment_file_existing.$attId")) {
                            $file = $request->file("attachment_file_existing.$attId");
                            if ($file && $file->isValid()) {
                                $attachment->attachment_file = $file->store('attachments', 'public');
                                $attachment->attachment_name = $file->getClientOriginalName();
                            }
                        }

                        $attachment->save();
                    }
                }
            }

            if ($request->hasFile('attachment_file_new')) {
                foreach ($request->file('attachment_file_new') as $i => $file) {
                    if ($file->isValid()) {
                        PackageAttachment::create([
                            'package_id'        => $package->id,
                            'attachment_file'   => $file->store('attachments', 'public'),
                            'attachment_name'   => $file->getClientOriginalName(),
                            'attachment_type'   => $validated['attachment_type_new'][$i]   ?? null,
                            'attachment_number' => $validated['attachment_number_new'][$i] ?? null,
                            'issued_on'         => $validated['issued_on_new'][$i]         ?? null,
                            'expired_on'        => $validated['expired_on_new'][$i]        ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect('/candidates/inside')->with('success', 'Package updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating package', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to update package: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        try {
            $package->delete();
            return redirect()->route('package.index')->with('success', 'Package deleted successfully!');
        } catch (Exception $e) {
            Log::error('Error deleting package', ['error' => $e->getMessage()]);
            return redirect()->route('package.index')->withErrors(['error' => 'Failed to delete package: ' . $e->getMessage()]);
        }
    }

    private function mapRowToData($row)
    {
        $mapping = [
            1 => 'hr_ref_no',
            2 => 'sales_name',
            3 => 'candidate_name',
            4 => 'passport_no',
            5 => 'nationality',
            6 => 'passport_expiry_date',
            7 => 'date_of_birth',
            8 => 'foreign_partner',
            9 => 'visa_type',
            10 => 'sponsor_name',
            11 => 'qid_no',
            12 => 'applied_date',
            13 => 'vp_number',
            14 => 'issued_date',
            15 => 'incident_type',
            16 => 'incident_date',
            17 => 'arrived_date',
            18 => 'status',
            19 => 'remark',
        ];
        $data = [];
        foreach ($mapping as $column => $field) {
            $data[$field] = isset($row[$column]) && trim($row[$column]) !== '' ? trim($row[$column]) : "";
        }
        foreach (['passport_expiry_date', 'date_of_birth', 'applied_date', 'issued_date', 'incident_date', 'arrived_date'] as $dateField) {
            if (!empty($data[$dateField])) {
                $data[$dateField] = $this->sanitizeDate($data[$dateField]);
            }
        }
        $data['package'] = "Package 1";
        return $data;
    }

    private function sanitizeDate($dateValue)
    {
        if (is_numeric($dateValue)) {
            try {
                $date = Date::excelToDateTimeObject($dateValue)->format('Y-m-d');
                return (strtotime($date) !== false) ? $date : "";
            } catch (Exception $e) {
                return "";
            }
        }
        if (strtotime($dateValue) && preg_match('/^\d{4}-\d{2}-\d{2}$/', date('Y-m-d', strtotime($dateValue)))) {
            return date('Y-m-d', strtotime($dateValue));
        }
        return "";
    }

    private function generatePrefixedCode(string $column, string $prefix): string
    {
        $last = Package::whereNotNull($column)
            ->where($column, 'like', $prefix . '%')
            ->orderByDesc($column)  
            ->value($column);

        if (!$last) {
            return $prefix . str_pad('1', 4, '0', STR_PAD_LEFT);  
        }

        $number = (int) preg_replace('/\D/', '', $last);

        return $prefix . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
    }

    private function generateCN(): string
    {
        return $this->generatePrefixedCode('CN_Number', 'CN-');
    }

    private function generateHR(): string
    {
        return $this->generatePrefixedCode('hr_ref_no', 'HR-');
    }

    private function generateCNSeries(): string
    {
        return $this->generatePrefixedCode('cn_number_series', 'CN-');
    }

    private function updateProgress($current, $total)
    {
        $progress = ($current / $total) * 100;
        Log::info("Progress: $current/$total ($progress%)");
    }

    public function officeData($id)
    {
        $package = Package::findOrFail($id);
        return response()->json([
            'sales_name'       => $package->sales_name,
            'partner'          => $package->foreign_partner,
            'cn_number'        => $package->CN_Number,
            'cl_number'        => $package->CL_Number,
            'visa_type'        => $package->visa_type,
            'visa_status'      => $package->visa_status,
            'package'          => $package->package,
            'arrived_date'     => $package->arrived_date,
            'transferred_date' => $package->transferred_date,
        ]);
    }

    public function officeSave(Request $request)
    {
        $data = $request->validate([
            'package_id'           => ['required','integer',Rule::exists('packages','id')],
            'category'             => ['required','string'],
            'returned_date'        => ['required','date'],
            'expiry_date'          => ['required','date'],
            'overstay_days'        => ['required','integer','min:0'],
            'fine_amount'          => ['required','numeric','min:0'],
            'passport_status'      => ['required','string'],
            'ica_proof_attachment' => ['nullable','file','mimes:pdf,jpg,jpeg,png','max:5000'],
        ]);

        $package        = Package::findOrFail($data['package_id']);
        $previousStatus = $package->inside_status;
        $icaProofPath   = null;

        if ($request->hasFile('ica_proof_attachment')) {
            $file        = $request->file('ica_proof_attachment');
            $icaProofPath = $file->storeAs(
                'payment_proof',
                uniqid($package->id.'_', true) . '.' . $file->getClientOriginalExtension(),
                'public'
            );
        }

        try {
            DB::transaction(function () use ($data, $package, $icaProofPath, $previousStatus) {
                DB::table('packages')
                    ->where('id', $package->id)
                    ->update([
                        'inside_status'      => 1,
                        'change_status_date' => now(),
                    ]);

                DB::table('office')
                    ->where('candidate_id', $package->id)
                    ->where('type', 'package')
                    ->where('status', 1)
                    ->update(['status' => 0]);

                DB::table('office')->insert([
                    'candidate_id'    => $package->id,
                    'type'            => 'package',
                    'category'        => $data['category'],
                    'returned_date'   => $data['returned_date'],
                    'expiry_date'     => $data['expiry_date'],
                    'ica_proof'       => $icaProofPath,
                    'overstay_days'   => $data['overstay_days'],
                    'fine_amount'     => $data['fine_amount'],
                    'passport_status' => $data['passport_status'],
                    'status'          => 1,
                    'created_by'      => auth()->id(),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);

                $package->update([
                    'inside_status'             => 1,
                    'inside_country_or_outside' => 2,
                ]);

                if ($previousStatus === 2 && in_array($data['category'], ['Sales Return','Trial Return'], true)) {
                    $agreements = Agreement::where('candidate_id', $package->id)
                        ->where('agreement_type', 'BIA')
                        ->where('reference_of_candidate', $package->hr_ref_no)
                        ->pluck('hr_ref_no', 'id');

                    if ($agreements->isNotEmpty()) {
                        Agreement::whereIn('id', $agreements->keys())->update([
                            'status' => 4,
                            'notes'  => 'Agreement cancelled due to '.strtolower($data['category']),
                        ]);

                        Contract::whereIn('agreement_reference_no', $agreements->values())->update([
                            'status'  => 4,
                            'remarks' => 'Contract is cancelled due to '.strtolower($data['category']),
                        ]);

                        Invoice::whereIn('agreement_reference_no', $agreements->values())->update([
                            'status' => 'Cancelled',
                            'notes'  => 'Invoice is cancelled due to '.strtolower($data['category']),
                        ]);
                    }
                }
            });
        } catch (\Throwable $e) {
            if ($icaProofPath) {
                Storage::disk('public')->delete($icaProofPath);
            }
            throw $e;
        }

        return response()->json(['message' => 'Data saved successfully']);
    }

    public function updateOffice(Request $request)
    {
        $validated = $request->validate([
            'office_id'       => ['required', 'integer', Rule::exists('office', 'id')],
            'candidate_id'    => ['required', 'integer', Rule::exists('packages', 'id')],
            'type'            => ['required', 'string', Rule::in(['package'])],
            'category'        => ['required', 'string', 'max:100'],
            'returned_date'   => ['required', 'date'],
            'expiry_date'     => ['required', 'date'],
            'passport_status' => ['required', 'string', 'max:50'],
            'ica_proof'       => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'update_by'       => ['nullable', 'integer'],
        ]);

        $returned = \Carbon\Carbon::parse($validated['returned_date'])->startOfDay();
        $expiry   = \Carbon\Carbon::parse($validated['expiry_date'])->startOfDay();

        $overstayDays = $returned->gt($expiry) ? $expiry->diffInDays($returned) : 0;
        $fineAmount   = (float) ($overstayDays * 50);

        try {
            $result = DB::transaction(function () use ($request, $validated, $overstayDays, $fineAmount) {
                $office = DB::table('office')
                    ->where('id', $validated['office_id'])
                    ->lockForUpdate()
                    ->first();

                if (!$office) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Office record not found.',
                    ], 404);
                }

                if ((int) $office->candidate_id !== (int) $validated['candidate_id'] || (string) $office->type !== 'package') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid office record for this candidate/type.',
                    ], 422);
                }

                $proofPath = $office->ica_proof ?? null;

                if ($request->hasFile('ica_proof')) {
                    if ($proofPath) {
                        Storage::disk('public')->delete($proofPath);
                    }

                    $file = $request->file('ica_proof');
                    $proofPath = $file->storeAs(
                        'payment_proof',
                        uniqid($validated['candidate_id'] . '_', true) . '.' . $file->getClientOriginalExtension(),
                        'public'
                    );
                }

                $updateBy = $request->user()?->id ?? ($validated['update_by'] ?? null);

                DB::table('office')
                    ->where('id', $validated['office_id'])
                    ->update([
                        'category'        => $validated['category'],
                        'returned_date'   => $validated['returned_date'],
                        'expiry_date'     => $validated['expiry_date'],
                        'overstay_days'   => $overstayDays,
                        'fine_amount'     => number_format($fineAmount, 2, '.', ''),
                        'passport_status' => $validated['passport_status'],
                        'ica_proof'       => $proofPath,
                        'update_by'       => $updateBy,
                        'updated_at'      => now(),
                    ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Office record updated successfully.',
                    'data'    => [
                        'office_id'     => (int) $validated['office_id'],
                        'candidate_id'  => (int) $validated['candidate_id'],
                        'overstay_days' => $overstayDays,
                        'fine_amount'   => number_format($fineAmount, 2, '.', ''),
                        'ica_proof'     => $proofPath,
                    ],
                ]);
            });

            return $result;
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function trial(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $type = $request->input('type');
        $status = $request->input('status');
        $query = Trial::with(['client'])->orderBy('updated_at', 'desc');

        if ($type === 'package') {
            $query->where('trial_type', 'package');
        } elseif ($type === 'package') {
            $query->where('trial_type', 'package');
        }

        switch ($status) {
            case 'trial':
                $query->where('trial_status', 'Active');
                break;
            case 'confirm':
                $query->where('trial_status', 'Confirmed');
                break;
            case 'change-status':
                $query->where('trial_status', 'Change Status');
                break;
        }

        $trials = $query->paginate(10);

        if ($request->ajax()) {
            return view('package.partials.trial_table', compact('trials', 'now'));
        }

        return view('package.index', compact('trials', 'now'));
    }

    public function updateStatusInside(Request $request, int $packageId)
    {
        $statusId = (int) ($request->input('status_id') ?? $request->input('inside_status'));

        $validated = $request->validate([
            'status_id' => ['nullable', 'integer', 'in:1,2,3,4,5'],
            'inside_status' => ['nullable', 'integer', 'in:1,2,3,4,5'],
            'client_id' => ['nullable', 'integer'],
        ]);

        if ($statusId < 1 || $statusId > 5) {
            abort(422, 'Invalid status.');
        }

        $clientId = $validated['client_id'] ?? null;

        $package = Package::query()->findOrFail($packageId);
        $clients = CRM::query()->get();

        $fmtDate = static function ($value): ?string {
            if ($value === null || $value === '') return null;
            try { return \Carbon\Carbon::parse($value)->format('Y-m-d'); } catch (\Throwable $e) { return null; }
        };

        $passportNoRaw = trim((string) ($package->passport_no ?? ''));
        $passportNoKey = $passportNoRaw !== '' ? strtoupper($passportNoRaw) : '';

        $agreement = null;

        if ($passportNoKey !== '') {
            $q = Agreement::query()
                ->with('client')
                ->whereIn('agreement_type', ['BIA', 'BOA']);

            $cols = [
                'passport_no',
                'passsport_no',
                'passport_number',
                'passport',
            ];

            $hasAny = false;

            foreach ($cols as $col) {
                if (\Illuminate\Support\Facades\Schema::hasColumn('agreements', $col)) {
                    $hasAny = true;
                    $q->orWhereRaw("TRIM(UPPER({$col})) = ?", [$passportNoKey]);
                }
            }

            if ($hasAny) {
                $agreement = $q->orderByDesc('created_at')->orderByDesc('id')->first();
            }
        }

        $pendingInvoiceStatuses = ['Partially Paid', 'Pending'];

        $invoices = collect();
        if (!empty($agreement?->reference_no)) {
            $invoices = DB::table('invoices')
                ->where('agreement_reference_no', $agreement->reference_no)
                ->whereIn('status', $pendingInvoiceStatuses)
                ->orderByDesc('invoice_id')
                ->get();
        }

        $totalAmount = (float) $invoices->sum(fn ($i) => (float) ($i->total_amount ?? 0));
        $receivedAmount = (float) $invoices->sum(fn ($i) => (float) ($i->received_amount ?? 0));
        $remainingAmount = max($totalAmount - $receivedAmount, 0.0);

        $vatAmount = 0.0;
        if ($agreement) {
            $vatAmount = (float) ($agreement->vat_amount ?? $agreement->vat ?? 0);
        } elseif ($invoices->count()) {
            $first = (array) $invoices->first();
            if (array_key_exists('vat_amount', $first)) {
                $vatAmount = (float) $invoices->sum(fn ($i) => (float) ($i->vat_amount ?? 0));
            } elseif (array_key_exists('vat', $first)) {
                $vatAmount = (float) $invoices->sum(fn ($i) => (float) ($i->vat ?? 0));
            }
        }

        $remainingAmountWithVat = $remainingAmount + $vatAmount;

        $agreementPayload = $agreement ? [
            'id' => $agreement->id,
            'reference_no' => $agreement->reference_no ?? null,
            'agreement_no' => $agreement->agreement_no ?? $agreement->reference_no ?? null,
            'agreement_type' => $agreement->agreement_type ?? null,
            'status' => $agreement->status ?? null,
            'client_id' => $agreement->client_id ?? null,
            'client_name' => $agreement?->client?->name ?? null,
            'contract_start_date' => $fmtDate($agreement->contract_start_date ?? $agreement->start_date ?? $agreement->agreement_start_date),
            'contract_end_date' => $fmtDate($agreement->contract_end_date ?? $agreement->end_date ?? $agreement->agreement_end_date),
            'vat_amount' => $vatAmount,
        ] : null;

        $candidateDetails = [
            'candidate_id' => $package->id,
            'candidate_name' => $package->candidate_name,
            'candidate_reference_no' => $package->hr_ref_no,
            'candidate_ref_no' => $package->hr_ref_no,
            'foreign_partner' => $package->foreign_partner,
            'candidate_nationality' => $package->nationality,
            'candidate_passport_number' => $package->passport_no,
            'candidate_passport_expiry' => $fmtDate($package->passport_expiry_date),
            'candidate_dob' => $fmtDate($package->date_of_birth),
            'arrived_date' => $fmtDate($package->date_of_joining),
            'sponsor_name' => $package->sponsor_name ?? $package->employer_name ?? null,
            'employer_name' => $package->employer_name ?? $package->sponsor_name ?? null,
            'sponsor_qid' => $package->emirates_id ?? null,

            'agreement' => $agreementPayload,
            'agreement_id' => $agreementPayload['id'] ?? null,
            'agreement_reference_no' => $agreementPayload['reference_no'] ?? null,
            'agreement_type' => $agreementPayload['agreement_type'] ?? null,
            'agreement_client_id' => $agreementPayload['client_id'] ?? null,
            'contract_start_date' => $agreementPayload['contract_start_date'] ?? null,
            'contract_end_date' => $agreementPayload['contract_end_date'] ?? null,

            'total_amount' => $totalAmount,
            'received_amount' => $receivedAmount,
            'remaining_amount' => $remainingAmount,
            'vat_amount' => $vatAmount,
            'remaining_with_vat' => $remainingAmountWithVat,
            'office_charges' => 0,
            'invoices' => $invoices,
        ];

        $modals = [
            1 => ['officeModal', 'Please update the office details.'],
            2 => ['trialModal', 'Please update the trial details.'],
            5 => ['incidentModal', 'Please update the Incident details.'],
        ];

        if (isset($modals[$statusId])) {
            [$modalId, $message] = $modals[$statusId];

            return response()->json([
                'success' => true,
                'action' => 'open_modal',
                'modal' => $modalId,
                'message' => $message,
                'clients' => $clients,
                'candidateDetails' => $candidateDetails,
            ]);
        }

        return response()->json([
            'success' => true,
            'action' => 'update_only',
            'message' => 'Status updated.',
            'clients' => $clients,
            'candidateDetails' => $candidateDetails,
        ]);
    }


    protected $acctInv;

    public function __construct(AccountInvoiceController $acctInv)
    {
        $this->acctInv = $acctInv;
    }

    public function saveTrialConfirmed(Request $request)
    {
        $v = $request->validate([
            'trial_id'        => ['required', 'integer', 'exists:trials,id'],
            'candidate_id'    => ['required', 'integer', 'exists:packages,id'],
            'confirmed_date'  => ['required', 'date'],
            'employer_name'   => ['required', 'string', 'max:255'],
            'payment_method'  => ['required', 'string', 'max:50'],
            'received_amount' => ['required', 'numeric', 'min:0'],
            'payment_proof'   => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5000'],
        ]);

        $filePath = $request->file('payment_proof')->store('payment_proofs', 'public');
        $now = Carbon::now('Asia/Dubai');

        try {
            DB::transaction(function () use ($v, $filePath, $request, $now) {
                $package = Package::query()->findOrFail($v['candidate_id']);

                $pkgUpdated = Package::query()->whereKey($package->id)->update([
                    'inside_status'      => 6,
                    'change_status_date' => $now,
                ]);

                if ($pkgUpdated !== 1) {
                    throw new \RuntimeException('Failed to update package status');
                }

                $request->merge(['received_amount' => $v['received_amount']]);
                $invoice = $this->acctInv->createPendingInvoice($request, $filePath);

                PaymentProof::query()->create([
                    'candidate_id'       => $v['candidate_id'],
                    'client_name'        => $v['employer_name'],
                    'invoice_id'         => $invoice->invoice_id,
                    'invoice_amount'     => $invoice->total_amount,
                    'received_amount'    => $invoice->received_amount,
                    'payment_method'     => $v['payment_method'],
                    'payment_proof_path' => $filePath,
                    'created_by'         => auth()->id(),
                ]);

                $trialUpdated = Trial::query()->whereKey($v['trial_id'])->update([
                    'trial_status'   => 'Confirmed',
                    'confirmed_date' => Carbon::parse($v['confirmed_date'], 'Asia/Dubai')->toDateString(),
                    'payment_proof'  => $filePath,
                    'updated_at'     => now(),
                ]);

                if ($trialUpdated !== 1) {
                    throw new \RuntimeException('Failed to update trial');
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Package trial confirmed and invoice updated successfully.',
            ]);
        } catch (\Throwable $e) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            Log::error('saveTrialConfirmed failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'An error occurred while confirming trial.',
            ], 500);
        }
    }

    public function saveTrialReturn(Request $request)
    {
        $v = $request->validate([
            'trial_id'          => ['required','integer','exists:trials,id'],
            'candidate_id'      => ['required','integer','exists:packages,id'],
            'proof'             => ['required','file','mimes:pdf,jpg,jpeg,png','max:5000'],
            'remarks'           => ['nullable','string'],

            'customer_decision' => ['nullable','string',Rule::in(['Refund','Replacement'])],
            'refund_type'       => ['nullable','string',Rule::in(['employee','package'])],
            'office_charges'    => ['nullable','numeric','min:0'],
            'balance_amount'    => ['nullable','numeric','min:0'],
            'refund_due_date'   => ['nullable','date'],
        ]);

        if (!empty($v['customer_decision'])) {
            if (empty($v['refund_due_date'])) {
                throw ValidationException::withMessages(['refund_due_date' => ['Refund/Replacement due date is required.']]);
            }
            if (empty($v['refund_type'])) {
                throw ValidationException::withMessages(['refund_type' => ['Refund type is required (employee/package).']]);
            }
            $this->assertDueDate(Carbon::parse($v['refund_due_date'], 'Asia/Dubai')->toDateString());
        }

        $filePath = $request->file('proof')->store('trial_return_proof', 'public');
        $now = Carbon::now('Asia/Dubai');

        try {
            DB::transaction(function () use ($v, $filePath, $now) {
                $package = Package::query()->findOrFail($v['candidate_id']);

                Package::query()->whereKey($package->id)->update([
                    'inside_status'      => 1,
                    'change_status_date' => $now,
                ]);

                DB::table('office')
                    ->where(['candidate_id' => $package->id, 'type' => 'package'])
                    ->limit(1)
                    ->update(['status' => 1, 'updated_at' => now()]);

                $trialUpdated = Trial::query()->whereKey($v['trial_id'])->update([
                    'trial_status'        => 'Trial Return',
                    'trial_return_date'   => $now->toDateString(),
                    'change_status_proof' => $filePath,
                    'remarks'             => $v['remarks'] ?? null,
                    'updated_at'          => now(),
                ]);

                if ($trialUpdated !== 1) {
                    throw new \RuntimeException('Failed to update trial return.');
                }

                if (empty($v['customer_decision'])) {
                    return;
                }

                $agreement = $this->latestAgreementForPackage($package);
                $clientId = (int) ($agreement->client_id ?? 0);

                if ($clientId <= 0) {
                    throw ValidationException::withMessages(['agreement_client_id' => ['Client is required. Please ensure agreement exists.']]);
                }

                $isRefund = $v['customer_decision'] === 'Refund';
                $refNo = $this->generatePrefixedRef(
                    $isRefund ? 'refunds' : 'replacements',
                    'reference_no',
                    $isRefund ? 'RF-' : 'RP-'
                );

                $payload = [
                    'reference_no'          => $refNo,
                    'candidate_id'          => $package->id,
                    'client_id'             => $clientId,
                    'type'                  => 'Trial Return',
                    $isRefund ? 'refund_type' : 'replacement_type' => $v['refund_type'],
                    'candidate_name'        => $package->candidate_name,
                    'sponsor_name'          => $package->sponsor_name,
                    'passport_no'           => $package->passport_no,
                    'nationality'           => $package->nationality,
                    'foreign_partner'       => $package->foreign_partner,
                    'agreement_no'          => $agreement?->reference_no,
                    'contract_start_date'   => $agreement?->contract_start_date ? Carbon::parse($agreement->contract_start_date, 'Asia/Dubai')->toDateString() : ($agreement?->agreement_start_date ? Carbon::parse($agreement->agreement_start_date, 'Asia/Dubai')->toDateString() : null),
                    'contract_end_date'     => $agreement?->contract_end_date ? Carbon::parse($agreement->contract_end_date, 'Asia/Dubai')->toDateString() : ($agreement?->agreement_end_date ? Carbon::parse($agreement->agreement_end_date, 'Asia/Dubai')->toDateString() : null),
                    'return_date'           => $now->toDateString(),
                    'office_charges'        => (float)($v['office_charges'] ?? 0),
                    'refun_type'            => 'package',
                    'refunded_amount'       => (float)($v['balance_amount'] ?? 0),
                    'refund_date'           => Carbon::parse($v['refund_due_date'], 'Asia/Dubai')->toDateString(),
                    'payment_proof'         => $filePath,
                    'original_passport'     => 0,
                    'worker_belongings'     => 0,
                    'status'                => 'open',
                    'sales_name'            => $package->sales_name ?? null,
                    'updated_by_sales_name' => trim((string) (auth()->user()->name ?? auth()->user()->full_name ?? auth()->user()->first_name ?? '')) ?: null,
                    'package'               => $package->package,
                ];

                $this->upsertRefundOrReplacement($payload, $v['customer_decision']);
            });

            return response()->json(['success' => true, 'message' => 'Trial Return updated successfully.'], 200);
        } catch (\Throwable $e) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            Log::error('saveTrialReturn failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'An error occurred while saving Trial Return.',
            ], 500);
        }
    }

    public function saveReturnIncident(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trial_id'      => ['required', 'exists:trials,id'],
            'candidate_id'  => ['required', 'exists:packages,id'],
            'incident_type' => ['required', 'string', 'max:100'],
            'incident_date' => ['required', 'date'],
            'remarks'       => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            $payload = [
                'success' => false,
                'message' => 'Validation error.',
                'errors'  => $validator->errors(),
            ];

            return $request->expectsJson()
                ? response()->json($payload, 422)
                : back()->withErrors($validator)->withInput();
        }

        $v = $validator->validated();
        $date = Carbon::parse($v['incident_date'], 'Asia/Dubai')->toDateString();

        try {
            DB::beginTransaction();

            $pkgUpdated = Package::query()->whereKey($v['candidate_id'])->update([
                'inside_status' => 5,
                'incident_type' => $v['incident_type'],
                'incident_date' => $date,
            ]);

            if ($pkgUpdated !== 1) {
                throw new \RuntimeException('Failed to update package.');
            }

            $trialUpdated = Trial::query()->whereKey($v['trial_id'])->update([
                'trial_status'  => 'Incident',
                'incident_type' => $v['incident_type'],
                'incident_date' => $date,
                'remarks'       => $v['remarks'] ?? null,
                'updated_at'    => now(),
            ]);

            if ($trialUpdated !== 1) {
                throw new \RuntimeException('Failed to update trial.');
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Incident recorded.',
                ]);
            }

            return redirect('/candidates/inside')->with('success', 'Incident recorded.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('saveReturnIncident failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);

            $payload = [
                'success' => false,
                'message' => $e->getMessage() ?: 'An unexpected error occurred while saving the incident.',
            ];

            return $request->expectsJson()
                ? response()->json($payload, 500)
                : back()->with('error', $payload['message'])->withInput();
        }
    }

    public function updateCandidateDetails(Request $request)
    {
        $request->validate([
            'candidate_id'            => 'required|integer|exists:packages,id',
            'arrived_in_office_date'  => 'required|date',
            'visa_type'               => 'required|string',
            'overstay_days'           => 'required|integer',
            'fine_amount'             => 'required|numeric',
            'preferred_package'       => 'required|string',
            'accomodation'            => 'required|string',
            'passport_status'         => 'required|string',
            'visa_issue_date'         => 'nullable|date',
            'visa_expiry_date'        => 'nullable|date',
            'entry_date'              => 'nullable|date',
            'cancellation_date'       => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            $arrived_in_office_date = Carbon::parse($request->arrived_in_office_date, 'Asia/Dubai')->toDateString();
            $visa_issue_date = $request->visa_issue_date ? Carbon::parse($request->visa_issue_date, 'Asia/Dubai')->toDateString() : null;
            $visa_expiry_date = $request->visa_expiry_date ? Carbon::parse($request->visa_expiry_date, 'Asia/Dubai')->toDateString() : null;
            $entry_date = $request->entry_date ? Carbon::parse($request->entry_date, 'Asia/Dubai')->toDateString() : null;
            $cancellation_date = $request->cancellation_date ? Carbon::parse($request->cancellation_date, 'Asia/Dubai')->toDateString() : null;

            $now = Carbon::now('Asia/Dubai');

            $updated = Package::query()->whereKey($request->candidate_id)->update([
                'arrived_in_office_date' => $arrived_in_office_date,
                'visa_type'              => $request->visa_type,
                'overstay_days'          => $request->overstay_days,
                'fine_amount'            => $request->fine_amount,
                'preferred_package'      => $request->preferred_package,
                'accomodation'           => $request->accomodation,
                'passport_status'        => $request->passport_status,
                'visa_issue_date'        => $visa_issue_date,
                'visa_expiry_date'       => $visa_expiry_date,
                'entry_date'             => $entry_date,
                'cancellation_date'      => $cancellation_date,
                'inside_status'          => 1,
                'change_status_date'     => $now,
                'office_date'            => $now,
                'updated_by'             => auth()->id(),
                'updated_at'             => $now,
            ]);

            if ($updated !== 1) {
                throw new \RuntimeException('Failed to update candidate.');
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Candidate details updated successfully.']);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error updating candidate details', [
                'error_message' => $e->getMessage(),
                'line'          => $e->getLine(),
                'file'          => $e->getFile(),
                'request_data'  => $request->all(),
            ]);

            return response()->json(['success' => false, 'message' => $e->getMessage() ?: 'Failed to update candidate details.'], 500);
        }
    }

    public function updateTrialStatus(Request $request)
    {
        $validated = $request->validate([
            'status'       => ['required','string'],
            'trial_id'     => ['required','integer','exists:trials,id'],
            'candidate_id' => ['required','integer','exists:packages,id'],
            'client_id'    => ['required','integer','exists:crm,id'],
        ]);

        $candidate = Package::query()->findOrFail($validated['candidate_id']);
        $client = CRM::query()->findOrFail($validated['client_id']);

        $agreement = Agreement::query()
            ->where('candidate_id', $candidate->id)
            ->where('agreement_type', 'BIA')
            ->whereIn('package', ['PKG-1','PACKAGE 1'])
            ->where('status', '!=', 4)
            ->orderByDesc('created_at')
            ->first();

        if (!$agreement) {
            return response()->json([
                'success' => false,
                'message' => 'Agreement not found.',
            ], 404);
        }

        $invoices = Invoice::query()
            ->where('agreement_reference_no', $agreement->reference_no)
            ->whereIn('status', ['Pending','Partially Paid'])
            ->orderByDesc('invoice_id')
            ->get()
            ->map(function ($i) {
                return [
                    'invoice_id'      => $i->invoice_id,
                    'invoice_number'  => $i->invoice_number ?? $i->invoice_id,
                    'invoice_date'    => $i->invoice_date ? Carbon::parse($i->invoice_date, 'Asia/Dubai')->toDateString() : null,
                    'total_amount'    => (float) $i->total_amount,
                    'received_amount' => (float) $i->received_amount,
                    'status'          => (string) $i->status,
                ];
            })
            ->values();

        $totalAmount = (float) $invoices->sum('total_amount');
        $receivedAmount = (float) $invoices->sum('received_amount');
        $remainingAmount = max(0, $totalAmount - $receivedAmount);

        $agreementPayload = [
            'id'                    => $agreement->id,
            'agreement_reference_no' => $agreement->reference_no,
            'agreement_type'         => $agreement->agreement_type,
            'status'                 => $agreement->status,
            'package'                => $agreement->package,
            'contract_start_date'    => $agreement->contract_start_date ? Carbon::parse($agreement->contract_start_date, 'Asia/Dubai')->toDateString() : ($agreement->agreement_start_date ? Carbon::parse($agreement->agreement_start_date, 'Asia/Dubai')->toDateString() : null),
            'contract_end_date'      => $agreement->contract_end_date ? Carbon::parse($agreement->contract_end_date, 'Asia/Dubai')->toDateString() : ($agreement->agreement_end_date ? Carbon::parse($agreement->agreement_end_date, 'Asia/Dubai')->toDateString() : null),
            'total_amount'           => (float) ($agreement->total_amount ?? $totalAmount),
            'received_amount'        => $receivedAmount,
            'remaining_amount'       => $remainingAmount,
        ];

        $candidateDetails = [
            'candidate_id'             => $candidate->id,
            'client_id'                => (int) $validated['client_id'],
            'trial_id'                 => (int) $validated['trial_id'],
            'reference_no'             => (string) ($candidate->hr_ref_no ?? ''),
            'candidate_name'           => (string) ($candidate->candidate_name ?? ''),
            'foreign_partner'          => (string) ($candidate->foreign_partner ?? ''),
            'nationality'              => (string) ($candidate->nationality ?? ''),
            'passport_number'          => (string) ($candidate->passport_no ?? ''),
            'passport_expiry'          => $candidate->passport_expiry_date ? Carbon::parse($candidate->passport_expiry_date, 'Asia/Dubai')->toDateString() : null,
            'dob'                      => $candidate->date_of_birth ? Carbon::parse($candidate->date_of_birth, 'Asia/Dubai')->toDateString() : null,
            'employer_name'            => (string) ($candidate->employer_name ?? ''),
            'client_name'              => trim((string) ($client->first_name ?? '').' '.(string) ($client->last_name ?? '')),
            'agreement'                => $agreementPayload,
            'invoices'                 => $invoices,
            'remaining_amount_with_vat'=> $remainingAmount,
        ];

        $status = trim((string) $validated['status']);

        $allowed = [
            'Contracted'    => ['modal' => 'ContractedModal',   'message' => 'Please update the contracted details.'],
            'Trial Return'  => ['modal' => 'TrialReturnModal',  'message' => 'Please update the trial return details.'],
            'Incident'      => ['modal' => 'incidentModal',     'message' => 'Please update the incident details.'],
            'Sales Return'  => ['modal' => 'SalesReturnModal',  'message' => 'Please update the sales return details.'],
            'Change Status' => ['modal' => 'ChangeStatusModal', 'message' => 'Please update the changed status details.'],
            'Confirmed'     => ['modal' => null,                'message' => 'Status updated successfully.'],
        ];

        if (!array_key_exists($status, $allowed)) {
            return response()->json([
                'success' => false,
                'message' => "You can't change the trial status.",
            ], 403);
        }

        if ($status === 'Confirmed') {
            $now = Carbon::now('Asia/Dubai');

            $candidate->inside_status = 3;
            $candidate->change_status_date = $now;
            $candidate->save();

            Trial::query()->whereKey($validated['trial_id'])->update([
                'trial_status' => 'Confirmed',
                'updated_at'   => now(),
            ]);

            return response()->json([
                'success'          => true,
                'action'           => 'reload',
                'message'          => $allowed[$status]['message'],
                'candidateDetails' => $candidateDetails,
            ]);
        }

        return response()->json([
            'success'          => true,
            'action'           => 'open_modal',
            'modal'            => $allowed[$status]['modal'],
            'message'          => $allowed[$status]['message'],
            'candidateDetails' => $candidateDetails,
        ]);
    }

    public function updateChangeStatus(Request $request)
    {
        $validatedData = $request->validate([
            'trial_id'               => ['required','integer','exists:trials,id'],
            'candidate_id'           => ['required','integer','exists:packages,id'],
            'employer_name'          => ['required','string','max:255'],
            'change_status_date'     => ['required','date'],
            'change_status_proof'    => ['required','file','mimes:pdf,jpg,jpeg,png','max:5000'],
            'penalty_payment_amount' => ['nullable','numeric','min:0'],
            'penalty_payment_proof'  => ['nullable','file','mimes:pdf,jpg,jpeg,png','max:5000'],
            'penalty_paid_by'        => ['nullable','string','max:50'],
            'istiraha_proof'         => ['nullable','file','mimes:pdf,jpg,jpeg,png','max:5000'],
        ]);

        $proofPath = null;
        $penaltyPaymentFilePath = null;
        $istirahaProofFilePath = null;

        try {
            DB::transaction(function () use ($validatedData, $request, &$proofPath, &$penaltyPaymentFilePath, &$istirahaProofFilePath) {
                $proofPath = $request->file('change_status_proof')->store('change_status_proof', 'public');

                $penaltyPaymentFilePath = $request->hasFile('penalty_payment_proof')
                    ? $request->file('penalty_payment_proof')->store('penalty_payment_proof', 'public')
                    : null;

                $istirahaProofFilePath = $request->hasFile('istiraha_proof')
                    ? $request->file('istiraha_proof')->store('istiraha_proof', 'public')
                    : null;

                $trialUpdated = Trial::query()->whereKey($validatedData['trial_id'])->update([
                    'trial_status'           => 'Change Status',
                    'employer_name'          => $validatedData['employer_name'],
                    'change_status_date'     => Carbon::parse($validatedData['change_status_date'], 'Asia/Dubai')->toDateString(),
                    'change_status_proof'    => $proofPath,
                    'penalty_payment_amount' => $validatedData['penalty_payment_amount'] ?? 0,
                    'penalty_payment_proof'  => $penaltyPaymentFilePath,
                    'penalty_paid_by'        => $validatedData['penalty_paid_by'] ?? null,
                    'istiraha_proof'         => $istirahaProofFilePath,
                    'updated_at'             => now(),
                ]);

                $packageUpdated = Package::query()->whereKey($validatedData['candidate_id'])->update([
                    'inside_status'      => 4,
                    'change_status_date' => Carbon::parse($validatedData['change_status_date'], 'Asia/Dubai'),
                    'updated_at'         => now(),
                ]);

                if ($trialUpdated !== 1) {
                    throw new \RuntimeException("Trial with ID {$validatedData['trial_id']} could not be updated.");
                }
                if ($packageUpdated !== 1) {
                    throw new \RuntimeException("Package with ID {$validatedData['candidate_id']} could not be updated.");
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Change status updated successfully.',
            ]);
        } catch (\Throwable $e) {
            if ($proofPath && Storage::disk('public')->exists($proofPath)) Storage::disk('public')->delete($proofPath);
            if ($penaltyPaymentFilePath && Storage::disk('public')->exists($penaltyPaymentFilePath)) Storage::disk('public')->delete($penaltyPaymentFilePath);
            if ($istirahaProofFilePath && Storage::disk('public')->exists($istirahaProofFilePath)) Storage::disk('public')->delete($istirahaProofFilePath);

            Log::error('updateChangeStatus failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'An error occurred while updating change status.',
            ], 500);
        }
    }

    public function exit_form($referenceNo)
    {
        $package = Package::query()->where('cn_number_series', $referenceNo)->firstOrFail();
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('package.exit', compact('package', 'now'));
    }

    public function incidentSave(Request $request)
    {
        $data = $request->validate([
            'candidate_id'           => ['required','integer',Rule::exists('packages','id')],
            'refund_type'            => ['required','string',Rule::in(['employee','package'])],
            'incident_category'      => ['nullable','string','max:191'],
            'incident_reason'        => ['required','string','max:191'],
            'other_reason'           => ['nullable','string','max:255'],
            'incident_expiry_date'   => ['nullable','date'],
            'customer_decision'      => ['required','string',Rule::in(['Refund','Replacement'])],
            'office_charges'         => ['nullable','numeric','min:0'],
            'balance_amount'         => ['nullable','numeric','min:0'],
            'refund_due_date'        => ['required','date'],
            'proof'                  => ['required','file','mimes:pdf,jpg,jpeg,png','max:5000'],
            'remarks'                => ['nullable','string'],

            'agreement_reference_no' => ['nullable','string','max:255'],
            'agreement_client_id'    => ['nullable','integer'],
            'agreement_start_date'   => ['nullable','date'],
            'agreement_end_date'     => ['nullable','date'],
            'contracted_amount'      => ['nullable','numeric','min:0'],
            'received_amount'        => ['nullable','numeric','min:0'],
        ]);

        $this->assertDueDate(Carbon::parse($data['refund_due_date'], 'Asia/Dubai')->toDateString());

        $package = Package::query()->findOrFail($data['candidate_id']);
        $agreement = $this->latestAgreementForPackage($package);

        $clientId = (int) ($data['agreement_client_id'] ?? ($agreement->client_id ?? 0));
        if ($clientId <= 0) {
            throw ValidationException::withMessages([
                'agreement_client_id' => ['Client is required. Please ensure agreement exists.'],
            ]);
        }

        $proofPath = $request->file('proof')->store('incident_proof', 'public');

        $reason = strtoupper(trim($data['incident_reason']));
        if ($reason === 'OTHER') {
            $other = strtoupper(trim((string) ($data['other_reason'] ?? '')));
            if ($other === '') {
                throw ValidationException::withMessages(['other_reason' => ['Please specify reason.']]);
            }
            $reason = $other;
        }

        $incidentDate = Carbon::now('Asia/Dubai')->toDateString();
        $dueDate = Carbon::parse($data['refund_due_date'], 'Asia/Dubai')->toDateString();
        $officeCharges = (float) ($data['office_charges'] ?? 0);
        $balanceAmount = (float) ($data['balance_amount'] ?? 0);

        $agreementRef = (string) ($data['agreement_reference_no'] ?? ($agreement->reference_no ?? ''));

        $contractStart = $data['agreement_start_date']
            ? Carbon::parse($data['agreement_start_date'], 'Asia/Dubai')->toDateString()
            : ($agreement?->contract_start_date ? Carbon::parse($agreement->contract_start_date, 'Asia/Dubai')->toDateString() : ($agreement?->agreement_start_date ? Carbon::parse($agreement->agreement_start_date, 'Asia/Dubai')->toDateString() : null));

        $contractEnd = $data['agreement_end_date']
            ? Carbon::parse($data['agreement_end_date'], 'Asia/Dubai')->toDateString()
            : ($agreement?->contract_end_date ? Carbon::parse($agreement->contract_end_date, 'Asia/Dubai')->toDateString() : ($agreement?->agreement_end_date ? Carbon::parse($agreement->agreement_end_date, 'Asia/Dubai')->toDateString() : null));

        $contractedAmount = (float) ($data['contracted_amount'] ?? 0);
        $receivedAmount = (float) ($data['received_amount'] ?? 0);

        try {
            DB::transaction(function () use (
                $package,
                $data,
                $proofPath,
                $clientId,
                $incidentDate,
                $dueDate,
                $officeCharges,
                $balanceAmount,
                $reason,
                $agreementRef,
                $contractStart,
                $contractEnd,
                $contractedAmount,
                $receivedAmount
            ) {
                $prevInsideStatus = (int) ($package->inside_status ?? 0);

                $package->update([
                    'inside_status'      => 5,
                    'incident_type'      => 'IAA - '.$reason,
                    'incident_date'      => $incidentDate,
                    'remarks'            => $data['remarks'] ?? null,
                    'change_status_date' => Carbon::now('Asia/Dubai'),
                    'updated_at'         => now(),
                ]);

                if ($prevInsideStatus === 1) {
                    DB::table('office')
                        ->where('candidate_id', $package->id)
                        ->where('type', 'package')
                        ->where('status', 1)
                        ->update(['status' => 0, 'updated_at' => now()]);
                }

                if ($prevInsideStatus === 2) {
                    DB::table('trials')
                        ->where('candidate_id', $package->id)
                        ->where('trial_type', 'package')
                        ->update(['trial_status' => 'Incident', 'updated_at' => now()]);
                }

                $isRefund = $data['customer_decision'] === 'Refund';
                $refNo = $this->generatePrefixedRef(
                    $isRefund ? 'refunds' : 'replacements',
                    'reference_no',
                    $isRefund ? 'RF-' : 'RP-'
                );

                $payload = [
                    'reference_no'          => $refNo,
                    'candidate_id'          => $package->id,
                    'client_id'             => $clientId,
                    'type'                  => 'Incident After Arrival',
                    $isRefund ? 'refund_type' : 'replacement_type' => $data['refund_type'],
                    'candidate_name'        => $package->candidate_name,
                    'sponsor_name'          => $package->sponsor_name,
                    'passport_no'           => $package->passport_no,
                    'nationality'           => $package->nationality,
                    'foreign_partner'       => $package->foreign_partner,
                    'agreement_no'          => $agreementRef !== '' ? $agreementRef : null,
                    'contract_start_date'   => $contractStart,
                    'contract_end_date'     => $contractEnd,
                    'return_date'           => $incidentDate,
                    'contracted_amount'     => $contractedAmount > 0 ? $contractedAmount : null,
                    'office_charges'        => $officeCharges,
                    'refunded_amount'       => $balanceAmount,
                    'refund_date'           => $dueDate,
                    'refund_type'           => 'package',
                    'payment_proof'         => $proofPath,
                    'original_passport'     => 0,
                    'worker_belongings'     => 0,
                    'status'                => 'open',
                    'sales_name'            => $package->sales_name ?? null,
                    'updated_by_sales_name' => trim((string) (auth()->user()->name ?? auth()->user()->full_name ?? auth()->user()->first_name ?? '')) ?: null,
                    'package'               => $package->package,
                ];

                $this->upsertRefundOrReplacement($payload, $data['customer_decision']);
            });

            return response()->json(['success' => true, 'message' => 'Incident saved successfully.'], 200);
        } catch (\Throwable $e) {
            if ($proofPath && Storage::disk('public')->exists($proofPath)) {
                Storage::disk('public')->delete($proofPath);
            }

            Log::error('incidentSave failed', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Failed to save incident.',
            ], 500);
        }
    }

    protected function assertDueDate(string $ymdDate): void
    {
        $tz = 'Asia/Dubai';
        $due = Carbon::parse($ymdDate, $tz)->startOfDay();
        $min = Carbon::now($tz)->startOfDay()->addDays(7);

        if ($due->lt($min)) {
            throw ValidationException::withMessages([
                'refund_due_date' => ['Refund/Replacement due date must be at least 7 days from today.'],
            ]);
        }

        if ($due->dayOfWeek === Carbon::SUNDAY) {
            throw ValidationException::withMessages([
                'refund_due_date' => ['Sunday is off. Please choose another date.'],
            ]);
        }
    }

    protected function resolveCandidateFromPackage(Package $package)
    {
        $candidate = NewCandidate::with('attachments')
            ->where('passport_no', $package->passport_no)
            ->first();
            
        return $candidate ?: $package->load('attachments');
    }

    public function showCV(Package $package)
    {
        $now = Carbon::now('Africa/Addis_Ababa')->format('l, F d, Y h:i A');
        $candidate = $this->resolveCandidateFromPackage($package);

        return view('package.cv', ['candidate' => $candidate, 'now' => $now]);
    }

    public function downloadCV(Package $package)
    {
        $candidate = $this->resolveCandidateFromPackage($package);

        $serverName = $_SERVER['SERVER_NAME'] ?? 'default.domain.com';
        $subdomain = explode('.', $serverName)[0];
        $headerFileName = strtolower($subdomain) . '_header.jpg';
        $footerFileName = strtolower($subdomain) . '_footer.jpg';
        $headerPath = public_path('assets/img/' . $headerFileName);
        $footerPath = public_path('assets/img/' . $footerFileName);
        $headerUrl = file_exists($headerPath) ? asset('assets/img/' . $headerFileName) : null;
        $footerUrl = file_exists($footerPath) ? asset('assets/img/' . $footerFileName) : null;

        $pdf = PDF::loadView('package.download_cv', ['candidate' => $candidate]);
        $pdf->setOption('enable-local-file-access', true);
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-bottom', 30);
        $pdf->setOption('margin-left', 10);
        $pdf->setOption('margin-right', 10);
        $pdf->setOption('page-size', 'A4');
        $pdf->setOption('encoding', 'UTF-8');

        if ($headerUrl) {
            $headerHtml = '<html><head><style>body { margin: 0; padding: 0; }</style></head><body><img src="' . $headerUrl . '" style="width:100%; height:auto;"></body></html>';
            $headerTempFile = tempnam(sys_get_temp_dir(), 'header_') . '.html';
            file_put_contents($headerTempFile, $headerHtml);
            $pdf->setOption('header-html', $headerTempFile);
            $pdf->setOption('header-spacing', 5);
        }

        if ($footerUrl) {
            $footerHtml = '<html><head><style>body { margin: 0; padding: 0; }</style></head><body><img src="' . $footerUrl . '" style="width:100%; height:auto;"></body></html>';
            $footerTempFile = tempnam(sys_get_temp_dir(), 'footer_') . '.html';
            file_put_contents($footerTempFile, $footerHtml);
            $pdf->setOption('footer-html', $footerTempFile);
            $pdf->setOption('footer-spacing', 5);
        }

        $filename = ($candidate->candidate_name ?? 'Candidate') . '_CV.pdf';

        return response($pdf->inline(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function shareCV(Package $package)
    {
        $candidate = $this->resolveCandidateFromPackage($package);

        $name = $candidate->candidate_name ?? 'Unknown';
        $downloadUrl = route('package.download', ['package' => $package->cn_number_series]);

        $message = "🌸 *{$name}*'s CV 🌸\n\n" .
                   "🔗 {$downloadUrl}\n\n" .
                   "Have a nice day! 🍀";

        return redirect()->away('https://wa.me/?text=' . urlencode($message));
    }

    public function viewCV(Package $package)
    {
        $candidate = $this->resolveCandidateFromPackage($package);

        return view('package.view_cv', ['candidate' => $candidate]);
    }

    public function refundUpdateStatus(Request $request)
    {
        return $this->updateStatusRow(
            $request,
            'refunds',
            ['open','closed','cancelled'],
            fn (string $s) => $this->normSimple($s, ['open','closed','cancelled'])
        );
    }

    public function replacementUpdateStatus(Request $request)
    {
        return $this->updateStatusRow(
            $request,
            'replacements',
            ['open','closed','cancelled'],
            fn (string $s) => $this->normSimple($s, ['open','closed','cancelled'])
        );
    }

    public function salaryUpdateStatus(Request $request)
    {
        return $this->updateStatusRow(
            $request,
            'salaries',
            ['pending','paid','partial_paid','cancelled'],
            fn (string $s) => $this->normSalary($s)
        );
    }

    public function remittanceUpdateStatus(Request $request)
    {
        return $this->updateStatusRow(
            $request,
            'remittances',
            ['pending','paid','partial_paid'],
            fn (string $s) => $this->normRemittance($s)
        );
    }

    private function updateStatusRow(Request $request, string $table, array $allowed, \Closure $normalizer)
    {
        $role = (string) (auth()->user()->role ?? '');
        $allowedRoles = ['Admin','Operations Manager','Managing Director','Accountant','Cashier','Finance Officer'];

        if (!in_array($role, $allowedRoles, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $data = $request->validate([
            'id' => ['required','integer','min:1'],
            'status' => ['required','string','max:30'],
        ]);

        $id = (int) $data['id'];
        $next = (string) $data['status'];
        $next = $normalizer($next);

        if (!in_array($next, $allowed, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status value.',
                'allowed' => $allowed
            ], 422);
        }

        $row = DB::table($table)->where('id', $id)->first();

        if (!$row) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found.'
            ], 404);
        }

        $current = isset($row->status) ? strtolower(trim((string) $row->status)) : '';
        $current = $normalizer($current ?: $next);

        if ($current === $next) {
            return response()->json([
                'success' => true,
                'status' => $next,
                'message' => 'Status is already up to date.'
            ]);
        }

        $payload = ['status' => $next];

        if (Schema::hasColumn($table, 'updated_at')) {
            $payload['updated_at'] = now();
        }

        $updatedBy = (string) (auth()->user()->name ?? auth()->user()->full_name ?? auth()->user()->username ?? '');
        $updatedBy = trim($updatedBy);

        if ($updatedBy !== '' && Schema::hasColumn($table, 'updated_by_sales_name')) {
            $payload['updated_by_sales_name'] = $updatedBy;
        }

        if ($updatedBy !== '' && Schema::hasColumn($table, 'updated_by')) {
            $payload['updated_by'] = $updatedBy;
        }

        DB::table($table)->where('id', $id)->update($payload);

        return response()->json([
            'success' => true,
            'status' => $next,
            'message' => 'Status updated successfully.'
        ]);
    }

    private function normSimple(string $v, array $fallbackAllowed): string
    {
        $v = strtolower(trim($v));
        $v = $v === 'canceled' ? 'cancelled' : $v;
        if ($v === '') $v = $fallbackAllowed[0] ?? 'open';
        return $v;
    }

    private function normRemittance(string $v): string
    {
        $v = strtolower(trim($v));
        $v = str_replace(['-', '  '], ['_', ' '], $v);
        $v = $v === 'partial paid' ? 'partial_paid' : $v;
        $v = $v === 'partialpaid' ? 'partial_paid' : $v;
        if ($v === '') $v = 'pending';
        return $v;
    }

    private function normSalary(string $v): string
    {
        $v = strtolower(trim($v));
        $v = $v === 'canceled' ? 'cancelled' : $v;
        $v = str_replace(['-', '  '], ['_', ' '], $v);
        $v = $v === 'partial paid' ? 'partial_paid' : $v;
        $v = $v === 'partialpaid' ? 'partial_paid' : $v;
        if ($v === '') $v = 'pending';
        return $v;
    }

    public function convertOfficeToContract(Request $request)
    {
        $data = $request->validate([
            'passport_no' => ['required','string','max:50'],
        ]);

        $passportNo = strtoupper(trim($data['passport_no']));

        $package = Package::query()
            ->whereRaw('UPPER(TRIM(passport_no)) = ?', [$passportNo])
            ->latest('id')
            ->first();

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'No package found for this passport number.',
            ], 404);
        }

        $office = Office::query()
            ->where('candidate_id', $package->id)
            ->where('type', 'package')
            ->latest('id')
            ->first();

        $currentStatusText = $this->resolveOfficeStatusText($package, $office);

        $agreement = Agreement::query()
            ->whereRaw('UPPER(TRIM(passport_no)) = ?', [$passportNo])
            ->whereNotNull('client_id')
            ->latest('created_at')
            ->first();

        if (!$agreement) {
            return response()->json([
                'success' => false,
                'message' => 'No agreement found for this passport number.',
            ], 404);
        }

        $pendingStatuses = ['Pending', 'Unpaid', 'Partially Paid', 'Overdue', 'Hold'];

        $invoices = DB::table('invoices')
            ->where('agreement_reference_no', $agreement->reference_no)
            ->whereIn('status', $pendingStatuses)
            ->orderByDesc('invoice_id')
            ->get()
            ->map(function ($r) {
                $total = (float)($r->total_amount ?? 0);
                $paid = (float)($r->received_amount ?? 0);
                $remaining = max(0, $total - $paid);

                return [
                    'invoice_no'        => $r->invoice_no ?? $r->invoice_id ?? null,
                    'date'              => $r->invoice_date ?? $r->date ?? null,
                    'total_amount'      => $total,
                    'paid_amount'       => $paid,
                    'remaining_amount'  => $remaining,
                    'status'            => $r->status ?? null,
                ];
            })
            ->values();

        $outstandingTotal = (float) $invoices->sum('remaining_amount');

        return response()->json([
            'success' => true,
            'data' => [
                'candidate' => [
                    'candidate_id'        => $package->id,
                    'cn_number'           => $package->CN_Number ?? $package->cn_number ?? $package->cn_number_series ?? null,
                    'candidate_name'      => $package->candidate_name ?? null,
                    'passport_no'         => $package->passport_no ?? null,
                    'current_status_text' => $currentStatusText,
                ],
                'agreement' => [
                    'reference_no'   => $agreement->reference_no,
                    'client_id'      => $agreement->client_id,
                    'agreement_type' => $agreement->agreement_type,
                ],
                'invoices' => $invoices,
                'outstanding_total' => $outstandingTotal,
            ],
        ], 200);
    }

    private function resolveOfficeStatusText($package, $office): string
    {
        $raw = $package->_status ?? $package->current_status ?? ($office->current_status ?? $office->status ?? null);

        if (is_numeric($raw)) {
            $map = [
                0 => 'Change Status',
                1 => 'Arrived',
                2 => 'Trial',
                5 => 'Incident',
                6 => 'Contracted',
            ];
            return $map[(int)$raw] ?? 'Unknown';
        }

        $t = strtolower(trim((string)$raw));
        return $t !== '' ? ucfirst($t) : 'Unknown';
    }

    private function generatePrefixedRef(string $table, string $column, string $prefix, int $pad = 6): string
    {
        $last = DB::table($table)
            ->whereNotNull($column)
            ->where($column, 'like', $prefix.'%')
            ->orderByDesc($column)
            ->value($column);

        if (!$last) {
            return $prefix . str_pad('1', $pad, '0', STR_PAD_LEFT);
        }

        $number = (int) preg_replace('/\D/', '', (string) $last);
        return $prefix . str_pad((string) ($number + 1), $pad, '0', STR_PAD_LEFT);
    }

    private function latestAgreementForPackage(Package $package): ?Agreement
    {
        $passport = strtoupper(trim((string) ($package->passport_no ?? '')));
        if ($passport === '') {
            return Agreement::query()
                ->where('candidate_id', $package->id)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->first();
        }

        $q = Agreement::query()->whereIn('agreement_type', ['BIA', 'BOA']);
        $cols = ['passport_no', 'passsport_no', 'passport_number', 'passport'];

        $has = false;
        foreach ($cols as $col) {
            if (Schema::hasColumn('agreements', $col)) {
                $has = true;
                $q->orWhereRaw("TRIM(UPPER({$col})) = ?", [$passport]);
            }
        }

        if (!$has) {
            $q->where('candidate_id', $package->id);
        }

        return $q->orderByDesc('created_at')->orderByDesc('id')->first();
    }

    private function upsertRefundOrReplacement(array $payload, string $decision)
    {
        if ($decision === 'Refund') {
            return Refund::create($payload);
        }
        return Replacement::create($payload);
    }

    public function convertOfficeToContractSave(Request $request)
    {
        $tz = 'Asia/Dubai';

        $validator = Validator::make($request->all(), [
            'passport_no'    => 'required|string|max:50',
            'payment_method' => 'required|string|max:50',
            'pay_amount'     => 'required|numeric|min:0',
            'comments'       => 'nullable|string|max:2000',
            'payment_proof'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5000',
        ]);

        $validator->sometimes('payment_proof', 'required', function ($in) {
            $pay = (float) ($in->pay_amount ?? 0);
            $method = strtolower(trim((string) ($in->payment_method ?? '')));
            return $pay > 0 && $method !== 'cash';
        });

        $v = $validator->validate();

        $passportNo = strtoupper(trim((string) $v['passport_no']));
        $payAmount = (float) $v['pay_amount'];
        $paymentMethod = trim((string) $v['payment_method']);

        $filePath = $request->file('payment_proof')
            ? $request->file('payment_proof')->store('payment_proofs', 'public')
            : '';

        try {
            $data = DB::transaction(function () use ($tz, $passportNo, $payAmount, $paymentMethod, $filePath, $v) {

                $package = Package::query()
                    ->lockForUpdate()
                    ->whereRaw('UPPER(TRIM(passport_no)) = ?', [$passportNo])
                    ->orderByDesc('id')
                    ->firstOrFail();

                $candidate = NewCandidate::query()
                    ->lockForUpdate()
                    ->whereRaw('UPPER(TRIM(passport_no)) = ?', [$passportNo])
                    ->orderByDesc('id')
                    ->firstOrFail();

                $agreement = Agreement::query()
                    ->lockForUpdate()
                    ->where(function ($q) use ($passportNo, $candidate, $package) {
                        $q->whereRaw('UPPER(TRIM(passport_no)) = ?', [$passportNo]);

                        $cn = strtoupper(trim((string) ($candidate->CN_Number ?? $package->CN_Number ?? '')));
                        $cl = strtoupper(trim((string) ($candidate->CL_Number ?? $package->CL_Number ?? '')));
                        $ref = strtoupper(trim((string) ($candidate->reference_no ?? $package->reference_no ?? '')));

                        if ($cn !== '') $q->orWhereRaw('UPPER(TRIM(CN_Number)) = ?', [$cn]);
                        if ($cl !== '') $q->orWhereRaw('UPPER(TRIM(CL_Number)) = ?', [$cl]);
                        if ($ref !== '') $q->orWhereRaw('UPPER(TRIM(reference_no)) = ?', [$ref]);
                    })
                    ->orderByDesc('id')
                    ->firstOrFail();

                $clientId = (int) ($agreement->client_id ?? 0);

                $customer = $clientId > 0
                    ? CRM::query()->select('id', 'first_name', 'last_name')->where('id', $clientId)->first()
                    : null;

                $employerName = trim(implode(' ', array_filter([
                    $customer->first_name ?? '',
                    $customer->last_name ?? '',
                ])));

                $taxInvoice = Invoice::query()
                    ->lockForUpdate()
                    ->where('agreement_reference_no', $agreement->reference_no)
                    ->where('invoice_type', 'Tax')
                    ->orderByDesc('invoice_id')
                    ->first();

                $createdFromProforma = false;

                if (!$taxInvoice) {
                    $proforma = Invoice::query()
                        ->lockForUpdate()
                        ->where('agreement_reference_no', $agreement->reference_no)
                        ->where('invoice_type', 'Proforma')
                        ->orderByDesc('invoice_id')
                        ->firstOrFail();

                    $now = Carbon::now($tz);
                    $invoiceDate = $now->toDateString();

                    $prefix = 'INV-P1-';

                    $last = Invoice::query()
                        ->lockForUpdate()
                        ->where('invoice_number', 'like', $prefix . '%')
                        ->orderByDesc('invoice_id')
                        ->value('invoice_number');

                    $seq = 0;
                    if ($last) {
                        $last = strtoupper(trim((string) $last));
                        if (preg_match('/^' . preg_quote($prefix, '/') . '(\d+)$/', $last, $m)) {
                            $seq = (int) ltrim($m[1], '0');
                        }
                    }

                    $invoiceNumber = '';
                    for ($i = 0; $i < 500; $i++) {
                        $seq++;
                        $candidateNo = $prefix . str_pad((string) $seq, 5, '0', STR_PAD_LEFT);
                        if (!Invoice::query()->where('invoice_number', $candidateNo)->exists()) {
                            $invoiceNumber = $candidateNo;
                            break;
                        }
                    }

                    if ($invoiceNumber === '') {
                        throw new \RuntimeException('Unable to generate unique invoice number.');
                    }

                    $total = (float) ($proforma->total_amount ?? 0);
                    $received = (float) ($proforma->received_amount ?? 0);
                    if ($received > $total) $received = $total;

                    $discount = (float) ($proforma->discount_amount ?? 0);
                    $taxAmt = (float) ($proforma->tax_amount ?? 0);

                    $balance = max($total - $received, 0);

                    $taxInvoice = Invoice::create([
                        'invoice_number'         => $invoiceNumber,
                        'agreement_reference_no' => $agreement->reference_no,
                        'customer_id'            => $clientId > 0 ? $clientId : null,
                        'CL_Number'              => $candidate->CL_Number ?? $agreement->CL_Number ?? null,
                        'CN_Number'              => $candidate->CN_Number ?? $agreement->CN_Number ?? null,
                        'reference_no'           => $candidate->reference_no ?? $agreement->reference_no ?? null,
                        'invoice_type'           => 'Tax',
                        'payment_method'         => $paymentMethod,
                        'invoice_date'           => $invoiceDate,
                        'due_date'               => $invoiceDate,
                        'total_amount'           => $total,
                        'received_amount'        => $received,
                        'discount_amount'        => $discount,
                        'tax_amount'             => $taxAmt,
                        'balance_due'            => $balance,
                        'status'                 => 'Pending',
                        'notes'                  => $proforma->notes ?? null,
                        'payment_proof'          => null,
                        'upcoming_payment_date'  => null,
                        'created_by'             => Auth::id(),
                    ]);

                    $items = InvoiceItem::query()->where('invoice_id', $proforma->invoice_id)->get();

                    foreach ($items as $it) {
                        InvoiceItem::create([
                            'invoice_id'   => $taxInvoice->invoice_id,
                            'product_name' => $it->product_name ?? null,
                            'quantity'     => (float) ($it->quantity ?? 1),
                            'unit_price'   => (float) ($it->unit_price ?? 0),
                            'total_price'  => (float) ($it->total_price ?? 0),
                        ]);
                    }

                    $createdFromProforma = true;
                }

                $taxInvoice->refresh();

                $total = (float) ($taxInvoice->total_amount ?? 0);
                $receivedBefore = (float) ($taxInvoice->received_amount ?? 0);
                if ($receivedBefore > $total) $receivedBefore = $total;

                $receivedAfter = $receivedBefore;
                if ($payAmount > 0) $receivedAfter = min($total, max($receivedBefore + $payAmount, 0));
                if (abs($total - $receivedAfter) < 0.0001) $receivedAfter = $total;

                $balance = max($total - $receivedAfter, 0);

                $taxInvoice->update([
                    'payment_method'  => $paymentMethod,
                    'received_amount' => $receivedAfter,
                    'balance_due'     => $balance,
                    'status'          => 'Pending',
                    'payment_proof'   => $filePath !== '' ? $filePath : ($taxInvoice->payment_proof ?? null),
                ]);

                if ($filePath !== '') {
                    PaymentProof::updateOrCreate(
                        ['candidate_id' => $candidate->id, 'invoice_id' => $taxInvoice->invoice_id],
                        [
                            'client_name'        => $employerName !== '' ? $employerName : 'CLIENT',
                            'invoice_amount'     => $total,
                            'received_amount'    => $receivedAfter,
                            'payment_method'     => $paymentMethod,
                            'payment_proof_path' => $filePath,
                            'created_by'         => Auth::id(),
                        ]
                    );
                }

                $today = Carbon::now($tz)->toDateString();

                $candidate->update([
                    'current_status'       => 17,
                    'transfer_date'        => $today,
                    'transfer_added_date'  => now($tz),
                    'transfer_date_remark' => $v['comments'] ?? null,
                ]);

                $package->update([
                    'inside_status'  => 6,
                    'current_status' => 17,
                ]);

                Package::where('candidate_id', $candidate->id)->update([
                    'inside_status'  => 6,
                    'current_status' => 17,
                ]);

                \App\Models\Office::query()
                    ->where('candidate_id', $package->id)
                    ->where('type', 'package')
                    ->update(['status' => 0]);

                $remoteDb = $this->getForeignDatabaseName($candidate->foreign_partner);

                DB::connection($remoteDb)->table('candidates')
                    ->where('ref_no', $candidate->ref_no)
                    ->update([
                        'transfer_date'       => $today,
                        'transfer_added_date' => now('Africa/Addis_Ababa'),
                        'current_status'      => 17,
                    ]);

                foreach (['sales', 'coordinator'] as $role) {
                    $this->add_notification([
                        'role'         => $role,
                        'user_id'      => $candidate->sales_name,
                        'reference_no' => $candidate->reference_no,
                        'ref_no'       => $candidate->ref_no,
                        'title'        => 'Transfer of ' . $candidate->CN_Number,
                        'message'      => 'Transfer of ' . $candidate->CN_Number . ' to ' . ($employerName !== '' ? $employerName : 'CLIENT') . ' on ' . $today,
                        'CL_Number'    => $candidate->CL_Number,
                        'CN_Number'    => $candidate->CN_Number,
                        'status'       => 'Un Read',
                        'filePath'     => $filePath,
                        'created_at'   => now($tz),
                    ]);
                }

                return [
                    'passport_no'            => $passportNo,
                    'candidate_id'           => (int) $candidate->id,
                    'package_id'             => (int) $package->id,
                    'agreement_reference_no' => (string) $agreement->reference_no,
                    'invoice_id'             => (int) $taxInvoice->invoice_id,
                    'invoice_number'         => (string) ($taxInvoice->invoice_number ?? ''),
                    'invoice_type'           => 'Tax',
                    'created_from_proforma'  => (bool) $createdFromProforma,
                    'total_amount'           => (float) $total,
                    'received_amount'        => (float) $receivedAfter,
                    'balance_due'            => (float) $balance,
                    'status'                 => 'Pending',
                    'transfer_date'          => (string) $today,
                    'payment_proof'          => (string) ($filePath !== '' ? $filePath : ($taxInvoice->payment_proof ?? '')),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Converted to Contract and invoice updated.',
                'data'    => $data,
            ], 200);

        } catch (\Throwable $e) {
            if ($filePath !== '' && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    protected function getForeignDatabaseName($foreignPartner)
    {
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
            case 'estella':       return 'estella_new';
            case 'ritemerit':     return 'ritemeritonesour_new';
            case 'khalid':        return 'khalidonesourcee_new';
            default:              return '';
        }
    }

    protected function add_notification(array $notificationData)
    {
        Notification::create([
            'role' => $notificationData['role'],
            'user_id' => $notificationData['user_id'],
            'reference_no' => $notificationData['reference_no'],
            'ref_no' => $notificationData['ref_no'],
            'title' => $notificationData['title'],
            'message' => $notificationData['message'],
            'CL_Number' => $notificationData['CL_Number'],
            'CN_Number' => $notificationData['CN_Number'],
            'status' => $notificationData['status'],
            'filePath' => $notificationData['filePath'],
            'created_at' => $notificationData['created_at'],
        ]);
    }


}
