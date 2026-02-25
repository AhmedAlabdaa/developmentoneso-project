@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
body{background:linear-gradient(to right,#e0f7fa,#e1bee7);font-family:Arial,sans-serif}
.toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;gap:10px;flex-wrap:wrap}
.toolbar-right{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.input-clear{position:relative}
.input-clear .fa-times-circle{position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;color:#6c757d;display:none}
.btn-create{background:linear-gradient(45deg,#007bff,#00c6ff);color:#fff;font-size:.875rem;padding:.25rem .5rem;border-radius:.25rem;border:none}
.btn-export{background:linear-gradient(45deg,#28a745,#85e085);color:#fff;font-size:.875rem;padding:.25rem .5rem;border-radius:.25rem;border:none}
.dropdown-menu{min-width:320px;padding:.5rem}
.dropdown-menu .row+.row{margin-top:.5rem}
.table thead th,.table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-align:center;font-weight:normal}
#preloader{position:fixed;inset:0;background:rgba(255,255,255,.75);display:flex;flex-direction:column;justify-content:center;align-items:center;z-index:1050}
#preloader .spinner{width:54px;height:54px;border:6px solid rgba(0,0,0,.1);border-top-color:#007bff;border-radius:50%;animation:spin 1s linear infinite}
#preloader .text{margin-top:10px;color:#007bff;font-weight:700}
@keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
</style>

<main id="main" class="main">
  <section class="section">
    <div class="card flex-fill">
      <div class="card-body mt-2">

        <div class="toolbar">
          <div class="toolbar-left">
            <a href="https://tadbeeralebdaa.onesourceerp.com/govt-services" class="btn btn-outline-secondary btn-sm">
              <i class="fas fa-landmark"></i> Government Services
            </a>
          </div>

          <div class="toolbar-right">
            <div class="input-group input-clear" style="width:300px;">
              <input id="global_search" class="form-control" placeholder="Search CL / CN / Ref">
              <i class="fas fa-times-circle" id="clear_global_search"></i>
            </div>

            <div class="dropdown">
              <button class="btn btn-outline-primary btn-sm" data-bs-toggle="dropdown">
                Filters <i class="fas fa-filter"></i>
              </button>
              <div class="dropdown-menu">
                <div class="row">
                  <div class="col-6">
                    <input id="filter_cl" class="form-control form-control-sm" placeholder="CL Number">
                  </div>
                  <div class="col-6">
                    <input id="filter_agreement" class="form-control form-control-sm" placeholder="CN / Agreement No">
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <input id="filter_from_date" type="date" class="form-control form-control-sm">
                  </div>
                  <div class="col-6">
                    <input id="filter_to_date" type="date" class="form-control form-control-sm">
                  </div>
                </div>
                <div class="text-end mt-2">
                  <button type="button" id="btn_reset" class="btn btn-secondary btn-sm">Reset</button>
                  <button type="button" id="btn_apply" class="btn btn-primary btn-sm">Apply</button>
                </div>
              </div>
            </div>

            <a href="{{ route('crm.create') }}" class="btn btn-outline-info btn-sm">
              <i class="fas fa-user-plus"></i> Add Customer
            </a>

            <a href="{{ route('govt-transactions.create') }}" class="btn btn-create btn-sm">
              <i class="fas fa-plus"></i> Create New
            </a>

            <button type="button" id="btn_export" class="btn btn-export btn-sm">
              <i class="fas fa-file-excel"></i> Export
            </button>
          </div>
        </div>

        <div id="invoice_table" class="table-responsive"></div>

      </div>
    </div>
  </section>
</main>

@include('../layout.footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const routes={
  index:'{{ route("govt-transactions.index") }}',
  export:'{{ route("govt-transactions.export") }}'
};

let req=null;
let tmr=null;

function showPreloader(){
  if(!$('#preloader').length){
    $('body').append('<div id="preloader"><div class="spinner"></div><div class="text">Loading...</div></div>');
  }
}

function hidePreloader(){
  $('#preloader').remove();
}

function buildQuery(){
  const q=new URLSearchParams();
  const g=($('#global_search').val()||'').trim();
  const cl=($('#filter_cl').val()||'').trim();
  const ag=($('#filter_agreement').val()||'').trim();
  const f=$('#filter_from_date').val();
  const t=$('#filter_to_date').val();

  if(g) q.set('global_search', g);
  if(cl) q.set('CL_Number', cl);
  if(ag) q.set('agreement_no', ag);
  if(f) q.set('from_date', f);
  if(t) q.set('to_date', t);

  return q.toString();
}

function loadTable(url){
  const base=(url ? url.split('?')[0] : routes.index);
  const qs=buildQuery();
  const target=base + (qs ? ('?'+qs) : '');

  if(req) req.abort();
  showPreloader();

  req=$.ajax({
    url: target,
    method: 'GET',
    dataType: 'json',
    headers: {'X-Requested-With':'XMLHttpRequest'}
  })
  .done(res=>{
    const html=(res && res.html) ? res.html : '';
    $('#invoice_table').html(html || '<div class="p-3">No records found</div>');
  })
  .fail(xhr=>{
    if(xhr.statusText==='abort') return;
    $('#invoice_table').html('<div class="p-3">No records found</div>');
  })
  .always(()=>{
    hidePreloader();
    req=null;
  });
}

function debounceLoad(){
  clearTimeout(tmr);
  tmr=setTimeout(()=>loadTable(),250);
}

function exportUrl(){
  const qs=buildQuery();
  return routes.export + (qs ? ('?'+qs) : '');
}

function downloadBlob(blob, filename){
  const url=URL.createObjectURL(blob);
  const a=document.createElement('a');
  a.href=url;
  a.download=filename || 'govt-transactions.csv';
  document.body.appendChild(a);
  a.click();
  a.remove();
  URL.revokeObjectURL(url);
}

function getFilename(disposition){
  if(!disposition) return '';
  const m=/filename\*?=(?:UTF-8'')?["']?([^;"']+)["']?/i.exec(disposition);
  return m ? decodeURIComponent(m[1]) : '';
}

async function exportAjax(){
  const btn=document.getElementById('btn_export');
  btn.disabled=true;
  showPreloader();
  try{
    const res=await fetch(exportUrl(), {headers:{'X-Requested-With':'XMLHttpRequest'}});
    if(!res.ok) throw new Error('export_failed');
    const blob=await res.blob();
    const name=getFilename(res.headers.get('content-disposition'));
    downloadBlob(blob, name);
  }catch(e){
    alert('Export failed. Please try again.');
  }finally{
    hidePreloader();
    btn.disabled=false;
  }
}

$(function(){
  loadTable();

  $('#global_search').on('input', function(){
    const v=this.value.trim();
    v ? $('#clear_global_search').show() : $('#clear_global_search').hide();
    debounceLoad();
  });

  $('#clear_global_search').on('click', function(){
    $('#global_search').val('').focus();
    $(this).hide();
    loadTable();
  });

  $('#filter_cl,#filter_agreement,#filter_from_date,#filter_to_date').on('change', loadTable);
  $('#btn_apply').on('click', loadTable);

  $('#btn_reset').on('click', function(){
    $('#global_search,#filter_cl,#filter_agreement').val('');
    $('#filter_from_date,#filter_to_date').val('');
    $('#clear_global_search').hide();
    loadTable();
  });

  $(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    loadTable($(this).attr('href'));
  });

  $('#btn_export').on('click', function(){
    exportAjax();
  });
});
</script>
