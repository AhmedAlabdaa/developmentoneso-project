<style>
    .table-container { width: 100%; overflow-x: auto; position: relative; }
    .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
    .table th, .table td { padding: 10px 15px; text-align: left; vertical-align: middle; border-bottom: 1px solid #ddd; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .table th { background-color: #343a40; color: white; text-transform: uppercase; font-weight: bold; }
    .table-hover tbody tr:hover { background-color: #f1f1f1; }
    .table-striped tbody tr:nth-of-type(odd) { background-color: #f9f9f9; }
    .btn-icon-only { display: inline-flex; align-items: center; justify-content: center; padding: 5px; border-radius: 50%; font-size: 12px; width: 30px; height: 30px; color: white; }
    .btn-info { background-color: #17a2b8; }
    .btn-warning { background-color: #ffc107; }
    .btn-danger { background-color: #dc3545; }
    .attachments-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px; margin-top: 10px; }
    .attachment-item { text-align: center; }
    .attachment-item p { margin-top: 5px; font-size: 12px; }
    .img-thumbnail { max-width: 100px; max-height: 100px; object-fit: cover; }
    .bg-gradient-primary { background: linear-gradient(to right, #007bff, #6a11cb); }
    .btn-sm { font-size: 0.8rem; }
    .table-warning { background-color: #fff3cd !important; }
    .appeal-blink { animation: blink-animation 1.5s infinite; font-weight: bold; color: #000; }
    @keyframes blink-animation { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }
    .pagination-controls { display: flex; justify-content: center; margin-bottom: 10px; align-items: center; gap: 20px; }
    .pagination-controls i { font-size: 12px; cursor: pointer; color: #343a40; }
    .pagination-controls i.disabled { color: #ccc; cursor: not-allowed; }
    .fullscreen-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1049; }
    .dropdown-container { display: none; position: fixed; z-index: 1050; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2); min-width: 350px; max-width: 450px; text-align: center; left: 50%; top: 50%; transform: translate(-50%, -50%); border: 4px solid #007bff; animation: fadeIn 0.3s ease-in-out; }
    .dropdown-header { margin-bottom: 10px; }
    .dropdown-header .header-icon { font-size: 24px; color: #007bff; margin-bottom: 10px; }
    .dropdown-header p { font-size: 12px; font-weight: bold; color: #333; margin: 5px 0; line-height: 1.5; }
    .candidate-name { color: #007bff; font-weight: bold; font-size: 12px; }
    .status-dropdown { width: 100%; margin-top: 10px; font-size: 12px; border: 2px solid #007bff; border-radius: 6px; outline: none; background-color: #fff; color: #333; }
    .close-icon { position: absolute; top: 10px; right: 10px; font-size: 24px; color: #ff6347; cursor: pointer; transition: color 0.3s ease; }
    .close-icon:hover { color: #ff4500; }
    @keyframes fadeIn { from { opacity: 0; transform: translate(-50%, -55%); } to { opacity: 1; transform: translate(-50%, -50%); } }
    .dropdown-container .fa-times { cursor: pointer; margin-left: 10px; color: #888; font-size: 12px; }
    .pagination-controls { margin-top: 10px; display: flex; gap: 10px; justify-content: center; align-items: center; }
    .icon-wrapper { display: flex; justify-content: center; align-items: center; width: 20px; height: 20px; border-radius: 50%; background-color: #f0f0f0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease, transform 0.3s ease; cursor: pointer; }
    .icon-wrapper i { font-size: 12px; color: #555; }
    .icon-wrapper:hover { background-color: #007BFF; transform: scale(1.1); }
    .icon-wrapper:hover i { color: #fff; }
    .icon-wrapper .disabled { cursor: not-allowed; opacity: 0.5; }
    .icon-wrapper .disabled:hover { transform: none; background-color: #f0f0f0; }
    .pagination-container span { font-size: 12px; }
    .table th,
    .table td {padding: 10px 15px;text-align: center;vertical-align: middle;border-bottom: 1px solid #ddd;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
    /* Preloader styles */
    .preloader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1050;
    }
    .preloader-content {
        text-align: center;
    }
    .spinner {
        width: 50px;
        height: 50px;
        border: 6px solid rgba(0, 0, 0, 0.1);
        border-top-color: #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 10px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<div class="table-container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Ref #</th>
                <th>Name</th>
                <th>Package</th>
                <th>Status</th>
                <th>CN #</th>
                <th>CL #</th>
                <th>Created At</th>
                <th>Expired Time</th>
                <th>Client</th>
                <th>Foreign Partner</th>
                <th>Nationality</th>
                <th>Passport No</th>
                <th>Passport Expiry Date</th>
                <th>Date of Birth</th>
                <th>Payment Method</th>
                <th>Total Amount</th>
                <th>Received Amount</th>
                <th>Remaining Amount</th>
                <th>Salary</th>
                <th>Notes</th>
                <th>Agreement Start Date</th>
                <th>Trial End Date</th>
                <th>Trial No. Days</th>
                <th>Agreement End Date</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agreements as $agreement)
                <tr>
                    <td>{{ $agreement->reference_no }}</td>
                    <td>{{ $agreement->candidate_name }}</td>
                    <td>{{ $agreement->package }}</td>
                    <td>
                        @if($agreement->status == 1)
                            <i class="fas fa-clock text-warning status-icon" title="Pending"></i> Pending
                        @elseif($agreement->status == 2)
                            <i class="fas fa-check-circle text-success status-icon" title="Approved"></i> Approved
                        @elseif($agreement->status == 3)
                            <i class="fas fa-pause-circle text-info status-icon" title="Hold"></i> Hold
                        @elseif($agreement->status == 4)
                            <i class="fas fa-times-circle text-danger status-icon" title="Cancelled"></i> Cancelled
                        @elseif($agreement->status == 5)
                            <i class="fas fa-file-signature text-success status-icon" title="Contracted"></i> Contracted
                        @endif
                    </td>
                    <td><a href="{{ route('candidates.show', $agreement->reference_of_candidate) }}" class="text-primary" target="_blank">{{ $agreement->CN_Number }}</a></td>
                    <td><a href="{{ route('crm.show', $agreement->client->slug ?? '') }}" class="text-primary" target="_blank">{{ $agreement->CL_Number }}</a></td>
                    <td>{{ \Carbon\Carbon::parse($agreement->created_at)->format('d M Y h:i A') }}</td>
                    @php
                        $now       = \Carbon\Carbon::now();
                        $btnClass  = 'btn-secondary';
                        $label     = 'No expiry date available';

                        $expiryRaw = $agreement->agreement_end_date;
                        if ($agreement->package === 'PKG-1' && $agreement->status == 5 && !empty($agreement->agreement_start_date)) {
                            $expiryRaw = \Carbon\Carbon::parse($agreement->agreement_start_date)->addYears(2)->toDateString();
                        }

                        if (!empty($expiryRaw)) {
                            $expiry    = \Carbon\Carbon::parse($expiryRaw);
                            $daysLeft  = $now->diffInDays($expiry, false);
                            $interval  = $now->diff($expiry);

                            if ($daysLeft < 0) {
                                $btnClass = 'btn-danger';
                                $label    = 'Expired';
                            } elseif ($daysLeft <= 7) {
                                $btnClass = 'btn-danger';
                                $label    = $interval->format('%y years %m months %d days %h hours');
                            } elseif ($daysLeft <= 30) {
                                $btnClass = 'btn-warning';
                                $label    = $interval->format('%y years %m months %d days %h hours');
                            } else {
                                $btnClass = 'btn-info';
                                $label    = $interval->format('%y years %m months %d days %h hours');
                            }
                        }
                    @endphp

                    <td>
                        <button type="button" class="btn {{ $btnClass }} btn-sm">
                            <i class="fas fa-clock"></i> {{ $label }}
                        </button>
                    </td>
                    <td>
                        @if ($agreement->client)
                            <a href="{{ route('crm.show', $agreement->client->slug) }}" class="text-primary">{{ $agreement->client->first_name }} {{ $agreement->client->last_name }}</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ explode(' ', $agreement->foreign_partner)[0] . ' ' . last(explode('-', $agreement->foreign_partner)) }}</td>
                    <td>{{ $agreement->Nationality->name ??  $agreement->nationality }}</td>
                    <td>{{ $agreement->passport_no }}</td>
                    <td>{{ \Carbon\Carbon::parse($agreement->passport_expiry_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($agreement->date_of_birth)->format('d M Y') }}</td>
                    <td>{{ $agreement->payment_method }}</td>
                    <td>{{ number_format($agreement->total_amount, 2) }}</td>
                    <td>{{ number_format($agreement->received_amount, 2) }}</td>
                    <td>{{ number_format($agreement->remaining_amount, 2) }}</td>
                    <td>{{ number_format($agreement->salary, 2) }}</td>
                    <td>{{ $agreement->notes ?? 'NA'}}</td>
                    <td>{{ $agreement->agreement_start_date ? \Carbon\Carbon::parse($agreement->agreement_start_date)->format('d M Y') : 'N/A' }}</td>
                    <td>
                      @if($agreement->package === 'PKG-1' && $agreement->agreement_end_date)
                        {{ \Carbon\Carbon::parse($agreement->agreement_end_date)->format('d M Y') }}
                      @else
                        –
                      @endif
                    </td>
                    <td>{{ $agreement->number_of_days ?? '0' }}</td>
                    @php
                        $raw = $agreement->package === 'PKG-1'
                            ? $agreement->agreement_start_date
                            : $agreement->agreement_end_date;

                        $display = '-';

                        if ($raw) {
                            $dt = \Carbon\Carbon::parse($raw);
                            if ($agreement->package === 'PKG-1') {
                                $dt->addYears(2);
                            }

                            $display = $dt->format('d M Y');
                        }
                    @endphp
                    <td>{{ $display }}</td>
                    <td>{{ $agreement->user->first_name ?? '' }} {{ $agreement->user->last_name ?? '' }}</td>
                    <td class="actions">
                        <button type="button" class="btn btn-success btn-icon-only" title="View Payment Proof" data-bs-toggle="modal" data-bs-target="#paymentProofModal{{ $agreement->reference_no }}">
                            <i class="fas fa-receipt"></i>
                        </button>
                        <a href="{{ route('agreements.show', $agreement->reference_no) }}" class="btn btn-info btn-icon-only" target="_blank" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <div class="modal fade" id="paymentProofModal{{ $agreement->reference_no }}" tabindex="-1" aria-labelledby="paymentProofLabel{{ $agreement->reference_no }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentProofLabel{{ $agreement->reference_no }}">Payment Proof</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                @if($agreement->payment_proof)
                                    @php
                                        $filePath = asset('storage/'.$agreement->payment_proof);
                                        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                        <div id="lightGallery{{ $agreement->reference_no }}">
                                            <a href="{{ $filePath }}" class="lightbox-item">
                                                <img src="{{ $filePath }}" alt="Payment Proof" class="img-fluid" style="max-width: 100%; max-height: 500px;">
                                            </a>
                                        </div>
                                    @elseif(strtolower($fileExtension) === 'pdf')
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
                                @if($agreement->payment_proof)
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
        </tbody>
        <tfoot>
            <tr>
                <th>Ref #</th>
                <th>Name</th>
                <th>Package</th>
                <th>Status</th>
                <th>CN #</th>
                <th>CL #</th>
                <th>Created At</th>
                <th>Expired Time</th>
                <th>Client</th>
                <th>Foreign Partner</th>
                <th>Nationality</th>
                <th>Passport No</th>
                <th>Passport Expiry Date</th>
                <th>Date of Birth</th>
                <th>Payment Method</th>
                <th>Total Amount</th>
                <th>Received Amount</th>
                <th>Remaining Amount</th>
                <th>Salary</th>
                <th>Notes</th>
                <th>Agreement Start Date</th>
                <th>Trial End Date</th>
                <th>Trial No. Days</th>
                <th>Agreement End Date</th>
                <th>Created By</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
<nav class="py-2">
  <div class="d-flex justify-content-between align-items-center">
    <span class="text-muted small">
      Showing {{ $agreements->firstItem() }}–{{ $agreements->lastItem() }} of {{ $agreements->total() }} results
    </span>
    <ul class="pagination mb-0">{{ $agreements->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}</ul>
  </div>
</nav>
<script>
    function updateTimeLeft() {
        document.querySelectorAll('.time-left').forEach((element) => {
            const expiryData = element.getAttribute('data-expiry');
            if (!expiryData || isNaN(new Date(expiryData).getTime())) {
                element.innerHTML = `<i class="fas fa-exclamation-triangle text-warning"></i> No expiry date set`;
                element.style.color = 'gray';
                return;
            }

            const expiryDate = new Date(expiryData);
            const now = new Date();
            const diff = expiryDate - now;

            if (diff > 0) {
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                element.innerHTML = `<i class="fas fa-clock text-warning status-icon"></i> ${days}d ${hours}h ${minutes}m ${seconds}s left`;
                element.style.color = '';
            } else {
                const overdue = Math.abs(diff);
                const days = Math.floor(overdue / (1000 * 60 * 60 * 24));
                const hours = Math.floor((overdue % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((overdue % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((overdue % (1000 * 60)) / 1000);
                element.innerHTML = `
                    <i class="fas fa-clock text-danger"></i> Expired<br>
                    <span style="color: red;">-${days}d ${hours}h ${minutes}m ${seconds}s</span>`;
            }
        });
    }

    setInterval(updateTimeLeft, 1000);

</script>