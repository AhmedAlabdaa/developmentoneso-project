<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\NewCandidate;
use App\Models\Staff;
use App\Models\Invoice;
use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Contract;
use App\Models\Incident;
use App\Models\License;
use App\Models\CRM;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $user = User::where(function ($q) use ($request) {
                    $q->where('email', $request->email)
                      ->orWhere('first_name', $request->email);
                })
                ->where('status', 'active')
                ->first();

        if ($user && $user->password === $request->password) {
            Auth::login($user);
            Session::put('user_id',    $user->id);
            Session::put('first_name', $user->first_name);
            Session::put('last_name',  $user->last_name);
            Session::put('role',       $user->role);

            $token = Str::random(60);
            $user->api_token = $token;
            $user->api_token_created_at = now();
            $user->save();

            return response()->json([
                'success'      => true,
                'message'      => 'Login successful. Redirecting to dashboard...',
                'redirect_url' => route('dashboard'),
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ]);
        }

        Log::error('Login failed.', [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials. Please try again.',
        ], 401);
    }

    public function dashboard(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['You must be logged in to access the dashboard.']);
        }

        $user = Auth::user();
        switch ($user->role) {
            case 'Admin':
                return $this->adminDashboard($request);
            case 'HR Manager':
                return $this->hrmDashboard();
            case 'Finance Officer':
                return $this->FinanceDashboard();
            case 'Sales Officer':
                return $this->salesOfficerDashboard();
            case 'Managing Director':
                return $this->managingDirectorDashboard($request);
            case 'Marketing Manager':
                return $this->marketingManagerDashboard();
            case 'Digital Marketing Specialist':
                return $this->digitalMarketingSpecialistDashboard();
            case 'Digital Marketing Executive':
                return $this->digitalMarketingExecutiveDashboard();
            case 'Photographer':
                return $this->photographerDashboard();
            case 'Accountant':
            case 'Junior Accountant':
                return $this->juniorAccountantDashboard();
            case 'Cashier':
                return $this->cashierDashboard();
            case 'Contract Administrator':
                return $this->contractAdministratorDashboard();
            case 'PRO':
                return $this->proDashboard();
            case 'Web Manager':
                return $this->webManagerDashboard();
            case 'Sales Coordinator':
                return $this->salesCoordinatorDashboard();
            case 'Operations Manager':
                return $this->operationsManagerDashboard($request);
            case 'Sales Manager':
                return $this->salesManagerDashboard($request);
            case 'Operations Supervisor':
                return $this->operationsSupervisorDashboard($request);
            case 'Happiness Consultant':
                return $this->happinessConsultantDashboard();
            case 'Customer Services':
                return $this->customerServicesDashboard();
            case 'Archive Clerk':
                return $this->archiveClerkDashboard();
            default:
                return redirect()->route('login')->withErrors(['You do not have access to the dashboard.']);
        }
    }

    private function resolveTableName($connection)
    {
        if ($connection === 'mysql' || $connection === 'tadbeeralebdaaon_new') {
            return 'new_candidates';
        }
        return 'candidates';
    }

    private function getCandidateStats($connection, $startDate, $endDate)
    {
        $table = $this->resolveTableName($connection);
        $baseQuery = DB::connection($connection)->table($table);

        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
            $baseQuery->whereBetween('created_at', [$start, $end]);
        }

        return [
            'All' => (clone $baseQuery)->count(),
            'Available' => (clone $baseQuery)
                ->where('current_status', 1)
                ->where(function ($q) {
                    $q->whereNotNull('coc_registration_date')
                      ->orWhereNotNull('coc_status_date');
                })
                ->count(),
            'Draft' => (clone $baseQuery)
                ->where('current_status', 1)
                ->whereNull('coc_registration_date')
                ->whereNull('coc_status_date')
                ->count(),
            'On Process' => (clone $baseQuery)
                ->whereIn('current_status', [3, 4, 5, 7, 13, 15, 17])
                ->count(),
            'Incident' => (clone $baseQuery)
                ->whereIn('current_status', [6, 8, 14, 16])
                ->count(),
            'Backout' => (clone $baseQuery)
                ->where('current_status', 2)
                ->count(),
            'COC Done' => (clone $baseQuery)
                ->whereNotNull('coc_status_date')
                ->where('coc_status_date', '<>', '')
                ->count(),
            'COC Receipted' => (clone $baseQuery)
                ->whereNotNull('coc_registration_date')
                ->where('coc_registration_date', '<>', '')
                ->count(),
            'Medical' => (clone $baseQuery)
                ->whereNotNull('medical_date')
                ->where('medical_date', '<>', '')
                ->count(),
            'MOL Issued' => (clone $baseQuery)
                ->whereNotNull('l_issued_date')
                ->where('l_issued_date', '<>', '')
                ->count(),
            'MOL Submitted' => (clone $baseQuery)
                ->whereNotNull('l_submitted_date')
                ->where('l_submitted_date', '<>', '')
                ->count(),
        ];
    }

    private function getMonthlyProgressData($connection, $startDate, $endDate)
    {
        $table = $this->resolveTableName($connection);
        $baseQuery = DB::connection($connection)->table($table);

        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
            $baseQuery->whereBetween('created_at', [$start, $end]);
        }

        $statusNames = [
            1 => 'Available',
            2 => 'Back Out',
            3 => 'Hold',
            4 => 'Selected',
            5 => 'WC-Date',
            6 => 'Incident Before Visa (IBV)',
            7 => 'Visa Date',
            8 => 'Incident After Visa (IAV)',
            9 => 'Medical Status',
            10 => 'COC-Status',
            11 => 'MoL Submitted Date',
            12 => 'MoL Issued Date',
            13 => 'Departure Date',
            14 => 'Incident After Departure (IAD)',
            15 => 'Arrived Date',
            16 => 'Incident After Arrival (IAA)',
            17 => 'Transfer Date',
        ];

        $monthlyData = $baseQuery
            ->selectRaw('MONTH(created_at) as month, current_status, COUNT(*) as count')
            ->groupBy('month', 'current_status')
            ->get()
            ->groupBy('current_status')
            ->map(function ($statusData) {
                return $statusData->pluck('count', 'month');
            });

        $formatted = [];

        foreach ($monthlyData as $status => $data) {
            $statusName = $statusNames[$status] ?? 'Unknown Status';
            $formatted[$statusName] = array_replace(array_fill(1, 12, 0), $data->toArray());
        }

        return $formatted;
    }

    private function adminDashboard(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $totalStaff = Staff::count();
        $totalEmployees = NewCandidate::whereIn('preferred_package', ['PKG-2', 'PKG-3', 'PKG-4'])->count();
        $totalCustomers = CRM::count();
        $totalAgreements = Agreement::count();
        $totalContracts = Contract::count();
        $totalIncidents = Incident::count();
        $insideCandidates = NewCandidate::whereIn('inside_status', [1, 2, 3, 4])->count();
        $outsideCandidates = NewCandidate::whereIn('current_status', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])->count();
        $proformaInvoices = Invoice::where('invoice_type', 'Proforma')->count();
        $taxInvoices = Invoice::where('invoice_type', 'Tax')->count();
        $totalActivities = Activity::count();
        $totalDocuments = License::count();
        $package1 = NewCandidate::where('preferred_package', 'PKG-1')->count();
        $package2 = NewCandidate::where('preferred_package', 'PKG-2')->count();
        $package3 = NewCandidate::where('preferred_package', 'PKG-3')->count();
        $package4 = NewCandidate::where('preferred_package', 'PKG-4')->count();
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();
        $formattedMonthlyData = $this->getMonthlyProgressData('mysql', $startDate, $endDate);
        $mainStats = $this->getCandidateStats('mysql', $startDate, $endDate);

        $companies = [
            'ETHIOPIA' => [
                ['name' => 'Adey',  'db' => 'adeyonesourceerp_new'],
                ['name' => 'ALKABA','db' => 'alkabaonesourcee_new'],
                ['name' => 'BMG',   'db' => 'bmgonesourceerp_new'],
                ['name' => 'MY',    'db' => 'myonesourceerp_new'],
            ],
            'PHILIPPINE' => [
                ['name' => 'Rite Merit',         'db' => 'ritemeritonesour_new'],
                ['name' => 'Khalid International','db' => 'khalidonesourcee_new'],
            ],
            'UGANDA' => [
                ['name' => 'Stella', 'db' => 'estella_new'],
            ],
        ];

        $companyStats = [];

        foreach ($companies as $country => $list) {
            foreach ($list as $company) {
                $companyStats[$country][$company['name']] = $this->getCandidateStats(
                    $company['db'],
                    $startDate,
                    $endDate
                );
            }
        }

        return view('Admin-dashboard', [
            'now' => $now,
            'totalStaff' => $totalStaff,
            'totalEmployees' => $totalEmployees,
            'totalCustomers' => $totalCustomers,
            'totalAgreements' => $totalAgreements,
            'totalContracts' => $totalContracts,
            'totalIncidents' => $totalIncidents,
            'insideCandidates' => $insideCandidates,
            'outsideCandidates' => $outsideCandidates,
            'proformaInvoices' => $proformaInvoices,
            'taxInvoices' => $taxInvoices,
            'totalActivities' => $totalActivities,
            'totalDocuments' => $totalDocuments,
            'package1' => $package1,
            'package2' => $package2,
            'package3' => $package3,
            'package4' => $package4,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'formattedMonthlyData' => $formattedMonthlyData,
            'mainStats' => $mainStats,
            'companyStats' => $companyStats,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    private function managingDirectorDashboard(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $totalStaff = Staff::count();
        $totalEmployees = NewCandidate::whereIn('preferred_package', ['PKG-2', 'PKG-3', 'PKG-4'])->count();
        $totalCustomers = CRM::count();
        $totalAgreements = Agreement::count();
        $totalContracts = Contract::count();
        $totalIncidents = Incident::count();
        $insideCandidates = NewCandidate::whereIn('inside_status', [1, 2, 3, 4])->count();
        $outsideCandidates = NewCandidate::whereIn('current_status', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])->count();
        $proformaInvoices = Invoice::where('invoice_type', 'Proforma')->count();
        $taxInvoices = Invoice::where('invoice_type', 'Tax')->count();
        $totalActivities = Activity::count();
        $totalDocuments = License::count();
        $package1 = NewCandidate::where('preferred_package', 'PKG-1')->count();
        $package2 = NewCandidate::where('preferred_package', 'PKG-2')->count();
        $package3 = NewCandidate::where('preferred_package', 'PKG-3')->count();
        $package4 = NewCandidate::where('preferred_package', 'PKG-4')->count();
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();
        $formattedMonthlyData = $this->getMonthlyProgressData('mysql', $startDate, $endDate);
        $mainStats = $this->getCandidateStats('mysql', $startDate, $endDate);

        $companies = [
            'ETHIOPIA' => [
                ['name' => 'Adey',  'db' => 'adeyonesourceerp_new'],
                ['name' => 'ALKABA','db' => 'alkabaonesourcee_new'],
                ['name' => 'BMG',   'db' => 'bmgonesourceerp_new'],
                ['name' => 'MY',    'db' => 'myonesourceerp_new'],
            ],
            'PHILIPPINE' => [
                ['name' => 'Rite Merit',         'db' => 'ritemeritonesour_new'],
                ['name' => 'Khalid International','db' => 'khalidonesourcee_new'],
            ],
            'UGANDA' => [
                ['name' => 'Stella', 'db' => 'estella_new'],
            ],
        ];

        $companyStats = [];

        foreach ($companies as $country => $list) {
            foreach ($list as $company) {
                $companyStats[$country][$company['name']] = $this->getCandidateStats(
                    $company['db'],
                    $startDate,
                    $endDate
                );
            }
        }

        return view('Managing-Director-dashboard', [
            'now' => $now,
            'totalStaff' => $totalStaff,
            'totalEmployees' => $totalEmployees,
            'totalCustomers' => $totalCustomers,
            'totalAgreements' => $totalAgreements,
            'totalContracts' => $totalContracts,
            'totalIncidents' => $totalIncidents,
            'insideCandidates' => $insideCandidates,
            'outsideCandidates' => $outsideCandidates,
            'proformaInvoices' => $proformaInvoices,
            'taxInvoices' => $taxInvoices,
            'totalActivities' => $totalActivities,
            'totalDocuments' => $totalDocuments,
            'package1' => $package1,
            'package2' => $package2,
            'package3' => $package3,
            'package4' => $package4,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'formattedMonthlyData' => $formattedMonthlyData,
            'mainStats' => $mainStats,
            'companyStats' => $companyStats,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    private function operationsManagerDashboard(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $totalStaff = Staff::count();
        $totalEmployees = NewCandidate::whereIn('preferred_package', ['PKG-2', 'PKG-3', 'PKG-4'])->count();
        $totalCustomers = CRM::count();
        $totalAgreements = Agreement::count();
        $totalContracts = Contract::count();
        $totalIncidents = Incident::count();
        $insideCandidates = NewCandidate::whereIn('inside_status', [1, 2, 3, 4])->count();
        $outsideCandidates = NewCandidate::whereIn('current_status', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])->count();
        $proformaInvoices = Invoice::where('invoice_type', 'Proforma')->count();
        $taxInvoices = Invoice::where('invoice_type', 'Tax')->count();
        $totalActivities = Activity::count();
        $totalDocuments = License::count();
        $package1 = NewCandidate::where('preferred_package', 'PKG-1')->count();
        $package2 = NewCandidate::where('preferred_package', 'PKG-2')->count();
        $package3 = NewCandidate::where('preferred_package', 'PKG-3')->count();
        $package4 = NewCandidate::where('preferred_package', 'PKG-4')->count();
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();
        $formattedMonthlyData = $this->getMonthlyProgressData('mysql', $startDate, $endDate);
        $mainStats = $this->getCandidateStats('mysql', $startDate, $endDate);

        $companies = [
            'ETHIOPIA' => [
                ['name' => 'Adey',  'db' => 'adeyonesourceerp_new'],
                ['name' => 'ALKABA','db' => 'alkabaonesourcee_new'],
                ['name' => 'BMG',   'db' => 'bmgonesourceerp_new'],
                ['name' => 'MY',    'db' => 'myonesourceerp_new'],
            ],
            'PHILIPPINE' => [
                ['name' => 'Rite Merit',         'db' => 'ritemeritonesour_new'],
                ['name' => 'Khalid International','db' => 'khalidonesourcee_new'],
            ],
            'UGANDA' => [
                ['name' => 'Stella', 'db' => 'estella_new'],
            ],
        ];

        $companyStats = [];

        foreach ($companies as $country => $list) {
            foreach ($list as $company) {
                $companyStats[$country][$company['name']] = $this->getCandidateStats(
                    $company['db'],
                    $startDate,
                    $endDate
                );
            }
        }

        return view('Operations-Manager-dashboard', [
            'now' => $now,
            'totalStaff' => $totalStaff,
            'totalEmployees' => $totalEmployees,
            'totalCustomers' => $totalCustomers,
            'totalAgreements' => $totalAgreements,
            'totalContracts' => $totalContracts,
            'totalIncidents' => $totalIncidents,
            'insideCandidates' => $insideCandidates,
            'outsideCandidates' => $outsideCandidates,
            'proformaInvoices' => $proformaInvoices,
            'taxInvoices' => $taxInvoices,
            'totalActivities' => $totalActivities,
            'totalDocuments' => $totalDocuments,
            'package1' => $package1,
            'package2' => $package2,
            'package3' => $package3,
            'package4' => $package4,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'formattedMonthlyData' => $formattedMonthlyData,
            'mainStats' => $mainStats,
            'companyStats' => $companyStats,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    private function salesManagerDashboard(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $totalStaff = Staff::count();
        $totalEmployees = NewCandidate::whereIn('preferred_package', ['PKG-2', 'PKG-3', 'PKG-4'])->count();
        $totalCustomers = CRM::count();
        $totalAgreements = Agreement::count();
        $totalContracts = Contract::count();
        $totalIncidents = Incident::count();
        $insideCandidates = NewCandidate::whereIn('inside_status', [1, 2, 3, 4])->count();
        $outsideCandidates = NewCandidate::whereIn('current_status', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])->count();
        $proformaInvoices = Invoice::where('invoice_type', 'Proforma')->count();
        $taxInvoices = Invoice::where('invoice_type', 'Tax')->count();
        $totalActivities = Activity::count();
        $totalDocuments = License::count();
        $package1 = NewCandidate::where('preferred_package', 'PKG-1')->count();
        $package2 = NewCandidate::where('preferred_package', 'PKG-2')->count();
        $package3 = NewCandidate::where('preferred_package', 'PKG-3')->count();
        $package4 = NewCandidate::where('preferred_package', 'PKG-4')->count();
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();
        $formattedMonthlyData = $this->getMonthlyProgressData('mysql', $startDate, $endDate);
        $mainStats = $this->getCandidateStats('mysql', $startDate, $endDate);

        $companies = [
            'ETHIOPIA' => [
                ['name' => 'Adey',  'db' => 'adeyonesourceerp_new'],
                ['name' => 'ALKABA','db' => 'alkabaonesourcee_new'],
                ['name' => 'BMG',   'db' => 'bmgonesourceerp_new'],
                ['name' => 'MY',    'db' => 'myonesourceerp_new'],
            ],
            'PHILIPPINE' => [
                ['name' => 'Rite Merit',         'db' => 'ritemeritonesour_new'],
                ['name' => 'Khalid International','db' => 'khalidonesourcee_new'],
            ],
            'UGANDA' => [
                ['name' => 'Stella', 'db' => 'estella_new'],
            ],
        ];

        $companyStats = [];

        foreach ($companies as $country => $list) {
            foreach ($list as $company) {
                $companyStats[$country][$company['name']] = $this->getCandidateStats(
                    $company['db'],
                    $startDate,
                    $endDate
                );
            }
        }

        return view('Sales-Manager-dashboard', [
            'now' => $now,
            'totalStaff' => $totalStaff,
            'totalEmployees' => $totalEmployees,
            'totalCustomers' => $totalCustomers,
            'totalAgreements' => $totalAgreements,
            'totalContracts' => $totalContracts,
            'totalIncidents' => $totalIncidents,
            'insideCandidates' => $insideCandidates,
            'outsideCandidates' => $outsideCandidates,
            'proformaInvoices' => $proformaInvoices,
            'taxInvoices' => $taxInvoices,
            'totalActivities' => $totalActivities,
            'totalDocuments' => $totalDocuments,
            'package1' => $package1,
            'package2' => $package2,
            'package3' => $package3,
            'package4' => $package4,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'formattedMonthlyData' => $formattedMonthlyData,
            'mainStats' => $mainStats,
            'companyStats' => $companyStats,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    private function operationsSupervisorDashboard(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $totalStaff = Staff::count();
        $totalEmployees = NewCandidate::whereIn('preferred_package', ['PKG-2', 'PKG-3', 'PKG-4'])->count();
        $totalCustomers = CRM::count();
        $totalAgreements = Agreement::count();
        $totalContracts = Contract::count();
        $totalIncidents = Incident::count();
        $insideCandidates = NewCandidate::whereIn('inside_status', [1, 2, 3, 4])->count();
        $outsideCandidates = NewCandidate::whereIn('current_status', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])->count();
        $proformaInvoices = Invoice::where('invoice_type', 'Proforma')->count();
        $taxInvoices = Invoice::where('invoice_type', 'Tax')->count();
        $totalActivities = Activity::count();
        $totalDocuments = License::count();
        $package1 = NewCandidate::where('preferred_package', 'PKG-1')->count();
        $package2 = NewCandidate::where('preferred_package', 'PKG-2')->count();
        $package3 = NewCandidate::where('preferred_package', 'PKG-3')->count();
        $package4 = NewCandidate::where('preferred_package', 'PKG-4')->count();
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();
        $formattedMonthlyData = $this->getMonthlyProgressData('mysql', $startDate, $endDate);
        $mainStats = $this->getCandidateStats('mysql', $startDate, $endDate);

        $companies = [
            'ETHIOPIA' => [
                ['name' => 'Adey',  'db' => 'adeyonesourceerp_new'],
                ['name' => 'ALKABA','db' => 'alkabaonesourcee_new'],
                ['name' => 'BMG',   'db' => 'bmgonesourceerp_new'],
                ['name' => 'MY',    'db' => 'myonesourceerp_new'],
            ],
            'PHILIPPINE' => [
                ['name' => 'Rite Merit',         'db' => 'ritemeritonesour_new'],
                ['name' => 'Khalid International','db' => 'khalidonesourcee_new'],
            ],
            'UGANDA' => [
                ['name' => 'Stella', 'db' => 'estella_new'],
            ],
        ];

        $companyStats = [];

        foreach ($companies as $country => $list) {
            foreach ($list as $company) {
                $companyStats[$country][$company['name']] = $this->getCandidateStats(
                    $company['db'],
                    $startDate,
                    $endDate
                );
            }
        }

        return view('Operations-Supervisor-dashboard', [
            'now' => $now,
            'totalStaff' => $totalStaff,
            'totalEmployees' => $totalEmployees,
            'totalCustomers' => $totalCustomers,
            'totalAgreements' => $totalAgreements,
            'totalContracts' => $totalContracts,
            'totalIncidents' => $totalIncidents,
            'insideCandidates' => $insideCandidates,
            'outsideCandidates' => $outsideCandidates,
            'proformaInvoices' => $proformaInvoices,
            'taxInvoices' => $taxInvoices,
            'totalActivities' => $totalActivities,
            'totalDocuments' => $totalDocuments,
            'package1' => $package1,
            'package2' => $package2,
            'package3' => $package3,
            'package4' => $package4,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'formattedMonthlyData' => $formattedMonthlyData,
            'mainStats' => $mainStats,
            'companyStats' => $companyStats,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function hrmDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('HRM-dashboard', [
            'now' => $now,
            'totalProfiles' => 0,
            'activeProfiles' => 0,
            'expiredProfiles' => 0,
            'newProfiles' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
        ]);
    }

    public function FinanceDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $startOfMonth = Carbon::now('Asia/Dubai')->startOfMonth();
        $endOfMonth = Carbon::now('Asia/Dubai')->endOfMonth();

        $totalRVIAmount = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where(function ($query) {
                $query->where('status', 'Paid')
                      ->orWhere('status', 'Partially Paid');
            })
            ->where('invoice_number', 'like', 'RVI%')
            ->sum('received_amount');

        $totalRVOAmount = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where(function ($query) {
                $query->where('status', 'Paid')
                      ->orWhere('status', 'Partially Paid');
            })
            ->where('invoice_number', 'like', 'RVO%')
            ->sum('received_amount');

        $totalINVAmount = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where(function ($query) {
                $query->where('status', 'Paid')
                      ->orWhere('status', 'Partially Paid');
            })
            ->where('invoice_number', 'like', 'INV%')
            ->sum('received_amount');

        $pendingRVI = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Pending')
            ->where('invoice_number', 'like', 'RVI%')
            ->count();

        $pendingRVO = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Pending')
            ->where('invoice_number', 'like', 'RVO%')
            ->count();

        $pendingINV = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Pending')
            ->where('invoice_number', 'like', 'INV%')
            ->count();

        $totalRevenue = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Paid')
            ->sum('received_amount');

        return view('Finance-dashboard', [
            'now' => $now,
            'totalInvoices' => ($totalRVIAmount ?? 0) + ($totalRVOAmount ?? 0) + ($totalINVAmount ?? 0),
            'paidInvoices' => $totalRevenue ?? 0,
            'unpaidInvoices' => ($pendingRVI ?? 0) + ($pendingRVO ?? 0) + ($pendingINV ?? 0),
            'overdueInvoices' => 0,
            'outsideAllNewCandidates' => NewCandidate::where('current_status', 1)->count() ?? 0,
            'totalRevenue' => $totalRevenue ?? 0,
            'totalRVIAmount' => $totalRVIAmount ?? 0,
            'totalRVOAmount' => $totalRVOAmount ?? 0,
            'totalINVAmount' => $totalINVAmount ?? 0,
            'pendingRVI' => $pendingRVI ?? 0,
            'pendingRVO' => $pendingRVO ?? 0,
            'pendingINV' => $pendingINV ?? 0
        ]);
    }

    public function salesOfficerDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Sales-Officer-dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function marketingManagerDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Marketing-Manager-dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function digitalMarketingSpecialistDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Digital-Marketing-Specialist-dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function digitalMarketingExecutiveDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Digital-Marketing-Executive-dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function photographerDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Photographer-dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function juniorAccountantDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $startOfMonth = Carbon::now('Asia/Dubai')->startOfMonth();
        $endOfMonth = Carbon::now('Asia/Dubai')->endOfMonth();

        $totalRVIAmount = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where(function ($query) {
                $query->where('status', 'Paid')->orWhere('status', 'Partially Paid');
            })
            ->where('invoice_number', 'like', 'RVI%')
            ->sum('received_amount');

        $totalRVOAmount = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where(function ($query) {
                $query->where('status', 'Paid')->orWhere('status', 'Partially Paid');
            })
            ->where('invoice_number', 'like', 'RVO%')
            ->sum('received_amount');

        $totalINVAmount = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where(function ($query) {
                $query->where('status', 'Paid')->orWhere('status', 'Partially Paid');
            })
            ->where('invoice_number', 'like', 'INV%')
            ->sum('received_amount');

        $pendingRVI = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Pending')
            ->where('invoice_number', 'like', 'RVI%')
            ->count();

        $pendingRVO = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Pending')
            ->where('invoice_number', 'like', 'RVO%')
            ->count();

        $pendingINV = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Pending')
            ->where('invoice_number', 'like', 'INV%')
            ->count();

        $totalRevenue = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Paid')
            ->sum('received_amount');

        return view('Junior-Accountant-dashboard', [
            'now' => $now,
            'totalInvoices' => ($totalRVIAmount ?? 0) + ($totalRVOAmount ?? 0) + ($totalINVAmount ?? 0),
            'paidInvoices' => $totalRevenue ?? 0,
            'unpaidInvoices' => ($pendingRVI ?? 0) + ($pendingRVO ?? 0) + ($pendingINV ?? 0),
            'overdueInvoices' => 0,
            'outsideAllNewCandidates' => NewCandidate::where('current_status', 1)->count() ?? 0,
            'totalRevenue' => $totalRevenue ?? 0,
            'totalRVIAmount' => $totalRVIAmount ?? 0,
            'totalRVOAmount' => $totalRVOAmount ?? 0,
            'totalINVAmount' => $totalINVAmount ?? 0,
            'pendingRVI' => $pendingRVI ?? 0,
            'pendingRVO' => $pendingRVO ?? 0,
            'pendingINV' => $pendingINV ?? 0
        ]);
    }

    public function cashierDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $startOfMonth = Carbon::now('Asia/Dubai')->startOfMonth();
        $endOfMonth = Carbon::now('Asia/Dubai')->endOfMonth();

        $totalRVIAmount = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where(function ($query) {
                $query->where('status', 'Paid')->orWhere('status', 'Partially Paid');
            })
            ->where('invoice_number', 'like', 'RVI%')
            ->sum('received_amount');

        $totalRVOAmount = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where(function ($query) {
                $query->where('status', 'Paid')->orWhere('status', 'Partially Paid');
            })
            ->where('invoice_number', 'like', 'RVO%')
            ->sum('received_amount');

        $totalINVAmount = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where(function ($query) {
                $query->where('status', 'Paid')->orWhere('status', 'Partially Paid');
            })
            ->where('invoice_number', 'like', 'INV%')
            ->sum('received_amount');

        $pendingRVI = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Pending')
            ->where('invoice_number', 'like', 'RVI%')
            ->count();

        $pendingRVO = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Pending')
            ->where('invoice_number', 'like', 'RVO%')
            ->count();

        $pendingINV = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Pending')
            ->where('invoice_number', 'like', 'INV%')
            ->count();

        $totalRevenue = DB::table('invoices')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Paid')
            ->sum('received_amount');

        return view('Cashier-Dashboard', [
            'now' => $now,
            'totalInvoices' => ($totalRVIAmount ?? 0) + ($totalRVOAmount ?? 0) + ($totalINVAmount ?? 0),
            'paidInvoices' => $totalRevenue ?? 0,
            'unpaidInvoices' => ($pendingRVI ?? 0) + ($pendingRVO ?? 0) + ($pendingINV ?? 0),
            'overdueInvoices' => 0,
            'outsideAllNewCandidates' => NewCandidate::where('current_status', 1)->count() ?? 0,
            'totalRevenue' => $totalRevenue ?? 0,
            'totalRVIAmount' => $totalRVIAmount ?? 0,
            'totalRVOAmount' => $totalRVOAmount ?? 0,
            'totalINVAmount' => $totalINVAmount ?? 0,
            'pendingRVI' => $pendingRVI ?? 0,
            'pendingRVO' => $pendingRVO ?? 0,
            'pendingINV' => $pendingINV ?? 0
        ]);
    }

    public function contractAdministratorDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Contract-Administrator-dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function proDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Pro-Dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function webManagerDashboard()
    {

        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Web_Manager', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function salesCoordinatorDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Sales-Coordinator-dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function happinessConsultantDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Happiness-Consultant-dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function customerServicesDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Customer-Service-dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function archiveClerkDashboard()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('Archive-clerk-dashboard', [
            'now' => $now,
            'totalLeads' => 0,
            'convertedLeads' => 0,
            'pendingLeads' => 0,
            'lostLeads' => 0,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'monthlyTarget' => 0,
            'achievedTarget' => 0
        ]);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
