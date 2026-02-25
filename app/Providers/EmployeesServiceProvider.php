<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Employee;

class EmployeesServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registering as singleton is optional if you want to use it statically.
    }

    public function boot()
    {
        //
    }

    public static function getByPackages($package)
    {
        if ($package === 'all') {
            return Employee::count();
        }
        
        return Employee::where('package', $package)->count();
    }
}
