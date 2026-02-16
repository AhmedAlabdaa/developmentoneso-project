<?php

namespace App\Http\Controllers;

use App\Http\Requests\BulkJournalImportRequest;
use App\Models\LedgerOfAccount;
use App\Services\JournalHeaderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * @group Bulk Journal Import
 *
 * APIs for bulk importing journal vouchers via CSV.
 */
class BulkJournalImportController extends Controller
{
    protected JournalHeaderService $journalService;

    public function __construct(JournalHeaderService $journalService)
    {
        $this->journalService = $journalService;
    }

    /**
     * Bulk Import Journal Vouchers
     *
     * Import multiple journal entries from a CSV file. Each journal entry is grouped by posting_date.
     * 
     * CSV columns:
     * - ledger_name (required): Name of the ledger account
     * - debit (required): Debit amount (use 0 if credit)
     * - credit (required): Credit amount (use 0 if debit)
     * - posting_date (required): Date in Y-m-d format
     * - candidate_id (optional): Employee/candidate ID
     * - note (optional): Transaction note
     *
     * @bodyParam file file required The CSV file to import. No-example
     *
     * @response 200 {
     *   "message": "Import completed",
     *   "created_journals": 3,
     *   "total_rows": 10,
     *   "errors": []
     * }
     *
     * @param BulkJournalImportRequest $request
     * @return JsonResponse
     */
    public function import(BulkJournalImportRequest $request): JsonResponse
    {
        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');
        
        if (!$handle) {
            return response()->json([
                'message' => 'Failed to open file',
            ], 400);
        }

        // Parse CSV header
        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return response()->json([
                'message' => 'Empty or invalid CSV file',
            ], 400);
        }

        // Normalize header (trim whitespace and lowercase)
        $header = array_map(fn($col) => strtolower(trim($col)), $header);
        
        // Validate required columns
        $requiredColumns = ['ledger_name', 'debit', 'credit', 'posting_date'];
        $missingColumns = array_diff($requiredColumns, $header);
        if (!empty($missingColumns)) {
            fclose($handle);
            return response()->json([
                'message' => 'Missing required columns: ' . implode(', ', $missingColumns),
            ], 400);
        }

        // Parse rows and group by posting_date
        $rowNumber = 1;
        $groupedRows = [];
        $errors = [];
        $totalRows = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            $totalRows++;
            
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            // Map row to associative array
            $data = array_combine($header, array_pad($row, count($header), null));
            
            // Validate row data
            $rowErrors = $this->validateRow($data, $rowNumber);
            if (!empty($rowErrors)) {
                $errors = array_merge($errors, $rowErrors);
                continue;
            }

            // Look up ledger by name
            $ledger = LedgerOfAccount::where('name', trim($data['ledger_name']))->first();
            if (!$ledger) {
                $errors[] = "Row {$rowNumber}: Ledger not found: {$data['ledger_name']}";
                continue;
            }

            $postingDate = $data['posting_date'];
            if (!isset($groupedRows[$postingDate])) {
                $groupedRows[$postingDate] = [];
            }

            // Prepare line data
            $lineData = [
                'ledger_id' => $ledger->id,
                'debit' => (float) ($data['debit'] ?? 0),
                'credit' => (float) ($data['credit'] ?? 0),
                'candidate_id' => !empty($data['candidate_id']) ? (int) $data['candidate_id'] : null,
                'note' => $data['note'] ?? null,
            ];

            $groupedRows[$postingDate][] = $lineData;
        }

        fclose($handle);

        // Create journal entries for each group
        $createdJournals = [];

        DB::beginTransaction();
        try {
            foreach ($groupedRows as $postingDate => $lines) {
                // Check if balanced
                $totalDebit = array_sum(array_column($lines, 'debit'));
                $totalCredit = array_sum(array_column($lines, 'credit'));
                
                if (round($totalDebit, 2) !== round($totalCredit, 2)) {
                    $errors[] = "Posting date {$postingDate}: Unbalanced entries (Debit: {$totalDebit}, Credit: {$totalCredit})";
                    continue;
                }

                $journalData = [
                    'posting_date' => $postingDate,
                    'status' => 0, // Unposted
                    'note' => 'Bulk import',
                    'lines' => $lines,
                ];

                $journal = $this->journalService->createJournal($journalData);
                $createdJournals[] = $journal->id;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Import failed: ' . $e->getMessage(),
                'errors' => $errors,
            ], 500);
        }

        return response()->json([
            'message' => 'Import completed',
            'created_journals' => count($createdJournals),
            'journal_ids' => $createdJournals,
            'total_rows' => $totalRows,
            'errors' => $errors,
        ]);
    }

    /**
     * Validate a single CSV row
     */
    protected function validateRow(array $data, int $rowNumber): array
    {
        $errors = [];

        if (empty($data['ledger_name'])) {
            $errors[] = "Row {$rowNumber}: ledger_name is required";
        }

        $debit = $data['debit'] ?? '';
        $credit = $data['credit'] ?? '';

        if ($debit === '' && $credit === '') {
            $errors[] = "Row {$rowNumber}: debit or credit must have a value";
        }

        if ($debit !== '' && !is_numeric($debit)) {
            $errors[] = "Row {$rowNumber}: debit must be a valid number";
        }

        if ($credit !== '' && !is_numeric($credit)) {
            $errors[] = "Row {$rowNumber}: credit must be a valid number";
        }

        if (empty($data['posting_date'])) {
            $errors[] = "Row {$rowNumber}: posting_date is required";
        } elseif (!strtotime($data['posting_date'])) {
            $errors[] = "Row {$rowNumber}: posting_date must be a valid date";
        }

        return $errors;
    }
}

