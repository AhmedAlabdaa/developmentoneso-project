<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
  .nav-tabs .nav-link{transition:background-color .2s;color:#495057;font-size:12px;text-transform:uppercase}
  .nav-tabs .nav-link:hover{background-color:#f8f9fa}
  .nav-tabs .nav-link.active{background-color:#007bff;color:#fff}
  .table-container{width:100%;overflow-x:auto;position:relative}
  .table{width:100%;border-collapse:collapse;margin-bottom:20px}
  .table th,.table td{padding:10px 15px;text-align:left;vertical-align:middle;border-bottom:1px solid #ddd;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:normal}
  .table-hover tbody tr:hover{background-color:#f1f1f1}
  .table-striped tbody tr:nth-of-type(odd){background-color:#f9f9f9}
  .btn-icon-only{display:inline-flex;align-items:center;justify-content:center;padding:5px;border-radius:50%;font-size:12px;width:30px;height:30px;color:#fff}
  .btn-danger{background-color:#dc3545}
  .pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 0}
  .muted-text{color:#6c757d;font-size:12px}
  .pagination{display:flex;justify-content:center;align-items:center;margin:0}
  .pagination .page-item{margin:0 .1rem}
  .pagination .page-link{border-radius:.25rem;padding:.5rem .75rem;color:#007bff;background-color:#fff;border:1px solid #007bff;transition:background-color .2s,color .2s}
  .pagination .page-link:hover{background-color:#007bff;color:#fff}
  .pagination .page-item.active .page-link{background-color:#007bff;color:#fff;border:1px solid #007bff}
  .pagination .page-item.disabled .page-link{color:#6c757d;background-color:#fff;border:1px solid #6c757d;cursor:not-allowed}
  .pagination .page-item:first-child .page-link{border-top-left-radius:.25rem;border-bottom-left-radius:.25rem}
  .pagination .page-item:last-child .page-link{border-top-right-radius:.25rem;border-bottom-right-radius:.25rem}
  .fullscreen-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,.5);z-index:1049}
  .dropdown-container{display:none;position:fixed;z-index:1050;background-color:#fff;border-radius:8px;padding:20px;box-shadow:0 8px 12px rgba(0,0,0,.2);min-width:350px;max-width:450px;text-align:center;left:50%;top:50%;transform:translate(-50%,-50%);border:4px solid #007bff}
  .dropdown-header{margin-bottom:15px}
  .dropdown-header .header-icon{font-size:24px;color:#007bff;margin-bottom:10px}
  .dropdown-header p{font-size:12px;font-weight:bold;color:#333;margin:5px 0;line-height:1.5}
  .package-name{color:#007bff;font-weight:bold;font-size:12px}
  .status-dropdown{width:100%;margin-top:10px;font-size:12px;border:2px solid #007bff;border-radius:6px;outline:0;background-color:#fff;color:#333}
  .close-icon{position:absolute;top:10px;right:10px;font-size:24px;color:#ff6347;cursor:pointer}
  .close-icon:hover{color:#ff4500}
  .custom-modal .modal-content{border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.3);font-size:12px;background:#fff}
  .custom-modal .modal-header{background:linear-gradient(135deg,#007bff,#6a11cb);color:#fff;padding:15px;border-radius:12px 12px 0 0}
  .custom-modal .modal-header h5{font-size:12px;font-weight:bold;margin:0;color:#fff}
  .custom-modal .modal-body{padding:20px;color:#333;background:#f9f9f9}
  .custom-modal .modal-footer{padding:15px;border-top:1px solid #ddd;border-radius:0 0 12px 12px;background:#f1f1f1}
</style>

<div class="table-container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>CN#</th>
        <th>Full Name</th>
        <th>Sales Name</th>
        <th>Status Date</th>
        <th>Nationality</th>
        <th>Partner</th>
        <th>CL#</th>
        <th>Client Name</th>
        <th>Current Visa</th>
        <th>Arrived Date</th>
        <th>Return Date</th>
        <th>Cancel Date</th>
        <th>Visa/Cancel Expiry</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($packages as $p)
      <tr>
        <td>{{ strtoupper($p->CN_Number) }}</td>
        <td>{{ strtoupper($p->candidate_name) }}</td>
        <td title="{{ $p->sales_name }}">{{ strtoupper(explode(' ', $p->sales_name)[0]) }}</td>
        <td>{{ strtoupper($p->updated_at->format('d M Y h:i A')) }}</td>
        <td>{{ strtoupper($p->nationality) }}</td>
        <td>{{ strtoupper($p->foreign_partner) }}</td>
        <td>{{ strtoupper($p->CL_Number) }}</td>
        <td>{{ strtoupper($p->sponsor_name) }}</td>
        <td>{{ strtoupper($p->visa_type) }}</td>
        <td>{{ \Carbon\Carbon::parse($p->arrived_date)->format('d M Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($p->returned_date)->format('d M Y') }}</td>
        <td>-</td>
        <td>{{ \Carbon\Carbon::parse($p->expiry_date)->format('d M Y') }}</td>
        <td>{{ $p->description }}</td>
        <td>
          <a href="javascript:void(0)" class="btn btn-primary btn-icon-only" title="Change Status" onclick="openStatusDialog('{{ $p->id }}','{{ $p->candidate_name ? strtoupper(\Illuminate\Support\Str::title(strtolower($p->candidate_name))) : 'N/A' }}')">
            <i class="fas fa-train"></i>
          </a>
          <a href="{{ route('package.exit', ['reference_no' => $p->hr_ref_no]) }}" class="btn btn-primary btn-icon-only" title="Exit Form" target="_blank">
            <i class="fas fa-file-export"></i>
          </a>
          @if (Auth::user()->role === 'Admin')
          <form action="{{ route('packages.destroy', $p->id) }}" method="POST" style="display:inline" id="delete-form-{{ $p->id }}">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger btn-icon-only" onclick="confirmDelete('{{ $p->id }}')" title="Delete">
              <i class="fas fa-trash-alt"></i>
            </button>
          </form>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="15" class="text-center">No results found.</td>
      </tr>
      @endforelse
    </tbody>
    <tfoot>
      <tr>
        <th>CN#</th>
        <th>Full Name</th>
        <th>Sales Name</th>
        <th>Status Date</th>
        <th>Nationality</th>
        <th>Partner</th>
        <th>CL#</th>
        <th>Client Name</th>
        <th>Current Visa</th>
        <th>Arrived Date</th>
        <th>Return Date</th>
        <th>Cancel Date</th>
        <th>Visa/Cancel Expiry</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </tfoot>
  </table>
</div>

<nav aria-label="Page navigation">
  <div class="pagination-container">
    <span class="muted-text">Showing {{ $packages->firstItem() }} to {{ $packages->lastItem() }} of {{ $packages->total() }} results</span>
    <ul class="pagination justify-content-center">
      {{ $packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
    </ul>
  </div>
</nav>

<div class="fullscreen-overlay" id="fullscreenOverlay"></div>
<div class="dropdown-container" id="statusDropdownDialog">
  <div class="close-icon" onclick="closeStatusDialog()"><i class="fas fa-times-circle"></i></div>
  <div class="dropdown-header">
    <div class="header-icon"><i class="fas fa-info-circle"></i></div>
    <p>Do you want to change the status of</p>
    <p>package <span id="statusDialogPackageName" class="package-name"></span>?</p>
  </div>
  <select class="form-control status-dropdown" id="statusDropdownSelect" name="current_status">
    <option value="0">Incident</option>
  </select>
  <div class="mt-3">
    <button type="button" class="btn btn-primary" onclick="confirmStatusChange()">Confirm</button>
  </div>
</div>

<div class="modal fade custom-modal" id="incidentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Incident</h5></div>
      <div class="modal-body">
        <input type="hidden" id="incident_candidate_id">
        <input type="hidden" id="incident_cn_number">
        <div class="form-group mb-2">
          <label>Incident Type</label>
          <input type="text" class="form-control" id="incident_type">
        </div>
        <div class="form-group mb-2">
          <label>Date</label>
          <input type="date" class="form-control" id="incident_date">
        </div>
        <div class="form-group mb-2">
          <label>Comments</label>
          <textarea class="form-control" id="incident_comments" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" onclick="saveIncidentData()">Save</button>
      </div>
    </div>
  </div>
</div>

<script>
  let currentPackageId=null,currentPackageName='';
  const overlay=document.getElementById('fullscreenOverlay');
  const dialog=document.getElementById('statusDropdownDialog');
  const pkgNameEl=document.getElementById('statusDialogPackageName');
  const statusSelect=document.getElementById('statusDropdownSelect');

  function openStatusDialog(packageId,packageName){
    currentPackageId=packageId;currentPackageName=packageName||'N/A';
    pkgNameEl.textContent=currentPackageName;
    overlay.style.display='block';
    dialog.style.display='block';
  }

  function closeStatusDialog(){
    overlay.style.display='none';
    dialog.style.display='none';
  }

  overlay.addEventListener('click',closeStatusDialog);

  function confirmDelete(packageId){
    Swal.fire({title:'Are you sure?',text:'This action cannot be undone.',icon:'warning',showCancelButton:true,confirmButtonColor:'#28a745',cancelButtonColor:'#dc3545',confirmButtonText:'Yes, delete it',cancelButtonText:'No, cancel'})
    .then(r=>{if(r.isConfirmed){document.getElementById(`delete-form-${packageId}`).submit()}});
  }

  function confirmStatusChange(){
    const newStatus=statusSelect.value;
    Swal.fire({title:`Change status for ${currentPackageName}?`,text:`Set status to "Incident"?`,icon:'warning',showCancelButton:true,confirmButtonColor:'#28a745',cancelButtonColor:'#dc3545',confirmButtonText:'Yes, change it',cancelButtonText:'No, keep it'})
    .then(r=>{
      if(!r.isConfirmed)return;
      closeStatusDialog();
      openIncidentModal(currentPackageId);
    });
  }

  function openIncidentModal(packageId){
    const csrf=document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    document.getElementById('incident_candidate_id').value=packageId;
    document.getElementById('incident_cn_number').value='';
    document.getElementById('incident_type').value='';
    document.getElementById('incident_date').value='';
    document.getElementById('incident_comments').value='';
    $.ajax({
      url:"{{ route('packages.update-status-inside', ':id') }}".replace(':id',packageId),
      type:'GET',
      headers:{'X-CSRF-TOKEN':csrf},
      success:function(res){
        $('#incident_candidate_id').val(res.candidate_id||packageId);
        $('#incident_cn_number').val(res.cn_number||'');
        $('#incident_type').val(res.incident_type||'');
        $('#incident_date').val(res.incident_date||'');
        $('#incident_comments').val(res.comments||'');
        $('#incidentModal').modal('show');
      },
      error:function(){toastr.error('Failed to load incident data. Please try again.');$('#incidentModal').modal('show')}
    });
  }

  function saveIncidentData(){
    const csrf=document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const data=new FormData();
    data.append('candidate_id',$('#incident_candidate_id').val());
    data.append('cn_number',$('#incident_cn_number').val());
    data.append('incident_type',$('#incident_type').val());
    data.append('incident_date',$('#incident_date').val());
    data.append('comments',$('#incident_comments').val());
    $.ajax({
      url:"{{ route('package.incidentSave') }}",
      type:'POST',
      headers:{'X-CSRF-TOKEN':csrf},
      data:data,
      processData:false,
      contentType:false,
      success:function(){toastr.success('Incident saved successfully!');$('#incidentModal').modal('hide');location.reload()},
      error:function(){toastr.error('Failed to save incident. Please check your inputs and try again.')}
    });
  }
</script>
