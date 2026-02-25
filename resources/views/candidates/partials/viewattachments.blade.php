<div class="document-list">
    @foreach ($candidate->attachments as $attachment)
        @php
            $baseUrl = 'https://' . $foreignPartner . '.onesourceerp.com/storage/app/public/';
            $localPath = 'public/' . $attachment->attachment_file;
            $localFileExists = \Storage::exists($localPath);
            $remoteFileUrl = $baseUrl . $attachment->attachment_file;
            $fileUrl = $localFileExists 
                        ? url('storage/' . $attachment->attachment_file) 
                        : (get_headers($remoteFileUrl) && strpos(get_headers($remoteFileUrl)[0], '200') !== false ? $remoteFileUrl : null);
        @endphp
        <div class="document-item">
            <span class="document-name">
                @if (pathinfo($attachment->attachment_file, PATHINFO_EXTENSION) === 'pdf')
                    <i class="fas fa-file-pdf"></i>
                @elseif (in_array(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                    <i class="fas fa-image"></i>
                @elseif (pathinfo($attachment->attachment_file, PATHINFO_EXTENSION) === 'mp4')
                    <i class="fas fa-video"></i>
                @else
                    <i class="fas fa-file-alt"></i>
                @endif
                {{ $attachment->attachment_type }}
            </span>
            <div class="document-viewer">
                @if ($fileUrl)
                    @if (pathinfo($attachment->attachment_file, PATHINFO_EXTENSION) === 'pdf')
                        <iframe src="{{ $fileUrl }}" frameborder="0" class="document-frame"></iframe>
                    @elseif (in_array(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                        <a href="{{ $fileUrl }}" data-lightbox="attachment-{{ $attachment->id }}" data-title="{{ $attachment->attachment_type }}">
                            <img src="{{ $fileUrl }}" style="max-width: 300px; max-height: 300px; object-fit: cover;" alt="{{ $attachment->attachment_type }}">
                        </a>
                    @elseif (pathinfo($attachment->attachment_file, PATHINFO_EXTENSION) === 'mp4')
                        <a href="{{ $fileUrl }}" data-lightbox="attachment-{{ $attachment->id }}" data-title="{{ $attachment->attachment_type }}">
                            <video controls style="max-width: 300px; max-height: 300px; object-fit: cover;" class="document-video">
                                <source src="{{ $fileUrl }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </a>
                    @else
                        <img src="https://via.placeholder.com/800x600.png?text=Unsupported+Document" class="document-placeholder" alt="Placeholder Document">
                    @endif
                @else
                    <p class="text-muted">File not found.</p>
                @endif
            </div>
        </div>
    @endforeach
</div>