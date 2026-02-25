@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
  .select2-container--bootstrap-5 .select2-selection__rendered,
  .select2-container--bootstrap-5 .select2-selection__placeholder,
  .select2-container--bootstrap-5 .select2-search .select2-search__field,
  .select2-container--bootstrap-5 .select2-results__option{font-size:12px;line-height:1.4}
  .attachments-card{border:1px solid #e9ecef;border-radius:.5rem}
  .attachments-title{font-weight:600;font-size:1rem;margin-bottom:.5rem}
  .attachments-banner{background:#e9f2ff;color:#0d6efd;padding:.75rem 1rem;display:flex;align-items:center;gap:.5rem;border-left:6px solid #0d6efd;border-radius:.5rem .5rem 0 0}
  .attachments-banner i{font-size:1rem}
  #attachmentsTable thead th{background:#0d6efd;color:#fff;vertical-align:middle;text-transform:uppercase;font-size:.8rem;letter-spacing:.02em}
  #attachmentsTable td{vertical-align:middle}
  .btn-add{background:#198754;color:#fff}
  .btn-add:hover{color:#fff}
  .btn-eye{width:100%}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Package</h5>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            @php
              $selectedForeignPartner = old('foreign_partner', $package->foreign_partner ?? '');
              $allowedCountries = ['Ethiopian','India','Indonesia','Kenya','Myanmar','Philippines','Uganda','SriLanka'];
              $nationalities = array_values(array_unique($allowedCountries));
              $selectedNationality = old('nationality', $package->nationality ?? '');
              $documentTypes = ['Passport Copy','Visa Copy','Medical Report','Offer Letter','Contract','QID Copy','Photo','Ticket','Other'];
              $attachments = $attachments ?? collect();
            @endphp

            <form action="{{ route('package.update', $package->id) }}" method="POST" class="row g-3" enctype="multipart/form-data" id="packageFormEdit">
              @csrf
              @method('PUT')
              <div id="deleteBin"></div>

              <div class="col-md-6">
                <label for="candidate_name" class="form-label">Candidate Name <span style="color:#dc3545">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="candidate_name" id="candidate_name" class="form-control" value="{{ old('candidate_name', $package->candidate_name) }}" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="foreign_partner" class="form-label">Foreign Partner</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                  <select name="foreign_partner" id="foreign_partner" class="form-select">
                    <option value="" disabled {{ $selectedForeignPartner === '' ? 'selected' : '' }}>Select foreign partner…</option>
                    <optgroup label="Ethiopian Agencies">
                      <option value="ADEY"   {{ $selectedForeignPartner === 'ADEY' ? 'selected' : '' }}>Adey</option>
                      <option value="BMG"    {{ $selectedForeignPartner === 'BMG' ? 'selected' : '' }}>BMG</option>
                      <option value="ALKABA" {{ $selectedForeignPartner === 'ALKABA' ? 'selected' : '' }}>Alkaba</option>
                      <option value="MY"     {{ $selectedForeignPartner === 'MY' ? 'selected' : '' }}>My</option>
                    </optgroup>
                    <optgroup label="Philippine Agencies">
                      <option value="Ritemerit" {{ $selectedForeignPartner === 'Ritemerit' ? 'selected' : '' }}>Ritemerit</option>
                      <option value="Khalid"    {{ $selectedForeignPartner === 'Khalid' ? 'selected' : '' }}>Khalid</option>
                      <option value="Pinoy"    {{ $selectedForeignPartner === 'Pinoy' ? 'selected' : '' }}>Pinoy</option>
                      <option value="Philandco"    {{ $selectedForeignPartner === 'Philandco' ? 'selected' : '' }}>Philandco</option>
                    </optgroup>
                    <optgroup label="Sri Lanka Agency">
                      <option value="Greenway" {{ $selectedForeignPartner === 'Greenway' ? 'selected' : '' }}>Greenway</option>
                    </optgroup>
                    <optgroup label="Ugandan Agencies">
                      <option value="Edith"  {{ $selectedForeignPartner === 'Edith' ? 'selected' : '' }}>Edith</option>
                      <option value="Stella" {{ $selectedForeignPartner === 'Stella' ? 'selected' : '' }}>Stella</option>
                    </optgroup>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <label for="passport_no" class="form-label">Passport No <span style="color:#dc3545">*</span></label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                  <input type="text" name="passport_no" id="passport_no" class="form-control" value="{{ old('passport_no', $package->passport_no) }}" required>
                </div>
              </div>

              <div class="col-md-6">
                <label for="passport_expiry_date" class="form-label">Passport Expiry Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="passport_expiry_date" id="passport_expiry_date" class="form-control" value="{{ old('passport_expiry_date', $package->passport_expiry_date) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $package->date_of_birth) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="visa_type" class="form-label">Visa Type</label>
                <select name="visa_type" id="visa_type" class="form-select select2-visa">
                  <option value="" {{ old('visa_type', $package->visa_type)=='' ? 'selected' : '' }}>Select Visa Type</option>
                  <option value="D-SPO"     {{ old('visa_type', $package->visa_type)=='D-SPO' ? 'selected' : '' }}>D-SPO</option>
                  <option value="D-HIRE"    {{ old('visa_type', $package->visa_type)=='D-HIRE' ? 'selected' : '' }}>D-HIRE</option>
                  <option value="C-SPO"     {{ old('visa_type', $package->visa_type)=='C-SPO' ? 'selected' : '' }}>C-SPO</option>
                  <option value="OFFICE-V"  {{ old('visa_type', $package->visa_type)=='OFFICE-V' ? 'selected' : '' }}>OFFICE-V</option>
                  <option value="HAYYA"     {{ old('visa_type', $package->visa_type)=='HAYYA' ? 'selected' : '' }}>HAYYA</option>
                  <option value="tourist"   {{ old('visa_type', $package->visa_type)=='tourist' ? 'selected' : '' }}>Tourist</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="CL_Number" class="form-label">CL Number</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  <input type="text" name="CL_Number" id="CL_Number" class="form-control" value="{{ old('CL_Number', $package->CL_Number) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="sponsor_name" class="form-label">Sponsor Name</label>
                <select name="sponsor_name" id="sponsor_name" class="form-select select2-sponsor">
                  <option value="">Select Sponsor</option>
                  @foreach($crmCustomers as $customer)
                    @php $full = trim(($customer->first_name ?? '').' '.($customer->last_name ?? '')); @endphp
                    <option value="{{ $full }}"
                      data-emirates_id="{{ $customer->emirates_id }}"
                      data-nationality="{{ $customer->nationality }}"
                      {{ old('sponsor_name', $package->sponsor_name) === $full ? 'selected' : '' }}>
                      {{ $full }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="eid_no" class="form-label">QID No</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                  <input type="text" name="eid_no" id="eid_no" class="form-control" value="{{ old('eid_no', $package->eid_no) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="nationality" class="form-label">Nationality <span style="color:#dc3545">*</span></label>
                <select name="nationality" id="nationality" class="form-select select2-country" required>
                  <option value="">Select nationality</option>
                  @foreach($nationalities as $nat)
                    <option value="{{ $nat }}" {{ $selectedNationality === $nat ? 'selected' : '' }}>{{ $nat }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="CL_nationality" class="form-label">CL Nationality</label>
                <select name="CL_nationality" id="CL_nationality" class="form-select select2-country">
                  <option value="">Select country</option>
                  @foreach($allCountries as $country)
                    <option value="{{ $country->NAME }}" {{ old('CL_nationality', $package->CL_nationality) == $country->NAME ? 'selected' : '' }}>{{ $country->NAME }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label for="wc_date" class="form-label">WC Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                  <input type="date" name="wc_date" id="wc_date" class="form-control" value="{{ old('wc_date', $package->wc_date) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="visa_date" class="form-label">Visa Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="visa_date" id="visa_date" class="form-control" value="{{ old('visa_date', $package->visa_date) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="incident_type" class="form-label">Incident Type</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                  <input type="text" name="incident_type" id="incident_type" class="form-control" value="{{ old('incident_type', $package->incident_type) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="incident_date" class="form-label">Incident Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  <input type="date" name="incident_date" id="incident_date" class="form-control" value="{{ old('incident_date', $package->incident_date) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="arrived_date" class="form-label">Arrived Date</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-plane-arrival"></i></span>
                  <input type="date" name="arrived_date" id="arrived_date" class="form-control" value="{{ old('arrived_date', $package->arrived_date) }}">
                </div>
              </div>

              <div class="col-md-6">
                <label for="package" class="form-label">Package</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-box"></i></span>
                  <input type="text" name="package" id="package" class="form-control" value="{{ old('package', $package->package) }}" readonly>
                </div>
              </div>

              <div class="col-md-6">
                @php $selectedSalesComm = old('sales_comm_status', $package->sales_comm_status ?? '') @endphp
                <label for="sales_comm_status" class="form-label">Sales Commission Status</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-percent"></i></span>
                  <select name="sales_comm_status" id="sales_comm_status" class="form-select">
                    <option value="" disabled {{ $selectedSalesComm === '' ? 'selected' : '' }}>Select status…</option>
                    <option value="Paid"   {{ $selectedSalesComm === 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Unpaid" {{ $selectedSalesComm === 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                  </select>
                </div>
              </div>

              <div class="col-12">
                <div class="attachments-card p-3">
                  <div class="attachments-title">Attachments</div>
                  <div class="attachments-banner mb-3">
                    <i class="fas fa-paperclip"></i>
                    <span>Upload important documents for the candidate's profile.</span>
                  </div>
                  <div class="table-responsive">
                    <table class="table align-middle mb-0" id="attachmentsTable">
                      <thead>
                        <tr>
                          <th style="min-width:220px">Type</th>
                          <th style="min-width:200px">Document Number</th>
                          <th style="min-width:160px">Issued On</th>
                          <th style="min-width:160px">Expired On</th>
                          <th style="min-width:240px">File</th>
                          <th style="width:120px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($attachments as $doc)
                          @php
                            $issuedVal  = old("existing_documents.$doc->id.issued_at", $doc->issued_on ? \Illuminate\Support\Carbon::parse($doc->issued_on)->format('Y-m-d') : '');
                            $expiredVal = old("existing_documents.$doc->id.expires_at", $doc->expired_on ? \Illuminate\Support\Carbon::parse($doc->expired_on)->format('Y-m-d') : '');
                            $hasFile    = !empty($doc->attachment_file) && $doc->attachment_file !== '0';
                          @endphp
                          <tr class="doc-row doc-row-existing">
                            <td>
                              <select name="existing_documents[{{ $doc->id }}][type]" class="form-select select2-doc-type doc-type-existing">
                                <option value="">Select Document Type...</option>
                                @foreach($documentTypes as $dt)
                                  <option value="{{ $dt }}" {{ old("existing_documents.$doc->id.type", $doc->attachment_type)==$dt ? 'selected' : '' }}>{{ $dt }}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <input type="text" name="existing_documents[{{ $doc->id }}][document_no]" class="form-control doc-number-existing" value="{{ old("existing_documents.$doc->id.document_no", $doc->attachment_number) }}">
                            </td>
                            <td>
                              <input type="date" name="existing_documents[{{ $doc->id }}][issued_at]" class="form-control doc-issued-existing" value="{{ $issuedVal }}">
                            </td>
                            <td>
                              <input type="date" name="existing_documents[{{ $doc->id }}][expires_at]" class="form-control doc-expiry-existing" value="{{ $expiredVal }}">
                            </td>
                            <td>
                              <input type="file" name="existing_documents[{{ $doc->id }}][file]" class="form-control doc-file-existing" accept=".pdf,.jpg,.jpeg,.png">
                              @php
                                $hasFile = !empty($doc->attachment_file);
                              @endphp

                              @if($hasFile)
                                @php
                                  $rawPath   = (string) $doc->attachment_file;                           
                                  $isAbs     = \Illuminate\Support\Str::startsWith($rawPath, ['http://','https://']);
                                  $base      = rtrim(request()->getSchemeAndHttpHost(), '/');            
                                  $fileUrl   = $isAbs ? $rawPath : $base.'/storage/app/public/'.ltrim($rawPath, '/');
                                @endphp
                                <a href="{{ $fileUrl }}" target="_blank" rel="noopener" class="btn btn-outline-secondary btn-sm mt-2 btn-eye">
                                  <i class="fas fa-eye"></i> View
                                </a>
                                <input type="hidden" class="existing-has-file" value="1">
                              @else
                                <input type="hidden" class="existing-has-file" value="0">
                              @endif

                            </td>
                            <td class="text-center">
                              <button type="button" class="btn btn-outline-danger btn-sm btn-remove-existing" data-id="{{ $doc->id }}"><i class="fas fa-trash"></i></button>
                            </td>
                          </tr>
                        @endforeach

                        @php $docIndex = 0; @endphp
                        <tr class="doc-row doc-row-new">
                          <td>
                            <select name="documents[{{ $docIndex }}][type]" class="form-select select2-doc-type doc-type">
                              <option value="">Select Document Type...</option>
                              @foreach($documentTypes as $dt)
                                <option value="{{ $dt }}">{{ $dt }}</option>
                              @endforeach
                            </select>
                          </td>
                          <td><input type="text" name="documents[{{ $docIndex }}][document_no]" class="form-control doc-number" placeholder="Document Number"></td>
                          <td><input type="date" name="documents[{{ $docIndex }}][issued_at]" class="form-control doc-issued" placeholder="Issued On"></td>
                          <td><input type="date" name="documents[{{ $docIndex }}][expires_at]" class="form-control doc-expiry" placeholder="Expired On"></td>
                          <td><input type="file" name="documents[{{ $docIndex }}][file]" class="form-control doc-file" accept=".pdf,.jpg,.jpeg,.png"></td>
                          <td class="text-center">
                            <button type="button" class="btn btn-add btn-sm add-doc-row"><i class="fas fa-plus"></i></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary" id="submitButtonEdit"><i class="fas fa-save"></i> Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@include('../layout.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function(){
  function initSelect2($el){ $el.select2({theme:'bootstrap-5',width:'100%',placeholder:'Select Document Type...',allowClear:true}); }
  $('.select2-country').select2({theme:'bootstrap-5',width:'100%',placeholder:'Select country',allowClear:true});
  $('.select2-sponsor').select2({theme:'bootstrap-5',width:'100%',placeholder:'Select sponsor',allowClear:true});
  $('.select2-visa').select2({theme:'bootstrap-5',width:'100%',placeholder:'Select visa type',allowClear:true});
  $('.select2-doc-type').each(function(){ initSelect2($(this)); });

  $('#sponsor_name').on('change', function(){
    var opt=$(this).find(':selected');
    var qid=opt.data('emirates_id')||'';
    var nat=opt.data('nationality')||'';
    if(qid){ $('#eid_no').val(qid); }
    if(nat){ $('#CL_nationality').val(nat).trigger('change'); }
  });

  function refreshPlusButtons(){
    var $rows=$('#attachmentsTable tbody tr.doc-row-new');
    $rows.find('.add-doc-row').remove();
    if($rows.length){ $rows.last().find('td:last').html('<button type="button" class="btn btn-add btn-sm add-doc-row"><i class="fas fa-plus"></i></button>'); }
  }

  function nextDocIndex(){
    var max=-1;
    $('#attachmentsTable tbody tr.doc-row-new').each(function(){
      var n=$(this).find('select.doc-type').attr('name')||'';
      var m=n.match(/documents\[(\d+)\]/);
      if(m){ var i=parseInt(m[1]); if(i>max) max=i; }
    });
    return max+1;
  }

  function rowReady($row){
    var t=$row.find('.doc-type').val();
    var f=$row.find('.doc-file').val();
    return t && f;
  }

  function newRow(idx){
    var opts=$('#attachmentsTable tbody tr.doc-row-new').first().find('select.doc-type option').map(function(){return '<option value="'+$(this).attr('value')+'">'+$(this).text()+'</option>';}).get().join('');
    var html='';
    html+='<tr class="doc-row doc-row-new">';
    html+='<td><select name="documents['+idx+'][type]" class="form-select select2-doc-type doc-type">'+opts+'</select></td>';
    html+='<td><input type="text" name="documents['+idx+'][document_no]" class="form-control doc-number" placeholder="Document Number"></td>';
    html+='<td><input type="date" name="documents['+idx+'][issued_at]" class="form-control doc-issued" placeholder="Issued On"></td>';
    html+='<td><input type="date" name="documents['+idx+'][expires_at]" class="form-control doc-expiry" placeholder="Expired On"></td>';
    html+='<td><input type="file" name="documents['+idx+'][file]" class="form-control doc-file" accept=".pdf,.jpg,.jpeg,.png"></td>';
    html+='<td class="text-center"></td>';
    html+='</tr>';
    return html;
  }

  $(document).on('click','.add-doc-row',function(){
    var $row=$(this).closest('tr');
    if(!rowReady($row)){ alert('Please select Type and choose a File for this row before adding another.'); return; }
    var idx=nextDocIndex();
    $('#attachmentsTable tbody').append(newRow(idx));
    initSelect2($('#attachmentsTable tbody tr.doc-row-new:last .select2-doc-type'));
    refreshPlusButtons();
  });

  $(document).on('click','.btn-remove-existing',function(){
    var id=$(this).data('id');
    $('#deleteBin').append('<input type="hidden" name="delete_attachments[]" value="'+id+'">');
    $(this).closest('tr').remove();
    refreshPlusButtons();
  });

  refreshPlusButtons();

  $('#packageFormEdit').on('submit', function(e){
    var hasPassport=false;
    $('#attachmentsTable tbody tr.doc-row-existing').each(function(){
      var type=$(this).find('.doc-type-existing').val();
      var hasExisting=$(this).find('.existing-has-file').val()==='1';
      var newFile=$(this).find('.doc-file-existing').val();
      if(type==='Passport Copy' && (hasExisting || newFile)){ hasPassport=true; }
    });
    if(!hasPassport){
      $('#attachmentsTable tbody tr.doc-row-new').each(function(){
        var type=$(this).find('.doc-type').val();
        var f=$(this).find('.doc-file').val();
        if(type==='Passport Copy' && f){ hasPassport=true; }
      });
    }
    if(!hasPassport){
      e.preventDefault();
      alert('Please ensure a Passport Copy exists (current or newly uploaded) before updating.');
      $('html, body').animate({ scrollTop: $('.attachments-card').offset().top-80 }, 300);
    }
  });
});
</script>
