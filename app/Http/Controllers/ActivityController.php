<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\NewCandidate;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['msg' => 'You need to be logged in to access this page.']);
        }

        $query = Notification::query();

        if ($user->role === 'Admin') {
            $query->orderBy('id', 'desc');
            $unreadCount = Notification::where('status', 'Un Read')->count();
        } elseif ($user->role === 'Finance') {
            $query->where('role', 'finance')->orderBy('id', 'desc');
            $unreadCount = Notification::where('role', 'finance')
                ->where('status', 'Un Read')
                ->count();
        } else {
            $query->where('role', strtolower($user->role))->orderBy('id', 'desc');
            $unreadCount = Notification::where('role', strtolower($user->role))
                ->where('status', 'Un Read')
                ->count();
        }

        if ($request->has('search')) {
            $search = $request->search;
            if (empty($search)) {
                return redirect()->route('notifications.index')->withErrors(['error' => 'Search field cannot be empty.']);
            }
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $notifications = $query->paginate(10);
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        return view('activities.index', [
            'now' => $now,
            'outsideAllNewCandidates' => $outsideAllNewCandidates,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return redirect()->route('notifications.index')->withErrors(['Notification not found.']);
        }

        if ($notification->status === 'Read') {
            return redirect()->route('notifications.index')->with('success', 'Notification is already marked as read.');
        }

        $notification->status = 'Read';
        $notification->save();

        if ($notification->wasChanged('status')) {
            return redirect()->route('notifications.index')->with('success', 'Notification marked as read successfully.');
        }

        return redirect()->route('notifications.index')->withErrors(['Failed to update notification status.']);
    }

}
