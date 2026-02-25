<?php

namespace App\Exports;

use App\Models\LedgerOfAccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LedgerOfAccountExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return LedgerOfAccount::with(['createdBy', 'updatedBy'])
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($ledger) {
                return [
                    $ledger->id,
                    $ledger->name,
                    $ledger->class?->label() ?? '',
                    $ledger->sub_class?->label() ?? '',
                    $ledger->group,
                    $ledger->spacial?->label() ?? '',
                    $ledger->type,
                    $ledger->note,
                    optional($ledger->createdBy)->name,
                    optional($ledger->updatedBy)->name,
                    $ledger->created_at?->format('Y-m-d H:i:s'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Class',
            'Sub Class',
            'Group',
            'Spacial',
            'Type',
            'Note',
            'Created By',
            'Updated By',
            'Created At',
        ];
    }
}
