<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $totalNotifications = 0;
            $latestNotifications = collect();

            if ($user) {
                if ($user->role === 'Admin') {
                    $totalNotifications = Notification::where('status', 'Un Read')->count();
                    $latestNotifications = Notification::select('id', 'title', 'message', 'created_at')
                        ->where('status', 'Un Read')
                        ->whereIn('id', function ($query) {
                            $query->selectRaw('MAX(id)')
                                ->from('notifications')
                                ->groupBy('title');
                        })
                        ->orderBy('id', 'desc')
                        ->take(4)
                        ->get();
                } elseif ($user->role === 'Finance') {
                    $totalNotifications = Notification::where('role', 'finance')
                        ->where('status', 'Un Read')
                        ->count();

                    $latestNotifications = Notification::where('role', 'finance')
                        ->where('status', 'Un Read')
                        ->orderBy('id', 'desc')
                        ->take(4)
                        ->get();
                } else {
                    $role = strtolower($user->role);
                    $totalNotifications = Notification::where('role', $role)
                        ->where('status', 'Un Read')
                        ->count();

                    $latestNotifications = Notification::where('role', $role)
                        ->where('status', 'Un Read')
                        ->orderBy('id', 'desc')
                        ->take(4)
                        ->get();
                }
            }

            $view->with([
                'totalNotifications' => $totalNotifications,
                'latestNotifications' => $latestNotifications,
            ]);
        });
    }

}
