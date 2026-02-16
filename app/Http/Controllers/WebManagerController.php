<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\NewCandidate;
use App\Models\Employee;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class WebManagerController extends Controller
{
    public function availableCandidates()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $candidatesCount = NewCandidate::where('current_status', 1)->count();
        $employeesCount = Employee::where('inside_status', 1)->count();
        $packagesCount = Package::where('inside_status', 1)->count();

        $candidates = NewCandidate::query()
            ->select([
                'id',
                'ref_no',
                'candidate_name',
                'passport_no',
                'slug',
                'meta_title',
                'meta_keywords',
                'meta_description',
                'meta_title_ar',
                'meta_keywords_ar',
                'meta_description_ar',
            ])
            ->where('current_status', 1)
            ->latest('created_at')
            ->get();

        $nationalityStats = DB::table('nationalities as n')
            ->leftJoin('new_candidates as c', function ($join) {
                $join->on('c.nationality', '=', 'n.id')
                     ->where('c.current_status', 1);
            })
            ->groupBy('n.id', 'n.name', 'n.arabic_name')
            ->select('n.id', 'n.name', 'n.arabic_name', DB::raw('COUNT(c.id) as total'))
            ->orderByDesc('total')
            ->orderBy('n.name')
            ->get();

        return view('web_manager.available-candidates', [
            'now' => $now,
            'candidates' => $candidates,
            'candidatesCount' => $candidatesCount,
            'employeesCount' => $employeesCount,
            'packagesCount' => $packagesCount,
            'nationalityStats' => $nationalityStats,
        ]);
    }

    public function availablePackages()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $candidatesCount = NewCandidate::where('current_status', 1)->count();
        $employeesCount = Employee::where('inside_status', 1)->count();
        $packagesCount = Package::where('inside_status', 1)->count();

        $packages = Package::where('inside_status', 1)->latest()->paginate(20);

        return view('web_manager.available-packages', [
            'now' => $now,
            'packages' => $packages,
            'packagesCount' => $packagesCount,
            'candidatesCount' => $candidatesCount,
            'employeesCount' => $employeesCount,
        ]);
    }

    public function availableEmployees()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $candidatesCount = NewCandidate::where('current_status', 1)->count();
        $employeesCount = Employee::where('inside_status', 1)->count();
        $packagesCount = Package::where('inside_status', 1)->count();

        $employees = Employee::where('inside_status', 1)->latest()->paginate(20);

        return view('web_manager.available-employees', [
            'now' => $now,
            'employees' => $employees,
            'employeesCount' => $employeesCount,
            'candidatesCount' => $candidatesCount,
            'packagesCount' => $packagesCount,
        ]);
    }

    public function updateCandidateMeta(Request $request, $id)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:255', Rule::unique('new_candidates', 'slug')->ignore($id)],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'max:1000'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_keywords_ar' => ['nullable', 'string', 'max:1000'],
            'meta_description_ar' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            $candidate = NewCandidate::findOrFail($id);
            $candidate->update($data);

            return response()->json([
                'ok' => true,
                'message' => 'Candidate meta updated successfully.',
                'candidate' => [
                    'id' => $candidate->id,
                    'slug' => $candidate->slug,
                    'meta_title' => $candidate->meta_title,
                    'meta_keywords' => $candidate->meta_keywords,
                    'meta_description' => $candidate->meta_description,
                    'meta_title_ar' => $candidate->meta_title_ar,
                    'meta_keywords_ar' => $candidate->meta_keywords_ar,
                    'meta_description_ar' => $candidate->meta_description_ar,
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Update failed. Please try again.',
            ], 500);
        }
    }

    public function updatePackageMeta(Request $request, $id)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:255', Rule::unique('packages', 'slug')->ignore($id)],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'max:1000'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_keywords_ar' => ['nullable', 'string', 'max:1000'],
            'meta_description_ar' => ['nullable', 'string', 'max:1000'],
        ]);

        $pkg = Package::findOrFail($id);
        $pkg->update($data);

        return response()->json([
            'ok' => true,
            'message' => 'Package meta updated successfully.',
            'package' => [
                'id' => $pkg->id,
                'slug' => $pkg->slug,
                'meta_title' => $pkg->meta_title,
                'meta_keywords' => $pkg->meta_keywords,
                'meta_description' => $pkg->meta_description,
                'meta_title_ar' => $pkg->meta_title_ar,
                'meta_keywords_ar' => $pkg->meta_keywords_ar,
                'meta_description_ar' => $pkg->meta_description_ar,
            ],
        ]);
    }

    public function updateEmployeeMeta(Request $request, $id)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:255', Rule::unique('employees', 'slug')->ignore($id)],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'max:1000'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'meta_title_ar' => ['nullable', 'string', 'max:255'],
            'meta_keywords_ar' => ['nullable', 'string', 'max:1000'],
            'meta_description_ar' => ['nullable', 'string', 'max:1000'],
        ]);

        $emp = Employee::findOrFail($id);
        $emp->update($data);

        return response()->json([
            'ok' => true,
            'message' => 'Employee meta updated successfully.',
            'employee' => [
                'id' => $emp->id,
                'slug' => $emp->slug,
                'meta_title' => $emp->meta_title,
                'meta_keywords' => $emp->meta_keywords,
                'meta_description' => $emp->meta_description,
                'meta_title_ar' => $emp->meta_title_ar,
                'meta_keywords_ar' => $emp->meta_keywords_ar,
                'meta_description_ar' => $emp->meta_description_ar,
            ],
        ]);
    }
}
