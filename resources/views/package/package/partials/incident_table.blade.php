<style>
.incident-table-wrap{width:100%;overflow-x:auto;background:#fff;border-radius:0;box-shadow:0 10px 30px rgba(0,0,0,.08)}
.incident-table{width:100%;border-collapse:separate;border-spacing:0;table-layout:fixed;min-width:1100px}
.incident-table thead th,.incident-table tfoot th{padding:12px 14px;text-align:left;white-space:nowrap}
.incident-table thead th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-transform:uppercase;letter-spacing:.03em}
.incident-table tfoot th{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;text-transform:uppercase;letter-spacing:.03em}
.incident-table tbody td{padding:14px;border-bottom:1px solid #eef2f7;vertical-align:top;background:#fff;overflow:hidden}
.incident-table tbody tr:hover td{background:#f9fbff}
.nowrap{white-space:nowrap}
.kv{display:grid;grid-template-columns:160px 1fr;gap:8px 14px;align-items:start}
.k{font-size:11px;color:#6b7280;text-transform:uppercase;letter-spacing:.04em}
.v{font-size:13px;color:#111827;min-width:0}
.badge-pill{display:inline-flex;align-items:center;padding:4px 10px;border-radius:999px;background:#eef2ff;color:#1f3a8a;font-weight:600;font-size:11px}
.icon-btn{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border:1px solid #dbe4ff;border-radius:10px;background:#fff;color:#1d4ed8;transition:.18s}
.icon-btn:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(29,78,216,.15)}
.proof-empty{display:inline-block;padding:4px 8px;border-radius:8px;background:#f3f4f6;color:#6b7280;font-size:12px}
.count-chip{display:inline-flex;align-items:center;gap:8px}
.count-chip i{font-size:12px;opacity:.9}
.cell-head{display:flex;align-items:center;gap:8px;font-weight:700;color:#0f172a}
.cell-head i{opacity:.9}
.pad-compact .kv{grid-template-columns:140px 1fr}
.remark-box{display:block;width:100%;max-width:300px;white-space:normal;overflow-wrap:anywhere;word-break:break-word;line-height:1.35;font-size: 12px;}
.remark-box:empty{display:none}
.remark-box-short{display:block;width:100%;white-space:normal;overflow-wrap:anywhere;word-break:break-word;line-height:1.35}
#incidentProofModal .modal-content{border:0;border-radius:0;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.22)}
#incidentProofModal .modal-header{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:0;border-radius:0}
#incidentProofModal .btn-close{filter:invert(1) grayscale(1) brightness(200%)}
#incidentProofModal .modal-footer{background:linear-gradient(to right,#007bff,#00c6ff);border:0;border-radius:0}
#incidentFormModal .modal-content{border:0;border-radius:0;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.22)}
#incidentFormModal .modal-header{background:linear-gradient(to right,#007bff,#00c6ff);color:#fff;border:0;border-radius:0}
#incidentFormModal .btn-close{filter:invert(1) grayscale(1) brightness(200%)}
#incidentFormModal .modal-footer{background:linear-gradient(to right,#007bff,#00c6ff);border:0;border-radius:0}
.pagination .page-link{border-color:#b7c7ff;color:#3b82f6}
.pagination .page-link:hover{background:#3b82f6;color:#fff;border-color:#3b82f6}
.pagination .page-item.active .page-link{background:linear-gradient(to right,#007bff,#00c6ff);border-color:transparent}

.incident-table col.col-idx{width:64px}
.incident-table col.col-cand{width:340px}
.incident-table col.col-cust{width:290px}
.incident-table col.col-inc{width:520px}
.incident-table col.col-proof{width:120px}

@media (max-width:1200px){
  .kv{grid-template-columns:120px 1fr}
  .remark-box{max-width:420px}
  .incident-table{min-width:980px}
  .incident-table col.col-cand{width:320px}
  .incident-table col.col-cust{width:280px}
  .incident-table col.col-inc{width:480px}
}
@media (max-width:768px){
  .kv{grid-template-columns:1fr;gap:4px 0}
  .incident-table tbody td{padding:12px}
  .incident-table{min-width:840px}
  .remark-box{max-width:100%}
}
</style>

<style id="incidentPrintCss">
@page { size: A4; margin: 0 }
* { box-sizing: border-box }
.ipr-page{background:#eef3f9;padding:0;margin:0;font-family:Arial,Helvetica,sans-serif;-webkit-print-color-adjust:exact;print-color-adjust:exact}
.ipr-wrap{width:210mm;min-height:297mm;margin:0 auto;position:relative;background:#fff}
.ipr-header,.ipr-footer{position:absolute;left:0;right:0;height:110px}
.ipr-header{top:0}
.ipr-footer{bottom:0}
.ipr-header img,.ipr-footer img{width:100%;height:100%;object-fit:cover;display:block}
.ipr-content{padding:115px 10mm 115px}
.ipr-title{display:flex;justify-content:space-between;align-items:center;font-size:16px;margin:0 0 6px;font-weight:800;letter-spacing:.2px}
.ipr-title span{font-size:16px}
.ipr-table{width:100%;border-collapse:collapse;font-size:11px}
.ipr-table th,.ipr-table td{border:1px solid #555;padding:6px 8px;vertical-align:middle}
.ipr-caption{background:#e9edf5;font-weight:800;text-align:center}
.ipr-label{width:25%;font-weight:700}
.ipr-value{width:45%;text-align:center}
.ipr-label-ar{width:30%;text-align:right;direction:rtl}
.ipr-mt{margin-top:10px}
.ipr-grid{display:grid;grid-template-columns:1fr;gap:12px}
.ipr-signs td{height:56px;text-align:center;font-weight:700}
.ipr-signs small{display:block;font-weight:400;margin-top:4px}
@media print{body{margin:0;background:#fff}#incidentFormModal{display:none!important}}
</style>

@php
  use Carbon\Carbon;

  $server = $_SERVER['SERVER_NAME'] ?? parse_url(url('/'), PHP_URL_HOST);
  $sub    = explode('.', $server)[0] ?? '';
  $iprHeader = asset('assets/img/' . strtolower($sub) . '_header.jpg');
  $iprFooter = asset('assets/img/' . strtolower($sub) . '_footer.jpg');

  $fmt = function ($date, $pattern = 'j M Y') {
      if (!$date) return 'N/A';
      try {
          $dt = $date instanceof Carbon ? $date : Carbon::parse($date);
          return $dt->format($pattern);
      } catch (\Exception $e) {
          return 'N/A';
      }
  };
@endphp

<div class="incident-table-wrap">
  <table class="incident-table">
    <colgroup>
      <col class="col-idx">
      <col class="col-cand">
      <col class="col-cust">
      <col class="col-inc">
      <col class="col-proof">
    </colgroup>

    <thead>
      <tr>
        <th class="nowrap">#</th>
        <th>Candidate Information</th>
        <th>Customer Information</th>
        <th>Incident Information</th>
        <th class="nowrap">Proof</th>
      </tr>
    </thead>

    <tbody>
      @forelse($packages as $p)
        @php
          $rowNum       = ($packages->firstItem() ?? 1) + $loop->index;

          $salesId      = (int)($p->sales_name ?? 0);
          $salesUser    = collect($salesOfficers)->firstWhere('id',$salesId);
          $salesLabel   = trim(($salesUser->first_name ?? '').' '.($salesUser->last_name ?? ''));
          $salesDisplay = $salesLabel !== '' ? strtoupper($salesLabel) : (is_numeric($p->sales_name) ? 'NOT ASSIGNED' : strtoupper((string)$p->sales_name));

          $cn           = strtoupper((string)($p->CN_Number ?? ''));
          $cand         = strtoupper((string)($p->candidate_name ?? ''));
          $nat          = strtoupper((string)($p->nationality ?? ''));
          $pp           = strtoupper((string)($p->passport_no ?? ''));
          $partner      = strtoupper(\Illuminate\Support\Str::before((string)($p->foreign_partner ?? ''),' '));

          $cl           = strtoupper((string)($p->CL_Number ?? ''));
          $customer     = strtoupper((string)($p->sponsor_name ?? ''));
          $qid          = strtoupper((string)($p->eid_no ?? ''));

          $arrived      = $p->arrived_date ? $fmt($p->arrived_date) : 'N/A';
          $statusDate   = $p->updated_at ? $fmt($p->updated_at) : 'N/A';
          $incidentDate = $p->incident_date ? $fmt($p->incident_date) : 'N/A';
          $incidentType = strtoupper((string)($p->incident_type ?? ''));
          $remarksRaw   = trim((string)($p->remark ?? ''));
          $remarksView  = $remarksRaw !== '' ? strtoupper($remarksRaw) : 'N/A';

          $proofUrl = null;
          $raw = trim((string)($p->incident_proof_path ?? ''));
          if ($raw !== '') {
            if (\Illuminate\Support\Str::startsWith($raw, ['http://','https://'])) {
              $proofUrl = $raw;
            } else {
              $clean = $raw;
              if (\Illuminate\Support\Str::startsWith($clean, '/')) $clean = ltrim($clean, '/');
              if (\Illuminate\Support\Str::startsWith($clean, 'public/')) $clean = \Illuminate\Support\Str::after($clean, 'public/');
              if (\Illuminate\Support\Str::startsWith($clean, 'storage/')) $clean = \Illuminate\Support\Str::after($clean, 'storage/');
              $proofUrl = asset('storage/app/public/'.ltrim($clean,'/'));
            }
          }

          $formDate      = $fmt($p->incident_date ?? $p->created_at, 'j M Y');
          $formIncDate   = $fmt($p->incident_date, 'j M Y');
          $formRemarks   = $remarksRaw !== '' ? strtoupper($remarksRaw) : '-';
          $formCandidate = $cand !== '' ? $cand : '-';
          $formPassport  = $pp !== '' ? $pp : '-';
          $formNat       = $nat !== '' ? $nat : '-';
          $formAgent     = $partner !== '' ? $partner : '-';
          $formCL        = $cl !== '' ? $cl : '-';
          $formCustomer  = $customer !== '' ? $customer : '-';
          $formQid       = $qid !== '' ? $qid : '-';
          $formCn        = $cn !== '' ? $cn : '-';
          $formSales     = $salesDisplay !== '' ? $salesDisplay : '-';
          $formIncType   = $incidentType !== '' ? $incidentType : '-';
        @endphp

        <tr class="pad-compact">
          <td class="nowrap">
            <span class="count-chip"><i class="fas fa-hashtag"></i><strong>{{ $rowNum }}</strong></span>
          </td>

          <td>
            <div class="cell-head"><i class="fas fa-user"></i>{{ $cand !== '' ? $cand : 'N/A' }}</div>
            <div class="kv" style="margin-top:10px">
              <div class="k">CN Number</div><div class="v">{{ $cn !== '' ? $cn : 'N/A' }}</div>
              <div class="k">Sales Name</div><div class="v"><span class="badge-pill">{{ $salesDisplay }}</span></div>
              <div class="k">Status Date</div><div class="v">{{ $statusDate }}</div>
              <div class="k">Passport No</div><div class="v">{{ $pp !== '' ? $pp : 'N/A' }}</div>
              <div class="k">Nationality</div><div class="v">{{ $nat !== '' ? $nat : 'N/A' }}</div>
              <div class="k">Partner</div><div class="v">{{ $partner !== '' ? $partner : 'N/A' }}</div>
            </div>
          </td>

          <td>
            <div class="cell-head"><i class="fas fa-building"></i>{{ $customer !== '' ? $customer : 'N/A' }}</div>
            <div class="kv" style="margin-top:10px">
              <div class="k">CL Number</div><div class="v">{{ $cl !== '' ? $cl : 'N/A' }}</div>
              <div class="k">QID</div><div class="v">{{ $qid !== '' ? $qid : 'N/A' }}</div>
              <div class="k">Arrived Date</div><div class="v">{{ $arrived }}</div>
            </div>
          </td>

          <td>
            <div class="cell-head"><i class="fas fa-exclamation-triangle"></i>Incident</div>
            <div class="kv" style="margin-top:10px">
              <div class="k">Incident Date</div><div class="v">{{ $incidentDate }}</div>
              <div class="k">Incident Type</div><div class="v">{{ $incidentType !== '' ? $incidentType : 'N/A' }}</div>
              <div class="k">Remarks</div>
              <div class="v">
                @if($remarksRaw !== '')
                  <div class="remark-box">{{ strtoupper($remarksRaw) }}</div>
                @else
                  <span class="remark-box-short">N/A</span>
                @endif
              </div>
            </div>
          </td>

          <td class="nowrap" style="text-align:center">
            <div style="display:flex;justify-content:center;gap:6px">
              @if($proofUrl)
                <a href="javascript:void(0)" class="icon-btn" title="View Proof" onclick="openIncidentProof('{{ $proofUrl }}')">
                  <i class="fas fa-eye"></i>
                </a>
              @else
                <span class="proof-empty">N/A</span>
              @endif
              <a href="javascript:void(0)" class="icon-btn" title="Incident Report Form" onclick="openIncidentForm('incident-form-{{ $p->id }}')">
                <i class="fas fa-file-alt"></i>
              </a>
            </div>
          </td>
        </tr>

        <tr style="display:none">
          <td colspan="5">
            <div id="incident-form-{{ $p->id }}" class="incident-form-html">
              <div class="ipr-page">
                <div class="ipr-wrap">
                  <div class="ipr-header"><img src="{{ $iprHeader }}" alt=""></div>
                  <div class="ipr-footer"><img src="{{ $iprFooter }}" alt=""></div>
                  <div class="ipr-content">
                    <div class="ipr-title">
                      <span>INCIDENT REPORT FORM</span>
                      <span>استمارة تقرير الحادث</span>
                    </div>

                    <table class="ipr-table">
                      <tr>
                        <td class="ipr-label">Date</td>
                        <td class="ipr-value">{{ $formDate }}</td>
                        <td class="ipr-label-ar">التاريخ</td>
                      </tr>
                      <tr>
                        <td class="ipr-label">CN-NO.</td>
                        <td class="ipr-value">{{ $formCn }}</td>
                        <td class="ipr-label-ar">رقم الملف</td>
                      </tr>
                    </table>

                    <div class="ipr-grid ipr-mt">
                      <table class="ipr-table">
                        <tr><td class="ipr-caption" colspan="3">CANDIDATE NAME</td></tr>
                        <tr>
                          <td class="ipr-label">CANDIDATE NAME</td>
                          <td class="ipr-value" style="text-align:left">{{ $formCandidate }}</td>
                          <td class="ipr-label-ar">اسم العاملة</td>
                        </tr>
                        <tr>
                          <td class="ipr-label">PASSPORT NO.</td>
                          <td class="ipr-value">{{ $formPassport }}</td>
                          <td class="ipr-label-ar">رقم جواز السفر</td>
                        </tr>
                        <tr>
                          <td class="ipr-label">NATIONALITY</td>
                          <td class="ipr-value">{{ $formNat }}</td>
                          <td class="ipr-label-ar">الجنسية</td>
                        </tr>
                        <tr>
                          <td class="ipr-label">AGENT NAME</td>
                          <td class="ipr-value" style="text-align:left">{{ $formAgent }}</td>
                          <td class="ipr-label-ar">اسم الوكيل</td>
                        </tr>
                      </table>

                      <table class="ipr-table">
                        <tr><td class="ipr-caption" colspan="3">SPONSOR DETAILS - بيانات الكفيل</td></tr>
                        <tr>
                          <td class="ipr-label">CL-NO.</td>
                          <td class="ipr-value">{{ $formCL }}</td>
                          <td class="ipr-label-ar">رقم العقد</td>
                        </tr>
                        <tr>
                          <td class="ipr-label">SPONSOR NAME</td>
                          <td class="ipr-value" style="text-align:left">{{ $formCustomer }}</td>
                          <td class="ipr-label-ar">اسم الكفيل</td>
                        </tr>
                        <tr>
                          <td class="ipr-label">QID NO.</td>
                          <td class="ipr-value">{{ $formQid }}</td>
                          <td class="ipr-label-ar">الرقم الشخصي</td>
                        </tr>
                        <tr>
                          <td class="ipr-label">SALES OFFICER NAME</td>
                          <td class="ipr-value" style="text-align:left">{{ $formSales }}</td>
                          <td class="ipr-label-ar">اسم المبيعات</td>
                        </tr>
                      </table>
                    </div>

                    <table class="ipr-table ipr-mt">
                      <tr><td class="ipr-caption" colspan="3">INCIDENT DETAIL</td></tr>
                      <tr>
                        <td class="ipr-label">INCIDENT DATE</td>
                        <td class="ipr-value">{{ $formIncDate }}</td>
                        <td class="ipr-label-ar">تاريخ الحادث</td>
                      </tr>
                      <tr>
                        <td class="ipr-label">INCIDENT TYPE</td>
                        <td class="ipr-value">{{ $formIncType }}</td>
                        <td class="ipr-label-ar">نوع الحادث</td>
                      </tr>
                      <tr>
                        <td class="ipr-label">REMARKS</td>
                        <td class="ipr-value" colspan="2" style="text-align:left;height:60px">{{ $formRemarks }}</td>
                      </tr>
                    </table>

                    <table class="ipr-table ipr-mt ipr-signs">
                      <tr>
                        <td>COODINATOR SIGN<small>توقيع المنسق</small></td>
                        <td>SALES OFFICER SIGN<small>توقيع موظف المبيعات</small></td>
                        <td>OPERATIONS MANAGER SIGN<small>توقيع مدير الفرع</small></td>
                      </tr>
                      <tr>
                        <td></td><td></td><td></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>

      @empty
        <tr>
          <td colspan="5" style="text-align:center;color:#6b7280">No results found.</td>
        </tr>
      @endforelse
    </tbody>

    <tfoot>
      <tr>
        <th class="nowrap">#</th>
        <th>Candidate Information</th>
        <th>Customer Information</th>
        <th>Incident Information</th>
        <th class="nowrap">Proof</th>
      </tr>
    </tfoot>
  </table>
</div>

<nav aria-label="Page navigation" style="margin-top:10px">
  <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0">
    <span style="color:#6b7280">Showing {{ $packages->firstItem() }} to {{ $packages->lastItem() }} of {{ $packages->total() }} results</span>
    <ul class="pagination justify-content-center m-0">
      {{ $packages->appends(request()->except('page'))->links('vendor.pagination.bootstrap-4') }}
    </ul>
  </div>
</nav>

<div class="modal fade" id="incidentProofModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-file-alt me-2"></i> Incident Proof</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="incidentProofBody" style="min-height:70vh;display:flex;align-items:center;justify-content:center">
        <div style="color:#6b7280">Loading…</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="incidentFormModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-file-alt me-2"></i> Incident Report Form</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="incidentFormBody" style="min-height:70vh;display:flex;align-items:center;justify-content:center;background:#eef3f9">
        <div style="color:#6b7280">Loading…</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="printIncidentForm()">
          <i class="fas fa-print me-1"></i>Print
        </button>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  function hasBs(){return !!(window.bootstrap&&window.bootstrap.Modal)}
  function showModal(id){
    var el=document.getElementById(id);
    if(!el)return;
    if(hasBs()) new bootstrap.Modal(el).show();
    else{el.classList.add('show');el.style.display='block';el.removeAttribute('aria-hidden')}
  }

  window.openIncidentProof=function(url){
    var body=document.getElementById('incidentProofBody');
    body.innerHTML='<div style="color:#6b7280">Loading…</div>';
    var lower=String(url||'').toLowerCase();
    var isImg=/\.(png|jpg|jpeg|webp|gif)$/.test(lower);
    var isPdf=/\.pdf$/.test(lower);
    if(isImg){
      body.innerHTML='<img src="'+url+'" alt="Incident Proof" style="max-width:100%;max-height:70vh;display:block;margin:0 auto">';
    }else if(isPdf){
      body.innerHTML='<iframe src="'+url+'" title="Incident Proof" style="width:100%;height:70vh;border:0"></iframe>';
    }else{
      body.innerHTML='<div style="text-align:center"><p style="margin-bottom:10px">Preview not available.</p><a href="'+url+'" target="_blank" class="btn btn-outline-light btn-sm"><i class="fas fa-external-link-alt me-1"></i>Open</a></div>';
    }
    showModal('incidentProofModal');
  };

  window.openIncidentForm=function(id){
    var src=document.getElementById(id);
    var body=document.getElementById('incidentFormBody');
    if(!src||!body)return;
    body.innerHTML=src.innerHTML;
    showModal('incidentFormModal');
  };

  window.printIncidentForm=function(){
    var body=document.getElementById('incidentFormBody');
    if(!body)return;
    var content=body.innerHTML;
    if(!content.trim())return;
    var css=document.getElementById('incidentPrintCss');
    var cssText=css?css.innerHTML:'';
    var w=window.open('','_blank','width=900,height=1200');
    if(!w)return;
    w.document.open();
    w.document.write('<html><head><title>Incident Report</title><style>'+cssText+'</style></head><body>'+content+'</body></html>');
    w.document.close();
    w.focus();
    w.print();
  };
})();
</script>
