<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query();
        if ($request->filled('reference_no')) {
            $query->where('reference_no', 'like', '%' . $request->input('reference_no') . '%');
        }
        if ($request->filled('name_of_staff')) {
            $query->where('name_of_staff', 'like', '%' . $request->input('name_of_staff') . '%');
        }
        if ($request->filled('nationality')) {
            $query->where('nationality', $request->input('nationality'));
        }
        if ($request->filled('passport_no')) {
            $query->where('passport_no', 'like', '%' . $request->input('passport_no') . '%');
        }
        if ($request->filled('passport_expiry_date')) {
            $query->whereDate('passport_expiry_date', $request->input('passport_expiry_date'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        } else {
            $query->whereIn('status', ['AVAILABLE', 'HOLD', 'SELECTED', 'WC-DATE', 'VISA DATE']);
        }
        if ($request->filled('date_of_joining')) {
            $query->whereDate('date_of_joining', $request->input('date_of_joining'));
        }
        if ($request->filled('actual_designation')) {
            $query->where('actual_designation', 'like', '%' . $request->input('actual_designation') . '%');
        }
        if ($request->filled('emirates_id_number')) {
            $query->where('emirates_id_number', 'like', '%' . $request->input('emirates_id_number') . '%');
        }
        $staff = $query->paginate(10);
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        if ($request->ajax()) {
            return view('staff.partials.staff_table', compact('staff'));
        }
        return view('staff.index', [
            'staff' => $staff,
            'now' => $now,
        ]);
    }

    public function create()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('staff.create', [
            'now' => $now,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_of_staff' => 'required|string',
            'nationality' => 'required|string',
            'passport_no' => 'required|string|unique:staff,passport_no',
            'passport_expiry_date' => 'required|date',
            'status' => 'nullable|string',
            'slug' => 'nullable|string|unique:staff,slug',
            'date_of_joining' => 'nullable|date',
            'actual_designation' => 'nullable|string',
            'visa_designation' => 'nullable|string',
            'gender' => 'nullable|string|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'marital_status' => 'nullable|string|in:married,unmarried,other',
            'employment_contract_start_date' => 'nullable|date',
            'employment_contract_end_date' => 'nullable|date',
            'contract_type' => 'nullable|string',
            'file_entry_permit_no' => 'nullable|string',
            'uid_no' => 'nullable|string',
            'contact_no' => 'nullable|string',
            'temp_work_permit_no' => 'nullable|string',
            'temp_work_permit_expiry_date' => 'nullable|date',
            'personal_no' => 'nullable|string',
            'labor_card_no' => 'nullable|string|unique:staff,labor_card_no',
            'labor_card_expiry_date' => 'nullable|date',
            'residence_visa_start_date' => 'nullable|date',
            'residence_visa_expiry_date' => 'nullable|date',
            'emirates_id_number' => 'nullable|string|unique:staff,emirates_id_number',
            'eid_expiry_date' => 'nullable|date',
            'salary_as_per_contract' => 'nullable|numeric',
            'basic' => 'nullable|numeric',
            'housing' => 'nullable|numeric',
            'transport' => 'nullable|numeric',
            'other_allowances' => 'nullable|numeric',
            'total_salary' => 'nullable|numeric',
            'pc' => 'nullable|boolean',
            'laptop' => 'nullable|boolean',
            'mobile' => 'nullable|boolean',
            'company_sim' => 'nullable|boolean',
            'printer' => 'nullable|boolean',
            'wps_cash' => 'nullable|string|in:WPS,CASH',
            'bank_name' => 'nullable|string',
            'iban' => 'nullable|string|unique:staff,iban',
            'comments' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);
        $lastStaff = Staff::orderBy('id', 'desc')->first();
        $validatedData['reference_no'] = $lastStaff ? $lastStaff->reference_no + 1 : 1001;
        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['name_of_staff']);
        }
        $existingSlugCount = Staff::where('slug', $validatedData['slug'])->count();
        if ($existingSlugCount > 0) {
            $validatedData['slug'] .= '-' . ($existingSlugCount + 1);
        }
        $dateFields = [
            'passport_expiry_date',
            'date_of_joining',
            'date_of_birth',
            'employment_contract_start_date',
            'employment_contract_end_date',
            'temp_work_permit_expiry_date',
            'labor_card_expiry_date',
            'residence_visa_start_date',
            'residence_visa_expiry_date',
            'eid_expiry_date'
        ];
        foreach ($dateFields as $field) {
            if (!empty($validatedData[$field])) {
                $validatedData[$field] = Carbon::parse($validatedData[$field])->format('Y-m-d');
            }
        }
        Staff::create($validatedData);
        return redirect()->route('staff.index')->with('success', 'Staff record created successfully.');
    }

    public function show($slug)
    {
        try {
            $staff = Staff::where('slug', $slug)->firstOrFail();
            $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
            return view('staff.show', compact('staff', 'now'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('staff.index')->with('error', 'Staff not found.');
        }
    }

    public function edit($slug)
    {
        try {
            $staff = Staff::where('slug', $slug)->firstOrFail();
            $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
            return view('staff.edit', compact('staff', 'now'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('staff.index')->with('error', 'Staff not found.');
        }
    }

    public function update(Request $request, $slug)
    {
        try {
            $staff = Staff::where('slug', $slug)->firstOrFail();
            $validatedData = $request->validate([
                'name_of_staff' => 'required|string',
                'nationality' => 'required|string',
                'passport_no' => 'required|string|unique:staff,passport_no,' . $staff->id,
                'passport_expiry_date' => 'required|date',
                'status' => 'nullable|string',
                'slug' => 'nullable|string|unique:staff,slug,' . $staff->id,
                'date_of_joining' => 'nullable|date',
                'actual_designation' => 'nullable|string',
                'visa_designation' => 'nullable|string',
                'gender' => 'nullable|string|in:Male,Female',
                'date_of_birth' => 'nullable|date',
                'marital_status' => 'nullable|string|in:married,unmarried,other',
                'employment_contract_start_date' => 'nullable|date',
                'employment_contract_end_date' => 'nullable|date',
                'contract_type' => 'nullable|string',
                'file_entry_permit_no' => 'nullable|string',
                'uid_no' => 'nullable|string',
                'contact_no' => 'nullable|string',
                'temp_work_permit_no' => 'nullable|string',
                'temp_work_permit_expiry_date' => 'nullable|date',
                'personal_no' => 'nullable|string',
                'labor_card_no' => 'nullable|string|unique:staff,labor_card_no,' . $staff->id,
                'labor_card_expiry_date' => 'nullable|date',
                'residence_visa_start_date' => 'nullable|date',
                'residence_visa_expiry_date' => 'nullable|date',
                'emirates_id_number' => 'nullable|string|unique:staff,emirates_id_number,' . $staff->id,
                'eid_expiry_date' => 'nullable|date',
                'salary_as_per_contract' => 'nullable|numeric',
                'basic' => 'nullable|numeric',
                'housing' => 'nullable|numeric',
                'transport' => 'nullable|numeric',
                'other_allowances' => 'nullable|numeric',
                'total_salary' => 'nullable|numeric',
                'pc' => 'nullable|boolean',
                'laptop' => 'nullable|boolean',
                'mobile' => 'nullable|boolean',
                'company_sim' => 'nullable|boolean',
                'printer' => 'nullable|boolean',
                'wps_cash' => 'nullable|string|in:WPS,CASH',
                'bank_name' => 'nullable|string',
                'iban' => 'nullable|string|unique:staff,iban,' . $staff->id,
                'comments' => 'nullable|string',
                'remarks' => 'nullable|string',
            ]);
            $dateFields = [
                'passport_expiry_date',
                'date_of_joining',
                'date_of_birth',
                'employment_contract_start_date',
                'employment_contract_end_date',
                'temp_work_permit_expiry_date',
                'labor_card_expiry_date',
                'residence_visa_start_date',
                'residence_visa_expiry_date',
                'eid_expiry_date'
            ];
            foreach ($dateFields as $field) {
                if (!empty($validatedData[$field])) {
                    $validatedData[$field] = Carbon::parse($validatedData[$field])->format('Y-m-d');
                }
            }
            $staff->update($validatedData);
            return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('staff.index')->with('error', 'Staff not found.');
        }
    }

    public function destroy($slug)
    {
        try {
            $staff = Staff::where('slug', $slug)->firstOrFail();
            $staff->delete();
            return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('staff.index')->with('error', 'Staff not found.');
        }
    }

    public function showUploadForm()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('staff.upload_staff_csv_file', [
            'now' => $now,
        ]);
    }

    public function processCsvUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
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
                'slug' => 'required|unique:staff,slug',
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
            $responseMessage .= "<br>Some records were not uploaded due to validation errors.";
        }
        return response()->json([
            'success' => true,
            'message' => $responseMessage,
            'uploadedRecords' => $uploadedRecords,
            'totalRecords' => $totalRecords,
            'errors' => $errors,
        ]);
    }
}
