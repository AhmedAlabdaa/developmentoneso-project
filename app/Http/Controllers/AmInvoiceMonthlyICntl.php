<?php

namespace App\Http\Controllers;

use App\Queries\AmMonthlyInvoiceQuery;
use App\Services\AmMonthlyInvoiceService;
use Illuminate\Http\Request;
use Exception;

/**
 * @group Package 3 Modular
 * @subgroup Invoices For p3
 *
 *  invoices for p3.
 */
class AmInvoiceMonthlyICntl extends Controller
{
    protected AmMonthlyInvoiceService $service;
    protected AmMonthlyInvoiceQuery $query;

    public function __construct(AmMonthlyInvoiceService $service, AmMonthlyInvoiceQuery $query)
    {
        $this->service = $service;
        $this->query = $query;
    }

    /**
     * List all monthly invoices.
     *
     * Returns a paginated list of monthly contract invoices with optional filtering.
     *
     * @queryParam per_page integer Number of items per page. Default: 15. Example: 20
     * @queryParam sort_by string Sort field (id, date, serial_no, amount, paid_amount, created_at). Default: created_at. Example: date
     * @queryParam sort_direction string Sort direction (asc, desc). Default: desc. Example: asc
     * @queryParam crm_id integer Filter by customer ID. Example: 1
     * @queryParam am_monthly_contract_id integer Filter by contract movement ID. Example: 5
     * @queryParam date_from string Filter invoices from this date. Example: 2026-01-01
     * @queryParam date_to string Filter invoices until this date. Example: 2026-12-31
     * @queryParam search string Search by serial number or note. Example: p3-INV
     *
     * @response 200 {
     *   "current_page": 1,
     *   "data": [],
     *   "last_page": 1,
     *   "per_page": 15,
     *   "total": 0
     * }
     */
    public function index(Request $request)
    {
        $invoices = $this->query
            ->withRelations()
            ->applyFilters($request->only([
                'crm_id',
                'am_monthly_contract_id',
                'date_from',
                'date_to',
                'search',
            ]))
            ->sortBy(
                $request->input('sort_by', 'created_at'),
                $request->input('sort_direction', 'desc')
            )
            ->paginate($request->input('per_page', 15));

        return response()->json($invoices);
    }

    /**
     * Store a newly created monthly invoice.
     *
     * This method handles:
     * 1. Validation of the installment.
     * 2. Calculation of amounts:
     *    - VAT (assumed 5% inclusive): Total - (Total / 1.05)
     *    - Salary Cost: Full monthly salary of the maid
     *    - Profit: Total - VAT - Salary Cost
     * 3. Ledger Resolution using `LedgerOfAccount` for:
     *    - Customer (Debit)
     *    - VAT Output (Credit)
     *    - Maid Salary (Credit)
     *    - P3 Profit (Credit)
     * 4. Creation of `AmMonthlyContractInv` record.
     * 5. Update of `AmInstallment` status to 1 (Invoiced).
     * 6. Generation of Journal Entry via `JournalHeaderService` (Status: Draft).
     *
     * @bodyParam installment_id integer required The ID of the installment to invoice. Example: 1
     *
     * @response 201 {
     *   "message": "Invoice created successfully",
     *   "data": {}
     * }
     * @response 400 {
     *   "message": "Installment already invoiced"
     * }
     */
    public function store(Request $request)
    {
        $request->validate([
            'installment_id' => 'required|exists:am_installments,id',
        ]);

        try {
            $invoice = $this->service->createInvoice($request->only([
                'installment_id',
            ]));

            return response()->json([
                'message' => 'Invoice created successfully',
                'data' => $invoice,
            ], 201);
        } catch (Exception $e) {
            $code = $e->getMessage() === 'Installment already invoiced' ? 400 : 500;
            return response()->json([
                'message' => $e->getMessage(),
            ], $code);
        }
    }

    /**
     * Display a specific monthly invoice.
     *
     * Returns a single monthly contract invoice with all related data.
     *
     * @urlParam id integer required The invoice ID. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "serial_no": "p3-INV-000001",
     *   "date": "2026-01-15",
     *   "amount": 3150,
     *   "paid_amount": 0,
     *   "note": "January installment",
     *   "contract_movment": {},
     *   "crm": {},
     *   "installment": {},
     *   "journal": {}
     * }
     * @response 404 {
     *   "message": "Invoice not found"
     * }
     */
    public function show(string $id)
    {
        try {
            $invoice = $this->query->findById($id);
            return response()->json($invoice);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Invoice not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update a monthly invoice.
     *
     * Updates the editable fields of a monthly contract invoice.
     *
     * @urlParam id integer required The invoice ID. Example: 1
     * @bodyParam date string The invoice date. Example: 2026-02-01
     * @bodyParam note string A note for the invoice. Example: Updated note
     * @bodyParam amount number The invoice amount. Example: 3500
     * @bodyParam paid_amount number The paid amount. Example: 1000
     *
     * @response 200 {
     *   "message": "Invoice updated successfully",
     *   "data": {}
     * }
     * @response 404 {
     *   "message": "Invoice not found"
     * }
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'sometimes|date',
            'note' => 'sometimes|nullable|string',
            'amount' => 'sometimes|numeric|min:0',
            'paid_amount' => 'sometimes|numeric|min:0',
        ]);

