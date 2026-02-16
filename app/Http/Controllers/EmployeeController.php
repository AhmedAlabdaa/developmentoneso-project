<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContractsExport;
use App\Exports\EmployeesExport;
use App\Exports\InvoicesExport;
use App\Exports\OfficeEmployeesExport;
use App\Exports\ReceiptsExport;
use App\Exports\RefundsExport;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\AccountInvoiceController;
use App\Services\ZohoItemService;
use App\Models\Agreement;
use App\Models\AppliedPosition;
use App\Models\ReplacementHistory;
use App\Models\CRM;
use App\Models\CocStatus;
use App\Models\Contract;
use App\Models\Office;
use App\Models\CurrentStatus;
use App\Models\DesiredCountry;
use App\Models\EducationLevel;
use App\Models\Employee;
use App\Models\EmployeeAttachment;
use App\Models\FraName;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Installment;
use App\Models\InstallmentItem;
use App\Models\MaritalStatus;
use App\Models\MedicalStatus;
use App\Models\Nationality;
use App\Models\NewCandidate;
use App\Models\Notification;
use App\Models\PaymentProof;
use App\Models\Staff;
use App\Models\Trial;
use App\Models\Payroll;
use App\Models\Package;
use App\Models\CandidateAttachment;
use App\Models\EmployeeVisaStage;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Throwable;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $package = $request->input('package', 'all');
        $filterString = $request->input('filters');
        $filterData = [];
        if (!empty($filterString)) {
            parse_str($filterString, $filterData);
        }
        $query = Employee::query();
        if ($package !== 'all') {
            $query->where('package', $package);
        }
        if ($request->filled('global_search')) {
            $searchTerm = $request->input('global_search');
            $query->where(function ($sub) use ($searchTerm) {
                $sub->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('passport_no', 'like', '%' . $searchTerm . '%');
            });
        }
        if (!empty($filterData['reference_no'])) {
            $query->where('reference_no', 'like', '%' . $filterData['reference_no'] . '%');
        }
        if (!empty($filterData['name'])) {
            $query->where('name', 'like', '%' . $filterData['name'] . '%');
        }
        if (!empty($filterData['passport_no'])) {
            $query->where('passport_no', 'like', '%' . $filterData['passport_no'] . '%');
        }
        if (!empty($filterData['nationality'])) {
            $query->where('nationality', 'like', '%' . $filterData['nationality'] . '%');
        }
        if (!empty($filterData['visa_designation'])) {
            $query->where('visa_designation', 'like', '%' . $filterData['visa_designation'] . '%');
        }
        if (!empty($filterData['date_of_joining'])) {
            $query->whereDate('date_of_joining', Carbon::parse($filterData['date_of_joining'])->format('Y-m-d'));
        }
        if (!empty($filterData['employment_contract_start_date'])) {
            $query->whereDate('employment_contract_start_date', Carbon::parse($filterData['employment_contract_start_date'])->format('Y-m-d'));
        }
        if (!empty($filterData['contract_type'])) {
            $query->where('contract_type', 'like', '%' . $filterData['contract_type'] . '%');
        }
        $employees = $query->orderBy('reference_no', 'asc')->paginate(10);
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $nationalities = Nationality::all();
        $appliedPositions = AppliedPosition::all();
        $educationLevels = EducationLevel::all();
        $maritalStatuses = MaritalStatus::all();
        $desiredCountries = DesiredCountry::all();
        $fraNames = FraName::all();
        $medicalStatuses = MedicalStatus::all();
        $cocStatuses = CocStatus::all();
        $currentStatuses = CurrentStatus::all();
        $steps = DB::table('process_flow_steps')
            ->select('id', 'title')
            ->orderBy('step_no')
            ->get();
        if ($request->ajax()) {
            return view('employee.partials.employee_table', compact(
                'employees',
                'now',
                'nationalities',
                'appliedPositions',
                'educationLevels',
                'maritalStatuses',
                'desiredCountries',
                'fraNames',
                'medicalStatuses',
                'cocStatuses',
                'currentStatuses',
                'steps'
            ));
        }
        return view('employee.index', compact(
            'employees',
            'now',
            'nationalities',
            'appliedPositions',
            'educationLevels',
            'maritalStatuses',
            'desiredCountries',
            'fraNames',
            'medicalStatuses',
            'cocStatuses',
            'currentStatuses',
            'steps'
        ));
    }

    public function employee_visa_tracker(Request $request)
    {
        $filterString = $request->input('filters');
        $filterData = [];
        if (!empty($filterString)) {
            parse_str($filterString, $filterData);
        }

        $query = Employee::orderBy('reference_no', 'asc');

        if ($request->filled('global_search')) {
            $search = $request->input('global_search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('passport_no', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('package') && $request->input('package') !== 'all') {
            $query->where('package', $request->input('package'));
        }

        if ($request->filled('visa_status') && $request->input('visa_status') !== 'new') {
            $query->where('visa_status', $request->input('visa_status'));
        }

        if (!empty($filterData['reference_no'])) {
            $query->where('reference_no', 'like', $filterData['reference_no'] . '%');
        }
        if (!empty($filterData['name'])) {
            $query->where('name', 'like', $filterData['name'] . '%');
        }
        if (!empty($filterData['passport_no'])) {
            $query->where('passport_no', 'like', $filterData['passport_no'] . '%');
        }
        if (!empty($filterData['nationality'])) {
            $query->where('nationality', 'like', $filterData['nationality'] . '%');
        }
        if (!empty($filterData['visa_designation'])) {
            $query->where('visa_designation', 'like', $filterData['visa_designation'] . '%');
        }
        if (!empty($filterData['date_of_joining'])) {
            $query->whereDate('date_of_joining', Carbon::parse($filterData['date_of_joining'])->format('Y-m-d'));
        }
        if (!empty($filterData['employment_contract_start_date'])) {
            $query->whereDate('employment_contract_start_date', Carbon::parse($filterData['employment_contract_start_date'])->format('Y-m-d'));
        }
        if (!empty($filterData['contract_type'])) {
            $query->where('contract_type', 'like', $filterData['contract_type'] . '%');
        }
        if (!empty($filterData['emirates_id'])) {
            $query->where('emirates_id', 'like', $filterData['emirates_id'] . '%');
        }

        $employees = $query->paginate(10);
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $nationalities = Nationality::all();
        $appliedPositions = AppliedPosition::all();
        $educationLevels = EducationLevel::all();
        $maritalStatuses = MaritalStatus::all();
        $desiredCountries = DesiredCountry::all();
        $fraNames = FraName::all();
        $medicalStatuses = MedicalStatus::all();
        $cocStatuses = CocStatus::all();
        $currentStatuses = CurrentStatus::all();
        $visaStatus = DB::table('visa_tracker_statuses')->get();

        if ($request->ajax()) {
            return view('employee.partials.employee_visa_tracker_table', compact(
                'employees',
                'now',
                'nationalities',
                'appliedPositions',
                'educationLevels',
                'maritalStatuses',
                'desiredCountries',
                'fraNames',
                'medicalStatuses',
                'cocStatuses',
                'currentStatuses',
                'visaStatus'
            ));
        }

        return view('employee.employee_visa_tracker', compact(
            'employees',
            'now',
            'nationalities',
            'appliedPositions',
            'educationLevels',
            'maritalStatuses',
            'desiredCountries',
            'fraNames',
            'medicalStatuses',
            'cocStatuses',
            'currentStatuses',
            'visaStatus'
        ));
    }
    public function create()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('employee.create', ['now' => $now]);
    }

    public function store(Request $request)
    {
        $rules = [
            'package'             => 'required|string|max:255',
            'name'                => 'required|string|max:255',
            'nationality'         => 'required|string|max:100',
            'passport_no'         => 'required|string|max:50|unique:employees,passport_no',
            'passport_expiry_date'=> 'nullable|date',
            'date_of_birth'       => 'nullable|date',
            'passport_issue_date' => 'nullable|date',
            'foreign_partner'     => 'nullable|string|max:255',
            'relgion'             => 'nullable|string|max:100',
            'place_of_birth'      => 'nullable|string|max:255',
            'living_town'         => 'nullable|string|max:255',
            'marital_status'      => 'nullable|string|max:50',
            'no_of_childrens'     => 'nullable|integer|min:0',
            'weight'              => 'nullable|numeric|min:0',
            'height'              => 'nullable|numeric|min:0',
            'education'           => 'nullable|string|max:255',
            'languages'           => 'nullable|string|max:255',
            'working_expierience' => 'nullable|string|max:255',
            'place_of_issues'     => 'nullable|string|max:255',
        ];

        $messages = [
            'package.required'     => 'Package is required.',
            'name.required'        => 'Name is required.',
            'nationality.required' => 'Nationality is required.',
            'passport_no.required' => 'Passport number is required.',
            'passport_no.unique'   => 'This passport number is already in use.',
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

        $validatedData['reference_no']             = $this->generateReferenceNo();
        $validatedData['CN_Number']                = $this->generateCNNumber();
        $validatedData['current_status']           = 17;
        $validatedData['status']                   = 1;
        $validatedData['inside_country_or_outside']= 2;
        $validatedData['inside_status']            = 0;
        $validatedData['slug']                     = Str::slug($validatedData['name'] . '-' . $validatedData['CN_Number']);

        DB::beginTransaction();

        try {
            Employee::create($validatedData);

            DB::commit();
            return redirect()
                ->route('employees.index')
                ->with('success', 'Employee created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating employee', ['error' => $e->getMessage()]);

            return back()
                ->withErrors(['error' => 'Failed to create employee: ' . $e->getMessage()])
                ->withInput();
        }
    }

    private function sanitizeDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (Exception $e) {
            return null;
        }
    }

    private function generateReferenceNo(): string
    {
        $last = Employee::whereNotNull('reference_no')
            ->where('reference_no', 'like', 'EM-%')
            ->orderByDesc('reference_no')
            ->value('reference_no');

        if (!$last) {
            return 'EM-' . str_pad('1', 4, '0', STR_PAD_LEFT);
        }

        $number = (int) preg_replace('/\D/', '', $last);

        return 'EM-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
    }

    private function generateCNNumber(): string
    {
        $last = Employee::whereNotNull('CN_Number')
            ->where('CN_Number', 'like', 'CN-%')
            ->orderByDesc('CN_Number')
            ->value('CN_Number');

        if (!$last) {
            return 'CN-' . str_pad('1', 4, '0', STR_PAD_LEFT);
        }

        $number = (int) preg_replace('/\D/', '', $last);

        return 'CN-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
    }

    public function show(string $reference_no)
    {
        $reference_no = trim($reference_no);

        $employee = Employee::where('reference_no', $reference_no)->first();
        if (!$employee) {
            abort(404, 'Employee not found');
        }

        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        $visaStages = EmployeeVisaStage::where('employee_id', (int) $employee->id)
            ->orderBy('step_id')
            ->orderBy('id')
            ->get();

        return view('employee.show', compact('employee', 'now', 'visaStages'));
    }


    public function edit(Employee $employee)
    {
        $now = now('Asia/Dubai')->format('l, F d, Y h:i A');

        $attachments = EmployeeAttachment::where('employee_id', $employee->id)
            ->orderBy('id')
            ->get();

        $steps = DB::table('process_flow_steps')
            ->select('id', 'title')
            ->orderBy('step_no')
            ->get();

        $visaStages = EmployeeVisaStage::where('employee_id', $employee->id)
            ->orderBy('step_id')
            ->get();

        $additionalFiles = DB::table('employees_additional_files')
            ->where('employee_id', $employee->id)
            ->orderBy('visa_stage_id')
            ->orderBy('id')
            ->get();

        $additionalFilesByStage = $additionalFiles->groupBy('visa_stage_id');
        $additionalFilesByStep  = $additionalFiles->groupBy('step_id');

        $visaStages = $visaStages->map(function($stage) use ($additionalFilesByStage) {
            $combined = [];
            $raw = $stage->fin_extra_files;

            if (is_array($raw)) {
                foreach ($raw as $item) {
                    if (is_array($item)) {
                        $p = $item['path'] ?? $item['file_path'] ?? $item['url'] ?? $item['storage_path'] ?? null;
                        $n = $item['name'] ?? $item['file_name'] ?? ($p ? basename($p) : 'File');
                    } else {
                        $p = $item;
                        $n = basename((string) $p);
                    }
                    if ($p) $combined[] = ['path' => $p, 'name' => $n];
                }
            } elseif (is_string($raw)) {
                $trim = trim($raw);
                if (\Illuminate\Support\Str::startsWith($trim, ['[', '{'])) {
                    $decoded = json_decode($trim, true);
                    if (is_array($decoded)) {
                        foreach ($decoded as $item) {
                            if (is_array($item)) {
                                $p = $item['path'] ?? $item['file_path'] ?? $item['url'] ?? $item['storage_path'] ?? null;
                                $n = $item['name'] ?? $item['file_name'] ?? ($p ? basename($p) : 'File');
                            } else {
                                $p = $item;
                                $n = basename((string) $p);
                            }
                            if ($p) $combined[] = ['path' => $p, 'name' => $n];
                        }
                    } elseif ($trim !== '') {
                        $combined[] = ['path' => $trim, 'name' => basename($trim)];
                    }
                } elseif ($trim !== '') {
                    $combined[] = ['path' => $trim, 'name' => basename($trim)];
                }
            }

            $rows = $additionalFilesByStage->get($stage->id, collect());
            foreach ($rows as $r) {
                $p = $r->path ?? $r->file_path ?? $r->url ?? $r->storage_path ?? null;
                $n = $r->name ?? $r->file_name ?? ($p ? basename($p) : 'File');
                if ($p) $combined[] = ['path' => $p, 'name' => $n];
            }

            $stage->fin_extra_files = $combined;
            $stage->has_extra_files = count($combined) > 0;

            return $stage;
        });

        return view('employee.edit', [
            'employee'               => $employee,
            'now'                    => $now,
            'attachments'            => $attachments,
            'steps'                  => $steps,
            'visaStages'             => $visaStages,
            'additionalFiles'        => $additionalFiles,
            'additionalFilesByStage' => $additionalFilesByStage,
            'additionalFilesByStep'  => $additionalFilesByStep,
        ]);
    }

    public function update(Request $request, string $reference_no)
    {
        $employee = Employee::where('reference_no', $reference_no)->firstOrFail();

        $fmt = 'Y-m-d';

        $normalizeDate = static function ($value) use ($fmt) {
            if ($value === null) return null;

            $value = trim((string) $value);
            if ($value === '') return null;

            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) return $value;

            $candidates = [
                'd/m/Y', 'd-m-Y', 'm/d/Y', 'm-d/Y',
                'Y/m/d', 'd.m.Y', 'Y.m.d',
                'M d, Y', 'd M Y', 'Ymd',
            ];

            foreach ($candidates as $f) {
                try {
                    return \Carbon\Carbon::createFromFormat($f, $value)->format($fmt);
                } catch (\Throwable $e) {
                }
            }

            try {
                return \Carbon\Carbon::parse($value)->format($fmt);
            } catch (\Throwable $e) {
            }

            return $value;
        };

        $normalizeScalarKeys = static function (array $keys) use ($request, $normalizeDate) {
            $out = [];
            foreach ($keys as $k) {
                if ($request->has($k)) {
                    $out[$k] = $normalizeDate($request->input($k));
                }
            }
            return $out;
        };

        $normalizeAssoc = static function (string $key) use ($request, $normalizeDate) {
            $arr = $request->input($key, []);
            if (!is_array($arr)) return [$key => []];

            $res = [];
            foreach ($arr as $id => $v) {
                $res[$id] = $normalizeDate($v);
            }
            return [$key => $res];
        };

        $normalizeIndexed = static function (string $key) use ($request, $normalizeDate) {
            $arr = $request->input($key, []);
            if (!is_array($arr)) return [$key => []];

            $res = [];
            foreach ($arr as $i => $v) {
                $res[$i] = $normalizeDate($v);
            }
            return [$key => $res];
        };

        $singleRequired = ['passport_expiry_date', 'date_of_birth'];

        $singleNullable = [
            'date_of_joining',
            'employment_contract_start_date', 'employment_contract_end_date',
            'file_entry_permit_issued_date', 'file_entry_permit_expired_date',
            'eid_issued_date', 'eid_expiry_date',
            'labor_card_issued_date', 'labor_card_expiry_date',
            'iloe_issued_date', 'iloe_expired_date',
            'residence_visa_start_date', 'residence_visa_expiry_date',
            'insurance_policy_issued_date', 'insurance_policy_expired_date',
            'incident_date',
            'arrival_date', 'arrival_expiry_date',
        ];

        $merge = [];
        $merge += $normalizeScalarKeys($singleRequired);
        $merge += $normalizeScalarKeys($singleNullable);
        $merge += $normalizeAssoc('issued_on_existing');
        $merge += $normalizeAssoc('expired_on_existing');
        $merge += $normalizeIndexed('issued_on_new');
        $merge += $normalizeIndexed('expired_on_new');

        $stagesExisting = $request->input('stages_existing', []);
        $stagesNew = $request->input('stages_new', []);
        $stagesUnified = $request->input('stages', []);

        $stagesExisting = is_array($stagesExisting) ? $stagesExisting : [];
        $stagesNew = is_array($stagesNew) ? $stagesNew : [];
        $stagesUnified = is_array($stagesUnified) ? $stagesUnified : [];

        foreach ($stagesExisting as $id => $s) {
            if (isset($s['hr_issue_date'])) $stagesExisting[$id]['hr_issue_date'] = $normalizeDate($s['hr_issue_date']);
            if (isset($s['hr_expiry_date'])) $stagesExisting[$id]['hr_expiry_date'] = $normalizeDate($s['hr_expiry_date']);
        }

        foreach ($stagesNew as $i => $s) {
            if (isset($s['hr_issue_date'])) $stagesNew[$i]['hr_issue_date'] = $normalizeDate($s['hr_issue_date']);
            if (isset($s['hr_expiry_date'])) $stagesNew[$i]['hr_expiry_date'] = $normalizeDate($s['hr_expiry_date']);
        }

        foreach ($stagesUnified as $i => $s) {
            if (isset($s['hr_issue_date'])) $stagesUnified[$i]['hr_issue_date'] = $normalizeDate($s['hr_issue_date']);
            if (isset($s['hr_expiry_date'])) $stagesUnified[$i]['hr_expiry_date'] = $normalizeDate($s['hr_expiry_date']);
        }

        $request->merge(array_merge($merge, [
            'stages_existing' => $stagesExisting,
            'stages_new' => $stagesNew,
            'stages' => $stagesUnified,
        ]));

        $minDOB = now()->subYears(18)->format($fmt);
        $maxFiles = 10;

        $messages = [
            'incident_type.required_if' => 'Incident Type is required when Inside Status is Incidented.',
            'incident_date.required_if' => 'Incident Date is required when Inside Status is Incidented.',
            'passport_expiry_date.after' => 'Passport Expiry Date must be a future date.',
            'date_of_birth.before' => 'Employee must be at least 18 years old.',
            'arrival_expiry_date.after_or_equal' => 'Arrival Expiry Date must be after or equal to Arrival Date.',
        ];

        $attributes = [
            'inside_status' => 'Inside Status',
            'inside_country_or_outside' => 'Outside Status',
            'incident_type' => 'Incident Type',
            'incident_date' => 'Incident Date',
        ];

        $validator = \Validator::make($request->all(), [
            'reference_no' => 'required|unique:employees,reference_no,' . $employee->id,
            'package' => 'required',
            'name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'passport_no' => 'required|string',
            'passport_expiry_date' => "required|date_format:$fmt|after:today",
            'date_of_joining' => "nullable|date_format:$fmt",
            'date_of_birth' => "required|date_format:$fmt|before:$minDOB",
            'gender' => 'required|in:Male,Female,Other',
            'employment_contract_start_date' => "nullable|date_format:$fmt",
            'employment_contract_end_date' => "nullable|date_format:$fmt|after_or_equal:employment_contract_start_date",
            'file_entry_permit_no' => 'nullable|string',
            'file_entry_permit_issued_date' => "nullable|date_format:$fmt",
            'file_entry_permit_expired_date' => "nullable|date_format:$fmt",
            'emirates_id_number' => 'nullable|string',
            'eid_issued_date' => "nullable|date_format:$fmt",
            'eid_expiry_date' => "nullable|date_format:$fmt",
            'labor_card_no' => 'nullable|string',
            'labor_card_issued_date' => "nullable|date_format:$fmt",
            'labor_card_expiry_date' => "nullable|date_format:$fmt",
            'iloe_number' => 'nullable|string',
            'iloe_issued_date' => "nullable|date_format:$fmt",
            'iloe_expired_date' => "nullable|date_format:$fmt",
            'residence_visa_start_date' => "nullable|date_format:$fmt",
            'residence_visa_expiry_date' => "nullable|date_format:$fmt",
            'insurance_policy_number' => 'nullable|string',
            'insurance_policy_issued_date' => "nullable|date_format:$fmt",
            'insurance_policy_expired_date' => "nullable|date_format:$fmt",
            'visa_designation' => 'nullable|string',
            'contract_type' => 'nullable|in:Permanent,Temporary',
            'personal_no' => 'nullable|string',
            'uid_no' => 'nullable|string',
            'foreign_partner' => 'nullable|string',
            'salary_as_per_contract' => 'nullable|numeric',
            'basic' => 'nullable|numeric',
            'housing' => 'nullable|numeric',
            'transport' => 'nullable|numeric',
            'other_allowances' => 'nullable|numeric',
            'total_salary' => 'nullable|numeric',
            'payment_type' => 'nullable|in:WPS,CASH',
            'bank_name' => 'nullable|string',
            'iban' => 'nullable|string',
            'current_status' => 'nullable|string',
            'visa_status' => 'nullable|numeric',
            'inside_status' => 'required|in:0,1,2,3,4,5,6',
            'inside_country_or_outside' => 'required|in:1,2',
            'incident_type' => 'required_if:inside_status,3|nullable|string',
            'incident_date' => "required_if:inside_status,3|nullable|date_format:$fmt",
            'remarks' => 'nullable|string',
            'comments' => 'nullable|string',

            'delete_attachments' => 'nullable|array',
            'delete_attachments.*' => 'integer|exists:employee_attachments,id',

            'delete_stages' => 'nullable|array',
            'delete_stages.*' => 'integer|exists:employee_visa_stages,id',

            'issued_on_existing' => 'sometimes|array',
            'issued_on_existing.*' => "nullable|date_format:$fmt",
            'expired_on_existing' => 'sometimes|array',
            'expired_on_existing.*' => "nullable|date_format:$fmt",
            'attachment_file_existing' => "sometimes|array|max:$maxFiles",
            'attachment_file_existing.*' => 'file',
            'attachment_type_existing' => 'sometimes|array',
            'attachment_type_existing.*' => 'nullable|string',
            'attachment_number_existing' => 'sometimes|array',
            'attachment_number_existing.*' => 'nullable|string',

            'attachment_file_new' => "sometimes|array|max:$maxFiles",
            'attachment_file_new.*' => 'file',
            'attachment_type_new' => 'sometimes|array',
            'attachment_type_new.*' => 'nullable|string',
            'attachment_number_new' => 'sometimes|array',
            'attachment_number_new.*' => 'nullable|string',
            'issued_on_new' => 'sometimes|array',
            'issued_on_new.*' => "nullable|date_format:$fmt",
            'expired_on_new' => 'sometimes|array',
            'expired_on_new.*' => "nullable|date_format:$fmt",

            'stages_existing' => 'sometimes|array',
            'stages_new' => 'sometimes|array',
            'stages' => 'sometimes|array',

            'stages_existing.*.fin_extra_files' => 'sometimes|array',
            'stages_existing.*.fin_extra_files.*' => 'file',
            'stages_new.*.fin_extra_files' => 'sometimes|array',
            'stages_new.*.fin_extra_files.*' => 'file',

            'religion' => 'nullable|in:Muslim,Christian,Other',
            'marital_status' => 'nullable|integer|in:1,2,3,4',
            'children_count' => 'nullable|integer|min:0',
            'experience_years' => 'nullable|integer|min:0|max:50',

            'arrival_date' => "nullable|date_format:$fmt",
            'arrival_expiry_date' => "nullable|date_format:$fmt|after_or_equal:arrival_date",
            'arrival_ticket_attachment' => 'nullable|file',
            'arrival_entry_stamp_attachment' => 'nullable|file',
            'arrival_icp_proof_attachment' => 'nullable|file',
        ], $messages, $attributes);

        $validator->after(function ($v) use ($request, $employee) {
            $toDelete = collect($request->input('delete_stages', []))->map(fn ($x) => (int) $x)->all();

            $existing = EmployeeVisaStage::where('employee_id', $employee->id)->get()->keyBy('id');
            $keptExisting = $existing->reject(fn ($row) => in_array((int) $row->id, $toDelete, true));

            $updates = $request->input('stages_existing', []);
            $updates = is_array($updates) ? $updates : [];

            foreach ($updates as $id => $payload) {
                $id = (int) $id;

                if (!$existing->has($id)) {
                    $v->errors()->add("stages_existing.$id", 'Invalid stage row.');
                    continue;
                }

                $row = $existing->get($id);

                if (isset($payload['step_id']) && (int) $payload['step_id'] !== (int) $row->step_id) {
                    $v->errors()->add("stages_existing.$id.step_id", 'Cannot change stage number for an existing row.');
                }

                if (empty($payload['hr_issue_date'])) {
                    $v->errors()->add("stages_existing.$id.hr_issue_date", 'HR issue date is required.');
                }

                if (empty($payload['hr_expiry_date'])) {
                    $v->errors()->add("stages_existing.$id.hr_expiry_date", 'HR expiry date is required.');
                }
            }

            $newBlocks = $request->input('stages_new', []);
            $fallbackBlocks = $request->input('stages', []);

            $newInput = [];
            if (is_array($newBlocks) && count($newBlocks)) {
                $newInput = array_values($newBlocks);
            } elseif (is_array($fallbackBlocks) && count($fallbackBlocks)) {
                $newInput = array_values($fallbackBlocks);
            }

            foreach ($newInput as $i => $s) {
                $sid = (int) ($s['stage_id'] ?? $s['step_id'] ?? 0);

                if ($sid <= 0) $v->errors()->add("stages_new.$i.step_id", 'Stage is required.');
                if (empty($s['hr_issue_date'])) $v->errors()->add("stages_new.$i.hr_issue_date", 'HR issue date is required.');
                if (empty($s['hr_expiry_date'])) $v->errors()->add("stages_new.$i.hr_expiry_date", 'HR expiry date is required.');
            }

            $used = [];
            foreach ($keptExisting as $row) $used[] = (int) $row->step_id;
            foreach ($newInput as $s) {
                $sid = (int) ($s['stage_id'] ?? $s['step_id'] ?? 0);
                if ($sid > 0) $used[] = $sid;
            }

            $counts = array_count_values($used);
            foreach ($counts as $stepId => $c) {
                if ($c > 1) {
                    $v->errors()->add('stages', "Stage $stepId is selected more than once. Each stage can be selected only once.");
                }
            }
        });

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $conv = static function ($v) use ($fmt) {
            if (!$v) return null;
            try {
                return \Carbon\Carbon::createFromFormat($fmt, $v)->format($fmt);
            } catch (\Throwable $e) {
                return null;
            }
        };

        try {
            DB::transaction(function () use ($request, $employee, $conv) {
                $isIncident = (int) $request->inside_status === 3;

                $ticketPath = $employee->arrival_ticket_attachment;
                $entryStampPath = $employee->arrival_entry_stamp_attachment;
                $icpPath = $employee->arrival_icp_proof_attachment;

                if ($request->hasFile('arrival_ticket_attachment')) {
                    $f = $request->file('arrival_ticket_attachment');
                    if ($f && $f->isValid()) $ticketPath = $f->store('visa_arrival/ticket', 'public');
                }

                if ($request->hasFile('arrival_entry_stamp_attachment')) {
                    $f = $request->file('arrival_entry_stamp_attachment');
                    if ($f && $f->isValid()) $entryStampPath = $f->store('visa_arrival/entry_stamp', 'public');
                }

                if ($request->hasFile('arrival_icp_proof_attachment')) {
                    $f = $request->file('arrival_icp_proof_attachment');
                    if ($f && $f->isValid()) $icpPath = $f->store('visa_arrival/icp_proof', 'public');
                }

                $employee->update([
                    'reference_no' => $request->reference_no,
                    'package' => $request->package,
                    'name' => $request->name,
                    'slug' => $this->generateUniqueSlug($request->slug ?? $employee->slug, $employee->id),
                    'nationality' => $request->nationality,
                    'passport_no' => $request->passport_no,
                    'passport_expiry_date' => $conv($request->passport_expiry_date),
                    'date_of_joining' => $conv($request->date_of_joining),
                    'visa_designation' => $request->visa_designation,
                    'date_of_birth' => $conv($request->date_of_birth),
                    'gender' => $request->gender,
                    'employment_contract_start_date' => $conv($request->employment_contract_start_date),
                    'employment_contract_end_date' => $conv($request->employment_contract_end_date),
                    'contract_type' => $request->contract_type,
                    'personal_no' => $request->personal_no,
                    'file_entry_permit_no' => $request->file_entry_permit_no,
                    'file_entry_permit_issued_date' => $conv($request->file_entry_permit_issued_date),
                    'file_entry_permit_expired_date' => $conv($request->file_entry_permit_expired_date),
                    'emirates_id_number' => $request->emirates_id_number,
                    'eid_issued_date' => $conv($request->eid_issued_date),
                    'eid_expiry_date' => $conv($request->eid_expiry_date),
                    'labor_card_no' => $request->labor_card_no,
                    'labor_card_issued_date' => $conv($request->labor_card_issued_date),
                    'labor_card_expiry_date' => $conv($request->labor_card_expiry_date),
                    'iloe_number' => $request->iloe_number,
                    'iloe_issued_date' => $conv($request->iloe_issued_date),
                    'iloe_expired_date' => $conv($request->iloe_expired_date),
                    'residence_visa_start_date' => $conv($request->residence_visa_start_date),
                    'residence_visa_expiry_date' => $conv($request->residence_visa_expiry_date),
                    'insurance_policy_number' => $request->insurance_policy_number,
                    'insurance_policy_issued_date' => $conv($request->insurance_policy_issued_date),
                    'insurance_policy_expired_date' => $conv($request->insurance_policy_expired_date),
                    'uid_no' => $request->uid_no,
                    'foreign_partner' => $request->foreign_partner,
                    'salary_as_per_contract' => $request->salary_as_per_contract,
                    'basic' => $request->basic,
                    'housing' => $request->housing,
                    'transport' => $request->transport,
                    'other_allowances' => $request->other_allowances,
                    'total_salary' => $request->total_salary,
                    'payment_type' => $request->payment_type,
                    'bank_name' => $request->bank_name,
                    'iban' => $request->iban,
                    'current_status' => $request->current_status,
                    'status' => $request->has('status') ? $request->status : $employee->status,
                    'inside_status' => $request->inside_status,
                    'inside_country_or_outside' => $request->inside_country_or_outside,
                    'incident_type' => $isIncident ? $request->incident_type : null,
                    'incident_date' => $isIncident ? $conv($request->incident_date) : null,
                    'remarks' => $request->remarks,
                    'comments' => $request->comments,
                    'religion' => $request->religion,
                    'marital_status' => $request->marital_status,
                    'children_count' => is_numeric($request->children_count) ? (int) $request->children_count : 0,
                    'experience_years' => $request->experience_years,
                    'salary' => $request->salary ?? $employee->salary ?? 1200,
                    'arrival_date' => $conv($request->arrival_date),
                    'arrival_expiry_date' => $conv($request->arrival_expiry_date),
                    'arrival_ticket_attachment' => $ticketPath,
                    'arrival_entry_stamp_attachment' => $entryStampPath,
                    'arrival_icp_proof_attachment' => $icpPath,
                ]);

                $candidateId = (int) $employee->id;
                $userId = auth()->id();
                $now = now();

                if ((int) $request->inside_status === 1) {
                    $latest = DB::table('office')
                        ->where('candidate_id', $candidateId)
                        ->where('type', 'employee')
                        ->orderByDesc('id')
                        ->first();

                    if ($latest) {
                        DB::table('office')
                            ->where('candidate_id', $candidateId)
                            ->where('type', 'employee')
                            ->update([
                                'status' => 0,
                                'update_by' => $userId,
                                'updated_at' => $now,
                            ]);

                        DB::table('office')
                            ->where('id', (int) $latest->id)
                            ->update([
                                'status' => 1,
                                'update_by' => $userId,
                                'updated_at' => $now,
                            ]);
                    } else {
                        DB::table('office')->insert([
                            'candidate_id' => $candidateId,
                            'type' => 'employee',
                            'status' => 1,
                            'created_by' => $userId,
                            'update_by' => $userId,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                } else {
                    DB::table('office')
                        ->where('candidate_id', $candidateId)
                        ->where('type', 'employee')
                        ->update([
                            'status' => 0,
                            'update_by' => $userId,
                            'updated_at' => $now,
                        ]);
                }

                $deleteAttachments = $request->input('delete_attachments', []);
                if (is_array($deleteAttachments) && count($deleteAttachments)) {
                    EmployeeAttachment::where('employee_id', $employee->id)
                        ->whereIn('id', array_map('intval', $deleteAttachments))
                        ->delete();
                }

                $ids = array_unique(array_merge(
                    array_keys($request->input('attachment_type_existing', []) ?? []),
                    array_keys($request->input('attachment_number_existing', []) ?? []),
                    array_keys($request->input('issued_on_existing', []) ?? []),
                    array_keys($request->input('expired_on_existing', []) ?? []),
                    array_keys($request->file('attachment_file_existing', []) ?? [])
                ));

                foreach ($ids as $id) {
                    $id = (int) $id;

                    $att = EmployeeAttachment::where('employee_id', $employee->id)->where('id', $id)->first();
                    if (!$att) continue;

                    $types = $request->input('attachment_type_existing', []);
                    $nums = $request->input('attachment_number_existing', []);
                    $iss = $request->input('issued_on_existing', []);
                    $exp = $request->input('expired_on_existing', []);

                    if (array_key_exists($id, $types)) $att->attachment_type = $types[$id] ?: null;
                    if (array_key_exists($id, $nums)) $att->attachment_number = $nums[$id] ?: null;
                    if (array_key_exists($id, $iss)) $att->issued_on = $iss[$id] ?: null;
                    if (array_key_exists($id, $exp)) $att->expired_on = $exp[$id] ?: null;

                    if ($request->hasFile("attachment_file_existing.$id")) {
                        $file = $request->file("attachment_file_existing.$id");
                        if ($file && $file->isValid()) {
                            $att->attachment_file = $file->store('attachments', 'public');
                            $att->attachment_name = $file->getClientOriginalName();
                        }
                    }

                    $att->save();
                }

                if ($request->hasFile('attachment_file_new')) {
                    foreach ($request->file('attachment_file_new') as $i => $file) {
                        if ($file && $file->isValid()) {
                            EmployeeAttachment::create([
                                'employee_id' => $employee->id,
                                'attachment_type' => $request->input("attachment_type_new.$i") ?: null,
                                'attachment_file' => $file->store('attachments', 'public'),
                                'attachment_name' => $file->getClientOriginalName(),
                                'attachment_number' => $request->input("attachment_number_new.$i") ?: null,
                                'issued_on' => $request->input("issued_on_new.$i") ?: null,
                                'expired_on' => $request->input("expired_on_new.$i") ?: null,
                            ]);
                        }
                    }
                }

                $deleteStages = $request->input('delete_stages', []);
                if (is_array($deleteStages) && count($deleteStages)) {
                    $delIds = array_map('intval', $deleteStages);
                    EmployeeVisaStage::where('employee_id', $employee->id)->whereIn('id', $delIds)->delete();
                }

                $existingRows = EmployeeVisaStage::where('employee_id', $employee->id)->get()->keyBy('id');

                $stageExistingInput = $request->input('stages_existing', []);
                $stageExistingInput = is_array($stageExistingInput) ? $stageExistingInput : [];

                foreach ($stageExistingInput as $id => $payload) {
                    $id = (int) $id;
                    if (!$existingRows->has($id)) continue;

                    $row = $existingRows->get($id);

                    $row->hr_issue_date = $payload['hr_issue_date'] ?? $row->hr_issue_date;
                    $row->hr_file_number = $payload['hr_file_number'] ?? $row->hr_file_number;
                    $row->hr_expiry_date = $payload['hr_expiry_date'] ?? $row->hr_expiry_date;
                    $row->fin_paid_amount = $payload['fin_paid_amount'] ?? $row->fin_paid_amount;

                    if ($request->hasFile("stages_existing.$id.hr_attach_file")) {
                        $f = $request->file("stages_existing.$id.hr_attach_file");
                        if ($f && $f->isValid()) $row->hr_attach_file = $f->store('visa_stages/hr', 'public');
                    }

                    if ($request->hasFile("stages_existing.$id.ica_proof")) {
                        $f = $request->file("stages_existing.$id.ica_proof");
                        if ($f && $f->isValid()) $row->ica_proof = $f->store('visa_stages/ica', 'public');
                    }

                    if ($request->hasFile("stages_existing.$id.fin_zoho_proof")) {
                        $f = $request->file("stages_existing.$id.fin_zoho_proof");
                        if ($f && $f->isValid()) $row->fin_zoho_proof = $f->store('visa_stages/finance/zoho', 'public');
                    }

                    if ($request->hasFile("stages_existing.$id.fin_gov_invoice_proof")) {
                        $f = $request->file("stages_existing.$id.fin_gov_invoice_proof");
                        if ($f && $f->isValid()) $row->fin_gov_invoice_proof = $f->store('visa_stages/finance/gov', 'public');
                    }

                    $row->save();

                    if ($request->hasFile("stages_existing.$id.fin_extra_files")) {
                        foreach ($request->file("stages_existing.$id.fin_extra_files") as $ff) {
                            if ($ff && $ff->isValid()) {
                                $path = $ff->store('visa_stages/finance/extra', 'public');
                                DB::table('employees_additional_files')->insert([
                                    'employee_id' => $employee->id,
                                    'visa_stage_id' => $row->id,
                                    'step_id' => $row->step_id,
                                    'file_path' => $path,
                                    'file_name' => $ff->getClientOriginalName(),
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        }
                    }
                }

                $newBlocks = $request->input('stages_new', []);
                $fallbackBlocks = $request->input('stages', []);

                $toCreate = [];
                if (is_array($newBlocks) && count($newBlocks)) {
                    $toCreate = array_values($newBlocks);
                } elseif (is_array($fallbackBlocks) && count($fallbackBlocks)) {
                    $toCreate = array_values($fallbackBlocks);
                }

                foreach ($toCreate as $i => $s) {
                    $sid = (int) ($s['stage_id'] ?? $s['step_id'] ?? 0);
                    if ($sid <= 0) continue;

                    $hrAttachPath = null;
                    $icaPath = null;
                    $zohoPath = null;
                    $govPath = null;

                    if ($request->hasFile("stages_new.$i.hr_attach_file")) {
                        $f = $request->file("stages_new.$i.hr_attach_file");
                        if ($f && $f->isValid()) $hrAttachPath = $f->store('visa_stages/hr', 'public');
                    }

                    if ($request->hasFile("stages_new.$i.ica_proof")) {
                        $f = $request->file("stages_new.$i.ica_proof");
                        if ($f && $f->isValid()) $icaPath = $f->store('visa_stages/ica', 'public');
                    }

                    if ($request->hasFile("stages_new.$i.fin_zoho_proof")) {
                        $f = $request->file("stages_new.$i.fin_zoho_proof");
                        if ($f && $f->isValid()) $zohoPath = $f->store('visa_stages/finance/zoho', 'public');
                    }

                    if ($request->hasFile("stages_new.$i.fin_gov_invoice_proof")) {
                        $f = $request->file("stages_new.$i.fin_gov_invoice_proof");
                        if ($f && $f->isValid()) $govPath = $f->store('visa_stages/finance/gov', 'public');
                    }

                    $row = EmployeeVisaStage::create([
                        'employee_id' => $employee->id,
                        'step_id' => $sid,
                        'hr_issue_date' => $s['hr_issue_date'] ?? null,
                        'hr_file_number' => $s['hr_file_number'] ?? null,
                        'hr_expiry_date' => $s['hr_expiry_date'] ?? null,
                        'hr_attach_file' => $hrAttachPath,
                        'ica_proof' => $icaPath,
                        'fin_paid_amount' => $s['fin_paid_amount'] ?? null,
                        'fin_zoho_proof' => $zohoPath,
                        'fin_gov_invoice_proof' => $govPath,
                    ]);

                    if ($request->hasFile("stages_new.$i.fin_extra_files")) {
                        foreach ($request->file("stages_new.$i.fin_extra_files") as $ff) {
                            if ($ff && $ff->isValid()) {
                                $path = $ff->store('visa_stages/finance/extra', 'public');
                                DB::table('employees_additional_files')->insert([
                                    'employee_id' => $employee->id,
                                    'visa_stage_id' => $row->id,
                                    'step_id' => $row->step_id,
                                    'file_path' => $path,
                                    'file_name' => $ff->getClientOriginalName(),
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        }
                    }
                }

                $maxStage = EmployeeVisaStage::where('employee_id', $employee->id)->max('step_id');
                $lastStage = null;

                if ($maxStage) {
                    $lastStage = EmployeeVisaStage::where('employee_id', $employee->id)
                        ->where('step_id', $maxStage)
                        ->orderByDesc('id')
                        ->first();
                }

                if ($maxStage) {
                    $employee->visa_status = (int) $maxStage;
                    $employee->expiry_date = $lastStage?->hr_expiry_date;
                    $employee->save();
                }
            });
        } catch (\Throwable $e) {
            \Log::error('Failed to update employee', [
                'reference_no' => $reference_no,
                'message' => $e->getMessage(),
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Update failed.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()])->withInput();
        }

        $redirect = route('employees.inside');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Employee updated successfully.',
                'redirect' => $redirect,
            ]);
        }

        return redirect()->route('employees.inside')->with('success', 'Employee updated successfully.');
    }

    public function destroy($slug)
    {
        try {
            $employee = Employee::where('slug', $slug)->firstOrFail();
            $employee->delete();
            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('employees.index')->with('error', 'Employee not found.');
        }
    }

    protected function generateUniqueSlug($name, $id = null)
    {
        $originalSlug = Str::slug($name);
        $uniqueSlug = $originalSlug;
        $count = 1;
        while (Employee::where('slug', $uniqueSlug)->where('id', '!=', $id)->exists()) {
            $uniqueSlug = $originalSlug . '-' . $count;
            $count++;
        }
        return $uniqueSlug;
    }

    public function showUploadForm()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('employee.upload_staff_csv_file', ['now' => $now]);
    }

    public function processCsvUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:5000'
        ]);

        $filePath = $request->file('csv_file')->store('uploads/csv');
        $data = array_map('str_getcsv', file(storage_path('app/' . $filePath)));
        $header = array_shift($data);
        $totalRecords = count($data);
        $uploadedRecords = 0;
        $errors = [];

        foreach ($data as $row) {
            $staffData = array_combine($header, $row);
            $validator = Validator::make($staffData, [
                'reference_no' => 'required',
                'name_of_staff' => 'required',
                'nationality' => 'required',
                'passport_no' => 'required|unique:staff,passport_no',
                'passport_expiry_date' => 'required|date',
                'status' => 'required',
                'slug' => 'required|unique:staff,slug'
            ]);

            if ($validator->fails()) {
                $errors[] = $validator->errors();
                continue;
            }

            Staff::create($staffData);
            $uploadedRecords++;
        }

        $responseMessage = "$uploadedRecords of $totalRecords records uploaded successfully.";
        if (!empty($errors)) {
            $responseMessage .= " Some records were not uploaded due to validation errors.";
        }

        return response()->json([
            'success' => true,
            'message' => $responseMessage,
            'uploadedRecords' => $uploadedRecords,
            'totalRecords' => $totalRecords,
            'errors' => $errors
        ]);
    }

    public function getVisaStatusDetails(Request $request)
    {
        $statusText = $request->input('statusText');
        $tableName = strtolower(str_replace(' ', '_', $statusText));
        $fields = DB::table('visa_tracker_tables')
            ->where('table_name', $tableName)
            ->get(['field_name', 'field_type', 'is_nullable', 'default_value']);

        if ($fields->isEmpty()) {
            return response()->json(['error' => 'No table found for the given status text.'], 404);
        }

        return response()->json([
            'fields' => $fields,
            'statusText' => $statusText
        ]);
    }

    public function storeTrackingDetail(Request $request)
    {
        try {
            $status = (int) $request->input('status');
            $formName = $request->input('form_name');
            $tableMapping = [
                'Visit 1' => 'visit_1',
                'Visit 2' => 'visit_2',
                'Dubai Insurance' => 'insurance',
                'Entry Permit Visa' => 'visa',
                'CS (For Inside)' => 'change_status',
                'Medical' => 'medical',
                'Tawjeeh Date' => 'tawjeeh',
                'EID' => 'emirated_id',
                'Residence Visa Stamping' => 'residence_visa',
                'Visit 3' => 'visit_3',
                'ILOE' => 'iloe',
                'Salary Details' => 'salary_details',
                'Visa Cancellation' => 'visa_cancellation'
            ];

            $tableName = $tableMapping[$formName] ?? null;
            if (!$tableName) {
                return response()->json(['error' => 'Invalid form name'], 400);
            }

            $validator = Validator::make($request->all(), [
                'candidate_id' => 'required|integer',
                'proof' => 'nullable|file|mimes:jpeg,png,pdf,jpg|max:5000',
                'remarks' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $data = $request->except(['_token', 'form_name', 'proof', 'status']);
            $data['candidate_id'] = $request->input('candidate_id');
            $data['created_by'] = auth()->id();

            if ($request->hasFile('proof')) {
                $filePath = $request->file('proof')->store('tracking_attachments', 'public');
                $data['proof'] = $filePath;
            }

            if ($request->has('remarks')) {
                $data['remarks'] = $request->input('remarks');
            }

            $currentVisaStatus = DB::table('employees')
                ->where('id', $data['candidate_id'])
                ->value('visa_status');

            if ($status !== 13) {
                if ($currentVisaStatus + 1 !== $status) {
                    return response()->json(['error' => 'Visa status transition is not allowed.'], 400);
                }
            }

            DB::table($tableName)->insert($data);
            DB::table('employees')->where('id', $data['candidate_id'])->update(['visa_status' => $status]);

            return response()->json(['message' => 'Data saved successfully in ' . $formName]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function officeData($id)
    {
        $employee = Employee::findOrFail($id);
        $visaStatusName = DB::table('visa_tracker_statuses')
            ->where('id', $employee->visa_status)
            ->value('name');
        $data = $employee->toArray();
        $data['visa_status'] = $visaStatusName ?? 'N/A';
        return response()->json($data);
    }

    public function officeSave(Request $request)
    {
        $request->validate([
            'employee_id' => ['nullable', 'integer', Rule::exists('employees', 'id')],
            'candidate_id' => ['nullable', 'integer', Rule::exists('employees', 'id')],

            'category' => ['required', 'string'],
            'returned_date' => ['required', 'date'],
            'expiry_date' => ['required', 'date'],

            'ica_proof_attachment' => ['required_without:ica_proof', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5000'],
            'ica_proof' => ['required_without:ica_proof_attachment', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5000'],

            'overstay_days' => ['required', 'integer'],
            'fine_amount' => ['required', 'numeric'],
            'passport_status' => ['required', 'string'],
        ]);

        $employeeId = $request->input('employee_id') ?? $request->input('candidate_id');

        if (!$employeeId) {
            return response()->json(['message' => 'employee_id or candidate_id is required.'], 422);
        }

        $employee = DB::table('employees')->where('id', $employeeId)->first();

        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        $proofFile = $request->file('ica_proof_attachment') ?? $request->file('ica_proof');

        if (!$proofFile) {
            return response()->json(['message' => 'ICA proof file is required.'], 422);
        }

        $icaProofPath = null;

        try {
            $result = DB::transaction(function () use ($request, $employeeId, $proofFile, &$icaProofPath) {
                $row = DB::table('employees')->where('id', $employeeId)->lockForUpdate()->first();
                $previousStatus = (int)($row->inside_status ?? 0);

                $icaProofPath = $proofFile->storeAs(
                    'payment_proof',
                    uniqid($employeeId . '_', true) . '.' . $proofFile->getClientOriginalExtension(),
                    'public'
                );

                $deactivated = DB::table('office')
                    ->where('candidate_id', $employeeId)
                    ->where('type', 'employee')
                    ->update([
                        'status' => 0,
                        'updated_at' => now(),
                    ]);

                $insertId = DB::table('office')->insertGetId([
                    'candidate_id' => $employeeId,
                    'type' => 'employee',
                    'category' => $request->input('category'),
                    'returned_date' => $request->input('returned_date'),
                    'expiry_date' => $request->input('expiry_date'),
                    'ica_proof' => $icaProofPath,
                    'overstay_days' => (int)$request->input('overstay_days'),
                    'fine_amount' => $request->input('fine_amount'),
                    'passport_status' => $request->input('passport_status'),
                    'status' => 1,
                    'created_by' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if (!$insertId) {
                    throw new \RuntimeException('Failed to insert office record.');
                }

                DB::table('employees')
                    ->where('id', $employeeId)
                    ->update([
                        'inside_status' => 1,
                        'inside_country_or_outside' => 2,
                        'updated_at' => now(),
                    ]);

                $agreementsUpdated = 0;
                $contractsUpdated = 0;
                $invoicesUpdated  = 0;

                if ($previousStatus === 2 && in_array($request->input('category'), ['Sales Return', 'Trial Return'], true)) {
                    $agreements = Agreement::select('id', 'reference_no')
                        ->where('candidate_id', $employeeId)
                        ->where('agreement_type', 'BIA')
                        ->where('reference_of_candidate', $row->reference_no ?? null)
                        ->get();

                    if ($agreements->isNotEmpty()) {
                        $agreementIds = $agreements->pluck('id');
                        $refNos = $agreements->pluck('reference_no');

                        $agreementsUpdated = Agreement::whereIn('id', $agreementIds)->update([
                            'status' => 4,
                            'notes' => 'Agreement cancelled due to ' . strtolower($request->input('category')),
                            'updated_at' => now(),
                        ]);

                        $contractsUpdated = Contract::whereIn('agreement_reference_no', $refNos)->update([
                            'status' => 4,
                            'cancelled_date' => Carbon::now(),
                            'remarks' => 'Contract is cancelled due to ' . strtolower($request->input('category')),
                            'updated_at' => now(),
                        ]);

                        $invoicesUpdated = Invoice::whereIn('agreement_reference_no', $refNos)->update([
                            'status' => 'Cancelled',
                            'notes' => 'Invoice is cancelled due to ' . strtolower($request->input('category')),
                            'updated_at' => now(),
                        ]);
                    }
                }

                return [
                    'office_insert_id' => $insertId,
                    'office_deactivated' => $deactivated,
                    'employee_previous_inside_status' => $previousStatus,
                    'employee' => DB::table('employees')->where('id', $employeeId)->first(),
                    'agreements_updated' => $agreementsUpdated,
                    'contracts_updated' => $contractsUpdated,
                    'invoices_updated' => $invoicesUpdated,
                ];
            });

            return response()->json([
                'message' => 'Data saved successfully',
                'details' => $result,
            ], 201);

        } catch (\Throwable $e) {
            if ($icaProofPath) {
                Storage::disk('public')->delete($icaProofPath);
            }

            return response()->json([
                'message' => 'Failed to save data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function trial(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $type = $request->input('type');
        $status = $request->input('status');
        $query = Trial::with(['client'])->orderBy('agreement_reference_no', 'asc');

        if ($type == 'employee') {
            $query->where('trial_type', 'employee');
        } elseif ($type == 'package') {
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
            return view('employee.partials.trial_table', compact('trials', 'now'));
        }

        return view('employee.index', compact('trials', 'now'));
    }

    public function saveTrialConfirmed(Request $request)
    {
        $v = $request->validate([
            'trial_id'        => 'required|exists:trials,id',
            'candidate_id'    => 'required|exists:employees,id',
            'confirmed_date'  => 'required|date',
            'employer_name'   => 'required|string|max:255',
            'payment_method'  => 'required|string|max:50',
            'received_amount' => 'required|numeric|min:0',
            'payment_proof'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
        ]);

        $filePath = $request->file('payment_proof')->store('payment_proofs', 'public');

        try {
            DB::transaction(function () use ($request, $v, $filePath) {
                $confirmedDate = Carbon::parse($v['confirmed_date'])->toDateString();
                $candidate = Employee::findOrFail($v['candidate_id']);
                $candidate->update([
                    'inside_status'  => 3,
                    'confirmed_date' => $confirmedDate,
                ]);

                $request->merge(['received_amount' => $v['received_amount']]);
                $invoice = $this->acctInv->createPendingInvoice($request, $filePath);

                PaymentProof::create([
                    'candidate_id'        => $v['candidate_id'],
                    'client_name'         => $v['employer_name'],
                    'invoice_id'          => $invoice->invoice_id,
                    'invoice_amount'      => $invoice->total_amount,
                    'received_amount'     => $invoice->received_amount,
                    'payment_method'      => $v['payment_method'],
                    'payment_proof_path'  => $filePath,
                    'created_by'          => auth()->id(),
                ]);

                Trial::where('id', $v['trial_id'])->update([
                    'trial_status'   => 'Confirmed',
                    'confirmed_date' => $confirmedDate,
                    'payment_proof'  => $filePath,
                ]);
            });

            return response()->json(['success' => true, 'message' => 'Trial confirmed and invoice updated successfully.']);
        } catch (\Exception $e) {
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function saveTrialReturn(Request $request)
    {
        $data = $request->validate([
            'trial_id'     => 'required|integer',
            'candidate_id' => 'required|integer',
            'proof'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
            'remarks'      => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($data, $request) {
                $path  = $request->file('proof')->store('trial_return_proof','public');
                $trial = Trial::findOrFail($data['trial_id']);
                $trial->update([
                    'trial_status'        => 'Trial Return',
                    'trial_return_date'   => Carbon::now('Asia/Dubai')->toDateString(),
                    'change_status_proof' => $path,
                    'remarks'             => $data['remarks'],
                ]);

                $ref = $trial->agreement_reference_no;

                Agreement::where('reference_no',$ref)->update([
                    'status' => 4,
                    'notes'  => 'This agreement is cancelled because of trial return',
                ]);

                Invoice::where('agreement_reference_no',$ref)->update([
                    'status' => 'Cancelled',
                    'notes'  => 'This invoice is cancelled because of trial return',
                ]);

                Contract::where('agreement_reference_no',$ref)->update([
                    'status'  => 2,
                    'cancelled_date' => Carbon::now(),
                    'remarks' => 'Contract cancelled because of trial return',
                ]);

                Employee::where('id',$data['candidate_id'])->update([
                    'inside_status' => 1,
                ]);

                DB::table('office')->insert([
                    'candidate_id'  => $data['candidate_id'],
                    'type'          => 'employee',
                    'category'      => 'Trial Return',
                    'returned_date' => Carbon::now('Asia/Dubai')->toDateString(),
                    'status'        => 1,
                    'created_by'    => auth()->id(),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            });

            return response()->json(['success'=>true,'message'=>'Trial Return saved.']);
        } catch (\Exception $e) {
            Log::error('saveTrialReturn error',['e'=>$e]);
            return response()->json(['success'=>false,'message'=>'Error saving Trial Return.'],500);
        }
    }

    public function saveSalesReturn(Request $request)
    {
        $data = $request->validate([
            'trial_id'     => 'required|integer',
            'candidate_id' => 'required|integer',
            'proof'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
            'remarks'      => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($data, $request) {
                $path  = $request->file('proof')->store('sales_return_proof','public');
                $trial = Trial::findOrFail($data['trial_id']);
                $trial->update([
                    'trial_status'        => 'Sales Return',
                    'sales_return_date'   => Carbon::now('Asia/Dubai')->toDateString(),
                    'change_status_proof' => $path,
                    'remarks'             => $data['remarks'],
                ]);

                $ref = $trial->agreement_reference_no;

                Agreement::where('reference_no',$ref)->update([
                    'status' => 4,
                    'notes'  => 'This agreement is cancelled because of sales return',
                ]);

                Invoice::where('agreement_reference_no',$ref)->update([
                    'status' => 'Cancelled',
                    'notes'  => 'This invoice is cancelled because of sales return',
                ]);

                Contract::where('agreement_reference_no',$ref)->update([
                    'status'  => 2,
                    'cancelled_date' => Carbon::now(),
                    'remarks' => 'Contract cancelled because of sales return',
                ]);

                Employee::where('id',$data['candidate_id'])->update([
                    'inside_status' => 1,
                ]);

                DB::table('office')->insert([
                    'candidate_id'  => $data['candidate_id'],
                    'type'          => 'employee',
                    'category'      => 'Sales Return',
                    'returned_date' => Carbon::now('Asia/Dubai')->toDateString(),
                    'status'        => 1,
                    'created_by'    => auth()->id(),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            });

            return response()->json(['success'=>true,'message'=>'Sales Return saved.']);
        } catch (\Exception $e) {
            Log::error('saveSalesReturn error',['e'=>$e]);
            return response()->json(['success'=>false,'message'=>'Error saving Sales Return.'],500);
        }
    }

    public function saveReturnIncident(Request $request)
    {
        $data = $request->validate([
            'candidate_id'              => 'required|integer',
            'candidate_name'            => 'required|string|max:255',
            'employer_name'             => 'required|string|max:255',
            'candidate_reference_no'    => 'nullable|string|max:255',
            'candidate_ref_no'          => 'nullable|string|max:255',
            'foreign_partner'           => 'nullable|string|max:255',
            'candidate_nationality'     => 'nullable|string|max:255',
            'candidate_passport_number' => 'nullable|string|max:255',
            'candidate_passport_expiry' => 'nullable|date',
            'candidate_dob'             => 'nullable|date',
            'proof'                     => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
            'incident_status'           => 'required|string',
            'remarks'                   => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($data, $request) {
                $path  = $request->file('proof')->store('incident_proof','public');
                $trial = Trial::findOrFail($data['candidate_id']);
                $trial->update([
                    'trial_status'   => 'Incident',
                    'incident_type'  => $data['incident_status'],
                    'incident_date'  => Carbon::now('Asia/Dubai')->toDateString(),
                    'incident_proof' => $path,
                    'remarks'        => $data['remarks'],
                ]);

                $ref = $trial->agreement_reference_no;

                Agreement::where('reference_no',$ref)->update([
                    'status' => 4,
                    'notes'  => 'This agreement is cancelled because of incident',
                ]);

                Invoice::where('agreement_reference_no',$ref)->update([
                    'status' => 'Cancelled',
                    'notes'  => 'This invoice is cancelled because of incident',
                ]);

                Contract::where('agreement_reference_no',$ref)->update([
                    'status'  => 2,
                    'cancelled_date' => Carbon::now(),
                    'remarks' => 'Contract cancelled because of incident',
                ]);

                Employee::where('id',$data['candidate_id'])->update([
                    'inside_status' => 3,
                    'incident_date' => Carbon::now('Asia/Dubai')->toDateString(),
                ]);

                $office = DB::table('office')
                            ->where('candidate_id',$data['candidate_id'])
                            ->where('type','employee')
                            ->first();

                if ($office) {
                    DB::table('office')
                      ->where('candidate_id',$data['candidate_id'])
                      ->where('type','employee')
                      ->update([
                          'status' => 0,
                          'category'=> $data['incident_status'],
                          'incident_date'=> Carbon::now('Asia/Dubai')->toDateString(),
                          'updated_at'=> now(),
                      ]);
                } else {
                    DB::table('office')->insert([
                        'candidate_id' => $data['candidate_id'],
                        'type'         => 'employee',
                        'category'     => $data['incident_status'],
                        'returned_date'=> Carbon::now('Asia/Dubai')->toDateString(),
                        'status'       => 0,
                        'created_by'   => auth()->id(),
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                }

                DB::table('incident')->insert([
                    'incident_category'         => $data['incident_status'],
                    'candidate_id'              => $data['candidate_id'],
                    'candidate_name'            => $data['candidate_name'],
                    'employer_name'             => $data['employer_name'],
                    'candidate_reference_no'    => $data['candidate_reference_no'],
                    'candidate_ref_no'          => $data['candidate_ref_no'],
                    'foreign_partner'           => $data['foreign_partner'],
                    'candidate_nationality'     => $data['candidate_nationality'],
                    'candidate_passport_number' => $data['candidate_passport_number'],
                    'candidate_passport_expiry' => $data['candidate_passport_expiry'] ? Carbon::parse($data['candidate_passport_expiry'])->toDateString() : null,
                    'candidate_dob'             => $data['candidate_dob'] ? Carbon::parse($data['candidate_dob'])->toDateString() : null,
                    'incident_reason'           => $data['remarks'],
                    'proof'                     => $path,
                    'created_by'                => auth()->id(),
                    'created_at'                => now(),
                    'updated_at'                => now(),
                ]);
            });

            return response()->json(['success'=>true,'message'=>'Incident saved.']);
        } catch (\Exception $e) {
            Log::error('saveReturnIncident error',['e'=>$e]);
            return response()->json(['success'=>false,'message'=>'Error saving Incident.'],500);
        }
    }

    public function updateCandidateDetails(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required',
            'arrived_in_office_date' => 'required|date',
            'visa_type' => 'required|string',
            'overstay_days' => 'required|integer',
            'fine_amount' => 'required|numeric',
            'preferred_package' => 'required|string',
            'accomodation' => 'required|string',
            'passport_status' => 'required|string',
            'visa_issue_date' => 'nullable',
            'visa_expiry_date' => 'nullable',
            'entry_date' => 'nullable',
            'cancellation_date' => 'nullable',
        ]);
        DB::beginTransaction();
        try {
            $arrived_in_office_date = Carbon::parse($request->arrived_in_office_date)->format('Y-m-d');
            $visa_issue_date = $request->visa_issue_date ? Carbon::parse($request->visa_issue_date)->format('Y-m-d') : null;
            $visa_expiry_date = $request->visa_expiry_date ? Carbon::parse($request->visa_expiry_date)->format('Y-m-d') : null;
            $entry_date = $request->entry_date ? Carbon::parse($request->entry_date)->format('Y-m-d') : null;
            $cancellation_date = $request->cancellation_date ? Carbon::parse($request->cancellation_date)->format('Y-m-d') : null;
            Employee::where('id', $request->candidate_id)->update([
                'arrived_in_office_date' => $arrived_in_office_date,
                'visa_type' => $request->visa_type,
                'overstay_days' => $request->overstay_days,
                'fine_amount' => $request->fine_amount,
                'preferred_package' => $request->preferred_package,
                'accomodation' => $request->accomodation,
                'passport_status' => $request->passport_status,
                'visa_issue_date' => $visa_issue_date,
                'visa_expiry_date' => $visa_expiry_date,
                'entry_date' => $entry_date,
                'cancellation_date' => $cancellation_date,
                'inside_status' => 1,
                'office_date' => Carbon::now('Asia/Dubai'),
                'updated_by' => auth()->id(),
                'updated_at' => Carbon::now('Asia/Dubai'),
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Candidate details updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating candidate details', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to update candidate details.']);
        }
    }

    public function updateTrialStatus(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'trial_id' => 'required',
            'candidate_id' => 'required',
            'client_id' => 'required',
        ]);

        $candidateId = $request->input('candidate_id');
        $clientId = $request->input('client_id');
        $candidate = Employee::findOrFail($candidateId);
        $clients = CRM::all();
        $agreement = Agreement::where('reference_of_candidate', $candidate->reference_no)->first();
        $client = CRM::findOrFail($clientId);
        $clientName = $client->first_name . ' ' . $client->last_name;

        $invoicesQuery = DB::table('invoices')
            ->join('agreements', 'invoices.agreement_reference_no', '=', 'agreements.reference_no')
            ->where('agreements.reference_of_candidate', $candidate->reference_no)
            ->where('invoices.status', '<>', 'Cancelled')
            ->orderBy('invoices.invoice_id', 'desc')
            ->select('invoices.*');
        $invoices = $invoicesQuery->get();
        $remainingAmount = $invoices->sum('total_amount') - $invoices->sum('received_amount');
        $remainingAmountWithVat = $remainingAmount + ($invoices->sum('total_amount') * 0.00);
        $candidateDetails = [
            'candidateId' => $candidate->id,
            'referenceNo' => $candidate->reference_no,
            'ref_no' => $candidate->reference_no,
            'candidateName' => $candidate->name,
            'foreignPartner' => $candidate->foreign_partner,
            'nationality' => $candidate->nationality,
            'passportNo' => $candidate->passport_no,
            'passportExpiry'=>$candidate->passport_expiry_date?->format('Y-m-d'),
            'dob'=>$candidate->date_of_birth?->format('Y-m-d'),
            'employerName' => $candidate->employer_name,
            'clientName' => $clientName,
            'invoices' => $invoices,
            'remainingAmountWithVat' => $remainingAmountWithVat,
        ];

        $modals = [
            'Confirmed'     => ['ConfirmedModal', 'Please update the confirmed trial details.'],
            'Trial Return'  => ['TrialReturnModal', 'Please update the trial return details.'],
            'Incident'      => ['IncidentModal', 'Please update the incident details.'],
            'Sales Return'  => ['SalesReturnModal', 'Please update the sales return details.'],
            'Change Status' => ['ChangeStatusModal', 'Please update the changed status details.'],
        ];

        if (isset($modals[$request->status])) {
            $modal = $modals[$request->status];
            return response()->json([
                'success' => true,
                'action' => 'open_modal',
                'modal' => $modal[0],
                'message' => $modal[1],
                'clients' => $clients,
                'candidateDetails' => $candidateDetails,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "You can't change the trial status.",
        ], 403);
    }

    public function updateChangeStatus(Request $request)
    {
        $validatedData = $request->validate([
            'trial_id' => 'required|integer|exists:trials,id',
            'candidate_id' => 'required|integer|exists:new_candidates,id',
            'change_status_date' => 'required|date',
            'proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
        ]);

        try {
            DB::transaction(function () use ($validatedData, $request) {
                $filePath = $request->file('proof')->store('change_status_proof', 'public');

                $trialUpdated = Trial::where('id', $validatedData['trial_id'])->update([
                    'trial_status' => 'Change Status',
                    'change_status_date' => $validatedData['change_status_date'],
                    'change_status_proof' => $filePath,
                ]);

                $candidateUpdated = Employee::where('id', $validatedData['candidate_id'])->update([
                    'inside_status' => 4,
                    'change_status_date' => $validatedData['change_status_date'],
                ]);

                if (!$trialUpdated) {
                    throw new \Exception("Trial with ID {$validatedData['trial_id']} could not be updated.");
                }

                if (!$candidateUpdated) {
                    throw new \Exception("Candidate with ID {$validatedData['candidate_id']} could not be updated.");
                }
            });

            return response()->json(['success' => true, 'message' => 'Change status updated successfully.']);
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error in updateChangeStatus:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'A database error occurred while updating the status. Please check the logs.',
            ], 500);
        } catch (\Exception $e) {
            Log::error('General error in updateChangeStatus:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the status. Please try again.',
            ], 500);
        }
    }

    public function exit_form($referenceNo)
    {
        $employee = Employee::where('reference_no', $referenceNo)->firstOrFail();
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('employee.exit', compact('employee', 'now'));
    }

    public function employeePaymentTracker(Request $request)
    {
        $query = Installment::with('items')->orderBy('created_at', 'desc');

        if ($request->filled('global_search')) {
            $search = $request->input('global_search');
            $query->where(function ($q) use ($search) {
                $q->where('employee_name', 'like', '%' . $search . '%')
                  ->orWhere('passport_no', 'like', '%' . $search . '%')
                  ->orWhere('reference_no', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('package')) {
            $query->where('package', $request->input('package'));
        }

        if ($request->filled('contract_start_date')) {
            $query->whereDate('contract_start_date', Carbon::parse($request->input('contract_start_date'))->format('Y-m-d'));
        }

        $installments = $query->paginate(10);
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        if ($request->ajax()) {
            return view('employee.partials.payment_tracker_table', compact('installments', 'now'));
        }

        return view('employee.payment_tracker', compact('installments', 'now'));
    }

    public function inside_employees(Request $request)
    {
        $tz = 'Asia/Dubai';
        $now = Carbon::now($tz)->format('l, F d, Y h:i A');

        $status = (string) $request->input('status', 'all');
        $export = strtolower(trim((string) $request->input('export', '')));

        $search = trim((string) $request->input('search', ''));

        $searchRefCont = trim((string) $request->input('con_reference_no', ''));
        $searchRef = trim((string) $request->input('reference_no', ''));
        $searchName = trim((string) $request->input('candidate_name', ''));
        $searchPassport = trim((string) $request->input('passport_number', ''));
        $searchPartner = trim((string) $request->input('foreign_partner', ''));
        $searchVisaStage = $request->input('visa_stage');
        $searchNationality = $request->input('nationality');
        $searchCategory = $request->input('category');
        $searchTrial = $request->input('trial_status');
        $searchIncident = $request->input('incident_type');
        $filterInsideStatus = $request->input('inside_status');

        $activePackage = $this->normalizePackage((string) ($request->input('package') ?? 'ALL'));
        $activePackage = $activePackage === '' ? 'ALL' : $activePackage;

        $coll = config('database.connections.mysql.collation') ?: 'utf8mb4_unicode_ci';
        $allowedPackages = $this->receiptRefundPackages();

        $refundAgreementColumn = Schema::hasColumn('refunds', 'agreement_reference_no') ? 'agreement_reference_no' : 'reference_no';

        $receiptDateFrom = null;
        $receiptDateTo = null;
        if ($status === 'receipt') {
            [$receiptDateFrom, $receiptDateTo] = $this->normalizedDateRangeForRvoLike($request, $tz);
        }

        $filters = [
            'status' => $status,
            'search' => $search,
            'searchRefCont' => $searchRefCont,
            'searchRef' => $searchRef,
            'searchName' => $searchName,
            'searchPassport' => $searchPassport,
            'searchPartner' => $searchPartner,
            'searchVisaStage' => $searchVisaStage,
            'searchNationality' => $searchNationality,
            'searchCategory' => $searchCategory,
            'searchTrial' => $searchTrial,
            'searchIncident' => $searchIncident,
            'filterInsideStatus' => $filterInsideStatus,
            'searchPackage' => $activePackage,
            'allowedPackages' => $allowedPackages,
            'collation' => $coll,
            'refundAgreementColumn' => $refundAgreementColumn,
            'receiptDateFrom' => $receiptDateFrom,
            'receiptDateTo' => $receiptDateTo,
            'receipt_reference_no' => trim((string) $request->input('reference_no', '')),
            'receipt_agreement_no' => trim((string) $request->input('agreement_no', '')),
            'receipt_candidate_name' => trim((string) $request->input('candidate_name', '')),
            'receipt_customer_name' => trim((string) $request->input('customer_name', '')),
            'receipt_cl_number' => trim((string) $request->input('cl_number', '')),
            'receipt_cn_number' => trim((string) $request->input('cn_number', '')),
            'receipt_payment_method' => trim((string) $request->input('payment_method', '')),
            'receipt_status' => trim((string) ($request->input('invoice_status') ?? $request->input('status_rvo') ?? $request->input('receipt_status') ?? '')),
        ];

        if ($export === 'excel') {
            $filePrefix = match ($status) {
                'office' => 'office_employees_',
                'trial' => 'contracted_',
                'invoices' => 'invoices_',
                'receipt' => 'receipts_',
                'refund' => 'refunds_',
                default => 'employees_',
            };

            $file = $filePrefix . Carbon::now($tz)->format('Ymd_His') . '.xlsx';

            return match ($status) {
                'office' => Excel::download(new OfficeEmployeesExport($filters), $file),
                'trial' => Excel::download(new ContractsExport($filters), $file),
                'invoices' => Excel::download(new InvoicesExport($filters), $file),
                'receipt' => Excel::download(new ReceiptsExport($filters), $file),
                'refund' => Excel::download(new RefundsExport($filters), $file),
                default => Excel::download(new EmployeesExport($filters), $file),
            };
        }

        if ($export === 'pdf') {
            $exporter = match ($status) {
                'office' => new OfficeEmployeesExport($filters),
                'trial' => new ContractsExport($filters),
                'invoices' => new InvoicesExport($filters),
                'receipt' => new ReceiptsExport($filters),
                'refund' => new RefundsExport($filters),
                default => new EmployeesExport($filters),
            };

            $headings = $exporter->headings();
            $rows = $exporter->collection()->map(fn ($row) => $exporter->map($row))->toArray();

            $filePrefix = match ($status) {
                'office' => 'office_employees_',
                'trial' => 'contracted_',
                'invoices' => 'invoices_',
                'receipt' => 'receipts_',
                'refund' => 'refunds_',
                default => 'employees_',
            };

            $file = $filePrefix . Carbon::now($tz)->format('Ymd_His') . '.pdf';

            $title = match ($status) {
                'office' => 'Office Employees',
                'trial' => 'Contracted',
                'invoices' => 'Invoices',
                'receipt' => 'Receipts',
                'refund' => 'Refunds',
                default => 'Employees',
            };

            return PDF::loadView('employee.exports.generic_pdf', [
                'title' => $title,
                'headings' => $headings,
                'rows' => $rows,
            ])->setPaper('a4', 'landscape')->download($file);
        }

        $employees = null;
        $q = null;

        if ($status === 'receipt') {
            $receiptRef = trim((string) $request->input('reference_no', ''));
            $agreementNo = trim((string) $request->input('agreement_no', ''));
            $candidateName = trim((string) $request->input('candidate_name', ''));
            $customerName = trim((string) $request->input('customer_name', ''));
            $cl = trim((string) $request->input('cl_number', ''));
            $cn = trim((string) $request->input('cn_number', ''));
            $paymentMethod = trim((string) $request->input('payment_method', ''));

            $incomingReceiptStatus = trim((string) ($request->input('invoice_status') ?? $request->input('status_rvo') ?? $request->input('receipt_status') ?? ''));
            $receiptStatus = in_array($incomingReceiptStatus, ['Pending', 'Approved', 'Cancelled'], true) ? $incomingReceiptStatus : '';

            [$dateFrom, $dateTo] = $this->normalizedDateRangeForRvoLike($request, $tz);

            $q = DB::table('payment_receipts')
                ->leftJoin('agreements as a', function ($j) use ($coll) {
                    $j->on(DB::raw("a.reference_no COLLATE {$coll}"), '=', DB::raw("payment_receipts.reference_no COLLATE {$coll}"));
                })
                ->leftJoin('crm as c', 'c.id', '=', 'payment_receipts.customer_id')
                ->select([
                    'payment_receipts.id',
                    'payment_receipts.receipt_number',
                    'payment_receipts.receipt_date',
                    'payment_receipts.payer_type',
                    'payment_receipts.customer_id',
                    'payment_receipts.walkin_name',
                    'payment_receipts.amount',
                    'payment_receipts.payment_method',
                    'payment_receipts.reference_no',
                    'payment_receipts.attachment_path',
                    'payment_receipts.status',
                    'payment_receipts.notes',
                    'payment_receipts.cancel_reason',
                    'payment_receipts.created_at',
                    'a.reference_no as agreement_reference_no',
                    'a.candidate_name as candidate_name',
                    'a.passport_no as passport_no',
                    'a.nationality as nationality',
                    'a.package as package',
                    'a.CL_Number as CL_Number',
                    'a.CN_Number as CN_Number',
                    'c.first_name as customer_first_name',
                    'c.last_name as customer_last_name',
                    'c.mobile as customer_mobile',
                ])
                ->whereIn('a.package', $allowedPackages)
                ->when(in_array($activePackage, $allowedPackages, true), fn ($x) => $x->where('a.package', $activePackage))
                ->when($dateFrom && $dateTo, fn ($x) => $x->whereBetween('payment_receipts.receipt_date', [$dateFrom, $dateTo]))
                ->when($receiptStatus !== '', fn ($x) => $x->where('payment_receipts.status', $receiptStatus))
                ->when($paymentMethod !== '', fn ($x) => $x->where('payment_receipts.payment_method', $paymentMethod))
                ->when($agreementNo !== '', fn ($x) => $x->where('payment_receipts.reference_no', 'like', "{$agreementNo}%"))
                ->when($receiptRef !== '', function ($x) use ($receiptRef) {
                    $x->where(function ($w) use ($receiptRef) {
                        $w->where('payment_receipts.receipt_number', 'like', "{$receiptRef}%")
                            ->orWhere('payment_receipts.reference_no', 'like', "{$receiptRef}%");
                    });
                })
                ->when($candidateName !== '', fn ($x) => $x->where('a.candidate_name', 'like', "{$candidateName}%"))
                ->when($cl !== '', fn ($x) => $x->where('a.CL_Number', 'like', "{$cl}%"))
                ->when($cn !== '', fn ($x) => $x->where('a.CN_Number', 'like', "{$cn}%"))
                ->when($customerName !== '', function ($x) use ($customerName) {
                    $x->where(function ($w) use ($customerName) {
                        $w->whereRaw("CONCAT(IFNULL(c.first_name,''),' ',IFNULL(c.last_name,'')) like ?", ["%{$customerName}%"])
                            ->orWhere('payment_receipts.walkin_name', 'like', "%{$customerName}%");
                    });
                })
                ->when($search !== '', function ($x) use ($search) {
                    $x->where(function ($w) use ($search) {
                        $w->where('a.reference_no', 'like', "%{$search}%")
                            ->orWhere('a.candidate_name', 'like', "%{$search}%")
                            ->orWhere('a.passport_no', 'like', "%{$search}%")
                            ->orWhere('payment_receipts.receipt_number', 'like', "%{$search}%")
                            ->orWhere('payment_receipts.reference_no', 'like', "%{$search}%")
                            ->orWhere('payment_receipts.walkin_name', 'like', "%{$search}%")
                            ->orWhere('payment_receipts.payment_method', 'like', "%{$search}%")
                            ->orWhere('payment_receipts.status', 'like', "%{$search}%")
                            ->orWhere('payment_receipts.notes', 'like', "%{$search}%")
                            ->orWhere('payment_receipts.cancel_reason', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(IFNULL(c.first_name,''),' ',IFNULL(c.last_name,'')) like ?", ["%{$search}%"]);
                    });
                })
                ->orderByDesc('payment_receipts.id');

            $employees = $q->paginate(10)->withQueryString();
        } elseif ($status === 'refund') {
            $q = $this->buildRefundsQuery($request, $coll, $activePackage, $allowedPackages, $refundAgreementColumn);
            $employees = $q->paginate(10)->withQueryString();
        } elseif ($status === 'trial') {
            $q = Contract::with(['agreement', 'invoice', 'client', 'candidate', 'salesPerson', 'installments.items'])
                ->where('maid_delivered', 'Yes')
                ->when($activePackage !== 'ALL', fn ($x) => $x->whereHas('agreement', fn ($a) => $a->where('package', $activePackage)))
                ->when($search !== '', function ($x) use ($search) {
                    $x->where(function ($w) use ($search) {
                        $w->where('reference_no', 'like', "%{$search}%")
                            ->orWhereHas('agreement', function ($a) use ($search) {
                                $a->where('candidate_name', 'like', "%{$search}%")
                                    ->orWhere('passport_no', 'like', "%{$search}%");
                            });
                    });
                })
                ->when($searchRefCont !== '', fn ($x) => $x->where('reference_no', 'like', "{$searchRefCont}%"))
                ->when(!empty($searchTrial), fn ($x) => $x->where('status', $searchTrial))
                ->orderByDesc('reference_no');

            $employees = $q->paginate(10)->withQueryString();
        } elseif ($status === 'invoices') {
            $q = Invoice::with(['creator', 'customer', 'agreement'])
                ->where('invoice_type', 'Tax')
                ->where('invoice_number', 'not like', 'INV-INS-%')
                ->when($activePackage !== 'ALL', fn ($x) => $x->whereHas('agreement', fn ($a) => $a->where('package', $activePackage)))
                ->when($search !== '', function ($x) use ($search) {
                    $x->where(function ($w) use ($search) {
                        $w->where('invoice_number', 'like', "%{$search}%")
                            ->orWhere('contract_ref_no', 'like', "%{$search}%")
                            ->orWhere('CL_Number', 'like', "%{$search}%")
                            ->orWhere('CN_Number', 'like', "%{$search}%")
                            ->orWhere('payment_method', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%");
                    });
                })
                ->orderByDesc('invoice_id');

            $employees = $q->paginate(10)->withQueryString();
        } else {
            $arrivedRaw = (string) $request->input('arrived_date', '');
            $expiryRaw = (string) $request->input('expiry', '');
            $arrivedOrder = str_contains(strtolower($arrivedRaw), 'asc') ? 'asc' : (str_contains(strtolower($arrivedRaw), 'desc') ? 'desc' : null);
            $expiryOrder = str_contains(strtolower($expiryRaw), 'asc') ? 'asc' : (str_contains(strtolower($expiryRaw), 'desc') ? 'desc' : null);

            $officeLatest = DB::table('office as o')
                ->where('o.type', 'employee')
                ->where('o.status', 1)
                ->join(DB::raw('(select candidate_id, max(updated_at) as max_updated_at from office where type = "employee" and status = 1 group by candidate_id) ox'), function ($j) {
                    $j->on('ox.candidate_id', '=', 'o.candidate_id')->on('ox.max_updated_at', '=', 'o.updated_at');
                })
                ->select([
                    DB::raw('o.id as office_id'),
                    'o.candidate_id',
                    'o.category',
                    'o.returned_date',
                    'o.expiry_date',
                    'o.ica_proof',
                    'o.overstay_days',
                    'o.fine_amount',
                    'o.passport_status',
                    DB::raw('o.updated_at as office_updated_at'),
                ]);

            $q = Employee::query()
                ->when($activePackage !== 'ALL', fn ($x) => $x->where('employees.package', $activePackage))
                ->leftJoinSub($officeLatest, 'office', function ($j) {
                    $j->on('office.candidate_id', '=', 'employees.id');
                });

            switch ($status) {
                case 'office':
                    $q->where('employees.inside_status', 1)->whereNotNull('office.office_id')->orderByDesc('office.office_updated_at');
                    if ($arrivedOrder) {
                        $q->orderBy('employees.arrived_date', $arrivedOrder);
                    }
                    if ($expiryOrder) {
                        $q->orderBy('office.expiry_date', $expiryOrder);
                    }
                    break;

                case 'incident':
                    $q->where('employees.inside_status', 3)->orderByDesc('employees.created_at');
                    break;

                case 'outside':
                    $q->where('employees.inside_country_or_outside', 1)->orderByDesc('employees.created_at');
                    break;

                default:
                    $q->orderByDesc('employees.reference_no');
            }

            if (in_array((string) $filterInsideStatus, ['1', '2', '3'], true) && !in_array($status, ['office', 'incident'], true)) {
                $q->where('employees.inside_status', (int) $filterInsideStatus);
            }

            $q->when($search !== '', fn ($x) => $x->where(function ($w) use ($search) {
                $w->where('employees.reference_no', 'like', "%{$search}%")
                    ->orWhere('employees.name', 'like', "%{$search}%")
                    ->orWhere('employees.passport_no', 'like', "%{$search}%");
            }))
                ->when($searchRef !== '', fn ($x) => $x->where('employees.reference_no', 'like', "{$searchRef}%"))
                ->when($searchName !== '', fn ($x) => $x->where('employees.name', 'like', "{$searchName}%"))
                ->when($searchPassport !== '', fn ($x) => $x->where('employees.passport_no', 'like', "{$searchPassport}%"))
                ->when($searchPartner !== '', fn ($x) => $x->where('employees.foreign_partner', 'like', "%{$searchPartner}%"))
                ->when(!empty($searchVisaStage), fn ($x) => $x->where('employees.visa_status', $searchVisaStage))
                ->when(!empty($searchNationality), fn ($x) => $x->where('employees.nationality', $searchNationality))
                ->when($status === 'office' && !empty($searchCategory), fn ($x) => $x->where('office.category', $searchCategory))
                ->when($status === 'incident' && !empty($searchIncident), fn ($x) => $x->where('employees.incident_type', $searchIncident));

            $select = [
                'employees.*',
                DB::raw('office.expiry_date as expiry_date'),
                'office.office_id',
                'office.category',
                'office.returned_date',
                'office.ica_proof',
                'office.overstay_days',
                'office.fine_amount',
                'office.passport_status',
                'office.office_updated_at',
            ];

            $employees = $q->select($select)->paginate(10)->withQueryString();
        }

        $from = $request->input('from', Carbon::now($tz)->startOfMonth()->toDateString());
        $to = $request->input('to', Carbon::now($tz)->toDateString());

        $live = $this->getLiveSalaryData($from, $to, $activePackage);
        $liveRows = $live['rows'] ?? [];
        $liveTotalEmployees = (int) ($live['totalEmployees'] ?? 0);
        $liveTotalPayable = (float) ($live['totalPayable'] ?? 0);

        $countsReceipt = 0;
        if ($status === 'receipt' && $q) {
            $countsReceipt = (int) (clone $q)->count();
        } else {
            $countsReceipt = (int) DB::table('payment_receipts')
                ->leftJoin('agreements as a', function ($j) use ($coll) {
                    $j->on(DB::raw("a.reference_no COLLATE {$coll}"), '=', DB::raw("payment_receipts.reference_no COLLATE {$coll}"));
                })
                ->whereIn('a.package', $allowedPackages)
                ->when(in_array($activePackage, $allowedPackages, true), fn ($x) => $x->where('a.package', $activePackage))
                ->count();
        }

        $countsRefund = (int) $this->buildRefundsQuery($request, $coll, $activePackage, $allowedPackages, $refundAgreementColumn)->count();
        $employeeBase = Employee::query()->when($activePackage !== 'ALL', fn ($x) => $x->where('package', $activePackage));
        $counts = [
            'all' => (clone $employeeBase)->count(),
            'office' => (clone $employeeBase)->where('inside_status', 1)->count(),
            'trial' => Contract::where('maid_delivered', 'Yes')->when($activePackage !== 'ALL', fn ($x) => $x->whereHas('agreement', fn ($a) => $a->where('package', $activePackage)))->count(),
            'incident' => (clone $employeeBase)->where('inside_status', 3)->count(),
            'outside' => (clone $employeeBase)->where('inside_country_or_outside', 1)->count(),
            'invoices' => Invoice::where('invoice_type', 'Tax')
                ->where('invoice_number', 'not like', 'INV-INS-%')
                ->when($activePackage !== 'ALL', fn ($x) => $x->whereHas('agreement', fn ($a) => $a->where('package', $activePackage)))
                ->count(),
            'payroll' => $liveTotalEmployees,
            'ins_invoices' => Invoice::where('invoice_number', 'like', 'INV-INS-%')
                ->when($activePackage !== 'ALL', fn ($x) => $x->whereHas('agreement', fn ($a) => $a->where('package', $activePackage)))
                ->count(),
            'receipt' => $countsReceipt,
            'refund' => $countsRefund,
            'boa' => Agreement::where('agreement_type', 'BOA')->when($activePackage !== 'ALL', fn ($x) => $x->where('package', $activePackage))->count(),
            'rvo' => Invoice::where('invoice_type', 'Proforma')
                ->where('invoice_number', 'like', 'RVO-%')
                ->when($activePackage !== 'ALL', fn ($x) => $x->whereHas('agreement', fn ($a) => $a->where('package', $activePackage)))
                ->count(),
            'replacements' => (int) DB::table('replacement_history')->count(),
        ];

        $steps = DB::table('process_flow_steps')->select('id', 'title')->orderBy('step_no')->get();
        $viewData = [
            'now' => $now,
            'employees' => $employees,
            'counts' => $counts,
            'status' => $status,
            'searchRef' => $searchRef ?: null,
            'searchName' => $searchName ?: null,
            'searchPassport' => $searchPassport ?: null,
            'searchPartner' => $searchPartner ?: null,
            'searchVisaStage' => $searchVisaStage ?: null,
            'searchNationality' => $searchNationality ?: null,
            'searchPackage' => $activePackage,
            'searchCategory' => $searchCategory ?: null,
            'searchTrial' => $searchTrial ?: null,
            'searchIncident' => $searchIncident ?: null,
            'liveRows' => $liveRows,
            'liveTotalEmployees' => $liveTotalEmployees,
            'liveTotalPayable' => $liveTotalPayable,
            'nationalities' => Nationality::all(),
            'from' => $from,
            'to' => $to,
            'activePackage' => $activePackage,
            'steps' => $steps,
        ];

        if ($request->ajax()) {
            $tableView = match ($status) {
                'trial' => 'employee.partials.contracted_table',
                'office' => 'employee.partials.office_table',
                'incident' => 'employee.partials.incident_table',
                'outside' => 'employee.partials.outside_table',
                'invoices' => 'employee.partials.invoices_table',
                'receipt' => 'employee.partials.receipt_table',
                'refund' => 'employee.partials.refund_table',
                default => 'employee.partials.employees_table_inside',
            };

            $total = is_object($employees) && method_exists($employees, 'total') ? (int) $employees->total() : null;
            return response()->json([
                'table' => view($tableView, $viewData)->render(),
                'count' => $total,
                'status' => $status,
                'package' => $activePackage,
                'counts' => $counts,
            ]);
        }

        return view('employee.inside_emp', $viewData);
    }

    private function receiptRefundPackages(): array
    {
        return ['PKG-2','PKG-3','PKG-4'];
    }

    private function resolvePresetDates(?string $preset, string $tz): array
    {
        $p = strtolower(trim((string)$preset));
        if ($p === 'today') { $d = Carbon::now($tz)->toDateString(); return [$d,$d]; }
        if ($p === 'this_week') { return [Carbon::now($tz)->startOfWeek(Carbon::MONDAY)->toDateString(), Carbon::now($tz)->toDateString()]; }
        if ($p === 'this_month') { return [Carbon::now($tz)->startOfMonth()->toDateString(), Carbon::now($tz)->toDateString()]; }
        if ($p === 'previous_month') { return [Carbon::now($tz)->subMonthNoOverflow()->startOfMonth()->toDateString(), Carbon::now($tz)->subMonthNoOverflow()->endOfMonth()->toDateString()]; }
        if ($p === 'this_year') { return [Carbon::now($tz)->startOfYear()->toDateString(), Carbon::now($tz)->toDateString()]; }
        return [null,null];
    }

    private function normalizedDateRangeForRvoLike(Request $request, string $tz): array
    {
        $preset = strtolower(trim((string)$request->input('date_preset','')));
        $df = trim((string)$request->input('date_from',''));
        $dt = trim((string)$request->input('date_to',''));
        if ($preset && $preset !== 'custom') return $this->resolvePresetDates($preset, $tz);
        if ($preset === 'custom') return [$df !== '' ? $df : null, $dt !== '' ? $dt : null];
        return [$df !== '' ? $df : null, $dt !== '' ? $dt : null];
    }

    private function normalizedDateRangeForPayroll(Request $request, string $tz): array
    {
        $preset = strtolower(trim((string)$request->input('date_preset','')));
        $df = trim((string)$request->input('start_date',''));
        $dt = trim((string)$request->input('end_date',''));
        if ($preset && $preset !== 'custom') return $this->resolvePresetDates($preset, $tz);
        if ($preset === 'custom') return [$df !== '' ? $df : null, $dt !== '' ? $dt : null];
        return [$df !== '' ? $df : null, $dt !== '' ? $dt : null];
    }

    private function buildReceiptsQuery(Request $request, string $coll, string $activePackage, array $allowedPackages, string $receiptAgreementRefCol, bool $hasReceiptCustomerId)
    {
        $tz = 'Asia/Dubai';

        $search = trim((string)$request->input('search', ''));
        $referenceNo = trim((string)$request->input('reference_no', ''));
        $candidate = trim((string)$request->input('candidate_name', ''));
        $customer = trim((string)$request->input('customer_name', ''));
        $cl = trim((string)$request->input('cl_number', ''));
        $cn = trim((string)$request->input('cn_number', ''));
        $agreementNo = trim((string)$request->input('agreement_no', ''));
        $paymentMethod = trim((string)$request->input('payment_method', ''));

        [$dateFrom, $dateTo] = $this->normalizedDateRangeForRvoLike($request, $tz);

        $q = DB::table('payment_receipts')
            ->leftJoin('agreements as a', function ($j) use ($coll, $receiptAgreementRefCol, $hasReceiptCustomerId) {
                if ($hasReceiptCustomerId) {
                    $j->on(DB::raw("a.CL_Number COLLATE {$coll}"), '=', DB::raw("payment_receipts.customer_id COLLATE {$coll}"))
                      ->orOn(DB::raw("a.reference_no COLLATE {$coll}"), '=', DB::raw("payment_receipts.{$receiptAgreementRefCol} COLLATE {$coll}"));
                } else {
                    $j->on(DB::raw("a.reference_no COLLATE {$coll}"), '=', DB::raw("payment_receipts.{$receiptAgreementRefCol} COLLATE {$coll}"));
                }
            })
            ->leftJoin('crm as c', function ($j) use ($coll) {
                $j->on(DB::raw("c.CL_Number COLLATE {$coll}"), '=', DB::raw("a.CL_Number COLLATE {$coll}"));
            })
            ->select([
                'payment_receipts.id',
                'payment_receipts.receipt_no',
                'payment_receipts.reference_no',
                DB::raw("payment_receipts.{$receiptAgreementRefCol} as agreement_reference_no"),
                'payment_receipts.contract_reference_no',
                'payment_receipts.amount',
                'payment_receipts.currency',
                'payment_receipts.payment_method',
                'payment_receipts.payment_date',
                'payment_receipts.bank_name',
                'payment_receipts.iban',
                'payment_receipts.remarks',
                'payment_receipts.created_at',
                'a.reference_no as agreement_ref',
                'a.candidate_name as candidate_name',
                'a.passport_no as passport_no',
                'a.nationality as nationality',
                'a.foreign_partner as foreign_partner',
                'a.package as package',
                'a.CL_Number as CL_Number',
                'a.CN_Number as CN_Number',
                'c.first_name as customer_first_name',
                'c.last_name as customer_last_name',
                'c.mobile as customer_mobile'
            ])
            ->whereIn('a.package', $allowedPackages)
            ->when(in_array($activePackage, $allowedPackages, true), fn($x) => $x->where('a.package', $activePackage))
            ->when($dateFrom && $dateTo, fn($x) => $x->whereBetween('payment_receipts.payment_date', [$dateFrom, $dateTo]))
            ->when($referenceNo !== '', function ($x) use ($referenceNo) {
                $x->where(function ($w) use ($referenceNo) {
                    $w->where('payment_receipts.receipt_no', 'like', "{$referenceNo}%")
                      ->orWhere('payment_receipts.reference_no', 'like', "{$referenceNo}%")
                      ->orWhere('payment_receipts.contract_reference_no', 'like', "{$referenceNo}%");
                });
            })
            ->when($agreementNo !== '', fn($x) => $x->where("payment_receipts.{$receiptAgreementRefCol}", 'like', "{$agreementNo}%"))
            ->when($candidate !== '', fn($x) => $x->where('a.candidate_name', 'like', "{$candidate}%"))
            ->when($customer !== '', fn($x) => $x->whereRaw("CONCAT(IFNULL(c.first_name,''),' ',IFNULL(c.last_name,'')) like ?", ["%{$customer}%"]))
            ->when($cl !== '', fn($x) => $x->where('a.CL_Number', 'like', "{$cl}%"))
            ->when($cn !== '', fn($x) => $x->where('a.CN_Number', 'like', "{$cn}%"))
            ->when($paymentMethod !== '', fn($x) => $x->where('payment_receipts.payment_method', $paymentMethod))
            ->when($search !== '', function ($x) use ($search) {
                $x->where(function ($w) use ($search) {
                    $w->where('a.reference_no', 'like', "%{$search}%")
                      ->orWhere('a.candidate_name', 'like', "%{$search}%")
                      ->orWhere('a.passport_no', 'like', "%{$search}%")
                      ->orWhere('payment_receipts.receipt_no', 'like', "%{$search}%")
                      ->orWhere('payment_receipts.reference_no', 'like', "%{$search}%")
                      ->orWhere('payment_receipts.contract_reference_no', 'like', "%{$search}%")
                      ->orWhere('payment_receipts.bank_name', 'like', "%{$search}%")
                      ->orWhere('payment_receipts.iban', 'like', "%{$search}%")
                      ->orWhere('payment_receipts.remarks', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('payment_receipts.id');

        return $q;
    }

    private function buildRefundsQuery(Request $request, string $coll, string $activePackage, array $allowedPackages): \Illuminate\Database\Query\Builder
    {
        $tz = 'Asia/Dubai';

        $search        = trim((string) $request->input('search', ''));
        $referenceNo   = trim((string) $request->input('reference_no', ''));
        $candidate     = trim((string) $request->input('candidate_name', ''));
        $customer      = trim((string) $request->input('customer_name', ''));
        $cl            = trim((string) $request->input('cl_number', ''));
        $cn            = trim((string) $request->input('cn_number', ''));
        $agreementNo   = trim((string) $request->input('agreement_no', ''));
        $paymentMethod = trim((string) $request->input('payment_method', ''));
        [$dateFrom, $dateTo] = $this->normalizedDateRangeForRvoLike($request, $tz);

        $q = \Illuminate\Support\Facades\DB::table('refunds')
            ->leftJoin('agreements as a', function ($j) use ($coll) {
                $j->on(\Illuminate\Support\Facades\DB::raw("a.reference_no COLLATE {$coll}"), '=', \Illuminate\Support\Facades\DB::raw("refunds.agreement_no COLLATE {$coll}"));
            })
            ->leftJoin('crm as c', function ($j) use ($coll) {
                $j->on(\Illuminate\Support\Facades\DB::raw("c.CL_Number COLLATE {$coll}"), '=', \Illuminate\Support\Facades\DB::raw("a.CL_Number COLLATE {$coll}"));
            })
            ->select([
                'refunds.id',
                'refunds.candidate_id',
                'refunds.candidate_name',
                'refunds.sponsor_name',
                'refunds.passport_no',
                'refunds.nationality',
                'refunds.foreign_partner',
                'refunds.agreement_no',
                'refunds.contract_start_date',
                'refunds.contract_end_date',
                'refunds.return_date',
                'refunds.maid_worked_days',
                'refunds.contracted_amount',
                'refunds.salary',
                'refunds.worker_salary_for_work_days',
                'refunds.salary_payment_method',
                'refunds.payment_proof',
                'refunds.office_charges',
                'refunds.refunded_amount',
                'refunds.refund_date',
                'refunds.original_passport',
                'refunds.worker_belongings',
                'refunds.status',
                'refunds.sales_name',
                'refunds.updated_by_sales_name',
                'refunds.created_at',
                'refunds.updated_at',
                'a.reference_no as agreement_reference_no',
                'a.package as package',
                'a.CL_Number as CL_Number',
                'a.CN_Number as CN_Number',
                'c.first_name as customer_first_name',
                'c.last_name as customer_last_name',
                'c.mobile as customer_mobile',
            ])
            ->whereIn('a.package', $allowedPackages)
            ->when(in_array($activePackage, $allowedPackages, true), fn ($x) => $x->where('a.package', $activePackage))
            ->when($dateFrom && $dateTo, fn ($x) => $x->whereBetween('refunds.refund_date', [$dateFrom, $dateTo]))
            ->when($referenceNo !== '', function ($x) use ($referenceNo) {
                $x->where(function ($w) use ($referenceNo) {
                    $w->where('refunds.agreement_no', 'like', "{$referenceNo}%")
                      ->orWhere('refunds.candidate_id', 'like', "{$referenceNo}%")
                      ->orWhere('refunds.passport_no', 'like', "{$referenceNo}%");
                });
            })
            ->when($agreementNo !== '', fn ($x) => $x->where('refunds.agreement_no', 'like', "{$agreementNo}%"))
            ->when($candidate !== '', fn ($x) => $x->where('refunds.candidate_name', 'like', "{$candidate}%"))
            ->when($customer !== '', fn ($x) => $x->whereRaw("CONCAT(IFNULL(c.first_name,''),' ',IFNULL(c.last_name,'')) like ?", ["%{$customer}%"]))
            ->when($cl !== '', fn ($x) => $x->where('a.CL_Number', 'like', "{$cl}%"))
            ->when($cn !== '', fn ($x) => $x->where('a.CN_Number', 'like', "{$cn}%"))
            ->when($paymentMethod !== '', fn ($x) => $x->where('refunds.salary_payment_method', $paymentMethod))
            ->when($search !== '', function ($x) use ($search) {
                $x->where(function ($w) use ($search) {
                    $w->where('refunds.agreement_no', 'like', "%{$search}%")
                      ->orWhere('refunds.candidate_id', 'like', "%{$search}%")
                      ->orWhere('refunds.candidate_name', 'like', "%{$search}%")
                      ->orWhere('refunds.sponsor_name', 'like', "%{$search}%")
                      ->orWhere('refunds.passport_no', 'like', "%{$search}%")
                      ->orWhere('refunds.nationality', 'like', "%{$search}%")
                      ->orWhere('refunds.foreign_partner', 'like', "%{$search}%")
                      ->orWhere('refunds.sales_name', 'like', "%{$search}%")
                      ->orWhere('refunds.updated_by_sales_name', 'like', "%{$search}%")
                      ->orWhere('refunds.salary_payment_method', 'like', "%{$search}%")
                      ->orWhere('refunds.payment_proof', 'like', "%{$search}%")
                      ->orWhere('refunds.status', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('refunds.id');

        return $q;
    }


    private function exportQueryToExcel($query, array $headings, callable $map, string $prefix, string $tz)
    {
        $rows = $query->get()->map(fn($r) => $map($r))->toArray();
        $file = $prefix . Carbon::now($tz)->format('Ymd_His') . '.xlsx';

        return Excel::download(
            new class($rows, $headings) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\ShouldAutoSize {
                private array $rows;
                private array $headings;
                public function __construct(array $rows, array $headings) { $this->rows = $rows; $this->headings = $headings; }
                public function array(): array { return $this->rows; }
                public function headings(): array { return $this->headings; }
            },
            $file
        );
    }

    public function office(Request $request)
    {
        $request->merge(['status' => 'office', 'package' => $this->normalizePackage($request->input('package'))]);
        return $this->inside_employees($request);
    }

    public function contracted(Request $request)
    {
        $request->merge(['status' => 'trial', 'package' => $this->normalizePackage($request->input('package'))]);
        return $this->inside_employees($request);
    }

    public function incident(Request $request)
    {
        $request->merge(['status' => 'incident', 'package' => $this->normalizePackage($request->input('package'))]);
        return $this->inside_employees($request);
    }

    public function outside(Request $request)
    {
        $request->merge(['status' => 'outside', 'package' => $this->normalizePackage($request->input('package'))]);
        return $this->inside_employees($request);
    }

    public function receipts(Request $request)
    {
        $request->merge(['status' => 'receipt', 'package' => $this->normalizePackage($request->input('package'))]);
        return $this->inside_employees($request);
    }

    public function refunds(Request $request)
    {
        $request->merge(['status' => 'refund', 'package' => $this->normalizePackage($request->input('package'))]);
        return $this->inside_employees($request);
    }

    public function invoices(Request $request)
    {
        $tz = 'Asia/Dubai';
        $now = Carbon::now($tz)->format('l, F d, Y h:i A');

        $export = strtolower(trim((string) $request->input('export', '')));
        $search = trim((string) $request->input('search', ''));
        $reference_no = trim((string) $request->input('reference_no', ''));
        $candidate_name = trim((string) $request->input('candidate_name', ''));
        $customer_name = trim((string) $request->input('customer_name', ''));
        $cl_number = trim((string) $request->input('cl_number', ''));
        $cn_number = trim((string) $request->input('cn_number', ''));
        $agreement_no = trim((string) $request->input('agreement_no', ''));
        $status = trim((string) $request->input('status', ''));
        $payment_method = trim((string) $request->input('payment_method', ''));
        $package = $this->normalizePackage((string) $request->input('package', 'ALL'));

        [$date_from, $date_to] = $this->normalizedDateRangeForRvoLike($request, $tz);

        $allowedPackages = method_exists($this, 'receiptRefundPackages') ? $this->receiptRefundPackages() : ['PKG-1', 'PKG-2', 'PKG-3', 'PKG-4', 'PACKAGE 1', 'PACKAGE 2', 'PACKAGE 3', 'PACKAGE 4'];

        $query = Invoice::query()
            ->select([
                'invoices.*',
                'contracts.reference_no as contract_ref_no',
                'agreements.payment_cycle',
                'agreements.monthly_payment',
            ])
            ->leftJoin('contracts', 'contracts.agreement_reference_no', '=', 'invoices.agreement_reference_no')
            ->leftJoin('agreements', 'agreements.reference_no', '=', 'invoices.agreement_reference_no')
            ->whereIn('invoices.invoice_type', ['Tax'])
            ->whereIn('agreements.package', $allowedPackages)
            ->when(in_array($package, $allowedPackages, true), fn ($q) => $q->where('agreements.package', $package))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('invoices.invoice_number', 'like', "%{$search}%")
                        ->orWhere('contracts.reference_no', 'like', "%{$search}%")
                        ->orWhere('agreements.candidate_name', 'like', "%{$search}%")
                        ->orWhere('invoices.CL_Number', 'like', "%{$search}%")
                        ->orWhere('invoices.CN_Number', 'like', "%{$search}%")
                        ->orWhereHas('customer', fn ($c) => $c->whereRaw("CONCAT(first_name,' ',last_name) like ?", ["%{$search}%"]));
                });
            })
            ->when($reference_no !== '', fn ($q) => $q->where('invoices.invoice_number', 'like', "{$reference_no}%"))
            ->when($agreement_no !== '', fn ($q) => $q->where('invoices.agreement_reference_no', 'like', "{$agreement_no}%"))
            ->when($status !== '', fn ($q) => $q->where('invoices.status', $status))
            ->when($date_from && $date_to, fn ($q) => $q->whereBetween('invoices.invoice_date', [$date_from, $date_to]))
            ->when($customer_name !== '', fn ($q) => $q->whereHas('customer', fn ($c) => $c->whereRaw("CONCAT(first_name,' ',last_name) like ?", ["%{$customer_name}%"])))
            ->when($candidate_name !== '', fn ($q) => $q->where('agreements.candidate_name', 'like', "{$candidate_name}%"))
            ->when($cl_number !== '', fn ($q) => $q->where('invoices.CL_Number', 'like', "{$cl_number}%"))
            ->when($cn_number !== '', fn ($q) => $q->where('invoices.CN_Number', 'like', "{$cn_number}%"))
            ->when($payment_method !== '', fn ($q) => $q->where('invoices.payment_method', $payment_method))
            ->orderByDesc('invoices.invoice_id');

        if ($export === 'excel') {
            $headings = ['Invoice No', 'Agreement Ref', 'Contract Ref', 'Candidate', 'CL', 'CN', 'Amount', 'VAT', 'Total', 'Status', 'Method', 'Invoice Date', 'Due Date', 'Package'];

            return $this->exportQueryToExcel($query, $headings, function ($i) {
                return [
                    (string) ($i->invoice_number ?? ''),
                    (string) ($i->agreement_reference_no ?? ''),
                    (string) ($i->contract_ref_no ?? ''),
                    (string) ($i->candidate_name ?? ''),
                    (string) ($i->CL_Number ?? ''),
                    (string) ($i->CN_Number ?? ''),
                    (string) ($i->amount ?? ''),
                    (string) ($i->vat_amount ?? ''),
                    (string) ($i->total_amount ?? ''),
                    (string) ($i->status ?? ''),
                    (string) ($i->payment_method ?? ''),
                    (string) ($i->invoice_date ?? ''),
                    (string) ($i->due_date ?? ''),
                    (string) ($i->package ?? ''),
                ];
            }, 'invoices_', $this->tz ?? 'Asia/Dubai');
        }

        if ($export === 'pdf') {
            $headings = ['Invoice No', 'Agreement Ref', 'Contract Ref', 'Candidate', 'CL', 'CN', 'Amount', 'VAT', 'Total', 'Status', 'Method', 'Invoice Date', 'Due Date', 'Package'];

            $rows = $query->get()->map(function ($i) {
                return [
                    (string) ($i->invoice_number ?? ''),
                    (string) ($i->agreement_reference_no ?? ''),
                    (string) ($i->contract_ref_no ?? ''),
                    (string) ($i->candidate_name ?? ''),
                    (string) ($i->CL_Number ?? ''),
                    (string) ($i->CN_Number ?? ''),
                    (string) ($i->amount ?? ''),
                    (string) ($i->vat_amount ?? ''),
                    (string) ($i->total_amount ?? ''),
                    (string) ($i->status ?? ''),
                    (string) ($i->payment_method ?? ''),
                    (string) ($i->invoice_date ?? ''),
                    (string) ($i->due_date ?? ''),
                    (string) ($i->package ?? ''),
                ];
            })->toArray();

            $file = 'invoices_' . Carbon::now($tz)->format('Ymd_His') . '.pdf';

            return PDF::loadView('employee.exports.generic_pdf', [
                'title' => 'Invoices',
                'headings' => $headings,
                'rows' => $rows,
            ])->setPaper('a4', 'landscape')->download($file);
        }

        $invoices = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('employee.partials.invoice_table', compact('invoices'))->render(),
                'now' => $now,
                'count' => (int) $invoices->total(),
            ]);
        }

        return view('employee.inside_emp', compact(
            'invoices',
            'now',
            'reference_no',
            'candidate_name',
            'customer_name',
            'cl_number',
            'cn_number',
            'agreement_no',
            'status',
            'date_from',
            'date_to',
            'payment_method',
            'package',
            'search'
        ));
    }


    public function installmentInvoices(Request $request)
    {
        $tz = 'Asia/Dubai';
        $now = Carbon::now($tz)->format('l, F d, Y h:i A');

        $export = strtolower(trim((string)$request->input('export', '')));
        $search = $request->input('search');
        $reference_no = $request->input('reference_no');
        $candidate_name = $request->input('candidate_name');
        $customer_name = $request->input('customer_name');
        $cl_number = $request->input('cl_number');
        $cn_number = $request->input('cn_number');
        $agreement_no = $request->input('agreement_no');
        $status = $request->input('status');
        $payment_method = $request->input('payment_method');
        $package = $this->normalizePackage($request->input('package'));

        [$date_from,$date_to] = $this->normalizedDateRangeForRvoLike($request, $tz);

        $query = Invoice::select('invoices.*','contracts.reference_no as contract_ref_no','agreements.payment_cycle','agreements.monthly_payment')
            ->leftJoin('contracts','contracts.agreement_reference_no','=','invoices.agreement_reference_no')
            ->leftJoin('agreements','agreements.reference_no','=','invoices.agreement_reference_no')
            ->where('invoices.invoice_number','like','INV-INS-%')
            ->when($package !== 'ALL', fn($q) => $q->whereHas('agreement', fn($a) => $a->where('package', $package)))
            ->when($search, fn($q) => $q->where(function($q2) use ($search) {
                $q2->where('invoices.invoice_number','like',"%{$search}%")
                    ->orWhere('contracts.reference_no','like',"%{$search}%")
                    ->orWhereHas('agreement', fn($a) => $a->where('candidate_name','like',"%{$search}%"))
                    ->orWhereHas('customer', fn($c) => $c->whereRaw("CONCAT(first_name,' ',last_name) like ?",["%{$search}%"]))
                    ->orWhere('invoices.CL_Number','like',"%{$search}%")
                    ->orWhere('invoices.CN_Number','like',"%{$search}%");
            }))
            ->when($reference_no, fn($q) => $q->where('invoices.invoice_number','like',"{$reference_no}%"))
            ->when($agreement_no, fn($q) => $q->where('invoices.agreement_reference_no','like',"{$agreement_no}%"))
            ->when($status, fn($q) => $q->where('invoices.status',$status))
            ->when($date_from && $date_to, fn($q) => $q->whereBetween('invoices.invoice_date',[$date_from,$date_to]))
            ->when($customer_name, fn($q) => $q->whereHas('customer', fn($c) => $c->whereRaw("CONCAT(first_name,' ',last_name) like ?",["%{$customer_name}%"])))
            ->when($candidate_name, fn($q) => $q->whereHas('agreement', fn($a) => $a->where('candidate_name','like',"{$candidate_name}%")))
            ->when($cl_number, fn($q) => $q->where('invoices.CL_Number','like',"{$cl_number}%"))
            ->when($cn_number, fn($q) => $q->where('invoices.CN_Number','like',"{$cn_number}%"))
            ->when($payment_method, fn($q) => $q->where('invoices.payment_method',$payment_method))
            ->orderByDesc('invoices.invoice_number');

        if ($export === 'excel') {
            $headings = ['Invoice No','Agreement Ref','Contract Ref','Candidate','CL','CN','Amount','VAT','Total','Status','Method','Invoice Date','Due Date','Package'];
            return $this->exportQueryToExcel($query, $headings, function ($i) {
                $candidate = (string)optional($i->agreement)->candidate_name;
                $pkg = (string)optional($i->agreement)->package;
                return [
                    (string)($i->invoice_number ?? ''),
                    (string)($i->agreement_reference_no ?? ''),
                    (string)($i->contract_ref_no ?? ''),
                    $candidate,
                    (string)($i->CL_Number ?? ''),
                    (string)($i->CN_Number ?? ''),
                    (string)($i->amount ?? ''),
                    (string)($i->vat_amount ?? ''),
                    (string)($i->total_amount ?? ''),
                    (string)($i->status ?? ''),
                    (string)($i->payment_method ?? ''),
                    (string)($i->invoice_date ?? ''),
                    (string)($i->due_date ?? ''),
                    $pkg,
                ];
            }, 'instalments_', $tz);
        }

        if ($export === 'pdf') {
            $headings = ['Invoice No','Agreement Ref','Contract Ref','Candidate','CL','CN','Amount','VAT','Total','Status','Method','Invoice Date','Due Date','Package'];
            $rows = $query->get()->map(function ($i) {
                $candidate = (string)optional($i->agreement)->candidate_name;
                $pkg = (string)optional($i->agreement)->package;
                return [
                    (string)($i->invoice_number ?? ''),
                    (string)($i->agreement_reference_no ?? ''),
                    (string)($i->contract_ref_no ?? ''),
                    $candidate,
                    (string)($i->CL_Number ?? ''),
                    (string)($i->CN_Number ?? ''),
                    (string)($i->amount ?? ''),
                    (string)($i->vat_amount ?? ''),
                    (string)($i->total_amount ?? ''),
                    (string)($i->status ?? ''),
                    (string)($i->payment_method ?? ''),
                    (string)($i->invoice_date ?? ''),
                    (string)($i->due_date ?? ''),
                    $pkg,
                ];
            })->toArray();
            $file = 'instalments_' . Carbon::now($tz)->format('Ymd_His') . '.pdf';
            return PDF::loadView('employee.exports.generic_pdf', ['title' => 'Installments', 'headings' => $headings, 'rows' => $rows])->setPaper('a4','landscape')->download($file);
        }

        $invoices = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('employee.partials.invoice_table', compact('invoices'))->render(),
                'now'  => $now,
                'count' => (int)$invoices->total()
            ]);
        }

        return view('employee.inside_emp', compact('invoices','now','reference_no','candidate_name','customer_name','cl_number','cn_number','agreement_no','status','date_from','date_to','payment_method','package','search'));
    }

    public function payroll(Request $request)
    {
        $tz = 'Asia/Dubai';
        $now = Carbon::now($tz)->format('l, F d, Y h:i A');

        $export = strtolower(trim((string)$request->input('export', '')));
        $search = $request->input('search');
        $empRefNo = $request->input('reference_no');
        $candidateName = $request->input('candidate_name');
        $passportNumber = $request->input('passport_number');
        $package = $this->normalizePackage($request->input('package'));

        [$from,$to] = $this->normalizedDateRangeForPayroll($request, $tz);

        $from = $from ?: Carbon::now($tz)->startOfMonth()->toDateString();
        $to = $to ?: Carbon::now($tz)->toDateString();

        $data = $this->getLiveSalaryData($from, $to, $package);

        $filtered = collect($data['rows'])
            ->when($search, fn($c) => $c->filter(fn($r) =>
                str_contains((string)$r['emp_reference_no'], (string)$search) ||
                str_contains(strtolower((string)$r['candidate_name']), strtolower((string)$search)) ||
                str_contains((string)($r['passport_no'] ?? ''), (string)$search)
            ))
            ->when($empRefNo, fn($c) => $c->filter(fn($r) => str_starts_with((string)$r['emp_reference_no'], (string)$empRefNo)))
            ->when($candidateName, fn($c) => $c->filter(fn($r) => str_contains(strtolower((string)$r['candidate_name']), strtolower((string)$candidateName))))
            ->when($passportNumber, fn($c) => $c->filter(fn($r) => str_contains((string)($r['passport_no'] ?? ''), (string)$passportNumber)))
            ->values()
            ->all();

        $data['rows'] = $filtered;
        $data['totalEmployees'] = count($filtered);
        $data['totalPayable'] = collect($filtered)->sum('calculated');

        if ($export === 'excel') {
            $headings = ['Emp Ref','Candidate','Nationality','Passport','Contract No','Package','Start','End','Replacement Date','Duration','Calculated','Status'];
            $rows = collect($data['rows'])->map(fn($r) => [
                (string)($r['emp_reference_no'] ?? ''),
                (string)($r['candidate_name'] ?? ''),
                (string)($r['nationality'] ?? ''),
                (string)($r['passport_no'] ?? ''),
                (string)($r['contract_number'] ?? ''),
                (string)($r['package'] ?? ''),
                (string)($r['contract_start_date'] ?? ''),
                (string)($r['contract_end_date'] ?? ''),
                (string)($r['replacement_date'] ?? ''),
                (string)($r['duration'] ?? ''),
                (string)($r['calculated'] ?? ''),
                strip_tags((string)($r['status'] ?? '')),
            ])->toArray();

            $file = 'payroll_' . Carbon::now($tz)->format('Ymd_His') . '.xlsx';
            return Excel::download(
                new class($rows, $headings) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\ShouldAutoSize {
                    private array $rows;
                    private array $headings;
                    public function __construct(array $rows, array $headings) { $this->rows = $rows; $this->headings = $headings; }
                    public function array(): array { return $this->rows; }
                    public function headings(): array { return $this->headings; }
                },
                $file
            );
        }

        if ($export === 'pdf') {
            $headings = ['Emp Ref','Candidate','Nationality','Passport','Contract No','Package','Start','End','Replacement Date','Duration','Calculated','Status'];
            $rows = collect($data['rows'])->map(fn($r) => [
                (string)($r['emp_reference_no'] ?? ''),
                (string)($r['candidate_name'] ?? ''),
                (string)($r['nationality'] ?? ''),
                (string)($r['passport_no'] ?? ''),
                (string)($r['contract_number'] ?? ''),
                (string)($r['package'] ?? ''),
                (string)($r['contract_start_date'] ?? ''),
                (string)($r['contract_end_date'] ?? ''),
                (string)($r['replacement_date'] ?? ''),
                (string)($r['duration'] ?? ''),
                (string)($r['calculated'] ?? ''),
                strip_tags((string)($r['status'] ?? '')),
            ])->toArray();
            $file = 'payroll_' . Carbon::now($tz)->format('Ymd_His') . '.pdf';
            return PDF::loadView('employee.exports.generic_pdf', ['title' => 'Payroll', 'headings' => $headings, 'rows' => $rows])->setPaper('a4','landscape')->download($file);
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('employee.partials.live_salary', array_merge($data, compact('from','to')))->render(),
                'now'  => $now,
                'count' => (int)$data['totalEmployees']
            ]);
        }

        return view('employee.inside_emp', array_merge($data, compact('now','from','to','empRefNo','candidateName','passportNumber','package','search')));
    }

    private function getLiveSalaryData(string $from = null, string $to = null, ?string $package = null): array
    {
        $tz = 'Asia/Dubai';

        $fromDate = $from ? Carbon::parse($from, $tz)->startOfDay() : Carbon::now($tz)->startOfMonth()->startOfDay();
        $toDate   = $to   ? Carbon::parse($to,   $tz)->endOfDay()   : Carbon::now($tz)->endOfDay();

        $pkg = ($package && $package !== 'ALL') ? $package : null;

        $statusMap = [
            1 => ['Pending',     '<i class="fas fa-clock text-warning"></i>'],
            2 => ['Active',      '<i class="fas fa-circle-check text-success"></i>'],
            3 => ['Exceeded',    '<i class="fas fa-triangle-exclamation text-warning"></i>'],
            4 => ['Cancelled',   '<i class="fas fa-ban text-danger"></i>'],
            5 => ['Contracted',  '<i class="fas fa-file-signature text-primary"></i>'],
            6 => ['Rejected',    '<i class="fas fa-circle-xmark text-danger"></i>'],
        ];

        $contracts = Contract::with('replacementHistories')
            ->where('maid_delivered', 'Yes')
            ->when($pkg, fn($q) => $q->where('package', $pkg))
            ->orderByDesc('created_at')
            ->get();

        $contractNos = $contracts->pluck('reference_no');
        $replacementsBy = ReplacementHistory::whereIn('contract_number', $contractNos)
            ->orderBy('replacement_date')
            ->get()
            ->groupBy('contract_number');

        $rows = [];

        foreach ($contracts as $contract) {
            $salary = (float) $contract->salary;
            $contractStart = Carbon::parse($contract->contract_start_date, $tz)->addDay()->startOfDay();
            $contractEnd = Carbon::parse($contract->contract_end_date, $tz)->startOfDay();

            $periodStart = $contractStart->copy()->max($fromDate);
            $periodEnd = $contractEnd->copy()->min($toDate);

            if ($periodStart->gt($periodEnd)) {
                [$label, $icon] = $statusMap[$contract->status] ?? ['Unknown', ''];
                $rows[] = [
                    'emp_reference_no'    => $contract->emp_reference_no,
                    'candidate_name'      => $contract->candidate_name,
                    'nationality'         => $contract->nationality,
                    'passport_no'         => $contract->passport_no,
                    'contract_number'     => $contract->reference_no,
                    'package'             => $contract->package,
                    'contract_start_date' => $contract->contract_start_date,
                    'contract_end_date'   => $contract->contract_end_date,
                    'contract_created_at' => $contract->created_at->toDateTimeString(),
                    'contract_updated_at' => $contract->updated_at->toDateTimeString(),
                    'replacement_date'    => null,
                    'duration'            => '0 Days',
                    'calculated'          => 0.00,
                    'status'              => $icon . ' ' . $label,
                ];
                continue;
            }

            $history = $replacementsBy[$contract->reference_no] ?? collect();
            $segments = [];

            if ($contract->replacement && $history->isNotEmpty()) {
                $startDate = $periodStart->copy();
                foreach ($history as $item) {
                    $cutoff = Carbon::parse($item->replacement_date, $tz)->startOfDay();
                    if ($cutoff->lt($startDate)) continue;
                    if ($cutoff->gt($periodEnd)) break;
                    $segments[] = ['start' => $startDate->copy(), 'end' => $cutoff->copy(), 'repDate' => $cutoff->toDateString()];
                    $startDate = $cutoff->copy()->addDay();
                }
                if ($startDate->lte($periodEnd)) {
                    $segments[] = ['start' => $startDate->copy(), 'end' => $periodEnd->copy(), 'repDate' => null];
                }
            } else {
                $segments[] = ['start' => $periodStart->copy(), 'end' => $periodEnd->copy(), 'repDate' => null];
            }

            foreach ($segments as $segment) {
                $workedDays = $segment['start']->diffInDays($segment['end']) + 1;
                $cycleDays  = $segment['start']->month === 2 ? $segment['start']->daysInMonth : 30;
                $days       = (int) min($workedDays, $cycleDays);
                $amount     = round($salary / $cycleDays * $days, 2);
                [$label, $icon] = $statusMap[$contract->status] ?? ['Unknown', ''];

                $rows[] = [
                    'emp_reference_no'    => $contract->emp_reference_no,
                    'candidate_name'      => $segment['repDate'] ? $contract->replaced_by_name : $contract->candidate_name,
                    'nationality'         => $contract->nationality,
                    'passport_no'         => $contract->passport_no,
                    'contract_number'     => $contract->reference_no,
                    'package'             => $contract->package,
                    'contract_start_date' => $contract->contract_start_date,
                    'contract_end_date'   => $contract->contract_end_date,
                    'contract_created_at' => $contract->created_at->toDateTimeString(),
                    'contract_updated_at' => $contract->updated_at->toDateTimeString(),
                    'replacement_date'    => $segment['repDate'],
                    'duration'            => "{$days} Days",
                    'calculated'          => $amount,
                    'status'              => $icon . ' ' . $label,
                ];
            }
        }

        return [
            'rows'           => $rows,
            'totalEmployees' => count($rows),
            'totalPayable'   => collect($rows)->sum('calculated'),
        ];
    }

    public function getReplaced(Request $request)
    {
        $tz = 'Asia/Dubai';
        $now = Carbon::now($tz)->format('l, F d, Y h:i A');

        $export = strtolower(trim((string)$request->input('export', '')));
        $search = $request->input('search');
        $contractNumber = $request->input('contract_number');
        $referenceNo = $request->input('reference_no');
        $name = $request->input('name');
        $passportNo = $request->input('passport_no');
        $nationality = $request->input('nationality');
        $package = $this->normalizePackage($request->input('package'));

        $hasDateFilter = $request->filled('from') || $request->filled('to');

        $from = $hasDateFilter ? ($request->filled('from') ? Carbon::parse($request->input('from'))->format('Y-m-d') : '1970-01-01') : null;
        $to = $hasDateFilter ? ($request->filled('to') ? Carbon::parse($request->input('to'))->format('Y-m-d') : Carbon::now($tz)->toDateString()) : null;

        $query = ReplacementHistory::query()
            ->join('contracts', 'contracts.reference_no', '=', 'replacement_history.contract_number')
            ->with(['oldCandidate', 'newCandidate', 'client'])
            ->when($package !== 'ALL', fn($q) => $q->where('contracts.package', $package))
            ->when($search, fn($q) => $q->where(function($q2) use ($search) {
                $q2->where('replacement_history.contract_number', 'like', "%{$search}%")
                   ->orWhereHas('oldCandidate', fn($q3) =>
                       $q3->where('reference_no', 'like', "%{$search}%")
                          ->orWhere('name', 'like', "%{$search}%")
                          ->orWhere('passport_no', 'like', "%{$search}%")
                   )
                   ->orWhereHas('newCandidate', fn($q4) =>
                       $q4->where('reference_no', 'like', "%{$search}%")
                          ->orWhere('name', 'like', "%{$search}%")
                          ->orWhere('passport_no', 'like', "%{$search}%")
                   );
            }))
            ->when($contractNumber, fn($q) => $q->where('replacement_history.contract_number', 'like', "{$contractNumber}%"))
            ->when($referenceNo, fn($q) => $q->where(function($q2) use ($referenceNo) {
                $q2->whereHas('oldCandidate', fn($q3) => $q3->where('reference_no', 'like', "{$referenceNo}%"))
                   ->orWhereHas('newCandidate', fn($q4) => $q4->where('reference_no', 'like', "{$referenceNo}%"));
            }))
            ->when($name, fn($q) => $q->where(function($q2) use ($name) {
                $q2->whereHas('oldCandidate', fn($q3) => $q3->where('name', 'like', "%{$name}%"))
                   ->orWhereHas('newCandidate', fn($q4) => $q4->where('name', 'like', "%{$name}%"));
            }))
            ->when($passportNo, fn($q) => $q->where(function($q2) use ($passportNo) {
                $q2->whereHas('oldCandidate', fn($q3) => $q3->where('passport_no', 'like', "{$passportNo}%"))
                   ->orWhereHas('newCandidate', fn($q4) => $q4->where('passport_no', 'like', "{$passportNo}%"));
            }))
            ->when($nationality, fn($q) => $q->where(function($q2) use ($nationality) {
                $q2->whereHas('oldCandidate', fn($q3) => $q3->where('nationality', $nationality))
                   ->orWhereHas('newCandidate', fn($q4) => $q4->where('nationality', $nationality));
            }))
            ->when($hasDateFilter, fn($q) => $q->whereBetween('replacement_history.created_at', ["{$from} 00:00:00", "{$to} 23:59:59"]))
            ->orderByDesc('replacement_history.created_at')
            ->select('replacement_history.*');

        if ($export === 'excel') {
            $headings = ['Contract No','Old Ref','Old Name','Old Passport','New Ref','New Name','New Passport','Client','Replacement Date','Created'];
            return $this->exportQueryToExcel($query, $headings, function ($h) {
                $client = (string)optional($h->client)->first_name . ' ' . (string)optional($h->client)->last_name;
                return [
                    (string)($h->contract_number ?? ''),
                    (string)optional($h->oldCandidate)->reference_no,
                    (string)optional($h->oldCandidate)->name,
                    (string)optional($h->oldCandidate)->passport_no,
                    (string)optional($h->newCandidate)->reference_no,
                    (string)optional($h->newCandidate)->name,
                    (string)optional($h->newCandidate)->passport_no,
                    trim($client),
                    (string)($h->replacement_date ?? ''),
                    (string)($h->created_at ?? ''),
                ];
            }, 'replacements_', $tz);
        }

        if ($export === 'pdf') {
            $headings = ['Contract No','Old Ref','Old Name','Old Passport','New Ref','New Name','New Passport','Client','Replacement Date','Created'];
            $rows = $query->get()->map(function ($h) {
                $client = (string)optional($h->client)->first_name . ' ' . (string)optional($h->client)->last_name;
                return [
                    (string)($h->contract_number ?? ''),
                    (string)optional($h->oldCandidate)->reference_no,
                    (string)optional($h->oldCandidate)->name,
                    (string)optional($h->oldCandidate)->passport_no,
                    (string)optional($h->newCandidate)->reference_no,
                    (string)optional($h->newCandidate)->name,
                    (string)optional($h->newCandidate)->passport_no,
                    trim($client),
                    (string)($h->replacement_date ?? ''),
                    (string)($h->created_at ?? ''),
                ];
            })->toArray();
            $file = 'replacements_' . Carbon::now($tz)->format('Ymd_His') . '.pdf';
            return PDF::loadView('employee.exports.generic_pdf', ['title' => 'Replacements', 'headings' => $headings, 'rows' => $rows])->setPaper('a4','landscape')->download($file);
        }

        $histories = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('employee.partials.replacements_table', compact('histories'))->render(),
                'now'  => $now,
            ]);
        }

        return view('employee.inside_emp', compact('histories','now','search','contractNumber','referenceNo','name','passportNo','nationality','from','to'));
    }

    public function boa(Request $request)
    {
        $tz = 'Asia/Dubai';
        $now = Carbon::now($tz)->format('l, F d, Y h:i A');

        $export = strtolower(trim((string)$request->input('export', '')));
        $search = $request->input('search');
        $package = $this->normalizePackage($request->input('package'));

        $query = Agreement::with(['client','installments','contract'])
            ->where('agreement_type','BOA')
            ->when($package !== 'ALL', fn($q) => $q->where('package', $package))
            ->when($search, fn($q) => $q->where(function($q2) use ($search) {
                $q2->where('reference_no','like',"%{$search}%")
                    ->orWhere('candidate_name','like',"%{$search}%")
                    ->orWhereHas('client', fn($c) => $c->whereRaw("CONCAT(first_name,' ',last_name) like ?",["%{$search}%"]));
            }))
            ->orderByDesc('created_at');

        if ($export === 'excel') {
            $headings = ['Agreement Ref','Candidate','Passport','Nationality','Package','CL','CN','Created'];
            return $this->exportQueryToExcel($query, $headings, function ($a) {
                return [
                    (string)($a->reference_no ?? ''),
                    (string)($a->candidate_name ?? ''),
                    (string)($a->passport_no ?? ''),
                    (string)($a->nationality ?? ''),
                    (string)($a->package ?? ''),
                    (string)($a->CL_Number ?? ''),
                    (string)($a->CN_Number ?? ''),
                    (string)($a->created_at ?? ''),
                ];
            }, 'boa_', $tz);
        }

        if ($export === 'pdf') {
            $headings = ['Agreement Ref','Candidate','Passport','Nationality','Package','CL','CN','Created'];
            $rows = $query->get()->map(function ($a) {
                return [
                    (string)($a->reference_no ?? ''),
                    (string)($a->candidate_name ?? ''),
                    (string)($a->passport_no ?? ''),
                    (string)($a->nationality ?? ''),
                    (string)($a->package ?? ''),
                    (string)($a->CL_Number ?? ''),
                    (string)($a->CN_Number ?? ''),
                    (string)($a->created_at ?? ''),
                ];
            })->toArray();
            $file = 'boa_' . Carbon::now($tz)->format('Ymd_His') . '.pdf';
            return PDF::loadView('employee.exports.generic_pdf', ['title' => 'BOA', 'headings' => $headings, 'rows' => $rows])->setPaper('a4','landscape')->download($file);
        }

        $agreements = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json(['html'=>view('employee.partials.boa_table',compact('agreements'))->render(),'now'=>$now]);
        }

        return view('employee.inside_emp',compact('agreements','now'));
    }

    public function rvo(Request $request)
    {
        $tz = 'Asia/Dubai';
        $now = Carbon::now($tz)->format('l, F d, Y h:i A');

        $export = strtolower(trim((string) $request->input('export', '')));
        $search = trim((string) $request->input('search', ''));
        $package = $this->normalizePackage((string) ($request->input('package') ?? 'ALL'));
        if ($package === '') {
            $package = 'ALL';
        }

        $query = Invoice::with(['agreement'])
            ->where('invoice_type', 'Proforma')
            ->where('invoice_number', 'like', 'RVO-%')
            ->when($package !== 'ALL', fn ($q) => $q->whereHas('agreement', fn ($a) => $a->where('package', $package)))
            ->when($search !== '', fn ($q) => $q->where('invoice_number', 'like', "%{$search}%"))
            ->orderByDesc('invoice_id');

        if ($export === 'excel') {
            $headings = ['Invoice No', 'Agreement Ref', 'CL', 'CN', 'Amount', 'Status', 'Method', 'Invoice Date', 'Package'];
            return $this->exportQueryToExcel($query, $headings, function ($i) {
                $pkg = (string) optional($i->agreement)->package;
                return [
                    (string) ($i->invoice_number ?? ''),
                    (string) ($i->agreement_reference_no ?? ''),
                    (string) ($i->CL_Number ?? ''),
                    (string) ($i->CN_Number ?? ''),
                    (string) ($i->total_amount ?? $i->amount ?? ''),
                    (string) ($i->status ?? ''),
                    (string) ($i->payment_method ?? ''),
                    (string) ($i->invoice_date ?? ''),
                    $pkg,
                ];
            }, 'rvo_', $tz);
        }

        if ($export === 'pdf') {
            $headings = ['Invoice No', 'Agreement Ref', 'CL', 'CN', 'Amount', 'Status', 'Method', 'Invoice Date', 'Package'];
            $rows = $query->get()->map(function ($i) {
                $pkg = (string) optional($i->agreement)->package;
                return [
                    (string) ($i->invoice_number ?? ''),
                    (string) ($i->agreement_reference_no ?? ''),
                    (string) ($i->CL_Number ?? ''),
                    (string) ($i->CN_Number ?? ''),
                    (string) ($i->total_amount ?? $i->amount ?? ''),
                    (string) ($i->status ?? ''),
                    (string) ($i->payment_method ?? ''),
                    (string) ($i->invoice_date ?? ''),
                    $pkg,
                ];
            })->toArray();

            $file = 'rvo_' . Carbon::now($tz)->format('Ymd_His') . '.pdf';

            return PDF::loadView('employee.exports.generic_pdf', [
                'title' => 'RVO',
                'headings' => $headings,
                'rows' => $rows,
            ])->setPaper('a4', 'landscape')->download($file);
        }

        $rvo = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('employee.partials.rvo_table', ['invoices' => $rvo])->render(),
                'now' => $now,
                'count' => (int) $rvo->total(),
            ]);
        }

        return view('employee.inside_emp', [
            'invoices' => $rvo,
            'now' => $now,
            'package' => $package,
            'search' => $search,
        ]);
    }


    private function normalizePackage($value): string
    {
        $v = strtoupper(trim((string)$value));
        if ($v === 'ALL') return 'ALL';
        if ($v === '') return 'PKG-2';
        $map = [
            'PKG-2' => 'PKG-2',
            'PKG-3' => 'PKG-3',
            'PKG-4' => 'PKG-4',
            'PKG 2' => 'PKG-2',
            'PKG 3' => 'PKG-3',
            'PKG 4' => 'PKG-4',
            'PACKAGE 2' => 'PKG-2',
            'PACKAGE 3' => 'PKG-3',
            'PACKAGE 4' => 'PKG-4',
            '2' => 'PKG-2',
            '3' => 'PKG-3',
            '4' => 'PKG-4',
        ];
        return $map[$v] ?? 'PKG-2';
    }

    public function updateStatusInside(Request $request, $identifier)
    {
        $request->validate(['status_id'=>['required','in:1,2,3,4,5']]);
        $employee = Employee::where('passport_no',$identifier)->first();
        if(!$employee){
            return response()->json(['success'=>false,'message'=>'Employee not found.'],404);
        }
        $clients = Crm::all();
        $invoices = DB::table('invoices')
            ->join('agreements','invoices.agreement_reference_no','=','agreements.reference_no')
            ->where('agreements.candidate_id',$employee->id)
            ->whereIn('invoices.status',['Paid','Partially Paid','Cancelled'])
            ->select('invoices.*')
            ->orderByDesc('invoices.invoice_id')
            ->get();
        $remaining = $invoices->sum('total_amount') - $invoices->sum('received_amount');
        $details = [
            'candidateId'=>$employee->id,
            'referenceNo'=>$employee->reference_no,
            'arrivedDate'=>$employee->date_of_joining,
            'candidateName'=>$employee->name,
            'foreignPartner'=>$employee->foreign_partner,
            'nationality'=>$employee->nationality,
            'passportNo'=>$employee->passport_no,
            'passportExpiry'=>$employee->passport_expiry_date?->format('Y-m-d'),
            'dob'=>$employee->date_of_birth?->format('Y-m-d'),
            'invoices'=>$invoices,
            'remainingAmountWithVat'=>$remaining,
        ];
        switch($request->status_id){
            case 1:
                return response()->json(['success'=>true,'action'=>'open_modal','modal'=>'OfficeModal','candidateDetails'=>$details]);
            case 2:
                return response()->json(['success'=>true,'action'=>'open_modal','modal'=>'contractPanel','clients'=>$clients,'candidateDetails'=>$details]);
            case 3:
                return response()->json(['success'=>true,'action'=>'open_modal','modal'=>'incidentPanel','candidateDetails'=>$details]);
            case 4:
                return response()->json(['success'=>true,'message'=>'Outside status selected.']);
            case 5:
                return response()->json(['success'=>true,'action'=>'open_boa_modal','message'=>'BOA conversion pending.']);
            default:
                return response()->json(['success'=>false,'message'=>'Invalid status.'],400);
        }
    }

    public function cancellationRequests(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $count = 0;
        if($request->ajax()){
            return response()->json([
                'html'=>view('employee.partials.cancellation_requests_table',['requests'=>[]])->render(),
                'now'=>$now,
            ]);
        }
        return view('employee.inside_emp',compact('count','now'));
    }

    public function changeStatusOutside(Request $request, $identifier)
    {
        $employee = Employee::where('reference_no', $identifier)->first();
        if (! $employee) {
            return response()->json(['success'=>false,'message'=>'Employee not found.'], 404);
        }

        $employee->inside_status = 0;
        $employee->inside_country_or_outside = 1;
        $employee->save();

        return response()->json(['success'=>true,'message'=>'Status changed to Outside.']);
    }

    public function incidentSave(Request $request)
    {
        $validated = $request->validate([
            'employee_id'   => ['required', 'integer', Rule::exists('employees', 'id')],
            'incident_type' => ['required', 'string', 'max:100'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'comments'      => ['nullable', 'string', 'max:10000'],
        ]);

        $employee = Employee::findOrFail($validated['employee_id']);

        DB::transaction(function () use ($employee, $validated) {
            $employee->update([
                'incident_type' => $validated['incident_type'],
                'incident_date' => Carbon::parse($validated['incident_date'])->toDateString(),
                'comments'      => $validated['comments'] ?? null,
                'inside_status' => 3,
            ]);

            DB::table('office')
                ->where('candidate_id', $employee->id)
                ->where('type', 'employee')
                ->update(['status' => 0]);

            DB::table('trials')
                ->where('candidate_id', $employee->id)
                ->where('trial_type', 'employee')
                ->update(['trial_status' => 'Incident']);

            $agreement = Agreement::where('passport_no', $employee->passport_no)->first();

            if ($agreement) {
                $notesText = 'Incidented: ' . $validated['incident_type'];

                $agreement->update([
                    'status' => 4,
                    'notes'  => $notesText,
                ]);

                Contract::where('agreement_reference_no', $agreement->reference_no)
                    ->update([
                        'status'         => 4,
                        'cancelled_date' => Carbon::now(),
                        'remarks'        => $notesText,
                    ]);
            }
        });

        return response()->json(['message' => 'Incident saved successfully.']);
    }

    public function transferToEmployees(Request $request)
    {
        $packageId = (int) $request->input('package_id');
        $package   = Package::find($packageId);

        if (! $package) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Package does not exist.',
            ], 404);
        }

        if (! in_array($package->inside_status, [0, 1], true)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Package is already contracted and cannot be transferred.',
            ], 422);
        }

        try {
            $employee = DB::transaction(function () use ($package) {
                $lastRef = Employee::whereNotNull('reference_no')
                    ->lockForUpdate()
                    ->orderByDesc('id')
                    ->value('reference_no');

                $nextNum = $lastRef ? (int) substr($lastRef, 3) + 1 : 1;
                $newRef  = 'EM-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);

                $employee = Employee::create([
                    'reference_no'              => $newRef,
                    'package'                   => 'PKG-3',
                    'name'                      => $package->candidate_name,
                    'slug'                      => Str::slug($package->candidate_name),
                    'nationality'               => $package->nationality,
                    'passport_no'               => $package->passport_no,
                    'passport_expiry_date'      => $package->passport_expiry_date,
                    'date_of_birth'             => $package->date_of_birth,
                    'foreign_partner'           => $package->foreign_partner,
                    'visa_designation'          => $package->visa_type,
                    'current_status'            => 1,
                    'inside_status'             => 0,
                    'visa_status'               => 0,
                    'incident_type'             => $package->incident_type,
                    'incident_date'             => $package->incident_date,
                ]);

                if ($package->inside_status === 1) {
                    DB::table('office')
                        ->where('candidate_id', $package->id)
                        ->where('type', 'package')
                        ->delete();
                }

                $package->delete();
                return $employee;
            });

            return response()->json([
                'status'  => 'success',
                'message' => 'Package transferred successfully.',
                'data'    => ['employee' => $employee],
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Transfer failed.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    protected function resolveCandidate(Employee $employee)
    {
        $candidate = NewCandidate::with('attachments')
            ->where('passport_no', $employee->passport_no)
            ->first();

        return $candidate ?: $employee->load('attachments');
    }

    public function showCV(Employee $candidate)
    {
        $now = Carbon::now('Africa/Addis_Ababa')->format('l, F d, Y h:i A');
        $candidate = $this->resolveCandidate($candidate);

        return view('employee.cv', compact('candidate', 'now'));
    }

    public function downloadCV(Employee $candidate)
    {
        $candidate = $this->resolveCandidate($candidate);

        $serverName = $_SERVER['SERVER_NAME'] ?? 'default.domain.com';
        $subdomain  = explode('.', $serverName)[0];
        $headerFileName = strtolower($subdomain) . '_header.jpg';
        $footerFileName = strtolower($subdomain) . '_footer.jpg';
        $headerPath = public_path('assets/img/' . $headerFileName);
        $footerPath = public_path('assets/img/' . $footerFileName);
        $headerUrl  = file_exists($headerPath) ? asset('assets/img/' . $headerFileName) : null;
        $footerUrl  = file_exists($footerPath) ? asset('assets/img/' . $footerFileName) : null;

        $pdf = PDF::loadView('candidates.download_cv', compact('candidate'));
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
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function shareCV(Employee $candidate)
    {
        $resolved = $this->resolveCandidate($candidate);

        $name = $resolved->candidate_name ?? 'Unknown';
        $referenceNo = $candidate->reference_no ?? '00000';
        $serverName = $_SERVER['SERVER_NAME'] ?? 'default.domain.com';
        $downloadUrl = "https://{$serverName}/{$referenceNo}/download";

        $message = "🌸 *{$name}*'s CV 🌸\n\n" .
                   "🔗 {$downloadUrl}\n\n" .
                   "Have a nice day! 🍀";

        $whatsappUrl = "https://wa.me/?text=" . urlencode($message);
        return redirect()->away($whatsappUrl);
    }

    public function viewCV($reference_no)
    {
        $employee = Employee::where('reference_no', $reference_no)->firstOrFail();
        $candidate = $this->resolveCandidate($employee);

        return view('employee.view_cv', compact('candidate'));
    }

    public function UpdateofficeSave(Request $request)
    {
        $validated = $request->validate([
            'office_id'       => ['nullable', 'integer', 'exists:offices,id'],
            'candidate_id'    => ['required', 'integer', 'exists:employees,id'],
            'type'            => ['required', 'string', Rule::in(['employee'])],
            'category'        => ['required', 'string', Rule::in(['Sales Return','Trial Return','New Arrival','Unfit','Others'])],
            'returned_date'   => ['required', 'date'],
            'expiry_date'     => ['required', 'date'],
            'ica_proof'       => ['nullable', 'file', 'mimes:png,jpg,jpeg,pdf', 'max:20480'],
            'overstay_days'   => ['nullable', 'integer', 'min:0'],
            'fine_amount'     => ['nullable', 'numeric', 'min:0'],
            'passport_status' => ['required', 'string', Rule::in(['With Employer','With Candidate','Expired','Office','Lost','Other'])],
            'update_by'       => ['nullable', 'integer'],
        ]);

        return DB::transaction(function () use ($request, $validated) {

            $office = null;

            if (!empty($validated['office_id'])) {
                $office = Office::where('id', $validated['office_id'])->first();
            }

            if (!$office) {
                $office = Office::where('candidate_id', $validated['candidate_id'])
                    ->where('type', 'employee')
                    ->first();
            }

            if (!$office) {
                $office = new Office();
                $office->candidate_id = $validated['candidate_id'];
                $office->type = 'employee';
                $office->created_by = Auth::id();
            }

            $office->category        = $validated['category'];
            $office->returned_date   = Carbon::parse($validated['returned_date'])->startOfDay();
            $office->expiry_date     = Carbon::parse($validated['expiry_date'])->startOfDay();
            $office->passport_status = $validated['passport_status'];

            if ($request->hasFile('ica_proof')) {
                if (!empty($office->ica_proof) && Storage::disk('public')->exists($office->ica_proof)) {
                    Storage::disk('public')->delete($office->ica_proof);
                }
                $office->ica_proof = $request->file('ica_proof')->store('office_proofs', 'public');
            }

            $expiry = $office->expiry_date ?: null;
            $today  = Carbon::now()->startOfDay();
            $autoDays = ($expiry && $today->gt($expiry)) ? $expiry->diffInDays($today) : 0;

            $office->overstay_days = array_key_exists('overstay_days', $validated) && $validated['overstay_days'] !== null
                ? (int) $validated['overstay_days']
                : $autoDays;

            $office->fine_amount = array_key_exists('fine_amount', $validated) && $validated['fine_amount'] !== null
                ? (float) $validated['fine_amount']
                : ($office->overstay_days * 50);

            $office->status    = $office->status ?? 1;
            $office->update_by = $validated['update_by'] ?? Auth::id();
            $office->save();

            $agreements = Agreement::where('candidate_id', $office->candidate_id)->get();

            foreach ($agreements as $agreement) {
                $agreement->status = 4;
                $agreement->notes = $office->category;
                $agreement->save();

                Invoice::where('agreement_reference_no', $agreement->reference_no)->update([
                    'status' => 'Cancelled',
                    'notes'  => $office->category,
                ]);

                Contract::where('agreement_reference_no', $agreement->reference_no)->update([
                    'status'  => 4,
                    'remarks' => $office->category,
                ]);
            }

            return response()->json([
                'success'         => true,
                'message'         => 'Office details saved successfully.',
                'office_id'       => $office->id,
                'candidate_id'    => $office->candidate_id,
                'category'        => $office->category,
                'returned_date'   => optional($office->returned_date)->toDateString(),
                'expiry_date'     => optional($office->expiry_date)->toDateString(),
                'overstay_days'   => (int) $office->overstay_days,
                'fine_amount'     => (float) $office->fine_amount,
                'passport_status' => $office->passport_status,
                'ica_proof_url'   => $office->ica_proof ? Storage::disk('public')->url($office->ica_proof) : null,
            ]);
        });
    }

    // movement

    protected $acctInv;

    public function __construct(AccountInvoiceController $acctInv)
    {
        $this->acctInv = $acctInv;
    }

    public function boaProcess(string $reference_no)
    {
        $employee = Employee::where('reference_no', $reference_no)->first();

        if (! $employee) {
            abort(404, 'Employee not found');
        }

        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        $visaStages = EmployeeVisaStage::where('employee_id', $employee->id)
            ->orderBy('step_id')
            ->get();

        $newCandidate = NewCandidate::where('passport_no', $employee->passport_no)->first();

        return view('employee.boa_process', compact('employee', 'now', 'visaStages', 'newCandidate'));
    }

    protected function getBoaCandidate(string $reference_no): NewCandidate
    {
        $employee = Employee::where('reference_no', $reference_no)->firstOrFail();

        $candidate = NewCandidate::where('passport_no', $employee->passport_no)->first();

        if (! $candidate) {
            abort(404, 'NewCandidate not found for this employee');
        }

        return $candidate;
    }

    protected function boaJsonOrBack(Request $request, array $payload)
    {
        $ok = $payload['success'] ?? true;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($payload, $ok ? 200 : 500);
        }

        if ($ok) {
            return back()->with('success', $payload['message'] ?? 'Saved');
        }

        return back()->withErrors($payload['message'] ?? 'Something went wrong.');
    }

    protected function getForeignDatabaseName($foreignPartner)
    {
        $name = strtolower(explode(' ', (string) $foreignPartner)[0]);

        return match ($name) {
            'adey'           => 'adeyonesourceerp_new',
            'alkaba'         => 'alkabaonesourcee_new',
            'bmg'            => 'bmgonesourceerp_new',
            'middleeast'     => 'middleeastonesou_new',
            'my'             => 'myonesourceerp_new',
            'rozana'         => 'rozanaonesourcee_new',
            'tadbeeralebdaa' => 'tadbeeralebdaaon_new',
            'vienna'         => 'viennaonesourcee_new',
            'edith'          => 'edithonesource_new',
            'estella'        => 'estella_new',
            'ritemerit'      => 'ritemeritonesour_new',
            'khalid'         => 'khalidonesourcee_new',
            default          => '',
        };
    }

    protected function updateEmployeeStatusFromCandidate(NewCandidate $candidate): void
    {
        $employee = Employee::where('passport_no', $candidate->passport_no)->first();

        if ($employee) {
            $employee->current_status = $candidate->current_status;
            $employee->save();
        }
    }

    public function saveWc(Request $request, string $reference_no)
    {
        $request->validate([
            'wc_date'          => ['required', 'date'],
            'wc_dw_number'     => ['required', 'string', 'max:255'],
            'wc_contract_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10000'],
            'wc_remarks'       => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        $filePath = null;
        $fullPath = null;

        try {
            $candidate = $this->getBoaCandidate($reference_no);

            $formattedWcDate = Carbon::parse($request->wc_date)->format('Y-m-d');

            $candidate->wc_date        = $formattedWcDate;
            $candidate->wc_added_date  = Carbon::now('Asia/Dubai');
            $candidate->current_status = 5;
            $candidate->dw_number      = $request->wc_dw_number;
            $candidate->wc_date_remark = $request->wc_remarks;
            $candidate->save();

            if ($request->hasFile('wc_contract_file')) {
                $filePath = $request->file('wc_contract_file')->store('attachments', 'public');

                if (! $filePath) {
                    throw new \Exception('WC contract file upload failed.');
                }

                $fullPath = rtrim(config('app.url'), '/') . '/storage/' . $filePath;
            }

            $foreignPartner = $candidate->foreign_partner;
            $remoteDb       = $this->getForeignDatabaseName($foreignPartner);

            if ($remoteDb && array_key_exists($remoteDb, config('database.connections'))) {
                try {
                    $remoteUpdate = [
                        'wc_date'        => $formattedWcDate,
                        'wc_added_date'  => Carbon::now('Africa/Addis_Ababa')->format('Y-m-d'),
                        'current_status' => 5,
                        'dw_number'      => $candidate->dw_number,
                    ];

                    if ($fullPath) {
                        $remoteUpdate['wc_contract_file'] = $fullPath;
                    }

                    DB::connection($remoteDb)
                        ->table('candidates')
                        ->where('ref_no', $candidate->ref_no)
                        ->update($remoteUpdate);
                } catch (\Exception $e) {
                    Log::warning("Could not update remote DB [{$remoteDb}]: " . $e->getMessage());
                }
            }

            $existingAttachment = CandidateAttachment::where('candidate_id', $candidate->id)
                ->where('attachment_type', 'Work Contract')
                ->first();

            if ($existingAttachment) {
                if ($existingAttachment->attachment_file && Storage::disk('public')->exists($existingAttachment->attachment_file)) {
                    Storage::disk('public')->delete($existingAttachment->attachment_file);
                }
                $existingAttachment->delete();
            }

            CandidateAttachment::create([
                'candidate_id'    => $candidate->id,
                'attachment_type' => 'Work Contract',
                'attachment_name' => 'Work Contract',
                'attachment_file' => $filePath,
                'issued_on'       => Carbon::now('Asia/Dubai'),
                'created_by'      => auth()->id(),
            ]);

            $this->updateEmployeeStatusFromCandidate($candidate);

            DB::commit();

            return $this->boaJsonOrBack($request, [
                'success' => true,
                'message' => 'WC Date, status, and attachment updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return $this->boaJsonOrBack($request, [
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveIbv(Request $request, string $reference_no)
    {
        $request->validate([
            'ibv_date'    => ['required', 'date'],
            'ibv_reason'  => ['required', 'string'],
            'ibv_proof'   => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5000'],
            'ibv_remarks' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        $filePath = null;
        $remoteDb = null;

        try {
            $candidate = $this->getBoaCandidate($reference_no);

            if (! $candidate->wc_date) {
                throw new \Exception('Complete WC stage before recording Incident Before Visa.');
            }

            $formattedDate = Carbon::parse($request->ibv_date)->format('Y-m-d');

            $candidate->incident_before_visa_date   = $formattedDate;
            $candidate->incident_before_visa_remark = $request->ibv_remarks;
            $candidate->current_status              = 6;
            $candidate->save();

            $filePath = $request->file('ibv_proof')->store('incidents', 'public');

            if (! $filePath) {
                throw new \Exception('IBV proof file upload failed.');
            }

            $existingIncident = Incident::where('candidate_id', $candidate->id)
                ->where('incident_category', 'Incident Before Visa (IBV)')
                ->first();

            if ($existingIncident && $existingIncident->proof && Storage::disk('public')->exists($existingIncident->proof)) {
                Storage::disk('public')->delete($existingIncident->proof);
            }

            if ($existingIncident) {
                $existingIncident->delete();
            }

            Incident::create([
                'incident_category' => 'Incident Before Visa (IBV)',
                'candidate_id'      => $candidate->id,
                'candidate_name'    => $candidate->candidate_name,
                'employer_name'     => $candidate->foreign_partner,
                'reference_no'      => $candidate->reference_no,
                'ref_no'            => $candidate->ref_no,
                'nationality'       => $candidate->nationality,
                'country'           => 'Dubai',
                'company'           => 'Alebdaa',
                'branch'            => 'Alebdaa',
                'incident_reason'   => $request->ibv_reason,
                'other_reason'      => null,
                'incident_expiry_date' => null,
                'proof'             => $filePath,
                'note'              => $request->ibv_remarks,
                'created_by'        => auth()->id(),
            ]);

            $foreignPartner = $candidate->foreign_partner;
            $remoteDb       = $this->getForeignDatabaseName($foreignPartner);

            if ($remoteDb && array_key_exists($remoteDb, config('database.connections'))) {
                DB::connection($remoteDb)->beginTransaction();

                DB::connection($remoteDb)->table('candidates')
                    ->where('ref_no', $candidate->ref_no)
                    ->update([
                        'incident_before_visa_date' => Carbon::now('Africa/Addis_Ababa'),
                        'current_status'            => 6,
                    ]);

                DB::connection($remoteDb)->table('incidents')
                    ->where('candidate_id', $candidate->id)
                    ->where('incident_category', 'Incident Before Visa (IBV)')
                    ->delete();

                DB::connection($remoteDb)->table('incidents')->insert([
                    'incident_category' => 'Incident Before Visa (IBV)',
                    'candidate_id'      => $candidate->id,
                    'candidate_name'    => $candidate->candidate_name,
                    'reference_no'      => $candidate->reference_no,
                    'ref_no'            => $candidate->ref_no,
                    'country'           => 'Dubai',
                    'company'           => 'Alebdaa',
                    'branch'            => 'Alebdaa',
                    'incident_reason'   => $request->ibv_reason,
                    'other_reason'      => null,
                    'incident_expiry_date' => null,
                    'proof'             => $filePath,
                    'note'              => $request->ibv_remarks,
                    'created_by'        => auth()->id(),
                    'created_at'        => Carbon::now('Africa/Addis_Ababa'),
                    'updated_at'        => Carbon::now('Africa/Addis_Ababa'),
                ]);

                DB::connection($remoteDb)->commit();
            }

            $this->updateEmployeeStatusFromCandidate($candidate);

            DB::commit();

            return $this->boaJsonOrBack($request, [
                'success' => true,
                'message' => 'Incident Before Visa saved successfully in both databases.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            if ($remoteDb) {
                DB::connection($remoteDb)->rollBack();
            }

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return $this->boaJsonOrBack($request, [
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveVisa(Request $request, string $reference_no)
    {
        $request->validate([
            'visa_date'            => ['required', 'date'],
            'visa_number'          => ['nullable', 'string', 'max:255'],
            'visa_expiry_date'     => ['required', 'date'],
            'visa_uid_no'          => ['nullable', 'string', 'max:255'],
            'visa_entry_permit_no' => ['required', 'string', 'max:255'],
            'visa_copy_file'       => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5000'],
            'visa_remarks'         => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        $filePath = null;
        $fullUrl  = null;
        $remoteDb = null;

        try {
            $candidate = $this->getBoaCandidate($reference_no);

            if (! $candidate->wc_date) {
                throw new \Exception('Complete WC stage before saving Visa details.');
            }

            $formattedVisaDate       = Carbon::parse($request->visa_date)->format('Y-m-d');
            $formattedVisaExpiryDate = Carbon::parse($request->visa_expiry_date)->format('Y-m-d');

            $candidate->visa_date        = $formattedVisaDate;
            $candidate->visa_expiry_date = $formattedVisaExpiryDate;
            $candidate->visa_added_date  = Carbon::now('Asia/Dubai')->format('Y-m-d');
            $candidate->visa_number      = $request->visa_number;
            $candidate->entry_permit_number = $request->visa_entry_permit_no;
            $candidate->uid_number          = $request->visa_uid_no;
            $candidate->visa_date_remark    = $request->visa_remarks;
            $candidate->current_status      = 7;
            $candidate->save();

            $filePath = $request->file('visa_copy_file')->store('attachments', 'public');

            if (! $filePath) {
                throw new \Exception('Visa copy file upload failed.');
            }

            $fullUrl = rtrim(config('app.url'), '/') . '/storage/' . $filePath;

            $existingAttachment = CandidateAttachment::where('candidate_id', $candidate->id)
                ->where('attachment_type', 'Visa')
                ->where('attachment_number', $request->visa_number)
                ->first();

            if ($existingAttachment && Storage::disk('public')->exists($existingAttachment->attachment_file)) {
                Storage::disk('public')->delete($existingAttachment->attachment_file);
            }

            CandidateAttachment::updateOrCreate(
                [
                    'candidate_id'      => $candidate->id,
                    'attachment_type'   => 'Visa',
                    'attachment_name'   => 'Visa',
                    'attachment_number' => $request->visa_number,
                ],
                [
                    'attachment_file' => $filePath,
                    'issued_on'       => Carbon::now('Asia/Dubai')->format('Y-m-d'),
                    'created_by'      => auth()->id(),
                ]
            );

            $foreignPartner = $candidate->foreign_partner;
            $remoteDb       = $this->getForeignDatabaseName($foreignPartner);

            if (! $remoteDb || ! array_key_exists($remoteDb, config('database.connections'))) {
                throw new \Exception('Remote database not found.');
            }

            DB::connection($remoteDb)->beginTransaction();

            DB::connection($remoteDb)->table('candidates')
                ->where('ref_no', $candidate->ref_no)
                ->update([
                    'visa_date'       => $formattedVisaDate,
                    'visa_added_date' => Carbon::now('Africa/Addis_Ababa')->format('Y-m-d'),
                    'current_status'  => 7,
                    'visa_file'       => $fullUrl,
                ]);

            DB::connection($remoteDb)->commit();

            $this->updateEmployeeStatusFromCandidate($candidate);

            DB::commit();

            return $this->boaJsonOrBack($request, [
                'success' => true,
                'message' => 'Visa details updated successfully in both databases.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            if ($remoteDb) {
                DB::connection($remoteDb)->rollBack();
            }

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            Log::error('Failed to save VISA in BOA', [
                'error' => $e->getMessage(),
            ]);

            return $this->boaJsonOrBack($request, [
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveArrival(Request $request, string $reference_no)
    {
        $request->validate([
            'arrival_date'                => ['required', 'date'],
            'arrival_passport_stamp_file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5000'],
            'arrival_remarks'             => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        $filePath = null;
        $remoteDb = null;

        try {
            $candidate = $this->getBoaCandidate($reference_no);

            if (! $candidate->visa_date) {
                throw new \Exception('Complete Visa stage before saving Arrival.');
            }

            $arrivedDate = Carbon::parse($request->arrival_date)->format('Y-m-d');

            $filePath = $request->file('arrival_passport_stamp_file')->store('attachments', 'public');

            if (! $filePath) {
                throw new \Exception('Arrival passport stamp upload failed.');
            }

            $candidate->arrived_date                  = $arrivedDate;
            $candidate->arrived_added_date            = Carbon::now('Asia/Dubai');
            $candidate->updateArrivedDateModalremarks = $request->arrival_remarks;
            $candidate->current_status                = 15;
            $candidate->save();

            $oldFile = CandidateAttachment::where([
                ['candidate_id',    '=', $candidate->id],
                ['attachment_type', '=', 'Passport with Immigration Stamp'],
                ['attachment_name', '=', 'Passport with Immigration Stamp'],
            ])->value('attachment_file');

            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            CandidateAttachment::updateOrCreate(
                [
                    'candidate_id'    => $candidate->id,
                    'attachment_type' => 'Passport with Immigration Stamp',
                    'attachment_name' => 'Passport with Immigration Stamp',
                ],
                [
                    'attachment_file' => $filePath,
                    'issued_on'       => Carbon::now('Asia/Dubai')->format('Y-m-d'),
                ]
            );

            $foreignPartner = $candidate->foreign_partner;
            $remoteDb       = $this->getForeignDatabaseName($foreignPartner);

            if (! $remoteDb || ! array_key_exists($remoteDb, config('database.connections'))) {
                throw new \Exception('Remote database not found.');
            }

            DB::connection($remoteDb)->beginTransaction();

            DB::connection($remoteDb)
                ->table('candidates')
                ->where('ref_no', $candidate->ref_no)
                ->update([
                    'current_status'     => 15,
                    'arrived_date'       => $arrivedDate,
                    'arrived_added_date' => Carbon::now('Asia/Dubai'),
                ]);

            DB::connection($remoteDb)->commit();

            $this->updateEmployeeStatusFromCandidate($candidate);

            DB::commit();

            return $this->boaJsonOrBack($request, [
                'success' => true,
                'message' => 'Arrival date updated in both databases.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            if ($remoteDb) {
                DB::connection($remoteDb)->rollBack();
            }

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            Log::error('Error updating arrival date (BOA)', [
                'message' => $e->getMessage(),
            ]);

            return $this->boaJsonOrBack($request, [
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveIaa(Request $request, string $reference_no)
    {
        $request->validate([
            'iaa_reason'  => ['required', 'string'],
            'iaa_proof'   => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5000'],
            'iaa_remarks' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        $filePath = null;
        $remoteDb = null;

        try {
            $candidate = $this->getBoaCandidate($reference_no);

            if (! $candidate->arrived_date) {
                throw new \Exception('Complete Arrival stage before recording Incident After Arrival.');
            }

            $filePath = $request->file('iaa_proof')->store('incidents', 'public');

            if (! $filePath) {
                throw new \Exception('IAA proof file upload failed.');
            }

            $candidate->incident_after_arrival_date   = Carbon::now('Asia/Dubai');
            $candidate->incident_after_arrival_remark = $request->iaa_remarks;
            $candidate->current_status                = 16;
            $candidate->save();

            Package::where('candidate_id', $candidate->id)->update(['current_status' => 16]);

            $existingLocalIncident = Incident::where('candidate_id', $candidate->id)
                ->where('incident_category', 'Incident After Arrival (IAA)')
                ->first();

            if ($existingLocalIncident) {
                if ($existingLocalIncident->proof && Storage::disk('public')->exists($existingLocalIncident->proof)) {
                    Storage::disk('public')->delete($existingLocalIncident->proof);
                }
                $existingLocalIncident->delete();
            }

            Incident::create([
                'incident_category' => 'Incident After Arrival (IAA)',
                'candidate_id'      => $candidate->id,
                'candidate_name'    => $candidate->candidate_name,
                'employer_name'     => $candidate->foreign_partner,
                'reference_no'      => $candidate->reference_no,
                'ref_no'            => $candidate->ref_no,
                'nationality'       => $candidate->nationality,
                'country'           => 'Dubai',
                'company'           => 'Alebdaa',
                'branch'            => 'Alebdaa',
                'incident_reason'   => $request->iaa_reason,
                'other_reason'      => null,
                'proof'             => $filePath,
                'note'              => $request->iaa_remarks,
                'created_by'        => auth()->id(),
            ]);

            $foreignPartner = $candidate->foreign_partner;
            $remoteDb       = $this->getForeignDatabaseName($foreignPartner);

            if (! $remoteDb || ! array_key_exists($remoteDb, config('database.connections'))) {
                throw new \Exception('Remote database not found.');
            }

            DB::connection($remoteDb)->beginTransaction();

            DB::connection($remoteDb)->table('incidents')
                ->where('candidate_id', $candidate->id)
                ->where('incident_category', 'Incident After Arrival (IAA)')
                ->delete();

            DB::connection($remoteDb)->table('incidents')->insert([
                'incident_category' => 'Incident After Arrival (IAA)',
                'candidate_id'      => $candidate->id,
                'candidate_name'    => $candidate->candidate_name,
                'reference_no'      => $candidate->reference_no,
                'ref_no'            => $candidate->ref_no,
                'country'           => 'Dubai',
                'company'           => 'Alebdaa',
                'branch'            => 'Alebdaa',
                'incident_reason'   => $request->iaa_reason,
                'other_reason'      => null,
                'proof'             => $filePath,
                'note'              => $request->iaa_remarks,
                'created_by'        => auth()->id(),
                'created_at'        => Carbon::now('Africa/Addis_Ababa'),
                'updated_at'        => Carbon::now('Africa/Addis_Ababa'),
            ]);

            DB::connection($remoteDb)->table('candidates')
                ->where('ref_no', $candidate->ref_no)
                ->update([
                    'incident_after_arrival_date' => Carbon::now('Africa/Addis_Ababa'),
                    'current_status'              => 16,
                ]);

            DB::connection($remoteDb)->commit();

            $this->updateEmployeeStatusFromCandidate($candidate);

            DB::commit();

            return $this->boaJsonOrBack($request, [
                'success' => true,
                'message' => 'Incident After Arrival saved successfully in both databases.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            if ($remoteDb) {
                DB::connection($remoteDb)->rollBack();
            }

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            Log::error('Failed to save Incident After Arrival (BOA)', [
                'error' => $e->getMessage(),
            ]);

            return $this->boaJsonOrBack($request, [
                'success' => false,
                'message' => 'Failed to save incident: ' . $e->getMessage(),
            ]);
        }
    }

    public function saveTransfer(Request $request, string $reference_no)
    {
        $request->validate([
            'transfer_date'    => ['required', 'date'],
            'transfer_remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $remoteDb = null;

        try {
            return DB::transaction(function () use ($request, $reference_no, &$remoteDb) {

                $candidate = $this->getBoaCandidate($reference_no);

                if (empty($candidate->arrived_date)) {
                    throw new \Exception('Complete Arrival stage before saving Transfer.');
                }

                $transferDate = Carbon::parse($request->transfer_date)->toDateString();

                $candidate->fill([
                    'transfer_date'        => $transferDate,
                    'transfer_added_date'  => Carbon::now('Asia/Dubai'),
                    'transfer_date_remark' => $request->transfer_remarks,
                    'current_status'       => 17,
                ])->save();

                Package::where('candidate_id', $candidate->id)->update([
                    'current_status' => 17,
                    'inside_status'  => 4,
                ]);

                $foreignPartner = $candidate->foreign_partner;
                $remoteDb = $this->getForeignDatabaseName($foreignPartner);

                if ($remoteDb && array_key_exists($remoteDb, config('database.connections'))) {
                    DB::connection($remoteDb)->transaction(function () use ($remoteDb, $candidate, $transferDate) {
                        DB::connection($remoteDb)->table('candidates')
                            ->where('ref_no', $candidate->ref_no)
                            ->update([
                                'transfer_date'       => $transferDate,
                                'transfer_added_date' => Carbon::now('Africa/Addis_Ababa'),
                                'current_status'      => 17,
                            ]);
                    });
                }

                $this->updateEmployeeStatusFromCandidate($candidate);

                return $this->boaJsonOrBack($request, [
                    'success' => true,
                    'message' => 'Transfer details saved successfully.',
                ]);
            });
        } catch (\Throwable $e) {
            return $this->boaJsonOrBack($request, [
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    protected function add_notification(array $data): void
    {
        DB::table('notifications')->insert($data);
    }


}
