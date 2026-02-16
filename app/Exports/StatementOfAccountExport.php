<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StatementOfAccountExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection(): Collection
    {
        $rows = collect();

        // Add Opening Balance Row
        $rows->push([
            'date' => $this->data['date_from'],
            'source_type' => 'Opening Balance',
            'serial_no' => '',
            'source_id' => '',
            'description' => 'Opening Balance',
            'debit' => '',
            'credit' => '',
            'balance' => $this->data['opening_balance'],
        ]);

        // Add Transactions
        foreach ($this->data['transactions'] as $transaction) {
            $rows->push([
                'date' => $transaction['posting_date'],
                'source_type' => $transaction['source_type'],
                'serial_no' => $transaction['serial_no'],
                'source_id' => $transaction['source_id'],
                'description' => $transaction['note'],
                'debit' => $transaction['debit'],
                'credit' => $transaction['credit'],
                'balance' => $transaction['running_balance'],
            ]);
        }
        
        // Add Closing Balance Row
        $rows->push([
            'date' => $this->data['date_to'],
            'source_type' => 'Closing Balance',
            'serial_no' => '',
            'source_id' => '',
            'description' => 'Closing Balance',
            'debit' => $this->data['summary']['total_debit'],
            'credit' => $this->data['summary']['total_credit'],
            'balance' => $this->data['summary']['closing_balance'],
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Source Type',
            'Serial No',
            'Source ID',
            'Description',
            'Debit',
            'Credit',
            'Balance',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
