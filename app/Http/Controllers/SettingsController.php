<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use App\Models\NewCandidate;
use Carbon\Carbon;


class SettingsController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['You must be logged in to access the dashboard.']);
        }
        $settings = Setting::first();
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();
        return view('settings.index', [
            'settings' => $settings,
            'now' => $now,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
        ]);
    }

    public function updateCompany(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['You must be logged in to access the dashboard.']);
        }
        $this->validateSettings($request, 'company');
        $settingsData = $request->except('_token', 'settings_type');
        Setting::updateOrCreate(
            ['id' => 1],
            $settingsData
        );

        return redirect()->route('settings.index')->with('success', 'Company settings updated successfully.');
    }

    public function updateUserManagement(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['You must be logged in to access the dashboard.']);
        }
        $this->validateSettings($request, 'user_management');
        $settingsData = $request->except('_token', 'settings_type');
        Setting::updateOrCreate(
            ['id' => 1],
            $settingsData
        );

        return redirect()->route('settings.index')->with('success', 'User management settings updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['You must be logged in to access the dashboard.']);
        }
        $this->validateSettings($request, 'notifications');
        $settingsData = $request->except('_token', 'settings_type');
        Setting::updateOrCreate(
            ['id' => 1],
            $settingsData
        );

        return redirect()->route('settings.index')->with('success', 'Notification settings updated successfully.');
    }

    public function updateSystem(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['You must be logged in to access the dashboard.']);
        }
        $this->validateSettings($request, 'system');
        $settingsData = $request->except('_token', 'settings_type');
        Setting::updateOrCreate(
            ['id' => 1],
            $settingsData
        );

        return redirect()->route('settings.index')->with('success', 'System settings updated successfully.');
    }

    private function validateSettings(Request $request, $type)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['You must be logged in to access the dashboard.']);
        }
        switch ($type) {
            case 'company':
                $request->validate([
                    'company_name' => 'required|string|max:255',
                    'company_email' => 'required|email|max:255',
                    'company_phone' => 'nullable|string|max:20',
                    'company_address' => 'nullable|string',
                ]);
                break;

            case 'user_management':
                $request->validate([
                    'default_role' => 'required|string',
                    'user_approval' => 'nullable|boolean',
                ]);
                break;

            case 'notifications':
                $request->validate([
                    'email_notifications' => 'nullable|boolean',
                    'push_notifications' => 'nullable|boolean',
                ]);
                break;

            case 'system':
                $request->validate([
                    'timezone' => 'required|string',
                    'date_format' => 'required|string',
                    'language' => 'required|string',
                ]);
                break;

            default:
                abort(400, 'Invalid settings type.');
        }
    }
}
