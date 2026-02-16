<style>
.table-container { width: 100%; overflow-x: auto; position: relative; }
    .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .table th, .table td { padding: 10px 15px; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .table th { background-color: #343a40; color: white; text-transform: uppercase; font-weight: bold; }
    .table-hover tbody tr:hover { background-color: #f1f1f1; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
    .actions { display: flex; gap: 5px; }
    .btn-icon-only { display: inline-flex; align-items: center; justify-content: center; padding: 5px; border-radius: 50%; font-size: 12px; width: 30px; height: 30px; color: white; }
    .btn-info { background-color: #17a2b8; }
    .btn-warning { background-color: #ffc107; }
    .btn-danger { background-color: #dc3545; }
    .sticky-table th:last-child,
    .sticky-table td:last-child {
        position: sticky;
        right: 0;
        background-color: white;
        z-index: 2;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        min-width: 150px;
    }

    .modal .table th:last-child,
    .modal .table td:last-child {
        position: static; /* Ensure non-sticky for modal table */
    }

    .table th:last-child { z-index: 3; }
    .status-dropdown {
        padding: 5px;
        font-size: 12px;
        border-radius: 5px;
        transition: background-color 0.3s;
        width: 120px;
        color: #000;
        font-weight: bold;
        text-transform: uppercase;
    }

    .status-dropdown.approved {
        background-color: #28a745; 
    }

    .status-dropdown.pending {
        background-color: #ffc107; 
    }

    .status-dropdown.rejected {
        background-color: #dc3545; 
    }

    .status-dropdown.review {
        background-color: #17a2b8;
    }

    .attachments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 20px;
        margin-top: 10px;
    }
    .attachment-item {
        text-align: center;
    }
    .attachment-item p {
        margin-top: 5px;
        font-size: 12px;
    }
    .img-thumbnail {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
    }

    .bg-gradient-primary {
       background: linear-gradient(to right, #007bff, #6a11cb);
    }

    .btn-sm {
        font-size: 0.8rem;
    }

    .scrollable-modal-body {
        max-height: 500px;
        overflow-y: auto;
    }
</style>

<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Ref #</th>
                <th>Agre. Ref #</th>
                <th>CL #</th>
                <th>CN #</th>
                <th>Customre Name</th>
                <th>Maid Name</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Received Amount</th>
                <th>Discount</th>
                <th>Tax</th>
                <th>Balance Due</th>
                <th>Type</th>
                <th>Payment Method</th>
                <th>Date</th>
                <th>Due Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($invoices->isEmpty())
                <tr>
                    <td colspan="10" class="text-center no-records">
                        <h5 style="margin-top: 50px; margin-bottom: 50px;">There are no records available</h5>
                    </td>
                </tr>
            @else
                @foreach ($invoices as $invoice)
                    <tr>
                       <td><a href="{{ route('invoices.show', $invoice->invoice_number) }}" class="text-primary" target="_blank">{{ $invoice->invoice_number }}</a></td>
                        <td><a href="{{ route('agreements.show', $invoice->agreement_reference_no) }}" class="text-primary" target="_blank">{{ $invoice->agreement_reference_no }}</a></td>
                        <td><a href="{{ route('crm.show', $invoice->customer->slug ?? '') }}" class="text-primary" target="_blank">{{ $invoice->CL_Number }}</a></td>
                        <td><a href="{{ route('candidates.show', $invoice->candidate->reference_no ?? '') }}" class="text-primary" target="_blank">{{ $invoice->CN_Number }}</a></td>
                        <td>
                          @php $cust = optional($invoice->customer); @endphp
                          <a href="{{ $cust->slug ? route('crm.show', $cust->slug) : '#' }}"
                             class="text-primary"
                             target="_blank">
                            {{ trim($cust->first_name . ' ' . $cust->last_name) }}
                          </a>
                        </td>
                        <td><a href="{{ route('candidates.show', $invoice->candidate->reference_no ?? '') }}">{{ optional($invoice->candidate)->candidate_name ?: optional($invoice->candidate)->name }}</a></td>
                        <td>
                            <select class="status-dropdown" data-invoice-id="{{ $invoice->invoice_id }}" onchange="confirmInvoiceStatusChangeofEmployees(this, {{ $invoice->invoice_id }}, '{{ $invoice->customer->first_name ?? '' }}', '{{ $invoice->received_amount }}', '{{ $invoice->agreement_reference_no }}' , '{{ $invoice->invoice_type }}')">
                                <option value="Pending" {{ $invoice->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Unpaid" {{ $invoice->status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="Paid" {{ $invoice->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Partially Paid" {{ $invoice->status == 'Partially Paid' ? 'selected' : '' }}>Partially Paid</option>
                                <option value="Overdue" {{ $invoice->status == 'Overdue' ? 'selected' : '' }}>Overdue</option>
                                <option value="Cancelled" {{ $invoice->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="Hold" {{ $invoice->status == 'Hold' ? 'selected' : '' }}>Hold</option>
                                <option value="COD" {{ $invoice->status == 'COD' ? 'selected' : '' }}>COD</option>
                            </select>
                        </td>
                        <td>{{ number_format($invoice->total_amount, 2) }}</td>
                        <td>{{ number_format($invoice->received_amount, 2) }}</td>
                        <td>{{ number_format($invoice->discount_amount, 2) }}</td>
                        <td>{{ number_format($invoice->tax_amount, 2) }}</td>
                        <td>{{ number_format($invoice->balance_due, 2) }}</td>
                        <td>{{ $invoice->invoice_type }}</td>
                        <td>{{ $invoice->payment_method }}</td>
                        <td>{{ $invoice->invoice_date }}</td>
                        <td>{{ $invoice->due_date }}</td>
                        <td>{{ $invoice->notes }}</td>
                        <td class="actions">
                            <button type="button" class="btn btn-success btn-icon-only" title="View Payment Proof" data-bs-toggle="modal" data-bs-target="#paymentProofModal{{ $invoice->invoice_number }}">
                                <i class="fas fa-receipt"></i>
                            </button>
                            <a href="{{ route('invoices.show', $invoice->invoice_number) }}" class="btn btn-info btn-icon-only" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if (Auth::user()->role === 'Admin')
                            <form action="{{ route('invoices.destroy', $invoice->invoice_number) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-icon-only" title="Delete" onclick="return confirm('Are you sure?');">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    <div class="modal fade" id="paymentProofModal{{ $invoice->invoice_number }}" tabindex="-1" aria-labelledby="paymentProofLabel{{ $invoice->invoice_number }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="paymentProofLabel{{ $invoice->invoice_number }}">Payment Proof</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    @if(!empty($invoice->payment_proof))
                                        @php
                                            $filePath = asset('storage/'.$invoice->payment_proof);
                                            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                        @endphp
                                        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                            <div id="lightGallery{{ $invoice->invoice_number }}" class="lightgallery">
                                                <a href="{{ $filePath }}" class="lightbox-item">
                                                    <img 
                                                        src="{{ $filePath }}" 
                                                        alt="Payment Proof" 
                                                        class="img-fluid payment-proof-image" 
                                                        style="max-width: 100%; max-height: 500px;"
                                                    >
                                                </a>
                                            </div>
                                        @elseif($fileExtension === 'pdf')
                                            <iframe 
                                                src="{{ $filePath }}" 
                                                width="100%" 
                                                height="500px" 
                                                style="border: none;">
                                            </iframe>
                                        @else
                                            <p>Unsupported file format for payment proof.</p>
                                        @endif
                                    @else
                                        <p>No payment proof available.</p>
                                    @endif
                                </div>
                                <div class="modal-footer justify-content-center">
                                    @if(!empty($invoice->payment_proof))
                                        <a href="{{ $filePath }}" download class="btn btn-primary">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @endif
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th>Ref #</th>
                <th>Agre. Ref #</th>
                <th>CL #</th>
                <th>CN #</th>
                <th>Customre Name</th>
                <th>Maid Name</th>
                <th>Status</th>
                <th>Total Amount</th>
                <th>Received Amount</th>
                <th>Discount</th>
                <th>Tax</th>
                <th>Balance Due</th>
                <th>Type</th>
                <th>Payment Method</th>
                <th>Date</th>
                <th>Due Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav aria-label="Page navigation">
    <div class="pagination-container">
        <span class="muted-text">
            Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} results
        </span>
        <ul class="pagination justify-content-center">
            {{ $invoices->links('vendor.pagination.bootstrap-4') }}
        </ul>
    </div>
</nav>
