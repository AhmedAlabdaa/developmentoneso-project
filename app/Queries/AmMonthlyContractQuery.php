<?php

namespace App\Queries;

use App\Enum\EnumMaidStatus;
use App\Models\AmPrimaryContract;
use App\Models\AmContractMovment;
use App\Models\AmInstallment;
use App\Models\Employee;
use App\Models\CRM;

class AmMonthlyContractQuery
{
    /**
     * Get contract movements with filters and pagination.
     *
     * @deprecated Use AmContractMovementQuery directly.
     */
    public function getContractMovements(array $filters = [], int $perPage = 15)
    {
        return app(AmContractMovementQuery::class)->getContractMovements($filters, $perPage);
    }

    /**
     * Get all contracts with filters and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllContracts(array $filters = [], $perPage = 15)
    {
        $query = AmPrimaryContract::with(['contractMovments.installments', 'contractMovments.employee', 'crm']);

        if (!empty($filters['customer_name'])) {
            $query->whereHas('crm', function ($q) use ($filters) {
                $q->where('first_name', 'like', "%{$filters['customer_name']}%")
                  ->orWhere('last_name', 'like', "%{$filters['customer_name']}%");
            });
        }

        if (!empty($filters['crm_id'])) {
            $query->where('crm_id', $filters['crm_id']);
        }

        if (!empty($filters['employee_name'])) {
            $query->whereHas('contractMovments.employee', function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['employee_name']}%");
            });
        }

        if (!empty($filters['employee_id'])) {
            $query->whereHas('contractMovments', function ($q) use ($filters) {
                $q->where('employee_id', $filters['employee_id']);
            });
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('id','desc')->paginate($perPage);
    }


    /**
     * Get a specific contract by ID.
     *
     * @param int $id
     * @return AmPrimaryContract
     */
    public function getContractById($id)
    {
        return AmPrimaryContract::with([
          'contractMovments.employee',
          'crm', 
          'contractMovments.returnInfo',
          'contractMovments.createdBy', 
          'contractMovments.updatedBy', 
          'contractMovments.invoice'])
         ->findOrFail($id);
    }

    /**
     * Get installments with filters and pagination.
     *
     * @deprecated Use AmInstallmentQuery directly.
     */
    public function getInstallments(array $filters = [], int $perPage = 15)
    {
        return app(AmInstallmentQuery::class)->getInstallments($filters, $perPage);
    }

    /**
     * Lookup employees (maids) by name.
     *
     * Returns id and name for autocomplete/search use.
     *
     * @param string|null $search
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function lookupEmployees(?string $search = null, int $limit = 20)
    {
        $query = Employee::select('id', 'name')
                          ->where('inside_status', 1);

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
            ;
        }

        return $query->orderBy('name')->limit($limit)->get();
    }

    /**
     * Lookup employees (maids) by name.
     *
     * Returns id and name for autocomplete/search use.
     *
     * @param string|null $search
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function lookupAllEmployees(?string $search = null, int $limit = 20)
    {
        $query = Employee::select('id', 'name')
                          ;

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
            ;
        }

        return $query->orderBy('name')->limit($limit)->get();
    }



    

    /**
     * Get all employees with optional filters and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getallEmployees(array $filters = [], int $perPage = 15)
    {
        $query = Employee::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', "%{$filters['name']}%");
        }

        if (!empty($filters['nationality'])) {
            $query->where('nationality', 'like', "%{$filters['nationality']}%");
        }

        if (!empty($filters['payment_type'])) {
            $query->where('payment_type', 'like', "%{$filters['payment_type']}%");
        }

        if (!empty($filters['passport_no'])) {
            $query->where('passport_no', 'like', "%{$filters['passport_no']}%");
        }

        if (!empty($filters['emirates_id'])) {
            $query->where('emirates_id', 'like', "%{$filters['emirates_id']}%");
        }

        if (!empty($filters['reference_no'])) {
            $query->where('reference_no', 'like', "%{$filters['reference_no']}%");
        }

        if (isset($filters['inside_status']) && $filters['inside_status'] !== '') {
            $allowed = array_map(
                static fn (EnumMaidStatus $status) => $status->value,
                EnumMaidStatus::cases()
            );

            if (in_array((int) $filters['inside_status'], $allowed, true)) {
                $query->where('inside_status', (int) $filters['inside_status']);
            }
        }


        return $query
        ->where('package' , 'PKG-3')
        ->orderBy('id', 'desc')
        ->paginate($perPage);
    }

    /**
     * Lookup customers (CRM) by name, mobile, or CL number.
     *
     * Returns CRM id and display name for autocomplete/search use.
     * The id returned is the CRM id, NOT the ledger id.
     *
     * @param string|null $search
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function lookupCustomers(?string $search = null, int $perPage = 10)
    {
        $query = CRM::query()
            ->select(
                'crm.id',
                'crm.first_name',
                'crm.last_name',
                'crm.mobile',
                'crm.CL_Number',
                'crm.ledger_id',
                'ledger_of_accounts.name as ledger_name'
            )
            ->leftJoin('ledger_of_accounts', 'crm.ledger_id', '=', 'ledger_of_accounts.id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('crm.first_name', 'like', "%{$search}%")
                  ->orWhere('crm.last_name', 'like', "%{$search}%")
                  ->orWhere('crm.mobile', 'like', "%{$search}%")
                  ->orWhere('crm.CL_Number', 'like', "%{$search}%")
                  ->orWhere('ledger_of_accounts.name', 'like', "%{$search}%");
            });
        }

        $query->orderBy('crm.first_name', 'asc');

        return $query->paginate($perPage);
    }
}
