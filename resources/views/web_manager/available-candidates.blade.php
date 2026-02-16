@include('role_header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<style>
  .dataTables_info{font-size:12px}
  .dataTables_paginate{font-size:12px}
  .text-truncate{max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
  .lang-chip{font-size:10px;padding:.15rem .4rem;border-radius:.35rem;background:#eef;border:1px solid #cfe}
  .lang-chip.ar{background:#fee;border-color:#f6c}
  .small-muted{font-size:12px;color:#6c757d}
  .dir-rtl{direction:rtl;text-align:right}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="card-title">Available Candidates</h5>
        </div>
        <div class="table-responsive">
          <table id="candidates-table" class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Ref No</th>
                <th>Candidate Name</th>
                <th>Passport No</th>
                <th>Slug</th>
                <th>Meta Title<br><span class="small-muted">EN / AR</span></th>
                <th>Meta Keywords<br><span class="small-muted">EN / AR</span></th>
                <th>Meta Description<br><span class="small-muted">EN / AR</span></th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($candidates as $c)
                <tr id="cand-{{ $c->id }}">
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $c->ref_no }}</td>
                  <td>{{ $c->candidate_name }}</td>
                  <td>{{ $c->passport_no }}</td>
                  <td class="cell-slug">{{ $c->slug }}</td>
                  <td class="cell-title">
                    <div><span class="lang-chip">EN</span> <span class="val-en">{{ $c->meta_title }}</span></div>
                    <div class="mt-1"><span class="lang-chip ar">AR</span> <span class="val-ar">{{ $c->meta_title_ar }}</span></div>
                  </td>
                  <td class="cell-keywords">
                    <div class="text-truncate"><span class="lang-chip">EN</span> <span class="val-en">{{ $c->meta_keywords }}</span></div>
                    <div class="text-truncate mt-1"><span class="lang-chip ar">AR</span> <span class="val-ar">{{ $c->meta_keywords_ar }}</span></div>
                  </td>
                  <td class="cell-description">
                    <div class="text-truncate"><span class="lang-chip">EN</span> <span class="val-en">{{ $c->meta_description }}</span></div>
                    <div class="text-truncate mt-1"><span class="lang-chip ar">AR</span> <span class="val-ar">{{ $c->meta_description_ar }}</span></div>
                  </td>
                  <td class="text-center">
                    <button
                      class="btn btn-info btn-sm edit-btn"
                      data-bs-toggle="modal"
                      data-bs-target="#editCandidateMetaModal"
                      data-id="{{ $c->id }}"
                      data-row="#cand-{{ $c->id }}"
                      data-ref="{{ $c->ref_no }}"
                      data-name="{{ $c->candidate_name }}"
                      data-passport="{{ $c->passport_no }}"
                      data-slug="{{ e($c->slug) }}"
                      data-title-en="{{ e($c->meta_title) }}"
                      data-title-ar="{{ e($c->meta_title_ar) }}"
                      data-keywords-en="{{ e($c->meta_keywords) }}"
                      data-keywords-ar="{{ e($c->meta_keywords_ar) }}"
                      data-description-en="{{ e($c->meta_description) }}"
                      data-description-ar="{{ e($c->meta_description_ar) }}"
                      title="Edit SEO/Slug"
                    >
                      <i class="fas fa-edit"></i>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="editCandidateMetaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form id="candidateMetaForm">
      @csrf
      <input type="hidden" name="id" id="cand_id">
      <input type="hidden" id="row_selector">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Candidate Meta</h5>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
          <div class="row gx-3">
            <div class="col-md-4 mb-3">
              <label class="form-label">Ref No</label>
              <input type="text" id="cand_ref" class="form-control" readonly>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Candidate Name</label>
              <input type="text" id="cand_name" class="form-control" readonly>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Passport No</label>
              <input type="text" id="cand_passport" class="form-control" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label for="slug" class="form-label">Slug *</label>
              <input type="text" id="slug" name="slug" class="form-control" required>
              <div class="small-muted mt-1">lowercase, numbers, hyphens</div>
            </div>
            <div class="col-12">
              <ul class="nav nav-tabs mt-2" id="metaTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="tab-en" data-bs-toggle="tab" data-bs-target="#pane-en" type="button" role="tab" aria-controls="pane-en" aria-selected="true">English</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="tab-ar" data-bs-toggle="tab" data-bs-target="#pane-ar" type="button" role="tab" aria-controls="pane-ar" aria-selected="false">العربية</button>
                </li>
              </ul>
              <div class="tab-content border border-top-0 p-3" id="metaTabsContent">
                <div class="tab-pane fade show active" id="pane-en" role="tabpanel" aria-labelledby="tab-en" tabindex="0">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="meta_title" class="form-label">Meta Title (EN)</label>
                      <input type="text" id="meta_title" name="meta_title" class="form-control" maxlength="60">
                      <div class="small-muted"><span id="cnt_title_en">0</span>/60</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="meta_keywords" class="form-label">Meta Keywords (EN)</label>
                      <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" maxlength="255">
                      <div class="small-muted"><span id="cnt_keywords_en">0</span>/255</div>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="meta_description" class="form-label">Meta Description (EN)</label>
                      <textarea id="meta_description" name="meta_description" rows="3" class="form-control" maxlength="160"></textarea>
                      <div class="small-muted"><span id="cnt_description_en">0</span>/160</div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="pane-ar" role="tabpanel" aria-labelledby="tab-ar" tabindex="0">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="meta_title_ar" class="form-label">عنوان الميتا (AR)</label>
                      <input type="text" id="meta_title_ar" name="meta_title_ar" class="form-control dir-rtl" maxlength="60">
                      <div class="small-muted text-end"><span id="cnt_title_ar">0</span>/60</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="meta_keywords_ar" class="form-label">الكلمات المفتاحية (AR)</label>
                      <input type="text" id="meta_keywords_ar" name="meta_keywords_ar" class="form-control dir-rtl" maxlength="255">
                      <div class="small-muted text-end"><span id="cnt_keywords_ar">0</span>/255</div>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="meta_description_ar" class="form-label">وصف الميتا (AR)</label>
                      <textarea id="meta_description_ar" name="meta_description_ar" rows="3" class="form-control dir-rtl" maxlength="160"></textarea>
                      <div class="small-muted text-end"><span id="cnt_description_ar">0</span>/160</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
  const updateUrlTemplate="{{ route('available-candidates.update', ':id') }}";
  let currentRowSelector=null;
  toastr.options={closeButton:true,progressBar:true,newestOnTop:true,timeOut:2500,extendedTimeOut:1200,positionClass:"toast-top-right"};
  function countBind(id,cid){const $e=$(id),$c=$(cid);const f=()=>{$c.text(($e.val()||'').length)};$e.on('input',f);f()}
  function sanitizeSlug(v){return (v||'').toString().toLowerCase().replace(/\s+/g,'-').replace(/[^a-z0-9\-]/g,'-').replace(/\-+/g,'-').replace(/^\-+|\-+$/g,'')}
  $(function(){
    const dt=$('#candidates-table').DataTable({pageLength:25,order:[[0,'asc']]});
    countBind('#meta_title','#cnt_title_en');countBind('#meta_keywords','#cnt_keywords_en');countBind('#meta_description','#cnt_description_en');
    countBind('#meta_title_ar','#cnt_title_ar');countBind('#meta_keywords_ar','#cnt_keywords_ar');countBind('#meta_description_ar','#cnt_description_ar');
    $('#editCandidateMetaModal').on('show.bs.modal',function(e){
      const b=$(e.relatedTarget);
      currentRowSelector=b.data('row');
      $('#cand_id').val(b.data('id'));
      $('#row_selector').val(currentRowSelector);
      $('#cand_ref').val(b.data('ref')||'');
      $('#cand_name').val(b.data('name')||'');
      $('#cand_passport').val(b.data('passport')||'');
      $('#slug').val(b.data('slug')||'');
      $('#meta_title').val(b.data('title-en')||'').trigger('input');
      $('#meta_keywords').val(b.data('keywords-en')||'').trigger('input');
      $('#meta_description').val(b.data('description-en')||'').trigger('input');
      $('#meta_title_ar').val(b.data('title-ar')||'').trigger('input');
      $('#meta_keywords_ar').val(b.data('keywords-ar')||'').trigger('input');
      $('#meta_description_ar').val(b.data('description-ar')||'').trigger('input');
      $('#candidateMetaForm').attr('action',updateUrlTemplate.replace(':id',b.data('id')));
      setTimeout(()=>{const active=localStorage.getItem('candMetaTab')||'#pane-en';const btn=active==='#pane-ar'?'#tab-ar':'#tab-en';$(btn).tab('show')},10)
    });
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab',function(e){const target=$(e.target).attr('data-bs-target');localStorage.setItem('candMetaTab',target)});
    $('#slug').on('blur',function(){ $(this).val(sanitizeSlug($(this).val())) });
    $('#candidateMetaForm').on('submit',function(e){
      e.preventDefault();
      const url=$(this).attr('action');
      const payload={
        id:$('#cand_id').val(),
        slug:$('#slug').val(),
        meta_title:$('#meta_title').val(),
        meta_keywords:$('#meta_keywords').val(),
        meta_description:$('#meta_description').val(),
        meta_title_ar:$('#meta_title_ar').val(),
        meta_keywords_ar:$('#meta_keywords_ar').val(),
        meta_description_ar:$('#meta_description_ar').val(),
        _method:'PUT'
      };
      $.ajax({
        url:url,type:'POST',data:payload,
        success:function(res){
          const modalEl=document.getElementById('editCandidateMetaModal');
          const modal=bootstrap.Modal.getInstance(modalEl);
          if(res&&res.ok&&res.candidate&&currentRowSelector){
            const $row=$(currentRowSelector),cand=res.candidate;
            $row.find('.cell-slug').text(cand.slug||'');
            $row.find('.cell-title .val-en').text(cand.meta_title||'');
            $row.find('.cell-title .val-ar').text(cand.meta_title_ar||'');
            $row.find('.cell-keywords .val-en').text(cand.meta_keywords||'');
            $row.find('.cell-keywords .val-ar').text(cand.meta_keywords_ar||'');
            $row.find('.cell-description .val-en').text(cand.meta_description||'');
            $row.find('.cell-description .val-ar').text(cand.meta_description_ar||'');
            const $btn=$row.find('.edit-btn');
            $btn.data('slug',cand.slug||'');
            $btn.data('title-en',cand.meta_title||'');
            $btn.data('title-ar',cand.meta_title_ar||'');
            $btn.data('keywords-en',cand.meta_keywords||'');
            $btn.data('keywords-ar',cand.meta_keywords_ar||'');
            $btn.data('description-en',cand.meta_description||'');
            $btn.data('description-ar',cand.meta_description_ar||'');
            dt.row($row).invalidate().draw(false);
          }
          modal.hide();
          toastr.success(res.message||'Updated successfully.');
        },
        error:function(xhr){
          if(xhr.status===422&&xhr.responseJSON&&xhr.responseJSON.errors){Object.values(xhr.responseJSON.errors).flat().forEach(m=>toastr.error(m));return}
          const msg=(xhr.responseJSON&&xhr.responseJSON.message)?xhr.responseJSON.message:'Update failed. Please try again.';toastr.error(msg);
        }
      })
    })
  })
</script>