        try {
            $invoice = $this->query->findById($id);
            $updated = $this->service->updateInvoice($invoice, $request->only([
                'date', 'note', 'amount', 'paid_amount',
            ]));

            return response()->json([
                'message' => 'Invoice updated successfully',
                'data' => $updated,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update invoice',
                'error' => $e->getMessage(),
            ], $e->getCode() === 404 ? 404 : 500);
        }
    }

    /**
     * Delete a monthly invoice.
     *
     * Deletes the invoice, reverts the installment status to pending,
     * and removes the associated journal entry.
     *
     * @urlParam id integer required The invoice ID. Example: 1
     *
     * @response 200 {
     *   "message": "Invoice deleted successfully"
     * }
     * @response 404 {
     *   "message": "Invoice not found"
     * }
     */
    public function destroy(string $id)
    {
        try {
            $invoice = $this->query->findById($id);
            $this->service->deleteInvoice($invoice);

            return response()->json([
                'message' => 'Invoice deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete invoice',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Receive payment for a monthly invoice.
     *
     * Creates a receipt voucher linked to the invoice with a journal entry
     * and updates the invoice's paid_amount.
     *
     * @urlParam id integer required The invoice ID. Example: 1
     * @bodyParam amount number required The payment amount. Example: 1500
     * @bodyParam debit_ledger_id integer required The cash/bank ledger ID to debit. Example: 10
     * @bodyParam payment_mode integer Payment mode (1 = Cash, 2 = Bank). Default: 1. Example: 1
     *
     * @response 200 {
     *   "message": "Payment received successfully",
     *   "data": {}
     * }
     * @response 400 {
     *   "message": "Payment amount (5000) exceeds remaining balance (3000)"
     * }
     */
    public function receivePayment(Request $request, string $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'debit_ledger_id' => 'required|exists:ledger_of_accounts,id',
            'payment_mode' => 'nullable|integer|in:1,2',
        ]);

        try {
            $invoice = $this->query->findById($id);
            $result = $this->service->receivePayment($invoice, $request->only([
                'amount', 'debit_ledger_id', 'payment_mode',
            ]));

            return response()->json([
                'message' => 'Payment received successfully',
                'data' => $result,
            ]);
        } catch (Exception $e) {
            $code = str_contains($e->getMessage(), 'exceeds') || str_contains($e->getMessage(), 'greater than') ? 400 : 500;
            return response()->json([
                'message' => $e->getMessage(),
            ], $code);
        }
    }

    /**
     * Issue a credit note for a monthly invoice.
     *
     * Full credit: reverses the entire invoice journal (swap debit/credit),
     * reverts installment status, and zeros out the invoice.
     *
     * Partial credit: recalculates proportionally by days, reverses the difference,
     * and updates the invoice amount to the new prorated total.
     *
     * @urlParam id integer required The invoice ID. Example: 1
     * @bodyParam credit_type string required The credit type: full or partial. Example: full
     * @bodyParam days integer Number of days to retain (required when credit_type is partial, 1-29). Example: 15
     *
     * @response 200 {
     *   "message": "Credit note issued successfully",
     *   "data": {}
     * }
     * @response 400 {
     *   "message": "Invoice has no journal entry to reverse"
     * }
     */
    public function creditNote(Request $request, string $id)
    {
        $request->validate([
            'credit_type' => 'required|in:full,partial',
            'days' => ['nullable', 'required_if:credit_type,partial', 'integer', 'min:1', 'max:29'],
        ]);

        try {
            $invoice = $this->query->findById($id);
            $result = $this->service->creditNote($invoice, $request->only([
                'credit_type', 'days',
            ]));

            return response()->json([
                'message' => 'Credit note issued successfully',
                'data' => $result,
            ]);
        } catch (Exception $e) {
            $code = str_contains($e->getMessage(), 'no journal') ? 400 : 500;
            return response()->json([
                'message' => $e->getMessage(),
            ], $code);
        }
    }
}
