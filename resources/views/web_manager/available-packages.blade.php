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
          <h5 class="card-title">Available Packages</h5>
        </div>

        <div class="table-responsive">
          <table id="packages-table" class="table table-striped table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>CN Number</th>
                <th>Candidate Name</th>
                <th>Passport No</th>
                <th>Slug</th>
                <th>Meta Title<br><span class="small-muted">(EN / AR)</span></th>
                <th>Meta Keywords<br><span class="small-muted">(EN / AR)</span></th>
                <th>Meta Description<br><span class="small-muted">(EN / AR)</span></th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($packages as $p)
                @php
                  $cand = $p->candidate ?? null;
                @endphp
                <tr id="pkg-row-{{ $p->id }}">
                  <td>{{ $loop->iteration }}</td>
                  <td class="cell-cn">{{ $cand->CN_Number ?? $p->CN_Number ?? '' }}</td>
                  <td class="cell-name">{{ $cand->candidate_name ?? $p->candidate_name ?? '' }}</td>
                  <td class="cell-passport">{{ $cand->passport_no ?? $p->passport_no ?? '' }}</td>
                  <td class="cell-slug">{{ $p->slug }}</td>

                  {{-- Titles EN/AR --}}
                  <td class="cell-title">
                    <div><span class="lang-chip">EN</span> <span class="val-en">{{ $p->meta_title }}</span></div>
                    <div class="mt-1"><span class="lang-chip ar">AR</span> <span class="val-ar">{{ $p->meta_title_ar }}</span></div>
                  </td>

                  {{-- Keywords EN/AR --}}
                  <td class="cell-keywords">
                    <div class="text-truncate"><span class="lang-chip">EN</span> <span class="val-en">{{ $p->meta_keywords }}</span></div>
                    <div class="text-truncate mt-1"><span class="lang-chip ar">AR</span> <span class="val-ar">{{ $p->meta_keywords_ar }}</span></div>
                  </td>

                  {{-- Descriptions EN/AR --}}
                  <td class="cell-description">
                    <div class="text-truncate"><span class="lang-chip">EN</span> <span class="val-en">{{ $p->meta_description }}</span></div>
                    <div class="text-truncate mt-1"><span class="lang-chip ar">AR</span> <span class="val-ar">{{ $p->meta_description_ar }}</span></div>
                  </td>

                  <td class="text-center">
                    <button
                      class="btn btn-info btn-sm edit-btn"
                      data-bs-toggle="modal"
                      data-bs-target="#editPackageMetaModal"
                      data-id="{{ $p->id }}"
                      data-row="#pkg-row-{{ $p->id }}"
                      data-cn="{{ $cand->CN_Number ?? $p->CN_Number ?? '' }}"
                      data-name="{{ $cand->candidate_name ?? $p->candidate_name ?? '' }}"
                      data-passport="{{ $cand->passport_no ?? $p->passport_no ?? '' }}"
                      data-slug="{{ e($p->slug) }}"
                      data-title-en="{{ e($p->meta_title) }}"
                      data-title-ar="{{ e($p->meta_title_ar) }}"
                      data-keywords-en="{{ e($p->meta_keywords) }}"
                      data-keywords-ar="{{ e($p->meta_keywords_ar) }}"
                      data-description-en="{{ e($p->meta_description) }}"
                      data-description-ar="{{ e($p->meta_description_ar) }}"
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

        {{-- Remove Laravel paginator when using DataTables client-side --}}
      </div>
    </div>
  </section>
</main>

