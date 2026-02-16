<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Attachment Type</th>
            <th>Preview</th>
            <th>Expired On</th>
        </tr>
    </thead>
    <tbody>
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

            <tr>
                <td class="align-middle text-center"><strong>{{ $attachment->attachment_type }}</strong></td>
                <td class="text-center">
                    @if ($fileUrl)
                        <div style="width: 300px; height: 300px; overflow: hidden; margin: auto; display: flex; align-items: center; justify-content: center;">
                            @if (in_array(pathinfo($attachment->attachment_file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                <a href="{{ $fileUrl }}" data-lightbox="attachment-{{ $attachment->id }}" data-title="{{ $attachment->attachment_type }}">
                                    <img src="{{ $fileUrl }}" style="width: 300px; height: 300px; object-fit: cover;">
                                </a>
                            @elseif ($attachment->attachment_type === 'Video')
                                <video controls style="width: 300px; height: 300px; border-radius: 8px;">
                                    <source src="{{ $fileUrl }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif (pathinfo($attachment->attachment_file, PATHINFO_EXTENSION) === 'pdf')
                                <iframe src="{{ $fileUrl }}" style="width: 300px; height: 300px; border: none;"></iframe>
                            @endif
                        </div>
                        <div class="mt-2 text-center">
                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-primary btn-sm">
                                View Full
                            </a>
                            <a href="{{ $fileUrl }}" download="{{ $attachment->attachment_file }}" class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    @else
                        <span class="text-muted">File not found.</span>
                    @endif
                </td>
                <td class="align-middle text-center">
                    {{ $attachment->expired_on ? \Carbon\Carbon::parse($attachment->expired_on)->format('j F Y') : 'N/A' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
