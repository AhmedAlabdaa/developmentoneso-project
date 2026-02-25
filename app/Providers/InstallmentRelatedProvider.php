<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Installment;

class InstallmentRelatedProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        View::share('installmentStats', function (string $invoiceNumber): string {
            $inst = Installment::where('invoice_number', $invoiceNumber)->first();
            if (! $inst) {
                return '0/0';
            }
            return "{$inst->paid_installments}/{$inst->number_of_installments}";
        });

        View::share('installmentForInvoice', function (string $invoiceNumber): ?Installment {
            return Installment::where('invoice_number', $invoiceNumber)->first();
        });

        View::share('installmentId', function (string $invoiceNumber): ?int {
            return Installment::where('invoice_number', $invoiceNumber)
                              ->value('id');
        });

        View::share('installmentPaid', function (string $invoiceNumber): int {
            return Installment::where('invoice_number', $invoiceNumber)
                              ->value('paid_installments') ?? 0;
        });

        View::share('installmentTotal', function (string $invoiceNumber): int {
            return Installment::where('invoice_number', $invoiceNumber)
                              ->value('number_of_installments') ?? 0;
        });
    }
}
