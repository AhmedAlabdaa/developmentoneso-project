@include('role_header')
<style>
    .notification-list {
        margin-top: 1rem;
        font-size: 12px;
    }
    .notification-item {
        padding: 1rem;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .notification-item:last-child {
        border-bottom: none;
    }
    .notification-time {
        margin-right: 1rem;
        text-align: right;
    }
    .notification-time .time {
        font-weight: bold;
    }
    .notification-time .date {
        color: #666;
    }
    .notification-badge {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        margin-right: 1rem;
    }
    .notification-content {
        flex: 1;
    }
    .notification-content strong {
        display: block;
        margin-bottom: 0.5rem;
    }
    .notification-actions {
        display: flex;
        gap: 0.5rem;
    }
    .pagination-container {
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .pagination-container .muted-text {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .pagination-container ul.pagination {
        justify-content: flex-end;
        margin-bottom: 0;
    }
    .alert {
        max-width: 600px;
        margin: 1rem auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .alert i {
        margin-right: 0.5rem;
    }

    .notification-item.unread {
        background-color: #ffecec;
    }
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Recent Notifications</h5>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="GET" action="{{ route('notifications.index') }}" class="mb-3">
              <div class="input-group">
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search notifications...">
                <button class="btn btn-primary" type="submit">
                  <i class="bi bi-search"></i> Search
                </button>
              </div>
            </form>
            <div class="notification-list">
                @if ($notifications->isEmpty())
                  <div class="notification-item">
                    <div class="notification-content text-center w-100">
                      <strong>No notifications available.</strong>
                    </div>
                  </div>
                @else
                @foreach ($notifications as $notification)
                  <div class="notification-item {{ $notification->status === 'Un Read' ? 'unread' : '' }}">
                    <div class="notification-time">
                      <div class="time">{{ $notification->created_at->format('d M, Y') }}</div>
                      <div class="date">{{ $notification->created_at->format('H:i') }}</div>
                    </div>
                    <i class="bi bi-circle-fill notification-badge 
                        @switch($notification->role)
                            @case('finance') text-success @break
                            @case('sales') text-danger @break
                            @case('coordinator') text-primary @break
                            @case('CHC') text-info @break
                            @default text-muted
                        @endswitch"></i>
                      <div class="notification-content">
                        <strong>{{ $notification->title }}</strong>
                        <p>{{ $notification->message }}</p>
                      </div>
                      @if ($notification->filePath)
                        <div class="notification-attachment">
                          @php
                            $fileExtension = strtolower(pathinfo($notification->filePath, PATHINFO_EXTENSION));
                          @endphp
                          @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                            <a href="javascript:void(0)" style="margin-right: 10px;" class="btn btn-outline-primary btn-sm" onclick="showImageModal('{{ asset('storage/' .$notification->filePath) }}')">
                              <i class="bi bi-image"></i> View Image
                            </a>
                          @elseif ($fileExtension === 'pdf')
                            <a href="javascript:void(0)" style="margin-right: 10px;" class="btn btn-outline-primary btn-sm" onclick="showPdfModal('{{ asset('storage/' .$notification->filePath) }}')">
                              <i class="bi bi-file-earmark-pdf"></i> View PDF
                            </a>
                          @endif
                          <a href="{{ asset($notification->filePath) }}" style="margin-right: 10px;" class="btn btn-outline-success btn-sm" download>
                            <i class="bi bi-download"></i> Download
                          </a>
                        </div>
                      @endif
                      <div class="notification-actions">
                        <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-secondary btn-sm" title="Mark as Read">
                              <i class="bi bi-check-circle"></i>
                            </button>
                        </form>
                        <a href="#" class="btn btn-outline-danger btn-sm" title="Delete">
                          <i class="bi bi-trash"></i>
                        </a>
                      </div>
                  </div>
                @endforeach
              @endif
            </div>

            <nav aria-label="Page navigation">
                <div class="pagination-container">
                    <span class="muted-text">
                        Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} of {{ $notifications->total() }} results
                    </span>
                    <ul class="pagination justify-content-center">
                        {{ $notifications->appends(['search' => request('search')])->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Notification Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="modalPdf" src="" width="100%" height="500px" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

@include('../layout.footer')

<script>
    function showImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }

    function showPdfModal(pdfSrc) {
        document.getElementById('modalPdf').src = pdfSrc;
        const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
        pdfModal.show();
    }

</script>
