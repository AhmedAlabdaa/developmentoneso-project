<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Employee;

class VisaStatusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('visaStatusService', function () {
            return new self;
        });
    }

    public function boot()
    {
    }

    public static function getByVisaStatus($status)
    {
        if ($status === 'new') {
            return Employee::where(function($query) {
                $query->whereNull('visa_status')
                      ->orWhere('visa_status', 0);
            })->count();
        }
        return Employee::where('visa_status', $status)->count();
    }
}
