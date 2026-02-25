<style>
.table-container{width:100%;overflow-x:auto;position:relative}
.table{width:100%;border-collapse:collapse;margin-bottom:20px}
.table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.table th{background-color:#343a40;color:#fff;text-transform:uppercase;font-weight:700}
.table-hover tbody tr:hover{background-color:#f1f1f1}
.table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}
.btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
.btn-info{background-color:#17a2b8}
.btn-warning{background-color:#ffc107}
.btn-danger{background-color:#dc3545}
.sticky-table th:last-child,.sticky-table td:last-child{position:sticky;right:0;background-color:#fff;z-index:2;box-shadow:-2px 0 5px rgba(0,0,0,.1);min-width:150px}
.table th:last-child{z-index:3}
.status-dropdown{padding:5px;font-size:12px;border-radius:5px;transition:background-color .3s;width:150px;color:#000;font-weight:700;text-transform:uppercase}
.status-dropdown.approved{background-color:#28a745}
.status-dropdown.pending{background-color:#ffc107}
.status-dropdown.rejected{background-color:#dc3545}
.status-dropdown.review{background-color:#17a2b8}
.scrollable-modal-body{max-height:500px;overflow-y:auto}
.modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3)}
.modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0;font-size:14px}
.modal-body{padding:20px;background:#f9f9f9;font-size:12px;max-height:70vh;overflow:auto}
.modal-footer{padding:15px;background:#f9f9f9;border-radius:0 0 12px 12px}
.custom-modal .modal-dialog{max-width:600px;margin:0 auto}
.custom-modal .form-control,.custom-modal .form-select{font-size:12px;border-radius:4px;height:30px}
.select2-container--default .select2-selection--single{height:30px!important;border:2px solid #007bff;border-radius:6px}
</style>

@php $fmt = 'd M Y'; @endphp

<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Ref #</th>
        <th>Agree #</th>
        <th>Sale Name</th>
        <th>CN&nbsp;#</th>
        <th>CN&nbsp;Name</th>
        <th>Status</th>                
        <th>Nationality</th>
        <th>Passport&nbsp;#</th>       
        <th>CL&nbsp;#</th>
        <th>CL&nbsp;Name</th>
        <th>Date</th>
        <th>Cont.&nbsp;Type</th>
        <th>Package</th>
        <th>cont.&nbsp;Start</th>
        <th>cont.&nbsp;End</th>
        <th>Maid&nbsp;Delivered</th>
        <th>Transferred&nbsp;Date</th>
        <th>Remarks</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($contracts as $contract)
        @php
          $end        = $contract->contract_end_date ? \Carbon\Carbon::parse($contract->contract_end_date) : null;
          $now        = now();
          $agreement  = $contract->agreement;
          $client     = $contract->client;
          $cnNumber    = $contract->CN_Number                ?? '—';
          $cnName      = $agreement?->candidate_name         ?? '—';
          $nationality = $agreement?->nationality            ?? '—';
          $passport    = $agreement?->passport_no            ?? '—';   
          $clNumber    = $client?->cl ?? $client?->CL_Number ?? '—';
          $clName      = trim(($client?->first_name ?? '').' '.($client?->last_name ?? '')) ?: '—';
          $statusVal   = $agreement?->status; 
        @endphp
        <tr>
          <td><a class="link-primary" href="{{ route('contracts.show', $contract->reference_no) }}">{{ $contract->reference_no }}</a></td>
          <td><a class="link-primary" href="{{ route('agreements.show', $contract->agreement_reference_no) }}">{{ $contract->agreement_reference_no }}</a></td>
          <td title="{{ $contract->salesPerson?->first_name ?? '—' }} {{ $contract->salesPerson?->last_name ?? '—' }}">{{ $contract->salesPerson?->first_name ?? '—' }}</td>
          <td>{{ $cnNumber }}</td>
          <td>{{ $cnName }}</td>
          <td>
            @switch((int) $statusVal)
              @case(1)
                <i class="fas fa-clock text-warning status-icon" title="Pending"></i> Pending
              @break
              @case(2)
                <i class="fas fa-circle-check text-success status-icon" title="Active"></i> Active
              @break
              @case(3)
                <i class="fas fa-triangle-exclamation text-warning status-icon" title="Exceeded"></i> Exceeded
              @break
              @case(4)
                <i class="fas fa-circle-xmark text-danger status-icon" title="Rejected"></i> Rejected
              @break
              @case(5)
                <i class="fas fa-file-signature text-primary status-icon" title="Contracted"></i> Contracted
              @break
              @case(6)
                <i class="fas fa-calendar-plus text-info status-icon" title="Extended"></i> Extended
              @break
              @default
                <i class="fas fa-circle-question text-secondary status-icon" title="Unknown"></i> Unknown
            @endswitch
          </td>
          <td>{{ $nationality }}</td>
          <td>{{ $passport }}</td>
          <td>{{ $clNumber }}</td>
          <td>{{ $clName }}</td>
          <td>{{ \Carbon\Carbon::parse($contract->created_at)->format('d M Y') }}</td>
          <td>{{ $contract->agreement_type }}</td>
          <td>{{ $contract->package }}</td>
          <td>{{ $contract->contract_start_date ? \Carbon\Carbon::parse($contract->contract_start_date)->format($fmt) : '' }}</td>
          <td>{{ $contract->contract_end_date   ? \Carbon\Carbon::parse($contract->contract_end_date)->format($fmt)   : '' }}</td>
          <td>{{ $contract->maid_delivered }}</td>
          <td>{{ $contract->transferred_date ? \Carbon\Carbon::parse($contract->transferred_date)->format($fmt) : '' }}</td>
          <td>{{ $contract->remarks }}</td>
          <td class="text-center">
            @if($contract->contract_signed_copy)
              <button class="btn btn-success btn-icon-only view-copy" data-file="{{ asset('storage/'.$contract->contract_signed_copy) }}">
                <i class="fas fa-download"></i>
              </button>
            @else
              <button class="btn btn-primary btn-icon-only open-upload-modal" data-bs-toggle="modal" data-bs-target="#uploadCopyModal" data-reference="{{ $contract->reference_no }}" data-agreement="{{ $contract->agreement_reference_no }}" data-start="{{ $contract->contract_start_date }}" data-end="{{ $contract->contract_end_date }}" data-transferred="{{ $contract->maid_delivered ?? 'No' }}" data-status="{{ $contract->status ?? 1 }}">
                <i class="fas fa-upload"></i>
              </button>
            @endif
            <a class="btn btn-info btn-icon-only" href="{{ route('contracts.show', $contract->reference_no) }}">
              <i class="fas fa-eye"></i>
            </a>
            @if(in_array(Auth::user()->role, ['Managing Director','Archive Clerk','Admin']))
              <button class="btn btn-icon-only toggle-marked {{ $contract->marked==='Yes'?'btn-success':'btn-danger' }}" data-id="{{ $contract->id }}" data-ref="{{ $contract->reference_no }}" data-current="{{ $contract->marked }}">
                <i class="fas {{ $contract->marked==='Yes'?'fa-check-circle':'fa-times-circle' }}"></i>
              </button>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th>Ref #</th>
        <th>Agree #</th>
        <th>Sale Name</th>
        <th>CN&nbsp;#</th>
        <th>CN&nbsp;Name</th>
        <th>Status</th>                
        <th>Nationality</th>
        <th>Passport&nbsp;#</th>       
        <th>CL&nbsp;#</th>
        <th>CL&nbsp;Name</th>
        <th>Date</th>
        <th>Cont.&nbsp;Type</th>
        <th>Package</th>
        <th>cont.&nbsp;Start</th>
        <th>cont.&nbsp;End</th>
        <th>Maid&nbsp;Delivered</th>
        <th>Transferred&nbsp;Date</th>
        <th>Remarks</th>
        <th class="text-center">Actions</th>
      </tr>
    </tfoot>
  </table>
</div>
<nav class="py-2">
  <div class="d-flex justify-content-between align-items-center">
    <span class="text-muted small">
      Showing {{ $contracts->firstItem() }}–{{ $contracts->lastItem() }} of {{ $contracts->total() }}
    </span>
    <ul class="pagination mb-0">
      {{ $contracts->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
    </ul>
  </div>
</nav>

<div class="modal fade" id="signedCopyModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Contract Signed Copy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <iframe id="signedCopyFrame" style="width:100%;height:80vh;border:0"></iframe>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="uploadCopyModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="uploadCopyForm" method="POST" enctype="multipart/form-data">
      @csrf
      @method('POST')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Upload Contract Signed Copy</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="formErrors" class="alert alert-danger d-none small mb-2"></div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Contract Reference #</label>
              <input type="text" id="reference_no" name="reference_no" class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Agreement Reference No</label>
              <input type="text" id="agreement_reference_no" name="agreement_reference_no" class="form-control" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label">Contract Start Date</label>
              <input type="date" id="contract_start_date" name="contract_start_date" class="form-control">
              <div class="invalid-feedback" id="error_contract_start_date"></div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Contract End Date</label>
              <input type="date" id="contract_end_date" name="contract_end_date" class="form-control">
              <div class="invalid-feedback" id="error_contract_end_date"></div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Maid Transferred</label>
              <select id="maid_delivered" name="maid_delivered" class="form-select">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
              <div class="invalid-feedback" id="error_maid_delivered"></div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Status</label>
              <select id="status" name="status" class="form-select">
                <option value="1">Active</option>
                <option value="2">Cancelled</option>
                <option value="3">Extended</option>
                <option value="4">Completed</option>
              </select>
              <div class="invalid-feedback" id="error_status"></div>
            </div>
            <div class="col-md-12">
              <label class="form-label">Signed-copy file</label>
              <input type="file" name="contract_signed_copy" id="contract_signed_copy" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
              <div class="invalid-feedback" id="error_contract_signed_copy"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-upload me-1"></i>Save &amp; Upload</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).on('click','.view-copy',function(){
  $('#signedCopyFrame').attr('src',$(this).data('file'));
  bootstrap.Modal.getOrCreateInstance(document.getElementById('signedCopyModal')).show();
});
$('#signedCopyModal').on('hidden.bs.modal',function(){
  $('#signedCopyFrame').attr('src','');
});

$(document).on('click','.open-upload-modal',function(){
  const btn = $(this);
  $('#uploadCopyForm')
    .attr('action', `/contracts/updateP1`)
    .find('.is-invalid').removeClass('is-invalid').end()
    .find('.invalid-feedback').text('');
  $('#reference_no').val(btn.data('reference'));
  $('#agreement_reference_no').val(btn.data('agreement'));
  $('#contract_start_date').val(btn.data('start')||'');
  $('#contract_end_date').val(btn.data('end')||'');
  $('#maid_delivered').val(btn.data('transferred'));
  $('#status').val(btn.data('status'));
  $('#formErrors').addClass('d-none').empty();
  bootstrap.Modal.getOrCreateInstance(document.getElementById('uploadCopyModal')).show();
});

$('#uploadCopyForm').on('submit',function(e){
  e.preventDefault();
  const form = $(this);
  const url  = form.attr('action');
  const data = new FormData(this);
  form.find('.is-invalid').removeClass('is-invalid');
  form.find('.invalid-feedback').text('');
  $('#formErrors').addClass('d-none').empty();

  $.ajax({
    url: url,
    method: 'POST',
    data: data,
    processData: false,
    contentType: false,
    success: () => location.reload(),
    error: xhr => {
      if (xhr.status === 422) {
        const errors = xhr.responseJSON.errors;
        Object.keys(errors).forEach(field => {
          const msg   = errors[field][0];
          const input = form.find(`[name="${field}"]`);
          if (input.length) {
            input.addClass('is-invalid');
            $(`#error_${field}`).text(msg);
          } else {
            $('#formErrors').removeClass('d-none').append(`<div>${msg}</div>`);
          }
        });
      } else {
        $('#formErrors').removeClass('d-none').text('An unexpected error occurred.');
      }
    }
  });
});

$(document).on('click','.toggle-marked',function(){
  const btn  = $(this);
  const next = btn.data('current') === 'Yes' ? 'No' : 'Yes';
  if (!confirm(`Mark as ${next}?`)) return;
  $.post("{{ route('contracts.toggleMarked') }}", {
    id: btn.data('id'),
    marked: next,
    _token: $('meta[name="csrf-token"]').attr('content')
  }).done(res => {
    btn.data('current',next)
       .toggleClass('btn-success btn-danger')
       .find('i').toggleClass('fa-check-circle fa-times-circle');
    alert(res.message || 'Updated');
  }).fail(() => alert('Failed to update.'));
});
</script>
