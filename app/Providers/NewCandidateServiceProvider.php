<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\NewCandidate;
use Carbon\Carbon;

class NewCandidateServiceProvider extends ServiceProvider
{
    public static function getAllCount($user = null)
    {
        $user = $user ?: Auth::user();
        $query = NewCandidate::where('status', 1);

        $adminRoles = [
            'Admin',
            'Managing Director',
            'Marketing Manager',
            'Digital Marketing Specialist',
            'Digital Marketing Executive',
            'Photographer',
            'Operations Manager',
            'Sales Manager',
            'Operations Supervisor',
            'Contract Administrator',
            'Finance Officer',
            'Archive Clerk',
        ];

        if (!in_array($user->role, $adminRoles)) {
            match ($user->role) {
                'Sales Officer', 'Customer Services' =>
                    $query->where(function ($q) use ($user) {
                        $q->where('current_status', 1)
                          ->orWhere(function ($q2) use ($user) {
                              $q2->where('sales_name', $user->id)
                                 ->where('current_status', '!=', 1);
                          });
                    }),
                'Sales Coordinator' =>
                    $query->whereRaw('CAST(nationality AS SIGNED) = ?', [$user->nationality]),
                'Happiness Consultant' =>
                    $query->whereIn('current_status', range(4, 12)),
                default =>
                    $query->whereRaw('1 = 0')
            };
        }

        return $query->count();
    }

    public static function getCandidatesCountByStatus($statusName, $user = null)
    {
        $user = $user ?: Auth::user();
        $query = NewCandidate::where('status', 1);

        $adminRoles = [
            'Admin',
            'Managing Director',
            'Marketing Manager',
            'Digital Marketing Specialist',
            'Digital Marketing Executive',
            'Photographer',
            'Operations Manager',
            'Sales Manager',
            'Operations Supervisor',
            'Contract Administrator',
            'Finance Officer',
            'Archive Clerk',
        ];

        if (!in_array($user->role, $adminRoles)) {
            match ($user->role) {
                'Sales Officer', 'Customer Services' =>
                    $query->where(function ($q) use ($user) {
                        $q->where('current_status', 1)
                          ->orWhere(function ($q2) use ($user) {
                              $q2->where('sales_name', $user->id)
                                 ->where('current_status', '!=', 1);
                          });
                    }),
                'Sales Coordinator' =>
                    $query->whereRaw('CAST(nationality AS SIGNED) = ?', [$user->nationality]),
                'Happiness Consultant' =>
                    $query->whereIn('current_status', range(4, 12)),
                default =>
                    $query->whereRaw('1 = 0')
            };
        }

        switch ($statusName) {
            case 'Available':
                $query->where('current_status', 1);
                break;
            case 'Back Out':
                $query->where('current_status', 2);
                break;
            case 'Hold':
                $query->where('current_status', 3);
                break;
            case 'Selected':
                $query->where('current_status', 4);
                break;
            case 'WC-Date':
                $query->where('current_status', 5);
                break;
            case 'Incident Before Visa (IBV)':
                $query->where('current_status', 6);
                break;
            case 'Visa Date':
                $query->where('current_status', 7);
                break;
            case 'Incident After Visa (IAV)':
                $query->where('current_status', 8);
                break;
            case 'Medical Status':
                $query->whereNotNull('medical_date');
                break;
            case 'COC-Status':
                $query->whereNotNull('coc_status');
                break;
            case 'MoL Submitted Date':
                $query->whereNotNull('l_submitted_date');
                break;
            case 'MoL Issued Date':
                $query->whereNotNull('l_issued_date');
                break;
            case 'Departure Date':
                $query->where('current_status', 13);
                break;
            case 'Incident After Departure (IAD)':
                $query->where('current_status', 14);
                break;
            case 'Arrived Date':
                $query->where('current_status', 15);
                break;
            case 'Incident After Arrival (IAA)':
                $query->where('current_status', 16);
                break;
            case 'Transfer Date':
                $query->where('current_status', 17);
                break;
            default:
                $query->whereRaw('1 = 0');
        }

        return $query->count();
    }
}
