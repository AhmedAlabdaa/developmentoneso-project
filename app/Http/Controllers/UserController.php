<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NewCandidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['msg' => 'You need to be logged in to access this page.']);
        }
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();
        return view('user.index', [
            'user' => $user,
            'now' => $now,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
        ]);
    }

    public function allUsers(Request $request)
    {

        if (!in_array(Auth::user()->role, ['Admin', 'Operations Manager'])) {
            return redirect()->route('dashboard')->withErrors(['msg' => 'You cannot access this page.']);
        }

        $query = User::query();

        if ($request->filled('query')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->input('query') . '%')
                  ->orWhere('last_name', 'like', '%' . $request->input('query') . '%')
                  ->orWhere('email', 'like', '%' . $request->input('query') . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('nationality')) {
            $query->where('nationality', $request->input('nationality'));
        }


        $users = $query->orderBy('id', 'desc')->paginate(10);


        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();


        if ($request->ajax()) {
            return view('user.user_table', compact('users'));
        }


        return view('user.all', compact('users', 'now', 'outsideAllNewCandidates'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'nationality' => 'nullable',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:5|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'nationality' => $request->input('nationality'),
                'role' => $request->input('role'),
                'status' => 'Active',
                'password' => $request->input('password'),
                'created_at' => now()->setTimezone('Asia/Dubai'),
                'updated_at' => now()->setTimezone('Asia/Dubai'),
            ]);

            return response()->json(['message' => 'User added successfully!', 'user' => $user], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['errors' => ['error' => 'A database error occurred. Please try again later.']], 500);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['error' => 'An unexpected error occurred. Please try again.']], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id . '|max:255',
            'nationality' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = User::findOrFail($id);

            $role = $request->input('role') ?? auth()->user()->role;
            $email = $request->input('email') ?? auth()->user()->email;

            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $email,
                'nationality' => $request->input('nationality'),
                'role' => $role,
                'updated_at' => now()->setTimezone('Asia/Dubai'),
            ]);

            return response()->json(['message' => 'User updated successfully!', 'user' => $user], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => ['error' => 'User not found.']], 404);
        } catch (Exception $e) {
            return response()->json(['errors' => ['error' => 'An unexpected error occurred. Please try again.']], 500);
        }
    }
    
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:5|confirmed',
        ]);
        $user = User::findOrFail($id);
        if ($request->current_password !== $user->password) {
            return response()->json(['success' => false, 'message' => 'The current password is incorrect.'], 422);
        }

        if ($request->current_password === $request->new_password) {
            return response()->json(['success' => false, 'message' => 'The new password must be different from the current password.'], 422);
        }
        $user->password = $request->new_password;
        $user->save();
        return response()->json(['success' => true, 'message' => 'Password changed successfully.']);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['msg' => 'You need to be logged in to access this page.']);
        }

        User::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function backup()
    {
        $databases = [
            [
                'name' => 'adeyonesourceerp_new',
                'user' => 'Shahzad_12345',
                'password' => 'Shahzad_12345',
                'host' => '127.0.0.1',
                'port' => 3306,
            ],
            [
                'name' => 'alkabaonesourcee_new',
                'user' => 'Shahzad_12345',
                'password' => 'Shahzad_12345',
                'host' => '127.0.0.1',
                'port' => 3306,
            ],
            [
                'name' => 'bmgonesourceerp_new',
                'user' => 'Shahzad_12345',
                'password' => 'Shahzad_12345',
                'host' => '127.0.0.1',
                'port' => 3306,
            ],
            [
                'name' => 'middleeastonesou_new',
                'user' => 'Shahzad_12345',
                'password' => 'Shahzad_12345',
                'host' => '127.0.0.1',
                'port' => 3306,
            ],
            [
                'name' => 'myonesourceerp_new',
                'user' => 'Shahzad_12345',
                'password' => 'Shahzad_12345',
                'host' => '127.0.0.1',
                'port' => 3306,
            ],
            [
                'name' => 'rozanaonesourcee_new',
                'user' => 'Shahzad_12345',
                'password' => 'Shahzad_12345',
                'host' => '127.0.0.1',
                'port' => 3306,
            ],
            [
                'name' => 'tadbeeralebdaaon_new',
                'user' => 'Shahzad_12345',
                'password' => 'Shahzad_12345',
                'host' => '127.0.0.1',
                'port' => 3306,
            ],
            [
                'name' => 'viennaonesourcee_new',
                'user' => 'Shahzad_12345',
                'password' => 'Shahzad_12345',
                'host' => '127.0.0.1',
                'port' => 3306,
            ],
        ];

        $backupDir = storage_path('app/backups'); 

        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true); 
        }

        $results = [];

        foreach ($databases as $db) {
            $backupFile = "{$backupDir}/{$db['name']}_backup.sql";
            $command = sprintf(
                'mysqldump -h%s -P%s -u%s --password="%s" %s > %s',
                $db['host'],
                $db['port'],
                $db['user'],
                $db['password'],
                $db['name'],
                $backupFile
            );

            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                $results[] = [
                    'database' => $db['name'],
                    'status' => 'success',
                    'file' => $backupFile,
                ];
            } else {
                $results[] = [
                    'database' => $db['name'],
                    'status' => 'failed',
                    'error' => implode("\n", $output),
                ];
            }
        }

        return response()->json($results);
    }

    public function loginRequest(Request $request)
    {
        $companyName = $request->input('companyName');
        $companyMappings = [
            'Middle East'            => ['url' => 'middleeast.onesourceerp.com'],
            'Vienna Manpower'        => ['url' => 'vienna.onesourceerp.com'],
            'Rozana Manpower'        => ['url' => 'rozana.onesourceerp.com'],
            'Adey Foreign Agency'    => ['url' => 'adey.onesourceerp.com'],
            'BMG Foreign Agency'     => ['url' => 'bmg.onesourceerp.com'],
            'Alkaba Foreign Agency'  => ['url' => 'alkaba.onesourceerp.com'],
            'My Foreign Agency'      => ['url' => 'my.onesourceerp.com'],
            'Rite Merit Agency'      => ['url' => 'ritemerit.onesourceerp.com'],
            'Khalid International'   => ['url' => 'khalid.onesourceerp.com'],
            'Edith Agency'           => ['url' => 'edith.onesourceerp.com'],
            'Estella Agency'         => ['url' => 'estella.onesourceerp.com'],
            'Greenway Agency'        => ['url' => 'greenway.onesourceerp.com'],
            'Al Anbar Manpower'      => ['url' => 'alanbar.onesourceerp.com'],
            'Shaikhah Manpower'      => ['url' => 'shaikhah.onesourceerp.com'],
        ];

        if (!array_key_exists($companyName, $companyMappings)) {
            return response()->json(['success' => false, 'message' => 'This company has not gone online yet.']);
        }

        $dashboardUrl = $companyMappings[$companyName]['url'];

        return response()->json([
            'success' => true,
            'redirectUrl' => 'https://' . $dashboardUrl
        ]);
    }

}
