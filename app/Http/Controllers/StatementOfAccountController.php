<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatementOfAccountResource;
use App\Models\JournalTranLine;
use App\Models\LedgerOfAccount;
use App\Enum\JournalStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * @group Statement of Account
 *
 * APIs for retrieving statement of account for a ledger.
 */
class StatementOfAccountController extends Controller
{
    /**
     * Get Statement of Account
     *
     * Retrieve the statement of account for a specific ledger. Returns all posted
     * journal transaction lines with debit, credit, running balance, notes, and source type.
     * Supports date filtering with opening balance calculation.
     *
     * @urlParam ledger_id integer required The ID of the ledger. Example: 1
     * @queryParam date_from string The start date for filtering (Y-m-d). Defaults to today. Example: 2026-01-01
     * @queryParam date_to string The end date for filtering (Y-m-d). Defaults to today. Example: 2026-01-31
     *
     * @param Request $request
     * @param int $ledgerId
     * @return StatementOfAccountResource|JsonResponse
     */
    public function show(Request $request, int $ledgerId): StatementOfAccountResource|JsonResponse
    {
        // Check if ledger exists
        $ledger = LedgerOfAccount::find($ledgerId);
        
        if (!$ledger) {
            return response()->json([
                'message' => 'Ledger not found',
            ], 404);
        }

        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Parse dates robustly if provided
        if ($dateFrom) {
            try { $dateFrom = Carbon::parse($dateFrom)->format('Y-m-d'); } catch (\Exception $e) {}
        }
        if ($dateTo) {
            try { $dateTo = Carbon::parse($dateTo)->format('Y-m-d'); } catch (\Exception $e) {}
        }

        $data = $this->getStatementData($ledgerId, $dateFrom, $dateTo);

        return new StatementOfAccountResource(array_merge(['ledger' => $ledger], $data));
    }

    /**
     * Export Statement of Account
     *
     * Export the statement of account for a specific ledger to Excel.
     *
     * @urlParam ledger_id integer required The ID of the ledger. Example: 1
     * @queryParam date_from string The start date for filtering (Y-m-d). Defaults to today. Example: 2026-01-01
     * @queryParam date_to string The end date for filtering (Y-m-d). Defaults to today. Example: 2026-01-31
     *
     * @param Request $request
     * @param int $ledgerId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, int $ledgerId)
    {
        $ledger = LedgerOfAccount::find($ledgerId);

        if (!$ledger) {
            return response()->json([
                'message' => 'Ledger not found',
            ], 404);
        }

        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Parse dates robustly if provided
        if ($dateFrom) {
            try { $dateFrom = Carbon::parse($dateFrom)->format('Y-m-d'); } catch (\Exception $e) {}
        }
        if ($dateTo) {
            try { $dateTo = Carbon::parse($dateTo)->format('Y-m-d'); } catch (\Exception $e) {}
        }

        $data = $this->getStatementData($ledgerId, $dateFrom, $dateTo);
        
        // Add ledger name to filename
        $filename = 'Statement_of_Account_' . $ledger->name . '_' . $dateFrom . '_to_' . $dateTo . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\StatementOfAccountExport($data), $filename);
    }

    private function getStatementData(int $ledgerId, ?string $dateFrom, ?string $dateTo): array
    {
        // Calculate opening balance (all transactions before date_from)
        $openingBalance = 0;
        if ($dateFrom) {
            $openingBalanceData = JournalTranLine::where('journal_tran_lines.ledger_id', $ledgerId)
                ->join('journal_headers', 'journal_tran_lines.journal_header_id', '=', 'journal_headers.id')
                ->where('journal_headers.status', JournalStatus::Posted->value)
                ->where('journal_headers.posting_date', '<', $dateFrom)
                ->selectRaw('COALESCE(SUM(journal_tran_lines.debit), 0) as total_debit, COALESCE(SUM(journal_tran_lines.credit), 0) as total_credit')
                ->first();

            $openingBalance = (float) $openingBalanceData->total_debit - (float) $openingBalanceData->total_credit;
        }

        // Get journal transaction lines
        $query = JournalTranLine::with(['header.source', 'ledger'])
            ->where('journal_tran_lines.ledger_id', $ledgerId)
            ->join('journal_headers', 'journal_tran_lines.journal_header_id', '=', 'journal_headers.id')
            ->where('journal_headers.status', JournalStatus::Posted->value);

        if ($dateFrom) {
            $query->where('journal_headers.posting_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('journal_headers.posting_date', '<=', $dateTo);
        }

        $lines = $query->orderBy('journal_headers.posting_date', 'asc')
            ->orderBy('journal_tran_lines.id', 'asc')
            ->select('journal_tran_lines.*')
            ->get();

        // Calculate running balance starting from opening balance
        $runningBalance = $openingBalance;
        $totalDebit = 0;
        $totalCredit = 0;

        $transactions = $lines->map(function ($line) use (&$runningBalance, &$totalDebit, &$totalCredit) {
            $debit = (float) $line->debit;
            $credit = (float) $line->credit;
            
            $totalDebit += $debit;
            $totalCredit += $credit;
            $runningBalance += $debit - $credit;

            $source = $line->header?->source;
            $serialNo = '-';
            if ($source) {
                $serialNo = $source->serial_no ?? $source->serial_number ?? $source->invoice_number ?? $source->voucher_no ?? '-';
            }

            return [
                'id' => $line->id,
                'posting_date' => $line->header?->posting_date?->format('Y-m-d'),
                'journal_header_id' => $line->header?->id,
                'serial_no' => $serialNo,
                'note' => $line->note,
                'debit' => $debit,
                'credit' => $credit,
                'running_balance' => $runningBalance,
                'source_type' => $line->header ? class_basename($line->header->source_type) : null,
                'source_id' => $line->header?->source_id,
            ];
        });

        return [
            'date_from' => $dateFrom ?? '-',
            'date_to' => $dateTo ?? '-',
            'opening_balance' => $openingBalance,
            'transactions' => $transactions,
            'summary' => [
                'opening_balance' => $openingBalance,
                'total_debit' => $totalDebit,
                'total_credit' => $totalCredit,
                'closing_balance' => $runningBalance,
            ],
        ];
    }
}