{{-- Modal --}}
<div class="modal fade" id="editPackageMetaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form id="packageMetaForm">
      @csrf
      <input type="hidden" id="pkg_id">
      <input type="hidden" id="row_selector">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Package Meta</h5>
          <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="row gx-3">
            <div class="col-md-4 mb-3">
              <label class="form-label">CN Number</label>
              <input type="text" id="m_cn" class="form-control" readonly>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Candidate Name</label>
              <input type="text" id="m_name" class="form-control" readonly>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Passport No</label>
              <input type="text" id="m_passport" class="form-control" readonly>
            </div>

            <div class="col-md-6 mb-3">
              <label for="m_slug" class="form-label">Slug *</label>
              <input type="text" id="m_slug" name="slug" class="form-control" required>
              <div class="small-muted mt-1">Only lowercase letters, numbers, and hyphens are recommended.</div>
            </div>

            <div class="col-12">
              <ul class="nav nav-tabs mt-2" id="metaTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="tab-en" data-bs-toggle="tab" data-bs-target="#pane-en" type="button" role="tab" aria-controls="pane-en" aria-selected="true">
                    English
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="tab-ar" data-bs-toggle="tab" data-bs-target="#pane-ar" type="button" role="tab" aria-controls="pane-ar" aria-selected="false">
                    العربية
                  </button>
                </li>
              </ul>
              <div class="tab-content border border-top-0 p-3" id="metaTabsContent">
                {{-- English --}}
                <div class="tab-pane fade show active" id="pane-en" role="tabpanel" aria-labelledby="tab-en" tabindex="0">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="m_title_en" class="form-label">Meta Title (EN)</label>
                      <input type="text" id="m_title_en" name="meta_title" class="form-control" maxlength="60">
                      <div class="small-muted"><span id="cnt_title_en">0</span>/60</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="m_keywords_en" class="form-label">Meta Keywords (EN)</label>
                      <input type="text" id="m_keywords_en" name="meta_keywords" class="form-control" maxlength="255">
                      <div class="small-muted"><span id="cnt_keywords_en">0</span>/255 (comma-separated)</div>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="m_description_en" class="form-label">Meta Description (EN)</label>
                      <textarea id="m_description_en" name="meta_description" rows="3" class="form-control" maxlength="160"></textarea>
                      <div class="small-muted"><span id="cnt_description_en">0</span>/160</div>
                    </div>
                  </div>
                </div>

                {{-- Arabic --}}
                <div class="tab-pane fade" id="pane-ar" role="tabpanel" aria-labelledby="tab-ar" tabindex="0">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="m_title_ar" class="form-label">عنوان الميتا (AR)</label>
                      <input type="text" id="m_title_ar" name="meta_title_ar" class="form-control dir-rtl" maxlength="60">
                      <div class="small-muted text-end"><span id="cnt_title_ar">0</span>/60</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="m_keywords_ar" class="form-label">الكلمات المفتاحية (AR)</label>
                      <input type="text" id="m_keywords_ar" name="meta_keywords_ar" class="form-control dir-rtl" maxlength="255">
                      <div class="small-muted text-end"><span id="cnt_keywords_ar">0</span>/255</div>
                    </div>
                    <div class="col-12 mb-3">
                      <label for="m_description_ar" class="form-label">وصف الميتا (AR)</label>
                      <textarea id="m_description_ar" name="meta_description_ar" rows="3" class="form-control dir-rtl" maxlength="160"></textarea>
                      <div class="small-muted text-end"><span id="cnt_description_ar">0</span>/160</div>
                    </div>
                  </div>
                </div>
              </div> {{-- tab-content --}}
            </div>{{-- col-12 --}}
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

  const updateUrlTemplate = "{{ route('available-packages.update', ':id') }}";
  let dt;

  toastr.options = { closeButton:true, progressBar:true, newestOnTop:true, timeOut:2500, extendedTimeOut:1200, positionClass:"toast-top-right" };

  function countBind(id, counterId) {
    const $el = $(id), $cnt = $(counterId);
    const update = () => $cnt.text(($el.val() || '').length);
    $el.on('input', update); update();
  }

  function sanitizeSlug(v){
    // soft guidance: lowercase + replace spaces with hyphens + trim hyphens
    return (v||'').toString()
      .toLowerCase()
      .replace(/\s+/g,'-')
      .replace(/[^a-z0-9\-]/g,'-')
      .replace(/\-+/g,'-')
      .replace(/^\-+|\-+$/g,'');
  }

  $(function () {
    dt = $('#packages-table').DataTable({
      pageLength: 25,
      order: [[0, 'asc']]
    });

    // live counters
    countBind('#m_title_en','#cnt_title_en');
    countBind('#m_keywords_en','#cnt_keywords_en');
    countBind('#m_description_en','#cnt_description_en');
    countBind('#m_title_ar','#cnt_title_ar');
    countBind('#m_keywords_ar','#cnt_keywords_ar');
    countBind('#m_description_ar','#cnt_description_ar');

    // Preload modal with row data
    $('#editPackageMetaModal').on('show.bs.modal', function (e) {
      const b = $(e.relatedTarget);
      const id = b.data('id');

      $('#pkg_id').val(id);
      $('#row_selector').val('#pkg-row-' + id);
      $('#m_cn').val(b.data('cn') || '');
      $('#m_name').val(b.data('name') || '');
      $('#m_passport').val(b.data('passport') || '');

      $('#m_slug').val(b.data('slug') || '');
      $('#m_title_en').val(b.data('title-en') || '').trigger('input');
      $('#m_keywords_en').val(b.data('keywords-en') || '').trigger('input');
      $('#m_description_en').val(b.data('description-en') || '').trigger('input');

      $('#m_title_ar').val(b.data('title-ar') || '').trigger('input');
      $('#m_keywords_ar').val(b.data('keywords-ar') || '').trigger('input');
      $('#m_description_ar').val(b.data('description-ar') || '').trigger('input');

      $('#packageMetaForm').attr('action', updateUrlTemplate.replace(':id', id));
      // default to the last used tab (keeps UX comfy)
      setTimeout(() => {
        const active = localStorage.getItem('metaTab') || '#pane-en';
        const btn = active === '#pane-ar' ? '#tab-ar' : '#tab-en';
        $(btn).tab('show');
      }, 10);
    });

    // remember selected tab
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
      const target = $(e.target).attr('data-bs-target');
      localStorage.setItem('metaTab', target);
    });

    // Slug sanitation on blur
    $('#m_slug').on('blur', function(){
      $(this).val(sanitizeSlug($(this).val()));
    });

    // Submit (AJAX)
    $('#packageMetaForm').on('submit', function (e) {
      e.preventDefault();
      const url = $(this).attr('action');

      const payload = {
        slug: $('#m_slug').val(),
        meta_title: $('#m_title_en').val(),
        meta_keywords: $('#m_keywords_en').val(),
        meta_description: $('#m_description_en').val(),
        meta_title_ar: $('#m_title_ar').val(),
        meta_keywords_ar: $('#m_keywords_ar').val(),
        meta_description_ar: $('#m_description_ar').val(),
        _method: 'PUT'
      };

      $.ajax({
        url: url,
        type: 'POST',
        data: payload,
        success: function (res) {
          const modalEl = document.getElementById('editPackageMetaModal');
          const modal = bootstrap.Modal.getInstance(modalEl);

          if (res && res.ok && res.package) {
            const pkg = res.package;
            const rowSel = $('#row_selector').val();
            const $row = $(rowSel);

            // slug
            $row.find('.cell-slug').text(pkg.slug || '');

            // titles
            $row.find('.cell-title .val-en').text(pkg.meta_title || '');
            $row.find('.cell-title .val-ar').text(pkg.meta_title_ar || '');

            // keywords
            $row.find('.cell-keywords .val-en').text(pkg.meta_keywords || '');
            $row.find('.cell-keywords .val-ar').text(pkg.meta_keywords_ar || '');

            // descriptions
            $row.find('.cell-description .val-en').text(pkg.meta_description || '');
            $row.find('.cell-description .val-ar').text(pkg.meta_description_ar || '');

            // update the edit button data for future edits
            const $btn = $row.find('.edit-btn');
            $btn.data('slug', pkg.slug || '');
            $btn.data('title-en', pkg.meta_title || '');
            $btn.data('title-ar', pkg.meta_title_ar || '');
            $btn.data('keywords-en', pkg.meta_keywords || '');
            $btn.data('keywords-ar', pkg.meta_keywords_ar || '');
            $btn.data('description-en', pkg.meta_description || '');
            $btn.data('description-ar', pkg.meta_description_ar || '');

            dt.row($row).invalidate().draw(false);
          }

          modal.hide();
          toastr.success((res && res.message) ? res.message : 'Updated successfully.');
        },
        error: function (xhr) {
          if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
            Object.values(xhr.responseJSON.errors).flat().forEach(m => toastr.error(m));
            return;
          }
          const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Update failed. Please try again.';
          toastr.error(msg);
        }
      });
    });
  });
</script>
