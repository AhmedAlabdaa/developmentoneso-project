@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $license->file_name }}</h5>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <i class="fas fa-file-alt"></i> <strong>File Name:</strong> {{ $license->file_name }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-id-badge"></i> <strong>Document Type:</strong> {{ $license->document_type ?? 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-barcode"></i> <strong>Document Number:</strong> {{ $license->document_number ?? 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-calendar"></i> <strong>Document Date:</strong> {{ $license->document_date ? \Carbon\Carbon::parse($license->document_date)->format('F d, Y') : 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-calendar-alt"></i> <strong>Expiry Date:</strong> {{ $license->expiry_date ? \Carbon\Carbon::parse($license->expiry_date)->format('F d, Y') : 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-toggle-on"></i> <strong>Status:</strong> {{ $license->status }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-building"></i> <strong>Company Name:</strong> {{ $license->company->name ?? 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-map-marker-alt"></i> <strong>Branch Name:</strong> {{ $license->branch->name ?? 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-user"></i> <strong>Uploaded By:</strong> {{ $license->uploaded_by }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-calendar-check"></i> <strong>Uploaded At:</strong> {{ $license->uploaded_at ? \Carbon\Carbon::parse($license->uploaded_at)->format('F d, Y h:i A') : 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-calendar-check"></i> <strong>Created At:</strong> {{ $license->created_at ? $license->created_at->format('F d, Y h:i A') : 'N/A' }}
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-calendar-edit"></i> <strong>Updated At:</strong> {{ $license->updated_at ? $license->updated_at->format('F d, Y h:i A') : 'N/A' }}
                            </li>
                        </ul>
                        <div class="mt-4">
                            <a href="{{ route('licenses.edit', $license->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit License
                            </a>
                            <a href="{{ route('licenses.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Licenses
                            </a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fileModal">
                                <i class="fas fa-eye"></i> View Document
                            </button>
                            <a href="{{ asset('storage/' . ltrim($license->file_path, '/')) }}" download class="btn btn-success">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal for viewing the file -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">Document Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                @if(pathinfo($license->file_path, PATHINFO_EXTENSION) === 'pdf')
                    <iframe src="{{ asset('storage/' . ltrim($license->file_path, '/')) }}" width="100%" height="500px"></iframe>
                @elseif(in_array(pathinfo($license->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset('storage/' . ltrim($license->file_path, '/')) }}" class="img-fluid" alt="Document Image">
                @else
                    <p>Document preview is not available for this file type. Please download to view.</p>
                @endif
            </div>
            <div class="modal-footer">
                <a href="{{ asset('storage/' . ltrim($license->file_path, '/')) }}" download class="btn btn-success">
                    <i class="fas fa-download"></i> Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@include('../layout.footer')
