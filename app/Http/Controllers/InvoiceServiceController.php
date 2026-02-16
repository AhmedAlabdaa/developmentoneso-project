<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceServiceRequest;
use App\Http\Requests\UpdateInvoiceServiceRequest;
use App\Http\Resources\InvoiceServiceResource;
use App\Services\InvoiceServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\InvoiceService;

/**
 * @group Invoice Services
 *
 * APIs for managing invoice services.
 */
class InvoiceServiceController extends Controller
{
    protected InvoiceServiceService $service;

    public function __construct(InvoiceServiceService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the invoice services management page
     */
    public function viewIndex()
    {
        $now = \Carbon\Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        // Re-use logic or call service. Since we want a Blade view with data:
        // We'll fetch all or paginate. PaymentVoucher does paginate(10).
        $invoiceServices = \App\Models\InvoiceService::with(['creator', 'updater'])->orderByDesc('id')->paginate(10);
        
        return view('invoice_services.index', compact('invoiceServices', 'now'));
    }

    /**
     * List Invoice Services
     * 
     * Display a listing of the resource.
     * 
     * @queryParam per_page int Number of items per page. Example: 15
     * @queryParam sort_by string Field to sort by. Example: created_at
     * @queryParam sort_direction string Sort direction. Example: desc
     */
    public function index(Request $request)
    {
        $filters = $request->all();
        $perPage = $request->input('per_page', 15);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $result = $this->service->getPaginatedList($filters, $perPage, $sortBy, $sortDirection);

        return InvoiceServiceResource::collection($result);
    }

    /**
     * Create Invoice Service
     * 
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceServiceRequest $request)
    {
        $data = $request->validated();
        $invoiceService = $this->service->create($data);

        return new InvoiceServiceResource($invoiceService);
    }

    /**
     * Get Invoice Service
     * 
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoiceService = $this->service->getById($id);

        if (!$invoiceService) {
            return response()->json(['message' => 'Invoice Service not found'], 404);
        }

        return new InvoiceServiceResource($invoiceService);
    }

    /**
     * Update Invoice Service
     * 
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceServiceRequest $request, $id)
    {
        $data = $request->validated();
        $invoiceService = $this->service->update($id, $data);

        if (!$invoiceService) {
            return response()->json(['message' => 'Invoice Service not found'], 404);
        }

        return new InvoiceServiceResource($invoiceService);
    }

    /**
     * Delete Invoice Service
     * 
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Invoice Service not found'], 404);
        }

        return response()->json(['message' => 'Invoice Service deleted successfully']);
    }

    /**
     * Lookup Invoice Services
     *
     * Get a simplified list of invoice services for dropdowns, including nested lines.
     * Returns format: {id, text, lines: [...]}
     *
     * @queryParam search string Search by name or code. Example: Service A
     * @queryParam type int Filter by service type. Example: 1
     * @queryParam page int Page number. Example: 1
     * @queryParam per_page int Items per page (max 50). Example: 20
     *
     * @return JsonResponse
     */
    public function lookup(Request $request): JsonResponse
    {
        $search = $request->input('search', '');
        $type = $request->input('type');
        $perPage = min($request->input('per_page', 10), 50);

        $query = InvoiceService::query()
        ->where('status', 1);
        
        // Filter by type if provided
        if ($type !== null) {
            $query->where('type', (int) $type);
        }
        
        // Eager load lines
        $query->with(['lines.ledger']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $query->orderBy('name', 'asc');

        $services = $query->paginate($perPage);

        $results = $services->map(function ($service) {
            return [
                'id' => $service->id,
                'text' => $service->code . ' - ' . $service->name,
                'lines' => $service->lines, // Include full lines data
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => $services->hasMorePages(),
                'current_page' => $services->currentPage(),
                'total' => $services->total(),
            ]
        ]);
    }
}
