<?php
    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\Storage;
    use App\Models\NewCandidate;
    use App\Models\Agreement;
    use App\Models\Payroll;
    use App\Models\CandidateAttachment;
    use App\Models\Experience;
    use App\Models\Branch;
    use App\Models\AppliedPosition;
    use App\Models\WorkSkill;
    use App\Models\EducationLevel;
    use App\Models\MaritalStatus;
    use App\Models\DesiredCountry;
    use App\Models\FraName;
    use App\Models\MedicalStatus;
    use App\Models\CocStatus;
    use App\Models\CurrentStatus;
    use App\Models\Nationality;
    use App\Models\CRM;
    use App\Models\User;
    use App\Models\Refund;
    use App\Models\Replacement;
    use App\Models\GovtTransactionInvoice;
    use App\Models\Trial;
    use App\Models\Office;
    use App\Models\Incident;
    use App\Models\Invoice;
    use App\Models\PaymentProof;
    use App\Models\JournalEntries;
    use App\Models\JournalEntryDetails;
    use App\Models\Notification;
    use App\Models\Package;
    use App\Models\PackageAttachment;
    use App\Models\Employee;
    use App\Models\EmployeeAttachment;
    use App\Models\Service;
    use App\Models\EmailSent;
    use App\Http\Controllers\AccountInvoiceController;
    use App\Exports\FilteredCandidatesExport;
    use Maatwebsite\Excel\Facades\Excel;
    use Carbon\Carbon;
    use App\Exports\PackagesExport;
    use App\Exports\TrialsExport;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
    use App\Http\Resources\NewCandidateResource;
    use App\Http\Resources\EmployeeResource;
    use App\Http\Resources\PackageResource;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Facades\Mail;
    use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

    class CandidateController extends Controller
    {
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

        public function index(Request $request)
        {
            $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

            $normalize = static fn($v) => mb_strtolower(trim((string) $v));

            $nameToId = CurrentStatus::query()
                ->pluck('id', 'status_name')
                ->mapWithKeys(static fn($id, $name) => [$normalize($name) => (int) $id])
                ->all();

            $nameToId['draft'] = 0;

            $idFor = static function ($statusName) use ($normalize, $nameToId): ?int {
                $k = $normalize($statusName);
                return $k !== '' ? ($nameToId[$k] ?? null) : null;
            };

            $onProcessNames = [
                'Selected',
                'WC-Date',
                'Incident Before Visa (IBV)',
                'Visa Date',
                'Incident After Visa (IAV)',
                'Medical Status',
                'COC-Status',
                'MoL Submitted Date',
                'MoL Issued Date',
                'Departure Date',
                'Incident After Departure (IAD)',
            ];

            $onProcessIds = array_values(array_filter(array_map($idFor, $onProcessNames), static fn($v) => $v !== null));

            $user = Auth::user();
            $userRole = $user->role;
            $userId = $user->id;

            $query = NewCandidate::with([
                'nationality',
                'appliedPosition',
                'educationLevel',
                'desiredCountry',
                'fraName',
                'medicalStatus',
                'cocStatus',
                'currentStatus',
                'creator',
                'maritalStatus',
                'attachments',
                'CandidatesExperience' => fn($q) => $q->where('experience_years', '>=', 1),
                'agreement',
                'agreement.client',
            ])->where('status', 1);

            $adminRoles = [
                'Admin',
                'Managing Director',
                'Marketing Manager',
                'Digital Marketing Specialist',
                'Digital Marketing Executive',
                'Photographer',
                'Operations Manager',
                'Operations Supervisor',
                'Contract Administrator',
                'Finance Officer',
                'Archive Clerk',
                'Sales Manager',
                'PRO',
            ];

            if (!in_array($userRole, $adminRoles, true)) {
                if (in_array($userRole, ['Sales Officer', 'Customer Services'], true)) {
                    $query->where(function ($q) use ($userId) {
                        $q->where('current_status', 1)
                            ->orWhere(function ($q2) use ($userId) {
                                $q2->where('sales_name', $userId)->where('current_status', '!=', 1);
                            });
                    });
                } elseif ($userRole === 'Sales Coordinator') {
                    $query->whereRaw('CAST(nationality AS SIGNED) = ?', [(int) $user->nationality]);
                } elseif ($userRole === 'Happiness Consultant') {
                    $query->whereIn('current_status', range(4, 12));
                } else {
                    $query->whereRaw('1 = 0');
                }
            }

            $filterRaw = $request->input('filter', 'all');
            $filter = $normalize($filterRaw);
            $subFilter = $request->filled('sub_filter') ? trim((string) $request->input('sub_filter')) : null;

            if ($filter !== 'all') {
                if ($filter === 'draft') {
                    $query->where('current_status', 0);
                } elseif ($filter === 'on-process') {
                    if ($subFilter) {
                        $sid = $idFor($subFilter);
                        $sid !== null ? $query->where('current_status', $sid) : $query->whereRaw('1 = 0');
                    } else {
                        $onProcessIds ? $query->whereIn('current_status', $onProcessIds) : $query->whereRaw('1 = 0');
                    }
                } else {
                    $sid = $idFor($filterRaw);
                    $sid !== null ? $query->where('current_status', $sid) : $query->whereRaw('1 = 0');
                }
            }

            if ($request->filled('current_status')) {
                $query->where('current_status', (int) $request->input('current_status'));
            }

            if ($request->filled('reference_no')) {
                $query->where('ref_no', 'like', '%' . $request->input('reference_no') . '%');
            }

            if ($request->filled('name')) {
                $query->where('candidate_name', 'like', '%' . $request->input('name') . '%');
            }

            if ($request->filled('passport_number')) {
                $query->where('passport_no', 'like', '%' . $request->input('passport_number') . '%');
            }

            if ($request->filled('nationality')) {
                $query->where('nationality', $request->input('nationality'));
            }

            if ($request->filled('package')) {
                $query->where('preferred_package', $request->input('package'));
            }

            if ($request->filled('education')) {
                $query->where('education_level', $request->input('education'));
            }

            if ($request->filled('skills')) {
                $query->where('work_skill', 'like', '%' . $request->input('skills') . '%');
            }

            if ($request->filled('religion')) {
                $query->where('religion', $request->input('religion'));
            }

            if ($request->filled('sales_name')) {
                $query->where('sales_name', $request->input('sales_name'));
            }

            if ($request->filled('age') && str_contains((string) $request->input('age'), '-')) {
                [$min, $max] = array_pad(explode('-', (string) $request->input('age'), 2), 2, null);
                $min = is_numeric($min) ? (int) $min : null;
                $max = is_numeric($max) ? (int) $max : null;

                if ($min !== null && $max !== null && $min <= $max) {
                    $fromDate = now()->subYears($max)->format('Y-m-d');
                    $toDate = now()->subYears($min)->format('Y-m-d');
                    $query->whereBetween('date_of_birth', [$fromDate, $toDate]);
                }
            }

            if ($request->filled('marital_status')) {
                $query->where('marital_status', $request->input('marital_status'));
            }

            if ($request->filled('experience')) {
                $exp = (string) $request->input('experience');
                if ($exp === 'Yes') {
                    $query->whereHas('CandidatesExperience', fn($q) => $q->where('experience_years', '>=', 1));
                } elseif ($exp === 'No') {
                    $query->whereDoesntHave('CandidatesExperience', fn($q) => $q->where('experience_years', '>=', 1));
                }
            }

            if ($request->filled('partners')) {
                $partners = strtoupper((string) $request->input('partners'));
                $query->whereRaw('SUBSTRING_INDEX(foreign_partner, " ", 1) = ?', [$partners]);
            }

            if ($request->filled('global_search')) {
                $term = trim((string) $request->input('global_search'));
                if ($term !== '') {
                    $query->where(function ($q) use ($term) {
                        $q->where('candidate_name', 'like', "%{$term}%")
                            ->orWhere('passport_no', 'like', "%{$term}%")
                            ->orWhere('ref_no', 'like', "%{$term}%");
                    });
                }
            }

            $sortColumn = ($filter === 'available') ? 'created_at' : 'updated_at';
            $query->orderByDesc($sortColumn)->orderByDesc('id');

            $candidates = $query->paginate(10)->withQueryString();

            $currentStatuses = CurrentStatus::all();
            $counts = [];
            $counts['all'] = \App\Providers\NewCandidateServiceProvider::getAllCount($user);

            foreach ($currentStatuses as $cs) {
                $counts[$cs->status_name] = \App\Providers\NewCandidateServiceProvider::getCandidatesCountByStatus($cs->status_name, $user);
            }

            $counts['Draft'] = NewCandidate::where('status', 1)->where('current_status', 0)->count();

            if ($request->ajax()) {
                $statusIdForView = $request->has('current_status_id') ? (int) $request->input('current_status_id') : null;

                if ($statusIdForView === null) {
                    $tabName = $request->filled('tab_name') ? (string) $request->input('tab_name') : ($subFilter ?: $filterRaw);
                    $statusIdForView = $idFor($tabName);
                }

                $view = 'candidates.partials.candidates_table';

                if ($statusIdForView !== null) {
                    $candidateView = 'candidates.partials.candidates_table_' . $statusIdForView;
                    if (view()->exists($candidateView)) {
                        $view = $candidateView;
                    }
                }

                return view($view, compact('candidates', 'currentStatuses'))->render();
            }

            $salesOfficers = User::where('role', 'Sales Officer')->get();
            $services = Service::all();

            return view('candidates.outside', [
                'now'              => $now,
                'services'         => $services,
                'candidates'       => $candidates,
                'nationalities'    => Nationality::all(),
                'appliedPositions' => AppliedPosition::all(),
                'workSkills'       => WorkSkill::all(),
                'educationLevels'  => EducationLevel::all(),
                'maritalStatuses'  => MaritalStatus::all(),
                'desiredCountries' => DesiredCountry::all(),
                'currentStatuses'  => $currentStatuses,
                'counts'           => $counts,
                'salesOfficers'    => $salesOfficers,
            ]);
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

        public function sendAlarm(Request $request)
        {
            $CN_Number = $request->input('CN_Number');
            $candidate = NewCandidate::where('CN_Number', $CN_Number)->first();

            if (!$candidate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Candidate not found.'
                ], 404);
            }

            if ($candidate->current_status != 5) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The current status of the candidate is not WC-Date.You cant send alram'
                ], 400);
            }

            $notificationData = [
                'role' => 'CHC',
                'user_id' => $candidate->sales_name,
                'reference_no' => $candidate->reference_no,
                'ref_no' => $candidate->ref_no,
                'title' => "Kind Alarm about $CN_Number",
                'message' => "This is a kind reminder for the $CN_Number. Please upload this candidate incident or visa.",
                'CL_Number' => $CN_Number,
                'CN_Number' => $CN_Number,
                'status' => 'Un Read',
                'filePath' => '',
                'created_at' => Carbon::now()
            ];

            $this->add_notification($notificationData);
            return response()->json([
                'status' => 'success',
                'message' => 'Alarm sent successfully.'
            ]);
        }

        public function inside(Request $request)
        {
            if ($request->input('export') === 'excel') {
                return $this->export($request);
            }

            $now          = \Carbon\Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
            $status       = (string) $request->input('status', 'all');
            $ref          = $request->input('reference_no');
            $name         = $request->input('candidate_name');
            $nationality  = $request->input('nationality');
            $package      = $request->input('package');
            $pass         = $request->input('passport_number');
            $search       = $request->input('global_search');
            $expiryOrder  = $request->input('expiry_order');
            $arrivalOrder = $request->input('arrival_order');
            $returnOrder  = $request->input('return_order');

            if ($status === 'inside') {
                $status = 'all';
            }

            $allowedStatuses = [
                'all', 'outside', 'office', 'trial', 'incident', 'contracts',
                'refund', 'replacement', 'remittance', 'salaries'
            ];
            $status = in_array($status, $allowedStatuses, true) ? $status : 'all';

            $partials = [
                'all'         => 'candidates.partials.package_table_inside',
                'outside'     => 'package.partials.outside_table',
                'office'      => 'package.partials.office_table',
                'trial'       => 'package.partials.trial_table',
                'incident'    => 'package.partials.incident_table',
                'contracts'   => 'package.partials.contracted_table',
                'refund'      => 'package.partials.refund_table',
                'replacement' => 'package.partials.replacement_table',
                'remittance'  => 'package.partials.remittance_table',
                'salaries'    => 'package.partials.salaries_table',
            ];
            $partial = $partials[$status] ?? $partials['all'];

            $collation = 'utf8mb4_general_ci';
            $like = static fn($v) => '%' . $v . '%';

            $counts = \Illuminate\Support\Facades\Cache::remember('inside_counts_v2', 300, function () {
                return [
                    'all'         => \App\Models\Package::count(),
                    'outside'     => \App\Models\Package::where('inside_country_or_outside', 1)->where('current_status', '>', 3)->count(),
                    'office'      => \App\Models\Package::where('inside_status', 1)->count(),
                    'trial'       => \App\Models\Package::where('inside_status', 2)->count(),
                    'incident'    => \App\Models\Package::where('inside_status', 5)->count(),
                    'contracts'   => \App\Models\Contract::where('package', 'PKG-1')->count(),
                    'refund'      => \App\Models\Refund::count(),
                    'replacement' => \App\Models\Replacement::count(),
                    'remittance'  => \App\Models\Remittance::count(),
                    'salaries'    => \App\Models\Salary::count(),
                ];
            });

            $lookups = \Illuminate\Support\Facades\Cache::remember('inside_lookups_v2', 3600, function () {
                return [
                    'services'         => \App\Models\Service::all(),
                    'nationalities'    => \App\Models\Nationality::all(),
                    'appliedPositions' => \App\Models\AppliedPosition::all(),
                    'workSkills'       => \App\Models\WorkSkill::all(),
                    'educationLevels'  => \App\Models\EducationLevel::all(),
                    'maritalStatuses'  => \App\Models\MaritalStatus::all(),
                    'desiredCountries' => \App\Models\DesiredCountry::all(),
                    'fraNames'         => \App\Models\FraName::all(),
                    'medicalStatuses'  => \App\Models\MedicalStatus::all(),
                    'cocStatuses'      => \App\Models\CocStatus::all(),
                    'currentStatuses'  => \App\Models\CurrentStatus::all(),
                    'visaStatuses'     => \Illuminate\Support\Facades\DB::table('visa_tracker_statuses')->get(),
                ];
            });

            $data = array_merge($lookups, [
                'now'    => $now,
                'counts' => $counts,
                'status' => $status,
            ]);

            $normalize = static function ($v) {
                $v = strtolower(trim((string)($v ?? 'pending')));
                if ($v === 'canceled') return 'cancelled';
                if ($v === 'partial paid' || $v === 'partialpaid') return 'partial_paid';
                if ($v === 'replace' || $v === 'raplaced') return 'replaced';
                return $v ?: 'pending';
            };

            $respond = function (array $payload) use ($request, $partial) {
                if ($request->ajax()) {
                    return response()->json([
                        'table' => view($partial, $payload)->render(),
                        'stats' => view('candidates.partials.inside_counts', $payload)->render(),
                    ]);
                }
                return view('candidates.inside', $payload);
            };

            if ($status === 'refund') {
                $q = \App\Models\Refund::query();

                if ($ref) {
                    $q->where(function ($w) use ($ref, $collation, $like) {
                        $w->whereRaw("refunds.agreement_no COLLATE {$collation} LIKE ?", [$like($ref)])
                          ->orWhereRaw("refunds.candidate_id LIKE ?", [$like($ref)]);
                    });
                }
                if ($name)        $q->whereRaw("refunds.candidate_name COLLATE {$collation} LIKE ?", [$like($name)]);
                if ($pass)        $q->whereRaw("refunds.passport_no COLLATE {$collation} LIKE ?", [$like($pass)]);
                if ($nationality) $q->whereRaw("refunds.nationality COLLATE {$collation} LIKE ?", [$like($nationality)]);
                if ($package)     $q->whereRaw("refunds.foreign_partner COLLATE {$collation} LIKE ?", [$like($package)]);

                if ($search) {
                    $param = $like($search);
                    $q->where(function ($w) use ($param, $collation) {
                        $w->whereRaw("refunds.candidate_name COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("refunds.sponsor_name COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("refunds.passport_no COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("refunds.nationality COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("refunds.foreign_partner COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("refunds.agreement_no COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("refunds.sales_name COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("refunds.updated_by_sales_name COLLATE {$collation} LIKE ?", [$param]);
                    });
                }

                $refunds = $q->orderByDesc('updated_at')->paginate(10)->withQueryString();

                $statsRaw = \App\Models\Refund::query()
                    ->selectRaw("status, COUNT(*) as c, COALESCE(SUM(COALESCE(refunded_amount,0)),0) as a")
                    ->groupBy('status')
                    ->get()
                    ->keyBy(fn ($r) => $normalize($r->status));

                $refundStatusStats = [
                    'pending'   => ['count' => (int)($statsRaw['pending']->c ?? 0),   'amount' => (float)($statsRaw['pending']->a ?? 0)],
                    'paid'      => ['count' => (int)($statsRaw['paid']->c ?? 0),      'amount' => (float)($statsRaw['paid']->a ?? 0)],
                    'replaced'  => ['count' => (int)($statsRaw['replaced']->c ?? 0),  'amount' => (float)($statsRaw['replaced']->a ?? 0)],
                    'cancelled' => ['count' => (int)($statsRaw['cancelled']->c ?? 0), 'amount' => (float)($statsRaw['cancelled']->a ?? 0)],
                ];

                return $respond(array_merge($data, [
                    'refunds'           => $refunds,
                    'refundStatusStats' => $refundStatusStats,
                    'packages'          => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
                ]));
            }

            if ($status === 'replacement') {
                $q = \App\Models\Replacement::query();

                if ($ref) {
                    $q->where(function ($w) use ($ref, $collation, $like) {
                        $w->whereRaw("replacements.agreement_no COLLATE {$collation} LIKE ?", [$like($ref)])
                          ->orWhereRaw("replacements.candidate_id LIKE ?", [$like($ref)]);
                    });
                }
                if ($name)        $q->whereRaw("replacements.candidate_name COLLATE {$collation} LIKE ?", [$like($name)]);
                if ($pass)        $q->whereRaw("replacements.passport_no COLLATE {$collation} LIKE ?", [$like($pass)]);
                if ($nationality) $q->whereRaw("replacements.nationality COLLATE {$collation} LIKE ?", [$like($nationality)]);
                if ($package)     $q->whereRaw("replacements.foreign_partner COLLATE {$collation} LIKE ?", [$like($package)]);

                if ($search) {
                    $param = $like($search);
                    $q->where(function ($w) use ($param, $collation) {
                        $w->whereRaw("replacements.candidate_name COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("replacements.sponsor_name COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("replacements.passport_no COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("replacements.nationality COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("replacements.foreign_partner COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("replacements.agreement_no COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("replacements.sales_name COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("replacements.updated_by_sales_name COLLATE {$collation} LIKE ?", [$param]);
                    });
                }

                $replacements = $q->orderByDesc('updated_at')->paginate(10)->withQueryString();

                $statsRaw = \App\Models\Replacement::query()
                    ->selectRaw("status, COUNT(*) as c, COALESCE(SUM(COALESCE(refunded_amount,0)),0) as a")
                    ->groupBy('status')
                    ->get()
                    ->keyBy(fn ($r) => $normalize($r->status));

                $replacementStatusStats = [
                    'pending'   => ['count' => (int)($statsRaw['pending']->c ?? 0),   'amount' => (float)($statsRaw['pending']->a ?? 0)],
                    'paid'      => ['count' => (int)($statsRaw['paid']->c ?? 0),      'amount' => (float)($statsRaw['paid']->a ?? 0)],
                    'replaced'  => ['count' => (int)($statsRaw['replaced']->c ?? 0),  'amount' => (float)($statsRaw['replaced']->a ?? 0)],
                    'cancelled' => ['count' => (int)($statsRaw['cancelled']->c ?? 0), 'amount' => (float)($statsRaw['cancelled']->a ?? 0)],
                ];

                return $respond(array_merge($data, [
                    'replacements'           => $replacements,
                    'replacementStatusStats' => $replacementStatusStats,
                    'packages'               => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
                ]));
            }

            if ($status === 'remittance') {
                $q = \App\Models\Remittance::query();

                if ($ref) {
                    $q->where(function ($w) use ($ref, $collation, $like) {
                        $w->whereRaw("remittances.candidate_id LIKE ?", [$like($ref)])
                          ->orWhereRaw("remittances.candidate_name COLLATE {$collation} LIKE ?", [$like($ref)])
                          ->orWhereRaw("remittances.passport_no COLLATE {$collation} LIKE ?", [$like($ref)]);
                    });
                }
                if ($name)        $q->whereRaw("remittances.candidate_name COLLATE {$collation} LIKE ?", [$like($name)]);
                if ($pass)        $q->whereRaw("remittances.passport_no COLLATE {$collation} LIKE ?", [$like($pass)]);
                if ($nationality) $q->whereRaw("remittances.nationality COLLATE {$collation} LIKE ?", [$like($nationality)]);
                if ($package)     $q->whereRaw("remittances.foreign_partner COLLATE {$collation} LIKE ?", [$like($package)]);

                if ($search) {
                    $param = $like($search);
                    $q->where(function ($w) use ($param, $collation) {
                        $w->whereRaw("remittances.candidate_name COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("remittances.passport_no COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("remittances.nationality COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("remittances.foreign_partner COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("remittances.sales_name COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("remittances.payment_method COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("remittances.status COLLATE {$collation} LIKE ?", [$param]);
                    });
                }

                $remittances = $q->orderByDesc('updated_at')->paginate(10)->withQueryString();

                $statsRaw = \App\Models\Remittance::query()
                    ->selectRaw("status, COUNT(*) as c, COALESCE(SUM(COALESCE(amount,0)),0) as a")
                    ->groupBy('status')
                    ->get()
                    ->keyBy(fn ($r) => $normalize($r->status));

                $remittanceStatusStats = [
                    'pending'      => ['count' => (int)($statsRaw['pending']->c ?? 0),      'amount' => (float)($statsRaw['pending']->a ?? 0)],
                    'paid'         => ['count' => (int)($statsRaw['paid']->c ?? 0),         'amount' => (float)($statsRaw['paid']->a ?? 0)],
                    'partial_paid' => ['count' => (int)($statsRaw['partial_paid']->c ?? 0), 'amount' => (float)($statsRaw['partial_paid']->a ?? 0)],
                ];

                return $respond(array_merge($data, [
                    'remittances'           => $remittances,
                    'remittanceStatusStats' => $remittanceStatusStats,
                    'packages'              => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
                ]));
            }

            if ($status === 'salaries') {
                $q = \App\Models\Salary::query();

                if ($ref) {
                    $q->where(function ($w) use ($ref, $collation, $like) {
                        $w->whereRaw("salaries.agreement_no COLLATE {$collation} LIKE ?", [$like($ref)])
                          ->orWhereRaw("salaries.candidate_id LIKE ?", [$like($ref)]);
                    });
                }
                if ($pass)        $q->whereRaw("salaries.passport_no COLLATE {$collation} LIKE ?", [$like($pass)]);
                if ($nationality) $q->whereRaw("salaries.nationality COLLATE {$collation} LIKE ?", [$like($nationality)]);
                if ($package)     $q->whereRaw("salaries.foreign_partner COLLATE {$collation} LIKE ?", [$like($package)]);

                if ($search) {
                    $param = $like($search);
                    $q->where(function ($w) use ($param, $collation) {
                        $w->whereRaw("salaries.passport_no COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("salaries.nationality COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("salaries.foreign_partner COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("salaries.agreement_no COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("salaries.sales_name COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("salaries.status COLLATE {$collation} LIKE ?", [$param]);
                    });
                }

                $salaries = $q->orderByDesc('updated_at')->paginate(10)->withQueryString();

                $statsRaw = \App\Models\Salary::query()
                    ->selectRaw("status, COUNT(*) as c, COALESCE(SUM(COALESCE(salary_for_work_days,0)),0) as a")
                    ->groupBy('status')
                    ->get()
                    ->keyBy(fn ($r) => $normalize($r->status));

                $salaryStatusStats = [
                    'pending'      => ['count' => (int)($statsRaw['pending']->c ?? 0),      'amount' => (float)($statsRaw['pending']->a ?? 0)],
                    'paid'         => ['count' => (int)($statsRaw['paid']->c ?? 0),         'amount' => (float)($statsRaw['paid']->a ?? 0)],
                    'partial_paid' => ['count' => (int)($statsRaw['partial_paid']->c ?? 0), 'amount' => (float)($statsRaw['partial_paid']->a ?? 0)],
                    'cancelled'    => ['count' => (int)($statsRaw['cancelled']->c ?? 0),    'amount' => (float)($statsRaw['cancelled']->a ?? 0)],
                ];

                return $respond(array_merge($data, [
                    'salaries'          => $salaries,
                    'salaryStatusStats' => $salaryStatusStats,
                    'packages'          => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
                ]));
            }

            if ($status === 'contracts') {
                $cq = \App\Models\Contract::query()->where('package', 'PKG-1');

                if ($ref) {
                    $cq->whereRaw("contracts.reference_no COLLATE {$collation} LIKE ?", [$like($ref)]);
                }

                if ($search) {
                    $param = $like($search);
                    $cq->where(function ($w) use ($param, $collation) {
                        $w->whereRaw("contracts.reference_no COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("contracts.status COLLATE {$collation} LIKE ?", [$param]);
                    });
                }

                $contracts = $cq->orderByDesc('reference_no')->paginate(10)->withQueryString();

                return $respond(array_merge($data, [
                    'contracts' => $contracts,
                    'packages'  => new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10),
                ]));
            }

            $applyPackageFilters = function ($q) use ($ref, $name, $pass, $nationality, $package, $search, $status, $collation, $like) {
                if ($ref)         $q->whereRaw("packages.CN_Number COLLATE {$collation} LIKE ?", [$like($ref)]);
                if ($name)        $q->whereRaw("packages.candidate_name COLLATE {$collation} LIKE ?", [$like($name)]);
                if ($pass)        $q->whereRaw("packages.passport_no COLLATE {$collation} LIKE ?", [$like($pass)]);
                if ($nationality) $q->whereRaw("packages.nationality COLLATE {$collation} LIKE ?", [$like($nationality)]);
                if ($package)     $q->whereRaw("packages.package COLLATE {$collation} LIKE ?", [$like($package)]);

                if ($search) {
                    $param = $like($search);
                    $q->where(function ($w) use ($param, $status, $collation) {
                        $w->whereRaw("packages.CN_Number COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("packages.candidate_name COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereRaw("packages.passport_no COLLATE {$collation} LIKE ?", [$param])
                          ->orWhereExists(function ($sub) use ($param, $collation) {
                              $sub->select(\Illuminate\Support\Facades\DB::raw(1))
                                  ->from('agreements')
                                  ->whereRaw("agreements.reference_no COLLATE {$collation} = packages.agreement_no COLLATE {$collation}")
                                  ->where(function ($a) use ($param, $collation) {
                                      $a->whereRaw("agreements.status COLLATE {$collation} LIKE ?", [$param])
                                        ->orWhereRaw("agreements.reference_no COLLATE {$collation} LIKE ?", [$param]);
                                  });
                          });

                        if ($status === 'office') {
                            $w->orWhereExists(function ($sub) use ($param, $collation) {
                                $sub->select(\Illuminate\Support\Facades\DB::raw(1))
                                    ->from('office')
                                    ->whereRaw("office.candidate_id = packages.id")
                                    ->where('office.type', 'package')
                                    ->where('office.status', 1)
                                    ->whereRaw("office.category COLLATE {$collation} LIKE ?", [$param]);
                            });
                        }

                        if ($status === 'trial') {
                            $w->orWhereExists(function ($sub) use ($param, $collation) {
                                $sub->select(\Illuminate\Support\Facades\DB::raw(1))
                                    ->from('trials')
                                    ->whereRaw("trials.candidate_id = packages.id")
                                    ->where('trials.trial_type', 'package')
                                    ->where(function ($t) use ($param, $collation) {
                                        $t->whereRaw("trials.reference_no COLLATE {$collation} LIKE ?", [$param])
                                          ->orWhereRaw("trials.CN_Number COLLATE {$collation} LIKE ?", [$param])
                                          ->orWhereRaw("trials.agreement_reference_no COLLATE {$collation} LIKE ?", [$param]);
                                    });
                            });
                        }
                    });
                }
            };

            $query = \App\Models\Package::query()
                ->with(['agreement'])
                ->select('packages.*');

            if ($status === 'outside') {
                $query->where('packages.inside_country_or_outside', 1)
                      ->where('packages.current_status', '>', 3);
            } elseif ($status === 'office') {
                $query->where('packages.inside_status', 1);
            } elseif ($status === 'trial') {
                $trialsMax = \Illuminate\Support\Facades\DB::table('trials')
                    ->select('candidate_id', \Illuminate\Support\Facades\DB::raw('MAX(updated_at) as max_updated_at'))
                    ->where('trial_type', 'package')
                    ->groupBy('candidate_id');

                $trialsLatest = \Illuminate\Support\Facades\DB::table('trials as t')
                    ->where('t.trial_type', 'package')
                    ->where('t.trial_status', 'Active')
                    ->joinSub($trialsMax, 'tx', function ($j) {
                        $j->on('tx.candidate_id', '=', 't.candidate_id')
                          ->on('tx.max_updated_at', '=', 't.updated_at');
                    })
                    ->select([
                        \Illuminate\Support\Facades\DB::raw('t.id as trial_id'),
                        't.candidate_id',
                        't.client_id',
                        't.trial_type',
                        't.trial_status',
                        't.reference_no',
                        't.CN_Number',
                        't.trial_start_date',
                        't.trial_end_date',
                        't.agreement_reference_no',
                        \Illuminate\Support\Facades\DB::raw('t.updated_at as trials_updated_at'),
                    ]);

                $query->joinSub($trialsLatest, 'trials', function ($j) {
                        $j->on('trials.candidate_id', '=', 'packages.id');
                    })
                    ->join('crm', 'trials.client_id', '=', 'crm.id')
                    ->where('packages.inside_status', 2)
                    ->addSelect([
                        'trials.*',
                        'crm.first_name',
                        'crm.last_name',
                        \Illuminate\Support\Facades\DB::raw('crm.CL_Number as crm_CL_Number'),
                        \Illuminate\Support\Facades\DB::raw('packages.id as candidate_id'),
                    ]);
            } elseif ($status === 'incident') {
                $query->where('packages.inside_status', 5);
            } elseif ($status === 'contracts') {
                $query->where('packages.inside_status', 6);
            }

            $applyPackageFilters($query);

            if ($status === 'office') {
                if (in_array($arrivalOrder, ['asc', 'desc'], true)) {
                    $query->orderBy('packages.arrived_date', $arrivalOrder);
                } else {
                    $query->orderByDesc('packages.updated_at');
                }
                $query->orderByDesc('packages.created_at');
            } elseif ($status === 'trial') {
                $query->orderByDesc('trials.agreement_reference_no')
                      ->orderByDesc('trials.trials_updated_at')
                      ->orderByDesc('packages.created_at');
            } elseif (in_array($status, ['incident', 'contracts'], true)) {
                $query->orderByDesc('packages.updated_at')->orderByDesc('packages.created_at');
            } else {
                $query->orderByDesc('packages.created_at');
            }

            $packages = $query->paginate(10)->withQueryString();

            $ids = $packages->getCollection()->pluck('id')->all();

            if (!empty($ids) && in_array($status, ['all', 'office'], true)) {
                $officeRows = \Illuminate\Support\Facades\DB::table('office as o')
                    ->select('o.candidate_id', 'o.category', 'o.returned_date', 'o.expiry_date', 'o.passport_status', 'o.updated_at')
                    ->where('o.type', 'package')
                    ->where('o.status', 1)
                    ->whereIn('o.candidate_id', $ids)
                    ->orderByDesc('o.updated_at')
                    ->get()
                    ->groupBy('candidate_id')
                    ->map(fn ($rows) => $rows->first());

                $packages->getCollection()->transform(function ($p) use ($officeRows) {
                    $o = $officeRows[$p->id] ?? null;
                    if ($o) {
                        $p->category = $o->category;
                        $p->returned_date = $o->returned_date;
                        $p->expiry_date = $o->expiry_date;
                        $p->passport_status = $o->passport_status;
                        $p->office_updated_at = $o->updated_at;
                    } else {
                        if (!isset($p->expiry_date)) $p->expiry_date = null;
                    }
                    return $p;
                });

                if ($status === 'office') {
                    $sorted = $packages->getCollection();

                    if (in_array($returnOrder, ['asc', 'desc'], true)) {
                        $sorted = $sorted->sortBy(fn ($x) => $x->returned_date ?? '', SORT_REGULAR, $returnOrder === 'desc')->values();
                    } elseif (in_array($expiryOrder, ['asc', 'desc'], true)) {
                        $sorted = $sorted->sortBy(fn ($x) => $x->expiry_date ?? '', SORT_REGULAR, $expiryOrder === 'desc')->values();
                    }

                    $packages->setCollection($sorted);
                }
            }

            return $respond(array_merge($data, [
                'packages' => $packages,
            ]));
        }

        private function export(Request $request)
        {
            $status      = $request->input('status','inside');
            $ref         = $request->input('reference_no');
            $name        = $request->input('candidate_name');
            $pass        = $request->input('passport_number');
            $nationality = $request->input('nationality');
            $package     = $request->input('package');
            $search      = $request->input('global_search');
            $expiry_order  = $request->input('expiry_order');
            $arrival_order = $request->input('arrival_order');
            $return_order  = $request->input('return_order');

            $status = in_array($status, ['inside','all','outside','office','trial','confirm','change-status','incident','contracts']) ? $status : 'inside';

            $applyFilters = function($q) use ($ref,$name,$pass,$nationality,$package,$search,$status){
                if ($ref)         $q->where('packages.CN_Number','like',"$ref%");
                if ($name)        $q->where(function($w) use ($name){ $w->where('packages.candidate_name','like',"$name%"); });
                if ($pass)        $q->where('packages.passport_no','like',"$pass%");
                if ($nationality) $q->where('packages.nationality','like',"$nationality%");
                if ($package)     $q->where('packages.package','like',"$package%");
                if ($search) {
                    $q->where(function($w) use($search,$status){
                        $w->where('packages.CN_Number','like',"%{$search}%")
                          ->orWhere('packages.candidate_name','like',"%{$search}%")
                          ->orWhere('packages.passport_no','like',"%{$search}%");
                        if ($status==='office') $w->orWhere('office.category','like',"%{$search}%");
                        if (in_array($status,['trial','confirm','change-status'])) {
                            $w->orWhere('trials.reference_no','like',"%{$search}%")
                              ->orWhere('trials.CN_Number','like',"%{$search}%");
                        }
                    });
                }
            };

            if (in_array($status,['trial','confirm','change-status'])) {
                $map = [
                    'trial'         => ['Active',2],
                    'confirm'       => ['Confirmed',3],
                    'change-status' => ['Change Status',4],
                ];
                [$trialState,$insideCode] = $map[$status];

                $trialsLatest = DB::table('trials as t')
                    ->where('t.trial_type','package')
                    ->where('t.trial_status',$trialState)
                    ->join(DB::raw('(select candidate_id, max(updated_at) as max_updated_at from trials where trial_type = "package" group by candidate_id) tx'),
                        function($j){ $j->on('tx.candidate_id','=','t.candidate_id')->on('tx.max_updated_at','=','t.updated_at'); })
                    ->select('t.*');

                $query = Package::query()
                    ->joinSub($trialsLatest,'trials',function($j){ $j->on('trials.candidate_id','=','packages.id'); })
                    ->where('packages.inside_status',$insideCode)
                    ->select('packages.*','trials.*');

                $applyFilters($query);
                $query->orderByDesc('trials.updated_at')->orderByDesc('packages.created_at');

                return Excel::download(
                    new TrialsExport($query->get(), $status),
                    "inside_{$status}_" . now()->format('Ymd_His') . ".xlsx"
                );
            }

            $query = Package::query()->select('packages.*');

            if ($status === 'outside') { 
                $query->where('packages.inside_country_or_outside', 1)->orderByDesc('packages.created_at'); 
            } elseif ($status === 'office') {
                $officeLatest = DB::table('office as o')
                    ->where('o.type','package')
                    ->where('o.status',1)
                    ->join(DB::raw('(select candidate_id, max(updated_at) as max_updated_at from office where type = "package" and status = 1 group by candidate_id) om'),
                        function($j){ $j->on('om.candidate_id','=','o.candidate_id')->on('om.max_updated_at','=','o.updated_at'); })
                    ->select('o.id','o.candidate_id','o.type','o.category','o.returned_date','o.expiry_date','o.ica_proof','o.overstay_days','o.fine_amount','o.passport_status','o.status','o.updated_at');

                $query->joinSub($officeLatest,'office',function($j){ $j->on('office.candidate_id','=','packages.id'); })
                      ->where('packages.inside_status',1)
                      ->addSelect('office.category','office.returned_date','office.expiry_date','office.passport_status','office.updated_at as office_updated_at');

                if (in_array($return_order,['asc','desc']))       $query->orderBy('office.returned_date',$return_order);
                elseif (in_array($expiry_order,['asc','desc']))   $query->orderBy('office.expiry_date',$expiry_order);
                elseif (in_array($arrival_order,['asc','desc']))  $query->orderBy('packages.arrived_date',$arrival_order);
                else                                              $query->orderByDesc('office.updated_at');
                $query->orderByDesc('packages.created_at');
            } elseif ($status === 'incident') {
                $query->where('packages.inside_status',5)->orderByDesc('packages.updated_at')->orderByDesc('packages.created_at');
            } elseif ($status === 'contracts') {
                $query->where('packages.inside_status',6)->orderByDesc('packages.updated_at')->orderByDesc('packages.created_at');
            } else {
                $query->orderByDesc('packages.created_at');
            }

            $applyFilters($query);

            return Excel::download(
                new PackagesExport($query->get(), $status),
                "inside_{$status}_" . now()->format('Ymd_His') . ".xlsx"
            );
        }

        public function trial(Request $request)
        {
            $now    = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
            $type   = $request->input('type');
            $status = $request->input('status');

            $query = Trial::with('client')->orderByDesc('updated_at');

            if ($type === 'employee') {
                $query->where('trial_type', 'employee');
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
                case 'change_status':
                    $query->where('trial_status', 'Change Status');
                    break;
            }

            $trials = $query->paginate(10);

            if ($request->ajax()) {
                return view('candidates.partials.trial_candidates_table', compact('trials', 'now'));
            }

            return view('candidates.index', compact('trials', 'now'));
        }

        public function show(NewCandidate $candidate)
        {
            $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
            $user = Auth::user();
            $candidate->load([
                'nationality', 'appliedPosition', 'educationLevel', 'desiredCountry',
                'fraName', 'medicalStatus', 'cocStatus', 'currentStatus'
            ]);

            $nationalities = Nationality::all();
            $appliedPositions = AppliedPosition::all();
            $workSkills = WorkSkill::all();
            $educationLevels = EducationLevel::all();
            $maritalStatuses = MaritalStatus::all();
            $desiredCountries = DesiredCountry::all();
            $fraNames = FraName::all();
            $medicalStatuses = MedicalStatus::all();
            $cocStatuses = CocStatus::all();
            $currentStatuses = CurrentStatus::all();
            return view('candidates.show', compact(
                'candidate', 'now', 'nationalities',
                'appliedPositions', 'educationLevels', 'maritalStatuses',
                'desiredCountries', 'fraNames', 'medicalStatuses', 'cocStatuses', 'currentStatuses'
            ));
        }

        public function wc_contract(NewCandidate $candidate)
        {
            $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
            $user = Auth::user();
            $candidate->load([
                'nationality', 'appliedPosition', 'educationLevel', 'desiredCountry',
                'fraName', 'medicalStatus', 'cocStatus', 'currentStatus'
            ]);

            $nationalities = Nationality::all();
            $appliedPositions = AppliedPosition::all();
            $workSkills = WorkSkill::all();
            $educationLevels = EducationLevel::all();
            $maritalStatuses = MaritalStatus::all();
            $desiredCountries = DesiredCountry::all();
            $fraNames = FraName::all();
            $medicalStatuses = MedicalStatus::all();
            $cocStatuses = CocStatus::all();
            $currentStatuses = CurrentStatus::all();

            return view('candidates.wc_contract', compact(
                'candidate', 'now', 'nationalities',
                'appliedPositions', 'educationLevels', 'maritalStatuses',
                'desiredCountries', 'fraNames', 'medicalStatuses', 'cocStatuses', 'currentStatuses'
            ));
        }

        public function edit(NewCandidate $candidate)
        {
            $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
            $user = Auth::user();
            $nationalities = Nationality::all();
            $appliedPositions = AppliedPosition::all();
            $workSkills = WorkSkill::all();
            $educationLevels = EducationLevel::all();
            $maritalStatuses = MaritalStatus::all();
            $desiredCountries = DesiredCountry::all();
            $fraNames = FraName::all();
            $medicalStatuses = MedicalStatus::all();
            $cocStatuses = CocStatus::all();
            $currentStatuses = CurrentStatus::all();
            return view('candidates.edit', compact('candidate', 'now','nationalities','appliedPositions','educationLevels', 'maritalStatuses','desiredCountries', 'fraNames', 'medicalStatuses', 'cocStatuses', 'currentStatuses'
            ));
        }

        public function wc_contract_pdf(NewCandidate $candidate, Request $request, $action = 'view')
        {
            if (empty($candidate->reference_no)) {
                abort(404, 'Reference number not found.');
            }

            $serverName = $_SERVER['SERVER_NAME'];
            $subdomain = explode('.', $serverName)[0];
            $headerFile = public_path('images/' . strtolower($subdomain) . '_header.jpg');
            $footerFile = public_path('images/' . strtolower($subdomain) . '_footer.jpg');
            $now = Carbon::now('Asia/Dubai')->format('d M Y h:i A');

            $candidate->load([
                'nationality', 'appliedPosition', 'educationLevel', 'desiredCountry',
                'fraName', 'medicalStatus', 'cocStatus', 'currentStatus'
            ]);

            $html = view('candidates.wc_contract_pdf', compact('candidate', 'now'))->render();
            if (empty($html)) {
                abort(500, 'Failed to generate the PDF content.');
            }

            $tempDir = storage_path('app/mpdf');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $mpdf = new Mpdf([
                'tempDir' => $tempDir,
                'fontDir' => [resource_path('fonts')],
                'fontdata' => [
                    'amiri' => [
                        'R' => 'amiri-regular.ttf',
                        'B' => 'amiri-bold.ttf',
                        'useOTL' => 0xFF,
                        'useKashida' => 75,
                    ],
                ],
                'default_font' => 'amiri',
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_top' => 30,
                'margin_bottom' => 30,
                'margin_left' => 10,
                'margin_right' => 10,
            ]);

            $mpdf->SetDirectionality('rtl');
            $mpdf->SetHTMLHeader('<img src="' . $headerFile . '" width="100%" />');
            $mpdf->SetHTMLFooter('<img src="' . $footerFile . '" width="100%" /><div style="text-align: right; font-size: 10px;">Page {PAGENO} of {nbpg}</div>');
            
            $mpdf->WriteHTML($html);
            $filename = 'wc_contract_' . $candidate->reference_no . '.pdf';
            
            return $action === 'download'
                ? response($mpdf->Output($filename, 'D'))->header('Content-Type', 'application/pdf')
                : response($mpdf->Output($filename, 'I'))->header('Content-Type', 'application/pdf');
        }

        public function update(Request $request, Candidate $candidate)
        {
            $request->validate([
                'cc_name' => 'required|string|max:255',
                'passport_number' => 'required|string|max:255|unique:candidates,passport_number,' . $candidate->id,
                'passport_expiry_date' => 'required|date',
                'nationality' => 'required|exists:nationalities,id',
            ]);

            $candidate->fill($request->all());
            $candidate->save();

            return redirect()->route('candidates.index')
                ->with('success', 'Candidate updated successfully.');
        }

        public function destroy(NewCandidate $candidate)
        {

            // try {
            //     $refNo = $candidate->ref_no;
            //     $foreignPartner = $candidate->foreign_partner;
            //     $remoteDb = $this->getForeignDatabaseName($foreignPartner);

            //     if ($remoteDb) {
            //         $remoteCandidate = DB::connection($remoteDb)
            //             ->table('candidates')
            //             ->where('ref_no', $refNo)
            //             ->first();

            //         if ($remoteCandidate) {
            //             $remoteCandidateId = $remoteCandidate->id;

            //             DB::connection($remoteDb)
            //                 ->table('candidates')
            //                 ->where('ref_no', $refNo)
            //                 ->delete();

            //             $remoteAttachments = DB::connection($remoteDb)
            //                 ->table('candidate_attachments')
            //                 ->where('candidate_id', $remoteCandidateId)
            //                 ->get();

            //             foreach ($remoteAttachments as $attachment) {
            //                 $remoteFilePath = $attachment->file_path;
            //                 if ($remoteFilePath && Storage::disk('remote')->exists($remoteFilePath)) {
            //                     Storage::disk('remote')->delete($remoteFilePath);
            //                 }
            //             }
            //         }
            //     }

            //     $localAttachments = $candidate->attachments;
            //     foreach ($localAttachments as $attachment) {
            //         $localFilePath = $attachment->file_path;
            //         if ($localFilePath && Storage::exists($localFilePath)) {
            //             Storage::delete($localFilePath);
            //         }
            //     }

            //     $candidate->delete();

            //     return redirect()->route('candidates.index')
            //         ->with('success', 'Candidate deleted successfully along with related records and files.');
            // } catch (\Exception $e) {
            //     return redirect()->route('candidates.index')
            //         ->with('error', 'An error occurred while deleting the candidate: ' . $e->getMessage());
            // }
        }

        public function showCsvUploadForm()
        {
            return view('candidates.upload_csv');
        }

        public function uploadCsv(Request $request)
        {
            $request->validate([
                'csv_file' => 'required|mimes:csv,txt|max:5000',
            ]);

            return redirect()->route('candidates.index')->with('success', 'CSV file uploaded successfully.');
        }

        public function getFraNames($countryId)
        {
            $fraNames = FraName::where('country_id', $countryId)->get();
            return response()->json($fraNames);
        }

        public function updateStatus(Request $request, int $candidateId)
        {
            $request->validate([
                'status_id' => 'required|exists:current_statuses,id',
            ]);

            $candidate = NewCandidate::findOrFail($candidateId);
            $clients = CRM::select('id', 'first_name', 'last_name', 'emirates_id')->get();

            $host = strtolower($request->getHost());
            $hostToConnection = [
                'rozana.onesourceerp.com' => 'rozanaonesourcee_new',
                'vienna.onesourceerp.com' => 'viennaonesourcee_new',
                'middleeast.onesourceerp.com' => 'middleeastonesou_new',
                'alanbar.onesourceerp.com' => 'alanbaronesource_new',
                'tadbeeralebdaa.onesourceerp.com' => 'tadbeeralebdaaon_new',
                'shaikhah.onesourceerp.com' => 'shaikhahonesourc_new',
            ];
            $primaryConnection = $hostToConnection[$host] ?? null;

            $dbConfigs = config('database.connections');
            $allTenantConnections = [];
            foreach ($hostToConnection as $h => $conn) {
                if (array_key_exists($conn, $dbConfigs)) {
                    $allTenantConnections[] = $conn;
                }
            }
            $allTenantConnections = array_values(array_unique($allTenantConnections));

            $otherConnections = array_values(array_filter($allTenantConnections, function ($c) use ($primaryConnection) {
                return $primaryConnection ? $c !== $primaryConnection : true;
            }));

            $foreignPartner = $candidate->foreign_partner;
            $remoteDb = $this->getForeignDatabaseName($foreignPartner);

            $resolveRemoteTable = function (?string $conn): ?string {
                if (!$conn) return null;
                $schema = DB::connection($conn)->getSchemaBuilder();
                if ($schema->hasTable('candidates')) return 'candidates';
                if ($schema->hasTable('new_candidates')) return 'new_candidates';
                return null;
            };

            $updateRemote = function (?string $conn, string $refNo, array $values) use ($resolveRemoteTable) {
                if (!$conn) return;
                $table = $resolveRemoteTable($conn);
                if (!$table) return;
                $schema = Schema::connection($conn);
                $payload = [];
                if (array_key_exists('current_status', $values)) {
                    if ($schema->hasColumn($table, 'current_status')) {
                        $payload['current_status'] = $values['current_status'];
                    } elseif ($schema->hasColumn($table, 'status')) {
                        $payload['status'] = $values['current_status'];
                    }
                }
                foreach (['status', 'appeal', 'hold_date'] as $key) {
                    if (array_key_exists($key, $values) && $schema->hasColumn($table, $key)) {
                        $payload[$key] = $values[$key];
                    }
                }
                if (!empty($payload)) {
                    DB::connection($conn)->table($table)->where('ref_no', $refNo)->update($payload);
                }
            };

            $updateTenantRow = function (string $conn, string $refNo, array $values) {
                $schema = Schema::connection($conn);
                $payload = [];
                foreach (['current_status', 'status', 'appeal', 'hold_date'] as $key) {
                    if (array_key_exists($key, $values) && $schema->hasColumn('new_candidates', $key)) {
                        $payload[$key] = $values[$key];
                    }
                }
                if (!empty($payload)) {
                    DB::connection($conn)->table('new_candidates')->where('ref_no', $refNo)->update($payload);
                }
            };

            if ((int) $request->status_id === 1) {
                $candidate->current_status = 1;
                $candidate->hold_date = null;
                $candidate->sales_name = null;
                $candidate->save();

                if (Schema::hasColumn('new_candidates', 'appeal')) {
                    DB::table('new_candidates')->where('id', $candidate->id)->update(['appeal' => 0]);
                }
                if (Schema::hasColumn('new_candidates', 'status')) {
                    DB::table('new_candidates')->where('id', $candidate->id)->update(['status' => 1]);
                }

                $updateRemote($remoteDb, $candidate->ref_no, ['current_status' => 1, 'appeal' => 0]);

                if ($primaryConnection && in_array($primaryConnection, $allTenantConnections, true)) {
                    $updateTenantRow($primaryConnection, $candidate->ref_no, ['current_status' => 1, 'status' => 1, 'appeal' => 0]);
                }
                foreach ($otherConnections as $conn) {
                    $updateTenantRow($conn, $candidate->ref_no, ['status' => 1]);
                }

                $backoutNote = 'Backout as per request of partners.';
                $agreementsToUpdate = Agreement::where('candidate_id', $candidateId)
                    ->where('agreement_type', 'BOA')
                    ->get();

                foreach ($agreementsToUpdate as $agr) {
                    $agr->status = 4;
                    $agr->notes = $backoutNote;
                    $agr->save();
                    DB::table('invoices')
                        ->where('agreement_reference_no', $agr->reference_no)
                        ->update(['status' => 'Cancelled', 'notes' => $backoutNote]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Status reset across tenants.',
                    'clients' => $clients,
                ]);
            }

            if (in_array((int) $request->status_id, [2, 3], true)) {
                $candidate->current_status = (int) $request->status_id;
            }

            $candidate->save();

            if (in_array((int) $request->status_id, [2, 3], true)) {
                $updateRemote($remoteDb, $candidate->ref_no, ['current_status' => (int) $request->status_id]);
            }

            if ($primaryConnection && in_array($primaryConnection, $allTenantConnections, true)) {
                $primaryPayload = ['status' => 1];
                if (in_array((int) $request->status_id, [2, 3], true)) {
                    $primaryPayload['current_status'] = (int) $request->status_id;
                }
                $updateTenantRow($primaryConnection, $candidate->ref_no, $primaryPayload);
            }

            foreach ($otherConnections as $conn) {
                $updateTenantRow($conn, $candidate->ref_no, ['status' => 2]);
            }

            if ((int) $request->status_id === 3) {
                $candidate->hold_date = Carbon::now('Asia/Qatar');
                $candidate->sales_name = auth()->id();
                $candidate->save();
                $updateRemote($remoteDb, $candidate->ref_no, ['hold_date' => Carbon::now('Africa/Addis_Ababa')]);
            }

            $agreement = Agreement::where('candidate_id', $candidateId)
                ->whereNotNull('client_id')
                ->latest('created_at')
                ->first();

            $clientName = null;
            $clientEmiratesId = null;
            if ($agreement) {
                $client = CRM::find($agreement->client_id);
                if ($client) {
                    $clientName = trim("{$client->first_name} {$client->last_name}");
                    $clientEmiratesId = $client->emirates_id ?? null;
                }
            }

            $pendingStatuses = ['Pending', 'Unpaid', 'Partially Paid', 'Overdue', 'Hold'];

            $invoices = collect();
            $remaining = 0;
            $vatAmount = 0;

            if ($agreement) {
                $invoices = DB::table('invoices')
                    ->join('agreements', 'agreements.reference_no', '=', 'invoices.agreement_reference_no')
                    ->where('agreements.reference_no', $agreement->reference_no)
                    ->where('agreements.candidate_id', $candidateId)
                    ->where('agreements.client_id', $agreement->client_id)
                    ->where('agreements.agreement_type', 'BOA')
                    ->whereIn('invoices.status', $pendingStatuses)
                    ->orderByDesc('invoices.invoice_id')
                    ->select('invoices.*')
                    ->get();

                $remaining = $invoices->sum('total_amount') - $invoices->sum('received_amount');
            }

            $remainingWithVat = $remaining + $vatAmount;

            $agreementInfo = null;
            if ($agreement) {
                $agreementInfo = [
                    'id' => $agreement->id ?? null,
                    'reference_no' => $agreement->reference_no ?? $candidate->reference_no,
                    'agreement_type' => $agreement->agreement_type ?? null,
                    'client_id' => $agreement->client_id ?? null,
                    'contract_start_date' => $agreement->agreement_start_date ?? ($agreement->agreement_start_date ?? null),
                    'contract_end_date' => $agreement->agreement_end_date ?? ($agreement->agreement_end_date ?? null),
                    'total_amount' => $agreement->total_amount ?? ($agreement->contract_amount ?? ($agreement->contracted_amount ?? $invoices->sum('total_amount'))),
                    'received_amount' => $agreement->received_amount ?? ($agreement->received ?? $invoices->sum('received_amount')),
                    'remaining_amount' => $agreement->remaining_amount ?? $remaining,
                    'remaining_amount_with_vat' => $remainingWithVat,
                    'vat_amount' => $vatAmount,
                ];
            }

            $commonDetails = [
                'candidateId' => $candidate->id,
                'clientId' => $agreement->client_id ?? 1,
                'referenceNo' => $candidate->reference_no,
                'refNo' => $candidate->ref_no,
                'candidateName' => $candidate->candidate_name,
                'foreignPartner' => $candidate->foreign_partner,
                'candiateNationality' => $candidate->nationality,
                'candidatePassportNumber' => $candidate->passport_no,
                'candidatePassportExpiry' => $candidate->passport_expiry_date,
                'candidateDOB' => $candidate->date_of_birth,
                'employer_name' => $clientName ?? 'Tadbeer Alebdaa',
                'client_name' => $clientName ?? 'Tadbeer Alebdaa',
                'client_emirates_id' => $clientEmiratesId,
                'invoices' => $invoices,
                'remainingAmountWithVat' => $remainingWithVat,
                'agreement' => $agreementInfo,
                'current_agreement' => $agreementInfo,
            ];

            $modals = [
                4 => ['selectedModal', 'Please update the package and client details.'],
                5 => ['WcDateModal', 'Please update the WC date.'],
                6 => ['IncidentBeforeVisaModal', 'Please update the required documents for backout.'],
                7 => ['VisaDateModal', 'Please update the Visa date.'],
                8 => ['IncidentAfterVisaModal', 'Please update the incident details after visa issuance.'],
                14 => ['IncidentAfterDepartureModal', 'Please update the incident details after departure.'],
                15 => ['updateArrivedDateModal', 'Please update the arrival date.'],
                16 => ['IncidentAfterArrivalModal', 'Please update the incident details after arrival.'],
                17 => ['TransferDateModal', 'Please update the transfer date.'],
            ];

            if (isset($modals[$request->status_id])) {
                [$modal, $message] = $modals[$request->status_id];
                return response()->json([
                    'success' => true,
                    'action' => 'open_modal',
                    'modal' => $modal,
                    'message' => $message,
                    'clients' => $clients,
                    'candidate_details' => $commonDetails,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status updated.',
                'clients' => $clients,
            ]);
        }


        public function toggleDraft(Request $request, int $candidateId): JsonResponse
        {
            $data = $request->validate([
                'current_status' => ['nullable', 'integer', 'in:0,1'],
            ]);

            $candidate = NewCandidate::query()
                ->select(['id', 'ref_no', 'reference_no', 'foreign_partner', 'current_status'])
                ->findOrFail($candidateId);

            $nextStatus = array_key_exists('current_status', $data)
                ? (int) $data['current_status']
                : ((int) $candidate->current_status === 0 ? 1 : 0);

            $remoteConn = $this->getForeignDatabaseName((string) $candidate->foreign_partner);
            if ($remoteConn === '' || !array_key_exists($remoteConn, config('database.connections', []))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Remote connection not found for this candidate partner.',
                ], 422);
            }

            $remoteTable = null;
            $remoteSchema = DB::connection($remoteConn)->getSchemaBuilder();
            if ($remoteSchema->hasTable('candidates')) {
                $remoteTable = 'candidates';
            } elseif ($remoteSchema->hasTable('new_candidates')) {
                $remoteTable = 'new_candidates';
            }

            if (!$remoteTable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Remote table not found (candidates/new_candidates).',
                ], 422);
            }

            $remotePayload = [];
            $remoteSchemaFacade = Schema::connection($remoteConn);

            if ($remoteSchemaFacade->hasColumn($remoteTable, 'current_status')) {
                $remotePayload['current_status'] = $nextStatus;
            } elseif ($remoteSchemaFacade->hasColumn($remoteTable, 'status')) {
                $remotePayload['status'] = $nextStatus;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Remote table does not have current_status or status column.',
                ], 422);
            }

            try {
                DB::beginTransaction();

                $updated = DB::connection($remoteConn)
                    ->table($remoteTable)
                    ->where('ref_no', (string) $candidate->ref_no)
                    ->update($remotePayload);

                if ($updated === 0) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Remote candidate record not found by ref_no.',
                    ], 404);
                }

                $candidate->current_status = $nextStatus;
                $candidate->save();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'current_status' => $nextStatus,
                    'message' => $nextStatus === 0 ? 'Candidate set to Draft successfully.' : 'Candidate is now Available successfully.',
                ]);
            } catch (\Throwable $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update draft status.',
                ], 500);
            }
        }


        public function updateStatusInside(Request $request, int $candidateId)
        {
            echo $candidateId;die;
            $validated = $request->validate([
                'status_id' => ['required', 'integer', 'in:0,1,5'],
            ]);

            $statusId = (int) $validated['status_id'];

            $candidate = NewCandidate::query()->findOrFail($candidateId);

            $agreement = Agreement::query()
                ->with('client')
                ->where('candidate_id', $candidateId)
                ->whereNotNull('client_id')
                ->latest('created_at')
                ->first();

            $clientName = $agreement?->client?->name;

            $pendingInvoiceStatuses = ['Pending', 'Unpaid', 'Partially Paid', 'Overdue', 'Hold'];

            $totalAmount = 0.0;
            $receivedAmount = 0.0;

            if (!empty($agreement?->reference_no)) {
                $invoiceSums = DB::table('invoices')
                    ->join('agreements', 'invoices.agreement_reference_no', '=', 'agreements.reference_no')
                    ->where('agreements.candidate_id', $candidateId)
                    ->where('invoices.agreement_reference_no', $agreement->reference_no)
                    ->whereIn('invoices.status', $pendingInvoiceStatuses)
                    ->selectRaw('COALESCE(SUM(invoices.total_amount),0) as total_amount, COALESCE(SUM(invoices.received_amount),0) as received_amount')
                    ->first();

                $totalAmount = (float) ($invoiceSums->total_amount ?? 0);
                $receivedAmount = (float) ($invoiceSums->received_amount ?? 0);
            }

            $vatAmount = (float) ($agreement?->vat_amount ?? $agreement?->vat ?? 0);
            $remainingAmount = $totalAmount - $receivedAmount;
            $remainingAmountWithVat = $remainingAmount + $vatAmount;

            $nationalityNames = [
                1 => 'Ethiopia',
                2 => 'Uganda',
                3 => 'Philippines',
                4 => 'Indonesia',
                5 => 'Sri Lanka',
                6 => 'Myanmar',
            ];

            $fmtDate = static function ($value): ?string {
                if ($value === null || $value === '') return null;
                try { return \Carbon\Carbon::parse($value)->format('Y-m-d'); } catch (\Throwable $e) { return null; }
            };

            $agreementPayload = $agreement ? [
                'id'                  => $agreement->id,
                'reference_no'        => $agreement->reference_no ?? null,
                'agreement_no'        => $agreement->agreement_no ?? $agreement->reference_no ?? null,
                'agreement_type'      => $agreement->agreement_type ?? null,
                'status'              => $agreement->status ?? null,
                'client_id'           => $agreement->client_id ?? null,
                'client_name'         => $clientName,
                'contract_start_date' => $fmtDate($agreement->contract_start_date ?? $agreement->start_date ?? $agreement->agreement_start_date),
                'contract_end_date'   => $fmtDate($agreement->contract_end_date ?? $agreement->end_date ?? $agreement->agreement_end_date),
                'vat_amount'          => $vatAmount,
            ] : null;

            $sponsorName = $candidate->sponsor_name
                ?? $candidate->sponsor
                ?? $candidate->employer_name
                ?? $clientName
                ?? 'N/A';

            $sponsorQid = $candidate->sponsor_qid
                ?? $candidate->eid_no
                ?? $candidate->qid_no
                ?? $candidate->sponsor_id_no
                ?? null;

            if (property_exists($candidate, 'inside_status')) {
                $candidate->inside_status = $statusId;
                $candidate->save();
            }

            $candidateDetails = [
                'candidateId'            => $candidate->id,
                'referenceNo'            => $candidate->reference_no,
                'ref_no'                 => $candidate->ref_no,
                'arrived_date'           => $fmtDate($candidate->arrived_date),
                'candidateName'          => $candidate->candidate_name,
                'foreignPartner'         => $candidate->foreign_partner,
                'nationality'            => $nationalityNames[$candidate->nationality] ?? 'N/A',
                'passportNo'             => $candidate->passport_no,
                'passportExpiry'         => $fmtDate($candidate->passport_expiry_date ?? $candidate->passport_expiry),
                'dob'                    => $fmtDate($candidate->date_of_birth),
                'sponsorName'            => $sponsorName,
                'sponsorQid'             => $sponsorQid,
                'clientName'             => $clientName,
                'agreement'              => $agreementPayload,
                'agreement_reference_no' => $agreementPayload['reference_no'] ?? null,
                'invoice_totals'         => [
                    'total_amount'       => $totalAmount,
                    'received_amount'    => $receivedAmount,
                    'remaining_amount'   => $remainingAmount,
                    'vat_amount'         => $vatAmount,
                    'remaining_with_vat' => $remainingAmountWithVat,
                ],
                'category'               => 'Inside - All',
                'refund_type_label'      => 'Inside - All',
                'refund_type'            => 'package',
                'view'                   => 'candidates/' . $candidate->reference_no,
            ];

            if ($statusId === 0) {
                return response()->json([
                    'success' => true,
                    'action'  => 'update_only',
                    'message' => 'Status updated.',
                ]);
            }

            $modalMap = [
                1 => ['officeModal', 'Please update the office details.'],
                5 => ['incidentModal', 'Please update the incident details.'],
            ];

            [$modalId, $message] = $modalMap[$statusId];

            return response()->json([
                'success'          => true,
                'action'           => 'open_modal',
                'modal'            => $modalId,
                'message'          => $message,
                'candidateDetails' => $candidateDetails,
            ]);
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
            $client_id = $request->input('client_id');
            $candidate = NewCandidate::findOrFail($candidateId);
            $clients = CRM::all();
            $agreement = Agreement::where('candidate_id', $candidateId)->first();
            $client = CRM::findOrFail($client_id);
            $clientName = $client->first_name.' '.$client->last_name;
            $pendingStatuses = ['Pending', 'Unpaid', 'Partially Paid', 'Overdue', 'Hold'];
            $invoices = DB::table('invoices')
                ->join('agreements', 'invoices.agreement_reference_no', '=', 'agreements.reference_no')
                ->where('agreements.candidate_id', $candidateId)
                ->whereIn('invoices.status', $pendingStatuses)
                ->orderBy('invoices.invoice_id', 'desc')
                ->select('invoices.*')
                ->get();
                
            $remainingAmount = $invoices->sum('total_amount') - $invoices->sum('received_amount');
            $remainingAmountWithVat = $remainingAmount;

            $candidateDetails = [
                'candidateId' => $candidate->id,
                'referenceNo' => $candidate->reference_no,
                'ref_no' => $candidate->ref_no,
                'candidateName' => $candidate->candidate_name,
                'foreignPartner' => $candidate->foreign_partner,
                'nationality' => $candidate->nationality,
                'passportNo' => $candidate->passport_no,
                'passportExpiry' => $candidate->passport_expiry_date,
                'dob' => $candidate->date_of_birth,
                'employerName' => $candidate->employer_name,
                'clientName' => $clientName,
                'invoices' => $invoices,
                'remainingAmountWithVat' => $remainingAmountWithVat,
            ];

            $modals = [
                "Confirmed" => ['ConfirmedModal', 'Please update the confirmed trial details.'],
                "Incident" => ['IncidentModal', 'Please update the Incident trial details.'],
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

        public function getChangeStatusDetails(Request $request)
        {
            $trialId = $request->input('trial_id');
            $candidateId = $request->input('candidate_id');
            $clientId = $request->input('client_id');

            try {
                $candidate = NewCandidate::find($candidateId);
                if (!$candidate) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Candidate not found.',
                    ], 404); 
                }

                $client = CRM::find($clientId);
                if (!$client) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Client not found.',
                    ], 404); 
                }

                return response()->json([
                    'success' => true,
                    'candidate_name' => $candidate->candidate_name,
                    'candidate_reference_no' => $candidate->reference_no,
                    'candidate_ref_no' => $candidate->ref_no,
                    'foreign_partner' => $candidate->foreign_partner,
                    'candidate_nationality' => $candidate->nationality,
                    'candidate_passport_number' => $candidate->passport_no,
                    'candidate_passport_expiry' => $candidate->passport_expiry_date,
                    'candidate_dob' => $candidate->date_of_birth,
                    'client_name' => $client->first_name.' '.$client->last_name,
                ]);

            } catch (\Exception $e) {
                \Log::error('Error in getChangeStatusDetails:', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while fetching details.',
                    'error' => $e->getMessage(),
                ], 500); 
            }
        }

        public function updateChangeStatus(Request $request)
        {
            $data = $request->validate([
                'trial_id' => 'required|integer|exists:trials,id',
                'candidate_id' => 'required|integer|exists:new_candidates,id',
                'change_status_date' => 'required|date',
                'proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
            ]);

            try {
                DB::transaction(function() use ($data, $request) {
                    $filePath = $request->file('proof')->store('change_status_proof', 'public');

                    $trial = Trial::findOrFail($data['trial_id']);
                    $trial->update([
                        'trial_status' => 'Change Status',
                        'change_status_date' => $data['change_status_date'],
                        'change_status_proof' => $filePath,
                    ]);

                    $candidate = NewCandidate::findOrFail($data['candidate_id']);
                    $candidate->update([
                        'inside_status' => 4,
                        'change_status_date' => $data['change_status_date'],
                    ]);

                    if ($trial->trial_type === 'package') {
                        Package::where('id', $data['candidate_id'])->update(['inside_status' => 4]);
                    } else {
                        Employee::where('id', $data['candidate_id'])->update(['inside_status' => 4]);
                    }
                });

                return response()->json(['success' => true, 'message' => 'Change status updated successfully.']);
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error('Database error in updateChangeStatus', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                return response()->json(['success' => false, 'message' => 'A database error occurred while updating the status. Please check the logs.'], 500);
            } catch (\Exception $e) {
                Log::error('General error in updateChangeStatus', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                return response()->json(['success' => false, 'message' => 'An error occurred while updating the status. Please try again.'], 500);
            }
        }

        public function showCV(NewCandidate $candidate)
        {
            $now = Carbon::now('Africa/Addis_Ababa')->format('l, F d, Y h:i A');
            $user = Auth::user();
            $candidate->load([
                'nationality', 
                'appliedPosition', 
                'educationLevel', 
                'desiredCountry', 
                'fraName', 
                'medicalStatus', 
                'cocStatus', 
                'currentStatus', 
                'creator', 
                'maritalStatus',
                'attachments'
            ]);

            return view('candidates.cv', compact('candidate', 'now'));
        }

        public function downloadCV(NewCandidate $candidate)
        {
            $candidate->load([
                'nationality',
                'appliedPosition',
                'educationLevel',
                'desiredCountry',
                'fraName',
                'medicalStatus',
                'cocStatus',
                'currentStatus',
                'creator',
                'maritalStatus',
                'attachments'
            ]);

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

            $filename = $candidate->candidate_name . '_CV.pdf';

            return response($pdf->inline(), 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);
        }

        public function shareCV(NewCandidate $candidate)
        {
            $candidate->load([
                'nationality',
                'appliedPosition',
                'educationLevel',
                'desiredCountry',
                'fraName',
                'medicalStatus',
                'cocStatus',
                'currentStatus',
                'creator',
                'maritalStatus',
                'attachments'
            ]);

            $name = $candidate->candidate_name ?? 'Unknown';
            $referenceNo = $candidate->reference_no ?? '00000';
            $serverName = $_SERVER['SERVER_NAME'] ?? 'default.domain.com';
            $downloadUrl = "https://{$serverName}/{$referenceNo}/download";
            $message = "🌸 *{$name}*'s CV 🌸\n\n"
                     . "🔗 {$downloadUrl}\n\n"
                     . "Have a nice day! 🍀";

            $whatsappUrl = "https://wa.me/?text=" . urlencode($message);
            return redirect()->away($whatsappUrl);
        }

        public function viewCV($reference_no)
        {
            $candidate = NewCandidate::with([
                'nationality', 
                'appliedPosition', 
                'educationLevel', 
                'desiredCountry', 
                'fraName', 
                'medicalStatus', 
                'cocStatus', 
                'currentStatus', 
                'creator',
                'maritalStatus', 
                'attachments'
            ])->where('reference_no', $reference_no)->firstOrFail();

            return view('candidates.view_cv', compact('candidate'));
        }

        protected function buildFileUrl(string $filePath): string
        {
            return rtrim(config('app.url'), '/') . '/storage/' . ltrim($filePath, '/');
        }

        protected function getCandidateFileDiskPaths(int $candidateId, ?string $attachmentType = null, ?string $attachmentNumber = null): array
        {
            $query = CandidateAttachment::where('candidate_id', $candidateId);

            if ($attachmentType !== null) {
                $query->where('attachment_type', $attachmentType);
            }

            if ($attachmentNumber !== null) {
                $query->where('attachment_number', $attachmentNumber);
            }

            $paths = $query->pluck('attachment_file')->filter()->unique();

            return $paths
                ->map(function ($path) {
                    return storage_path('app/public/' . ltrim($path, '/'));
                })
                ->values()
                ->all();
        }

        private function upsertPackageAttachmentByPassport(
            ?string $passportNo,
            string $type,
            string $name,
            string $filePath,
            ?string $number = null,
            ?string $issuedOn = null,
            ?int $createdBy = null
        ): void {
            if (!$passportNo) return;

            $pkg = Package::where('passport_no', $passportNo)->first();
            if (!$pkg) return;

            $query = PackageAttachment::where('package_id', $pkg->id)
                ->where('attachment_type', $type)
                ->where('attachment_name', $name);

            if ($number !== null) {
                $query->where('attachment_number', $number);
            }

            $old = $query->first();

            if ($old && $old->attachment_file && $old->attachment_file !== $filePath && Storage::disk('public')->exists($old->attachment_file)) {
                Storage::disk('public')->delete($old->attachment_file);
            }

            PackageAttachment::updateOrCreate(
                [
                    'package_id'        => $pkg->id,
                    'attachment_type'   => $type,
                    'attachment_name'   => $name,
                    'attachment_number' => $number,
                ],
                [
                    'attachment_file' => $filePath,
                    'issued_on'       => $issuedOn ?: now('Asia/Dubai')->format('Y-m-d'),
                    'created_by'      => $createdBy ?: auth()->id(),
                ]
            );

            $pkg->touch();
        }

        private function upsertEmployeeAttachmentByPassport(
            ?string $passportNo,
            string $type,
            string $name,
            string $filePath,
            ?string $number = null,
            ?string $issuedOn = null,
            ?int $createdBy = null
        ): void {
            if (!$passportNo) return;

            $emp = Employee::where('passport_no', $passportNo)->first();
            if (!$emp) return;

            $query = EmployeeAttachment::where('employee_id', $emp->id)
                ->where('attachment_type', $type)
                ->where('attachment_name', $name);

            if ($number !== null) {
                $query->where('attachment_number', $number);
            }

            $old = $query->first();

            if ($old && $old->attachment_file && $old->attachment_file !== $filePath && Storage::disk('public')->exists($old->attachment_file)) {
                Storage::disk('public')->delete($old->attachment_file);
            }

            EmployeeAttachment::updateOrCreate(
                [
                    'employee_id'       => $emp->id,
                    'attachment_type'   => $type,
                    'attachment_name'   => $name,
                    'attachment_number' => $number,
                ],
                [
                    'attachment_file' => $filePath,
                    'issued_on'       => $issuedOn ?: now('Asia/Dubai')->format('Y-m-d'),
                    'created_by'      => $createdBy ?: auth()->id(),
                ]
            );

            $emp->touch();
        }

        private function updatePackageByPassport(?string $passportNo, array $data): void
        {
            if (!$passportNo) return;
            $pkg = Package::where('passport_no', $passportNo)->first();
            if (!$pkg) return;
            $pkg->fill($data);
            $pkg->save();
        }

        private function updateEmployeeByPassport(?string $passportNo, array $data): void
        {
            if (!$passportNo) return;
            $emp = Employee::where('passport_no', $passportNo)->first();
            if (!$emp) return;
            $emp->fill($data);
            $emp->save();
        }

        public function updateWcDate(Request $request)
        {
            $request->validate([
                'wc_date'          => 'required|date',
                'dw_number'        => 'required|string',
                'wc_date_remark'   => 'nullable|string',
                'candidate_id'     => 'required|integer',
                'wc_contract_file' => 'required|file|mimes:pdf|max:10000',
            ]);

            DB::beginTransaction();

            $filePath = null;
            $fileUrl  = null;

            try {
                $candidate = NewCandidate::where('id', (int) $request->candidate_id)->lockForUpdate()->first();

                if (! $candidate) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Candidate not found.',
                    ], 404);
                }

                $formattedWcDate = Carbon::parse($request->wc_date)->format('Y-m-d');

                $candidate->wc_date        = $formattedWcDate;
                $candidate->wc_added_date  = now('Asia/Dubai');
                $candidate->current_status = 5;
                $candidate->dw_number      = $request->dw_number;
                $candidate->wc_date_remark = $request->wc_date_remark;
                $candidate->save();

                $passportNo = (string) ($candidate->passport_no ?? '');

                $this->updatePackageByPassport($passportNo, [
                    'wc_date'        => $formattedWcDate,
                    'dw_number'      => $request->dw_number,
                    'current_status' => 5,
                    'remark'         => $request->wc_date_remark,
                ]);

                $this->updateEmployeeByPassport($passportNo, [
                    'current_status' => 5,
                    'remarks'        => $request->wc_date_remark,
                ]);

                $filePath = $request->file('wc_contract_file')->store('attachments', 'public');

                if (! $filePath) {
                    throw new \RuntimeException('File upload failed.');
                }

                $fileUrl = $this->buildFileUrl($filePath);

                $foreignPartner = $candidate->foreign_partner;
                $remoteDb       = $this->getForeignDatabaseName($foreignPartner);

                if (! empty($remoteDb) && array_key_exists($remoteDb, config('database.connections'))) {
                    try {
                        $remoteUpdate = [
                            'wc_date'        => $formattedWcDate,
                            'wc_added_date'  => Carbon::now('Africa/Addis_Ababa')->format('Y-m-d'),
                            'current_status' => 5,
                            'wc_contract_file' => $fileUrl,
                        ];

                        DB::connection($remoteDb)
                            ->table('candidates')
                            ->where('ref_no', $candidate->ref_no)
                            ->update($remoteUpdate);
                    } catch (\Throwable $e) {
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

                $this->upsertPackageAttachmentByPassport($passportNo, 'Work Contract', 'Work Contract', $filePath, null, now('Asia/Dubai')->format('Y-m-d'), auth()->id());
                $this->upsertEmployeeAttachmentByPassport($passportNo, 'Work Contract', 'Work Contract', $filePath, null, now('Asia/Dubai')->format('Y-m-d'), auth()->id());

                $CN_Number = $candidate->CN_Number;

                $notificationData = [
                    'reference_no' => $candidate->reference_no,
                    'ref_no'       => $candidate->ref_no,
                    'title'        => "Work Contract has been completed for {$CN_Number}",
                    'message'      => "The Work Contract has been completed for {$CN_Number}",
                    'CL_Number'    => $CN_Number,
                    'CN_Number'    => $CN_Number,
                    'status'       => 'Un Read',
                    'filePath'     => $fileUrl,
                    'created_at'   => Carbon::now('Asia/Dubai'),
                ];

                $notificationSales = array_merge($notificationData, [
                    'role'    => 'sales',
                    'user_id' => $candidate->sales_name,
                ]);
                $this->add_notification($notificationSales);

                $notificationCoordinator = array_merge($notificationData, [
                    'role'    => 'coordinator',
                    'user_id' => $candidate->sales_name,
                ]);
                $this->add_notification($notificationCoordinator);

                DB::commit();

                $emails = $this->getActionEmailRecipients($candidate);

                if ($emails->isNotEmpty()) {
                    $action          = 'Work Contract';
                    $passport_no     = (string) ($candidate->passport_no ?? '');
                    $candidate_name  = (string) ($candidate->candidate_name ?? $candidate->CN_Number);
                    $foreign_partner = (string) ($candidate->foreign_partner ?? '');
                    $ref_no          = (string) ($candidate->ref_no ?? '');
                    $action_date     = (string) $formattedWcDate;
                    $other           = (string) ($candidate->wc_date_remark ?? '');

                    $fileDiskPaths = $this->getCandidateFileDiskPaths($candidate->id, 'Work Contract');

                    foreach ($emails as $to) {
                        $this->sendActionEmail(
                            $to,
                            $action,
                            $passport_no,
                            $candidate_name,
                            $foreign_partner,
                            $ref_no,
                            $action_date,
                            $fileDiskPaths,
                            $other
                        );
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'WC Date, status, attachment updated and emails processed successfully.',
                ]);
            } catch (\Throwable $e) {
                DB::rollBack();

                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        public function saveIncident(Request $request)
        {
            $request->validate([
                'incident_category'                => 'required|string|max:255',
                'candidate_id'                     => 'required',
                'candidate_name'                   => 'required|string|max:255',
                'employer_name'                    => 'required|string|max:255',
                'candidate_reference_no'           => 'required|string|max:255',
                'candidate_ref_no'                 => 'required|string|max:255',
                'candidate_nationality'            => 'required|string|max:255',
                'incident_reason'                  => 'required|string',
                'other_reason'                     => 'nullable|string',
                'incident_expiry_date'             => 'nullable|string',
                'proof'                            => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
                'IncidentBeforeVisaremarks'        => 'nullable|string',
                'IncidentAfterArrivalModalremarks' => 'nullable|string',
                'customer_decision'                => 'required|in:Refund,Replacement',
                'refund_due_date'                  => 'nullable|date',
                'office_charges'                   => 'nullable|numeric|min:0',
                'balance_amount'                   => 'nullable|numeric|min:0',
                'client_id'                        => 'nullable|integer',
                'package'                          => 'nullable|string',
                'original_passport'                => 'nullable|boolean',
                'worker_belongings'                => 'nullable|boolean',
            ]);

            $candidate = NewCandidate::find((int) $request->candidate_id);
            if (!$candidate) {
                return response()->json(['success' => false, 'message' => 'Candidate not found.'], 404);
            }

            $passportNo = (string) ($candidate->passport_no ?? '');
            if ($passportNo === '') {
                return response()->json(['success' => false, 'message' => 'Passport number is missing.'], 422);
            }

            $foreignPartner = $candidate->foreign_partner ?? null;
            $remoteDb = $this->getForeignDatabaseName($foreignPartner);

            $boaAgreement = Agreement::where('passport_no', $passportNo)
                ->where('agreement_type', 'BOA')
                ->first();

            $filterByExistingColumns = function (string $connection, string $table, array $data): array {
                if (!Schema::connection($connection)->hasTable($table)) return [];
                $out = [];
                foreach ($data as $k => $v) {
                    if (Schema::connection($connection)->hasColumn($table, $k)) $out[$k] = $v;
                }
                return $out;
            };

            $firstExistingColumn = function (string $connection, string $table, array $candidates): ?string {
                if (!Schema::connection($connection)->hasTable($table)) return null;
                foreach ($candidates as $col) {
                    if (Schema::connection($connection)->hasColumn($table, $col)) return $col;
                }
                return null;
            };

            $filterLocalColumns = function (string $table, array $data): array {
                if (!Schema::hasTable($table)) return [];
                $out = [];
                foreach ($data as $k => $v) {
                    if (Schema::hasColumn($table, $k)) $out[$k] = $v;
                }
                return $out;
            };

            $nextSeriesRef = function (string $table, string $prefix) {
                $start = strlen($prefix) + 1;
                $max = (int) (DB::table($table)->lockForUpdate()
                    ->where('reference_no', 'like', $prefix . '%')
                    ->selectRaw("COALESCE(MAX(CAST(SUBSTRING(reference_no,{$start}) AS UNSIGNED)),0) m")
                    ->value('m') ?? 0);

                $n = $max + 1;
                while (true) {
                    $ref = $prefix . str_pad((string) $n, 5, '0', STR_PAD_LEFT);
                    $exists = DB::table($table)->where('reference_no', $ref)->exists();
                    if (!$exists) return $ref;
                    $n++;
                }
            };

            DB::beginTransaction();
            if ($remoteDb) DB::connection($remoteDb)->beginTransaction();

            $filePath = null;
            $fileUrl = null;

            try {
                $existingIncident = Incident::where('candidate_id', (int) $request->candidate_id)
                    ->where('incident_category', (string) $request->incident_category)
                    ->first();

                if ($existingIncident && $existingIncident->proof && Storage::disk('public')->exists($existingIncident->proof)) {
                    Storage::disk('public')->delete($existingIncident->proof);
                }

                $filePath = $request->file('proof')->store('incidents', 'public');
                if (!$filePath) throw new \RuntimeException('File upload failed.');

                $fileUrl = $this->buildFileUrl($filePath);

                $formattedExpiryDate = $request->filled('incident_expiry_date')
                    ? Carbon::parse($request->incident_expiry_date)->toDateString()
                    : null;

                $incident = Incident::updateOrCreate(
                    [
                        'candidate_id'      => (int) $request->candidate_id,
                        'incident_category' => (string) $request->incident_category,
                    ],
                    [
                        'candidate_name'       => (string) $request->candidate_name,
                        'employer_name'        => (string) $request->employer_name,
                        'reference_no'         => (string) $request->candidate_reference_no,
                        'ref_no'               => (string) $request->candidate_ref_no,
                        'nationality'          => (string) $request->candidate_nationality,
                        'country'              => 'Dubai',
                        'company'              => 'Alebdaa',
                        'branch'               => 'Alebdaa',
                        'incident_reason'      => (string) $request->incident_reason,
                        'other_reason'         => $request->other_reason,
                        'incident_expiry_date' => $formattedExpiryDate,
                        'proof'                => $filePath,
                        'note'                 => $request->IncidentBeforeVisaremarks,
                        'created_by'           => auth()->id(),
                    ]
                );

                NewCandidate::where('id', (int) $request->candidate_id)->update([
                    'incident_before_visa_date' => Carbon::now('Asia/Dubai'),
                    'current_status'            => 6,
                ]);

                $incidentDate = Carbon::now('Asia/Dubai')->toDateString();

                $remarks = trim(
                    (string) $request->incident_reason . ' ' .
                    (string) ($request->IncidentBeforeVisaremarks ?? '') . ' ' .
                    (string) ($request->other_reason ?? '')
                );

                $refundType = null;
                $pkg = null;
                $emp = Employee::where('passport_no', $passportNo)->lockForUpdate()->first();

                if ($emp) {
                    $emp->update([
                        'inside_status'  => 3,
                        'current_status' => 6,
                        'incident_type'  => (string) $request->incident_category,
                        'incident_date'  => $incidentDate,
                        'remarks'        => $remarks,
                    ]);
                    $refundType = 'employee';

                    $this->upsertEmployeeAttachmentByPassport(
                        $passportNo,
                        (string) $request->incident_category,
                        (string) $request->incident_category,
                        $filePath,
                        null,
                        $incidentDate,
                        auth()->id()
                    );
                } else {
                    $pkg = Package::where('passport_no', $passportNo)->lockForUpdate()->first();
                    if (!$pkg) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'passport_no' => ['Not exist in the inside candidate.'],
                        ]);
                    }

                    $pkg->update([
                        'inside_status' => 5,
                        'incident_type' => (string) $request->incident_category,
                        'incident_date' => $incidentDate,
                        'remark'        => $remarks,
                    ]);
                    $refundType = 'package';

                    $this->upsertPackageAttachmentByPassport(
                        $passportNo,
                        (string) $request->incident_category,
                        (string) $request->incident_category,
                        $filePath,
                        null,
                        $incidentDate,
                        auth()->id()
                    );
                }

                $packageValue = $request->input('package');
                if (!$packageValue && $emp && !empty($emp->package)) $packageValue = $emp->package;
                if (!$packageValue && $pkg && !empty($pkg->package)) $packageValue = $pkg->package;

                $clientId = $request->input('client_id');
                if ($clientId === null && isset($boaAgreement->client_id)) $clientId = $boaAgreement->client_id;

                $agreementRefNo = (string) ($boaAgreement->reference_no ?? '');

                if ($agreementRefNo !== '') {
                    Agreement::where('reference_no', $agreementRefNo)->update([
                        'status' => 4,
                        'notes'  => $remarks,
                    ]);

                    if (Schema::hasTable('invoices')) {
                        $invUpdate = [];
                        if (Schema::hasColumn('invoices', 'status')) $invUpdate['status'] = 'Cancelled';
                        if (Schema::hasColumn('invoices', 'notes'))  $invUpdate['notes']  = $remarks;

                        if (!empty($invUpdate) && Schema::hasColumn('invoices', 'agreement_reference_no')) {
                            DB::table('invoices')->where('agreement_reference_no', $agreementRefNo)->update($invUpdate);
                        }
                    }
                }

                $agreementNo = $boaAgreement->agreement_no
                    ?? $boaAgreement->reference_no
                    ?? $boaAgreement->agreement_reference_no
                    ?? null;

                $contractStart = $boaAgreement->contract_start_date
                    ?? $boaAgreement->start_date
                    ?? $boaAgreement->agreement_start_date
                    ?? null;

                $contractEnd = $boaAgreement->contract_end_date
                    ?? $boaAgreement->end_date
                    ?? $boaAgreement->agreement_end_date
                    ?? null;

                $contractedAmount = $boaAgreement->total_amount
                    ?? $boaAgreement->contracted_amount
                    ?? $boaAgreement->contract_amount
                    ?? null;

                $salary = $candidate->agreed_salary ?? $candidate->salary ?? null;

                $decision = (string) $request->customer_decision;
                $dueDate = $request->filled('refund_due_date') ? Carbon::parse($request->refund_due_date)->toDateString() : null;

                $baseRecord = [
                    'candidate_id'                => (int) $candidate->id,
                    'client_id'                   => $clientId ? (int) $clientId : null,
                    'type'                        => (string) $incident->incident_category,
                    'candidate_name'              => (string) ($candidate->candidate_name ?? $request->candidate_name),
                    'sponsor_name'                => (string) $request->employer_name,
                    'passport_no'                 => $passportNo,
                    'nationality'                 => (string) ($candidate->nationality ?? $request->candidate_nationality),
                    'foreign_partner'             => (string) ($candidate->foreign_partner ?? ''),
                    'agreement_no'                => $agreementNo,
                    'contract_start_date'         => $contractStart,
                    'contract_end_date'           => $contractEnd,
                    'return_date'                 => $incidentDate,
                    'maid_worked_days'            => null,
                    'contracted_amount'           => $contractedAmount,
                    'salary'                      => $salary,
                    'worker_salary_for_work_days' => null,
                    'salary_payment_method'       => null,
                    'payment_proof'               => null,
                    'office_charges'              => $request->office_charges,
                    'refunded_amount'             => $request->balance_amount,
                    'refund_date'                 => $dueDate,
                    'original_passport'           => $request->boolean('original_passport', false),
                    'worker_belongings'           => $request->boolean('worker_belongings', false),
                    'status'                      => 'open',
                    'sales_name'                  => $candidate->sales_name,
                    'updated_by_sales_name'       => auth()->id(),
                    'package'                     => $packageValue,
                ];

                if ($decision === 'Refund') {
                    $existingRefund = Refund::where('candidate_id', (int) $candidate->id)
                        ->where('type', (string) $incident->incident_category)
                        ->lockForUpdate()
                        ->first();

                    $refundRefNo = $existingRefund && !empty($existingRefund->reference_no) ? (string) $existingRefund->reference_no : (string) $nextSeriesRef('refunds', 'REF-');

                    $refundRecord = array_merge($baseRecord, [
                        'reference_no' => $refundRefNo,
                        'refund_type'  => $refundType,
                    ]);

                    Refund::updateOrCreate(
                        [
                            'candidate_id' => (int) $candidate->id,
                            'type'         => (string) $incident->incident_category,
                        ],
                        $filterLocalColumns('refunds', $refundRecord)
                    );
                } else {
                    $existingReplacement = Replacement::where('candidate_id', (int) $candidate->id)
                        ->where('type', (string) $incident->incident_category)
                        ->lockForUpdate()
                        ->first();

                    $repRefNo = $existingReplacement && !empty($existingReplacement->reference_no) ? (string) $existingReplacement->reference_no : (string) $nextSeriesRef('replacements', 'REP-');

                    $replacementRecord = array_merge($baseRecord, [
                        'reference_no'       => $repRefNo,
                        'replacement_type'   => $refundType,
                    ]);

                    Replacement::updateOrCreate(
                        [
                            'candidate_id' => (int) $candidate->id,
                            'type'         => (string) $incident->incident_category,
                        ],
                        $filterLocalColumns('replacements', $replacementRecord)
                    );
                }

                if ($remoteDb) {
                    if ($agreementRefNo !== '') {
                        $agrRefCol = $firstExistingColumn($remoteDb, 'agreements', ['reference_no', 'agreement_reference_no', 'agreement_no']);
                        $agrUpdate = $filterByExistingColumns($remoteDb, 'agreements', ['status' => 4, 'notes' => $remarks]);
                        if ($agrRefCol && !empty($agrUpdate)) {
                            DB::connection($remoteDb)->table('agreements')->where($agrRefCol, $agreementRefNo)->update($agrUpdate);
                        }

                        $invRefCol = $firstExistingColumn($remoteDb, 'invoices', ['agreement_reference_no', 'agreement_ref_no', 'reference_no']);
                        $invUpdate = $filterByExistingColumns($remoteDb, 'invoices', ['status' => 'Cancelled', 'notes' => $remarks]);
                        if ($invRefCol && !empty($invUpdate)) {
                            DB::connection($remoteDb)->table('invoices')->where($invRefCol, $agreementRefNo)->update($invUpdate);
                        }
                    }

                    $nowRemote = Carbon::now('Africa/Addis_Ababa');

                    DB::connection($remoteDb)->table('incidents')->insert([
                        'incident_category'    => (string) $incident->incident_category,
                        'candidate_id'         => (int) $request->candidate_id,
                        'candidate_name'       => (string) $request->candidate_name,
                        'reference_no'         => (string) $request->candidate_reference_no,
                        'ref_no'               => (string) $request->candidate_ref_no,
                        'country'              => 'Dubai',
                        'company'              => 'Alebdaa',
                        'branch'               => 'Alebdaa',
                        'incident_reason'      => (string) $request->incident_reason,
                        'other_reason'         => $request->other_reason,
                        'incident_expiry_date' => $formattedExpiryDate,
                        'proof'                => $fileUrl,
                        'note'                 => $request->IncidentAfterArrivalModalremarks,
                        'created_by'           => auth()->id(),
                        'created_at'           => $nowRemote,
                        'updated_at'           => $nowRemote,
                    ]);

                    DB::connection($remoteDb)->table('candidates')
                        ->where('ref_no', (string) $request->candidate_ref_no)
                        ->update([
                            'incident_before_visa_date' => $nowRemote,
                            'current_status'            => 6,
                        ]);

                    if ($decision === 'Refund' && Schema::connection($remoteDb)->hasTable('refunds')) {
                        $existingRemoteRefundRef = null;
                        if (Schema::connection($remoteDb)->hasColumn('refunds', 'reference_no')) {
                            $existingRemoteRefundRef = DB::connection($remoteDb)->table('refunds')
                                ->where($filterByExistingColumns($remoteDb, 'refunds', ['candidate_id' => (int) $candidate->id, 'type' => (string) $incident->incident_category]))
                                ->value('reference_no');
                        }

                        $existingLocalRefund = Refund::where('candidate_id', (int) $candidate->id)->where('type', (string) $incident->incident_category)->first();
                        $refundRefNo = $existingLocalRefund && !empty($existingLocalRefund->reference_no) ? (string) $existingLocalRefund->reference_no : (string) ($existingRemoteRefundRef ?: $nextSeriesRef('refunds', 'REF-'));

                        $remoteRefundRecord = $filterByExistingColumns($remoteDb, 'refunds', array_merge($baseRecord, [
                            'reference_no' => $refundRefNo,
                            'refund_type'  => $refundType,
                        ]));

                        if (!empty($remoteRefundRecord)) {
                            DB::connection($remoteDb)->table('refunds')->updateOrInsert(
                                $filterByExistingColumns($remoteDb, 'refunds', [
                                    'candidate_id' => (int) $candidate->id,
                                    'type'         => (string) $incident->incident_category,
                                ]),
                                array_merge($remoteRefundRecord, ['created_at' => $nowRemote, 'updated_at' => $nowRemote])
                            );
                        }
                    }

                    if ($decision === 'Replacement' && Schema::connection($remoteDb)->hasTable('replacements')) {
                        $existingRemoteRepRef = null;
                        if (Schema::connection($remoteDb)->hasColumn('replacements', 'reference_no')) {
                            $existingRemoteRepRef = DB::connection($remoteDb)->table('replacements')
                                ->where($filterByExistingColumns($remoteDb, 'replacements', ['candidate_id' => (int) $candidate->id, 'type' => (string) $incident->incident_category]))
                                ->value('reference_no');
                        }

                        $existingLocalRep = Replacement::where('candidate_id', (int) $candidate->id)->where('type', (string) $incident->incident_category)->first();
                        $repRefNo = $existingLocalRep && !empty($existingLocalRep->reference_no) ? (string) $existingLocalRep->reference_no : (string) ($existingRemoteRepRef ?: $nextSeriesRef('replacements', 'REP-'));

                        $remoteReplacementRecord = $filterByExistingColumns($remoteDb, 'replacements', array_merge($baseRecord, [
                            'reference_no'     => $repRefNo,
                            'replacement_type' => $refundType,
                        ]));

                        if (!empty($remoteReplacementRecord)) {
                            DB::connection($remoteDb)->table('replacements')->updateOrInsert(
                                $filterByExistingColumns($remoteDb, 'replacements', [
                                    'candidate_id' => (int) $candidate->id,
                                    'type'         => (string) $incident->incident_category,
                                ]),
                                array_merge($remoteReplacementRecord, ['created_at' => $nowRemote, 'updated_at' => $nowRemote])
                            );
                        }
                    }
                }

                $CN_Number = $candidate->CN_Number;

                $notification1 = [
                    'role'         => 'sales',
                    'user_id'      => $candidate->sales_name,
                    'reference_no' => $candidate->reference_no,
                    'ref_no'       => $candidate->ref_no,
                    'title'        => (string) $request->incident_category . ' for ' . $CN_Number,
                    'message'      => (string) $request->incident_category . ' for ' . $CN_Number . ' and the reason is : ' . (string) $request->incident_reason,
                    'CL_Number'    => $CN_Number,
                    'CN_Number'    => $CN_Number,
                    'filePath'     => $fileUrl,
                    'status'       => 'Un Read',
                    'created_at'   => Carbon::now('Asia/Dubai'),
                ];
                $this->add_notification($notification1);

                if ($remoteDb) {
                    $message = (string) $request->incident_category . ' for ' . $candidate->ref_no . ' and the reason is : ' . (string) $request->incident_reason;

                    DB::connection($remoteDb)->table('notifications')->insert([
                        'role'         => $notification1['role'],
                        'user_id'      => $notification1['user_id'],
                        'reference_no' => $notification1['reference_no'],
                        'ref_no'       => $notification1['ref_no'],
                        'title'        => $notification1['title'],
                        'message'      => $message,
                        'CL_Number'    => $notification1['CL_Number'],
                        'CN_Number'    => $notification1['CN_Number'],
                        'filePath'     => $fileUrl,
                        'status'       => $notification1['status'],
                        'created_at'   => $notification1['created_at'],
                        'updated_at'   => Carbon::now('Africa/Addis_Ababa'),
                    ]);
                }

                DB::commit();
                if ($remoteDb) DB::connection($remoteDb)->commit();

                $emails = $this->getActionEmailRecipients($candidate);
                if ($emails->isNotEmpty()) {
                    $action          = (string) $incident->incident_category;
                    $passport_no     = $passportNo;
                    $candidate_name  = (string) ($candidate->candidate_name ?? $incident->candidate_name);
                    $foreign_partner = (string) ($candidate->foreign_partner ?? '');
                    $ref_no          = (string) ($incident->ref_no ?? $candidate->ref_no ?? '');
                    $action_date     = Carbon::now('Asia/Dubai')->toDateString();
                    $other           = trim((string) $incident->incident_reason . ' ' . (string) ($incident->other_reason ?? ''));

                    $fileDiskPaths = $filePath ? [storage_path('app/public/' . ltrim($filePath, '/'))] : [];

                    foreach ($emails as $to) {
                        $this->sendActionEmail(
                            $to,
                            $action,
                            $passport_no,
                            $candidate_name,
                            $foreign_partner,
                            $ref_no,
                            $action_date,
                            $fileDiskPaths,
                            $other
                        );
                    }
                }

                return response()->json(['success' => true, 'message' => 'Incident saved successfully.']);
            } catch (\Throwable $e) {
                DB::rollBack();
                if ($remoteDb) DB::connection($remoteDb)->rollBack();

                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                return response()->json(['success' => false, 'message' => 'Failed to save incident: ' . $e->getMessage()], 500);
            }
        }

        public function updateVisaDetails(Request $request)
        {
            $request->validate([
                'visa_date'            => 'required|date',
                'visa_expiry_date'     => 'required|date',
                'uid_number'           => 'nullable|string',
                'entry_permit_number'  => 'required|string',
                'visa_copy'            => 'required|file|mimes:pdf|max:5000',
                'candidate_id'         => 'required|integer',
                'visa_number'          => 'nullable|string',
                'VisaDateModalremarks' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $filePath = null;
            $fileUrl = null;
            $remoteDb = null;

            try {
                $candidate = NewCandidate::where('id', (int) $request->candidate_id)->lockForUpdate()->first();
                if (!$candidate) {
                    return response()->json(['success' => false, 'message' => 'Candidate not found.'], 404);
                }

                $passportNo = (string) ($candidate->passport_no ?? '');
                if ($passportNo === '') {
                    return response()->json(['success' => false, 'message' => 'Passport number is missing.'], 422);
                }

                $boaAgreement = Agreement::where('passport_no', $passportNo)
                    ->where('agreement_type', 'BOA')
                    ->first();

                $foreignPartner = $candidate->foreign_partner;
                $remoteDb = $this->getForeignDatabaseName($foreignPartner);

                if (!$remoteDb) {
                    return response()->json(['success' => false, 'message' => 'Remote database not found.'], 404);
                }

                DB::connection($remoteDb)->beginTransaction();

                $formattedVisaDate = Carbon::parse($request->visa_date)->toDateString();
                $formattedVisaExpiryDate = Carbon::parse($request->visa_expiry_date)->toDateString();

                $filePath = $request->file('visa_copy')->store('attachments', 'public');
                if (!$filePath) throw new \RuntimeException('File upload failed.');

                $fileUrl = $this->buildFileUrl($filePath);

                NewCandidate::where('id', (int) $candidate->id)->update([
                    'visa_date'           => $formattedVisaDate,
                    'visa_expiry_date'    => $formattedVisaExpiryDate,
                    'visa_added_date'     => Carbon::now('Asia/Dubai')->toDateString(),
                    'visa_number'         => $request->visa_number,
                    'entry_permit_number' => (string) $request->entry_permit_number,
                    'uid_number'          => $request->uid_number,
                    'visa_date_remark'    => $request->VisaDateModalremarks,
                    'current_status'      => 7,
                ]);

                $pkg = Package::where('passport_no', $passportNo)->lockForUpdate()->first();
                $emp = null;

                if ($pkg) {
                    $pkg->update([
                        'visa_date'      => $formattedVisaDate,
                        'current_status' => 7,
                        'remark'         => $request->VisaDateModalremarks,
                    ]);
                } else {
                    $emp = Employee::where('passport_no', $passportNo)->lockForUpdate()->first();
                    if (!$emp) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'passport_no' => ['Not exist in the inside candidate.'],
                        ]);
                    }
                    $emp->update([
                        'current_status' => 7,
                        'remarks'        => $request->VisaDateModalremarks,
                    ]);
                }

                $existingAttachment = CandidateAttachment::where('candidate_id', (int) $candidate->id)
                    ->where('attachment_type', 'Visa')
                    ->where('attachment_number', $request->visa_number)
                    ->first();

                if ($existingAttachment && $existingAttachment->attachment_file && Storage::disk('public')->exists($existingAttachment->attachment_file)) {
                    Storage::disk('public')->delete($existingAttachment->attachment_file);
                }

                CandidateAttachment::updateOrCreate(
                    [
                        'candidate_id'      => (int) $candidate->id,
                        'attachment_type'   => 'Visa',
                        'attachment_name'   => 'Visa',
                        'attachment_number' => $request->visa_number,
                    ],
                    [
                        'attachment_file' => $filePath,
                        'issued_on'       => Carbon::now('Asia/Dubai')->toDateString(),
                        'created_by'      => auth()->id(),
                    ]
                );

                $this->upsertPackageAttachmentByPassport($passportNo, 'Visa', 'Visa', $filePath, (string) ($request->visa_number ?? null), now('Asia/Dubai')->format('Y-m-d'), auth()->id());
                $this->upsertEmployeeAttachmentByPassport($passportNo, 'Visa', 'Visa', $filePath, (string) ($request->visa_number ?? null), now('Asia/Dubai')->format('Y-m-d'), auth()->id());

                DB::connection($remoteDb)->table('candidates')
                    ->where('ref_no', $candidate->ref_no)
                    ->update([
                        'visa_date'       => $formattedVisaDate,
                        'visa_added_date' => Carbon::now('Africa/Addis_Ababa')->toDateString(),
                        'current_status'  => 7,
                        'visa_file'       => $fileUrl,
                    ]);

                $cnNumber = $candidate->CN_Number ?: 'CN-00000';
                $clNumber = $candidate->CN_Number ?: 'CL-00000';

                $notification = [
                    'role'         => 'sales',
                    'user_id'      => $candidate->sales_name,
                    'reference_no' => $candidate->reference_no,
                    'ref_no'       => $candidate->ref_no,
                    'title'        => 'Visa Date updated for ' . $cnNumber,
                    'message'      => 'Visa Date updated for ' . $cnNumber . ' and the visa date is : ' . $formattedVisaDate,
                    'CL_Number'    => $clNumber,
                    'CN_Number'    => $cnNumber,
                    'status'       => 'Un Read',
                    'filePath'     => $fileUrl,
                    'created_at'   => Carbon::now('Asia/Dubai'),
                ];
                $this->add_notification($notification);

                $message = 'Visa Date updated for ' . $candidate->ref_no . ' and the visa date is : ' . $formattedVisaDate;

                DB::connection($remoteDb)->table('notifications')->insert([
                    'role'         => $notification['role'],
                    'user_id'      => $notification['user_id'],
                    'reference_no' => $notification['reference_no'],
                    'ref_no'       => $notification['ref_no'],
                    'title'        => $notification['title'],
                    'message'      => $message,
                    'CL_Number'    => $notification['CL_Number'],
                    'CN_Number'    => $notification['CN_Number'],
                    'status'       => $notification['status'],
                    'filePath'     => $fileUrl,
                    'created_at'   => $notification['created_at'],
                    'updated_at'   => Carbon::now('Africa/Addis_Ababa'),
                ]);

                DB::connection($remoteDb)->commit();
                DB::commit();

                $emails = $this->getActionEmailRecipients($candidate);
                if ($emails->isNotEmpty()) {
                    $action          = 'Visa Date updated';
                    $passport_no     = $passportNo;
                    $candidate_name  = (string) ($candidate->candidate_name ?? $cnNumber);
                    $foreign_partner = (string) ($candidate->foreign_partner ?? '');
                    $ref_no          = (string) ($candidate->ref_no ?? '');
                    $action_date     = $formattedVisaDate;
                    $other           = (string) ($request->VisaDateModalremarks ?? '');

                    $fileDiskPaths = $this->getCandidateFileDiskPaths((int) $candidate->id, 'Visa', $request->visa_number);

                    foreach ($emails as $to) {
                        $this->sendActionEmail(
                            $to,
                            $action,
                            $passport_no,
                            $candidate_name,
                            $foreign_partner,
                            $ref_no,
                            $action_date,
                            $fileDiskPaths,
                            $other
                        );
                    }
                }

                return response()->json(['success' => true, 'message' => 'Visa details updated successfully in both databases and emails processed successfully.']);
            } catch (\Throwable $e) {
                DB::rollBack();
                if ($remoteDb) DB::connection($remoteDb)->rollBack();

                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        public function saveIncidentAfterVisa(Request $request)
        {
            $request->validate([
                'candidate_id'               => 'required|exists:new_candidates,id',
                'candidate_name'             => 'required|string|max:255',
                'employer_name'              => 'required|string|max:255',
                'reference_no'               => 'required|string|max:255',
                'ref_no'                     => 'required|string|max:255',
                'candidate_nationality'      => 'required|string|max:255',
                'incident_reason'            => 'required|string',
                'other_reason'               => 'nullable|string',
                'proof'                      => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
                'incident_after_visa_remark' => 'nullable|string',
                'customer_decision'          => 'required|in:Refund,Replacement',
                'refund_due_date'            => 'nullable|date',
                'office_charges'             => 'nullable|numeric|min:0',
                'balance_amount'             => 'nullable|numeric|min:0',
                'client_id'                  => 'nullable|integer',
                'package'                    => 'nullable|string',
                'original_passport'          => 'nullable|boolean',
                'worker_belongings'          => 'nullable|boolean',
            ]);

            $candidate = NewCandidate::find((int) $request->candidate_id);
            if (!$candidate) {
                return response()->json(['success' => false, 'message' => 'Candidate not found.'], 404);
            }

            $passportNo = (string) ($candidate->passport_no ?? '');
            if ($passportNo === '') {
                return response()->json(['success' => false, 'message' => 'Passport number is missing.'], 422);
            }

            $foreignPartner = $candidate->foreign_partner ?? null;
            $remoteDb = $this->getForeignDatabaseName($foreignPartner);

            $filterByExistingColumns = function (string $connection, string $table, array $data): array {
                if (!Schema::connection($connection)->hasTable($table)) return [];
                $out = [];
                foreach ($data as $k => $v) {
                    if (Schema::connection($connection)->hasColumn($table, $k)) $out[$k] = $v;
                }
                return $out;
            };

            $firstExistingColumn = function (string $connection, string $table, array $candidates): ?string {
                if (!Schema::connection($connection)->hasTable($table)) return null;
                foreach ($candidates as $col) {
                    if (Schema::connection($connection)->hasColumn($table, $col)) return $col;
                }
                return null;
            };

            $filterLocalColumns = function (string $table, array $data): array {
                if (!Schema::hasTable($table)) return [];
                $out = [];
                foreach ($data as $k => $v) {
                    if (Schema::hasColumn($table, $k)) $out[$k] = $v;
                }
                return $out;
            };

            $nextSeriesRef = function (string $table, string $prefix) {
                $start = strlen($prefix) + 1;
                $max = (int) (DB::table($table)->lockForUpdate()
                    ->where('reference_no', 'like', $prefix . '%')
                    ->selectRaw("COALESCE(MAX(CAST(SUBSTRING(reference_no,{$start}) AS UNSIGNED)),0) m")
                    ->value('m') ?? 0);

                $n = $max + 1;
                while (true) {
                    $ref = $prefix . str_pad((string) $n, 5, '0', STR_PAD_LEFT);
                    $exists = DB::table($table)->where('reference_no', $ref)->exists();
                    if (!$exists) return $ref;
                    $n++;
                }
            };

            $normalizePkg = function ($v): string {
                return strtoupper(str_replace([' ', '_'], ['-', '-'], trim((string) $v)));
            };

            $boaAgreement = Agreement::where('passport_no', $passportNo)
                ->where('agreement_type', 'BOA')
                ->first();

            DB::beginTransaction();
            if ($remoteDb) DB::connection($remoteDb)->beginTransaction();

            $filePath = null;
            $fileUrl = null;

            try {
                $filePath = $request->file('proof')->store('incidents', 'public');
                if (!$filePath) throw new \RuntimeException('File upload failed.');
                $fileUrl = $this->buildFileUrl($filePath);

                $candidate = NewCandidate::where('id', (int) $request->candidate_id)->lockForUpdate()->firstOrFail();

                $incidentCategory = 'Incident After Visa (IAV)';
                $incidentDate = Carbon::now('Asia/Dubai')->toDateString();

                $remarks = trim(
                    (string) $request->incident_reason . ' ' .
                    (string) ($request->incident_after_visa_remark ?? '') . ' ' .
                    (string) ($request->other_reason ?? '')
                );

                $incident = Incident::create([
                    'incident_category' => $incidentCategory,
                    'candidate_id'      => (int) $request->candidate_id,
                    'candidate_name'    => (string) $request->candidate_name,
                    'employer_name'     => (string) $request->employer_name,
                    'reference_no'      => (string) $request->reference_no,
                    'ref_no'            => (string) $request->ref_no,
                    'nationality'       => (string) $request->candidate_nationality,
                    'country'           => 'Dubai',
                    'company'           => 'Vienna',
                    'branch'            => 'Vienna',
                    'incident_reason'   => (string) $request->incident_reason,
                    'other_reason'      => $request->other_reason,
                    'proof'             => $filePath,
                    'note'              => $request->incident_after_visa_remark,
                    'created_by'        => auth()->id(),
                ]);

                $candidate->update([
                    'incident_after_visa_date'   => Carbon::now('Asia/Dubai'),
                    'incident_after_visa_remark' => $request->incident_after_visa_remark,
                    'current_status'             => 8,
                ]);

                $refundType = null;
                $pkg = null;
                $emp = Employee::where('passport_no', $passportNo)->lockForUpdate()->first();

                if ($emp) {
                    $emp->update([
                        'inside_status'  => 3,
                        'current_status' => 8,
                        'incident_type'  => $incidentCategory,
                        'incident_date'  => $incidentDate,
                        'remarks'        => $remarks,
                    ]);
                    $refundType = 'employee';

                    $this->upsertEmployeeAttachmentByPassport(
                        $passportNo,
                        $incidentCategory,
                        $incidentCategory,
                        $filePath,
                        null,
                        $incidentDate,
                        auth()->id()
                    );
                } else {
                    $pkg = Package::where('passport_no', $passportNo)->lockForUpdate()->first();
                    if (!$pkg) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'passport_no' => ['Not exist in the inside candidate.'],
                        ]);
                    }

                    $pkg->update([
                        'inside_status' => 5,
                        'incident_type' => $incidentCategory,
                        'incident_date' => $incidentDate,
                        'remark'        => $remarks,
                    ]);
                    $refundType = 'package';

                    $this->upsertPackageAttachmentByPassport(
                        $passportNo,
                        $incidentCategory,
                        $incidentCategory,
                        $filePath,
                        null,
                        $incidentDate,
                        auth()->id()
                    );
                }

                $packageValue = $request->input('package');
                if (!$packageValue && $emp && !empty($emp->package)) $packageValue = $emp->package;
                if (!$packageValue && $pkg && !empty($pkg->package)) $packageValue = $pkg->package;
                if ($packageValue) {
                    $refundType = $emp ? 'employee' : ($normalizePkg($packageValue) === 'PKG-1' ? 'package' : $refundType);
                }

                $clientId = $request->input('client_id');
                if ($clientId === null && isset($boaAgreement->client_id)) $clientId = $boaAgreement->client_id;

                $agreementRefNo = (string) ($boaAgreement->reference_no ?? '');

                if ($agreementRefNo !== '') {
                    Agreement::where('reference_no', $agreementRefNo)->update([
                        'status' => 4,
                        'notes'  => $remarks,
                    ]);

                    if (Schema::hasTable('invoices')) {
                        $invUpdate = [];
                        if (Schema::hasColumn('invoices', 'status')) $invUpdate['status'] = 'Cancelled';
                        if (Schema::hasColumn('invoices', 'notes'))  $invUpdate['notes']  = $remarks;

                        if (!empty($invUpdate) && Schema::hasColumn('invoices', 'agreement_reference_no')) {
                            DB::table('invoices')->where('agreement_reference_no', $agreementRefNo)->update($invUpdate);
                        }
                    }
                }

                $agreementNo = $boaAgreement->agreement_no
                    ?? $boaAgreement->reference_no
                    ?? $boaAgreement->agreement_reference_no
                    ?? null;

                $contractStart = $boaAgreement->contract_start_date
                    ?? $boaAgreement->start_date
                    ?? $boaAgreement->agreement_start_date
                    ?? null;

                $contractEnd = $boaAgreement->contract_end_date
                    ?? $boaAgreement->end_date
                    ?? $boaAgreement->agreement_end_date
                    ?? null;

                $contractedAmount = $boaAgreement->total_amount
                    ?? $boaAgreement->contracted_amount
                    ?? $boaAgreement->contract_amount
                    ?? null;

                $salary = $candidate->agreed_salary ?? $candidate->salary ?? null;

                $decision = (string) $request->customer_decision;
                $dueDate = $request->filled('refund_due_date') ? Carbon::parse($request->refund_due_date)->toDateString() : null;

                $baseRecord = [
                    'candidate_id'                => (int) $candidate->id,
                    'client_id'                   => $clientId ? (int) $clientId : null,
                    'type'                        => (string) $incident->incident_category,
                    'candidate_name'              => (string) ($candidate->candidate_name ?? $request->candidate_name),
                    'sponsor_name'                => (string) $request->employer_name,
                    'passport_no'                 => $passportNo,
                    'nationality'                 => (string) ($candidate->nationality ?? $request->candidate_nationality),
                    'foreign_partner'             => (string) ($candidate->foreign_partner ?? ''),
                    'agreement_no'                => $agreementNo,
                    'contract_start_date'         => $contractStart,
                    'contract_end_date'           => $contractEnd,
                    'return_date'                 => $incidentDate,
                    'maid_worked_days'            => null,
                    'contracted_amount'           => $contractedAmount,
                    'salary'                      => $salary,
                    'worker_salary_for_work_days' => null,
                    'salary_payment_method'       => null,
                    'payment_proof'               => null,
                    'office_charges'              => $request->office_charges,
                    'refunded_amount'             => $request->balance_amount,
                    'refund_date'                 => $dueDate,
                    'original_passport'           => $request->boolean('original_passport', false),
                    'worker_belongings'           => $request->boolean('worker_belongings', false),
                    'status'                      => 'open',
                    'sales_name'                  => $candidate->sales_name,
                    'updated_by_sales_name'       => auth()->id(),
                    'package'                     => $packageValue,
                ];

                if ($decision === 'Refund') {
                    $existingRefund = Refund::where('candidate_id', (int) $candidate->id)
                        ->where('type', (string) $incident->incident_category)
                        ->lockForUpdate()
                        ->first();

                    $refundRefNo = $existingRefund && !empty($existingRefund->reference_no) ? (string) $existingRefund->reference_no : (string) $nextSeriesRef('refunds', 'REF-');

                    $refundRecord = array_merge($baseRecord, [
                        'reference_no' => $refundRefNo,
                        'refund_type'  => $refundType,
                    ]);

                    Refund::updateOrCreate(
                        ['candidate_id' => (int) $candidate->id, 'type' => (string) $incident->incident_category],
                        $filterLocalColumns('refunds', $refundRecord)
                    );
                } else {
                    $existingReplacement = Replacement::where('candidate_id', (int) $candidate->id)
                        ->where('type', (string) $incident->incident_category)
                        ->lockForUpdate()
                        ->first();

                    $repRefNo = $existingReplacement && !empty($existingReplacement->reference_no) ? (string) $existingReplacement->reference_no : (string) $nextSeriesRef('replacements', 'REP-');

                    $replacementRecord = array_merge($baseRecord, [
                        'reference_no'     => $repRefNo,
                        'replacement_type' => $refundType,
                    ]);

                    Replacement::updateOrCreate(
                        ['candidate_id' => (int) $candidate->id, 'type' => (string) $incident->incident_category],
                        $filterLocalColumns('replacements', $replacementRecord)
                    );
                }

                if ($remoteDb) {
                    $nowRemote = Carbon::now('Africa/Addis_Ababa');

                    if ($agreementRefNo !== '') {
                        $agrRefCol = $firstExistingColumn($remoteDb, 'agreements', ['reference_no', 'agreement_reference_no', 'agreement_no']);
                        $agrUpdate = $filterByExistingColumns($remoteDb, 'agreements', ['status' => 4, 'notes' => $remarks]);
                        if ($agrRefCol && !empty($agrUpdate)) {
                            DB::connection($remoteDb)->table('agreements')->where($agrRefCol, $agreementRefNo)->update($agrUpdate);
                        }

                        $invRefCol = $firstExistingColumn($remoteDb, 'invoices', ['agreement_reference_no', 'agreement_ref_no', 'reference_no']);
                        $invUpdate = $filterByExistingColumns($remoteDb, 'invoices', ['status' => 'Cancelled', 'notes' => $remarks]);
                        if ($invRefCol && !empty($invUpdate)) {
                            DB::connection($remoteDb)->table('invoices')->where($invRefCol, $agreementRefNo)->update($invUpdate);
                        }
                    }

                    DB::connection($remoteDb)->table('incidents')->insert([
                        'incident_category' => $incidentCategory,
                        'candidate_id'      => (int) $request->candidate_id,
                        'candidate_name'    => (string) $request->candidate_name,
                        'reference_no'      => (string) $request->reference_no,
                        'ref_no'            => (string) $request->ref_no,
                        'country'           => 'Dubai',
                        'company'           => 'Alebdaa',
                        'branch'            => 'Alebdaa',
                        'incident_reason'   => (string) $request->incident_reason,
                        'other_reason'      => $request->other_reason,
                        'proof'             => $fileUrl,
                        'note'              => $request->incident_after_visa_remark,
                        'created_by'        => auth()->id(),
                        'created_at'        => $nowRemote,
                        'updated_at'        => $nowRemote,
                    ]);

                    DB::connection($remoteDb)->table('candidates')
                        ->where('ref_no', $candidate->ref_no)
                        ->update([
                            'incident_after_visa_date' => $nowRemote,
                            'current_status'           => 8,
                        ]);

                    DB::connection($remoteDb)->table('notifications')->insert([
                        'role'       => 'sales',
                        'title'      => $incidentCategory . ' of ' . $candidate->CN_Number,
                        'message'    => $incidentCategory . ' of ' . $candidate->CN_Number . ' and the reason is: ' . (string) $request->incident_reason,
                        'CL_Number'  => $candidate->CN_Number,
                        'CN_Number'  => $candidate->CN_Number,
                        'ref_no'     => $candidate->ref_no,
                        'status'     => 'Un Read',
                        'filePath'   => $fileUrl,
                        'created_at' => $nowRemote,
                        'updated_at' => $nowRemote,
                    ]);

                    if ($decision === 'Refund' && Schema::connection($remoteDb)->hasTable('refunds')) {
                        $existingLocalRefund = Refund::where('candidate_id', (int) $candidate->id)->where('type', (string) $incident->incident_category)->first();
                        $refundRefNo = $existingLocalRefund && !empty($existingLocalRefund->reference_no) ? (string) $existingLocalRefund->reference_no : (string) $nextSeriesRef('refunds', 'REF-');

                        $remoteRefund = $filterByExistingColumns($remoteDb, 'refunds', array_merge($baseRecord, [
                            'reference_no' => $refundRefNo,
                            'refund_type'  => $refundType,
                        ]));

                        if (!empty($remoteRefund)) {
                            DB::connection($remoteDb)->table('refunds')->updateOrInsert(
                                $filterByExistingColumns($remoteDb, 'refunds', [
                                    'candidate_id' => (int) $candidate->id,
                                    'type'         => (string) $incident->incident_category,
                                ]),
                                array_merge($remoteRefund, ['created_at' => $nowRemote, 'updated_at' => $nowRemote])
                            );
                        }
                    }

                    if ($decision === 'Replacement' && Schema::connection($remoteDb)->hasTable('replacements')) {
                        $existingLocalRep = Replacement::where('candidate_id', (int) $candidate->id)->where('type', (string) $incident->incident_category)->first();
                        $repRefNo = $existingLocalRep && !empty($existingLocalRep->reference_no) ? (string) $existingLocalRep->reference_no : (string) $nextSeriesRef('replacements', 'REP-');

                        $remoteReplacement = $filterByExistingColumns($remoteDb, 'replacements', array_merge($baseRecord, [
                            'reference_no'     => $repRefNo,
                            'replacement_type' => $refundType,
                        ]));

                        if (!empty($remoteReplacement)) {
                            DB::connection($remoteDb)->table('replacements')->updateOrInsert(
                                $filterByExistingColumns($remoteDb, 'replacements', [
                                    'candidate_id' => (int) $candidate->id,
                                    'type'         => (string) $incident->incident_category,
                                ]),
                                array_merge($remoteReplacement, ['created_at' => $nowRemote, 'updated_at' => $nowRemote])
                            );
                        }
                    }
                }

                DB::commit();
                if ($remoteDb) DB::connection($remoteDb)->commit();

                $emails = $this->getActionEmailRecipients($candidate);
                if ($emails->isNotEmpty()) {
                    $action          = $incidentCategory;
                    $passport_no     = $passportNo;
                    $candidate_name  = (string) ($candidate->candidate_name ?? $request->candidate_name);
                    $foreign_partner = (string) ($candidate->foreign_partner ?? '');
                    $ref_no          = (string) ($candidate->ref_no ?? $request->ref_no);
                    $action_date     = Carbon::now('Asia/Dubai')->toDateString();
                    $other           = trim(
                        (string) ($request->incident_reason ?? '') . ' ' .
                        (string) ($request->other_reason ?? '') . ' ' .
                        (string) ($request->incident_after_visa_remark ?? '')
                    );

                    $fileDiskPaths = $filePath ? [storage_path('app/public/' . ltrim($filePath, '/'))] : [];

                    foreach ($emails as $to) {
                        $this->sendActionEmail(
                            $to,
                            $action,
                            $passport_no,
                            $candidate_name,
                            $foreign_partner,
                            $ref_no,
                            $action_date,
                            $fileDiskPaths,
                            $other
                        );
                    }
                }

                return response()->json(['success' => true, 'message' => 'Incident saved successfully.']);
            } catch (\Throwable $e) {
                DB::rollBack();
                if ($remoteDb) DB::connection($remoteDb)->rollBack();

                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                return response()->json(['success' => false, 'message' => 'Failed to save incident: ' . $e->getMessage()], 500);
            }
        }

        public function updateArrivedDate(Request $request)
        {
            $remarks = $request->input('remarks', $request->input('updateArrivedDateModalremarks', ''));
            $request->merge(['remarks' => $remarks]);

            $request->validate([
                'arrived_date'              => 'required|date',
                'remarks'                   => 'nullable|string',
                'candidate_id'              => 'required|integer',
                'client_id'                 => 'required|integer',
                'candidate_passport_expiry' => 'required|date',
                'passport_stamp_image'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:10000',
                'ticket_attachment'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:10000',
                'icp_proof_attachment'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:10000',
            ]);

            $paths = ['stamp' => null, 'ticket' => null, 'icp' => null];
            $remoteDb = null;

            $filterByExistingColumns = function (string $connection, string $table, array $data): array {
                if (!Schema::connection($connection)->hasTable($table)) return [];
                $out = [];
                foreach ($data as $k => $v) {
                    if (Schema::connection($connection)->hasColumn($table, $k)) $out[$k] = $v;
                }
                return $out;
            };

            $firstExistingColumn = function (string $connection, string $table, array $candidates): ?string {
                if (!Schema::connection($connection)->hasTable($table)) return null;
                foreach ($candidates as $col) {
                    if (Schema::connection($connection)->hasColumn($table, $col)) return $col;
                }
                return null;
            };

            $firstExistingLocalColumn = function (string $table, array $candidates): ?string {
                if (!Schema::hasTable($table)) return null;
                foreach ($candidates as $col) {
                    if (Schema::hasColumn($table, $col)) return $col;
                }
                return null;
            };

            $upsertCandidateAttachment = function (int $candidateId, string $type, string $name, string $filePath): void {
                $oldFile = CandidateAttachment::where([
                    ['candidate_id', '=', $candidateId],
                    ['attachment_type', '=', $type],
                    ['attachment_name', '=', $name],
                ])->value('attachment_file');

                if ($oldFile && Storage::disk('public')->exists($oldFile) && $oldFile !== $filePath) {
                    Storage::disk('public')->delete($oldFile);
                }

                CandidateAttachment::updateOrCreate(
                    [
                        'candidate_id'    => $candidateId,
                        'attachment_type' => $type,
                        'attachment_name' => $name,
                    ],
                    [
                        'attachment_file' => $filePath,
                        'issued_on'       => now('Asia/Dubai')->format('Y-m-d'),
                        'created_by'      => auth()->id(),
                    ]
                );
            };

            DB::beginTransaction();

            try {
                $paths['stamp']  = $request->file('passport_stamp_image')->store('attachments', 'public');
                $paths['ticket'] = $request->file('ticket_attachment')->store('attachments', 'public');
                $paths['icp']    = $request->file('icp_proof_attachment')->store('attachments', 'public');

                if (!$paths['stamp'] || !$paths['ticket'] || !$paths['icp']) {
                    throw new \RuntimeException('File upload failed.');
                }

                $stampUrl       = $this->buildFileUrl($paths['stamp']);
                $arrivedDate    = Carbon::parse($request->arrived_date)->toDateString();
                $passportExpiry = Carbon::parse($request->candidate_passport_expiry)->toDateString();

                $cand   = NewCandidate::where('id', (int) $request->candidate_id)->lockForUpdate()->firstOrFail();
                $client = CRM::findOrFail((int) $request->client_id);

                $passportNo = (string) ($cand->passport_no ?? '');
                if ($passportNo === '') {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'passport_no' => ['Passport number is missing for this candidate.'],
                    ]);
                }

                $pkg = Package::where('passport_no', $passportNo)->lockForUpdate()->first();
                $emp = null;

                if (!$pkg) {
                    $emp = Employee::where('passport_no', $passportNo)->lockForUpdate()->first();
                    if (!$emp) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'passport_no' => ['Not exist in the inside candidate.'],
                        ]);
                    }
                }

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

                        if (!$exists) return $cn;
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

                $candTable = $cand->getTable();
                $expiryCol = $firstExistingLocalColumn($candTable, [
                    'candidate_passport_expiry',
                    'passport_expiry',
                    'passport_expiry_date',
                    'passport_expire_date',
                    'passport_expiry_dt',
                ]);

                $candUpdate = [
                    'arrived_date'       => $arrivedDate,
                    'arrived_added_date' => now('Asia/Dubai'),
                    'current_status'     => 15,
                ];

                if (Schema::hasColumn($candTable, 'updateArrivedDateModalremarks')) {
                    $candUpdate['updateArrivedDateModalremarks'] = $remarks;
                } elseif (Schema::hasColumn($candTable, 'remarks')) {
                    $candUpdate['remarks'] = $remarks;
                }

                if ($expiryCol) $candUpdate[$expiryCol] = $passportExpiry;

                $cand->update($candUpdate);

                $cnCols = ['CN_Number', 'cn_number', 'cnNumber'];

                $pkgTable = (new Package)->getTable();
                if (Schema::hasTable($pkgTable)) {
                    foreach ($cnCols as $col) {
                        if (Schema::hasColumn($pkgTable, $col)) {
                            Package::where('passport_no', $passportNo)->update([$col => $cnNumber]);
                            break;
                        }
                    }
                }

                $empTable = (new Employee)->getTable();
                if (Schema::hasTable($empTable)) {
                    foreach ($cnCols as $col) {
                        if (Schema::hasColumn($empTable, $col)) {
                            Employee::where('passport_no', $passportNo)->update([$col => $cnNumber]);
                            break;
                        }
                    }
                }

                if ($pkg) {
                    Package::where('passport_no', $passportNo)->update([
                        'inside_status'             => 1,
                        'inside_country_or_outside' => 2,
                        'arrived_date'              => $arrivedDate,
                        'passport_expiry_date'      => $passportExpiry,
                        'current_status'            => 15,
                        'remark'                    => $remarks,
                    ]);
                } else {
                    Employee::where('passport_no', $passportNo)->update([
                        'inside_status'             => 1,
                        'inside_country_or_outside' => 2,
                        'arrived_date'              => $arrivedDate,
                        'passport_expiry_date'      => $passportExpiry,
                        'current_status'            => 15,
                        'remarks'                   => $remarks,
                    ]);
                }

                $upsertCandidateAttachment((int) $cand->id, 'Passport with Immigration Stamp', 'Passport with Immigration Stamp', $paths['stamp']);
                $upsertCandidateAttachment((int) $cand->id, 'Ticket', 'Ticket', $paths['ticket']);
                $upsertCandidateAttachment((int) $cand->id, 'ICP Proof', 'ICP Proof', $paths['icp']);

                $this->upsertPackageAttachmentByPassport($passportNo, 'Passport with Immigration Stamp', 'Passport with Immigration Stamp', $paths['stamp'], null, now('Asia/Dubai')->format('Y-m-d'), auth()->id());
                $this->upsertPackageAttachmentByPassport($passportNo, 'Ticket', 'Ticket', $paths['ticket'], null, now('Asia/Dubai')->format('Y-m-d'), auth()->id());
                $this->upsertPackageAttachmentByPassport($passportNo, 'ICP Proof', 'ICP Proof', $paths['icp'], null, now('Asia/Dubai')->format('Y-m-d'), auth()->id());

                $this->upsertEmployeeAttachmentByPassport($passportNo, 'Passport with Immigration Stamp', 'Passport with Immigration Stamp', $paths['stamp'], null, now('Asia/Dubai')->format('Y-m-d'), auth()->id());
                $this->upsertEmployeeAttachmentByPassport($passportNo, 'Ticket', 'Ticket', $paths['ticket'], null, now('Asia/Dubai')->format('Y-m-d'), auth()->id());
                $this->upsertEmployeeAttachmentByPassport($passportNo, 'ICP Proof', 'ICP Proof', $paths['icp'], null, now('Asia/Dubai')->format('Y-m-d'), auth()->id());

                if (!Schema::hasTable('office')) {
                    throw new \RuntimeException('Office table not found.');
                }

                if ($pkg) {
                    DB::table('office')
                        ->where('candidate_id', (int) $pkg->id)
                        ->where('type', 'package')
                        ->update(['status' => 0, 'updated_at' => now()]);

                    $inserted = DB::table('office')->insert([
                        'candidate_id'    => (int) $pkg->id,
                        'category'        => 'New Arrival',
                        'type'            => 'package',
                        'returned_date'   => now()->format('Y-m-d'),
                        'expiry_date'     => $passportExpiry,
                        'ica_proof'       => $paths['icp'],
                        'overstay_days'   => 0,
                        'fine_amount'     => 0,
                        'passport_status' => 'Office',
                        'status'          => 1,
                        'created_by'      => auth()->id(),
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);

                    if (!$inserted) throw new \RuntimeException('Failed to save office entry.');
                } else {
                    DB::table('office')
                        ->where('candidate_id', (int) $emp->id)
                        ->where('type', 'employee')
                        ->update(['status' => 0, 'updated_at' => now()]);

                    $inserted = DB::table('office')->insert([
                        'candidate_id'    => (int) $emp->id,
                        'category'        => 'New Arrival',
                        'type'            => 'employee',
                        'returned_date'   => now()->format('Y-m-d'),
                        'expiry_date'     => $passportExpiry,
                        'ica_proof'       => $paths['icp'],
                        'overstay_days'   => 0,
                        'fine_amount'     => 0,
                        'passport_status' => 'Office',
                        'status'          => 1,
                        'created_by'      => auth()->id(),
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);

                    if (!$inserted) throw new \RuntimeException('Failed to save office entry.');
                }

                $remoteDb = $this->getForeignDatabaseName($cand->foreign_partner);

                if ($remoteDb) {
                    DB::connection($remoteDb)->beginTransaction();

                    $remoteCandidatesUpdate = $filterByExistingColumns($remoteDb, 'candidates', [
                        'current_status'     => 15,
                        'arrived_date'       => $arrivedDate,
                        'arrived_added_date' => now('Asia/Dubai'),
                    ]);

                    $remoteCnCol = $firstExistingColumn($remoteDb, 'candidates', ['CN_Number', 'cn_number', 'cnNumber']);
                    if ($remoteCnCol) $remoteCandidatesUpdate[$remoteCnCol] = $cnNumber;

                    $remoteExpiryCol = $firstExistingColumn($remoteDb, 'candidates', [
                        'candidate_passport_expiry',
                        'passport_expiry',
                        'passport_expiry_date',
                        'passport_expire_date',
                        'passport_expiry_dt',
                    ]);
                    if ($remoteExpiryCol) $remoteCandidatesUpdate[$remoteExpiryCol] = $passportExpiry;

                    $remoteRemarksCol = $firstExistingColumn($remoteDb, 'candidates', ['updateArrivedDateModalremarks', 'remarks']);
                    if ($remoteRemarksCol) $remoteCandidatesUpdate[$remoteRemarksCol] = $remarks;

                    if (!empty($remoteCandidatesUpdate)) {
                        DB::connection($remoteDb)->table('candidates')->where('ref_no', $cand->ref_no)->update($remoteCandidatesUpdate);
                    }

                    $clNumber = $client->CL_Number ?? 'CL-00000';

                    $remoteNotifData = $filterByExistingColumns($remoteDb, 'notifications', [
                        'role'       => 'sales',
                        'title'      => 'Arrival of ' . $cnNumber,
                        'message'    => 'Arrival of ' . $cnNumber . ' on ' . $arrivedDate,
                        'CL_Number'  => $clNumber,
                        'filePath'   => $stampUrl,
                        'status'     => 'Un Read',
                        'created_at' => now('Africa/Addis_Ababa'),
                        'updated_at' => now('Africa/Addis_Ababa'),
                    ]);

                    $notifCnCol = $firstExistingColumn($remoteDb, 'notifications', ['CN_Number', 'cn_number', 'cnNumber']);
                    if ($notifCnCol) $remoteNotifData[$notifCnCol] = $cnNumber;

                    if (!empty($remoteNotifData)) {
                        DB::connection($remoteDb)->table('notifications')->insert($remoteNotifData);
                    }

                    $remotePkgUpdate = $filterByExistingColumns($remoteDb, 'packages', [
                        'inside_status'             => 1,
                        'inside_country_or_outside' => 2,
                        'arrived_date'              => $arrivedDate,
                        'passport_expiry_date'      => $passportExpiry,
                        'current_status'            => 15,
                        'remark'                    => $remarks,
                    ]);

                    if (!empty($remotePkgUpdate)) {
                        DB::connection($remoteDb)->table('packages')->where('passport_no', $passportNo)->update($remotePkgUpdate);
                    }

                    $remoteEmpUpdate = $filterByExistingColumns($remoteDb, 'employees', [
                        'inside_status'             => 1,
                        'inside_country_or_outside' => 2,
                        'arrived_date'              => $arrivedDate,
                        'passport_expiry_date'      => $passportExpiry,
                        'current_status'            => 15,
                        'remarks'                   => $remarks,
                    ]);

                    if (!empty($remoteEmpUpdate)) {
                        DB::connection($remoteDb)->table('employees')->where('passport_no', $passportNo)->update($remoteEmpUpdate);
                    }

                    DB::connection($remoteDb)->commit();
                }

                DB::commit();

                $emails = $this->getActionEmailRecipients($cand);
                if ($emails->isNotEmpty()) {
                    $action          = 'Arrival';
                    $passport_no     = $passportNo;
                    $candidate_name  = (string) ($cand->candidate_name ?? $cnNumber);
                    $foreign_partner = (string) ($cand->foreign_partner ?? '');
                    $ref_no          = (string) ($cand->ref_no ?? '');
                    $action_date     = $arrivedDate;
                    $other           = (string) $remarks;

                    $fileDiskPaths = $this->getCandidateFileDiskPaths((int) $cand->id, 'Passport with Immigration Stamp');

                    foreach ($emails as $to) {
                        $this->sendActionEmail(
                            $to,
                            $action,
                            $passport_no,
                            $candidate_name,
                            $foreign_partner,
                            $ref_no,
                            $action_date,
                            $fileDiskPaths,
                            $other
                        );
                    }
                }

                return response()->json(['success' => true, 'message' => 'Arrival updated successfully.']);
            } catch (\Throwable $e) {
                DB::rollBack();

                if ($remoteDb) {
                    try {
                        DB::connection($remoteDb)->rollBack();
                    } catch (\Throwable $ignore) {
                    }
                }

                foreach ($paths as $p) {
                    if ($p && Storage::disk('public')->exists($p)) {
                        Storage::disk('public')->delete($p);
                    }
                }

                $status = $e instanceof \Illuminate\Validation\ValidationException ? 422 : 500;

                return response()->json([
                    'success' => false,
                    'message' => $e instanceof \Illuminate\Validation\ValidationException ? 'Validation failed.' : 'Arrival update failed.',
                    'error'   => $e->getMessage(),
                ], $status);
            }
        }

        public function saveIncidentAfterArrival(Request $request)
        {
            $request->validate([
                'candidate_id'                     => 'required|exists:new_candidates,id',
                'candidate_name'                   => 'required|string|max:255',
                'employer_name'                    => 'required|string|max:255',
                'reference_no'                     => 'required|string|max:255',
                'ref_no'                           => 'required|string|max:255',
                'candidate_nationality'            => 'required|string|max:255',
                'incident_reason'                  => 'required|string',
                'other_reason'                     => 'nullable|string',
                'proof'                            => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
                'IncidentAfterArrivalModalremarks' => 'nullable|string',
                'customer_decision'                => 'required|in:Refund,Replacement',
                'refund_due_date'                  => 'nullable|date',
                'office_charges'                   => 'nullable|numeric|min:0',
                'balance_amount'                   => 'nullable|numeric|min:0',
                'client_id'                        => 'nullable|integer',
                'package'                          => 'nullable|string',
                'original_passport'                => 'nullable|boolean',
                'worker_belongings'                => 'nullable|boolean',
            ]);

            $candidate = NewCandidate::find((int) $request->candidate_id);
            if (!$candidate) {
                return response()->json(['success' => false, 'message' => 'Candidate not found.'], 404);
            }

            $passportNo = (string) ($candidate->passport_no ?? '');
            if ($passportNo === '') {
                return response()->json(['success' => false, 'message' => 'Passport number is missing.'], 422);
            }

            $foreignPartner = $candidate->foreign_partner ?? null;
            $remoteDb = $this->getForeignDatabaseName($foreignPartner);

            $filterByExistingColumns = function (string $connection, string $table, array $data): array {
                if (!Schema::connection($connection)->hasTable($table)) return [];
                $out = [];
                foreach ($data as $k => $v) {
                    if (Schema::connection($connection)->hasColumn($table, $k)) $out[$k] = $v;
                }
                return $out;
            };

            $firstExistingColumn = function (string $connection, string $table, array $candidates): ?string {
                if (!Schema::connection($connection)->hasTable($table)) return null;
                foreach ($candidates as $col) {
                    if (Schema::connection($connection)->hasColumn($table, $col)) return $col;
                }
                return null;
            };

            $extractPkgValue = function ($row): ?string {
                if (!$row) return null;
                foreach (['package', 'package_code', 'package_name', 'package_type'] as $k) {
                    if (isset($row->{$k}) && trim((string) $row->{$k}) !== '') return (string) $row->{$k};
                }
                return null;
            };

            $getNextSeriesRef = function (string $prefix, string $table) : string {
                $digits = 5;
                $like = $prefix . '-%';
                $col = 'reference_no';

                $maxRow = DB::table($table)
                    ->selectRaw("MAX(CAST(SUBSTRING(`$col`, ? + 2) AS UNSIGNED)) as mx", [strlen($prefix)])
                    ->where($col, 'like', $like)
                    ->lockForUpdate()
                    ->first();

                $mx = (int) (($maxRow->mx ?? 0) ?: 0);
                $next = $mx + 1;

                while (true) {
                    $ref = $prefix . '-' . str_pad((string) $next, $digits, '0', STR_PAD_LEFT);
                    $exists = DB::table($table)->where($col, $ref)->exists();
                    if (!$exists) return $ref;
                    $next++;
                }
            };

            DB::beginTransaction();
            if ($remoteDb) DB::connection($remoteDb)->beginTransaction();

            $filePath = null;
            $fileUrl = null;

            try {
                $incidentCategory = 'Incident After Arrival (IAA)';
                $incidentDate = Carbon::now('Asia/Dubai')->toDateString();

                $existingLocalIncident = Incident::where('candidate_id', (int) $request->candidate_id)
                    ->where('incident_category', $incidentCategory)
                    ->first();

                if ($existingLocalIncident) {
                    if ($existingLocalIncident->proof && Storage::disk('public')->exists($existingLocalIncident->proof)) {
                        Storage::disk('public')->delete($existingLocalIncident->proof);
                    }
                    $existingLocalIncident->delete();
                }

                $filePath = $request->file('proof')->store('incidents', 'public');
                if (!$filePath) throw new \RuntimeException('File upload failed.');
                $fileUrl = $this->buildFileUrl($filePath);

                $candidate = NewCandidate::where('id', (int) $request->candidate_id)->lockForUpdate()->firstOrFail();

                $remarks = trim(
                    (string) $request->incident_reason . ' ' .
                    (string) ($request->IncidentAfterArrivalModalremarks ?? '') . ' ' .
                    (string) ($request->other_reason ?? '')
                );

                $incident = Incident::create([
                    'incident_category' => $incidentCategory,
                    'candidate_id'      => (int) $request->candidate_id,
                    'candidate_name'    => (string) $request->candidate_name,
                    'employer_name'     => (string) $request->employer_name,
                    'reference_no'      => (string) $request->reference_no,
                    'ref_no'            => (string) $request->ref_no,
                    'nationality'       => (string) $request->candidate_nationality,
                    'country'           => 'Dubai',
                    'company'           => 'Alebdaa',
                    'branch'            => 'Alebdaa',
                    'incident_reason'   => (string) $request->incident_reason,
                    'other_reason'      => $request->other_reason,
                    'proof'             => $filePath,
                    'note'              => $request->IncidentAfterArrivalModalremarks,
                    'created_by'        => auth()->id(),
                ]);

                $candidate->update([
                    'incident_after_arrival_date' => Carbon::now('Asia/Dubai'),
                    'current_status'              => 16,
                ]);

                $pkg = Package::where('passport_no', $passportNo)->lockForUpdate()->first();
                $emp = null;

                if (!$pkg) {
                    $emp = Employee::where('passport_no', $passportNo)->lockForUpdate()->first();
                    if (!$emp) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'passport_no' => ['Not exist in the inside candidate.'],
                        ]);
                    }
                }

                $recordType = $emp ? 'employee' : 'package';

                if ($pkg) {
                    $pkg->update([
                        'inside_status' => 5,
                        'incident_type' => $incidentCategory,
                        'incident_date' => $incidentDate,
                        'remark'        => $remarks,
                    ]);

                    $this->upsertPackageAttachmentByPassport(
                        $passportNo,
                        $incidentCategory,
                        $incidentCategory,
                        $filePath,
                        null,
                        $incidentDate,
                        auth()->id()
                    );
                } else {
                    $emp->update([
                        'inside_status'  => 3,
                        'current_status' => 16,
                        'incident_type'  => $incidentCategory,
                        'incident_date'  => $incidentDate,
                        'remarks'        => $remarks,
                    ]);

                    $this->upsertEmployeeAttachmentByPassport(
                        $passportNo,
                        $incidentCategory,
                        $incidentCategory,
                        $filePath,
                        null,
                        $incidentDate,
                        auth()->id()
                    );
                }

                $packageValue = $request->input('package');
                if (!$packageValue) {
                    $packageValue = $extractPkgValue($emp) ?: $extractPkgValue($pkg);
                }

                $boaAgreement = Agreement::where('passport_no', $passportNo)
                    ->where('agreement_type', 'BOA')
                    ->first();

                $clientId = $request->input('client_id');
                if ($clientId === null && isset($boaAgreement->client_id)) $clientId = $boaAgreement->client_id;

                $agreementRefNo = (string) ($boaAgreement->reference_no ?? '');

                if ($agreementRefNo !== '') {
                    Agreement::where('reference_no', $agreementRefNo)->update([
                        'status' => 4,
                        'notes'  => $remarks,
                    ]);

                    if (Schema::hasTable('invoices')) {
                        $invUpdate = [];
                        if (Schema::hasColumn('invoices', 'status')) $invUpdate['status'] = 'Cancelled';
                        if (Schema::hasColumn('invoices', 'notes'))  $invUpdate['notes']  = $remarks;

                        if (!empty($invUpdate) && Schema::hasColumn('invoices', 'agreement_reference_no')) {
                            DB::table('invoices')->where('agreement_reference_no', $agreementRefNo)->update($invUpdate);
                        }
                    }
                }

                $agreementNo = $boaAgreement->agreement_no
                    ?? $boaAgreement->reference_no
                    ?? $boaAgreement->agreement_reference_no
                    ?? null;

                $contractStart = $boaAgreement->contract_start_date
                    ?? $boaAgreement->start_date
                    ?? $boaAgreement->agreement_start_date
                    ?? null;

                $contractEnd = $boaAgreement->contract_end_date
                    ?? $boaAgreement->end_date
                    ?? $boaAgreement->agreement_end_date
                    ?? null;

                $contractedAmount = $boaAgreement->total_amount
                    ?? $boaAgreement->contracted_amount
                    ?? $boaAgreement->contract_amount
                    ?? null;

                $salary = $candidate->agreed_salary ?? $candidate->salary ?? null;

                $decision = (string) $request->customer_decision;
                $dueDate = $request->filled('refund_due_date') ? Carbon::parse($request->refund_due_date)->toDateString() : null;

                $refundRefNo = null;
                $replacementRefNo = null;

                if ($decision === 'Refund') {
                    $refundRefNo = $getNextSeriesRef('REF', 'refunds');
                } else {
                    $replacementRefNo = $getNextSeriesRef('REP', 'replacements');
                }

                $commonRecord = [
                    'reference_no'                => $decision === 'Refund' ? $refundRefNo : $replacementRefNo,
                    'candidate_id'                => (int) $candidate->id,
                    'client_id'                   => $clientId ? (int) $clientId : null,
                    'refund_type'                 => $decision === 'Refund' ? $recordType : null,
                    'replacement_type'            => $decision === 'Replacement' ? $recordType : null,
                    'package'                     => $packageValue,
                    'type'                        => (string) $incident->incident_category,
                    'candidate_name'              => (string) ($candidate->candidate_name ?? $request->candidate_name),
                    'sponsor_name'                => (string) $request->employer_name,
                    'passport_no'                 => $passportNo,
                    'nationality'                 => (string) ($candidate->nationality ?? $request->candidate_nationality),
                    'foreign_partner'             => (string) ($candidate->foreign_partner ?? ''),
                    'agreement_no'                => $agreementNo,
                    'contract_start_date'         => $contractStart,
                    'contract_end_date'           => $contractEnd,
                    'return_date'                 => $incidentDate,
                    'maid_worked_days'            => null,
                    'contracted_amount'           => $contractedAmount,
                    'salary'                      => $salary,
                    'worker_salary_for_work_days' => null,
                    'salary_payment_method'       => null,
                    'payment_proof'               => null,
                    'office_charges'              => $request->office_charges,
                    'refunded_amount'             => $request->balance_amount,
                    'refund_date'                 => $dueDate,
                    'original_passport'           => $request->boolean('original_passport', false),
                    'worker_belongings'           => $request->boolean('worker_belongings', false),
                    'status'                      => 'open',
                    'sales_name'                  => $candidate->sales_name,
                    'updated_by_sales_name'       => auth()->id(),
                ];

                if ($decision === 'Refund') {
                    Refund::updateOrCreate(
                        ['candidate_id' => (int) $candidate->id, 'type' => (string) $incident->incident_category],
                        $commonRecord
                    );
                } else {
                    Replacement::updateOrCreate(
                        ['candidate_id' => (int) $candidate->id, 'type' => (string) $incident->incident_category],
                        $commonRecord
                    );
                }

                if ($remoteDb) {
                    $nowRemote = Carbon::now('Africa/Addis_Ababa');

                    if ($agreementRefNo !== '') {
                        $agrRefCol = $firstExistingColumn($remoteDb, 'agreements', ['reference_no', 'agreement_reference_no', 'agreement_no']);
                        $agrUpdate = $filterByExistingColumns($remoteDb, 'agreements', ['status' => 4, 'notes' => $remarks]);
                        if ($agrRefCol && !empty($agrUpdate)) {
                            DB::connection($remoteDb)->table('agreements')->where($agrRefCol, $agreementRefNo)->update($agrUpdate);
                        }

                        $invRefCol = $firstExistingColumn($remoteDb, 'invoices', ['agreement_reference_no', 'agreement_ref_no', 'reference_no']);
                        $invUpdate = $filterByExistingColumns($remoteDb, 'invoices', ['status' => 'Cancelled', 'notes' => $remarks]);
                        if ($invRefCol && !empty($invUpdate)) {
                            DB::connection($remoteDb)->table('invoices')->where($invRefCol, $agreementRefNo)->update($invUpdate);
                        }
                    }

                    DB::connection($remoteDb)->table('incidents')
                        ->where('candidate_id', (int) $request->candidate_id)
                        ->where('incident_category', $incidentCategory)
                        ->delete();

                    DB::connection($remoteDb)->table('incidents')->insert([
                        'incident_category' => $incidentCategory,
                        'candidate_id'      => (int) $request->candidate_id,
                        'candidate_name'    => (string) $request->candidate_name,
                        'reference_no'      => (string) $request->reference_no,
                        'ref_no'            => (string) $request->ref_no,
                        'country'           => 'Dubai',
                        'company'           => 'Alebdaa',
                        'branch'            => 'Alebdaa',
                        'incident_reason'   => (string) $request->incident_reason,
                        'other_reason'      => $request->other_reason,
                        'proof'             => $fileUrl,
                        'note'              => $request->IncidentAfterArrivalModalremarks,
                        'created_by'        => auth()->id(),
                        'created_at'        => $nowRemote,
                        'updated_at'        => $nowRemote,
                    ]);

                    DB::connection($remoteDb)->table('candidates')
                        ->where('ref_no', $candidate->ref_no)
                        ->update([
                            'incident_after_arrival_date' => $nowRemote,
                            'current_status'              => 16,
                        ]);

                    DB::connection($remoteDb)->table('notifications')->insert([
                        'role'       => 'sales',
                        'title'      => $incidentCategory . ' of ' . $candidate->CN_Number,
                        'message'    => $incidentCategory . ' of ' . $candidate->CN_Number . ' and the reason is: ' . (string) $request->incident_reason,
                        'CL_Number'  => $candidate->CN_Number,
                        'CN_Number'  => $candidate->CN_Number,
                        'ref_no'     => $candidate->ref_no,
                        'status'     => 'Un Read',
                        'filePath'   => $fileUrl,
                        'created_at' => $nowRemote,
                        'updated_at' => $nowRemote,
                    ]);

                    if ($decision === 'Refund' && Schema::connection($remoteDb)->hasTable('refunds')) {
                        $remoteRefund = $filterByExistingColumns($remoteDb, 'refunds', $commonRecord);
                        if (!empty($remoteRefund)) {
                            DB::connection($remoteDb)->table('refunds')->updateOrInsert(
                                $filterByExistingColumns($remoteDb, 'refunds', [
                                    'candidate_id' => (int) $candidate->id,
                                    'type'         => (string) $incident->incident_category,
                                ]),
                                array_merge($remoteRefund, ['created_at' => $nowRemote, 'updated_at' => $nowRemote])
                            );
                        }
                    }

                    if ($decision === 'Replacement' && Schema::connection($remoteDb)->hasTable('replacements')) {
                        $remoteReplacement = $filterByExistingColumns($remoteDb, 'replacements', $commonRecord);
                        if (!empty($remoteReplacement)) {
                            DB::connection($remoteDb)->table('replacements')->updateOrInsert(
                                $filterByExistingColumns($remoteDb, 'replacements', [
                                    'candidate_id' => (int) $candidate->id,
                                    'type'         => (string) $incident->incident_category,
                                ]),
                                array_merge($remoteReplacement, ['created_at' => $nowRemote, 'updated_at' => $nowRemote])
                            );
                        }
                    }
                }

                DB::commit();
                if ($remoteDb) DB::connection($remoteDb)->commit();

                $emails = $this->getActionEmailRecipients($candidate);
                if ($emails->isNotEmpty()) {
                    $action          = $incidentCategory;
                    $passport_no     = $passportNo;
                    $candidate_name  = (string) ($candidate->candidate_name ?? $request->candidate_name);
                    $foreign_partner = (string) ($candidate->foreign_partner ?? '');
                    $ref_no          = (string) ($candidate->ref_no ?? $request->ref_no);
                    $action_date     = Carbon::now('Asia/Dubai')->toDateString();
                    $other           = trim(
                        (string) ($request->incident_reason ?? '') . ' ' .
                        (string) ($request->other_reason ?? '') . ' ' .
                        (string) ($request->IncidentAfterArrivalModalremarks ?? '')
                    );

                    $fileDiskPaths = $filePath ? [storage_path('app/public/' . ltrim($filePath, '/'))] : [];

                    foreach ($emails as $to) {
                        $this->sendActionEmail(
                            $to,
                            $action,
                            $passport_no,
                            $candidate_name,
                            $foreign_partner,
                            $ref_no,
                            $action_date,
                            $fileDiskPaths,
                            $other
                        );
                    }
                }

                return response()->json(['success' => true, 'message' => 'Incident saved successfully.']);
            } catch (\Throwable $e) {
                DB::rollBack();
                if ($remoteDb) DB::connection($remoteDb)->rollBack();

                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                return response()->json(['success' => false, 'message' => 'Failed to save incident: ' . $e->getMessage()], 500);
            }
        }


        protected $acctInv;
        public function __construct(AccountInvoiceController $acctInv)
        {
            $this->acctInv = $acctInv;
        }

        public function saveTransferDate(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'candidate_id'         => 'required|exists:new_candidates,id',
                'client_id'            => 'required',
                'transfer_date'        => 'required|date',
                'employer_name'        => 'required|string|max:255',
                'received_amount'      => 'required|numeric|min:0',
                'payment_method'       => 'required|string|max:50',
                'transfer_date_remark' => 'nullable|string|max:500',
                'payment_proof'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5000',
            ]);

            $validator->sometimes('payment_proof', 'required', fn ($in) =>
                floatval($in->received_amount) > 0
            );

            $v = $validator->validate();

            $filePath = $request->file('payment_proof')
                ? $request->file('payment_proof')->store('payment_proofs', 'public')
                : '';

            $candidate = NewCandidate::findOrFail($v['candidate_id']);
            $remoteDb  = $this->getForeignDatabaseName($candidate->foreign_partner);

            try {
                DB::transaction(function () use ($request, $v, $filePath, $candidate, $remoteDb) {

                    $candidate->update([
                        'current_status'       => 17,
                        'transfer_date'        => Carbon::parse($v['transfer_date'])->toDateString(),
                        'transfer_added_date'  => now('Asia/Dubai'),
                        'transfer_date_remark' => $v['transfer_date_remark'] ?? null,
                    ]);

                    Package::where('candidate_id', $candidate->id)->update(['current_status' => 17]);

                    $request->merge(['received_amount' => $v['received_amount']]);
                    $invoice = $this->acctInv->createPendingInvoice($request, $filePath);

                    if ($filePath !== '') {
                        PaymentProof::updateOrCreate(
                            ['candidate_id' => $candidate->id, 'invoice_id' => $invoice->invoice_id],
                            [
                                'client_name'        => $v['employer_name'],
                                'invoice_amount'     => $invoice->total_amount,
                                'received_amount'    => $invoice->received_amount,
                                'payment_method'     => $v['payment_method'],
                                'payment_proof_path' => $filePath,
                                'created_by'         => Auth::id(),
                            ]
                        );
                    }

                    DB::connection($remoteDb)->table('candidates')
                        ->where('ref_no', $candidate->ref_no)
                        ->update([
                            'transfer_date'       => Carbon::parse($v['transfer_date'])->toDateString(),
                            'transfer_added_date' => now('Africa/Addis_Ababa'),
                            'current_status'      => 17,
                        ]);

                    foreach (['sales', 'coordinator'] as $role) {
                        $this->add_notification([
                            'role'        => $role,
                            'user_id'     => $candidate->sales_name,
                            'reference_no'=> $candidate->reference_no,
                            'ref_no'      => $candidate->ref_no,
                            'title'       => 'Transfer of '.$candidate->CN_Number,
                            'message'     => 'Transfer of '.$candidate->CN_Number.' to '.$v['employer_name'].' on '.$v['transfer_date'],
                            'CL_Number'   => $candidate->CL_Number,
                            'CN_Number'   => $candidate->CN_Number,
                            'status'      => 'Un Read',
                            'filePath'    => $filePath,
                            'created_at'  => now('Asia/Dubai'),
                        ]);
                    }
                });

                return response()->json(['success' => true, 'message' => 'Transfer date updated and invoice created.'], 200);

            } catch (\Throwable $e) {
                if ($filePath !== '' && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }
        
        public function saveTrialReturn(Request $request)
        {
            $data = $request->validate([
                'trial_id'      => 'required|integer|exists:trials,id',
                'candidate_id'  => 'required|integer|exists:new_candidates,id',
                'proof'         => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
                'remarks'       => 'nullable|string',
            ]);

            try {
                DB::transaction(function() use ($data, $request) {
                    $filePath = $request->file('proof')->store('trial_return_proof', 'public');
                    $returnDate = Carbon::now('Asia/Dubai')->format('Y-m-d');

                    $trial = Trial::findOrFail($data['trial_id']);
                    $trial->update([
                        'trial_status'         => 'Trial Return',
                        'trial_return_date'    => $returnDate,
                        'change_status_proof'  => $filePath,
                        'remarks'              => $data['remarks'],
                    ]);

                    NewCandidate::findOrFail($data['candidate_id'])->update([
                        'inside_status' => 1,
                    ]);

                    if ($trial->trial_type === 'package') {
                        Package::where('id', $data['candidate_id'])->update([
                            'inside_status' => 1,
                        ]);
                    } else {
                        Employee::where('id', $data['candidate_id'])->update([
                            'inside_status' => 1,
                        ]);
                    }
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Trial Return updated successfully.',
                ]);
            } catch (\Exception $e) {
                Log::error('Error in saveTrialReturn', [
                    'message' => $e->getMessage(),
                    'trace'   => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while saving Trial Return.',
                ], 500);
            }
        }


        public function saveSalesReturn(Request $request)
        {
            $data = $request->validate([
                'trial_id'     => 'required|integer|exists:trials,id',
                'candidate_id' => 'required|integer|exists:new_candidates,id',
                'proof'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:5000',
                'remarks'      => 'nullable|string',
            ]);

            try {
                DB::transaction(function() use ($data, $request) {
                    $filePath   = $request->file('proof')->store('sales_return_proof', 'public');
                    $returnDate = Carbon::now('Asia/Dubai')->format('Y-m-d');

                    $trial = Trial::findOrFail($data['trial_id']);
                    $trial->update([
                        'trial_status'        => 'Sales Return',
                        'sales_return_date'   => $returnDate,
                        'change_status_proof' => $filePath,
                        'remarks'             => $data['remarks'],
                    ]);

                    NewCandidate::findOrFail($data['candidate_id'])->update([
                        'inside_status' => 1,
                    ]);

                    if ($trial->trial_type === 'package') {
                        Package::where('id', $data['candidate_id'])->update([
                            'inside_status' => 1,
                        ]);
                    } else {
                        Employee::where('id', $data['candidate_id'])->update([
                            'inside_status' => 1,
                        ]);
                    }
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Sales Return updated successfully.',
                ]);
            } catch (\Exception $e) {
                Log::error('Error in saveSalesReturn', [
                    'message' => $e->getMessage(),
                    'trace'   => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while saving Sales Return.',
                ], 500);
            }
        }


        public function saveReturnIncident(Request $request)
        {
            $data = $request->validate([
                'trial_id'                  => 'required|integer|exists:trials,id',
                'candidate_id'              => 'required|integer|exists:new_candidates,id',
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
                DB::transaction(function() use ($data, $request) {
                    $filePath = $request->file('proof')->store('incident_proof', 'public');
                    $date     = Carbon::now('Asia/Dubai')->format('Y-m-d');

                    $trial = Trial::findOrFail($data['trial_id']);
                    $trial->update([
                        'trial_status'    => 'Incident',
                        'incident_type'   => $data['incident_status'],
                        'incident_date'   => $date,
                        'incident_proof'  => $filePath,
                        'remarks'         => $data['remarks'],
                    ]);

                    NewCandidate::findOrFail($data['candidate_id'])->update([
                        'inside_status'  => 1,
                        'incident_date'  => $date,
                    ]);

                    if ($trial->trial_type === 'package') {
                        Package::where('id', $data['candidate_id'])->update([
                            'inside_status' => 1,
                        ]);
                    } else {
                        Employee::where('id', $data['candidate_id'])->update([
                            'inside_status' => 1,
                        ]);
                    }

                    Incident::create([
                        'incident_category'        => $data['incident_status'],
                        'candidate_id'             => $data['candidate_id'],
                        'candidate_name'           => $data['candidate_name'],
                        'employer_name'            => $data['employer_name'],
                        'candidate_reference_no'   => $data['candidate_reference_no'],
                        'candidate_ref_no'         => $data['candidate_ref_no'],
                        'foreign_partner'          => $data['foreign_partner'],
                        'candidate_nationality'    => $data['candidate_nationality'],
                        'candidate_passport_number'=> $data['candidate_passport_number'],
                        'candidate_passport_expiry'=> $data['candidate_passport_expiry']
                            ? Carbon::parse($data['candidate_passport_expiry'])->format('Y-m-d')
                            : null,
                        'candidate_dob'            => $data['candidate_dob']
                            ? Carbon::parse($data['candidate_dob'])->format('Y-m-d')
                            : null,
                        'incident_reason'          => $data['remarks'],
                        'proof'                    => $filePath,
                        'created_by'               => auth()->id(),
                    ]);
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Incident updated and record created successfully.',
                ]);
            } catch (\Exception $e) {
                Log::error('Error in saveReturnIncident', [
                    'message' => $e->getMessage(),
                    'trace'   => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while saving the incident.',
                ], 500);
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
                NewCandidate::where('id', $request->candidate_id)->update([
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

        public function exportFiltered(Request $request)
        {
            $nameToId = CurrentStatus::query()
                ->pluck('id', 'status_name')
                ->mapWithKeys(fn($id, $name) => [mb_strtolower(trim($name)) => (int) $id])
                ->toArray();

            $idFor = function (?string $statusName) use ($nameToId): ?int {
                if (!$statusName) return null;
                $k = mb_strtolower(trim($statusName));
                return $nameToId[$k] ?? null;
            };

            $onProcessNames = [
                'Selected',
                'WC-Date',
                'Incident Before Visa (IBV)',
                'Visa Date',
                'Incident After Visa (IAV)',
                'Medical Status',
                'COC-Status',
                'MoL Submitted Date',
                'MoL Issued Date',
                'Arrived Date',
            ];
            $onProcessIds = collect($onProcessNames)->map(fn($n) => $idFor($n))->filter()->values()->all();

            $user   = Auth::user();
            $role   = $user->role;
            $userId = $user->id;

            $query = NewCandidate::query()
                ->leftJoin('countries as nat', 'nat.id', '=', 'new_candidates.nationality')
                ->leftJoin('current_statuses as cs', 'cs.id', '=', 'new_candidates.current_status')
                ->select([
                    'new_candidates.ref_no',
                    'new_candidates.reference_no',
                    'new_candidates.candidate_name',
                    'new_candidates.passport_no',
                    'new_candidates.passport_expiry_date',
                    'new_candidates.nationality',
                    'nat.name as nationality_name',
                    'new_candidates.foreign_partner',
                    'new_candidates.religion',
                    'new_candidates.marital_status',
                    'new_candidates.current_status',
                    'cs.status_name as current_status_name',
                    'new_candidates.date_of_birth',
                    'new_candidates.preferred_package',
                    'new_candidates.sales_name',
                    'new_candidates.status',
                    'new_candidates.created_at',
                ])
                ->where('new_candidates.status', 1)
                ->orderBy('new_candidates.ref_no');

            $adminRoles = [
                'Admin','Managing Director','Marketing Manager','Digital Marketing Specialist',
                'Digital Marketing Executive','Photographer','Operations Manager','Sales Manager','Operations Supervisor','Contract Administrator','Finance Officer','Archive Clerk',
            ];

            if (!in_array($role, $adminRoles, true)) {
                switch ($role) {
                    case 'Sales Officer':
                    case 'Customer Services':
                        $query->where(function ($q) use ($userId) {
                            $q->where('new_candidates.current_status', 1)
                              ->orWhere(function ($q2) use ($userId) {
                                  $q2->where('new_candidates.sales_name', $userId)
                                     ->where('new_candidates.current_status', '!=', 1);
                              });
                        });
                        break;
                    case 'Sales Coordinator':
                        $query->whereRaw('CAST(new_candidates.nationality AS SIGNED) = ?', [(int) $user->nationality]);
                        break;
                    case 'Happiness Consultant':
                        $query->whereIn('new_candidates.current_status', range(4, 12));
                        break;
                    default:
                        $query->whereRaw('1 = 0');
                }
            }

            $filter    = $request->filled('filter') ? trim((string) $request->input('filter')) : 'all';
            $subFilter = $request->filled('sub_filter') ? trim((string) $request->input('sub_filter')) : null;
            $tabName   = $request->input('tab_name');
            $statusIdFromPayload = $request->filled('current_status_id') ? (int) $request->input('current_status_id') : null;

            if ($statusIdFromPayload) {
                $query->where('new_candidates.current_status', $statusIdFromPayload);
            } else {
                if ($filter !== null && mb_strtolower($filter) !== 'all') {
                    if (mb_strtolower($filter) === 'on-process') {
                        if ($subFilter) {
                            $sid = $idFor($subFilter);
                            $sid ? $query->where('new_candidates.current_status', $sid) : $query->whereRaw('1 = 0');
                        } else {
                            count($onProcessIds) ? $query->whereIn('new_candidates.current_status', $onProcessIds) : $query->whereRaw('1 = 0');
                        }
                    } else {
                        $sid = is_numeric($filter) ? (int)$filter : $idFor($filter);
                        if (!$sid && $tabName) $sid = $idFor($tabName);
                        if ($sid) {
                            $query->where('new_candidates.current_status', $sid);
                        } else {
                            switch ($filter) {
                                case 'Medical Status':
                                    $query->whereNotNull('new_candidates.medical_date');
                                    break;
                                case 'COC-Status':
                                    $query->whereNotNull('new_candidates.coc_status');
                                    break;
                                case 'MoL Submitted Date':
                                    $query->whereNotNull('new_candidates.l_submitted_date');
                                    break;
                                case 'MoL Issued Date':
                                    $query->whereNotNull('new_candidates.l_issued_date');
                                    break;
                                default:
                                    $query->whereRaw('1 = 0');
                            }
                        }
                    }
                }
            }

            if ($request->filled('current_status') && !$statusIdFromPayload) {
                $status = (int) $request->input('current_status');
                $query->where('new_candidates.current_status', $status);
            }

            if ($request->filled('global_search')) {
                $term = trim((string) $request->input('global_search'));
                if ($term !== '') {
                    $query->where(function($q) use ($term) {
                        $q->where('new_candidates.candidate_name', 'like', "%{$term}%")
                          ->orWhere('new_candidates.passport_no', 'like', "%{$term}%")
                          ->orWhere('new_candidates.ref_no', 'like', "%{$term}%")
                          ->orWhere('new_candidates.reference_no', 'like', "%{$term}%");
                    });
                }
            }

            if ($request->filled('reference_no')) {
                $ref = $request->input('reference_no');
                $query->where(function ($q) use ($ref) {
                    $q->where('new_candidates.ref_no', 'like', "%{$ref}%")
                      ->orWhere('new_candidates.reference_no', 'like', "%{$ref}%");
                });
            }
            if ($request->filled('name')) {
                $query->where('new_candidates.candidate_name', 'like', '%'.$request->input('name').'%');
            }
            if ($request->filled('passport_number')) {
                $query->where('new_candidates.passport_no', 'like', '%'.$request->input('passport_number').'%');
            }
            if ($request->filled('nationality')) {
                $query->where('new_candidates.nationality', $request->input('nationality'));
            }
            if ($request->filled('package')) {
                $query->where('new_candidates.preferred_package', $request->input('package'));
            }
            if ($request->filled('education')) {
                $query->where('new_candidates.education_level', $request->input('education'));
            }
            if ($request->filled('skills')) {
                $query->where('new_candidates.work_skill', 'like', '%'.$request->input('skills').'%');
            }
            if ($request->filled('religion')) {
                $query->where('new_candidates.religion', $request->input('religion'));
            }
            if ($request->filled('sales_name')) {
                $query->where('new_candidates.sales_name', $request->input('sales_name'));
            }
            if ($request->filled('age') && str_contains($request->input('age'), '-')) {
                [$min, $max] = array_pad(explode('-', $request->input('age'), 2), 2, null);
                $min = is_numeric($min) ? (int)$min : null;
                $max = is_numeric($max) ? (int)$max : null;
                if ($min !== null && $max !== null && $min <= $max) {
                    $fromDate = now()->subYears($max)->format('Y-m-d');
                    $toDate   = now()->subYears($min)->format('Y-m-d');
                    $query->whereBetween('new_candidates.date_of_birth', [$fromDate, $toDate]);
                }
            }
            if ($request->filled('marital_status')) {
                $query->where('new_candidates.marital_status', $request->input('marital_status'));
            }
            if ($request->filled('experience')) {
                $val = $request->input('experience');
                if ($val === 'Yes') {
                    $query->whereHas('CandidatesExperience', fn($q) => $q->where('experience_years', '>=', 1));
                } elseif ($val === 'No') {
                    $query->whereDoesntHave('CandidatesExperience', fn($q) => $q->where('experience_years', '>=', 1));
                }
            }
            if ($request->filled('partners')) {
                $partners = strtoupper($request->input('partners'));
                $query->whereRaw('SUBSTRING_INDEX(new_candidates.foreign_partner, " ", 1) = ?', [$partners]);
            }

            $fileName = now()->format('d-m-Y') . '_candidates.xlsx';

            return Excel::download(
                new FilteredCandidatesExport($query),
                $fileName,
                \Maatwebsite\Excel\Excel::XLSX,
                ['Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0']
            );
        }

        public function loadImages(Request $request)
        {
            $candidateId = $request->id;
            $candidate = NewCandidate::with('attachments')->find($candidateId); 

            if (!$candidate) {
                return response()->json(['success' => false, 'message' => 'Candidate not found.']);
            }

            $foreignPartner = strtolower(explode(' ', $candidate->foreign_partner)[0]);
            $attachmentsHtml = view('candidates.partials.attachments', compact('candidate', 'foreignPartner'))->render();
            return response()->json(['success' => true, 'html' => $attachmentsHtml]);
        }

        public function loadImages1(Request $request)
        {
            $candidateId = $request->id;
            $candidate = NewCandidate::with('attachments')->find($candidateId); 

            if (!$candidate) {
                return response()->json(['success' => false, 'message' => 'Candidate not found.']);
            }

            $foreignPartner = strtolower(explode(' ', $candidate->foreign_partner)[0]);
            $attachmentsHtml = view('candidates.partials.viewattachments', compact('candidate', 'foreignPartner'))->render();
            return response()->json(['success' => true, 'html' => $attachmentsHtml]);
        }

        public function loadExperiences(Request $request)
        {
            $candidateId = $request->id;
            $candidate = NewCandidate::with('experiences')->find($candidateId); 

            if (!$candidate) {
                return response()->json(['success' => false, 'message' => 'Candidate not found.']);
            }

            $experiences = view('candidates.partials.load_experiences', compact('candidate'))->render();
            return response()->json(['success' => true, 'html' => $experiences]);
        }

        public function loadWorkSkills(Request $request)
        {
            $candidateId = $request->id;
            $skills = DB::table('candidate_skills')
                ->join('work_skills', 'candidate_skills.skill_id', '=', 'work_skills.id')
                ->where('candidate_skills.candidate_id', $candidateId)
                ->select('work_skills.skill_name as skill_name', 'candidate_skills.description as skill_description')
                ->get();

            if ($skills->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No skills found for this candidate.']);
            }

            $skillsHtml = view('candidates.partials.load_skills', compact('skills'))->render();
            return response()->json(['success' => true, 'html' => $skillsHtml]);
        }

        public function loadDesiredCountries(Request $request)
        {
            $candidateId = $request->id;
            $desiredCountries = DB::table('candidate_desired_countries')
                ->join('desired_countries', 'candidate_desired_countries.country_id', '=', 'desired_countries.id')
                ->join('fra_names', 'candidate_desired_countries.fra_id', '=', 'fra_names.id')
                ->where('candidate_desired_countries.candidate_id', $candidateId)
                ->select(
                    'desired_countries.country_name',
                    'desired_countries.arabic_name as country_arabic_name',
                    'fra_names.fra_name'
                )
                ->get();

            if ($desiredCountries->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No desired countries found for this candidate.']);
            }

            $countriesHtml = view('candidates.partials.load_desired_countries', compact('desiredCountries'))->render();
            return response()->json(['success' => true, 'html' => $countriesHtml]);
        }

        public function getExperience($id)
        {
            $candidate = NewCandidate::with('CandidatesExperience')->findOrFail($id);
            $experiences = $candidate->CandidatesExperience->map(function ($experience) {
                return [
                    'country' => $experience->country,
                    'experience_years' => $experience->experience_years,
                    'experience_months' => $experience->experience_months,
                ];
            });

            return response()->json(['experiences' => $experiences]);
        }

        public function getSkills($id)
        {
            $candidate = NewCandidate::findOrFail($id);
            $skills = $candidate->work_skills->map(function ($skill) {
                return [
                    'skill_name' => $skill->skill_name,
                ];
            });

            return response()->json(['skills' => $skills]);
        }

        public function resetRecord(Request $request)
        {
            // $allDatabases = [
            //     'adeyonesourceerp_new',
            //     'alkabaonesourcee_new',
            //     'bmgonesourceerp_new',
            //     'edithonesource_new',
            //     'estella_new',
            //     'greenwayonesourc_new',
            //     'khalidonesourcee_new',
            //     'middleeastonesou_new',
            //     'myonesourceerp_new',
            //     'ritemeritonesour_new',
            //     'rozanaonesourcee_new',
            //     'tadbeeralebdaaon_new',
            //     'viennaonesourcee_new',
            // ];

            // $resetLogs = [];

            // foreach ($allDatabases as $dbName) {
            //     $config = config('database.connections.mysql');
            //     $config['database'] = $dbName;
            //     $config['username'] = $dbName;
            //     $config['password'] = 'Shahzad_12345';
            //     $config['host'] = '127.0.0.1';

            //     config(['database.connections.dynamic' => $config]);

            //     DB::purge('dynamic');
            //     DB::reconnect('dynamic');

            //     Log::info("Connected to database: $dbName");

            //     try {
            //         $tables = DB::connection('dynamic')->select("SHOW TABLES");
            //     } catch (\Exception $e) {
            //         Log::error("Error fetching tables from $dbName: " . $e->getMessage());
            //         continue;
            //     }

            //     $tableNames = array_map(function($tableObj) {
            //         return array_values((array)$tableObj)[0];
            //     }, $tables);

            //     foreach (['candidates', 'new_candidates'] as $table) {
            //         if (in_array($table, $tableNames)) {
            //             Log::info("Checking table: $dbName.$table");

            //             $selectQuery = "
            //                 SELECT ref_no, hold_date
            //                 FROM `$table`
            //                 WHERE current_status = 2
            //                   AND hold_date IS NOT NULL
            //                   AND hold_date <= DATE_SUB(NOW(), INTERVAL 6 HOUR)
            //             ";

            //             $recordsToReset = DB::connection('dynamic')->select($selectQuery);

            //             if (count($recordsToReset) > 0) {
            //                 Log::info("Found " . count($recordsToReset) . " record(s) older than 6 hours in $dbName.$table", $recordsToReset);

            //                 $updateQuery = "
            //                     UPDATE `$table`
            //                     SET current_status = 1, hold_date = NULL
            //                     WHERE current_status = 2
            //                       AND hold_date IS NOT NULL
            //                       AND hold_date <= DATE_SUB(NOW(), INTERVAL 6 HOUR)
            //                 ";
            //                 Log::info("Running query: $updateQuery");
            //                 $count = DB::connection('dynamic')->affectingStatement($updateQuery);

            //                 Log::info("Updated $count row(s) in $dbName.$table");

            //                 $refNos = array_map(function($record) {
            //                     return $record->ref_no;
            //                 }, $recordsToReset);

            //                 $resetLogs[] = [
            //                     'database'      => $dbName,
            //                     'table'         => $table,
            //                     'updated_count' => $count,
            //                     'ref_nos'       => $refNos
            //                 ];
            //             } else {
            //                 Log::info("No records older than 6 hours found in $dbName.$table");
            //             }
            //         }
            //     }
            // }

            // Log::info('Candidates Reset Summary', $resetLogs);

            // return response()->json([
            //     'message' => 'Record reset successfully.',
            //     'data'    => $resetLogs
            // ]);
        }

        public function hideInOtherDatabasesForActive(Request $request)
        {
            $host = strtolower($request->getHost());
            $hostToConnection = [
                'rozana.onesourceerp.com'            => 'rozanaonesourcee_new',
                'vienna.onesourceerp.com'            => 'viennaonesourcee_new',
                'middleeast.onesourceerp.com'        => 'middleeastonesou_new',
                'alanbar.onesourceerp.com'           => 'alanbaronesource_new',
                'tadbeeralebdaa.onesourceerp.com'    => 'tadbeeralebdaaon_new',
                'shaikhah.onesourceerp.com'          => 'shaikhahonesourc_new',
            ];
            $primaryConnection = $hostToConnection[$host] ?? null;

            $dbConfigs = config('database.connections');
            $allTenantConnections = array_values(array_filter([
                'rozanaonesourcee_new',
                'viennaonesourcee_new',
                'middleeastonesou_new',
                'alanbaronesource_new',
                'tadbeeralebdaaon_new',
                'shaikhahonesourc_new',
            ], fn ($c) => array_key_exists($c, $dbConfigs)));

            $otherConnections = array_values(array_filter($allTenantConnections, fn ($c) => $primaryConnection ? $c !== $primaryConnection : true));

            $resolveTenantTable = function (string $conn): ?string {
                $schema = Schema::connection($conn);
                if ($schema->hasTable('new_candidates')) return 'new_candidates';
                if ($schema->hasTable('candidates')) return 'candidates';
                return null;
            };

            $updated = [];
            foreach ($otherConnections as $c) $updated[$c] = 0;

            NewCandidate::where('current_status', '>', 2)
                ->select('ref_no')
                ->orderBy('id')
                ->chunk(500, function ($chunk) use ($otherConnections, $resolveTenantTable, &$updated) {
                    foreach ($chunk as $cand) {
                        foreach ($otherConnections as $conn) {
                            $table = $resolveTenantTable($conn);
                            if (! $table) continue;
                            if (! Schema::connection($conn)->hasColumn($table, 'status')) continue;
                            $count = DB::connection($conn)->table($table)->where('ref_no', $cand->ref_no)->update(['status' => 2]);
                            if ($count > 0) $updated[$conn] += $count;
                        }
                    }
                });

            return response()->json([
                'success' => true,
                'message' => 'Synced visibility: set status = 2 in other databases for candidates with current_status > 2.',
                'updated_per_connection' => $updated,
            ]);
        }


        public function convertToContract(Request $request): JsonResponse
        {
            $data = $request->validate([
                'candidate_id'              => 'required|integer|exists:new_candidates,id',
                'candidate_name'            => 'required|string',
                'reference_no'              => 'nullable',
                'ref_no'                    => 'required',
                'foreign_partner'           => 'required|string',
                'candidate_nationality'     => 'required|integer',
                'candidate_passport_number' => 'required|string',
                'candidate_passport_expiry' => 'required|date',
                'candidate_dob'             => 'required|date',

                'sponsor_name'              => 'nullable|string',
                'emirates_id'               => 'nullable|string',
                'visa_type'                 => 'nullable|string',
                'contract_duration'         => 'nullable|integer',
                'contract_end_date'         => 'nullable|date',
                'package'                   => 'required|string|in:PKG-2,PKG-3,PKG-4',
            ]);

            $nationalityName = [
                1 => 'Ethiopia',
                2 => 'Uganda',
                3 => 'Philippines',
                4 => 'Indonesia',
                5 => 'Sri Lanka',
                6 => 'Myanmar',
            ][$data['candidate_nationality']] ?? null;

            DB::transaction(function () use ($data, $nationalityName) {

                $employee = Employee::lockForUpdate()
                    ->whereRaw('UPPER(TRIM(passport_no)) = ?', [strtoupper(trim($data['candidate_passport_number']))])
                    ->first();

                $pkg = strtoupper(trim((string) $data['package']));
                $prefixMap = [
                    'PKG-2' => 'EP2-',
                    'PKG-3' => 'EP3-',
                    'PKG-4' => 'EP4-',
                ];
                $prefix = $prefixMap[$pkg] ?? 'EP3-';

                if (!$employee) {
                    $lastRef = Employee::query()
                        ->lockForUpdate()
                        ->where('reference_no', 'like', $prefix . '%')
                        ->orderByDesc('id')
                        ->value('reference_no');

                    $seq = 0;
                    if ($lastRef) {
                        $lastRef = strtoupper(trim((string) $lastRef));
                        if (preg_match('/^' . preg_quote($prefix, '/') . '(\d+)$/', $lastRef, $m)) {
                            $seq = (int) ltrim($m[1], '0');
                        }
                    }

                    $newRef = '';
                    for ($i = 0; $i < 1000; $i++) {
                        $seq++;
                        $candidateRef = $prefix . str_pad((string) $seq, 5, '0', STR_PAD_LEFT);
                        if (!Employee::query()->where('reference_no', $candidateRef)->exists()) {
                            $newRef = $candidateRef;
                            break;
                        }
                    }

                    if ($newRef === '') {
                        throw new \RuntimeException('Unable to generate unique employee reference number.');
                    }

                    $employee = new Employee(['reference_no' => $newRef]);
                }

                $employee->fill([
                    'name'                      => $data['candidate_name'],
                    'slug'                      => Str::slug($data['candidate_name'] . '-' . $employee->reference_no),
                    'nationality'               => $nationalityName,
                    'passport_no'               => strtoupper(trim((string) $data['candidate_passport_number'])),
                    'passport_expiry_date'      => Carbon::parse($data['candidate_passport_expiry'])->toDateString(),
                    'date_of_joining'           => now('Asia/Dubai'),
                    'date_of_birth'             => Carbon::parse($data['candidate_dob'])->toDateString(),
                    'current_status'            => 4,
                    'package'                   => $pkg,
                    'visa_designation'          => 'Tadbeer',
                    'inside_country_or_outside' => 1,
                    'foreign_partner'           => $data['foreign_partner'] ?? null,
                    'sponsor_name'              => $data['sponsor_name'] ?? null,
                    'emirates_id'               => $data['emirates_id'] ?? null,
                    'visa_type'                 => $data['visa_type'] ?? null,
                    'contract_duration'         => $data['contract_duration'] ?? null,
                    'contract_end_date'         => isset($data['contract_end_date']) && $data['contract_end_date']
                        ? Carbon::parse($data['contract_end_date'])->toDateString()
                        : null,
                    'sales_name'                => auth()->user()->first_name ?? null,
                    'sale_id'                   => auth()->id(),
                ])->save();

                NewCandidate::where('id', $data['candidate_id'])->update([
                    'current_status'     => 4,
                    'change_status_date' => now('Asia/Dubai'),
                ]);
            });

            return response()->json([
                'status'  => 'success',
                'message' => 'Candidate converted to employee.',
            ]);
        }

        public function ajaxSyncPartnerStatus(): JsonResponse
        {
            // $summary = [];

            // NewCandidate::whereNotNull('foreign_partner')
            //     ->whereNotNull('ref_no')
            //     ->where('status', 1)
            //     ->chunkById(200, function ($candidates) use (&$summary) {
            //         foreach ($candidates as $candidate) {
            //             $remoteDb = $this->getForeignDatabaseName($candidate->foreign_partner);
            //             if (! $remoteDb) {
            //                 continue;
            //             }

            //             try {
            //                 $affected = DB::connection($remoteDb)
            //                     ->table('candidates')
            //                     ->where('ref_no', $candidate->ref_no)
            //                     ->update(['current_status' => $candidate->current_status]);

            //                 if ($affected > 0) {
            //                     $summary[$candidate->foreign_partner] = ($summary[$candidate->foreign_partner] ?? 0) + $affected;
            //                 }
            //             } catch (\Throwable $e) {
            //                 Log::error('partner_status_sync_failed', [
            //                     'partner' => $candidate->foreign_partner,
            //                     'ref_no'  => $candidate->ref_no,
            //                     'error'   => $e->getMessage(),
            //                 ]);
            //             }
            //         }
            //     });

            // return response()->json([
            //     'status'  => 'success',
            //     'total'   => array_sum($summary),
            //     'summary' => collect($summary)
            //         ->map(fn ($count, $partner) => ['partner' => $partner, 'updated' => $count])
            //         ->values(),
            // ]);
        }
        
        public function getOutsideCandidatesAPI(Request $request): JsonResponse|AnonymousResourceCollection
        {
            $category    = strtolower((string) $request->input('category', 'outside'));
            $sponsorship = strtolower((string) $request->input('sponsorship', 'personal'));
            $perPage     = max(5, min(100, (int) $request->input('per_page', 15)));

            if (in_array($category, ['company', 'personal'], true)) {
                $sponsorship = $category;
                $category    = 'inside';
            }
            if ($category === 'inside' && !in_array($sponsorship, ['company', 'personal'], true)) {
                $sponsorship = 'personal';
            }
            if ($category === 'outside') {
                $sponsorship = 'personal';
            }

            $filters = $this->parseFilters($request);

            if ($request->boolean('debug_sql')) {
                return response()->json($this->debugAllQueries($filters));
            }

            $mode = $category === 'outside' ? 'outside' : $sponsorship;

            if ($mode === 'outside') {
                if (empty($filters['nationalities'])) {
                    $filters['nationalities'] = [3];
                }
                $builder = $this->buildOutsideQuery($filters);

                return NewCandidateResource::collection(
                    $builder->latest('created_at')->paginate($perPage)->withQueryString()
                )->additional($this->debugMeta($request, $builder, $filters, [
                    'mode'         => $mode,
                    'category'     => $category,
                    'sponsorship'  => $sponsorship,
                    'nat_match'    => null,
                ]));
            }

            if ($mode === 'company') {
                $builder  = $this->buildCompanyQuery($filters, $natMatch = $this->normalizeInsideNationalityInputs($filters));

                return EmployeeResource::collection(
                    $builder->latest('created_at')->paginate($perPage)->withQueryString()
                )->additional($this->debugMeta($request, $builder, $filters, [
                    'mode'         => $mode,
                    'category'     => $category,
                    'sponsorship'  => $sponsorship,
                    'nat_match'    => $natMatch,
                ]));
            }

            $builder  = $this->buildPersonalQuery($filters, $natMatch = $this->normalizeInsideNationalityInputs($filters));

            return PackageResource::collection(
                $builder->latest('created_at')->paginate($perPage)->withQueryString()
            )->additional($this->debugMeta($request, $builder, $filters, [
                'mode'         => $mode,
                'category'     => $category,
                'sponsorship'  => $sponsorship,
                'nat_match'    => $natMatch,
            ]));
        }

        protected function parseFilters(Request $request): array
        {
            $ageRanges = [];
            foreach ((array) $request->input('age', []) as $v) {
                if (preg_match('/^(\d+)-(\d+)$/', $v, $m)) {
                    $ageRanges[] = ['min' => (int) $m[1], 'max' => (int) $m[2]];
                } elseif ($v === '46+') {
                    $ageRanges[] = ['min' => 46, 'max' => 100];
                }
            }
            foreach ((array) $request->input('ages', []) as $r) {
                $min = (int) ($r['min'] ?? 0);
                $max = (int) ($r['max'] ?? 0);
                if ($min && $max) {
                    $ageRanges[] = ['min' => $min, 'max' => $max];
                }
            }

            return [
                'nationalities' => array_values(array_filter((array) $request->input('nationality', []), fn ($v) => $v !== null && $v !== '')),
                'countries'     => array_values(array_filter((array) $request->input('country', []), fn ($v) => $v !== null && $v !== '')),
                'languages'     => array_values(array_filter((array) $request->input('language', []), fn ($v) => $v !== null && $v !== '')),
                'religions'     => array_values(array_filter((array) $request->input('religion', []), fn ($v) => $v !== null && $v !== '')),
                'experiences'   => array_values(array_filter((array) $request->input('experience', []), fn ($v) => $v !== null && $v !== '')),
                'ageRanges'     => $ageRanges,
            ];
        }

        protected function normalizeInsideNationalityInputs(array $filters): array
        {
            $inputs = array_merge($filters['nationalities'] ?? [], $filters['countries'] ?? []);
            return $this->buildInsideNationalityMatcher($inputs);
        }

        protected function buildInsideNationalityMatcher(array $vals): array
        {
            $exact = [];
            $likes = [];

            foreach ($vals as $v) {
                if ($v === null || $v === '') {
                    continue;
                }
                $s = strtolower(trim((string) $v));

                if (in_array($s, ['1', 'et', 'eth', 'ethiopia', 'ethiopian'], true)) {
                    $exact[] = 'ethiopia';
                    $exact[] = 'ethiopian';
                    $likes[] = 'ethio%';
                    continue;
                }

                if (in_array($s, ['2', 'ug', 'uga', 'uganda', 'ugandan'], true)) {
                    $exact[] = 'uganda';
                    $exact[] = 'ugandan';
                    $likes[] = 'uga%';
                    $likes[] = 'ugand%';
                    continue;
                }

                if (in_array($s, ['3', 'ph', 'phl', 'philippines', 'filipino', 'philippine'], true)) {
                    $exact[] = 'philippines';
                    $exact[] = 'filipino';
                    $exact[] = 'philippine';
                    $likes[] = 'phil%';
                    $likes[] = 'filip%';
                    continue;
                }

                $exact[] = $s;
                $likes[] = $s . '%';
            }

            return [
                'exact' => array_values(array_unique($exact)),
                'likes' => array_values(array_unique($likes)),
            ];
        }

        protected function buildOutsideQuery(array $f): EloquentBuilder
        {
            return NewCandidate::with([
                    'experiences',
                    'attachments',
                    'nationality',
                    'appliedPosition',
                    'educationLevel',
                    'desiredCountry',
                    'fraName',
                    'medicalStatus',
                    'cocStatus',
                    'currentStatus',
                    'maritalStatus',
                ])
                ->where('current_status', 1)
                ->when(!empty($f['nationalities']), fn ($q) => $q->whereIn('nationality', $f['nationalities']))
                ->when(!empty($f['ageRanges']), function ($q) use ($f) {
                    $q->where(function ($sub) use ($f) {
                        $first = true;
                        foreach ($f['ageRanges'] as $range) {
                            $young = Carbon::today()->subYears($range['min']);
                            $old   = Carbon::today()->subYears($range['max'] + 1)->addDay();
                            if ($first) {
                                $sub->whereBetween('date_of_birth', [$old, $young]);
                                $first = false;
                            } else {
                                $sub->orWhereBetween('date_of_birth', [$old, $young]);
                            }
                        }
                    });
                })
                ->when(!empty($f['languages']), function ($q) use ($f) {
                    $q->where(function ($s) use ($f) {
                        foreach (array_values($f['languages']) as $i => $lang) {
                            if ($i === 0) {
                                $s->whereJsonContains('languages', $lang);
                            } else {
                                $s->orWhereJsonContains('languages', $lang);
                            }
                        }
                    });
                })
                ->when(!empty($f['religions']), fn ($q) => $q->whereIn('religion', $f['religions']))
                ->when(!empty($f['experiences']), function ($q) use ($f) {
                    $q->whereHas('experiences', fn ($e) => $e->whereIn('country', $f['experiences']));
                });
        }

        protected function buildCompanyQuery(array $f, array $natMatch = null): EloquentBuilder
        {
            $natMatch = $natMatch ?? $this->normalizeInsideNationalityInputs($f);

            return Employee::with(['attachments', 'experiences', 'skills'])
                ->where('inside_status', 1)
                ->when(!empty($natMatch['exact']) || !empty($natMatch['likes']), function ($q) use ($natMatch) {
                    $q->where(function ($sub) use ($natMatch) {
                        if (!empty($natMatch['exact'])) {
                            $sub->whereIn(DB::raw('LOWER(nationality)'), $natMatch['exact']);
                        }
                        foreach ($natMatch['likes'] as $i => $like) {
                            $method = (empty($natMatch['exact']) && $i === 0) ? 'where' : 'orWhere';
                            $sub->{$method}(DB::raw('LOWER(nationality)'), 'like', $like);
                        }
                    });
                })
                ->when(!empty($f['ageRanges']), function ($q) use ($f) {
                    $q->where(function ($sub) use ($f) {
                        $first = true;
                        foreach ($f['ageRanges'] as $range) {
                            $young = Carbon::today()->subYears($range['min']);
                            $old   = Carbon::today()->subYears($range['max'] + 1)->addDay();
                            if ($first) {
                                $sub->whereBetween('date_of_birth', [$old, $young]);
                                $first = false;
                            } else {
                                $sub->orWhereBetween('date_of_birth', [$old, $young]);
                            }
                        }
                    });
                })
                ->when(!empty($f['religions']) && $this->hasColumn('employees', 'religion'),
                    fn ($q) => $q->whereIn('religion', $f['religions'])
                )
                ->when(!empty($f['languages']) && $this->hasColumn('employees', 'languages'), function ($q) use ($f) {
                    $q->where(function ($s) use ($f) {
                        foreach (array_values($f['languages']) as $i => $lang) {
                            if ($i === 0) {
                                $s->where('languages', 'like', "%{$lang}%");
                            } else {
                                $s->orWhere('languages', 'like', "%{$lang}%");
                            }
                        }
                    });
                })
                ->when(!empty($f['experiences']), function ($q) use ($f) {
                    $q->whereHas('experiences', fn ($e) => $e->whereIn('country', $f['experiences']));
                });
        }

        protected function buildPersonalQuery(array $f, array $natMatch = null): EloquentBuilder
        {
            $natMatch = $natMatch ?? $this->normalizeInsideNationalityInputs($f);

            return Package::with(['attachments', 'experiences', 'skills'])
                ->where('inside_status', 1)
                ->when(!empty($natMatch['exact']) || !empty($natMatch['likes']), function ($q) use ($natMatch) {
                    $q->where(function ($sub) use ($natMatch) {
                        if (!empty($natMatch['exact'])) {
                            $sub->whereIn(DB::raw('LOWER(nationality)'), $natMatch['exact']);
                        }
                        foreach ($natMatch['likes'] as $i => $like) {
                            $method = (empty($natMatch['exact']) && $i === 0) ? 'where' : 'orWhere';
                            $sub->{$method}(DB::raw('LOWER(nationality)'), 'like', $like);
                        }
                    });
                })
                ->when(!empty($f['ageRanges']), function ($q) use ($f) {
                    $q->where(function ($sub) use ($f) {
                        $first = true;
                        foreach ($f['ageRanges'] as $range) {
                            $young = Carbon::today()->subYears($range['min']);
                            $old   = Carbon::today()->subYears($range['max'] + 1)->addDay();
                            if ($first) {
                                $sub->whereBetween('date_of_birth', [$old, $young]);
                                $first = false;
                            } else {
                                $sub->orWhereBetween('date_of_birth', [$old, $young]);
                            }
                        }
                    });
                })
                ->when(!empty($f['religions']) && $this->hasColumn('packages', 'religion'),
                    fn ($q) => $q->whereIn('religion', $f['religions'])
                )
                ->when(!empty($f['languages']) && $this->hasColumn('packages', 'languages'), function ($q) use ($f) {
                    $q->where(function ($s) use ($f) {
                        foreach (array_values($f['languages']) as $i => $lang) {
                            if ($i === 0) {
                                $s->where('languages', 'like', "%{$lang}%");
                            } else {
                                $s->orWhere('languages', 'like', "%{$lang}%");
                            }
                        }
                    });
                })
                ->when(!empty($f['experiences']), function ($q) use ($f) {
                    $q->whereHas('experiences', fn ($e) => $e->whereIn('country', $f['experiences']));
                });
        }

        protected function debugAllQueries(array $filters): array
        {
            $outside   = $this->buildOutsideQuery($filters);
            $companyNM = $this->normalizeInsideNationalityInputs($filters);
            $company   = $this->buildCompanyQuery($filters, $companyNM);
            $personalNM= $this->normalizeInsideNationalityInputs($filters);
            $personal  = $this->buildPersonalQuery($filters, $personalNM);

            return [
                'filters'           => $filters,
                'company_nat_match' => $companyNM,
                'personal_nat_match'=> $personalNM,
                'outside'           => $this->queryDump($outside),
                'company'           => $this->queryDump($company),
                'personal'          => $this->queryDump($personal),
            ];
        }

        protected function queryDump(EloquentBuilder $builder): array
        {
            $q = $builder->getQuery();

            return [
                'sql'              => $q->toSql(),
                'bindings'         => $q->getBindings(),
                'sql_interpolated' => $this->interpolate($q->toSql(), $q->getBindings()),
            ];
        }

        protected function interpolate(string $sql, array $bindings): string
        {
            $pdo = DB::getPdo();

            foreach ($bindings as $b) {
                if ($b instanceof \DateTimeInterface) {
                    $b = $b->format('Y-m-d H:i:s');
                }
                $replacement = is_numeric($b) ? $b : $pdo->quote($b);
                $sql = preg_replace('/\?/', $replacement, $sql, 1);
            }

            return $sql;
        }

        protected function debugMeta(Request $request, EloquentBuilder $builder, array $filters, array $extra = []): array
        {
            if (!$request->boolean('debug')) {
                return [];
            }

            $q = $builder->getQuery();

            return [
                'debug' => array_merge([
                    'filters'          => $filters,
                    'sql'              => $q->toSql(),
                    'bindings'         => $q->getBindings(),
                    'sql_interpolated' => $this->interpolate($q->toSql(), $q->getBindings()),
                ], $extra),
            ];
        }

        protected function hasColumn(string $table, string $column): bool
        {
            static $cache = [];
            $key = $table . '.' . $column;
            if (!array_key_exists($key, $cache)) {
                $cache[$key] = Schema::hasColumn($table, $column);
            }
            return $cache[$key];
        }

        public function getCandidateBySlug(Request $request): \Illuminate\Http\JsonResponse
        {
            $slug = trim((string) $request->query('slug', ''));
            if ($slug === '') {
                return response()->json(['error' => 'invalid_slug'], 400);
            }

            $perPage = max(6, min(36, (int) $request->input('per_page', 24)));

            $outside = NewCandidate::with([
                'experiences',
                'attachments',
                'nationality',
                'appliedPosition',
                'educationLevel',
                'desiredCountry',
                'fraName',
                'medicalStatus',
                'cocStatus',
                'currentStatus',
                'maritalStatus',
            ])->where('slug', $slug)->first();

            if ($outside) {
                $others = NewCandidate::with(['attachments', 'experiences'])
                    ->where('current_status', 1)
                    ->where('slug', '!=', $slug)
                    ->latest('created_at')
                    ->take($perPage)
                    ->get();

                return response()->json([
                    'data' => [
                        'candidate' => new \App\Http\Resources\NewCandidateResource($outside),
                        'carousel'  => \App\Http\Resources\NewCandidateResource::collection($others),
                    ],
                ]);
            }

            $personal = Package::with(['attachments', 'experiences', 'skills'])
                ->where('slug', $slug)
                ->first();

            if ($personal) {
                $others = Package::with(['attachments', 'experiences'])
                    ->where('inside_status', 1)
                    ->where('slug', '!=', $slug)
                    ->latest('created_at')
                    ->take($perPage)
                    ->get();

                return response()->json([
                    'data' => [
                        'candidate' => new \App\Http\Resources\PackageResource($personal),
                        'carousel'  => \App\Http\Resources\PackageResource::collection($others),
                    ],
                ]);
            }

            $company = Employee::with(['attachments', 'experiences', 'skills'])
                ->where('slug', $slug)
                ->first();

            if ($company) {
                $others = Employee::with(['attachments', 'experiences'])
                    ->where('inside_status', 1)
                    ->where('slug', '!=', $slug)
                    ->latest('created_at')
                    ->take($perPage)
                    ->get();

                return response()->json([
                    'data' => [
                        'candidate' => new \App\Http\Resources\EmployeeResource($company),
                        'carousel'  => \App\Http\Resources\EmployeeResource::collection($others),
                    ],
                ]);
            }

            return response()->json(['error' => 'not_found'], 404);
        }
        
        public function outlet()
        {
            return view('candidates.outlet');
        }

        public function outletData(Request $request)
        {
            $type        = $request->string('type')->lower()->value() ?: 'outside';
            $country     = $request->string('country')->lower()->value() ?: null;
            $q           = $request->string('q')->trim()->value() ?: null;
            $ages        = $request->input('ages', []);
            $langs       = $request->input('langs', []);
            $rels        = $request->input('rels', []);
            $expFilters  = $request->input('exp', []);
            $sponsorship = $request->string('spon')->lower()->value() ?: null;
            $page        = max((int) $request->input('page', 1), 1);
            $perPage     = max(min((int) $request->input('per_page', 20), 60), 1);

            $partnerSlug = function ($v): string {
                $s     = strtolower(trim((string) $v));
                $first = preg_split('/[\s\-_\.,]+/', $s)[0] ?? '';
                return preg_replace('/[^a-z0-9]/', '', $first) ?: '';
            };

            $remoteBase = fn(string $slug): string => 'https://' . $slug . '.onesourceerp.com/storage/app/public/';

            $remoteExists = function (string $url): bool {
                try {
                    $h = @get_headers($url);
                    return is_array($h) && isset($h[0]) && str_contains(strtolower($h[0]), '200');
                } catch (\Throwable $e) {
                    return false;
                }
            };

            $fileUrl = function (?string $path, string $slug) use ($remoteBase, $remoteExists): ?string {
                if (!$path) {
                    return null;
                }

                $clean = ltrim($path, '/');
                $local = str_starts_with($clean, 'public/') ? $clean : 'public/' . $clean;

                if (Storage::exists($local)) {
                    return asset('storage/' . ltrim(str_replace('public/', '', $local), '/'));
                }

                $remote = $remoteBase($slug) . $clean;
                return $remoteExists($remote) ? $remote : null;
            };

            $countryKey = function (?string $nat): ?string {
                $s = strtolower(trim((string) $nat));

                return match (true) {
                    str_contains($s, 'phil')                        => 'philippines',
                    str_contains($s, 'ethiop')                      => 'ethiopia',
                    str_contains($s, 'ugan')                        => 'uganda',
                    str_contains($s, 'indo')                        => 'indonesia',
                    str_contains($s, 'sri')                         => 'sri-lanka',
                    str_contains($s, 'myan'), str_contains($s, 'burm') => 'myanmar',
                    default                                         => null,
                };
            };

            $nationalityLabel = function ($val): ?string {
                if ($val === null || $val === '') {
                    return null;
                }

                if (is_numeric($val)) {
                    $id = (int) $val;

                    return match ($id) {
                        1       => 'Ethiopia',
                        2       => 'Uganda',
                        3       => 'Philippines',
                        default => (string) $val,
                    };
                }

                return (string) $val;
            };

            $ageInfo = function ($dob): array {
                if (!$dob) {
                    return ['age' => null, 'band' => null];
                }

                try {
                    $age = Carbon::parse($dob)->age;
                } catch (\Throwable $e) {
                    return ['age' => null, 'band' => null];
                }

                $band = $age <= 25
                    ? '18-25'
                    : ($age <= 30
                        ? '26-30'
                        : ($age <= 35
                            ? '31-35'
                            : ($age <= 45 ? '36-45' : '46+')));

                return ['age' => $age, 'band' => $band];
            };

            $langArr = function ($raw): array {
                if (is_array($raw)) {
                    return array_values(array_filter(array_map(
                        fn($x) => strtolower(trim((string) $x)),
                        $raw
                    )));
                }

                $txt = trim((string) $raw);
                if ($txt === '') {
                    return [];
                }

                $json = json_decode($txt, true);
                if (is_array($json)) {
                    return array_values(array_filter(array_map(
                        fn($x) => strtolower(trim((string) $x)),
                        $json
                    )));
                }

                return array_values(array_filter(array_map(
                    fn($x) => strtolower(trim($x)),
                    preg_split('/[,|]/', $txt)
                )));
            };

            $experiencesToArray = function ($set) {
                return collect($set ?? [])->map(function ($e) {
                    $yrs = (int) ($e->experience_years ?? $e->years ?? 0);
                    $mon = (int) ($e->experience_months ?? 0);

                    return [
                        'country' => $e->country ?? ($e->country_name ?? null),
                        'years'   => $yrs,
                        'months'  => $mon,
                    ];
                })->values()->all();
            };

            $mediaFromAttachments = function ($attachments, string $slug) use ($fileUrl): array {
                $photo    = null;
                $video    = null;
                $fullBody = null;

                foreach (collect($attachments ?? [])->sortBy(fn($a) => strtolower($a->attachment_type ?? 'zzz')) as $a) {
                    $type = strtolower($a->attachment_type ?? '');
                    $src  = $fileUrl($a->attachment_file ?? null, $slug);

                    if (!$src) {
                        continue;
                    }

                    if (
                        !$photo
                        && (
                            $type === 'passport size photo'
                            || (str_contains($type, 'passport') && !str_contains($type, 'full body'))
                        )
                    ) {
                        $photo = $src;
                    }

                    if (
                        !$fullBody
                        && ($type === 'full body photo' || str_contains($type, 'full body'))
                    ) {
                        $fullBody = $src;
                    }

                    if (
                        !$video
                        && (
                            $type === 'video'
                            || preg_match('/\.(mp4|mov|webm|m4v)$/i', $src)
                        )
                    ) {
                        $video = $src;
                    }
                }

                return [$photo, $video, $fullBody];
            };

            $salaryText = function ($salary, ?string $natKey): ?string {
                if ($salary === null || $salary === '') {
                    return null;
                }

                $n = (float) $salary;

                if ($natKey === 'philippines') {
                    return number_format((int) round($n * 3.64)) . ' AED / month';
                }

                return number_format((int) round($n)) . ' AED / month';
            };

            $mapOutside = fn($c) => (function ($c) use (
                $partnerSlug,
                $mediaFromAttachments,
                $ageInfo,
                $langArr,
                $experiencesToArray,
                $countryKey,
                $salaryText,
                $nationalityLabel
            ) {
                $slug                        = $partnerSlug($c->foreign_partner ?? '');
                [$photo, $video, $fullBody]  = $mediaFromAttachments($c->attachments ?? [], $slug);
                $age                         = $ageInfo($c->date_of_birth ?? null);
                $rawLang                     = $c->languages ?? ($c->language ?? null);

                if (!$rawLang) {
                    $list = [];

                    if ($c->english_skills) {
                        $list[] = 'english';
                    }

                    if ($c->arabic_skills) {
                        $list[] = 'arabic';
                    }

                    $langs = $langArr($list);
                } else {
                    $langs = $langArr($rawLang);
                }

                $natRaw  = optional($c->nationality)->name ?? $c->nationality ?? null;
                $natName = $nationalityLabel($natRaw);
                $ck      = $countryKey($natName);

                $workSkills = [];
                if (method_exists($c, 'getWorkSkillsAttribute')) {
                    $workSkills = $c->work_skills?->pluck('name')->values()->all() ?? [];
                }

                return [
                    'type'                   => 'outside',
                    'sponsorship'            => null,
                    'id'                     => $c->id,
                    'ref'                    => (string) ($c->ref_no ?? $c->reference_no ?? ''),
                    'name'                   => (string) ($c->candidate_name ?? $c->name ?? ''),
                    'nationality'            => (string) ($natName ?? ''),
                    'countryKey'             => $ck,
                    'religion'               => (string) ($c->religion ?? ''),
                    'marital_status'         => (string) (optional($c->maritalStatus)->marital_status ?? $c->marital_status ?? ''),
                    'children_count'         => $c->number_of_children ?? $c->children_count ?? null,
                    'passport_no'            => (string) ($c->passport_no ?? ''),
                    'speaks'                 => $langs,
                    'salary'                 => $c->salary ?? null,
                    'salary_text'            => $salaryText($c->salary ?? null, $ck),
                    'experience_years'       => $c->experience_years ?? null,
                    'experiences'            => $experiencesToArray($c->candidatesExperience ?? $c->experiences ?? []),
                    'photo'                  => $photo,
                    'video'                  => $video,
                    'full_body'              => $fullBody,
                    'arrival'                => $c->arrived_date ?? null,
                    'inside_status'          => null,
                    'age'                    => $age['age'],
                    'ageBand'                => $age['band'],
                    'partner'                => $slug,
                    'position'               => optional($c->appliedPosition)->name ?? null,
                    'contract_duration'      => $c->contract_duration ?? null,
                    'place_of_birth'         => $c->place_of_birth ?? null,
                    'living_town'            => $c->candidate_current_address ?? null,
                    'weight'                 => $c->weight ?? null,
                    'height'                 => $c->height ?? null,
                    'education_level'        => optional($c->educationLevel)->level_name ?? null,
                    'phone_number'           => $c->phone_number ?? null,
                    'family_contact_number'  => $c->family_contact_number_1 ?? null,
                    'passport_issue_date'    => $c->passport_issue_date ?? null,
                    'passport_issue_place'   => $c->passport_issue_place ?? null,
                    'passport_expiry_date'   => $c->passport_expiry_date ?? null,
                    'work_skills'            => $workSkills,
                    'created_at'             => $c->created_at ? $c->created_at->timestamp : null,
                ];
            })($c);

            $mapInside = fn($row, $sponsorshipType) => (function ($row, $sponsorshipType) use (
                $partnerSlug,
                $mediaFromAttachments,
                $ageInfo,
                $langArr,
                $experiencesToArray,
                $countryKey,
                $salaryText,
                $nationalityLabel
            ) {
                $slug                       = $partnerSlug($row->foreign_partner ?? '');
                [$photo, $video, $fullBody] = $mediaFromAttachments($row->attachments ?? [], $slug);
                $age                        = $ageInfo($row->date_of_birth ?? null);
                $langs                      = $langArr($row->languages ?? null);
                $natRaw                     = $row->nationality ?? null;
                $natName                    = $nationalityLabel($natRaw);
                $ck                         = $countryKey($natName);

                return [
                    'type'                   => 'inside',
                    'sponsorship'            => $sponsorshipType,
                    'id'                     => $row->id,
                    'ref'                    => (string) ($row->reference_no ?? $row->ref_no ?? $row->id),
                    'name'                   => (string) ($row->candidate_name ?? $row->name ?? ''),
                    'nationality'            => (string) ($natName ?? ''),
                    'countryKey'             => $ck,
                    'religion'               => (string) ($row->religion ?? ''),
                    'marital_status'         => (string) ($row->marital_status ?? $row->maritial_status ?? ''),
                    'children_count'         => $row->children_count ?? $row->no_of_childrens ?? null,
                    'passport_no'            => (string) ($row->passport_no ?? ''),
                    'speaks'                 => $langs,
                    'salary'                 => $row->salary ?? $row->montly_salary ?? null,
                    'salary_text'            => $salaryText($row->salary ?? $row->montly_salary ?? null, $ck),
                    'experience_years'       => $row->experience_years ?? null,
                    'experiences'            => $experiencesToArray($row->experiences ?? []),
                    'photo'                  => $photo,
                    'video'                  => $video,
                    'full_body'              => $fullBody,
                    'arrival'                => $row->arrived_date ?? null,
                    'inside_status'          => $row->inside_status ?? 1,
                    'age'                    => $age['age'],
                    'ageBand'                => $age['band'],
                    'partner'                => $slug,
                    'position'               => null,
                    'contract_duration'      => $row->contract_duration ?? $row->contract_period ?? null,
                    'place_of_birth'         => $row->place_of_birth ?? null,
                    'living_town'            => $row->living_town ?? null,
                    'weight'                 => $row->weight ?? null,
                    'height'                 => $row->height ?? null,
                    'education_level'        => $row->education ?? null,
                    'phone_number'           => null,
                    'family_contact_number'  => $row->family_contact_no ?? null,
                    'passport_issue_date'    => $row->passport_issue_date ?? null,
                    'passport_issue_place'   => $row->place_of_issue ?? null,
                    'passport_expiry_date'   => $row->passport_expiry_date ?? $row->expiry_date ?? null,
                    'work_skills'            => [],
                    'created_at'             => $row->created_at ? $row->created_at->timestamp : null,
                ];
            })($row, $sponsorshipType);

            if ($type === 'outside') {
                $query = NewCandidate::with([
                    'nationality',
                    'maritalStatus',
                    'attachments' => fn($q2) => $q2->whereIn('attachment_type', ['Passport Size Photo', 'Video', 'Full Body Photo']),
                    'candidatesExperience' => fn($q2) => $q2->where('experience_years', '>=', 0),
                    'appliedPosition',
                    'educationLevel',
                ])
                    ->where('status', 1)
                    ->where('current_status', 1);

                if ($country) {
                    $query->where(function ($q2) use ($country) {
                        $q2->whereHas('nationality', function ($q3) use ($country) {
                            $c = $country;
                            if ($c === 'philippines') {
                                $q3->where('name', 'like', '%phil%');
                            } elseif ($c === 'ethiopia') {
                                $q3->where('name', 'like', '%ethiop%');
                            } elseif ($c === 'uganda') {
                                $q3->where('name', 'like', '%ugan%');
                            }
                        })->orWhere(function ($q3) use ($country) {
                            if ($country === 'philippines') {
                                $q3->where('nationality', 'like', '%phil%');
                            } elseif ($country === 'ethiopia') {
                                $q3->where('nationality', 'like', '%ethiop%');
                            } elseif ($country === 'uganda') {
                                $q3->where('nationality', 'like', '%ugan%');
                            }
                        });
                    });
                }

                if ($q) {
                    $query->where(function ($q2) use ($q) {
                        $q2->where('candidate_name', 'like', '%' . $q . '%')
                            ->orWhere('ref_no', 'like', '%' . $q . '%')
                            ->orWhere('reference_no', 'like', '%' . $q . '%')
                            ->orWhere('passport_no', 'like', '%' . $q . '%');
                    });
                }

                if (!empty($rels)) {
                    $relsLower = array_map('strtolower', $rels);
                    $query->where(function ($q2) use ($relsLower) {
                        foreach ($relsLower as $r) {
                            $q2->orWhereRaw('lower(religion) like ?', ['%' . $r . '%']);
                        }
                    });
                }

                if (!empty($langs)) {
                    $langsLower = array_map('strtolower', $langs);
                    $query->where(function ($q2) use ($langsLower) {
                        foreach ($langsLower as $l) {
                            $q2->orWhereRaw('lower(languages) like ?', ['%' . $l . '%'])
                                ->orWhereRaw('lower(language) like ?', ['%' . $l . '%']);
                        }
                    });
                }

                if (!empty($ages)) {
                    $query->whereNotNull('date_of_birth');
                }

                if (!empty($expFilters)) {
                    if (in_array('first', $expFilters, true)) {
                        $query->where(function ($q2) {
                            $q2->whereNull('experience_years')
                                ->orWhere('experience_years', '<=', 0)
                                ->orWhereDoesntHave('candidatesExperience');
                        });
                    }

                    $countries = array_filter($expFilters, fn($e) => $e !== 'first' && $e !== 'others');

                    if (!empty($countries)) {
                        foreach ($countries as $c) {
                            $name = strtolower($c);
                            $query->whereHas('candidatesExperience', function ($q2) use ($name) {
                                $q2->whereRaw('lower(country) = ?', [$name]);
                            });
                        }
                    }
                }

                $query     = $query->latest('created_at');
                $paginator = $query->paginate($perPage, ['*'], 'page', $page);
                $items     = $paginator->getCollection()->map($mapOutside)->values()->all();

                if (!empty($ages)) {
                    $items = array_values(array_filter($items, function ($m) use ($ages) {
                        return $m['ageBand'] && in_array($m['ageBand'], $ages, true);
                    }));
                }

                return response()->json([
                    'items'     => $items,
                    'page'      => $paginator->currentPage(),
                    'per_page'  => $perPage,
                    'total'     => $paginator->total(),
                    'last_page' => $paginator->lastPage(),
                ]);
            }

            $buildInsidePersonalQuery = function () use ($country, $q, $rels, $langs, $ages, $expFilters) {
                $query = Package::with([
                    'attachments' => fn($q2) => $q2->whereIn('attachment_type', ['Passport Size Photo', 'Video', 'Full Body Photo']),
                    'experiences',
                ])->where('inside_status', 1);

                if ($country) {
                    $query->where(function ($q2) use ($country) {
                        if ($country === 'philippines') {
                            $q2->where('nationality', 'like', '%phil%');
                        } elseif ($country === 'ethiopia') {
                            $q2->where('nationality', 'like', '%ethiop%');
                        } elseif ($country === 'uganda') {
                            $q2->where('nationality', 'like', '%ugan%');
                        }
                    });
                }

                if ($q) {
                    $query->where(function ($q2) use ($q) {
                        $q2->where('candidate_name', 'like', '%' . $q . '%')
                            ->orWhere('hr_ref_no', 'like', '%' . $q . '%')
                            ->orWhere('passport_no', 'like', '%' . $q . '%');
                    });
                }

                if (!empty($rels)) {
                    $relsLower = array_map('strtolower', $rels);
                    $query->where(function ($q2) use ($relsLower) {
                        foreach ($relsLower as $r) {
                            $q2->orWhereRaw('lower(religion) like ?', ['%' . $r . '%']);
                        }
                    });
                }

                if (!empty($langs)) {
                    $langsLower = array_map('strtolower', $langs);
                    $query->where(function ($q2) use ($langsLower) {
                        foreach ($langsLower as $l) {
                            $q2->orWhereRaw('lower(languages) like ?', ['%' . $l . '%']);
                        }
                    });
                }

                if (!empty($ages)) {
                    $query->whereNotNull('date_of_birth');
                }

                if (!empty($expFilters)) {
                    if (in_array('first', $expFilters, true)) {
                        $query->where(function ($q2) {
                            $q2->whereNull('experience_years')
                                ->orWhere('experience_years', '<=', 0)
                                ->orWhereDoesntHave('experiences');
                        });
                    }

                    $countries = array_filter($expFilters, fn($e) => $e !== 'first' && $e !== 'others');

                    if (!empty($countries)) {
                        foreach ($countries as $c) {
                            $name = strtolower($c);
                            $query->whereHas('experiences', function ($q2) use ($name) {
                                $q2->whereRaw('lower(country) = ?', [$name]);
                            });
                        }
                    }
                }

                return $query;
            };

            $buildInsideCompanyQuery = function () use ($country, $q, $rels, $langs, $ages, $expFilters) {
                $query = Employee::with([
                    'attachments' => fn($q2) => $q2->whereIn('attachment_type', ['Passport Size Photo', 'Video', 'Full Body Photo']),
                    'experiences',
                ])->where('inside_status', 1);

                if ($country) {
                    $query->where(function ($q2) use ($country) {
                        if ($country === 'philippines') {
                            $q2->where('nationality', 'like', '%phil%');
                        } elseif ($country === 'ethiopia') {
                            $q2->where('nationality', 'like', '%ethiop%');
                        } elseif ($country === 'uganda') {
                            $q2->where('nationality', 'like', '%ugan%');
                        }
                    });
                }

                if ($q) {
                    $query->where(function ($q2) use ($q) {
                        $q2->where('name', 'like', '%' . $q . '%')
                            ->orWhere('reference_no', 'like', '%' . $q . '%')
                            ->orWhere('passport_no', 'like', '%' . $q . '%');
                    });
                }

                if (!empty($rels)) {
                    $relsLower = array_map('strtolower', $rels);
                    $query->where(function ($q2) use ($relsLower) {
                        foreach ($relsLower as $r) {
                            $q2->orWhereRaw('lower(religion) like ?', ['%' . $r . '%']);
                        }
                    });
                }

                if (!empty($langs)) {
                    $langsLower = array_map('strtolower', $langs);
                    $query->where(function ($q2) use ($langsLower) {
                        foreach ($langsLower as $l) {
                            $q2->orWhereRaw('lower(languages) like ?', ['%' . $l . '%']);
                        }
                    });
                }

                if (!empty($ages)) {
                    $query->whereNotNull('date_of_birth');
                }

                if (!empty($expFilters)) {
                    if (in_array('first', $expFilters, true)) {
                        $query->where(function ($q2) {
                            $q2->whereNull('experience_years')
                                ->orWhere('experience_years', '<=', 0)
                                ->orWhereDoesntHave('experiences');
                        });
                    }

                    $countries = array_filter($expFilters, fn($e) => $e !== 'first' && $e !== 'others');

                    if (!empty($countries)) {
                        foreach ($countries as $c) {
                            $name = strtolower($c);
                            $query->whereHas('experiences', function ($q2) use ($name) {
                                $q2->whereRaw('lower(country) = ?', [$name]);
                            });
                        }
                    }
                }

                return $query;
            };

            if ($type === 'inside-personal' || ($type === 'inside' && $sponsorship === 'personal')) {
                $query     = $buildInsidePersonalQuery()->latest('created_at');
                $paginator = $query->paginate($perPage, ['*'], 'page', $page);
                $items     = $paginator->getCollection()->map(fn($row) => $mapInside($row, 'personal'))->values()->all();

                if (!empty($ages)) {
                    $items = array_values(array_filter($items, function ($m) use ($ages) {
                        return $m['ageBand'] && in_array($m['ageBand'], $ages, true);
                    }));
                }

                return response()->json([
                    'items'     => $items,
                    'page'      => $paginator->currentPage(),
                    'per_page'  => $perPage,
                    'total'     => $paginator->total(),
                    'last_page' => $paginator->lastPage(),
                ]);
            }

            if ($type === 'inside-company' || ($type === 'inside' && $sponsorship === 'company')) {
                $query     = $buildInsideCompanyQuery()->latest('created_at');
                $paginator = $query->paginate($perPage, ['*'], 'page', $page);
                $items     = $paginator->getCollection()->map(fn($row) => $mapInside($row, 'company'))->values()->all();

                if (!empty($ages)) {
                    $items = array_values(array_filter($items, function ($m) use ($ages) {
                        return $m['ageBand'] && in_array($m['ageBand'], $ages, true);
                    }));
                }

                return response()->json([
                    'items'     => $items,
                    'page'      => $paginator->currentPage(),
                    'per_page'  => $perPage,
                    'total'     => $paginator->total(),
                    'last_page' => $paginator->lastPage(),
                ]);
            }

            if ($type === 'inside') {
                $personalRows = $buildInsidePersonalQuery()->latest('created_at')->get();
                $companyRows  = $buildInsideCompanyQuery()->latest('created_at')->get();

                $personalItems = collect($personalRows)->map(fn($row) => $mapInside($row, 'personal'));
                $companyItems  = collect($companyRows)->map(fn($row) => $mapInside($row, 'company'));

                $merged = $personalItems->concat($companyItems);

                if (!empty($ages)) {
                    $merged = $merged->filter(function ($m) use ($ages) {
                        return $m['ageBand'] && in_array($m['ageBand'], $ages, true);
                    });
                }

                $merged = $merged->sortByDesc('created_at')->values();

                $total    = $merged->count();
                $lastPage = $total > 0 ? (int) ceil($total / $perPage) : 1;
                $page     = max(1, min($page, $lastPage));

                $offset = ($page - 1) * $perPage;
                $items  = $merged->slice($offset, $perPage)->values()->all();

                return response()->json([
                    'items'     => $items,
                    'page'      => $page,
                    'per_page'  => $perPage,
                    'total'     => $total,
                    'last_page' => $lastPage,
                ]);
            }

            return response()->json([
                'items'     => [],
                'page'      => 1,
                'per_page'  => $perPage,
                'total'     => 0,
                'last_page' => 1,
            ]);
        }

        public function sendActionEmail(
            string $to,
            string $action,
            string $passport_no,
            string $candidate_name,
            string $foreign_partner,
            string $ref_no,
            string $action_date,
            $files = null,
            ?string $other = null
        ) {
            config([
                'mail.default'                 => 'smtp',
                'mail.mailers.smtp.transport'  => 'smtp',
                'mail.mailers.smtp.host'       => 'mail.onesourceerp.com',
                'mail.mailers.smtp.port'       => 465,
                'mail.mailers.smtp.encryption' => 'ssl',
                'mail.mailers.smtp.username'   => 'no-reply@onesourceerp.com',
                'mail.mailers.smtp.password'   => 'Shahzad_12345',
                'mail.from.address'            => 'no-reply@onesourceerp.com',
                'mail.from.name'               => 'OneSource ERP',
            ]);

            if (is_string($files) && $files !== '') {
                $files = [$files];
            }

            if (! is_array($files)) {
                $files = [];
            }

            $subject = $candidate_name . ' has ' . $action . ' successfully.';

            $data = [
                'action'          => $action,
                'passport_no'     => $passport_no,
                'candidate_name'  => $candidate_name,
                'foreign_partner' => $foreign_partner,
                'ref_no'          => $ref_no,
                'action_date'     => $action_date,
                'files'           => $files,
                'other'           => $other,
            ];

            $status        = 'sent';
            $error_message = null;

            try {
                Mail::mailer('smtp')->send('emails.action_notification', $data, function ($message) use ($to, $action, $subject, $files) {
                    $message->from('no-reply@onesourceerp.com', $action);
                    $message->to($to)->subject($subject);

                    foreach ($files as $filePath) {
                        if ($filePath && file_exists($filePath)) {
                            $message->attach($filePath);
                        }
                    }
                });
            } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
                $status = 'failed';
                $prev   = $e->getPrevious();
                $extra  = $prev ? ' | previous: ' . $prev->getMessage() : '';
                $error_message = 'Mail transport error: ' . $e->getMessage() . $extra;
            } catch (\Throwable $e) {
                $status        = 'failed';
                $error_message = 'General mail error: ' . $e->getMessage();
            }

            EmailSent::create([
                'to_email'        => $to,
                'action'          => $action,
                'passport_no'     => $passport_no,
                'candidate_name'  => $candidate_name,
                'foreign_partner' => $foreign_partner,
                'ref_no'          => $ref_no,
                'action_date'     => $action_date,
                'file'            => json_encode($files),
                'other'           => $other,
                'subject'         => $subject,
                'status'          => $status,
                'error_message'   => $error_message,
            ]);

            return $status === 'sent'
                ? 'Email sent to ' . $to
                : 'Email failed to ' . $to . ' | ' . $error_message;
        }

        protected function getActionEmailRecipients(NewCandidate $candidate)
        {
            $emails = collect([
                'shahzadtanveer360@gmail.com',
            ]);

            $foreignPartner = $candidate->foreign_partner;
            $remoteDb       = $this->getForeignDatabaseName($foreignPartner);

            if (empty($remoteDb) || ! array_key_exists($remoteDb, config('database.connections'))) {
                return $emails->filter()->unique()->values();
            }

            try {
                $remoteCandidate = DB::connection($remoteDb)
                    ->table('candidates')
                    ->where('ref_no', $candidate->ref_no)
                    ->first();

                if ($remoteCandidate && ! empty($remoteCandidate->created_by)) {
                    $remoteCreator = DB::connection($remoteDb)
                        ->table('users')
                        ->where('id', $remoteCandidate->created_by)
                        ->first();

                    if ($remoteCreator && ! empty($remoteCreator->update_email)) {
                        $emails->push($remoteCreator->update_email);
                    }
                }

                $branchId  = $candidate->registered_branch;
                $companyId = $candidate->registered_company;

                $remoteExtraUsers = DB::connection($remoteDb)
                    ->table('users')
                    ->whereIn('role', ['Operation Manager', 'IT'])
                    ->where('branch_id', $branchId)
                    ->where('company_id', $companyId)
                    ->whereNotNull('update_email')
                    ->pluck('update_email');

                $emails = $emails->merge($remoteExtraUsers);
            } catch (\Throwable $e) {
                \Log::warning('Could not fetch remote action email recipients: ' . $e->getMessage());
            }

            return $emails->filter()->unique()->values();
        }
    }
